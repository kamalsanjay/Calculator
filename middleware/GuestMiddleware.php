<?php
/**
 * Guest Middleware
 * Ensures user is NOT authenticated (for login/register pages)
 */

class GuestMiddleware {
    
    /**
     * Check if user is guest (not authenticated)
     */
    public static function check() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (isset($_SESSION['user_id']) && isset($_SESSION['logged_in'])) {
            self::redirectToHome();
        }
        
        // Check remember me token
        if (self::hasRememberToken()) {
            self::redirectToHome();
        }
        
        return true;
    }
    
    /**
     * Check if remember me token exists and is valid
     */
    private static function hasRememberToken() {
        if (!isset($_COOKIE['remember_token'])) {
            return false;
        }
        
        try {
            $db = Database::getInstance();
            $token = $_COOKIE['remember_token'];
            $hashedToken = hash('sha256', $token);
            
            $result = $db->fetch("
                SELECT user_id FROM remember_tokens 
                WHERE token = ? AND expires_at > NOW()
            ", [$hashedToken]);
            
            return $result ? true : false;
            
        } catch (Exception $e) {
            error_log("Remember token check error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Redirect to home page
     */
    private static function redirectToHome() {
        $redirectUrl = $_GET['redirect'] ?? '/';
        
        // Sanitize redirect URL
        $redirectUrl = filter_var($redirectUrl, FILTER_SANITIZE_URL);
        
        // Ensure it's a local redirect
        if (strpos($redirectUrl, 'http') === 0) {
            $redirectUrl = '/';
        }
        
        header('Location: ' . $redirectUrl);
        exit;
    }
    
    /**
     * Check if user is authenticated
     */
    public static function isAuthenticated() {
        return isset($_SESSION['user_id']) && isset($_SESSION['logged_in']);
    }
    
    /**
     * Redirect authenticated users
     */
    public static function redirectIfAuthenticated($url = '/') {
        if (self::isAuthenticated()) {
            header('Location: ' . $url);
            exit;
        }
    }
}