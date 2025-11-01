<?php
/**
 * Horsepower Calculator
 * File: automotive/horsepower-calculator.php
 * Description: Calculate engine horsepower from torque, RPM, and other metrics
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horsepower Calculator - Engine Power & Torque Converter</title>
    <meta name="description" content="Advanced horsepower calculator. Calculate HP from torque and RPM, convert between power units, and analyze engine performance metrics.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #667eea; margin-bottom: 25px; font-size: 1.8rem; }
        
        .tabs { display: flex; gap: 10px; margin-bottom: 25px; }
        .tab { flex: 1; padding: 12px; background: #f0f0f0; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s; }
        .tab.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
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
        
        .power-curve { width: 100%; height: 200px; background: #f8f9fa; border-radius: 12px; position: relative; margin: 20px 0; }
        .curve-line { stroke: #667eea; stroke-width: 3; fill: none; }
        .curve-area { fill: url(#gradient); opacity: 0.3; }
        
        .info-box { background: #e8f2ff; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #667eea; }
        
        .formula-box { background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0; font-family: 'Courier New', monospace; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: repeat(2, 1fr); }
            .input-group { grid-template-columns: 1fr; }
            .tabs { flex-direction: column; }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
            .metric-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚙️ Horsepower Calculator</h1>
            <p>Calculate engine power from torque, RPM, and other metrics</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Calculation Method</h2>
                
                <div class="tabs">
                    <button class="tab active" onclick="switchTab('torque')">From Torque</button>
                    <button class="tab" onclick="switchTab('weight')">From Weight/Time</button>
                    <button class="tab" onclick="switchTab('convert')">Unit Converter</button>
                </div>

                <!-- Tab 1: From Torque -->
                <div id="torque-tab" class="tab-content active">
                    <form id="torqueForm">
                        <div class="form-group">
                            <label for="torque">Torque</label>
                            <div class="input-group">
                                <input type="number" id="torque" value="400" min="1" max="10000" step="1" required>
                                <select id="torqueUnit" style="padding: 12px;">
                                    <option value="lbft" selected>lb-ft</option>
                                    <option value="nm">Nm</option>
                                </select>
                            </div>
                            <small>Engine torque output</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="rpm">RPM (Revolutions Per Minute)</label>
                            <input type="number" id="rpm" value="5500" min="100" max="15000" step="100" required>
                            <small>Engine speed</small>
                        </div>
                        
                        <div class="formula-box">
                            <strong>Formula:</strong><br>
                            HP = (Torque × RPM) / 5252
                        </div>
                        
                        <button type="submit" class="btn">Calculate Horsepower</button>
                    </form>
                </div>

                <!-- Tab 2: From Weight/Time -->
                <div id="weight-tab" class="tab-content">
                    <form id="weightForm">
                        <div class="form-group">
                            <label for="vehicleWeight">Vehicle Weight</label>
                            <div class="input-group">
                                <input type="number" id="vehicleWeight" value="3500" min="500" max="10000" step="10" required>
                                <select id="weightUnit" style="padding: 12px;">
                                    <option value="lbs" selected>lbs</option>
                                    <option value="kg">kg</option>
                                </select>
                            </div>
                            <small>Total vehicle weight</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="time060">0-60 mph Time (seconds)</label>
                            <input type="number" id="time060" value="5.5" min="1" max="30" step="0.1" required>
                            <small>Acceleration time</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="efficiency">Drivetrain Efficiency (%)</label>
                            <input type="number" id="efficiency" value="85" min="50" max="100" step="1">
                            <small>Power loss through drivetrain (85% typical)</small>
                        </div>
                        
                        <div class="formula-box">
                            <strong>Formula:</strong><br>
                            HP ≈ (Weight / Time) × 0.036 / Efficiency
                        </div>
                        
                        <button type="submit" class="btn">Calculate Horsepower</button>
                    </form>
                </div>

                <!-- Tab 3: Unit Converter -->
                <div id="convert-tab" class="tab-content">
                    <form id="convertForm">
                        <div class="form-group">
                            <label for="powerValue">Power Value</label>
                            <input type="number" id="powerValue" value="400" min="0.1" max="10000" step="0.1" required>
                            <small>Enter power value to convert</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="fromUnit">Convert From</label>
                            <select id="fromUnit">
                                <option value="hp" selected>Horsepower (HP)</option>
                                <option value="kw">Kilowatts (kW)</option>
                                <option value="ps">Metric HP (PS)</option>
                                <option value="bhp">Brake HP (BHP)</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="toUnit">Convert To</label>
                            <select id="toUnit">
                                <option value="hp">Horsepower (HP)</option>
                                <option value="kw" selected>Kilowatts (kW)</option>
                                <option value="ps">Metric HP (PS)</option>
                                <option value="bhp">Brake HP (BHP)</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn">Convert Units</button>
                    </form>
                </div>
            </div>

            <div class="results-section">
                <h2>Power Results</h2>
                
                <div class="result-card">
                    <h3>Horsepower</h3>
                    <div class="amount" id="horsepowerResult">419 HP</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Kilowatts</h4>
                        <div class="value" id="kilowatts">312</div>
                        <small>kW</small>
                    </div>
                    <div class="metric-card">
                        <h4>Metric HP</h4>
                        <div class="value" id="metricHP">425</div>
                        <small>PS</small>
                    </div>
                    <div class="metric-card">
                        <h4>Brake HP</h4>
                        <div class="value" id="brakeHP">419</div>
                        <small>BHP</small>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Power Curve</h3>
                    <svg class="power-curve" viewBox="0 0 300 150" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#764ba2;stop-opacity:0.3" />
                            </linearGradient>
                        </defs>
                        <path class="curve-area" d="M 20 130 Q 75 80, 150 60 T 280 70 L 280 130 Z"/>
                        <path class="curve-line" d="M 20 130 Q 75 80, 150 60 T 280 70"/>
                        <text x="150" y="50" text-anchor="middle" font-size="14" fill="#667eea" font-weight="bold">Peak Power</text>
                        <line x1="20" y1="130" x2="280" y2="130" stroke="#ccc" stroke-width="2"/>
                        <line x1="20" y1="20" x2="20" y2="130" stroke="#ccc" stroke-width="2"/>
                        <text x="150" y="145" text-anchor="middle" font-size="11" fill="#666">RPM →</text>
                        <text x="10" y="75" text-anchor="middle" font-size="11" fill="#666" transform="rotate(-90, 10, 75)">HP →</text>
                    </svg>
                </div>

                <div class="breakdown">
                    <h3>Input Values</h3>
                    <div class="breakdown-item">
                        <span>Torque</span>
                        <strong id="torqueDisplay">400 lb-ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>RPM</span>
                        <strong id="rpmDisplay">5,500 RPM</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Calculation Method</span>
                        <strong id="methodDisplay">Torque × RPM</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Power Conversions</h3>
                    <div class="breakdown-item">
                        <span>Horsepower (HP)</span>
                        <strong id="hpFull">419 HP</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Kilowatts (kW)</span>
                        <strong id="kwFull">312.3 kW</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Metric Horsepower (PS)</span>
                        <strong id="psFull">424.7 PS</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Brake Horsepower (BHP)</span>
                        <strong id="bhpFull">419.0 BHP</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Foot-Pounds/Second</span>
                        <strong id="ftlbSec">308,400 ft·lb/s</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Torque Analysis</h3>
                    <div class="breakdown-item">
                        <span>Torque (lb-ft)</span>
                        <strong id="torqueLbft">400 lb-ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Torque (Nm)</span>
                        <strong id="torqueNm">542 Nm</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Peak Power RPM</span>
                        <strong id="peakRpm">5,500 RPM</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Power at Idle (1000 RPM)</span>
                        <strong id="idlePower">76 HP</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Power at Redline (7000 RPM)</span>
                        <strong id="redlinePower">533 HP</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Formula Explanation:</strong><br>
                    HP = (Torque × RPM) / 5252<br><br>
                    The constant 5252 comes from converting rotational speed (RPM) and torque to the standard horsepower unit (550 ft·lb/s). This is the fundamental relationship between torque and horsepower.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⚙️ Horsepower Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Engine power and torque calculations</p>
        </div>
    </div>

    <script>
        let currentTab = 'torque';

        function switchTab(tab) {
            currentTab = tab;
            
            // Update tab buttons
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            event.target.classList.add('active');
            
            // Update tab content
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.getElementById(tab + '-tab').classList.add('active');
        }

        // Form handlers
        document.getElementById('torqueForm').addEventListener('submit', function(e) {
            e.preventDefault();
            calculateFromTorque();
        });

        document.getElementById('weightForm').addEventListener('submit', function(e) {
            e.preventDefault();
            calculateFromWeight();
        });

        document.getElementById('convertForm').addEventListener('submit', function(e) {
            e.preventDefault();
            convertUnits();
        });

        function calculateFromTorque() {
            const torque = parseFloat(document.getElementById('torque').value);
            const torqueUnit = document.getElementById('torqueUnit').value;
            const rpm = parseFloat(document.getElementById('rpm').value);
            
            // Convert torque to lb-ft if needed
            const torqueLbft = torqueUnit === 'nm' ? torque * 0.737562 : torque;
            const torqueNm = torqueUnit === 'nm' ? torque : torque * 1.35582;
            
            // Calculate horsepower
            const horsepower = (torqueLbft * rpm) / 5252;
            
            // Update display
            updateResults(horsepower, torqueLbft, rpm);
            
            document.getElementById('methodDisplay').textContent = 'Torque × RPM';
            document.getElementById('torqueDisplay').textContent = torqueLbft.toFixed(1) + ' lb-ft';
            document.getElementById('rpmDisplay').textContent = rpm.toLocaleString() + ' RPM';
        }

        function calculateFromWeight() {
            const weight = parseFloat(document.getElementById('vehicleWeight').value);
            const weightUnit = document.getElementById('weightUnit').value;
            const time060 = parseFloat(document.getElementById('time060').value);
            const efficiency = parseFloat(document.getElementById('efficiency').value) / 100;
            
            // Convert weight to lbs if needed
            const weightLbs = weightUnit === 'kg' ? weight * 2.20462 : weight;
            
            // Estimate horsepower from 0-60 time
            // Simplified formula: HP ≈ (Weight / Time²) × 0.036 / Efficiency
            const horsepower = (weightLbs / (time060 * time060)) * 0.036 / efficiency;
            
            // Estimate torque (assuming peak at 5500 RPM)
            const estimatedRpm = 5500;
            const estimatedTorque = (horsepower * 5252) / estimatedRpm;
            
            // Update display
            updateResults(horsepower, estimatedTorque, estimatedRpm);
            
            document.getElementById('methodDisplay').textContent = 'Weight/Time Estimation';
            document.getElementById('torqueDisplay').textContent = estimatedTorque.toFixed(1) + ' lb-ft (estimated)';
            document.getElementById('rpmDisplay').textContent = estimatedRpm.toLocaleString() + ' RPM (estimated)';
        }

        function convertUnits() {
            const powerValue = parseFloat(document.getElementById('powerValue').value);
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;
            
            // Conversion factors to HP
            const toHP = {
                'hp': 1,
                'kw': 1.341,
                'ps': 0.9863,
                'bhp': 1
            };
            
            // Convert to HP first
            const hp = powerValue * toHP[fromUnit];
            
            // Update display
            updateResults(hp, 0, 0);
            
            document.getElementById('methodDisplay').textContent = 'Unit Conversion';
            document.getElementById('torqueDisplay').textContent = 'N/A';
            document.getElementById('rpmDisplay').textContent = 'N/A';
        }

        function updateResults(horsepower, torque, rpm) {
            // Convert to all units
            const kw = horsepower * 0.7457;
            const ps = horsepower * 1.0139;
            const bhp = horsepower;
            
            // Update main display
            document.getElementById('horsepowerResult').textContent = Math.round(horsepower) + ' HP';
            document.getElementById('kilowatts').textContent = Math.round(kw);
            document.getElementById('metricHP').textContent = Math.round(ps);
            document.getElementById('brakeHP').textContent = Math.round(bhp);
            
            // Update conversions
            document.getElementById('hpFull').textContent = horsepower.toFixed(1) + ' HP';
            document.getElementById('kwFull').textContent = kw.toFixed(1) + ' kW';
            document.getElementById('psFull').textContent = ps.toFixed(1) + ' PS';
            document.getElementById('bhpFull').textContent = bhp.toFixed(1) + ' BHP';
            document.getElementById('ftlbSec').textContent = (horsepower * 550).toLocaleString() + ' ft·lb/s';
            
            // Update torque analysis
            if (torque > 0) {
                const torqueNm = torque * 1.35582;
                document.getElementById('torqueLbft').textContent = torque.toFixed(1) + ' lb-ft';
                document.getElementById('torqueNm').textContent = torqueNm.toFixed(1) + ' Nm';
                document.getElementById('peakRpm').textContent = rpm.toLocaleString() + ' RPM';
                
                // Calculate power at different RPMs
                const idlePower = (torque * 1000) / 5252;
                const redlinePower = (torque * 7000) / 5252;
                document.getElementById('idlePower').textContent = Math.round(idlePower) + ' HP';
                document.getElementById('redlinePower').textContent = Math.round(redlinePower) + ' HP';
            }
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateFromTorque();
        });
    </script>
</body>
</html>