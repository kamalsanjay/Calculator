<?php
/**
 * URL Router
 * Handles all URL routing for the application
 */

class Router {
    private static $routes = [];
    
    /**
     * Add a route
     */
    public static function add($pattern, $callback) {
        self::$routes[$pattern] = $callback;
    }
    
    /**
     * Dispatch the request
     */
    public static function dispatch() {
        $uri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        $uri = strtok($uri, '?');
        
        // Remove base path
        $base_path = '/Calculator';
        if (strpos($uri, $base_path) === 0) {
            $uri = substr($uri, strlen($base_path));
        }
        
        // Remove trailing slash
        $uri = rtrim($uri, '/');
        
        // Home page
        if (empty($uri) || $uri === '/index.php') {
            if (file_exists(__DIR__ . '/index.php')) {
                return;
            }
        }
        
        // Check for direct file access
        $file_path = __DIR__ . $uri;
        if (file_exists($file_path) && is_file($file_path)) {
            return;
        }
        
        // Check for PHP file
        if (file_exists($file_path . '.php')) {
            include $file_path . '.php';
            return;
        }
        
        // Check for index.php in directory
        if (is_dir($file_path) && file_exists($file_path . '/index.php')) {
            include $file_path . '/index.php';
            return;
        }
        
        // 404 Not Found
        http_response_code(404);
        if (file_exists(__DIR__ . '/404.php')) {
            include __DIR__ . '/404.php';
        } else {
            echo '<h1>404 - Page Not Found</h1>';
            echo '<p>The page you are looking for does not exist.</p>';
            echo '<p><a href="' . SITE_URL . '">Go to Homepage</a></p>';
        }
    }
}