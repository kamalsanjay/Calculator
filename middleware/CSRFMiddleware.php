<?php
/**
 * CSRF Protection Middleware
 * Protects against Cross-Site Request Forgery attacks
 */

class CSRFMiddleware {
    private static $tokenName = 'csrf_token';
    private static $headerName = 'X-CSRF-TOKEN';
    
    /**
     * Generate CSRF token
     */
    public static function generateToken() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION[self::$tokenName])) {
            $_SESSION[self::$tokenName] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION[self::$tokenName];
    }
    
    /**
     * Get CSRF token
     */
    public static function getToken() {
        return $_SESSION[self::$tokenName] ?? self::generateToken();
    }
    
    /**
     * Verify CSRF token
     */
    public static function verify() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Skip verification for GET, HEAD, OPTIONS requests
        $method = $_SERVER['REQUEST_METHOD'];
        if (in_array($method, ['GET', 'HEAD', 'OPTIONS'])) {
            return true;
        }
        
        $token = self::getTokenFromRequest();
        
        if (!$token) {
            self::handleInvalidToken('CSRF token not found in request');
            return false;
        }
        
        if (!isset($_SESSION[self::$tokenName])) {
            self::handleInvalidToken('CSRF token not found in session');
            return false;
        }
        
        if (!hash_equals($_SESSION[self::$tokenName], $token)) {
            self::handleInvalidToken('CSRF token mismatch');
            return false;
        }
        
        return true;
    }
    
    /**
     * Get token from request
     */
    private static function getTokenFromRequest() {
        // Check POST data
        if (isset($_POST[self::$tokenName])) {
            return $_POST[self::$tokenName];
        }
        
        // Check headers
        $headers = getallheaders();
        if (isset($headers[self::$headerName])) {
            return $headers[self::$headerName];
        }
        
        // Check JSON body
        $jsonData = json_decode(file_get_contents('php://input'), true);
        if (isset($jsonData[self::$tokenName])) {
            return $jsonData[self::$tokenName];
        }
        
        return null;
    }
    
    /**
     * Handle invalid token
     */
    private static function handleInvalidToken($reason) {
        // Log the attempt
        self::logCSRFAttempt($reason);
        
        // Return 403 response
        http_response_code(403);
        
        if (self::isAjaxRequest()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => 'CSRF token validation failed. Please refresh the page and try again.'
            ]);
        } else {
            echo self::getCSRFErrorPage();
        }
        
        exit;
    }
    
    /**
     * Log CSRF attempt
     */
    private static function logCSRFAttempt($reason) {
        try {
            $db = Database::getInstance();
            
            $db->insert('csrf_log', [
                'ip_address' => Security::getClientIP(),
                'user_id' => $_SESSION['user_id'] ?? null,
                'endpoint' => $_SERVER['REQUEST_URI'] ?? null,
                'reason' => $reason,
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
        } catch (Exception $e) {
            error_log("Log CSRF attempt error: " . $e->getMessage());
        }
    }
    
    /**
     * Get CSRF error page
     */
    private static function getCSRFErrorPage() {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Security Error</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                    margin: 0;
                    background: #f5f5f5;
                }
                .container {
                    text-align: center;
                    background: white;
                    padding: 3rem;
                    border-radius: 12px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                    max-width: 500px;
                }
                h1 {
                    color: #dc3545;
                    font-size: 3rem;
                    margin: 0 0 1rem 0;
                }
                p {
                    color: #6c757d;
                    font-size: 1.1rem;
                    line-height: 1.6;
                }
                .btn {
                    display: inline-block;
                    margin-top: 2rem;
                    padding: 0.75rem 2rem;
                    background: #007bff;
                    color: white;
                    text-decoration: none;
                    border-radius: 8px;
                    transition: 0.3s ease;
                }
                .btn:hover {
                    background: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>403</h1>
                <h2>Security Error</h2>
                <p>CSRF token validation failed. This might happen if your session expired or if you opened the form in multiple tabs.</p>
                <p>Please refresh the page and try again.</p>
                <a href="javascript:location.reload()" class="btn">Refresh Page</a>
            </div>
        </body>
        </html>
        ';
    }
    
    /**
     * Check if request is AJAX
     */
    private static function isAjaxRequest() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    /**
     * Get HTML input field
     */
    public static function field() {
        $token = self::getToken();
        return '<input type="hidden" name="' . self::$tokenName . '" value="' . htmlspecialchars($token) . '">';
    }
    
    /**
     * Get meta tag for JavaScript
     */
    public static function metaTag() {
        $token = self::getToken();
        return '<meta name="csrf-token" content="' . htmlspecialchars($token) . '">';
    }
    
    /**
     * Regenerate token
     */
    public static function regenerateToken() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION[self::$tokenName] = bin2hex(random_bytes(32));
        return $_SESSION[self::$tokenName];
    }
}