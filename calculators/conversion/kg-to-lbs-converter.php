<?php
/**
 * KG to LBS Converter
 * File: conversion/kg-to-lbs-converter.php
 * Description: Convert kilograms to pounds and vice versa
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KG to LBS Converter - Kilograms to Pounds Calculator</title>
    <meta name="description" content="Convert kilograms (kg) to pounds (lbs) and lbs to kg instantly. Bidirectional weight converter for everyday use.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #e96443 0%, #904e95 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 900px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 70px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #e96443; box-shadow: 0 0 0 3px rgba(233, 100, 67, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #e96443; font-weight: 600; font-size: 0.95rem; }
        
        .swap-btn { background: linear-gradient(135deg, #e96443 0%, #904e95 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-box { background: linear-gradient(135deg, #ffe5df 0%, #f3e5f5 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #e96443; margin-bottom: 25px; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.5rem; font-weight: bold; color: #e96443; margin-bottom: 10px; }
        .result-formula { background: white; padding: 15px; border-radius: 8px; font-family: 'Courier New', monospace; color: #555; font-size: 0.9rem; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #e96443; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(233, 100, 67, 0.15); }
        .quick-value { font-weight: bold; color: #e96443; font-size: 1.1rem; }
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
        .conversion-table tr:hover { background: #ffe5df; }
        
        .formula-box { background: #ffe5df; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #e96443; }
        .formula-box strong { color: #e96443; }
        
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
            <h1>⚖️ KG ⇄ LBS Converter</h1>
            <p>Convert between kilograms and pounds with bidirectional conversion</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="kgInput">Kilograms</label>
                    <div class="input-wrapper">
                        <input type="number" id="kgInput" placeholder="Enter kg" step="0.01" min="0" value="70">
                        <span class="unit-label">kg</span>
                    </div>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="lbsInput">Pounds</label>
                    <div class="input-wrapper">
                        <input type="number" id="lbsInput" placeholder="Enter lbs" step="0.01" min="0">
                        <span class="unit-label">lbs</span>
                    </div>
                </div>
            </div>

            <div class="result-box">
                <div class="result-label">Result</div>
                <div class="result-value" id="resultValue">70 kg = 154.32 lbs</div>
                <div class="result-formula" id="resultFormula">70 kg × 2.20462 = 154.32 lbs</div>
            </div>

            <div class="quick-convert">
                <h3>⚖️ Common Weights</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setKg(50)">
                        <div class="quick-value">50 kg</div>
                        <div class="quick-label">110.2 lbs</div>
                    </div>
                    <div class="quick-btn" onclick="setKg(70)">
                        <div class="quick-value">70 kg</div>
                        <div class="quick-label">154.3 lbs</div>
                    </div>
                    <div class="quick-btn" onclick="setKg(80)">
                        <div class="quick-value">80 kg</div>
                        <div class="quick-label">176.4 lbs</div>
                    </div>
                    <div class="quick-btn" onclick="setKg(90)">
                        <div class="quick-value">90 kg</div>
                        <div class="quick-label">198.4 lbs</div>
                    </div>
                    <div class="quick-btn" onclick="setKg(100)">
                        <div class="quick-value">100 kg</div>
                        <div class="quick-label">220.5 lbs</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⚖️ Kilograms to Pounds Conversion</h2>
            
            <p>The <strong>kilogram (kg)</strong> is the SI base unit of mass used worldwide, while the <strong>pound (lb or lbs)</strong> is an imperial unit commonly used in the United States.</p>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>Kilograms to Pounds:</strong><br>
                • Pounds = Kilograms × 2.20462<br>
                • 1 kilogram = 2.20462 pounds<br><br>
                <strong>Pounds to Kilograms:</strong><br>
                • Kilograms = Pounds ÷ 2.20462<br>
                • 1 pound = 0.453592 kilograms
            </div>

            <h3>📊 Conversion Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Kilograms (kg)</th>
                        <th>Pounds (lbs)</th>
                        <th>Common Reference</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 kg</td><td>2.20 lbs</td><td>Bag of sugar</td></tr>
                    <tr><td>5 kg</td><td>11.02 lbs</td><td>Bowling ball</td></tr>
                    <tr><td>10 kg</td><td>22.05 lbs</td><td>Car tire</td></tr>
                    <tr><td>25 kg</td><td>55.12 lbs</td><td>Large dog</td></tr>
                    <tr><td>50 kg</td><td>110.23 lbs</td><td>Small adult</td></tr>
                    <tr><td>70 kg</td><td>154.32 lbs</td><td>Average adult</td></tr>
                    <tr><td>90 kg</td><td>198.42 lbs</td><td>Large adult</td></tr>
                    <tr><td>100 kg</td><td>220.46 lbs</td><td>100 kilograms</td></tr>
                </tbody>
            </table>

            <h3>👤 Human Body Weight</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Weight Category</th>
                        <th>Kilograms</th>
                        <th>Pounds</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Newborn baby</td><td>2.5-4 kg</td><td>5.5-8.8 lbs</td></tr>
                    <tr><td>1-year-old</td><td>9-11 kg</td><td>20-24 lbs</td></tr>
                    <tr><td>5-year-old</td><td>18-20 kg</td><td>40-44 lbs</td></tr>
                    <tr><td>10-year-old</td><td>30-35 kg</td><td>66-77 lbs</td></tr>
                    <tr><td>Adult female (avg)</td><td>60-75 kg</td><td>132-165 lbs</td></tr>
                    <tr><td>Adult male (avg)</td><td>70-85 kg</td><td>154-187 lbs</td></tr>
                    <tr><td>Athlete (heavy)</td><td>90-110 kg</td><td>198-243 lbs</td></tr>
                </tbody>
            </table>

            <h3>🏋️ Gym & Fitness</h3>
            <ul>
                <li><strong>Standard barbell:</strong> 20 kg (45 lbs)</li>
                <li><strong>Weight plates:</strong> 2.5, 5, 10, 20, 25 kg (5.5, 11, 22, 44, 55 lbs)</li>
                <li><strong>Dumbbell set:</strong> 5-50 kg (11-110 lbs)</li>
                <li><strong>Kettlebell:</strong> 8, 12, 16, 24, 32 kg (18, 26, 35, 53, 70 lbs)</li>
                <li><strong>Beginner bench press:</strong> 40-60 kg (88-132 lbs)</li>
            </ul>

            <h3>📦 Shipping & Luggage</h3>
            <div class="formula-box">
                <strong>Common Weight Limits:</strong><br>
                • Carry-on luggage: 7-10 kg (15-22 lbs)<br>
                • Checked bag (economy): 23 kg (50 lbs)<br>
                • Checked bag (business): 32 kg (70 lbs)<br>
                • Overweight baggage: > 32 kg (> 70 lbs)<br>
                • Small package (postal): Up to 20 kg (44 lbs)<br>
                • Large package: 20-70 kg (44-154 lbs)
            </div>

            <h3>🥊 Combat Sports Weight Classes</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Weight Class</th>
                        <th>Kilograms</th>
                        <th>Pounds</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Flyweight</td><td>~57 kg</td><td>~125 lbs</td></tr>
                    <tr><td>Lightweight</td><td>~70 kg</td><td>~155 lbs</td></tr>
                    <tr><td>Welterweight</td><td>~77 kg</td><td>~170 lbs</td></tr>
                    <tr><td>Middleweight</td><td>~84 kg</td><td>~185 lbs</td></tr>
                    <tr><td>Light Heavyweight</td><td>~93 kg</td><td>~205 lbs</td></tr>
                    <tr><td>Heavyweight</td><td>> 93 kg</td><td>> 205 lbs</td></tr>
                </tbody>
            </table>

            <h3>🐕 Pet Weights</h3>
            <ul>
                <li><strong>Small dog (Chihuahua):</strong> 1-3 kg (2-7 lbs)</li>
                <li><strong>Medium dog (Beagle):</strong> 10-15 kg (22-33 lbs)</li>
                <li><strong>Large dog (Labrador):</strong> 25-35 kg (55-77 lbs)</li>
                <li><strong>Giant dog (Great Dane):</strong> 50-90 kg (110-200 lbs)</li>
                <li><strong>House cat:</strong> 3-6 kg (7-13 lbs)</li>
            </ul>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>KG to LBS (Rough):</strong><br>
                • Multiply kg by 2.2<br>
                • Example: 75 kg × 2.2 = 165 lbs<br>
                • Actual: 75 kg = 165.35 lbs (very close!)<br><br>
                <strong>LBS to KG (Rough):</strong><br>
                • Divide lbs by 2.2<br>
                • Example: 180 lbs ÷ 2.2 ≈ 82 kg<br>
                • Actual: 180 lbs = 81.65 kg (close!)
            </div>

            <h3>🍎 Food & Grocery Items</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Kilograms</th>
                        <th>Pounds</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Apple</td><td>~0.2 kg</td><td>~0.44 lbs</td></tr>
                    <tr><td>Banana (bunch)</td><td>~1 kg</td><td>~2.2 lbs</td></tr>
                    <tr><td>Bag of flour</td><td>1-2 kg</td><td>2.2-4.4 lbs</td></tr>
                    <tr><td>Bag of rice</td><td>5-10 kg</td><td>11-22 lbs</td></tr>
                    <tr><td>Watermelon</td><td>5-8 kg</td><td>11-18 lbs</td></tr>
                    <tr><td>Turkey (whole)</td><td>5-8 kg</td><td>11-18 lbs</td></tr>
                </tbody>
            </table>

            <h3>🌍 Regional Usage</h3>
            <ul>
                <li><strong>United States:</strong> Uses pounds (lbs) primarily</li>
                <li><strong>United Kingdom:</strong> Uses stones and pounds, transitioning to kg</li>
                <li><strong>Canada:</strong> Officially uses kg, but lbs common</li>
                <li><strong>Most of world:</strong> Uses kilograms exclusively</li>
                <li><strong>Science/Medicine:</strong> Universal use of kilograms</li>
            </ul>

            <h3>🚗 Vehicle Weights</h3>
            <div class="formula-box">
                <strong>Typical Vehicle Weights:</strong><br>
                • Motorcycle: 150-300 kg (330-660 lbs)<br>
                • Compact car: 1,000-1,200 kg (2,200-2,650 lbs)<br>
                • Sedan: 1,300-1,600 kg (2,865-3,527 lbs)<br>
                • SUV: 1,800-2,500 kg (3,968-5,512 lbs)<br>
                • Pickup truck: 2,000-3,000 kg (4,409-6,614 lbs)<br>
                • Semi-truck (loaded): 36,000 kg (79,366 lbs)
            </div>

            <h3>📐 Weight Hierarchy</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Metric</th>
                        <th>Imperial</th>
                        <th>Conversion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 gram (g)</td><td>0.035 oz</td><td>1 g = 0.035274 oz</td></tr>
                    <tr><td>1 kilogram (kg)</td><td>2.205 lbs</td><td>1 kg = 2.20462 lbs</td></tr>
                    <tr><td>1 tonne (t)</td><td>2,205 lbs</td><td>1 t = 1,000 kg</td></tr>
                    <tr><td>-</td><td>1 ounce (oz)</td><td>1 oz = 28.35 g</td></tr>
                    <tr><td>-</td><td>1 pound (lb)</td><td>1 lb = 0.4536 kg</td></tr>
                    <tr><td>-</td><td>1 stone</td><td>1 stone = 6.35 kg</td></tr>
                </tbody>
            </table>

            <h3>🏥 Medical & Health</h3>
            <ul>
                <li><strong>BMI calculation:</strong> Uses kg and meters (kg/m²)</li>
                <li><strong>Medication dosage:</strong> Often calculated per kg body weight</li>
                <li><strong>Weight tracking:</strong> Medical records use kg globally</li>
                <li><strong>Healthy weight range:</strong> BMI 18.5-24.9 for adults</li>
            </ul>

            <h3>🎯 Practical Examples</h3>
            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • Person 60 kg = 132.3 lbs<br>
                • Person 70 kg = 154.3 lbs<br>
                • Person 80 kg = 176.4 lbs<br>
                • Person 90 kg = 198.4 lbs<br>
                • Luggage 23 kg = 50.7 lbs<br>
                • Barbell 20 kg = 44.1 lbs
            </div>

            <h3>🏛️ Historical Context</h3>
            <p>The kilogram was originally defined in 1795 as the mass of one liter of water. It was redefined in 2019 using the Planck constant for greater precision. The pound comes from the Roman "libra" (hence "lb"), and has been standardized internationally as exactly 0.45359237 kilograms since 1959.</p>

            <h3>🔑 Key Conversions</h3>
            <ul>
                <li><strong>1 kg = 2.20462 lbs</strong> (exact conversion factor)</li>
                <li><strong>1 lb = 0.453592 kg</strong> (exact conversion factor)</li>
                <li><strong>1 stone = 14 lbs = 6.35 kg</strong> (UK unit)</li>
                <li><strong>100 kg = 220.46 lbs</strong> (nice round number)</li>
                <li><strong>1 tonne = 1,000 kg = 2,204.6 lbs</strong></li>
            </ul>

            <h3>💪 Strength Training Benchmarks</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Exercise</th>
                        <th>Beginner</th>
                        <th>Intermediate</th>
                        <th>Advanced</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Bench Press</td><td>40 kg (88 lbs)</td><td>80 kg (176 lbs)</td><td>120 kg (265 lbs)</td></tr>
                    <tr><td>Squat</td><td>60 kg (132 lbs)</td><td>100 kg (220 lbs)</td><td>150 kg (331 lbs)</td></tr>
                    <tr><td>Deadlift</td><td>70 kg (154 lbs)</td><td>120 kg (265 lbs)</td><td>180 kg (397 lbs)</td></tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>⚖️ Accurate KG ⇄ LBS Conversion | Bidirectional Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for body weight, fitness, travel, and everyday weight conversions</p>
        </div>
    </div>

    <script>
        const LBS_PER_KG = 2.20462262185;

        function convertKg() {
            const kg = parseFloat(document.getElementById('kgInput').value);
            
            if (isNaN(kg) || kg < 0) {
                return;
            }

            const lbs = kg * LBS_PER_KG;
            document.getElementById('lbsInput').value = lbs.toFixed(2);
            
            document.getElementById('resultValue').textContent = 
                `${kg.toFixed(2)} kg = ${lbs.toFixed(2)} lbs`;
            
            document.getElementById('resultFormula').textContent = 
                `${kg.toFixed(2)} kg × 2.20462 = ${lbs.toFixed(2)} lbs`;
        }

        function convertLbs() {
            const lbs = parseFloat(document.getElementById('lbsInput').value);
            
            if (isNaN(lbs) || lbs < 0) {
                return;
            }

            const kg = lbs / LBS_PER_KG;
            document.getElementById('kgInput').value = kg.toFixed(2);
            
            document.getElementById('resultValue').textContent = 
                `${lbs.toFixed(2)} lbs = ${kg.toFixed(2)} kg`;
            
            document.getElementById('resultFormula').textContent = 
                `${lbs.toFixed(2)} lbs ÷ 2.20462 = ${kg.toFixed(2)} kg`;
        }

        function swapUnits() {
            const kgValue = document.getElementById('kgInput').value;
            const lbsValue = document.getElementById('lbsInput').value;
            
            document.getElementById('kgInput').value = lbsValue;
            document.getElementById('lbsInput').value = kgValue;
            
            if (kgValue) convertKg();
        }

        function setKg(value) {
            document.getElementById('kgInput').value = value;
            convertKg();
        }

        // Auto-convert on input
        document.getElementById('kgInput').addEventListener('input', convertKg);
        document.getElementById('lbsInput').addEventListener('input', convertLbs);

        // Initial conversion
        convertKg();
    </script>
</body>
</html>