<?php
/**
 * CAGR Calculator
 * File: cagr-calculator.php
 * Description: Calculate Compound Annual Growth Rate for investments
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAGR Calculator - Compound Annual Growth Rate Calculator (USD/INR)</title>
    <meta name="description" content="Free CAGR calculator. Calculate compound annual growth rate for investments. Compare returns, find annualized growth rate using CAGR formula. Supports USD and INR.">
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
        <h1>📈 CAGR Calculator</h1>
        <p>Calculate Compound Annual Growth Rate for your investments</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Investment Details</h2>
                <form id="cagrForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="initialValue">Initial Value (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="initialValue" value="10000" min="0" step="100" required>
                        <small>Starting investment amount</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="finalValue">Final Value (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="finalValue" value="25000" min="0" step="100" required>
                        <small>Ending investment value</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="duration">Investment Duration (Years)</label>
                        <input type="number" id="duration" value="5" min="0.1" step="0.1" required>
                        <small>Number of years invested</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate CAGR</button>
                </form>
            </div>

            <div class="results-section">
                <h2>CAGR Results</h2>
                
                <div class="result-card">
                    <h3>Compound Annual Growth Rate</h3>
                    <div class="amount" id="cagrRate">0%</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Initial Value</h4>
                        <div class="value" id="initialDisplay">$10,000</div>
                    </div>
                    <div class="metric-card">
                        <h4>Final Value</h4>
                        <div class="value" id="finalDisplay">$25,000</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Gain</h4>
                        <div class="value" id="totalGain">$15,000</div>
                    </div>
                    <div class="metric-card">
                        <h4>Absolute Return</h4>
                        <div class="value" id="absoluteReturn">150%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>CAGR Formula</h3>
                    <div class="breakdown-item">
                        <span>Formula</span>
                        <strong>CAGR = (FV/IV)^(1/n) - 1</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Calculation</span>
                        <strong id="calculation">(25000/10000)^(1/5) - 1</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAGR</span>
                        <strong id="cagrValue">20.11%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Investment Summary</h3>
                    <div class="breakdown-item">
                        <span>Initial Investment</span>
                        <strong id="initialAmount">$10,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Final Value</span>
                        <strong id="finalAmount">$25,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Duration</span>
                        <strong id="durationDisplay">5 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Gain</span>
                        <strong id="gainAmount" style="color: #4CAF50;">$15,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Absolute Return %</span>
                        <strong id="absReturn">150%</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>CAGR</strong></span>
                        <strong id="cagrPercent" style="color: #667eea; font-size: 1.2em;">20.11%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Year-by-Year Growth</h3>
                    <div class="breakdown-item">
                        <span>After Year 1</span>
                        <strong id="year1">$12,011</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After Year 2</span>
                        <strong id="year2">$14,427</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After Year 3</span>
                        <strong id="year3">$17,331</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After Year 4</span>
                        <strong id="year4">$20,816</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After Year 5</span>
                        <strong id="year5">$25,000</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Comparison Analysis</h3>
                    <div class="breakdown-item">
                        <span>CAGR (Annualized)</span>
                        <strong id="cagrAnnualized">20.11%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Simple Average Return</span>
                        <strong id="simpleReturn">30.00%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Difference</span>
                        <strong id="difference">9.89%</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>CAGR Formula:</strong> CAGR = (Final Value / Initial Value)^(1/Years) - 1. CAGR shows the smoothed annualized growth rate. Unlike absolute return, CAGR accounts for time and compounding, making it ideal for comparing investments of different durations.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('cagrForm');
        const currencySelect = document.getElementById('currency');

        // Currency change
        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateCAGR();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
            document.getElementById('currencyLabel2').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateCAGR();
        });

        function calculateCAGR() {
            const initialValue = parseFloat(document.getElementById('initialValue').value) || 0;
            const finalValue = parseFloat(document.getElementById('finalValue').value) || 0;
            const duration = parseFloat(document.getElementById('duration').value) || 1;
            const currency = currencySelect.value;

            if (initialValue <= 0 || finalValue <= 0) {
                alert('Initial and final values must be greater than 0');
                return;
            }

            // CAGR Formula: (FV/IV)^(1/n) - 1
            const cagr = (Math.pow(finalValue / initialValue, 1 / duration) - 1) * 100;

            const totalGainValue = finalValue - initialValue;
            const absoluteReturnValue = ((finalValue - initialValue) / initialValue) * 100;
            const simpleReturnValue = absoluteReturnValue / duration;
            const differenceValue = simpleReturnValue - cagr;

            // Year-by-year growth
            const yearValues = [];
            for (let i = 1; i <= Math.min(5, Math.ceil(duration)); i++) {
                const yearValue = initialValue * Math.pow(1 + cagr/100, i);
                yearValues.push(yearValue);
            }

            // Update UI
            document.getElementById('cagrRate').textContent = cagr.toFixed(2) + '%';
            document.getElementById('initialDisplay').textContent = formatCurrency(initialValue, currency);
            document.getElementById('finalDisplay').textContent = formatCurrency(finalValue, currency);
            document.getElementById('totalGain').textContent = formatCurrency(totalGainValue, currency);
            document.getElementById('absoluteReturn').textContent = absoluteReturnValue.toFixed(2) + '%';

            document.getElementById('calculation').textContent = `(${finalValue}/${initialValue})^(1/${duration}) - 1`;
            document.getElementById('cagrValue').textContent = cagr.toFixed(2) + '%';

            document.getElementById('initialAmount').textContent = formatCurrency(initialValue, currency);
            document.getElementById('finalAmount').textContent = formatCurrency(finalValue, currency);
            document.getElementById('durationDisplay').textContent = duration + ' year' + (duration !== 1 ? 's' : '');
            document.getElementById('gainAmount').textContent = formatCurrency(totalGainValue, currency);
            document.getElementById('absReturn').textContent = absoluteReturnValue.toFixed(2) + '%';
            document.getElementById('cagrPercent').textContent = cagr.toFixed(2) + '%';

            document.getElementById('year1').textContent = formatCurrency(yearValues[0] || finalValue, currency);
            document.getElementById('year2').textContent = formatCurrency(yearValues[1] || finalValue, currency);
            document.getElementById('year3').textContent = formatCurrency(yearValues[2] || finalValue, currency);
            document.getElementById('year4').textContent = formatCurrency(yearValues[3] || finalValue, currency);
            document.getElementById('year5').textContent = formatCurrency(yearValues[4] || finalValue, currency);

            document.getElementById('cagrAnnualized').textContent = cagr.toFixed(2) + '%';
            document.getElementById('simpleReturn').textContent = simpleReturnValue.toFixed(2) + '%';
            document.getElementById('difference').textContent = Math.abs(differenceValue).toFixed(2) + '%';
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
            calculateCAGR();
        });
    </script>
</body>
</html>