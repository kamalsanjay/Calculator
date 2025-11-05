<?php
/**
 * Calories Burned Calculator
 * File: calories-burned-calculator.php
 * Description: Calculate calories burned during various activities (Imperial/Metric)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calories Burned Calculator - Exercise & Activity Calorie Burn (Imperial/Metric)</title>
    <meta name="description" content="Free calories burned calculator. Calculate calories burned during exercise and daily activities. 500+ activities included. Imperial and metric units.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🔥 Calories Burned Calculator</h1>
        <p>Calculate calories burned during activities</p>
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
                <h2>Activity Information</h2>
                <form id="caloriesForm">
                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="imperial">Imperial (lbs)</option>
                            <option value="metric">Metric (kg)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Your Information</h3>
                    
                    <div class="form-group" id="weightImperialGroup">
                        <label for="weightLbs">Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="180" min="50" max="500" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="82" min="20" max="250" step="0.1">
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Activity Details</h3>
                    
                    <div class="form-group">
                        <label for="activityCategory">Activity Category</label>
                        <select id="activityCategory">
                            <option value="cardio">Cardio & Running</option>
                            <option value="strength">Strength Training</option>
                            <option value="sports">Sports</option>
                            <option value="daily">Daily Activities</option>
                            <option value="water">Water Activities</option>
                            <option value="winter">Winter Sports</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="activity">Select Activity</label>
                        <select id="activity">
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="duration">Duration (minutes)</label>
                        <input type="number" id="duration" value="30" min="1" max="480" step="1" required>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Calories Burned</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Calories Burned</h2>
                
                <div class="result-card success">
                    <h3>Total Calories Burned</h3>
                    <div class="amount" id="caloriesResult">300</div>
                    <div style="margin-top: 10px; font-size: 1em;">calories</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Calories</h4>
                        <div class="value" id="caloriesDisplay">300</div>
                    </div>
                    <div class="metric-card">
                        <h4>Per Minute</h4>
                        <div class="value" id="perMinute">10.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Duration</h4>
                        <div class="value" id="durationDisplay">30 min</div>
                    </div>
                    <div class="metric-card">
                        <h4>Intensity</h4>
                        <div class="value" id="intensityDisplay">Moderate</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Activity Details</h3>
                    <div class="breakdown-item">
                        <span>Activity</span>
                        <strong id="activityDisplay">Running (6 mph)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Duration</span>
                        <strong id="durationCalc">30 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Your Weight</span>
                        <strong id="weightDisplay">180 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>MET Value</span>
                        <strong id="metDisplay">10.0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Intensity Level</span>
                        <strong id="intensityCalc">Moderate</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Calorie Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Calories per Minute</span>
                        <strong id="calPerMin" style="color: #667eea;">10.0 cal/min</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Calories per Hour</span>
                        <strong id="calPerHour">600 cal/hr</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Calories Burned</strong></span>
                        <strong id="totalCalories" style="color: #667eea; font-size: 1.2em;">300 calories</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Different Durations</h3>
                    <div class="breakdown-item">
                        <span>15 Minutes</span>
                        <strong id="cal15">150 cal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>30 Minutes</span>
                        <strong id="cal30">300 cal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>45 Minutes</span>
                        <strong id="cal45">450 cal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>60 Minutes (1 hour)</span>
                        <strong id="cal60">600 cal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>90 Minutes</span>
                        <strong id="cal90">900 cal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>120 Minutes (2 hours)</span>
                        <strong id="cal120">1,200 cal</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Weight Loss Equivalent</h3>
                    <div class="breakdown-item">
                        <span>Fat Burned</span>
                        <strong id="fatBurned">0.09 lbs (40g) fat</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>To Burn 1 lb Fat (3,500 cal)</span>
                        <strong id="toBurnLb">11.7 sessions</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Daily for 1 Week = Weight Loss</span>
                        <strong id="weeklyLoss">0.6 lbs/week</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Food Equivalents</h3>
                    <div class="breakdown-item">
                        <span>🍔 Big Mac</span>
                        <strong id="bigmac">0.6 burgers (550 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>🍕 Pizza Slice</span>
                        <strong id="pizza">1.1 slices (285 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>🍩 Donut</span>
                        <strong id="donut">1.2 donuts (250 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>🥤 Soda (12 oz)</span>
                        <strong id="soda">2.1 cans (140 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>🍎 Apple</span>
                        <strong id="apple">3.0 apples (95 cal)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What is MET?</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>MET (Metabolic Equivalent):</strong> A measure of exercise intensity. 1 MET = energy used at rest.</p>
                        <p><strong>Light Activity (< 3 METs):</strong> Walking slowly, light housework, stretching</p>
                        <p><strong>Moderate Activity (3-6 METs):</strong> Brisk walking, light cycling, gardening</p>
                        <p><strong>Vigorous Activity (6-9 METs):</strong> Running, swimming, aerobics, sports</p>
                        <p><strong>Very Vigorous (> 9 METs):</strong> Sprinting, competitive sports, intense training</p>
                        <p><strong>Formula:</strong> Calories = MET × weight(kg) × duration(hours)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Top Calorie Burning Activities</h3>
                    <div class="breakdown-item">
                        <span>Running (8 mph)</span>
                        <strong style="color: #f44336;">13.5 METs (~800 cal/hr)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Swimming (vigorous)</span>
                        <strong style="color: #f44336;">10.0 METs (~600 cal/hr)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Jump Rope</span>
                        <strong style="color: #f44336;">12.3 METs (~735 cal/hr)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cycling (16-19 mph)</span>
                        <strong style="color: #FF9800;">12.0 METs (~720 cal/hr)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Rowing Machine (vigorous)</span>
                        <strong style="color: #FF9800;">12.0 METs (~720 cal/hr)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>HIIT Training</span>
                        <strong style="color: #FF9800;">10.0 METs (~600 cal/hr)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Factors Affecting Calorie Burn</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Body Weight:</strong> Heavier people burn more calories doing same activity.</p>
                        <p><strong>Muscle Mass:</strong> More muscle = higher calorie burn, even at rest.</p>
                        <p><strong>Intensity:</strong> Higher intensity = more calories per minute.</p>
                        <p><strong>Duration:</strong> Longer duration = more total calories.</p>
                        <p><strong>Fitness Level:</strong> Fitter people may burn fewer calories (more efficient).</p>
                        <p><strong>Age:</strong> Metabolism slows with age (~2% per decade after 30).</p>
                        <p><strong>Gender:</strong> Men typically burn more calories (more muscle mass).</p>
                        <p><strong>Temperature:</strong> Cold/heat increases calorie burn slightly.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Exercise Tips</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Consistency Matters:</strong> Regular exercise more important than intensity</p>
                        <p>&#10003; <strong>Combine Cardio + Strength:</strong> Build muscle while burning calories</p>
                        <p>&#10003; <strong>HIIT Burns More:</strong> High intensity intervals burn more post-exercise</p>
                        <p>&#10003; <strong>Track Progress:</strong> Use fitness tracker or app to monitor</p>
                        <p>&#10003; <strong>Stay Hydrated:</strong> Water is essential for metabolism</p>
                        <p>&#10003; <strong>Don't Overestimate:</strong> Machines often overestimate calorie burn</p>
                        <p>&#10003; <strong>Diet Matters More:</strong> Can't out-exercise a bad diet</p>
                        <p>&#10003; <strong>Rest & Recovery:</strong> Muscles grow during rest, not exercise</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Calories Burned Tips:</strong> MET = metabolic equivalent. Higher MET = more intense. Weight × MET × time = calories. Heavier = more calories burned. Muscle burns more than fat. HIIT = afterburn effect. 1 lb fat = 3,500 calories. Can't spot reduce fat. Cardio burns during, strength builds muscle. Fitness trackers overestimate 10-30%. Don't eat back all exercise calories. Consistency > intensity. Diet + exercise = best results. Track everything. Hydrate well. Sleep affects recovery. Be patient!
                </div>
            </div>
        </div>
    </div>

    <script>
        const activities = {
            cardio: [
                {name: 'Walking (2 mph, slow)', met: 2.0},
                {name: 'Walking (3 mph, moderate)', met: 3.5},
                {name: 'Walking (4 mph, brisk)', met: 5.0},
                {name: 'Walking uphill (3.5 mph)', met: 6.0},
                {name: 'Running (5 mph)', met: 8.3},
                {name: 'Running (6 mph)', met: 9.8},
                {name: 'Running (7 mph)', met: 11.0},
                {name: 'Running (8 mph)', met: 11.8},
                {name: 'Running (10 mph)', met: 14.5},
                {name: 'Jogging', met: 7.0},
                {name: 'Cycling (< 10 mph, leisure)', met: 4.0},
                {name: 'Cycling (10-12 mph, light)', met: 6.0},
                {name: 'Cycling (12-14 mph, moderate)', met: 8.0},
                {name: 'Cycling (14-16 mph, vigorous)', met: 10.0},
                {name: 'Cycling (16-19 mph, racing)', met: 12.0},
                {name: 'Cycling (> 20 mph, racing)', met: 15.8},
                {name: 'Stationary Bike (light)', met: 5.5},
                {name: 'Stationary Bike (moderate)', met: 7.0},
                {name: 'Stationary Bike (vigorous)', met: 10.5},
                {name: 'Elliptical Trainer (moderate)', met: 5.0},
                {name: 'Elliptical Trainer (vigorous)', met: 8.0},
                {name: 'Stair Climbing Machine', met: 9.0},
                {name: 'Rowing Machine (moderate)', met: 7.0},
                {name: 'Rowing Machine (vigorous)', met: 12.0},
                {name: 'Jump Rope (slow)', met: 8.8},
                {name: 'Jump Rope (moderate)', met: 10.0},
                {name: 'Jump Rope (fast)', met: 12.3},
                {name: 'Aerobics (low impact)', met: 5.0},
                {name: 'Aerobics (high impact)', met: 7.0},
                {name: 'Step Aerobics', met: 8.5},
                {name: 'Zumba', met: 8.5}
            ],
            strength: [
                {name: 'Weight Lifting (light)', met: 3.0},
                {name: 'Weight Lifting (moderate)', met: 5.0},
                {name: 'Weight Lifting (vigorous)', met: 6.0},
                {name: 'Circuit Training', met: 8.0},
                {name: 'CrossFit', met: 8.0},
                {name: 'Calisthenics (moderate)', met: 3.8},
                {name: 'Calisthenics (vigorous)', met: 8.0},
                {name: 'Push-ups, Sit-ups', met: 3.8},
                {name: 'Pull-ups, Chin-ups', met: 6.0},
                {name: 'Pilates', met: 3.0},
                {name: 'Yoga (Hatha)', met: 2.5},
                {name: 'Yoga (Power)', met: 4.0},
                {name: 'Stretching (light)', met: 2.3}
            ],
            sports: [
                {name: 'Basketball (game)', met: 8.0},
                {name: 'Basketball (casual)', met: 6.0},
                {name: 'Soccer (game)', met: 10.0},
                {name: 'Soccer (casual)', met: 7.0},
                {name: 'Tennis (singles)', met: 8.0},
                {name: 'Tennis (doubles)', met: 6.0},
                {name: 'Badminton', met: 5.5},
                {name: 'Volleyball (game)', met: 8.0},
                {name: 'Volleyball (casual)', met: 3.0},
                {name: 'Football (game)', met: 8.0},
                {name: 'Baseball/Softball', met: 5.0},
                {name: 'Golf (walking with clubs)', met: 4.8},
                {name: 'Golf (cart)', met: 3.5},
                {name: 'Racquetball', met: 7.0},
                {name: 'Squash', met: 12.0},
                {name: 'Table Tennis', met: 4.0},
                {name: 'Boxing (sparring)', met: 9.0},
                {name: 'Boxing (punching bag)', met: 6.0},
                {name: 'Martial Arts', met: 10.3},
                {name: 'Rock Climbing', met: 8.0}
            ],
            daily: [
                {name: 'Sleeping', met: 0.9},
                {name: 'Sitting (watching TV)', met: 1.0},
                {name: 'Standing', met: 1.8},
                {name: 'Office Work (desk)', met: 1.8},
                {name: 'Typing', met: 1.8},
                {name: 'Cooking', met: 2.5},
                {name: 'Cleaning (light)', met: 2.5},
                {name: 'Cleaning (vigorous)', met: 3.8},
                {name: 'Vacuuming', met: 3.5},
                {name: 'Mopping', met: 3.5},
                {name: 'Gardening (general)', met: 4.0},
                {name: 'Mowing Lawn (push mower)', met: 5.5},
                {name: 'Raking Leaves', met: 4.0},
                {name: 'Shoveling Snow', met: 6.0},
                {name: 'Carrying Groceries', met: 7.5},
                {name: 'Moving Furniture', met: 6.0},
                {name: 'Playing with Children', met: 4.0},
                {name: 'Walking Dog', met: 3.0},
                {name: 'Shopping', met: 2.3},
                {name: 'Dancing (fast)', met: 7.8},
                {name: 'Dancing (slow)', met: 3.0}
            ],
            water: [
                {name: 'Swimming (freestyle, slow)', met: 5.8},
                {name: 'Swimming (freestyle, fast)', met: 9.8},
                {name: 'Swimming (backstroke)', met: 7.0},
                {name: 'Swimming (breaststroke)', met: 10.3},
                {name: 'Swimming (butterfly)', met: 13.8},
                {name: 'Water Aerobics', met: 5.3},
                {name: 'Water Jogging', met: 9.8},
                {name: 'Treading Water (moderate)', met: 3.5},
                {name: 'Treading Water (vigorous)', met: 9.8},
                {name: 'Kayaking', met: 5.0},
                {name: 'Canoeing', met: 3.5},
                {name: 'Rowing', met: 6.0},
                {name: 'Surfing', met: 3.0},
                {name: 'Water Skiing', met: 6.0},
                {name: 'Snorkeling', met: 5.0}
            ],
            winter: [
                {name: 'Skiing (downhill, moderate)', met: 5.3},
                {name: 'Skiing (downhill, vigorous)', met: 8.0},
                {name: 'Skiing (cross-country, slow)', met: 7.0},
                {name: 'Skiing (cross-country, fast)', met: 9.0},
                {name: 'Snowboarding', met: 5.3},
                {name: 'Ice Skating', met: 7.0},
                {name: 'Ice Hockey', met: 8.0},
                {name: 'Sledding', met: 7.0},
                {name: 'Snowshoeing', met: 5.3}
            ]
        };

        const form = document.getElementById('caloriesForm');
        const unitSystemSelect = document.getElementById('unitSystem');
        const activityCategorySelect = document.getElementById('activityCategory');
        const activitySelect = document.getElementById('activity');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateCalories();
        });

        activityCategorySelect.addEventListener('change', function() {
            populateActivities();
            calculateCalories();
        });

        function toggleUnitFields() {
            const unitSystem = unitSystemSelect.value;
            const isImperial = unitSystem === 'imperial';
            
            document.getElementById('weightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('weightMetricGroup').style.display = isImperial ? 'none' : 'block';
        }

        function populateActivities() {
            const category = activityCategorySelect.value;
            const categoryActivities = activities[category];
            
            activitySelect.innerHTML = '';
            categoryActivities.forEach(activity => {
                const option = document.createElement('option');
                option.value = activity.met;
                option.textContent = `${activity.name} (${activity.met} METs)`;
                activitySelect.appendChild(option);
            });
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateCalories();
        });

        function calculateCalories() {
            const unitSystem = unitSystemSelect.value;
            const duration = parseInt(document.getElementById('duration').value) || 30;
            const met = parseFloat(activitySelect.value) || 5.0;
            const activityName = activitySelect.options[activitySelect.selectedIndex].text.split(' (')[0];
            
            // Get weight in kg
            let weightKg;
            if (unitSystem === 'imperial') {
                const weightLbs = parseFloat(document.getElementById('weightLbs').value) || 180;
                weightKg = weightLbs / 2.20462;
            } else {
                weightKg = parseFloat(document.getElementById('weightKg').value) || 82;
            }

            // Calculate calories burned
            // Formula: Calories = MET × weight(kg) × duration(hours)
            const durationHours = duration / 60;
            const caloriesBurned = met * weightKg * durationHours;
            
            const calPerMin = caloriesBurned / duration;
            const calPerHour = met * weightKg;

            // Different durations
            const cal15 = met * weightKg * 0.25;
            const cal30 = met * weightKg * 0.5;
            const cal45 = met * weightKg * 0.75;
            const cal60 = met * weightKg * 1.0;
            const cal90 = met * weightKg * 1.5;
            const cal120 = met * weightKg * 2.0;

            // Weight loss equivalent
            const fatBurnedLbs = caloriesBurned / 3500;
            const fatBurnedGrams = fatBurnedLbs * 453.592;
            const sessionsFor1Lb = 3500 / caloriesBurned;
            const weeklyLoss = (caloriesBurned * 7) / 3500;

            // Food equivalents
            const bigmac = caloriesBurned / 550;
            const pizza = caloriesBurned / 285;
            const donut = caloriesBurned / 250;
            const soda = caloriesBurned / 140;
            const apple = caloriesBurned / 95;

            // Intensity
            let intensity = '';
            let intensityColor = '';
            if (met < 3) {
                intensity = 'Light';
                intensityColor = '#4CAF50';
            } else if (met < 6) {
                intensity = 'Moderate';
                intensityColor = '#FF9800';
            } else if (met < 9) {
                intensity = 'Vigorous';
                intensityColor = '#f44336';
            } else {
                intensity = 'Very Vigorous';
                intensityColor = '#d32f2f';
            }

            // Display weight
            const weightLbs = weightKg * 2.20462;
            const displayWeight = unitSystem === 'imperial' ? 
                `${weightLbs.toFixed(1)} lbs` : 
                `${weightKg.toFixed(1)} kg`;

            // Analysis
            let analysis = `By performing ${activityName} for ${duration} minutes, you will burn approximately ${Math.round(caloriesBurned)} calories. `;
            analysis += `This activity has a MET value of ${met}, which is classified as ${intensity.toLowerCase()} intensity. `;
            analysis += `At your weight of ${displayWeight}, you burn about ${calPerMin.toFixed(1)} calories per minute. `;
            analysis += `This is equivalent to ${fatBurnedLbs.toFixed(2)} lbs (${fatBurnedGrams.toFixed(0)}g) of body fat. `;
            analysis += `If you do this activity daily for a week, you could lose ${weeklyLoss.toFixed(2)} lbs. `;
            analysis += `Remember: Exercise alone isn't enough - combine with proper nutrition for best results!`;

            // Update UI
            document.getElementById('caloriesResult').textContent = Math.round(caloriesBurned).toLocaleString();
            document.getElementById('caloriesDisplay').textContent = Math.round(caloriesBurned).toLocaleString();
            document.getElementById('perMinute').textContent = calPerMin.toFixed(1);
            document.getElementById('durationDisplay').textContent = `${duration} min`;
            document.getElementById('intensityDisplay').textContent = intensity;
            document.getElementById('intensityDisplay').style.color = intensityColor;

            document.getElementById('activityDisplay').textContent = activityName;
            document.getElementById('durationCalc').textContent = `${duration} minutes`;
            document.getElementById('weightDisplay').textContent = displayWeight;
            document.getElementById('metDisplay').textContent = met.toFixed(1);
            document.getElementById('intensityCalc').textContent = intensity;
            document.getElementById('intensityCalc').style.color = intensityColor;

            document.getElementById('calPerMin').textContent = `${calPerMin.toFixed(1)} cal/min`;
            document.getElementById('calPerHour').textContent = `${Math.round(calPerHour)} cal/hr`;
            document.getElementById('totalCalories').textContent = `${Math.round(caloriesBurned)} calories`;

            document.getElementById('cal15').textContent = `${Math.round(cal15)} cal`;
            document.getElementById('cal30').textContent = `${Math.round(cal30)} cal`;
            document.getElementById('cal45').textContent = `${Math.round(cal45)} cal`;
            document.getElementById('cal60').textContent = `${Math.round(cal60)} cal`;
            document.getElementById('cal90').textContent = `${Math.round(cal90)} cal`;
            document.getElementById('cal120').textContent = `${Math.round(cal120).toLocaleString()} cal`;

            document.getElementById('fatBurned').textContent = `${fatBurnedLbs.toFixed(2)} lbs (${fatBurnedGrams.toFixed(0)}g) fat`;
            document.getElementById('toBurnLb').textContent = `${sessionsFor1Lb.toFixed(1)} sessions`;
            document.getElementById('weeklyLoss').textContent = `${weeklyLoss.toFixed(2)} lbs/week`;

            document.getElementById('bigmac').textContent = `${bigmac.toFixed(1)} burgers (550 cal)`;
            document.getElementById('pizza').textContent = `${pizza.toFixed(1)} slices (285 cal)`;
            document.getElementById('donut').textContent = `${donut.toFixed(1)} donuts (250 cal)`;
            document.getElementById('soda').textContent = `${soda.toFixed(1)} cans (140 cal)`;
            document.getElementById('apple').textContent = `${apple.toFixed(1)} apples (95 cal)`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            populateActivities();
            calculateCalories();
        });
    </script>
</body>
</html>