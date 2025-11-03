<?php
/**
 * Role Management
 * Manage user roles and their permissions
 */

require_once '../config.php';
require_once '../includes/functions.php';
require_once '../middleware/AdminMiddleware.php';

AdminMiddleware::check();
AdminMiddleware::requirePermission('manage_roles');

$page_title = "Role Management - Admin Panel";
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
                $db->insert('roles', [
                    'name' => $name,
                    'slug' => $slug,
                    'description' => $description
                ]);
                $_SESSION['success'] = "Role created successfully.";
                AdminMiddleware::logAction('role_create', "Created role: {$name}");
            } catch (Exception $e) {
                $_SESSION['error'] = "Failed to create role: " . $e->getMessage();
            }
        }
        header('Location: /admin/roles');
        exit;
    }
    
    if ($action === 'update') {
        $roleId = $_POST['role_id'] ?? null;
        $name = sanitize_input($_POST['name'] ?? '');
        $description = sanitize_input($_POST['description'] ?? '');
        
        if ($roleId && $name) {
            try {
                $db->update('roles', [
                    'name' => $name,
                    'description' => $description
                ], 'id = ?', [$roleId]);
                $_SESSION['success'] = "Role updated successfully.";
                AdminMiddleware::logAction('role_update', "Updated role ID: {$roleId}");
            } catch (Exception $e) {
                $_SESSION['error'] = "Failed to update role.";
            }
        }
        header('Location: /admin/roles');
        exit;
    }
    
    if ($action === 'delete') {
        $roleId = $_POST['role_id'] ?? null;
        
        // Don't allow deletion of system roles
        if ($roleId && !in_array($roleId, [1, 2, 3])) {
            try {
                $db->delete('roles', 'id = ?', [$roleId]);
                $_SESSION['success'] = "Role deleted successfully.";
                AdminMiddleware::logAction('role_delete', "Deleted role ID: {$roleId}");
            } catch (Exception $e) {
                $_SESSION['error'] = "Failed to delete role.";
            }
        } else {
            $_SESSION['error'] = "System roles cannot be deleted.";
        }
        header('Location: /admin/roles');
        exit;
    }
    
    if ($action === 'assign_permissions') {
        $roleId = $_POST['role_id'] ?? null;
        $permissions = $_POST['permissions'] ?? [];
        
        if ($roleId) {
            try {
                // Delete existing permissions
                $db->delete('role_permissions', 'role_id = ?', [$roleId]);
                
                // Insert new permissions
                foreach ($permissions as $permissionId) {
                    $db->insert('role_permissions', [
                        'role_id' => $roleId,
                        'permission_id' => $permissionId
                    ]);
                }
                
                $_SESSION['success'] = "Permissions updated successfully.";
                AdminMiddleware::logAction('role_permissions_update', "Updated permissions for role ID: {$roleId}");
            } catch (Exception $e) {
                $_SESSION['error'] = "Failed to update permissions.";
            }
        }
        header('Location: /admin/roles');
        exit;
    }
}

// Get all roles
try {
    $roles = $db->fetchAll("SELECT * FROM roles ORDER BY id ASC");
    $permissions = $db->fetchAll("SELECT * FROM permissions ORDER BY name ASC");
    
    // Get permissions for each role
    foreach ($roles as &$role) {
        $rolePermissions = $db->fetchAll("
            SELECT p.id, p.name, p.slug
            FROM permissions p
            INNER JOIN role_permissions rp ON p.id = rp.permission_id
            WHERE rp.role_id = ?
        ", [$role['id']]);
        $role['permissions'] = $rolePermissions;
    }
    
} catch (Exception $e) {
    error_log("Roles fetch error: " . $e->getMessage());
    $roles = [];
}

include '../includes/header.php';
?>

<div class="admin-wrapper">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Role Management</h1>
            <button class="btn btn-primary" onclick="showCreateModal()">
                <i class="fas fa-plus"></i> Create Role
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

        <!-- Roles Grid -->
        <div class="roles-grid">
            <?php foreach ($roles as $role): ?>
                <div class="role-card">
                    <div class="role-header">
                        <h3><?php echo htmlspecialchars($role['name']); ?></h3>
                        <span class="role-badge"><?php echo htmlspecialchars($role['slug']); ?></span>
                    </div>
                    
                    <p class="role-description">
                        <?php echo htmlspecialchars($role['description'] ?? 'No description'); ?>
                    </p>
                    
                    <div class="role-stats">
                        <div class="stat-item">
                            <strong><?php echo count($role['permissions']); ?></strong>
                            <span>Permissions</span>
                        </div>
                        <div class="stat-item">
                            <strong><?php 
                                $userCount = $db->fetchColumn("SELECT COUNT(*) FROM users WHERE role = ?", [$role['id']]);
                                echo $userCount;
                            ?></strong>
                            <span>Users</span>
                        </div>
                    </div>
                    
                    <div class="role-permissions">
                        <h4>Permissions:</h4>
                        <div class="permission-tags">
                            <?php foreach (array_slice($role['permissions'], 0, 3) as $perm): ?>
                                <span class="permission-tag"><?php echo htmlspecialchars($perm['name']); ?></span>
                            <?php endforeach; ?>
                            <?php if (count($role['permissions']) > 3): ?>
                                <span class="permission-tag">+<?php echo count($role['permissions']) - 3; ?> more</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="role-actions">
                        <button class="btn btn-sm btn-primary" onclick="editRole(<?php echo htmlspecialchars(json_encode($role)); ?>)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-info" onclick="managePermissions(<?php echo $role['id']; ?>)">
                            <i class="fas fa-key"></i> Permissions
                        </button>
                        <?php if (!in_array($role['id'], [1, 2, 3])): ?>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Delete this role?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="role_id" value="<?php echo $role['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Create/Edit Role Modal -->
<div id="roleModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('roleModal')">&times;</span>
        <h2 id="modalTitle">Create Role</h2>
        <form method="POST" id="roleForm">
            <input type="hidden" name="action" id="formAction" value="create">
            <input type="hidden" name="role_id" id="roleId">
            
            <div class="form-group">
                <label>Role Name *</label>
                <input type="text" name="name" id="roleName" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Slug *</label>
                <input type="text" name="slug" id="roleSlug" class="form-control" required>
                <small>Lowercase, no spaces (e.g., content-manager)</small>
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="roleDescription" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('roleModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Role</button>
            </div>
        </form>
    </div>
</div>

<!-- Permissions Modal -->
<div id="permissionsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('permissionsModal')">&times;</span>
        <h2>Manage Permissions</h2>
        <form method="POST" id="permissionsForm">
            <input type="hidden" name="action" value="assign_permissions">
            <input type="hidden" name="role_id" id="permissionsRoleId">
            
            <div class="permissions-list">
                <?php foreach ($permissions as $permission): ?>
                    <label class="permission-item">
                        <input type="checkbox" name="permissions[]" value="<?php echo $permission['id']; ?>" class="permission-checkbox">
                        <div class="permission-info">
                            <strong><?php echo htmlspecialchars($permission['name']); ?></strong>
                            <p><?php echo htmlspecialchars($permission['description']); ?></p>
                        </div>
                    </label>
                <?php endforeach; ?>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('permissionsModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Permissions</button>
            </div>
        </form>
    </div>
</div>

<style>
.roles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.role-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.role-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.role-header h3 {
    margin: 0;
    font-size: 1.25rem;
}

.role-badge {
    padding: 0.25rem 0.75rem;
    background: #e9ecef;
    border-radius: 4px;
    font-size: 0.875rem;
    font-family: monospace;
}

.role-description {
    color: #6c757d;
    margin-bottom: 1rem;
}

.role-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin: 1rem 0;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.stat-item {
    text-align: center;
}

.stat-item strong {
    display: block;
    font-size: 1.5rem;
    color: #007bff;
}

.stat-item span {
    font-size: 0.875rem;
    color: #6c757d;
}

.role-permissions h4 {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.permission-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.permission-tag {
    padding: 0.25rem 0.75rem;
    background: #007bff;
    color: white;
    border-radius: 4px;
    font-size: 0.75rem;
}

.role-actions {
    display: flex;
    gap: 0.5rem;
    padding-top: 1rem;
    border-top: 1px solid #dee2e6;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: white;
    margin: 5% auto;
    padding: 2rem;
    border-radius: 12px;
    width: 90%;
    max-width: 600px;
    max-height: 80vh;
    overflow-y: auto;
}

.close {
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.permissions-list {
    max-height: 400px;
    overflow-y: auto;
    margin: 1rem 0;
}

.permission-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    cursor: pointer;
}

.permission-item:hover {
    background: #f8f9fa;
}

.permission-checkbox {
    width: 20px;
    height: 20px;
}

.permission-info strong {
    display: block;
    margin-bottom: 0.25rem;
}

.permission-info p {
    margin: 0;
    font-size: 0.875rem;
    color: #6c757d;
}

.modal-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 1.5rem;
}
</style>

<script>
function showCreateModal() {
    document.getElementById('modalTitle').textContent = 'Create Role';
    document.getElementById('formAction').value = 'create';
    document.getElementById('roleForm').reset();
    document.getElementById('roleSlug').readOnly = false;
    document.getElementById('roleModal').style.display = 'block';
}

function editRole(role) {
    document.getElementById('modalTitle').textContent = 'Edit Role';
    document.getElementById('formAction').value = 'update';
    document.getElementById('roleId').value = role.id;
    document.getElementById('roleName').value = role.name;
    document.getElementById('roleSlug').value = role.slug;
    document.getElementById('roleSlug').readOnly = true;
    document.getElementById('roleDescription').value = role.description || '';
    document.getElementById('roleModal').style.display = 'block';
}

function managePermissions(roleId) {
    document.getElementById('permissionsRoleId').value = roleId;
    
    // Get role permissions
    fetch(`/admin/api/role-permissions.php?role_id=${roleId}`)
        .then(response => response.json())
        .then(data => {
            // Uncheck all
            document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
            
            // Check permissions for this role
            data.permissions.forEach(permId => {
                const checkbox = document.querySelector(`input[value="${permId}"]`);
                if (checkbox) checkbox.checked = true;
            });
        });
    
    document.getElementById('permissionsModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Auto-generate slug from name
document.getElementById('roleName')?.addEventListener('input', function(e) {
    if (document.getElementById('formAction').value === 'create') {
        const slug = e.target.value.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-|-$/g, '');
        document.getElementById('roleSlug').value = slug;
    }
});

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>

<?php include '../includes/footer.php'; ?>