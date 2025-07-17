<?php
// Einfache Logging-API für Frontend-Anfragen
// Schreibt alle empfangenen Daten als JSON-Zeile in eine Logdatei (frontend-requests.log)

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = file_get_contents('php://input');
if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'No input']);
    exit;
}

$data = json_decode($input, true);
if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

$logData = [
    'timestamp' => date('c'),
    'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
    'source' => 'frontend',
    'data' => $data
];

$logLine = json_encode($logData, JSON_UNESCAPED_UNICODE) . "\n";
$logFile = __DIR__ . '/frontend-requests.log';

// Prüfe, ob das Verzeichnis beschreibbar ist
if (!is_writable(__DIR__)) {
    http_response_code(500);
    echo json_encode(['error' => 'Log-Verzeichnis nicht beschreibbar: ' . __DIR__]);
    exit;
}

// Versuche Logdatei anzulegen, falls sie nicht existiert
if (!file_exists($logFile)) {
    if (file_put_contents($logFile, "") === false) {
        http_response_code(500);
        echo json_encode(['error' => 'Logdatei konnte nicht angelegt werden: ' . $logFile, 'php_errormsg' => error_get_last()]);
        exit;
    }
}

// Schreibe Logzeile
if (file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX) === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Logdatei konnte nicht beschrieben werden: ' . $logFile, 'php_errormsg' => error_get_last()]);
    exit;
}

echo json_encode(['status' => 'ok']);
