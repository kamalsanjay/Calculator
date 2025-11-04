<?php
/**
 * Meal Prep Calculator
 * File: cooking/meal-prep-calculator.php
 * Description: Calculate meal prep quantities, nutrition, and planning for efficient cooking
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Prep Calculator - Plan & Calculate Your Weekly Meals</title>
    <meta name="description" content="Calculate meal prep quantities, nutrition information, shopping lists, and cooking schedules for efficient weekly meal preparation.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: clamp(20px, 5vw, 30px); border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: clamp(1.5rem, 4vw, 2rem); margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: clamp(0.9rem, 2.5vw, 1.05rem); line-height: 1.6; }
        
        .calculator-card { background: white; padding: clamp(20px, 5vw, 35px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .setup-section { margin-bottom: 30px; }
        .setup-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: clamp(15px, 4vw, 25px); margin-bottom: 25px; }
        
        .input-group { background: #f8f9fa; padding: clamp(15px, 4vw, 25px); border-radius: 12px; }
        .input-group h3 { color: #2c3e50; margin-bottom: 15px; font-size: clamp(1rem, 3vw, 1.2rem); display: flex; align-items: center; gap: 8px; }
        
        .input-row { display: flex; gap: 15px; align-items: end; margin-bottom: 15px; }
        .input-wrapper { flex: 1; }
        .input-wrapper label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.9rem; }
        .input-field { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-field:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; }
        .unit-select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .checkbox-group { display: flex; flex-direction: column; gap: 12px; margin-top: 15px; }
        .checkbox-item { display: flex; align-items: center; gap: 10px; }
        .checkbox-item input[type="checkbox"] { width: 18px; height: 18px; accent-color: #667eea; }
        .checkbox-item label { color: #34495e; cursor: pointer; font-size: 0.9rem; }
        
        .calculate-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 16px 30px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin: 20px 0; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        
        .results-section { margin-top: 30px; }
        
        .meal-plan-overview { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .overview-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
        .overview-card { background: white; padding: 20px; border-radius: 10px; text-align: center; border-left: 4px solid #667eea; }
        .overview-value { font-size: 1.4rem; font-weight: bold; color: #5e35b1; margin-bottom: 5px; }
        .overview-label { color: #7f8c8d; font-size: 0.9rem; }
        
        .nutrition-breakdown { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .nutrition-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .nutrition-header h3 { color: #2c3e50; font-size: 1.1rem; }
        
        .nutrition-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .nutrition-card { background: white; padding: 20px; border-radius: 10px; text-align: center; }
        .nutrition-icon { font-size: 2rem; margin-bottom: 10px; }
        .nutrition-value { font-size: 1.3rem; font-weight: bold; color: #667eea; margin-bottom: 5px; }
        .nutrition-label { color: #7f8c8d; font-size: 0.9rem; }
        
        .shopping-list { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .shopping-header { display: flex; align-items: center; justify-content: between; margin-bottom: 20px; }
        .shopping-header h3 { color: #2c3e50; font-size: 1.1rem; }
        .print-btn { background: #667eea; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; }
        
        .shopping-categories { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .category-group { background: white; padding: 20px; border-radius: 10px; }
        .category-title { color: #2c3e50; font-weight: 600; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #f8f9fa; }
        .shopping-items { display: flex; flex-direction: column; gap: 10px; }
        .shopping-item { display: flex; justify-content: between; align-items: center; padding: 10px; background: #f8f9fa; border-radius: 6px; }
        .item-name { flex: 1; }
        .item-quantity { color: #667eea; font-weight: 600; }
        
        .prep-schedule { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .schedule-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .day-schedule { background: white; padding: 20px; border-radius: 10px; }
        .day-header { color: #2c3e50; font-weight: 600; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #f8f9fa; }
        .meal-times { display: flex; flex-direction: column; gap: 12px; }
        .meal-time { display: flex; justify-content: between; align-items: center; padding: 12px; background: #f8f9fa; border-radius: 6px; }
        .meal-name { flex: 1; }
        .meal-calories { color: #667eea; font-weight: 600; }
        
        .quick-templates { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .templates-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .templates-header h3 { color: #2c3e50; font-size: 1.1rem; }
        
        .templates-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .template-card { background: white; padding: 20px; border-radius: 10px; text-align: center; cursor: pointer; transition: all 0.3s; border: 2px solid #e0e0e0; }
        .template-card:hover { border-color: #667eea; transform: translateY(-2px); }
        .template-icon { font-size: 2rem; margin-bottom: 10px; }
        .template-name { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .template-desc { color: #7f8c8d; font-size: 0.8rem; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: clamp(1.2rem, 4vw, 1.4rem); }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: clamp(1rem, 3vw, 1.1rem); }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        
        .meal-prep-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin: 20px 0; }
        .meal-prep-card { background: #ede7f6; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; }
        .meal-prep-card h4 { color: #4527a0; margin-bottom: 10px; }
        
        .benefits-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: clamp(0.8rem, 2vw, 0.9rem); }
        .benefits-table th, .benefits-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .benefits-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .benefits-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-row { flex-direction: column; }
            .overview-grid { grid-template-columns: repeat(2, 1fr); }
            .nutrition-grid { grid-template-columns: repeat(2, 1fr); }
            .shopping-categories { grid-template-columns: 1fr; }
            .schedule-grid { grid-template-columns: 1fr; }
            .templates-grid { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (max-width: 480px) {
            .overview-grid { grid-template-columns: 1fr; }
            .nutrition-grid { grid-template-columns: 1fr; }
            .templates-grid { grid-template-columns: 1fr; }
            .setup-grid { grid-template-columns: 1fr; }
            .calculator-card { padding: 15px; }
            .header { padding: 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍽️ Meal Prep Calculator</h1>
            <p>Plan your weekly meals, calculate quantities, nutrition, and create shopping lists for efficient meal preparation</p>
        </div>

        <div class="calculator-card">
            <div class="setup-section">
                <div class="setup-grid">
                    <div class="input-group">
                        <h3>👥 Basic Information</h3>
                        <div class="input-wrapper">
                            <label for="peopleCount">Number of People</label>
                            <input type="number" id="peopleCount" class="input-field" placeholder="2" value="2" min="1" max="20" step="1">
                        </div>
                        <div class="input-wrapper">
                            <label for="daysCount">Days to Prep</label>
                            <input type="number" id="daysCount" class="input-field" placeholder="7" value="7" min="1" max="14" step="1">
                        </div>
                        <div class="input-wrapper">
                            <label for="mealsPerDay">Meals per Day</label>
                            <select id="mealsPerDay" class="unit-select">
                                <option value="2">2 meals (Lunch & Dinner)</option>
                                <option value="3" selected>3 meals (Breakfast, Lunch & Dinner)</option>
                                <option value="4">4 meals (Includes Snacks)</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group">
                        <h3>🎯 Dietary Goals</h3>
                        <div class="input-wrapper">
                            <label for="calorieTarget">Daily Calorie Target (per person)</label>
                            <input type="number" id="calorieTarget" class="input-field" placeholder="2000" value="2000" min="1200" max="4000" step="100">
                        </div>
                        <div class="input-wrapper">
                            <label for="dietType">Diet Type</label>
                            <select id="dietType" class="unit-select">
                                <option value="balanced" selected>Balanced</option>
                                <option value="keto">Keto/Low-Carb</option>
                                <option value="vegetarian">Vegetarian</option>
                                <option value="vegan">Vegan</option>
                                <option value="paleo">Paleo</option>
                                <option value="mediterranean">Mediterranean</option>
                            </select>
                        </div>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="includeSnacks" checked>
                                <label for="includeSnacks">Include healthy snacks</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="includeBreakfast" checked>
                                <label for="includeBreakfast">Include breakfast meals</label>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <h3>⚡ Preferences</h3>
                        <div class="input-wrapper">
                            <label for="cookingTime">Max Daily Cooking Time (minutes)</label>
                            <input type="number" id="cookingTime" class="input-field" placeholder="60" value="60" min="15" max="180" step="15">
                        </div>
                        <div class="input-wrapper">
                            <label for="prepDay">Preferred Prep Day</label>
                            <select id="prepDay" class="unit-select">
                                <option value="sunday" selected>Sunday</option>
                                <option value="saturday">Saturday</option>
                                <option value="monday">Monday</option>
                            </select>
                        </div>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="leftovers" checked>
                                <label for="leftovers">Plan for leftovers</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="freezerMeals">
                                <label for="freezerMeals">Include freezer meals</label>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="calculate-btn" id="calculateButton">Generate Meal Plan</button>
            </div>

            <div class="results-section">
                <div class="meal-plan-overview">
                    <div class="overview-grid">
                        <div class="overview-card">
                            <div class="overview-value" id="totalMeals">42</div>
                            <div class="overview-label">Total Meals</div>
                        </div>
                        <div class="overview-card">
                            <div class="overview-value" id="weeklyCost">$168</div>
                            <div class="overview-label">Estimated Cost</div>
                        </div>
                        <div class="overview-card">
                            <div class="overview-value" id="prepTime">3.5h</div>
                            <div class="overview-label">Prep Time</div>
                        </div>
                        <div class="overview-card">
                            <div class="overview-value" id="caloriesPerDay">2000</div>
                            <div class="overview-label">Calories/Day</div>
                        </div>
                    </div>
                </div>

                <div class="nutrition-breakdown">
                    <div class="nutrition-header">
                        <h3>📊 Nutrition Overview (Daily Average)</h3>
                    </div>
                    <div class="nutrition-grid">
                        <div class="nutrition-card">
                            <div class="nutrition-icon">⚡</div>
                            <div class="nutrition-value" id="avgCalories">2000</div>
                            <div class="nutrition-label">Calories</div>
                        </div>
                        <div class="nutrition-card">
                            <div class="nutrition-icon">🍗</div>
                            <div class="nutrition-value" id="avgProtein">75g</div>
                            <div class="nutrition-label">Protein</div>
                        </div>
                        <div class="nutrition-card">
                            <div class="nutrition-icon">🍚</div>
                            <div class="nutrition-value" id="avgCarbs">250g</div>
                            <div class="nutrition-label">Carbs</div>
                        </div>
                        <div class="nutrition-card">
                            <div class="nutrition-icon">🥑</div>
                            <div class="nutrition-value" id="avgFat">65g</div>
                            <div class="nutrition-label">Fat</div>
                        </div>
                    </div>
                </div>

                <div class="shopping-list">
                    <div class="shopping-header">
                        <h3>🛒 Shopping List</h3>
                        <button class="print-btn" onclick="printShoppingList()">Print List</button>
                    </div>
                    <div class="shopping-categories">
                        <div class="category-group">
                            <div class="category-title">🥦 Produce</div>
                            <div class="shopping-items" id="produceList">
                                <!-- Generated by JavaScript -->
                            </div>
                        </div>
                        <div class="category-group">
                            <div class="category-title">🍗 Protein</div>
                            <div class="shopping-items" id="proteinList">
                                <!-- Generated by JavaScript -->
                            </div>
                        </div>
                        <div class="category-group">
                            <div class="category-title">🥫 Pantry</div>
                            <div class="shopping-items" id="pantryList">
                                <!-- Generated by JavaScript -->
                            </div>
                        </div>
                        <div class="category-group">
                            <div class="category-title">🥛 Dairy & Alternatives</div>
                            <div class="shopping-items" id="dairyList">
                                <!-- Generated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="prep-schedule">
                    <div class="shopping-header">
                        <h3>⏰ Meal Schedule</h3>
                    </div>
                    <div class="schedule-grid">
                        <div class="day-schedule">
                            <div class="day-header">Monday</div>
                            <div class="meal-times" id="mondayMeals">
                                <!-- Generated by JavaScript -->
                            </div>
                        </div>
                        <div class="day-schedule">
                            <div class="day-header">Tuesday</div>
                            <div class="meal-times" id="tuesdayMeals">
                                <!-- Generated by JavaScript -->
                            </div>
                        </div>
                        <div class="day-schedule">
                            <div class="day-header">Wednesday</div>
                            <div class="meal-times" id="wednesdayMeals">
                                <!-- Generated by JavaScript -->
                            </div>
                        </div>
                        <div class="day-schedule">
                            <div class="day-header">Thursday</div>
                            <div class="meal-times" id="thursdayMeals">
                                <!-- Generated by JavaScript -->
                            </div>
                        </div>
                        <div class="day-schedule">
                            <div class="day-header">Friday</div>
                            <div class="meal-times" id="fridayMeals">
                                <!-- Generated by JavaScript -->
                            </div>
                        </div>
                        <div class="day-schedule">
                            <div class="day-header">Weekend</div>
                            <div class="meal-times" id="weekendMeals">
                                <!-- Generated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="quick-templates">
                <div class="templates-header">
                    <h3>🚀 Quick Start Templates</h3>
                </div>
                <div class="templates-grid">
                    <div class="template-card" onclick="applyTemplate('weightLoss')">
                        <div class="template-icon">⚖️</div>
                        <div class="template-name">Weight Loss</div>
                        <div class="template-desc">1500 calories, high protein</div>
                    </div>
                    <div class="template-card" onclick="applyTemplate('muscleGain')">
                        <div class="template-icon">💪</div>
                        <div class="template-name">Muscle Gain</div>
                        <div class="template-desc">2800 calories, high protein</div>
                    </div>
                    <div class="template-card" onclick="applyTemplate('family')">
                        <div class="template-icon">👨‍👩‍👧‍👦</div>
                        <div class="template-name">Family Plan</div>
                        <div class="template-desc">4 people, balanced meals</div>
                    </div>
                    <div class="template-card" onclick="applyTemplate('busyWeek')">
                        <div class="template-icon">🏃‍♂️</div>
                        <div class="template-name">Busy Week</div>
                        <div class="template-desc">Quick meals, 30 min prep</div>
                    </div>
                    <div class="template-card" onclick="applyTemplate('vegetarian')">
                        <div class="template-icon">🥗</div>
                        <div class="template-name">Vegetarian</div>
                        <div class="template-desc">Plant-based, high fiber</div>
                    </div>
                    <div class="template-card" onclick="applyTemplate('keto')">
                        <div class="template-icon">🥑</div>
                        <div class="template-name">Keto</div>
                        <div class="template-desc">Low carb, high fat</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🍽️ Meal Preparation Guide</h2>
            
            <p>Meal prepping is the practice of preparing meals or meal components ahead of time to save time, reduce stress, and maintain healthy eating habits throughout the week.</p>

            <div class="meal-prep-grid">
                <div class="meal-prep-card">
                    <h4>⏰ Time Savings</h4>
                    <p>Spend 2-4 hours on weekend to save 10+ hours during the week. No more daily cooking decisions or last-minute takeout.</p>
                </div>
                <div class="meal-prep-card">
                    <h4>💰 Cost Effective</h4>
                    <p>Reduce food waste, buy in bulk, and avoid expensive convenience foods and restaurant meals.</p>
                </div>
                <div class="meal-prep-card">
                    <h4>🎯 Health Benefits</h4>
                    <p>Control portions, ensure balanced nutrition, and avoid unhealthy impulse eating when hungry.</p>
                </div>
            </div>

            <h3>📊 Meal Prep Benefits Comparison</h3>
            <table class="benefits-table">
                <thead>
                    <tr>
                        <th>Aspect</th>
                        <th>With Meal Prep</th>
                        <th>Without Meal Prep</th>
                        <th>Savings/Improvement</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Weekly Time</strong></td>
                        <td>2-4 hours</td>
                        <td>10-14 hours</td>
                        <td>6-10 hours saved</td>
                    </tr>
                    <tr>
                        <td><strong>Weekly Cost</strong></td>
                        <td>$100-150</td>
                        <td>$200-300</td>
                        <td>40-50% savings</td>
                    </tr>
                    <tr>
                        <td><strong>Nutrition Control</strong></td>
                        <td>Complete control</td>
                        <td>Variable</td>
                        <td>Better macro balance</td>
                    </tr>
                    <tr>
                        <td><strong>Food Waste</strong></td>
                        <td>5-10%</td>
                        <td>25-40%</td>
                        <td>60-80% reduction</td>
                    </tr>
                    <tr>
                        <td><strong>Stress Level</strong></td>
                        <td>Low</td>
                        <td>High</td>
                        <td>Significant reduction</td>
                    </tr>
                </tbody>
            </table>

            <h3>🔪 Meal Prep Methods</h3>
            <div class="formula-box">
                <strong>Batch Cooking:</strong> Cook complete meals in large quantities and portion them out<br>
                <strong>Ingredient Prep:</strong> Prepare components (chopped veggies, cooked grains) to assemble later<br>
                <strong>Freezer Meals:</strong> Prepare and freeze complete meals for later use<br>
                <strong>Portion Planning:</strong> Pre-portion snacks and ingredients for quick assembly<br>
                <strong>Theme Days:</strong> Assign specific types of cuisine to each day for variety
            </div>

            <h3>📅 Weekly Planning Strategy</h3>
            <div class="meal-prep-grid">
                <div class="meal-prep-card">
                    <h4>🛒 Shopping Day (Saturday)</h4>
                    <p>• Create detailed shopping list<br>• Shop for all ingredients<br>• Organize pantry and fridge</p>
                </div>
                <div class="meal-prep-card">
                    <h4>🔪 Prep Day (Sunday)</h4>
                    <p>• Wash and chop produce<br>• Cook proteins and grains<br>• Portion snacks and meals<br>• Label and store properly</p>
                </div>
                <div class="meal-prep-card">
                    <h4>🍽️ Assembly Days (Weekdays)</h4>
                    <p>• Quick meal assembly<br>• Minimal cooking required<br>• Easy reheating<br>• Fresh additions as needed</p>
                </div>
            </div>

            <h3>⚡ Time-Saving Tips</h3>
            <ul>
                <li><strong>Use kitchen gadgets:</strong> Food processors, slow cookers, and instant pots save significant time</li>
                <li><strong>Multi-task:</strong> Roast vegetables while cooking grains and proteins simultaneously</li>
                <li><strong>One-pan meals:</strong> Reduce cleanup time with sheet pan dinners and one-pot meals</li>
                <li><strong>Pre-made components:</strong> Use pre-chopped vegetables or canned beans when short on time</li>
                <li><strong>Label everything:</strong> Use masking tape and markers to label containers with contents and dates</li>
            </ul>

            <h3>📦 Storage Guidelines</h3>
            <table class="benefits-table">
                <thead>
                    <tr>
                        <th>Food Type</th>
                        <th>Refrigerator</th>
                        <th>Freezer</th>
                        <th>Reheating Tips</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Cooked Meat</strong></td>
                        <td>3-4 days</td>
                        <td>2-3 months</td>
                        <td>Reheat to 165°F, add moisture</td>
                    </tr>
                    <tr>
                        <td><strong>Cooked Vegetables</strong></td>
                        <td>3-5 days</td>
                        <td>8-12 months</td>
                        <td>Quick reheat to maintain texture</td>
                    </tr>
                    <tr>
                        <td><strong>Grains & Rice</strong></td>
                        <td>4-6 days</td>
                        <td>6-8 months</td>
                        <td>Add water when reheating</td>
                    </tr>
                    <tr>
                        <td><strong>Soups & Stews</strong></td>
                        <td>3-4 days</td>
                        <td>4-6 months</td>
                        <td>Thaw in refrigerator overnight</td>
                    </tr>
                    <tr>
                        <td><strong>Salads (dressing separate)</strong></td>
                        <td>2-3 days</td>
                        <td>Not recommended</td>
                        <td>Keep dressing separate until serving</td>
                    </tr>
                </tbody>
            </table>

            <h3>💰 Cost-Saving Strategies</h3>
            <div class="formula-box">
                <strong>Buy in Bulk:</strong> Purchase family packs and divide at home<br>
                <strong>Seasonal Shopping:</strong> Focus on fruits and vegetables that are in season<br>
                <strong>Plant-Based Proteins:</strong> Incorporate beans, lentils, and tofu as affordable protein sources<br>
                <strong>Repurpose Leftovers:</strong> Turn roasted chicken into salads, soups, or tacos<br>
                <strong>Minimize Waste:</strong> Use vegetable scraps for stocks and broths
            </div>

            <h3>🎯 Success Tips for Beginners</h3>
            <ul>
                <li><strong>Start small:</strong> Begin with prepping 2-3 days worth of meals rather than a full week</li>
                <li><strong>Invest in quality containers:</strong> Get leak-proof, microwave-safe, stackable containers</li>
                <li><strong>Keep it simple:</strong> Don't try complicated recipes for your first meal prep</li>
                <li><strong>Schedule it:</strong> Treat meal prep like any other important appointment</li>
                <li><strong>Listen to your body:</strong> Adjust portions and ingredients based on your hunger and energy levels</li>
                <li><strong>Make it enjoyable:</strong> Listen to music or podcasts while prepping to make it more fun</li>
            </ul>

            <h3>🌱 Sustainable Meal Prepping</h3>
            <div class="meal-prep-grid">
                <div class="meal-prep-card">
                    <h4>♻️ Reduce Waste</h4>
                    <p>Use reusable containers, buy in bulk to reduce packaging, and compost food scraps when possible.</p>
                </div>
                <div class="meal-prep-card">
                    <h4>🛒 Smart Shopping</h4>
                    <p>Plan meals around what's on sale and in season. Shop local farmers markets when possible.</p>
                </div>
                <div class="meal-prep-card">
                    <h4>🔁 Repurpose Ingredients</h4>
                    <p>Use leftover proteins in different dishes throughout the week to maintain variety.</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🍽️ Meal Prep Calculator | Plan & Calculate Your Weekly Meals</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate meal prep quantities, nutrition information, shopping lists, and cooking schedules</p>
        </div>
    </div>

    <script>
        // DOM elements
        const peopleCountInput = document.getElementById('peopleCount');
        const daysCountInput = document.getElementById('daysCount');
        const mealsPerDaySelect = document.getElementById('mealsPerDay');
        const calorieTargetInput = document.getElementById('calorieTarget');
        const dietTypeSelect = document.getElementById('dietType');
        const includeSnacksCheck = document.getElementById('includeSnacks');
        const includeBreakfastCheck = document.getElementById('includeBreakfast');
        const cookingTimeInput = document.getElementById('cookingTime');
        const prepDaySelect = document.getElementById('prepDay');
        const leftoversCheck = document.getElementById('leftovers');
        const freezerMealsCheck = document.getElementById('freezerMeals');
        const calculateButton = document.getElementById('calculateButton');

        // Results elements
        const totalMealsElement = document.getElementById('totalMeals');
        const weeklyCostElement = document.getElementById('weeklyCost');
        const prepTimeElement = document.getElementById('prepTime');
        const caloriesPerDayElement = document.getElementById('caloriesPerDay');
        
        const avgCaloriesElement = document.getElementById('avgCalories');
        const avgProteinElement = document.getElementById('avgProtein');
        const avgCarbsElement = document.getElementById('avgCarbs');
        const avgFatElement = document.getElementById('avgFat');
        
        const produceListElement = document.getElementById('produceList');
        const proteinListElement = document.getElementById('proteinList');
        const pantryListElement = document.getElementById('pantryList');
        const dairyListElement = document.getElementById('dairyList');
        
        const mondayMealsElement = document.getElementById('mondayMeals');
        const tuesdayMealsElement = document.getElementById('tuesdayMeals');
        const wednesdayMealsElement = document.getElementById('wednesdayMeals');
        const thursdayMealsElement = document.getElementById('thursdayMeals');
        const fridayMealsElement = document.getElementById('fridayMeals');
        const weekendMealsElement = document.getElementById('weekendMeals');

        // Event listeners
        calculateButton.addEventListener('click', generateMealPlan);
        
        // Initial generation
        generateMealPlan();

        function generateMealPlan() {
            // Get input values
            const peopleCount = parseInt(peopleCountInput.value);
            const daysCount = parseInt(daysCountInput.value);
            const mealsPerDay = parseInt(mealsPerDaySelect.value);
            const calorieTarget = parseInt(calorieTargetInput.value);
            const dietType = dietTypeSelect.value;
            const includeSnacks = includeSnacksCheck.checked;
            const includeBreakfast = includeBreakfastCheck.checked;
            const maxCookingTime = parseInt(cookingTimeInput.value);

            // Calculate basic metrics
            const totalMeals = peopleCount * daysCount * mealsPerDay;
            const estimatedCost = calculateCost(peopleCount, daysCount, dietType);
            const prepTime = calculatePrepTime(totalMeals, maxCookingTime);
            const nutrition = calculateNutrition(calorieTarget, dietType);

            // Update overview
            updateOverview(totalMeals, estimatedCost, prepTime, calorieTarget);
            
            // Update nutrition breakdown
            updateNutrition(nutrition);
            
            // Generate shopping list
            generateShoppingList(peopleCount, daysCount, dietType);
            
            // Generate meal schedule
            generateMealSchedule(daysCount, mealsPerDay, calorieTarget, dietType);
        }

        function calculateCost(people, days, diet) {
            const baseCostPerPerson = 8; // dollars per day
            let multiplier = 1;
            
            switch(diet) {
                case 'keto':
                    multiplier = 1.3;
                    break;
                case 'paleo':
                    multiplier = 1.2;
                    break;
                case 'vegetarian':
                    multiplier = 0.9;
                    break;
                case 'vegan':
                    multiplier = 0.8;
                    break;
            }
            
            return Math.round(people * days * baseCostPerPerson * multiplier);
        }

        function calculatePrepTime(totalMeals, maxTime) {
            const baseTimePerMeal = 0.1; // hours per meal
            const totalTime = totalMeals * baseTimePerMeal;
            return Math.min(totalTime, maxTime / 60).toFixed(1);
        }

        function calculateNutrition(calories, diet) {
            let proteinRatio, carbRatio, fatRatio;
            
            switch(diet) {
                case 'keto':
                    proteinRatio = 0.25;
                    carbRatio = 0.05;
                    fatRatio = 0.70;
                    break;
                case 'paleo':
                    proteinRatio = 0.30;
                    carbRatio = 0.30;
                    fatRatio = 0.40;
                    break;
                case 'vegetarian':
                    proteinRatio = 0.20;
                    carbRatio = 0.55;
                    fatRatio = 0.25;
                    break;
                case 'vegan':
                    proteinRatio = 0.18;
                    carbRatio = 0.60;
                    fatRatio = 0.22;
                    break;
                default: // balanced
                    proteinRatio = 0.25;
                    carbRatio = 0.50;
                    fatRatio = 0.25;
            }
            
            // Calories per gram: protein=4, carbs=4, fat=9
            const proteinGrams = Math.round((calories * proteinRatio) / 4);
            const carbGrams = Math.round((calories * carbRatio) / 4);
            const fatGrams = Math.round((calories * fatRatio) / 9);
            
            return {
                calories: calories,
                protein: proteinGrams,
                carbs: carbGrams,
                fat: fatGrams
            };
        }

        function updateOverview(totalMeals, cost, prepTime, calories) {
            totalMealsElement.textContent = totalMeals;
            weeklyCostElement.textContent = '$' + cost;
            prepTimeElement.textContent = prepTime + 'h';
            caloriesPerDayElement.textContent = calories;
        }

        function updateNutrition(nutrition) {
            avgCaloriesElement.textContent = nutrition.calories;
            avgProteinElement.textContent = nutrition.protein + 'g';
            avgCarbsElement.textContent = nutrition.carbs + 'g';
            avgFatElement.textContent = nutrition.fat + 'g';
        }

        function generateShoppingList(people, days, diet) {
            // Sample shopping items by category
            const produceItems = [
                { name: 'Bell Peppers', quantity: `${people * 3} pieces` },
                { name: 'Broccoli', quantity: `${Math.ceil(people * days * 0.3)} heads` },
                { name: 'Carrots', quantity: `${people * 5} pieces` },
                { name: 'Spinach', quantity: `${people * 2} bags` },
                { name: 'Onions', quantity: `${people * 3} pieces` },
                { name: 'Garlic', quantity: '1 head' }
            ];
            
            const proteinItems = [
                { name: 'Chicken Breast', quantity: `${people * days * 0.4} lbs` },
                { name: 'Ground Turkey', quantity: `${people * days * 0.3} lbs` },
                { name: 'Salmon Fillets', quantity: `${people * 2} pieces` }
            ];
            
            const pantryItems = [
                { name: 'Brown Rice', quantity: `${Math.ceil(people * days * 0.2)} cups` },
                { name: 'Quinoa', quantity: `${Math.ceil(people * days * 0.15)} cups` },
                { name: 'Oats', quantity: `${Math.ceil(people * days * 0.1)} cups` },
                { name: 'Canned Tomatoes', quantity: `${people * 2} cans` }
            ];
            
            const dairyItems = [
                { name: 'Greek Yogurt', quantity: `${people * 3} containers` },
                { name: 'Eggs', quantity: `${people * 6} pieces` },
                { name: 'Cheese', quantity: `${people * 0.5} lbs` }
            ];
            
            // Adjust for diet type
            if (diet === 'vegetarian' || diet === 'vegan') {
                proteinItems.length = 0;
                proteinItems.push(
                    { name: 'Lentils', quantity: `${Math.ceil(people * days * 0.3)} cups` },
                    { name: 'Chickpeas', quantity: `${people * 3} cans` },
                    { name: 'Tofu', quantity: `${people * 2} blocks` }
                );
            }
            
            if (diet === 'vegan') {
                dairyItems.length = 0;
                dairyItems.push(
                    { name: 'Almond Milk', quantity: '1 carton' },
                    { name: 'Nutritional Yeast', quantity: '1 container' }
                );
            }
            
            // Populate shopping lists
            populateShoppingCategory(produceListElement, produceItems);
            populateShoppingCategory(proteinListElement, proteinItems);
            populateShoppingCategory(pantryListElement, pantryItems);
            populateShoppingCategory(dairyListElement, dairyItems);
        }

        function populateShoppingCategory(element, items) {
            element.innerHTML = '';
            items.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className = 'shopping-item';
                itemElement.innerHTML = `
                    <span class="item-name">${item.name}</span>
                    <span class="item-quantity">${item.quantity}</span>
                `;
                element.appendChild(itemElement);
            });
        }

        function generateMealSchedule(days, mealsPerDay, calories, diet) {
            const mealTemplates = {
                balanced: [
                    { name: 'Oatmeal with Berries', calories: 350 },
                    { name: 'Chicken Salad', calories: 450 },
                    { name: 'Salmon with Quinoa', calories: 550 },
                    { name: 'Greek Yogurt with Nuts', calories: 250 }
                ],
                keto: [
                    { name: 'Eggs with Avocado', calories: 400 },
                    { name: 'Chicken Caesar Salad', calories: 500 },
                    { name: 'Beef with Roasted Veggies', calories: 600 },
                    { name: 'Cheese and Nuts', calories: 300 }
                ],
                vegetarian: [
                    { name: 'Smoothie Bowl', calories: 350 },
                    { name: 'Lentil Soup', calories: 400 },
                    { name: 'Vegetable Stir-fry with Tofu', calories: 500 },
                    { name: 'Hummus with Veggies', calories: 200 }
                ]
            };
            
            const templates = mealTemplates[diet] || mealTemplates.balanced;
            const daysOfWeek = [
                { element: mondayMealsElement, name: 'Monday' },
                { element: tuesdayMealsElement, name: 'Tuesday' },
                { element: wednesdayMealsElement, name: 'Wednesday' },
                { element: thursdayMealsElement, name: 'Thursday' },
                { element: fridayMealsElement, name: 'Friday' },
                { element: weekendMealsElement, name: 'Weekend' }
            ];
            
            daysOfWeek.forEach(day => {
                day.element.innerHTML = '';
                for (let i = 0; i < mealsPerDay; i++) {
                    const meal = templates[i % templates.length];
                    const mealElement = document.createElement('div');
                    mealElement.className = 'meal-time';
                    mealElement.innerHTML = `
                        <span class="meal-name">${meal.name}</span>
                        <span class="meal-calories">${meal.calories} cal</span>
                    `;
                    day.element.appendChild(mealElement);
                }
            });
        }

        function applyTemplate(template) {
            switch(template) {
                case 'weightLoss':
                    peopleCountInput.value = 1;
                    calorieTargetInput.value = 1500;
                    dietTypeSelect.value = 'balanced';
                    break;
                case 'muscleGain':
                    peopleCountInput.value = 1;
                    calorieTargetInput.value = 2800;
                    dietTypeSelect.value = 'balanced';
                    break;
                case 'family':
                    peopleCountInput.value = 4;
                    calorieTargetInput.value = 2000;
                    dietTypeSelect.value = 'balanced';
                    break;
                case 'busyWeek':
                    cookingTimeInput.value = 30;
                    break;
                case 'vegetarian':
                    dietTypeSelect.value = 'vegetarian';
                    break;
                case 'keto':
                    dietTypeSelect.value = 'keto';
                    break;
            }
            generateMealPlan();
        }

        function printShoppingList() {
            window.print();
        }

        // Make functions available globally
        window.applyTemplate = applyTemplate;
        window.printShoppingList = printShoppingList;
    </script>
</body>
</html>
