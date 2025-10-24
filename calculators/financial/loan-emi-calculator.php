<?php
/**
 * Loan EMI Calculator
 * File: loan-emi-calculator.php
 * Description: Calculate Equated Monthly Installment for loans with USD/INR support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan EMI Calculator - Calculate Monthly Payment (USD/INR)</title>
    <meta name="description" content="Free loan EMI calculator. Calculate monthly installments for home, car, personal loans. Supports USD and INR currencies. Get amortization schedule instantly.">
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
        <h1>💰 Loan EMI Calculator</h1>
        <p>Calculate your monthly loan installment easily</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Loan Details</h2>
                <form id="emiForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanAmount">Loan Amount (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="loanAmount" value="100000" min="1000" step="1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% per annum)</label>
                        <input type="number" id="interestRate" value="8.5" min="0.1" max="30" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTenure">Loan Tenure (Years)</label>
                        <input type="number" id="loanTenure" value="10" min="1" max="30" step="1" required>
                    </div>
                    
                    <button type="submit" class="btn">Calculate EMI</button>
                </form>
            </div>

            <div class="results-section">
                <h2>EMI Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Monthly EMI</h3>
                    <div class="amount" id="emiAmount">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Principal Amount</h4>
                        <div class="value" id="principalAmount">$0</div>
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
                        <h4>Loan Tenure</h4>
                        <div class="value" id="tenureDisplay">0 years</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Payment Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="loanAmountDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="interestRateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Tenure</span>
                        <strong id="tenureMonths">0 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly EMI</span>
                        <strong id="monthlyEmi">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest Payable</span>
                        <strong id="interestPayable">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Amount Payable</strong></span>
                        <strong id="totalAmountPayable" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>EMI Formula:</strong> EMI = [P x R x (1+R)^N]/[(1+R)^N-1], where P = Principal, R = Monthly interest rate, N = Number of months. Your EMI remains constant throughout the loan tenure.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('emiForm');
        const currencySelect = document.getElementById('currency');

        // Currency change event
        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateEMI();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateEMI();
        });

        function calculateEMI() {
            const loanAmount = parseFloat(document.getElementById('loanAmount').value) || 0;
            const annualRate = parseFloat(document.getElementById('interestRate').value) || 0;
            const years = parseInt(document.getElementById('loanTenure').value) || 0;
            const currency = currencySelect.value;

            const monthlyRate = annualRate / 12 / 100;
            const months = years * 12;

            let emi = 0;
            if (monthlyRate > 0) {
                emi = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, months)) / 
                      (Math.pow(1 + monthlyRate, months) - 1);
            } else {
                emi = loanAmount / months;
            }

            const totalPayment = emi * months;
            const totalInterest = totalPayment - loanAmount;

            // Update UI
            document.getElementById('emiAmount').textContent = formatCurrency(emi, currency);
            document.getElementById('principalAmount').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('totalPayment').textContent = formatCurrency(totalPayment, currency);
            document.getElementById('tenureDisplay').textContent = years + ' years';

            document.getElementById('loanAmountDisplay').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('interestRateDisplay').textContent = annualRate.toFixed(2) + '%';
            document.getElementById('tenureMonths').textContent = months + ' months';
            document.getElementById('monthlyEmi').textContent = formatCurrency(emi, currency);
            document.getElementById('interestPayable').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('totalAmountPayable').textContent = formatCurrency(totalPayment, currency);
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

        // Calculate on page load
        window.addEventListener('load', function() {
            updateCurrencyLabels();
            calculateEMI();
        });
    </script>
</body>
</html>