<?php
/**
 * Swim Pace Calculator
 * Calculate swimming pace per 100m/yards
 */

require_once '../../config.php';
require_once '../../includes/functions.php';

$page_title = "Swim Pace Calculator - Calculate Swimming Pace Per 100m/100yd";
$page_description = "Free swim pace calculator. Calculate your swimming pace per 100 meters or yards. Convert between different distances and time formats for training.";
$calculator_category = "sports";
$calculator_name = "Swim Pace Calculator";

// Calculation logic
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $distance = floatval($_POST['distance'] ?? 0);
    $distance_unit = sanitize_input($_POST['distance_unit'] ?? 'meters');
    $minutes = intval($_POST['minutes'] ?? 0);
    $seconds = intval($_POST['seconds'] ?? 0);
    
    if ($distance > 0 && ($minutes > 0 || $seconds > 0)) {
        $total_seconds = ($minutes * 60) + $seconds;
        
        // Convert to 100m/100yd pace
        $pace_seconds = ($total_seconds / $distance) * 100;
        $pace_minutes = floor($pace_seconds / 60);
        $pace_secs = $pace_seconds % 60;
        
        // Speed calculations
        $speed_mps = $distance / $total_seconds; // meters per second
        $speed_mph = ($speed_mps * 3600) / 1609.34; // miles per hour
        $speed_kph = ($speed_mps * 3600) / 1000; // kilometers per hour
        
        // Common race times
        $races = [
            '50' => 50,
            '100' => 100,
            '200' => 200,
            '400' => 400,
            '800' => 800,
            '1500' => 1500
        ];
        
        $race_times = [];
        foreach ($races as $name => $dist) {
            $time = ($pace_seconds / 100) * $dist;
            $race_times[$name] = [
                'distance' => $dist,
                'time' => $time,
                'formatted' => format_time($time)
            ];
        }
        
        $result = [
            'distance' => $distance,
            'distance_unit' => $distance_unit,
            'time' => format_time($total_seconds),
            'pace_100' => sprintf("%d:%05.2f", $pace_minutes, $pace_secs),
            'speed_mps' => $speed_mps,
            'speed_mph' => $speed_mph,
            'speed_kph' => $speed_kph,
            'race_times' => $race_times
        ];
    }
}

function format_time($seconds) {
    $minutes = floor($seconds / 60);
    $secs = $seconds % 60;
    if ($minutes > 0) {
        return sprintf("%d:%05.2f", $minutes, $secs);
    }
    return sprintf("%.2f seconds", $secs);
}

require_once '../../includes/header.php';
?>

<div class="calculator-page">
    <div class="container">
        <?php echo generate_breadcrumb($calculator_category, $calculator_name); ?>
        
        <div class="calculator-container">
            <!-- Main Calculator -->
            <div class="calculator-main">
                <h1><?php echo $calculator_name; ?></h1>
                <p class="calculator-description">
                    Calculate your swimming pace per 100 meters or 100 yards. Perfect for training, tracking progress, and race planning.
                </p>

                <!-- Calculator Form -->
                <div class="calculator-form">
                    <form method="POST" id="swimPaceForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Distance Swum</label>
                                <input type="number" 
                                       name="distance" 
                                       class="form-control" 
                                       step="1"
                                       min="1"
                                       value="<?php echo $_POST['distance'] ?? ''; ?>"
                                       placeholder="e.g., 400"
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Unit</label>
                                <select name="distance_unit" class="form-control">
                                    <option value="meters" <?php echo ($_POST['distance_unit'] ?? '') === 'meters' ? 'selected' : ''; ?>>Meters</option>
                                    <option value="yards" <?php echo ($_POST['distance_unit'] ?? '') === 'yards' ? 'selected' : ''; ?>>Yards</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Time - Minutes</label>
                                <input type="number" 
                                       name="minutes" 
                                       class="form-control" 
                                       min="0"
                                       value="<?php echo $_POST['minutes'] ?? ''; ?>"
                                       placeholder="0">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Time - Seconds</label>
                                <input type="number" 
                                       name="seconds" 
                                       class="form-control" 
                                       min="0"
                                       max="59"
                                       value="<?php echo $_POST['seconds'] ?? ''; ?>"
                                       placeholder="0"
                                       required>
                            </div>
                        </div>

                        <div class="calculator-buttons">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calculator"></i> Calculate Pace
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>

                <?php if ($result): ?>
                <!-- Results -->
                <div class="result-card">
                    <h3>Your Swimming Pace</h3>
                    
                    <div class="result-primary">
                        <?php echo $result['pace_100']; ?>
                        <span style="font-size: 1.5rem;">per 100<?php echo $result['distance_unit'] === 'meters' ? 'm' : 'yd'; ?></span>
                    </div>

                    <div class="result-details">
                        <div class="result-item">
                            <div class="result-item-label">Distance</div>
                            <div class="result-item-value">
                                <?php echo format_number($result['distance'], 0); ?><?php echo $result['distance_unit'] === 'meters' ? 'm' : 'yd'; ?>
                            </div>
                        </div>
                        <div class="result-item">
                            <div class="result-item-label">Total Time</div>
                            <div class="result-item-value"><?php echo $result['time']; ?></div>
                        </div>
                        <div class="result-item">
                            <div class="result-item-label">Speed (m/s)</div>
                            <div class="result-item-value"><?php echo format_number($result['speed_mps'], 2); ?></div>
                        </div>
                        <div class="result-item">
                            <div class="result-item-label">Speed (km/h)</div>
                            <div class="result-item-value"><?php echo format_number($result['speed_kph'], 2); ?></div>
                        </div>
                    </div>

                    <!-- Race Time Predictions -->
                    <div style="margin-top: 2rem;">
                        <h4>Predicted Race Times</h4>
                        <table class="result-table">
                            <thead>
                                <tr>
                                    <th>Distance</th>
                                    <th>Predicted Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result['race_times'] as $name => $race): ?>
                                <tr>
                                    <td><strong><?php echo $name; ?><?php echo $result['distance_unit'] === 'meters' ? 'm' : 'yd'; ?></strong></td>
                                    <td><?php echo $race['formatted']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="result-actions">
                        <button onclick="window.print()" class="btn btn-secondary">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button onclick="copyResults()" class="btn btn-secondary">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Information Sections -->
                <div class="info-section">
                    <h2>How to Use the Swim Pace Calculator</h2>
                    <ol>
                        <li>Enter the distance you swam (e.g., 400 meters)</li>
                        <li>Select whether it was meters or yards</li>
                        <li>Enter your time in minutes and seconds</li>
                        <li>Click "Calculate Pace" to see your pace per 100m/100yd</li>
                        <li>View predicted times for common race distances</li>
                    </ol>
                </div>

                <div class="info-section">
                    <h2>Understanding Swim Pace</h2>
                    <p>Swimming pace is typically measured as the time it takes to swim 100 meters or 100 yards. This standardized measurement allows swimmers to:</p>
                    <ul>
                        <li><strong>Track Progress:</strong> Compare performances over time</li>
                        <li><strong>Plan Workouts:</strong> Set target paces for interval training</li>
                        <li><strong>Predict Race Times:</strong> Estimate finish times for competitions</li>
                        <li><strong>Compare Performances:</strong> Benchmark against other swimmers</li>
                    </ul>
                </div>

                <div class="info-section">
                    <h2>Swimming Pace Benchmarks</h2>
                    <h3>Freestyle (100m)</h3>
                    <ul>
                        <li><strong>Elite:</strong> Under 1:00</li>
                        <li><strong>Advanced:</strong> 1:00 - 1:20</li>
                        <li><strong>Intermediate:</strong> 1:20 - 1:45</li>
                        <li><strong>Beginner:</strong> 1:45 - 2:30</li>
                        <li><strong>Novice:</strong> Over 2:30</li>
                    </ul>
                    
                    <p><em>Note: These are general guidelines and vary by age, gender, and stroke.</em></p>
                </div>

                <div class="info-section">
                    <h2>Training Tips</h2>
                    <ul>
                        <li><strong>Interval Training:</strong> Swim sets at 5-10 seconds faster than race pace</li>
                        <li><strong>Endurance:</strong> Long swims at 10-15 seconds slower than race pace</li>
                        <li><strong>Technique:</strong> Focus on efficiency rather than speed</li>
                        <li><strong>Recovery:</strong> Allow adequate rest between hard sets</li>
                        <li><strong>Consistency:</strong> Regular training is key to improvement</li>
                    </ul>
                </div>

                <!-- Ad Space -->
                <?php display_horizontal_ad(1); ?>
            </div>

            <!-- Sidebar -->
            <aside class="calculator-sidebar">
                <?php include '../../includes/sidebar.php'; ?>
            </aside>
        </div>
    </div>
</div>

<style>
.result-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.result-table th,
.result-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.result-table th {
    font-weight: 600;
    opacity: 0.9;
}

.result-table tbody tr:hover {
    background: rgba(255,255,255,0.1);
}
</style>

<script>
function copyResults() {
    const pace = '<?php echo $result['pace_100'] ?? ''; ?>';
    const text = `Swimming Pace: ${pace} per 100m`;
    copyToClipboard(text);
}
</script>

<?php require_once '../../includes/footer.php'; ?>