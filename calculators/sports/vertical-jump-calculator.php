<?php
/**
 * Vertical Jump Calculator
 * File: sports/vertical-jump-calculator.php
 * Description: Calculate vertical jump height using various methods and compare with athletic standards
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vertical Jump Calculator - Measure Your Vertical Leap & Athletic Performance</title>
    <meta name="description" content="Calculate your vertical jump height using reach test, vertec, or video analysis. Compare with NBA, NFL, and athletic standards.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .method-tabs { display: flex; gap: 10px; margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; }
        .method-tab { padding: 12px 20px; background: #f8f9fa; border: none; border-radius: 8px 8px 0 0; cursor: pointer; transition: all 0.3s; font-weight: 500; }
        .method-tab.active { background: #ff6b35; color: white; }
        
        .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input, .input-wrapper select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus { outline: none; border-color: #ff6b35; box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1); }
        
        .unit-toggle { display: flex; gap: 10px; margin-bottom: 20px; }
        .unit-btn { padding: 10px 20px; background: #f8f9fa; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; }
        .unit-btn.active { background: #ff6b35; color: white; border-color: #ff6b35; }
        
        .calculate-btn { background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%); color: white; border: none; border-radius: 10px; padding: 15px 30px; font-size: 1.1rem; cursor: pointer; transition: all 0.3s; width: 100%; margin-top: 20px; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3); }
        
        .result-section { background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); padding: 25px; border-radius: 10px; margin-top: 25px; border-left: 4px solid #ff6b35; display: none; }
        .result-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.3rem; }
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .result-card { background: white; padding: 18px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .result-label { color: #7f8c8d; font-size: 0.85rem; margin-bottom: 5px; }
        .result-value { font-size: 1.4rem; font-weight: bold; color: #ff6b35; }
        
        .performance-meter { background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .meter-scale { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.8rem; color: #7f8c8d; }
        .meter-bar { height: 20px; background: #f0f0f0; border-radius: 10px; overflow: hidden; position: relative; }
        .meter-fill { height: 100%; background: linear-gradient(90deg, #4caf50, #ffeb3b, #ff9800, #f44336); transition: width 0.5s ease; }
        .meter-marker { position: absolute; top: -25px; transform: translateX(-50%); font-size: 0.7rem; color: #666; }
        
        .quick-actions { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-actions h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #ff6b35; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255, 107, 53, 0.15); }
        .quick-value { font-weight: bold; color: #ff6b35; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .jump-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .jump-table th, .jump-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .jump-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .jump-table tr:hover { background: #fff3e0; }
        
        .formula-box { background: #fff3e0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff6b35; }
        .formula-box strong { color: #ff6b35; }
        
        .comparison-chart { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin: 20px 0; }
        .sport-card { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #ff6b35; }
        .sport-name { font-weight: bold; color: #2c3e50; margin-bottom: 8px; }
        .sport-jump { color: #ff6b35; font-size: 1.1rem; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-row { grid-template-columns: 1fr; gap: 15px; }
            .method-tabs { flex-wrap: wrap; }
            .header h1 { font-size: 1.5rem; }
            .result-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏀 Vertical Jump Calculator</h1>
            <p>Measure your vertical leap using different methods and compare with professional athletic standards</p>
        </div>

        <div class="calculator-card">
            <div class="method-tabs">
                <button class="method-tab active" onclick="switchMethod('reach')">Reach Test</button>
                <button class="method-tab" onclick="switchMethod('vertec')">Vertec</button>
                <button class="method-tab" onclick="switchMethod('video')">Video Analysis</button>
                <button class="method-tab" onclick="switchMethod('force')">Force Plate</button>
            </div>
            
            <div class="unit-toggle">
                <button class="unit-btn active" onclick="switchUnits('imperial')">Imperial (inches/feet)</button>
                <button class="unit-btn" onclick="switchUnits('metric')">Metric (cm/meters)</button>
            </div>

            <!-- Reach Test Method -->
            <div id="reachMethod" class="method-content">
                <div class="input-row">
                    <div class="input-group">
                        <label for="standingReach">Standing Reach Height</label>
                        <div class="input-wrapper">
                            <input type="number" id="standingReach" placeholder="e.g., 84" step="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="jumpReach">Jump Reach Height</label>
                        <div class="input-wrapper">
                            <input type="number" id="jumpReach" placeholder="e.g., 108" step="0.1">
                        </div>
                    </div>
                </div>
                
                <div class="input-row">
                    <div class="input-group">
                        <label for="athleteHeight">Your Height</label>
                        <div class="input-wrapper">
                            <input type="number" id="athleteHeight" placeholder="e.g., 72" step="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="athleteWeight">Your Weight</label>
                        <div class="input-wrapper">
                            <input type="number" id="athleteWeight" placeholder="e.g., 180" step="0.1">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vertec Method -->
            <div id="vertecMethod" class="method-content" style="display: none;">
                <div class="input-row">
                    <div class="input-group">
                        <label for="vertecSetting">Vertec Setting (lowest vane)</label>
                        <div class="input-wrapper">
                            <input type="number" id="vertecSetting" placeholder="e.g., 84" step="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="vanesTouched">Number of Vanes Touched</label>
                        <div class="input-wrapper">
                            <input type="number" id="vanesTouched" placeholder="e.g., 12" step="1" min="0">
                        </div>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="vertecVaneHeight">Vane Spacing (inches between vanes)</label>
                    <div class="input-wrapper">
                        <input type="number" id="vertecVaneHeight" value="0.5" step="0.1" min="0.1">
                    </div>
                </div>
            </div>

            <!-- Video Analysis Method -->
            <div id="videoMethod" class="method-content" style="display: none;">
                <div class="input-row">
                    <div class="input-group">
                        <label for="referenceHeight">Reference Object Height</label>
                        <div class="input-wrapper">
                            <input type="number" id="referenceHeight" placeholder="e.g., 96 (rim height)" step="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="headClearance">Head Clearance Above Reference</label>
                        <div class="input-wrapper">
                            <input type="number" id="headClearance" placeholder="e.g., 6" step="0.1">
                        </div>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="videoMethodNote">Note: Use video analysis software or frame-by-frame analysis for accurate measurement</label>
                </div>
            </div>

            <!-- Force Plate Method -->
            <div id="forceMethod" class="method-content" style="display: none;">
                <div class="input-row">
                    <div class="input-group">
                        <label for="flightTime">Flight Time (seconds)</label>
                        <div class="input-wrapper">
                            <input type="number" id="flightTime" placeholder="e.g., 0.5" step="0.01" min="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="takeoffVelocity">Takeoff Velocity (m/s)</label>
                        <div class="input-wrapper">
                            <input type="number" id="takeoffVelocity" placeholder="e.g., 3.5" step="0.1">
                        </div>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="forcePlateNote">Note: Force plates provide the most accurate vertical jump measurement</label>
                </div>
            </div>

            <button class="calculate-btn" onclick="calculateJump()">Calculate Vertical Jump</button>

            <div class="result-section" id="resultSection">
                <h3>Your Vertical Jump Results</h3>
                <div class="result-grid">
                    <div class="result-card">
                        <div class="result-label">Vertical Jump</div>
                        <div class="result-value" id="jumpHeight">-</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Power Output</div>
                        <div class="result-value" id="powerOutput">-</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Athletic Rating</div>
                        <div class="result-value" id="athleticRating">-</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Percentile</div>
                        <div class="result-value" id="percentile">-</div>
                    </div>
                </div>
                
                <div class="performance-meter">
                    <h4>Performance Scale</h4>
                    <div class="meter-scale">
                        <span>Beginner</span>
                        <span>Average</span>
                        <span>Good</span>
                        <span>Elite</span>
                        <span>Pro</span>
                    </div>
                    <div class="meter-bar">
                        <div class="meter-fill" id="meterFill" style="width: 0%"></div>
                        <div class="meter-marker" style="left: 20%">16"</div>
                        <div class="meter-marker" style="left: 40%">20"</div>
                        <div class="meter-marker" style="left: 60%">24"</div>
                        <div class="meter-marker" style="left: 80%">28"</div>
                        <div class="meter-marker" style="left: 95%">32"</div>
                    </div>
                </div>
            </div>

            <div class="quick-actions">
                <h3>🏃 Quick Comparisons</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="loadExample('average')">
                        <div class="quick-value">Average Male</div>
                        <div class="quick-label">16-20 inches</div>
                    </div>
                    <div class="quick-btn" onclick="loadExample('college')">
                        <div class="quick-value">College Athlete</div>
                        <div class="quick-label">24-28 inches</div>
                    </div>
                    <div class="quick-btn" onclick="loadExample('nba')">
                        <div class="quick-value">NBA Player</div>
                        <div class="quick-label">28+ inches</div>
                    </div>
                    <div class="quick-btn" onclick="loadExample('elite')">
                        <div class="quick-value">Elite Jumper</div>
                        <div class="quick-label">32+ inches</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🏀 Understanding Vertical Jump</h2>
            
            <p>Vertical jump is a key measure of explosive lower body power and athletic ability. It's crucial for sports like basketball, volleyball, football, and track & field.</p>

            <h3>📊 Vertical Jump Standards (Men)</h3>
            <table class="jump-table">
                <thead>
                    <tr>
                        <th>Rating</th>
                        <th>Vertical Jump</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Excellent</td><td>28"+</td><td>Professional athlete level</td></tr>
                    <tr><td>Very Good</td><td>24"-28"</td><td>College athlete level</td></tr>
                    <tr><td>Above Average</td><td>20"-24"</td><td>Good recreational athlete</td></tr>
                    <tr><td>Average</td><td>16"-20"</td><td>Typical active male</td></tr>
                    <tr><td>Below Average</td><td>12"-16"</td><td>Needs improvement</td></tr>
                    <tr><td>Poor</td><td>&lt;12"</td><td>Significant training needed</td></tr>
                </tbody>
            </table>

            <h3>📈 Vertical Jump Standards (Women)</h3>
            <table class="jump-table">
                <thead>
                    <tr>
                        <th>Rating</th>
                        <th>Vertical Jump</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Excellent</td><td>24"+</td><td>Professional athlete level</td></tr>
                    <tr><td>Very Good</td><td>20"-24"</td><td>College athlete level</td></tr>
                    <tr><td>Above Average</td><td>16"-20"</td><td>Good recreational athlete</td></tr>
                    <tr><td>Average</td><td>12"-16"</td><td>Typical active female</td></tr>
                    <tr><td>Below Average</td><td>8"-12"</td><td>Needs improvement</td></tr>
                    <tr><td>Poor</td><td>&lt;8"</td><td>Significant training needed</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Formulas:</strong><br>
                • <strong>Vertical Jump</strong> = Jump Reach - Standing Reach<br>
                • <strong>Power (Watts)</strong> = (Weight × 9.81 × Jump Height) ÷ Time<br>
                • <strong>Flight Time Method</strong>: Height = (g × t²) ÷ 8 (where g = 9.81 m/s²)<br>
                • <strong>Velocity Method</strong>: Height = (v²) ÷ (2 × g)
            </div>

            <h3>🏆 Professional Athlete Vertical Jumps</h3>
            <div class="comparison-chart">
                <div class="sport-card">
                    <div class="sport-name">NBA Basketball</div>
                    <div class="sport-jump">28-40 inches</div>
                    <div style="font-size: 0.8rem; color: #666;">Michael Jordan: 48"</div>
                </div>
                <div class="sport-card">
                    <div class="sport-name">NFL Football</div>
                    <div class="sport-jump">30-38 inches</div>
                    <div style="font-size: 0.8rem; color: #666;">Combine average: 32"</div>
                </div>
                <div class="sport-card">
                    <div class="sport-name">Volleyball</div>
                    <div class="sport-jump">24-36 inches</div>
                    <div style="font-size: 0.8rem; color: #666;">Spike approach jumps</div>
                </div>
                <div class="sport-card">
                    <div class="sport-name">Sprinters</div>
                    <div class="sport-jump">22-30 inches</div>
                    <div style="font-size: 0.8rem; color: #666;">Explosive power</div>
                </div>
            </div>

            <h3>🎯 Measurement Methods</h3>
            <table class="jump-table">
                <thead>
                    <tr>
                        <th>Method</th>
                        <th>Accuracy</th>
                        <th>Equipment Needed</th>
                        <th>Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Force Plate</td><td>Very High</td><td>Force platform</td><td>Professional testing</td></tr>
                    <tr><td>Vertec</td><td>High</td><td>Vertec device</td><td>Team testing</td></tr>
                    <tr><td>Reach Test</td><td>Medium</td><td>Wall & tape measure</td><td>Home testing</td></tr>
                    <tr><td>Video Analysis</td><td>Medium</td><td>Camera & software</td><td>Coaching analysis</td></tr>
                    <tr><td>Jump Mat</td><td>High</td><td>Electronic mat</td><td>School testing</td></tr>
                </tbody>
            </table>

            <h3>💪 Factors Affecting Vertical Jump</h3>
            <ul>
                <li><strong>Muscle Fiber Type:</strong> Fast-twitch fibers for explosive power</li>
                <li><strong>Strength:</strong> Leg and core strength</li>
                <li><strong>Technique:</strong> Proper jumping mechanics</li>
                <li><strong>Body Composition:</strong> Power-to-weight ratio</li>
                <li><strong>Flexibility:</strong> Range of motion in hips and ankles</li>
                <li><strong>Neuromuscular Efficiency:</strong> Coordination and timing</li>
            </ul>

            <h3>📈 NFL Combine Vertical Jump Records</h3>
            <table class="jump-table">
                <thead>
                    <tr>
                        <th>Player</th>
                        <th>Position</th>
                        <th>Vertical</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Gerald Sensabaugh</td><td>Safety</td><td>46 inches</td><td>2005</td></tr>
                    <tr><td>Chris Conley</td><td>WR</td><td>45 inches</td><td>2015</td></tr>
                    <tr><td>Donovan Peoples-Jones</td><td>WR</td><td>44.5 inches</td><td>2020</td></tr>
                    <tr><td>Byron Jones</td><td>CB</td><td>44.5 inches</td><td>2015</td></tr>
                    <tr><td>Miles Boykin</td><td>WR</td><td>43.5 inches</td><td>2019</td></tr>
                </tbody>
            </table>

            <h3>🏀 NBA Draft Combine Standards</h3>
            <div class="formula-box">
                <strong>NBA Combine Averages:</strong><br>
                • <strong>Point Guards:</strong> 31-34 inches<br>
                • <strong>Shooting Guards:</strong> 32-35 inches<br>
                • <strong>Small Forwards:</strong> 33-36 inches<br>
                • <strong>Power Forwards:</strong> 31-34 inches<br>
                • <strong>Centers:</strong> 28-31 inches<br><br>
                <strong>Notable NBA Jumpers:</strong><br>
                • Michael Jordan: 48 inches (estimated)<br>
                • Zach LaVine: 46 inches<br>
                • Vince Carter: 43 inches<br>
                • LeBron James: 40+ inches
            </div>

            <h3>🚀 Improving Your Vertical Jump</h3>
            <ul>
                <li><strong>Plyometrics:</strong> Box jumps, depth jumps, bounding</li>
                <li><strong>Strength Training:</strong> Squats, deadlifts, lunges</li>
                <li><strong>Olympic Lifts:</strong> Power cleans, snatches</li>
                <li><strong>Jump Technique:</strong> Arm swing, countermovement</li>
                <li><strong>Flexibility:</strong> Hip mobility, ankle dorsiflexion</li>
                <li><strong>Plyometric Progressions:</strong> Start with low impact, build intensity</li>
            </ul>

            <h3>📊 Power Output Calculation</h3>
            <table class="jump-table">
                <thead>
                    <tr>
                        <th>Jump Height</th>
                        <th>Body Weight</th>
                        <th>Approximate Power</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>20 inches</td><td>180 lbs</td><td>2,100 watts</td></tr>
                    <tr><td>24 inches</td><td>180 lbs</td><td>2,500 watts</td></tr>
                    <tr><td>28 inches</td><td>180 lbs</td><td>2,900 watts</td></tr>
                    <tr><td>32 inches</td><td>180 lbs</td><td>3,300 watts</td></tr>
                    <tr><td>36 inches</td><td>180 lbs</td><td>3,700 watts</td></tr>
                </tbody>
            </table>

            <h3>🎯 Testing Tips for Accuracy</h3>
            <div class="formula-box">
                <strong>For Best Results:</strong><br>
                • Warm up properly before testing<br>
                • Use the same testing method consistently<br>
                • Test at the same time of day<br>
                • Allow adequate recovery between attempts<br>
                • Record the best of 3-5 attempts<br>
                • Use proper jumping technique with arm swing
            </div>

            <h3>🏃‍♂️ Sport-Specific Requirements</h3>
            <ul>
                <li><strong>Basketball:</strong> 24"+ for dunking, 28"+ for game dunks</li>
                <li><strong>Volleyball:</strong> 20"+ for spiking, 24"+ for competitive play</li>
                <li><strong>Football (WR/DB):</strong> 30"+ for NFL consideration</li>
                <li><strong>Soccer (Goalkeepers):</strong> 20"+ for effective play</li>
                <li><strong>Track & Field:</strong> 24"+ for jump events</li>
            </ul>

            <h3>📈 Age and Vertical Jump</h3>
            <table class="jump-table">
                <thead>
                    <tr>
                        <th>Age Group</th>
                        <th>Average Male</th>
                        <th>Average Female</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>13-14 years</td><td>14-18 inches</td><td>12-15 inches</td></tr>
                    <tr><td>15-16 years</td><td>16-20 inches</td><td>13-16 inches</td></tr>
                    <tr><td>17-18 years</td><td>18-22 inches</td><td>14-17 inches</td></tr>
                    <tr><td>19-25 years</td><td>19-23 inches</td><td>15-18 inches</td></tr>
                    <tr><td>26-35 years</td><td>18-22 inches</td><td>14-17 inches</td></tr>
                </tbody>
            </table>

            <h3>💡 Training Principles</h3>
            <ul>
                <li><strong>Progressive Overload:</strong> Gradually increase intensity</li>
                <li><strong>Specificity:</strong> Train movements similar to jumping</li>
                <li><strong>Recovery:</strong> Allow 48-72 hours between intense sessions</li>
                <li><strong>Variation:</strong> Change exercises every 4-6 weeks</li>
                <li><strong>Quality over Quantity:</strong> Focus on perfect form</li>
            </ul>
        </div>

        <div class="footer">
            <p>🏀 Vertical Jump Calculator | Professional Athletic Assessment</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Measure your explosive power and compare with NBA, NFL, and athletic standards</p>
        </div>
    </div>

    <script>
        let currentMethod = 'reach';
        let currentUnits = 'imperial';
        
        function switchMethod(method) {
            currentMethod = method;
            
            // Update tabs
            document.querySelectorAll('.method-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Show selected method
            document.querySelectorAll('.method-content').forEach(content => {
                content.style.display = 'none';
            });
            document.getElementById(method + 'Method').style.display = 'block';
        }
        
        function switchUnits(units) {
            currentUnits = units;
            
            // Update unit buttons
            document.querySelectorAll('.unit-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Update placeholders and labels based on units
            updateUnitLabels();
        }
        
        function updateUnitLabels() {
            const reachLabel = currentUnits === 'imperial' ? 'inches' : 'cm';
            const heightLabel = currentUnits === 'imperial' ? 'inches' : 'cm';
            const weightLabel = currentUnits === 'imperial' ? 'lbs' : 'kg';
            
            // Update placeholders
            document.getElementById('standingReach').placeholder = `e.g., ${currentUnits === 'imperial' ? '84' : '213'}`;
            document.getElementById('jumpReach').placeholder = `e.g., ${currentUnits === 'imperial' ? '108' : '274'}`;
            document.getElementById('athleteHeight').placeholder = `e.g., ${currentUnits === 'imperial' ? '72' : '183'}`;
            document.getElementById('athleteWeight').placeholder = `e.g., ${currentUnits === 'imperial' ? '180' : '82'}`;
            document.getElementById('vertecSetting').placeholder = `e.g., ${currentUnits === 'imperial' ? '84' : '213'}`;
        }
        
        function calculateJump() {
            let jumpHeight = 0;
            let powerOutput = 0;
            let athleticRating = '';
            let percentile = '';
            
            switch(currentMethod) {
                case 'reach':
                    const standingReach = parseFloat(document.getElementById('standingReach').value);
                    const jumpReach = parseFloat(document.getElementById('jumpReach').value);
                    const weight = parseFloat(document.getElementById('athleteWeight').value);
                    
                    if (!standingReach || !jumpReach) {
                        alert('Please enter both standing reach and jump reach values');
                        return;
                    }
                    
                    jumpHeight = jumpReach - standingReach;
                    
                    // Convert to metric if needed for power calculation
                    let jumpHeightM = currentUnits === 'imperial' ? jumpHeight * 0.0254 : jumpHeight / 100;
                    let weightKg = currentUnits === 'imperial' ? weight * 0.453592 : weight;
                    
                    // Simple power estimation (Watts)
                    powerOutput = Math.round((weightKg * 9.81 * jumpHeightM) / 0.2);
                    break;
                    
                case 'vertec':
                    const vertecSetting = parseFloat(document.getElementById('vertecSetting').value);
                    const vanesTouched = parseInt(document.getElementById('vanesTouched').value);
                    const vaneSpacing = parseFloat(document.getElementById('vertecVaneHeight').value);
                    
                    if (!vertecSetting || !vanesTouched) {
                        alert('Please enter Vertec setting and number of vanes touched');
                        return;
                    }
                    
                    jumpHeight = vertecSetting + (vanesTouched * vaneSpacing) - vertecSetting;
                    powerOutput = Math.round(jumpHeight * 45); // Estimated power
                    break;
                    
                case 'video':
                    const referenceHeight = parseFloat(document.getElementById('referenceHeight').value);
                    const headClearance = parseFloat(document.getElementById('headClearance').value);
                    
                    if (!referenceHeight || !headClearance) {
                        alert('Please enter both reference height and head clearance values');
                        return;
                    }
                    
                    // Estimate jump height based on head clearance (simplified)
                    jumpHeight = headClearance + 12; // Add approximate torso length
                    powerOutput = Math.round(jumpHeight * 40); // Estimated power
                    break;
                    
                case 'force':
                    const flightTime = parseFloat(document.getElementById('flightTime').value);
                    const takeoffVelocity = parseFloat(document.getElementById('takeoffVelocity').value);
                    
                    if (flightTime) {
                        // Using flight time: h = (g * t²) / 8
                        jumpHeight = (9.81 * Math.pow(flightTime, 2)) / 8;
                        // Convert to inches if imperial
                        if (currentUnits === 'imperial') {
                            jumpHeight = jumpHeight / 0.0254;
                        }
                    } else if (takeoffVelocity) {
                        // Using takeoff velocity: h = v² / (2 * g)
                        jumpHeight = Math.pow(takeoffVelocity, 2) / (2 * 9.81);
                        // Convert to inches if imperial
                        if (currentUnits === 'imperial') {
                            jumpHeight = jumpHeight / 0.0254;
                        }
                    } else {
                        alert('Please enter either flight time or takeoff velocity');
                        return;
                    }
                    
                    powerOutput = Math.round(jumpHeight * 50); // Estimated power
                    break;
            }
            
            // Determine athletic rating and percentile
            if (jumpHeight >= 32) {
                athleticRating = 'Elite/Pro';
                percentile = '95%+';
            } else if (jumpHeight >= 28) {
                athleticRating = 'Excellent';
                percentile = '85%';
            } else if (jumpHeight >= 24) {
                athleticRating = 'Very Good';
                percentile = '70%';
            } else if (jumpHeight >= 20) {
                athleticRating = 'Above Average';
                percentile = '50%';
            } else if (jumpHeight >= 16) {
                athleticRating = 'Average';
                percentile = '30%';
            } else {
                athleticRating = 'Below Average';
                percentile = '15%';
            }
            
            // Display results
            const unitSuffix = currentUnits === 'imperial' ? '"' : ' cm';
            document.getElementById('jumpHeight').textContent = jumpHeight.toFixed(1) + unitSuffix;
            document.getElementById('powerOutput').textContent = powerOutput + ' W';
            document.getElementById('athleticRating').textContent = athleticRating;
            document.getElementById('percentile').textContent = percentile;
            
            // Update performance meter
            const meterPercentage = Math.min(100, (jumpHeight / 40) * 100);
            document.getElementById('meterFill').style.width = meterPercentage + '%';
            
            document.getElementById('resultSection').style.display = 'block';
        }
        
        function loadExample(type) {
            switch(type) {
                case 'average':
                    document.getElementById('standingReach').value = '84';
                    document.getElementById('jumpReach').value = '100';
                    document.getElementById('athleteHeight').value = '70';
                    document.getElementById('athleteWeight').value = '170';
                    break;
                case 'college':
                    document.getElementById('standingReach').value = '85';
                    document.getElementById('jumpReach').value = '110';
                    document.getElementById('athleteHeight').value = '74';
                    document.getElementById('athleteWeight').value = '190';
                    break;
                case 'nba':
                    document.getElementById('standingReach').value = '88';
                    document.getElementById('jumpReach').value = '116';
                    document.getElementById('athleteHeight').value = '78';
                    document.getElementById('athleteWeight').value = '210';
                    break;
                case 'elite':
                    document.getElementById('standingReach').value = '86';
                    document.getElementById('jumpReach').value = '120';
                    document.getElementById('athleteHeight').value = '76';
                    document.getElementById('athleteWeight').value = '200';
                    break;
            }
            
            // Switch to reach method and calculate
            switchMethod('reach');
            setTimeout(calculateJump, 100);
        }
        
        // Initialize
        window.onload = function() {
            updateUnitLabels();
        };
    </script>
</body>
</html>
