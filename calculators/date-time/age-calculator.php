<?php
/**
 * Age Calculator
 * File: age-calculator.php
 * Description: Calculate exact age in years, months, and days from date of birth
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Age Calculator - Calculate Exact Age from Date of Birth</title>
    <meta name="description" content="Free age calculator. Calculate your exact age in years, months, weeks, and days from date of birth. Find age difference between two dates.">
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
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
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
        <h1>🎂 Age Calculator</h1>
        <p>Calculate your exact age in years, months, and days</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Date of Birth</h2>
                <form id="ageForm">
                    <div class="form-group">
                        <label for="birthDate">Birth Date</label>
                        <input type="date" id="birthDate" value="1990-01-01" required>
                        <small>Enter your date of birth</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="calculateDate">Calculate Age On</label>
                        <input type="date" id="calculateDate" required>
                        <small>Usually today's date (default)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Age</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Age Results</h2>
                
                <div class="result-card">
                    <h3>Your Age</h3>
                    <div class="amount" id="ageYears">0 Years</div>
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
                    <h3>Detailed Age</h3>
                    <div class="breakdown-item">
                        <span>Full Age</span>
                        <strong id="fullAge">0 years, 0 months, 0 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Months</span>
                        <strong id="totalMonths">0 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Weeks</span>
                        <strong id="totalWeeks">0 weeks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Days</span>
                        <strong id="totalDays">0 days</strong>
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
                    <h3>Birthday Information</h3>
                    <div class="breakdown-item">
                        <span>Birth Date</span>
                        <strong id="birthDateDisplay">-</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Day of Week Born</span>
                        <strong id="dayOfWeek">-</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Next Birthday</span>
                        <strong id="nextBirthday">-</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Days Until Birthday</span>
                        <strong id="daysUntilBirthday">0 days</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Life Milestones</h3>
                    <div class="breakdown-item">
                        <span>18th Birthday</span>
                        <strong id="milestone18">-</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>21st Birthday</span>
                        <strong id="milestone21">-</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>30th Birthday</span>
                        <strong id="milestone30">-</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>50th Birthday</span>
                        <strong id="milestone50">-</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>100th Birthday</span>
                        <strong id="milestone100">-</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Age Calculation:</strong> Age is calculated by finding the difference between birth date and current date. The result shows completed years, months, and days. Leap years are accounted for automatically.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('ageForm');
        const calculateDateInput = document.getElementById('calculateDate');

        // Set today's date as default
        const today = new Date();
        calculateDateInput.value = today.toISOString().split('T')[0];

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateAge();
        });

        function calculateAge() {
            const birthDate = new Date(document.getElementById('birthDate').value);
            const calculateDate = new Date(document.getElementById('calculateDate').value);

            if (birthDate > calculateDate) {
                alert('Birth date cannot be in the future!');
                return;
            }

            // Calculate age
            let years = calculateDate.getFullYear() - birthDate.getFullYear();
            let months = calculateDate.getMonth() - birthDate.getMonth();
            let days = calculateDate.getDate() - birthDate.getDate();

            // Adjust for negative days
            if (days < 0) {
                months--;
                const prevMonth = new Date(calculateDate.getFullYear(), calculateDate.getMonth(), 0);
                days += prevMonth.getDate();
            }

            // Adjust for negative months
            if (months < 0) {
                years--;
                months += 12;
            }

            // Total calculations
            const totalDaysValue = Math.floor((calculateDate - birthDate) / (1000 * 60 * 60 * 24));
            const totalWeeksValue = Math.floor(totalDaysValue / 7);
            const totalMonthsValue = years * 12 + months;
            const totalHoursValue = totalDaysValue * 24;
            const totalMinutesValue = totalHoursValue * 60;

            // Day of week born
            const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const dayBorn = daysOfWeek[birthDate.getDay()];

            // Next birthday
            let nextBirthday = new Date(calculateDate.getFullYear(), birthDate.getMonth(), birthDate.getDate());
            if (nextBirthday < calculateDate) {
                nextBirthday.setFullYear(calculateDate.getFullYear() + 1);
            }
            const daysUntilBirthdayValue = Math.floor((nextBirthday - calculateDate) / (1000 * 60 * 60 * 24));

            // Milestones
            const milestone18Date = new Date(birthDate);
            milestone18Date.setFullYear(birthDate.getFullYear() + 18);
            
            const milestone21Date = new Date(birthDate);
            milestone21Date.setFullYear(birthDate.getFullYear() + 21);
            
            const milestone30Date = new Date(birthDate);
            milestone30Date.setFullYear(birthDate.getFullYear() + 30);
            
            const milestone50Date = new Date(birthDate);
            milestone50Date.setFullYear(birthDate.getFullYear() + 50);
            
            const milestone100Date = new Date(birthDate);
            milestone100Date.setFullYear(birthDate.getFullYear() + 100);

            // Update UI
            document.getElementById('ageYears').textContent = years + ' Year' + (years !== 1 ? 's' : '');
            document.getElementById('years').textContent = years;
            document.getElementById('months').textContent = months;
            document.getElementById('days').textContent = days;

            document.getElementById('fullAge').textContent = `${years} years, ${months} months, ${days} days`;
            document.getElementById('totalMonths').textContent = totalMonthsValue.toLocaleString() + ' months';
            document.getElementById('totalWeeks').textContent = totalWeeksValue.toLocaleString() + ' weeks';
            document.getElementById('totalDays').textContent = totalDaysValue.toLocaleString() + ' days';
            document.getElementById('totalHours').textContent = totalHoursValue.toLocaleString() + ' hours';
            document.getElementById('totalMinutes').textContent = totalMinutesValue.toLocaleString() + ' minutes';

            document.getElementById('birthDateDisplay').textContent = formatDate(birthDate);
            document.getElementById('dayOfWeek').textContent = dayBorn;
            document.getElementById('nextBirthday').textContent = formatDate(nextBirthday);
            document.getElementById('daysUntilBirthday').textContent = daysUntilBirthdayValue + ' days';

            document.getElementById('milestone18').textContent = formatDate(milestone18Date) + (calculateDate >= milestone18Date ? ' (Passed)' : '');
            document.getElementById('milestone21').textContent = formatDate(milestone21Date) + (calculateDate >= milestone21Date ? ' (Passed)' : '');
            document.getElementById('milestone30').textContent = formatDate(milestone30Date) + (calculateDate >= milestone30Date ? ' (Passed)' : '');
            document.getElementById('milestone50').textContent = formatDate(milestone50Date) + (calculateDate >= milestone50Date ? ' (Passed)' : '');
            document.getElementById('milestone100').textContent = formatDate(milestone100Date);
        }

        function formatDate(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        window.addEventListener('load', function() {
            calculateAge();
        });
    </script>
</body>
</html>