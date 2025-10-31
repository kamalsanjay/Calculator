<?php
/**
 * Length Converter
 * File: conversion/length-converter.php
 * Description: Universal length converter for all major units
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Length Converter - Universal Distance & Length Calculator</title>
    <meta name="description" content="Convert between all length units: meters, feet, inches, centimeters, kilometers, miles, yards, and more.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; margin-top: 10px; }
        .unit-select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #667eea; }
        .result-unit { color: #4527a0; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #5e35b1; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
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
        .conversion-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
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
            <h1>📏 Universal Length Converter</h1>
            <p>Convert between all major length units - meters, feet, inches, miles, kilometers, and more</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="m" selected>Meter (m)</option>
                        <option value="km">Kilometer (km)</option>
                        <option value="cm">Centimeter (cm)</option>
                        <option value="mm">Millimeter (mm)</option>
                        <option value="mi">Mile (mi)</option>
                        <option value="yd">Yard (yd)</option>
                        <option value="ft">Foot (ft)</option>
                        <option value="in">Inch (in)</option>
                        <option value="nm">Nautical Mile (nmi)</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="m">Meter (m)</option>
                        <option value="km">Kilometer (km)</option>
                        <option value="cm">Centimeter (cm)</option>
                        <option value="mm">Millimeter (mm)</option>
                        <option value="mi">Mile (mi)</option>
                        <option value="yd">Yard (yd)</option>
                        <option value="ft" selected>Foot (ft)</option>
                        <option value="in">Inch (in)</option>
                        <option value="nm">Nautical Mile (nmi)</option>
                    </select>
                    <div class="input-wrapper" style="margin-top: 10px;">
                        <input type="text" id="outputValue" placeholder="Result" readonly style="background: #f8f9fa; font-weight: 600; color: #2c3e50;">
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid"></div>

            <div class="quick-convert">
                <h3>📐 Quick Conversions</h3>
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
            <h2>📏 Universal Length Conversion</h2>
            
            <p>Convert between all major length units used worldwide for measuring distance, height, and dimensions.</p>

            <h3>📊 Conversion Factors to Meters</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Meters</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Meter</td><td>m</td><td>1</td></tr>
                    <tr><td>Kilometer</td><td>km</td><td>1,000</td></tr>
                    <tr><td>Centimeter</td><td>cm</td><td>0.01</td></tr>
                    <tr><td>Millimeter</td><td>mm</td><td>0.001</td></tr>
                    <tr><td>Mile</td><td>mi</td><td>1,609.344</td></tr>
                    <tr><td>Yard</td><td>yd</td><td>0.9144</td></tr>
                    <tr><td>Foot</td><td>ft</td><td>0.3048</td></tr>
                    <tr><td>Inch</td><td>in</td><td>0.0254</td></tr>
                    <tr><td>Nautical Mile</td><td>nmi</td><td>1,852</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • 1 meter = 100 cm = 1,000 mm<br>
                • 1 kilometer = 1,000 meters<br>
                • 1 mile = 1.609344 km = 5,280 feet<br>
                • 1 foot = 12 inches = 30.48 cm<br>
                • 1 yard = 3 feet = 0.9144 meters<br>
                • 1 inch = 2.54 cm (exact)<br>
                • 1 nautical mile = 1.852 km
            </div>

            <h3>📐 Metric System</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Abbreviation</th>
                        <th>Relation to Meter</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Kilometer</td><td>km</td><td>1,000 m</td></tr>
                    <tr><td>Meter</td><td>m</td><td>Base unit</td></tr>
                    <tr><td>Decimeter</td><td>dm</td><td>0.1 m</td></tr>
                    <tr><td>Centimeter</td><td>cm</td><td>0.01 m</td></tr>
                    <tr><td>Millimeter</td><td>mm</td><td>0.001 m</td></tr>
                    <tr><td>Micrometer</td><td>μm</td><td>0.000001 m</td></tr>
                </tbody>
            </table>

            <h3>📏 Imperial/US System</h3>
            <ul>
                <li><strong>Mile:</strong> 1,760 yards = 5,280 feet</li>
                <li><strong>Yard:</strong> 3 feet = 36 inches</li>
                <li><strong>Foot:</strong> 12 inches</li>
                <li><strong>Inch:</strong> Base imperial unit</li>
            </ul>

            <h3>🌍 Common Uses</h3>
            <div class="formula-box">
                <strong>Metric (Most of World):</strong><br>
                • Road distances: kilometers<br>
                • Human height: centimeters or meters<br>
                • Room dimensions: meters<br>
                • Precision: millimeters<br><br>
                <strong>Imperial (US, UK):</strong><br>
                • Road distances: miles<br>
                • Human height: feet and inches<br>
                • Room dimensions: feet<br>
                • Precision: inches or fractions
            </div>

            <h3>🏃 Human Scale</h3>
            <ul>
                <li><strong>Average human height:</strong> 165-180 cm (5'5"-5'11")</li>
                <li><strong>Arm span:</strong> Roughly equal to height</li>
                <li><strong>Step length:</strong> 60-80 cm (24-31 inches)</li>
                <li><strong>Fingernail width:</strong> ~1 cm</li>
                <li><strong>Thumb width:</strong> ~2.5 cm (1 inch)</li>
            </ul>

            <h3>🏠 Building & Construction</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Element</th>
                        <th>Typical Size</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Door height</td><td>2 m (6'8")</td></tr>
                    <tr><td>Door width</td><td>80-90 cm (32-36")</td></tr>
                    <tr><td>Ceiling height</td><td>2.4-3 m (8-10 ft)</td></tr>
                    <tr><td>Room size</td><td>3-5 m (10-16 ft)</td></tr>
                    <tr><td>Window</td><td>1-1.5 m wide (3-5 ft)</td></tr>
                </tbody>
            </table>

            <h3>🚗 Transportation</h3>
            <ul>
                <li><strong>Car length:</strong> 4-5 m (13-16 ft)</li>
                <li><strong>Parking space:</strong> 2.5 × 5 m (8 × 16 ft)</li>
                <li><strong>Lane width:</strong> 3-3.7 m (10-12 ft)</li>
                <li><strong>Semi-truck:</strong> 16-18 m (53-60 ft)</li>
            </ul>

            <h3>⚽ Sports Fields</h3>
            <div class="formula-box">
                <strong>Field Dimensions:</strong><br>
                • Soccer: 100-110 m × 64-75 m<br>
                • American football: 100 yards (91.4 m) long<br>
                • Basketball: 28 m × 15 m (94 × 50 ft)<br>
                • Tennis: 23.77 m × 10.97 m (78 × 36 ft)<br>
                • Olympic pool: 50 m × 25 m
            </div>

            <h3>✈️ Aviation & Maritime</h3>
            <ul>
                <li><strong>Nautical mile:</strong> 1,852 m (1.15 statute miles)</li>
                <li><strong>Aircraft altitude:</strong> Measured in feet</li>
                <li><strong>Ship draft:</strong> Meters or feet</li>
                <li><strong>Runway length:</strong> 1,500-4,000 m</li>
            </ul>

            <h3>🔬 Scientific Measurements</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Scale</th>
                        <th>Unit</th>
                        <th>Examples</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Astronomical</td><td>Light year, AU</td><td>Space distances</td></tr>
                    <tr><td>Geographic</td><td>Kilometers, miles</td><td>Countries, cities</td></tr>
                    <tr><td>Human scale</td><td>Meters, feet</td><td>Buildings, rooms</td></tr>
                    <tr><td>Precision</td><td>Millimeters, inches</td><td>Parts, components</td></tr>
                    <tr><td>Microscopic</td><td>Micrometers, nanometers</td><td>Cells, molecules</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>Meters ↔ Feet:</strong><br>
                • Multiply meters by 3.3 for rough feet<br>
                • Divide feet by 3.3 for rough meters<br><br>
                <strong>Kilometers ↔ Miles:</strong><br>
                • Multiply km by 0.6 for rough miles<br>
                • Multiply miles by 1.6 for rough km<br><br>
                <strong>Centimeters ↔ Inches:</strong><br>
                • Divide cm by 2.5 for rough inches<br>
                • Multiply inches by 2.5 for rough cm
            </div>

            <h3>🌎 Country Standards</h3>
            <ul>
                <li><strong>Metric countries:</strong> Most of the world uses meters</li>
                <li><strong>United States:</strong> Primarily uses feet and miles</li>
                <li><strong>United Kingdom:</strong> Mixed system (miles for roads, meters for sports)</li>
                <li><strong>Canada:</strong> Officially metric, but some imperial use</li>
            </ul>

            <h3>📱 Screen & Device Sizes</h3>
            <ul>
                <li><strong>Phone screen:</strong> 15-17 cm (6-7 inches) diagonal</li>
                <li><strong>Tablet:</strong> 25-33 cm (10-13 inches)</li>
                <li><strong>Laptop:</strong> 33-43 cm (13-17 inches)</li>
                <li><strong>TV:</strong> Measured diagonally in inches</li>
            </ul>

            <h3>🏛️ Historical Context</h3>
            <p>The <strong>meter</strong> was defined in 1791 as one ten-millionth of the distance from the equator to the North Pole. Today it's defined by the speed of light. The <strong>foot</strong> comes from actual human feet and was standardized internationally in 1959 as exactly 0.3048 meters.</p>

            <h3>🎯 Key Conversions to Remember</h3>
            <ul>
                <li><strong>1 meter ≈ 3.28 feet ≈ 39.37 inches</strong></li>
                <li><strong>1 kilometer ≈ 0.621 miles</strong></li>
                <li><strong>1 mile = 1.609 km = 5,280 feet</strong></li>
                <li><strong>1 inch = 2.54 cm (exact)</strong></li>
                <li><strong>1 foot = 30.48 cm</strong></li>
                <li><strong>1 yard = 0.9144 meters</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>📏 Universal Length Converter | All Major Units</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert meters, feet, inches, miles, kilometers, yards, and more</p>
        </div>
    </div>

    <script>
        // Conversion factors to meters
        const toMeters = {
            m: 1,
            km: 1000,
            cm: 0.01,
            mm: 0.001,
            mi: 1609.344,
            yd: 0.9144,
            ft: 0.3048,
            in: 0.0254,
            nm: 1852
        };

        const unitNames = {
            m: 'Meter (m)',
            km: 'Kilometer (km)',
            cm: 'Centimeter (cm)',
            mm: 'Millimeter (mm)',
            mi: 'Mile (mi)',
            yd: 'Yard (yd)',
            ft: 'Foot (ft)',
            in: 'Inch (in)',
            nm: 'Nautical Mile (nmi)'
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

            // Convert to meters first
            const valueInMeters = inputValue * toMeters[fromUnit];
            
            // Convert to target unit
            const result = valueInMeters / toMeters[toUnit];
            
            document.getElementById('outputValue').value = formatNumber(result);
            
            displayAllConversions(valueInMeters);
        }

        function displayAllConversions(valueInMeters) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInMeters / toMeters[unit];
                
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