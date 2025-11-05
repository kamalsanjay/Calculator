<?php
/**
 * Pace Calculator
 * File: pace-calculator.php
 * Description: Calculate running/walking pace, speed, time, and distance
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pace Calculator - Running Pace & Speed Calculator (min/mile, min/km)</title>
    <meta name="description" content="Free pace calculator. Calculate running pace (min/mile, min/km), speed (mph, km/h), time, and distance. Plan your race pace and training runs.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🏃 Pace Calculator</h1>
        <p>Calculate pace, speed, time & distance</p>
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
                <form id="paceForm">
                    <div class="form-group">
                        <label for="calculationType">Calculate</label>
                        <select id="calculationType">
                            <option value="pace">Pace (from time & distance)</option>
                            <option value="time">Time (from pace & distance)</option>
                            <option value="distance">Distance (from pace & time)</option>
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
                        <small>Distance covered</small>
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
                        <label>Pace (per mile/km)</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="paceMinutes" value="8" min="0" max="60" step="1" style="flex: 1;" placeholder="Minutes">
                            <input type="number" id="paceSeconds" value="0" min="0" max="59" step="1" style="flex: 1;" placeholder="Seconds">
                        </div>
                        <small>Minutes : Seconds per mile/km</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Race Distance (Optional)</h3>
                    
                    <div class="form-group">
                        <label for="raceDistance">Common Race</label>
                        <select id="raceDistance">
                            <option value="custom">Custom Distance</option>
                            <option value="5k">5K (3.1 miles)</option>
                            <option value="10k">10K (6.2 miles)</option>
                            <option value="half">Half Marathon (13.1 miles)</option>
                            <option value="marathon">Marathon (26.2 miles)</option>
                            <option value="50k">50K Ultra (31 miles)</option>
                            <option value="100k">100K Ultra (62 miles)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Pace</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Pace Results</h2>
                
                <div class="result-card success">
                    <h3>Your Pace</h3>
                    <div class="amount" id="paceResult">8:00 /mile</div>
                    <div style="margin-top: 10px; font-size: 1em;">Time per mile/kilometer</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Pace (/mile)</h4>
                        <div class="value" id="pacePerMile">8:00</div>
                    </div>
                    <div class="metric-card">
                        <h4>Pace (/km)</h4>
                        <div class="value" id="pacePerKm">4:58</div>
                    </div>
                    <div class="metric-card">
                        <h4>Speed (mph)</h4>
                        <div class="value" id="speedMph">7.5</div>
                    </div>
                    <div class="metric-card">
                        <h4>Speed (km/h)</h4>
                        <div class="value" id="speedKmh">12.1</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Run Summary</h3>
                    <div class="breakdown-item">
                        <span>Distance</span>
                        <strong id="distanceDisplay">5.0 miles (8.0 km)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Time</span>
                        <strong id="timeDisplay">25:00</strong>
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
                    <h3>Race Time Predictions</h3>
                    <div class="breakdown-item">
                        <span>5K (3.1 miles)</span>
                        <strong id="time5k">24:50</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>10K (6.2 miles)</span>
                        <strong id="time10k">49:40</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Half Marathon (13.1 miles)</span>
                        <strong id="timeHalf">1:44:48</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Marathon (26.2 miles)</span>
                        <strong id="timeMarathon" style="color: #667eea;">3:29:36</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>50K Ultra (31 miles)</span>
                        <strong id="time50k">4:08:00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Training Paces</h3>
                    <div class="breakdown-item">
                        <span>Easy Run (60-70% effort)</span>
                        <strong id="easyPace">9:20 - 10:40 /mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Long Run (65-75% effort)</span>
                        <strong id="longPace">9:00 - 10:00 /mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tempo Run (80-90% effort)</span>
                        <strong id="tempoPace" style="color: #FF9800;">7:20 - 8:00 /mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Threshold (85-90% effort)</span>
                        <strong id="thresholdPace">7:20 - 7:40 /mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interval (95-100% effort)</span>
                        <strong id="intervalPace" style="color: #f44336;">6:40 - 7:12 /mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Race Pace</span>
                        <strong id="racePace" style="color: #4CAF50;">8:00 /mile</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Pace Categories</h3>
                    <div class="breakdown-item">
                        <span>Your Current Pace</span>
                        <strong id="paceCategory" style="color: #667eea; font-size: 1.1em;">8:00 /mile (Moderate)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Walking Pace</span>
                        <strong>15-20 min/mile (3-4 mph)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Jogging Pace</span>
                        <strong>11-15 min/mile (4-5.5 mph)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Moderate Running</span>
                        <strong>8-11 min/mile (5.5-7.5 mph)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fast Running</span>
                        <strong>6-8 min/mile (7.5-10 mph)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Elite Running</span>
                        <strong>&lt;6 min/mile (&gt;10 mph)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Pace</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>What is Pace?</strong> Time taken to cover one unit of distance (e.g., 8:00 per mile = 8 minutes to run 1 mile). Lower pace = faster running.</p>
                        <p><strong>Pace vs Speed:</strong> Pace = time/distance (min/mile). Speed = distance/time (mph). Inverse relationship: faster pace = higher speed.</p>
                        <p><strong>Why Track Pace?</strong> Consistency in training, race planning, progress tracking, appropriate training intensity, avoiding over/under-training.</p>
                        <p><strong>Common Units:</strong> Minutes per mile (min/mile) - US standard. Minutes per kilometer (min/km) - metric/international. Speed in mph or km/h.</p>
                        <p><strong>Conversions:</strong> 1 mile = 1.609 km. 1 km = 0.621 miles. Pace per km is ~0.621× pace per mile (faster number).</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Training Pace Zones</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Easy/Recovery Pace (60-70% max HR):</strong> Comfortable conversational pace. Build aerobic base. 80% of training should be here. Can talk in full sentences.</p>
                        <p><strong>Long Run Pace (65-75% max HR):</strong> Slightly slower than easy. Build endurance. Weekly long run at this pace. Should feel sustainable for hours.</p>
                        <p><strong>Tempo/Steady State (80-90% max HR):</strong> Comfortably hard. Improves lactate threshold. 20-40 min sustained efforts. Can speak short phrases.</p>
                        <p><strong>Threshold Pace (85-90% max HR):</strong> Challenging but maintainable for ~60 min. Max sustainable pace. Just below anaerobic threshold.</p>
                        <p><strong>Interval/VO2 Max (95-100% max HR):</strong> Very hard. 3-5 min intervals. Improves max oxygen uptake. Can only say few words. Need recovery between intervals.</p>
                        <p><strong>Race Pace:</strong> Target pace for race. Practice in training. Varies by distance: shorter races = faster pace. Marathon pace slower than 5K pace.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Race Pace Strategy</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>5K Race:</strong> Fast pace. Start slightly slower first mile, increase to race pace, strong finish last 0.5 mile. All-out effort. 95-100% max HR.</p>
                        <p><strong>10K Race:</strong> Controlled fast pace. Even splits ideal. Don't go out too fast. 90-95% max HR. Slight positive or negative split.</p>
                        <p><strong>Half Marathon:</strong> Steady pace throughout. Start conservatively. Negative split recommended (faster second half). 85-90% max HR.</p>
                        <p><strong>Marathon:</strong> Conservative pacing critical. Start 10-15 sec/mile slower than goal. Even pace through 20 miles. Positive split expected (second half slower). 80-85% max HR.</p>
                        <p><strong>Ultra Marathon:</strong> Very conservative. Walk breaks common. Focus on finishing, not speed. Run/walk strategy. 70-80% max HR.</p>
                        <p><strong>Golden Rule:</strong> Never go out too fast. Better to negative split than blow up. Most common mistake = starting too fast.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Factors Affecting Pace</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Terrain:</strong> Hills slow pace 15-30 sec/mile per % grade. Trail running 30-60 sec/mile slower. Downhill can be faster but harder on legs.</p>
                        <p><strong>Weather:</strong> Heat/humidity slow pace 20-60 sec/mile. Cold/wind can add 10-30 sec/mile. Ideal conditions: 45-60°F, low humidity, calm.</p>
                        <p><strong>Altitude:</strong> Elevation slows pace. Above 5,000 ft, add 10-30 sec/mile. Thin air reduces oxygen. Acclimatization takes 2-3 weeks.</p>
                        <p><strong>Fatigue:</strong> Tired legs from previous workouts. Insufficient recovery. Overtraining slows pace significantly.</p>
                        <p><strong>Hydration/Nutrition:</strong> Dehydration slows pace. Inadequate fueling during long runs. Bonking (glycogen depletion) dramatic slowdown.</p>
                        <p><strong>Experience:</strong> Beginners slower. Pacing improves with training. Seasoned runners more consistent pace.</p>
                        <p><strong>Age/Fitness:</strong> Peak performance 25-35 years. Gradual decline after. Higher fitness = faster pace. Training improves pace over time.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How to Improve Your Pace</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Consistency:</strong> Run regularly. 3-5x per week. Build mileage gradually (10% per week max).</p>
                        <p>&#10003; <strong>Easy Runs:</strong> 80% of training at easy pace. Builds aerobic base without overtraining.</p>
                        <p>&#10003; <strong>Speed Work:</strong> Weekly intervals or tempo runs. Improves VO2 max and lactate threshold.</p>
                        <p>&#10003; <strong>Long Runs:</strong> Weekly long run. Builds endurance. Increase distance gradually.</p>
                        <p>&#10003; <strong>Strength Training:</strong> 2x per week. Squats, lunges, deadlifts. Improves running economy and injury prevention.</p>
                        <p>&#10003; <strong>Hill Training:</strong> Hills build power and strength. Include weekly hill repeats or hilly routes.</p>
                        <p>&#10003; <strong>Proper Form:</strong> Midfoot strike, 180 cadence, relaxed shoulders, forward lean.</p>
                        <p>&#10003; <strong>Recovery:</strong> Rest days crucial. Sleep 7-9 hours. Easy weeks every 3-4 weeks.</p>
                        <p>&#10003; <strong>Nutrition:</strong> Adequate calories, protein for recovery. Carbs for energy. Hydration critical.</p>
                        <p>&#10003; <strong>Patience:</strong> Pace improves over months/years. Trust the process. Avoid comparing to others.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Pace Tips:</strong> Pace = time per mile/km. Lower number = faster. Speed = mph/kmh. Higher = faster. Track pace for consistent training. Easy pace = conversational (60-70% effort). Tempo = comfortably hard (80-90%). Intervals = very hard (95-100%). 80% of training should be easy pace. Don't go out too fast in races. Negative split = faster second half (ideal). Marathon pace 45-60 sec/mile slower than 10K. Heat/hills slow pace 20-60 sec/mile. Run 3-5x per week. Build mileage 10% per week max. Speed work 1x per week. Long run 1x per week. Strength train 2x per week. 180 steps/min cadence optimal. Rest days crucial. Be patient - pace improves gradually!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('paceForm');
        const calculationType = document.getElementById('calculationType');

        calculationType.addEventListener('change', function() {
            toggleInputFields();
            calculatePace();
        });

        function toggleInputFields() {
            const type = calculationType.value;
            
            document.getElementById('distanceGroup').style.display = type !== 'distance' ? 'block' : 'none';
            document.getElementById('timeGroup').style.display = type !== 'time' ? 'block' : 'none';
            document.getElementById('paceGroup').style.display = type === 'pace' ? 'none' : 'block';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculatePace();
        });

        document.getElementById('raceDistance').addEventListener('change', function() {
            const race = this.value;
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
                document.getElementById('distance').value = distance.toFixed(2);
                calculatePace();
            }
        });

        function calculatePace() {
            const type = calculationType.value;
            const unitSystem = document.getElementById('unitSystem').value;
            
            let distanceMiles, totalSeconds;
            
            // Get or calculate values based on type
            if (type === 'pace') {
                // Calculate pace from distance and time
                const distance = parseFloat(document.getElementById('distance').value) || 5;
                distanceMiles = unitSystem === 'miles' ? distance : distance * 0.621371;
                
                const hours = parseInt(document.getElementById('hours').value) || 0;
                const minutes = parseInt(document.getElementById('minutes').value) || 25;
                const seconds = parseInt(document.getElementById('seconds').value) || 0;
                totalSeconds = (hours * 3600) + (minutes * 60) + seconds;
            } else if (type === 'time') {
                // Calculate time from pace and distance
                const distance = parseFloat(document.getElementById('distance').value) || 5;
                distanceMiles = unitSystem === 'miles' ? distance : distance * 0.621371;
                
                const paceMin = parseInt(document.getElementById('paceMinutes').value) || 8;
                const paceSec = parseInt(document.getElementById('paceSeconds').value) || 0;
                const pacePerMile = (paceMin * 60) + paceSec;
                
                totalSeconds = pacePerMile * distanceMiles;
            } else {
                // Calculate distance from pace and time
                const hours = parseInt(document.getElementById('hours').value) || 0;
                const minutes = parseInt(document.getElementById('minutes').value) || 25;
                const seconds = parseInt(document.getElementById('seconds').value) || 0;
                totalSeconds = (hours * 3600) + (minutes * 60) + seconds;
                
                const paceMin = parseInt(document.getElementById('paceMinutes').value) || 8;
                const paceSec = parseInt(document.getElementById('paceSeconds').value) || 0;
                const pacePerMile = (paceMin * 60) + paceSec;
                
                distanceMiles = totalSeconds / pacePerMile;
            }

            // Calculate pace per mile (seconds)
            const pacePerMile = totalSeconds / distanceMiles;
            const pacePerKm = pacePerMile / 1.60934;
            
            // Calculate speed
            const speedMph = (distanceMiles / totalSeconds) * 3600;
            const speedKmh = speedMph * 1.60934;
            
            // Format time
            const formatTime = (secs) => {
                const h = Math.floor(secs / 3600);
                const m = Math.floor((secs % 3600) / 60);
                const s = Math.floor(secs % 60);
                
                if (h > 0) {
                    return `${h}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                } else {
                    return `${m}:${s.toString().padStart(2, '0')}`;
                }
            };
            
            // Format pace
            const formatPace = (secs) => {
                const m = Math.floor(secs / 60);
                const s = Math.floor(secs % 60);
                return `${m}:${s.toString().padStart(2, '0')}`;
            };

            // Distance conversions
            const distanceKm = distanceMiles * 1.60934;

            // Race predictions (adjusted for distance)
            const time5k = (pacePerMile * 3.107);
            const time10k = (pacePerMile * 6.214);
            const timeHalf = (pacePerMile * 13.109) * 1.05; // Add 5% for longer distance
            const timeMarathon = (pacePerMile * 26.219) * 1.10; // Add 10% for marathon
            const time50k = (pacePerMile * 31.069) * 1.15;

            // Training paces (percentages of race pace)
            const easyPaceMin = pacePerMile * 1.15;
            const easyPaceMax = pacePerMile * 1.30;
            const longPaceMin = pacePerMile * 1.10;
            const longPaceMax = pacePerMile * 1.20;
            const tempoPaceMin = pacePerMile * 0.90;
            const tempoPaceMax = pacePerMile * 1.00;
            const thresholdPaceMin = pacePerMile * 0.90;
            const thresholdPaceMax = pacePerMile * 0.95;
            const intervalPaceMin = pacePerMile * 0.82;
            const intervalPaceMax = pacePerMile * 0.90;

            // Pace category
            let paceCategory = '';
            const paceMinutes = pacePerMile / 60;
            if (paceMinutes > 15) {
                paceCategory = 'Walking';
            } else if (paceMinutes > 11) {
                paceCategory = 'Jogging';
            } else if (paceMinutes > 8) {
                paceCategory = 'Moderate Running';
            } else if (paceMinutes > 6) {
                paceCategory = 'Fast Running';
            } else {
                paceCategory = 'Elite Running';
            }

            // Analysis
            let analysis = `Your running pace is ${formatPace(pacePerMile)} per mile (${formatPace(pacePerKm)} per kilometer), `;
            analysis += `which corresponds to a speed of ${speedMph.toFixed(1)} mph (${speedKmh.toFixed(1)} km/h). `;
            
            if (type === 'pace') {
                analysis += `You covered ${distanceMiles.toFixed(2)} miles (${distanceKm.toFixed(2)} km) in ${formatTime(totalSeconds)}. `;
            } else if (type === 'time') {
                analysis += `At this pace, covering ${distanceMiles.toFixed(2)} miles (${distanceKm.toFixed(2)} km) will take ${formatTime(totalSeconds)}. `;
            } else {
                analysis += `Running at this pace for ${formatTime(totalSeconds)}, you would cover ${distanceMiles.toFixed(2)} miles (${distanceKm.toFixed(2)} km). `;
            }
            
            analysis += `This pace falls in the "${paceCategory}" category. `;
            
            analysis += `Based on this pace, your predicted race times would be approximately ${formatTime(time5k)} for a 5K, `;
            analysis += `${formatTime(time10k)} for a 10K, ${formatTime(timeHalf)} for a half marathon, `;
            analysis += `and ${formatTime(timeMarathon)} for a full marathon. `;
            
            analysis += `For training, your easy runs should be at ${formatPace(easyPaceMin)}-${formatPace(easyPaceMax)} per mile, `;
            analysis += `tempo runs at ${formatPace(tempoPaceMin)}-${formatPace(tempoPaceMax)} per mile, `;
            analysis += `and interval training at ${formatPace(intervalPaceMin)}-${formatPace(intervalPaceMax)} per mile. `;
            
            analysis += `Remember that most of your training (80%) should be at an easy, conversational pace. `;
            analysis += `Speed work and tempo runs should only make up 20% of your weekly mileage to avoid overtraining and injury.`;

            // Update UI
            document.getElementById('paceResult').textContent = `${formatPace(pacePerMile)} /mile`;
            document.getElementById('pacePerMile').textContent = formatPace(pacePerMile);
            document.getElementById('pacePerKm').textContent = formatPace(pacePerKm);
            document.getElementById('speedMph').textContent = speedMph.toFixed(1);
            document.getElementById('speedKmh').textContent = speedKmh.toFixed(1);

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
            document.getElementById('time50k').textContent = formatTime(time50k);

            document.getElementById('easyPace').textContent = `${formatPace(easyPaceMin)} - ${formatPace(easyPaceMax)} /mile`;
            document.getElementById('longPace').textContent = `${formatPace(longPaceMin)} - ${formatPace(longPaceMax)} /mile`;
            document.getElementById('tempoPace').textContent = `${formatPace(tempoPaceMin)} - ${formatPace(tempoPaceMax)} /mile`;
            document.getElementById('thresholdPace').textContent = `${formatPace(thresholdPaceMin)} - ${formatPace(thresholdPaceMax)} /mile`;
            document.getElementById('intervalPace').textContent = `${formatPace(intervalPaceMin)} - ${formatPace(intervalPaceMax)} /mile`;
            document.getElementById('racePace').textContent = `${formatPace(pacePerMile)} /mile`;

            document.getElementById('paceCategory').textContent = `${formatPace(pacePerMile)} /mile (${paceCategory})`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleInputFields();
            calculatePace();
        });
    </script>
</body>
</html>