<?php
/**
 * Email Verification API
 * Verify user email address
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

// Allow both GET and POST
if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'])) {
    json_response(['error' => 'Method not allowed'], 405);
}

// Get token
$token = null;
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_GET['token'] ?? null;
} else {
    $input = json_decode(file_get_contents('php://input'), true);
    $token = $input['token'] ?? null;
}

if (!$token) {
    json_response(['error' => 'Verification token is required'], 400);
}

try {
    $db = Database::getInstance();
    
    // Find user with this token
    $user = $db->fetchOne("
        SELECT id, username, email, email_verified
        FROM users
        WHERE verification_token = ?
        AND is_active = 1
    ", [$token]);
    
    if (!$user) {
        json_response(['error' => 'Invalid or expired verification token'], 404);
    }
    
    // Check if already verified
    if ($user['email_verified']) {
        json_response([
            'success' => true,
            'message' => 'Email already verified',
            'already_verified' => true
        ]);
    }
    
    // Verify email
    $db->query("
        UPDATE users
        SET email_verified = 1,
            verification_token = NULL,
            email_verified_at = NOW()
        WHERE id = ?
    ", [$user['id']]);
    
    // Log verification
    log_activity('email_verified', "Email verified: {$user['email']}", $user['id']);
    
    // Send welcome email
    send_welcome_email($user['email'], $user['username']);
    
    json_response([
        'success' => true,
        'message' => 'Email verified successfully',
        'user' => [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email']
        ]
    ]);
    
} catch (Exception $e) {
    error_log("Email verification error: " . $e->getMessage());
    json_response([
        'error' => 'Server error',
        'message' => 'An error occurred during verification'
    ], 500);
}

/**
 * Send Welcome Email
 */
function send_welcome_email(string $email, string $username): void {
    $subject = "Welcome to Calculator!";
    $message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
            .button { display: inline-block; background: #007bff; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
            .features { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
            .feature { margin: 10px 0; padding-left: 25px; position: relative; }
            .feature:before { content: '✓'; position: absolute; left: 0; color: #28a745; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>🎉 Welcome to Calculator!</h1>
            </div>
            <div class='content'>
                <h2>Hi {$username},</h2>
                <p>Your email has been verified successfully! You now have full access to all our features.</p>
                
                <div class='features'>
                    <h3>What you can do:</h3>
                    <div class='feature'>Access 300+ professional calculators</div>
                    <div class='feature'>Save your calculations</div>
                    <div class='feature'>Track your history</div>
                    <div class='feature'>Get personalized recommendations</div>
                    <div class='feature'>Export results to PDF</div>
                </div>
                
                <p style='text-align: center;'>
                    <a href='https://{$_SERVER['HTTP_HOST']}' class='button'>Start Calculating</a>
                </p>
                
                <p>If you have any questions, feel free to contact our support team.</p>
                <p>Happy calculating!</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    send_email($email, $subject, $message);
}
?>