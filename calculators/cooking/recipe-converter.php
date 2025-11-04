<?php
/**
 * Recipe Converter
 * File: cooking/recipe-converter.php
 * Description: Convert recipe measurements between different units and scale recipe quantities
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Converter - Measurement Conversion & Scaling Tool</title>
    <meta name="description" content="Convert recipe measurements between metric and imperial units, scale recipe quantities, and adjust serving sizes.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: clamp(20px, 5vw, 30px); border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: clamp(1.5rem, 4vw, 2rem); margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: clamp(0.9rem, 2.5vw, 1.05rem); line-height: 1.6; }
        
        .converter-card { background: white; padding: clamp(20px, 5vw, 35px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-tabs { display: flex; gap: 10px; margin-bottom: 25px; border-bottom: 2px solid #f8f9fa; }
        .tab-btn { background: none; border: none; padding: 12px 20px; font-size: 1rem; cursor: pointer; transition: all 0.3s; border-bottom: 3px solid transparent; }
        .tab-btn.active { color: #667eea; border-bottom-color: #667eea; font-weight: 600; }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .input-sections { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: clamp(15px, 4vw, 25px); margin-bottom: 25px; }
        
        .input-group { background: #f8f9fa; padding: clamp(15px, 4vw, 25px); border-radius: 12px; }
        .input-group h3 { color: #2c3e50; margin-bottom: 15px; font-size: clamp(1rem, 3vw, 1.2rem); display: flex; align-items: center; gap: 8px; }
        
        .input-row { display: flex; gap: 15px; align-items: end; margin-bottom: 15px; }
        .input-wrapper { flex: 1; }
        .input-wrapper label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.9rem; }
        .input-field { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-field:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; }
        .unit-select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .ingredients-list { margin-top: 20px; }
        .ingredient-row { display: flex; gap: 10px; margin-bottom: 10px; align-items: center; }
        .ingredient-input { flex: 1; padding: 10px; border: 1px solid #e0e0e0; border-radius: 6px; }
        .remove-ingredient { background: #e74c3c; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer; }
        
        .add-ingredient-btn { background: #27ae60; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer; margin-top: 10px; }
        
        .calculate-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 16px 30px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin: 20px 0; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        
        .results-section { margin-top: 30px; }
        
        .conversion-results { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .results-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .results-header h3 { color: #2c3e50; font-size: 1.1rem; }
        
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .result-card { background: white; padding: 20px; border-radius: 10px; text-align: center; border-left: 4px solid #667eea; }
        .result-label { color: #4527a0; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-value { font-size: 1.4rem; font-weight: bold; color: #5e35b1; }
        .result-unit { color: #7e57c2; font-size: 0.9rem; margin-top: 5px; }
        
        .converted-ingredients { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .ingredients-table { width: 100%; border-collapse: collapse; }
        .ingredients-table th, .ingredients-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .ingredients-table th { background: #667eea; color: white; font-weight: 600; }
        .ingredients-table tr:hover { background: rgba(102, 126, 234, 0.05); }
        
        .quick-conversions { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .conversion-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
        .conversion-card { background: white; padding: 20px; border-radius: 10px; text-align: center; cursor: pointer; transition: all 0.3s; border: 2px solid #e0e0e0; }
        .conversion-card:hover { border-color: #667eea; transform: translateY(-2px); }
        .conversion-value { font-weight: bold; color: #667eea; font-size: 1rem; }
        .conversion-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .common-ingredients { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .ingredients-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .ingredient-card { background: white; padding: 15px; border-radius: 8px; text-align: center; cursor: pointer; transition: all 0.3s; border: 1px solid #e0e0e0; }
        .ingredient-card:hover { border-color: #667eea; }
        .ingredient-name { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .ingredient-conversion { color: #667eea; font-size: 0.9rem; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: clamp(1.2rem, 4vw, 1.4rem); }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: clamp(1rem, 3vw, 1.1rem); }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        
        .conversion-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin: 20px 0; }
        .conversion-card-info { background: #ede7f6; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; }
        .conversion-card-info h4 { color: #4527a0; margin-bottom: 10px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: clamp(0.8rem, 2vw, 0.9rem); }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-row { flex-direction: column; }
            .results-grid { grid-template-columns: repeat(2, 1fr); }
            .conversion-grid { grid-template-columns: repeat(2, 1fr); }
            .ingredients-grid { grid-template-columns: repeat(2, 1fr); }
            .ingredient-row { flex-direction: column; }
            .converter-tabs { flex-wrap: wrap; }
        }
        
        @media (max-width: 480px) {
            .results-grid { grid-template-columns: 1fr; }
            .conversion-grid { grid-template-columns: 1fr; }
            .ingredients-grid { grid-template-columns: 1fr; }
            .input-sections { grid-template-columns: 1fr; }
            .converter-card { padding: 15px; }
            .header { padding: 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🥄 Recipe Converter</h1>
            <p>Convert recipe measurements between metric and imperial units, scale quantities, and adjust serving sizes</p>
        </div>

        <div class="converter-card">
            <div class="converter-tabs">
                <button class="tab-btn active" data-tab="unit-conversion">Unit Conversion</button>
                <button class="tab-btn" data-tab="recipe-scaling">Recipe Scaling</button>
                <button class="tab-btn" data-tab="ingredient-converter">Ingredient Converter</button>
            </div>

            <!-- Unit Conversion Tab -->
            <div class="tab-content active" id="unit-conversion">
                <div class="input-sections">
                    <div class="input-group">
                        <h3>📏 Measurement Input</h3>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="amount">Amount</label>
                                <input type="number" id="amount" class="input-field" placeholder="Enter amount" value="1" step="0.01" min="0">
                            </div>
                            <div class="input-wrapper">
                                <label for="fromUnit">From Unit</label>
                                <select id="fromUnit" class="unit-select">
                                    <option value="cups">Cups</option>
                                    <option value="tbsp">Tablespoons</option>
                                    <option value="tsp">Teaspoons</option>
                                    <option value="floz">Fluid Ounces</option>
                                    <option value="pints">Pints</option>
                                    <option value="quarts">Quarts</option>
                                    <option value="gallons">Gallons</option>
                                    <option value="ml">Milliliters</option>
                                    <option value="liters">Liters</option>
                                    <option value="grams">Grams</option>
                                    <option value="kg">Kilograms</option>
                                    <option value="oz">Ounces</option>
                                    <option value="lbs">Pounds</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="toUnit">To Unit</label>
                                <select id="toUnit" class="unit-select">
                                    <option value="ml">Milliliters</option>
                                    <option value="cups">Cups</option>
                                    <option value="tbsp">Tablespoons</option>
                                    <option value="tsp">Teaspoons</option>
                                    <option value="floz">Fluid Ounces</option>
                                    <option value="grams">Grams</option>
                                    <option value="oz">Ounces</option>
                                    <option value="liters">Liters</option>
                                    <option value="pints">Pints</option>
                                    <option value="quarts">Quarts</option>
                                    <option value="gallons">Gallons</option>
                                    <option value="kg">Kilograms</option>
                                    <option value="lbs">Pounds</option>
                                </select>
                            </div>
                            <div class="input-wrapper">
                                <label for="ingredientType">Ingredient Type</label>
                                <select id="ingredientType" class="unit-select">
                                    <option value="general">General (Water)</option>
                                    <option value="flour">Flour</option>
                                    <option value="sugar">Sugar</option>
                                    <option value="butter">Butter</option>
                                    <option value="milk">Milk</option>
                                    <option value="honey">Honey</option>
                                    <option value="oil">Oil</option>
                                    <option value="salt">Salt</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <h3>⚡ Quick Conversions</h3>
                        <div class="conversion-grid">
                            <div class="conversion-card" onclick="setQuickConversion(1, 'cups', 'ml')">
                                <div class="conversion-value">1 cup → ml</div>
                                <div class="conversion-label">Liquid Volume</div>
                            </div>
                            <div class="conversion-card" onclick="setQuickConversion(1, 'tbsp', 'ml')">
                                <div class="conversion-value">1 tbsp → ml</div>
                                <div class="conversion-label">Tablespoon</div>
                            </div>
                            <div class="conversion-card" onclick="setQuickConversion(1, 'tsp', 'ml')">
                                <div class="conversion-value">1 tsp → ml</div>
                                <div class="conversion-label">Teaspoon</div>
                            </div>
                            <div class="conversion-card" onclick="setQuickConversion(1, 'oz', 'grams')">
                                <div class="conversion-value">1 oz → grams</div>
                                <div class="conversion-label">Weight</div>
                            </div>
                            <div class="conversion-card" onclick="setQuickConversion(1, 'lbs', 'grams')">
                                <div class="conversion-value">1 lb → grams</div>
                                <div class="conversion-label">Pound</div>
                            </div>
                            <div class="conversion-card" onclick="setQuickConversion(250, 'grams', 'cups', 'flour')">
                                <div class="conversion-value">250g flour → cups</div>
                                <div class="conversion-label">Baking</div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="calculate-btn" onclick="convertUnit()">Convert Measurement</button>

                <div class="results-section">
                    <div class="conversion-results">
                        <div class="results-header">
                            <h3>📊 Conversion Result</h3>
                        </div>
                        <div class="results-grid">
                            <div class="result-card">
                                <div class="result-label">Original Amount</div>
                                <div class="result-value" id="originalAmount">1</div>
                                <div class="result-unit" id="originalUnit">cup</div>
                            </div>
                            <div class="result-card">
                                <div class="result-label">Converted Amount</div>
                                <div class="result-value" id="convertedAmount">236.59</div>
                                <div class="result-unit" id="convertedUnit">ml</div>
                            </div>
                            <div class="result-card">
                                <div class="result-label">Conversion Factor</div>
                                <div class="result-value" id="conversionFactor">236.59</div>
                                <div class="result-unit">per unit</div>
                            </div>
                            <div class="result-card">
                                <div class="result-label">Accuracy</div>
                                <div class="result-value" id="accuracyLevel">High</div>
                                <div class="result-unit">For baking</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recipe Scaling Tab -->
            <div class="tab-content" id="recipe-scaling">
                <div class="input-sections">
                    <div class="input-group">
                        <h3>👥 Serving Adjustment</h3>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="originalServings">Original Servings</label>
                                <input type="number" id="originalServings" class="input-field" placeholder="4" value="4" min="1" step="1">
                            </div>
                            <div class="input-wrapper">
                                <label for="newServings">New Servings</label>
                                <input type="number" id="newServings" class="input-field" placeholder="6" value="6" min="1" step="1">
                            </div>
                        </div>
                        <div class="input-wrapper">
                            <label for="scaleMethod">Scaling Method</label>
                            <select id="scaleMethod" class="unit-select">
                                <option value="linear">Linear Scaling</option>
                                <option value="spices">Adjust Spices Carefully</option>
                                <option value="baking">Baking (Careful Scaling)</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group">
                        <h3>📝 Recipe Ingredients</h3>
                        <div class="ingredients-list" id="scalingIngredients">
                            <div class="ingredient-row">
                                <input type="text" class="ingredient-input" placeholder="Ingredient name" value="Flour">
                                <input type="number" class="ingredient-input" placeholder="Amount" value="2" step="0.01">
                                <select class="unit-select">
                                    <option value="cups">cups</option>
                                    <option value="grams">grams</option>
                                    <option value="tbsp">tbsp</option>
                                </select>
                                <button class="remove-ingredient" onclick="removeIngredient(this)">×</button>
                            </div>
                            <div class="ingredient-row">
                                <input type="text" class="ingredient-input" placeholder="Ingredient name" value="Sugar">
                                <input type="number" class="ingredient-input" placeholder="Amount" value="1" step="0.01">
                                <select class="unit-select">
                                    <option value="cups">cups</option>
                                    <option value="grams">grams</option>
                                </select>
                                <button class="remove-ingredient" onclick="removeIngredient(this)">×</button>
                            </div>
                        </div>
                        <button class="add-ingredient-btn" onclick="addIngredient()">+ Add Ingredient</button>
                    </div>
                </div>

                <button class="calculate-btn" onclick="scaleRecipe()">Scale Recipe</button>

                <div class="results-section">
                    <div class="converted-ingredients">
                        <div class="results-header">
                            <h3>📋 Scaled Recipe</h3>
                        </div>
                        <table class="ingredients-table">
                            <thead>
                                <tr>
                                    <th>Ingredient</th>
                                    <th>Original Amount</th>
                                    <th>Scaled Amount</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody id="scaledIngredients">
                                <!-- Filled by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Ingredient Converter Tab -->
            <div class="tab-content" id="ingredient-converter">
                <div class="input-sections">
                    <div class="input-group">
                        <h3>🔍 Ingredient Search</h3>
                        <div class="input-wrapper">
                            <label for="ingredientSearch">Search Ingredient</label>
                            <input type="text" id="ingredientSearch" class="input-field" placeholder="Search for ingredients..." onkeyup="searchIngredients()">
                        </div>
                    </div>
                </div>

                <div class="common-ingredients">
                    <div class="results-header">
                        <h3>🥕 Common Ingredients</h3>
                    </div>
                    <div class="ingredients-grid" id="commonIngredients">
                        <!-- Filled by JavaScript -->
                    </div>
                </div>
            </div>

            <div class="quick-conversions">
                <div class="results-header">
                    <h3>📚 Common Baking Conversions</h3>
                </div>
                <div class="conversion-grid">
                    <div class="conversion-card" onclick="setQuickConversion(1, 'cups', 'grams', 'flour')">
                        <div class="conversion-value">1 cup flour</div>
                        <div class="conversion-label">≈ 120 grams</div>
                    </div>
                    <div class="conversion-card" onclick="setQuickConversion(1, 'cups', 'grams', 'sugar')">
                        <div class="conversion-value">1 cup sugar</div>
                        <div class="conversion-label">≈ 200 grams</div>
                    </div>
                    <div class="conversion-card" onclick="setQuickConversion(1, 'cups', 'grams', 'butter')">
                        <div class="conversion-value">1 cup butter</div>
                        <div class="conversion-label">≈ 227 grams</div>
                    </div>
                    <div class="conversion-card" onclick="setQuickConversion(1, 'tbsp', 'grams', 'butter')">
                        <div class="conversion-value">1 tbsp butter</div>
                        <div class="conversion-label">≈ 14 grams</div>
                    </div>
                    <div class="conversion-card" onclick="setQuickConversion(1, 'cups', 'ml', 'milk')">
                        <div class="conversion-value">1 cup milk</div>
                        <div class="conversion-label">≈ 240 ml</div>
                    </div>
                    <div class="conversion-card" onclick="setQuickConversion(1, 'oz', 'grams')">
                        <div class="conversion-value">1 ounce</div>
                        <div class="conversion-label">≈ 28 grams</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🥄 Recipe Conversion Guide</h2>
            
            <p>Recipe conversion involves changing ingredient quantities and measurements to adapt recipes for different serving sizes, measurement systems, or available ingredients.</p>

            <div class="conversion-grid">
                <div class="conversion-card-info">
                    <h4>📏 Why Convert Recipes?</h4>
                    <p>Adapt recipes for different serving sizes, convert between measurement systems (metric/imperial), substitute ingredients, or adjust for different pan sizes.</p>
                </div>
                <div class="conversion-card-info">
                    <h4>⚖️ Weight vs Volume</h4>
                    <p>Weight measurements (grams) are more accurate than volume measurements (cups) for baking, as they're not affected by settling or packing.</p>
                </div>
                <div class="conversion-card-info">
                    <h4>🌍 International Cooking</h4>
                    <p>Convert between metric and imperial systems to follow recipes from different countries or use kitchen tools from various regions.</p>
                </div>
            </div>

            <h3>📊 Common Measurement Conversions</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Measurement</th>
                        <th>Imperial</th>
                        <th>Metric</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>1 teaspoon</strong></td>
                        <td>1 tsp</td>
                        <td>5 ml</td>
                        <td>Standard measuring spoon</td>
                    </tr>
                    <tr>
                        <td><strong>1 tablespoon</strong></td>
                        <td>1 tbsp</td>
                        <td>15 ml</td>
                        <td>3 teaspoons</td>
                    </tr>
                    <tr>
                        <td><strong>1 fluid ounce</strong></td>
                        <td>1 fl oz</td>
                        <td>30 ml</td>
                        <td>2 tablespoons</td>
                    </tr>
                    <tr>
                        <td><strong>1 cup</strong></td>
                        <td>1 cup</td>
                        <td>240 ml</td>
                        <td>16 tablespoons</td>
                    </tr>
                    <tr>
                        <td><strong>1 pint</strong></td>
                        <td>1 pt</td>
                        <td>473 ml</td>
                        <td>2 cups</td>
                    </tr>
                    <tr>
                        <td><strong>1 quart</strong></td>
                        <td>1 qt</td>
                        <td>946 ml</td>
                        <td>4 cups</td>
                    </tr>
                    <tr>
                        <td><strong>1 gallon</strong></td>
                        <td>1 gal</td>
                        <td>3.785 L</td>
                        <td>16 cups</td>
                    </tr>
                    <tr>
                        <td><strong>1 ounce (weight)</strong></td>
                        <td>1 oz</td>
                        <td>28 g</td>
                        <td>Weight measurement</td>
                    </tr>
                    <tr>
                        <td><strong>1 pound</strong></td>
                        <td>1 lb</td>
                        <td>454 g</td>
                        <td>16 ounces</td>
                    </tr>
                </tbody>
            </table>

            <h3>🥖 Ingredient-Specific Conversions</h3>
            <div class="formula-box">
                <strong>Flour:</strong> 1 cup = 120-125 grams (varies by type and packing)<br>
                <strong>Sugar (granulated):</strong> 1 cup = 200 grams<br>
                <strong>Sugar (brown):</strong> 1 cup = 220 grams (packed)<br>
                <strong>Butter:</strong> 1 cup = 227 grams (2 sticks)<br>
                <strong>Milk:</strong> 1 cup = 240 ml = 245 grams<br>
                <strong>Honey:</strong> 1 cup = 340 grams<br>
                <strong>Oil:</strong> 1 cup = 218 grams<br>
                <strong>Salt:</strong> 1 teaspoon = 5-6 grams (varies by type)
            </div>

            <h3>🔍 Baking Conversion Tips</h3>
            <div class="conversion-grid">
                <div class="conversion-card-info">
                    <h4>⚖️ Use Weight for Baking</h4>
                    <p>For precise baking results, always use weight measurements (grams) rather than volume measurements (cups).</p>
                </div>
                <div class="conversion-card-info">
                    <h4>🥄 Spoon and Level</h4>
                    <p>When using cups, spoon flour into the cup and level with a knife - don't scoop directly from the bag.</p>
                </div>
                <div class="conversion-card-info">
                    <h4>🌡️ Temperature Conversion</h4>
                    <p>°C to °F: Multiply by 1.8 and add 32. °F to °C: Subtract 32 and multiply by 0.5556.</p>
                </div>
            </div>

            <h3>📈 Recipe Scaling Guidelines</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Scaling Factor</th>
                        <th>Method</th>
                        <th>Considerations</th>
                        <th>Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>0.5x - 2x</strong></td>
                        <td>Linear scaling</td>
                        <td>Most ingredients scale directly</td>
                        <td>Soups, stews, sauces</td>
                    </tr>
                    <tr>
                        <td><strong>2x - 4x</strong></td>
                        <td>Adjust cooking times</td>
                        <td>May need longer cooking</td>
                        <td>Casseroles, roasts</td>
                    </tr>
                    <tr>
                        <td><strong>4x+</strong></td>
                        <td>Careful adjustment</td>
                        <td>Adjust spices, leaveners carefully</td>
                        <td>Professional scaling</td>
                    </tr>
                    <tr>
                        <td><strong>Baking</strong></td>
                        <td>Precise scaling</td>
                        <td>Weigh ingredients, adjust pan size</td>
                        <td>Cakes, breads, pastries</td>
                    </tr>
                </tbody>
            </table>

            <h3>🌡️ Oven Temperature Conversion</h3>
            <div class="formula-box">
                <strong>Very Slow:</strong> 120°C / 250°F<br>
                <strong>Slow:</strong> 150°C / 300°F<br>
                <strong>Moderately Slow:</strong> 160°C / 325°F<br>
                <strong>Moderate:</strong> 180°C / 350°F<br>
                <strong>Moderately Hot:</strong> 190°C / 375°F<br>
                <strong>Hot:</strong> 200°C / 400°F<br>
                <strong>Very Hot:</strong> 220°C / 425°F<br>
                <strong>Extremely Hot:</strong> 240°C / 475°F
            </div>

            <h3>🍳 Pan Size Conversions</h3>
            <ul>
                <li><strong>8-inch round:</strong> 4 cups volume</li>
                <li><strong>9-inch round:</strong> 6 cups volume</li>
                <li><strong>10-inch round:</strong> 8 cups volume</li>
                <li><strong>8-inch square:</strong> 6 cups volume</li>
                <li><strong>9-inch square:</strong> 8 cups volume</li>
                <li><strong>13x9-inch rectangle:</strong> 12 cups volume</li>
                <li><strong>Loaf pan (9x5-inch):</strong> 6 cups volume</li>
            </ul>

            <h3>⚠️ Common Conversion Mistakes</h3>
            <div class="conversion-grid">
                <div class="conversion-card-info">
                    <h4>🚫 Confusing Weight and Volume</h4>
                    <p>Ounces can be weight (oz) or volume (fl oz). Make sure you're using the correct type for your ingredient.</p>
                </div>
                <div class="conversion-card-info">
                    <h4>📏 Incorrect Cup Measurements</h4>
                    <p>US cups (240ml) differ from UK/Australian cups (250ml) and metric cups (250ml).</p>
                </div>
                <div class="conversion-card-info">
                    <h4>🧂 Over-scaling Spices</h4>
                    <p>Spices don't always scale linearly - be careful when doubling or tripling recipes.</p>
                </div>
            </div>

            <h3>🔧 Professional Tips</h3>
            <ul>
                <li><strong>Create conversion charts:</strong> Make personalized charts for ingredients you use frequently</li>
                <li><strong>Use digital scales:</strong> Invest in a good kitchen scale for accurate measurements</li>
                <li><strong>Test scaled recipes:</strong> Always test a small batch when scaling baking recipes significantly</li>
                <li><strong>Consider altitude:</strong> High-altitude baking requires additional adjustments</li>
                <li><strong>Document changes:</strong> Keep notes of successful conversions for future reference</li>
            </ul>
        </div>

        <div class="footer">
            <p>🥄 Recipe Converter - Measurement Conversion & Scaling Tool</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert between measurement systems, scale recipes, and adjust ingredient quantities</p>
        </div>
    </div>

    <script>
        // Conversion factors and data
        const conversionFactors = {
            // Volume conversions (ml as base)
            tsp: { ml: 5, factor: 5 },
            tbsp: { ml: 15, factor: 15 },
            floz: { ml: 30, factor: 30 },
            cups: { ml: 240, factor: 240 },
            pints: { ml: 473, factor: 473 },
            quarts: { ml: 946, factor: 946 },
            gallons: { ml: 3785, factor: 3785 },
            ml: { ml: 1, factor: 1 },
            liters: { ml: 1000, factor: 1000 },
            
            // Weight conversions (grams as base)
            grams: { grams: 1, factor: 1 },
            kg: { grams: 1000, factor: 1000 },
            oz: { grams: 28.35, factor: 28.35 },
            lbs: { grams: 453.6, factor: 453.6 }
        };

        // Ingredient density factors (grams per ml for volume to weight conversion)
        const ingredientDensity = {
            general: 1,    // Water
            flour: 0.57,   // 120g per cup (120/240 = 0.5, but accounting for settling)
            sugar: 0.85,   // 200g per cup
            butter: 0.96,  // 227g per cup
            milk: 1.03,    // 245g per cup
            honey: 1.42,   // 340g per cup
            oil: 0.92,     // 218g per cup
            salt: 1.2      // Varies by type
        };

        // Common ingredients for quick access
        const commonIngredients = [
            { name: 'All-Purpose Flour', conversions: '1 cup = 120g' },
            { name: 'Bread Flour', conversions: '1 cup = 127g' },
            { name: 'Cake Flour', conversions: '1 cup = 114g' },
            { name: 'Whole Wheat Flour', conversions: '1 cup = 120g' },
            { name: 'Granulated Sugar', conversions: '1 cup = 200g' },
            { name: 'Brown Sugar', conversions: '1 cup = 220g (packed)' },
            { name: 'Powdered Sugar', conversions: '1 cup = 120g' },
            { name: 'Butter', conversions: '1 cup = 227g' },
            { name: 'Milk', conversions: '1 cup = 240ml' },
            { name: 'Heavy Cream', conversions: '1 cup = 240ml' },
            { name: 'Water', conversions: '1 cup = 240ml' },
            { name: 'Honey', conversions: '1 cup = 340g' },
            { name: 'Maple Syrup', conversions: '1 cup = 312g' },
            { name: 'Vegetable Oil', conversions: '1 cup = 218g' },
            { name: 'Olive Oil', conversions: '1 cup = 216g' },
            { name: 'Cocoa Powder', conversions: '1 cup = 85g' },
            { name: 'Chocolate Chips', conversions: '1 cup = 170g' },
            { name: 'Rolled Oats', conversions: '1 cup = 80g' },
            { name: 'Rice', conversions: '1 cup = 185g' },
            { name: 'Pasta', conversions: '1 cup = 100g (dry)' }
        ];

        // DOM elements
        const amountInput = document.getElementById('amount');
        const fromUnitSelect = document.getElementById('fromUnit');
        const toUnitSelect = document.getElementById('toUnit');
        const ingredientTypeSelect = document.getElementById('ingredientType');

        // Tab functionality
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                button.classList.add('active');
                document.getElementById(button.dataset.tab).classList.add('active');
            });
        });

        // Initialize common ingredients
        populateCommonIngredients();

        function convertUnit() {
            const amount = parseFloat(amountInput.value);
            const fromUnit = fromUnitSelect.value;
            const toUnit = toUnitSelect.value;
            const ingredientType = ingredientTypeSelect.value;

            if (isNaN(amount) || amount <= 0) {
                alert('Please enter a valid amount');
                return;
            }

            let result;
            let accuracy = 'High';

            // Check if conversion is between same type (volume-volume or weight-weight)
            const fromIsVolume = ['tsp', 'tbsp', 'floz', 'cups', 'pints', 'quarts', 'gallons', 'ml', 'liters'].includes(fromUnit);
            const toIsVolume = ['tsp', 'tbsp', 'floz', 'cups', 'pints', 'quarts', 'gallons', 'ml', 'liters'].includes(toUnit);
            const fromIsWeight = ['grams', 'kg', 'oz', 'lbs'].includes(fromUnit);
            const toIsWeight = ['grams', 'kg', 'oz', 'lbs'].includes(toUnit);

            if ((fromIsVolume && toIsVolume) || (fromIsWeight && toIsWeight)) {
                // Direct conversion within same measurement type
                result = convertDirect(amount, fromUnit, toUnit);
            } else if (fromIsVolume && toIsWeight) {
                // Volume to weight conversion
                result = convertVolumeToWeight(amount, fromUnit, toUnit, ingredientType);
                accuracy = ingredientType === 'general' ? 'Medium' : 'High';
            } else if (fromIsWeight && toIsVolume) {
                // Weight to volume conversion
                result = convertWeightToVolume(amount, fromUnit, toUnit, ingredientType);
                accuracy = ingredientType === 'general' ? 'Medium' : 'High';
            } else {
                alert('Cannot convert between these unit types');
                return;
            }

            // Update results
            document.getElementById('originalAmount').textContent = amount;
            document.getElementById('originalUnit').textContent = fromUnit;
            document.getElementById('convertedAmount').textContent = result.toFixed(2);
            document.getElementById('convertedUnit').textContent = toUnit;
            document.getElementById('conversionFactor').textContent = (result / amount).toFixed(2);
            document.getElementById('accuracyLevel').textContent = accuracy;
        }

        function convertDirect(amount, fromUnit, toUnit) {
            // Convert to base unit first, then to target unit
            let baseValue;
            
            if (['tsp', 'tbsp', 'floz', 'cups', 'pints', 'quarts', 'gallons', 'ml', 'liters'].includes(fromUnit)) {
                // Volume conversion
                baseValue = amount * conversionFactors[fromUnit].ml;
                return baseValue / conversionFactors[toUnit].ml;
            } else {
                // Weight conversion
                baseValue = amount * conversionFactors[fromUnit].grams;
                return baseValue / conversionFactors[toUnit].grams;
            }
        }

        function convertVolumeToWeight(amount, fromUnit, toUnit, ingredientType) {
            // Convert volume to ml first
            const volumeMl = amount * conversionFactors[fromUnit].ml;
            // Convert to grams using density
            const weightGrams = volumeMl * ingredientDensity[ingredientType];
            // Convert to target weight unit
            return weightGrams / conversionFactors[toUnit].grams;
        }

        function convertWeightToVolume(amount, fromUnit, toUnit, ingredientType) {
            // Convert weight to grams first
            const weightGrams = amount * conversionFactors[fromUnit].grams;
            // Convert to ml using density
            const volumeMl = weightGrams / ingredientDensity[ingredientType];
            // Convert to target volume unit
            return volumeMl / conversionFactors[toUnit].ml;
        }

        function setQuickConversion(amount, fromUnit, toUnit, ingredientType = 'general') {
            amountInput.value = amount;
            fromUnitSelect.value = fromUnit;
            toUnitSelect.value = toUnit;
            if (ingredientType) {
                ingredientTypeSelect.value = ingredientType;
            }
            convertUnit();
        }

        function addIngredient() {
            const container = document.getElementById('scalingIngredients');
            const newRow = document.createElement('div');
            newRow.className = 'ingredient-row';
            newRow.innerHTML = `
                <input type="text" class="ingredient-input" placeholder="Ingredient name">
                <input type="number" class="ingredient-input" placeholder="Amount" value="1" step="0.01">
                <select class="unit-select">
                    <option value="cups">cups</option>
                    <option value="grams">grams</option>
                    <option value="tbsp">tbsp</option>
                    <option value="tsp">tsp</option>
                    <option value="oz">oz</option>
                    <option value="lbs">lbs</option>
                    <option value="ml">ml</option>
                </select>
                <button class="remove-ingredient" onclick="removeIngredient(this)">×</button>
            `;
            container.appendChild(newRow);
        }

        function removeIngredient(button) {
            button.parentElement.remove();
        }

        function scaleRecipe() {
            const originalServings = parseInt(document.getElementById('originalServings').value);
            const newServings = parseInt(document.getElementById('newServings').value);
            const scaleMethod = document.getElementById('scaleMethod').value;

            if (isNaN(originalServings) || isNaN(newServings) || originalServings <= 0 || newServings <= 0) {
                alert('Please enter valid serving numbers');
                return;
            }

            const scaleFactor = newServings / originalServings;
            const ingredients = document.querySelectorAll('#scalingIngredients .ingredient-row');
            const resultsContainer = document.getElementById('scaledIngredients');
            
            resultsContainer.innerHTML = '';

            ingredients.forEach(row => {
                const nameInput = row.querySelector('input[type="text"]');
                const amountInput = row.querySelector('input[type="number"]');
                const unitSelect = row.querySelector('select');

                if (nameInput.value && amountInput.value) {
                    const originalAmount = parseFloat(amountInput.value);
                    let scaledAmount = originalAmount * scaleFactor;

                    // Apply scaling method adjustments
                    if (scaleMethod === 'spices' && isSpice(nameInput.value)) {
                        scaledAmount = adjustSpiceAmount(originalAmount, scaleFactor);
                    } else if (scaleMethod === 'baking') {
                        scaledAmount = adjustBakingAmount(originalAmount, scaleFactor);
                    }

                    const rowElement = document.createElement('tr');
                    rowElement.innerHTML = `
                        <td>${nameInput.value}</td>
                        <td>${originalAmount}</td>
                        <td>${scaledAmount.toFixed(2)}</td>
                        <td>${unitSelect.value}</td>
                    `;
                    resultsContainer.appendChild(rowElement);
                }
            });
        }

        function isSpice(ingredientName) {
            const spices = ['salt', 'pepper', 'cinnamon', 'nutmeg', 'ginger', 'cloves', 'paprika', 'cumin', 'oregano', 'basil', 'thyme'];
            return spices.some(spice => ingredientName.toLowerCase().includes(spice));
        }

        function adjustSpiceAmount(originalAmount, scaleFactor) {
            // Spices don't scale linearly - be more conservative
            if (scaleFactor < 1) {
                return originalAmount * Math.sqrt(scaleFactor);
            } else {
                return originalAmount * (1 + (scaleFactor - 1) * 0.7);
            }
        }

        function adjustBakingAmount(originalAmount, scaleFactor) {
            // Baking requires more precise scaling
            return originalAmount * scaleFactor;
        }

        function populateCommonIngredients() {
            const container = document.getElementById('commonIngredients');
            container.innerHTML = '';

            commonIngredients.forEach(ingredient => {
                const card = document.createElement('div');
                card.className = 'ingredient-card';
                card.innerHTML = `
                    <div class="ingredient-name">${ingredient.name}</div>
                    <div class="ingredient-conversion">${ingredient.conversions}</div>
                `;
                container.appendChild(card);
            });
        }

        function searchIngredients() {
            const searchTerm = document.getElementById('ingredientSearch').value.toLowerCase();
            const container = document.getElementById('commonIngredients');
            container.innerHTML = '';

            const filteredIngredients = commonIngredients.filter(ingredient => 
                ingredient.name.toLowerCase().includes(searchTerm)
            );

            if (filteredIngredients.length === 0) {
                container.innerHTML = '<div style="text-align: center; color: #7f8c8d; padding: 20px;">No ingredients found</div>';
                return;
            }

            filteredIngredients.forEach(ingredient => {
                const card = document.createElement('div');
                card.className = 'ingredient-card';
                card.innerHTML = `
                    <div class="ingredient-name">${ingredient.name}</div>
                    <div class="ingredient-conversion">${ingredient.conversions}</div>
                `;
                container.appendChild(card);
            });
        }

        // Initialize with a conversion
        convertUnit();
    </script>
</body>
</html>
