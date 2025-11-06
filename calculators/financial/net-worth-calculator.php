<?php
/**
 * Net Worth Calculator
 * File: net-worth-calculator.php
 * Description: Calculate personal net worth (assets - liabilities) (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Net Worth Calculator - Calculate Your Financial Position (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free net worth calculator. Calculate your personal net worth by tracking assets and liabilities. Monitor financial health. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128179; Net Worth Calculator</h1>
        <p>Calculate your personal net worth</p>
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
                <h2>Assets & Liabilities</h2>
                <form id="netWorthForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD (&#36;)</option>
                            <option value="INR">INR (&#8377;)</option>
                            <option value="EUR">EUR (&#8364;)</option>
                            <option value="GBP">GBP (&#163;)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #4CAF50; margin: 25px 0 15px;">Assets</h3>
                    
                    <div class="form-group">
                        <label for="cashSavings">Cash & Savings (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="cashSavings" value="25000" min="0" step="1000">
                    </div>
                    
                    <div class="form-group">
                        <label for="investments">Investments (Stocks, Bonds, MF) (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="investments" value="50000" min="0" step="1000">
                    </div>
                    
                    <div class="form-group">
                        <label for="retirement">Retirement Accounts (401k, IRA) (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="retirement" value="100000" min="0" step="1000">
                    </div>
                    
                    <div class="form-group">
                        <label for="realEstate">Real Estate Value (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="realEstate" value="300000" min="0" step="10000">
                    </div>
                    
                    <div class="form-group">
                        <label for="vehicles">Vehicles (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="vehicles" value="20000" min="0" step="1000">
                    </div>
                    
                    <div class="form-group">
                        <label for="otherAssets">Other Assets (<span id="currencyLabel6">$</span>)</label>
                        <input type="number" id="otherAssets" value="10000" min="0" step="1000">
                        <small>Jewelry, art, business value, etc.</small>
                    </div>
                    
                    <h3 style="color: #f44336; margin: 25px 0 15px;">Liabilities</h3>
                    
                    <div class="form-group">
                        <label for="mortgage">Mortgage Balance (<span id="currencyLabel7">$</span>)</label>
                        <input type="number" id="mortgage" value="200000" min="0" step="10000">
                    </div>
                    
                    <div class="form-group">
                        <label for="autoLoans">Auto Loans (<span id="currencyLabel8">$</span>)</label>
                        <input type="number" id="autoLoans" value="15000" min="0" step="1000">
                    </div>
                    
                    <div class="form-group">
                        <label for="studentLoans">Student Loans (<span id="currencyLabel9">$</span>)</label>
                        <input type="number" id="studentLoans" value="30000" min="0" step="1000">
                    </div>
                    
                    <div class="form-group">
                        <label for="creditCards">Credit Card Debt (<span id="currencyLabel10">$</span>)</label>
                        <input type="number" id="creditCards" value="5000" min="0" step="500">
                    </div>
                    
                    <div class="form-group">
                        <label for="personalLoans">Personal Loans (<span id="currencyLabel11">$</span>)</label>
                        <input type="number" id="personalLoans" value="0" min="0" step="1000">
                    </div>
                    
                    <div class="form-group">
                        <label for="otherDebts">Other Debts (<span id="currencyLabel12">$</span>)</label>
                        <input type="number" id="otherDebts" value="0" min="0" step="1000">
                        <small>Medical bills, taxes owed, etc.</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Net Worth</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Net Worth Summary</h2>
                
                <div class="result-card" id="netWorthCard">
                    <h3>Your Net Worth</h3>
                    <div class="amount" id="netWorth">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Assets</h4>
                        <div class="value" id="totalAssets" style="color: #4CAF50;">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Liabilities</h4>
                        <div class="value" id="totalLiabilities" style="color: #f44336;">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Debt-to-Asset Ratio</h4>
                        <div class="value" id="debtRatio">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Financial Health</h4>
                        <div class="value" id="healthStatus">Excellent</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Assets Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Cash & Savings</span>
                        <strong id="cashDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Investments</span>
                        <strong id="investmentsDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Retirement Accounts</span>
                        <strong id="retirementDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Real Estate</span>
                        <strong id="realEstateDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Vehicles</span>
                        <strong id="vehiclesDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Assets</span>
                        <strong id="otherAssetsDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Assets</strong></span>
                        <strong id="totalAssetsSum" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Liabilities Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Mortgage</span>
                        <strong id="mortgageDisplay" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Auto Loans</span>
                        <strong id="autoLoansDisplay" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Student Loans</span>
                        <strong id="studentLoansDisplay" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Credit Card Debt</span>
                        <strong id="creditCardsDisplay" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Personal Loans</span>
                        <strong id="personalLoansDisplay" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Debts</span>
                        <strong id="otherDebtsDisplay" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #f44336; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Liabilities</strong></span>
                        <strong id="totalLiabilitiesSum" style="color: #f44336; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Net Worth Calculation</h3>
                    <div class="breakdown-item">
                        <span>Total Assets</span>
                        <strong id="assetsCalc" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Liabilities</span>
                        <strong id="liabilitiesCalc" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Net Worth</strong></span>
                        <strong id="netWorthCalc" style="font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Asset Composition</h3>
                    <div class="breakdown-item">
                        <span>Liquid Assets (Cash + Investments)</span>
                        <strong id="liquidAssets" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>% of Total Assets</span>
                        <strong id="liquidPercent">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Retirement Assets</span>
                        <strong id="retirementAssets" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>% of Total Assets</span>
                        <strong id="retirementPercent">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Real Estate & Property</span>
                        <strong id="propertyAssets" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>% of Total Assets</span>
                        <strong id="propertyPercent">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Financial Ratios</h3>
                    <div class="breakdown-item">
                        <span>Debt-to-Asset Ratio</span>
                        <strong id="debtAssetRatio">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Asset-to-Liability Ratio</span>
                        <strong id="assetLiabilityRatio">0:1</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Liquidity Ratio</span>
                        <strong id="liquidityRatio">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Solvency Status</span>
                        <strong id="solvencyStatus" style="color: #4CAF50;">Solvent</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Financial Health Assessment</h3>
                    <div class="breakdown-item">
                        <span>Overall Rating</span>
                        <strong id="overallRating" style="color: #4CAF50;">Excellent</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Net Worth Status</span>
                        <strong id="netWorthStatus">Positive</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Debt Level</span>
                        <strong id="debtLevel">Low</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Asset Diversification</span>
                        <strong id="diversification">Good</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Net Worth Tips:</strong> Track net worth regularly (monthly/quarterly). Positive net worth = assets > liabilities. Increase assets, reduce liabilities. Build emergency fund (3-6 months). Pay off high-interest debt first. Invest consistently. Diversify assets. Max retirement contributions. Real estate builds wealth slowly. Don't count depreciating assets at full value. Net worth ≠ income. Focus on trends, not single number. Compare to age benchmarks. Review annually. Set net worth goals. Automate savings and investments.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('netWorthForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateNetWorth();
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
            for (let i = 1; i <= 12; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateNetWorth();
        });

        function calculateNetWorth() {
            // Assets
            const cashSavings = parseFloat(document.getElementById('cashSavings').value) || 0;
            const investments = parseFloat(document.getElementById('investments').value) || 0;
            const retirement = parseFloat(document.getElementById('retirement').value) || 0;
            const realEstate = parseFloat(document.getElementById('realEstate').value) || 0;
            const vehicles = parseFloat(document.getElementById('vehicles').value) || 0;
            const otherAssets = parseFloat(document.getElementById('otherAssets').value) || 0;

            // Liabilities
            const mortgage = parseFloat(document.getElementById('mortgage').value) || 0;
            const autoLoans = parseFloat(document.getElementById('autoLoans').value) || 0;
            const studentLoans = parseFloat(document.getElementById('studentLoans').value) || 0;
            const creditCards = parseFloat(document.getElementById('creditCards').value) || 0;
            const personalLoans = parseFloat(document.getElementById('personalLoans').value) || 0;
            const otherDebts = parseFloat(document.getElementById('otherDebts').value) || 0;

            const currency = currencySelect.value;

            // Calculations
            const totalAssets = cashSavings + investments + retirement + realEstate + vehicles + otherAssets;
            const totalLiabilities = mortgage + autoLoans + studentLoans + creditCards + personalLoans + otherDebts;
            const netWorth = totalAssets - totalLiabilities;

            const liquidAssets = cashSavings + investments;
            const propertyAssets = realEstate + vehicles;

            const liquidPercent = totalAssets > 0 ? (liquidAssets / totalAssets) * 100 : 0;
            const retirementPercent = totalAssets > 0 ? (retirement / totalAssets) * 100 : 0;
            const propertyPercent = totalAssets > 0 ? (propertyAssets / totalAssets) * 100 : 0;

            const debtRatio = totalAssets > 0 ? (totalLiabilities / totalAssets) * 100 : 0;
            const assetLiabilityRatio = totalLiabilities > 0 ? (totalAssets / totalLiabilities).toFixed(2) : totalAssets;
            const liquidityRatio = totalLiabilities > 0 ? (liquidAssets / totalLiabilities) * 100 : 100;

            // Health assessments
            let healthStatus = 'Excellent';
            let overallRating = 'Excellent';
            let netWorthStatus = netWorth >= 0 ? 'Positive' : 'Negative';
            let debtLevel = 'Low';
            let solvencyStatus = 'Solvent';
            let diversification = 'Good';

            if (debtRatio > 50) {
                healthStatus = 'Poor';
                overallRating = 'Needs Improvement';
                debtLevel = 'High';
            } else if (debtRatio > 30) {
                healthStatus = 'Fair';
                overallRating = 'Fair';
                debtLevel = 'Moderate';
            } else if (debtRatio > 20) {
                healthStatus = 'Good';
                overallRating = 'Good';
            }

            if (netWorth < 0) {
                solvencyStatus = 'Insolvent';
                overallRating = 'Critical';
            }

            if (liquidPercent < 10 || retirementPercent < 10 || propertyPercent > 80) {
                diversification = 'Needs Improvement';
            }

            // Analysis
            let analysis = `Your net worth is ${formatCurrency(netWorth, currency)}, with total assets of ${formatCurrency(totalAssets, currency)} and liabilities of ${formatCurrency(totalLiabilities, currency)}. `;
            
            if (netWorth > 0) {
                analysis += `You have a positive net worth, which means your assets exceed your liabilities. `;
            } else {
                analysis += `Your net worth is negative, meaning your liabilities exceed your assets. Focus on paying down debt and building assets. `;
            }

            if (debtRatio < 20) {
                analysis += `Your debt-to-asset ratio of ${debtRatio.toFixed(1)}% is excellent, indicating strong financial health. `;
            } else if (debtRatio < 30) {
                analysis += `Your debt-to-asset ratio of ${debtRatio.toFixed(1)}% is good, but there's room for improvement. `;
            } else {
                analysis += `Your debt-to-asset ratio of ${debtRatio.toFixed(1)}% is high. Consider focusing on debt reduction. `;
            }

            analysis += `Your liquid assets (${formatCurrency(liquidAssets, currency)}) represent ${liquidPercent.toFixed(1)}% of your total assets.`;

            // Update UI
            document.getElementById('netWorth').textContent = formatCurrency(netWorth, currency);
            document.getElementById('totalAssets').textContent = formatCurrency(totalAssets, currency);
            document.getElementById('totalLiabilities').textContent = formatCurrency(totalLiabilities, currency);
            document.getElementById('debtRatio').textContent = debtRatio.toFixed(1) + '%';
            document.getElementById('healthStatus').textContent = healthStatus;

            // Update card color
            const card = document.getElementById('netWorthCard');
            card.className = 'result-card ' + (netWorth >= 0 ? 'success' : 'warning');

            document.getElementById('cashDisplay').textContent = formatCurrency(cashSavings, currency);
            document.getElementById('investmentsDisplay').textContent = formatCurrency(investments, currency);
            document.getElementById('retirementDisplay').textContent = formatCurrency(retirement, currency);
            document.getElementById('realEstateDisplay').textContent = formatCurrency(realEstate, currency);
            document.getElementById('vehiclesDisplay').textContent = formatCurrency(vehicles, currency);
            document.getElementById('otherAssetsDisplay').textContent = formatCurrency(otherAssets, currency);
            document.getElementById('totalAssetsSum').textContent = formatCurrency(totalAssets, currency);

            document.getElementById('mortgageDisplay').textContent = formatCurrency(mortgage, currency);
            document.getElementById('autoLoansDisplay').textContent = formatCurrency(autoLoans, currency);
            document.getElementById('studentLoansDisplay').textContent = formatCurrency(studentLoans, currency);
            document.getElementById('creditCardsDisplay').textContent = formatCurrency(creditCards, currency);
            document.getElementById('personalLoansDisplay').textContent = formatCurrency(personalLoans, currency);
            document.getElementById('otherDebtsDisplay').textContent = formatCurrency(otherDebts, currency);
            document.getElementById('totalLiabilitiesSum').textContent = formatCurrency(totalLiabilities, currency);

            document.getElementById('assetsCalc').textContent = formatCurrency(totalAssets, currency);
            document.getElementById('liabilitiesCalc').textContent = formatCurrency(totalLiabilities, currency);
            document.getElementById('netWorthCalc').textContent = formatCurrency(netWorth, currency);
            document.getElementById('netWorthCalc').style.color = netWorth >= 0 ? '#4CAF50' : '#f44336';

            document.getElementById('liquidAssets').textContent = formatCurrency(liquidAssets, currency);
            document.getElementById('liquidPercent').textContent = liquidPercent.toFixed(1) + '%';
            document.getElementById('retirementAssets').textContent = formatCurrency(retirement, currency);
            document.getElementById('retirementPercent').textContent = retirementPercent.toFixed(1) + '%';
            document.getElementById('propertyAssets').textContent = formatCurrency(propertyAssets, currency);
            document.getElementById('propertyPercent').textContent = propertyPercent.toFixed(1) + '%';

            document.getElementById('debtAssetRatio').textContent = debtRatio.toFixed(1) + '%';
            document.getElementById('assetLiabilityRatio').textContent = assetLiabilityRatio + ':1';
            document.getElementById('liquidityRatio').textContent = liquidityRatio.toFixed(1) + '%';
            document.getElementById('solvencyStatus').textContent = solvencyStatus;
            document.getElementById('solvencyStatus').style.color = solvencyStatus === 'Solvent' ? '#4CAF50' : '#f44336';

            document.getElementById('overallRating').textContent = overallRating;
            document.getElementById('netWorthStatus').textContent = netWorthStatus;
            document.getElementById('netWorthStatus').style.color = netWorth >= 0 ? '#4CAF50' : '#f44336';
            document.getElementById('debtLevel').textContent = debtLevel;
            document.getElementById('diversification').textContent = diversification;

            document.getElementById('analysisText').textContent = analysis;
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
            calculateNetWorth();
        });
    </script>
</body>
</html>