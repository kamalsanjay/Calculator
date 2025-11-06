<?php
/**
 * Real Estate Investment Calculator
 * File: real-estate-investment-calculator.php
 * Description: Calculate ROI for rental properties (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Investment Calculator - Calculate ROI (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free real estate investment calculator. Calculate ROI, cash flow, and returns for rental properties. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#127970; Real Estate Investment Calculator</h1>
        <p>Calculate rental property returns and ROI</p>
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
                <h2>Property Investment</h2>
                <form id="realEstateForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD (&#36;)</option>
                            <option value="INR">INR (&#8377;)</option>
                            <option value="EUR">EUR (&#8364;)</option>
                            <option value="GBP">GBP (&#163;)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Purchase Details</h3>
                    
                    <div class="form-group">
                        <label for="purchasePrice">Purchase Price (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="purchasePrice" value="300000" min="10000" step="10000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="downPayment">Down Payment (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="downPayment" value="60000" min="0" step="5000">
                        <small>Initial investment (20% = $60,000)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="closingCosts">Closing Costs (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="closingCosts" value="8000" min="0" step="1000">
                        <small>Fees, inspections, etc. (2-5%)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="repairCosts">Repair/Renovation Costs (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="repairCosts" value="15000" min="0" step="1000">
                    </div>
                    
                    <h3 style="color: #f44336; margin: 25px 0 15px;">Financing</h3>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% APR)</label>
                        <input type="number" id="interestRate" value="6.5" min="0" max="15" step="0.1">
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Years)</label>
                        <input type="number" id="loanTerm" value="30" min="1" max="50" step="1">
                    </div>
                    
                    <h3 style="color: #4CAF50; margin: 25px 0 15px;">Income</h3>
                    
                    <div class="form-group">
                        <label for="monthlyRent">Monthly Rent (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="monthlyRent" value="2200" min="0" step="50" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="otherIncome">Other Monthly Income (<span id="currencyLabel6">$</span>)</label>
                        <input type="number" id="otherIncome" value="0" min="0" step="50">
                        <small>Parking, laundry, storage, etc.</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Expenses</h3>
                    
                    <div class="form-group">
                        <label for="propertyTax">Annual Property Tax (<span id="currencyLabel7">$</span>)</label>
                        <input type="number" id="propertyTax" value="3600" min="0" step="100">
                    </div>
                    
                    <div class="form-group">
                        <label for="insurance">Annual Insurance (<span id="currencyLabel8">$</span>)</label>
                        <input type="number" id="insurance" value="1200" min="0" step="100">
                    </div>
                    
                    <div class="form-group">
                        <label for="hoaFees">Monthly HOA Fees (<span id="currencyLabel9">$</span>)</label>
                        <input type="number" id="hoaFees" value="0" min="0" step="25">
                    </div>
                    
                    <div class="form-group">
                        <label for="maintenance">Monthly Maintenance (<span id="currencyLabel10">$</span>)</label>
                        <input type="number" id="maintenance" value="200" min="0" step="25">
                        <small>Repairs, upkeep (1% of value/year = $250/mo)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="propertyManagement">Property Management (%)</label>
                        <input type="number" id="propertyManagement" value="8" min="0" max="20" step="0.5">
                        <small>% of monthly rent (typically 8-10%)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="vacancy">Vacancy Rate (%)</label>
                        <input type="number" id="vacancy" value="5" min="0" max="50" step="1">
                        <small>Expected vacancy (5-10% typical)</small>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Appreciation</h3>
                    
                    <div class="form-group">
                        <label for="appreciation">Annual Appreciation (%)</label>
                        <input type="number" id="appreciation" value="3" min="0" max="20" step="0.5">
                        <small>Property value increase (avg: 3-5%)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate ROI</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Investment Analysis</h2>
                
                <div class="result-card success">
                    <h3>Cash on Cash Return</h3>
                    <div class="amount" id="cashOnCashReturn">0%</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Monthly Cash Flow</h4>
                        <div class="value" id="monthlyCashFlow">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Annual Cash Flow</h4>
                        <div class="value" id="annualCashFlow">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Cap Rate</h4>
                        <div class="value" id="capRate">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total ROI (Year 1)</h4>
                        <div class="value" id="totalROI">0%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Total Investment</h3>
                    <div class="breakdown-item">
                        <span>Purchase Price</span>
                        <strong id="priceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="downPaymentDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Closing Costs</span>
                        <strong id="closingCostsDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Repair/Renovation</span>
                        <strong id="repairCostsDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Cash Investment</strong></span>
                        <strong id="totalInvestment" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Monthly Income</h3>
                    <div class="breakdown-item">
                        <span>Rent Income</span>
                        <strong id="rentDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Income</span>
                        <strong id="otherIncomeDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Vacancy Loss</span>
                        <strong id="vacancyLoss" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Effective Monthly Income</strong></span>
                        <strong id="effectiveIncome" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Monthly Expenses</h3>
                    <div class="breakdown-item">
                        <span>Mortgage Payment (P&I)</span>
                        <strong id="mortgagePayment" style="color: #f44336;">$0</strong>
                    </div>
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
                        <span>Maintenance</span>
                        <strong id="maintenanceDisplay" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Property Management</span>
                        <strong id="managementFee" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #f44336; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Monthly Expenses</strong></span>
                        <strong id="totalExpenses" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Cash Flow Analysis</h3>
                    <div class="breakdown-item">
                        <span>Effective Monthly Income</span>
                        <strong id="incomeCalc" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Monthly Expenses</span>
                        <strong id="expensesCalc" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Monthly Cash Flow</strong></span>
                        <strong id="cashFlowCalc" style="font-size: 1.2em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Cash Flow</span>
                        <strong id="annualCashFlowCalc" style="color: #667eea;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Return Metrics</h3>
                    <div class="breakdown-item">
                        <span>Cash on Cash Return</span>
                        <strong id="cocReturn" style="color: #667eea; font-size: 1.1em;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cap Rate</span>
                        <strong id="capRateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gross Rent Multiplier</span>
                        <strong id="grm">0x</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Debt Service Coverage Ratio</span>
                        <strong id="dscr">0x</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Year 1 Total Return</h3>
                    <div class="breakdown-item">
                        <span>Cash Flow (Year 1)</span>
                        <strong id="cashFlowYear1" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Appreciation (Year 1)</span>
                        <strong id="appreciationYear1" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Principal Paydown (Year 1)</span>
                        <strong id="principalYear1" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Return (Year 1)</strong></span>
                        <strong id="totalReturn" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total ROI %</span>
                        <strong id="totalROIPercent" style="color: #667eea;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>5-Year Projection</h3>
                    <div class="breakdown-item">
                        <span>Total Cash Flow (5 years)</span>
                        <strong id="cashFlow5Year" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Property Value (Year 5)</span>
                        <strong id="value5Year">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Appreciation Gain</span>
                        <strong id="appreciation5Year" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Balance (Year 5)</span>
                        <strong id="loanBalance5Year" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Equity (Year 5)</span>
                        <strong id="equity5Year" style="color: #667eea;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Investment Tips:</strong> Positive cash flow = good investment. Cash-on-cash >8% = excellent. Cap rate >5% = decent. Location matters most. Screen tenants carefully. Budget for vacancies. Maintenance adds up. Property management costs 8-10%. 1% rule: rent ≥ 1% of price. Factor appreciation. Leverage increases returns. Consider tax benefits. Diversify properties. Emergency fund essential. Run numbers conservatively. Buy below market value. Understand local market. Long-term hold best.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('realEstateForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateROI();
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
            for (let i = 1; i <= 10; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateROI();
        });

        function calculateROI() {
            const purchasePrice = parseFloat(document.getElementById('purchasePrice').value) || 0;
            const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
            const closingCosts = parseFloat(document.getElementById('closingCosts').value) || 0;
            const repairCosts = parseFloat(document.getElementById('repairCosts').value) || 0;
            const interestRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0;
            const loanTerm = parseInt(document.getElementById('loanTerm').value) || 30;
            const monthlyRent = parseFloat(document.getElementById('monthlyRent').value) || 0;
            const otherIncome = parseFloat(document.getElementById('otherIncome').value) || 0;
            const propertyTax = parseFloat(document.getElementById('propertyTax').value) || 0;
            const insurance = parseFloat(document.getElementById('insurance').value) || 0;
            const hoaFees = parseFloat(document.getElementById('hoaFees').value) || 0;
            const maintenance = parseFloat(document.getElementById('maintenance').value) || 0;
            const propertyManagement = parseFloat(document.getElementById('propertyManagement').value) / 100 || 0;
            const vacancy = parseFloat(document.getElementById('vacancy').value) / 100 || 0;
            const appreciation = parseFloat(document.getElementById('appreciation').value) / 100 || 0;
            const currency = currencySelect.value;

            // Total investment
            const totalInvestment = downPayment + closingCosts + repairCosts;
            const loanAmount = purchasePrice - downPayment;

            // Calculate mortgage payment
            const monthlyRate = interestRate / 12;
            const months = loanTerm * 12;
            let mortgagePayment = 0;
            if (monthlyRate > 0) {
                mortgagePayment = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, months)) /
                                 (Math.pow(1 + monthlyRate, months) - 1);
            } else {
                mortgagePayment = loanAmount / months;
            }

            // Income
            const grossIncome = monthlyRent + otherIncome;
            const vacancyLoss = grossIncome * vacancy;
            const effectiveIncome = grossIncome - vacancyLoss;

            // Expenses
            const propertyTaxMonthly = propertyTax / 12;
            const insuranceMonthly = insurance / 12;
            const managementFee = (monthlyRent + otherIncome) * propertyManagement;
            const totalExpenses = mortgagePayment + propertyTaxMonthly + insuranceMonthly + hoaFees + maintenance + managementFee;

            // Cash flow
            const monthlyCashFlow = effectiveIncome - totalExpenses;
            const annualCashFlow = monthlyCashFlow * 12;

            // Returns
            const cashOnCashReturn = totalInvestment > 0 ? (annualCashFlow / totalInvestment) * 100 : 0;
            const noi = (effectiveIncome * 12) - ((propertyTaxMonthly + insuranceMonthly + hoaFees + maintenance + managementFee) * 12);
            const capRate = purchasePrice > 0 ? (noi / purchasePrice) * 100 : 0;
            const grm = monthlyRent > 0 ? purchasePrice / (monthlyRent * 12) : 0;
            const dscr = (mortgagePayment * 12) > 0 ? noi / (mortgagePayment * 12) : 0;

            // Year 1 total return
            const appreciationYear1 = purchasePrice * appreciation;
            
            // Calculate principal paydown year 1
            let balance = loanAmount;
            let principalYear1 = 0;
            for (let month = 1; month <= 12; month++) {
                const interest = balance * monthlyRate;
                const principal = mortgagePayment - interest;
                principalYear1 += principal;
                balance -= principal;
            }

            const totalReturn = annualCashFlow + appreciationYear1 + principalYear1;
            const totalROI = totalInvestment > 0 ? (totalReturn / totalInvestment) * 100 : 0;

            // 5-year projection
            const cashFlow5Year = annualCashFlow * 5;
            const value5Year = purchasePrice * Math.pow(1 + appreciation, 5);
            const appreciation5Year = value5Year - purchasePrice;
            
            // Calculate loan balance after 5 years
            let loanBalance5Year = loanAmount;
            for (let month = 1; month <= 60; month++) {
                const interest = loanBalance5Year * monthlyRate;
                const principal = mortgagePayment - interest;
                loanBalance5Year -= principal;
            }
            const equity5Year = value5Year - loanBalance5Year;

            // Analysis
            let analysis = `With a total investment of ${formatCurrency(totalInvestment, currency)}, `;
            analysis += `you will generate ${formatCurrency(monthlyCashFlow, currency)} in monthly cash flow (${formatCurrency(annualCashFlow, currency)}/year). `;
            
            if (monthlyCashFlow > 0) {
                analysis += `This is a positive cash flow property. `;
            } else {
                analysis += `This property has negative cash flow and may require additional capital. `;
            }
            
            analysis += `Your cash-on-cash return is ${cashOnCashReturn.toFixed(2)}% and cap rate is ${capRate.toFixed(2)}%. `;
            analysis += `Including appreciation and principal paydown, your total Year 1 ROI is ${totalROI.toFixed(2)}%. `;
            analysis += `After 5 years, you will have ${formatCurrency(equity5Year, currency)} in equity.`;

            // Update UI
            document.getElementById('cashOnCashReturn').textContent = cashOnCashReturn.toFixed(2) + '%';
            document.getElementById('monthlyCashFlow').textContent = formatCurrency(monthlyCashFlow, currency);
            document.getElementById('annualCashFlow').textContent = formatCurrency(annualCashFlow, currency);
            document.getElementById('capRate').textContent = capRate.toFixed(2) + '%';
            document.getElementById('totalROI').textContent = totalROI.toFixed(2) + '%';

            // Update cash flow color
            const cashFlowColor = monthlyCashFlow >= 0 ? '#4CAF50' : '#f44336';
            document.getElementById('monthlyCashFlow').style.color = cashFlowColor;
            document.getElementById('annualCashFlow').style.color = cashFlowColor;

            document.getElementById('priceDisplay').textContent = formatCurrency(purchasePrice, currency);
            document.getElementById('downPaymentDisplay').textContent = formatCurrency(downPayment, currency);
            document.getElementById('closingCostsDisplay').textContent = formatCurrency(closingCosts, currency);
            document.getElementById('repairCostsDisplay').textContent = formatCurrency(repairCosts, currency);
            document.getElementById('totalInvestment').textContent = formatCurrency(totalInvestment, currency);

            document.getElementById('rentDisplay').textContent = formatCurrency(monthlyRent, currency);
            document.getElementById('otherIncomeDisplay').textContent = formatCurrency(otherIncome, currency);
            document.getElementById('vacancyLoss').textContent = formatCurrency(vacancyLoss, currency);
            document.getElementById('effectiveIncome').textContent = formatCurrency(effectiveIncome, currency);

            document.getElementById('mortgagePayment').textContent = formatCurrency(mortgagePayment, currency);
            document.getElementById('propertyTaxMonthly').textContent = formatCurrency(propertyTaxMonthly, currency);
            document.getElementById('insuranceMonthly').textContent = formatCurrency(insuranceMonthly, currency);
            document.getElementById('hoaFeesDisplay').textContent = formatCurrency(hoaFees, currency);
            document.getElementById('maintenanceDisplay').textContent = formatCurrency(maintenance, currency);
            document.getElementById('managementFee').textContent = formatCurrency(managementFee, currency);
            document.getElementById('totalExpenses').textContent = formatCurrency(totalExpenses, currency);

            document.getElementById('incomeCalc').textContent = formatCurrency(effectiveIncome, currency);
            document.getElementById('expensesCalc').textContent = formatCurrency(totalExpenses, currency);
            document.getElementById('cashFlowCalc').textContent = formatCurrency(monthlyCashFlow, currency);
            document.getElementById('cashFlowCalc').style.color = cashFlowColor;
            document.getElementById('annualCashFlowCalc').textContent = formatCurrency(annualCashFlow, currency);

            document.getElementById('cocReturn').textContent = cashOnCashReturn.toFixed(2) + '%';
            document.getElementById('capRateDisplay').textContent = capRate.toFixed(2) + '%';
            document.getElementById('grm').textContent = grm.toFixed(2) + 'x';
            document.getElementById('dscr').textContent = dscr.toFixed(2) + 'x';

            document.getElementById('cashFlowYear1').textContent = formatCurrency(annualCashFlow, currency);
            document.getElementById('appreciationYear1').textContent = formatCurrency(appreciationYear1, currency);
            document.getElementById('principalYear1').textContent = formatCurrency(principalYear1, currency);
            document.getElementById('totalReturn').textContent = formatCurrency(totalReturn, currency);
            document.getElementById('totalROIPercent').textContent = totalROI.toFixed(2) + '%';

            document.getElementById('cashFlow5Year').textContent = formatCurrency(cashFlow5Year, currency);
            document.getElementById('value5Year').textContent = formatCurrency(value5Year, currency);
            document.getElementById('appreciation5Year').textContent = formatCurrency(appreciation5Year, currency);
            document.getElementById('loanBalance5Year').textContent = formatCurrency(loanBalance5Year, currency);
            document.getElementById('equity5Year').textContent = formatCurrency(equity5Year, currency);

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
            calculateROI();
        });
    </script>
</body>
</html>