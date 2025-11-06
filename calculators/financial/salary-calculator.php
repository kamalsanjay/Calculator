<?php
/**
 * Salary Calculator
 * File: salary-calculator.php
 * Description: Convert between annual, monthly, hourly salary rates (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Calculator - Convert Annual/Monthly/Hourly (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free salary calculator. Convert between annual, monthly, weekly, and hourly pay rates. Calculate take-home pay. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128176; Salary Calculator</h1>
        <p>Convert between salary rates and time periods</p>
    </header>
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
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
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
            grid-template-columns: repeat(2, 1fr);
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
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Salary Details</h2>
                <form id="salaryForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD (&#36;)</option>
                            <option value="INR">INR (&#8377;)</option>
                            <option value="EUR">EUR (&#8364;)</option>
                            <option value="GBP">GBP (&#163;)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputType">Input Salary As</label>
                        <select id="inputType">
                            <option value="annual">Annual Salary</option>
                            <option value="monthly">Monthly Salary</option>
                            <option value="weekly">Weekly Salary</option>
                            <option value="hourly">Hourly Rate</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="salaryAmount">Salary Amount (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="salaryAmount" value="60000" min="0" step="100" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="hoursPerWeek">Hours Per Week</label>
                        <input type="number" id="hoursPerWeek" value="40" min="1" max="168" step="1">
                        <small>Standard: 40 hours/week</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="weeksPerYear">Weeks Per Year</label>
                        <input type="number" id="weeksPerYear" value="52" min="1" max="52" step="1">
                        <small>52 weeks = full year, 50 = 2 weeks vacation</small>
                    </div>
                    
                    <h3 style="color: #f44336; margin: 25px 0 15px;">Deductions (Optional)</h3>
                    
                    <div class="form-group">
                        <label for="taxRate">Tax Rate (%)</label>
                        <input type="number" id="taxRate" value="0" min="0" max="50" step="0.5">
                        <small>Effective tax rate (leave 0 to skip)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="otherDeductions">Other Monthly Deductions (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="otherDeductions" value="0" min="0" step="50">
                        <small>401k, insurance, etc.</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Salary</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Salary Breakdown</h2>
                
                <div class="result-card info">
                    <h3>Annual Salary</h3>
                    <div class="amount" id="annualSalary">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Monthly Salary</h4>
                        <div class="value" id="monthlySalary">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Weekly Salary</h4>
                        <div class="value" id="weeklySalary">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Daily Rate</h4>
                        <div class="value" id="dailyRate">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Hourly Rate</h4>
                        <div class="value" id="hourlyRate">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Gross Salary Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Annual Gross</span>
                        <strong id="annualGross">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Gross</span>
                        <strong id="monthlyGross">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekly Gross</span>
                        <strong id="weeklyGross">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Daily Gross</span>
                        <strong id="dailyGross">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hourly Rate</span>
                        <strong id="hourlyRateGross" style="color: #667eea;">$0/hr</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Work Schedule</h3>
                    <div class="breakdown-item">
                        <span>Hours Per Week</span>
                        <strong id="hoursDisplay">40 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hours Per Year</span>
                        <strong id="hoursPerYear">2,080 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Working Weeks Per Year</span>
                        <strong id="weeksDisplay">52 weeks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Working Days Per Year</span>
                        <strong id="daysPerYear">260 days</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Deductions</h3>
                    <div class="breakdown-item">
                        <span>Tax Rate</span>
                        <strong id="taxRateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Tax</span>
                        <strong id="annualTax" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Tax</span>
                        <strong id="monthlyTax" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Annual Deductions</span>
                        <strong id="annualOtherDeductions" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #f44336; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Annual Deductions</strong></span>
                        <strong id="totalAnnualDeductions" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Net (Take-Home) Salary</h3>
                    <div class="breakdown-item">
                        <span>Annual Net Salary</span>
                        <strong id="annualNet" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Net Salary</span>
                        <strong id="monthlyNet" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekly Net Pay</span>
                        <strong id="weeklyNet">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Daily Net Pay</span>
                        <strong id="dailyNet">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hourly Net Rate</span>
                        <strong id="hourlyNet">$0/hr</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Gross vs Net Comparison</h3>
                    <div class="breakdown-item">
                        <span>Gross Annual Salary</span>
                        <strong id="grossAnnualComp">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Deductions</span>
                        <strong id="deductionsComp" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Annual Salary</strong></span>
                        <strong id="netAnnualComp" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Take-Home Percentage</span>
                        <strong id="takeHomePercent" style="color: #667eea;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Bi-Weekly Pay</h3>
                    <div class="breakdown-item">
                        <span>Pay Periods Per Year</span>
                        <strong id="biweeklyPeriods">26</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gross Bi-Weekly Pay</span>
                        <strong id="biweeklyGross">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Net Bi-Weekly Pay</span>
                        <strong id="biweeklyNet" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Overtime Rates (1.5x)</h3>
                    <div class="breakdown-item">
                        <span>Regular Hourly Rate</span>
                        <strong id="regularRate">$0/hr</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Overtime Rate (1.5x)</span>
                        <strong id="overtimeRate" style="color: #667eea;">$0/hr</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Double Time Rate (2x)</span>
                        <strong id="doubleTimeRate" style="color: #FF9800;">$0/hr</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Equivalent Rates</h3>
                    <div class="breakdown-item">
                        <span>Per Minute</span>
                        <strong id="perMinute">$0/min</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Per Hour</span>
                        <strong id="perHour">$0/hr</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Per Day (8 hours)</span>
                        <strong id="perDay">$0/day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Per Week (40 hours)</span>
                        <strong id="perWeek">$0/week</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Per Month</span>
                        <strong id="perMonth">$0/month</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Per Year</span>
                        <strong id="perYear" style="color: #667eea;">$0/year</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Salary Tips:</strong> Gross = before taxes. Net = take-home. Hourly = annual ÷ 2080 (40hrs × 52 weeks). Salary negotiation: think annual not hourly. Benefits add 20-30% to compensation. Overtime = 1.5x regular rate. Compare total compensation packages. Bi-weekly = 26 paychecks/year. Semi-monthly = 24 paychecks/year. Budget on net pay, not gross. Track effective tax rate. Consider cost of living. Review salary annually. Know market rates. Document achievements for raises.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('salaryForm');
        const currencySelect = document.getElementById('currency');
        const inputTypeSelect = document.getElementById('inputType');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateSalary();
        });

        inputTypeSelect.addEventListener('change', function() {
            calculateSalary();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbols = {
                'USD': '$',
                'INR': '₹',
                'EUR': '€',
                'GBP': '£'
            };
            const symbol = symbols[currency];
            for (let i = 1; i <= 2; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateSalary();
        });

        function calculateSalary() {
            const salaryAmount = parseFloat(document.getElementById('salaryAmount').value) || 0;
            const inputType = inputTypeSelect.value;
            const hoursPerWeek = parseFloat(document.getElementById('hoursPerWeek').value) || 40;
            const weeksPerYear = parseFloat(document.getElementById('weeksPerYear').value) || 52;
            const taxRate = parseFloat(document.getElementById('taxRate').value) / 100 || 0;
            const otherDeductions = parseFloat(document.getElementById('otherDeductions').value) || 0;
            const currency = currencySelect.value;

            // Calculate annual salary based on input type
            let annualSalary = 0;
            const hoursPerYear = hoursPerWeek * weeksPerYear;

            switch(inputType) {
                case 'annual':
                    annualSalary = salaryAmount;
                    break;
                case 'monthly':
                    annualSalary = salaryAmount * 12;
                    break;
                case 'weekly':
                    annualSalary = salaryAmount * weeksPerYear;
                    break;
                case 'hourly':
                    annualSalary = salaryAmount * hoursPerYear;
                    break;
            }

            // Calculate all salary breakdowns
            const monthlySalary = annualSalary / 12;
            const weeklySalary = annualSalary / weeksPerYear;
            const dailyRate = weeklySalary / 5; // 5 working days
            const hourlyRate = annualSalary / hoursPerYear;

            // Deductions
            const annualTax = annualSalary * taxRate;
            const monthlyTax = annualTax / 12;
            const annualOtherDeductions = otherDeductions * 12;
            const totalAnnualDeductions = annualTax + annualOtherDeductions;

            // Net salary
            const annualNet = annualSalary - totalAnnualDeductions;
            const monthlyNet = annualNet / 12;
            const weeklyNet = annualNet / weeksPerYear;
            const dailyNet = weeklyNet / 5;
            const hourlyNet = annualNet / hoursPerYear;

            // Bi-weekly
            const biweeklyPeriods = 26;
            const biweeklyGross = annualSalary / biweeklyPeriods;
            const biweeklyNet = annualNet / biweeklyPeriods;

            // Overtime rates
            const overtimeRate = hourlyRate * 1.5;
            const doubleTimeRate = hourlyRate * 2;

            // Equivalent rates
            const perMinute = hourlyRate / 60;
            const daysPerYear = weeksPerYear * 5;

            // Take-home percentage
            const takeHomePercent = annualSalary > 0 ? (annualNet / annualSalary) * 100 : 0;

            // Analysis
            let analysis = `Your annual salary of ${formatCurrency(annualSalary, currency)} breaks down to ${formatCurrency(monthlySalary, currency)} per month, ${formatCurrency(weeklySalary, currency)} per week, and ${formatCurrency(hourlyRate, currency)} per hour (based on ${hoursPerWeek} hours/week). `;
            
            if (totalAnnualDeductions > 0) {
                analysis += `After ${formatCurrency(totalAnnualDeductions, currency)} in annual deductions (${(taxRate * 100).toFixed(1)}% tax), your take-home pay is ${formatCurrency(annualNet, currency)} annually or ${formatCurrency(monthlyNet, currency)} monthly. `;
                analysis += `You keep ${takeHomePercent.toFixed(1)}% of your gross salary.`;
            } else {
                analysis += `Working ${hoursPerYear.toFixed(0)} hours per year at ${formatCurrency(hourlyRate, currency)}/hour.`;
            }

            // Update UI
            document.getElementById('annualSalary').textContent = formatCurrency(annualSalary, currency);
            document.getElementById('monthlySalary').textContent = formatCurrency(monthlySalary, currency);
            document.getElementById('weeklySalary').textContent = formatCurrency(weeklySalary, currency);
            document.getElementById('dailyRate').textContent = formatCurrency(dailyRate, currency);
            document.getElementById('hourlyRate').textContent = formatCurrency(hourlyRate, currency) + '/hr';

            document.getElementById('annualGross').textContent = formatCurrency(annualSalary, currency);
            document.getElementById('monthlyGross').textContent = formatCurrency(monthlySalary, currency);
            document.getElementById('weeklyGross').textContent = formatCurrency(weeklySalary, currency);
            document.getElementById('dailyGross').textContent = formatCurrency(dailyRate, currency);
            document.getElementById('hourlyRateGross').textContent = formatCurrency(hourlyRate, currency) + '/hr';

            document.getElementById('hoursDisplay').textContent = hoursPerWeek + ' hours/week';
            document.getElementById('hoursPerYear').textContent = hoursPerYear.toLocaleString() + ' hours';
            document.getElementById('weeksDisplay').textContent = weeksPerYear + ' weeks';
            document.getElementById('daysPerYear').textContent = daysPerYear + ' days';

            document.getElementById('taxRateDisplay').textContent = (taxRate * 100).toFixed(1) + '%';
            document.getElementById('annualTax').textContent = formatCurrency(annualTax, currency);
            document.getElementById('monthlyTax').textContent = formatCurrency(monthlyTax, currency);
            document.getElementById('annualOtherDeductions').textContent = formatCurrency(annualOtherDeductions, currency);
            document.getElementById('totalAnnualDeductions').textContent = formatCurrency(totalAnnualDeductions, currency);

            document.getElementById('annualNet').textContent = formatCurrency(annualNet, currency);
            document.getElementById('monthlyNet').textContent = formatCurrency(monthlyNet, currency);
            document.getElementById('weeklyNet').textContent = formatCurrency(weeklyNet, currency);
            document.getElementById('dailyNet').textContent = formatCurrency(dailyNet, currency);
            document.getElementById('hourlyNet').textContent = formatCurrency(hourlyNet, currency) + '/hr';

            document.getElementById('grossAnnualComp').textContent = formatCurrency(annualSalary, currency);
            document.getElementById('deductionsComp').textContent = formatCurrency(totalAnnualDeductions, currency);
            document.getElementById('netAnnualComp').textContent = formatCurrency(annualNet, currency);
            document.getElementById('takeHomePercent').textContent = takeHomePercent.toFixed(1) + '%';

            document.getElementById('biweeklyPeriods').textContent = biweeklyPeriods + ' periods';
            document.getElementById('biweeklyGross').textContent = formatCurrency(biweeklyGross, currency);
            document.getElementById('biweeklyNet').textContent = formatCurrency(biweeklyNet, currency);

            document.getElementById('regularRate').textContent = formatCurrency(hourlyRate, currency) + '/hr';
            document.getElementById('overtimeRate').textContent = formatCurrency(overtimeRate, currency) + '/hr';
            document.getElementById('doubleTimeRate').textContent = formatCurrency(doubleTimeRate, currency) + '/hr';

            document.getElementById('perMinute').textContent = formatCurrency(perMinute, currency) + '/min';
            document.getElementById('perHour').textContent = formatCurrency(hourlyRate, currency) + '/hr';
            document.getElementById('perDay').textContent = formatCurrency(dailyRate, currency) + '/day';
            document.getElementById('perWeek').textContent = formatCurrency(weeklySalary, currency) + '/week';
            document.getElementById('perMonth').textContent = formatCurrency(monthlySalary, currency) + '/month';
            document.getElementById('perYear').textContent = formatCurrency(annualSalary, currency) + '/year';

            document.getElementById('analysisText').textContent = analysis;
        }

        function formatCurrency(amount, currency) {
            const locale = currency === 'INR' ? 'en-IN' : currency === 'EUR' ? 'de-DE' : currency === 'GBP' ? 'en-GB' : 'en-US';
            return new Intl.NumberFormat(locale, {
                style: 'currency',
                currency: currency,
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            }).format(amount);
        }

        window.addEventListener('load', function() {
            updateCurrencyLabels();
            calculateSalary();
        });
    </script>
</body>
</html>