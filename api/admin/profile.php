<?php

require_once __DIR__ . '/../helpers.php';

$method = get_request_method();

switch ($method) {
    case 'GET':
        handleGetProfile();
        break;
    case 'POST':
        handleFileUpload();
        break;
    case 'PATCH':
        handleUpdateProfile();
        break;
    default:
        send_json(['success' => false, 'message' => 'Method not allowed'], 405);
}

function handleGetProfile() {
    require_admin_auth();
    $db = getDatabase();
    
    $adminId = $_SESSION['admin_id'];
    $stmt = $db->prepare('SELECT id, email, created_at FROM admins WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $adminId]);
    $admin = $stmt->fetch();
    
    if (!$admin) {
        send_json(['success' => false, 'message' => 'Admin not found'], 404);
    }
    
    // Get site settings for logo and favicon
    $settings = $db->query('SELECT logo, favicon FROM site_settings WHERE id = 1 LIMIT 1')->fetch();
    
    $admin['logo'] = $settings['logo'] ?? null;
    $admin['favicon'] = $settings['favicon'] ?? null;
    
    send_json(['success' => true, 'admin' => $admin]);
}

function handleUpdateProfile() {
    require_admin_auth();
    $payload = get_json_input();
    $db = getDatabase();
    $adminId = $_SESSION['admin_id'];
    
    $action = $payload['action'] ?? '';
    
    if ($action === 'change_password') {
        // Verify current password
        $stmt = $db->prepare('SELECT password FROM admins WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $adminId]);
        $admin = $stmt->fetch();
        
        if (!$admin || !password_verify($payload['current_password'] ?? '', $admin['password'])) {
            send_json(['success' => false, 'message' => 'Current password is incorrect'], 401);
        }
        
        // Update password
        $newPassword = password_hash($payload['new_password'], PASSWORD_DEFAULT);
        $updateStmt = $db->prepare('UPDATE admins SET password = :password WHERE id = :id');
        $updateStmt->execute([':password' => $newPassword, ':id' => $adminId]);
        
        send_json(['success' => true, 'message' => 'Password updated successfully']);
        
    } elseif ($action === 'change_email') {
        // Verify password
        $stmt = $db->prepare('SELECT password FROM admins WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $adminId]);
        $admin = $stmt->fetch();
        
        if (!$admin || !password_verify($payload['password'] ?? '', $admin['password'])) {
            send_json(['success' => false, 'message' => 'Password is incorrect'], 401);
        }
        
        $newEmail = sanitize_text($payload['new_email'] ?? '');
        if (!validate_email($newEmail)) {
            send_json(['success' => false, 'message' => 'Invalid email address'], 400);
        }
        
        // Check if email already exists
        $checkStmt = $db->prepare('SELECT id FROM admins WHERE email = :email AND id != :id LIMIT 1');
        $checkStmt->execute([':email' => $newEmail, ':id' => $adminId]);
        if ($checkStmt->fetch()) {
            send_json(['success' => false, 'message' => 'Email address already in use'], 400);
        }
        
        // Update email
        $updateStmt = $db->prepare('UPDATE admins SET email = :email WHERE id = :id');
        $updateStmt->execute([':email' => $newEmail, ':id' => $adminId]);
        
        // Update session
        $_SESSION['admin_email'] = $newEmail;
        
        send_json(['success' => true, 'message' => 'Email updated successfully']);
    } else {
        send_json(['success' => false, 'message' => 'Invalid action'], 400);
    }
}

function handleFileUpload() {
    require_admin_auth();
    $db = getDatabase();
    
    if (!isset($_FILES['logo']) && !isset($_FILES['favicon'])) {
        send_json(['success' => false, 'message' => 'No file uploaded'], 400);
    }
    
    $uploadDir = __DIR__ . '/../../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/svg+xml', 'image/x-icon'];
    $maxSize = 2 * 1024 * 1024; // 2MB for logo
    $maxFaviconSize = 500 * 1024; // 500KB for favicon
    
    if (isset($_FILES['logo'])) {
        $file = $_FILES['logo'];
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            send_json(['success' => false, 'message' => 'File upload error'], 400);
        }
        
        if (!in_array($file['type'], $allowedTypes)) {
            send_json(['success' => false, 'message' => 'Invalid file type. Allowed: PNG, JPG, SVG'], 400);
        }
        
        if ($file['size'] > $maxSize) {
            send_json(['success' => false, 'message' => 'File size exceeds 2MB limit'], 400);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'logo_' . time() . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            send_json(['success' => false, 'message' => 'Failed to save file'], 500);
        }
        
        $relativePath = 'uploads/' . $filename;
        
        // Update site_settings
        $updateStmt = $db->prepare('UPDATE site_settings SET logo = :logo WHERE id = 1');
        $updateStmt->execute([':logo' => $relativePath]);
        
        send_json(['success' => true, 'message' => 'Logo uploaded successfully', 'path' => $relativePath]);
        
    } elseif (isset($_FILES['favicon'])) {
        $file = $_FILES['favicon'];
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            send_json(['success' => false, 'message' => 'File upload error'], 400);
        }
        
        if (!in_array($file['type'], $allowedTypes)) {
            send_json(['success' => false, 'message' => 'Invalid file type. Allowed: PNG, ICO, SVG'], 400);
        }
        
        if ($file['size'] > $maxFaviconSize) {
            send_json(['success' => false, 'message' => 'File size exceeds 500KB limit'], 400);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'favicon_' . time() . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            send_json(['success' => false, 'message' => 'Failed to save file'], 500);
        }
        
        $relativePath = 'uploads/' . $filename;
        
        // Update site_settings - need to add favicon column if not exists
        try {
            // Check if column exists, if not add it
            $checkColumn = $db->query("SHOW COLUMNS FROM site_settings LIKE 'favicon'")->fetch();
            if (!$checkColumn) {
                $db->exec('ALTER TABLE site_settings ADD COLUMN favicon VARCHAR(255) DEFAULT NULL');
            }
            
            $updateStmt = $db->prepare('UPDATE site_settings SET favicon = :favicon WHERE id = 1');
            $updateStmt->execute([':favicon' => $relativePath]);
        } catch (Exception $e) {
            error_log('Error updating favicon: ' . $e->getMessage());
        }
        
        send_json(['success' => true, 'message' => 'Favicon uploaded successfully', 'path' => $relativePath]);
    }
}
