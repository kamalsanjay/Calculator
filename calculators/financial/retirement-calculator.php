<?php
/**
 * Retirement Calculator
 * File: retirement-calculator.php
 * Description: Calculate retirement savings and monthly contributions needed (USD/INR)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retirement Calculator - Plan Your Retirement Savings (USD/INR)</title>
    <meta name="description" content="Free retirement calculator. Calculate how much you need to save for retirement. Plan monthly contributions and retirement corpus. Supports USD and INR.">
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
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
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
        <h1>🏖️ Retirement Calculator</h1>
        <p>Plan your retirement savings and secure your future</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Retirement Planning</h2>
                <form id="retirementForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentAge">Current Age</label>
                        <input type="number" id="currentAge" value="30" min="18" max="80" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="retirementAge">Retirement Age</label>
                        <input type="number" id="retirementAge" value="60" min="40" max="80" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentSavings">Current Retirement Savings (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="currentSavings" value="50000" min="0" step="1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="monthlyContribution">Monthly Contribution (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="monthlyContribution" value="1000" min="0" step="50" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="returnRate">Expected Annual Return (%)</label>
                        <input type="number" id="returnRate" value="8" min="0" max="30" step="0.1" required>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Retirement</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Retirement Projections</h2>
                
                <div class="result-card">
                    <h3>Retirement Corpus</h3>
                    <div class="amount" id="retirementCorpus">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Years to Retirement</h4>
                        <div class="value" id="yearsToRetirement">0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Contributions</h4>
                        <div class="value" id="totalContributions">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Investment Growth</h4>
                        <div class="value" id="investmentGrowth">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Monthly at Retirement</h4>
                        <div class="value" id="monthlyIncome">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Retirement Summary</h3>
                    <div class="breakdown-item">
                        <span>Current Age</span>
                        <strong id="currentAgeDisplay">30 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Retirement Age</span>
                        <strong id="retirementAgeDisplay">60 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Years Until Retirement</span>
                        <strong id="yearsDisplay">30 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Savings</span>
                        <strong id="currentSavingsDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Contribution</span>
                        <strong id="monthlyDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Expected Return</span>
                        <strong id="returnDisplay">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Savings Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Current Savings</span>
                        <strong id="savingsAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Monthly Contributions</span>
                        <strong id="contributionsTotal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Investment Returns</span>
                        <strong id="returnsAmount" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Retirement Corpus</strong></span>
                        <strong id="corpusTotal" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Retirement Income (4% Rule)</h3>
                    <div class="breakdown-item">
                        <span>Monthly Income</span>
                        <strong id="monthlyIncomeAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Income</span>
                        <strong id="annualIncome">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Retirement Planning:</strong> Uses compound interest to project retirement savings. Monthly income based on 4% safe withdrawal rate. Start early and contribute regularly for a comfortable retirement!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('retirementForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateRetirement();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
            document.getElementById('currencyLabel2').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateRetirement();
        });

        function calculateRetirement() {
            const currentAge = parseInt(document.getElementById('currentAge').value) || 30;
            const retirementAge = parseInt(document.getElementById('retirementAge').value) || 60;
            const currentSavings = parseFloat(document.getElementById('currentSavings').value) || 0;
            const monthlyContribution = parseFloat(document.getElementById('monthlyContribution').value) || 0;
            const annualReturn = parseFloat(document.getElementById('returnRate').value) / 100 || 0;
            const currency = currencySelect.value;

            const yearsToRetirement = retirementAge - currentAge;
            const monthlyRate = annualReturn / 12;
            const totalMonths = yearsToRetirement * 12;

            // Future value of current savings
            const fvSavings = currentSavings * Math.pow(1 + monthlyRate, totalMonths);

            // Future value of monthly contributions
            const fvContributions = monthlyContribution * ((Math.pow(1 + monthlyRate, totalMonths) - 1) / monthlyRate);

            const retirementCorpus = fvSavings + fvContributions;
            const totalContributions = currentSavings + (monthlyContribution * totalMonths);
            const investmentGrowth = retirementCorpus - totalContributions;

            // 4% rule for retirement income
            const annualIncome = retirementCorpus * 0.04;
            const monthlyIncome = annualIncome / 12;

            // Update UI
            document.getElementById('retirementCorpus').textContent = formatCurrency(retirementCorpus, currency);
            document.getElementById('yearsToRetirement').textContent = yearsToRetirement + ' years';
            document.getElementById('totalContributions').textContent = formatCurrency(totalContributions, currency);
            document.getElementById('investmentGrowth').textContent = formatCurrency(investmentGrowth, currency);
            document.getElementById('monthlyIncome').textContent = formatCurrency(monthlyIncome, currency);

            document.getElementById('currentAgeDisplay').textContent = currentAge + ' years';
            document.getElementById('retirementAgeDisplay').textContent = retirementAge + ' years';
            document.getElementById('yearsDisplay').textContent = yearsToRetirement + ' years';
            document.getElementById('currentSavingsDisplay').textContent = formatCurrency(currentSavings, currency);
            document.getElementById('monthlyDisplay').textContent = formatCurrency(monthlyContribution, currency);
            document.getElementById('returnDisplay').textContent = (annualReturn * 100).toFixed(2) + '%';

            document.getElementById('savingsAmount').textContent = formatCurrency(currentSavings, currency);
            document.getElementById('contributionsTotal').textContent = formatCurrency(monthlyContribution * totalMonths, currency);
            document.getElementById('returnsAmount').textContent = formatCurrency(investmentGrowth, currency);
            document.getElementById('corpusTotal').textContent = formatCurrency(retirementCorpus, currency);

            document.getElementById('monthlyIncomeAmount').textContent = formatCurrency(monthlyIncome, currency);
            document.getElementById('annualIncome').textContent = formatCurrency(annualIncome, currency);
        }

        function formatCurrency(amount, currency) {
            if (currency === 'INR') {
                return new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(amount);
            } else {
                return new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(amount);
            }
        }

        window.addEventListener('load', function() {
            updateCurrencyLabels();
            calculateRetirement();
        });
    </script>
</body>
</html>