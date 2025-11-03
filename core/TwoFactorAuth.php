<?php
/**
 * Two-Factor Authentication Class
 * Implements TOTP-based 2FA
 */

class TwoFactorAuth {
    private $db;
    private $codeLength = 6;
    private $period = 30; // seconds
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Generate secret key
     */
    public function generateSecret($length = 32) {
        return base64_encode(random_bytes($length));
    }
    
    /**
     * Enable 2FA for user
     */
    public function enable($userId, $secret) {
        try {
            $this->db->query("
                INSERT INTO two_factor_auth (user_id, secret, enabled) 
                VALUES (?, ?, 1)
                ON DUPLICATE KEY UPDATE secret = VALUES(secret), enabled = 1
            ", [$userId, $secret]);
            
            return true;
        } catch (Exception $e) {
            error_log("Enable 2FA error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Disable 2FA for user
     */
    public function disable($userId) {
        try {
            $this->db->update('two_factor_auth', [
                'enabled' => 0
            ], 'user_id = ?', [$userId]);
            
            return true;
        } catch (Exception $e) {
            error_log("Disable 2FA error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if 2FA is enabled
     */
    public function isEnabled($userId) {
        try {
            $result = $this->db->fetch("
                SELECT enabled FROM two_factor_auth WHERE user_id = ?
            ", [$userId]);
            
            return $result && $result['enabled'];
        } catch (Exception $e) {
            error_log("Check 2FA error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get secret for user
     */
    public function getSecret($userId) {
        try {
            $result = $this->db->fetch("
                SELECT secret FROM two_factor_auth WHERE user_id = ?
            ", [$userId]);
            
            return $result ? $result['secret'] : null;
        } catch (Exception $e) {
            error_log("Get 2FA secret error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Generate TOTP code
     */
    public function generateCode($secret) {
        $time = floor(time() / $this->period);
        $secret = base64_decode($secret);
        
        $hash = hash_hmac('sha1', pack('N*', 0) . pack('N*', $time), $secret, true);
        $offset = ord($hash[19]) & 0xf;
        
        $code = (
            ((ord($hash[$offset]) & 0x7f) << 24) |
            ((ord($hash[$offset + 1]) & 0xff) << 16) |
            ((ord($hash[$offset + 2]) & 0xff) << 8) |
            (ord($hash[$offset + 3]) & 0xff)
        ) % pow(10, $this->codeLength);
        
        return str_pad($code, $this->codeLength, '0', STR_PAD_LEFT);
    }
    
    /**
     * Verify TOTP code
     */
    public function verify($userId, $code) {
        $secret = $this->getSecret($userId);
        
        if (!$secret) {
            return false;
        }
        
        // Check current time window and adjacent windows
        for ($i = -1; $i <= 1; $i++) {
            $time = floor(time() / $this->period) + $i;
            $expectedCode = $this->generateCodeForTime($secret, $time);
            
            if (hash_equals($expectedCode, $code)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Generate code for specific time
     */
    private function generateCodeForTime($secret, $time) {
        $secret = base64_decode($secret);
        
        $hash = hash_hmac('sha1', pack('N*', 0) . pack('N*', $time), $secret, true);
        $offset = ord($hash[19]) & 0xf;
        
        $code = (
            ((ord($hash[$offset]) & 0x7f) << 24) |
            ((ord($hash[$offset + 1]) & 0xff) << 16) |
            ((ord($hash[$offset + 2]) & 0xff) << 8) |
            (ord($hash[$offset + 3]) & 0xff)
        ) % pow(10, $this->codeLength);
        
        return str_pad($code, $this->codeLength, '0', STR_PAD_LEFT);
    }
    
    /**
     * Generate QR code URL
     */
    public function getQRCodeUrl($secret, $email, $issuer = 'Calculator') {
        $otpauth = "otpauth://totp/{$issuer}:{$email}?secret={$secret}&issuer={$issuer}";
        return "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=" . urlencode($otpauth);
    }
    
    /**
     * Generate backup codes
     */
    public function generateBackupCodes($userId, $count = 10) {
        $codes = [];
        
        for ($i = 0; $i < $count; $i++) {
            $codes[] = strtoupper(bin2hex(random_bytes(4)));
        }
        
        try {
            // Store hashed backup codes
            foreach ($codes as $code) {
                $this->db->insert('backup_codes', [
                    'user_id' => $userId,
                    'code' => hash('sha256', $code),
                    'used' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
            
            return $codes;
        } catch (Exception $e) {
            error_log("Generate backup codes error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Verify backup code
     */
    public function verifyBackupCode($userId, $code) {
        try {
            $result = $this->db->fetch("
                SELECT id FROM backup_codes 
                WHERE user_id = ? AND code = ? AND used = 0
            ", [$userId, hash('sha256', $code)]);
            
            if ($result) {
                // Mark as used
                $this->db->update('backup_codes', [
                    'used' => 1
                ], 'id = ?', [$result['id']]);
                
                return true;
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Verify backup code error: " . $e->getMessage());
            return false;
        }
    }
}