<?php
/**
 * Car Loan Calculator
 * File: car-loan-calculator.php
 * Description: Calculate car/auto loan EMI and total costs (USD/INR)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Loan Calculator - Calculate Auto Loan EMI (USD/INR)</title>
    <meta name="description" content="Free car loan calculator. Calculate monthly auto loan payments, total interest, and vehicle financing costs. Supports USD and INR currencies.">
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
        <h1>🚗 Car Loan Calculator</h1>
        <p>Calculate your auto loan payments and total costs</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Car Loan Details</h2>
                <form id="carLoanForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="carPrice">Car Price (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="carPrice" value="30000" min="1000" step="500" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="downPayment">Down Payment (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="downPayment" value="5000" min="0" step="500" required>
                        <small>Typically 10-20% of car price</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Years)</label>
                        <input type="number" id="loanTerm" value="5" min="1" max="10" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% per annum)</label>
                        <input type="number" id="interestRate" value="7" min="0.1" max="25" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="tradeIn">Trade-In Value (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="tradeIn" value="0" min="0" step="500">
                        <small>Optional: Value of your old car</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Car Loan</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Loan Payment</h2>
                
                <div class="result-card">
                    <h3>Monthly EMI</h3>
                    <div class="amount" id="monthlyEMI">$0</div>
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
                        <h4>Total Payment</h4>
                        <div class="value" id="totalPayment">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Car Loan Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Car Price</span>
                        <strong id="carPriceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="downPaymentDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Trade-In Value</span>
                        <strong id="tradeInDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="loanAmountDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="rateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Term</span>
                        <strong id="termDisplay">0 years</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Payment Summary</h3>
                    <div class="breakdown-item">
                        <span>Monthly EMI</span>
                        <strong id="emiAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Number of Payments</span>
                        <strong id="numberOfPayments">0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Principal</span>
                        <strong id="totalPrincipal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest Paid</span>
                        <strong id="interestPaid" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Amount Payable</strong></span>
                        <strong id="totalPayable" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Car Cost</h3>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="downPaymentCost">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Payments</span>
                        <strong id="loanPayments">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Less: Trade-In</span>
                        <strong id="tradeInCredit">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Cost of Car</strong></span>
                        <strong id="grandTotal" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Car Loan Tips:</strong> Put down at least 20% to reduce interest. Shorter loan terms save money but increase monthly payments. Check for promotional rates from dealers. Factor in insurance, maintenance, and fuel costs.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('carLoanForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateCarLoan();
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
            calculateCarLoan();
        });

        function calculateCarLoan() {
            const carPrice = parseFloat(document.getElementById('carPrice').value) || 0;
            const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
            const loanTerm = parseInt(document.getElementById('loanTerm').value) || 5;
            const annualRate = parseFloat(document.getElementById('interestRate').value) || 0;
            const tradeIn = parseFloat(document.getElementById('tradeIn').value) || 0;
            const currency = currencySelect.value;

            const loanAmount = carPrice - downPayment - tradeIn;
            const monthlyRate = annualRate / 12 / 100;
            const numberOfPayments = loanTerm * 12;

            // EMI Formula
            let monthlyEMI = 0;
            if (monthlyRate > 0) {
                monthlyEMI = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)) /
                           (Math.pow(1 + monthlyRate, numberOfPayments) - 1);
            } else {
                monthlyEMI = loanAmount / numberOfPayments;
            }

            const totalPayment = monthlyEMI * numberOfPayments;
            const totalInterest = totalPayment - loanAmount;
            const totalCost = downPayment + totalPayment - tradeIn;

            // Update UI
            document.getElementById('monthlyEMI').textContent = formatCurrency(monthlyEMI, currency);
            document.getElementById('loanAmount').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('totalPayment').textContent = formatCurrency(totalPayment, currency);
            document.getElementById('totalCost').textContent = formatCurrency(totalCost, currency);

            document.getElementById('carPriceDisplay').textContent = formatCurrency(carPrice, currency);
            document.getElementById('downPaymentDisplay').textContent = formatCurrency(downPayment, currency);
            document.getElementById('tradeInDisplay').textContent = formatCurrency(tradeIn, currency);
            document.getElementById('loanAmountDisplay').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('rateDisplay').textContent = annualRate.toFixed(2) + '%';
            document.getElementById('termDisplay').textContent = loanTerm + ' years (' + numberOfPayments + ' months)';

            document.getElementById('emiAmount').textContent = formatCurrency(monthlyEMI, currency);
            document.getElementById('numberOfPayments').textContent = numberOfPayments + ' months';
            document.getElementById('totalPrincipal').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('interestPaid').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('totalPayable').textContent = formatCurrency(totalPayment, currency);

            document.getElementById('downPaymentCost').textContent = formatCurrency(downPayment, currency);
            document.getElementById('loanPayments').textContent = formatCurrency(totalPayment, currency);
            document.getElementById('tradeInCredit').textContent = '-' + formatCurrency(tradeIn, currency);
            document.getElementById('grandTotal').textContent = formatCurrency(totalCost, currency);
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
            calculateCarLoan();
        });
    </script>
</body>
</html>