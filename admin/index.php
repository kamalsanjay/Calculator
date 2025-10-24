<?php
/**
 * Admin Dashboard - Overview with Statistics and Charts
 */

require_once 'includes/auth.php';
require_once 'includes/header.php';

// Get dashboard statistics
$stats = getDashboardStats();
$popularCalculators = getPopularCalculators(5);
$recentActivity = getRecentActivity(10);
$trafficData = getTrafficData(30); // Last 30 days
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
        </h1>
        <div>
            <button class="btn btn-sm btn-primary" onclick="refreshDashboard()">
                <i class="fas fa-sync-alt me-1"></i>Refresh
            </button>
            <a href="analytics.php" class="btn btn-sm btn-success">
                <i class="fas fa-chart-line me-1"></i>View Analytics
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Visitors -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Visitors (Today)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($stats['visitors_today']); ?>
                            </div>
                            <div class="text-xs text-success mt-1">
                                <i class="fas fa-arrow-up"></i>
                                <?php echo $stats['visitor_change']; ?>% from yesterday
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calculations -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Calculations (Today)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($stats['calculations_today']); ?>
                            </div>
                            <div class="text-xs text-success mt-1">
                                <i class="fas fa-arrow-up"></i>
                                <?php echo $stats['calculation_change']; ?>% from yesterday
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Calculators -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Calculators
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($stats['total_calculators']); ?>
                            </div>
                            <div class="text-xs text-muted mt-1">
                                <i class="fas fa-check-circle"></i>
                                <?php echo $stats['active_calculators']; ?> active
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-layer-group fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ad Revenue -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Est. Revenue (Today)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                $<?php echo number_format($stats['revenue_today'], 2); ?>
                            </div>
                            <div class="text-xs text-muted mt-1">
                                <i class="fas fa-coins"></i>
                                $<?php echo number_format($stats['revenue_month'], 2); ?> this month
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Traffic Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-area me-2"></i>Visitor Traffic Overview
                    </h6>
                    <div class="dropdown no-arrow">
                        <select class="form-select form-select-sm" id="trafficPeriod" onchange="updateTrafficChart()">
                            <option value="7">Last 7 Days</option>
                            <option value="30" selected>Last 30 Days</option>
                            <option value="90">Last 90 Days</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="trafficChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Calculator Usage Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Calculator Usage
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="usageChart"></canvas>
                    <div class="mt-3 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Loan
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> BMI
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Percentage
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Others
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Popular Calculators -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-fire me-2"></i>Popular Calculators
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Calculator</th>
                                    <th>Uses Today</th>
                                    <th>Trend</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($popularCalculators as $calc): ?>
                                <tr>
                                    <td>
                                        <i class="fas fa-<?php echo $calc['icon']; ?> me-2"></i>
                                        <a href="../<?php echo $calc['slug']; ?>.php" target="_blank">
                                            <?php echo htmlspecialchars($calc['name']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <strong><?php echo number_format($calc['uses_today']); ?></strong>
                                    </td>
                                    <td>
                                        <?php if ($calc['trend'] > 0): ?>
                                            <span class="text-success">
                                                <i class="fas fa-arrow-up"></i> <?php echo $calc['trend']; ?>%
                                            </span>
                                        <?php else: ?>
                                            <span class="text-danger">
                                                <i class="fas fa-arrow-down"></i> <?php echo abs($calc['trend']); ?>%
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="manage-calculators.php" class="btn btn-sm btn-primary mt-2">
                        <i class="fas fa-cog me-1"></i>Manage Calculators
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history me-2"></i>Recent Activity
                    </h6>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <?php foreach ($recentActivity as $activity): ?>
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <span class="badge bg-<?php echo getActivityBadgeColor($activity['action']); ?>">
                                    <i class="fas fa-<?php echo getActivityIcon($activity['action']); ?>"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1">
                                    <strong><?php echo htmlspecialchars($activity['username']); ?></strong>
                                    <?php echo htmlspecialchars($activity['description']); ?>
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    <?php echo timeAgo($activity['created_at']); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <a href="manage-calculators.php?action=add" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                                Add Calculator
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="analytics.php" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-chart-line fa-2x d-block mb-2"></i>
                                View Analytics
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="manage-ads.php" class="btn btn-warning btn-lg w-100">
                                <i class="fas fa-ad fa-2x d-block mb-2"></i>
                                Manage Ads
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="settings.php" class="btn btn-info btn-lg w-100">
                                <i class="fas fa-cogs fa-2x d-block mb-2"></i>
                                Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Traffic Chart
const trafficCtx = document.getElementById('trafficChart').getContext('2d');
const trafficChart = new Chart(trafficCtx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_column($trafficData, 'date')); ?>,
        datasets: [{
            label: 'Visitors',
            data: <?php echo json_encode(array_column($trafficData, 'visitors')); ?>,
            borderColor: 'rgb(78, 115, 223)',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            tension: 0.4,
            fill: true
        }, {
            label: 'Calculations',
            data: <?php echo json_encode(array_column($trafficData, 'calculations')); ?>,
            borderColor: 'rgb(28, 200, 138)',
            backgroundColor: 'rgba(28, 200, 138, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Usage Pie Chart
const usageCtx = document.getElementById('usageChart').getContext('2d');
const usageChart = new Chart(usageCtx, {
    type: 'doughnut',
    data: {
        labels: ['Loan Calculator', 'BMI Calculator', 'Percentage Calculator', 'Others'],
        datasets: [{
            data: [<?php echo implode(',', array_column($stats['calculator_usage'], 'percentage')); ?>],
            backgroundColor: [
                'rgb(78, 115, 223)',
                'rgb(28, 200, 138)',
                'rgb(54, 185, 204)',
                'rgb(246, 194, 62)'
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Refresh Dashboard
function refreshDashboard() {
    location.reload();
}

// Update Traffic Chart
function updateTrafficChart() {
    const period = document.getElementById('trafficPeriod').value;
    // Implement AJAX call to update chart data
    window.location.href = `?period=${period}`;
}

// Auto-refresh every 5 minutes
setTimeout(() => {
    location.reload();
}, 300000);
</script>

<?php require_once 'includes/footer.php'; ?>

<?php
/**
 * Helper Functions
 */

function getDashboardStats() {
    global $pdo;
    
    // Get today's stats
    $stmt = $pdo->query("
        SELECT 
            (SELECT COUNT(DISTINCT ip_address) FROM analytics WHERE DATE(created_at) = CURDATE()) as visitors_today,
            (SELECT COUNT(DISTINCT ip_address) FROM analytics WHERE DATE(created_at) = CURDATE() - INTERVAL 1 DAY) as visitors_yesterday,
            (SELECT COUNT(*) FROM calculator_usage WHERE DATE(created_at) = CURDATE()) as calculations_today,
            (SELECT COUNT(*) FROM calculator_usage WHERE DATE(created_at) = CURDATE() - INTERVAL 1 DAY) as calculations_yesterday,
            (SELECT COUNT(*) FROM calculators) as total_calculators,
            (SELECT COUNT(*) FROM calculators WHERE status = 'active') as active_calculators,
            (SELECT SUM(revenue) FROM ad_revenue WHERE DATE(created_at) = CURDATE()) as revenue_today,
            (SELECT SUM(revenue) FROM ad_revenue WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())) as revenue_month
    ");
    
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Calculate percentage changes
    $stats['visitor_change'] = $stats['visitors_yesterday'] > 0 
        ? round((($stats['visitors_today'] - $stats['visitors_yesterday']) / $stats['visitors_yesterday']) * 100, 1)
        : 0;
        
    $stats['calculation_change'] = $stats['calculations_yesterday'] > 0
        ? round((($stats['calculations_today'] - $stats['calculations_yesterday']) / $stats['calculations_yesterday']) * 100, 1)
        : 0;
    
    // Get calculator usage distribution
    $usageStmt = $pdo->query("
        SELECT c.name, COUNT(cu.id) as count,
            (COUNT(cu.id) * 100.0 / (SELECT COUNT(*) FROM calculator_usage WHERE DATE(created_at) = CURDATE())) as percentage
        FROM calculators c
        LEFT JOIN calculator_usage cu ON c.id = cu.calculator_id AND DATE(cu.created_at) = CURDATE()
        GROUP BY c.id
        ORDER BY count DESC
        LIMIT 4
    ");
    $stats['calculator_usage'] = $usageStmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $stats;
}

function getPopularCalculators($limit = 5) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT 
            c.id, c.name, c.slug, c.icon,
            COUNT(cu.id) as uses_today,
            (SELECT COUNT(*) FROM calculator_usage WHERE calculator_id = c.id AND DATE(created_at) = CURDATE() - INTERVAL 1 DAY) as uses_yesterday
        FROM calculators c
        LEFT JOIN calculator_usage cu ON c.id = cu.calculator_id AND DATE(cu.created_at) = CURDATE()
        WHERE c.status = 'active'
        GROUP BY c.id
        ORDER BY uses_today DESC
        LIMIT ?
    ");
    
    $stmt->execute([$limit]);
    $calculators = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculate trends
    foreach ($calculators as &$calc) {
        $calc['trend'] = $calc['uses_yesterday'] > 0
            ? round((($calc['uses_today'] - $calc['uses_yesterday']) / $calc['uses_yesterday']) * 100, 1)
            : 0;
    }
    
    return $calculators;
}

function getRecentActivity($limit = 10) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT al.*, au.username
        FROM activity_log al
        LEFT JOIN admin_users au ON al.user_id = au.id
        ORDER BY al.created_at DESC
        LIMIT ?
    ");
    
    $stmt->execute([$limit]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTrafficData($days = 30) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT 
            DATE(created_at) as date,
            COUNT(DISTINCT ip_address) as visitors,
            (SELECT COUNT(*) FROM calculator_usage WHERE DATE(created_at) = DATE(a.created_at)) as calculations
        FROM analytics a
        WHERE created_at >= CURDATE() - INTERVAL ? DAY
        GROUP BY DATE(created_at)
        ORDER BY date ASC
    ");
    
    $stmt->execute([$days]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getActivityBadgeColor($action) {
    $colors = [
        'login' => 'success',
        'logout' => 'secondary',
        'create' => 'primary',
        'update' => 'info',
        'delete' => 'danger',
        'failed_login' => 'danger'
    ];
    return $colors[$action] ?? 'secondary';
}

function getActivityIcon($action) {
    $icons = [
        'login' => 'sign-in-alt',
        'logout' => 'sign-out-alt',
        'create' => 'plus-circle',
        'update' => 'edit',
        'delete' => 'trash',
        'failed_login' => 'exclamation-triangle'
    ];
    return $icons[$action] ?? 'circle';
}

function timeAgo($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    if ($diff < 60) {
        return 'just now';
    } elseif ($diff < 3600) {
        $mins = floor($diff / 60);
        return $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } else {
        return date('M j, Y', $time);
    }
}
?>