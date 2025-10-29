<?php
/**
 * TDEE Calculator
 * File: tdee-calculator.php
 * Description: Calculate Total Daily Energy Expenditure (TDEE), BMR, and calorie goals
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TDEE Calculator - Total Daily Energy Expenditure & Calorie Calculator</title>
    <meta name="description" content="Free TDEE calculator. Calculate your Total Daily Energy Expenditure, BMR, and daily calorie needs for weight loss, maintenance, or muscle gain.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🔥 TDEE Calculator</h1>
        <p>Calculate daily calorie needs</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Your Information</h2>
                <form id="tdeeForm">
                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="imperial">Imperial (lbs/inches)</option>
                            <option value="metric">Metric (kg/cm)</option>
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
                        <input type="number" id="weightLbs" value="180" min="70" max="500" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="82" min="30" max="250" step="0.1">
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Activity & Goals</h3>
                    
                    <div class="form-group">
                        <label for="activityLevel">Activity Level</label>
                        <select id="activityLevel">
                            <option value="1.2">Sedentary (little/no exercise)</option>
                            <option value="1.375">Lightly Active (exercise 1-3 days/week)</option>
                            <option value="1.55" selected>Moderately Active (exercise 3-5 days/week)</option>
                            <option value="1.725">Very Active (exercise 6-7 days/week)</option>
                            <option value="1.9">Extra Active (physical job + exercise daily)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="goal">Goal</label>
                        <select id="goal">
                            <option value="extreme-loss">Extreme Weight Loss (-2 lbs/week)</option>
                            <option value="loss">Weight Loss (-1 lb/week)</option>
                            <option value="mild-loss">Mild Weight Loss (-0.5 lb/week)</option>
                            <option value="maintain" selected>Maintain Weight</option>
                            <option value="mild-gain">Mild Weight Gain (+0.5 lb/week)</option>
                            <option value="gain">Weight Gain (+1 lb/week)</option>
                            <option value="extreme-gain">Extreme Weight Gain (+2 lbs/week)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate TDEE</button>
                </form>
            </div>

            <div class="results-section">
                <h2>TDEE Results</h2>
                
                <div class="result-card success" id="resultCard">
                    <h3 id="resultTitle">Daily Calorie Target</h3>
                    <div class="amount" id="tdeeResult">2,400 calories</div>
                    <div style="margin-top: 10px; font-size: 1em;" id="goalSubtitle">To maintain current weight</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>BMR</h4>
                        <div class="value" id="bmrDisplay">1,800</div>
                    </div>
                    <div class="metric-card">
                        <h4>TDEE</h4>
                        <div class="value" id="tdeeDisplay">2,400</div>
                    </div>
                    <div class="metric-card">
                        <h4>Daily Goal</h4>
                        <div class="value" id="goalDisplay">2,400</div>
                    </div>
                    <div class="metric-card">
                        <h4>Change/Week</h4>
                        <div class="value" id="weeklyChangeDisplay">0 lbs</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Profile</h3>
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
                        <strong id="heightDisplay">5'10" (178 cm)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight</span>
                        <strong id="weightDisplay">180 lbs (82 kg)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI</span>
                        <strong id="bmiDisplay" style="color: #4CAF50;">25.8 (Normal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Activity Level</span>
                        <strong id="activityDisplay">Moderately Active</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Calorie Breakdown</h3>
                    <div class="breakdown-item">
                        <span>BMR (Basal Metabolic Rate)</span>
                        <strong id="bmrValue" style="color: #667eea;">1,800 calories</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>TDEE (Total Daily Energy)</span>
                        <strong id="tdeeValue" style="color: #4CAF50;">2,400 calories</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Daily Calorie Goal</span>
                        <strong id="dailyGoal" style="color: #FF9800; font-size: 1.05em;">2,400 calories</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekly Calorie Adjustment</span>
                        <strong id="weeklyAdjustment">0 calories (maintain)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Calorie Goals by Target</h3>
                    <div class="breakdown-item">
                        <span>Extreme Loss (-2 lbs/week)</span>
                        <strong id="extremeLoss" style="color: #f44336;">1,400 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight Loss (-1 lb/week)</span>
                        <strong id="weightLoss" style="color: #FF9800;">1,900 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mild Loss (-0.5 lb/week)</span>
                        <strong id="mildLoss">2,150 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Maintain Weight</span>
                        <strong id="maintain" style="color: #4CAF50;">2,400 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mild Gain (+0.5 lb/week)</span>
                        <strong id="mildGain">2,650 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight Gain (+1 lb/week)</span>
                        <strong id="weightGain" style="color: #2196F3;">2,900 cal/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Extreme Gain (+2 lbs/week)</span>
                        <strong id="extremeGain" style="color: #2196F3;">3,400 cal/day</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Macronutrient Recommendations</h3>
                    <div class="breakdown-item">
                        <span>Protein (30%)</span>
                        <strong id="proteinMacro" style="color: #E91E63;">180g (720 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Carbohydrates (40%)</span>
                        <strong id="carbsMacro" style="color: #FF9800;">240g (960 cal)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fat (30%)</span>
                        <strong id="fatMacro" style="color: #4CAF50;">80g (720 cal)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding TDEE & BMR</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>BMR (Basal Metabolic Rate):</strong> Calories your body burns at complete rest. Breathing, circulation, cell production, nutrient processing. If you laid in bed all day doing nothing.</p>
                        <p><strong>TDEE (Total Daily Energy Expenditure):</strong> BMR + activity calories. Total calories burned per day including exercise, work, daily activities. What you actually burn.</p>
                        <p><strong>Formula:</strong> TDEE = BMR × Activity Multiplier. Higher activity = higher TDEE. Sedentary ×1.2, Moderate ×1.55, Very Active ×1.725.</p>
                        <p><strong>Calorie Deficit = Weight Loss:</strong> Eat below TDEE. 500 cal/day deficit = 1 lb/week loss (3,500 cal = 1 lb fat).</p>
                        <p><strong>Calorie Surplus = Weight Gain:</strong> Eat above TDEE. 500 cal/day surplus = 1 lb/week gain. With resistance training = muscle gain.</p>
                        <p><strong>Maintenance:</strong> Eat at TDEE. Weight stays same. Energy balance.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Weight Loss Guidelines</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Safe Rate:</strong> 0.5-2 lbs per week. 1-1.5 lbs ideal for most. Faster = more muscle loss, harder to sustain.</p>
                        <p><strong>Minimum Calories:</strong> Never below 1,200 (women) or 1,500 (men). Risk of nutrient deficiency, muscle loss, metabolic slowdown.</p>
                        <p><strong>500 Cal Deficit:</strong> Most common approach. TDEE - 500 = 1 lb/week loss. Sustainable, preserves muscle.</p>
                        <p><strong>Protein Priority:</strong> 0.8-1g per lb bodyweight during deficit. Prevents muscle loss. Most important macro.</p>
                        <p><strong>Exercise:</strong> Cardio burns calories (adds to deficit). Strength training preserves muscle. Both important.</p>
                        <p><strong>Track Progress:</strong> Weigh weekly, same time/day. Take measurements. Photos. Scale fluctuates daily (water, food).</p>
                        <p><strong>Adjust:</strong> Recalculate TDEE every 10-15 lbs lost. Smaller body = lower TDEE. Must reduce calories further.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Muscle Gain Guidelines</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Calorie Surplus:</strong> Eat above TDEE. 200-500 cal surplus. More = faster gain but more fat. Lean bulk = small surplus.</p>
                        <p><strong>Realistic Gains:</strong> 0.5-1 lb per week max. 2-4 lbs per month. Beginners faster, advanced slower. Can't rush muscle growth.</p>
                        <p><strong>Protein Critical:</strong> 0.8-1g per lb bodyweight. Builds muscle. Spread throughout day. Post-workout important.</p>
                        <p><strong>Progressive Overload:</strong> Lift heavier over time. Muscle grows in response to stress. Track lifts, increase gradually.</p>
                        <p><strong>Carbs for Energy:</strong> Fuel workouts. 2-3g per lb bodyweight. Post-workout carbs replenish glycogen.</p>
                        <p><strong>Fats for Hormones:</strong> 0.3-0.5g per lb bodyweight. Supports testosterone, recovery. Don't go too low.</p>
                        <p><strong>Bulk & Cut Cycles:</strong> Gain muscle in surplus (bulk). Lose fat in deficit (cut). Can't optimally do both simultaneously.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Macro Basics</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Protein (4 cal/g):</strong> Builds/repairs muscle, organs, enzymes. Most important. 30% of calories (0.8-1g/lb bodyweight).</p>
                        <p><strong>Carbohydrates (4 cal/g):</strong> Primary energy source. Fuels workouts, brain. 40-50% of calories. Adjust based on activity.</p>
                        <p><strong>Fat (9 cal/g):</strong> Hormones, vitamin absorption, cell structure. 25-30% of calories. Don't eliminate.</p>
                        <p><strong>Macro Split:</strong> 30/40/30 (P/C/F) is common balanced split. Adjust: Low-carb diets, athletic needs, preferences.</p>
                        <p><strong>Fat Loss:</strong> High protein (40%), moderate carbs (30%), moderate fat (30%). Protein preserves muscle.</p>
                        <p><strong>Muscle Gain:</strong> High protein (30%), high carbs (45%), moderate fat (25%). Carbs fuel growth.</p>
                        <p><strong>Tracking:</strong> Use MyFitnessPal, Cronometer, LoseIt. Weigh food for accuracy. Focus on protein first.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>TDEE Tips:</strong> TDEE = calories you burn daily. BMR = calories at rest. Eat below TDEE to lose weight. Eat above to gain. 500 cal deficit = 1 lb/week loss. Min 1,200 cal (women), 1,500 (men). High protein during deficit preserves muscle. Track calories with app. Weigh food for accuracy. Recalculate TDEE every 10-15 lbs. Weight fluctuates daily (normal). Track weekly average. Strength training essential during cut. Cardio adds to deficit. Sleep 7-9 hours (affects metabolism). Stay hydrated. Be patient - sustainable &gt; fast. Adjust based on results after 2-4 weeks!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('tdeeForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateTDEE();
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
            calculateTDEE();
        });

        function calculateTDEE() {
            const gender = document.getElementById('gender').value;
            const age = parseInt(document.getElementById('age').value) || 30;
            const activityLevel = parseFloat(document.getElementById('activityLevel').value);
            const goal = document.getElementById('goal').value;
            const unitSystem = unitSystemSelect.value;
            
            let heightCm, weightKg;
            
            if (unitSystem === 'imperial') {
                const feet = parseFloat(document.getElementById('heightFeet').value) || 0;
                const inches = parseFloat(document.getElementById('heightInches').value) || 0;
                const heightInches = (feet * 12) + inches;
                heightCm = heightInches * 2.54;
                
                const weightLbs = parseFloat(document.getElementById('weightLbs').value) || 180;
                weightKg = weightLbs / 2.20462;
            } else {
                heightCm = parseFloat(document.getElementById('heightCm').value) || 178;
                weightKg = parseFloat(document.getElementById('weightKg').value) || 82;
            }

            const heightM = heightCm / 100;
            const bmi = weightKg / (heightM * heightM);

            let bmr;
            if (gender === 'male') {
                bmr = 10 * weightKg + 6.25 * heightCm - 5 * age + 5;
            } else {
                bmr = 10 * weightKg + 6.25 * heightCm - 5 * age - 161;
            }

            const tdee = Math.round(bmr * activityLevel);

            const goalAdjustments = {
                'extreme-loss': -1000,
                'loss': -500,
                'mild-loss': -250,
                'maintain': 0,
                'mild-gain': 250,
                'gain': 500,
                'extreme-gain': 1000
            };

            const goalCalories = Math.round(tdee + goalAdjustments[goal]);
            const weeklyChange = goalAdjustments[goal] / 500;

            const goalNames = {
                'extreme-loss': 'Extreme Weight Loss (-2 lbs/week)',
                'loss': 'Weight Loss (-1 lb/week)',
                'mild-loss': 'Mild Weight Loss (-0.5 lb/week)',
                'maintain': 'Maintain Weight',
                'mild-gain': 'Mild Weight Gain (+0.5 lb/week)',
                'gain': 'Weight Gain (+1 lb/week)',
                'extreme-gain': 'Extreme Weight Gain (+2 lbs/week)'
            };

            const activityNames = {
                '1.2': 'Sedentary',
                '1.375': 'Lightly Active',
                '1.55': 'Moderately Active',
                '1.725': 'Very Active',
                '1.9': 'Extra Active'
            };

            const extremeLoss = Math.round(tdee - 1000);
            const weightLoss = Math.round(tdee - 500);
            const mildLoss = Math.round(tdee - 250);
            const maintain = tdee;
            const mildGain = Math.round(tdee + 250);
            const weightGain = Math.round(tdee + 500);
            const extremeGain = Math.round(tdee + 1000);

            const proteinCal = goalCalories * 0.30;
            const carbsCal = goalCalories * 0.40;
            const fatCal = goalCalories * 0.30;

            const proteinG = Math.round(proteinCal / 4);
            const carbsG = Math.round(carbsCal / 4);
            const fatG = Math.round(fatCal / 9);

            let bmiCategory = '';
            let bmiColor = '#4CAF50';
            if (bmi < 18.5) {
                bmiCategory = 'Underweight';
                bmiColor = '#2196F3';
            } else if (bmi < 25) {
                bmiCategory = 'Normal';
                bmiColor = '#4CAF50';
            } else if (bmi < 30) {
                bmiCategory = 'Overweight';
                bmiColor = '#FF9800';
            } else {
                bmiCategory = 'Obese';
                bmiColor = '#f44336';
            }

            const heightDisplay = unitSystem === 'imperial' ? 
                `${Math.floor((heightCm / 2.54) / 12)}'${((heightCm / 2.54) % 12).toFixed(0)}" (${heightCm.toFixed(0)} cm)` : 
                `${heightCm.toFixed(1)} cm`;
            const weightDisplay = unitSystem === 'imperial' ? 
                `${(weightKg * 2.20462).toFixed(1)} lbs (${weightKg.toFixed(1)} kg)` : 
                `${weightKg.toFixed(1)} kg`;

            let analysis = `Based on your profile (${gender === 'male' ? 'male' : 'female'}, age ${age}, ${weightDisplay}, ${heightDisplay}), `;
            analysis += `your BMR is ${Math.round(bmr)} calories per day - the amount your body burns at complete rest. `;
            analysis += `With your ${activityNames[activityLevel.toString()].toLowerCase()} lifestyle, your TDEE is ${tdee} calories per day. `;
            
            if (goal === 'maintain') {
                analysis += `To maintain your current weight, eat ${goalCalories} calories daily. `;
            } else if (goal.includes('loss')) {
                const minCal = gender === 'male' ? 1500 : 1200;
                if (goalCalories < minCal) {
                    analysis += `Your goal requires ${goalCalories} calories, which is below the safe minimum of ${minCal} calories. Consider a slower rate of weight loss or increase activity level. `;
                } else {
                    analysis += `To ${goalNames[goal].toLowerCase()}, eat ${goalCalories} calories daily (${Math.abs(goalAdjustments[goal])} cal deficit). `;
                    analysis += `This creates a ${Math.abs(weeklyChange)} lb per week weight loss. `;
                }
                analysis += `Prioritize protein (${proteinG}g daily) to preserve muscle mass. `;
                analysis += `Combine with strength training 3-4x per week and cardio 2-3x per week. `;
            } else {
                analysis += `To ${goalNames[goal].toLowerCase()}, eat ${goalCalories} calories daily (${goalAdjustments[goal]} cal surplus). `;
                analysis += `This creates a ${Math.abs(weeklyChange)} lb per week weight gain. `;
                analysis += `Focus on high protein (${proteinG}g daily) and progressive strength training to maximize muscle growth. `;
            }
            
            analysis += `Your BMI is ${bmi.toFixed(1)} (${bmiCategory}). `;
            analysis += `Recommended macros: ${proteinG}g protein (30%), ${carbsG}g carbs (40%), ${fatG}g fat (30%). `;
            analysis += `Track calories accurately using a food scale and app like MyFitnessPal. Adjust after 2-4 weeks based on results.`;

            const cardClass = goal.includes('loss') ? 'warning' : goal.includes('gain') ? 'info' : 'success';
            document.getElementById('resultCard').className = 'result-card ' + cardClass;

            document.getElementById('resultTitle').textContent = goalNames[goal];
            document.getElementById('tdeeResult').textContent = goalCalories.toLocaleString() + ' calories';
            document.getElementById('goalSubtitle').textContent = weeklyChange === 0 ? 'To maintain current weight' : 
                weeklyChange > 0 ? `To gain ${Math.abs(weeklyChange)} lb/week` : `To lose ${Math.abs(weeklyChange)} lb/week`;

            document.getElementById('bmrDisplay').textContent = Math.round(bmr).toLocaleString();
            document.getElementById('tdeeDisplay').textContent = tdee.toLocaleString();
            document.getElementById('goalDisplay').textContent = goalCalories.toLocaleString();
            document.getElementById('weeklyChangeDisplay').textContent = weeklyChange === 0 ? '0 lbs' : 
                (weeklyChange > 0 ? '+' : '') + weeklyChange + ' lbs';

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('ageDisplay').textContent = age + ' years';
            document.getElementById('heightDisplay').textContent = heightDisplay;
            document.getElementById('weightDisplay').textContent = weightDisplay;
            document.getElementById('bmiDisplay').textContent = bmi.toFixed(1) + ' (' + bmiCategory + ')';
            document.getElementById('bmiDisplay').style.color = bmiColor;
            document.getElementById('activityDisplay').textContent = activityNames[activityLevel.toString()];

            document.getElementById('bmrValue').textContent = Math.round(bmr).toLocaleString() + ' calories';
            document.getElementById('tdeeValue').textContent = tdee.toLocaleString() + ' calories';
            document.getElementById('dailyGoal').textContent = goalCalories.toLocaleString() + ' calories';
            document.getElementById('weeklyAdjustment').textContent = goalAdjustments[goal] === 0 ? '0 calories (maintain)' :
                (goalAdjustments[goal] > 0 ? '+' : '') + goalAdjustments[goal] + ' cal/day';

            document.getElementById('extremeLoss').textContent = extremeLoss.toLocaleString() + ' cal/day';
            document.getElementById('weightLoss').textContent = weightLoss.toLocaleString() + ' cal/day';
            document.getElementById('mildLoss').textContent = mildLoss.toLocaleString() + ' cal/day';
            document.getElementById('maintain').textContent = maintain.toLocaleString() + ' cal/day';
            document.getElementById('mildGain').textContent = mildGain.toLocaleString() + ' cal/day';
            document.getElementById('weightGain').textContent = weightGain.toLocaleString() + ' cal/day';
            document.getElementById('extremeGain').textContent = extremeGain.toLocaleString() + ' cal/day';

            document.getElementById('proteinMacro').textContent = `${proteinG}g (${proteinCal.toFixed(0)} cal)`;
            document.getElementById('carbsMacro').textContent = `${carbsG}g (${carbsCal.toFixed(0)} cal)`;
            document.getElementById('fatMacro').textContent = `${fatG}g (${fatCal.toFixed(0)} cal)`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateTDEE();
        });
    </script>
</body>
</html>