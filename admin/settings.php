<?php
/**
 * Enhanced Settings Page
 */

define('ADMIN_PANEL', true);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../middleware/AdminMiddleware.php';

AdminMiddleware::check();
$admin = AdminMiddleware::adminUser();

$success = '';
$error = '';

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In a real application, you would save these to a database or config file
    $success = 'Settings updated successfully!';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>

        <main class="main-content">
            <div class="top-bar">
                <div class="welcome-text">
                    <h1><i class="fas fa-cog"></i> Website Settings</h1>
                    <p>Configure your website</p>
                </div>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <div class="settings-grid">
                <!-- General Settings -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h3><i class="fas fa-globe"></i> General Settings</h3>
                    </div>
                    <div class="content-card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label class="form-label">Site Name</label>
                                <input type="text" class="form-control" value="Calculator" name="site_name">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Site URL</label>
                                <input type="text" class="form-control" value="<?php echo SITE_URL; ?>" name="site_url" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Site Description</label>
                                <textarea class="form-control" rows="3" name="site_description">Free online calculators for all your needs</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Email Settings -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h3><i class="fas fa-envelope"></i> Email Settings</h3>
                    </div>
                    <div class="content-card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label class="form-label">From Email</label>
                                <input type="email" class="form-control" value="<?php echo MAIL_FROM_ADDRESS; ?>" name="from_email">
                            </div>
                            <div class="form-group">
                                <label class="form-label">From Name</label>
                                <input type="text" class="form-control" value="<?php echo MAIL_FROM_NAME; ?>" name="from_name">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Admin Email</label>
                                <input type="email" class="form-control" value="admin@calculator.com" name="admin_email">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h3><i class="fas fa-search"></i> SEO Settings</h3>
                    </div>
                    <div class="content-card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label class="form-label">Default Meta Title</label>
                                <input type="text" class="form-control" value="Calculator - Free Online Calculators" name="meta_title">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Default Meta Description</label>
                                <textarea class="form-control" rows="2" name="meta_description">Access 300+ free online calculators for finance, health, math, and more</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" value="calculator, online calculator, free calculator" name="meta_keywords">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Advertisement Settings -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h3><i class="fas fa-ad"></i> Advertisement Settings</h3>
                    </div>
                    <div class="content-card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label class="form-checkbox">
                                    <input type="checkbox" name="ads_enabled" checked>
                                    <span>Enable Advertisements</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="form-label">AdSense Publisher ID</label>
                                <input type="text" class="form-control" placeholder="ca-pub-XXXXXXXXXXXXXXXX" name="adsense_id">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Adsterra Key</label>
                                <input type="text" class="form-control" placeholder="Your Adsterra Key" name="adsterra_key">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Database Info -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h3><i class="fas fa-database"></i> Database Information</h3>
                    </div>
                    <div class="content-card-body">
                        <div class="setting-item">
                            <div class="setting-label">Database Name</div>
                            <div class="setting-value"><code><?php echo DB_NAME; ?></code></div>
                        </div>
                        <div class="setting-item">
                            <div class="setting-label">Database Host</div>
                            <div class="setting-value"><code><?php echo DB_HOST; ?></code></div>
                        </div>
                        <div class="setting-item">
                            <div class="setting-label">PHP Version</div>
                            <div class="setting-value"><code><?php echo phpversion(); ?></code></div>
                        </div>
                    </div>
                </div>

                <!-- Maintenance Mode -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h3><i class="fas fa-tools"></i> Maintenance Mode</h3>
                    </div>
                    <div class="content-card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label class="form-checkbox">
                                    <input type="checkbox" name="maintenance_mode">
                                    <span>Enable Maintenance Mode</span>
                                </label>
                                <small class="form-text">Website will show maintenance page to all visitors except admins</small>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Maintenance Message</label>
                                <textarea class="form-control" rows="3" name="maintenance_message">We're currently performing maintenance. Please check back soon!</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
        gap: 2rem;
    }

    .setting-item {
        display: flex;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid #f1f3f5;
    }

    .setting-item:last-child {
        border-bottom: none;
    }

    .setting-label {
        font-weight: 600;
        color: #495057;
    }

    .setting-value {
        color: #6c757d;
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

    code {
        background: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        color: #667eea;
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

    @media (max-width: 1024px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</body>
</html>