<?php
/**
 * Home Affordability Calculator
 * File: home-affordability-calculator.php
 * Description: Calculate how much house you can afford (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Affordability Calculator - How Much House Can I Afford? (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free home affordability calculator. Calculate maximum home price based on income, debts, and down payment. Get personalized mortgage recommendations. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🏡 Home Affordability Calculator</h1>
        <p>Find out how much house you can afford</p>
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
                <h2>Your Financial Details</h2>
                <form id="affordabilityForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                            <option value="EUR">EUR (€)</option>
                            <option value="GBP">GBP (£)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Income</h3>
                    
                    <div class="form-group">
                        <label for="annualIncome">Gross Annual Income (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="annualIncome" value="75000" min="0" step="1000" required>
                        <small>Before taxes</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="otherIncome">Other Monthly Income (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="otherIncome" value="0" min="0" step="100">
                        <small>Bonuses, investments, etc.</small>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Monthly Debts</h3>
                    
                    <div class="form-group">
                        <label for="carPayment">Car Payment (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="carPayment" value="400" min="0" step="10">
                    </div>
                    
                    <div class="form-group">
                        <label for="creditCards">Credit Card Payments (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="creditCards" value="150" min="0" step="10">
                        <small>Minimum payments</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="studentLoans">Student Loans (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="studentLoans" value="200" min="0" step="10">
                    </div>
                    
                    <div class="form-group">
                        <label for="otherDebts">Other Monthly Debts (<span id="currencyLabel6">$</span>)</label>
                        <input type="number" id="otherDebts" value="0" min="0" step="10">
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Loan Parameters</h3>
                    
                    <div class="form-group">
                        <label for="downPayment">Down Payment (<span id="currencyLabel7">$</span>)</label>
                        <input type="number" id="downPayment" value="40000" min="0" step="1000" required>
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
                        <label for="propertyTaxRate">Property Tax Rate (%)</label>
                        <input type="number" id="propertyTaxRate" value="1.2" min="0" max="5" step="0.1">
                        <small>Annual rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="homeInsuranceRate">Home Insurance Rate (%)</label>
                        <input type="number" id="homeInsuranceRate" value="0.5" min="0" max="3" step="0.1">
                        <small>Annual rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="hoaFees">Monthly HOA Fees (<span id="currencyLabel8">$</span>)</label>
                        <input type="number" id="hoaFees" value="0" min="0" step="10">
                    </div>
                    
                    <button type="submit" class="btn">Calculate Affordability</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Home Affordability Results</h2>
                
                <div class="result-card success">
                    <h3>Maximum Home Price</h3>
                    <div class="amount" id="maxHomePrice">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Loan Amount</h4>
                        <div class="value" id="loanAmount">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Monthly Payment</h4>
                        <div class="value" id="monthlyPayment">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>DTI Ratio</h4>
                        <div class="value" id="dtiRatio">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Down Payment</h4>
                        <div class="value" id="downPaymentDisplay">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Income Analysis</h3>
                    <div class="breakdown-item">
                        <span>Gross Annual Income</span>
                        <strong id="incomeDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Monthly Income</span>
                        <strong id="otherIncomeDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gross Monthly Income</span>
                        <strong id="monthlyIncome" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Current Monthly Debts</h3>
                    <div class="breakdown-item">
                        <span>Car Payment</span>
                        <strong id="carDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Credit Cards</span>
                        <strong id="creditDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Student Loans</span>
                        <strong id="studentDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Debts</span>
                        <strong id="otherDebtsDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Monthly Debts</strong></span>
                        <strong id="totalDebts" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Debt-to-Income Ratios</h3>
                    <div class="breakdown-item">
                        <span>Front-End Ratio (Housing only)</span>
                        <strong id="frontEndRatio">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Back-End Ratio (All debts)</span>
                        <strong id="backEndRatio" style="color: #667eea;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Recommended Max (28% / 36%)</span>
                        <strong style="color: #888;">28% / 36%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>DTI Status</span>
                        <strong id="dtiStatus">Good</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Maximum Monthly Housing Payment</h3>
                    <div class="breakdown-item">
                        <span>Based on 28% Rule</span>
                        <strong id="rule28">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Based on 36% Rule</span>
                        <strong id="rule36">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Recommended Maximum</span>
                        <strong id="maxHousingPayment" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Estimated Monthly Payment</h3>
                    <div class="breakdown-item">
                        <span>Principal & Interest</span>
                        <strong id="piPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Property Tax</span>
                        <strong id="taxPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Home Insurance</span>
                        <strong id="insurancePayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>HOA Fees</span>
                        <strong id="hoaPayment">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Monthly Payment (PITI)</strong></span>
                        <strong id="totalPITI" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Home Price Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Maximum Home Price</span>
                        <strong id="homePriceBreakdown" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="downBreakdown">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="loanBreakdown" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment %</span>
                        <strong id="downPercent">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Home Price Scenarios</h3>
                    <div class="breakdown-item">
                        <span>Conservative (28% rule)</span>
                        <strong id="conservativePrice" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Moderate (32% rule)</span>
                        <strong id="moderatePrice" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Aggressive (36% rule)</span>
                        <strong id="aggressivePrice" style="color: #f44336;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Cash Required at Closing</h3>
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
                        <strong id="totalCash" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Affordability Tips:</strong> 28% rule = housing costs ≤ 28% gross income. 36% rule = all debts ≤ 36% gross income. DTI below 36% is ideal. Higher down payment = lower monthly costs. Include HOA, taxes, insurance in budget. Leave room for maintenance (1-2% home value yearly). Don't max out budget. Consider future expenses.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('affordabilityForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateAffordability();
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
            for (let i = 1; i <= 8; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateAffordability();
        });

        function calculateAffordability() {
            const annualIncome = parseFloat(document.getElementById('annualIncome').value) || 0;
            const otherIncome = parseFloat(document.getElementById('otherIncome').value) || 0;
            const carPayment = parseFloat(document.getElementById('carPayment').value) || 0;
            const creditCards = parseFloat(document.getElementById('creditCards').value) || 0;
            const studentLoans = parseFloat(document.getElementById('studentLoans').value) || 0;
            const otherDebts = parseFloat(document.getElementById('otherDebts').value) || 0;
            const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
            const interestRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0;
            const years = parseInt(document.getElementById('loanTerm').value) || 30;
            const propertyTaxRate = parseFloat(document.getElementById('propertyTaxRate').value) / 100 || 0.012;
            const homeInsuranceRate = parseFloat(document.getElementById('homeInsuranceRate').value) / 100 || 0.005;
            const hoaFees = parseFloat(document.getElementById('hoaFees').value) || 0;
            const currency = currencySelect.value;

            // Calculate monthly income
            const monthlyIncome = (annualIncome / 12) + otherIncome;
            
            // Calculate total monthly debts
            const totalMonthlyDebts = carPayment + creditCards + studentLoans + otherDebts;
            
            // Calculate maximum housing payment using 28% rule
            const maxHousingPayment28 = monthlyIncome * 0.28;
            
            // Calculate maximum housing payment using 36% rule (minus existing debts)
            const maxTotalPayment36 = monthlyIncome * 0.36;
            const maxHousingPayment36 = maxTotalPayment36 - totalMonthlyDebts;
            
            // Use the lower of the two
            const maxHousingPayment = Math.min(maxHousingPayment28, maxHousingPayment36);
            
            // Subtract HOA fees from available payment
            const availableForPITI = maxHousingPayment - hoaFees;
            
            // Calculate maximum home price
            const monthlyRate = interestRate / 12;
            const months = years * 12;
            
            // We need to solve for home price where:
            // PITI = P&I + (homePrice * taxRate / 12) + (homePrice * insRate / 12)
            // availableForPITI = [loanAmount * (r * (1+r)^n) / ((1+r)^n - 1)] + (homePrice * taxRate / 12) + (homePrice * insRate / 12)
            
            // Simplified approach: estimate iteratively
            let homePrice = 0;
            let loanAmount = 0;
            let monthlyPI = 0;
            let monthlyTax = 0;
            let monthlyInsurance = 0;
            let totalPITI = 0;
            
            // Start with an estimate
            homePrice = (availableForPITI * months) / (1 + (propertyTaxRate + homeInsuranceRate) * years);
            
            // Refine through iteration
            for (let i = 0; i < 10; i++) {
                loanAmount = homePrice - downPayment;
                
                if (monthlyRate > 0) {
                    monthlyPI = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, months)) /
                              (Math.pow(1 + monthlyRate, months) - 1);
                } else {
                    monthlyPI = loanAmount / months;
                }
                
                monthlyTax = (homePrice * propertyTaxRate) / 12;
                monthlyInsurance = (homePrice * homeInsuranceRate) / 12;
                totalPITI = monthlyPI + monthlyTax + monthlyInsurance + hoaFees;
                
                // Adjust home price
                const diff = availableForPITI - (totalPITI - hoaFees);
                homePrice += diff * 100; // Adjustment factor
                
                if (Math.abs(diff) < 1) break;
            }
            
            // DTI calculations
            const frontEndRatio = (totalPITI / monthlyIncome) * 100;
            const backEndRatio = ((totalPITI + totalMonthlyDebts) / monthlyIncome) * 100;
            
            // DTI Status
            let dtiStatus = '';
            if (backEndRatio <= 28) {
                dtiStatus = 'Excellent ✅';
            } else if (backEndRatio <= 36) {
                dtiStatus = 'Good 👍';
            } else if (backEndRatio <= 43) {
                dtiStatus = 'Fair ⚠️';
            } else {
                dtiStatus = 'High Risk ❌';
            }
            
            // Alternative scenarios
            const conservativeMax = monthlyIncome * 0.28 - hoaFees;
            const moderateMax = monthlyIncome * 0.32 - hoaFees;
            const aggressiveMax = monthlyIncome * 0.36 - totalMonthlyDebts - hoaFees;
            
            function calculateHomePrice(maxPayment) {
                let hp = 0;
                for (let i = 0; i < 10; i++) {
                    const la = hp - downPayment;
                    const pi = monthlyRate > 0 ? (la * monthlyRate * Math.pow(1 + monthlyRate, months)) / (Math.pow(1 + monthlyRate, months) - 1) : la / months;
                    const tx = (hp * propertyTaxRate) / 12;
                    const ins = (hp * homeInsuranceRate) / 12;
                    const total = pi + tx + ins;
                    const diff = maxPayment - total;
                    hp += diff * 100;
                    if (Math.abs(diff) < 1) break;
                }
                return hp;
            }
            
            const conservativePrice = calculateHomePrice(conservativeMax) + downPayment;
            const moderatePrice = calculateHomePrice(moderateMax) + downPayment;
            const aggressivePrice = calculateHomePrice(aggressiveMax) + downPayment;
            
            // Closing costs
            const closingCosts = homePrice * 0.03;
            const totalCash = downPayment + closingCosts;
            const downPercent = homePrice > 0 ? (downPayment / homePrice) * 100 : 0;

            // Update UI
            document.getElementById('maxHomePrice').textContent = formatCurrency(homePrice, currency);
            document.getElementById('loanAmount').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('monthlyPayment').textContent = formatCurrency(totalPITI, currency);
            document.getElementById('dtiRatio').textContent = backEndRatio.toFixed(1) + '%';
            document.getElementById('downPaymentDisplay').textContent = formatCurrency(downPayment, currency);

            document.getElementById('incomeDisplay').textContent = formatCurrency(annualIncome, currency);
            document.getElementById('otherIncomeDisplay').textContent = formatCurrency(otherIncome, currency);
            document.getElementById('monthlyIncome').textContent = formatCurrency(monthlyIncome, currency);

            document.getElementById('carDisplay').textContent = formatCurrency(carPayment, currency);
            document.getElementById('creditDisplay').textContent = formatCurrency(creditCards, currency);
            document.getElementById('studentDisplay').textContent = formatCurrency(studentLoans, currency);
            document.getElementById('otherDebtsDisplay').textContent = formatCurrency(otherDebts, currency);
            document.getElementById('totalDebts').textContent = formatCurrency(totalMonthlyDebts, currency);

            document.getElementById('frontEndRatio').textContent = frontEndRatio.toFixed(1) + '%';
            document.getElementById('backEndRatio').textContent = backEndRatio.toFixed(1) + '%';
            document.getElementById('dtiStatus').textContent = dtiStatus;

            document.getElementById('rule28').textContent = formatCurrency(maxHousingPayment28, currency);
            document.getElementById('rule36').textContent = formatCurrency(maxHousingPayment36, currency);
            document.getElementById('maxHousingPayment').textContent = formatCurrency(maxHousingPayment, currency);

            document.getElementById('piPayment').textContent = formatCurrency(monthlyPI, currency);
            document.getElementById('taxPayment').textContent = formatCurrency(monthlyTax, currency);
            document.getElementById('insurancePayment').textContent = formatCurrency(monthlyInsurance, currency);
            document.getElementById('hoaPayment').textContent = formatCurrency(hoaFees, currency);
            document.getElementById('totalPITI').textContent = formatCurrency(totalPITI, currency);

            document.getElementById('homePriceBreakdown').textContent = formatCurrency(homePrice, currency);
            document.getElementById('downBreakdown').textContent = formatCurrency(downPayment, currency);
            document.getElementById('loanBreakdown').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('downPercent').textContent = downPercent.toFixed(1) + '%';

            document.getElementById('conservativePrice').textContent = formatCurrency(conservativePrice, currency);
            document.getElementById('moderatePrice').textContent = formatCurrency(moderatePrice, currency);
            document.getElementById('aggressivePrice').textContent = formatCurrency(aggressivePrice, currency);

            document.getElementById('closingDown').textContent = formatCurrency(downPayment, currency);
            document.getElementById('closingCosts').textContent = formatCurrency(closingCosts, currency);
            document.getElementById('totalCash').textContent = formatCurrency(totalCash, currency);
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
            calculateAffordability();
        });
    </script>
</body>
</html>