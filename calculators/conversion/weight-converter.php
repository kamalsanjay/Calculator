<?php
/**
 * Weight Converter
 * File: conversion/weight-converter.php
 * Description: Convert between pounds, kilograms, ounces, and other weight units
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weight Converter - Pounds, Kilograms, Ounces Calculator</title>
    <meta name="description" content="Convert between pounds, kilograms, ounces, grams, and other weight units. Universal weight converter.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-section { margin-bottom: 25px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 90px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #667eea; font-weight: 600; font-size: 0.95rem; }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #e0e7ff 0%, #cfd9ff 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #667eea; }
        .result-unit { color: #4c51bf; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-value { font-size: 1.8rem; font-weight: bold; color: #5a67d8; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #667eea; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15); }
        .quick-value { font-weight: bold; color: #667eea; font-size: 1rem; }
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
        .conversion-table tr:hover { background: #e0e7ff; }
        
        .formula-box { background: #e0e7ff; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .result-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚖️ Weight Converter</h1>
            <p>Convert between pounds, kilograms, ounces, and all weight units</p>
        </div>

        <div class="converter-card">
            <div class="input-section">
                <div class="input-group">
                    <label for="kgInput">Weight in Kilograms (kg)</label>
                    <div class="input-wrapper">
                        <input type="number" id="kgInput" placeholder="Enter kilograms" step="0.01" min="0" value="70">
                        <span class="unit-label">kg</span>
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid">
                <div class="result-card">
                    <div class="result-unit">Pounds (lb)</div>
                    <div class="result-value" id="lbValue">154.32 lb</div>
                </div>
                <div class="result-card">
                    <div class="result-unit">Ounces (oz)</div>
                    <div class="result-value" id="ozValue">2,469.17 oz</div>
                </div>
                <div class="result-card">
                    <div class="result-unit">Grams (g)</div>
                    <div class="result-value" id="gValue">70,000 g</div>
                </div>
                <div class="result-card">
                    <div class="result-unit">Stone</div>
                    <div class="result-value" id="stValue">11.02 st</div>
                </div>
                <div class="result-card">
                    <div class="result-unit">Metric Ton</div>
                    <div class="result-value" id="tValue">0.070 t</div>
                </div>
            </div>

            <div class="quick-convert">
                <h3>⚖️ Common Weights</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setKg(1)">
                        <div class="quick-value">1 kg</div>
                        <div class="quick-label">2.2 lbs</div>
                    </div>
                    <div class="quick-btn" onclick="setKg(50)">
                        <div class="quick-value">50 kg</div>
                        <div class="quick-label">Medium Weight</div>
                    </div>
                    <div class="quick-btn" onclick="setKg(70)">
                        <div class="quick-value">70 kg</div>
                        <div class="quick-label">Average Person</div>
                    </div>
                    <div class="quick-btn" onclick="setKg(100)">
                        <div class="quick-value">100 kg</div>
                        <div class="quick-label">Heavy Weight</div>
                    </div>
                    <div class="quick-btn" onclick="setKg(1000)">
                        <div class="quick-value">1,000 kg</div>
                        <div class="quick-label">1 Metric Ton</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⚖️ Weight Unit Conversion</h2>
            
            <p>Weight measures the force of gravity on an object. The <strong>kilogram (kg)</strong> is the SI unit, while <strong>pound (lb)</strong> is used primarily in the United States.</p>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>Kilograms to Other Units:</strong><br>
                • Pounds (lb) = Kilograms × 2.20462<br>
                • Ounces (oz) = Kilograms × 35.274<br>
                • Grams (g) = Kilograms × 1,000<br>
                • Stone = Kilograms × 0.157473<br>
                • Metric Ton (t) = Kilograms ÷ 1,000<br><br>
                <strong>Base Definitions:</strong><br>
                • 1 kg = 1,000 grams<br>
                • 1 lb = 16 ounces = 0.453592 kg<br>
                • 1 stone = 14 pounds = 6.35029 kg
            </div>

            <h3>📊 Weight Unit Comparison</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Kilograms</th>
                        <th>Common Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 Gram</td><td>0.001 kg</td><td>Small items</td></tr>
                    <tr><td>1 Ounce</td><td>0.0283 kg</td><td>Food portions</td></tr>
                    <tr><td>1 Pound</td><td>0.454 kg</td><td>US standard</td></tr>
                    <tr><td>1 Kilogram</td><td>1 kg</td><td>SI unit</td></tr>
                    <tr><td>1 Stone</td><td>6.35 kg</td><td>UK body weight</td></tr>
                    <tr><td>1 Metric Ton</td><td>1,000 kg</td><td>Large weights</td></tr>
                </tbody>
            </table>

            <h3>👤 Human Body Weight</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Kilograms</th>
                        <th>Pounds</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Newborn baby</td><td>3-4 kg</td><td>6.6-8.8 lb</td></tr>
                    <tr><td>Child (5 years)</td><td>18-20 kg</td><td>40-44 lb</td></tr>
                    <tr><td>Child (10 years)</td><td>30-35 kg</td><td>66-77 lb</td></tr>
                    <tr><td>Adult female (average)</td><td>60-70 kg</td><td>132-154 lb</td></tr>
                    <tr><td>Adult male (average)</td><td>70-85 kg</td><td>154-187 lb</td></tr>
                    <tr><td>Athlete (varies)</td><td>65-100+ kg</td><td>143-220+ lb</td></tr>
                </tbody>
            </table>

            <h3>🍎 Food & Cooking</h3>
            <ul>
                <li><strong>1 cup flour:</strong> ~120 g (4.2 oz)</li>
                <li><strong>1 cup sugar:</strong> ~200 g (7 oz)</li>
                <li><strong>1 stick butter:</strong> 113 g (4 oz)</li>
                <li><strong>1 cup rice:</strong> ~185 g (6.5 oz)</li>
                <li><strong>Medium apple:</strong> 182 g (6.4 oz)</li>
                <li><strong>Large egg:</strong> 50 g (1.76 oz)</li>
                <li><strong>Chicken breast:</strong> 170-230 g (6-8 oz)</li>
            </ul>

            <h3>📦 Package Weights</h3>
            <div class="formula-box">
                <strong>Shipping Standards:</strong><br>
                • Letter: Up to 50 g (1.76 oz)<br>
                • Small package: 1-5 kg (2.2-11 lb)<br>
                • Medium package: 5-15 kg (11-33 lb)<br>
                • Large package: 15-30 kg (33-66 lb)<br>
                • Freight: 30+ kg (66+ lb)<br>
                • Max UPS/FedEx: 70 kg (150 lb)
            </div>

            <h3>🏋️ Gym Weights</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Equipment</th>
                        <th>Kilograms</th>
                        <th>Pounds</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Light dumbbell</td><td>2-5 kg</td><td>4.4-11 lb</td></tr>
                    <tr><td>Medium dumbbell</td><td>10-20 kg</td><td>22-44 lb</td></tr>
                    <tr><td>Heavy dumbbell</td><td>25-50 kg</td><td>55-110 lb</td></tr>
                    <tr><td>Olympic barbell</td><td>20 kg</td><td>45 lb</td></tr>
                    <tr><td>Weight plate (standard)</td><td>1.25-25 kg</td><td>2.5-55 lb</td></tr>
                    <tr><td>Kettlebell</td><td>4-32 kg</td><td>9-70 lb</td></tr>
                </tbody>
            </table>

            <h3>🐾 Animal Weights</h3>
            <ul>
                <li><strong>Cat:</strong> 3-5 kg (6.6-11 lb)</li>
                <li><strong>Small dog:</strong> 5-10 kg (11-22 lb)</li>
                <li><strong>Medium dog:</strong> 10-25 kg (22-55 lb)</li>
                <li><strong>Large dog:</strong> 25-50 kg (55-110 lb)</li>
                <li><strong>Giant dog:</strong> 50-90 kg (110-200 lb)</li>
                <li><strong>Horse:</strong> 380-550 kg (840-1,210 lb)</li>
                <li><strong>Cow:</strong> 600-800 kg (1,320-1,760 lb)</li>
            </ul>

            <h3>🚗 Vehicle Weights</h3>
            <div class="formula-box">
                <strong>Typical Curb Weights:</strong><br>
                • Motorcycle: 150-300 kg (330-660 lb)<br>
                • Smart car: 750 kg (1,650 lb)<br>
                • Compact car: 1,200-1,400 kg (2,650-3,090 lb)<br>
                • Sedan: 1,400-1,700 kg (3,090-3,750 lb)<br>
                • SUV: 1,800-2,500 kg (3,970-5,510 lb)<br>
                • Pickup truck: 2,000-3,000 kg (4,410-6,610 lb)<br>
                • Semi-truck: 15,000-36,000 kg (33,070-79,370 lb)
            </div>

            <h3>✈️ Luggage Limits</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Airline Type</th>
                        <th>Kilograms</th>
                        <th>Pounds</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Carry-on</td><td>7-10 kg</td><td>15-22 lb</td></tr>
                    <tr><td>Checked (economy)</td><td>23 kg</td><td>50 lb</td></tr>
                    <tr><td>Checked (business)</td><td>32 kg</td><td>70 lb</td></tr>
                    <tr><td>Overweight fee threshold</td><td>23-32 kg</td><td>50-70 lb</td></tr>
                </tbody>
            </table>

            <h3>🏗️ Construction Materials</h3>
            <ul>
                <li><strong>Concrete (per m³):</strong> 2,400 kg (5,290 lb)</li>
                <li><strong>Steel (per m³):</strong> 7,850 kg (17,300 lb)</li>
                <li><strong>Wood (per m³):</strong> 500-700 kg (1,100-1,540 lb)</li>
                <li><strong>Brick:</strong> 2-3 kg each (4.4-6.6 lb)</li>
                <li><strong>Concrete block:</strong> 14-18 kg (31-40 lb)</li>
                <li><strong>Bag of cement:</strong> 25-50 kg (55-110 lb)</li>
            </ul>

            <h3>📱 Electronics Weight</h3>
            <div class="formula-box">
                <strong>Common Devices:</strong><br>
                • Smartphone: 150-250 g (5.3-8.8 oz)<br>
                • Tablet: 300-700 g (10.6-24.7 oz)<br>
                • Laptop (13"): 1-1.5 kg (2.2-3.3 lb)<br>
                • Laptop (15"): 1.8-2.5 kg (4-5.5 lb)<br>
                • Desktop PC: 5-15 kg (11-33 lb)<br>
                • Monitor (24"): 4-7 kg (8.8-15.4 lb)
            </div>

            <h3>💎 Precious Metals</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Grams</th>
                        <th>Troy Ounces</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 Troy ounce</td><td>31.1035 g</td><td>1 oz t</td></tr>
                    <tr><td>Gold bar (standard)</td><td>400 troy oz</td><td>12.44 kg</td></tr>
                    <tr><td>Gold coin (1 oz)</td><td>31.1 g</td><td>1.09 regular oz</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>Kilograms to Pounds:</strong><br>
                • Multiply kg by 2 for rough lbs (slightly low)<br>
                • Example: 70 kg × 2 = 140 lb<br>
                • Actual: 70 kg = 154.3 lb<br>
                • For accuracy: multiply by 2.2<br><br>
                <strong>Pounds to Kilograms:</strong><br>
                • Divide lbs by 2 for rough kg (slightly high)<br>
                • Example: 150 lb ÷ 2 = 75 kg<br>
                • Actual: 150 lb = 68 kg<br>
                • For accuracy: divide by 2.2
            </div>

            <h3>🌍 Regional Usage</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Region</th>
                        <th>Body Weight</th>
                        <th>Other Uses</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>United States</td><td>Pounds</td><td>Pounds/ounces</td></tr>
                    <tr><td>United Kingdom</td><td>Stone/pounds</td><td>Kilograms</td></tr>
                    <tr><td>Canada</td><td>Kilograms</td><td>Metric system</td></tr>
                    <tr><td>Europe</td><td>Kilograms</td><td>Metric standard</td></tr>
                    <tr><td>Asia</td><td>Kilograms</td><td>Metric system</td></tr>
                </tbody>
            </table>

            <h3>🎯 Practical Examples</h3>
            <ul>
                <li><strong>Bag of potatoes:</strong> 5 kg = 11 lb</li>
                <li><strong>Gallon of milk:</strong> 3.78 kg = 8.34 lb</li>
                <li><strong>Bowling ball:</strong> 6-7 kg = 13-16 lb</li>
                <li><strong>Newborn baby:</strong> 3.5 kg = 7.7 lb</li>
                <li><strong>Small dog:</strong> 7 kg = 15.4 lb</li>
                <li><strong>Suitcase (empty):</strong> 3-5 kg = 6.6-11 lb</li>
            </ul>

            <h3>🏛️ Historical Context</h3>
            <p>The <strong>kilogram</strong> was originally defined as the mass of one liter of water. The <strong>pound</strong> comes from the Roman "libra" (hence the abbreviation "lb"). The <strong>stone</strong> is a uniquely British unit still used for body weight in the UK. In 2019, the kilogram was redefined based on fundamental constants of nature rather than a physical prototype.</p>

            <h3>🔑 Key Conversions</h3>
            <ul>
                <li><strong>1 kg = 2.20462 pounds = 1,000 grams</strong></li>
                <li><strong>1 lb = 0.453592 kg = 16 ounces</strong></li>
                <li><strong>1 oz = 28.3495 grams</strong></li>
                <li><strong>1 stone = 14 pounds = 6.35 kg</strong></li>
                <li><strong>1 metric ton = 1,000 kg = 2,204.6 lb</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>⚖️ Accurate Weight Conversion | All Weight Units</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for body weight, cooking, shipping, and weight measurements</p>
        </div>
    </div>

    <script>
        function convertKg() {
            const kg = parseFloat(document.getElementById('kgInput').value);
            
            if (isNaN(kg) || kg < 0) {
                return;
            }

            // Convert kg to other units
            const lb = kg * 2.20462;
            const oz = kg * 35.274;
            const g = kg * 1000;
            const stone = kg * 0.157473;
            const ton = kg / 1000;
            
            document.getElementById('lbValue').textContent = lb.toFixed(2) + ' lb';
            document.getElementById('ozValue').textContent = oz.toLocaleString('en-US', {maximumFractionDigits: 2}) + ' oz';
            document.getElementById('gValue').textContent = g.toLocaleString('en-US', {maximumFractionDigits: 0}) + ' g';
            document.getElementById('stValue').textContent = stone.toFixed(2) + ' st';
            document.getElementById('tValue').textContent = ton.toFixed(3) + ' t';
        }

        function setKg(value) {
            document.getElementById('kgInput').value = value;
            convertKg();
        }

        // Auto-convert on input
        document.getElementById('kgInput').addEventListener('input', convertKg);

        // Initial conversion
        convertKg();
    </script>
</body>
</html>