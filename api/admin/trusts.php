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

function format_trust_row(array $trust, bool $hasAssetTypesColumn): array {
    $trust['id'] = (int) ($trust['id'] ?? 0);
    $trust['price'] = (float) ($trust['price'] ?? 0);
    $trust['is_free'] = (int) ($trust['is_free'] ?? 0);
    $trust['is_active'] = (int) ($trust['is_active'] ?? 0);
    $trust['trust_type'] = $trust['service_key'] ?? '';
    $trust['trust_type_label'] = get_trust_type_options()[$trust['trust_type']] ?? $trust['service_name'] ?? '';
    $trust['is_crypto'] = is_crypto_trust_type($trust['trust_type']);
    if ($hasAssetTypesColumn) {
        $trust['asset_types'] = decode_asset_types($trust['asset_types'] ?? null);
    } else {
        $trust['asset_types'] = [];
    }
    unset($trust['asset_types_raw']);
    return $trust;
}

function handleListTrusts() {
    require_admin_auth();
    $db = getDatabase();
    $hasAssetTypes = trust_services_has_asset_types_column($db);

    $assetCol = $hasAssetTypes ? ', asset_types' : '';
    $stmt = $db->query(
        "SELECT id, service_key, service_name, description{$assetCol}, price, is_free, is_active, created_at, updated_at
         FROM trust_services
         ORDER BY service_name"
    );
    $trusts = array_map(function ($row) use ($hasAssetTypes) {
        return format_trust_row($row, $hasAssetTypes);
    }, $stmt->fetchAll());

    send_json([
        'success' => true,
        'trusts' => $trusts,
        'trust_type_options' => get_trust_type_options(),
        'suggested_asset_types' => get_suggested_asset_types(),
    ]);
}

function handleCreateTrust() {
    require_admin_auth();
    $payload = get_json_input();

    $trustType = sanitize_text($payload['trust_type'] ?? $payload['service_key'] ?? '');
    $serviceName = sanitize_text($payload['service_name'] ?? '');
    $description = sanitize_text($payload['description'] ?? '');
    $price = isset($payload['price']) ? (float) $payload['price'] : 0.0;
    $isFree = isset($payload['is_free']) ? (int) $payload['is_free'] : 0;
    $isActive = isset($payload['is_active']) ? (int) $payload['is_active'] : 1;
    $assetTypes = normalize_asset_types($payload['asset_types'] ?? []);

    if (!is_valid_trust_type_key($trustType)) {
        send_json(['success' => false, 'message' => 'Please select a valid trust type'], 400);
    }

    $typeOptions = get_trust_type_options();
    if ($serviceName === '') {
        $serviceName = $typeOptions[$trustType];
    }

    if (is_crypto_trust_type($trustType)) {
        $assetTypes = [];
    }

    $db = getDatabase();
    $hasAssetTypes = trust_services_has_asset_types_column($db);

    $exists = $db->prepare('SELECT COUNT(*) FROM trust_services WHERE service_key = :key');
    $exists->execute([':key' => $trustType]);
    if ((int) $exists->fetchColumn() > 0) {
        send_json(['success' => false, 'message' => 'This trust type is already configured. Edit the existing service instead.'], 409);
    }

    try {
        if ($hasAssetTypes) {
            $stmt = $db->prepare(
                'INSERT INTO trust_services (service_key, service_name, description, asset_types, price, is_free, is_active)
                 VALUES (:service_key, :service_name, :description, :asset_types, :price, :is_free, :is_active)'
            );
            $stmt->execute([
                ':service_key' => $trustType,
                ':service_name' => $serviceName,
                ':description' => $description,
                ':asset_types' => encode_asset_types_json($assetTypes),
                ':price' => $price,
                ':is_free' => $isFree,
                ':is_active' => $isActive,
            ]);
        } else {
            $stmt = $db->prepare(
                'INSERT INTO trust_services (service_key, service_name, description, price, is_free, is_active)
                 VALUES (:service_key, :service_name, :description, :price, :is_free, :is_active)'
            );
            $stmt->execute([
                ':service_key' => $trustType,
                ':service_name' => $serviceName,
                ':description' => $description,
                ':price' => $price,
                ':is_free' => $isFree,
                ':is_active' => $isActive,
            ]);
        }

        $trustId = (int) $db->lastInsertId();

        send_json([
            'success' => true,
            'message' => 'Trust service created successfully',
            'trust' => [
                'id' => $trustId,
                'service_key' => $trustType,
                'trust_type' => $trustType,
                'service_name' => $serviceName,
                'asset_types' => $assetTypes,
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
    $hasAssetTypes = trust_services_has_asset_types_column($db);

    $existing = $db->prepare('SELECT service_key FROM trust_services WHERE id = :id LIMIT 1');
    $existing->execute([':id' => $trustId]);
    $row = $existing->fetch();
    if (!$row) {
        send_json(['success' => false, 'message' => 'Trust service not found'], 404);
    }

    $trustType = $row['service_key'] ?? '';

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

    if ($hasAssetTypes && isset($payload['asset_types']) && !is_crypto_trust_type($trustType)) {
        $updates[] = 'asset_types = :asset_types';
        $params[':asset_types'] = encode_asset_types_json(normalize_asset_types($payload['asset_types']));
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
