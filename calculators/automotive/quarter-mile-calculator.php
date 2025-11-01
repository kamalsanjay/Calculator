<?php
/**
 * Quarter Mile Calculator
 * File: automotive/quarter-mile-calculator.php
 * Description: Advanced calculator for quarter mile performance, drag racing analysis, and vehicle acceleration
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quarter Mile Calculator - Drag Racing Performance Analysis</title>
    <meta name="description" content="Advanced quarter mile calculator. Calculate ET, trap speed, and analyze vehicle acceleration performance.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #e74c3c; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #e74c3c; box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(231, 76, 60, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3); position: relative; overflow: hidden; }
        .result-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 0.8; } }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; position: relative; z-index: 1; }
        .result-card .amount { font-size: 3rem; font-weight: bold; position: relative; z-index: 1; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #e74c3c; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #e74c3c; font-size: 1.8rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #e74c3c; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .progress-bar { background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #e74c3c 0%, #c0392b 100%); width: 0%; transition: width 1s ease-out; }
        
        .info-box { background: #ffeaea; border-left: 4px solid #e74c3c; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #e74c3c; }
        
        .vehicle-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 8px; margin-top: 10px; }
        .vehicle-btn { padding: 10px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .vehicle-btn:hover { background: #e74c3c; color: white; border-color: #e74c3c; }
        .vehicle-btn.active { background: #e74c3c; color: white; border-color: #e74c3c; }
        
        .track-visual { display: flex; flex-direction: column; align-items: center; margin: 20px 0; }
        .track { width: 100%; height: 120px; background: #2c3e50; border-radius: 8px; position: relative; overflow: hidden; margin-bottom: 15px; }
        .track-lane { position: absolute; top: 20px; width: 100%; height: 80px; border-top: 2px dashed #e74c3c; border-bottom: 2px dashed #e74c3c; }
        .track-marker { position: absolute; height: 100%; width: 2px; background: #e74c3c; opacity: 0.5; }
        .track-marker-60 { left: 20%; }
        .track-marker-330 { left: 40%; }
        .track-marker-660 { left: 60%; }
        .track-marker-1000 { left: 80%; }
        .track-marker-finish { left: 95%; background: #fff; width: 4px; }
        .track-marker-label { position: absolute; top: -20px; color: white; font-size: 0.8rem; transform: translateX(-50%); }
        .car { position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 60px; height: 30px; background: #e74c3c; border-radius: 6px; transition: left 3s ease-out; }
        .car::before { content: ''; position: absolute; top: 5px; left: 5px; right: 5px; bottom: 5px; background: #c0392b; border-radius: 3px; }
        .performance-level { font-size: 1.2rem; font-weight: bold; color: #e74c3c; }
        
        .acceleration-chart { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .chart-container { height: 250px; position: relative; margin: 20px 0; }
        .chart-grid { position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: grid; grid-template-columns: repeat(5, 1fr); grid-template-rows: repeat(5, 1fr); }
        .grid-line { border-right: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0; }
        .chart-line { position: absolute; bottom: 0; left: 0; height: 3px; background: #e74c3c; transition: all 2s ease-out; }
        .chart-point { position: absolute; width: 8px; height: 8px; background: #e74c3c; border-radius: 50%; transform: translate(-50%, 50%); }
        
        .performance-comparison { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
        .comparison-card { background: white; padding: 15px; border-radius: 8px; border: 2px solid #e0e0e0; text-align: center; }
        .comparison-card h4 { color: #666; margin-bottom: 10px; font-size: 0.9rem; }
        .comparison-value { font-size: 1.5rem; font-weight: bold; color: #e74c3c; }
        
        .reaction-analysis { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .reaction-item { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0; }
        .reaction-item:last-child { border-bottom: none; margin-bottom: 0; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
            .performance-comparison { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .vehicle-preset { grid-template-columns: repeat(2, 1fr); }
            .chart-container { height: 200px; }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
            .chart-container { height: 150px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏁 Quarter Mile Calculator</h1>
            <p>Drag Racing Performance Analysis & Acceleration Simulation</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Vehicle Performance</h2>
                <form id="quarterMileForm">
                    <div class="form-group">
                        <label for="horsepower">Engine Horsepower</label>
                        <input type="number" id="horsepower" value="400" min="50" max="2000" step="10" required>
                        <small>Peak horsepower at the crankshaft</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="vehicleWeight">Vehicle Weight</label>
                        <div class="input-group">
                            <input type="number" id="vehicleWeight" value="3500" min="1000" max="10000" step="100" required>
                            <select id="weightUnit" style="padding: 12px;">
                                <option value="lbs" selected>lbs</option>
                                <option value="kg">kg</option>
                            </select>
                        </div>
                        <small>Total weight with driver and fuel</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="driveType">Drive Type</label>
                        <select id="driveType" style="padding: 12px;">
                            <option value="rwd">Rear Wheel Drive</option>
                            <option value="fwd">Front Wheel Drive</option>
                            <option value="awd" selected>All Wheel Drive</option>
                        </select>
                        <small>Vehicle drivetrain configuration</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="transmission">Transmission Type</label>
                        <select id="transmission" style="padding: 12px;">
                            <option value="manual">Manual</option>
                            <option value="automatic" selected>Automatic</option>
                            <option value="dct">Dual-Clutch</option>
                            <option value="cvt">CVT</option>
                        </select>
                        <small>Gearbox and shift characteristics</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Vehicle Presets</label>
                        <div class="vehicle-preset">
                            <div class="vehicle-btn" onclick="setVehiclePreset('economy')">Economy Car</div>
                            <div class="vehicle-btn" onclick="setVehiclePreset('sports')">Sports Car</div>
                            <div class="vehicle-btn" onclick="setVehiclePreset('muscle')">Muscle Car</div>
                            <div class="vehicle-btn" onclick="setVehiclePreset('supercar')">Supercar</div>
                            <div class="vehicle-btn" onclick="setVehiclePreset('drag')">Drag Car</div>
                            <div class="vehicle-btn" onclick="setVehiclePreset('electric')">Electric Vehicle</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="traction">Traction Conditions</label>
                        <select id="traction" style="padding: 12px;">
                            <option value="poor">Poor (Street Tires)</option>
                            <option value="average" selected>Average (Performance Tires)</option>
                            <option value="good">Good (Drag Radials)</option>
                            <option value="excellent">Excellent (Slick Tires)</option>
                        </select>
                        <small>Tire grip and track surface conditions</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="reactionTime">Reaction Time (seconds)</label>
                        <input type="number" id="reactionTime" value="0.5" min="0.1" max="2.0" step="0.05">
                        <small>Driver reaction time at the start</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="altitude">Altitude (feet above sea level)</label>
                        <input type="number" id="altitude" value="500" min="0" max="10000" step="100">
                        <small>Elevation affects engine performance</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="temperature">Air Temperature (°F)</label>
                        <input type="number" id="temperature" value="70" min="-20" max="120" step="5">
                        <small>Ambient air temperature</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="humidity">Humidity (%)</label>
                        <input type="number" id="humidity" value="50" min="0" max="100" step="5">
                        <small>Relative humidity affects air density</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Quarter Mile</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Performance Analysis</h2>
                
                <div class="result-card">
                    <h3>Quarter Mile Time</h3>
                    <div class="amount" id="quarterMileTime">12.34s</div>
                </div>

                <div class="track-visual">
                    <div class="track">
                        <div class="track-lane"></div>
                        <div class="track-marker track-marker-60">
                            <div class="track-marker-label">60ft</div>
                        </div>
                        <div class="track-marker track-marker-330">
                            <div class="track-marker-label">330ft</div>
                        </div>
                        <div class="track-marker track-marker-660">
                            <div class="track-marker-label">1/8mi</div>
                        </div>
                        <div class="track-marker track-marker-1000">
                            <div class="track-marker-label">1000ft</div>
                        </div>
                        <div class="track-marker track-marker-finish">
                            <div class="track-marker-label">1320ft</div>
                        </div>
                        <div class="car" id="raceCar"></div>
                    </div>
                    <div class="performance-level" id="performanceLevel">Sports Car Performance</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Trap Speed</h4>
                        <div class="value" id="trapSpeed">112.5 mph</div>
                    </div>
                    <div class="metric-card">
                        <h4>0-60 mph Time</h4>
                        <div class="value" id="zeroToSixty">4.2s</div>
                    </div>
                    <div class="metric-card">
                        <h4>Power-to-Weight</h4>
                        <div class="value" id="powerToWeight">8.75 lbs/hp</div>
                    </div>
                </div>

                <div class="acceleration-chart">
                    <h3>Acceleration Curve</h3>
                    <div class="chart-container">
                        <div class="chart-grid">
                            <div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div>
                            <div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div>
                            <div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div>
                            <div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div>
                            <div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div>
                        </div>
                        <div class="chart-line" id="accelerationLine"></div>
                        <!-- Chart points will be generated dynamically -->
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Performance Breakdown</h3>
                    <div class="breakdown-item">
                        <span>60-foot Time</span>
                        <strong id="sixtyFoot">1.85s</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>330-foot Time</span>
                        <strong id="threeThirty">5.12s</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>1/8 Mile Time</span>
                        <strong id="eighthMile">7.89s</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>1/8 Mile Speed</span>
                        <strong id="eighthSpeed">89.3 mph</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>1000-foot Time</span>
                        <strong id="thousandFoot">10.28s</strong>
                    </div>
                </div>

                <div class="performance-comparison">
                    <div class="comparison-card">
                        <h4>Theoretical Best</h4>
                        <div class="comparison-value" id="theoreticalBest">11.95s</div>
                        <small>Perfect conditions & launch</small>
                    </div>
                    <div class="comparison-card">
                        <h4>Realistic Average</h4>
                        <div class="comparison-value" id="realisticAverage">12.45s</div>
                        <small>Typical street performance</small>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Performance Factors</h3>
                    <div class="breakdown-item">
                        <span>Traction Impact</span>
                        <strong id="tractionImpact">-0.15s</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Drive Type Bonus</span>
                        <strong id="driveTypeBonus">-0.08s</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Transmission Efficiency</span>
                        <strong id="transmissionImpact">-0.05s</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Altitude Penalty</span>
                        <strong id="altitudeImpact">+0.03s</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weather Impact</span>
                        <strong id="weatherImpact">+0.02s</strong>
                    </div>
                </div>

                <div class="reaction-analysis">
                    <h3>Reaction & ET Analysis</h3>
                    <div class="reaction-item">
                        <span>Reaction Time</span>
                        <strong id="reactionDisplay">0.500s</strong>
                    </div>
                    <div class="reaction-item">
                        <span>Total Elapsed Time (ET)</span>
                        <strong id="totalET">12.840s</strong>
                    </div>
                    <div class="reaction-item">
                        <span>60-ft Acceleration</span>
                        <strong id="sixtyAcceleration">0.82 G</strong>
                    </div>
                    <div class="reaction-item">
                        <span>Peak Acceleration</span>
                        <strong id="peakAcceleration">1.12 G</strong>
                    </div>
                    <div class="reaction-item">
                        <span>Average Acceleration</span>
                        <strong id="averageAcceleration">0.68 G</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Performance Potential</h3>
                    <div class="breakdown-item" style="flex-direction: column; align-items: flex-start;">
                        <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 5px;">
                            <span>Vehicle Performance Score</span>
                            <strong id="performanceScore">82%</strong>
                        </div>
                        <div class="progress-bar" style="width: 100%;">
                            <div class="progress-fill" id="performanceBar"></div>
                        </div>
                        <small style="margin-top: 5px;">Compared to optimal setup for your power-to-weight ratio</small>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Drag Racing Tip:</strong> The 60-foot time is the best indicator of launch quality. Improving traction and reaction time has the biggest impact on overall ET. AWD vehicles typically have better 60-foot times but may be traction-limited at higher speeds.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🏁 Quarter Mile Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced drag racing performance analysis and simulation</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('quarterMileForm');
        let raceAnimation;

        // Vehicle presets with performance data
        const vehiclePresets = {
            'economy': { hp: 150, weight: 3000, drive: 'fwd', transmission: 'automatic' },
            'sports': { hp: 400, weight: 3500, drive: 'awd', transmission: 'automatic' },
            'muscle': { hp: 450, weight: 3800, drive: 'rwd', transmission: 'manual' },
            'supercar': { hp: 650, weight: 3200, drive: 'awd', transmission: 'dct' },
            'drag': { hp: 800, weight: 3000, drive: 'rwd', transmission: 'automatic' },
            'electric': { hp: 500, weight: 4500, drive: 'awd', transmission: 'automatic' }
        };

        // Drive type multipliers
        const driveTypes = {
            'rwd': { launch: 0.95, name: 'Rear Wheel Drive' },
            'fwd': { launch: 0.90, name: 'Front Wheel Drive' },
            'awd': { launch: 1.05, name: 'All Wheel Drive' }
        };

        // Transmission efficiency multipliers
        const transmissions = {
            'manual': { efficiency: 0.98, shift: 0.95, name: 'Manual' },
            'automatic': { efficiency: 1.00, shift: 1.00, name: 'Automatic' },
            'dct': { efficiency: 1.02, shift: 1.05, name: 'Dual-Clutch' },
            'cvt': { efficiency: 0.96, shift: 0.98, name: 'CVT' }
        };

        // Traction condition multipliers
        const tractionConditions = {
            'poor': { multiplier: 0.85, name: 'Poor (Street Tires)' },
            'average': { multiplier: 1.00, name: 'Average (Performance Tires)' },
            'good': { multiplier: 1.10, name: 'Good (Drag Radials)' },
            'excellent': { multiplier: 1.20, name: 'Excellent (Slick Tires)' }
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateQuarterMile();
        });

        function setVehiclePreset(preset) {
            const config = vehiclePresets[preset];
            document.getElementById('horsepower').value = config.hp;
            document.getElementById('vehicleWeight').value = config.weight;
            document.getElementById('driveType').value = config.drive;
            document.getElementById('transmission').value = config.transmission;
            
            // Visual feedback
            document.querySelectorAll('.vehicle-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateQuarterMile();
        }

        function calculateQuarterMile() {
            // Get inputs
            const horsepower = parseFloat(document.getElementById('horsepower').value);
            const vehicleWeight = parseFloat(document.getElementById('vehicleWeight').value);
            const weightUnit = document.getElementById('weightUnit').value;
            const driveType = document.getElementById('driveType').value;
            const transmission = document.getElementById('transmission').value;
            const traction = document.getElementById('traction').value;
            const reactionTime = parseFloat(document.getElementById('reactionTime').value);
            const altitude = parseFloat(document.getElementById('altitude').value);
            const temperature = parseFloat(document.getElementById('temperature').value);
            const humidity = parseFloat(document.getElementById('humidity').value);

            // Convert weight to pounds if needed
            let weightLbs = vehicleWeight;
            if (weightUnit === 'kg') {
                weightLbs = vehicleWeight * 2.20462;
            }

            // Calculate power-to-weight ratio
            const powerToWeight = weightLbs / horsepower;

            // Base quarter mile time calculation using power-to-weight ratio
            let baseET = 14.0; // Base for average car
            
            // More accurate calculation based on power-to-weight
            if (powerToWeight <= 6) {
                baseET = 10.5 + (powerToWeight - 4) * 0.5;
            } else if (powerToWeight <= 8) {
                baseET = 11.5 + (powerToWeight - 6) * 0.75;
            } else if (powerToWeight <= 10) {
                baseET = 13.0 + (powerToWeight - 8) * 0.8;
            } else if (powerToWeight <= 12) {
                baseET = 14.6 + (powerToWeight - 10) * 0.9;
            } else {
                baseET = 16.4 + (powerToWeight - 12) * 1.1;
            }

            // Apply drive type multiplier
            const driveMultiplier = driveTypes[driveType].launch;
            baseET *= driveMultiplier;

            // Apply transmission efficiency
            const transEfficiency = transmissions[transmission].efficiency;
            const shiftEfficiency = transmissions[transmission].shift;
            baseET *= transEfficiency * shiftEfficiency;

            // Apply traction multiplier
            const tractionMultiplier = tractionConditions[traction].multiplier;
            baseET /= tractionMultiplier;

            // Apply altitude correction (1% loss per 1000ft above sea level)
            const altitudeCorrection = 1 + (altitude / 1000) * 0.01;
            baseET *= altitudeCorrection;

            // Apply weather correction (density altitude)
            const weatherCorrection = calculateWeatherCorrection(temperature, humidity, altitude);
            baseET *= weatherCorrection;

            // Calculate trap speed (typically higher for lighter, more powerful cars)
            let trapSpeed = 90 + (horsepower / weightLbs) * 8000;
            trapSpeed *= (1.05 - (baseET - 11) * 0.02); // Adjust based on ET

            // Calculate 0-60 time
            const zeroToSixty = baseET * 0.34; // Rough correlation

            // Calculate incremental times
            const sixtyFoot = baseET * 0.15;
            const threeThirty = baseET * 0.415;
            const eighthMile = baseET * 0.64;
            const eighthSpeed = trapSpeed * 0.795;
            const thousandFoot = baseET * 0.83;

            // Calculate performance factors for display
            const tractionImpact = (baseET * (1 - tractionMultiplier)).toFixed(2);
            const driveTypeBonus = (baseET * (1 - driveMultiplier)).toFixed(2);
            const transmissionImpact = (baseET * (1 - (transEfficiency * shiftEfficiency))).toFixed(2);
            const altitudeImpact = (baseET * (altitudeCorrection - 1)).toFixed(2);
            const weatherImpact = (baseET * (weatherCorrection - 1)).toFixed(2);

            // Calculate theoretical best (perfect conditions)
            const theoreticalBest = baseET * 0.97;

            // Calculate realistic average
            const realisticAverage = baseET * 1.02;

            // Calculate acceleration metrics
            const sixtyAcceleration = (calculateAcceleration(0, 88, sixtyFoot)).toFixed(2);
            const peakAcceleration = (sixtyAcceleration * 1.35).toFixed(2);
            const averageAcceleration = (trapSpeed / (baseET * 0.22)).toFixed(2); // Rough average G calculation

            // Calculate total elapsed time with reaction
            const totalET = baseET + reactionTime;

            // Calculate performance score (0-100%)
            const performanceScore = Math.min(100, Math.max(0, (14 - baseET) / (14 - 8) * 100));

            // Update UI
            document.getElementById('quarterMileTime').textContent = baseET.toFixed(2) + 's';
            document.getElementById('trapSpeed').textContent = trapSpeed.toFixed(1) + ' mph';
            document.getElementById('zeroToSixty').textContent = zeroToSixty.toFixed(1) + 's';
            document.getElementById('powerToWeight').textContent = (weightLbs / horsepower).toFixed(2) + ' lbs/hp';

            document.getElementById('sixtyFoot').textContent = sixtyFoot.toFixed(2) + 's';
            document.getElementById('threeThirty').textContent = threeThirty.toFixed(2) + 's';
            document.getElementById('eighthMile').textContent = eighthMile.toFixed(2) + 's';
            document.getElementById('eighthSpeed').textContent = eighthSpeed.toFixed(1) + ' mph';
            document.getElementById('thousandFoot').textContent = thousandFoot.toFixed(2) + 's';

            document.getElementById('theoreticalBest').textContent = theoreticalBest.toFixed(2) + 's';
            document.getElementById('realisticAverage').textContent = realisticAverage.toFixed(2) + 's';

            document.getElementById('tractionImpact').textContent = tractionImpact + 's';
            document.getElementById('driveTypeBonus').textContent = driveTypeBonus + 's';
            document.getElementById('transmissionImpact').textContent = transmissionImpact + 's';
            document.getElementById('altitudeImpact').textContent = '+' + altitudeImpact + 's';
            document.getElementById('weatherImpact').textContent = '+' + weatherImpact + 's';

            document.getElementById('reactionDisplay').textContent = reactionTime.toFixed(3) + 's';
            document.getElementById('totalET').textContent = totalET.toFixed(3) + 's';
            document.getElementById('sixtyAcceleration').textContent = sixtyAcceleration + ' G';
            document.getElementById('peakAcceleration').textContent = peakAcceleration + ' G';
            document.getElementById('averageAcceleration').textContent = averageAcceleration + ' G';

            // Update performance level text
            updatePerformanceLevel(baseET);

            // Update performance score
            updatePerformanceScore(performanceScore);

            // Animate race car
            animateRaceCar(baseET);

            // Generate acceleration chart
            generateAccelerationChart(baseET, trapSpeed);
        }

        function calculateWeatherCorrection(temperature, humidity, altitude) {
            // Simplified density altitude calculation
            const pressureAltitude = altitude + (temperature - 59) * 120; // Rough adjustment
            const densityAltitude = pressureAltitude + (humidity / 100) * 500; // Humidity effect
            
            // Performance loss: ~1% per 1000ft density altitude above sea level
            const correction = 1 + (densityAltitude / 1000) * 0.01;
            return correction;
        }

        function calculateAcceleration(initialSpeed, finalSpeed, time) {
            // Calculate acceleration in G's
            const speedDiff = (finalSpeed - initialSpeed) * 0.44704; // Convert to m/s
            const acceleration = speedDiff / time;
            return acceleration / 9.81; // Convert to G's
        }

        function updatePerformanceLevel(et) {
            const levelElement = document.getElementById('performanceLevel');
            let level = '';
            
            if (et <= 10.0) level = 'Professional Drag Car';
            else if (et <= 11.0) level = 'Supercar Territory';
            else if (et <= 12.0) level = 'High-Performance Sports';
            else if (et <= 13.0) level = 'Sports Car Performance';
            else if (et <= 14.0) level = 'Performance Sedan';
            else if (et <= 15.0) level = 'Average Sports Car';
            else if (et <= 16.0) level = 'Economy Performance';
            else level = 'Standard Passenger Car';
            
            levelElement.textContent = level;
            
            // Change color based on performance
            if (et <= 11.0) {
                levelElement.style.color = '#e74c3c';
            } else if (et <= 13.0) {
                levelElement.style.color = '#e67e22';
            } else if (et <= 15.0) {
                levelElement.style.color = '#f1c40f';
            } else {
                levelElement.style.color = '#27ae60';
            }
        }

        function updatePerformanceScore(score) {
            const performanceBar = document.getElementById('performanceBar');
            const performanceText = document.getElementById('performanceScore');
            
            performanceBar.style.width = '0%';
            performanceText.textContent = '0%';
            
            setTimeout(() => {
                performanceBar.style.width = score + '%';
                performanceText.textContent = Math.round(score) + '%';
                
                // Change color based on score
                if (score >= 80) {
                    performanceBar.style.background = 'linear-gradient(90deg, #27ae60 0%, #2ecc71 100%)';
                } else if (score >= 60) {
                    performanceBar.style.background = 'linear-gradient(90deg, #f39c12 0%, #f1c40f 100%)';
                } else {
                    performanceBar.style.background = 'linear-gradient(90deg, #e74c3c 0%, #c0392b 100%)';
                }
            }, 100);
        }

        function animateRaceCar(et) {
            const raceCar = document.getElementById('raceCar');
            const animationTime = et * 1000; // Convert to milliseconds
            
            // Reset position
            raceCar.style.left = '0%';
            raceCar.style.transition = 'left ' + (animationTime / 1000) + 's cubic-bezier(0.2, 0.8, 0.4, 1)';
            
            // Start animation
            setTimeout(() => {
                raceCar.style.left = '95%';
            }, 100);
        }

        function generateAccelerationChart(et, trapSpeed) {
            const chartContainer = document.querySelector('.chart-container');
            const accelerationLine = document.getElementById('accelerationLine');
            
            // Clear existing points
            document.querySelectorAll('.chart-point').forEach(point => point.remove());
            
            // Generate acceleration curve points
            const points = [
                { time: 0, speed: 0 },
                { time: et * 0.15, speed: 45 },
                { time: et * 0.4, speed: 75 },
                { time: et * 0.64, speed: trapSpeed * 0.8 },
                { time: et, speed: trapSpeed }
            ];
            
            // Calculate maximum values for scaling
            const maxTime = et;
            const maxSpeed = trapSpeed;
            
            // Create points and line
            let linePath = '';
            points.forEach((point, index) => {
                const x = (point.time / maxTime) * 100;
                const y = (point.speed / maxSpeed) * 100;
                
                // Add point
                const pointElement = document.createElement('div');
                pointElement.className = 'chart-point';
                pointElement.style.left = x + '%';
                pointElement.style.bottom = y + '%';
                chartContainer.appendChild(pointElement);
                
                // Build line path
                if (index === 0) {
                    linePath = `M 0,100 L ${x},${100 - y}`;
                } else {
                    linePath += ` L ${x},${100 - y}`;
                }
            });
            
            // Animate line (simplified with height)
            accelerationLine.style.width = '0%';
            setTimeout(() => {
                accelerationLine.style.width = '100%';
            }, 100);
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateQuarterMile();
        });
    </script>
</body>
</html>
