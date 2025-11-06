<?php
/**
 * Interest Calculator
 * File: interest-calculator.php
 * Description: Calculate simple and compound interest with detailed breakdowns and comparisons
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interest Calculator - Simple & Compound Interest Calculator</title>
    <meta name="description" content="Advanced Interest Calculator. Calculate simple and compound interest with detailed breakdowns, comparisons, and investment growth projections.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>💰 Interest Calculator</h1>
        <p>Calculate simple and compound interest with detailed growth projections</p>
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
            background: linear-gradient(135deg, #FFA726 0%, #FB8C00 100%);
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
            color: #FFA726;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #FB8C00;
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
            color: #FFA726;
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
            border-color: #FFA726;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #888;
            font-size: 0.9em;
        }
        
        .btn {
            background: #FFA726;
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
            background: #FB8C00;
        }
        
        .result-card {
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
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
        
        .result-card .category {
            font-size: 1.3em;
            margin-top: 10px;
            opacity: 0.95;
        }
        
        .compound-interest {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .simple-interest {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }
        
        .interest-difference {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
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
            color: #FFA726;
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
            color: #FFA726;
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
            background: #fff3e0;
            border-left: 4px solid #FFA726;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box strong {
            color: #FB8C00;
        }
        
        .interest-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .interest-option {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .interest-option.active {
            background: #FFA726;
            color: white;
            border-color: #FB8C00;
        }
        
        .frequency-options {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 20px;
        }
        
        .frequency-option {
            background: #f8f9fa;
            padding: 12px 8px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
            font-size: 0.9em;
        }
        
        .frequency-option.active {
            background: #FFA726;
            color: white;
            border-color: #FB8C00;
        }
        
        .growth-chart {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            position: relative;
            height: 200px;
        }
        
        .chart-bars {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            height: 150px;
            margin-top: 10px;
        }
        
        .chart-bar {
            flex: 1;
            margin: 0 5px;
            background: #2196F3;
            border-radius: 4px 4px 0 0;
            position: relative;
            transition: all 0.5s ease;
        }
        
        .chart-bar.compound {
            background: #4CAF50;
        }
        
        .chart-bar.simple {
            background: #FFA726;
        }
        
        .chart-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 0.8em;
            color: #666;
        }
        
        .comparison-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        
        .comparison-table th, .comparison-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .comparison-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #555;
        }
        
        .comparison-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .yearly-breakdown {
            max-height: 300px;
            overflow-y: auto;
            margin: 20px 0;
        }
        
        .yearly-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .yearly-table th, .yearly-table td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
            font-size: 0.9em;
        }
        
        .yearly-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #555;
            position: sticky;
            top: 0;
        }
        
        .scenario-comparison {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }
        
        .scenario-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
        }
        
        .scenario-card h4 {
            color: #FFA726;
            margin-bottom: 15px;
            font-size: 1.1em;
        }
        
        .interest-impact {
            background: #e8f5e9;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .impact-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #c8e6c9;
        }
        
        .impact-item:last-child {
            border-bottom: none;
        }

        /* Currency Selector Styles */
        .currency-selector-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border: 2px solid #e0e0e0;
        }
        
        .currency-selector-container h3 {
            color: #FFA726;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .currency-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }
        
        .currency-option {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .currency-option:hover {
            border-color: #FFA726;
            transform: translateY(-2px);
        }
        
        .currency-option.active {
            background: #FFA726;
            color: white;
            border-color: #FB8C00;
        }
        
        .currency-option .symbol {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .currency-option .name {
            font-size: 0.9em;
            opacity: 0.8;
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
            
            .interest-options {
                grid-template-columns: 1fr;
            }
            
            .frequency-options {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .scenario-comparison {
                grid-template-columns: 1fr;
            }
            
            .currency-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Financial Calculators</a>
        </div>

        <!-- Currency Selector -->
        <div class="currency-selector-container">
            <h3>Select Currency</h3>
            <div class="currency-grid">
                <div class="currency-option active" data-currency="USD">
                    <div class="symbol">$</div>
                    <div class="name">US Dollar</div>
                </div>
                <div class="currency-option" data-currency="EUR">
                    <div class="symbol">€</div>
                    <div class="name">Euro</div>
                </div>
                <div class="currency-option" data-currency="GBP">
                    <div class="symbol">£</div>
                    <div class="name">British Pound</div>
                </div>
                <div class="currency-option" data-currency="JPY">
                    <div class="symbol">¥</div>
                    <div class="name">Japanese Yen</div>
                </div>
                <div class="currency-option" data-currency="INR">
                    <div class="symbol">₹</div>
                    <div class="name">Indian Rupee</div>
                </div>
                <div class="currency-option" data-currency="CAD">
                    <div class="symbol">C$</div>
                    <div class="name">Canadian Dollar</div>
                </div>
                <div class="currency-option" data-currency="AUD">
                    <div class="symbol">A$</div>
                    <div class="name">Australian Dollar</div>
                </div>
                <div class="currency-option" data-currency="CHF">
                    <div class="symbol">CHF</div>
                    <div class="name">Swiss Franc</div>
                </div>
                <div class="currency-option" data-currency="CNY">
                    <div class="symbol">¥</div>
                    <div class="name">Chinese Yuan</div>
                </div>
                <div class="currency-option" data-currency="MXN">
                    <div class="symbol">Mex$</div>
                    <div class="name">Mexican Peso</div>
                </div>
            </div>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Interest Calculation</h2>
                <form id="interestForm">
                    <div class="form-group">
                        <label for="principalAmount">Principal Amount</label>
                        <input type="number" id="principalAmount" value="10000" min="1" max="10000000" step="100" required>
                        <small>Initial investment or loan amount</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Annual Interest Rate (%)</label>
                        <input type="number" id="interestRate" value="5.0" min="0.01" max="100" step="0.1" required>
                        <small>Annual percentage rate (APR)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="timePeriod">Time Period (Years)</label>
                        <input type="number" id="timePeriod" value="10" min="1" max="100" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Interest Type</label>
                        <div class="interest-options">
                            <div class="interest-option active" data-type="compound">
                                <strong>Compound Interest</strong>
                                <div>Interest on interest</div>
                            </div>
                            <div class="interest-option" data-type="simple">
                                <strong>Simple Interest</strong>
                                <div>Interest only on principal</div>
                            </div>
                        </div>
                        <input type="hidden" id="interestType" value="compound">
                    </div>
                    
                    <div class="form-group" id="compoundFrequencyGroup">
                        <label>Compounding Frequency</label>
                        <div class="frequency-options">
                            <div class="frequency-option active" data-frequency="annually">Annual</div>
                            <div class="frequency-option" data-frequency="semiannually">Semi-Annual</div>
                            <div class="frequency-option" data-frequency="quarterly">Quarterly</div>
                            <div class="frequency-option" data-frequency="monthly">Monthly</div>
                            <div class="frequency-option" data-frequency="daily">Daily</div>
                            <div class="frequency-option" data-frequency="continuously">Continuous</div>
                        </div>
                        <input type="hidden" id="compoundingFrequency" value="annually">
                    </div>
                    
                    <div class="form-group">
                        <label for="regularContributions">Regular Contributions</label>
                        <input type="number" id="regularContributions" value="0" min="0" max="100000" step="10">
                        <small>Additional monthly contributions (optional)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="contributionFrequency">Contribution Frequency</label>
                        <select id="contributionFrequency">
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="annually">Annually</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Interest</button>
                </form>
                
                <div class="breakdown" style="margin-top: 30px;">
                    <h3>Interest Formulas</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Simple Interest:</strong> A = P(1 + rt)</p>
                        <p><strong>Compound Interest:</strong> A = P(1 + r/n)^(nt)</p>
                        <p><strong>Continuous Compound:</strong> A = Pe^(rt)</p>
                        <p>Where: A = Final amount, P = Principal, r = Rate, t = Time, n = Compounding periods per year</p>
                    </div>
                </div>
            </div>

            <div class="results-section">
                <h2>Interest Results</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Future Value</h3>
                    <div class="amount" id="futureValue">$16,289</div>
                    <div class="category" id="interestTypeDisplay">Compound Interest</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Interest</h4>
                        <div class="value" id="totalInterest">$6,289</div>
                    </div>
                    <div class="metric-card">
                        <h4>Effective Annual Rate</h4>
                        <div class="value" id="effectiveRate">5.00%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Contributions</h4>
                        <div class="value" id="totalContributions">$10,000</div>
                    </div>
                    <div class="metric-card">
                        <h4>Interest vs Principal</h4>
                        <div class="value" id="interestRatio">62.9%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Calculation Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Principal Amount</span>
                        <strong id="breakdownPrincipal">$10,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest Earned</span>
                        <strong id="breakdownInterest">$6,289</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Regular Contributions</span>
                        <strong id="breakdownContributions">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Compounding Periods</span>
                        <strong id="breakdownPeriods">10</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #FFA726; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Future Value</strong></span>
                        <strong id="breakdownTotal" style="font-size: 1.1em;">$16,289</strong>
                    </div>
                </div>

                <div class="growth-chart">
                    <h3 style="color: #1976D2; margin-bottom: 10px;">Growth Comparison</h3>
                    <div class="chart-bars" id="growthBars">
                        <!-- Chart bars will be generated by JavaScript -->
                    </div>
                    <div class="chart-labels">
                        <span>Simple Interest</span>
                        <span>Compound Interest</span>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Yearly Growth Breakdown</h3>
                    <div class="yearly-breakdown">
                        <table class="yearly-table">
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Principal</th>
                                    <th>Interest</th>
                                    <th>Total</th>
                                    <th>Growth</th>
                                </tr>
                            </thead>
                            <tbody id="yearlyTable">
                                <!-- Yearly data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="scenario-comparison">
                    <div class="scenario-card">
                        <h4>📈 Compound Interest</h4>
                        <div class="breakdown-item">
                            <span>Future Value</span>
                            <strong id="compoundValue">$16,289</strong>
                        </div>
                        <div class="breakdown-item">
                            <span>Total Interest</span>
                            <strong id="compoundInterest">$6,289</strong>
                        </div>
                        <div class="breakdown-item">
                            <span>Effective Rate</span>
                            <strong id="compoundEffective">5.00%</strong>
                        </div>
                    </div>
                    
                    <div class="scenario-card">
                        <h4>📊 Simple Interest</h4>
                        <div class="breakdown-item">
                            <span>Future Value</span>
                            <strong id="simpleValue">$15,000</strong>
                        </div>
                        <div class="breakdown-item">
                            <span>Total Interest</span>
                            <strong id="simpleInterest">$5,000</strong>
                        </div>
                        <div class="breakdown-item">
                            <span>Effective Rate</span>
                            <strong id="simpleEffective">5.00%</strong>
                        </div>
                    </div>
                </div>

                <div class="interest-impact">
                    <h3 style="color: #2E7D32; margin-bottom: 15px;">Compound Interest Impact</h3>
                    <div class="impact-item">
                        <span>Difference (Compound - Simple)</span>
                        <strong id="interestDifference">+$1,289</strong>
                    </div>
                    <div class="impact-item">
                        <span>Additional Return</span>
                        <strong id="additionalReturn">+25.8%</strong>
                    </div>
                    <div class="impact-item">
                        <span>Equivalent Extra Years</span>
                        <strong id="equivalentYears">2.6 years</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Frequency Impact Comparison</h3>
                    <table class="comparison-table">
                        <thead>
                            <tr>
                                <th>Compounding</th>
                                <th>Future Value</th>
                                <th>Total Interest</th>
                                <th>Effective Rate</th>
                            </tr>
                        </thead>
                        <tbody id="frequencyTable">
                            <!-- Frequency comparison data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Investment Insights</h3>
                    <div id="investmentInsights" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="insightsText" style="margin: 0;">Compound interest generates significantly higher returns over time compared to simple interest. The more frequent the compounding, the greater the final amount. Starting early and contributing regularly dramatically increases long-term growth due to the power of compounding.</p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Interest Calculation Tips:</strong> Compound interest works best over long periods. Higher compounding frequency increases effective yield. Start investing early to maximize compounding benefits. Regular contributions significantly boost final amounts. Compare effective annual rates (EAR) not just nominal rates. Consider tax implications on interest earnings. Inflation reduces real returns. Rule of 72: Divide 72 by interest rate to estimate doubling time. Compound interest benefits savers but hurts borrowers. Diversify investments to manage risk while earning interest. Review and reinvest interest earnings regularly. Consider automated contributions to maintain consistency.
                </div>
            </div>
        </div>
    </div>

    <script>
        // Currency configuration
        const currencyConfig = {
            'USD': { symbol: '$', name: 'US Dollar', locale: 'en-US' },
            'EUR': { symbol: '€', name: 'Euro', locale: 'de-DE' },
            'GBP': { symbol: '£', name: 'British Pound', locale: 'en-GB' },
            'JPY': { symbol: '¥', name: 'Japanese Yen', locale: 'ja-JP' },
            'INR': { symbol: '₹', name: 'Indian Rupee', locale: 'en-IN' },
            'CAD': { symbol: 'C$', name: 'Canadian Dollar', locale: 'en-CA' },
            'AUD': { symbol: 'A$', name: 'Australian Dollar', locale: 'en-AU' },
            'CHF': { symbol: 'CHF', name: 'Swiss Franc', locale: 'de-CH' },
            'CNY': { symbol: '¥', name: 'Chinese Yuan', locale: 'zh-CN' },
            'MXN': { symbol: 'Mex$', name: 'Mexican Peso', locale: 'es-MX' }
        };
        
        // Current currency
        let currentCurrency = 'USD';
        
        const form = document.getElementById('interestForm');
        const interestOptions = document.querySelectorAll('.interest-option');
        const frequencyOptions = document.querySelectorAll('.frequency-option');
        
        // Currency selection
        document.querySelectorAll('.currency-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.currency-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                
                currentCurrency = this.dataset.currency;
                calculateInterest();
            });
        });
        
        // Interest type selection
        interestOptions.forEach(option => {
            option.addEventListener('click', function() {
                interestOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                const interestType = this.dataset.type;
                document.getElementById('interestType').value = interestType;
                
                // Toggle compounding frequency for simple interest
                if (interestType === 'simple') {
                    document.getElementById('compoundFrequencyGroup').style.display = 'none';
                } else {
                    document.getElementById('compoundFrequencyGroup').style.display = 'block';
                }
                
                calculateInterest();
            });
        });
        
        // Frequency option selection
        frequencyOptions.forEach(option => {
            option.addEventListener('click', function() {
                frequencyOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('compoundingFrequency').value = this.dataset.frequency;
                calculateInterest();
            });
        });
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateInterest();
        });

        function calculateInterest() {
            const principal = parseFloat(document.getElementById('principalAmount').value) || 0;
            const annualRate = parseFloat(document.getElementById('interestRate').value) || 0;
            const years = parseFloat(document.getElementById('timePeriod').value) || 0;
            const interestType = document.getElementById('interestType').value;
            const compounding = document.getElementById('compoundingFrequency').value;
            const monthlyContribution = parseFloat(document.getElementById('regularContributions').value) || 0;
            const contributionFreq = document.getElementById('contributionFrequency').value;
            
            const decimalRate = annualRate / 100;
            
            // Calculate compounding periods per year
            let periodsPerYear = 1;
            switch(compounding) {
                case 'annually': periodsPerYear = 1; break;
                case 'semiannually': periodsPerYear = 2; break;
                case 'quarterly': periodsPerYear = 4; break;
                case 'monthly': periodsPerYear = 12; break;
                case 'daily': periodsPerYear = 365; break;
                case 'continuously': periodsPerYear = 0; break; // Special case
            }
            
            let futureValue, totalInterest, effectiveRate;
            let simpleFutureValue, simpleTotalInterest;
            
            if (interestType === 'simple') {
                // Simple interest calculation
                futureValue = principal * (1 + decimalRate * years);
                totalInterest = futureValue - principal;
                effectiveRate = annualRate;
                
                // For comparison, also calculate compound interest
                simpleFutureValue = futureValue;
                simpleTotalInterest = totalInterest;
                futureValue = calculateCompoundInterest(principal, decimalRate, years, 1); // Annual compounding for comparison
                totalInterest = futureValue - principal;
            } else {
                // Compound interest calculation
                if (compounding === 'continuously') {
                    // Continuous compounding
                    futureValue = principal * Math.exp(decimalRate * years);
                    effectiveRate = (Math.exp(decimalRate) - 1) * 100;
                } else {
                    // Discrete compounding
                    futureValue = calculateCompoundInterest(principal, decimalRate, years, periodsPerYear);
                    effectiveRate = (Math.pow(1 + decimalRate/periodsPerYear, periodsPerYear) - 1) * 100;
                }
                totalInterest = futureValue - principal;
                
                // Calculate simple interest for comparison
                simpleFutureValue = principal * (1 + decimalRate * years);
                simpleTotalInterest = simpleFutureValue - principal;
            }
            
            // Add regular contributions
            let totalContributions = 0;
            if (monthlyContribution > 0) {
                let contributionFutureValue = 0;
                const periods = years * 12; // Assume monthly for simplicity
                const monthlyRate = decimalRate / 12;
                
                contributionFutureValue = monthlyContribution * ((Math.pow(1 + monthlyRate, periods) - 1) / monthlyRate);
                totalContributions = monthlyContribution * periods;
                
                futureValue += contributionFutureValue;
                totalInterest += contributionFutureValue - totalContributions;
                simpleFutureValue += totalContributions; // Simple interest on contributions
                simpleTotalInterest += totalContributions * decimalRate * years;
            }
            
            // Calculate ratios and percentages
            const interestRatio = (totalInterest / (principal + totalContributions)) * 100;
            const interestDifference = futureValue - simpleFutureValue;
            const additionalReturn = (interestDifference / simpleTotalInterest) * 100;
            const equivalentYears = (interestDifference / (simpleFutureValue * decimalRate));
            
            // Update UI
            const card = document.getElementById('resultCard');
            if (interestType === 'compound') {
                card.className = 'result-card compound-interest';
                document.getElementById('interestTypeDisplay').textContent = 'Compound Interest';
            } else {
                card.className = 'result-card simple-interest';
                document.getElementById('interestTypeDisplay').textContent = 'Simple Interest';
            }
            
            document.getElementById('futureValue').textContent = formatCurrency(futureValue);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest);
            document.getElementById('effectiveRate').textContent = effectiveRate.toFixed(2) + '%';
            document.getElementById('totalContributions').textContent = formatCurrency(totalContributions);
            document.getElementById('interestRatio').textContent = interestRatio.toFixed(1) + '%';
            
            document.getElementById('breakdownPrincipal').textContent = formatCurrency(principal);
            document.getElementById('breakdownInterest').textContent = formatCurrency(totalInterest);
            document.getElementById('breakdownContributions').textContent = formatCurrency(totalContributions);
            document.getElementById('breakdownPeriods').textContent = years;
            document.getElementById('breakdownTotal').textContent = formatCurrency(futureValue);
            
            // Update comparison cards
            document.getElementById('compoundValue').textContent = formatCurrency(futureValue);
            document.getElementById('compoundInterest').textContent = formatCurrency(totalInterest);
            document.getElementById('compoundEffective').textContent = effectiveRate.toFixed(2) + '%';
            
            document.getElementById('simpleValue').textContent = formatCurrency(simpleFutureValue);
            document.getElementById('simpleInterest').textContent = formatCurrency(simpleTotalInterest);
            document.getElementById('simpleEffective').textContent = annualRate.toFixed(2) + '%';
            
            // Update impact section
            document.getElementById('interestDifference').textContent = formatCurrency(interestDifference);
            document.getElementById('additionalReturn').textContent = '+' + additionalReturn.toFixed(1) + '%';
            document.getElementById('equivalentYears').textContent = equivalentYears.toFixed(1) + ' years';
            
            // Generate growth chart
            generateGrowthChart(principal, decimalRate, years, periodsPerYear, monthlyContribution);
            
            // Generate yearly breakdown
            generateYearlyBreakdown(principal, decimalRate, years, periodsPerYear, monthlyContribution);
            
            // Generate frequency comparison
            generateFrequencyComparison(principal, decimalRate, years);
            
            // Update insights
            document.getElementById('insightsText').textContent = 
                `Compound interest generates ${additionalReturn.toFixed(1)}% more return than simple interest over ${years} years. ` +
                `The power of compounding becomes more significant with longer time periods and higher compounding frequencies.`;
        }
        
        function calculateCompoundInterest(principal, rate, years, periodsPerYear) {
            return principal * Math.pow(1 + rate/periodsPerYear, periodsPerYear * years);
        }
        
        function generateGrowthChart(principal, rate, years, periodsPerYear, monthlyContribution) {
            const chart = document.getElementById('growthBars');
            chart.innerHTML = '';
            
            // Calculate values for each year
            const simpleValues = [];
            const compoundValues = [];
            
            for (let year = 1; year <= years; year++) {
                // Simple interest
                let simpleValue = principal * (1 + rate * year);
                simpleValue += monthlyContribution * 12 * year; // Add contributions without interest
                
                // Compound interest
                let compoundValue = calculateCompoundInterest(principal, rate, year, periodsPerYear);
                if (monthlyContribution > 0) {
                    const periods = year * 12;
                    const monthlyRate = rate / 12;
                    compoundValue += monthlyContribution * ((Math.pow(1 + monthlyRate, periods) - 1) / monthlyRate);
                }
                
                simpleValues.push(simpleValue);
                compoundValues.push(compoundValue);
            }
            
            // Find maximum value for scaling
            const maxValue = Math.max(...compoundValues, ...simpleValues);
            
            // Create bars for final year
            const simpleHeight = (simpleValues[years-1] / maxValue) * 100;
            const compoundHeight = (compoundValues[years-1] / maxValue) * 100;
            
            const simpleBar = document.createElement('div');
            simpleBar.className = 'chart-bar simple';
            simpleBar.style.height = `${simpleHeight}%`;
            simpleBar.title = `Simple: ${formatCurrency(simpleValues[years-1])}`;
            
            const compoundBar = document.createElement('div');
            compoundBar.className = 'chart-bar compound';
            compoundBar.style.height = `${compoundHeight}%`;
            compoundBar.title = `Compound: ${formatCurrency(compoundValues[years-1])}`;
            
            chart.appendChild(simpleBar);
            chart.appendChild(compoundBar);
        }
        
        function generateYearlyBreakdown(principal, rate, years, periodsPerYear, monthlyContribution) {
            const table = document.getElementById('yearlyTable');
            table.innerHTML = '';
            
            let currentBalance = principal;
            
            for (let year = 1; year <= years; year++) {
                // Calculate interest for the year
                const yearlyInterest = calculateCompoundInterest(currentBalance, rate, 1, periodsPerYear) - currentBalance;
                
                // Add monthly contributions
                const yearlyContributions = monthlyContribution * 12;
                const contributionInterest = monthlyContribution > 0 ? 
                    calculateFutureValueOfAnnuity(monthlyContribution, rate/12, 12) - yearlyContributions : 0;
                
                currentBalance += yearlyInterest + yearlyContributions + contributionInterest;
                const totalInterest = yearlyInterest + contributionInterest;
                const growthRate = (totalInterest / (currentBalance - yearlyContributions - totalInterest)) * 100;
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${year}</td>
                    <td>${formatCurrency(principal + (yearlyContributions * year))}</td>
                    <td>${formatCurrency(totalInterest)}</td>
                    <td>${formatCurrency(currentBalance)}</td>
                    <td>${growthRate.toFixed(1)}%</td>
                `;
                table.appendChild(row);
            }
        }
        
        function generateFrequencyComparison(principal, rate, years) {
            const table = document.getElementById('frequencyTable');
            table.innerHTML = '';
            
            const frequencies = [
                { name: 'Annually', periods: 1 },
                { name: 'Semi-Annual', periods: 2 },
                { name: 'Quarterly', periods: 4 },
                { name: 'Monthly', periods: 12 },
                { name: 'Daily', periods: 365 },
                { name: 'Continuous', periods: 0 }
            ];
            
            frequencies.forEach(freq => {
                let futureValue, effectiveRate;
                
                if (freq.periods === 0) {
                    // Continuous compounding
                    futureValue = principal * Math.exp(rate * years);
                    effectiveRate = (Math.exp(rate) - 1) * 100;
                } else {
                    futureValue = calculateCompoundInterest(principal, rate, years, freq.periods);
                    effectiveRate = (Math.pow(1 + rate/freq.periods, freq.periods) - 1) * 100;
                }
                
                const totalInterest = futureValue - principal;
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${freq.name}</td>
                    <td>${formatCurrency(futureValue)}</td>
                    <td>${formatCurrency(totalInterest)}</td>
                    <td>${effectiveRate.toFixed(3)}%</td>
                `;
                table.appendChild(row);
            });
        }
        
        function calculateFutureValueOfAnnuity(payment, rate, periods) {
            return payment * ((Math.pow(1 + rate, periods) - 1) / rate);
        }
        
        function formatCurrency(amount) {
            const currency = currencyConfig[currentCurrency];
            if (!currency) return '$' + amount.toLocaleString();
            
            // For currencies like JPY that typically don't use decimals
            const options = {
                style: 'currency',
                currency: currentCurrency,
                minimumFractionDigits: currentCurrency === 'JPY' ? 0 : 0,
                maximumFractionDigits: currentCurrency === 'JPY' ? 0 : 0
            };
            
            try {
                return amount.toLocaleString(currency.locale, options);
            } catch (e) {
                // Fallback if locale formatting fails
                return currency.symbol + amount.toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            }
        }

        window.addEventListener('load', function() {
            calculateInterest();
        });
    </script>
</body>
</html>