<?php
/**
 * Admin Authentication Handler
 * Calculator Website Project
 * 
 * This file handles admin authentication and session management
 */

// Define the app constant before including config
if (!defined('CALCULATOR_APP')) {
    define('CALCULATOR_APP', true);
}

// Include configuration first
require_once dirname(dirname(__DIR__)) . '/config/config.php';

// Include database connection
require_once dirname(dirname(__DIR__)) . '/config/database.php';

/**
 * Check if user is logged in as admin
 * 
 * @return bool
 */
function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Check if user has admin privileges
 * 
 * @return bool
 */
function isAdmin() {
    return isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'admin';
}

/**
 * Get current admin user ID
 * 
 * @return int|null
 */
function getAdminId() {
    return $_SESSION['admin_id'] ?? null;
}

/**
 * Get current admin username
 * 
 * @return string|null
 */
function getAdminUsername() {
    return $_SESSION['admin_username'] ?? null;
}

/**
 * Get current admin email
 * 
 * @return string|null
 */
function getAdminEmail() {
    return $_SESSION['admin_email'] ?? null;
}

/**
 * Require admin login - redirect if not logged in
 * 
 * @param string $redirect_to URL to redirect after login
 */
function requireAdminLogin($redirect_to = '') {
    if (!isAdminLoggedIn()) {
        $_SESSION['redirect_after_login'] = $redirect_to ?: $_SERVER['REQUEST_URI'];
        header('Location: login.php');
        exit();
    }
}

/**
 * Login admin user
 * 
 * @param string $username
 * @param string $password
 * @return array ['success' => bool, 'message' => string]
 */
function loginAdmin($username, $password) {
    global $db;
    
    try {
        // Sanitize input
        $username = trim($username);
        
        // Check if user exists
        $sql = "SELECT * FROM users WHERE username = :username AND role = 'admin' AND is_active = 1 LIMIT 1";
        $user = $db->fetchOne($sql, ['username' => $username]);
        
        if (!$user) {
            // Log failed attempt
            logLoginAttempt($username, false);
            
            return [
                'success' => false,
                'message' => 'Invalid username or password'
            ];
        }
        
        // Check if account is locked due to too many failed attempts
        if (isAccountLocked($username)) {
            return [
                'success' => false,
                'message' => 'Account temporarily locked due to too many failed login attempts. Please try again later.'
            ];
        }
        
        // Verify password
        if (!password_verify($password, $user['password'])) {
            // Log failed attempt
            logLoginAttempt($username, false);
            
            return [
                'success' => false,
                'message' => 'Invalid username or password'
            ];
        }
        
        // Successful login
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_email'] = $user['email'];
        $_SESSION['admin_role'] = $user['role'];
        $_SESSION['login_time'] = time();
        
        // Regenerate session ID for security
        session_regenerate_id(true);
        
        // Update last login time
        $db->update('users', 
            ['last_login' => date('Y-m-d H:i:s')],
            'id = :id',
            ['id' => $user['id']]
        );
        
        // Log successful attempt
        logLoginAttempt($username, true);
        
        return [
            'success' => true,
            'message' => 'Login successful'
        ];
        
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        
        return [
            'success' => false,
            'message' => 'An error occurred during login. Please try again.'
        ];
    }
}

/**
 * Logout admin user
 */
function logoutAdmin() {
    // Clear all session variables
    $_SESSION = [];
    
    // Destroy the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    // Destroy the session
    session_destroy();
    
    // Redirect to login page
    header('Location: login.php');
    exit();
}

/**
 * Check if account is locked
 * 
 * @param string $username
 * @return bool
 */
function isAccountLocked($username) {
    global $db;
    
    try {
        $sql = "SELECT COUNT(*) as attempts 
                FROM login_attempts 
                WHERE username = :username 
                AND success = 0 
                AND attempt_time > DATE_SUB(NOW(), INTERVAL 15 MINUTE)";
        
        $result = $db->fetchOne($sql, ['username' => $username]);
        
        return ($result['attempts'] ?? 0) >= MAX_LOGIN_ATTEMPTS;
        
    } catch (Exception $e) {
        error_log("Error checking account lock: " . $e->getMessage());
        return false;
    }
}

/**
 * Log login attempt
 * 
 * @param string $username
 * @param bool $success
 */
function logLoginAttempt($username, $success) {
    global $db;
    
    try {
        $db->insert('login_attempts', [
            'username' => $username,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'success' => $success ? 1 : 0,
            'attempt_time' => date('Y-m-d H:i:s')
        ]);
    } catch (Exception $e) {
        error_log("Error logging login attempt: " . $e->getMessage());
    }
}

/**
 * Generate CSRF token
 * 
 * @return string
 */
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * 
 * @param string $token
 * @return bool
 */
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Check session timeout
 */
function checkSessionTimeout() {
    if (isset($_SESSION['login_time'])) {
        $elapsed = time() - $_SESSION['login_time'];
        
        if ($elapsed > SESSION_LIFETIME) {
            logoutAdmin();
        }
        
        // Update last activity time
        $_SESSION['login_time'] = time();
    }
}

// Check session timeout on every request
if (isAdminLoggedIn()) {
    checkSessionTimeout();
}