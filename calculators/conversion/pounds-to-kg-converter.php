<?php
/**
 * Pounds to Kilograms Converter
 * File: conversion/pounds-to-kg-converter.php
 * Description: Convert between pounds and kilograms with detailed weight information
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pounds to Kilograms Converter - Weight Conversion Calculator</title>
    <meta name="description" content="Convert between pounds and kilograms with precision. Learn about weight measurements, conversions, and practical applications.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #ff7e5f; box-shadow: 0 0 0 3px rgba(255, 126, 95, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; margin-top: 10px; }
        .unit-select:focus { outline: none; border-color: #ff7e5f; box-shadow: 0 0 0 3px rgba(255, 126, 95, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #ff7e5f; }
        .result-unit { color: #d63031; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #e17055; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #ff7e5f; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255, 126, 95, 0.15); }
        .quick-value { font-weight: bold; color: #ff7e5f; font-size: 1rem; }
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
        .conversion-table tr:hover { background: #ffeaa7; }
        
        .formula-box { background: #ffeaa7; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff7e5f; }
        .formula-box strong { color: #ff7e5f; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
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
            <h1>⚖️ Pounds to Kilograms Converter</h1>
            <p>Convert between pounds and kilograms with precision. Essential for cooking, fitness, shipping, and scientific applications.</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="lb" selected>Pound (lb)</option>
                        <option value="kg">Kilogram (kg)</option>
                        <option value="oz">Ounce (oz)</option>
                        <option value="g">Gram (g)</option>
                        <option value="stone">Stone (st)</option>
                        <option value="ton">US Ton (t)</option>
                        <option value="tonne">Metric Tonne (t)</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="lb">Pound (lb)</option>
                        <option value="kg" selected>Kilogram (kg)</option>
                        <option value="oz">Ounce (oz)</option>
                        <option value="g">Gram (g)</option>
                        <option value="stone">Stone (st)</option>
                        <option value="ton">US Ton (t)</option>
                        <option value="tonne">Metric Tonne (t)</option>
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
                        <div class="quick-label">Unit</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(10)">
                        <div class="quick-value">10</div>
                        <div class="quick-label">Units</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(100)">
                        <div class="quick-value">100</div>
                        <div class="quick-label">Units</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(1000)">
                        <div class="quick-value">1000</div>
                        <div class="quick-label">Units</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⚖️ Weight Conversion Guide</h2>
            
            <p>Convert between pounds, kilograms, and other weight units used worldwide for personal, commercial, and scientific purposes.</p>

            <h3>📊 Conversion Factors to Kilograms</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Kilograms</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Kilogram</td><td>kg</td><td>1</td></tr>
                    <tr><td>Pound</td><td>lb</td><td>0.45359237</td></tr>
                    <tr><td>Ounce</td><td>oz</td><td>0.0283495</td></tr>
                    <tr><td>Gram</td><td>g</td><td>0.001</td></tr>
                    <tr><td>Stone</td><td>st</td><td>6.35029</td></tr>
                    <tr><td>US Ton</td><td>ton</td><td>907.185</td></tr>
                    <tr><td>Metric Tonne</td><td>tonne</td><td>1,000</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Conversion Formulas:</strong><br>
                • 1 pound = 0.45359237 kilograms (exact)<br>
                • 1 kilogram = 2.20462262 pounds<br>
                • 1 ounce = 28.3495 grams<br>
                • 1 stone = 14 pounds = 6.35029 kg<br>
                • 1 US ton = 2,000 pounds = 907.185 kg<br>
                • 1 metric tonne = 1,000 kg = 2,204.62 pounds
            </div>

            <h3>🌍 Global Weight Systems</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>System</th>
                        <th>Primary Units</th>
                        <th>Used In</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Metric</td><td>Kilograms, grams</td><td>Most countries worldwide</td></tr>
                    <tr><td>Imperial</td><td>Pounds, ounces, stone</td><td>United Kingdom, Ireland</td></tr>
                    <tr><td>US Customary</td><td>Pounds, ounces, tons</td><td>United States</td></tr>
                </tbody>
            </table>

            <h3>👤 Human Weight Ranges</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Kilograms</th>
                        <th>Pounds</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Newborn baby</td><td>2.5-4.5 kg</td><td>5.5-10 lb</td></tr>
                    <tr><td>Average adult male</td><td>70-85 kg</td><td>154-187 lb</td></tr>
                    <tr><td>Average adult female</td><td>55-70 kg</td><td>121-154 lb</td></tr>
                    <tr><td>Professional athlete</td><td>Varies by sport</td><td>Varies by sport</td></tr>
                </tbody>
            </table>

            <h3>🏋️ Fitness & Health</h3>
            <ul>
                <li><strong>BMI Calculation:</strong> Weight in kg ÷ (Height in m)²</li>
                <li><strong>Weightlifting:</strong> Typically measured in pounds (US) or kilograms (elsewhere)</li>
                <li><strong>Weight loss goals:</strong> Often tracked in pounds (US) or kilograms</li>
                <li><strong>Medical dosages:</strong> Calculated based on weight in kilograms</li>
            </ul>

            <h3>🛒 Commercial & Retail</h3>
            <div class="formula-box">
                <strong>Common Product Weights:</strong><br>
                • Groceries: Pounds (US), Kilograms (elsewhere)<br>
                • Precious metals: Troy ounces (31.1 grams)<br>
                • Postal packages: Pounds and ounces (US), Kilograms (elsewhere)<br>
                • Bulk commodities: Tons or metric tonnes
            </div>

            <h3>🍳 Cooking & Recipes</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Ingredient</th>
                        <th>Common Measurement</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Flour</td><td>1 cup ≈ 120-125 grams</td></tr>
                    <tr><td>Sugar</td><td>1 cup ≈ 200 grams</td></tr>
                    <tr><td>Butter</td><td>1 stick = 113 grams (¼ lb)</td></tr>
                    <tr><td>Meat</td><td>Often sold by pound (US) or kilogram</td></tr>
                </tbody>
            </table>

            <h3>📦 Shipping & Logistics</h3>
            <ul>
                <li><strong>US Postal Service:</strong> Uses ounces and pounds</li>
                <li><strong>International shipping:</strong> Typically uses kilograms</li>
                <li><strong>Air freight:</strong> Chargeable weight in kilograms</li>
                <li><strong>Trucking:</strong> Gross vehicle weight in pounds (US) or kilograms</li>
            </ul>

            <h3>🔬 Scientific Applications</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Typical Units</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Chemistry</td><td>Grams, milligrams</td></tr>
                    <tr><td>Physics</td><td>Kilograms (SI base unit)</td></tr>
                    <tr><td>Pharmacology</td><td>Milligrams, micrograms</td></tr>
                    <tr><td>Engineering</td><td>Pounds or kilograms depending on location</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>Pounds ↔ Kilograms:</strong><br>
                • Multiply pounds by 0.45 for rough kilograms<br>
                • Multiply kilograms by 2.2 for rough pounds<br><br>
                <strong>Ounces ↔ Grams:</strong><br>
                • Multiply ounces by 28 for rough grams<br>
                • Divide grams by 28 for rough ounces<br><br>
                <strong>Stone ↔ Kilograms:</strong><br>
                • Multiply stone by 6.35 for kilograms<br>
                • Divide kilograms by 6.35 for stone
            </div>

            <h3>🌎 Country Standards</h3>
            <ul>
                <li><strong>United States:</strong> Pounds and ounces for most applications</li>
                <li><strong>United Kingdom:</strong> Stone and pounds for body weight, metric for other uses</li>
                <li><strong>Canada:</strong> Officially metric, but some imperial use persists</li>
                <li><strong>Australia/New Zealand:</strong> Fully metric (kilograms)</li>
                <li><strong>European Union:</strong> Exclusively metric (kilograms)</li>
            </ul>

            <h3>⚖️ Historical Context</h3>
            <p>The <strong>pound</strong> has origins in Roman libra, while the <strong>kilogram</strong> was defined in 1795 as the mass of one liter of water. Today, the kilogram is defined by the Planck constant. The international avoirdupois pound was defined in 1959 as exactly 0.45359237 kilograms.</p>

            <h3>🎯 Key Conversions to Remember</h3>
            <ul>
                <li><strong>1 pound = 0.4536 kilograms</strong></li>
                <li><strong>1 kilogram = 2.2046 pounds</strong></li>
                <li><strong>1 ounce = 28.35 grams</strong></li>
                <li><strong>1 stone = 14 pounds = 6.35 kg</strong></li>
                <li><strong>1 US ton = 2,000 pounds = 907.185 kg</strong></li>
                <li><strong>1 metric tonne = 1,000 kg = 2,204.62 pounds</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>⚖️ Pounds to Kilograms Converter | Complete Weight Conversion</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert pounds, kilograms, ounces, grams, stone, and tons with precision</p>
        </div>
    </div>

    <script>
        // Conversion factors to kilograms
        const toKilograms = {
            kg: 1,
            lb: 0.45359237,
            oz: 0.0283495,
            g: 0.001,
            stone: 6.35029,
            ton: 907.185,
            tonne: 1000
        };

        const unitNames = {
            kg: 'Kilogram (kg)',
            lb: 'Pound (lb)',
            oz: 'Ounce (oz)',
            g: 'Gram (g)',
            stone: 'Stone (st)',
            ton: 'US Ton (t)',
            tonne: 'Metric Tonne (t)'
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

            // Convert to kilograms first
            const valueInKilograms = inputValue * toKilograms[fromUnit];
            
            // Convert to target unit
            const result = valueInKilograms / toKilograms[toUnit];
            
            document.getElementById('outputValue').value = formatNumber(result);
            
            displayAllConversions(valueInKilograms);
        }

        function displayAllConversions(valueInKilograms) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInKilograms / toKilograms[unit];
                
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
            if (Math.abs(num) < 0.000001 || Math.abs(num) > 1e12) {
                return num.toExponential(6);
            }
            return num.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 6
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

        // Auto-convert on input
        document.getElementById('inputValue').addEventListener('input', convert);
        document.getElementById('fromUnit').addEventListener('change', convert);
        document.getElementById('toUnit').addEventListener('change', convert);

        // Initial conversion
        convert();
    </script>
</body>
</html>