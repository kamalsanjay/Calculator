<?php
/**
 * Tax Calculator
 * File: tax-calculator.php
 * Description: Calculate income tax and take-home pay with USD/INR/EUR/GBP support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Calculator - Calculate Income Tax (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free income tax calculator. Calculate federal and state taxes, take-home pay, and effective tax rate. Supports USD, INR, EUR, and GBP currencies.">
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
</head>
<body>
    <header>
        <h1>💼 Tax Calculator</h1>
        <p>Calculate your income tax and take-home pay</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Income Details</h2>
                <form id="taxForm">
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
                        <label for="annualIncome">Annual Gross Income (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="annualIncome" value="75000" min="0" step="1000" required>
                        <small>Before tax salary/income</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="filingStatus">Filing Status</label>
                        <select id="filingStatus">
                            <option value="single">Single</option>
                            <option value="married">Married Filing Jointly</option>
                            <option value="head">Head of Household</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="federalTaxRate">Federal Tax Rate (%)</label>
                        <input type="number" id="federalTaxRate" value="22" min="0" max="50" step="0.1" required>
                        <small>Effective federal tax rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="stateTaxRate">State Tax Rate (%)</label>
                        <input type="number" id="stateTaxRate" value="5" min="0" max="15" step="0.1">
                        <small>State/provincial tax rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="deductions">Total Deductions (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="deductions" value="12000" min="0" step="500">
                        <small>Standard/itemized deductions</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Tax</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Tax Calculation</h2>
                
                <div class="result-card">
                    <h3>Take-Home Pay</h3>
                    <div class="amount" id="takeHomePay">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Tax</h4>
                        <div class="value" id="totalTax">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Effective Tax Rate</h4>
                        <div class="value" id="effectiveTaxRate">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Monthly Take-Home</h4>
                        <div class="value" id="monthlyTakeHome">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Bi-weekly Pay</h4>
                        <div class="value" id="biweeklyPay">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Income Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Annual Gross Income</span>
                        <strong id="grossIncome">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Deductions</span>
                        <strong id="deductionsDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Taxable Income</span>
                        <strong id="taxableIncome" style="color: #667eea;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Federal Tax (<span id="fedRate">22</span>%)</span>
                        <strong id="federalTax" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>State Tax (<span id="stateRate">5</span>%)</span>
                        <strong id="stateTax" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Tax</strong></span>
                        <strong id="totalTaxAmount" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Net Income</h3>
                    <div class="breakdown-item">
                        <span>Gross Income</span>
                        <strong id="grossIncomeDisplay2">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Less: Total Tax</span>
                        <strong id="taxDeducted" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Annual Take-Home</strong></span>
                        <strong id="annualTakeHome" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Pay Periods</h3>
                    <div class="breakdown-item">
                        <span>Monthly Take-Home</span>
                        <strong id="monthlyNet" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Bi-weekly Take-Home</span>
                        <strong id="biweeklyNet">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekly Take-Home</span>
                        <strong id="weeklyNet">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Daily Take-Home (260 days)</span>
                        <strong id="dailyNet">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Rates</h3>
                    <div class="breakdown-item">
                        <span>Marginal Tax Rate</span>
                        <strong id="marginalRate">22%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Effective Tax Rate</span>
                        <strong id="effectiveRate" style="color: #667eea;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax as % of Gross</span>
                        <strong id="taxPercentGross">0%</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Tax Tips:</strong> Marginal rate = highest bracket. Effective rate = actual % paid. Max deductions to reduce taxable income. Consider 401k/retirement contributions. Health savings accounts are tax-free. Tax planning reduces burden. Consult tax professional for personalized advice.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('taxForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateTax();
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
            document.getElementById('currencyLabel1').textContent = symbol;
            document.getElementById('currencyLabel2').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateTax();
        });

        function calculateTax() {
            const annualIncome = parseFloat(document.getElementById('annualIncome').value) || 0;
            const federalTaxRate = parseFloat(document.getElementById('federalTaxRate').value) / 100 || 0;
            const stateTaxRate = parseFloat(document.getElementById('stateTaxRate').value) / 100 || 0;
            const deductions = parseFloat(document.getElementById('deductions').value) || 0;
            const currency = currencySelect.value;

            // Calculate taxable income
            const taxableIncome = Math.max(0, annualIncome - deductions);

            // Calculate taxes
            const federalTax = taxableIncome * federalTaxRate;
            const stateTax = taxableIncome * stateTaxRate;
            const totalTax = federalTax + stateTax;

            // Net income
            const takeHomePay = annualIncome - totalTax;
            const monthlyTakeHome = takeHomePay / 12;
            const biweeklyPay = takeHomePay / 26;
            const weeklyPay = takeHomePay / 52;
            const dailyPay = takeHomePay / 260;

            // Tax rates
            const effectiveTaxRate = annualIncome > 0 ? (totalTax / annualIncome) * 100 : 0;
            const marginalRate = (federalTaxRate + stateTaxRate) * 100;
            const taxPercentGross = annualIncome > 0 ? (totalTax / annualIncome) * 100 : 0;

            // Update UI
            document.getElementById('takeHomePay').textContent = formatCurrency(takeHomePay, currency);
            document.getElementById('totalTax').textContent = formatCurrency(totalTax, currency);
            document.getElementById('effectiveTaxRate').textContent = effectiveTaxRate.toFixed(2) + '%';
            document.getElementById('monthlyTakeHome').textContent = formatCurrency(monthlyTakeHome, currency);
            document.getElementById('biweeklyPay').textContent = formatCurrency(biweeklyPay, currency);

            document.getElementById('grossIncome').textContent = formatCurrency(annualIncome, currency);
            document.getElementById('deductionsDisplay').textContent = formatCurrency(deductions, currency);
            document.getElementById('taxableIncome').textContent = formatCurrency(taxableIncome, currency);

            document.getElementById('fedRate').textContent = (federalTaxRate * 100).toFixed(1);
            document.getElementById('federalTax').textContent = formatCurrency(federalTax, currency);
            document.getElementById('stateRate').textContent = (stateTaxRate * 100).toFixed(1);
            document.getElementById('stateTax').textContent = formatCurrency(stateTax, currency);
            document.getElementById('totalTaxAmount').textContent = formatCurrency(totalTax, currency);

            document.getElementById('grossIncomeDisplay2').textContent = formatCurrency(annualIncome, currency);
            document.getElementById('taxDeducted').textContent = formatCurrency(totalTax, currency);
            document.getElementById('annualTakeHome').textContent = formatCurrency(takeHomePay, currency);

            document.getElementById('monthlyNet').textContent = formatCurrency(monthlyTakeHome, currency);
            document.getElementById('biweeklyNet').textContent = formatCurrency(biweeklyPay, currency);
            document.getElementById('weeklyNet').textContent = formatCurrency(weeklyPay, currency);
            document.getElementById('dailyNet').textContent = formatCurrency(dailyPay, currency);

            document.getElementById('marginalRate').textContent = marginalRate.toFixed(1) + '%';
            document.getElementById('effectiveRate').textContent = effectiveTaxRate.toFixed(2) + '%';
            document.getElementById('taxPercentGross').textContent = taxPercentGross.toFixed(2) + '%';
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
            calculateTax();
        });
    </script>
</body>
</html>