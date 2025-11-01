<?php
/**
 * 0-60 Calculator
 * File: automotive/0-60-calculator.php
 * Description: Calculate 0-60 mph acceleration time based on horsepower, weight, and drivetrain
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>0-60 Calculator - Vehicle Acceleration Time & Performance</title>
    <meta name="description" content="Advanced 0-60 mph calculator. Calculate acceleration time based on horsepower, weight, drivetrain, and compare with real-world performance data.">
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
        
        .performance-gauge { width: 100%; height: 30px; background: linear-gradient(90deg, #00ff00 0%, #ffff00 25%, #ff9900 50%, #ff0000 100%); border-radius: 15px; position: relative; margin: 20px 0; }
        .gauge-marker { position: absolute; top: -5px; width: 4px; height: 40px; background: #333; transition: left 0.3s; }
        .gauge-labels { display: flex; justify-content: space-between; font-size: 0.75rem; color: #666; margin-top: 5px; }
        
        .comparison-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .comparison-table th, .comparison-table td { padding: 10px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .comparison-table th { background: #f8f9fa; color: #667eea; font-weight: 600; }
        .comparison-table tr:hover { background: #f8f9fa; }
        
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
            .input-group { grid-template-columns: 1fr; }
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
            <h1>🏎️ 0-60 Calculator</h1>
            <p>Calculate vehicle acceleration time based on horsepower and weight</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Vehicle Specifications</h2>
                <form id="accelForm">
                    <div class="form-group">
                        <label for="horsepower">Horsepower (HP)</label>
                        <input type="number" id="horsepower" value="300" min="50" max="2000" step="1" required>
                        <small>Engine power output</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="weight">Vehicle Weight</label>
                        <div class="input-group">
                            <input type="number" id="weight" value="3500" min="1000" max="10000" step="10" required>
                            <select id="weightUnit" style="padding: 12px;">
                                <option value="lbs" selected>lbs</option>
                                <option value="kg">kg</option>
                            </select>
                        </div>
                        <small>Curb weight including driver</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="drivetrain">Drivetrain</label>
                        <select id="drivetrain">
                            <option value="rwd">RWD (Rear-Wheel Drive)</option>
                            <option value="fwd">FWD (Front-Wheel Drive)</option>
                            <option value="awd" selected>AWD (All-Wheel Drive)</option>
                            <option value="4wd">4WD (Four-Wheel Drive)</option>
                        </select>
                        <small>Power delivery system</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="transmission">Transmission</label>
                        <select id="transmission">
                            <option value="manual">Manual</option>
                            <option value="automatic" selected>Automatic</option>
                            <option value="dct">DCT (Dual-Clutch)</option>
                            <option value="cvt">CVT</option>
                        </select>
                        <small>Transmission type</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="tireType">Tire Type</label>
                        <select id="tireType">
                            <option value="street" selected>Street Tires</option>
                            <option value="performance">Performance Tires</option>
                            <option value="race">Race/Slick Tires</option>
                            <option value="allseason">All-Season</option>
                        </select>
                        <small>Tire grip level</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="launchControl">Launch Control / Traction</label>
                        <select id="launchControl">
                            <option value="none">None</option>
                            <option value="basic" selected>Basic Traction Control</option>
                            <option value="advanced">Advanced Launch Control</option>
                        </select>
                        <small>Electronic launch assistance</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate 0-60 Time</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Performance Results</h2>
                
                <div class="result-card">
                    <h3>0-60 mph Time</h3>
                    <div class="amount" id="time060">5.2 sec</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Power/Weight</h4>
                        <div class="value" id="powerWeight">11.7</div>
                        <small>lbs/hp</small>
                    </div>
                    <div class="metric-card">
                        <h4>0-100 mph</h4>
                        <div class="value" id="time0100">12.8</div>
                        <small>seconds</small>
                    </div>
                    <div class="metric-card">
                        <h4>Quarter Mile</h4>
                        <div class="value" id="quarterMile">13.5</div>
                        <small>seconds</small>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Performance Rating</h3>
                    <div style="text-align: center; margin: 15px 0;">
                        <div id="performanceLabel" style="font-size: 1.5rem; font-weight: bold; color: #667eea; margin-bottom: 10px;">Very Quick</div>
                    </div>
                    <div class="performance-gauge">
                        <div class="gauge-marker" id="gaugeMarker"></div>
                    </div>
                    <div class="gauge-labels">
                        <span>Supercar<br>(&lt;3s)</span>
                        <span>Sports<br>(3-5s)</span>
                        <span>Quick<br>(5-7s)</span>
                        <span>Average<br>(7-10s)</span>
                        <span>Slow<br>(&gt;10s)</span>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Vehicle Analysis</h3>
                    <div class="breakdown-item">
                        <span>Horsepower</span>
                        <strong id="hpDisplay">300 HP</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight</span>
                        <strong id="weightDisplay">3,500 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Power-to-Weight Ratio</span>
                        <strong id="pwrDisplay">11.7 lbs/hp</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>HP per Ton</span>
                        <strong id="hpPerTon">171 HP/ton</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Drivetrain</span>
                        <strong id="drivetrainDisplay">AWD</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Transmission</span>
                        <strong id="transDisplay">Automatic</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Acceleration Times</h3>
                    <div class="breakdown-item">
                        <span>0-30 mph</span>
                        <strong id="time030">2.1 sec</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>0-60 mph</span>
                        <strong id="time060b">5.2 sec</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>0-100 mph</span>
                        <strong id="time0100b">12.8 sec</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Quarter Mile (1/4 mi)</span>
                        <strong id="quarterMileb">13.5 sec @ 105 mph</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>30-70 mph</span>
                        <strong id="time3070">3.8 sec</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Compare to Real Cars</h3>
                    <table class="comparison-table">
                        <thead>
                            <tr>
                                <th>Vehicle Class</th>
                                <th>Typical 0-60</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>🏆 Supercar</td>
                                <td>2.5-3.0 sec</td>
                            </tr>
                            <tr>
                                <td>🏎️ Sports Car</td>
                                <td>4.0-5.5 sec</td>
                            </tr>
                            <tr>
                                <td>🚗 Performance Sedan</td>
                                <td>5.5-7.0 sec</td>
                            </tr>
                            <tr>
                                <td>🚙 SUV/Crossover</td>
                                <td>7.0-9.0 sec</td>
                            </tr>
                            <tr>
                                <td>🚐 Economy Car</td>
                                <td>9.0-12.0 sec</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> Actual 0-60 times vary based on driver skill, road conditions, tire temperature, altitude, and vehicle condition. This calculator provides estimates based on physics formulas and typical efficiency factors.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🏎️ 0-60 Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Vehicle acceleration and performance analysis</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('accelForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculate060();
        });

        function calculate060() {
            // Get inputs
            const horsepower = parseFloat(document.getElementById('horsepower').value);
            const weight = parseFloat(document.getElementById('weight').value);
            const weightUnit = document.getElementById('weightUnit').value;
            const drivetrain = document.getElementById('drivetrain').value;
            const transmission = document.getElementById('transmission').value;
            const tireType = document.getElementById('tireType').value;
            const launchControl = document.getElementById('launchControl').value;
            
            // Convert weight to lbs if needed
            const weightLbs = weightUnit === 'kg' ? weight * 2.20462 : weight;
            
            // Calculate power-to-weight ratio
            const powerToWeight = weightLbs / horsepower;
            const hpPerTon = (horsepower / (weightLbs / 2000)).toFixed(0);
            
            // Base 0-60 calculation using empirical formula
            // Base formula: time = 5.825 * sqrt(weight / horsepower)
            let time060 = 5.825 * Math.sqrt(weightLbs / horsepower);
            
            // Drivetrain efficiency factors
            const drivetrainFactors = {
                'rwd': 1.05,  // RWD slightly slower due to traction
                'fwd': 1.08,  // FWD slower due to weight distribution
                'awd': 0.95,  // AWD best traction
                '4wd': 1.00   // 4WD neutral
            };
            time060 *= drivetrainFactors[drivetrain];
            
            // Transmission factors
            const transFactors = {
                'manual': 1.08,    // Manual slower (human shift time)
                'automatic': 1.00, // Baseline
                'dct': 0.95,       // DCT fastest shifts
                'cvt': 1.05        // CVT slightly slower
            };
            time060 *= transFactors[transmission];
            
            // Tire grip factors
            const tireFactors = {
                'street': 1.05,
                'performance': 1.00,
                'race': 0.90,
                'allseason': 1.12
            };
            time060 *= tireFactors[tireType];
            
            // Launch control factors
            const launchFactors = {
                'none': 1.10,
                'basic': 1.00,
                'advanced': 0.92
            };
            time060 *= launchFactors[launchControl];
            
            // Calculate other times
            const time030 = time060 * 0.40;  // 0-30 is ~40% of 0-60
            const time0100 = time060 * 2.46; // 0-100 is ~2.46x of 0-60
            const time3070 = time060 * 0.73; // 30-70 is ~73% of 0-60
            
            // Quarter mile estimation (1/4 mile = 402m)
            // Formula: ET = 6.269 * (weight/hp)^0.3333
            const quarterMile = 6.269 * Math.pow(weightLbs / horsepower, 0.3333);
            const trapSpeed = 224 * Math.pow(horsepower / weightLbs, 0.3333);
            
            // Performance rating
            let rating, gaugePosition;
            if (time060 < 3.0) {
                rating = 'Supercar Performance';
                gaugePosition = 10;
            } else if (time060 < 5.0) {
                rating = 'Sports Car Performance';
                gaugePosition = 30;
            } else if (time060 < 7.0) {
                rating = 'Very Quick';
                gaugePosition = 50;
            } else if (time060 < 10.0) {
                rating = 'Average';
                gaugePosition = 75;
            } else {
                rating = 'Slow';
                gaugePosition = 95;
            }
            
            // Update UI
            document.getElementById('time060').textContent = time060.toFixed(1) + ' sec';
            document.getElementById('powerWeight').textContent = powerToWeight.toFixed(1);
            document.getElementById('time0100').textContent = time0100.toFixed(1);
            document.getElementById('quarterMile').textContent = quarterMile.toFixed(1);
            
            document.getElementById('performanceLabel').textContent = rating;
            document.getElementById('gaugeMarker').style.left = gaugePosition + '%';
            
            document.getElementById('hpDisplay').textContent = horsepower + ' HP';
            document.getElementById('weightDisplay').textContent = weightLbs.toLocaleString() + ' lbs';
            document.getElementById('pwrDisplay').textContent = powerToWeight.toFixed(1) + ' lbs/hp';
            document.getElementById('hpPerTon').textContent = hpPerTon + ' HP/ton';
            
            const drivetrainNames = {
                'rwd': 'RWD (Rear-Wheel Drive)',
                'fwd': 'FWD (Front-Wheel Drive)',
                'awd': 'AWD (All-Wheel Drive)',
                '4wd': '4WD (Four-Wheel Drive)'
            };
            document.getElementById('drivetrainDisplay').textContent = drivetrainNames[drivetrain];
            
            const transNames = {
                'manual': 'Manual',
                'automatic': 'Automatic',
                'dct': 'DCT (Dual-Clutch)',
                'cvt': 'CVT'
            };
            document.getElementById('transDisplay').textContent = transNames[transmission];
            
            document.getElementById('time030').textContent = time030.toFixed(1) + ' sec';
            document.getElementById('time060b').textContent = time060.toFixed(1) + ' sec';
            document.getElementById('time0100b').textContent = time0100.toFixed(1) + ' sec';
            document.getElementById('quarterMileb').textContent = quarterMile.toFixed(1) + ' sec @ ' + Math.round(trapSpeed) + ' mph';
            document.getElementById('time3070').textContent = time3070.toFixed(1) + ' sec';
        }

        // Initialize
        window.addEventListener('load', function() {
            calculate060();
        });
    </script>
</body>
</html>