<?php
/**
 * SIP Calculator
 * File: sip-calculator.php
 * Description: Calculate Systematic Investment Plan returns for mutual funds (USD/INR)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIP Calculator - Systematic Investment Plan Calculator (USD/INR)</title>
    <meta name="description" content="Free SIP calculator. Calculate mutual fund SIP returns with monthly investments. Systematic Investment Plan calculator for wealth creation. Supports USD and INR.">
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
        <h1>📊 SIP Calculator</h1>
        <p>Calculate Systematic Investment Plan returns for mutual funds</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>SIP Investment Details</h2>
                <form id="sipForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="monthlyInvestment">Monthly Investment (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="monthlyInvestment" value="5000" min="100" step="100" required>
                        <small>Amount to invest every month</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="duration">Investment Duration (Years)</label>
                        <input type="number" id="duration" value="10" min="1" max="50" step="1" required>
                        <small>How long to invest via SIP</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="expectedReturn">Expected Annual Return (%)</label>
                        <input type="number" id="expectedReturn" value="12" min="1" max="30" step="0.1" required>
                        <small>Expected annual return rate</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate SIP Returns</button>
                </form>
            </div>

            <div class="results-section">
                <h2>SIP Maturity Details</h2>
                
                <div class="result-card">
                    <h3>Maturity Value</h3>
                    <div class="amount" id="maturityValue">$11,46,557</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Invested</h4>
                        <div class="value" id="totalInvested">$6,00,000</div>
                    </div>
                    <div class="metric-card">
                        <h4>Wealth Gained</h4>
                        <div class="value" id="wealthGained">$5,46,557</div>
                    </div>
                    <div class="metric-card">
                        <h4>Expected Returns</h4>
                        <div class="value" id="returnRate">12%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Return %</h4>
                        <div class="value" id="totalReturnPercent">91.1%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>SIP Formula</h3>
                    <div class="breakdown-item">
                        <span>Formula</span>
                        <strong>FV = P × ({[1+r]^n - 1} / r) × (1+r)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>P (Monthly Investment)</span>
                        <strong id="pValue">$5,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>r (Monthly Return)</span>
                        <strong id="rValue">0.95%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>n (Total Months)</span>
                        <strong id="nValue">120</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Investment Summary</h3>
                    <div class="breakdown-item">
                        <span>Monthly Investment</span>
                        <strong id="monthlyAmount">$5,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Investment Period</span>
                        <strong id="investmentPeriod">10 years (120 months)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Amount Invested</span>
                        <strong id="totalPrincipal">$6,00,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Wealth Gained (Returns)</span>
                        <strong id="wealthAmount" style="color: #4CAF50;">$5,46,557</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Maturity Value</strong></span>
                        <strong id="maturityAmount" style="color: #667eea; font-size: 1.2em;">$11,46,557</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Year-by-Year Growth</h3>
                    <div class="breakdown-item">
                        <span>After 3 Years</span>
                        <strong id="year3">$2,17,038</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 5 Years</span>
                        <strong id="year5">$4,08,219</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 7 Years</span>
                        <strong id="year7">$6,45,847</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 10 Years</span>
                        <strong id="year10">$11,46,557</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 15 Years</span>
                        <strong id="year15">$24,99,567</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Performance Metrics</h3>
                    <div class="breakdown-item">
                        <span>Absolute Return %</span>
                        <strong id="absoluteReturn">91.1%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAGR (Annualized)</span>
                        <strong id="cagrReturn">12.0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Return Multiple</span>
                        <strong id="returnMultiple">1.91x</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>SIP Benefits:</strong> Rupee cost averaging reduces market volatility impact. Power of compounding grows wealth exponentially. Disciplined investing builds long-term corpus. Formula: FV = P × ({[1+r]^n - 1} / r) × (1+r). Start early for maximum returns!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('sipForm');
        const currencySelect = document.getElementById('currency');

        // Currency change
        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateSIP();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateSIP();
        });

        function calculateSIP() {
            const monthlyInvestment = parseFloat(document.getElementById('monthlyInvestment').value) || 5000;
            const duration = parseInt(document.getElementById('duration').value) || 10;
            const expectedReturn = parseFloat(document.getElementById('expectedReturn').value) / 100 || 0.12;
            const currency = currencySelect.value;

            // Convert annual return to monthly return
            const monthlyReturn = Math.pow(1 + expectedReturn, 1/12) - 1;
            const totalMonths = duration * 12;

            // SIP Formula: FV = P × ({[1+r]^n - 1} / r) × (1+r)
            const maturityAmount = monthlyInvestment * 
                ((Math.pow(1 + monthlyReturn, totalMonths) - 1) / monthlyReturn) * 
                (1 + monthlyReturn);

            const totalInvestedAmount = monthlyInvestment * totalMonths;
            const wealthGainedAmount = maturityAmount - totalInvestedAmount;
            const totalReturnPercentValue = (wealthGainedAmount / totalInvestedAmount) * 100;
            const returnMultipleValue = maturityAmount / totalInvestedAmount;

            // Year-wise calculations
            function calculateYearValue(years) {
                const months = years * 12;
                return monthlyInvestment * 
                    ((Math.pow(1 + monthlyReturn, months) - 1) / monthlyReturn) * 
                    (1 + monthlyReturn);
            }

            const year3Value = calculateYearValue(3);
            const year5Value = calculateYearValue(5);
            const year7Value = calculateYearValue(7);
            const year10Value = calculateYearValue(10);
            const year15Value = calculateYearValue(15);

            // Update UI
            document.getElementById('maturityValue').textContent = formatCurrency(maturityAmount, currency);
            document.getElementById('totalInvested').textContent = formatCurrency(totalInvestedAmount, currency);
            document.getElementById('wealthGained').textContent = formatCurrency(wealthGainedAmount, currency);
            document.getElementById('returnRate').textContent = (expectedReturn * 100).toFixed(1) + '%';
            document.getElementById('totalReturnPercent').textContent = totalReturnPercentValue.toFixed(1) + '%';

            document.getElementById('pValue').textContent = formatCurrency(monthlyInvestment, currency);
            document.getElementById('rValue').textContent = (monthlyReturn * 100).toFixed(2) + '%';
            document.getElementById('nValue').textContent = totalMonths + ' months';

            document.getElementById('monthlyAmount').textContent = formatCurrency(monthlyInvestment, currency);
            document.getElementById('investmentPeriod').textContent = duration + ' years (' + totalMonths + ' months)';
            document.getElementById('totalPrincipal').textContent = formatCurrency(totalInvestedAmount, currency);
            document.getElementById('wealthAmount').textContent = formatCurrency(wealthGainedAmount, currency);
            document.getElementById('maturityAmount').textContent = formatCurrency(maturityAmount, currency);

            document.getElementById('year3').textContent = formatCurrency(year3Value, currency);
            document.getElementById('year5').textContent = formatCurrency(year5Value, currency);
            document.getElementById('year7').textContent = formatCurrency(year7Value, currency);
            document.getElementById('year10').textContent = formatCurrency(year10Value, currency);
            document.getElementById('year15').textContent = formatCurrency(year15Value, currency);

            document.getElementById('absoluteReturn').textContent = totalReturnPercentValue.toFixed(1) + '%';
            document.getElementById('cagrReturn').textContent = (expectedReturn * 100).toFixed(1) + '%';
            document.getElementById('returnMultiple').textContent = returnMultipleValue.toFixed(2) + 'x';
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
            calculateSIP();
        });
    </script>
</body>
</html>