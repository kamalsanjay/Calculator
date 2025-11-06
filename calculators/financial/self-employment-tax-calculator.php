<?php
/**
 * Self-Employment Tax Calculator
 * File: self-employment-tax-calculator.php
 * Description: Calculate self-employment taxes and net income (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self-Employment Tax Calculator - Calculate Freelance Taxes (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free self-employment tax calculator. Calculate self-employment tax, income tax, and net income for freelancers. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128188; Self-Employment Tax Calculator</h1>
        <p>Calculate taxes for freelancers and self-employed</p>
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
                <h2>Self-Employment Income</h2>
                <form id="selfEmploymentForm">
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
                        <label for="grossIncome">Annual Gross Income (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="grossIncome" value="80000" min="0" step="1000" required>
                        <small>Total revenue before expenses</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Business Expenses</h3>
                    
                    <div class="form-group">
                        <label for="businessExpenses">Annual Business Expenses (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="businessExpenses" value="15000" min="0" step="500">
                        <small>Deductible business costs</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="homeOffice">Home Office Deduction (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="homeOffice" value="3000" min="0" step="100">
                        <small>Dedicated workspace expenses</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="healthInsurance">Health Insurance (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="healthInsurance" value="5000" min="0" step="100">
                        <small>Self-employed health insurance</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="retirementContribution">Retirement Contribution (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="retirementContribution" value="6000" min="0" step="500">
                        <small>SEP-IRA, Solo 401k, etc.</small>
                    </div>
                    
                    <h3 style="color: #f44336; margin: 25px 0 15px;">Tax Rates</h3>
                    
                    <div class="form-group">
                        <label for="selfEmploymentTaxRate">Self-Employment Tax Rate (%)</label>
                        <input type="number" id="selfEmploymentTaxRate" value="15.3" min="0" max="20" step="0.1">
                        <small>US: 15.3% (Social Security + Medicare)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="incomeTaxRate">Income Tax Rate (%)</label>
                        <input type="number" id="incomeTaxRate" value="22" min="0" max="50" step="1">
                        <small>Federal income tax rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="stateTaxRate">State/Local Tax Rate (%)</label>
                        <input type="number" id="stateTaxRate" value="5" min="0" max="15" step="0.5">
                        <small>State and local taxes</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Taxes</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Tax Summary</h2>
                
                <div class="result-card success">
                    <h3>Net Income (Take-Home)</h3>
                    <div class="amount" id="netIncome">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Gross Income</h4>
                        <div class="value" id="grossIncomeDisplay">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Taxes</h4>
                        <div class="value" id="totalTaxes">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Effective Tax Rate</h4>
                        <div class="value" id="effectiveTaxRate">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Taxable Income</h4>
                        <div class="value" id="taxableIncome">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Income Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Gross Income</span>
                        <strong id="grossIncomeCalc">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Business Expenses</span>
                        <strong id="businessExpensesDisplay" style="color: #FF9800;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Home Office Deduction</span>
                        <strong id="homeOfficeDisplay" style="color: #FF9800;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Business Income</strong></span>
                        <strong id="netBusinessIncome" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Self-Employment Tax</h3>
                    <div class="breakdown-item">
                        <span>Net Business Income</span>
                        <strong id="netIncomeForSE">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>SE Tax Base (92.35% of income)</span>
                        <strong id="seTaxBase">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>SE Tax Rate</span>
                        <strong id="seTaxRateDisplay">15.3%</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #f44336; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Self-Employment Tax</strong></span>
                        <strong id="selfEmploymentTax" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Social Security (12.4%)</span>
                        <strong id="socialSecurityTax">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Medicare (2.9%)</span>
                        <strong id="medicareTax">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Adjusted Gross Income (AGI)</h3>
                    <div class="breakdown-item">
                        <span>Net Business Income</span>
                        <strong id="netBusinessIncomeAGI">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Deductible SE Tax (50%)</span>
                        <strong id="seTaxDeduction" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Health Insurance Deduction</span>
                        <strong id="healthInsuranceDeduction" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Retirement Contribution</span>
                        <strong id="retirementDeduction" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Adjusted Gross Income</strong></span>
                        <strong id="agi" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Income Tax</h3>
                    <div class="breakdown-item">
                        <span>Adjusted Gross Income</span>
                        <strong id="agiForIncomeTax">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Standard Deduction</span>
                        <strong id="standardDeduction" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Taxable Income</span>
                        <strong id="taxableIncomeCalc" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Federal Income Tax</span>
                        <strong id="federalIncomeTax" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>State/Local Tax</span>
                        <strong id="stateTax" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #f44336; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Income Tax</strong></span>
                        <strong id="totalIncomeTax" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Tax Liability</h3>
                    <div class="breakdown-item">
                        <span>Self-Employment Tax</span>
                        <strong id="seTaxTotal" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Federal Income Tax</span>
                        <strong id="federalTaxTotal" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>State/Local Tax</span>
                        <strong id="stateTaxTotal" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #f44336; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Annual Taxes</strong></span>
                        <strong id="totalAnnualTaxes" style="color: #f44336; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Net Income</h3>
                    <div class="breakdown-item">
                        <span>Gross Income</span>
                        <strong id="grossForNet">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Business Expenses</span>
                        <strong id="expensesForNet" style="color: #FF9800;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Taxes</span>
                        <strong id="taxesForNet" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Income (Take-Home)</strong></span>
                        <strong id="netIncomeFinal" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Net Income %</span>
                        <strong id="netIncomePercent" style="color: #667eea;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Monthly Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Monthly Gross Income</span>
                        <strong id="monthlyGross">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Expenses</span>
                        <strong id="monthlyExpenses" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Taxes</span>
                        <strong id="monthlyTaxes" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Net Income</span>
                        <strong id="monthlyNet" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Quarterly Estimated Taxes</h3>
                    <div class="breakdown-item">
                        <span>Total Annual Tax</span>
                        <strong id="annualTaxForQuarterly">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Quarterly Payment (÷4)</span>
                        <strong id="quarterlyPayment" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Payment Dates</span>
                        <strong id="paymentDates">Apr 15, Jun 15, Sep 15, Jan 15</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Rate Analysis</h3>
                    <div class="breakdown-item">
                        <span>Effective Tax Rate</span>
                        <strong id="effectiveRate" style="color: #f44336;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>SE Tax as % of Gross</span>
                        <strong id="seRateOfGross">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Income Tax as % of Gross</span>
                        <strong id="incomeRateOfGross">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Tax as % of Gross</span>
                        <strong id="totalRateOfGross">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Self-Employment Tips:</strong> SE tax = 15.3% (12.4% Social Security + 2.9% Medicare). Pay quarterly estimated taxes. Deduct 50% of SE tax from income. Track ALL business expenses. Home office = significant deduction. Health insurance 100% deductible. Retirement contributions reduce taxable income. Keep personal/business separate. Mileage = 65.5¢/mile (2023). Save 25-30% of income for taxes. Estimated tax penalties if underpay. Consider S-Corp for high income. Hire CPA/accountant. QBI deduction = 20% potential savings. Pay yourself salary. Keep receipts!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('selfEmploymentForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateTaxes();
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
            for (let i = 1; i <= 5; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateTaxes();
        });

        function calculateTaxes() {
            const grossIncome = parseFloat(document.getElementById('grossIncome').value) || 0;
            const businessExpenses = parseFloat(document.getElementById('businessExpenses').value) || 0;
            const homeOffice = parseFloat(document.getElementById('homeOffice').value) || 0;
            const healthInsurance = parseFloat(document.getElementById('healthInsurance').value) || 0;
            const retirementContribution = parseFloat(document.getElementById('retirementContribution').value) || 0;
            const seTaxRate = parseFloat(document.getElementById('selfEmploymentTaxRate').value) / 100 || 0.153;
            const incomeTaxRate = parseFloat(document.getElementById('incomeTaxRate').value) / 100 || 0.22;
            const stateTaxRate = parseFloat(document.getElementById('stateTaxRate').value) / 100 || 0.05;
            const currency = currencySelect.value;

            // Calculate net business income
            const totalExpenses = businessExpenses + homeOffice;
            const netBusinessIncome = grossIncome - totalExpenses;

            // Self-employment tax (on 92.35% of net business income)
            const seTaxBase = netBusinessIncome * 0.9235;
            const selfEmploymentTax = seTaxBase * seTaxRate;
            const socialSecurityTax = seTaxBase * 0.124;
            const medicareTax = seTaxBase * 0.029;

            // Deductible portion of SE tax (50%)
            const seTaxDeduction = selfEmploymentTax * 0.5;

            // Adjusted Gross Income
            const agi = netBusinessIncome - seTaxDeduction - healthInsurance - retirementContribution;

            // Standard deduction (2024 single filer)
            const standardDeduction = 14600;

            // Taxable income
            const taxableIncome = Math.max(0, agi - standardDeduction);

            // Income taxes
            const federalIncomeTax = taxableIncome * incomeTaxRate;
            const stateTax = taxableIncome * stateTaxRate;
            const totalIncomeTax = federalIncomeTax + stateTax;

            // Total taxes
            const totalTaxes = selfEmploymentTax + totalIncomeTax;

            // Net income
            const netIncome = grossIncome - totalExpenses - totalTaxes;

            // Percentages
            const effectiveTaxRate = grossIncome > 0 ? (totalTaxes / grossIncome) * 100 : 0;
            const netIncomePercent = grossIncome > 0 ? (netIncome / grossIncome) * 100 : 0;
            const seRateOfGross = grossIncome > 0 ? (selfEmploymentTax / grossIncome) * 100 : 0;
            const incomeRateOfGross = grossIncome > 0 ? (totalIncomeTax / grossIncome) * 100 : 0;
            const totalRateOfGross = effectiveTaxRate;

            // Monthly
            const monthlyGross = grossIncome / 12;
            const monthlyExpenses = totalExpenses / 12;
            const monthlyTaxes = totalTaxes / 12;
            const monthlyNet = netIncome / 12;

            // Quarterly
            const quarterlyPayment = totalTaxes / 4;

            // Analysis
            let analysis = `From your gross income of ${formatCurrency(grossIncome, currency)}, you deduct ${formatCurrency(totalExpenses, currency)} in business expenses, leaving ${formatCurrency(netBusinessIncome, currency)} in net business income. `;
            analysis += `Your self-employment tax is ${formatCurrency(selfEmploymentTax, currency)} (${(seTaxRate * 100).toFixed(1)}% of ${formatCurrency(seTaxBase, currency)}). `;
            analysis += `After deducting 50% of SE tax (${formatCurrency(seTaxDeduction, currency)}), health insurance, and retirement contributions, your AGI is ${formatCurrency(agi, currency)}. `;
            analysis += `With ${formatCurrency(totalIncomeTax, currency)} in income taxes and ${formatCurrency(selfEmploymentTax, currency)} in SE tax, your total tax is ${formatCurrency(totalTaxes, currency)} (${effectiveTaxRate.toFixed(1)}% effective rate). `;
            analysis += `Your net take-home income is ${formatCurrency(netIncome, currency)} (${formatCurrency(monthlyNet, currency)}/month). Pay ${formatCurrency(quarterlyPayment, currency)} in quarterly estimated taxes.`;

            // Update UI
            document.getElementById('netIncome').textContent = formatCurrency(netIncome, currency);
            document.getElementById('grossIncomeDisplay').textContent = formatCurrency(grossIncome, currency);
            document.getElementById('totalTaxes').textContent = formatCurrency(totalTaxes, currency);
            document.getElementById('effectiveTaxRate').textContent = effectiveTaxRate.toFixed(1) + '%';
            document.getElementById('taxableIncome').textContent = formatCurrency(taxableIncome, currency);

            document.getElementById('grossIncomeCalc').textContent = formatCurrency(grossIncome, currency);
            document.getElementById('businessExpensesDisplay').textContent = formatCurrency(businessExpenses, currency);
            document.getElementById('homeOfficeDisplay').textContent = formatCurrency(homeOffice, currency);
            document.getElementById('netBusinessIncome').textContent = formatCurrency(netBusinessIncome, currency);

            document.getElementById('netIncomeForSE').textContent = formatCurrency(netBusinessIncome, currency);
            document.getElementById('seTaxBase').textContent = formatCurrency(seTaxBase, currency);
            document.getElementById('seTaxRateDisplay').textContent = (seTaxRate * 100).toFixed(1) + '%';
            document.getElementById('selfEmploymentTax').textContent = formatCurrency(selfEmploymentTax, currency);
            document.getElementById('socialSecurityTax').textContent = formatCurrency(socialSecurityTax, currency);
            document.getElementById('medicareTax').textContent = formatCurrency(medicareTax, currency);

            document.getElementById('netBusinessIncomeAGI').textContent = formatCurrency(netBusinessIncome, currency);
            document.getElementById('seTaxDeduction').textContent = formatCurrency(seTaxDeduction, currency);
            document.getElementById('healthInsuranceDeduction').textContent = formatCurrency(healthInsurance, currency);
            document.getElementById('retirementDeduction').textContent = formatCurrency(retirementContribution, currency);
            document.getElementById('agi').textContent = formatCurrency(agi, currency);

            document.getElementById('agiForIncomeTax').textContent = formatCurrency(agi, currency);
            document.getElementById('standardDeduction').textContent = formatCurrency(standardDeduction, currency);
            document.getElementById('taxableIncomeCalc').textContent = formatCurrency(taxableIncome, currency);
            document.getElementById('federalIncomeTax').textContent = formatCurrency(federalIncomeTax, currency);
            document.getElementById('stateTax').textContent = formatCurrency(stateTax, currency);
            document.getElementById('totalIncomeTax').textContent = formatCurrency(totalIncomeTax, currency);

            document.getElementById('seTaxTotal').textContent = formatCurrency(selfEmploymentTax, currency);
            document.getElementById('federalTaxTotal').textContent = formatCurrency(federalIncomeTax, currency);
            document.getElementById('stateTaxTotal').textContent = formatCurrency(stateTax, currency);
            document.getElementById('totalAnnualTaxes').textContent = formatCurrency(totalTaxes, currency);

            document.getElementById('grossForNet').textContent = formatCurrency(grossIncome, currency);
            document.getElementById('expensesForNet').textContent = formatCurrency(totalExpenses, currency);
            document.getElementById('taxesForNet').textContent = formatCurrency(totalTaxes, currency);
            document.getElementById('netIncomeFinal').textContent = formatCurrency(netIncome, currency);
            document.getElementById('netIncomePercent').textContent = netIncomePercent.toFixed(1) + '%';

            document.getElementById('monthlyGross').textContent = formatCurrency(monthlyGross, currency);
            document.getElementById('monthlyExpenses').textContent = formatCurrency(monthlyExpenses, currency);
            document.getElementById('monthlyTaxes').textContent = formatCurrency(monthlyTaxes, currency);
            document.getElementById('monthlyNet').textContent = formatCurrency(monthlyNet, currency);

            document.getElementById('annualTaxForQuarterly').textContent = formatCurrency(totalTaxes, currency);
            document.getElementById('quarterlyPayment').textContent = formatCurrency(quarterlyPayment, currency);

            document.getElementById('effectiveRate').textContent = effectiveTaxRate.toFixed(1) + '%';
            document.getElementById('seRateOfGross').textContent = seRateOfGross.toFixed(1) + '%';
            document.getElementById('incomeRateOfGross').textContent = incomeRateOfGross.toFixed(1) + '%';
            document.getElementById('totalRateOfGross').textContent = totalRateOfGross.toFixed(1) + '%';

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
            calculateTaxes();
        });
    </script>
</body>
</html>