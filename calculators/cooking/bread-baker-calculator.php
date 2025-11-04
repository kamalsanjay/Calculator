<?php
/**
 * Bread Baker Calculator
 * File: cooking/bread-baker-calculator.php
 * Description: Advanced bread baking calculator with recipe scaling, hydration levels, and professional baking techniques
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bread Baker Calculator - Professional Baking Assistant</title>
    <meta name="description" content="Calculate perfect bread recipes with precise hydration, fermentation times, and professional baking techniques for artisan bread making.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); min-height: 100vh; padding: 20px; }
        
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
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); 
            color: white; 
            border-color: #f6d365;
        }
        .tab-btn:hover:not(.active) {
            border-color: #f6d365;
            transform: translateY(-2px);
        }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; background: white; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #f6d365; box-shadow: 0 0 0 3px rgba(246, 211, 101, 0.1); }
        
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
        .slider-value { text-align: center; font-weight: bold; color: #e17055; margin-top: 5px; }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .checkbox-group input { width: auto; }
        
        .ingredient-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 15px; }
        .ingredient-card { 
            background: #f8f9fa; 
            padding: 15px; 
            border-radius: 8px; 
            border-left: 4px solid #f6d365;
            text-align: center;
        }
        .ingredient-name { font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .ingredient-amount { font-size: 1.2rem; font-weight: bold; color: #e17055; }
        .ingredient-unit { font-size: 0.85rem; color: #7f8c8d; }
        
        .action-buttons { display: flex; gap: 15px; margin-top: 25px; flex-wrap: wrap; }
        .btn { padding: 14px 24px; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; font-weight: 600; }
        .btn-primary { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(246, 211, 101, 0.3); }
        .btn-secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .btn-secondary:hover { background: #e9ecef; }
        
        .quick-bake { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-bake h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #f6d365; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(246, 211, 101, 0.15); }
        .quick-value { font-weight: bold; color: #e17055; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .results-section { margin-top: 30px; }
        
        .recipe-summary { 
            background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%); 
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
        .dough-weight { 
            font-size: 3rem; 
            font-weight: bold; 
            color: #e17055; 
            margin-bottom: 10px;
            line-height: 1;
        }
        .weight-label { 
            font-size: 1.1rem; 
            color: #2c3e50; 
            font-weight: 600;
            margin-bottom: 15px;
        }
        .baking-stats { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-top: 20px;
        }
        .stat-item { 
            background: rgba(255,255,255,0.9); 
            padding: 15px; 
            border-radius: 10px; 
        }
        .stat-value { 
            font-size: 1.3rem; 
            font-weight: bold; 
            color: #e17055; 
            margin-bottom: 5px;
        }
        .stat-label { 
            font-size: 0.9rem; 
            color: #7f8c8d; 
        }
        
        .ingredients-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px;
        }
        .ingredients-card { 
            background: white; 
            padding: 25px; 
            border-radius: 12px; 
            border-left: 4px solid #f6d365;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        .ingredients-title { 
            font-size: 1.1rem; 
            font-weight: bold; 
            color: #2c3e50; 
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .ingredients-list {
            list-style: none;
        }
        .ingredient-item {
            padding: 10px 0;
            border-bottom: 1px solid #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ingredient-item:last-child {
            border-bottom: none;
        }
        .item-name {
            color: #34495e;
            font-weight: 500;
        }
        .item-amount {
            color: #e17055;
            font-weight: bold;
        }
        
        .timeline { 
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            margin-top: 25px;
        }
        .timeline-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .timeline-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .timeline-step {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #e0e0e0;
            transition: transform 0.3s;
        }
        .timeline-step.active {
            border-color: #f6d365;
            transform: scale(1.05);
        }
        .step-time {
            font-size: 1.1rem;
            font-weight: bold;
            color: #e17055;
            margin-bottom: 8px;
        }
        .step-duration {
            font-size: 0.9rem;
            color: #0984e3;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .step-desc {
            font-size: 0.85rem;
            color: #7f8c8d;
            line-height: 1.4;
        }
        
        .baking-chart {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-top: 25px;
        }
        .chart-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .chart-bar {
            display: flex;
            align-items: center;
            margin: 15px 0;
            gap: 15px;
        }
        .chart-label {
            width: 120px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
        }
        .chart-bar-inner {
            flex: 1;
            height: 30px;
            background: #ecf0f1;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }
        .chart-bar-fill {
            height: 100%;
            border-radius: 15px;
            transition: width 0.5s ease-in-out;
            background: linear-gradient(90deg, #f6d365, #fda085);
        }
        .chart-percentage {
            width: 80px;
            text-align: right;
            font-weight: bold;
            color: #2c3e50;
            font-size: 0.9rem;
        }
        
        .tips-section { margin-top: 30px; }
        .tips-list { 
            max-height: 300px; 
            overflow-y: auto; 
            border: 1px solid #e0e0e0; 
            border-radius: 12px; 
            padding: 15px;
            background: #f8f9fa;
        }
        .tip-item { 
            padding: 12px 15px; 
            border-bottom: 1px solid #e0e0e0; 
            display: flex; 
            align-items: flex-start;
            gap: 12px;
            transition: background-color 0.2s;
        }
        .tip-item:hover { background: white; }
        .tip-item:last-child { border-bottom: none; }
        .tip-icon { font-size: 1.2rem; }
        .tip-content { flex: 1; }
        .tip-title { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .tip-desc { font-size: 0.9rem; color: #7f8c8d; line-height: 1.4; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .bread-types { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin: 20px 0; }
        .bread-card { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #f6d365; }
        .bread-name { font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .bread-desc { font-size: 0.85rem; color: #7f8c8d; }
        
        .formula-box { background: #fffaf0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #f6d365; }
        .formula-box strong { color: #e17055; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #fffaf0; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .tab-navigation { flex-direction: column; }
            .action-buttons { flex-direction: column; }
            .ingredients-grid { grid-template-columns: 1fr; }
            .timeline-steps { grid-template-columns: 1fr; }
            .baking-stats { grid-template-columns: 1fr; }
            .dough-weight { font-size: 2.5rem; }
            .ingredient-grid { grid-template-columns: 1fr 1fr; }
            .header h1 { font-size: 1.5rem; }
        }
        
        @media (max-width: 480px) {
            .calculator-card { padding: 20px; }
            .header { padding: 20px; }
            .recipe-summary { padding: 20px; }
            .ingredients-card { padding: 20px; }
            .chart-bar { flex-direction: column; align-items: flex-start; gap: 8px; }
            .chart-label { width: auto; }
            .ingredient-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍞 Bread Baker Calculator</h1>
            <p>Calculate perfect bread recipes with precise hydration, fermentation times, and professional baking techniques for artisan bread making</p>
        </div>

        <div class="calculator-card">
            <div class="tab-navigation">
                <button class="tab-btn active" onclick="switchTab('basic')">📊 Basic Recipe</button>
                <button class="tab-btn" onclick="switchTab('advanced')">⚡ Advanced</button>
                <button class="tab-btn" onclick="switchTab('ingredients')">🥖 Ingredients</button>
                <button class="tab-btn" onclick="switchTab('results')">📈 Results</button>
            </div>

            <!-- Basic Recipe Tab -->
            <div class="tab-content active" id="basic-tab">
                <h3>📊 Basic Bread Recipe</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="breadType">Bread Type</label>
                        <select id="breadType" class="control-select" onchange="updateRecipeDefaults()">
                            <option value="white">White Bread</option>
                            <option value="wholewheat">Whole Wheat</option>
                            <option value="sourdough">Sourdough</option>
                            <option value="rye">Rye Bread</option>
                            <option value="ciabatta">Ciabatta</option>
                            <option value="brioche">Brioche</option>
                            <option value="baguette">Baguette</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="doughWeight">Desired Dough Weight</label>
                        <div class="input-with-unit">
                            <input type="number" id="doughWeight" placeholder="e.g., 1000" value="1000" min="100" max="5000">
                            <span class="unit-display">grams</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="hydration">Hydration Level</label>
                        <input type="range" id="hydration" min="50" max="90" value="65" class="slider-container">
                        <div class="slider-value" id="hydrationValue">65%</div>
                    </div>
                    
                    <div class="control-group">
                        <label for="saltPercentage">Salt Percentage</label>
                        <input type="range" id="saltPercentage" min="1" max="3" value="2" step="0.1" class="slider-container">
                        <div class="slider-value" id="saltValue">2.0%</div>
                    </div>
                </div>
            </div>

            <!-- Advanced Tab -->
            <div class="tab-content" id="advanced-tab">
                <h3>⚡ Advanced Baking Parameters</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="yeastType">Yeast Type</label>
                        <select id="yeastType" class="control-select">
                            <option value="instant">Instant Yeast</option>
                            <option value="active_dry">Active Dry Yeast</option>
                            <option value="fresh">Fresh Yeast</option>
                            <option value="sourdough_starter">Sourdough Starter</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="yeastPercentage">Yeast Percentage</label>
                        <input type="range" id="yeastPercentage" min="0.5" max="3" value="1.5" step="0.1" class="slider-container">
                        <div class="slider-value" id="yeastValue">1.5%</div>
                    </div>
                    
                    <div class="control-group">
                        <label for="preferment">Pre-ferment Usage</label>
                        <select id="preferment" class="control-select">
                            <option value="none">No Pre-ferment</option>
                            <option value="poolish">Poolish (Liquid)</option>
                            <option value="biga">Biga (Stiff)</option>
                            <option value="sponge">Sponge</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="fermentationTime">Fermentation Time</label>
                        <div class="input-with-unit">
                            <input type="number" id="fermentationTime" placeholder="e.g., 2" value="2" step="0.5">
                            <span class="unit-display">hours</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ingredients Tab -->
            <div class="tab-content" id="ingredients-tab">
                <h3>🥖 Additional Ingredients</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="addFlour1">Additional Flour 1</label>
                        <select id="addFlour1" class="control-select">
                            <option value="none">None</option>
                            <option value="rye">Rye Flour</option>
                            <option value="spelt">Spelt Flour</option>
                            <option value="buckwheat">Buckwheat Flour</option>
                            <option value="cornmeal">Cornmeal</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="addFlour1Percentage">Flour 1 Percentage</label>
                        <input type="range" id="addFlour1Percentage" min="0" max="30" value="0" class="slider-container">
                        <div class="slider-value" id="flour1Value">0%</div>
                    </div>
                    
                    <div class="control-group">
                        <label for="addIns">Add-ins & Flavorings</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="addSeeds">
                            <label for="addSeeds">Seeds (sunflower, flax, etc.)</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="addNuts">
                            <label for="addNuts">Nuts (walnuts, almonds, etc.)</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="addHerbs">
                            <label for="addHerbs">Herbs (rosemary, thyme, etc.)</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="addCheese">
                            <label for="addCheese">Cheese (parmesan, cheddar, etc.)</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Tab -->
            <div class="tab-content" id="results-tab">
                <h3>📈 Baking Results & Instructions</h3>
                <div class="results-section">
                    <div class="recipe-summary">
                        <div class="summary-title">🍞 Your Bread Recipe</div>
                        <div class="dough-weight" id="finalDoughWeight">0</div>
                        <div class="weight-label" id="doughWeightLabel">grams total dough weight</div>
                        
                        <div class="baking-stats">
                            <div class="stat-item">
                                <div class="stat-value" id="hydrationResult">0%</div>
                                <div class="stat-label">Hydration Level</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value" id="flourWeight">0g</div>
                                <div class="stat-label">Total Flour</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value" id="waterWeight">0g</div>
                                <div class="stat-label">Total Water</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value" id="saltWeight">0g</div>
                                <div class="stat-label">Salt</div>
                            </div>
                        </div>
                    </div>

                    <div class="ingredients-grid">
                        <div class="ingredients-card">
                            <div class="ingredients-title">🥣 Main Ingredients</div>
                            <div class="ingredients-list" id="mainIngredients">
                                <!-- Main ingredients will be listed here -->
                            </div>
                        </div>
                        
                        <div class="ingredients-card">
                            <div class="ingredients-title">⚡ Additional Ingredients</div>
                            <div class="ingredients-list" id="additionalIngredients">
                                <!-- Additional ingredients will be listed here -->
                            </div>
                        </div>
                    </div>

                    <div class="timeline">
                        <div class="timeline-title">⏰ Baking Timeline</div>
                        <div class="timeline-steps" id="bakingTimeline">
                            <!-- Timeline steps will be generated here -->
                        </div>
                    </div>

                    <div class="baking-chart">
                        <div class="chart-title">📊 Ingredient Proportions</div>
                        <div id="ingredientChart">
                            <!-- Chart bars will be generated here -->
                        </div>
                    </div>

                    <div class="tips-section">
                        <h3>💡 Professional Baking Tips</h3>
                        <div class="tips-list" id="bakingTips">
                            <!-- Baking tips will be generated here -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="quick-bake">
                <h3>⚡ Popular Bread Types</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="loadBreadType('white')">
                        <div class="quick-value">White Bread</div>
                        <div class="quick-label">65% hydration</div>
                    </div>
                    <div class="quick-btn" onclick="loadBreadType('sourdough')">
                        <div class="quick-value">Sourdough</div>
                        <div class="quick-label">75% hydration</div>
                    </div>
                    <div class="quick-btn" onclick="loadBreadType('ciabatta')">
                        <div class="quick-value">Ciabatta</div>
                        <div class="quick-label">80% hydration</div>
                    </div>
                    <div class="quick-btn" onclick="loadBreadType('wholewheat')">
                        <div class="quick-value">Whole Wheat</div>
                        <div class="quick-label">70% hydration</div>
                    </div>
                    <div class="quick-btn" onclick="loadBreadType('brioche')">
                        <div class="quick-value">Brioche</div>
                        <div class="quick-label">Rich & buttery</div>
                    </div>
                    <div class="quick-btn" onclick="loadBreadType('baguette')">
                        <div class="quick-value">Baguette</div>
                        <div class="quick-label">Crispy crust</div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button class="btn btn-primary" onclick="calculateRecipe()">🍞 Calculate Recipe</button>
                <button class="btn btn-secondary" onclick="resetCalculator()">🔄 Reset</button>
                <button class="btn btn-secondary" onclick="saveRecipe()">💾 Save Recipe</button>
            </div>
        </div>

        <div class="info-section">
            <h2>🍞 Artisan Bread Baking</h2>
            
            <p>Master the art of bread making with precise calculations, professional techniques, and scientific understanding of fermentation and gluten development.</p>

            <h3>🥖 Bread Types & Characteristics</h3>
            <div class="bread-types">
                <div class="bread-card">
                    <div class="bread-name">🍞 White Bread</div>
                    <div class="bread-desc">Soft crumb, mild flavor, 60-68% hydration, perfect for sandwiches</div>
                </div>
                <div class="bread-card">
                    <div class="bread-name">🌾 Whole Wheat</div>
                    <div class="bread-desc">Nutty flavor, denser crumb, 68-75% hydration, higher fiber content</div>
                </div>
                <div class="bread-card">
                    <div class="bread-name">🥖 Sourdough</div>
                    <div class="bread-desc">Tangy flavor, chewy crust, 70-85% hydration, natural fermentation</div>
                </div>
                <div class="bread-card">
                    <div class="bread-name">🌾 Rye Bread</div>
                    <div class="bread-desc">Dense texture, distinct flavor, 65-75% hydration, traditional European</div>
                </div>
                <div class="bread-card">
                    <div class="bread-name">🇮🇹 Ciabatta</div>
                    <div class="bread-desc">Open crumb, crispy crust, 75-85% hydration, Italian classic</div>
                </div>
                <div class="bread-card">
                    <div class="bread-name">🇫🇷 Baguette</div>
                    <div class="bread-desc">Crispy crust, light crumb, 65-70% hydration, French tradition</div>
                </div>
            </div>

            <h3>📊 Baker's Percentage System</h3>
            <div class="formula-box">
                <strong>Baker's Math Principles:</strong><br>
                • <strong>Flour:</strong> Always 100% (base measurement)<br>
                • <strong>Hydration:</strong> Water ÷ Flour × 100 = Hydration %<br>
                • <strong>Salt:</strong> Typically 1.8-2.2% of flour weight<br>
                • <strong>Yeast:</strong> 0.5-2.5% depending on fermentation time<br>
                • <strong>Pre-ferments:</strong> Portion of flour and water fermented beforehand<br>
                • <strong>Total Dough:</strong> Sum of all ingredients = 100% + hydration + additions
            </div>

            <h3>💧 Hydration Levels & Effects</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Hydration Range</th>
                        <th>Dough Characteristic</th>
                        <th>Bread Type</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>50-60%</td><td>Very stiff, difficult to knead</td><td>Bagels, pretzels</td></tr>
                    <tr><td>60-68%</td><td>Firm, easy to handle</td><td>Sandwich bread, rolls</td></tr>
                    <tr><td>68-75%</td><td>Soft, slightly sticky</td><td>Artisan bread, whole wheat</td></tr>
                    <tr><td>75-80%</td><td>Sticky, requires technique</td><td>Ciabatta, high-hydration</td></tr>
                    <tr><td>80-90%</td><td>Very wet, challenging</td><td>Advanced artisan bread</td></tr>
                </tbody>
            </table>

            <h3>⏰ Fermentation Science</h3>
            <div class="probability-grid">
                <div class="probability-item">
                    <div class="prob-value">1-2 hours</div>
                    <div class="prob-label">Fast Fermentation</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">2-4 hours</div>
                    <div class="prob-label">Standard Bulk Ferment</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">4-8 hours</div>
                    <div class="prob-label">Slow Fermentation</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">8-24 hours</div>
                    <div class="prob-label">Cold Fermentation</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">24+ hours</div>
                    <div class="prob-label">Sourdough Development</div>
                </div>
            </div>

            <h3>🌡️ Temperature Guidelines</h3>
            <ul>
                <li><strong>Water Temperature:</strong> Adjust to achieve desired dough temperature (75-78°F ideal)</li>
                <li><strong>Room Temperature:</strong> 70-75°F for standard fermentation</li>
                <li><strong>Refrigeration:</strong> 38-42°F for slow, cold fermentation</li>
                <li><strong>Baking Temperature:</strong> 400-475°F depending on bread type</li>
                <li><strong>Internal Temperature:</strong> 190-210°F when fully baked</li>
            </ul>

            <h3>🥣 Ingredient Functions</h3>
            <div class="formula-box">
                <strong>Ingredient Roles in Bread Making:</strong><br>
                • <strong>Flour:</strong> Provides structure through gluten formation<br>
                • <strong>Water:</strong> Hydrates flour, enables gluten development<br>
                • <strong>Yeast:</strong> Leavening agent through CO₂ production<br>
                • <strong>Salt:</strong> Flavor enhancement, controls fermentation<br>
                • <strong>Sugar:</strong> Food for yeast, crust coloration<br>
                • <strong>Fat:</strong> Tenderizes crumb, extends freshness<br>
                • <strong>Milk:</strong> Softens crumb, enhances browning
            </div>

            <h3>📏 Measurement Standards</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Measurement</th>
                        <th>Standard Unit</th>
                        <th>Conversion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Flour</td><td>Grams (g)</td><td>1 cup ≈ 120-130g</td></tr>
                    <tr><td>Water</td><td>Grams (g)</td><td>1 ml = 1g</td></tr>
                    <tr><td>Yeast</td><td>Grams (g)</td><td>1 tsp ≈ 3g instant yeast</td></tr>
                    <tr><td>Salt</td><td>Grams (g)</td><td>1 tsp ≈ 5-6g</td></tr>
                    <tr><td>Volume</td><td>Cups (US)</td><td>1 cup = 240ml</td></tr>
                    <tr><td>Temperature</td><td>Fahrenheit/Celsius</td><td>°C = (°F - 32) × 5/9</td></tr>
                </tbody>
            </table>

            <h3>🔬 Bread Science Principles</h3>
            <ul>
                <li><strong>Gluten Development:</strong> Protein network that traps gas and provides structure</li>
                <li><strong>Enzyme Activity:</strong> Breaks down starches into fermentable sugars</li>
                <li><strong>Maillard Reaction:</strong> Browning and flavor development during baking</li>
                <li><strong>Gelatinization:</strong> Starch swelling and setting during baking</li>
                <li><strong>Oven Spring:</strong> Rapid expansion in the first minutes of baking</li>
                <li><strong>Starch Retrogradation:</strong> Starch crystallization causing staling</li>
            </ul>
        </div>

        <div class="footer">
            <p>🍞 Bread Baker Calculator | Professional Baking Assistant</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Create perfect bread with precise calculations, professional techniques, and scientific baking principles</p>
        </div>
    </div>

    <script>
        let recipeHistory = [];
        
        // Update slider value displays
        document.getElementById('hydration').addEventListener('input', function() {
            document.getElementById('hydrationValue').textContent = this.value + '%';
        });
        
        document.getElementById('saltPercentage').addEventListener('input', function() {
            document.getElementById('saltValue').textContent = this.value + '%';
        });
        
        document.getElementById('yeastPercentage').addEventListener('input', function() {
            document.getElementById('yeastValue').textContent = this.value + '%';
        });
        
        document.getElementById('addFlour1Percentage').addEventListener('input', function() {
            document.getElementById('flour1Value').textContent = this.value + '%';
        });

        // Bread type defaults
        const breadDefaults = {
            'white': { hydration: 65, salt: 2.0, yeast: 1.5, fermentation: 2 },
            'wholewheat': { hydration: 70, salt: 2.2, yeast: 1.8, fermentation: 2.5 },
            'sourdough': { hydration: 75, salt: 2.0, yeast: 0, fermentation: 6 },
            'rye': { hydration: 68, salt: 2.2, yeast: 1.5, fermentation: 3 },
            'ciabatta': { hydration: 80, salt: 2.0, yeast: 1.0, fermentation: 2 },
            'brioche': { hydration: 60, salt: 2.0, yeast: 2.5, fermentation: 2 },
            'baguette': { hydration: 68, salt: 2.0, yeast: 1.2, fermentation: 2.5 },
            'custom': { hydration: 65, salt: 2.0, yeast: 1.5, fermentation: 2 }
        };

        function updateRecipeDefaults() {
            const breadType = document.getElementById('breadType').value;
            const defaults = breadDefaults[breadType];
            
            document.getElementById('hydration').value = defaults.hydration;
            document.getElementById('hydrationValue').textContent = defaults.hydration + '%';
            
            document.getElementById('saltPercentage').value = defaults.salt;
            document.getElementById('saltValue').textContent = defaults.salt + '%';
            
            document.getElementById('yeastPercentage').value = defaults.yeast;
            document.getElementById('yeastValue').textContent = defaults.yeast + '%';
            
            document.getElementById('fermentationTime').value = defaults.fermentation;
            
            // Update yeast type for sourdough
            if (breadType === 'sourdough') {
                document.getElementById('yeastType').value = 'sourdough_starter';
            } else {
                document.getElementById('yeastType').value = 'instant';
            }
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

        function calculateRecipe() {
            // Get basic recipe data
            const breadType = document.getElementById('breadType').value;
            const doughWeight = parseFloat(document.getElementById('doughWeight').value) || 1000;
            const hydration = parseFloat(document.getElementById('hydration').value) || 65;
            const saltPercentage = parseFloat(document.getElementById('saltPercentage').value) || 2.0;
            
            // Get advanced parameters
            const yeastType = document.getElementById('yeastType').value;
            const yeastPercentage = parseFloat(document.getElementById('yeastPercentage').value) || 1.5;
            const preferment = document.getElementById('preferment').value;
            const fermentationTime = parseFloat(document.getElementById('fermentationTime').value) || 2;
            
            // Get additional ingredients
            const addFlour1 = document.getElementById('addFlour1').value;
            const addFlour1Percentage = parseFloat(document.getElementById('addFlour1Percentage').value) || 0;
            const addSeeds = document.getElementById('addSeeds').checked;
            const addNuts = document.getElementById('addNuts').checked;
            const addHerbs = document.getElementById('addHerbs').checked;
            const addCheese = document.getElementById('addCheese').checked;
            
            // Calculate ingredient weights using baker's percentages
            const totalFlour = calculateFlourWeight(doughWeight, hydration, saltPercentage, yeastPercentage, addFlour1Percentage);
            const waterWeight = (hydration / 100) * totalFlour;
            const saltWeight = (saltPercentage / 100) * totalFlour;
            const yeastWeight = (yeastPercentage / 100) * totalFlour;
            
            // Calculate additional flour weight
            const mainFlourWeight = totalFlour * (1 - addFlour1Percentage / 100);
            const additionalFlourWeight = totalFlour * (addFlour1Percentage / 100);
            
            // Calculate add-ins weights
            const addInsWeights = calculateAddInsWeights(totalFlour, addSeeds, addNuts, addHerbs, addCheese);
            
            // Calculate final dough weight
            const finalDoughWeight = totalFlour + waterWeight + saltWeight + yeastWeight + 
                                   additionalFlourWeight + addInsWeights.total;
            
            // Generate timeline and tips
            const timeline = generateTimeline(fermentationTime, preferment, breadType);
            const tips = generateBakingTips(breadType, hydration, fermentationTime);
            
            // Update display
            updateResults(finalDoughWeight, totalFlour, waterWeight, saltWeight, yeastWeight, 
                         additionalFlourWeight, addInsWeights, hydration, breadType, timeline, tips);
            
            // Switch to results tab
            switchTab('results');
            
            // Add to history
            addToHistory(breadType, finalDoughWeight, hydration);
        }
        
        function calculateFlourWeight(doughWeight, hydration, saltPercentage, yeastPercentage, addFlour1Percentage) {
            // Total percentage = 100% flour + hydration + salt + yeast
            const totalPercentage = 100 + hydration + saltPercentage + yeastPercentage;
            return doughWeight / (totalPercentage / 100);
        }
        
        function calculateAddInsWeights(totalFlour, seeds, nuts, herbs, cheese) {
            const weights = {
                seeds: 0,
                nuts: 0,
                herbs: 0,
                cheese: 0,
                total: 0
            };
            
            if (seeds) {
                weights.seeds = totalFlour * 0.05; // 5% of flour weight
                weights.total += weights.seeds;
            }
            
            if (nuts) {
                weights.nuts = totalFlour * 0.08; // 8% of flour weight
                weights.total += weights.nuts;
            }
            
            if (herbs) {
                weights.herbs = totalFlour * 0.02; // 2% of flour weight
                weights.total += weights.herbs;
            }
            
            if (cheese) {
                weights.cheese = totalFlour * 0.10; // 10% of flour weight
                weights.total += weights.cheese;
            }
            
            return weights;
        }
        
        function generateTimeline(fermentationTime, preferment, breadType) {
            const steps = [];
            
            // Pre-ferment step if used
            if (preferment !== 'none') {
                steps.push({
                    time: 'Day 1 - Evening',
                    duration: '12-16 hours',
                    description: `Prepare ${preferment} and let ferment at room temperature`
                });
            }
            
            // Mixing and initial fermentation
            steps.push({
                time: 'Baking Day - Start',
                duration: '15-30 minutes',
                description: 'Mix ingredients, knead until smooth and elastic'
            });
            
            // Bulk fermentation
            steps.push({
                time: 'After Mixing',
                duration: `${fermentationTime} hours`,
                description: 'Bulk fermentation - let dough rise until doubled'
            });
            
            // Shaping
            steps.push({
                time: 'After Fermentation',
                duration: '20-30 minutes',
                description: 'Shape dough and place in proofing basket'
            });
            
            // Final proof
            const proofTime = breadType === 'sourdough' ? '4-8 hours' : '1-2 hours';
            steps.push({
                time: 'Before Baking',
                duration: proofTime,
                description: 'Final proof - let shaped dough rise before baking'
            });
            
            // Baking
            steps.push({
                time: 'Baking',
                duration: '30-45 minutes',
                description: 'Bake at 450°F with steam for optimal crust'
            });
            
            // Cooling
            steps.push({
                time: 'After Baking',
                duration: '2+ hours',
                description: 'Cool completely on wire rack before slicing'
            });
            
            return steps;
        }
        
        function generateBakingTips(breadType, hydration, fermentationTime) {
            const tips = [];
            
            // General tips
            tips.push({
                icon: '💡',
                title: 'Use a Scale',
                description: 'Weigh ingredients for consistent results. Volume measurements can vary significantly.'
            });
            
            tips.push({
                icon: '🌡️',
                title: 'Control Temperature',
                description: 'Keep dough temperature around 75-78°F for optimal fermentation.'
            });
            
            // Hydration-specific tips
            if (hydration > 75) {
                tips.push({
                    icon: '💧',
                    title: 'High Hydration Handling',
                    description: 'Use wet hands and bench scraper. High hydration doughs are sticky but develop great oven spring.'
                });
            }
            
            if (hydration < 65) {
                tips.push({
                    icon: '👐',
                    title: 'Low Hydration Kneading',
                    description: 'Knead thoroughly to develop gluten. Lower hydration doughs need more mechanical development.'
                });
            }
            
            // Bread type specific tips
            if (breadType === 'sourdough') {
                tips.push({
                    icon: '🕒',
                    title: 'Sourdough Patience',
                    description: 'Sourdough fermentation is slower. Don\'t rush - flavor develops with time.'
                });
            }
            
            if (breadType === 'wholewheat') {
                tips.push({
                    icon: '🌾',
                    title: 'Whole Wheat Hydration',
                    description: 'Whole grains absorb more water. Consider autolyse to improve hydration.'
                });
            }
            
            // Fermentation tips
            if (fermentationTime > 4) {
                tips.push({
                    icon: '❄️',
                    title: 'Slow Fermentation',
                    description: 'Consider refrigerating dough to slow fermentation and develop more flavor.'
                });
            }
            
            return tips;
        }
        
        function updateResults(finalWeight, totalFlour, waterWeight, saltWeight, yeastWeight, 
                             additionalFlour, addInsWeights, hydration, breadType, timeline, tips) {
            // Update summary
            document.getElementById('finalDoughWeight').textContent = Math.round(finalWeight);
            document.getElementById('doughWeightLabel').textContent = 'grams total dough weight';
            
            document.getElementById('hydrationResult').textContent = hydration + '%';
            document.getElementById('flourWeight').textContent = Math.round(totalFlour) + 'g';
            document.getElementById('waterWeight').textContent = Math.round(waterWeight) + 'g';
            document.getElementById('saltWeight').textContent = Math.round(saltWeight) + 'g';
            
            // Update main ingredients
            const mainIngredients = document.getElementById('mainIngredients');
            mainIngredients.innerHTML = '';
            
            const mainItems = [
                { name: 'Bread Flour', amount: Math.round(totalFlour - additionalFlour), unit: 'g' },
                { name: 'Water', amount: Math.round(waterWeight), unit: 'g' },
                { name: 'Salt', amount: Math.round(saltWeight), unit: 'g' },
                { name: 'Yeast', amount: Math.round(yeastWeight), unit: 'g' }
            ];
            
            mainItems.forEach(item => {
                if (item.amount > 0) {
                    const li = document.createElement('div');
                    li.className = 'ingredient-item';
                    li.innerHTML = `
                        <span class="item-name">${item.name}</span>
                        <span class="item-amount">${item.amount}${item.unit}</span>
                    `;
                    mainIngredients.appendChild(li);
                }
            });
            
            // Update additional ingredients
            const additionalIngredients = document.getElementById('additionalIngredients');
            additionalIngredients.innerHTML = '';
            
            const additionalFlourType = document.getElementById('addFlour1').value;
            if (additionalFlour > 0 && additionalFlourType !== 'none') {
                const li = document.createElement('div');
                li.className = 'ingredient-item';
                li.innerHTML = `
                    <span class="item-name">${additionalFlourType.charAt(0).toUpperCase() + additionalFlourType.slice(1)} Flour</span>
                    <span class="item-amount">${Math.round(additionalFlour)}g</span>
                `;
                additionalIngredients.appendChild(li);
            }
            
            // Add add-ins
            if (addInsWeights.seeds > 0) {
                const li = document.createElement('div');
                li.className = 'ingredient-item';
                li.innerHTML = `
                    <span class="item-name">Mixed Seeds</span>
                    <span class="item-amount">${Math.round(addInsWeights.seeds)}g</span>
                `;
                additionalIngredients.appendChild(li);
            }
            
            if (addInsWeights.nuts > 0) {
                const li = document.createElement('div');
                li.className = 'ingredient-item';
                li.innerHTML = `
                    <span class="item-name">Chopped Nuts</span>
                    <span class="item-amount">${Math.round(addInsWeights.nuts)}g</span>
                `;
                additionalIngredients.appendChild(li);
            }
            
            if (addInsWeights.herbs > 0) {
                const li = document.createElement('div');
                li.className = 'ingredient-item';
                li.innerHTML = `
                    <span class="item-name">Fresh Herbs</span>
                    <span class="item-amount">${Math.round(addInsWeights.herbs)}g</span>
                `;
                additionalIngredients.appendChild(li);
            }
            
            if (addInsWeights.cheese > 0) {
                const li = document.createElement('div');
                li.className = 'ingredient-item';
                li.innerHTML = `
                    <span class="item-name">Grated Cheese</span>
                    <span class="item-amount">${Math.round(addInsWeights.cheese)}g</span>
                `;
                additionalIngredients.appendChild(li);
            }
            
            // Update timeline
            updateTimeline(timeline);
            
            // Update ingredient chart
            updateIngredientChart(totalFlour, waterWeight, saltWeight, yeastWeight, additionalFlour, addInsWeights.total);
            
            // Update baking tips
            updateBakingTips(tips);
        }
        
        function updateTimeline(timeline) {
            const container = document.getElementById('bakingTimeline');
            container.innerHTML = '';
            
            timeline.forEach((step, index) => {
                const stepElement = document.createElement('div');
                stepElement.className = 'timeline-step';
                if (index === 0) stepElement.classList.add('active');
                
                stepElement.innerHTML = `
                    <div class="step-time">${step.time}</div>
                    <div class="step-duration">${step.duration}</div>
                    <div class="step-desc">${step.description}</div>
                `;
                container.appendChild(stepElement);
            });
        }
        
        function updateIngredientChart(totalFlour, waterWeight, saltWeight, yeastWeight, additionalFlour, addInsTotal) {
            const container = document.getElementById('ingredientChart');
            container.innerHTML = '';
            
            const totalWeight = totalFlour + waterWeight + saltWeight + yeastWeight + additionalFlour + addInsTotal;
            
            const ingredients = [
                { name: 'Main Flour', value: totalFlour - additionalFlour, color: '#f6d365' },
                { name: 'Additional Flour', value: additionalFlour, color: '#fdcb6e' },
                { name: 'Water', value: waterWeight, color: '#74b9ff' },
                { name: 'Add-ins', value: addInsTotal, color: '#a29bfe' },
                { name: 'Salt', value: saltWeight, color: '#dfe6e9' },
                { name: 'Yeast', value: yeastWeight, color: '#ffeaa7' }
            ];
            
            ingredients.forEach(ingredient => {
                if (ingredient.value > 0) {
                    const percentage = (ingredient.value / totalWeight) * 100;
                    const bar = document.createElement('div');
                    bar.className = 'chart-bar';
                    bar.innerHTML = `
                        <div class="chart-label">${ingredient.name}</div>
                        <div class="chart-bar-inner">
                            <div class="chart-bar-fill" style="width: ${percentage}%; background: ${ingredient.color}"></div>
                        </div>
                        <div class="chart-percentage">${percentage.toFixed(1)}%</div>
                    `;
                    container.appendChild(bar);
                }
            });
        }
        
        function updateBakingTips(tips) {
            const container = document.getElementById('bakingTips');
            container.innerHTML = '';
            
            tips.forEach(tip => {
                const tipElement = document.createElement('div');
                tipElement.className = 'tip-item';
                tipElement.innerHTML = `
                    <div class="tip-icon">${tip.icon}</div>
                    <div class="tip-content">
                        <div class="tip-title">${tip.title}</div>
                        <div class="tip-desc">${tip.description}</div>
                    </div>
                `;
                container.appendChild(tipElement);
            });
        }
        
        function loadBreadType(type) {
            document.getElementById('breadType').value = type;
            updateRecipeDefaults();
            calculateRecipe();
        }
        
        function addToHistory(breadType, doughWeight, hydration) {
            const timestamp = new Date().toLocaleString();
            recipeHistory.unshift({
                timestamp,
                breadType,
                doughWeight,
                hydration
            });
            
            // Keep only last 10 recipes
            if (recipeHistory.length > 10) {
                recipeHistory = recipeHistory.slice(0, 10);
            }
        }
        
        function resetCalculator() {
            // Reset all inputs to default values
            document.getElementById('breadType').value = 'white';
            document.getElementById('doughWeight').value = '1000';
            document.getElementById('hydration').value = '65';
            document.getElementById('hydrationValue').textContent = '65%';
            document.getElementById('saltPercentage').value = '2.0';
            document.getElementById('saltValue').textContent = '2.0%';
            document.getElementById('yeastType').value = 'instant';
            document.getElementById('yeastPercentage').value = '1.5';
            document.getElementById('yeastValue').textContent = '1.5%';
            document.getElementById('preferment').value = 'none';
            document.getElementById('fermentationTime').value = '2';
            document.getElementById('addFlour1').value = 'none';
            document.getElementById('addFlour1Percentage').value = '0';
            document.getElementById('flour1Value').textContent = '0%';
            document.getElementById('addSeeds').checked = false;
            document.getElementById('addNuts').checked = false;
            document.getElementById('addHerbs').checked = false;
            document.getElementById('addCheese').checked = false;
        }
        
        function saveRecipe() {
            const breadType = document.getElementById('breadType').value;
            const doughWeight = document.getElementById('finalDoughWeight').textContent;
            const hydration = document.getElementById('hydrationResult').textContent;
            
            let recipe = 'Bread Baker Recipe\n';
            recipe += 'Generated: ' + new Date().toLocaleString() + '\n\n';
            recipe += `Bread Type: ${breadType}\n`;
            recipe += `Total Dough Weight: ${doughWeight} grams\n`;
            recipe += `Hydration Level: ${hydration}\n\n`;
            recipe += 'Complete ingredient list and baking instructions provided.';
            
            const blob = new Blob([recipe], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'bread-recipe.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        // Initialize calculator
        window.onload = function() {
            // Set initial state
            updateRecipeDefaults();
        };
    </script>
</body>
</html>
