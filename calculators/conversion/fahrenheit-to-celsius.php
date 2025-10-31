<?php
/**
 * Fahrenheit to Celsius Converter
 * File: conversion/fahrenheit-to-celsius.php
 * Description: Convert Fahrenheit to Celsius temperature
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fahrenheit to Celsius Converter - °F to °C Calculator</title>
    <meta name="description" content="Convert Fahrenheit to Celsius instantly. Free temperature converter with formula, calculation steps, and common temperature reference points.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #5f72bd 0%, #9921e8 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 900px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-group { margin-bottom: 25px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 80px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #9921e8; box-shadow: 0 0 0 3px rgba(153, 33, 232, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #9921e8; font-weight: 600; font-size: 1.1rem; }
        
        .convert-btn { width: 100%; padding: 16px; background: linear-gradient(135deg, #5f72bd 0%, #9921e8 100%); color: white; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-bottom: 20px; }
        .convert-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(153, 33, 232, 0.4); }
        
        .result-box { background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #9921e8; margin-bottom: 25px; display: none; }
        .result-box.show { display: block; animation: slideIn 0.4s ease; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.5rem; font-weight: bold; color: #9921e8; margin-bottom: 10px; }
        .result-steps { background: white; padding: 15px; border-radius: 8px; margin-top: 15px; }
        .step { color: #555; line-height: 1.8; margin-bottom: 8px; font-family: 'Courier New', monospace; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #9921e8; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(153, 33, 232, 0.15); }
        .quick-fahrenheit { font-weight: bold; color: #9921e8; font-size: 1.1rem; }
        .quick-celsius { font-size: 0.85rem; color: #7f8c8d; margin-top: 4px; }
        
        .temp-scale { background: linear-gradient(to right, #3498db, #9b59b6, #e74c3c); height: 30px; border-radius: 15px; margin: 25px 0; position: relative; }
        .temp-marker { position: absolute; top: -10px; width: 4px; height: 50px; background: #2c3e50; transition: left 0.3s; }
        .temp-marker::after { content: '▼'; position: absolute; top: -20px; left: 50%; transform: translateX(-50%); color: #2c3e50; font-size: 1.2rem; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .formula-box { background: #f5f3ff; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #9921e8; }
        .formula-box strong { color: #9921e8; }
        
        .temp-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .temp-table th, .temp-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .temp-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .temp-table tr:hover { background: #f5f3ff; }
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
            <h1>❄️ Fahrenheit to Celsius Converter</h1>
            <p>Convert temperature from Fahrenheit (°F) to Celsius (°C) with formula and calculation steps</p>
        </div>

        <div class="converter-card">
            <div class="input-group">
                <label for="fahrenheitInput">Temperature in Fahrenheit (°F)</label>
                <div class="input-wrapper">
                    <input type="number" id="fahrenheitInput" placeholder="Enter Fahrenheit" step="0.1" value="32">
                    <span class="unit-label">°F</span>
                </div>
            </div>

            <button class="convert-btn" onclick="convertTemp()">🌡️ Convert to Celsius</button>

            <div class="result-box" id="resultBox">
                <div class="result-label">Celsius</div>
                <div class="result-value" id="resultValue">0°C</div>
                <div class="result-steps" id="resultSteps">
                    <div class="step"><strong>Formula:</strong> °C = (°F - 32) × 5/9</div>
                    <div class="step"><strong>Step 1:</strong> 32 - 32 = 0</div>
                    <div class="step"><strong>Step 2:</strong> 0 × 5/9 = 0</div>
                    <div class="step"><strong>Result:</strong> 0°C</div>
                </div>
            </div>

            <div class="temp-scale">
                <div class="temp-marker" id="tempMarker"></div>
            </div>

            <div class="quick-convert">
                <h3>⚡ Common Temperatures</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setFahrenheit(-40)">
                        <div class="quick-fahrenheit">-40°F</div>
                        <div class="quick-celsius">Extreme Cold</div>
                    </div>
                    <div class="quick-btn" onclick="setFahrenheit(32)">
                        <div class="quick-fahrenheit">32°F</div>
                        <div class="quick-celsius">Water Freezes</div>
                    </div>
                    <div class="quick-btn" onclick="setFahrenheit(68)">
                        <div class="quick-fahrenheit">68°F</div>
                        <div class="quick-celsius">Room Temp</div>
                    </div>
                    <div class="quick-btn" onclick="setFahrenheit(98.6)">
                        <div class="quick-fahrenheit">98.6°F</div>
                        <div class="quick-celsius">Body Temp</div>
                    </div>
                    <div class="quick-btn" onclick="setFahrenheit(212)">
                        <div class="quick-fahrenheit">212°F</div>
                        <div class="quick-celsius">Water Boils</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🌡️ Fahrenheit to Celsius Conversion</h2>
            
            <p>The <strong>Fahrenheit scale</strong> (°F) is primarily used in the United States, while the <strong>Celsius scale</strong> (°C) is used worldwide as part of the metric system.</p>

            <div class="formula-box">
                <strong>Conversion Formula:</strong><br>
                °C = (°F - 32) × 5/9<br>
                or<br>
                °C = (°F - 32) / 1.8
            </div>

            <h3>📊 Temperature Comparison Table</h3>
            <table class="temp-table">
                <thead>
                    <tr>
                        <th>Fahrenheit (°F)</th>
                        <th>Celsius (°C)</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="temp-cold">-40°F</td>
                        <td class="temp-cold">-40°C</td>
                        <td>Extreme cold (both scales meet)</td>
                    </tr>
                    <tr>
                        <td class="temp-cold">0°F</td>
                        <td class="temp-cold">-18°C</td>
                        <td>Very cold winter day</td>
                    </tr>
                    <tr>
                        <td>32°F</td>
                        <td class="temp-cold">0°C</td>
                        <td>Water freezing point</td>
                    </tr>
                    <tr>
                        <td>50°F</td>
                        <td>10°C</td>
                        <td>Cool day</td>
                    </tr>
                    <tr>
                        <td>68°F</td>
                        <td>20°C</td>
                        <td>Room temperature</td>
                    </tr>
                    <tr>
                        <td>77°F</td>
                        <td>25°C</td>
                        <td>Warm comfortable day</td>
                    </tr>
                    <tr>
                        <td class="temp-hot">86°F</td>
                        <td class="temp-hot">30°C</td>
                        <td>Hot summer day</td>
                    </tr>
                    <tr>
                        <td class="temp-hot">98.6°F</td>
                        <td class="temp-hot">37°C</td>
                        <td>Normal human body temperature</td>
                    </tr>
                    <tr>
                        <td class="temp-hot">104°F</td>
                        <td class="temp-hot">40°C</td>
                        <td>Extreme heat</td>
                    </tr>
                    <tr>
                        <td class="temp-hot">212°F</td>
                        <td class="temp-hot">100°C</td>
                        <td>Water boiling point</td>
                    </tr>
                </tbody>
            </table>

            <h3>🔢 How to Convert Step-by-Step</h3>
            <div class="formula-box">
                <strong>Example: Convert 77°F to Celsius</strong><br><br>
                <strong>Step 1:</strong> Subtract 32 from Fahrenheit<br>
                77 - 32 = 45<br><br>
                <strong>Step 2:</strong> Multiply by 5/9 (or divide by 1.8)<br>
                45 × 5/9 = 45 / 1.8 = 25<br><br>
                <strong>Result:</strong> 77°F = 25°C
            </div>

            <h3>🌍 About Temperature Scales</h3>
            <ul>
                <li><strong>Fahrenheit (°F):</strong> Water freezes at 32° and boils at 212°, 180 degrees apart</li>
                <li><strong>Celsius (°C):</strong> Also called Centigrade, water freezes at 0° and boils at 100°</li>
                <li><strong>Usage:</strong> Fahrenheit in US; Celsius used worldwide</li>
                <li><strong>Scientific:</strong> Kelvin is the SI base unit (0 K = -273.15°C = -459.67°F)</li>
            </ul>

            <h3>❄️ Key Temperature Points</h3>
            <ul>
                <li><strong>Absolute Zero:</strong> -459.67°F = -273.15°C (lowest possible temperature)</li>
                <li><strong>Water Freezes:</strong> 32°F = 0°C</li>
                <li><strong>Room Temperature:</strong> 68-72°F = 20-22°C</li>
                <li><strong>Body Temperature:</strong> 97.7-99.5°F = 36.5-37.5°C</li>
                <li><strong>Water Boils:</strong> 212°F = 100°C (at sea level)</li>
                <li><strong>Same Value:</strong> -40°F = -40°C (the only point where both scales meet)</li>
            </ul>

            <h3>🔥 Weather Temperature Guide</h3>
            <ul>
                <li><strong>Below 32°F (0°C):</strong> Freezing, ice forms</li>
                <li><strong>32-50°F (0-10°C):</strong> Cold, winter clothing needed</li>
                <li><strong>50-68°F (10-20°C):</strong> Cool to mild, light jacket weather</li>
                <li><strong>68-77°F (20-25°C):</strong> Comfortable, pleasant temperature</li>
                <li><strong>77-86°F (25-30°C):</strong> Warm, summer weather</li>
                <li><strong>86-95°F (30-35°C):</strong> Hot, stay hydrated</li>
                <li><strong>Above 95°F (35°C):</strong> Very hot, heat warnings possible</li>
            </ul>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>Approximate Method:</strong><br>
                1. Subtract 30 from Fahrenheit<br>
                2. Divide by 2<br>
                3. Result is close to Celsius<br><br>
                <strong>Example:</strong> 70°F → (70 - 30) / 2 = 20°C<br>
                (Actual: 21.1°C - close enough for estimation!)
            </div>

            <h3>🎯 Common Uses</h3>
            <ul>
                <li><strong>Weather Forecasts:</strong> Daily temperature reporting (US uses °F)</li>
                <li><strong>Cooking:</strong> Oven temperatures (US recipes use °F)</li>
                <li><strong>Medical:</strong> Body temperature monitoring</li>
                <li><strong>Science:</strong> International standard is Celsius</li>
                <li><strong>Travel:</strong> Understanding temperatures when visiting other countries</li>
                <li><strong>HVAC:</strong> Thermostat settings in homes</li>
            </ul>

            <h3>📏 Historical Note</h3>
            <p>Daniel Gabriel Fahrenheit created his scale in 1724, originally setting 0°F as the coldest temperature he could create with ice, water, and salt. Anders Celsius proposed his scale in 1742 for scientific use. The Fahrenheit scale remains popular in the US due to its finer gradation for weather temperatures.</p>

            <h3>🌡️ Conversion Quick Reference</h3>
            <table class="temp-table">
                <thead>
                    <tr>
                        <th>°F</th>
                        <th>°C</th>
                        <th>°F</th>
                        <th>°C</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>0°F</td><td>-18°C</td><td>60°F</td><td>16°C</td></tr>
                    <tr><td>10°F</td><td>-12°C</td><td>70°F</td><td>21°C</td></tr>
                    <tr><td>20°F</td><td>-7°C</td><td>80°F</td><td>27°C</td></tr>
                    <tr><td>30°F</td><td>-1°C</td><td>90°F</td><td>32°C</td></tr>
                    <tr><td>40°F</td><td>4°C</td><td>100°F</td><td>38°C</td></tr>
                    <tr><td>50°F</td><td>10°C</td><td>110°F</td><td>43°C</td></tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>❄️ Accurate Fahrenheit to Celsius Conversion | °F to °C</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Weather, cooking, and everyday temperature conversions</p>
        </div>
    </div>

    <script>
        function convertTemp() {
            const fahrenheit = parseFloat(document.getElementById('fahrenheitInput').value);
            const resultBox = document.getElementById('resultBox');
            
            if (isNaN(fahrenheit)) {
                alert('Please enter a valid temperature in Fahrenheit');
                return;
            }

            const celsius = (fahrenheit - 32) * 5/9;
            const step1 = fahrenheit - 32;
            
            document.getElementById('resultValue').textContent = celsius.toFixed(1) + '°C';
            
            const stepsHTML = `
                <div class="step"><strong>Formula:</strong> °C = (°F - 32) × 5/9</div>
                <div class="step"><strong>Step 1:</strong> ${fahrenheit} - 32 = ${step1.toFixed(2)}</div>
                <div class="step"><strong>Step 2:</strong> ${step1.toFixed(2)} × 5/9 = ${celsius.toFixed(1)}</div>
                <div class="step"><strong>Result:</strong> ${fahrenheit}°F = ${celsius.toFixed(1)}°C</div>
            `;
            document.getElementById('resultSteps').innerHTML = stepsHTML;
            
            resultBox.classList.add('show');
            updateTempMarker(fahrenheit);
        }

        function updateTempMarker(fahrenheit) {
            const marker = document.getElementById('tempMarker');
            // Map 0 to 120°F to 0-100% of scale
            let position = (fahrenheit / 120) * 100;
            position = Math.max(0, Math.min(100, position));
            marker.style.left = position + '%';
        }

        function setFahrenheit(value) {
            document.getElementById('fahrenheitInput').value = value;
            convertTemp();
        }

        // Auto-convert on input
        document.getElementById('fahrenheitInput').addEventListener('input', function() {
            if (this.value) convertTemp();
        });

        // Initial conversion
        convertTemp();
    </script>
</body>
</html>