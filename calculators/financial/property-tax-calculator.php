<?php
/**
 * Property Tax Calculator
 * File: property-tax-calculator.php
 * Description: Calculate annual property taxes (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Tax Calculator - Calculate Annual Property Taxes (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free property tax calculator. Calculate annual property taxes based on assessed value and tax rate. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#127969; Property Tax Calculator</h1>
        <p>Calculate your annual property taxes</p>
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
                <h2>Property Details</h2>
                <form id="propertyTaxForm">
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
                        <label for="propertyValue">Property Value (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="propertyValue" value="300000" min="10000" step="10000" required>
                        <small>Market or assessed value</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="assessmentRatio">Assessment Ratio (%)</label>
                        <input type="number" id="assessmentRatio" value="100" min="1" max="100" step="1">
                        <small>% of market value used for tax (usually 100%)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="taxRate">Property Tax Rate (%)</label>
                        <input type="number" id="taxRate" value="1.2" min="0" max="10" step="0.1" required>
                        <small>Annual tax rate (US avg: 1.1%, UK: 0.4-3%, India: 0.2-0.3%)</small>
                    </div>
                    
                    <h3 style="color: #4CAF50; margin: 25px 0 15px;">Exemptions & Deductions</h3>
                    
                    <div class="form-group">
                        <label for="homesteadExemption">Homestead Exemption (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="homesteadExemption" value="25000" min="0" step="1000">
                        <small>Primary residence exemption</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="seniorExemption">Senior Citizen Exemption (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="seniorExemption" value="0" min="0" step="1000">
                        <small>Age 65+ exemption (if applicable)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="otherExemptions">Other Exemptions (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="otherExemptions" value="0" min="0" step="1000">
                        <small>Veteran, disability, etc.</small>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Additional Charges</h3>
                    
                    <div class="form-group">
                        <label for="schoolTax">School Tax (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="schoolTax" value="500" min="0" step="50">
                        <small>Separate school district tax</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="specialAssessments">Special Assessments (<span id="currencyLabel6">$</span>)</label>
                        <input type="number" id="specialAssessments" value="0" min="0" step="50">
                        <small>HOA, improvements, etc.</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Property Tax</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Tax Summary</h2>
                
                <div class="result-card warning">
                    <h3>Annual Property Tax</h3>
                    <div class="amount" id="annualTax">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Monthly Tax</h4>
                        <div class="value" id="monthlyTax">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Taxable Value</h4>
                        <div class="value" id="taxableValue">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Exemptions</h4>
                        <div class="value" id="totalExemptions">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Effective Tax Rate</h4>
                        <div class="value" id="effectiveRate">0%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Property Valuation</h3>
                    <div class="breakdown-item">
                        <span>Property Value</span>
                        <strong id="valueDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Assessment Ratio</span>
                        <strong id="ratioDisplay">100%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Assessed Value</span>
                        <strong id="assessedValue" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Property Tax Rate</span>
                        <strong id="rateDisplay">1.2%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Exemptions Applied</h3>
                    <div class="breakdown-item">
                        <span>Homestead Exemption</span>
                        <strong id="homesteadDisplay" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Senior Citizen Exemption</span>
                        <strong id="seniorDisplay" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Exemptions</span>
                        <strong id="otherExemptionsDisplay" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Exemptions</strong></span>
                        <strong id="totalExemptionsSum" style="color: #4CAF50; font-size: 1.1em;">-$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Calculation</h3>
                    <div class="breakdown-item">
                        <span>Assessed Value</span>
                        <strong id="assessedValueCalc">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Exemptions</span>
                        <strong id="exemptionsCalc" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Taxable Value</span>
                        <strong id="taxableValueCalc" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax Rate</span>
                        <strong id="taxRateCalc">1.2%</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #f44336; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Base Property Tax</strong></span>
                        <strong id="baseTax" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Additional Charges</h3>
                    <div class="breakdown-item">
                        <span>School Tax</span>
                        <strong id="schoolTaxDisplay" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Special Assessments</span>
                        <strong id="specialAssessmentsDisplay" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #FF9800; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Additional Charges</strong></span>
                        <strong id="totalCharges" style="color: #FF9800; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Annual Tax</h3>
                    <div class="breakdown-item">
                        <span>Base Property Tax</span>
                        <strong id="baseTaxTotal" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>School Tax</span>
                        <strong id="schoolTaxTotal" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Special Assessments</span>
                        <strong id="specialTotal" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Annual Property Tax</strong></span>
                        <strong id="totalAnnualTax" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Payment Schedule</h3>
                    <div class="breakdown-item">
                        <span>Annual Tax</span>
                        <strong id="annualPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Semi-Annual Payment</span>
                        <strong id="semiAnnualPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Quarterly Payment</span>
                        <strong id="quarterlyPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="monthlyPayment" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Daily Cost</span>
                        <strong id="dailyCost">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Rate Analysis</h3>
                    <div class="breakdown-item">
                        <span>Nominal Tax Rate</span>
                        <strong id="nominalRate">1.2%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Effective Tax Rate</span>
                        <strong id="effectiveTaxRate">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax Per $1,000</span>
                        <strong id="taxPer1000">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax as % of Property Value</span>
                        <strong id="taxPercent">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>10-Year Projection</h3>
                    <div class="breakdown-item">
                        <span>Current Annual Tax</span>
                        <strong id="current10Year">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Assuming 3% Annual Increase</span>
                        <strong id="increase10Year">$0 in 10 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Paid Over 10 Years</span>
                        <strong id="total10Year" style="color: #f44336;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Property Tax Tips:</strong> Taxes vary widely by location. Challenge assessment if value seems high. Homestead exemption = primary residence savings. Senior/veteran exemptions available in many areas. Taxes often escrowed in mortgage. Appeal before deadline. Tax rate ≠ tax bill. Improvements increase assessed value. Check for errors in assessment. Exemptions must be applied for. Rates change annually. Budget for increases. Some states cap increases. Transfer triggers reassessment. Keep records of exemptions.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('propertyTaxForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculatePropertyTax();
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
            calculatePropertyTax();
        });

        function calculatePropertyTax() {
            const propertyValue = parseFloat(document.getElementById('propertyValue').value) || 0;
            const assessmentRatio = parseFloat(document.getElementById('assessmentRatio').value) / 100 || 1;
            const taxRate = parseFloat(document.getElementById('taxRate').value) / 100 || 0;
            const homesteadExemption = parseFloat(document.getElementById('homesteadExemption').value) || 0;
            const seniorExemption = parseFloat(document.getElementById('seniorExemption').value) || 0;
            const otherExemptions = parseFloat(document.getElementById('otherExemptions').value) || 0;
            const schoolTax = parseFloat(document.getElementById('schoolTax').value) || 0;
            const specialAssessments = parseFloat(document.getElementById('specialAssessments').value) || 0;
            const currency = currencySelect.value;

            // Calculations
            const assessedValue = propertyValue * assessmentRatio;
            const totalExemptions = homesteadExemption + seniorExemption + otherExemptions;
            const taxableValue = Math.max(0, assessedValue - totalExemptions);
            const baseTax = taxableValue * taxRate;
            const totalAdditionalCharges = schoolTax + specialAssessments;
            const annualTax = baseTax + totalAdditionalCharges;

            // Payment schedules
            const monthlyTax = annualTax / 12;
            const semiAnnualPayment = annualTax / 2;
            const quarterlyPayment = annualTax / 4;
            const dailyCost = annualTax / 365;

            // Rates
            const effectiveRate = propertyValue > 0 ? (annualTax / propertyValue) * 100 : 0;
            const taxPer1000 = (annualTax / propertyValue) * 1000;
            const taxPercent = effectiveRate;

            // 10-year projection
            const annualIncrease = 0.03; // 3% annual increase
            const tax10Year = annualTax * Math.pow(1 + annualIncrease, 10);
            let total10Year = 0;
            for (let year = 1; year <= 10; year++) {
                total10Year += annualTax * Math.pow(1 + annualIncrease, year - 1);
            }

            // Analysis
            let analysis = `Your property valued at ${formatCurrency(propertyValue, currency)} has an assessed value of ${formatCurrency(assessedValue, currency)}. `;
            analysis += `After applying ${formatCurrency(totalExemptions, currency)} in exemptions, your taxable value is ${formatCurrency(taxableValue, currency)}. `;
            analysis += `At a ${(taxRate * 100).toFixed(2)}% tax rate, your base property tax is ${formatCurrency(baseTax, currency)}. `;
            if (totalAdditionalCharges > 0) {
                analysis += `Including ${formatCurrency(totalAdditionalCharges, currency)} in additional charges, `;
            }
            analysis += `your total annual property tax is ${formatCurrency(annualTax, currency)}, or ${formatCurrency(monthlyTax, currency)} per month.`;

            // Update UI
            document.getElementById('annualTax').textContent = formatCurrency(annualTax, currency);
            document.getElementById('monthlyTax').textContent = formatCurrency(monthlyTax, currency);
            document.getElementById('taxableValue').textContent = formatCurrency(taxableValue, currency);
            document.getElementById('totalExemptions').textContent = formatCurrency(totalExemptions, currency);
            document.getElementById('effectiveRate').textContent = effectiveRate.toFixed(2) + '%';

            document.getElementById('valueDisplay').textContent = formatCurrency(propertyValue, currency);
            document.getElementById('ratioDisplay').textContent = (assessmentRatio * 100).toFixed(0) + '%';
            document.getElementById('assessedValue').textContent = formatCurrency(assessedValue, currency);
            document.getElementById('rateDisplay').textContent = (taxRate * 100).toFixed(2) + '% per year';

            document.getElementById('homesteadDisplay').textContent = formatCurrency(homesteadExemption, currency);
            document.getElementById('seniorDisplay').textContent = formatCurrency(seniorExemption, currency);
            document.getElementById('otherExemptionsDisplay').textContent = formatCurrency(otherExemptions, currency);
            document.getElementById('totalExemptionsSum').textContent = formatCurrency(totalExemptions, currency);

            document.getElementById('assessedValueCalc').textContent = formatCurrency(assessedValue, currency);
            document.getElementById('exemptionsCalc').textContent = formatCurrency(totalExemptions, currency);
            document.getElementById('taxableValueCalc').textContent = formatCurrency(taxableValue, currency);
            document.getElementById('taxRateCalc').textContent = (taxRate * 100).toFixed(2) + '%';
            document.getElementById('baseTax').textContent = formatCurrency(baseTax, currency);

            document.getElementById('schoolTaxDisplay').textContent = formatCurrency(schoolTax, currency);
            document.getElementById('specialAssessmentsDisplay').textContent = formatCurrency(specialAssessments, currency);
            document.getElementById('totalCharges').textContent = formatCurrency(totalAdditionalCharges, currency);

            document.getElementById('baseTaxTotal').textContent = formatCurrency(baseTax, currency);
            document.getElementById('schoolTaxTotal').textContent = formatCurrency(schoolTax, currency);
            document.getElementById('specialTotal').textContent = formatCurrency(specialAssessments, currency);
            document.getElementById('totalAnnualTax').textContent = formatCurrency(annualTax, currency);

            document.getElementById('annualPayment').textContent = formatCurrency(annualTax, currency);
            document.getElementById('semiAnnualPayment').textContent = formatCurrency(semiAnnualPayment, currency);
            document.getElementById('quarterlyPayment').textContent = formatCurrency(quarterlyPayment, currency);
            document.getElementById('monthlyPayment').textContent = formatCurrency(monthlyTax, currency);
            document.getElementById('dailyCost').textContent = formatCurrency(dailyCost, currency);

            document.getElementById('nominalRate').textContent = (taxRate * 100).toFixed(2) + '%';
            document.getElementById('effectiveTaxRate').textContent = effectiveRate.toFixed(2) + '%';
            document.getElementById('taxPer1000').textContent = formatCurrency(taxPer1000, currency);
            document.getElementById('taxPercent').textContent = taxPercent.toFixed(2) + '%';

            document.getElementById('current10Year').textContent = formatCurrency(annualTax, currency);
            document.getElementById('increase10Year').textContent = formatCurrency(tax10Year, currency) + ' in 10 years';
            document.getElementById('total10Year').textContent = formatCurrency(total10Year, currency);

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
            calculatePropertyTax();
        });
    </script>
</body>
</html>