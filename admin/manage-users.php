<?php
/**
 * User Management System
 * Complete CRUD for admin users
 * @version 1.0.0
 */

require_once 'includes/auth.php';

if ($_SESSION['admin_role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$message = '';
$error = '';
$action = $_GET['action'] ?? 'list';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Invalid request.';
    } else {
        switch ($_POST['action_type']) {
            case 'add':
            case 'edit':
                $result = saveUser($_POST);
                $message = $result['success'] ? $result['message'] : '';
                $error = !$result['success'] ? $result['message'] : '';
                if ($result['success']) $action = 'list';
                break;
            case 'delete':
                $result = deleteUser($_POST['id']);
                $message = $result['success'] ? $result['message'] : '';
                $error = !$result['success'] ? $result['message'] : '';
                break;
            case 'reset_password':
                $result = resetUserPassword($_POST['id'], $_POST['new_password']);
                $message = $result['success'] ? $result['message'] : '';
                $error = !$result['success'] ? $result['message'] : '';
                break;
        }
    }
}

$user = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $user = getUser($_GET['id']);
    if (!$user) {
        $error = 'User not found.';
        $action = 'list';
    }
}

$searchTerm = $_GET['search'] ?? '';
$roleFilter = $_GET['role'] ?? 'all';
$statusFilter = $_GET['status'] ?? 'all';
$users = getUsers($searchTerm, $roleFilter, $statusFilter);

require_once 'includes/header.php';
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users-cog me-2"></i>
            <?php echo $action === 'add' ? 'Add User' : ($action === 'edit' ? 'Edit User' : 'Manage Users'); ?>
        </h1>
        <?php if ($action === 'list'): ?>
        <a href="?action=add" class="btn btn-primary">
            <i class="fas fa-user-plus me-1"></i>Add New User
        </a>
        <?php endif; ?>
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

    <?php if ($action === 'list'): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Admin Users</h6>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="role">
                        <option value="all">All Roles</option>
                        <option value="admin" <?php echo $roleFilter === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="editor" <?php echo $roleFilter === 'editor' ? 'selected' : ''; ?>>Editor</option>
                        <option value="viewer" <?php echo $roleFilter === 'viewer' ? 'selected' : ''; ?>>Viewer</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="all">All Status</option>
                        <option value="active" <?php echo $statusFilter === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $statusFilter === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        <option value="suspended" <?php echo $statusFilter === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        <?php echo strtoupper(substr($u['username'], 0, 1)); ?>
                                    </div>
                                    <div>
                                        <strong><?php echo htmlspecialchars($u['username']); ?></strong>
                                        <?php if ($u['id'] == $_SESSION['admin_id']): ?>
                                        <span class="badge bg-info ms-1">You</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo ['admin'=>'danger','editor'=>'primary','viewer'=>'secondary'][$u['role']] ?? 'secondary'; ?>">
                                    <?php echo ucfirst($u['role']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo $u['status']==='active'?'success':($u['status']==='inactive'?'secondary':'danger'); ?>">
                                    <?php echo ucfirst($u['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($u['last_login']): ?>
                                <small><?php echo date('M j, Y g:i A', strtotime($u['last_login'])); ?></small>
                                <?php else: ?>
                                <small class="text-muted">Never</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="?action=edit&id=<?php echo $u['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-warning" 
                                            onclick="showResetModal(<?php echo $u['id']; ?>, '<?php echo htmlspecialchars($u['username'], ENT_QUOTES); ?>')">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <?php if ($u['id'] != $_SESSION['admin_id']): ?>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="deleteUser(<?php echo $u['id']; ?>, '<?php echo htmlspecialchars($u['username'], ENT_QUOTES); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                    <div class="h5 mb-0 font-weight-bold"><?php echo count($users); ?></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Users</div>
                    <div class="h5 mb-0 font-weight-bold"><?php echo countUsersByStatus('active'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Logged In Today</div>
                    <div class="h5 mb-0 font-weight-bold"><?php echo countUsersLoggedInToday(); ?></div>
                </div>
            </div>
        </div>
    </div>

    <?php else: ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" id="userForm">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="action_type" value="<?php echo $action; ?>">
                <?php if ($user): ?>
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Username *</label>
                        <input type="text" class="form-control" name="username" required
                               value="<?php echo $user['username'] ?? ''; ?>"
                               <?php echo $user ? 'readonly' : ''; ?>>
                        <?php if (!$user): ?>
                        <small class="text-muted">Cannot be changed after creation</small>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" required
                               value="<?php echo $user['email'] ?? ''; ?>">
                    </div>

                    <?php if (!$user): ?>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password *</label>
                        <input type="password" class="form-control" name="password" required minlength="8">
                        <small class="text-muted">Minimum 8 characters</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" class="form-control" name="password_confirm" required minlength="8">
                    </div>
                    <?php endif; ?>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Role *</label>
                        <select class="form-select" name="role" required>
                            <option value="">Select Role</option>
                            <option value="admin" <?php echo ($user['role'] ?? '') === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="editor" <?php echo ($user['role'] ?? '') === 'editor' ? 'selected' : ''; ?>>Editor</option>
                            <option value="viewer" <?php echo ($user['role'] ?? '') === 'viewer' ? 'selected' : ''; ?>>Viewer</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status *</label>
                        <select class="form-select" name="status" required>
                            <option value="active" <?php echo ($user['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($user['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                            <option value="suspended" <?php echo ($user['status'] ?? '') === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between">
                    <a href="?action=list" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i><?php echo $action === 'add' ? 'Create' : 'Update'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="action_type" value="reset_password">
                    <input type="hidden" name="id" id="reset_user_id">
                    <p>Reset password for: <strong id="reset_username"></strong></p>
                    <div class="mb-3">
                        <label class="form-label">New Password *</label>
                        <input type="password" class="form-control" name="new_password" required minlength="8">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" class="form-control" name="new_password_confirm" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key me-1"></i>Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary-color, #4e73df);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}
</style>

<script>
document.getElementById('userForm')?.addEventListener('submit', function(e) {
    const pass = document.querySelector('input[name="password"]');
    const conf = document.querySelector('input[name="password_confirm"]');
    if (pass && conf && pass.value !== conf.value) {
        e.preventDefault();
        alert('Passwords do not match!');
    }
});

function showResetModal(id, username) {
    document.getElementById('reset_user_id').value = id;
    document.getElementById('reset_username').textContent = username;
    new bootstrap.Modal(document.getElementById('resetPasswordModal')).show();
}

function deleteUser(id, username) {
    if (confirm(`Delete user "${username}"?`)) {
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
</script>

<?php
require_once 'includes/footer.php';

function getUsers($search, $role, $status) {
    global $pdo;
    $sql = "SELECT * FROM admin_users WHERE 1=1";
    $params = [];
    if ($search) {
        $sql .= " AND (username LIKE ? OR email LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    if ($role !== 'all') {
        $sql .= " AND role = ?";
        $params[] = $role;
    }
    if ($status !== 'all') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    $sql .= " ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUser($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function saveUser($data) {
    global $pdo;
    try {
        if (isset($data['id'])) {
            $stmt = $pdo->prepare("UPDATE admin_users SET email=?, role=?, status=?, updated_at=NOW() WHERE id=?");
            $stmt->execute([$data['email'], $data['role'], $data['status'], $data['id']]);
            logActivity($_SESSION['admin_id'], 'update', "Updated user: {$data['username']}");
            return ['success' => true, 'message' => 'User updated!'];
        } else {
            $check = $pdo->prepare("SELECT id FROM admin_users WHERE username=? OR email=?");
            $check->execute([$data['username'], $data['email']]);
            if ($check->fetch()) return ['success' => false, 'message' => 'Username/email exists.'];
            
            if ($data['password'] !== $data['password_confirm']) {
                return ['success' => false, 'message' => 'Passwords do not match.'];
            }
            if (strlen($data['password']) < 8) {
                return ['success' => false, 'message' => 'Password must be 8+ characters.'];
            }
            
            $hash = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
            $stmt = $pdo->prepare("INSERT INTO admin_users (username, email, password, role, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$data['username'], $data['email'], $hash, $data['role'], $data['status']]);
            logActivity($_SESSION['admin_id'], 'create', "Created user: {$data['username']}");
            return ['success' => true, 'message' => 'User created!'];
        }
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}


function deleteUser($id) {
    global $pdo;
    if ($id == $_SESSION['admin_id']) {
        return ['success' => false, 'message' => 'Cannot delete yourself.'];
    }
    $stmt = $pdo->prepare("SELECT username FROM admin_users WHERE id=?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $pdo->prepare("DELETE FROM admin_users WHERE id=?")->execute([$id]);
    logActivity($_SESSION['admin_id'], 'delete', "Deleted user: {$user['username']}");
    return ['success' => true, 'message' => 'User deleted!'];
}

function resetUserPassword($id, $password) {
    global $pdo;
    if (strlen($password) < 8) {
        return ['success' => false, 'message' => 'Password must be 8+ characters.'];
    }
    $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    $pdo->prepare("UPDATE admin_users SET password=?, updated_at=NOW() WHERE id=?")->execute([$hash, $id]);
    logActivity($_SESSION['admin_id'], 'update', "Reset password for user ID: {$id}");
    return ['success' => true, 'message' => 'Password reset!'];
}

function countUsersByStatus($status) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin_users WHERE status=?");
    $stmt->execute([$status]);
    return $stmt->fetchColumn();
}

function countUsersLoggedInToday() {
    global $pdo;
    return $pdo->query("SELECT COUNT(*) FROM admin_users WHERE DATE(last_login)=CURDATE()")->fetchColumn();
}
?>