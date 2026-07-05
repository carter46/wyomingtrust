<?php

require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    send_json(['success' => false, 'message' => 'Method not allowed'], 405);
}

$db = getDatabase();
$hasAssetTypes = trust_services_has_asset_types_column($db);
$assetCol = $hasAssetTypes ? ', asset_types' : '';

$sql = "SELECT id, service_key, service_name, description{$assetCol}, price, is_free, is_active, created_at, updated_at
        FROM trust_services
        WHERE is_active = 1
        ORDER BY service_name";

$stmt = $db->query($sql);
$services = $stmt->fetchAll();

foreach ($services as &$s) {
    $s['id'] = (int) ($s['id'] ?? 0);
    $s['price'] = (float) ($s['price'] ?? 0);
    $s['is_free'] = (int) ($s['is_free'] ?? 0);
    $s['is_active'] = (int) ($s['is_active'] ?? 0);
    $s['trust_type'] = $s['service_key'] ?? '';
    $s['is_crypto'] = is_crypto_trust_type($s['trust_type']);
    $s['asset_types'] = $hasAssetTypes ? decode_asset_types($s['asset_types'] ?? null) : [];
}
unset($s);

send_json(['success' => true, 'services' => $services]);
