<?php
/**
 * Rate Limit Middleware
 * Prevents abuse by limiting request frequency
 */

class RateLimitMiddleware {
    private static $defaultMaxRequests = 100;
    private static $defaultWindowSeconds = 3600; // 1 hour
    
    /**
     * Check rate limit
     */
    public static function check($maxRequests = null, $windowSeconds = null) {
        $maxRequests = $maxRequests ?: self::$defaultMaxRequests;
        $windowSeconds = $windowSeconds ?: self::$defaultWindowSeconds;
        
        $key = self::getKey();
        
        if (self::isRateLimited($key, $maxRequests, $windowSeconds)) {
            self::handleRateLimit();
        }
        
        self::incrementCounter($key, $windowSeconds);
        
        return true;
    }
    
    /**
     * Check if rate limited
     */
    private static function isRateLimited($key, $maxRequests, $windowSeconds) {
        try {
            $db = Database::getInstance();
            
            // Clean expired entries
            $db->query("DELETE FROM rate_limits WHERE expires_at < NOW()");
            
            // Get current request count
            $result = $db->fetch("
                SELECT attempts 
                FROM rate_limits 
                WHERE key_hash = ? AND expires_at > NOW()
            ", [hash('sha256', $key)]);
            
            if ($result && $result['attempts'] >= $maxRequests) {
                return true;
            }
            
            return false;
            
        } catch (Exception $e) {
            error_log("Rate limit check error: " . $e->getMessage());
            return false; // Fail open in case of error
        }
    }
    
    /**
     * Increment request counter
     */
    private static function incrementCounter($key, $windowSeconds) {
        try {
            $db = Database::getInstance();
            $keyHash = hash('sha256', $key);
            $expiresAt = date('Y-m-d H:i:s', time() + $windowSeconds);
            
            $db->query("
                INSERT INTO rate_limits (key_hash, attempts, expires_at, created_at) 
                VALUES (?, 1, ?, NOW())
                ON DUPLICATE KEY UPDATE 
                    attempts = attempts + 1,
                    expires_at = ?
            ", [$keyHash, $expiresAt, $expiresAt]);
            
        } catch (Exception $e) {
            error_log("Increment rate limit error: " . $e->getMessage());
        }
    }
    
    /**
     * Get rate limit key
     */
    private static function getKey() {
        $ip = Security::getClientIP();
        $userId = $_SESSION['user_id'] ?? 'guest';
        $endpoint = $_SERVER['REQUEST_URI'] ?? '/';
        
        return "rate_limit:{$ip}:{$userId}:{$endpoint}";
    }
    
    /**
     * Handle rate limit exceeded
     */
    private static function handleRateLimit() {
        // Log rate limit hit
        self::logRateLimitHit();
        
        // Set response headers
        header('X-RateLimit-Limit: ' . self::$defaultMaxRequests);
        header('X-RateLimit-Remaining: 0');
        header('Retry-After: ' . self::$defaultWindowSeconds);
        
        // Return 429 response
        http_response_code(429);
        
        if (self::isAjaxRequest()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => 'Rate limit exceeded. Please try again later.',
                'retry_after' => self::$defaultWindowSeconds
            ]);
        } else {
            echo self::getRateLimitPage();
        }
        
        exit;
    }
    
    /**
     * Log rate limit hit
     */
    private static function logRateLimitHit() {
        try {
            $db = Database::getInstance();
            
            $db->insert('rate_limit_log', [
                'ip_address' => Security::getClientIP(),
                'user_id' => $_SESSION['user_id'] ?? null,
                'endpoint' => $_SERVER['REQUEST_URI'] ?? null,
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
        } catch (Exception $e) {
            error_log("Log rate limit error: " . $e->getMessage());
        }
    }
    
    /**
     * Get rate limit exceeded page
     */
    private static function getRateLimitPage() {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Rate Limit Exceeded</title>
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
                <h1>429</h1>
                <h2>Rate Limit Exceeded</h2>
                <p>You have made too many requests. Please wait a moment and try again.</p>
                <a href="/" class="btn">Go to Homepage</a>
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
     * Get remaining requests
     */
    public static function getRemainingRequests($maxRequests = null) {
        $maxRequests = $maxRequests ?: self::$defaultMaxRequests;
        $key = self::getKey();
        
        try {
            $db = Database::getInstance();
            
            $result = $db->fetch("
                SELECT attempts 
                FROM rate_limits 
                WHERE key_hash = ? AND expires_at > NOW()
            ", [hash('sha256', $key)]);
            
            $used = $result ? $result['attempts'] : 0;
            return max(0, $maxRequests - $used);
            
        } catch (Exception $e) {
            error_log("Get remaining requests error: " . $e->getMessage());
            return $maxRequests;
        }
    }
    
    /**
     * Clear rate limit for key
     */
    public static function clear($key = null) {
        $key = $key ?: self::getKey();
        
        try {
            $db = Database::getInstance();
            $db->delete('rate_limits', 'key_hash = ?', [hash('sha256', $key)]);
            return true;
        } catch (Exception $e) {
            error_log("Clear rate limit error: " . $e->getMessage());
            return false;
        }
    }
}