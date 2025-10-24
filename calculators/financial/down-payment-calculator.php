<?php
/**
 * Down Payment Calculator
 * File: down-payment-calculator.php
 * Description: Calculate home down payment requirements and savings plan (USD/INR)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Down Payment Calculator - Calculate Home Down Payment (USD/INR)</title>
    <meta name="description" content="Free down payment calculator. Calculate required down payment for home purchase and monthly savings needed. Plan your home buying with USD and INR support.">
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
        <h1>🏠 Down Payment Calculator</h1>
        <p>Calculate your home down payment and savings plan</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Home Purchase Details</h2>
                <form id="downPaymentForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="homePrice">Home Price (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="homePrice" value="300000" min="10000" step="5000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="downPaymentPercent">Down Payment (%)</label>
                        <input type="number" id="downPaymentPercent" value="20" min="5" max="50" step="1" required>
                        <small>Standard is 20% to avoid PMI</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentSavings">Current Savings (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="currentSavings" value="10000" min="0" step="1000">
                    </div>
                    
                    <div class="form-group">
                        <label for="monthlySavings">Monthly Savings (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="monthlySavings" value="2000" min="0" step="100">
                        <small>Amount you can save per month</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Down Payment</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Down Payment Plan</h2>
                
                <div class="result-card">
                    <h3>Required Down Payment</h3>
                    <div class="amount" id="downPaymentAmount">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Home Price</h4>
                        <div class="value" id="homePriceDisplay">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Loan Amount</h4>
                        <div class="value" id="loanAmount">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Still Need to Save</h4>
                        <div class="value" id="needToSave">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Time to Save</h4>
                        <div class="value" id="timeToSave">0 mos</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Purchase Details</h3>
                    <div class="breakdown-item">
                        <span>Home Price</span>
                        <strong id="priceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment %</span>
                        <strong id="percentDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment Amount</span>
                        <strong id="dpAmount" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="loanAmountDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan-to-Value (LTV)</span>
                        <strong id="ltvRatio">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Savings Plan</h3>
                    <div class="breakdown-item">
                        <span>Current Savings</span>
                        <strong id="currentSavingsDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment Needed</span>
                        <strong id="dpNeeded">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Still Need to Save</span>
                        <strong id="remainingSavings" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Savings</span>
                        <strong id="monthlySavingsDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Time Required</span>
                        <strong id="timeRequired">0 months</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Closing Costs Estimate</h3>
                    <div class="breakdown-item">
                        <span>Closing Costs (2-5%)</span>
                        <strong id="closingCosts">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Cash Needed</span>
                        <strong id="totalCashNeeded" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Different Down Payment Options</h3>
                    <div class="breakdown-item">
                        <span>10% Down Payment</span>
                        <strong id="dp10">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>15% Down Payment</span>
                        <strong id="dp15">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>20% Down Payment</span>
                        <strong id="dp20">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>25% Down Payment</span>
                        <strong id="dp25">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Down Payment Tips:</strong> 20% down avoids PMI insurance. Larger down payment = smaller loan & less interest. Budget for closing costs (2-5% of price). First-time buyers may get programs with lower down payments. Save 3-6 months expenses as emergency fund too.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('downPaymentForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateDownPayment();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
            document.getElementById('currencyLabel2').textContent = symbol;
            document.getElementById('currencyLabel3').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateDownPayment();
        });

        function calculateDownPayment() {
            const homePrice = parseFloat(document.getElementById('homePrice').value) || 0;
            const dpPercent = parseFloat(document.getElementById('downPaymentPercent').value) || 20;
            const currentSavings = parseFloat(document.getElementById('currentSavings').value) || 0;
            const monthlySavings = parseFloat(document.getElementById('monthlySavings').value) || 0;
            const currency = currencySelect.value;

            const downPayment = (homePrice * dpPercent) / 100;
            const loanAmount = homePrice - downPayment;
            const ltvRatio = homePrice > 0 ? (loanAmount / homePrice) * 100 : 0;

            const needToSave = Math.max(0, downPayment - currentSavings);
            const monthsToSave = monthlySavings > 0 ? Math.ceil(needToSave / monthlySavings) : 0;

            const closingCosts = homePrice * 0.03; // 3% average
            const totalCashNeeded = downPayment + closingCosts;

            // Different down payment options
            const dp10 = (homePrice * 10) / 100;
            const dp15 = (homePrice * 15) / 100;
            const dp20 = (homePrice * 20) / 100;
            const dp25 = (homePrice * 25) / 100;

            // Update UI
            document.getElementById('downPaymentAmount').textContent = formatCurrency(downPayment, currency);
            document.getElementById('homePriceDisplay').textContent = formatCurrency(homePrice, currency);
            document.getElementById('loanAmount').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('needToSave').textContent = formatCurrency(needToSave, currency);
            document.getElementById('timeToSave').textContent = monthsToSave + ' mos';

            document.getElementById('priceDisplay').textContent = formatCurrency(homePrice, currency);
            document.getElementById('percentDisplay').textContent = dpPercent + '%';
            document.getElementById('dpAmount').textContent = formatCurrency(downPayment, currency);
            document.getElementById('loanAmountDisplay').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('ltvRatio').textContent = ltvRatio.toFixed(1) + '%';

            document.getElementById('currentSavingsDisplay').textContent = formatCurrency(currentSavings, currency);
            document.getElementById('dpNeeded').textContent = formatCurrency(downPayment, currency);
            document.getElementById('remainingSavings').textContent = formatCurrency(needToSave, currency);
            document.getElementById('monthlySavingsDisplay').textContent = formatCurrency(monthlySavings, currency);
            document.getElementById('timeRequired').textContent = monthsToSave + ' months (' + (monthsToSave / 12).toFixed(1) + ' years)';

            document.getElementById('closingCosts').textContent = formatCurrency(closingCosts, currency);
            document.getElementById('totalCashNeeded').textContent = formatCurrency(totalCashNeeded, currency);

            document.getElementById('dp10').textContent = formatCurrency(dp10, currency);
            document.getElementById('dp15').textContent = formatCurrency(dp15, currency);
            document.getElementById('dp20').textContent = formatCurrency(dp20, currency);
            document.getElementById('dp25').textContent = formatCurrency(dp25, currency);
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
            calculateDownPayment();
        });
    </script>
</body>
</html>