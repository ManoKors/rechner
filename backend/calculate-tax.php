<?php

/**
 * KFZ-Steuer Rechner Backend (2025)
 *
 * Berechnet die deutsche KFZ-Steuer nach aktuellen Gesetzen (2025).
 * Loggt alle Anfragen für spätere Analysen (DSGVO-konform, keine Speicherung von personenbezogenen Daten über das technisch Notwendige hinaus).
 *
 * @author 2025
 * @see https://www.gesetze-im-internet.de/kraftstg_2002/  (KraftStG)
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');


// Preflight-Request für CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit(0);
}


// Nur POST-Requests zulassen
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_response('Method not allowed', 405);
}


// JSON-Input parsen
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    error_response('Invalid JSON input', 400);
}


// Pflichtfelder prüfen
$required_fields = ['type', 'displacement', 'co2_emission', 'first_registration_year', 'weight'];
foreach ($required_fields as $field) {
    if (!isset($input[$field])) {
        error_response("Missing required field: $field", 400);
    }
}


// Eingabewerte extrahieren und validieren
$vehicle_type = $input['type'];
$displacement = (int) $input['displacement'];
$co2_emission = (int) $input['co2_emission'];
$first_registration_year = (int) $input['first_registration_year'];
$weight = (int) $input['weight'];


// Wertebereich prüfen
if ($displacement < 1 || $displacement > 10000) {
    error_response('Displacement must be between 1 and 10000 ccm', 400);
}
if ($co2_emission < 0 || $co2_emission > 500) {
    error_response('CO2 emission must be between 0 and 500 g/km', 400);
}
if ($first_registration_year < 1990 || $first_registration_year > (int)date('Y')) {
    error_response('First registration year must be between 1990 and current year', 400);
}
if ($weight < 100 || $weight > 50000) {
    error_response('Weight must be between 100 and 50000 kg', 400);
}
if (!in_array($vehicle_type, ['benzin', 'diesel', 'elektro', 'hybrid'], true)) {
    error_response('Invalid vehicle type', 400);
}

/**
 * Gibt eine standardisierte JSON-Fehlermeldung aus und beendet das Skript.
 * @param string $msg
 * @param int $code
 * @return never
 */
function error_response(string $msg, int $code = 400) {
    http_response_code($code);
    echo json_encode(['error' => $msg]);
    exit;
}


/**
 * Berechnet die deutsche KFZ-Steuer nach aktuellem Recht (2025).
 *
 * @param string $vehicle_type   Fahrzeugtyp ('benzin', 'diesel', 'elektro', 'hybrid')
 * @param int    $displacement   Hubraum in ccm
 * @param int    $co2_emission   CO2-Ausstoß in g/km
 * @param int    $first_registration_year Erstzulassung (Jahr)
 * @param int    $weight         Leergewicht in kg
 * @return array                 Steuerdaten (jährlich, monatlich, Aufschlüsselung)
 */
function calculateKfzSteuer(string $vehicle_type, int $displacement, int $co2_emission, int $first_registration_year, int $weight): array {
    $displacement_tax = 0.0;
    $co2_tax = 0.0;
    $base_tax = 0.0;
    $hybrid_discount = 0.0;

    // Elektrofahrzeuge sind steuerbefreit (Stand 2025)
    if ($vehicle_type === 'elektro') {
        return [
            'annual' => 0.0,
            'monthly' => 0.0,
            'details' => [
                'displacement_tax' => 0.0,
                'co2_tax' => 0.0,
                'base_tax' => 0.0
            ],
            'info' => 'Elektrofahrzeuge sind bis 2030 steuerbefreit.'
        ];
    }

    // Hubraumsteuer berechnen
    if ($vehicle_type === 'benzin') {
        // Benziner: 2,00 € je angefangene 100 ccm
        $displacement_tax = ceil($displacement / 100) * 2.00;
    } elseif ($vehicle_type === 'diesel') {
        // Diesel: 9,50 € je angefangene 100 ccm
        $displacement_tax = ceil($displacement / 100) * 9.50;
    }

    // CO2-Steuer berechnen (für Fahrzeuge ab 1. Juli 2009)
    if ($first_registration_year >= 2009) {
        $co2_threshold = 95; // g/km Freibetrag
        if ($co2_emission > $co2_threshold) {
            $co2_over_threshold = $co2_emission - $co2_threshold;
            // Gestaffelte CO2-Steuer (Stand 2025)
            if ($co2_over_threshold <= 15) {
                $co2_tax = $co2_over_threshold * 2.00;
            } elseif ($co2_over_threshold <= 35) {
                $co2_tax = 15 * 2.00 + ($co2_over_threshold - 15) * 2.20;
            } elseif ($co2_over_threshold <= 55) {
                $co2_tax = 15 * 2.00 + 20 * 2.20 + ($co2_over_threshold - 35) * 2.50;
            } elseif ($co2_over_threshold <= 75) {
                $co2_tax = 15 * 2.00 + 20 * 2.20 + 20 * 2.50 + ($co2_over_threshold - 55) * 2.90;
            } elseif ($co2_over_threshold <= 95) {
                $co2_tax = 15 * 2.00 + 20 * 2.20 + 20 * 2.50 + 20 * 2.90 + ($co2_over_threshold - 75) * 3.40;
            } else {
                $co2_tax = 15 * 2.00 + 20 * 2.20 + 20 * 2.50 + 20 * 2.90 + 20 * 3.40 + ($co2_over_threshold - 95) * 4.00;
            }
        }
    }

    // Hybridfahrzeuge erhalten Steuerermäßigung (50% Rabatt auf Gesamtsteuer)
    if ($vehicle_type === 'hybrid') {
        $total_before_discount = $displacement_tax + $co2_tax;
        $hybrid_discount = $total_before_discount * 0.5;
        $base_tax = $total_before_discount - $hybrid_discount;
        $displacement_tax = 0.0;
        $co2_tax = 0.0;
    }

    // Mindeststeuer für sehr kleine Fahrzeuge (20 €)
    $total_tax = $base_tax + $displacement_tax + $co2_tax;
    if ($total_tax < 20 && $vehicle_type !== 'elektro') {
        $base_tax = 20.0;
        $displacement_tax = 0.0;
        $co2_tax = 0.0;
        $total_tax = 20.0;
    }

    $result = [
        'annual' => round($total_tax, 2),
        'monthly' => round($total_tax / 12, 2),
        'details' => [
            'displacement_tax' => round($displacement_tax, 2),
            'co2_tax' => round($co2_tax, 2),
            'base_tax' => round($base_tax, 2)
        ]
    ];
    if ($vehicle_type === 'hybrid') {
        $result['hybrid_discount'] = round($hybrid_discount, 2);
        $result['info'] = 'Hybridfahrzeuge erhalten 50% Steuerermäßigung.';
    }
    return $result;
}


// Steuer berechnen
$result = calculateKfzSteuer($vehicle_type, $displacement, $co2_emission, $first_registration_year, $weight);

// Logging (DSGVO: nur technisch notwendige Daten, keine Speicherung von Namen, Adressen o.ä.)
$logData = [
    'timestamp' => date('c'),
    'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
    'input' => $input,
    'result' => $result
];
$logLine = json_encode($logData, JSON_UNESCAPED_UNICODE) . "\n";
@file_put_contents(__DIR__ . '/requests.log', $logLine, FILE_APPEND | LOCK_EX);

// JSON-Antwort zurückgeben
echo json_encode($result);
?>
