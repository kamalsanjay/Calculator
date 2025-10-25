<?php
/**
 * Debt Consolidation Calculator
 * File: debt-consolidation-calculator.php
 * Description: Calculate savings from consolidating multiple debts (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debt Consolidation Calculator - Compare Loan Options (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free debt consolidation calculator. Compare multiple debts vs single consolidation loan. Calculate monthly savings and total interest savings. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>💳 Debt Consolidation Calculator</h1>
        <p>Compare multiple debts vs consolidation loan</p>
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
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Current Debts</h2>
                <form id="debtConsolidationForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                            <option value="EUR">EUR (€)</option>
                            <option value="GBP">GBP (£)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Debt #1 - Credit Card</h3>
                    
                    <div class="form-group">
                        <label for="debt1Balance">Balance (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="debt1Balance" value="8000" min="0" step="100">
                    </div>
                    
                    <div class="form-group">
                        <label for="debt1Rate">Interest Rate (% APR)</label>
                        <input type="number" id="debt1Rate" value="18" min="0" max="50" step="0.1">
                    </div>
                    
                    <div class="form-group">
                        <label for="debt1Payment">Monthly Payment (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="debt1Payment" value="200" min="0" step="10">
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Debt #2 - Personal Loan</h3>
                    
                    <div class="form-group">
                        <label for="debt2Balance">Balance (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="debt2Balance" value="12000" min="0" step="100">
                    </div>
                    
                    <div class="form-group">
                        <label for="debt2Rate">Interest Rate (% APR)</label>
                        <input type="number" id="debt2Rate" value="12" min="0" max="50" step="0.1">
                    </div>
                    
                    <div class="form-group">
                        <label for="debt2Payment">Monthly Payment (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="debt2Payment" value="300" min="0" step="10">
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Debt #3 - Car Loan</h3>
                    
                    <div class="form-group">
                        <label for="debt3Balance">Balance (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="debt3Balance" value="15000" min="0" step="100">
                    </div>
                    
                    <div class="form-group">
                        <label for="debt3Rate">Interest Rate (% APR)</label>
                        <input type="number" id="debt3Rate" value="7" min="0" max="50" step="0.1">
                    </div>
                    
                    <div class="form-group">
                        <label for="debt3Payment">Monthly Payment (<span id="currencyLabel6">$</span>)</label>
                        <input type="number" id="debt3Payment" value="350" min="0" step="10">
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Consolidation Loan</h3>
                    
                    <div class="form-group">
                        <label for="consolidationRate">New Interest Rate (% APR)</label>
                        <input type="number" id="consolidationRate" value="9" min="0" max="30" step="0.1" required>
                        <small>Rate for consolidation loan</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="consolidationTerm">Loan Term (Years)</label>
                        <select id="consolidationTerm">
                            <option value="3">3 years</option>
                            <option value="5" selected>5 years</option>
                            <option value="7">7 years</option>
                            <option value="10">10 years</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Savings</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Consolidation Analysis</h2>
                
                <div class="result-card success">
                    <h3>Total Monthly Savings</h3>
                    <div class="amount" id="monthlySavings">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Current Payment</h4>
                        <div class="value" id="currentPayment">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>New Payment</h4>
                        <div class="value" id="newPayment">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Interest Savings</h4>
                        <div class="value" id="interestSavings">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Time to Payoff</h4>
                        <div class="value" id="payoffTime">0 yrs</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Current Debts Summary</h3>
                    <div class="breakdown-item">
                        <span>Debt #1 Balance</span>
                        <strong id="debt1BalanceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Debt #2 Balance</span>
                        <strong id="debt2BalanceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Debt #3 Balance</span>
                        <strong id="debt3BalanceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Debt</strong></span>
                        <strong id="totalDebt" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Current Monthly Payments</h3>
                    <div class="breakdown-item">
                        <span>Debt #1 Payment</span>
                        <strong id="debt1PaymentDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Debt #2 Payment</span>
                        <strong id="debt2PaymentDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Debt #3 Payment</span>
                        <strong id="debt3PaymentDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Monthly Payment</strong></span>
                        <strong id="totalMonthlyPayment" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Current Interest Rates</h3>
                    <div class="breakdown-item">
                        <span>Debt #1 Rate</span>
                        <strong id="debt1RateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Debt #2 Rate</span>
                        <strong id="debt2RateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Debt #3 Rate</span>
                        <strong id="debt3RateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weighted Average Rate</span>
                        <strong id="avgRate" style="color: #667eea;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Consolidation Loan Details</h3>
                    <div class="breakdown-item">
                        <span>Total Amount to Consolidate</span>
                        <strong id="consolidationAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>New Interest Rate</span>
                        <strong id="newRate" style="color: #4CAF50;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Term</span>
                        <strong id="loanTerm">0 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>New Monthly Payment</span>
                        <strong id="consolidatedPayment" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Comparison: Current vs Consolidated</h3>
                    <div class="breakdown-item">
                        <span>Current Monthly Payment</span>
                        <strong id="currentMonthly">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>New Monthly Payment</span>
                        <strong id="newMonthly" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Monthly Savings</strong></span>
                        <strong id="savingsAmount" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Savings %</span>
                        <strong id="savingsPercent" style="color: #4CAF50;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Interest Comparison</h3>
                    <div class="breakdown-item">
                        <span>Current Total Interest (Estimated)</span>
                        <strong id="currentInterest" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Consolidated Total Interest</span>
                        <strong id="consolidatedInterest" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Interest Savings</strong></span>
                        <strong id="totalInterestSavings" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Payoff Timeline</h3>
                    <div class="breakdown-item">
                        <span>Current Estimated Payoff</span>
                        <strong id="currentPayoff">0 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Consolidated Payoff</span>
                        <strong id="consolidatedPayoff" style="color: #667eea;">5 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Time Difference</span>
                        <strong id="timeDifference">0 years</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Annual Savings</h3>
                    <div class="breakdown-item">
                        <span>Monthly Savings</span>
                        <strong id="monthlySavingsDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Savings (12 months)</span>
                        <strong id="annualSavings" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>5-Year Savings</span>
                        <strong id="fiveYearSavings" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Debt Consolidation Tips:</strong> Lower rate = better deal. Watch for origination fees. Don't close old accounts (hurts credit score). Avoid new debt after consolidating. Consider balance transfer cards (0% intro APR). Compare multiple lenders. Calculate break-even point. Automate payments. Build emergency fund to avoid new debt.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('debtConsolidationForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateConsolidation();
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
            for (let i = 1; i <= 6; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateConsolidation();
        });

        function calculateConsolidation() {
            const debt1Balance = parseFloat(document.getElementById('debt1Balance').value) || 0;
            const debt1Rate = parseFloat(document.getElementById('debt1Rate').value) / 100 || 0;
            const debt1Payment = parseFloat(document.getElementById('debt1Payment').value) || 0;
            
            const debt2Balance = parseFloat(document.getElementById('debt2Balance').value) || 0;
            const debt2Rate = parseFloat(document.getElementById('debt2Rate').value) / 100 || 0;
            const debt2Payment = parseFloat(document.getElementById('debt2Payment').value) || 0;
            
            const debt3Balance = parseFloat(document.getElementById('debt3Balance').value) || 0;
            const debt3Rate = parseFloat(document.getElementById('debt3Rate').value) / 100 || 0;
            const debt3Payment = parseFloat(document.getElementById('debt3Payment').value) || 0;
            
            const consolidationRate = parseFloat(document.getElementById('consolidationRate').value) / 100 || 0;
            const consolidationYears = parseInt(document.getElementById('consolidationTerm').value) || 5;
            const currency = currencySelect.value;

            // Calculate totals
            const totalDebt = debt1Balance + debt2Balance + debt3Balance;
            const totalMonthlyPayment = debt1Payment + debt2Payment + debt3Payment;

            // Weighted average rate
            const weightedRate = totalDebt > 0 ? 
                ((debt1Balance * debt1Rate) + (debt2Balance * debt2Rate) + (debt3Balance * debt3Rate)) / totalDebt : 0;

            // Consolidation loan calculation
            const months = consolidationYears * 12;
            const monthlyRate = consolidationRate / 12;
            let newPayment = 0;
            
            if (monthlyRate > 0) {
                newPayment = (totalDebt * monthlyRate * Math.pow(1 + monthlyRate, months)) /
                           (Math.pow(1 + monthlyRate, months) - 1);
            } else {
                newPayment = totalDebt / months;
            }

            // Savings
            const monthlySavings = totalMonthlyPayment - newPayment;
            const annualSavings = monthlySavings * 12;
            const fiveYearSavings = monthlySavings * 60;
            const savingsPercent = totalMonthlyPayment > 0 ? (monthlySavings / totalMonthlyPayment) * 100 : 0;

            // Total interest calculations (simplified estimates)
            const consolidatedTotalPayment = newPayment * months;
            const consolidatedInterest = consolidatedTotalPayment - totalDebt;

            // Estimate current interest (rough calculation)
            function estimatePayoffMonths(balance, payment, rate) {
                if (payment <= balance * rate / 12) return 999; // Can't pay off
                const monthlyRate = rate / 12;
                return Math.log(payment / (payment - balance * monthlyRate)) / Math.log(1 + monthlyRate);
            }

            const months1 = estimatePayoffMonths(debt1Balance, debt1Payment, debt1Rate);
            const months2 = estimatePayoffMonths(debt2Balance, debt2Payment, debt2Rate);
            const months3 = estimatePayoffMonths(debt3Balance, debt3Payment, debt3Rate);

            const currentInterest1 = (debt1Payment * months1) - debt1Balance;
            const currentInterest2 = (debt2Payment * months2) - debt2Balance;
            const currentInterest3 = (debt3Payment * months3) - debt3Balance;
            const currentTotalInterest = currentInterest1 + currentInterest2 + currentInterest3;

            const interestSavings = currentTotalInterest - consolidatedInterest;

            // Payoff time
            const avgCurrentPayoff = (months1 + months2 + months3) / 3 / 12;
            const consolidatedPayoff = consolidationYears;
            const timeDiff = avgCurrentPayoff - consolidatedPayoff;

            // Update UI
            document.getElementById('monthlySavings').textContent = formatCurrency(monthlySavings, currency);
            document.getElementById('currentPayment').textContent = formatCurrency(totalMonthlyPayment, currency);
            document.getElementById('newPayment').textContent = formatCurrency(newPayment, currency);
            document.getElementById('interestSavings').textContent = formatCurrency(interestSavings, currency);
            document.getElementById('payoffTime').textContent = consolidationYears + ' yrs';

            document.getElementById('debt1BalanceDisplay').textContent = formatCurrency(debt1Balance, currency);
            document.getElementById('debt2BalanceDisplay').textContent = formatCurrency(debt2Balance, currency);
            document.getElementById('debt3BalanceDisplay').textContent = formatCurrency(debt3Balance, currency);
            document.getElementById('totalDebt').textContent = formatCurrency(totalDebt, currency);

            document.getElementById('debt1PaymentDisplay').textContent = formatCurrency(debt1Payment, currency);
            document.getElementById('debt2PaymentDisplay').textContent = formatCurrency(debt2Payment, currency);
            document.getElementById('debt3PaymentDisplay').textContent = formatCurrency(debt3Payment, currency);
            document.getElementById('totalMonthlyPayment').textContent = formatCurrency(totalMonthlyPayment, currency);

            document.getElementById('debt1RateDisplay').textContent = (debt1Rate * 100).toFixed(2) + '%';
            document.getElementById('debt2RateDisplay').textContent = (debt2Rate * 100).toFixed(2) + '%';
            document.getElementById('debt3RateDisplay').textContent = (debt3Rate * 100).toFixed(2) + '%';
            document.getElementById('avgRate').textContent = (weightedRate * 100).toFixed(2) + '%';

            document.getElementById('consolidationAmount').textContent = formatCurrency(totalDebt, currency);
            document.getElementById('newRate').textContent = (consolidationRate * 100).toFixed(2) + '%';
            document.getElementById('loanTerm').textContent = consolidationYears + ' years (' + months + ' months)';
            document.getElementById('consolidatedPayment').textContent = formatCurrency(newPayment, currency);

            document.getElementById('currentMonthly').textContent = formatCurrency(totalMonthlyPayment, currency);
            document.getElementById('newMonthly').textContent = formatCurrency(newPayment, currency);
            document.getElementById('savingsAmount').textContent = formatCurrency(monthlySavings, currency);
            document.getElementById('savingsPercent').textContent = savingsPercent.toFixed(1) + '%';

            document.getElementById('currentInterest').textContent = formatCurrency(currentTotalInterest, currency);
            document.getElementById('consolidatedInterest').textContent = formatCurrency(consolidatedInterest, currency);
            document.getElementById('totalInterestSavings').textContent = formatCurrency(Math.max(0, interestSavings), currency);

            document.getElementById('currentPayoff').textContent = avgCurrentPayoff.toFixed(1) + ' years';
            document.getElementById('consolidatedPayoff').textContent = consolidatedPayoff + ' years';
            document.getElementById('timeDifference').textContent = Math.abs(timeDiff).toFixed(1) + ' years ' + (timeDiff > 0 ? 'faster' : 'longer');

            document.getElementById('monthlySavingsDisplay').textContent = formatCurrency(monthlySavings, currency);
            document.getElementById('annualSavings').textContent = formatCurrency(annualSavings, currency);
            document.getElementById('fiveYearSavings').textContent = formatCurrency(fiveYearSavings, currency);
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
            calculateConsolidation();
        });
    </script>
</body>
</html>