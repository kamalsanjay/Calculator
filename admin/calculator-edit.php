<?php
/**
 * Edit Calculator
 */

define('ADMIN_PANEL', true);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../middleware/AdminMiddleware.php';

AdminMiddleware::check();
$admin = AdminMiddleware::adminUser();

$db = Database::getInstance();
$success = '';
$error = '';

// Get calculator ID
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: calculators.php');
    exit;
}

// Get calculator data
try {
    $calculator = $db->fetchOne("SELECT * FROM calculators WHERE id = ?", [$id]);
    if (!$calculator) {
        header('Location: calculators.php');
        exit;
    }
} catch (Exception $e) {
    $error = 'Failed to load calculator';
}

// Get categories
try {
    $categories = $db->fetchAll("SELECT * FROM categories WHERE is_active = 1 ORDER BY name");
} catch (Exception $e) {
    $categories = [];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $subcategory = trim($_POST['subcategory'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $formula = trim($_POST['formula'] ?? '');
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if (empty($name) || empty($slug) || empty($category)) {
        $error = 'Name, slug, and category are required';
    } else {
        try {
            $stmt = $db->prepare("
                UPDATE calculators 
                SET name = ?, slug = ?, category = ?, subcategory = ?, description = ?, formula = ?, is_active = ?, updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$name, $slug, $category, $subcategory, $description, $formula, $is_active, $id]);
            
            $success = 'Calculator updated successfully!';
            
            // Reload calculator data
            $calculator = $db->fetchOne("SELECT * FROM calculators WHERE id = ?", [$id]);
        } catch (Exception $e) {
            $error = 'Failed to update calculator: ' . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Calculator - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>

        <main class="main-content">
            <div class="top-bar">
                <div class="welcome-text">
                    <h1><i class="fas fa-edit"></i> Edit Calculator</h1>
                    <p>Update calculator details</p>
                </div>
                <div class="user-info">
                    <a href="calculators.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Calculators
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
                    <h3>Calculator Information</h3>
                </div>
                <div class="content-card-body">
                    <form method="POST" class="admin-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Calculator Name *</label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control" 
                                       value="<?php echo htmlspecialchars($calculator['name']); ?>"
                                       required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Slug *</label>
                                <input type="text" 
                                       name="slug" 
                                       class="form-control" 
                                       value="<?php echo htmlspecialchars($calculator['slug']); ?>"
                                       required>
                                <small class="form-text">URL-friendly name</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Category *</label>
                                <select name="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['slug']; ?>" 
                                                <?php echo $calculator['category'] === $cat['slug'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Subcategory</label>
                                <input type="text" 
                                       name="subcategory" 
                                       class="form-control" 
                                       value="<?php echo htmlspecialchars($calculator['subcategory']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" 
                                      class="form-control" 
                                      rows="3"><?php echo htmlspecialchars($calculator['description']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Formula / Explanation</label>
                            <textarea name="formula" 
                                      class="form-control" 
                                      rows="4"><?php echo htmlspecialchars($calculator['formula']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" 
                                       name="is_active" 
                                       <?php echo $calculator['is_active'] ? 'checked' : ''; ?>>
                                <span>Active (visible on website)</span>
                            </label>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Calculator
                            </button>
                            <a href="calculators.php" class="btn btn-secondary">
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
        max-width: 900px;
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
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 8px;
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