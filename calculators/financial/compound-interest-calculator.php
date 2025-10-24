<?php
/**
 * Compound Interest Calculator
 * File: compound-interest-calculator.php
 * Description: Calculate compound interest with different compounding frequencies (USD/INR)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compound Interest Calculator - Calculate Returns (USD/INR)</title>
    <meta name="description" content="Free compound interest calculator. Calculate compound interest with daily, monthly, quarterly, yearly compounding. Supports USD and INR. See total returns and interest earned.">
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
        <h1>📈 Compound Interest Calculator</h1>
        <p>Calculate the power of compounding on your investments</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Investment Details</h2>
                <form id="compoundForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="principal">Principal Amount (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="principal" value="10000" min="1" step="100" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="rate">Annual Interest Rate (%)</label>
                        <input type="number" id="rate" value="8" min="0.1" max="50" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="time">Time Period (Years)</label>
                        <input type="number" id="time" value="5" min="1" max="50" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="frequency">Compounding Frequency</label>
                        <select id="frequency">
                            <option value="1">Annually (1x per year)</option>
                            <option value="2">Semi-Annually (2x per year)</option>
                            <option value="4">Quarterly (4x per year)</option>
                            <option value="12" selected>Monthly (12x per year)</option>
                            <option value="365">Daily (365x per year)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Returns</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Investment Returns</h2>
                
                <div class="result-card">
                    <h3>Final Amount</h3>
                    <div class="amount" id="finalAmount">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Principal</h4>
                        <div class="value" id="principalDisplay">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Interest Earned</h4>
                        <div class="value" id="interestEarned">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Return %</h4>
                        <div class="value" id="totalReturn">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Time Period</h4>
                        <div class="value" id="timeDisplay">0 years</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Investment Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Principal Amount</span>
                        <strong id="principalAmount">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="rateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Time Period</span>
                        <strong id="timePeriod">0 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Compounding</span>
                        <strong id="compoundingDisplay">Monthly</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Earned</span>
                        <strong id="interestAmount" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Final Amount</strong></span>
                        <strong id="totalAmount" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Year-by-Year Growth</h3>
                    <div class="breakdown-item">
                        <span>After 1 Year</span>
                        <strong id="year1">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 3 Years</span>
                        <strong id="year3">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 5 Years</span>
                        <strong id="year5">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 10 Years</span>
                        <strong id="year10">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Compound Interest Formula:</strong> A = P(1 + r/n)^(nt), where A is final amount, P is principal, r is annual rate, n is compounding frequency, and t is time in years. More frequent compounding means higher returns!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('compoundForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateCompound();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateCompound();
        });

        function calculateCompound() {
            const principal = parseFloat(document.getElementById('principal').value) || 0;
            const rate = parseFloat(document.getElementById('rate').value) / 100 || 0;
            const time = parseInt(document.getElementById('time').value) || 0;
            const frequency = parseInt(document.getElementById('frequency').value) || 12;
            const currency = currencySelect.value;

            // Compound Interest Formula: A = P(1 + r/n)^(nt)
            const amount = principal * Math.pow((1 + rate / frequency), frequency * time);
            const interest = amount - principal;
            const returnPercent = (interest / principal) * 100;

            // Year-wise calculations
            const year1Amount = principal * Math.pow((1 + rate / frequency), frequency * 1);
            const year3Amount = principal * Math.pow((1 + rate / frequency), frequency * 3);
            const year5Amount = principal * Math.pow((1 + rate / frequency), frequency * 5);
            const year10Amount = principal * Math.pow((1 + rate / frequency), frequency * 10);

            const frequencyNames = {
                1: 'Annually',
                2: 'Semi-Annually',
                4: 'Quarterly',
                12: 'Monthly',
                365: 'Daily'
            };

            // Update UI
            document.getElementById('finalAmount').textContent = formatCurrency(amount, currency);
            document.getElementById('principalDisplay').textContent = formatCurrency(principal, currency);
            document.getElementById('interestEarned').textContent = formatCurrency(interest, currency);
            document.getElementById('totalReturn').textContent = returnPercent.toFixed(2) + '%';
            document.getElementById('timeDisplay').textContent = time + ' years';

            document.getElementById('principalAmount').textContent = formatCurrency(principal, currency);
            document.getElementById('rateDisplay').textContent = (rate * 100).toFixed(2) + '%';
            document.getElementById('timePeriod').textContent = time + ' years';
            document.getElementById('compoundingDisplay').textContent = frequencyNames[frequency];
            document.getElementById('interestAmount').textContent = formatCurrency(interest, currency);
            document.getElementById('totalAmount').textContent = formatCurrency(amount, currency);

            document.getElementById('year1').textContent = formatCurrency(year1Amount, currency);
            document.getElementById('year3').textContent = formatCurrency(year3Amount, currency);
            document.getElementById('year5').textContent = formatCurrency(year5Amount, currency);
            document.getElementById('year10').textContent = formatCurrency(year10Amount, currency);
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
            calculateCompound();
        });
    </script>
</body>
</html>