<?php
/**
 * Payment Calculator
 * File: payment-calculator.php
 * Description: Calculate installment payments for purchases (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Calculator - Calculate Installment Payments (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free payment calculator. Calculate monthly installment payments for purchases. Compare financing options. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128179; Payment Calculator</h1>
        <p>Calculate your installment payments</p>
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
                <h2>Payment Details</h2>
                <form id="paymentForm">
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
                        <label for="purchasePrice">Purchase Price (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="purchasePrice" value="10000" min="100" step="100" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="downPayment">Down Payment (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="downPayment" value="2000" min="0" step="100">
                        <small>Initial payment</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% APR)</label>
                        <input type="number" id="interestRate" value="8" min="0" max="30" step="0.5" required>
                        <small>Annual percentage rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Months)</label>
                        <input type="number" id="loanTerm" value="24" min="1" max="120" step="1" required>
                        <small>Number of monthly payments</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="paymentFrequency">Payment Frequency</label>
                        <select id="paymentFrequency">
                            <option value="monthly">Monthly</option>
                            <option value="biweekly">Bi-Weekly</option>
                            <option value="weekly">Weekly</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="tradeinValue">Trade-In Value (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="tradeinValue" value="0" min="0" step="100">
                        <small>Optional: reduces purchase price</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Payment</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Payment Summary</h2>
                
                <div class="result-card">
                    <h3>Monthly Payment</h3>
                    <div class="amount" id="monthlyPayment">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Amount Financed</h4>
                        <div class="value" id="amountFinanced">$0</div>
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
                        <h4>Number of Payments</h4>
                        <div class="value" id="numPayments">24</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Purchase Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Purchase Price</span>
                        <strong id="priceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Trade-In Value</span>
                        <strong id="tradeinDisplay" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="downPaymentDisplay" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Amount Financed</strong></span>
                        <strong id="financedAmount" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Loan Terms</h3>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="rateDisplay">8% APR</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Term</span>
                        <strong id="termDisplay">24 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Payment Frequency</span>
                        <strong id="frequencyDisplay">Monthly</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Payments</span>
                        <strong id="totalPaymentsCount">24</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Payment Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="monthlyPaymentDisplay" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Bi-Weekly Payment</span>
                        <strong id="biweeklyPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekly Payment</span>
                        <strong id="weeklyPayment">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Cost Analysis</h3>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="downPaymentCost">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total of Payments</span>
                        <strong id="totalPayments">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest Paid</span>
                        <strong id="interestPaid" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Cost (including interest)</strong></span>
                        <strong id="grandTotal" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>First Payment Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Principal</span>
                        <strong id="firstPrincipal" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest</span>
                        <strong id="firstInterest" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Payment</span>
                        <strong id="firstPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Remaining Balance</span>
                        <strong id="firstBalance">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Last Payment Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Principal</span>
                        <strong id="lastPrincipal" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest</span>
                        <strong id="lastInterest" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Payment</span>
                        <strong id="lastPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Remaining Balance</span>
                        <strong id="lastBalance" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Interest Paid Over Time</h3>
                    <div class="breakdown-item">
                        <span>First 6 Months</span>
                        <strong id="interest6" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>First 12 Months</span>
                        <strong id="interest12" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>First 24 Months</span>
                        <strong id="interest24" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest</span>
                        <strong id="interestTotal" style="color: #f44336;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Cost Comparison</h3>
                    <div class="breakdown-item">
                        <span>Cash Price (No Financing)</span>
                        <strong id="cashPrice" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Financed Price</span>
                        <strong id="financedPrice">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cost of Financing</span>
                        <strong id="financingCost" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>% Increase Due to Interest</span>
                        <strong id="percentIncrease">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Payment Tips:</strong> Higher down payment = lower monthly payment. Shorter term = higher payment but less interest. Shop rates from multiple lenders. Check total cost, not just monthly payment. Pre-approval helps negotiation. Trade-in can reduce amount financed. 0% financing = best deal if available. Consider opportunity cost. Can you afford payment comfortably? Budget for insurance, maintenance. Pay extra to principal when possible. Avoid extending terms unnecessarily. Read fine print carefully.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('paymentForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculatePayment();
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
            for (let i = 1; i <= 3; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculatePayment();
        });

        function calculatePayment() {
            const purchasePrice = parseFloat(document.getElementById('purchasePrice').value) || 0;
            const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
            const tradeinValue = parseFloat(document.getElementById('tradeinValue').value) || 0;
            const annualRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0;
            const months = parseInt(document.getElementById('loanTerm').value) || 24;
            const frequency = document.getElementById('paymentFrequency').value;
            const currency = currencySelect.value;

            const monthlyRate = annualRate / 12;
            const amountFinanced = purchasePrice - downPayment - tradeinValue;

            // Calculate monthly payment
            let monthlyPayment = 0;
            if (monthlyRate > 0) {
                monthlyPayment = (amountFinanced * monthlyRate * Math.pow(1 + monthlyRate, months)) /
                               (Math.pow(1 + monthlyRate, months) - 1);
            } else {
                monthlyPayment = amountFinanced / months;
            }

            const totalPayments = monthlyPayment * months;
            const totalInterest = totalPayments - amountFinanced;
            const totalCost = downPayment + totalPayments;

            // Calculate different payment frequencies
            const biweeklyPayment = (monthlyPayment * 12) / 26;
            const weeklyPayment = (monthlyPayment * 12) / 52;

            // First and last payment breakdown
            const firstInterest = amountFinanced * monthlyRate;
            const firstPrincipal = monthlyPayment - firstInterest;
            const firstBalance = amountFinanced - firstPrincipal;

            // Calculate last payment
            let balance = amountFinanced;
            let lastPrincipal = 0, lastInterest = 0;
            let interest6 = 0, interest12 = 0, interest24 = 0;

            for (let month = 1; month <= months; month++) {
                const interest = balance * monthlyRate;
                const principal = monthlyPayment - interest;
                balance -= principal;

                if (month <= 6) interest6 += interest;
                if (month <= 12) interest12 += interest;
                if (month <= 24) interest24 += interest;

                if (month === months) {
                    lastPrincipal = principal;
                    lastInterest = interest;
                }
            }

            const cashPrice = purchasePrice - tradeinValue;
            const financingCost = totalInterest;
            const percentIncrease = cashPrice > 0 ? (financingCost / cashPrice) * 100 : 0;

            // Analysis
            let analysis = `For a purchase price of ${formatCurrency(purchasePrice, currency)} with a ${formatCurrency(downPayment, currency)} down payment`;
            if (tradeinValue > 0) analysis += ` and ${formatCurrency(tradeinValue, currency)} trade-in`;
            analysis += `, you will finance ${formatCurrency(amountFinanced, currency)} at ${(annualRate * 100).toFixed(1)}% APR for ${months} months. `;
            analysis += `Your monthly payment will be ${formatCurrency(monthlyPayment, currency)}. `;
            analysis += `Over the life of the loan, you will pay ${formatCurrency(totalInterest, currency)} in interest, bringing your total cost to ${formatCurrency(totalCost, currency)}.`;

            // Update UI
            document.getElementById('monthlyPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('amountFinanced').textContent = formatCurrency(amountFinanced, currency);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('totalCost').textContent = formatCurrency(totalCost, currency);
            document.getElementById('numPayments').textContent = months;

            document.getElementById('priceDisplay').textContent = formatCurrency(purchasePrice, currency);
            document.getElementById('tradeinDisplay').textContent = formatCurrency(tradeinValue, currency);
            document.getElementById('downPaymentDisplay').textContent = formatCurrency(downPayment, currency);
            document.getElementById('financedAmount').textContent = formatCurrency(amountFinanced, currency);

            document.getElementById('rateDisplay').textContent = (annualRate * 100).toFixed(2) + '% APR';
            document.getElementById('termDisplay').textContent = months + ' months (' + (months / 12).toFixed(1) + ' years)';
            const freqNames = {'monthly': 'Monthly', 'biweekly': 'Bi-Weekly', 'weekly': 'Weekly'};
            document.getElementById('frequencyDisplay').textContent = freqNames[frequency];
            document.getElementById('totalPaymentsCount').textContent = months + ' payments';

            document.getElementById('monthlyPaymentDisplay').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('biweeklyPayment').textContent = formatCurrency(biweeklyPayment, currency);
            document.getElementById('weeklyPayment').textContent = formatCurrency(weeklyPayment, currency);

            document.getElementById('downPaymentCost').textContent = formatCurrency(downPayment, currency);
            document.getElementById('totalPayments').textContent = formatCurrency(totalPayments, currency);
            document.getElementById('interestPaid').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('grandTotal').textContent = formatCurrency(totalCost, currency);

            document.getElementById('firstPrincipal').textContent = formatCurrency(firstPrincipal, currency);
            document.getElementById('firstInterest').textContent = formatCurrency(firstInterest, currency);
            document.getElementById('firstPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('firstBalance').textContent = formatCurrency(firstBalance, currency);

            document.getElementById('lastPrincipal').textContent = formatCurrency(lastPrincipal, currency);
            document.getElementById('lastInterest').textContent = formatCurrency(lastInterest, currency);
            document.getElementById('lastPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('lastBalance').textContent = formatCurrency(0, currency);

            document.getElementById('interest6').textContent = formatCurrency(interest6, currency);
            document.getElementById('interest12').textContent = formatCurrency(interest12, currency);
            document.getElementById('interest24').textContent = formatCurrency(interest24, currency);
            document.getElementById('interestTotal').textContent = formatCurrency(totalInterest, currency);

            document.getElementById('cashPrice').textContent = formatCurrency(cashPrice, currency);
            document.getElementById('financedPrice').textContent = formatCurrency(totalCost, currency);
            document.getElementById('financingCost').textContent = formatCurrency(financingCost, currency);
            document.getElementById('percentIncrease').textContent = percentIncrease.toFixed(1) + '%';

            document.getElementById('analysisText').textContent = analysis;
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
            calculatePayment();
        });
    </script>
</body>
</html>