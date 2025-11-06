<?php
/**
 * Manage Calculators - With Updated Checkbox
 */

define('ADMIN_PANEL', true);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../middleware/AdminMiddleware.php';

AdminMiddleware::check();
$admin = AdminMiddleware::adminUser();

$db = Database::getInstance();
$success = '';
$error = '';

// Handle actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    try {
        switch ($_GET['action']) {
            case 'delete':
                $db->execute("DELETE FROM calculators WHERE id = ?", [$id]);
                $success = 'Calculator deleted successfully!';
                break;
                
            case 'toggle_active':
                $current = $db->fetchOne("SELECT is_active FROM calculators WHERE id = ?", [$id]);
                $newStatus = $current['is_active'] ? 0 : 1;
                $db->execute("UPDATE calculators SET is_active = ? WHERE id = ?", [$newStatus, $id]);
                $success = 'Calculator status updated!';
                break;
                
            case 'toggle_updated':
                $current = $db->fetchOne("SELECT is_updated FROM calculators WHERE id = ?", [$id]);
                $newStatus = $current['is_updated'] ? 0 : 1;
                $db->execute("UPDATE calculators SET is_updated = ?, updated_at = NOW() WHERE id = ?", [$newStatus, $id]);
                $success = 'Calculator updated status changed!';
                break;
        }
    } catch (Exception $e) {
        $error = 'Failed to perform action: ' . $e->getMessage();
    }
}

// Handle bulk actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulk_action']) && isset($_POST['calculator_ids'])) {
    $ids = array_map('intval', $_POST['calculator_ids']);
    
    if (!empty($ids)) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        
        try {
            switch ($_POST['bulk_action']) {
                case 'activate':
                    $db->execute("UPDATE calculators SET is_active = 1 WHERE id IN ($placeholders)", $ids);
                    $success = count($ids) . ' calculators activated!';
                    break;
                    
                case 'deactivate':
                    $db->execute("UPDATE calculators SET is_active = 0 WHERE id IN ($placeholders)", $ids);
                    $success = count($ids) . ' calculators deactivated!';
                    break;
                    
                case 'delete':
                    $db->execute("DELETE FROM calculators WHERE id IN ($placeholders)", $ids);
                    $success = count($ids) . ' calculators deleted!';
                    break;
            }
        } catch (Exception $e) {
            $error = 'Bulk action failed: ' . $e->getMessage();
        }
    }
}

// Get filters
$filter_category = $_GET['category'] ?? '';
$filter_status = $_GET['status'] ?? '';
$filter_updated = $_GET['updated'] ?? '';
$search = $_GET['search'] ?? '';

// Build query
$query = "
    SELECT c.*, cat.name as category_name
    FROM calculators c
    LEFT JOIN categories cat ON c.category = cat.slug
    WHERE 1=1
";
$params = [];

if ($filter_category) {
    $query .= " AND c.category = ?";
    $params[] = $filter_category;
}

if ($filter_status === 'active') {
    $query .= " AND c.is_active = 1";
} elseif ($filter_status === 'inactive') {
    $query .= " AND c.is_active = 0";
}

if ($filter_updated === 'yes') {
    $query .= " AND c.is_updated = 1";
} elseif ($filter_updated === 'no') {
    $query .= " AND c.is_updated = 0";
}

if ($search) {
    $query .= " AND (c.name LIKE ? OR c.description LIKE ? OR c.slug LIKE ?)";
    $params[] = "%{$search}%";
    $params[] = "%{$search}%";
    $params[] = "%{$search}%";
}

$query .= " ORDER BY c.page_views DESC";

// Get calculators
try {
    $calculators = $db->fetchAll($query, $params);
    $categories = $db->fetchAll("SELECT * FROM categories WHERE is_active = 1 ORDER BY name");
    
    // Get statistics
    $totalCount = $db->fetchColumn("SELECT COUNT(*) FROM calculators");
    $activeCount = $db->fetchColumn("SELECT COUNT(*) FROM calculators WHERE is_active = 1");
    $inactiveCount = $db->fetchColumn("SELECT COUNT(*) FROM calculators WHERE is_active = 0");
    $updatedCount = $db->fetchColumn("SELECT COUNT(*) FROM calculators WHERE is_updated = 1");
} catch (Exception $e) {
    $calculators = [];
    $categories = [];
    $totalCount = $activeCount = $inactiveCount = $updatedCount = 0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculators - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>

        <main class="main-content">
            <div class="top-bar">
                <div class="welcome-text">
                    <h1><i class="fas fa-calculator"></i> Manage Calculators</h1>
                    <p>View and manage all calculators</p>
                </div>
                <div class="user-info">
                    <a href="calculator-add.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Calculator
                    </a>
                </div>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($totalCount); ?></h3>
                        <p>Total Calculators</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($activeCount); ?></h3>
                        <p>Active</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($inactiveCount); ?></h3>
                        <p>Inactive</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ffc107 0%, #ff6b6b 100%);">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo number_format($updatedCount); ?></h3>
                        <p>Updated</p>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters-card">
                <form method="GET" class="filters-form">
                    <div class="filter-group">
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Search calculators..."
                               value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="filter-group">
                        <select name="category" class="form-control">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['slug']; ?>" 
                                        <?php echo $filter_category === $cat['slug'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="active" <?php echo $filter_status === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $filter_status === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <select name="updated" class="form-control">
                            <option value="">Updated Status</option>
                            <option value="yes" <?php echo $filter_updated === 'yes' ? 'selected' : ''; ?>>Updated</option>
                            <option value="no" <?php echo $filter_updated === 'no' ? 'selected' : ''; ?>>Not Updated</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <?php if ($search || $filter_category || $filter_status || $filter_updated): ?>
                        <a href="calculators.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Bulk Actions -->
            <form method="POST" id="bulkForm">
                <div class="bulk-actions-bar">
                    <label>
                        <input type="checkbox" id="selectAll"> Select All
                    </label>
                    <select name="bulk_action" class="form-control" style="width: auto;">
                        <option value="">Bulk Actions</option>
                        <option value="activate">Activate</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="delete">Delete</option>
                    </select>
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?');">
                        <i class="fas fa-check"></i> Apply
                    </button>
                </div>

                <div class="content-card">
                    <div class="content-card-header">
                        <h3>All Calculators (<?php echo count($calculators); ?>)</h3>
                    </div>
                    <div class="content-card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="40"><input type="checkbox" id="selectAllTop"></th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Views</th>
                                        <th>Status</th>
                                        <th>Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($calculators)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No calculators found</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($calculators as $calc): ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="calculator_ids[]" value="<?php echo $calc['id']; ?>" class="calc-checkbox">
                                            </td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($calc['name']); ?></strong>
                                                <br><small class="text-muted"><code><?php echo htmlspecialchars($calc['slug']); ?></code></small>
                                            </td>
                                            <td><?php echo htmlspecialchars($calc['category_name'] ?? $calc['category']); ?></td>
                                            <td><?php echo number_format($calc['page_views']); ?></td>
                                            <td>
                                                <?php if ($calc['is_active']): ?>
                                                    <span class="badge badge-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($calc['is_updated']): ?>
                                                    <span class="badge badge-warning"><i class="fas fa-check"></i> Yes</span>
                                                <?php else: ?>
                                                    <span class="badge badge-light"><i class="fas fa-times"></i> No</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="<?php echo SITE_URL; ?>/calculators/<?php echo $calc['category']; ?>/<?php echo $calc['slug']; ?>.php" 
                                                       class="btn-action btn-view" 
                                                       title="View"
                                                       target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="calculator-edit.php?id=<?php echo $calc['id']; ?>" 
                                                       class="btn-action btn-edit" 
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="?action=toggle_active&id=<?php echo $calc['id']; ?>" 
                                                       class="btn-action btn-toggle" 
                                                       title="Toggle Active">
                                                        <i class="fas fa-power-off"></i>
                                                    </a>
                                                    <a href="?action=toggle_updated&id=<?php echo $calc['id']; ?>" 
                                                       class="btn-action btn-updated" 
                                                       title="Toggle Updated">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </a>
                                                    <a href="?action=delete&id=<?php echo $calc['id']; ?>" 
                                                       class="btn-action btn-delete" 
                                                       title="Delete"
                                                       onclick="return confirm('Are you sure you want to delete this calculator?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
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
            </form>
        </main>
    </div>

    <script>
    // Select all functionality
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.calc-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
    
    document.getElementById('selectAllTop').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.calc-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        document.getElementById('selectAll').checked = this.checked;
    });
    </script>

    <style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .stat-details h3 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-details p {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .filters-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
    }

    .filters-form {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .bulk-actions-bar {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        display: flex;
        gap: 1rem;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .btn-view:hover {
        background: #2e7d32;
        color: white;
    }

    .btn-edit {
        background: #e3f2fd;
        color: #1976d2;
    }

    .btn-edit:hover {
        background: #1976d2;
        color: white;
    }

    .btn-toggle {
        background: #fff3e0;
        color: #f57c00;
    }

    .btn-toggle:hover {
        background: #f57c00;
        color: white;
    }

    .btn-updated {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .btn-updated:hover {
        background: #7b1fa2;
        color: white;
    }

    .btn-delete {
        background: #ffebee;
        color: #c62828;
    }

    .btn-delete:hover {
        background: #c62828;
        color: white;
    }

    .badge {
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-secondary {
        background: #e2e3e5;
        color: #383d41;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-light {
        background: #f8f9fa;
        color: #6c757d;
    }

    code {
        background: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        color: #667eea;
        font-size: 0.875rem;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
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

    .table-responsive {
        overflow-x: auto;
    }

    @media (max-width: 768px) {
        .filters-form {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
    </style>
</body>
</html>