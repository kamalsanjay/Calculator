<?php
/**
 * Time Difference Calculator
 * File: date-time/time-difference-calculator.php
 * Description: Calculate the difference between two times
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Difference Calculator - Calculate Time Between Two Times</title>
    <meta name="description" content="Free time difference calculator. Calculate the exact difference between two times in hours and minutes. Perfect for work hours and time tracking.">
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
        .form-group input { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
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
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⏲️ Time Difference Calculator</h1>
            <p>Calculate the exact difference between two times</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Time Period</h2>
                <form id="timeDiffForm">
                    <div class="form-group">
                        <label for="startTime">Start Time</label>
                        <input type="time" id="startTime" value="09:00" required>
                        <small>Enter starting time</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="endTime">End Time</label>
                        <input type="time" id="endTime" value="17:30" required>
                        <small>Enter ending time</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Difference</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Time Results</h2>
                
                <div class="result-card">
                    <h3>Time Difference</h3>
                    <div class="amount" id="timeDiffDisplay">8h 30m</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Hours</h4>
                        <div class="value" id="hours">8</div>
                    </div>
                    <div class="metric-card">
                        <h4>Minutes</h4>
                        <div class="value" id="minutes">30</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Time Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Hours and Minutes</span>
                        <strong id="hoursMinutes">8 hours, 30 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Hours</span>
                        <strong id="totalHours">8.50 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Minutes</span>
                        <strong id="totalMinutes">510 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Decimal Hours</span>
                        <strong id="decimalHours">8.50</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Time Details</h3>
                    <div class="breakdown-item">
                        <span>Start Time</span>
                        <strong id="startTimeDisplay">9:00 AM</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>End Time</span>
                        <strong id="endTimeDisplay">5:30 PM</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Duration</span>
                        <strong id="duration">8:30</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Format Conversions</h3>
                    <div class="breakdown-item">
                        <span>HH:MM Format</span>
                        <strong id="hhmmFormat">08:30</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Seconds</span>
                        <strong id="totalSeconds">30,600 seconds</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Percentage of Day</span>
                        <strong id="percentageDay">35.4%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Work Calculations</h3>
                    <div class="breakdown-item">
                        <span>Standard Workday (8h)</span>
                        <strong id="workdayEquiv">1.06 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hourly Rate ($20/hr)</span>
                        <strong id="rate20">$170.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hourly Rate ($25/hr)</span>
                        <strong id="rate25">$212.50</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hourly Rate ($30/hr)</span>
                        <strong id="rate30">$255.00</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Time Difference:</strong> This calculator computes the exact time difference between two times. If end time is earlier than start time, it assumes next day.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⏲️ Time Difference Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Accurate time calculations for any period</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('timeDiffForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateTimeDifference();
        });

        function calculateTimeDifference() {
            const startTime = document.getElementById('startTime').value;
            const endTime = document.getElementById('endTime').value;

            // Parse times
            const [startHour, startMin] = startTime.split(':').map(Number);
            const [endHour, endMin] = endTime.split(':').map(Number);

            // Convert to minutes
            let startTotalMin = startHour * 60 + startMin;
            let endTotalMin = endHour * 60 + endMin;

            // Handle overnight (if end is before start, assume next day)
            if (endTotalMin < startTotalMin) {
                endTotalMin += 24 * 60; // Add 24 hours
            }

            // Calculate difference
            const diffMinutes = endTotalMin - startTotalMin;
            const hours = Math.floor(diffMinutes / 60);
            const minutes = diffMinutes % 60;

            // Decimal hours
            const decimalHoursValue = (diffMinutes / 60).toFixed(2);

            // Total seconds
            const totalSecondsValue = diffMinutes * 60;

            // Percentage of day
            const percentageValue = ((diffMinutes / (24 * 60)) * 100).toFixed(1);

            // Work equivalents
            const workdayEquiv = (diffMinutes / (8 * 60)).toFixed(2);

            // Pay calculations
            const pay20 = (parseFloat(decimalHoursValue) * 20).toFixed(2);
            const pay25 = (parseFloat(decimalHoursValue) * 25).toFixed(2);
            const pay30 = (parseFloat(decimalHoursValue) * 30).toFixed(2);

            // Format times
            const start12 = format12Hour(startHour, startMin);
            const end12 = format12Hour(endHour, endMin);
            const hhmmFormat = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;

            // Update UI
            document.getElementById('timeDiffDisplay').textContent = `${hours}h ${minutes}m`;
            document.getElementById('hours').textContent = hours;
            document.getElementById('minutes').textContent = minutes;

            document.getElementById('hoursMinutes').textContent = `${hours} hour${hours !== 1 ? 's' : ''}, ${minutes} minute${minutes !== 1 ? 's' : ''}`;
            document.getElementById('totalHours').textContent = decimalHoursValue + ' hours';
            document.getElementById('totalMinutes').textContent = diffMinutes.toLocaleString() + ' minutes';
            document.getElementById('decimalHours').textContent = decimalHoursValue;

            document.getElementById('startTimeDisplay').textContent = start12;
            document.getElementById('endTimeDisplay').textContent = end12;
            document.getElementById('duration').textContent = hhmmFormat;

            document.getElementById('hhmmFormat').textContent = hhmmFormat;
            document.getElementById('totalSeconds').textContent = totalSecondsValue.toLocaleString() + ' seconds';
            document.getElementById('percentageDay').textContent = percentageValue + '%';

            document.getElementById('workdayEquiv').textContent = workdayEquiv + ' days';
            document.getElementById('rate20').textContent = '$' + pay20;
            document.getElementById('rate25').textContent = '$' + pay25;
            document.getElementById('rate30').textContent = '$' + pay30;
        }

        function format12Hour(hour, minute) {
            const period = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${String(minute).padStart(2, '0')} ${period}`;
        }

        window.addEventListener('load', function() {
            calculateTimeDifference();
        });
    </script>
</body>
</html>