<?php
/**
 * Savings Calculator
 * File: savings-calculator.php
 * Description: Calculate savings growth with regular deposits and compound interest (USD/INR)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Savings Calculator - Calculate Savings Growth (USD/INR)</title>
    <meta name="description" content="Free savings calculator. Calculate how your savings grow with regular deposits and compound interest. Plan your financial goals with USD and INR support.">
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
        <h1>💵 Savings Calculator</h1>
        <p>Calculate your savings growth with regular deposits</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Savings Plan</h2>
                <form id="savingsForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="initialDeposit">Initial Deposit (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="initialDeposit" value="5000" min="0" step="100" required>
                        <small>One-time initial amount</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="monthlyDeposit">Monthly Deposit (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="monthlyDeposit" value="500" min="0" step="10" required>
                        <small>Amount to save each month</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Annual Interest Rate (%)</label>
                        <input type="number" id="interestRate" value="5" min="0" max="30" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="years">Savings Period (Years)</label>
                        <input type="number" id="years" value="10" min="1" max="50" step="1" required>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Savings</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Savings Results</h2>
                
                <div class="result-card">
                    <h3>Future Value</h3>
                    <div class="amount" id="futureValue">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Deposits</h4>
                        <div class="value" id="totalDeposits">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Interest Earned</h4>
                        <div class="value" id="interestEarned">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Return %</h4>
                        <div class="value" id="returnPercent">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Savings Period</h4>
                        <div class="value" id="periodDisplay">0 years</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Savings Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Initial Deposit</span>
                        <strong id="initialAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Deposit</span>
                        <strong id="monthlyAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Months</span>
                        <strong id="totalMonths">0 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="rateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Deposits Made</span>
                        <strong id="depositsTotal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Accumulated</span>
                        <strong id="interestTotal" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Future Value</strong></span>
                        <strong id="totalValue" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Year-by-Year Growth</h3>
                    <div class="breakdown-item">
                        <span>After 1 Year</span>
                        <strong id="year1">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 3 Years</span>
                        <strong id="year3">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 5 Years</span>
                        <strong id="year5">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 10 Years</span>
                        <strong id="year10">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Savings Formula:</strong> FV = P(1+r)^n + PMT × [((1+r)^n - 1) / r], where P is initial deposit, PMT is monthly deposit, r is monthly rate, n is total months. Regular savings with compound interest creates wealth over time!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('savingsForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateSavings();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
            document.getElementById('currencyLabel2').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateSavings();
        });

        function calculateSavings() {
            const initialDeposit = parseFloat(document.getElementById('initialDeposit').value) || 0;
            const monthlyDeposit = parseFloat(document.getElementById('monthlyDeposit').value) || 0;
            const annualRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0;
            const years = parseInt(document.getElementById('years').value) || 0;
            const currency = currencySelect.value;

            const monthlyRate = annualRate / 12;
            const months = years * 12;

            // Future Value = Initial × (1+r)^n + Monthly × [((1+r)^n - 1) / r]
            const futureValueInitial = initialDeposit * Math.pow(1 + monthlyRate, months);
            const futureValueMonthly = monthlyDeposit * ((Math.pow(1 + monthlyRate, months) - 1) / monthlyRate);
            const futureValue = futureValueInitial + futureValueMonthly;

            const totalDeposits = initialDeposit + (monthlyDeposit * months);
            const interestEarned = futureValue - totalDeposits;
            const returnPercent = totalDeposits > 0 ? (interestEarned / totalDeposits) * 100 : 0;

            // Year-wise calculations
            function calculateYearValue(y) {
                const m = y * 12;
                const fvInit = initialDeposit * Math.pow(1 + monthlyRate, m);
                const fvMonthly = monthlyDeposit * ((Math.pow(1 + monthlyRate, m) - 1) / monthlyRate);
                return fvInit + fvMonthly;
            }

            // Update UI
            document.getElementById('futureValue').textContent = formatCurrency(futureValue, currency);
            document.getElementById('totalDeposits').textContent = formatCurrency(totalDeposits, currency);
            document.getElementById('interestEarned').textContent = formatCurrency(interestEarned, currency);
            document.getElementById('returnPercent').textContent = returnPercent.toFixed(2) + '%';
            document.getElementById('periodDisplay').textContent = years + ' years';

            document.getElementById('initialAmount').textContent = formatCurrency(initialDeposit, currency);
            document.getElementById('monthlyAmount').textContent = formatCurrency(monthlyDeposit, currency);
            document.getElementById('totalMonths').textContent = months + ' months';
            document.getElementById('rateDisplay').textContent = (annualRate * 100).toFixed(2) + '%';
            document.getElementById('depositsTotal').textContent = formatCurrency(totalDeposits, currency);
            document.getElementById('interestTotal').textContent = formatCurrency(interestEarned, currency);
            document.getElementById('totalValue').textContent = formatCurrency(futureValue, currency);

            document.getElementById('year1').textContent = formatCurrency(calculateYearValue(1), currency);
            document.getElementById('year3').textContent = formatCurrency(calculateYearValue(3), currency);
            document.getElementById('year5').textContent = formatCurrency(calculateYearValue(5), currency);
            document.getElementById('year10').textContent = formatCurrency(calculateYearValue(10), currency);
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
            calculateSavings();
        });
    </script>
</body>
</html>