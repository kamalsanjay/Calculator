<?php
/**
 * Rental Property Calculator
 * File: rental-property-calculator.php
 * Description: Calculate rental property cash flow and returns (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Property Calculator - Calculate Cash Flow (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free rental property calculator. Calculate monthly cash flow, operating expenses, and rental income. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#127968; Rental Property Calculator</h1>
        <p>Calculate rental income and cash flow</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Property Details</h2>
                <form id="rentalForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD (&#36;)</option>
                            <option value="INR">INR (&#8377;)</option>
                            <option value="EUR">EUR (&#8364;)</option>
                            <option value="GBP">GBP (&#163;)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #4CAF50; margin: 25px 0 15px;">Rental Income</h3>
                    
                    <div class="form-group">
                        <label for="monthlyRent">Monthly Rent (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="monthlyRent" value="2000" min="0" step="50" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="otherIncome">Other Monthly Income (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="otherIncome" value="0" min="0" step="25">
                        <small>Parking, laundry, storage fees</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="vacancyRate">Vacancy Rate (%)</label>
                        <input type="number" id="vacancyRate" value="5" min="0" max="50" step="1">
                        <small>Expected vacancy (5-10% typical)</small>
                    </div>
                    
                    <h3 style="color: #f44336; margin: 25px 0 15px;">Operating Expenses</h3>
                    
                    <div class="form-group">
                        <label for="propertyTax">Annual Property Tax (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="propertyTax" value="3000" min="0" step="100">
                    </div>
                    
                    <div class="form-group">
                        <label for="insurance">Annual Insurance (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="insurance" value="1200" min="0" step="100">
                    </div>
                    
                    <div class="form-group">
                        <label for="hoaFees">Monthly HOA Fees (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="hoaFees" value="0" min="0" step="25">
                    </div>
                    
                    <div class="form-group">
                        <label for="maintenance">Maintenance & Repairs (<span id="currencyLabel6">$</span>/month)</label>
                        <input type="number" id="maintenance" value="150" min="0" step="25">
                        <small>Typically 1% of property value/year</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="utilities">Utilities (<span id="currencyLabel7">$</span>/month)</label>
                        <input type="number" id="utilities" value="0" min="0" step="25">
                        <small>If landlord pays</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="propertyManagement">Property Management (%)</label>
                        <input type="number" id="propertyManagement" value="8" min="0" max="20" step="0.5">
                        <small>% of gross rent (8-10% typical)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="otherExpenses">Other Expenses (<span id="currencyLabel8">$</span>/month)</label>
                        <input type="number" id="otherExpenses" value="0" min="0" step="25">
                        <small>Pest control, landscaping, etc.</small>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Mortgage (Optional)</h3>
                    
                    <div class="form-group">
                        <label for="mortgagePayment">Monthly Mortgage Payment (<span id="currencyLabel9">$</span>)</label>
                        <input type="number" id="mortgagePayment" value="0" min="0" step="50">
                        <small>Principal + Interest (leave 0 if paid off)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Cash Flow</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Cash Flow Analysis</h2>
                
                <div class="result-card" id="cashFlowCard">
                    <h3>Monthly Cash Flow</h3>
                    <div class="amount" id="monthlyCashFlow">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Gross Monthly Income</h4>
                        <div class="value" id="grossIncome">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Expenses</h4>
                        <div class="value" id="totalExpenses">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Annual Cash Flow</h4>
                        <div class="value" id="annualCashFlow">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Operating Expense Ratio</h4>
                        <div class="value" id="oer">0%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Monthly Income</h3>
                    <div class="breakdown-item">
                        <span>Monthly Rent</span>
                        <strong id="rentDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Income</span>
                        <strong id="otherIncomeDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Gross Monthly Income</strong></span>
                        <strong id="grossMonthlyIncome" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Vacancy Loss ({vacancyRate}%)</span>
                        <strong id="vacancyLoss" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Effective Gross Income</strong></span>
                        <strong id="effectiveIncome" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Monthly Operating Expenses</h3>
                    <div class="breakdown-item">
                        <span>Property Tax</span>
                        <strong id="propertyTaxMonthly" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Insurance</span>
                        <strong id="insuranceMonthly" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>HOA Fees</span>
                        <strong id="hoaFeesDisplay" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Maintenance & Repairs</span>
                        <strong id="maintenanceDisplay" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Utilities</span>
                        <strong id="utilitiesDisplay" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Property Management</span>
                        <strong id="managementFee" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Expenses</span>
                        <strong id="otherExpensesDisplay" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #f44336; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Operating Expenses</strong></span>
                        <strong id="totalOperatingExpenses" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Net Operating Income</h3>
                    <div class="breakdown-item">
                        <span>Effective Gross Income</span>
                        <strong id="egiCalc" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Operating Expenses</span>
                        <strong id="opexCalc" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Operating Income (NOI)</strong></span>
                        <strong id="noi" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Monthly Cash Flow</h3>
                    <div class="breakdown-item">
                        <span>Net Operating Income</span>
                        <strong id="noiCashFlow">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mortgage Payment</span>
                        <strong id="mortgageDisplay" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Monthly Cash Flow</strong></span>
                        <strong id="cashFlowFinal" style="font-size: 1.2em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Cash Flow</span>
                        <strong id="annualCashFlowCalc" style="color: #667eea;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Annual Summary</h3>
                    <div class="breakdown-item">
                        <span>Annual Gross Income</span>
                        <strong id="annualGrossIncome" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Operating Expenses</span>
                        <strong id="annualOpex" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual NOI</span>
                        <strong id="annualNOI" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Mortgage Payments</span>
                        <strong id="annualMortgage" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Annual Cash Flow</strong></span>
                        <strong id="annualCashFlowTotal" style="font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Key Metrics</h3>
                    <div class="breakdown-item">
                        <span>Operating Expense Ratio</span>
                        <strong id="oerDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Net Operating Margin</span>
                        <strong id="noiMargin">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Debt Service Coverage Ratio</span>
                        <strong id="dscr">0x</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Break-Even Occupancy</span>
                        <strong id="breakEven">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Expense Breakdown by Category</h3>
                    <div class="breakdown-item">
                        <span>Fixed Costs (Tax, Insurance, HOA)</span>
                        <strong id="fixedCosts">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Variable Costs (Maintenance, Utilities)</span>
                        <strong id="variableCosts">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Management Costs</span>
                        <strong id="managementCosts">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Per Unit Economics</h3>
                    <div class="breakdown-item">
                        <span>Gross Rent Per Month</span>
                        <strong id="rentPerMonth">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Expenses Per Month</span>
                        <strong id="expensesPerMonth">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cash Flow Per Month</span>
                        <strong id="cashFlowPerMonth">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cash Flow as % of Rent</span>
                        <strong id="cashFlowPercent">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Rental Tips:</strong> Positive cash flow = good. Budget for vacancies (5-10%). 1% rule: monthly rent ≥ 1% of property value. Screen tenants thoroughly. Maintenance costs add up (1% of value/year). Property management = 8-10% of rent. Keep 6-month emergency fund. NOI excludes mortgage. Higher NOI = better. OER <50% = good. DSCR >1.25 = healthy. Written lease essential. Know landlord-tenant laws. Insurance is critical. Raise rent with market. Long-term tenants save money.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('rentalForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateCashFlow();
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
            for (let i = 1; i <= 9; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateCashFlow();
        });

        function calculateCashFlow() {
            const monthlyRent = parseFloat(document.getElementById('monthlyRent').value) || 0;
            const otherIncome = parseFloat(document.getElementById('otherIncome').value) || 0;
            const vacancyRate = parseFloat(document.getElementById('vacancyRate').value) / 100 || 0;
            const propertyTax = parseFloat(document.getElementById('propertyTax').value) || 0;
            const insurance = parseFloat(document.getElementById('insurance').value) || 0;
            const hoaFees = parseFloat(document.getElementById('hoaFees').value) || 0;
            const maintenance = parseFloat(document.getElementById('maintenance').value) || 0;
            const utilities = parseFloat(document.getElementById('utilities').value) || 0;
            const propertyManagement = parseFloat(document.getElementById('propertyManagement').value) / 100 || 0;
            const otherExpenses = parseFloat(document.getElementById('otherExpenses').value) || 0;
            const mortgagePayment = parseFloat(document.getElementById('mortgagePayment').value) || 0;
            const currency = currencySelect.value;

            // Income calculations
            const grossMonthlyIncome = monthlyRent + otherIncome;
            const vacancyLoss = grossMonthlyIncome * vacancyRate;
            const effectiveGrossIncome = grossMonthlyIncome - vacancyLoss;

            // Expense calculations
            const propertyTaxMonthly = propertyTax / 12;
            const insuranceMonthly = insurance / 12;
            const managementFee = grossMonthlyIncome * propertyManagement;
            const totalOperatingExpenses = propertyTaxMonthly + insuranceMonthly + hoaFees + maintenance + utilities + managementFee + otherExpenses;

            // NOI
            const noi = effectiveGrossIncome - totalOperatingExpenses;

            // Cash Flow
            const monthlyCashFlow = noi - mortgagePayment;
            const annualCashFlow = monthlyCashFlow * 12;

            // Annual figures
            const annualGrossIncome = grossMonthlyIncome * 12;
            const annualOpex = totalOperatingExpenses * 12;
            const annualNOI = noi * 12;
            const annualMortgage = mortgagePayment * 12;

            // Metrics
            const oer = effectiveGrossIncome > 0 ? (totalOperatingExpenses / effectiveGrossIncome) * 100 : 0;
            const noiMargin = effectiveGrossIncome > 0 ? (noi / effectiveGrossIncome) * 100 : 0;
            const dscr = (mortgagePayment * 12) > 0 ? annualNOI / (mortgagePayment * 12) : 0;
            const breakEven = effectiveGrossIncome > 0 ? ((totalOperatingExpenses + mortgagePayment) / grossMonthlyIncome) * 100 : 0;

            // Expense breakdown
            const fixedCosts = propertyTaxMonthly + insuranceMonthly + hoaFees;
            const variableCosts = maintenance + utilities + otherExpenses;
            const managementCosts = managementFee;

            // Per unit
            const cashFlowPercent = monthlyRent > 0 ? (monthlyCashFlow / monthlyRent) * 100 : 0;

            // Analysis
            let analysis = `Your property generates ${formatCurrency(grossMonthlyIncome, currency)} in gross monthly income. `;
            analysis += `After accounting for ${(vacancyRate * 100).toFixed(0)}% vacancy (${formatCurrency(vacancyLoss, currency)}), your effective gross income is ${formatCurrency(effectiveGrossIncome, currency)}. `;
            analysis += `With ${formatCurrency(totalOperatingExpenses, currency)} in monthly operating expenses, your Net Operating Income is ${formatCurrency(noi, currency)}. `;
            
            if (mortgagePayment > 0) {
                analysis += `After mortgage payment of ${formatCurrency(mortgagePayment, currency)}, `;
            }
            
            if (monthlyCashFlow >= 0) {
                analysis += `you have positive monthly cash flow of ${formatCurrency(monthlyCashFlow, currency)} (${formatCurrency(annualCashFlow, currency)}/year). This is a profitable rental property.`;
            } else {
                analysis += `you have negative monthly cash flow of ${formatCurrency(Math.abs(monthlyCashFlow), currency)}. This property requires additional capital each month.`;
            }

            // Update UI
            document.getElementById('monthlyCashFlow').textContent = formatCurrency(monthlyCashFlow, currency);
            document.getElementById('grossIncome').textContent = formatCurrency(grossMonthlyIncome, currency);
            document.getElementById('totalExpenses').textContent = formatCurrency(totalOperatingExpenses + mortgagePayment, currency);
            document.getElementById('annualCashFlow').textContent = formatCurrency(annualCashFlow, currency);
            document.getElementById('oer').textContent = oer.toFixed(1) + '%';

            // Update card color
            const card = document.getElementById('cashFlowCard');
            card.className = 'result-card ' + (monthlyCashFlow >= 0 ? 'success' : 'warning');

            // Update cash flow colors
            const cashFlowColor = monthlyCashFlow >= 0 ? '#4CAF50' : '#f44336';
            document.getElementById('monthlyCashFlow').style.color = monthlyCashFlow >= 0 ? 'inherit' : cashFlowColor;

            document.getElementById('rentDisplay').textContent = formatCurrency(monthlyRent, currency);
            document.getElementById('otherIncomeDisplay').textContent = formatCurrency(otherIncome, currency);
            document.getElementById('grossMonthlyIncome').textContent = formatCurrency(grossMonthlyIncome, currency);
            document.getElementById('vacancyLoss').textContent = formatCurrency(vacancyLoss, currency);
            document.getElementById('effectiveIncome').textContent = formatCurrency(effectiveGrossIncome, currency);

            document.getElementById('propertyTaxMonthly').textContent = formatCurrency(propertyTaxMonthly, currency);
            document.getElementById('insuranceMonthly').textContent = formatCurrency(insuranceMonthly, currency);
            document.getElementById('hoaFeesDisplay').textContent = formatCurrency(hoaFees, currency);
            document.getElementById('maintenanceDisplay').textContent = formatCurrency(maintenance, currency);
            document.getElementById('utilitiesDisplay').textContent = formatCurrency(utilities, currency);
            document.getElementById('managementFee').textContent = formatCurrency(managementFee, currency);
            document.getElementById('otherExpensesDisplay').textContent = formatCurrency(otherExpenses, currency);
            document.getElementById('totalOperatingExpenses').textContent = formatCurrency(totalOperatingExpenses, currency);

            document.getElementById('egiCalc').textContent = formatCurrency(effectiveGrossIncome, currency);
            document.getElementById('opexCalc').textContent = formatCurrency(totalOperatingExpenses, currency);
            document.getElementById('noi').textContent = formatCurrency(noi, currency);

            document.getElementById('noiCashFlow').textContent = formatCurrency(noi, currency);
            document.getElementById('mortgageDisplay').textContent = formatCurrency(mortgagePayment, currency);
            document.getElementById('cashFlowFinal').textContent = formatCurrency(monthlyCashFlow, currency);
            document.getElementById('cashFlowFinal').style.color = cashFlowColor;
            document.getElementById('annualCashFlowCalc').textContent = formatCurrency(annualCashFlow, currency);

            document.getElementById('annualGrossIncome').textContent = formatCurrency(annualGrossIncome, currency);
            document.getElementById('annualOpex').textContent = formatCurrency(annualOpex, currency);
            document.getElementById('annualNOI').textContent = formatCurrency(annualNOI, currency);
            document.getElementById('annualMortgage').textContent = formatCurrency(annualMortgage, currency);
            document.getElementById('annualCashFlowTotal').textContent = formatCurrency(annualCashFlow, currency);
            document.getElementById('annualCashFlowTotal').style.color = cashFlowColor;

            document.getElementById('oerDisplay').textContent = oer.toFixed(1) + '%';
            document.getElementById('noiMargin').textContent = noiMargin.toFixed(1) + '%';
            document.getElementById('dscr').textContent = dscr.toFixed(2) + 'x';
            document.getElementById('breakEven').textContent = breakEven.toFixed(1) + '%';

            document.getElementById('fixedCosts').textContent = formatCurrency(fixedCosts, currency);
            document.getElementById('variableCosts').textContent = formatCurrency(variableCosts, currency);
            document.getElementById('managementCosts').textContent = formatCurrency(managementCosts, currency);

            document.getElementById('rentPerMonth').textContent = formatCurrency(monthlyRent, currency);
            document.getElementById('expensesPerMonth').textContent = formatCurrency(totalOperatingExpenses + mortgagePayment, currency);
            document.getElementById('cashFlowPerMonth').textContent = formatCurrency(monthlyCashFlow, currency);
            document.getElementById('cashFlowPercent').textContent = cashFlowPercent.toFixed(1) + '%';

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
            calculateCashFlow();
        });
    </script>
</body>
</html>