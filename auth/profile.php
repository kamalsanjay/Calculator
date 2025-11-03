<?php
/**
 * User Profile Page
 * Display and edit user profile information
 */

require_once '../config.php';
require_once '../includes/functions.php';
require_once '../middleware/AuthMiddleware.php';

AuthMiddleware::check();

$page_title = "My Profile - Calculator";
$error = '';
$success = '';

// Get user data
try {
    $stmt = $db->prepare("
        SELECT id, username, email, created_at, last_login, avatar 
        FROM users 
        WHERE id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    // Get calculation statistics
    $stmt = $db->prepare("
        SELECT COUNT(*) as total_calculations 
        FROM calculator_usage 
        WHERE user_id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $stats = $stmt->fetch();
    
    // Get saved calculations
    $stmt = $db->prepare("
        SELECT sc.*, c.name as calculator_name 
        FROM saved_calculations sc
        JOIN calculators c ON sc.calculator_id = c.id
        WHERE sc.user_id = ?
        ORDER BY sc.created_at DESC
        LIMIT 10
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $saved_calculations = $stmt->fetchAll();
    
} catch (PDOException $e) {
    error_log("Profile error: " . $e->getMessage());
    $error = "An error occurred loading your profile.";
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_input($_POST['username'] ?? '');
    
    if (empty($username)) {
        $error = "Username is required.";
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $error = "Username must be between 3 and 50 characters.";
    } else {
        try {
            // Check if username is taken by another user
            $stmt = $db->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
            $stmt->execute([$username, $_SESSION['user_id']]);
            if ($stmt->fetch()) {
                $error = "Username already taken.";
            } else {
                // Update username
                $stmt = $db->prepare("UPDATE users SET username = ? WHERE id = ?");
                $stmt->execute([$username, $_SESSION['user_id']]);
                
                $_SESSION['username'] = $username;
                $user['username'] = $username;
                $success = "Profile updated successfully!";
            }
        } catch (PDOException $e) {
            error_log("Profile update error: " . $e->getMessage());
            $error = "An error occurred updating your profile.";
        }
    }
}

include '../includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="profile-sidebar">
                <div class="profile-avatar">
                    <img src="<?php echo $user['avatar'] ?? '/assets/images/default-avatar.png'; ?>" alt="Avatar">
                </div>
                <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                
                <div class="profile-menu">
                    <a href="/auth/profile" class="active">Profile</a>
                    <a href="/auth/settings">Settings</a>
                    <a href="/auth/change-password">Change Password</a>
                    <a href="/auth/logout">Logout</a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <!-- Profile Stats -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <h4><?php echo number_format($stats['total_calculations']); ?></h4>
                        <p>Total Calculations</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <h4><?php echo count($saved_calculations); ?></h4>
                        <p>Saved Calculations</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <h4><?php echo date('M Y', strtotime($user['created_at'])); ?></h4>
                        <p>Member Since</p>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-error"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                class="form-control" 
                                value="<?php echo htmlspecialchars($user['username']); ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input 
                                type="email" 
                                class="form-control" 
                                value="<?php echo htmlspecialchars($user['email']); ?>"
                                disabled
                            >
                            <small class="form-text">Email cannot be changed</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>

            <!-- Saved Calculations -->
            <div class="card">
                <div class="card-header">
                    <h4>Saved Calculations</h4>
                </div>
                <div class="card-body">
                    <?php if (empty($saved_calculations)): ?>
                        <p class="text-muted">No saved calculations yet.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Calculator</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($saved_calculations as $calc): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($calc['calculator_name']); ?></td>
                                            <td><?php echo htmlspecialchars($calc['calculation_name']); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($calc['created_at'])); ?></td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-primary">View</a>
                                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
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
    </div>
</div>

<style>
.profile-sidebar {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.profile-avatar img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 1rem;
}

.profile-menu {
    margin-top: 2rem;
}

.profile-menu a {
    display: block;
    padding: 0.75rem 1rem;
    color: #343a40;
    text-decoration: none;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    transition: 0.3s ease;
}

.profile-menu a:hover,
.profile-menu a.active {
    background: #667eea;
    color: white;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.stat-card h4 {
    font-size: 2rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 0.5rem;
}

.stat-card p {
    color: #6c757d;
    margin: 0;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card-header {
    border-bottom: 1px solid #dee2e6;
    padding: 1.5rem;
}

.card-body {
    padding: 1.5rem;
}
</style>

<?php include '../includes/footer.php'; ?>