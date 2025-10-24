<?php
/**
 * Admin Login Page
 * Secure authentication with session management and CSRF protection
 */

session_start();
require_once '../config/database.php';
require_once '../includes/security.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit();
}

$error = '';
$success = '';

// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Invalid request. Please try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember_me']);

        if (empty($username) || empty($password)) {
            $error = 'Please enter both username and password.';
        } else {
            // Check login attempts
            if (checkLoginAttempts($username)) {
                $error = 'Too many failed login attempts. Please try again in 15 minutes.';
            } else {
                // Authenticate user
                $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ? AND status = 'active' LIMIT 1");
                $stmt->execute([$username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    // Successful login
                    clearLoginAttempts($username);
                    
                    // Regenerate session ID
                    session_regenerate_id(true);
                    
                    // Set session variables
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_username'] = $user['username'];
                    $_SESSION['admin_role'] = $user['role'];
                    $_SESSION['admin_email'] = $user['email'];
                    $_SESSION['login_time'] = time();
                    $_SESSION['last_activity'] = time();

                    // Update last login
                    $updateStmt = $pdo->prepare("UPDATE admin_users SET last_login = NOW(), login_ip = ? WHERE id = ?");
                    $updateStmt->execute([getClientIP(), $user['id']]);

                    // Log activity
                    logActivity($user['id'], 'login', 'User logged in successfully');

                    // Handle remember me
                    if ($remember) {
                        $token = bin2hex(random_bytes(32));
                        $expiry = time() + (30 * 24 * 60 * 60); // 30 days
                        
                        // Store token in database
                        $tokenStmt = $pdo->prepare("INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?, ?, FROM_UNIXTIME(?))");
                        $tokenStmt->execute([$user['id'], hash('sha256', $token), $expiry]);
                        
                        // Set cookie
                        setcookie('remember_token', $token, $expiry, '/', '', true, true);
                    }

                    header('Location: index.php');
                    exit();
                } else {
                    // Failed login
                    recordLoginAttempt($username);
                    $error = 'Invalid username or password.';
                    
                    // Log failed attempt
                    logActivity(0, 'failed_login', "Failed login attempt for username: {$username}");
                }
            }
        }
    }
}

// Check remember me cookie
if (isset($_COOKIE['remember_token']) && !isset($_SESSION['admin_logged_in'])) {
    $token = $_COOKIE['remember_token'];
    $hashedToken = hash('sha256', $token);
    
    $stmt = $pdo->prepare("
        SELECT u.* FROM admin_users u
        INNER JOIN remember_tokens t ON u.id = t.user_id
        WHERE t.token = ? AND t.expires_at > NOW() AND u.status = 'active'
        LIMIT 1
    ");
    $stmt->execute([$hashedToken]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // Auto login
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_role'] = $user['role'];
        $_SESSION['admin_email'] = $user['email'];
        $_SESSION['login_time'] = time();
        $_SESSION['last_activity'] = time();
        
        header('Location: index.php');
        exit();
    } else {
        // Invalid or expired token
        setcookie('remember_token', '', time() - 3600, '/', '', true, true);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Calculator Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --danger-color: #e74a3b;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            max-width: 450px;
            width: 100%;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .login-header i {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .login-body {
            padding: 40px;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn-login {
            background: var(--primary-color);
            border: none;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: #224abe;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }

        .input-group-text {
            background-color: #f8f9fc;
            border-right: none;
        }

        .form-control {
            border-left: none;
        }

        .alert {
            border-radius: 10px;
        }

        .remember-me {
            user-select: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-shield-halved"></i>
                <h2 class="mb-0">Admin Panel</h2>
                <p class="mb-0 mt-2">Calculator Website</p>
            </div>

            <div class="login-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo htmlspecialchars($success); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" id="loginForm">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control" name="username" required 
                                   placeholder="Enter username" autocomplete="username">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" name="password" required 
                                   placeholder="Enter password" autocomplete="current-password" id="password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3 form-check remember-me">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="remember_me">
                        <label class="form-check-label" for="rememberMe">
                            Remember me for 30 days
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <a href="forgot-password.php" class="text-decoration-none">
                        <i class="fas fa-key me-1"></i>Forgot Password?
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-3 text-white">
            <small>&copy; <?php echo date('Y'); ?> Calculator Website. All rights reserved.</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Auto-dismiss alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>
<?php
/**
 * Security Helper Functions
 */

function checkLoginAttempts($username) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as attempts 
        FROM login_attempts 
        WHERE username = ? AND attempt_time > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
    ");
    $stmt->execute([$username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['attempts'] >= 5;
}

function recordLoginAttempt($username) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO login_attempts (username, ip_address) VALUES (?, ?)");
    $stmt->execute([$username, getClientIP()]);
}

function clearLoginAttempts($username) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE username = ?");
    $stmt->execute([$username]);
}

function getClientIP() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
}

function logActivity($userId, $action, $description, $metadata = null) {
    global $pdo;
    $stmt = $pdo->prepare("
        INSERT INTO activity_log (user_id, action, description, ip_address, user_agent, metadata) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $userId,
        $action,
        $description,
        getClientIP(),
        $_SERVER['HTTP_USER_AGENT'] ?? '',
        $metadata ? json_encode($metadata) : null
    ]);
}
?>  
