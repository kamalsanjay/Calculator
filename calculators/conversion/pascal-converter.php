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
    <title>Pascal Converter - Pa to PSI, Bar, Atm Pressure Calculator</title>
    <meta name="description" content="Convert Pascal to PSI, bar, atmosphere, and other pressure units. Universal pressure converter.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-section { margin-bottom: 25px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 90px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #0072ff; box-shadow: 0 0 0 3px rgba(0, 114, 255, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #0072ff; font-weight: 600; font-size: 0.95rem; }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #0072ff; }
        .result-unit { color: #01579b; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-value { font-size: 1.8rem; font-weight: bold; color: #0277bd; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #0072ff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 114, 255, 0.15); }
        .quick-value { font-weight: bold; color: #0072ff; font-size: 1rem; }
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
        
        .formula-box { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #0072ff; }
        .formula-box strong { color: #0072ff; }
        
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
            <h1>🔧 Pascal Pressure Converter</h1>
            <p>Convert Pascal to PSI, bar, atmosphere, and all pressure units</p>
        </div>

        <div class="converter-card">
            <div class="input-section">
                <div class="input-group">
                    <label for="pascalInput">Pressure in Pascal (Pa)</label>
                    <div class="input-wrapper">
                        <input type="number" id="pascalInput" placeholder="Enter Pascal" step="0.01" min="0" value="100000">
                        <span class="unit-label">Pa</span>
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid">
                <div class="result-card">
                    <div class="result-unit">Kilopascal (kPa)</div>
                    <div class="result-value" id="kpaValue">100 kPa</div>
                </div>
                <div class="result-card">
                    <div class="result-unit">Bar</div>
                    <div class="result-value" id="barValue">1.00 bar</div>
                </div>
                <div class="result-card">
                    <div class="result-unit">PSI</div>
                    <div class="result-value" id="psiValue">14.50 PSI</div>
                </div>
                <div class="result-card">
                    <div class="result-unit">Atmosphere (atm)</div>
                    <div class="result-value" id="atmValue">0.987 atm</div>
                </div>
                <div class="result-card">
                    <div class="result-unit">Torr (mmHg)</div>
                    <div class="result-value" id="torrValue">750.06 Torr</div>
                </div>
                <div class="result-card">
                    <div class="result-unit">Millibar (mbar)</div>
                    <div class="result-value" id="mbarValue">1000 mbar</div>
                </div>
            </div>

            <div class="quick-convert">
                <h3>🔧 Common Pressures</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setPascal(101325)">
                        <div class="quick-value">101,325 Pa</div>
                        <div class="quick-label">1 atm</div>
                    </div>
                    <div class="quick-btn" onclick="setPascal(100000)">
                        <div class="quick-value">100,000 Pa</div>
                        <div class="quick-label">1 bar</div>
                    </div>
                    <div class="quick-btn" onclick="setPascal(6895)">
                        <div class="quick-value">6,895 Pa</div>
                        <div class="quick-label">1 PSI</div>
                    </div>
                    <div class="quick-btn" onclick="setPascal(200000)">
                        <div class="quick-value">200,000 Pa</div>
                        <div class="quick-label">Tire Pressure</div>
                    </div>
                    <div class="quick-btn" onclick="setPascal(1000000)">
                        <div class="quick-value">1,000,000 Pa</div>
                        <div class="quick-label">High Pressure</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🔧 Pascal Pressure Unit</h2>
            
            <p>The <strong>Pascal (Pa)</strong> is the SI unit of pressure, named after Blaise Pascal. It's defined as one newton per square meter.</p>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>Pascal to Other Units:</strong><br>
                • Kilopascal (kPa) = Pascal ÷ 1,000<br>
                • Bar = Pascal ÷ 100,000<br>
                • PSI = Pascal ÷ 6,894.76<br>
                • Atmosphere (atm) = Pascal ÷ 101,325<br>
                • Torr (mmHg) = Pascal ÷ 133.322<br>
                • Millibar (mbar) = Pascal ÷ 100<br><br>
                <strong>Base Definition:</strong><br>
                • 1 Pascal = 1 Newton/meter² = 1 kg/(m·s²)
            </div>

            <h3>📊 Pressure Unit Comparison</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Pascal (Pa)</th>
                        <th>Common Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 Pascal</td><td>1 Pa</td><td>SI base unit</td></tr>
                    <tr><td>1 Kilopascal</td><td>1,000 Pa</td><td>Engineering</td></tr>
                    <tr><td>1 Bar</td><td>100,000 Pa</td><td>Meteorology</td></tr>
                    <tr><td>1 PSI</td><td>6,894.76 Pa</td><td>US industry</td></tr>
                    <tr><td>1 Atmosphere</td><td>101,325 Pa</td><td>Standard pressure</td></tr>
                    <tr><td>1 Torr</td><td>133.322 Pa</td><td>Vacuum systems</td></tr>
                    <tr><td>1 Millibar</td><td>100 Pa</td><td>Aviation</td></tr>
                </tbody>
            </table>

            <h3>🚗 Tire Pressure</h3>
            <ul>
                <li><strong>Car tires:</strong> 200-250 kPa (29-36 PSI)</li>
                <li><strong>Truck tires:</strong> 550-700 kPa (80-100 PSI)</li>
                <li><strong>Bicycle tires:</strong> 400-900 kPa (60-130 PSI)</li>
                <li><strong>Motorcycle tires:</strong> 200-300 kPa (29-43 PSI)</li>
                <li><strong>Aircraft tires:</strong> 1,500-2,000 kPa (220-290 PSI)</li>
            </ul>

            <h3>🌍 Atmospheric Pressure</h3>
            <div class="formula-box">
                <strong>Standard Atmosphere:</strong><br>
                • Sea level: 101,325 Pa (1 atm)<br>
                • 1,000 m altitude: ~90,000 Pa<br>
                • 3,000 m altitude: ~70,000 Pa<br>
                • 5,000 m altitude: ~54,000 Pa<br>
                • Mt. Everest (8,848 m): ~33,000 Pa<br><br>
                <strong>Weather Systems:</strong><br>
                • High pressure: > 102,000 Pa (1020 mbar)<br>
                • Low pressure: < 100,000 Pa (1000 mbar)<br>
                • Hurricane center: ~88,000 Pa (880 mbar)
            </div>

            <h3>💨 Wind & Weather</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Condition</th>
                        <th>Pressure (Pa)</th>
                        <th>Pressure (mbar)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>High pressure system</td><td>102,000-103,500 Pa</td><td>1020-1035 mbar</td></tr>
                    <tr><td>Normal pressure</td><td>101,325 Pa</td><td>1013.25 mbar</td></tr>
                    <tr><td>Low pressure system</td><td>99,000-100,000 Pa</td><td>990-1000 mbar</td></tr>
                    <tr><td>Tropical storm</td><td>~98,000 Pa</td><td>~980 mbar</td></tr>
                    <tr><td>Hurricane Cat 1</td><td>~98,000 Pa</td><td>~980 mbar</td></tr>
                    <tr><td>Hurricane Cat 5</td><td>< 92,000 Pa</td><td>< 920 mbar</td></tr>
                </tbody>
            </table>

            <h3>🏭 Industrial Applications</h3>
            <ul>
                <li><strong>HVAC systems:</strong> 100-500 Pa pressure difference</li>
                <li><strong>Hydraulic systems:</strong> 10-35 MPa (10-35 million Pa)</li>
                <li><strong>Pneumatic tools:</strong> 600-900 kPa (90-130 PSI)</li>
                <li><strong>Compressed air:</strong> 700-1,000 kPa (100-145 PSI)</li>
                <li><strong>Steam boilers:</strong> 1-20 MPa (10-200 bar)</li>
            </ul>

            <h3>🔬 Laboratory & Scientific</h3>
            <div class="formula-box">
                <strong>Vacuum Levels:</strong><br>
                • Low vacuum: 10³-10⁵ Pa<br>
                • Medium vacuum: 10⁻¹-10³ Pa<br>
                • High vacuum: 10⁻⁷-10⁻¹ Pa<br>
                • Ultra-high vacuum: < 10⁻⁷ Pa<br><br>
                <strong>Gas Cylinders:</strong><br>
                • CO₂ cylinder: ~5,700,000 Pa (57 bar)<br>
                • Oxygen medical: ~13,800,000 Pa (138 bar)<br>
                • Scuba tank: ~20,000,000 Pa (200 bar)
            </div>

            <h3>🏊 Water Pressure</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Depth</th>
                        <th>Pressure (Pa)</th>
                        <th>Pressure (atm)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Surface</td><td>101,325 Pa</td><td>1 atm</td></tr>
                    <tr><td>10 meters</td><td>~200,000 Pa</td><td>~2 atm</td></tr>
                    <tr><td>50 meters</td><td>~600,000 Pa</td><td>~6 atm</td></tr>
                    <tr><td>100 meters</td><td>~1,100,000 Pa</td><td>~11 atm</td></tr>
                    <tr><td>1,000 meters</td><td>~10,100,000 Pa</td><td>~100 atm</td></tr>
                    <tr><td>Mariana Trench</td><td>~110,000,000 Pa</td><td>~1,100 atm</td></tr>
                </tbody>
            </table>

            <h3>🏠 Household Pressures</h3>
            <ul>
                <li><strong>Water supply:</strong> 300-600 kPa (45-85 PSI)</li>
                <li><strong>Garden hose:</strong> 200-400 kPa (30-60 PSI)</li>
                <li><strong>Natural gas line:</strong> 2-7 kPa (0.3-1 PSI)</li>
                <li><strong>Pressure washer:</strong> 7,000-20,000 kPa (1,000-3,000 PSI)</li>
                <li><strong>Espresso machine:</strong> 900 kPa (9 bar, 130 PSI)</li>
            </ul>

            <h3>✈️ Aviation Pressure</h3>
            <div class="formula-box">
                <strong>Cabin Pressure:</strong><br>
                • Ground level: 101,325 Pa (1 atm)<br>
                • Typical cruise cabin: 75,000-81,000 Pa (0.75-0.8 atm)<br>
                • Equivalent altitude: 1,800-2,400 m (6,000-8,000 ft)<br><br>
                <strong>Altitude Pressure:</strong><br>
                • 10,000 ft: ~70,000 Pa<br>
                • 35,000 ft (cruise): ~23,000 Pa<br>
                • 60,000 ft: ~5,500 Pa
            </div>

            <h3>🏥 Medical Applications</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Measurement</th>
                        <th>Pressure</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Blood pressure (120/80)</td><td>16,000/10,700 Pa (120/80 mmHg)</td></tr>
                    <tr><td>Hyperbaric oxygen</td><td>~250,000 Pa (2.5 atm)</td></tr>
                    <tr><td>CPAP therapy</td><td>400-2,000 Pa (4-20 mbar)</td></tr>
                    <tr><td>Spinal fluid</td><td>700-1,800 Pa (7-18 cmH₂O)</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>Pascal Approximations:</strong><br>
                • 1 kPa ≈ 0.15 PSI<br>
                • 100 kPa ≈ 1 bar ≈ 1 atm<br>
                • 7 kPa ≈ 1 PSI<br>
                • 100 Pa = 1 mbar<br>
                • 1,000 Pa = 1 kPa<br>
                • 101,325 Pa = 1 atmosphere (exact)
            </div>

            <h3>🌡️ Temperature & Pressure</h3>
            <p>Pressure and temperature are related through gas laws:</p>
            <ul>
                <li><strong>Gay-Lussac's Law:</strong> P/T = constant (at constant volume)</li>
                <li><strong>Ideal Gas Law:</strong> PV = nRT</li>
                <li><strong>Effect:</strong> Tire pressure increases ~7 kPa per 10°C rise</li>
                <li><strong>Standard conditions:</strong> 101,325 Pa at 0°C (STP)</li>
            </ul>

            <h3>🔊 Sound Pressure</h3>
            <div class="formula-box">
                <strong>Sound Pressure Levels:</strong><br>
                • Threshold of hearing: 20 μPa (0.00002 Pa)<br>
                • Normal conversation: ~0.02 Pa<br>
                • Busy street: ~0.2 Pa<br>
                • Threshold of pain: ~20 Pa<br>
                • Jet engine: ~200 Pa
            </div>

            <h3>⚙️ Engineering Standards</h3>
            <ul>
                <li><strong>Structural analysis:</strong> Uses Pa and MPa</li>
                <li><strong>Fluid dynamics:</strong> Pascals for pressure drop</li>
                <li><strong>Material testing:</strong> Stress in MPa or GPa</li>
                <li><strong>Pipe flow:</strong> kPa per 100 meters</li>
            </ul>

            <h3>🌊 Oceanography</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Pressure Range</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Recreational diving</td><td>100,000-600,000 Pa (1-6 atm)</td></tr>
                    <tr><td>Technical diving</td><td>600,000-1,500,000 Pa (6-15 atm)</td></tr>
                    <tr><td>Submarine operations</td><td>Up to 5,000,000 Pa (50 atm)</td></tr>
                    <tr><td>Deep-sea research</td><td>10,000,000-110,000,000 Pa</td></tr>
                </tbody>
            </table>

            <h3>🏛️ Historical Context</h3>
            <p>The <strong>Pascal</strong> was named after Blaise Pascal (1623-1662), a French mathematician and physicist who made significant contributions to fluid mechanics and pressure studies. The unit was officially adopted in 1971 as part of the International System of Units (SI).</p>

            <h3>🔑 Key Conversions</h3>
            <ul>
                <li><strong>1 Pascal = 1 N/m²</strong> (exact definition)</li>
                <li><strong>1 kPa = 1,000 Pa</strong></li>
                <li><strong>1 bar = 100,000 Pa = 100 kPa</strong></li>
                <li><strong>1 PSI = 6,894.76 Pa ≈ 6.9 kPa</strong></li>
                <li><strong>1 atm = 101,325 Pa ≈ 101.3 kPa</strong></li>
                <li><strong>1 Torr = 133.322 Pa</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>🔧 Accurate Pascal Pressure Conversion | All Pressure Units</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for engineering, science, weather, and pressure measurements</p>
        </div>
    </div>

    <script>
        function convertPascal() {
            const pascal = parseFloat(document.getElementById('pascalInput').value);
            
            if (isNaN(pascal) || pascal < 0) {
                return;
            }

            // Pascal to other units
            const kpa = pascal / 1000;
            const bar = pascal / 100000;
            const psi = pascal / 6894.76;
            const atm = pascal / 101325;
            const torr = pascal / 133.322;
            const mbar = pascal / 100;
            
            document.getElementById('kpaValue').textContent = kpa.toFixed(2) + ' kPa';
            document.getElementById('barValue').textContent = bar.toFixed(5) + ' bar';
            document.getElementById('psiValue').textContent = psi.toFixed(2) + ' PSI';
            document.getElementById('atmValue').textContent = atm.toFixed(5) + ' atm';
            document.getElementById('torrValue').textContent = torr.toFixed(2) + ' Torr';
            document.getElementById('mbarValue').textContent = mbar.toFixed(2) + ' mbar';
        }

        function setPascal(value) {
            document.getElementById('pascalInput').value = value;
            convertPascal();
        }

        // Auto-convert on input
        document.getElementById('pascalInput').addEventListener('input', convertPascal);

        // Initial conversion
        convertPascal();
    </script>
</body>
</html>