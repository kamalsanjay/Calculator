<?php
/**
 * Bike Cadence Calculator
 * File: sports/bike-cadence-calculator.php
 * Description: Calculate cycling cadence, speed, and gear ratios
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bike Cadence Calculator - Professional Cycling Analysis</title>
    <meta name="description" content="Calculate cycling cadence, speed, gear ratios, and optimal RPM for training and performance.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #c0392b; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-section { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin-bottom: 30px; }
        
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { display: flex; }
        .input-wrapper input { flex: 1; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #e74c3c; box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; margin-top: 10px; }
        .unit-select:focus { outline: none; border-color: #e74c3c; box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1); }
        
        .calculate-btn { background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; border: none; border-radius: 10px; padding: 16px 30px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin-top: 10px; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(231, 76, 60, 0.3); }
        
        .results-section { display: none; margin-top: 30px; }
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .result-card { background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #e74c3c; text-align: center; }
        .result-label { color: #c62828; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.3rem; font-weight: bold; color: #d32f2f; }
        
        .gear-section { margin-top: 25px; }
        .gear-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .gear-table th, .gear-table td { padding: 12px; text-align: center; border-bottom: 1px solid #e0e0e0; }
        .gear-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .gear-table tr:nth-child(even) { background: #f8f9fa; }
        .gear-table tr:hover { background: #ffebee; }
        
        .cadence-zones { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .cadence-zones h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .zones-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .zone-card { background: white; padding: 15px; border-radius: 8px; border-left: 4px solid #e74c3c; }
        .zone-name { font-weight: bold; color: #d32f2f; margin-bottom: 5px; }
        .zone-range { color: #c62828; font-size: 0.9rem; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .formula-box { background: #ffebee; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #e74c3c; }
        .formula-box strong { color: #e74c3c; }
        
        .comparison-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .comparison-table th, .comparison-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .comparison-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .comparison-table tr:hover { background: #ffebee; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .gear-visual { display: flex; align-items: center; justify-content: center; margin: 20px 0; }
        .chainring, .cassette { text-align: center; padding: 15px; }
        .chainring { border-right: 2px solid #e0e0e0; }
        .gear-tooth { display: inline-block; width: 20px; height: 20px; background: #e74c3c; margin: 2px; border-radius: 50%; }
        
        @media (max-width: 768px) {
            .input-section { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .gear-table { font-size: 0.8rem; }
            .gear-visual { flex-direction: column; }
            .chainring { border-right: none; border-bottom: 2px solid #e0e0e0; margin-bottom: 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚴‍♂️ Bike Cadence Calculator</h1>
            <p>Calculate cycling cadence, speed, gear ratios, and optimal RPM for training</p>
        </div>

        <div class="calculator-card">
            <div class="input-section">
                <div class="input-group">
                    <label for="cadence">Cadence (RPM)</label>
                    <input type="number" id="cadence" placeholder="Enter RPM" value="90" min="1" max="200">
                </div>
                
                <div class="input-group">
                    <label for="chainring">Chainring Teeth</label>
                    <input type="number" id="chainring" placeholder="Front chainring" value="50" min="20" max="60">
                </div>
                
                <div class="input-group">
                    <label for="cassette">Cassette Teeth</label>
                    <input type="number" id="cassette" placeholder="Rear cassette" value="17" min="10" max="52">
                </div>
            </div>
            
            <div class="input-section">
                <div class="input-group">
                    <label for="wheelSize">Wheel Size</label>
                    <select id="wheelSize" class="unit-select">
                        <option value="2096">700x23c (Road bike)</option>
                        <option value="2136">700x25c</option>
                        <option value="2176">700x28c</option>
                        <option value="2235">700x32c</option>
                        <option value="2268">700x35c</option>
                        <option value="2050">650x23c</option>
                        <option value="1938">26" Mountain bike</option>
                        <option value="2055">27.5" Mountain bike</option>
                        <option value="2180">29" Mountain bike</option>
                        <option value="custom">Custom wheel size</option>
                    </select>
                </div>
                
                <div class="input-group" id="customWheelGroup" style="display: none;">
                    <label for="wheelCircumference">Wheel Circumference (mm)</label>
                    <input type="number" id="wheelCircumference" placeholder="Enter circumference" value="2096" min="1000" max="3000">
                </div>
                
                <div class="input-group">
                    <label for="unitSystem">Unit System</label>
                    <select id="unitSystem" class="unit-select">
                        <option value="metric" selected>Metric (km/h)</option>
                        <option value="imperial">Imperial (mph)</option>
                    </select>
                </div>
            </div>
            
            <button class="calculate-btn" onclick="calculateCadence()">Calculate Cycling Metrics</button>
            
            <div class="results-section" id="resultsSection">
                <div class="results-grid">
                    <div class="result-card">
                        <div class="result-label">Speed</div>
                        <div class="result-value" id="speed">--</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Gear Ratio</div>
                        <div class="result-value" id="gearRatio">--</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Gear Inches</div>
                        <div class="result-value" id="gearInches">--</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Development (m)</div>
                        <div class="result-value" id="development">--</div>
                    </div>
                </div>
                
                <div class="gear-section">
                    <h3>⚙️ Gear Analysis</h3>
                    
                    <div class="gear-visual">
                        <div class="chainring">
                            <div style="font-weight: bold; color: #e74c3c;">Chainring</div>
                            <div id="chainringVisual"></div>
                            <div id="chainringTeeth">50 teeth</div>
                        </div>
                        <div class="cassette">
                            <div style="font-weight: bold; color: #e74c3c;">Cassette</div>
                            <div id="cassetteVisual"></div>
                            <div id="cassetteTeeth">17 teeth</div>
                        </div>
                    </div>
                    
                    <table class="gear-table">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Value</th>
                                <th>Interpretation</th>
                                <th>Ideal Use</th>
                            </tr>
                        </thead>
                        <tbody id="gearBody">
                            <!-- Gear analysis will be populated here -->
                        </tbody>
                    </table>
                </div>
                
                <div class="cadence-zones">
                    <h3>🎯 Cadence Training Zones</h3>
                    <div class="zones-grid">
                        <div class="zone-card">
                            <div class="zone-name">Recovery Spin</div>
                            <div class="zone-range">60-70 RPM</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">Active recovery, technique work</div>
                        </div>
                        <div class="zone-card">
                            <div class="zone-name">Endurance</div>
                            <div class="zone-range">75-85 RPM</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">Long rides, aerobic base</div>
                        </div>
                        <div class="zone-card">
                            <div class="zone-name">Sweet Spot</div>
                            <div class="zone-range">85-95 RPM</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">Optimal efficiency, tempo rides</div>
                        </div>
                        <div class="zone-card">
                            <div class="zone-name">High Cadence</div>
                            <div class="zone-range">95-105 RPM</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">Intervals, climbing, racing</div>
                        </div>
                        <div class="zone-card">
                            <div class="zone-name">Sprint</div>
                            <div class="zone-range">105-120+ RPM</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">Maximum power, short bursts</div>
                        </div>
                        <div class="zone-card">
                            <div class="zone-name">Your Current</div>
                            <div class="zone-range" id="currentCadenceZone">-- RPM</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;" id="currentZoneDesc">--</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🚴‍♂️ Understanding Bike Cadence</h2>
            
            <p>Cadence (RPM - Revolutions Per Minute) is one of the most important metrics in cycling performance. It affects efficiency, power output, and fatigue management.</p>

            <h3>📊 How Cadence Affects Performance</h3>
            <div class="formula-box">
                <strong>Speed (km/h) = (Cadence × Wheel Circumference × 60) ÷ (Gear Ratio × 1,000,000)</strong><br><br>
                <strong>Gear Ratio = Chainring Teeth ÷ Cassette Teeth</strong><br><br>
                <strong>Gear Inches = (Chainring ÷ Cassette) × Wheel Diameter</strong><br><br>
                <strong>Development = (Chainring ÷ Cassette) × Wheel Circumference</strong>
            </div>

            <h3>🎯 Optimal Cadence Ranges</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Rider Type</th>
                        <th>Typical Cadence</th>
                        <th>Terrain</th>
                        <th>Power Output</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Professional Road</td><td>90-100 RPM</td><td>Flat terrain</td><td>High efficiency</td></tr>
                    <tr><td>Recreational</td><td>70-85 RPM</td><td>Mixed terrain</td><td>Moderate efficiency</td></tr>
                    <tr><td>Mountain Biker</td><td>60-80 RPM</td><td>Technical trails</td><td>High torque</td></tr>
                    <tr><td>Track Sprinter</td><td>110-130+ RPM</td><td>Velodrome</td><td>Maximum power</td></tr>
                    <tr><td>Triathlete</td><td>85-95 RPM</td><td>Time trial</td><td>Run leg preservation</td></tr>
                </tbody>
            </table>

            <h3>⚙️ Gear Ratio Analysis</h3>
            <div class="formula-box">
                <strong>Low Gear (Climbing):</strong> Small chainring + large cassette = easier pedaling<br>
                <strong>High Gear (Descending):</strong> Large chainring + small cassette = faster speed<br>
                <strong>Ideal Range:</strong> 2.5-4.0 gear ratio for most road cycling<br>
                <strong>Mountain Biking:</strong> 1.0-3.0 gear ratio for technical terrain
            </div>

            <h3>🚀 Professional Cadence Data</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Average Cadence</th>
                        <th>Peak Cadence</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Tour de France Flat Stage</td><td>95-105 RPM</td><td>120+ RPM</td><td>Peloton riding</td></tr>
                    <tr><td>Time Trial World Cup</td><td>85-95 RPM</td><td>110 RPM</td><td>Aerodynamic position</td></tr>
                    <tr><td>Mountain Bike XC</td><td>75-85 RPM</td><td>100 RPM</td><td>Technical terrain</td></tr>
                    <tr><td>Track Kilometer</td><td>120-140 RPM</td><td>160+ RPM</td><td>Fixed gear</td></tr>
                    <tr><td>Triathlon Ironman</td><td>80-90 RPM</td><td>100 RPM</td><td>Run preservation</td></tr>
                </tbody>
            </table>

            <h3>🔧 Common Gear Setups</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Bike Type</th>
                        <th>Chainring</th>
                        <th>Cassette Range</th>
                        <th>Lowest Gear</th>
                        <th>Highest Gear</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Road Race</td><td>53/39T</td><td>11-28T</td><td>1.39</td><td>4.82</td></tr>
                    <tr><td>Endurance Road</td><td>50/34T</td><td>11-32T</td><td>1.06</td><td>4.55</td></tr>
                    <tr><td>Gravel Bike</td><td>48/31T</td><td>11-34T</td><td>0.91</td><td>4.36</td></tr>
                    <tr><td>Mountain Bike</td><td>32T</td><td>10-52T</td><td>0.62</td><td>3.20</td></tr>
                    <tr><td>Time Trial</td><td>54/42T</td><td>11-25T</td><td>1.68</td><td>4.91</td></tr>
                </tbody>
            </table>

            <h3>💡 Cadence Training Benefits</h3>
            <div class="formula-box">
                <strong>Muscle Efficiency:</strong> Higher cadence reduces muscle fatigue<br>
                <strong>Cardiovascular:</strong> Trains heart and lungs more effectively<br>
                <strong>Pedal Technique:</strong> Improves smooth pedal stroke<br>
                <strong>Injury Prevention:</strong> Reduces strain on knees and joints<br>
                <strong>Power Development:</strong> Enables higher power output
            </div>

            <h3>📈 Cadence vs Power Relationship</h3>
            <ul>
                <li><strong>Low Cadence (60-70 RPM):</strong> High torque, muscular endurance focus</li>
                <li><strong>Medium Cadence (80-90 RPM):</strong> Balanced power and efficiency</li>
                <li><strong>High Cadence (95-110 RPM):</strong> Cardiovascular focus, less muscular fatigue</li>
                <li><strong>Very High Cadence (110+ RPM):</strong> Neuromuscular coordination, sprint power</li>
            </ul>

            <h3>🎓 Historical Perspective</h3>
            <p>In the early days of cycling, riders typically used much lower cadences (60-70 RPM) with fixed gears. The shift to higher cadences began with riders like Miguel Indurain and was popularized by Lance Armstrong's high-RPM climbing style. Modern power meters have further refined optimal cadence strategies.</p>

            <h3>🔬 Scientific Research Findings</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Study Focus</th>
                        <th>Optimal Cadence</th>
                        <th>Key Finding</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Metabolic Efficiency</td><td>90-100 RPM</td><td>Lowest oxygen consumption</td></tr>
                    <tr><td>Muscle Fatigue</td><td>85-95 RPM</td><td>Reduced muscle glycogen use</td></tr>
                    <tr><td>Time Trial Performance</td><td>80-90 RPM</td><td>Best power:aerodynamics balance</td></tr>
                    <tr><td>Mountain Biking</td><td>70-85 RPM</td><td>Better traction and control</td></tr>
                    <tr><td>Triathlon Running</td><td>85-95 RPM</td><td>Less impact on run performance</td></tr>
                </tbody>
            </table>

            <h3>🚵‍♂️ Terrain-Specific Cadence</h3>
            <div class="formula-box">
                <strong>Flat Roads:</strong> 90-100 RPM for optimal efficiency<br>
                <strong>Climbing:</strong> 80-95 RPM to balance power and endurance<br>
                <strong>Descending:</strong> 100-120 RPM for speed maintenance<br>
                <strong>Headwinds:</strong> 85-95 RPM to maintain power into resistance<br>
                <strong>Technical Trails:</strong> 70-85 RPM for better bike control
            </div>

            <h3>📱 Modern Training Tools</h3>
            <p>Today's cyclists use cadence sensors, power meters, and smart trainers to precisely monitor and optimize their pedaling efficiency. These tools provide real-time feedback and enable targeted cadence drills for improvement.</p>

            <h3>🎯 Cadence Drills for Improvement</h3>
            <ul>
                <li><strong>High Cadence Intervals:</strong> 110-120 RPM for 1-2 minutes</li>
                <li><strong>Single Leg Drills:</strong> Focus on smooth pedal stroke</li>
                <li><strong>Cadence Ladders:</strong> Gradually increase from 80 to 110 RPM</li>
                <li><strong>Over-Under Sets:</strong> Alternate between high and low cadence</li>
                <li><strong>Spin-ups:</strong> Rapid acceleration to maximum cadence</li>
            </ul>
        </div>

        <div class="footer">
            <p>🚴‍♂️ Bike Cadence Calculator | Professional Cycling Analysis</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate speed, gear ratios, and optimal RPM for training and performance</p>
        </div>
    </div>

    <script>
        // Wheel circumference in millimeters for common sizes
        const wheelSizes = {
            '2096': '700x23c (Road) - 2096mm',
            '2136': '700x25c - 2136mm', 
            '2176': '700x28c - 2176mm',
            '2235': '700x32c - 2235mm',
            '2268': '700x35c - 2268mm',
            '2050': '650x23c - 2050mm',
            '1938': '26" MTB - 1938mm',
            '2055': '27.5" MTB - 2055mm',
            '2180': '29" MTB - 2180mm'
        };

        function calculateCadence() {
            // Get input values
            const cadence = parseInt(document.getElementById('cadence').value) || 0;
            const chainring = parseInt(document.getElementById('chainring').value) || 0;
            const cassette = parseInt(document.getElementById('cassette').value) || 0;
            const wheelSize = document.getElementById('wheelSize').value;
            const unitSystem = document.getElementById('unitSystem').value;
            
            let wheelCircumference;
            if (wheelSize === 'custom') {
                wheelCircumference = parseInt(document.getElementById('wheelCircumference').value) || 2096;
            } else {
                wheelCircumference = parseInt(wheelSize);
            }
            
            // Validate inputs
            if (cadence <= 0 || chainring <= 0 || cassette <= 0 || wheelCircumference <= 0) {
                alert('Please enter valid values for all fields');
                return;
            }
            
            // Calculate gear ratio
            const gearRatio = chainring / cassette;
            
            // Calculate gear inches (traditional measurement)
            const wheelDiameterInches = (wheelCircumference / Math.PI) / 25.4;
            const gearInches = gearRatio * wheelDiameterInches;
            
            // Calculate development (distance per pedal revolution in meters)
            const development = (chainring / cassette) * (wheelCircumference / 1000);
            
            // Calculate speed
            let speed;
            if (unitSystem === 'metric') {
                // km/h = (RPM * circumference in meters * 60) / 1000
                speed = (cadence * (wheelCircumference / 1000) * 60) / 1000;
            } else {
                // mph = (RPM * circumference in inches * 60) / 63360
                const circumferenceInches = wheelCircumference / 25.4;
                speed = (cadence * circumferenceInches * 60) / 63360;
            }
            
            // Display results
            document.getElementById('speed').textContent = speed.toFixed(1) + (unitSystem === 'metric' ? ' km/h' : ' mph');
            document.getElementById('gearRatio').textContent = gearRatio.toFixed(2) + ':1';
            document.getElementById('gearInches').textContent = Math.round(gearInches) + '"';
            document.getElementById('development').textContent = development.toFixed(2) + 'm';
            
            // Update gear visualization
            updateGearVisualization(chainring, cassette);
            
            // Display gear analysis
            displayGearAnalysis(gearRatio, development, cadence, unitSystem);
            
            // Update cadence zone
            updateCadenceZone(cadence);
            
            // Show results section
            document.getElementById('resultsSection').style.display = 'block';
        }
        
        function updateGearVisualization(chainring, cassette) {
            const chainringVisual = document.getElementById('chainringVisual');
            const cassetteVisual = document.getElementById('cassetteVisual');
            
            // Clear previous visualization
            chainringVisual.innerHTML = '';
            cassetteVisual.innerHTML = '';
            
            // Create chainring visualization (limited to reasonable display)
            const chainringDisplay = Math.min(chainring, 20);
            for (let i = 0; i < chainringDisplay; i++) {
                const tooth = document.createElement('div');
                tooth.className = 'gear-tooth';
                tooth.style.opacity = (i < chainring) ? '1' : '0.3';
                chainringVisual.appendChild(tooth);
            }
            if (chainring > 20) {
                chainringVisual.innerHTML += `<div style="font-size: 0.8rem; margin-top: 5px;">+${chainring - 20} more</div>`;
            }
            
            // Create cassette visualization
            const cassetteDisplay = Math.min(cassette, 15);
            for (let i = 0; i < cassetteDisplay; i++) {
                const tooth = document.createElement('div');
                tooth.className = 'gear-tooth';
                tooth.style.opacity = (i < cassette) ? '1' : '0.3';
                cassetteVisual.appendChild(tooth);
            }
            if (cassette > 15) {
                cassetteVisual.innerHTML += `<div style="font-size: 0.8rem; margin-top: 5px;">+${cassette - 15} more</div>`;
            }
            
            document.getElementById('chainringTeeth').textContent = chainring + ' teeth';
            document.getElementById('cassetteTeeth').textContent = cassette + ' teeth';
        }
        
        function displayGearAnalysis(gearRatio, development, cadence, unitSystem) {
            const gearBody = document.getElementById('gearBody');
            gearBody.innerHTML = '';
            
            // Gear ratio analysis
            let ratioAnalysis, ratioUse;
            if (gearRatio < 2.0) {
                ratioAnalysis = 'Very Low';
                ratioUse = 'Steep climbing, mountain biking';
            } else if (gearRatio < 2.8) {
                ratioAnalysis = 'Low';
                ratioUse = 'Climbing, headwinds';
            } else if (gearRatio < 3.5) {
                ratioAnalysis = 'Medium';
                ratioUse = 'Flat terrain, endurance riding';
            } else if (gearRatio < 4.5) {
                ratioAnalysis = 'High';
                ratioUse = 'Fast group rides, slight descents';
            } else {
                ratioAnalysis = 'Very High';
                ratioUse = 'Time trials, steep descents';
            }
            
            addGearRow(gearBody, 'Gear Ratio', gearRatio.toFixed(2) + ':1', ratioAnalysis, ratioUse);
            
            // Development analysis
            let devAnalysis, devUse;
            if (development < 4.0) {
                devAnalysis = 'Very Low';
                devUse = 'Technical climbing, recovery';
            } else if (development < 6.0) {
                devAnalysis = 'Low';
                devUse = 'General climbing, endurance';
            } else if (development < 8.0) {
                devAnalysis = 'Medium';
                devUse = 'Flat roads, tempo riding';
            } else {
                devAnalysis = 'High';
                devUse = 'Fast riding, time trials';
            }
            
            addGearRow(gearBody, 'Development', development.toFixed(2) + 'm', devAnalysis, devUse);
            
            // Speed analysis
            const wheelCircumference = parseInt(document.getElementById('wheelSize').value) || 2096;
            const speed = (cadence * (wheelCircumference / 1000) * 60) / 1000;
            const speedMph = speed * 0.621371;
            
            let speedAnalysis, speedUse;
            const displaySpeed = unitSystem === 'metric' ? speed : speedMph;
            
            if (displaySpeed < 15) {
                speedAnalysis = 'Easy Pace';
                speedUse = 'Recovery, beginner riding';
            } else if (displaySpeed < 25) {
                speedAnalysis = 'Moderate Pace';
                speedUse = 'Endurance training, group rides';
            } else if (displaySpeed < 35) {
                speedAnalysis = 'Fast Pace';
                speedUse = 'Racing, fast group rides';
            } else {
                speedAnalysis = 'Very Fast';
                speedUse = 'Time trials, descents';
            }
            
            addGearRow(gearBody, 'Speed', displaySpeed.toFixed(1) + (unitSystem === 'metric' ? ' km/h' : ' mph'), speedAnalysis, speedUse);
            
            // Cadence efficiency
            let cadenceAnalysis, cadenceUse;
            if (cadence < 70) {
                cadenceAnalysis = 'Very Low';
                cadenceUse = 'High torque, muscular focus';
            } else if (cadence < 80) {
                cadenceAnalysis = 'Low';
                cadenceUse = 'Strength building, climbing';
            } else if (cadence < 95) {
                cadenceAnalysis = 'Optimal';
                cadenceUse = 'Balanced efficiency and power';
            } else if (cadence < 110) {
                cadenceAnalysis = 'High';
                cadenceUse = 'Cardiovascular focus, racing';
            } else {
                cadenceAnalysis = 'Very High';
                cadenceUse = 'Sprinting, neuromuscular training';
            }
            
            addGearRow(gearBody, 'Cadence', cadence + ' RPM', cadenceAnalysis, cadenceUse);
        }
        
        function addGearRow(tbody, metric, value, analysis, use) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><strong>${metric}</strong></td>
                <td>${value}</td>
                <td>${analysis}</td>
                <td>${use}</td>
            `;
            tbody.appendChild(row);
        }
        
        function updateCadenceZone(cadence) {
            const currentZone = document.getElementById('currentCadenceZone');
            const currentZoneDesc = document.getElementById('currentZoneDesc');
            
            let zone, description;
            
            if (cadence < 60) {
                zone = 'Too Low';
                description = 'Inefficient, high muscle strain';
            } else if (cadence < 75) {
                zone = 'Recovery Spin';
                description = 'Active recovery, technique work';
            } else if (cadence < 85) {
                zone = 'Endurance';
                description = 'Long rides, aerobic base';
            } else if (cadence < 95) {
                zone = 'Sweet Spot';
                description = 'Optimal efficiency, tempo rides';
            } else if (cadence < 105) {
                zone = 'High Cadence';
                description = 'Intervals, climbing, racing';
            } else if (cadence < 120) {
                zone = 'Sprint';
                description = 'Maximum power, short bursts';
            } else {
                zone = 'Very High';
                description = 'Neuromuscular, track cycling';
            }
            
            currentZone.textContent = cadence + ' RPM - ' + zone;
            currentZoneDesc.textContent = description;
        }
        
        // Show/hide custom wheel size input
        document.getElementById('wheelSize').addEventListener('change', function() {
            const customGroup = document.getElementById('customWheelGroup');
            customGroup.style.display = this.value === 'custom' ? 'block' : 'none';
        });
        
        // Auto-calculate when inputs change
        const inputs = ['cadence', 'chainring', 'cassette', 'wheelCircumference'];
        inputs.forEach(id => {
            document.getElementById(id).addEventListener('input', calculateCadence);
        });
        
        document.getElementById('wheelSize').addEventListener('change', calculateCadence);
        document.getElementById('unitSystem').addEventListener('change', calculateCadence);
        
        // Initial calculation
        window.addEventListener('load', calculateCadence);
    </script>
</body>
</html>
