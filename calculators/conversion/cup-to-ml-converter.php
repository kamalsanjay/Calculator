<?php
/**
 * Cup to ML Converter
 * File: conversion/cup-to-ml-converter.php
 * Description: Convert cups to milliliters for cooking and baking
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cup to ML Converter - Cooking Measurement Calculator</title>
    <meta name="description" content="Convert cups to milliliters (mL) for cooking and baking. Supports US cups, metric cups, and imperial cups with accurate conversions.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 950px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .cup-type-selector { display: flex; gap: 10px; margin-bottom: 25px; padding: 15px; background: #f8f9fa; border-radius: 10px; }
        .cup-type-btn { flex: 1; padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; font-weight: 600; }
        .cup-type-btn.active { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-color: #f5576c; }
        .cup-type-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(245, 87, 108, 0.2); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 70px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #f5576c; box-shadow: 0 0 0 3px rgba(245, 87, 108, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #f5576c; font-weight: 600; font-size: 0.95rem; }
        
        .swap-btn { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-box { background: linear-gradient(135deg, #fff5f7 0%, #ffe9ed 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #f5576c; margin-bottom: 25px; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.5rem; font-weight: bold; color: #f5576c; margin-bottom: 10px; }
        .result-formula { background: white; padding: 15px; border-radius: 8px; font-family: 'Courier New', monospace; color: #555; font-size: 0.9rem; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #f5576c; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(245, 87, 108, 0.15); }
        .quick-value { font-weight: bold; color: #f5576c; font-size: 1.1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #fff5f7; }
        
        .formula-box { background: #fff5f7; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #f5576c; }
        .formula-box strong { color: #f5576c; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .converter-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .header h1 { font-size: 1.5rem; }
            .result-value { font-size: 2rem; }
            .cup-type-selector { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>☕ Cup to ML Converter</h1>
            <p>Convert cups to milliliters for accurate cooking and baking measurements</p>
        </div>

        <div class="converter-card">
            <div class="cup-type-selector">
                <button class="cup-type-btn active" onclick="selectCupType('us', this)">
                    US Cup<br><span style="font-size: 0.8rem; font-weight: 400;">236.59 mL</span>
                </button>
                <button class="cup-type-btn" onclick="selectCupType('metric', this)">
                    Metric Cup<br><span style="font-size: 0.8rem; font-weight: 400;">250 mL</span>
                </button>
                <button class="cup-type-btn" onclick="selectCupType('imperial', this)">
                    Imperial Cup<br><span style="font-size: 0.8rem; font-weight: 400;">284.13 mL</span>
                </button>
            </div>

            <div class="converter-row">
                <div class="input-group">
                    <label for="cupsInput">Cups</label>
                    <div class="input-wrapper">
                        <input type="number" id="cupsInput" placeholder="Enter cups" step="0.125" min="0" value="1">
                        <span class="unit-label">cups</span>
                    </div>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="mlInput">Milliliters (mL)</label>
                    <div class="input-wrapper">
                        <input type="number" id="mlInput" placeholder="Enter mL" step="1" min="0">
                        <span class="unit-label">mL</span>
                    </div>
                </div>
            </div>

            <div class="result-box">
                <div class="result-label">Result</div>
                <div class="result-value" id="resultValue">1 cup = 236.59 mL</div>
                <div class="result-formula" id="resultFormula">1 US cup × 236.59 = 236.59 mL</div>
            </div>

            <div class="quick-convert">
                <h3>⚡ Common Measurements</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setCups(0.25)">
                        <div class="quick-value">1/4</div>
                        <div class="quick-label">Quarter Cup</div>
                    </div>
                    <div class="quick-btn" onclick="setCups(0.5)">
                        <div class="quick-value">1/2</div>
                        <div class="quick-label">Half Cup</div>
                    </div>
                    <div class="quick-btn" onclick="setCups(0.75)">
                        <div class="quick-value">3/4</div>
                        <div class="quick-label">Three Quarters</div>
                    </div>
                    <div class="quick-btn" onclick="setCups(1)">
                        <div class="quick-value">1</div>
                        <div class="quick-label">One Cup</div>
                    </div>
                    <div class="quick-btn" onclick="setCups(1.5)">
                        <div class="quick-value">1.5</div>
                        <div class="quick-label">One & Half</div>
                    </div>
                    <div class="quick-btn" onclick="setCups(2)">
                        <div class="quick-value">2</div>
                        <div class="quick-label">Two Cups</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>☕ Understanding Cup to ML Conversion</h2>
            
            <p>A <strong>cup</strong> is a common cooking measurement, but its exact volume varies by region. The <strong>milliliter (mL)</strong> is a metric unit that provides precise measurements. Understanding the differences is crucial for accurate recipe conversions.</p>

            <h3>🌍 Types of Cups</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Cup Type</th>
                        <th>Volume (mL)</th>
                        <th>Used In</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>US Cup (Legal)</strong></td>
                        <td>236.59 mL</td>
                        <td>United States, most American recipes</td>
                    </tr>
                    <tr>
                        <td><strong>Metric Cup</strong></td>
                        <td>250 mL</td>
                        <td>Australia, New Zealand, Canada, international recipes</td>
                    </tr>
                    <tr>
                        <td><strong>Imperial Cup</strong></td>
                        <td>284.13 mL</td>
                        <td>United Kingdom, older British recipes</td>
                    </tr>
                </tbody>
            </table>

            <h3>📊 US Cup Conversion Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Cups</th>
                        <th>Milliliters (mL)</th>
                        <th>Common Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1/8 cup</td><td>29.57 mL</td><td>Small pinch, 2 tablespoons</td></tr>
                    <tr><td>1/4 cup</td><td>59.15 mL</td><td>4 tablespoons</td></tr>
                    <tr><td>1/3 cup</td><td>78.86 mL</td><td>5 tablespoons + 1 teaspoon</td></tr>
                    <tr><td>1/2 cup</td><td>118.29 mL</td><td>8 tablespoons, 1 stick butter</td></tr>
                    <tr><td>2/3 cup</td><td>157.73 mL</td><td>10 tablespoons + 2 teaspoons</td></tr>
                    <tr><td>3/4 cup</td><td>177.44 mL</td><td>12 tablespoons</td></tr>
                    <tr><td>1 cup</td><td>236.59 mL</td><td>16 tablespoons, 8 fl oz</td></tr>
                    <tr><td>2 cups</td><td>473.18 mL</td><td>1 pint, 16 fl oz</td></tr>
                    <tr><td>4 cups</td><td>946.35 mL</td><td>1 quart, 32 fl oz</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>US Cup:</strong> mL = cups × 236.59<br>
                <strong>Metric Cup:</strong> mL = cups × 250<br>
                <strong>Imperial Cup:</strong> mL = cups × 284.13
            </div>

            <h3>🥄 Related Measurements</h3>
            <ul>
                <li><strong>1 tablespoon (tbsp):</strong> 14.79 mL (US), 15 mL (metric)</li>
                <li><strong>1 teaspoon (tsp):</strong> 4.93 mL (US), 5 mL (metric)</li>
                <li><strong>1 fluid ounce (fl oz):</strong> 29.57 mL (US), 28.41 mL (UK)</li>
                <li><strong>1 pint:</strong> 473.18 mL (US), 568.26 mL (UK)</li>
                <li><strong>1 quart:</strong> 946.35 mL (US), 1,136.52 mL (UK)</li>
                <li><strong>1 gallon:</strong> 3,785.41 mL (US), 4,546.09 mL (UK)</li>
            </ul>

            <h3>👨‍🍳 Cooking Tips</h3>
            <ul>
                <li><strong>Liquid ingredients:</strong> Measure in a clear measuring cup at eye level</li>
                <li><strong>Dry ingredients:</strong> Spoon into cup and level off (don't pack unless specified)</li>
                <li><strong>Flour:</strong> 1 cup flour ≈ 120-130g (varies by measurement method)</li>
                <li><strong>Sugar:</strong> 1 cup granulated sugar ≈ 200g</li>
                <li><strong>Water:</strong> 1 cup water = exactly 236.59 mL = 236.59g</li>
                <li><strong>Recipe origin:</strong> Check if recipe is US, UK, or metric to use correct cup size</li>
            </ul>

            <h3>🍰 Baking Conversions</h3>
            <div class="formula-box">
                <strong>Common Baking Ingredients:</strong><br>
                • 1 cup all-purpose flour = 120-125g<br>
                • 1 cup granulated sugar = 200g<br>
                • 1 cup brown sugar (packed) = 220g<br>
                • 1 cup butter = 227g (2 sticks)<br>
                • 1 cup milk = 240g<br>
                • 1 cup water = 236.59g<br>
                • 1 cup oil = 218g
            </div>

            <h3>🌎 International Recipe Conversion</h3>
            <ul>
                <li><strong>US to Metric:</strong> Multiply US cups by 236.59 for mL</li>
                <li><strong>Australian to US:</strong> Multiply Australian cups by 1.056 for US cups</li>
                <li><strong>UK to US:</strong> Multiply UK cups by 1.2 for US cups</li>
                <li><strong>Pro tip:</strong> When precision matters (baking), use weight measurements (grams) instead of volume</li>
            </ul>

            <h3>📏 Measuring Cup Sizes</h3>
            <ul>
                <li><strong>Standard set:</strong> 1 cup, 1/2 cup, 1/3 cup, 1/4 cup</li>
                <li><strong>Liquid measuring cups:</strong> Have pour spout, usually 1, 2, or 4 cup capacity</li>
                <li><strong>Dry measuring cups:</strong> Flat top for leveling, nested set</li>
                <li><strong>Adjustable measuring cups:</strong> Sliding mechanism for various amounts</li>
            </ul>

            <h3>💡 Kitchen Measurement Tips</h3>
            <ul>
                <li>Always use the measurement system specified in the recipe</li>
                <li>For baking, weigh ingredients when possible (more accurate)</li>
                <li>Level off dry ingredients with a straight edge</li>
                <li>Don't pack dry ingredients unless recipe says to (brown sugar exception)</li>
                <li>Read measurements at eye level for liquids</li>
                <li>Use proper measuring tools (not drinking glasses)</li>
            </ul>

            <h3>🎯 Quick Reference</h3>
            <div class="formula-box">
                <strong>Remember:</strong><br>
                • 1 US cup ≈ 237 mL (rounded)<br>
                • 1 metric cup = 250 mL (exact)<br>
                • 1 cup = 16 tablespoons<br>
                • 1 cup = 48 teaspoons<br>
                • 1 cup = 8 fluid ounces (US)
            </div>
        </div>

        <div class="footer">
            <p>☕ Accurate Cup to ML Conversion | Cooking & Baking Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect measurements for recipes from around the world</p>
        </div>
    </div>

    <script>
        let currentCupType = 'us';
        const cupSizes = {
            us: 236.59,
            metric: 250,
            imperial: 284.13
        };

        const cupNames = {
            us: 'US cup',
            metric: 'Metric cup',
            imperial: 'Imperial cup'
        };

        function selectCupType(type, btn) {
            currentCupType = type;
            document.querySelectorAll('.cup-type-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            convertCups();
        }

        function convertCups() {
            const cups = parseFloat(document.getElementById('cupsInput').value);
            
            if (isNaN(cups) || cups < 0) {
                return;
            }

            const mL = cups * cupSizes[currentCupType];
            document.getElementById('mlInput').value = mL.toFixed(2);
            
            updateResult(cups, mL);
        }

        function convertML() {
            const mL = parseFloat(document.getElementById('mlInput').value);
            
            if (isNaN(mL) || mL < 0) {
                return;
            }

            const cups = mL / cupSizes[currentCupType];
            document.getElementById('cupsInput').value = cups.toFixed(4);
            
            updateResult(cups, mL);
        }

        function updateResult(cups, mL) {
            const cupName = cupNames[currentCupType];
            const factor = cupSizes[currentCupType];
            
            document.getElementById('resultValue').textContent = 
                `${cups.toFixed(4)} cup${cups !== 1 ? 's' : ''} = ${mL.toFixed(2)} mL`;
            
            document.getElementById('resultFormula').textContent = 
                `${cups.toFixed(4)} ${cupName}${cups !== 1 ? 's' : ''} × ${factor} = ${mL.toFixed(2)} mL`;
        }

        function swapUnits() {
            const cupsValue = document.getElementById('cupsInput').value;
            const mlValue = document.getElementById('mlInput').value;
            
            document.getElementById('cupsInput').value = mlValue ? (mlValue / cupSizes[currentCupType]).toFixed(4) : '';
            document.getElementById('mlInput').value = cupsValue ? (cupsValue * cupSizes[currentCupType]).toFixed(2) : '';
            
            if (cupsValue) convertCups();
        }

        function setCups(value) {
            document.getElementById('cupsInput').value = value;
            convertCups();
        }

        // Auto-convert on input
        document.getElementById('cupsInput').addEventListener('input', convertCups);
        document.getElementById('mlInput').addEventListener('input', convertML);

        // Initial conversion
        convertCups();
    </script>
</body>
</html>