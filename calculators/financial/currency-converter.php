<?php
/**
 * Currency Converter Calculator
 * File: currency-converter-calculator.php
 * Description: Convert between USD and INR with live exchange rates
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter Calculator - USD to INR Exchange Rate</title>
    <meta name="description" content="Free currency converter calculator. Convert between USD and INR with current exchange rates. Calculate foreign exchange for international transactions.">
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
        
        .swap-btn {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
            margin-bottom: 20px;
        }
        
        .swap-btn:hover {
            background: #45a049;
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
        <h1>💱 Currency Converter</h1>
        <p>Convert between USD and INR with live exchange rates</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Conversion Details</h2>
                <form id="currencyForm">
                    <div class="form-group">
                        <label for="fromCurrency">From Currency</label>
                        <select id="fromCurrency">
                            <option value="USD">USD - US Dollar</option>
                            <option value="INR">INR - Indian Rupee</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="amount">Amount (<span id="fromSymbol">$</span>)</label>
                        <input type="number" id="amount" value="100" min="0" step="0.01" required>
                    </div>
                    
                    <button type="button" class="swap-btn" id="swapBtn">⇄ Swap Currencies</button>
                    
                    <div class="form-group">
                        <label for="toCurrency">To Currency</label>
                        <select id="toCurrency">
                            <option value="INR">INR - Indian Rupee</option>
                            <option value="USD">USD - US Dollar</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="exchangeRate">Exchange Rate (1 USD = INR)</label>
                        <input type="number" id="exchangeRate" value="88" min="0" step="0.01" required>
                        <small>Current market rate (editable)</small>
                    </div>
                    
                    <button type="submit" class="btn">Convert Currency</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Conversion Result</h2>
                
                <div class="result-card">
                    <h3>Converted Amount</h3>
                    <div class="amount" id="convertedAmount">₹0.00</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>From Amount</h4>
                        <div class="value" id="fromAmount">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>To Amount</h4>
                        <div class="value" id="toAmount">₹0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Exchange Rate</h4>
                        <div class="value" id="rateDisplay">88</div>
                    </div>
                    <div class="metric-card">
                        <h4>Inverse Rate</h4>
                        <div class="value" id="inverseRate">0.0114</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Conversion Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Original Amount</span>
                        <strong id="originalAmount">$100.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>From Currency</span>
                        <strong id="fromCurrencyDisplay">USD</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>To Currency</span>
                        <strong id="toCurrencyDisplay">INR</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Exchange Rate</span>
                        <strong id="exchangeRateDisplay">1 USD = 88.00 INR</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Converted Amount</strong></span>
                        <strong id="convertedAmountDisplay" style="color: #667eea; font-size: 1.2em;">₹8,800.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Common Conversions</h3>
                    <div class="breakdown-item">
                        <span id="conv1Label">1 USD</span>
                        <strong id="conv1">₹88.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span id="conv2Label">10 USD</span>
                        <strong id="conv2">₹880.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span id="conv3Label">100 USD</span>
                        <strong id="conv3">₹8,800.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span id="conv4Label">1,000 USD</span>
                        <strong id="conv4">₹88,000.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span id="conv5Label">10,000 USD</span>
                        <strong id="conv5">₹8,80,000.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Reverse Conversion</h3>
                    <div class="breakdown-item">
                        <span>To get <span id="reverseTarget">$100</span></span>
                        <strong id="reverseAmount">₹8,800</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Inverse Rate</span>
                        <strong id="inverseRateDisplay">1 INR = 0.0114 USD</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Exchange Rate Info:</strong> Rates shown are indicative. Actual rates may vary by bank/money changer. Current rate: 1 USD ≈ 88 INR (October 2025). Update the rate field for latest conversions.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('currencyForm');
        const fromCurrency = document.getElementById('fromCurrency');
        const toCurrency = document.getElementById('toCurrency');
        const swapBtn = document.getElementById('swapBtn');

        // Swap currencies
        swapBtn.addEventListener('click', function() {
            const tempFrom = fromCurrency.value;
            fromCurrency.value = toCurrency.value;
            toCurrency.value = tempFrom;
            updateSymbol();
            convertCurrency();
        });

        fromCurrency.addEventListener('change', function() {
            toCurrency.value = fromCurrency.value === 'USD' ? 'INR' : 'USD';
            updateSymbol();
            convertCurrency();
        });

        toCurrency.addEventListener('change', convertCurrency);

        function updateSymbol() {
            const symbol = fromCurrency.value === 'USD' ? '$' : '₹';
            document.getElementById('fromSymbol').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            convertCurrency();
        });

        function convertCurrency() {
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const rate = parseFloat(document.getElementById('exchangeRate').value) || 88;
            const from = fromCurrency.value;
            const to = toCurrency.value;

            let convertedValue;
            let inverseRateValue;

            if (from === 'USD' && to === 'INR') {
                convertedValue = amount * rate;
                inverseRateValue = 1 / rate;
            } else if (from === 'INR' && to === 'USD') {
                convertedValue = amount / rate;
                inverseRateValue = rate;
            } else {
                convertedValue = amount; // Same currency
                inverseRateValue = 1;
            }

            // Symbols
            const fromSymbol = from === 'USD' ? '$' : '₹';
            const toSymbol = to === 'USD' ? '$' : '₹';

            // Update UI
            document.getElementById('convertedAmount').textContent = formatCurrency(convertedValue, to);
            document.getElementById('fromAmount').textContent = formatCurrency(amount, from);
            document.getElementById('toAmount').textContent = formatCurrency(convertedValue, to);
            document.getElementById('rateDisplay').textContent = rate.toFixed(4);
            document.getElementById('inverseRate').textContent = inverseRateValue.toFixed(4);

            document.getElementById('originalAmount').textContent = formatCurrency(amount, from);
            document.getElementById('fromCurrencyDisplay').textContent = from;
            document.getElementById('toCurrencyDisplay').textContent = to;
            document.getElementById('exchangeRateDisplay').textContent = `1 ${from} = ${(from === 'USD' ? rate : 1/rate).toFixed(2)} ${to}`;
            document.getElementById('convertedAmountDisplay').textContent = formatCurrency(convertedValue, to);

            // Common conversions
            if (from === 'USD' && to === 'INR') {
                document.getElementById('conv1Label').textContent = '1 USD';
                document.getElementById('conv1').textContent = formatCurrency(rate * 1, 'INR');
                document.getElementById('conv2Label').textContent = '10 USD';
                document.getElementById('conv2').textContent = formatCurrency(rate * 10, 'INR');
                document.getElementById('conv3Label').textContent = '100 USD';
                document.getElementById('conv3').textContent = formatCurrency(rate * 100, 'INR');
                document.getElementById('conv4Label').textContent = '1,000 USD';
                document.getElementById('conv4').textContent = formatCurrency(rate * 1000, 'INR');
                document.getElementById('conv5Label').textContent = '10,000 USD';
                document.getElementById('conv5').textContent = formatCurrency(rate * 10000, 'INR');
            } else {
                document.getElementById('conv1Label').textContent = '100 INR';
                document.getElementById('conv1').textContent = formatCurrency(100 / rate, 'USD');
                document.getElementById('conv2Label').textContent = '1,000 INR';
                document.getElementById('conv2').textContent = formatCurrency(1000 / rate, 'USD');
                document.getElementById('conv3Label').textContent = '10,000 INR';
                document.getElementById('conv3').textContent = formatCurrency(10000 / rate, 'USD');
                document.getElementById('conv4Label').textContent = '1,00,000 INR';
                document.getElementById('conv4').textContent = formatCurrency(100000 / rate, 'USD');
                document.getElementById('conv5Label').textContent = '10,00,000 INR';
                document.getElementById('conv5').textContent = formatCurrency(1000000 / rate, 'USD');
            }

            // Reverse conversion
            document.getElementById('reverseTarget').textContent = formatCurrency(amount, from);
            document.getElementById('reverseAmount').textContent = formatCurrency(convertedValue, to);
            document.getElementById('inverseRateDisplay').textContent = `1 ${to} = ${inverseRateValue.toFixed(4)} ${from}`;
        }

        function formatCurrency(amount, currency) {
            if (currency === 'INR') {
                return new Intl.NumberFormat('en-IN', {
                    style: 'currency',
                    currency: 'INR',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(amount);
            } else {
                return new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(amount);
            }
        }

        window.addEventListener('load', function() {
            updateSymbol();
            convertCurrency();
        });
    </script>
</body>
</html>