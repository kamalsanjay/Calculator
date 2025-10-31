<?php
/**
 * Kelvin Converter
 * File: conversion/kelvin-converter.php
 * Description: Convert Kelvin to Celsius, Fahrenheit, and Rankine
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelvin Converter - K to °C, °F, °R Calculator</title>
    <meta name="description" content="Convert Kelvin to Celsius, Fahrenheit, and Rankine. Comprehensive temperature converter for scientific calculations.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #0093E9 0%, #80D0C7 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-section { margin-bottom: 25px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 70px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #0093E9; box-shadow: 0 0 0 3px rgba(0, 147, 233, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #0093E9; font-weight: 600; font-size: 0.95rem; }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #e3f2fd 0%, #b3e5fc 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #0093E9; }
        .result-unit { color: #01579b; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-value { font-size: 1.8rem; font-weight: bold; color: #0277bd; word-wrap: break-word; }
        
        .temp-scale { background: linear-gradient(to right, #0093E9, #4CAF50, #FFC107, #FF5722); height: 30px; border-radius: 15px; margin: 25px 0; position: relative; }
        .temp-marker { position: absolute; top: -10px; width: 4px; height: 50px; background: #2c3e50; transition: left 0.3s; }
        .temp-marker::after { content: '▼'; position: absolute; top: -20px; left: 50%; transform: translateX(-50%); color: #2c3e50; font-size: 1.2rem; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #0093E9; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 147, 233, 0.15); }
        .quick-value { font-weight: bold; color: #0093E9; font-size: 1rem; }
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
        .conversion-table tr:hover { background: #e3f2fd; }
        
        .formula-box { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #0093E9; }
        .formula-box strong { color: #0093E9; }
        
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
            <h1>🌡️ Kelvin Temperature Converter</h1>
            <p>Convert Kelvin to Celsius, Fahrenheit, and Rankine - Scientific temperature scales</p>
        </div>

        <div class="converter-card">
            <div class="input-section">
                <div class="input-group">
                    <label for="kelvinInput">Temperature in Kelvin (K)</label>
                    <div class="input-wrapper">
                        <input type="number" id="kelvinInput" placeholder="Enter Kelvin" step="0.01" min="0" value="273.15">
                        <span class="unit-label">K</span>
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid">
                <div class="result-card">
                    <div class="result-unit">Celsius (°C)</div>
                    <div class="result-value" id="celsiusValue">0.00°C</div>
                </div>
                <div class="result-card">
                    <div class="result-unit">Fahrenheit (°F)</div>
                    <div class="result-value" id="fahrenheitValue">32.00°F</div>
                </div>
                <div class="result-card">
                    <div class="result-unit">Rankine (°R)</div>
                    <div class="result-value" id="rankineValue">491.67°R</div>
                </div>
            </div>

            <div class="temp-scale">
                <div class="temp-marker" id="tempMarker"></div>
            </div>

            <div class="quick-convert">
                <h3>🌡️ Important Temperature Points</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setKelvin(0)">
                        <div class="quick-value">0 K</div>
                        <div class="quick-label">Absolute Zero</div>
                    </div>
                    <div class="quick-btn" onclick="setKelvin(273.15)">
                        <div class="quick-value">273.15 K</div>
                        <div class="quick-label">Water Freezes</div>
                    </div>
                    <div class="quick-btn" onclick="setKelvin(293.15)">
                        <div class="quick-value">293.15 K</div>
                        <div class="quick-label">Room Temp</div>
                    </div>
                    <div class="quick-btn" onclick="setKelvin(310.15)">
                        <div class="quick-value">310.15 K</div>
                        <div class="quick-label">Body Temp</div>
                    </div>
                    <div class="quick-btn" onclick="setKelvin(373.15)">
                        <div class="quick-value">373.15 K</div>
                        <div class="quick-label">Water Boils</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🌡️ Kelvin Temperature Scale</h2>
            
            <p>The <strong>Kelvin (K)</strong> is the SI base unit of thermodynamic temperature. Unlike Celsius and Fahrenheit, Kelvin has no degrees symbol and starts at absolute zero, the theoretical lowest possible temperature.</p>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>Kelvin to Celsius:</strong><br>
                • °C = K - 273.15<br><br>
                <strong>Kelvin to Fahrenheit:</strong><br>
                • °F = (K - 273.15) × 9/5 + 32<br>
                • Or: °F = K × 9/5 - 459.67<br><br>
                <strong>Kelvin to Rankine:</strong><br>
                • °R = K × 9/5<br>
                • °R = K × 1.8
            </div>

            <h3>📊 Temperature Comparison Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Kelvin (K)</th>
                        <th>Celsius (°C)</th>
                        <th>Fahrenheit (°F)</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>0 K</td><td>-273.15°C</td><td>-459.67°F</td><td>Absolute zero</td></tr>
                    <tr><td>77 K</td><td>-196.15°C</td><td>-321°F</td><td>Liquid nitrogen</td></tr>
                    <tr><td>194 K</td><td>-79.15°C</td><td>-110°F</td><td>Dry ice (CO₂)</td></tr>
                    <tr><td>233 K</td><td>-40°C</td><td>-40°F</td><td>C and F meet</td></tr>
                    <tr><td>273.15 K</td><td>0°C</td><td>32°F</td><td>Water freezes</td></tr>
                    <tr><td>293.15 K</td><td>20°C</td><td>68°F</td><td>Room temperature</td></tr>
                    <tr><td>310.15 K</td><td>37°C</td><td>98.6°F</td><td>Body temperature</td></tr>
                    <tr><td>373.15 K</td><td>100°C</td><td>212°F</td><td>Water boils</td></tr>
                    <tr><td>473 K</td><td>200°C</td><td>392°F</td><td>Baking temperature</td></tr>
                    <tr><td>1811 K</td><td>1538°C</td><td>2800°F</td><td>Iron melts</td></tr>
                </tbody>
            </table>

            <h3>🔬 Scientific Applications</h3>
            <ul>
                <li><strong>Physics:</strong> Thermodynamics, gas laws, quantum mechanics</li>
                <li><strong>Chemistry:</strong> Reaction rates, equilibrium constants</li>
                <li><strong>Astronomy:</strong> Stellar temperatures, cosmic microwave background</li>
                <li><strong>Cryogenics:</strong> Study of very low temperatures</li>
                <li><strong>Material science:</strong> Phase transitions, superconductivity</li>
            </ul>

            <h3>❄️ Extreme Low Temperatures</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Temperature</th>
                        <th>Kelvin</th>
                        <th>What happens</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Absolute Zero</td><td>0 K</td><td>All molecular motion stops (theoretical)</td></tr>
                    <tr><td>Liquid Helium</td><td>4.2 K</td><td>Coldest naturally occurring liquid</td></tr>
                    <tr><td>Liquid Hydrogen</td><td>20 K</td><td>Rocket fuel temperature</td></tr>
                    <tr><td>Liquid Nitrogen</td><td>77 K</td><td>Common cryogenic coolant</td></tr>
                    <tr><td>Dry Ice</td><td>194 K</td><td>Solid CO₂ sublimation point</td></tr>
                </tbody>
            </table>

            <h3>🔥 Extreme High Temperatures</h3>
            <div class="formula-box">
                <strong>Notable High Temperatures:</strong><br>
                • Surface of Sun: 5,778 K<br>
                • Core of Sun: 15 million K<br>
                • Lightning bolt: 30,000 K<br>
                • Tungsten melting: 3,695 K<br>
                • Lava: 1,000-1,500 K<br>
                • Candle flame: 1,000-1,400 K<br>
                • Wood fire: 873 K (600°C)<br>
                • Oven (max): 533-573 K (260-300°C)
            </div>

            <h3>🌌 Astronomical Temperatures</h3>
            <ul>
                <li><strong>Cosmic microwave background:</strong> 2.7 K</li>
                <li><strong>Pluto surface:</strong> 40-50 K</li>
                <li><strong>Mars average:</strong> 210 K (-63°C)</li>
                <li><strong>Earth average:</strong> 288 K (15°C)</li>
                <li><strong>Venus surface:</strong> 735 K (462°C)</li>
                <li><strong>Mercury dayside:</strong> 700 K (427°C)</li>
            </ul>

            <h3>⚗️ Chemistry & Physics Constants</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Substance/Phenomenon</th>
                        <th>Temperature (K)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Helium boiling point</td><td>4.2 K</td></tr>
                    <tr><td>Hydrogen boiling point</td><td>20.3 K</td></tr>
                    <tr><td>Nitrogen boiling point</td><td>77.4 K</td></tr>
                    <tr><td>Oxygen boiling point</td><td>90.2 K</td></tr>
                    <tr><td>Water triple point</td><td>273.16 K (exact)</td></tr>
                    <tr><td>Mercury melting point</td><td>234 K</td></tr>
                    <tr><td>Lead melting point</td><td>600 K</td></tr>
                    <tr><td>Iron melting point</td><td>1811 K</td></tr>
                </tbody>
            </table>

            <h3>🌡️ About the Kelvin Scale</h3>
            <div class="formula-box">
                <strong>Key Facts:</strong><br>
                • Named after Lord Kelvin (William Thomson)<br>
                • SI base unit for temperature<br>
                • No degree symbol used (just K, not °K)<br>
                • Starts at absolute zero (0 K)<br>
                • Same magnitude as Celsius degree<br>
                • Used universally in science<br>
                • Water freezes at 273.15 K<br>
                • Water boils at 373.15 K
            </div>

            <h3>🔬 Gas Laws & Kelvin</h3>
            <ul>
                <li><strong>Ideal Gas Law:</strong> PV = nRT (T must be in Kelvin)</li>
                <li><strong>Charles's Law:</strong> V/T = constant (T in Kelvin)</li>
                <li><strong>Gay-Lussac's Law:</strong> P/T = constant (T in Kelvin)</li>
                <li><strong>Absolute zero:</strong> Where gas volume theoretically = 0</li>
            </ul>

            <h3>📐 Why Kelvin Starts at Zero</h3>
            <p>At absolute zero (0 K), molecules theoretically have zero kinetic energy and all motion stops. This makes Kelvin an absolute scale with no negative values, perfect for scientific calculations involving ratios and proportions.</p>

            <h3>🎯 Practical Temperature Guide</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Temperature Range</th>
                        <th>Kelvin</th>
                        <th>Celsius</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Cryogenic</td><td>< 123 K</td><td>< -150°C</td></tr>
                    <tr><td>Extremely cold</td><td>123-223 K</td><td>-150 to -50°C</td></tr>
                    <tr><td>Very cold</td><td>223-263 K</td><td>-50 to -10°C</td></tr>
                    <tr><td>Cold</td><td>263-283 K</td><td>-10 to 10°C</td></tr>
                    <tr><td>Comfortable</td><td>283-298 K</td><td>10 to 25°C</td></tr>
                    <tr><td>Warm</td><td>298-313 K</td><td>25 to 40°C</td></tr>
                    <tr><td>Hot</td><td>313-373 K</td><td>40 to 100°C</td></tr>
                    <tr><td>Very hot</td><td>> 373 K</td><td>> 100°C</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>Kelvin to Celsius (Easy):</strong><br>
                • Subtract 273<br>
                • Example: 300 K - 273 = 27°C<br>
                • Actual: 300 K = 26.85°C (very close!)<br><br>
                <strong>Celsius to Kelvin:</strong><br>
                • Add 273<br>
                • Example: 25°C + 273 = 298 K<br>
                • Actual: 25°C = 298.15 K (very close!)
            </div>

            <h3>🌡️ Rankine Scale</h3>
            <p>The <strong>Rankine scale</strong> is the Fahrenheit equivalent of Kelvin - an absolute scale starting at 0 °R (absolute zero) but with Fahrenheit-sized degrees. Primarily used in engineering in the United States.</p>

            <div class="formula-box">
                <strong>Rankine Conversions:</strong><br>
                • 0 K = 0 °R (absolute zero)<br>
                • 273.15 K = 491.67 °R (water freezes)<br>
                • 373.15 K = 671.67 °R (water boils)<br>
                • °R = K × 1.8<br>
                • K = °R / 1.8
            </div>

            <h3>🏛️ Historical Context</h3>
            <p>Lord Kelvin proposed the absolute temperature scale in 1848, based on Carnot's theorem. The Kelvin scale was redefined in 2019 by fixing the Boltzmann constant to an exact value. The degree Celsius is now defined in relation to the Kelvin.</p>

            <h3>🎓 Educational Applications</h3>
            <ul>
                <li><strong>Physics courses:</strong> Thermodynamics, statistical mechanics</li>
                <li><strong>Chemistry:</strong> Kinetic theory, reaction kinetics</li>
                <li><strong>Engineering:</strong> Heat transfer, HVAC calculations</li>
                <li><strong>Meteorology:</strong> Atmospheric temperature profiles</li>
                <li><strong>Material science:</strong> Phase diagrams, transitions</li>
            </ul>

            <h3>🔑 Key Temperature Points</h3>
            <ul>
                <li><strong>Absolute zero:</strong> 0 K = -273.15°C = -459.67°F</li>
                <li><strong>Water triple point:</strong> 273.16 K (exactly by definition)</li>
                <li><strong>Water freezing:</strong> 273.15 K = 0°C = 32°F</li>
                <li><strong>Room temperature:</strong> ~293 K = 20°C = 68°F</li>
                <li><strong>Body temperature:</strong> 310 K = 37°C = 98.6°F</li>
                <li><strong>Water boiling:</strong> 373.15 K = 100°C = 212°F</li>
            </ul>
        </div>

        <div class="footer">
            <p>🌡️ Accurate Kelvin Temperature Conversion | Scientific Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for scientific research, physics, chemistry, and engineering</p>
        </div>
    </div>

    <script>
        function convertKelvin() {
            const kelvin = parseFloat(document.getElementById('kelvinInput').value);
            
            if (isNaN(kelvin) || kelvin < 0) {
                return;
            }

            // Kelvin to Celsius
            const celsius = kelvin - 273.15;
            
            // Kelvin to Fahrenheit
            const fahrenheit = (kelvin - 273.15) * 9/5 + 32;
            
            // Kelvin to Rankine
            const rankine = kelvin * 9/5;
            
            document.getElementById('celsiusValue').textContent = celsius.toFixed(2) + '°C';
            document.getElementById('fahrenheitValue').textContent = fahrenheit.toFixed(2) + '°F';
            document.getElementById('rankineValue').textContent = rankine.toFixed(2) + '°R';
            
            updateTempMarker(kelvin);
        }

        function updateTempMarker(kelvin) {
            const marker = document.getElementById('tempMarker');
            // Map 0 to 500 K to 0-100% of scale
            let position = (kelvin / 500) * 100;
            position = Math.max(0, Math.min(100, position));
            marker.style.left = position + '%';
        }

        function setKelvin(value) {
            document.getElementById('kelvinInput').value = value;
            convertKelvin();
        }

        // Auto-convert on input
        document.getElementById('kelvinInput').addEventListener('input', convertKelvin);

        // Initial conversion
        convertKelvin();
    </script>
</body>
</html>