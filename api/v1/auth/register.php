<?php
/**
 * Register API
 * User registration endpoint
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

// Validate required fields
$required_fields = ['username', 'email', 'password'];
foreach ($required_fields as $field) {
    if (!isset($input[$field]) || empty($input[$field])) {
        json_response(['error' => "Field '{$field}' is required"], 400);
    }
}

$username = sanitize_input($input['username']);
$email = sanitize_input($input['email']);
$password = $input['password'];

// Validate username
if (strlen($username) < 3 || strlen($username) > 50) {
    json_response(['error' => 'Username must be between 3 and 50 characters'], 400);
}

if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    json_response(['error' => 'Username can only contain letters, numbers, and underscores'], 400);
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_response(['error' => 'Invalid email format'], 400);
}

// Validate password strength
if (strlen($password) < 8) {
    json_response(['error' => 'Password must be at least 8 characters'], 400);
}

if (!preg_match('/[A-Z]/', $password)) {
    json_response(['error' => 'Password must contain at least one uppercase letter'], 400);
}

if (!preg_match('/[a-z]/', $password)) {
    json_response(['error' => 'Password must contain at least one lowercase letter'], 400);
}

if (!preg_match('/[0-9]/', $password)) {
    json_response(['error' => 'Password must contain at least one number'], 400);
}

if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
    json_response(['error' => 'Password must contain at least one special character'], 400);
}

try {
    $db = Database::getInstance();
    
    // Check if username exists
    $existing_username = $db->fetchColumn("
        SELECT COUNT(*) FROM users WHERE username = ?
    ", [$username]);
    
    if ($existing_username > 0) {
        json_response(['error' => 'Username already taken'], 409);
    }
    
    // Check if email exists
    $existing_email = $db->fetchColumn("
        SELECT COUNT(*) FROM users WHERE email = ?
    ", [$email]);
    
    if ($existing_email > 0) {
        json_response(['error' => 'Email already registered'], 409);
    }
    
    // Hash password
    $password_hash = hash_password($password);
    
    // Generate verification token
    $verification_token = generate_token(32);
    
    // Insert user
    $db->query("
        INSERT INTO users (
            username,
            email,
            password,
            role,
            email_verified,
            verification_token,
            is_active,
            created_at
        ) VALUES (?, ?, ?, 'user', 0, ?, 1, NOW())
    ", [$username, $email, $password_hash, $verification_token]);
    
    $user_id = $db->lastInsertId();
    
    // Send verification email
    send_verification_email($email, $username, $verification_token);
    
    // Log registration
    log_activity('register', "New user registered: {$email}", $user_id);
    
    json_response([
        'success' => true,
        'message' => 'Registration successful. Please check your email to verify your account.',
        'user' => [
            'id' => $user_id,
            'username' => $username,
            'email' => $email
        ],
        'requires_verification' => true
    ], 201);
    
} catch (Exception $e) {
    error_log("Registration error: " . $e->getMessage());
    json_response([
        'error' => 'Server error',
        'message' => 'An error occurred during registration'
    ], 500);
}

/**
 * Send Verification Email
 */
function send_verification_email(string $email, string $username, string $token): void {
    $verification_url = "https://" . $_SERVER['HTTP_HOST'] . "/verify-email?token=" . $token;
    
    $subject = "Verify Your Email - Calculator";
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
            .footer { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Welcome to Calculator!</h1>
            </div>
            <div class='content'>
                <h2>Hi {$username},</h2>
                <p>Thank you for registering with Calculator. Please verify your email address to activate your account.</p>
                <p style='text-align: center;'>
                    <a href='{$verification_url}' class='button'>Verify Email Address</a>
                </p>
                <p>Or copy and paste this link into your browser:</p>
                <p style='word-break: break-all; background: white; padding: 10px; border-radius: 5px;'>{$verification_url}</p>
                <p>This link will expire in 24 hours.</p>
                <p>If you didn't create an account, please ignore this email.</p>
            </div>
            <div class='footer'>
                <p>&copy; " . date('Y') . " Calculator. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    send_email($email, $subject, $message);
}
?>