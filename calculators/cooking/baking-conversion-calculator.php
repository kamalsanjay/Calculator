<?php
/**
 * Baking Conversion Calculator
 * File: cooking/baking-conversion-calculator.php
 * Description: Advanced baking conversion calculator for weights, volumes, and ingredient substitutions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baking Conversion Calculator - Advanced Ingredient & Measurement Converter</title>
    <meta name="description" content="Professional baking conversion calculator for weights, volumes, temperatures, and ingredient substitutions with recipe scaling.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-tabs { display: flex; gap: 10px; margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; flex-wrap: wrap; }
        .tab { padding: 12px 24px; background: #f8f9fa; border: none; border-radius: 8px 8px 0 0; cursor: pointer; transition: all 0.3s; font-weight: 600; color: #7f8c8d; }
        .tab.active { background: #f093fb; color: white; }
        
        .input-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px; }
        
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input, .input-wrapper select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus { outline: none; border-color: #f093fb; box-shadow: 0 0 0 3px rgba(240, 147, 251, 0.1); }
        .unit { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #7f8c8d; font-weight: 600; }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .checkbox-group input[type="checkbox"] { width: 18px; height: 18px; }
        
        .calculate-btn { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none; padding: 16px 32px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin: 20px 0; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(245, 87, 108, 0.3); }
        
        .results-section { margin-top: 30px; }
        .results-section h3 { color: #2c3e50; margin-bottom: 20px; font-size: 1.3rem; }
        
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .result-card { background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%); padding: 25px; border-radius: 12px; border-left: 4px solid #f093fb; text-align: center; }
        .result-label { color: #7b1fa2; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-value { font-size: 1.5rem; font-weight: bold; color: #8e24aa; margin-bottom: 5px; }
        .result-unit { color: #ab47bc; font-size: 0.9rem; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #f5f5f5; }
        
        .tips-box { background: #f3e5f5; padding: 25px; border-radius: 12px; border-left: 4px solid #ab47bc; margin: 25px 0; }
        .tips-box h4 { color: #7b1fa2; margin-bottom: 15px; font-size: 1.1rem; }
        .tips-list { list-style: none; }
        .tips-list li { padding: 8px 0; color: #555; position: relative; padding-left: 25px; }
        .tips-list li:before { content: "🍰"; position: absolute; left: 0; }
        
        .ingredient-comparison { background: white; border: 2px solid #e0e0e0; border-radius: 12px; padding: 25px; margin-top: 25px; }
        .ingredient-comparison h4 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        
        .action-buttons { display: flex; gap: 12px; margin-top: 20px; flex-wrap: wrap; }
        .action-btn { padding: 12px 20px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; }
        .action-btn:hover { border-color: #f093fb; background: #fef7ff; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .formula-box { background: #f3e5f5; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ab47bc; }
        .formula-box strong { color: #7b1fa2; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        /* Ingredient visualization */
        .ingredient-visual { width: 100%; height: 100px; background: #f8f9fa; border-radius: 8px; margin: 20px 0; position: relative; border: 2px solid #e0e0e0; display: flex; align-items: end; }
        .ingredient-bar { flex: 1; margin: 0 2px; border-radius: 4px 4px 0 0; transition: all 0.3s; }
        .bar-label { position: absolute; bottom: -25px; font-size: 0.7rem; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-grid { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .calculator-tabs { flex-direction: column; }
            .tab { border-radius: 8px; margin-bottom: 5px; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { flex-direction: column; }
        }
        
        /* Temperature gauge */
        .temp-gauge { width: 200px; height: 100px; margin: 20px auto; position: relative; }
        .gauge-background { width: 100%; height: 100%; border-radius: 100px 100px 0 0; background: conic-gradient(#74b9ff 0%, #ffeaa7 25%, #fdcb6e 50%, #f1aeb5 75%, #e9aeb4 100%); overflow: hidden; }
        .gauge-needle { position: absolute; bottom: 0; left: 50%; width: 2px; height: 80px; background: #2c3e50; transform-origin: bottom center; transition: transform 0.5s ease; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍰 Baking Conversion Calculator</h1>
            <p>Professional baking conversions for weights, volumes, temperatures, and ingredient substitutions</p>
        </div>

        <div class="calculator-card">
            <div class="calculator-tabs">
                <button class="tab active" onclick="switchTab('weight')">Weight Conversion</button>
                <button class="tab" onclick="switchTab('volume')">Volume Conversion</button>
                <button class="tab" onclick="switchTab('temperature')">Temperature</button>
                <button class="tab" onclick="switchTab('ingredient')">Ingredient Substitution</button>
                <button class="tab" onclick="switchTab('scaling')">Recipe Scaling</button>
            </div>

            <div id="weightTab" class="tab-content">
                <div class="input-grid">
                    <div class="input-group">
                        <label for="weightAmount">Amount</label>
                        <div class="input-wrapper">
                            <input type="number" id="weightAmount" placeholder="Enter amount" value="100" step="0.1" min="0">
                            <span class="unit" id="weightInputUnit">g</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="weightFromUnit">From Unit</label>
                        <div class="input-wrapper">
                            <select id="weightFromUnit">
                                <option value="g">Grams (g)</option>
                                <option value="kg">Kilograms (kg)</option>
                                <option value="oz">Ounces (oz)</option>
                                <option value="lb">Pounds (lb)</option>
                                <option value="cup">Cups (ingredient specific)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="weightToUnit">To Unit</label>
                        <div class="input-wrapper">
                            <select id="weightToUnit">
                                <option value="g">Grams (g)</option>
                                <option value="kg">Kilograms (kg)</option>
                                <option value="oz" selected>Ounces (oz)</option>
                                <option value="lb">Pounds (lb)</option>
                                <option value="cup">Cups (ingredient specific)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="ingredientType">Ingredient Type</label>
                        <div class="input-wrapper">
                            <select id="ingredientType">
                                <option value="flour">All-Purpose Flour</option>
                                <option value="bread_flour">Bread Flour</option>
                                <option value="cake_flour">Cake Flour</option>
                                <option value="sugar_granulated">Granulated Sugar</option>
                                <option value="sugar_powdered">Powdered Sugar</option>
                                <option value="sugar_brown">Brown Sugar</option>
                                <option value="butter">Butter</option>
                                <option value="water">Water</option>
                                <option value="milk">Milk</option>
                                <option value="honey">Honey</option>
                                <option value="cocoa">Cocoa Powder</option>
                                <option value="baking_powder">Baking Powder</option>
                                <option value="salt">Salt</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="ingredient-visual" id="weightVisual">
                    <div class="ingredient-bar" style="background: #f093fb; height: 60%;" data-original="60%">
                        <div class="bar-label">Original</div>
                    </div>
                    <div class="ingredient-bar" style="background: #f5576c; height: 40%; display: none;" data-converted="40%">
                        <div class="bar-label">Converted</div>
                    </div>
                </div>
            </div>

            <div id="volumeTab" class="tab-content" style="display: none;">
                <div class="input-grid">
                    <div class="input-group">
                        <label for="volumeAmount">Amount</label>
                        <div class="input-wrapper">
                            <input type="number" id="volumeAmount" placeholder="Enter amount" value="1" step="0.1" min="0">
                            <span class="unit" id="volumeInputUnit">cup</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="volumeFromUnit">From Unit</label>
                        <div class="input-wrapper">
                            <select id="volumeFromUnit">
                                <option value="tsp">Teaspoons (tsp)</option>
                                <option value="tbsp">Tablespoons (tbsp)</option>
                                <option value="cup" selected>Cups (cup)</option>
                                <option value="pint">Pints (pt)</option>
                                <option value="quart">Quarts (qt)</option>
                                <option value="gallon">Gallons (gal)</option>
                                <option value="ml">Milliliters (ml)</option>
                                <option value="l">Liters (l)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="volumeToUnit">To Unit</label>
                        <div class="input-wrapper">
                            <select id="volumeToUnit">
                                <option value="tsp">Teaspoons (tsp)</option>
                                <option value="tbsp" selected>Tablespoons (tbsp)</option>
                                <option value="cup">Cups (cup)</option>
                                <option value="pint">Pints (pt)</option>
                                <option value="quart">Quarts (qt)</option>
                                <option value="gallon">Gallons (gal)</option>
                                <option value="ml">Milliliters (ml)</option>
                                <option value="l">Liters (l)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="volumeIngredient">Ingredient Type</label>
                        <div class="input-wrapper">
                            <select id="volumeIngredient">
                                <option value="liquid">Liquid (Water-based)</option>
                                <option value="flour">Flour (Spooned & Leveled)</option>
                                <option value="sugar">Granulated Sugar</option>
                                <option value="brown_sugar">Brown Sugar (Packed)</option>
                                <option value="butter">Butter</option>
                                <option value="honey">Honey/Syrup</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="temperatureTab" class="tab-content" style="display: none;">
                <div class="input-grid">
                    <div class="input-group">
                        <label for="tempAmount">Temperature</label>
                        <div class="input-wrapper">
                            <input type="number" id="tempAmount" placeholder="Enter temperature" value="350" step="1" min="-100" max="600">
                            <span class="unit" id="tempInputUnit">°F</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="tempFromUnit">From Scale</label>
                        <div class="input-wrapper">
                            <select id="tempFromUnit">
                                <option value="f" selected>Fahrenheit (°F)</option>
                                <option value="c">Celsius (°C)</option>
                                <option value="gas">Gas Mark</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="tempToUnit">To Scale</label>
                        <div class="input-wrapper">
                            <select id="tempToUnit">
                                <option value="f">Fahrenheit (°F)</option>
                                <option value="c" selected>Celsius (°C)</option>
                                <option value="gas">Gas Mark</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="bakingType">Baking Application</label>
                        <div class="input-wrapper">
                            <select id="bakingType">
                                <option value="general">General Baking</option>
                                <option value="bread">Bread</option>
                                <option value="cakes">Cakes</option>
                                <option value="cookies">Cookies</option>
                                <option value="pastry">Pastry</option>
                                <option value="convection">Convection Oven</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="temp-gauge">
                    <div class="gauge-background"></div>
                    <div class="gauge-needle" id="tempNeedle" style="transform: rotate(0deg);"></div>
                </div>
            </div>

            <div id="ingredientTab" class="tab-content" style="display: none;">
                <div class="input-grid">
                    <div class="input-group">
                        <label for="subIngredient">Ingredient to Substitute</label>
                        <div class="input-wrapper">
                            <select id="subIngredient">
                                <option value="butter">Butter</option>
                                <option value="milk">Milk</option>
                                <option value="eggs">Eggs</option>
                                <option value="sugar">Sugar</option>
                                <option value="flour">All-Purpose Flour</option>
                                <option value="baking_powder">Baking Powder</option>
                                <option value="yeast">Yeast</option>
                                <option value="honey">Honey</option>
                                <option value="chocolate">Chocolate</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="subAmount">Amount Needed</label>
                        <div class="input-wrapper">
                            <input type="number" id="subAmount" placeholder="Enter amount" value="1" step="0.1" min="0">
                            <span class="unit" id="subInputUnit">cup</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="dietaryNeed">Dietary Need</label>
                        <div class="input-wrapper">
                            <select id="dietaryNeed">
                                <option value="none">No Restrictions</option>
                                <option value="vegan">Vegan</option>
                                <option value="dairy_free">Dairy-Free</option>
                                <option value="gluten_free">Gluten-Free</option>
                                <option value="low_sugar">Low Sugar</option>
                                <option value="low_fat">Low Fat</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="recipeType">Recipe Type</label>
                        <div class="input-wrapper">
                            <select id="recipeType">
                                <option value="general">General Baking</option>
                                <option value="cakes">Cakes</option>
                                <option value="cookies">Cookies</option>
                                <option value="bread">Bread</option>
                                <option value="pastry">Pastry</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="scalingTab" class="tab-content" style="display: none;">
                <div class="input-grid">
                    <div class="input-group">
                        <label for="originalServings">Original Servings</label>
                        <div class="input-wrapper">
                            <input type="number" id="originalServings" placeholder="Original servings" value="8" step="1" min="1">
                            <span class="unit">servings</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="desiredServings">Desired Servings</label>
                        <div class="input-wrapper">
                            <input type="number" id="desiredServings" placeholder="Desired servings" value="12" step="1" min="1">
                            <span class="unit">servings</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="scaleMethod">Scaling Method</label>
                        <div class="input-wrapper">
                            <select id="scaleMethod">
                                <option value="linear">Linear Scaling</option>
                                <option value="baker_percentage">Baker's Percentage</option>
                                <option value="conservative">Conservative (Spices)</option>
                                <option value="exponential">Exponential (Large batches)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="recipeComplexity">Recipe Complexity</label>
                        <div class="input-wrapper">
                            <select id="recipeComplexity">
                                <option value="simple">Simple (Cookies, Muffins)</option>
                                <option value="moderate" selected>Moderate (Cakes, Bread)</option>
                                <option value="complex">Complex (Pastry, Soufflé)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <button class="calculate-btn" onclick="calculateConversion()">🧮 Calculate Conversion</button>

            <div class="results-section" id="resultsSection" style="display: none;">
                <h3>📊 Conversion Results</h3>
                
                <div class="results-grid">
                    <div class="result-card">
                        <div class="result-label">Converted Amount</div>
                        <div class="result-value" id="convertedAmount">0</div>
                        <div class="result-unit" id="convertedUnit">-</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Conversion Factor</div>
                        <div class="result-value" id="conversionFactor">0</div>
                        <div class="result-unit">Multiplier</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Accuracy</div>
                        <div class="result-value" id="accuracy">0%</div>
                        <div class="result-unit">Estimated</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Common Uses</div>
                        <div class="result-value" id="commonUses">-</div>
                        <div class="result-unit">Applications</div>
                    </div>
                </div>

                <div class="tips-box">
                    <h4>💡 Baking Tips & Notes</h4>
                    <ul class="tips-list" id="bakingTips">
                        <!-- Tips will be populated here -->
                    </ul>
                </div>

                <div class="ingredient-comparison">
                    <h4>📋 Common Equivalents</h4>
                    <table class="conversion-table">
                        <thead>
                            <tr>
                                <th>Ingredient</th>
                                <th>1 Cup Weight</th>
                                <th>1 Ounce Volume</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody id="equivalentsTable">
                            <!-- Equivalents data will be populated here -->
                        </tbody>
                    </table>
                </div>

                <div class="action-buttons">
                    <button class="action-btn" onclick="saveConversion()">
                        💾 Save Conversion
                    </button>
                    <button class="action-btn" onclick="printResults()">
                        🖨️ Print Chart
                    </button>
                    <button class="action-btn" onclick="shareConversion()">
                        📤 Share Conversion
                    </button>
                    <button class="action-btn" onclick="resetCalculator()">
                        🔄 Reset Calculator
                    </button>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🍰 Professional Baking Conversions</h2>
            
            <p>Accurate measurement conversions are essential for successful baking. This calculator provides professional-grade conversions with ingredient-specific densities and baking science considerations.</p>

            <h3>⚖️ Weight vs Volume Measurements</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Measurement Type</th>
                        <th>Accuracy</th>
                        <th>Best For</th>
                        <th>Precision Level</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Weight (Grams)</strong></td>
                        <td>High (±1%)</td>
                        <td>Professional baking, bread</td>
                        <td>Most precise</td>
                    </tr>
                    <tr>
                        <td><strong>Volume (Cups)</strong></td>
                        <td>Medium (±5-10%)</td>
                        <td>Home baking, quick recipes</td>
                        <td>Moderate precision</td>
                    </tr>
                    <tr>
                        <td><strong>Volume (Spoons)</strong></td>
                        <td>Low-Medium (±10-15%)</td>
                        <td>Small quantities, spices</td>
                        <td>Less precise</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Conversion Formulas:</strong><br>
                • <strong>Fahrenheit to Celsius:</strong> (°F - 32) × 5/9 = °C<br>
                • <strong>Celsius to Fahrenheit:</strong> (°C × 9/5) + 32 = °F<br>
                • <strong>Grams to Ounces:</strong> g ÷ 28.35 = oz<br>
                • <strong>Ounces to Grams:</strong> oz × 28.35 = g<br>
                • <strong>Cups to Milliliters:</strong> cups × 236.6 = ml
            </div>

            <h3>🎯 Ingredient-Specific Densities</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Ingredient</th>
                        <th>Grams per Cup</th>
                        <th>Ounces per Cup</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>All-Purpose Flour</strong></td>
                        <td>120g</td>
                        <td>4.25 oz</td>
                        <td>Spooned & leveled</td>
                    </tr>
                    <tr>
                        <td><strong>Bread Flour</strong></td>
                        <td>127g</td>
                        <td>4.5 oz</td>
                        <td>Higher protein content</td>
                    </tr>
                    <tr>
                        <td><strong>Cake Flour</strong></td>
                        <td>114g</td>
                        <td>4 oz</td>
                        <td>Lighter, sifted</td>
                    </tr>
                    <tr>
                        <td><strong>Granulated Sugar</strong></td>
                        <td>200g</td>
                        <td>7 oz</td>
                        <td>Standard packing</td>
                    </tr>
                    <tr>
                        <td><strong>Brown Sugar</strong></td>
                        <td>220g</td>
                        <td>7.75 oz</td>
                        <td>Packed firmly</td>
                    </tr>
                    <tr>
                        <td><strong>Powdered Sugar</strong></td>
                        <td>120g</td>
                        <td>4.25 oz</td>
                        <td>Sifted</td>
                    </tr>
                    <tr>
                        <td><strong>Butter</strong></td>
                        <td>227g</td>
                        <td>8 oz</td>
                        <td>2 sticks = 1 cup</td>
                    </tr>
                    <tr>
                        <td><strong>Water/Milk</strong></td>
                        <td>240g</td>
                        <td>8.45 oz</td>
                        <td>Liquid measure</td>
                    </tr>
                    <tr>
                        <td><strong>Honey</strong></td>
                        <td>340g</td>
                        <td>12 oz</td>
                        <td>Viscous liquid</td>
                    </tr>
                </tbody>
            </table>

            <h3>🌡️ Oven Temperature Guide</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>°F</th>
                        <th>°C</th>
                        <th>Gas Mark</th>
                        <th>Common Uses</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Very Cool</strong></td>
                        <td>200-250°F</td>
                        <td>95-120°C</td>
                        <td>¼-½</td>
                        <td>Drying, meringues</td>
                    </tr>
                    <tr>
                        <td><strong>Cool</strong></td>
                        <td>275-300°F</td>
                        <td>135-150°C</td>
                        <td>1-2</td>
                        <td>Slow baking, custards</td>
                    </tr>
                    <tr>
                        <td><strong>Moderate</strong></td>
                        <td>325-350°F</td>
                        <td>165-175°C</td>
                        <td>3-4</td>
                        <td>Most cakes, cookies</td>
                    </tr>
                    <tr>
                        <td><strong>Moderately Hot</strong></td>
                        <td>375-400°F</td>
                        <td>190-205°C</td>
                        <td>5-6</td>
                        <td>Quick breads, pies</td>
                    </tr>
                    <tr>
                        <td><strong>Hot</strong></td>
                        <td>425-450°F</td>
                        <td>220-230°C</td>
                        <td>7-8</td>
                        <td>Bread, puff pastry</td>
                    </tr>
                    <tr>
                        <td><strong>Very Hot</strong></td>
                        <td>475-500°F</td>
                        <td>245-260°C</td>
                        <td>9</td>
                        <td>Pizza, flatbreads</td>
                    </tr>
                </tbody>
            </table>

            <h3>🔄 Common Ingredient Substitutions</h3>
            <div class="formula-box">
                <strong>Emergency Substitutions:</strong><br>
                • <strong>1 cup butter:</strong> 1 cup margarine OR ⅞ cup oil<br>
                • <strong>1 cup milk:</strong> 1 cup water + 1 tbsp lemon juice OR 1 cup plant milk<br>
                • <strong>1 egg:</strong> ¼ cup applesauce OR 1 tbsp flax + 3 tbsp water<br>
                • <strong>1 cup sugar:</strong> 1 cup honey (reduce liquid by ¼ cup)<br>
                • <strong>1 tsp baking powder:</strong> ¼ tsp baking soda + ½ tsp cream of tartar<br>
                • <strong>1 cup all-purpose flour:</strong> 1 cup + 2 tbsp cake flour OR ⅞ cup bread flour
            </div>

            <h3>📐 Recipe Scaling Principles</h3>
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
                        <td>Cookies, muffins, cakes</td>
                    </tr>
                    <tr>
                        <td><strong>2x - 4x</strong></td>
                        <td>Baker's percentage</td>
                        <td>Adjust hydration, check equipment</td>
                        <td>Bread, pastry dough</td>
                    </tr>
                    <tr>
                        <td><strong>4x+</strong></td>
                        <td>Conservative scaling</td>
                        <td>Reduce spices, adjust leavening</td>
                        <td>Large batch production</td>
                    </tr>
                </tbody>
            </table>

            <h3>⚠️ Common Baking Mistakes</h3>
            <ul>
                <li><strong>Over-measuring flour:</strong> Spoon flour into cup, don't scoop</li>
                <li><strong>Incorrect temperature:</strong> Ingredients should typically be room temperature</li>
                <li><strong>Over-mixing:</strong> Develops gluten, creates tough textures</li>
                <li><strong>Inaccurate oven temp:</strong> Use oven thermometer for precision</li>
                <li><strong>Substituting without adjustment:</strong> Consider density and moisture differences</li>
                <li><strong>Ignoring altitude:</strong> High altitude requires recipe adjustments</li>
            </ul>

            <h3>🔧 Professional Baking Tips</h3>
            <div class="formula-box">
                <strong>Pro Techniques:</strong><br>
                • <strong>Weigh ingredients:</strong> Most accurate method for consistent results<br>
                • <strong>Temperature control:</strong> Butter at 65-68°F for creaming<br>
                • <strong>Proper mixing:</strong> Mix until just combined, avoid overworking<br>
                • <strong>Oven placement:</strong> Center rack for even baking<br>
                • <strong>Testing doneness:</strong> Use toothpick, internal thermometer<br>
                • <strong>Cooling properly:</strong> Wire racks prevent soggy bottoms
            </div>
        </div>

        <div class="footer">
            <p>🍰 Advanced Baking Conversion Calculator | Professional Measurements & Substitutions</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Weight conversions, temperature scaling, ingredient substitutions, and recipe adjustments</p>
        </div>
    </div>

    <script>
        // DOM elements
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');
        const resultsSection = document.getElementById('resultsSection');

        // Ingredient density database (grams per cup)
        const ingredientDensities = {
            'flour': 120,           // All-purpose flour
            'bread_flour': 127,     // Bread flour
            'cake_flour': 114,      // Cake flour
            'sugar_granulated': 200, // Granulated sugar
            'sugar_powdered': 120,  // Powdered sugar
            'sugar_brown': 220,     // Brown sugar (packed)
            'butter': 227,          // Butter
            'water': 240,           // Water
            'milk': 245,            // Milk
            'honey': 340,           // Honey
            'cocoa': 100,           // Cocoa powder
            'baking_powder': 220,   // Baking powder
            'salt': 300             // Salt
        };

        // Volume conversion factors
        const volumeConversions = {
            'tsp': { factor: 1, ml: 4.93 },
            'tbsp': { factor: 3, ml: 14.79 },
            'cup': { factor: 48, ml: 236.59 },
            'pint': { factor: 96, ml: 473.18 },
            'quart': { factor: 192, ml: 946.35 },
            'gallon': { factor: 768, ml: 3785.41 },
            'ml': { factor: 0.203, ml: 1 },
            'l': { factor: 203, ml: 1000 }
        };

        // Weight conversion factors
        const weightConversions = {
            'g': { factor: 1, oz: 0.035274 },
            'kg': { factor: 1000, oz: 35.274 },
            'oz': { factor: 28.3495, oz: 1 },
            'lb': { factor: 453.592, oz: 16 },
            'cup': { factor: 'ingredient_specific', oz: 'ingredient_specific' }
        };

        // Switch between tabs
        function switchTab(tabName) {
            // Update tab buttons
            tabs.forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');
            
            // Show selected tab content
            tabContents.forEach(content => content.style.display = 'none');
            document.getElementById(tabName + 'Tab').style.display = 'block';
            
            // Update unit labels based on tab
            updateUnitLabels(tabName);
        }

        // Update unit labels based on current tab
        function updateUnitLabels(tabName) {
            switch(tabName) {
                case 'weight':
                    document.getElementById('weightInputUnit').textContent = document.getElementById('weightFromUnit').value;
                    break;
                case 'volume':
                    document.getElementById('volumeInputUnit').textContent = document.getElementById('volumeFromUnit').value;
                    break;
                case 'temperature':
                    document.getElementById('tempInputUnit').textContent = document.getElementById('tempFromUnit').value === 'gas' ? 'mark' : '°' + document.getElementById('tempFromUnit').value.toUpperCase();
                    break;
                case 'ingredient':
                    document.getElementById('subInputUnit').textContent = 'cup';
                    break;
            }
        }

        // Calculate conversion based on current tab
        function calculateConversion() {
            const activeTab = document.querySelector('.tab.active').textContent.toLowerCase();
            
            switch(activeTab) {
                case 'weight conversion':
                    calculateWeightConversion();
                    break;
                case 'volume conversion':
                    calculateVolumeConversion();
                    break;
                case 'temperature':
                    calculateTemperatureConversion();
                    break;
                case 'ingredient substitution':
                    calculateIngredientSubstitution();
                    break;
                case 'recipe scaling':
                    calculateRecipeScaling();
                    break;
            }
            
            // Show results section
            resultsSection.style.display = 'block';
            resultsSection.scrollIntoView({ behavior: 'smooth' });
        }

        // Weight conversion calculation
        function calculateWeightConversion() {
            const amount = parseFloat(document.getElementById('weightAmount').value) || 0;
            const fromUnit = document.getElementById('weightFromUnit').value;
            const toUnit = document.getElementById('weightToUnit').value;
            const ingredient = document.getElementById('ingredientType').value;
            
            let result, conversionFactor;
            
            if (fromUnit === 'cup' || toUnit === 'cup') {
                // Handle cup conversions using ingredient density
                result = convertWithCups(amount, fromUnit, toUnit, ingredient);
                conversionFactor = result.conversionFactor;
            } else {
                // Standard weight conversion
                const amountInGrams = convertToGrams(amount, fromUnit, ingredient);
                result = convertFromGrams(amountInGrams, toUnit, ingredient);
                conversionFactor = weightConversions[toUnit].factor / weightConversions[fromUnit].factor;
            }
            
            // Update results
            updateResults(result.amount, toUnit, conversionFactor, 98, 'Baking, Cooking');
            updateBakingTips('weight', ingredient, fromUnit, toUnit);
            updateEquivalentsTable(ingredient);
            
            // Update visualization
            updateWeightVisualization(amount, result.amount);
        }

        // Volume conversion calculation
        function calculateVolumeConversion() {
            const amount = parseFloat(document.getElementById('volumeAmount').value) || 0;
            const fromUnit = document.getElementById('volumeFromUnit').value;
            const toUnit = document.getElementById('volumeToUnit').value;
            const ingredient = document.getElementById('volumeIngredient').value;
            
            // Convert to base unit (teaspoons)
            const amountInTsp = amount * volumeConversions[fromUnit].factor;
            const resultAmount = amountInTsp / volumeConversions[toUnit].factor;
            const conversionFactor = volumeConversions[toUnit].factor / volumeConversions[fromUnit].factor;
            
            // Update results
            updateResults(resultAmount, toUnit, conversionFactor, 95, 'Liquid measures, Baking');
            updateBakingTips('volume', ingredient, fromUnit, toUnit);
            updateEquivalentsTable(ingredient);
        }

        // Temperature conversion calculation
        function calculateTemperatureConversion() {
            const amount = parseFloat(document.getElementById('tempAmount').value) || 0;
            const fromUnit = document.getElementById('tempFromUnit').value;
            const toUnit = document.getElementById('tempToUnit').value;
            const bakingType = document.getElementById('bakingType').value;
            
            let resultAmount, conversionFactor;
            
            if (fromUnit === 'f' && toUnit === 'c') {
                resultAmount = (amount - 32) * 5/9;
                conversionFactor = 5/9;
            } else if (fromUnit === 'c' && toUnit === 'f') {
                resultAmount = (amount * 9/5) + 32;
                conversionFactor = 9/5;
            } else if (fromUnit === 'gas') {
                resultAmount = convertGasMark(amount, toUnit);
                conversionFactor = 1;
            } else if (toUnit === 'gas') {
                resultAmount = convertToGasMark(amount, fromUnit);
                conversionFactor = 1;
            } else {
                resultAmount = amount;
                conversionFactor = 1;
            }
            
            // Update results
            const unitSymbol = toUnit === 'gas' ? 'mark' : '°' + toUnit.toUpperCase();
            updateResults(Math.round(resultAmount), unitSymbol, conversionFactor, 99, 'Oven baking, Candy making');
            updateBakingTips('temperature', bakingType, fromUnit, toUnit);
            
            // Update temperature gauge
            updateTemperatureGauge(resultAmount, toUnit);
        }

        // Ingredient substitution calculation
        function calculateIngredientSubstitution() {
            const ingredient = document.getElementById('subIngredient').value;
            const amount = parseFloat(document.getElementById('subAmount').value) || 0;
            const dietaryNeed = document.getElementById('dietaryNeed').value;
            const recipeType = document.getElementById('recipeType').value;
            
            const substitutions = getSubstitutions(ingredient, amount, dietaryNeed, recipeType);
            
            // Update results
            document.getElementById('convertedAmount').textContent = substitutions.primary.amount + ' ' + substitutions.primary.unit;
            document.getElementById('convertedUnit').textContent = substitutions.primary.ingredient;
            document.getElementById('conversionFactor').textContent = '1:' + substitutions.primary.ratio;
            document.getElementById('accuracy').textContent = substitutions.primary.accuracy + '%';
            document.getElementById('commonUses').textContent = substitutions.primary.bestFor;
            
            updateSubstitutionTips(substitutions);
            updateEquivalentsTable(ingredient);
        }

        // Recipe scaling calculation
        function calculateRecipeScaling() {
            const original = parseFloat(document.getElementById('originalServings').value) || 1;
            const desired = parseFloat(document.getElementById('desiredServings').value) || 1;
            const method = document.getElementById('scaleMethod').value;
            const complexity = document.getElementById('recipeComplexity').value;
            
            const scalingFactor = desired / original;
            let adjustedFactor = scalingFactor;
            let accuracy = 95;
            
            // Apply scaling method adjustments
            switch(method) {
                case 'conservative':
                    adjustedFactor = scalingFactor * 0.9; // Slightly reduce for spices
                    accuracy = 90;
                    break;
                case 'exponential':
                    adjustedFactor = Math.pow(scalingFactor, 0.9); // Slight reduction for large batches
                    accuracy = 85;
                    break;
                case 'baker_percentage':
                    adjustedFactor = scalingFactor; // Linear for baker's percentage
                    accuracy = 98;
                    break;
            }
            
            // Complexity adjustments
            if (complexity === 'complex') {
                accuracy -= 5;
            }
            
            // Update results
            updateResults(adjustedFactor.toFixed(2), 'multiplier', scalingFactor, accuracy, 'Recipe scaling, Batch production');
            updateScalingTips(method, complexity, scalingFactor);
        }

        // Helper functions for conversions
        function convertToGrams(amount, unit, ingredient) {
            if (unit === 'g') return amount;
            if (unit === 'kg') return amount * 1000;
            if (unit === 'oz') return amount * 28.35;
            if (unit === 'lb') return amount * 453.6;
            if (unit === 'cup') return amount * ingredientDensities[ingredient];
            return amount;
        }

        function convertFromGrams(amount, unit, ingredient) {
            if (unit === 'g') return amount;
            if (unit === 'kg') return amount / 1000;
            if (unit === 'oz') return amount / 28.35;
            if (unit === 'lb') return amount / 453.6;
            if (unit === 'cup') return amount / ingredientDensities[ingredient];
            return amount;
        }

        function convertWithCups(amount, fromUnit, toUnit, ingredient) {
            let amountInGrams;
            
            if (fromUnit === 'cup') {
                amountInGrams = amount * ingredientDensities[ingredient];
            } else {
                amountInGrams = convertToGrams(amount, fromUnit, ingredient);
            }
            
            if (toUnit === 'cup') {
                return {
                    amount: amountInGrams / ingredientDensities[ingredient],
                    conversionFactor: ingredientDensities[ingredient] / convertToGrams(1, fromUnit, ingredient)
                };
            } else {
                const result = convertFromGrams(amountInGrams, toUnit, ingredient);
                return {
                    amount: result,
                    conversionFactor: convertToGrams(1, toUnit, ingredient) / (fromUnit === 'cup' ? ingredientDensities[ingredient] : convertToGrams(1, fromUnit, ingredient))
                };
            }
        }

        function convertGasMark(gasMark, toUnit) {
            const gasMarkTemps = {
                1: 275, 2: 300, 3: 325, 4: 350, 5: 375, 6: 400, 7: 425, 8: 450, 9: 475
            };
            const tempF = gasMarkTemps[gasMark] || 350;
            
            if (toUnit === 'f') return tempF;
            if (toUnit === 'c') return (tempF - 32) * 5/9;
            return tempF;
        }

        function convertToGasMark(temp, fromUnit) {
            let tempF = temp;
            if (fromUnit === 'c') tempF = (temp * 9/5) + 32;
            
            const gasMarkTemps = {
                1: 275, 2: 300, 3: 325, 4: 350, 5: 375, 6: 400, 7: 425, 8: 450, 9: 475
            };
            
            for (let mark in gasMarkTemps) {
                if (tempF <= gasMarkTemps[mark] + 25) return parseInt(mark);
            }
            return 5; // Default
        }

        function getSubstitutions(ingredient, amount, dietaryNeed, recipeType) {
            const substitutionDatabase = {
                'butter': [
                    { ingredient: 'Margarine', amount: amount, unit: 'cups', ratio: '1:1', accuracy: 95, bestFor: 'Baking, Cooking' },
                    { ingredient: 'Coconut Oil', amount: amount, unit: 'cups', ratio: '1:1', accuracy: 85, bestFor: 'Vegan baking' },
                    { ingredient: 'Applesauce', amount: amount * 0.5, unit: 'cups', ratio: '1:0.5', accuracy: 80, bestFor: 'Low-fat baking' }
                ],
                'milk': [
                    { ingredient: 'Almond Milk', amount: amount, unit: 'cups', ratio: '1:1', accuracy: 90, bestFor: 'Dairy-free' },
                    { ingredient: 'Soy Milk', amount: amount, unit: 'cups', ratio: '1:1', accuracy: 95, bestFor: 'Baking, Cooking' },
                    { ingredient: 'Water + Butter', amount: amount, unit: 'cups', ratio: '1:1', accuracy: 85, bestFor: 'Emergency substitute' }
                ],
                'eggs': [
                    { ingredient: 'Flax Egg', amount: amount, unit: 'eggs', ratio: '1:1', accuracy: 85, bestFor: 'Vegan baking' },
                    { ingredient: 'Applesauce', amount: amount * 0.25, unit: 'cups', ratio: '1:0.25', accuracy: 80, bestFor: 'Cakes, Muffins' },
                    { ingredient: 'Yogurt', amount: amount * 0.25, unit: 'cups', ratio: '1:0.25', accuracy: 90, bestFor: 'Moist baked goods' }
                ]
            };
            
            return {
                primary: substitutionDatabase[ingredient]?.[0] || { ingredient: 'No substitution', amount: amount, unit: 'cups', ratio: '1:1', accuracy: 100, bestFor: 'Original ingredient' },
                alternatives: substitutionDatabase[ingredient]?.slice(1) || []
            };
        }

        // Update results display
        function updateResults(amount, unit, factor, accuracy, uses) {
            document.getElementById('convertedAmount').textContent = typeof amount === 'number' ? amount.toFixed(2) : amount;
            document.getElementById('convertedUnit').textContent = unit;
            document.getElementById('conversionFactor').textContent = typeof factor === 'number' ? factor.toFixed(3) : factor;
            document.getElementById('accuracy').textContent = accuracy + '%';
            document.getElementById('commonUses').textContent = uses;
        }

        // Update baking tips
        function updateBakingTips(type, ingredient, fromUnit, toUnit) {
            const tipsList = document.getElementById('bakingTips');
            tipsList.innerHTML = '';
            
            const tips = [];
            
            switch(type) {
                case 'weight':
                    tips.push('For most accurate results, use a digital kitchen scale');
                    tips.push('Flour should be spooned into measuring cups, not scooped');
                    tips.push('Different flour brands may have slightly different densities');
                    break;
                case 'volume':
                    tips.push('Use liquid measuring cups for liquids, dry for dry ingredients');
                    tips.push('Level off dry ingredients with a straight edge');
                    tips.push('Brown sugar should be packed firmly into measuring cups');
                    break;
                case 'temperature':
                    tips.push('Oven temperatures can vary - use an oven thermometer for accuracy');
                    tips.push('Reduce temperature by 25°F when using convection ovens');
                    tips.push('Allow oven to fully preheat for most consistent results');
                    break;
            }
            
            // Add general tips
            tips.push('Measure all ingredients before starting to bake');
            tips.push('Room temperature ingredients incorporate better');
            tips.push('Preheat your oven for at least 15-20 minutes');
            
            tips.forEach(tip => {
                const li = document.createElement('li');
                li.textContent = tip;
                tipsList.appendChild(li);
            });
        }

        // Update substitution tips
        function updateSubstitutionTips(substitutions) {
            const tipsList = document.getElementById('bakingTips');
            tipsList.innerHTML = '';
            
            const tips = [];
            
            tips.push(`Primary substitution: ${substitutions.primary.amount} ${substitutions.primary.unit} ${substitutions.primary.ingredient}`);
            tips.push(`Accuracy: ${substitutions.primary.accuracy}% - Best for: ${substitutions.primary.bestFor}`);
            
            if (substitutions.alternatives.length > 0) {
                tips.push('Alternative substitutions:');
                substitutions.alternatives.forEach(alt => {
                    tips.push(`${alt.amount} ${alt.unit} ${alt.ingredient} (${alt.accuracy}% accuracy)`);
                });
            }
            
            tips.push('Test substitutions with small batches first');
            tips.push('Texture and rise may be slightly different with substitutions');
            
            tips.forEach(tip => {
                const li = document.createElement('li');
                li.textContent = tip;
                tipsList.appendChild(li);
            });
        }

        // Update scaling tips
        function updateScalingTips(method, complexity, factor) {
            const tipsList = document.getElementById('bakingTips');
            tipsList.innerHTML = '';
            
            const tips = [];
            
            tips.push(`Scaling factor: ${factor.toFixed(2)}x`);
            tips.push(`Method: ${method.charAt(0).toUpperCase() + method.slice(1)} scaling`);
            tips.push(`Recipe complexity: ${complexity.charAt(0).toUpperCase() + complexity.slice(1)}`);
            
            if (factor > 2) {
                tips.push('For large batches, consider mixing in multiple batches');
                tips.push('Baking time may need adjustment for larger volumes');
            }
            
            if (complexity === 'complex') {
                tips.push('Complex recipes may require additional technique adjustments');
                tips.push('Consider professional guidance for large-scale complex baking');
            }
            
            tips.push('Always check doneness with toothpick or thermometer');
            tips.push('Keep detailed notes for future reference');
            
            tips.forEach(tip => {
                const li = document.createElement('li');
                li.textContent = tip;
                tipsList.appendChild(li);
            });
        }

        // Update equivalents table
        function updateEquivalentsTable(ingredient) {
            const table = document.getElementById('equivalentsTable');
            table.innerHTML = '';
            
            const equivalents = [
                { ingredient: 'All-Purpose Flour', cupWeight: '120g', ounceVolume: '0.25 cups', notes: 'Spooned & leveled' },
                { ingredient: 'Granulated Sugar', cupWeight: '200g', ounceVolume: '0.14 cups', notes: 'Standard packing' },
                { ingredient: 'Brown Sugar', cupWeight: '220g', ounceVolume: '0.13 cups', notes: 'Firmly packed' },
                { ingredient: 'Butter', cupWeight: '227g', ounceVolume: '0.125 cups', notes: '2 sticks = 1 cup' },
                { ingredient: 'Milk', cupWeight: '245g', ounceVolume: '0.12 cups', notes: 'Liquid measure' }
            ];
            
            equivalents.forEach(eq => {
                const tr = document.createElement('tr');
                
                const ingTd = document.createElement('td');
                ingTd.textContent = eq.ingredient;
                tr.appendChild(ingTd);
                
                const weightTd = document.createElement('td');
                weightTd.textContent = eq.cupWeight;
                tr.appendChild(weightTd);
                
                const volumeTd = document.createElement('td');
                volumeTd.textContent = eq.ounceVolume;
                tr.appendChild(volumeTd);
                
                const notesTd = document.createElement('td');
                notesTd.textContent = eq.notes;
                tr.appendChild(notesTd);
                
                table.appendChild(tr);
            });
        }

        // Update weight visualization
        function updateWeightVisualization(originalAmount, convertedAmount) {
            const visual = document.getElementById('weightVisual');
            const bars = visual.querySelectorAll('.ingredient-bar');
            
            // Calculate relative heights (max 100%)
            const maxAmount = Math.max(originalAmount, convertedAmount);
            const originalHeight = (originalAmount / maxAmount) * 100;
            const convertedHeight = (convertedAmount / maxAmount) * 100;
            
            bars[0].style.height = originalHeight + '%';
            bars[0].setAttribute('data-original', originalAmount.toFixed(1));
            bars[0].querySelector('.bar-label').textContent = originalAmount.toFixed(1);
            
            bars[1].style.height = convertedHeight + '%';
            bars[1].style.display = 'block';
            bars[1].setAttribute('data-converted', convertedAmount.toFixed(1));
            bars[1].querySelector('.bar-label').textContent = convertedAmount.toFixed(1);
        }

        // Update temperature gauge
        function updateTemperatureGauge(temp, unit) {
            const needle = document.getElementById('tempNeedle');
            
            // Normalize temperature to gauge scale (0-500°F range)
            let normalizedTemp;
            if (unit === 'c') {
                normalizedTemp = (temp * 9/5) + 32; // Convert to Fahrenheit for gauge
            } else if (unit === 'gas') {
                normalizedTemp = convertGasMark(temp, 'f');
            } else {
                normalizedTemp = temp;
            }
            
            // Calculate needle rotation (-45deg to 225deg for 0-500°F)
            const rotation = -45 + (normalizedTemp / 500) * 270;
            needle.style.transform = `rotate(${rotation}deg)`;
        }

        // Action functions
        function saveConversion() {
            const data = {
                convertedAmount: document.getElementById('convertedAmount').textContent,
                convertedUnit: document.getElementById('convertedUnit').textContent,
                timestamp: new Date().toLocaleString()
            };
            localStorage.setItem('bakingConversion', JSON.stringify(data));
            alert('Conversion saved successfully!');
        }

        function printResults() {
            window.print();
        }

        function shareConversion() {
            const amount = document.getElementById('convertedAmount').textContent;
            const unit = document.getElementById('convertedUnit').textContent;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Baking Conversion',
                    text: `Baking conversion: ${amount} ${unit}`,
                    url: window.location.href
                });
            } else {
                alert('Share functionality not available in this browser. Conversion copied to clipboard.');
                navigator.clipboard.writeText(`Baking Conversion: ${amount} ${unit}`);
            }
        }

        function resetCalculator() {
            // Reset all inputs to defaults
            document.getElementById('weightAmount').value = '100';
            document.getElementById('volumeAmount').value = '1';
            document.getElementById('tempAmount').value = '350';
            document.getElementById('subAmount').value = '1';
            document.getElementById('originalServings').value = '8';
            document.getElementById('desiredServings').value = '12';
            
            resultsSection.style.display = 'none';
        }

        // Initialize calculator
        document.addEventListener('DOMContentLoaded', function() {
            // Add input validation
            const numberInputs = document.querySelectorAll('input[type="number"]');
            numberInputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value < 0) this.value = 0;
                });
            });
            
            // Add unit label updates when units change
            const unitSelects = document.querySelectorAll('select');
            unitSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const activeTab = document.querySelector('.tab.active').textContent.toLowerCase();
                    updateUnitLabels(activeTab.replace(' ', '_'));
                });
            });
            
            // Calculate on page load with default values
            calculateConversion();
        });
    </script>
</body>
</html>
