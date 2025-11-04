<?php
/**
 * Swim Pace Calculator
 * File: sports/swim-pace-calculator.php
 * Description: Calculate swim pace for various distances and units
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swim Pace Calculator - Professional Swimming Pace Analysis</title>
    <meta name="description" content="Calculate swim pace, splits, and training zones for pool and open water swimming.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #006994; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-section { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-bottom: 30px; }
        
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { display: flex; }
        .input-wrapper input { flex: 1; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #00b4db; box-shadow: 0 0 0 3px rgba(0, 180, 219, 0.1); }
        
        .unit-select, .pool-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; margin-top: 10px; }
        .unit-select:focus, .pool-select:focus { outline: none; border-color: #00b4db; box-shadow: 0 0 0 3px rgba(0, 180, 219, 0.1); }
        
        .calculate-btn { background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%); color: white; border: none; border-radius: 10px; padding: 16px 30px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin-top: 10px; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0, 180, 219, 0.3); }
        
        .results-section { display: none; margin-top: 30px; }
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .result-card { background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #00b4db; text-align: center; }
        .result-label { color: #006064; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.3rem; font-weight: bold; color: #00838f; }
        
        .splits-section { margin-top: 25px; }
        .splits-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .splits-table th, .splits-table td { padding: 12px; text-align: center; border-bottom: 1px solid #e0e0e0; }
        .splits-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .splits-table tr:nth-child(even) { background: #f8f9fa; }
        .splits-table tr:hover { background: #e0f7fa; }
        
        .training-zones { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .training-zones h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .zones-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .zone-card { background: white; padding: 15px; border-radius: 8px; border-left: 4px solid #00b4db; }
        .zone-name { font-weight: bold; color: #00838f; margin-bottom: 5px; }
        .zone-pace { color: #006064; font-size: 0.9rem; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .formula-box { background: #e0f7fa; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #00b4db; }
        .formula-box strong { color: #00838f; }
        
        .comparison-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .comparison-table th, .comparison-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .comparison-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .comparison-table tr:hover { background: #e0f7fa; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-section { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .splits-table { font-size: 0.8rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏊‍♂️ Swim Pace Calculator</h1>
            <p>Calculate your swim pace, splits, and training zones for optimal performance</p>
        </div>

        <div class="calculator-card">
            <div class="input-section">
                <div class="input-group">
                    <label for="distance">Distance</label>
                    <div class="input-wrapper">
                        <input type="number" id="distance" placeholder="Enter distance" value="100">
                    </div>
                    <select id="distanceUnit" class="unit-select">
                        <option value="m" selected>Meters</option>
                        <option value="yd">Yards</option>
                    </select>
                </div>
                
                <div class="input-group">
                    <label for="timeMinutes">Time</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="font-size: 0.8rem;">Minutes</label>
                            <input type="number" id="timeMinutes" placeholder="Min" value="1" min="0">
                        </div>
                        <div>
                            <label style="font-size: 0.8rem;">Seconds</label>
                            <input type="number" id="timeSeconds" placeholder="Sec" value="30" min="0" max="59">
                        </div>
                        <div>
                            <label style="font-size: 0.8rem;">Hundredths</label>
                            <input type="number" id="timeHundredths" placeholder="00" value="0" min="0" max="99">
                        </div>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="poolLength">Pool Length</label>
                    <select id="poolLength" class="pool-select">
                        <option value="25" selected>25m/25yd (Short Course)</option>
                        <option value="50">50m (Long Course/Olympic)</option>
                        <option value="33.3">33.3m (33 1/3 yd)</option>
                        <option value="20">20m/20yd</option>
                        <option value="0">Open Water</option>
                    </select>
                </div>
            </div>
            
            <button class="calculate-btn" onclick="calculatePace()">Calculate Swim Pace</button>
            
            <div class="results-section" id="resultsSection">
                <div class="results-grid">
                    <div class="result-card">
                        <div class="result-label">Pace per 100m</div>
                        <div class="result-value" id="pace100m">--:--.--</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Pace per 100yd</div>
                        <div class="result-value" id="pace100yd">--:--.--</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Speed</div>
                        <div class="result-value" id="speed">-- km/h</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Stroke Rate</div>
                        <div class="result-value" id="strokeRate">-- SPM</div>
                    </div>
                </div>
                
                <div class="splits-section">
                    <h3>📊 Split Times</h3>
                    <table class="splits-table" id="splitsTable">
                        <thead>
                            <tr>
                                <th>Distance</th>
                                <th>Split Time</th>
                                <th>Cumulative Time</th>
                                <th>Pace/100m</th>
                            </tr>
                        </thead>
                        <tbody id="splitsBody">
                            <!-- Splits will be populated here -->
                        </tbody>
                    </table>
                </div>
                
                <div class="training-zones">
                    <h3>🎯 Training Zones</h3>
                    <div class="zones-grid">
                        <div class="zone-card">
                            <div class="zone-name">Recovery</div>
                            <div class="zone-pace" id="zoneRecovery">--:--</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">Easy swimming, technique focus</div>
                        </div>
                        <div class="zone-card">
                            <div class="zone-name">Endurance</div>
                            <div class="zone-pace" id="zoneEndurance">--:--</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">Steady aerobic pace</div>
                        </div>
                        <div class="zone-card">
                            <div class="zone-name">Tempo</div>
                            <div class="zone-pace" id="zoneTempo">--:--</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">Moderately hard, race pace</div>
                        </div>
                        <div class="zone-card">
                            <div class="zone-name">Threshold</div>
                            <div class="zone-pace" id="zoneThreshold">--:--</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">Lactate threshold, hard effort</div>
                        </div>
                        <div class="zone-card">
                            <div class="zone-name">VO2 Max</div>
                            <div class="zone-pace" id="zoneVO2Max">--:--</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">Maximum effort, short intervals</div>
                        </div>
                        <div class="zone-card">
                            <div class="zone-name">Sprint</div>
                            <div class="zone-pace" id="zoneSprint">--:--</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">All-out maximum speed</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🏊‍♂️ Understanding Swim Pace</h2>
            
            <p>Swim pace is a critical metric for swimmers of all levels, from beginners to elite competitors. It helps you track progress, set realistic goals, and structure effective training sessions.</p>

            <h3>📊 How to Calculate Swim Pace</h3>
            <div class="formula-box">
                <strong>Pace per 100m = (Total Time / Total Distance) × 100</strong><br><br>
                <strong>Example:</strong> If you swim 400m in 6:00 (360 seconds):<br>
                Pace per 100m = (360 / 400) × 100 = 90 seconds = 1:30 per 100m
            </div>

            <h3>🏊‍♀️ Standard Competition Distances</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Pool Type</th>
                        <th>Common Events</th>
                        <th>Pool Length</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Short Course (SCM/SCY)</td><td>25m/25yd pool</td><td>25m or 25yd</td></tr>
                    <tr><td>Long Course (LCM)</td><td>Olympic pool</td><td>50m</td></tr>
                    <tr><td>Open Water</td><td>Marathon swimming</td><td>Variable</td></tr>
                </tbody>
            </table>

            <h3>📈 Pace Standards by Level</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Skill Level</th>
                        <th>100m Freestyle Pace</th>
                        <th>Typical 1500m Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Beginner</td><td>2:30-3:00</td><td>45:00-55:00</td></tr>
                    <tr><td>Intermediate</td><td>1:45-2:15</td><td>30:00-40:00</td></tr>
                    <tr><td>Advanced</td><td>1:20-1:40</td><td>22:00-28:00</td></tr>
                    <tr><td>Elite</td><td>0:55-1:15</td><td>15:00-20:00</td></tr>
                    <tr><td>World Class</td><td>0:48-0:55</td><td>14:30-15:30</td></tr>
                </tbody>
            </table>

            <h3>🎯 Training Zones Explained</h3>
            <div class="formula-box">
                <strong>Recovery Zone (60-70% effort):</strong> Easy swimming for recovery and technique work<br>
                <strong>Endurance Zone (70-80% effort):</strong> Steady aerobic pace for building endurance<br>
                <strong>Tempo Zone (80-85% effort):</strong> Moderately hard, sustainable for longer distances<br>
                <strong>Threshold Zone (85-92% effort):</strong> Lactate threshold pace, challenging but sustainable<br>
                <strong>VO2 Max Zone (92-97% effort):</strong> High intensity for improving aerobic capacity<br>
                <strong>Sprint Zone (97-100% effort):</strong> Maximum effort for short distances
            </div>

            <h3>📏 Pool Length Conversions</h3>
            <ul>
                <li><strong>25 yards = 22.86 meters</strong> (SCY to SCM conversion)</li>
                <li><strong>25 meters = 27.34 yards</strong> (SCM to SCY conversion)</li>
                <li><strong>1 mile = 1609.34 meters = 1760 yards</strong></li>
                <li><strong>1 kilometer = 1000 meters = 1093.61 yards</strong></li>
            </ul>

            <h3>⏱️ Time Standards for Common Distances</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Distance</th>
                        <th>Beginner</th>
                        <th>Intermediate</th>
                        <th>Advanced</th>
                        <th>Elite</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>100m Freestyle</td><td>2:00-2:30</td><td>1:30-2:00</td><td>1:10-1:30</td><td>0:50-1:10</td></tr>
                    <tr><td>200m Freestyle</td><td>4:30-5:30</td><td>3:30-4:30</td><td>2:40-3:30</td><td>1:50-2:40</td></tr>
                    <tr><td>400m Freestyle</td><td>9:00-11:00</td><td>7:00-9:00</td><td>5:30-7:00</td><td>4:00-5:30</td></tr>
                    <tr><td>800m Freestyle</td><td>18:00-22:00</td><td>14:00-18:00</td><td>11:00-14:00</td><td>8:00-11:00</td></tr>
                    <tr><td>1500m Freestyle</td><td>35:00-42:00</td><td>28:00-35:00</td><td>22:00-28:00</td><td>15:00-22:00</td></tr>
                </tbody>
            </table>

            <h3>🏆 World Record Paces</h3>
            <ul>
                <li><strong>Men's 100m Freestyle:</strong> 46.86 seconds (César Cielo) - 0:46.86/100m</li>
                <li><strong>Women's 100m Freestyle:</strong> 51.71 seconds (Sarah Sjöström) - 0:51.71/100m</li>
                <li><strong>Men's 1500m Freestyle:</strong> 14:31.02 (Sun Yang) - 0:58.07/100m</li>
                <li><strong>Women's 1500m Freestyle:</strong> 15:20.48 (Katie Ledecky) - 1:01.37/100m</li>
            </ul>

            <h3>💡 Training Tips</h3>
            <div class="formula-box">
                <strong>For Beginners:</strong><br>
                • Focus on technique over speed<br>
                • Use drills to improve stroke efficiency<br>
                • Build endurance gradually with short rest intervals<br><br>
                <strong>For Intermediate Swimmers:</strong><br>
                • Incorporate interval training<br>
                • Work on pacing strategies<br>
                • Include threshold and VO2 max sessions<br><br>
                <strong>For Advanced Swimmers:</strong><br>
                • Fine-tune race pace strategies<br>
                • Include race-specific training<br>
                • Focus on starts, turns, and finishes
            </div>

            <h3>🌊 Open Water Considerations</h3>
            <ul>
                <li><strong>Currents and tides</strong> can significantly affect pace</li>
                <li><strong>Sighting</strong> adds time and affects rhythm</li>
                <li><strong>Drafting</strong> can save 10-20% energy</li>
                <li><strong>Water temperature</strong> affects performance</li>
                <li><strong>Wetsuits</strong> provide buoyancy and speed advantage</li>
            </ul>

            <h3>📱 Using Technology</h3>
            <p>Modern swim technology includes pace clocks, tempo trainers, smart goggles, and swim watches that can track stroke rate, SWOLF score (swim golf - strokes + time), and efficiency metrics to help optimize your training.</p>

            <h3>🎯 Goal Setting</h3>
            <p>Set realistic, incremental goals based on your current pace. A 5-10% improvement over a training cycle is an excellent target. Remember that consistency in training, proper technique, and adequate recovery are more important than dramatic pace improvements in short periods.</p>
        </div>

        <div class="footer">
            <p>🏊‍♂️ Swim Pace Calculator | Professional Swimming Analysis</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate pace, splits, and training zones for optimal performance</p>
        </div>
    </div>

    <script>
        function calculatePace() {
            // Get input values
            const distance = parseFloat(document.getElementById('distance').value);
            const distanceUnit = document.getElementById('distanceUnit').value;
            const minutes = parseInt(document.getElementById('timeMinutes').value) || 0;
            const seconds = parseInt(document.getElementById('timeSeconds').value) || 0;
            const hundredths = parseInt(document.getElementById('timeHundredths').value) || 0;
            const poolLength = parseFloat(document.getElementById('poolLength').value);
            
            // Validate inputs
            if (isNaN(distance) || distance <= 0) {
                alert('Please enter a valid distance');
                return;
            }
            
            // Calculate total time in seconds
            const totalSeconds = minutes * 60 + seconds + hundredths / 100;
            
            if (totalSeconds <= 0) {
                alert('Please enter a valid time');
                return;
            }
            
            // Convert distance to meters if needed
            let distanceInMeters = distance;
            if (distanceUnit === 'yd') {
                distanceInMeters = distance * 0.9144; // Convert yards to meters
            }
            
            // Calculate pace per 100m
            const pacePer100mSeconds = (totalSeconds / distanceInMeters) * 100;
            
            // Calculate pace per 100yd
            const pacePer100ydSeconds = pacePer100mSeconds / 0.9144;
            
            // Calculate speed in km/h
            const speedKmh = (distanceInMeters / totalSeconds) * 3.6;
            
            // Estimate stroke rate (simplified calculation)
            const strokeRate = Math.round(60 / (pacePer100mSeconds / 100 * 1.2)); // Assuming 1.2 seconds per stroke
            
            // Display results
            document.getElementById('pace100m').textContent = formatTime(pacePer100mSeconds);
            document.getElementById('pace100yd').textContent = formatTime(pacePer100ydSeconds);
            document.getElementById('speed').textContent = speedKmh.toFixed(2) + ' km/h';
            document.getElementById('strokeRate').textContent = strokeRate + ' SPM';
            
            // Calculate and display splits
            calculateSplits(distanceInMeters, totalSeconds, poolLength);
            
            // Calculate training zones
            calculateTrainingZones(pacePer100mSeconds);
            
            // Show results section
            document.getElementById('resultsSection').style.display = 'block';
        }
        
        function formatTime(totalSeconds) {
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = Math.floor(totalSeconds % 60);
            const hundredths = Math.round((totalSeconds % 1) * 100);
            
            return `${minutes}:${seconds.toString().padStart(2, '0')}.${hundredths.toString().padStart(2, '0')}`;
        }
        
        function calculateSplits(distanceInMeters, totalSeconds, poolLength) {
            const splitsBody = document.getElementById('splitsBody');
            splitsBody.innerHTML = '';
            
            // Determine split interval based on distance
            let splitInterval;
            if (distanceInMeters <= 100) {
                splitInterval = 25;
            } else if (distanceInMeters <= 400) {
                splitInterval = 50;
            } else {
                splitInterval = 100;
            }
            
            // Calculate number of splits
            const numSplits = Math.floor(distanceInMeters / splitInterval);
            
            // Time per meter
            const timePerMeter = totalSeconds / distanceInMeters;
            
            let cumulativeTime = 0;
            
            for (let i = 1; i <= numSplits; i++) {
                const splitDistance = i * splitInterval;
                const splitTime = splitDistance * timePerMeter;
                const splitPace = (splitTime / splitDistance) * 100;
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${splitDistance}m</td>
                    <td>${formatTime(splitTime - cumulativeTime)}</td>
                    <td>${formatTime(splitTime)}</td>
                    <td>${formatTime(splitPace)}</td>
                `;
                
                splitsBody.appendChild(row);
                cumulativeTime = splitTime;
            }
            
            // Add final split if distance doesn't divide evenly
            if (distanceInMeters % splitInterval !== 0) {
                const finalSplitTime = totalSeconds;
                const finalSplitPace = (finalSplitTime / distanceInMeters) * 100;
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${distanceInMeters}m</td>
                    <td>${formatTime(finalSplitTime - cumulativeTime)}</td>
                    <td>${formatTime(finalSplitTime)}</td>
                    <td>${formatTime(finalSplitPace)}</td>
                `;
                
                splitsBody.appendChild(row);
            }
        }
        
        function calculateTrainingZones(basePaceSeconds) {
            // Calculate training zones as percentages of base pace
            const recoveryPace = basePaceSeconds / 0.85; // 85% of effort = slower pace
            const endurancePace = basePaceSeconds / 0.80; // 80% of effort
            const tempoPace = basePaceSeconds / 0.75; // 75% of effort
            const thresholdPace = basePaceSeconds / 0.70; // 70% of effort
            const vo2maxPace = basePaceSeconds / 0.65; // 65% of effort
            const sprintPace = basePaceSeconds / 0.60; // 60% of effort
            
            // Display training zones
            document.getElementById('zoneRecovery').textContent = formatTime(recoveryPace);
            document.getElementById('zoneEndurance').textContent = formatTime(endurancePace);
            document.getElementById('zoneTempo').textContent = formatTime(tempoPace);
            document.getElementById('zoneThreshold').textContent = formatTime(thresholdPace);
            document.getElementById('zoneVO2Max').textContent = formatTime(vo2maxPace);
            document.getElementById('zoneSprint').textContent = formatTime(sprintPace);
        }
        
        // Auto-calculate when inputs change
        document.getElementById('distance').addEventListener('input', calculatePace);
        document.getElementById('timeMinutes').addEventListener('input', calculatePace);
        document.getElementById('timeSeconds').addEventListener('input', calculatePace);
        document.getElementById('timeHundredths').addEventListener('input', calculatePace);
        document.getElementById('distanceUnit').addEventListener('change', calculatePace);
        document.getElementById('poolLength').addEventListener('change', calculatePace);
        
        // Initial calculation if values are present
        window.addEventListener('load', function() {
            if (document.getElementById('distance').value && 
                document.getElementById('timeMinutes').value) {
                calculatePace();
            }
        });
    </script>
</body>
</html>
