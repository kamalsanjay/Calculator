<?php
/**
 * Manage Calculators
 */

define('ADMIN_PANEL', true);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../middleware/AdminMiddleware.php';

AdminMiddleware::check();
$admin = AdminMiddleware::adminUser();

$db = Database::getInstance();
$success = '';
$error = '';

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    try {
        $id = intval($_GET['id']);
        $db->execute("DELETE FROM calculators WHERE id = ?", [$id]);
        $success = 'Calculator deleted successfully!';
    } catch (Exception $e) {
        $error = 'Failed to delete calculator: ' . $e->getMessage();
    }
}

// Get filter
$filter_category = $_GET['category'] ?? '';
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

if ($search) {
    $query .= " AND (c.name LIKE ? OR c.description LIKE ?)";
    $params[] = "%{$search}%";
    $params[] = "%{$search}%";
}

$query .= " ORDER BY c.page_views DESC";

// Get calculators
try {
    $calculators = $db->fetchAll($query, $params);
    $categories = $db->fetchAll("SELECT * FROM categories WHERE is_active = 1 ORDER BY name");
} catch (Exception $e) {
    $calculators = [];
    $categories = [];
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <?php if ($search || $filter_category): ?>
                        <a href="calculators.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="content-card">
                <div class="content-card-header">
                    <h3>All Calculators (<?php echo count($calculators); ?>)</h3>
                </div>
                <div class="content-card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Slug</th>
                                <th>Views</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($calculators)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No calculators found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($calculators as $calc): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($calc['name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($calc['category_name'] ?? $calc['category']); ?></td>
                                    <td><code><?php echo htmlspecialchars($calc['slug']); ?></code></td>
                                    <td><?php echo number_format($calc['page_views']); ?></td>
                                    <td>
                                        <?php if ($calc['is_active']): ?>
                                            <span class="badge badge-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Inactive</span>
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
        </main>
    </div>

    <style>
    .filters-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .filters-form {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .filter-group {
        flex: 1;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
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

    .btn-delete {
        background: #ffebee;
        color: #c62828;
    }

    .btn-delete:hover {
        background: #c62828;
        color: white;
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

    @media (max-width: 768px) {
        .filters-form {
            flex-direction: column;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
    </style>
</body>
</html>