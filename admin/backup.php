<?php
/**
 * Advanced Backup & Restore System
 * Complete backup management with scheduling
 * @version 1.0.0
 */

require_once 'includes/auth.php';

// Check admin permissions
if ($_SESSION['admin_role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$message = '';
$error = '';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Invalid request. Please try again.';
    } else {
        switch ($_POST['action']) {
            case 'create_backup':
                $result = createFullBackup($_POST['backup_type'], $_POST['backup_name']);
                if ($result['success']) {
                    if (isset($_POST['download']) && $_POST['download'] === '1') {
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="' . $result['filename'] . '"');
                        header('Content-Length: ' . strlen($result['data']));
                        echo $result['data'];
                        exit();
                    } else {
                        $message = $result['message'];
                    }
                } else {
                    $error = $result['message'];
                }
                break;
            
            case 'download_backup':
                $result = downloadBackup($_POST['backup_id']);
                if ($result['success']) {
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . $result['filename'] . '"');
                    header('Content-Length: ' . $result['size']);
                    readfile($result['filepath']);
                    exit();
                } else {
                    $error = $result['message'];
                }
                break;
            
            case 'delete_backup':
                $result = deleteBackup($_POST['backup_id']);
                $message = $result['success'] ? $result['message'] : '';
                $error = !$result['success'] ? $result['message'] : '';
                break;
            
            case 'restore_backup':
                $result = restoreBackup($_POST['backup_id']);
                $message = $result['success'] ? $result['message'] : '';
                $error = !$result['success'] ? $result['message'] : '';
                break;
            
            case 'schedule_backup':
                $result = scheduleBackup($_POST);
                $message = $result['success'] ? $result['message'] : '';
                $error = !$result['success'] ? $result['message'] : '';
                break;
            
            case 'delete_schedule':
                $result = deleteSchedule($_POST['schedule_id']);
                $message = $result['success'] ? $result['message'] : '';
                $error = !$result['success'] ? $result['message'] : '';
                break;
            
            case 'cleanup_old':
                $result = cleanupOldBackups(30);
                $message = $result['success'] ? $result['message'] : '';
                $error = !$result['success'] ? $result['message'] : '';
                break;
        }
    }
}

$backupStats = getBackupStatistics();
$backups = getAllBackups();
$scheduledBackups = getScheduledBackups();

require_once 'includes/header.php';
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-database me-2"></i>Backup & Restore
        </h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBackupModal">
            <i class="fas fa-plus-circle me-1"></i>Create Backup
        </button>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($message); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Backups</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $backupStats['total_backups']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-archive fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Size</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo formatBytes($backupStats['total_size']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hdd fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Last Backup</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo $backupStats['last_backup'] ? timeAgo($backupStats['last_backup']) : 'Never'; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Scheduled</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count($scheduledBackups); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Backup History</h6>
            <button class="btn btn-sm btn-danger" onclick="cleanupOldBackups()">
                <i class="fas fa-trash-alt me-1"></i>Cleanup Old
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Created By</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($backups)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                No backups found. Create your first backup to get started.
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($backups as $backup): ?>
                        <tr>
                            <td>
                                <i class="fas fa-file-archive text-primary me-2"></i>
                                <strong><?php echo htmlspecialchars($backup['backup_name']); ?></strong>
                            </td>
                            <td>
                                <?php
                                $badges = [
                                    'full' => 'success',
                                    'data_only' => 'info',
                                    'structure_only' => 'warning'
                                ];
                                $badgeClass = $badges[$backup['backup_type']] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?php echo $badgeClass; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $backup['backup_type'])); ?>
                                </span>
                            </td>
                            <td><?php echo formatBytes($backup['file_size']); ?></td>
                            <td><?php echo htmlspecialchars($backup['username'] ?? 'System'); ?></td>
                            <td>
                                <small><?php echo date('M j, Y g:i A', strtotime($backup['created_at'])); ?></small><br>
                                <small class="text-muted"><?php echo timeAgo($backup['created_at']); ?></small>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <input type="hidden" name="action" value="download_backup">
                                        <input type="hidden" name="backup_id" value="<?php echo $backup['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-primary" title="Download">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-warning" 
                                            onclick="showRestoreModal(<?php echo $backup['id']; ?>, '<?php echo htmlspecialchars($backup['backup_name'], ENT_QUOTES); ?>')" 
                                            title="Restore">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="deleteBackup(<?php echo $backup['id']; ?>, '<?php echo htmlspecialchars($backup['backup_name'], ENT_QUOTES); ?>')" 
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scheduled Backups -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Scheduled Backups</h6>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#scheduleBackupModal">
                <i class="fas fa-plus me-1"></i>Add Schedule
            </button>
        </div>
        <div class="card-body">
            <?php if (empty($scheduledBackups)): ?>
            <div class="text-center text-muted py-4">
                <i class="fas fa-calendar-times fa-3x mb-3 d-block"></i>
                <p>No scheduled backups configured.</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#scheduleBackupModal">
                    <i class="fas fa-plus me-1"></i>Schedule Your First Backup
                </button>
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Frequency</th>
                            <th>Type</th>
                            <th>Next Run</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($scheduledBackups as $schedule): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($schedule['schedule_name']); ?></strong></td>
                            <td><span class="badge bg-info"><?php echo ucfirst($schedule['frequency']); ?></span></td>
                            <td><?php echo ucfirst(str_replace('_', ' ', $schedule['backup_type'])); ?></td>
                            <td><small><?php echo date('M j, Y g:i A', strtotime($schedule['next_run'])); ?></small></td>
                            <td>
                                <?php if ($schedule['is_active']): ?>
                                <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="deleteSchedule(<?php echo $schedule['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Create Backup Modal -->
<div class="modal fade" id="createBackupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Backup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="action" value="create_backup">
                    
                    <div class="mb-3">
                        <label class="form-label">Backup Name *</label>
                        <input type="text" class="form-control" name="backup_name" required
                               value="backup_<?php echo date('Y-m-d_H-i-s'); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Backup Type *</label>
                        <select class="form-select" name="backup_type" required>
                            <option value="full">Full Backup (Structure + Data)</option>
                            <option value="data_only">Data Only</option>
                            <option value="structure_only">Structure Only</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="download" value="1" id="downloadCheck" checked>
                            <label class="form-check-label" for="downloadCheck">
                                Download backup immediately
                            </label>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Large databases may take several minutes to backup.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-database me-1"></i>Create Backup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Schedule Backup Modal -->
<div class="modal fade" id="scheduleBackupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule Automatic Backup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="action" value="schedule_backup">
                    
                    <div class="mb-3">
                        <label class="form-label">Schedule Name *</label>
                        <input type="text" class="form-control" name="schedule_name" required
                               placeholder="e.g., Daily Auto Backup">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Frequency *</label>
                        <select class="form-select" name="frequency" required>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Backup Type *</label>
                        <select class="form-select" name="backup_type" required>
                            <option value="full">Full Backup</option>
                            <option value="data_only">Data Only</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Retention Days</label>
                        <input type="number" class="form-control" name="retention_days" value="7" min="1" max="90">
                        <small class="text-muted">Auto-delete backups older than this</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-plus me-1"></i>Schedule Backup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Restore Modal -->
<div class="modal fade" id="restoreBackupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Restore Backup
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="restoreForm">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="action" value="restore_backup">
                    <input type="hidden" name="backup_id" id="restore_backup_id">
                    
                    <div class="alert alert-danger">
                        <i class="fas fa-skull-crossbones me-2"></i>
                        <strong>WARNING:</strong> This will replace ALL current data!
                    </div>
                    
                    <p>Restore backup: <strong id="restore_backup_name"></strong></p>
                    
                    <div class="mb-3">
                        <label class="form-label">Type "RESTORE" to confirm</label>
                        <input type="text" class="form-control" id="restore_confirm" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="restoreBtn" disabled>
                        <i class="fas fa-undo me-1"></i>Restore Backup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRestoreModal(id, name) {
    document.getElementById('restore_backup_id').value = id;
    document.getElementById('restore_backup_name').textContent = name;
    document.getElementById('restore_confirm').value = '';
    document.getElementById('restoreBtn').disabled = true;
    new bootstrap.Modal(document.getElementById('restoreBackupModal')).show();
}

document.getElementById('restore_confirm')?.addEventListener('input', function() {
    document.getElementById('restoreBtn').disabled = this.value !== 'RESTORE';
});

function deleteBackup(id, name) {
    if (confirm(`Delete backup "${name}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="action" value="delete_backup">
            <input type="hidden" name="backup_id" value="${id}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function deleteSchedule(id) {
    if (confirm('Delete this schedule?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="action" value="delete_schedule">
            <input type="hidden" name="schedule_id" value="${id}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

function cleanupOldBackups() {
    if (confirm('Delete backups older than 30 days?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="action" value="cleanup_old">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php
require_once 'includes/footer.php';

// FUNCTIONS
function createFullBackup($type, $name) {
    global $pdo;
    try {
        $backupDir = __DIR__ . '/../backups';
        if (!file_exists($backupDir)) mkdir($backupDir, 0700, true);
        
        $filename = $name . '.sql';
        $filepath = $backupDir . '/' . $filename;
        
        $backup = "-- Backup: " . $name . "\n";
        $backup .= "-- Type: " . $type . "\n";
        $backup .= "-- Date: " . date('Y-m-d H:i:s') . "\n\n";
        $backup .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $backup .= "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n\n";
        
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        
        foreach ($tables as $table) {
            if ($type === 'full' || $type === 'structure_only') {
                $create = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(PDO::FETCH_ASSOC);
                $backup .= "DROP TABLE IF EXISTS `{$table}`;\n";
                $backup .= $create['Create Table'] . ";\n\n";
            }
            
            if ($type === 'full' || $type === 'data_only') {
                $rows = $pdo->query("SELECT * FROM `{$table}`");
                while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
                    $values = array_map(fn($v) => $v === null ? 'NULL' : $pdo->quote($v), array_values($row));
                    $cols = '`' . implode('`,`', array_keys($row)) . '`';
                    $backup .= "INSERT INTO `{$table}` ($cols) VALUES (" . implode(',', $values) . ");\n";
                }
                $backup .= "\n";
            }
        }
        
        $backup .= "SET FOREIGN_KEY_CHECKS=1;\n";
        file_put_contents($filepath, $backup);
        
        $stmt = $pdo->prepare("INSERT INTO backups (backup_name, filename, filepath, backup_type, file_size, tables_count, created_by, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $filename, $filepath, $type, filesize($filepath), count($tables), $_SESSION['admin_id']]);
        
        logActivity($_SESSION['admin_id'], 'backup', "Created {$type} backup: {$name}");
        
        return ['success' => true, 'message' => 'Backup created!', 'filename' => $filename, 'data' => $backup];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Backup failed: ' . $e->getMessage()];
    }
}

function downloadBackup($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM backups WHERE id = ?");
    $stmt->execute([$id]);
    $backup = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$backup || !file_exists($backup['filepath'])) {
        return ['success' => false, 'message' => 'Backup not found.'];
    }
    logActivity($_SESSION['admin_id'], 'download', "Downloaded: {$backup['filename']}");
    return ['success' => true, 'filename' => $backup['filename'], 'filepath' => $backup['filepath'], 'size' => $backup['file_size']];
}

function deleteBackup($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM backups WHERE id = ?");
    $stmt->execute([$id]);
    $backup = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$backup) return ['success' => false, 'message' => 'Not found.'];
    if (file_exists($backup['filepath'])) unlink($backup['filepath']);
    $pdo->prepare("DELETE FROM backups WHERE id = ?")->execute([$id]);
    logActivity($_SESSION['admin_id'], 'delete', "Deleted: {$backup['filename']}");
    return ['success' => true, 'message' => 'Deleted!'];
}

function restoreBackup($id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT * FROM backups WHERE id = ?");
        $stmt->execute([$id]);
        $backup = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$backup || !file_exists($backup['filepath'])) {
            return ['success' => false, 'message' => 'Not found.'];
        }
        
        $sql = file_get_contents($backup['filepath']);
        $pdo->beginTransaction();
        $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
        
        $statements = array_filter(array_map('trim', explode(";\n", $sql)), fn($s) => !empty($s) && !preg_match('/^--/', $s));
        foreach ($statements as $stmt) {
            if (!empty($stmt)) $pdo->exec($stmt);
        }
        
        $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
        $pdo->commit();
        
        logActivity($_SESSION['admin_id'], 'restore', "Restored: {$backup['filename']}");
        return ['success' => true, 'message' => 'Restored! Please logout and login.'];
    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
        return ['success' => false, 'message' => 'Failed: ' . $e->getMessage()];
    }
}

function scheduleBackup($data) {
    global $pdo;
    try {
        $nextRun = new DateTime();
        $nextRun->modify('+1 ' . $data['frequency']);
        $stmt = $pdo->prepare("INSERT INTO scheduled_backups (schedule_name, frequency, backup_type, retention_days, next_run, is_active, created_at) VALUES (?, ?, ?, ?, ?, 1, NOW())");
        $stmt->execute([$data['schedule_name'], $data['frequency'], $data['backup_type'], $data['retention_days'] ?? 7, $nextRun->format('Y-m-d H:i:s')]);
        logActivity($_SESSION['admin_id'], 'create', "Scheduled: {$data['schedule_name']}");
        return ['success' => true, 'message' => 'Scheduled!'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Failed: ' . $e->getMessage()];
    }
}

function deleteSchedule($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT schedule_name FROM scheduled_backups WHERE id = ?");
    $stmt->execute([$id]);
    $schedule = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$schedule) return ['success' => false, 'message' => 'Not found.'];
    $pdo->prepare("DELETE FROM scheduled_backups WHERE id = ?")->execute([$id]);
    logActivity($_SESSION['admin_id'], 'delete', "Deleted schedule: {$schedule['schedule_name']}");
    return ['success' => true, 'message' => 'Deleted!'];
}

function cleanupOldBackups($days) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT * FROM backups WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)");
        $stmt->execute([$days]);
        $old = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count = 0;
        foreach ($old as $b) {
            if (file_exists($b['filepath'])) unlink($b['filepath']);
            $pdo->prepare("DELETE FROM backups WHERE id = ?")->execute([$b['id']]);
            $count++;
        }
        logActivity($_SESSION['admin_id'], 'cleanup', "Cleaned $count backups");
        return ['success' => true, 'message' => "Deleted $count old backups"];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Failed: ' . $e->getMessage()];
    }
}

function getBackupStatistics() {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) as total_backups, COALESCE(SUM(file_size), 0) as total_size, MAX(created_at) as last_backup FROM backups");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllBackups() {
    global $pdo;
    $stmt = $pdo->query("SELECT b.*, u.username FROM backups b LEFT JOIN admin_users u ON b.created_by = u.id ORDER BY b.created_at DESC LIMIT 100");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getScheduledBackups() {
    global $pdo;
    return $pdo->query("SELECT * FROM scheduled_backups ORDER BY is_active DESC, next_run ASC")->fetchAll(PDO::FETCH_ASSOC);
}

function formatBytes($bytes) {
    if ($bytes == 0) return '0 B';
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log(1024));
    return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
}

function timeAgo($datetime) {
    $diff = time() - strtotime($datetime);
    if ($diff < 60) return 'just now';
    if ($diff < 3600) return floor($diff/60) . ' min ago';
    if ($diff < 86400) return floor($diff/3600) . ' hr ago';
    if ($diff < 604800) return floor($diff/86400) . ' days ago';
    return date('M j, Y', strtotime($datetime));
}
?>