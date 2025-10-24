<?php
/**
 * Investment Calculator
 * File: investment-calculator.php
 * Description: Calculate investment returns with lump sum and regular contributions (USD/INR)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investment Calculator - Calculate Investment Returns (USD/INR)</title>
    <meta name="description" content="Free investment calculator. Calculate returns on lump sum and regular investments. Plan your wealth creation with compound interest. Supports USD and INR.">
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
        <h1>📊 Investment Calculator</h1>
        <p>Calculate returns on your investments with compound growth</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Investment Details</h2>
                <form id="investmentForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="initialInvestment">Initial Investment (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="initialInvestment" value="10000" min="0" step="100" required>
                        <small>One-time lump sum amount</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="regularContribution">Regular Contribution (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="regularContribution" value="500" min="0" step="10" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="frequency">Contribution Frequency</label>
                        <select id="frequency">
                            <option value="12" selected>Monthly</option>
                            <option value="4">Quarterly</option>
                            <option value="2">Semi-Annually</option>
                            <option value="1">Annually</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="returnRate">Expected Annual Return (%)</label>
                        <input type="number" id="returnRate" value="10" min="0" max="50" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="duration">Investment Duration (Years)</label>
                        <input type="number" id="duration" value="10" min="1" max="50" step="1" required>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Returns</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Investment Returns</h2>
                
                <div class="result-card">
                    <h3>Future Value</h3>
                    <div class="amount" id="futureValue">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Invested</h4>
                        <div class="value" id="totalInvested">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Returns</h4>
                        <div class="value" id="totalReturns">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Return %</h4>
                        <div class="value" id="returnPercent">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>CAGR</h4>
                        <div class="value" id="cagrDisplay">0%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Investment Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Initial Investment</span>
                        <strong id="initialAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Regular Contribution</span>
                        <strong id="contributionAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Contribution Frequency</span>
                        <strong id="frequencyDisplay">Monthly</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Contributions</span>
                        <strong id="totalContributions">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Expected Return Rate</span>
                        <strong id="rateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Investment Duration</span>
                        <strong id="durationDisplay">0 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Amount Invested</span>
                        <strong id="investedTotal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Investment Returns</span>
                        <strong id="returnsTotal" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Future Value</strong></span>
                        <strong id="totalValue" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Growth Timeline</h3>
                    <div class="breakdown-item">
                        <span>After 5 Years</span>
                        <strong id="year5">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 10 Years</span>
                        <strong id="year10">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 15 Years</span>
                        <strong id="year15">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 20 Years</span>
                        <strong id="year20">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Investment Growth:</strong> Combines initial lump sum growth with regular contributions. Formula: FV = P(1+r)^n + PMT × [((1+r)^n - 1) / r]. The power of compounding accelerates wealth creation over time!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('investmentForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateInvestment();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
            document.getElementById('currencyLabel2').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateInvestment();
        });

        function calculateInvestment() {
            const initialInvestment = parseFloat(document.getElementById('initialInvestment').value) || 0;
            const regularContribution = parseFloat(document.getElementById('regularContribution').value) || 0;
            const frequency = parseInt(document.getElementById('frequency').value) || 12;
            const annualRate = parseFloat(document.getElementById('returnRate').value) / 100 || 0;
            const years = parseInt(document.getElementById('duration').value) || 0;
            const currency = currencySelect.value;

            const ratePerPeriod = annualRate / frequency;
            const totalPeriods = years * frequency;

            // Future value of initial investment
            const fvInitial = initialInvestment * Math.pow(1 + ratePerPeriod, totalPeriods);
            
            // Future value of regular contributions
            const fvContributions = regularContribution * ((Math.pow(1 + ratePerPeriod, totalPeriods) - 1) / ratePerPeriod);
            
            const futureValue = fvInitial + fvContributions;
            const totalInvested = initialInvestment + (regularContribution * totalPeriods);
            const totalReturns = futureValue - totalInvested;
            const returnPercent = totalInvested > 0 ? (totalReturns / totalInvested) * 100 : 0;

            const frequencyNames = {
                12: 'Monthly',
                4: 'Quarterly',
                2: 'Semi-Annually',
                1: 'Annually'
            };

            // Calculate values at different years
            function calculateAtYear(y) {
                const periods = y * frequency;
                const fvInit = initialInvestment * Math.pow(1 + ratePerPeriod, periods);
                const fvCont = regularContribution * ((Math.pow(1 + ratePerPeriod, periods) - 1) / ratePerPeriod);
                return fvInit + fvCont;
            }

            // Update UI
            document.getElementById('futureValue').textContent = formatCurrency(futureValue, currency);
            document.getElementById('totalInvested').textContent = formatCurrency(totalInvested, currency);
            document.getElementById('totalReturns').textContent = formatCurrency(totalReturns, currency);
            document.getElementById('returnPercent').textContent = returnPercent.toFixed(2) + '%';
            document.getElementById('cagrDisplay').textContent = (annualRate * 100).toFixed(2) + '%';

            document.getElementById('initialAmount').textContent = formatCurrency(initialInvestment, currency);
            document.getElementById('contributionAmount').textContent = formatCurrency(regularContribution, currency);
            document.getElementById('frequencyDisplay').textContent = frequencyNames[frequency];
            document.getElementById('totalContributions').textContent = (regularContribution * totalPeriods).toFixed(0) + ' contributions';
            document.getElementById('rateDisplay').textContent = (annualRate * 100).toFixed(2) + '%';
            document.getElementById('durationDisplay').textContent = years + ' years';
            document.getElementById('investedTotal').textContent = formatCurrency(totalInvested, currency);
            document.getElementById('returnsTotal').textContent = formatCurrency(totalReturns, currency);
            document.getElementById('totalValue').textContent = formatCurrency(futureValue, currency);

            document.getElementById('year5').textContent = formatCurrency(calculateAtYear(5), currency);
            document.getElementById('year10').textContent = formatCurrency(calculateAtYear(10), currency);
            document.getElementById('year15').textContent = formatCurrency(calculateAtYear(15), currency);
            document.getElementById('year20').textContent = formatCurrency(calculateAtYear(20), currency);
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
            calculateInvestment();
        });
    </script>
</body>
</html>