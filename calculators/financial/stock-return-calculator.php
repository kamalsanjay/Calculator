<?php
/**
 * Stock Return Calculator
 * File: stock-return-calculator.php
 * Description: Calculate stock investment returns and gains (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Return Calculator - Calculate Investment Returns (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free stock return calculator. Calculate stock investment returns, gains, and ROI. Includes dividends and fees. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128200; Stock Return Calculator</h1>
        <p>Calculate stock investment returns and gains</p>
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
                <h2>Stock Investment Details</h2>
                <form id="stockForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD (&#36;)</option>
                            <option value="INR">INR (&#8377;)</option>
                            <option value="EUR">EUR (&#8364;)</option>
                            <option value="GBP">GBP (&#163;)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #4CAF50; margin: 25px 0 15px;">Purchase Details</h3>
                    
                    <div class="form-group">
                        <label for="buyPrice">Purchase Price per Share (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="buyPrice" value="100" min="0" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="numShares">Number of Shares</label>
                        <input type="number" id="numShares" value="100" min="1" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="buyCommission">Purchase Commission (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="buyCommission" value="10" min="0" step="0.01">
                        <small>Broker fees on purchase</small>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Sale Details</h3>
                    
                    <div class="form-group">
                        <label for="sellPrice">Sale Price per Share (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="sellPrice" value="150" min="0" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="sellCommission">Sale Commission (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="sellCommission" value="10" min="0" step="0.01">
                        <small>Broker fees on sale</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Additional Income</h3>
                    
                    <div class="form-group">
                        <label for="dividends">Total Dividends Received (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="dividends" value="200" min="0" step="0.01">
                        <small>Dividends earned while holding</small>
                    </div>
                    
                    <h3 style="color: #f44336; margin: 25px 0 15px;">Taxes (Optional)</h3>
                    
                    <div class="form-group">
                        <label for="capitalGainsTax">Capital Gains Tax Rate (%)</label>
                        <input type="number" id="capitalGainsTax" value="15" min="0" max="50" step="0.5">
                        <small>Long-term: 0-20%, Short-term: ordinary rate</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Returns</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Investment Returns</h2>
                
                <div class="result-card success">
                    <h3>Total Profit/Loss</h3>
                    <div class="amount" id="totalProfit">$0.00</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Return</h4>
                        <div class="value" id="totalReturn">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Capital Gain</h4>
                        <div class="value" id="capitalGain">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Dividends</h4>
                        <div class="value" id="dividendIncome">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>After-Tax Profit</h4>
                        <div class="value" id="afterTaxProfit">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Purchase Summary</h3>
                    <div class="breakdown-item">
                        <span>Purchase Price per Share</span>
                        <strong id="buyPriceDisplay">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Number of Shares</span>
                        <strong id="sharesDisplay">0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Shares Cost</span>
                        <strong id="sharesCost">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Purchase Commission</span>
                        <strong id="buyCommissionDisplay" style="color: #f44336;">+$0.00</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Investment</strong></span>
                        <strong id="totalInvestment" style="color: #667eea; font-size: 1.1em;">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cost Basis per Share</span>
                        <strong id="costBasis" style="color: #667eea;">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Sale Summary</h3>
                    <div class="breakdown-item">
                        <span>Sale Price per Share</span>
                        <strong id="sellPriceDisplay">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Number of Shares</span>
                        <strong id="sharesSold">0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gross Sale Proceeds</span>
                        <strong id="grossProceeds">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Sale Commission</span>
                        <strong id="sellCommissionDisplay" style="color: #f44336;">-$0.00</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Sale Proceeds</strong></span>
                        <strong id="netProceeds" style="color: #4CAF50; font-size: 1.1em;">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Capital Gains Analysis</h3>
                    <div class="breakdown-item">
                        <span>Net Sale Proceeds</span>
                        <strong id="proceedsForGain">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Investment (Cost Basis)</span>
                        <strong id="investmentForGain" style="color: #667eea;">-$0.00</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Capital Gain/Loss</strong></span>
                        <strong id="capitalGainAmount" style="font-size: 1.1em;">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Price Change per Share</span>
                        <strong id="priceChange">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Percentage Gain/Loss</span>
                        <strong id="percentGain" style="color: #667eea;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Return Calculation</h3>
                    <div class="breakdown-item">
                        <span>Capital Gain</span>
                        <strong id="capitalGainTotal">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Dividend Income</span>
                        <strong id="dividendTotal" style="color: #4CAF50;">+$0.00</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Profit/Loss</strong></span>
                        <strong id="totalProfitCalc" style="font-size: 1.2em;">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Return %</span>
                        <strong id="totalReturnPercent" style="color: #667eea; font-size: 1.1em;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Analysis</h3>
                    <div class="breakdown-item">
                        <span>Taxable Gain</span>
                        <strong id="taxableGain">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Capital Gains Tax Rate</span>
                        <strong id="taxRateDisplay">15%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Capital Gains Tax Owed</span>
                        <strong id="taxOwed" style="color: #f44336;">$0.00</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>After-Tax Profit</strong></span>
                        <strong id="afterTaxProfitCalc" style="color: #4CAF50; font-size: 1.1em;">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After-Tax Return %</span>
                        <strong id="afterTaxReturn">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Per Share Analysis</h3>
                    <div class="breakdown-item">
                        <span>Buy Price per Share</span>
                        <strong id="buyPerShare">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Sell Price per Share</span>
                        <strong id="sellPerShare">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gain per Share</span>
                        <strong id="gainPerShare" style="color: #4CAF50;">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Dividend per Share</span>
                        <strong id="dividendPerShare">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Return per Share</span>
                        <strong id="returnPerShare" style="color: #667eea;">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Fees & Commissions</h3>
                    <div class="breakdown-item">
                        <span>Purchase Commission</span>
                        <strong id="buyFee">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Sale Commission</span>
                        <strong id="sellFee">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Fees</span>
                        <strong id="totalFees" style="color: #f44336;">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fees as % of Investment</span>
                        <strong id="feesPercent">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Investment Performance</h3>
                    <div class="breakdown-item">
                        <span>Total Invested</span>
                        <strong id="totalInvestedPerf">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Received</span>
                        <strong id="totalReceived">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Net Profit/Loss</span>
                        <strong id="netProfitLoss">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>ROI (Return on Investment)</span>
                        <strong id="roi" style="color: #667eea; font-size: 1.1em;">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Break-Even Analysis</h3>
                    <div class="breakdown-item">
                        <span>Break-Even Price per Share</span>
                        <strong id="breakEvenPrice" style="color: #FF9800;">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Price</span>
                        <strong id="currentPriceDisplay">$0.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Above/Below Break-Even</span>
                        <strong id="vsBreakEven">$0.00</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Stock Investment Tips:</strong> Long-term = better tax rates (hold >1 year). Dividends = passive income. Diversify portfolio. Don't panic sell. Dollar-cost averaging reduces risk. Capital gains taxed when sold. Track cost basis. Reinvest dividends for compound growth. Fees eat returns (choose low-cost brokers). Stop-loss protects downside. Research before buying. Market timing = risky. Index funds beat most active investors. Tax-loss harvesting saves taxes. Keep records for taxes. Contribute to tax-advantaged accounts first (IRA, 401k).
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('stockForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateReturns();
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
            calculateReturns();
        });

        function calculateReturns() {
            const buyPrice = parseFloat(document.getElementById('buyPrice').value) || 0;
            const numShares = parseInt(document.getElementById('numShares').value) || 0;
            const buyCommission = parseFloat(document.getElementById('buyCommission').value) || 0;
            const sellPrice = parseFloat(document.getElementById('sellPrice').value) || 0;
            const sellCommission = parseFloat(document.getElementById('sellCommission').value) || 0;
            const dividends = parseFloat(document.getElementById('dividends').value) || 0;
            const capitalGainsTax = parseFloat(document.getElementById('capitalGainsTax').value) / 100 || 0;
            const currency = currencySelect.value;

            // Purchase calculations
            const sharesCost = buyPrice * numShares;
            const totalInvestment = sharesCost + buyCommission;
            const costBasis = totalInvestment / numShares;

            // Sale calculations
            const grossProceeds = sellPrice * numShares;
            const netProceeds = grossProceeds - sellCommission;

            // Capital gains
            const capitalGain = netProceeds - totalInvestment;
            const priceChange = sellPrice - buyPrice;
            const percentGain = totalInvestment > 0 ? (capitalGain / totalInvestment) * 100 : 0;

            // Total return
            const totalProfit = capitalGain + dividends;
            const totalReturn = totalInvestment > 0 ? (totalProfit / totalInvestment) * 100 : 0;

            // Tax calculations
            const taxableGain = Math.max(0, capitalGain);
            const taxOwed = taxableGain * capitalGainsTax;
            const afterTaxProfit = totalProfit - taxOwed;
            const afterTaxReturn = totalInvestment > 0 ? (afterTaxProfit / totalInvestment) * 100 : 0;

            // Per share
            const gainPerShare = priceChange;
            const dividendPerShare = numShares > 0 ? dividends / numShares : 0;
            const returnPerShare = gainPerShare + dividendPerShare;

            // Fees
            const totalFees = buyCommission + sellCommission;
            const feesPercent = totalInvestment > 0 ? (totalFees / totalInvestment) * 100 : 0;

            // Performance
            const totalReceived = netProceeds + dividends;
            const netProfitLoss = totalProfit;
            const roi = totalReturn;

            // Break-even
            const breakEvenPrice = costBasis + (sellCommission / numShares);
            const vsBreakEven = sellPrice - breakEvenPrice;

            // Update card color and profit sign
            const card = document.getElementById('totalProfit').closest('.result-card');
            if (totalProfit >= 0) {
                card.className = 'result-card success';
            } else {
                card.className = 'result-card warning';
            }

            const profitColor = totalProfit >= 0 ? '#4CAF50' : '#f44336';
            const profitSign = totalProfit >= 0 ? '+' : '';

            // Analysis
            let analysis = `You invested ${formatCurrency(totalInvestment, currency)} (${numShares} shares at ${formatCurrency(buyPrice, currency)} plus ${formatCurrency(buyCommission, currency)} commission). `;
            analysis += `Selling at ${formatCurrency(sellPrice, currency)} per share (minus ${formatCurrency(sellCommission, currency)} commission) gives ${formatCurrency(netProceeds, currency)} in proceeds. `;
            
            if (capitalGain >= 0) {
                analysis += `Your capital gain is ${formatCurrency(capitalGain, currency)} (${percentGain.toFixed(2)}%). `;
            } else {
                analysis += `Your capital loss is ${formatCurrency(Math.abs(capitalGain), currency)} (${percentGain.toFixed(2)}%). `;
            }
            
            if (dividends > 0) {
                analysis += `Including ${formatCurrency(dividends, currency)} in dividends, `;
            }
            
            if (totalProfit >= 0) {
                analysis += `your total profit is ${formatCurrency(totalProfit, currency)} (${totalReturn.toFixed(2)}% return). `;
            } else {
                analysis += `your total loss is ${formatCurrency(Math.abs(totalProfit), currency)} (${totalReturn.toFixed(2)}% return). `;
            }
            
            if (taxOwed > 0) {
                analysis += `After ${formatCurrency(taxOwed, currency)} in capital gains tax, your after-tax profit is ${formatCurrency(afterTaxProfit, currency)}.`;
            }

            // Update UI
            document.getElementById('totalProfit').textContent = profitSign + formatCurrency(totalProfit, currency);
            document.getElementById('totalProfit').style.color = profitColor;
            document.getElementById('totalReturn').textContent = totalReturn.toFixed(2) + '%';
            document.getElementById('totalReturn').style.color = profitColor;
            document.getElementById('capitalGain').textContent = formatCurrency(capitalGain, currency);
            document.getElementById('capitalGain').style.color = capitalGain >= 0 ? '#4CAF50' : '#f44336';
            document.getElementById('dividendIncome').textContent = formatCurrency(dividends, currency);
            document.getElementById('afterTaxProfit').textContent = formatCurrency(afterTaxProfit, currency);
            document.getElementById('afterTaxProfit').style.color = afterTaxProfit >= 0 ? '#4CAF50' : '#f44336';

            document.getElementById('buyPriceDisplay').textContent = formatCurrency(buyPrice, currency);
            document.getElementById('sharesDisplay').textContent = numShares + ' shares';
            document.getElementById('sharesCost').textContent = formatCurrency(sharesCost, currency);
            document.getElementById('buyCommissionDisplay').textContent = formatCurrency(buyCommission, currency);
            document.getElementById('totalInvestment').textContent = formatCurrency(totalInvestment, currency);
            document.getElementById('costBasis').textContent = formatCurrency(costBasis, currency) + '/share';

            document.getElementById('sellPriceDisplay').textContent = formatCurrency(sellPrice, currency);
            document.getElementById('sharesSold').textContent = numShares + ' shares';
            document.getElementById('grossProceeds').textContent = formatCurrency(grossProceeds, currency);
            document.getElementById('sellCommissionDisplay').textContent = formatCurrency(sellCommission, currency);
            document.getElementById('netProceeds').textContent = formatCurrency(netProceeds, currency);

            document.getElementById('proceedsForGain').textContent = formatCurrency(netProceeds, currency);
            document.getElementById('investmentForGain').textContent = formatCurrency(totalInvestment, currency);
            document.getElementById('capitalGainAmount').textContent = formatCurrency(capitalGain, currency);
            document.getElementById('capitalGainAmount').style.color = capitalGain >= 0 ? '#4CAF50' : '#f44336';
            document.getElementById('priceChange').textContent = formatCurrency(priceChange, currency) + '/share';
            document.getElementById('percentGain').textContent = percentGain.toFixed(2) + '%';

            document.getElementById('capitalGainTotal').textContent = formatCurrency(capitalGain, currency);
            document.getElementById('dividendTotal').textContent = formatCurrency(dividends, currency);
            document.getElementById('totalProfitCalc').textContent = formatCurrency(totalProfit, currency);
            document.getElementById('totalProfitCalc').style.color = profitColor;
            document.getElementById('totalReturnPercent').textContent = totalReturn.toFixed(2) + '%';

            document.getElementById('taxableGain').textContent = formatCurrency(taxableGain, currency);
            document.getElementById('taxRateDisplay').textContent = (capitalGainsTax * 100).toFixed(1) + '%';
            document.getElementById('taxOwed').textContent = formatCurrency(taxOwed, currency);
            document.getElementById('afterTaxProfitCalc').textContent = formatCurrency(afterTaxProfit, currency);
            document.getElementById('afterTaxReturn').textContent = afterTaxReturn.toFixed(2) + '%';

            document.getElementById('buyPerShare').textContent = formatCurrency(buyPrice, currency);
            document.getElementById('sellPerShare').textContent = formatCurrency(sellPrice, currency);
            document.getElementById('gainPerShare').textContent = formatCurrency(gainPerShare, currency);
            document.getElementById('dividendPerShare').textContent = formatCurrency(dividendPerShare, currency);
            document.getElementById('returnPerShare').textContent = formatCurrency(returnPerShare, currency);

            document.getElementById('buyFee').textContent = formatCurrency(buyCommission, currency);
            document.getElementById('sellFee').textContent = formatCurrency(sellCommission, currency);
            document.getElementById('totalFees').textContent = formatCurrency(totalFees, currency);
            document.getElementById('feesPercent').textContent = feesPercent.toFixed(2) + '%';

            document.getElementById('totalInvestedPerf').textContent = formatCurrency(totalInvestment, currency);
            document.getElementById('totalReceived').textContent = formatCurrency(totalReceived, currency);
            document.getElementById('netProfitLoss').textContent = formatCurrency(netProfitLoss, currency);
            document.getElementById('netProfitLoss').style.color = profitColor;
            document.getElementById('roi').textContent = roi.toFixed(2) + '%';

            document.getElementById('breakEvenPrice').textContent = formatCurrency(breakEvenPrice, currency);
            document.getElementById('currentPriceDisplay').textContent = formatCurrency(sellPrice, currency);
            document.getElementById('vsBreakEven').textContent = formatCurrency(vsBreakEven, currency) + (vsBreakEven >= 0 ? ' above' : ' below');
            document.getElementById('vsBreakEven').style.color = vsBreakEven >= 0 ? '#4CAF50' : '#f44336';

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
            calculateReturns();
        });
    </script>
</body>
</html>