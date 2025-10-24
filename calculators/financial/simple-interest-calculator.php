<?php
/**
 * Simple Interest Calculator
 * File: simple-interest-calculator.php
 * Description: Calculate simple interest using P×R×T/100 formula with USD/INR support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Interest Calculator - Calculate SI with Formula (USD/INR)</title>
    <meta name="description" content="Free simple interest calculator. Calculate simple interest using SI = (P×R×T)/100 formula. Find interest amount and total amount with principal, rate, and time.">
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
        <h1>📊 Simple Interest Calculator</h1>
        <p>Calculate simple interest using SI = (P×R×T)/100</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Loan/Investment Details</h2>
                <form id="siForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="principal">Principal Amount (P) (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="principal" value="10000" min="0" step="100" required>
                        <small>Initial amount invested or borrowed</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="rate">Rate of Interest (R) (%)</label>
                        <input type="number" id="rate" value="10" min="0" max="100" step="0.1" required>
                        <small>Annual interest rate percentage</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="time">Time Period (T) (Years)</label>
                        <input type="number" id="time" value="3" min="0" step="0.1" required>
                        <small>Duration in years</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Simple Interest</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Interest Calculation</h2>
                
                <div class="result-card">
                    <h3>Simple Interest</h3>
                    <div class="amount" id="simpleInterest">$3,000</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Principal</h4>
                        <div class="value" id="principalDisplay">$10,000</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Amount</h4>
                        <div class="value" id="totalAmount">$13,000</div>
                    </div>
                    <div class="metric-card">
                        <h4>Interest Rate</h4>
                        <div class="value" id="rateDisplay">10%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Time Period</h4>
                        <div class="value" id="timeDisplay">3 years</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Calculation Formula</h3>
                    <div class="breakdown-item">
                        <span>Formula</span>
                        <strong>SI = (P × R × T) / 100</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Calculation</span>
                        <strong id="calculation">(10000 × 10 × 3) / 100</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Simple Interest (SI)</span>
                        <strong id="siAmount">$3,000</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Amount Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Principal Amount (P)</span>
                        <strong id="principalAmount">$10,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Simple Interest (SI)</span>
                        <strong id="interestAmount" style="color: #4CAF50;">$3,000</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Amount (A = P + SI)</strong></span>
                        <strong id="totalAmountDisplay" style="color: #667eea; font-size: 1.2em;">$13,000</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Year-by-Year Interest</h3>
                    <div class="breakdown-item">
                        <span>After 1 Year</span>
                        <strong id="year1">SI: $1,000 | Total: $11,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 2 Years</span>
                        <strong id="year2">SI: $2,000 | Total: $12,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 3 Years</span>
                        <strong id="year3">SI: $3,000 | Total: $13,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 5 Years</span>
                        <strong id="year5">SI: $5,000 | Total: $15,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 10 Years</span>
                        <strong id="year10">SI: $10,000 | Total: $20,000</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Monthly Interest</h3>
                    <div class="breakdown-item">
                        <span>Interest Per Month</span>
                        <strong id="monthlyInterest">$83.33</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Per Year</span>
                        <strong id="yearlyInterest">$1,000</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Simple Interest Formula:</strong> SI = (P × R × T) / 100, where P = Principal, R = Rate per annum, T = Time in years. Total Amount = Principal + Simple Interest. Simple interest is calculated only on the principal amount.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('siForm');
        const currencySelect = document.getElementById('currency');

        // Currency change
        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateSI();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateSI();
        });

        function calculateSI() {
            const principal = parseFloat(document.getElementById('principal').value) || 0;
            const rate = parseFloat(document.getElementById('rate').value) || 0;
            const time = parseFloat(document.getElementById('time').value) || 0;
            const currency = currencySelect.value;

            // Simple Interest Formula: SI = (P × R × T) / 100
            const simpleInterestValue = (principal * rate * time) / 100;
            const totalAmountValue = principal + simpleInterestValue;

            // Year-by-year interest
            const interest1Year = (principal * rate * 1) / 100;
            const interest2Years = (principal * rate * 2) / 100;
            const interest3Years = (principal * rate * 3) / 100;
            const interest5Years = (principal * rate * 5) / 100;
            const interest10Years = (principal * rate * 10) / 100;

            // Monthly interest
            const monthlyInterestValue = simpleInterestValue / (time * 12);
            const yearlyInterestValue = (principal * rate) / 100;

            // Update UI
            document.getElementById('simpleInterest').textContent = formatCurrency(simpleInterestValue, currency);
            document.getElementById('principalDisplay').textContent = formatCurrency(principal, currency);
            document.getElementById('totalAmount').textContent = formatCurrency(totalAmountValue, currency);
            document.getElementById('rateDisplay').textContent = rate.toFixed(2) + '%';
            document.getElementById('timeDisplay').textContent = time + ' year' + (time !== 1 ? 's' : '');

            document.getElementById('calculation').textContent = `(${principal} × ${rate} × ${time}) / 100`;
            document.getElementById('siAmount').textContent = formatCurrency(simpleInterestValue, currency);

            document.getElementById('principalAmount').textContent = formatCurrency(principal, currency);
            document.getElementById('interestAmount').textContent = formatCurrency(simpleInterestValue, currency);
            document.getElementById('totalAmountDisplay').textContent = formatCurrency(totalAmountValue, currency);

            document.getElementById('year1').textContent = `SI: ${formatCurrency(interest1Year, currency)} | Total: ${formatCurrency(principal + interest1Year, currency)}`;
            document.getElementById('year2').textContent = `SI: ${formatCurrency(interest2Years, currency)} | Total: ${formatCurrency(principal + interest2Years, currency)}`;
            document.getElementById('year3').textContent = `SI: ${formatCurrency(interest3Years, currency)} | Total: ${formatCurrency(principal + interest3Years, currency)}`;
            document.getElementById('year5').textContent = `SI: ${formatCurrency(interest5Years, currency)} | Total: ${formatCurrency(principal + interest5Years, currency)}`;
            document.getElementById('year10').textContent = `SI: ${formatCurrency(interest10Years, currency)} | Total: ${formatCurrency(principal + interest10Years, currency)}`;

            document.getElementById('monthlyInterest').textContent = formatCurrency(monthlyInterestValue, currency);
            document.getElementById('yearlyInterest').textContent = formatCurrency(yearlyInterestValue, currency);
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
            calculateSI();
        });
    </script>
</body>
</html>