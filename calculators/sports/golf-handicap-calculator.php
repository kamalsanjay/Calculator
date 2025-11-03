<?php
/**
 * Golf Handicap Calculator
 * Calculate golf handicap index and course handicap
 */

require_once '../../config.php';
require_once '../../includes/functions.php';

$page_title = "Golf Handicap Calculator - Calculate Your Golf Handicap Index";
$page_description = "Free golf handicap calculator. Calculate your handicap index and course handicap using official USGA formula. Track your golf scores and improvement.";
$calculator_category = "sports";
$calculator_name = "Golf Handicap Calculator";

// Calculation logic
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $scores = [];
    $course_ratings = [];
    $slope_ratings = [];
    
    // Collect up to 20 scores
    for ($i = 1; $i <= 20; $i++) {
        $score = $_POST["score_$i"] ?? '';
        $rating = $_POST["rating_$i"] ?? '';
        $slope = $_POST["slope_$i"] ?? '';
        
        if (!empty($score) && !empty($rating) && !empty($slope)) {
            $scores[] = floatval($score);
            $course_ratings[] = floatval($rating);
            $slope_ratings[] = floatval($slope);
        }
    }
    
    if (count($scores) >= 3) {
        // Calculate differentials
        $differentials = [];
        for ($i = 0; $i < count($scores); $i++) {
            $differential = (($scores[$i] - $course_ratings[$i]) * 113) / $slope_ratings[$i];
            $differentials[] = $differential;
        }
        
        // Sort differentials
        sort($differentials);
        
        // Calculate handicap index based on number of scores
        $num_scores = count($scores);
        $num_to_use = min(get_num_differentials_to_use($num_scores), count($differentials));
        
        // Take lowest differentials
        $lowest_differentials = array_slice($differentials, 0, $num_to_use);
        $avg_differential = array_sum($lowest_differentials) / count($lowest_differentials);
        $handicap_index = $avg_differential * 0.96;
        
        // Course handicap calculation (using first course if available)
        $course_handicap = null;
        if (!empty($course_ratings[0]) && !empty($slope_ratings[0])) {
            $course_handicap = round(($handicap_index * $slope_ratings[0]) / 113);
        }
        
        $result = [
            'handicap_index' => $handicap_index,
            'course_handicap' => $course_handicap,
            'num_scores' => $num_scores,
            'num_used' => $num_to_use,
            'differentials' => $differentials,
            'lowest_differentials' => $lowest_differentials,
            'avg_score' => array_sum($scores) / count($scores),
            'best_score' => min($scores),
            'worst_score' => max($scores)
        ];
    }
}

function get_num_differentials_to_use($num_scores) {
    if ($num_scores >= 20) return 10;
    if ($num_scores >= 19) return 9;
    if ($num_scores >= 18) return 8;
    if ($num_scores >= 17) return 7;
    if ($num_scores >= 16) return 6;
    if ($num_scores >= 15) return 6;
    if ($num_scores >= 14) return 5;
    if ($num_scores >= 13) return 5;
    if ($num_scores >= 12) return 4;
    if ($num_scores >= 11) return 4;
    if ($num_scores >= 10) return 3;
    if ($num_scores >= 9) return 3;
    if ($num_scores >= 8) return 2;
    if ($num_scores >= 7) return 2;
    if ($num_scores >= 6) return 2;
    if ($num_scores >= 5) return 1;
    return 1;
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
                    Calculate your golf handicap index using the official USGA formula. Enter your recent scores, course ratings, and slope ratings to get your handicap.
                </p>

                <div class="calculator-form">
                    <form method="POST" id="golfHandicapForm">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Enter at least 3 scores (up to 20) with their corresponding course rating and slope rating.
                        </div>

                        <div id="scoresContainer">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <div class="score-row" id="scoreRow<?php echo $i; ?>">
                                <h4>Round <?php echo $i; ?></h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Score</label>
                                        <input type="number" 
                                               name="score_<?php echo $i; ?>" 
                                               class="form-control" 
                                               value="<?php echo $_POST["score_$i"] ?? ''; ?>"
                                               placeholder="e.g., 85"
                                               min="50"
                                               max="150"
                                               <?php echo $i <= 3 ? 'required' : ''; ?>>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label">Course Rating</label>
                                        <input type="number" 
                                               name="rating_<?php echo $i; ?>" 
                                               class="form-control" 
                                               value="<?php echo $_POST["rating_$i"] ?? ''; ?>"
                                               placeholder="e.g., 72.5"
                                               step="0.1"
                                               min="60"
                                               max="85"
                                               <?php echo $i <= 3 ? 'required' : ''; ?>>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label">Slope Rating</label>
                                        <input type="number" 
                                               name="slope_<?php echo $i; ?>" 
                                               class="form-control" 
                                               value="<?php echo $_POST["slope_$i"] ?? ''; ?>"
                                               placeholder="e.g., 130"
                                               min="55"
                                               max="155"
                                               <?php echo $i <= 3 ? 'required' : ''; ?>>
                                    </div>
                                </div>
                            </div>
                            <?php endfor; ?>
                        </div>

                        <button type="button" class="btn btn-secondary" onclick="addMoreRounds()">
                            <i class="fas fa-plus"></i> Add More Rounds
                        </button>

                        <div class="calculator-buttons">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calculator"></i> Calculate Handicap
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>

                <?php if ($result): ?>
                <div class="result-card">
                    <h3>Your Golf Handicap</h3>
                    
                    <div class="result-primary">
                        <?php echo format_number($result['handicap_index'], 1); ?>
                        <span style="font-size: 1.5rem;">Handicap Index</span>
                    </div>

                    <?php if ($result['course_handicap']): ?>
                    <div class="result-details">
                        <div class="result-item">
                            <div class="result-item-label">Course Handicap</div>
                            <div class="result-item-value"><?php echo $result['course_handicap']; ?></div>
                        </div>
                        <div class="result-item">
                            <div class="result-item-label">Scores Used</div>
                            <div class="result-item-value"><?php echo $result['num_used']; ?> of <?php echo $result['num_scores']; ?></div>
                        </div>
                        <div class="result-item">
                            <div class="result-item-label">Average Score</div>
                            <div class="result-item-value"><?php echo format_number($result['avg_score'], 1); ?></div>
                        </div>
                        <div class="result-item">
                            <div class="result-item-label">Best Score</div>
                            <div class="result-item-value"><?php echo $result['best_score']; ?></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div style="margin-top: 2rem;">
                        <h4>Score Differentials</h4>
                        <table class="result-table">
                            <thead>
                                <tr>
                                    <th>Round</th>
                                    <th>Differential</th>
                                    <th>Used?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result['differentials'] as $index => $diff): ?>
                                <tr <?php echo in_array($diff, $result['lowest_differentials']) ? 'style="background: rgba(40,167,69,0.2);"' : ''; ?>>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo format_number($diff, 1); ?></td>
                                    <td><?php echo in_array($diff, $result['lowest_differentials']) ? '✓' : ''; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p><em>Green rows indicate differentials used in calculation</em></p>
                    </div>

                    <div class="result-actions">
                        <button onclick="window.print()" class="btn btn-secondary">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
                <?php endif; ?>

                <div class="info-section">
                    <h2>How Golf Handicap is Calculated</h2>
                    <p>The USGA Handicap System uses the following formula:</p>
                    
                    <div class="formula-box">
                        <code>Differential = (Score - Course Rating) × 113 ÷ Slope Rating</code>
                        <div class="formula-explanation">
                            <p><strong>Handicap Index</strong> = Average of lowest differentials × 0.96</p>
                            <p><strong>Course Handicap</strong> = (Handicap Index × Slope Rating) ÷ 113</p>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <h2>Number of Scores to Use</h2>
                    <table class="info-table">
                        <thead>
                            <tr>
                                <th>Scores Posted</th>
                                <th>Differentials Used</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>3-4</td><td>Lowest 1</td></tr>
                            <tr><td>5-6</td><td>Lowest 1</td></tr>
                            <tr><td>7-8</td><td>Lowest 2</td></tr>
                            <tr><td>9-11</td><td>Lowest 3</td></tr>
                            <tr><td>12-14</td><td>Lowest 4</td></tr>
                            <tr><td>15-16</td><td>Lowest 6</td></tr>
                            <tr><td>17-18</td><td>Lowest 7</td></tr>
                            <tr><td>19</td><td>Lowest 9</td></tr>
                            <tr><td>20</td><td>Lowest 10</td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="info-section">
                    <h2>Understanding Your Handicap</h2>
                    <ul>
                        <li><strong>Scratch Golfer:</strong> Handicap index of 0.0</li>
                        <li><strong>Low Handicap:</strong> 0-9 (very good player)</li>
                        <li><strong>Mid Handicap:</strong> 10-20 (average to good)</li>
                        <li><strong>High Handicap:</strong> 21+ (beginner to intermediate)</li>
                    </ul>
                </div>

                <div class="info-section">
                    <h2>Tips for Lowering Your Handicap</h2>
                    <ul>
                        <li><strong>Practice Short Game:</strong> Focus on putting, chipping, and bunker shots</li>
                        <li><strong>Course Management:</strong> Play smart, not aggressive</li>
                        <li><strong>Consistent Swing:</strong> Develop a repeatable swing</li>
                        <li><strong>Physical Fitness:</strong> Improve flexibility and strength</li>
                        <li><strong>Mental Game:</strong> Stay focused and positive</li>
                        <li><strong>Equipment:</strong> Get properly fitted clubs</li>
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
.score-row {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.score-row h4 {
    margin-bottom: 1rem;
    color: var(--primary-color);
}

.info-table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
}

.info-table th,
.info-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #dee2e6;
}

.info-table th {
    background: var(--light-color);
    font-weight: 600;
}
</style>

<script>
let roundCount = 5;

function addMoreRounds() {
    if (roundCount >= 20) {
        alert('Maximum 20 rounds allowed');
        return;
    }
    
    for (let i = 0; i < 5 && roundCount < 20; i++) {
        roundCount++;
        const container = document.getElementById('scoresContainer');
        const newRow = document.createElement('div');
        newRow.className = 'score-row';
        newRow.id = 'scoreRow' + roundCount;
        newRow.innerHTML = `
            <h4>Round ${roundCount}</h4>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Score</label>
                    <input type="number" name="score_${roundCount}" class="form-control" placeholder="e.g., 85" min="50" max="150">
                </div>
                <div class="form-group">
                    <label class="form-label">Course Rating</label>
                    <input type="number" name="rating_${roundCount}" class="form-control" placeholder="e.g., 72.5" step="0.1" min="60" max="85">
                </div>
                <div class="form-group">
                    <label class="form-label">Slope Rating</label>
                    <input type="number" name="slope_${roundCount}" class="form-control" placeholder="e.g., 130" min="55" max="155">
                </div>
            </div>
        `;
        container.appendChild(newRow);
    }
}
</script>

<?php require_once '../../includes/footer.php'; ?>