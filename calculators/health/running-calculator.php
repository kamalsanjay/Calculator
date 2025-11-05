<?php
/**
 * Running Calculator
 * File: running-calculator.php
 * Description: Calculate race times, training paces, splits, and running performance predictions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Running Calculator - Race Time, Pace, Split & Training Calculator</title>
    <meta name="description" content="Free running calculator. Calculate race times, paces, splits, and training zones. Predict finish times and plan your training.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🏃 Running Calculator</h1>
        <p>Calculate race times, pace & splits</p>
    </header>
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        header p {
            font-size: 1.2em;
            opacity: 0.9;
        }
        
        .breadcrumb {
            margin: 20px 0;
        }
        
        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #5568d3;
        }
        
        .calculator-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }
        
        .calculator-section,
        .results-section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .calculator-section h2,
        .results-section h2 {
            color: #667eea;
            margin-bottom: 25px;
            font-size: 1.8em;
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
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #888;
            font-size: 0.9em;
        }
        
        .btn {
            background: #667eea;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #5568d3;
        }
        
        .result-card {
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        
        .result-card h3 {
            font-size: 1.2em;
            opacity: 0.9;
            margin-bottom: 10px;
            font-weight: 400;
        }
        
        .result-card .amount {
            font-size: 3em;
            font-weight: bold;
        }
        
        .result-card .category {
            font-size: 1.3em;
            margin-top: 10px;
            opacity: 0.95;
        }
        
        .underweight {
            background: linear-gradient(135deg, #42a5f5 0%, #1976d2 100%);
        }
        
        .normal {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .overweight {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
        }
        
        .obese {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        }
        
        .metric-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .metric-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #e0e0e0;
        }
        
        .metric-card h4 {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
            font-weight: 400;
        }
        
        .metric-card .value {
            color: #667eea;
            font-size: 2em;
            font-weight: bold;
        }
        
        .breakdown {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .breakdown h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.3em;
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
        
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box strong {
            color: #1976D2;
        }
        
        @media (max-width: 768px) {
            .calculator-wrapper {
                grid-template-columns: 1fr;
            }
            
            header h1 {
                font-size: 2em;
            }
            
            .result-card .amount {
                font-size: 2.5em;
            }
            
            .metric-grid {
                grid-template-columns: 1fr;
            }
        } 
    </style>
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Running Information</h2>
                <form id="runningForm">
                    <div class="form-group">
                        <label for="calculationType">I want to calculate</label>
                        <select id="calculationType">
                            <option value="pace">Pace (from time & distance)</option>
                            <option value="time">Time (from pace & distance)</option>
                            <option value="distance">Distance (from pace & time)</option>
                            <option value="predict">Predict Race Time (from recent race)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="unitSystem">Distance Units</label>
                        <select id="unitSystem">
                            <option value="miles">Miles</option>
                            <option value="km">Kilometers</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Input Values</h3>
                    
                    <div class="form-group" id="distanceGroup">
                        <label for="distance">Distance</label>
                        <input type="number" id="distance" value="5" min="0.1" max="500" step="0.1" required>
                        <small>Distance you want to calculate for</small>
                    </div>
                    
                    <div class="form-group" id="raceDistanceGroup">
                        <label for="raceDistance">Race Distance</label>
                        <select id="raceDistance">
                            <option value="custom">Custom Distance</option>
                            <option value="5k">5K (3.1 miles)</option>
                            <option value="10k">10K (6.2 miles)</option>
                            <option value="half" selected>Half Marathon (13.1 miles)</option>
                            <option value="marathon">Marathon (26.2 miles)</option>
                            <option value="50k">50K (31 miles)</option>
                            <option value="100k">100K (62 miles)</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="timeGroup">
                        <label>Time</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="hours" value="0" min="0" max="24" step="1" style="flex: 1;" placeholder="Hours">
                            <input type="number" id="minutes" value="25" min="0" max="59" step="1" style="flex: 1;" placeholder="Minutes">
                            <input type="number" id="seconds" value="0" min="0" max="59" step="1" style="flex: 1;" placeholder="Seconds">
                        </div>
                        <small>Hours : Minutes : Seconds</small>
                    </div>
                    
                    <div class="form-group" id="paceGroup" style="display: none;">
                        <label>Target Pace (per mile/km)</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="paceMinutes" value="8" min="0" max="60" step="1" style="flex: 1;" placeholder="Minutes">
                            <input type="number" id="paceSeconds" value="0" min="0" max="59" step="1" style="flex: 1;" placeholder="Seconds">
                        </div>
                        <small>Minutes : Seconds per mile/km</small>
                    </div>

                    <div id="predictGroup" style="display: none;">
                        <h3 style="color: #FF9800; margin: 25px 0 15px;">Recent Race Result</h3>
                        
                        <div class="form-group">
                            <label for="recentRaceDistance">Recent Race Distance</label>
                            <select id="recentRaceDistance">
                                <option value="5k">5K (3.1 miles)</option>
                                <option value="10k" selected>10K (6.2 miles)</option>
                                <option value="half">Half Marathon (13.1 miles)</option>
                                <option value="marathon">Marathon (26.2 miles)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Recent Race Time</label>
                            <div style="display: flex; gap: 10px;">
                                <input type="number" id="recentHours" value="0" min="0" max="24" step="1" style="flex: 1;" placeholder="Hours">
                                <input type="number" id="recentMinutes" value="50" min="0" max="59" step="1" style="flex: 1;" placeholder="Minutes">
                                <input type="number" id="recentSeconds" value="0" min="0" max="59" step="1" style="flex: 1;" placeholder="Seconds">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="targetRaceDistance">Target Race Distance</label>
                            <select id="targetRaceDistance">
                                <option value="5k">5K (3.1 miles)</option>
                                <option value="10k">10K (6.2 miles)</option>
                                <option value="half">Half Marathon (13.1 miles)</option>
                                <option value="marathon" selected>Marathon (26.2 miles)</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Calculate</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Running Results</h2>
                
                <div class="result-card success">
                    <h3 id="resultTitle">Your Pace</h3>
                    <div class="amount" id="resultValue">8:00 /mile</div>
                    <div style="margin-top: 10px; font-size: 1em;" id="resultSubtitle">Moderate running pace</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4 id="metric1Label">Pace (/mile)</h4>
                        <div class="value" id="metric1">8:00</div>
                    </div>
                    <div class="metric-card">
                        <h4 id="metric2Label">Pace (/km)</h4>
                        <div class="value" id="metric2">4:58</div>
                    </div>
                    <div class="metric-card">
                        <h4 id="metric3Label">Speed (mph)</h4>
                        <div class="value" id="metric3">7.5</div>
                    </div>
                    <div class="metric-card">
                        <h4 id="metric4Label">Speed (km/h)</h4>
                        <div class="value" id="metric4">12.1</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Run Summary</h3>
                    <div class="breakdown-item">
                        <span>Distance</span>
                        <strong id="distanceDisplay">5.0 miles (8.0 km)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Time</span>
                        <strong id="timeDisplay">40:00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pace per Mile</span>
                        <strong id="pacePerMileDisplay" style="color: #667eea;">8:00 /mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pace per Kilometer</span>
                        <strong id="pacePerKmDisplay" style="color: #4CAF50;">4:58 /km</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Speed (mph)</span>
                        <strong id="speedMphDisplay">7.5 mph</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Speed (km/h)</span>
                        <strong id="speedKmhDisplay">12.1 km/h</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Race Predictions</h3>
                    <div class="breakdown-item">
                        <span>5K (3.1 miles)</span>
                        <strong id="time5k">24:50</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>10K (6.2 miles)</span>
                        <strong id="time10k">51:39</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Half Marathon (13.1 miles)</span>
                        <strong id="timeHalf">1:54:14</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Marathon (26.2 miles)</span>
                        <strong id="timeMarathon" style="color: #667eea;">3:59:26</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Training Pace Zones</h3>
                    <div class="breakdown-item">
                        <span>Easy Run (60-70%)</span>
                        <strong id="easyPace">9:20 - 10:40 /mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Long Run (65-75%)</span>
                        <strong id="longPace">9:00 - 10:00 /mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tempo Run (80-90%)</span>
                        <strong id="tempoPace" style="color: #FF9800;">7:20 - 8:00 /mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Threshold (85-90%)</span>
                        <strong id="thresholdPace">7:20 - 7:40 /mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interval (95-100%)</span>
                        <strong id="intervalPace" style="color: #f44336;">6:40 - 7:12 /mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Race Pace</span>
                        <strong id="racePaceDisplay" style="color: #4CAF50;">8:00 /mile</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Mile Splits</h3>
                    <div id="mileSplits">
                        <div class="breakdown-item">
                            <span>Mile 1</span>
                            <strong>8:00</strong>
                        </div>
                        <div class="breakdown-item">
                            <span>Mile 2</span>
                            <strong>16:00</strong>
                        </div>
                        <div class="breakdown-item">
                            <span>Mile 3</span>
                            <strong>24:00</strong>
                        </div>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Running Pace</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Pace:</strong> Time per mile/km. Lower = faster. Example: 8:00/mile = 8 minutes to run 1 mile.</p>
                        <p><strong>Speed:</strong> Distance per hour (mph or km/h). Higher = faster. Inverse of pace.</p>
                        <p><strong>Easy Pace:</strong> Conversational. 60-70% effort. Build endurance. 80% of training.</p>
                        <p><strong>Tempo Pace:</strong> Comfortably hard. 80-90% effort. Improves lactate threshold. 20-40 min runs.</p>
                        <p><strong>Interval Pace:</strong> Hard effort. 95-100% max. 3-5 min intervals. Improves VO2 max.</p>
                        <p><strong>Race Pace:</strong> Target pace for race. Practice in training. Varies by distance.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Running Tips:</strong> Track pace for consistency. Easy runs = 80% of training. Speed work 1x/week. Long run 1x/week. Race pace practice. Heat/hills slow pace 20-60 sec/mile. Hydrate well. 180 cadence optimal. Run 3-5x/week. Build mileage 10% per week. Rest days crucial. Negative split = faster second half (ideal). Marathon pace 45-60 sec/mile slower than 10K. Train at various paces. Listen to your body!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('runningForm');
        const calculationType = document.getElementById('calculationType');

        calculationType.addEventListener('change', function() {
            toggleInputFields();
            calculateRunning();
        });

        document.getElementById('raceDistance').addEventListener('change', function() {
            setRaceDistance();
            calculateRunning();
        });

        function toggleInputFields() {
            const type = calculationType.value;
            
            document.getElementById('distanceGroup').style.display = (type === 'pace' || type === 'time') ? 'block' : 'none';
            document.getElementById('raceDistanceGroup').style.display = (type !== 'predict') ? 'block' : 'none';
            document.getElementById('timeGroup').style.display = (type === 'pace' || type === 'distance') ? 'block' : 'none';
            document.getElementById('paceGroup').style.display = (type === 'time' || type === 'distance') ? 'block' : 'none';
            document.getElementById('predictGroup').style.display = (type === 'predict') ? 'block' : 'none';
        }

        function setRaceDistance() {
            const race = document.getElementById('raceDistance').value;
            const unitSystem = document.getElementById('unitSystem').value;
            
            let distance = 0;
            switch(race) {
                case '5k':
                    distance = unitSystem === 'miles' ? 3.107 : 5;
                    break;
                case '10k':
                    distance = unitSystem === 'miles' ? 6.214 : 10;
                    break;
                case 'half':
                    distance = unitSystem === 'miles' ? 13.109 : 21.098;
                    break;
                case 'marathon':
                    distance = unitSystem === 'miles' ? 26.219 : 42.195;
                    break;
                case '50k':
                    distance = unitSystem === 'miles' ? 31.069 : 50;
                    break;
                case '100k':
                    distance = unitSystem === 'miles' ? 62.137 : 100;
                    break;
            }
            
            if (distance > 0) {
                document.getElementById('distance').value = distance.toFixed(3);
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateRunning();
        });

        function calculateRunning() {
            const type = calculationType.value;
            const unitSystem = document.getElementById('unitSystem').value;
            
            if (type === 'predict') {
                calculatePrediction();
                return;
            }
            
            let distanceMiles, totalSeconds;
            
            if (type === 'pace') {
                const distance = parseFloat(document.getElementById('distance').value) || 5;
                distanceMiles = unitSystem === 'miles' ? distance : distance * 0.621371;
                
                const hours = parseInt(document.getElementById('hours').value) || 0;
                const minutes = parseInt(document.getElementById('minutes').value) || 25;
                const seconds = parseInt(document.getElementById('seconds').value) || 0;
                totalSeconds = (hours * 3600) + (minutes * 60) + seconds;
            } else if (type === 'time') {
                const distance = parseFloat(document.getElementById('distance').value) || 5;
                distanceMiles = unitSystem === 'miles' ? distance : distance * 0.621371;
                
                const paceMin = parseInt(document.getElementById('paceMinutes').value) || 8;
                const paceSec = parseInt(document.getElementById('paceSeconds').value) || 0;
                const pacePerMile = (paceMin * 60) + paceSec;
                
                totalSeconds = pacePerMile * distanceMiles;
            } else {
                const hours = parseInt(document.getElementById('hours').value) || 0;
                const minutes = parseInt(document.getElementById('minutes').value) || 25;
                const seconds = parseInt(document.getElementById('seconds').value) || 0;
                totalSeconds = (hours * 3600) + (minutes * 60) + seconds;
                
                const paceMin = parseInt(document.getElementById('paceMinutes').value) || 8;
                const paceSec = parseInt(document.getElementById('paceSeconds').value) || 0;
                const pacePerMile = (paceMin * 60) + paceSec;
                
                distanceMiles = totalSeconds / pacePerMile;
            }

            const pacePerMile = totalSeconds / distanceMiles;
            const pacePerKm = pacePerMile / 1.60934;
            const speedMph = (distanceMiles / totalSeconds) * 3600;
            const speedKmh = speedMph * 1.60934;
            const distanceKm = distanceMiles * 1.60934;

            const time5k = pacePerMile * 3.107;
            const time10k = pacePerMile * 6.214 * 1.03;
            const timeHalf = pacePerMile * 13.109 * 1.08;
            const timeMarathon = pacePerMile * 26.219 * 1.12;

            const easyPaceMin = pacePerMile * 1.15;
            const easyPaceMax = pacePerMile * 1.30;
            const longPaceMin = pacePerMile * 1.10;
            const longPaceMax = pacePerMile * 1.20;
            const tempoPaceMin = pacePerMile * 0.90;
            const tempoPaceMax = pacePerMile;
            const thresholdPaceMin = pacePerMile * 0.90;
            const thresholdPaceMax = pacePerMile * 0.95;
            const intervalPaceMin = pacePerMile * 0.82;
            const intervalPaceMax = pacePerMile * 0.90;

            const formatTime = (secs) => {
                const h = Math.floor(secs / 3600);
                const m = Math.floor((secs % 3600) / 60);
                const s = Math.floor(secs % 60);
                if (h > 0) return `${h}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                return `${m}:${s.toString().padStart(2, '0')}`;
            };
            
            const formatPace = (secs) => {
                const m = Math.floor(secs / 60);
                const s = Math.floor(secs % 60);
                return `${m}:${s.toString().padStart(2, '0')}`;
            };

            let paceCategory = pacePerMile / 60 > 15 ? 'Walking' : pacePerMile / 60 > 11 ? 'Jogging' : pacePerMile / 60 > 8 ? 'Moderate' : pacePerMile / 60 > 6 ? 'Fast' : 'Elite';

            let analysis = `Your running pace is ${formatPace(pacePerMile)} per mile (${formatPace(pacePerKm)} per kilometer), `;
            analysis += `which corresponds to a speed of ${speedMph.toFixed(1)} mph (${speedKmh.toFixed(1)} km/h). `;
            analysis += `This pace falls in the "${paceCategory} Running" category. `;
            
            if (type === 'pace') {
                analysis += `You covered ${distanceMiles.toFixed(2)} miles (${distanceKm.toFixed(2)} km) in ${formatTime(totalSeconds)}. `;
            } else if (type === 'time') {
                analysis += `At this pace, covering ${distanceMiles.toFixed(2)} miles (${distanceKm.toFixed(2)} km) will take ${formatTime(totalSeconds)}. `;
            } else {
                analysis += `Running at this pace for ${formatTime(totalSeconds)}, you would cover ${distanceMiles.toFixed(2)} miles (${distanceKm.toFixed(2)} km). `;
            }
            
            analysis += `Based on this pace, your predicted race times: 5K in ${formatTime(time5k)}, 10K in ${formatTime(time10k)}, half marathon in ${formatTime(timeHalf)}, and full marathon in ${formatTime(timeMarathon)}. `;
            analysis += `For training: easy runs at ${formatPace(easyPaceMin)}-${formatPace(easyPaceMax)}/mile, tempo at ${formatPace(tempoPaceMin)}-${formatPace(tempoPaceMax)}/mile, intervals at ${formatPace(intervalPaceMin)}-${formatPace(intervalPaceMax)}/mile.`;

            document.getElementById('resultTitle').textContent = type === 'pace' ? 'Your Pace' : type === 'time' ? 'Finish Time' : 'Distance Covered';
            document.getElementById('resultValue').textContent = type === 'pace' ? `${formatPace(pacePerMile)} /mile` : type === 'time' ? formatTime(totalSeconds) : `${distanceMiles.toFixed(2)} miles`;
            document.getElementById('resultSubtitle').textContent = `${paceCategory} running pace`;

            document.getElementById('metric1Label').textContent = 'Pace (/mile)';
            document.getElementById('metric1').textContent = formatPace(pacePerMile);
            document.getElementById('metric2Label').textContent = 'Pace (/km)';
            document.getElementById('metric2').textContent = formatPace(pacePerKm);
            document.getElementById('metric3Label').textContent = 'Speed (mph)';
            document.getElementById('metric3').textContent = speedMph.toFixed(1);
            document.getElementById('metric4Label').textContent = 'Speed (km/h)';
            document.getElementById('metric4').textContent = speedKmh.toFixed(1);

            document.getElementById('distanceDisplay').textContent = `${distanceMiles.toFixed(2)} miles (${distanceKm.toFixed(2)} km)`;
            document.getElementById('timeDisplay').textContent = formatTime(totalSeconds);
            document.getElementById('pacePerMileDisplay').textContent = `${formatPace(pacePerMile)} /mile`;
            document.getElementById('pacePerKmDisplay').textContent = `${formatPace(pacePerKm)} /km`;
            document.getElementById('speedMphDisplay').textContent = `${speedMph.toFixed(1)} mph`;
            document.getElementById('speedKmhDisplay').textContent = `${speedKmh.toFixed(1)} km/h`;

            document.getElementById('time5k').textContent = formatTime(time5k);
            document.getElementById('time10k').textContent = formatTime(time10k);
            document.getElementById('timeHalf').textContent = formatTime(timeHalf);
            document.getElementById('timeMarathon').textContent = formatTime(timeMarathon);

            document.getElementById('easyPace').textContent = `${formatPace(easyPaceMin)} - ${formatPace(easyPaceMax)} /mile`;
            document.getElementById('longPace').textContent = `${formatPace(longPaceMin)} - ${formatPace(longPaceMax)} /mile`;
            document.getElementById('tempoPace').textContent = `${formatPace(tempoPaceMin)} - ${formatPace(tempoPaceMax)} /mile`;
            document.getElementById('thresholdPace').textContent = `${formatPace(thresholdPaceMin)} - ${formatPace(thresholdPaceMax)} /mile`;
            document.getElementById('intervalPace').textContent = `${formatPace(intervalPaceMin)} - ${formatPace(intervalPaceMax)} /mile`;
            document.getElementById('racePaceDisplay').textContent = `${formatPace(pacePerMile)} /mile`;

            const splitsHTML = [];
            for (let i = 1; i <= Math.ceil(distanceMiles); i++) {
                const splitTime = pacePerMile * i;
                splitsHTML.push(`<div class="breakdown-item"><span>Mile ${i}</span><strong>${formatTime(splitTime)}</strong></div>`);
            }
            document.getElementById('mileSplits').innerHTML = splitsHTML.join('');

            document.getElementById('analysisText').textContent = analysis;
        }

        function calculatePrediction() {
            const recentRace = document.getElementById('recentRaceDistance').value;
            const targetRace = document.getElementById('targetRaceDistance').value;
            
            const recentHours = parseInt(document.getElementById('recentHours').value) || 0;
            const recentMinutes = parseInt(document.getElementById('recentMinutes').value) || 50;
            const recentSeconds = parseInt(document.getElementById('recentSeconds').value) || 0;
            const recentTime = (recentHours * 3600) + (recentMinutes * 60) + recentSeconds;

            const distances = {
                '5k': 3.107,
                '10k': 6.214,
                'half': 13.109,
                'marathon': 26.219
            };

            const recentDist = distances[recentRace];
            const targetDist = distances[targetRace];

            const recentPace = recentTime / recentDist;
            const ratio = Math.pow(targetDist / recentDist, 1.06);
            const predictedTime = recentTime * ratio;

            const predictedPace = predictedTime / targetDist;

            const formatTime = (secs) => {
                const h = Math.floor(secs / 3600);
                const m = Math.floor((secs % 3600) / 60);
                const s = Math.floor(secs % 60);
                if (h > 0) return `${h}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                return `${m}:${s.toString().padStart(2, '0')}`;
            };

            const formatPace = (secs) => {
                const m = Math.floor(secs / 60);
                const s = Math.floor(secs % 60);
                return `${m}:${s.toString().padStart(2, '0')}`;
            };

            const raceNames = {
                '5k': '5K',
                '10k': '10K',
                'half': 'Half Marathon',
                'marathon': 'Marathon'
            };

            document.getElementById('resultTitle').textContent = `Predicted ${raceNames[targetRace]} Time`;
            document.getElementById('resultValue').textContent = formatTime(predictedTime);
            document.getElementById('resultSubtitle').textContent = `Based on ${raceNames[recentRace]} result`;

            document.getElementById('metric1').textContent = formatTime(predictedTime);
            document.getElementById('metric2').textContent = formatPace(predictedPace);
            document.getElementById('metric3').textContent = formatTime(recentTime);
            document.getElementById('metric4').textContent = formatPace(recentPace);

            const analysis = `Based on your recent ${raceNames[recentRace]} time of ${formatTime(recentTime)} (${formatPace(recentPace)}/mile pace), your predicted ${raceNames[targetRace]} time is ${formatTime(predictedTime)} at a ${formatPace(predictedPace)}/mile pace. This prediction uses the Riegel formula accounting for distance and fatigue. Train consistently, practice race pace, and adjust for course difficulty and weather conditions.`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleInputFields();
            calculateRunning();
        });
    </script>
</body>
</html>