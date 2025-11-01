<?php
/**
 * Date Difference Calculator
 * File: date-time/date-difference-calculator.php
 * Description: Calculate the difference between two dates in multiple formats
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Difference Calculator - Calculate Time Between Dates</title>
    <meta name="description" content="Free date difference calculator. Calculate the exact difference between two dates in years, months, weeks, days, hours, and minutes.">
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
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Date Difference Calculator</h1>
            <p>Calculate the exact difference between two dates</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Select Dates</h2>
                <form id="dateDiffForm">
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" id="startDate" value="2025-01-01" required>
                        <small>Enter the first date</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" id="endDate" required>
                        <small>Enter the second date</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Difference</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Difference Results</h2>
                
                <div class="result-card">
                    <h3>Total Difference</h3>
                    <div class="amount" id="totalDaysDisplay">305 Days</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Years</h4>
                        <div class="value" id="years">0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Months</h4>
                        <div class="value" id="months">10</div>
                    </div>
                    <div class="metric-card">
                        <h4>Days</h4>
                        <div class="value" id="days">1</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Detailed Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Years, Months, Days</span>
                        <strong id="fullBreakdown">0 years, 10 months, 1 day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Days</span>
                        <strong id="totalDays">305 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Weeks</span>
                        <strong id="totalWeeks">43 weeks, 4 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Months</span>
                        <strong id="totalMonths">10.0 months</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Time Units</h3>
                    <div class="breakdown-item">
                        <span>Total Hours</span>
                        <strong id="totalHours">7,320 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Minutes</span>
                        <strong id="totalMinutes">439,200 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Seconds</span>
                        <strong id="totalSeconds">26,352,000 seconds</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Date Information</h3>
                    <div class="breakdown-item">
                        <span>Start Date</span>
                        <strong id="startDateDisplay">January 1, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>End Date</span>
                        <strong id="endDateDisplay">November 1, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Start Day</span>
                        <strong id="startDay">Wednesday</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>End Day</span>
                        <strong id="endDay">Saturday</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Weekday Analysis</h3>
                    <div class="breakdown-item">
                        <span>Weekdays (Mon-Fri)</span>
                        <strong id="weekdays">218 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekend Days (Sat-Sun)</span>
                        <strong id="weekendDays">87 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Business Days</span>
                        <strong id="businessDays">218 days</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Date Difference:</strong> This calculator finds the exact time difference between two dates, accounting for varying month lengths and leap years automatically.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📊 Date Difference Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Precise calculations between any two dates</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('dateDiffForm');
        const endDateInput = document.getElementById('endDate');

        // Set today's date as default
        const today = new Date();
        endDateInput.value = today.toISOString().split('T')[0];

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateDifference();
        });

        function calculateDifference() {
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);

            if (startDate > endDate) {
                alert('Start date must be before end date!');
                return;
            }

            // Calculate total days
            const totalDaysValue = Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24));
            const totalHoursValue = totalDaysValue * 24;
            const totalMinutesValue = totalHoursValue * 60;
            const totalSecondsValue = totalMinutesValue * 60;

            // Calculate years, months, days
            let years = endDate.getFullYear() - startDate.getFullYear();
            let months = endDate.getMonth() - startDate.getMonth();
            let days = endDate.getDate() - startDate.getDate();

            if (days < 0) {
                months--;
                const prevMonth = new Date(endDate.getFullYear(), endDate.getMonth(), 0);
                days += prevMonth.getDate();
            }

            if (months < 0) {
                years--;
                months += 12;
            }

            // Calculate weeks
            const totalWeeks = Math.floor(totalDaysValue / 7);
            const remainingDays = totalDaysValue % 7;

            // Calculate approximate total months
            const totalMonthsValue = (years * 12 + months + (days / 30)).toFixed(1);

            // Count weekdays and weekend days
            let weekdaysCount = 0;
            let weekendCount = 0;
            let currentDate = new Date(startDate);
            
            while (currentDate <= endDate) {
                const dayOfWeek = currentDate.getDay();
                if (dayOfWeek === 0 || dayOfWeek === 6) {
                    weekendCount++;
                } else {
                    weekdaysCount++;
                }
                currentDate.setDate(currentDate.getDate() + 1);
            }

            // Day of week
            const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const startDay = daysOfWeek[startDate.getDay()];
            const endDay = daysOfWeek[endDate.getDay()];

            // Update UI
            document.getElementById('totalDaysDisplay').textContent = totalDaysValue.toLocaleString() + ' Days';
            document.getElementById('years').textContent = years;
            document.getElementById('months').textContent = months;
            document.getElementById('days').textContent = days;

            document.getElementById('fullBreakdown').textContent = `${years} year${years !== 1 ? 's' : ''}, ${months} month${months !== 1 ? 's' : ''}, ${days} day${days !== 1 ? 's' : ''}`;
            document.getElementById('totalDays').textContent = totalDaysValue.toLocaleString() + ' days';
            document.getElementById('totalWeeks').textContent = `${totalWeeks} week${totalWeeks !== 1 ? 's' : ''}, ${remainingDays} day${remainingDays !== 1 ? 's' : ''}`;
            document.getElementById('totalMonths').textContent = totalMonthsValue + ' months';

            document.getElementById('totalHours').textContent = totalHoursValue.toLocaleString() + ' hours';
            document.getElementById('totalMinutes').textContent = totalMinutesValue.toLocaleString() + ' minutes';
            document.getElementById('totalSeconds').textContent = totalSecondsValue.toLocaleString() + ' seconds';

            document.getElementById('startDateDisplay').textContent = formatDate(startDate);
            document.getElementById('endDateDisplay').textContent = formatDate(endDate);
            document.getElementById('startDay').textContent = startDay;
            document.getElementById('endDay').textContent = endDay;

            document.getElementById('weekdays').textContent = weekdaysCount.toLocaleString() + ' days';
            document.getElementById('weekendDays').textContent = weekendCount.toLocaleString() + ' days';
            document.getElementById('businessDays').textContent = weekdaysCount.toLocaleString() + ' days';
        }

        function formatDate(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        window.addEventListener('load', function() {
            calculateDifference();
        });
    </script>
</body>
</html>