<?php
/**
 * Gear Ratio Calculator
 * File: automotive/gear-ratio-calculator.php
 * Description: Calculate gear ratios, final drive, and speed/RPM relationships
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gear Ratio Calculator - Transmission, Final Drive & Speed</title>
    <meta name="description" content="Advanced gear ratio calculator. Calculate transmission ratios, final drive, speed at RPM, and optimize gear selection for performance.">
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
        
        .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        
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
        
        .gear-visual { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; text-align: center; }
        .gear-diagram { display: flex; justify-content: center; align-items: center; gap: 20px; margin: 20px 0; }
        .gear { width: 80px; height: 80px; border-radius: 50%; border: 4px solid #667eea; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #667eea; background: white; position: relative; }
        .gear.large { width: 100px; height: 100px; }
        .gear-label { font-size: 0.75rem; color: #666; margin-top: 5px; }
        .gear-arrow { font-size: 2rem; color: #667eea; }
        
        .speed-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .speed-table th, .speed-table td { padding: 10px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .speed-table th { background: #f8f9fa; color: #667eea; font-weight: 600; }
        .speed-table tr:hover { background: #f8f9fa; }
        
        .info-box { background: #e8f2ff; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: repeat(2, 1fr); }
            .input-row { grid-template-columns: 1fr; }
            .gear-diagram { flex-direction: column; }
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
            <h1>⚙️ Gear Ratio Calculator</h1>
            <p>Calculate transmission ratios, final drive, and speed/RPM relationships</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Vehicle & Gear Parameters</h2>
                <form id="gearForm">
                    <div class="form-group">
                        <label for="gearRatio">Gear Ratio</label>
                        <input type="number" id="gearRatio" value="3.5" min="0.1" max="10" step="0.01" required>
                        <small>Transmission gear ratio (e.g., 1st gear = 3.5:1)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="finalDrive">Final Drive Ratio</label>
                        <input type="number" id="finalDrive" value="3.73" min="0.1" max="10" step="0.01" required>
                        <small>Differential ratio (rear axle ratio)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="tireSize">Tire Size</label>
                        <div class="input-row">
                            <input type="number" id="tireWidth" value="245" min="100" max="400" step="5" placeholder="Width">
                            <input type="number" id="tireAspect" value="45" min="25" max="90" step="5" placeholder="Aspect">
                        </div>
                        <div style="margin-top: 10px;">
                            <input type="number" id="tireWheel" value="17" min="13" max="24" step="1" placeholder="Wheel diameter">
                        </div>
                        <small>Format: 245/45R17 (Width/Aspect/Wheel)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="rpm">Engine RPM</label>
                        <input type="number" id="rpm" value="3000" min="500" max="10000" step="100" required>
                        <small>Engine revolutions per minute</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="speedUnit">Speed Unit</label>
                        <select id="speedUnit">
                            <option value="mph" selected>MPH</option>
                            <option value="kph">KPH (km/h)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Gear Ratios</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Gear Analysis</h2>
                
                <div class="result-card">
                    <h3>Overall Ratio</h3>
                    <div class="amount" id="overallRatio">13.1:1</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Speed at RPM</h4>
                        <div class="value" id="speedAtRPM">45</div>
                        <small id="speedUnit1">mph</small>
                    </div>
                    <div class="metric-card">
                        <h4>RPM at 60 mph</h4>
                        <div class="value" id="rpmAt60">4000</div>
                        <small>RPM</small>
                    </div>
                    <div class="metric-card">
                        <h4>Tire Diameter</h4>
                        <div class="value" id="tireDiameter">25.7</div>
                        <small>inches</small>
                    </div>
                </div>

                <div class="gear-visual">
                    <h3 style="color: #667eea; margin-bottom: 15px;">Gear Visualization</h3>
                    <div class="gear-diagram">
                        <div>
                            <div class="gear large">
                                <span id="inputTeeth">35</span>
                            </div>
                            <div class="gear-label">Input Gear</div>
                        </div>
                        <div class="gear-arrow">→</div>
                        <div>
                            <div class="gear">
                                <span id="outputTeeth">10</span>
                            </div>
                            <div class="gear-label">Output Gear</div>
                        </div>
                    </div>
                    <div style="margin-top: 15px; font-size: 0.9rem; color: #666;">
                        Ratio: <strong id="visualRatio" style="color: #667eea;">3.5:1</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Ratio Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Gear Ratio</span>
                        <strong id="gearRatioDisplay">3.50:1</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Final Drive Ratio</span>
                        <strong id="finalDriveDisplay">3.73:1</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Overall Ratio</span>
                        <strong id="overallRatioDisplay">13.06:1</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tire Circumference</span>
                        <strong id="tireCircumference">80.7 inches</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Revs per Mile</span>
                        <strong id="revsPerMile">789</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Speed at Different RPMs</h3>
                    <table class="speed-table">
                        <thead>
                            <tr>
                                <th>RPM</th>
                                <th>Speed</th>
                                <th>Wheel RPM</th>
                            </tr>
                        </thead>
                        <tbody id="speedTableBody">
                            <tr>
                                <td>1000 RPM</td>
                                <td>15 mph</td>
                                <td>77 RPM</td>
                            </tr>
                            <tr>
                                <td>2000 RPM</td>
                                <td>30 mph</td>
                                <td>153 RPM</td>
                            </tr>
                            <tr>
                                <td>3000 RPM</td>
                                <td>45 mph</td>
                                <td>230 RPM</td>
                            </tr>
                            <tr>
                                <td>4000 RPM</td>
                                <td>60 mph</td>
                                <td>306 RPM</td>
                            </tr>
                            <tr>
                                <td>5000 RPM</td>
                                <td>75 mph</td>
                                <td>383 RPM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="breakdown">
                    <h3>Tire Specifications</h3>
                    <div class="breakdown-item">
                        <span>Tire Size</span>
                        <strong id="tireSizeDisplay">245/45R17</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Section Width</span>
                        <strong id="sectionWidth">245 mm</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Sidewall Height</span>
                        <strong id="sidewallHeight">110 mm (4.3")</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tire Diameter</span>
                        <strong id="tireDiameterFull">25.7 inches</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tire Circumference</span>
                        <strong id="tireCircumferenceFull">80.7 inches</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>How to Calculate:</strong><br>
                    • Overall Ratio = Gear Ratio × Final Drive<br>
                    • Speed = (RPM × Tire Circumference) / (Overall Ratio × 336)<br>
                    • Lower ratios = higher top speed, less acceleration<br>
                    • Higher ratios = more acceleration, lower top speed
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⚙️ Gear Ratio Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Transmission and final drive calculations</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('gearForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateGearRatio();
        });

        function calculateGearRatio() {
            // Get inputs
            const gearRatio = parseFloat(document.getElementById('gearRatio').value);
            const finalDrive = parseFloat(document.getElementById('finalDrive').value);
            const tireWidth = parseFloat(document.getElementById('tireWidth').value);
            const tireAspect = parseFloat(document.getElementById('tireAspect').value);
            const tireWheel = parseFloat(document.getElementById('tireWheel').value);
            const rpm = parseFloat(document.getElementById('rpm').value);
            const speedUnit = document.getElementById('speedUnit').value;
            
            // Calculate overall ratio
            const overallRatio = gearRatio * finalDrive;
            
            // Calculate tire dimensions
            const sidewallHeight = (tireWidth * tireAspect / 100) / 25.4; // Convert mm to inches
            const tireDiameter = (tireWheel * 2) + (sidewallHeight * 2);
            const tireCircumference = tireDiameter * Math.PI;
            
            // Calculate revolutions per mile
            const revsPerMile = Math.round(63360 / tireCircumference); // 63360 inches in a mile
            
            // Calculate speed at current RPM
            // Formula: Speed (mph) = (RPM × Tire Circumference) / (Overall Ratio × 336)
            // 336 = inches per revolution × 60 minutes
            let speed = (rpm * tireCircumference) / (overallRatio * 336);
            
            // Convert to KPH if needed
            if (speedUnit === 'kph') {
                speed = speed * 1.60934;
            }
            
            // Calculate RPM at 60 mph (or 100 kph)
            const targetSpeed = speedUnit === 'mph' ? 60 : 100;
            const rpmAt60 = (targetSpeed * overallRatio * 336) / tireCircumference;
            
            // Calculate wheel RPM
            const wheelRPM = rpm / overallRatio;
            
            // Update gear visualization
            const inputTeeth = Math.round(gearRatio * 10);
            const outputTeeth = 10;
            document.getElementById('inputTeeth').textContent = inputTeeth;
            document.getElementById('outputTeeth').textContent = outputTeeth;
            document.getElementById('visualRatio').textContent = gearRatio.toFixed(2) + ':1';
            
            // Update main displays
            document.getElementById('overallRatio').textContent = overallRatio.toFixed(1) + ':1';
            document.getElementById('speedAtRPM').textContent = Math.round(speed);
            document.getElementById('speedUnit1').textContent = speedUnit;
            document.getElementById('rpmAt60').textContent = Math.round(rpmAt60);
            document.getElementById('tireDiameter').textContent = tireDiameter.toFixed(1);
            
            // Update breakdowns
            document.getElementById('gearRatioDisplay').textContent = gearRatio.toFixed(2) + ':1';
            document.getElementById('finalDriveDisplay').textContent = finalDrive.toFixed(2) + ':1';
            document.getElementById('overallRatioDisplay').textContent = overallRatio.toFixed(2) + ':1';
            document.getElementById('tireCircumference').textContent = tireCircumference.toFixed(1) + ' inches';
            document.getElementById('revsPerMile').textContent = revsPerMile.toLocaleString();
            
            // Update tire specs
            document.getElementById('tireSizeDisplay').textContent = `${tireWidth}/${tireAspect}R${tireWheel}`;
            document.getElementById('sectionWidth').textContent = tireWidth + ' mm';
            document.getElementById('sidewallHeight').textContent = (tireWidth * tireAspect / 100).toFixed(0) + ' mm (' + sidewallHeight.toFixed(1) + '")';
            document.getElementById('tireDiameterFull').textContent = tireDiameter.toFixed(1) + ' inches';
            document.getElementById('tireCircumferenceFull').textContent = tireCircumference.toFixed(1) + ' inches';
            
            // Update speed table
            const tableBody = document.getElementById('speedTableBody');
            tableBody.innerHTML = '';
            
            const rpmSteps = [1000, 2000, 3000, 4000, 5000, 6000, 7000];
            rpmSteps.forEach(rpmStep => {
                let speedAtStep = (rpmStep * tireCircumference) / (overallRatio * 336);
                if (speedUnit === 'kph') speedAtStep *= 1.60934;
                
                const wheelRPMAtStep = rpmStep / overallRatio;
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${rpmStep.toLocaleString()} RPM</td>
                    <td>${Math.round(speedAtStep)} ${speedUnit}</td>
                    <td>${Math.round(wheelRPMAtStep)} RPM</td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateGearRatio();
        });
    </script>
</body>
</html>