<?php
/**
 * Time Calculator
 * File: date-time/time-calculator.php
 * Description: Add or subtract time periods with hours and minutes
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Calculator - Add or Subtract Hours and Minutes</title>
    <meta name="description" content="Free time calculator. Add or subtract hours and minutes. Calculate time durations, work hours, and time spans easily.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
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
        
        .time-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; }
        .result-card .amount { font-size: 3rem; font-weight: bold; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #667eea; font-size: 2rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #667eea; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .info-box { background: #e8f2ff; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .header h1 { font-size: 2rem; }
            .result-card .amount { font-size: 2.5rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .time-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⏱️ Time Calculator</h1>
            <p>Add or subtract hours and minutes</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Time Operation</h2>
                <form id="timeForm">
                    <div class="form-group">
                        <label>Starting Time</label>
                        <div class="time-row">
                            <input type="number" id="startHours" placeholder="Hours" value="8" min="0">
                            <input type="number" id="startMinutes" placeholder="Minutes" value="30" min="0" max="59">
                        </div>
                        <small>Enter starting hours and minutes</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="operation">Operation</label>
                        <select id="operation">
                            <option value="add">Add Time</option>
                            <option value="subtract">Subtract Time</option>
                        </select>
                        <small>Choose to add or subtract</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Time to Add/Subtract</label>
                        <div class="time-row">
                            <input type="number" id="adjustHours" placeholder="Hours" value="2" min="0">
                            <input type="number" id="adjustMinutes" placeholder="Minutes" value="45" min="0" max="59">
                        </div>
                        <small>Enter hours and minutes to adjust</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Time</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Time Results</h2>
                
                <div class="result-card">
                    <h3>Result Time</h3>
                    <div class="amount" id="resultTimeDisplay">11:15</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Hours</h4>
                        <div class="value" id="resultHours">11</div>
                    </div>
                    <div class="metric-card">
                        <h4>Minutes</h4>
                        <div class="value" id="resultMinutes">15</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Time Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Result (HH:MM)</span>
                        <strong id="hhmmFormat">11:15</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Hours</span>
                        <strong id="totalHours">11.25 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Minutes</span>
                        <strong id="totalMinutes">675 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Decimal Hours</span>
                        <strong id="decimalHours">11.25</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Calculation Details</h3>
                    <div class="breakdown-item">
                        <span>Starting Time</span>
                        <strong id="startingTime">8:30</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Operation</span>
                        <strong id="operationDisplay">Add</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Adjustment</span>
                        <strong id="adjustmentTime">2:45</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Result</span>
                        <strong id="resultTime">11:15</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Format Conversions</h3>
                    <div class="breakdown-item">
                        <span>12-Hour Format</span>
                        <strong id="format12Hour">11:15 AM</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>24-Hour Format</span>
                        <strong id="format24Hour">11:15</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Time of Day</span>
                        <strong id="timeOfDay">Morning</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Additional Calculations</h3>
                    <div class="breakdown-item">
                        <span>Days Equivalent</span>
                        <strong id="daysEquivalent">0.47 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weeks Equivalent</span>
                        <strong id="weeksEquivalent">0.07 weeks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Working Days (8h)</span>
                        <strong id="workingDays">1.41 days</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Time Calculation:</strong> This calculator adds or subtracts time periods. Perfect for calculating work shifts, time durations, or scheduling tasks.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⏱️ Time Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Easy time calculations for any duration</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('timeForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateTime();
        });

        function calculateTime() {
            const startHours = parseInt(document.getElementById('startHours').value) || 0;
            const startMinutes = parseInt(document.getElementById('startMinutes').value) || 0;
            const operation = document.getElementById('operation').value;
            const adjustHours = parseInt(document.getElementById('adjustHours').value) || 0;
            const adjustMinutes = parseInt(document.getElementById('adjustMinutes').value) || 0;

            // Convert to total minutes
            let startTotalMinutes = (startHours * 60) + startMinutes;
            const adjustTotalMinutes = (adjustHours * 60) + adjustMinutes;

            // Perform operation
            if (operation === 'add') {
                startTotalMinutes += adjustTotalMinutes;
            } else {
                startTotalMinutes -= adjustTotalMinutes;
            }

            // Handle negative results
            if (startTotalMinutes < 0) {
                startTotalMinutes = 0;
            }

            // Convert back to hours and minutes
            const resultHours = Math.floor(startTotalMinutes / 60);
            const resultMinutes = startTotalMinutes % 60;

            // Format times
            const startTimeFormatted = formatTime(startHours, startMinutes);
            const adjustTimeFormatted = formatTime(adjustHours, adjustMinutes);
            const resultTimeFormatted = formatTime(resultHours, resultMinutes);

            // 12-hour format
            const format12 = format12Hour(resultHours, resultMinutes);

            // Time of day
            let timeOfDay = 'Night';
            if (resultHours >= 5 && resultHours < 12) timeOfDay = 'Morning';
            else if (resultHours >= 12 && resultHours < 17) timeOfDay = 'Afternoon';
            else if (resultHours >= 17 && resultHours < 21) timeOfDay = 'Evening';

            // Calculations
            const totalHoursValue = (startTotalMinutes / 60).toFixed(2);
            const daysEquivalent = (startTotalMinutes / (24 * 60)).toFixed(2);
            const weeksEquivalent = (startTotalMinutes / (7 * 24 * 60)).toFixed(2);
            const workingDays = (startTotalMinutes / (8 * 60)).toFixed(2);

            // Update UI
            document.getElementById('resultTimeDisplay').textContent = resultTimeFormatted;
            document.getElementById('resultHours').textContent = resultHours;
            document.getElementById('resultMinutes').textContent = resultMinutes;

            document.getElementById('hhmmFormat').textContent = resultTimeFormatted;
            document.getElementById('totalHours').textContent = totalHoursValue + ' hours';
            document.getElementById('totalMinutes').textContent = startTotalMinutes.toLocaleString() + ' minutes';
            document.getElementById('decimalHours').textContent = totalHoursValue;

            document.getElementById('startingTime').textContent = startTimeFormatted;
            document.getElementById('operationDisplay').textContent = operation.charAt(0).toUpperCase() + operation.slice(1);
            document.getElementById('adjustmentTime').textContent = adjustTimeFormatted;
            document.getElementById('resultTime').textContent = resultTimeFormatted;

            document.getElementById('format12Hour').textContent = format12;
            document.getElementById('format24Hour').textContent = resultTimeFormatted;
            document.getElementById('timeOfDay').textContent = timeOfDay;

            document.getElementById('daysEquivalent').textContent = daysEquivalent + ' days';
            document.getElementById('weeksEquivalent').textContent = weeksEquivalent + ' weeks';
            document.getElementById('workingDays').textContent = workingDays + ' days';
        }

        function formatTime(hours, minutes) {
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
        }

        function format12Hour(hours, minutes) {
            const period = hours >= 12 ? 'PM' : 'AM';
            const displayHours = hours % 12 || 12;
            return `${displayHours}:${String(minutes).padStart(2, '0')} ${period}`;
        }

        window.addEventListener('load', function() {
            calculateTime();
        });
    </script>
</body>
</html>