<?php
/**
 * Profit Margin Calculator
 * File: profit-margin-calculator.php
 * Description: Calculate profit margins and markup (USD/INR/EUR/GBP)
 */

$page_title = "Profit Margin Calculator - Calculate Margins & Markup (USD/INR/EUR/GBP)";
$page_description = "Free profit margin calculator. Calculate gross profit, net profit, markup percentage, and pricing. Optimize business profitability. USD, INR, EUR, GBP.";

include 'includes/header.php';
?>

<header>
    <h1>💹 Profit Margin Calculator</h1>
    <p>Calculate profit margins, markup, and optimal pricing</p>
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
        <a href="index.php">← Back to Financial Calculators</a>
    </div>

    <div class="calculator-wrapper">
        <div class="calculator-section">
            <h2>Product Costs & Pricing</h2>
            <form id="profitMarginForm">
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
                    <label for="costPrice">Cost Price (<span id="currencyLabel1">$</span>)</label>
                    <input type="number" id="costPrice" value="50" min="0.01" step="0.01" required>
                    <small>Cost to produce/acquire product</small>
                </div>
                
                <div class="form-group">
                    <label for="sellingPrice">Selling Price (<span id="currencyLabel2">$</span>)</label>
                    <input type="number" id="sellingPrice" value="100" min="0.01" step="0.01" required>
                    <small>Price you sell to customers</small>
                </div>
                
                <div class="form-group">
                    <label for="operatingExpenses">Operating Expenses (<span id="currencyLabel3">$</span>)</label>
                    <input type="number" id="operatingExpenses" value="15" min="0" step="0.01">
                    <small>Marketing, overhead per unit (optional)</small>
                </div>
                
                <div class="form-group">
                    <label for="unitsSold">Units Sold</label>
                    <input type="number" id="unitsSold" value="1000" min="1" step="1">
                    <small>For total profit calculation</small>
                </div>
                
                <button type="submit" class="btn">Calculate Margins</button>
            </form>
        </div>

        <div class="results-section">
            <h2>Profit Analysis</h2>
            
            <div class="result-card success">
                <h3>Gross Profit Margin</h3>
                <div class="amount" id="grossMargin">0%</div>
            </div>

            <div class="metric-grid">
                <div class="metric-card">
                    <h4>Net Profit Margin</h4>
                    <div class="value" id="netMargin">0%</div>
                </div>
                <div class="metric-card">
                    <h4>Markup %</h4>
                    <div class="value" id="markupPercent">0%</div>
                </div>
                <div class="metric-card">
                    <h4>Profit per Unit</h4>
                    <div class="value" id="profitPerUnit">$0</div>
                </div>
                <div class="metric-card">
                    <h4>Total Profit</h4>
                    <div class="value" id="totalProfit">$0</div>
                </div>
            </div>

            <div class="breakdown">
                <h3>Per Unit Analysis</h3>
                <div class="breakdown-item">
                    <span>Cost Price</span>
                    <strong id="costDisplay">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Selling Price</span>
                    <strong id="priceDisplay">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Gross Profit</span>
                    <strong id="grossProfit" style="color: #4CAF50;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Operating Expenses</span>
                    <strong id="expensesDisplay">$0</strong>
                </div>
                <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                    <span><strong>Net Profit per Unit</strong></span>
                    <strong id="netProfitUnit" style="color: #667eea; font-size: 1.1em;">$0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Margin Calculations</h3>
                <div class="breakdown-item">
                    <span>Gross Profit Margin</span>
                    <strong id="grossMarginDisplay" style="color: #4CAF50;">0%</strong>
                </div>
                <div class="breakdown-item">
                    <span>Net Profit Margin</span>
                    <strong id="netMarginDisplay" style="color: #667eea;">0%</strong>
                </div>
                <div class="breakdown-item">
                    <span>Markup Percentage</span>
                    <strong id="markupDisplay">0%</strong>
                </div>
                <div class="breakdown-item">
                    <span>Profit to Cost Ratio</span>
                    <strong id="profitRatio">0:1</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Total Business Profit</h3>
                <div class="breakdown-item">
                    <span>Units Sold</span>
                    <strong id="unitsSoldDisplay">1,000</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Revenue</span>
                    <strong id="totalRevenue" style="color: #667eea;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Cost (COGS)</span>
                    <strong id="totalCost">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Operating Expenses</span>
                    <strong id="totalExpenses">$0</strong>
                </div>
                <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                    <span><strong>Total Net Profit</strong></span>
                    <strong id="totalNetProfit" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Pricing Recommendations</h3>
                <div class="breakdown-item">
                    <span>For 25% Margin</span>
                    <strong id="price25">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>For 30% Margin</span>
                    <strong id="price30">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>For 40% Margin</span>
                    <strong id="price40">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>For 50% Margin</span>
                    <strong id="price50" style="color: #4CAF50;">$0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Margin vs Markup</h3>
                <div style="padding: 15px; background: #f8f9fa; border-radius: 5px; margin-bottom: 10px;">
                    <strong style="color: #667eea;">Profit Margin:</strong>
                    <div style="margin-top: 5px;">Profit as % of Selling Price = (Profit ÷ Price) × 100</div>
                    <div style="color: #4CAF50; margin-top: 5px;" id="marginFormula">($50 ÷ $100) × 100 = 50%</div>
                </div>
                <div style="padding: 15px; background: #f8f9fa; border-radius: 5px;">
                    <strong style="color: #667eea;">Markup:</strong>
                    <div style="margin-top: 5px;">Profit as % of Cost = (Profit ÷ Cost) × 100</div>
                    <div style="color: #4CAF50; margin-top: 5px;" id="markupFormula">($50 ÷ $50) × 100 = 100%</div>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Margin Benchmark</h3>
                <div class="breakdown-item">
                    <span>Your Gross Margin</span>
                    <strong id="yourMargin" style="color: #667eea;">0%</strong>
                </div>
                <div class="breakdown-item">
                    <span>Industry Average (Retail)</span>
                    <strong>25-50%</strong>
                </div>
                <div class="breakdown-item">
                    <span>Industry Average (Software)</span>
                    <strong>70-90%</strong>
                </div>
                <div class="breakdown-item">
                    <span>Industry Average (Food)</span>
                    <strong>60-70%</strong>
                </div>
            </div>
            
            <div class="info-box">
                <strong>Profit Tips:</strong> Margin = profit % of selling price. Markup = profit % of cost. Higher margin = more profitable. Gross margin excludes operating costs. Net margin includes all expenses. Aim for 30%+ net margin. Monitor margin trends. Volume vs margin tradeoff.
            </div>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('profitMarginForm');
    const currencySelect = document.getElementById('currency');

    currencySelect.addEventListener('change', function() {
        updateCurrencyLabels();
        calculateMargins();
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
        for (let i = 1; i <= 3; i++) {
            document.getElementById('currencyLabel' + i).textContent = symbol;
        }
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        calculateMargins();
    });

    function calculateMargins() {
        const cost = parseFloat(document.getElementById('costPrice').value) || 0;
        const price = parseFloat(document.getElementById('sellingPrice').value) || 0;
        const expenses = parseFloat(document.getElementById('operatingExpenses').value) || 0;
        const units = parseInt(document.getElementById('unitsSold').value) || 1;
        const currency = currencySelect.value;

        // Per unit calculations
        const grossProfit = price - cost;
        const netProfit = grossProfit - expenses;

        // Margins
        const grossMargin = price > 0 ? (grossProfit / price) * 100 : 0;
        const netMargin = price > 0 ? (netProfit / price) * 100 : 0;

        // Markup
        const markup = cost > 0 ? (grossProfit / cost) * 100 : 0;

        // Profit ratio
        const profitRatio = cost > 0 ? (grossProfit / cost).toFixed(2) : 0;

        // Total calculations
        const totalRevenue = price * units;
        const totalCost = cost * units;
        const totalExpenses = expenses * units;
        const totalNetProfit = netProfit * units;

        // Recommended prices for different margins
        function priceForMargin(targetMargin) {
            return cost / (1 - targetMargin / 100);
        }

        const price25 = priceForMargin(25);
        const price30 = priceForMargin(30);
        const price40 = priceForMargin(40);
        const price50 = priceForMargin(50);

        // Update UI
        document.getElementById('grossMargin').textContent = grossMargin.toFixed(2) + '%';
        document.getElementById('netMargin').textContent = netMargin.toFixed(2) + '%';
        document.getElementById('markupPercent').textContent = markup.toFixed(2) + '%';
        document.getElementById('profitPerUnit').textContent = formatCurrency(netProfit, currency);
        document.getElementById('totalProfit').textContent = formatCurrency(totalNetProfit, currency);

        document.getElementById('costDisplay').textContent = formatCurrency(cost, currency);
        document.getElementById('priceDisplay').textContent = formatCurrency(price, currency);
        document.getElementById('grossProfit').textContent = formatCurrency(grossProfit, currency);
        document.getElementById('expensesDisplay').textContent = formatCurrency(expenses, currency);
        document.getElementById('netProfitUnit').textContent = formatCurrency(netProfit, currency);

        document.getElementById('grossMarginDisplay').textContent = grossMargin.toFixed(2) + '%';
        document.getElementById('netMarginDisplay').textContent = netMargin.toFixed(2) + '%';
        document.getElementById('markupDisplay').textContent = markup.toFixed(2) + '%';
        document.getElementById('profitRatio').textContent = profitRatio + ':1';

        document.getElementById('unitsSoldDisplay').textContent = units.toLocaleString();
        document.getElementById('totalRevenue').textContent = formatCurrency(totalRevenue, currency);
        document.getElementById('totalCost').textContent = formatCurrency(totalCost, currency);
        document.getElementById('totalExpenses').textContent = formatCurrency(totalExpenses, currency);
        document.getElementById('totalNetProfit').textContent = formatCurrency(totalNetProfit, currency);

        document.getElementById('price25').textContent = formatCurrency(price25, currency);
        document.getElementById('price30').textContent = formatCurrency(price30, currency);
        document.getElementById('price40').textContent = formatCurrency(price40, currency);
        document.getElementById('price50').textContent = formatCurrency(price50, currency);

        // Formulas
        document.getElementById('marginFormula').textContent = 
            `(${formatCurrency(grossProfit, currency)} ÷ ${formatCurrency(price, currency)}) × 100 = ${grossMargin.toFixed(2)}%`;
        document.getElementById('markupFormula').textContent = 
            `(${formatCurrency(grossProfit, currency)} ÷ ${formatCurrency(cost, currency)}) × 100 = ${markup.toFixed(2)}%`;

        document.getElementById('yourMargin').textContent = grossMargin.toFixed(2) + '%';
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
        calculateMargins();
    });
</script>

<?php include 'includes/footer.php'; ?>