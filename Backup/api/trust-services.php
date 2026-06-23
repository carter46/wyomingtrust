<?php

require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    send_json(['success' => false, 'message' => 'Method not allowed'], 405);
}

$db = getDatabase();

$forOnboarding = isset($_GET['for_onboarding']) && $_GET['for_onboarding'] === 'true';

$sql = 'SELECT id, service_key, service_name, description, price, is_free, is_active, created_at, updated_at
        FROM trust_services
        WHERE is_active = 1';

if ($forOnboarding) {
    $sql .= ' AND service_key IN ("revocable_living_trust", "irrevocable_trust")';
}

$sql .= ' ORDER BY service_name';

$stmt = $db->query($sql);
$services = $stmt->fetchAll();

// Normalize types for frontend correctness:
// MySQL often returns numeric columns as strings; in JS, "0" is truthy.
// This prevents onboarding/payment logic from incorrectly treating paid services as free.
foreach ($services as &$s) {
    $s['id'] = (int)($s['id'] ?? 0);
    $s['price'] = (float)($s['price'] ?? 0);
    $s['is_free'] = (int)($s['is_free'] ?? 0);     // 0/1
    $s['is_active'] = (int)($s['is_active'] ?? 0); // 0/1
}

send_json(['success' => true, 'services' => $services]);
