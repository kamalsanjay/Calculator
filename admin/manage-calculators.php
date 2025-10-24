<?php
/**
 * Manage Calculators - Add/Edit/Delete with Search & Bulk Actions
 */

require_once 'includes/auth.php';
require_once 'includes/header.php';

// Handle actions
$action = $_GET['action'] ?? 'list';
$message = '';
$error = '';

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Invalid request. Please try again.';
    } else {
        switch ($_POST['action_type']) {
            case 'add':
            case 'edit':
                $result = saveCalculator($_POST);
                if ($result['success']) {
                    $message = $result['message'];
                    $action = 'list';
                } else {
                    $error = $result['message'];
                }
                break;
            
            case 'delete':
                $result = deleteCalculator($_POST['id']);
                if ($result['success']) {
                    $message = $result['message'];
                } else {
                    $error = $result['message'];
                }
                break;
            
            case 'bulk_action':
                $result = handleBulkAction($_POST);
                if ($result['success']) {
                    $message = $result['message'];
                } else {
                    $error = $result['message'];
                }
                break;
        }
    }
}

// Get calculator for editing
$calculator = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $calculator = getCalculator($_GET['id']);
}

// Get all calculators for listing
$searchTerm = $_GET['search'] ?? '';
$statusFilter = $_GET['status'] ?? 'all';
$categoryFilter = $_GET['category'] ?? 'all';
$calculators = getCalculators($searchTerm, $statusFilter, $categoryFilter);
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-layer-group me-2"></i>
            <?php echo $action === 'add' ? 'Add Calculator' : ($action === 'edit' ? 'Edit Calculator' : 'Manage Calculators'); ?>
        </h1>
        <?php if ($action === 'list'): ?>
        <a href="?action=add" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Add New Calculator
        </a>
        <?php endif; ?>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($message); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if ($action === 'list'): ?>
    <!-- Calculator List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">All Calculators</h6>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-sm btn-danger" id="bulkActionBtn" style="display: none;">
                        <i class="fas fa-trash me-1"></i>Delete Selected
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Search and Filters -->
            <form method="GET" action="" class="row g-3 mb-4">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Search calculators..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>All Status</option>
                        <option value="active" <?php echo $statusFilter === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $statusFilter === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="category">
                        <option value="all" <?php echo $categoryFilter === 'all' ? 'selected' : ''; ?>>All Categories</option>
                        <option value="finance" <?php echo $categoryFilter === 'finance' ? 'selected' : ''; ?>>Finance</option>
                        <option value="health" <?php echo $categoryFilter === 'health' ? 'selected' : ''; ?>>Health</option>
                        <option value="math" <?php echo $categoryFilter === 'math' ? 'selected' : ''; ?>>Math</option>
                        <option value="conversion" <?php echo $categoryFilter === 'conversion' ? 'selected' : ''; ?>>Conversion</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Calculators Table -->
            <form method="POST" id="bulkForm">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="action_type" value="bulk_action">
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="30">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Uses (Today)</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($calculators as $calc): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="calculator_ids[]" value="<?php echo $calc['id']; ?>" class="calc-checkbox">
                                </td>
                                <td>
                                    <i class="fas fa-<?php echo htmlspecialchars($calc['icon']); ?> fa-2x text-primary"></i>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($calc['name']); ?></strong><br>
                                    <small class="text-muted"><?php echo htmlspecialchars($calc['slug']); ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo ucfirst($calc['category']); ?></span>
                                </td>
                                <td>
                                    <?php if ($calc['status'] === 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo number_format($calc['uses_today']); ?></strong>
                                </td>
                                <td>
                                    <small><?php echo date('M j, Y', strtotime($calc['updated_at'])); ?></small>
                                </td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $calc['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteCalculator(<?php echo $calc['id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <a href="../<?php echo $calc['slug']; ?>.php" target="_blank" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>

    <?php else: ?>
    <!-- Add/Edit Form -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="action_type" value="<?php echo $action; ?>">
                <?php if ($calculator): ?>
                <input type="hidden" name="id" value="<?php echo $calculator['id']; ?>">
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Calculator Name *</label>
                        <input type="text" class="form-control" name="name" required
                               value="<?php echo $calculator['name'] ?? ''; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Slug *</label>
                        <input type="text" class="form-control" name="slug" required
                               value="<?php echo $calculator['slug'] ?? ''; ?>"
                               pattern="[a-z0-9-]+" title="Only lowercase letters, numbers, and hyphens">
                        <small class="text-muted">URL-friendly name (e.g., loan-calculator)</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category *</label>
                        <select class="form-select" name="category" required>
                            <option value="">Select Category</option>
                            <option value="finance" <?php echo ($calculator['category'] ?? '') === 'finance' ? 'selected' : ''; ?>>Finance</option>
                            <option value="health" <?php echo ($calculator['category'] ?? '') === 'health' ? 'selected' : ''; ?>>Health</option>
                            <option value="math" <?php echo ($calculator['category'] ?? '') === 'math' ? 'selected' : ''; ?>>Math</option>
                            <option value="conversion" <?php echo ($calculator['category'] ?? '') === 'conversion' ? 'selected' : ''; ?>>Conversion</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Icon *</label>
                        <input type="text" class="form-control" name="icon" required
                               value="<?php echo $calculator['icon'] ?? ''; ?>"
                               placeholder="calculator">
                        <small class="text-muted">Font Awesome icon name (without fa-)</small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description *</label>
                        <textarea class="form-control" name="description" rows="3" required><?php echo $calculator['description'] ?? ''; ?></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title"
                               value="<?php echo $calculator['meta_title'] ?? ''; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Meta Description</label>
                        <input type="text" class="form-control" name="meta_description"
                               value="<?php echo $calculator['meta_description'] ?? ''; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status *</label>
                        <select class="form-select" name="status" required>
                            <option value="active" <?php echo ($calculator['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($calculator['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Featured</label>
                        <select class="form-select" name="is_featured">
                            <option value="0" <?php echo ($calculator['is_featured'] ?? 0) == 0 ? 'selected' : ''; ?>>No</option>
                            <option value="1" <?php echo ($calculator['is_featured'] ?? 0) == 1 ? 'selected' : ''; ?>>Yes</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between">
                    <a href="?action=list" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to List
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        <?php echo $action === 'add' ? 'Add Calculator' : 'Update Calculator'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
// Select All Checkboxes
document.getElementById('selectAll')?.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.calc-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
    toggleBulkActions();
});

// Show/Hide Bulk Actions
document.querySelectorAll('.calc-checkbox').forEach(cb => {
    cb.addEventListener('change', toggleBulkActions);
});

function toggleBulkActions() {
    const checked = document.querySelectorAll('.calc-checkbox:checked').length;
    document.getElementById('bulkActionBtn').style.display = checked > 0 ? 'inline-block' : 'none';
}

// Bulk Delete
document.getElementById('bulkActionBtn')?.addEventListener('click', function() {
    if (confirm('Are you sure you want to delete the selected calculators?')) {
        document.getElementById('bulkForm').submit();
    }
});

// Single Delete
function deleteCalculator(id) {
    if (confirm('Are you sure you want to delete this calculator?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="action_type" value="delete">
            <input type="hidden" name="id" value="${id}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// Auto-generate slug from name
document.querySelector('input[name="name"]')?.addEventListener('blur', function() {
    const slugInput = document.querySelector('input[name="slug"]');
    if (!slugInput.value) {
        slugInput.value = this.value.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>

<?php
/**
 * Calculator Management Functions
 */

function getCalculators($search = '', $status = 'all', $category = 'all') {
    global $pdo;
    
    $sql = "SELECT c.*, 
            (SELECT COUNT(*) FROM calculator_usage WHERE calculator_id = c.id AND DATE(created_at) = CURDATE()) as uses_today
            FROM calculators c
            WHERE 1=1";
    
    $params = [];
    
    if ($search) {
        $sql .= " AND (c.name LIKE ? OR c.description LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    
    if ($status !== 'all') {
        $sql .= " AND c.status = ?";
        $params[] = $status;
    }
    
    if ($category !== 'all') {
        $sql .= " AND c.category = ?";
        $params[] = $category;
    }
    
    $sql .= " ORDER BY c.created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCalculator($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM calculators WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function saveCalculator($data) {
    global $pdo;
    
    try {
        $fields = ['name', 'slug', 'category', 'icon', 'description', 'meta_title', 'meta_description', 'status', 'is_featured'];
        
        if (isset($data['id'])) {
            // Update
            $sql = "UPDATE calculators SET ";
            $updates = [];
            foreach ($fields as $field) {
                $updates[] = "$field = ?";
            }
            $sql .= implode(', ', $updates) . ", updated_at = NOW() WHERE id = ?";
            
            $params = [];
            foreach ($fields as $field) {
                $params[] = $data[$field] ?? null;
            }
            $params[] = $data['id'];
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
            logActivity($_SESSION['admin_id'], 'update', "Updated calculator: {$data['name']}");
            
            return ['success' => true, 'message' => 'Calculator updated successfully!'];
        } else {
            // Insert
            $sql = "INSERT INTO calculators (" . implode(', ', $fields) . ") VALUES (" . str_repeat('?,', count($fields) - 1) . "?)";
            
            $params = [];
            foreach ($fields as $field) {
                $params[] = $data[$field] ?? null;
            }
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
            logActivity($_SESSION['admin_id'], 'create', "Created calculator: {$data['name']}");
            
            return ['success' => true, 'message' => 'Calculator added successfully!'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}


function deleteCalculator($id) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT name FROM calculators WHERE id = ?");
        $stmt->execute([$id]);
        $calc = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $pdo->prepare("DELETE FROM calculators WHERE id = ?");
        $stmt->execute([$id]);
        
        logActivity($_SESSION['admin_id'], 'delete', "Deleted calculator: {$calc['name']}");
        
        return ['success' => true, 'message' => 'Calculator deleted successfully!'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error deleting calculator.'];
    }
}

function handleBulkAction($data) {
    global $pdo;
    
    if (empty($data['calculator_ids'])) {
        return ['success' => false, 'message' => 'No calculators selected.'];
    }
    
    try {
        $ids = implode(',', array_map('intval', $data['calculator_ids']));
        $stmt = $pdo->query("DELETE FROM calculators WHERE id IN ($ids)");
        
        $count = count($data['calculator_ids']);
        logActivity($_SESSION['admin_id'], 'delete', "Bulk deleted $count calculators");
        
        return ['success' => true, 'message' => "$count calculator(s) deleted successfully!"];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error performing bulk action.'];
    }
}
?>