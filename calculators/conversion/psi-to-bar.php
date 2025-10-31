<?php
/**
 * PSI to Bar Converter
 * File: conversion/psi-to-bar.php
 * Description: Convert between PSI and Bar pressure units with detailed pressure information
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSI to Bar Converter - Pressure Unit Conversion Calculator</title>
    <meta name="description" content="Convert between PSI and Bar pressure units with precision. Essential for automotive, industrial, and scientific applications.">
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
        .result-card { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #4facfe; }
        .result-unit { color: #0984e3; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #00cec9; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #4facfe; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(79, 172, 254, 0.15); }
        .quick-value { font-weight: bold; color: #4facfe; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .common-pressures { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .common-pressures h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #a8edea; }
        
        .formula-box { background: #a8edea; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #4facfe; }
        .formula-box strong { color: #4facfe; }
        
        .safety-box { background: #ffeaa7; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #fdcb6e; }
        
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
            <h1>🔵 PSI to Bar Converter</h1>
            <p>Convert between PSI and Bar pressure units with precision. Essential for automotive, industrial, and scientific applications.</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="psi" selected>Pound per Square Inch (PSI)</option>
                        <option value="bar">Bar</option>
                        <option value="kpa">Kilopascal (kPa)</option>
                        <option value="mpa">Megapascal (MPa)</option>
                        <option value="atm">Atmosphere (atm)</option>
                        <option value="torr">Torr (mmHg)</option>
                        <option value="inhg">Inches of Mercury (inHg)</option>
                        <option value="kgcm2">kg/cm²</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="psi">Pound per Square Inch (PSI)</option>
                        <option value="bar" selected>Bar</option>
                        <option value="kpa">Kilopascal (kPa)</option>
                        <option value="mpa">Megapascal (MPa)</option>
                        <option value="atm">Atmosphere (atm)</option>
                        <option value="torr">Torr (mmHg)</option>
                        <option value="inhg">Inches of Mercury (inHg)</option>
                        <option value="kgcm2">kg/cm²</option>
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

            <div class="common-pressures">
                <h3>🎯 Common Pressure Values</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setCommonPressure(14.7, 'Atmospheric pressure at sea level')">
                        <div class="quick-value">14.7 PSI</div>
                        <div class="quick-label">Atmospheric</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonPressure(32, 'Standard car tire pressure')">
                        <div class="quick-value">32 PSI</div>
                        <div class="quick-label">Car Tire</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonPressure(100, 'High-pressure applications')">
                        <div class="quick-value">100 PSI</div>
                        <div class="quick-label">High Pressure</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonPressure(3000, 'Scuba tank pressure')">
                        <div class="quick-value">3000 PSI</div>
                        <div class="quick-label">Scuba Tank</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🔵 Pressure Unit Conversion</h2>
            
            <p>Convert between PSI, Bar, and other pressure units used worldwide for automotive, industrial, scientific, and everyday applications.</p>

            <h3>📊 Conversion Factors to Bar</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Bar Equivalent</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Bar</td><td>bar</td><td>1</td></tr>
                    <tr><td>Pound per Square Inch</td><td>PSI</td><td>0.0689476</td></tr>
                    <tr><td>Kilopascal</td><td>kPa</td><td>0.01</td></tr>
                    <tr><td>Megapascal</td><td>MPa</td><td>10</td></tr>
                    <tr><td>Atmosphere</td><td>atm</td><td>1.01325</td></tr>
                    <tr><td>Torr (mmHg)</td><td>torr</td><td>0.00133322</td></tr>
                    <tr><td>Inches of Mercury</td><td>inHg</td><td>0.0338639</td></tr>
                    <tr><td>Kilogram per cm²</td><td>kg/cm²</td><td>0.980665</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Conversion Formulas:</strong><br>
                • 1 PSI = 0.0689476 bar<br>
                • 1 bar = 14.5038 PSI<br>
                • 1 kPa = 0.01 bar<br>
                • 1 atm = 1.01325 bar = 14.6959 PSI<br>
                • 1 MPa = 10 bar = 145.038 PSI<br>
                • 1 torr = 1 mmHg = 0.00133322 bar
            </div>

            <h3>🚗 Automotive Applications</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Typical Pressure</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Car tires</td><td>30-35 PSI (2.1-2.4 bar)</td><td>Check when cold</td></tr>
                    <tr><td>Bicycle tires</td><td>40-65 PSI (2.8-4.5 bar)</td><td>Road bikes higher pressure</td></tr>
                    <tr><td>Motorcycle tires</td><td>28-40 PSI (1.9-2.8 bar)</td><td>Varies by bike type</td></tr>
                    <tr><td>Truck tires</td><td>80-125 PSI (5.5-8.6 bar)</td><td>Heavy load capacity</td></tr>
                    <tr><td>Fuel injection</td><td>30-85 PSI (2.1-5.9 bar)</td><td>Gasoline engines</td></tr>
                </tbody>
            </table>

            <div class="safety-box">
                <strong>⚠️ Pressure Safety:</strong><br>
                • Always use appropriate pressure gauges<br>
                • Never exceed recommended pressure limits<br>
                • Wear safety glasses when working with pressurized systems<br>
                • Release pressure slowly and safely<br>
                • Follow manufacturer specifications
            </div>

            <h3>🏭 Industrial & Manufacturing</h3>
            <ul>
                <li><strong>Hydraulic systems:</strong> 1,000-5,000 PSI (69-345 bar)</li>
                <li><strong>Pneumatic tools:</strong> 90-120 PSI (6.2-8.3 bar)</li>
                <li><strong>Compressed air lines:</strong> 100-150 PSI (6.9-10.3 bar)</li>
                <li><strong>Industrial boilers:</strong> 150-1,200 PSI (10.3-82.7 bar)</li>
                <li><strong>Water jet cutting:</strong> 30,000-90,000 PSI (2,068-6,205 bar)</li>
            </ul>

            <h3>⚕️ Medical & Healthcare</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Pressure Range</th>
                        <th>Purpose</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Blood pressure</td><td>120/80 mmHg</td><td>Normal adult reading</td></tr>
                    <tr><td>Oxygen tanks</td><td>2,000-3,000 PSI</td><td>Medical oxygen storage</td></tr>
                    <tr><td>Anesthesia machines</td><td>45-60 PSI</td><td>Medical gas delivery</td></tr>
                    <tr><td>CPAP machines</td><td>4-20 cmH₂O</td><td>Sleep apnea treatment</td></tr>
                </tbody>
            </table>

            <h3>🌡️ Scientific & Laboratory</h3>
            <div class="formula-box">
                <strong>Scientific Pressure Ranges:</strong><br>
                • High vacuum: 10⁻³ to 10⁻⁸ bar<br>
                • Ultra-high vacuum: <10⁻⁸ bar<br>
                • High-pressure research: 10,000-1,000,000 bar<br>
                • Deep ocean pressure: Up to 1,100 bar (Mariana Trench)<br>
                • Industrial processes: 1-1,000 bar
            </div>

            <h3>🏠 Household Applications</h3>
            <ul>
                <li><strong>Water pressure:</strong> 40-80 PSI (2.8-5.5 bar) typical home</li>
                <li><strong>Pressure cookers:</strong> 15 PSI (1 bar) standard</li>
                <li><strong>Gas grills:</strong> 0.25-2 PSI (0.017-0.14 bar) propane</li>
                <li><strong>Air conditioning:</strong> 100-400 PSI (6.9-27.6 bar) refrigerant</li>
                <li><strong>Fire extinguishers:</strong> 100-300 PSI (6.9-20.7 bar)</li>
            </ul>

            <h3>🌊 Diving & Underwater</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Depth</th>
                        <th>Pressure</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Sea level</td><td>14.7 PSI (1 bar)</td><td>Atmospheric pressure</td></tr>
                    <tr><td>33 feet (10 m)</td><td>29.4 PSI (2 bar)</td><td>Double atmospheric pressure</td></tr>
                    <tr><td>66 feet (20 m)</td><td>44.1 PSI (3 bar)</td><td>Recreational diving limit</td></tr>
                    <tr><td>100 feet (30 m)</td><td>58.8 PSI (4 bar)</td><td>Advanced recreational diving</td></tr>
                    <tr><td>Mariana Trench</td><td>16,000 PSI (1,100 bar)</td><td>Deepest ocean point</td></tr>
                </tbody>
            </table>

            <h3>✈️ Aviation & Aerospace</h3>
            <ul>
                <li><strong>Cabin pressure:</strong> 11-12 PSI (0.76-0.83 bar) at cruising altitude</li>
                <li><strong>Oxygen systems:</td><td>1,800-2,200 PSI (124-152 bar)</li>
                <li><strong>Hydraulic systems:</strong> 3,000 PSI (207 bar) aircraft</li>
                <li><strong>Space suit:</strong> 4.3 PSI (0.3 bar) pure oxygen</li>
                <li><strong>Rocket fuel:</strong> Up to 3,000 PSI (207 bar) pressure-fed systems</li>
            </ul>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>PSI ↔ Bar:</strong><br>
                • Multiply PSI by 0.07 for rough bar<br>
                • Multiply bar by 14.5 for rough PSI<br><br>
                <strong>PSI ↔ kPa:</strong><br>
                • Multiply PSI by 7 for rough kPa<br>
                • Divide kPa by 7 for rough PSI<br><br>
                <strong>Bar ↔ atm:</strong><br>
                • 1 bar ≈ 1 atmosphere (0.987 atm exact)
            </div>

            <h3>🌎 Regional Standards</h3>
            <ul>
                <li><strong>United States:</strong> Primarily uses PSI for most applications</li>
                <li><strong>Europe:</strong> Primarily uses Bar and kPa</li>
                <li><strong>Automotive:</strong> Mixed usage worldwide (PSI in US, Bar in Europe)</li>
                <li><strong>Scientific:</strong> SI units (Pascals) with conversions</li>
                <li><strong>Industrial:</strong> Varies by industry and region</li>
            </ul>

            <h3>⚖️ Historical Context</h3>
            <p>The <strong>PSI</strong> (Pound per Square Inch) comes from the imperial system, while the <strong>Bar</strong> was introduced in the early 20th century as a metric unit approximately equal to atmospheric pressure. The Pascal (Pa) is the SI unit for pressure, named after Blaise Pascal. Standard atmospheric pressure was originally defined as 760 mmHg at 0°C.</p>

            <h3>🔧 Pressure Measurement Tools</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Tool</th>
                        <th>Typical Range</th>
                        <th>Applications</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Tire pressure gauge</td><td>0-100 PSI</td><td>Automotive tires</td></tr>
                    <tr><td>Bourdon tube gauge</td><td>Up to 100,000 PSI</td><td>Industrial applications</td></tr>
                    <tr><td>Digital manometer</td><td>0.001 to 10,000 PSI</td><td>Precision measurement</td></tr>
                    <tr><td>Pressure transducer</td><td>Wide range</td><td>Electronic systems</td></tr>
                    <tr><td>Deadweight tester</td><td>High precision</td><td>Calibration standard</td></tr>
                </tbody>
            </table>

            <h3>🎯 Key Conversions to Remember</h3>
            <ul>
                <li><strong>1 PSI = 0.0689476 bar</strong></li>
                <li><strong>1 bar = 14.5038 PSI</strong></li>
                <li><strong>1 atm = 14.6959 PSI = 1.01325 bar</strong></li>
                <li><strong>1 kPa = 0.145038 PSI = 0.01 bar</strong></li>
                <li><strong>1 MPa = 145.038 PSI = 10 bar</strong></li>
                <li><strong>Standard atmosphere: 14.7 PSI = 1.01325 bar</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>🔵 PSI to Bar Converter | Complete Pressure Unit Conversion</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert PSI, Bar, kPa, MPa, atm, and other pressure units with precision</p>
        </div>
    </div>

    <script>
        // Conversion factors to bar
        const toBar = {
            bar: 1,
            psi: 0.0689476,
            kpa: 0.01,
            mpa: 10,
            atm: 1.01325,
            torr: 0.00133322,
            inhg: 0.0338639,
            kgcm2: 0.980665
        };

        const unitNames = {
            bar: 'Bar',
            psi: 'Pound per Square Inch (PSI)',
            kpa: 'Kilopascal (kPa)',
            mpa: 'Megapascal (MPa)',
            atm: 'Atmosphere (atm)',
            torr: 'Torr (mmHg)',
            inhg: 'Inches of Mercury (inHg)',
            kgcm2: 'kg/cm²'
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

            // Convert to bar first
            const valueInBar = inputValue * toBar[fromUnit];
            
            // Convert to target unit
            const result = valueInBar / toBar[toUnit];
            
            document.getElementById('outputValue').value = formatNumber(result);
            
            displayAllConversions(valueInBar);
        }

        function displayAllConversions(valueInBar) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInBar / toBar[unit];
                
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
                maximumFractionDigits: 4
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

        function setCommonPressure(value, description) {
            document.getElementById('inputValue').value = value;
            document.getElementById('fromUnit').value = 'psi';
            document.getElementById('toUnit').value = 'bar';
            convert();
            // Optional: Show a tooltip or notification about the description
            console.log(description); // Could be enhanced with a toast notification
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