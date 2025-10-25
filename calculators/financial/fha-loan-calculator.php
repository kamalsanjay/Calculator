<?php
/**
 * FHA Loan Calculator
 * File: fha-loan-calculator.php
 * Description: Calculate FHA loan payments with mortgage insurance (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FHA Loan Calculator - Calculate FHA Mortgage Payment (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free FHA loan calculator. Calculate monthly mortgage payments with FHA mortgage insurance premiums. Low down payment options. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🏠 FHA Loan Calculator</h1>
        <p>Calculate FHA mortgage with insurance premiums</p>
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
                <h2>FHA Loan Details</h2>
                <form id="fhaLoanForm">
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
                        <label for="homePrice">Home Price (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="homePrice" value="300000" min="50000" step="1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="downPaymentPercent">Down Payment (%)</label>
                        <input type="number" id="downPaymentPercent" value="3.5" min="3.5" max="100" step="0.1" required>
                        <small>FHA minimum: 3.5%</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="downPaymentAmount">Down Payment Amount (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="downPaymentAmount" value="10500" min="0" step="100" readonly>
                        <small>Calculated automatically</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% APR)</label>
                        <input type="number" id="interestRate" value="6.5" min="0" max="20" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Years)</label>
                        <select id="loanTerm">
                            <option value="15">15 years</option>
                            <option value="20">20 years</option>
                            <option value="25">25 years</option>
                            <option value="30" selected>30 years</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="propertyTax">Annual Property Tax (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="propertyTax" value="3000" min="0" step="100">
                    </div>
                    
                    <div class="form-group">
                        <label for="homeInsurance">Annual Home Insurance (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="homeInsurance" value="1200" min="0" step="50">
                    </div>
                    
                    <div class="form-group">
                        <label for="hoaFees">Monthly HOA Fees (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="hoaFees" value="0" min="0" step="10">
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">FHA Mortgage Insurance</h3>
                    
                    <div class="form-group">
                        <label for="upfrontMIP">Upfront MIP (%)</label>
                        <input type="number" id="upfrontMIP" value="1.75" min="0" max="3" step="0.01" required>
                        <small>Standard FHA upfront: 1.75%</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="annualMIP">Annual MIP (%)</label>
                        <input type="number" id="annualMIP" value="0.85" min="0" max="2" step="0.01" required>
                        <small>Typical range: 0.45% - 1.05%</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate FHA Payment</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Monthly Payment Breakdown</h2>
                
                <div class="result-card">
                    <h3>Total Monthly Payment</h3>
                    <div class="amount" id="totalMonthlyPayment">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Principal & Interest</h4>
                        <div class="value" id="principalInterest">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Mortgage Insurance</h4>
                        <div class="value" id="mortgageInsurance">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Property Tax</h4>
                        <div class="value" id="propertyTaxMonthly">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Home Insurance</h4>
                        <div class="value" id="homeInsuranceMonthly">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Loan Summary</h3>
                    <div class="breakdown-item">
                        <span>Home Price</span>
                        <strong id="homePriceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment (<span id="downPercent">3.5</span>%)</span>
                        <strong id="downPaymentDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Base Loan Amount</span>
                        <strong id="baseLoanAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Upfront MIP (Financed)</span>
                        <strong id="upfrontMIPAmount" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Loan Amount</strong></span>
                        <strong id="totalLoanAmount" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Monthly Payment Components</h3>
                    <div class="breakdown-item">
                        <span>Principal & Interest</span>
                        <strong id="piDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly MIP</span>
                        <strong id="monthlyMIPDisplay" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Property Tax</span>
                        <strong id="taxDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Home Insurance</span>
                        <strong id="insuranceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>HOA Fees</span>
                        <strong id="hoaDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Monthly Payment</strong></span>
                        <strong id="totalPayment" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>FHA Mortgage Insurance Details</h3>
                    <div class="breakdown-item">
                        <span>Upfront MIP Rate</span>
                        <strong id="upfrontRate">1.75%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Upfront MIP Amount</span>
                        <strong id="upfrontAmount" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual MIP Rate</span>
                        <strong id="annualRate">0.85%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly MIP Payment</span>
                        <strong id="monthlyMIP" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual MIP Payment</span>
                        <strong id="annualMIPPayment">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Loan Terms</h3>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="rateDisplay">0% APR</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Term</span>
                        <strong id="termDisplay">30 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Payments</span>
                        <strong id="totalPayments">360</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Cost Over Life of Loan</h3>
                    <div class="breakdown-item">
                        <span>Total Principal & Interest</span>
                        <strong id="totalPI">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total MIP (Estimated)</span>
                        <strong id="totalMIP" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Property Tax</span>
                        <strong id="totalTax">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Home Insurance</span>
                        <strong id="totalInsurance">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="downTotal">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Cost</strong></span>
                        <strong id="grandTotal" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Cash Needed at Closing</h3>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="closingDown">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Closing Costs (Est. 3%)</span>
                        <strong id="closingCosts">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Cash Needed</strong></span>
                        <strong id="totalCashNeeded" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>FHA Loan Info:</strong> Minimum 3.5% down (credit score 580+). 10% down if credit score 500-579. Upfront MIP (1.75%) can be financed. Annual MIP required for life of loan (30-year) or 11 years (15-year). Lower credit score requirements than conventional. Higher debt-to-income ratios allowed. Property must be primary residence.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('fhaLoanForm');
        const currencySelect = document.getElementById('currency');
        const homePriceInput = document.getElementById('homePrice');
        const downPaymentPercentInput = document.getElementById('downPaymentPercent');
        const downPaymentAmountInput = document.getElementById('downPaymentAmount');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateFHA();
        });

        homePriceInput.addEventListener('input', updateDownPayment);
        downPaymentPercentInput.addEventListener('input', updateDownPayment);

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

        function updateDownPayment() {
            const homePrice = parseFloat(homePriceInput.value) || 0;
            const downPercent = parseFloat(downPaymentPercentInput.value) / 100 || 0.035;
            const downAmount = homePrice * downPercent;
            downPaymentAmountInput.value = Math.round(downAmount);
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateFHA();
        });

        function calculateFHA() {
            const homePrice = parseFloat(document.getElementById('homePrice').value) || 0;
            const downPaymentPercent = parseFloat(document.getElementById('downPaymentPercent').value) / 100 || 0.035;
            const interestRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0;
            const years = parseInt(document.getElementById('loanTerm').value) || 30;
            const propertyTax = parseFloat(document.getElementById('propertyTax').value) || 0;
            const homeInsurance = parseFloat(document.getElementById('homeInsurance').value) || 0;
            const hoaFees = parseFloat(document.getElementById('hoaFees').value) || 0;
            const upfrontMIPRate = parseFloat(document.getElementById('upfrontMIP').value) / 100 || 0.0175;
            const annualMIPRate = parseFloat(document.getElementById('annualMIP').value) / 100 || 0.0085;
            const currency = currencySelect.value;

            // Calculate down payment
            const downPayment = homePrice * downPaymentPercent;
            
            // Base loan amount
            const baseLoanAmount = homePrice - downPayment;
            
            // Upfront MIP (financed into loan)
            const upfrontMIP = baseLoanAmount * upfrontMIPRate;
            
            // Total loan amount
            const totalLoanAmount = baseLoanAmount + upfrontMIP;
            
            // Monthly P&I calculation
            const monthlyRate = interestRate / 12;
            const months = years * 12;
            let principalInterest = 0;
            
            if (monthlyRate > 0) {
                principalInterest = (totalLoanAmount * monthlyRate * Math.pow(1 + monthlyRate, months)) /
                                  (Math.pow(1 + monthlyRate, months) - 1);
            } else {
                principalInterest = totalLoanAmount / months;
            }
            
            // Monthly MIP
            const monthlyMIP = (baseLoanAmount * annualMIPRate) / 12;
            
            // Monthly property tax and insurance
            const monthlyPropertyTax = propertyTax / 12;
            const monthlyHomeInsurance = homeInsurance / 12;
            
            // Total monthly payment
            const totalMonthly = principalInterest + monthlyMIP + monthlyPropertyTax + monthlyHomeInsurance + hoaFees;
            
            // Total costs over life of loan
            const totalPI = principalInterest * months;
            const totalMIPPayment = monthlyMIP * months; // Simplified
            const totalTax = propertyTax * years;
            const totalInsurancePayment = homeInsurance * years;
            const grandTotal = downPayment + totalPI + totalMIPPayment + totalTax + totalInsurancePayment;
            
            // Closing costs estimate
            const closingCosts = homePrice * 0.03;
            const totalCashNeeded = downPayment + closingCosts;

            // Update UI
            document.getElementById('totalMonthlyPayment').textContent = formatCurrency(totalMonthly, currency);
            document.getElementById('principalInterest').textContent = formatCurrency(principalInterest, currency);
            document.getElementById('mortgageInsurance').textContent = formatCurrency(monthlyMIP, currency);
            document.getElementById('propertyTaxMonthly').textContent = formatCurrency(monthlyPropertyTax, currency);
            document.getElementById('homeInsuranceMonthly').textContent = formatCurrency(monthlyHomeInsurance, currency);

            document.getElementById('homePriceDisplay').textContent = formatCurrency(homePrice, currency);
            document.getElementById('downPercent').textContent = (downPaymentPercent * 100).toFixed(1);
            document.getElementById('downPaymentDisplay').textContent = formatCurrency(downPayment, currency);
            document.getElementById('baseLoanAmount').textContent = formatCurrency(baseLoanAmount, currency);
            document.getElementById('upfrontMIPAmount').textContent = formatCurrency(upfrontMIP, currency);
            document.getElementById('totalLoanAmount').textContent = formatCurrency(totalLoanAmount, currency);

            document.getElementById('piDisplay').textContent = formatCurrency(principalInterest, currency);
            document.getElementById('monthlyMIPDisplay').textContent = formatCurrency(monthlyMIP, currency);
            document.getElementById('taxDisplay').textContent = formatCurrency(monthlyPropertyTax, currency);
            document.getElementById('insuranceDisplay').textContent = formatCurrency(monthlyHomeInsurance, currency);
            document.getElementById('hoaDisplay').textContent = formatCurrency(hoaFees, currency);
            document.getElementById('totalPayment').textContent = formatCurrency(totalMonthly, currency);

            document.getElementById('upfrontRate').textContent = (upfrontMIPRate * 100).toFixed(2) + '%';
            document.getElementById('upfrontAmount').textContent = formatCurrency(upfrontMIP, currency);
            document.getElementById('annualRate').textContent = (annualMIPRate * 100).toFixed(2) + '%';
            document.getElementById('monthlyMIP').textContent = formatCurrency(monthlyMIP, currency);
            document.getElementById('annualMIPPayment').textContent = formatCurrency(monthlyMIP * 12, currency);

            document.getElementById('rateDisplay').textContent = (interestRate * 100).toFixed(2) + '% APR';
            document.getElementById('termDisplay').textContent = years + ' years';
            document.getElementById('totalPayments').textContent = months + ' payments';

            document.getElementById('totalPI').textContent = formatCurrency(totalPI, currency);
            document.getElementById('totalMIP').textContent = formatCurrency(totalMIPPayment, currency);
            document.getElementById('totalTax').textContent = formatCurrency(totalTax, currency);
            document.getElementById('totalInsurance').textContent = formatCurrency(totalInsurancePayment, currency);
            document.getElementById('downTotal').textContent = formatCurrency(downPayment, currency);
            document.getElementById('grandTotal').textContent = formatCurrency(grandTotal, currency);

            document.getElementById('closingDown').textContent = formatCurrency(downPayment, currency);
            document.getElementById('closingCosts').textContent = formatCurrency(closingCosts, currency);
            document.getElementById('totalCashNeeded').textContent = formatCurrency(totalCashNeeded, currency);
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
            updateDownPayment();
            calculateFHA();
        });
    </script>
</body>
</html>