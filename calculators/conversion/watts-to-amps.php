<?php
/**
 * Watts to Amps Converter
 * File: conversion/watts-to-amps.php
 * Description: Convert power in watts to current in amps for DC, AC single phase, and AC three phase systems
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watts to Amps Converter - Electrical Power to Current Calculator</title>
    <meta name="description" content="Convert watts to amps for DC, AC single phase, and AC three phase systems. Calculate current from power and voltage.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .system-selector { margin-bottom: 25px; }
        .system-tabs { display: flex; gap: 10px; margin-bottom: 20px; }
        .system-tab { flex: 1; padding: 15px; text-align: center; background: #f8f9fa; border: 2px solid #e0e0e0; border-radius: 10px; cursor: pointer; transition: all 0.3s; }
        .system-tab.active { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); border-color: #a8edea; color: #2c3e50; font-weight: 600; }
        .system-tab:hover:not(.active) { border-color: #a8edea; }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #a8edea; box-shadow: 0 0 0 3px rgba(168, 237, 234, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; margin-top: 10px; }
        .unit-select:focus { outline: none; border-color: #a8edea; box-shadow: 0 0 0 3px rgba(168, 237, 234, 0.1); }
        
        .power-factor-group { margin-top: 15px; }
        .power-factor-info { font-size: 0.85rem; color: #7f8c8d; margin-top: 5px; }
        
        .swap-btn { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #f0fdfa 0%, #fdf2f8 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #a8edea; }
        .result-unit { color: #0d9488; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #0f766e; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #a8edea; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(168, 237, 234, 0.15); }
        .quick-value { font-weight: bold; color: #a8edea; font-size: 1rem; }
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
        .conversion-table tr:hover { background: #f0fdfa; }
        
        .formula-box { background: #f0fdfa; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #a8edea; }
        .formula-box strong { color: #a8edea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .converter-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .result-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .system-tabs { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚡ Watts to Amps Converter</h1>
            <p>Convert electrical power in watts to current in amps for DC, AC single phase, and AC three phase systems</p>
        </div>

        <div class="converter-card">
            <div class="system-selector">
                <h3 style="margin-bottom: 15px; color: #34495e;">🔧 Select Electrical System</h3>
                <div class="system-tabs">
                    <div class="system-tab active" onclick="selectSystem('dc')">DC System</div>
                    <div class="system-tab" onclick="selectSystem('ac1')">AC Single Phase</div>
                    <div class="system-tab" onclick="selectSystem('ac3')">AC Three Phase</div>
                </div>
            </div>

            <div class="converter-row">
                <div class="input-group">
                    <label for="inputWatts">Power (Watts)</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputWatts" placeholder="Enter watts" step="any" value="1000">
                    </div>
                </div>

                <button class="swap-btn" onclick="swapCalculation()" title="Swap calculation">⇄</button>

                <div class="input-group">
                    <label for="inputVoltage">Voltage (Volts)</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputVoltage" placeholder="Enter voltage" step="any" value="120">
                    </div>
                    <select id="voltageType" class="unit-select">
                        <option value="v" selected>Volts (V)</option>
                        <option value="kv">Kilovolts (kV)</option>
                    </select>
                </div>
            </div>

            <div id="acSettings" style="display: none;">
                <div class="converter-row">
                    <div class="input-group">
                        <label for="powerFactor">Power Factor</label>
                        <div class="input-wrapper">
                            <input type="number" id="powerFactor" placeholder="0.8" step="0.01" min="0" max="1" value="0.8">
                        </div>
                        <div class="power-factor-info">Typically 0.8-1.0 for most applications</div>
                    </div>
                    
                    <div style="display: flex; align-items: center; justify-content: center;">
                        <!-- Spacer for alignment -->
                    </div>
                    
                    <div class="input-group" id="threePhaseSettings" style="display: none;">
                        <label for="phaseConfiguration">Phase Configuration</label>
                        <select id="phaseConfiguration" class="unit-select">
                            <option value="line_to_line" selected>Line to Line (L-L)</option>
                            <option value="line_to_neutral">Line to Neutral (L-N)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="result-card" style="margin-top: 20px; text-align: center;">
                <div class="result-unit">CURRENT RESULT</div>
                <div class="result-value" id="currentResult" style="font-size: 1.5rem; color: #0d9488;">0 A</div>
                <div style="font-size: 0.9rem; color: #7f8c8d; margin-top: 8px;" id="resultDescription">DC Current</div>
            </div>

            <div class="quick-convert">
                <h3>🔌 Common Power Values</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setPower(100)">
                        <div class="quick-value">100W</div>
                        <div class="quick-label">Light bulb</div>
                    </div>
                    <div class="quick-btn" onclick="setPower(500)">
                        <div class="quick-value">500W</div>
                        <div class="quick-label">Small appliance</div>
                    </div>
                    <div class="quick-btn" onclick="setPower(1500)">
                        <div class="quick-value">1500W</div>
                        <div class="quick-label">Space heater</div>
                    </div>
                    <div class="quick-btn" onclick="setPower(5000)">
                        <div class="quick-value">5000W</div>
                        <div class="quick-label">Water heater</div>
                    </div>
                </div>
            </div>

            <div class="quick-convert">
                <h3>🏠 Common Voltage Values</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setVoltage(12)">
                        <div class="quick-value">12V</div>
                        <div class="quick-label">Car battery</div>
                    </div>
                    <div class="quick-btn" onclick="setVoltage(24)">
                        <div class="quick-value">24V</div>
                        <div class="quick-label">Industrial DC</div>
                    </div>
                    <div class="quick-btn" onclick="setVoltage(120)">
                        <div class="quick-value">120V</div>
                        <div class="quick-label">US household</div>
                    </div>
                    <div class="quick-btn" onclick="setVoltage(230)">
                        <div class="quick-value">230V</div>
                        <div class="quick-label">EU household</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⚡ Watts to Amps Conversion</h2>
            
            <p>Convert electrical power in watts to current in amperes for different electrical systems using Ohm's Law and power formulas.</p>

            <h3>📊 Conversion Formulas</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>System Type</th>
                        <th>Formula</th>
                        <th>Variables</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>DC System</strong></td>
                        <td>I = P / V</td>
                        <td>I = Current (A), P = Power (W), V = Voltage (V)</td>
                    </tr>
                    <tr>
                        <td><strong>AC Single Phase</strong></td>
                        <td>I = P / (V × PF)</td>
                        <td>PF = Power Factor (0-1)</td>
                    </tr>
                    <tr>
                        <td><strong>AC Three Phase</strong></td>
                        <td>I = P / (√3 × V × PF)</td>
                        <td>V = Line to Line Voltage</td>
                    </tr>
                    <tr>
                        <td><strong>AC Three Phase (L-N)</strong></td>
                        <td>I = P / (3 × V × PF)</td>
                        <td>V = Line to Neutral Voltage</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Ohm's Law Foundation:</strong><br>
                P = V × I (Power = Voltage × Current)<br>
                Therefore: I = P / V<br><br>
                For AC systems, we must account for power factor (PF) which represents the phase difference between voltage and current.
            </div>

            <h3>🔧 DC Systems</h3>
            <ul>
                <li><strong>Simple calculation:</strong> I = P / V</li>
                <li><strong>No power factor:</strong> PF is always 1 in DC systems</li>
                <li><strong>Applications:</strong> Batteries, solar panels, automotive, electronics</li>
                <li><strong>Examples:</strong> 12V car systems, 5V USB, 24V industrial controls</li>
            </ul>

            <h3>🏠 AC Single Phase Systems</h3>
            <div class="formula-box">
                <strong>Single Phase Formula:</strong><br>
                I = P / (V × PF)<br><br>
                <strong>Typical Power Factors:</strong><br>
                • Resistive loads (heaters, incandescent lights): 1.0<br>
                • Motor loads: 0.8-0.9<br>
                • Electronic devices: 0.6-0.8<br>
                • Poor power factor: &lt;0.7
            </div>

            <h3>🏭 AC Three Phase Systems</h3>
            <ul>
                <li><strong>Line to Line (L-L):</strong> I = P / (√3 × V × PF)</li>
                <li><strong>Line to Neutral (L-N):</strong> I = P / (3 × V × PF)</li>
                <li><strong>√3 ≈ 1.732:</strong> Constant for three-phase calculations</li>
                <li><strong>Applications:</strong> Industrial motors, large HVAC, manufacturing</li>
                <li><strong>Advantages:</strong> More efficient power transmission</li>
            </ul>

            <h3>📈 Common Power Factor Values</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Load Type</th>
                        <th>Typical Power Factor</th>
                        <th>Examples</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Resistive</td><td>1.0</td><td>Heaters, incandescent lights</td></tr>
                    <tr><td>Inductive (good)</td><td>0.9-0.95</td><td>Efficient motors, transformers</td></tr>
                    <tr><td>Inductive (typical)</td><td>0.8-0.85</td><td>Standard motors, fluorescent lights</td></tr>
                    <tr><td>Electronic</td><td>0.6-0.7</td><td>Computers, LED drivers, SMPS</td></tr>
                    <tr><td>Poor</td><td>&lt;0.6</td><td>Welding equipment, arc furnaces</td></tr>
                </tbody>
            </table>

            <h3>🔋 Real-World Examples</h3>
            <div class="formula-box">
                <strong>Household Appliances (120V):</strong><br>
                • 60W light bulb: 60W / 120V = 0.5A<br>
                • 1500W space heater: 1500W / 120V = 12.5A<br>
                • 800W microwave: 800W / 120V = 6.67A<br><br>
                <strong>Industrial Equipment (480V 3-phase, PF=0.8):</strong><br>
                • 10HP motor (7460W): 7460W / (1.732×480V×0.8) = 11.2A<br>
                • 50kW heater: 50000W / (1.732×480V×1.0) = 60.1A
            </div>

            <h3>⚡ Electrical Safety</h3>
            <ul>
                <li><strong>Circuit breakers:</strong> Typically 15A or 20A for household circuits</li>
                <li><strong>Wire sizing:</strong> Current determines wire gauge requirements</li>
                <li><strong>Voltage drop:</strong> Higher current = more voltage drop over distance</li>
                <li><strong>Overcurrent protection:</strong> Essential for fire prevention</li>
            </ul>

            <h3>🏗️ Wire Sizing Guidelines</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Current (A)</th>
                        <th>Wire Gauge (AWG)</th>
                        <th>Max Capacity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>0-15</td><td>14</td><td>15A</td></tr>
                    <tr><td>15-20</td><td>12</td><td>20A</td></tr>
                    <tr><td>20-30</td><td>10</td><td>30A</td></tr>
                    <tr><td>30-40</td><td>8</td><td>40A</td></tr>
                    <tr><td>40-55</td><td>6</td><td>55A</td></tr>
                    <tr><td>55-70</td><td>4</td><td>70A</td></tr>
                </tbody>
            </table>

            <h3>🌎 International Standards</h3>
            <ul>
                <li><strong>North America:</strong> 120V/240V single phase, 120/208V or 277/480V three phase</li>
                <li><strong>Europe:</strong> 230V single phase, 400V three phase</li>
                <li><strong>UK:</strong> 230V single phase, 400V three phase</li>
                <li><strong>Australia:</strong> 230V single phase, 400V three phase</li>
                <li><strong>Japan:</strong> 100V/200V, both 50Hz and 60Hz regions</li>
            </ul>

            <h3>🔍 Power Factor Correction</h3>
            <div class="formula-box">
                <strong>Why Power Factor Matters:</strong><br>
                • Low PF increases current for same power<br>
                • Higher current = larger wires, bigger equipment<br>
                • Utilities may charge penalties for low PF<br>
                • Capacitors can improve power factor<br><br>
                <strong>Benefits of High PF:</strong><br>
                • Reduced energy costs<br>
                • Smaller conductors required<br>
                • Better voltage regulation<br>
                • Increased system capacity
            </div>

            <h3>💡 Practical Tips</h3>
            <ul>
                <li>Always use the correct formula for your system type</li>
                <li>Include power factor for AC calculations</li>
                <li>Consider adding 20% safety margin for continuous loads</li>
                <li>Verify local electrical codes and standards</li>
                <li>Consult qualified electrician for installation work</li>
            </ul>

            <h3>🎯 Key Formulas to Remember</h3>
            <ul>
                <li><strong>DC:</strong> Amps = Watts / Volts</li>
                <li><strong>AC Single Phase:</strong> Amps = Watts / (Volts × Power Factor)</li>
                <li><strong>AC Three Phase:</strong> Amps = Watts / (1.732 × Volts × Power Factor)</li>
                <li><strong>Three Phase L-N:</strong> Amps = Watts / (3 × Volts × Power Factor)</li>
            </ul>

            <h3>⚠️ Safety First</h3>
            <div class="formula-box">
                <strong>Electrical Safety Guidelines:</strong><br>
                • Always turn off power before working on circuits<br>
                • Use appropriate personal protective equipment<br>
                • Follow local electrical codes and regulations<br>
                • Never exceed circuit breaker ratings<br>
                • Regular maintenance and inspections are essential<br>
                • When in doubt, consult a licensed electrician
            </div>
        </div>

        <div class="footer">
            <p>⚡ Watts to Amps Converter | DC & AC Systems</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert electrical power to current with power factor correction</p>
        </div>
    </div>

    <script>
        let currentSystem = 'dc';

        function selectSystem(system) {
            currentSystem = system;
            
            // Update tab styles
            document.querySelectorAll('.system-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Show/hide AC settings
            const acSettings = document.getElementById('acSettings');
            const threePhaseSettings = document.getElementById('threePhaseSettings');
            
            if (system === 'dc') {
                acSettings.style.display = 'none';
            } else {
                acSettings.style.display = 'block';
                if (system === 'ac3') {
                    threePhaseSettings.style.display = 'block';
                } else {
                    threePhaseSettings.style.display = 'none';
                }
            }
            
            calculateCurrent();
        }

        function calculateCurrent() {
            const watts = parseFloat(document.getElementById('inputWatts').value);
            let voltage = parseFloat(document.getElementById('inputVoltage').value);
            const voltageType = document.getElementById('voltageType').value;
            
            // Convert kV to V if needed
            if (voltageType === 'kv') {
                voltage = voltage * 1000;
            }
            
            if (isNaN(watts) || isNaN(voltage) || voltage === 0) {
                document.getElementById('currentResult').textContent = '0 A';
                return;
            }
            
            let current = 0;
            let description = '';
            
            switch (currentSystem) {
                case 'dc':
                    current = watts / voltage;
                    description = 'DC Current';
                    break;
                    
                case 'ac1':
                    const pf1 = parseFloat(document.getElementById('powerFactor').value) || 0.8;
                    current = watts / (voltage * pf1);
                    description = 'AC Single Phase Current';
                    break;
                    
                case 'ac3':
                    const pf3 = parseFloat(document.getElementById('powerFactor').value) || 0.8;
                    const phaseConfig = document.getElementById('phaseConfiguration').value;
                    
                    if (phaseConfig === 'line_to_line') {
                        current = watts / (1.732 * voltage * pf3); // √3 ≈ 1.732
                        description = 'AC Three Phase Current (L-L)';
                    } else {
                        current = watts / (3 * voltage * pf3);
                        description = 'AC Three Phase Current (L-N)';
                    }
                    break;
            }
            
            document.getElementById('currentResult').textContent = formatNumber(current) + ' A';
            document.getElementById('resultDescription').textContent = description;
        }

        function swapCalculation() {
            // For watts to amps, swapping doesn't make sense in the same way
            // Instead, we can swap between common voltage values
            const currentVoltage = parseFloat(document.getElementById('inputVoltage').value);
            
            if (currentVoltage === 120) {
                setVoltage(230);
            } else if (currentVoltage === 230) {
                setVoltage(120);
            } else if (currentVoltage === 12) {
                setVoltage(24);
            } else if (currentVoltage === 24) {
                setVoltage(12);
            } else {
                setVoltage(120); // Default to 120V
            }
        }

        function formatNumber(num) {
            if (isNaN(num)) return '0';
            if (Math.abs(num) < 0.001) {
                return num.toExponential(4);
            }
            return num.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 3
            });
        }

        function setPower(watts) {
            document.getElementById('inputWatts').value = watts;
            calculateCurrent();
        }

        function setVoltage(volts) {
            document.getElementById('inputVoltage').value = volts;
            calculateCurrent();
        }

        // Auto-calculate on input
        document.getElementById('inputWatts').addEventListener('input', calculateCurrent);
        document.getElementById('inputVoltage').addEventListener('input', calculateCurrent);
        document.getElementById('powerFactor').addEventListener('input', calculateCurrent);
        document.getElementById('voltageType').addEventListener('change', calculateCurrent);
        document.getElementById('phaseConfiguration').addEventListener('change', calculateCurrent);

        // Initial calculation
        calculateCurrent();
    </script>
</body>
</html>