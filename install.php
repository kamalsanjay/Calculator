<?php
/**
 * Automatic Installation Script
 * Sets up the Calculator website database and configuration
 * Fixed for XAMPP/Apache compatibility
 */

// Prevent running in production
if (file_exists('config.php') && !isset($_GET['force'])) {
    die('Installation already completed. Delete config.php or add ?force=1 to reinstall.');
}

// Start session
session_start();

// Installation steps
$step = $_GET['step'] ?? 1;
$errors = [];
$success = [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator Installation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .install-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 900px;
            width: 100%;
            overflow: hidden;
        }

        .install-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .install-header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .install-header p {
            opacity: 0.9;
        }

        .progress-bar {
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: #28a745;
            transition: width 0.3s ease;
        }

        .install-body {
            padding: 2rem;
            max-height: 70vh;
            overflow-y: auto;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .step {
            flex: 1;
            text-align: center;
            padding: 1rem;
            border-radius: 8px;
            background: #f8f9fa;
            margin: 0.25rem;
            position: relative;
            min-width: 100px;
        }

        .step.active {
            background: #007bff;
            color: white;
        }

        .step.completed {
            background: #28a745;
            color: white;
        }

        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .step.completed .step-number::before {
            content: '✓';
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #007bff;
        }

        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.25rem;
            display: block;
        }

        .btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .alert ul {
            margin: 10px 0 0 20px;
        }

        .requirements-list {
            list-style: none;
            padding: 0;
        }

        .requirements-list li {
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .status-icon {
            font-size: 1.25rem;
        }

        .status-icon.success {
            color: #28a745;
        }

        .status-icon.error {
            color: #dc3545;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 3rem;
            color: white;
        }

        .code-block {
            background: #2d3748;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 8px;
            font-family: monospace;
            overflow-x: auto;
            margin: 1rem 0;
        }

        @media (max-width: 768px) {
            .step {
                font-size: 0.875rem;
            }
            
            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="install-container">
        <div class="install-header">
            <h1><i class="fas fa-calculator"></i> Calculator Installation</h1>
            <p>Complete setup wizard for your calculator website</p>
        </div>

        <div class="progress-bar">
            <div class="progress-fill" style="width: <?php echo ($step / 5) * 100; ?>%"></div>
        </div>

        <div class="install-body">
            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step <?php echo $step >= 1 ? 'active' : ''; ?> <?php echo $step > 1 ? 'completed' : ''; ?>">
                    <div class="step-number"><?php echo $step > 1 ? '' : '1'; ?></div>
                    <div>Requirements</div>
                </div>
                <div class="step <?php echo $step >= 2 ? 'active' : ''; ?> <?php echo $step > 2 ? 'completed' : ''; ?>">
                    <div class="step-number"><?php echo $step > 2 ? '' : '2'; ?></div>
                    <div>Database</div>
                </div>
                <div class="step <?php echo $step >= 3 ? 'active' : ''; ?> <?php echo $step > 3 ? 'completed' : ''; ?>">
                    <div class="step-number"><?php echo $step > 3 ? '' : '3'; ?></div>
                    <div>Admin</div>
                </div>
                <div class="step <?php echo $step >= 4 ? 'active' : ''; ?> <?php echo $step > 4 ? 'completed' : ''; ?>">
                    <div class="step-number"><?php echo $step > 4 ? '' : '4'; ?></div>
                    <div>Install</div>
                </div>
                <div class="step <?php echo $step >= 5 ? 'active' : ''; ?>">
                    <div class="step-number">5</div>
                    <div>Complete</div>
                </div>
            </div>

            <?php
            // STEP 1: Check Requirements
            if ($step == 1) {
                $requirements = [
                    'PHP Version >= 8.0' => version_compare(PHP_VERSION, '8.0.0', '>='),
                    'PDO Extension' => extension_loaded('pdo'),
                    'PDO MySQL Extension' => extension_loaded('pdo_mysql'),
                    'MySQLi Extension' => extension_loaded('mysqli'),
                    'JSON Extension' => extension_loaded('json'),
                    'cURL Extension' => extension_loaded('curl'),
                    'MBString Extension' => extension_loaded('mbstring'),
                    'OpenSSL Extension' => extension_loaded('openssl'),
                    'Writable Directory' => is_writable(__DIR__)
                ];

                $all_passed = !in_array(false, $requirements);
                ?>

                <h2>System Requirements Check</h2>
                <p>Checking if your server meets the minimum requirements...</p>

                <ul class="requirements-list">
                    <?php foreach ($requirements as $name => $status): ?>
                    <li>
                        <span><?php echo $name; ?></span>
                        <span class="status-icon <?php echo $status ? 'success' : 'error'; ?>">
                            <?php echo $status ? '✓' : '✗'; ?>
                        </span>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <?php if ($all_passed): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> All requirements met! You can proceed with installation.
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> Some requirements are not met. Please fix them before continuing.
                    </div>
                <?php endif; ?>

                <div class="button-group">
                    <?php if ($all_passed): ?>
                    <a href="install.php?step=2" class="btn btn-primary">
                        Continue <i class="fas fa-arrow-right"></i>
                    </a>
                    <?php else: ?>
                    <button onclick="location.reload()" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Recheck
                    </button>
                    <?php endif; ?>
                </div>

                <?php
            }

            // STEP 2: Database Configuration
            elseif ($step == 2) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_connection'])) {
                    $db_host = trim($_POST['db_host']);
                    $db_name = trim($_POST['db_name']);
                    $db_user = trim($_POST['db_user']);
                    $db_pass = $_POST['db_pass'];

                    try {
                        // Try connecting to MySQL server
                        $dsn = "mysql:host=$db_host;charset=utf8mb4";
                        $pdo = new PDO(
                            $dsn,
                            $db_user,
                            $db_pass,
                            [
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                            ]
                        );

                        // Create database if it doesn't exist
                        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                        
                        // Use the database
                        $pdo->exec("USE `$db_name`");

                        // Store in session
                        $_SESSION['db_config'] = [
                            'host' => $db_host,
                            'name' => $db_name,
                            'user' => $db_user,
                            'pass' => $db_pass
                        ];

                        echo '<div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> <strong>Database connection successful!</strong><br>
                            Database "' . htmlspecialchars($db_name) . '" is ready for installation.
                        </div>';

                        echo '<div class="button-group">
                            <a href="install.php?step=3" class="btn btn-primary">
                                Continue <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>';

                    } catch (PDOException $e) {
                        echo '<div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> <strong>Connection failed:</strong><br>
                            ' . htmlspecialchars($e->getMessage()) . '
                            <br><br>
                            <strong>Common solutions:</strong>
                            <ul>
                                <li>Make sure MySQL is running in XAMPP Control Panel</li>
                                <li>Verify username is "root" and password is empty (XAMPP default)</li>
                                <li>Try using "127.0.0.1" instead of "localhost"</li>
                                <li>Check if port 3306 is available</li>
                                <li>Restart Apache and MySQL services</li>
                            </ul>
                        </div>';
                    }
                }

                if (!isset($_SESSION['db_config'])) {
                ?>

                <h2>Database Configuration</h2>
                <p>Enter your MySQL database details:</p>

                <form method="POST">
                    <div class="form-group">
                        <label class="form-label">Database Host</label>
                        <input type="text" 
                               name="db_host" 
                               class="form-control" 
                               value="<?php echo $_POST['db_host'] ?? 'localhost'; ?>"
                               required>
                        <small class="form-text">Usually "localhost" or "127.0.0.1"</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Database Name</label>
                        <input type="text" 
                               name="db_name" 
                               class="form-control" 
                               value="<?php echo $_POST['db_name'] ?? 'calculator'; ?>"
                               required>
                        <small class="form-text">Database will be created if it doesn't exist</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Database Username</label>
                        <input type="text" 
                               name="db_user" 
                               class="form-control" 
                               value="<?php echo $_POST['db_user'] ?? 'root'; ?>"
                               required>
                        <small class="form-text">Default XAMPP username is "root"</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Database Password</label>
                        <input type="password" 
                               name="db_pass" 
                               class="form-control"
                               value="<?php echo $_POST['db_pass'] ?? ''; ?>">
                        <small class="form-text">Leave empty for XAMPP default (no password)</small>
                    </div>

                    <div class="button-group">
                        <a href="install.php?step=1" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" name="test_connection" class="btn btn-primary">
                            Test Connection <i class="fas fa-check"></i>
                        </button>
                    </div>
                </form>

                <?php
                }
            }

            // STEP 3: Create Admin Account
            elseif ($step == 3) {
                if (!isset($_SESSION['db_config'])) {
                    header('Location: install.php?step=1');
                    exit;
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_admin'])) {
                    $username = trim($_POST['admin_username']);
                    $email = trim($_POST['admin_email']);
                    $password = $_POST['admin_password'];
                    $confirm_password = $_POST['admin_password_confirm'];

                    $errors = [];

                    // Validate
                    if (strlen($username) < 3) {
                        $errors[] = "Username must be at least 3 characters";
                    }
                    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                        $errors[] = "Username can only contain letters, numbers, and underscores";
                    }
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Invalid email format";
                    }
                    if (strlen($password) < 8) {
                        $errors[] = "Password must be at least 8 characters";
                    }
                    if (!preg_match('/[A-Z]/', $password)) {
                        $errors[] = "Password must contain at least one uppercase letter";
                    }
                    if (!preg_match('/[a-z]/', $password)) {
                        $errors[] = "Password must contain at least one lowercase letter";
                    }
                    if (!preg_match('/[0-9]/', $password)) {
                        $errors[] = "Password must contain at least one number";
                    }
                    if ($password !== $confirm_password) {
                        $errors[] = "Passwords do not match";
                    }

                    if (empty($errors)) {
                        $_SESSION['admin_account'] = [
                            'username' => $username,
                            'email' => $email,
                            'password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 12])
                        ];

                        header('Location: install.php?step=4');
                        exit;
                    }
                }
                ?>

                <h2>Create Admin Account</h2>
                <p>Set up your administrator account:</p>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <strong><i class="fas fa-exclamation-circle"></i> Please fix the following errors:</strong>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" 
                               name="admin_username" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($_POST['admin_username'] ?? 'admin'); ?>"
                               required>
                        <small class="form-text">Use only letters, numbers, and underscores</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" 
                               name="admin_email" 
                               class="form-control" 
                               value="<?php echo htmlspecialchars($_POST['admin_email'] ?? ''); ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" 
                               name="admin_password" 
                               class="form-control" 
                               required>
                        <small class="form-text">Minimum 8 characters with uppercase, lowercase, and number</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" 
                               name="admin_password_confirm" 
                               class="form-control" 
                               required>
                    </div>

                    <div class="button-group">
                        <a href="install.php?step=2" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" name="create_admin" class="btn btn-primary">
                            Continue <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <?php
            }

            // STEP 4: Install Database & Configuration
            elseif ($step == 4) {
                if (!isset($_SESSION['db_config']) || !isset($_SESSION['admin_account'])) {
                    header('Location: install.php?step=1');
                    exit;
                }

                if (isset($_GET['install']) && $_GET['install'] === 'now') {
                    set_time_limit(300); // Increase time limit for large SQL files
                    
                    try {
                        $db_config = $_SESSION['db_config'];
                        $admin = $_SESSION['admin_account'];

                        // Connect to database
                        $pdo = new PDO(
                            "mysql:host={$db_config['host']};dbname={$db_config['name']};charset=utf8mb4",
                            $db_config['user'],
                            $db_config['pass'],
                            [
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                            ]
                        );

                        // Read and execute SQL file
                        $sql_file = __DIR__ . '/database/schema.sql';
                        
                        if (!file_exists($sql_file)) {
                            throw new Exception("Schema file not found at: database/schema.sql. Please ensure the file exists.");
                        }

                        $sql = file_get_contents($sql_file);
                        
                        // Split SQL statements and execute
                        $statements = array_filter(
                            array_map('trim', explode(';', $sql)),
                            function($stmt) {
                                return !empty($stmt) && 
                                       stripos($stmt, 'CREATE TABLE') !== false || 
                                       stripos($stmt, 'INSERT INTO') !== false ||
                                       stripos($stmt, 'CREATE DATABASE') !== false;
                            }
                        );

                        foreach ($statements as $statement) {
                            if (!empty(trim($statement))) {
                                try {
                                    $pdo->exec($statement);
                                } catch (PDOException $e) {
                                    // Log but continue if table already exists
                                    if (strpos($e->getMessage(), 'already exists') === false) {
                                        throw $e;
                                    }
                                }
                            }
                        }

                        // Insert admin user
                        $stmt = $pdo->prepare("
                            INSERT INTO users (username, email, password, role, email_verified, is_active, created_at)
                            VALUES (?, ?, ?, 'admin', 1, 1, NOW())
                            ON DUPLICATE KEY UPDATE username = username
                        ");
                        $stmt->execute([
                            $admin['username'],
                            $admin['email'],
                            $admin['password']
                        ]);

                        // Create config.php
                        $config_content = "<?php
/**
 * Configuration File
 * Auto-generated by installation script
 */

// Error Reporting (Disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/php-errors.log');

// Create logs directory
if (!is_dir(__DIR__ . '/logs')) {
    @mkdir(__DIR__ . '/logs', 0755, true);
}

// Database Configuration
define('DB_HOST', '{$db_config['host']}');
define('DB_NAME', '{$db_config['name']}');
define('DB_USER', '{$db_config['user']}');
define('DB_PASS', '" . addslashes($db_config['pass']) . "');

// Site Configuration
define('SITE_URL', 'http://' . \$_SERVER['HTTP_HOST'] . '/Calculator');
define('SITE_NAME', 'Calculator');
define('BASE_PATH', __DIR__);

// Security
define('JWT_SECRET', '" . bin2hex(random_bytes(32)) . "');
define('ENCRYPTION_KEY', '" . bin2hex(random_bytes(32)) . "');

// Email Configuration
define('MAIL_FROM_ADDRESS', 'noreply@calculator.local');
define('MAIL_FROM_NAME', 'Calculator');

// Timezone
date_default_timezone_set('UTC');

/**
 * Database Connection Class
 */
class Database {
    private static \$instance = null;
    private \$pdo;
    
    private function __construct() {
        try {
            \$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            \$options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            \$this->pdo = new PDO(\$dsn, DB_USER, DB_PASS, \$options);
        } catch (PDOException \$e) {
            error_log('Database Connection Error: ' . \$e->getMessage());
            die('Database connection failed. Please check your configuration.');
        }
    }
    
    public static function getInstance() {
        if (self::\$instance === null) {
            self::\$instance = new self();
        }
        return self::\$instance;
    }
    
    public function query(\$sql, \$params = []) {
        try {
            \$stmt = \$this->pdo->prepare(\$sql);
            \$stmt->execute(\$params);
            return \$stmt;
        } catch (PDOException \$e) {
            error_log('Query Error: ' . \$e->getMessage() . ' | SQL: ' . \$sql);
            throw \$e;
        }
    }
    
    public function fetchAll(\$sql, \$params = []) {
        return \$this->query(\$sql, \$params)->fetchAll();
    }
    
    public function fetchOne(\$sql, \$params = []) {
        return \$this->query(\$sql, \$params)->fetch();
    }
    
    public function fetchColumn(\$sql, \$params = []) {
        return \$this->query(\$sql, \$params)->fetchColumn();
    }
    
    public function lastInsertId() {
        return \$this->pdo->lastInsertId();
    }
}

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_secure' => false,
        'use_strict_mode' => true
    ]);
}

// Auto-load functions
if (file_exists(__DIR__ . '/includes/functions.php')) {
    require_once __DIR__ . '/includes/functions.php';
}
?>";

                        file_put_contents(__DIR__ . '/config.php', $config_content);

                        // Clear session
                        session_destroy();

                        // Redirect to completion
                        header('Location: install.php?step=5');
                        exit;

                    } catch (Exception $e) {
                        echo '<div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> <strong>Installation failed:</strong><br>
                            ' . htmlspecialchars($e->getMessage()) . '
                        </div>';
                        echo '<div class="button-group">
                            <a href="install.php?step=2" class="btn btn-secondary">Go Back</a>
                        </div>';
                    }
                } else {
                    ?>

                    <h2>Ready to Install</h2>
                    <p>Review your configuration before installation:</p>

                    <div class="alert alert-info">
                        <h4>Database Configuration</h4>
                        <p><strong>Host:</strong> <?php echo htmlspecialchars($_SESSION['db_config']['host']); ?></p>
                        <p><strong>Database:</strong> <?php echo htmlspecialchars($_SESSION['db_config']['name']); ?></p>
                        <p><strong>User:</strong> <?php echo htmlspecialchars($_SESSION['db_config']['user']); ?></p>
                    </div>

                    <div class="alert alert-info">
                        <h4>Admin Account</h4>
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['admin_account']['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['admin_account']['email']); ?></p>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> <strong>Important:</strong> This will create database tables and configuration files. Make sure MySQL is running in XAMPP.
                    </div>

                    <div class="button-group">
                        <a href="install.php?step=3" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <a href="install.php?step=4&install=now" class="btn btn-primary">
                            <i class="fas fa-download"></i> Install Now
                        </a>
                    </div>

                    <?php
                }
            }

            // STEP 5: Installation Complete
            elseif ($step == 5) {
                ?>

                <div style="text-align: center;">
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>

                    <h2>🎉 Installation Complete!</h2>
                    <p>Your Calculator website has been successfully installed.</p>

                    <div class="alert alert-success" style="text-align: left; margin: 2rem 0;">
                        <h4>✅ What's Been Set Up:</h4>
                        <ul style="margin: 1rem 0 0 1.5rem;">
                            <li>Database created and tables initialized</li>
                            <li>Admin account created</li>
                            <li>Configuration file generated</li>
                            <li>All calculator categories set up</li>
                        </ul>
                    </div>

                    <div class="alert alert-warning" style="text-align: left;">
                        <h4>🔒 Security Steps:</h4>
                        <ol style="margin: 1rem 0 0 1.5rem;">
                            <li><strong>Delete install.php</strong> - This file should be removed immediately</li>
                            <li>Change admin password after first login</li>
                            <li>Configure .htaccess for production</li>
                            <li>Set up SSL certificate (HTTPS)</li>
                        </ol>
                    </div>

                    <div class="button-group" style="justify-content: center; margin-top: 2rem;">
                        <a href="index.php" class="btn btn-success" style="font-size: 1.25rem; padding: 1rem 3rem;">
                            <i class="fas fa-home"></i> Visit Homepage
                        </a>
                        <a href="admin/login.php" class="btn btn-primary" style="font-size: 1.25rem; padding: 1rem 3rem;">
                            <i class="fas fa-lock"></i> Admin Login
                        </a>
                    </div>

                    <div style="margin-top: 3rem; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
                        <h4>📚 Next Steps</h4>
                        <ul style="text-align: left; margin-left: 2rem;">
                            <li>Customize site branding and logo</li>
                            <li>Configure email settings for notifications</li>
                            <li>Set up Google Analytics</li>
                            <li>Add AdSense code for monetization</li>
                            <li>Test all calculator functions</li>
                        </ul>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
    </div>

    <script>
        // Form submission handling
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button[type="submit"]');
                if (button && !button.disabled) {
                    button.disabled = true;
                    const originalHTML = button.innerHTML;
                    button.innerHTML = '<span class="loading"></span> Processing...';
                    
                    // Re-enable after 5 seconds as fallback
                    setTimeout(() => {
                        button.disabled = false;
                        button.innerHTML = originalHTML;
                    }, 5000);
                }
            });
        });
    </script>
</body>
</html>