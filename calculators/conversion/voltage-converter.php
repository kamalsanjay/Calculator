<?php
/**
 * Voltage Converter
 * File: conversion/voltage-converter.php
 * Description: Convert between voltage units including volts, millivolts, kilovolts, and more
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voltage Converter - Electrical Potential Unit Conversion Calculator</title>
    <meta name="description" content="Convert between voltage units: volts, millivolts, kilovolts, and more. Essential for electronics, electrical engineering, and power systems.">
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
        .result-card { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #667eea; }
        .result-unit { color: #0984e3; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #00cec9; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #667eea; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15); }
        .quick-value { font-weight: bold; color: #667eea; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .common-voltages { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .common-voltages h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        
        .voltage-scale { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .voltage-scale-bar { height: 30px; background: linear-gradient(90deg, #4caf50, #ffeb3b, #ff9800, #f44336); border-radius: 15px; margin: 10px 0; position: relative; }
        .voltage-scale-labels { display: flex; justify-content: space-between; font-size: 0.8rem; color: #555; }
        
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
        
        .formula-box { background: #a8edea; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .safety-box { background: #ffebee; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #f44336; }
        
        .electronics-box { background: #fff3e0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff9800; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .voltage-highlight { background: #e3f2fd; padding: 3px 6px; border-radius: 4px; font-weight: bold; }
        
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
            <h1>⚡ Voltage Converter</h1>
            <p>Convert between voltage units: volts, millivolts, kilovolts, and more. Essential for electronics, electrical engineering, and power systems.</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="v" selected>Volt (V)</option>
                        <option value="mv">Millivolt (mV)</option>
                        <option value="uv">Microvolt (μV)</option>
                        <option value="kv">Kilovolt (kV)</option>
                        <option value="mv_stat">Megavolt (MV)</option>
                        <option value="abv">Abvolt (abV)</option>
                        <option value="statv">Statvolt (statV)</option>
                        <option value="ev">Electronvolt (eV)</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="v">Volt (V)</option>
                        <option value="mv" selected>Millivolt (mV)</option>
                        <option value="uv">Microvolt (μV)</option>
                        <option value="kv">Kilovolt (kV)</option>
                        <option value="mv_stat">Megavolt (MV)</option>
                        <option value="abv">Abvolt (abV)</option>
                        <option value="statv">Statvolt (statV)</option>
                        <option value="ev">Electronvolt (eV)</option>
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

            <div class="common-voltages">
                <h3>🎯 Common Voltage Values</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setCommonVoltage(1.5, 'Standard AA/AAA battery')">
                        <div class="quick-value">1.5V</div>
                        <div class="quick-label">AA Battery</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonVoltage(5, 'USB power standard')">
                        <div class="quick-value">5V</div>
                        <div class="quick-label">USB Power</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonVoltage(12, 'Car electrical system')">
                        <div class="quick-value">12V</div>
                        <div class="quick-label">Automotive</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonVoltage(120, 'US household outlet')">
                        <div class="quick-value">120V</div>
                        <div class="quick-label">US Outlet</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⚡ Voltage Unit Conversion</h2>
            
            <p>Convert between voltage units used worldwide for electronics, electrical systems, power distribution, and scientific applications.</p>

            <div class="voltage-scale">
                <h3>📊 Voltage Scale Spectrum</h3>
                <div class="voltage-scale-bar"></div>
                <div class="voltage-scale-labels">
                    <span>Microvolts<br>(μV)</span>
                    <span>Millivolts<br>(mV)</span>
                    <span>Volts<br>(V)</span>
                    <span>Kilovolts<br>(kV)</span>
                    <span>Megavolts<br>(MV)</span>
                </div>
            </div>

            <h3>📊 Conversion Factors to Volts</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Volts Equivalent</th>
                        <th>Usage Context</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Volt</td><td>V</td><td>1</td><td>SI base unit</td></tr>
                    <tr><td>Millivolt</td><td>mV</td><td>0.001</td><td>Small signals, sensors</td></tr>
                    <tr><td>Microvolt</td><td>μV</td><td>0.000001</td><td>Biological signals, precision</td></tr>
                    <tr><td>Kilovolt</td><td>kV</td><td>1,000</td><td>Power transmission</td></tr>
                    <tr><td>Megavolt</td><td>MV</td><td>1,000,000</td><td>High-voltage research</td></tr>
                    <tr><td>Abvolt</td><td>abV</td><td>1×10⁻⁸</td><td>CGS electromagnetic unit</td></tr>
                    <tr><td>Statvolt</td><td>statV</td><td>299.792458</td><td>ESU/CGS unit</td></tr>
                    <tr><td>Electronvolt</td><td>eV</td><td>1.602×10⁻¹⁹</td><td>Particle physics</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Electrical Formulas:</strong><br>
                • <strong>Ohm's Law:</strong> V = I × R (Voltage = Current × Resistance)<br>
                • <strong>Power Formula:</strong> P = V × I (Power = Voltage × Current)<br>
                • <strong>Voltage Divider:</strong> Vout = Vin × (R2 / (R1 + R2))<br>
                • <strong>Capacitor Voltage:</strong> V = Q / C (Voltage = Charge / Capacitance)<br>
                • <strong>Inductor EMF:</strong> V = -L × (di/dt) (EMF = -Inductance × rate of current change)
            </div>

            <h3>🔋 Battery & DC Power Systems</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Source</th>
                        <th>Typical Voltage</th>
                        <th>Application</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Button cell</td><td>1.5V, 3V</td><td>Watches, calculators</td><td>Silver oxide, lithium</td></tr>
                    <tr><td>AA/AAA battery</td><td>1.5V</td><td>Consumer electronics</td><td>Alkaline, NiMH: 1.2V</td></tr>
                    <tr><td>9V battery</td><td>9V</td><td>Smoke detectors, guitars</td><td>Rectangular shape</td></tr>
                    <tr><td>Car battery</td><td>12V</td><td>Automotive systems</td><td>Actually 12.6-14.4V</td></tr>
                    <tr><td>Li-ion battery</td><td>3.7V</td><td>Phones, laptops</td><td>Per cell, 4.2V charged</td></tr>
                    <tr><td>Li-po battery</td><td>3.7V</td><td>Drones, RC vehicles</td><td>High discharge rates</td></tr>
                    <tr><td>Lead-acid</td><td>2V per cell</td><td>UPS, solar storage</td><td>6V, 12V, 24V systems</td></tr>
                    <tr><td>Power over Ethernet</td><td>48V</td><td>Network equipment</td><td>IEEE 802.3 standards</td></tr>
                </tbody>
            </table>

            <div class="safety-box">
                <strong>⚠️ Electrical Safety Voltage Levels:</strong><br>
                • <span class="voltage-highlight">Extra Low Voltage (ELV):</span> &lt;50V AC, &lt;120V DC - Generally safe<br>
                • <span class="voltage-highlight">Low Voltage (LV):</span> 50-1000V AC, 120-1500V DC - Requires caution<br>
                • <span class="voltage-highlight">High Voltage (HV):</span> &gt;1000V AC, &gt;1500V DC - Dangerous, qualified personnel only<br>
                • <span class="voltage-highlight">Extra High Voltage (EHV):</span> &gt;230,000V - Power transmission lines<br>
                • <strong>Remember:</strong> Current kills, not voltage! Even low voltages can be dangerous with sufficient current.
            </div>

            <h3>🏠 Residential & Commercial Power</h3>
            <ul>
                <li><strong>North America:</strong> 120V/240V split-phase, 60Hz</li>
                <li><strong>Europe/UK:</strong> 230V/400V, 50Hz</li>
                <li><strong>Japan:</strong> 100V, 50Hz (East) / 60Hz (West)</li>
                <li><strong>Australia:</strong> 230V/400V, 50Hz</li>
                <li><strong>India:</strong> 230V/400V, 50Hz</li>
                <li><strong>Brazil:</strong> 127V/220V, 60Hz (varies by region)</li>
                <li><strong>Industrial (US):</strong> 480V/277V, 60Hz three-phase</li>
                <li><strong>Industrial (EU):</strong> 400V/230V, 50Hz three-phase</li>
            </ul>

            <h3>🔌 Electronics & Circuit Design</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Component/System</th>
                        <th>Operating Voltage</th>
                        <th>Typical Range</th>
                        <th>Application</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>CMOS logic</td><td>3.3V, 5V</td><td>1.8V-5V</td><td>Digital circuits</td></tr>
                    <tr><td>TTL logic</td><td>5V</td><td>4.75V-5.25V</td><td>Legacy digital</td></tr>
                    <tr><td>Arduino Uno</td><td>5V</td><td>7-12V input</td><td>Microcontroller</td></tr>
                    <tr><td>Raspberry Pi</td><td>3.3V</td><td>5V input</td><td>Single-board computer</td></tr>
                    <tr><td>LED forward voltage</td><td>1.8-3.3V</td><td>Depends on color</td><td>Indicators, lighting</td></tr>
                    <tr><td>Silicon diode</td><td>0.7V drop</td><td>0.6-1.1V</td><td>Rectification</td></tr>
                    <tr><td>Transistor base-emitter</td><td>0.7V</td><td>0.65-0.8V</td><td>BJT switching</td></tr>
                    <tr><td>Op-amp supply</td><td>±15V</td><td>±5V to ±18V</td><td>Analog circuits</td></tr>
                </tbody>
            </table>

            <div class="electronics-box">
                <strong>💡 Common Electronic Voltage Levels:</strong><br>
                • <span class="voltage-highlight">Logic Low:</span> 0-0.8V (TTL), 0-0.9V (CMOS 5V)<br>
                • <span class="voltage-highlight">Logic High:</span> 2.0-5V (TTL), 3.5-5V (CMOS 5V)<br>
                • <span class="voltage-highlight">Analog Reference:</span> 2.5V, 3.3V, 5V common references<br>
                • <span class="voltage-highlight">USB Standards:</span> 5V (USB 2.0/3.0), 20V (USB Power Delivery)<br>
                • <span class="voltage-highlight">Ethernet:</span> 3.3V (signaling), 48V (PoE)
            </div>

            <h3>⚡ Power Transmission & Distribution</h3>
            <ul>
                <li><strong>Distribution lines:</strong> 4-35 kV (neighborhood level)</li>
                <li><strong>Sub-transmission:</strong> 69-138 kV (regional distribution)</li>
                <li><strong>Transmission lines:</strong> 115-765 kV (long-distance)</li>
                <li><strong>Ultra-high voltage:</strong> 800 kV, 1,100 kV (experimental)</li>
                <li><strong>HVDC transmission:</strong> ±500 kV, ±800 kV (very long distance)</li>
                <li><strong>Railway electrification:</strong> 600V-25kV (varies by country)</li>
                <li><strong>Traction power:</strong> 750V, 1,500V, 3,000V DC systems</li>
            </ul>

            <h3>🔬 Scientific & Special Applications</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Voltage Range</th>
                        <th>Context</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Neuron action potential</td><td>70-100 mV</td><td>Biological signals</td></tr>
                    <tr><td>ECG/EKG signals</td><td>1-5 mV</td><td>Heart monitoring</td></tr>
                    <tr><td>EEG signals</td><td>10-100 μV</td><td>Brain activity</td></tr>
                    <tr><td>Photomultiplier tubes</td><td>500-3000V</td><td>Light detection</td></tr>
                    <tr><td>Electron microscopes</td><td>1-300 kV</td><td>Imaging</td></tr>
                    <tr><td>Particle accelerators</td><td>MV to GV range</td><td>Physics research</td></tr>
                    <tr><td>Lightning strike</td><td>100-1000 MV</td><td>Atmospheric electricity</td></tr>
                    <tr><td>Van de Graaff generator</td><td>1-25 MV</td><td>Electrostatic</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>Metric Prefix Conversions:</strong><br>
                • <strong>Volts to Millivolts:</strong> Multiply by 1,000 (V × 1000 = mV)<br>
                • <strong>Millivolts to Volts:</strong> Divide by 1,000 (mV ÷ 1000 = V)<br>
                • <strong>Volts to Kilovolts:</strong> Divide by 1,000 (V ÷ 1000 = kV)<br>
                • <strong>Kilovolts to Volts:</strong> Multiply by 1,000 (kV × 1000 = V)<br>
                • <strong>Microvolts to Millivolts:</strong> Divide by 1,000 (μV ÷ 1000 = mV)<br>
                • <strong>Millivolts to Microvolts:</strong> Multiply by 1,000 (mV × 1000 = μV)
            </div>

            <h3>🌎 Regional Standards</h3>
            <ul>
                <li><strong>International System (SI):</strong> Volt (V) as base unit</li>
                <li><strong>United States:</strong> Follows SI with customary use of kV, mV</li>
                <li><strong>Europe:</strong> Strict SI usage with metric prefixes</li>
                <li><strong>Engineering:</strong> Mixed usage based on application scale</li>
                <li><strong>Scientific research:</strong> Electronvolts (eV) in particle physics</li>
                <li><strong>Legacy systems:</strong> Some CGS units still in specialized fields</li>
            </ul>

            <h3>⚖️ Historical Context</h3>
            <p>The <strong>volt</strong> is named after Alessandro Volta, inventor of the electric battery. It was adopted as the SI unit of electric potential in 1873. The <strong>electronvolt</strong> (eV) was introduced in the early 20th century for atomic and particle physics. The <strong>abvolt</strong> and <strong>statvolt</strong> come from the CGS (centimeter-gram-second) system of units, which was widely used in scientific work before the SI system became dominant.</p>

            <h3>🔧 Voltage Measurement</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Measurement Tool</th>
                        <th>Typical Range</th>
                        <th>Accuracy</th>
                        <th>Applications</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Multimeter</td><td>mV to kV</td><td>0.5-3%</td><td>General purpose</td></tr>
                    <tr><td>Oscilloscope</td><td>mV to kV</td><td>1-3%</td><td>Time-varying signals</td></tr>
                    <tr><td>Voltmeter</td><td>V to kV</td><td>0.1-2%</td><td>DC/AC measurement</td></tr>
                    <tr><td>Potentiometer</td><td>μV to V</td><td>0.001%</td><td>Precision measurement</td></tr>
                    <tr><td>High-voltage probe</td><td>kV to MV</td><td>1-5%</td><td>Power systems</td></tr>
                    <tr><td>Electrometer</td><td>μV to kV</td><td>0.01%</td><td>High-impedance circuits</td></tr>
                </tbody>
            </table>

            <h3>🎯 Key Conversions to Remember</h3>
            <ul>
                <li><strong>1 V = 1,000 mV = 1,000,000 μV</strong></li>
                <li><strong>1 kV = 1,000 V</strong></li>
                <li><strong>1 MV = 1,000,000 V</strong></li>
                <li><strong>1 abV = 10⁻⁸ V</strong></li>
                <li><strong>1 statV ≈ 299.792458 V</strong></li>
                <li><strong>1 eV ≈ 1.602 × 10⁻¹⁹ V</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>⚡ Voltage Converter | Complete Voltage Unit Conversion</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert volts, millivolts, kilovolts, and other voltage units with precision</p>
        </div>
    </div>

    <script>
        // Conversion factors to volts
        const toVolts = {
            v: 1,
            mv: 0.001,
            uv: 0.000001,
            kv: 1000,
            mv_stat: 1000000,
            abv: 1e-8,
            statv: 299.792458,
            ev: 1.602176634e-19
        };

        const unitNames = {
            v: 'Volt (V)',
            mv: 'Millivolt (mV)',
            uv: 'Microvolt (μV)',
            kv: 'Kilovolt (kV)',
            mv_stat: 'Megavolt (MV)',
            abv: 'Abvolt (abV)',
            statv: 'Statvolt (statV)',
            ev: 'Electronvolt (eV)'
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

            // Convert to volts first
            const valueInVolts = inputValue * toVolts[fromUnit];
            
            // Convert to target unit
            const result = valueInVolts / toVolts[toUnit];
            
            document.getElementById('outputValue').value = formatNumber(result);
            
            displayAllConversions(valueInVolts);
        }

        function displayAllConversions(valueInVolts) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInVolts / toVolts[unit];
                
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

        function setCommonVoltage(value, description) {
            document.getElementById('inputValue').value = value;
            document.getElementById('fromUnit').value = 'v';
            document.getElementById('toUnit').value = 'mv';
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