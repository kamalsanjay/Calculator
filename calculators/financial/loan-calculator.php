<?php
/**
 * Loan Calculator
 * File: loan-calculator.php
 * Description: Calculate loan payments and total interest (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Calculator - Calculate Monthly Payments (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free loan calculator. Calculate monthly payments, total interest, and amortization schedule. Compare loan options. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128178; Loan Calculator</h1>
        <p>Calculate your loan payments and interest</p>
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

/* Header Styles */
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

/* Breadcrumb */
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

/* Calculator Layout */
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

/* Form Styles */
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

/* Button */
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

/* Result Card */
.result-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px;
    border-radius: 10px;
    margin-bottom: 20px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.result-card.success {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
}

.result-card.warning {
    background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
    box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
}

.result-card.info {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
    box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
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

/* Metric Grid */
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

/* Breakdown Section */
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

/* Info Box */
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

/* Tables */
.schedule-table {
    width: 100%;
    margin-top: 20px;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

table thead {
    background: #667eea;
    color: white;
}

table th,
table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

table tbody tr:hover {
    background: #f8f9fa;
}

/* Utility Classes */
.text-center {
    text-align: center;
}

.text-success {
    color: #4CAF50;
}

.text-danger {
    color: #f44336;
}

.text-warning {
    color: #FF9800;
}

.text-info {
    color: #2196F3;
}

.text-primary {
    color: #667eea;
}

.mt-10 {
    margin-top: 10px;
}

.mt-20 {
    margin-top: 20px;
}

.mb-10 {
    margin-bottom: 10px;
}

.mb-20 {
    margin-bottom: 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .calculator-wrapper {
        grid-template-columns: 1fr;
    }
    
    header h1 {
        font-size: 2em;
    }
    
    header p {
        font-size: 1em;
    }
    
    .result-card .amount {
        font-size: 2.5em;
    }
    
    .metric-grid {
        grid-template-columns: 1fr;
    }
    
    table {
        font-size: 0.9em;
    }
    
    .calculator-section,
    .results-section {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 10px;
    }
    
    header {
        padding: 30px 15px;
    }
    
    header h1 {
        font-size: 1.8em;
    }
    
    .result-card .amount {
        font-size: 2em;
    }
    
    .form-group input,
    .form-group select {
        padding: 10px;
        font-size: 14px;
    }
    
    .btn {
        padding: 12px 20px;
        font-size: 16px;
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
                        <label for="loanAmount">Loan Amount (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="loanAmount" value="200000" min="1000" step="1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% APR)</label>
                        <input type="number" id="interestRate" value="6.5" min="0" max="30" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Years)</label>
                        <input type="number" id="loanTerm" value="30" min="1" max="50" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="startDate">Loan Start Date</label>
                        <input type="month" id="startDate" value="2024-01">
                    </div>
                    
                    <div class="form-group">
                        <label for="extraPayment">Extra Monthly Payment (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="extraPayment" value="0" min="0" step="50">
                        <small>Optional additional payment</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Loan</button>
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
                        <h4>Total Interest</h4>
                        <div class="value" id="totalInterest">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Amount</h4>
                        <div class="value" id="totalAmount">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Payoff Date</h4>
                        <div class="value" id="payoffDate">Jan 2054</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Payments</h4>
                        <div class="value" id="totalPayments">360</div>
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
                        <strong id="rateDisplay">6.5% APR</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Term</span>
                        <strong id="termDisplay">30 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Number of Payments</span>
                        <strong id="paymentsDisplay">360</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Monthly Payment Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Principal & Interest</span>
                        <strong id="piPayment" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Extra Payment</span>
                        <strong id="extraPaymentDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Monthly Payment</strong></span>
                        <strong id="totalMonthly" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Cost Analysis</h3>
                    <div class="breakdown-item">
                        <span>Loan Amount (Principal)</span>
                        <strong id="principalAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest Paid</span>
                        <strong id="interestPaid" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest as % of Loan</span>
                        <strong id="interestPercent">0%</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Amount Paid</strong></span>
                        <strong id="totalPaid" style="color: #667eea; font-size: 1.2em;">$0</strong>
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
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>With Extra Payments</h3>
                    <div class="breakdown-item">
                        <span>Time Saved</span>
                        <strong id="timeSaved" style="color: #4CAF50;">0 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Saved</span>
                        <strong id="interestSaved" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>New Payoff Date</span>
                        <strong id="newPayoffDate">Jan 2054</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Loan Milestones</h3>
                    <div class="breakdown-item">
                        <span>Balance After 5 Years</span>
                        <strong id="balance5">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Balance After 10 Years</span>
                        <strong id="balance10">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Balance After 15 Years</span>
                        <strong id="balance15">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Balance After 20 Years</span>
                        <strong id="balance20">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Interest Paid Over Time</h3>
                    <div class="breakdown-item">
                        <span>First 5 Years</span>
                        <strong id="interest5" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>First 10 Years</span>
                        <strong id="interest10" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>First 15 Years</span>
                        <strong id="interest15" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest</span>
                        <strong id="interestTotal" style="color: #f44336;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Loan Tips:</strong> Shop around for best rates. Lower interest = less total cost. Shorter terms = higher payments but less interest. Extra payments reduce principal faster. Pay bi-weekly = 13 monthly payments/year. Avoid unnecessary loans. Good credit = better rates. Consider total cost, not just monthly payment. Refinance if rates drop. Auto-pay may reduce rate. Read all terms carefully.
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
            for (let i = 1; i <= 2; i++) {
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
            const years = parseInt(document.getElementById('loanTerm').value) || 30;
            const extraPayment = parseFloat(document.getElementById('extraPayment').value) || 0;
            const startDate = document.getElementById('startDate').value || '2024-01';
            const currency = currencySelect.value;

            const monthlyRate = annualRate / 12;
            const months = years * 12;

            // Calculate monthly payment (without extra)
            let monthlyPayment = 0;
            if (monthlyRate > 0) {
                monthlyPayment = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, months)) /
                               (Math.pow(1 + monthlyRate, months) - 1);
            } else {
                monthlyPayment = loanAmount / months;
            }

            // Calculate totals
            const totalPayment = monthlyPayment * months;
            const totalInterest = totalPayment - loanAmount;
            const interestPercent = (totalInterest / loanAmount) * 100;

            // First payment breakdown
            const firstInterest = loanAmount * monthlyRate;
            const firstPrincipal = monthlyPayment - firstInterest;

            // Calculate with amortization for accurate last payment and milestones
            let balance = loanAmount;
            let totalInterestPaid = 0;
            let balance5 = 0, balance10 = 0, balance15 = 0, balance20 = 0;
            let interest5 = 0, interest10 = 0, interest15 = 0;
            let lastPrincipal = 0, lastInterest = 0;

            for (let month = 1; month <= months; month++) {
                const interest = balance * monthlyRate;
                const principal = monthlyPayment - interest;
                balance -= principal;
                totalInterestPaid += interest;

                if (month === 60) { balance5 = balance; interest5 = totalInterestPaid; }
                if (month === 120) { balance10 = balance; interest10 = totalInterestPaid; }
                if (month === 180) { balance15 = balance; interest15 = totalInterestPaid; }
                if (month === 240) balance20 = balance;

                if (month === months) {
                    lastPrincipal = principal;
                    lastInterest = interest;
                }
            }

            // Calculate with extra payments
            let balanceWithExtra = loanAmount;
            let monthsWithExtra = 0;
            let totalInterestWithExtra = 0;

            while (balanceWithExtra > 0 && monthsWithExtra < months * 2) {
                const interest = balanceWithExtra * monthlyRate;
                const principal = Math.min(monthlyPayment + extraPayment - interest, balanceWithExtra);
                balanceWithExtra -= principal;
                totalInterestWithExtra += interest;
                monthsWithExtra++;
            }

            const timeSaved = months - monthsWithExtra;
            const interestSaved = totalInterest - totalInterestWithExtra;

            // Calculate payoff dates
            const [startYear, startMonth] = startDate.split('-').map(Number);
            const payoffMonth = startMonth + months - 1;
            const payoffYear = startYear + Math.floor(payoffMonth / 12);
            const payoffMonthFinal = ((payoffMonth - 1) % 12) + 1;

            const newPayoffMonth = startMonth + monthsWithExtra - 1;
            const newPayoffYear = startYear + Math.floor(newPayoffMonth / 12);
            const newPayoffMonthFinal = ((newPayoffMonth - 1) % 12) + 1;

            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const payoffDateStr = monthNames[payoffMonthFinal - 1] + ' ' + payoffYear;
            const newPayoffDateStr = monthNames[newPayoffMonthFinal - 1] + ' ' + newPayoffYear;

            // Update UI
            document.getElementById('monthlyPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('totalAmount').textContent = formatCurrency(totalPayment, currency);
            document.getElementById('payoffDate').textContent = payoffDateStr;
            document.getElementById('totalPayments').textContent = months;

            document.getElementById('loanAmountDisplay').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('rateDisplay').textContent = (annualRate * 100).toFixed(2) + '% APR';
            document.getElementById('termDisplay').textContent = years + ' years (' + months + ' months)';
            document.getElementById('paymentsDisplay').textContent = months + ' payments';

            document.getElementById('piPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('extraPaymentDisplay').textContent = formatCurrency(extraPayment, currency);
            document.getElementById('totalMonthly').textContent = formatCurrency(monthlyPayment + extraPayment, currency);

            document.getElementById('principalAmount').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('interestPaid').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('interestPercent').textContent = interestPercent.toFixed(1) + '%';
            document.getElementById('totalPaid').textContent = formatCurrency(totalPayment, currency);

            document.getElementById('firstPrincipal').textContent = formatCurrency(firstPrincipal, currency);
            document.getElementById('firstInterest').textContent = formatCurrency(firstInterest, currency);
            document.getElementById('firstPayment').textContent = formatCurrency(monthlyPayment, currency);

            document.getElementById('lastPrincipal').textContent = formatCurrency(lastPrincipal, currency);
            document.getElementById('lastInterest').textContent = formatCurrency(lastInterest, currency);
            document.getElementById('lastPayment').textContent = formatCurrency(monthlyPayment, currency);

            document.getElementById('timeSaved').textContent = timeSaved + ' months (' + (timeSaved / 12).toFixed(1) + ' years)';
            document.getElementById('interestSaved').textContent = formatCurrency(interestSaved, currency);
            document.getElementById('newPayoffDate').textContent = newPayoffDateStr;

            document.getElementById('balance5').textContent = formatCurrency(Math.max(0, balance5), currency);
            document.getElementById('balance10').textContent = formatCurrency(Math.max(0, balance10), currency);
            document.getElementById('balance15').textContent = formatCurrency(Math.max(0, balance15), currency);
            document.getElementById('balance20').textContent = formatCurrency(Math.max(0, balance20), currency);

            document.getElementById('interest5').textContent = formatCurrency(interest5, currency);
            document.getElementById('interest10').textContent = formatCurrency(interest10, currency);
            document.getElementById('interest15').textContent = formatCurrency(interest15, currency);
            document.getElementById('interestTotal').textContent = formatCurrency(totalInterest, currency);
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