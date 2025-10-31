<?php
/**
 * Distance Converter
 * File: conversion/distance-converter.php
 * Description: Convert between all distance and length units
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distance Converter - Convert Miles, Kilometers, and More</title>
    <meta name="description" content="Convert between miles, kilometers, meters, feet, yards, and all distance units. Free online distance converter calculator.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #11998e; box-shadow: 0 0 0 3px rgba(17, 153, 142, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; }
        .unit-select:focus { outline: none; border-color: #11998e; box-shadow: 0 0 0 3px rgba(17, 153, 142, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #11998e; }
        .result-unit { color: #7f8c8d; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #2c3e50; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #11998e; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(17, 153, 142, 0.15); }
        .quick-value { font-weight: bold; color: #11998e; font-size: 1rem; }
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
        .conversion-table tr:hover { background: #f8f9fa; }
        
        .formula-box { background: #e8f8f5; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #11998e; }
        .formula-box strong { color: #11998e; }
        
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
            <h1>📏 Distance Converter</h1>
            <p>Convert between miles, kilometers, meters, feet, yards, and all distance units instantly</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select" style="margin-top: 10px;">
                        <option value="mm">Millimeter (mm)</option>
                        <option value="cm">Centimeter (cm)</option>
                        <option value="m">Meter (m)</option>
                        <option value="km" selected>Kilometer (km)</option>
                        <option value="in">Inch (in)</option>
                        <option value="ft">Foot (ft)</option>
                        <option value="yd">Yard (yd)</option>
                        <option value="mi">Mile (mi)</option>
                        <option value="nm">Nautical Mile</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="mm">Millimeter (mm)</option>
                        <option value="cm">Centimeter (cm)</option>
                        <option value="m">Meter (m)</option>
                        <option value="km">Kilometer (km)</option>
                        <option value="in">Inch (in)</option>
                        <option value="ft">Foot (ft)</option>
                        <option value="yd">Yard (yd)</option>
                        <option value="mi" selected>Mile (mi)</option>
                        <option value="nm">Nautical Mile</option>
                    </select>
                    <div class="input-wrapper" style="margin-top: 10px;">
                        <input type="text" id="outputValue" placeholder="Result" readonly style="background: #f8f9fa; font-weight: 600; color: #2c3e50;">
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid"></div>

            <div class="quick-convert">
                <h3>⚡ Common Distances</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setInputValue(1)">
                        <div class="quick-value">1</div>
                        <div class="quick-label">Unit</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(5)">
                        <div class="quick-value">5</div>
                        <div class="quick-label">Units</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(10)">
                        <div class="quick-value">10</div>
                        <div class="quick-label">Units</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(100)">
                        <div class="quick-value">100</div>
                        <div class="quick-label">Units</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🗺️ Distance Conversion Guide</h2>
            
            <p><strong>Distance</strong> measures how far apart objects are. This converter supports all major distance units from millimeters to miles, covering both metric and imperial systems.</p>

            <h3>📊 Conversion Factors to Meters</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Equals (in meters)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Millimeter</td><td>mm</td><td>0.001</td></tr>
                    <tr><td>Centimeter</td><td>cm</td><td>0.01</td></tr>
                    <tr><td>Meter</td><td>m</td><td>1</td></tr>
                    <tr><td>Kilometer</td><td>km</td><td>1,000</td></tr>
                    <tr><td>Inch</td><td>in</td><td>0.0254</td></tr>
                    <tr><td>Foot</td><td>ft</td><td>0.3048</td></tr>
                    <tr><td>Yard</td><td>yd</td><td>0.9144</td></tr>
                    <tr><td>Mile</td><td>mi</td><td>1,609.344</td></tr>
                    <tr><td>Nautical Mile</td><td>nmi</td><td>1,852</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • 1 km = 0.621371 miles<br>
                • 1 mile = 1.60934 km<br>
                • 1 meter = 3.28084 feet<br>
                • 1 foot = 0.3048 meters<br>
                • 1 inch = 2.54 cm<br>
                • 1 yard = 3 feet = 0.9144 meters
            </div>

            <h3>📏 Metric Distance Units</h3>
            <ul>
                <li><strong>Millimeter (mm):</strong> 1/1,000 of a meter, used for small measurements</li>
                <li><strong>Centimeter (cm):</strong> 1/100 of a meter, common for everyday objects</li>
                <li><strong>Meter (m):</strong> Base SI unit for length, about 3.3 feet</li>
                <li><strong>Kilometer (km):</strong> 1,000 meters, used for longer distances</li>
            </ul>

            <h3>🇺🇸 Imperial Distance Units</h3>
            <ul>
                <li><strong>Inch (in):</strong> 1/12 of a foot, 2.54 cm exactly</li>
                <li><strong>Foot (ft):</strong> 12 inches, 0.3048 meters</li>
                <li><strong>Yard (yd):</strong> 3 feet, 0.9144 meters</li>
                <li><strong>Mile (mi):</strong> 5,280 feet, 1.609 km</li>
                <li><strong>Nautical Mile:</strong> 1,852 meters, used in aviation and marine navigation</li>
            </ul>

            <h3>🌍 Real-World Distances</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Example</th>
                        <th>Distance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Credit card thickness</td><td>~0.76 mm</td></tr>
                    <tr><td>Average human height</td><td>~1.7 m (5'7")</td></tr>
                    <tr><td>Car length (sedan)</td><td>~4.5 m (15 ft)</td></tr>
                    <tr><td>Football field (US)</td><td>91.44 m (100 yd)</td></tr>
                    <tr><td>Marathon race</td><td>42.195 km (26.2 mi)</td></tr>
                    <tr><td>Earth's circumference</td><td>~40,075 km (24,901 mi)</td></tr>
                    <tr><td>Moon distance from Earth</td><td>~384,400 km (238,855 mi)</td></tr>
                </tbody>
            </table>

            <h3>🏃 Sports & Athletics</h3>
            <ul>
                <li><strong>Track events:</strong> 100m, 200m, 400m, 800m, 1500m, 5000m, 10000m</li>
                <li><strong>Marathon:</strong> 42.195 km / 26.2 miles / 26 miles 385 yards</li>
                <li><strong>Half marathon:</strong> 21.0975 km / 13.1 miles</li>
                <li><strong>5K run:</strong> 5 km / 3.1 miles</li>
                <li><strong>10K run:</strong> 10 km / 6.2 miles</li>
                <li><strong>American football field:</strong> 100 yards (91.44 m) between end zones</li>
                <li><strong>Soccer field:</strong> 100-110 m (109-120 yards) long</li>
            </ul>

            <h3>🚗 Driving & Travel</h3>
            <div class="formula-box">
                <strong>Speed Limits:</strong><br>
                • Urban: 25-35 mph (40-56 km/h)<br>
                • Rural: 55-65 mph (88-105 km/h)<br>
                • Highway: 65-75 mph (105-120 km/h)<br>
                • Autobahn (Germany): No limit in sections<br><br>
                <strong>Average walking speed:</strong> 5 km/h (3.1 mph)<br>
                <strong>Average cycling speed:</strong> 15-20 km/h (9-12 mph)
            </div>

            <h3>✈️ Aviation & Marine</h3>
            <ul>
                <li><strong>Nautical mile:</strong> 1.852 km, based on Earth's circumference</li>
                <li><strong>Knot:</strong> 1 nautical mile per hour (1.852 km/h)</li>
                <li><strong>Flight altitude:</strong> 30,000-40,000 feet (9-12 km)</li>
                <li><strong>Visibility:</strong> Often measured in nautical miles for pilots/sailors</li>
            </ul>

            <h3>🔬 Scientific & Engineering</h3>
            <ul>
                <li><strong>Nanometer (nm):</strong> 10⁻⁹ meters, used for wavelengths</li>
                <li><strong>Micrometer (μm):</strong> 10⁻⁶ meters, used for cells</li>
                <li><strong>Astronomical Unit (AU):</strong> ~150 million km (Earth-Sun distance)</li>
                <li><strong>Light-year:</strong> ~9.46 trillion km (distance light travels in a year)</li>
            </ul>

            <h3>🎯 Conversion Tips</h3>
            <ul>
                <li><strong>Quick km to miles:</strong> Multiply km by 0.6 (approximate)</li>
                <li><strong>Quick miles to km:</strong> Multiply miles by 1.6 (approximate)</li>
                <li><strong>Feet to meters:</strong> Divide feet by 3.3 (approximate)</li>
                <li><strong>Meters to feet:</strong> Multiply meters by 3.3 (approximate)</li>
                <li><strong>Inches to cm:</strong> Multiply inches by 2.5 (approximate)</li>
            </ul>

            <h3>📐 Historical Context</h3>
            <ul>
                <li><strong>Foot:</strong> Originally based on the human foot</li>
                <li><strong>Yard:</strong> Distance from nose to outstretched arm</li>
                <li><strong>Mile:</strong> From Roman "mille passus" (thousand paces)</li>
                <li><strong>Meter:</strong> Defined as 1/10,000,000 of distance from equator to North Pole</li>
                <li><strong>Inch:</strong> Width of adult thumb</li>
            </ul>

            <h3>🌎 Countries Using Metric vs Imperial</h3>
            <ul>
                <li><strong>Metric (km):</strong> Most of the world (180+ countries)</li>
                <li><strong>Imperial (miles):</strong> USA, UK (partially), Liberia, Myanmar</li>
                <li><strong>UK hybrid:</strong> Road signs in miles, but other measurements in metric</li>
                <li><strong>Canada:</strong> Officially metric since 1970s</li>
            </ul>

            <h3>💡 Practical Examples</h3>
            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • 1 mile walk ≈ 20 minutes (average pace)<br>
                • 5 km run ≈ 3.1 miles<br>
                • 100 km drive ≈ 62 miles<br>
                • 6 feet tall ≈ 1.83 meters<br>
                • 100 yards ≈ 91 meters<br>
                • 10 inches ≈ 25.4 cm
            </div>

            <h3>📱 GPS & Maps</h3>
            <ul>
                <li>GPS accuracy: Within 5-10 meters (16-33 feet) typically</li>
                <li>Google Maps: Can display either km or miles</li>
                <li>Coordinate precision: Degrees, minutes, seconds</li>
                <li>One degree latitude: ~111 km (69 miles)</li>
            </ul>
        </div>

        <div class="footer">
            <p>📏 Accurate Distance Conversion | All Major Units Supported</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for travel, sports, engineering, and everyday measurements</p>
        </div>
    </div>

    <script>
        // Conversion factors to meters
        const conversionFactors = {
            mm: 0.001,
            cm: 0.01,
            m: 1,
            km: 1000,
            in: 0.0254,
            ft: 0.3048,
            yd: 0.9144,
            mi: 1609.344,
            nm: 1852
        };

        const unitNames = {
            mm: 'Millimeter (mm)',
            cm: 'Centimeter (cm)',
            m: 'Meter (m)',
            km: 'Kilometer (km)',
            in: 'Inch (in)',
            ft: 'Foot (ft)',
            yd: 'Yard (yd)',
            mi: 'Mile (mi)',
            nm: 'Nautical Mile'
        };

        function convertDistance() {
            const inputValue = parseFloat(document.getElementById('inputValue').value);
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;

            if (isNaN(inputValue)) {
                document.getElementById('outputValue').value = '';
                document.getElementById('resultGrid').innerHTML = '';
                return;
            }

            const valueInMeters = inputValue * conversionFactors[fromUnit];
            const result = valueInMeters / conversionFactors[toUnit];

            document.getElementById('outputValue').value = formatNumber(result);
            displayAllConversions(valueInMeters);
        }

        function displayAllConversions(valueInMeters) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInMeters / conversionFactors[unit];
                
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
            if (Math.abs(num) < 0.000001 || Math.abs(num) > 1000000) {
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
            
            convertDistance();
        }

        function setInputValue(value) {
            document.getElementById('inputValue').value = value;
            convertDistance();
        }

        // Auto-convert on input
        document.getElementById('inputValue').addEventListener('input', convertDistance);
        document.getElementById('fromUnit').addEventListener('change', convertDistance);
        document.getElementById('toUnit').addEventListener('change', convertDistance);

        // Initial conversion
        convertDistance();
    </script>
</body>
</html>