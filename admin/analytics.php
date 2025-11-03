<?php
/**
 * Enhanced Analytics Page
 */

define('ADMIN_PANEL', true);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../middleware/AdminMiddleware.php';

AdminMiddleware::check();
$admin = AdminMiddleware::adminUser();

$db = Database::getInstance();

// Date range
$days = intval($_GET['days'] ?? 30);
$startDate = date('Y-m-d', strtotime("-{$days} days"));
$endDate = date('Y-m-d');

try {
    // Total stats
    $totalViews = $db->fetchColumn("
        SELECT COALESCE(SUM(page_views), 0) 
        FROM page_analytics 
        WHERE date BETWEEN ? AND ?
    ", [$startDate, $endDate]) ?? 0;
    
    $totalCalculations = $db->fetchColumn("
        SELECT COUNT(*) 
        FROM calculator_usage 
        WHERE DATE(created_at) BETWEEN ? AND ?
    ", [$startDate, $endDate]) ?? 0;
    
    $uniqueUsers = $db->fetchColumn("
        SELECT COUNT(DISTINCT ip_address) 
        FROM calculator_usage 
        WHERE DATE(created_at) BETWEEN ? AND ?
    ", [$startDate, $endDate]) ?? 0;
    
    // Top calculators
    $topCalculators = $db->fetchAll("
        SELECT c.name, c.category, COUNT(*) as usage_count
        FROM calculator_usage cu
        LEFT JOIN calculators c ON cu.calculator_id = c.id
        WHERE DATE(cu.created_at) BETWEEN ? AND ?
        GROUP BY cu.calculator_id
        ORDER BY usage_count DESC
        LIMIT 10
    ", [$startDate, $endDate]) ?? [];
    
    // Daily stats
    $dailyStats = $db->fetchAll("
        SELECT DATE(created_at) as date, COUNT(*) as count
        FROM calculator_usage
        WHERE DATE(created_at) BETWEEN ? AND ?
        GROUP BY DATE(created_at)
        ORDER BY date ASC
    ", [$startDate, $endDate]) ?? [];
    
    // Category breakdown
    $categoryStats = $db->fetchAll("
        SELECT c.category, cat.name as category_name, COUNT(*) as count
        FROM calculator_usage cu
        LEFT JOIN calculators c ON cu.calculator_id = c.id
        LEFT JOIN categories cat ON c.category = cat.slug
        WHERE DATE(cu.created_at) BETWEEN ? AND ?
        GROUP BY c.category
        ORDER BY count DESC
    ", [$startDate, $endDate]) ?? [];
    
} catch (Exception $e) {
    error_log('Analytics error: ' . $e->getMessage());
    $totalViews = $totalCalculations = $uniqueUsers = 0;
    $topCalculators = $dailyStats = $categoryStats = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>

        <main class="main-content">
            <div class="top-bar">
                <div class="welcome-text">
                    <h1><i class="fas fa-chart-line"></i> Analytics Dashboard</h1>
                    <p>Website performance and usage statistics</p>
                </div>
                <div class="user-info">
                    <select id="dateRange" class="form-control" onchange="changeDateRange(this.value)">
                        <option value="7" <?php echo $days === 7 ? 'selected' : ''; ?>>Last 7 Days</option>
                        <option value="30" <?php echo $days === 30 ? 'selected' : ''; ?>>Last 30 Days</option>
                        <option value="90" <?php echo $days === 90 ? 'selected' : ''; ?>>Last 90 Days</option>
                        <option value="365" <?php echo $days === 365 ? 'selected' : ''; ?>>Last Year</option>
                    </select>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-icon blue">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-card-value"><?php echo number_format($totalViews); ?></div>
                        <div class="stat-card-label">Total Page Views</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-icon green">
                            <i class="fas fa-calculator"></i>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-card-value"><?php echo number_format($totalCalculations); ?></div>
                        <div class="stat-card-label">Total Calculations</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-icon orange">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-card-value"><?php echo number_format($uniqueUsers); ?></div>
                        <div class="stat-card-label">Unique Users</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-icon red">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-card-value"><?php echo $uniqueUsers > 0 ? number_format($totalCalculations / $uniqueUsers, 1) : '0'; ?></div>
                        <div class="stat-card-label">Avg Calculations/User</div>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            <div class="content-card">
                <div class="content-card-header">
                    <h3><i class="fas fa-chart-area"></i> Daily Usage Trend</h3>
                </div>
                <div class="content-card-body">
                    <canvas id="usageChart" height="80"></canvas>
                </div>
            </div>

            <div class="content-grid">
                <!-- Top Calculators -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h3><i class="fas fa-fire"></i> Top Calculators</h3>
                    </div>
                    <div class="content-card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Calculator</th>
                                    <th>Category</th>
                                    <th>Uses</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($topCalculators as $calc): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($calc['name'] ?? 'Unknown'); ?></strong></td>
                                    <td><?php echo htmlspecialchars($calc['category'] ?? 'N/A'); ?></td>
                                    <td><span class="badge badge-primary"><?php echo number_format($calc['usage_count']); ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Category Breakdown -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h3><i class="fas fa-pie-chart"></i> Category Breakdown</h3>
                    </div>
                    <div class="content-card-body">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    function changeDateRange(days) {
        window.location.href = '?days=' + days;
    }

    // Usage Chart
    const dailyData = <?php echo json_encode($dailyStats); ?>;
    const ctx1 = document.getElementById('usageChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: dailyData.map(d => d.date),
            datasets: [{
                label: 'Daily Calculations',
                data: dailyData.map(d => d.count),
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Category Chart
    const categoryData = <?php echo json_encode($categoryStats); ?>;
    const ctx2 = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: categoryData.map(c => c.category_name || c.category),
            datasets: [{
                data: categoryData.map(c => c.count),
                backgroundColor: [
                    '#667eea', '#764ba2', '#f093fb', '#4facfe',
                    '#43e97b', '#fa709a', '#30cfd0', '#a8edea',
                    '#ff9a56', '#fccb90', '#e0c3fc', '#f77062'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    </script>
</body>
</html>