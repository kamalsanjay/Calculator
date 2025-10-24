<?php
/**
 * Auto Loan Calculator
 * File: auto-loan-calculator.php
 * Description: Calculate car loan payments with trade-in and down payment (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Loan Calculator - Calculate Car Loan Payment (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free auto loan calculator. Calculate monthly car payments with trade-in value, down payment, taxes, and fees. Supports USD, INR, EUR, and GBP currencies.">
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
        <h1>🚗 Auto Loan Calculator</h1>
        <p>Calculate your monthly car payment with ease</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Vehicle & Loan Details</h2>
                <form id="autoLoanForm">
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
                        <label for="vehiclePrice">Vehicle Price (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="vehiclePrice" value="30000" min="1000" step="500" required>
                        <small>MSRP or negotiated price</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="downPayment">Down Payment (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="downPayment" value="5000" min="0" step="500">
                        <small>Cash down payment</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="tradeInValue">Trade-In Value (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="tradeInValue" value="0" min="0" step="500">
                        <small>Current car trade-in value</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="tradeInOwed">Amount Owed on Trade-In (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="tradeInOwed" value="0" min="0" step="500">
                        <small>Outstanding loan on trade-in</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="salesTax">Sales Tax (%)</label>
                        <input type="number" id="salesTax" value="7" min="0" max="15" step="0.1">
                    </div>
                    
                    <div class="form-group">
                        <label for="otherFees">Other Fees (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="otherFees" value="500" min="0" step="50">
                        <small>Registration, documentation fees</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% APR)</label>
                        <input type="number" id="interestRate" value="5.5" min="0" max="30" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Years)</label>
                        <select id="loanTerm">
                            <option value="2">2 years</option>
                            <option value="3">3 years</option>
                            <option value="4">4 years</option>
                            <option value="5" selected>5 years</option>
                            <option value="6">6 years</option>
                            <option value="7">7 years</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Payment</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Loan Summary</h2>
                
                <div class="result-card">
                    <h3>Monthly Payment</h3>
                    <div class="amount" id="monthlyPayment">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Loan Amount</h4>
                        <div class="value" id="loanAmount">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Interest</h4>
                        <div class="value" id="totalInterest">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Payments</h4>
                        <div class="value" id="totalPayments">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Vehicle Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Vehicle Price</span>
                        <strong id="priceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Sales Tax</span>
                        <strong id="taxAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Fees</span>
                        <strong id="feesAmount">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Vehicle Cost</strong></span>
                        <strong id="totalVehicleCost" style="color: #667eea;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Down Payment & Trade-In</h3>
                    <div class="breakdown-item">
                        <span>Cash Down Payment</span>
                        <strong id="downPaymentDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Trade-In Value</span>
                        <strong id="tradeInDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Less: Amount Owed on Trade-In</span>
                        <strong id="tradeInOwedDisplay" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Net Trade-In Value</span>
                        <strong id="netTradeIn" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Down Payment</strong></span>
                        <strong id="totalDown" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Loan Details</h3>
                    <div class="breakdown-item">
                        <span>Total Vehicle Cost</span>
                        <strong id="vehicleCostLoan">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Less: Total Down Payment</span>
                        <strong id="downDeduction" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Amount Financed</strong></span>
                        <strong id="amountFinanced" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="rateDisplay">0% APR</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Term</span>
                        <strong id="termDisplay">0 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="paymentDisplay" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Cost of Ownership</h3>
                    <div class="breakdown-item">
                        <span>Total Down Payment</span>
                        <strong id="downTotal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Monthly Payments</span>
                        <strong id="monthlyTotal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest Paid</span>
                        <strong id="interestTotal" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Cost</strong></span>
                        <strong id="grandTotal" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Auto Loan Tips:</strong> 20% down payment recommended. Negotiate price before discussing financing. Check credit score for best rates. Shorter terms = less interest. Consider total cost, not just monthly payment. Get pre-approved for negotiation power. Avoid negative equity on trade-ins.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('autoLoanForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateAutoLoan();
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
            for (let i = 1; i <= 5; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateAutoLoan();
        });

        function calculateAutoLoan() {
            const vehiclePrice = parseFloat(document.getElementById('vehiclePrice').value) || 0;
            const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
            const tradeInValue = parseFloat(document.getElementById('tradeInValue').value) || 0;
            const tradeInOwed = parseFloat(document.getElementById('tradeInOwed').value) || 0;
            const salesTaxRate = parseFloat(document.getElementById('salesTax').value) / 100 || 0;
            const otherFees = parseFloat(document.getElementById('otherFees').value) || 0;
            const annualRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0;
            const years = parseInt(document.getElementById('loanTerm').value) || 5;
            const currency = currencySelect.value;

            // Calculate sales tax
            const salesTax = vehiclePrice * salesTaxRate;
            
            // Total vehicle cost
            const totalVehicleCost = vehiclePrice + salesTax + otherFees;
            
            // Net trade-in (trade-in value minus what's owed)
            const netTradeIn = tradeInValue - tradeInOwed;
            
            // Total down payment
            const totalDown = downPayment + netTradeIn;
            
            // Amount to finance
            const loanAmount = totalVehicleCost - totalDown;
            
            // Calculate monthly payment
            const monthlyRate = annualRate / 12;
            const months = years * 12;
            let monthlyPayment = 0;
            
            if (monthlyRate > 0) {
                monthlyPayment = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, months)) /
                               (Math.pow(1 + monthlyRate, months) - 1);
            } else {
                monthlyPayment = loanAmount / months;
            }
            
            // Total amounts
            const totalMonthlyPayments = monthlyPayment * months;
            const totalInterest = totalMonthlyPayments - loanAmount;
            const totalCost = totalDown + totalMonthlyPayments;

            // Update UI
            document.getElementById('monthlyPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('loanAmount').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('totalPayments').textContent = formatCurrency(totalMonthlyPayments, currency);
            document.getElementById('totalCost').textContent = formatCurrency(totalCost, currency);

            document.getElementById('priceDisplay').textContent = formatCurrency(vehiclePrice, currency);
            document.getElementById('taxAmount').textContent = formatCurrency(salesTax, currency);
            document.getElementById('feesAmount').textContent = formatCurrency(otherFees, currency);
            document.getElementById('totalVehicleCost').textContent = formatCurrency(totalVehicleCost, currency);

            document.getElementById('downPaymentDisplay').textContent = formatCurrency(downPayment, currency);
            document.getElementById('tradeInDisplay').textContent = formatCurrency(tradeInValue, currency);
            document.getElementById('tradeInOwedDisplay').textContent = formatCurrency(tradeInOwed, currency);
            document.getElementById('netTradeIn').textContent = formatCurrency(netTradeIn, currency);
            document.getElementById('totalDown').textContent = formatCurrency(totalDown, currency);

            document.getElementById('vehicleCostLoan').textContent = formatCurrency(totalVehicleCost, currency);
            document.getElementById('downDeduction').textContent = formatCurrency(totalDown, currency);
            document.getElementById('amountFinanced').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('rateDisplay').textContent = (annualRate * 100).toFixed(2) + '% APR';
            document.getElementById('termDisplay').textContent = months + ' months (' + years + ' years)';
            document.getElementById('paymentDisplay').textContent = formatCurrency(monthlyPayment, currency);

            document.getElementById('downTotal').textContent = formatCurrency(totalDown, currency);
            document.getElementById('monthlyTotal').textContent = formatCurrency(totalMonthlyPayments, currency);
            document.getElementById('interestTotal').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('grandTotal').textContent = formatCurrency(totalCost, currency);
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
            calculateAutoLoan();
        });
    </script>
</body>
</html>