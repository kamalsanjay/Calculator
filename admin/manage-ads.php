<?php
/**
 * Manage Ads - Configure Ad Units and Track Performance
 */

require_once 'includes/auth.php';
require_once 'includes/header.php';

$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Invalid request.';
    } else {
        $result = saveAdConfiguration($_POST);
        if ($result['success']) {
            $message = $result['message'];
        } else {
            $error = $result['message'];
        }
    }
}

// Get ad configuration
$adConfig = getAdConfiguration();
$adPerformance = getAdPerformance(30); // Last 30 days
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-ad me-2"></i>Manage Advertisements
        </h1>
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

    <!-- Ad Performance Overview -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Revenue (30d)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                $<?php echo number_format($adPerformance['total_revenue'], 2); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Impressions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($adPerformance['total_impressions']); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300"></i>
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
                                Total Clicks
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($adPerformance['total_clicks']); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-mouse-pointer fa-2x text-gray-300"></i>
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
                                Click-Through Rate
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($adPerformance['ctr'], 2); ?>%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ad Configuration Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-cog me-2"></i>Ad Configuration
            </h6>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <!-- Global Settings -->
                <h5 class="mb-3">Global Settings</h5>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ad Network</label>
                        <select class="form-select" name="ad_network">
                            <option value="google_adsense" <?php echo ($adConfig['ad_network'] ?? '') === 'google_adsense' ? 'selected' : ''; ?>>Google AdSense</option>
                            <option value="media_net" <?php echo ($adConfig['ad_network'] ?? '') === 'media_net' ? 'selected' : ''; ?>>Media.net</option>
                            <option value="custom" <?php echo ($adConfig['ad_network'] ?? '') === 'custom' ? 'selected' : ''; ?>>Custom</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Publisher ID</label>
                        <input type="text" class="form-control" name="publisher_id"
                               value="<?php echo htmlspecialchars($adConfig['publisher_id'] ?? ''); ?>"
                               placeholder="ca-pub-XXXXXXXXXXXXXXXX">
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="ads_enabled" value="1"
                                   <?php echo ($adConfig['ads_enabled'] ?? 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label">
                                Enable Advertisements Globally
                            </label>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Ad Unit Positions -->
                <h5 class="mb-3">Ad Unit Positions</h5>

                <!-- Header Ad -->
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Header Ad Unit (728x90 Leaderboard)</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ad Unit ID</label>
                                <input type="text" class="form-control" name="header_ad_id"
                                       value="<?php echo htmlspecialchars($adConfig['header_ad_id'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="header_ad_status">
                                    <option value="1" <?php echo ($adConfig['header_ad_status'] ?? 1) ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo !($adConfig['header_ad_status'] ?? 1) ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Ad -->
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Sidebar Ad Unit (300x250 Rectangle)</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ad Unit ID</label>
                                <input type="text" class="form-control" name="sidebar_ad_id"
                                       value="<?php echo htmlspecialchars($adConfig['sidebar_ad_id'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="sidebar_ad_status">
                                    <option value="1" <?php echo ($adConfig['sidebar_ad_status'] ?? 1) ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo !($adConfig['sidebar_ad_status'] ?? 1) ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Ad -->
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>In-Content Ad Unit (336x280 Rectangle)</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ad Unit ID</label>
                                <input type="text" class="form-control" name="content_ad_id"
                                       value="<?php echo htmlspecialchars($adConfig['content_ad_id'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="content_ad_status">
                                    <option value="1" <?php echo ($adConfig['content_ad_status'] ?? 1) ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo !($adConfig['content_ad_status'] ?? 1) ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Ad -->
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>Footer Ad Unit (728x90 Leaderboard)</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ad Unit ID</label>
                                <input type="text" class="form-control" name="footer_ad_id"
                                       value="<?php echo htmlspecialchars($adConfig['footer_ad_id'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="footer_ad_status">
                                    <option value="1" <?php echo ($adConfig['footer_ad_status'] ?? 1) ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo !($adConfig['footer_ad_status'] ?? 1) ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Save Configuration
                </button>
            </form>
        </div>
    </div>

    <!-- Ad Performance Chart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-chart-bar me-2"></i>Performance Trends (Last 30 Days)
            </h6>
        </div>
        <div class="card-body">
            <canvas id="adPerformanceChart" height="80"></canvas>
        </div>
    </div>

    <!-- Ad Units Performance Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>Ad Units Performance
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Position</th>
                            <th>Impressions</th>
                            <th>Clicks</th>
                            <th>CTR</th>
                            <th>Revenue</th>
                            <th>RPM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($adPerformance['by_position'] as $pos): ?>
                        <tr>
                            <td><strong><?php echo ucfirst($pos['position']); ?></strong></td>
                            <td><?php echo number_format($pos['impressions']); ?></td>
                            <td><?php echo number_format($pos['clicks']); ?></td>
                            <td><?php echo number_format($pos['ctr'], 2); ?>%</td>
                            <td>$<?php echo number_format($pos['revenue'], 2); ?></td>
                            <td>$<?php echo number_format($pos['rpm'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('adPerformanceChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_column($adPerformance['daily'], 'date')); ?>,
        datasets: [{
            label: 'Revenue ($)',
            data: <?php echo json_encode(array_column($adPerformance['daily'], 'revenue')); ?>,
            borderColor: 'rgb(28, 200, 138)',
            backgroundColor: 'rgba(28, 200, 138, 0.1)',
            yAxisID: 'y'
        }, {
            label: 'Impressions',
            data: <?php echo json_encode(array_column($adPerformance['daily'], 'impressions')); ?>,
            borderColor: 'rgb(78, 115, 223)',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Revenue ($)'
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Impressions'
                },
                grid: {
                    drawOnChartArea: false
                }
            }
        }
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>

<?php
function getAdConfiguration() {
    global $pdo;
    $stmt = $pdo->query("SELECT config_key, config_value FROM settings WHERE config_key LIKE 'ad_%'");
    $config = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $config[str_replace('ad_', '', $row['config_key'])] = $row['config_value'];
    }
    return $config;
}

function saveAdConfiguration($data) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        $fields = [
            'ad_network', 'publisher_id', 'ads_enabled',
            'header_ad_id', 'header_ad_status',
            'sidebar_ad_id', 'sidebar_ad_status',
            'content_ad_id', 'content_ad_status',
            'footer_ad_id', 'footer_ad_status'
        ];
        
        $stmt = $pdo->prepare("
            INSERT INTO settings (config_key, config_value, updated_at) 
            VALUES (?, ?, NOW())
            ON DUPLICATE KEY UPDATE config_value = VALUES(config_value), updated_at = NOW()
        ");
        
        foreach ($fields as $field) {
            $value = $data[$field] ?? '';
            $stmt->execute([$field, $value]);
        }
        
        $pdo->commit();
        
        logActivity($_SESSION['admin_id'], 'update', 'Updated ad configuration');
        
        return ['success' => true, 'message' => 'Ad configuration saved successfully!'];
    } catch (Exception $e) {
        $pdo->rollBack();
        return ['success' => false, 'message' => 'Error saving configuration.'];
    }
}

function getAdPerformance($days = 30) {
    global $pdo;
    
    // Total stats
    $stmt = $pdo->prepare("
        SELECT 
            SUM(impressions) as total_impressions,
            SUM(clicks) as total_clicks,
            SUM(revenue) as total_revenue,
            (SUM(clicks) * 100.0 / NULLIF(SUM(impressions), 0)) as ctr
        FROM ad_performance
        WHERE date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
    ");
    $stmt->execute([$days]);
    $totals = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Daily performance
    $stmt = $pdo->prepare("
        SELECT 
            DATE_FORMAT(date, '%m/%d') as date,
            SUM(impressions) as impressions,
            SUM(clicks) as clicks,
            SUM(revenue) as revenue
        FROM ad_performance
        WHERE date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
        GROUP BY date
        ORDER BY date ASC
    ");
    $stmt->execute([$days]);
    $daily = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // By position
    $stmt = $pdo->prepare("
        SELECT 
            position,
            SUM(impressions) as impressions,
            SUM(clicks) as clicks,
            (SUM(clicks) * 100.0 / NULLIF(SUM(impressions), 0)) as ctr,
            SUM(revenue) as revenue,
            (SUM(revenue) * 1000.0 / NULLIF(SUM(impressions), 0)) as rpm
        FROM ad_performance
        WHERE date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
        GROUP BY position
        ORDER BY revenue DESC
    ");
    $stmt->execute([$days]);
    $byPosition = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return [
        'total_impressions' => $totals['total_impressions'] ?? 0,
        'total_clicks' => $totals['total_clicks'] ?? 0,
        'total_revenue' => $totals['total_revenue'] ?? 0,
        'ctr' => $totals['ctr'] ?? 0,
        'daily' => $daily,
        'by_position' => $byPosition
    ];
}
?>  
