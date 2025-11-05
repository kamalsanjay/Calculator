<?php
/**
 * Macro Calculator (Macronutrient Calculator)
 * File: macro-calculator.php
 * Description: Calculate daily protein, carbs, and fat needs based on goals
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Macro Calculator - Macronutrient Calculator (Protein, Carbs, Fat)</title>
    <meta name="description" content="Free macro calculator. Calculate daily protein, carbs, and fat needs for weight loss, muscle gain, or maintenance. Personalized macronutrient goals.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🍎 Macro Calculator</h1>
        <p>Calculate protein, carbs, fat needs</p>
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
                <form id="macroForm">
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
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Activity & Goals</h3>
                    
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
                    
                    <div class="form-group">
                        <label for="goal">Goal</label>
                        <select id="goal">
                            <option value="loss">Weight Loss (Fat Loss)</option>
                            <option value="maintain" selected>Maintain Weight</option>
                            <option value="gain">Muscle Gain (Bulk)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="macroSplit">Macro Split</label>
                        <select id="macroSplit">
                            <option value="balanced" selected>Balanced (40/30/30)</option>
                            <option value="high-protein">High Protein (40/25/35)</option>
                            <option value="low-carb">Low Carb (30/20/50)</option>
                            <option value="keto">Ketogenic (5/25/70)</option>
                            <option value="low-fat">Low Fat (60/20/20)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Macros</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Macro Results</h2>
                
                <div class="result-card success">
                    <h3>Daily Calories</h3>
                    <div class="amount" id="caloriesResult">2,790 cal</div>
                    <div style="margin-top: 10px; font-size: 1em;">Total daily target</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Protein</h4>
                        <div class="value" id="proteinDisplay">279g</div>
                    </div>
                    <div class="metric-card">
                        <h4>Carbs</h4>
                        <div class="value" id="carbsDisplay">209g</div>
                    </div>
                    <div class="metric-card">
                        <h4>Fat</h4>
                        <div class="value" id="fatDisplay">93g</div>
                    </div>
                    <div class="metric-card">
                        <h4>Calories</h4>
                        <div class="value" id="totalCalDisplay">2,790</div>
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
                        <strong id="activityDisplay">Moderate</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Goal</span>
                        <strong id="goalDisplay">Maintain Weight</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Macro Split</span>
                        <strong id="splitDisplay">Balanced</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Daily Macro Targets</h3>
                    <div class="breakdown-item">
                        <span>Total Daily Calories</span>
                        <strong id="totalCalories" style="color: #667eea; font-size: 1.1em;">2,790 cal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Protein (40%)</span>
                        <strong id="proteinMacro" style="color: #E91E63;">279g (1,116 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Carbohydrates (30%)</span>
                        <strong id="carbsMacro" style="color: #4CAF50;">209g (837 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fat (30%)</span>
                        <strong id="fatMacro" style="color: #FF9800;">93g (837 cal)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Meal Distribution (4 meals)</h3>
                    <div class="breakdown-item">
                        <span>Calories per Meal</span>
                        <strong id="calPerMeal">698 cal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Protein per Meal</span>
                        <strong id="proteinPerMeal">70g</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Carbs per Meal</span>
                        <strong id="carbsPerMeal">52g</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fat per Meal</span>
                        <strong id="fatPerMeal">23g</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Weekly Totals</h3>
                    <div class="breakdown-item">
                        <span>Weekly Calories</span>
                        <strong id="weeklyCal">19,530 cal/week</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekly Protein</span>
                        <strong id="weeklyProtein">1,953g/week</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekly Carbs</span>
                        <strong id="weeklyCarbs">1,465g/week</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekly Fat</span>
                        <strong id="weeklyFat">651g/week</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Alternative Macro Splits</h3>
                    <div class="breakdown-item">
                        <span>Balanced (40/30/30)</span>
                        <strong id="balancedSplit">279g P / 209g C / 93g F</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>High Protein (40/25/35)</span>
                        <strong id="highProteinSplit">279g P / 174g C / 108g F</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Low Carb (30/20/50)</span>
                        <strong id="lowCarbSplit">209g P / 140g C / 155g F</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ketogenic (5/25/70)</span>
                        <strong id="ketoSplit">174g P / 35g C / 217g F</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Low Fat (60/20/20)</span>
                        <strong id="lowFatSplit">140g P / 419g C / 62g F</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Macronutrients</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Protein (4 calories per gram):</strong> Builds/repairs muscle, supports immune function, maintains lean mass. Essential for recovery and growth.</p>
                        <p><strong>Carbohydrates (4 calories per gram):</strong> Primary energy source, fuels workouts, replenishes glycogen, supports brain function.</p>
                        <p><strong>Fat (9 calories per gram):</strong> Hormone production, vitamin absorption (A,D,E,K), cell structure, sustained energy, anti-inflammatory.</p>
                        <p><strong>Why Track Macros:</strong> More accurate than just calories. Same calories, different macros = different body composition results.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Macro Splits Explained</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Balanced (40/30/30):</strong> 40% protein, 30% carbs, 30% fat. Best for most people. Flexible, sustainable, supports muscle & performance.</p>
                        <p><strong>High Protein (40/25/35):</strong> Great for fat loss, muscle preservation, high satiety. Popular with bodybuilders and fitness enthusiasts.</p>
                        <p><strong>Low Carb (30/20/50):</strong> Moderate carb reduction. Good for insulin sensitivity, appetite control. Still enough carbs for training.</p>
                        <p><strong>Ketogenic (5/25/70):</strong> Very low carb (&lt;50g), high fat. Body uses ketones for fuel. For epilepsy, fat loss, mental clarity. Hard to sustain.</p>
                        <p><strong>Low Fat (60/20/20):</strong> High carb, low fat. Good for endurance athletes, active people. Need whole grains & fiber.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Protein Requirements</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Sedentary:</strong> 0.5-0.7g per lb bodyweight (1.2-1.6g per kg)</p>
                        <p><strong>Active/Athletic:</strong> 0.7-1.0g per lb (1.6-2.2g per kg)</p>
                        <p><strong>Muscle Building:</strong> 0.8-1.2g per lb (1.8-2.4g per kg)</p>
                        <p><strong>Fat Loss:</strong> 1.0-1.2g per lb (2.2-2.6g per kg) - higher protein preserves muscle</p>
                        <p><strong>Best Sources:</strong> Chicken, turkey, fish, eggs, Greek yogurt, cottage cheese, lean beef, protein powder, tofu, legumes</p>
                        <p><strong>Timing:</strong> Spread throughout day. 20-40g per meal optimal for muscle protein synthesis.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Carbohydrate Guidelines</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Low Carb:</strong> &lt;100g/day. Ketogenic &lt;50g/day.</p>
                        <p><strong>Moderate Carb:</strong> 100-200g/day. Good for weight loss with training.</p>
                        <p><strong>High Carb:</strong> 200-400g+ /day. For athletes, bulking, very active.</p>
                        <p><strong>Complex Carbs (Choose These):</strong> Oats, brown rice, quinoa, sweet potatoes, whole grain bread, fruits, vegetables</p>
                        <p><strong>Simple Carbs (Limit):</strong> Sugar, candy, soda, white bread, pastries</p>
                        <p><strong>Timing:</strong> Pre-workout (1-3 hrs before), post-workout (within 2 hrs). Fuel and recovery.</p>
                        <p><strong>Fiber:</strong> Aim 25-35g daily. Found in vegetables, fruits, whole grains, legumes.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Fat Recommendations</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Minimum:</strong> 0.3-0.5g per lb bodyweight (20-30% of calories). Essential for hormones.</p>
                        <p><strong>Balanced Diet:</strong> 0.4-0.6g per lb (25-35% of calories)</p>
                        <p><strong>High Fat/Keto:</strong> 0.8-1.5g per lb (60-75% of calories)</p>
                        <p><strong>Healthy Fats (Eat These):</strong> Olive oil, avocados, nuts, seeds, fatty fish (salmon, mackerel), nut butters, eggs</p>
                        <p><strong>Limit Saturated Fat:</strong> Red meat, butter, cheese, coconut oil. Keep &lt;10% of calories.</p>
                        <p><strong>Avoid Trans Fats:</strong> Fried foods, margarine, processed baked goods. Harmful to heart health.</p>
                        <p><strong>Omega-3s:</strong> 2-3g/day from fish or supplements (EPA + DHA). Anti-inflammatory.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Adjusting Macros by Goal</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Fat Loss:</strong></p>
                        <p>• Create 500 cal deficit (lose 1 lb/week)</p>
                        <p>• High protein (1-1.2g per lb) to preserve muscle</p>
                        <p>• Moderate carbs (100-200g) or low carb if preferred</p>
                        <p>• Moderate fat (0.4-0.5g per lb) for hormones</p>
                        <p><strong>Muscle Gain (Bulk):</strong></p>
                        <p>• Create 300-500 cal surplus (gain 0.5-1 lb/week)</p>
                        <p>• High protein (0.8-1g per lb) for muscle synthesis</p>
                        <p>• High carbs (200-400g+) for energy and recovery</p>
                        <p>• Moderate fat (0.4-0.6g per lb)</p>
                        <p><strong>Maintenance:</strong></p>
                        <p>• Eat at TDEE (no surplus/deficit)</p>
                        <p>• Moderate protein (0.7-0.9g per lb)</p>
                        <p>• Flexible carbs/fat based on preference</p>
                        <p>• Focus on performance and consistency</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Macro Tracking Tips</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Use Food Scale:</strong> Weigh food for accuracy. Eyeballing underestimates by 20-50%.</p>
                        <p>&#10003; <strong>Track Everything:</strong> Apps like MyFitnessPal, Cronometer, MacroFactor. Log daily.</p>
                        <p>&#10003; <strong>Plan Ahead:</strong> Meal prep makes hitting macros easier. Prepare 3-4 days at once.</p>
                        <p>&#10003; <strong>Prioritize Protein:</strong> Hit protein goal first, then fill in carbs/fat.</p>
                        <p>&#10003; <strong>±5g Flexibility:</strong> Don't stress over hitting exact numbers. Within 5g is fine.</p>
                        <p>&#10003; <strong>Weekly Average:</strong> Some days over, some under. Weekly total matters most.</p>
                        <p>&#10003; <strong>Adjust as Needed:</strong> Not losing weight after 2-3 weeks? Reduce calories by 200.</p>
                        <p>&#10003; <strong>Be Consistent:</strong> Track for at least 4 weeks before changing approach.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Macro Tips:</strong> Protein = 4 cal/g. Carbs = 4 cal/g. Fat = 9 cal/g. Protein: 0.8-1.2g per lb. Carbs: 100-300g varies by activity. Fat: minimum 0.4g per lb. Balanced split = 40/30/30. High protein = best for fat loss. Ketogenic = &lt;50g carbs. Low carb = 50-100g. Track with food scale + app. Meal prep = key to consistency. Hit protein target first. Fiber = 25-35g daily. Omega-3 = 2-3g daily. Eat complex carbs. Avoid trans fats. Adjust every 2-3 weeks if needed. Weekly average matters more than daily. Spread protein across meals. Pre/post-workout carbs = best timing. Be flexible ±5g. Track for 4+ weeks before changing!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('macroForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateMacros();
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
            calculateMacros();
        });

        function calculateMacros() {
            const gender = document.getElementById('gender').value;
            const age = parseInt(document.getElementById('age').value) || 30;
            const activityLevel = parseFloat(document.getElementById('activityLevel').value) || 1.55;
            const goal = document.getElementById('goal').value;
            const macroSplit = document.getElementById('macroSplit').value;
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

            // Calculate BMR using Mifflin-St Jeor
            let bmr;
            if (gender === 'male') {
                bmr = (10 * weightKg) + (6.25 * heightCm) - (5 * age) + 5;
            } else {
                bmr = (10 * weightKg) + (6.25 * heightCm) - (5 * age) - 161;
            }

            // Calculate TDEE
            const tdee = bmr * activityLevel;

            // Adjust for goal
            let calories;
            let goalName;
            switch(goal) {
                case 'loss':
                    calories = tdee - 500;
                    goalName = 'Weight Loss';
                    break;
                case 'maintain':
                    calories = tdee;
                    goalName = 'Maintain Weight';
                    break;
                case 'gain':
                    calories = tdee + 300;
                    goalName = 'Muscle Gain';
                    break;
            }

            // Get macro ratios
            let proteinPercent, carbsPercent, fatPercent, splitName;
            switch(macroSplit) {
                case 'balanced':
                    proteinPercent = 0.40;
                    carbsPercent = 0.30;
                    fatPercent = 0.30;
                    splitName = 'Balanced (40/30/30)';
                    break;
                case 'high-protein':
                    proteinPercent = 0.40;
                    carbsPercent = 0.25;
                    fatPercent = 0.35;
                    splitName = 'High Protein (40/25/35)';
                    break;
                case 'low-carb':
                    proteinPercent = 0.30;
                    carbsPercent = 0.20;
                    fatPercent = 0.50;
                    splitName = 'Low Carb (30/20/50)';
                    break;
                case 'keto':
                    proteinPercent = 0.25;
                    carbsPercent = 0.05;
                    fatPercent = 0.70;
                    splitName = 'Ketogenic (5/25/70)';
                    break;
                case 'low-fat':
                    proteinPercent = 0.20;
                    carbsPercent = 0.60;
                    fatPercent = 0.20;
                    splitName = 'Low Fat (60/20/20)';
                    break;
            }

            // Calculate macros
            const proteinCal = calories * proteinPercent;
            const carbsCal = calories * carbsPercent;
            const fatCal = calories * fatPercent;

            const proteinGrams = proteinCal / 4;
            const carbsGrams = carbsCal / 4;
            const fatGrams = fatCal / 9;

            // Meal distribution (4 meals)
            const calPerMeal = calories / 4;
            const proteinPerMeal = proteinGrams / 4;
            const carbsPerMeal = carbsGrams / 4;
            const fatPerMeal = fatGrams / 4;

            // Weekly totals
            const weeklyCal = calories * 7;
            const weeklyProtein = proteinGrams * 7;
            const weeklyCarbs = carbsGrams * 7;
            const weeklyFat = fatGrams * 7;

            // Alternative splits
            const balancedP = (calories * 0.40) / 4;
            const balancedC = (calories * 0.30) / 4;
            const balancedF = (calories * 0.30) / 9;

            const highProteinP = (calories * 0.40) / 4;
            const highProteinC = (calories * 0.25) / 4;
            const highProteinF = (calories * 0.35) / 9;

            const lowCarbP = (calories * 0.30) / 4;
            const lowCarbC = (calories * 0.20) / 4;
            const lowCarbF = (calories * 0.50) / 9;

            const ketoP = (calories * 0.25) / 4;
            const ketoC = (calories * 0.05) / 4;
            const ketoF = (calories * 0.70) / 9;

            const lowFatP = (calories * 0.20) / 4;
            const lowFatC = (calories * 0.60) / 4;
            const lowFatF = (calories * 0.20) / 9;

            // Activity names
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
            const heightDisplay = unitSystem === 'imperial' ? 
                `${Math.floor(heightInches / 12)}'${(heightInches % 12).toFixed(0)}"` : 
                `${heightCm.toFixed(1)} cm`;
            const weightDisplay = unitSystem === 'imperial' ? 
                `${weightLbs.toFixed(1)} lbs` : 
                `${weightKg.toFixed(1)} kg`;

            // Analysis
            let analysis = `For your goal of "${goalName}" with a ${activityNames[activityLevel.toString()].toLowerCase()} activity level, you should consume approximately ${Math.round(calories)} calories per day. `;
            analysis += `Using the ${splitName} macro split, your daily targets are ${Math.round(proteinGrams)}g protein, ${Math.round(carbsGrams)}g carbohydrates, and ${Math.round(fatGrams)}g fat. `;
            
            analysis += `Protein provides ${Math.round(proteinCal)} calories (${(proteinPercent * 100).toFixed(0)}%), carbs provide ${Math.round(carbsCal)} calories (${(carbsPercent * 100).toFixed(0)}%), and fat provides ${Math.round(fatCal)} calories (${(fatPercent * 100).toFixed(0)}%). `;
            
            if (goal === 'loss') {
                analysis += `For fat loss, prioritize hitting your protein target (${Math.round(proteinGrams)}g) to preserve muscle mass while in a calorie deficit. `;
            } else if (goal === 'gain') {
                analysis += `For muscle gain, ensure you're eating enough protein (${Math.round(proteinGrams)}g) and carbs (${Math.round(carbsGrams)}g) to support training and recovery. `;
            }
            
            if (macroSplit === 'keto') {
                analysis += `On a ketogenic diet with only ${Math.round(carbsGrams)}g carbs per day, your body will enter ketosis and use fat for fuel. This is very restrictive and requires dedication. `;
            }
            
            analysis += `Distribute your macros across 3-5 meals throughout the day. For example, if eating 4 meals, aim for ${Math.round(proteinPerMeal)}g protein, ${Math.round(carbsPerMeal)}g carbs, and ${Math.round(fatPerMeal)}g fat per meal. `;
            analysis += `Track your food intake using a food scale and app like MyFitnessPal for accuracy. Adjust macros if you don't see progress after 2-3 weeks.`;

            // Update UI
            document.getElementById('caloriesResult').textContent = `${Math.round(calories).toLocaleString()} cal`;
            document.getElementById('proteinDisplay').textContent = `${Math.round(proteinGrams)}g`;
            document.getElementById('carbsDisplay').textContent = `${Math.round(carbsGrams)}g`;
            document.getElementById('fatDisplay').textContent = `${Math.round(fatGrams)}g`;
            document.getElementById('totalCalDisplay').textContent = Math.round(calories).toLocaleString();

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('ageDisplay').textContent = `${age} years`;
            document.getElementById('heightDisplay').textContent = heightDisplay;
            document.getElementById('weightDisplay').textContent = weightDisplay;
            document.getElementById('activityDisplay').textContent = activityNames[activityLevel.toString()];
            document.getElementById('goalDisplay').textContent = goalName;
            document.getElementById('splitDisplay').textContent = splitName;

            document.getElementById('totalCalories').textContent = `${Math.round(calories).toLocaleString()} cal`;
            document.getElementById('proteinMacro').textContent = `${Math.round(proteinGrams)}g (${Math.round(proteinCal)} cal)`;
            document.getElementById('carbsMacro').textContent = `${Math.round(carbsGrams)}g (${Math.round(carbsCal)} cal)`;
            document.getElementById('fatMacro').textContent = `${Math.round(fatGrams)}g (${Math.round(fatCal)} cal)`;

            document.getElementById('calPerMeal').textContent = `${Math.round(calPerMeal)} cal`;
            document.getElementById('proteinPerMeal').textContent = `${Math.round(proteinPerMeal)}g`;
            document.getElementById('carbsPerMeal').textContent = `${Math.round(carbsPerMeal)}g`;
            document.getElementById('fatPerMeal').textContent = `${Math.round(fatPerMeal)}g`;

            document.getElementById('weeklyCal').textContent = `${Math.round(weeklyCal).toLocaleString()} cal/week`;
            document.getElementById('weeklyProtein').textContent = `${Math.round(weeklyProtein).toLocaleString()}g/week`;
            document.getElementById('weeklyCarbs').textContent = `${Math.round(weeklyCarbs).toLocaleString()}g/week`;
            document.getElementById('weeklyFat').textContent = `${Math.round(weeklyFat).toLocaleString()}g/week`;

            document.getElementById('balancedSplit').textContent = `${Math.round(balancedP)}g P / ${Math.round(balancedC)}g C / ${Math.round(balancedF)}g F`;
            document.getElementById('highProteinSplit').textContent = `${Math.round(highProteinP)}g P / ${Math.round(highProteinC)}g C / ${Math.round(highProteinF)}g F`;
            document.getElementById('lowCarbSplit').textContent = `${Math.round(lowCarbP)}g P / ${Math.round(lowCarbC)}g C / ${Math.round(lowCarbF)}g F`;
            document.getElementById('ketoSplit').textContent = `${Math.round(ketoP)}g P / ${Math.round(ketoC)}g C / ${Math.round(ketoF)}g F`;
            document.getElementById('lowFatSplit').textContent = `${Math.round(lowFatP)}g P / ${Math.round(lowFatC)}g C / ${Math.round(lowFatF)}g F`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateMacros();
        });
    </script>
</body>
</html>