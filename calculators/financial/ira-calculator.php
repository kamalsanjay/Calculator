<?php
/**
 * IRA Calculator
 * File: ira-calculator.php
 * Description: Calculate IRA retirement savings with tax benefits (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IRA Calculator - Calculate Retirement Savings (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free IRA calculator. Calculate Traditional and Roth IRA retirement savings with tax benefits. Compare contribution strategies. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128176; IRA Calculator</h1>
        <p>Calculate your retirement savings with IRA</p>
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
                <h2>IRA Details</h2>
                <form id="iraForm">
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
                        <label for="iraType">IRA Type</label>
                        <select id="iraType">
                            <option value="traditional">Traditional IRA</option>
                            <option value="roth">Roth IRA</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentAge">Current Age</label>
                        <input type="number" id="currentAge" value="30" min="18" max="100" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="retirementAge">Retirement Age</label>
                        <input type="number" id="retirementAge" value="65" min="18" max="100" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentBalance">Current IRA Balance (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="currentBalance" value="10000" min="0" step="1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="annualContribution">Annual Contribution (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="annualContribution" value="6500" min="0" step="100" required>
                        <small>2024 limit: $6,500 (under 50), $7,500 (50+)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="contributionIncrease">Annual Contribution Increase (%)</label>
                        <input type="number" id="contributionIncrease" value="2" min="0" max="20" step="0.5">
                        <small>Annual increase in contributions</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="returnRate">Expected Annual Return (%)</label>
                        <input type="number" id="returnRate" value="7" min="0" max="30" step="0.1" required>
                        <small>Historical average: 7-10%</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="taxRate">Current Tax Rate (%)</label>
                        <input type="number" id="taxRate" value="22" min="0" max="50" step="1">
                        <small>For Traditional IRA tax deduction</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="retirementTaxRate">Retirement Tax Rate (%)</label>
                        <input type="number" id="retirementTaxRate" value="18" min="0" max="50" step="1">
                        <small>Expected tax rate in retirement</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate IRA</button>
                </form>
            </div>

            <div class="results-section">
                <h2>IRA Projection</h2>
                
                <div class="result-card success">
                    <h3>Balance at Retirement</h3>
                    <div class="amount" id="finalBalance">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Contributions</h4>
                        <div class="value" id="totalContributions">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Earnings</h4>
                        <div class="value" id="totalEarnings">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Tax Savings</h4>
                        <div class="value" id="taxSavings">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Years to Retirement</h4>
                        <div class="value" id="yearsToRetirement">35</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Retirement Summary</h3>
                    <div class="breakdown-item">
                        <span>Current Age</span>
                        <strong id="ageDisplay">30</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Retirement Age</span>
                        <strong id="retireAgeDisplay">65</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Years Until Retirement</span>
                        <strong id="yearsDisplay" style="color: #667eea;">35 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>IRA Type</span>
                        <strong id="iraTypeDisplay">Traditional IRA</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Account Growth</h3>
                    <div class="breakdown-item">
                        <span>Starting Balance</span>
                        <strong id="startBalance">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Contributions</span>
                        <strong id="contributionsTotal" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Investment Growth</span>
                        <strong id="investmentGrowth" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Final Balance</strong></span>
                        <strong id="finalBalanceDisplay" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Traditional IRA Tax Benefits</h3>
                    <div class="breakdown-item">
                        <span>Annual Contribution</span>
                        <strong id="annualContribDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Tax Rate</span>
                        <strong id="taxRateDisplay">22%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Tax Savings</span>
                        <strong id="annualTaxSavings" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lifetime Tax Savings</span>
                        <strong id="lifetimeTaxSavings" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Withdrawal at Retirement</h3>
                    <div class="breakdown-item">
                        <span>Balance at 65</span>
                        <strong id="retirementBalance">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Retirement Tax Rate</span>
                        <strong id="retireTaxDisplay">18%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Taxes Owed (Traditional)</span>
                        <strong id="taxesOwed" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>After-Tax Balance</strong></span>
                        <strong id="afterTaxBalance" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Contribution Strategy</h3>
                    <div class="breakdown-item">
                        <span>First Year Contribution</span>
                        <strong id="firstYearContrib">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Increase</span>
                        <strong id="contribIncrease">2%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Last Year Contribution</span>
                        <strong id="lastYearContrib">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Contribution</span>
                        <strong id="avgContrib">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Investment Performance</h3>
                    <div class="breakdown-item">
                        <span>Expected Return</span>
                        <strong id="returnDisplay">7% annually</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Invested</span>
                        <strong id="totalInvested">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Growth</span>
                        <strong id="totalGrowth" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Return Multiple</span>
                        <strong id="returnMultiple" style="color: #667eea;">0x</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Monthly Retirement Income</h3>
                    <div class="breakdown-item">
                        <span>4% Rule (Annual)</span>
                        <strong id="withdrawalAnnual">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Income (Pre-Tax)</span>
                        <strong id="monthlyIncome" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Income (After-Tax)</span>
                        <strong id="monthlyIncomeAfterTax" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Milestone Balances</h3>
                    <div class="breakdown-item">
                        <span>At Age 40</span>
                        <strong id="balance40">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At Age 50</span>
                        <strong id="balance50">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At Age 60</span>
                        <strong id="balance60">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At Age 65</span>
                        <strong id="balance65" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>IRA Tips:</strong> Traditional IRA = tax deduction now, pay taxes later. Roth IRA = no deduction now, tax-free withdrawals. Contribute early and consistently. Max contribution: $6,500 (2024), $7,500 if 50+. Start withdrawals at 59½. Required distributions at 73 (Traditional). Employer 401(k) match = free money. Diversify investments. Consider target-date funds. Roth better if expecting higher tax rate. Review annually.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('iraForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateIRA();
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
            calculateIRA();
        });

        function calculateIRA() {
            const currentAge = parseInt(document.getElementById('currentAge').value) || 30;
            const retirementAge = parseInt(document.getElementById('retirementAge').value) || 65;
            const currentBalance = parseFloat(document.getElementById('currentBalance').value) || 0;
            const annualContribution = parseFloat(document.getElementById('annualContribution').value) || 0;
            const contributionIncrease = parseFloat(document.getElementById('contributionIncrease').value) / 100 || 0;
            const returnRate = parseFloat(document.getElementById('returnRate').value) / 100 || 0.07;
            const taxRate = parseFloat(document.getElementById('taxRate').value) / 100 || 0.22;
            const retirementTaxRate = parseFloat(document.getElementById('retirementTaxRate').value) / 100 || 0.18;
            const iraType = document.getElementById('iraType').value;
            const currency = currencySelect.value;

            const years = retirementAge - currentAge;
            
            // Calculate year-by-year
            let balance = currentBalance;
            let totalContributions = 0;
            let contribution = annualContribution;
            let balance40 = 0, balance50 = 0, balance60 = 0;
            
            for (let year = 1; year <= years; year++) {
                const currentAgeInYear = currentAge + year;
                
                balance = balance * (1 + returnRate) + contribution;
                totalContributions += contribution;
                contribution = contribution * (1 + contributionIncrease);
                
                if (currentAgeInYear === 40) balance40 = balance;
                if (currentAgeInYear === 50) balance50 = balance;
                if (currentAgeInYear === 60) balance60 = balance;
            }
            
            const finalBalance = balance;
            const totalEarnings = finalBalance - currentBalance - totalContributions;
            
            // Tax calculations
            const annualTaxSavings = annualContribution * taxRate;
            const lifetimeTaxSavings = annualTaxSavings * years; // Simplified
            const taxesOwed = iraType === 'traditional' ? finalBalance * retirementTaxRate : 0;
            const afterTaxBalance = finalBalance - taxesOwed;
            
            // Last year contribution
            const lastYearContrib = annualContribution * Math.pow(1 + contributionIncrease, years - 1);
            const avgContrib = totalContributions / years;
            
            // Total invested
            const totalInvested = currentBalance + totalContributions;
            const returnMultiple = totalInvested > 0 ? (finalBalance / totalInvested) : 0;
            
            // Monthly income (4% rule)
            const withdrawalAnnual = afterTaxBalance * 0.04;
            const monthlyIncome = withdrawalAnnual / 12;
            const monthlyIncomeAfterTax = iraType === 'traditional' ? monthlyIncome * (1 - retirementTaxRate) : monthlyIncome;

            // Update UI
            document.getElementById('finalBalance').textContent = formatCurrency(finalBalance, currency);
            document.getElementById('totalContributions').textContent = formatCurrency(totalContributions, currency);
            document.getElementById('totalEarnings').textContent = formatCurrency(totalEarnings, currency);
            document.getElementById('taxSavings').textContent = formatCurrency(lifetimeTaxSavings, currency);
            document.getElementById('yearsToRetirement').textContent = years;

            document.getElementById('ageDisplay').textContent = currentAge;
            document.getElementById('retireAgeDisplay').textContent = retirementAge;
            document.getElementById('yearsDisplay').textContent = years + ' years';
            document.getElementById('iraTypeDisplay').textContent = iraType === 'traditional' ? 'Traditional IRA' : 'Roth IRA';

            document.getElementById('startBalance').textContent = formatCurrency(currentBalance, currency);
            document.getElementById('contributionsTotal').textContent = formatCurrency(totalContributions, currency);
            document.getElementById('investmentGrowth').textContent = formatCurrency(totalEarnings, currency);
            document.getElementById('finalBalanceDisplay').textContent = formatCurrency(finalBalance, currency);

            document.getElementById('annualContribDisplay').textContent = formatCurrency(annualContribution, currency);
            document.getElementById('taxRateDisplay').textContent = (taxRate * 100).toFixed(0) + '%';
            document.getElementById('annualTaxSavings').textContent = formatCurrency(annualTaxSavings, currency);
            document.getElementById('lifetimeTaxSavings').textContent = formatCurrency(lifetimeTaxSavings, currency);

            document.getElementById('retirementBalance').textContent = formatCurrency(finalBalance, currency);
            document.getElementById('retireTaxDisplay').textContent = (retirementTaxRate * 100).toFixed(0) + '%';
            document.getElementById('taxesOwed').textContent = formatCurrency(taxesOwed, currency);
            document.getElementById('afterTaxBalance').textContent = formatCurrency(afterTaxBalance, currency);

            document.getElementById('firstYearContrib').textContent = formatCurrency(annualContribution, currency);
            document.getElementById('contribIncrease').textContent = (contributionIncrease * 100).toFixed(1) + '% annually';
            document.getElementById('lastYearContrib').textContent = formatCurrency(lastYearContrib, currency);
            document.getElementById('avgContrib').textContent = formatCurrency(avgContrib, currency);

            document.getElementById('returnDisplay').textContent = (returnRate * 100).toFixed(1) + '% annually';
            document.getElementById('totalInvested').textContent = formatCurrency(totalInvested, currency);
            document.getElementById('totalGrowth').textContent = formatCurrency(totalEarnings, currency);
            document.getElementById('returnMultiple').textContent = returnMultiple.toFixed(2) + 'x';

            document.getElementById('withdrawalAnnual').textContent = formatCurrency(withdrawalAnnual, currency);
            document.getElementById('monthlyIncome').textContent = formatCurrency(monthlyIncome, currency);
            document.getElementById('monthlyIncomeAfterTax').textContent = formatCurrency(monthlyIncomeAfterTax, currency);

            document.getElementById('balance40').textContent = formatCurrency(balance40, currency);
            document.getElementById('balance50').textContent = formatCurrency(balance50, currency);
            document.getElementById('balance60').textContent = formatCurrency(balance60, currency);
            document.getElementById('balance65').textContent = formatCurrency(finalBalance, currency);
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
            calculateIRA();
        });
    </script>
</body>
</html>