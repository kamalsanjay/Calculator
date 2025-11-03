<?php
/**
 * Bike Cadence Calculator
 * Calculate optimal cycling cadence and gear ratios
 */

require_once '../../config.php';
require_once '../../includes/functions.php';

$page_title = "Bike Cadence Calculator - Cycling Cadence & Speed Calculator";
$page_description = "Free bike cadence calculator. Calculate cycling cadence, speed, and gear ratios. Optimize your pedaling efficiency for training and racing.";
$calculator_category = "sports";
$calculator_name = "Bike Cadence Calculator";

// Calculation logic
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cadence = floatval($_POST['cadence'] ?? 0);
    $wheel_size = floatval($_POST['wheel_size'] ?? 700);
    $tire_width = floatval($_POST['tire_width'] ?? 25);
    $chainring = intval($_POST['chainring'] ?? 50);
    $cog = intval($_POST['cog'] ?? 15);
    
    if ($cadence > 0 && $wheel_size > 0 && $chainring > 0 && $cog > 0) {
        // Calculate wheel circumference (mm)
        $wheel_circumference = calculate_wheel_circumference($wheel_size, $tire_width);
        
        // Gear ratio
        $gear_ratio = $chainring / $cog;
        
        // Distance per pedal revolution (meters)
        $distance_per_rev = ($wheel_circumference / 1000) * $gear_ratio;
        
        // Speed calculations
        $speed_mps = ($distance_per_rev * $cadence) / 60; // meters per second
        $speed_kph = $speed_mps * 3.6; // km/h
        $speed_mph = $speed_kph / 1.609344; // mph
        
        // Gear inches (used in cycling)
        $gear_inches = ($chainring / $cog) * ($wheel_size / 25.4);
        
        // Development (meters per revolution)
        $development = $distance_per_rev;
        
        // Calculate for different cadences
        $cadence_ranges = [60, 70, 80, 90, 100, 110, 120];
        $cadence_speeds = [];
        
        foreach ($cadence_ranges as $test_cadence) {
            $test_speed = (($distance_per_rev * $test_cadence) / 60) * 3.6;
            $cadence_speeds[$test_cadence] = [
                'cadence' => $test_cadence,
                'speed_kph' => $test_speed,
                'speed_mph' => $test_speed / 1.609344
            ];
        }
        
        $result = [
            'cadence' => $cadence,
            'speed_kph' => $speed_kph,
            'speed_mph' => $speed_mph,
            'gear_ratio' => $gear_ratio,
            'gear_inches' => $gear_inches,
            'development' => $development,
            'wheel_circumference' => $wheel_circumference,
            'distance_per_rev' => $distance_per_rev,
            'chainring' => $chainring,
            'cog' => $cog,
            'cadence_speeds' => $cadence_speeds
        ];
    }
}

function calculate_wheel_circumference($wheel_size, $tire_width) {
    // Approximate formula: wheel diameter + 2 * tire width * 0.5
    $diameter_mm = $wheel_size + (2 * $tire_width * 0.5);
    return pi() * $diameter_mm;
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
                    Calculate your cycling cadence, speed, and gear ratios. Optimize your pedaling efficiency and find the perfect gear for any riding condition.
                </p>

                <div class="calculator-form">
                    <form method="POST">
                        <h3>Bike Setup</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Wheel Size (mm)</label>
                                <select name="wheel_size" class="form-control" required>
                                    <option value="700" <?php echo ($_POST['wheel_size'] ?? '700') == '700' ? 'selected' : ''; ?>>700c (Road)</option>
                                    <option value="622" <?php echo ($_POST['wheel_size'] ?? '') == '622' ? 'selected' : ''; ?>>29" (MTB)</option>
                                    <option value="584" <?php echo ($_POST['wheel_size'] ?? '') == '584' ? 'selected' : ''; ?>>27.5" (MTB)</option>
                                    <option value="559" <?php echo ($_POST['wheel_size'] ?? '') == '559' ? 'selected' : ''; ?>>26" (MTB)</option>
                                    <option value="406" <?php echo ($_POST['wheel_size'] ?? '') == '406' ? 'selected' : ''; ?>>20" (BMX)</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Tire Width (mm)</label>
                                <input type="number" 
                                       name="tire_width" 
                                       class="form-control" 
                                       value="<?php echo $_POST['tire_width'] ?? '25'; ?>"
                                       min="20"
                                       max="60"
                                       required>
                            </div>
                        </div>

                        <h3>Gearing</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Chainring (Front)</label>
                                <input type="number" 
                                       name="chainring" 
                                       class="form-control" 
                                       value="<?php echo $_POST['chainring'] ?? '50'; ?>"
                                       min="20"
                                       max="60"
                                       placeholder="e.g., 50"
                                       required>
                                <small class="form-text">Number of teeth on front chainring</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Cog (Rear)</label>
                                <input type="number" 
                                       name="cog" 
                                       class="form-control" 
                                       value="<?php echo $_POST['cog'] ?? '15'; ?>"
                                       min="8"
                                       max="50"
                                       placeholder="e.g., 15"
                                       required>
                                <small class="form-text">Number of teeth on rear cog</small>
                            </div>
                        </div>

                        <h3>Cadence</h3>
                        
                        <div class="form-group">
                            <label class="form-label">Cadence (RPM)</label>
                            <input type="number" 
                                   name="cadence" 
                                   class="form-control" 
                                   value="<?php echo $_POST['cadence'] ?? ''; ?>"
                                   min="30"
                                   max="150"
                                   placeholder="e.g., 90"
                                   required>
                            <small class="form-text">Pedal revolutions per minute</small>
                        </div>

                        <div class="calculator-buttons">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calculator"></i> Calculate
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>

                <?php if ($result): ?>
                <div class="result-card">
                    <h3>Your Cycling Results</h3>
                    
                    <div class="result-primary">
                        <?php echo format_number($result['speed_kph'], 2); ?> km/h
                        <span style="font-size: 1.5rem;">(<?php echo format_number($result['speed_mph'], 2); ?> mph)</span>
                    </div>

                    <div class="result-details">
                        <div class="result-item">
                            <div class="result-item-label">Cadence</div>
                            <div class="result-item-value"><?php echo $result['cadence']; ?> RPM</div>
                        </div>
                        <div class="result-item">
                            <div class="result-item-label">Gear Ratio</div>
                            <div class="result-item-value"><?php echo format_number($result['gear_ratio'], 2); ?></div>
                        </div>
                        <div class="result-item">
                            <div class="result-item-label">Gear Inches</div>
                            <div class="result-item-value"><?php echo format_number($result['gear_inches'], 1); ?>"</div>
                        </div>
                        <div class="result-item">
                            <div class="result-item-label">Development</div>
                            <div class="result-item-value"><?php echo format_number($result['development'], 2); ?>m</div>
                        </div>
                    </div>

                    <div style="margin-top: 2rem;">
                        <h4>Gear Setup</h4>
                        <p><strong>Chainring:</strong> <?php echo $result['chainring']; ?> teeth</p>
                        <p><strong>Cog:</strong> <?php echo $result['cog']; ?> teeth</p>
                        <p><strong>Wheel Circumference:</strong> <?php echo format_number($result['wheel_circumference'] / 1000, 3); ?>m</p>
                        <p><strong>Distance per Revolution:</strong> <?php echo format_number($result['distance_per_rev'], 2); ?>m</p>
                    </div>

                    <div style="margin-top: 2rem;">
                        <h4>Speed at Different Cadences</h4>
                        <table class="result-table">
                            <thead>
                                <tr>
                                    <th>Cadence (RPM)</th>
                                    <th>Speed (km/h)</th>
                                    <th>Speed (mph)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result['cadence_speeds'] as $speed): ?>
                                <tr <?php echo $speed['cadence'] == $result['cadence'] ? 'style="background: rgba(255,255,255,0.2);"' : ''; ?>>
                                    <td><strong><?php echo $speed['cadence']; ?></strong></td>
                                    <td><?php echo format_number($speed['speed_kph'], 2); ?></td>
                                    <td><?php echo format_number($speed['speed_mph'], 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="result-actions">
                        <button onclick="window.print()" class="btn btn-secondary">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
                <?php endif; ?>

                <div class="info-section">
                    <h2>Understanding Bike Cadence</h2>
                    <p>Cadence is the number of pedal revolutions per minute (RPM). It's a crucial metric for cycling efficiency and performance.</p>
                    
                    <h3>Optimal Cadence Ranges</h3>
                    <ul>
                        <li><strong>Recreational:</strong> 60-80 RPM</li>
                        <li><strong>Endurance Cycling:</strong> 80-90 RPM</li>
                        <li><strong>Racing/Performance:</strong> 90-100 RPM</li>
                        <li><strong>Sprint:</strong> 110-130 RPM</li>
                        <li><strong>Track Cycling:</strong> 120-150 RPM</li>
                    </ul>
                </div>

                <div class="info-section">
                    <h2>Gear Ratio Explained</h2>
                    <p>Gear ratio is calculated by dividing the number of teeth on the chainring by the number of teeth on the rear cog.</p>
                    
                    <div class="formula-box">
                        <code>Gear Ratio = Chainring Teeth ÷ Cog Teeth</code>
                    </div>
                    
                    <h3>What Does It Mean?</h3>
                    <ul>
                        <li><strong>Higher ratio (e.g., 4.0):</strong> Harder to pedal, higher speed, better for flats</li>
                        <li><strong>Lower ratio (e.g., 2.0):</strong> Easier to pedal, lower speed, better for climbing</li>
                    </ul>
                </div>

                <div class="info-section">
                    <h2>Speed Formula</h2>
                    <div class="formula-box">
                        <code>Speed = (Wheel Circumference × Gear Ratio × Cadence) ÷ 60</code>
                        <div class="formula-explanation">
                            Result is in meters per second, then converted to km/h or mph
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <h2>Training Tips</h2>
                    <ul>
                        <li><strong>High Cadence Training:</strong> Improves cardiovascular fitness and pedaling efficiency</li>
                        <li><strong>Low Cadence Training:</strong> Builds strength and power</li>
                        <li><strong>Varied Cadence:</strong> Mix different cadences in training for adaptability</li>
                        <li><strong>Smooth Pedaling:</strong> Focus on circular motion, not just pushing down</li>
                        <li><strong>Cadence Drills:</strong> Practice holding specific cadences for intervals</li>
                    </ul>
                </div>

                <div class="info-section">
                    <h2>Factors Affecting Speed</h2>
                    <ul>
                        <li><strong>Wind Resistance:</strong> Increases exponentially with speed</li>
                        <li><strong>Rolling Resistance:</strong> Affected by tire pressure and surface</li>
                        <li><strong>Gradient:</strong> Hills significantly impact required power</li>
                        <li><strong>Weight:</strong> Bike + rider weight affects climbing</li>
                        <li><strong>Aerodynamics:</strong> Body position and equipment</li>
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

<?php require_once '../../includes/footer.php'; ?>