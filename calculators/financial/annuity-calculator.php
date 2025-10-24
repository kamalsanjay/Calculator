<?php
/**
 * Annuity Calculator
 * File: annuity-calculator.php
 * Description: Calculate annuity payments and future value with USD/INR/EUR/GBP support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuity Calculator - Calculate Annuity Payments (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free annuity calculator. Calculate regular payments, future value, and retirement income streams. Supports ordinary and annuity due. USD, INR, EUR, GBP.">
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
        <h1>💵 Annuity Calculator</h1>
        <p>Calculate annuity payments and future value</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Annuity Details</h2>
                <form id="annuityForm">
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
                        <label for="calculationType">Calculate</label>
                        <select id="calculationType">
                            <option value="futureValue">Future Value (from payments)</option>
                            <option value="payment">Payment (to reach goal)</option>
                            <option value="presentValue">Present Value (of future payments)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="annuityType">Annuity Type</label>
                        <select id="annuityType">
                            <option value="ordinary">Ordinary Annuity (End of Period)</option>
                            <option value="due">Annuity Due (Beginning of Period)</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="paymentGroup">
                        <label for="payment">Payment per Period (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="payment" value="500" min="1" step="10" required>
                        <small>Regular payment amount</small>
                    </div>
                    
                    <div class="form-group" id="futureValueGroup" style="display: none;">
                        <label for="futureValueTarget">Future Value Target (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="futureValueTarget" value="100000" min="1" step="1000">
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% per annum)</label>
                        <input type="number" id="interestRate" value="6" min="0" max="20" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="periods">Number of Periods</label>
                        <input type="number" id="periods" value="240" min="1" step="1" required>
                        <small>Total payment periods (e.g., months)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="frequency">Payment Frequency</label>
                        <select id="frequency">
                            <option value="12">Monthly</option>
                            <option value="4">Quarterly</option>
                            <option value="2">Semi-Annually</option>
                            <option value="1">Annually</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Annuity</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Annuity Results</h2>
                
                <div class="result-card">
                    <h3 id="resultTitle">Future Value</h3>
                    <div class="amount" id="mainResult">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Contributions</h4>
                        <div class="value" id="totalContributions">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Interest Earned</h4>
                        <div class="value" id="interestEarned">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Payment per Period</h4>
                        <div class="value" id="paymentAmount">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Periods</h4>
                        <div class="value" id="totalPeriods">0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Annuity Summary</h3>
                    <div class="breakdown-item">
                        <span>Annuity Type</span>
                        <strong id="annuityTypeDisplay">Ordinary Annuity</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Payment per Period</span>
                        <strong id="paymentPerPeriod">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="rateDisplay">0% per period</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Number of Periods</span>
                        <strong id="periodsDisplay">0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Payment Frequency</span>
                        <strong id="frequencyDisplay">Monthly</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Financial Summary</h3>
                    <div class="breakdown-item">
                        <span>Total Payments Made</span>
                        <strong id="totalPayments">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest/Growth Earned</span>
                        <strong id="growthEarned" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Future Value</strong></span>
                        <strong id="futureValueDisplay" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Time-based Analysis</h3>
                    <div class="breakdown-item">
                        <span>Years</span>
                        <strong id="yearsDisplay">0 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Value after 5 years</span>
                        <strong id="value5">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Value after 10 years</span>
                        <strong id="value10">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Value after 20 years</span>
                        <strong id="value20">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Annuity Formulas</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; margin-bottom: 10px;">
                        <strong style="color: #667eea;">Future Value (Ordinary):</strong>
                        <div style="margin-top: 5px; font-family: monospace;">FV = PMT × [(1 + r)^n - 1] / r</div>
                    </div>
                    <div style="padding: 15px; background: white; border-radius: 5px;">
                        <strong style="color: #667eea;">Future Value (Due):</strong>
                        <div style="margin-top: 5px; font-family: monospace;">FV = PMT × [(1 + r)^n - 1] / r × (1 + r)</div>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Annuity Tips:</strong> Ordinary annuity = payments at end of period. Annuity due = payments at beginning (slightly higher FV). Common for retirement planning, pensions, structured settlements. Interest compounds over time. Regular payments build wealth through compound growth.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('annuityForm');
        const currencySelect = document.getElementById('currency');
        const calculationType = document.getElementById('calculationType');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateAnnuity();
        });

        calculationType.addEventListener('change', function() {
            toggleInputFields();
            calculateAnnuity();
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
            document.getElementById('currencyLabel1').textContent = symbol;
            document.getElementById('currencyLabel2').textContent = symbol;
        }

        function toggleInputFields() {
            const type = calculationType.value;
            const paymentGroup = document.getElementById('paymentGroup');
            const futureValueGroup = document.getElementById('futureValueGroup');

            if (type === 'payment') {
                paymentGroup.style.display = 'none';
                futureValueGroup.style.display = 'block';
            } else {
                paymentGroup.style.display = 'block';
                futureValueGroup.style.display = 'none';
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateAnnuity();
        });

        function calculateAnnuity() {
            const payment = parseFloat(document.getElementById('payment').value) || 0;
            const annualRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0;
            const periods = parseInt(document.getElementById('periods').value) || 0;
            const frequency = parseInt(document.getElementById('frequency').value) || 12;
            const annuityType = document.getElementById('annuityType').value;
            const calcType = calculationType.value;
            const futureValueTarget = parseFloat(document.getElementById('futureValueTarget').value) || 0;
            const currency = currencySelect.value;

            const periodRate = annualRate / frequency;
            const isDue = annuityType === 'due';

            let futureValue, calculatedPayment, totalContributions, interestEarned;

            if (calcType === 'futureValue' || calcType === 'presentValue') {
                // Calculate Future Value
                if (periodRate > 0) {
                    futureValue = payment * ((Math.pow(1 + periodRate, periods) - 1) / periodRate);
                    if (isDue) {
                        futureValue *= (1 + periodRate);
                    }
                } else {
                    futureValue = payment * periods;
                }
                
                calculatedPayment = payment;
                totalContributions = payment * periods;
                interestEarned = futureValue - totalContributions;
            } else {
                // Calculate Payment needed to reach target
                if (periodRate > 0) {
                    calculatedPayment = futureValueTarget / (((Math.pow(1 + periodRate, periods) - 1) / periodRate) * (isDue ? (1 + periodRate) : 1));
                } else {
                    calculatedPayment = futureValueTarget / periods;
                }
                
                futureValue = futureValueTarget;
                totalContributions = calculatedPayment * periods;
                interestEarned = futureValue - totalContributions;
            }

            // Calculate values at different years
            function valueAtPeriods(p) {
                const pmt = calcType === 'payment' ? calculatedPayment : payment;
                if (periodRate > 0) {
                    let fv = pmt * ((Math.pow(1 + periodRate, p) - 1) / periodRate);
                    if (isDue) fv *= (1 + periodRate);
                    return fv;
                }
                return pmt * p;
            }

            const value5Years = valueAtPeriods(Math.min(5 * frequency, periods));
            const value10Years = valueAtPeriods(Math.min(10 * frequency, periods));
            const value20Years = valueAtPeriods(Math.min(20 * frequency, periods));

            const years = periods / frequency;

            const frequencyNames = {
                '12': 'Monthly',
                '4': 'Quarterly',
                '2': 'Semi-Annually',
                '1': 'Annually'
            };

            // Update UI
            document.getElementById('resultTitle').textContent = calcType === 'payment' ? 'Required Payment' : 'Future Value';
            document.getElementById('mainResult').textContent = formatCurrency(calcType === 'payment' ? calculatedPayment : futureValue, currency);
            
            document.getElementById('totalContributions').textContent = formatCurrency(totalContributions, currency);
            document.getElementById('interestEarned').textContent = formatCurrency(interestEarned, currency);
            document.getElementById('paymentAmount').textContent = formatCurrency(calcType === 'payment' ? calculatedPayment : payment, currency);
            document.getElementById('totalPeriods').textContent = periods;

            document.getElementById('annuityTypeDisplay').textContent = isDue ? 'Annuity Due' : 'Ordinary Annuity';
            document.getElementById('paymentPerPeriod').textContent = formatCurrency(calcType === 'payment' ? calculatedPayment : payment, currency);
            document.getElementById('rateDisplay').textContent = (periodRate * 100).toFixed(3) + '% per period (' + annualRate.toFixed(2) + '% annual)';
            document.getElementById('periodsDisplay').textContent = periods + ' periods';
            document.getElementById('frequencyDisplay').textContent = frequencyNames[frequency];

            document.getElementById('totalPayments').textContent = formatCurrency(totalContributions, currency);
            document.getElementById('growthEarned').textContent = formatCurrency(interestEarned, currency);
            document.getElementById('futureValueDisplay').textContent = formatCurrency(futureValue, currency);

            document.getElementById('yearsDisplay').textContent = years.toFixed(1) + ' years';
            document.getElementById('value5').textContent = formatCurrency(value5Years, currency);
            document.getElementById('value10').textContent = formatCurrency(value10Years, currency);
            document.getElementById('value20').textContent = formatCurrency(value20Years, currency);
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
            toggleInputFields();
            calculateAnnuity();
        });
    </script>
</body>
</html>