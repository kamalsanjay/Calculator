<?php
/**
 * Days Until Calculator
 * File: date-time/days-until-calculator.php
 * Description: Calculate how many days until a future event or date
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Days Until Calculator - Countdown to Any Date</title>
    <meta name="description" content="Free days until calculator. Count down days, weeks, months until any future event, birthday, holiday, vacation, or special date.">
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
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); }
        
        .quick-dates { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 20px; }
        .quick-btn { background: #f8f9fa; border: 2px solid #e0e0e0; padding: 10px; border-radius: 8px; font-size: 14px; cursor: pointer; transition: all 0.3s; }
        .quick-btn:hover { background: #e8e9ea; border-color: #667eea; }
        
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
            .quick-dates { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⏳ Days Until Calculator</h1>
            <p>Count down to any future event or date</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Event Details</h2>
                <form id="daysUntilForm">
                    <div class="form-group">
                        <label for="eventName">Event Name (Optional)</label>
                        <input type="text" id="eventName" placeholder="e.g., Birthday, Vacation, Wedding">
                        <small>Give your countdown a name</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="targetDate">Target Date</label>
                        <input type="date" id="targetDate" value="2025-12-25" required>
                        <small>Select the future date</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Dates</label>
                        <div class="quick-dates">
                            
                            <button type="button" class="quick-btn" onclick="setQuickDate('newyear')">New Year 2026</button>
                            <button type="button" class="quick-btn" onclick="setQuickDate('30days')">30 Days</button>
                            <button type="button" class="quick-btn" onclick="setQuickDate('90days')">90 Days</button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Countdown</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Countdown Results</h2>
                
                <div class="result-card">
                    <h3 id="eventTitle">Christmas 2025</h3>
                    <div class="amount" id="daysUntilDisplay">55 Days</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Weeks</h4>
                        <div class="value" id="weeks">7</div>
                    </div>
                    <div class="metric-card">
                        <h4>Months</h4>
                        <div class="value" id="months">1</div>
                    </div>
                    <div class="metric-card">
                        <h4>Hours</h4>
                        <div class="value" id="hours">1,320</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Time Remaining</h3>
                    <div class="breakdown-item">
                        <span>Total Days</span>
                        <strong id="totalDays">55 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Hours</span>
                        <strong id="totalHours">1,320 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Minutes</span>
                        <strong id="totalMinutes">79,200 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Seconds</span>
                        <strong id="totalSeconds">4,752,000 seconds</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Date Information</h3>
                    <div class="breakdown-item">
                        <span>Today</span>
                        <strong id="todayDisplay">November 1, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Target Date</span>
                        <strong id="targetDateDisplay">December 25, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Target Day</span>
                        <strong id="targetDay">Thursday</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekdays Until</span>
                        <strong id="weekdaysUntil">39 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekend Days Until</span>
                        <strong id="weekendDaysUntil">16 days</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Full Duration</span>
                        <strong id="fullDuration">1 month, 24 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Complete Weeks</span>
                        <strong id="completeWeeks">7 weeks, 6 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Percentage of Year</span>
                        <strong id="percentageOfYear">15.1%</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Countdown Timer:</strong> This calculator shows how many days remain until your target date. All calculations are from today's date to the selected future date.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⏳ Days Until Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Count down to your special moments</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('daysUntilForm');
        const targetDateInput = document.getElementById('targetDate');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateDaysUntil();
        });

        function setQuickDate(type) {
            const today = new Date();
            let targetDate = new Date();

            switch(type) {
                case 'christmas':
                    targetDate = new Date(today.getFullYear(), 11, 25); // Dec 25
                    if (targetDate < today) targetDate.setFullYear(today.getFullYear() + 1);
                    document.getElementById('eventName').value = 'Christmas';
                    break;
                case 'newyear':
                    targetDate = new Date(today.getFullYear() + 1, 0, 1); // Jan 1 next year
                    document.getElementById('eventName').value = 'New Year';
                    break;
                case '30days':
                    targetDate.setDate(today.getDate() + 30);
                    document.getElementById('eventName').value = '30 Days From Now';
                    break;
                case '90days':
                    targetDate.setDate(today.getDate() + 90);
                    document.getElementById('eventName').value = '90 Days From Now';
                    break;
            }

            targetDateInput.value = targetDate.toISOString().split('T')[0];
            calculateDaysUntil();
        }

        function calculateDaysUntil() {
            const eventName = document.getElementById('eventName').value || 'Your Event';
            const targetDate = new Date(document.getElementById('targetDate').value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            targetDate.setHours(0, 0, 0, 0);

            if (targetDate <= today) {
                alert('Please select a future date!');
                return;
            }

            // Calculate total days
            const totalDaysValue = Math.floor((targetDate - today) / (1000 * 60 * 60 * 24));
            const totalHoursValue = totalDaysValue * 24;
            const totalMinutesValue = totalHoursValue * 60;
            const totalSecondsValue = totalMinutesValue * 60;

            // Calculate weeks and months
            const weeksValue = Math.floor(totalDaysValue / 7);
            const remainingDays = totalDaysValue % 7;

            // Calculate months and days
            let months = 0;
            let days = 0;
            let tempDate = new Date(today);
            
            while (tempDate < targetDate) {
                const nextMonth = new Date(tempDate);
                nextMonth.setMonth(nextMonth.getMonth() + 1);
                
                if (nextMonth <= targetDate) {
                    months++;
                    tempDate = nextMonth;
                } else {
                    break;
                }
            }
            
            days = Math.floor((targetDate - tempDate) / (1000 * 60 * 60 * 24));

            // Count weekdays and weekend days
            let weekdaysCount = 0;
            let weekendCount = 0;
            let currentDate = new Date(today);
            
            while (currentDate < targetDate) {
                const dayOfWeek = currentDate.getDay();
                if (dayOfWeek === 0 || dayOfWeek === 6) {
                    weekendCount++;
                } else {
                    weekdaysCount++;
                }
                currentDate.setDate(currentDate.getDate() + 1);
            }

            // Day of week for target
            const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const targetDay = daysOfWeek[targetDate.getDay()];

            // Percentage of year
            const daysInYear = 365;
            const percentage = ((totalDaysValue / daysInYear) * 100).toFixed(1);

            // Update UI
            document.getElementById('eventTitle').textContent = eventName;
            document.getElementById('daysUntilDisplay').textContent = totalDaysValue.toLocaleString() + ' Days';
            document.getElementById('weeks').textContent = weeksValue;
            document.getElementById('months').textContent = months;
            document.getElementById('hours').textContent = totalHoursValue.toLocaleString();

            document.getElementById('totalDays').textContent = totalDaysValue.toLocaleString() + ' days';
            document.getElementById('totalHours').textContent = totalHoursValue.toLocaleString() + ' hours';
            document.getElementById('totalMinutes').textContent = totalMinutesValue.toLocaleString() + ' minutes';
            document.getElementById('totalSeconds').textContent = totalSecondsValue.toLocaleString() + ' seconds';

            document.getElementById('todayDisplay').textContent = formatDate(today);
            document.getElementById('targetDateDisplay').textContent = formatDate(targetDate);
            document.getElementById('targetDay').textContent = targetDay;
            document.getElementById('weekdaysUntil').textContent = weekdaysCount.toLocaleString() + ' days';
            document.getElementById('weekendDaysUntil').textContent = weekendCount.toLocaleString() + ' days';

            document.getElementById('fullDuration').textContent = `${months} month${months !== 1 ? 's' : ''}, ${days} day${days !== 1 ? 's' : ''}`;
            document.getElementById('completeWeeks').textContent = `${weeksValue} week${weeksValue !== 1 ? 's' : ''}, ${remainingDays} day${remainingDays !== 1 ? 's' : ''}`;
            document.getElementById('percentageOfYear').textContent = percentage + '%';
        }

        function formatDate(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        window.addEventListener('load', function() {
            calculateDaysUntil();
        });
    </script>
</body>
</html>