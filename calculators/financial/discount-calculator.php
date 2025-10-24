<?php
/**
 * Discount Calculator
 * File: discount-calculator.php
 * Description: Calculate discounts, sale prices, and savings with USD/INR support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discount Calculator - Calculate Sale Price & Savings (USD/INR)</title>
    <meta name="description" content="Free discount calculator. Calculate sale price after discount, percentage off, and total savings. Supports USD and INR currencies.">
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
        <h1>🏷️ Discount Calculator</h1>
        <p>Calculate sale prices and savings from discounts</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Price Details</h2>
                <form id="discountForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="originalPrice">Original Price (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="originalPrice" value="100" min="0" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="discountPercent">Discount Percentage (%)</label>
                        <input type="number" id="discountPercent" value="20" min="0" max="100" step="0.1" required>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Discount</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Discount Summary</h2>
                
                <div class="result-card">
                    <h3>Sale Price</h3>
                    <div class="amount" id="salePrice">$0.00</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Original Price</h4>
                        <div class="value" id="originalPriceDisplay">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>You Save</h4>
                        <div class="value" id="youSave">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Discount %</h4>
                        <div class="value" id="discountPercentDisplay">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Final Price</h4>
                        <div class="value" id="finalPrice">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Price Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Original Price</span>
                        <strong id="originalAmount">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Discount Percentage</span>
                        <strong id="discountRate">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Discount Amount</span>
                        <strong id="discountAmount" style="color: #4CAF50;">-$0.00</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Sale Price</strong></span>
                        <strong id="salePriceDisplay" style="color: #667eea; font-size: 1.2em;">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Savings Analysis</h3>
                    <div class="breakdown-item">
                        <span>Amount Saved</span>
                        <strong id="amountSaved" style="color: #4CAF50;">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Percentage Saved</span>
                        <strong id="percentageSaved">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>You Pay</span>
                        <strong id="youPay">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Common Discount Scenarios</h3>
                    <div class="breakdown-item">
                        <span>10% Off</span>
                        <strong id="discount10">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>20% Off</span>
                        <strong id="discount20">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>30% Off</span>
                        <strong id="discount30">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>50% Off</span>
                        <strong id="discount50">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>75% Off</span>
                        <strong id="discount75">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Multiple Item Savings</h3>
                    <div class="breakdown-item">
                        <span>Buy 2 Items</span>
                        <strong id="buy2">$0.00 (Save $0.00)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Buy 5 Items</span>
                        <strong id="buy5">$0.00 (Save $0.00)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Buy 10 Items</span>
                        <strong id="buy10">$0.00 (Save $0.00)</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Discount Formula:</strong> Sale Price = Original Price - (Original Price × Discount %). Savings = Original Price - Sale Price. Great deals typically offer 25% or more off!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('discountForm');
        const currencySelect = document.getElementById('currency');

        // Currency change
        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateDiscount();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateDiscount();
        });

        function calculateDiscount() {
            const originalPrice = parseFloat(document.getElementById('originalPrice').value) || 0;
            const discountPercent = parseFloat(document.getElementById('discountPercent').value) || 0;
            const currency = currencySelect.value;

            const discountAmountValue = originalPrice * (discountPercent / 100);
            const salePriceValue = originalPrice - discountAmountValue;

            // Common discount scenarios
            const discount10Value = originalPrice * 0.9;
            const discount20Value = originalPrice * 0.8;
            const discount30Value = originalPrice * 0.7;
            const discount50Value = originalPrice * 0.5;
            const discount75Value = originalPrice * 0.25;

            // Multiple items
            const buy2Price = salePriceValue * 2;
            const buy2Save = (originalPrice * 2) - buy2Price;
            const buy5Price = salePriceValue * 5;
            const buy5Save = (originalPrice * 5) - buy5Price;
            const buy10Price = salePriceValue * 10;
            const buy10Save = (originalPrice * 10) - buy10Price;

            // Update UI
            document.getElementById('salePrice').textContent = formatCurrency(salePriceValue, currency);
            document.getElementById('originalPriceDisplay').textContent = formatCurrency(originalPrice, currency);
            document.getElementById('youSave').textContent = formatCurrency(discountAmountValue, currency);
            document.getElementById('discountPercentDisplay').textContent = discountPercent.toFixed(1) + '%';
            document.getElementById('finalPrice').textContent = formatCurrency(salePriceValue, currency);

            document.getElementById('originalAmount').textContent = formatCurrency(originalPrice, currency);
            document.getElementById('discountRate').textContent = discountPercent.toFixed(1) + '%';
            document.getElementById('discountAmount').textContent = '-' + formatCurrency(discountAmountValue, currency);
            document.getElementById('salePriceDisplay').textContent = formatCurrency(salePriceValue, currency);

            document.getElementById('amountSaved').textContent = formatCurrency(discountAmountValue, currency);
            document.getElementById('percentageSaved').textContent = discountPercent.toFixed(1) + '%';
            document.getElementById('youPay').textContent = formatCurrency(salePriceValue, currency);

            document.getElementById('discount10').textContent = formatCurrency(discount10Value, currency);
            document.getElementById('discount20').textContent = formatCurrency(discount20Value, currency);
            document.getElementById('discount30').textContent = formatCurrency(discount30Value, currency);
            document.getElementById('discount50').textContent = formatCurrency(discount50Value, currency);
            document.getElementById('discount75').textContent = formatCurrency(discount75Value, currency);

            document.getElementById('buy2').textContent = formatCurrency(buy2Price, currency) + ' (Save ' + formatCurrency(buy2Save, currency) + ')';
            document.getElementById('buy5').textContent = formatCurrency(buy5Price, currency) + ' (Save ' + formatCurrency(buy5Save, currency) + ')';
            document.getElementById('buy10').textContent = formatCurrency(buy10Price, currency) + ' (Save ' + formatCurrency(buy10Save, currency) + ')';
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
            updateCurrencyLabels();
            calculateDiscount();
        });
    </script>
</body>
</html>