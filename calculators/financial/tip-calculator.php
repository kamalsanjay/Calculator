<?php
/**
 * Tip Calculator
 * File: tip-calculator.php
 * Description: Calculate tips and split bills with multiple currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tip Calculator - Calculate Tips & Split Bills (USD/INR)</title>
    <meta name="description" content="Free tip calculator with bill splitting. Calculate tips, split bills among people, and see per-person amounts. Supports USD and INR currencies.">
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
        
        .tip-presets {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .tip-preset {
            padding: 12px;
            border: 2px solid #667eea;
            border-radius: 5px;
            background: white;
            color: #667eea;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        
        .tip-preset:hover {
            background: #667eea;
            color: white;
        }
        
        .tip-preset.active {
            background: #667eea;
            color: white;
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
            
            .tip-presets {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>💰 Tip Calculator</h1>
        <p>Calculate tips and split bills easily</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Bill Details</h2>
                <form id="tipForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="billAmount">Bill Amount (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="billAmount" value="100" min="0" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Tip Percentage (%)</label>
                        <div class="tip-presets">
                            <div class="tip-preset" data-tip="10">10%</div>
                            <div class="tip-preset active" data-tip="15">15%</div>
                            <div class="tip-preset" data-tip="18">18%</div>
                            <div class="tip-preset" data-tip="20">20%</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="tipPercent">Custom Tip Percentage (%)</label>
                        <input type="number" id="tipPercent" value="15" min="0" max="100" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="numPeople">Number of People</label>
                        <input type="number" id="numPeople" value="1" min="1" max="100" step="1" required>
                        <small>Split the bill among this many people</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Tip</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Bill Summary</h2>
                
                <div class="result-card">
                    <h3>Total Amount</h3>
                    <div class="amount" id="totalAmount">$0.00</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Tip Amount</h4>
                        <div class="value" id="tipAmount">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Per Person</h4>
                        <div class="value" id="perPerson">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Tip Per Person</h4>
                        <div class="value" id="tipPerPerson">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Bill Per Person</h4>
                        <div class="value" id="billPerPerson">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Bill Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Original Bill</span>
                        <strong id="originalBill">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tip Percentage</span>
                        <strong id="tipPercentDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tip Amount</span>
                        <strong id="tipAmountDisplay" style="color: #4CAF50;">$0.00</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total with Tip</strong></span>
                        <strong id="totalWithTip" style="color: #667eea; font-size: 1.2em;">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Split Among <span id="numPeopleDisplay">1</span> People</h3>
                    <div class="breakdown-item">
                        <span>Bill Per Person</span>
                        <strong id="billPerPersonDisplay">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tip Per Person</span>
                        <strong id="tipPerPersonDisplay">$0.00</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Per Person</strong></span>
                        <strong id="totalPerPerson" style="color: #667eea; font-size: 1.2em;">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Other Tip Options</h3>
                    <div class="breakdown-item">
                        <span>10% Tip Total</span>
                        <strong id="tip10Total">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>15% Tip Total</span>
                        <strong id="tip15Total">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>18% Tip Total</span>
                        <strong id="tip18Total">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>20% Tip Total</span>
                        <strong id="tip20Total">$0.00</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Tipping Guide:</strong> In the US, 15-20% is standard for good service. In India, 10% is common at restaurants. Adjust based on service quality and local customs.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('tipForm');
        const currencySelect = document.getElementById('currency');
        const tipPresets = document.querySelectorAll('.tip-preset');
        const tipPercentInput = document.getElementById('tipPercent');

        // Tip preset buttons
        tipPresets.forEach(preset => {
            preset.addEventListener('click', function() {
                tipPresets.forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                tipPercentInput.value = this.dataset.tip;
                calculateTip();
            });
        });

        // Currency change
        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateTip();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            document.getElementById('currencyLabel1').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateTip();
        });

        function calculateTip() {
            const billAmount = parseFloat(document.getElementById('billAmount').value) || 0;
            const tipPercent = parseFloat(document.getElementById('tipPercent').value) || 0;
            const numPeople = parseInt(document.getElementById('numPeople').value) || 1;
            const currency = currencySelect.value;

            const tipAmountValue = billAmount * (tipPercent / 100);
            const totalAmountValue = billAmount + tipAmountValue;
            const perPersonValue = totalAmountValue / numPeople;
            const tipPerPersonValue = tipAmountValue / numPeople;
            const billPerPersonValue = billAmount / numPeople;

            // Other tip options
            const tip10 = billAmount + (billAmount * 0.10);
            const tip15 = billAmount + (billAmount * 0.15);
            const tip18 = billAmount + (billAmount * 0.18);
            const tip20 = billAmount + (billAmount * 0.20);

            // Update UI
            document.getElementById('totalAmount').textContent = formatCurrency(totalAmountValue, currency);
            document.getElementById('tipAmount').textContent = formatCurrency(tipAmountValue, currency);
            document.getElementById('perPerson').textContent = formatCurrency(perPersonValue, currency);
            document.getElementById('tipPerPerson').textContent = formatCurrency(tipPerPersonValue, currency);
            document.getElementById('billPerPerson').textContent = formatCurrency(billPerPersonValue, currency);

            document.getElementById('originalBill').textContent = formatCurrency(billAmount, currency);
            document.getElementById('tipPercentDisplay').textContent = tipPercent.toFixed(1) + '%';
            document.getElementById('tipAmountDisplay').textContent = formatCurrency(tipAmountValue, currency);
            document.getElementById('totalWithTip').textContent = formatCurrency(totalAmountValue, currency);

            document.getElementById('numPeopleDisplay').textContent = numPeople;
            document.getElementById('billPerPersonDisplay').textContent = formatCurrency(billPerPersonValue, currency);
            document.getElementById('tipPerPersonDisplay').textContent = formatCurrency(tipPerPersonValue, currency);
            document.getElementById('totalPerPerson').textContent = formatCurrency(perPersonValue, currency);

            document.getElementById('tip10Total').textContent = formatCurrency(tip10, currency);
            document.getElementById('tip15Total').textContent = formatCurrency(tip15, currency);
            document.getElementById('tip18Total').textContent = formatCurrency(tip18, currency);
            document.getElementById('tip20Total').textContent = formatCurrency(tip20, currency);
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
            calculateTip();
        });
    </script>
</body>
</html>