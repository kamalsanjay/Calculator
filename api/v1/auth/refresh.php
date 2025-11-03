<?php
/**
 * Refresh Token API
 * Refresh access token using refresh token
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

if (!$input || !isset($input['refresh_token'])) {
    json_response(['error' => 'Refresh token is required'], 400);
}

$refresh_token = $input['refresh_token'];

try {
    $db = Database::getInstance();
    
    // Find refresh token
    $token_hash = hash('sha256', $refresh_token);
    
    $token_data = $db->fetchOne("
        SELECT rt.*, u.id as user_id, u.email, u.role, u.is_active
        FROM refresh_tokens rt
        JOIN users u ON rt.user_id = u.id
        WHERE rt.token = ?
        AND rt.expires_at > NOW()
        AND rt.revoked = 0
    ", [$token_hash]);
    
    if (!$token_data) {
        json_response(['error' => 'Invalid or expired refresh token'], 401);
    }
    
    // Check if user is active
    if (!$token_data['is_active']) {
        json_response(['error' => 'Account is disabled'], 403);
    }
    
    // Generate new access token
    $access_token = generate_jwt(
        $token_data['user_id'],
        $token_data['email'],
        $token_data['role']
    );
    
    // Optionally rotate refresh token
    $rotate_refresh = $input['rotate'] ?? false;
    $new_refresh_token = null;
    
    if ($rotate_refresh) {
        // Revoke old token
        $db->query("
            UPDATE refresh_tokens 
            SET revoked = 1 
            WHERE token = ?
        ", [$token_hash]);
        
        // Generate new refresh token
        $new_refresh_token = generate_token(64);
        
        $db->query("
            INSERT INTO refresh_tokens (user_id, token, expires_at, created_at)
            VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 30 DAY), NOW())
        ", [$token_data['user_id'], hash('sha256', $new_refresh_token)]);
    }
    
    $response = [
        'success' => true,
        'access_token' => $access_token,
        'token_type' => 'Bearer',
        'expires_in' => 3600
    ];
    
    if ($new_refresh_token) {
        $response['refresh_token'] = $new_refresh_token;
    }
    
    json_response($response);
    
} catch (Exception $e) {
    error_log("Token refresh error: " . $e->getMessage());
    json_response([
        'error' => 'Server error',
        'message' => 'An error occurred during token refresh'
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
        'exp' => time() + 3600
    ]);
    
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload,
                          getenv('JWT_SECRET') ?: 'your-secret-key', true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    
    return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
}
?>