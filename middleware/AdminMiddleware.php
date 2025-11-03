<?php
/**
 * Admin Middleware
 * Checks if user is authenticated and has admin role
 */

// Include AuthMiddleware
require_once __DIR__ . '/AuthMiddleware.php';

class AdminMiddleware {
    /**
     * Check if user is admin
     */
    public static function check() {
        // First check if authenticated
        AuthMiddleware::check();
        
        // Check if user has admin role
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            // Not an admin, redirect to homepage
            header('Location: ' . SITE_URL . '/index.php');
            exit;
        }
        
        return true;
    }
    
    /**
     * Check if current user is admin (without redirect)
     */
    public static function isAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    /**
     * Get admin user data
     */
    public static function adminUser() {
        if (!self::isAdmin()) {
            return null;
        }
        
        return AuthMiddleware::user();
    }
}
?>