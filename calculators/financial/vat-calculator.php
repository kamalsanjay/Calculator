<?php
/**
 * VAT Calculator
 * File: vat-calculator.php
 * Description: Calculate VAT (Value Added Tax) for different countries (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VAT Calculator - Calculate Value Added Tax (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free VAT calculator. Calculate VAT amount and total price. Add or remove VAT. Supports USD, INR, EUR, and GBP with country-specific rates.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128179; VAT Calculator</h1>
        <p>Calculate Value Added Tax (VAT)</p>
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
                <h2>VAT Calculation</h2>
                <form id="vatForm">
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
                        <label for="country">Country (VAT Rate)</label>
                        <select id="country">
                            <option value="custom">Custom Rate</option>
                            <optgroup label="Europe">
                                <option value="uk">UK (20%)</option>
                                <option value="germany">Germany (19%)</option>
                                <option value="france">France (20%)</option>
                                <option value="italy">Italy (22%)</option>
                                <option value="spain">Spain (21%)</option>
                                <option value="netherlands">Netherlands (21%)</option>
                                <option value="belgium">Belgium (21%)</option>
                                <option value="sweden">Sweden (25%)</option>
                                <option value="denmark">Denmark (25%)</option>
                                <option value="norway">Norway (25%)</option>
                                <option value="finland">Finland (24%)</option>
                                <option value="poland">Poland (23%)</option>
                                <option value="austria">Austria (20%)</option>
                                <option value="ireland">Ireland (23%)</option>
                                <option value="portugal">Portugal (23%)</option>
                                <option value="greece">Greece (24%)</option>
                            </optgroup>
                            <optgroup label="Asia & Pacific">
                                <option value="india">India GST (18%)</option>
                                <option value="australia">Australia GST (10%)</option>
                                <option value="singapore">Singapore GST (9%)</option>
                                <option value="japan">Japan (10%)</option>
                                <option value="southkorea">South Korea (10%)</option>
                                <option value="newzealand">New Zealand GST (15%)</option>
                            </optgroup>
                            <optgroup label="Americas">
                                <option value="canada">Canada GST (5%)</option>
                                <option value="mexico">Mexico (16%)</option>
                                <option value="brazil">Brazil (17%)</option>
                                <option value="argentina">Argentina (21%)</option>
                            </optgroup>
                            <optgroup label="Middle East & Africa">
                                <option value="uae">UAE (5%)</option>
                                <option value="saudiarabia">Saudi Arabia (15%)</option>
                                <option value="southafrica">South Africa (15%)</option>
                            </optgroup>
                        </select>
                    </div>
                    
                    <div class="form-group" id="customRateGroup">
                        <label for="vatRate">VAT Rate (%)</label>
                        <input type="number" id="vatRate" value="20" min="0" max="50" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="calculationType">Calculation Type</label>
                        <select id="calculationType">
                            <option value="add">Add VAT to Price (Net → Gross)</option>
                            <option value="remove">Remove VAT from Price (Gross → Net)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="amount" id="amountLabel">Price Excluding VAT (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="amount" value="100" min="0" step="0.01" required>
                    </div>
                    
                    <button type="submit" class="btn">Calculate VAT</button>
                </form>
            </div>

            <div class="results-section">
                <h2>VAT Summary</h2>
                
                <div class="result-card info">
                    <h3>Total Price (Including VAT)</h3>
                    <div class="amount" id="totalPrice">$0.00</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Net Price</h4>
                        <div class="value" id="netPrice">$0.00</div>
                    </div>
                    <div class="metric-card">
                        <h4>VAT Amount</h4>
                        <div class="value" id="vatAmount">$0.00</div>
                    </div>
                    <div class="metric-card">
                        <h4>VAT Rate</h4>
                        <div class="value" id="vatRateDisplay">20%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Gross Price</h4>
                        <div class="value" id="grossPrice">$0.00</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Price Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Country</span>
                        <strong id="countryDisplay">Custom</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>VAT/GST Rate</span>
                        <strong id="rateDisplay" style="color: #667eea;">20%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Calculation Type</span>
                        <strong id="calcTypeDisplay">Add VAT</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>VAT Calculation</h3>
                    <div class="breakdown-item">
                        <span>Net Price (Excluding VAT)</span>
                        <strong id="netPriceCalc">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>VAT Rate</span>
                        <strong id="vatRateCalc">20%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>VAT Amount</span>
                        <strong id="vatAmountCalc" style="color: #FF9800; font-size: 1.1em;">$0.00</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Gross Price (Including VAT)</strong></span>
                        <strong id="grossPriceCalc" style="color: #667eea; font-size: 1.2em;">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Reverse Calculation</h3>
                    <div class="breakdown-item">
                        <span>If Gross Price is</span>
                        <strong id="reverseGross">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Then Net Price is</span>
                        <strong id="reverseNet" style="color: #667eea;">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>And VAT is</span>
                        <strong id="reverseVAT">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>VAT as Percentage</h3>
                    <div class="breakdown-item">
                        <span>VAT as % of Net Price</span>
                        <strong id="vatOfNet">20%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>VAT as % of Gross Price</span>
                        <strong id="vatOfGross">16.67%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Net as % of Gross</span>
                        <strong id="netOfGross">83.33%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Multiple Quantities</h3>
                    <div class="breakdown-item">
                        <span>Price for 1 Unit</span>
                        <strong id="price1">$0.00 (incl. VAT)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Price for 5 Units</span>
                        <strong id="price5">$0.00 (incl. VAT)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Price for 10 Units</span>
                        <strong id="price10">$0.00 (incl. VAT)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Price for 100 Units</span>
                        <strong id="price100">$0.00 (incl. VAT)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Different VAT Rates Comparison</h3>
                    <div class="breakdown-item">
                        <span>At 5% VAT</span>
                        <strong id="vat5">$0.00 gross</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At 10% VAT</span>
                        <strong id="vat10">$0.00 gross</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At 15% VAT</span>
                        <strong id="vat15">$0.00 gross</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At 20% VAT (Current)</span>
                        <strong id="vat20" style="color: #667eea;">$0.00 gross</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At 25% VAT</span>
                        <strong id="vat25">$0.00 gross</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Common VAT Rates by Region</h3>
                    <div class="breakdown-item">
                        <span>UK</span>
                        <strong>20% (Standard)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EU Average</span>
                        <strong>21% (varies by country)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>India (GST)</span>
                        <strong>5%, 12%, 18%, 28%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Australia (GST)</span>
                        <strong>10%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Canada (GST)</span>
                        <strong>5% (+ provincial)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>UAE</span>
                        <strong>5%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Invoice Format</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; border: 1px solid #ddd;">
                        <div class="breakdown-item" style="border: none; padding: 5px 0;">
                            <span>Net Amount:</span>
                            <strong id="invoiceNet">$0.00</strong>
                        </div>
                        <div class="breakdown-item" style="border: none; padding: 5px 0;">
                            <span>VAT (<span id="invoiceRate">20</span>%):</span>
                            <strong id="invoiceVAT">$0.00</strong>
                        </div>
                        <div class="breakdown-item" style="border-top: 2px solid #000; padding: 10px 0 5px;">
                            <span><strong>Total Due:</strong></span>
                            <strong id="invoiceTotal" style="font-size: 1.2em;">$0.00</strong>
                        </div>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>VAT Tips:</strong> VAT = Value Added Tax (consumption tax). EU/UK: VAT included in price. US: Sales tax added at checkout. VAT registered businesses can reclaim VAT. Standard rates: UK 20%, EU avg 21%, Australia 10%. Reduced rates for essentials (food, books). Zero-rated = 0% VAT. Exempt = no VAT charged. Threshold for registration varies. B2B = reverse charge possible. Cross-border = different rules. Digital services = customer location. Check local rates. Keep VAT receipts. File returns regularly. Penalties for late filing. Use accounting software.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('vatForm');
        const currencySelect = document.getElementById('currency');
        const countrySelect = document.getElementById('country');
        const calculationTypeSelect = document.getElementById('calculationType');
        const vatRateInput = document.getElementById('vatRate');

        // VAT rates by country
        const vatRates = {
            'uk': 20, 'germany': 19, 'france': 20, 'italy': 22, 'spain': 21,
            'netherlands': 21, 'belgium': 21, 'sweden': 25, 'denmark': 25,
            'norway': 25, 'finland': 24, 'poland': 23, 'austria': 20,
            'ireland': 23, 'portugal': 23, 'greece': 24, 'india': 18,
            'australia': 10, 'singapore': 9, 'japan': 10, 'southkorea': 10,
            'newzealand': 15, 'canada': 5, 'mexico': 16, 'brazil': 17,
            'argentina': 21, 'uae': 5, 'saudiarabia': 15, 'southafrica': 15
        };

        const countryNames = {
            'uk': 'United Kingdom', 'germany': 'Germany', 'france': 'France',
            'italy': 'Italy', 'spain': 'Spain', 'netherlands': 'Netherlands',
            'belgium': 'Belgium', 'sweden': 'Sweden', 'denmark': 'Denmark',
            'norway': 'Norway', 'finland': 'Finland', 'poland': 'Poland',
            'austria': 'Austria', 'ireland': 'Ireland', 'portugal': 'Portugal',
            'greece': 'Greece', 'india': 'India', 'australia': 'Australia',
            'singapore': 'Singapore', 'japan': 'Japan', 'southkorea': 'South Korea',
            'newzealand': 'New Zealand', 'canada': 'Canada', 'mexico': 'Mexico',
            'brazil': 'Brazil', 'argentina': 'Argentina', 'uae': 'United Arab Emirates',
            'saudiarabia': 'Saudi Arabia', 'southafrica': 'South Africa', 'custom': 'Custom Rate'
        };

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateVAT();
        });

        countrySelect.addEventListener('change', function() {
            updateVATRate();
            calculateVAT();
        });

        calculationTypeSelect.addEventListener('change', function() {
            updateAmountLabel();
            calculateVAT();
        });

        vatRateInput.addEventListener('input', calculateVAT);

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
        }

        function updateVATRate() {
            const country = countrySelect.value;
            const customGroup = document.getElementById('customRateGroup');
            
            if (country === 'custom') {
                customGroup.style.display = 'block';
            } else {
                customGroup.style.display = 'none';
                vatRateInput.value = vatRates[country];
            }
        }

        function updateAmountLabel() {
            const calcType = calculationTypeSelect.value;
            const label = calcType === 'add' ? 'Price Excluding VAT' : 'Price Including VAT';
            document.getElementById('amountLabel').innerHTML = `${label} (<span id="currencyLabel1">${document.getElementById('currencyLabel1').textContent}</span>)`;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateVAT();
        });

        function calculateVAT() {
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const vatRate = parseFloat(vatRateInput.value) / 100 || 0;
            const calcType = calculationTypeSelect.value;
            const country = countrySelect.value;
            const currency = currencySelect.value;

            let netPrice, vatAmount, grossPrice;

            if (calcType === 'add') {
                // Add VAT to price
                netPrice = amount;
                vatAmount = netPrice * vatRate;
                grossPrice = netPrice + vatAmount;
            } else {
                // Remove VAT from price
                grossPrice = amount;
                netPrice = grossPrice / (1 + vatRate);
                vatAmount = grossPrice - netPrice;
            }

            // Reverse calculation
            const reverseGross = grossPrice;
            const reverseNet = netPrice;
            const reverseVAT = vatAmount;

            // VAT percentages
            const vatOfNet = vatRate * 100;
            const vatOfGross = grossPrice > 0 ? (vatAmount / grossPrice) * 100 : 0;
            const netOfGross = grossPrice > 0 ? (netPrice / grossPrice) * 100 : 0;

            // Multiple quantities
            const price1 = grossPrice;
            const price5 = grossPrice * 5;
            const price10 = grossPrice * 10;
            const price100 = grossPrice * 100;

            // Different VAT rates
            const vat5 = netPrice * 1.05;
            const vat10 = netPrice * 1.10;
            const vat15 = netPrice * 1.15;
            const vat20 = netPrice * 1.20;
            const vat25 = netPrice * 1.25;

            // Analysis
            let analysis = '';
            if (calcType === 'add') {
                analysis = `Starting with a net price of ${formatCurrency(netPrice, currency)} (excluding VAT), `;
                analysis += `adding ${(vatRate * 100).toFixed(1)}% VAT (${formatCurrency(vatAmount, currency)}) `;
                analysis += `gives a total gross price of ${formatCurrency(grossPrice, currency)} including VAT. `;
            } else {
                analysis = `Starting with a gross price of ${formatCurrency(grossPrice, currency)} (including VAT), `;
                analysis += `removing ${(vatRate * 100).toFixed(1)}% VAT shows the net price is ${formatCurrency(netPrice, currency)} `;
                analysis += `and the VAT amount is ${formatCurrency(vatAmount, currency)}. `;
            }
            
            analysis += `The VAT represents ${vatOfGross.toFixed(2)}% of the total price. `;
            
            if (country !== 'custom') {
                analysis += `In ${countryNames[country]}, the standard VAT/GST rate is ${(vatRate * 100).toFixed(1)}%.`;
            }

            // Update UI
            document.getElementById('totalPrice').textContent = formatCurrency(grossPrice, currency);
            document.getElementById('netPrice').textContent = formatCurrency(netPrice, currency);
            document.getElementById('vatAmount').textContent = formatCurrency(vatAmount, currency);
            document.getElementById('vatRateDisplay').textContent = (vatRate * 100).toFixed(1) + '%';
            document.getElementById('grossPrice').textContent = formatCurrency(grossPrice, currency);

            document.getElementById('countryDisplay').textContent = countryNames[country];
            document.getElementById('rateDisplay').textContent = (vatRate * 100).toFixed(1) + '%';
            document.getElementById('calcTypeDisplay').textContent = calcType === 'add' ? 'Add VAT to Net Price' : 'Remove VAT from Gross Price';

            document.getElementById('netPriceCalc').textContent = formatCurrency(netPrice, currency);
            document.getElementById('vatRateCalc').textContent = (vatRate * 100).toFixed(1) + '%';
            document.getElementById('vatAmountCalc').textContent = formatCurrency(vatAmount, currency);
            document.getElementById('grossPriceCalc').textContent = formatCurrency(grossPrice, currency);

            document.getElementById('reverseGross').textContent = formatCurrency(reverseGross, currency);
            document.getElementById('reverseNet').textContent = formatCurrency(reverseNet, currency);
            document.getElementById('reverseVAT').textContent = formatCurrency(reverseVAT, currency);

            document.getElementById('vatOfNet').textContent = vatOfNet.toFixed(1) + '%';
            document.getElementById('vatOfGross').textContent = vatOfGross.toFixed(2) + '%';
            document.getElementById('netOfGross').textContent = netOfGross.toFixed(2) + '%';

            document.getElementById('price1').textContent = formatCurrency(price1, currency) + ' (incl. VAT)';
            document.getElementById('price5').textContent = formatCurrency(price5, currency) + ' (incl. VAT)';
            document.getElementById('price10').textContent = formatCurrency(price10, currency) + ' (incl. VAT)';
            document.getElementById('price100').textContent = formatCurrency(price100, currency) + ' (incl. VAT)';

            document.getElementById('vat5').textContent = formatCurrency(vat5, currency) + ' gross';
            document.getElementById('vat10').textContent = formatCurrency(vat10, currency) + ' gross';
            document.getElementById('vat15').textContent = formatCurrency(vat15, currency) + ' gross';
            document.getElementById('vat20').textContent = formatCurrency(vat20, currency) + ' gross';
            document.getElementById('vat25').textContent = formatCurrency(vat25, currency) + ' gross';

            document.getElementById('invoiceNet').textContent = formatCurrency(netPrice, currency);
            document.getElementById('invoiceRate').textContent = (vatRate * 100).toFixed(1);
            document.getElementById('invoiceVAT').textContent = formatCurrency(vatAmount, currency);
            document.getElementById('invoiceTotal').textContent = formatCurrency(grossPrice, currency);

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
            updateVATRate();
            updateAmountLabel();
            calculateVAT();
        });
    </script>
</body>
</html>