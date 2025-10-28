<?php
/**
 * Paycheck Calculator
 * File: paycheck-calculator.php
 * Description: Calculate net pay after taxes and deductions (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paycheck Calculator - Calculate Take-Home Pay (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free paycheck calculator. Calculate net pay after federal taxes, state taxes, and deductions. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128181; Paycheck Calculator</h1>
        <p>Calculate your take-home pay after taxes</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Paycheck Details</h2>
                <form id="paycheckForm">
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
                        <label for="payPeriod">Pay Period</label>
                        <select id="payPeriod">
                            <option value="monthly">Monthly</option>
                            <option value="biweekly">Bi-Weekly (Every 2 weeks)</option>
                            <option value="weekly">Weekly</option>
                            <option value="semimonthly">Semi-Monthly (Twice a month)</option>
                            <option value="annual">Annual (Yearly)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="grossPay">Gross Pay (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="grossPay" value="5000" min="0" step="100" required>
                        <small id="payPeriodHelp">Per pay period</small>
                    </div>
                    
                    <h3 style="color: #f44336; margin: 25px 0 15px;">Taxes</h3>
                    
                    <div class="form-group">
                        <label for="federalTax">Federal/Income Tax (%)</label>
                        <input type="number" id="federalTax" value="22" min="0" max="50" step="0.5">
                        <small>US: 10-37%, India: 5-30%, UK: 20-45%</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="stateTax">State/Regional Tax (%)</label>
                        <input type="number" id="stateTax" value="5" min="0" max="20" step="0.5">
                        <small>Varies by state/region</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="socialSecurity">Social Security/FICA (%)</label>
                        <input type="number" id="socialSecurity" value="6.2" min="0" max="15" step="0.1">
                        <small>US: 6.2%, India: PF 12%</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="medicare">Medicare/Health (%)</label>
                        <input type="number" id="medicare" value="1.45" min="0" max="10" step="0.1">
                        <small>US: 1.45%, varies elsewhere</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Deductions</h3>
                    
                    <div class="form-group">
                        <label for="retirement401k">401k/Retirement (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="retirement401k" value="500" min="0" step="50">
                        <small>Pre-tax contribution</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="healthInsurance">Health Insurance (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="healthInsurance" value="150" min="0" step="10">
                    </div>
                    
                    <div class="form-group">
                        <label for="otherDeductions">Other Deductions (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="otherDeductions" value="0" min="0" step="10">
                        <small>HSA, FSA, etc.</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Paycheck</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Paycheck Summary</h2>
                
                <div class="result-card success">
                    <h3>Net Pay (Take-Home)</h3>
                    <div class="amount" id="netPay">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Gross Pay</h4>
                        <div class="value" id="grossPayDisplay">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Taxes</h4>
                        <div class="value" id="totalTaxes">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Deductions</h4>
                        <div class="value" id="totalDeductions">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Effective Tax Rate</h4>
                        <div class="value" id="effectiveTaxRate">0%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Gross Pay</h3>
                    <div class="breakdown-item">
                        <span>Pay Period</span>
                        <strong id="periodDisplay">Monthly</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gross Pay (This Period)</span>
                        <strong id="grossThisPeriod" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Gross Salary</span>
                        <strong id="annualGross" style="color: #667eea;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Federal/Income Tax</span>
                        <strong id="federalTaxAmount" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>State/Regional Tax</span>
                        <strong id="stateTaxAmount" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Social Security/FICA</span>
                        <strong id="socialSecurityAmount" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Medicare/Health</span>
                        <strong id="medicareAmount" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #f44336; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Taxes</strong></span>
                        <strong id="totalTaxesSum" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Deductions Breakdown</h3>
                    <div class="breakdown-item">
                        <span>401k/Retirement</span>
                        <strong id="retirement401kAmount" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Health Insurance</span>
                        <strong id="healthInsuranceAmount" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Deductions</span>
                        <strong id="otherDeductionsAmount" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #FF9800; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Deductions</strong></span>
                        <strong id="totalDeductionsSum" style="color: #FF9800; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Net Pay Calculation</h3>
                    <div class="breakdown-item">
                        <span>Gross Pay</span>
                        <strong id="grossPayCalc" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Taxes</span>
                        <strong id="taxesCalc" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Deductions</span>
                        <strong id="deductionsCalc" style="color: #FF9800;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Pay (Take-Home)</strong></span>
                        <strong id="netPayCalc" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>% of Gross Pay</span>
                        <strong id="netPayPercent">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Annual Projections</h3>
                    <div class="breakdown-item">
                        <span>Annual Gross Salary</span>
                        <strong id="annualGrossProjection">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Taxes</span>
                        <strong id="annualTaxes" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Deductions</span>
                        <strong id="annualDeductions" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Net Pay</span>
                        <strong id="annualNet" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Pay Period Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Pay Periods Per Year</span>
                        <strong id="periodsPerYear">12</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gross Pay Per Period</span>
                        <strong id="grossPerPeriod">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Net Pay Per Period</span>
                        <strong id="netPerPeriod" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekly Net Pay</span>
                        <strong id="weeklyNet">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hourly Net Pay (40hrs/week)</span>
                        <strong id="hourlyNet">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Analysis</h3>
                    <div class="breakdown-item">
                        <span>Effective Tax Rate</span>
                        <strong id="effectiveRate" style="color: #f44336;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Marginal Tax Rate</span>
                        <strong id="marginalRate">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Withholding %</span>
                        <strong id="totalWithholding">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Take-Home %</span>
                        <strong id="takeHomePercent" style="color: #4CAF50;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Paycheck Tips:</strong> Check tax withholdings annually. Update W-4 form when life changes. Max 401k contribution = free money + tax savings. HSA/FSA = tax-free medical expenses. Pre-tax deductions reduce taxable income. Understand gross vs net pay. Budget on net pay, not gross. Tax refund = too much withheld. Owe taxes? Adjust withholdings. State taxes vary widely. FICA = Social Security + Medicare. Track year-to-date totals. Review pay stub regularly. Employer match? Don't miss it!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('paycheckForm');
        const currencySelect = document.getElementById('currency');
        const payPeriodSelect = document.getElementById('payPeriod');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculatePaycheck();
        });

        payPeriodSelect.addEventListener('change', function() {
            updatePayPeriodHelp();
            calculatePaycheck();
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

        function updatePayPeriodHelp() {
            const period = payPeriodSelect.value;
            const periodNames = {
                'monthly': 'Per month',
                'biweekly': 'Every 2 weeks',
                'weekly': 'Per week',
                'semimonthly': 'Twice per month',
                'annual': 'Per year'
            };
            document.getElementById('payPeriodHelp').textContent = periodNames[period];
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculatePaycheck();
        });

        function calculatePaycheck() {
            const grossPay = parseFloat(document.getElementById('grossPay').value) || 0;
            const federalTax = parseFloat(document.getElementById('federalTax').value) / 100 || 0;
            const stateTax = parseFloat(document.getElementById('stateTax').value) / 100 || 0;
            const socialSecurity = parseFloat(document.getElementById('socialSecurity').value) / 100 || 0;
            const medicare = parseFloat(document.getElementById('medicare').value) / 100 || 0;
            const retirement401k = parseFloat(document.getElementById('retirement401k').value) || 0;
            const healthInsurance = parseFloat(document.getElementById('healthInsurance').value) || 0;
            const otherDeductions = parseFloat(document.getElementById('otherDeductions').value) || 0;
            const payPeriod = payPeriodSelect.value;
            const currency = currencySelect.value;

            // Calculate periods per year
            const periodsPerYear = {
                'monthly': 12,
                'biweekly': 26,
                'weekly': 52,
                'semimonthly': 24,
                'annual': 1
            }[payPeriod];

            // Calculate taxable income (after pre-tax deductions)
            const taxableIncome = grossPay - retirement401k;

            // Calculate taxes
            const federalTaxAmount = taxableIncome * federalTax;
            const stateTaxAmount = taxableIncome * stateTax;
            const socialSecurityAmount = grossPay * socialSecurity;
            const medicareAmount = grossPay * medicare;
            const totalTaxes = federalTaxAmount + stateTaxAmount + socialSecurityAmount + medicareAmount;

            // Calculate deductions
            const totalDeductions = retirement401k + healthInsurance + otherDeductions;

            // Calculate net pay
            const netPay = grossPay - totalTaxes - totalDeductions;

            // Annual calculations
            const annualGross = grossPay * periodsPerYear;
            const annualTaxes = totalTaxes * periodsPerYear;
            const annualDeductionsTotal = totalDeductions * periodsPerYear;
            const annualNet = netPay * periodsPerYear;

            // Percentages
            const effectiveTaxRate = grossPay > 0 ? (totalTaxes / grossPay) * 100 : 0;
            const netPayPercent = grossPay > 0 ? (netPay / grossPay) * 100 : 0;
            const marginalRate = (federalTax + stateTax) * 100;
            const totalWithholding = grossPay > 0 ? ((totalTaxes + totalDeductions) / grossPay) * 100 : 0;

            // Weekly and hourly
            const weeklyNet = annualNet / 52;
            const hourlyNet = weeklyNet / 40;

            // Analysis
            let analysis = `From your gross pay of ${formatCurrency(grossPay, currency)} per pay period, you take home ${formatCurrency(netPay, currency)} after ${formatCurrency(totalTaxes, currency)} in taxes and ${formatCurrency(totalDeductions, currency)} in deductions. `;
            analysis += `This represents ${netPayPercent.toFixed(1)}% of your gross pay. `;
            analysis += `Your effective tax rate is ${effectiveTaxRate.toFixed(1)}%. `;
            analysis += `Annually, you earn ${formatCurrency(annualGross, currency)} gross and take home ${formatCurrency(annualNet, currency)} net.`;

            // Update UI
            document.getElementById('netPay').textContent = formatCurrency(netPay, currency);
            document.getElementById('grossPayDisplay').textContent = formatCurrency(grossPay, currency);
            document.getElementById('totalTaxes').textContent = formatCurrency(totalTaxes, currency);
            document.getElementById('totalDeductions').textContent = formatCurrency(totalDeductions, currency);
            document.getElementById('effectiveTaxRate').textContent = effectiveTaxRate.toFixed(1) + '%';

            const periodNames = {
                'monthly': 'Monthly',
                'biweekly': 'Bi-Weekly',
                'weekly': 'Weekly',
                'semimonthly': 'Semi-Monthly',
                'annual': 'Annual'
            };
            document.getElementById('periodDisplay').textContent = periodNames[payPeriod];
            document.getElementById('grossThisPeriod').textContent = formatCurrency(grossPay, currency);
            document.getElementById('annualGross').textContent = formatCurrency(annualGross, currency);

            document.getElementById('federalTaxAmount').textContent = formatCurrency(federalTaxAmount, currency);
            document.getElementById('stateTaxAmount').textContent = formatCurrency(stateTaxAmount, currency);
            document.getElementById('socialSecurityAmount').textContent = formatCurrency(socialSecurityAmount, currency);
            document.getElementById('medicareAmount').textContent = formatCurrency(medicareAmount, currency);
            document.getElementById('totalTaxesSum').textContent = formatCurrency(totalTaxes, currency);

            document.getElementById('retirement401kAmount').textContent = formatCurrency(retirement401k, currency);
            document.getElementById('healthInsuranceAmount').textContent = formatCurrency(healthInsurance, currency);
            document.getElementById('otherDeductionsAmount').textContent = formatCurrency(otherDeductions, currency);
            document.getElementById('totalDeductionsSum').textContent = formatCurrency(totalDeductions, currency);

            document.getElementById('grossPayCalc').textContent = formatCurrency(grossPay, currency);
            document.getElementById('taxesCalc').textContent = formatCurrency(totalTaxes, currency);
            document.getElementById('deductionsCalc').textContent = formatCurrency(totalDeductions, currency);
            document.getElementById('netPayCalc').textContent = formatCurrency(netPay, currency);
            document.getElementById('netPayPercent').textContent = netPayPercent.toFixed(1) + '% of gross';

            document.getElementById('annualGrossProjection').textContent = formatCurrency(annualGross, currency);
            document.getElementById('annualTaxes').textContent = formatCurrency(annualTaxes, currency);
            document.getElementById('annualDeductions').textContent = formatCurrency(annualDeductionsTotal, currency);
            document.getElementById('annualNet').textContent = formatCurrency(annualNet, currency);

            document.getElementById('periodsPerYear').textContent = periodsPerYear + ' periods';
            document.getElementById('grossPerPeriod').textContent = formatCurrency(grossPay, currency);
            document.getElementById('netPerPeriod').textContent = formatCurrency(netPay, currency);
            document.getElementById('weeklyNet').textContent = formatCurrency(weeklyNet, currency);
            document.getElementById('hourlyNet').textContent = formatCurrency(hourlyNet, currency) + '/hr';

            document.getElementById('effectiveRate').textContent = effectiveTaxRate.toFixed(1) + '%';
            document.getElementById('marginalRate').textContent = marginalRate.toFixed(1) + '%';
            document.getElementById('totalWithholding').textContent = totalWithholding.toFixed(1) + '%';
            document.getElementById('takeHomePercent').textContent = netPayPercent.toFixed(1) + '%';

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
            updatePayPeriodHelp();
            calculatePaycheck();
        });
    </script>
</body>
</html>