<?php
/**
 * BMR Calculator
 * File: bmr-calculator.php
 * Description: Calculate Basal Metabolic Rate using multiple formulas (Imperial/Metric)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMR Calculator - Basal Metabolic Rate (Imperial/Metric)</title>
    <meta name="description" content="Free BMR calculator. Calculate Basal Metabolic Rate using Mifflin-St Jeor, Harris-Benedict, and Katch-McArdle formulas. Supports imperial and metric units.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128293; BMR Calculator</h1>
        <p>Calculate Basal Metabolic Rate</p>
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
                <h2>Your Information</h2>
                <form id="bmrForm">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="imperial">Imperial (lbs/inches)</option>
                            <option value="metric">Metric (kg/cm)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Basic Measurements</h3>
                    
                    <div class="form-group">
                        <label for="age">Age (years)</label>
                        <input type="number" id="age" value="30" min="15" max="100" step="1" required>
                    </div>
                    
                    <div class="form-group" id="heightImperialGroup">
                        <label for="heightFeet">Height</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="heightFeet" value="5" min="3" max="8" step="1" style="flex: 1;" placeholder="Feet">
                            <input type="number" id="heightInches" value="10" min="0" max="11" step="1" style="flex: 1;" placeholder="Inches">
                        </div>
                    </div>

                    <div class="form-group" id="heightMetricGroup" style="display: none;">
                        <label for="heightCm">Height (cm)</label>
                        <input type="number" id="heightCm" value="178" min="100" max="250" step="0.1">
                    </div>
                    
                    <div class="form-group" id="weightImperialGroup">
                        <label for="weightLbs">Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="180" min="50" max="500" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="82" min="20" max="250" step="0.1">
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Optional (For Katch-McArdle)</h3>
                    
                    <div class="form-group">
                        <label for="bodyFat">Body Fat Percentage (%)</label>
                        <input type="number" id="bodyFat" value="0" min="0" max="50" step="0.1">
                        <small>Optional - more accurate if known</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="activityLevel">Activity Level</label>
                        <select id="activityLevel">
                            <option value="1.2">Sedentary (little/no exercise)</option>
                            <option value="1.375">Light (exercise 1-3 days/week)</option>
                            <option value="1.55" selected>Moderate (exercise 3-5 days/week)</option>
                            <option value="1.725">Active (exercise 6-7 days/week)</option>
                            <option value="1.9">Very Active (intense exercise daily)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate BMR</button>
                </form>
            </div>

            <div class="results-section">
                <h2>BMR Results</h2>
                
                <div class="result-card success">
                    <h3>Your BMR (Mifflin-St Jeor)</h3>
                    <div class="amount" id="bmrResult">1,800</div>
                    <div style="margin-top: 10px; font-size: 1em;">calories per day</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>BMR</h4>
                        <div class="value" id="bmrDisplay">1,800</div>
                    </div>
                    <div class="metric-card">
                        <h4>TDEE</h4>
                        <div class="value" id="tdeeDisplay">2,790</div>
                    </div>
                    <div class="metric-card">
                        <h4>Activity</h4>
                        <div class="value" id="activityDisplay">Moderate</div>
                    </div>
                    <div class="metric-card">
                        <h4>Daily Calories</h4>
                        <div class="value" id="dailyCalories">2,790</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Information</h3>
                    <div class="breakdown-item">
                        <span>Gender</span>
                        <strong id="genderDisplay">Male</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Age</span>
                        <strong id="ageDisplay">30 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Height</span>
                        <strong id="heightDisplay">5'10"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight</span>
                        <strong id="weightDisplay">180 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Activity Level</span>
                        <strong id="activityLevelDisplay">Moderate</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>BMR Calculations (Different Formulas)</h3>
                    <div class="breakdown-item">
                        <span>Mifflin-St Jeor (Recommended)</span>
                        <strong id="mifflinBMR" style="color: #667eea; font-size: 1.1em;">1,800 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Harris-Benedict (Revised)</span>
                        <strong id="harrisBMR">1,800 cal/day</strong>
                    </div>
                    <div class="breakdown-item" id="katchItem">
                        <span>Katch-McArdle (Lean Mass)</span>
                        <strong id="katchBMR">1,800 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average BMR</span>
                        <strong id="averageBMR">1,800 cal/day</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Daily Energy Expenditure (TDEE)</h3>
                    <div class="breakdown-item">
                        <span>BMR (Resting)</span>
                        <strong id="bmrTdee" style="color: #667eea;">1,800 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Activity Multiplier</span>
                        <strong id="activityMultiplier">1.55x</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>TDEE (Total Daily Calories)</strong></span>
                        <strong id="tdeeFinal" style="color: #667eea; font-size: 1.2em;">2,790 cal/day</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Calorie Goals for Different Objectives</h3>
                    <div class="breakdown-item">
                        <span>Extreme Weight Loss (-1000 cal)</span>
                        <strong id="extremeLoss" style="color: #f44336;">1,790 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight Loss (-500 cal)</span>
                        <strong id="weightLoss" style="color: #FF9800;">2,290 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mild Weight Loss (-250 cal)</span>
                        <strong id="mildLoss" style="color: #FF9800;">2,540 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Maintain Weight</span>
                        <strong id="maintain" style="color: #4CAF50;">2,790 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mild Weight Gain (+250 cal)</span>
                        <strong id="mildGain" style="color: #2196F3;">3,040 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight Gain (+500 cal)</span>
                        <strong id="weightGain" style="color: #2196F3;">3,290 cal/day</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Macronutrient Breakdown (Balanced Diet)</h3>
                    <div class="breakdown-item">
                        <span>Protein (30%)</span>
                        <strong id="protein">209g per day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Carbohydrates (40%)</span>
                        <strong id="carbs">279g per day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fats (30%)</span>
                        <strong id="fats">93g per day</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding BMR</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>BMR (Basal Metabolic Rate):</strong> Calories your body burns at complete rest to maintain vital functions (breathing, circulation, cell production).</p>
                        <p><strong>TDEE (Total Daily Energy Expenditure):</strong> BMR + calories burned through daily activities and exercise.</p>
                        <p><strong>Why BMR Matters:</strong> Understanding BMR helps you create accurate calorie deficits/surpluses for weight goals.</p>
                        <p><strong>Never Eat Below BMR:</strong> Eating significantly below BMR can slow metabolism and cause muscle loss.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>BMR Formula Comparison</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Mifflin-St Jeor (1990):</strong> Most accurate for general population. Recommended by nutrition professionals. Uses weight, height, age, gender.</p>
                        <p><strong>Harris-Benedict (Revised 1984):</strong> Older but reliable. Tends to overestimate slightly. Good alternative formula.</p>
                        <p><strong>Katch-McArdle:</strong> Most accurate IF you know body fat %. Based on lean body mass. Gender-neutral. Best for athletes.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Activity Level Descriptions</h3>
                    <div class="breakdown-item">
                        <span>Sedentary (1.2x)</span>
                        <strong>Desk job, little/no exercise</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Light (1.375x)</span>
                        <strong>Light exercise 1-3 days/week</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Moderate (1.55x)</span>
                        <strong>Moderate exercise 3-5 days/week</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Active (1.725x)</span>
                        <strong>Heavy exercise 6-7 days/week</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Very Active (1.9x)</span>
                        <strong>Very intense exercise, physical job</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Factors Affecting BMR</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#9650; <strong>Increases BMR:</strong> More muscle mass, larger body size, male gender, younger age, fever, pregnancy, hyperthyroidism</p>
                        <p>&#9660; <strong>Decreases BMR:</strong> More body fat, female gender, older age, starvation/fasting, hypothyroidism, severe calorie restriction</p>
                        <p><strong>Genetics:</strong> BMR can vary 20-30% between individuals of same size</p>
                        <p><strong>Muscle vs Fat:</strong> Muscle burns 6 cal/lb/day, fat burns 2 cal/lb/day</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How to Use Your BMR</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>For Weight Loss:</strong> Eat 500 cal below TDEE = lose 1 lb/week. Max deficit = 1000 cal/day (2 lbs/week).</p>
                        <p><strong>For Weight Gain:</strong> Eat 500 cal above TDEE = gain 1 lb/week (mostly muscle with proper training).</p>
                        <p><strong>For Maintenance:</strong> Eat at TDEE level. Monitor weight weekly and adjust if needed.</p>
                        <p><strong>Safe Minimums:</strong> Men: 1500 cal/day, Women: 1200 cal/day. Never go below BMR long-term.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tips to Boost Metabolism</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Build Muscle:</strong> Strength training increases lean mass and BMR</p>
                        <p>&#10003; <strong>Eat Protein:</strong> Higher thermic effect than carbs/fats (20-30% vs 5-10%)</p>
                        <p>&#10003; <strong>Stay Active:</strong> NEAT (non-exercise activity) burns significant calories</p>
                        <p>&#10003; <strong>Don't Starve:</strong> Severe restriction lowers BMR (metabolic adaptation)</p>
                        <p>&#10003; <strong>Drink Water:</strong> Cold water may temporarily increase metabolism</p>
                        <p>&#10003; <strong>Sleep Well:</strong> Poor sleep decreases BMR and increases hunger</p>
                        <p>&#10003; <strong>Manage Stress:</strong> Chronic stress (cortisol) can affect metabolism</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>BMR Tips:</strong> BMR = calories at complete rest. TDEE = BMR × activity level. Mifflin-St Jeor = most accurate formula. 1 lb fat = 3,500 calories. 500 cal deficit = 1 lb loss/week. Never eat below BMR long-term. Build muscle to increase BMR. Age decreases BMR ~2% per decade. Men have 5-10% higher BMR than women. Muscle burns more than fat. Protein has highest thermic effect. Crash diets slow metabolism. Track calories consistently. Adjust based on weekly progress. Be patient - sustainable changes work best!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('bmrForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateBMR();
        });

        function toggleUnitFields() {
            const unitSystem = unitSystemSelect.value;
            const isImperial = unitSystem === 'imperial';
            
            document.getElementById('heightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('heightMetricGroup').style.display = isImperial ? 'none' : 'block';
            document.getElementById('weightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('weightMetricGroup').style.display = isImperial ? 'none' : 'block';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBMR();
        });

        function calculateBMR() {
            const gender = document.getElementById('gender').value;
            const age = parseInt(document.getElementById('age').value) || 30;
            const bodyFat = parseFloat(document.getElementById('bodyFat').value) || 0;
            const activityLevel = parseFloat(document.getElementById('activityLevel').value) || 1.55;
            const unitSystem = unitSystemSelect.value;
            
            // Get measurements
            let heightCm, weightKg;
            
            if (unitSystem === 'imperial') {
                const feet = parseFloat(document.getElementById('heightFeet').value) || 0;
                const inches = parseFloat(document.getElementById('heightInches').value) || 0;
                const heightInches = (feet * 12) + inches;
                heightCm = heightInches * 2.54;
                const weightLbs = parseFloat(document.getElementById('weightLbs').value) || 0;
                weightKg = weightLbs / 2.20462;
            } else {
                heightCm = parseFloat(document.getElementById('heightCm').value) || 0;
                weightKg = parseFloat(document.getElementById('weightKg').value) || 0;
            }

            // Calculate BMR using different formulas
            
            // Mifflin-St Jeor (Most accurate)
            let mifflinBMR;
            if (gender === 'male') {
                mifflinBMR = (10 * weightKg) + (6.25 * heightCm) - (5 * age) + 5;
            } else {
                mifflinBMR = (10 * weightKg) + (6.25 * heightCm) - (5 * age) - 161;
            }

            // Harris-Benedict (Revised)
            let harrisBMR;
            if (gender === 'male') {
                harrisBMR = 88.362 + (13.397 * weightKg) + (4.799 * heightCm) - (5.677 * age);
            } else {
                harrisBMR = 447.593 + (9.247 * weightKg) + (3.098 * heightCm) - (4.330 * age);
            }

            // Katch-McArdle (Lean body mass)
            let katchBMR = 0;
            if (bodyFat > 0) {
                const leanMass = weightKg * (1 - bodyFat / 100);
                katchBMR = 370 + (21.6 * leanMass);
                document.getElementById('katchItem').style.display = 'flex';
            } else {
                document.getElementById('katchItem').style.display = 'none';
            }

            // Average BMR
            const averageBMR = bodyFat > 0 ? 
                (mifflinBMR + harrisBMR + katchBMR) / 3 : 
                (mifflinBMR + harrisBMR) / 2;

            // Calculate TDEE
            const tdee = mifflinBMR * activityLevel;

            // Calorie goals
            const extremeLoss = Math.max(mifflinBMR, tdee - 1000);
            const weightLoss = tdee - 500;
            const mildLoss = tdee - 250;
            const maintain = tdee;
            const mildGain = tdee + 250;
            const weightGain = tdee + 500;

            // Macros (for maintenance)
            const protein = (maintain * 0.30) / 4; // 4 cal per gram
            const carbs = (maintain * 0.40) / 4;
            const fats = (maintain * 0.30) / 9; // 9 cal per gram

            // Activity level names
            const activityNames = {
                '1.2': 'Sedentary',
                '1.375': 'Light',
                '1.55': 'Moderate',
                '1.725': 'Active',
                '1.9': 'Very Active'
            };

            // Display measurements
            const heightInches = heightCm / 2.54;
            const weightLbs = weightKg * 2.20462;
            const displayHeight = unitSystem === 'imperial' ? 
                `${Math.floor(heightInches / 12)}'${(heightInches % 12).toFixed(0)}"` : 
                `${heightCm.toFixed(1)} cm`;
            const displayWeight = unitSystem === 'imperial' ? 
                `${weightLbs.toFixed(1)} lbs` : 
                `${weightKg.toFixed(1)} kg`;

            // Analysis
            let analysis = `Your Basal Metabolic Rate (BMR) is approximately ${Math.round(mifflinBMR)} calories per day. `;
            analysis += `This is the number of calories your body burns at complete rest to maintain vital functions. `;
            analysis += `With your ${activityNames[activityLevel.toString()]} activity level, your Total Daily Energy Expenditure (TDEE) is ${Math.round(tdee)} calories per day. `;
            
            if (bodyFat > 0) {
                const leanMass = weightKg * (1 - bodyFat / 100);
                analysis += `Based on your ${bodyFat}% body fat, you have ${leanMass.toFixed(1)} kg of lean body mass. `;
            }
            
            analysis += `To lose weight, eat around ${Math.round(weightLoss)} calories per day (500 calorie deficit = 1 lb per week). `;
            analysis += `To maintain weight, eat ${Math.round(maintain)} calories. `;
            analysis += `To gain weight/muscle, eat around ${Math.round(weightGain)} calories per day. `;
            analysis += `Never eat below your BMR (${Math.round(mifflinBMR)} cal) for extended periods as this can slow your metabolism.`;

            // Update UI
            document.getElementById('bmrResult').textContent = Math.round(mifflinBMR).toLocaleString();
            document.getElementById('bmrDisplay').textContent = Math.round(mifflinBMR).toLocaleString();
            document.getElementById('tdeeDisplay').textContent = Math.round(tdee).toLocaleString();
            document.getElementById('activityDisplay').textContent = activityNames[activityLevel.toString()];
            document.getElementById('dailyCalories').textContent = Math.round(tdee).toLocaleString();

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('ageDisplay').textContent = `${age} years`;
            document.getElementById('heightDisplay').textContent = displayHeight;
            document.getElementById('weightDisplay').textContent = displayWeight;
            document.getElementById('activityLevelDisplay').textContent = activityNames[activityLevel.toString()];

            document.getElementById('mifflinBMR').textContent = `${Math.round(mifflinBMR).toLocaleString()} cal/day`;
            document.getElementById('harrisBMR').textContent = `${Math.round(harrisBMR).toLocaleString()} cal/day`;
            if (bodyFat > 0) {
                document.getElementById('katchBMR').textContent = `${Math.round(katchBMR).toLocaleString()} cal/day`;
            }
            document.getElementById('averageBMR').textContent = `${Math.round(averageBMR).toLocaleString()} cal/day`;

            document.getElementById('bmrTdee').textContent = `${Math.round(mifflinBMR).toLocaleString()} cal/day`;
            document.getElementById('activityMultiplier').textContent = `${activityLevel}x`;
            document.getElementById('tdeeFinal').textContent = `${Math.round(tdee).toLocaleString()} cal/day`;

            document.getElementById('extremeLoss').textContent = `${Math.round(extremeLoss).toLocaleString()} cal/day`;
            document.getElementById('weightLoss').textContent = `${Math.round(weightLoss).toLocaleString()} cal/day`;
            document.getElementById('mildLoss').textContent = `${Math.round(mildLoss).toLocaleString()} cal/day`;
            document.getElementById('maintain').textContent = `${Math.round(maintain).toLocaleString()} cal/day`;
            document.getElementById('mildGain').textContent = `${Math.round(mildGain).toLocaleString()} cal/day`;
            document.getElementById('weightGain').textContent = `${Math.round(weightGain).toLocaleString()} cal/day`;

            document.getElementById('protein').textContent = `${Math.round(protein)}g per day`;
            document.getElementById('carbs').textContent = `${Math.round(carbs)}g per day`;
            document.getElementById('fats').textContent = `${Math.round(fats)}g per day`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateBMR();
        });
    </script>
</body>
</html>