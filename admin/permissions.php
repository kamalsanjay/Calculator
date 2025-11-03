<?php
/**
 * Permission Management
 * Manage system permissions
 */

require_once '../config.php';
require_once '../includes/functions.php';
require_once '../middleware/AdminMiddleware.php';

AdminMiddleware::check();
AdminMiddleware::requirePermission('manage_permissions');

$page_title = "Permission Management - Admin Panel";
$db = Database::getInstance();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create') {
        $name = sanitize_input($_POST['name'] ?? '');
        $slug = sanitize_input($_POST['slug'] ?? '');
        $description = sanitize_input($_POST['description'] ?? '');
        
        if ($name && $slug) {
            try {
                $db->insert('permissions', [
                    'name' => $name,
                    'slug' => $slug,
                    'description' => $description
                ]);
                $_SESSION['success'] = "Permission created successfully.";
                AdminMiddleware::logAction('permission_create', "Created permission: {$name}");
            } catch (Exception $e) {
                $_SESSION['error'] = "Failed to create permission: " . $e->getMessage();
            }
        }
        header('Location: /admin/permissions');
        exit;
    }
    
    if ($action === 'update') {
        $permId = $_POST['permission_id'] ?? null;
        $name = sanitize_input($_POST['name'] ?? '');
        $description = sanitize_input($_POST['description'] ?? '');
        
        if ($permId && $name) {
            try {
                $db->update('permissions', [
                    'name' => $name,
                    'description' => $description
                ], 'id = ?', [$permId]);
                $_SESSION['success'] = "Permission updated successfully.";
                AdminMiddleware::logAction('permission_update', "Updated permission ID: {$permId}");
            } catch (Exception $e) {
                $_SESSION['error'] = "Failed to update permission.";
            }
        }
        header('Location: /admin/permissions');
        exit;
    }
    
    if ($action === 'delete') {
        $permId = $_POST['permission_id'] ?? null;
        
        if ($permId) {
            try {
                $db->delete('permissions', 'id = ?', [$permId]);
                $_SESSION['success'] = "Permission deleted successfully.";
                AdminMiddleware::logAction('permission_delete', "Deleted permission ID: {$permId}");
            } catch (Exception $e) {
                $_SESSION['error'] = "Failed to delete permission.";
            }
        }
        header('Location: /admin/permissions');
        exit;
    }
}

// Get all permissions with role count
try {
    $permissions = $db->fetchAll("
        SELECT p.*, COUNT(DISTINCT rp.role_id) as role_count
        FROM permissions p
        LEFT JOIN role_permissions rp ON p.id = rp.permission_id
        GROUP BY p.id
        ORDER BY p.name ASC
    ");
    
} catch (Exception $e) {
    error_log("Permissions fetch error: " . $e->getMessage());
    $permissions = [];
}

include '../includes/header.php';
?>

<div class="admin-wrapper">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Permission Management</h1>
            <button class="btn btn-primary" onclick="showCreateModal()">
                <i class="fas fa-plus"></i> Create Permission
            </button>
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

        <!-- Permissions Table -->
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Permission</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Roles</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($permissions as $perm): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($perm['name']); ?></strong>
                                </td>
                                <td>
                                    <code><?php echo htmlspecialchars($perm['slug']); ?></code>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($perm['description'] ?? 'No description'); ?>
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        <?php echo $perm['role_count']; ?> role(s)
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-primary" 
                                                onclick='editPermission(<?php echo json_encode($perm); ?>)'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" style="display: inline;" 
                                              onsubmit="return confirm('Delete this permission? This will remove it from all roles.');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="permission_id" value="<?php echo $perm['id']; ?>">
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
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit Permission Modal -->
<div id="permissionModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Create Permission</h2>
        <form method="POST" id="permissionForm">
            <input type="hidden" name="action" id="formAction" value="create">
            <input type="hidden" name="permission_id" id="permissionId">
            
            <div class="form-group">
                <label>Permission Name *</label>
                <input type="text" name="name" id="permissionName" class="form-control" required>
                <small>Human-readable name (e.g., "Manage Users")</small>
            </div>
            
            <div class="form-group">
                <label>Slug *</label>
                <input type="text" name="slug" id="permissionSlug" class="form-control" required>
                <small>Lowercase, underscores (e.g., "manage_users")</small>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="permissionDescription" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Permission</button>
            </div>
        </form>
    </div>
</div>

<script>
function showCreateModal() {
    document.getElementById('modalTitle').textContent = 'Create Permission';
    document.getElementById('formAction').value = 'create';
    document.getElementById('permissionForm').reset();
    document.getElementById('permissionSlug').readOnly = false;
    document.getElementById('permissionModal').style.display = 'block';
}

function editPermission(perm) {
    document.getElementById('modalTitle').textContent = 'Edit Permission';
    document.getElementById('formAction').value = 'update';
    document.getElementById('permissionId').value = perm.id;
    document.getElementById('permissionName').value = perm.name;
    document.getElementById('permissionSlug').value = perm.slug;
    document.getElementById('permissionSlug').readOnly = true;
    document.getElementById('permissionDescription').value = perm.description || '';
    document.getElementById('permissionModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('permissionModal').style.display = 'none';
}

// Auto-generate slug from name
document.getElementById('permissionName')?.addEventListener('input', function(e) {
    if (document.getElementById('formAction').value === 'create') {
        const slug = e.target.value.toLowerCase()
            .replace(/[^a-z0-9]+/g, '_')
            .replace(/^_|_$/g, '');
        document.getElementById('permissionSlug').value = slug;
    }
});

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>

<?php include '../includes/footer.php'; ?>