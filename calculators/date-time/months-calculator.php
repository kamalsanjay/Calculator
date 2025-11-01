<?php
/**
 * Months Calculator
 * File: date-time/months-calculator.php
 * Description: Calculate months between two dates with detailed breakdown
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Months Calculator - Calculate Months Between Dates</title>
    <meta name="description" content="Free months calculator. Calculate the exact number of months between two dates including years, months, weeks, and days breakdown.">
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
            <h1>📆 Months Calculator</h1>
            <p>Calculate the exact number of months between two dates</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Select Dates</h2>
                <form id="monthsForm">
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" id="startDate" value="2025-01-01" required>
                        <small>Enter the starting date</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" id="endDate" required>
                        <small>Enter the ending date</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Months</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Months Results</h2>
                
                <div class="result-card">
                    <h3>Total Months</h3>
                    <div class="amount" id="totalMonthsDisplay">10 Months</div>
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
                        <span>Full Duration</span>
                        <strong id="fullDuration">0 years, 10 months, 1 day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Months</span>
                        <strong id="totalMonths">10 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Decimal Months</span>
                        <strong id="decimalMonths">10.03 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Days</span>
                        <strong id="totalDays">305 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Weeks</span>
                        <strong id="totalWeeks">43 weeks</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Month-by-Month</h3>
                    <div class="breakdown-item">
                        <span>Complete Months</span>
                        <strong id="completeMonths">10 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Remaining Days</span>
                        <strong id="remainingDays">1 day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Days/Month</span>
                        <strong id="avgDaysMonth">30.5 days</strong>
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
                        <span>Start Month</span>
                        <strong id="startMonth">January</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>End Month</span>
                        <strong id="endMonth">November</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Calendar Year(s)</span>
                        <strong id="calendarYears">2025</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Quarter Analysis</h3>
                    <div class="breakdown-item">
                        <span>Start Quarter</span>
                        <strong id="startQuarter">Q1 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>End Quarter</span>
                        <strong id="endQuarter">Q4 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Quarters Spanned</span>
                        <strong id="quartersSpanned">4 quarters</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Months Calculation:</strong> The calculation counts complete calendar months between dates, accounting for varying month lengths. Remaining days are shown separately.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📆 Months Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Accurate month calculations between any two dates</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('monthsForm');
        const endDateInput = document.getElementById('endDate');

        // Set today's date as default for end date
        const today = new Date();
        endDateInput.value = today.toISOString().split('T')[0];

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateMonths();
        });

        function calculateMonths() {
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);

            if (startDate > endDate) {
                alert('Start date must be before end date!');
                return;
            }

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

            // Total months
            const totalMonthsValue = years * 12 + months;

            // Calculate decimal months (approximate)
            const totalDaysValue = Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24));
            const decimalMonthsValue = (totalDaysValue / 30.44).toFixed(2); // Average month length

            // Calculate weeks
            const totalWeeksValue = Math.floor(totalDaysValue / 7);

            // Month names
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const startMonth = monthNames[startDate.getMonth()];
            const endMonth = monthNames[endDate.getMonth()];

            // Quarter analysis
            const startQuarter = Math.floor(startDate.getMonth() / 3) + 1;
            const endQuarter = Math.floor(endDate.getMonth() / 3) + 1;
            const startYear = startDate.getFullYear();
            const endYear = endDate.getFullYear();

            // Quarters spanned
            const totalQuarters = ((endYear - startYear) * 4) + (endQuarter - startQuarter) + 1;

            // Calendar years
            const yearDiff = endYear - startYear;
            let calendarYearsText = '';
            if (yearDiff === 0) {
                calendarYearsText = startYear.toString();
            } else {
                calendarYearsText = `${startYear} - ${endYear}`;
            }

            // Update UI
            document.getElementById('totalMonthsDisplay').textContent = totalMonthsValue + ' Month' + (totalMonthsValue !== 1 ? 's' : '');
            document.getElementById('years').textContent = years;
            document.getElementById('months').textContent = months;
            document.getElementById('days').textContent = days;

            document.getElementById('fullDuration').textContent = `${years} year${years !== 1 ? 's' : ''}, ${months} month${months !== 1 ? 's' : ''}, ${days} day${days !== 1 ? 's' : ''}`;
            document.getElementById('totalMonths').textContent = totalMonthsValue + ' months';
            document.getElementById('decimalMonths').textContent = decimalMonthsValue + ' months';
            document.getElementById('totalDays').textContent = totalDaysValue.toLocaleString() + ' days';
            document.getElementById('totalWeeks').textContent = totalWeeksValue.toLocaleString() + ' weeks';

            document.getElementById('completeMonths').textContent = totalMonthsValue + ' months';
            document.getElementById('remainingDays').textContent = days + ' day' + (days !== 1 ? 's' : '');
            document.getElementById('avgDaysMonth').textContent = '30.5 days';

            document.getElementById('startDateDisplay').textContent = formatDate(startDate);
            document.getElementById('endDateDisplay').textContent = formatDate(endDate);
            document.getElementById('startMonth').textContent = startMonth;
            document.getElementById('endMonth').textContent = endMonth;
            document.getElementById('calendarYears').textContent = calendarYearsText;

            document.getElementById('startQuarter').textContent = `Q${startQuarter} ${startYear}`;
            document.getElementById('endQuarter').textContent = `Q${endQuarter} ${endYear}`;
            document.getElementById('quartersSpanned').textContent = totalQuarters + ' quarter' + (totalQuarters !== 1 ? 's' : '');
        }

        function formatDate(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        window.addEventListener('load', function() {
            calculateMonths();
        });
    </script>
</body>
</html>