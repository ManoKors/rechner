<?php
// stats.php: Aggregiert Logdaten für das Admin Dashboard
header('Content-Type: application/json');

$logFile = __DIR__ . '/requests.log';
if (!file_exists($logFile)) {
    echo json_encode(['error' => 'Logdatei nicht gefunden']);
    exit;
}

$lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$stats = [
    'total' => 0,
    'byDay' => [],
    'byType' => [
        'benzin' => 0,
        'diesel' => 0,
        'hybrid' => 0,
        'elektro' => 0
    ],
    'lastRequests' => []
];

foreach (array_reverse($lines) as $line) {
    $entry = json_decode($line, true);
    if (!$entry) continue;
    $stats['total']++;
    $date = substr($entry['time'], 0, 10);
    $stats['byDay'][$date] = ($stats['byDay'][$date] ?? 0) + 1;
    $type = $entry['input']['type'] ?? null;
    if ($type && isset($stats['byType'][$type])) {
        $stats['byType'][$type]++;
    }
    if (count($stats['lastRequests']) < 20) {
        $stats['lastRequests'][] = [
            'time' => $entry['time'],
            'type' => $type,
            'displacement' => $entry['input']['displacement'] ?? null,
            'co2_emission' => $entry['input']['co2_emission'] ?? null,
            'first_registration_year' => $entry['input']['first_registration_year'] ?? null,
            'weight' => $entry['input']['weight'] ?? null,
            'result' => $entry['result']['annual'] ?? null
        ];
    }
}

ksort($stats['byDay']);
echo json_encode($stats);
