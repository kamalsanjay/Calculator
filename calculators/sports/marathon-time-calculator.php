<?php
/**
 * Marathon Time Calculator
 * File: sports/marathon-time-calculator.php
 * Description: Calculate marathon finish times based on pace, speed, or other race times
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marathon Time Calculator - Predict Your Finish Time</title>
    <meta name="description" content="Calculate your marathon finish time based on pace, speed, or other race performances. Plan your training and race strategy.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-section { margin-bottom: 30px; }
        .section-title { color: #2c3e50; font-size: 1.3rem; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0; }
        
        .input-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { display: flex; }
        .input-wrapper input { flex: 1; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #ff7e5f; box-shadow: 0 0 0 3px rgba(255, 126, 95, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; margin-top: 10px; }
        .unit-select:focus { outline: none; border-color: #ff7e5f; box-shadow: 0 0 0 3px rgba(255, 126, 95, 0.1); }
        
        .time-inputs { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; }
        .time-input { display: flex; flex-direction: column; }
        .time-input label { margin-bottom: 5px; font-size: 0.85rem; color: #7f8c8d; }
        
        .calculate-btn { background: linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%); color: white; border: none; border-radius: 10px; padding: 14px 25px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin-top: 10px; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 126, 95, 0.4); }
        
        .result-section { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 15px; }
        .result-card { background: linear-gradient(135deg, #ffe8e1 0%, #ffd7c7 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #ff7e5f; }
        .result-label { color: #d84315; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #bf360c; word-wrap: break-word; }
        
        .pace-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-top: 20px; }
        .pace-card { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); text-align: center; }
        .pace-value { font-size: 1.3rem; font-weight: bold; color: #ff7e5f; }
        .pace-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 5px; }
        
        .quick-predict { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-predict h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #ff7e5f; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255, 126, 95, 0.15); }
        .quick-value { font-weight: bold; color: #ff7e5f; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .training-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .training-table th, .training-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .training-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .training-table tr:hover { background: #ffe8e1; }
        
        .formula-box { background: #ffe8e1; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff7e5f; }
        .formula-box strong { color: #ff7e5f; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .method-tabs { display: flex; margin-bottom: 20px; border-bottom: 2px solid #f0f0f0; }
        .method-tab { padding: 12px 20px; cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.3s; font-weight: 600; color: #7f8c8d; }
        .method-tab.active { color: #ff7e5f; border-bottom-color: #ff7e5f; }
        
        .method-content { display: none; }
        .method-content.active { display: block; }
        
        @media (max-width: 768px) {
            .input-row { grid-template-columns: 1fr; gap: 15px; }
            .time-inputs { grid-template-columns: 1fr; }
            .result-grid, .pace-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .method-tabs { flex-wrap: wrap; }
            .method-tab { flex: 1; min-width: 120px; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏃‍♂️ Marathon Time Calculator</h1>
            <p>Predict your marathon finish time based on pace, speed, or other race performances. Plan your training and race strategy effectively.</p>
        </div>

        <div class="calculator-card">
            <div class="method-tabs">
                <div class="method-tab active" data-method="pace">By Pace</div>
                <div class="method-tab" data-method="speed">By Speed</div>
                <div class="method-tab" data-method="race">By Race Time</div>
                <div class="method-tab" data-method="vdot">VDOT Calculator</div>
            </div>

            <!-- Pace Method -->
            <div class="method-content active" id="pace-method">
                <div class="input-section">
                    <h3 class="section-title">Calculate by Pace</h3>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="paceMinutes">Pace (per mile)</label>
                            <div class="time-inputs">
                                <div class="time-input">
                                    <label>Minutes</label>
                                    <input type="number" id="paceMinutes" placeholder="0" min="0" max="59" value="8">
                                </div>
                                <div class="time-input">
                                    <label>Seconds</label>
                                    <input type="number" id="paceSeconds" placeholder="0" min="0" max="59" value="0">
                                </div>
                                <div class="time-input">
                                    <label>Unit</label>
                                    <select id="paceUnit" class="unit-select">
                                        <option value="mile">per Mile</option>
                                        <option value="km">per Kilometer</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="calculate-btn" onclick="calculateByPace()">Calculate Marathon Time</button>
                </div>
            </div>

            <!-- Speed Method -->
            <div class="method-content" id="speed-method">
                <div class="input-section">
                    <h3 class="section-title">Calculate by Speed</h3>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="speedValue">Running Speed</label>
                            <div class="input-wrapper">
                                <input type="number" id="speedValue" placeholder="Enter speed" step="0.1" value="7.5">
                                <select id="speedUnit" class="unit-select" style="margin-left: 10px; width: auto;">
                                    <option value="mph">mph</option>
                                    <option value="kph">km/h</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="calculate-btn" onclick="calculateBySpeed()">Calculate Marathon Time</button>
                </div>
            </div>

            <!-- Race Time Method -->
            <div class="method-content" id="race-method">
                <div class="input-section">
                    <h3 class="section-title">Predict from Other Race</h3>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="raceDistance">Race Distance</label>
                            <select id="raceDistance" class="unit-select">
                                <option value="5k">5K</option>
                                <option value="10k">10K</option>
                                <option value="half">Half Marathon</option>
                                <option value="30k">30K</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="raceTime">Race Time</label>
                            <div class="time-inputs">
                                <div class="time-input">
                                    <label>Hours</label>
                                    <input type="number" id="raceHours" placeholder="0" min="0" value="0">
                                </div>
                                <div class="time-input">
                                    <label>Minutes</label>
                                    <input type="number" id="raceMinutes" placeholder="0" min="0" max="59" value="45">
                                </div>
                                <div class="time-input">
                                    <label>Seconds</label>
                                    <input type="number" id="raceSeconds" placeholder="0" min="0" max="59" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="calculate-btn" onclick="calculateByRace()">Predict Marathon Time</button>
                </div>
            </div>

            <!-- VDOT Method -->
            <div class="method-content" id="vdot-method">
                <div class="input-section">
                    <h3 class="section-title">VDOT Calculator</h3>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="vdotDistance">Recent Race Distance</label>
                            <select id="vdotDistance" class="unit-select">
                                <option value="5k">5K</option>
                                <option value="10k">10K</option>
                                <option value="half">Half Marathon</option>
                                <option value="marathon">Marathon</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="vdotTime">Race Time</label>
                            <div class="time-inputs">
                                <div class="time-input">
                                    <label>Hours</label>
                                    <input type="number" id="vdotHours" placeholder="0" min="0" value="0">
                                </div>
                                <div class="time-input">
                                    <label>Minutes</label>
                                    <input type="number" id="vdotMinutes" placeholder="0" min="0" max="59" value="45">
                                </div>
                                <div class="time-input">
                                    <label>Seconds</label>
                                    <input type="number" id="vdotSeconds" placeholder="0" min="0" max="59" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="calculate-btn" onclick="calculateVDOT()">Calculate VDOT & Predictions</button>
                </div>
            </div>

            <div class="result-section">
                <h3 class="section-title">Marathon Prediction</h3>
                <div class="result-grid" id="resultGrid">
                    <div class="result-card">
                        <div class="result-label">Finish Time</div>
                        <div class="result-value" id="finishTime">--:--:--</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Average Pace</div>
                        <div class="result-value" id="avgPace">--:-- /mi</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Boston Qualifier</div>
                        <div class="result-value" id="bqStatus">--</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">World Record Gap</div>
                        <div class="result-value" id="wrGap">--</div>
                    </div>
                </div>

                <h3 style="margin-top: 25px;">Pace per Mile</h3>
                <div class="pace-grid" id="paceGrid">
                    <!-- Pace cards will be generated here -->
                </div>
            </div>

            <div class="quick-predict">
                <h3>🏃 Common Goal Times</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setGoalTime(3, 0, 0)">
                        <div class="quick-value">3:00:00</div>
                        <div class="quick-label">Sub-3 Hour</div>
                    </div>
                    <div class="quick-btn" onclick="setGoalTime(3, 30, 0)">
                        <div class="quick-value">3:30:00</div>
                        <div class="quick-label">3:30 Marathon</div>
                    </div>
                    <div class="quick-btn" onclick="setGoalTime(4, 0, 0)">
                        <div class="quick-value">4:00:00</div>
                        <div class="quick-label">4-Hour Marathon</div>
                    </div>
                    <div class="quick-btn" onclick="setGoalTime(4, 30, 0)">
                        <div class="quick-value">4:30:00</div>
                        <div class="quick-label">4:30 Marathon</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🏃‍♂️ Marathon Time Prediction</h2>
            
            <p>Accurately predict your marathon finish time using various calculation methods based on your current fitness level, pace, or recent race performances.</p>

            <h3>📊 Calculation Methods</h3>
            <table class="training-table">
                <thead>
                    <tr>
                        <th>Method</th>
                        <th>Description</th>
                        <th>Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Pace Calculation</td><td>Calculate based on your target pace per mile or kilometer</td><td>Runners with a specific pace goal</td></tr>
                    <tr><td>Speed Calculation</td><td>Calculate based on your running speed in mph or km/h</td><td>Track runners or those who train by speed</td></tr>
                    <tr><td>Race Time Prediction</td><td>Predict marathon time based on shorter race performances</td><td>Runners with recent race times</td></tr>
                    <tr><td>VDOT Calculator</td><td>Use Jack Daniels' VDOT system for precise predictions</td><td>Serious runners following structured training</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Common Marathon Formulas:</strong><br>
                • <strong>Pace to Time:</strong> Time = Pace × 26.2 miles (or 42.195 km)<br>
                • <strong>Speed to Time:</strong> Time = Distance ÷ Speed<br>
                • <strong>Race Equivalency:</strong> Marathon ≈ 2 × Half Marathon + 10-20 minutes<br>
                • <strong>Riegel Formula:</strong> T2 = T1 × (D2 ÷ D1)<sup>1.06</sup>
            </div>

            <h3>🎯 Boston Marathon Qualifying Times</h3>
            <table class="training-table">
                <thead>
                    <tr>
                        <th>Age Group</th>
                        <th>Men</th>
                        <th>Women</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>18-34</td><td>3:00:00</td><td>3:30:00</td></tr>
                    <tr><td>35-39</td><td>3:05:00</td><td>3:35:00</td></tr>
                    <tr><td>40-44</td><td>3:10:00</td><td>3:40:00</td></tr>
                    <tr><td>45-49</td><td>3:20:00</td><td>3:50:00</td></tr>
                    <tr><td>50-54</td><td>3:25:00</td><td>3:55:00</td></tr>
                    <tr><td>55-59</td><td>3:35:00</td><td>4:05:00</td></tr>
                    <tr><td>60-64</td><td>3:50:00</td><td>4:20:00</td></tr>
                    <tr><td>65-69</td><td>4:05:00</td><td>4:35:00</td></tr>
                    <tr><td>70-74</td><td>4:20:00</td><td>4:50:00</td></tr>
                    <tr><td>75-79</td><td>4:35:00</td><td>5:05:00</td></tr>
                    <tr><td>80+</td><td>4:50:00</td><td>5:20:00</td></tr>
                </tbody>
            </table>

            <h3>🏆 World Records & Elite Standards</h3>
            <ul>
                <li><strong>Men's World Record:</strong> 2:00:35 (Kelvin Kiptum, 2023)</li>
                <li><strong>Women's World Record:</strong> 2:11:53 (Tigist Assefa, 2023)</li>
                <li><strong>Olympic Standard (Men):</strong> 2:08:10</li>
                <li><strong>Olympic Standard (Women):</strong> 2:26:50</li>
                <li><strong>Sub-2 Hour Pace:</strong> 4:34 per mile / 2:50 per km</li>
            </ul>

            <h3>📈 Race Time Predictions</h3>
            <div class="formula-box">
                <strong>Common Race Equivalencies:</strong><br>
                • <strong>5K to Marathon:</strong> Marathon ≈ 5K time × 8.4-9.0<br>
                • <strong>10K to Marathon:</strong> Marathon ≈ 10K time × 4.6-4.9<br>
                • <strong>Half to Marathon:</strong> Marathon ≈ Half × 2.1-2.2<br>
                • <strong>Note:</strong> These are estimates - terrain, training, and conditions affect actual performance
            </div>

            <h3>🏃‍♂️ Training Paces by Goal Time</h3>
            <table class="training-table">
                <thead>
                    <tr>
                        <th>Goal Time</th>
                        <th>Marathon Pace</th>
                        <th>Easy Pace</th>
                        <th>Tempo Pace</th>
                        <th>Interval Pace</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>3:00:00</td><td>6:52/mi</td><td>8:00-8:30/mi</td><td>6:20-6:30/mi</td><td>5:45-6:00/mi</td></tr>
                    <tr><td>3:30:00</td><td>8:00/mi</td><td>9:15-9:45/mi</td><td>7:25-7:35/mi</td><td>6:45-7:00/mi</td></tr>
                    <tr><td>4:00:00</td><td>9:09/mi</td><td>10:30-11:00/mi</td><td>8:30-8:40/mi</td><td>7:45-8:00/mi</td></tr>
                    <tr><td>4:30:00</td><td>10:18/mi</td><td>11:45-12:15/mi</td><td>9:35-9:45/mi</td><td>8:45-9:00/mi</td></tr>
                    <tr><td>5:00:00</td><td>11:27/mi</td><td>13:00-13:30/mi</td><td>10:40-10:50/mi</td><td>9:45-10:00/mi</td></tr>
                </tbody>
            </table>

            <h3>📊 VDOT Running Calculator</h3>
            <p>The VDOT system, developed by renowned coach Jack Daniels, provides a comprehensive approach to training based on your current fitness level. Your VDOT number represents your current oxygen utilization capacity and correlates with race performances.</p>

            <div class="formula-box">
                <strong>VDOT Training Paces:</strong><br>
                • <strong>Easy Pace:</strong> 65-79% of VDOT pace - for recovery and long runs<br>
                • <strong>Marathon Pace:</strong> 80-85% of VDOT pace - goal race pace<br>
                • <strong>Threshold Pace:</strong> 86-88% of VDOT pace - comfortably hard<br>
                • <strong>Interval Pace:</strong> 95-100% of VDOT pace - VO2 max training<br>
                • <strong>Repetition Pace:</strong> 105-110% of VDOT pace - speed development
            </div>

            <h3>🌡️ Temperature & Course Adjustment</h3>
            <ul>
                <li><strong>Ideal temperature:</strong> 45-55°F (7-13°C)</li>
                <li><strong>Heat adjustment:</strong> Add 1-2% per 5°F above 55°F</li>
                <li><strong>Hilly course:</strong> Add 10-30 seconds per mile for significant elevation</li>
                <li><strong>Altitude:</strong> Performance decreases ~3% at 5,000 ft (1,500 m)</li>
            </ul>

            <h3>💪 Training Principles</h3>
            <ul>
                <li><strong>80/20 Rule:</strong> 80% easy running, 20% quality work</li>
                <li><strong>Long Run:</strong> Build to 18-22 miles, 20-30% of weekly volume</li>
                <li><strong>Taper:</strong> Reduce volume 25-50% over final 2-3 weeks</li>
                <li><strong>Peak Week:</strong> Typically 3 weeks before race day</li>
                <li><strong>Recovery:</strong> Include easy weeks every 3-4 weeks</li>
            </ul>

            <h3>🍽️ Race Day Nutrition</h3>
            <table class="training-table">
                <thead>
                    <tr>
                        <th>Time Goal</th>
                        <th>Calories/Hour</th>
                        <th>Fluid (oz/hour)</th>
                        <th>Carbohydrates (g/hour)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Sub-3:00</td><td>200-300</td><td>16-24</td><td>60-90</td></tr>
                    <tr><td>3:00-4:00</td><td>150-250</td><td>12-20</td><td>45-75</td></tr>
                    <tr><td>4:00-5:00</td><td>100-200</td><td>10-16</td><td>30-60</td></tr>
                    <tr><td>5:00+</td><td>100-150</td><td>8-12</td><td>30-45</td></tr>
                </tbody>
            </table>

            <h3>📋 Marathon Preparation Timeline</h3>
            <ul>
                <li><strong>16-20 weeks:</strong> Begin training plan</li>
                <li><strong>12 weeks:</strong> First 15+ mile long run</li>
                <li><strong>8 weeks:</strong> Peak long run (20-22 miles)</li>
                <li><strong>3 weeks:</strong> Begin taper</li>
                <li><strong>1 week:</strong> Carb loading begins</li>
                <li><strong>2 days:</strong> Final short, easy run</li>
                <li><strong>Race day:</strong> Stick to your plan!</li>
            </ul>

            <h3>⚠️ Important Considerations</h3>
            <div class="formula-box">
                <strong>Factors Affecting Performance:</strong><br>
                • <strong>Course Profile:</strong> Flat vs. hilly, elevation<br>
                • <strong>Weather Conditions:</strong> Temperature, humidity, wind<br>
                • <strong>Training:</strong> Consistency, long runs, speed work<br>
                • <strong>Experience:</strong> First marathon vs. experienced<br>
                • <strong>Nutrition:</strong> Fueling strategy during race<br>
                • <strong>Taper:</strong> Proper rest before race day
            </div>

            <h3>🎯 Smart Marathon Goals</h3>
            <ul>
                <li><strong>A Goal:</strong> Perfect day, optimal conditions</li>
                <li><strong>B Goal:</strong> Realistic target based on training</li>
                <li><strong>C Goal:</strong> Finish strong and enjoy the experience</li>
                <li><strong>First Marathon:</strong> Focus on finishing, not time</li>
            </ul>
        </div>

        <div class="footer">
            <p>🏃‍♂️ Marathon Time Calculator | Predict Your Finish Time</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate based on pace, speed, race times, or VDOT. Plan your training and race strategy.</p>
        </div>
    </div>

    <script>
        // Method tabs functionality
        document.querySelectorAll('.method-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.method-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.method-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                tab.classList.add('active');
                const method = tab.getAttribute('data-method');
                document.getElementById(`${method}-method`).classList.add('active');
            });
        });

        // VDOT table data (simplified)
        const vdotTable = {
            '5k': {
                '14:00': 85, '16:00': 75, '18:00': 66, '20:00': 58, '22:00': 51, '24:00': 45, '26:00': 40, '28:00': 36
            },
            '10k': {
                '29:00': 85, '33:00': 75, '37:00': 66, '41:00': 58, '45:00': 51, '49:00': 45, '53:00': 40, '57:00': 36
            },
            'half': {
                '1:05:00': 85, '1:15:00': 75, '1:25:00': 66, '1:35:00': 58, '1:45:00': 51, '1:55:00': 45, '2:05:00': 40, '2:15:00': 36
            },
            'marathon': {
                '2:20:00': 85, '2:45:00': 75, '3:10:00': 66, '3:35:00': 58, '4:00:00': 51, '4:25:00': 45, '4:50:00': 40, '5:15:00': 36
            }
        };

        // World records
        const worldRecords = {
            men: 2 * 3600 + 35, // 2:00:35 in seconds
            women: 2 * 3600 + 11 * 60 + 53 // 2:11:53 in seconds
        };

        // Boston qualifying times (men 18-34 as reference)
        const bqTime = 3 * 3600; // 3:00:00 in seconds

        function calculateByPace() {
            const minutes = parseInt(document.getElementById('paceMinutes').value) || 0;
            const seconds = parseInt(document.getElementById('paceSeconds').value) || 0;
            const unit = document.getElementById('paceUnit').value;
            
            const paceInSeconds = minutes * 60 + seconds;
            const marathonDistance = unit === 'mile' ? 26.2188 : 42.195; // miles vs km
            
            const totalSeconds = paceInSeconds * marathonDistance;
            displayResults(totalSeconds);
        }

        function calculateBySpeed() {
            const speed = parseFloat(document.getElementById('speedValue').value);
            const unit = document.getElementById('speedUnit').value;
            
            if (!speed || speed <= 0) return;
            
            const marathonDistance = unit === 'mph' ? 26.2188 : 42.195;
            const hours = marathonDistance / speed;
            const totalSeconds = hours * 3600;
            
            displayResults(totalSeconds);
        }

        function calculateByRace() {
            const distance = document.getElementById('raceDistance').value;
            const hours = parseInt(document.getElementById('raceHours').value) || 0;
            const minutes = parseInt(document.getElementById('raceMinutes').value) || 0;
            const seconds = parseInt(document.getElementById('raceSeconds').value) || 0;
            
            const raceTimeInSeconds = hours * 3600 + minutes * 60 + seconds;
            
            // Using Riegel formula: T2 = T1 × (D2 ÷ D1)^1.06
            const distances = {
                '5k': 5,
                '10k': 10,
                'half': 21.0975,
                '30k': 30
            };
            
            const marathonDistance = 42.195;
            const raceDistance = distances[distance];
            const exponent = 1.06;
            
            const totalSeconds = raceTimeInSeconds * Math.pow(marathonDistance / raceDistance, exponent);
            displayResults(totalSeconds);
        }

        function calculateVDOT() {
            const distance = document.getElementById('vdotDistance').value;
            const hours = parseInt(document.getElementById('vdotHours').value) || 0;
            const minutes = parseInt(document.getElementById('vdotMinutes').value) || 0;
            const seconds = parseInt(document.getElementById('vdotSeconds').value) || 0;
            
            const raceTimeInSeconds = hours * 3600 + minutes * 60 + seconds;
            const raceTimeFormatted = formatTime(raceTimeInSeconds, false);
            
            // Simplified VDOT calculation (in a real app, you'd use more precise tables)
            let vdot = 50; // Default
            
            // Find closest time in VDOT table
            if (vdotTable[distance]) {
                const times = Object.keys(vdotTable[distance]);
                for (let i = 0; i < times.length; i++) {
                    const tableTime = timeToSeconds(times[i]);
                    if (raceTimeInSeconds <= tableTime) {
                        vdot = vdotTable[distance][times[i]];
                        break;
                    }
                }
            }
            
            // Predict marathon time based on VDOT
            // This is a simplified calculation - real VDOT predictions are more complex
            const marathonPrediction = raceTimeInSeconds * (42.195 / distances[distance]) * 1.1;
            
            displayResults(marathonPrediction, vdot);
        }

        function displayResults(totalSeconds, vdot = null) {
            // Format and display finish time
            document.getElementById('finishTime').textContent = formatTime(totalSeconds);
            
            // Calculate and display average pace
            const pacePerMile = totalSeconds / 26.2188;
            document.getElementById('avgPace').textContent = `${formatTime(pacePerMile, true)} /mi`;
            
            // Boston Qualifier status
            const bqStatus = totalSeconds <= bqTime ? 'Qualifies!' : 'Does Not Qualify';
            document.getElementById('bqStatus').textContent = bqStatus;
            
            // World record gap
            const wrGapSeconds = totalSeconds - worldRecords.men;
            document.getElementById('wrGap').textContent = formatTime(wrGapSeconds, false, true);
            
            // Display VDOT if available
            if (vdot) {
                // Add VDOT to results if calculated
                const resultGrid = document.getElementById('resultGrid');
                if (!document.getElementById('vdotResult')) {
                    const vdotCard = document.createElement('div');
                    vdotCard.className = 'result-card';
                    vdotCard.id = 'vdotResult';
                    vdotCard.innerHTML = `
                        <div class="result-label">VDOT Score</div>
                        <div class="result-value">${vdot}</div>
                    `;
                    resultGrid.appendChild(vdotCard);
                } else {
                    document.querySelector('#vdotResult .result-value').textContent = vdot;
                }
            }
            
            // Generate pace chart
            generatePaceChart(totalSeconds);
        }

        function generatePaceChart(totalSeconds) {
            const paceGrid = document.getElementById('paceGrid');
            paceGrid.innerHTML = '';
            
            const splits = [5, 10, 13.1, 20, 26.2]; // Common marathon splits in miles
            const totalMiles = 26.2188;
            
            splits.forEach(split => {
                const splitTime = (totalSeconds * split) / totalMiles;
                
                const card = document.createElement('div');
                card.className = 'pace-card';
                card.innerHTML = `
                    <div class="pace-value">${formatTime(splitTime, true)}</div>
                    <div class="pace-label">${split} ${split === 13.1 ? 'Half' : split === 26.2 ? 'Finish' : split + 'mi'}</div>
                `;
                paceGrid.appendChild(card);
            });
        }

        function setGoalTime(hours, minutes, seconds) {
            // This would set inputs for a specific goal time
            // For simplicity, we'll just calculate and display
            const totalSeconds = hours * 3600 + minutes * 60 + seconds;
            displayResults(totalSeconds);
        }

        // Utility functions
        function formatTime(totalSeconds, showHours = false, showSign = false) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = Math.floor(totalSeconds % 60);
            
            let sign = '';
            if (showSign && totalSeconds > 0) {
                sign = '+';
            } else if (showSign && totalSeconds < 0) {
                sign = '-';
            }
            
            const absSeconds = Math.abs(totalSeconds);
            const absHours = Math.floor(absSeconds / 3600);
            const absMinutes = Math.floor((absSeconds % 3600) / 60);
            const absSecs = Math.floor(absSeconds % 60);
            
            if (showHours || absHours > 0) {
                return `${sign}${absHours}:${absMinutes.toString().padStart(2, '0')}:${absSecs.toString().padStart(2, '0')}`;
            } else {
                return `${sign}${absMinutes}:${absSecs.toString().padStart(2, '0')}`;
            }
        }

        function timeToSeconds(timeString) {
            // Convert time string like "1:15:00" to seconds
            const parts = timeString.split(':');
            if (parts.length === 3) {
                return parseInt(parts[0]) * 3600 + parseInt(parts[1]) * 60 + parseInt(parts[2]);
            } else if (parts.length === 2) {
                return parseInt(parts[0]) * 60 + parseInt(parts[1]);
            }
            return 0;
        }

        // Initialize with default calculation
        calculateByPace();
    </script>
</body>
</html>
