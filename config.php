<?php
/**
 * Configuration File - Calculator Website
 * 
 * This file contains all database and application configurations
 * Uses environment-based configuration for security
 * 
 * @package Calculator
 * @version 1.0.0
 * @author Calculator Team
 */

// Enable strict types for type safety
declare(strict_types=1);

// Prevent direct access
if (!defined('CALCULATOR_APP')) {
    define('CALCULATOR_APP', true);
}

// Error reporting configuration (change to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/logs/error.log');

// Timezone configuration
date_default_timezone_set('America/New_York');

// Session configuration
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_secure', '1'); // Enable in production with HTTPS
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', '1');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * ========================================
 * ENVIRONMENT CONFIGURATION
 * ========================================
 * Change this to 'production' when deploying
 */
define('ENVIRONMENT', 'development'); // Options: 'development', 'production'

/**
 * ========================================
 * DATABASE CONFIGURATION
 * ========================================
 */
if (ENVIRONMENT === 'production') {
    // Production database settings
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'calculator_prod');
    define('DB_USER', 'calculator_user');
    define('DB_PASS', 'your_secure_password_here');
    define('DB_CHARSET', 'utf8mb4');
    
    // Production settings
    define('DISPLAY_ERRORS', false);
    error_reporting(0);
    ini_set('display_errors', '0');
    
} else {
    // Development database settings
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'calculator_dev');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_CHARSET', 'utf8mb4');
    
    // Development settings
    define('DISPLAY_ERRORS', true);
}

/**
 * ========================================
 * APPLICATION CONFIGURATION
 * ========================================
 */

// Site information
define('SITE_NAME', 'Calculator');
define('SITE_TITLE', 'Calculator - Free Online Calculators & Tools');
define('SITE_DESCRIPTION', 'Free online calculator with 300+ tools for financial, health, math, conversion, and more. Fast, accurate, and easy to use calculators.');
define('SITE_KEYWORDS', 'calculator, online calculator, free calculator, math calculator, financial calculator, conversion calculator');
define('SITE_AUTHOR', 'Calculator Team');
define('SITE_VERSION', '1.0.0');

// URL configuration (change in production)
define('BASE_URL', 'http://localhost/calculator/');
define('SITE_URL', 'http://localhost/calculator/');
define('ASSETS_URL', BASE_URL . 'assets/');
define('CSS_URL', ASSETS_URL . 'css/');
define('JS_URL', ASSETS_URL . 'js/');
define('IMG_URL', ASSETS_URL . 'images/');

// Directory paths
define('ROOT_PATH', __DIR__ . '/');
define('INCLUDES_PATH', ROOT_PATH . 'includes/');
define('CALCULATORS_PATH', ROOT_PATH . 'calculators/');
define('ADMIN_PATH', ROOT_PATH . 'admin/');
define('API_PATH', ROOT_PATH . 'api/');
define('LOGS_PATH', ROOT_PATH . 'logs/');

/**
 * ========================================
 * SECURITY CONFIGURATION
 * ========================================
 */

// CSRF token configuration
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
define('CSRF_TOKEN', $_SESSION['csrf_token']);

// Password hashing configuration
define('PASSWORD_HASH_ALGO', PASSWORD_ARGON2ID);
define('PASSWORD_HASH_OPTIONS', [
    'memory_cost' => 65536,
    'time_cost' => 4,
    'threads' => 3
]);

// Maximum login attempts
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 minutes in seconds

// File upload configuration
define('MAX_FILE_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']);

/**
 * ========================================
 * EMAIL CONFIGURATION
 * ========================================
 */
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-app-password');
define('SMTP_FROM_EMAIL', 'noreply@calculator.com');
define('SMTP_FROM_NAME', 'Calculator Team');

// Admin email for notifications
define('ADMIN_EMAIL', 'admin@calculator.com');

/**
 * ========================================
 * PAGINATION CONFIGURATION
 * ========================================
 */
define('ITEMS_PER_PAGE', 20);
define('CALCULATORS_PER_PAGE', 24);
define('SEARCH_RESULTS_PER_PAGE', 15);

/**
 * ========================================
 * CACHE CONFIGURATION
 * ========================================
 */
define('ENABLE_CACHE', true);
define('CACHE_TIME', 3600); // 1 hour in seconds
define('CACHE_PATH', ROOT_PATH . 'cache/');

/**
 * ========================================
 * ADSENSE CONFIGURATION
 * ========================================
 */
define('ENABLE_ADS', true);
define('ADSENSE_CLIENT_ID', 'ca-pub-XXXXXXXXXXXXXXXX'); // Replace with your AdSense ID

// Ad slot IDs (replace with your actual slot IDs)
define('AD_VERTICAL_1', 'XXXXXXXXXX'); // Right sidebar top
define('AD_VERTICAL_2', 'XXXXXXXXXX'); // Right sidebar bottom
define('AD_HORIZONTAL_1', 'XXXXXXXXXX'); // After results
define('AD_HORIZONTAL_2', 'XXXXXXXXXX'); // Before footer

/**
 * ========================================
 * ANALYTICS CONFIGURATION
 * ========================================
 */
define('ENABLE_ANALYTICS', true);
define('GOOGLE_ANALYTICS_ID', 'G-XXXXXXXXXX'); // Replace with your GA4 ID

/**
 * ========================================
 * API CONFIGURATION
 * ========================================
 */
define('API_RATE_LIMIT', 100); // Requests per hour
define('API_KEY_LENGTH', 32);

/**
 * ========================================
 * CALCULATOR CATEGORIES
 * ========================================
 */
define('CALCULATOR_CATEGORIES', [
    'financial' => ['name' => 'Financial', 'icon' => '💰', 'count' => 58],
    'health' => ['name' => 'Health & Fitness', 'icon' => '🏥', 'count' => 40],
    'math' => ['name' => 'Math', 'icon' => '🔢', 'count' => 42],
    'conversion' => ['name' => 'Conversion', 'icon' => '🔄', 'count' => 40],
    'date-time' => ['name' => 'Date & Time', 'icon' => '📅', 'count' => 16],
    'construction' => ['name' => 'Construction', 'icon' => '🏗️', 'count' => 18],
    'electronics' => ['name' => 'Electronics', 'icon' => '⚡', 'count' => 12],
    'automotive' => ['name' => 'Automotive', 'icon' => '🚗', 'count' => 11],
    'education' => ['name' => 'Education', 'icon' => '🎓', 'count' => 10],
    'utility' => ['name' => 'Utility', 'icon' => '🛠️', 'count' => 15],
    'weather' => ['name' => 'Weather', 'icon' => '🌤️', 'count' => 9],
    'cooking' => ['name' => 'Cooking', 'icon' => '🍳', 'count' => 9],
    'gaming' => ['name' => 'Gaming', 'icon' => '🎮', 'count' => 8],
    'sports' => ['name' => 'Sports', 'icon' => '⚽', 'count' => 8]
]);

/**
 * ========================================
 * DATABASE CONNECTION FUNCTION
 * ========================================
 */

/**
 * Get PDO database connection
 * 
 * @return PDO Database connection object
 * @throws PDOException If connection fails
 */
function getDBConnection(): PDO {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_PERSISTENT         => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
            ];
            
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            
        } catch (PDOException $e) {
            // Log the error
            error_log("Database Connection Error: " . $e->getMessage());
            
            // Show user-friendly message
            if (ENVIRONMENT === 'development') {
                die("Database connection failed: " . $e->getMessage());
            } else {
                die("We're experiencing technical difficulties. Please try again later.");
            }
        }
    }
    
    return $pdo;
}

/**
 * ========================================
 * UTILITY FUNCTIONS
 * ========================================
 */

/**
 * Sanitize input data
 * 
 * @param mixed $data Input data to sanitize
 * @return mixed Sanitized data
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate CSRF token
 * 
 * @param string $token Token to validate
 * @return bool True if valid, false otherwise
 */
function validateCSRFToken(string $token): bool {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Generate new CSRF token
 * 
 * @return string New CSRF token
 */
function generateCSRFToken(): string {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}

/**
 * Redirect to URL
 * 
 * @param string $url URL to redirect to
 * @return void
 */
function redirect(string $url): void {
    header("Location: " . $url);
    exit;
}

/**
 * Check if user is logged in
 * 
 * @return bool True if logged in, false otherwise
 */
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
}

/**
 * Check if user is admin
 * 
 * @return bool True if admin, false otherwise
 */
function isAdmin(): bool {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * ========================================
 * AUTO-LOAD REQUIRED FILES
 * ========================================
 */

// Create necessary directories if they don't exist
$directories = [LOGS_PATH, CACHE_PATH];
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Load common functions if file exists
if (file_exists(INCLUDES_PATH . 'functions.php')) {
    require_once INCLUDES_PATH . 'functions.php';
}

/**
 * ========================================
 * CONFIGURATION COMPLETE
 * ========================================
 * All configuration values are now available throughout the application
 */  
