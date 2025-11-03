<?php
/**
 * Session Management Class
 * Handles session operations and security
 */

class Session {
    private $sessionName = 'calculator_session';
    private $sessionLifetime = 7200; // 2 hours
    
    /**
     * Constructor
     */
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            $this->configure();
            session_start();
            $this->validateSession();
        }
    }
    
    /**
     * Configure session
     */
    private function configure() {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
        ini_set('session.cookie_samesite', 'Lax');
        ini_set('session.gc_maxlifetime', $this->sessionLifetime);
        
        session_name($this->sessionName);
    }
    
    /**
     * Validate session
     */
    private function validateSession() {
        // Check if session is expired
        if ($this->has('last_activity')) {
            $elapsed = time() - $this->get('last_activity');
            if ($elapsed > $this->sessionLifetime) {
                $this->destroy();
                return;
            }
        }
        
        // Update last activity
        $this->set('last_activity', time());
        
        // Validate fingerprint
        $this->validateFingerprint();
    }
    
    /**
     * Generate and validate session fingerprint
     */
    private function validateFingerprint() {
        $fingerprint = $this->generateFingerprint();
        
        if (!$this->has('fingerprint')) {
            $this->set('fingerprint', $fingerprint);
        } elseif ($this->get('fingerprint') !== $fingerprint) {
            // Fingerprint mismatch - possible session hijacking
            $this->destroy();
        }
    }
    
    /**
     * Generate session fingerprint
     */
    private function generateFingerprint() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
        
        return hash('sha256', $userAgent . $ipAddress);
    }
    
    /**
     * Set session value
     */
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    /**
     * Get session value
     */
    public function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
    
    /**
     * Check if session has key
     */
    public function has($key) {
        return isset($_SESSION[$key]);
    }
    
    /**
     * Remove session value
     */
    public function remove($key) {
        unset($_SESSION[$key]);
    }
    
    /**
     * Flash message
     */
    public function flash($key, $value) {
        $_SESSION['flash'][$key] = $value;
    }
    
    /**
     * Get flash message
     */
    public function getFlash($key, $default = null) {
        if (isset($_SESSION['flash'][$key])) {
            $value = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $value;
        }
        return $default;
    }
    
    /**
     * Check if has flash message
     */
    public function hasFlash($key) {
        return isset($_SESSION['flash'][$key]);
    }
    
    /**
     * Regenerate session ID
     */
    public function regenerate() {
        session_regenerate_id(true);
        $this->set('fingerprint', $this->generateFingerprint());
    }
    
    /**
     * Destroy session
     */
    public function destroy() {
        $_SESSION = [];
        
        // Delete session cookie
        if (ini_get('session.use_cookies')) {
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
        
        session_destroy();
    }
    
    /**
     * Get all session data
     */
    public function all() {
        return $_SESSION;
    }
    
    /**
     * Clear all session data
     */
    public function clear() {
        $_SESSION = [];
    }
    
    /**
     * Get session ID
     */
    public function getId() {
        return session_id();
    }
    
    /**
     * Check if session is active
     */
    public function isActive() {
        return session_status() === PHP_SESSION_ACTIVE;
    }
}