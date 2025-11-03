<?php
/**
 * Login API
 * User authentication endpoint
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
if (!isset($input['email']) || !isset($input['password'])) {
    json_response(['error' => 'Email and password are required'], 400);
}

$email = sanitize_input($input['email']);
$password = $input['password'];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_response(['error' => 'Invalid email format'], 400);
}

try {
    $db = Database::getInstance();
    
    // Check for rate limiting
    $ip = get_client_ip();
    $recent_attempts = $db->fetchColumn("
        SELECT COUNT(*) 
        FROM login_attempts 
        WHERE ip_address = ? 
        AND created_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
    ", [$ip]);
    
    if ($recent_attempts >= 5) {
        json_response([
            'error' => 'Too many login attempts',
            'message' => 'Please try again in 15 minutes'
        ], 429);
    }
    
    // Get user
    $user = $db->fetchOne("
        SELECT 
            id,
            username,
            email,
            password,
            role,
            is_active,
            email_verified,
            two_factor_enabled
        FROM users
        WHERE email = ?
    ", [$email]);
    
    // Log attempt
    log_login_attempt($email, $ip, $user ? 'found' : 'not_found');
    
    if (!$user) {
        json_response(['error' => 'Invalid credentials'], 401);
    }
    
    // Check if account is active
    if (!$user['is_active']) {
        json_response(['error' => 'Account is disabled'], 403);
    }
    
    // Verify password
    if (!verify_password($password, $user['password'])) {
        log_login_attempt($email, $ip, 'invalid_password');
        json_response(['error' => 'Invalid credentials'], 401);
    }
    
    // Check if email is verified
    if (!$user['email_verified']) {
        json_response([
            'error' => 'Email not verified',
            'message' => 'Please verify your email address',
            'requires_verification' => true
        ], 403);
    }
    
    // Check if 2FA is enabled
    if ($user['two_factor_enabled']) {
        // Generate 2FA token
        $twofa_token = generate_token(32);
        
        $db->query("
            INSERT INTO two_factor_tokens (user_id, token, expires_at, created_at)
            VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 10 MINUTE), NOW())
        ", [$user['id'], hash('sha256', $twofa_token)]);
        
        json_response([
            'requires_2fa' => true,
            'twofa_token' => $twofa_token,
            'message' => 'Two-factor authentication required'
        ]);
    }
    
    // Generate access token and refresh token
    $access_token = generate_jwt($user['id'], $user['email'], $user['role']);
    $refresh_token = generate_token(64);
    
    // Store refresh token
    $db->query("
        INSERT INTO refresh_tokens (user_id, token, expires_at, created_at)
        VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 30 DAY), NOW())
    ", [$user['id'], hash('sha256', $refresh_token)]);
    
    // Update last login
    $db->query("
        UPDATE users 
        SET last_login = NOW() 
        WHERE id = ?
    ", [$user['id']]);
    
    // Log successful login
    log_activity('login', "User logged in: {$email}", $user['id']);
    
    json_response([
        'success' => true,
        'access_token' => $access_token,
        'refresh_token' => $refresh_token,
        'token_type' => 'Bearer',
        'expires_in' => 3600,
        'user' => [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role']
        ]
    ]);
    
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    json_response([
        'error' => 'Server error',
        'message' => 'An error occurred during login'
    ], 500);
}

/**
 * Generate JWT Token
 */
function generate_jwt(int $user_id, string $email, string $role): string {
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $payload = json_encode([
        'user_id' => $user_id,
        'email' => $email,
        'role' => $role,
        'iat' => time(),
        'exp' => time() + 3600 // 1 hour
    ]);
    
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 
                          getenv('JWT_SECRET') ?: 'your-secret-key', true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    
    return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
}

/**
 * Log Login Attempt
 */
function log_login_attempt(string $email, string $ip, string $status): void {
    try {
        $db = Database::getInstance();
        $db->query("
            INSERT INTO login_attempts (email, ip_address, status, user_agent, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ", [$email, $ip, $status, get_user_agent()]);
    } catch (Exception $e) {
        error_log("Login attempt logging error: " . $e->getMessage());
    }
}
?>