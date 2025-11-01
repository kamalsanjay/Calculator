<?php
/**
 * Ohm's Law Calculator
 * File: electronics/ohms-law-calculator.php
 * Description: Advanced Ohm's Law calculator for electrical calculations
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ohm's Law Calculator - Electrical Circuit Calculations</title>
    <meta name="description" content="Advanced Ohm's Law calculator for voltage, current, resistance, and power calculations in electrical circuits.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #667eea; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); position: relative; overflow: hidden; }
        .result-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 0.8; } }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; position: relative; z-index: 1; }
        .result-card .amount { font-size: 3rem; font-weight: bold; position: relative; z-index: 1; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #667eea; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #667eea; font-size: 1.8rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #667eea; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .progress-bar { background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); width: 0%; transition: width 1s ease-out; }
        
        .info-box { background: #e8f2ff; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #667eea; }
        
        .preset-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 8px; margin-top: 10px; }
        .preset-btn { padding: 8px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .preset-btn:hover { background: #667eea; color: white; border-color: #667eea; }
        .preset-btn.active { background: #667eea; color: white; border-color: #667eea; }
        
        .circuit-diagram { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; text-align: center; }
        .circuit-svg { max-width: 100%; height: auto; }
        
        .formula-section { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .formula-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; }
        .formula-card { background: white; padding: 15px; border-radius: 8px; text-align: center; border: 2px solid #e0e0e0; }
        .formula-card h4 { color: #667eea; margin-bottom: 10px; }
        .formula-card .formula { font-family: 'Courier New', monospace; font-size: 1.2rem; font-weight: bold; color: #333; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .preset-buttons { grid-template-columns: repeat(2, 1fr); }
            .formula-grid { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚡ Ohm's Law Calculator</h1>
            <p>Calculate voltage, current, resistance, and power in electrical circuits</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Circuit Parameters</h2>
                <form id="ohmsLawForm">
                    <div class="form-group">
                        <label for="calculationType">Calculate</label>
                        <select id="calculationType" style="padding: 12px;">
                            <option value="voltage">Voltage (V)</option>
                            <option value="current">Current (I)</option>
                            <option value="resistance">Resistance (R)</option>
                            <option value="power">Power (P)</option>
                        </select>
                        <small>Select what you want to calculate</small>
                    </div>
                    
                    <div class="form-group" id="voltageGroup">
                        <label for="voltage">Voltage (V)</label>
                        <div class="input-group">
                            <input type="number" id="voltage" value="12" min="0.001" step="0.001" required>
                            <select id="voltageUnit" style="padding: 12px;">
                                <option value="V" selected>Volts (V)</option>
                                <option value="mV">Millivolts (mV)</option>
                                <option value="kV">Kilovolts (kV)</option>
                            </select>
                        </div>
                        <small>Electrical potential difference</small>
                    </div>
                    
                    <div class="form-group" id="currentGroup">
                        <label for="current">Current (I)</label>
                        <div class="input-group">
                            <input type="number" id="current" value="0.5" min="0.001" step="0.001" required>
                            <select id="currentUnit" style="padding: 12px;">
                                <option value="A" selected>Amps (A)</option>
                                <option value="mA">Milliamps (mA)</option>
                                <option value="uA">Microamps (μA)</option>
                            </select>
                        </div>
                        <small>Flow of electric charge</small>
                    </div>
                    
                    <div class="form-group" id="resistanceGroup">
                        <label for="resistance">Resistance (R)</label>
                        <div class="input-group">
                            <input type="number" id="resistance" value="24" min="0.001" step="0.001" required>
                            <select id="resistanceUnit" style="padding: 12px;">
                                <option value="Ω" selected>Ohms (Ω)</option>
                                <option value="kΩ">Kiloohms (kΩ)</option>
                                <option value="MΩ">Megaohms (MΩ)</option>
                            </select>
                        </div>
                        <small>Opposition to current flow</small>
                    </div>
                    
                    <div class="form-group" id="powerGroup">
                        <label for="power">Power (P)</label>
                        <div class="input-group">
                            <input type="number" id="power" value="6" min="0.001" step="0.001" required>
                            <select id="powerUnit" style="padding: 12px;">
                                <option value="W" selected>Watts (W)</option>
                                <option value="mW">Milliwatts (mW)</option>
                                <option value="kW">Kilowatts (kW)</option>
                                <option value="MW">Megawatts (MW)</option>
                            </select>
                        </div>
                        <small>Rate of energy transfer</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Presets</label>
                        <div class="preset-buttons">
                            <div class="preset-btn" onclick="setPreset('led')">LED Circuit</div>
                            <div class="preset-btn" onclick="setPreset('battery')">Battery Load</div>
                            <div class="preset-btn" onclick="setPreset('household')">Household</div>
                            <div class="preset-btn" onclick="setPreset('industrial')">Industrial</div>
                            <div class="preset-btn" onclick="setPreset('electronic')">Electronic</div>
                            <div class="preset-btn" onclick="setPreset('power')">Power Supply</div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Calculate</button>
                </form>
                
                <div class="formula-section">
                    <h3>Ohm's Law Formulas</h3>
                    <div class="formula-grid">
                        <div class="formula-card">
                            <h4>Voltage</h4>
                            <div class="formula">V = I × R</div>
                            <small>Voltage = Current × Resistance</small>
                        </div>
                        <div class="formula-card">
                            <h4>Current</h4>
                            <div class="formula">I = V ÷ R</div>
                            <small>Current = Voltage ÷ Resistance</small>
                        </div>
                        <div class="formula-card">
                            <h4>Resistance</h4>
                            <div class="formula">R = V ÷ I</div>
                            <small>Resistance = Voltage ÷ Current</small>
                        </div>
                        <div class="formula-card">
                            <h4>Power</h4>
                            <div class="formula">P = V × I</div>
                            <small>Power = Voltage × Current</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3 id="resultTitle">Voltage</h3>
                    <div class="amount" id="mainResult">12 V</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Voltage (V)</h4>
                        <div class="value" id="resultVoltage">12 V</div>
                    </div>
                    <div class="metric-card">
                        <h4>Current (I)</h4>
                        <div class="value" id="resultCurrent">0.5 A</div>
                    </div>
                    <div class="metric-card">
                        <h4>Resistance (R)</h4>
                        <div class="value" id="resultResistance">24 Ω</div>
                    </div>
                    <div class="metric-card">
                        <h4>Power (P)</h4>
                        <div class="value" id="resultPower">6 W</div>
                    </div>
                </div>

                <div class="circuit-diagram">
                    <h3>Circuit Visualization</h3>
                    <svg class="circuit-svg" width="400" height="200" viewBox="0 0 400 200" id="circuitSvg">
                        <!-- Circuit will be drawn here by JavaScript -->
                    </svg>
                </div>

                <div class="breakdown">
                    <h3>Detailed Analysis</h3>
                    <div class="breakdown-item">
                        <span>Voltage Drop</span>
                        <strong id="voltageDrop">12 V</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Flow</span>
                        <strong id="currentFlow">0.5 A</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Power Dissipation</span>
                        <strong id="powerDissipation">6 W</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Energy per Hour</span>
                        <strong id="energyPerHour">0.006 kWh</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cost per Hour</span>
                        <strong id="costPerHour">$0.00072</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Safety Analysis</h3>
                    <div class="breakdown-item">
                        <span>Voltage Level</span>
                        <strong id="voltageLevel" style="color: #27ae60;">Safe</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Level</span>
                        <strong id="currentLevel" style="color: #27ae60;">Safe</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Power Level</span>
                        <strong id="powerLevel" style="color: #27ae60;">Safe</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Recommended Wire Gauge</span>
                        <strong id="wireGauge">22 AWG</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Unit Conversions</h3>
                    <div class="breakdown-item">
                        <span>Voltage</span>
                        <strong id="voltageConversion">12,000 mV</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current</span>
                        <strong id="currentConversion">500 mA</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Resistance</span>
                        <strong id="resistanceConversion">0.024 kΩ</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Power</span>
                        <strong id="powerConversion">6,000 mW</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Ohm's Law:</strong> V = I × R, where V is voltage in volts, I is current in amperes, and R is resistance in ohms. Power is calculated as P = V × I.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⚡ Ohm's Law Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced electrical circuit calculations and analysis</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('ohmsLawForm');
        const calculationType = document.getElementById('calculationType');

        // Unit conversion factors
        const voltageUnits = {
            V: 1,
            mV: 0.001,
            kV: 1000
        };

        const currentUnits = {
            A: 1,
            mA: 0.001,
            uA: 0.000001
        };

        const resistanceUnits = {
            'Ω': 1,
            'kΩ': 1000,
            'MΩ': 1000000
        };

        const powerUnits = {
            W: 1,
            mW: 0.001,
            kW: 1000,
            MW: 1000000
        };

        // Preset configurations
        const presets = {
            led: {
                voltage: 3.3, voltageUnit: 'V',
                current: 0.02, currentUnit: 'A',
                resistance: 165, resistanceUnit: 'Ω',
                power: 0.066, powerUnit: 'W'
            },
            battery: {
                voltage: 9, voltageUnit: 'V',
                current: 0.1, currentUnit: 'A',
                resistance: 90, resistanceUnit: 'Ω',
                power: 0.9, powerUnit: 'W'
            },
            household: {
                voltage: 120, voltageUnit: 'V',
                current: 1, currentUnit: 'A',
                resistance: 120, resistanceUnit: 'Ω',
                power: 120, powerUnit: 'W'
            },
            industrial: {
                voltage: 480, voltageUnit: 'V',
                current: 10, currentUnit: 'A',
                resistance: 48, resistanceUnit: 'Ω',
                power: 4800, powerUnit: 'W'
            },
            electronic: {
                voltage: 5, voltageUnit: 'V',
                current: 0.1, currentUnit: 'A',
                resistance: 50, resistanceUnit: 'Ω',
                power: 0.5, powerUnit: 'W'
            },
            power: {
                voltage: 12, voltageUnit: 'V',
                current: 2, currentUnit: 'A',
                resistance: 6, resistanceUnit: 'Ω',
                power: 24, powerUnit: 'W'
            }
        };

        // Update form based on calculation type
        calculationType.addEventListener('change', function() {
            updateFormVisibility();
        });

        function updateFormVisibility() {
            const type = calculationType.value;
            
            // Hide all input groups first
            document.getElementById('voltageGroup').style.display = type === 'voltage' ? 'none' : 'block';
            document.getElementById('currentGroup').style.display = type === 'current' ? 'none' : 'block';
            document.getElementById('resistanceGroup').style.display = type === 'resistance' ? 'none' : 'block';
            document.getElementById('powerGroup').style.display = type === 'power' ? 'none' : 'block';
            
            // Update result title
            const titles = {
                voltage: 'Voltage',
                current: 'Current',
                resistance: 'Resistance',
                power: 'Power'
            };
            document.getElementById('resultTitle').textContent = titles[type];
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateOhmsLaw();
        });

        function setPreset(presetName) {
            const preset = presets[presetName];
            
            document.getElementById('voltage').value = preset.voltage;
            document.getElementById('voltageUnit').value = preset.voltageUnit;
            document.getElementById('current').value = preset.current;
            document.getElementById('currentUnit').value = preset.currentUnit;
            document.getElementById('resistance').value = preset.resistance;
            document.getElementById('resistanceUnit').value = preset.resistanceUnit;
            document.getElementById('power').value = preset.power;
            document.getElementById('powerUnit').value = preset.powerUnit;
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateOhmsLaw();
        }

        function calculateOhmsLaw() {
            // Get inputs and convert to base units
            const voltage = parseFloat(document.getElementById('voltage').value) * voltageUnits[document.getElementById('voltageUnit').value];
            const current = parseFloat(document.getElementById('current').value) * currentUnits[document.getElementById('currentUnit').value];
            const resistance = parseFloat(document.getElementById('resistance').value) * resistanceUnits[document.getElementById('resistanceUnit').value];
            const power = parseFloat(document.getElementById('power').value) * powerUnits[document.getElementById('powerUnit').value];
            
            const type = calculationType.value;
            let resultValue, resultUnit, calculatedVoltage, calculatedCurrent, calculatedResistance, calculatedPower;

            // Calculate based on selected type
            switch(type) {
                case 'voltage':
                    // V = I * R or V = P / I
                    if (current > 0 && resistance > 0) {
                        calculatedVoltage = current * resistance;
                    } else if (power > 0 && current > 0) {
                        calculatedVoltage = power / current;
                    } else if (power > 0 && resistance > 0) {
                        calculatedVoltage = Math.sqrt(power * resistance);
                    }
                    calculatedCurrent = current;
                    calculatedResistance = resistance;
                    calculatedPower = power;
                    break;
                    
                case 'current':
                    // I = V / R or I = P / V
                    if (voltage > 0 && resistance > 0) {
                        calculatedCurrent = voltage / resistance;
                    } else if (power > 0 && voltage > 0) {
                        calculatedCurrent = power / voltage;
                    } else if (power > 0 && resistance > 0) {
                        calculatedCurrent = Math.sqrt(power / resistance);
                    }
                    calculatedVoltage = voltage;
                    calculatedResistance = resistance;
                    calculatedPower = power;
                    break;
                    
                case 'resistance':
                    // R = V / I or R = V² / P or R = P / I²
                    if (voltage > 0 && current > 0) {
                        calculatedResistance = voltage / current;
                    } else if (voltage > 0 && power > 0) {
                        calculatedResistance = (voltage * voltage) / power;
                    } else if (power > 0 && current > 0) {
                        calculatedResistance = power / (current * current);
                    }
                    calculatedVoltage = voltage;
                    calculatedCurrent = current;
                    calculatedPower = power;
                    break;
                    
                case 'power':
                    // P = V * I or P = I² * R or P = V² / R
                    if (voltage > 0 && current > 0) {
                        calculatedPower = voltage * current;
                    } else if (current > 0 && resistance > 0) {
                        calculatedPower = current * current * resistance;
                    } else if (voltage > 0 && resistance > 0) {
                        calculatedPower = (voltage * voltage) / resistance;
                    }
                    calculatedVoltage = voltage;
                    calculatedCurrent = current;
                    calculatedResistance = resistance;
                    break;
            }

            // Format results for display
            const formatResult = (value, units, baseUnit) => {
                if (value >= units[baseUnit] * 1000) {
                    return { value: value / (units[baseUnit] * 1000), unit: baseUnit === 'V' ? 'kV' : baseUnit === 'A' ? 'kA' : baseUnit === 'Ω' ? 'MΩ' : 'MW' };
                } else if (value < units[baseUnit] * 0.1) {
                    return { value: value / (units[baseUnit] * 0.001), unit: baseUnit === 'V' ? 'mV' : baseUnit === 'A' ? 'mA' : baseUnit === 'Ω' ? 'mΩ' : 'mW' };
                } else {
                    return { value: value / units[baseUnit], unit: baseUnit };
                }
            };

            const voltageResult = formatResult(calculatedVoltage, voltageUnits, 'V');
            const currentResult = formatResult(calculatedCurrent, currentUnits, 'A');
            const resistanceResult = formatResult(calculatedResistance, resistanceUnits, 'Ω');
            const powerResult = formatResult(calculatedPower, powerUnits, 'W');

            // Update main result
            const mainResults = {
                voltage: voltageResult,
                current: currentResult,
                resistance: resistanceResult,
                power: powerResult
            };
            
            const mainResult = mainResults[type];
            document.getElementById('mainResult').textContent = `${mainResult.value.toFixed(3)} ${mainResult.unit}`;

            // Update all results
            document.getElementById('resultVoltage').textContent = `${voltageResult.value.toFixed(3)} ${voltageResult.unit}`;
            document.getElementById('resultCurrent').textContent = `${currentResult.value.toFixed(3)} ${currentResult.unit}`;
            document.getElementById('resultResistance').textContent = `${resistanceResult.value.toFixed(3)} ${resistanceResult.unit}`;
            document.getElementById('resultPower').textContent = `${powerResult.value.toFixed(3)} ${powerResult.unit}`;

            // Update detailed analysis
            document.getElementById('voltageDrop').textContent = `${voltageResult.value.toFixed(3)} ${voltageResult.unit}`;
            document.getElementById('currentFlow').textContent = `${currentResult.value.toFixed(3)} ${currentResult.unit}`;
            document.getElementById('powerDissipation').textContent = `${powerResult.value.toFixed(3)} ${powerResult.unit}`;
            
            // Calculate energy and cost
            const energyPerHour = calculatedPower * 0.001; // kWh
            const costPerHour = energyPerHour * 0.12; // Assuming $0.12 per kWh
            document.getElementById('energyPerHour').textContent = `${energyPerHour.toFixed(6)} kWh`;
            document.getElementById('costPerHour').textContent = `$${costPerHour.toFixed(6)}`;

            // Safety analysis
            document.getElementById('voltageLevel').textContent = calculatedVoltage < 50 ? 'Safe' : calculatedVoltage < 600 ? 'Caution' : 'Dangerous';
            document.getElementById('voltageLevel').style.color = calculatedVoltage < 50 ? '#27ae60' : calculatedVoltage < 600 ? '#f39c12' : '#e74c3c';
            
            document.getElementById('currentLevel').textContent = calculatedCurrent < 0.01 ? 'Safe' : calculatedCurrent < 0.1 ? 'Caution' : 'Dangerous';
            document.getElementById('currentLevel').style.color = calculatedCurrent < 0.01 ? '#27ae60' : calculatedCurrent < 0.1 ? '#f39c12' : '#e74c3c';
            
            document.getElementById('powerLevel').textContent = calculatedPower < 10 ? 'Safe' : calculatedPower < 100 ? 'Caution' : 'Dangerous';
            document.getElementById('powerLevel').style.color = calculatedPower < 10 ? '#27ae60' : calculatedPower < 100 ? '#f39c12' : '#e74c3c';

            // Wire gauge recommendation (simplified)
            let wireGauge = '22 AWG';
            if (calculatedCurrent > 3) wireGauge = '18 AWG';
            if (calculatedCurrent > 7) wireGauge = '16 AWG';
            if (calculatedCurrent > 10) wireGauge = '14 AWG';
            if (calculatedCurrent > 15) wireGauge = '12 AWG';
            if (calculatedCurrent > 20) wireGauge = '10 AWG';
            document.getElementById('wireGauge').textContent = wireGauge;

            // Unit conversions
            document.getElementById('voltageConversion').textContent = `${(calculatedVoltage * 1000).toFixed(0)} mV / ${(calculatedVoltage / 1000).toFixed(3)} kV`;
            document.getElementById('currentConversion').textContent = `${(calculatedCurrent * 1000).toFixed(0)} mA / ${(calculatedCurrent * 1000000).toFixed(0)} μA`;
            document.getElementById('resistanceConversion').textContent = `${(calculatedResistance / 1000).toFixed(3)} kΩ / ${(calculatedResistance / 1000000).toFixed(6)} MΩ`;
            document.getElementById('powerConversion').textContent = `${(calculatedPower * 1000).toFixed(0)} mW / ${(calculatedPower / 1000).toFixed(3)} kW`;

            // Draw circuit diagram
            drawCircuit(calculatedVoltage, calculatedCurrent, calculatedResistance);
        }

        function drawCircuit(voltage, current, resistance) {
            const svg = document.getElementById('circuitSvg');
            svg.innerHTML = '';
            
            // Simple circuit drawing
            const ns = "http://www.w3.org/2000/svg";
            
            // Battery
            const battery = document.createElementNS(ns, 'rect');
            battery.setAttribute('x', '50');
            battery.setAttribute('y', '80');
            battery.setAttribute('width', '20');
            battery.setAttribute('height', '40');
            battery.setAttribute('fill', '#e74c3c');
            svg.appendChild(battery);
            
            // Resistor
            const resistor = document.createElementNS(ns, 'rect');
            resistor.setAttribute('x', '200');
            resistor.setAttribute('y', '80');
            resistor.setAttribute('width', '40');
            resistor.setAttribute('height', '40');
            resistor.setAttribute('fill', '#3498db');
            svg.appendChild(resistor);
            
            // Wires
            const wire1 = document.createElementNS(ns, 'line');
            wire1.setAttribute('x1', '70');
            wire1.setAttribute('y1', '100');
            wire1.setAttribute('x2', '200');
            wire1.setAttribute('y2', '100');
            wire1.setAttribute('stroke', '#2c3e50');
            wire1.setAttribute('stroke-width', '3');
            svg.appendChild(wire1);
            
            const wire2 = document.createElementNS(ns, 'line');
            wire2.setAttribute('x1', '240');
            wire2.setAttribute('y1', '100');
            wire2.setAttribute('x2', '330');
            wire2.setAttribute('y2', '100');
            wire2.setAttribute('stroke', '#2c3e50');
            wire2.setAttribute('stroke-width', '3');
            svg.appendChild(wire2);
            
            const wire3 = document.createElementNS(ns, 'line');
            wire3.setAttribute('x1', '330');
            wire3.setAttribute('y1', '100');
            wire3.setAttribute('x2', '330');
            wire3.setAttribute('y2', '150');
            wire3.setAttribute('stroke', '#2c3e50');
            wire3.setAttribute('stroke-width', '3');
            svg.appendChild(wire3);
            
            const wire4 = document.createElementNS(ns, 'line');
            wire4.setAttribute('x1', '330');
            wire4.setAttribute('y1', '150');
            wire4.setAttribute('x2', '50');
            wire4.setAttribute('y2', '150');
            wire4.setAttribute('stroke', '#2c3e50');
            wire4.setAttribute('stroke-width', '3');
            svg.appendChild(wire4);
            
            const wire5 = document.createElementNS(ns, 'line');
            wire5.setAttribute('x1', '50');
            wire5.setAttribute('y1', '150');
            wire5.setAttribute('x2', '50');
            wire5.setAttribute('y2', '120');
            wire5.setAttribute('stroke', '#2c3e50');
            wire5.setAttribute('stroke-width', '3');
            svg.appendChild(wire5);
            
            // Labels
            const voltageLabel = document.createElementNS(ns, 'text');
            voltageLabel.setAttribute('x', '30');
            voltageLabel.setAttribute('y', '70');
            voltageLabel.setAttribute('fill', '#2c3e50');
            voltageLabel.setAttribute('font-size', '14');
            voltageLabel.textContent = `${voltage.toFixed(1)}V`;
            svg.appendChild(voltageLabel);
            
            const currentLabel = document.createElementNS(ns, 'text');
            currentLabel.setAttribute('x', '120');
            currentLabel.setAttribute('y', '90');
            currentLabel.setAttribute('fill', '#2c3e50');
            currentLabel.setAttribute('font-size', '14');
            currentLabel.textContent = `${current.toFixed(3)}A`;
            svg.appendChild(currentLabel);
            
            const resistanceLabel = document.createElementNS(ns, 'text');
            resistanceLabel.setAttribute('x', '210');
            resistanceLabel.setAttribute('y', '70');
            resistanceLabel.setAttribute('fill', '#2c3e50');
            resistanceLabel.setAttribute('font-size', '14');
            resistanceLabel.textContent = `${resistance.toFixed(1)}Ω`;
            svg.appendChild(resistanceLabel);
        }

        // Initialize
        window.addEventListener('load', function() {
            updateFormVisibility();
            calculateOhmsLaw();
        });
    </script>
</body>
</html>