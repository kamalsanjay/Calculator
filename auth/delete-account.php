<?php
/**
 * Delete Account Page
 * Allow users to permanently delete their account
 */

require_once '../config.php';
require_once '../includes/functions.php';
require_once '../middleware/AuthMiddleware.php';

AuthMiddleware::check();

$page_title = "Delete Account - Calculator";
$error = '';
$success = '';

// Get user data
try {
    $stmt = $db->prepare("SELECT username, email, avatar FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    error_log("Delete account error: " . $e->getMessage());
}

// Handle account deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm_text = $_POST['confirm_text'] ?? '';
    
    if (empty($password)) {
        $error = "Please enter your password to confirm.";
    } elseif (strtoupper($confirm_text) !== 'DELETE') {
        $error = "Please type DELETE to confirm account deletion.";
    } else {
        try {
            // Verify password
            $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $stored_password = $stmt->fetchColumn();
            
            if (!password_verify($password, $stored_password)) {
                $error = "Incorrect password.";
            } else {
                // Begin transaction
                $db->beginTransaction();
                
                try {
                    // Delete user data
                    $stmt = $db->prepare("DELETE FROM saved_calculations WHERE user_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    
                    $stmt = $db->prepare("DELETE FROM calculator_usage WHERE user_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    
                    $stmt = $db->prepare("DELETE FROM user_settings WHERE user_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    
                    $stmt = $db->prepare("DELETE FROM remember_tokens WHERE user_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    
                    $stmt = $db->prepare("DELETE FROM email_verifications WHERE user_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    
                    $stmt = $db->prepare("DELETE FROM password_resets WHERE user_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    
                    $stmt = $db->prepare("DELETE FROM two_factor_auth WHERE user_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    
                    // Delete user account
                    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    
                    // Commit transaction
                    $db->commit();
                    
                    // Destroy session
                    session_destroy();
                    
                    // Redirect to homepage
                    header('Location: /?account_deleted=1');
                    exit;
                    
                } catch (Exception $e) {
                    $db->rollBack();
                    throw $e;
                }
            }
        } catch (PDOException $e) {
            error_log("Account deletion error: " . $e->getMessage());
            $error = "An error occurred. Please try again.";
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
                    <a href="/auth/profile">Profile</a>
                    <a href="/auth/settings">Settings</a>
                    <a href="/auth/change-password">Change Password</a>
                    <a href="/auth/logout">Logout</a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h4><i class="fas fa-exclamation-triangle"></i> Delete Account</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <h5><i class="fas fa-exclamation-circle"></i> Warning: This action is irreversible!</h5>
                        <p class="mb-0">Once you delete your account, there is no going back. All your data will be permanently deleted.</p>
                    </div>

                    <div class="deletion-info mb-4">
                        <h5>What will be deleted:</h5>
                        <ul>
                            <li><i class="fas fa-times text-danger"></i> Your profile information</li>
                            <li><i class="fas fa-times text-danger"></i> All saved calculations</li>
                            <li><i class="fas fa-times text-danger"></i> Calculation history</li>
                            <li><i class="fas fa-times text-danger"></i> Account settings and preferences</li>
                            <li><i class="fas fa-times text-danger"></i> All associated data</li>
                        </ul>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-error"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" id="deleteAccountForm">
                        <div class="form-group">
                            <label for="password">Confirm Your Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control" 
                                required
                                placeholder="Enter your password"
                            >
                        </div>

                        <div class="form-group">
                            <label for="confirm_text">Type <strong>DELETE</strong> to confirm</label>
                            <input 
                                type="text" 
                                id="confirm_text" 
                                name="confirm_text" 
                                class="form-control" 
                                required
                                placeholder="Type DELETE in capital letters"
                            >
                        </div>

                        <div class="form-check mb-4">
                            <input 
                                type="checkbox" 
                                id="understand" 
                                class="form-check-input" 
                                required
                            >
                            <label for="understand" class="form-check-label">
                                I understand that this action cannot be undone
                            </label>
                        </div>

                        <button type="submit" class="btn btn-danger" id="deleteBtn" disabled>
                            <i class="fas fa-trash"></i> Delete My Account
                        </button>
                        <a href="/auth/profile" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

            <!-- Alternative Options -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Looking for alternatives?</h5>
                </div>
                <div class="card-body">
                    <p>If you're not satisfied with our service, consider these options instead of deleting your account:</p>
                    <ul>
                        <li><a href="/auth/settings">Disable email notifications</a></li>
                        <li><a href="/contact">Contact support</a> for help</li>
                        <li>Simply stop using the service (your data will remain secure)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card.border-danger {
    border-width: 2px;
}

.deletion-info ul {
    list-style: none;
    padding-left: 0;
}

.deletion-info li {
    padding: 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.deletion-info i {
    font-size: 1.25rem;
}

.alert-danger h5 {
    margin-bottom: 0.5rem;
}
</style>

<script>
// Enable delete button only when checkbox is checked and form is valid
const form = document.getElementById('deleteAccountForm');
const checkbox = document.getElementById('understand');
const deleteBtn = document.getElementById('deleteBtn');
const confirmText = document.getElementById('confirm_text');

function checkFormValidity() {
    const isValid = checkbox.checked && confirmText.value.toUpperCase() === 'DELETE';
    deleteBtn.disabled = !isValid;
}

checkbox.addEventListener('change', checkFormValidity);
confirmText.addEventListener('input', checkFormValidity);

// Confirm before submitting
form.addEventListener('submit', function(e) {
    if (!confirm('Are you absolutely sure you want to delete your account? This action cannot be undone!')) {
        e.preventDefault();
    }
});
</script>

<?php include '../includes/footer.php'; ?>