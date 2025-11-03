<?php
/**
 * Add New Calculator
 */

define('ADMIN_PANEL', true);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../middleware/AdminMiddleware.php';

AdminMiddleware::check();
$admin = AdminMiddleware::adminUser();

$db = Database::getInstance();
$success = '';
$error = '';

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
            // Check if slug already exists
            $existing = $db->fetchOne("SELECT id FROM calculators WHERE slug = ? AND category = ?", [$slug, $category]);
            if ($existing) {
                $error = 'A calculator with this slug already exists in this category';
            } else {
                $stmt = $db->prepare("
                    INSERT INTO calculators (name, slug, category, subcategory, description, formula, is_active, created_at, updated_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
                ");
                $stmt->execute([$name, $slug, $category, $subcategory, $description, $formula, $is_active]);
                
                $success = 'Calculator added successfully!';
                
                // Clear form
                $name = $slug = $category = $subcategory = $description = $formula = '';
                $is_active = 1;
            }
        } catch (Exception $e) {
            $error = 'Failed to add calculator: ' . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Calculator - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>

        <main class="main-content">
            <div class="top-bar">
                <div class="welcome-text">
                    <h1><i class="fas fa-plus"></i> Add New Calculator</h1>
                    <p>Create a new calculator tool</p>
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
                    <a href="calculators.php" style="margin-left: auto;">View All Calculators →</a>
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
                                       value="<?php echo htmlspecialchars($name ?? ''); ?>"
                                       placeholder="BMI Calculator"
                                       required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Slug *</label>
                                <input type="text" 
                                       name="slug" 
                                       class="form-control" 
                                       value="<?php echo htmlspecialchars($slug ?? ''); ?>"
                                       placeholder="bmi-calculator"
                                       required>
                                <small class="form-text">URL-friendly name (lowercase, hyphens)</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Category *</label>
                                <select name="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['slug']; ?>" 
                                                <?php echo ($category ?? '') === $cat['slug'] ? 'selected' : ''; ?>>
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
                                       value="<?php echo htmlspecialchars($subcategory ?? ''); ?>"
                                       placeholder="Optional">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="Brief description for SEO and display"><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Formula / Explanation</label>
                            <textarea name="formula" 
                                      class="form-control" 
                                      rows="4"
                                      placeholder="Mathematical formula or calculation explanation"><?php echo htmlspecialchars($formula ?? ''); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-checkbox">
                                <input type="checkbox" 
                                       name="is_active" 
                                       <?php echo ($is_active ?? 1) ? 'checked' : ''; ?>>
                                <span>Active (visible on website)</span>
                            </label>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Calculator
                            </button>
                            <a href="calculators.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="content-card" style="margin-top: 2rem;">
                <div class="content-card-header">
                    <h3><i class="fas fa-info-circle"></i> Important Notes</h3>
                </div>
                <div class="content-card-body">
                    <ul style="line-height: 2; color: #6c757d;">
                        <li>After adding a calculator here, you need to create the actual PHP file</li>
                        <li>File location: <code>/calculators/{category}/{slug}.php</code></li>
                        <li>Use the calculator template provided in the documentation</li>
                        <li>The slug must match the filename exactly</li>
                        <li>Test the calculator thoroughly before making it active</li>
                    </ul>
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

    code {
        background: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        color: #667eea;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
    </style>

    <script>
    // Auto-generate slug from name
    document.querySelector('input[name="name"]').addEventListener('input', function(e) {
        const slugInput = document.querySelector('input[name="slug"]');
        if (!slugInput.value || slugInput.dataset.auto !== 'false') {
            const slug = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
        }
    });

    document.querySelector('input[name="slug"]').addEventListener('input', function() {
        this.dataset.auto = 'false';
    });
    </script>
</body>
</html>