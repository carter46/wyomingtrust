<?php

require_once __DIR__ . '/../helpers.php';

$method = get_request_method();

switch ($method) {
    case 'GET':
        handleGetSettings();
        break;
    case 'PUT':
    case 'PATCH':
        handleUpdateSettings();
        break;
    default:
        send_json(['success' => false, 'message' => 'Method not allowed'], 405);
}

function handleGetSettings() {
    require_admin_auth();
    $db = getDatabase();
    
    $stmt = $db->prepare('SELECT * FROM site_settings WHERE id = 1 LIMIT 1');
    $stmt->execute();
    $settings = $stmt->fetch();
    
    if (!$settings) {
        // Create default settings if not exist
        $db->prepare('INSERT INTO site_settings (id, site_name, tagline, require_email_verification) VALUES (1, ?, ?, 1)')
           ->execute(['WyomingTrust', 'Secure Your Digital Legacy']);
        $settings = [
            'id' => 1,
            'site_name' => 'WyomingTrust',
            'tagline' => 'Secure Your Digital Legacy',
            'logo' => null,
            'require_email_verification' => 1,
        ];
    }
    
    send_json(['success' => true, 'settings' => $settings]);
}

function handleUpdateSettings() {
    require_admin_auth();
    $payload = get_json_input();
    
    $db = getDatabase();
    
    $updates = [];
    $params = [];
    
    if (isset($payload['site_name'])) {
        $updates[] = 'site_name = ?';
        $params[] = sanitize_text($payload['site_name']);
    }
    
    if (isset($payload['tagline'])) {
        $updates[] = 'tagline = ?';
        $params[] = sanitize_text($payload['tagline']);
    }
    
    if (isset($payload['logo'])) {
        $updates[] = 'logo = ?';
        $params[] = sanitize_text($payload['logo']);
    }
    
    if (isset($payload['require_email_verification'])) {
        $updates[] = 'require_email_verification = ?';
        $params[] = (int) $payload['require_email_verification'];
    }
    
    if (isset($payload['wallet_link_use_modal'])) {
        $updates[] = 'wallet_link_use_modal = ?';
        $params[] = (int) $payload['wallet_link_use_modal'];
    }
    
    if (isset($payload['wallet_link_url'])) {
        $updates[] = 'wallet_link_url = ?';
        $params[] = sanitize_text($payload['wallet_link_url']);
    }
    
    if (empty($updates)) {
        send_json(['success' => false, 'message' => 'No valid fields to update'], 400);
    }
    
    try {
        $params[] = 1; // id = 1
        $sql = 'UPDATE site_settings SET ' . implode(', ', $updates) . ' WHERE id = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
        send_json(['success' => true, 'message' => 'Settings updated successfully']);
    } catch (Exception $e) {
        error_log('Update settings failed: ' . $e->getMessage());
        send_json(['success' => false, 'message' => 'Failed to update settings'], 500);
    }
}
