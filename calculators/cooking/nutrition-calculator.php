<?php
/**
 * Nutrition Calculator
 * File: cooking/nutrition-calculator.php
 * Description: Advanced nutrition analysis with macro tracking, meal planning, and dietary recommendations
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutrition Calculator - Advanced Dietary Analysis Tool</title>
    <meta name="description" content="Calculate nutritional values, track macros, plan meals, and get personalized dietary recommendations for optimal health and fitness goals.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #a8e6cf 0%, #dcedc1 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .tab-navigation { display: flex; gap: 10px; margin-bottom: 25px; flex-wrap: wrap; }
        .tab-btn { 
            padding: 12px 24px; 
            background: #f8f9fa; 
            border: 2px solid #e0e0e0; 
            border-radius: 8px; 
            cursor: pointer; 
            transition: all 0.3s;
            font-weight: 600;
            color: #2c3e50;
        }
        .tab-btn.active { 
            background: linear-gradient(135deg, #a8e6cf 0%, #dcedc1 100%); 
            color: white; 
            border-color: #a8e6cf;
        }
        .tab-btn:hover:not(.active) {
            border-color: #a8e6cf;
            transform: translateY(-2px);
        }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; background: white; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #a8e6cf; box-shadow: 0 0 0 3px rgba(168, 230, 207, 0.1); }
        
        .input-with-unit { position: relative; }
        .input-with-unit input { padding-right: 60px; }
        .unit-display { 
            position: absolute; 
            right: 16px; 
            top: 50%; 
            transform: translateY(-50%); 
            color: #7f8c8d; 
            font-weight: 600;
        }
        
        .slider-container { margin-top: 10px; }
        .slider-value { text-align: center; font-weight: bold; color: #4cd964; margin-top: 5px; }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .checkbox-group input { width: auto; }
        
        .food-search { position: relative; margin-bottom: 20px; }
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #a8e6cf;
            border-top: none;
            border-radius: 0 0 10px 10px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        .search-result {
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid #f8f9fa;
            transition: background-color 0.2s;
        }
        .search-result:hover {
            background: #f8f9fa;
        }
        .search-result:last-child {
            border-bottom: none;
        }
        
        .selected-foods { margin-top: 20px; }
        .food-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 8px;
        }
        .food-info { flex: 1; }
        .food-name { font-weight: 600; color: #2c3e50; }
        .food-details { font-size: 0.85rem; color: #7f8c8d; }
        .food-actions { display: flex; gap: 10px; }
        .remove-food { 
            background: #e74c3c; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            padding: 5px 10px; 
            cursor: pointer; 
            font-size: 0.8rem;
        }
        
        .action-buttons { display: flex; gap: 15px; margin-top: 25px; flex-wrap: wrap; }
        .btn { padding: 14px 24px; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; font-weight: 600; }
        .btn-primary { background: linear-gradient(135deg, #a8e6cf 0%, #dcedc1 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(168, 230, 207, 0.3); }
        .btn-secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .btn-secondary:hover { background: #e9ecef; }
        
        .quick-meals { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-meals h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #a8e6cf; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(168, 230, 207, 0.15); }
        .quick-value { font-weight: bold; color: #4cd964; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .results-section { margin-top: 30px; }
        
        .nutrition-summary { 
            background: linear-gradient(135deg, #ffd3b6 0%, #ffaaa5 100%); 
            padding: 30px; 
            border-radius: 15px; 
            margin-bottom: 25px;
            text-align: center;
        }
        .summary-title { 
            font-size: 1.4rem; 
            font-weight: bold; 
            color: #2c3e50; 
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .calorie-total { 
            font-size: 3rem; 
            font-weight: bold; 
            color: #e17055; 
            margin-bottom: 10px;
            line-height: 1;
        }
        .calorie-label { 
            font-size: 1.1rem; 
            color: #2c3e50; 
            font-weight: 600;
            margin-bottom: 15px;
        }
        .macro-stats { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-top: 20px;
        }
        .macro-item { 
            background: rgba(255,255,255,0.9); 
            padding: 15px; 
            border-radius: 10px; 
        }
        .macro-value { 
            font-size: 1.3rem; 
            font-weight: bold; 
            color: #4cd964; 
            margin-bottom: 5px;
        }
        .macro-label { 
            font-size: 0.9rem; 
            color: #7f8c8d; 
        }
        
        .nutrition-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px;
        }
        .nutrition-card { 
            background: white; 
            padding: 25px; 
            border-radius: 12px; 
            border-left: 4px solid #a8e6cf;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        .nutrition-title { 
            font-size: 1.1rem; 
            font-weight: bold; 
            color: #2c3e50; 
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nutrition-list {
            list-style: none;
        }
        .nutrition-item {
            padding: 10px 0;
            border-bottom: 1px solid #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nutrition-item:last-child {
            border-bottom: none;
        }
        .nutrient-name {
            color: #34495e;
            font-weight: 500;
        }
        .nutrient-amount {
            color: #4cd964;
            font-weight: bold;
        }
        
        .progress-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            margin-top: 25px;
        }
        .progress-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .progress-bars {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .progress-item {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .progress-label {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .progress-bar {
            height: 20px;
            background: #ecf0f1;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 8px;
            position: relative;
        }
        .progress-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s ease-in-out;
            background: linear-gradient(90deg, #a8e6cf, #4cd964);
        }
        .progress-value {
            font-size: 0.85rem;
            color: #2c3e50;
            font-weight: 600;
        }
        
        .meal-plan {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-top: 25px;
        }
        .meal-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .meal-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .meal-tab {
            padding: 10px 20px;
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            color: #2c3e50;
        }
        .meal-tab.active {
            background: #a8e6cf;
            color: white;
            border-color: #a8e6cf;
        }
        .meal-content {
            display: none;
        }
        .meal-content.active {
            display: block;
        }
        
        .recommendations {
            background: #fffaf0;
            padding: 25px;
            border-radius: 12px;
            margin-top: 25px;
        }
        .rec-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .rec-list {
            list-style: none;
        }
        .rec-item {
            padding: 15px;
            border-bottom: 1px solid #f8f9fa;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            transition: background-color 0.2s;
        }
        .rec-item:hover {
            background: white;
        }
        .rec-item:last-child {
            border-bottom: none;
        }
        .rec-icon {
            font-size: 1.2rem;
            margin-top: 2px;
        }
        .rec-content { flex: 1; }
        .rec-category { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .rec-desc { font-size: 0.9rem; color: #7f8c8d; line-height: 1.4; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .nutrient-types { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin: 20px 0; }
        .nutrient-card { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #a8e6cf; }
        .nutrient-name { font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .nutrient-desc { font-size: 0.85rem; color: #7f8c8d; }
        
        .formula-box { background: #f0f8f5; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #a8e6cf; }
        .formula-box strong { color: #4cd964; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #f0f8f5; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .tab-navigation { flex-direction: column; }
            .action-buttons { flex-direction: column; }
            .nutrition-grid { grid-template-columns: 1fr; }
            .progress-bars { grid-template-columns: 1fr; }
            .macro-stats { grid-template-columns: 1fr; }
            .calorie-total { font-size: 2.5rem; }
            .meal-tabs { flex-direction: column; }
            .header h1 { font-size: 1.5rem; }
        }
        
        @media (max-width: 480px) {
            .calculator-card { padding: 20px; }
            .header { padding: 20px; }
            .nutrition-summary { padding: 20px; }
            .nutrition-card { padding: 20px; }
            .food-item { flex-direction: column; align-items: flex-start; gap: 10px; }
            .food-actions { align-self: flex-end; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🥗 Nutrition Calculator</h1>
            <p>Calculate nutritional values, track macros, plan meals, and get personalized dietary recommendations for optimal health and fitness goals</p>
        </div>

        <div class="calculator-card">
            <div class="tab-navigation">
                <button class="tab-btn active" onclick="switchTab('profile')">👤 Profile</button>
                <button class="tab-btn" onclick="switchTab('foods')">🍎 Foods</button>
                <button class="tab-btn" onclick="switchTab('goals')">🎯 Goals</button>
                <button class="tab-btn" onclick="switchTab('results')">📊 Results</button>
            </div>

            <!-- Profile Tab -->
            <div class="tab-content active" id="profile-tab">
                <h3>👤 Personal Profile</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="gender">Gender</label>
                        <select id="gender" class="control-select">
                            <option value="male">Male</option>
                            <option value="female" selected>Female</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="age">Age</label>
                        <div class="input-with-unit">
                            <input type="number" id="age" placeholder="e.g., 30" value="30" min="18" max="100">
                            <span class="unit-display">years</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="weight">Weight</label>
                        <div class="input-with-unit">
                            <input type="number" id="weight" placeholder="e.g., 70" value="65" step="0.1">
                            <span class="unit-display">kg</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="height">Height</label>
                        <div class="input-with-unit">
                            <input type="number" id="height" placeholder="e.g., 170" value="165">
                            <span class="unit-display">cm</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="activity">Activity Level</label>
                        <select id="activity" class="control-select">
                            <option value="sedentary">Sedentary (little exercise)</option>
                            <option value="light">Light (1-3 days/week)</option>
                            <option value="moderate" selected>Moderate (3-5 days/week)</option>
                            <option value="active">Active (6-7 days/week)</option>
                            <option value="athlete">Athlete (2x/day training)</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="dietType">Diet Type</label>
                        <select id="dietType" class="control-select">
                            <option value="balanced">Balanced</option>
                            <option value="keto">Keto/Low-carb</option>
                            <option value="paleo">Paleo</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="vegan">Vegan</option>
                            <option value="mediterranean">Mediterranean</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Foods Tab -->
            <div class="tab-content" id="foods-tab">
                <h3>🍎 Food Selection</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="foodSearch">Search Foods</label>
                        <input type="text" id="foodSearch" placeholder="Search for foods..." class="control-select">
                        <div class="search-results" id="searchResults"></div>
                    </div>
                    
                    <div class="control-group">
                        <label for="servingSize">Serving Size</label>
                        <div class="input-with-unit">
                            <input type="number" id="servingSize" placeholder="e.g., 100" value="100" step="1">
                            <span class="unit-display">grams</span>
                        </div>
                    </div>
                </div>
                
                <div class="selected-foods">
                    <h4>Selected Foods</h4>
                    <div id="selectedFoodsList">
                        <!-- Selected foods will appear here -->
                    </div>
                </div>
            </div>

            <!-- Goals Tab -->
            <div class="tab-content" id="goals-tab">
                <h3>🎯 Health & Fitness Goals</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="goal">Primary Goal</label>
                        <select id="goal" class="control-select">
                            <option value="maintain">Maintain Weight</option>
                            <option value="lose" selected>Lose Weight</option>
                            <option value="gain">Gain Weight</option>
                            <option value="muscle">Build Muscle</option>
                            <option value="performance">Athletic Performance</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="targetWeight">Target Weight</label>
                        <div class="input-with-unit">
                            <input type="number" id="targetWeight" placeholder="e.g., 60" value="60" step="0.1">
                            <span class="unit-display">kg</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="weeklyGoal">Weekly Goal</label>
                        <select id="weeklyGoal" class="control-select">
                            <option value="0.25">Lose 0.25 kg/week</option>
                            <option value="0.5" selected>Lose 0.5 kg/week</option>
                            <option value="0.75">Lose 0.75 kg/week</option>
                            <option value="1.0">Lose 1.0 kg/week</option>
                            <option value="-0.25">Gain 0.25 kg/week</option>
                            <option value="-0.5">Gain 0.5 kg/week</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label>Macro Preferences</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="highProtein">
                            <label for="highProtein">High Protein</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="lowCarb">
                            <label for="lowCarb">Low Carbohydrate</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="healthyFats">
                            <label for="healthyFats">Emphasis on Healthy Fats</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Tab -->
            <div class="tab-content" id="results-tab">
                <h3>📊 Nutrition Analysis Results</h3>
                <div class="results-section">
                    <div class="nutrition-summary">
                        <div class="summary-title">📈 Daily Nutrition Summary</div>
                        <div class="calorie-total" id="calorieTotal">0</div>
                        <div class="calorie-label" id="calorieLabel">calories per day</div>
                        
                        <div class="macro-stats">
                            <div class="macro-item">
                                <div class="macro-value" id="proteinAmount">0g</div>
                                <div class="macro-label">Protein</div>
                            </div>
                            <div class="macro-item">
                                <div class="macro-value" id="carbsAmount">0g</div>
                                <div class="macro-label">Carbohydrates</div>
                            </div>
                            <div class="macro-item">
                                <div class="macro-value" id="fatAmount">0g</div>
                                <div class="macro-label">Fat</div>
                            </div>
                            <div class="macro-item">
                                <div class="macro-value" id="fiberAmount">0g</div>
                                <div class="macro-label">Fiber</div>
                            </div>
                        </div>
                    </div>

                    <div class="nutrition-grid">
                        <div class="nutrition-card">
                            <div class="nutrition-title">🥛 Macronutrients</div>
                            <div class="nutrition-list" id="macronutrientsList">
                                <!-- Macronutrients will be listed here -->
                            </div>
                        </div>
                        
                        <div class="nutrition-card">
                            <div class="nutrition-title">💊 Micronutrients</div>
                            <div class="nutrition-list" id="micronutrientsList">
                                <!-- Micronutrients will be listed here -->
                            </div>
                        </div>
                    </div>

                    <div class="progress-section">
                        <div class="progress-title">📊 Daily Goal Progress</div>
                        <div class="progress-bars" id="goalProgress">
                            <!-- Progress bars will be generated here -->
                        </div>
                    </div>

                    <div class="meal-plan">
                        <div class="meal-title">🍽️ Sample Meal Plan</div>
                        <div class="meal-tabs">
                            <div class="meal-tab active" onclick="switchMealTab('breakfast')">Breakfast</div>
                            <div class="meal-tab" onclick="switchMealTab('lunch')">Lunch</div>
                            <div class="meal-tab" onclick="switchMealTab('dinner')">Dinner</div>
                            <div class="meal-tab" onclick="switchMealTab('snacks')">Snacks</div>
                        </div>
                        
                        <div class="meal-content active" id="breakfast-meal">
                            <!-- Breakfast content will be generated here -->
                        </div>
                        <div class="meal-content" id="lunch-meal">
                            <!-- Lunch content will be generated here -->
                        </div>
                        <div class="meal-content" id="dinner-meal">
                            <!-- Dinner content will be generated here -->
                        </div>
                        <div class="meal-content" id="snacks-meal">
                            <!-- Snacks content will be generated here -->
                        </div>
                    </div>

                    <div class="recommendations">
                        <div class="rec-title">💡 Personalized Recommendations</div>
                        <div class="rec-list" id="nutritionRecommendations">
                            <!-- Recommendations will be generated here -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="quick-meals">
                <h3>⚡ Common Meals & Foods</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="addQuickFood('chicken_breast')">
                        <div class="quick-value">Chicken Breast</div>
                        <div class="quick-label">165 cal / 100g</div>
                    </div>
                    <div class="quick-btn" onclick="addQuickFood('salmon')">
                        <div class="quick-value">Salmon</div>
                        <div class="quick-label">208 cal / 100g</div>
                    </div>
                    <div class="quick-btn" onclick="addQuickFood('brown_rice')">
                        <div class="quick-value">Brown Rice</div>
                        <div class="quick-label">111 cal / 100g</div>
                    </div>
                    <div class="quick-btn" onclick="addQuickFood('broccoli')">
                        <div class="quick-value">Broccoli</div>
                        <div class="quick-label">34 cal / 100g</div>
                    </div>
                    <div class="quick-btn" onclick="addQuickFood('avocado')">
                        <div class="quick-value">Avocado</div>
                        <div class="quick-label">160 cal / 100g</div>
                    </div>
                    <div class="quick-btn" onclick="addQuickFood('eggs')">
                        <div class="quick-value">Eggs</div>
                        <div class="quick-label">155 cal / 100g</div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button class="btn btn-primary" onclick="calculateNutrition()">📊 Calculate Nutrition</button>
                <button class="btn btn-secondary" onclick="resetCalculator()">🔄 Reset</button>
                <button class="btn btn-secondary" onclick="savePlan()">💾 Save Plan</button>
            </div>
        </div>

        <div class="info-section">
            <h2>🥗 Comprehensive Nutrition Analysis</h2>
            
            <p>Advanced nutritional analysis tool that provides detailed macro and micronutrient tracking, personalized recommendations, and meal planning based on your health goals and dietary preferences.</p>

            <h3>📊 Macronutrient Guidelines</h3>
            <div class="nutrient-types">
                <div class="nutrient-card">
                    <div class="nutrient-name">💪 Protein</div>
                    <div class="nutrient-desc">Essential for muscle repair, enzyme production, and hormone synthesis. Recommended: 0.8-2.0g per kg of body weight.</div>
                </div>
                <div class="nutrient-card">
                    <div class="nutrient-name">⚡ Carbohydrates</div>
                    <div class="nutrient-desc">Primary energy source for brain and muscles. Focus on complex carbs from whole foods.</div>
                </div>
                <div class="nutrient-card">
                    <div class="nutrient-name">🛢️ Fats</div>
                    <div class="nutrient-desc">Essential for hormone production, brain health, and vitamin absorption. Emphasize unsaturated fats.</div>
                </div>
                <div class="nutrient-card">
                    <div class="nutrient-name">🌾 Fiber</div>
                    <div class="nutrient-desc">Supports digestive health, blood sugar control, and heart health. Aim for 25-35g daily.</div>
                </div>
            </div>

            <h3>🎯 Calorie Calculation Methods</h3>
            <div class="formula-box">
                <strong>Harris-Benedict Equation (BMR):</strong><br>
                • <strong>Men:</strong> BMR = 88.362 + (13.397 × weight in kg) + (4.799 × height in cm) - (5.677 × age in years)<br>
                • <strong>Women:</strong> BMR = 447.593 + (9.247 × weight in kg) + (3.098 × height in cm) - (4.330 × age in years)<br><br>
                <strong>Total Daily Energy Expenditure (TDEE):</strong><br>
                • Sedentary: BMR × 1.2<br>
                • Light activity: BMR × 1.375<br>
                • Moderate activity: BMR × 1.55<br>
                • Very active: BMR × 1.725<br>
                • Extra active: BMR × 1.9
            </div>

            <h3>📈 Weight Management Guidelines</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Goal</th>
                        <th>Calorie Adjustment</th>
                        <th>Weekly Weight Change</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Weight Loss</td><td>TDEE - 500 calories</td><td>~0.5 kg loss per week</td></tr>
                    <tr><td>Maintenance</td><td>TDEE ± 0 calories</td><td>Weight stability</td></tr>
                    <tr><td>Weight Gain</td><td>TDEE + 500 calories</td><td>~0.5 kg gain per week</td></tr>
                    <tr><td>Muscle Building</td><td>TDEE + 300 calories</td><td>Lean mass focus</td></tr>
                    <tr><td>Rapid Loss</td><td>TDEE - 1000 calories</td><td>~1 kg loss per week</td></tr>
                </tbody>
            </table>

            <h3>💊 Essential Micronutrients</h3>
            <div class="probability-grid">
                <div class="probability-item">
                    <div class="prob-value">Vitamin D</div>
                    <div class="prob-label">Bone health, immunity</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">Iron</div>
                    <div class="prob-label">Oxygen transport</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">Calcium</div>
                    <div class="prob-label">Bone strength</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">Vitamin C</div>
                    <div class="prob-label">Immunity, collagen</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">Magnesium</div>
                    <div class="prob-label">Muscle function</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">Zinc</div>
                    <div class="prob-label">Immune support</div>
                </div>
            </div>

            <h3>🍽️ Meal Timing & Distribution</h3>
            <ul>
                <li><strong>Breakfast:</strong> 25% of daily calories - Focus on protein and complex carbs</li>
                <li><strong>Lunch:</strong> 35% of daily calories - Balanced macronutrients</li>
                <li><strong>Dinner:</strong> 30% of daily calories - Lighter, protein-focused</li>
                <li><strong>Snacks:</strong> 10% of daily calories - Nutrient-dense options</li>
                <li><strong>Pre-workout:</strong> 1-2 hours before exercise - Easily digestible carbs</li>
                <li><strong>Post-workout:</strong> Within 2 hours after exercise - Protein and carbs</li>
            </ul>

            <h3>🌱 Dietary Pattern Benefits</h3>
            <div class="formula-box">
                <strong>Popular Dietary Approaches:</strong><br>
                • <strong>Mediterranean:</strong> Heart health, longevity - Rich in olive oil, fish, vegetables<br>
                • <strong>Plant-based:</strong> Reduced chronic disease risk - Focus on whole plant foods<br>
                • <strong>Keto:</strong> Rapid weight loss, epilepsy management - Very low carb, high fat<br>
                • <strong>Paleo:</strong> Whole foods focus - Eliminates processed foods, grains, dairy<br>
                • <strong>Intermittent Fasting:</strong> Metabolic health - Time-restricted eating windows<br>
                • <strong>Flexitarian:</strong> Balanced approach - Primarily plant-based with occasional meat
            </div>

            <h3>📋 Food Quality Indicators</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Quality Level</th>
                        <th>Characteristics</th>
                        <th>Examples</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>High</td><td>Minimally processed, nutrient-dense</td><td>Vegetables, fruits, lean proteins</td></tr>
                    <tr><td>Medium</td><td>Moderately processed, some nutrients</td><td>Whole grain bread, yogurt</td></tr>
                    <tr><td>Low</td><td>Highly processed, low nutrients</td><td>Sugary drinks, chips, cookies</td></tr>
                    <tr><td>Empty Calories</td><td>High calories, minimal nutrients</td><td>Soda, candy, alcohol</td></tr>
                </tbody>
            </table>

            <h3>🔬 Nutrition Science Principles</h3>
            <ul>
                <li><strong>Energy Balance:</strong> Weight management follows calories in vs calories out</li>
                <li><strong>Nutrient Timing:</strong> When you eat can impact energy and recovery</li>
                <li><strong>Thermic Effect:</strong> Protein requires more energy to digest than carbs or fat</li>
                <li><strong>Glycemic Index:</strong> How quickly foods raise blood sugar levels</li>
                <li><strong>Nutrient Density:</strong> Maximizing nutrients per calorie consumed</li>
                <li><strong>Bioavailability:</strong> How well nutrients are absorbed and utilized</li>
            </ul>
        </div>

        <div class="footer">
            <p>🥗 Nutrition Calculator | Comprehensive Dietary Analysis</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Make informed nutritional choices with personalized analysis, meal planning, and evidence-based recommendations</p>
        </div>
    </div>

    <script>
        let selectedFoods = [];
        let foodDatabase = {
            'chicken_breast': { name: 'Chicken Breast', calories: 165, protein: 31, carbs: 0, fat: 3.6, fiber: 0 },
            'salmon': { name: 'Salmon', calories: 208, protein: 20, carbs: 0, fat: 13, fiber: 0 },
            'brown_rice': { name: 'Brown Rice', calories: 111, protein: 2.6, carbs: 23, fat: 0.9, fiber: 1.8 },
            'broccoli': { name: 'Broccoli', calories: 34, protein: 2.8, carbs: 7, fat: 0.4, fiber: 2.6 },
            'avocado': { name: 'Avocado', calories: 160, protein: 2, carbs: 9, fat: 15, fiber: 7 },
            'eggs': { name: 'Eggs', calories: 155, protein: 13, carbs: 1.1, fat: 11, fiber: 0 },
            'oats': { name: 'Oats', calories: 389, protein: 17, carbs: 66, fat: 7, fiber: 11 },
            'almonds': { name: 'Almonds', calories: 579, protein: 21, carbs: 22, fat: 50, fiber: 12 },
            'sweet_potato': { name: 'Sweet Potato', calories: 86, protein: 1.6, carbs: 20, fat: 0.1, fiber: 3 },
            'spinach': { name: 'Spinach', calories: 23, protein: 2.9, carbs: 3.6, fat: 0.4, fiber: 2.2 },
            'quinoa': { name: 'Quinoa', calories: 120, protein: 4.4, carbs: 21, fat: 1.9, fiber: 2.8 },
            'greek_yogurt': { name: 'Greek Yogurt', calories: 59, protein: 10, carbs: 3.6, fat: 0.4, fiber: 0 }
        };

        // Food search functionality
        document.getElementById('foodSearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const resultsContainer = document.getElementById('searchResults');
            
            if (searchTerm.length < 2) {
                resultsContainer.style.display = 'none';
                return;
            }
            
            const matches = Object.entries(foodDatabase).filter(([key, food]) => 
                food.name.toLowerCase().includes(searchTerm)
            );
            
            resultsContainer.innerHTML = '';
            matches.forEach(([key, food]) => {
                const result = document.createElement('div');
                result.className = 'search-result';
                result.textContent = food.name;
                result.onclick = () => addFoodToSelection(key, food);
                resultsContainer.appendChild(result);
            });
            
            resultsContainer.style.display = matches.length > 0 ? 'block' : 'none';
        });

        function addFoodToSelection(key, food) {
            const servingSize = parseFloat(document.getElementById('servingSize').value) || 100;
            const multiplier = servingSize / 100;
            
            selectedFoods.push({
                key: key,
                name: food.name,
                serving: servingSize,
                calories: food.calories * multiplier,
                protein: food.protein * multiplier,
                carbs: food.carbs * multiplier,
                fat: food.fat * multiplier,
                fiber: food.fiber * multiplier
            });
            
            updateSelectedFoodsList();
            document.getElementById('foodSearch').value = '';
            document.getElementById('searchResults').style.display = 'none';
        }

        function addQuickFood(foodKey) {
            const food = foodDatabase[foodKey];
            if (food) {
                addFoodToSelection(foodKey, food);
            }
        }

        function updateSelectedFoodsList() {
            const container = document.getElementById('selectedFoodsList');
            container.innerHTML = '';
            
            selectedFoods.forEach((food, index) => {
                const foodItem = document.createElement('div');
                foodItem.className = 'food-item';
                foodItem.innerHTML = `
                    <div class="food-info">
                        <div class="food-name">${food.name}</div>
                        <div class="food-details">${food.serving}g • ${Math.round(food.calories)} cal</div>
                    </div>
                    <div class="food-actions">
                        <button class="remove-food" onclick="removeFood(${index})">Remove</button>
                    </div>
                `;
                container.appendChild(foodItem);
            });
        }

        function removeFood(index) {
            selectedFoods.splice(index, 1);
            updateSelectedFoodsList();
        }

        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Activate selected button
            event.target.classList.add('active');
        }

        function switchMealTab(mealType) {
            // Hide all meal contents
            document.querySelectorAll('.meal-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Remove active class from all meal tabs
            document.querySelectorAll('.meal-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected meal content
            document.getElementById(mealType + '-meal').classList.add('active');
            
            // Activate selected meal tab
            event.target.classList.add('active');
        }

        function calculateNutrition() {
            // Get profile data
            const gender = document.getElementById('gender').value;
            const age = parseFloat(document.getElementById('age').value) || 30;
            const weight = parseFloat(document.getElementById('weight').value) || 65;
            const height = parseFloat(document.getElementById('height').value) || 165;
            const activity = document.getElementById('activity').value;
            const dietType = document.getElementById('dietType').value;
            
            // Get goals data
            const goal = document.getElementById('goal').value;
            const targetWeight = parseFloat(document.getElementById('targetWeight').value) || 60;
            const weeklyGoal = parseFloat(document.getElementById('weeklyGoal').value) || 0.5;
            const highProtein = document.getElementById('highProtein').checked;
            const lowCarb = document.getElementById('lowCarb').checked;
            const healthyFats = document.getElementById('healthyFats').checked;
            
            // Calculate BMR and TDEE
            const bmr = calculateBMR(gender, weight, height, age);
            const tdee = calculateTDEE(bmr, activity);
            const calorieTarget = calculateCalorieTarget(tdee, goal, weeklyGoal);
            
            // Calculate selected foods totals
            const foodTotals = calculateFoodTotals();
            
            // Calculate macro targets
            const macroTargets = calculateMacroTargets(calorieTarget, weight, goal, highProtein, lowCarb, healthyFats);
            
            // Generate meal plan and recommendations
            const mealPlan = generateMealPlan(calorieTarget, macroTargets, dietType);
            const recommendations = generateRecommendations(foodTotals, macroTargets, goal, dietType);
            
            // Update display
            updateResults(calorieTarget, foodTotals, macroTargets, mealPlan, recommendations);
            
            // Switch to results tab
            switchTab('results');
        }
        
        function calculateBMR(gender, weight, height, age) {
            if (gender === 'male') {
                return 88.362 + (13.397 * weight) + (4.799 * height) - (5.677 * age);
            } else {
                return 447.593 + (9.247 * weight) + (3.098 * height) - (4.330 * age);
            }
        }
        
        function calculateTDEE(bmr, activity) {
            const multipliers = {
                'sedentary': 1.2,
                'light': 1.375,
                'moderate': 1.55,
                'active': 1.725,
                'athlete': 1.9
            };
            return bmr * multipliers[activity];
        }
        
        function calculateCalorieTarget(tdee, goal, weeklyGoal) {
            const calorieAdjustments = {
                'maintain': 0,
                'lose': -500,
                'gain': 500,
                'muscle': 300,
                'performance': 200
            };
            
            // Adjust for weekly goal intensity
            const weeklyAdjustment = weeklyGoal * 1100; // 1100 calories ≈ 0.5kg body weight
            return Math.round(tdee + calorieAdjustments[goal] + weeklyAdjustment);
        }
        
        function calculateFoodTotals() {
            return selectedFoods.reduce((totals, food) => {
                totals.calories += food.calories;
                totals.protein += food.protein;
                totals.carbs += food.carbs;
                totals.fat += food.fat;
                totals.fiber += food.fiber;
                return totals;
            }, { calories: 0, protein: 0, carbs: 0, fat: 0, fiber: 0 });
        }
        
        function calculateMacroTargets(calories, weight, goal, highProtein, lowCarb, healthyFats) {
            let protein, carbs, fat;
            
            // Protein calculation
            if (highProtein || goal === 'muscle') {
                protein = weight * 2.2; // 2.2g per kg for high protein
            } else if (goal === 'lose') {
                protein = weight * 1.8; // 1.8g per kg for weight loss
            } else {
                protein = weight * 1.2; // 1.2g per kg for maintenance
            }
            
            // Fat calculation
            if (healthyFats) {
                fat = (calories * 0.35) / 9; // 35% from fat
            } else {
                fat = (calories * 0.25) / 9; // 25% from fat
            }
            
            // Carb calculation
            const proteinCalories = protein * 4;
            const fatCalories = fat * 9;
            const carbCalories = calories - proteinCalories - fatCalories;
            carbs = lowCarb ? Math.max(carbCalories * 0.5 / 4, 50) : carbCalories / 4; // Minimum 50g carbs
            
            return {
                protein: Math.round(protein),
                carbs: Math.round(carbs),
                fat: Math.round(fat),
                fiber: 25 // Standard fiber target
            };
        }
        
        function generateMealPlan(calories, macros, dietType) {
            const mealDistribution = {
                breakfast: 0.25,
                lunch: 0.35,
                dinner: 0.30,
                snacks: 0.10
            };
            
            const meals = {};
            
            Object.keys(mealDistribution).forEach(meal => {
                const mealCalories = Math.round(calories * mealDistribution[meal]);
                const mealProtein = Math.round(macros.protein * mealDistribution[meal]);
                const mealCarbs = Math.round(macros.carbs * mealDistribution[meal]);
                const mealFat = Math.round(macros.fat * mealDistribution[meal]);
                
                meals[meal] = {
                    calories: mealCalories,
                    protein: mealProtein,
                    carbs: mealCarbs,
                    fat: mealFat,
                    suggestions: generateMealSuggestions(meal, dietType, mealCalories)
                };
            });
            
            return meals;
        }
        
        function generateMealSuggestions(meal, dietType, calories) {
            const suggestions = {
                breakfast: [
                    "Oatmeal with berries and almonds",
                    "Greek yogurt with honey and nuts",
                    "Scrambled eggs with whole grain toast",
                    "Smoothie with protein powder and spinach"
                ],
                lunch: [
                    "Grilled chicken salad with olive oil dressing",
                    "Quinoa bowl with roasted vegetables",
                    "Turkey and avocado whole grain wrap",
                    "Lentil soup with whole grain bread"
                ],
                dinner: [
                    "Baked salmon with steamed broccoli",
                    "Lean steak with sweet potato and greens",
                    "Stir-fried tofu with brown rice",
                    "Chicken and vegetable skewers"
                ],
                snacks: [
                    "Apple with peanut butter",
                    "Carrot sticks with hummus",
                    "Handful of mixed nuts",
                    "Greek yogurt with berries"
                ]
            };
            
            return suggestions[meal] || [];
        }
        
        function generateRecommendations(foodTotals, macroTargets, goal, dietType) {
            const recommendations = [];
            
            // Protein recommendations
            if (foodTotals.protein < macroTargets.protein * 0.8) {
                recommendations.push({
                    icon: '💪',
                    category: 'Protein Intake',
                    description: 'Consider adding more protein sources like chicken, fish, eggs, or legumes to meet your daily target.'
                });
            }
            
            // Fiber recommendations
            if (foodTotals.fiber < 20) {
                recommendations.push({
                    icon: '🌾',
                    category: 'Fiber Intake',
                    description: 'Increase fiber intake with more vegetables, fruits, whole grains, and legumes for better digestive health.'
                });
            }
            
            // Hydration reminder
            recommendations.push({
                icon: '💧',
                category: 'Hydration',
                description: 'Remember to drink 2-3 liters of water daily for optimal metabolism and overall health.'
            });
            
            // Goal-specific recommendations
            if (goal === 'lose') {
                recommendations.push({
                    icon: '⚖️',
                    category: 'Weight Loss',
                    description: 'Focus on nutrient-dense foods and consider incorporating regular physical activity for sustainable weight loss.'
                });
            }
            
            if (goal === 'muscle') {
                recommendations.push({
                    icon: '🏋️',
                    category: 'Muscle Building',
                    description: 'Ensure adequate protein intake and consider timing protein consumption around your workouts.'
                });
            }
            
            // Diet type recommendations
            if (dietType === 'vegetarian' || dietType === 'vegan') {
                recommendations.push({
                    icon: '🌱',
                    category: 'Plant-based Nutrition',
                    description: 'Combine different plant protein sources throughout the day to ensure complete amino acid intake.'
                });
            }
            
            return recommendations;
        }
        
        function updateResults(calorieTarget, foodTotals, macroTargets, mealPlan, recommendations) {
            // Update calorie summary
            document.getElementById('calorieTotal').textContent = calorieTarget;
            document.getElementById('calorieLabel').textContent = 'calories per day';
            
            // Update macro amounts
            document.getElementById('proteinAmount').textContent = macroTargets.protein + 'g';
            document.getElementById('carbsAmount').textContent = macroTargets.carbs + 'g';
            document.getElementById('fatAmount').textContent = macroTargets.fat + 'g';
            document.getElementById('fiberAmount').textContent = macroTargets.fiber + 'g';
            
            // Update macronutrients list
            updateMacronutrientsList(macroTargets);
            
            // Update micronutrients list
            updateMicronutrientsList();
            
            // Update progress bars
            updateProgressBars(foodTotals, macroTargets, calorieTarget);
            
            // Update meal plan
            updateMealPlan(mealPlan);
            
            // Update recommendations
            updateRecommendations(recommendations);
        }
        
        function updateMacronutrientsList(macros) {
            const container = document.getElementById('macronutrientsList');
            container.innerHTML = '';
            
            const nutrients = [
                { name: 'Protein', amount: macros.protein + 'g', target: macros.protein + 'g' },
                { name: 'Carbohydrates', amount: macros.carbs + 'g', target: macros.carbs + 'g' },
                { name: 'Fat', amount: macros.fat + 'g', target: macros.fat + 'g' },
                { name: 'Fiber', amount: macros.fiber + 'g', target: macros.fiber + 'g' },
                { name: 'Sugars', amount: '< 50g', target: 'Minimal' },
                { name: 'Saturated Fat', amount: '< 22g', target: 'Limited' }
            ];
            
            nutrients.forEach(nutrient => {
                const item = document.createElement('div');
                item.className = 'nutrition-item';
                item.innerHTML = `
                    <span class="nutrient-name">${nutrient.name}</span>
                    <span class="nutrient-amount">${nutrient.amount}</span>
                `;
                container.appendChild(item);
            });
        }
        
        function updateMicronutrientsList() {
            const container = document.getElementById('micronutrientsList');
            container.innerHTML = '';
            
            const nutrients = [
                { name: 'Vitamin D', amount: '15-20 mcg', status: 'Adequate' },
                { name: 'Calcium', amount: '1000-1200 mg', status: 'Sufficient' },
                { name: 'Iron', amount: '8-18 mg', status: 'Optimal' },
                { name: 'Vitamin C', amount: '75-90 mg', status: 'Good' },
                { name: 'Magnesium', amount: '310-420 mg', status: 'Adequate' },
                { name: 'Potassium', amount: '2600-3400 mg', status: 'Monitor' }
            ];
            
            nutrients.forEach(nutrient => {
                const item = document.createElement('div');
                item.className = 'nutrition-item';
                item.innerHTML = `
                    <span class="nutrient-name">${nutrient.name}</span>
                    <span class="nutrient-amount">${nutrient.amount}</span>
                `;
                container.appendChild(item);
            });
        }
        
        function updateProgressBars(foodTotals, macroTargets, calorieTarget) {
            const container = document.getElementById('goalProgress');
            container.innerHTML = '';
            
            const goals = [
                { label: 'Calories', current: foodTotals.calories, target: calorieTarget, unit: 'cal' },
                { label: 'Protein', current: foodTotals.protein, target: macroTargets.protein, unit: 'g' },
                { label: 'Carbs', current: foodTotals.carbs, target: macroTargets.carbs, unit: 'g' },
                { label: 'Fat', current: foodTotals.fat, target: macroTargets.fat, unit: 'g' },
                { label: 'Fiber', current: foodTotals.fiber, target: macroTargets.fiber, unit: 'g' }
            ];
            
            goals.forEach(goal => {
                const percentage = Math.min((goal.current / goal.target) * 100, 100);
                const progressItem = document.createElement('div');
                progressItem.className = 'progress-item';
                progressItem.innerHTML = `
                    <div class="progress-label">${goal.label}</div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: ${percentage}%"></div>
                    </div>
                    <div class="progress-value">${Math.round(goal.current)}/${goal.target}${goal.unit}</div>
                `;
                container.appendChild(progressItem);
            });
        }
        
        function updateMealPlan(mealPlan) {
            Object.keys(mealPlan).forEach(meal => {
                const container = document.getElementById(`${meal}-meal`);
                const plan = mealPlan[meal];
                
                container.innerHTML = `
                    <div style="text-align: center; margin-bottom: 15px;">
                        <strong>${Math.round(plan.calories)} calories</strong> • 
                        P: ${plan.protein}g • C: ${plan.carbs}g • F: ${plan.fat}g
                    </div>
                    <div style="font-size: 0.9rem; color: #555;">
                        <strong>Suggestions:</strong>
                        <ul style="margin-top: 10px; padding-left: 20px;">
                            ${plan.suggestions.map(suggestion => `<li>${suggestion}</li>`).join('')}
                        </ul>
                    </div>
                `;
            });
        }
        
        function updateRecommendations(recommendations) {
            const container = document.getElementById('nutritionRecommendations');
            container.innerHTML = '';
            
            recommendations.forEach(rec => {
                const item = document.createElement('div');
                item.className = 'rec-item';
                item.innerHTML = `
                    <div class="rec-icon">${rec.icon}</div>
                    <div class="rec-content">
                        <div class="rec-category">${rec.category}</div>
                        <div class="rec-desc">${rec.description}</div>
                    </div>
                `;
                container.appendChild(item);
            });
        }
        
        function resetCalculator() {
            // Reset all inputs to default values
            document.getElementById('gender').value = 'female';
            document.getElementById('age').value = '30';
            document.getElementById('weight').value = '65';
            document.getElementById('height').value = '165';
            document.getElementById('activity').value = 'moderate';
            document.getElementById('dietType').value = 'balanced';
            document.getElementById('goal').value = 'lose';
            document.getElementById('targetWeight').value = '60';
            document.getElementById('weeklyGoal').value = '0.5';
            document.getElementById('highProtein').checked = false;
            document.getElementById('lowCarb').checked = false;
            document.getElementById('healthyFats').checked = false;
            document.getElementById('servingSize').value = '100';
            document.getElementById('foodSearch').value = '';
            
            // Clear selected foods
            selectedFoods = [];
            updateSelectedFoodsList();
        }
        
        function savePlan() {
            const calorieTarget = document.getElementById('calorieTotal').textContent;
            const proteinTarget = document.getElementById('proteinAmount').textContent;
            
            let plan = 'Nutrition Plan\n';
            plan += 'Generated: ' + new Date().toLocaleString() + '\n\n';
            plan += `Daily Calorie Target: ${calorieTarget} calories\n`;
            plan += `Protein Target: ${proteinTarget}\n\n`;
            plan += 'Complete nutritional analysis and meal recommendations provided.';
            
            const blob = new Blob([plan], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'nutrition-plan.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        // Initialize calculator
        window.onload = function() {
            // Set initial state
            updateSelectedFoodsList();
        };
    </script>
</body>
</html>
