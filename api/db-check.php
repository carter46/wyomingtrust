<?php
/**
 * Temporary database connectivity check.
 * Delete this file after verifying the connection.
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/config.php';

try {
    $db = getDatabase();
    $db->query('SELECT 1');
    $admins = 0;
    try {
        $admins = (int) $db->query('SELECT COUNT(*) FROM admins')->fetchColumn();
    } catch (Throwable $e) {
        echo json_encode([
            'success' => true,
            'connected' => true,
            'admins_table' => false,
            'message' => 'Connected, but admins table is missing or inaccessible.',
            'detail' => $e->getMessage(),
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'connected' => true,
        'admins_table' => true,
        'admin_count' => $admins,
        'message' => 'Database connection OK.',
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'connected' => false,
        'message' => 'Database connection failed.',
        'detail' => $e->getMessage(),
    ]);
}
