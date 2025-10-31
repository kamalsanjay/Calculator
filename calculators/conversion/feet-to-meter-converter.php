<?php
/**
 * Feet to Meter Converter
 * File: conversion/feet-to-meter-converter.php
 * Description: Convert feet to meters for length/distance measurements
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feet to Meter Converter - ft to m Calculator</title>
    <meta name="description" content="Convert feet to meters instantly. Free length converter with formula, calculation steps, and common measurement reference points.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 900px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-group { margin-bottom: 25px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 80px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #4facfe; box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #4facfe; font-weight: 600; font-size: 1.1rem; }
        
        .convert-btn { width: 100%; padding: 16px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-bottom: 20px; }
        .convert-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79, 172, 254, 0.4); }
        
        .result-box { background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #4facfe; margin-bottom: 25px; display: none; }
        .result-box.show { display: block; animation: slideIn 0.4s ease; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.5rem; font-weight: bold; color: #4facfe; margin-bottom: 10px; }
        .result-steps { background: white; padding: 15px; border-radius: 8px; margin-top: 15px; }
        .step { color: #555; line-height: 1.8; margin-bottom: 8px; font-family: 'Courier New', monospace; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #4facfe; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(79, 172, 254, 0.15); }
        .quick-feet { font-weight: bold; color: #4facfe; font-size: 1.1rem; }
        .quick-meter { font-size: 0.85rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .formula-box { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #4facfe; }
        .formula-box strong { color: #4facfe; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #e3f2fd; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @keyframes slideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 1.5rem; }
            .result-value { font-size: 2rem; }
            .quick-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📏 Feet to Meter Converter</h1>
            <p>Convert length from feet (ft) to meters (m) with formula and calculation steps</p>
        </div>

        <div class="converter-card">
            <div class="input-group">
                <label for="feetInput">Length in Feet (ft)</label>
                <div class="input-wrapper">
                    <input type="number" id="feetInput" placeholder="Enter feet" step="0.01" value="10">
                    <span class="unit-label">ft</span>
                </div>
            </div>

            <button class="convert-btn" onclick="convertLength()">📐 Convert to Meters</button>

            <div class="result-box" id="resultBox">
                <div class="result-label">Meters</div>
                <div class="result-value" id="resultValue">3.048 m</div>
                <div class="result-steps" id="resultSteps">
                    <div class="step"><strong>Formula:</strong> m = ft × 0.3048</div>
                    <div class="step"><strong>Calculation:</strong> 10 × 0.3048 = 3.048</div>
                    <div class="step"><strong>Result:</strong> 10 ft = 3.048 m</div>
                </div>
            </div>

            <div class="quick-convert">
                <h3>⚡ Common Lengths</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setFeet(1)">
                        <div class="quick-feet">1 ft</div>
                        <div class="quick-meter">One Foot</div>
                    </div>
                    <div class="quick-btn" onclick="setFeet(3)">
                        <div class="quick-feet">3 ft</div>
                        <div class="quick-meter">One Yard</div>
                    </div>
                    <div class="quick-btn" onclick="setFeet(6)">
                        <div class="quick-feet">6 ft</div>
                        <div class="quick-meter">Average Height</div>
                    </div>
                    <div class="quick-btn" onclick="setFeet(10)">
                        <div class="quick-feet">10 ft</div>
                        <div class="quick-meter">Basketball Hoop</div>
                    </div>
                    <div class="quick-btn" onclick="setFeet(100)">
                        <div class="quick-feet">100 ft</div>
                        <div class="quick-meter">Building Height</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>📏 Feet to Meter Conversion</h2>
            
            <p>The <strong>foot</strong> (ft) is an imperial unit commonly used in the United States, while the <strong>meter</strong> (m) is the SI base unit for length used worldwide.</p>

            <div class="formula-box">
                <strong>Conversion Formula:</strong><br>
                meters = feet × 0.3048<br>
                or<br>
                1 foot = 0.3048 meters (exactly)
            </div>

            <h3>📊 Conversion Table</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Feet (ft)</th>
                        <th>Meters (m)</th>
                        <th>Common Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 ft</td><td>0.3048 m</td><td>Ruler length</td></tr>
                    <tr><td>3 ft</td><td>0.9144 m</td><td>One yard</td></tr>
                    <tr><td>5 ft</td><td>1.524 m</td><td>Short person height</td></tr>
                    <tr><td>6 ft</td><td>1.8288 m</td><td>Average height</td></tr>
                    <tr><td>10 ft</td><td>3.048 m</td><td>Basketball hoop height</td></tr>
                    <tr><td>20 ft</td><td>6.096 m</td><td>Room length</td></tr>
                    <tr><td>50 ft</td><td>15.24 m</td><td>Swimming pool</td></tr>
                    <tr><td>100 ft</td><td>30.48 m</td><td>Small building height</td></tr>
                    <tr><td>1,000 ft</td><td>304.8 m</td><td>Tall building</td></tr>
                </tbody>
            </table>

            <h3>🔢 How to Convert Step-by-Step</h3>
            <div class="formula-box">
                <strong>Example: Convert 15 feet to meters</strong><br><br>
                <strong>Step 1:</strong> Multiply feet by 0.3048<br>
                15 × 0.3048 = 4.572<br><br>
                <strong>Result:</strong> 15 ft = 4.572 m
            </div>

            <h3>📐 About Feet and Meters</h3>
            <ul>
                <li><strong>Foot (ft):</strong> Imperial unit, defined as exactly 0.3048 meters</li>
                <li><strong>Meter (m):</strong> SI base unit for length, defined by speed of light</li>
                <li><strong>Origin:</strong> Foot originally based on human foot length</li>
                <li><strong>12 inches:</strong> 1 foot = 12 inches = 0.3048 meters</li>
                <li><strong>3 feet:</strong> 1 yard = 3 feet = 0.9144 meters</li>
            </ul>

            <h3>🏠 Common Measurements</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Object/Distance</th>
                        <th>Feet</th>
                        <th>Meters</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Credit card width</td><td>0.28 ft</td><td>0.085 m</td></tr>
                    <tr><td>Standard door height</td><td>6.67 ft</td><td>2.03 m</td></tr>
                    <tr><td>Ceiling height</td><td>8-10 ft</td><td>2.44-3.05 m</td></tr>
                    <tr><td>Parking space</td><td>18 ft</td><td>5.5 m</td></tr>
                    <tr><td>Basketball court</td><td>94 ft</td><td>28.65 m</td></tr>
                    <tr><td>Football field (US)</td><td>300 ft</td><td>91.44 m</td></tr>
                    <tr><td>Olympic pool</td><td>164 ft</td><td>50 m</td></tr>
                </tbody>
            </table>

            <h3>🏗️ Construction & Real Estate</h3>
            <ul>
                <li><strong>Room dimensions:</strong> Often measured in feet in US</li>
                <li><strong>Ceiling height:</strong> Standard 8-10 ft (2.44-3.05 m)</li>
                <li><strong>Plot size:</strong> Square feet common in US real estate</li>
                <li><strong>Building codes:</strong> Use feet in US, meters elsewhere</li>
            </ul>

            <h3>👤 Human Height Reference</h3>
            <div class="formula-box">
                <strong>Average Heights:</strong><br>
                • 5'0" (5 feet) = 1.524 m<br>
                • 5'6" (5 feet 6 inches) = 1.676 m<br>
                • 6'0" (6 feet) = 1.829 m<br>
                • 6'6" (6 feet 6 inches) = 1.981 m<br><br>
                <strong>Note:</strong> To convert feet and inches:<br>
                1. Convert total to feet: 5'6" = 5.5 ft<br>
                2. Multiply by 0.3048: 5.5 × 0.3048 = 1.676 m
            </div>

            <h3>⚽ Sports Fields</h3>
            <ul>
                <li><strong>Basketball court:</strong> 94 × 50 ft (28.65 × 15.24 m)</li>
                <li><strong>Tennis court:</strong> 78 × 36 ft (23.77 × 10.97 m)</li>
                <li><strong>Volleyball court:</strong> 60 × 30 ft (18.29 × 9.14 m)</li>
                <li><strong>Baseball diamond:</strong> 90 ft between bases (27.43 m)</li>
                <li><strong>American football:</strong> 300 × 160 ft (91.44 × 48.77 m)</li>
            </ul>

            <h3>✈️ Aviation</h3>
            <ul>
                <li><strong>Altitude:</strong> Measured in feet in aviation worldwide</li>
                <li><strong>Cruising altitude:</strong> 30,000-40,000 ft (9,144-12,192 m)</li>
                <li><strong>FAA regulations:</strong> Use feet for altitude</li>
                <li><strong>Conversion:</strong> Flight levels (FL) × 100 = feet</li>
            </ul>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>Approximate Method:</strong><br>
                • Divide feet by 3 for rough meters<br>
                • Example: 30 ft ÷ 3 ≈ 10 m<br>
                • Actual: 30 ft = 9.144 m (close!)<br><br>
                <strong>More Accurate:</strong><br>
                • Multiply feet by 0.3<br>
                • Example: 30 × 0.3 = 9 m<br>
                • Actual: 30 ft = 9.144 m (very close!)
            </div>

            <h3>🌍 Usage Around the World</h3>
            <ul>
                <li><strong>United States:</strong> Primary measurement unit</li>
                <li><strong>United Kingdom:</strong> Used alongside meters</li>
                <li><strong>Canada:</strong> Transitioning to metric but feet still common</li>
                <li><strong>Rest of world:</strong> Primarily uses meters</li>
                <li><strong>Aviation:</strong> Feet used globally for altitude</li>
            </ul>

            <h3>📏 Related Conversions</h3>
            <ul>
                <li><strong>1 foot:</strong> 12 inches = 30.48 centimeters</li>
                <li><strong>1 yard:</strong> 3 feet = 0.9144 meters</li>
                <li><strong>1 mile:</strong> 5,280 feet = 1,609.34 meters</li>
                <li><strong>1 meter:</strong> 3.28084 feet ≈ 3 feet 3 inches</li>
            </ul>

            <h3>🎯 Practical Examples</h3>
            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • Apartment: 1,000 sq ft = 92.9 m²<br>
                • House: 2,500 sq ft = 232 m²<br>
                • 6-foot person = 1.83 m tall<br>
                • 10-foot ceiling = 3.05 m high<br>
                • 100-foot building = 30.48 m tall<br>
                • Mile high (5,280 ft) = 1,609 m
            </div>

            <h3>🔧 Engineering & Technical</h3>
            <ul>
                <li><strong>Precision:</strong> 1 foot = 0.3048 meters exactly (defined)</li>
                <li><strong>US customary:</strong> Based on international foot since 1959</li>
                <li><strong>Survey foot:</strong> Slightly different (1200/3937 m), deprecated</li>
                <li><strong>Technical drawings:</strong> US uses feet, world uses mm</li>
            </ul>

            <h3>📐 Historical Context</h3>
            <p>The foot has been used as a measurement since ancient times, originally based on the human foot. The modern foot was standardized in 1959 as exactly 0.3048 meters through international agreement. While most of the world has adopted the metric system, the United States continues to use feet for most everyday measurements.</p>
        </div>

        <div class="footer">
            <p>📏 Accurate Feet to Meter Conversion | ft to m</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for construction, real estate, travel, and everyday measurements</p>
        </div>
    </div>

    <script>
        function convertLength() {
            const feet = parseFloat(document.getElementById('feetInput').value);
            const resultBox = document.getElementById('resultBox');
            
            if (isNaN(feet)) {
                alert('Please enter a valid length in feet');
                return;
            }

            const meters = feet * 0.3048;
            
            document.getElementById('resultValue').textContent = meters.toFixed(4) + ' m';
            
            const stepsHTML = `
                <div class="step"><strong>Formula:</strong> m = ft × 0.3048</div>
                <div class="step"><strong>Calculation:</strong> ${feet} × 0.3048 = ${meters.toFixed(4)}</div>
                <div class="step"><strong>Result:</strong> ${feet} ft = ${meters.toFixed(4)} m</div>
            `;
            document.getElementById('resultSteps').innerHTML = stepsHTML;
            
            resultBox.classList.add('show');
        }

        function setFeet(value) {
            document.getElementById('feetInput').value = value;
            convertLength();
        }

        // Auto-convert on input
        document.getElementById('feetInput').addEventListener('input', function() {
            if (this.value) convertLength();
        });

        // Initial conversion
        convertLength();
    </script>
</body>
</html>