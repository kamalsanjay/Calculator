<?php
/**
 * User Login Page
 * Handles user authentication
 */

require_once '../config.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}

$page_title = "Login - Calculator";
$error = '';
$success = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    // Validate inputs
    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        try {
            // Check login attempts
            $stmt = $db->prepare("
                SELECT COUNT(*) as attempts 
                FROM login_attempts 
                WHERE email = ? AND created_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
            ");
            $stmt->execute([$email]);
            $attempts = $stmt->fetch()['attempts'];
            
            if ($attempts >= 5) {
                $error = "Too many login attempts. Please try again in 15 minutes.";
            } else {
                // Get user by email
                $stmt = $db->prepare("
                    SELECT id, username, email, password, role, is_active, email_verified 
                    FROM users 
                    WHERE email = ?
                ");
                $stmt->execute([$email]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password'])) {
                    // Check if account is active
                    if (!$user['is_active']) {
                        $error = "Your account has been deactivated. Please contact support.";
                    } 
                    // Check if email is verified
                    elseif (!$user['email_verified'] && REQUIRE_EMAIL_VERIFICATION) {
                        $error = "Please verify your email address before logging in.";
                    } 
                    else {
                        // Successful login
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_email'] = $user['email'];
                        $_SESSION['user_role'] = $user['role'];
                        $_SESSION['username'] = $user['username'];
                        
                        // Update last login
                        $stmt = $db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                        $stmt->execute([$user['id']]);
                        
                        // Handle remember me
                        if ($remember) {
                            $token = bin2hex(random_bytes(32));
                            setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', true, true);
                            
                            // Store token in database
                            $stmt = $db->prepare("
                                INSERT INTO remember_tokens (user_id, token, expires_at) 
                                VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 30 DAY))
                            ");
                            $stmt->execute([$user['id'], hash('sha256', $token)]);
                        }
                        
                        // Redirect to intended page or homepage
                        $redirect = $_GET['redirect'] ?? '/';
                        header('Location: ' . $redirect);
                        exit;
                    }
                } else {
                    // Log failed attempt
                    $stmt = $db->prepare("
                        INSERT INTO login_attempts (email, ip_address, user_agent, created_at) 
                        VALUES (?, ?, ?, NOW())
                    ");
                    $stmt->execute([$email, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']]);
                    
                    $error = "Invalid email or password.";
                }
            }
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            $error = "An error occurred. Please try again.";
        }
    }
}

include '../includes/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Welcome Back</h1>
            <p>Login to access your account</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['verified'])): ?>
            <div class="alert alert-success">Email verified successfully! You can now login.</div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    required 
                    autofocus
                    value="<?php echo htmlspecialchars($email ?? ''); ?>"
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    required
                >
            </div>

            <div class="form-group form-check">
                <input 
                    type="checkbox" 
                    id="remember" 
                    name="remember" 
                    class="form-check-input"
                >
                <label for="remember" class="form-check-label">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <div class="auth-links">
            <a href="/auth/forgot-password">Forgot password?</a>
            <span>·</span>
            <a href="/auth/register">Create an account</a>
        </div>

        <!-- Social Login -->
        <div class="social-login">
            <div class="divider">
                <span>Or continue with</span>
            </div>
            <div class="social-buttons">
                <a href="/auth/social-login?provider=google" class="btn btn-social btn-google">
                    <i class="fab fa-google"></i> Google
                </a>
                <a href="/auth/social-login?provider=facebook" class="btn btn-social btn-facebook">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 2rem;
}

.auth-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    padding: 3rem;
    width: 100%;
    max-width: 450px;
}

.auth-header {
    text-align: center;
    margin-bottom: 2rem;
}

.auth-header h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #343a40;
    margin-bottom: 0.5rem;
}

.auth-header p {
    color: #6c757d;
    font-size: 1rem;
}

.auth-form .form-group {
    margin-bottom: 1.5rem;
}

.auth-form label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #343a40;
}

.auth-form .form-control {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    font-size: 1rem;
    transition: 0.3s ease;
}

.auth-form .form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-check {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-block {
    width: 100%;
}

.auth-links {
    text-align: center;
    margin-top: 1.5rem;
    font-size: 0.9rem;
}

.auth-links a {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
}

.auth-links a:hover {
    text-decoration: underline;
}

.social-login {
    margin-top: 2rem;
}

.divider {
    text-align: center;
    margin: 2rem 0 1rem;
    position: relative;
}

.divider span {
    background: white;
    padding: 0 1rem;
    color: #6c757d;
    font-size: 0.9rem;
}

.divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #dee2e6;
    z-index: -1;
}

.social-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.btn-social {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s ease;
    text-decoration: none;
}

.btn-google {
    color: #ea4335;
}

.btn-google:hover {
    background: #ea4335;
    color: white;
    border-color: #ea4335;
}

.btn-facebook {
    color: #1877f2;
}

.btn-facebook:hover {
    background: #1877f2;
    color: white;
    border-color: #1877f2;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.alert-error {
    background: #fee;
    color: #c33;
    border: 1px solid #fcc;
}

.alert-success {
    background: #efe;
    color: #3c3;
    border: 1px solid #cfc;
}

@media (max-width: 576px) {
    .auth-card {
        padding: 2rem;
    }
    
    .social-buttons {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include '../includes/footer.php'; ?>