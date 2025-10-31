<?php
/**
 * Temperature Converter
 * File: conversion/temperature-converter.php
 * Description: Convert between temperature units including Celsius, Fahrenheit, Kelvin, and more
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temperature Converter - Thermal Unit Conversion Calculator</title>
    <meta name="description" content="Convert between temperature units: Celsius, Fahrenheit, Kelvin, Rankine, and more. Essential for cooking, science, weather, and industrial applications.">
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
        
        .common-temps { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .common-temps h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        
        .temp-scale { background: linear-gradient(180deg, #0000ff 0%, #00ffff 25%, #00ff00 50%, #ffff00 75%, #ff0000 100%); padding: 20px; border-radius: 10px; margin: 20px 0; color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.5); }
        .temp-scale h3 { color: white; margin-bottom: 15px; }
        
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
        
        .weather-box { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #2196f3; }
        
        .cooking-box { background: #fff3e0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff9800; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .temp-highlight { background: #ffeb3b; padding: 3px 6px; border-radius: 4px; font-weight: bold; }
        
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
            <h1>🌡️ Temperature Converter</h1>
            <p>Convert between temperature units: Celsius, Fahrenheit, Kelvin, Rankine, and more. Essential for cooking, science, weather, and industrial applications.</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="20">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="c" selected>Celsius (°C)</option>
                        <option value="f">Fahrenheit (°F)</option>
                        <option value="k">Kelvin (K)</option>
                        <option value="r">Rankine (°R)</option>
                        <option value="del">Delisle (°De)</option>
                        <option value="new">Newton (°N)</option>
                        <option value="rea">Réaumur (°Ré)</option>
                        <option value="rom">Rømer (°Rø)</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="c">Celsius (°C)</option>
                        <option value="f" selected>Fahrenheit (°F)</option>
                        <option value="k">Kelvin (K)</option>
                        <option value="r">Rankine (°R)</option>
                        <option value="del">Delisle (°De)</option>
                        <option value="new">Newton (°N)</option>
                        <option value="rea">Réaumur (°Ré)</option>
                        <option value="rom">Rømer (°Rø)</option>
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
                    <div class="quick-btn" onclick="setInput(0)">
                        <div class="quick-value">0°C</div>
                        <div class="quick-label">Freezing</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(100)">
                        <div class="quick-value">100°C</div>
                        <div class="quick-label">Boiling</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(20)">
                        <div class="quick-value">20°C</div>
                        <div class="quick-label">Room Temp</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(37)">
                        <div class="quick-value">37°C</div>
                        <div class="quick-label">Body Temp</div>
                    </div>
                </div>
            </div>

            <div class="common-temps">
                <h3>🎯 Common Temperature Values</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setCommonTemp(-40, 'Temperature where Celsius and Fahrenheit are equal')">
                        <div class="quick-value">-40°</div>
                        <div class="quick-label">C=F Point</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonTemp(0, 'Water freezing point')">
                        <div class="quick-value">0°C</div>
                        <div class="quick-label">Freezing</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonTemp(100, 'Water boiling point at sea level')">
                        <div class="quick-value">100°C</div>
                        <div class="quick-label">Boiling</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonTemp(273.15, 'Absolute zero in Celsius')">
                        <div class="quick-value">273.15K</div>
                        <div class="quick-label">0°C in K</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🌡️ Temperature Unit Conversion</h2>
            
            <p>Convert between temperature units used worldwide for weather, cooking, science, medicine, and industrial applications.</p>

            <div class="temp-scale">
                <h3>📊 Temperature Scale Visualization</h3>
                <p><strong>Blue (Cold) ← → Red (Hot)</strong></p>
                <p>Absolute Zero (-273°C) • Freezing (0°C) • Room Temp (20°C) • Body Temp (37°C) • Boiling (100°C) • Sun Surface (5,500°C)</p>
            </div>

            <h3>📊 Key Temperature Scales</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Scale</th>
                        <th>Symbol</th>
                        <th>Freezing Point</th>
                        <th>Boiling Point</th>
                        <th>Absolute Zero</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Celsius</td><td>°C</td><td>0°C</td><td>100°C</td><td>-273.15°C</td></tr>
                    <tr><td>Fahrenheit</td><td>°F</td><td>32°F</td><td>212°F</td><td>-459.67°F</td></tr>
                    <tr><td>Kelvin</td><td>K</td><td>273.15K</td><td>373.15K</td><td>0K</td></tr>
                    <tr><td>Rankine</td><td>°R</td><td>491.67°R</td><td>671.67°R</td><td>0°R</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Conversion Formulas:</strong><br>
                • <strong>Celsius to Fahrenheit:</strong> °F = (°C × 9/5) + 32<br>
                • <strong>Fahrenheit to Celsius:</strong> °C = (°F - 32) × 5/9<br>
                • <strong>Celsius to Kelvin:</strong> K = °C + 273.15<br>
                • <strong>Kelvin to Celsius:</strong> °C = K - 273.15<br>
                • <strong>Fahrenheit to Kelvin:</strong> K = (°F + 459.67) × 5/9<br>
                • <strong>Kelvin to Fahrenheit:</strong> °F = (K × 9/5) - 459.67
            </div>

            <h3>🌤️ Weather & Environment</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Temperature</th>
                        <th>Celsius</th>
                        <th>Fahrenheit</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Extreme cold</td><td>-40°C</td><td>-40°F</td><td>Dangerously cold</td></tr>
                    <tr><td>Freezing</td><td>0°C</td><td>32°F</td><td>Water freezes</td></tr>
                    <tr><td>Cold</td><td>5°C</td><td>41°F</td><td>Winter jacket weather</td></tr>
                    <tr><td>Cool</td><td>15°C</td><td>59°F</td><td>Light sweater weather</td></tr>
                    <tr><td>Room temperature</td><td>20-22°C</td><td>68-72°F</td><td>Comfortable indoor</td></tr>
                    <tr><td>Warm</td><td>25°C</td><td>77°F</td><td>Pleasant summer day</td></tr>
                    <tr><td>Hot</td><td>30°C</td><td>86°F</td><td>Summer heat</td></tr>
                    <tr><td>Very hot</td><td>35°C</td><td>95°F</td><td>Heat wave</td></tr>
                    <tr><td>Extreme heat</td><td>40°C</td><td>104°F</td><td>Dangerously hot</td></tr>
                </tbody>
            </table>

            <div class="weather-box">
                <strong>🌡️ Human Comfort Ranges:</strong><br>
                • <span class="temp-highlight">Comfort zone:</span> 18-24°C (65-75°F)<br>
                • <span class="temp-highlight">Sleep comfort:</span> 16-20°C (60-68°F)<br>
                • <span class="temp-highlight">Office comfort:</span> 20-22°C (68-72°F)<br>
                • <span class="temp-highlight">Heat stress begins:</span> 32°C (90°F) with humidity<br>
                • <span class="temp-highlight">Cold stress begins:</span> 10°C (50°F) without protection
            </div>

            <h3>🍳 Cooking & Food Safety</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Temperature</th>
                        <th>Celsius</th>
                        <th>Fahrenheit</th>
                        <th>Purpose</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Freezer</td><td>-18°C</td><td>0°F</td><td>Food preservation</td></tr>
                    <tr><td>Refrigerator</td><td>4°C</td><td>40°F</td><td>Food storage</td></tr>
                    <tr><td>Danger zone</td><td>4-60°C</td><td>40-140°F</td><td>Bacteria growth</td></tr>
                    <tr><td>Simmer</td><td>85-95°C</td><td>185-203°F</td><td>Gentle cooking</td></tr>
                    <tr><td>Boiling water</td><td>100°C</td><td>212°F</td><td>Sea level boiling</td></tr>
                    <tr><td>Oven (low)</td><td>150°C</td><td>300°F</td><td>Slow baking</td></tr>
                    <tr><td>Oven (medium)</td><td>180°C</td><td>350°F</td><td>Most baking</td></tr>
                    <tr><td>Oven (hot)</td><td>220°C</td><td>425°F</td><td>Pizza, roasting</td></tr>
                    <tr><td>Oven (very hot)</td><td>240°C</td><td>475°F</td><td>Broiling</td></tr>
                </tbody>
            </table>

            <div class="cooking-box">
                <strong>🔥 Oven Temperature Guide:</strong><br>
                • <span class="temp-highlight">Very slow:</span> 120°C / 250°F<br>
                • <span class="temp-highlight">Slow:</span> 150°C / 300°F<br>
                • <span class="temp-highlight">Moderately slow:</span> 160°C / 325°F<br>
                • <span class="temp-highlight">Moderate:</span> 180°C / 350°F<br>
                • <span class="temp-highlight">Moderately hot:</span> 190°C / 375°F<br>
                • <span class="temp-highlight">Hot:</span> 200°C / 400°F<br>
                • <span class="temp-highlight">Very hot:</span> 230°C / 450°F
            </div>

            <h3>⚕️ Medical & Biological</h3>
            <ul>
                <li><strong>Human body temperature:</strong> 36.5-37.5°C (97.7-99.5°F) normal range</li>
                <li><strong>Fever:</strong> >38°C (100.4°F) clinically significant</li>
                <li><strong>Hypothermia:</strong> <35°C (95°F) begins, <32°C (89.6°F) severe</li>
                <li><strong>Hyperthermia:</strong> >40°C (104°F) dangerous</li>
                <li><strong>Hot bath comfort:</strong> 38-40°C (100-104°F)</li>
                <li><strong>Cold therapy:</strong> 10-15°C (50-59°F) for inflammation</li>
            </ul>

            <h3>🔬 Scientific & Industrial</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Temperature</th>
                        <th>Celsius</th>
                        <th>Kelvin</th>
                        <th>Context</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Absolute zero</td><td>-273.15°C</td><td>0K</td><td>Theoretical minimum</td></tr>
                    <tr><td>Liquid nitrogen</td><td>-196°C</td><td>77K</td><td>Cryogenic storage</td></tr>
                    <tr><td>Dry ice sublimation</td><td>-78.5°C</td><td>194.7K</td><td>Solid CO₂</td></tr>
                    <tr><td>Standard conditions</td><td>0°C</td><td>273.15K</td><td>STP reference</td></tr>
                    <tr><td>Room temperature</td><td>20°C</td><td>293.15K</td><td>Scientific standard</td></tr>
                    <tr><td>Human body</td><td>37°C</td><td>310.15K</td><td>Medical reference</td></tr>
                    <tr><td>Water boils</td><td>100°C</td><td>373.15K</td><td>Sea level</td></tr>
                    <tr><td>Pizza oven</td><td>260-315°C</td><td>533-588K</td><td>Wood-fired</td></tr>
                    <tr><td>Steel melting</td><td>1,370-1,510°C</td><td>1,643-1,783K</td><td>Industrial</td></tr>
                </tbody>
            </table>

            <h3>🌍 Natural Phenomena</h3>
            <div class="formula-box">
                <strong>Extreme Temperatures in Nature:</strong><br>
                • <span class="temp-highlight">Coldest inhabited:</span> Oymyakon, Russia: -67.7°C (-89.9°F)<br>
                • <span class="temp-highlight">Hottest inhabited:</span> Death Valley, USA: 56.7°C (134.1°F)<br>
                • <span class="temp-highlight">Coldest natural:</span> Antarctica: -89.2°C (-128.6°F)<br>
                • <span class="temp-highlight">Lightning bolt:</span> 30,000°C (54,000°F)<br>
                • <span class="temp-highlight">Sun surface:</span> 5,500°C (9,900°F)<br>
                • <span class="temp-highlight">Sun core:</span> 15,000,000°C (27,000,000°F)
            </div>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>Celsius ↔ Fahrenheit:</strong><br>
                • Double Celsius, add 30 for rough Fahrenheit: °F ≈ (°C × 2) + 30<br>
                • Subtract 30 from Fahrenheit, halve for rough Celsius: °C ≈ (°F - 30) ÷ 2<br><br>
                <strong>Exact method:</strong><br>
                • °C to °F: Multiply by 2, subtract 10%, add 32<br>
                • °F to °C: Subtract 32, add 10%, divide by 2
            </div>

            <h3>🌎 Regional Standards</h3>
            <ul>
                <li><strong>United States:</strong> Primarily uses Fahrenheit for weather and cooking</li>
                <li><strong>Canada:</strong> Mixed usage (Celsius for weather, Fahrenheit for cooking)</li>
                <li><strong>United Kingdom:</strong> Mixed usage (Celsius for weather, Fahrenheit for cooking in older generations)</li>
                <li><strong>Europe:</strong> Exclusively Celsius for all applications</li>
                <li><strong>Scientific worldwide:</strong> Celsius and Kelvin (SI units)</li>
                <li><strong>Medical worldwide:</strong> Celsius for clinical measurements</li>
            </ul>

            <h3>⚖️ Historical Context</h3>
            <p>The <strong>Celsius scale</strong> was developed by Anders Celsius in 1742, originally with 0° as boiling and 100° as freezing (later reversed). The <strong>Fahrenheit scale</strong> was created by Daniel Fahrenheit in 1724, based on three fixed points. The <strong>Kelvin scale</strong> was developed by Lord Kelvin in 1848 as an absolute thermodynamic temperature scale. The <strong>Rankine scale</strong> is the Fahrenheit equivalent of Kelvin.</p>

            <h3>🔧 Temperature Measurement</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Measurement Tool</th>
                        <th>Typical Range</th>
                        <th>Applications</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Mercury thermometer</td><td>-39 to 357°C</td><td>Medical, weather</td></tr>
                    <tr><td>Digital thermometer</td><td>-50 to 300°C</td><td>General purpose</td></tr>
                    <tr><td>Infrared thermometer</td><td>-50 to 3000°C</td><td>Non-contact measurement</td></tr>
                    <tr><td>Thermocouple</td><td>-200 to 2300°C</td><td>Industrial, scientific</td></tr>
                    <tr><td>RTD</td><td>-200 to 850°C</td><td>Precision measurement</td></tr>
                    <tr><td>Thermistor</td><td>-100 to 300°C</td><td>Electronic devices</td></tr>
                </tbody>
            </table>

            <h3>🎯 Key Conversions to Remember</h3>
            <ul>
                <li><strong>Water freezes:</strong> 0°C = 32°F = 273.15K</li>
                <strong>Water boils:</strong> 100°C = 212°F = 373.15K</li>
                <li><strong>Absolute zero:</strong> -273.15°C = -459.67°F = 0K</li>
                <li><strong>Human body temperature:</strong> 37°C = 98.6°F = 310.15K</li>
                <li><strong>Room temperature:</strong> 20°C = 68°F = 293.15K</li>
                <li><strong>Celsius-Fahrenheit equal:</strong> -40°C = -40°F</li>
            </ul>
        </div>

        <div class="footer">
            <p>🌡️ Temperature Converter | Complete Temperature Unit Conversion</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert Celsius, Fahrenheit, Kelvin, Rankine, and other temperature units with precision</p>
        </div>
    </div>

    <script>
        // Temperature conversion functions
        function celsiusToFahrenheit(c) {
            return (c * 9/5) + 32;
        }

        function fahrenheitToCelsius(f) {
            return (f - 32) * 5/9;
        }

        function celsiusToKelvin(c) {
            return c + 273.15;
        }

        function kelvinToCelsius(k) {
            return k - 273.15;
        }

        function celsiusToRankine(c) {
            return (c + 273.15) * 9/5;
        }

        function rankineToCelsius(r) {
            return (r - 491.67) * 5/9;
        }

        function celsiusToDelisle(c) {
            return (100 - c) * 3/2;
        }

        function delisleToCelsius(d) {
            return 100 - d * 2/3;
        }

        function celsiusToNewton(c) {
            return c * 33/100;
        }

        function newtonToCelsius(n) {
            return n * 100/33;
        }

        function celsiusToReaumur(c) {
            return c * 4/5;
        }

        function reaumurToCelsius(r) {
            return r * 5/4;
        }

        function celsiusToRomer(c) {
            return c * 21/40 + 7.5;
        }

        function romerToCelsius(r) {
            return (r - 7.5) * 40/21;
        }

        const unitNames = {
            c: 'Celsius (°C)',
            f: 'Fahrenheit (°F)',
            k: 'Kelvin (K)',
            r: 'Rankine (°R)',
            del: 'Delisle (°De)',
            new: 'Newton (°N)',
            rea: 'Réaumur (°Ré)',
            rom: 'Rømer (°Rø)'
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

            // Convert to Celsius first (as our base unit)
            let valueInCelsius;
            switch (fromUnit) {
                case 'c': valueInCelsius = inputValue; break;
                case 'f': valueInCelsius = fahrenheitToCelsius(inputValue); break;
                case 'k': valueInCelsius = kelvinToCelsius(inputValue); break;
                case 'r': valueInCelsius = rankineToCelsius(inputValue); break;
                case 'del': valueInCelsius = delisleToCelsius(inputValue); break;
                case 'new': valueInCelsius = newtonToCelsius(inputValue); break;
                case 'rea': valueInCelsius = reaumurToCelsius(inputValue); break;
                case 'rom': valueInCelsius = romerToCelsius(inputValue); break;
                default: valueInCelsius = inputValue;
            }

            // Convert from Celsius to target unit
            let result;
            switch (toUnit) {
                case 'c': result = valueInCelsius; break;
                case 'f': result = celsiusToFahrenheit(valueInCelsius); break;
                case 'k': result = celsiusToKelvin(valueInCelsius); break;
                case 'r': result = celsiusToRankine(valueInCelsius); break;
                case 'del': result = celsiusToDelisle(valueInCelsius); break;
                case 'new': result = celsiusToNewton(valueInCelsius); break;
                case 'rea': result = celsiusToReaumur(valueInCelsius); break;
                case 'rom': result = celsiusToRomer(valueInCelsius); break;
                default: result = valueInCelsius;
            }
            
            document.getElementById('outputValue').value = formatNumber(result);
            
            displayAllConversions(valueInCelsius);
        }

        function displayAllConversions(valueInCelsius) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                let converted;
                switch (unit) {
                    case 'c': converted = valueInCelsius; break;
                    case 'f': converted = celsiusToFahrenheit(valueInCelsius); break;
                    case 'k': converted = celsiusToKelvin(valueInCelsius); break;
                    case 'r': converted = celsiusToRankine(valueInCelsius); break;
                    case 'del': converted = celsiusToDelisle(valueInCelsius); break;
                    case 'new': converted = celsiusToNewton(valueInCelsius); break;
                    case 'rea': converted = celsiusToReaumur(valueInCelsius); break;
                    case 'rom': converted = celsiusToRomer(valueInCelsius); break;
                    default: converted = valueInCelsius;
                }
                
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
            if (Math.abs(num) < 0.01) {
                return num.toFixed(8);
            }
            if (Math.abs(num) < 1) {
                return num.toFixed(6);
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

        function setCommonTemp(value, description) {
            document.getElementById('inputValue').value = value;
            document.getElementById('fromUnit').value = 'c';
            document.getElementById('toUnit').value = 'f';
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