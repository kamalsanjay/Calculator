<?php
/**
 * Admin Dashboard
 */

// Define admin context
define('ADMIN_PANEL', true);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../middleware/AdminMiddleware.php';

// Check admin authentication
AdminMiddleware::check();

// Get admin user
$admin = AdminMiddleware::adminUser();

// Get statistics
try {
    $db = Database::getInstance();
    
    // Total users
    $totalUsers = $db->fetchColumn("SELECT COUNT(*) FROM users") ?? 0;
    
    // Total calculators
    $totalCalculators = $db->fetchColumn("SELECT COUNT(*) FROM calculators WHERE is_active = 1") ?? 0;
    
    // Total page views today
    $viewsToday = $db->fetchColumn("
        SELECT COALESCE(SUM(page_views), 0) 
        FROM page_analytics 
        WHERE date = CURDATE()
    ") ?? 0;
    
    // Recent calculator usage
    $recentUsage = $db->fetchAll("
        SELECT c.name, cu.created_at, cu.ip_address
        FROM calculator_usage cu
        LEFT JOIN calculators c ON cu.calculator_id = c.id
        ORDER BY cu.created_at DESC
        LIMIT 10
    ") ?? [];
    
    // Popular calculators
    $popularCalcs = $db->fetchAll("
        SELECT name, page_views
        FROM calculators
        WHERE is_active = 1
        ORDER BY page_views DESC
        LIMIT 10
    ") ?? [];
    
} catch (Exception $e) {
    error_log('Dashboard error: ' . $e->getMessage());
    $totalUsers = 0;
    $totalCalculators = 0;
    $viewsToday = 0;
    $recentUsage = [];
    $popularCalcs = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Calculator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="welcome-text">
                    <h1>Welcome back, <?php echo htmlspecialchars($admin['username']); ?>!</h1>
                    <p>Here's what's happening with your calculator website today.</p>
                </div>
                <div class="user-info">
                    <span class="user-email"><?php echo htmlspecialchars($admin['email']); ?></span>
                    <a href="<?php echo SITE_URL; ?>" class="btn btn-primary" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Site
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-icon blue">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-card-trend">
                            <span class="trend-up">+12%</span>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-card-value"><?php echo number_format($totalUsers); ?></div>
                        <div class="stat-card-label">Total Users</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-icon green">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div class="stat-card-trend">
                            <span class="trend-neutral">296</span>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-card-value"><?php echo number_format($totalCalculators); ?></div>
                        <div class="stat-card-label">Active Calculators</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-icon orange">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-card-trend">
                            <span class="trend-up">+8%</span>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-card-value"><?php echo number_format($viewsToday); ?></div>
                        <div class="stat-card-label">Views Today</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-icon red">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-card-trend">
                            <span class="trend-down">Coming Soon</span>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-card-value">$0.00</div>
                        <div class="stat-card-label">Revenue</div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Popular Calculators -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h3><i class="fas fa-fire"></i> Popular Calculators</h3>
                        <a href="calculators.php" class="btn-link">View All</a>
                    </div>
                    <div class="content-card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Calculator</th>
                                    <th>Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($popularCalcs)): ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No data available</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($popularCalcs as $calc): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($calc['name']); ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">
                                                <?php echo number_format($calc['page_views']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h3><i class="fas fa-history"></i> Recent Activity</h3>
                        <a href="analytics.php" class="btn-link">View All</a>
                    </div>
                    <div class="content-card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Calculator</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($recentUsage)): ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No recent activity</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($recentUsage as $usage): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($usage['name'] ?? 'Unknown'); ?></td>
                                        <td class="text-muted">
                                            <?php echo date('M j, g:i A', strtotime($usage['created_at'])); ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h3>Quick Actions</h3>
                <div class="action-buttons">
                    <a href="calculators.php" class="action-btn">
                        <i class="fas fa-plus"></i>
                        <span>Add Calculator</span>
                    </a>
                    <a href="categories.php" class="action-btn">
                        <i class="fas fa-folder"></i>
                        <span>Manage Categories</span>
                    </a>
                    <a href="users.php" class="action-btn">
                        <i class="fas fa-users"></i>
                        <span>View Users</span>
                    </a>
                    <a href="settings.php" class="action-btn">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script src="<?php echo SITE_URL; ?>/assets/js/admin.js"></script>
</body>
</html>