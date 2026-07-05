<?php

require_once __DIR__ . '/../helpers.php';

$method = get_request_method();

if ($method !== 'GET') {
    send_json(['success' => false, 'message' => 'Method not allowed'], 405);
}

$userId = require_user_auth();
$db = getDatabase();

$hasPm = false;
try {
    $stmt = $db->prepare(
        'SELECT COUNT(*)
         FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME = "user_trusts"
           AND COLUMN_NAME = "payment_method_id"'
    );
    $stmt->execute();
    $hasPm = ((int) $stmt->fetchColumn() > 0);
} catch (Exception $e) {
    $hasPm = false;
}

$sql = $hasPm
    ? 'SELECT ut.id AS trust_id, ut.status, ut.payment_status, ut.trust_data, ut.created_at, ut.updated_at,
              ts.service_key, ts.service_name, ts.price, ts.is_free,
              pm.method_type AS payment_method_type, pm.method_name AS payment_method_name
       FROM user_trusts ut
       INNER JOIN trust_services ts ON ts.id = ut.trust_service_id
       LEFT JOIN payment_methods pm ON pm.id = ut.payment_method_id
       WHERE ut.user_id = :user_id
       ORDER BY ut.created_at DESC'
    : 'SELECT ut.id AS trust_id, ut.status, ut.payment_status, ut.trust_data, ut.created_at, ut.updated_at,
              ts.service_key, ts.service_name, ts.price, ts.is_free,
              NULL AS payment_method_type, NULL AS payment_method_name
       FROM user_trusts ut
       INNER JOIN trust_services ts ON ts.id = ut.trust_service_id
       WHERE ut.user_id = :user_id
       ORDER BY ut.created_at DESC';

$stmt = $db->prepare($sql);
$stmt->execute([':user_id' => $userId]);
$rows = $stmt->fetchAll();

$payments = [];
foreach ($rows as $row) {
    $trustData = [];
    if (!empty($row['trust_data'])) {
        $trustData = json_decode($row['trust_data'], true) ?? [];
    }

    $paymentInfo = is_array($trustData['payment_info'] ?? null) ? $trustData['payment_info'] : [];
    $isFree = !empty($row['is_free']) || (float) $row['price'] <= 0;
    $amount = isset($paymentInfo['amount']) ? (float) $paymentInfo['amount'] : (float) $row['price'];

    $payments[] = [
        'trust_id' => (int) $row['trust_id'],
        'service_name' => $row['service_name'],
        'service_key' => $row['service_key'],
        'amount' => $amount,
        'is_free' => $isFree,
        'payment_status' => $row['payment_status'],
        'trust_status' => $row['status'],
        'payment_method_name' => $row['payment_method_name'],
        'payment_method_type' => $row['payment_method_type'],
        'payment_type' => $paymentInfo['type'] ?? ($isFree ? 'free' : 'paid'),
        'created_at' => $row['created_at'],
        'updated_at' => $row['updated_at'],
    ];
}

$lastPayment = null;
foreach ($payments as $payment) {
    if (!$payment['is_free']) {
        $lastPayment = $payment;
        break;
    }
}

send_json([
    'success' => true,
    'payments' => $payments,
    'last_payment' => $lastPayment,
]);
