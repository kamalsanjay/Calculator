<?php
/**
 * Refinance Calculator
 * File: refinance-calculator.php
 * Description: Calculate savings from refinancing your mortgage/loan (USD/INR)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refinance Calculator - Should I Refinance My Mortgage? (USD/INR)</title>
    <meta name="description" content="Free mortgage refinance calculator. Calculate savings from refinancing, break-even point, and new monthly payment. Compare old vs new loan terms with USD and INR.">
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
        <h1>🔄 Refinance Calculator</h1>
        <p>Calculate savings from refinancing your mortgage</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Current & New Loan Details</h2>
                <form id="refinanceForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Current Loan</h3>
                    
                    <div class="form-group">
                        <label for="currentBalance">Current Loan Balance (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="currentBalance" value="250000" min="10000" step="1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentRate">Current Interest Rate (%)</label>
                        <input type="number" id="currentRate" value="8" min="1" max="20" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="remainingYears">Remaining Years on Current Loan</label>
                        <input type="number" id="remainingYears" value="25" min="1" max="30" step="1" required>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">New Loan</h3>
                    
                    <div class="form-group">
                        <label for="newRate">New Interest Rate (%)</label>
                        <input type="number" id="newRate" value="6.5" min="1" max="20" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="newTerm">New Loan Term (Years)</label>
                        <input type="number" id="newTerm" value="30" min="10" max="30" step="5" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="closingCosts">Refinance Closing Costs (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="closingCosts" value="5000" min="0" step="500">
                        <small>Typically 2-5% of loan amount</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Savings</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Refinance Analysis</h2>
                
                <div class="result-card">
                    <h3>Monthly Savings</h3>
                    <div class="amount" id="monthlySavings">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Old Payment</h4>
                        <div class="value" id="oldPayment">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>New Payment</h4>
                        <div class="value" id="newPayment">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Break-Even Point</h4>
                        <div class="value" id="breakEven">0 mos</div>
                    </div>
                    <div class="metric-card">
                        <h4>Lifetime Savings</h4>
                        <div class="value" id="lifetimeSavings">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Current Loan</h3>
                    <div class="breakdown-item">
                        <span>Loan Balance</span>
                        <strong id="currentBalanceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="currentRateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Remaining Term</span>
                        <strong id="remainingTermDisplay">0 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="currentPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Remaining Interest</span>
                        <strong id="remainingInterest">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>New Loan (After Refinance)</h3>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="newLoanAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="newRateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>New Term</span>
                        <strong id="newTermDisplay">0 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="newMonthlyPayment" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest (New Loan)</span>
                        <strong id="newTotalInterest">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Savings Analysis</h3>
                    <div class="breakdown-item">
                        <span>Monthly Payment Savings</span>
                        <strong id="paymentSavings" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Closing Costs</span>
                        <strong id="closingCostsDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Break-Even Period</span>
                        <strong id="breakEvenMonths">0 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Savings</span>
                        <strong id="interestSavings" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Lifetime Savings</strong></span>
                        <strong id="netSavings" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Recommendation</h3>
                    <div id="recommendation" style="padding: 15px; background: #fff3cd; border-radius: 5px; color: #856404;">
                        Calculate to see recommendation
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Refinance Tips:</strong> Refinance when rates drop 0.75-1% or more. Break-even typically 2-3 years. Consider if staying in home long enough. Closing costs usually 2-5% of loan. Can refinance for better rate or shorter term to save interest.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('refinanceForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateRefinance();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
            document.getElementById('currencyLabel2').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateRefinance();
        });

        function calculateRefinance() {
            const currentBalance = parseFloat(document.getElementById('currentBalance').value) || 0;
            const currentRate = parseFloat(document.getElementById('currentRate').value) / 100 || 0;
            const remainingYears = parseInt(document.getElementById('remainingYears').value) || 25;
            const newRate = parseFloat(document.getElementById('newRate').value) / 100 || 0;
            const newTerm = parseInt(document.getElementById('newTerm').value) || 30;
            const closingCosts = parseFloat(document.getElementById('closingCosts').value) || 0;
            const currency = currencySelect.value;

            // Current loan calculations
            const currentMonthlyRate = currentRate / 12;
            const remainingMonths = remainingYears * 12;
            
            let currentPayment = 0;
            if (currentMonthlyRate > 0) {
                currentPayment = (currentBalance * currentMonthlyRate * Math.pow(1 + currentMonthlyRate, remainingMonths)) /
                                (Math.pow(1 + currentMonthlyRate, remainingMonths) - 1);
            } else {
                currentPayment = currentBalance / remainingMonths;
            }
            
            const totalCurrentPayments = currentPayment * remainingMonths;
            const remainingInterestOld = totalCurrentPayments - currentBalance;

            // New loan calculations
            const newMonthlyRate = newRate / 12;
            const newMonths = newTerm * 12;
            
            let newPayment = 0;
            if (newMonthlyRate > 0) {
                newPayment = (currentBalance * newMonthlyRate * Math.pow(1 + newMonthlyRate, newMonths)) /
                            (Math.pow(1 + newMonthlyRate, newMonths) - 1);
            } else {
                newPayment = currentBalance / newMonths;
            }
            
            const totalNewPayments = newPayment * newMonths;
            const newTotalInterest = totalNewPayments - currentBalance;

            // Savings calculations
            const monthlySavings = currentPayment - newPayment;
            const breakEvenMonths = monthlySavings > 0 ? Math.ceil(closingCosts / monthlySavings) : 0;
            const interestSavings = remainingInterestOld - newTotalInterest;
            const netSavings = interestSavings - closingCosts;

            // Recommendation
            let recommendation = '';
            if (monthlySavings > 0 && breakEvenMonths <= 36) {
                recommendation = `✅ <strong>Good to Refinance!</strong> You'll save ${formatCurrency(monthlySavings, currency)}/month and break even in ${breakEvenMonths} months.`;
            } else if (monthlySavings > 0 && breakEvenMonths > 36) {
                recommendation = `⚠️ <strong>Consider Carefully.</strong> Break-even is ${breakEvenMonths} months. Refinance if staying in home that long.`;
            } else {
                recommendation = `❌ <strong>Not Recommended.</strong> New payment is higher. Refinancing doesn't save money with these terms.`;
            }

            // Update UI
            document.getElementById('monthlySavings').textContent = formatCurrency(monthlySavings, currency);
            document.getElementById('oldPayment').textContent = formatCurrency(currentPayment, currency);
            document.getElementById('newPayment').textContent = formatCurrency(newPayment, currency);
            document.getElementById('breakEven').textContent = breakEvenMonths + ' mos';
            document.getElementById('lifetimeSavings').textContent = formatCurrency(netSavings, currency);

            document.getElementById('currentBalanceDisplay').textContent = formatCurrency(currentBalance, currency);
            document.getElementById('currentRateDisplay').textContent = (currentRate * 100).toFixed(2) + '%';
            document.getElementById('remainingTermDisplay').textContent = remainingYears + ' years';
            document.getElementById('currentPayment').textContent = formatCurrency(currentPayment, currency);
            document.getElementById('remainingInterest').textContent = formatCurrency(remainingInterestOld, currency);

            document.getElementById('newLoanAmount').textContent = formatCurrency(currentBalance, currency);
            document.getElementById('newRateDisplay').textContent = (newRate * 100).toFixed(2) + '%';
            document.getElementById('newTermDisplay').textContent = newTerm + ' years';
            document.getElementById('newMonthlyPayment').textContent = formatCurrency(newPayment, currency);
            document.getElementById('newTotalInterest').textContent = formatCurrency(newTotalInterest, currency);

            document.getElementById('paymentSavings').textContent = formatCurrency(monthlySavings, currency);
            document.getElementById('closingCostsDisplay').textContent = formatCurrency(closingCosts, currency);
            document.getElementById('breakEvenMonths').textContent = breakEvenMonths + ' months (' + (breakEvenMonths / 12).toFixed(1) + ' years)';
            document.getElementById('interestSavings').textContent = formatCurrency(interestSavings, currency);
            document.getElementById('netSavings').textContent = formatCurrency(netSavings, currency);

            document.getElementById('recommendation').innerHTML = recommendation;
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
            calculateRefinance();
        });
    </script>
</body>
</html>