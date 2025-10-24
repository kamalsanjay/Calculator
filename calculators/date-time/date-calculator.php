<?php
/**
 * Date Calculator
 * File: date-calculator.php
 * Description: Calculate days, weeks, months between two dates and add/subtract dates
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Calculator - Calculate Days Between Dates & Date Difference</title>
    <meta name="description" content="Free date calculator. Calculate days, weeks, months between two dates. Add or subtract days from any date. Find date difference and duration easily.">
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
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
        
        .metric-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
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
</head>
<body>
    <header>
        <h1>📅 Date Calculator</h1>
        <p>Calculate days between dates and date differences</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Date Selection</h2>
                <form id="dateForm">
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" id="startDate" value="2025-01-01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" id="endDate" required>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="includeEndDate"> Include End Date
                        </label>
                        <small>Add 1 day to the total count</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Difference</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Date Difference</h2>
                
                <div class="result-card">
                    <h3>Total Days</h3>
                    <div class="amount" id="totalDays">0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Years</h4>
                        <div class="value" id="years">0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Months</h4>
                        <div class="value" id="months">0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Days</h4>
                        <div class="value" id="days">0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Time Duration</h3>
                    <div class="breakdown-item">
                        <span>Full Duration</span>
                        <strong id="fullDuration">0 years, 0 months, 0 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Days</span>
                        <strong id="totalDaysDisplay">0 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Weeks</span>
                        <strong id="totalWeeks">0 weeks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Months</span>
                        <strong id="totalMonths">0 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Hours</span>
                        <strong id="totalHours">0 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Minutes</span>
                        <strong id="totalMinutes">0 minutes</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Date Information</h3>
                    <div class="breakdown-item">
                        <span>Start Date</span>
                        <strong id="startDateDisplay">-</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>End Date</span>
                        <strong id="endDateDisplay">-</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Include End Date</span>
                        <strong id="includeEndDisplay">No</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Working Days</h3>
                    <div class="breakdown-item">
                        <span>Total Calendar Days</span>
                        <strong id="calendarDays">0 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Approximate Working Days</span>
                        <strong id="workingDays">0 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Approximate Weekend Days</span>
                        <strong id="weekendDays">0 days</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Date Calculation:</strong> The difference is calculated by subtracting the start date from the end date. Working days are estimated as 5/7 of total days (Monday-Friday). Leap years are automatically accounted for.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('dateForm');
        const endDateInput = document.getElementById('endDate');
        
        // Set today's date as default end date
        const today = new Date();
        endDateInput.value = today.toISOString().split('T')[0];

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateDateDifference();
        });

        // Calculate on change
        document.getElementById('startDate').addEventListener('change', calculateDateDifference);
        document.getElementById('endDate').addEventListener('change', calculateDateDifference);
        document.getElementById('includeEndDate').addEventListener('change', calculateDateDifference);

        function calculateDateDifference() {
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);
            const includeEnd = document.getElementById('includeEndDate').checked;

            if (startDate > endDate) {
                alert('Start date must be before end date!');
                return;
            }

            // Calculate total days
            let totalDaysValue = Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24));
            if (includeEnd) {
                totalDaysValue += 1;
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

            if (includeEnd) {
                days++;
                if (days >= 30) {
                    months++;
                    days = days % 30;
                }
                if (months >= 12) {
                    years++;
                    months = months % 12;
                }
            }

            // Other calculations
            const totalWeeksValue = Math.floor(totalDaysValue / 7);
            const totalMonthsValue = years * 12 + months;
            const totalHoursValue = totalDaysValue * 24;
            const totalMinutesValue = totalHoursValue * 60;

            // Working days (approximate: 5 out of 7 days)
            const workingDaysValue = Math.floor(totalDaysValue * (5/7));
            const weekendDaysValue = totalDaysValue - workingDaysValue;

            // Update UI
            document.getElementById('totalDays').textContent = totalDaysValue.toLocaleString();
            document.getElementById('years').textContent = years;
            document.getElementById('months').textContent = months;
            document.getElementById('days').textContent = days;

            document.getElementById('fullDuration').textContent = `${years} years, ${months} months, ${days} days`;
            document.getElementById('totalDaysDisplay').textContent = totalDaysValue.toLocaleString() + ' days';
            document.getElementById('totalWeeks').textContent = totalWeeksValue.toLocaleString() + ' weeks';
            document.getElementById('totalMonths').textContent = totalMonthsValue.toLocaleString() + ' months';
            document.getElementById('totalHours').textContent = totalHoursValue.toLocaleString() + ' hours';
            document.getElementById('totalMinutes').textContent = totalMinutesValue.toLocaleString() + ' minutes';

            document.getElementById('startDateDisplay').textContent = formatDate(startDate);
            document.getElementById('endDateDisplay').textContent = formatDate(endDate);
            document.getElementById('includeEndDisplay').textContent = includeEnd ? 'Yes (+1 day)' : 'No';

            document.getElementById('calendarDays').textContent = totalDaysValue.toLocaleString() + ' days';
            document.getElementById('workingDays').textContent = workingDaysValue.toLocaleString() + ' days';
            document.getElementById('weekendDays').textContent = weekendDaysValue.toLocaleString() + ' days';
        }

        function formatDate(date) {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        window.addEventListener('load', function() {
            calculateDateDifference();
        });
    </script>
</body>
</html>