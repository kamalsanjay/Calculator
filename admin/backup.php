<?php
/**
 * Database Backup
 * Create and manage database backups
 */

require_once '../config.php';
require_once '../includes/functions.php';
require_once '../middleware/AdminMiddleware.php';

AdminMiddleware::check();
AdminMiddleware::requirePermission('backup_database');

$page_title = "Database Backup - Admin Panel";
$db = Database::getInstance();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create_backup') {
        try {
            $backupDir = BASE_PATH . '/database/backups';
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $filepath = $backupDir . '/' . $filename;
            
            // Database credentials
            $host = getenv('DB_HOST') ?: 'localhost';
            $dbname = getenv('DB_NAME') ?: 'calculator';
            $username = getenv('DB_USER') ?: 'root';
            $password = getenv('DB_PASSWORD') ?: '';
            
            // Create backup using mysqldump
            $command = sprintf(
                'mysqldump -h%s -u%s -p%s %s > %s',
                escapeshellarg($host),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($dbname),
                escapeshellarg($filepath)
            );
            
            exec($command, $output, $returnVar);
            
            if ($returnVar === 0 && file_exists($filepath)) {
                $_SESSION['success'] = "Backup created successfully: {$filename}";
                AdminMiddleware::logAction('backup_create', "Created database backup: {$filename}");
            } else {
                $_SESSION['error'] = "Failed to create backup.";
            }
            
        } catch (Exception $e) {
            $_SESSION['error'] = "Backup error: " . $e->getMessage();
        }
        
        header('Location: /admin/backup');
        exit;
    }
    
    if ($action === 'delete_backup') {
        $filename = $_POST['filename'] ?? '';
        $filepath = BASE_PATH . '/database/backups/' . basename($filename);
        
        if (file_exists($filepath)) {
            if (unlink($filepath)) {
                $_SESSION['success'] = "Backup deleted successfully.";
                AdminMiddleware::logAction('backup_delete', "Deleted backup: {$filename}");
            } else {
                $_SESSION['error'] = "Failed to delete backup.";
            }
        }
        
        header('Location: /admin/backup');
        exit;
    }
}

// Get existing backups
$backupDir = BASE_PATH . '/database/backups';
$backups = [];

if (is_dir($backupDir)) {
    $files = scandir($backupDir, SCANDIR_SORT_DESCENDING);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
            $filepath = $backupDir . '/' . $file;
            $backups[] = [
                'filename' => $file,
                'size' => filesize($filepath),
                'created' => filemtime($filepath)
            ];
        }
    }
}

// Get database size
try {
    $dbSize = $db->fetchColumn("
        SELECT SUM(data_length + index_length) 
        FROM information_schema.tables 
        WHERE table_schema = DATABASE()
    ");
} catch (Exception $e) {
    $dbSize = 0;
}

include '../includes/header.php';
?>

<div class="admin-wrapper">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Database Backup</h1>
            <form method="POST" style="display: inline;">
                <input type="hidden" name="action" value="create_backup">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Backup
                </button>
            </form>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Database Info -->
        <div class="card">
            <div class="card-header">
                <h3>Database Information</h3>
            </div>
            <div class="card-body">
                <div class="db-info">
                    <div class="info-item">
                        <strong>Database Name:</strong>
                        <span><?php echo htmlspecialchars(getenv('DB_NAME') ?: 'calculator'); ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Database Size:</strong>
                        <span><?php echo formatBytes($dbSize); ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Total Backups:</strong>
                        <span><?php echo count($backups); ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Last Backup:</strong>
                        <span>
                            <?php 
                            if (!empty($backups)) {
                                echo date('M d, Y H:i', $backups[0]['created']);
                            } else {
                                echo 'No backups yet';
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Backups List -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Available Backups</h3>
            </div>
            <div class="card-body">
                <?php if (empty($backups)): ?>
                    <p class="text-center text-muted py-4">
                        No backups available. Create your first backup above.
                    </p>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Filename</th>
                                <th>Size</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($backups as $backup): ?>
                                <tr>
                                    <td>
                                        <i class="fas fa-database"></i>
                                        <?php echo htmlspecialchars($backup['filename']); ?>
                                    </td>
                                    <td><?php echo formatBytes($backup['size']); ?></td>
                                    <td><?php echo date('M d, Y H:i', $backup['created']); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="/admin/backup/download?file=<?php echo urlencode($backup['filename']); ?>" 
                                               class="btn btn-sm btn-success">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                            <form method="POST" 
                                                  style="display: inline;" 
                                                  onsubmit="return confirm('Delete this backup?');">
                                                <input type="hidden" name="action" value="delete_backup">
                                                <input type="hidden" name="filename" value="<?php echo htmlspecialchars($backup['filename']); ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <!-- Backup Instructions -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Backup Instructions</h3>
            </div>
            <div class="card-body">
                <div class="instructions">
                    <h4>📋 How to Use Backups:</h4>
                    <ol>
                        <li><strong>Create Regular Backups:</strong> Click "Create New Backup" to generate a snapshot of your database</li>
                        <li><strong>Download Backups:</strong> Download backups to your local computer for safekeeping</li>
                        <li><strong>Store Securely:</strong> Keep backups in multiple locations (local + cloud)</li>
                        <li><strong>Test Restores:</strong> Periodically test that backups can be restored successfully</li>
                    </ol>
                    
                    <h4>⚠️ Important Notes:</h4>
                    <ul>
                        <li>Backups are stored in: <code>/database/backups/</code></li>
                        <li>Ensure this directory has proper write permissions</li>
                        <li>Backups include all tables and data</li>
                        <li>Delete old backups to save disk space</li>
                        <li>Always backup before major updates</li>
                    </ul>
                    
                    <h4>🔄 How to Restore:</h4>
                    <p>To restore a backup, use MySQL command:</p>
                    <pre><code>mysql -u username -p database_name < backup_file.sql</code></pre>
                    
                    <h4>⏰ Automated Backups:</h4>
                    <p>Set up a cron job for automated daily backups:</p>
                    <pre><code>0 2 * * * php /path/to/admin/backup-cron.php</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.db-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-item strong {
    color: #6c757d;
    font-size: 0.875rem;
}

.info-item span {
    font-size: 1.25rem;
    font-weight: 600;
    color: #343a40;
}

.instructions {
    line-height: 1.8;
}

.instructions h4 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #343a40;
}

.instructions h4:first-child {
    margin-top: 0;
}

.instructions ol, .instructions ul {
    margin-left: 1.5rem;
}

.instructions li {
    margin-bottom: 0.75rem;
}

.instructions pre {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #007bff;
    margin: 1rem 0;
}

.instructions code {
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
}
</style>

<?php
// Helper function to format bytes
function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    
    return round($bytes, $precision) . ' ' . $units[$i];
}
?>

<?php include '../includes/footer.php'; ?>