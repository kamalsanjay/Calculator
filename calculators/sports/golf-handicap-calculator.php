<?php
/**
 * Golf Handicap Calculator
 * File: sports/golf-handicap-calculator.php
 * Description: Professional golf handicap calculator using WHS (World Handicap System)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Golf Handicap Calculator - Professional WHS Handicap Index</title>
    <meta name="description" content="Calculate your golf handicap index using the World Handicap System. Input your scores, course rating, and slope rating.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #2e7d32 0%, #66bb6a 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input, .input-wrapper select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus { outline: none; border-color: #2e7d32; box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1); }
        
        .scores-section { margin-top: 30px; }
        .scores-header { display: flex; justify-content: between; align-items: center; margin-bottom: 15px; }
        .scores-header h3 { color: #2c3e50; font-size: 1.2rem; }
        .add-score-btn { background: #2e7d32; color: white; border: none; border-radius: 8px; padding: 10px 15px; cursor: pointer; font-size: 0.9rem; transition: all 0.3s; }
        .add-score-btn:hover { background: #1b5e20; }
        
        .score-row { display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 15px; align-items: end; margin-bottom: 15px; padding: 15px; background: #f8f9fa; border-radius: 8px; }
        .remove-score { background: #e53935; color: white; border: none; border-radius: 5px; width: 30px; height: 30px; cursor: pointer; font-size: 0.8rem; }
        
        .calculate-btn { background: linear-gradient(135deg, #2e7d32 0%, #66bb6a 100%); color: white; border: none; border-radius: 10px; padding: 15px 30px; font-size: 1.1rem; cursor: pointer; transition: all 0.3s; width: 100%; margin-top: 20px; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3); }
        
        .result-section { background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); padding: 25px; border-radius: 10px; margin-top: 25px; border-left: 4px solid #2e7d32; display: none; }
        .result-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.3rem; }
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .result-card { background: white; padding: 18px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .result-label { color: #7f8c8d; font-size: 0.85rem; margin-bottom: 5px; }
        .result-value { font-size: 1.4rem; font-weight: bold; color: #2e7d32; }
        
        .quick-actions { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-actions h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #2e7d32; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(46, 125, 50, 0.15); }
        .quick-value { font-weight: bold; color: #2e7d32; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .handicap-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .handicap-table th, .handicap-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .handicap-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .handicap-table tr:hover { background: #e8f5e9; }
        
        .formula-box { background: #e8f5e9; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #2e7d32; }
        .formula-box strong { color: #2e7d32; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-row { grid-template-columns: 1fr; gap: 15px; }
            .score-row { grid-template-columns: 1fr; gap: 10px; }
            .header h1 { font-size: 1.5rem; }
            .result-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⛳ Golf Handicap Calculator</h1>
            <p>Calculate your golf handicap index using the World Handicap System (WHS) - Input your scores, course rating, and slope rating</p>
        </div>

        <div class="calculator-card">
            <div class="input-row">
                <div class="input-group">
                    <label for="courseRating">Course Rating</label>
                    <div class="input-wrapper">
                        <input type="number" id="courseRating" placeholder="e.g., 72.0" step="0.1" min="55" max="80">
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="slopeRating">Slope Rating</label>
                    <div class="input-wrapper">
                        <input type="number" id="slopeRating" placeholder="e.g., 113" step="1" min="55" max="155">
                    </div>
                </div>
            </div>
            
            <div class="input-row">
                <div class="input-group">
                    <label for="par">Course Par</label>
                    <div class="input-wrapper">
                        <input type="number" id="par" placeholder="e.g., 72" step="1" min="54" max="80">
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="teeBox">Tee Box</label>
                    <div class="input-wrapper">
                        <select id="teeBox">
                            <option value="">Select Tee Box</option>
                            <option value="championship">Championship</option>
                            <option value="men">Men's</option>
                            <option value="senior">Senior</option>
                            <option value="women">Women's</option>
                            <option value="forward">Forward</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="scores-section">
                <div class="scores-header">
                    <h3>Score History (Last 20 Rounds)</h3>
                    <button class="add-score-btn" onclick="addScoreRow()">+ Add Score</button>
                </div>
                
                <div id="scoresContainer">
                    <div class="score-row">
                        <div class="input-group">
                            <label>Score</label>
                            <input type="number" class="score-input" placeholder="e.g., 85" min="50" max="150">
                        </div>
                        <div class="input-group">
                            <label>Course Rating</label>
                            <input type="number" class="rating-input" placeholder="e.g., 72.0" step="0.1">
                        </div>
                        <div class="input-group">
                            <label>Slope Rating</label>
                            <input type="number" class="slope-input" placeholder="e.g., 113" step="1">
                        </div>
                        <button class="remove-score" onclick="removeScoreRow(this)">×</button>
                    </div>
                </div>
            </div>

            <button class="calculate-btn" onclick="calculateHandicap()">Calculate Handicap Index</button>

            <div class="result-section" id="resultSection">
                <h3>Your Handicap Results</h3>
                <div class="result-grid">
                    <div class="result-card">
                        <div class="result-label">Handicap Index</div>
                        <div class="result-value" id="handicapIndex">-</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Course Handicap</div>
                        <div class="result-value" id="courseHandicap">-</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Playing Handicap</div>
                        <div class="result-value" id="playingHandicap">-</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Differentials Used</div>
                        <div class="result-value" id="differentialsUsed">-</div>
                    </div>
                </div>
            </div>

            <div class="quick-actions">
                <h3>🏌️ Quick Examples</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="loadExample('beginner')">
                        <div class="quick-value">Beginner</div>
                        <div class="quick-label">High 90s</div>
                    </div>
                    <div class="quick-btn" onclick="loadExample('intermediate')">
                        <div class="quick-value">Intermediate</div>
                        <div class="quick-label">Mid 80s</div>
                    </div>
                    <div class="quick-btn" onclick="loadExample('advanced')">
                        <div class="quick-value">Advanced</div>
                        <div class="quick-label">Low 70s</div>
                    </div>
                    <div class="quick-btn" onclick="loadExample('pro')">
                        <div class="quick-value">Pro Level</div>
                        <div class="quick-label">Scratch/+</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⛳ Golf Handicap System Explained</h2>
            
            <p>The World Handicap System (WHS) allows golfers of different abilities to compete fairly by calculating a Handicap Index that represents a player's potential ability.</p>

            <h3>📊 How Handicap Index is Calculated</h3>
            <table class="handicap-table">
                <thead>
                    <tr>
                        <th>Number of Scores</th>
                        <th>Differentials Used</th>
                        <th>Adjustment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>3</td><td>Lowest 1</td><td>-2.0</td></tr>
                    <tr><td>4</td><td>Lowest 1</td><td>-1.0</td></tr>
                    <tr><td>5</td><td>Lowest 1</td><td>0</td></tr>
                    <tr><td>6</td><td>Lowest 2</td><td>0</td></tr>
                    <tr><td>7-8</td><td>Lowest 2</td><td>0</td></tr>
                    <tr><td>9-11</td><td>Lowest 3</td><td>0</td></tr>
                    <tr><td>12-14</td><td>Lowest 4</td><td>0</td></tr>
                    <tr><td>15-16</td><td>Lowest 5</td><td>0</td></tr>
                    <tr><td>17-18</td><td>Lowest 6</td><td>0</td></tr>
                    <tr><td>19</td><td>Lowest 7</td><td>0</td></tr>
                    <tr><td>20</td><td>Lowest 8</td><td>0</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Formulas:</strong><br>
                • <strong>Score Differential</strong> = (113 ÷ Slope Rating) × (Adjusted Gross Score - Course Rating)<br>
                • <strong>Handicap Index</strong> = Average of best differentials × 0.96<br>
                • <strong>Course Handicap</strong> = Handicap Index × (Slope Rating ÷ 113)<br>
                • <strong>Playing Handicap</strong> = Course Handicap × Handicap Allowance
            </div>

            <h3>🏌️ Understanding Golf Ratings</h3>
            <table class="handicap-table">
                <thead>
                    <tr>
                        <th>Rating Type</th>
                        <th>Description</th>
                        <th>Typical Range</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Course Rating</td><td>Expected score for scratch golfer</td><td>67-77</td></tr>
                    <tr><td>Slope Rating</td><td>Relative difficulty for bogey golfer</td><td>55-155</td></tr>
                    <tr><td>Bogey Rating</td><td>Expected score for bogey golfer</td><td>72-92</td></tr>
                </tbody>
            </table>

            <h3>📈 Handicap Index Ranges</h3>
            <ul>
                <li><strong>Scratch Golfer:</strong> 0.0 to +4.0</li>
                <li><strong>Low Handicap:</strong> 1.0 to 9.9</li>
                <li><strong>Mid Handicap:</strong> 10.0 to 19.9</li>
                <li><strong>High Handicap:</strong> 20.0 to 29.9</li>
                <li><strong>Beginner:</strong> 30.0+</li>
            </ul>

            <h3>🏆 Tournament Handicap Allowances</h3>
            <table class="handicap-table">
                <thead>
                    <tr>
                        <th>Format</th>
                        <th>Allowance</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Individual Stroke Play</td><td>95%</td><td>Most common format</td></tr>
                    <tr><td>Four-Ball Stroke Play</td><td>85%</td><td>Better ball of partners</td></tr>
                    <tr><td>Match Play</td><td>100%</td><td>Full difference</td></tr>
                    <tr><td>Four-Ball Match Play</td><td>90%</td><td>Better ball match</td></tr>
                    <tr><td>Scramble</td><td>35%/15%</td><td>A&B player percentages</td></tr>
                </tbody>
            </table>

            <h3>🎯 Score Adjustment (Net Double Bogey)</h3>
            <div class="formula-box">
                <strong>Net Double Bogey Maximum:</strong><br>
                • For handicap purposes, your maximum score on any hole is:<br>
                • <strong>Par + 2 + Your Stroke Allowance</strong><br>
                • Example: On a par 4 where you get 1 stroke: 4 + 2 + 1 = 7 maximum
            </div>

            <h3>🌍 WHS Implementation Worldwide</h3>
            <ul>
                <li><strong>United States:</strong> USGA Handicap System → WHS</li>
                <li><strong>Europe:</strong> CONGU → WHS</li>
                <li><strong>Australia:</strong> GA Handicap System → WHS</li>
                <li><strong>South Africa:</strong> SAGA Handicap System → WHS</li>
                <li><strong>Argentina:</strong> AAG Handicap System → WHS</li>
            </ul>

            <h3>📱 Maintaining Your Handicap</h3>
            <ul>
                <li>Post scores as soon as possible after round completion</li>
                <li>Include all acceptable scores (9-hole and 18-hole rounds)</li>
                <li>Apply net double bogey maximum per hole</li>
                <li>Play by the Rules of Golf for acceptable scores</li>
                <li>Your handicap updates daily with new scores</li>
            </ul>

            <h3>🏅 What Your Handicap Means</h3>
            <table class="handicap-table">
                <thead>
                    <tr>
                        <th>Handicap Range</th>
                        <th>Typical Scoring</th>
                        <th>Skill Level</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>+2 to 0</td><td>70-72</td><td>Elite/Professional</td></tr>
                    <tr><td>1 to 5</td><td>73-77</td><td>Advanced Amateur</td></tr>
                    <tr><td>6 to 12</td><td>78-84</td><td>Good Club Player</td></tr>
                    <tr><td>13 to 20</td><td>85-92</td><td>Average Golfer</td></tr>
                    <tr><td>21 to 29</td><td>93-101</td><td>Recreational Player</td></tr>
                    <tr><td>30+</td><td>102+</td><td>Beginner/High Handicap</td></tr>
                </tbody>
            </table>

            <h3>⛳ Course Handicap Calculation</h3>
            <div class="formula-box">
                <strong>Course Handicap Formula:</strong><br>
                • Course Handicap = Handicap Index × (Slope Rating ÷ 113)<br>
                • <strong>Example:</strong> 10.0 Handicap Index on 130 Slope course:<br>
                • 10.0 × (130 ÷ 113) = 11.5 → Rounded to 12 Course Handicap
            </div>

            <h3>📊 Expected Scoring by Handicap</h3>
            <ul>
                <li><strong>Scratch Golfer (0):</strong> Typically shoots 72-75</li>
                <li><strong>10 Handicap:</strong> Typically shoots 82-85</li>
                <li><strong>20 Handicap:</strong> Typically shoots 92-95</li>
                <li><strong>30 Handicap:</strong> Typically shoots 102-105</li>
            </ul>

            <h3>🎪 Special Situations</h3>
            <ul>
                <li><strong>9-Hole Scores:</strong> Combined with another 9-hole score</li>
                <li><strong>Exceptional Scores:</strong> Reduction of -1.0 for exceptional rounds</li>
                <li><strong>Playing Conditions Calculation:</strong> Automatic adjustment for weather</li>
                <li><strong>Frequency of Updates:</strong> Handicap index updates daily</li>
            </ul>

            <h3>🏌️‍♂️ Improving Your Handicap</h3>
            <div class="formula-box">
                <strong>Tips for Lowering Your Handicap:</strong><br>
                • Focus on consistency rather than hero shots<br>
                • Practice short game (50% of shots are within 50 yards)<br>
                • Improve course management and strategy<br>
                • Work on eliminating big numbers (double bogeys+)<br>
                • Get fitted for proper equipment
            </div>

            <h3>📈 Handicap Trends</h3>
            <ul>
                <li>Most golfers have handicaps between 10-20</li>
                <li>Only about 2% of golfers have single-digit handicaps</li>
                <li>The average male golfer has a handicap of about 16</li>
                <li>The average female golfer has a handicap of about 28</li>
                <li>Handicaps tend to improve for about 7 years then stabilize</li>
            </ul>
        </div>

        <div class="footer">
            <p>⛳ Professional Golf Handicap Calculator | World Handicap System (WHS)</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate handicap index, course handicap, and playing handicap for fair competition</p>
        </div>
    </div>

    <script>
        let scoreCount = 1;
        
        function addScoreRow() {
            if (scoreCount >= 20) {
                alert('Maximum 20 scores allowed for handicap calculation');
                return;
            }
            
            const container = document.getElementById('scoresContainer');
            const newRow = document.createElement('div');
            newRow.className = 'score-row';
            newRow.innerHTML = `
                <div class="input-group">
                    <label>Score</label>
                    <input type="number" class="score-input" placeholder="e.g., 85" min="50" max="150">
                </div>
                <div class="input-group">
                    <label>Course Rating</label>
                    <input type="number" class="rating-input" placeholder="e.g., 72.0" step="0.1">
                </div>
                <div class="input-group">
                    <label>Slope Rating</label>
                    <input type="number" class="slope-input" placeholder="e.g., 113" step="1">
                </div>
                <button class="remove-score" onclick="removeScoreRow(this)">×</button>
            `;
            
            container.appendChild(newRow);
            scoreCount++;
        }
        
        function removeScoreRow(button) {
            if (scoreCount <= 1) {
                alert('You need at least one score to calculate handicap');
                return;
            }
            
            button.parentElement.remove();
            scoreCount--;
        }
        
        function calculateHandicap() {
            const courseRating = parseFloat(document.getElementById('courseRating').value);
            const slopeRating = parseFloat(document.getElementById('slopeRating').value);
            const par = parseInt(document.getElementById('par').value);
            
            if (!courseRating || !slopeRating || !par) {
                alert('Please fill in all course information fields');
                return;
            }
            
            // Collect scores
            const scoreRows = document.querySelectorAll('.score-row');
            const differentials = [];
            
            scoreRows.forEach(row => {
                const score = parseInt(row.querySelector('.score-input').value);
                const rating = parseFloat(row.querySelector('.rating-input').value);
                const slope = parseFloat(row.querySelector('.slope-input').value);
                
                if (score && rating && slope) {
                    // Calculate differential: (113 / Slope Rating) x (Adjusted Gross Score - Course Rating)
                    const differential = (113 / slope) * (score - rating);
                    differentials.push(differential);
                }
            });
            
            if (differentials.length < 3) {
                alert('You need at least 3 valid scores to calculate a handicap');
                return;
            }
            
            // Sort differentials and select appropriate number based on WHS rules
            differentials.sort((a, b) => a - b);
            
            let differentialsToUse;
            if (differentials.length <= 3) differentialsToUse = 1;
            else if (differentials.length <= 4) differentialsToUse = 1;
            else if (differentials.length <= 5) differentialsToUse = 1;
            else if (differentials.length <= 6) differentialsToUse = 2;
            else if (differentials.length <= 8) differentialsToUse = 2;
            else if (differentials.length <= 11) differentialsToUse = 3;
            else if (differentials.length <= 14) differentialsToUse = 4;
            else if (differentials.length <= 16) differentialsToUse = 5;
            else if (differentials.length <= 18) differentialsToUse = 6;
            else if (differentials.length <= 19) differentialsToUse = 7;
            else differentialsToUse = 8;
            
            // Get the lowest differentials
            const usedDifferentials = differentials.slice(0, differentialsToUse);
            
            // Calculate average and apply 0.96 multiplier
            const average = usedDifferentials.reduce((sum, diff) => sum + diff, 0) / usedDifferentials.length;
            const handicapIndex = Math.max(0, average * 0.96);
            
            // Calculate course handicap
            const courseHandicap = Math.round(handicapIndex * (slopeRating / 113));
            
            // Calculate playing handicap (95% for stroke play)
            const playingHandicap = Math.round(courseHandicap * 0.95);
            
            // Display results
            document.getElementById('handicapIndex').textContent = handicapIndex.toFixed(1);
            document.getElementById('courseHandicap').textContent = courseHandicap;
            document.getElementById('playingHandicap').textContent = playingHandicap;
            document.getElementById('differentialsUsed').textContent = `${usedDifferentials.length} of ${differentials.length}`;
            
            document.getElementById('resultSection').style.display = 'block';
        }
        
        function loadExample(type) {
            // Clear existing scores
            document.getElementById('scoresContainer').innerHTML = '';
            scoreCount = 0;
            
            // Set course info
            document.getElementById('courseRating').value = '72.0';
            document.getElementById('slopeRating').value = '130';
            document.getElementById('par').value = '72';
            document.getElementById('teeBox').value = 'men';
            
            // Add example scores based on type
            let scores = [];
            
            switch(type) {
                case 'beginner':
                    scores = [95, 98, 102, 97, 99, 101, 96, 100, 104, 98, 97, 99];
                    break;
                case 'intermediate':
                    scores = [82, 85, 84, 87, 83, 86, 81, 85, 88, 84, 83, 86];
                    break;
                case 'advanced':
                    scores = [74, 76, 72, 75, 73, 77, 74, 75, 76, 72, 74, 75];
                    break;
                case 'pro':
                    scores = [70, 71, 69, 72, 68, 71, 70, 69, 72, 68, 70, 71];
                    break;
            }
            
            // Add score rows
            scores.forEach(score => {
                addScoreRow();
                const rows = document.querySelectorAll('.score-row');
                const lastRow = rows[rows.length - 1];
                
                lastRow.querySelector('.score-input').value = score;
                lastRow.querySelector('.rating-input').value = '72.0';
                lastRow.querySelector('.slope-input').value = '130';
            });
            
            // Calculate immediately
            setTimeout(calculateHandicap, 100);
        }
        
        // Initialize with one score row
        window.onload = function() {
            addScoreRow();
        };
    </script>
</body>
</html>
