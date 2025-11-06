<?php
/**
 * Inflation Calculator
 * File: inflation-calculator.php
 * Description: Calculate purchasing power changes over time and future costs adjusted for inflation
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inflation Calculator - Purchasing Power & Future Cost Analysis</title>
    <meta name="description" content="Inflation Calculator. Calculate how inflation affects purchasing power over time and estimate future costs with historical and projected inflation rates.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>📈 Inflation Calculator</h1>
        <p>Calculate purchasing power changes and future costs adjusted for inflation</p>
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
            background: linear-gradient(135deg, #E91E63 0%, #C2185B 100%);
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
            color: #E91E63;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #C2185B;
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
            color: #E91E63;
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
            border-color: #E91E63;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #888;
            font-size: 0.9em;
        }
        
        .btn {
            background: #E91E63;
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
            background: #C2185B;
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
        
        .purchasing-power {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .future-cost {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }
        
        .inflation-impact {
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
            color: #E91E63;
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
            color: #E91E63;
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
            background: #fce4ec;
            border-left: 4px solid #E91E63;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box strong {
            color: #C2185B;
        }
        
        .calculator-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .calculator-option {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .calculator-option.active {
            background: #E91E63;
            color: white;
            border-color: #C2185B;
        }
        
        .inflation-rate-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .rate-option {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .rate-option.active {
            background: #E91E63;
            color: white;
            border-color: #C2185B;
        }
        
        .currency-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap: 8px;
            margin-bottom: 20px;
        }
        
        .currency-option {
            background: #f8f9fa;
            padding: 12px 8px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
            font-size: 0.9em;
        }
        
        .currency-option.active {
            background: #E91E63;
            color: white;
            border-color: #C2185B;
        }
        
        .currency-flag {
            font-size: 1.5em;
            margin-bottom: 5px;
        }
        
        .currency-code {
            font-weight: 600;
            font-size: 0.9em;
        }
        
        .currency-name {
            font-size: 0.7em;
            opacity: 0.8;
            margin-top: 2px;
        }
        
        .historical-data {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .data-table {
            width: 100%;
            margin: 15px 0;
            border-collapse: collapse;
        }
        
        .data-table th, .data-table td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #bbdefb;
        }
        
        .data-table th {
            background-color: #bbdefb;
            font-weight: 600;
            color: #1565C0;
        }
        
        .data-table tr:hover {
            background-color: #e1f5fe;
        }
        
        .purchasing-timeline {
            background: #f3e5f5;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .timeline-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e1bee7;
        }
        
        .timeline-item:last-child {
            border-bottom: none;
        }
        
        .timeline-bar {
            flex: 1;
            height: 20px;
            background: #e0e0e0;
            border-radius: 10px;
            margin: 0 15px;
            overflow: hidden;
        }
        
        .timeline-fill {
            height: 100%;
            border-radius: 10px;
            background: linear-gradient(90deg, #4CAF50, #E91E63);
        }
        
        .comparison-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 15px;
        }
        
        .comparison-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .comparison-card h4 {
            color: #E91E63;
            margin-bottom: 10px;
            font-size: 1.1em;
        }
        
        .impact-visual {
            height: 120px;
            background: #f8f9fa;
            border-radius: 8px;
            margin: 15px 0;
            position: relative;
            overflow: hidden;
        }
        
        .impact-bar {
            position: absolute;
            bottom: 0;
            width: 40%;
            background: #4CAF50;
            border-radius: 4px 4px 0 0;
            transition: all 0.5s ease;
        }
        
        .impact-bar.future {
            background: #E91E63;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .impact-labels {
            display: flex;
            justify-content: space-between;
            position: absolute;
            bottom: -25px;
            width: 100%;
            font-size: 0.9em;
            color: #666;
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
            
            .calculator-options,
            .inflation-rate-options {
                grid-template-columns: 1fr;
            }
            
            .comparison-grid {
                grid-template-columns: 1fr;
            }
            
            .currency-selector {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Inflation Calculation</h2>
                <form id="inflationForm">
                    <div class="form-group">
                        <label>Currency</label>
                        <div class="currency-selector" id="currencySelector">
                            <!-- Currency options will be populated by JavaScript -->
                        </div>
                        <input type="hidden" id="selectedCurrency" value="USD">
                    </div>
                    
                    <div class="form-group">
                        <label>Calculation Type</label>
                        <div class="calculator-options">
                            <div class="calculator-option active" data-type="purchasing">
                                <strong>Purchasing Power</strong>
                                <div>What past money is worth today</div>
                            </div>
                            <div class="calculator-option" data-type="future">
                                <strong>Future Cost</strong>
                                <div>What today's money will be worth</div>
                            </div>
                        </div>
                        <input type="hidden" id="calculationType" value="purchasing">
                    </div>
                    
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" id="amount" value="1000" min="1" max="10000000" step="100" required>
                        <small>The monetary amount to adjust for inflation</small>
                    </div>
                    
                    <div class="form-group" id="startYearGroup">
                        <label for="startYear">Starting Year</label>
                        <input type="number" id="startYear" value="2000" min="1900" max="2023" step="1" required>
                    </div>
                    
                    <div class="form-group" id="endYearGroup">
                        <label for="endYear">Ending Year</label>
                        <input type="number" id="endYear" value="2023" min="1901" max="2050" step="1" required>
                    </div>
                    
                    <div class="form-group" id="futureYearsGroup" style="display: none;">
                        <label for="futureYears">Years in the Future</label>
                        <input type="number" id="futureYears" value="10" min="1" max="50" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Inflation Rate Source</label>
                        <div class="inflation-rate-options">
                            <div class="rate-option active" data-rate="historical">
                                <strong>Historical CPI</strong>
                                <div>Actual inflation data</div>
                            </div>
                            <div class="rate-option" data-rate="custom">
                                <strong>Custom Rate</strong>
                                <div>Your own inflation estimate</div>
                            </div>
                            <div class="rate-option" data-rate="projected">
                                <strong>Projected</strong>
                                <div>Future estimates (3.0%)</div>
                            </div>
                        </div>
                        <input type="hidden" id="rateSource" value="historical">
                    </div>
                    
                    <div class="form-group" id="customRateGroup" style="display: none;">
                        <label for="customRate">Custom Annual Inflation Rate (%)</label>
                        <input type="number" id="customRate" value="3.0" min="0.1" max="50" step="0.1" required>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Inflation Impact</button>
                </form>
                
                <div class="historical-data">
                    <h3 style="color: #1565C0; margin-bottom: 15px;">Historical Inflation Data (US)</h3>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Inflation Rate</th>
                                <th>CPI Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2023</td>
                                <td>3.4%</td>
                                <td>307.051</td>
                            </tr>
                            <tr>
                                <td>2022</td>
                                <td>8.0%</td>
                                <td>296.311</td>
                            </tr>
                            <tr>
                                <td>2021</td>
                                <td>4.7%</td>
                                <td>274.310</td>
                            </tr>
                            <tr>
                                <td>2020</td>
                                <td>1.2%</td>
                                <td>258.811</td>
                            </tr>
                            <tr>
                                <td>2019</td>
                                <td>1.8%</td>
                                <td>255.657</td>
                            </tr>
                        </tbody>
                    </table>
                    <small>Source: U.S. Bureau of Labor Statistics</small>
                </div>
                
                <div class="breakdown" style="margin-top: 30px;">
                    <h3>Understanding Inflation</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Purchasing Power:</strong> Measures how much a specific amount of past money would be worth today after inflation.</p>
                        <p><strong>Future Cost:</strong> Estimates how much today's money will be worth in the future with inflation.</p>
                        <p><strong>CPI (Consumer Price Index):</strong> Measures average price changes for consumer goods and services.</p>
                        <p><strong>Inflation Rate:</strong> Annual percentage increase in consumer prices. Long-term average: ~3%</p>
                    </div>
                </div>
            </div>

            <div class="results-section">
                <h2>Inflation Analysis</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Adjusted Value</h3>
                    <div class="amount" id="adjustedValue">$1,815</div>
                    <div class="category" id="resultDescription">in 2023 dollars</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Original Value</h4>
                        <div class="value" id="originalValue">$1,000</div>
                    </div>
                    <div class="metric-card">
                        <h4>Inflation Rate</h4>
                        <div class="value" id="inflationRate">2.5% avg</div>
                    </div>
                    <div class="metric-card">
                        <h4>Time Period</h4>
                        <div class="value" id="timePeriod">23 years</div>
                    </div>
                    <div class="metric-card">
                        <h4>Value Change</h4>
                        <div class="value" id="valueChange">+81.5%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Calculation Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Original Amount</span>
                        <strong id="breakdownOriginal">$1,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Annual Inflation</span>
                        <strong id="breakdownInflation">2.5%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cumulative Inflation</span>
                        <strong id="breakdownCumulative">81.5%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Inflation Amount</span>
                        <strong id="breakdownInflationAmount">$815</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #E91E63; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Adjusted Value</strong></span>
                        <strong id="breakdownAdjusted" style="font-size: 1.1em;">$1,815</strong>
                    </div>
                </div>

                <div class="purchasing-timeline">
                    <h3 style="color: #7B1FA2; margin-bottom: 15px;">Purchasing Power Timeline</h3>
                    <div class="timeline-item">
                        <span id="timelineStartYear">2000</span>
                        <div class="timeline-bar">
                            <div class="timeline-fill" id="timelineFill" style="width: 100%;"></div>
                        </div>
                        <span id="timelineEndYear">2023</span>
                    </div>
                    <div style="text-align: center; margin-top: 10px;">
                        <span id="timelineText">$1,000 in 2000 = $1,815 in 2023</span>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Purchasing Power Impact</h3>
                    <div class="impact-visual">
                        <div class="impact-bar" id="currentValueBar" style="height: 80%; left: 20%;"></div>
                        <div class="impact-bar future" id="futureValueBar" style="height: 44%;"></div>
                        <div class="impact-labels">
                            <span id="currentLabel">2000: $1,000</span>
                            <span id="futureLabel">2023: $1,815</span>
                        </div>
                    </div>
                    <div style="text-align: center; margin-top: 10px;">
                        <p id="impactText">To maintain the same purchasing power, you would need $1,815 in 2023 to equal $1,000 in 2000.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Common Item Comparisons</h3>
                    <div class="comparison-grid">
                        <div class="comparison-card">
                            <h4>🍔 Fast Food Meal</h4>
                            <div class="breakdown-item">
                                <span>Then (<span id="mealThenYear">2000</span>)</span>
                                <strong id="mealThenPrice">$5.00</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Now (<span id="mealNowYear">2023</span>)</span>
                                <strong id="mealNowPrice">$9.08</strong>
                            </div>
                        </div>
                        <div class="comparison-card">
                            <h4>⛽ Gallon of Gas</h4>
                            <div class="breakdown-item">
                                <span>Then (<span id="gasThenYear">2000</span>)</span>
                                <strong id="gasThenPrice">$1.50</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Now (<span id="gasNowYear">2023</span>)</span>
                                <strong id="gasNowPrice">$2.72</strong>
                            </div>
                        </div>
                        <div class="comparison-card">
                            <h4>🎬 Movie Ticket</h4>
                            <div class="breakdown-item">
                                <span>Then (<span id="movieThenYear">2000</span>)</span>
                                <strong id="movieThenPrice">$5.50</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Now (<span id="movieNowYear">2023</span>)</span>
                                <strong id="movieNowPrice">$9.98</strong>
                            </div>
                        </div>
                        <div class="comparison-card">
                            <h4>🏠 Median Home</h4>
                            <div class="breakdown-item">
                                <span>Then (<span id="homeThenYear">2000</span>)</span>
                                <strong id="homeThenPrice">$165,000</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Now (<span id="homeNowYear">2023</span>)</span>
                                <strong id="homeNowPrice">$299,000</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Investment Implications</h3>
                    <div id="investmentImplications" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="implicationsText" style="margin: 0;">To maintain purchasing power, investments need to outpace inflation. A 2.5% average inflation rate means investments must earn at least 2.5% annually just to break even in real terms.</p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Inflation Insights:</strong> Inflation erodes purchasing power over time. Historical average inflation is ~3% annually. High inflation periods (1970s-1980s) saw rates up to 14%. Deflation (negative inflation) is rare but can occur during recessions. Core inflation excludes food and energy prices. Different goods inflate at different rates (medical care > electronics). Wages often lag behind inflation. Fixed-income investments lose value during high inflation. Real returns = nominal returns minus inflation. Central banks target ~2% inflation for economic stability. Hyperinflation (>50% monthly) destroys currency value. Inflation-protected securities (TIPS) adjust for inflation.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('inflationForm');
        const calculationOptions = document.querySelectorAll('.calculator-option');
        const rateOptions = document.querySelectorAll('.rate-option');
        
        // Currency data with exchange rates (simplified - in real app, use API)
        const currencies = {
            USD: { symbol: '$', code: 'USD', name: 'US Dollar', flag: '🇺🇸', exchangeRate: 1 },
            EUR: { symbol: '€', code: 'EUR', name: 'Euro', flag: '🇪🇺', exchangeRate: 0.92 },
            GBP: { symbol: '£', code: 'GBP', name: 'British Pound', flag: '🇬🇧', exchangeRate: 0.79 },
            JPY: { symbol: '¥', code: 'JPY', name: 'Japanese Yen', flag: '🇯🇵', exchangeRate: 150 },
            CAD: { symbol: 'C$', code: 'CAD', name: 'Canadian Dollar', flag: '🇨🇦', exchangeRate: 1.35 },
            AUD: { symbol: 'A$', code: 'AUD', name: 'Australian Dollar', flag: '🇦🇺', exchangeRate: 1.52 },
            CHF: { symbol: 'CHF', code: 'CHF', name: 'Swiss Franc', flag: '🇨🇭', exchangeRate: 0.88 },
            CNY: { symbol: '¥', code: 'CNY', name: 'Chinese Yuan', flag: '🇨🇳', exchangeRate: 7.18 },
            INR: { symbol: '₹', code: 'INR', name: 'Indian Rupee', flag: '🇮🇳', exchangeRate: 83 },
            BRL: { symbol: 'R$', code: 'BRL', name: 'Brazilian Real', flag: '🇧🇷', exchangeRate: 4.95 },
            MXN: { symbol: 'MX$', code: 'MXN', name: 'Mexican Peso', flag: '🇲🇽', exchangeRate: 17.05 },
            ZAR: { symbol: 'R', code: 'ZAR', name: 'South African Rand', flag: '🇿🇦', exchangeRate: 18.75 }
        };
        
        // Historical CPI data (simplified)
        const cpiData = {
            2023: 307.051,
            2022: 296.311,
            2021: 274.310,
            2020: 258.811,
            2019: 255.657,
            2018: 251.107,
            2017: 245.120,
            2016: 240.007,
            2015: 237.017,
            2014: 236.736,
            2013: 232.957,
            2012: 229.594,
            2011: 224.939,
            2010: 218.056,
            2005: 195.300,
            2000: 172.200,
            1995: 152.400,
            1990: 130.700,
            1985: 107.600,
            1980: 82.400,
            1975: 53.800,
            1970: 38.800,
            1965: 31.500,
            1960: 29.600,
            1955: 26.800,
            1950: 24.100
        };
        
        // Initialize currency selector
        function initializeCurrencySelector() {
            const currencySelector = document.getElementById('currencySelector');
            
            Object.values(currencies).forEach(currency => {
                const option = document.createElement('div');
                option.className = `currency-option ${currency.code === 'USD' ? 'active' : ''}`;
                option.dataset.currency = currency.code;
                
                option.innerHTML = `
                    <div class="currency-flag">${currency.flag}</div>
                    <div class="currency-code">${currency.code}</div>
                    <div class="currency-name">${currency.name}</div>
                `;
                
                option.addEventListener('click', function() {
                    document.querySelectorAll('.currency-option').forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                    document.getElementById('selectedCurrency').value = currency.code;
                    calculateInflation();
                });
                
                currencySelector.appendChild(option);
            });
        }
        
        // Calculation type selection
        calculationOptions.forEach(option => {
            option.addEventListener('click', function() {
                calculationOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                const calcType = this.dataset.type;
                document.getElementById('calculationType').value = calcType;
                
                // Toggle input visibility
                if (calcType === 'purchasing') {
                    document.getElementById('startYearGroup').style.display = 'block';
                    document.getElementById('endYearGroup').style.display = 'block';
                    document.getElementById('futureYearsGroup').style.display = 'none';
                } else {
                    document.getElementById('startYearGroup').style.display = 'block';
                    document.getElementById('endYearGroup').style.display = 'none';
                    document.getElementById('futureYearsGroup').style.display = 'block';
                }
                
                calculateInflation();
            });
        });
        
        // Rate source selection
        rateOptions.forEach(option => {
            option.addEventListener('click', function() {
                rateOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                const rateSource = this.dataset.rate;
                document.getElementById('rateSource').value = rateSource;
                
                // Toggle custom rate input
                document.getElementById('customRateGroup').style.display = 
                    rateSource === 'custom' ? 'block' : 'none';
                
                calculateInflation();
            });
        });
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateInflation();
        });

        function calculateInflation() {
            const selectedCurrency = document.getElementById('selectedCurrency').value;
            const currency = currencies[selectedCurrency];
            const calcType = document.getElementById('calculationType').value;
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const rateSource = document.getElementById('rateSource').value;
            const customRate = parseFloat(document.getElementById('customRate').value) || 0;
            
            let startYear, endYear, years;
            
            if (calcType === 'purchasing') {
                startYear = parseInt(document.getElementById('startYear').value) || 0;
                endYear = parseInt(document.getElementById('endYear').value) || 0;
                years = endYear - startYear;
            } else {
                startYear = parseInt(document.getElementById('startYear').value) || 0;
                years = parseInt(document.getElementById('futureYears').value) || 0;
                endYear = startYear + years;
            }
            
            // Get inflation rate
            let inflationRate;
            if (rateSource === 'historical') {
                // Calculate average historical inflation rate
                inflationRate = calculateHistoricalInflationRate(startYear, endYear);
            } else if (rateSource === 'custom') {
                inflationRate = customRate / 100;
            } else {
                inflationRate = 0.03; // Projected 3%
            }
            
            // Calculate adjusted value
            let adjustedValue, cumulativeInflation, inflationAmount;
            
            if (calcType === 'purchasing') {
                // Past to present: Future Value = Present Value × (1 + inflation rate)^years
                adjustedValue = amount * Math.pow(1 + inflationRate, years);
                cumulativeInflation = (adjustedValue / amount - 1) * 100;
                inflationAmount = adjustedValue - amount;
            } else {
                // Present to future: Future Value = Present Value × (1 + inflation rate)^years
                adjustedValue = amount * Math.pow(1 + inflationRate, years);
                cumulativeInflation = (adjustedValue / amount - 1) * 100;
                inflationAmount = adjustedValue - amount;
            }
            
            // Update UI with currency formatting
            const card = document.getElementById('resultCard');
            if (calcType === 'purchasing') {
                card.className = 'result-card purchasing-power';
                document.getElementById('resultDescription').textContent = `in ${endYear} dollars`;
                document.getElementById('adjustedValue').textContent = formatCurrency(adjustedValue, currency);
                document.getElementById('valueChange').textContent = `+${cumulativeInflation.toFixed(1)}%`;
            } else {
                card.className = 'result-card future-cost';
                document.getElementById('resultDescription').textContent = `in ${endYear} dollars`;
                document.getElementById('adjustedValue').textContent = formatCurrency(adjustedValue, currency);
                document.getElementById('valueChange').textContent = `+${cumulativeInflation.toFixed(1)}%`;
            }
            
            document.getElementById('originalValue').textContent = formatCurrency(amount, currency);
            document.getElementById('inflationRate').textContent = `${(inflationRate * 100).toFixed(1)}% avg`;
            document.getElementById('timePeriod').textContent = `${years} years`;
            
            document.getElementById('breakdownOriginal').textContent = formatCurrency(amount, currency);
            document.getElementById('breakdownInflation').textContent = `${(inflationRate * 100).toFixed(1)}%`;
            document.getElementById('breakdownCumulative').textContent = `${cumulativeInflation.toFixed(1)}%`;
            document.getElementById('breakdownInflationAmount').textContent = formatCurrency(inflationAmount, currency);
            document.getElementById('breakdownAdjusted').textContent = formatCurrency(adjustedValue, currency);
            
            // Update timeline
            document.getElementById('timelineStartYear').textContent = startYear;
            document.getElementById('timelineEndYear').textContent = endYear;
            document.getElementById('timelineText').textContent = 
                calcType === 'purchasing' 
                    ? `${formatCurrency(amount, currency)} in ${startYear} = ${formatCurrency(adjustedValue, currency)} in ${endYear}`
                    : `${formatCurrency(amount, currency)} today = ${formatCurrency(adjustedValue, currency)} in ${endYear}`;
            
            // Update impact visual
            const currentHeight = calcType === 'purchasing' ? 80 : 100;
            const futureHeight = (amount / adjustedValue) * currentHeight;
            
            document.getElementById('currentValueBar').style.height = `${currentHeight}%`;
            document.getElementById('futureValueBar').style.height = `${futureHeight}%`;
            
            document.getElementById('currentLabel').textContent = 
                calcType === 'purchasing' ? `${startYear}: ${formatCurrency(amount, currency)}` : `Today: ${formatCurrency(amount, currency)}`;
            document.getElementById('futureLabel').textContent = 
                calcType === 'purchasing' ? `${endYear}: ${formatCurrency(adjustedValue, currency)}` : `${endYear}: ${formatCurrency(adjustedValue, currency)}`;
            
            document.getElementById('impactText').textContent = 
                calcType === 'purchasing'
                    ? `To maintain the same purchasing power, you would need ${formatCurrency(adjustedValue, currency)} in ${endYear} to equal ${formatCurrency(amount, currency)} in ${startYear}.`
                    : `With ${(inflationRate * 100).toFixed(1)}% annual inflation, ${formatCurrency(amount, currency)} today will only be worth ${formatCurrency(adjustedValue, currency)} in ${endYear} purchasing power.`;
            
            // Update common item comparisons
            updateCommonItems(startYear, endYear, amount, adjustedValue, currency);
            
            // Update investment implications
            document.getElementById('implicationsText').textContent = 
                `To maintain purchasing power, investments need to outpace inflation. A ${(inflationRate * 100).toFixed(1)}% average inflation rate means investments must earn at least ${(inflationRate * 100).toFixed(1)}% annually just to break even in real terms.`;
        }
        
        function calculateHistoricalInflationRate(startYear, endYear) {
            // Get CPI values for start and end years (use closest available years)
            const startCPI = getClosestCPI(startYear);
            const endCPI = getClosestCPI(endYear);
            
            // Calculate average annual inflation rate
            const years = endYear - startYear;
            const inflationRate = Math.pow(endCPI / startCPI, 1 / years) - 1;
            
            return inflationRate;
        }
        
        function getClosestCPI(year) {
            // Find the closest available CPI data for the given year
            const years = Object.keys(cpiData).map(y => parseInt(y)).sort((a, b) => a - b);
            
            let closestYear = years[0];
            for (const availableYear of years) {
                if (Math.abs(availableYear - year) < Math.abs(closestYear - year)) {
                    closestYear = availableYear;
                }
            }
            
            return cpiData[closestYear];
        }
        
        function updateCommonItems(startYear, endYear, originalAmount, adjustedAmount, currency) {
            // Common item prices in USD (simplified estimates)
            const items = {
                meal: { then: 5.00, now: 9.00 },
                gas: { then: 1.50, now: 3.50 },
                movie: { then: 5.50, now: 12.00 },
                home: { then: 165000, now: 400000 }
            };
            
            // Calculate adjusted prices based on the same inflation rate
            const inflationFactor = adjustedAmount / originalAmount;
            
            // Convert prices to selected currency
            const convertPrice = (price) => price * currency.exchangeRate;
            
            document.getElementById('mealThenYear').textContent = startYear;
            document.getElementById('mealThenPrice').textContent = formatCurrency(convertPrice(items.meal.then), currency);
            document.getElementById('mealNowYear').textContent = endYear;
            document.getElementById('mealNowPrice').textContent = formatCurrency(convertPrice(items.meal.then * inflationFactor), currency);
            
            document.getElementById('gasThenYear').textContent = startYear;
            document.getElementById('gasThenPrice').textContent = formatCurrency(convertPrice(items.gas.then), currency);
            document.getElementById('gasNowYear').textContent = endYear;
            document.getElementById('gasNowPrice').textContent = formatCurrency(convertPrice(items.gas.then * inflationFactor), currency);
            
            document.getElementById('movieThenYear').textContent = startYear;
            document.getElementById('movieThenPrice').textContent = formatCurrency(convertPrice(items.movie.then), currency);
            document.getElementById('movieNowYear').textContent = endYear;
            document.getElementById('movieNowPrice').textContent = formatCurrency(convertPrice(items.movie.then * inflationFactor), currency);
            
            document.getElementById('homeThenYear').textContent = startYear;
            document.getElementById('homeThenPrice').textContent = formatCurrency(convertPrice(items.home.then), currency);
            document.getElementById('homeNowYear').textContent = endYear;
            document.getElementById('homeNowPrice').textContent = formatCurrency(convertPrice(items.home.then * inflationFactor), currency);
        }
        
        function formatCurrency(amount, currency) {
            // For currencies like JPY that typically don't use decimals
            const useDecimals = !['JPY'].includes(currency.code);
            
            // Convert amount to selected currency
            const convertedAmount = amount * currency.exchangeRate;
            
            if (convertedAmount >= 1000 && useDecimals) {
                return currency.symbol + convertedAmount.toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            } else {
                return currency.symbol + convertedAmount.toLocaleString('en-US', {
                    minimumFractionDigits: useDecimals ? 2 : 0,
                    maximumFractionDigits: useDecimals ? 2 : 0
                });
            }
        }

        // Initialize the calculator
        window.addEventListener('load', function() {
            initializeCurrencySelector();
            calculateInflation();
        });
    </script>
</body>
</html>