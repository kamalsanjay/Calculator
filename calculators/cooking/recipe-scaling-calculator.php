<?php
/**
 * Recipe Scaling Calculator
 * File: cooking/recipe-scaling-calculator.php
 * Description: Scale recipes up or down with precise ingredient adjustments and method modifications
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Scaling Calculator - Perfect Proportions Every Time</title>
    <meta name="description" content="Scale recipes up or down with precise ingredient adjustments. Maintain perfect proportions and adjust cooking methods for any serving size.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .scaling-methods { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .method-card { background: #f8f9fa; padding: 20px; border-radius: 10px; cursor: pointer; transition: all 0.3s; border: 2px solid transparent; text-align: center; }
        .method-card:hover { transform: translateY(-2px); }
        .method-card.active { background: #ede7f6; border-color: #667eea; }
        .method-icon { font-size: 2rem; margin-bottom: 10px; }
        .method-name { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .method-desc { font-size: 0.8rem; color: #7f8c8d; }
        
        .controls-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .input-with-unit { display: flex; align-items: center; gap: 10px; }
        .input-with-unit input { flex: 1; }
        .unit-label { min-width: 60px; font-size: 0.9rem; color: #7f8c8d; font-weight: 600; }
        
        .scaling-factor { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; text-align: center; }
        .scaling-factor h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .factor-display { font-size: 3rem; font-weight: bold; color: #667eea; margin-bottom: 10px; }
        .factor-label { font-size: 1rem; color: #7f8c8d; }
        
        .ingredients-section { margin-bottom: 25px; }
        .ingredients-header { display: flex; justify-content: between; align-items: center; margin-bottom: 15px; }
        .ingredients-header h3 { color: #2c3e50; font-size: 1.1rem; }
        .ingredient-actions { display: flex; gap: 10px; }
        
        .ingredients-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .ingredients-table th, .ingredients-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .ingredients-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .ingredients-table tr:hover { background: #f8f9fa; }
        .ingredient-input { width: 100%; padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px; }
        .ingredient-actions-cell { display: flex; gap: 5px; }
        
        .recipe-templates { background: #e8f5e8; padding: 25px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #4caf50; }
        .recipe-templates h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .template-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .template-card { background: white; padding: 20px; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .template-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .template-icon { font-size: 2rem; margin-bottom: 10px; }
        .template-name { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .template-servings { font-size: 0.8rem; color: #7f8c8d; }
        
        .adjustments-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .adjustment-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; text-align: center; }
        .adjustment-card.highlight { background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); border-left-color: #4caf50; }
        .adjustment-value { font-size: 1.5rem; font-weight: bold; color: #5e35b1; margin-bottom: 5px; }
        .adjustment-card.highlight .adjustment-value { color: #2e7d32; }
        .adjustment-label { font-size: 0.85rem; color: #4527a0; font-weight: 600; }
        .adjustment-card.highlight .adjustment-label { color: #1b5e20; }
        .adjustment-note { font-size: 0.75rem; color: #7f8c8d; margin-top: 5px; }
        
        .method-adjustments { background: #fff3e0; padding: 25px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #ff9800; }
        .method-adjustments h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .adjustment-list { list-style: none; }
        .adjustment-item { padding: 10px 0; border-bottom: 1px solid #ffe0b2; }
        .adjustment-item:last-child { border-bottom: none; }
        .adjustment-title { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .adjustment-desc { font-size: 0.85rem; color: #555; }
        
        .nutrition-info { background: #e3f2fd; padding: 25px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #2196f3; }
        .nutrition-info h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .nutrition-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
        .nutrition-item { background: white; padding: 15px; border-radius: 8px; text-align: center; }
        .nutrition-value { font-size: 1.2rem; font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .nutrition-label { font-size: 0.8rem; color: #7f8c8d; }
        
        .action-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .action-btn { padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3); }
        .action-btn.secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .action-btn.secondary:hover { border-color: #667eea; }
        
        .tips-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .tip-card { background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #2196f3; }
        .tip-icon { font-size: 1.5rem; margin-bottom: 10px; }
        .tip-title { font-weight: 600; color: #2c3e50; margin-bottom: 8px; }
        .tip-desc { font-size: 0.85rem; color: #555; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .scaling-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .scaling-table th, .scaling-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .scaling-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .scaling-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .controls-row { grid-template-columns: 1fr; }
            .scaling-methods { grid-template-columns: repeat(2, 1fr); }
            .adjustments-grid { grid-template-columns: repeat(2, 1fr); }
            .template-grid { grid-template-columns: repeat(2, 1fr); }
            .nutrition-grid { grid-template-columns: repeat(3, 1fr); }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { grid-template-columns: 1fr; }
            .ingredients-table { font-size: 0.8rem; }
        }
        
        @media (max-width: 480px) {
            .scaling-methods { grid-template-columns: 1fr; }
            .adjustments-grid { grid-template-columns: 1fr; }
            .template-grid { grid-template-columns: 1fr; }
            .nutrition-grid { grid-template-columns: repeat(2, 1fr); }
            .calculator-card { padding: 20px; }
            .header { padding: 20px; }
            .tips-grid { grid-template-columns: 1fr; }
            .ingredient-actions { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚖️ Recipe Scaling Calculator</h1>
            <p>Scale recipes up or down with precise ingredient adjustments. Maintain perfect proportions and adjust cooking methods for any serving size.</p>
        </div>

        <div class="calculator-card">
            <div class="scaling-methods">
                <div class="method-card active" data-method="servings">
                    <div class="method-icon">👥</div>
                    <div class="method-name">By Servings</div>
                    <div class="method-desc">Scale based on number of servings</div>
                </div>
                <div class="method-card" data-method="percentage">
                    <div class="method-icon">📊</div>
                    <div class="method-name">By Percentage</div>
                    <div class="method-desc">Scale by percentage increase/decrease</div>
                </div>
                <div class="method-card" data-method="pan_size">
                    <div class="method-icon">🍰</div>
                    <div class="method-name">By Pan Size</div>
                    <div class="method-desc">Adjust for different baking pans</div>
                </div>
                <div class="method-card" data-method="batch_size">
                    <div class="method-icon">🏭</div>
                    <div class="method-name">By Batch Size</div>
                    <div class="method-desc">Scale for commercial production</div>
                </div>
            </div>
            
            <div class="controls-row">
                <div class="control-group">
                    <label for="originalServings">Original Servings</label>
                    <input type="number" id="originalServings" value="4" min="1" max="100" step="1">
                </div>
                
                <div class="control-group">
                    <label for="targetServings">Target Servings</label>
                    <input type="number" id="targetServings" value="8" min="1" max="1000" step="1">
                </div>
                
                <div class="control-group">
                    <label for="scalingPrecision">Measurement Precision</label>
                    <select id="scalingPrecision">
                        <option value="exact">Exact (grams/ml)</option>
                        <option value="common" selected>Common Fractions</option>
                        <option value="rounded">Rounded (1/4 cups)</option>
                        <option value="bakers">Baker's Percentages</option>
                    </select>
                </div>
            </div>
            
            <div class="scaling-factor">
                <h3>📈 Scaling Factor</h3>
                <div class="factor-display" id="scalingFactor">2.00x</div>
                <div class="factor-label" id="scalingDescription">Doubling the recipe</div>
            </div>
            
            <div class="ingredients-section">
                <div class="ingredients-header">
                    <h3>🥘 Recipe Ingredients</h3>
                    <div class="ingredient-actions">
                        <button class="action-btn secondary" id="addIngredientBtn">
                            <span>➕</span> Add Ingredient
                        </button>
                        <button class="action-btn secondary" id="clearIngredientsBtn">
                            <span>🗑️</span> Clear All
                        </button>
                    </div>
                </div>
                
                <table class="ingredients-table">
                    <thead>
                        <tr>
                            <th>Ingredient</th>
                            <th>Original Amount</th>
                            <th>Scaled Amount</th>
                            <th>Unit</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ingredientsTable">
                        <tr>
                            <td><input type="text" class="ingredient-input" value="All-purpose flour" placeholder="Ingredient name"></td>
                            <td><input type="number" class="ingredient-input" value="2" step="0.01" placeholder="Amount"></td>
                            <td><span class="scaled-amount">4</span> cups</td>
                            <td>
                                <select class="ingredient-input">
                                    <option value="cups">cups</option>
                                    <option value="tbsp">tablespoons</option>
                                    <option value="tsp">teaspoons</option>
                                    <option value="g">grams</option>
                                    <option value="oz">ounces</option>
                                    <option value="ml">milliliters</option>
                                    <option value="lb">pounds</option>
                                    <option value="each">each</option>
                                </select>
                            </td>
                            <td class="ingredient-actions-cell">
                                <button class="action-btn secondary" onclick="removeIngredient(this)">🗑️</button>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" class="ingredient-input" value="Sugar" placeholder="Ingredient name"></td>
                            <td><input type="number" class="ingredient-input" value="1" step="0.01" placeholder="Amount"></td>
                            <td><span class="scaled-amount">2</span> cups</td>
                            <td>
                                <select class="ingredient-input">
                                    <option value="cups">cups</option>
                                    <option value="tbsp">tablespoons</option>
                                    <option value="tsp">teaspoons</option>
                                    <option value="g">grams</option>
                                    <option value="oz">ounces</option>
                                    <option value="ml">milliliters</option>
                                    <option value="lb">pounds</option>
                                    <option value="each">each</option>
                                </select>
                            </td>
                            <td class="ingredient-actions-cell">
                                <button class="action-btn secondary" onclick="removeIngredient(this)">🗑️</button>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" class="ingredient-input" value="Eggs" placeholder="Ingredient name"></td>
                            <td><input type="number" class="ingredient-input" value="2" step="1" placeholder="Amount"></td>
                            <td><span class="scaled-amount">4</span> each</td>
                            <td>
                                <select class="ingredient-input">
                                    <option value="cups">cups</option>
                                    <option value="tbsp">tablespoons</option>
                                    <option value="tsp">teaspoons</option>
                                    <option value="g">grams</option>
                                    <option value="oz">ounces</option>
                                    <option value="ml">milliliters</option>
                                    <option value="lb">pounds</option>
                                    <option value="each" selected>each</option>
                                </select>
                            </td>
                            <td class="ingredient-actions-cell">
                                <button class="action-btn secondary" onclick="removeIngredient(this)">🗑️</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="recipe-templates">
                <h3>📋 Quick Recipe Templates</h3>
                <div class="template-grid">
                    <div class="template-card" onclick="loadTemplate('chocolate_chip_cookies')">
                        <div class="template-icon">🍪</div>
                        <div class="template-name">Chocolate Chip Cookies</div>
                        <div class="template-servings">24 cookies</div>
                    </div>
                    <div class="template-card" onclick="loadTemplate('banana_bread')">
                        <div class="template-icon">🍞</div>
                        <div class="template-name">Banana Bread</div>
                        <div class="template-servings">1 loaf</div>
                    </div>
                    <div class="template-card" onclick="loadTemplate('pancakes')">
                        <div class="template-icon">🥞</div>
                        <div class="template-name">Pancakes</div>
                        <div class="template-servings">4 servings</div>
                    </div>
                    <div class="template-card" onclick="loadTemplate('pasta_sauce')">
                        <div class="template-icon">🍝</div>
                        <div class="template-name">Marinara Sauce</div>
                        <div class="template-servings">6 servings</div>
                    </div>
                </div>
            </div>
            
            <div class="adjustments-grid">
                <div class="adjustment-card highlight">
                    <div class="adjustment-value" id="totalIngredients">3</div>
                    <div class="adjustment-label">INGREDIENTS</div>
                    <div class="adjustment-note">In recipe</div>
                </div>
                <div class="adjustment-card">
                    <div class="adjustment-value" id="cookingTimeAdjustment">+25%</div>
                    <div class="adjustment-label">COOKING TIME</div>
                    <div class="adjustment-note">Estimated change</div>
                </div>
                <div class="adjustment-card">
                    <div class="adjustment-value" id="ovenTempAdjustment">No change</div>
                    <div class="adjustment-label">OVEN TEMP</div>
                    <div class="adjustment-note">Usually unchanged</div>
                </div>
                <div class="adjustment-card">
                    <div class="adjustment-value" id="panSizeAdjustment">2x larger</div>
                    <div class="adjustment-label">PAN SIZE</div>
                    <div class="adjustment-note">Recommended</div>
                </div>
            </div>
            
            <div class="method-adjustments">
                <h3>👨‍🍳 Method Adjustments</h3>
                <ul class="adjustment-list" id="methodAdjustments">
                    <li class="adjustment-item">
                        <div class="adjustment-title">Mixing Time</div>
                        <div class="adjustment-desc">Increase mixing time by 30-50% for larger batches</div>
                    </li>
                    <li class="adjustment-item">
                        <div class="adjustment-title">Resting Time</div>
                        <div class="adjustment-desc">Keep resting times the same unless doubling yeast dough</div>
                    </li>
                    <li class="adjustment-item">
                        <div class="adjustment-title">Cooking Surface</div>
                        <div class="adjustment-desc">Use multiple pans or larger cooking vessels</div>
                    </li>
                </ul>
            </div>
            
            <div class="nutrition-info">
                <h3>📊 Nutrition Information (Per Serving)</h3>
                <div class="nutrition-grid">
                    <div class="nutrition-item">
                        <div class="nutrition-value" id="caloriesPerServing">-</div>
                        <div class="nutrition-label">CALORIES</div>
                    </div>
                    <div class="nutrition-item">
                        <div class="nutrition-value" id="carbsPerServing">-</div>
                        <div class="nutrition-label">CARBS</div>
                    </div>
                    <div class="nutrition-item">
                        <div class="nutrition-value" id="proteinPerServing">-</div>
                        <div class="nutrition-label">PROTEIN</div>
                    </div>
                    <div class="nutrition-item">
                        <div class="nutrition-value" id="fatPerServing">-</div>
                        <div class="nutrition-label">FAT</div>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="action-btn" id="calculateBtn">
                    <span>🧮</span> Calculate Scaled Recipe
                </button>
                <button class="action-btn secondary" id="resetBtn">
                    <span>🔄</span> Reset Calculator
                </button>
                <button class="action-btn secondary" id="printBtn">
                    <span>🖨️</span> Print Scaled Recipe
                </button>
            </div>
            
            <div class="tips-grid" id="scalingTips">
                <!-- Scaling tips will be generated here -->
            </div>
        </div>

        <div class="info-section">
            <h2>⚖️ Recipe Scaling Science</h2>
            
            <p>Professional recipe scaling involves more than just multiplying ingredients. Understanding the science behind scaling ensures consistent results regardless of batch size.</p>

            <h3>📈 Scaling Methods</h3>
            <table class="scaling-table">
                <thead>
                    <tr>
                        <th>Method</th>
                        <th>Best For</th>
                        <th>Formula</th>
                        <th>Considerations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Direct Proportion</td><td>Most recipes</td><td>New = Original × (Target/Original)</td><td>Works for most ingredients</td></tr>
                    <tr><td>Baker's Percentage</td><td>Baked goods</td><td>Ingredients as % of flour weight</td><td>Maintains dough consistency</td></tr>
                    <tr><td>Geometric Scaling</td><td>Pan sizes, volumes</td><td>Based on area or volume ratios</td><td>Critical for baking times</td></tr>
                    <tr><td>Exponential Scaling</td><td>Spices, seasonings</td><td>New = Original × (Target/Original)^0.8</td><td>Prevents over-seasoning</td></tr>
                </tbody>
            </table>

            <h3>🧮 Scaling Formulas</h3>
            <div class="formula-box">
                <strong>Basic Scaling Formula:</strong><br>
                Scaled Amount = Original Amount × (Target Servings ÷ Original Servings)<br><br>
                
                <strong>Spice & Seasoning Adjustment (Square-Cube Law):</strong><br>
                Scaled Seasoning = Original × (Target/Original)^0.7 to 0.8<br><br>
                
                <strong>Pan Size Scaling (Area-based):</strong><br>
                Scaling Factor = (New Pan Area ÷ Original Pan Area)<br><br>
                
                <strong>Volume Scaling (3D items):</strong><br>
                Scaling Factor = (New Dimension ÷ Original Dimension)³
            </div>

            <h3>🍳 Ingredient-Specific Considerations</h3>
            <table class="scaling-table">
                <thead>
                    <tr>
                        <th>Ingredient Type</th>
                        <th>Scaling Rule</th>
                        <th>Exceptions</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Flour, Sugar, Liquids</td><td>Scale linearly</td><td>None</td><td>Multiply directly by scaling factor</td></tr>
                    <tr><td>Eggs</td><td>Round to nearest whole egg</td><td>Small batches</td><td>For fractions, adjust other liquids</td></tr>
                    <tr><td>Yeast, Baking Powder</td><td>Scale linearly</td><td>Very large batches</td><td>May need slight reduction in very large scales</td></tr>
                    <tr><td>Salt, Spices</td><td>Scale at 70-80%</td><td>All cases</td><td>Prevents over-seasoning</td></tr>
                    <tr><td>Butter, Fats</td><td>Scale linearly</td><td>Pastry, pie crusts</td><td>Maintains texture and flakiness</td></tr>
                    <tr><td>Leavening Agents</td><td>Scale carefully</td><td>All baked goods</td><td>Too much can cause collapse</td></tr>
                </tbody>
            </table>

            <h3>⏰ Time & Temperature Adjustments</h3>
            <ul>
                <li><strong>Baking Time:</strong> Increases by 25-50% when doubling, but not linearly</li>
                <li><strong>Oven Temperature:</strong> Usually remains the same for baking</li>
                <li><strong>Stovetop Cooking:</strong> May require lower heat for larger volumes</li>
                <li><strong>Resting/Proofing:</strong> Times generally remain consistent</li>
                <li><strong>Marinating:</strong> Time increases with thickness, not volume</li>
            </ul>

            <h3>🥘 Equipment Considerations</h3>
            <div class="formula-box">
                <strong>Pan Size Calculations:</strong><br>
                • Round pans: Area = π × radius²<br>
                • Square/Rectangular pans: Area = length × width<br>
                • Bundt pans: Use volume measurements<br><br>
                
                <strong>Common Pan Conversions:</strong><br>
                • 8" round → 9" round: Multiply by 1.27<br>
                • 9×13" → 10×15": Multiply by 1.28<br>
                • Loaf pan → Muffins: Divide by 0.75 per muffin
            </div>

            <h3>📊 Baker's Percentage System</h3>
            <table class="scaling-table">
                <thead>
                    <tr>
                        <th>Ingredient</th>
                        <th>Standard Percentage</th>
                        <th>Purpose</th>
                        <th>Scaling Method</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Flour</td><td>100%</td><td>Base ingredient</td><td>Anchor for all calculations</td></tr>
                    <tr><td>Water</td><td>60-75%</td><td>Hydration</td><td>Maintain percentage</td></tr>
                    <tr><td>Salt</td><td>1.8-2.2%</td><td>Flavor, gluten control</td><td>Maintain percentage</td></tr>
                    <tr><td>Yeast</td><td>0.5-2%</td><td>Leavening</td><td>Adjust for fermentation time</td></tr>
                    <tr><td>Sugar</td><td>0-15%</td><td>Sweetness, browning</td><td>Maintain percentage</td></tr>
                    <tr><td>Fat</td><td>3-10%</td><td>Tenderness, flavor</td><td>Maintain percentage</td></tr>
                </tbody>
            </table>

            <h3>⚡ Quick Scaling Rules</h3>
            <ul>
                <li><strong>Doubling (2x):</strong> Most ingredients double, spices ×1.8, baking time +25%</li>
                <li><strong>Tripling (3x):</strong> Ingredients ×3, spices ×2.4, use multiple pans</li>
                <li><strong>Halving (0.5x):</strong> All ingredients ×0.5, baking time -15%</li>
                <li><strong>Quartering (0.25x):</strong> Ingredients ×0.25, use smaller pans, watch baking time</li>
            </ul>

            <h3>🎯 Professional Tips</h3>
            <div class="formula-box">
                <strong>Scaling Best Practices:</strong><br>
                • Always scale by weight, not volume, for accuracy<br>
                • Write down the original recipe before scaling<br>
                • Test scaled recipes before important events<br>
                • Consider equipment limitations when scaling up<br>
                • Adjust seasonings at the end, to taste<br>
                • Keep detailed notes of successful scaling factors
            </div>

            <h3>⚠️ Common Scaling Mistakes</h3>
            <table class="scaling-table">
                <thead>
                    <tr>
                        <th>Mistake</th>
                        <th>Result</th>
                        <th>Solution</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Over-scaling spices</td><td>Overpowering flavor</td><td>Use 70-80% scaling for seasonings</td></tr>
                    <tr><td>Wrong pan size</td><td>Over/under cooking</td><td>Calculate area/volume ratios</td></tr>
                    <tr><td>Ignoring mixing time</td><td>Poor incorporation</td><td>Increase mixing time gradually</td></tr>
                    <tr><td>Linear time scaling</td><td>Burnt or raw food</td><td>Use experience-based adjustments</td></tr>
                    <tr><td>Equipment limitations</td><td>Inconsistent results</td><td>Scale in manageable batches</td></tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>⚖️ Professional Recipe Scaling Calculator | Perfect Proportions Every Time</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Scale recipes up or down with precise ingredient adjustments and method modifications</p>
        </div>
    </div>

    <script>
        // DOM elements
        const methodCards = document.querySelectorAll('.method-card');
        const originalServings = document.getElementById('originalServings');
        const targetServings = document.getElementById('targetServings');
        const scalingPrecision = document.getElementById('scalingPrecision');
        const calculateBtn = document.getElementById('calculateBtn');
        const resetBtn = document.getElementById('resetBtn');
        const printBtn = document.getElementById('printBtn');
        const addIngredientBtn = document.getElementById('addIngredientBtn');
        const clearIngredientsBtn = document.getElementById('clearIngredientsBtn');
        const ingredientsTable = document.getElementById('ingredientsTable');
        const scalingFactor = document.getElementById('scalingFactor');
        const scalingDescription = document.getElementById('scalingDescription');
        const totalIngredients = document.getElementById('totalIngredients');
        const cookingTimeAdjustment = document.getElementById('cookingTimeAdjustment');
        const ovenTempAdjustment = document.getElementById('ovenTempAdjustment');
        const panSizeAdjustment = document.getElementById('panSizeAdjustment');
        const caloriesPerServing = document.getElementById('caloriesPerServing');
        const carbsPerServing = document.getElementById('carbsPerServing');
        const proteinPerServing = document.getElementById('proteinPerServing');
        const fatPerServing = document.getElementById('fatPerServing');
        const methodAdjustments = document.getElementById('methodAdjustments');
        const scalingTips = document.getElementById('scalingTips');

        // Recipe templates
        const recipeTemplates = {
            chocolate_chip_cookies: {
                name: "Chocolate Chip Cookies",
                servings: 24,
                ingredients: [
                    { name: "All-purpose flour", amount: 2.25, unit: "cups" },
                    { name: "Baking soda", amount: 1, unit: "tsp" },
                    { name: "Salt", amount: 1, unit: "tsp" },
                    { name: "Butter", amount: 1, unit: "cups" },
                    { name: "Brown sugar", amount: 0.75, unit: "cups" },
                    { name: "White sugar", amount: 0.75, unit: "cups" },
                    { name: "Vanilla extract", amount: 2, unit: "tsp" },
                    { name: "Eggs", amount: 2, unit: "each" },
                    { name: "Chocolate chips", amount: 2, unit: "cups" }
                ]
            },
            banana_bread: {
                name: "Banana Bread",
                servings: 1,
                ingredients: [
                    { name: "Ripe bananas", amount: 3, unit: "each" },
                    { name: "All-purpose flour", amount: 2, unit: "cups" },
                    { name: "Baking soda", amount: 1, unit: "tsp" },
                    { name: "Salt", amount: 0.5, unit: "tsp" },
                    { name: "Butter", amount: 0.5, unit: "cups" },
                    { name: "Brown sugar", amount: 0.75, unit: "cups" },
                    { name: "Eggs", amount: 2, unit: "each" },
                    { name: "Vanilla extract", amount: 1, unit: "tsp" }
                ]
            },
            pancakes: {
                name: "Pancakes",
                servings: 4,
                ingredients: [
                    { name: "All-purpose flour", amount: 1.5, unit: "cups" },
                    { name: "Baking powder", amount: 3.5, unit: "tsp" },
                    { name: "Salt", amount: 1, unit: "tsp" },
                    { name: "White sugar", amount: 1, unit: "tbsp" },
                    { name: "Milk", amount: 1.25, unit: "cups" },
                    { name: "Egg", amount: 1, unit: "each" },
                    { name: "Butter", amount: 3, unit: "tbsp" }
                ]
            },
            pasta_sauce: {
                name: "Marinara Sauce",
                servings: 6,
                ingredients: [
                    { name: "Olive oil", amount: 2, unit: "tbsp" },
                    { name: "Onion", amount: 1, unit: "each" },
                    { name: "Garlic", amount: 4, unit: "cloves" },
                    { name: "Crushed tomatoes", amount: 28, unit: "oz" },
                    { name: "Tomato paste", amount: 2, unit: "tbsp" },
                    { name: "Dried basil", amount: 1, unit: "tsp" },
                    { name: "Dried oregano", amount: 1, unit: "tsp" },
                    { name: "Salt", amount: 1, unit: "tsp" },
                    { name: "Black pepper", amount: 0.5, unit: "tsp" },
                    { name: "Sugar", amount: 1, unit: "tsp" }
                ]
            }
        };

        // Current state
        let currentMethod = 'servings';

        // Initialize
        setupEventListeners();
        calculateScaling();

        function setupEventListeners() {
            // Method cards
            methodCards.forEach(card => {
                card.addEventListener('click', function() {
                    methodCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    currentMethod = this.dataset.method;
                    updateScalingMethod();
                });
            });

            // Calculate button
            calculateBtn.addEventListener('click', calculateScaling);
            
            // Reset button
            resetBtn.addEventListener('click', resetCalculator);
            
            // Print button
            printBtn.addEventListener('click', printRecipe);
            
            // Add ingredient button
            addIngredientBtn.addEventListener('click', addIngredient);
            
            // Clear ingredients button
            clearIngredientsBtn.addEventListener('click', clearIngredients);
            
            // Input listeners
            originalServings.addEventListener('input', calculateScaling);
            targetServings.addEventListener('input', calculateScaling);
            scalingPrecision.addEventListener('change', calculateScaling);
            
            // Ingredient input listeners (delegated)
            ingredientsTable.addEventListener('input', function(e) {
                if (e.target.classList.contains('ingredient-input')) {
                    calculateScaling();
                }
            });
        }

        function updateScalingMethod() {
            // Update UI based on selected scaling method
            switch(currentMethod) {
                case 'servings':
                    originalServings.parentElement.style.display = 'block';
                    targetServings.parentElement.style.display = 'block';
                    break;
                case 'percentage':
                    // Would show percentage inputs
                    break;
                case 'pan_size':
                    // Would show pan dimension inputs
                    break;
                case 'batch_size':
                    // Would show batch size inputs
                    break;
            }
            calculateScaling();
        }

        function calculateScaling() {
            const original = parseFloat(originalServings.value);
            const target = parseFloat(targetServings.value);
            
            if (isNaN(original) || isNaN(target) || original <= 0 || target <= 0) {
                return;
            }
            
            const factor = target / original;
            
            // Update scaling factor display
            scalingFactor.textContent = factor.toFixed(2) + 'x';
            scalingDescription.textContent = getScalingDescription(factor);
            
            // Update ingredient amounts
            updateIngredientAmounts(factor);
            
            // Update adjustments
            updateAdjustments(factor);
            
            // Update nutrition
            updateNutritionInfo(factor);
            
            // Update method adjustments
            updateMethodAdjustments(factor);
            
            // Generate tips
            generateScalingTips(factor);
        }

        function getScalingDescription(factor) {
            if (factor >= 4) return 'Quadrupling the recipe';
            if (factor >= 3) return 'Tripling the recipe';
            if (factor >= 2) return 'Doubling the recipe';
            if (factor >= 1.5) return 'Increasing by 50%';
            if (factor >= 1.1) return 'Slight increase';
            if (factor === 1) return 'No change';
            if (factor >= 0.9) return 'Slight decrease';
            if (factor >= 0.5) return 'Halving the recipe';
            return 'Significant reduction';
        }

        function updateIngredientAmounts(factor) {
            const rows = ingredientsTable.querySelectorAll('tr');
            totalIngredients.textContent = rows.length;
            
            rows.forEach(row => {
                const amountInput = row.querySelector('input[type="number"]');
                const scaledAmountSpan = row.querySelector('.scaled-amount');
                const unitSelect = row.querySelector('select');
                
                if (amountInput && scaledAmountSpan && unitSelect) {
                    const originalAmount = parseFloat(amountInput.value);
                    const unit = unitSelect.value;
                    
                    if (!isNaN(originalAmount)) {
                        let scaledAmount = originalAmount * factor;
                        
                        // Apply precision rules
                        scaledAmount = applyPrecision(scaledAmount, unit, scalingPrecision.value);
                        
                        scaledAmountSpan.textContent = formatAmount(scaledAmount, unit, scalingPrecision.value);
                    }
                }
            });
        }

        function applyPrecision(amount, unit, precision) {
            switch(precision) {
                case 'exact':
                    return Math.round(amount * 100) / 100;
                case 'common':
                    return roundToCommonFraction(amount);
                case 'rounded':
                    return Math.round(amount * 4) / 4; // Nearest 1/4
                case 'bakers':
                    return Math.round(amount * 100) / 100; // Keep decimals for percentages
                default:
                    return amount;
            }
        }

        function roundToCommonFraction(amount) {
            const fractions = {
                0.125: '1/8',
                0.25: '1/4',
                0.333: '1/3',
                0.375: '3/8',
                0.5: '1/2',
                0.625: '5/8',
                0.666: '2/3',
                0.75: '3/4',
                0.875: '7/8'
            };
            
            const whole = Math.floor(amount);
            const decimal = amount - whole;
            
            // Find closest fraction
            let closestFraction = '';
            let minDifference = Infinity;
            
            for (const [dec, frac] of Object.entries(fractions)) {
                const difference = Math.abs(decimal - parseFloat(dec));
                if (difference < minDifference) {
                    minDifference = difference;
                    closestFraction = frac;
                }
            }
            
            if (minDifference < 0.1) { // Only use fraction if close enough
                return whole > 0 ? `${whole} ${closestFraction}` : closestFraction;
            }
            
            return Math.round(amount * 2) / 2; // Fallback to halves
        }

        function formatAmount(amount, unit, precision) {
            if (precision === 'common' && typeof amount === 'string') {
                return amount;
            }
            
            if (unit === 'each') {
                return Math.round(amount); // Whole numbers for countable items
            }
            
            if (precision === 'common') {
                const whole = Math.floor(amount);
                const fraction = amount - whole;
                
                if (fraction === 0) return whole.toString();
                if (fraction === 0.5) return whole > 0 ? `${whole} 1/2` : '1/2';
                if (fraction === 0.25) return whole > 0 ? `${whole} 1/4` : '1/4';
                if (fraction === 0.75) return whole > 0 ? `${whole} 3/4` : '3/4';
                if (fraction === 0.33) return whole > 0 ? `${whole} 1/3` : '1/3';
                if (fraction === 0.67) return whole > 0 ? `${whole} 2/3` : '2/3';
            }
            
            return amount % 1 === 0 ? amount.toString() : amount.toFixed(2);
        }

        function updateAdjustments(factor) {
            // Cooking time adjustment (non-linear)
            let timeAdjustment = 'No change';
            if (factor >= 4) timeAdjustment = '+50-75%';
            else if (factor >= 2) timeAdjustment = '+25-50%';
            else if (factor >= 1.5) timeAdjustment = '+15-25%';
            else if (factor <= 0.5) timeAdjustment = '-20-30%';
            else if (factor <= 0.75) timeAdjustment = '-10-20%';
            
            cookingTimeAdjustment.textContent = timeAdjustment;
            
            // Oven temperature (usually unchanged)
            ovenTempAdjustment.textContent = 'No change';
            
            // Pan size recommendation
            let panSize = 'Same size';
            if (factor >= 3) panSize = '3x larger or multiple pans';
            else if (factor >= 2) panSize = '2x larger';
            else if (factor <= 0.5) panSize = 'Half size';
            
            panSizeAdjustment.textContent = panSize;
        }

        function updateNutritionInfo(factor) {
            // These would normally be calculated based on ingredient database
            // For demo purposes, using placeholder values
            caloriesPerServing.textContent = '250';
            carbsPerServing.textContent = '35g';
            proteinPerServing.textContent = '8g';
            fatPerServing.textContent = '10g';
        }

        function updateMethodAdjustments(factor) {
            let adjustments = [];
            
            if (factor >= 2) {
                adjustments.push(
                    'Increase mixing time by 30-50% for proper ingredient incorporation',
                    'Consider using multiple pans or baking in batches',
                    'Check for doneness 5-10 minutes before expected time'
                );
            } else if (factor <= 0.5) {
                adjustments.push(
                    'Reduce mixing time slightly to avoid over-working',
                    'Use smaller pans for proper heat distribution',
                    'Watch carefully as cooking time decreases'
                );
            } else {
                adjustments.push(
                    'Mixing times generally remain the same',
                    'Cooking vessels should be appropriately sized',
                    'Monitor closely and adjust as needed'
                );
            }
            
            methodAdjustments.innerHTML = adjustments.map(adj => `
                <li class="adjustment-item">
                    <div class="adjustment-desc">${adj}</div>
                </li>
            `).join('');
        }

        function generateScalingTips(factor) {
            const tips = [
                {
                    icon: '⚖️',
                    title: 'Weigh Ingredients',
                    desc: 'Use a kitchen scale for accuracy, especially when scaling baked goods.'
                },
                {
                    icon: '👃',
                    title: 'Season to Taste',
                    desc: 'Add spices gradually at the end and adjust based on your preference.'
                },
                {
                    icon: '⏰',
                    title: 'Monitor Closely',
                    desc: 'Cooking times don\'t scale linearly. Check for doneness early and often.'
                }
            ];
            
            if (factor >= 3) {
                tips.push({
                    icon: '🍳',
                    title: 'Batch Cooking',
                    desc: 'Consider cooking in multiple batches for consistent results with large scales.'
                });
            }
            
            scalingTips.innerHTML = tips.map(tip => `
                <div class="tip-card">
                    <div class="tip-icon">${tip.icon}</div>
                    <div class="tip-title">${tip.title}</div>
                    <div class="tip-desc">${tip.desc}</div>
                </div>
            `).join('');
        }

        function addIngredient() {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" class="ingredient-input" placeholder="Ingredient name"></td>
                <td><input type="number" class="ingredient-input" value="1" step="0.01" placeholder="Amount"></td>
                <td><span class="scaled-amount">1</span> <span class="unit-display">cups</span></td>
                <td>
                    <select class="ingredient-input">
                        <option value="cups">cups</option>
                        <option value="tbsp">tablespoons</option>
                        <option value="tsp">teaspoons</option>
                        <option value="g">grams</option>
                        <option value="oz">ounces</option>
                        <option value="ml">milliliters</option>
                        <option value="lb">pounds</option>
                        <option value="each">each</option>
                    </select>
                </td>
                <td class="ingredient-actions-cell">
                    <button class="action-btn secondary" onclick="removeIngredient(this)">🗑️</button>
                </td>
            `;
            ingredientsTable.appendChild(newRow);
            calculateScaling();
        }

        function removeIngredient(button) {
            const row = button.closest('tr');
            row.remove();
            calculateScaling();
        }

        function clearIngredients() {
            if (confirm('Are you sure you want to clear all ingredients?')) {
                ingredientsTable.innerHTML = '';
                calculateScaling();
            }
        }

        function loadTemplate(templateName) {
            const template = recipeTemplates[templateName];
            if (!template) return;
            
            // Clear existing ingredients
            ingredientsTable.innerHTML = '';
            
            // Set servings
            originalServings.value = template.servings;
            targetServings.value = template.servings;
            
            // Add template ingredients
            template.ingredients.forEach(ingredient => {
                const row = document.createElement('tr');
                const unitOptions = ['cups', 'tbsp', 'tsp', 'g', 'oz', 'ml', 'lb', 'each']
                    .map(unit => `<option value="${unit}" ${unit === ingredient.unit ? 'selected' : ''}>${unit}</option>`)
                    .join('');
                
                row.innerHTML = `
                    <td><input type="text" class="ingredient-input" value="${ingredient.name}"></td>
                    <td><input type="number" class="ingredient-input" value="${ingredient.amount}" step="0.01"></td>
                    <td><span class="scaled-amount">${ingredient.amount}</span> <span class="unit-display">${ingredient.unit}</span></td>
                    <td>
                        <select class="ingredient-input">${unitOptions}</select>
                    </td>
                    <td class="ingredient-actions-cell">
                        <button class="action-btn secondary" onclick="removeIngredient(this)">🗑️</button>
                    </td>
                `;
                ingredientsTable.appendChild(row);
            });
            
            calculateScaling();
            alert(`Loaded ${template.name} template!`);
        }

        function resetCalculator() {
            originalServings.value = 4;
            targetServings.value = 8;
            scalingPrecision.value = 'common';
            
            // Reset to first method
            methodCards[0].click();
            
            // Clear and add default ingredients
            clearIngredients();
            setTimeout(() => {
                // Add back default ingredients
                const defaultIngredients = [
                    { name: 'All-purpose flour', amount: 2, unit: 'cups' },
                    { name: 'Sugar', amount: 1, unit: 'cups' },
                    { name: 'Eggs', amount: 2, unit: 'each' }
                ];
                
                defaultIngredients.forEach(ingredient => {
                    const row = document.createElement('tr');
                    const unitOptions = ['cups', 'tbsp', 'tsp', 'g', 'oz', 'ml', 'lb', 'each']
                        .map(unit => `<option value="${unit}" ${unit === ingredient.unit ? 'selected' : ''}>${unit}</option>`)
                        .join('');
                    
                    row.innerHTML = `
                        <td><input type="text" class="ingredient-input" value="${ingredient.name}"></td>
                        <td><input type="number" class="ingredient-input" value="${ingredient.amount}" step="${ingredient.unit === 'each' ? '1' : '0.01'}"></td>
                        <td><span class="scaled-amount">${ingredient.amount}</span> <span class="unit-display">${ingredient.unit}</span></td>
                        <td>
                            <select class="ingredient-input">${unitOptions}</select>
                        </td>
                        <td class="ingredient-actions-cell">
                            <button class="action-btn secondary" onclick="removeIngredient(this)">🗑️</button>
                        </td>
                    `;
                    ingredientsTable.appendChild(row);
                });
                
                calculateScaling();
            }, 100);
        }

        function printRecipe() {
            const factor = parseFloat(targetServings.value) / parseFloat(originalServings.value);
            let printContent = `
                <h1>Scaled Recipe</h1>
                <p><strong>Original Servings:</strong> ${originalServings.value}</p>
                <p><strong>Target Servings:</strong> ${targetServings.value}</p>
                <p><strong>Scaling Factor:</strong> ${factor.toFixed(2)}x</p>
                <h2>Ingredients</h2>
                <table border="1" style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th>Ingredient</th>
                        <th>Amount</th>
                        <th>Unit</th>
                    </tr>
            `;
            
            const rows = ingredientsTable.querySelectorAll('tr');
            rows.forEach(row => {
                const nameInput = row.querySelector('input[type="text"]');
                const scaledAmountSpan = row.querySelector('.scaled-amount');
                const unitSelect = row.querySelector('select');
                
                if (nameInput && scaledAmountSpan && unitSelect) {
                    const name = nameInput.value || 'Unnamed Ingredient';
                    const amount = scaledAmountSpan.textContent;
                    const unit = unitSelect.options[unitSelect.selectedIndex].text;
                    
                    printContent += `
                        <tr>
                            <td>${name}</td>
                            <td>${amount}</td>
                            <td>${unit}</td>
                        </tr>
                    `;
                }
            });
            
            printContent += `
                </table>
                <h2>Method Adjustments</h2>
                <ul>
                    <li>Cooking Time: ${cookingTimeAdjustment.textContent}</li>
                    <li>Oven Temperature: ${ovenTempAdjustment.textContent}</li>
                    <li>Pan Size: ${panSizeAdjustment.textContent}</li>
                </ul>
            `;
            
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Scaled Recipe</title>
                        <style>
                            body { font-family: Arial, sans-serif; padding: 20px; }
                            table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                            th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
                            th { background-color: #f2f2f2; }
                        </style>
                    </head>
                    <body>
                        ${printContent}
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }

        // Initialize calculation
        calculateScaling();
    </script>
</body>
</html>
