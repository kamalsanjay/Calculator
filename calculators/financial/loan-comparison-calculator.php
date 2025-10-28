<?php
/**
 * Loan Comparison Calculator
 * File: loan-comparison-calculator.php
 * Description: Compare two loans side-by-side (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Comparison Calculator - Compare Two Loans (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free loan comparison calculator. Compare two loans side-by-side with monthly payments, total interest, and savings. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128202; Loan Comparison Calculator</h1>
        <p>Compare two loans side-by-side</p>
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
                <h2>Loan Comparison</h2>
                <form id="comparisonForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD (&#36;)</option>
                            <option value="INR">INR (&#8377;)</option>
                            <option value="EUR">EUR (&#8364;)</option>
                            <option value="GBP">GBP (&#163;)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Loan A</h3>
                    
                    <div class="form-group">
                        <label for="loanAmountA">Loan Amount (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="loanAmountA" value="200000" min="1000" step="1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRateA">Interest Rate (% APR)</label>
                        <input type="number" id="interestRateA" value="6.5" min="0" max="30" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTermA">Loan Term (Years)</label>
                        <input type="number" id="loanTermA" value="30" min="1" max="50" step="1" required>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Loan B</h3>
                    
                    <div class="form-group">
                        <label for="loanAmountB">Loan Amount (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="loanAmountB" value="200000" min="1000" step="1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRateB">Interest Rate (% APR)</label>
                        <input type="number" id="interestRateB" value="5.5" min="0" max="30" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTermB">Loan Term (Years)</label>
                        <input type="number" id="loanTermB" value="15" min="1" max="50" step="1" required>
                    </div>
                    
                    <button type="submit" class="btn">Compare Loans</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Comparison Results</h2>
                
                <div class="result-card info">
                    <h3>Best Option</h3>
                    <div class="amount" id="bestOption">Loan B</div>
                    <small id="bestReason">Saves $X in total interest</small>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Interest Difference</h4>
                        <div class="value" id="interestDiff">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Monthly Payment Difference</h4>
                        <div class="value" id="paymentDiff">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost Difference</h4>
                        <div class="value" id="totalDiff">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Time Difference</h4>
                        <div class="value" id="timeDiff">15 years</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Loan A Summary</h3>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="amountA">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="rateA">6.5% APR</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Term</span>
                        <strong id="termA">30 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="paymentA" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest</span>
                        <strong id="interestA" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Amount Paid</span>
                        <strong id="totalA" style="color: #667eea;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Loan B Summary</h3>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="amountB">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="rateB">5.5% APR</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Term</span>
                        <strong id="termB">15 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="paymentB" style="color: #FF9800; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest</span>
                        <strong id="interestB" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Amount Paid</span>
                        <strong id="totalB" style="color: #FF9800;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Side-by-Side Comparison</h3>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="paymentCompare">A: $0 vs B: $0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest</span>
                        <strong id="interestCompare">A: $0 vs B: $0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Amount Paid</span>
                        <strong id="totalCompare">A: $0 vs B: $0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Term</span>
                        <strong id="termCompare">A: 30 years vs B: 15 years</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Savings with Better Option</h3>
                    <div class="breakdown-item">
                        <span>Interest Savings</span>
                        <strong id="interestSavings" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Cost Savings</span>
                        <strong id="totalSavings" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Time Saved</span>
                        <strong id="timeSaved" style="color: #4CAF50;">0 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Payment Difference</span>
                        <strong id="monthlyDiff">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Interest Paid Over Time</h3>
                    <div class="breakdown-item">
                        <span>Loan A - First 5 Years</span>
                        <strong id="interest5A" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan B - First 5 Years</span>
                        <strong id="interest5B" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Difference (5 Years)</span>
                        <strong id="interest5Diff">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Which Loan is Better?</h3>
                    <div id="recommendation" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="recommendationText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Comparison Tips:</strong> Lower monthly payment ≠ better deal. Total interest matters most. Shorter terms = higher payments but less interest. Consider your budget and goals. Lower rate + longer term may cost more total. Factor in opportunity cost. Can you afford higher payments? Extra payments reduce both options. Pre-payment penalties? Check total cost over loan life. Balance monthly budget vs long-term savings.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('comparisonForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            compareLoans();
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
            compareLoans();
        });

        function calculateLoan(principal, annualRate, years) {
            const monthlyRate = annualRate / 12;
            const months = years * 12;
            
            let monthlyPayment = 0;
            if (monthlyRate > 0) {
                monthlyPayment = (principal * monthlyRate * Math.pow(1 + monthlyRate, months)) /
                               (Math.pow(1 + monthlyRate, months) - 1);
            } else {
                monthlyPayment = principal / months;
            }
            
            const totalPayment = monthlyPayment * months;
            const totalInterest = totalPayment - principal;
            
            // Calculate interest for first 5 years
            let balance = principal;
            let interest5Years = 0;
            const months5 = Math.min(60, months);
            
            for (let month = 1; month <= months5; month++) {
                const interest = balance * monthlyRate;
                const principalPmt = monthlyPayment - interest;
                balance -= principalPmt;
                interest5Years += interest;
            }
            
            return {
                monthlyPayment,
                totalInterest,
                totalPayment,
                months,
                interest5Years
            };
        }

        function compareLoans() {
            const loanAmountA = parseFloat(document.getElementById('loanAmountA').value) || 0;
            const interestRateA = parseFloat(document.getElementById('interestRateA').value) / 100 || 0;
            const loanTermA = parseInt(document.getElementById('loanTermA').value) || 30;
            
            const loanAmountB = parseFloat(document.getElementById('loanAmountB').value) || 0;
            const interestRateB = parseFloat(document.getElementById('interestRateB').value) / 100 || 0;
            const loanTermB = parseInt(document.getElementById('loanTermB').value) || 15;
            
            const currency = currencySelect.value;

            const loanA = calculateLoan(loanAmountA, interestRateA, loanTermA);
            const loanB = calculateLoan(loanAmountB, interestRateB, loanTermB);

            // Comparisons
            const interestDiff = Math.abs(loanA.totalInterest - loanB.totalInterest);
            const paymentDiff = Math.abs(loanA.monthlyPayment - loanB.monthlyPayment);
            const totalDiff = Math.abs(loanA.totalPayment - loanB.totalPayment);
            const timeDiff = Math.abs(loanTermA - loanTermB);

            // Determine better option
            let bestOption = 'Loan A';
            let bestReason = '';
            let interestSavings = 0;
            let totalSavings = 0;
            
            if (loanA.totalInterest < loanB.totalInterest) {
                bestOption = 'Loan A';
                interestSavings = loanB.totalInterest - loanA.totalInterest;
                totalSavings = loanB.totalPayment - loanA.totalPayment;
                bestReason = `Saves ${formatCurrency(interestSavings, currency)} in total interest`;
            } else if (loanB.totalInterest < loanA.totalInterest) {
                bestOption = 'Loan B';
                interestSavings = loanA.totalInterest - loanB.totalInterest;
                totalSavings = loanA.totalPayment - loanB.totalPayment;
                bestReason = `Saves ${formatCurrency(interestSavings, currency)} in total interest`;
            } else {
                bestOption = 'Equal';
                bestReason = 'Both loans have similar costs';
            }

            // Recommendation
            let recommendation = '';
            if (bestOption === 'Loan A') {
                recommendation = `Loan A is the better option. It will save you ${formatCurrency(interestSavings, currency)} in interest over the life of the loan. `;
                if (loanA.monthlyPayment < loanB.monthlyPayment) {
                    recommendation += `Additionally, Loan A has a lower monthly payment of ${formatCurrency(loanA.monthlyPayment, currency)} compared to ${formatCurrency(loanB.monthlyPayment, currency)}.`;
                } else {
                    recommendation += `However, Loan A requires a higher monthly payment of ${formatCurrency(loanA.monthlyPayment, currency)} compared to ${formatCurrency(loanB.monthlyPayment, currency)}.`;
                }
            } else if (bestOption === 'Loan B') {
                recommendation = `Loan B is the better option. It will save you ${formatCurrency(interestSavings, currency)} in interest over the life of the loan. `;
                if (loanB.monthlyPayment < loanA.monthlyPayment) {
                    recommendation += `Additionally, Loan B has a lower monthly payment of ${formatCurrency(loanB.monthlyPayment, currency)} compared to ${formatCurrency(loanA.monthlyPayment, currency)}.`;
                } else {
                    recommendation += `However, Loan B requires a higher monthly payment of ${formatCurrency(loanB.monthlyPayment, currency)} compared to ${formatCurrency(loanA.monthlyPayment, currency)}.`;
                }
            } else {
                recommendation = 'Both loans are similar in total cost. Choose based on your monthly budget preference.';
            }

            const interest5Diff = Math.abs(loanA.interest5Years - loanB.interest5Years);

            // Update UI
            document.getElementById('bestOption').textContent = bestOption;
            document.getElementById('bestReason').textContent = bestReason;
            
            document.getElementById('interestDiff').textContent = formatCurrency(interestDiff, currency);
            document.getElementById('paymentDiff').textContent = formatCurrency(paymentDiff, currency);
            document.getElementById('totalDiff').textContent = formatCurrency(totalDiff, currency);
            document.getElementById('timeDiff').textContent = timeDiff + ' years';

            document.getElementById('amountA').textContent = formatCurrency(loanAmountA, currency);
            document.getElementById('rateA').textContent = (interestRateA * 100).toFixed(2) + '% APR';
            document.getElementById('termA').textContent = loanTermA + ' years (' + loanA.months + ' months)';
            document.getElementById('paymentA').textContent = formatCurrency(loanA.monthlyPayment, currency);
            document.getElementById('interestA').textContent = formatCurrency(loanA.totalInterest, currency);
            document.getElementById('totalA').textContent = formatCurrency(loanA.totalPayment, currency);

            document.getElementById('amountB').textContent = formatCurrency(loanAmountB, currency);
            document.getElementById('rateB').textContent = (interestRateB * 100).toFixed(2) + '% APR';
            document.getElementById('termB').textContent = loanTermB + ' years (' + loanB.months + ' months)';
            document.getElementById('paymentB').textContent = formatCurrency(loanB.monthlyPayment, currency);
            document.getElementById('interestB').textContent = formatCurrency(loanB.totalInterest, currency);
            document.getElementById('totalB').textContent = formatCurrency(loanB.totalPayment, currency);

            document.getElementById('paymentCompare').textContent = `A: ${formatCurrency(loanA.monthlyPayment, currency)} vs B: ${formatCurrency(loanB.monthlyPayment, currency)}`;
            document.getElementById('interestCompare').textContent = `A: ${formatCurrency(loanA.totalInterest, currency)} vs B: ${formatCurrency(loanB.totalInterest, currency)}`;
            document.getElementById('totalCompare').textContent = `A: ${formatCurrency(loanA.totalPayment, currency)} vs B: ${formatCurrency(loanB.totalPayment, currency)}`;
            document.getElementById('termCompare').textContent = `A: ${loanTermA} years vs B: ${loanTermB} years`;

            document.getElementById('interestSavings').textContent = formatCurrency(interestSavings, currency);
            document.getElementById('totalSavings').textContent = formatCurrency(totalSavings, currency);
            document.getElementById('timeSaved').textContent = timeDiff + ' years';
            document.getElementById('monthlyDiff').textContent = formatCurrency(paymentDiff, currency);

            document.getElementById('interest5A').textContent = formatCurrency(loanA.interest5Years, currency);
            document.getElementById('interest5B').textContent = formatCurrency(loanB.interest5Years, currency);
            document.getElementById('interest5Diff').textContent = formatCurrency(interest5Diff, currency);

            document.getElementById('recommendationText').textContent = recommendation;
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
            compareLoans();
        });
    </script>
</body>
</html>