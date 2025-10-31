<?php
/**
 * Time Converter
 * File: conversion/time-converter.php
 * Description: Convert between time units including seconds, minutes, hours, days, and more
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Converter - Temporal Unit Conversion Calculator</title>
    <meta name="description" content="Convert between time units: seconds, minutes, hours, days, weeks, years, and more. Essential for scheduling, science, and everyday time management.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; margin-top: 10px; }
        .unit-select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #667eea; }
        .result-unit { color: #0984e3; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #00cec9; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #667eea; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15); }
        .quick-value { font-weight: bold; color: #667eea; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .common-times { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .common-times h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        
        .time-scale { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .time-scale-bar { height: 30px; background: linear-gradient(90deg, #4caf50, #ffeb3b, #ff9800, #f44336); border-radius: 15px; margin: 10px 0; position: relative; }
        .time-scale-labels { display: flex; justify-content: space-between; font-size: 0.8rem; color: #555; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #a8edea; }
        
        .formula-box { background: #a8edea; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .human-scale { background: #fff3e0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff9800; }
        
        .scientific-box { background: #e8f5e8; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #4caf50; }
        
        .calendar-box { background: #f3e5f5; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #9c27b0; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .time-highlight { background: #e3f2fd; padding: 3px 6px; border-radius: 4px; font-weight: bold; }
        
        @media (max-width: 768px) {
            .converter-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .result-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⏰ Time Converter</h1>
            <p>Convert between time units: seconds, minutes, hours, days, weeks, years, and more. Essential for scheduling, science, and everyday time management.</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="60">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="second" selected>Second (s)</option>
                        <option value="millisecond">Millisecond (ms)</option>
                        <option value="microsecond">Microsecond (μs)</option>
                        <option value="nanosecond">Nanosecond (ns)</option>
                        <option value="minute">Minute (min)</option>
                        <option value="hour">Hour (hr)</option>
                        <option value="day">Day (day)</option>
                        <option value="week">Week (wk)</option>
                        <option value="month">Month (mo)</option>
                        <option value="year">Year (yr)</option>
                        <option value="decade">Decade</option>
                        <option value="century">Century</option>
                        <option value="millennium">Millennium</option>
                        <option value="fortnight">Fortnight</option>
                        <option value="shake">Shake (nuclear)</option>
                        <option value="planck">Planck Time</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="second">Second (s)</option>
                        <option value="millisecond">Millisecond (ms)</option>
                        <option value="microsecond">Microsecond (μs)</option>
                        <option value="nanosecond">Nanosecond (ns)</option>
                        <option value="minute" selected>Minute (min)</option>
                        <option value="hour">Hour (hr)</option>
                        <option value="day">Day (day)</option>
                        <option value="week">Week (wk)</option>
                        <option value="month">Month (mo)</option>
                        <option value="year">Year (yr)</option>
                        <option value="decade">Decade</option>
                        <option value="century">Century</option>
                        <option value="millennium">Millennium</option>
                        <option value="fortnight">Fortnight</option>
                        <option value="shake">Shake (nuclear)</option>
                        <option value="planck">Planck Time</option>
                    </select>
                    <div class="input-wrapper" style="margin-top: 10px;">
                        <input type="text" id="outputValue" placeholder="Result" readonly style="background: #f8f9fa; font-weight: 600; color: #2c3e50;">
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid"></div>

            <div class="quick-convert">
                <h3>⚡ Quick Conversions</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setInput(60)">
                        <div class="quick-value">60</div>
                        <div class="quick-label">Seconds</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(3600)">
                        <div class="quick-value">3600</div>
                        <div class="quick-label">1 Hour</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(86400)">
                        <div class="quick-value">86400</div>
                        <div class="quick-label">1 Day</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(31536000)">
                        <div class="quick-value">31,536,000</div>
                        <div class="quick-label">1 Year</div>
                    </div>
                </div>
            </div>

            <div class="common-times">
                <h3>🎯 Common Time Values</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setCommonTime(15, 'Standard break time')">
                        <div class="quick-value">15 min</div>
                        <div class="quick-label">Coffee Break</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonTime(45, 'Typical class period')">
                        <div class="quick-value">45 min</div>
                        <div class="quick-label">Class Period</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonTime(90, 'Typical movie length')">
                        <div class="quick-value">90 min</div>
                        <div class="quick-label">Movie</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonTime(525600, 'Minutes in common year')">
                        <div class="quick-value">525,600</div>
                        <div class="quick-label">Year in Minutes</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⏰ Time Unit Conversion</h2>
            
            <p>Convert between time units used worldwide for science, scheduling, history, and everyday life applications.</p>

            <div class="time-scale">
                <h3>📊 Time Scale Spectrum</h3>
                <div class="time-scale-bar"></div>
                <div class="time-scale-labels">
                    <span>Seconds<br>(s)</span>
                    <span>Minutes<br>(min)</span>
                    <span>Hours<br>(hr)</span>
                    <span>Days<br>(day)</span>
                    <span>Years<br>(yr)</span>
                </div>
            </div>

            <h3>📊 Conversion Factors to Seconds</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Seconds</th>
                        <th>Common Usage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Second</td><td>s</td><td>1</td><td>SI base unit</td></tr>
                    <tr><td>Millisecond</td><td>ms</td><td>0.001</td><td>Computers, sports timing</td></tr>
                    <tr><td>Microsecond</td><td>μs</td><td>0.000001</td><td>Electronics, physics</td></tr>
                    <tr><td>Nanosecond</td><td>ns</td><td>1×10⁻⁹</td><td>Computers, light travel</td></tr>
                    <tr><td>Minute</td><td>min</td><td>60</td><td>Daily timekeeping</td></tr>
                    <tr><td>Hour</td><td>hr</td><td>3,600</td><td>Work schedules</td></tr>
                    <tr><td>Day</td><td>day</td><td>86,400</td><td>Calendar, astronomy</td></tr>
                    <tr><td>Week</td><td>wk</td><td>604,800</td><td>Planning, schedules</td></tr>
                    <tr><td>Month (avg)</td><td>mo</td><td>2,629,746</td><td>Calendar, billing</td></tr>
                    <tr><td>Year (common)</td><td>yr</td><td>31,536,000</td><td>Annual cycles</td></tr>
                    <tr><td>Year (leap)</td><td>yr</td><td>31,622,400</td><td>Calendar correction</td></tr>
                    <tr><td>Decade</td><td>dec</td><td>315,360,000</td><td>Historical periods</td></tr>
                    <tr><td>Century</td><td>cent</td><td>3,153,600,000</td><td>Historical eras</td></tr>
                    <tr><td>Millennium</td><td>mill</td><td>31,536,000,000</td><td>Long-term history</td></tr>
                    <tr><td>Fortnight</td><td>ftn</td><td>1,209,600</td><td>UK, traditional</td></tr>
                    <tr><td>Shake</td><td>shake</td><td>1×10⁻⁸</td><td>Nuclear physics</td></tr>
                    <tr><td>Planck Time</td><td>tₚ</td><td>5.39×10⁻⁴⁴</td><td>Theoretical physics</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Time Conversion Formulas:</strong><br>
                • <strong>1 Minute</strong> = 60 Seconds = 60,000 Milliseconds<br>
                • <strong>1 Hour</strong> = 60 Minutes = 3,600 Seconds<br>
                • <strong>1 Day</strong> = 24 Hours = 1,440 Minutes = 86,400 Seconds<br>
                • <strong>1 Week</strong> = 7 Days = 168 Hours = 10,080 Minutes<br>
                • <strong>1 Year</strong> = 365 Days (common) = 8,760 Hours = 525,600 Minutes<br>
                • <strong>1 Leap Year</strong> = 366 Days = 8,784 Hours = 527,040 Minutes<br>
                • <strong>1 Decade</strong> = 10 Years ≈ 3,652.5 Days (including leap years)
            </div>

            <h3>👥 Human Time Perception</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Time Period</th>
                        <th>Duration</th>
                        <th>Human Experience</th>
                        <th>Common Activities</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Blink of an eye</td><td>0.1-0.4 seconds</td><td>Instantaneous</td><td>Reflex actions</td></tr>
                    <tr><td>Heartbeat</td><td>0.6-1.0 seconds</td><td>Rhythmic pulse</td><td>Basic life function</td></tr>
                    <tr><td>Commercial break</td><td>2-3 minutes</td><td>Short pause</td><td>TV advertising</td></tr>
                    <tr><td>Power nap</td><td>10-20 minutes</td><td>Brief rest</td><td>Quick recharge</td></tr>
                    <tr><td>Sitcom episode</td><td>22 minutes</td><td>Entertainment unit</td><td>TV programming</td></tr>
                    <tr><td>Commute (avg)</td><td>25-30 minutes</td><td>Daily travel</td><td>Work transportation</td></tr>
                    <tr><td>Lunch break</td><td>30-60 minutes</td><td>Midday break</td><td>Meal and rest</td></tr>
                    <tr><td>Feature film</td><td>90-120 minutes</td><td>Entertainment</td><td>Movie watching</td></tr>
                    <tr><td>Work shift</td><td>8 hours</td><td>Standard workday</td><td>Employment</td></tr>
                    <tr><td>Sleep cycle</td><td>7-9 hours</td><td>Daily rest</td><td>Health maintenance</td></tr>
                </tbody>
            </table>

            <div class="human-scale">
                <strong>⏱️ Human Time References:</strong><br>
                • <span class="time-highlight">Reaction time:</span> 0.15-0.3 seconds (visual stimulus to physical response)<br>
                • <span class="time-highlight">Attention span:</span> 10-20 minutes (typical focus duration)<br>
                • <span class="time-highlight">Pomodoro technique:</span> 25 minutes work + 5 minutes break<br>
                • <span class="time-highlight">Biological clock:</span> Circadian rhythm ≈ 24.2 hours<br>
                • <span class="time-highlight">Memory formation:</span> Short-term: 15-30 seconds, Long-term: lifetime
            </div>

            <h3>📅 Calendar & Historical Time</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Calendar Unit</th>
                        <th>Days</th>
                        <th>Weeks</th>
                        <th>Months</th>
                        <th>Years</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Fortnight</td><td>14</td><td>2</td><td>0.46</td><td>0.038</td></tr>
                    <tr><td>Lunar month</td><td>29.53</td><td>4.22</td><td>1</td><td>0.081</td></tr>
                    <tr><td>Common month</td><td>30.44</td><td>4.35</td><td>1</td><td>0.083</td></tr>
                    <tr><td>Quarter</td><td>91.31</td><td>13.04</td><td>3</td><td>0.25</td></tr>
                    <tr><td>Semester</td><td>182.62</td><td>26.09</td><td>6</td><td>0.5</td></tr>
                    <tr><td>Common year</td><td>365</td><td>52.14</td><td>12</td><td>1</td></tr>
                    <tr><td>Leap year</td><td>366</td><td>52.29</td><td>12</td><td>1</td></tr>
                    <tr><td>Olympiad</td><td>1,461</td><td>208.71</td><td>48</td><td>4</td></tr>
                    <tr><td>Decade</td><td>3,652.5</td><td>521.79</td><td>120</td><td>10</td></tr>
                    <tr><td>Century</td><td>36,525</td><td>5,217.86</td><td>1,200</td><td>100</td></tr>
                    <tr><td>Millennium</td><td>365,250</td><td>52,178.57</td><td>12,000</td><td>1,000</td></tr>
                </tbody>
            </table>

            <div class="calendar-box">
                <strong>🗓️ Calendar Time Facts:</strong><br>
                • <span class="time-highlight">Average month:</span> 30.44 days (365.25 ÷ 12)<br>
                • <span class="time-highlight">Business month:</span> 21-23 working days (excluding weekends)<br>
                • <span class="time-highlight">Academic year:</span> ≈ 180 school days (US standard)<br>
                • <span class="time-highlight">Fiscal year:</span> 12-month financial reporting period<br>
                • <span class="time-highlight">Leap year rule:</span> Divisible by 4, but not by 100 unless also by 400
            </div>

            <h3>🔬 Scientific & Technical Time</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Seconds</th>
                        <th>Scientific Context</th>
                        <th>Applications</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Planck Time</td><td>5.39×10⁻⁴⁴ s</td><td>Quantum scale</td><td>Theoretical physics</td></tr>
                    <tr><td>Yoctosecond</td><td>1×10⁻²⁴ s</td><td>Subatomic particles</td><td>Particle physics</td></tr>
                    <tr><td>Zeptosecond</td><td>1×10⁻²¹ s</td><td>Nuclear processes</td><td>Quantum mechanics</td></tr>
                    <tr><td>Attosecond</td><td>1×10⁻¹⁸ s</td><td>Electron movements</td><td>Atomic physics</td></tr>
                    <tr><td>Femtosecond</td><td>1×10⁻¹⁵ s</td><td>Molecular vibrations</td><td>Chemistry, optics</td></tr>
                    <tr><td>Picosecond</td><td>1×10⁻¹² s</td><td>Light travel (0.3mm)</td><td>Electronics</td></tr>
                    <tr><td>Nanosecond</td><td>1×10⁻⁹ s</td><td>Light travel (30cm)</td><td>Computers, RAM</td></tr>
                    <tr><td>Microsecond</td><td>1×10⁻⁶ s</td><td>Sound travel (0.34mm)</td><td>Audio processing</td></tr>
                    <tr><td>Millisecond</td><td>0.001 s</td><td>Neural processing</td><td>Biology, sports</td></tr>
                    <tr><td>Shake</td><td>1×10⁻⁸ s</td><td>Nuclear chain reaction</td><td>Weapons physics</td></tr>
                </tbody>
            </table>

            <div class="scientific-box">
                <strong>🔭 Scientific Time Scales:</strong><br>
                • <span class="time-highlight">Light travel:</span> 1 nanosecond ≈ 30 cm (in vacuum)<br>
                • <span class="time-highlight">Atomic clocks:</span> Accuracy to 1 second in 100 million years<br>
                • <span class="time-highlight">GPS timing:</span> Requires nanosecond precision for meter accuracy<br>
                • <span class="time-highlight">Quantum processes:</span> Some occur in attoseconds (10⁻¹⁸ s)<br>
                • <span class="time-highlight">Geological time:</span> Measured in millions to billions of years
            </div>

            <h3>🌍 Cultural & Historical Time</h3>
            <ul>
                <li><strong>Generation:</strong> Typically 20-30 years (human lifespan perspective)</li>
                <li><strong>Historical era:</strong> Centuries or millennia (Ancient, Medieval, Modern)</li>
                <li><strong>Geological period:</strong> Millions of years (Jurassic, Cretaceous, etc.)</li>
                <li><strong>Cosmological time:</strong> Billions of years (age of universe: 13.8 billion years)</li>
                <li><strong>Precession cycle:</strong> 25,772 years (Earth's axial precession)</li>
                <li><strong>Human civilization:</strong> ≈ 6,000 years (recorded history)</li>
                <li><strong>Human species:</strong> ≈ 300,000 years (Homo sapiens existence)</li>
            </ul>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>Easy-to-Remember Time Conversions:</strong><br>
                • <strong>Seconds to Minutes:</strong> Divide by 60 (seconds ÷ 60 = minutes)<br>
                • <strong>Minutes to Hours:</strong> Divide by 60 (minutes ÷ 60 = hours)<br>
                • <strong>Hours to Days:</strong> Divide by 24 (hours ÷ 24 = days)<br>
                • <strong>Days to Weeks:</strong> Divide by 7 (days ÷ 7 = weeks)<br>
                • <strong>Weeks to Years:</strong> Divide by 52 (weeks ÷ 52 ≈ years)<br>
                • <strong>Months to Years:</strong> Divide by 12 (months ÷ 12 = years)<br>
                • <strong>Quick estimate:</strong> π seconds ≈ 1/100,000 of a year
            </div>

            <h3>⚖️ Historical Context</h3>
            <p>The <strong>second</strong> was originally defined as 1/86,400 of a mean solar day. In 1967, it was redefined using atomic transitions of cesium-133. The <strong>minute</strong> and <strong>hour</strong> come from ancient Babylonian sexagesimal (base-60) numbering system. The <strong>day</strong> is based on Earth's rotation, while the <strong>year</strong> comes from Earth's orbit around the Sun. The <strong>week</strong> of 7 days has various origins including astronomical (7 visible planets) and religious traditions.</p>

            <h3>⏱️ Time Measurement Tools</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Measurement Tool</th>
                        <th>Precision</th>
                        <th>Typical Range</th>
                        <th>Applications</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Atomic clock</td><td>Nanoseconds</td><td>Years</td><td>Scientific standards, GPS</td></tr>
                    <tr><td>Quartz clock</td><td>Milliseconds</td><td>Years</td><td>Consumer electronics</td></tr>
                    <tr><td>Mechanical watch</td><td>Seconds</td><td>Days</td><td>Personal timekeeping</td></tr>
                    <tr><td>Stopwatch</td><td>0.01 seconds</td><td>Hours</td><td>Sports, experiments</td></tr>
                    <tr><td>Hourglass</td><td>Minutes</td><td>Hours</td><td>Cooking, games</td></tr>
                    <tr><td>Sundial</td><td>Minutes</td><td>Daylight hours</td><td>Ancient timekeeping</td></tr>
                    <tr><td>Radiometric dating</td><td>Years to millennia</td><td>Billions of years</td><td>Geology, archaeology</td></tr>
                </tbody>
            </table>

            <h3>🎯 Key Conversions to Remember</h3>
            <ul>
                <li><strong>1 Minute = 60 Seconds</strong></li>
                <li><strong>1 Hour = 3,600 Seconds = 60 Minutes</strong></li>
                <li><strong>1 Day = 86,400 Seconds = 1,440 Minutes = 24 Hours</strong></li>
                <li><strong>1 Week = 604,800 Seconds = 10,080 Minutes = 168 Hours</strong></li>
                <li><strong>1 Year ≈ 31,536,000 Seconds (common) = 525,600 Minutes</strong></li>
                <li><strong>1 Decade ≈ 315,360,000 Seconds</strong></li>
                <li><strong>1 Century ≈ 3,153,600,000 Seconds</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>⏰ Time Converter | Complete Time Unit Conversion</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert seconds, minutes, hours, days, weeks, years, and other time units with precision</p>
        </div>
    </div>

    <script>
        // Conversion factors to seconds
        const toSeconds = {
            second: 1,
            millisecond: 0.001,
            microsecond: 0.000001,
            nanosecond: 1e-9,
            minute: 60,
            hour: 3600,
            day: 86400,
            week: 604800,
            month: 2629746, // Average month (365.25/12 days)
            year: 31536000, // Common year
            decade: 315360000,
            century: 3153600000,
            millennium: 31536000000,
            fortnight: 1209600,
            shake: 1e-8,
            planck: 5.39e-44
        };

        const unitNames = {
            second: 'Second (s)',
            millisecond: 'Millisecond (ms)',
            microsecond: 'Microsecond (μs)',
            nanosecond: 'Nanosecond (ns)',
            minute: 'Minute (min)',
            hour: 'Hour (hr)',
            day: 'Day (day)',
            week: 'Week (wk)',
            month: 'Month (mo)',
            year: 'Year (yr)',
            decade: 'Decade',
            century: 'Century',
            millennium: 'Millennium',
            fortnight: 'Fortnight',
            shake: 'Shake (nuclear)',
            planck: 'Planck Time'
        };

        function convert() {
            const inputValue = parseFloat(document.getElementById('inputValue').value);
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;

            if (isNaN(inputValue)) {
                document.getElementById('outputValue').value = '';
                document.getElementById('resultGrid').innerHTML = '';
                return;
            }

            // Convert to seconds first
            const valueInSeconds = inputValue * toSeconds[fromUnit];
            
            // Convert to target unit
            const result = valueInSeconds / toSeconds[toUnit];
            
            document.getElementById('outputValue').value = formatNumber(result);
            
            displayAllConversions(valueInSeconds);
        }

        function displayAllConversions(valueInSeconds) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInSeconds / toSeconds[unit];
                
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div class="result-unit">${name}</div>
                    <div class="result-value">${formatNumber(converted)}</div>
                `;
                resultGrid.appendChild(card);
            }
        }

        function formatNumber(num) {
            if (Math.abs(num) < 0.000001 || Math.abs(num) > 1e12) {
                return num.toExponential(6);
            }
            if (Math.abs(num) < 0.01) {
                return num.toFixed(8);
            }
            if (Math.abs(num) < 1) {
                return num.toFixed(6);
            }
            return num.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 4
            });
        }

        function swapUnits() {
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;
            
            document.getElementById('fromUnit').value = toUnit;
            document.getElementById('toUnit').value = fromUnit;
            
            convert();
        }

        function setInput(value) {
            document.getElementById('inputValue').value = value;
            convert();
        }

        function setCommonTime(value, description) {
            document.getElementById('inputValue').value = value;
            document.getElementById('fromUnit').value = 'minute';
            document.getElementById('toUnit').value = 'second';
            convert();
            console.log(description);
        }

        // Auto-convert on input
        document.getElementById('inputValue').addEventListener('input', convert);
        document.getElementById('fromUnit').addEventListener('change', convert);
        document.getElementById('toUnit').addEventListener('change', convert);

        // Initial conversion
        convert();
    </script>
</body>
</html>