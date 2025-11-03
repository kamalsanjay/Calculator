<?php
/**
 * Authentication Middleware
 * Checks if user is authenticated
 */

class AuthMiddleware {
    /**
     * Check if user is authenticated
     */
    public static function check() {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Store the intended URL
            $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'];
            
            // Redirect to login
            header('Location: ' . SITE_URL . '/admin/login.php');
            exit;
        }
        
        return true;
    }
    
    /**
     * Check if user is guest (not authenticated)
     */
    public static function guest() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return !isset($_SESSION['user_id']);
    }
    
    /**
     * Get authenticated user ID
     */
    public static function userId() {
        return $_SESSION['user_id'] ?? null;
    }
    
    /**
     * Get authenticated user data
     */
    public static function user() {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }
        
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'username' => $_SESSION['username'] ?? null,
            'email' => $_SESSION['email'] ?? null,
            'role' => $_SESSION['role'] ?? null
        ];
    }
    
    /**
     * Logout user
     */
    public static function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Destroy session
        $_SESSION = [];
        
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        session_destroy();
    }
}
?>