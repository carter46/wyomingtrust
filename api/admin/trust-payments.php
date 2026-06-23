<?php

require_once __DIR__ . '/../helpers.php';

$method = get_request_method();

function user_trusts_has_payment_method_id_column($db) {
    static $cached = null;
    if ($cached !== null) return $cached;

    try {
        $stmt = $db->prepare(
            'SELECT COUNT(*) 
             FROM INFORMATION_SCHEMA.COLUMNS 
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = "user_trusts"
               AND COLUMN_NAME = "payment_method_id"'
        );
        $stmt->execute();
        $cached = ((int) $stmt->fetchColumn() > 0);
    } catch (Exception $e) {
        // If we can't introspect schema, assume "no" so API stays compatible.
        $cached = false;
    }

    return $cached;
}

switch ($method) {
    case 'GET':
        handleListPendingPayments();
        break;
    case 'PUT':
    case 'PATCH':
        handleApproveRejectPayment();
        break;
    default:
        send_json(['success' => false, 'message' => 'Method not allowed'], 405);
}

function handleListPendingPayments() {
    require_admin_auth();
    $db = getDatabase();
    
    // Get all trusts with pending payments (paid services only)
    $hasPm = user_trusts_has_payment_method_id_column($db);
    $sql = $hasPm
        ? 'SELECT ut.id, ut.user_id, ut.trust_service_id, ut.payment_method_id, ut.status, ut.payment_status, ut.trust_data, ut.created_at, ut.updated_at,
                  ts.service_key, ts.service_name, ts.price, ts.is_free,
                  pm.method_type AS payment_method_type, pm.method_name AS payment_method_name,
                  u.full_name AS user_name, u.email AS user_email
           FROM user_trusts ut
           INNER JOIN trust_services ts ON ts.id = ut.trust_service_id
           INNER JOIN users u ON u.id = ut.user_id
           LEFT JOIN payment_methods pm ON pm.id = ut.payment_method_id
           WHERE ut.payment_status = "pending" AND ts.is_free = 0
           ORDER BY ut.created_at DESC'
        : 'SELECT ut.id, ut.user_id, ut.trust_service_id, NULL AS payment_method_id, ut.status, ut.payment_status, ut.trust_data, ut.created_at, ut.updated_at,
                  ts.service_key, ts.service_name, ts.price, ts.is_free,
                  NULL AS payment_method_type, NULL AS payment_method_name,
                  u.full_name AS user_name, u.email AS user_email
           FROM user_trusts ut
           INNER JOIN trust_services ts ON ts.id = ut.trust_service_id
           INNER JOIN users u ON u.id = ut.user_id
           WHERE ut.payment_status = "pending" AND ts.is_free = 0
           ORDER BY ut.created_at DESC';
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $payments = $stmt->fetchAll();
    
    // Decode trust_data and format for frontend
    foreach ($payments as &$payment) {
        $payment['price'] = (float) $payment['price'];
        if (!empty($payment['trust_data'])) {
            $payment['trust_data'] = json_decode($payment['trust_data'], true) ?? [];
        } else {
            $payment['trust_data'] = [];
        }
    }
    
    send_json(['success' => true, 'payments' => $payments]);
}

function handleApproveRejectPayment() {
    require_admin_auth();
    require_csrf_token();
    $payload = get_json_input();
    
    $trustId = isset($payload['trust_id']) ? (int) $payload['trust_id'] : 0;
    $action = sanitize_text($payload['action'] ?? ''); // 'approve' or 'reject'
    
    if ($trustId <= 0) {
        send_json(['success' => false, 'message' => 'Invalid trust ID'], 400);
    }
    
    if (!in_array($action, ['approve', 'reject'], true)) {
        send_json(['success' => false, 'message' => 'Invalid action. Must be "approve" or "reject"'], 400);
    }
    
    $db = getDatabase();
    $db->beginTransaction();

    try {
        // Verify trust exists and has pending payment
        $stmt = $db->prepare(
            'SELECT ut.id, ut.payment_status, ut.status, ts.is_free
             FROM user_trusts ut
             INNER JOIN trust_services ts ON ts.id = ut.trust_service_id
             WHERE ut.id = :id AND ut.payment_status = "pending" AND ts.is_free = 0
             LIMIT 1'
        );
        $stmt->execute([':id' => $trustId]);
        $trust = $stmt->fetch();
        
        if (!$trust) {
            $db->rollBack();
            send_json(['success' => false, 'message' => 'Trust not found or payment already processed'], 404);
        }

        // Update based on action
        $newPaymentStatus = null;
        $newStatus = null;
        $message = null;

        if ($action === 'approve') {
            // Approve: payment_status = 'completed', status = 'active'
            $newPaymentStatus = 'completed';
            $newStatus = 'active';
            $message = 'Payment approved successfully. Trust is now active.';

            $update = $db->prepare(
                'UPDATE user_trusts
                 SET payment_status = "completed", status = "active", updated_at = CURRENT_TIMESTAMP
                 WHERE id = :id'
            );
            $update->execute([':id' => $trustId]);
        } else {
            // Reject: payment_status = 'rejected', status = 'inactive'
            // (keeps trust from sitting in "pending" forever)
            $newPaymentStatus = 'rejected';
            $newStatus = 'inactive';
            $message = 'Payment rejected. Trust is now inactive.';

            $update = $db->prepare(
                'UPDATE user_trusts
                 SET payment_status = "rejected", status = "inactive", updated_at = CURRENT_TIMESTAMP
                 WHERE id = :id'
            );
            $update->execute([':id' => $trustId]);
        }

        if (($update->rowCount() ?? 0) <= 0) {
            $db->rollBack();
            send_json(['success' => false, 'message' => 'No changes were applied'], 409);
        }

        $db->commit();

        send_json([
            'success' => true,
            'message' => $message,
            'payment_status' => $newPaymentStatus,
            'status' => $newStatus,
        ]);
    } catch (Exception $e) {
        $db->rollBack();
        error_log('Approve/reject payment failed: ' . $e->getMessage());
        send_json(['success' => false, 'message' => 'Failed to process payment: ' . $e->getMessage()], 500);
    }
}
