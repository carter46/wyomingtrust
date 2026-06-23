<?php

require_once __DIR__ . '/../helpers.php';

$method = get_request_method();

switch ($method) {
    case 'GET':
        handleListUserAssets();
        break;
    case 'POST':
        handleAdjustAsset();
        break;
    default:
        send_json(['success' => false, 'message' => 'Method not allowed'], 405);
}

function handleListUserAssets() {
    require_admin_auth();
    $userId = isset($_GET['user_id']) ? (int) $_GET['user_id'] : 0;
    if ($userId <= 0) {
        send_json(['success' => false, 'message' => 'User id is required'], 400);
    }

    $db = getDatabase();
    $stmt = $db->prepare(
        'SELECT ua.id, ua.balance, ua.coin_id, c.display_name, c.symbol, c.coin_key
         FROM user_assets ua
         INNER JOIN coins c ON c.id = ua.coin_id
         WHERE ua.user_id = :user
         ORDER BY c.display_name'
    );
    $stmt->execute([':user' => $userId]);
    $assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Convert DECIMAL to float for JSON
    foreach ($assets as &$asset) {
        $asset['balance'] = (float) $asset['balance'];
    }
    
    send_json(['success' => true, 'assets' => $assets]);
}

function handleAdjustAsset() {
    require_admin_auth();
    require_csrf_token();
    $payload = get_json_input();
    $userId = isset($payload['user_id']) ? (int) $payload['user_id'] : 0;
    $coinId = isset($payload['coin_id']) ? (int) $payload['coin_id'] : 0;
    $type = sanitize_text($payload['type'] ?? '');
    $amount = isset($payload['amount']) ? (float) $payload['amount'] : 0.0;

    if ($userId <= 0 || $coinId <= 0 || $amount <= 0) {
        send_json(['success' => false, 'message' => 'Invalid data provided'], 400);
    }

    if (!in_array($type, ['credit', 'debit'], true)) {
        send_json(['success' => false, 'message' => 'Invalid transaction type'], 400);
    }

    $db = getDatabase();
    $db->beginTransaction();
    try {
        $stmt = $db->prepare('SELECT balance FROM user_assets WHERE user_id = :user AND coin_id = :coin LIMIT 1');
        $stmt->execute([
            ':user' => $userId,
            ':coin' => $coinId,
        ]);
        $asset = $stmt->fetch();

        if (!$asset) {
            // Create asset record if it doesn't exist
            $insert = $db->prepare('INSERT INTO user_assets (user_id, coin_id, balance) VALUES (:user, :coin, 0)');
            $insert->execute([':user' => $userId, ':coin' => $coinId]);
            $currentBalance = 0.0;
        } else {
            $currentBalance = (float) $asset['balance'];
        }

        $newBalance = $type === 'credit' ? $currentBalance + $amount : $currentBalance - $amount;
        if ($newBalance < 0) {
            $db->rollBack();
            send_json(['success' => false, 'message' => 'Insufficient balance for debit'], 400);
        }

        $update = $db->prepare('UPDATE user_assets SET balance = :balance, updated_at = CURRENT_TIMESTAMP WHERE user_id = :user AND coin_id = :coin');
        $update->execute([
            ':balance' => $newBalance,
            ':user' => $userId,
            ':coin' => $coinId,
        ]);
        
        // Create transaction record for admin adjustment
        $coinStmt = $db->prepare('SELECT symbol FROM coins WHERE id = :coin_id LIMIT 1');
        $coinStmt->execute([':coin_id' => $coinId]);
        $coin = $coinStmt->fetch();
        
        $insertTx = $db->prepare(
            'INSERT INTO transactions (user_id, coin_id, asset_symbol, amount, fee, recipient, status, type, metadata)
             VALUES (:user, :coin, :symbol, :amount, 0, NULL, :status, :type, :metadata)'
        );
        $insertTx->execute([
            ':user' => $userId,
            ':coin' => $coinId,
            ':symbol' => $coin['symbol'] ?? 'CRYPTO',
            ':amount' => $amount,
            ':status' => 'completed',
            ':type' => $type === 'credit' ? 'admin_credit' : 'admin_debit',
            ':metadata' => json_encode(['admin_adjusted' => true, 'previous_balance' => $currentBalance, 'new_balance' => $newBalance]),
        ]);

        $db->commit();
    } catch (Exception $exception) {
        $db->rollBack();
        error_log('Admin asset adjustment failed: ' . $exception->getMessage());
        send_json(['success' => false, 'message' => 'Failed to update balance'], 500);
    }

    send_json(['success' => true, 'message' => 'Balance updated', 'balance' => $newBalance]);
}
