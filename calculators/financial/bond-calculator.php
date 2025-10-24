<?php
/**
 * Bond Calculator
 * File: bond-calculator.php
 * Description: Calculate bond price, yield, and returns (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bond Calculator - Calculate Bond Price & Yield (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free bond calculator. Calculate bond price, yield to maturity, current yield, and total returns. Supports USD, INR, EUR, and GBP currencies.">
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
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
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
        <h1>📊 Bond Calculator</h1>
        <p>Calculate bond price, yield, and returns</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Bond Details</h2>
                <form id="bondForm">
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
                        <label for="faceValue">Face Value / Par Value (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="faceValue" value="1000" min="100" step="100" required>
                        <small>Bond's par value at maturity</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="couponRate">Coupon Rate (% per annum)</label>
                        <input type="number" id="couponRate" value="5" min="0" max="20" step="0.1" required>
                        <small>Annual interest rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="marketRate">Market Interest Rate / Yield (%)</label>
                        <input type="number" id="marketRate" value="4" min="0" max="20" step="0.1" required>
                        <small>Current market yield (YTM)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="yearsToMaturity">Years to Maturity</label>
                        <input type="number" id="yearsToMaturity" value="10" min="0.5" max="30" step="0.5" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="paymentFrequency">Payment Frequency</label>
                        <select id="paymentFrequency">
                            <option value="1">Annual</option>
                            <option value="2" selected>Semi-Annual</option>
                            <option value="4">Quarterly</option>
                            <option value="12">Monthly</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="purchasePrice">Purchase Price (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="purchasePrice" value="0" min="0" step="10">
                        <small>Optional: Current market price (leave 0 to calculate)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Bond</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Bond Valuation</h2>
                
                <div class="result-card">
                    <h3>Bond Price</h3>
                    <div class="amount" id="bondPrice">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Current Yield</h4>
                        <div class="value" id="currentYield">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Yield to Maturity</h4>
                        <div class="value" id="ytm">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Coupons</h4>
                        <div class="value" id="totalCoupons">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Return</h4>
                        <div class="value" id="totalReturn">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Bond Specifications</h3>
                    <div class="breakdown-item">
                        <span>Face Value</span>
                        <strong id="faceValueDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Coupon Rate</span>
                        <strong id="couponRateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Coupon Payment</span>
                        <strong id="annualCoupon">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Payment Frequency</span>
                        <strong id="frequencyDisplay">Semi-Annual</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Coupon per Payment</span>
                        <strong id="couponPerPayment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Years to Maturity</span>
                        <strong id="maturityDisplay">0 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Payments</span>
                        <strong id="totalPayments">0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Bond Pricing</h3>
                    <div class="breakdown-item">
                        <span>Market Interest Rate (YTM)</span>
                        <strong id="marketRateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Present Value of Coupons</span>
                        <strong id="pvCoupons">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Present Value of Face Value</span>
                        <strong id="pvFaceValue">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Fair Bond Price</strong></span>
                        <strong id="fairPrice" style="color: #2196F3; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Yield Calculations</h3>
                    <div class="breakdown-item">
                        <span>Current Yield</span>
                        <strong id="currentYieldCalc">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Yield to Maturity (YTM)</span>
                        <strong id="ytmCalc" style="color: #667eea;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Bond Status</span>
                        <strong id="bondStatus">At Par</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Returns at Maturity</h3>
                    <div class="breakdown-item">
                        <span>Purchase Price</span>
                        <strong id="purchasePriceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Coupon Payments</span>
                        <strong id="totalCouponPayments" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Face Value at Maturity</span>
                        <strong id="faceValueReturn">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Received</span>
                        <strong id="totalReceived" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Gain/Loss</strong></span>
                        <strong id="netGain" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Bond Classification</h3>
                    <div id="bondClassification" style="padding: 15px; background: white; border-radius: 5px; text-align: center;">
                        <div style="font-size: 1.5em; margin-bottom: 10px;" id="classIcon">📊</div>
                        <div style="font-size: 1.2em; color: #667eea; font-weight: 600;" id="classType">Premium Bond</div>
                        <div style="margin-top: 10px; color: #666;" id="classDescription">Trading above par value</div>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Bond Tips:</strong> Premium bond = price > face value (coupon > market rate). Discount bond = price < face value (coupon < market rate). Par bond = price = face value. Current yield = annual coupon / price. YTM = total return if held to maturity. Higher market rates = lower bond prices.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('bondForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateBond();
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

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBond();
        });

        function calculateBond() {
            const faceValue = parseFloat(document.getElementById('faceValue').value) || 1000;
            const couponRate = parseFloat(document.getElementById('couponRate').value) / 100 || 0.05;
            const marketRate = parseFloat(document.getElementById('marketRate').value) / 100 || 0.04;
            const years = parseFloat(document.getElementById('yearsToMaturity').value) || 10;
            const frequency = parseInt(document.getElementById('paymentFrequency').value) || 2;
            let purchasePrice = parseFloat(document.getElementById('purchasePrice').value) || 0;
            const currency = currencySelect.value;

            // Calculate bond price
            const periodsPerYear = frequency;
            const totalPeriods = years * periodsPerYear;
            const couponPayment = (faceValue * couponRate) / periodsPerYear;
            const periodRate = marketRate / periodsPerYear;

            // Present value of coupon payments
            let pvCoupons = 0;
            if (periodRate > 0) {
                pvCoupons = couponPayment * ((1 - Math.pow(1 + periodRate, -totalPeriods)) / periodRate);
            } else {
                pvCoupons = couponPayment * totalPeriods;
            }

            // Present value of face value
            const pvFaceValue = faceValue / Math.pow(1 + periodRate, totalPeriods);

            // Bond price
            const bondPrice = pvCoupons + pvFaceValue;

            // Use calculated price if purchase price not provided
            if (purchasePrice === 0) {
                purchasePrice = bondPrice;
            }

            // Yields
            const annualCoupon = faceValue * couponRate;
            const currentYield = (annualCoupon / purchasePrice) * 100;
            const ytm = marketRate * 100;

            // Total returns
            const totalCouponPayments = couponPayment * totalPeriods;
            const totalReceived = totalCouponPayments + faceValue;
            const netGain = totalReceived - purchasePrice;

            // Bond status
            let bondStatus = '';
            let classIcon = '';
            let classType = '';
            let classDescription = '';

            if (bondPrice > faceValue) {
                bondStatus = 'Premium Bond';
                classIcon = '💰';
                classType = 'Premium Bond';
                classDescription = 'Trading above par (Coupon > Market Rate)';
            } else if (bondPrice < faceValue) {
                bondStatus = 'Discount Bond';
                classIcon = '📉';
                classType = 'Discount Bond';
                classDescription = 'Trading below par (Coupon < Market Rate)';
            } else {
                bondStatus = 'Par Bond';
                classIcon = '📊';
                classType = 'Par Bond';
                classDescription = 'Trading at par (Coupon = Market Rate)';
            }

            const frequencyNames = {
                '1': 'Annual',
                '2': 'Semi-Annual',
                '4': 'Quarterly',
                '12': 'Monthly'
            };

            // Update UI
            document.getElementById('bondPrice').textContent = formatCurrency(bondPrice, currency);
            document.getElementById('currentYield').textContent = currentYield.toFixed(2) + '%';
            document.getElementById('ytm').textContent = ytm.toFixed(2) + '%';
            document.getElementById('totalCoupons').textContent = formatCurrency(totalCouponPayments, currency);
            document.getElementById('totalReturn').textContent = formatCurrency(netGain, currency);

            document.getElementById('faceValueDisplay').textContent = formatCurrency(faceValue, currency);
            document.getElementById('couponRateDisplay').textContent = (couponRate * 100).toFixed(2) + '%';
            document.getElementById('annualCoupon').textContent = formatCurrency(annualCoupon, currency);
            document.getElementById('frequencyDisplay').textContent = frequencyNames[frequency];
            document.getElementById('couponPerPayment').textContent = formatCurrency(couponPayment, currency);
            document.getElementById('maturityDisplay').textContent = years + ' years';
            document.getElementById('totalPayments').textContent = totalPeriods + ' payments';

            document.getElementById('marketRateDisplay').textContent = (marketRate * 100).toFixed(2) + '%';
            document.getElementById('pvCoupons').textContent = formatCurrency(pvCoupons, currency);
            document.getElementById('pvFaceValue').textContent = formatCurrency(pvFaceValue, currency);
            document.getElementById('fairPrice').textContent = formatCurrency(bondPrice, currency);

            document.getElementById('currentYieldCalc').textContent = currentYield.toFixed(2) + '%';
            document.getElementById('ytmCalc').textContent = ytm.toFixed(2) + '%';
            document.getElementById('bondStatus').textContent = bondStatus;

            document.getElementById('purchasePriceDisplay').textContent = formatCurrency(purchasePrice, currency);
            document.getElementById('totalCouponPayments').textContent = formatCurrency(totalCouponPayments, currency);
            document.getElementById('faceValueReturn').textContent = formatCurrency(faceValue, currency);
            document.getElementById('totalReceived').textContent = formatCurrency(totalReceived, currency);
            document.getElementById('netGain').textContent = formatCurrency(netGain, currency);

            document.getElementById('classIcon').textContent = classIcon;
            document.getElementById('classType').textContent = classType;
            document.getElementById('classDescription').textContent = classDescription;
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
            calculateBond();
        });
    </script>
</body>
</html>