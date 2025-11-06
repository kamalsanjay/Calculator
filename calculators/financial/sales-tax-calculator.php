<?php
/**
 * Sales Tax Calculator
 * File: sales-tax-calculator.php
 * Description: Calculate sales tax and total price (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Tax Calculator - Calculate Tax and Total Price (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free sales tax calculator. Calculate sales tax amount and total price. Add or remove tax from price. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128184; Sales Tax Calculator</h1>
        <p>Calculate sales tax and total price</p>
    </header>
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
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Price & Tax Details</h2>
                <form id="salesTaxForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD (&#36;)</option>
                            <option value="INR">INR (&#8377;)</option>
                            <option value="EUR">EUR (&#8364;)</option>
                            <option value="GBP">GBP (&#163;)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="calculationType">Calculation Type</label>
                        <select id="calculationType">
                            <option value="add">Add Tax to Price (Pre-Tax → Total)</option>
                            <option value="remove">Remove Tax from Price (Total → Pre-Tax)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="priceAmount" id="priceLabel">Price Before Tax (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="priceAmount" value="100" min="0" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="taxRate">Sales Tax Rate (%)</label>
                        <input type="number" id="taxRate" value="8.5" min="0" max="50" step="0.1" required>
                        <small>US avg: 7.5%, India: 5-28% GST, EU: 15-27% VAT, UK: 20% VAT</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" value="1" min="1" step="1">
                    </div>
                    
                    <div class="form-group">
                        <label for="discount">Discount (%)</label>
                        <input type="number" id="discount" value="0" min="0" max="100" step="0.5">
                        <small>Applied before tax</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="shippingCost">Shipping Cost (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="shippingCost" value="0" min="0" step="0.01">
                        <small>Added after tax (usually not taxed)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Tax</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Tax Summary</h2>
                
                <div class="result-card info">
                    <h3>Total Price</h3>
                    <div class="amount" id="totalPrice">$0.00</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Subtotal</h4>
                        <div class="value" id="subtotal">$0.00</div>
                    </div>
                    <div class="metric-card">
                        <h4>Sales Tax</h4>
                        <div class="value" id="salesTax">$0.00</div>
                    </div>
                    <div class="metric-card">
                        <h4>After Discount</h4>
                        <div class="value" id="afterDiscount">$0.00</div>
                    </div>
                    <div class="metric-card">
                        <h4>Tax Rate</h4>
                        <div class="value" id="taxRateDisplay">8.5%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Price Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Item Price (Each)</span>
                        <strong id="itemPrice">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Quantity</span>
                        <strong id="quantityDisplay">1</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Subtotal</strong></span>
                        <strong id="subtotalCalc" style="color: #667eea; font-size: 1.1em;">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Discount ({discountRate}%)</span>
                        <strong id="discountAmount" style="color: #4CAF50;">-$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Price After Discount</span>
                        <strong id="priceAfterDiscount">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Calculation</h3>
                    <div class="breakdown-item">
                        <span>Taxable Amount</span>
                        <strong id="taxableAmount">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax Rate</span>
                        <strong id="taxRateCalc">8.5%</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #FF9800; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Sales Tax Amount</strong></span>
                        <strong id="salesTaxAmount" style="color: #FF9800; font-size: 1.1em;">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Cost</h3>
                    <div class="breakdown-item">
                        <span>Price After Discount</span>
                        <strong id="pricePostDiscount">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Sales Tax</span>
                        <strong id="taxAdded" style="color: #FF9800;">+$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Shipping Cost</span>
                        <strong id="shippingAdded" style="color: #667eea;">+$0.00</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Price</strong></span>
                        <strong id="grandTotal" style="color: #4CAF50; font-size: 1.2em;">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Per Item Analysis</h3>
                    <div class="breakdown-item">
                        <span>Price Per Item (Before Tax)</span>
                        <strong id="pricePerItem">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax Per Item</span>
                        <strong id="taxPerItem">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Per Item (After Tax)</span>
                        <strong id="totalPerItem" style="color: #667eea;">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Components</h3>
                    <div class="breakdown-item">
                        <span>Tax as % of Total</span>
                        <strong id="taxPercentOfTotal">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax as Amount</span>
                        <strong id="taxAsAmount">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pre-Tax Amount</span>
                        <strong id="preTaxAmount">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Post-Tax Amount</span>
                        <strong id="postTaxAmount">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Reverse Calculation</h3>
                    <div class="breakdown-item">
                        <span>If Total Price is</span>
                        <strong id="reverseTotalPrice">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Then Pre-Tax Price is</span>
                        <strong id="reversePreTax" style="color: #667eea;">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>And Tax Amount is</span>
                        <strong id="reverseTaxAmount">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Multiple Tax Rates Comparison</h3>
                    <div class="breakdown-item">
                        <span>At 5% Tax</span>
                        <strong id="tax5">$0.00 total</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At 7% Tax</span>
                        <strong id="tax7">$0.00 total</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At 10% Tax</span>
                        <strong id="tax10">$0.00 total</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At 15% Tax</span>
                        <strong id="tax15">$0.00 total</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At 20% Tax (Current)</span>
                        <strong id="tax20" style="color: #667eea;">$0.00 total</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Savings Analysis</h3>
                    <div class="breakdown-item">
                        <span>Original Price</span>
                        <strong id="originalPrice">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Discount Saved</span>
                        <strong id="discountSaved" style="color: #4CAF50;">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>You Pay</span>
                        <strong id="youPay">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Savings %</span>
                        <strong id="savingsPercent" style="color: #4CAF50;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Sales Tax Tips:</strong> Varies by location (state, county, city). US: 0-10% (OR, NH, MT, AK, DE = no sales tax). Canada: 5-15% (GST/HST). EU/UK: VAT included in price. India: GST 5-28% by category. Online sales = buyer's location tax. Tax-free items: groceries, medicine (varies). Business purchases: provide tax-exempt certificate. Keep receipts for returns. International shipping may avoid tax. Compare pre-tax prices. Factor tax into budget. Some states have tax holidays.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('salesTaxForm');
        const currencySelect = document.getElementById('currency');
        const calculationType = document.getElementById('calculationType');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateSalesTax();
        });

        calculationType.addEventListener('change', function() {
            updatePriceLabel();
            calculateSalesTax();
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
            for (let i = 1; i <= 2; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        function updatePriceLabel() {
            const calcType = calculationType.value;
            const label = calcType === 'add' ? 'Price Before Tax' : 'Price Including Tax';
            document.getElementById('priceLabel').innerHTML = `${label} (<span id="currencyLabel1">${document.getElementById('currencyLabel1').textContent}</span>)`;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateSalesTax();
        });

        function calculateSalesTax() {
            const priceAmount = parseFloat(document.getElementById('priceAmount').value) || 0;
            const taxRate = parseFloat(document.getElementById('taxRate').value) / 100 || 0;
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            const discount = parseFloat(document.getElementById('discount').value) / 100 || 0;
            const shippingCost = parseFloat(document.getElementById('shippingCost').value) || 0;
            const calcType = calculationType.value;
            const currency = currencySelect.value;

            let preTaxPrice, taxAmount, totalPrice;
            const itemPrice = priceAmount;
            const subtotal = itemPrice * quantity;
            const discountAmount = subtotal * discount;
            const priceAfterDiscount = subtotal - discountAmount;

            if (calcType === 'add') {
                // Adding tax to price
                preTaxPrice = priceAfterDiscount;
                taxAmount = preTaxPrice * taxRate;
                totalPrice = preTaxPrice + taxAmount + shippingCost;
            } else {
                // Removing tax from price
                totalPrice = priceAfterDiscount + shippingCost;
                preTaxPrice = (priceAfterDiscount) / (1 + taxRate);
                taxAmount = priceAfterDiscount - preTaxPrice;
            }

            // Per item calculations
            const taxPerItem = taxAmount / quantity;
            const totalPerItem = (totalPrice - shippingCost) / quantity;

            // Tax components
            const taxPercentOfTotal = totalPrice > 0 ? (taxAmount / totalPrice) * 100 : 0;

            // Reverse calculation
            const reversePreTax = totalPrice / (1 + taxRate);
            const reverseTaxAmount = totalPrice - reversePreTax;

            // Multiple tax rates
            const tax5 = preTaxPrice * 1.05 + shippingCost;
            const tax7 = preTaxPrice * 1.07 + shippingCost;
            const tax10 = preTaxPrice * 1.10 + shippingCost;
            const tax15 = preTaxPrice * 1.15 + shippingCost;
            const tax20 = preTaxPrice * 1.20 + shippingCost;

            // Savings
            const savingsPercent = discount * 100;

            // Analysis
            let analysis = '';
            if (calcType === 'add') {
                analysis = `For ${quantity} item(s) at ${formatCurrency(itemPrice, currency)} each, your subtotal is ${formatCurrency(subtotal, currency)}. `;
                if (discount > 0) {
                    analysis += `After a ${(discount * 100).toFixed(1)}% discount (${formatCurrency(discountAmount, currency)}), `;
                }
                analysis += `the taxable amount is ${formatCurrency(preTaxPrice, currency)}. `;
                analysis += `With ${(taxRate * 100).toFixed(1)}% sales tax (${formatCurrency(taxAmount, currency)})`;
                if (shippingCost > 0) {
                    analysis += ` and ${formatCurrency(shippingCost, currency)} shipping`;
                }
                analysis += `, your total cost is ${formatCurrency(totalPrice, currency)}.`;
            } else {
                analysis = `If the total price including tax is ${formatCurrency(priceAfterDiscount, currency)}, then the pre-tax price is ${formatCurrency(preTaxPrice, currency)} and the tax amount is ${formatCurrency(taxAmount, currency)} at ${(taxRate * 100).toFixed(1)}%.`;
            }

            // Update UI
            document.getElementById('totalPrice').textContent = formatCurrency(totalPrice, currency);
            document.getElementById('subtotal').textContent = formatCurrency(subtotal, currency);
            document.getElementById('salesTax').textContent = formatCurrency(taxAmount, currency);
            document.getElementById('afterDiscount').textContent = formatCurrency(priceAfterDiscount, currency);
            document.getElementById('taxRateDisplay').textContent = (taxRate * 100).toFixed(1) + '%';

            document.getElementById('itemPrice').textContent = formatCurrency(itemPrice, currency);
            document.getElementById('quantityDisplay').textContent = quantity + (quantity === 1 ? ' item' : ' items');
            document.getElementById('subtotalCalc').textContent = formatCurrency(subtotal, currency);
            document.getElementById('discountAmount').textContent = formatCurrency(discountAmount, currency);
            document.getElementById('priceAfterDiscount').textContent = formatCurrency(priceAfterDiscount, currency);

            document.getElementById('taxableAmount').textContent = formatCurrency(preTaxPrice, currency);
            document.getElementById('taxRateCalc').textContent = (taxRate * 100).toFixed(1) + '%';
            document.getElementById('salesTaxAmount').textContent = formatCurrency(taxAmount, currency);

            document.getElementById('pricePostDiscount').textContent = formatCurrency(preTaxPrice, currency);
            document.getElementById('taxAdded').textContent = formatCurrency(taxAmount, currency);
            document.getElementById('shippingAdded').textContent = formatCurrency(shippingCost, currency);
            document.getElementById('grandTotal').textContent = formatCurrency(totalPrice, currency);

            document.getElementById('pricePerItem').textContent = formatCurrency(preTaxPrice / quantity, currency);
            document.getElementById('taxPerItem').textContent = formatCurrency(taxPerItem, currency);
            document.getElementById('totalPerItem').textContent = formatCurrency(totalPerItem, currency);

            document.getElementById('taxPercentOfTotal').textContent = taxPercentOfTotal.toFixed(2) + '%';
            document.getElementById('taxAsAmount').textContent = formatCurrency(taxAmount, currency);
            document.getElementById('preTaxAmount').textContent = formatCurrency(preTaxPrice, currency);
            document.getElementById('postTaxAmount').textContent = formatCurrency(totalPrice, currency);

            document.getElementById('reverseTotalPrice').textContent = formatCurrency(totalPrice, currency);
            document.getElementById('reversePreTax').textContent = formatCurrency(reversePreTax, currency);
            document.getElementById('reverseTaxAmount').textContent = formatCurrency(reverseTaxAmount, currency);

            document.getElementById('tax5').textContent = formatCurrency(tax5, currency) + ' total';
            document.getElementById('tax7').textContent = formatCurrency(tax7, currency) + ' total';
            document.getElementById('tax10').textContent = formatCurrency(tax10, currency) + ' total';
            document.getElementById('tax15').textContent = formatCurrency(tax15, currency) + ' total';
            document.getElementById('tax20').textContent = formatCurrency(tax20, currency) + ' total';

            document.getElementById('originalPrice').textContent = formatCurrency(subtotal, currency);
            document.getElementById('discountSaved').textContent = formatCurrency(discountAmount, currency);
            document.getElementById('youPay').textContent = formatCurrency(totalPrice, currency);
            document.getElementById('savingsPercent').textContent = savingsPercent.toFixed(1) + '%';

            document.getElementById('analysisText').textContent = analysis;
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
            updatePriceLabel();
            calculateSalesTax();
        });
    </script>
</body>
</html>