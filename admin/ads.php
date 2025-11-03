<?php
/**
 * Ad Management
 * Configure and monitor advertisements
 */

require_once '../config.php';
require_once '../includes/functions.php';
require_once '../middleware/AdminMiddleware.php';

AdminMiddleware::check();
AdminMiddleware::requirePermission('manage_ads');

$page_title = "Ad Management - Admin Panel";
$db = Database::getInstance();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_settings') {
        $settings = [
            'ads_enabled' => isset($_POST['ads_enabled']) ? 1 : 0,
            'adsense_client_id' => sanitize_input($_POST['adsense_client_id'] ?? ''),
            'vertical_ad_1' => sanitize_input($_POST['vertical_ad_1'] ?? ''),
            'vertical_ad_2' => sanitize_input($_POST['vertical_ad_2'] ?? ''),
            'horizontal_ad_1' => sanitize_input($_POST['horizontal_ad_1'] ?? ''),
            'horizontal_ad_2' => sanitize_input($_POST['horizontal_ad_2'] ?? '')
        ];
        
        foreach ($settings as $key => $value) {
            try {
                $db->query("
                    INSERT INTO settings (setting_key, setting_value) 
                    VALUES (?, ?)
                    ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)
                ", [$key, $value]);
            } catch (Exception $e) {
                error_log("Settings update error: " . $e->getMessage());
            }
        }
        
        $_SESSION['success'] = "Ad settings updated successfully.";
        AdminMiddleware::logAction('ads_update', "Updated ad settings");
        header('Location: /admin/ads');
        exit;
    }
}

// Get current settings
try {
    $settingsData = $db->fetchAll("SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'ads%' OR setting_key LIKE '%ad%'");
    $settings = [];
    foreach ($settingsData as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    
    // Get ad performance stats (last 30 days)
    $adStats = $db->fetchAll("
        SELECT 
            ad_position,
            SUM(impressions) as total_impressions,
            SUM(clicks) as total_clicks,
            AVG(ctr) as avg_ctr,
            SUM(revenue) as total_revenue
        FROM ad_performance
        WHERE date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        GROUP BY ad_position
    ");
    
} catch (Exception $e) {
    error_log("Ad settings fetch error: " . $e->getMessage());
    $settings = [];
    $adStats = [];
}

include '../includes/header.php';
?>

<div class="admin-wrapper">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="admin-content">
        <div class="admin-header">
            <h1>Ad Management</h1>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <!-- Ad Performance Stats -->
        <div class="stats-grid">
            <?php foreach ($adStats as $stat): ?>
                <div class="stat-card">
                    <h4><?php echo htmlspecialchars($stat['ad_position']); ?></h4>
                    <div class="stat-row">
                        <div>
                            <strong><?php echo number_format($stat['total_impressions']); ?></strong>
                            <span>Impressions</span>
                        </div>
                        <div>
                            <strong><?php echo number_format($stat['total_clicks']); ?></strong>
                            <span>Clicks</span>
                        </div>
                        <div>
                            <strong><?php echo number_format($stat['avg_ctr'], 2); ?>%</strong>
                            <span>CTR</span>
                        </div>
                        <div>
                            <strong>$<?php echo number_format($stat['total_revenue'], 2); ?></strong>
                            <span>Revenue</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Ad Settings Form -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Ad Configuration</h3>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="update_settings">
                    
                    <!-- Global Settings -->
                    <div class="form-section">
                        <h4>Global Settings</h4>
                        
                        <div class="form-group">
                            <label class="switch-label">
                                <input type="checkbox" name="ads_enabled" 
                                       <?php echo ($settings['ads_enabled'] ?? 0) ? 'checked' : ''; ?>>
                                <span class="switch-slider"></span>
                                Enable Advertisements
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label>Google AdSense Client ID</label>
                            <input type="text" 
                                   name="adsense_client_id" 
                                   class="form-control" 
                                   value="<?php echo htmlspecialchars($settings['adsense_client_id'] ?? ''); ?>"
                                   placeholder="ca-pub-xxxxxxxxxxxxxxxx">
                            <small>Your AdSense publisher ID</small>
                        </div>
                    </div>

                    <!-- Vertical Ads -->
                    <div class="form-section">
                        <h4>Vertical Ads (300x600)</h4>
                        
                        <div class="form-group">
                            <label>Vertical Ad #1 (Right Sidebar Top)</label>
                            <textarea name="vertical_ad_1" 
                                      class="form-control code-input" 
                                      rows="4"
                                      placeholder="<ins class='adsbygoogle'..."></ins>"><?php echo htmlspecialchars($settings['vertical_ad_1'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Vertical Ad #2 (Right Sidebar Bottom)</label>
                            <textarea name="vertical_ad_2" 
                                      class="form-control code-input" 
                                      rows="4"
                                      placeholder="<ins class='adsbygoogle'..."></ins>"><?php echo htmlspecialchars($settings['vertical_ad_2'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <!-- Horizontal Ads -->
                    <div class="form-section">
                        <h4>Horizontal Ads (728x90)</h4>
                        
                        <div class="form-group">
                            <label>Horizontal Ad #1 (After Results)</label>
                            <textarea name="horizontal_ad_1" 
                                      class="form-control code-input" 
                                      rows="4"
                                      placeholder="<ins class='adsbygoogle'..."></ins>"><?php echo htmlspecialchars($settings['horizontal_ad_1'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Horizontal Ad #2 (Before Footer)</label>
                            <textarea name="horizontal_ad_2" 
                                      class="form-control code-input" 
                                      rows="4"
                                      placeholder="<ins class='adsbygoogle'..."></ins>"><?php echo htmlspecialchars($settings['horizontal_ad_2'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Ad Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Ad Guidelines -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Ad Placement Guidelines</h3>
            </div>
            <div class="card-body">
                <div class="guidelines">
                    <h4>📍 Ad Positions:</h4>
                    <ul>
                        <li><strong>Vertical Ad #1:</strong> Right sidebar top (300x600) - Sticky position</li>
                        <li><strong>Vertical Ad #2:</strong> Right sidebar bottom (300x600) - Below first ad</li>
                        <li><strong>Horizontal Ad #1:</strong> After calculator results (728x90)</li>
                        <li><strong>Horizontal Ad #2:</strong> Before footer (728x90)</li>
                    </ul>
                    
                    <h4>✅ Best Practices:</h4>
                    <ul>
                        <li>Test ad placements regularly for optimal performance</li>
                        <li>Monitor CTR and adjust positions if needed</li>
                        <li>Ensure ads don't interfere with user experience</li>
                        <li>Comply with Google AdSense policies</li>
                        <li>Use responsive ad units for mobile</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stat-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    text-align: center;
}

.stat-row > div {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.stat-row strong {
    display: block;
    font-size: 1.5rem;
    color: #007bff;
}

.stat-row span {
    font-size: 0.875rem;
    color: #6c757d;
}

.form-section {
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 2rem;
}

.form-section h4 {
    margin-bottom: 1.5rem;
    color: #343a40;
}

.switch-label {
    display: flex;
    align-items: center;
    gap: 1rem;
    cursor: pointer;
}

.switch-slider {
    position: relative;
    width: 50px;
    height: 24px;
    background: #ccc;
    border-radius: 24px;
    transition: 0.3s;
}

input[type="checkbox"]:checked + .switch-slider {
    background: #007bff;
}

.code-input {
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
}

.guidelines {
    line-height: 1.8;
}

.guidelines h4 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    color: #343a40;
}

.guidelines ul {
    margin-left: 1.5rem;
}

.guidelines li {
    margin-bottom: 0.5rem;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    padding-top: 2rem;
    border-top: 1px solid #dee2e6;
}
</style>

<?php include '../includes/footer.php'; ?>