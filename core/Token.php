<?php
/**
 * Token Class
 * Generates and validates tokens
 */

class Token {
    /**
     * Generate random token
     */
    public static function generate($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }
    
    /**
     * Generate URL-safe token
     */
    public static function generateUrlSafe($length = 32) {
        return rtrim(strtr(base64_encode(random_bytes($length)), '+/', '-_'), '=');
    }
    
    /**
     * Generate numeric token
     */
    public static function generateNumeric($length = 6) {
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= random_int(0, 9);
        }
        return $token;
    }
    
    /**
     * Generate CSRF token
     */
    public static function generateCSRF() {
        $token = self::generate(32);
        $_SESSION['csrf_token'] = $token;
        return $token;
    }
    
    /**
     * Verify CSRF token
     */
    public static function verifyCSRF($token) {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Generate email verification token
     */
    public static function generateEmailVerification($userId) {
        $db = Database::getInstance();
        $token = self::generate(64);
        
        try {
            $db->insert('email_verifications', [
                'user_id' => $userId,
                'token' => hash('sha256', $token),
                'expires_at' => date('Y-m-d H:i:s', time() + (24 * 60 * 60)) // 24 hours
            ]);
            
            return $token;
            
        } catch (Exception $e) {
            error_log("Generate email verification token error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verify email verification token
     */
    public static function verifyEmailVerification($token) {
        $db = Database::getInstance();
        
        try {
            $result = $db->fetch("
                SELECT user_id FROM email_verifications 
                WHERE token = ? AND expires_at > NOW()
            ", [hash('sha256', $token)]);
            
            if ($result) {
                // Delete used token
                $db->delete('email_verifications', 'user_id = ?', [$result['user_id']]);
                return $result['user_id'];
            }
            
            return false;
            
        } catch (Exception $e) {
            error_log("Verify email verification token error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Generate password reset token
     */
    public static function generatePasswordReset($userId) {
        $db = Database::getInstance();
        $token = self::generate(64);
        
        try {
            // Delete old tokens
            $db->delete('password_resets', 'user_id = ?', [$userId]);
            
            // Insert new token
            $db->insert('password_resets', [
                'user_id' => $userId,
                'token' => hash('sha256', $token),
                'expires_at' => date('Y-m-d H:i:s', time() + (60 * 60)) // 1 hour
            ]);
            
            return $token;
            
        } catch (Exception $e) {
            error_log("Generate password reset token error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verify password reset token
     */
    public static function verifyPasswordReset($token) {
        $db = Database::getInstance();
        
        try {
            $result = $db->fetch("
                SELECT user_id FROM password_resets 
                WHERE token = ? AND expires_at > NOW()
            ", [hash('sha256', $token)]);
            
            return $result ? $result['user_id'] : false;
            
        } catch (Exception $e) {
            error_log("Verify password reset token error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Generate API token
     */
    public static function generateAPI($userId) {
        $db = Database::getInstance();
        $token = self::generate(64);
        
        try {
            $db->insert('api_tokens', [
                'user_id' => $userId,
                'token' => hash('sha256', $token),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            return $token;
            
        } catch (Exception $e) {
            error_log("Generate API token error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verify API token
     */
    public static function verifyAPI($token) {
        $db = Database::getInstance();
        
        try {
            $result = $db->fetch("
                SELECT user_id FROM api_tokens 
                WHERE token = ?
            ", [hash('sha256', $token)]);
            
            return $result ? $result['user_id'] : false;
            
        } catch (Exception $e) {
            error_log("Verify API token error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Generate JWT token
     */
    public static function generateJWT($payload, $secret = null) {
        $secret = $secret ?: getenv('APP_KEY');
        
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($payload);
        
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
    
    /**
     * Verify JWT token
     */
    public static function verifyJWT($jwt, $secret = null) {
        $secret = $secret ?: getenv('APP_KEY');
        
        $tokenParts = explode('.', $jwt);
        if (count($tokenParts) !== 3) {
            return false;
        }
        
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signatureProvided = $tokenParts[2];
        
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        if ($base64UrlSignature === $signatureProvided) {
            return json_decode($payload, true);
        }
        
        return false;
    }
}