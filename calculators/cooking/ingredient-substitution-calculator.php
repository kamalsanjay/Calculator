<?php
/**
 * Ingredient Substitution Calculator
 * File: cooking/ingredient-substitution-calculator.php
 * Description: Advanced ingredient substitution calculator with dietary restrictions and recipe compatibility
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingredient Substitution Calculator - Advanced Recipe Adaptation Tool</title>
    <meta name="description" content="Professional ingredient substitution calculator for dietary restrictions, allergies, and recipe adaptation with compatibility analysis.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #a8e6cf 0%, #dcedc1 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin-bottom: 30px; }
        
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input, .input-wrapper select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus { outline: none; border-color: #a8e6cf; box-shadow: 0 0 0 3px rgba(168, 230, 207, 0.1); }
        .unit { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #7f8c8d; font-weight: 600; }
        
        .checkbox-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 20px 0; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; padding: 12px; background: #f8f9fa; border-radius: 8px; transition: all 0.3s; }
        .checkbox-group:hover { background: #e9f7ef; }
        .checkbox-group input[type="checkbox"] { width: 18px; height: 18px; }
        .checkbox-group label { margin: 0; font-weight: 500; }
        
        .calculate-btn { background: linear-gradient(135deg, #a8e6cf 0%, #56ab91 100%); color: white; border: none; padding: 16px 32px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin: 20px 0; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(86, 171, 145, 0.3); }
        
        .results-section { margin-top: 30px; }
        .results-section h3 { color: #2c3e50; margin-bottom: 20px; font-size: 1.3rem; }
        
        .substitution-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .sub-card { background: white; border: 2px solid #e0e0e0; border-radius: 12px; padding: 25px; transition: all 0.3s; }
        .sub-card.recommended { border-color: #4caf50; background: #f1f8e9; }
        .sub-card.good { border-color: #ff9800; background: #fff3e0; }
        .sub-card.fair { border-color: #ff5722; background: #fbe9e7; }
        .sub-card-header { display: flex; justify-content: between; align-items: center; margin-bottom: 15px; }
        .sub-card-title { font-size: 1.2rem; font-weight: bold; color: #2c3e50; }
        .sub-card-rating { padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .rating-excellent { background: #4caf50; color: white; }
        .rating-good { background: #ff9800; color: white; }
        .rating-fair { background: #ff5722; color: white; }
        .sub-card-content { line-height: 1.6; }
        .sub-ratio { font-weight: bold; color: #56ab91; }
        .sub-notes { font-size: 0.9rem; color: #7f8c8d; margin-top: 10px; padding-top: 10px; border-top: 1px solid #e0e0e0; }
        
        .compatibility-analysis { background: #e3f2fd; padding: 25px; border-radius: 12px; border-left: 4px solid #2196f3; margin: 25px 0; }
        .compatibility-analysis h4 { color: #1976d2; margin-bottom: 15px; font-size: 1.1rem; }
        
        .nutrition-comparison { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .nutrition-comparison th, .nutrition-comparison td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .nutrition-comparison th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .nutrition-comparison tr:hover { background: #f5f5f5; }
        
        .flavor-profile { display: flex; gap: 10px; margin: 15px 0; flex-wrap: wrap; }
        .flavor-tag { padding: 6px 12px; background: #a8e6cf; border-radius: 20px; font-size: 0.8rem; font-weight: 600; color: #2c3e50; }
        
        .action-buttons { display: flex; gap: 12px; margin-top: 20px; flex-wrap: wrap; }
        .action-btn { padding: 12px 20px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; }
        .action-btn:hover { border-color: #a8e6cf; background: #f1f8e9; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .formula-box { background: #e8f5e9; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #4caf50; }
        .formula-box strong { color: #2e7d32; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        /* Compatibility meter */
        .compatibility-meter { width: 100%; height: 20px; background: #f0f0f0; border-radius: 10px; margin: 15px 0; overflow: hidden; }
        .compatibility-fill { height: 100%; background: linear-gradient(90deg, #4caf50, #8bc34a, #ff9800, #ff5722); transition: width 0.5s ease; }
        
        /* Dietary icons */
        .dietary-icons { display: flex; gap: 8px; margin: 10px 0; flex-wrap: wrap; }
        .dietary-icon { padding: 4px 8px; background: #e3f2fd; border-radius: 12px; font-size: 0.7rem; font-weight: 600; color: #1976d2; }
        
        @media (max-width: 768px) {
            .input-grid { grid-template-columns: 1fr; }
            .substitution-cards { grid-template-columns: 1fr; }
            .checkbox-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { flex-direction: column; }
        }
        
        /* Ingredient visualization */
        .ingredient-visual { display: flex; align-items: center; gap: 20px; margin: 20px 0; padding: 20px; background: #f8f9fa; border-radius: 12px; }
        .original-ingredient, .substitute-ingredient { text-align: center; flex: 1; }
        .ingredient-icon { font-size: 2rem; margin-bottom: 10px; }
        .ingredient-arrow { font-size: 1.5rem; color: #7f8c8c; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔄 Ingredient Substitution Calculator</h1>
            <p>Find perfect ingredient substitutions for dietary restrictions, allergies, and recipe adaptation with compatibility analysis</p>
        </div>

        <div class="calculator-card">
            <div class="input-grid">
                <div class="input-group">
                    <label for="ingredientToSubstitute">Ingredient to Substitute</label>
                    <div class="input-wrapper">
                        <select id="ingredientToSubstitute">
                            <option value="butter">Butter</option>
                            <option value="milk">Milk</option>
                            <option value="eggs">Eggs</option>
                            <option value="sugar">Sugar</option>
                            <option value="flour">All-Purpose Flour</option>
                            <option value="yeast">Yeast</option>
                            <option value="baking_powder">Baking Powder</option>
                            <option value="honey">Honey</option>
                            <option value="chocolate">Chocolate</option>
                            <option value="cream">Heavy Cream</option>
                            <option value="buttermilk">Buttermilk</option>
                            <option value="oil">Vegetable Oil</option>
                            <option value="vanilla">Vanilla Extract</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="subAmount">Amount Needed</label>
                    <div class="input-wrapper">
                        <input type="number" id="subAmount" placeholder="Enter amount" value="1" step="0.1" min="0">
                        <span class="unit" id="subUnit">cup</span>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="recipeType">Recipe Type</label>
                    <div class="input-wrapper">
                        <select id="recipeType">
                            <option value="baking_general">General Baking</option>
                            <option value="cakes">Cakes</option>
                            <option value="cookies">Cookies</option>
                            <option value="bread">Bread</option>
                            <option value="pastry">Pastry</option>
                            <option value="sauces">Sauces & Dressings</option>
                            <option value="cooking_general">General Cooking</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="substitutionGoal">Substitution Goal</label>
                    <div class="input-wrapper">
                        <select id="substitutionGoal">
                            <option value="dietary">Dietary Restriction</option>
                            <option value="allergy">Allergy Concern</option>
                            <option value="health">Healthier Option</option>
                            <option value="availability">Ingredient Unavailable</option>
                            <option value="cost">Cost Reduction</option>
                            <option value="flavor">Flavor Variation</option>
                        </select>
                    </div>
                </div>
            </div>

            <h4 style="color: #2c3e50; margin: 20px 0 15px 0;">Dietary Restrictions & Preferences</h4>
            <div class="checkbox-grid">
                <div class="checkbox-group">
                    <input type="checkbox" id="vegan">
                    <label for="vegan">Vegan</label>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="dairy_free">
                    <label for="dairy_free">Dairy-Free</label>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="gluten_free">
                    <label for="gluten_free">Gluten-Free</label>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="nut_free">
                    <label for="nut_free">Nut-Free</label>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="egg_free">
                    <label for="egg_free">Egg-Free</label>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="soy_free">
                    <label for="soy_free">Soy-Free</label>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="low_sugar">
                    <label for="low_sugar">Low Sugar</label>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="low_fat">
                    <label for="low_fat">Low Fat</label>
                </div>
            </div>

            <div class="input-grid">
                <div class="input-group">
                    <label for="flavorPreference">Flavor Preference</label>
                    <div class="input-wrapper">
                        <select id="flavorPreference">
                            <option value="neutral">Neutral</option>
                            <option value="sweet">Sweet</option>
                            <option value="savory">Savory</option>
                            <option value="rich">Rich/Buttery</option>
                            <option value="light">Light/Delicate</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="textureImportance">Texture Importance</label>
                    <div class="input-wrapper">
                        <select id="textureImportance">
                            <option value="critical">Critical (Baking)</option>
                            <option value="important">Important</option>
                            <option value="moderate">Moderate</option>
                            <option value="flexible">Flexible</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="availability">Ingredient Availability</label>
                    <div class="input-wrapper">
                        <select id="availability">
                            <option value="common">Common Pantry Items</option>
                            <option value="specialty">Specialty Stores OK</option>
                            <option value="online">Online Ordering OK</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="experienceLevel">Cooking Experience</label>
                    <div class="input-wrapper">
                        <select id="experienceLevel">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate" selected>Intermediate</option>
                            <option value="advanced">Advanced</option>
                            <option value="professional">Professional</option>
                        </select>
                    </div>
                </div>
            </div>

            <button class="calculate-btn" onclick="calculateSubstitutions()">🔄 Find Substitutions</button>

            <div class="results-section" id="resultsSection" style="display: none;">
                <h3>📊 Substitution Recommendations</h3>
                
                <div class="ingredient-visual">
                    <div class="original-ingredient">
                        <div class="ingredient-icon" id="originalIcon">🥛</div>
                        <div class="ingredient-name" id="originalName">Milk</div>
                        <div class="ingredient-amount" id="originalAmount">1 cup</div>
                    </div>
                    <div class="ingredient-arrow">→</div>
                    <div class="substitute-ingredient">
                        <div class="ingredient-icon" id="substituteIcon">🌱</div>
                        <div class="ingredient-name" id="substituteName">Almond Milk</div>
                        <div class="ingredient-amount" id="substituteAmount">1 cup</div>
                    </div>
                </div>
                
                <div class="substitution-cards" id="substitutionCards">
                    <!-- Substitution cards will be populated here -->
                </div>

                <div class="compatibility-analysis">
                    <h4>🔍 Recipe Compatibility Analysis</h4>
                    <div class="compatibility-meter">
                        <div class="compatibility-fill" id="compatibilityFill" style="width: 85%;"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; color: #7f8c8d;">
                        <span>Low Compatibility</span>
                        <span id="compatibilityScore">85% Compatibility</span>
                        <span>High Compatibility</span>
                    </div>
                    <div id="compatibilityDetails" style="margin-top: 15px;">
                        <!-- Compatibility details will be populated here -->
                    </div>
                </div>

                <div style="background: white; padding: 20px; border-radius: 12px; margin: 20px 0;">
                    <h4 style="color: #2c3e50; margin-bottom: 15px;">📈 Nutrition Comparison</h4>
                    <table class="nutrition-comparison">
                        <thead>
                            <tr>
                                <th>Nutrient</th>
                                <th>Original</th>
                                <th>Substitute</th>
                                <th>Change</th>
                            </tr>
                        </thead>
                        <tbody id="nutritionTable">
                            <!-- Nutrition data will be populated here -->
                        </tbody>
                    </table>
                </div>

                <div class="action-buttons">
                    <button class="action-btn" onclick="saveSubstitution()">
                        💾 Save Substitution
                    </button>
                    <button class="action-btn" onclick="printSubstitutions()">
                        🖨️ Print Guide
                    </button>
                    <button class="action-btn" onclick="shareSubstitution()">
                        📤 Share Substitution
                    </button>
                    <button class="action-btn" onclick="resetCalculator()">
                        🔄 New Search
                    </button>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🔄 Professional Ingredient Substitution Guide</h2>
            
            <p>Master the art of ingredient substitution with professional techniques for dietary restrictions, allergies, and creative recipe adaptation while maintaining flavor and texture integrity.</p>

            <h3>🎯 Substitution Success Factors</h3>
            <table class="nutrition-comparison">
                <thead>
                    <tr>
                        <th>Factor</th>
                        <th>Importance</th>
                        <th>Considerations</th>
                        <th>Testing Required</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Flavor Profile</strong></td>
                        <td>High</td>
                        <td>Sweet, savory, neutral, aromatic</td>
                        <td>Recommended</td>
                    </tr>
                    <tr>
                        <td><strong>Texture Impact</strong></td>
                        <td>High</td>
                        <td>Moisture, density, crumb structure</td>
                        <td>Essential</td>
                    </tr>
                    <tr>
                        <td><strong>Chemical Function</strong></td>
                        <td>Critical</td>
                        <td>Leavening, binding, tenderizing</td>
                        <td>Mandatory</td>
                    </tr>
                    <tr>
                        <td><strong>Moisture Content</strong></td>
                        <td>High</td>
                        <td>Liquid vs dry ingredient balance</td>
                        <td>Recommended</td>
                    </tr>
                    <tr>
                        <td><strong>Acidity Level</strong></td>
                        <td>Medium</td>
                        <td>pH balance for chemical reactions</td>
                        <td>For sensitive recipes</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Substitution Principles:</strong><br>
                • <strong>1:1 Ratio:</strong> Direct substitution when properties match closely<br>
                • <strong>Adjusted Ratio:</strong> Modify quantities based on density/moisture differences<br>
                • <strong>Combination Approach:</strong> Use multiple ingredients to replicate complex functions<br>
                • <strong>Flavor Compensation:</strong> Add complementary flavors to balance changes<br>
                • <strong>Texture Management:</strong> Adjust mixing techniques and cooking times
            </div>

            <h3>🌱 Common Dietary Substitutions</h3>
            <table class="nutrition-comparison">
                <thead>
                    <tr>
                        <th>Original Ingredient</th>
                        <th>Vegan</th>
                        <th>Gluten-Free</th>
                        <th>Dairy-Free</th>
                        <th>Egg-Free</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>1 Egg</strong></td>
                        <td>1 tbsp flax + 3 tbsp water</td>
                        <td>Same as vegan</td>
                        <td>Same as vegan</td>
                        <td>1/4 cup applesauce</td>
                    </tr>
                    <tr>
                        <td><strong>1 cup Milk</strong></td>
                        <td>1 cup plant milk</td>
                        <td>1 cup plant milk</td>
                        <td>1 cup plant milk</td>
                        <td>1 cup plant milk</td>
                    </tr>
                    <tr>
                        <td><strong>1 cup Flour</strong></td>
                        <td>1 cup gluten-free blend</td>
                        <td>1 cup gluten-free blend</td>
                        <td>Same as original</td>
                        <td>Same as original</td>
                    </tr>
                    <tr>
                        <td><strong>1 cup Butter</strong></td>
                        <td>1 cup coconut oil</td>
                        <td>Same as vegan</td>
                        <td>1 cup vegan butter</td>
                        <td>Same as original</td>
                    </tr>
                    <tr>
                        <td><strong>1 cup Buttermilk</strong></td>
                        <td>1 cup plant milk + 1 tbsp vinegar</td>
                        <td>Same as vegan</td>
                        <td>1 cup plant milk + 1 tbsp vinegar</td>
                        <td>Same as vegan</td>
                    </tr>
                </tbody>
            </table>

            <h3>🔬 Chemical Function Substitutions</h3>
            <div class="formula-box">
                <strong>Leavening Agents:</strong><br>
                • <strong>1 tsp baking powder:</strong> 1/4 tsp baking soda + 1/2 tsp cream of tartar<br>
                • <strong>1 tsp baking soda:</strong> 3 tsp baking powder (reduce acid)<br>
                • <strong>Yeast (active dry):</strong> Instant yeast 1:1 (no proofing needed)<br><br>
                <strong>Binding Agents:</strong><br>
                • <strong>1 egg (binding):</strong> 1 tbsp ground flax/chia + 3 tbsp water<br>
                • <strong>1 egg (leavening):</strong> 1/4 cup carbonated water<br>
                • <strong>Gelatin:</strong> Agar agar 1:1 (vegetarian alternative)
            </div>

            <h3>🍯 Sweetener Substitutions</h3>
            <table class="nutrition-comparison">
                <thead>
                    <tr>
                        <th>Sweetener</th>
                        <th>Substitution Ratio</th>
                        <th>Liquid Adjustment</th>
                        <th>Best For</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>White Sugar</strong></td>
                        <td>1:1</td>
                        <td>None</td>
                        <td>All purposes</td>
                        <td>Standard reference</td>
                    </tr>
                    <tr>
                        <td><strong>Honey</strong></td>
                        <td>3/4 cup : 1 cup sugar</td>
                        <td>Reduce by 3 tbsp</td>
                        <td>Baking, glazes</td>
                        <td>Adds moisture</td>
                    </tr>
                    <tr>
                        <td><strong>Maple Syrup</strong></td>
                        <td>3/4 cup : 1 cup sugar</td>
                        <td>Reduce by 3 tbsp</td>
                        <td>Baking, sauces</td>
                        <td>Distinct flavor</td>
                    </tr>
                    <tr>
                        <td><strong>Agave Nectar</strong></td>
                        <td>2/3 cup : 1 cup sugar</td>
                        <td>Reduce by 1/4 cup</td>
                        <td>Beverages, raw</td>
                        <td>Very sweet</td>
                    </tr>
                    <tr>
                        <td><strong>Coconut Sugar</strong></td>
                        <td>1:1</td>
                        <td>None</td>
                        <td>Baking</td>
                        <td>Caramel flavor</td>
                    </tr>
                </tbody>
            </table>

            <h3>⚠️ Common Substitution Pitfalls</h3>
            <ul>
                <li><strong>Over-substituting multiple ingredients:</strong> Changes compound and create unpredictable results</li>
                <li><strong>Ignoring moisture differences:</strong> Liquid/dry substitutions require recipe adjustment</li>
                <li><strong>Flavor incompatibility:</strong> Strong-flavored substitutes can overwhelm delicate recipes</li>
                <li><strong>Texture mismatches:</strong> Some substitutes create gummy or dense results</li>
                <li><strong>Chemical reaction failures:</strong> Leavening agents require specific pH conditions</li>
                <li><strong>Nutritional imbalance:</strong> Some substitutes significantly alter macronutrient profiles</li>
            </ul>

            <h3>🔧 Professional Testing Protocol</h3>
            <div class="formula-box">
                <strong>Substitution Validation Process:</strong><br>
                1. <strong>Small Batch Test:</strong> Make 1/4 recipe with substitution first<br>
                2. <strong>Visual Inspection:</strong> Check color, rise, and appearance<br>
                3. <strong>Texture Analysis:</strong> Evaluate crumb, moisture, mouthfeel<br>
                4. <strong>Flavor Assessment:</strong> Taste for balance and off-flavors<br>
                5. <strong>Storage Testing:</strong> Check how substitution affects shelf life<br>
                6. <strong>Documentation:</strong> Record successful ratios and adjustments
            </div>

            <h3>🌍 Cultural & Regional Substitutions</h3>
            <table class="nutrition-comparison">
                <thead>
                    <tr>
                        <th>Region</th>
                        <th>Common Substitutions</th>
                        <th>Rationale</th>
                        <th>Success Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Asian Cuisine</strong></td>
                        <td>Mirin → Sweet sherry + sugar</td>
                        <td>Flavor profile match</td>
                        <td>85%</td>
                    </tr>
                    <tr>
                        <td><strong>Mediterranean</strong></td>
                        <td>Feta → Tofu + salt + lemon</td>
                        <td>Texture and saltiness</td>
                        <td>75%</td>
                    </tr>
                    <tr>
                        <td><strong>Latin American</strong></td>
                        <td>Queso fresco → Farmer's cheese</td>
                        <td>Similar melting properties</td>
                        <td>90%</td>
                    </tr>
                    <tr>
                        <td><strong>European Baking</strong></td>
                        <td>Type 55 flour → AP flour + vital wheat gluten</td>
                        <td>Protein content adjustment</td>
                        <td>88%</td>
                    </tr>
                </tbody>
            </table>

            <h3>💡 Advanced Substitution Techniques</h3>
            <ul>
                <li><strong>Flavor layering:</strong> Combine multiple substitutes to create complexity</li>
                <li><strong>Texture engineering:</strong> Use hydrocolloids for specific mouthfeel</li>
                <li><strong>Umami building:</strong> Combine ingredients to replicate savory depth</li>
                <li><strong>Acid balancing:</strong> Adjust citrus or vinegar to maintain pH balance</li>
                <li><strong>Maillard reaction optimization:</strong> Use amino acids for browning</li>
                <li><strong>Emulsion stabilization:</strong> Use lecithin-rich substitutes for sauces</li>
            </ul>
        </div>

        <div class="footer">
            <p>🔄 Advanced Ingredient Substitution Calculator | Dietary Adaptation & Recipe Compatibility</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Vegan, gluten-free, allergy-friendly substitutions with nutrition analysis and compatibility scoring</p>
        </div>
    </div>

    <script>
        // DOM elements
        const resultsSection = document.getElementById('resultsSection');
        const substitutionCards = document.getElementById('substitutionCards');

        // Comprehensive substitution database
        const substitutionDatabase = {
            'butter': {
                name: 'Butter',
                icon: '🧈',
                substitutions: [
                    {
                        name: 'Coconut Oil',
                        icon: '🥥',
                        ratio: '1:1',
                        accuracy: 95,
                        rating: 'excellent',
                        bestFor: ['Baking', 'Cooking', 'Vegan'],
                        dietary: ['vegan', 'dairy_free'],
                        flavor: 'neutral',
                        notes: 'Excellent for baking, provides similar fat content and melting properties',
                        nutrition: { calories: -15, fat: -2, saturated: -10 }
                    },
                    {
                        name: 'Applesauce',
                        icon: '🍎',
                        ratio: '1:0.5',
                        accuracy: 80,
                        rating: 'good',
                        bestFor: ['Low-fat baking', 'Muffins', 'Cakes'],
                        dietary: ['vegan', 'low_fat', 'dairy_free'],
                        flavor: 'sweet',
                        notes: 'Reduces fat content significantly, adds moisture and natural sweetness',
                        nutrition: { calories: -70, fat: -11, sugar: +8 }
                    },
                    {
                        name: 'Greek Yogurt',
                        icon: '🥛',
                        ratio: '1:1',
                        accuracy: 85,
                        rating: 'good',
                        bestFor: ['Baking', 'Healthy swaps'],
                        dietary: ['low_fat'],
                        flavor: 'tangy',
                        notes: 'Adds protein and reduces fat while maintaining moisture',
                        nutrition: { calories: -60, fat: -11, protein: +5 }
                    }
                ]
            },
            'milk': {
                name: 'Milk',
                icon: '🥛',
                substitutions: [
                    {
                        name: 'Almond Milk',
                        icon: '🌱',
                        ratio: '1:1',
                        accuracy: 90,
                        rating: 'excellent',
                        bestFor: ['Baking', 'Cereals', 'Smoothies'],
                        dietary: ['vegan', 'dairy_free', 'low_fat'],
                        flavor: 'nutty',
                        notes: 'Works well in most recipes, slightly nutty flavor',
                        nutrition: { calories: -70, fat: -4, protein: -7 }
                    },
                    {
                        name: 'Oat Milk',
                        icon: '🌾',
                        ratio: '1:1',
                        accuracy: 92,
                        rating: 'excellent',
                        bestFor: ['Coffee', 'Baking', 'Sauces'],
                        dietary: ['vegan', 'dairy_free', 'nut_free'],
                        flavor: 'creamy',
                        notes: 'Creamy texture, excellent for coffee and baking',
                        nutrition: { calories: -40, fat: -4, carbs: +2 }
                    },
                    {
                        name: 'Coconut Milk',
                        icon: '🥥',
                        ratio: '1:1',
                        accuracy: 88,
                        rating: 'good',
                        bestFor: ['Curries', 'Desserts', 'Tropical dishes'],
                        dietary: ['vegan', 'dairy_free'],
                        flavor: 'tropical',
                        notes: 'Rich and creamy, adds tropical flavor',
                        nutrition: { calories: +30, fat: +8, saturated: +7 }
                    }
                ]
            },
            'eggs': {
                name: 'Eggs',
                icon: '🥚',
                substitutions: [
                    {
                        name: 'Flax Egg',
                        icon: '🌱',
                        ratio: '1:1',
                        accuracy: 85,
                        rating: 'good',
                        bestFor: ['Vegan baking', 'Binding'],
                        dietary: ['vegan', 'egg_free'],
                        flavor: 'neutral',
                        notes: 'Mix 1 tbsp ground flax with 3 tbsp water, let sit 5 minutes',
                        nutrition: { calories: -50, fat: -4, fiber: +3 }
                    },
                    {
                        name: 'Applesauce',
                        icon: '🍎',
                        ratio: '1:0.25',
                        accuracy: 75,
                        rating: 'fair',
                        bestFor: ['Cakes', 'Muffins', 'Quick breads'],
                        dietary: ['vegan', 'egg_free', 'low_fat'],
                        flavor: 'sweet',
                        notes: 'Adds moisture and sweetness, reduces leavening',
                        nutrition: { calories: -40, fat: -5, sugar: +6 }
                    },
                    {
                        name: 'Silken Tofu',
                        icon: '🧈',
                        ratio: '1:0.25',
                        accuracy: 80,
                        rating: 'good',
                        bestFor: ['Dense baking', 'Custards'],
                        dietary: ['vegan', 'egg_free'],
                        flavor: 'neutral',
                        notes: 'Blend until smooth, provides structure and moisture',
                        nutrition: { calories: -30, protein: +2, fat: -4 }
                    }
                ]
            },
            'flour': {
                name: 'All-Purpose Flour',
                icon: '🌾',
                substitutions: [
                    {
                        name: 'Gluten-Free Blend',
                        icon: '🌱',
                        ratio: '1:1',
                        accuracy: 90,
                        rating: 'excellent',
                        bestFor: ['All gluten-free baking'],
                        dietary: ['gluten_free', 'vegan'],
                        flavor: 'neutral',
                        notes: 'Commercial blends work best for consistent results',
                        nutrition: { calories: -10, protein: -2, fiber: +1 }
                    },
                    {
                        name: 'Almond Flour',
                        icon: '🥜',
                        ratio: '1:1',
                        accuracy: 70,
                        rating: 'fair',
                        bestFor: ['Cookies', 'Crusts', 'Low-carb'],
                        dietary: ['gluten_free', 'low_carb'],
                        flavor: 'nutty',
                        notes: 'High in fat, requires more binding agents',
                        nutrition: { calories: +80, fat: +14, protein: +4 }
                    },
                    {
                        name: 'Oat Flour',
                        icon: '🌾',
                        ratio: '1:1',
                        accuracy: 80,
                        rating: 'good',
                        bestFor: ['Quick breads', 'Cookies'],
                        dietary: ['gluten_free', 'vegan'],
                        flavor: 'mild',
                        notes: 'Make your own by grinding oats, adds fiber',
                        nutrition: { calories: -20, fiber: +3, protein: +1 }
                    }
                ]
            }
        };

        // Calculate substitutions based on user input
        function calculateSubstitutions() {
            const ingredient = document.getElementById('ingredientToSubstitute').value;
            const amount = parseFloat(document.getElementById('subAmount').value) || 0;
            const recipeType = document.getElementById('recipeType').value;
            const substitutionGoal = document.getElementById('substitutionGoal').value;
            
            // Get dietary restrictions
            const dietaryRestrictions = getDietaryRestrictions();
            const flavorPreference = document.getElementById('flavorPreference').value;
            const textureImportance = document.getElementById('textureImportance').value;
            const availability = document.getElementById('availability').value;
            const experienceLevel = document.getElementById('experienceLevel').value;
            
            const ingredientData = substitutionDatabase[ingredient];
            if (!ingredientData) return;
            
            // Update visual elements
            updateIngredientVisual(ingredientData, amount);
            
            // Filter and score substitutions
            const filteredSubstitutions = filterAndScoreSubstitutions(
                ingredientData.substitutions,
                dietaryRestrictions,
                recipeType,
                substitutionGoal,
                flavorPreference,
                textureImportance,
                availability,
                experienceLevel
            );
            
            // Display substitutions
            displaySubstitutions(filteredSubstitutions, amount);
            
            // Update compatibility analysis
            updateCompatibilityAnalysis(filteredSubstitutions[0], recipeType, textureImportance);
            
            // Update nutrition comparison
            updateNutritionComparison(ingredientData, filteredSubstitutions[0], amount);
            
            // Show results section
            resultsSection.style.display = 'block';
            resultsSection.scrollIntoView({ behavior: 'smooth' });
        }

        // Get dietary restrictions from checkboxes
        function getDietaryRestrictions() {
            const restrictions = [];
            const checkboxes = [
                'vegan', 'dairy_free', 'gluten_free', 'nut_free', 
                'egg_free', 'soy_free', 'low_sugar', 'low_fat'
            ];
            
            checkboxes.forEach(id => {
                if (document.getElementById(id).checked) {
                    restrictions.push(id);
                }
            });
            
            return restrictions;
        }

        // Filter and score substitutions based on criteria
        function filterAndScoreSubstitutions(substitutions, dietary, recipeType, goal, flavor, texture, availability, experience) {
            return substitutions.map(sub => {
                let score = sub.accuracy;
                
                // Dietary compatibility
                if (dietary.length > 0) {
                    const dietaryMatch = dietary.every(req => sub.dietary.includes(req));
                    score *= dietaryMatch ? 1.1 : 0.7;
                }
                
                // Recipe type compatibility
                const recipeBonus = sub.bestFor.includes(getRecipeCategory(recipeType)) ? 1.05 : 0.95;
                score *= recipeBonus;
                
                // Goal alignment
                score *= getGoalAlignment(sub, goal);
                
                // Flavor preference
                score *= getFlavorCompatibility(sub.flavor, flavor);
                
                // Texture importance
                score *= getTextureCompatibility(sub, texture);
                
                // Availability
                score *= getAvailabilityScore(sub, availability);
                
                // Experience level
                score *= getExperienceScore(sub, experience);
                
                return {
                    ...sub,
                    finalScore: Math.min(Math.round(score), 100)
                };
            }).sort((a, b) => b.finalScore - a.finalScore);
        }

        // Helper functions for scoring
        function getRecipeCategory(recipeType) {
            const categories = {
                'baking_general': 'Baking',
                'cakes': 'Cakes',
                'cookies': 'Cookies',
                'bread': 'Bread',
                'pastry': 'Pastry',
                'sauces': 'Sauces',
                'cooking_general': 'Cooking'
            };
            return categories[recipeType] || 'General';
        }

        function getGoalAlignment(substitution, goal) {
            const goalAlignments = {
                'dietary': substitution.dietary.length > 0 ? 1.1 : 0.9,
                'allergy': substitution.dietary.length > 0 ? 1.15 : 0.8,
                'health': substitution.nutrition.calories < 0 ? 1.1 : 0.95,
                'availability': 1.0,
                'cost': 1.0,
                'flavor': 1.0
            };
            return goalAlignments[goal] || 1.0;
        }

        function getFlavorCompatibility(subFlavor, userPreference) {
            if (userPreference === 'neutral') return 1.0;
            if (subFlavor === userPreference) return 1.1;
            if (subFlavor === 'neutral') return 1.0;
            return 0.9;
        }

        function getTextureCompatibility(substitution, importance) {
            const importanceFactors = {
                'critical': 0.9,
                'important': 0.95,
                'moderate': 1.0,
                'flexible': 1.05
            };
            return importanceFactors[importance] || 1.0;
        }

        function getAvailabilityScore(substitution, availability) {
            const availabilityScores = {
                'common': 1.0,
                'specialty': 0.95,
                'online': 0.9
            };
            return availabilityScores[availability] || 1.0;
        }

        function getExperienceScore(substitution, experience) {
            const experienceScores = {
                'beginner': 0.9,
                'intermediate': 1.0,
                'advanced': 1.05,
                'professional': 1.1
            };
            return experienceScores[experience] || 1.0;
        }

        // Update ingredient visual
        function updateIngredientVisual(ingredientData, amount) {
            document.getElementById('originalIcon').textContent = ingredientData.icon;
            document.getElementById('originalName').textContent = ingredientData.name;
            document.getElementById('originalAmount').textContent = amount + ' ' + document.getElementById('subUnit').textContent;
        }

        // Display substitution cards
        function displaySubstitutions(substitutions, amount) {
            substitutionCards.innerHTML = '';
            
            substitutions.forEach((sub, index) => {
                const card = document.createElement('div');
                card.className = `sub-card ${getRatingClass(sub.rating)}`;
                if (index === 0) card.classList.add('recommended');
                
                const ratingClass = `rating-${sub.rating}`;
                
                card.innerHTML = `
                    <div class="sub-card-header">
                        <div class="sub-card-title">${sub.icon} ${sub.name}</div>
                        <div class="sub-card-rating ${ratingClass}">${sub.finalScore}% Match</div>
                    </div>
                    <div class="sub-card-content">
                        <p><strong>Ratio:</strong> <span class="sub-ratio">${sub.ratio}</span> (${calculateSubAmount(amount, sub.ratio)})</p>
                        <p><strong>Best For:</strong> ${sub.bestFor.join(', ')}</p>
                        <div class="dietary-icons">
                            ${sub.dietary.map(d => `<span class="dietary-icon">${d.replace('_', ' ')}</span>`).join('')}
                        </div>
                        <div class="flavor-profile">
                            <span class="flavor-tag">${sub.flavor} flavor</span>
                        </div>
                        <div class="sub-notes">${sub.notes}</div>
                    </div>
                `;
                
                substitutionCards.appendChild(card);
            });
            
            // Update substitute visual with top recommendation
            if (substitutions.length > 0) {
                const topSub = substitutions[0];
                document.getElementById('substituteIcon').textContent = topSub.icon;
                document.getElementById('substituteName').textContent = topSub.name;
                document.getElementById('substituteAmount').textContent = calculateSubAmount(amount, topSub.ratio);
            }
        }

        // Calculate substitution amount based on ratio
        function calculateSubAmount(amount, ratio) {
            if (ratio === '1:1') return amount + ' ' + document.getElementById('subUnit').textContent;
            
            const parts = ratio.split(':');
            if (parts.length === 2) {
                const subAmount = (amount * parseFloat(parts[0])) / parseFloat(parts[1]);
                return subAmount.toFixed(2) + ' ' + document.getElementById('subUnit').textContent;
            }
            
            return ratio;
        }

        // Get CSS class for rating
        function getRatingClass(rating) {
            const ratingClasses = {
                'excellent': 'recommended',
                'good': 'good',
                'fair': 'fair'
            };
            return ratingClasses[rating] || 'fair';
        }

        // Update compatibility analysis
        function updateCompatibilityAnalysis(substitution, recipeType, textureImportance) {
            const compatibilityFill = document.getElementById('compatibilityFill');
            const compatibilityScore = document.getElementById('compatibilityScore');
            const compatibilityDetails = document.getElementById('compatibilityDetails');
            
            compatibilityFill.style.width = substitution.finalScore + '%';
            compatibilityScore.textContent = substitution.finalScore + '% Compatibility';
            
            let detailsHTML = `
                <p><strong>${substitution.name}</strong> is an excellent match for your needs:</p>
                <ul style="margin-top: 10px;">
                    <li>Meets all dietary requirements</li>
                    <li>Well-suited for ${getRecipeCategory(recipeType)} recipes</li>
                    <li>${substitution.flavor} flavor profile complements your preference</li>
            `;
            
            if (textureImportance === 'critical') {
                detailsHTML += `<li>Texture properties closely match the original ingredient</li>`;
            }
            
            detailsHTML += `</ul>`;
            
            compatibilityDetails.innerHTML = detailsHTML;
        }

        // Update nutrition comparison
        function updateNutritionComparison(originalIngredient, substitution, amount) {
            const nutritionTable = document.getElementById('nutritionTable');
            nutritionTable.innerHTML = '';
            
            const nutritionData = [
                { nutrient: 'Calories', original: '150', substitute: (150 + substitution.nutrition.calories).toString(), change: substitution.nutrition.calories },
                { nutrient: 'Fat (g)', original: '12', substitute: (12 + substitution.nutrition.fat).toString(), change: substitution.nutrition.fat },
                { nutrient: 'Protein (g)', original: '8', substitute: (8 + substitution.nutrition.protein).toString(), change: substitution.nutrition.protein },
                { nutrient: 'Carbs (g)', original: '9', substitute: (9 + (substitution.nutrition.carbs || 0)).toString(), change: substitution.nutrition.carbs || 0 },
                { nutrient: 'Sugar (g)', original: '6', substitute: (6 + (substitution.nutrition.sugar || 0)).toString(), change: substitution.nutrition.sugar || 0 }
            ];
            
            nutritionData.forEach(row => {
                const tr = document.createElement('tr');
                
                const nutrientTd = document.createElement('td');
                nutrientTd.textContent = row.nutrient;
                tr.appendChild(nutrientTd);
                
                const originalTd = document.createElement('td');
                originalTd.textContent = row.original;
                tr.appendChild(originalTd);
                
                const substituteTd = document.createElement('td');
                substituteTd.textContent = row.substitute;
                tr.appendChild(substituteTd);
                
                const changeTd = document.createElement('td');
                changeTd.textContent = (row.change > 0 ? '+' : '') + row.change;
                changeTd.style.color = row.change < 0 ? '#4caf50' : row.change > 0 ? '#f44336' : '#7f8c8d';
                changeTd.style.fontWeight = '600';
                tr.appendChild(changeTd);
                
                nutritionTable.appendChild(tr);
            });
        }

        // Action functions
        function saveSubstitution() {
            const original = document.getElementById('originalName').textContent;
            const substitute = document.getElementById('substituteName').textContent;
            const amount = document.getElementById('substituteAmount').textContent;
            
            const data = {
                original: original,
                substitute: substitute,
                amount: amount,
                timestamp: new Date().toLocaleString()
            };
            
            localStorage.setItem('ingredientSubstitution', JSON.stringify(data));
            alert('Substitution saved successfully!');
        }

        function printSubstitutions() {
            window.print();
        }

        function shareSubstitution() {
            const original = document.getElementById('originalName').textContent;
            const substitute = document.getElementById('substituteName').textContent;
            const amount = document.getElementById('substituteAmount').textContent;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Ingredient Substitution',
                    text: `Substitute ${original} with ${amount} ${substitute}`,
                    url: window.location.href
                });
            } else {
                alert('Share functionality not available. Substitution copied to clipboard.');
                navigator.clipboard.writeText(`Substitute ${original} with ${amount} ${substitute}`);
            }
        }

        function resetCalculator() {
            // Reset form
            document.getElementById('ingredientToSubstitute').value = 'butter';
            document.getElementById('subAmount').value = '1';
            document.getElementById('recipeType').value = 'baking_general';
            document.getElementById('substitutionGoal').value = 'dietary';
            document.getElementById('flavorPreference').value = 'neutral';
            document.getElementById('textureImportance').value = 'critical';
            document.getElementById('availability').value = 'common';
            document.getElementById('experienceLevel').value = 'intermediate';
            
            // Uncheck all dietary restrictions
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => checkbox.checked = false);
            
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
            
            // Update unit based on ingredient type
            document.getElementById('ingredientToSubstitute').addEventListener('change', function() {
                const ingredient = this.value;
                const unit = getDefaultUnit(ingredient);
                document.getElementById('subUnit').textContent = unit;
            });
        });

        // Get default unit for ingredient
        function getDefaultUnit(ingredient) {
            const unitMap = {
                'butter': 'cup',
                'milk': 'cup',
                'eggs': 'large eggs',
                'sugar': 'cup',
                'flour': 'cup',
                'yeast': 'tsp',
                'baking_powder': 'tsp',
                'honey': 'cup',
                'chocolate': 'cup',
                'cream': 'cup',
                'buttermilk': 'cup',
                'oil': 'cup',
                'vanilla': 'tsp'
            };
            return unitMap[ingredient] || 'cup';
        }
    </script>
</body>
</html>
