<?php
/**
 * Capital Gains Tax Calculator
 * File: capital-gains-tax-calculator.php
 * Description: Calculate capital gains tax on investments (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capital Gains Tax Calculator - Calculate Investment Taxes (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free capital gains tax calculator. Calculate short-term and long-term capital gains tax on stocks, real estate, and investments. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>📈 Capital Gains Tax Calculator</h1>
        <p>Calculate taxes on investment profits</p>
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

/* Header Styles */
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

/* Breadcrumb */
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

/* Calculator Layout */
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

/* Form Styles */
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

/* Button */
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

/* Result Card */
.result-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px;
    border-radius: 10px;
    margin-bottom: 20px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.result-card.success {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
}

.result-card.warning {
    background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
    box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
}

.result-card.info {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
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

/* Metric Grid */
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

/* Breakdown Section */
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

/* Info Box */
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

/* Tables */
.schedule-table {
    width: 100%;
    margin-top: 20px;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

table thead {
    background: #667eea;
    color: white;
}

table th,
table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

table tbody tr:hover {
    background: #f8f9fa;
}

/* Utility Classes */
.text-center {
    text-align: center;
}

.text-success {
    color: #4CAF50;
}

.text-danger {
    color: #f44336;
}

.text-warning {
    color: #FF9800;
}

.text-info {
    color: #2196F3;
}

.text-primary {
    color: #667eea;
}

.mt-10 {
    margin-top: 10px;
}

.mt-20 {
    margin-top: 20px;
}

.mb-10 {
    margin-bottom: 10px;
}

.mb-20 {
    margin-bottom: 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .calculator-wrapper {
        grid-template-columns: 1fr;
    }
    
    header h1 {
        font-size: 2em;
    }
    
    header p {
        font-size: 1em;
    }
    
    .result-card .amount {
        font-size: 2.5em;
    }
    
    .metric-grid {
        grid-template-columns: 1fr;
    }
    
    table {
        font-size: 0.9em;
    }
    
    .calculator-section,
    .results-section {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 10px;
    }
    
    header {
        padding: 30px 15px;
    }
    
    header h1 {
        font-size: 1.8em;
    }
    
    .result-card .amount {
        font-size: 2em;
    }
    
    .form-group input,
    .form-group select {
        padding: 10px;
        font-size: 14px;
    }
    
    .btn {
        padding: 12px 20px;
        font-size: 16px;
    }
}
</style>
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Investment Details</h2>
                <form id="capitalGainsForm">
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
                        <label for="assetType">Asset Type</label>
                        <select id="assetType">
                            <option value="stocks">Stocks / Equities</option>
                            <option value="real-estate">Real Estate / Property</option>
                            <option value="crypto">Cryptocurrency</option>
                            <option value="mutual-funds">Mutual Funds</option>
                            <option value="bonds">Bonds</option>
                            <option value="other">Other Assets</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="purchasePrice">Purchase Price / Cost Basis (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="purchasePrice" value="10000" min="0" step="100" required>
                        <small>Original purchase price</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="salePrice">Sale Price (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="salePrice" value="15000" min="0" step="100" required>
                        <small>Selling price</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="purchaseCosts">Purchase Costs (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="purchaseCosts" value="100" min="0" step="10">
                        <small>Brokerage, fees, commissions</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="saleCosts">Sale Costs (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="saleCosts" value="100" min="0" step="10">
                        <small>Brokerage, fees, commissions</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="improvements">Improvements / Additions (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="improvements" value="0" min="0" step="50">
                        <small>For real estate - renovations, upgrades</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="holdingPeriod">Holding Period (Months)</label>
                        <input type="number" id="holdingPeriod" value="18" min="0" step="1" required>
                        <small>How long you held the asset</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="shortTermRate">Short-Term Capital Gains Rate (%)</label>
                        <input type="number" id="shortTermRate" value="22" min="0" max="50" step="0.1" required>
                        <small>Usually your income tax rate (&lt;12 months)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="longTermRate">Long-Term Capital Gains Rate (%)</label>
                        <input type="number" id="longTermRate" value="15" min="0" max="30" step="0.1" required>
                        <small>Preferential rate (≥12 months)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="stateTaxRate">State Tax Rate (%)</label>
                        <input type="number" id="stateTaxRate" value="5" min="0" max="15" step="0.1">
                        <small>Additional state/provincial tax</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Tax</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Tax Calculation</h2>
                
                <div class="result-card info">
                    <h3>Net Profit (After Tax)</h3>
                    <div class="amount" id="netProfit">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Capital Gain</h4>
                        <div class="value" id="capitalGain">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Tax</h4>
                        <div class="value" id="totalTax">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Tax Type</h4>
                        <div class="value" id="taxType">Long-Term</div>
                    </div>
                    <div class="metric-card">
                        <h4>Effective Rate</h4>
                        <div class="value" id="effectiveRate">0%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Transaction Details</h3>
                    <div class="breakdown-item">
                        <span>Asset Type</span>
                        <strong id="assetTypeDisplay">Stocks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Holding Period</span>
                        <strong id="holdingPeriodDisplay">0 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax Classification</span>
                        <strong id="taxClassification">Long-Term</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Cost Basis Calculation</h3>
                    <div class="breakdown-item">
                        <span>Purchase Price</span>
                        <strong id="purchasePriceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Purchase Costs</span>
                        <strong id="purchaseCostsDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Improvements / Additions</span>
                        <strong id="improvementsDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Adjusted Cost Basis</strong></span>
                        <strong id="adjustedCostBasis" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Sale Proceeds</h3>
                    <div class="breakdown-item">
                        <span>Sale Price</span>
                        <strong id="salePriceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Less: Sale Costs</span>
                        <strong id="saleCostsDisplay" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Sale Proceeds</strong></span>
                        <strong id="netSaleProceeds" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Capital Gain Calculation</h3>
                    <div class="breakdown-item">
                        <span>Net Sale Proceeds</span>
                        <strong id="proceedsForGain">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Less: Adjusted Cost Basis</span>
                        <strong id="costBasisDeduction" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Taxable Capital Gain</strong></span>
                        <strong id="taxableGain" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Capital Gains Rate (<span id="gainRate">15</span>%)</span>
                        <strong id="capitalGainsTax" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>State Tax (<span id="stateRate">5</span>%)</span>
                        <strong id="stateTax" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Tax Due</strong></span>
                        <strong id="totalTaxDue" style="color: #f44336; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Net Profit Analysis</h3>
                    <div class="breakdown-item">
                        <span>Capital Gain</span>
                        <strong id="grossGain">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Less: Total Tax</span>
                        <strong id="taxAmount" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Profit (After Tax)</strong></span>
                        <strong id="finalNetProfit" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Effective Tax Rate</span>
                        <strong id="effectiveTaxRate" style="color: #667eea;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Return Analysis</h3>
                    <div class="breakdown-item">
                        <span>Initial Investment</span>
                        <strong id="initialInvestment">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gross Profit %</span>
                        <strong id="grossProfitPercent" style="color: #4CAF50;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Net Profit % (After Tax)</span>
                        <strong id="netProfitPercent" style="color: #667eea;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax as % of Gain</span>
                        <strong id="taxPercentOfGain">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Savings Comparison</h3>
                    <div class="breakdown-item">
                        <span>If Short-Term (<span id="stRateDisplay">22</span>%)</span>
                        <strong id="shortTermTax" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>If Long-Term (<span id="ltRateDisplay">15</span>%)</span>
                        <strong id="longTermTax" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax Savings (Long-Term)</span>
                        <strong id="taxSavings" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Capital Gains Tips:</strong> Long-term (>12 months) = lower tax rate. Short-term = ordinary income rate. Keep records of all transactions. Track cost basis adjustments. Harvest losses to offset gains. Consider tax-loss harvesting. Real estate has special rules (1031 exchange). Crypto taxes same as stocks. State taxes vary by location.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('capitalGainsForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateCapitalGains();
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
            for (let i = 1; i <= 5; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateCapitalGains();
        });

        function calculateCapitalGains() {
            const purchasePrice = parseFloat(document.getElementById('purchasePrice').value) || 0;
            const salePrice = parseFloat(document.getElementById('salePrice').value) || 0;
            const purchaseCosts = parseFloat(document.getElementById('purchaseCosts').value) || 0;
            const saleCosts = parseFloat(document.getElementById('saleCosts').value) || 0;
            const improvements = parseFloat(document.getElementById('improvements').value) || 0;
            const holdingPeriod = parseInt(document.getElementById('holdingPeriod').value) || 0;
            const shortTermRate = parseFloat(document.getElementById('shortTermRate').value) / 100 || 0.22;
            const longTermRate = parseFloat(document.getElementById('longTermRate').value) / 100 || 0.15;
            const stateTaxRate = parseFloat(document.getElementById('stateTaxRate').value) / 100 || 0.05;
            const assetType = document.getElementById('assetType').value;
            const currency = currencySelect.value;

            // Determine if long-term or short-term
            const isLongTerm = holdingPeriod >= 12;
            const applicableRate = isLongTerm ? longTermRate : shortTermRate;

            // Calculate adjusted cost basis
            const adjustedCostBasis = purchasePrice + purchaseCosts + improvements;

            // Calculate net sale proceeds
            const netSaleProceeds = salePrice - saleCosts;

            // Calculate capital gain
            const capitalGain = netSaleProceeds - adjustedCostBasis;

            // Calculate taxes
            const federalTax = capitalGain * applicableRate;
            const stateTax = capitalGain * stateTaxRate;
            const totalTax = federalTax + stateTax;

            // Net profit
            const netProfit = capitalGain - totalTax;

            // Percentages
            const effectiveRate = capitalGain > 0 ? (totalTax / capitalGain) * 100 : 0;
            const grossProfitPercent = adjustedCostBasis > 0 ? (capitalGain / adjustedCostBasis) * 100 : 0;
            const netProfitPercent = adjustedCostBasis > 0 ? (netProfit / adjustedCostBasis) * 100 : 0;
            const taxPercentOfGain = capitalGain > 0 ? (totalTax / capitalGain) * 100 : 0;

            // Tax comparison
            const shortTermTotalTax = (capitalGain * shortTermRate) + stateTax;
            const longTermTotalTax = (capitalGain * longTermRate) + stateTax;
            const taxSavings = shortTermTotalTax - longTermTotalTax;

            // Asset type display
            const assetNames = {
                'stocks': 'Stocks / Equities',
                'real-estate': 'Real Estate / Property',
                'crypto': 'Cryptocurrency',
                'mutual-funds': 'Mutual Funds',
                'bonds': 'Bonds',
                'other': 'Other Assets'
            };

            // Update UI
            document.getElementById('netProfit').textContent = formatCurrency(netProfit, currency);
            document.getElementById('capitalGain').textContent = formatCurrency(capitalGain, currency);
            document.getElementById('totalTax').textContent = formatCurrency(totalTax, currency);
            document.getElementById('taxType').textContent = isLongTerm ? 'Long-Term' : 'Short-Term';
            document.getElementById('effectiveRate').textContent = effectiveRate.toFixed(2) + '%';

            document.getElementById('assetTypeDisplay').textContent = assetNames[assetType];
            document.getElementById('holdingPeriodDisplay').textContent = holdingPeriod + ' months';
            document.getElementById('taxClassification').textContent = isLongTerm ? 'Long-Term (≥12 months)' : 'Short-Term (<12 months)';

            document.getElementById('purchasePriceDisplay').textContent = formatCurrency(purchasePrice, currency);
            document.getElementById('purchaseCostsDisplay').textContent = formatCurrency(purchaseCosts, currency);
            document.getElementById('improvementsDisplay').textContent = formatCurrency(improvements, currency);
            document.getElementById('adjustedCostBasis').textContent = formatCurrency(adjustedCostBasis, currency);

            document.getElementById('salePriceDisplay').textContent = formatCurrency(salePrice, currency);
            document.getElementById('saleCostsDisplay').textContent = formatCurrency(saleCosts, currency);
            document.getElementById('netSaleProceeds').textContent = formatCurrency(netSaleProceeds, currency);

            document.getElementById('proceedsForGain').textContent = formatCurrency(netSaleProceeds, currency);
            document.getElementById('costBasisDeduction').textContent = formatCurrency(adjustedCostBasis, currency);
            document.getElementById('taxableGain').textContent = formatCurrency(capitalGain, currency);

            document.getElementById('gainRate').textContent = (applicableRate * 100).toFixed(1);
            document.getElementById('capitalGainsTax').textContent = formatCurrency(federalTax, currency);
            document.getElementById('stateRate').textContent = (stateTaxRate * 100).toFixed(1);
            document.getElementById('stateTax').textContent = formatCurrency(stateTax, currency);
            document.getElementById('totalTaxDue').textContent = formatCurrency(totalTax, currency);

            document.getElementById('grossGain').textContent = formatCurrency(capitalGain, currency);
            document.getElementById('taxAmount').textContent = formatCurrency(totalTax, currency);
            document.getElementById('finalNetProfit').textContent = formatCurrency(netProfit, currency);
            document.getElementById('effectiveTaxRate').textContent = effectiveRate.toFixed(2) + '%';

            document.getElementById('initialInvestment').textContent = formatCurrency(adjustedCostBasis, currency);
            document.getElementById('grossProfitPercent').textContent = grossProfitPercent.toFixed(2) + '%';
            document.getElementById('netProfitPercent').textContent = netProfitPercent.toFixed(2) + '%';
            document.getElementById('taxPercentOfGain').textContent = taxPercentOfGain.toFixed(2) + '%';

            document.getElementById('stRateDisplay').textContent = (shortTermRate * 100).toFixed(1);
            document.getElementById('shortTermTax').textContent = formatCurrency(shortTermTotalTax, currency);
            document.getElementById('ltRateDisplay').textContent = (longTermRate * 100).toFixed(1);
            document.getElementById('longTermTax').textContent = formatCurrency(longTermTotalTax, currency);
            document.getElementById('taxSavings').textContent = formatCurrency(Math.max(0, taxSavings), currency);
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
            calculateCapitalGains();
        });
    </script>
</body>
</html>