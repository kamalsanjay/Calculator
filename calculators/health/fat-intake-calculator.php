<?php
/**
 * Fat Intake Calculator
 * File: fat-intake-calculator.php
 * Description: Calculate daily fat needs and optimal fat intake for health goals
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fat Intake Calculator - Daily Fat Needs & Healthy Fat Goals</title>
    <meta name="description" content="Free fat intake calculator. Calculate daily fat needs, optimal fat intake for weight loss, muscle gain, or maintenance. Understand healthy fats vs unhealthy fats.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🥑 Fat Intake Calculator</h1>
        <p>Calculate daily fat needs</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Your Information</h2>
                <form id="fatForm">
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
                            <option value="standard" selected>Standard (25-35% fat)</option>
                            <option value="low-fat">Low Fat (20-25% fat)</option>
                            <option value="moderate">Moderate Fat (30-35% fat)</option>
                            <option value="high-fat">High Fat (35-45% fat)</option>
                            <option value="keto">Ketogenic (65-75% fat)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Fat Intake</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Fat Intake Results</h2>
                
                <div class="result-card success">
                    <h3>Daily Fat Goal</h3>
                    <div class="amount" id="fatResult">84g</div>
                    <div style="margin-top: 10px; font-size: 1em;">per day</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Fat</h4>
                        <div class="value" id="fatDisplay">84g</div>
                    </div>
                    <div class="metric-card">
                        <h4>Saturated</h4>
                        <div class="value" id="saturatedDisplay">28g</div>
                    </div>
                    <div class="metric-card">
                        <h4>Unsaturated</h4>
                        <div class="value" id="unsaturatedDisplay">56g</div>
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
                        <strong id="dietDisplay">Standard</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Daily Fat Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Total Daily Calories</span>
                        <strong id="totalCalories" style="color: #667eea; font-size: 1.1em;">2,790 cal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Fat (30%)</span>
                        <strong id="totalFat" style="color: #FF9800;">84g (753 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Saturated Fat (≤10%)</span>
                        <strong id="saturatedFat" style="color: #f44336;">≤28g (≤248 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Unsaturated Fat (20%)</span>
                        <strong id="unsaturatedFat" style="color: #4CAF50;">56g (505 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Trans Fat</span>
                        <strong style="color: #f44336;">Avoid completely</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Fat Type Distribution</h3>
                    <div class="breakdown-item">
                        <span>Monounsaturated Fat (MUFA)</span>
                        <strong id="monounsaturated">45g (15-20% of calories)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Polyunsaturated Fat (PUFA)</span>
                        <strong id="polyunsaturated">31g (10-15% of calories)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Omega-3 Fatty Acids</span>
                        <strong id="omega3">2-3g (EPA + DHA)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Omega-6 Fatty Acids</span>
                        <strong id="omega6">12-17g</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Fat Intake by Diet Type</h3>
                    <div class="breakdown-item">
                        <span>Low Fat (20% fat)</span>
                        <strong id="lowFat">62g fat</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Standard (30% fat)</span>
                        <strong id="standardFat" style="color: #4CAF50;">84g fat</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Moderate Fat (35% fat)</span>
                        <strong id="moderateFat">97g fat</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>High Fat (40% fat)</span>
                        <strong id="highFat">111g fat</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ketogenic (70% fat)</span>
                        <strong id="ketoFat">195g fat</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Meal Distribution (3 meals)</h3>
                    <div class="breakdown-item">
                        <span>Fat per Meal</span>
                        <strong id="fatPerMeal">28g per meal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Breakfast</span>
                        <strong id="breakfast">28g fat</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lunch</span>
                        <strong id="lunch">28g fat</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Dinner</span>
                        <strong id="dinner">28g fat</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Types of Dietary Fats</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong style="color: #4CAF50;">Healthy Fats (Unsaturated):</strong></p>
                        <p><strong>Monounsaturated (MUFA):</strong> Olive oil, avocados, nuts (almonds, cashews), peanut butter. Improves cholesterol, reduces inflammation.</p>
                        <p><strong>Polyunsaturated (PUFA):</strong> Fatty fish (salmon, mackerel), walnuts, flaxseeds, chia seeds, sunflower oil. Essential for brain and heart health.</p>
                        <p><strong>Omega-3:</strong> EPA/DHA from fish, ALA from flaxseeds/walnuts. Anti-inflammatory, heart protective, brain development.</p>
                        <p><strong style="color: #FF9800;">Limit (Saturated Fats):</strong></p>
                        <p>Red meat, butter, cheese, cream, coconut oil, palm oil. Raises LDL cholesterol. Limit to &lt;10% of calories.</p>
                        <p><strong style="color: #f44336;">Avoid (Trans Fats):</strong></p>
                        <p>Partially hydrogenated oils, fried foods, baked goods, margarine (older types). Increases LDL, decreases HDL. AVOID completely.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Best Sources of Healthy Fats</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Oils & Cooking Fats:</strong></p>
                        <p>• Olive oil (15g fat per tbsp) - best for cooking & dressings</p>
                        <p>• Avocado oil (14g per tbsp) - high smoke point</p>
                        <p>• Coconut oil (14g per tbsp) - saturated, use moderately</p>
                        <p><strong>Nuts & Seeds:</strong></p>
                        <p>• Almonds (14g per oz/23 nuts)</p>
                        <p>• Walnuts (18g per oz/14 halves) - high omega-3</p>
                        <p>• Chia seeds (9g per oz/2 tbsp) - omega-3 rich</p>
                        <p>• Flaxseeds (12g per oz/3 tbsp ground)</p>
                        <p><strong>Fatty Fish (Omega-3):</strong></p>
                        <p>• Salmon (13g per 3 oz)</p>
                        <p>• Mackerel (15g per 3 oz)</p>
                        <p>• Sardines (11g per 3 oz)</p>
                        <p><strong>Other Sources:</strong></p>
                        <p>• Avocado (21g per medium avocado)</p>
                        <p>• Eggs (5g per large egg)</p>
                        <p>• Dark chocolate (12g per oz - 70%+ cacao)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Fat Intake Guidelines</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>General Recommendations:</strong></p>
                        <p>• Total Fat: 20-35% of daily calories (standard diet)</p>
                        <p>• Saturated Fat: &lt;10% of daily calories</p>
                        <p>• Trans Fat: Avoid completely (0g)</p>
                        <p>• Omega-3: At least 250-500 mg EPA+DHA daily</p>
                        <p>• Omega-6 to Omega-3 Ratio: Aim for 4:1 or less</p>
                        <p><strong>By Goal:</strong></p>
                        <p>• Weight Loss: 20-30% fat (prioritize protein & fiber)</p>
                        <p>• Maintenance: 25-35% fat (balanced macros)</p>
                        <p>• Muscle Gain: 20-30% fat (prioritize protein first)</p>
                        <p>• Keto/Low-Carb: 60-75% fat (very low carb, moderate protein)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Benefits of Healthy Fats</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Heart Health:</strong> Lowers LDL, raises HDL, reduces inflammation</p>
                        <p>&#10003; <strong>Brain Function:</strong> Essential for cognitive function, memory, mood</p>
                        <p>&#10003; <strong>Hormone Production:</strong> Required for testosterone, estrogen, other hormones</p>
                        <p>&#10003; <strong>Vitamin Absorption:</strong> Vitamins A, D, E, K need fat to be absorbed</p>
                        <p>&#10003; <strong>Satiety:</strong> Fat keeps you full longer, reduces cravings</p>
                        <p>&#10003; <strong>Cell Structure:</strong> Fat is essential for cell membrane integrity</p>
                        <p>&#10003; <strong>Anti-Inflammatory:</strong> Omega-3s reduce inflammation throughout body</p>
                        <p>&#10003; <strong>Skin & Hair:</strong> Healthy fats improve skin elasticity and hair health</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Cooking with Fats</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>High Heat Cooking (400°F+):</strong></p>
                        <p>• Avocado oil (smoke point: 520°F)</p>
                        <p>• Refined olive oil (465°F)</p>
                        <p>• Ghee (485°F)</p>
                        <p><strong>Medium Heat (350-400°F):</strong></p>
                        <p>• Extra virgin olive oil (375°F)</p>
                        <p>• Coconut oil (350°F)</p>
                        <p>• Butter (350°F)</p>
                        <p><strong>Low Heat/No Heat:</strong></p>
                        <p>• Flaxseed oil (salads only, don't heat)</p>
                        <p>• Walnut oil (dressings, don't heat)</p>
                        <p><strong>Avoid Reusing:</strong> Don't reuse oils multiple times - oxidation creates harmful compounds</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Fat vs. Carbs Debate</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Low-Fat Diet (20-25% fat):</strong> Higher carbs. Good for: Athletes, active people, those who don't like fatty foods. Requires whole grains & fiber.</p>
                        <p><strong>Balanced Diet (25-35% fat):</strong> Moderate carbs. Good for: Most people, general health, sustainable long-term. Flexible and balanced.</p>
                        <p><strong>High-Fat Diet (35-45% fat):</strong> Lower carbs. Good for: Blood sugar control, sustained energy, appetite control. Not necessarily keto.</p>
                        <p><strong>Ketogenic Diet (65-75% fat):</strong> Very low carb (&lt;50g). Good for: Epilepsy, weight loss, metabolic conditions. Medical supervision recommended.</p>
                        <p><strong>Bottom Line:</strong> Fat doesn't make you fat - excess calories do. Both low-fat and high-fat diets can work if calories are controlled. Choose what's sustainable for YOU.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Fat Tips:</strong> Fat = 9 cal/gram (most calorie-dense). Total fat = 20-35% calories. Saturated fat &lt;10%. Trans fat = 0g (avoid). Omega-3 = anti-inflammatory. Omega-6 = pro-inflammatory (need balance). MUFA = heart healthy (olive oil). PUFA = essential (fish, nuts). Fat needed for hormones & vitamins A,D,E,K. Fat ≠ makes you fat. Excess calories = fat gain. Low-fat not always better. Quality matters more than quantity. Avocados = healthy fat. Fried food = unhealthy fat. Nuts = great snack. Fish 2x/week. Cook with olive/avocado oil. Fat keeps you full. Don't fear fat!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('fatForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateFat();
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
            calculateFat();
        });

        function calculateFat() {
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

            // Get fat percentage based on diet type
            let fatPercent, dietName;
            
            switch(dietType) {
                case 'low-fat':
                    fatPercent = 0.20;
                    dietName = 'Low Fat (20%)';
                    break;
                case 'standard':
                    fatPercent = 0.30;
                    dietName = 'Standard (30%)';
                    break;
                case 'moderate':
                    fatPercent = 0.35;
                    dietName = 'Moderate Fat (35%)';
                    break;
                case 'high-fat':
                    fatPercent = 0.40;
                    dietName = 'High Fat (40%)';
                    break;
                case 'keto':
                    fatPercent = 0.70;
                    dietName = 'Ketogenic (70%)';
                    break;
            }

            // Calculate fat
            const fatCalories = calories * fatPercent;
            const fatGrams = fatCalories / 9;
            
            // Saturated fat (max 10% of calories)
            const saturatedCalories = calories * 0.10;
            const saturatedGrams = saturatedCalories / 9;
            
            // Unsaturated fat (remaining)
            const unsaturatedGrams = fatGrams - saturatedGrams;
            
            // MUFA and PUFA distribution
            const mufaPercent = 0.15; // 15% of calories
            const pufaPercent = 0.10; // 10% of calories
            const mufaGrams = (calories * mufaPercent) / 9;
            const pufaGrams = (calories * pufaPercent) / 9;
            
            // Omega-3 and Omega-6
            const omega3Grams = "2-3"; // recommended range
            const omega6Grams = (pufaGrams * 0.8).toFixed(0) + "-" + (pufaGrams).toFixed(0);

            // Different diet types
            const lowFatGrams = (calories * 0.20) / 9;
            const standardFatGrams = (calories * 0.30) / 9;
            const moderateFatGrams = (calories * 0.35) / 9;
            const highFatGrams = (calories * 0.40) / 9;
            const ketoFatGrams = (calories * 0.70) / 9;

            // Meal distribution
            const fatPerMeal = fatGrams / 3;

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
            let analysis = `For your goal of "${goalName}" on a ${dietName} diet, you should consume approximately ${Math.round(fatGrams)}g of fat per day. `;
            analysis += `This represents ${(fatPercent * 100).toFixed(0)}% of your ${Math.round(calories)} daily calories (${Math.round(fatCalories)} calories from fat). `;
            analysis += `Focus on healthy unsaturated fats (about ${Math.round(unsaturatedGrams)}g) from sources like olive oil, avocados, nuts, and fatty fish. `;
            analysis += `Limit saturated fat to no more than ${Math.round(saturatedGrams)}g per day (10% of calories) from sources like red meat, butter, and cheese. `;
            analysis += `Completely avoid trans fats found in fried foods and processed baked goods. `;
            
            if (dietType === 'keto') {
                analysis += `On a ketogenic diet, fat is your primary fuel source. Include plenty of MCT oil, coconut oil, butter, fatty fish, and avocados. Keep carbs under 50g/day. `;
            } else if (dietType === 'low-fat') {
                analysis += `On a low-fat diet, prioritize the fats you do eat - choose omega-3 rich fish, nuts, and olive oil. Fill remaining calories with complex carbs and protein. `;
            } else {
                analysis += `A balanced approach to fat intake supports hormone production, vitamin absorption, and satiety. Aim for 2-3 servings of fatty fish per week for omega-3s. `;
            }
            
            analysis += `Remember: dietary fat doesn't directly make you fat - excess calories do. Quality matters more than quantity!`;

            // Update UI
            document.getElementById('fatResult').textContent = `${Math.round(fatGrams)}g`;
            document.getElementById('fatDisplay').textContent = `${Math.round(fatGrams)}g`;
            document.getElementById('saturatedDisplay').textContent = `≤${Math.round(saturatedGrams)}g`;
            document.getElementById('unsaturatedDisplay').textContent = `${Math.round(unsaturatedGrams)}g`;
            document.getElementById('caloriesDisplay').textContent = Math.round(calories).toLocaleString();

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('ageDisplay').textContent = `${age} years`;
            document.getElementById('heightDisplay').textContent = displayHeight;
            document.getElementById('weightDisplay').textContent = displayWeight;
            document.getElementById('activityDisplay').textContent = activityNames[activityLevel.toString()];
            document.getElementById('goalDisplay').textContent = goalName;
            document.getElementById('dietDisplay').textContent = dietName;

            document.getElementById('totalCalories').textContent = `${Math.round(calories).toLocaleString()} cal`;
            document.getElementById('totalFat').textContent = `${Math.round(fatGrams)}g (${Math.round(fatCalories)} cal)`;
            document.getElementById('saturatedFat').textContent = `≤${Math.round(saturatedGrams)}g (≤${Math.round(saturatedCalories)} cal)`;
            document.getElementById('unsaturatedFat').textContent = `${Math.round(unsaturatedGrams)}g (${Math.round(fatCalories - saturatedCalories)} cal)`;

            document.getElementById('monounsaturated').textContent = `${Math.round(mufaGrams)}g (15-20% of calories)`;
            document.getElementById('polyunsaturated').textContent = `${Math.round(pufaGrams)}g (10-15% of calories)`;
            document.getElementById('omega3').textContent = `${omega3Grams}g (EPA + DHA)`;
            document.getElementById('omega6').textContent = `${omega6Grams}g`;

            document.getElementById('lowFat').textContent = `${Math.round(lowFatGrams)}g fat`;
            document.getElementById('standardFat').textContent = `${Math.round(standardFatGrams)}g fat`;
            document.getElementById('moderateFat').textContent = `${Math.round(moderateFatGrams)}g fat`;
            document.getElementById('highFat').textContent = `${Math.round(highFatGrams)}g fat`;
            document.getElementById('ketoFat').textContent = `${Math.round(ketoFatGrams)}g fat`;

            document.getElementById('fatPerMeal').textContent = `${Math.round(fatPerMeal)}g per meal`;
            document.getElementById('breakfast').textContent = `${Math.round(fatPerMeal)}g fat`;
            document.getElementById('lunch').textContent = `${Math.round(fatPerMeal)}g fat`;
            document.getElementById('dinner').textContent = `${Math.round(fatPerMeal)}g fat`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateFat();
        });
    </script>
</body>
</html>