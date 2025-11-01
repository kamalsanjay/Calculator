<?php
/**
 * Hours Calculator
 * File: date-time/hours-calculator.php
 * Description: Calculate hours and minutes between two times or dates
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hours Calculator - Calculate Hours Between Times</title>
    <meta name="description" content="Free hours calculator. Calculate hours and minutes between two times or dates. Perfect for work hours, time tracking, and scheduling.">
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
        
        .metric-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px; }
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
            <h1>⏰ Hours Calculator</h1>
            <p>Calculate hours and minutes between two times</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Time Period</h2>
                <form id="hoursForm">
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" id="startDate" required>
                        <small>Select starting date</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Start Time</label>
                        <div class="time-row">
                            <input type="time" id="startTime" value="09:00" required>
                        </div>
                        <small>Select starting time</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" id="endDate" required>
                        <small>Select ending date</small>
                    </div>
                    
                    <div class="form-group">
                        <label>End Time</label>
                        <div class="time-row">
                            <input type="time" id="endTime" value="17:00" required>
                        </div>
                        <small>Select ending time</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Hours</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Hours Results</h2>
                
                <div class="result-card">
                    <h3>Total Hours</h3>
                    <div class="amount" id="totalHoursDisplay">8.0 Hours</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Hours</h4>
                        <div class="value" id="hours">8</div>
                    </div>
                    <div class="metric-card">
                        <h4>Minutes</h4>
                        <div class="value" id="minutes">0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Days</h4>
                        <div class="value" id="days">0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Time Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Total Hours</span>
                        <strong id="totalHours">8.0 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Minutes</span>
                        <strong id="totalMinutes">480 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Seconds</span>
                        <strong id="totalSeconds">28,800 seconds</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Decimal Hours</span>
                        <strong id="decimalHours">8.00</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Time Period Details</h3>
                    <div class="breakdown-item">
                        <span>Start</span>
                        <strong id="startDisplay">Nov 1, 2025 at 9:00 AM</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>End</span>
                        <strong id="endDisplay">Nov 1, 2025 at 5:00 PM</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Duration</span>
                        <strong id="durationDisplay">8 hours, 0 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Days Span</span>
                        <strong id="daysSpan">Same day</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Work Hours Analysis</h3>
                    <div class="breakdown-item">
                        <span>Standard Workday (8h)</span>
                        <strong id="workdayEquivalent">1.0 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Standard Workweek (40h)</span>
                        <strong id="workweekEquivalent">0.2 weeks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hourly Rate ($20/hr)</span>
                        <strong id="hourlyRate20">$160.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hourly Rate ($25/hr)</span>
                        <strong id="hourlyRate25">$200.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hourly Rate ($30/hr)</span>
                        <strong id="hourlyRate30">$240.00</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Hours Calculation:</strong> This calculator computes the exact time difference between two datetime points. Perfect for calculating work hours, project time, or any time duration.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⏰ Hours Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Accurate time calculations for any period</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('hoursForm');
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');

        // Set today's date as default
        const today = new Date();
        startDateInput.value = today.toISOString().split('T')[0];
        endDateInput.value = today.toISOString().split('T')[0];

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateHours();
        });

        function calculateHours() {
            const startDate = document.getElementById('startDate').value;
            const startTime = document.getElementById('startTime').value;
            const endDate = document.getElementById('endDate').value;
            const endTime = document.getElementById('endTime').value;

            // Create datetime objects
            const start = new Date(`${startDate}T${startTime}`);
            const end = new Date(`${endDate}T${endTime}`);

            if (start >= end) {
                alert('End time must be after start time!');
                return;
            }

            // Calculate total milliseconds
            const diffMs = end - start;
            
            // Calculate components
            const totalSeconds = Math.floor(diffMs / 1000);
            const totalMinutes = Math.floor(totalSeconds / 60);
            const totalHours = totalMinutes / 60;
            
            const days = Math.floor(totalHours / 24);
            const hours = Math.floor(totalHours % 24);
            const minutes = totalMinutes % 60;

            // Decimal hours
            const decimalHours = totalHours.toFixed(2);

            // Work equivalents
            const workdayEquivalent = (totalHours / 8).toFixed(1);
            const workweekEquivalent = (totalHours / 40).toFixed(2);

            // Hourly rates
            const rate20 = (totalHours * 20).toFixed(2);
            const rate25 = (totalHours * 25).toFixed(2);
            const rate30 = (totalHours * 30).toFixed(2);

            // Days span
            const daysDiff = Math.floor((end.setHours(0,0,0,0) - start.setHours(0,0,0,0)) / (1000 * 60 * 60 * 24));
            let daysSpanText = daysDiff === 0 ? 'Same day' : `${daysDiff} day${daysDiff !== 1 ? 's' : ''} apart`;

            // Format display
            const startDisplay = formatDateTime(new Date(`${startDate}T${startTime}`));
            const endDisplay = formatDateTime(new Date(`${endDate}T${endTime}`));

            // Update UI
            document.getElementById('totalHoursDisplay').textContent = totalHours.toFixed(1) + ' Hours';
            document.getElementById('hours').textContent = Math.floor(totalHours);
            document.getElementById('minutes').textContent = minutes;
            document.getElementById('days').textContent = days;

            document.getElementById('totalHours').textContent = totalHours.toFixed(1) + ' hours';
            document.getElementById('totalMinutes').textContent = totalMinutes.toLocaleString() + ' minutes';
            document.getElementById('totalSeconds').textContent = totalSeconds.toLocaleString() + ' seconds';
            document.getElementById('decimalHours').textContent = decimalHours;

            document.getElementById('startDisplay').textContent = startDisplay;
            document.getElementById('endDisplay').textContent = endDisplay;
            document.getElementById('durationDisplay').textContent = `${hours} hours, ${minutes} minutes`;
            document.getElementById('daysSpan').textContent = daysSpanText;

            document.getElementById('workdayEquivalent').textContent = workdayEquivalent + ' days';
            document.getElementById('workweekEquivalent').textContent = workweekEquivalent + ' weeks';
            document.getElementById('hourlyRate20').textContent = '$' + rate20;
            document.getElementById('hourlyRate25').textContent = '$' + rate25;
            document.getElementById('hourlyRate30').textContent = '$' + rate30;
        }

        function formatDateTime(date) {
            const dateOptions = { year: 'numeric', month: 'short', day: 'numeric' };
            const timeOptions = { hour: 'numeric', minute: '2-digit', hour12: true };
            
            const dateStr = date.toLocaleDateString('en-US', dateOptions);
            const timeStr = date.toLocaleTimeString('en-US', timeOptions);
            
            return `${dateStr} at ${timeStr}`;
        }

        window.addEventListener('load', function() {
            calculateHours();
        });
    </script>
</body>
</html>