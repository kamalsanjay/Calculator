<?php
/**
 * Tablespoon Converter
 * File: conversion/tablespoon-converter.php
 * Description: Convert between tablespoons and other volume units for cooking and baking
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablespoon Converter - Cooking Volume Unit Conversion Calculator</title>
    <meta name="description" content="Convert between tablespoons, teaspoons, cups, milliliters, and other cooking volume units. Essential for recipes, baking, and culinary applications.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #ff6b6b; box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; margin-top: 10px; }
        .unit-select:focus { outline: none; border-color: #ff6b6b; box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #ffeb3b 0%, #ff9800 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #ff6b6b; }
        .result-unit { color: #d84315; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #e65100; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #ff6b6b; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255, 107, 107, 0.15); }
        .quick-value { font-weight: bold; color: #ff6b6b; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .common-conversions { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .common-conversions h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        
        .measurement-guide { background: #fff3e0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff9800; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #ffeb3b; }
        
        .formula-box { background: #ffeb3b; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff6b6b; }
        .formula-box strong { color: #ff6b6b; }
        
        .cooking-tips { background: #e8f5e8; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #4caf50; }
        
        .regional-box { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #2196f3; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .measurement-highlight { background: #fff3e0; padding: 3px 6px; border-radius: 4px; font-weight: bold; }
        
        @media (max-width: 768px) {
            .converter-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .result-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🥄 Tablespoon Converter</h1>
            <p>Convert between tablespoons, teaspoons, cups, milliliters, and other cooking volume units. Essential for recipes, baking, and culinary applications.</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="tbsp" selected>US Tablespoon (tbsp)</option>
                        <option value="tsp">US Teaspoon (tsp)</option>
                        <option value="cup">US Cup (cup)</option>
                        <option value="floz">US Fluid Ounce (fl oz)</option>
                        <option value="pint">US Pint (pt)</option>
                        <option value="quart">US Quart (qt)</option>
                        <option value="gallon">US Gallon (gal)</option>
                        <option value="ml">Milliliter (mL)</option>
                        <option value="liter">Liter (L)</option>
                        <option value="tbsp_uk">UK Tablespoon (tbsp UK)</option>
                        <option value="tsp_uk">UK Teaspoon (tsp UK)</option>
                        <option value="cup_uk">UK Cup (cup UK)</option>
                        <option value="floz_uk">UK Fluid Ounce (fl oz UK)</option>
                        <option value="pinch">Pinch</option>
                        <option value="dash">Dash</option>
                        <option value="drop">Drop</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="tbsp">US Tablespoon (tbsp)</option>
                        <option value="tsp" selected>US Teaspoon (tsp)</option>
                        <option value="cup">US Cup (cup)</option>
                        <option value="floz">US Fluid Ounce (fl oz)</option>
                        <option value="pint">US Pint (pt)</option>
                        <option value="quart">US Quart (qt)</option>
                        <option value="gallon">US Gallon (gal)</option>
                        <option value="ml">Milliliter (mL)</option>
                        <option value="liter">Liter (L)</option>
                        <option value="tbsp_uk">UK Tablespoon (tbsp UK)</option>
                        <option value="tsp_uk">UK Teaspoon (tsp UK)</option>
                        <option value="cup_uk">UK Cup (cup UK)</option>
                        <option value="floz_uk">UK Fluid Ounce (fl oz UK)</option>
                        <option value="pinch">Pinch</option>
                        <option value="dash">Dash</option>
                        <option value="drop">Drop</option>
                    </select>
                    <div class="input-wrapper" style="margin-top: 10px;">
                        <input type="text" id="outputValue" placeholder="Result" readonly style="background: #f8f9fa; font-weight: 600; color: #2c3e50;">
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid"></div>

            <div class="quick-convert">
                <h3>⚡ Quick Conversions</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setInput(1)">
                        <div class="quick-value">1</div>
                        <div class="quick-label">Tablespoon</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(4)">
                        <div class="quick-value">¼ Cup</div>
                        <div class="quick-label">4 tbsp</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(8)">
                        <div class="quick-value">½ Cup</div>
                        <div class="quick-label">8 tbsp</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(16)">
                        <div class="quick-value">1 Cup</div>
                        <div class="quick-label">16 tbsp</div>
                    </div>
                </div>
            </div>

            <div class="common-conversions">
                <h3>🎯 Common Recipe Measurements</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setCommonMeasurement(3, 'Standard teaspoon equivalent')">
                        <div class="quick-value">3 tsp</div>
                        <div class="quick-label">= 1 tbsp</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonMeasurement(0.5, 'Common baking measurement')">
                        <div class="quick-value">½ tbsp</div>
                        <div class="quick-label">= 1.5 tsp</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonMeasurement(2, 'Two tablespoons')">
                        <div class="quick-value">2 tbsp</div>
                        <div class="quick-label">= ⅛ cup</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonMeasurement(14.79, 'Tablespoon to milliliters')">
                        <div class="quick-value">1 tbsp</div>
                        <div class="quick-label">= 14.79 mL</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🥄 Cooking Measurement Conversion</h2>
            
            <p>Convert between tablespoons and other cooking volume units used in recipes, baking, and culinary applications worldwide.</p>

            <div class="measurement-guide">
                <h3>📏 Standard US Cooking Measurements</h3>
                <p><strong>From smallest to largest:</strong> Pinch → Dash → Drop → Teaspoon → Tablespoon → Fluid Ounce → Cup → Pint → Quart → Gallon</p>
            </div>

            <h3>📊 Conversion Factors to US Tablespoons</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>US Tablespoons</th>
                        <th>Milliliters</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>US Tablespoon</td><td>tbsp</td><td>1</td><td>14.79 mL</td></tr>
                    <tr><td>US Teaspoon</td><td>tsp</td><td>0.3333</td><td>4.93 mL</td></tr>
                    <tr><td>US Cup</td><td>cup</td><td>16</td><td>236.59 mL</td></tr>
                    <tr><td>US Fluid Ounce</td><td>fl oz</td><td>2</td><td>29.57 mL</td></tr>
                    <tr><td>US Pint</td><td>pt</td><td>32</td><td>473.18 mL</td></tr>
                    <tr><td>US Quart</td><td>qt</td><td>64</td><td>946.35 mL</td></tr>
                    <tr><td>US Gallon</td><td>gal</td><td>256</td><td>3,785.41 mL</td></tr>
                    <tr><td>Milliliter</td><td>mL</td><td>0.06763</td><td>1 mL</td></tr>
                    <tr><td>Liter</td><td>L</td><td>67.628</td><td>1,000 mL</td></tr>
                    <tr><td>UK Tablespoon</td><td>tbsp UK</td><td>1.20095</td><td>17.76 mL</td></tr>
                    <tr><td>UK Teaspoon</td><td>tsp UK</td><td>0.40032</td><td>5.92 mL</td></tr>
                    <tr><td>UK Cup</td><td>cup UK</td><td>19.2152</td><td>284.13 mL</td></tr>
                    <tr><td>UK Fluid Ounce</td><td>fl oz UK</td><td>1.92152</td><td>28.41 mL</td></tr>
                    <tr><td>Pinch</td><td>pinch</td><td>0.0625</td><td>~0.92 mL</td></tr>
                    <tr><td>Dash</td><td>dash</td><td>0.125</td><td>~1.85 mL</td></tr>
                    <tr><td>Drop</td><td>drop</td><td>0.03333</td><td>~0.49 mL</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Conversion Formulas:</strong><br>
                • <strong>1 US Tablespoon</strong> = 3 US Teaspoons = ½ US Fluid Ounce<br>
                • <strong>1 US Cup</strong> = 16 Tablespoons = 48 Teaspoons = 8 Fluid Ounces<br>
                • <strong>1 US Pint</strong> = 2 Cups = 32 Tablespoons = 96 Teaspoons<br>
                • <strong>1 US Quart</strong> = 2 Pints = 4 Cups = 64 Tablespoons<br>
                • <strong>1 US Gallon</strong> = 4 Quarts = 8 Pints = 16 Cups = 256 Tablespoons<br>
                • <strong>1 Milliliter</strong> ≈ 0.06763 US Tablespoons<br>
                • <strong>1 Liter</strong> = 1,000 mL ≈ 67.628 US Tablespoons
            </div>

            <h3>🍳 Common Ingredient Measurements</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Ingredient</th>
                        <th>1 Tablespoon Weight</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Water</td><td>14.79 grams</td><td>Standard conversion</td></tr>
                    <tr><td>All-purpose flour</td><td>~7.81 grams</td><td>Spooned and leveled</td></tr>
                    <tr><td>Granulated sugar</td><td>~12.5 grams</td><td>Standard packing</td></tr>
                    <tr><td>Brown sugar</td><td>~13.8 grams</td><td>Packed firmly</td></tr>
                    <tr><td>Butter</td><td>14.2 grams</td><td>Standard stick markings</td></tr>
                    <tr><td>Oil (vegetable)</td><td>~13.6 grams</td><td>Varies by type</td></tr>
                    <tr><td>Honey</td><td>~21 grams</td><td>Thick liquid</td></tr>
                    <tr><td>Milk</td><td>~15.2 grams</td><td>Whole milk</td></tr>
                    <tr><td>Salt (table)</td><td>~18 grams</td><td>Fine grain</td></tr>
                    <tr><td>Baking powder</td><td>~13 grams</td><td>Standard measurement</td></tr>
                </tbody>
            </table>

            <div class="cooking-tips">
                <strong>👨‍🍳 Cooking Tips & Techniques:</strong><br>
                • <span class="measurement-highlight">Measuring dry ingredients:</span> Spoon into measuring spoon, level with straight edge<br>
                • <span class="measurement-highlight">Measuring liquids:</span> Use liquid measuring cups, check at eye level<br>
                • <span class="measurement-highlight">Butter measurements:</span> 1 tbsp = ½ oz = ⅛ stick of butter<br>
                • <span class="measurement-highlight">Baking precision:</span> Use weight measurements for accuracy in baking<br>
                • <span class="measurement-highlight">Conversion tip:</span> 16 tbsp = 1 cup = 8 oz = ½ pint = ¼ quart
            </div>

            <h3>🌍 International Differences</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Country/System</th>
                        <th>Tablespoon Size</th>
                        <th>Teaspoon Size</th>
                        <th>Cup Size</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>United States</td><td>14.79 mL</td><td>4.93 mL</td><td>236.59 mL</td></tr>
                    <tr><td>United Kingdom</td><td>17.76 mL</td><td>5.92 mL</td><td>284.13 mL</td></tr>
                    <tr><td>Australia</td><td>20 mL</td><td>5 mL</td><td>250 mL</td></tr>
                    <tr><td>Canada</td><td>14.79 mL</td><td>4.93 mL</td><td>250 mL*</td></tr>
                    <tr><td>Japan</td><td>15 mL</td><td>5 mL</td><td>200 mL</td></tr>
                    <tr><td>Metric System</td><td>15 mL</td><td>5 mL</td><td>250 mL</td></tr>
                </tbody>
            </table>
            <p style="font-size: 0.9rem; color: #777;">* Canada uses US measurements but often references metric equivalents</p>

            <div class="regional-box">
                <strong>🌎 Regional Measurement Notes:</strong><br>
                • <span class="measurement-highlight">US & Canada:</span> 1 tbsp = 3 tsp = 14.79 mL<br>
                • <span class="measurement-highlight">UK & Commonwealth:</span> 1 tbsp = 4 tsp = 17.76 mL<br>
                • <span class="measurement-highlight">Australia:</span> 1 tbsp = 4 tsp = 20 mL (metric tablespoon)<br>
                • <span class="measurement-highlight">Medical measurements:</span> 1 tbsp = 15 mL exactly (for medication)<br>
                • <span class="measurement-highlight">Nutrition labels:</span> Often use 15 mL for tablespoon conversion
            </div>

            <h3>📐 Measurement Equivalents Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Tablespoons</th>
                        <th>Teaspoons</th>
                        <th>Cups</th>
                        <th>Fluid Ounces</th>
                        <th>Milliliters</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 tbsp</td><td>3 tsp</td><td>1/16 cup</td><td>0.5 fl oz</td><td>14.79 mL</td></tr>
                    <tr><td>2 tbsp</td><td>6 tsp</td><td>⅛ cup</td><td>1 fl oz</td><td>29.57 mL</td></tr>
                    <tr><td>4 tbsp</td><td>12 tsp</td><td>¼ cup</td><td>2 fl oz</td><td>59.15 mL</td></tr>
                    <tr><td>8 tbsp</td><td>24 tsp</td><td>½ cup</td><td>4 fl oz</td><td>118.29 mL</td></tr>
                    <tr><td>12 tbsp</td><td>36 tsp</td><td>¾ cup</td><td>6 fl oz</td><td>177.44 mL</td></tr>
                    <tr><td>16 tbsp</td><td>48 tsp</td><td>1 cup</td><td>8 fl oz</td><td>236.59 mL</td></tr>
                    <tr><td>32 tbsp</td><td>96 tsp</td><td>2 cups</td><td>16 fl oz</td><td>473.18 mL</td></tr>
                </tbody>
            </table>

            <h3>🥣 Common Recipe Conversions</h3>
            <ul>
                <li><strong>¼ cup</strong> = 4 tablespoons = 12 teaspoons</li>
                <li><strong>⅓ cup</strong> = 5 tablespoons + 1 teaspoon</li>
                <li><strong>½ cup</strong> = 8 tablespoons = 24 teaspoons</li>
                <li><strong>⅔ cup</strong> = 10 tablespoons + 2 teaspoons</li>
                <li><strong>¾ cup</strong> = 12 tablespoons = 36 teaspoons</li>
                <li><strong>1 cup</strong> = 16 tablespoons = 48 teaspoons</li>
                <li><strong>1 stick of butter</strong> = 8 tablespoons = ½ cup</li>
                <li><strong>1 ounce</strong> = 2 tablespoons (fluid)</li>
            </ul>

            <h3>🔢 Approximate Measurements</h3>
            <div class="formula-box">
                <strong>Informal Cooking Measurements:</strong><br>
                • <span class="measurement-highlight">Pinch:</span> ⅛ teaspoon or amount between thumb and forefinger<br>
                • <span class="measurement-highlight">Dash:</span> ⅛ teaspoon (liquid) or ⅛ teaspoon (dry)<br>
                • <span class="measurement-highlight">Drop:</span> ⅛ teaspoon (approx.) from dropper<br>
                • <span class="measurement-highlight">Smidgen:</span> ½ pinch or 1/32 teaspoon<br>
                • <span class="measurement-highlight">Heaping spoonful:</span> As much as the spoon can hold<br>
                • <span class="measurement-highlight">Rounded spoonful:</span> Slightly mounded above spoon rim<br>
                • <span class="measurement-highlight">Level spoonful:</span> Level with spoon rim
            </div>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>Easy-to-Remember Conversions:</strong><br>
                • <strong>Tablespoons to Cups:</strong> Divide tablespoons by 16 (tbsp ÷ 16 = cups)<br>
                • <strong>Cups to Tablespoons:</strong> Multiply cups by 16 (cups × 16 = tbsp)<br>
                • <strong>Tablespoons to Teaspoons:</strong> Multiply by 3 (tbsp × 3 = tsp)<br>
                • <strong>Teaspoons to Tablespoons:</strong> Divide by 3 (tsp ÷ 3 = tbsp)<br>
                • <strong>Tablespoons to Milliliters:</strong> Multiply by 15 for quick estimate (tbsp × 15 ≈ mL)<br>
                • <strong>Milliliters to Tablespoons:</strong> Divide by 15 for quick estimate (mL ÷ 15 ≈ tbsp)
            </div>

            <h3>⚖️ Historical Context</h3>
            <p>The <strong>tablespoon</strong> originated as a unit of volume based on actual eating utensils. In medieval Europe, spoons were common eating tools, and their sizes varied regionally. The standardization of tablespoon measurements began in the 19th century with the development of formal cooking measurements. The <strong>US customary system</strong> standardized the tablespoon at ½ fluid ounce (14.79 mL), while the <strong>British imperial system</strong> settled on ⅞ fluid ounce (17.76 mL). The <strong>metric tablespoon</strong> (15 mL) was introduced for international standardization.</p>

            <h3>🥄 Measurement Tools</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Tool</th>
                        <th>Typical Measurements</th>
                        <th>Accuracy</th>
                        <th>Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Measuring spoons</td><td>¼ tsp to 1 tbsp</td><td>High</td><td>Small dry/liquid ingredients</td></tr>
                    <tr><td>Liquid measuring cups</td><td>1 tsp to 4 cups</td><td>Medium</td><td>Liquids only</td></tr>
                    <tr><td>Dry measuring cups</td><td>¼ cup to 2 cups</td><td>Medium</td><td>Dry ingredients</td></tr>
                    <tr><td>Kitchen scale</td><td>Grams, ounces</td><td>Very high</td><td>Baking, precision work</td></tr>
                    <tr><td>Graduated cylinders</td><td>mL measurements</td><td>Very high</td><td>Scientific, medical use</td></tr>
                </tbody>
            </table>

            <h3>🎯 Key Conversions to Remember</h3>
            <ul>
                <li><strong>1 US Tablespoon = 3 US Teaspoons = 14.79 mL</strong></li>
                <li><strong>1 US Cup = 16 Tablespoons = 236.59 mL</strong></li>
                <li><strong>1 US Fluid Ounce = 2 Tablespoons = 29.57 mL</strong></li>
                <li><strong>1 UK Tablespoon = 1.20095 US Tablespoons = 17.76 mL</strong></li>
                <li><strong>1 Australian Tablespoon = 1.35256 US Tablespoons = 20 mL</strong></li>
                <li><strong>1 Liter = 67.628 US Tablespoons = 1,000 mL</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>🥄 Tablespoon Converter | Complete Cooking Measurement Conversion</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert tablespoons, teaspoons, cups, milliliters, and other cooking volume units with precision</p>
        </div>
    </div>

    <script>
        // Conversion factors to US tablespoons
        const toUSTablespoons = {
            tbsp: 1,
            tsp: 1/3,
            cup: 16,
            floz: 2,
            pint: 32,
            quart: 64,
            gallon: 256,
            ml: 0.067628,
            liter: 67.628,
            tbsp_uk: 0.832674,
            tsp_uk: 0.277558,
            cup_uk: 13.3228,
            floz_uk: 1.66535,
            pinch: 16,
            dash: 8,
            drop: 30
        };

        const unitNames = {
            tbsp: 'US Tablespoon (tbsp)',
            tsp: 'US Teaspoon (tsp)',
            cup: 'US Cup (cup)',
            floz: 'US Fluid Ounce (fl oz)',
            pint: 'US Pint (pt)',
            quart: 'US Quart (qt)',
            gallon: 'US Gallon (gal)',
            ml: 'Milliliter (mL)',
            liter: 'Liter (L)',
            tbsp_uk: 'UK Tablespoon (tbsp UK)',
            tsp_uk: 'UK Teaspoon (tsp UK)',
            cup_uk: 'UK Cup (cup UK)',
            floz_uk: 'UK Fluid Ounce (fl oz UK)',
            pinch: 'Pinch',
            dash: 'Dash',
            drop: 'Drop'
        };

        function convert() {
            const inputValue = parseFloat(document.getElementById('inputValue').value);
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;

            if (isNaN(inputValue)) {
                document.getElementById('outputValue').value = '';
                document.getElementById('resultGrid').innerHTML = '';
                return;
            }

            // Convert to US tablespoons first
            const valueInTbsp = inputValue * toUSTablespoons[fromUnit];
            
            // Convert to target unit
            const result = valueInTbsp / toUSTablespoons[toUnit];
            
            document.getElementById('outputValue').value = formatNumber(result);
            
            displayAllConversions(valueInTbsp);
        }

        function displayAllConversions(valueInTbsp) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInTbsp / toUSTablespoons[unit];
                
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div class="result-unit">${name}</div>
                    <div class="result-value">${formatNumber(converted)}</div>
                `;
                resultGrid.appendChild(card);
            }
        }

        function formatNumber(num) {
            if (Math.abs(num) < 0.0001 || Math.abs(num) > 1e6) {
                return num.toExponential(4);
            }
            if (Math.abs(num) < 0.01) {
                return num.toFixed(6);
            }
            if (Math.abs(num) < 1) {
                return num.toFixed(4);
            }
            return num.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            });
        }

        function swapUnits() {
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;
            
            document.getElementById('fromUnit').value = toUnit;
            document.getElementById('toUnit').value = fromUnit;
            
            convert();
        }

        function setInput(value) {
            document.getElementById('inputValue').value = value;
            convert();
        }

        function setCommonMeasurement(value, description) {
            document.getElementById('inputValue').value = value;
            document.getElementById('fromUnit').value = 'tbsp';
            document.getElementById('toUnit').value = 'tsp';
            convert();
            console.log(description);
        }

        // Auto-convert on input
        document.getElementById('inputValue').addEventListener('input', convert);
        document.getElementById('fromUnit').addEventListener('change', convert);
        document.getElementById('toUnit').addEventListener('change', convert);

        // Initial conversion
        convert();
    </script>
</body>
</html>