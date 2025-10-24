<?php
/**
 * Business Loan Calculator
 * File: business-loan-calculator.php
 * Description: Calculate business loan EMI with working capital needs (USD/INR)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Loan Calculator - Calculate Business Loan EMI (USD/INR)</title>
    <meta name="description" content="Free business loan calculator. Calculate monthly EMI for business financing, working capital loans, and equipment financing. Supports USD and INR.">
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
        <h1>💼 Business Loan Calculator</h1>
        <p>Calculate your business loan EMI and financing costs</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Business Loan Details</h2>
                <form id="businessLoanForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanAmount">Loan Amount (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="loanAmount" value="100000" min="5000" step="5000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanType">Loan Type</label>
                        <select id="loanType">
                            <option value="working">Working Capital</option>
                            <option value="equipment">Equipment Financing</option>
                            <option value="expansion">Business Expansion</option>
                            <option value="term">Term Loan</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% per annum)</label>
                        <input type="number" id="interestRate" value="11" min="8" max="24" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTenure">Loan Tenure (Years)</label>
                        <input type="number" id="loanTenure" value="5" min="1" max="15" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="processingFee">Processing Fee (% of loan)</label>
                        <input type="number" id="processingFee" value="2" min="0" max="5" step="0.1">
                        <small>Typically 1-3% of loan amount</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Business Loan</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Loan Calculation</h2>
                
                <div class="result-card">
                    <h3>Monthly EMI</h3>
                    <div class="amount" id="monthlyEMI">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Loan Amount</h4>
                        <div class="value" id="principalAmount">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Interest</h4>
                        <div class="value" id="totalInterest">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Processing Fee</h4>
                        <div class="value" id="feeAmount">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Loan Summary</h3>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="loanAmountDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Type</span>
                        <strong id="loanTypeDisplay">Working Capital</strong>
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
                        <span>Processing Fee</span>
                        <strong id="feeDisplay">$0 (0%)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>EMI Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Monthly EMI</span>
                        <strong id="emiAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Number of EMIs</span>
                        <strong id="numberOfEMIs">0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total EMI Payments</span>
                        <strong id="totalEMI">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Cost Analysis</h3>
                    <div class="breakdown-item">
                        <span>Principal Amount</span>
                        <strong id="principalCost">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest Paid</span>
                        <strong id="interestCost" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Processing Fee (Upfront)</span>
                        <strong id="processingCost">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Cost of Loan</strong></span>
                        <strong id="totalLoanCost" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Business Cash Flow Impact</h3>
                    <div class="breakdown-item">
                        <span>Loan Received (After Fee)</span>
                        <strong id="netLoan" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Outflow (EMI)</span>
                        <strong id="monthlyOutflow">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Outflow</span>
                        <strong id="annualOutflow">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Business Loan Tips:</strong> Working capital loans have shorter tenure. Equipment loans offer collateral-based lower rates. Maintain good credit score for better rates. Processing fees are 1-3% typically. Keep EMI below 30% of monthly revenue for healthy cash flow.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('businessLoanForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateBusinessLoan();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBusinessLoan();
        });

        function calculateBusinessLoan() {
            const loanAmount = parseFloat(document.getElementById('loanAmount').value) || 0;
            const loanType = document.getElementById('loanType').value;
            const annualRate = parseFloat(document.getElementById('interestRate').value) || 0;
            const tenure = parseInt(document.getElementById('loanTenure').value) || 5;
            const feePercent = parseFloat(document.getElementById('processingFee').value) || 0;
            const currency = currencySelect.value;

            const monthlyRate = annualRate / 12 / 100;
            const numberOfPayments = tenure * 12;
            const processingFee = (loanAmount * feePercent) / 100;

            // EMI Calculation
            let emi = 0;
            if (monthlyRate > 0) {
                emi = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)) /
                      (Math.pow(1 + monthlyRate, numberOfPayments) - 1);
            } else {
                emi = loanAmount / numberOfPayments;
            }

            const totalEMIPayments = emi * numberOfPayments;
            const totalInterest = totalEMIPayments - loanAmount;
            const totalCost = loanAmount + totalInterest + processingFee;
            const netLoanAmount = loanAmount - processingFee;
            const annualOutflow = emi * 12;

            const loanTypeNames = {
                'working': 'Working Capital',
                'equipment': 'Equipment Financing',
                'expansion': 'Business Expansion',
                'term': 'Term Loan'
            };

            // Update UI
            document.getElementById('monthlyEMI').textContent = formatCurrency(emi, currency);
            document.getElementById('principalAmount').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('feeAmount').textContent = formatCurrency(processingFee, currency);
            document.getElementById('totalCost').textContent = formatCurrency(totalCost, currency);

            document.getElementById('loanAmountDisplay').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('loanTypeDisplay').textContent = loanTypeNames[loanType];
            document.getElementById('rateDisplay').textContent = annualRate.toFixed(2) + '% p.a.';
            document.getElementById('tenureDisplay').textContent = tenure + ' years (' + numberOfPayments + ' months)';
            document.getElementById('feeDisplay').textContent = formatCurrency(processingFee, currency) + ' (' + feePercent.toFixed(1) + '%)';

            document.getElementById('emiAmount').textContent = formatCurrency(emi, currency);
            document.getElementById('numberOfEMIs').textContent = numberOfPayments + ' months';
            document.getElementById('totalEMI').textContent = formatCurrency(totalEMIPayments, currency);

            document.getElementById('principalCost').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('interestCost').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('processingCost').textContent = formatCurrency(processingFee, currency);
            document.getElementById('totalLoanCost').textContent = formatCurrency(totalCost, currency);

            document.getElementById('netLoan').textContent = formatCurrency(netLoanAmount, currency);
            document.getElementById('monthlyOutflow').textContent = formatCurrency(emi, currency);
            document.getElementById('annualOutflow').textContent = formatCurrency(annualOutflow, currency);
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
            calculateBusinessLoan();
        });
    </script>
</body>
</html>