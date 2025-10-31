<?php
/**
 * Pascal Converter
 * File: conversion/pascal-converter.php
 * Description: Convert Pascal to all pressure units (PSI, bar, atm, etc.)
 */
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pressure Converter - Universal Pressure Unit Calculator</title>
    <meta name="description" content="Convert between all pressure units: pascal, bar, psi, atm, torr, mmHg, and more.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #4facfe; box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; margin-top: 10px; }
        .unit-select:focus { outline: none; border-color: #4facfe; box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #4facfe; }
        .result-unit { color: #1565c0; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #1976d2; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #4facfe; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(79, 172, 254, 0.15); }
        .quick-value { font-weight: bold; color: #4facfe; font-size: 1rem; }
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
        
        .formula-box { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #4facfe; }
        .formula-box strong { color: #4facfe; }
        
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
            <h1>📊 Universal Pressure Converter</h1>
            <p>Convert between all major pressure units - pascal, bar, psi, atmosphere, torr, mmHg, and more</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="pa" selected>Pascal (Pa)</option>
                        <option value="kpa">Kilopascal (kPa)</option>
                        <option value="mpa">Megapascal (MPa)</option>
                        <option value="bar">Bar (bar)</option>
                        <option value="mbar">Millibar (mbar)</option>
                        <option value="psi">Pound per Square Inch (psi)</option>
                        <option value="atm">Atmosphere (atm)</option>
                        <option value="torr">Torr (torr)</option>
                        <option value="mmHg">Millimeter of Mercury (mmHg)</option>
                        <option value="inhg">Inch of Mercury (inHg)</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="pa">Pascal (Pa)</option>
                        <option value="kpa">Kilopascal (kPa)</option>
                        <option value="mpa">Megapascal (MPa)</option>
                        <option value="bar" selected>Bar (bar)</option>
                        <option value="mbar">Millibar (mbar)</option>
                        <option value="psi">Pound per Square Inch (psi)</option>
                        <option value="atm">Atmosphere (atm)</option>
                        <option value="torr">Torr (torr)</option>
                        <option value="mmHg">Millimeter of Mercury (mmHg)</option>
                        <option value="inhg">Inch of Mercury (inHg)</option>
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
            <h2>📊 Universal Pressure Conversion</h2>
            
            <p>Convert between all major pressure units used in science, engineering, meteorology, and daily life applications.</p>

            <h3>📈 Conversion Factors to Pascals</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Pascals (Pa)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Pascal</td><td>Pa</td><td>1</td></tr>
                    <tr><td>Kilopascal</td><td>kPa</td><td>1,000</td></tr>
                    <tr><td>Megapascal</td><td>MPa</td><td>1,000,000</td></tr>
                    <tr><td>Bar</td><td>bar</td><td>100,000</td></tr>
                    <tr><td>Millibar</td><td>mbar</td><td>100</td></tr>
                    <tr><td>Pound per Square Inch</td><td>psi</td><td>6,894.76</td></tr>
                    <tr><td>Atmosphere</td><td>atm</td><td>101,325</td></tr>
                    <tr><td>Torr</td><td>torr</td><td>133.322</td></tr>
                    <tr><td>Millimeter of Mercury</td><td>mmHg</td><td>133.322</td></tr>
                    <tr><td>Inch of Mercury</td><td>inHg</td><td>3,386.39</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • 1 bar = 100,000 Pa = 14.5038 psi<br>
                • 1 atm = 101,325 Pa = 14.6959 psi<br>
                • 1 psi = 6,894.76 Pa = 0.0689476 bar<br>
                • 1 torr = 1 mmHg = 133.322 Pa<br>
                • 1 inHg = 3,386.39 Pa = 0.0334211 atm<br>
                • 1 MPa = 1,000,000 Pa = 10 bar
            </div>

            <h3>🔬 SI Units</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Abbreviation</th>
                        <th>Relation to Pascal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Megapascal</td><td>MPa</td><td>1,000,000 Pa</td></tr>
                    <tr><td>Kilopascal</td><td>kPa</td><td>1,000 Pa</td></tr>
                    <tr><td>Pascal</td><td>Pa</td><td>Base unit</td></tr>
                    <tr><td>Hectopascal</td><td>hPa</td><td>100 Pa</td></tr>
                    <tr><td>Millipascal</td><td>mPa</td><td>0.001 Pa</td></tr>
                </tbody>
            </table>

            <h3>⚖️ Imperial/US System</h3>
            <ul>
                <li><strong>Pound per Square Inch (psi):</strong> Most common US pressure unit</li>
                <li><strong>Inch of Mercury (inHg):</strong> Used in aviation and meteorology</li>
                <li><strong>Pound per Square Foot (psf):</strong> 1 psf = 47.8803 Pa</li>
                <li><strong>Kip per Square Inch (ksi):</strong> 1 ksi = 1,000 psi</li>
            </ul>

            <h3>🌤️ Meteorology & Weather</h3>
            <div class="formula-box">
                <strong>Atmospheric Pressure:</strong><br>
                • Standard sea level pressure: 1013.25 mbar<br>
                • High pressure system: >1013 mbar<br>
                • Low pressure system: <1013 mbar<br>
                • Hurricane pressure: <980 mbar<br>
                • Extreme low: ~870 mbar (Typhoon Tip, 1979)
            </div>

            <h3>🏠 Everyday Pressure Examples</h3>
            <ul>
                <li><strong>Tire pressure:</strong> 30-35 psi (car), 80-130 psi (bike)</li>
                <li><strong>Water pressure:</strong> 40-80 psi (typical home)</li>
                <li><strong>Scuba tank:</strong> 3,000 psi (full)</li>
                <li><strong>Blood pressure:</strong> 120/80 mmHg (normal)</li>
                <li><strong>Cooking pressure:</strong> 15 psi (pressure cooker)</li>
            </ul>

            <h3>🏭 Industrial Applications</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Typical Pressure Range</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>HVAC systems</td><td>0.5-2 bar</td></tr>
                    <tr><td>Hydraulic systems</td><td>100-700 bar</td></tr>
                    <tr><td>Natural gas pipelines</td><td>20-100 bar</td></tr>
                    <tr><td>Water distribution</td><td>2-6 bar</td></tr>
                    <tr><td>Steam systems</td><td>1-40 bar</td></tr>
                </tbody>
            </table>

            <h3>🚗 Automotive</h3>
            <ul>
                <li><strong>Car tires:</strong> 30-35 psi (2.1-2.4 bar)</li>
                <li><strong>Truck tires:</strong> 80-120 psi (5.5-8.3 bar)</li>
                <li><strong>Fuel injection:</strong> 30-85 psi (2-6 bar)</li>
                <li><strong>Brake systems:</td><td>1,000-2,000 psi (69-138 bar)</li>
            </ul>

            <h3>✈️ Aviation</h3>
            <div class="formula-box">
                <strong>Aviation Pressure Standards:</strong><br>
                • Standard atmosphere: 29.92 inHg or 1013.25 hPa<br>
                • Cabin pressure: ~8,000 ft equivalent (10.9 psi)<br>
                • Oxygen systems: 1,800-2,200 psi<br>
                • Hydraulic systems: 3,000 psi
            </div>

            <h3>🏥 Medical & Healthcare</h3>
            <ul>
                <li><strong>Blood pressure:</strong> Measured in mmHg</li>
                <li><strong>CPAP machines:</strong> 4-20 cmH₂O</li>
                <li><strong>Oxygen tanks:</strong> 2,000-3,000 psi</li>
                <li><strong>Anesthesia:</strong> 15-50 psi</li>
                <li><strong>Intravenous:</strong> 1-5 psi</li>
            </ul>

            <h3>🔬 Scientific & Laboratory</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Scale</th>
                        <th>Unit</th>
                        <th>Applications</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Ultra-high vacuum</td><td>nPa, μPa</td><td>Particle physics</td></tr>
                    <tr><td>High vacuum</td><td>mPa, Pa</td><td>Electron microscopy</td></tr>
                    <tr><td>Medium vacuum</td><td>Pa, hPa</td><td>Freeze drying</td></tr>
                    <tr><td>Atmospheric</td><td>kPa, bar</td><td>Chemical reactions</td></tr>
                    <tr><td>High pressure</td><td>MPa, GPa</td><td>Material science</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>Bar ↔ PSI:</strong><br>
                • Multiply bar by 14.5 for rough psi<br>
                • Divide psi by 14.5 for rough bar<br><br>
                <strong>Atm ↔ PSI:</strong><br>
                • Multiply atm by 14.7 for rough psi<br>
                • Divide psi by 14.7 for rough atm<br><br>
                <strong>mmHg ↔ PSI:</strong><br>
                • Divide mmHg by 50 for rough psi<br>
                • Multiply psi by 50 for rough mmHg
            </div>

            <h3>🌎 Country Standards</h3>
            <ul>
                <li><strong>SI countries:</strong> Use Pa, kPa, MPa, bar</li>
                <li><strong>United States:</strong> Primarily uses psi, inHg</li>
                <li><strong>United Kingdom:</strong> Mixed system (bar for cars, psi for bikes)</li>
                <li><strong>Aviation worldwide:</strong> Uses hPa/mbar and inHg</li>
            </ul>

            <h3>📏 Pressure Measurement Devices</h3>
            <ul>
                <li><strong>Barometer:</strong> Measures atmospheric pressure</li>
                <li><strong>Manometer:</strong> Measures gas/liquid pressure</li>
                <li><strong>Bourdon gauge:</strong> Common mechanical pressure gauge</li>
                <li><strong>Pressure transducer:</strong> Converts pressure to electrical signal</li>
                <li><strong>Sphygmomanometer:</strong> Measures blood pressure</li>
            </ul>

            <h3>🏛️ Historical Context</h3>
            <p>The <strong>pascal</strong> is named after Blaise Pascal, the French mathematician and physicist. The <strong>bar</strong> comes from the Greek word for weight. The <strong>torr</strong> is named after Evangelista Torricelli, inventor of the barometer. The <strong>atmosphere</strong> unit represents standard atmospheric pressure at sea level.</p>

            <h3>🎯 Key Conversions to Remember</h3>
            <ul>
                <li><strong>1 bar = 14.5038 psi ≈ 100,000 Pa</strong></li>
                <li><strong>1 atm = 14.6959 psi = 101,325 Pa</strong></li>
                <li><strong>1 psi = 6,894.76 Pa = 0.0689476 bar</strong></li>
                <li><strong>1 torr = 1 mmHg = 133.322 Pa</strong></li>
                <li><strong>1 inHg = 3,386.39 Pa = 0.0334211 atm</strong></li>
                <li><strong>1 MPa = 145.038 psi = 10 bar</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>📊 Universal Pressure Converter | All Major Units</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert pascal, bar, psi, atmosphere, torr, mmHg, and more</p>
        </div>
    </div>

    <script>
        // Conversion factors to pascals
        const toPascals = {
            pa: 1,
            kpa: 1000,
            mpa: 1000000,
            bar: 100000,
            mbar: 100,
            psi: 6894.76,
            atm: 101325,
            torr: 133.322,
            mmHg: 133.322,
            inhg: 3386.39
        };

        const unitNames = {
            pa: 'Pascal (Pa)',
            kpa: 'Kilopascal (kPa)',
            mpa: 'Megapascal (MPa)',
            bar: 'Bar (bar)',
            mbar: 'Millibar (mbar)',
            psi: 'Pound per Square Inch (psi)',
            atm: 'Atmosphere (atm)',
            torr: 'Torr (torr)',
            mmHg: 'Millimeter of Mercury (mmHg)',
            inhg: 'Inch of Mercury (inHg)'
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

            // Convert to pascals first
            const valueInPascals = inputValue * toPascals[fromUnit];
            
            // Convert to target unit
            const result = valueInPascals / toPascals[toUnit];
            
            document.getElementById('outputValue').value = formatNumber(result);
            
            displayAllConversions(valueInPascals);
        }

        function displayAllConversions(valueInPascals) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInPascals / toPascals[unit];
                
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