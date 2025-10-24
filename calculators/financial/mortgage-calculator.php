<?php
/**
 * Mortgage Calculator
 * File: mortgage-calculator.php
 * Description: Calculate home loan mortgage payments with amortization (USD/INR)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mortgage Calculator - Calculate Home Loan Payments (USD/INR)</title>
    <meta name="description" content="Free mortgage calculator. Calculate monthly home loan payments, total interest, and amortization. Plan your home purchase with USD and INR support.">
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
        <h1>🏠 Mortgage Calculator</h1>
        <p>Calculate your home loan payments and total costs</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Mortgage Details</h2>
                <form id="mortgageForm">
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
                        <label for="downPayment">Down Payment (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="downPayment" value="60000" min="0" step="1000" required>
                        <small>Typically 20% of home price</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Years)</label>
                        <input type="number" id="loanTerm" value="30" min="5" max="30" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% per annum)</label>
                        <input type="number" id="interestRate" value="6.5" min="1" max="20" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="propertyTax">Annual Property Tax (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="propertyTax" value="3000" min="0" step="100">
                        <small>Optional: Annual property tax</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Mortgage</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Mortgage Payment</h2>
                
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
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Down Payment %</h4>
                        <div class="value" id="downPaymentPercent">0%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Mortgage Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Home Price</span>
                        <strong id="homePriceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="downPaymentDisplay">$0</strong>
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
                    <h3>Monthly Payment Details</h3>
                    <div class="breakdown-item">
                        <span>Principal & Interest</span>
                        <strong id="principalInterest">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Property Tax</span>
                        <strong id="taxAmount">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Monthly Payment</strong></span>
                        <strong id="totalMonthly" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Payment Over Loan Term</h3>
                    <div class="breakdown-item">
                        <span>Total Principal Payments</span>
                        <strong id="totalPrincipal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest Payments</span>
                        <strong id="interestPayments">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Property Tax</span>
                        <strong id="totalPropertyTax">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Amount Paid</strong></span>
                        <strong id="grandTotal" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Mortgage Formula:</strong> M = P[r(1+r)^n]/[(1+r)^n-1], where M is monthly payment, P is loan principal, r is monthly interest rate, and n is number of payments. Down payment typically 20% to avoid PMI.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('mortgageForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateMortgage();
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
            calculateMortgage();
        });

        function calculateMortgage() {
            const homePrice = parseFloat(document.getElementById('homePrice').value) || 0;
            const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
            const loanTerm = parseInt(document.getElementById('loanTerm').value) || 30;
            const annualRate = parseFloat(document.getElementById('interestRate').value) || 0;
            const propertyTax = parseFloat(document.getElementById('propertyTax').value) || 0;
            const currency = currencySelect.value;

            const loanAmount = homePrice - downPayment;
            const monthlyRate = annualRate / 12 / 100;
            const numberOfPayments = loanTerm * 12;

            // Monthly Payment Formula: M = P[r(1+r)^n]/[(1+r)^n-1]
            let monthlyPayment = 0;
            if (monthlyRate > 0) {
                monthlyPayment = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)) /
                                (Math.pow(1 + monthlyRate, numberOfPayments) - 1);
            } else {
                monthlyPayment = loanAmount / numberOfPayments;
            }

            const monthlyPropertyTax = propertyTax / 12;
            const totalMonthlyPayment = monthlyPayment + monthlyPropertyTax;

            const totalPrincipalPayments = loanAmount;
            const totalInterestPayments = (monthlyPayment * numberOfPayments) - loanAmount;
            const totalPropertyTaxPaid = propertyTax * loanTerm;
            const totalCost = totalPrincipalPayments + totalInterestPayments + totalPropertyTaxPaid;

            const downPaymentPercent = homePrice > 0 ? (downPayment / homePrice) * 100 : 0;

            // Update UI
            document.getElementById('monthlyPayment').textContent = formatCurrency(totalMonthlyPayment, currency);
            document.getElementById('loanAmount').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterestPayments, currency);
            document.getElementById('totalCost').textContent = formatCurrency(totalCost, currency);
            document.getElementById('downPaymentPercent').textContent = downPaymentPercent.toFixed(1) + '%';

            document.getElementById('homePriceDisplay').textContent = formatCurrency(homePrice, currency);
            document.getElementById('downPaymentDisplay').textContent = formatCurrency(downPayment, currency);
            document.getElementById('loanAmountDisplay').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('rateDisplay').textContent = annualRate.toFixed(2) + '%';
            document.getElementById('termDisplay').textContent = loanTerm + ' years (' + numberOfPayments + ' payments)';

            document.getElementById('principalInterest').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('taxAmount').textContent = formatCurrency(monthlyPropertyTax, currency);
            document.getElementById('totalMonthly').textContent = formatCurrency(totalMonthlyPayment, currency);

            document.getElementById('totalPrincipal').textContent = formatCurrency(totalPrincipalPayments, currency);
            document.getElementById('interestPayments').textContent = formatCurrency(totalInterestPayments, currency);
            document.getElementById('totalPropertyTax').textContent = formatCurrency(totalPropertyTaxPaid, currency);
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
            calculateMortgage();
        });
    </script>
</body>
</html>