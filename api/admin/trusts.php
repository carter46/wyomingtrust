<?php

require_once __DIR__ . '/../helpers.php';

$method = get_request_method();

switch ($method) {
    case 'GET':
        handleListTrusts();
        break;
    case 'POST':
        handleCreateTrust();
        break;
    case 'PUT':
    case 'PATCH':
        handleUpdateTrust();
        break;
    case 'DELETE':
        handleDeleteTrust();
        break;
    default:
        send_json(['success' => false, 'message' => 'Method not allowed'], 405);
}

function handleListTrusts() {
    require_admin_auth();
    $db = getDatabase();
    
    $stmt = $db->query(
        'SELECT id, service_key, service_name, description, price, is_free, is_active, created_at, updated_at
         FROM trust_services
         ORDER BY service_name'
    );
    $trusts = $stmt->fetchAll();
    
    send_json(['success' => true, 'trusts' => $trusts]);
}

function handleCreateTrust() {
    require_admin_auth();
    $payload = get_json_input();
    $serviceKey = sanitize_text($payload['service_key'] ?? '');
    $serviceName = sanitize_text($payload['service_name'] ?? '');
    $description = sanitize_text($payload['description'] ?? '');
    $price = isset($payload['price']) ? (float) $payload['price'] : 0.0;
    $isFree = isset($payload['is_free']) ? (int) $payload['is_free'] : 0;
    $isActive = isset($payload['is_active']) ? (int) $payload['is_active'] : 1;
    
    if ($serviceKey === '' || $serviceName === '') {
        send_json(['success' => false, 'message' => 'Service key and name are required'], 400);
    }
    
    $db = getDatabase();
    
    // Check if service_key already exists
    $exists = $db->prepare('SELECT COUNT(*) FROM trust_services WHERE service_key = :key');
    $exists->execute([':key' => $serviceKey]);
    if ((int) $exists->fetchColumn() > 0) {
        send_json(['success' => false, 'message' => 'Service key already exists'], 409);
    }
    
    try {
        $stmt = $db->prepare(
            'INSERT INTO trust_services (service_key, service_name, description, price, is_free, is_active)
             VALUES (:service_key, :service_name, :description, :price, :is_free, :is_active)'
        );
        $stmt->execute([
            ':service_key' => $serviceKey,
            ':service_name' => $serviceName,
            ':description' => $description,
            ':price' => $price,
            ':is_free' => $isFree,
            ':is_active' => $isActive,
        ]);
        
        $trustId = (int) $db->lastInsertId();
        
        send_json([
            'success' => true,
            'message' => 'Trust service created successfully',
            'trust' => [
                'id' => $trustId,
                'service_key' => $serviceKey,
                'service_name' => $serviceName,
            ],
        ]);
    } catch (Exception $e) {
        error_log('Create trust failed: ' . $e->getMessage());
        send_json(['success' => false, 'message' => 'Failed to create trust service'], 500);
    }
}

function handleUpdateTrust() {
    require_admin_auth();
    $payload = get_json_input();
    $trustId = isset($payload['id']) ? (int) $payload['id'] : 0;
    
    if ($trustId <= 0) {
        send_json(['success' => false, 'message' => 'Invalid trust ID'], 400);
    }
    
    $db = getDatabase();
    
    $updates = [];
    $params = [':id' => $trustId];
    
    if (isset($payload['service_name'])) {
        $updates[] = 'service_name = :service_name';
        $params[':service_name'] = sanitize_text($payload['service_name']);
    }
    
    if (isset($payload['description'])) {
        $updates[] = 'description = :description';
        $params[':description'] = sanitize_text($payload['description']);
    }
    
    if (isset($payload['price'])) {
        $updates[] = 'price = :price';
        $params[':price'] = (float) $payload['price'];
    }
    
    if (isset($payload['is_free'])) {
        $updates[] = 'is_free = :is_free';
        $params[':is_free'] = (int) $payload['is_free'];
    }
    
    if (isset($payload['is_active'])) {
        $updates[] = 'is_active = :is_active';
        $params[':is_active'] = (int) $payload['is_active'];
    }
    
    if (empty($updates)) {
        send_json(['success' => false, 'message' => 'No valid fields to update'], 400);
    }
    
    try {
        $sql = 'UPDATE trust_services SET ' . implode(', ', $updates) . ' WHERE id = :id';
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
        send_json(['success' => true, 'message' => 'Trust service updated successfully']);
    } catch (Exception $e) {
        error_log('Update trust failed: ' . $e->getMessage());
        send_json(['success' => false, 'message' => 'Failed to update trust service'], 500);
    }
}

function handleDeleteTrust() {
    require_admin_auth();
    $trustId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    
    if ($trustId <= 0) {
        send_json(['success' => false, 'message' => 'Invalid trust ID'], 400);
    }
    
    $db = getDatabase();
    
    // Check if trust is in use
    $inUse = $db->prepare('SELECT COUNT(*) FROM user_trusts WHERE trust_service_id = :id');
    $inUse->execute([':id' => $trustId]);
    if ((int) $inUse->fetchColumn() > 0) {
        send_json(['success' => false, 'message' => 'Cannot delete trust service that is in use'], 400);
    }
    
    try {
        $stmt = $db->prepare('DELETE FROM trust_services WHERE id = :id');
        $stmt->execute([':id' => $trustId]);
        
        if ($stmt->rowCount() === 0) {
            send_json(['success' => false, 'message' => 'Trust service not found'], 404);
        }
        
        send_json(['success' => true, 'message' => 'Trust service deleted successfully']);
    } catch (Exception $e) {
        error_log('Delete trust failed: ' . $e->getMessage());
        send_json(['success' => false, 'message' => 'Failed to delete trust service'], 500);
    }
}
