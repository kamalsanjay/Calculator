<?php
/**
 * LED Resistor Calculator
 * File: electronics/led-resistor-calculator.php
 * Description: Advanced calculator for LED current-limiting resistor values
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LED Resistor Calculator - Calculate Current-Limiting Resistor Values</title>
    <meta name="description" content="Advanced LED resistor calculator. Calculate resistor values, power ratings, and series/parallel LED configurations with color codes.">
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
        
        .result-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; }
        .result-card .amount { font-size: 3rem; font-weight: bold; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #667eea; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #667eea; font-size: 1.6rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #667eea; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .color-code { display: flex; gap: 5px; margin: 15px 0; justify-content: center; }
        .color-band { width: 40px; height: 80px; border: 2px solid #333; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.5); }
        
        .led-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; margin-top: 10px; }
        .led-btn { padding: 8px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .led-btn:hover { background: #667eea; color: white; border-color: #667eea; }
        
        .circuit-diagram { background: white; border: 2px solid #e0e0e0; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 20px; }
        .circuit-svg { max-width: 100%; height: auto; }
        
        .info-box { background: #e8f2ff; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #667eea; }
        
        .warning-box { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .warning-box strong { color: #856404; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: repeat(2, 1fr); }
            .input-group { grid-template-columns: 1fr; }
            .color-band { width: 35px; height: 70px; }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
            .metric-grid { grid-template-columns: 1fr; }
            .color-band { width: 30px; height: 60px; font-size: 0.8rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💡 LED Resistor Calculator</h1>
            <p>Calculate current-limiting resistor values for LED circuits</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>LED Parameters</h2>
                <form id="ledForm">
                    <div class="form-group">
                        <label for="sourceVoltage">Source Voltage (V)</label>
                        <input type="number" id="sourceVoltage" value="12" min="1" max="1000" step="0.1" required>
                        <small>Power supply voltage (e.g., 5V, 9V, 12V)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="ledColor">LED Color (Voltage)</label>
                        <select id="ledColor">
                            <option value="1.8">Infrared (1.6-1.8V)</option>
                            <option value="2.0" selected>Red (1.8-2.2V)</option>
                            <option value="2.1">Orange (2.0-2.2V)</option>
                            <option value="2.2">Yellow (2.0-2.4V)</option>
                            <option value="2.5">Green (2.0-3.5V)</option>
                            <option value="3.0">Blue (3.0-3.5V)</option>
                            <option value="3.2">White (3.0-3.5V)</option>
                            <option value="3.0">UV (3.0-4.0V)</option>
                            <option value="custom">Custom Voltage</option>
                        </select>
                        <small>LED forward voltage drop</small>
                    </div>
                    
                    <div class="form-group" id="customVoltageGroup" style="display: none;">
                        <label for="customVoltage">Custom LED Voltage (V)</label>
                        <input type="number" id="customVoltage" value="2.0" min="0.5" max="10" step="0.1">
                        <small>Enter custom LED forward voltage</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="ledCurrent">LED Current (mA)</label>
                        <input type="number" id="ledCurrent" value="20" min="1" max="1000" step="1" required>
                        <small>Typical: 20mA (max safe current for standard LEDs)</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Current Presets</label>
                        <div class="led-preset">
                            <div class="led-btn" onclick="setCurrent(10)">10 mA</div>
                            <div class="led-btn" onclick="setCurrent(20)">20 mA</div>
                            <div class="led-btn" onclick="setCurrent(30)">30 mA</div>
                            <div class="led-btn" onclick="setCurrent(50)">50 mA</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="ledCount">Number of LEDs</label>
                        <select id="ledCount">
                            <option value="1" selected>1 LED</option>
                            <option value="2">2 LEDs</option>
                            <option value="3">3 LEDs</option>
                            <option value="4">4 LEDs</option>
                            <option value="5">5 LEDs</option>
                            <option value="custom">Custom</option>
                        </select>
                        <small>LEDs in series configuration</small>
                    </div>
                    
                    <div class="form-group" id="customCountGroup" style="display: none;">
                        <label for="customCount">Custom LED Count</label>
                        <input type="number" id="customCount" value="1" min="1" max="100" step="1">
                    </div>
                    
                    <button type="submit" class="btn">Calculate Resistor</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Resistor Results</h2>
                
                <div class="result-card">
                    <h3>Required Resistor</h3>
                    <div class="amount" id="resistorValue">500 Ω</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Standard Value</h4>
                        <div class="value" id="standardValue">470 Ω</div>
                    </div>
                    <div class="metric-card">
                        <h4>Power Rating</h4>
                        <div class="value" id="powerRating">0.25 W</div>
                    </div>
                    <div class="metric-card">
                        <h4>Actual Current</h4>
                        <div class="value" id="actualCurrent">21 mA</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Resistor Color Code</h3>
                    <div class="color-code" id="colorCode">
                        <div class="color-band" style="background: #8B4513;">4</div>
                        <div class="color-band" style="background: #800080;">7</div>
                        <div class="color-band" style="background: #8B4513;">×10</div>
                        <div class="color-band" style="background: #FFD700;">±5%</div>
                    </div>
                    <div style="text-align: center; font-size: 0.9rem; color: #666;">
                        <strong>470 Ω ± 5%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Calculation Details</h3>
                    <div class="breakdown-item">
                        <span>Source Voltage</span>
                        <strong id="sourceVDisplay">12 V</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>LED Voltage Drop</span>
                        <strong id="ledVDisplay">2.0 V</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Number of LEDs</span>
                        <strong id="ledCountDisplay">1 LED</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total LED Voltage</span>
                        <strong id="totalLEDV">2.0 V</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Voltage Across Resistor</span>
                        <strong id="resistorV">10 V</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Desired Current</span>
                        <strong id="desiredI">20 mA</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Power Dissipation</h3>
                    <div class="breakdown-item">
                        <span>Power in Resistor</span>
                        <strong id="powerResistor">0.20 W</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Power in Each LED</span>
                        <strong id="powerLED">0.04 W</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Circuit Power</span>
                        <strong id="totalPower">0.24 W</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Recommended Rating</span>
                        <strong id="recRating">1/4 W (0.25W)</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Standard Resistor Values</h3>
                    <div class="breakdown-item">
                        <span>Nearest Lower (E12)</span>
                        <strong id="lowerValue">430 Ω</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Exact Calculated</span>
                        <strong id="exactValue">500 Ω</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Nearest Higher (E12)</span>
                        <strong id="higherValue">560 Ω</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Recommended (Safe)</span>
                        <strong id="recommended">470 Ω</strong>
                    </div>
                </div>

                <div class="circuit-diagram">
                    <h3 style="color: #667eea; margin-bottom: 15px;">Circuit Diagram</h3>
                    <svg class="circuit-svg" viewBox="0 0 400 200" xmlns="http://www.w3.org/2000/svg">
                        <!-- Power source -->
                        <circle cx="50" cy="100" r="30" fill="none" stroke="#667eea" stroke-width="3"/>
                        <text x="50" y="105" text-anchor="middle" font-size="16" fill="#667eea" font-weight="bold">+12V</text>
                        
                        <!-- Wires -->
                        <line x1="80" y1="100" x2="130" y2="100" stroke="#333" stroke-width="3"/>
                        <line x1="230" y1="100" x2="280" y2="100" stroke="#333" stroke-width="3"/>
                        <line x1="350" y1="100" x2="400" y2="100" stroke="#333" stroke-width="3"/>
                        <line x1="400" y1="100" x2="400" y2="150" stroke="#333" stroke-width="3"/>
                        <line x1="400" y1="150" x2="50" y2="150" stroke="#333" stroke-width="3"/>
                        <line x1="50" y1="150" x2="50" y2="130" stroke="#333" stroke-width="3"/>
                        
                        <!-- Resistor -->
                        <rect x="130" y="85" width="100" height="30" fill="#FFF3E0" stroke="#FF9800" stroke-width="3"/>
                        <text x="180" y="105" text-anchor="middle" font-size="14" fill="#FF9800" font-weight="bold">R</text>
                        
                        <!-- LED -->
                        <circle cx="305" cy="100" r="25" fill="#FFE082" stroke="#FFC107" stroke-width="3"/>
                        <path d="M 295 90 L 315 100 L 295 110 Z" fill="#FFC107"/>
                        <text x="305" y="80" text-anchor="middle" font-size="12" fill="#666">LED</text>
                        
                        <!-- Ground -->
                        <line x1="35" y1="150" x2="65" y2="150" stroke="#333" stroke-width="3"/>
                        <line x1="40" y1="155" x2="60" y2="155" stroke="#333" stroke-width="2"/>
                        <line x1="45" y1="160" x2="55" y2="160" stroke="#333" stroke-width="1"/>
                    </svg>
                </div>
                
                <div class="info-box">
                    <strong>Formula:</strong> R = (Vs - Vled) / I<br>
                    Where: Vs = Source voltage, Vled = LED voltage drop, I = LED current
                </div>
                
                <div class="warning-box" id="warningBox" style="display: none;">
                    <strong>⚠️ Warning:</strong> <span id="warningText"></span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>💡 LED Resistor Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional LED current-limiting resistor calculations</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('ledForm');
        const ledColorSelect = document.getElementById('ledColor');
        const ledCountSelect = document.getElementById('ledCount');
        const customVoltageGroup = document.getElementById('customVoltageGroup');
        const customCountGroup = document.getElementById('customCountGroup');

        // E12 standard resistor values
        const e12Values = [10, 12, 15, 18, 22, 27, 33, 39, 47, 56, 68, 82];

        // Color code mapping
        const colorCodes = {
            0: { color: '#000000', name: 'Black' },
            1: { color: '#8B4513', name: 'Brown' },
            2: { color: '#FF0000', name: 'Red' },
            3: { color: '#FFA500', name: 'Orange' },
            4: { color: '#FFFF00', name: 'Yellow' },
            5: { color: '#00FF00', name: 'Green' },
            6: { color: '#0000FF', name: 'Blue' },
            7: { color: '#800080', name: 'Violet' },
            8: { color: '#808080', name: 'Gray' },
            9: { color: '#FFFFFF', name: 'White' }
        };

        ledColorSelect.addEventListener('change', function() {
            customVoltageGroup.style.display = this.value === 'custom' ? 'block' : 'none';
        });

        ledCountSelect.addEventListener('change', function() {
            customCountGroup.style.display = this.value === 'custom' ? 'block' : 'none';
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateResistor();
        });

        function setCurrent(value) {
            document.getElementById('ledCurrent').value = value;
            calculateResistor();
        }

        function findNearestE12(value) {
            let multiplier = 1;
            let normalizedValue = value;
            
            while (normalizedValue >= 100) {
                normalizedValue /= 10;
                multiplier *= 10;
            }
            while (normalizedValue < 10) {
                normalizedValue *= 10;
                multiplier /= 10;
            }
            
            let nearest = e12Values[0];
            let minDiff = Math.abs(normalizedValue - nearest);
            
            for (let val of e12Values) {
                let diff = Math.abs(normalizedValue - val);
                if (diff < minDiff) {
                    minDiff = diff;
                    nearest = val;
                }
            }
            
            return nearest * multiplier;
        }

        function getColorCode(resistance) {
            const resistanceStr = Math.round(resistance).toString();
            const significantDigits = resistanceStr.slice(0, 2);
            const multiplier = resistanceStr.length - 2;
            
            const digit1 = parseInt(significantDigits[0]);
            const digit2 = parseInt(significantDigits[1] || 0);
            
            return {
                band1: { digit: digit1, ...colorCodes[digit1] },
                band2: { digit: digit2, ...colorCodes[digit2] },
                multiplier: multiplier,
                tolerance: '±5%'
            };
        }

        function calculateResistor() {
            const sourceVoltage = parseFloat(document.getElementById('sourceVoltage').value);
            const ledColorValue = document.getElementById('ledColor').value;
            const ledVoltage = ledColorValue === 'custom' 
                ? parseFloat(document.getElementById('customVoltage').value)
                : parseFloat(ledColorValue);
            const ledCurrent = parseFloat(document.getElementById('ledCurrent').value) / 1000; // Convert to A
            const ledCountValue = document.getElementById('ledCount').value;
            const ledCount = ledCountValue === 'custom'
                ? parseInt(document.getElementById('customCount').value)
                : parseInt(ledCountValue);
            
            // Calculate total LED voltage
            const totalLEDVoltage = ledVoltage * ledCount;
            
            // Check if configuration is valid
            const warningBox = document.getElementById('warningBox');
            const warningText = document.getElementById('warningText');
            
            if (totalLEDVoltage >= sourceVoltage) {
                warningBox.style.display = 'block';
                warningText.textContent = `Total LED voltage (${totalLEDVoltage.toFixed(2)}V) exceeds source voltage (${sourceVoltage}V). Circuit will not work!`;
            } else {
                warningBox.style.display = 'none';
            }
            
            // Calculate resistor value
            const voltageAcrossResistor = sourceVoltage - totalLEDVoltage;
            const resistorValue = voltageAcrossResistor / ledCurrent;
            
            // Find standard values
            const standardValue = findNearestE12(resistorValue);
            const actualCurrent = voltageAcrossResistor / standardValue;
            
            // Calculate power
            const powerResistor = Math.pow(actualCurrent, 2) * standardValue;
            const powerPerLED = ledVoltage * actualCurrent;
            const totalPower = powerResistor + (powerPerLED * ledCount);
            
            // Determine power rating
            let recommendedRating;
            if (powerResistor <= 0.125) recommendedRating = '1/8 W (0.125W)';
            else if (powerResistor <= 0.25) recommendedRating = '1/4 W (0.25W)';
            else if (powerResistor <= 0.5) recommendedRating = '1/2 W (0.5W)';
            else if (powerResistor <= 1) recommendedRating = '1 W';
            else if (powerResistor <= 2) recommendedRating = '2 W';
            else recommendedRating = '5 W';
            
            // Get color code
            const colorCode = getColorCode(standardValue);
            
            // Find nearest lower and higher E12 values
            const lowerValue = findNearestE12(resistorValue * 0.9);
            const higherValue = findNearestE12(resistorValue * 1.1);
            
            // Update UI
            document.getElementById('resistorValue').textContent = resistorValue.toFixed(1) + ' Ω';
            document.getElementById('standardValue').textContent = standardValue.toFixed(0) + ' Ω';
            document.getElementById('powerRating').textContent = recommendedRating.split('(')[1].replace(')', '');
            document.getElementById('actualCurrent').textContent = (actualCurrent * 1000).toFixed(1) + ' mA';
            
            // Color code display
            const colorCodeDiv = document.getElementById('colorCode');
            colorCodeDiv.innerHTML = `
                <div class="color-band" style="background: ${colorCode.band1.color}; color: ${colorCode.band1.digit >= 5 ? '#000' : '#fff'}">${colorCode.band1.digit}</div>
                <div class="color-band" style="background: ${colorCode.band2.color}; color: ${colorCode.band2.digit >= 5 ? '#000' : '#fff'}">${colorCode.band2.digit}</div>
                <div class="color-band" style="background: ${colorCodes[colorCode.multiplier].color}; color: ${colorCode.multiplier >= 5 ? '#000' : '#fff'}">×10${colorCode.multiplier > 0 ? '<sup>' + colorCode.multiplier + '</sup>' : ''}</div>
                <div class="color-band" style="background: #FFD700; color: #000;">±5%</div>
            `;
            
            document.getElementById('sourceVDisplay').textContent = sourceVoltage.toFixed(1) + ' V';
            document.getElementById('ledVDisplay').textContent = ledVoltage.toFixed(1) + ' V';
            document.getElementById('ledCountDisplay').textContent = ledCount + ' LED' + (ledCount > 1 ? 's' : '');
            document.getElementById('totalLEDV').textContent = totalLEDVoltage.toFixed(1) + ' V';
            document.getElementById('resistorV').textContent = voltageAcrossResistor.toFixed(1) + ' V';
            document.getElementById('desiredI').textContent = (ledCurrent * 1000).toFixed(1) + ' mA';
            
            document.getElementById('powerResistor').textContent = powerResistor.toFixed(3) + ' W';
            document.getElementById('powerLED').textContent = powerPerLED.toFixed(3) + ' W';
            document.getElementById('totalPower').textContent = totalPower.toFixed(3) + ' W';
            document.getElementById('recRating').textContent = recommendedRating;
            
            document.getElementById('lowerValue').textContent = lowerValue.toFixed(0) + ' Ω';
            document.getElementById('exactValue').textContent = resistorValue.toFixed(1) + ' Ω';
            document.getElementById('higherValue').textContent = higherValue.toFixed(0) + ' Ω';
            document.getElementById('recommended').textContent = standardValue.toFixed(0) + ' Ω';
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateResistor();
        });
    </script>
</body>
</html>