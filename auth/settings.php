<?php
/**
 * Account Settings Page
 * Manage account preferences and settings
 */

require_once '../config.php';
require_once '../includes/functions.php';
require_once '../middleware/AuthMiddleware.php';

AuthMiddleware::check();

$page_title = "Account Settings - Calculator";
$error = '';
$success = '';

// Get user settings
try {
    $stmt = $db->prepare("
        SELECT u.*, us.theme, us.language, us.email_notifications, us.newsletter_subscription
        FROM users u
        LEFT JOIN user_settings us ON u.id = us.user_id
        WHERE u.id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    // Set default values if settings don't exist
    if (empty($user['theme'])) {
        $user['theme'] = 'light';
        $user['language'] = 'en';
        $user['email_notifications'] = 1;
        $user['newsletter_subscription'] = 0;
    }
    
} catch (PDOException $e) {
    error_log("Settings error: " . $e->getMessage());
    $error = "An error occurred loading settings.";
}

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = $_POST['theme'] ?? 'light';
    $language = $_POST['language'] ?? 'en';
    $email_notifications = isset($_POST['email_notifications']) ? 1 : 0;
    $newsletter_subscription = isset($_POST['newsletter_subscription']) ? 1 : 0;
    
    try {
        // Check if settings exist
        $stmt = $db->prepare("SELECT user_id FROM user_settings WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        
        if ($stmt->fetch()) {
            // Update existing settings
            $stmt = $db->prepare("
                UPDATE user_settings 
                SET theme = ?, language = ?, email_notifications = ?, newsletter_subscription = ?, updated_at = NOW()
                WHERE user_id = ?
            ");
            $stmt->execute([$theme, $language, $email_notifications, $newsletter_subscription, $_SESSION['user_id']]);
        } else {
            // Insert new settings
            $stmt = $db->prepare("
                INSERT INTO user_settings (user_id, theme, language, email_notifications, newsletter_subscription, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([$_SESSION['user_id'], $theme, $language, $email_notifications, $newsletter_subscription]);
        }
        
        $success = "Settings updated successfully!";
        
        // Update user array for display
        $user['theme'] = $theme;
        $user['language'] = $language;
        $user['email_notifications'] = $email_notifications;
        $user['newsletter_subscription'] = $newsletter_subscription;
        
    } catch (PDOException $e) {
        error_log("Settings update error: " . $e->getMessage());
        $error = "An error occurred updating settings.";
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
                    <a href="/auth/settings" class="active">Settings</a>
                    <a href="/auth/change-password">Change Password</a>
                    <a href="/auth/logout">Logout</a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4>Account Settings</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-error"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <!-- Appearance Settings -->
                        <div class="settings-section">
                            <h5>Appearance</h5>
                            
                            <div class="form-group">
                                <label for="theme">Theme</label>
                                <select id="theme" name="theme" class="form-control">
                                    <option value="light" <?php echo $user['theme'] === 'light' ? 'selected' : ''; ?>>Light</option>
                                    <option value="dark" <?php echo $user['theme'] === 'dark' ? 'selected' : ''; ?>>Dark</option>
                                    <option value="auto" <?php echo $user['theme'] === 'auto' ? 'selected' : ''; ?>>Auto (System)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="language">Language</label>
                                <select id="language" name="language" class="form-control">
                                    <option value="en" <?php echo $user['language'] === 'en' ? 'selected' : ''; ?>>English</option>
                                    <option value="es" <?php echo $user['language'] === 'es' ? 'selected' : ''; ?>>Español</option>
                                    <option value="fr" <?php echo $user['language'] === 'fr' ? 'selected' : ''; ?>>Français</option>
                                    <option value="de" <?php echo $user['language'] === 'de' ? 'selected' : ''; ?>>Deutsch</option>
                                </select>
                            </div>
                        </div>

                        <!-- Notification Settings -->
                        <div class="settings-section">
                            <h5>Notifications</h5>
                            
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    id="email_notifications" 
                                    name="email_notifications" 
                                    class="form-check-input"
                                    <?php echo $user['email_notifications'] ? 'checked' : ''; ?>
                                >
                                <label for="email_notifications" class="form-check-label">
                                    Email Notifications
                                    <small class="d-block text-muted">Receive emails about account activity</small>
                                </label>
                            </div>

                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    id="newsletter_subscription" 
                                    name="newsletter_subscription" 
                                    class="form-check-input"
                                    <?php echo $user['newsletter_subscription'] ? 'checked' : ''; ?>
                                >
                                <label for="newsletter_subscription" class="form-check-label">
                                    Newsletter Subscription
                                    <small class="d-block text-muted">Receive updates and tips via email</small>
                                </label>
                            </div>
                        </div>

                        <!-- Privacy Settings -->
                        <div class="settings-section">
                            <h5>Privacy</h5>
                            
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    id="profile_public" 
                                    name="profile_public" 
                                    class="form-check-input"
                                >
                                <label for="profile_public" class="form-check-label">
                                    Make profile public
                                    <small class="d-block text-muted">Allow others to view your profile</small>
                                </label>
                            </div>

                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    id="show_activity" 
                                    name="show_activity" 
                                    class="form-check-input"
                                >
                                <label for="show_activity" class="form-check-label">
                                    Show activity
                                    <small class="d-block text-muted">Display your recent calculations</small>
                                </label>
                            </div>
                        </div>

                        <!-- Account Actions -->
                        <div class="settings-section">
                            <h5>Account</h5>
                            
                            <div class="d-flex gap-3">
                                <a href="/auth/two-factor-auth" class="btn btn-outline-primary">
                                    <i class="fas fa-shield-alt"></i> Two-Factor Authentication
                                </a>
                                <a href="/auth/delete-account" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i> Delete Account
                                </a>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.settings-section {
    padding: 2rem 0;
    border-bottom: 1px solid #dee2e6;
}

.settings-section:last-of-type {
    border-bottom: none;
}

.settings-section h5 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    color: #343a40;
}

.form-check {
    padding: 1rem 0;
}

.form-check-label {
    font-weight: 500;
    cursor: pointer;
}

.form-check-label small {
    font-weight: 400;
    margin-top: 0.25rem;
}

.d-flex.gap-3 {
    gap: 1rem;
}

@media (max-width: 768px) {
    .d-flex.gap-3 {
        flex-direction: column;
    }
    
    .d-flex.gap-3 .btn {
        width: 100%;
    }
}
</style>

<?php include '../includes/footer.php'; ?>