<?php
/**
 * Affordability Calculator
 * File: affordability-calculator.php
 * Description: Calculate how much home you can afford based on income (USD/INR)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Affordability Calculator - How Much House Can I Afford? (USD/INR)</title>
    <meta name="description" content="Free home affordability calculator. Calculate how much house you can afford based on income, debts, and down payment. Plan your home budget with USD and INR.">
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
        <h1>🏡 Home Affordability Calculator</h1>
        <p>Calculate how much home you can afford</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Your Financial Details</h2>
                <form id="affordabilityForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="annualIncome">Annual Gross Income (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="annualIncome" value="80000" min="10000" step="1000" required>
                        <small>Before-tax annual income</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="monthlyDebts">Monthly Debt Payments (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="monthlyDebts" value="500" min="0" step="50">
                        <small>Car loans, credit cards, student loans, etc.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="downPayment">Down Payment (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="downPayment" value="60000" min="0" step="5000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% per annum)</label>
                        <input type="number" id="interestRate" value="7" min="3" max="15" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Years)</label>
                        <input type="number" id="loanTerm" value="30" min="10" max="30" step="5" required>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Affordability</button>
                </form>
            </div>

            <div class="results-section">
                <h2>You Can Afford</h2>
                
                <div class="result-card">
                    <h3>Maximum Home Price</h3>
                    <div class="amount" id="maxHomePrice">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Max Loan Amount</h4>
                        <div class="value" id="maxLoanAmount">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Monthly Payment</h4>
                        <div class="value" id="monthlyPayment">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>DTI Ratio</h4>
                        <div class="value" id="dtiRatio">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Down Payment</h4>
                        <div class="value" id="downPaymentDisplay">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Affordability Analysis</h3>
                    <div class="breakdown-item">
                        <span>Annual Income</span>
                        <strong id="incomeDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Gross Income</span>
                        <strong id="monthlyIncome">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>28% of Monthly Income</span>
                        <strong id="frontRatio">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>36% of Monthly Income</span>
                        <strong id="backRatio">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Debt-to-Income Ratios</h3>
                    <div class="breakdown-item">
                        <span>Monthly Debts</span>
                        <strong id="debtsDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Max Monthly Housing Payment</span>
                        <strong id="maxHousingPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Front-End DTI (Housing)</span>
                        <strong id="frontDTI">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Back-End DTI (Total Debt)</span>
                        <strong id="backDTI">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Purchase Summary</h3>
                    <div class="breakdown-item">
                        <span>Maximum Home Price</span>
                        <strong id="homePriceMax" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="dpAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="loanAmountMax">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly P&I Payment</span>
                        <strong id="piPayment">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Price Ranges by DTI</h3>
                    <div class="breakdown-item">
                        <span>Conservative (28% DTI)</span>
                        <strong id="conservative28">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Standard (33% DTI)</span>
                        <strong id="standard33">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Aggressive (36% DTI)</span>
                        <strong id="aggressive36">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Affordability Guidelines:</strong> Front-end DTI (housing costs) should be ≤28%. Back-end DTI (all debts) should be ≤36%. These are 28/36 qualifying ratios. Lenders may approve up to 43% DTI. Include property tax, insurance, HOA in monthly costs.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('affordabilityForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateAffordability();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
            document.getElementById('currencyLabel2').textContent = symbol;
            document.getElementById('currencyLabel3').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateAffordability();
        });

        function calculateAffordability() {
            const annualIncome = parseFloat(document.getElementById('annualIncome').value) || 0;
            const monthlyDebts = parseFloat(document.getElementById('monthlyDebts').value) || 0;
            const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
            const annualRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0;
            const loanTerm = parseInt(document.getElementById('loanTerm').value) || 30;
            const currency = currencySelect.value;

            const monthlyIncome = annualIncome / 12;
            const frontEndRatio = monthlyIncome * 0.28; // 28% for housing
            const backEndRatio = monthlyIncome * 0.36; // 36% for all debts
            
            // Maximum monthly payment (lower of front/back end)
            const maxHousingFromFront = frontEndRatio;
            const maxHousingFromBack = backEndRatio - monthlyDebts;
            const maxMonthlyPayment = Math.min(maxHousingFromFront, maxHousingFromBack);

            // Calculate max loan from monthly payment
            const monthlyRate = annualRate / 12;
            const numberOfPayments = loanTerm * 12;
            
            let maxLoan = 0;
            if (monthlyRate > 0) {
                maxLoan = maxMonthlyPayment * ((Math.pow(1 + monthlyRate, numberOfPayments) - 1) / (monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)));
            } else {
                maxLoan = maxMonthlyPayment * numberOfPayments;
            }

            const maxHomePrice = maxLoan + downPayment;
            
            // DTI calculations
            const frontDTI = (maxMonthlyPayment / monthlyIncome) * 100;
            const backDTI = ((maxMonthlyPayment + monthlyDebts) / monthlyIncome) * 100;

            // Different DTI scenarios
            function calculatePriceByDTI(dtiPercent) {
                const payment = (monthlyIncome * dtiPercent) - monthlyDebts;
                let loan = 0;
                if (monthlyRate > 0) {
                    loan = payment * ((Math.pow(1 + monthlyRate, numberOfPayments) - 1) / (monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)));
                } else {
                    loan = payment * numberOfPayments;
                }
                return loan + downPayment;
            }

            const price28 = calculatePriceByDTI(0.28);
            const price33 = calculatePriceByDTI(0.33);
            const price36 = calculatePriceByDTI(0.36);

            // Update UI
            document.getElementById('maxHomePrice').textContent = formatCurrency(maxHomePrice, currency);
            document.getElementById('maxLoanAmount').textContent = formatCurrency(maxLoan, currency);
            document.getElementById('monthlyPayment').textContent = formatCurrency(maxMonthlyPayment, currency);
            document.getElementById('dtiRatio').textContent = backDTI.toFixed(1) + '%';
            document.getElementById('downPaymentDisplay').textContent = formatCurrency(downPayment, currency);

            document.getElementById('incomeDisplay').textContent = formatCurrency(annualIncome, currency);
            document.getElementById('monthlyIncome').textContent = formatCurrency(monthlyIncome, currency);
            document.getElementById('frontRatio').textContent = formatCurrency(frontEndRatio, currency);
            document.getElementById('backRatio').textContent = formatCurrency(backEndRatio, currency);

            document.getElementById('debtsDisplay').textContent = formatCurrency(monthlyDebts, currency);
            document.getElementById('maxHousingPayment').textContent = formatCurrency(maxMonthlyPayment, currency);
            document.getElementById('frontDTI').textContent = frontDTI.toFixed(1) + '%';
            document.getElementById('backDTI').textContent = backDTI.toFixed(1) + '%';

            document.getElementById('homePriceMax').textContent = formatCurrency(maxHomePrice, currency);
            document.getElementById('dpAmount').textContent = formatCurrency(downPayment, currency);
            document.getElementById('loanAmountMax').textContent = formatCurrency(maxLoan, currency);
            document.getElementById('piPayment').textContent = formatCurrency(maxMonthlyPayment, currency);

            document.getElementById('conservative28').textContent = formatCurrency(price28, currency);
            document.getElementById('standard33').textContent = formatCurrency(price33, currency);
            document.getElementById('aggressive36').textContent = formatCurrency(price36, currency);
        }

           function formatCurrency(amount, currency) {
            if (currency === 'INR') {
                return new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(amount);
            } else {
                return new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(amount);
            }
        }

        window.addEventListener('load', function() {
            updateCurrencyLabels();
            calculateAffordability();
        });
    </script>
</body>
</html>