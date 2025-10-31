<?php
/**
 * Grams to Ounces Converter
 * File: conversion/grams-to-ounces-converter.php
 * Description: Convert grams to ounces and vice versa
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grams to Ounces Converter - g to oz Calculator</title>
    <meta name="description" content="Convert grams (g) to ounces (oz) and oz to g instantly. Bidirectional weight converter for cooking, jewelry, and everyday measurements.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 950px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 70px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #fa709a; box-shadow: 0 0 0 3px rgba(250, 112, 154, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #fa709a; font-weight: 600; font-size: 0.95rem; }
        
        .swap-btn { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-box { background: linear-gradient(135deg, #ffebef 0%, #fff9e6 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #fa709a; margin-bottom: 25px; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.5rem; font-weight: bold; color: #fa709a; margin-bottom: 10px; }
        .result-formula { background: white; padding: 15px; border-radius: 8px; font-family: 'Courier New', monospace; color: #555; font-size: 0.9rem; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #fa709a; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(250, 112, 154, 0.15); }
        .quick-value { font-weight: bold; color: #fa709a; font-size: 1.1rem; }
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
        .conversion-table tr:hover { background: #ffebef; }
        
        .formula-box { background: #ffebef; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #fa709a; }
        .formula-box strong { color: #fa709a; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .converter-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .header h1 { font-size: 1.5rem; }
            .result-value { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚖️ Grams ⇄ Ounces Converter</h1>
            <p>Convert between grams and ounces with bidirectional conversion for cooking, jewelry, and everyday measurements</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="gramsInput">Grams</label>
                    <div class="input-wrapper">
                        <input type="number" id="gramsInput" placeholder="Enter grams" step="0.01" min="0" value="100">
                        <span class="unit-label">g</span>
                    </div>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="ouncesInput">Ounces</label>
                    <div class="input-wrapper">
                        <input type="number" id="ouncesInput" placeholder="Enter ounces" step="0.001" min="0">
                        <span class="unit-label">oz</span>
                    </div>
                </div>
            </div>

            <div class="result-box">
                <div class="result-label">Result</div>
                <div class="result-value" id="resultValue">100 g = 3.527 oz</div>
                <div class="result-formula" id="resultFormula">100 g ÷ 28.3495 = 3.527 oz</div>
            </div>

            <div class="quick-convert">
                <h3>⚡ Common Weights</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setGrams(50)">
                        <div class="quick-value">50 g</div>
                        <div class="quick-label">Small Portion</div>
                    </div>
                    <div class="quick-btn" onclick="setGrams(100)">
                        <div class="quick-value">100 g</div>
                        <div class="quick-label">Serving Size</div>
                    </div>
                    <div class="quick-btn" onclick="setGrams(250)">
                        <div class="quick-value">250 g</div>
                        <div class="quick-label">Cup of Water</div>
                    </div>
                    <div class="quick-btn" onclick="setGrams(454)">
                        <div class="quick-value">454 g</div>
                        <div class="quick-label">1 Pound</div>
                    </div>
                    <div class="quick-btn" onclick="setGrams(1000)">
                        <div class="quick-value">1000 g</div>
                        <div class="quick-label">1 Kilogram</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⚖️ Grams to Ounces Conversion Guide</h2>
            
            <p>A <strong>gram (g)</strong> is a metric unit of weight, while an <strong>ounce (oz)</strong> is an imperial unit commonly used in the United States.</p>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>Grams to Ounces:</strong><br>
                • Ounces = Grams ÷ 28.3495<br>
                • 1 gram = 0.035274 ounces<br><br>
                <strong>Ounces to Grams:</strong><br>
                • Grams = Ounces × 28.3495<br>
                • 1 ounce = 28.3495 grams
            </div>

            <h3>📏 Grams to Ounces Conversion Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Grams (g)</th>
                        <th>Ounces (oz)</th>
                        <th>Common Item</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 g</td><td>0.035 oz</td><td>Paper clip</td></tr>
                    <tr><td>5 g</td><td>0.176 oz</td><td>Teaspoon of sugar</td></tr>
                    <tr><td>10 g</td><td>0.353 oz</td><td>Two nickels</td></tr>
                    <tr><td>28.35 g</td><td>1 oz</td><td>One ounce (exact)</td></tr>
                    <tr><td>50 g</td><td>1.764 oz</td><td>Golf ball</td></tr>
                    <tr><td>100 g</td><td>3.527 oz</td><td>Small bar of soap</td></tr>
                    <tr><td>250 g</td><td>8.818 oz</td><td>Cup of water</td></tr>
                    <tr><td>454 g</td><td>16 oz</td><td>1 pound</td></tr>
                    <tr><td>1000 g</td><td>35.274 oz</td><td>1 kilogram</td></tr>
                </tbody>
            </table>

            <h3>🍳 Cooking Measurements</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Ingredient</th>
                        <th>Grams</th>
                        <th>Ounces</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Flour (1 cup)</td><td>120-130 g</td><td>4.2-4.6 oz</td></tr>
                    <tr><td>Sugar (1 cup)</td><td>200 g</td><td>7.1 oz</td></tr>
                    <tr><td>Butter (1 stick)</td><td>113 g</td><td>4 oz</td></tr>
                    <tr><td>Water (1 cup)</td><td>237 g</td><td>8.4 oz</td></tr>
                    <tr><td>Rice (1 cup uncooked)</td><td>185 g</td><td>6.5 oz</td></tr>
                    <tr><td>Honey (1 tablespoon)</td><td>21 g</td><td>0.75 oz</td></tr>
                    <tr><td>Olive oil (1 tablespoon)</td><td>14 g</td><td>0.5 oz</td></tr>
                </tbody>
            </table>

            <h3>💍 Precious Metals & Jewelry</h3>
            <ul>
                <li><strong>Troy ounce:</strong> 31.1035 grams (used for gold, silver)</li>
                <li><strong>Regular ounce:</strong> 28.3495 grams (avoirdupois)</li>
                <li><strong>Gold ring:</strong> Typically 2-10 grams</li>
                <li><strong>Gold chain:</strong> Usually 5-30 grams</li>
                <li><strong>Silver coin (1 oz):</strong> 31.1 grams (troy)</li>
            </ul>

            <div class="formula-box">
                <strong>Important Note:</strong><br>
                • <strong>Avoirdupois ounce:</strong> 28.3495 g (food, everyday items)<br>
                • <strong>Troy ounce:</strong> 31.1035 g (precious metals only)<br>
                • This converter uses avoirdupois ounces (standard)
            </div>

            <h3>📦 Shipping & Postal Weights</h3>
            <ul>
                <li><strong>Letter (standard):</strong> Up to 30 g (~1 oz)</li>
                <li><strong>Large envelope:</strong> Up to 500 g (~17.6 oz)</li>
                <li><strong>Small package:</strong> Up to 1 kg (~35.3 oz)</li>
                <li><strong>Medium package:</strong> 1-5 kg (35-176 oz)</li>
            </ul>

            <h3>🏋️ Fitness & Nutrition</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Food Item</th>
                        <th>Typical Serving</th>
                        <th>Weight</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Chicken breast</td><td>1 piece</td><td>170 g (6 oz)</td></tr>
                    <tr><td>Steak</td><td>1 portion</td><td>225 g (8 oz)</td></tr>
                    <tr><td>Fish fillet</td><td>1 serving</td><td>140 g (5 oz)</td></tr>
                    <tr><td>Pasta (cooked)</td><td>1 serving</td><td>140 g (5 oz)</td></tr>
                    <tr><td>Cheese slice</td><td>1 slice</td><td>28 g (1 oz)</td></tr>
                    <tr><td>Protein powder</td><td>1 scoop</td><td>30 g (1.06 oz)</td></tr>
                </tbody>
            </table>

            <h3>🥤 Beverage Weights</h3>
            <ul>
                <li><strong>Water:</strong> 1 ml = 1 g, so 250 ml = 250 g (~8.8 oz)</li>
                <li><strong>Milk:</strong> 1 cup = ~244 g (~8.6 oz)</li>
                <li><strong>Coffee (brewed):</strong> 1 cup = ~237 g (~8.4 oz)</li>
                <li><strong>Soda can:</strong> 355 ml = ~355 g (~12.5 oz)</li>
            </ul>

            <h3>🍞 Baking Conversions</h3>
            <div class="formula-box">
                <strong>Common Baking Ingredients:</strong><br>
                • All-purpose flour: 1 cup = 125 g (4.4 oz)<br>
                • White sugar: 1 cup = 200 g (7.1 oz)<br>
                • Brown sugar (packed): 1 cup = 220 g (7.8 oz)<br>
                • Powdered sugar: 1 cup = 120 g (4.2 oz)<br>
                • Butter: 1 cup = 227 g (8 oz)<br>
                • Cocoa powder: 1 cup = 100 g (3.5 oz)
            </div>

            <h3>💊 Medical & Pharmaceutical</h3>
            <ul>
                <li><strong>Typical pill:</strong> 100-500 mg (0.1-0.5 g)</li>
                <li><strong>Vitamin tablet:</strong> 500 mg - 1 g</li>
                <li><strong>Liquid medicine:</strong> Often dosed in ml (1 ml water ≈ 1 g)</li>
                <li><strong>Body weight:</strong> Usually measured in kg (1 kg = 1,000 g)</li>
            </ul>

            <h3>📱 Electronic Devices</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Device</th>
                        <th>Grams</th>
                        <th>Ounces</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Smartphone</td><td>150-250 g</td><td>5.3-8.8 oz</td></tr>
                    <tr><td>Tablet</td><td>300-700 g</td><td>10.6-24.7 oz</td></tr>
                    <tr><td>Laptop</td><td>1000-3000 g</td><td>35-106 oz</td></tr>
                    <tr><td>Smartwatch</td><td>30-50 g</td><td>1.1-1.8 oz</td></tr>
                    <tr><td>Wireless earbuds</td><td>4-8 g each</td><td>0.14-0.28 oz</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>Simple Approximation:</strong><br>
                • Divide grams by 30 for rough ounces<br>
                • Example: 150 g ÷ 30 ≈ 5 oz<br>
                • Actual: 150 g = 5.29 oz (close!)<br><br>
                <strong>Reverse Approximation:</strong><br>
                • Multiply ounces by 30 for rough grams<br>
                • Example: 4 oz × 30 = 120 g<br>
                • Actual: 4 oz = 113.4 g (close enough!)
            </div>

            <h3>🌍 Metric vs Imperial</h3>
            <ul>
                <li><strong>Metric countries:</strong> Use grams exclusively</li>
                <li><strong>United States:</strong> Primarily uses ounces</li>
                <li><strong>United Kingdom:</strong> Mix of both systems</li>
                <li><strong>Science/Medicine:</strong> Universal use of grams</li>
            </ul>

            <h3>📐 Weight Hierarchy</h3>
            <div class="formula-box">
                <strong>Metric System:</strong><br>
                1 milligram (mg) = 0.001 grams<br>
                1 gram (g) = 1 gram<br>
                1 kilogram (kg) = 1,000 grams<br>
                1 metric ton = 1,000,000 grams<br><br>
                <strong>Imperial System:</strong><br>
                1 ounce (oz) = 28.3495 grams<br>
                1 pound (lb) = 16 oz = 453.592 grams<br>
                1 stone = 14 lb = 6,350 grams<br>
                1 ton (US) = 2,000 lb = 907,185 grams
            </div>

            <h3>🎯 Practical Examples</h3>
            <ul>
                <li><strong>Standard letter:</strong> 4-5 g (~0.14-0.18 oz)</li>
                <li><strong>Credit card:</strong> 5 g (~0.18 oz)</li>
                <li><strong>AA battery:</strong> 23 g (~0.81 oz)</li>
                <li><strong>Tennis ball:</strong> 58 g (~2.05 oz)</li>
                <li><strong>Baseball:</strong> 145 g (~5.1 oz)</li>
                <li><strong>Apple (medium):</strong> 182 g (~6.4 oz)</li>
                <li><strong>Banana:</strong> 118 g (~4.2 oz)</li>
            </ul>

            <h3>🥗 Diet & Portion Control</h3>
            <div class="formula-box">
                <strong>Recommended Daily Protein:</strong><br>
                • 50-100 grams (1.8-3.5 oz) for average adult<br>
                • Athletes: 100-200 grams (3.5-7 oz)<br><br>
                <strong>Food Labels:</strong><br>
                • US: Shows ounces and grams<br>
                • Europe: Shows only grams<br>
                • Serving sizes vary by region
            </div>

            <h3>⚗️ Laboratory Measurements</h3>
            <ul>
                <li><strong>Chemical samples:</strong> Measured in milligrams or grams</li>
                <li><strong>Lab scale precision:</strong> 0.001 g (1 mg)</li>
                <li><strong>Analytical balance:</strong> 0.0001 g (0.1 mg)</li>
                <li><strong>Standard weights:</strong> Calibrated in grams</li>
            </ul>

            <h3>🎓 Educational Context</h3>
            <p>The gram is the base unit of mass in the metric system, defined as one-thousandth of a kilogram. The ounce comes from the Roman "uncia" (one-twelfth). The avoirdupois ounce (28.35 g) is used for most everyday items, while the troy ounce (31.10 g) is reserved for precious metals like gold and silver.</p>
        </div>

        <div class="footer">
            <p>⚖️ Accurate Grams ⇄ Ounces Conversion | Bidirectional Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for cooking, jewelry, shipping, fitness, and everyday measurements</p>
        </div>
    </div>

    <script>
        const GRAMS_PER_OUNCE = 28.349523125;

        function convertGrams() {
            const grams = parseFloat(document.getElementById('gramsInput').value);
            
            if (isNaN(grams) || grams < 0) {
                return;
            }

            const ounces = grams / GRAMS_PER_OUNCE;
            document.getElementById('ouncesInput').value = ounces.toFixed(5);
            
            document.getElementById('resultValue').textContent = 
                `${grams.toFixed(3)} g = ${ounces.toFixed(5)} oz`;
            
            document.getElementById('resultFormula').textContent = 
                `${grams.toFixed(3)} g ÷ ${GRAMS_PER_OUNCE.toFixed(4)} = ${ounces.toFixed(5)} oz`;
        }

        function convertOunces() {
            const ounces = parseFloat(document.getElementById('ouncesInput').value);
            
            if (isNaN(ounces) || ounces < 0) {
                return;
            }

            const grams = ounces * GRAMS_PER_OUNCE;
            document.getElementById('gramsInput').value = grams.toFixed(3);
            
            document.getElementById('resultValue').textContent = 
                `${ounces.toFixed(5)} oz = ${grams.toFixed(3)} g`;
            
            document.getElementById('resultFormula').textContent = 
                `${ounces.toFixed(5)} oz × ${GRAMS_PER_OUNCE.toFixed(4)} = ${grams.toFixed(3)} g`;
        }

        function swapUnits() {
            const gramsValue = document.getElementById('gramsInput').value;
            const ouncesValue = document.getElementById('ouncesInput').value;
            
            document.getElementById('gramsInput').value = ouncesValue;
            document.getElementById('ouncesInput').value = gramsValue;
            
            if (gramsValue) convertGrams();
        }

        function setGrams(value) {
            document.getElementById('gramsInput').value = value;
            convertGrams();
        }

        // Auto-convert on input
        document.getElementById('gramsInput').addEventListener('input', convertGrams);
        document.getElementById('ouncesInput').addEventListener('input', convertOunces);

        // Initial conversion
        convertGrams();
    </script>
</body>
</html>