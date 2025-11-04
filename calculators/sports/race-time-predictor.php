<?php
/**
 * Race Time Predictor
 * File: sports/race-time-predictor.php
 * Description: Predict race times across different distances using proven formulas
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Race Time Predictor - Calculate Your Race Performance Across Distances</title>
    <meta name="description" content="Predict your race times for different distances using Riegel's formula and other proven methods. Calculate marathon, half-marathon, 10K, and 5K times.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #FF6B6B 0%, #4ECDC4 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-section { margin-bottom: 30px; }
        .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { display: flex; gap: 10px; }
        .input-wrapper input, .input-wrapper select { flex: 1; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus { outline: none; border-color: #FF6B6B; box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1); }
        
        .calculate-btn { background: linear-gradient(135deg, #FF6B6B 0%, #4ECDC4 100%); color: white; border: none; padding: 16px 32px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3); }
        
        .results-section { margin-top: 30px; }
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .result-card { background: linear-gradient(135deg, #FFEAA7 0%, #FFD43B 100%); padding: 20px; border-radius: 12px; text-align: center; border-left: 4px solid #FF6B6B; }
        .result-distance { color: #2d3436; font-size: 1rem; margin-bottom: 8px; font-weight: 600; }
        .result-time { font-size: 1.4rem; font-weight: bold; color: #e17055; margin-bottom: 5px; }
        .result-pace { font-size: 0.9rem; color: #636e72; }
        
        .prediction-methods { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .methods-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .method-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .method-btn.active { border-color: #FF6B6B; background: #FFEAA7; }
        .method-btn:hover:not(.active) { border-color: #4ECDC4; }
        .method-name { font-weight: bold; color: #2c3e50; font-size: 0.9rem; }
        .method-desc { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .pace-chart { background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%); color: white; padding: 20px; border-radius: 12px; margin-top: 25px; }
        .pace-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .pace-table th, .pace-table td { padding: 12px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .pace-table th { background: rgba(255,255,255,0.1); font-weight: 600; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #FFEAA7; }
        
        .formula-box { background: #FFEAA7; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #FF6B6B; }
        .formula-box strong { color: #FF6B6B; }
        
        .training-plan { background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%); color: white; padding: 25px; border-radius: 12px; margin: 20px 0; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-row { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .methods-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏃 Race Time Predictor</h1>
            <p>Predict your race times across different distances using proven formulas and performance data</p>
        </div>

        <div class="calculator-card">
            <div class="input-section">
                <div class="input-row">
                    <div class="input-group">
                        <label for="knownDistance">Known Distance</label>
                        <div class="input-wrapper">
                            <input type="number" id="knownDistance" placeholder="Distance" min="1" max="100" value="10" step="0.1">
                            <select id="knownDistanceUnit">
                                <option value="km">km</option>
                                <option value="miles">miles</option>
                                <option value="meters">meters</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="knownTime">Known Time</label>
                        <div class="input-wrapper">
                            <input type="number" id="knownHours" placeholder="Hours" min="0" max="24" value="0">
                            <input type="number" id="knownMinutes" placeholder="Minutes" min="0" max="59" value="45">
                            <input type="number" id="knownSeconds" placeholder="Seconds" min="0" max="59" value="0">
                        </div>
                    </div>
                </div>
                
                <div class="input-row">
                    <div class="input-group">
                        <label for="targetDistance">Target Distance</label>
                        <div class="input-wrapper">
                            <input type="number" id="targetDistance" placeholder="Distance" min="1" max="200" value="21.1" step="0.1">
                            <select id="targetDistanceUnit">
                                <option value="km">km</option>
                                <option value="miles">miles</option>
                                <option value="meters">meters</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="fitnessLevel">Fitness Level</label>
                        <select id="fitnessLevel">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate" selected>Intermediate</option>
                            <option value="advanced">Advanced</option>
                            <option value="elite">Elite</option>
                        </select>
                    </div>
                </div>
                
                <button class="calculate-btn" onclick="calculateRaceTimes()">Calculate Predicted Times</button>
            </div>

            <div class="results-section">
                <h3 style="color: #2c3e50; margin-bottom: 15px;">🎯 Predicted Race Times</h3>
                <div class="results-grid" id="raceResults">
                    <!-- Results will be populated here -->
                </div>
                
                <div class="prediction-methods">
                    <h3 style="color: #2c3e50; margin-bottom: 15px;">📊 Prediction Methods</h3>
                    <div class="methods-grid">
                        <div class="method-btn active" data-method="riegel">
                            <div class="method-name">Riegel's Formula</div>
                            <div class="method-desc">Most accurate for trained runners</div>
                        </div>
                        <div class="method-btn" data-method="cameron">
                            <div class="method-name">Cameron Formula</div>
                            <div class="method-desc">Good for longer distances</div>
                        </div>
                        <div class="method-btn" data-method="pureMath">
                            <div class="method-name">Pure Math</div>
                            <div class="method-desc">Simple pace calculation</div>
                        </div>
                        <div class="method-btn" data-method="vdot">
                            <div class="method-name">VDOT Method</div>
                            <div class="method-desc">Jack Daniels' running formula</div>
                        </div>
                    </div>
                </div>
                
                <div class="pace-chart">
                    <h3 style="color: white; margin-bottom: 15px;">⏱️ Pace Chart</h3>
                    <table class="pace-table">
                        <thead>
                            <tr>
                                <th>Distance</th>
                                <th>Predicted Time</th>
                                <th>Average Pace</th>
                                <th>Equivalent Pace</th>
                            </tr>
                        </thead>
                        <tbody id="paceChartBody">
                            <!-- Pace chart will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🏃 Race Time Prediction Science</h2>
            
            <p>Accurately predict your race times across different distances using proven mathematical formulas and running physiology principles.</p>

            <h3>📈 Prediction Formulas</h3>
            <div class="formula-box">
                <strong>Riegel's Formula (Most Popular):</strong><br>
                T₂ = T₁ × (D₂/D₁)¹.⁰⁶<br><br>
                <strong>Where:</strong><br>
                • T₁ = Known time<br>
                • D₁ = Known distance<br>
                • T₂ = Predicted time<br>
                • D₂ = Target distance<br>
                • 1.06 = Endurance coefficient
            </div>

            <h3>🎯 Common Race Distances</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Distance</th>
                        <th>Kilometers</th>
                        <th>Miles</th>
                        <th>Common Name</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>5K</td><td>5 km</td><td>3.11 miles</td><td>Parkrun, Fun Run</td></tr>
                    <tr><td>10K</td><td>10 km</td><td>6.21 miles</td><td>Standard Road Race</td></tr>
                    <tr><td>Half Marathon</td><td>21.1 km</td><td>13.1 miles</td><td>Popular Distance</td></tr>
                    <tr><td>Marathon</td><td>42.2 km</td><td>26.2 miles</td><td>Classic Distance</td></tr>
                    <tr><td>Ultra Marathon</td><td>50+ km</td><td>31+ miles</td><td>Ultra Distance</td></tr>
                </tbody>
            </table>

            <h3>📊 World Record Times</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Distance</th>
                        <th>Men's Record</th>
                        <th>Women's Record</th>
                        <th>Pace (min/km)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>5K</td><td>12:35</td><td>14:05</td><td>2:31 / 2:49</td></tr>
                    <tr><td>10K</td><td>26:11</td><td>29:01</td><td>2:37 / 2:54</td></tr>
                    <tr><td>Half Marathon</td><td>57:31</td><td>1:02:52</td><td>2:44 / 2:59</td></tr>
                    <tr><td>Marathon</td><td>2:00:35</td><td>2:11:53</td><td>2:52 / 3:07</td></tr>
                </tbody>
            </table>

            <h3>💪 Fitness Level Adjustments</h3>
            <ul>
                <li><strong>Beginner:</strong> +8-12% time adjustment for less endurance</li>
                <li><strong>Intermediate:</strong> Standard prediction (most accurate)</li>
                <li><strong>Advanced:</strong> -3-5% for better endurance and pacing</li>
                <li><strong>Elite:</strong> -5-8% for superior endurance and efficiency</li>
            </ul>

            <h3>🎯 Accuracy Factors</h3>
            <div class="formula-box">
                <strong>Factors Affecting Prediction Accuracy:</strong><br>
                • Training consistency and volume<br>
                • Course elevation and terrain<br>
                • Weather conditions<br>
                • Pacing strategy<br>
                • Race day nutrition<br>
                • Mental preparation<br>
                • Equipment and shoes
            </div>

            <h3>🏃‍♂️ Training Paces</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Training Type</th>
                        <th>% of Race Pace</th>
                        <th>Purpose</th>
                        <th>Example (5K pace 5:00/km)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Recovery</td><td>65-75%</td><td>Active recovery</td><td>6:30-7:30/km</td></tr>
                    <tr><td>Easy</td><td>75-85%</td><td>Aerobic base</td><td>6:00-6:30/km</td></tr>
                    <tr><td>Marathon Pace</td><td>85-90%</td><td>Endurance</td><td>5:30-5:45/km</td></tr>
                    <tr><td>Threshold</td><td>90-95%</td><td>Lactate clearance</td><td>5:15-5:30/km</td></tr>
                    <tr><td>Interval</td><td>105-110%</td><td>VO2 max</td><td>4:30-4:45/km</td></tr>
                </tbody>
            </table>

            <div class="training-plan">
                <h3 style="color: white;">📅 Sample Training Week</h3>
                <table class="pace-table">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Workout</th>
                            <th>Distance</th>
                            <th>Purpose</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Monday</td><td>Easy Run</td><td>5-8 km</td><td>Recovery</td></tr>
                        <tr><td>Tuesday</td><td>Interval Training</td><td>8-12 km</td><td>Speed</td></tr>
                        <tr><td>Wednesday</td><td>Rest or Cross</td><td>-</td><td>Recovery</td></tr>
                        <tr><td>Thursday</td><td>Tempo Run</td><td>10-15 km</td><td>Endurance</td></tr>
                        <tr><td>Friday</td><td>Easy Run</td><td>5-8 km</td><td>Recovery</td></tr>
                        <tr><td>Saturday</td><td>Long Run</td><td>15-25 km</td><td>Aerobic Base</td></tr>
                        <tr><td>Sunday</td><td>Rest</td><td>-</td><td>Recovery</td></tr>
                    </tbody>
                </table>
            </div>

            <h3>🌡️ Environmental Factors</h3>
            <ul>
                <li><strong>Temperature:</strong> Ideal 10-15°C (50-59°F)</li>
                <li><strong>Humidity:</strong> Below 60% optimal</li>
                <li><strong>Altitude:</strong> Affects oxygen availability</li>
                <li><strong>Wind:</strong> Can significantly impact times</li>
                <li><strong>Course Profile:</strong> Flat vs hilly courses</li>
            </ul>

            <h3>📱 Popular Prediction Tools</h3>
            <div class="formula-box">
                <strong>Well-Known Prediction Methods:</strong><br>
                • <strong>VDOT Calculator:</strong> Jack Daniels' running formula<br>
                • <strong>McMillan Calculator:</strong> Training pace calculator<br>
                • <strong>Riegel Formula:</strong> Mathematical prediction<br>
                • <strong>Runner's World Calculator:</strong> Popular online tool<br>
                • <strong>Training Peaks:</strong> Performance management
            </div>

            <h3>🎯 Race Strategy Tips</h3>
            <ul>
                <li><strong>Negative Split:</strong> Run second half faster than first</li>
                <li><strong>Even Pace:</strong> Maintain consistent pace throughout</li>
                <li><strong>Fueling:</strong> Practice nutrition strategy in training</li>
                <li><strong>Taper:</strong> Reduce training 2-3 weeks before race</li>
                <li><strong>Course Knowledge:</strong> Study elevation and turns</li>
            </ul>

            <h3>📈 Progress Tracking</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Time Period</th>
                        <th>Expected Improvement</th>
                        <th>Key Focus Areas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>0-3 months</td><td>5-10%</td><td>Consistency, base building</td></tr>
                    <tr><td>3-6 months</td><td>10-15%</td><td>Speed work, form improvement</td></tr>
                    <tr><td>6-12 months</td><td>15-25%</td><td>Advanced training, racing strategy</td></tr>
                    <tr><td>1-2 years</td><td>25-40%</td><td>Specialization, peak performance</td></tr>
                </tbody>
            </table>

            <h3>⚡ Quick Reference Paces</h3>
            <div class="formula-box">
                <strong>Common Race Pace Conversions:</strong><br>
                • 5:00/km pace = 8:03/mile pace<br>
                • 6:00/km pace = 9:39/mile pace<br>
                • 7:00/km pace = 11:16/mile pace<br>
                • 8:00/km pace = 12:52/mile pace<br><br>
                <strong>Marathon Finish Times:</strong><br>
                • 5:00/km = 3:30 marathon<br>
                • 5:30/km = 3:51 marathon<br>
                • 6:00/km = 4:13 marathon<br>
                • 6:30/km = 4:34 marathon
            </div>
        </div>

        <div class="footer">
            <p>🏃 Race Time Predictor | Accurate Performance Projections</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Predict marathon, half-marathon, 10K, and 5K times using proven formulas</p>
        </div>
    </div>

    <script>
        let currentMethod = 'riegel';
        
        // Initialize method buttons
        document.querySelectorAll('.method-btn').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.method-btn').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                currentMethod = button.dataset.method;
                calculateRaceTimes();
            });
        });

        // Distance conversion factors
        const distanceFactors = {
            km: 1,
            miles: 1.60934,
            meters: 0.001
        };

        // Fitness level adjustments
        const fitnessAdjustments = {
            beginner: 1.10,    // +10%
            intermediate: 1.00, // no adjustment
            advanced: 0.97,    // -3%
            elite: 0.94        // -6%
        };

        function calculateRaceTimes() {
            // Get input values
            const knownDistance = parseFloat(document.getElementById('knownDistance').value);
            const knownDistanceUnit = document.getElementById('knownDistanceUnit').value;
            const knownHours = parseInt(document.getElementById('knownHours').value) || 0;
            const knownMinutes = parseInt(document.getElementById('knownMinutes').value) || 0;
            const knownSeconds = parseInt(document.getElementById('knownSeconds').value) || 0;
            const targetDistance = parseFloat(document.getElementById('targetDistance').value);
            const targetDistanceUnit = document.getElementById('targetDistanceUnit').value;
            const fitnessLevel = document.getElementById('fitnessLevel').value;

            // Validate inputs
            if (!knownDistance || !targetDistance) {
                alert('Please enter valid distances');
                return;
            }

            // Convert distances to kilometers
            const knownDistanceKm = knownDistance * distanceFactors[knownDistanceUnit];
            const targetDistanceKm = targetDistance * distanceFactors[targetDistanceUnit];

            // Calculate known time in seconds
            const knownTimeSeconds = knownHours * 3600 + knownMinutes * 60 + knownSeconds;

            if (knownTimeSeconds <= 0) {
                alert('Please enter a valid time');
                return;
            }

            // Calculate predicted time based on selected method
            let predictedTimeSeconds;
            
            switch(currentMethod) {
                case 'riegel':
                    predictedTimeSeconds = riegelFormula(knownTimeSeconds, knownDistanceKm, targetDistanceKm);
                    break;
                case 'cameron':
                    predictedTimeSeconds = cameronFormula(knownTimeSeconds, knownDistanceKm, targetDistanceKm);
                    break;
                case 'pureMath':
                    predictedTimeSeconds = pureMathFormula(knownTimeSeconds, knownDistanceKm, targetDistanceKm);
                    break;
                case 'vdot':
                    predictedTimeSeconds = vdotFormula(knownTimeSeconds, knownDistanceKm, targetDistanceKm);
                    break;
            }

            // Apply fitness level adjustment
            predictedTimeSeconds *= fitnessAdjustments[fitnessLevel];

            // Display results
            displayResults(predictedTimeSeconds, targetDistanceKm);
            displayPaceChart(knownTimeSeconds, knownDistanceKm, fitnessLevel);
        }

        function riegelFormula(knownTime, knownDistance, targetDistance) {
            // T₂ = T₁ × (D₂/D₁)¹.⁰⁶
            return knownTime * Math.pow(targetDistance / knownDistance, 1.06);
        }

        function cameronFormula(knownTime, knownDistance, targetDistance) {
            // More conservative for longer distances
            const exponent = targetDistance > 21.1 ? 1.07 : 1.06;
            return knownTime * Math.pow(targetDistance / knownDistance, exponent);
        }

        function pureMathFormula(knownTime, knownDistance, targetDistance) {
            // Simple pace calculation
            const pacePerKm = knownTime / knownDistance;
            return pacePerKm * targetDistance;
        }

        function vdotFormula(knownTime, knownDistance, targetDistance) {
            // Simplified VDOT approximation
            const vdot = (knownDistance * 1000) / knownTime * 0.2;
            return (targetDistance * 1000) / (vdot * 5);
        }

        function displayResults(predictedTimeSeconds, targetDistanceKm) {
            const resultsGrid = document.getElementById('raceResults');
            resultsGrid.innerHTML = '';

            // Format predicted time
            const predictedTimeFormatted = formatTime(predictedTimeSeconds);
            const pacePerKm = formatPace(predictedTimeSeconds / targetDistanceKm);
            const pacePerMile = formatPace((predictedTimeSeconds / targetDistanceKm) * 1.60934);

            // Create result cards for different distances
            const commonDistances = [
                { dist: 5, name: '5K', unit: 'km' },
                { dist: 10, name: '10K', unit: 'km' },
                { dist: 21.1, name: 'Half Marathon', unit: 'km' },
                { dist: 42.2, name: 'Marathon', unit: 'km' },
                { dist: targetDistanceKm, name: 'Target Distance', unit: 'km' }
            ];

            commonDistances.forEach(distance => {
                let timeSeconds;
                switch(currentMethod) {
                    case 'riegel':
                        timeSeconds = riegelFormula(predictedTimeSeconds, targetDistanceKm, distance.dist);
                        break;
                    default:
                        timeSeconds = predictedTimeSeconds * (distance.dist / targetDistanceKm);
                }

                // Apply fitness adjustment
                const fitnessLevel = document.getElementById('fitnessLevel').value;
                timeSeconds *= fitnessAdjustments[fitnessLevel];

                const pace = formatPace(timeSeconds / distance.dist);
                
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div class="result-distance">${distance.name}</div>
                    <div class="result-time">${formatTime(timeSeconds)}</div>
                    <div class="result-pace">${pace}/km</div>
                `;
                resultsGrid.appendChild(card);
            });
        }

        function displayPaceChart(knownTimeSeconds, knownDistanceKm, fitnessLevel) {
            const paceChartBody = document.getElementById('paceChartBody');
            paceChartBody.innerHTML = '';

            const distances = [1, 5, 10, 21.1, 42.2];
            
            distances.forEach(distance => {
                let timeSeconds;
                switch(currentMethod) {
                    case 'riegel':
                        timeSeconds = riegelFormula(knownTimeSeconds, knownDistanceKm, distance);
                        break;
                    default:
                        timeSeconds = knownTimeSeconds * (distance / knownDistanceKm);
                }

                // Apply fitness adjustment
                timeSeconds *= fitnessAdjustments[fitnessLevel];

                const pacePerKm = formatPace(timeSeconds / distance);
                const pacePerMile = formatPace((timeSeconds / distance) * 1.60934);
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${distance} km</td>
                    <td>${formatTime(timeSeconds)}</td>
                    <td>${pacePerKm}/km</td>
                    <td>${pacePerMile}/mile</td>
                `;
                paceChartBody.appendChild(row);
            });
        }

        function formatTime(totalSeconds) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = Math.floor(totalSeconds % 60);
            
            if (hours > 0) {
                return `${hours}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            } else {
                return `${minutes}:${seconds.toString().padStart(2, '0')}`;
            }
        }

        function formatPace(secondsPerKm) {
            const minutes = Math.floor(secondsPerKm / 60);
            const seconds = Math.floor(secondsPerKm % 60);
            return `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }

        // Auto-calculate when inputs change
        document.getElementById('knownDistance').addEventListener('input', calculateRaceTimes);
        document.getElementById('knownDistanceUnit').addEventListener('change', calculateRaceTimes);
        document.getElementById('knownHours').addEventListener('input', calculateRaceTimes);
        document.getElementById('knownMinutes').addEventListener('input', calculateRaceTimes);
        document.getElementById('knownSeconds').addEventListener('input', calculateRaceTimes);
        document.getElementById('targetDistance').addEventListener('input', calculateRaceTimes);
        document.getElementById('targetDistanceUnit').addEventListener('change', calculateRaceTimes);
        document.getElementById('fitnessLevel').addEventListener('change', calculateRaceTimes);

        // Initial calculation
        calculateRaceTimes();
    </script>
</body>
</html>
