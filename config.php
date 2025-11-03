<?php
/**
 * Configuration File - Updated Version
 * Database and application settings
 */

// Error Reporting (Disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Create logs directory
if (!is_dir(__DIR__ . '/logs')) {
    @mkdir(__DIR__ . '/logs', 0755, true);
}
ini_set('error_log', __DIR__ . '/logs/php-errors.log');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'calculator');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site Configuration
define('SITE_URL', 'http://localhost/Calculator');
define('SITE_NAME', 'Calculator');
define('BASE_PATH', __DIR__);

// Security Keys
define('JWT_SECRET', bin2hex(random_bytes(32)));
define('ENCRYPTION_KEY', bin2hex(random_bytes(32)));

// Email Configuration
define('MAIL_FROM_ADDRESS', 'noreply@calculator.local');
define('MAIL_FROM_NAME', 'Calculator');

// Timezone
date_default_timezone_set('UTC');

/**
 * Database Connection Class - Enhanced
 */
class Database {
    private static $instance = null;
    private $pdo;
    
    private function __construct() {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log('Database Connection Error: ' . $e->getMessage());
            
            // Show user-friendly error in development
            if (ini_get('display_errors')) {
                die('<h1>Database Connection Error</h1><p>Could not connect to database. Please check your configuration.</p><p><strong>Error:</strong> ' . $e->getMessage() . '</p>');
            } else {
                die('Database connection failed. Please contact the administrator.');
            }
        }
    }
    
    /**
     * Get singleton instance
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Get PDO instance
     */
    public function getPDO() {
        return $this->pdo;
    }
    
    /**
     * Prepare statement
     */
    public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }
    
    /**
     * Execute query with parameters
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log('Query Error: ' . $e->getMessage() . ' | SQL: ' . $sql);
            throw $e;
        }
    }
    
    /**
     * Fetch all rows
     */
    public function fetchAll($sql, $params = []) {
        try {
            return $this->query($sql, $params)->fetchAll();
        } catch (PDOException $e) {
            error_log('fetchAll Error: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Fetch one row
     */
    public function fetchOne($sql, $params = []) {
        try {
            return $this->query($sql, $params)->fetch();
        } catch (PDOException $e) {
            error_log('fetchOne Error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Fetch single column value
     */
    public function fetchColumn($sql, $params = []) {
        try {
            return $this->query($sql, $params)->fetchColumn();
        } catch (PDOException $e) {
            error_log('fetchColumn Error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Execute SQL statement (UPDATE, DELETE, INSERT without returning data)
     * This is the method that was missing!
     */
    public function execute($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log('Execute Error: ' . $e->getMessage() . ' | SQL: ' . $sql);
            throw $e;
        }
    }
    
    /**
     * Execute raw SQL (use with caution)
     */
    public function exec($sql) {
        try {
            return $this->pdo->exec($sql);
        } catch (PDOException $e) {
            error_log('Exec Error: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Get last insert ID
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
    
    /**
     * Begin transaction
     */
    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }
    
    /**
     * Commit transaction
     */
    public function commit() {
        return $this->pdo->commit();
    }
    
    /**
     * Rollback transaction
     */
    public function rollBack() {
        return $this->pdo->rollBack();
    }
    
    /**
     * Check if in transaction
     */
    public function inTransaction() {
        return $this->pdo->inTransaction();
    }
    
    /**
     * Insert data into table
     * 
     * @param string $table Table name
     * @param array $data Associative array of column => value
     * @return int Last insert ID
     */
    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        
        $this->execute($sql, array_values($data));
        return $this->lastInsertId();
    }
    
    /**
     * Update data in table
     * 
     * @param string $table Table name
     * @param array $data Associative array of column => value
     * @param string $where WHERE clause
     * @param array $whereParams Parameters for WHERE clause
     * @return bool Success
     */
    public function update($table, $data, $where, $whereParams = []) {
        $setParts = [];
        foreach (array_keys($data) as $column) {
            $setParts[] = "{$column} = ?";
        }
        $setClause = implode(', ', $setParts);
        
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        $params = array_merge(array_values($data), $whereParams);
        
        return $this->execute($sql, $params);
    }
    
    /**
     * Delete from table
     * 
     * @param string $table Table name
     * @param string $where WHERE clause
     * @param array $params Parameters for WHERE clause
     * @return bool Success
     */
    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        return $this->execute($sql, $params);
    }
    
    /**
     * Check if record exists
     * 
     * @param string $table Table name
     * @param string $where WHERE clause
     * @param array $params Parameters
     * @return bool Exists
     */
    public function exists($table, $where, $params = []) {
        $sql = "SELECT COUNT(*) FROM {$table} WHERE {$where}";
        return (int) $this->fetchColumn($sql, $params) > 0;
    }
    
    /**
     * Get table row count
     * 
     * @param string $table Table name
     * @param string $where Optional WHERE clause
     * @param array $params Optional parameters
     * @return int Count
     */
    public function count($table, $where = '', $params = []) {
        $sql = "SELECT COUNT(*) FROM {$table}";
        if ($where) {
            $sql .= " WHERE {$where}";
        }
        return (int) $this->fetchColumn($sql, $params);
    }
}

/**
 * Helper Functions
 */

/**
 * Sanitize input data
 */
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Redirect to URL
 */
function redirect($url, $statusCode = 302) {
    header('Location: ' . $url, true, $statusCode);
    exit;
}

/**
 * Get current URL
 */
function current_url() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is admin
 */
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Generate CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Format number with commas
 */
function format_number($number, $decimals = 0) {
    return number_format($number, $decimals, '.', ',');
}

/**
 * Get time ago format
 */
function time_ago($datetime) {
    $timestamp = strtotime($datetime);
    $difference = time() - $timestamp;
    
    if ($difference < 60) {
        return $difference . ' seconds ago';
    } elseif ($difference < 3600) {
        return floor($difference / 60) . ' minutes ago';
    } elseif ($difference < 86400) {
        return floor($difference / 3600) . ' hours ago';
    } elseif ($difference < 604800) {
        return floor($difference / 86400) . ' days ago';
    } else {
        return date('M j, Y', $timestamp);
    }
}

/**
 * Generate slug from text
 */
function generate_slug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    $text = trim($text, '-');
    return $text;
}

/**
 * Truncate text
 */
function truncate($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $suffix;
}

/**
 * Load settings from database
 */
function get_setting($key, $default = null) {
    static $settings = null;
    
    if ($settings === null) {
        try {
            $db = Database::getInstance();
            $results = $db->fetchAll("SELECT setting_key, setting_value FROM site_settings");
            $settings = [];
            foreach ($results as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (Exception $e) {
            error_log('Error loading settings: ' . $e->getMessage());
            $settings = [];
        }
    }
    
    return $settings[$key] ?? $default;
}

/**
 * Update setting in database
 */
function update_setting($key, $value) {
    try {
        $db = Database::getInstance();
        return $db->execute(
            "UPDATE site_settings SET setting_value = ?, updated_at = NOW() WHERE setting_key = ?",
            [$value, $key]
        );
    } catch (Exception $e) {
        error_log('Error updating setting: ' . $e->getMessage());
        return false;
    }
}

/**
 * Log activity
 */
function log_activity($action, $description = '', $user_id = null) {
    try {
        $db = Database::getInstance();
        $user_id = $user_id ?? ($_SESSION['user_id'] ?? null);
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
        
        $db->execute(
            "INSERT INTO activity_log (user_id, action, description, ip_address, created_at) VALUES (?, ?, ?, ?, NOW())",
            [$user_id, $action, $description, $ip_address]
        );
    } catch (Exception $e) {
        error_log('Error logging activity: ' . $e->getMessage());
    }
}

// Start session with secure settings
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_secure' => false, // Set to true in production with HTTPS
        'use_strict_mode' => true,
        'use_only_cookies' => true,
        'cookie_samesite' => 'Strict'
    ]);
    
    // Generate CSRF token if not exists
    generate_csrf_token();
}

// Auto-load additional functions
if (file_exists(__DIR__ . '/includes/functions.php')) {
    require_once __DIR__ . '/includes/functions.php';
}

// Set default timezone from settings if available
try {
    $timezone = get_setting('timezone', 'UTC');
    date_default_timezone_set($timezone);
} catch (Exception $e) {
    // Use default UTC if settings not available
    date_default_timezone_set('UTC');
}