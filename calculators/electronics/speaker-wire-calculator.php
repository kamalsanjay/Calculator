<?php
/**
 * Speaker Wire Calculator
 * File: electronics/speaker-wire-calculator.php
 * Description: Advanced speaker wire calculator with gauge selection, power handling, and impedance calculations
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speaker Wire Calculator - Wire Gauge, Length & Power Calculations</title>
    <meta name="description" content="Advanced speaker wire calculator. Calculate proper wire gauge, power loss, voltage drop, and impedance for your audio system.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh; 
            padding: 20px; 
        }
        
        .container { 
            max-width: 1400px; 
            margin: 0 auto; 
        }
        
        .header { 
            background: rgba(255,255,255,0.95); 
            padding: 30px; 
            border-radius: 20px 20px 0 0; 
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1); 
            text-align: center; 
        }
        .header h1 { 
            color: #2c3e50; 
            font-size: 2.5rem; 
            margin-bottom: 10px; 
        }
        .header p { 
            color: #7f8c8d; 
            font-size: 1.2rem; 
            opacity: 0.9; 
        }
        
        .calculator-wrapper { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 30px; 
            background: white; 
            padding: 35px; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.12); 
        }
        
        .calculator-section h2, .results-section h2 { 
            color: #667eea; 
            margin-bottom: 25px; 
            font-size: 1.8rem; 
        }
        
        .form-group { 
            margin-bottom: 20px; 
        }
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            color: #555; 
        }
        .form-group input, .form-group select { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #e0e0e0; 
            border-radius: 8px; 
            font-size: 16px; 
            transition: border-color 0.3s; 
        }
        .form-group input:focus, .form-group select:focus { 
            outline: none; 
            border-color: #667eea; 
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); 
        }
        .form-group small { 
            display: block; 
            margin-top: 5px; 
            color: #888; 
            font-size: 0.9em; 
        }
        
        .input-group { 
            display: grid; 
            grid-template-columns: 2fr 1fr; 
            gap: 10px; 
            align-items: end; 
        }
        
        .btn { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 15px 30px; 
            border: none; 
            border-radius: 8px; 
            font-size: 18px; 
            font-weight: 600; 
            cursor: pointer; 
            width: 100%; 
            transition: all 0.3s; 
        }
        .btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); 
        }
        
        .result-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 25px; 
            border-radius: 12px; 
            margin-bottom: 20px; 
            text-align: center; 
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); 
            position: relative; 
            overflow: hidden; 
        }
        .result-card::before { 
            content: ''; 
            position: absolute; 
            top: -50%; 
            right: -50%; 
            width: 200%; 
            height: 200%; 
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); 
            animation: pulse 3s ease-in-out infinite; 
        }
        @keyframes pulse { 
            0%, 100% { transform: scale(1); opacity: 0.5; } 
            50% { transform: scale(1.1); opacity: 0.8; } 
        }
        .result-card h3 { 
            font-size: 1.2rem; 
            opacity: 0.9; 
            margin-bottom: 10px; 
            font-weight: 400; 
            position: relative; 
            z-index: 1; 
        }
        .result-card .amount { 
            font-size: 3rem; 
            font-weight: bold; 
            position: relative; 
            z-index: 1; 
        }
        
        .metric-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-bottom: 20px; 
        }
        .metric-card { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 12px; 
            text-align: center; 
            border: 2px solid #e0e0e0; 
            transition: all 0.3s; 
        }
        .metric-card:hover { 
            transform: translateY(-2px); 
            border-color: #667eea; 
        }
        .metric-card h4 { 
            color: #666; 
            font-size: 0.9rem; 
            margin-bottom: 10px; 
            font-weight: 400; 
        }
        .metric-card .value { 
            color: #667eea; 
            font-size: 1.8rem; 
            font-weight: bold; 
        }
        
        .breakdown { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 12px; 
            margin-bottom: 20px; 
        }
        .breakdown h3 { 
            color: #667eea; 
            margin-bottom: 15px; 
            font-size: 1.3rem; 
        }
        .breakdown-item { 
            display: flex; 
            justify-content: space-between; 
            padding: 12px 0; 
            border-bottom: 1px solid #e0e0e0; 
        }
        .breakdown-item:last-child { 
            border-bottom: none; 
        }
        .breakdown-item span { 
            color: #666; 
        }
        .breakdown-item strong { 
            color: #333; 
            font-weight: 600; 
        }
        
        .gauge-visual { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            margin: 15px 0; 
            padding: 15px; 
            background: white; 
            border-radius: 8px; 
            border: 2px solid #e0e0e0; 
        }
        .gauge-wire { 
            height: 8px; 
            background: linear-gradient(90deg, #4CAF50, #FFC107, #F44336); 
            border-radius: 4px; 
            flex-grow: 1; 
            margin: 0 10px; 
            position: relative; 
        }
        .gauge-marker { 
            position: absolute; 
            top: -5px; 
            width: 3px; 
            height: 18px; 
            background: #333; 
            transform: translateX(-50%); 
        }
        .gauge-label { 
            font-size: 0.8rem; 
            color: #666; 
            text-align: center; 
            margin-top: 5px; 
        }
        
        .wire-comparison { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 15px; 
            margin-top: 15px; 
        }
        .wire-card { 
            background: white; 
            padding: 15px; 
            border-radius: 8px; 
            border: 2px solid #e0e0e0; 
            text-align: center; 
            transition: all 0.3s; 
        }
        .wire-card:hover { 
            transform: translateY(-2px); 
            border-color: #667eea; 
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.2); 
        }
        .wire-card.recommended { 
            border-color: #4CAF50; 
            background: #f1f8e9; 
        }
        .wire-card h4 { 
            color: #667eea; 
            margin-bottom: 10px; 
        }
        .wire-card .gauge { 
            font-size: 1.5rem; 
            font-weight: bold; 
            color: #333; 
        }
        .wire-card .specs { 
            color: #666; 
            font-size: 0.9rem; 
            margin: 8px 0; 
        }
        
        .power-loss-indicator { 
            height: 10px; 
            background: #e0e0e0; 
            border-radius: 5px; 
            overflow: hidden; 
            margin: 10px 0; 
            position: relative; 
        }
        .power-loss-fill { 
            height: 100%; 
            background: linear-gradient(90deg, #4CAF50, #FFC107, #F44336); 
            width: 0%; 
            transition: width 1s ease-out; 
        }
        .power-loss-labels { 
            display: flex; 
            justify-content: space-between; 
            margin-top: 5px; 
            font-size: 0.8rem; 
            color: #666; 
        }
        
        .system-preset { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
            gap: 8px; 
            margin-top: 10px; 
        }
        .preset-btn { 
            padding: 10px 12px; 
            background: #f0f0f0; 
            border: 2px solid #e0e0e0; 
            border-radius: 6px; 
            cursor: pointer; 
            text-align: center; 
            font-size: 0.85rem; 
            transition: all 0.3s; 
        }
        .preset-btn:hover { 
            background: #667eea; 
            color: white; 
            border-color: #667eea; 
        }
        .preset-btn.active { 
            background: #667eea; 
            color: white; 
            border-color: #667eea; 
        }
        
        .info-box { 
            background: #e8f2ff; 
            border-left: 4px solid #667eea; 
            padding: 15px; 
            margin: 20px 0; 
            border-radius: 5px; 
        }
        .info-box strong { 
            color: #667eea; 
        }
        
        .footer { 
            background: rgba(255,255,255,0.95); 
            padding: 25px; 
            border-radius: 0 0 20px 20px; 
            text-align: center; 
            color: #7f8c8d; 
        }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { 
                grid-template-columns: 1fr; 
                padding: 25px; 
            }
            .result-card .amount { 
                font-size: 2.5rem; 
            }
        }
        
        @media (max-width: 768px) {
            .header h1 { 
                font-size: 2rem; 
            }
            .metric-grid { 
                grid-template-columns: 1fr; 
            }
            .input-group { 
                grid-template-columns: 1fr; 
            }
            .system-preset { 
                grid-template-columns: repeat(2, 1fr); 
            }
            .wire-comparison { 
                grid-template-columns: 1fr; 
            }
        }
        
        @media (max-width: 480px) {
            .header h1 { 
                font-size: 1.5rem; 
            }
            .header p { 
                font-size: 1rem; 
            }
            .result-card .amount { 
                font-size: 2rem; 
            }
            body { 
                padding: 10px; 
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔊 Speaker Wire Calculator</h1>
            <p>Calculate proper wire gauge, power loss, and impedance for your audio system</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>System Parameters</h2>
                <form id="wireForm">
                    <div class="form-group">
                        <label for="wireLength">Wire Length (One Way)</label>
                        <div class="input-group">
                            <input type="number" id="wireLength" value="15" min="1" max="500" step="0.5" required>
                            <select id="lengthUnit" style="padding: 12px;">
                                <option value="feet" selected>Feet</option>
                                <option value="meters">Meters</option>
                            </select>
                        </div>
                        <small>Distance from amplifier to speaker (one direction)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="speakerImpedance">Speaker Impedance</label>
                        <select id="speakerImpedance" style="padding: 12px;">
                            <option value="2">2 Ω</option>
                            <option value="4" selected>4 Ω</option>
                            <option value="6">6 Ω</option>
                            <option value="8">8 Ω</option>
                            <option value="16">16 Ω</option>
                        </select>
                        <small>Nominal impedance of your speakers</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="amplifierPower">Amplifier Power</label>
                        <div class="input-group">
                            <input type="number" id="amplifierPower" value="100" min="1" max="2000" step="1" required>
                            <select id="powerUnit" style="padding: 12px;">
                                <option value="watts" selected>Watts</option>
                            </select>
                        </div>
                        <small>RMS power per channel</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentWireGauge">Current Wire Gauge (AWG)</label>
                        <select id="currentWireGauge" style="padding: 12px;">
                            <option value="8">8 AWG (Very Thick)</option>
                            <option value="10">10 AWG (Thick)</option>
                            <option value="12" selected>12 AWG (Standard)</option>
                            <option value="14">14 AWG (Medium)</option>
                            <option value="16">16 AWG (Thin)</option>
                            <option value="18">18 AWG (Very Thin)</option>
                            <option value="20">20 AWG (Extremely Thin)</option>
                        </select>
                        <small>Gauge of your current speaker wire</small>
                    </div>
                    
                    <div class="form-group">
                        <label>System Presets</label>
                        <div class="system-preset">
                            <div class="preset-btn" onclick="setPreset('Bookshelf', '8', '4', '50', '16')">Bookshelf</div>
                            <div class="preset-btn" onclick="setPreset('Home Theater', '15', '8', '100', '14')">Home Theater</div>
                            <div class="preset-btn" onclick="setPreset('Car Audio', '12', '4', '75', '12')">Car Audio</div>
                            <div class="preset-btn" onclick="setPreset('Studio', '25', '8', '200', '12')">Studio</div>
                            <div class="preset-btn" onclick="setPreset('Outdoor', '50', '8', '100', '10')">Outdoor</div>
                            <div class="preset-btn" onclick="setPreset('Concert', '100', '8', '500', '8')">Concert</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="powerLossThreshold">Maximum Acceptable Power Loss</label>
                        <select id="powerLossThreshold" style="padding: 12px;">
                            <option value="0.5">0.5% (Critical Listening)</option>
                            <option value="1" selected>1% (High Quality)</option>
                            <option value="2">2% (Good Quality)</option>
                            <option value="5">5% (Standard)</option>
                            <option value="10">10% (Minimum)</option>
                        </select>
                        <small>Maximum power loss you're willing to accept</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Wire Requirements</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Wire Analysis</h2>
                
                <div class="result-card">
                    <h3>Recommended Wire Gauge</h3>
                    <div class="amount" id="recommendedGauge">12 AWG</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Power Loss</h4>
                        <div class="value" id="powerLoss">1.2%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Voltage Drop</h4>
                        <div class="value" id="voltageDrop">0.24V</div>
                    </div>
                    <div class="metric-card">
                        <h4>Damping Factor</h4>
                        <div class="value" id="dampingFactor">185</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Current Wire Performance</h3>
                    <div class="breakdown-item">
                        <span>Wire Gauge</span>
                        <strong id="currentGaugeDisplay">12 AWG</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Resistance per 1000ft</span>
                        <strong id="wireResistance">1.588 Ω</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Wire Resistance</span>
                        <strong id="totalResistance">0.048 Ω</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Power Loss</span>
                        <strong id="currentPowerLoss">1.2% (1.2W)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Voltage at Speaker</span>
                        <strong id="voltageAtSpeaker">19.76V</strong>
                    </div>
                    
                    <div class="power-loss-indicator">
                        <div class="power-loss-fill" id="powerLossFill"></div>
                    </div>
                    <div class="power-loss-labels">
                        <span>Excellent</span>
                        <span>Good</span>
                        <span>Acceptable</span>
                        <span>Poor</span>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>System Details</h3>
                    <div class="breakdown-item">
                        <span>Wire Length (Total)</span>
                        <strong id="totalLength">30 feet</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Speaker Impedance</span>
                        <strong id="impedanceDisplay">4 Ω</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Amplifier Power</span>
                        <strong id="powerDisplay">100W</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Through Wire</span>
                        <strong id="currentFlow">5A</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Power at Speaker</span>
                        <strong id="powerAtSpeaker">98.8W</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Wire Gauge Comparison</h3>
                    <div class="gauge-visual">
                        <span style="font-size: 0.9rem; color: #666;">Thicker</span>
                        <div class="gauge-wire" id="gaugeVisual">
                            <!-- Markers will be added by JavaScript -->
                        </div>
                        <span style="font-size: 0.9rem; color: #666;">Thinner</span>
                    </div>
                    <div class="wire-comparison" id="wireComparison">
                        <!-- Wire cards will be added by JavaScript -->
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Advanced Calculations</h3>
                    <div class="breakdown-item">
                        <span>Cross-sectional Area</span>
                        <strong id="crossSectional">3.309 mm²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Capacity</span>
                        <strong id="currentCapacity">20A</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Skin Effect Frequency</span>
                        <strong id="skinEffect">6.7 kHz</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Characteristic Impedance</span>
                        <strong id="characteristicImpedance">~100 Ω</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> For best audio quality, keep power loss below 1-2%. Thicker wires (lower AWG numbers) reduce resistance and power loss. Consider oxygen-free copper (OFC) wire for critical listening applications.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🔊 Speaker Wire Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced audio wire calculations and recommendations</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('wireForm');
        let currentPreset = '';

        // AWG wire properties (resistance in ohms per 1000 feet at 20°C)
        const awgProperties = {
            8: { resistance: 0.6282, diameter: 3.264, area: 8.367, current: 40 },
            10: { resistance: 0.9989, diameter: 2.588, area: 5.261, current: 30 },
            12: { resistance: 1.588, diameter: 2.053, area: 3.309, current: 20 },
            14: { resistance: 2.525, diameter: 1.628, area: 2.081, current: 15 },
            16: { resistance: 4.016, diameter: 1.291, area: 1.309, current: 10 },
            18: { resistance: 6.385, diameter: 1.024, area: 0.823, current: 7 },
            20: { resistance: 10.15, diameter: 0.812, area: 0.518, current: 5 }
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateWireRequirements();
        });

        function setPreset(name, length, impedance, power, gauge) {
            document.getElementById('wireLength').value = length;
            document.getElementById('speakerImpedance').value = impedance;
            document.getElementById('amplifierPower').value = power;
            document.getElementById('currentWireGauge').value = gauge;
            currentPreset = name;
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateWireRequirements();
        }

        function calculateWireRequirements() {
            // Get inputs
            let wireLength = parseFloat(document.getElementById('wireLength').value);
            const lengthUnit = document.getElementById('lengthUnit').value;
            const speakerImpedance = parseFloat(document.getElementById('speakerImpedance').value);
            const amplifierPower = parseFloat(document.getElementById('amplifierPower').value);
            const currentWireGauge = parseInt(document.getElementById('currentWireGauge').value);
            const powerLossThreshold = parseFloat(document.getElementById('powerLossThreshold').value);
            
            // Convert to feet if needed
            if (lengthUnit === 'meters') {
                wireLength = wireLength * 3.28084; // Convert meters to feet
            }
            
            const totalLength = wireLength * 2; // Round trip length
            
            // Calculate current through wire
            const voltage = Math.sqrt(amplifierPower * speakerImpedance);
            const current = voltage / speakerImpedance;
            
            // Calculate resistance and power loss for current wire
            const wireResistancePer1000ft = awgProperties[currentWireGauge].resistance;
            const totalWireResistance = (wireResistancePer1000ft * totalLength) / 1000;
            const powerLossWatts = Math.pow(current, 2) * totalWireResistance;
            const powerLossPercent = (powerLossWatts / amplifierPower) * 100;
            const powerAtSpeaker = amplifierPower - powerLossWatts;
            
            // Calculate voltage drop
            const voltageDrop = current * totalWireResistance;
            const voltageAtSpeaker = voltage - voltageDrop;
            
            // Calculate damping factor
            const dampingFactor = speakerImpedance / totalWireResistance;
            
            // Find recommended gauge based on power loss threshold
            let recommendedGauge = currentWireGauge;
            for (const gauge in awgProperties) {
                const gaugeResistance = awgProperties[gauge].resistance;
                const gaugeTotalResistance = (gaugeResistance * totalLength) / 1000;
                const gaugePowerLoss = Math.pow(current, 2) * gaugeTotalResistance;
                const gaugePowerLossPercent = (gaugePowerLoss / amplifierPower) * 100;
                
                if (gaugePowerLossPercent <= powerLossThreshold) {
                    recommendedGauge = parseInt(gauge);
                    break;
                }
            }
            
            // If no gauge meets threshold, use the thickest available
            if (recommendedGauge > currentWireGauge) {
                recommendedGauge = 8; // Thickest available
            }
            
            // Calculate additional properties
            const crossSectional = awgProperties[currentWireGauge].area;
            const currentCapacity = awgProperties[currentWireGauge].current;
            const skinEffectFreq = calculateSkinEffectFrequency(currentWireGauge);
            const characteristicImpedance = estimateCharacteristicImpedance(currentWireGauge);
            
            // Update UI
            document.getElementById('recommendedGauge').textContent = recommendedGauge + ' AWG';
            document.getElementById('powerLoss').textContent = powerLossPercent.toFixed(1) + '%';
            document.getElementById('voltageDrop').textContent = voltageDrop.toFixed(2) + 'V';
            document.getElementById('dampingFactor').textContent = Math.round(dampingFactor);
            
            document.getElementById('currentGaugeDisplay').textContent = currentWireGauge + ' AWG';
            document.getElementById('wireResistance').textContent = wireResistancePer1000ft.toFixed(3) + ' Ω';
            document.getElementById('totalResistance').textContent = totalWireResistance.toFixed(3) + ' Ω';
            document.getElementById('currentPowerLoss').textContent = powerLossPercent.toFixed(1) + '% (' + powerLossWatts.toFixed(1) + 'W)';
            document.getElementById('voltageAtSpeaker').textContent = voltageAtSpeaker.toFixed(2) + 'V';
            
            document.getElementById('totalLength').textContent = totalLength.toFixed(0) + ' feet';
            document.getElementById('impedanceDisplay').textContent = speakerImpedance + ' Ω';
            document.getElementById('powerDisplay').textContent = amplifierPower + 'W';
            document.getElementById('currentFlow').textContent = current.toFixed(1) + 'A';
            document.getElementById('powerAtSpeaker').textContent = powerAtSpeaker.toFixed(1) + 'W';
            
            document.getElementById('crossSectional').textContent = crossSectional.toFixed(3) + ' mm²';
            document.getElementById('currentCapacity').textContent = currentCapacity + 'A';
            document.getElementById('skinEffect').textContent = skinEffectFreq.toFixed(1) + ' kHz';
            document.getElementById('characteristicImpedance').textContent = characteristicImpedance;
            
            // Update power loss indicator
            const powerLossPercentage = Math.min(100, (powerLossPercent / 10) * 100); // Scale to 10% max
            document.getElementById('powerLossFill').style.width = powerLossPercentage + '%';
            
            // Update gauge visualization
            updateGaugeVisualization(currentWireGauge, recommendedGauge);
            
            // Update wire comparison
            updateWireComparison(currentWireGauge, recommendedGauge, totalLength, current, amplifierPower);
        }
        
        function calculateSkinEffectFrequency(gauge) {
            // Simplified skin effect calculation
            const diameter = awgProperties[gauge].diameter;
            // Skin effect becomes significant when skin depth equals radius
            // f = ρ / (π * μ * r²) where ρ = resistivity, μ = permeability, r = radius
            const resistivity = 1.68e-8; // Copper resistivity in ohm-meters
            const permeability = 4 * Math.PI * 1e-7; // Permeability of free space
            const radius = (diameter * 0.0254 / 2) / 100; // Convert to meters
            const frequency = resistivity / (Math.PI * permeability * Math.pow(radius, 2));
            return frequency / 1000; // Convert to kHz
        }
        
        function estimateCharacteristicImpedance(gauge) {
            // Rough estimate for typical speaker wire
            if (gauge <= 10) return '~75-100 Ω';
            if (gauge <= 14) return '~100-150 Ω';
            return '~150-200 Ω';
        }
        
        function updateGaugeVisualization(currentGauge, recommendedGauge) {
            const gaugeVisual = document.getElementById('gaugeVisual');
            gaugeVisual.innerHTML = '';
            
            // Add markers for different gauges
            const gauges = [8, 10, 12, 14, 16, 18, 20];
            gauges.forEach(gauge => {
                const marker = document.createElement('div');
                marker.className = 'gauge-marker';
                
                // Position marker based on gauge (8 = left, 20 = right)
                const position = ((gauge - 8) / (20 - 8)) * 100;
                marker.style.left = position + '%';
                
                // Highlight current and recommended gauges
                if (gauge === currentGauge) {
                    marker.style.background = '#667eea';
                    marker.style.height = '25px';
                    marker.style.top = '-10px';
                } else if (gauge === recommendedGauge) {
                    marker.style.background = '#4CAF50';
                    marker.style.height = '20px';
                    marker.style.top = '-7px';
                }
                
                // Add label
                const label = document.createElement('div');
                label.className = 'gauge-label';
                label.textContent = gauge + ' AWG';
                label.style.position = 'absolute';
                label.style.left = position + '%';
                label.style.transform = 'translateX(-50%)';
                label.style.top = '20px';
                label.style.width = '40px';
                
                gaugeVisual.appendChild(marker);
                gaugeVisual.appendChild(label);
            });
        }
        
        function updateWireComparison(currentGauge, recommendedGauge, totalLength, current, amplifierPower) {
            const wireComparison = document.getElementById('wireComparison');
            wireComparison.innerHTML = '';
            
            const gauges = [8, 10, 12, 14, 16, 18];
            
            gauges.forEach(gauge => {
                const wireResistancePer1000ft = awgProperties[gauge].resistance;
                const totalWireResistance = (wireResistancePer1000ft * totalLength) / 1000;
                const powerLossWatts = Math.pow(current, 2) * totalWireResistance;
                const powerLossPercent = (powerLossWatts / amplifierPower) * 100;
                const currentCapacity = awgProperties[gauge].current;
                
                const wireCard = document.createElement('div');
                wireCard.className = 'wire-card';
                
                if (gauge === recommendedGauge) {
                    wireCard.classList.add('recommended');
                }
                
                let recommendation = '';
                if (gauge === recommendedGauge) {
                    recommendation = '<div style="color: #4CAF50; font-weight: bold; margin-top: 5px;">✓ Recommended</div>';
                } else if (gauge < recommendedGauge) {
                    recommendation = '<div style="color: #4CAF50; margin-top: 5px;">Overkill</div>';
                } else {
                    recommendation = '<div style="color: #F44336; margin-top: 5px;">Insufficient</div>';
                }
                
                wireCard.innerHTML = `
                    <h4>${gauge} AWG</h4>
                    <div class="gauge">${gauge} AWG</div>
                    <div class="specs">
                        Resistance: ${wireResistancePer1000ft.toFixed(2)} Ω/kft<br>
                        Power Loss: ${powerLossPercent.toFixed(1)}%<br>
                        Current: ${currentCapacity}A max
                    </div>
                    ${recommendation}
                `;
                
                wireComparison.appendChild(wireCard);
            });
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateWireRequirements();
        });
    </script>
</body>
</html>
