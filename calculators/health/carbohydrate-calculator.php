<?php
/**
 * Carbohydrate Calculator
 * File: carbohydrate-calculator.php
 * Description: Calculate daily carb needs for different diets and goals
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carbohydrate Calculator - Daily Carb Needs & Macros</title>
    <meta name="description" content="Free carbohydrate calculator. Calculate daily carb needs for low-carb, keto, balanced, and high-carb diets. Get personalized macro recommendations.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🍞 Carbohydrate Calculator</h1>
        <p>Calculate daily carb needs</p>
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
                <form id="carbForm">
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
                            <option value="loss">Weight Loss</option>
                            <option value="maintain" selected>Maintain Weight</option>
                            <option value="gain">Weight Gain/Muscle Building</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="dietType">Diet Type</label>
                        <select id="dietType">
                            <option value="keto">Keto (Very Low Carb)</option>
                            <option value="low-carb">Low Carb</option>
                            <option value="moderate">Moderate Carb</option>
                            <option value="balanced" selected>Balanced</option>
                            <option value="high-carb">High Carb</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Carbs</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Carbohydrate Results</h2>
                
                <div class="result-card success">
                    <h3>Daily Carbohydrate Goal</h3>
                    <div class="amount" id="carbResult">279g</div>
                    <div style="margin-top: 10px; font-size: 1em;">per day</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Carbs</h4>
                        <div class="value" id="carbDisplay">279g</div>
                    </div>
                    <div class="metric-card">
                        <h4>Protein</h4>
                        <div class="value" id="proteinDisplay">209g</div>
                    </div>
                    <div class="metric-card">
                        <h4>Fats</h4>
                        <div class="value" id="fatDisplay">93g</div>
                    </div>
                    <div class="metric-card">
                        <h4>Calories</h4>
                        <div class="value" id="caloriesDisplay">2,790</div>
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
                        <span>Diet Type</span>
                        <strong id="dietDisplay">Balanced</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Daily Macronutrient Goals</h3>
                    <div class="breakdown-item">
                        <span>Total Daily Calories</span>
                        <strong id="totalCalories" style="color: #667eea; font-size: 1.1em;">2,790 cal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Carbohydrates (40%)</span>
                        <strong id="carbGrams" style="color: #2196F3;">279g (1,116 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Protein (30%)</span>
                        <strong id="proteinGrams" style="color: #E91E63;">209g (837 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fats (30%)</span>
                        <strong id="fatGrams" style="color: #FF9800;">93g (837 cal)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Carb Distribution per Meal</h3>
                    <div class="breakdown-item">
                        <span>3 Meals per Day</span>
                        <strong id="carbPerMeal3">93g per meal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>4 Meals per Day</span>
                        <strong id="carbPerMeal4">70g per meal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>5 Meals per Day</span>
                        <strong id="carbPerMeal5">56g per meal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>6 Meals per Day</span>
                        <strong id="carbPerMeal6">47g per meal</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Carb Intake by Timing</h3>
                    <div class="breakdown-item">
                        <span>Pre-Workout (1-2 hrs before)</span>
                        <strong id="preWorkout">56g (20%)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Post-Workout (within 1 hr)</span>
                        <strong id="postWorkout">84g (30%)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Rest of Day</span>
                        <strong id="restDay">140g (50%)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Diet Type Comparison</h3>
                    <div class="breakdown-item">
                        <span>Keto (5% carbs)</span>
                        <strong id="ketoDiet" style="color: #f44336;">35g carbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Low Carb (20% carbs)</span>
                        <strong id="lowCarbDiet" style="color: #FF9800;">140g carbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Moderate Carb (30% carbs)</span>
                        <strong id="moderateDiet" style="color: #4CAF50;">209g carbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Balanced (40% carbs)</span>
                        <strong id="balancedDiet" style="color: #2196F3;">279g carbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>High Carb (55% carbs)</span>
                        <strong id="highCarbDiet" style="color: #9C27B0;">383g carbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Carbohydrate Serving Examples</h3>
                    <div class="breakdown-item">
                        <span>White Rice (cooked)</span>
                        <strong id="rice">0 cups (45g carbs/cup)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Whole Wheat Bread</span>
                        <strong id="bread">0 slices (15g carbs/slice)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pasta (cooked)</span>
                        <strong id="pasta">0 cups (43g carbs/cup)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Banana (medium)</span>
                        <strong id="banana">0 bananas (27g carbs each)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Oatmeal (cooked)</span>
                        <strong id="oatmeal">0 cups (27g carbs/cup)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Sweet Potato (medium)</span>
                        <strong id="sweetPotato">0 potatoes (24g carbs each)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Types of Carbohydrates</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Simple Carbs (Quick Energy):</strong> Sugar, honey, fruit juice, candy, soda. Fast digestion, quick energy spike.</p>
                        <p><strong>Complex Carbs (Sustained Energy):</strong> Whole grains, oats, rice, quinoa, sweet potatoes. Slow digestion, steady energy.</p>
                        <p><strong>Fiber (0 net carbs):</strong> Vegetables, beans, whole grains. Doesn't raise blood sugar. Essential for digestion.</p>
                        <p><strong>Net Carbs:</strong> Total Carbs - Fiber = Net Carbs (used for keto/low-carb diets)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Best Carb Sources</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Whole Grains:</strong> Brown rice, quinoa, oats, whole wheat bread, whole wheat pasta</p>
                        <p><strong>Starchy Vegetables:</strong> Sweet potatoes, regular potatoes, corn, peas, butternut squash</p>
                        <p><strong>Legumes:</strong> Beans, lentils, chickpeas (high protein + carbs)</p>
                        <p><strong>Fruits:</strong> Bananas, apples, berries, oranges (natural sugars + fiber + vitamins)</p>
                        <p><strong>Dairy:</strong> Milk, yogurt (contains lactose, a natural sugar)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Carb Timing for Performance</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Pre-Workout (1-2 hours before):</strong> 20-30% of daily carbs. Choose easily digestible carbs for energy.</p>
                        <p><strong>Post-Workout (within 1 hour):</strong> 30-40% of daily carbs. Replenish glycogen, aid recovery.</p>
                        <p><strong>Morning:</strong> Good time for carbs to fuel the day. Oatmeal, fruit, whole grain toast.</p>
                        <p><strong>Evening:</strong> Reduce carbs if sedentary. Some people tolerate carbs better at night (better sleep).</p>
                        <p><strong>During Long Exercise (&gt;90 min):</strong> 30-60g carbs per hour for endurance.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Carb Guidelines by Goal</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Weight Loss:</strong> Lower carbs (20-30% of calories) to create deficit. Prioritize protein to preserve muscle.</p>
                        <p><strong>Muscle Gain:</strong> Higher carbs (40-55% of calories) for energy and recovery. Combine with strength training.</p>
                        <p><strong>Endurance Athletes:</strong> Very high carbs (55-65%) to fuel long-duration activities.</p>
                        <p><strong>Keto/Low-Carb:</strong> &lt;50g carbs daily to enter ketosis. High fat for energy instead.</p>
                        <p><strong>Maintenance:</strong> Moderate carbs (30-40%). Adjust based on activity level.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Carbohydrate Tips:</strong> Carbs = 4 cal/gram. Body's preferred fuel source. Not essential (fat/protein are). Complex carbs > simple carbs. Fiber = 0 net carbs. Time carbs around workouts. Athletes need more carbs. Keto = &lt;50g/day. Low-carb = 50-150g/day. Moderate = 150-300g/day. High-carb = 300g+/day. Carbs don't make you fat (excess calories do). Whole grains > refined grains. Fruit = healthy carbs. Vegetables = unlimited. Track net carbs on keto. Glycogen = stored carbs in muscles. Refeed days OK on low-carb. Listen to your body!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('carbForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateCarbs();
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
            calculateCarbs();
        });

        function calculateCarbs() {
            const gender = document.getElementById('gender').value;
            const age = parseInt(document.getElementById('age').value) || 30;
            const activityLevel = parseFloat(document.getElementById('activityLevel').value) || 1.55;
            const goal = document.getElementById('goal').value;
            const dietType = document.getElementById('dietType').value;
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

            // Calculate BMR
            let bmr;
            if (gender === 'male') {
                bmr = (10 * weightKg) + (6.25 * heightCm) - (5 * age) + 5;
            } else {
                bmr = (10 * weightKg) + (6.25 * heightCm) - (5 * age) - 161;
            }

            // Calculate TDEE
            const tdee = bmr * activityLevel;

            // Apply goal adjustment
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
                    goalName = 'Weight Gain/Muscle Building';
                    break;
            }

            // Get macros based on diet type
            let carbPercent, proteinPercent, fatPercent, dietName;
            
            switch(dietType) {
                case 'keto':
                    carbPercent = 0.05;
                    proteinPercent = 0.25;
                    fatPercent = 0.70;
                    dietName = 'Keto (Very Low Carb)';
                    break;
                case 'low-carb':
                    carbPercent = 0.20;
                    proteinPercent = 0.35;
                    fatPercent = 0.45;
                    dietName = 'Low Carb';
                    break;
                case 'moderate':
                    carbPercent = 0.30;
                    proteinPercent = 0.35;
                    fatPercent = 0.35;
                    dietName = 'Moderate Carb';
                    break;
                case 'balanced':
                    carbPercent = 0.40;
                    proteinPercent = 0.30;
                    fatPercent = 0.30;
                    dietName = 'Balanced';
                    break;
                case 'high-carb':
                    carbPercent = 0.55;
                    proteinPercent = 0.25;
                    fatPercent = 0.20;
                    dietName = 'High Carb';
                    break;
            }

            // Calculate macros
            const carbCal = calories * carbPercent;
            const proteinCal = calories * proteinPercent;
            const fatCal = calories * fatPercent;
            
            const carbGrams = carbCal / 4;
            const proteinGrams = proteinCal / 4;
            const fatGrams = fatCal / 9;

            // Carb distribution per meal
            const carbPerMeal3 = carbGrams / 3;
            const carbPerMeal4 = carbGrams / 4;
            const carbPerMeal5 = carbGrams / 5;
            const carbPerMeal6 = carbGrams / 6;

            // Carb timing
            const preWorkout = carbGrams * 0.20;
            const postWorkout = carbGrams * 0.30;
            const restDay = carbGrams * 0.50;

            // Diet type comparison
            const ketoDiet = (calories * 0.05) / 4;
            const lowCarbDiet = (calories * 0.20) / 4;
            const moderateDiet = (calories * 0.30) / 4;
            const balancedDiet = (calories * 0.40) / 4;
            const highCarbDiet = (calories * 0.55) / 4;

            // Food examples
            const rice = carbGrams / 45;
            const bread = carbGrams / 15;
            const pasta = carbGrams / 43;
            const banana = carbGrams / 27;
            const oatmeal = carbGrams / 27;
            const sweetPotato = carbGrams / 24;

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
            let analysis = `For your goal of "${goalName}" with a ${dietName} diet, you should consume approximately ${Math.round(carbGrams)}g of carbohydrates per day. `;
            analysis += `This represents ${(carbPercent * 100).toFixed(0)}% of your ${Math.round(calories)} daily calories. `;
            analysis += `Your complete macros are ${Math.round(carbGrams)}g carbs, ${Math.round(proteinGrams)}g protein, and ${Math.round(fatGrams)}g fat. `;
            
            if (dietType === 'keto') {
                analysis += `On a keto diet, keep net carbs under 50g to maintain ketosis. Focus on high-fat foods and monitor ketone levels. `;
            } else if (dietType === 'low-carb') {
                analysis += `On a low-carb diet, prioritize protein and healthy fats. Choose complex carbs when you do eat them. `;
            } else if (dietType === 'high-carb') {
                analysis += `On a high-carb diet, focus on whole grains, fruits, and vegetables. Great for athletic performance and endurance. `;
            } else {
                analysis += `A balanced diet provides enough carbs for energy while maintaining adequate protein and fats. `;
            }
            
            analysis += `Time your carbs around workouts for best results: ${Math.round(preWorkout)}g pre-workout and ${Math.round(postWorkout)}g post-workout.`;

            // Update UI
            document.getElementById('carbResult').textContent = `${Math.round(carbGrams)}g`;
            document.getElementById('carbDisplay').textContent = `${Math.round(carbGrams)}g`;
            document.getElementById('proteinDisplay').textContent = `${Math.round(proteinGrams)}g`;
            document.getElementById('fatDisplay').textContent = `${Math.round(fatGrams)}g`;
            document.getElementById('caloriesDisplay').textContent = Math.round(calories).toLocaleString();

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('ageDisplay').textContent = `${age} years`;
            document.getElementById('heightDisplay').textContent = displayHeight;
            document.getElementById('weightDisplay').textContent = displayWeight;
            document.getElementById('activityDisplay').textContent = activityNames[activityLevel.toString()];
            document.getElementById('goalDisplay').textContent = goalName;
            document.getElementById('dietDisplay').textContent = dietName;

            document.getElementById('totalCalories').textContent = `${Math.round(calories).toLocaleString()} cal`;
            document.getElementById('carbGrams').textContent = `${Math.round(carbGrams)}g (${Math.round(carbCal)} cal)`;
            document.getElementById('proteinGrams').textContent = `${Math.round(proteinGrams)}g (${Math.round(proteinCal)} cal)`;
            document.getElementById('fatGrams').textContent = `${Math.round(fatGrams)}g (${Math.round(fatCal)} cal)`;

            document.getElementById('carbPerMeal3').textContent = `${Math.round(carbPerMeal3)}g per meal`;
            document.getElementById('carbPerMeal4').textContent = `${Math.round(carbPerMeal4)}g per meal`;
            document.getElementById('carbPerMeal5').textContent = `${Math.round(carbPerMeal5)}g per meal`;
            document.getElementById('carbPerMeal6').textContent = `${Math.round(carbPerMeal6)}g per meal`;

            document.getElementById('preWorkout').textContent = `${Math.round(preWorkout)}g (20%)`;
            document.getElementById('postWorkout').textContent = `${Math.round(postWorkout)}g (30%)`;
            document.getElementById('restDay').textContent = `${Math.round(restDay)}g (50%)`;

            document.getElementById('ketoDiet').textContent = `${Math.round(ketoDiet)}g carbs`;
            document.getElementById('lowCarbDiet').textContent = `${Math.round(lowCarbDiet)}g carbs`;
            document.getElementById('moderateDiet').textContent = `${Math.round(moderateDiet)}g carbs`;
            document.getElementById('balancedDiet').textContent = `${Math.round(balancedDiet)}g carbs`;
            document.getElementById('highCarbDiet').textContent = `${Math.round(highCarbDiet)}g carbs`;

            document.getElementById('rice').textContent = `${rice.toFixed(1)} cups (45g carbs/cup)`;
            document.getElementById('bread').textContent = `${bread.toFixed(0)} slices (15g carbs/slice)`;
            document.getElementById('pasta').textContent = `${pasta.toFixed(1)} cups (43g carbs/cup)`;
            document.getElementById('banana').textContent = `${banana.toFixed(1)} bananas (27g carbs each)`;
            document.getElementById('oatmeal').textContent = `${oatmeal.toFixed(1)} cups (27g carbs/cup)`;
            document.getElementById('sweetPotato').textContent = `${sweetPotato.toFixed(1)} potatoes (24g carbs each)`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateCarbs();
        });
    </script>
</body>
</html>