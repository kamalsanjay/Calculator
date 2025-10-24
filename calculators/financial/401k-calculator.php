<?php
/**
 * 401(k) Calculator
 * File: 401k-calculator.php
 * Description: Calculate 401(k) retirement savings growth with USD/INR/EUR/GBP support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401(k) Calculator - Calculate Retirement Savings (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free 401(k) calculator. Calculate retirement savings with employer match, contribution limits, and compound growth. Supports USD, INR, EUR, and GBP currencies.">
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
</head>
<body>
    <header>
        <h1>💰 401(k) Calculator</h1>
        <p>Calculate your retirement savings and employer match</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>401(k) Details</h2>
                <form id="k401Form">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                            <option value="EUR">EUR (€)</option>
                            <option value="GBP">GBP (£)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentAge">Current Age</label>
                        <input type="number" id="currentAge" value="30" min="18" max="80" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="retirementAge">Retirement Age</label>
                        <input type="number" id="retirementAge" value="65" min="55" max="80" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentBalance">Current 401(k) Balance (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="currentBalance" value="25000" min="0" step="1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="annualSalary">Annual Salary (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="annualSalary" value="75000" min="0" step="1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contributionPercent">Your Contribution (%)</label>
                        <input type="number" id="contributionPercent" value="6" min="0" max="100" step="0.5" required>
                        <small>% of salary you contribute</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="employerMatch">Employer Match (%)</label>
                        <input type="number" id="employerMatch" value="3" min="0" max="10" step="0.5">
                        <small>% employer matches (e.g., 50% up to 6%)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="expectedReturn">Expected Annual Return (%)</label>
                        <input type="number" id="expectedReturn" value="8" min="0" max="20" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="salaryIncrease">Annual Salary Increase (%)</label>
                        <input type="number" id="salaryIncrease" value="3" min="0" max="10" step="0.1">
                    </div>
                    
                    <button type="submit" class="btn">Calculate 401(k)</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Retirement Projection</h2>
                
                <div class="result-card">
                    <h3>401(k) Balance at Retirement</h3>
                    <div class="amount" id="finalBalance">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Your Contributions</h4>
                        <div class="value" id="yourContributions">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Employer Match</h4>
                        <div class="value" id="employerContributions">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Investment Gains</h4>
                        <div class="value" id="investmentGains">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Years to Retirement</h4>
                        <div class="value" id="yearsToRetirement">0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Contribution Summary</h3>
                    <div class="breakdown-item">
                        <span>Current Balance</span>
                        <strong id="currentBalanceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Salary</span>
                        <strong id="salaryDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Your Contribution Rate</span>
                        <strong id="yourRate">6%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Contribution (Year 1)</span>
                        <strong id="annualContribution" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Employer Match Rate</span>
                        <strong id="matchRate">3%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Employer Match (Year 1)</span>
                        <strong id="annualMatch" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Growth Analysis</h3>
                    <div class="breakdown-item">
                        <span>Years Until Retirement</span>
                        <strong id="yearsDisplay">35 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Expected Return</span>
                        <strong id="returnDisplay">8%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Salary Growth Rate</span>
                        <strong id="salaryGrowthDisplay">3%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Contributions (You + Employer)</span>
                        <strong id="totalContributions" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Investment Growth</span>
                        <strong id="growthAmount" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Balance Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Starting Balance</span>
                        <strong id="startingBalance">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Your Total Contributions</span>
                        <strong id="yourTotal" style="color: #2196F3;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Employer Match Total</span>
                        <strong id="employerTotal" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Investment Earnings</span>
                        <strong id="earningsTotal" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Final 401(k) Balance</strong></span>
                        <strong id="finalTotal" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Milestone Projections</h3>
                    <div class="breakdown-item">
                        <span>Balance in 5 Years</span>
                        <strong id="balance5">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Balance in 10 Years</span>
                        <strong id="balance10">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Balance in 20 Years</span>
                        <strong id="balance20">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Balance at Retirement</span>
                        <strong id="balanceRetirement" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Monthly Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Monthly Contribution (Year 1)</span>
                        <strong id="monthlyContribution">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Employer Match</span>
                        <strong id="monthlyMatch">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Monthly Savings</span>
                        <strong id="monthlyTotal" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>401(k) Tips:</strong> Max out employer match = free money! 2024 limit: $23,000 ($30,500 if 50+). Traditional = tax-deferred. Roth 401(k) = tax-free withdrawals. Start early for compound growth. Consider catch-up contributions after 50. Diversify investments. Review allocation annually.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('k401Form');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculate401k();
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
            document.getElementById('currencyLabel1').textContent = symbol;
            document.getElementById('currencyLabel2').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculate401k();
        });

        function calculate401k() {
            const currentAge = parseInt(document.getElementById('currentAge').value) || 30;
            const retirementAge = parseInt(document.getElementById('retirementAge').value) || 65;
            const currentBalance = parseFloat(document.getElementById('currentBalance').value) || 0;
            const annualSalary = parseFloat(document.getElementById('annualSalary').value) || 0;
            const contributionPercent = parseFloat(document.getElementById('contributionPercent').value) / 100 || 0;
            const employerMatch = parseFloat(document.getElementById('employerMatch').value) / 100 || 0;
            const expectedReturn = parseFloat(document.getElementById('expectedReturn').value) / 100 || 0;
            const salaryIncrease = parseFloat(document.getElementById('salaryIncrease').value) / 100 || 0;
            const currency = currencySelect.value;

            const years = retirementAge - currentAge;
            let balance = currentBalance;
            let totalYourContributions = 0;
            let totalEmployerContributions = 0;
            let currentSalary = annualSalary;

            // Year-by-year calculation
            for (let year = 1; year <= years; year++) {
                const yearContribution = currentSalary * contributionPercent;
                const yearMatch = currentSalary * employerMatch;
                
                totalYourContributions += yearContribution;
                totalEmployerContributions += yearMatch;
                
                balance = (balance + yearContribution + yearMatch) * (1 + expectedReturn);
                currentSalary = currentSalary * (1 + salaryIncrease);
            }

            const finalBalance = balance;
            const totalContributions = totalYourContributions + totalEmployerContributions;
            const investmentGains = finalBalance - currentBalance - totalContributions;

            // First year contributions
            const annualContribution = annualSalary * contributionPercent;
            const annualMatch = annualSalary * employerMatch;
            const monthlyContribution = annualContribution / 12;
            const monthlyMatch = annualMatch / 12;
            const monthlyTotal = monthlyContribution + monthlyMatch;

            // Milestone projections
            function calculateBalance(targetYears) {
                let bal = currentBalance;
                let sal = annualSalary;
                for (let y = 1; y <= targetYears; y++) {
                    const contrib = sal * contributionPercent;
                    const match = sal * employerMatch;
                    bal = (bal + contrib + match) * (1 + expectedReturn);
                    sal = sal * (1 + salaryIncrease);
                }
                return bal;
            }

            const balance5 = calculateBalance(Math.min(5, years));
            const balance10 = calculateBalance(Math.min(10, years));
            const balance20 = calculateBalance(Math.min(20, years));

            // Update UI
            document.getElementById('finalBalance').textContent = formatCurrency(finalBalance, currency);
            document.getElementById('yourContributions').textContent = formatCurrency(totalYourContributions, currency);
            document.getElementById('employerContributions').textContent = formatCurrency(totalEmployerContributions, currency);
            document.getElementById('investmentGains').textContent = formatCurrency(investmentGains, currency);
            document.getElementById('yearsToRetirement').textContent = years;

            document.getElementById('currentBalanceDisplay').textContent = formatCurrency(currentBalance, currency);
            document.getElementById('salaryDisplay').textContent = formatCurrency(annualSalary, currency);
            document.getElementById('yourRate').textContent = (contributionPercent * 100).toFixed(1) + '%';
            document.getElementById('annualContribution').textContent = formatCurrency(annualContribution, currency);
            document.getElementById('matchRate').textContent = (employerMatch * 100).toFixed(1) + '%';
            document.getElementById('annualMatch').textContent = formatCurrency(annualMatch, currency);

            document.getElementById('yearsDisplay').textContent = years + ' years';
            document.getElementById('returnDisplay').textContent = (expectedReturn * 100).toFixed(1) + '%';
            document.getElementById('salaryGrowthDisplay').textContent = (salaryIncrease * 100).toFixed(1) + '%';
            document.getElementById('totalContributions').textContent = formatCurrency(totalContributions, currency);
            document.getElementById('growthAmount').textContent = formatCurrency(investmentGains, currency);

            document.getElementById('startingBalance').textContent = formatCurrency(currentBalance, currency);
            document.getElementById('yourTotal').textContent = formatCurrency(totalYourContributions, currency);
            document.getElementById('employerTotal').textContent = formatCurrency(totalEmployerContributions, currency);
            document.getElementById('earningsTotal').textContent = formatCurrency(investmentGains, currency);
            document.getElementById('finalTotal').textContent = formatCurrency(finalBalance, currency);

            document.getElementById('balance5').textContent = formatCurrency(balance5, currency);
            document.getElementById('balance10').textContent = formatCurrency(balance10, currency);
            document.getElementById('balance20').textContent = formatCurrency(balance20, currency);
            document.getElementById('balanceRetirement').textContent = formatCurrency(finalBalance, currency);

            document.getElementById('monthlyContribution').textContent = formatCurrency(monthlyContribution, currency);
            document.getElementById('monthlyMatch').textContent = formatCurrency(monthlyMatch, currency);
            document.getElementById('monthlyTotal').textContent = formatCurrency(monthlyTotal, currency);
        }

        function formatCurrency(amount, currency) {
            const locale = currency === 'INR' ? 'en-IN' : currency === 'EUR' ? 'de-DE' : currency === 'GBP' ? 'en-GB' : 'en-US';
            return new Intl.NumberFormat(locale, {
                style: 'currency',
                currency: currency,
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        }

        window.addEventListener('load', function() {
            updateCurrencyLabels();
            calculate401k();
        });
    </script>
</body>
</html>