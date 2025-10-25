<?php
/**
 * Home Equity Calculator
 * File: home-equity-calculator.php
 * Description: Calculate home equity and loan options (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Equity Calculator - Calculate Your Home Equity (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free home equity calculator. Calculate available equity, loan-to-value ratio, and borrowing capacity. Compare HELOC vs home equity loan. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🏠 Home Equity Calculator</h1>
        <p>Calculate your home equity and borrowing power</p>
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
                <h2>Home & Loan Details</h2>
                <form id="equityForm">
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
                        <label for="homeValue">Current Home Value (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="homeValue" value="400000" min="10000" step="1000" required>
                        <small>Current market value</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="mortgageBalance">Mortgage Balance Owed (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="mortgageBalance" value="250000" min="0" step="1000" required>
                        <small>Remaining principal balance</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="secondMortgage">Second Mortgage / HELOC Balance (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="secondMortgage" value="0" min="0" step="1000">
                        <small>Additional loans against home</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="originalPrice">Original Purchase Price (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="originalPrice" value="300000" min="0" step="1000">
                        <small>What you paid for the home</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="purchaseYear">Purchase Year</label>
                        <input type="number" id="purchaseYear" value="2018" min="1950" max="2025" step="1">
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Home Equity Loan Options</h3>
                    
                    <div class="form-group">
                        <label for="maxLTV">Maximum LTV for Borrowing (%)</label>
                        <input type="number" id="maxLTV" value="80" min="50" max="95" step="1">
                        <small>Typical: 80-85%</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="equityLoanRate">Home Equity Loan Rate (% APR)</label>
                        <input type="number" id="equityLoanRate" value="7.5" min="0" max="20" step="0.1">
                    </div>
                    
                    <div class="form-group">
                        <label for="equityLoanTerm">Loan Term (Years)</label>
                        <select id="equityLoanTerm">
                            <option value="5">5 years</option>
                            <option value="10">10 years</option>
                            <option value="15" selected>15 years</option>
                            <option value="20">20 years</option>
                            <option value="30">30 years</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Equity</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Home Equity Summary</h2>
                
                <div class="result-card success">
                    <h3>Available Home Equity</h3>
                    <div class="amount" id="availableEquity">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Current LTV</h4>
                        <div class="value" id="currentLTV">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Equity %</h4>
                        <div class="value" id="equityPercent">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Can Borrow</h4>
                        <div class="value" id="canBorrow">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Home Appreciation</h4>
                        <div class="value" id="appreciation">0%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Home Value & Debt</h3>
                    <div class="breakdown-item">
                        <span>Current Home Value</span>
                        <strong id="homeValueDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>First Mortgage Balance</span>
                        <strong id="mortgageDisplay" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Second Mortgage / HELOC</span>
                        <strong id="secondDisplay" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Debt</strong></span>
                        <strong id="totalDebt" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Available Home Equity</strong></span>
                        <strong id="equityAmount" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Loan-to-Value Analysis</h3>
                    <div class="breakdown-item">
                        <span>Home Value</span>
                        <strong id="ltvHomeValue">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Loans Against Home</span>
                        <strong id="totalLoans">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current LTV Ratio</span>
                        <strong id="ltvRatio" style="color: #667eea; font-size: 1.1em;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Equity Percentage</span>
                        <strong id="equityPercentDisplay" style="color: #4CAF50;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>LTV Status</span>
                        <strong id="ltvStatus">Good</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Borrowing Capacity</h3>
                    <div class="breakdown-item">
                        <span>Maximum LTV for Borrowing</span>
                        <strong id="maxLTVDisplay">80%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Maximum Loan Amount (at <span id="maxLTVLabel">80</span>% LTV)</span>
                        <strong id="maxLoanAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Less: Current Debt</span>
                        <strong id="currentDebt" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Available to Borrow</strong></span>
                        <strong id="availableBorrow" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Home Equity Loan Payment</h3>
                    <div class="breakdown-item">
                        <span>Loan Amount (Max Available)</span>
                        <strong id="loanAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="rateDisplay">0% APR</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Term</span>
                        <strong id="termDisplay">15 years</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Monthly Payment</strong></span>
                        <strong id="monthlyPayment" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Home Appreciation Analysis</h3>
                    <div class="breakdown-item">
                        <span>Original Purchase Price</span>
                        <strong id="originalPriceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Home Value</span>
                        <strong id="currentValueDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Appreciation</span>
                        <strong id="totalAppreciation" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Appreciation %</span>
                        <strong id="appreciationPercent" style="color: #667eea;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Years Owned</span>
                        <strong id="yearsOwned">0 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Appreciation Rate</span>
                        <strong id="annualRate">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Loan Cost Over Time</h3>
                    <div class="breakdown-item">
                        <span>Total Payments</span>
                        <strong id="totalPayments">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest</span>
                        <strong id="totalInterest" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest as % of Loan</span>
                        <strong id="interestPercent">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Borrowing Scenarios</h3>
                    <div class="breakdown-item">
                        <span>Borrow 25% of Available</span>
                        <strong id="borrow25">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Borrow 50% of Available</span>
                        <strong id="borrow50">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Borrow 75% of Available</span>
                        <strong id="borrow75">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Borrow 100% (Maximum)</span>
                        <strong id="borrow100" style="color: #667eea;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Home Equity Tips:</strong> Equity = Home Value - Debt. LTV = Debt ÷ Home Value. Lower LTV = better rates. 80% LTV is typical max. HELOC = line of credit (variable rate). Home Equity Loan = fixed rate, lump sum. Use equity wisely (renovations, debt consolidation). Not for frivolous spending. Refi if rates dropped. Keep 20% equity cushion.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('equityForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateEquity();
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
            calculateEquity();
        });

        function calculateEquity() {
            const homeValue = parseFloat(document.getElementById('homeValue').value) || 0;
            const mortgageBalance = parseFloat(document.getElementById('mortgageBalance').value) || 0;
            const secondMortgage = parseFloat(document.getElementById('secondMortgage').value) || 0;
            const originalPrice = parseFloat(document.getElementById('originalPrice').value) || 0;
            const purchaseYear = parseInt(document.getElementById('purchaseYear').value) || 2018;
            const maxLTV = parseFloat(document.getElementById('maxLTV').value) / 100 || 0.80;
            const equityLoanRate = parseFloat(document.getElementById('equityLoanRate').value) / 100 || 0.075;
            const years = parseInt(document.getElementById('equityLoanTerm').value) || 15;
            const currency = currencySelect.value;

            // Calculate total debt
            const totalDebt = mortgageBalance + secondMortgage;
            
            // Calculate available equity
            const availableEquity = homeValue - totalDebt;
            
            // Calculate LTV
            const currentLTV = homeValue > 0 ? (totalDebt / homeValue) * 100 : 0;
            const equityPercent = 100 - currentLTV;
            
            // LTV Status
            let ltvStatus = '';
            if (currentLTV <= 50) {
                ltvStatus = 'Excellent ✅ (>50% equity)';
            } else if (currentLTV <= 70) {
                ltvStatus = 'Very Good 👍 (30-50% equity)';
            } else if (currentLTV <= 80) {
                ltvStatus = 'Good 🙂 (20-30% equity)';
            } else if (currentLTV <= 90) {
                ltvStatus = 'Fair ⚠️ (<20% equity)';
            } else {
                ltvStatus = 'High Risk ❌ (<10% equity)';
            }
            
            // Calculate borrowing capacity
            const maxLoanAmount = homeValue * maxLTV;
            const availableToBorrow = Math.max(0, maxLoanAmount - totalDebt);
            
            // Calculate monthly payment on max available
            const monthlyRate = equityLoanRate / 12;
            const months = years * 12;
            let monthlyPayment = 0;
            
            if (availableToBorrow > 0) {
                if (monthlyRate > 0) {
                    monthlyPayment = (availableToBorrow * monthlyRate * Math.pow(1 + monthlyRate, months)) /
                                   (Math.pow(1 + monthlyRate, months) - 1);
                } else {
                    monthlyPayment = availableToBorrow / months;
                }
            }
            
            // Total cost
            const totalPayments = monthlyPayment * months;
            const totalInterest = totalPayments - availableToBorrow;
            const interestPercent = availableToBorrow > 0 ? (totalInterest / availableToBorrow) * 100 : 0;
            
            // Home appreciation
            const currentYear = new Date().getFullYear();
            const yearsOwned = currentYear - purchaseYear;
            const totalAppreciation = homeValue - originalPrice;
            const appreciationPercent = originalPrice > 0 ? (totalAppreciation / originalPrice) * 100 : 0;
            const annualRate = yearsOwned > 0 ? appreciationPercent / yearsOwned : 0;
            
            // Borrowing scenarios
            const borrow25 = availableToBorrow * 0.25;
            const borrow50 = availableToBorrow * 0.50;
            const borrow75 = availableToBorrow * 0.75;
            const borrow100 = availableToBorrow;

            // Update UI
            document.getElementById('availableEquity').textContent = formatCurrency(availableEquity, currency);
            document.getElementById('currentLTV').textContent = currentLTV.toFixed(1) + '%';
            document.getElementById('equityPercent').textContent = equityPercent.toFixed(1) + '%';
            document.getElementById('canBorrow').textContent = formatCurrency(availableToBorrow, currency);
            document.getElementById('appreciation').textContent = appreciationPercent.toFixed(1) + '%';

            document.getElementById('homeValueDisplay').textContent = formatCurrency(homeValue, currency);
            document.getElementById('mortgageDisplay').textContent = formatCurrency(mortgageBalance, currency);
            document.getElementById('secondDisplay').textContent = formatCurrency(secondMortgage, currency);
            document.getElementById('totalDebt').textContent = formatCurrency(totalDebt, currency);
            document.getElementById('equityAmount').textContent = formatCurrency(availableEquity, currency);

            document.getElementById('ltvHomeValue').textContent = formatCurrency(homeValue, currency);
            document.getElementById('totalLoans').textContent = formatCurrency(totalDebt, currency);
            document.getElementById('ltvRatio').textContent = currentLTV.toFixed(1) + '%';
            document.getElementById('equityPercentDisplay').textContent = equityPercent.toFixed(1) + '%';
            document.getElementById('ltvStatus').textContent = ltvStatus;

            document.getElementById('maxLTVDisplay').textContent = (maxLTV * 100).toFixed(0) + '%';
            document.getElementById('maxLTVLabel').textContent = (maxLTV * 100).toFixed(0);
            document.getElementById('maxLoanAmount').textContent = formatCurrency(maxLoanAmount, currency);
            document.getElementById('currentDebt').textContent = formatCurrency(totalDebt, currency);
            document.getElementById('availableBorrow').textContent = formatCurrency(availableToBorrow, currency);

            document.getElementById('loanAmount').textContent = formatCurrency(availableToBorrow, currency);
            document.getElementById('rateDisplay').textContent = (equityLoanRate * 100).toFixed(2) + '% APR';
            document.getElementById('termDisplay').textContent = years + ' years (' + months + ' payments)';
            document.getElementById('monthlyPayment').textContent = formatCurrency(monthlyPayment, currency);

            document.getElementById('originalPriceDisplay').textContent = formatCurrency(originalPrice, currency);
            document.getElementById('currentValueDisplay').textContent = formatCurrency(homeValue, currency);
            document.getElementById('totalAppreciation').textContent = formatCurrency(totalAppreciation, currency);
            document.getElementById('appreciationPercent').textContent = appreciationPercent.toFixed(1) + '%';
            document.getElementById('yearsOwned').textContent = yearsOwned + ' years';
            document.getElementById('annualRate').textContent = annualRate.toFixed(2) + '% per year';

            document.getElementById('totalPayments').textContent = formatCurrency(totalPayments, currency);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('interestPercent').textContent = interestPercent.toFixed(1) + '%';

            document.getElementById('borrow25').textContent = formatCurrency(borrow25, currency);
            document.getElementById('borrow50').textContent = formatCurrency(borrow50, currency);
            document.getElementById('borrow75').textContent = formatCurrency(borrow75, currency);
            document.getElementById('borrow100').textContent = formatCurrency(borrow100, currency);
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
            calculateEquity();
        });
    </script>
</body>
</html>