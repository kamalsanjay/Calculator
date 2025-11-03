<?php
/**
 * Password Reset API
 * Request and process password resets
 */

declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../../../config.php';
require_once '../../../includes/functions.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['error' => 'Method not allowed'], 405);
}

// Get request data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    json_response(['error' => 'Invalid JSON'], 400);
}

$action = $input['action'] ?? 'request';

try {
    if ($action === 'request') {
        handle_password_reset_request($input);
    } elseif ($action === 'reset') {
        handle_password_reset($input);
    } else {
        json_response(['error' => 'Invalid action'], 400);
    }
} catch (Exception $e) {
    error_log("Password reset error: " . $e->getMessage());
    json_response([
        'error' => 'Server error',
        'message' => 'An error occurred'
    ], 500);
}

/**
 * Handle Password Reset Request
 */
function handle_password_reset_request(array $input): void {
    if (!isset($input['email'])) {
        json_response(['error' => 'Email is required'], 400);
    }
    
    $email = sanitize_input($input['email']);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        json_response(['error' => 'Invalid email format'], 400);
    }
    
    $db = Database::getInstance();
    
    // Check if user exists
    $user = $db->fetchOne("
        SELECT id, username, email
        FROM users
        WHERE email = ?
        AND is_active = 1
    ", [$email]);
    
    // Always return success to prevent email enumeration
    if (!$user) {
        json_response([
            'success' => true,
            'message' => 'If an account exists with this email, a password reset link has been sent.'
        ]);
    }
    
    // Generate reset token
    $reset_token = generate_token(32);
    $token_hash = hash('sha256', $reset_token);
    
    // Store token
    $db->query("
        INSERT INTO password_reset_tokens (user_id, token, expires_at, created_at)
        VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR), NOW())
    ", [$user['id'], $token_hash]);
    
    // Send reset email
    send_password_reset_email($user['email'], $user['username'], $reset_token);
    
    // Log request
    log_activity('password_reset_request', "Password reset requested for: {$email}", $user['id']);
    
    json_response([
        'success' => true,
        'message' => 'If an account exists with this email, a password reset link has been sent.'
    ]);
}

/**
 * Handle Password Reset
 */
function handle_password_reset(array $input): void {
    if (!isset($input['token']) || !isset($input['password'])) {
        json_response(['error' => 'Token and password are required'], 400);
    }
    
    $token = $input['token'];
    $password = $input['password'];
    
    // Validate password strength
    if (strlen($password) < 8) {
        json_response(['error' => 'Password must be at least 8 characters'], 400);
    }
    
    if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) ||
        !preg_match('/[0-9]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
        json_response(['error' => 'Password must contain uppercase, lowercase, number, and special character'], 400);
    }
    
    $db = Database::getInstance();
    $token_hash = hash('sha256', $token);
    
    // Find token
    $reset_data = $db->fetchOne("
        SELECT prt.*, u.id as user_id, u.email
        FROM password_reset_tokens prt
        JOIN users u ON prt.user_id = u.id
        WHERE prt.token = ?
        AND prt.expires_at > NOW()
        AND prt.used = 0
    ", [$token_hash]);
    
    if (!$reset_data) {
        json_response(['error' => 'Invalid or expired reset token'], 404);
    }
    
    // Hash new password
    $password_hash = hash_password($password);
    
    // Update password
    $db->query("
        UPDATE users
        SET password = ?,
            updated_at = NOW()
        WHERE id = ?
    ", [$password_hash, $reset_data['user_id']]);
    
    // Mark token as used
    $db->query("
        UPDATE password_reset_tokens
        SET used = 1
        WHERE token = ?
    ", [$token_hash]);
    
    // Revoke all refresh tokens
    $db->query("
        UPDATE refresh_tokens
        SET revoked = 1
        WHERE user_id = ?
    ", [$reset_data['user_id']]);
    
    // Log reset
    log_activity('password_reset', "Password reset completed", $reset_data['user_id']);
    
    // Send confirmation email
    send_password_changed_email($reset_data['email']);
    
    json_response([
        'success' => true,
        'message' => 'Password has been reset successfully'
    ]);
}

/**
 * Send Password Reset Email
 */
function send_password_reset_email(string $email, string $username, string $token): void {
    $reset_url = "https://" . $_SERVER['HTTP_HOST'] . "/reset-password?token=" . $token;
    
    $subject = "Password Reset Request - Calculator";
    $message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #dc3545; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
            .button { display: inline-block; background: #dc3545; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
            .warning { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 5px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>🔒 Password Reset Request</h1>
            </div>
            <div class='content'>
                <h2>Hi {$username},</h2>
                <p>We received a request to reset your password. Click the button below to create a new password:</p>
                <p style='text-align: center;'>
                    <a href='{$reset_url}' class='button'>Reset Password</a>
                </p>
                <p>Or copy and paste this link:</p>
                <p style='word-break: break-all; background: white; padding: 10px; border-radius: 5px;'>{$reset_url}</p>
                
                <div class='warning'>
                    <strong>⚠️ Security Note:</strong><br>
                    This link will expire in 1 hour. If you didn't request this reset, please ignore this email and ensure your account is secure.
                </div>
                
                <p>If you have any concerns about your account security, please contact our support team immediately.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    send_email($email, $subject, $message);
}

/**
 * Send Password Changed Email
 */
function send_password_changed_email(string $email): void {
    $subject = "Password Changed - Calculator";
    $message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #28a745; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
            .info { background: #d1ecf1; border-left: 4px solid #17a2b8; padding: 15px; margin: 20px 0; border-radius: 5px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>✓ Password Changed Successfully</h1>
            </div>
            <div class='content'>
                <p>Your password has been changed successfully.</p>
                
                <div class='info'>
                    <strong>ℹ️ Important:</strong><br>
                    If you did not make this change, please contact our support team immediately at support@calculator.com
                </div>
                
                <p>For security reasons, all active sessions have been logged out. Please log in again with your new password.</p>
                
                <p><strong>Change Details:</strong></p>
                <ul>
                    <li>Date: " . date('F j, Y, g:i a') . "</li>
                    <li>IP Address: " . get_client_ip() . "</li>
                </ul>
            </div>
        </div>
    </body>
    </html>
    ";
    
    send_email($email, $subject, $message);
}
?>