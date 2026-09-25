<?php

require_once __DIR__ . '/../helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_json(['success' => false, 'message' => 'Method not allowed'], 405);
}

$payload = get_json_input();
$email = sanitize_text($payload['email'] ?? '');
$password = $payload['password'] ?? '';

if ($email === '' || $password === '') {
    send_json(['success' => false, 'message' => 'Email and password are required'], 400);
}

if (!validate_email($email)) {
    send_json(['success' => false, 'message' => 'Invalid email address'], 400);
}

try {
    $db = getDatabase();

    $stmt = $db->prepare('SELECT id, email, password FROM admins WHERE email = :email LIMIT 1');
    $stmt->execute([':email' => $email]);
    $admin = $stmt->fetch();

    if (!$admin || !password_verify($password, $admin['password'])) {
        send_json(['success' => false, 'message' => 'Invalid email or password'], 401);
    }

    // Set session
    $_SESSION['admin_id'] = (int) $admin['id'];
    $_SESSION['admin_email'] = $admin['email'];

    send_json([
        'success' => true,
        'message' => 'Login successful',
        'admin' => [
            'id' => (int) $admin['id'],
            'email' => $admin['email'],
        ],
    ]);
} catch (Throwable $e) {
    error_log('[admin/login] ' . $e->getMessage());
    $message = (stripos($e->getMessage(), 'Database connection failed') !== false)
        ? 'Database connection failed. Please verify api/config.php credentials on the server.'
        : 'Login failed due to a server error. Please try again.';
    send_json(['success' => false, 'message' => $message], 500);
}
