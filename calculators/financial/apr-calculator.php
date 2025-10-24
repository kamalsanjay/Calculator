<?php
/**
 * APR Calculator
 * File: apr-calculator.php
 * Description: Calculate Annual Percentage Rate with fees and charges (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APR Calculator - Calculate True Annual Percentage Rate (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free APR calculator. Calculate true annual percentage rate including fees and charges. Compare APR vs nominal rate. Supports USD, INR, EUR, and GBP.">
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
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
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
        <h1>📊 APR Calculator</h1>
        <p>Calculate Annual Percentage Rate with fees</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Loan Details</h2>
                <form id="aprForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                            <option value="EUR">EUR (€)</option>
                            <option value="GBP">GBP (£)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanAmount">Loan Amount (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="loanAmount" value="10000" min="100" step="100" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nominalRate">Nominal Interest Rate (%)</label>
                        <input type="number" id="nominalRate" value="12" min="0" max="50" step="0.1" required>
                        <small>Stated interest rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Months)</label>
                        <input type="number" id="loanTerm" value="12" min="1" max="360" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="originationFee">Origination Fee (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="originationFee" value="250" min="0" step="10">
                        <small>Upfront loan processing fee</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="closingCosts">Closing Costs (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="closingCosts" value="100" min="0" step="10">
                        <small>Additional upfront costs</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="otherFees">Other Fees (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="otherFees" value="50" min="0" step="10">
                        <small>Insurance, admin fees, etc.</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate APR</button>
                </form>
            </div>

            <div class="results-section">
                <h2>APR Results</h2>
                
                <div class="result-card">
                    <h3>Annual Percentage Rate</h3>
                    <div class="amount" id="aprRate">0%</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Nominal Rate</h4>
                        <div class="value" id="nominalDisplay">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Monthly Payment</h4>
                        <div class="value" id="monthlyPayment">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Fees</h4>
                        <div class="value" id="totalFees">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Loan Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="loanAmountDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Nominal Interest Rate</span>
                        <strong id="rateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Term</span>
                        <strong id="termDisplay">0 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="paymentDisplay">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Fee Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Origination Fee</span>
                        <strong id="originationDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Closing Costs</span>
                        <strong id="closingDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Fees</span>
                        <strong id="otherFeesDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Fees</strong></span>
                        <strong id="totalFeesDisplay" style="color: #FF9800; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Cost Analysis</h3>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="principalAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest Paid</span>
                        <strong id="totalInterest">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Fees</span>
                        <strong id="feesAmount">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Amount Paid</strong></span>
                        <strong id="totalPaid" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Rate Comparison</h3>
                    <div class="breakdown-item">
                        <span>Nominal Interest Rate</span>
                        <strong id="nominalRateComp">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Effective APR (with fees)</span>
                        <strong id="aprComp" style="color: #FF9800; font-size: 1.1em;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Additional Cost</span>
                        <strong id="additionalCost" style="color: #f44336;">+0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Net Loan Amount</h3>
                    <div class="breakdown-item">
                        <span>Loan Amount (stated)</span>
                        <strong id="statedAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Less: Upfront Fees</span>
                        <strong id="upfrontFees" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Amount Received</strong></span>
                        <strong id="netAmount" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>APR Explained:</strong> APR = true cost of borrowing including fees. Higher than nominal rate when fees exist. Required by law for loan disclosures. Compare APRs across lenders, not just interest rates. Lower APR = better deal. Calculate total cost, not just monthly payment.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('aprForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateAPR();
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

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateAPR();
        });

        function calculateAPR() {
            const loanAmount = parseFloat(document.getElementById('loanAmount').value) || 0;
            const nominalRate = parseFloat(document.getElementById('nominalRate').value) / 100 || 0;
            const months = parseInt(document.getElementById('loanTerm').value) || 12;
            const originationFee = parseFloat(document.getElementById('originationFee').value) || 0;
            const closingCosts = parseFloat(document.getElementById('closingCosts').value) || 0;
            const otherFees = parseFloat(document.getElementById('otherFees').value) || 0;
            const currency = currencySelect.value;

            // Calculate monthly payment based on nominal rate
            const monthlyRate = nominalRate / 12;
            let monthlyPayment = 0;
            
            if (monthlyRate > 0) {
                monthlyPayment = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, months)) /
                               (Math.pow(1 + monthlyRate, months) - 1);
            } else {
                monthlyPayment = loanAmount / months;
            }

            // Total fees
            const totalFees = originationFee + closingCosts + otherFees;
            
            // Net amount received (loan minus upfront fees)
            const netAmount = loanAmount - totalFees;
            
            // Total amount paid
            const totalPaid = monthlyPayment * months;
            const totalInterest = totalPaid - loanAmount;
            const totalCost = totalPaid + totalFees;

            // Calculate APR using Newton-Raphson method
            // APR is the rate that makes: netAmount = sum of discounted monthly payments
            let apr = nominalRate; // Start with nominal rate
            
            for (let i = 0; i < 20; i++) {
                let pv = 0;
                let pvDerivative = 0;
                const monthlyAPR = apr / 12;
                
                for (let month = 1; month <= months; month++) {
                    const discount = Math.pow(1 + monthlyAPR, month);
                    pv += monthlyPayment / discount;
                    pvDerivative += (-month * monthlyPayment) / (12 * discount * (1 + monthlyAPR));
                }
                
                const diff = pv - netAmount;
                if (Math.abs(diff) < 0.01) break;
                
                apr = apr - diff / pvDerivative;
            }

            const additionalCost = apr - nominalRate;

            // Update UI
            document.getElementById('aprRate').textContent = (apr * 100).toFixed(2) + '%';
            document.getElementById('nominalDisplay').textContent = (nominalRate * 100).toFixed(2) + '%';
            document.getElementById('monthlyPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('totalFees').textContent = formatCurrency(totalFees, currency);
            document.getElementById('totalCost').textContent = formatCurrency(totalCost, currency);

            document.getElementById('loanAmountDisplay').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('rateDisplay').textContent = (nominalRate * 100).toFixed(2) + '% per annum';
            document.getElementById('termDisplay').textContent = months + ' months';
            document.getElementById('paymentDisplay').textContent = formatCurrency(monthlyPayment, currency);

            document.getElementById('originationDisplay').textContent = formatCurrency(originationFee, currency);
            document.getElementById('closingDisplay').textContent = formatCurrency(closingCosts, currency);
            document.getElementById('otherFeesDisplay').textContent = formatCurrency(otherFees, currency);
            document.getElementById('totalFeesDisplay').textContent = formatCurrency(totalFees, currency);

            document.getElementById('principalAmount').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('feesAmount').textContent = formatCurrency(totalFees, currency);
            document.getElementById('totalPaid').textContent = formatCurrency(totalCost, currency);

            document.getElementById('nominalRateComp').textContent = (nominalRate * 100).toFixed(2) + '%';
            document.getElementById('aprComp').textContent = (apr * 100).toFixed(2) + '%';
            document.getElementById('additionalCost').textContent = '+' + (additionalCost * 100).toFixed(2) + '%';

            document.getElementById('statedAmount').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('upfrontFees').textContent = formatCurrency(totalFees, currency);
            document.getElementById('netAmount').textContent = formatCurrency(netAmount, currency);
        }

        function formatCurrency(amount, currency) {
            const locale = currency === 'INR' ? 'en-IN' : currency === 'EUR' ? 'de-DE' : currency === 'GBP' ? 'en-GB' : 'en-US';
            return new Intl.NumberFormat(locale, {
                style: 'currency',
                currency: currency,
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(amount);
        }

        window.addEventListener('load', function() {
            updateCurrencyLabels();
            calculateAPR();
        });
    </script>
</body>
</html>