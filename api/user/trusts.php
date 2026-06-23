<?php

require_once __DIR__ . '/../helpers.php';

$method = get_request_method();

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            handleGetUserTrust();
        } else {
            handleListUserTrusts();
        }
        break;
    case 'POST':
        handleCreateUserTrust();
        break;
    case 'PUT':
    case 'PATCH':
        handleUpdateUserTrust();
        break;
    case 'DELETE':
        handleDeleteUserTrust();
        break;
    default:
        send_json(['success' => false, 'message' => 'Method not allowed'], 405);
}

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

function normalize_beneficiaries($beneficiariesRaw) {
    if (!is_array($beneficiariesRaw)) {
        return [false, 'Beneficiaries must be an array', null];
    }

    if (count($beneficiariesRaw) === 0) {
        return [false, 'At least one beneficiary is required', null];
    }

    $beneficiaries = [];
    $total = 0.0;

    foreach ($beneficiariesRaw as $idx => $b) {
        if (!is_array($b)) {
            return [false, 'Invalid beneficiary at index ' . $idx, null];
        }

        $name = sanitize_text($b['name'] ?? '');
        $relationship = sanitize_text($b['relationship'] ?? '');
        $email = sanitize_text($b['email'] ?? '');
        $wallet = sanitize_text($b['wallet_address'] ?? '');
        $allocation = isset($b['allocation']) ? (float) $b['allocation'] : 0.0;
        $isMyself = !empty($b['is_myself']) ? 1 : 0;

        if ($name === '') {
            return [false, 'Beneficiary name is required (index ' . $idx . ')', null];
        }
        if ($relationship === '') {
            return [false, 'Beneficiary relationship is required (index ' . $idx . ')', null];
        }
        if ($email !== '' && !validate_email($email)) {
            return [false, 'Invalid beneficiary email (index ' . $idx . ')', null];
        }
        if ($allocation < 0 || $allocation > 100) {
            return [false, 'Allocation must be between 0 and 100 (index ' . $idx . ')', null];
        }

        $total += $allocation;

        $beneficiaries[] = [
            'name' => $name,
            'relationship' => $relationship,
            'email' => $email,
            'allocation' => $allocation,
            'wallet_address' => $wallet,
            'is_myself' => $isMyself === 1,
        ];
    }

    if (abs($total - 100.0) > 0.01) {
        return [false, 'Total allocation must equal 100%. Current total: ' . number_format($total, 2) . '%', null];
    }

    return [true, null, $beneficiaries];
}

function handleUpdateUserTrust() {
    $userId = require_user_auth();
    $payload = get_json_input();

    $trustId = isset($payload['id']) ? (int) $payload['id'] : 0;
    if ($trustId <= 0) {
        send_json(['success' => false, 'message' => 'Invalid trust ID'], 400);
    }

    $db = getDatabase();
    $stmt = $db->prepare('SELECT id, trust_data FROM user_trusts WHERE id = :id AND user_id = :user_id LIMIT 1');
    $stmt->execute([':id' => $trustId, ':user_id' => $userId]);
    $row = $stmt->fetch();
    if (!$row) {
        send_json(['success' => false, 'message' => 'Trust not found'], 404);
    }

    $trustData = [];
    if (!empty($row['trust_data'])) {
        $trustData = json_decode($row['trust_data'], true) ?? [];
    }

    $updatesMade = false;
    $statusUpdate = null;

    if (isset($payload['trust_name'])) {
        $trustName = sanitize_text($payload['trust_name']);
        if ($trustName === '') {
            send_json(['success' => false, 'message' => 'Trust name cannot be empty'], 400);
        }
        $trustData['trust_name'] = $trustName;
        $updatesMade = true;
    }

    if (isset($payload['beneficiaries'])) {
        [$ok, $err, $normalized] = normalize_beneficiaries($payload['beneficiaries']);
        if (!$ok) {
            send_json(['success' => false, 'message' => $err], 400);
        }
        $trustData['beneficiaries'] = $normalized;
        $updatesMade = true;
    }

    if (isset($payload['status'])) {
        $status = sanitize_text($payload['status']);
        $allowedStatuses = ['active', 'inactive', 'pending', 'suspended'];
        if (!in_array(strtolower($status), $allowedStatuses)) {
            send_json(['success' => false, 'message' => 'Invalid status. Allowed: ' . implode(', ', $allowedStatuses)], 400);
        }
        $statusUpdate = strtolower($status);
        $updatesMade = true;
    }

    if (!$updatesMade) {
        send_json(['success' => false, 'message' => 'No valid fields to update'], 400);
    }

    try {
        if ($statusUpdate !== null) {
            // Update status directly in database
            $up = $db->prepare('UPDATE user_trusts SET status = :status, trust_data = :trust_data WHERE id = :id AND user_id = :user_id');
            $up->execute([
                ':status' => $statusUpdate,
                ':trust_data' => json_encode($trustData),
                ':id' => $trustId,
                ':user_id' => $userId,
            ]);
        } else {
            // Only update trust_data
            $up = $db->prepare('UPDATE user_trusts SET trust_data = :trust_data WHERE id = :id AND user_id = :user_id');
            $up->execute([
                ':trust_data' => json_encode($trustData),
                ':id' => $trustId,
                ':user_id' => $userId,
            ]);
        }

        // Return updated trust
        $_GET['id'] = (string) $trustId;
        handleGetUserTrust();
    } catch (Exception $e) {
        error_log('Update user trust failed: ' . $e->getMessage());
        send_json(['success' => false, 'message' => 'Failed to update trust'], 500);
    }
}

function handleDeleteUserTrust() {
    $userId = require_user_auth();
    $trustId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    
    if ($trustId <= 0) {
        send_json(['success' => false, 'message' => 'Invalid trust ID'], 400);
    }
    
    $db = getDatabase();
    
    // Verify trust belongs to user
    $stmt = $db->prepare('SELECT id FROM user_trusts WHERE id = :id AND user_id = :user_id LIMIT 1');
    $stmt->execute([':id' => $trustId, ':user_id' => $userId]);
    $trust = $stmt->fetch();
    
    if (!$trust) {
        send_json(['success' => false, 'message' => 'Trust not found'], 404);
    }
    
    try {
        // Delete trust (CASCADE will handle related data if foreign keys are set up)
        $del = $db->prepare('DELETE FROM user_trusts WHERE id = :id AND user_id = :user_id');
        $del->execute([':id' => $trustId, ':user_id' => $userId]);
        
        send_json(['success' => true, 'message' => 'Trust deleted successfully']);
    } catch (Exception $e) {
        error_log('Delete user trust failed: ' . $e->getMessage());
        send_json(['success' => false, 'message' => 'Failed to delete trust'], 500);
    }
}

function handleGetUserTrust() {
    $userId = require_user_auth();
    $trustId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    if ($trustId <= 0) {
        send_json(['success' => false, 'message' => 'Invalid trust ID'], 400);
    }

    $db = getDatabase();
    $hasPm = user_trusts_has_payment_method_id_column($db);
    $sql = $hasPm
        ? 'SELECT ut.id, ut.user_id, ut.trust_service_id, ut.payment_method_id, ut.status, ut.payment_status, ut.trust_data, ut.created_at, ut.updated_at,
                  ts.service_key, ts.service_name, ts.price, ts.is_free,
                  pm.method_type AS payment_method_type, pm.method_name AS payment_method_name
           FROM user_trusts ut
           INNER JOIN trust_services ts ON ts.id = ut.trust_service_id
           LEFT JOIN payment_methods pm ON pm.id = ut.payment_method_id
           WHERE ut.user_id = :user_id AND ut.id = :id
           LIMIT 1'
        : 'SELECT ut.id, ut.user_id, ut.trust_service_id, NULL AS payment_method_id, ut.status, ut.payment_status, ut.trust_data, ut.created_at, ut.updated_at,
                  ts.service_key, ts.service_name, ts.price, ts.is_free,
                  NULL AS payment_method_type, NULL AS payment_method_name
           FROM user_trusts ut
           INNER JOIN trust_services ts ON ts.id = ut.trust_service_id
           WHERE ut.user_id = :user_id AND ut.id = :id
           LIMIT 1';
    $stmt = $db->prepare($sql);
    $stmt->execute([':user_id' => $userId, ':id' => $trustId]);
    $trust = $stmt->fetch();

    if (!$trust) {
        send_json(['success' => false, 'message' => 'Trust not found'], 404);
    }

    $trustData = [];
    if (!empty($trust['trust_data'])) {
        $trustData = json_decode($trust['trust_data'], true) ?? [];
    }
    $trust['trust_data'] = $trustData;

    // Back-compat fields expected by dashboard/user/manage-trust.php
    $trust['trust_name'] = $trustData['trust_name'] ?? null;
    $trust['trust_type'] = $trustData['trust_type'] ?? ($trust['service_key'] ?? null);
    $trust['beneficiaries'] = $trustData['beneficiaries'] ?? [];

    send_json(['success' => true, 'trust' => $trust]);
}

function handleListUserTrusts() {
    $userId = require_user_auth();
    $db = getDatabase();
    
    $hasPm = user_trusts_has_payment_method_id_column($db);
    $sql = $hasPm
        ? 'SELECT ut.id, ut.user_id, ut.trust_service_id, ut.payment_method_id, ut.status, ut.payment_status, ut.trust_data, ut.created_at, ut.updated_at,
                  ts.service_key, ts.service_name, ts.price, ts.is_free,
                  pm.method_type AS payment_method_type, pm.method_name AS payment_method_name
           FROM user_trusts ut
           INNER JOIN trust_services ts ON ts.id = ut.trust_service_id
           LEFT JOIN payment_methods pm ON pm.id = ut.payment_method_id
           WHERE ut.user_id = :user_id
           ORDER BY ut.created_at DESC'
        : 'SELECT ut.id, ut.user_id, ut.trust_service_id, NULL AS payment_method_id, ut.status, ut.payment_status, ut.trust_data, ut.created_at, ut.updated_at,
                  ts.service_key, ts.service_name, ts.price, ts.is_free,
                  NULL AS payment_method_type, NULL AS payment_method_name
           FROM user_trusts ut
           INNER JOIN trust_services ts ON ts.id = ut.trust_service_id
           WHERE ut.user_id = :user_id
           ORDER BY ut.created_at DESC';
    $stmt = $db->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
    $trusts = $stmt->fetchAll();
    
    // Decode JSON trust_data and add back-compat fields
    foreach ($trusts as &$trust) {
        if (!empty($trust['trust_data'])) {
            $trust['trust_data'] = json_decode($trust['trust_data'], true) ?? [];
        } else {
            $trust['trust_data'] = [];
        }
        
        // Add back-compat fields expected by dashboard/user/manage-trust.php and dashboard.php
        $trustData = $trust['trust_data'] ?? [];
        $trust['trust_name'] = $trustData['trust_name'] ?? null;
        $trust['trust_type'] = $trustData['trust_type'] ?? ($trust['service_key'] ?? null);
        $trust['beneficiaries'] = $trustData['beneficiaries'] ?? [];
    }
    
    send_json(['success' => true, 'trusts' => $trusts]);
}

function handleCreateUserTrust() {
    $userId = require_user_auth();
    $payload = get_json_input();
    
    $trustServiceId = isset($payload['trust_service_id']) ? (int) $payload['trust_service_id'] : 0;
    $paymentMethodId = isset($payload['payment_method_id']) ? (int) $payload['payment_method_id'] : 0;
    $trustData = isset($payload['trust_data']) ? $payload['trust_data'] : [];
    
    if ($trustServiceId <= 0) {
        send_json(['success' => false, 'message' => 'Valid trust service ID is required'], 400);
    }
    
    $db = getDatabase();
    
    // Verify trust service exists and is active
    $stmt = $db->prepare('SELECT id, price, is_free FROM trust_services WHERE id = :id AND is_active = 1 LIMIT 1');
    $stmt->execute([':id' => $trustServiceId]);
    $trustService = $stmt->fetch();
    
    if (!$trustService) {
        send_json(['success' => false, 'message' => 'Trust service not found or inactive'], 404);
    }

    // Validate beneficiaries data (must exist and total 100%)
    $beneficiariesRaw = is_array($trustData) ? ($trustData['beneficiaries'] ?? null) : null;
    [$okBen, $errBen, $normalizedBeneficiaries] = normalize_beneficiaries($beneficiariesRaw);
    if (!$okBen) {
        send_json(['success' => false, 'message' => $errBen], 400);
    }
    // Ensure stored data is normalized
    $trustData['beneficiaries'] = $normalizedBeneficiaries;
    
    try {
        $status = 'pending';
        $paymentStatus = 'pending';
        $resolvedPaymentMethodId = null;
        
        if ($trustService['is_free']) {
            $paymentStatus = 'completed';
            $status = 'active';
            $resolvedPaymentMethodId = null;
        } else {
            if ($paymentMethodId > 0) {
                // Validate payment method exists and is active
                $pm = $db->prepare('SELECT id FROM payment_methods WHERE id = :id AND is_active = 1 LIMIT 1');
                $pm->execute([':id' => $paymentMethodId]);
                if (!$pm->fetch()) {
                    send_json(['success' => false, 'message' => 'Invalid payment method'], 400);
                }
                $resolvedPaymentMethodId = $paymentMethodId;
            }
        }
        
        // Encode trust_data to JSON with error checking
        $trustDataJson = json_encode($trustData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($trustDataJson === false) {
            $jsonError = json_last_error_msg();
            error_log('JSON encode failed: ' . $jsonError);
            send_json(['success' => false, 'message' => 'Failed to encode trust data: ' . $jsonError], 500);
        }
        
        $hasPm = user_trusts_has_payment_method_id_column($db);
        if ($hasPm) {
            $stmt = $db->prepare(
                'INSERT INTO user_trusts (user_id, trust_service_id, payment_method_id, status, payment_status, trust_data)
                 VALUES (:user_id, :trust_service_id, :payment_method_id, :status, :payment_status, :trust_data)'
            );
            
            $stmt->execute([
                ':user_id' => $userId,
                ':trust_service_id' => $trustServiceId,
                ':payment_method_id' => $resolvedPaymentMethodId, // Can be null for free services
                ':status' => $status,
                ':payment_status' => $paymentStatus,
                ':trust_data' => $trustDataJson,
            ]);
        } else {
            // Backward-compatible insert for older DB schemas
            $stmt = $db->prepare(
                'INSERT INTO user_trusts (user_id, trust_service_id, status, payment_status, trust_data)
                 VALUES (:user_id, :trust_service_id, :status, :payment_status, :trust_data)'
            );
            $stmt->execute([
                ':user_id' => $userId,
                ':trust_service_id' => $trustServiceId,
                ':status' => $status,
                ':payment_status' => $paymentStatus,
                ':trust_data' => $trustDataJson,
            ]);
        }
        
        $trustId = (int) $db->lastInsertId();
        
        send_json([
            'success' => true,
            'message' => 'Trust created successfully',
            'trust' => [
                'id' => $trustId,
                'payment_method_id' => $resolvedPaymentMethodId,
                'status' => $status,
                'payment_status' => $paymentStatus,
            ],
        ]);
    } catch (Exception $e) {
        $errorMsg = $e->getMessage();
        $errorTrace = $e->getTraceAsString();
        error_log('Create user trust failed: ' . $errorMsg);
        error_log('Stack trace: ' . $errorTrace);
        
        // Return detailed error for debugging (in production, you might want to hide this)
        send_json([
            'success' => false, 
            'message' => 'Failed to create trust: ' . $errorMsg,
            'error_details' => $errorMsg
        ], 500);
    }
}
