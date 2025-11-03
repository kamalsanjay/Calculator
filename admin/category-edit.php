<?php
/**
 * Edit Category
 */

define('ADMIN_PANEL', true);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../middleware/AdminMiddleware.php';

AdminMiddleware::check();
$admin = AdminMiddleware::adminUser();

$db = Database::getInstance();
$success = '';
$error = '';

// Get category ID
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: categories.php');
    exit;
}

// Get category data
try {
    $category = $db->fetchOne("SELECT * FROM categories WHERE id = ?", [$id]);
    if (!$category) {
        header('Location: categories.php');
        exit;
    }
} catch (Exception $e) {
    $error = 'Failed to load category';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $icon = trim($_POST['icon'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $display_order = intval($_POST['display_order'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if (empty($name) || empty($slug)) {
        $error = 'Name and slug are required';
    } else {
        try {
            $stmt = $db->prepare("
                UPDATE categories 
                SET name = ?, slug = ?, icon = ?, description = ?, display_order = ?, is_active = ?
                WHERE id = ?
            ");
            $stmt->execute([$name, $slug, $icon, $description, $display_order, $is_active, $id]);
            
            $success = 'Category updated successfully!';
            
            // Reload category data
            $category = $db->fetchOne("SELECT * FROM categories WHERE id = ?", [$id]);
        } catch (Exception $e) {
            $error = 'Failed to update category: ' . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>

        <main class="main-content">
            <div class="top-bar">
                <div class="welcome-text">
                    <h1><i class="fas fa-edit"></i> Edit Category</h1>
                    <p>Update category details</p>
                </div>
                <div class="user-info">
                    <a href="categories.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Categories
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

            <div class="content-card">
                <div class="content-card-header">
                    <h3>Category Information</h3>
                </div>
                <div class="content-card-body">
                    <form method="POST" class="admin-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Category Name *</label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control" 
                                       value="<?php echo htmlspecialchars($category['name']); ?>"
                                       required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Slug *</label>
                                <input type="text" 
                                       name="slug" 
                                       class="form-control" 
                                       value="<?php echo htmlspecialchars($category['slug']); ?>"
                                       required>
                                <small class="form-text">URL-friendly name (e.g., financial, health)</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Icon (FontAwesome)</label>
                                <input type="text" 
                                       name="icon" 
                                       class="form-control" 
                                       value="<?php echo htmlspecialchars($category['icon']); ?>"
                                       placeholder="dollar-sign">
                                <small class="form-text">Icon name from FontAwesome (without 'fa-')</small>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Display Order</label>
                                <input type="number" 
                                       name="display_order" 
                                       class="form-control" 
                                       value="<?php echo $category['display_order']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" 
                                      class="form-control" 
                                      rows="3"><?php echo htmlspecialchars($category['description']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" 
                                       name="is_active" 
                                       <?php echo $category['is_active'] ? 'checked' : ''; ?>>
                                <span>Active</span>
                            </label>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Category
                            </button>
                            <a href="categories.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <style>
    .admin-form {
        max-width: 800px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #495057;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-text {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #6c757d;
    }

    .form-checkbox {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
    }

    .form-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
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
        .form-row {
            grid-template-columns: 1fr;
        }
    }
    </style>
</body>
</html>