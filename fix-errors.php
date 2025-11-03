<?php
/**
 * Quick Fix Script
 * Diagnose and fix common installation issues
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>Calculator - Quick Fix</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .box {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        h2 { color: #333; }
        pre { 
            background: #f8f9fa; 
            padding: 10px; 
            border-radius: 4px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h1>🔧 Calculator - Quick Fix Tool</h1>";

// Check 1: PHP Version
echo "<div class='box'>";
echo "<h2>1. PHP Version Check</h2>";
$phpVersion = phpversion();
if (version_compare($phpVersion, '8.0.0', '>=')) {
    echo "<p class='success'>✓ PHP Version: $phpVersion (OK)</p>";
} else {
    echo "<p class='error'>✗ PHP Version: $phpVersion (Need 8.0+)</p>";
}
echo "</div>";

// Check 2: Required Extensions
echo "<div class='box'>";
echo "<h2>2. Required Extensions</h2>";
$extensions = ['pdo', 'pdo_mysql', 'mysqli', 'json', 'mbstring', 'openssl'];
foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<p class='success'>✓ $ext loaded</p>";
    } else {
        echo "<p class='error'>✗ $ext NOT loaded</p>";
    }
}
echo "</div>";

// Check 3: Database Connection
echo "<div class='box'>";
echo "<h2>3. Database Connection Test</h2>";
try {
    $pdo = new PDO('mysql:host=localhost', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "<p class='success'>✓ Database connection successful</p>";
    
    // Check if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE 'calculator'");
    if ($stmt->rowCount() > 0) {
        echo "<p class='success'>✓ Database 'calculator' exists</p>";
    } else {
        echo "<p class='warning'>⚠ Database 'calculator' not found</p>";
        echo "<p>Run install.php to create database</p>";
    }
} catch (PDOException $e) {
    echo "<p class='error'>✗ Database connection failed: " . $e->getMessage() . "</p>";
    echo "<p><strong>Solutions:</strong></p>";
    echo "<ul>";
    echo "<li>Start MySQL in XAMPP Control Panel</li>";
    echo "<li>Check if MySQL is running on port 3306</li>";
    echo "<li>Verify credentials (default: root with no password)</li>";
    echo "</ul>";
}
echo "</div>";

// Check 4: File Permissions
echo "<div class='box'>";
echo "<h2>4. File Permissions</h2>";
$dirs = [
    'logs' => __DIR__ . '/logs',
    'uploads' => __DIR__ . '/uploads',
    'database/backups' => __DIR__ . '/database/backups'
];

foreach ($dirs as $name => $path) {
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
        echo "<p class='success'>✓ Created directory: $name</p>";
    }
    
    if (is_writable($path)) {
        echo "<p class='success'>✓ $name is writable</p>";
    } else {
        echo "<p class='error'>✗ $name is NOT writable</p>";
    }
}
echo "</div>";

// Check 5: .htaccess
echo "<div class='box'>";
echo "<h2>5. .htaccess Check</h2>";
if (file_exists(__DIR__ . '/.htaccess')) {
    echo "<p class='success'>✓ .htaccess file exists</p>";
    
    // Check for problematic directives
    $htaccess_content = file_get_contents(__DIR__ . '/.htaccess');
    if (strpos($htaccess_content, '<DirectoryMatch') !== false) {
        echo "<p class='warning'>⚠ .htaccess contains DirectoryMatch (may cause errors)</p>";
        echo "<p><strong>Fix:</strong> Remove or comment out DirectoryMatch directives</p>";
    }
} else {
    echo "<p class='error'>✗ .htaccess file not found</p>";
}
echo "</div>";

// Check 6: Config File
echo "<div class='box'>";
echo "<h2>6. Configuration Check</h2>";
if (file_exists(__DIR__ . '/config.php')) {
    echo "<p class='success'>✓ config.php exists</p>";
    
    // Try to include it
    try {
        require_once __DIR__ . '/config.php';
        echo "<p class='success'>✓ config.php loaded successfully</p>";
        
        // Test database connection
        try {
            $db = Database::getInstance();
            echo "<p class='success'>✓ Database class initialized</p>";
        } catch (Exception $e) {
            echo "<p class='error'>✗ Database initialization failed: " . $e->getMessage() . "</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>✗ config.php error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='warning'>⚠ config.php not found</p>";
    echo "<p>Run install.php to create configuration</p>";
}
echo "</div>";

// Check 7: Server Info
echo "<div class='box'>";
echo "<h2>7. Server Information</h2>";
echo "<pre>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "PHP SAPI: " . php_sapi_name() . "\n";
echo "Current Directory: " . __DIR__ . "\n";
echo "</pre>";
echo "</div>";

// Quick Actions
echo "<div class='box'>";
echo "<h2>Quick Actions</h2>";
echo "<p><a href='install.php' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px;'>→ Run Installation</a></p>";
echo "<p><a href='index.php' style='padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 4px;'>→ Go to Homepage</a></p>";
echo "<p><a href='admin/login.php' style='padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;'>→ Admin Login</a></p>";
echo "</div>";

echo "</body></html>";
?>