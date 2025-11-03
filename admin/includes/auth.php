<?php
/**
 * Authentication and Session Management
 * Handles login verification, session security, and CSRF protection
 */

session_start();

require_once '../config/database.php';
 
// Session timeout (30 minutes)
define('SESSION_TIMEOUT', 1800);

// Regenerate session ID periodically
if (!isset($_SESSION['last_regenerate'])) {
    $_SESSION['last_regenerate'] = time();
} elseif (time() - $_SESSION['last_regenerate'] > 300) { // Every 5 minutes
    session_regenerate_id(true);
    $_SESSION['last_regenerate'] = time();
}

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Check session timeout
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
    // Session expired
    session_unset();
    session_destroy();
    header('Location: login.php?timeout=1');
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Verify session IP address (optional security measure)
if (!isset($_SESSION['user_ip'])) {
    $_SESSION['user_ip'] = getClientIP();
} elseif ($_SESSION['user_ip'] !== getClientIP()) {
    // IP address changed - potential session hijacking
    session_unset();
    session_destroy();
    header('Location: login.php?security=1');
    exit();
}

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Verify CSRF token
 * @param string $token Token to verify
 * @return bool
 */
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Check if user has permission
 * @param string $permission Required permission
 * @return bool
 */
function hasPermission($permission) {
    $role = $_SESSION['admin_role'] ?? 'viewer';
    
    $permissions = [
        'admin' => ['*'], // All permissions
        'editor' => ['view', 'create', 'edit', 'analytics'],
        'viewer' => ['view', 'analytics']
    ];
    
    if (!isset($permissions[$role])) {
        return false;
    }
    
    return in_array('*', $permissions[$role]) || in_array($permission, $permissions[$role]);
}

/**
 * Require specific permission
 * @param string $permission Required permission
 */
function requirePermission($permission) {
    if (!hasPermission($permission)) {
        http_response_code(403);
        die('Access denied. Insufficient permissions.');
    }
}

/**
 * Get client IP address
 * @return string
 */
function getClientIP() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }
    
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
}

/**
 * Log admin activity
 * @param int $userId User ID
 * @param string $action Action type
 * @param string $description Action description
 * @param array|null $metadata Additional metadata
 */
function logActivity($userId, $action, $description, $metadata = null) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO activity_log 
            (user_id, action, description, ip_address, user_agent, metadata, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->execute([
            $userId,
            $action,
            $description,
            getClientIP(),
            $_SERVER['HTTP_USER_AGENT'] ?? '',
            $metadata ? json_encode($metadata) : null
        ]);
    } catch (PDOException $e) {
        error_log("Failed to log activity: " . $e->getMessage());
    }
}

/**
 * Sanitize input data
 * @param mixed $data Data to sanitize
 * @return mixed
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email address
 * @param string $email Email to validate
 * @return bool
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate URL
 * @param string $url URL to validate
 * @return bool
 */
function isValidUrl($url) {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

/**
 * Generate secure random token
 * @param int $length Token length
 * @return string
 */
function generateSecureToken($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Hash password securely
 * @param string $password Plain text password
 * @return string
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * Verify password
 * @param string $password Plain text password
 * @param string $hash Hashed password
 * @return bool
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Rate limiting check
 * @param string $action Action identifier
 * @param int $limit Max attempts
 * @param int $window Time window in seconds
 * @return bool True if limit exceeded
 */
function isRateLimited($action, $limit = 5, $window = 300) {
    global $pdo;
    
    $ip = getClientIP();
    $key = $action . '_' . $ip;
    
    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as attempts 
            FROM rate_limits 
            WHERE rate_key = ? AND created_at > DATE_SUB(NOW(), INTERVAL ? SECOND)
        ");
        $stmt->execute([$key, $window]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['attempts'] >= $limit) {
            return true;
        }
        
        // Record attempt
        $stmt = $pdo->prepare("INSERT INTO rate_limits (rate_key, ip_address) VALUES (?, ?)");
        $stmt->execute([$key, $ip]);
        
        return false;
    } catch (PDOException $e) {
        error_log("Rate limiting error: " . $e->getMessage());
        return false;
    }
}

/**
 * Send security alert email
 * @param string $subject Alert subject
 * @param string $message Alert message
 */
function sendSecurityAlert($subject, $message) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT config_value FROM settings WHERE config_key = 'admin_email'");
        $stmt->execute();
        $adminEmail = $stmt->fetchColumn();
        
        if ($adminEmail) {
            $headers = "From: security@" . $_SERVER['HTTP_HOST'] . "\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            
            $body = "<h2>Security Alert</h2>";
            $body .= "<p><strong>Time:</strong> " . date('Y-m-d H:i:s') . "</p>";
            $body .= "<p><strong>IP Address:</strong> " . getClientIP() . "</p>";
            $body .= "<p><strong>Message:</strong> " . $message . "</p>";
            
            mail($adminEmail, $subject, $body, $headers);
        }
    } catch (Exception $e) {
        error_log("Failed to send security alert: " . $e->getMessage());
    }
}

/**
 * Clean old sessions and expired data
 */
function cleanupExpiredData() {
    global $pdo;
    
    try {
        // Clean old login attempts
        $pdo->exec("DELETE FROM login_attempts WHERE attempt_time < DATE_SUB(NOW(), INTERVAL 1 DAY)");
        
        // Clean old remember tokens
        $pdo->exec("DELETE FROM remember_tokens WHERE expires_at < NOW()");
        
        // Clean old rate limits
        $pdo->exec("DELETE FROM rate_limits WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 HOUR)");
    } catch (PDOException $e) {
        error_log("Cleanup error: " . $e->getMessage());
    }
}

// Run cleanup occasionally (1% chance per request)
if (rand(1, 100) === 1) {
    cleanupExpiredData();
}
?>