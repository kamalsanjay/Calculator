<?php
/**
 * Tire Size Calculator
 * File: automotive/tire-size-calculator.php
 * Description: Advanced tire size calculator with comparisons, speedometer calibration, and performance analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tire Size Calculator - Comparison, Speedometer & Performance Analysis</title>
    <meta name="description" content="Advanced tire size calculator. Compare tire sizes, calculate speedometer differences, and analyze performance impacts.">
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
        
        .tire-input-group { 
            display: grid; 
            grid-template-columns: 1fr 1fr 1fr; 
            gap: 10px; 
            align-items: end; 
        }
        .tire-input-separator { 
            text-align: center; 
            font-size: 1.5rem; 
            font-weight: bold; 
            color: #667eea; 
            padding-bottom: 12px; 
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
        
        .tire-visual { 
            display: flex; 
            justify-content: space-around; 
            align-items: center; 
            margin: 20px 0; 
            padding: 20px; 
            background: white; 
            border-radius: 12px; 
            border: 2px solid #e0e0e0; 
        }
        .tire-circle { 
            width: 120px; 
            height: 120px; 
            border: 8px solid #667eea; 
            border-radius: 50%; 
            position: relative; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            background: #f8f9fa; 
        }
        .tire-circle.new { 
            border-color: #4CAF50; 
        }
        .tire-circle.old { 
            border-color: #FF9800; 
        }
        .tire-size { 
            font-weight: bold; 
            color: #333; 
            text-align: center; 
        }
        .tire-diameter { 
            position: absolute; 
            bottom: -25px; 
            left: 0; 
            right: 0; 
            text-align: center; 
            font-size: 0.8rem; 
            color: #666; 
        }
        
        .speed-comparison { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 15px; 
            margin-top: 15px; 
        }
        .speed-card { 
            background: white; 
            padding: 15px; 
            border-radius: 8px; 
            border: 2px solid #e0e0e0; 
            text-align: center; 
            transition: all 0.3s; 
        }
        .speed-card:hover { 
            transform: translateY(-2px); 
            border-color: #667eea; 
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.2); 
        }
        .speed-card h4 { 
            color: #667eea; 
            margin-bottom: 10px; 
        }
        .speed-card .speed { 
            font-size: 1.5rem; 
            font-weight: bold; 
            color: #333; 
        }
        .speed-card .difference { 
            color: #666; 
            font-size: 0.9rem; 
        }
        
        .tire-preset { 
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
        
        .performance-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-top: 15px; 
        }
        .performance-card { 
            background: white; 
            padding: 15px; 
            border-radius: 8px; 
            border: 2px solid #e0e0e0; 
            text-align: center; 
        }
        .performance-card h4 { 
            color: #667eea; 
            margin-bottom: 8px; 
            font-size: 0.9rem; 
        }
        .performance-card .value { 
            font-size: 1.2rem; 
            font-weight: bold; 
            color: #333; 
        }
        .performance-card .change { 
            font-size: 0.8rem; 
            color: #666; 
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
            .tire-input-group { 
                grid-template-columns: 1fr; 
            }
            .input-group { 
                grid-template-columns: 1fr; 
            }
            .tire-preset { 
                grid-template-columns: repeat(2, 1fr); 
            }
            .tire-visual { 
                flex-direction: column; 
                gap: 30px; 
            }
            .speed-comparison, .performance-grid { 
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
            <h1>🚗 Tire Size Calculator</h1>
            <p>Compare tire sizes, calculate speedometer differences, and analyze performance impacts</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Tire Specifications</h2>
                <form id="tireForm">
                    
                    <div class="form-group">
                        <label>Original Tire Size</label>
                        <div class="tire-input-group">
                            <div>
                                <input type="number" id="oldWidth" value="225" min="100" max="400" step="5" required>
                                <small>Width (mm)</small>
                            </div>
                            <div class="tire-input-separator">/</div>
                            <div>
                                <input type="number" id="oldAspect" value="45" min="20" max="100" step="5" required>
                                <small>Aspect Ratio</small>
                            </div>
                            <div class="tire-input-separator">R</div>
                            <div>
                                <input type="number" id="oldRim" value="17" min="10" max="24" step="1" required>
                                <small>Rim (inches)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>New Tire Size</label>
                        <div class="tire-input-group">
                            <div>
                                <input type="number" id="newWidth" value="235" min="100" max="400" step="5" required>
                                <small>Width (mm)</small>
                            </div>
                            <div class="tire-input-separator">/</div>
                            <div>
                                <input type="number" id="newAspect" value="40" min="20" max="100" step="5" required>
                                <small>Aspect Ratio</small>
                            </div>
                            <div class="tire-input-separator">R</div>
                            <div>
                                <input type="number" id="newRim" value="18" min="10" max="24" step="1" required>
                                <small>Rim (inches)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Tire Presets</label>
                        <div class="tire-preset">
                            <div class="preset-btn" onclick="setPreset('Stock', '225', '45', '17', '225', '45', '17')">Stock</div>
                            <div class="preset-btn" onclick="setPreset('Plus1', '225', '45', '17', '235', '40', '18')">Plus 1"</div>
                            <div class="preset-btn" onclick="setPreset('Plus2', '225', '45', '17', '245', '35', '19')">Plus 2"</div>
                            <div class="preset-btn" onclick="setPreset('Wider', '225', '45', '17', '255', '40', '17')">Wider</div>
                            <div class="preset-btn" onclick="setPreset('Offroad', '225', '45', '17', '235', '75', '15')">Off-road</div>
                            <div class="preset-btn" onclick="setPreset('LowProfile', '225', '45', '17', '245', '30', '19')">Low Profile</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="speedInput">Speedometer Reading</label>
                        <div class="input-group">
                            <input type="number" id="speedInput" value="60" min="1" max="200" step="1" required>
                            <select id="speedUnit" style="padding: 12px;">
                                <option value="mph" selected>MPH</option>
                                <option value="kph">KPH</option>
                            </select>
                        </div>
                        <small>Speed shown on your dashboard</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="gearRatio">Final Drive Ratio</label>
                        <input type="number" id="gearRatio" value="3.73" min="2.0" max="6.0" step="0.01">
                        <small>Vehicle's final drive ratio (optional)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="revLimit">Engine RPM Limit</label>
                        <div class="input-group">
                            <input type="number" id="revLimit" value="6500" min="2000" max="10000" step="100" required>
                            <select style="padding: 12px;" disabled>
                                <option>RPM</option>
                            </select>
                        </div>
                        <small>Maximum engine RPM</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Tire Differences</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Tire Analysis</h2>
                
                <div class="result-card">
                    <h3>Diameter Difference</h3>
                    <div class="amount" id="diameterDifference">+1.2%</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Old Diameter</h4>
                        <div class="value" id="oldDiameter">25.0"</div>
                    </div>
                    <div class="metric-card">
                        <h4>New Diameter</h4>
                        <div class="value" id="newDiameter">25.3"</div>
                    </div>
                    <div class="metric-card">
                        <h4>Circumference</h4>
                        <div class="value" id="circumference">79.5"</div>
                    </div>
                </div>

                <div class="tire-visual">
                    <div class="tire-circle old">
                        <div class="tire-size" id="oldTireSize">225/45R17</div>
                        <div class="tire-diameter" id="oldTireDiameter">25.0"</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 2rem; color: #667eea; margin-bottom: 10px;">→</div>
                        <div style="color: #666; font-size: 0.9rem;">Difference</div>
                    </div>
                    <div class="tire-circle new">
                        <div class="tire-size" id="newTireSize">235/40R18</div>
                        <div class="tire-diameter" id="newTireDiameter">25.3"</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Speedometer Analysis</h3>
                    <div class="breakdown-item">
                        <span>Displayed Speed</span>
                        <strong id="displayedSpeed">60 MPH</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Actual Speed</span>
                        <strong id="actualSpeed">60.7 MPH</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Speed Difference</span>
                        <strong id="speedDifference">+0.7 MPH</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Odometer Error (per 100 miles)</span>
                        <strong id="odometerError">1.2 miles</strong>
                    </div>
                    
                    <div class="speed-comparison">
                        <div class="speed-card">
                            <h4>30 MPH Displayed</h4>
                            <div class="speed" id="speed30">30.4 MPH</div>
                            <div class="difference">Actual Speed</div>
                        </div>
                        <div class="speed-card">
                            <h4>60 MPH Displayed</h4>
                            <div class="speed" id="speed60">60.7 MPH</div>
                            <div class="difference">Actual Speed</div>
                        </div>
                        <div class="speed-card">
                            <h4>80 MPH Displayed</h4>
                            <div class="speed" id="speed80">80.9 MPH</div>
                            <div class="difference">Actual Speed</div>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Performance Impact</h3>
                    <div class="performance-grid">
                        <div class="performance-card">
                            <h4>Acceleration</h4>
                            <div class="value" id="accelerationImpact">-2.1%</div>
                            <div class="change">Slower off the line</div>
                        </div>
                        <div class="performance-card">
                            <h4>Top Speed</h4>
                            <div class="value" id="topSpeedImpact">+1.2%</div>
                            <div class="change">Higher theoretical max</div>
                        </div>
                        <div class="performance-card">
                            <h4>RPM at 60 MPH</h4>
                            <div class="value" id="rpmAt60">2,450 RPM</div>
                            <div class="change">-28 RPM</div>
                        </div>
                        <div class="performance-card">
                            <h4>Fuel Economy</h4>
                            <div class="value" id="fuelImpact">-1.5%</div>
                            <div class="change">Slight decrease</div>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Detailed Specifications</h3>
                    <div class="breakdown-item">
                        <span>Sidewall Height (Old)</span>
                        <strong id="oldSidewall">4.0"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Sidewall Height (New)</span>
                        <strong id="newSidewall">3.7"</span>
                    </div>
                    <div class="breakdown-item">
                        <span>Revolutions per Mile</span>
                        <strong id="revsPerMile">798 RPM</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Width Difference</span>
                        <strong id="widthDifference">+10 mm</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Clearance Needed</span>
                        <strong id="clearanceNeeded">+5 mm</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Gear Ratio Impact</h3>
                    <div class="breakdown-item">
                        <span>Effective Gear Ratio</span>
                        <strong id="effectiveRatio">3.69:1</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Equivalent Change</span>
                        <strong id="equivalentChange">-1.1%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Theoretical Top Speed</span>
                        <strong id="theoreticalTopSpeed">158 MPH</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Speed per 1000 RPM</span>
                        <strong id="speedPer1000RPM">24.5 MPH</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> Always ensure proper clearance when changing tire sizes. Consult your vehicle manufacturer's recommendations and local regulations. Larger tires may affect braking performance, handling, and vehicle stability.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🚗 Tire Size Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced tire comparison and performance analysis</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('tireForm');
        let currentPreset = '';

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateTireDifferences();
        });

        function setPreset(name, oldW, oldA, oldR, newW, newA, newR) {
            document.getElementById('oldWidth').value = oldW;
            document.getElementById('oldAspect').value = oldA;
            document.getElementById('oldRim').value = oldR;
            document.getElementById('newWidth').value = newW;
            document.getElementById('newAspect').value = newA;
            document.getElementById('newRim').value = newR;
            currentPreset = name;
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateTireDifferences();
        }

        function calculateTireDifferences() {
            // Get inputs
            const oldWidth = parseFloat(document.getElementById('oldWidth').value);
            const oldAspect = parseFloat(document.getElementById('oldAspect').value);
            const oldRim = parseFloat(document.getElementById('oldRim').value);
            const newWidth = parseFloat(document.getElementById('newWidth').value);
            const newAspect = parseFloat(document.getElementById('newAspect').value);
            const newRim = parseFloat(document.getElementById('newRim').value);
            const speedInput = parseFloat(document.getElementById('speedInput').value);
            const speedUnit = document.getElementById('speedUnit').value;
            const gearRatio = parseFloat(document.getElementById('gearRatio').value) || 3.73;
            const revLimit = parseFloat(document.getElementById('revLimit').value);
            
            // Calculate tire diameters
            const oldSidewallInches = (oldWidth * oldAspect / 100) / 25.4;
            const newSidewallInches = (newWidth * newAspect / 100) / 25.4;
            
            const oldDiameter = oldRim + (2 * oldSidewallInches);
            const newDiameter = newRim + (2 * newSidewallInches);
            
            // Calculate circumference and revolutions per mile
            const oldCircumference = oldDiameter * Math.PI;
            const newCircumference = newDiameter * Math.PI;
            
            const oldRevsPerMile = 63360 / oldCircumference; // 63360 inches in a mile
            const newRevsPerMile = 63360 / newCircumference;
            
            // Calculate differences
            const diameterDifference = ((newDiameter - oldDiameter) / oldDiameter * 100);
            const widthDifference = newWidth - oldWidth;
            
            // Calculate speed differences
            const speedRatio = newDiameter / oldDiameter;
            let actualSpeed = speedInput * speedRatio;
            
            // Convert to KPH if needed
            if (speedUnit === 'kph') {
                actualSpeed = actualSpeed * 1.60934; // Convert to MPH for calculations
                actualSpeed = actualSpeed / 1.60934; // Convert back to KPH
            }
            
            const speedDifference = actualSpeed - speedInput;
            
            // Calculate odometer error
            const odometerError = (speedRatio - 1) * 100;
            
            // Calculate performance impacts
            const accelerationImpact = -((newDiameter / oldDiameter - 1) * 100).toFixed(1);
            const topSpeedImpact = ((newDiameter / oldDiameter - 1) * 100).toFixed(1);
            
            // Calculate RPM at speed
            const tireCircumferenceMiles = newCircumference / 63360; // Convert to miles
            const rpmAt60 = (60 / (tireCircumferenceMiles * gearRatio * 60)) * 1000; // Simplified calculation
            
            // Calculate fuel economy impact (rough estimate)
            const fuelImpact = -Math.abs(diameterDifference * 0.8).toFixed(1);
            
            // Calculate gear ratio impacts
            const effectiveRatio = gearRatio / speedRatio;
            const equivalentChange = ((effectiveRatio - gearRatio) / gearRatio * 100).toFixed(1);
            
            // Calculate theoretical top speed
            const theoreticalTopSpeed = (revLimit / rpmAt60 * 60).toFixed(0);
            const speedPer1000RPM = (1000 / rpmAt60 * 60).toFixed(1);
            
            // Calculate clearance needed
            const clearanceNeeded = Math.max(0, (newWidth - oldWidth) / 2);
            
            // Update UI
            document.getElementById('diameterDifference').textContent = (diameterDifference > 0 ? '+' : '') + diameterDifference.toFixed(1) + '%';
            document.getElementById('oldDiameter').textContent = oldDiameter.toFixed(1) + '"';
            document.getElementById('newDiameter').textContent = newDiameter.toFixed(1) + '"';
            document.getElementById('circumference').textContent = newCircumference.toFixed(1) + '"';
            
            document.getElementById('oldTireSize').textContent = `${oldWidth}/${oldAspect}R${oldRim}`;
            document.getElementById('newTireSize').textContent = `${newWidth}/${newAspect}R${newRim}`;
            document.getElementById('oldTireDiameter').textContent = oldDiameter.toFixed(1) + '"';
            document.getElementById('newTireDiameter').textContent = newDiameter.toFixed(1) + '"';
            
            document.getElementById('displayedSpeed').textContent = speedInput + ' ' + speedUnit.toUpperCase();
            document.getElementById('actualSpeed').textContent = actualSpeed.toFixed(1) + ' ' + speedUnit.toUpperCase();
            document.getElementById('speedDifference').textContent = (speedDifference > 0 ? '+' : '') + speedDifference.toFixed(1) + ' ' + speedUnit.toUpperCase();
            document.getElementById('odometerError').textContent = odometerError.toFixed(1) + ' miles';
            
            document.getElementById('speed30').textContent = (30 * speedRatio).toFixed(1) + ' ' + speedUnit.toUpperCase();
            document.getElementById('speed60').textContent = (60 * speedRatio).toFixed(1) + ' ' + speedUnit.toUpperCase();
            document.getElementById('speed80').textContent = (80 * speedRatio).toFixed(1) + ' ' + speedUnit.toUpperCase();
            
            document.getElementById('accelerationImpact').textContent = accelerationImpact + '%';
            document.getElementById('topSpeedImpact').textContent = '+' + topSpeedImpact + '%';
            document.getElementById('rpmAt60').textContent = Math.round(rpmAt60) + ' RPM';
            document.getElementById('fuelImpact').textContent = fuelImpact + '%';
            
            document.getElementById('oldSidewall').textContent = oldSidewallInches.toFixed(1) + '"';
            document.getElementById('newSidewall').textContent = newSidewallInches.toFixed(1) + '"';
            document.getElementById('revsPerMile').textContent = Math.round(newRevsPerMile) + ' RPM';
            document.getElementById('widthDifference').textContent = (widthDifference > 0 ? '+' : '') + widthDifference + ' mm';
            document.getElementById('clearanceNeeded').textContent = '+' + clearanceNeeded.toFixed(0) + ' mm';
            
            document.getElementById('effectiveRatio').textContent = effectiveRatio.toFixed(2) + ':1';
            document.getElementById('equivalentChange').textContent = equivalentChange + '%';
            document.getElementById('theoreticalTopSpeed').textContent = theoreticalTopSpeed + ' MPH';
            document.getElementById('speedPer1000RPM').textContent = speedPer1000RPM + ' MPH';
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateTireDifferences();
        });
    </script>
</body>
</html>
