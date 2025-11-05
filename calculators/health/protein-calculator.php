<?php
/**
 * Protein Calculator
 * File: protein-calculator.php
 * Description: Calculate daily protein needs based on weight, activity, and goals
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protein Calculator - Daily Protein Intake Calculator (g/day, g/lb, g/kg)</title>
    <meta name="description" content="Free protein calculator. Calculate daily protein needs based on weight, activity level, and fitness goals. Get personalized protein intake recommendations.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🥩 Protein Calculator</h1>
        <p>Calculate daily protein needs</p>
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
                <form id="proteinForm">
                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="imperial">Imperial (lbs)</option>
                            <option value="metric">Metric (kg)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Body Measurements</h3>
                    
                    <div class="form-group">
                        <label for="age">Age (years)</label>
                        <input type="number" id="age" value="30" min="15" max="100" step="1" required>
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
                            <option value="sedentary">Sedentary (little/no exercise)</option>
                            <option value="light">Light (exercise 1-3 days/week)</option>
                            <option value="moderate" selected>Moderate (exercise 3-5 days/week)</option>
                            <option value="active">Active (exercise 6-7 days/week)</option>
                            <option value="athlete">Athlete (intense training daily)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="goal">Fitness Goal</label>
                        <select id="goal">
                            <option value="general">General Health</option>
                            <option value="maintain">Maintain Weight</option>
                            <option value="fat-loss">Fat Loss / Weight Loss</option>
                            <option value="muscle-gain" selected>Muscle Gain / Bulking</option>
                            <option value="athletic">Athletic Performance</option>
                            <option value="endurance">Endurance Training</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Protein</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Protein Results</h2>
                
                <div class="result-card success">
                    <h3>Daily Protein Intake</h3>
                    <div class="amount" id="proteinResult">164g</div>
                    <div style="margin-top: 10px; font-size: 1em;">Recommended daily protein</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total (g/day)</h4>
                        <div class="value" id="totalProtein">164g</div>
                    </div>
                    <div class="metric-card">
                        <h4>Per Pound</h4>
                        <div class="value" id="perPound">0.91g/lb</div>
                    </div>
                    <div class="metric-card">
                        <h4>Per Kilogram</h4>
                        <div class="value" id="perKg">2.0g/kg</div>
                    </div>
                    <div class="metric-card">
                        <h4>Per Meal (4)</h4>
                        <div class="value" id="perMeal">41g</div>
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
                        <span>Weight</span>
                        <strong id="weightDisplay">180 lbs (82 kg)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Activity Level</span>
                        <strong id="activityDisplay">Moderate</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fitness Goal</span>
                        <strong id="goalDisplay">Muscle Gain</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Daily Protein Targets</h3>
                    <div class="breakdown-item">
                        <span>Total Daily Protein</span>
                        <strong id="dailyProtein" style="color: #E91E63; font-size: 1.1em;">164g</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Protein per Pound</span>
                        <strong id="proteinPerLb" style="color: #667eea;">0.91 g/lb</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Protein per Kilogram</span>
                        <strong id="proteinPerKg" style="color: #4CAF50;">2.0 g/kg</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Calories from Protein</span>
                        <strong id="proteinCalories">656 calories (4 cal/g)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Percentage of Diet (2500 cal)</span>
                        <strong id="proteinPercent">26%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Meal Distribution (4 meals/day)</h3>
                    <div class="breakdown-item">
                        <span>Protein per Meal</span>
                        <strong id="protein4Meals" style="color: #FF9800;">41g per meal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Breakfast</span>
                        <strong id="breakfast">41g</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lunch</span>
                        <strong id="lunch">41g</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Dinner</span>
                        <strong id="dinner">41g</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Snack/Shake</span>
                        <strong id="snack">41g</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Protein by Goal</h3>
                    <div class="breakdown-item">
                        <span>General Health</span>
                        <strong>73g (0.4 g/lb | 0.8 g/kg)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Maintain Weight</span>
                        <strong>109g (0.6 g/lb | 1.3 g/kg)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fat Loss</span>
                        <strong>180g (1.0 g/lb | 2.2 g/kg)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Muscle Gain</span>
                        <strong style="color: #4CAF50;">164g (0.9 g/lb | 2.0 g/kg)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Athletic Performance</span>
                        <strong>146g (0.8 g/lb | 1.8 g/kg)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Endurance Training</span>
                        <strong>128g (0.7 g/lb | 1.6 g/kg)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>High Protein Foods (per serving)</h3>
                    <div class="breakdown-item">
                        <span>Chicken Breast (4 oz)</span>
                        <strong style="color: #4CAF50;">35g protein</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lean Beef (4 oz)</span>
                        <strong>32g protein</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Salmon (4 oz)</span>
                        <strong>29g protein</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Eggs (2 large)</span>
                        <strong>12g protein</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Greek Yogurt (1 cup)</span>
                        <strong>20g protein</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cottage Cheese (1 cup)</span>
                        <strong>28g protein</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Protein Powder (1 scoop)</span>
                        <strong>20-30g protein</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tofu (4 oz)</span>
                        <strong>10g protein</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lentils (1 cup cooked)</span>
                        <strong>18g protein</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Almonds (1/4 cup)</span>
                        <strong>8g protein</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Protein Needs</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>What is Protein?</strong> Essential macronutrient made of amino acids. Builds/repairs muscle, organs, enzymes, hormones. Cannot be stored - must consume daily.</p>
                        <p><strong>RDA (Recommended Daily Allowance):</strong> 0.36 g/lb (0.8 g/kg) - minimum to prevent deficiency. Not optimal for active people or athletes.</p>
                        <p><strong>Active/Athletic:</strong> 0.7-1.0 g/lb (1.6-2.2 g/kg) - supports exercise, recovery, muscle maintenance. Most fitness enthusiasts need this range.</p>
                        <p><strong>Muscle Building:</strong> 0.8-1.2 g/lb (1.8-2.4 g/kg) - optimal for muscle growth. Combined with resistance training and calorie surplus.</p>
                        <p><strong>Fat Loss:</strong> 1.0-1.2 g/lb (2.2-2.6 g/kg) - higher protein preserves muscle during calorie deficit. Increases satiety, boosts metabolism.</p>
                        <p><strong>Calories:</strong> Protein = 4 calories per gram. Same as carbs, less than fat (9 cal/g).</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Benefits of Adequate Protein</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Muscle Growth & Repair:</strong> Provides amino acids for muscle protein synthesis. Essential after workouts. Prevents muscle breakdown.</p>
                        <p>&#10003; <strong>Weight Management:</strong> High satiety - keeps you full longer. Reduces hunger, cravings. Higher thermic effect than carbs/fat (burns more calories to digest).</p>
                        <p>&#10003; <strong>Metabolism Boost:</strong> 20-30% of protein calories burned during digestion (vs 5-10% carbs, 0-3% fat). Preserves metabolic rate during weight loss.</p>
                        <p>&#10003; <strong>Bone Health:</strong> Supports bone density. Higher protein linked to better bone health in older adults. Myth: protein doesn't weaken bones.</p>
                        <p>&#10003; <strong>Immune Function:</strong> Antibodies are proteins. Adequate intake supports immune system. Prevents illness.</p>
                        <p>&#10003; <strong>Recovery:</strong> Faster recovery from workouts, injuries. Reduces muscle soreness (DOMS). Critical for athletes.</p>
                        <p>&#10003; <strong>Hormone Production:</strong> Many hormones are proteins or require amino acids. Supports testosterone, growth hormone, insulin.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Protein Timing & Distribution</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Spread Throughout Day:</strong> Body can only use 20-40g protein per meal for muscle building. Excess used for energy or stored as fat. Distribute evenly across 3-5 meals.</p>
                        <p><strong>Post-Workout (Anabolic Window):</strong> Within 1-2 hours after training. 20-40g protein. Maximizes muscle protein synthesis. Combine with carbs for best results.</p>
                        <p><strong>Before Bed:</strong> Slow-digesting protein (casein, cottage cheese). Prevents overnight muscle breakdown. 20-40g.</p>
                        <p><strong>Breakfast:</strong> Start day with protein. Reduces hunger throughout day. 20-30g minimum.</p>
                        <p><strong>Pre-Workout:</strong> 1-2 hours before. Provides amino acids during workout. Prevents muscle breakdown. 20-30g.</p>
                        <p><strong>Total Matters Most:</strong> Timing optimization is minor. Hitting daily total is most important. Don't stress perfect timing.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Complete vs Incomplete Proteins</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Complete Proteins (All 9 Essential Amino Acids):</strong></p>
                        <p>• Animal sources: Meat, poultry, fish, eggs, dairy</p>
                        <p>• Plant sources: Quinoa, soy (tofu, tempeh, edamame), buckwheat</p>
                        <p>• Best for muscle building - optimal amino acid profile</p>
                        <p><strong>Incomplete Proteins (Missing 1+ Essential Amino Acids):</strong></p>
                        <p>• Most plant proteins: Beans, lentils, nuts, seeds, grains, vegetables</p>
                        <p>• Combine different sources (rice + beans = complete)</p>
                        <p>• Vegetarians/vegans: Eat variety throughout day to get all amino acids</p>
                        <p><strong>Protein Quality (PDCAAS Score):</strong> Whey protein (1.0), Casein (1.0), Egg (1.0), Soy (1.0), Beef (0.92), Pea protein (0.89), Wheat (0.42)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Protein Supplements</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Whey Protein:</strong> Fast-absorbing (30-60 min). Best post-workout. 20-30g per scoop. Rich in BCAAs. Most popular supplement.</p>
                        <p><strong>Casein Protein:</strong> Slow-absorbing (6-8 hours). Best before bed. Prevents muscle breakdown overnight. Good for satiety.</p>
                        <p><strong>Plant Protein:</strong> Pea, rice, hemp blend. Vegan option. 15-25g per scoop. Often lower leucine - may need more.</p>
                        <p><strong>Egg White Protein:</strong> Medium absorption. Lactose-free. Complete amino acid profile. Good alternative to dairy.</p>
                        <p><strong>When to Use:</strong> Convenient, not necessary. Whole foods preferred. Use when: busy schedule, post-workout, travel, struggle hitting targets.</p>
                        <p><strong>How Much:</strong> 1-2 scoops/day maximum. Get majority from whole foods. Supplements are supplement, not replacement.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Common Protein Myths</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>❌ <strong>Myth: High protein damages kidneys.</strong> ✅ Truth: Safe for healthy people. Only concern if pre-existing kidney disease. Stay hydrated.</p>
                        <p>❌ <strong>Myth: Can only absorb 30g per meal.</strong> ✅ Truth: Body absorbs all protein eaten. 30-40g optimal for muscle building per meal, but excess still used for energy.</p>
                        <p>❌ <strong>Myth: Need protein immediately after workout.</strong> ✅ Truth: "Anabolic window" is 24-48 hours, not 30 minutes. Total daily intake matters most.</p>
                        <p>❌ <strong>Myth: Plant protein inferior.</strong> ✅ Truth: Can build muscle on plant protein. Just need more variety and slightly higher amount.</p>
                        <p>❌ <strong>Myth: More protein always better.</strong> ✅ Truth: Diminishing returns above 1.2 g/lb. Excess converted to energy or fat. Balance with carbs/fats.</p>
                        <p>❌ <strong>Myth: Protein makes you bulky.</strong> ✅ Truth: Can't build muscle without resistance training + surplus calories. Protein alone doesn't cause bulk.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Protein Tips:</strong> Protein = 4 cal/g. Essential for muscle, recovery, satiety. RDA = 0.36 g/lb (too low for active people). Active: 0.7-1.0 g/lb. Muscle building: 0.8-1.2 g/lb. Fat loss: 1.0-1.2 g/lb (preserves muscle). Spread across 4-5 meals. 20-40g per meal optimal. Post-workout within 2 hours. Before bed: slow protein. Complete proteins: meat, eggs, dairy, soy. Incomplete: beans, nuts, grains. Combine variety for vegans. Whey = fast. Casein = slow. Supplements convenient, not necessary. High protein safe for healthy kidneys. Drink water. Track daily total. Hit targets consistently. Chicken, fish, eggs, Greek yogurt, cottage cheese, protein powder. Don't fear protein!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('proteinForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateProtein();
        });

        function toggleUnitFields() {
            const unitSystem = unitSystemSelect.value;
            const isImperial = unitSystem === 'imperial';
            
            document.getElementById('weightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('weightMetricGroup').style.display = isImperial ? 'none' : 'block';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateProtein();
        });

        function calculateProtein() {
            const gender = document.getElementById('gender').value;
            const age = parseInt(document.getElementById('age').value) || 30;
            const activityLevel = document.getElementById('activityLevel').value;
            const goal = document.getElementById('goal').value;
            const unitSystem = unitSystemSelect.value;
            
            // Get weight
            let weightKg;
            if (unitSystem === 'imperial') {
                const weightLbs = parseFloat(document.getElementById('weightLbs').value) || 180;
                weightKg = weightLbs / 2.20462;
            } else {
                weightKg = parseFloat(document.getElementById('weightKg').value) || 82;
            }

            const weightLbs = weightKg * 2.20462;

            // Calculate protein based on goal (g per lb bodyweight)
            let proteinPerLb;
            let goalName;
            
            switch(goal) {
                case 'general':
                    proteinPerLb = 0.4;
                    goalName = 'General Health';
                    break;
                case 'maintain':
                    proteinPerLb = 0.6;
                    goalName = 'Maintain Weight';
                    break;
                case 'fat-loss':
                    proteinPerLb = 1.0;
                    goalName = 'Fat Loss';
                    break;
                case 'muscle-gain':
                    proteinPerLb = 0.9;
                    goalName = 'Muscle Gain';
                    break;
                case 'athletic':
                    proteinPerLb = 0.8;
                    goalName = 'Athletic Performance';
                    break;
                case 'endurance':
                    proteinPerLb = 0.7;
                    goalName = 'Endurance Training';
                    break;
            }

            // Adjust for activity level
            const activityMultipliers = {
                'sedentary': 0.9,
                'light': 0.95,
                'moderate': 1.0,
                'active': 1.05,
                'athlete': 1.1
            };
            
            proteinPerLb *= activityMultipliers[activityLevel];

            // Calculate total protein
            const totalProtein = proteinPerLb * weightLbs;
            const proteinPerKg = (totalProtein / weightKg);

            // Calculate protein per meal (4 meals)
            const proteinPerMeal = totalProtein / 4;

            // Calculate calories from protein
            const proteinCalories = totalProtein * 4;

            // Estimate total daily calories (rough estimate)
            const estimatedCalories = gender === 'male' ? 2500 : 2000;
            const proteinPercent = (proteinCalories / estimatedCalories) * 100;

            // Calculate protein for different goals
            const generalProtein = 0.4 * weightLbs;
            const maintainProtein = 0.6 * weightLbs;
            const fatLossProtein = 1.0 * weightLbs;
            const muscleGainProtein = 0.9 * weightLbs;
            const athleticProtein = 0.8 * weightLbs;
            const enduranceProtein = 0.7 * weightLbs;

            // Activity names
            const activityNames = {
                'sedentary': 'Sedentary',
                'light': 'Light',
                'moderate': 'Moderate',
                'active': 'Active',
                'athlete': 'Athlete'
            };

            // Analysis
            let analysis = `Based on your weight of ${weightLbs.toFixed(1)} lbs (${weightKg.toFixed(1)} kg), ${activityNames[activityLevel].toLowerCase()} activity level, and goal of ${goalName.toLowerCase()}, `;
            analysis += `your recommended daily protein intake is ${Math.round(totalProtein)}g. `;
            
            analysis += `This equals ${proteinPerLb.toFixed(2)} grams per pound of bodyweight (${proteinPerKg.toFixed(2)} g/kg), `;
            analysis += `which is optimal for your fitness goal. `;
            
            analysis += `Protein provides ${Math.round(proteinCalories)} calories per day (4 calories per gram), `;
            analysis += `representing approximately ${proteinPercent.toFixed(1)}% of a typical ${estimatedCalories}-calorie diet. `;
            
            if (goal === 'muscle-gain') {
                analysis += `For muscle building, aim for 0.8-1.0 g/lb bodyweight combined with resistance training 3-5x per week and a calorie surplus. `;
                analysis += `Distribute protein across 4-5 meals throughout the day, with ${Math.round(proteinPerMeal)}g per meal. `;
                analysis += `Prioritize complete protein sources like chicken, fish, eggs, and dairy. `;
            } else if (goal === 'fat-loss') {
                analysis += `During fat loss, higher protein intake (1.0+ g/lb) is critical to preserve muscle mass while in a calorie deficit. `;
                analysis += `Protein increases satiety, reducing hunger and cravings. It also has a higher thermic effect, burning more calories during digestion. `;
                analysis += `Combine with resistance training to maintain muscle and metabolism. `;
            } else if (goal === 'general') {
                analysis += `For general health, you're meeting the minimum RDA (0.36 g/lb). However, if you exercise regularly or want to optimize health, consider increasing to 0.6-0.8 g/lb. `;
            }
            
            analysis += `Spread your protein intake evenly throughout the day. `;
            analysis += `Good sources include: chicken breast (35g per 4oz), Greek yogurt (20g per cup), eggs (6g each), salmon (29g per 4oz), and protein powder (20-30g per scoop). `;
            analysis += `Stay hydrated (8-12 glasses water daily) when consuming high protein. `;
            analysis += `Consistency matters most - hit your daily target regularly for best results.`;

            // Update UI
            document.getElementById('proteinResult').textContent = `${Math.round(totalProtein)}g`;
            document.getElementById('totalProtein').textContent = `${Math.round(totalProtein)}g`;
            document.getElementById('perPound').textContent = `${proteinPerLb.toFixed(2)}g/lb`;
            document.getElementById('perKg').textContent = `${proteinPerKg.toFixed(1)}g/kg`;
            document.getElementById('perMeal').textContent = `${Math.round(proteinPerMeal)}g`;

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('ageDisplay').textContent = `${age} years`;
            document.getElementById('weightDisplay').textContent = `${weightLbs.toFixed(1)} lbs (${weightKg.toFixed(1)} kg)`;
            document.getElementById('activityDisplay').textContent = activityNames[activityLevel];
            document.getElementById('goalDisplay').textContent = goalName;

            document.getElementById('dailyProtein').textContent = `${Math.round(totalProtein)}g`;
            document.getElementById('proteinPerLb').textContent = `${proteinPerLb.toFixed(2)} g/lb`;
            document.getElementById('proteinPerKg').textContent = `${proteinPerKg.toFixed(1)} g/kg`;
            document.getElementById('proteinCalories').textContent = `${Math.round(proteinCalories)} calories (4 cal/g)`;
            document.getElementById('proteinPercent').textContent = `${proteinPercent.toFixed(1)}%`;

            document.getElementById('protein4Meals').textContent = `${Math.round(proteinPerMeal)}g per meal`;
            document.getElementById('breakfast').textContent = `${Math.round(proteinPerMeal)}g`;
            document.getElementById('lunch').textContent = `${Math.round(proteinPerMeal)}g`;
            document.getElementById('dinner').textContent = `${Math.round(proteinPerMeal)}g`;
            document.getElementById('snack').textContent = `${Math.round(proteinPerMeal)}g`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateProtein();
        });
    </script>
</body>
</html>