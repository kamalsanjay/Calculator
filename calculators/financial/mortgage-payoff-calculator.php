<?php
/**
 * Mortgage Payoff Calculator
 * File: mortgage-payoff-calculator.php
 * Description: Calculate mortgage payoff with extra payments (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mortgage Payoff Calculator - Calculate Payoff with Extra Payments (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free mortgage payoff calculator. Calculate how extra payments reduce mortgage term and save interest. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#127968; Mortgage Payoff Calculator</h1>
        <p>Calculate payoff time with extra payments</p>
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
                <h2>Mortgage Details</h2>
                <form id="mortgageForm">
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
                        <label for="remainingBalance">Remaining Balance (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="remainingBalance" value="250000" min="1000" step="1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% APR)</label>
                        <input type="number" id="interestRate" value="6.5" min="0" max="30" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="remainingTerm">Remaining Term (Years)</label>
                        <input type="number" id="remainingTerm" value="25" min="1" max="50" step="1" required>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Extra Payment Options</h3>
                    
                    <div class="form-group">
                        <label for="extraMonthly">Extra Monthly Payment (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="extraMonthly" value="200" min="0" step="50">
                    </div>
                    
                    <div class="form-group">
                        <label for="extraYearly">Extra Yearly Payment (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="extraYearly" value="0" min="0" step="100">
                        <small>One-time annual payment</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="oneTimePayment">One-Time Extra Payment (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="oneTimePayment" value="0" min="0" step="1000">
                        <small>Lump sum payment now</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Payoff</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Payoff Analysis</h2>
                
                <div class="result-card success">
                    <h3>Interest Savings</h3>
                    <div class="amount" id="interestSavings">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Time Saved</h4>
                        <div class="value" id="timeSaved">0 years</div>
                    </div>
                    <div class="metric-card">
                        <h4>New Payoff Time</h4>
                        <div class="value" id="newPayoffTime">20 years</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Extra Payments</h4>
                        <div class="value" id="totalExtra">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>ROI on Extra Payments</h4>
                        <div class="value" id="roi">0%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Original Mortgage</h3>
                    <div class="breakdown-item">
                        <span>Remaining Balance</span>
                        <strong id="balanceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="rateDisplay">6.5% APR</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Remaining Term</span>
                        <strong id="termDisplay">25 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="monthlyPayment" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest (Original)</span>
                        <strong id="originalInterest" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Paid (Original)</span>
                        <strong id="originalTotal">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>With Extra Payments</h3>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="newMonthlyPayment" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Extra Monthly</span>
                        <strong id="extraMonthlyDisplay" style="color: #4CAF50;">+$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Monthly Payment</span>
                        <strong id="totalMonthlyNew" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>New Payoff Time</span>
                        <strong id="newTerm" style="color: #4CAF50;">0 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest (New)</span>
                        <strong id="newInterest" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Paid (New)</span>
                        <strong id="newTotal">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Savings Summary</h3>
                    <div class="breakdown-item">
                        <span>Interest Saved</span>
                        <strong id="interestSaved" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Time Saved</span>
                        <strong id="timeSavedMonths" style="color: #4CAF50;">0 months (0 years)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Extra Paid</span>
                        <strong id="totalExtraPaid">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Return on Extra Payments</span>
                        <strong id="returnRate" style="color: #667eea;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Extra Payment Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Extra Monthly Payments</span>
                        <strong id="extraMonthlyTotal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Extra Yearly Payments</span>
                        <strong id="extraYearlyTotal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>One-Time Payment</span>
                        <strong id="oneTimeTotal">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Extra Payments</strong></span>
                        <strong id="totalExtraSum" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Payoff Timeline</h3>
                    <div class="breakdown-item">
                        <span>Original Payoff</span>
                        <strong id="originalPayoff">25 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>New Payoff</span>
                        <strong id="newPayoff" style="color: #4CAF50;">20 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Months Saved</span>
                        <strong id="monthsSaved" style="color: #4CAF50;">60 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Years Saved</span>
                        <strong id="yearsSaved" style="color: #4CAF50;">5 years</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Balance Milestones</h3>
                    <div class="breakdown-item">
                        <span>After 5 Years (Original)</span>
                        <strong id="balance5Orig">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 5 Years (With Extra)</span>
                        <strong id="balance5New" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 10 Years (Original)</span>
                        <strong id="balance10Orig">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 10 Years (With Extra)</span>
                        <strong id="balance10New" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Payoff Tips:</strong> Extra payments go directly to principal. Even small extra payments save big. Pay bi-weekly = 1 extra monthly payment/year. Round up payments. Apply windfalls (bonus, tax refund). Specify "apply to principal" when paying. No prepayment penalties? Check first. Refinance vs extra payment? Compare. Consider opportunity cost. Emergency fund first. Mortgage vs investing? Depends on rates. Tax deduction value? High-rate debt first.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('mortgageForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculatePayoff();
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
            for (let i = 1; i <= 4; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculatePayoff();
        });

        function calculatePayoff() {
            const remainingBalance = parseFloat(document.getElementById('remainingBalance').value) || 0;
            const annualRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0;
            const remainingYears = parseInt(document.getElementById('remainingTerm').value) || 25;
            const extraMonthly = parseFloat(document.getElementById('extraMonthly').value) || 0;
            const extraYearly = parseFloat(document.getElementById('extraYearly').value) || 0;
            const oneTimePayment = parseFloat(document.getElementById('oneTimePayment').value) || 0;
            const currency = currencySelect.value;

            const monthlyRate = annualRate / 12;
            const originalMonths = remainingYears * 12;

            // Calculate original monthly payment
            let monthlyPayment = 0;
            if (monthlyRate > 0) {
                monthlyPayment = (remainingBalance * monthlyRate * Math.pow(1 + monthlyRate, originalMonths)) /
                               (Math.pow(1 + monthlyRate, originalMonths) - 1);
            } else {
                monthlyPayment = remainingBalance / originalMonths;
            }

            // Calculate original totals
            const originalTotalPaid = monthlyPayment * originalMonths;
            const originalInterest = originalTotalPaid - remainingBalance;

            // Calculate with extra payments
            let balance = remainingBalance - oneTimePayment;
            let monthsNew = 0;
            let totalInterestNew = 0;
            let totalExtraMonthly = 0;
            let totalExtraYearly = 0;
            let balance5New = 0, balance10New = 0;
            let balance5Orig = 0, balance10Orig = 0;

            // Calculate original milestones
            let balanceOrig = remainingBalance;
            for (let month = 1; month <= Math.min(120, originalMonths); month++) {
                const interest = balanceOrig * monthlyRate;
                const principal = monthlyPayment - interest;
                balanceOrig -= principal;
                
                if (month === 60) balance5Orig = balanceOrig;
                if (month === 120) balance10Orig = balanceOrig;
            }

            // Calculate with extra payments
            while (balance > 0 && monthsNew < originalMonths * 2) {
                monthsNew++;
                const interest = balance * monthlyRate;
                let principalPayment = monthlyPayment - interest + extraMonthly;
                
                // Add yearly payment
                if (monthsNew % 12 === 0) {
                    principalPayment += extraYearly;
                    totalExtraYearly += extraYearly;
                }
                
                totalExtraMonthly += extraMonthly;
                principalPayment = Math.min(principalPayment, balance + interest);
                
                balance -= (principalPayment - interest);
                totalInterestNew += interest;

                if (monthsNew === 60) balance5New = Math.max(0, balance);
                if (monthsNew === 120) balance10New = Math.max(0, balance);
                
                if (balance <= 0) break;
            }

            const timeSavedMonths = originalMonths - monthsNew;
            const timeSavedYears = timeSavedMonths / 12;
            const interestSaved = originalInterest - totalInterestNew;
            const totalExtraPaid = totalExtraMonthly + totalExtraYearly + oneTimePayment;
            const roi = totalExtraPaid > 0 ? (interestSaved / totalExtraPaid) * 100 : 0;

            const newTotalPaid = monthlyPayment * monthsNew + totalExtraPaid;

            // Analysis
            let analysis = `By paying an extra ${formatCurrency(extraMonthly, currency)} per month`;
            if (extraYearly > 0) analysis += ` and ${formatCurrency(extraYearly, currency)} annually`;
            if (oneTimePayment > 0) analysis += ` plus a one-time payment of ${formatCurrency(oneTimePayment, currency)}`;
            analysis += `, you will save ${formatCurrency(interestSaved, currency)} in interest and pay off your mortgage ${timeSavedYears.toFixed(1)} years earlier. `;
            analysis += `This is equivalent to earning a ${roi.toFixed(1)}% return on your extra payments.`;

            // Update UI
            document.getElementById('interestSavings').textContent = formatCurrency(interestSaved, currency);
            document.getElementById('timeSaved').textContent = timeSavedYears.toFixed(1) + ' years';
            document.getElementById('newPayoffTime').textContent = (monthsNew / 12).toFixed(1) + ' years';
            document.getElementById('totalExtra').textContent = formatCurrency(totalExtraPaid, currency);
            document.getElementById('roi').textContent = roi.toFixed(1) + '%';

            document.getElementById('balanceDisplay').textContent = formatCurrency(remainingBalance, currency);
            document.getElementById('rateDisplay').textContent = (annualRate * 100).toFixed(2) + '% APR';
            document.getElementById('termDisplay').textContent = remainingYears + ' years (' + originalMonths + ' months)';
            document.getElementById('monthlyPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('originalInterest').textContent = formatCurrency(originalInterest, currency);
            document.getElementById('originalTotal').textContent = formatCurrency(originalTotalPaid, currency);

            document.getElementById('newMonthlyPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('extraMonthlyDisplay').textContent = formatCurrency(extraMonthly, currency);
            document.getElementById('totalMonthlyNew').textContent = formatCurrency(monthlyPayment + extraMonthly, currency);
            document.getElementById('newTerm').textContent = (monthsNew / 12).toFixed(1) + ' years (' + monthsNew + ' months)';
            document.getElementById('newInterest').textContent = formatCurrency(totalInterestNew, currency);
            document.getElementById('newTotal').textContent = formatCurrency(newTotalPaid, currency);

            document.getElementById('interestSaved').textContent = formatCurrency(interestSaved, currency);
            document.getElementById('timeSavedMonths').textContent = timeSavedMonths + ' months (' + timeSavedYears.toFixed(1) + ' years)';
            document.getElementById('totalExtraPaid').textContent = formatCurrency(totalExtraPaid, currency);
            document.getElementById('returnRate').textContent = roi.toFixed(1) + '% return';

            document.getElementById('extraMonthlyTotal').textContent = formatCurrency(totalExtraMonthly, currency);
            document.getElementById('extraYearlyTotal').textContent = formatCurrency(totalExtraYearly, currency);
            document.getElementById('oneTimeTotal').textContent = formatCurrency(oneTimePayment, currency);
            document.getElementById('totalExtraSum').textContent = formatCurrency(totalExtraPaid, currency);

            document.getElementById('originalPayoff').textContent = remainingYears + ' years (' + originalMonths + ' months)';
            document.getElementById('newPayoff').textContent = (monthsNew / 12).toFixed(1) + ' years (' + monthsNew + ' months)';
            document.getElementById('monthsSaved').textContent = timeSavedMonths + ' months';
            document.getElementById('yearsSaved').textContent = timeSavedYears.toFixed(1) + ' years';

            document.getElementById('balance5Orig').textContent = formatCurrency(Math.max(0, balance5Orig), currency);
            document.getElementById('balance5New').textContent = formatCurrency(Math.max(0, balance5New), currency);
            document.getElementById('balance10Orig').textContent = formatCurrency(Math.max(0, balance10Orig), currency);
            document.getElementById('balance10New').textContent = formatCurrency(Math.max(0, balance10New), currency);

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
            calculatePayoff();
        });
    </script>
</body>
</html>