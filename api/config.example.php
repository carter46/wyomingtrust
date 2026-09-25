<?php
/**
 * Wyoming Trust Platform - Configuration example.
 *
 * Copy this file to api/config.php and fill in real values.
 * api/config.php is gitignored so deploys do not wipe production settings.
 */

/**
 * @param string $key
 * @param mixed $default
 * @return mixed|null
 * @deprecated Configuration should be set directly in config.php
 */
function envValue($key, $default = null)
{
    return $default;
}

/**
 * @return PDO
 */
function getDatabase()
{
    static $db = null;

    if ($db instanceof PDO) {
        return $db;
    }

    if (!class_exists('PDO')) {
        throw new RuntimeException('PDO extension is not available on this server.');
    }

    $requiredDrivers = ['mysql'];
    $drivers = PDO::getAvailableDrivers();
    foreach ($requiredDrivers as $driver) {
        if (!is_array($drivers) || !in_array($driver, $drivers, true)) {
            throw new RuntimeException(sprintf('PDO %s driver is not enabled on this server.', $driver));
        }
    }

    // ====================================================================
    // DATABASE CONFIGURATION
    // ====================================================================
    $host = 'localhost';
    $port = '3306';
    $database = 'YOUR_DATABASE_NAME';
    $username = 'YOUR_DATABASE_USER';
    $password = 'YOUR_DATABASE_PASSWORD';
    $charset = 'utf8mb4';

    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        $host,
        $port,
        $database,
        $charset
    );

    try {
        $db = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 5,
        ]);

        return $db;
    } catch (PDOException $e) {
        error_log('[getDatabase] PDO Error: ' . $e->getMessage());
        throw new RuntimeException('Database connection failed: ' . $e->getMessage(), 0, $e);
    }
}

/**
 * @return string
 */
function getEncryptionKey()
{
    // Generate a secure key: openssl rand -hex 32
    $key = 'CHANGE_ME_TO_A_LONG_RANDOM_STRING_MIN_32_CHARS';

    if (strlen($key) < 32) {
        error_log('[SECURITY WARNING] Encryption key is too short! Must be at least 32 characters.');
        $key = 'default_encryption_key_change_in_production_min_32_chars';
    }

    return hash('sha256', $key, true);
}

/**
 * @return array
 */
function getSMTPConfig()
{
    $smtp_host = 'smtp.hostinger.com';
    $smtp_port = 465;
    $smtp_encryption = 'ssl';

    $smtp_username = 'YOUR_SMTP_USERNAME';
    $smtp_password = 'YOUR_SMTP_PASSWORD';

    $smtp_from_email = 'YOUR_FROM_EMAIL';
    $smtp_from_name = 'WyomingTrust';

    return [
        'host' => $smtp_host,
        'port' => $smtp_port,
        'username' => $smtp_username,
        'password' => $smtp_password,
        'encryption' => $smtp_encryption,
        'from_email' => $smtp_from_email,
        'from_name' => $smtp_from_name,
    ];
}

/**
 * @return string
 */
function getSiteUrl() {
    if (!empty($_SERVER['HTTP_HOST'])) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
                    (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ||
                    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
                    ? 'https' : 'http';

        $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';

        $port = $_SERVER['SERVER_PORT'] ?? null;
        if ($port && (($protocol === 'http' && $port != 80) || ($protocol === 'https' && $port != 443))) {
            $host .= ':' . $port;
        }

        return $protocol . '://' . $host;
    }

    return 'http://localhost';
}
