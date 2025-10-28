<?php
/**
 * Tax Return Calculator
 * File: tax-return-calculator.php
 * Description: Calculate income tax refund or amount owed (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Return Calculator - Calculate Refund or Owed (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free tax return calculator. Calculate your tax refund or amount owed. Includes deductions and credits. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128221; Tax Return Calculator</h1>
        <p>Calculate your tax refund or amount owed</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Tax Information</h2>
                <form id="taxForm">
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
                        <label for="filingStatus">Filing Status</label>
                        <select id="filingStatus">
                            <option value="single">Single</option>
                            <option value="married">Married Filing Jointly</option>
                            <option value="marriedSeparate">Married Filing Separately</option>
                            <option value="hoh">Head of Household</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #4CAF50; margin: 25px 0 15px;">Income</h3>
                    
                    <div class="form-group">
                        <label for="wages">Wages & Salary (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="wages" value="75000" min="0" step="100" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="otherIncome">Other Income (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="otherIncome" value="0" min="0" step="100">
                        <small>Interest, dividends, capital gains, etc.</small>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Deductions</h3>
                    
                    <div class="form-group">
                        <label for="deductionType">Deduction Type</label>
                        <select id="deductionType">
                            <option value="standard">Standard Deduction</option>
                            <option value="itemized">Itemized Deductions</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="itemizedGroup" style="display: none;">
                        <label for="itemizedAmount">Itemized Deductions (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="itemizedAmount" value="0" min="0" step="100">
                        <small>Mortgage interest, charitable, state taxes, etc.</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Tax Credits</h3>
                    
                    <div class="form-group">
                        <label for="childTaxCredit">Child Tax Credit (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="childTaxCredit" value="0" min="0" step="100">
                        <small>$2,000 per qualifying child</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="otherCredits">Other Tax Credits (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="otherCredits" value="0" min="0" step="100">
                        <small>EV credit, education credit, etc.</small>
                    </div>
                    
                    <h3 style="color: #f44336; margin: 25px 0 15px;">Withholding</h3>
                    
                    <div class="form-group">
                        <label for="federalWithheld">Federal Tax Withheld (<span id="currencyLabel6">$</span>)</label>
                        <input type="number" id="federalWithheld" value="12000" min="0" step="100">
                        <small>From W-2 Box 2</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="estimatedPayments">Estimated Tax Payments (<span id="currencyLabel7">$</span>)</label>
                        <input type="number" id="estimatedPayments" value="0" min="0" step="100">
                        <small>Quarterly payments made</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Tax Return</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Tax Return Summary</h2>
                
                <div class="result-card" id="refundCard">
                    <h3 id="refundTitle">Refund</h3>
                    <div class="amount" id="refundAmount">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Income</h4>
                        <div class="value" id="totalIncome">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Tax Liability</h4>
                        <div class="value" id="taxLiability">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Credits</h4>
                        <div class="value" id="totalCredits">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Effective Tax Rate</h4>
                        <div class="value" id="effectiveTaxRate">0%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Income Summary</h3>
                    <div class="breakdown-item">
                        <span>Wages & Salary</span>
                        <strong id="wagesDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Income</span>
                        <strong id="otherIncomeDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Income</strong></span>
                        <strong id="totalIncomeCalc" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Deductions</h3>
                    <div class="breakdown-item">
                        <span>Filing Status</span>
                        <strong id="filingStatusDisplay">Single</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Deduction Type</span>
                        <strong id="deductionTypeDisplay">Standard</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Deduction Amount</span>
                        <strong id="deductionAmount" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Taxable Income</h3>
                    <div class="breakdown-item">
                        <span>Total Income</span>
                        <strong id="incomeForTaxable">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Deductions</span>
                        <strong id="deductionsTotal" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Taxable Income</strong></span>
                        <strong id="taxableIncome" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Calculation</h3>
                    <div class="breakdown-item">
                        <span>Taxable Income</span>
                        <strong id="taxableForCalc">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax Bracket</span>
                        <strong id="taxBracket">22%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gross Tax Liability</span>
                        <strong id="grossTax" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax Credits</span>
                        <strong id="creditsForCalc" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #f44336; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Tax Liability</strong></span>
                        <strong id="netTaxLiability" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Credits Applied</h3>
                    <div class="breakdown-item">
                        <span>Child Tax Credit</span>
                        <strong id="childCreditDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Credits</span>
                        <strong id="otherCreditsDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Credits</strong></span>
                        <strong id="totalCreditsCalc" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Payments & Withholding</h3>
                    <div class="breakdown-item">
                        <span>Federal Tax Withheld</span>
                        <strong id="withheldDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated Payments</span>
                        <strong id="estimatedDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Payments</strong></span>
                        <strong id="totalPayments" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Final Tax Return</h3>
                    <div class="breakdown-item">
                        <span>Net Tax Liability</span>
                        <strong id="liabilityForReturn" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Payments Made</span>
                        <strong id="paymentsForReturn" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span id="returnLabel"><strong>Refund / Owed</strong></span>
                        <strong id="finalReturn" style="font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Rate Analysis</h3>
                    <div class="breakdown-item">
                        <span>Marginal Tax Rate</span>
                        <strong id="marginalRate">22%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Effective Tax Rate</span>
                        <strong id="effectiveRate">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Avg Tax Per Dollar</span>
                        <strong id="avgTax">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Take-Home %</span>
                        <strong id="takeHomePercent" style="color: #4CAF50;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Standard Deduction 2024</h3>
                    <div class="breakdown-item">
                        <span>Single</span>
                        <strong id="stdSingle">$14,600</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Married Filing Jointly</span>
                        <strong id="stdMarried">$29,200</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Married Filing Separately</span>
                        <strong id="stdMarriedSep">$14,600</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Head of Household</span>
                        <strong id="stdHOH">$21,900</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Withholding Analysis</h3>
                    <div class="breakdown-item">
                        <span>Should Have Withheld</span>
                        <strong id="shouldWithhold">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Actually Withheld</span>
                        <strong id="actualWithhold">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Over/Under Withheld</span>
                        <strong id="withholdDiff">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Withholding Accuracy</span>
                        <strong id="withholdAccuracy">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Tax Return Tips:</strong> File early = get refund faster. E-file = fastest processing. Direct deposit = quicker than check. Large refund = too much withheld (adjust W-4). Owe taxes? Pay by deadline to avoid penalty. Itemize if >standard deduction. Keep receipts for deductions. Max retirement contributions = lower taxes. Tax credits > deductions. Claim all eligible credits. State taxes separate from federal. Extensions = more time to file, not pay. Review before submitting. IRS Free File if income <$73k. Track charitable donations. Consider tax software or CPA.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('taxForm');
        const currencySelect = document.getElementById('currency');
        const deductionTypeSelect = document.getElementById('deductionType');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateTax();
        });

        deductionTypeSelect.addEventListener('change', function() {
            toggleItemizedDeductions();
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
            for (let i = 1; i <= 7; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        function toggleItemizedDeductions() {
            const deductionType = deductionTypeSelect.value;
            const itemizedGroup = document.getElementById('itemizedGroup');
            itemizedGroup.style.display = deductionType === 'itemized' ? 'block' : 'none';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateTax();
        });

        function calculateTax() {
            const wages = parseFloat(document.getElementById('wages').value) || 0;
            const otherIncome = parseFloat(document.getElementById('otherIncome').value) || 0;
            const filingStatus = document.getElementById('filingStatus').value;
            const deductionType = deductionTypeSelect.value;
            const itemizedAmount = parseFloat(document.getElementById('itemizedAmount').value) || 0;
            const childTaxCredit = parseFloat(document.getElementById('childTaxCredit').value) || 0;
            const otherCredits = parseFloat(document.getElementById('otherCredits').value) || 0;
            const federalWithheld = parseFloat(document.getElementById('federalWithheld').value) || 0;
            const estimatedPayments = parseFloat(document.getElementById('estimatedPayments').value) || 0;
            const currency = currencySelect.value;

            // Standard deductions 2024
            const standardDeductions = {
                'single': 14600,
                'married': 29200,
                'marriedSeparate': 14600,
                'hoh': 21900
            };

            // Total income
            const totalIncome = wages + otherIncome;

            // Deduction
            const deduction = deductionType === 'standard' ? standardDeductions[filingStatus] : itemizedAmount;

            // Taxable income
            const taxableIncome = Math.max(0, totalIncome - deduction);

            // Calculate tax (simplified progressive brackets)
            let grossTax = 0;
            let marginalRate = 0;

            // Simplified 2024 tax brackets (single filer)
            if (taxableIncome <= 11600) {
                grossTax = taxableIncome * 0.10;
                marginalRate = 10;
            } else if (taxableIncome <= 47150) {
                grossTax = 1160 + (taxableIncome - 11600) * 0.12;
                marginalRate = 12;
            } else if (taxableIncome <= 100525) {
                grossTax = 5426 + (taxableIncome - 47150) * 0.22;
                marginalRate = 22;
            } else if (taxableIncome <= 191950) {
                grossTax = 17168.50 + (taxableIncome - 100525) * 0.24;
                marginalRate = 24;
            } else if (taxableIncome <= 243725) {
                grossTax = 39110.50 + (taxableIncome - 191950) * 0.32;
                marginalRate = 32;
            } else if (taxableIncome <= 609350) {
                grossTax = 55678.50 + (taxableIncome - 243725) * 0.35;
                marginalRate = 35;
            } else {
                grossTax = 183647.25 + (taxableIncome - 609350) * 0.37;
                marginalRate = 37;
            }

            // Tax credits
            const totalCredits = childTaxCredit + otherCredits;
            const netTaxLiability = Math.max(0, grossTax - totalCredits);

            // Total payments
            const totalPayments = federalWithheld + estimatedPayments;

            // Refund or owed
            const refundOrOwed = totalPayments - netTaxLiability;

            // Tax rates
            const effectiveRate = totalIncome > 0 ? (netTaxLiability / totalIncome) * 100 : 0;
            const avgTaxPerDollar = totalIncome > 0 ? netTaxLiability / totalIncome : 0;
            const takeHomePercent = totalIncome > 0 ? ((totalIncome - netTaxLiability) / totalIncome) * 100 : 0;

            // Withholding analysis
            const shouldWithhold = netTaxLiability;
            const actualWithhold = totalPayments;
            const withholdDiff = actualWithhold - shouldWithhold;
            const withholdAccuracy = shouldWithhold > 0 ? (actualWithhold / shouldWithhold) * 100 : 0;

            // Update card
            const card = document.getElementById('refundCard');
            const title = document.getElementById('refundTitle');
            const amountEl = document.getElementById('refundAmount');
            
            if (refundOrOwed >= 0) {
                card.className = 'result-card success';
                title.textContent = 'Your Refund';
                amountEl.textContent = formatCurrency(refundOrOwed, currency);
                amountEl.style.color = '#4CAF50';
            } else {
                card.className = 'result-card warning';
                title.textContent = 'Amount Owed';
                amountEl.textContent = formatCurrency(Math.abs(refundOrOwed), currency);
                amountEl.style.color = '#f44336';
            }

            // Analysis
            let analysis = `With a total income of ${formatCurrency(totalIncome, currency)} and a ${deductionType === 'standard' ? 'standard' : 'itemized'} deduction of ${formatCurrency(deduction, currency)}, your taxable income is ${formatCurrency(taxableIncome, currency)}. `;
            analysis += `Your gross tax liability is ${formatCurrency(grossTax, currency)}. `;
            
            if (totalCredits > 0) {
                analysis += `After applying ${formatCurrency(totalCredits, currency)} in tax credits, `;
            }
            
            analysis += `your net tax liability is ${formatCurrency(netTaxLiability, currency)} with an effective tax rate of ${effectiveRate.toFixed(1)}%. `;
            
            if (refundOrOwed >= 0) {
                analysis += `Since you paid ${formatCurrency(totalPayments, currency)} through withholding and estimated payments, you will receive a refund of ${formatCurrency(refundOrOwed, currency)}.`;
            } else {
                analysis += `Since you only paid ${formatCurrency(totalPayments, currency)}, you owe ${formatCurrency(Math.abs(refundOrOwed), currency)} in taxes.`;
            }

            // Update UI
            document.getElementById('totalIncome').textContent = formatCurrency(totalIncome, currency);
            document.getElementById('taxLiability').textContent = formatCurrency(netTaxLiability, currency);
            document.getElementById('totalCredits').textContent = formatCurrency(totalCredits, currency);
            document.getElementById('effectiveTaxRate').textContent = effectiveRate.toFixed(1) + '%';

            document.getElementById('wagesDisplay').textContent = formatCurrency(wages, currency);
            document.getElementById('otherIncomeDisplay').textContent = formatCurrency(otherIncome, currency);
            document.getElementById('totalIncomeCalc').textContent = formatCurrency(totalIncome, currency);

            const statusNames = {
                'single': 'Single',
                'married': 'Married Filing Jointly',
                'marriedSeparate': 'Married Filing Separately',
                'hoh': 'Head of Household'
            };
            document.getElementById('filingStatusDisplay').textContent = statusNames[filingStatus];
            document.getElementById('deductionTypeDisplay').textContent = deductionType === 'standard' ? 'Standard Deduction' : 'Itemized Deductions';
            document.getElementById('deductionAmount').textContent = formatCurrency(deduction, currency);

            document.getElementById('incomeForTaxable').textContent = formatCurrency(totalIncome, currency);
            document.getElementById('deductionsTotal').textContent = formatCurrency(deduction, currency);
            document.getElementById('taxableIncome').textContent = formatCurrency(taxableIncome, currency);

            document.getElementById('taxableForCalc').textContent = formatCurrency(taxableIncome, currency);
            document.getElementById('taxBracket').textContent = marginalRate + '% bracket';
            document.getElementById('grossTax').textContent = formatCurrency(grossTax, currency);
            document.getElementById('creditsForCalc').textContent = formatCurrency(totalCredits, currency);
            document.getElementById('netTaxLiability').textContent = formatCurrency(netTaxLiability, currency);

            document.getElementById('childCreditDisplay').textContent = formatCurrency(childTaxCredit, currency);
            document.getElementById('otherCreditsDisplay').textContent = formatCurrency(otherCredits, currency);
            document.getElementById('totalCreditsCalc').textContent = formatCurrency(totalCredits, currency);

            document.getElementById('withheldDisplay').textContent = formatCurrency(federalWithheld, currency);
            document.getElementById('estimatedDisplay').textContent = formatCurrency(estimatedPayments, currency);
            document.getElementById('totalPayments').textContent = formatCurrency(totalPayments, currency);

            document.getElementById('liabilityForReturn').textContent = formatCurrency(netTaxLiability, currency);
            document.getElementById('paymentsForReturn').textContent = formatCurrency(totalPayments, currency);
            document.getElementById('finalReturn').textContent = formatCurrency(Math.abs(refundOrOwed), currency);
            document.getElementById('finalReturn').style.color = refundOrOwed >= 0 ? '#4CAF50' : '#f44336';
            document.getElementById('returnLabel').innerHTML = refundOrOwed >= 0 ? '<strong>Refund</strong>' : '<strong>Amount Owed</strong>';

            document.getElementById('marginalRate').textContent = marginalRate + '%';
            document.getElementById('effectiveRate').textContent = effectiveRate.toFixed(1) + '%';
            document.getElementById('avgTax').textContent = formatCurrency(avgTaxPerDollar, currency);
            document.getElementById('takeHomePercent').textContent = takeHomePercent.toFixed(1) + '%';

            document.getElementById('stdSingle').textContent = formatCurrency(standardDeductions.single, currency);
            document.getElementById('stdMarried').textContent = formatCurrency(standardDeductions.married, currency);
            document.getElementById('stdMarriedSep').textContent = formatCurrency(standardDeductions.marriedSeparate, currency);
            document.getElementById('stdHOH').textContent = formatCurrency(standardDeductions.hoh, currency);

            document.getElementById('shouldWithhold').textContent = formatCurrency(shouldWithhold, currency);
            document.getElementById('actualWithhold').textContent = formatCurrency(actualWithhold, currency);
            document.getElementById('withholdDiff').textContent = formatCurrency(Math.abs(withholdDiff), currency) + (withholdDiff >= 0 ? ' over' : ' under');
            document.getElementById('withholdDiff').style.color = withholdDiff >= 0 ? '#4CAF50' : '#f44336';
            document.getElementById('withholdAccuracy').textContent = withholdAccuracy.toFixed(0) + '%';

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
            toggleItemizedDeductions();
            calculateTax();
        });
    </script>
</body>
</html>