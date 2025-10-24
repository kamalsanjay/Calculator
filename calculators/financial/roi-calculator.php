<?php
/**
 * ROI Calculator
 * File: roi-calculator.php
 * Description: Calculate return on investment with profit percentage and annualized returns (USD & INR)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROI Calculator - Return on Investment Calculator with Profit %</title>
    <meta name="description" content="Free ROI calculator. Calculate return on investment (ROI) with profit percentage, annualized returns, and total gain. Analyze investment performance easily.">
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
        
        .result-card.positive {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .result-card.negative {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
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
        <h1>📊 ROI Calculator</h1>
        <p>Calculate your return on investment with profit percentage</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Investment Details</h2>
                <form id="roiForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="investedAmount">Amount Invested (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="investedAmount" value="10000" min="0" step="100" required>
                        <small>Initial investment or cost</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="returnedAmount">Amount Returned (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="returnedAmount" value="15000" min="0" step="100" required>
                        <small>Final value or selling price</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="investmentDuration">Investment Duration (Years)</label>
                        <input type="number" id="investmentDuration" value="3" min="0" max="100" step="0.1" required>
                        <small>Holding period</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="additionalCosts">Additional Costs (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="additionalCosts" value="0" min="0" step="10">
                        <small>Fees, commissions, maintenance (optional)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate ROI</button>
                </form>
            </div>

            <div class="results-section">
                <h2>ROI Results</h2>
                
                <div class="result-card" id="roiCard">
                    <h3>Return on Investment (ROI)</h3>
                    <div class="amount" id="roiPercent">0%</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Net Profit</h4>
                        <div class="value" id="netProfit">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Annualized ROI</h4>
                        <div class="value" id="annualizedROI">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Return</h4>
                        <div class="value" id="totalReturn">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>ROI Multiple</h4>
                        <div class="value" id="roiMultiple">0x</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Investment Summary</h3>
                    <div class="breakdown-item">
                        <span>Amount Invested</span>
                        <strong id="investedDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Amount Returned</span>
                        <strong id="returnedDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Additional Costs</span>
                        <strong id="costsDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Investment Cost</span>
                        <strong id="totalCost">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Investment Duration</span>
                        <strong id="durationDisplay">0 years</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Profit Analysis</h3>
                    <div class="breakdown-item">
                        <span>Gross Return</span>
                        <strong id="grossReturn">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Less: Total Costs</span>
                        <strong id="lessCosts">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Profit</strong></span>
                        <strong id="netProfitDisplay" style="font-size: 1.2em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>ROI Percentage</span>
                        <strong id="roiPercentDisplay">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Performance Metrics</h3>
                    <div class="breakdown-item">
                        <span>ROI (Total Return)</span>
                        <strong id="totalRoiPercent">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annualized ROI</span>
                        <strong id="annualizedRoiDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>ROI Multiple</span>
                        <strong id="multipleDisplay">0.00x</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Profit Margin</span>
                        <strong id="profitMargin">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Return Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Return per Year</span>
                        <strong id="returnPerYear">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Return per Month</span>
                        <strong id="returnPerMonth">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Return per Day</span>
                        <strong id="returnPerDay">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>ROI Formula:</strong> ROI = (Net Profit / Total Investment Cost) × 100. A positive ROI means profit, negative means loss. Annualized ROI accounts for time, making it easier to compare investments of different durations.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('roiForm');
        const currencySelect = document.getElementById('currency');

        // Update currency labels when currency changes
        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateROI();
        });

        function updateCurrencyLabels() {
            const currency = currencySelect.value;
            const symbol = currency === 'USD' ? '$' : '₹';
            
            // Update form labels
            document.getElementById('currencyLabel1').textContent = symbol;
            document.getElementById('currencyLabel2').textContent = symbol;
            document.getElementById('currencyLabel3').textContent = symbol;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateROI();
        });

        function calculateROI() {
            const invested = parseFloat(document.getElementById('investedAmount').value) || 0;
            const returned = parseFloat(document.getElementById('returnedAmount').value) || 0;
            const duration = parseFloat(document.getElementById('investmentDuration').value) || 1;
            const additionalCosts = parseFloat(document.getElementById('additionalCosts').value) || 0;
            const currency = currencySelect.value;

            const totalCostAmt = invested + additionalCosts;
            const grossReturnAmt = returned - invested;
            const netProfitAmt = returned - totalCostAmt;

            // ROI Percentage
            const roiPercentAmt = totalCostAmt > 0 ? (netProfitAmt / totalCostAmt) * 100 : 0;

            // Annualized ROI
            let annualizedRoiAmt = 0;
            if (duration > 0 && totalCostAmt > 0) {
                annualizedRoiAmt = (Math.pow((returned / totalCostAmt), (1 / duration)) - 1) * 100;
            }

            // ROI Multiple
            const roiMultipleAmt = totalCostAmt > 0 ? returned / totalCostAmt : 0;

            // Profit Margin
            const profitMarginAmt = returned > 0 ? (netProfitAmt / returned) * 100 : 0;

            // Return breakdown
            const returnPerYearAmt = duration > 0 ? netProfitAmt / duration : 0;
            const returnPerMonthAmt = duration > 0 ? netProfitAmt / (duration * 12) : 0;
            const returnPerDayAmt = duration > 0 ? netProfitAmt / (duration * 365) : 0;

            // Update UI
            document.getElementById('roiPercent').textContent = roiPercentAmt.toFixed(2) + '%';
            
            const roiCard = document.getElementById('roiCard');
            roiCard.className = 'result-card';
            if (roiPercentAmt > 0) {
                roiCard.classList.add('positive');
            } else if (roiPercentAmt < 0) {
                roiCard.classList.add('negative');
            }

            document.getElementById('netProfit').textContent = formatCurrency(netProfitAmt, currency);
            document.getElementById('annualizedROI').textContent = annualizedRoiAmt.toFixed(2) + '%';
            document.getElementById('totalReturn').textContent = formatCurrency(netProfitAmt, currency);
            document.getElementById('roiMultiple').textContent = roiMultipleAmt.toFixed(2) + 'x';

            document.getElementById('investedDisplay').textContent = formatCurrency(invested, currency);
            document.getElementById('returnedDisplay').textContent = formatCurrency(returned, currency);
            document.getElementById('costsDisplay').textContent = formatCurrency(additionalCosts, currency);
            document.getElementById('totalCost').textContent = formatCurrency(totalCostAmt, currency);
            document.getElementById('durationDisplay').textContent = duration.toFixed(1) + ' years';

            document.getElementById('grossReturn').textContent = formatCurrency(grossReturnAmt, currency);
            document.getElementById('lessCosts').textContent = '-' + formatCurrency(additionalCosts, currency);
            document.getElementById('netProfitDisplay').textContent = formatCurrency(netProfitAmt, currency);
            document.getElementById('netProfitDisplay').style.color = netProfitAmt >= 0 ? '#4CAF50' : '#f44336';
            document.getElementById('roiPercentDisplay').textContent = roiPercentAmt.toFixed(2) + '%';

            document.getElementById('totalRoiPercent').textContent = roiPercentAmt.toFixed(2) + '%';
            document.getElementById('annualizedRoiDisplay').textContent = annualizedRoiAmt.toFixed(2) + '%';
            document.getElementById('multipleDisplay').textContent = roiMultipleAmt.toFixed(2) + 'x';
            document.getElementById('profitMargin').textContent = profitMarginAmt.toFixed(2) + '%';

            document.getElementById('returnPerYear').textContent = formatCurrency(returnPerYearAmt, currency);
            document.getElementById('returnPerMonth').textContent = formatCurrency(returnPerMonthAmt, currency);
            document.getElementById('returnPerDay').textContent = formatCurrency(returnPerDayAmt, currency);
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
            calculateROI();
        });
    </script>
</body>
</html>