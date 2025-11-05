<?php
/**
 * Cycling Calculator
 * File: cycling-calculator.php
 * Description: Calculate cycling speed, pace, distance, time, and calories burned
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cycling Calculator - Speed, Pace, Distance, Time & Calories Burned</title>
    <meta name="description" content="Free cycling calculator. Calculate cycling speed, pace, distance, time, and calories burned. Supports mph, km/h, and various cycling intensities.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🚴 Cycling Calculator</h1>
        <p>Calculate speed, pace, distance & calories</p>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #5568d3;
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
            color: #667eea;
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
            border-color: #667eea;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #888;
            font-size: 0.9em;
        }
        
        .btn {
            background: #667eea;
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
            background: #5568d3;
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
        
        .underweight {
            background: linear-gradient(135deg, #42a5f5 0%, #1976d2 100%);
        }
        
        .normal {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .overweight {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
        }
        
        .obese {
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
            color: #667eea;
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
            color: #667eea;
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
            background: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box strong {
            color: #1976D2;
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
        }
</style>
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Cycling Information</h2>
                <form id="cyclingForm">
                    <div class="form-group">
                        <label for="calculationType">Calculate</label>
                        <select id="calculationType">
                            <option value="speed">Speed (from distance & time)</option>
                            <option value="time">Time (from distance & speed)</option>
                            <option value="distance">Distance (from speed & time)</option>
                            <option value="calories">Calories Burned</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="imperial">Imperial (miles/mph)</option>
                            <option value="metric">Metric (km/km/h)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Ride Details</h3>
                    
                    <div class="form-group" id="distanceGroup">
                        <label for="distance">Distance (<span id="distanceUnit">miles</span>)</label>
                        <input type="number" id="distance" value="20" min="0.1" max="500" step="0.1">
                    </div>
                    
                    <div class="form-group" id="timeGroup">
                        <label for="hours">Time Duration</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="hours" value="1" min="0" max="24" step="1" style="flex: 1;" placeholder="Hours">
                            <input type="number" id="minutes" value="0" min="0" max="59" step="1" style="flex: 1;" placeholder="Minutes">
                            <input type="number" id="seconds" value="0" min="0" max="59" step="1" style="flex: 1;" placeholder="Seconds">
                        </div>
                    </div>
                    
                    <div class="form-group" id="speedGroup">
                        <label for="speed">Average Speed (<span id="speedUnit">mph</span>)</label>
                        <input type="number" id="speed" value="20" min="1" max="60" step="0.1">
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Personal Information</h3>
                    
                    <div class="form-group" id="weightImperialGroup">
                        <label for="weightLbs">Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="180" min="50" max="500" step="0.1">
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="82" min="20" max="250" step="0.1">
                    </div>
                    
                    <div class="form-group">
                        <label for="intensity">Cycling Intensity</label>
                        <select id="intensity">
                            <option value="10">Leisure (&lt;10 mph / &lt;16 km/h)</option>
                            <option value="12">Light (10-12 mph / 16-19 km/h)</option>
                            <option value="14" selected>Moderate (12-14 mph / 19-22 km/h)</option>
                            <option value="16">Vigorous (14-16 mph / 22-26 km/h)</option>
                            <option value="18">Racing (16-19 mph / 26-30 km/h)</option>
                            <option value="20">Elite (&gt;20 mph / &gt;32 km/h)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Cycling Results</h2>
                
                <div class="result-card success">
                    <h3>Average Speed</h3>
                    <div class="amount" id="speedResult">20.0 mph</div>
                    <div style="margin-top: 10px; font-size: 1em;">Average cycling speed</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Speed</h4>
                        <div class="value" id="speedDisplay">20.0 mph</div>
                    </div>
                    <div class="metric-card">
                        <h4>Distance</h4>
                        <div class="value" id="distanceDisplay">20 mi</div>
                    </div>
                    <div class="metric-card">
                        <h4>Time</h4>
                        <div class="value" id="timeDisplay">1:00:00</div>
                    </div>
                    <div class="metric-card">
                        <h4>Calories</h4>
                        <div class="value" id="caloriesDisplay">600</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Ride Summary</h3>
                    <div class="breakdown-item">
                        <span>Distance Covered</span>
                        <strong id="distanceCalc">20.0 miles</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Time</span>
                        <strong id="timeCalc">1 hour 0 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Speed</span>
                        <strong id="speedCalc" style="color: #667eea;">20.0 mph</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pace (Time per mile/km)</span>
                        <strong id="paceCalc">3:00 min/mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Calories Burned</span>
                        <strong id="caloriesCalc" style="color: #f44336;">600 calories</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Speed & Pace Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Speed (mph)</span>
                        <strong id="speedMph">20.0 mph</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Speed (km/h)</span>
                        <strong id="speedKmh">32.2 km/h</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pace (min/mile)</span>
                        <strong id="paceMinMile">3:00 min/mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pace (min/km)</span>
                        <strong id="paceMinKm">1:52 min/km</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Intensity Level</span>
                        <strong id="intensityLevel">Moderate</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Calorie Burn Analysis</h3>
                    <div class="breakdown-item">
                        <span>Total Calories Burned</span>
                        <strong id="totalCals" style="color: #667eea; font-size: 1.1em;">600 calories</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Calories per Hour</span>
                        <strong id="calsPerHour">600 cal/hr</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Calories per Mile</span>
                        <strong id="calsPerMile">30 cal/mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>MET Value</span>
                        <strong id="metValue">8.0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Different Distances at This Speed</h3>
                    <div class="breakdown-item">
                        <span>5 <span id="unit5">miles</span></span>
                        <strong id="time5">15 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>10 <span id="unit10">miles</span></span>
                        <strong id="time10">30 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>20 <span id="unit20">miles</span></span>
                        <strong id="time20">1 hour 0 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>50 <span id="unit50">miles</span></span>
                        <strong id="time50">2 hours 30 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>100 <span id="unit100">miles</span></span>
                        <strong id="time100">5 hours 0 minutes</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Weight Loss Equivalent</h3>
                    <div class="breakdown-item">
                        <span>Fat Burned</span>
                        <strong id="fatBurned">0.17 lbs (77g)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>To Burn 1 lb Fat</span>
                        <strong id="ridesToLoseLb">5.8 rides</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Daily for 1 Week</span>
                        <strong id="weeklyLoss">1.2 lbs/week</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Cycling Speed Categories</h3>
                    <div class="breakdown-item">
                        <span>Leisure Cycling</span>
                        <strong style="color: #4CAF50;">&lt;10 mph (&lt;16 km/h)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Light Effort</span>
                        <strong style="color: #4CAF50;">10-12 mph (16-19 km/h)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Moderate Effort</span>
                        <strong style="color: #FF9800;">12-14 mph (19-22 km/h)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Vigorous Effort</span>
                        <strong style="color: #FF9800;">14-16 mph (22-26 km/h)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Racing</span>
                        <strong style="color: #f44336;">16-19 mph (26-30 km/h)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Elite/Professional</span>
                        <strong style="color: #f44336;">&gt;20 mph (&gt;32 km/h)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Average Cycling Speeds by Experience</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Beginner:</strong> 10-12 mph (16-19 km/h) on flat terrain</p>
                        <p><strong>Recreational:</strong> 12-16 mph (19-26 km/h) on mixed terrain</p>
                        <p><strong>Experienced:</strong> 16-19 mph (26-30 km/h) on road bike</p>
                        <p><strong>Competitive Amateur:</strong> 19-23 mph (30-37 km/h) in group rides</p>
                        <p><strong>Professional:</strong> 23-28 mph (37-45 km/h) in races</p>
                        <p><strong>Tour de France Average:</strong> 25-28 mph (40-45 km/h) in flat stages</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Factors Affecting Cycling Speed</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Terrain:</strong> Hills and mountains significantly reduce average speed</p>
                        <p><strong>Wind:</strong> Headwind slows you down, tailwind speeds you up (up to 5-10 mph difference)</p>
                        <p><strong>Bike Type:</strong> Road bikes are fastest, mountain bikes slowest on pavement</p>
                        <p><strong>Fitness Level:</strong> Better conditioning = higher sustained speeds</p>
                        <p><strong>Drafting:</strong> Riding behind others saves 20-40% energy</p>
                        <p><strong>Weight:</strong> Lighter riders climb faster, heavier riders descend faster</p>
                        <p><strong>Tire Pressure:</strong> Proper inflation reduces rolling resistance</p>
                        <p><strong>Weather:</strong> Temperature, rain, and humidity affect performance</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Cycling MET Values</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>MET (Metabolic Equivalent):</strong> Energy expenditure relative to resting rate</p>
                        <p>• Leisure (&lt;10 mph): 4.0 METs</p>
                        <p>• Light (10-12 mph): 6.0 METs</p>
                        <p>• Moderate (12-14 mph): 8.0 METs</p>
                        <p>• Vigorous (14-16 mph): 10.0 METs</p>
                        <p>• Racing (16-19 mph): 12.0 METs</p>
                        <p>• Elite (&gt;20 mph): 15.8 METs</p>
                        <p><strong>Formula:</strong> Calories = MET × weight(kg) × time(hours)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Training Zones</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Recovery (Zone 1):</strong> &lt;55% max HR, very easy pace</p>
                        <p><strong>Endurance (Zone 2):</strong> 55-75% max HR, conversational pace</p>
                        <p><strong>Tempo (Zone 3):</strong> 75-85% max HR, moderate effort</p>
                        <p><strong>Threshold (Zone 4):</strong> 85-95% max HR, hard effort</p>
                        <p><strong>VO2 Max (Zone 5):</strong> &gt;95% max HR, maximum effort</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Cycling Benefits</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Cardiovascular Health:</strong> Improves heart and lung function</p>
                        <p>&#10003; <strong>Low Impact:</strong> Easy on joints compared to running</p>
                        <p>&#10003; <strong>Burns Calories:</strong> 400-1000+ calories per hour depending on intensity</p>
                        <p>&#10003; <strong>Builds Leg Strength:</strong> Develops quads, hamstrings, glutes, calves</p>
                        <p>&#10003; <strong>Mental Health:</strong> Reduces stress, anxiety, depression</p>
                        <p>&#10003; <strong>Environmentally Friendly:</strong> Zero emissions transportation</p>
                        <p>&#10003; <strong>Social Activity:</strong> Great for group rides and community</p>
                        <p>&#10003; <strong>Improves Balance:</strong> Enhances coordination and stability</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Safety Tips</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#9888; <strong>Always Wear a Helmet:</strong> Reduces head injury risk by 70%</p>
                        <p>&#9888; <strong>Be Visible:</strong> Bright clothing, lights, reflectors</p>
                        <p>&#9888; <strong>Follow Traffic Laws:</strong> Ride with traffic, obey signals</p>
                        <p>&#9888; <strong>Stay Alert:</strong> Watch for cars, pedestrians, road hazards</p>
                        <p>&#9888; <strong>Maintain Your Bike:</strong> Regular maintenance prevents accidents</p>
                        <p>&#9888; <strong>Stay Hydrated:</strong> Drink water before, during, after rides</p>
                        <p>&#9888; <strong>Use Hand Signals:</strong> Communicate intentions to others</p>
                        <p>&#9888; <strong>Ride Predictably:</strong> Avoid sudden movements</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Cycling Tips:</strong> Speed = distance ÷ time. Pace = time ÷ distance. Beginner = 10-12 mph. Recreational = 12-16 mph. Experienced = 16-19 mph. Pro = 23-28 mph. Tour de France avg = 25-28 mph. Drafting saves 20-40% energy. 1 mph = 1.609 km/h. MET values = 4-16 depending on intensity. Calories = MET × weight × time. 1 lb fat = 3,500 cal. Headwind dramatically slows speed. Road bike fastest on pavement. Mountain bike slowest. Proper tire pressure crucial. Always wear helmet. Stay hydrated. Ride with traffic. Use hand signals. Cycling = low impact cardio!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('cyclingForm');
        const typeSelect = document.getElementById('calculationType');
        const unitSelect = document.getElementById('unitSystem');

        typeSelect.addEventListener('change', function() {
            toggleCalculationFields();
            calculate();
        });

        unitSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculate();
        });

        function toggleCalculationFields() {
            const type = typeSelect.value;
            
            document.getElementById('distanceGroup').style.display = type !== 'distance' ? 'block' : 'none';
            document.getElementById('timeGroup').style.display = type !== 'time' ? 'block' : 'none';
            document.getElementById('speedGroup').style.display = type !== 'speed' ? 'block' : 'none';
        }

        function toggleUnitFields() {
            const unit = unitSelect.value;
            const isImperial = unit === 'imperial';
            
            document.getElementById('distanceUnit').textContent = isImperial ? 'miles' : 'km';
            document.getElementById('speedUnit').textContent = isImperial ? 'mph' : 'km/h';
            document.getElementById('weightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('weightMetricGroup').style.display = isImperial ? 'none' : 'block';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculate();
        });

        function calculate() {
            const type = typeSelect.value;
            const unit = unitSelect.value;
            const intensity = parseFloat(document.getElementById('intensity').value) || 14;
            
            // Get weight in kg
            let weightKg;
            if (unit === 'imperial') {
                const weightLbs = parseFloat(document.getElementById('weightLbs').value) || 180;
                weightKg = weightLbs / 2.20462;
            } else {
                weightKg = parseFloat(document.getElementById('weightKg').value) || 82;
            }

            // Get input values
            let distance = parseFloat(document.getElementById('distance').value) || 20;
            const hours = parseInt(document.getElementById('hours').value) || 1;
            const minutes = parseInt(document.getElementById('minutes').value) || 0;
            const seconds = parseInt(document.getElementById('seconds').value) || 0;
            let speed = parseFloat(document.getElementById('speed').value) || 20;
            
            // Convert to miles and mph if metric
            if (unit === 'metric') {
                distance = distance / 1.60934;
                speed = speed / 1.60934;
            }
            
            const totalTimeHours = hours + (minutes / 60) + (seconds / 3600);
            
            // Calculate based on type
            let calculatedSpeed, calculatedDistance, calculatedTime;
            
            if (type === 'speed') {
                calculatedSpeed = distance / totalTimeHours;
                calculatedDistance = distance;
                calculatedTime = totalTimeHours;
            } else if (type === 'time') {
                calculatedSpeed = speed;
                calculatedDistance = distance;
                calculatedTime = distance / speed;
            } else if (type === 'distance') {
                calculatedSpeed = speed;
                calculatedTime = totalTimeHours;
                calculatedDistance = speed * totalTimeHours;
            } else {
                // calories
                calculatedSpeed = speed;
                calculatedDistance = distance;
                calculatedTime = totalTimeHours;
            }

            // Calculate MET value based on speed
            let met;
            if (calculatedSpeed < 10) met = 4.0;
            else if (calculatedSpeed < 12) met = 6.0;
            else if (calculatedSpeed < 14) met = 8.0;
            else if (calculatedSpeed < 16) met = 10.0;
            else if (calculatedSpeed < 20) met = 12.0;
            else met = 15.8;

            // Calculate calories
            const caloriesBurned = met * weightKg * calculatedTime;
            const caloriesPerHour = caloriesBurned / calculatedTime;
            const caloriesPerMile = caloriesBurned / calculatedDistance;

            // Calculate pace (minutes per mile)
            const paceMinutesPerMile = 60 / calculatedSpeed;
            const paceMinutesPerKm = paceMinutesPerMile / 1.60934;

            // Convert to display units
            const displayDistance = unit === 'imperial' ? calculatedDistance : calculatedDistance * 1.60934;
            const displaySpeed = unit === 'imperial' ? calculatedSpeed : calculatedSpeed * 1.60934;
            const unitLabel = unit === 'imperial' ? 'mi' : 'km';
            const speedLabel = unit === 'imperial' ? 'mph' : 'km/h';

            // Format time
            const formatTime = (hours) => {
                const h = Math.floor(hours);
                const m = Math.floor((hours - h) * 60);
                const s = Math.floor(((hours - h) * 60 - m) * 60);
                return `${h}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
            };

            const formatTimeWords = (hours) => {
                const h = Math.floor(hours);
                const m = Math.floor((hours - h) * 60);
                if (h === 0) return `${m} minutes`;
                if (m === 0) return `${h} hour${h > 1 ? 's' : ''}`;
                return `${h} hour${h > 1 ? 's' : ''} ${m} minute${m > 1 ? 's' : ''}`;
            };

            const formatPace = (minutes) => {
                const m = Math.floor(minutes);
                const s = Math.floor((minutes - m) * 60);
                return `${m}:${s.toString().padStart(2, '0')}`;
            };

            // Different distances
            const time5 = unit === 'imperial' ? 5 / calculatedSpeed : 5 / calculatedSpeed;
            const time10 = unit === 'imperial' ? 10 / calculatedSpeed : 10 / calculatedSpeed;
            const time20 = unit === 'imperial' ? 20 / calculatedSpeed : 20 / calculatedSpeed;
            const time50 = unit === 'imperial' ? 50 / calculatedSpeed : 50 / calculatedSpeed;
            const time100 = unit === 'imperial' ? 100 / calculatedSpeed : 100 / calculatedSpeed;

            // Weight loss
            const fatBurnedLbs = caloriesBurned / 3500;
            const fatBurnedGrams = fatBurnedLbs * 453.592;
            const ridesToLoseLb = 3500 / caloriesBurned;
            const weeklyLoss = (caloriesBurned * 7) / 3500;

            // Intensity level
            let intensityName = '';
            if (calculatedSpeed < 10) intensityName = 'Leisure';
            else if (calculatedSpeed < 12) intensityName = 'Light';
            else if (calculatedSpeed < 14) intensityName = 'Moderate';
            else if (calculatedSpeed < 16) intensityName = 'Vigorous';
            else if (calculatedSpeed < 20) intensityName = 'Racing';
            else intensityName = 'Elite';

            // Analysis
            let analysis = `You cycled ${displayDistance.toFixed(1)} ${unitLabel} in ${formatTimeWords(calculatedTime)}, `;
            analysis += `averaging ${displaySpeed.toFixed(1)} ${speedLabel}. `;
            analysis += `Your pace was ${formatPace(unit === 'imperial' ? paceMinutesPerMile : paceMinutesPerKm)} per ${unitLabel}. `;
            analysis += `This is classified as ${intensityName.toLowerCase()} intensity cycling. `;
            analysis += `During this ride, you burned approximately ${Math.round(caloriesBurned)} calories, `;
            analysis += `which equals ${fatBurnedLbs.toFixed(2)} lbs (${fatBurnedGrams.toFixed(0)}g) of body fat. `;
            analysis += `At this intensity (${met} METs), you're burning about ${Math.round(caloriesPerHour)} calories per hour. `;
            if (calculatedSpeed >= 16) {
                analysis += `You're riding at a competitive pace! `;
            } else if (calculatedSpeed >= 12) {
                analysis += `This is a great pace for fitness and endurance building. `;
            } else {
                analysis += `This is a comfortable pace perfect for leisure rides and recovery. `;
            }
            analysis += `If you ride daily at this pace and distance, you could lose ${weeklyLoss.toFixed(2)} lbs per week through cycling alone.`;

            // Update UI
            document.getElementById('speedResult').textContent = `${displaySpeed.toFixed(1)} ${speedLabel}`;
            document.getElementById('speedDisplay').textContent = `${displaySpeed.toFixed(1)} ${speedLabel}`;
            document.getElementById('distanceDisplay').textContent = `${displayDistance.toFixed(1)} ${unitLabel}`;
            document.getElementById('timeDisplay').textContent = formatTime(calculatedTime);
            document.getElementById('caloriesDisplay').textContent = Math.round(caloriesBurned);

            document.getElementById('distanceCalc').textContent = `${displayDistance.toFixed(1)} ${unit === 'imperial' ? 'miles' : 'kilometers'}`;
            document.getElementById('timeCalc').textContent = formatTimeWords(calculatedTime);
            document.getElementById('speedCalc').textContent = `${displaySpeed.toFixed(1)} ${speedLabel}`;
            document.getElementById('paceCalc').textContent = `${formatPace(unit === 'imperial' ? paceMinutesPerMile : paceMinutesPerKm)} min/${unitLabel}`;
            document.getElementById('caloriesCalc').textContent = `${Math.round(caloriesBurned)} calories`;

            document.getElementById('speedMph').textContent = `${(calculatedSpeed).toFixed(1)} mph`;
            document.getElementById('speedKmh').textContent = `${(calculatedSpeed * 1.60934).toFixed(1)} km/h`;
            document.getElementById('paceMinMile').textContent = `${formatPace(paceMinutesPerMile)} min/mile`;
            document.getElementById('paceMinKm').textContent = `${formatPace(paceMinutesPerKm)} min/km`;
            document.getElementById('intensityLevel').textContent = intensityName;

            document.getElementById('totalCals').textContent = `${Math.round(caloriesBurned)} calories`;
            document.getElementById('calsPerHour').textContent = `${Math.round(caloriesPerHour)} cal/hr`;
            document.getElementById('calsPerMile').textContent = `${Math.round(caloriesPerMile)} cal/${unitLabel}`;
            document.getElementById('metValue').textContent = met.toFixed(1);

            document.getElementById('unit5').textContent = unitLabel;
            document.getElementById('unit10').textContent = unitLabel;
            document.getElementById('unit20').textContent = unitLabel;
            document.getElementById('unit50').textContent = unitLabel;
            document.getElementById('unit100').textContent = unitLabel;
            document.getElementById('time5').textContent = formatTimeWords(time5);
            document.getElementById('time10').textContent = formatTimeWords(time10);
            document.getElementById('time20').textContent = formatTimeWords(time20);
            document.getElementById('time50').textContent = formatTimeWords(time50);
            document.getElementById('time100').textContent = formatTimeWords(time100);

            document.getElementById('fatBurned').textContent = `${fatBurnedLbs.toFixed(2)} lbs (${fatBurnedGrams.toFixed(0)}g)`;
            document.getElementById('ridesToLoseLb').textContent = `${ridesToLoseLb.toFixed(1)} rides`;
            document.getElementById('weeklyLoss').textContent = `${weeklyLoss.toFixed(2)} lbs/week`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleCalculationFields();
            toggleUnitFields();
            calculate();
        });
    </script>
</body>
</html>