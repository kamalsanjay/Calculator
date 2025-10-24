<?php
/**
 * Analytics Dashboard - Comprehensive Analytics with Export
 */

require_once 'includes/auth.php';
require_once 'includes/header.php';

// Get date range from request
$startDate = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
$endDate = $_GET['end_date'] ?? date('Y-m-d');

// Handle CSV export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    exportAnalyticsCSV($startDate, $endDate);
    exit();
}

// Get analytics data
$analytics = getAnalyticsData($startDate, $endDate);
$trafficSources = getTrafficSources($startDate, $endDate);
$calculatorStats = getCalculatorStats($startDate, $endDate);
$userEngagement = getUserEngagement($startDate, $endDate);
$deviceStats = getDeviceStats($startDate, $endDate);
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-line me-2"></i>Analytics Dashboard
        </h1>
        <div>
            <button class="btn btn-sm btn-success" onclick="window.location.href='?export=csv&start_date=<?php echo $startDate; ?>&end_date=<?php echo $endDate; ?>'">
                <i class="fas fa-file-export me-1"></i>Export to CSV
            </button>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Start Date</label>
                    <input type="date" class="form-control" name="start_date" 
                           value="<?php echo $startDate; ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">End Date</label>
                    <input type="date" class="form-control" name="end_date" 
                           value="<?php echo $endDate; ?>" max="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i>Apply Filter
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="resetDateRange()">
                        <i class="fas fa-undo me-1"></i>Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Visitors
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($analytics['total_visitors']); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Calculations
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($analytics['total_calculations']); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Avg. Session Duration
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo $analytics['avg_session_duration']; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Bounce Rate
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($analytics['bounce_rate'], 1); ?>%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Traffic Over Time -->
        <div class="col-xl-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-area me-2"></i>Traffic Over Time
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="trafficTimeChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Device Distribution -->
        <div class="col-xl-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-mobile-alt me-2"></i>Device Distribution
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="deviceChart"></canvas>
                    <div class="mt-3">
                        <?php foreach ($deviceStats as $device): ?>
                        <div class="mb-2">
                            <span class="me-2"><?php echo $device['device_type']; ?></span>
                            <span class="badge bg-primary"><?php echo $device['percentage']; ?>%</span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Traffic Sources & Calculator Stats -->
    <div class="row">
        <!-- Traffic Sources -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-share-alt me-2"></i>Traffic Sources
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Source</th>
                                    <th>Visitors</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($trafficSources as $source): ?>
                                <tr>
                                    <td>
                                        <i class="fas fa-<?php echo getSourceIcon($source['source']); ?> me-2"></i>
                                        <?php echo ucfirst($source['source']); ?>
                                    </td>
                                    <td><?php echo number_format($source['visitors']); ?></td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-primary" role="progressbar" 
                                                 style="width: <?php echo $source['percentage']; ?>%">
                                                <?php echo number_format($source['percentage'], 1); ?>%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calculator Performance -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calculator me-2"></i>Calculator Performance
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Calculator</th>
                                    <th>Uses</th>
                                    <th>Avg. Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($calculatorStats as $calc): ?>
                                <tr>
                                    <td>
                                        <i class="fas fa-<?php echo $calc['icon']; ?> me-2"></i>
                                        <?php echo htmlspecialchars($calc['name']); ?>
                                    </td>
                                    <td><strong><?php echo number_format($calc['uses']); ?></strong></td>
                                    <td><?php echo $calc['avg_time']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Engagement -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-check me-2"></i>User Engagement Metrics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="border-end">
                                <h3 class="text-primary"><?php echo number_format($userEngagement['new_visitors']); ?></h3>
                                <p class="text-muted mb-0">New Visitors</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-end">
                                <h3 class="text-success"><?php echo number_format($userEngagement['returning_visitors']); ?></h3>
                                <p class="text-muted mb-0">Returning Visitors</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-end">
                                <h3 class="text-info"><?php echo number_format($userEngagement['pages_per_session'], 1); ?></h3>
                                <p class="text-muted mb-0">Pages/Session</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <h3 class="text-warning"><?php echo number_format($userEngagement['conversion_rate'], 1); ?>%</h3>
                            <p class="text-muted mb-0">Conversion Rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Traffic Time Chart
const trafficTimeCtx = document.getElementById('trafficTimeChart').getContext('2d');
new Chart(trafficTimeCtx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_column($analytics['daily_data'], 'date')); ?>,
        datasets: [{
            label: 'Visitors',
            data: <?php echo json_encode(array_column($analytics['daily_data'], 'visitors')); ?>,
            borderColor: 'rgb(78, 115, 223)',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Device Chart
const deviceCtx = document.getElementById('deviceChart').getContext('2d');
new Chart(deviceCtx, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode(array_column($deviceStats, 'device_type')); ?>,
        datasets: [{
            data: <?php echo json_encode(array_column($deviceStats, 'count')); ?>,
            backgroundColor: [
                'rgb(78, 115, 223)',
                'rgb(28, 200, 138)',
                'rgb(246, 194, 62)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false }
        }
    }
});

function resetDateRange() {
    window.location.href = 'analytics.php';
}
</script>

<?php require_once 'includes/footer.php'; ?>

<?php
/**
 * Analytics Functions
 */

function getAnalyticsData($startDate, $endDate) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT 
            COUNT(DISTINCT ip_address) as total_visitors,
            (SELECT COUNT(*) FROM calculator_usage WHERE DATE(created_at) BETWEEN ? AND ?) as total_calculations,
            AVG(TIMESTAMPDIFF(SECOND, session_start, session_end)) as avg_duration,
            (SELECT COUNT(*) FROM analytics WHERE pages_viewed = 1 AND DATE(created_at) BETWEEN ? AND ?) * 100.0 / COUNT(*) as bounce_rate
        FROM analytics
        WHERE DATE(created_at) BETWEEN ? AND ?
    ");
    
    $stmt->execute([$startDate, $endDate, $startDate, $endDate, $startDate, $endDate]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Format average duration
    $seconds = $data['avg_duration'] ?? 0;
    $minutes = floor($seconds / 60);
    $secs = $seconds % 60;
    $data['avg_session_duration'] = sprintf('%d:%02d', $minutes, $secs);
    
    // Get daily data for chart
    $dailyStmt = $pdo->prepare("
        SELECT DATE(created_at) as date, COUNT(DISTINCT ip_address) as visitors
        FROM analytics
        WHERE DATE(created_at) BETWEEN ? AND ?
        GROUP BY DATE(created_at)
        ORDER BY date ASC
    ");
    $dailyStmt->execute([$startDate, $endDate]);
    $data['daily_data'] = $dailyStmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $data;
}

function getTrafficSources($startDate, $endDate) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT 
            COALESCE(referrer_source, 'Direct') as source,
            COUNT(DISTINCT ip_address) as visitors,
            (COUNT(DISTINCT ip_address) * 100.0 / (SELECT COUNT(DISTINCT ip_address) FROM analytics WHERE DATE(created_at) BETWEEN ? AND ?)) as percentage
        FROM analytics
        WHERE DATE(created_at) BETWEEN ? AND ?
        GROUP BY source
        ORDER BY visitors DESC
        LIMIT 10
    ");
    
    $stmt->execute([$startDate, $endDate, $startDate, $endDate]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCalculatorStats($startDate, $endDate) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT 
            c.name, c.icon,
            COUNT(cu.id) as uses,
            SEC_TO_TIME(AVG(cu.time_spent)) as avg_time
        FROM calculators c
        LEFT JOIN calculator_usage cu ON c.id = cu.calculator_id
        WHERE DATE(cu.created_at) BETWEEN ? AND ?
        GROUP BY c.id
        ORDER BY uses DESC
        LIMIT 10
    ");
    
    $stmt->execute([$startDate, $endDate]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserEngagement($startDate, $endDate) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT 
            COUNT(DISTINCT CASE WHEN is_new_visitor = 1 THEN ip_address END) as new_visitors,
            COUNT(DISTINCT CASE WHEN is_new_visitor = 0 THEN ip_address END) as returning_visitors,
            AVG(pages_viewed) as pages_per_session,
            (SELECT COUNT(*) FROM calculator_usage WHERE DATE(created_at) BETWEEN ? AND ?) * 100.0 / COUNT(*) as conversion_rate
        FROM analytics
        WHERE DATE(created_at) BETWEEN ? AND ?
    ");
    
    $stmt->execute([$startDate, $endDate, $startDate, $endDate]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getDeviceStats($startDate, $endDate) {
    global $pdo;
    
    $stmt = $pdo->prepare("
        SELECT 
            device_type,
            COUNT(*) as count,
            (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM analytics WHERE DATE(created_at) BETWEEN ? AND ?)) as percentage
        FROM analytics
        WHERE DATE(created_at) BETWEEN ? AND ?
        GROUP BY device_type
        ORDER BY count DESC
    ");
    
    $stmt->execute([$startDate, $endDate, $startDate, $endDate]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSourceIcon($source) {
    $icons = [
        'google' => 'search',
        'facebook' => 'facebook-f',
        'twitter' => 'twitter',
        'direct' => 'globe',
        'organic' => 'leaf'
    ];
    return $icons[strtolower($source)] ?? 'share-alt';
}


function exportAnalyticsCSV($startDate, $endDate) {
    global $pdo;
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="analytics_' . $startDate . '_to_' . $endDate . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    // Headers
    fputcsv($output, ['Date', 'Visitors', 'Calculations', 'Pages Viewed', 'Avg Session Duration']);
    
    // Data
    $stmt = $pdo->prepare("
        SELECT 
            DATE(created_at) as date,
            COUNT(DISTINCT ip_address) as visitors,
            (SELECT COUNT(*) FROM calculator_usage WHERE DATE(created_at) = DATE(a.created_at)) as calculations,
            SUM(pages_viewed) as pages_viewed,
            AVG(TIMESTAMPDIFF(SECOND, session_start, session_end)) as avg_duration
        FROM analytics a
        WHERE DATE(created_at) BETWEEN ? AND ?
        GROUP BY DATE(created_at)
        ORDER BY date ASC
    ");
    
    $stmt->execute([$startDate, $endDate]);
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }
    
    fclose($output);
}
?>
