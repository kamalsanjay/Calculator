<?php
/**
 * Home Loan Calculator
 * File: home-loan-calculator.php
 * Description: Calculate home loan EMI, affordability, and property costs (USD/INR)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Loan Calculator - Calculate Housing Loan EMI (USD/INR)</title>
    <meta name="description" content="Free home loan calculator. Calculate monthly EMI, total interest, and property affordability. Plan your home purchase with USD and INR support.">
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
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
        <h1>🏡 Home Loan Calculator</h1>
        <p>Calculate your housing loan EMI and affordability</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Home Loan Details</h2>
                <form id="homeLoanForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="propertyValue">Property Value (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="propertyValue" value="500000" min="10000" step="5000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="downPayment">Down Payment (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="downPayment" value="100000" min="0" step="5000" required>
                        <small>Typically 20% of property value</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTenure">Loan Tenure (Years)</label>
                        <input type="number" id="loanTenure" value="20" min="5" max="30" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% per annum)</label>
                        <input type="number" id="interestRate" value="8" min="1" max="20" step="0.1" required>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Home Loan</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Loan Summary</h2>
                
                <div class="result-card">
                    <h3>Monthly EMI</h3>
                    <div class="amount" id="monthlyEMI">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Loan Amount</h4>
                        <div class="value" id="loanAmount">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Interest</h4>
                        <div class="value" id="totalInterest">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Payment</h4>
                        <div class="value" id="totalPayment">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>LTV Ratio</h4>
                        <div class="value" id="ltvRatio">0%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Property Details</h3>
                    <div class="breakdown-item">
                        <span>Property Value</span>
                        <strong id="propertyDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="downPaymentDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment %</span>
                        <strong id="downPaymentPercent">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="loanAmountDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>LTV Ratio</span>
                        <strong id="ltvDisplay">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>EMI Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Monthly EMI</span>
                        <strong id="emiAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="rateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Tenure</span>
                        <strong id="tenureDisplay">0 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Payments</span>
                        <strong id="numberOfPayments">0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Cost Analysis</h3>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="downPaymentCost">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Principal Repayment</span>
                        <strong id="principalRepayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Paid</span>
                        <strong id="interestPaid" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Cost of Home</strong></span>
                        <strong id="totalCost" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Affordability Check</h3>
                    <div class="breakdown-item">
                        <span>EMI to Income Ratio</span>
                        <strong id="emiRatio">Calculate below</strong>
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <label for="monthlyIncome">Your Monthly Income (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="monthlyIncome" value="10000" min="1000" step="500">
                        <small>EMI should be max 40% of income</small>
                    </div>
                    <div class="breakdown-item">
                        <span>Recommended Max EMI</span>
                        <strong id="maxEMI">$4,000</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Home Loan Tips:</strong> Down payment of 20% avoids PMI insurance. Keep EMI below 40% of monthly income. Lower interest rate = significant savings over loan term. Consider fixed vs. floating rates carefully.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('homeLoanForm');
        const currencySelect = document.getElementById('currency');
        const monthlyIncomeInput = document.getElementById('monthlyIncome');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateHomeLoan();
        });

        monthlyIncomeInput.addEventListener('input', calculateHomeLoan);

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
            document.getElementById('currencyLabel2').textContent = symbol;
            document.getElementById('currencyLabel3').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateHomeLoan();
        });

        function calculateHomeLoan() {
            const propertyValue = parseFloat(document.getElementById('propertyValue').value) || 0;
            const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
            const tenure = parseInt(document.getElementById('loanTenure').value) || 20;
            const annualRate = parseFloat(document.getElementById('interestRate').value) || 0;
            const monthlyIncome = parseFloat(document.getElementById('monthlyIncome').value) || 10000;
            const currency = currencySelect.value;

            const loanAmount = propertyValue - downPayment;
            const monthlyRate = annualRate / 12 / 100;
            const numberOfPayments = tenure * 12;

            // EMI Formula
            let emi = 0;
            if (monthlyRate > 0) {
                emi = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)) /
                      (Math.pow(1 + monthlyRate, numberOfPayments) - 1);
            } else {
                emi = loanAmount / numberOfPayments;
            }

            const totalPayment = emi * numberOfPayments;
            const totalInterest = totalPayment - loanAmount;
            const totalCost = downPayment + totalPayment;

            const downPaymentPercent = propertyValue > 0 ? (downPayment / propertyValue) * 100 : 0;
            const ltvRatio = propertyValue > 0 ? (loanAmount / propertyValue) * 100 : 0;

            const emiToIncomeRatio = monthlyIncome > 0 ? (emi / monthlyIncome) * 100 : 0;
            const maxAffordableEMI = monthlyIncome * 0.4;

            // Update UI
            document.getElementById('monthlyEMI').textContent = formatCurrency(emi, currency);
            document.getElementById('loanAmount').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('totalPayment').textContent = formatCurrency(totalPayment, currency);
            document.getElementById('ltvRatio').textContent = ltvRatio.toFixed(1) + '%';

            document.getElementById('propertyDisplay').textContent = formatCurrency(propertyValue, currency);
            document.getElementById('downPaymentDisplay').textContent = formatCurrency(downPayment, currency);
            document.getElementById('downPaymentPercent').textContent = downPaymentPercent.toFixed(1) + '%';
            document.getElementById('loanAmountDisplay').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('ltvDisplay').textContent = ltvRatio.toFixed(1) + '%';

            document.getElementById('emiAmount').textContent = formatCurrency(emi, currency);
            document.getElementById('rateDisplay').textContent = annualRate.toFixed(2) + '% p.a.';
            document.getElementById('tenureDisplay').textContent = tenure + ' years (' + numberOfPayments + ' months)';
            document.getElementById('numberOfPayments').textContent = numberOfPayments + ' EMIs';

            document.getElementById('downPaymentCost').textContent = formatCurrency(downPayment, currency);
            document.getElementById('principalRepayment').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('interestPaid').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('totalCost').textContent = formatCurrency(totalCost, currency);

            document.getElementById('emiRatio').textContent = emiToIncomeRatio.toFixed(1) + '% of income';
            document.getElementById('maxEMI').textContent = formatCurrency(maxAffordableEMI, currency) + ' (40% of income)';
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
            calculateHomeLoan();
        });
    </script>
</body>
</html>