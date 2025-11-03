<?php
/**
 * Authentication Class
 * Handles user authentication and authorization
 */

class Auth {
    private $db;
    private $session;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->db = Database::getInstance();
        $this->session = new Session();
    }
    
    /**
     * Attempt login
     */
    public function attempt($email, $password, $remember = false) {
        try {
            // Get user by email
            $user = $this->db->fetch("
                SELECT * FROM users WHERE email = ? AND is_active = 1
            ", [$email]);
            
            if (!$user) {
                $this->logFailedAttempt($email);
                return false;
            }
            
            // Verify password
            if (!Password::verify($password, $user['password'])) {
                $this->logFailedAttempt($email);
                return false;
            }
            
            // Check if email is verified
            if (!$user['email_verified'] && $this->requireEmailVerification()) {
                throw new Exception("Email not verified");
            }
            
            // Login successful
            $this->login($user, $remember);
            
            // Update last login
            $this->db->update('users', [
                'last_login' => date('Y-m-d H:i:s')
            ], 'id = ?', [$user['id']]);
            
            // Clear failed attempts
            $this->clearFailedAttempts($email);
            
            return true;
            
        } catch (Exception $e) {
            error_log("Login attempt error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Login user
     */
    public function login($user, $remember = false) {
        // Regenerate session ID
        $this->session->regenerate();
        
        // Set session data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
        
        // Remember me functionality
        if ($remember) {
            $this->setRememberToken($user['id']);
        }
        
        return true;
    }
    
    /**
     * Logout user
     */
    public function logout() {
        // Delete remember token
        if (isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];
            $this->db->delete('remember_tokens', 'token = ?', [hash('sha256', $token)]);
            setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        }
        
        // Clear session
        $this->session->destroy();
        
        return true;
    }
    
    /**
     * Check if user is authenticated
     */
    public function check() {
        return isset($_SESSION['user_id']) && isset($_SESSION['logged_in']);
    }
    
    /**
     * Check if user is guest
     */
    public function guest() {
        return !$this->check();
    }
    
    /**
     * Get authenticated user
     */
    public function user() {
        if (!$this->check()) {
            return null;
        }
        
        try {
            return $this->db->fetch("SELECT * FROM users WHERE id = ?", [$_SESSION['user_id']]);
        } catch (Exception $e) {
            error_log("Get user error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get user ID
     */
    public function id() {
        return $_SESSION['user_id'] ?? null;
    }
    
    /**
     * Check if user has role
     */
    public function hasRole($role) {
        if (!$this->check()) {
            return false;
        }
        
        $userRole = $_SESSION['user_role'] ?? null;
        
        if (is_array($role)) {
            return in_array($userRole, $role);
        }
        
        return $userRole === $role;
    }
    
    /**
     * Check if user is admin
     */
    public function isAdmin() {
        return $this->hasRole(ROLE_ADMIN);
    }
    
    /**
     * Set remember token
     */
    private function setRememberToken($userId) {
        $token = Token::generate(64);
        $hashedToken = hash('sha256', $token);
        
        try {
            // Delete old tokens
            $this->db->delete('remember_tokens', 'user_id = ?', [$userId]);
            
            // Insert new token
            $this->db->insert('remember_tokens', [
                'user_id' => $userId,
                'token' => $hashedToken,
                'expires_at' => date('Y-m-d H:i:s', time() + (30 * 24 * 60 * 60)) // 30 days
            ]);
            
            // Set cookie
            setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', true, true);
            
        } catch (Exception $e) {
            error_log("Set remember token error: " . $e->getMessage());
        }
    }
    
    /**
     * Check remember token
     */
    public function checkRememberToken() {
        if (!isset($_COOKIE['remember_token'])) {
            return false;
        }
        
        $token = $_COOKIE['remember_token'];
        $hashedToken = hash('sha256', $token);
        
        try {
            $result = $this->db->fetch("
                SELECT user_id FROM remember_tokens 
                WHERE token = ? AND expires_at > NOW()
            ", [$hashedToken]);
            
            if ($result) {
                $user = $this->db->fetch("SELECT * FROM users WHERE id = ?", [$result['user_id']]);
                if ($user) {
                    $this->login($user);
                    return true;
                }
            }
            
        } catch (Exception $e) {
            error_log("Check remember token error: " . $e->getMessage());
        }
        
        return false;
    }
    
    /**
     * Log failed login attempt
     */
    private function logFailedAttempt($email) {
        try {
            $this->db->insert('login_attempts', [
                'email' => $email,
                'ip_address' => Security::getClientIP(),
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            error_log("Log failed attempt error: " . $e->getMessage());
        }
    }
    
    /**
     * Clear failed attempts
     */
    private function clearFailedAttempts($email) {
        try {
            $this->db->delete('login_attempts', 'email = ?', [$email]);
        } catch (Exception $e) {
            error_log("Clear failed attempts error: " . $e->getMessage());
        }
    }
    
    /**
     * Check if too many failed attempts
     */
    public function tooManyAttempts($email, $maxAttempts = 5, $decayMinutes = 15) {
        try {
            $result = $this->db->fetch("
                SELECT COUNT(*) as attempts 
                FROM login_attempts 
                WHERE email = ? AND created_at > DATE_SUB(NOW(), INTERVAL ? MINUTE)
            ", [$email, $decayMinutes]);
            
            return $result['attempts'] >= $maxAttempts;
            
        } catch (Exception $e) {
            error_log("Check attempts error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Require email verification
     */
    private function requireEmailVerification() {
        return true; // Can be made configurable
    }
    
    /**
     * Verify two-factor code
     */
    public function verifyTwoFactor($userId, $code) {
        $twoFactor = new TwoFactorAuth();
        return $twoFactor->verify($userId, $code);
    }
}