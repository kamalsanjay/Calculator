<?php
/**
 * Celsius to Fahrenheit Converter
 * File: conversion/celsius-to-fahrenheit.php
 * Description: Convert Celsius to Fahrenheit temperature
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Celsius to Fahrenheit Converter - °C to °F Calculator</title>
    <meta name="description" content="Convert Celsius to Fahrenheit instantly. Free temperature converter with formula, calculation steps, and common temperature reference points.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 900px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-group { margin-bottom: 25px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 80px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #ff6b6b; box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #ff6b6b; font-weight: 600; font-size: 1.1rem; }
        
        .convert-btn { width: 100%; padding: 16px; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%); color: white; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-bottom: 20px; }
        .convert-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4); }
        
        .result-box { background: linear-gradient(135deg, #fff5f5 0%, #ffe9e9 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #ff6b6b; margin-bottom: 25px; display: none; }
        .result-box.show { display: block; animation: slideIn 0.4s ease; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.5rem; font-weight: bold; color: #ff6b6b; margin-bottom: 10px; }
        .result-steps { background: white; padding: 15px; border-radius: 8px; margin-top: 15px; }
        .step { color: #555; line-height: 1.8; margin-bottom: 8px; font-family: 'Courier New', monospace; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #ff6b6b; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255, 107, 107, 0.15); }
        .quick-celsius { font-weight: bold; color: #ff6b6b; font-size: 1.1rem; }
        .quick-fahrenheit { font-size: 0.85rem; color: #7f8c8d; margin-top: 4px; }
        
        .temp-scale { background: linear-gradient(to right, #3498db, #9b59b6, #e74c3c); height: 30px; border-radius: 15px; margin: 25px 0; position: relative; }
        .temp-marker { position: absolute; top: -10px; width: 4px; height: 50px; background: #2c3e50; transition: left 0.3s; }
        .temp-marker::after { content: '▼'; position: absolute; top: -20px; left: 50%; transform: translateX(-50%); color: #2c3e50; font-size: 1.2rem; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .formula-box { background: #fff5f5; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff6b6b; }
        .formula-box strong { color: #ff6b6b; }
        
        .temp-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .temp-table th, .temp-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .temp-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .temp-table tr:hover { background: #fff5f5; }
        .temp-hot { color: #e74c3c; font-weight: 600; }
        .temp-cold { color: #3498db; font-weight: 600; }
        
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
            <h1>🔥 Celsius to Fahrenheit Converter</h1>
            <p>Convert temperature from Celsius (°C) to Fahrenheit (°F) with formula and calculation steps</p>
        </div>

        <div class="converter-card">
            <div class="input-group">
                <label for="celsiusInput">Temperature in Celsius (°C)</label>
                <div class="input-wrapper">
                    <input type="number" id="celsiusInput" placeholder="Enter Celsius" step="0.1" value="0">
                    <span class="unit-label">°C</span>
                </div>
            </div>

            <button class="convert-btn" onclick="convertTemp()">🌡️ Convert to Fahrenheit</button>

            <div class="result-box" id="resultBox">
                <div class="result-label">Fahrenheit</div>
                <div class="result-value" id="resultValue">32°F</div>
                <div class="result-steps" id="resultSteps">
                    <div class="step"><strong>Formula:</strong> °F = (°C × 9/5) + 32</div>
                    <div class="step"><strong>Step 1:</strong> 0 × 9/5 = 0</div>
                    <div class="step"><strong>Step 2:</strong> 0 + 32 = 32</div>
                    <div class="step"><strong>Result:</strong> 32°F</div>
                </div>
            </div>

            <div class="temp-scale">
                <div class="temp-marker" id="tempMarker"></div>
            </div>

            <div class="quick-convert">
                <h3>⚡ Common Temperatures</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setCelsius(-40)">
                        <div class="quick-celsius">-40°C</div>
                        <div class="quick-fahrenheit">Extreme Cold</div>
                    </div>
                    <div class="quick-btn" onclick="setCelsius(0)">
                        <div class="quick-celsius">0°C</div>
                        <div class="quick-fahrenheit">Water Freezes</div>
                    </div>
                    <div class="quick-btn" onclick="setCelsius(20)">
                        <div class="quick-celsius">20°C</div>
                        <div class="quick-fahrenheit">Room Temp</div>
                    </div>
                    <div class="quick-btn" onclick="setCelsius(37)">
                        <div class="quick-celsius">37°C</div>
                        <div class="quick-fahrenheit">Body Temp</div>
                    </div>
                    <div class="quick-btn" onclick="setCelsius(100)">
                        <div class="quick-celsius">100°C</div>
                        <div class="quick-fahrenheit">Water Boils</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🌡️ Celsius to Fahrenheit Conversion</h2>
            
            <p>The <strong>Celsius scale</strong> (°C) and <strong>Fahrenheit scale</strong> (°F) are two common temperature measurement systems. The Celsius scale is used worldwide (metric system), while Fahrenheit is primarily used in the United States.</p>

            <div class="formula-box">
                <strong>Conversion Formula:</strong><br>
                °F = (°C × 9/5) + 32<br>
                or<br>
                °F = (°C × 1.8) + 32
            </div>

            <h3>📊 Temperature Comparison Table</h3>
            <table class="temp-table">
                <thead>
                    <tr>
                        <th>Celsius (°C)</th>
                        <th>Fahrenheit (°F)</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="temp-cold">-40°C</td>
                        <td class="temp-cold">-40°F</td>
                        <td>Extreme cold (both scales meet)</td>
                    </tr>
                    <tr>
                        <td class="temp-cold">-18°C</td>
                        <td class="temp-cold">0°F</td>
                        <td>Very cold winter day</td>
                    </tr>
                    <tr>
                        <td class="temp-cold">0°C</td>
                        <td>32°F</td>
                        <td>Water freezing point</td>
                    </tr>
                    <tr>
                        <td>10°C</td>
                        <td>50°F</td>
                        <td>Cool day</td>
                    </tr>
                    <tr>
                        <td>20°C</td>
                        <td>68°F</td>
                        <td>Room temperature</td>
                    </tr>
                    <tr>
                        <td>25°C</td>
                        <td>77°F</td>
                        <td>Warm comfortable day</td>
                    </tr>
                    <tr>
                        <td class="temp-hot">30°C</td>
                        <td class="temp-hot">86°F</td>
                        <td>Hot summer day</td>
                    </tr>
                    <tr>
                        <td class="temp-hot">37°C</td>
                        <td class="temp-hot">98.6°F</td>
                        <td>Normal human body temperature</td>
                    </tr>
                    <tr>
                        <td class="temp-hot">40°C</td>
                        <td class="temp-hot">104°F</td>
                        <td>Extreme heat</td>
                    </tr>
                    <tr>
                        <td class="temp-hot">100°C</td>
                        <td class="temp-hot">212°F</td>
                        <td>Water boiling point</td>
                    </tr>
                </tbody>
            </table>

            <h3>🔢 How to Convert Step-by-Step</h3>
            <div class="formula-box">
                <strong>Example: Convert 25°C to Fahrenheit</strong><br><br>
                <strong>Step 1:</strong> Multiply Celsius by 9/5 (or 1.8)<br>
                25 × 9/5 = 25 × 1.8 = 45<br><br>
                <strong>Step 2:</strong> Add 32 to the result<br>
                45 + 32 = 77<br><br>
                <strong>Result:</strong> 25°C = 77°F
            </div>

            <h3>🌍 About Temperature Scales</h3>
            <ul>
                <li><strong>Celsius (°C):</strong> Also called Centigrade, based on water freezing at 0° and boiling at 100°</li>
                <li><strong>Fahrenheit (°F):</strong> Water freezes at 32° and boils at 212°, 180 degrees apart</li>
                <li><strong>Usage:</strong> Celsius is used worldwide; Fahrenheit in US, Bahamas, Cayman Islands, Palau</li>
                <li><strong>Scientific:</strong> Kelvin is the SI base unit (0 K = -273.15°C)</li>
            </ul>

            <h3>❄️ Key Temperature Points</h3>
            <ul>
                <li><strong>Absolute Zero:</strong> -273.15°C = -459.67°F (lowest possible temperature)</li>
                <li><strong>Water Freezes:</strong> 0°C = 32°F</li>
                <li><strong>Room Temperature:</strong> 20-22°C = 68-72°F</li>
                <li><strong>Body Temperature:</strong> 36.5-37.5°C = 97.7-99.5°F</li>
                <li><strong>Water Boils:</strong> 100°C = 212°F (at sea level)</li>
                <li><strong>Same Value:</strong> -40°C = -40°F (the only point where both scales meet)</li>
            </ul>

            <h3>🔥 Weather Temperature Guide</h3>
            <ul>
                <li><strong>Below 0°C (32°F):</strong> Freezing, ice forms</li>
                <li><strong>0-10°C (32-50°F):</strong> Cold, winter clothing needed</li>
                <li><strong>10-20°C (50-68°F):</strong> Cool to mild, light jacket weather</li>
                <li><strong>20-25°C (68-77°F):</strong> Comfortable, pleasant temperature</li>
                <li><strong>25-30°C (77-86°F):</strong> Warm, summer weather</li>
                <li><strong>30-35°C (86-95°F):</strong> Hot, stay hydrated</li>
                <li><strong>Above 35°C (95°F):</strong> Very hot, heat warnings possible</li>
            </ul>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>Approximate Method:</strong><br>
                1. Double the Celsius temperature<br>
                2. Add 30<br>
                3. Result is close to Fahrenheit<br><br>
                <strong>Example:</strong> 20°C → (20 × 2) + 30 = 70°F<br>
                (Actual: 68°F - close enough for estimation!)
            </div>

            <h3>🎯 Common Uses</h3>
            <ul>
                <li><strong>Weather Forecasts:</strong> Daily temperature reporting</li>
                <li><strong>Cooking:</strong> Oven temperatures (especially US recipes)</li>
                <li><strong>Medical:</strong> Body temperature monitoring</li>
                <li><strong>Science:</strong> Laboratory experiments and research</li>
                <li><strong>Travel:</strong> Understanding temperatures in different countries</li>
                <li><strong>HVAC:</strong> Heating and cooling system settings</li>
            </ul>

            <h3>📏 Historical Note</h3>
            <p>Daniel Gabriel Fahrenheit created his scale in 1724, using the freezing point of brine as 0°F. Anders Celsius proposed his scale in 1742, originally with 100° for freezing and 0° for boiling (later reversed to current standard).</p>
        </div>

        <div class="footer">
            <p>🔥 Accurate Celsius to Fahrenheit Conversion | °C to °F</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Weather, cooking, and everyday temperature conversions</p>
        </div>
    </div>

    <script>
        function convertTemp() {
            const celsius = parseFloat(document.getElementById('celsiusInput').value);
            const resultBox = document.getElementById('resultBox');
            
            if (isNaN(celsius)) {
                alert('Please enter a valid temperature in Celsius');
                return;
            }

            const fahrenheit = (celsius * 9/5) + 32;
            const step1 = celsius * 9/5;
            
            document.getElementById('resultValue').textContent = fahrenheit.toFixed(1) + '°F';
            
            const stepsHTML = `
                <div class="step"><strong>Formula:</strong> °F = (°C × 9/5) + 32</div>
                <div class="step"><strong>Step 1:</strong> ${celsius} × 9/5 = ${step1.toFixed(2)}</div>
                <div class="step"><strong>Step 2:</strong> ${step1.toFixed(2)} + 32 = ${fahrenheit.toFixed(1)}</div>
                <div class="step"><strong>Result:</strong> ${celsius}°C = ${fahrenheit.toFixed(1)}°F</div>
            `;
            document.getElementById('resultSteps').innerHTML = stepsHTML;
            
            resultBox.classList.add('show');
            updateTempMarker(celsius);
        }

        function updateTempMarker(celsius) {
            const marker = document.getElementById('tempMarker');
            // Map -20 to 50°C to 0-100% of scale
            let position = ((celsius + 20) / 70) * 100;
            position = Math.max(0, Math.min(100, position));
            marker.style.left = position + '%';
        }

        function setCelsius(value) {
            document.getElementById('celsiusInput').value = value;
            convertTemp();
        }

        // Auto-convert on input
        document.getElementById('celsiusInput').addEventListener('input', function() {
            if (this.value) convertTemp();
        });

        // Initial conversion
        convertTemp();
    </script>
</body>
</html>