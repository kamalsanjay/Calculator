<?php
/**
 * Gallons to Liters Converter
 * File: conversion/gallons-to-liters.php
 * Description: Convert gallons to liters and liters to gallons
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallons to Liters Converter - Bidirectional Volume Calculator</title>
    <meta name="description" content="Convert gallons to liters and liters to gallons instantly. Supports US gallons, UK gallons with accurate conversion.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 950px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .gallon-type-selector { display: flex; gap: 10px; margin-bottom: 25px; padding: 15px; background: #f8f9fa; border-radius: 10px; }
        .gallon-type-btn { flex: 1; padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; font-weight: 600; }
        .gallon-type-btn.active { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-color: #38f9d7; }
        .gallon-type-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(56, 249, 215, 0.2); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 70px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #38f9d7; box-shadow: 0 0 0 3px rgba(56, 249, 215, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #38f9d7; font-weight: 600; font-size: 0.95rem; }
        
        .swap-btn { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-box { background: linear-gradient(135deg, #e8f8f5 0%, #d1f2eb 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #38f9d7; margin-bottom: 25px; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.5rem; font-weight: bold; color: #38f9d7; margin-bottom: 10px; }
        .result-formula { background: white; padding: 15px; border-radius: 8px; font-family: 'Courier New', monospace; color: #555; font-size: 0.9rem; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #38f9d7; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(56, 249, 215, 0.15); }
        .quick-value { font-weight: bold; color: #38f9d7; font-size: 1.1rem; }
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
        .conversion-table tr:hover { background: #e8f8f5; }
        
        .formula-box { background: #e8f8f5; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #38f9d7; }
        .formula-box strong { color: #38f9d7; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .converter-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .header h1 { font-size: 1.5rem; }
            .result-value { font-size: 2rem; }
            .gallon-type-selector { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💧 Gallons ⇄ Liters Converter</h1>
            <p>Convert between gallons and liters with bidirectional conversion - US and UK gallons supported</p>
        </div>

        <div class="converter-card">
            <div class="gallon-type-selector">
                <button class="gallon-type-btn active" onclick="selectGallonType('us', this)">
                    US Gallon<br><span style="font-size: 0.8rem; font-weight: 400;">3.78541 L</span>
                </button>
                <button class="gallon-type-btn" onclick="selectGallonType('uk', this)">
                    UK Gallon<br><span style="font-size: 0.8rem; font-weight: 400;">4.54609 L</span>
                </button>
            </div>

            <div class="converter-row">
                <div class="input-group">
                    <label for="gallonsInput">Gallons</label>
                    <div class="input-wrapper">
                        <input type="number" id="gallonsInput" placeholder="Enter gallons" step="0.01" min="0" value="1">
                        <span class="unit-label">gal</span>
                    </div>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="litersInput">Liters</label>
                    <div class="input-wrapper">
                        <input type="number" id="litersInput" placeholder="Enter liters" step="0.01" min="0">
                        <span class="unit-label">L</span>
                    </div>
                </div>
            </div>

            <div class="result-box">
                <div class="result-label">Result</div>
                <div class="result-value" id="resultValue">1 US gallon = 3.785 L</div>
                <div class="result-formula" id="resultFormula">1 US gallon × 3.78541 = 3.785 liters</div>
            </div>

            <div class="quick-convert">
                <h3>⚡ Common Volumes</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setGallons(1)">
                        <div class="quick-value">1</div>
                        <div class="quick-label">One Gallon</div>
                    </div>
                    <div class="quick-btn" onclick="setGallons(5)">
                        <div class="quick-value">5</div>
                        <div class="quick-label">Five Gallons</div>
                    </div>
                    <div class="quick-btn" onclick="setGallons(10)">
                        <div class="quick-value">10</div>
                        <div class="quick-label">Ten Gallons</div>
                    </div>
                    <div class="quick-btn" onclick="setGallons(15)">
                        <div class="quick-value">15</div>
                        <div class="quick-label">Gas Tank</div>
                    </div>
                    <div class="quick-btn" onclick="setGallons(50)">
                        <div class="quick-value">50</div>
                        <div class="quick-label">Water Heater</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>💧 Gallons to Liters Conversion</h2>
            
            <p>A <strong>gallon</strong> is a unit of volume used primarily in the United States and United Kingdom. The <strong>liter</strong> is the metric unit of volume used worldwide.</p>

            <h3>📊 Types of Gallons</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Volume (Liters)</th>
                        <th>Used In</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>US Gallon</strong></td>
                        <td>3.78541 L</td>
                        <td>United States, Latin America</td>
                    </tr>
                    <tr>
                        <td><strong>UK Gallon (Imperial)</strong></td>
                        <td>4.54609 L</td>
                        <td>United Kingdom, Canada (partial)</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>Gallons to Liters:</strong><br>
                • US: Liters = Gallons × 3.78541<br>
                • UK: Liters = Gallons × 4.54609<br><br>
                <strong>Liters to Gallons:</strong><br>
                • US: Gallons = Liters ÷ 3.78541<br>
                • UK: Gallons = Liters ÷ 4.54609
            </div>

            <h3>📏 US Gallon Conversion Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>US Gallons</th>
                        <th>Liters</th>
                        <th>Common Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>0.25 gal</td><td>0.95 L</td><td>Quart</td></tr>
                    <tr><td>0.5 gal</td><td>1.89 L</td><td>Half gallon (milk)</td></tr>
                    <tr><td>1 gal</td><td>3.79 L</td><td>Gallon jug</td></tr>
                    <tr><td>5 gal</td><td>18.93 L</td><td>Water cooler bottle</td></tr>
                    <tr><td>10 gal</td><td>37.85 L</td><td>Aquarium</td></tr>
                    <tr><td>15 gal</td><td>56.78 L</td><td>Car gas tank (small)</td></tr>
                    <tr><td>20 gal</td><td>75.71 L</td><td>Car gas tank (large)</td></tr>
                    <tr><td>50 gal</td><td>189.27 L</td><td>Water heater</td></tr>
                </tbody>
            </table>

            <h3>🚗 Fuel & Gas Stations</h3>
            <ul>
                <li><strong>US gas pumps:</strong> Measure in gallons (3.785 L each)</li>
                <li><strong>Small car tank:</strong> 12-15 gallons (45-57 L)</li>
                <li><strong>Large car tank:</strong> 18-20 gallons (68-76 L)</li>
                <li><strong>SUV/Truck tank:</strong> 20-30 gallons (76-114 L)</li>
                <li><strong>Gas can:</strong> Typically 1, 2, or 5 gallons</li>
            </ul>

            <h3>🥛 Food & Beverages</h3>
            <div class="formula-box">
                <strong>Common Container Sizes:</strong><br>
                • Milk jug: 1 gallon (3.79 L)<br>
                • Half gallon: 0.5 gal (1.89 L)<br>
                • 2-liter soda: ~0.53 US gallons<br>
                • Wine bottle (750 mL): ~0.20 US gallons<br>
                • Beer keg (½ barrel): 15.5 gallons (58.67 L)
            </div>

            <h3>🏊 Pools & Water Systems</h3>
            <ul>
                <li><strong>Bathtub:</strong> 40-80 gallons (151-303 L)</li>
                <li><strong>Hot tub:</strong> 200-500 gallons (757-1,893 L)</li>
                <li><strong>Small pool:</strong> 5,000-10,000 gallons (18,927-37,854 L)</li>
                <li><strong>Large pool:</strong> 15,000-30,000 gallons (56,781-113,562 L)</li>
                <li><strong>Olympic pool:</strong> 660,000 gallons (2.5 million L)</li>
            </ul>

            <h3>🏠 Household Water Usage</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>US Gallons</th>
                        <th>Liters</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Shower (10 min)</td><td>25 gal</td><td>95 L</td></tr>
                    <tr><td>Bath</td><td>36 gal</td><td>136 L</td></tr>
                    <tr><td>Washing machine load</td><td>15-40 gal</td><td>57-151 L</td></tr>
                    <tr><td>Dishwasher</td><td>6 gal</td><td>23 L</td></tr>
                    <tr><td>Toilet flush</td><td>1.6 gal</td><td>6 L</td></tr>
                    <tr><td>Brushing teeth (tap running)</td><td>1 gal</td><td>4 L</td></tr>
                </tbody>
            </table>

            <h3>🐟 Aquariums</h3>
            <ul>
                <li><strong>Small fish tank:</strong> 5-10 gallons (19-38 L)</li>
                <li><strong>Medium tank:</strong> 20-30 gallons (76-114 L)</li>
                <li><strong>Large tank:</strong> 50-75 gallons (189-284 L)</li>
                <li><strong>Extra large:</strong> 100+ gallons (379+ L)</li>
            </ul>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>US Gallon Approximation:</strong><br>
                • 1 gallon ≈ 4 liters (rough estimate)<br>
                • Actual: 1 gallon = 3.785 liters<br>
                • Error: ~5% (good for quick estimates)<br><br>
                <strong>UK Gallon Approximation:</strong><br>
                • 1 UK gallon ≈ 4.5 liters<br>
                • Actual: 1 UK gallon = 4.546 liters<br>
                • Very close approximation!
            </div>

            <h3>🌍 Regional Differences</h3>
            <ul>
                <li><strong>United States:</strong> Uses US gallon exclusively</li>
                <li><strong>United Kingdom:</strong> Uses Imperial gallon for fuel efficiency (mpg)</li>
                <li><strong>Canada:</strong> Officially uses liters, but some use Imperial gallons</li>
                <li><strong>Most of world:</strong> Uses liters exclusively</li>
            </ul>

            <h3>⛽ Fuel Economy Comparison</h3>
            <div class="formula-box">
                <strong>Miles Per Gallon (MPG) vs L/100km:</strong><br>
                • 25 US MPG = 9.4 L/100km<br>
                • 30 US MPG = 7.8 L/100km<br>
                • 35 US MPG = 6.7 L/100km<br>
                • 40 US MPG = 5.9 L/100km<br><br>
                <strong>Note:</strong> UK MPG is ~20% higher than US MPG due to larger gallon
            </div>

            <h3>📐 Related Volume Conversions</h3>
            <ul>
                <li><strong>1 US gallon:</strong> 4 quarts = 8 pints = 16 cups = 128 fl oz</li>
                <li><strong>1 liter:</strong> 1,000 milliliters = 1.057 US quarts</li>
                <li><strong>1 cubic meter:</strong> 1,000 liters = 264.2 US gallons</li>
                <li><strong>1 barrel (oil):</strong> 42 US gallons = 159 liters</li>
            </ul>

            <h3>🚿 Water Conservation</h3>
            <ul>
                <li><strong>Average person uses:</strong> 80-100 gallons/day (303-379 L)</li>
                <li><strong>Low-flow showerhead:</strong> Saves 10+ gallons per shower</li>
                <li><strong>Efficient washer:</strong> Uses 15-30 gal vs old 40+ gal</li>
                <li><strong>Dripping faucet:</strong> Wastes 3,000+ gallons/year</li>
            </ul>

            <h3>🎯 Practical Examples</h3>
            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • Milk jug: 1 gal = 3.79 L<br>
                • 5-gallon water bottle: 18.93 L<br>
                • 15-gallon gas tank: 56.78 L<br>
                • 50-gallon water heater: 189.27 L<br>
                • 2-liter soda: 0.53 US gallons<br>
                • 5 liters: 1.32 US gallons
            </div>

            <h3>🏭 Industrial & Commercial</h3>
            <ul>
                <li><strong>Drum (standard):</strong> 55 gallons (208 L)</li>
                <li><strong>IBC tote:</strong> 275 gallons (1,041 L)</li>
                <li><strong>Tanker truck:</strong> 5,000-11,600 gallons (18,927-43,906 L)</li>
                <li><strong>Rail tanker:</strong> 20,000-30,000 gallons (75,708-113,562 L)</li>
            </ul>

            <h3>📊 Historical Context</h3>
            <p>The gallon originated in England with various definitions. The Imperial gallon was standardized in 1824 as the volume of 10 pounds of water at 62°F. The US gallon, defined in 1832, is smaller at 231 cubic inches. The liter, part of the metric system, is defined as one cubic decimeter (1000 cm³).</p>
        </div>

        <div class="footer">
            <p>💧 Accurate Gallons ⇄ Liters Conversion | Bidirectional Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for fuel, cooking, pools, aquariums, and everyday volume measurements</p>
        </div>
    </div>

    <script>
        let currentGallonType = 'us';
        const gallonSizes = {
            us: 3.78541,
            uk: 4.54609
        };

        const gallonNames = {
            us: 'US gallon',
            uk: 'UK gallon'
        };

        function selectGallonType(type, btn) {
            currentGallonType = type;
            document.querySelectorAll('.gallon-type-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            convertGallons();
        }

        function convertGallons() {
            const gallons = parseFloat(document.getElementById('gallonsInput').value);
            
            if (isNaN(gallons) || gallons < 0) {
                return;
            }

            const liters = gallons * gallonSizes[currentGallonType];
            document.getElementById('litersInput').value = liters.toFixed(3);
            
            updateResult(gallons, liters, 'gallons');
        }

        function convertLiters() {
            const liters = parseFloat(document.getElementById('litersInput').value);
            
            if (isNaN(liters) || liters < 0) {
                return;
            }

            const gallons = liters / gallonSizes[currentGallonType];
            document.getElementById('gallonsInput').value = gallons.toFixed(3);
            
            updateResult(gallons, liters, 'liters');
        }

        function updateResult(gallons, liters, fromUnit) {
            const gallonName = gallonNames[currentGallonType];
            const factor = gallonSizes[currentGallonType];
            
            if (fromUnit === 'gallons') {
                document.getElementById('resultValue').textContent = 
                    `${gallons.toFixed(3)} ${gallonName}${gallons !== 1 ? 's' : ''} = ${liters.toFixed(3)} L`;
                
                document.getElementById('resultFormula').textContent = 
                    `${gallons.toFixed(3)} ${gallonName}${gallons !== 1 ? 's' : ''} × ${factor} = ${liters.toFixed(3)} liters`;
            } else {
                document.getElementById('resultValue').textContent = 
                    `${liters.toFixed(3)} L = ${gallons.toFixed(3)} ${gallonName}${gallons !== 1 ? 's' : ''}`;
                
                document.getElementById('resultFormula').textContent = 
                    `${liters.toFixed(3)} liters ÷ ${factor} = ${gallons.toFixed(3)} ${gallonName}${gallons !== 1 ? 's' : ''}`;
            }
        }

        function swapUnits() {
            const gallonsValue = document.getElementById('gallonsInput').value;
            const litersValue = document.getElementById('litersInput').value;
            
            // Swap the values
            document.getElementById('gallonsInput').value = litersValue;
            document.getElementById('litersInput').value = gallonsValue;
            
            if (gallonsValue) convertGallons();
        }

        function setGallons(value) {
            document.getElementById('gallonsInput').value = value;
            convertGallons();
        }

        // Auto-convert on input
        document.getElementById('gallonsInput').addEventListener('input', convertGallons);
        document.getElementById('litersInput').addEventListener('input', convertLiters);

        // Initial conversion
        convertGallons();
    </script>
</body>
</html>