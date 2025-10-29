<?php
/**
 * Water Intake Calculator
 * File: water-intake-calculator.php
 * Description: Calculate daily water intake needs based on weight, activity, and climate
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Intake Calculator - Daily Water Hydration Calculator</title>
    <meta name="description" content="Free water intake calculator. Calculate how much water you should drink daily based on weight, activity level, and climate. Stay hydrated!">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>💧 Water Intake Calculator</h1>
        <p>Calculate daily water needs</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Your Information</h2>
                <form id="waterForm">
                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="imperial">Imperial (lbs/oz)</option>
                            <option value="metric">Metric (kg/L)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Body Weight</h3>
                    
                    <div class="form-group" id="weightImperialGroup">
                        <label for="weightLbs">Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="180" min="70" max="500" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="82" min="30" max="250" step="0.1">
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Activity & Environment</h3>
                    
                    <div class="form-group">
                        <label for="activityLevel">Activity Level</label>
                        <select id="activityLevel">
                            <option value="sedentary">Sedentary (little/no exercise)</option>
                            <option value="light">Lightly Active (exercise 1-2 days/week)</option>
                            <option value="moderate" selected>Moderately Active (exercise 3-5 days/week)</option>
                            <option value="active">Very Active (exercise 6-7 days/week)</option>
                            <option value="extra">Extra Active (physical job + daily exercise)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="climate">Climate/Temperature</label>
                        <select id="climate">
                            <option value="cold">Cold (&lt;50°F / 10°C)</option>
                            <option value="moderate" selected>Moderate (50-80°F / 10-27°C)</option>
                            <option value="hot">Hot (80-95°F / 27-35°C)</option>
                            <option value="extreme">Extreme Heat (&gt;95°F / 35°C)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exerciseMinutes">Daily Exercise Duration (minutes)</label>
                        <input type="number" id="exerciseMinutes" value="45" min="0" max="300" step="5">
                        <small>Additional water needed for exercise</small>
                    </div>

                    <div class="form-group">
                        <label for="pregnantNursing">Pregnancy/Nursing Status</label>
                        <select id="pregnantNursing">
                            <option value="none" selected>Not Applicable</option>
                            <option value="pregnant">Pregnant</option>
                            <option value="nursing">Breastfeeding</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Water Intake</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Water Intake Results</h2>
                
                <div class="result-card success">
                    <h3>Daily Water Goal</h3>
                    <div class="amount" id="waterResult">100 oz</div>
                    <div style="margin-top: 10px; font-size: 1em;">Recommended daily intake</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Ounces/Day</h4>
                        <div class="value" id="ozDisplay">100</div>
                    </div>
                    <div class="metric-card">
                        <h4>Liters/Day</h4>
                        <div class="value" id="litersDisplay">3.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Glasses (8oz)</h4>
                        <div class="value" id="glassesDisplay">12.5</div>
                    </div>
                    <div class="metric-card">
                        <h4>Bottles (16oz)</h4>
                        <div class="value" id="bottlesDisplay">6</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Profile</h3>
                    <div class="breakdown-item">
                        <span>Weight</span>
                        <strong id="weightDisplay">180 lbs (82 kg)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gender</span>
                        <strong id="genderDisplay">Male</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Activity Level</span>
                        <strong id="activityDisplay">Moderately Active</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Climate</span>
                        <strong id="climateDisplay">Moderate</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Exercise Duration</span>
                        <strong id="exerciseDisplay">45 minutes/day</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Water Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Base Requirement</span>
                        <strong id="baseWater" style="color: #667eea;">64 oz (2.0 L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight-Based Addition</span>
                        <strong id="weightWater">+20 oz (0.6 L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Activity Addition</span>
                        <strong id="activityWater">+12 oz (0.35 L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Climate Addition</span>
                        <strong id="climateWater">+8 oz (0.24 L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Daily Intake</span>
                        <strong id="totalWater" style="color: #4CAF50; font-size: 1.1em;">104 oz (3.1 L)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Drinking Schedule</h3>
                    <div class="breakdown-item">
                        <span>Upon Waking (6-7 AM)</span>
                        <strong style="color: #FF9800;">16 oz (2 glasses) 🌅</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mid-Morning (10 AM)</span>
                        <strong>16 oz (2 glasses)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lunch (12-1 PM)</span>
                        <strong>16 oz (2 glasses) 🍽️</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mid-Afternoon (3 PM)</span>
                        <strong>16 oz (2 glasses)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Dinner (6-7 PM)</span>
                        <strong>16 oz (2 glasses) 🍽️</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Evening (9 PM)</span>
                        <strong>8 oz (1 glass)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>During/After Exercise</span>
                        <strong id="exerciseWaterSchedule" style="color: #E91E63;">16 oz (2 glasses) 💪</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Hydration Benefits</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Physical Performance:</strong> 2% dehydration = 10% performance decrease. Maintains strength, endurance. Regulates body temperature through sweating.</p>
                        <p><strong>Brain Function:</strong> Improves concentration, mood, memory. Prevents headaches, fatigue. Brain is 75% water. Even mild dehydration affects cognition.</p>
                        <p><strong>Weight Loss:</strong> Increases metabolism by 24-30% for 1 hour. Suppresses appetite (often thirst is mistaken for hunger). Zero calories. Drink before meals = eat less.</p>
                        <p><strong>Kidney Function:</strong> Flushes toxins, waste. Prevents kidney stones. Dilutes minerals that form stones. Dark urine = dehydrated.</p>
                        <p><strong>Digestive Health:</strong> Prevents constipation. Helps break down food. Absorbs nutrients. Maintains healthy gut bacteria.</p>
                        <p><strong>Skin Health:</strong> Moisturizes from inside. Reduces wrinkles, dryness. Flushes out toxins = clearer skin. Improves elasticity.</p>
                        <p><strong>Joint Health:</strong> Cartilage is 80% water. Lubricates joints. Prevents pain, stiffness. Especially important with exercise.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Signs of Dehydration</h3>
                    <div style="padding: 15px; background: #fff3e0; border-radius: 5px; border-left: 4px solid #FF9800; line-height: 1.8;">
                        <p><strong>Mild Dehydration (1-2% body water loss):</strong></p>
                        <p>• Thirst, dry mouth</p>
                        <p>• Dark yellow urine (should be pale yellow/clear)</p>
                        <p>• Fatigue, low energy</p>
                        <p>• Headache</p>
                        <p>• Dizziness, lightheadedness</p>
                        <p>• Dry skin, lips</p>
                        <p><strong>Moderate Dehydration (3-5%):</strong></p>
                        <p>• Very dark urine, decreased urination</p>
                        <p>• Extreme thirst</p>
                        <p>• Confusion, difficulty concentrating</p>
                        <p>• Rapid heartbeat, breathing</p>
                        <p>• Muscle cramps</p>
                        <p><strong>Severe Dehydration (&gt;5% - Medical Emergency):</strong></p>
                        <p>• No urination for 8+ hours</p>
                        <p>• Sunken eyes</p>
                        <p>• Rapid, weak pulse</p>
                        <p>• Confusion, irritability</p>
                        <p>• Seek immediate medical help!</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Hydration Tips</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Start Day with Water:</strong> 16 oz upon waking. Rehydrates after sleep. Kickstarts metabolism. Add lemon for flavor/vitamin C.</p>
                        <p>&#10003; <strong>Carry Bottle:</strong> Reusable water bottle everywhere. Makes drinking easy. Track intake. 32 oz bottle = refill 3x for 96 oz.</p>
                        <p>&#10003; <strong>Set Reminders:</strong> Phone alarm every 2 hours. Apps like WaterMinder, Plant Nanny. Sticky notes at desk. Build habit.</p>
                        <p>&#10003; <strong>Drink Before Meals:</strong> 16 oz 30 min before eating. Reduces appetite. Aids digestion. May help eat less.</p>
                        <p>&#10003; <strong>Flavor It:</strong> Add fruit (lemon, berries, cucumber). Herbal tea (counts as water). Infused water. Avoid sugary drinks.</p>
                        <p>&#10003; <strong>Eat Water-Rich Foods:</strong> Watermelon, cucumbers, oranges, lettuce, celery. Contributes 20% of daily intake through food.</p>
                        <p>&#10003; <strong>Monitor Urine Color:</strong> Pale yellow/clear = hydrated. Dark yellow = drink more. First check of day usually darker (normal).</p>
                        <p>&#10003; <strong>Drink During Exercise:</strong> 7-10 oz every 10-20 min. Before (17 oz 2 hrs before). After (24 oz per lb lost in sweat).</p>
                        <p>&#10003; <strong>Increase in Heat:</strong> Hot weather = more sweat = more water needed. Add 16-32 oz on hot days or with outdoor work.</p>
                        <p>&#10003; <strong>Limit Dehydrating Drinks:</strong> Alcohol, caffeine increase urination (diuretics). For each drink, add extra glass of water.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Common Water Myths</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>❌ <strong>Myth: Everyone needs 8 glasses (64 oz) per day.</strong> ✅ Truth: Needs vary by weight, activity, climate. 64 oz is minimum. Most need more.</p>
                        <p>❌ <strong>Myth: You can't drink too much water.</strong> ✅ Truth: Overhydration (hyponatremia) is rare but possible. Dilutes blood sodium. Mainly endurance athletes drinking excessively.</p>
                        <p>❌ <strong>Myth: Thirst = already dehydrated.</strong> ✅ Truth: Thirst is early warning. Means you're starting to get dehydrated. Don't wait - drink before thirsty.</p>
                        <p>❌ <strong>Myth: Coffee/tea don't count as water.</strong> ✅ Truth: Caffeine is mild diuretic but beverages still hydrate. Count 50% of caffeinated drinks toward goal.</p>
                        <p>❌ <strong>Myth: Clear urine means perfectly hydrated.</strong> ✅ Truth: Completely clear might mean overhydrated. Pale yellow = ideal. Clear occasionally is OK.</p>
                        <p>❌ <strong>Myth: Only water counts for hydration.</strong> ✅ Truth: All fluids count (milk, juice, tea). Food provides 20%. But water is best - no calories/sugar.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Hydration Tips:</strong> Baseline: half your weight (lbs) in ounces. 180 lbs = 90 oz minimum. Add for activity, heat. Dark urine = drink more. Pale yellow = good. Drink 16 oz upon waking. Carry water bottle. Set hourly reminders. Drink before meals (reduces appetite). Exercise: +12-20 oz per hour. Hot weather: +16-32 oz. Pregnant: +8 oz. Nursing: +24 oz. Dehydration = headaches, fatigue, poor performance. Start day hydrated. Don't wait until thirsty. Flavor with fruit/lemon. Eat water-rich foods. Limit alcohol/caffeine. Track intake with app. Build consistent habit!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('waterForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateWater();
        });

        function toggleUnitFields() {
            const unitSystem = unitSystemSelect.value;
            const isImperial = unitSystem === 'imperial';
            
            document.getElementById('weightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('weightMetricGroup').style.display = isImperial ? 'none' : 'block';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateWater();
        });

        function calculateWater() {
            const gender = document.getElementById('gender').value;
            const activityLevel = document.getElementById('activityLevel').value;
            const climate = document.getElementById('climate').value;
            const exerciseMinutes = parseInt(document.getElementById('exerciseMinutes').value) || 0;
            const pregnantNursing = document.getElementById('pregnantNursing').value;
            const unitSystem = unitSystemSelect.value;
            
            let weightLbs;
            if (unitSystem === 'imperial') {
                weightLbs = parseFloat(document.getElementById('weightLbs').value) || 180;
            } else {
                const weightKg = parseFloat(document.getElementById('weightKg').value) || 82;
                weightLbs = weightKg * 2.20462;
            }

            const weightKg = weightLbs / 2.20462;

            // Base calculation: 0.5-0.67 oz per lb of body weight
            let baseWaterOz = weightLbs * 0.5;

            // Gender adjustment
            const genderMultiplier = gender === 'male' ? 1.0 : 0.9;
            baseWaterOz *= genderMultiplier;

            // Activity level adjustments
            const activityAdditions = {
                'sedentary': 0,
                'light': 8,
                'moderate': 12,
                'active': 16,
                'extra': 24
            };
            const activityWaterOz = activityAdditions[activityLevel];

            // Climate adjustments
            const climateAdditions = {
                'cold': 0,
                'moderate': 8,
                'hot': 16,
                'extreme': 32
            };
            const climateWaterOz = climateAdditions[climate];

            // Exercise: 12 oz per 30 minutes
            const exerciseWaterOz = (exerciseMinutes / 30) * 12;

            // Pregnancy/Nursing
            let pregnancyWaterOz = 0;
            if (pregnantNursing === 'pregnant') {
                pregnancyWaterOz = 8;
            } else if (pregnantNursing === 'nursing') {
                pregnancyWaterOz = 24;
            }

            // Total water
            const totalWaterOz = Math.round(baseWaterOz + activityWaterOz + climateWaterOz + exerciseWaterOz + pregnancyWaterOz);
            const totalWaterLiters = (totalWaterOz * 0.0295735).toFixed(1);
            const totalGlasses = (totalWaterOz / 8).toFixed(1);
            const totalBottles = Math.ceil(totalWaterOz / 16);

            const activityNames = {
                'sedentary': 'Sedentary',
                'light': 'Lightly Active',
                'moderate': 'Moderately Active',
                'active': 'Very Active',
                'extra': 'Extra Active'
            };

            const climateNames = {
                'cold': 'Cold',
                'moderate': 'Moderate',
                'hot': 'Hot',
                'extreme': 'Extreme Heat'
            };

            let analysis = `Based on your weight of ${weightLbs.toFixed(0)} lbs (${weightKg.toFixed(0)} kg) and ${activityNames[activityLevel].toLowerCase()} lifestyle, `;
            analysis += `your recommended daily water intake is ${totalWaterOz} ounces (${totalWaterLiters} liters). `;
            analysis += `This equals approximately ${totalGlasses} standard 8-ounce glasses or ${totalBottles} refills of a 16-ounce water bottle. `;
            
            analysis += `Your base water requirement is ${Math.round(baseWaterOz)} oz, calculated at 0.5 oz per pound of body weight. `;
            
            if (activityWaterOz > 0) {
                analysis += `Add ${activityWaterOz} oz for your ${activityNames[activityLevel].toLowerCase()} activity level. `;
            }
            
            if (climateWaterOz > 0) {
                analysis += `Add ${climateWaterOz} oz for ${climateNames[climate].toLowerCase()} climate conditions. `;
            }
            
            if (exerciseWaterOz > 0) {
                analysis += `Add ${Math.round(exerciseWaterOz)} oz for ${exerciseMinutes} minutes of daily exercise (12 oz per 30 minutes). `;
            }
            
            if (pregnancyWaterOz > 0) {
                const status = pregnantNursing === 'pregnant' ? 'pregnancy' : 'breastfeeding';
                analysis += `Add ${pregnancyWaterOz} oz for ${status}. `;
            }
            
            analysis += `Start your day with 16 oz of water upon waking to rehydrate after sleep. `;
            analysis += `Spread your intake throughout the day - drinking 16 oz every 2-3 hours is ideal. `;
            analysis += `Monitor your urine color: pale yellow means you're well-hydrated, while dark yellow indicates you need more water. `;
            analysis += `Carry a reusable water bottle and set reminders to maintain consistent hydration. `;
            analysis += `Remember, proper hydration improves energy, focus, physical performance, and overall health!`;

            document.getElementById('waterResult').textContent = unitSystem === 'imperial' ? 
                `${totalWaterOz} oz` : `${totalWaterLiters} L`;
            document.getElementById('ozDisplay').textContent = totalWaterOz;
            document.getElementById('litersDisplay').textContent = totalWaterLiters;
            document.getElementById('glassesDisplay').textContent = totalGlasses;
            document.getElementById('bottlesDisplay').textContent = totalBottles;

            document.getElementById('weightDisplay').textContent = `${weightLbs.toFixed(0)} lbs (${weightKg.toFixed(0)} kg)`;
            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('activityDisplay').textContent = activityNames[activityLevel];
            document.getElementById('climateDisplay').textContent = climateNames[climate];
            document.getElementById('exerciseDisplay').textContent = `${exerciseMinutes} minutes/day`;

            document.getElementById('baseWater').textContent = `${Math.round(baseWaterOz)} oz (${(baseWaterOz * 0.0295735).toFixed(1)} L)`;
            document.getElementById('weightWater').textContent = activityWaterOz > 0 ? `+${activityWaterOz} oz (${(activityWaterOz * 0.0295735).toFixed(2)} L)` : '0 oz';
            document.getElementById('activityWater').textContent = climateWaterOz > 0 ? `+${climateWaterOz} oz (${(climateWaterOz * 0.0295735).toFixed(2)} L)` : '0 oz';
            document.getElementById('climateWater').textContent = exerciseWaterOz > 0 ? `+${Math.round(exerciseWaterOz)} oz (${(exerciseWaterOz * 0.0295735).toFixed(2)} L)` : '0 oz';
            document.getElementById('totalWater').textContent = `${totalWaterOz} oz (${totalWaterLiters} L)`;

            document.getElementById('exerciseWaterSchedule').textContent = exerciseWaterOz > 0 ? 
                `${Math.round(exerciseWaterOz)} oz during/after exercise 💪` : 'N/A';

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateWater();
        });
    </script>
</body>
</html>