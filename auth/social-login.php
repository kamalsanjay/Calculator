<?php
/**
 * Social Login Handler
 * Handle OAuth authentication with Google, Facebook, etc.
 */

require_once '../config.php';
require_once '../includes/functions.php';

$page_title = "Social Login - Calculator";
$error = '';
$provider = $_GET['provider'] ?? '';

// OAuth Configuration
$oauth_config = [
    'google' => [
        'client_id' => getenv('GOOGLE_CLIENT_ID'),
        'client_secret' => getenv('GOOGLE_CLIENT_SECRET'),
        'redirect_uri' => BASE_URL . '/auth/social-login?provider=google',
        'auth_url' => 'https://accounts.google.com/o/oauth2/v2/auth',
        'token_url' => 'https://oauth2.googleapis.com/token',
        'user_info_url' => 'https://www.googleapis.com/oauth2/v2/userinfo',
        'scope' => 'email profile'
    ],
    'facebook' => [
        'client_id' => getenv('FACEBOOK_APP_ID'),
        'client_secret' => getenv('FACEBOOK_APP_SECRET'),
        'redirect_uri' => BASE_URL . '/auth/social-login?provider=facebook',
        'auth_url' => 'https://www.facebook.com/v12.0/dialog/oauth',
        'token_url' => 'https://graph.facebook.com/v12.0/oauth/access_token',
        'user_info_url' => 'https://graph.facebook.com/me',
        'scope' => 'email'
    ]
];

if (!isset($oauth_config[$provider])) {
    $error = "Invalid social login provider.";
} else {
    $config = $oauth_config[$provider];
    
    // Check if returning from OAuth provider
    if (isset($_GET['code'])) {
        $code = $_GET['code'];
        
        // Exchange code for access token
        $token_params = [
            'client_id' => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'redirect_uri' => $config['redirect_uri'],
            'code' => $code,
            'grant_type' => 'authorization_code'
        ];
        
        // Make POST request to get access token
        $ch = curl_init($config['token_url']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $token_data = json_decode($response, true);
        
        if (isset($token_data['access_token'])) {
            $access_token = $token_data['access_token'];
            
            // Get user information
            $user_info_url = $config['user_info_url'];
            if ($provider === 'facebook') {
                $user_info_url .= '?fields=id,name,email&access_token=' . $access_token;
            }
            
            $ch = curl_init($user_info_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if ($provider === 'google') {
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $access_token]);
            }
            $user_info = json_decode(curl_exec($ch), true);
            curl_close($ch);
            
            // Process user information
            $email = $user_info['email'] ?? '';
            $name = $user_info['name'] ?? '';
            $oauth_id = $user_info['id'] ?? '';
            
            if (empty($email)) {
                $error = "Could not retrieve email from " . ucfirst($provider);
            } else {
                try {
                    // Check if user exists
                    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
                    $stmt->execute([$email]);
                    $existing_user = $stmt->fetch();
                    
                    if ($existing_user) {
                        // Login existing user
                        $user_id = $existing_user['id'];
                    } else {
                        // Create new user
                        $username = generate_username($name);
                        $random_password = bin2hex(random_bytes(16));
                        $password_hash = password_hash($random_password, PASSWORD_BCRYPT);
                        
                        $stmt = $db->prepare("
                            INSERT INTO users (username, email, password, role, is_active, email_verified, created_at) 
                            VALUES (?, ?, ?, 3, 1, 1, NOW())
                        ");
                        $stmt->execute([$username, $email, $password_hash]);
                        $user_id = $db->lastInsertId();
                    }
                    
                    // Store OAuth token
                    $stmt = $db->prepare("
                        INSERT INTO oauth_tokens (user_id, provider, provider_user_id, access_token, created_at) 
                        VALUES (?, ?, ?, ?, NOW())
                        ON DUPLICATE KEY UPDATE access_token = VALUES(access_token)
                    ");
                    $stmt->execute([$user_id, $provider, $oauth_id, $access_token]);
                    
                    // Set session
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_role'] = 3;
                    
                    // Redirect to homepage
                    header('Location: /');
                    exit;
                    
                } catch (PDOException $e) {
                    error_log("Social login error: " . $e->getMessage());
                    $error = "An error occurred during login.";
                }
            }
        } else {
            $error = "Failed to authenticate with " . ucfirst($provider);
        }
    } else {
        // Redirect to OAuth provider
        $auth_params = [
            'client_id' => $config['client_id'],
            'redirect_uri' => $config['redirect_uri'],
            'response_type' => 'code',
            'scope' => $config['scope'],
            'state' => bin2hex(random_bytes(16))
        ];
        
        $_SESSION['oauth_state'] = $auth_params['state'];
        
        $auth_url = $config['auth_url'] . '?' . http_build_query($auth_params);
        header('Location: ' . $auth_url);
        exit;
    }
}

// Helper function to generate unique username
function generate_username($name) {
    global $db;
    
    $base_username = strtolower(str_replace(' ', '', $name));
    $username = $base_username;
    $counter = 1;
    
    while (true) {
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if (!$stmt->fetch()) {
            break;
        }
        $username = $base_username . $counter;
        $counter++;
    }
    
    return $username;
}

// Show error if any
if ($error) {
    include '../includes/header.php';
    ?>
    <div class="container py-5">
        <div class="alert alert-error">
            <h4>Social Login Error</h4>
            <p><?php echo $error; ?></p>
            <a href="/auth/login" class="btn btn-primary">Back to Login</a>
        </div>
    </div>
    <?php
    include '../includes/footer.php';
}
?>