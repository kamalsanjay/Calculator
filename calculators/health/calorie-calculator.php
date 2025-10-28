<?php
/**
 * Calorie Calculator
 * File: calorie-calculator.php
 * Description: Calculate daily calorie needs and goals (Imperial/Metric)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calorie Calculator - Daily Calorie Needs & Goals (Imperial/Metric)</title>
    <meta name="description" content="Free calorie calculator. Calculate daily calorie needs, TDEE, BMR, and macros for weight loss, maintenance, or gain. Supports imperial and metric units.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🍽️ Calorie Calculator</h1>
        <p>Calculate daily calorie needs</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Your Information</h2>
                <form id="calorieForm">
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
                        <label for="weightLbs">Current Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="180" min="50" max="500" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Current Weight (kg)</label>
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
                            <option value="extreme-loss">Extreme Weight Loss (2 lbs/week)</option>
                            <option value="loss">Weight Loss (1 lb/week)</option>
                            <option value="mild-loss">Mild Weight Loss (0.5 lb/week)</option>
                            <option value="maintain" selected>Maintain Weight</option>
                            <option value="mild-gain">Mild Weight Gain (0.5 lb/week)</option>
                            <option value="gain">Weight Gain (1 lb/week)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="macroSplit">Macro Split</label>
                        <select id="macroSplit">
                            <option value="balanced" selected>Balanced (40/30/30)</option>
                            <option value="low-carb">Low Carb (20/40/40)</option>
                            <option value="high-protein">High Protein (30/40/30)</option>
                            <option value="low-fat">Low Fat (50/30/20)</option>
                            <option value="keto">Keto (5/25/70)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Calories</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Calorie Results</h2>
                
                <div class="result-card success">
                    <h3>Daily Calorie Goal</h3>
                    <div class="amount" id="calorieResult">2,790</div>
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
                        <h4>Goal</h4>
                        <div class="value" id="goalDisplay">Maintain</div>
                    </div>
                    <div class="metric-card">
                        <h4>Weekly Change</h4>
                        <div class="value" id="weeklyChange">0 lbs</div>
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
                        <strong id="goalCalc">Maintain Weight</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Calorie Breakdown</h3>
                    <div class="breakdown-item">
                        <span>BMR (Basal Metabolic Rate)</span>
                        <strong id="bmrCalc" style="color: #667eea;">1,800 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Activity Multiplier</span>
                        <strong id="activityMultiplier">1.55x</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>TDEE (Total Daily Energy)</span>
                        <strong id="tdeeCalc" style="color: #667eea;">2,790 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Calorie Adjustment</span>
                        <strong id="adjustment">+0 cal/day</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Daily Calorie Goal</strong></span>
                        <strong id="goalCalories" style="color: #667eea; font-size: 1.2em;">2,790 cal/day</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Macronutrient Goals</h3>
                    <div class="breakdown-item">
                        <span>Macro Split</span>
                        <strong id="macroSplitDisplay">Balanced (40% carbs, 30% protein, 30% fat)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Protein (4 cal/g)</span>
                        <strong id="proteinGrams" style="color: #E91E63;">209g/day (837 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Carbohydrates (4 cal/g)</span>
                        <strong id="carbGrams" style="color: #2196F3;">279g/day (1,116 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fats (9 cal/g)</span>
                        <strong id="fatGrams" style="color: #FF9800;">93g/day (837 cal)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Weight Change Projection</h3>
                    <div class="breakdown-item">
                        <span>Weekly Change</span>
                        <strong id="weeklyChangeCalc">0 lbs/week</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Change</span>
                        <strong id="monthlyChange">0 lbs/month</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>3-Month Projection</span>
                        <strong id="threeMonthChange">0 lbs (180 lbs)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>6-Month Projection</span>
                        <strong id="sixMonthChange">0 lbs (180 lbs)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Meal Planning</h3>
                    <div class="breakdown-item">
                        <span>3 Meals Per Day</span>
                        <strong id="threeMeals">930 cal/meal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>4 Meals Per Day</span>
                        <strong id="fourMeals">698 cal/meal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>5 Meals Per Day</span>
                        <strong id="fiveMeals">558 cal/meal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>6 Meals Per Day</span>
                        <strong id="sixMeals">465 cal/meal</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Alternative Calorie Goals</h3>
                    <div class="breakdown-item">
                        <span>Extreme Loss (-1000 cal)</span>
                        <strong id="extremeLoss" style="color: #f44336;">1,790 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight Loss (-500 cal)</span>
                        <strong id="weightLoss" style="color: #FF9800;">2,290 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mild Loss (-250 cal)</span>
                        <strong id="mildLoss" style="color: #FF9800;">2,540 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Maintain (0 cal)</span>
                        <strong id="maintain" style="color: #4CAF50;">2,790 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mild Gain (+250 cal)</span>
                        <strong id="mildGain" style="color: #2196F3;">3,040 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight Gain (+500 cal)</span>
                        <strong id="weightGain" style="color: #2196F3;">3,290 cal/day</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Macro Split Options Explained</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Balanced (40/30/30):</strong> 40% carbs, 30% protein, 30% fat. Good general split for most people.</p>
                        <p><strong>Low Carb (20/40/40):</strong> 20% carbs, 40% protein, 40% fat. Better insulin control, sustained energy.</p>
                        <p><strong>High Protein (30/40/30):</strong> 30% carbs, 40% protein, 30% fat. Muscle building, satiety, fat loss.</p>
                        <p><strong>Low Fat (50/30/20):</strong> 50% carbs, 30% protein, 20% fat. Athletic performance, high energy needs.</p>
                        <p><strong>Keto (5/25/70):</strong> 5% carbs (~30g), 25% protein, 70% fat. Ketosis, very low carb.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Important Guidelines</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Minimum Calories:</strong> Never go below 1,500 cal/day (men) or 1,200 cal/day (women) without medical supervision.</p>
                        <p><strong>Safe Weight Loss:</strong> 1-2 lbs per week (500-1000 calorie deficit) is safe and sustainable.</p>
                        <p><strong>Never Below BMR:</strong> Eating below your BMR long-term can slow metabolism and cause muscle loss.</p>
                        <p><strong>Protein Minimum:</strong> Aim for 0.8-1g per lb body weight to preserve muscle, especially when cutting.</p>
                        <p><strong>Track Progress:</strong> Weigh weekly at same time. Adjust calories if not seeing expected changes after 2-3 weeks.</p>
                        <p><strong>Water Intake:</strong> Drink at least 64 oz (2 liters) daily, more if active or hot climate.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Calorie Tips:</strong> BMR = calories at rest. TDEE = BMR × activity. 1 lb fat = 3,500 calories. 500 cal deficit = 1 lb loss/week. Track calories consistently. Weigh food for accuracy. Protein = 4 cal/g. Carbs = 4 cal/g. Fat = 9 cal/g. Alcohol = 7 cal/g. Never below 1,200-1,500 cal/day. Adjust every 2-3 weeks. Cheat meals OK occasionally. Focus on whole foods. Meal timing less important than total. Sleep affects hunger hormones. Stress increases cortisol and cravings. Be patient - sustainable progress!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('calorieForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateCalories();
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
            calculateCalories();
        });

        function calculateCalories() {
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

            // Apply goal adjustment
            let adjustment = 0;
            let weeklyChange = 0;
            let goalName = '';
            
            switch(goal) {
                case 'extreme-loss':
                    adjustment = -1000;
                    weeklyChange = -2;
                    goalName = 'Extreme Weight Loss';
                    break;
                case 'loss':
                    adjustment = -500;
                    weeklyChange = -1;
                    goalName = 'Weight Loss';
                    break;
                case 'mild-loss':
                    adjustment = -250;
                    weeklyChange = -0.5;
                    goalName = 'Mild Weight Loss';
                    break;
                case 'maintain':
                    adjustment = 0;
                    weeklyChange = 0;
                    goalName = 'Maintain Weight';
                    break;
                case 'mild-gain':
                    adjustment = 250;
                    weeklyChange = 0.5;
                    goalName = 'Mild Weight Gain';
                    break;
                case 'gain':
                    adjustment = 500;
                    weeklyChange = 1;
                    goalName = 'Weight Gain';
                    break;
            }

            const goalCalories = Math.max(gender === 'male' ? 1500 : 1200, tdee + adjustment);

            // Get macro split
            let carbPercent, proteinPercent, fatPercent, macroName;
            
            switch(macroSplit) {
                case 'balanced':
                    carbPercent = 0.40;
                    proteinPercent = 0.30;
                    fatPercent = 0.30;
                    macroName = 'Balanced (40/30/30)';
                    break;
                case 'low-carb':
                    carbPercent = 0.20;
                    proteinPercent = 0.40;
                    fatPercent = 0.40;
                    macroName = 'Low Carb (20/40/40)';
                    break;
                case 'high-protein':
                    carbPercent = 0.30;
                    proteinPercent = 0.40;
                    fatPercent = 0.30;
                    macroName = 'High Protein (30/40/30)';
                    break;
                case 'low-fat':
                    carbPercent = 0.50;
                    proteinPercent = 0.30;
                    fatPercent = 0.20;
                    macroName = 'Low Fat (50/30/20)';
                    break;
                case 'keto':
                    carbPercent = 0.05;
                    proteinPercent = 0.25;
                    fatPercent = 0.70;
                    macroName = 'Keto (5/25/70)';
                    break;
            }

            // Calculate macros
            const proteinCal = goalCalories * proteinPercent;
            const carbCal = goalCalories * carbPercent;
            const fatCal = goalCalories * fatPercent;
            
            const proteinGrams = proteinCal / 4;
            const carbGrams = carbCal / 4;
            const fatGrams = fatCal / 9;

            // Weight projections
            const weightLbs = weightKg * 2.20462;
            const monthlyChange = weeklyChange * 4;
            const threeMonthChange = weeklyChange * 12;
            const sixMonthChange = weeklyChange * 24;
            
            const threeMonthWeight = weightLbs + threeMonthChange;
            const sixMonthWeight = weightLbs + sixMonthChange;

            // Meal planning
            const threeMeals = goalCalories / 3;
            const fourMeals = goalCalories / 4;
            const fiveMeals = goalCalories / 5;
            const sixMeals = goalCalories / 6;

            // Alternative goals
            const extremeLoss = Math.max(gender === 'male' ? 1500 : 1200, tdee - 1000);
            const weightLoss = Math.max(gender === 'male' ? 1500 : 1200, tdee - 500);
            const mildLoss = tdee - 250;
            const maintain = tdee;
            const mildGain = tdee + 250;
            const weightGain = tdee + 500;

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
            const displayHeight = unitSystem === 'imperial' ? 
                `${Math.floor(heightInches / 12)}'${(heightInches % 12).toFixed(0)}"` : 
                `${heightCm.toFixed(1)} cm`;
            const displayWeight = unitSystem === 'imperial' ? 
                `${weightLbs.toFixed(1)} lbs` : 
                `${weightKg.toFixed(1)} kg`;
            const weightUnit = unitSystem === 'imperial' ? 'lbs' : 'kg';
            const convertWeight = (lbs) => unitSystem === 'imperial' ? lbs : lbs / 2.20462;

            // Analysis
            let analysis = `Your Basal Metabolic Rate (BMR) is ${Math.round(bmr)} calories per day. `;
            analysis += `With your ${activityNames[activityLevel.toString()]} activity level, your Total Daily Energy Expenditure (TDEE) is ${Math.round(tdee)} calories. `;
            analysis += `To achieve your goal of "${goalName}", you should consume approximately ${Math.round(goalCalories)} calories per day. `;
            
            if (weeklyChange < 0) {
                analysis += `This ${Math.abs(adjustment)} calorie deficit will result in approximately ${Math.abs(weeklyChange)} ${weightUnit === 'lbs' ? 'lb' : 'kg'} weight loss per week. `;
                analysis += `In 3 months, you could reach ${convertWeight(threeMonthWeight).toFixed(1)} ${weightUnit}. `;
            } else if (weeklyChange > 0) {
                analysis += `This ${adjustment} calorie surplus will result in approximately ${weeklyChange} ${weightUnit === 'lbs' ? 'lb' : 'kg'} weight gain per week. `;
                analysis += `In 3 months, you could reach ${convertWeight(threeMonthWeight).toFixed(1)} ${weightUnit}. `;
            } else {
                analysis += `This will maintain your current weight of ${displayWeight}. `;
            }
            
            analysis += `Your macros should be approximately ${Math.round(proteinGrams)}g protein, ${Math.round(carbGrams)}g carbs, and ${Math.round(fatGrams)}g fat per day.`;

            // Update UI
            document.getElementById('calorieResult').textContent = Math.round(goalCalories).toLocaleString();
            document.getElementById('bmrDisplay').textContent = Math.round(bmr).toLocaleString();
            document.getElementById('tdeeDisplay').textContent = Math.round(tdee).toLocaleString();
            document.getElementById('goalDisplay').textContent = goalName.split(' ')[0];
            document.getElementById('weeklyChange').textContent = weeklyChange !== 0 ? 
                `${weeklyChange > 0 ? '+' : ''}${convertWeight(weeklyChange).toFixed(1)} ${weightUnit}` : 
                '0 ' + weightUnit;

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('ageDisplay').textContent = `${age} years`;
            document.getElementById('heightDisplay').textContent = displayHeight;
            document.getElementById('weightDisplay').textContent = displayWeight;
            document.getElementById('activityDisplay').textContent = activityNames[activityLevel.toString()];
            document.getElementById('goalCalc').textContent = goalName;

            document.getElementById('bmrCalc').textContent = `${Math.round(bmr).toLocaleString()} cal/day`;
            document.getElementById('activityMultiplier').textContent = `${activityLevel}x`;
            document.getElementById('tdeeCalc').textContent = `${Math.round(tdee).toLocaleString()} cal/day`;
            document.getElementById('adjustment').textContent = adjustment !== 0 ? 
                `${adjustment > 0 ? '+' : ''}${adjustment} cal/day` : 
                '±0 cal/day';
            document.getElementById('goalCalories').textContent = `${Math.round(goalCalories).toLocaleString()} cal/day`;

            document.getElementById('macroSplitDisplay').textContent = macroName;
            document.getElementById('proteinGrams').textContent = `${Math.round(proteinGrams)}g/day (${Math.round(proteinCal)} cal)`;
            document.getElementById('carbGrams').textContent = `${Math.round(carbGrams)}g/day (${Math.round(carbCal)} cal)`;
            document.getElementById('fatGrams').textContent = `${Math.round(fatGrams)}g/day (${Math.round(fatCal)} cal)`;

            document.getElementById('weeklyChangeCalc').textContent = weeklyChange !== 0 ? 
                `${weeklyChange > 0 ? '+' : ''}${convertWeight(weeklyChange).toFixed(1)} ${weightUnit}/week` : 
                '0 ' + weightUnit + '/week';
            document.getElementById('monthlyChange').textContent = monthlyChange !== 0 ? 
                `${monthlyChange > 0 ? '+' : ''}${convertWeight(monthlyChange).toFixed(1)} ${weightUnit}/month` : 
                '0 ' + weightUnit + '/month';
            document.getElementById('threeMonthChange').textContent = threeMonthChange !== 0 ? 
                `${threeMonthChange > 0 ? '+' : ''}${convertWeight(threeMonthChange).toFixed(1)} ${weightUnit} (${convertWeight(threeMonthWeight).toFixed(1)} ${weightUnit})` : 
                `0 ${weightUnit} (${displayWeight})`;
            document.getElementById('sixMonthChange').textContent = sixMonthChange !== 0 ? 
                `${sixMonthChange > 0 ? '+' : ''}${convertWeight(sixMonthChange).toFixed(1)} ${weightUnit} (${convertWeight(sixMonthWeight).toFixed(1)} ${weightUnit})` : 
                `0 ${weightUnit} (${displayWeight})`;

            document.getElementById('threeMeals').textContent = `${Math.round(threeMeals)} cal/meal`;
            document.getElementById('fourMeals').textContent = `${Math.round(fourMeals)} cal/meal`;
            document.getElementById('fiveMeals').textContent = `${Math.round(fiveMeals)} cal/meal`;
            document.getElementById('sixMeals').textContent = `${Math.round(sixMeals)} cal/meal`;

            document.getElementById('extremeLoss').textContent = `${Math.round(extremeLoss).toLocaleString()} cal/day`;
            document.getElementById('weightLoss').textContent = `${Math.round(weightLoss).toLocaleString()} cal/day`;
            document.getElementById('mildLoss').textContent = `${Math.round(mildLoss).toLocaleString()} cal/day`;
            document.getElementById('maintain').textContent = `${Math.round(maintain).toLocaleString()} cal/day`;
            document.getElementById('mildGain').textContent = `${Math.round(mildGain).toLocaleString()} cal/day`;
            document.getElementById('weightGain').textContent = `${Math.round(weightGain).toLocaleString()} cal/day`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateCalories();
        });
    </script>
</body>
</html>