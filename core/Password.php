<?php
/**
 * Password Class
 * Handles password hashing and verification
 */

class Password {
    /**
     * Hash password
     */
    public static function hash($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    
    /**
     * Verify password
     */
    public static function verify($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Check if password needs rehash
     */
    public static function needsRehash($hash) {
        return password_needs_rehash($hash, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    
    /**
     * Generate random password
     */
    public static function generate($length = 16) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        $password = '';
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }
        
        return $password;
    }
    
    /**
     * Validate password strength
     */
    public static function validateStrength($password) {
        $errors = [];
        
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long";
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter";
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter";
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Password must contain at least one number";
        }
        
        if (!preg_match('/[@$!%*?&#]/', $password)) {
            $errors[] = "Password must contain at least one special character";
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'strength' => self::calculateStrength($password)
        ];
    }
    
    /**
     * Calculate password strength
     */
    public static function calculateStrength($password) {
        $strength = 0;
        
        if (strlen($password) >= 8) $strength++;
        if (strlen($password) >= 12) $strength++;
        if (preg_match('/[a-z]/', $password)) $strength++;
        if (preg_match('/[A-Z]/', $password)) $strength++;
        if (preg_match('/[0-9]/', $password)) $strength++;
        if (preg_match('/[@$!%*?&#]/', $password)) $strength++;
        
        if ($strength <= 2) return 'weak';
        if ($strength <= 4) return 'medium';
        return 'strong';
    }
    
    /**
     * Hash password for storage (alternative method)
     */
    public static function hashArgon2($password) {
        return password_hash($password, PASSWORD_ARGON2ID);
    }
    
    /**
     * Create password reset token
     */
    public static function createResetToken() {
        return bin2hex(random_bytes(32));
    }
    
    /**
     * Validate reset token
     */
    public static function validateResetToken($token, $userId) {
        $db = Database::getInstance();
        
        try {
            $result = $db->fetch("
                SELECT * FROM password_resets 
                WHERE user_id = ? AND token = ? AND expires_at > NOW()
            ", [$userId, hash('sha256', $token)]);
            
            return $result ? true : false;
            
        } catch (Exception $e) {
            error_log("Validate reset token error: " . $e->getMessage());
            return false;
        }
    }
}