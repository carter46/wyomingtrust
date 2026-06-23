<?php

require_once __DIR__ . '/../helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_json(['success' => false, 'message' => 'Method not allowed'], 405);
}

$userId = require_user_auth();

// CSRF protection for sensitive operations
require_csrf_token();

$payload = get_json_input();

$coinKey = sanitize_text($payload['coin_key'] ?? '');
$recipient = sanitize_text($payload['recipient'] ?? '');
$amount = isset($payload['amount']) ? (float) $payload['amount'] : 0.0;
$fee = isset($payload['fee']) ? (float) $payload['fee'] : 0.0;

if ($coinKey === '' || $amount <= 0) {
    send_json(['success' => false, 'message' => 'Invalid request payload'], 400);
}

// Validate recipient address format
if (!empty($recipient) && !validate_crypto_address($recipient, $coinKey)) {
    send_json(['success' => false, 'message' => 'Invalid recipient address format for selected cryptocurrency'], 400);
}

$total = $amount + max($fee, 0);

$db = getDatabase();
$db->beginTransaction();

try {
    $stmt = $db->prepare(
        'SELECT c.id AS coin_id, c.symbol, ua.balance
         FROM coins c
         LEFT JOIN user_assets ua ON ua.coin_id = c.id AND ua.user_id = :user
         WHERE c.coin_key = :coin_key
         LIMIT 1'
    );
    $stmt->execute([
        ':user' => $userId,
        ':coin_key' => $coinKey,
    ]);

    $coin = $stmt->fetch();

    if (!$coin) {
        $db->rollBack();
        send_json(['success' => false, 'message' => 'Asset not found'], 404);
    }

    $coinId = (int) $coin['coin_id'];
    $currentBalance = isset($coin['balance']) ? (float) $coin['balance'] : 0.0;

    if ($currentBalance < $total) {
        $db->rollBack();
        send_json(['success' => false, 'message' => 'Insufficient balance'], 400);
    }

    $newBalance = $currentBalance - $total;

    $update = $db->prepare('UPDATE user_assets SET balance = :balance, updated_at = CURRENT_TIMESTAMP WHERE user_id = :user AND coin_id = :coin');
    $update->execute([
        ':balance' => $newBalance,
        ':user' => $userId,
        ':coin' => $coinId,
    ]);

    if ($update->rowCount() === 0) {
        $insertAsset = $db->prepare('INSERT INTO user_assets (user_id, coin_id, balance) VALUES (:user, :coin, :balance)');
        $insertAsset->execute([
            ':user' => $userId,
            ':coin' => $coinId,
            ':balance' => $newBalance,
        ]);
    }

    // Create transaction record (using the transactions table structure from node spacedebugger)
    $insertTx = $db->prepare(
        'INSERT INTO transactions (user_id, coin_id, asset_symbol, amount, fee, recipient, status, type)
         VALUES (:user, :coin, :symbol, :amount, :fee, :recipient, :status, :type)'
    );
    $insertTx->execute([
        ':user' => $userId,
        ':coin' => $coinId,
        ':symbol' => $coin['symbol'] ?? strtoupper(substr($coinKey, 0, 3)),
        ':amount' => $amount,
        ':fee' => $fee,
        ':recipient' => $recipient,
        ':status' => 'completed',
        ':type' => 'send',
    ]);

    $db->commit();

    send_json([
        'success' => true,
        'message' => 'Transaction processed successfully',
        'balance' => $newBalance,
    ]);
} catch (Exception $exception) {
    $db->rollBack();
    error_log('Send transaction failed: ' . $exception->getMessage());
    send_json(['success' => false, 'message' => 'Failed to process transaction'], 500);
}
