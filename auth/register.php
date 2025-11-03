<?php
/**
 * User Registration Page
 * Handles new user account creation
 */

require_once '../config.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}

$page_title = "Register - Calculator";
$error = '';
$success = '';

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_input($_POST['username'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $agree_terms = isset($_POST['agree_terms']);
    
    // Validate inputs
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $error = "Username must be between 3 and 50 characters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (!$agree_terms) {
        $error = "You must agree to the terms and conditions.";
    } else {
        try {
            // Check if email already exists
            $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = "Email address already registered.";
            } else {
                // Check if username already exists
                $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->execute([$username]);
                if ($stmt->fetch()) {
                    $error = "Username already taken.";
                } else {
                    // Create user account
                    $password_hash = password_hash($password, PASSWORD_BCRYPT);
                    $verification_token = bin2hex(random_bytes(32));
                    
                    $stmt = $db->prepare("
                        INSERT INTO users (username, email, password, role, is_active, email_verified, created_at) 
                        VALUES (?, ?, ?, 3, 1, 0, NOW())
                    ");
                    $stmt->execute([$username, $email, $password_hash]);
                    $user_id = $db->lastInsertId();
                    
                    // Store verification token
                    $stmt = $db->prepare("
                        INSERT INTO email_verifications (user_id, token, expires_at) 
                        VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 24 HOUR))
                    ");
                    $stmt->execute([$user_id, hash('sha256', $verification_token)]);
                    
                    // Send verification email
                    $verification_link = BASE_URL . "/auth/verify-email?token=" . $verification_token;
                    
                    // TODO: Send email using mail function or PHPMailer
                    // For now, just show success message
                    
                    $success = "Registration successful! Please check your email to verify your account.";
                    
                    // Clear form
                    $username = $email = '';
                }
            }
        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            $error = "An error occurred. Please try again.";
        }
    }
}

include '../includes/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Create Account</h1>
            <p>Join thousands of users today</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="form-control" 
                    required 
                    minlength="3"
                    maxlength="50"
                    value="<?php echo htmlspecialchars($username ?? ''); ?>"
                >
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    required
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
                    minlength="8"
                >
                <small class="form-text">Minimum 8 characters</small>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password" 
                    class="form-control" 
                    required
                >
            </div>

            <div class="form-group form-check">
                <input 
                    type="checkbox" 
                    id="agree_terms" 
                    name="agree_terms" 
                    class="form-check-input"
                    required
                >
                <label for="agree_terms" class="form-check-label">
                    I agree to the <a href="/terms">Terms & Conditions</a>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
        </form>

        <div class="auth-links">
            Already have an account? <a href="/auth/login">Login</a>
        </div>

        <!-- Social Login -->
        <div class="social-login">
            <div class="divider">
                <span>Or register with</span>
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
/* Reuse styles from login.php */
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

.form-text {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #6c757d;
}

/* ... (include all other styles from login.php) ... */
</style>

<?php include '../includes/footer.php'; ?>