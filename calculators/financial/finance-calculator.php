<?php
/**
 * Finance Calculator - All-in-One Financial Calculator
 * File: finance-calculator.php
 * Description: Comprehensive financial calculator with multiple tools including loan, investment, retirement, and savings calculators
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Calculator - All-in-One Financial Calculator Suite</title>
    <meta name="description" content="Comprehensive Finance Calculator with loan calculator, investment calculator, retirement planner, savings calculator, and financial health assessment.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>💰 Finance Calculator</h1>
        <p>All-in-One Financial Calculator Suite for Complete Money Management</p>
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
            max-width: 1400px;
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
            color: #764ba2;
        }
        
        .calculator-tabs {
            display: flex;
            background: white;
            border-radius: 10px 10px 0 0;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .tab {
            flex: 1;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background: #f8f9fa;
            border: none;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
            border-bottom: 3px solid transparent;
        }
        
        .tab.active {
            background: white;
            color: #667eea;
            border-bottom: 3px solid #667eea;
        }
        
        .tab:hover {
            background: #e9ecef;
        }
        
        .calculator-wrapper {
            background: white;
            border-radius: 0 0 10px 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .calculator-content {
            display: none;
        }
        
        .calculator-content.active {
            display: block;
        }
        
        .calculator-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .input-section h2,
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
            background: #764ba2;
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
            font-size: 2.5em;
            font-weight: bold;
        }
        
        .result-card .category {
            font-size: 1.1em;
            margin-top: 10px;
            opacity: 0.95;
        }
        
        .loan-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .investment-card {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .retirement-card {
            background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
        }
        
        .savings-card {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }
        
        .debt-card {
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
            font-size: 1.8em;
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
        
        .progress-meter {
            height: 20px;
            background: #e0e0e0;
            border-radius: 10px;
            margin: 15px 0;
            overflow: hidden;
        }
        
        .progress-level {
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s ease;
        }
        
        .timeline-chart {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        
        .timeline-chart th, .timeline-chart td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .timeline-chart th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #555;
        }
        
        .timeline-chart tr:hover {
            background-color: #f5f5f5;
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
            background: #667eea;
            color: white;
            border-color: #764ba2;
        }
        
        .comparison-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        
        .comparison-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
        }
        
        .comparison-card h4 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.2em;
        }
        
        .financial-health {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-top: 30px;
        }
        
        .health-metrics {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin: 20px 0;
        }
        
        .health-metric {
            background: rgba(255,255,255,0.2);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        
        .health-metric .value {
            font-size: 1.8em;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .health-metric .label {
            font-size: 0.9em;
            opacity: 0.9;
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
            color: #667eea;
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
            border-color: #667eea;
            transform: translateY(-2px);
        }
        
        .currency-option.active {
            background: #667eea;
            color: white;
            border-color: #764ba2;
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
            .calculator-section {
                grid-template-columns: 1fr;
            }
            
            .calculator-tabs {
                flex-direction: column;
            }
            
            header h1 {
                font-size: 2em;
            }
            
            .result-card .amount {
                font-size: 2em;
            }
            
            .metric-grid {
                grid-template-columns: 1fr;
            }
            
            .calculator-options {
                grid-template-columns: 1fr;
            }
            
            .comparison-grid {
                grid-template-columns: 1fr;
            }
            
            .health-metrics {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .currency-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Calculators</a>
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

        <div class="calculator-tabs">
            <button class="tab active" data-tab="loan">Loan Calculator</button>
            <button class="tab" data-tab="investment">Investment Calculator</button>
            <button class="tab" data-tab="retirement">Retirement Planner</button>
            <button class="tab" data-tab="savings">Savings Calculator</button>
            <button class="tab" data-tab="debt">Debt Payoff</button>
            <button class="tab" data-tab="overview">Financial Health</button>
        </div>

        <!-- Loan Calculator -->
        <div class="calculator-wrapper">
            <div class="calculator-content active" id="loan-calculator">
                <div class="calculator-section">
                    <div class="input-section">
                        <h2>Loan Calculator</h2>
                        <form id="loanForm">
                            <div class="form-group">
                                <label for="loanAmount">Loan Amount</label>
                                <input type="number" id="loanAmount" value="25000" min="100" max="10000000" step="100" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="loanInterest">Annual Interest Rate (%)</label>
                                <input type="number" id="loanInterest" value="5.5" min="0.1" max="50" step="0.1" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="loanTerm">Loan Term (Years)</label>
                                <input type="number" id="loanTerm" value="5" min="1" max="50" step="1" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Loan Type</label>
                                <div class="calculator-options">
                                    <div class="calculator-option active" data-type="fixed">Fixed Rate</div>
                                    <div class="calculator-option" data-type="variable">Variable Rate</div>
                                </div>
                                <input type="hidden" id="loanType" value="fixed">
                            </div>
                            
                            <button type="submit" class="btn">Calculate Loan</button>
                        </form>
                    </div>

                    <div class="results-section">
                        <h2>Loan Results</h2>
                        
                        <div class="result-card loan-card">
                            <h3>Monthly Payment</h3>
                            <div class="amount" id="monthlyPayment">$478</div>
                            <div class="category" id="paymentFrequency">per month</div>
                        </div>

                        <div class="metric-grid">
                            <div class="metric-card">
                                <h4>Total Interest</h4>
                                <div class="value" id="totalInterest">$3,680</div>
                            </div>
                            <div class="metric-card">
                                <h4>Total Payment</h4>
                                <div class="value" id="totalPayment">$28,680</div>
                            </div>
                            <div class="metric-card">
                                <h4>Payoff Time</h4>
                                <div class="value" id="payoffTime">5 years</div>
                            </div>
                            <div class="metric-card">
                                <h4>Interest Rate</h4>
                                <div class="value" id="interestRate">5.5%</div>
                            </div>
                        </div>

                        <div class="breakdown">
                            <h3>Payment Breakdown</h3>
                            <div class="breakdown-item">
                                <span>Principal Amount</span>
                                <strong id="principalAmount">$25,000</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Total Interest</span>
                                <strong id="breakdownInterest">$3,680</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Total of Payments</span>
                                <strong id="breakdownTotal">$28,680</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Number of Payments</span>
                                <strong id="numberPayments">60</strong>
                            </div>
                        </div>

                        <div class="breakdown" style="margin-top: 20px;">
                            <h3>Amortization Schedule (First 12 Months)</h3>
                            <table class="timeline-chart">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Payment</th>
                                        <th>Principal</th>
                                        <th>Interest</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody id="amortizationTable">
                                    <!-- Amortization data will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Investment Calculator -->
            <div class="calculator-content" id="investment-calculator">
                <div class="calculator-section">
                    <div class="input-section">
                        <h2>Investment Calculator</h2>
                        <form id="investmentForm">
                            <div class="form-group">
                                <label for="initialInvestment">Initial Investment</label>
                                <input type="number" id="initialInvestment" value="10000" min="0" max="10000000" step="100" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="monthlyContribution">Monthly Contribution</label>
                                <input type="number" id="monthlyContribution" value="500" min="0" max="100000" step="10" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="investmentYears">Investment Period (Years)</label>
                                <input type="number" id="investmentYears" value="20" min="1" max="100" step="1" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="expectedReturn">Expected Annual Return (%)</label>
                                <input type="number" id="expectedReturn" value="7" min="0.1" max="50" step="0.1" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="inflationRate">Inflation Rate (%)</label>
                                <input type="number" id="inflationRate" value="2.5" min="0" max="20" step="0.1" required>
                            </div>
                            
                            <button type="submit" class="btn">Calculate Investment</button>
                        </form>
                    </div>

                    <div class="results-section">
                        <h2>Investment Results</h2>
                        
                        <div class="result-card investment-card">
                            <h3>Future Value</h3>
                            <div class="amount" id="futureValue">$312,909</div>
                            <div class="category" id="investmentPeriod">After 20 years</div>
                        </div>

                        <div class="metric-grid">
                            <div class="metric-card">
                                <h4>Total Contributions</h4>
                                <div class="value" id="totalContributions">$130,000</div>
                            </div>
                            <div class="metric-card">
                                <h4>Interest Earned</h4>
                                <div class="value" id="interestEarned">$182,909</div>
                            </div>
                            <div class="metric-card">
                                <h4>Real Value (Today's $)</h4>
                                <div class="value" id="realValue">$190,432</div>
                            </div>
                            <div class="metric-card">
                                <h4>Annual Return</h4>
                                <div class="value" id="annualReturn">7.0%</div>
                            </div>
                        </div>

                        <div class="breakdown">
                            <h3>Investment Growth</h3>
                            <div class="breakdown-item">
                                <span>Initial Investment</span>
                                <strong id="breakdownInitial">$10,000</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Monthly Contributions</span>
                                <strong id="breakdownMonthly">$120,000</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Compound Interest</span>
                                <strong id="breakdownCompound">$182,909</strong>
                            </div>
                            <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                                <span><strong>Total Future Value</strong></span>
                                <strong id="breakdownFuture" style="font-size: 1.1em;">$312,909</strong>
                            </div>
                        </div>

                        <div class="comparison-grid">
                            <div class="comparison-card">
                                <h4>📈 Growth Comparison</h4>
                                <div class="breakdown-item">
                                    <span>No Additional Contributions</span>
                                    <strong id="noContributions">$38,697</strong>
                                </div>
                                <div class="breakdown-item">
                                    <span>With Your Contributions</span>
                                    <strong id="withContributions">$312,909</strong>
                                </div>
                                <div class="breakdown-item">
                                    <span>Difference</span>
                                    <strong id="contributionDifference">+$274,212</strong>
                                </div>
                            </div>
                            
                            <div class="comparison-card">
                                <h4>⏰ Time Impact</h4>
                                <div class="breakdown-item">
                                    <span>10 Years Earlier</span>
                                    <strong id="tenYearsEarlier">$586,193</strong>
                                </div>
                                <div class="breakdown-item">
                                    <span>Your Plan</span>
                                    <strong id="yourPlan">$312,909</strong>
                                </div>
                                <div class="breakdown-item">
                                    <span>10 Years Later</span>
                                    <strong id="tenYearsLater">$167,514</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Retirement Planner -->
            <div class="calculator-content" id="retirement-calculator">
                <div class="calculator-section">
                    <div class="input-section">
                        <h2>Retirement Planner</h2>
                        <form id="retirementForm">
                            <div class="form-group">
                                <label for="currentAge">Current Age</label>
                                <input type="number" id="currentAge" value="35" min="18" max="100" step="1" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="retirementAge">Planned Retirement Age</label>
                                <input type="number" id="retirementAge" value="65" min="40" max="100" step="1" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="currentSavings">Current Retirement Savings</label>
                                <input type="number" id="currentSavings" value="50000" min="0" max="10000000" step="1000" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="annualContribution">Annual Contribution</label>
                                <input type="number" id="annualContribution" value="10000" min="0" max="1000000" step="100" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="retirementReturn">Expected Return (%)</label>
                                <input type="number" id="retirementReturn" value="6" min="0.1" max="20" step="0.1" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="retirementIncome">Desired Annual Retirement Income</label>
                                <input type="number" id="retirementIncome" value="60000" min="10000" max="1000000" step="1000" required>
                            </div>
                            
                            <button type="submit" class="btn">Calculate Retirement</button>
                        </form>
                    </div>

                    <div class="results-section">
                        <h2>Retirement Projection</h2>
                        
                        <div class="result-card retirement-card">
                            <h3>Retirement Nest Egg</h3>
                            <div class="amount" id="retirementNestEgg">$1,245,678</div>
                            <div class="category" id="retirementAgeDisplay">at age 65</div>
                        </div>

                        <div class="metric-grid">
                            <div class="metric-card">
                                <h4>Years to Retirement</h4>
                                <div class="value" id="yearsToRetirement">30</div>
                            </div>
                            <div class="metric-card">
                                <h4>Monthly Income</h4>
                                <div class="value" id="monthlyRetirementIncome">$5,000</div>
                            </div>
                            <div class="metric-card">
                                <h4>Savings Shortfall</h4>
                                <div class="value" id="savingsShortfall">-$154,322</div>
                            </div>
                            <div class="metric-card">
                                <h4>Success Probability</h4>
                                <div class="value" id="successProbability">85%</div>
                            </div>
                        </div>

                        <div class="breakdown">
                            <h3>Retirement Readiness</h3>
                            <div class="breakdown-item">
                                <span>Required Nest Egg</span>
                                <strong id="requiredNestEgg">$1,400,000</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Projected Nest Egg</span>
                                <strong id="projectedNestEgg">$1,245,678</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Shortfall/Surplus</span>
                                <strong id="nestEggDifference">-$154,322</strong>
                            </div>
                            <div class="progress-meter">
                                <div class="progress-level" id="retirementProgress" style="width: 89%; background: #FF6B35;"></div>
                            </div>
                            <div style="text-align: center; margin-top: 10px;">
                                <span id="progressText">89% of target</span>
                            </div>
                        </div>

                        <div class="breakdown" style="margin-top: 20px;">
                            <h3>Recommendations</h3>
                            <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                                <p id="retirementRecommendation" style="margin: 0;">To reach your retirement goal, consider increasing your annual contributions by $5,000 or working 2 additional years. Your current plan has an 85% success probability.</p>
                            </div>
                        </div>

                        <div class="info-box">
                            <strong>Retirement Tips:</strong> Start early to benefit from compound growth. Maximize employer matching contributions. Consider diversifying investments. Review your plan annually. Account for healthcare costs and inflation. Consider working part-time in retirement. Have a withdrawal strategy to make savings last.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional calculators would continue here for Savings, Debt Payoff, and Financial Health -->
            
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
        
        // Tab switching functionality
        const tabs = document.querySelectorAll('.tab');
        const calculatorContents = document.querySelectorAll('.calculator-content');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const targetTab = this.dataset.tab;
                
                // Update active tab
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Show corresponding calculator
                calculatorContents.forEach(content => {
                    content.classList.remove('active');
                    if (content.id === `${targetTab}-calculator`) {
                        content.classList.add('active');
                    }
                });
                
                // Recalculate for the active calculator
                recalculateActiveCalculator();
            });
        });
        
        // Currency selection
        document.querySelectorAll('.currency-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.currency-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                
                currentCurrency = this.dataset.currency;
                recalculateActiveCalculator();
            });
        });
        
        // Loan type selection
        document.querySelectorAll('.calculator-option').forEach(option => {
            option.addEventListener('click', function() {
                const parent = this.parentElement;
                parent.querySelectorAll('.calculator-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                
                if (parent.querySelector('[data-type]')) {
                    const type = this.dataset.type;
                    document.getElementById('loanType').value = type;
                    calculateLoan();
                }
            });
        });
        
        // Form submissions
        document.getElementById('loanForm').addEventListener('submit', function(e) {
            e.preventDefault();
            calculateLoan();
        });
        
        document.getElementById('investmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            calculateInvestment();
        });
        
        document.getElementById('retirementForm').addEventListener('submit', function(e) {
            e.preventDefault();
            calculateRetirement();
        });
        
        function recalculateActiveCalculator() {
            const activeTab = document.querySelector('.tab.active').dataset.tab;
            switch(activeTab) {
                case 'loan':
                    calculateLoan();
                    break;
                case 'investment':
                    calculateInvestment();
                    break;
                case 'retirement':
                    calculateRetirement();
                    break;
                // Add cases for other calculators
            }
        }
        
        function calculateLoan() {
            const amount = parseFloat(document.getElementById('loanAmount').value) || 0;
            const interest = parseFloat(document.getElementById('loanInterest').value) || 0;
            const years = parseFloat(document.getElementById('loanTerm').value) || 0;
            
            const monthlyInterest = interest / 100 / 12;
            const numberOfPayments = years * 12;
            
            // Calculate monthly payment
            const monthlyPayment = amount * (monthlyInterest * Math.pow(1 + monthlyInterest, numberOfPayments)) / 
                                 (Math.pow(1 + monthlyInterest, numberOfPayments) - 1);
            
            const totalPayment = monthlyPayment * numberOfPayments;
            const totalInterest = totalPayment - amount;
            
            // Update UI
            document.getElementById('monthlyPayment').textContent = formatCurrency(monthlyPayment);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest);
            document.getElementById('totalPayment').textContent = formatCurrency(totalPayment);
            document.getElementById('payoffTime').textContent = `${years} years`;
            document.getElementById('interestRate').textContent = `${interest}%`;
            
            document.getElementById('principalAmount').textContent = formatCurrency(amount);
            document.getElementById('breakdownInterest').textContent = formatCurrency(totalInterest);
            document.getElementById('breakdownTotal').textContent = formatCurrency(totalPayment);
            document.getElementById('numberPayments').textContent = numberOfPayments;
            
            // Generate amortization table
            generateAmortizationTable(amount, monthlyInterest, monthlyPayment, numberOfPayments);
        }
        
        function calculateInvestment() {
            const initial = parseFloat(document.getElementById('initialInvestment').value) || 0;
            const monthly = parseFloat(document.getElementById('monthlyContribution').value) || 0;
            const years = parseFloat(document.getElementById('investmentYears').value) || 0;
            const returnRate = parseFloat(document.getElementById('expectedReturn').value) || 0;
            const inflation = parseFloat(document.getElementById('inflationRate').value) || 0;
            
            const monthlyRate = returnRate / 100 / 12;
            const months = years * 12;
            
            // Calculate future value
            let futureValue = initial * Math.pow(1 + monthlyRate, months);
            futureValue += monthly * (Math.pow(1 + monthlyRate, months) - 1) / monthlyRate;
            
            const totalContributions = initial + (monthly * months);
            const interestEarned = futureValue - totalContributions;
            
            // Calculate real value (adjusted for inflation)
            const realValue = futureValue / Math.pow(1 + inflation/100, years);
            
            // Comparison calculations
            const noContributionsValue = initial * Math.pow(1 + returnRate/100, years);
            const tenYearsEarlier = calculateInvestmentValue(initial, monthly, years + 10, returnRate);
            const tenYearsLater = calculateInvestmentValue(initial, monthly, years - 10, returnRate);
            
            // Update UI
            document.getElementById('futureValue').textContent = formatCurrency(futureValue);
            document.getElementById('totalContributions').textContent = formatCurrency(totalContributions);
            document.getElementById('interestEarned').textContent = formatCurrency(interestEarned);
            document.getElementById('realValue').textContent = formatCurrency(realValue);
            document.getElementById('annualReturn').textContent = `${returnRate}%`;
            
            document.getElementById('breakdownInitial').textContent = formatCurrency(initial);
            document.getElementById('breakdownMonthly').textContent = formatCurrency(monthly * months);
            document.getElementById('breakdownCompound').textContent = formatCurrency(interestEarned);
            document.getElementById('breakdownFuture').textContent = formatCurrency(futureValue);
            
            document.getElementById('noContributions').textContent = formatCurrency(noContributionsValue);
            document.getElementById('withContributions').textContent = formatCurrency(futureValue);
            document.getElementById('contributionDifference').textContent = `+${formatCurrency(futureValue - noContributionsValue)}`;
            
            document.getElementById('tenYearsEarlier').textContent = formatCurrency(tenYearsEarlier);
            document.getElementById('yourPlan').textContent = formatCurrency(futureValue);
            document.getElementById('tenYearsLater').textContent = formatCurrency(tenYearsLater);
        }
        
        function calculateRetirement() {
            const currentAge = parseInt(document.getElementById('currentAge').value) || 0;
            const retirementAge = parseInt(document.getElementById('retirementAge').value) || 0;
            const currentSavings = parseFloat(document.getElementById('currentSavings').value) || 0;
            const annualContribution = parseFloat(document.getElementById('annualContribution').value) || 0;
            const returnRate = parseFloat(document.getElementById('retirementReturn').value) || 0;
            const desiredIncome = parseFloat(document.getElementById('retirementIncome').value) || 0;
            
            const yearsToRetirement = retirementAge - currentAge;
            
            // Calculate future value of current savings
            const futureSavings = currentSavings * Math.pow(1 + returnRate/100, yearsToRetirement);
            
            // Calculate future value of contributions
            const futureContributions = annualContribution * (Math.pow(1 + returnRate/100, yearsToRetirement) - 1) / (returnRate/100);
            
            const totalNestEgg = futureSavings + futureContributions;
            
            // Calculate required nest egg (using 4% rule)
            const requiredNestEgg = desiredIncome * 25;
            
            const shortfall = requiredNestEgg - totalNestEgg;
            const progressPercentage = Math.min(100, (totalNestEgg / requiredNestEgg) * 100);
            const successProbability = progressPercentage >= 100 ? 95 : Math.max(50, progressPercentage);
            
            // Update UI
            document.getElementById('retirementNestEgg').textContent = formatCurrency(totalNestEgg);
            document.getElementById('yearsToRetirement').textContent = yearsToRetirement;
            document.getElementById('monthlyRetirementIncome').textContent = formatCurrency(desiredIncome / 12);
            document.getElementById('savingsShortfall').textContent = formatCurrency(shortfall);
            document.getElementById('successProbability').textContent = `${Math.round(successProbability)}%`;
            
            document.getElementById('requiredNestEgg').textContent = formatCurrency(requiredNestEgg);
            document.getElementById('projectedNestEgg').textContent = formatCurrency(totalNestEgg);
            document.getElementById('nestEggDifference').textContent = formatCurrency(shortfall);
            document.getElementById('retirementProgress').style.width = `${progressPercentage}%`;
            document.getElementById('progressText').textContent = `${Math.round(progressPercentage)}% of target`;
            
            // Generate recommendation
            let recommendation = '';
            if (shortfall > 0) {
                const additionalAnnual = shortfall / yearsToRetirement;
                recommendation = `To reach your retirement goal, consider increasing your annual contributions by ${formatCurrency(additionalAnnual)} or working ${Math.ceil(shortfall / (desiredIncome * 0.04))} additional years. `;
            } else {
                recommendation = 'Great! You are on track to meet your retirement goals. ';
            }
            recommendation += `Your current plan has a ${Math.round(successProbability)}% success probability.`;
            
            document.getElementById('retirementRecommendation').textContent = recommendation;
        }
        
        function calculateInvestmentValue(initial, monthly, years, returnRate) {
            const monthlyRate = returnRate / 100 / 12;
            const months = years * 12;
            
            let futureValue = initial * Math.pow(1 + monthlyRate, months);
            futureValue += monthly * (Math.pow(1 + monthlyRate, months) - 1) / monthlyRate;
            
            return futureValue;
        }
        
        function generateAmortizationTable(principal, monthlyRate, monthlyPayment, numberOfPayments) {
            const table = document.getElementById('amortizationTable');
            table.innerHTML = '';
            
            let balance = principal;
            
            for (let i = 1; i <= Math.min(12, numberOfPayments); i++) {
                const interestPayment = balance * monthlyRate;
                const principalPayment = monthlyPayment - interestPayment;
                balance -= principalPayment;
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${i}</td>
                    <td>${formatCurrency(monthlyPayment)}</td>
                    <td>${formatCurrency(principalPayment)}</td>
                    <td>${formatCurrency(interestPayment)}</td>
                    <td>${formatCurrency(balance)}</td>
                `;
                table.appendChild(row);
            }
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
        
        // Initialize calculations on page load
        window.addEventListener('load', function() {
            calculateLoan();
            calculateInvestment();
            calculateRetirement();
        });
    </script>
</body>
</html>