<?php
/**
 * CORS Middleware
 * Handles Cross-Origin Resource Sharing
 */

class CORSMiddleware {
    private static $allowedOrigins = ['*'];
    private static $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];
    private static $allowedHeaders = ['Content-Type', 'Authorization', 'X-Requested-With', 'X-CSRF-TOKEN'];
    private static $exposedHeaders = ['X-RateLimit-Limit', 'X-RateLimit-Remaining'];
    private static $maxAge = 86400; // 24 hours
    private static $allowCredentials = true;
    
    /**
     * Handle CORS
     */
    public static function handle() {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        
        // Check if origin is allowed
        if (self::isOriginAllowed($origin)) {
            self::setHeaders($origin);
        }
        
        // Handle preflight request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            self::handlePreflight();
        }
        
        return true;
    }
    
    /**
     * Check if origin is allowed
     */
    private static function isOriginAllowed($origin) {
        if (empty($origin)) {
            return true; // Same-origin request
        }
        
        // Allow all origins
        if (in_array('*', self::$allowedOrigins)) {
            return true;
        }
        
        // Check if origin is in whitelist
        return in_array($origin, self::$allowedOrigins);
    }
    
    /**
     * Set CORS headers
     */
    private static function setHeaders($origin) {
        // Access-Control-Allow-Origin
        if (in_array('*', self::$allowedOrigins)) {
            header('Access-Control-Allow-Origin: *');
        } else {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Vary: Origin');
        }
        
        // Access-Control-Allow-Methods
        header('Access-Control-Allow-Methods: ' . implode(', ', self::$allowedMethods));
        
        // Access-Control-Allow-Headers
        header('Access-Control-Allow-Headers: ' . implode(', ', self::$allowedHeaders));
        
        // Access-Control-Expose-Headers
        if (!empty(self::$exposedHeaders)) {
            header('Access-Control-Expose-Headers: ' . implode(', ', self::$exposedHeaders));
        }
        
        // Access-Control-Allow-Credentials
        if (self::$allowCredentials) {
            header('Access-Control-Allow-Credentials: true');
        }
        
        // Access-Control-Max-Age
        header('Access-Control-Max-Age: ' . self::$maxAge);
    }
    
    /**
     * Handle preflight request
     */
    private static function handlePreflight() {
        http_response_code(204);
        exit;
    }
    
    /**
     * Set allowed origins
     */
    public static function setAllowedOrigins($origins) {
        self::$allowedOrigins = is_array($origins) ? $origins : [$origins];
    }
    
    /**
     * Add allowed origin
     */
    public static function addAllowedOrigin($origin) {
        if (!in_array($origin, self::$allowedOrigins)) {
            self::$allowedOrigins[] = $origin;
        }
    }
    
    /**
     * Set allowed methods
     */
    public static function setAllowedMethods($methods) {
        self::$allowedMethods = is_array($methods) ? $methods : [$methods];
    }
    
    /**
     * Set allowed headers
     */
    public static function setAllowedHeaders($headers) {
        self::$allowedHeaders = is_array($headers) ? $headers : [$headers];
    }
    
    /**
     * Set exposed headers
     */
    public static function setExposedHeaders($headers) {
        self::$exposedHeaders = is_array($headers) ? $headers : [$headers];
    }
    
    /**
     * Set max age
     */
    public static function setMaxAge($seconds) {
        self::$maxAge = $seconds;
    }
    
    /**
     * Set allow credentials
     */
    public static function setAllowCredentials($allow) {
        self::$allowCredentials = $allow;
    }
    
    /**
     * Load configuration from file
     */
    public static function loadConfig() {
        $configFile = BASE_PATH . '/config/api.php';
        
        if (file_exists($configFile)) {
            $config = require $configFile;
            
            if (isset($config['cors'])) {
                $cors = $config['cors'];
                
                if (isset($cors['allowed_origins'])) {
                    self::setAllowedOrigins($cors['allowed_origins']);
                }
                
                if (isset($cors['allowed_methods'])) {
                    self::setAllowedMethods($cors['allowed_methods']);
                }
                
                if (isset($cors['allowed_headers'])) {
                    self::setAllowedHeaders($cors['allowed_headers']);
                }
                
                if (isset($cors['exposed_headers'])) {
                    self::setExposedHeaders($cors['exposed_headers']);
                }
                
                if (isset($cors['max_age'])) {
                    self::setMaxAge($cors['max_age']);
                }
                
                if (isset($cors['supports_credentials'])) {
                    self::setAllowCredentials($cors['supports_credentials']);
                }
            }
        }
    }
    
    /**
     * Check if request is CORS
     */
    public static function isCorsRequest() {
        return isset($_SERVER['HTTP_ORIGIN']) && 
               $_SERVER['HTTP_ORIGIN'] !== self::getCurrentOrigin();
    }
    
    /**
     * Get current origin
     */
    private static function getCurrentOrigin() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $protocol . '://' . $host;
    }
}