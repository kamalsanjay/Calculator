<?php
/**
 * Student Loan Calculator
 * File: student-loan-calculator.php
 * Description: Calculate student loan payments and payoff (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Loan Calculator - Calculate Loan Payments (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free student loan calculator. Calculate monthly payments, total interest, and payoff strategies. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#127891; Student Loan Calculator</h1>
        <p>Calculate student loan payments and payoff</p>
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
                <h2>Loan Details</h2>
                <form id="loanForm">
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
                        <label for="loanAmount">Total Loan Amount (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="loanAmount" value="30000" min="100" step="100" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% APR)</label>
                        <input type="number" id="interestRate" value="5.5" min="0" max="20" step="0.1" required>
                        <small>Federal: 4-8%, Private: 3-14%</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Years)</label>
                        <input type="number" id="loanTerm" value="10" min="1" max="30" step="1" required>
                        <small>Standard: 10 years</small>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Repayment Plan</h3>
                    
                    <div class="form-group">
                        <label for="repaymentPlan">Payment Plan</label>
                        <select id="repaymentPlan">
                            <option value="standard">Standard (Fixed Payments)</option>
                            <option value="graduated">Graduated (Start Low, Increase)</option>
                            <option value="extended">Extended (Lower Payments, Longer Term)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #4CAF50; margin: 25px 0 15px;">Extra Payments (Optional)</h3>
                    
                    <div class="form-group">
                        <label for="extraPayment">Extra Monthly Payment (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="extraPayment" value="0" min="0" step="10">
                        <small>Pay off faster and save interest</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="oneTimePayment">One-Time Extra Payment (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="oneTimePayment" value="0" min="0" step="100">
                        <small>Lump sum payment</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Loan</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Loan Summary</h2>
                
                <div class="result-card warning">
                    <h3>Monthly Payment</h3>
                    <div class="amount" id="monthlyPayment">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Interest</h4>
                        <div class="value" id="totalInterest">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Payoff Date</h4>
                        <div class="value" id="payoffDate">2035</div>
                    </div>
                    <div class="metric-card">
                        <h4>Time to Payoff</h4>
                        <div class="value" id="timeToPayoff">10 years</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Loan Details</h3>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="loanAmountDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="interestRateDisplay">5.5% APR</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Term</span>
                        <strong id="termDisplay">10 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Number of Payments</span>
                        <strong id="numPayments">120</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Monthly Payment</h3>
                    <div class="breakdown-item">
                        <span>Principal & Interest</span>
                        <strong id="standardPayment" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Extra Payment</span>
                        <strong id="extraPaymentDisplay" style="color: #4CAF50;">+$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Monthly Payment</strong></span>
                        <strong id="totalMonthlyPayment" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Cost Analysis</h3>
                    <div class="breakdown-item">
                        <span>Total Principal</span>
                        <strong id="principalTotal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest Paid</span>
                        <strong id="interestPaid" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>One-Time Payment</span>
                        <strong id="oneTimeDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Amount Paid</strong></span>
                        <strong id="totalPaid" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest as % of Loan</span>
                        <strong id="interestPercent" style="color: #f44336;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Payoff Timeline</h3>
                    <div class="breakdown-item">
                        <span>Loan Start Date</span>
                        <strong id="startDate">Today</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Payoff Date</span>
                        <strong id="payoffDateDisplay" style="color: #667eea;">2035</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Time to Payoff</span>
                        <strong id="monthsToPayoff">120 months (10 years)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>With Extra Payments</h3>
                    <div class="breakdown-item">
                        <span>Original Payoff</span>
                        <strong id="originalPayoff">10 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>New Payoff (With Extra)</span>
                        <strong id="newPayoff" style="color: #4CAF50;">10 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Time Saved</span>
                        <strong id="timeSaved" style="color: #4CAF50;">0 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Saved</span>
                        <strong id="interestSaved" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
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
                    <h3>Final Payment Breakdown</h3>
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
                    <h3>Bi-Weekly Payment Option</h3>
                    <div class="breakdown-item">
                        <span>Bi-Weekly Payment</span>
                        <strong id="biweeklyPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest (Bi-Weekly)</span>
                        <strong id="biweeklyInterest" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Payoff Time</span>
                        <strong id="biweeklyPayoff" style="color: #4CAF50;">0 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Savings vs Monthly</span>
                        <strong id="biweeklySavings" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Income-Based Comparison</h3>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="paymentForIncome">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Payment</span>
                        <strong id="annualPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>% of $50k Salary</span>
                        <strong id="percent50k">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>% of $75k Salary</span>
                        <strong id="percent75k">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Refinancing Potential</h3>
                    <div class="breakdown-item">
                        <span>Current Interest Rate</span>
                        <strong id="currentRate">5.5%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At 4% Interest</span>
                        <strong id="refi4">$0/month</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At 3% Interest</span>
                        <strong id="refi3">$0/month</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Potential Monthly Savings</span>
                        <strong id="refiSavings" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Student Loan Tips:</strong> Federal loans = better protections. Income-driven plans = lower payments. Public Service Loan Forgiveness = 120 payments. Consolidation ≠ refinancing. Private refinance = lose federal benefits. Pay extra to principal = save interest. Autopay = 0.25% rate discount. Grace period = 6 months after graduation. Deferment/forbearance = temporary relief. Interest capitalizes = higher balance. Avalanche method = highest rate first. Snowball = smallest balance first. Standard plan = 10 years. Tax deduction = up to $2,500 interest. Check eligibility annually.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('loanForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateLoan();
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
            calculateLoan();
        });

        function calculateLoan() {
            const loanAmount = parseFloat(document.getElementById('loanAmount').value) || 0;
            const annualRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0;
            const years = parseInt(document.getElementById('loanTerm').value) || 10;
            const extraPayment = parseFloat(document.getElementById('extraPayment').value) || 0;
            const oneTimePayment = parseFloat(document.getElementById('oneTimePayment').value) || 0;
            const currency = currencySelect.value;

            const monthlyRate = annualRate / 12;
            const months = years * 12;

            // Calculate standard monthly payment
            let monthlyPayment = 0;
            if (monthlyRate > 0) {
                monthlyPayment = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, months)) /
                               (Math.pow(1 + monthlyRate, months) - 1);
            } else {
                monthlyPayment = loanAmount / months;
            }

            // Calculate without extra payments
            const standardTotalPaid = monthlyPayment * months;
            const standardInterest = standardTotalPaid - loanAmount;

            // Calculate with extra payments
            let balance = loanAmount - oneTimePayment;
            let totalInterest = 0;
            let monthsToPayoff = 0;
            let firstPrincipal = 0, firstInterest = 0, firstBalance = 0;
            let lastPrincipal = 0, lastInterest = 0;

            while (balance > 0 && monthsToPayoff < months * 2) {
                const interest = balance * monthlyRate;
                const principal = Math.min(monthlyPayment + extraPayment - interest, balance);
                
                if (monthsToPayoff === 0) {
                    firstInterest = interest;
                    firstPrincipal = principal;
                    firstBalance = balance - principal;
                }
                
                balance -= principal;
                totalInterest += interest;
                monthsToPayoff++;
                
                lastPrincipal = principal;
                lastInterest = interest;
                
                if (balance <= 0) break;
            }

            const totalPaid = loanAmount + totalInterest + oneTimePayment;
            const interestSaved = standardInterest - totalInterest;
            const timeSaved = months - monthsToPayoff;

            // Dates
            const today = new Date();
            const payoffDate = new Date(today);
            payoffDate.setMonth(payoffDate.getMonth() + monthsToPayoff);

            // Bi-weekly
            const biweeklyPayment = monthlyPayment / 2;
            const biweeklyMonths = monthsToPayoff * 0.92; // Approximate
            const biweeklyInterest = totalInterest * 0.85; // Approximate
            const biweeklySavings = totalInterest - biweeklyInterest;

            // Income comparison
            const annualPayment = (monthlyPayment + extraPayment) * 12;
            const percent50k = (annualPayment / 50000) * 100;
            const percent75k = (annualPayment / 75000) * 100;

            // Refinancing
            const refi4Payment = loanAmount > 0 ? (loanAmount * (0.04/12) * Math.pow(1 + (0.04/12), months)) / (Math.pow(1 + (0.04/12), months) - 1) : 0;
            const refi3Payment = loanAmount > 0 ? (loanAmount * (0.03/12) * Math.pow(1 + (0.03/12), months)) / (Math.pow(1 + (0.03/12), months) - 1) : 0;
            const refiSavings = monthlyPayment - refi3Payment;

            const interestPercent = loanAmount > 0 ? (totalInterest / loanAmount) * 100 : 0;

            // Analysis
            let analysis = `With a ${formatCurrency(loanAmount, currency)} student loan at ${(annualRate * 100).toFixed(1)}% APR for ${years} years, your monthly payment is ${formatCurrency(monthlyPayment, currency)}. `;
            
            if (extraPayment > 0 || oneTimePayment > 0) {
                analysis += `By paying an extra ${formatCurrency(extraPayment, currency)}/month`;
                if (oneTimePayment > 0) analysis += ` and making a one-time payment of ${formatCurrency(oneTimePayment, currency)}`;
                analysis += `, you'll pay off the loan in ${Math.floor(monthsToPayoff / 12)} years and ${monthsToPayoff % 12} months (${timeSaved} months early), saving ${formatCurrency(interestSaved, currency)} in interest. `;
            }
            
            analysis += `Your total cost will be ${formatCurrency(totalPaid, currency)}, including ${formatCurrency(totalInterest, currency)} in interest. `;
            analysis += `The loan will be paid off by ${payoffDate.toLocaleDateString('en-US', {month: 'long', year: 'numeric'})}.`;

            // Update UI
            document.getElementById('monthlyPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('totalCost').textContent = formatCurrency(totalPaid, currency);
            document.getElementById('payoffDate').textContent = payoffDate.getFullYear();
            document.getElementById('timeToPayoff').textContent = Math.floor(monthsToPayoff / 12) + ' years';

            document.getElementById('loanAmountDisplay').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('interestRateDisplay').textContent = (annualRate * 100).toFixed(2) + '% APR';
            document.getElementById('termDisplay').textContent = years + ' years (' + months + ' months)';
            document.getElementById('numPayments').textContent = monthsToPayoff + ' payments';

            document.getElementById('standardPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('extraPaymentDisplay').textContent = formatCurrency(extraPayment, currency);
            document.getElementById('totalMonthlyPayment').textContent = formatCurrency(monthlyPayment + extraPayment, currency);

            document.getElementById('principalTotal').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('interestPaid').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('oneTimeDisplay').textContent = formatCurrency(oneTimePayment, currency);
            document.getElementById('totalPaid').textContent = formatCurrency(totalPaid, currency);
            document.getElementById('interestPercent').textContent = interestPercent.toFixed(1) + '%';

            document.getElementById('startDate').textContent = today.toLocaleDateString('en-US', {month: 'long', year: 'numeric'});
            document.getElementById('payoffDateDisplay').textContent = payoffDate.toLocaleDateString('en-US', {month: 'long', year: 'numeric'});
            document.getElementById('monthsToPayoff').textContent = monthsToPayoff + ' months (' + Math.floor(monthsToPayoff / 12) + ' years, ' + (monthsToPayoff % 12) + ' months)';

            document.getElementById('originalPayoff').textContent = years + ' years';
            document.getElementById('newPayoff').textContent = Math.floor(monthsToPayoff / 12) + ' years, ' + (monthsToPayoff % 12) + ' months';
            document.getElementById('timeSaved').textContent = Math.abs(timeSaved) + ' months' + (timeSaved > 0 ? ' saved' : '');
            document.getElementById('interestSaved').textContent = formatCurrency(Math.max(0, interestSaved), currency);

            document.getElementById('firstPrincipal').textContent = formatCurrency(firstPrincipal, currency);
            document.getElementById('firstInterest').textContent = formatCurrency(firstInterest, currency);
            document.getElementById('firstPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('firstBalance').textContent = formatCurrency(firstBalance, currency);

            document.getElementById('lastPrincipal').textContent = formatCurrency(lastPrincipal, currency);
            document.getElementById('lastInterest').textContent = formatCurrency(lastInterest, currency);
            document.getElementById('lastPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('lastBalance').textContent = formatCurrency(0, currency);

            document.getElementById('biweeklyPayment').textContent = formatCurrency(biweeklyPayment, currency);
            document.getElementById('biweeklyInterest').textContent = formatCurrency(biweeklyInterest, currency);
            document.getElementById('biweeklyPayoff').textContent = (biweeklyMonths / 12).toFixed(1) + ' years';
            document.getElementById('biweeklySavings').textContent = formatCurrency(biweeklySavings, currency);

            document.getElementById('paymentForIncome').textContent = formatCurrency(monthlyPayment + extraPayment, currency);
            document.getElementById('annualPayment').textContent = formatCurrency(annualPayment, currency);
            document.getElementById('percent50k').textContent = percent50k.toFixed(1) + '%';
            document.getElementById('percent75k').textContent = percent75k.toFixed(1) + '%';

            document.getElementById('currentRate').textContent = (annualRate * 100).toFixed(1) + '% APR';
            document.getElementById('refi4').textContent = formatCurrency(refi4Payment, currency) + '/month';
            document.getElementById('refi3').textContent = formatCurrency(refi3Payment, currency) + '/month';
            document.getElementById('refiSavings').textContent = formatCurrency(refiSavings, currency);

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
            calculateLoan();
        });
    </script>
</body>
</html>