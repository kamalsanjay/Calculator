<?php
/**
 * Walking Calorie Calculator
 * File: walking-calorie-calculator.php
 * Description: Calculate calories burned while walking based on distance, pace, and personal factors
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walking Calorie Calculator - Estimate Calories Burned Walking</title>
    <meta name="description" content="Advanced Walking Calorie Calculator. Calculate calories burned walking based on distance, pace, terrain, and personal factors with MET values and detailed analysis.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🚶 Walking Calorie Calculator</h1>
        <p>Calculate calories burned walking based on your pace and personal factors</p>
    </header>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        header p {
            font-size: 1.2em;
            opacity: 0.9;
        }
        
        .breadcrumb {
            margin: 20px 0;
        }
        
        .breadcrumb a {
            color: #00b894;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #00a085;
        }
        
        .calculator-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }
        
        .calculator-section,
        .results-section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .calculator-section h2,
        .results-section h2 {
            color: #00b894;
            margin-bottom: 25px;
            font-size: 1.8em;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #00b894;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #888;
            font-size: 0.9em;
        }
        
        .btn {
            background: #00b894;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #00a085;
        }
        
        .result-card {
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        
        .result-card h3 {
            font-size: 1.2em;
            opacity: 0.9;
            margin-bottom: 10px;
            font-weight: 400;
        }
        
        .result-card .amount {
            font-size: 3em;
            font-weight: bold;
        }
        
        .result-card .category {
            font-size: 1.3em;
            margin-top: 10px;
            opacity: 0.95;
        }
        
        .low-intensity {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .moderate-intensity {
            background: linear-gradient(135deg, #FFC107 0%, #FFA000 100%);
        }
        
        .high-intensity {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
        }
        
        .very-high-intensity {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        }
        
        .metric-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .metric-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #e0e0e0;
        }
        
        .metric-card h4 {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
            font-weight: 400;
        }
        
        .metric-card .value {
            color: #00b894;
            font-size: 2em;
            font-weight: bold;
        }
        
        .breakdown {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .breakdown h3 {
            color: #00b894;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .breakdown-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .breakdown-item:last-child {
            border-bottom: none;
        }
        
        .breakdown-item span {
            color: #666;
        }
        
        .breakdown-item strong {
            color: #333;
            font-weight: 600;
        }
        
        .info-box {
            background: #e8f5e9;
            border-left: 4px solid #00b894;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box strong {
            color: #00a085;
        }
        
        .pace-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .pace-option {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .pace-option.active {
            background: #00b894;
            color: white;
            border-color: #00a085;
        }
        
        .terrain-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .terrain-option {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .terrain-option.active {
            background: #00b894;
            color: white;
            border-color: #00a085;
        }
        
        .unit-toggle {
            display: flex;
            background: #f8f9fa;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 15px;
        }
        
        .unit-option {
            flex: 1;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            border-radius: 3px;
            transition: all 0.3s;
        }
        
        .unit-option.active {
            background: #00b894;
            color: white;
        }
        
        .distance-inputs {
            display: flex;
            gap: 10px;
        }
        
        .distance-inputs input {
            flex: 1;
        }
        
        .calorie-equivalents {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 15px;
        }
        
        .food-item {
            background: white;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e0e0e0;
            font-size: 0.9em;
        }
        
        .progress-meter {
            height: 20px;
            background: #e0e0e0;
            border-radius: 10px;
            margin: 15px 0;
            overflow: hidden;
        }
        
        .progress-level {
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s ease;
            background: linear-gradient(90deg, #4CAF50, #FFC107, #FF9800, #f44336);
        }
        
        .intensity-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 0.9em;
            color: #666;
        }
        
        .comparison-chart {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        
        .comparison-chart th, .comparison-chart td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .comparison-chart th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #555;
        }
        
        .comparison-chart tr:hover {
            background-color: #f5f5f5;
        }
        
        @media (max-width: 768px) {
            .calculator-wrapper {
                grid-template-columns: 1fr;
            }
            
            header h1 {
                font-size: 2em;
            }
            
            .result-card .amount {
                font-size: 2.5em;
            }
            
            .metric-grid {
                grid-template-columns: 1fr;
            }
            
            .pace-options,
            .terrain-options {
                grid-template-columns: 1fr;
            }
            
            .calorie-equivalents {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Walking Details</h2>
                <form id="walkingCalorieForm">
                    <div class="form-group">
                        <label>Unit System</label>
                        <div class="unit-toggle">
                            <div class="unit-option active" data-unit="metric">Metric</div>
                            <div class="unit-option" data-unit="imperial">Imperial</div>
                        </div>
                        <input type="hidden" id="unitSystem" value="metric">
                    </div>
                    
                    <div class="form-group" id="metricDistanceGroup">
                        <label for="distanceKm">Distance (kilometers)</label>
                        <input type="number" id="distanceKm" value="5" min="0.1" max="100" step="0.1" required>
                    </div>
                    
                    <div class="form-group" id="imperialDistanceGroup" style="display: none;">
                        <label for="distanceMiles">Distance (miles)</label>
                        <input type="number" id="distanceMiles" value="3.1" min="0.1" max="62" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Walking Pace</label>
                        <div class="pace-options">
                            <div class="pace-option active" data-pace="leisurely">
                                <strong>Leisurely</strong>
                                <div>3-4 km/h</div>
                                <div>2-2.5 mph</div>
                            </div>
                            <div class="pace-option" data-pace="brisk">
                                <strong>Brisk</strong>
                                <div>5-6 km/h</div>
                                <div>3.1-3.7 mph</div>
                            </div>
                            <div class="pace-option" data-pace="power">
                                <strong>Power Walk</strong>
                                <div>7+ km/h</div>
                                <div>4.3+ mph</div>
                            </div>
                        </div>
                        <input type="hidden" id="walkingPace" value="leisurely">
                    </div>
                    
                    <div class="form-group">
                        <label>Terrain Type</label>
                        <div class="terrain-options">
                            <div class="terrain-option active" data-terrain="flat">
                                <strong>Flat Surface</strong>
                                <div>Road, track, treadmill</div>
                            </div>
                            <div class="terrain-option" data-terrain="hilly">
                                <strong>Hilly Terrain</strong>
                                <div>Rolling hills, moderate incline</div>
                            </div>
                        </div>
                        <input type="hidden" id="terrainType" value="flat">
                    </div>
                    
                    <div class="form-group">
                        <label for="weight">Your Weight</label>
                        <div class="distance-inputs">
                            <input type="number" id="weightKg" value="70" min="30" max="200" step="0.1" placeholder="kg">
                            <input type="number" id="weightLbs" value="154" min="66" max="440" step="0.1" placeholder="lbs" style="display: none;">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" value="35" min="5" max="100" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="fitnessLevel">Fitness Level</label>
                        <select id="fitnessLevel">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate" selected>Intermediate</option>
                            <option value="advanced">Advanced</option>
                            <option value="athlete">Athlete</option>
                        </select>
                        <small>Affects calorie calculation efficiency</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Calories Burned</button>
                </form>
                
                <div class="breakdown" style="margin-top: 30px;">
                    <h3>Walking Pace Guide</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Leisurely (3-4 km/h / 2-2.5 mph):</strong> Comfortable pace, able to hold conversation easily</p>
                        <p><strong>Brisk (5-6 km/h / 3.1-3.7 mph):</strong> Purposeful walking, slightly breathless but can talk</p>
                        <p><strong>Power Walk (7+ km/h / 4.3+ mph):</strong> Fast pace, arm movement, breathing heavily</p>
                        <p><strong>MET Values:</strong> Leisurely: 3.5, Brisk: 4.3, Power: 5.0, Hilly: +0.5-1.0 MET</p>
                    </div>
                </div>
            </div>

            <div class="results-section">
                <h2>Calorie Burn Results</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Calories Burned</h3>
                    <div class="amount" id="caloriesBurned">210</div>
                    <div class="category" id="intensityLevel">Moderate Intensity</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Distance Walked</h4>
                        <div class="value" id="distanceWalked">5.0 km</div>
                    </div>
                    <div class="metric-card">
                        <h4>Estimated Time</h4>
                        <div class="value" id="estimatedTime">1:00</div>
                    </div>
                    <div class="metric-card">
                        <h4>Calories per km</h4>
                        <div class="value" id="caloriesPerKm">42</div>
                    </div>
                    <div class="metric-card">
                        <h4>MET Value</h4>
                        <div class="value" id="metValue">4.3</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Walk Analysis</h3>
                    <div class="breakdown-item">
                        <span>Total Calories</span>
                        <strong id="totalCalories">210 kcal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Walking Pace</span>
                        <strong id="paceDisplay">Brisk (5 km/h)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Terrain</span>
                        <strong id="terrainDisplay">Flat Surface</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Your Weight</span>
                        <strong id="weightDisplay">70 kg</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Exercise Intensity</span>
                        <strong id="intensityDisplay">Moderate</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Exercise Intensity</h3>
                    <div class="progress-meter">
                        <div class="progress-level" id="intensityMeter" style="width: 50%;"></div>
                    </div>
                    <div class="intensity-labels">
                        <span>Light</span>
                        <span>Moderate</span>
                        <span>Vigorous</span>
                        <span>Very Hard</span>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Calorie Equivalents</h3>
                    <div class="calorie-equivalents">
                        <div class="food-item">
                            <strong>Apple</strong><br>
                            <span id="appleEquiv">1.0 medium</span>
                        </div>
                        <div class="food-item">
                            <strong>Banana</strong><br>
                            <span id="bananaEquiv">0.8 medium</span>
                        </div>
                        <div class="food-item">
                            <strong>Chocolate Bar</strong><br>
                            <span id="chocolateEquiv">0.4 bar</span>
                        </div>
                        <div class="food-item">
                            <strong>Slice of Pizza</strong><br>
                            <span id="pizzaEquiv">0.3 slice</span>
                        </div>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Weekly Goal Progress</h3>
                    <div class="breakdown-item">
                        <span>This Walk</span>
                        <strong id="thisWalk">210 kcal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekly Target (1500 kcal)</span>
                        <strong id="weeklyTarget">1500 kcal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Progress</span>
                        <strong id="weeklyProgress">14%</strong>
                    </div>
                    <div class="progress-meter" style="margin: 10px 0;">
                        <div class="progress-level" id="weeklyProgressBar" style="width: 14%; background: #00b894;"></div>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Walking Comparison</h3>
                    <table class="comparison-chart">
                        <thead>
                            <tr>
                                <th>Activity</th>
                                <th>Calories (30 min)</th>
                                <th>Equivalent Walk</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Your Walk</td>
                                <td id="yourWalkCalories">105 kcal</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Running (8 km/h)</td>
                                <td>240 kcal</td>
                                <td id="runningEquivalent">2.3x longer</td>
                            </tr>
                            <tr>
                                <td>Cycling (moderate)</td>
                                <td>180 kcal</td>
                                <td id="cyclingEquivalent">1.7x longer</td>
                            </tr>
                            <tr>
                                <td>Swimming</td>
                                <td>200 kcal</td>
                                <td id="swimmingEquivalent">1.9x longer</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Health Benefits</h3>
                    <div id="healthBenefits" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="benefitsText" style="margin: 0;">This walk provides excellent cardiovascular benefits, helps maintain healthy weight, improves mood, and reduces disease risk. Regular walking can lower blood pressure, improve cholesterol levels, and boost immune function.</p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Walking Tips:</strong> Brisk walking (5-6 km/h) provides optimal health benefits. Use proper posture: head up, shoulders relaxed, arms bent 90 degrees. Wear comfortable, supportive shoes. Start with 10-15 minutes daily, gradually increase duration and pace. Walk on varied terrain for better muscle engagement. Use arm movement to increase intensity. Stay hydrated, especially in warm weather. Track progress with steps or distance goals. 10,000 steps ≈ 8 km ≈ 400-500 calories. Walking after meals helps control blood sugar. Incline walking increases calorie burn by 30-50%. Consistency matters more than intensity for long-term health benefits.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('walkingCalorieForm');
        const unitOptions = document.querySelectorAll('.unit-option');
        const paceOptions = document.querySelectorAll('.pace-option');
        const terrainOptions = document.querySelectorAll('.terrain-option');
        
        // Unit system toggle
        unitOptions.forEach(option => {
            option.addEventListener('click', function() {
                unitOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                const unitSystem = this.dataset.unit;
                document.getElementById('unitSystem').value = unitSystem;
                
                // Toggle distance inputs
                document.getElementById('metricDistanceGroup').style.display = unitSystem === 'metric' ? 'block' : 'none';
                document.getElementById('imperialDistanceGroup').style.display = unitSystem === 'imperial' ? 'block' : 'none';
                
                // Toggle weight inputs
                document.getElementById('weightKg').style.display = unitSystem === 'metric' ? 'block' : 'none';
                document.getElementById('weightLbs').style.display = unitSystem === 'imperial' ? 'block' : 'none';
                
                calculateCalories();
            });
        });
        
        // Pace option selection
        paceOptions.forEach(option => {
            option.addEventListener('click', function() {
                paceOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('walkingPace').value = this.dataset.pace;
                calculateCalories();
            });
        });
        
        // Terrain option selection
        terrainOptions.forEach(option => {
            option.addEventListener('click', function() {
                terrainOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('terrainType').value = this.dataset.terrain;
                calculateCalories();
            });
        });
        
        // Sync weight inputs
        document.getElementById('weightKg').addEventListener('input', function() {
            const kg = parseFloat(this.value) || 0;
            document.getElementById('weightLbs').value = (kg * 2.20462).toFixed(1);
            calculateCalories();
        });
        
        document.getElementById('weightLbs').addEventListener('input', function() {
            const lbs = parseFloat(this.value) || 0;
            document.getElementById('weightKg').value = (lbs / 2.20462).toFixed(1);
            calculateCalories();
        });
        
        // Sync distance inputs
        document.getElementById('distanceKm').addEventListener('input', function() {
            const km = parseFloat(this.value) || 0;
            document.getElementById('distanceMiles').value = (km * 0.621371).toFixed(1);
            calculateCalories();
        });
        
        document.getElementById('distanceMiles').addEventListener('input', function() {
            const miles = parseFloat(this.value) || 0;
            document.getElementById('distanceKm').value = (miles / 0.621371).toFixed(1);
            calculateCalories();
        });
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateCalories();
        });

        function calculateCalories() {
            const unitSystem = document.getElementById('unitSystem').value;
            const distance = unitSystem === 'metric' ? 
                parseFloat(document.getElementById('distanceKm').value) || 0 :
                parseFloat(document.getElementById('distanceMiles').value) || 0;
            const pace = document.getElementById('walkingPace').value;
            const terrain = document.getElementById('terrainType').value;
            const weight = unitSystem === 'metric' ?
                parseFloat(document.getElementById('weightKg').value) || 0 :
                parseFloat(document.getElementById('weightLbs').value) || 0;
            const age = parseInt(document.getElementById('age').value) || 0;
            const gender = document.getElementById('gender').value;
            const fitnessLevel = document.getElementById('fitnessLevel').value;
            
            // Convert to metric for calculations
            const distanceKm = unitSystem === 'metric' ? distance : distance / 0.621371;
            const weightKg = unitSystem === 'metric' ? weight : weight / 2.20462;
            
            // Determine MET values based on pace and terrain
            let baseMET = 0;
            let paceSpeed = 0;
            
            switch(pace) {
                case 'leisurely':
                    baseMET = 3.5;
                    paceSpeed = 4; // km/h
                    break;
                case 'brisk':
                    baseMET = 4.3;
                    paceSpeed = 5.5; // km/h
                    break;
                case 'power':
                    baseMET = 5.0;
                    paceSpeed = 7; // km/h
                    break;
            }
            
            // Adjust MET for terrain
            if (terrain === 'hilly') {
                baseMET += 0.8;
            }
            
            // Adjust for fitness level (more efficient = slightly fewer calories)
            let efficiencyFactor = 1.0;
            switch(fitnessLevel) {
                case 'beginner':
                    efficiencyFactor = 1.05;
                    break;
                case 'intermediate':
                    efficiencyFactor = 1.0;
                    break;
                case 'advanced':
                    efficiencyFactor = 0.95;
                    break;
                case 'athlete':
                    efficiencyFactor = 0.9;
                    break;
            }
            
            // Calculate time in hours
            const timeHours = distanceKm / paceSpeed;
            
            // Calculate calories using MET formula: Calories = MET × weight(kg) × time(hours)
            let calories = baseMET * weightKg * timeHours * efficiencyFactor;
            
            // Adjust for age and gender
            if (age > 50) {
                calories *= 0.95; // Slight reduction for older adults
            }
            if (gender === 'female') {
                calories *= 0.9; // Women typically burn slightly fewer calories
            }
            
            // Round to whole number
            calories = Math.round(calories);
            
            // Determine intensity level
            let intensity = '';
            let intensityClass = '';
            let intensityPercentage = 0;
            
            if (baseMET < 4) {
                intensity = 'Low Intensity';
                intensityClass = 'low-intensity';
                intensityPercentage = 25;
            } else if (baseMET < 5) {
                intensity = 'Moderate Intensity';
                intensityClass = 'moderate-intensity';
                intensityPercentage = 50;
            } else if (baseMET < 6) {
                intensity = 'High Intensity';
                intensityClass = 'high-intensity';
                intensityPercentage = 75;
            } else {
                intensity = 'Very High Intensity';
                intensityClass = 'very-high-intensity';
                intensityPercentage = 90;
            }
            
            // Calculate additional metrics
            const caloriesPerKm = Math.round(calories / distanceKm);
            const timeMinutes = Math.round(timeHours * 60);
            const timeDisplay = `${Math.floor(timeMinutes / 60)}:${(timeMinutes % 60).toString().padStart(2, '0')}`;
            
            // Food equivalents
            const appleEquivalent = (calories / 95).toFixed(1);
            const bananaEquivalent = (calories / 105).toFixed(1);
            const chocolateEquivalent = (calories / 230).toFixed(1);
            const pizzaEquivalent = (calories / 285).toFixed(1);
            
            // Weekly progress
            const weeklyProgress = Math.min(Math.round((calories / 1500) * 100), 100);
            
            // Comparison activities (calories for 30 minutes)
            const yourWalk30min = Math.round(calories * (30 / timeMinutes));
            const runningEquivalent = (240 / yourWalk30min).toFixed(1);
            const cyclingEquivalent = (180 / yourWalk30min).toFixed(1);
            const swimmingEquivalent = (200 / yourWalk30min).toFixed(1);
            
            // Health benefits text
            let benefitsText = '';
            if (calories < 150) {
                benefitsText = 'This light walk provides basic health maintenance benefits. Consider increasing duration or pace for greater cardiovascular benefits.';
            } else if (calories < 300) {
                benefitsText = 'This moderate walk provides good cardiovascular benefits, helps maintain healthy weight, improves mood, and reduces disease risk.';
            } else {
                benefitsText = 'This vigorous walk provides excellent health benefits including significant calorie burn, improved cardiovascular fitness, stronger bones, and reduced risk of chronic diseases.';
            }
            
            // Update UI
            const card = document.getElementById('resultCard');
            card.className = `result-card ${intensityClass}`;
            
            document.getElementById('caloriesBurned').textContent = calories;
            document.getElementById('intensityLevel').textContent = intensity;
            
            document.getElementById('distanceWalked').textContent = unitSystem === 'metric' ? 
                `${distanceKm.toFixed(1)} km` : `${distance.toFixed(1)} mi`;
            document.getElementById('estimatedTime').textContent = timeDisplay;
            document.getElementById('caloriesPerKm').textContent = `${caloriesPerKm} kcal`;
            document.getElementById('metValue').textContent = baseMET.toFixed(1);
            
            document.getElementById('totalCalories').textContent = `${calories} kcal`;
            document.getElementById('paceDisplay').textContent = `${pace.charAt(0).toUpperCase() + pace.slice(1)} (${paceSpeed} km/h)`;
            document.getElementById('terrainDisplay').textContent = terrain === 'flat' ? 'Flat Surface' : 'Hilly Terrain';
            document.getElementById('weightDisplay').textContent = unitSystem === 'metric' ? 
                `${weightKg.toFixed(1)} kg` : `${weight.toFixed(1)} lbs`;
            document.getElementById('intensityDisplay').textContent = intensity.split(' ')[0];
            
            document.getElementById('intensityMeter').style.width = `${intensityPercentage}%`;
            
            document.getElementById('appleEquiv').textContent = `${appleEquivalent} medium`;
            document.getElementById('bananaEquiv').textContent = `${bananaEquivalent} medium`;
            document.getElementById('chocolateEquiv').textContent = `${chocolateEquivalent} bar`;
            document.getElementById('pizzaEquiv').textContent = `${pizzaEquivalent} slice`;
            
            document.getElementById('thisWalk').textContent = `${calories} kcal`;
            document.getElementById('weeklyProgress').textContent = `${weeklyProgress}%`;
            document.getElementById('weeklyProgressBar').style.width = `${weeklyProgress}%`;
            
            document.getElementById('yourWalkCalories').textContent = `${yourWalk30min} kcal`;
            document.getElementById('runningEquivalent').textContent = `${runningEquivalent}x longer`;
            document.getElementById('cyclingEquivalent').textContent = `${cyclingEquivalent}x longer`;
            document.getElementById('swimmingEquivalent').textContent = `${swimmingEquivalent}x longer`;
            
            document.getElementById('benefitsText').textContent = benefitsText;
        }

        window.addEventListener('load', function() {
            calculateCalories();
        });
    </script>
</body>
</html>