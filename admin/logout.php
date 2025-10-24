<?php
/**
 * Admin Logout Script
 * Securely destroys session and redirects to login
 * @version 1.0.0
 */

// Start session
session_start();

// Include database connection
require_once '../config/database.php';

// Log logout activity if user is logged in
if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_username'])) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO activity_log (user_id, action, description, ip_address, user_agent, created_at) 
            VALUES (?, 'logout', ?, ?, ?, NOW())
        ");
        
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipAddress = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        }
        
        $stmt->execute([
            $_SESSION['admin_id'],
            'User ' . $_SESSION['admin_username'] . ' logged out',
            $ipAddress,
            $_SERVER['HTTP_USER_AGENT'] ?? ''
        ]);
    } catch (PDOException $e) {
        // Log error but continue with logout
        error_log("Logout logging error: " . $e->getMessage());
    }
}

// Delete remember me token if exists
if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $hashedToken = hash('sha256', $token);
    
    try {
        $stmt = $pdo->prepare("DELETE FROM remember_tokens WHERE token = ?");
        $stmt->execute([$hashedToken]);
    } catch (PDOException $e) {
        error_log("Remember token deletion error: " . $e->getMessage());
    }
    
    // Delete cookie
    setcookie('remember_token', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']), true);
}

// Unset all session variables
$_SESSION = array();

// Delete session cookie
if (isset($_COOKIE[session_name()])) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destroy session
session_destroy();

// Redirect to login page
header('Location: login.php?logout=1');
exit();
?>  
