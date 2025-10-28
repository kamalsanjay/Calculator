<?php
/**
 * VA Mortgage Calculator
 * File: va-mortgage-calculator.php
 * Description: Calculate VA loan payments with funding fee (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VA Mortgage Calculator - Calculate VA Loan Payments (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free VA mortgage calculator. Calculate VA loan payments with funding fee. No down payment required. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#127968; VA Mortgage Calculator</h1>
        <p>Calculate VA loan payments for veterans</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>VA Loan Details</h2>
                <form id="vaLoanForm">
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
                        <label for="homePrice">Home Price (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="homePrice" value="350000" min="10000" step="1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="downPayment">Down Payment (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="downPayment" value="0" min="0" step="1000">
                        <small>Optional - VA loans allow 0% down</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% APR)</label>
                        <input type="number" id="interestRate" value="6.5" min="0" max="15" step="0.125" required>
                        <small>VA rates typically 0.25-0.5% lower</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Years)</label>
                        <input type="number" id="loanTerm" value="30" min="5" max="30" step="1" required>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">VA Funding Fee</h3>
                    
                    <div class="form-group">
                        <label for="vaLoanType">Loan Type</label>
                        <select id="vaLoanType">
                            <option value="firstTime">First-Time Use</option>
                            <option value="subsequent">Subsequent Use</option>
                            <option value="regular">Regular Military</option>
                            <option value="reserves">Reserves/National Guard</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="disability">Service-Connected Disability?</label>
                        <select id="disability">
                            <option value="no">No</option>
                            <option value="yes">Yes (Fee Waived)</option>
                        </select>
                        <small>10% or more = fee waived</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Additional Costs</h3>
                    
                    <div class="form-group">
                        <label for="propertyTax">Annual Property Tax (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="propertyTax" value="4200" min="0" step="100">
                    </div>
                    
                    <div class="form-group">
                        <label for="homeInsurance">Annual Home Insurance (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="homeInsurance" value="1200" min="0" step="100">
                    </div>
                    
                    <div class="form-group">
                        <label for="hoaFees">Monthly HOA Fees (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="hoaFees" value="0" min="0" step="25">
                    </div>
                    
                    <button type="submit" class="btn">Calculate VA Loan</button>
                </form>
            </div>

            <div class="results-section">
                <h2>VA Loan Summary</h2>
                
                <div class="result-card info">
                    <h3>Total Monthly Payment</h3>
                    <div class="amount" id="totalMonthlyPayment">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Principal & Interest</h4>
                        <div class="value" id="principalInterest">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>VA Funding Fee</h4>
                        <div class="value" id="fundingFee">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Loan Amount</h4>
                        <div class="value" id="loanAmount">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Interest</h4>
                        <div class="value" id="totalInterest">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Home Purchase</h3>
                    <div class="breakdown-item">
                        <span>Home Price</span>
                        <strong id="homePriceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="downPaymentDisplay" style="color: #4CAF50;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment %</span>
                        <strong id="downPaymentPercent">0%</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Base Loan Amount</strong></span>
                        <strong id="baseLoanAmount" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>VA Funding Fee</h3>
                    <div class="breakdown-item">
                        <span>Loan Type</span>
                        <strong id="loanTypeDisplay">First-Time Use</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Funding Fee Rate</span>
                        <strong id="fundingFeeRate">2.15%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Funding Fee Amount</span>
                        <strong id="fundingFeeAmount" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fee Financed?</span>
                        <strong id="feeFinanced">Yes (Added to Loan)</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Loan Amount</strong></span>
                        <strong id="totalLoanAmount" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Monthly Payment Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Principal & Interest</span>
                        <strong id="piPayment" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Property Tax</span>
                        <strong id="taxPayment" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Home Insurance</span>
                        <strong id="insurancePayment" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>HOA Fees</span>
                        <strong id="hoaPayment" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Monthly Payment</strong></span>
                        <strong id="totalPayment" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>VA Loan Benefits</h3>
                    <div class="breakdown-item">
                        <span>No Down Payment Required</span>
                        <strong style="color: #4CAF50;">✓ Yes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>No PMI (Mortgage Insurance)</span>
                        <strong style="color: #4CAF50;">✓ Yes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lower Interest Rates</span>
                        <strong style="color: #4CAF50;">✓ Typically 0.25-0.5% lower</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Funding Fee Waived?</span>
                        <strong id="feeWaived">No</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Cost Over Life of Loan</h3>
                    <div class="breakdown-item">
                        <span>Total Principal Paid</span>
                        <strong id="totalPrincipal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest Paid</span>
                        <strong id="totalInterestPaid" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>VA Funding Fee</span>
                        <strong id="fundingFeeCost" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Property Tax (30 years)</span>
                        <strong id="totalTax">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Insurance (30 years)</span>
                        <strong id="totalInsurance">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Cost of Homeownership</strong></span>
                        <strong id="totalCost" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>VA vs Conventional Comparison</h3>
                    <div class="breakdown-item">
                        <span>VA Loan (No PMI)</span>
                        <strong id="vaPayment" style="color: #4CAF50;">$0/month</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Conventional (with PMI)</span>
                        <strong id="conventionalPayment">$0/month</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Savings (VA)</span>
                        <strong id="monthlySavings" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Savings</span>
                        <strong id="annualSavings" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>30-Year Savings</span>
                        <strong id="lifetimeSavings" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Funding Fee Rates 2024</h3>
                    <div class="breakdown-item">
                        <span>First-Time Use (0% down)</span>
                        <strong id="feeFirst">2.15%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Subsequent Use (0% down)</span>
                        <strong id="feeSubsequent">3.30%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Reserves/Guard (0% down)</span>
                        <strong id="feeReserves">2.15%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>With 5-10% Down</span>
                        <strong id="fee5Down">1.50%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>With 10%+ Down</span>
                        <strong id="fee10Down">1.25%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Affordability Analysis</h3>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="paymentForAfford">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Payment</span>
                        <strong id="annualPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Income Needed (28% rule)</span>
                        <strong id="incomeNeeded" style="color: #667eea;">$0/year</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Payment as % of $80k Salary</span>
                        <strong id="percent80k">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>VA Loan Tips:</strong> No down payment required. No PMI ever. Funding fee typically 1.25-3.30% (can be financed). Disabled veterans = fee waived. Lower rates than conventional. Must have COE (Certificate of Eligibility). Can use multiple times. Assumable by qualified buyers. No prepayment penalty. Seller can pay closing costs. County loan limits apply (except for full entitlement). Primary residence only. Must meet occupancy requirements. Can refinance to VA IRRRL. Competitive with FHA/conventional. Credit score matters. Get pre-approved first.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('vaLoanForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateVALoan();
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
            calculateVALoan();
        });

        function calculateVALoan() {
            const homePrice = parseFloat(document.getElementById('homePrice').value) || 0;
            const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
            const annualRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0;
            const years = parseInt(document.getElementById('loanTerm').value) || 30;
            const vaLoanType = document.getElementById('vaLoanType').value;
            const disability = document.getElementById('disability').value;
            const propertyTax = parseFloat(document.getElementById('propertyTax').value) || 0;
            const homeInsurance = parseFloat(document.getElementById('homeInsurance').value) || 0;
            const hoaFees = parseFloat(document.getElementById('hoaFees').value) || 0;
            const currency = currencySelect.value;

            // Calculate base loan amount
            const baseLoanAmount = homePrice - downPayment;
            const downPaymentPercent = homePrice > 0 ? (downPayment / homePrice) * 100 : 0;

            // VA Funding Fee rates (2024)
            let fundingFeeRate = 0;
            if (disability === 'no') {
                if (downPaymentPercent === 0) {
                    fundingFeeRate = vaLoanType === 'firstTime' ? 0.0215 : 0.033;
                } else if (downPaymentPercent >= 10) {
                    fundingFeeRate = 0.0125;
                } else if (downPaymentPercent >= 5) {
                    fundingFeeRate = 0.015;
                } else {
                    fundingFeeRate = 0.0215;
                }
            }

            const fundingFee = baseLoanAmount * fundingFeeRate;
            const totalLoanAmount = baseLoanAmount + fundingFee;

            // Monthly mortgage payment (P&I)
            const monthlyRate = annualRate / 12;
            const months = years * 12;
            let piPayment = 0;
            if (monthlyRate > 0) {
                piPayment = (totalLoanAmount * monthlyRate * Math.pow(1 + monthlyRate, months)) /
                           (Math.pow(1 + monthlyRate, months) - 1);
            } else {
                piPayment = totalLoanAmount / months;
            }

            // Additional monthly costs
            const monthlyTax = propertyTax / 12;
            const monthlyInsurance = homeInsurance / 12;
            const totalMonthlyPayment = piPayment + monthlyTax + monthlyInsurance + hoaFees;

            // Total costs over life of loan
            const totalPaid = piPayment * months;
            const totalInterest = totalPaid - totalLoanAmount;
            const totalTax = propertyTax * years;
            const totalInsurance = homeInsurance * years;
            const totalCost = totalPaid + totalTax + totalInsurance + downPayment;

            // VA vs Conventional comparison (conventional with 0.5% PMI)
            const conventionalPMI = (baseLoanAmount * 0.005) / 12; // 0.5% annual PMI
            const conventionalPayment = totalMonthlyPayment + conventionalPMI;
            const monthlySavings = conventionalPMI;
            const annualSavings = monthlySavings * 12;
            const lifetimeSavings = monthlySavings * 120; // PMI for ~10 years

            // Affordability
            const annualPayment = totalMonthlyPayment * 12;
            const incomeNeeded = annualPayment / 0.28; // 28% rule
            const percent80k = (totalMonthlyPayment * 12 / 80000) * 100;

            // Loan type names
            const loanTypeNames = {
                'firstTime': 'First-Time Use',
                'subsequent': 'Subsequent Use',
                'regular': 'Regular Military',
                'reserves': 'Reserves/National Guard'
            };

            // Analysis
            let analysis = `With a VA loan of ${formatCurrency(homePrice, currency)}`;
            if (downPayment > 0) {
                analysis += ` and ${formatCurrency(downPayment, currency)} down (${downPaymentPercent.toFixed(1)}%)`;
            } else {
                analysis += ` with no down payment`;
            }
            analysis += `, your loan amount is ${formatCurrency(baseLoanAmount, currency)}. `;
            
            if (disability === 'yes') {
                analysis += `Because you have a service-connected disability, your VA funding fee is waived. `;
            } else {
                analysis += `The VA funding fee of ${(fundingFeeRate * 100).toFixed(2)}% (${formatCurrency(fundingFee, currency)}) is added to your loan, making the total loan ${formatCurrency(totalLoanAmount, currency)}. `;
            }
            
            analysis += `At ${(annualRate * 100).toFixed(2)}% interest for ${years} years, your monthly principal and interest payment is ${formatCurrency(piPayment, currency)}. `;
            analysis += `Including property tax, insurance, and HOA fees, your total monthly payment is ${formatCurrency(totalMonthlyPayment, currency)}. `;
            analysis += `The VA loan saves you approximately ${formatCurrency(monthlySavings, currency)}/month compared to a conventional loan with PMI.`;

            // Update UI
            document.getElementById('totalMonthlyPayment').textContent = formatCurrency(totalMonthlyPayment, currency);
            document.getElementById('principalInterest').textContent = formatCurrency(piPayment, currency);
            document.getElementById('fundingFee').textContent = disability === 'yes' ? 'WAIVED' : formatCurrency(fundingFee, currency);
            document.getElementById('loanAmount').textContent = formatCurrency(totalLoanAmount, currency);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest, currency);

            document.getElementById('homePriceDisplay').textContent = formatCurrency(homePrice, currency);
            document.getElementById('downPaymentDisplay').textContent = formatCurrency(downPayment, currency);
            document.getElementById('downPaymentPercent').textContent = downPaymentPercent.toFixed(1) + '%';
            document.getElementById('baseLoanAmount').textContent = formatCurrency(baseLoanAmount, currency);

            document.getElementById('loanTypeDisplay').textContent = loanTypeNames[vaLoanType];
            document.getElementById('fundingFeeRate').textContent = (fundingFeeRate * 100).toFixed(2) + '%';
            document.getElementById('fundingFeeAmount').textContent = disability === 'yes' ? 'WAIVED ($0)' : formatCurrency(fundingFee, currency);
            document.getElementById('feeFinanced').textContent = disability === 'yes' ? 'N/A - Fee Waived' : 'Yes (Added to Loan)';
            document.getElementById('totalLoanAmount').textContent = formatCurrency(totalLoanAmount, currency);

            document.getElementById('piPayment').textContent = formatCurrency(piPayment, currency);
            document.getElementById('taxPayment').textContent = formatCurrency(monthlyTax, currency);
            document.getElementById('insurancePayment').textContent = formatCurrency(monthlyInsurance, currency);
            document.getElementById('hoaPayment').textContent = formatCurrency(hoaFees, currency);
            document.getElementById('totalPayment').textContent = formatCurrency(totalMonthlyPayment, currency);

            document.getElementById('feeWaived').textContent = disability === 'yes' ? 'Yes ✓' : 'No';
            document.getElementById('feeWaived').style.color = disability === 'yes' ? '#4CAF50' : '#f44336';

            document.getElementById('totalPrincipal').textContent = formatCurrency(totalLoanAmount, currency);
            document.getElementById('totalInterestPaid').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('fundingFeeCost').textContent = disability === 'yes' ? '$0 (Waived)' : formatCurrency(fundingFee, currency);
            document.getElementById('totalTax').textContent = formatCurrency(totalTax, currency);
            document.getElementById('totalInsurance').textContent = formatCurrency(totalInsurance, currency);
            document.getElementById('totalCost').textContent = formatCurrency(totalCost, currency);

            document.getElementById('vaPayment').textContent = formatCurrency(totalMonthlyPayment, currency) + '/month';
            document.getElementById('conventionalPayment').textContent = formatCurrency(conventionalPayment, currency) + '/month';
            document.getElementById('monthlySavings').textContent = formatCurrency(monthlySavings, currency) + '/month';
            document.getElementById('annualSavings').textContent = formatCurrency(annualSavings, currency) + '/year';
            document.getElementById('lifetimeSavings').textContent = formatCurrency(lifetimeSavings, currency);

            document.getElementById('feeFirst').textContent = '2.15%';
            document.getElementById('feeSubsequent').textContent = '3.30%';
            document.getElementById('feeReserves').textContent = '2.15%';
            document.getElementById('fee5Down').textContent = '1.50%';
            document.getElementById('fee10Down').textContent = '1.25%';

            document.getElementById('paymentForAfford').textContent = formatCurrency(totalMonthlyPayment, currency);
            document.getElementById('annualPayment').textContent = formatCurrency(annualPayment, currency);
            document.getElementById('incomeNeeded').textContent = formatCurrency(incomeNeeded, currency) + '/year';
            document.getElementById('percent80k').textContent = percent80k.toFixed(1) + '%';

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
            calculateVALoan();
        });
    </script>
</body>
</html>