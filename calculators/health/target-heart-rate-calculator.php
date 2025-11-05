<?php
/**
 * Target Heart Rate Calculator
 * File: target-heart-rate-calculator.php
 * Description: Calculate target heart rate zones for exercise and training
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Target Heart Rate Calculator - Heart Rate Zones & Max HR Calculator</title>
    <meta name="description" content="Free target heart rate calculator. Calculate max heart rate, training zones, fat burn zone, cardio zone, and optimal heart rate for exercise.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>❤️ Target Heart Rate Calculator</h1>
        <p>Calculate heart rate zones for training</p>
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
                <h2>Your Information</h2>
                <form id="heartRateForm">
                    <div class="form-group">
                        <label for="age">Age (years)</label>
                        <input type="number" id="age" value="30" min="15" max="100" step="1" required>
                        <small>Your current age</small>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Resting Heart Rate (Optional)</h3>
                    
                    <div class="form-group">
                        <label for="restingHR">Resting Heart Rate (bpm)</label>
                        <input type="number" id="restingHR" value="" min="40" max="100" step="1" placeholder="Optional">
                        <small>Measure first thing in morning before getting up</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Fitness Level</h3>
                    
                    <div class="form-group">
                        <label for="fitnessLevel">Fitness Level</label>
                        <select id="fitnessLevel">
                            <option value="beginner">Beginner (Little/no exercise)</option>
                            <option value="intermediate" selected>Intermediate (Regular exercise)</option>
                            <option value="advanced">Advanced (Athlete/Very fit)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="activityType">Primary Activity Type</label>
                        <select id="activityType">
                            <option value="general">General Fitness</option>
                            <option value="cardio">Cardio/Running</option>
                            <option value="hiit">HIIT/Interval Training</option>
                            <option value="weightloss">Weight Loss</option>
                            <option value="endurance">Endurance Training</option>
                            <option value="cycling">Cycling</option>
                            <option value="swimming">Swimming</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Heart Rate Zones</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Heart Rate Results</h2>
                
                <div class="result-card success">
                    <h3>Maximum Heart Rate</h3>
                    <div class="amount" id="maxHRResult">190 bpm</div>
                    <div style="margin-top: 10px; font-size: 1em;">Your estimated max heart rate</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Max HR</h4>
                        <div class="value" id="maxHRDisplay">190</div>
                    </div>
                    <div class="metric-card">
                        <h4>Resting HR</h4>
                        <div class="value" id="restingHRDisplay">60</div>
                    </div>
                    <div class="metric-card">
                        <h4>Reserve HR</h4>
                        <div class="value" id="reserveHRDisplay">130</div>
                    </div>
                    <div class="metric-card">
                        <h4>Target Zone</h4>
                        <div class="value" id="targetZoneDisplay">133-152</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Profile</h3>
                    <div class="breakdown-item">
                        <span>Age</span>
                        <strong id="ageDisplay">30 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gender</span>
                        <strong id="genderDisplay">Male</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Resting Heart Rate</span>
                        <strong id="restingDisplay">60 bpm (Good)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Maximum Heart Rate</span>
                        <strong id="maxDisplay" style="color: #f44336;">190 bpm</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Heart Rate Reserve</span>
                        <strong id="reserveDisplay">130 bpm</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fitness Level</span>
                        <strong id="fitnessDisplay">Intermediate</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Training Heart Rate Zones</h3>
                    <div class="breakdown-item">
                        <span>Zone 1: Very Light (50-60%)</span>
                        <strong id="zone1" style="color: #4CAF50;">95-114 bpm - Warm up, cool down</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Zone 2: Light (60-70%)</span>
                        <strong id="zone2" style="color: #8BC34A;">114-133 bpm - Fat burn, recovery</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Zone 3: Moderate (70-80%)</span>
                        <strong id="zone3" style="color: #FF9800;">133-152 bpm - Aerobic, endurance</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Zone 4: Hard (80-90%)</span>
                        <strong id="zone4" style="color: #FF5722;">152-171 bpm - Anaerobic, performance</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Zone 5: Maximum (90-100%)</span>
                        <strong id="zone5" style="color: #f44336;">171-190 bpm - Max effort, sprints</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Recommended Zones by Goal</h3>
                    <div class="breakdown-item">
                        <span>Fat Burning (60-70%)</span>
                        <strong id="fatBurnZone" style="color: #4CAF50;">114-133 bpm</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cardio Fitness (70-80%)</span>
                        <strong id="cardioZone" style="color: #FF9800;">133-152 bpm</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Performance Training (80-90%)</span>
                        <strong id="performanceZone" style="color: #FF5722;">152-171 bpm</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Peak Performance (90-95%)</span>
                        <strong id="peakZone" style="color: #f44336;">171-181 bpm</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Heart Rate Zone Details</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Zone 1 (50-60% Max HR):</strong> Very light intensity. Warm-up, cool-down, active recovery. Can hold conversation easily. Minimal fitness benefit but important for recovery.</p>
                        <p><strong>Zone 2 (60-70% Max HR):</strong> Light intensity. Fat burning zone. Improves basic endurance. Can still talk comfortably. Most calories from fat. Good for long duration exercise (60+ min).</p>
                        <p><strong>Zone 3 (70-80% Max HR):</strong> Moderate intensity. Aerobic zone. Improves cardiovascular fitness. Breathing harder but can speak in sentences. Mix of fat and carb burning. Sweet spot for most training.</p>
                        <p><strong>Zone 4 (80-90% Max HR):</strong> Hard intensity. Anaerobic zone. Improves speed and power. Breathing very hard, can only say few words. Mostly carb burning. Higher lactate production.</p>
                        <p><strong>Zone 5 (90-100% Max HR):</strong> Maximum effort. VO2 max. Very short bursts (30 sec - 2 min). Sprints, HIIT. Cannot speak. Max calorie burn but unsustainable. Only for advanced athletes.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Resting Heart Rate</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>What is Resting Heart Rate?</strong> Number of heartbeats per minute when completely at rest. Best measured first thing in morning before getting out of bed.</p>
                        <p><strong>Normal Ranges:</strong> Adults: 60-100 bpm. Athletes: 40-60 bpm. Lower = better cardiovascular fitness (generally).</p>
                        <p><strong>Excellent:</strong> &lt;60 bpm (very fit). <strong>Good:</strong> 60-70 bpm. <strong>Average:</strong> 70-80 bpm. <strong>Below Average:</strong> 80-90 bpm. <strong>Poor:</strong> &gt;90 bpm.</p>
                        <p><strong>Factors Affecting:</strong> Fitness level (biggest factor), age, stress, caffeine, medications, dehydration, illness, temperature, body position.</p>
                        <p><strong>Improving:</strong> Regular cardio exercise (lowers over time), stress reduction, adequate sleep, healthy diet, hydration. Can drop 10-20 bpm with consistent training.</p>
                        <p><strong>When to Worry:</strong> Consistently &gt;100 bpm (tachycardia) or &lt;40 bpm (not athlete) = see doctor. Sudden changes = see doctor. Irregular rhythm = see doctor.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Training by Heart Rate Zones</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>80/20 Rule:</strong> Spend 80% of training time in Zones 1-2 (easy), 20% in Zones 3-5 (hard). Prevents overtraining, builds aerobic base, allows recovery.</p>
                        <p><strong>Beginner (Weeks 1-8):</strong> Focus on Zone 2 (60-70%). Build base fitness. 3-4x per week, 20-30 min. Don't push too hard too soon.</p>
                        <p><strong>Intermediate:</strong> 70% Zone 2, 20% Zone 3, 10% Zone 4. Mix steady-state and intervals. 4-5x per week. One long Zone 2 session weekly.</p>
                        <p><strong>Advanced:</strong> All zones incorporated. Periodized training. Zone 2 base, Zone 4-5 intervals, Zone 3 tempo runs. 5-6x per week. Specific to goals.</p>
                        <p><strong>Weight Loss:</strong> Zone 2 (60-70%) for fat burning. Longer duration (45-60 min). 4-5x per week. Add Zone 4 intervals 1-2x per week for metabolism boost.</p>
                        <p><strong>Performance:</strong> Zone 4-5 intervals for speed and power. Zone 2-3 for endurance. Periodized plan with build and recovery weeks.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How to Measure Heart Rate</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Manual (Pulse):</strong> Find pulse at wrist (radial artery) or neck (carotid artery). Count beats for 15 seconds. Multiply by 4. Not accurate during exercise.</p>
                        <p><strong>Heart Rate Monitor (Chest Strap):</strong> Most accurate. Worn around chest. Transmits to watch/phone. Real-time data. Gold standard for training. ~$50-200.</p>
                        <p><strong>Fitness Watch/Smartwatch:</strong> Optical sensor on wrist. Convenient, worn all day. Less accurate during HIIT/cold weather. Good enough for most people. Apple Watch, Garmin, Fitbit, etc.</p>
                        <p><strong>Treadmill/Equipment:</strong> Grip sensors on handles. Least accurate. OK for general idea but not training zones. Don't rely on these.</p>
                        <p><strong>Apps:</strong> Smartphone camera measures pulse via fingertip. Convenient for resting HR. Not suitable for exercise tracking.</p>
                        <p><strong>Best Practice:</strong> Chest strap for serious training. Wrist-based for casual fitness. Check resting HR manually each morning for trends.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Heart Rate Tips:</strong> Max HR = 220 - age (estimate). Resting HR improves with fitness. Zone 2 (60-70%) = fat burn, easy pace. Zone 3 (70-80%) = cardio fitness. Zone 4 (80-90%) = performance. Zone 5 (90-100%) = max effort. Train 80% in Zones 1-2, 20% in Zones 3-5. Heart rate monitor (chest strap) most accurate. Lower resting HR = better fitness. Normal: 60-100 bpm. Athletes: 40-60 bpm. Measure resting HR in morning before rising. Stay hydrated - dehydration raises HR. Overtraining = elevated resting HR. Listen to your body. HR zones are guidelines, not absolutes. Adjust based on feel!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('heartRateForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateHeartRate();
        });

        function calculateHeartRate() {
            const age = parseInt(document.getElementById('age').value) || 30;
            const gender = document.getElementById('gender').value;
            const restingHRInput = document.getElementById('restingHR').value;
            const fitnessLevel = document.getElementById('fitnessLevel').value;
            const activityType = document.getElementById('activityType').value;

            // Calculate maximum heart rate (220 - age is standard, but we can adjust for gender)
            let maxHR = gender === 'male' ? 220 - age : 226 - age;

            // Estimate resting HR if not provided
            let restingHR;
            if (restingHRInput && restingHRInput.trim() !== '') {
                restingHR = parseInt(restingHRInput);
            } else {
                // Estimate based on fitness level
                if (fitnessLevel === 'beginner') {
                    restingHR = gender === 'male' ? 75 : 78;
                } else if (fitnessLevel === 'intermediate') {
                    restingHR = gender === 'male' ? 65 : 68;
                } else {
                    restingHR = gender === 'male' ? 55 : 58;
                }
            }

            // Heart rate reserve (HRR) = Max HR - Resting HR
            const heartRateReserve = maxHR - restingHR;

            // Calculate zones using Karvonen formula (HRR method)
            const zone1Min = Math.round(restingHR + (heartRateReserve * 0.50));
            const zone1Max = Math.round(restingHR + (heartRateReserve * 0.60));
            
            const zone2Min = zone1Max;
            const zone2Max = Math.round(restingHR + (heartRateReserve * 0.70));
            
            const zone3Min = zone2Max;
            const zone3Max = Math.round(restingHR + (heartRateReserve * 0.80));
            
            const zone4Min = zone3Max;
            const zone4Max = Math.round(restingHR + (heartRateReserve * 0.90));
            
            const zone5Min = zone4Max;
            const zone5Max = maxHR;

            // Fat burning zone (60-70%)
            const fatBurnMin = zone2Min;
            const fatBurnMax = zone2Max;

            // Cardio zone (70-80%)
            const cardioMin = zone3Min;
            const cardioMax = zone3Max;

            // Performance zone (80-90%)
            const performanceMin = zone4Min;
            const performanceMax = zone4Max;

            // Peak zone (90-95%)
            const peakMin = zone5Min;
            const peakMax = Math.round(restingHR + (heartRateReserve * 0.95));

            // Determine resting HR quality
            let restingQuality = '';
            if (restingHR < 60) {
                restingQuality = 'Excellent (Athletic)';
            } else if (restingHR < 70) {
                restingQuality = 'Good';
            } else if (restingHR < 80) {
                restingQuality = 'Average';
            } else if (restingHR < 90) {
                restingQuality = 'Below Average';
            } else {
                restingQuality = 'Poor - Consider seeing doctor';
            }

            // Fitness level names
            const fitnessNames = {
                'beginner': 'Beginner',
                'intermediate': 'Intermediate',
                'advanced': 'Advanced'
            };

            const activityNames = {
                'general': 'General Fitness',
                'cardio': 'Cardio/Running',
                'hiit': 'HIIT/Interval Training',
                'weightloss': 'Weight Loss',
                'endurance': 'Endurance Training',
                'cycling': 'Cycling',
                'swimming': 'Swimming'
            };

            // Recommended zone based on activity
            let recommendedZone = '';
            let recommendedZoneRange = '';
            
            switch(activityType) {
                case 'weightloss':
                    recommendedZone = 'Zone 2 (60-70%) - Fat Burning';
                    recommendedZoneRange = `${fatBurnMin}-${fatBurnMax} bpm`;
                    break;
                case 'cardio':
                case 'general':
                    recommendedZone = 'Zone 3 (70-80%) - Cardio Fitness';
                    recommendedZoneRange = `${cardioMin}-${cardioMax} bpm`;
                    break;
                case 'hiit':
                    recommendedZone = 'Zones 4-5 (80-100%) - High Intensity';
                    recommendedZoneRange = `${performanceMin}-${maxHR} bpm`;
                    break;
                case 'endurance':
                    recommendedZone = 'Zone 2 (60-70%) - Base Building';
                    recommendedZoneRange = `${fatBurnMin}-${fatBurnMax} bpm`;
                    break;
                default:
                    recommendedZone = 'Zone 3 (70-80%) - Moderate';
                    recommendedZoneRange = `${cardioMin}-${cardioMax} bpm`;
            }

            // Analysis
            let analysis = `At age ${age}, your estimated maximum heart rate is ${maxHR} bpm. `;
            
            if (restingHRInput && restingHRInput.trim() !== '') {
                analysis += `Your resting heart rate of ${restingHR} bpm is ${restingQuality.toLowerCase()}. `;
            } else {
                analysis += `Based on your ${fitnessNames[fitnessLevel].toLowerCase()} fitness level, your estimated resting heart rate is ${restingHR} bpm (${restingQuality.toLowerCase()}). `;
                analysis += `For more accurate zones, measure your actual resting heart rate first thing in the morning before getting out of bed. `;
            }
            
            analysis += `Your heart rate reserve (max HR - resting HR) is ${heartRateReserve} bpm, which is used to calculate training zones. `;
            
            analysis += `For ${activityNames[activityType].toLowerCase()}, focus on ${recommendedZone} (${recommendedZoneRange}). `;
            
            if (activityType === 'weightloss') {
                analysis += `Zone 2 maximizes fat burning while being sustainable for longer durations (45-60 minutes). `;
                analysis += `Add 1-2 high-intensity sessions per week in Zone 4 to boost metabolism. `;
            } else if (activityType === 'hiit') {
                analysis += `HIIT involves short bursts in Zones 4-5 (30 sec - 2 min) with recovery periods in Zones 1-2. `;
                analysis += `Only for those with good fitness base. Start with 20-minute sessions. `;
            } else if (activityType === 'endurance') {
                analysis += `Build aerobic base with 80% of training in Zone 2 (easy, conversational pace). `;
                analysis += `Add 20% in Zones 3-4 for threshold and tempo work. `;
            } else {
                analysis += `Spend 80% of training time in Zones 1-2 (easy) and 20% in Zones 3-5 (moderate to hard). `;
            }
            
            analysis += `Monitor your heart rate during exercise with a chest strap monitor or fitness watch for best accuracy. `;
            analysis += `Track your resting heart rate weekly - improvements indicate better cardiovascular fitness.`;

            // Update UI
            document.getElementById('maxHRResult').textContent = `${maxHR} bpm`;
            document.getElementById('maxHRDisplay').textContent = maxHR;
            document.getElementById('restingHRDisplay').textContent = restingHR;
            document.getElementById('reserveHRDisplay').textContent = heartRateReserve;
            document.getElementById('targetZoneDisplay').textContent = `${cardioMin}-${cardioMax}`;

            document.getElementById('ageDisplay').textContent = `${age} years`;
            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('restingDisplay').textContent = `${restingHR} bpm (${restingQuality})`;
            document.getElementById('maxDisplay').textContent = `${maxHR} bpm`;
            document.getElementById('reserveDisplay').textContent = `${heartRateReserve} bpm`;
            document.getElementById('fitnessDisplay').textContent = fitnessNames[fitnessLevel];

            document.getElementById('zone1').textContent = `${zone1Min}-${zone1Max} bpm - Warm up, cool down`;
            document.getElementById('zone2').textContent = `${zone2Min}-${zone2Max} bpm - Fat burn, recovery`;
            document.getElementById('zone3').textContent = `${zone3Min}-${zone3Max} bpm - Aerobic, endurance`;
            document.getElementById('zone4').textContent = `${zone4Min}-${zone4Max} bpm - Anaerobic, performance`;
            document.getElementById('zone5').textContent = `${zone5Min}-${zone5Max} bpm - Max effort, sprints`;

            document.getElementById('fatBurnZone').textContent = `${fatBurnMin}-${fatBurnMax} bpm`;
            document.getElementById('cardioZone').textContent = `${cardioMin}-${cardioMax} bpm`;
            document.getElementById('performanceZone').textContent = `${performanceMin}-${performanceMax} bpm`;
            document.getElementById('peakZone').textContent = `${peakMin}-${peakMax} bpm`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            calculateHeartRate();
        });
    </script>
</body>
</html>