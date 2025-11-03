<?php
/**
 * Marathon Time Calculator
 * Predict marathon finish time based on recent race
 */

require_once '../../config.php';
require_once '../../includes/functions.php';

$page_title = "Marathon Time Calculator - Predict Your Finish Time";
$page_description = "Free marathon time calculator. Predict your marathon finish time based on recent race results. Plan your pacing strategy with split times.";
$calculator_category = "sports";
$calculator_name = "Marathon Time Calculator";

// Calculation logic
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $race_distance = floatval($_POST['race_distance'] ?? 0);
    $hours = intval($_POST['hours'] ?? 0);
    $minutes = intval($_POST['minutes'] ?? 0);
    $seconds = intval($_POST['seconds'] ?? 0);
    
    if ($race_distance > 0 && ($hours > 0 || $minutes > 0 || $seconds > 0)) {
        $race_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
        
        // Riegel formula: T2 = T1 * (D2/D1)^1.06
        $marathon_km = 42.195;
        $marathon_seconds = $race_seconds * pow(($marathon_km / $race_distance), 1.06);
        
        // Calculate splits
        $splits = [
            '5K' => ($marathon_seconds / $marathon_km) * 5,
            '10K' => ($marathon_seconds / $marathon_km) * 10,
            '15K' => ($marathon_seconds / $marathon_km) * 15,
            '20K' => ($marathon_seconds / $marathon_km) * 20,
            'Half' => ($marathon_seconds / $marathon_km) * 21.0975,
            '25K' => ($marathon_seconds / $marathon_km) * 25,
            '30K' => ($marathon_seconds / $marathon_km) * 30,
            '35K' => ($marathon_seconds / $marathon_km) * 35,
            '40K' => ($marathon_seconds / $marathon_km) * 40,
            'Finish' => $marathon_seconds
        ];
        
        // Average pace per km and mile
        $pace_per_km = $marathon_seconds / $marathon_km;
        $pace_per_mile = $pace_per_km * 1.60934;
        
        $result = [
            'marathon_time' => format_race_time($marathon_seconds),
            'marathon_seconds' => $marathon_seconds,
            'pace_per_km' => format_pace($pace_per_km),
            'pace_per_mile' => format_pace($pace_per_mile),
            'splits' => array_map('format_race_time', $splits),
            'race_distance' => $race_distance,
            'race_time' => format_race_time($race_seconds)
        ];
    }
}

function format_race_time($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $secs = $seconds % 60;
    return sprintf("%d:%02d:%02d", $hours, $minutes, $secs);
}

function format_pace($seconds) {
    $minutes = floor($seconds / 60);
    $secs = $seconds % 60;
    return sprintf("%d:%02d", $minutes, $secs);
}

require_once '../../includes/header.php';
?>

<div class="calculator-page">
    <div class="container">
        <?php echo generate_breadcrumb($calculator_category, $calculator_name); ?>
        
        <div class="calculator-container">
            <div class="calculator-main">
                <h1><?php echo $calculator_name; ?></h1>
                <p class="calculator-description">
                    Predict your marathon finish time based on your recent race performance. Get detailed split times and pacing strategy for your 42.195km marathon.
                </p>

                <div class="calculator-form">
                    <form method="POST">
                        <h3>Recent Race Performance</h3>
                        
                        <div class="form-group">
                            <label class="form-label">Race Distance (km)</label>
                            <select name="race_distance" class="form-control" required>
                                <option value="">Select distance...</option>
                                <option value="5" <?php echo ($_POST['race_distance'] ?? '') == '5' ? 'selected' : ''; ?>>5K</option>
                                <option value="10" <?php echo ($_POST['race_distance'] ?? '') == '10' ? 'selected' : ''; ?>>10K</option>
                                <option value="15" <?php echo ($_POST['race_distance'] ?? '') == '15' ? 'selected' : ''; ?>>15K</option>
                                <option value="21.0975" <?php echo ($_POST['race_distance'] ?? '') == '21.0975' ? 'selected' : ''; ?>>Half Marathon</option>
                                <option value="25" <?php echo ($_POST['race_distance'] ?? '') == '25' ? 'selected' : ''; ?>>25K</option>
                                <option value="30" <?php echo ($_POST['race_distance'] ?? '') == '30' ? 'selected' : ''; ?>>30K</option>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Hours</label>
                                <input type="number" 
                                       name="hours" 
                                       class="form-control" 
                                       min="0"
                                       max="10"
                                       value="<?php echo $_POST['hours'] ?? '0'; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Minutes</label>
                                <input type="number" 
                                       name="minutes" 
                                       class="form-control" 
                                       min="0"
                                       max="59"
                                       value="<?php echo $_POST['minutes'] ?? ''; ?>"
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Seconds</label>
                                <input type="number" 
                                       name="seconds" 
                                       class="form-control" 
                                       min="0"
                                       max="59"
                                       value="<?php echo $_POST['seconds'] ?? '0'; ?>">
                            </div>
                        </div>

                        <div class="calculator-buttons">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calculator"></i> Predict Marathon Time
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>

                <?php if ($result): ?>
                <div class="result-card">
                    <h3>Predicted Marathon Time</h3>
                    
                    <div class="result-primary">
                        <?php echo $result['marathon_time']; ?>
                    </div>

                    <div class="result-details">
                        <div class="result-item">
                            <div class="result-item-label">Pace per KM</div>
                            <div class="result-item-value"><?php echo $result['pace_per_km']; ?>/km</div>
                        </div>
                        <div class="result-item">
                            <div class="result-item-label">Pace per Mile</div>
                            <div class="result-item-value"><?php echo $result['pace_per_mile']; ?>/mi</div>
                        </div>
                        <div class="result-item">
                            <div class="result-item-label">Race Distance</div>
                            <div class="result-item-value"><?php echo $result['race_distance']; ?> km</div>
                        </div>
                        <div class="result-item">
                            <div class="result-item-label">Race Time</div>
                            <div class="result-item-value"><?php echo $result['race_time']; ?></div>
                        </div>
                    </div>

                    <div style="margin-top: 2rem;">
                        <h4>Split Times</h4>
                        <table class="splits-table">
                            <thead>
                                <tr>
                                    <th>Distance</th>
                                    <th>Split Time</th>
                                    <th>Cumulative</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result['splits'] as $distance => $time): ?>
                                <tr>
                                    <td><strong><?php echo $distance; ?></strong></td>
                                    <td><?php echo $time; ?></td>
                                    <td><?php echo $time; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="result-actions">
                        <button onclick="window.print()" class="btn btn-secondary">
                            <i class="fas fa-print"></i> Print Splits
                        </button>
                    </div>
                </div>
                <?php endif; ?>

                <div class="info-section">
                    <h2>How to Use This Calculator</h2>
                    <ol>
                        <li>Select a recent race distance you've completed</li>
                        <li>Enter your finish time for that race</li>
                        <li>Click "Predict Marathon Time" to see your predicted marathon performance</li>
                        <li>Review the split times for pacing strategy</li>
                    </ol>
                </div>

                <div class="info-section">
                    <h2>About the Prediction Formula</h2>
                    <p>This calculator uses the Riegel formula, a widely accepted method for predicting race times:</p>
                    <div class="formula-box">
                        <code>T2 = T1 × (D2/D1)^1.06</code>
                        <div class="formula-explanation">
                            Where T1 is your known time, D1 is that distance, T2 is predicted time, and D2 is the target distance (marathon).
                        </div>
                    </div>
                    <p><strong>Note:</strong> This is an estimate. Actual performance depends on training, conditions, and race day execution.</p>
                </div>

                <div class="info-section">
                    <h2>Marathon Training Tips</h2>
                    <ul>
                        <li><strong>Build Base Mileage:</strong> Gradually increase weekly distance</li>
                        <li><strong>Long Runs:</strong> Practice runs of 18-22 miles</li>
                        <li><strong>Tempo Runs:</strong> Maintain marathon pace for shorter distances</li>
                        <li><strong>Taper:</strong> Reduce volume 2-3 weeks before race day</li>
                        <li><strong>Nutrition:</strong> Practice fueling strategy during training</li>
                        <li><strong>Rest:</strong> Include recovery days in your training plan</li>
                    </ul>
                </div>

                <?php display_horizontal_ad(1); ?>
            </div>

            <aside class="calculator-sidebar">
                <?php include '../../includes/sidebar.php'; ?>
            </aside>
        </div>
    </div>
</div>

<style>
.splits-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.splits-table th,
.splits-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.splits-table th {
    font-weight: 600;
    opacity: 0.9;
}

.splits-table tbody tr:hover {
    background: rgba(255,255,255,0.1);
}
</style>

<?php require_once '../../includes/footer.php'; ?>