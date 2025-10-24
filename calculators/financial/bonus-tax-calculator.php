<?php
/**
 * Bonus Tax Calculator
 * File: bonus-tax-calculator.php
 * Description: Calculate bonus tax withholding and net bonus amount (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bonus Tax Calculator - Calculate Net Bonus After Tax (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free bonus tax calculator. Calculate federal and state tax withholding on bonus payments. See your net bonus after taxes. Supports USD, INR, EUR, and GBP.">
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
        <h1>💰 Bonus Tax Calculator</h1>
        <p>Calculate your net bonus after tax withholding</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Bonus Details</h2>
                <form id="bonusForm">
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
                        <label for="bonusAmount">Bonus Amount (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="bonusAmount" value="10000" min="100" step="100" required>
                        <small>Gross bonus before taxes</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="taxMethod">Tax Withholding Method</label>
                        <select id="taxMethod">
                            <option value="percentage">Percentage Method (22% flat)</option>
                            <option value="aggregate">Aggregate Method (with salary)</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="salaryGroup" style="display: none;">
                        <label for="annualSalary">Annual Salary (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="annualSalary" value="75000" min="0" step="1000">
                        <small>For aggregate method calculation</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="federalTaxRate">Federal Tax Rate (%)</label>
                        <input type="number" id="federalTaxRate" value="22" min="0" max="37" step="0.1" required>
                        <small>Supplemental wage rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="stateTaxRate">State Tax Rate (%)</label>
                        <input type="number" id="stateTaxRate" value="5" min="0" max="15" step="0.1">
                    </div>
                    
                    <div class="form-group">
                        <label for="socialSecurity">Social Security Tax (%)</label>
                        <input type="number" id="socialSecurity" value="6.2" min="0" max="10" step="0.1">
                        <small>FICA - typically 6.2%</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="medicare">Medicare Tax (%)</label>
                        <input type="number" id="medicare" value="1.45" min="0" max="5" step="0.05">
                        <small>Typically 1.45%</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="other401k">401(k) Contribution (%)</label>
                        <input type="number" id="other401k" value="0" min="0" max="100" step="0.5">
                        <small>Optional pre-tax deduction</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Net Bonus</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Bonus Calculation</h2>
                
                <div class="result-card">
                    <h3>Net Bonus (Take-Home)</h3>
                    <div class="amount" id="netBonus">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Gross Bonus</h4>
                        <div class="value" id="grossBonus">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Tax</h4>
                        <div class="value" id="totalTax">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Effective Tax Rate</h4>
                        <div class="value" id="effectiveRate">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Net Percentage</h4>
                        <div class="value" id="netPercentage">0%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Bonus Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Gross Bonus Amount</span>
                        <strong id="bonusGross">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax Method</span>
                        <strong id="methodDisplay">Percentage Method</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Withholdings</h3>
                    <div class="breakdown-item">
                        <span>Federal Tax (<span id="fedRate">22</span>%)</span>
                        <strong id="federalTax" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>State Tax (<span id="stateRate">5</span>%)</span>
                        <strong id="stateTax" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Social Security (<span id="ssRate">6.2</span>%)</span>
                        <strong id="socialSecurityTax" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Medicare (<span id="medRate">1.45</span>%)</span>
                        <strong id="medicareTax" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Tax Withheld</strong></span>
                        <strong id="totalTaxWithheld" style="color: #f44336; font-size: 1.1em;">-$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Other Deductions</h3>
                    <div class="breakdown-item">
                        <span>401(k) Contribution (<span id="k401Rate">0</span>%)</span>
                        <strong id="k401Amount" style="color: #FF9800;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Deductions</span>
                        <strong id="totalDeductions" style="color: #FF9800;">-$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Net Bonus Calculation</h3>
                    <div class="breakdown-item">
                        <span>Gross Bonus</span>
                        <strong id="grossAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Less: Total Tax</span>
                        <strong id="taxDeduction" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Less: Other Deductions</span>
                        <strong id="otherDeductions" style="color: #FF9800;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Bonus (Take-Home)</strong></span>
                        <strong id="finalNetBonus" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Summary</h3>
                    <div class="breakdown-item">
                        <span>Total Taxes Paid</span>
                        <strong id="totalTaxesPaid">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Effective Tax Rate</span>
                        <strong id="effectiveTaxRate" style="color: #667eea;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Take-Home Percentage</span>
                        <strong id="takeHomePercent" style="color: #4CAF50;">0%</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Bonus Tax Info:</strong> Percentage method = flat 22% federal (for bonuses under $1M). Aggregate method = bonus added to salary and taxed at regular rate. Social Security max = $160,200 (2024). Additional 0.9% Medicare on income >$200k. State tax varies by location. Consider increasing 401(k) to reduce taxable amount.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('bonusForm');
        const currencySelect = document.getElementById('currency');
        const taxMethodSelect = document.getElementById('taxMethod');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateBonus();
        });

        taxMethodSelect.addEventListener('change', function() {
            toggleSalaryField();
            calculateBonus();
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

        function toggleSalaryField() {
            const method = taxMethodSelect.value;
            const salaryGroup = document.getElementById('salaryGroup');
            salaryGroup.style.display = method === 'aggregate' ? 'block' : 'none';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBonus();
        });

        function calculateBonus() {
            const bonusAmount = parseFloat(document.getElementById('bonusAmount').value) || 0;
            const federalTaxRate = parseFloat(document.getElementById('federalTaxRate').value) / 100 || 0.22;
            const stateTaxRate = parseFloat(document.getElementById('stateTaxRate').value) / 100 || 0.05;
            const socialSecurityRate = parseFloat(document.getElementById('socialSecurity').value) / 100 || 0.062;
            const medicareRate = parseFloat(document.getElementById('medicare').value) / 100 || 0.0145;
            const k401Rate = parseFloat(document.getElementById('other401k').value) / 100 || 0;
            const currency = currencySelect.value;
            const taxMethod = taxMethodSelect.value;

            // Calculate taxes
            const federalTax = bonusAmount * federalTaxRate;
            const stateTax = bonusAmount * stateTaxRate;
            const socialSecurityTax = bonusAmount * socialSecurityRate;
            const medicareTax = bonusAmount * medicareRate;
            
            const totalTax = federalTax + stateTax + socialSecurityTax + medicareTax;
            
            // Other deductions
            const k401Contribution = bonusAmount * k401Rate;
            const totalDeductions = k401Contribution;
            
            // Net bonus
            const netBonus = bonusAmount - totalTax - totalDeductions;
            
            // Percentages
            const effectiveRate = bonusAmount > 0 ? (totalTax / bonusAmount) * 100 : 0;
            const netPercentage = bonusAmount > 0 ? (netBonus / bonusAmount) * 100 : 0;

            // Update UI
            document.getElementById('netBonus').textContent = formatCurrency(netBonus, currency);
            document.getElementById('grossBonus').textContent = formatCurrency(bonusAmount, currency);
            document.getElementById('totalTax').textContent = formatCurrency(totalTax, currency);
            document.getElementById('effectiveRate').textContent = effectiveRate.toFixed(2) + '%';
            document.getElementById('netPercentage').textContent = netPercentage.toFixed(2) + '%';

            document.getElementById('bonusGross').textContent = formatCurrency(bonusAmount, currency);
            document.getElementById('methodDisplay').textContent = taxMethod === 'percentage' ? 'Percentage Method (22%)' : 'Aggregate Method';

            document.getElementById('fedRate').textContent = (federalTaxRate * 100).toFixed(1);
            document.getElementById('federalTax').textContent = formatCurrency(federalTax, currency);
            document.getElementById('stateRate').textContent = (stateTaxRate * 100).toFixed(1);
            document.getElementById('stateTax').textContent = formatCurrency(stateTax, currency);
            document.getElementById('ssRate').textContent = (socialSecurityRate * 100).toFixed(2);
            document.getElementById('socialSecurityTax').textContent = formatCurrency(socialSecurityTax, currency);
            document.getElementById('medRate').textContent = (medicareRate * 100).toFixed(2);
            document.getElementById('medicareTax').textContent = formatCurrency(medicareTax, currency);
            document.getElementById('totalTaxWithheld').textContent = formatCurrency(totalTax, currency);

            document.getElementById('k401Rate').textContent = (k401Rate * 100).toFixed(1);
            document.getElementById('k401Amount').textContent = formatCurrency(k401Contribution, currency);
            document.getElementById('totalDeductions').textContent = formatCurrency(totalDeductions, currency);

            document.getElementById('grossAmount').textContent = formatCurrency(bonusAmount, currency);
            document.getElementById('taxDeduction').textContent = formatCurrency(totalTax, currency);
            document.getElementById('otherDeductions').textContent = formatCurrency(totalDeductions, currency);
            document.getElementById('finalNetBonus').textContent = formatCurrency(netBonus, currency);

            document.getElementById('totalTaxesPaid').textContent = formatCurrency(totalTax, currency);
            document.getElementById('effectiveTaxRate').textContent = effectiveRate.toFixed(2) + '%';
            document.getElementById('takeHomePercent').textContent = netPercentage.toFixed(2) + '%';
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
            toggleSalaryField();
            calculateBonus();
        });
    </script>
</body>
</html>