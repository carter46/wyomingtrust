<?php

require_once __DIR__ . '/../helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    send_json(['success' => false, 'message' => 'Method not allowed'], 405);
}

$userId = require_user_auth();
$coinKey = sanitize_text($_GET['coin_key'] ?? '');
$trustId = isset($_GET['trust_id']) ? (int) $_GET['trust_id'] : 0;

if ($coinKey === '') {
    send_json(['success' => false, 'message' => 'coin_key is required'], 400);
}

$db = getDatabase();
$fee = 0.0;
$feeSource = 'none';

if (coins_has_liquidation_fee_column($db)) {
    $stmt = $db->prepare('SELECT liquidation_fee FROM coins WHERE coin_key = :coin_key LIMIT 1');
    $stmt->execute([':coin_key' => $coinKey]);
    $row = $stmt->fetch();
    if ($row && isset($row['liquidation_fee'])) {
        $coinFee = (float) $row['liquidation_fee'];
        if ($coinFee > 0) {
            $fee = $coinFee;
            $feeSource = 'coin';
        }
    }
}

if ($fee <= 0 && $trustId > 0 && trust_services_has_liquidation_fee_column($db)) {
    $stmt = $db->prepare(
        'SELECT ts.liquidation_fee, ts.service_key
         FROM user_trusts ut
         INNER JOIN trust_services ts ON ts.id = ut.trust_service_id
         WHERE ut.id = :id AND ut.user_id = :user_id
         LIMIT 1'
    );
    $stmt->execute([':id' => $trustId, ':user_id' => $userId]);
    $trust = $stmt->fetch();
    if ($trust && trust_allows_liquidation($trust['service_key'] ?? '')) {
        $trustFee = (float) ($trust['liquidation_fee'] ?? 0);
        if ($trustFee > 0) {
            $fee = $trustFee;
            $feeSource = 'trust';
        }
    }
}

send_json([
    'success' => true,
    'fee' => round($fee, 2),
    'has_fee' => $fee > 0,
    'fee_source' => $feeSource,
]);
