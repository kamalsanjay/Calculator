<?php
/**
 * Emergency Fund Calculator
 * File: emergency-fund-calculator.php
 * Description: Calculate how much emergency fund you need based on expenses and financial situation
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Fund Calculator - Financial Safety Net Planning</title>
    <meta name="description" content="Emergency Fund Calculator. Calculate how much emergency savings you need based on monthly expenses, income stability, and financial goals.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>💰 Emergency Fund Calculator</h1>
        <p>Calculate your financial safety net and build your emergency savings</p>
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
            background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
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
            color: #FF6B35;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #F7931E;
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
            color: #FF6B35;
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
            border-color: #FF6B35;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #888;
            font-size: 0.9em;
        }
        
        .btn {
            background: #FF6B35;
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
            background: #F7931E;
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
        
        .excellent {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .good {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }
        
        .fair {
            background: linear-gradient(135deg, #FFC107 0%, #FFA000 100%);
        }
        
        .poor {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        }
        
        .critical {
            background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
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
            color: #FF6B35;
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
            color: #FF6B35;
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
            border-left: 4px solid #FF6B35;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box strong {
            color: #F7931E;
        }
        
        .scenario-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .scenario-option {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .scenario-option.active {
            background: #FF6B35;
            color: white;
            border-color: #F7931E;
        }
        
        .income-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .income-option {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .income-option.active {
            background: #FF6B35;
            color: white;
            border-color: #F7931E;
        }
        
        .expense-categories {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .expense-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .expense-item:last-child {
            border-bottom: none;
        }
        
        .expense-input {
            width: 120px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: right;
        }
        
        .savings-plan {
            background: #e8f5e9;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .plan-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #c8e6c9;
        }
        
        .plan-item:last-child {
            border-bottom: none;
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
            background: linear-gradient(90deg, #4CAF50, #2196F3, #FFC107, #f44336);
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
        
        .priority-list {
            background: #fff3e0;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .priority-item {
            display: flex;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid #ffe0b2;
        }
        
        .priority-item:last-child {
            border-bottom: none;
        }
        
        .priority-number {
            background: #FF6B35;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 12px;
            flex-shrink: 0;
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
            
            .scenario-options,
            .income-options {
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
                <h2>Financial Information</h2>
                <form id="emergencyFundForm">
                    <div class="form-group">
                        <label>Emergency Fund Scenario</label>
                        <div class="scenario-options">
                            <div class="scenario-option active" data-scenario="basic">
                                <strong>Basic Safety Net</strong>
                                <div>3 months expenses</div>
                            </div>
                            <div class="scenario-option" data-scenario="standard">
                                <strong>Standard Safety Net</strong>
                                <div>6 months expenses</div>
                            </div>
                            <div class="scenario-option" data-scenario="extended">
                                <strong>Extended Safety Net</strong>
                                <div>12 months expenses</div>
                            </div>
                        </div>
                        <input type="hidden" id="fundScenario" value="basic">
                    </div>
                    
                    <div class="form-group">
                        <label>Income Stability</label>
                        <div class="income-options">
                            <div class="income-option active" data-stability="stable">
                                <strong>Stable Income</strong>
                                <div>Secure job, regular income</div>
                            </div>
                            <div class="income-option" data-stability="variable">
                                <strong>Variable Income</strong>
                                <div>Freelance, commission, seasonal</div>
                            </div>
                        </div>
                        <input type="hidden" id="incomeStability" value="stable">
                    </div>
                    
                    <div class="form-group">
                        <label for="monthlyIncome">Monthly Take-Home Income</label>
                        <input type="number" id="monthlyIncome" value="4000" min="500" max="100000" step="100" required>
                        <small>After taxes and deductions</small>
                    </div>
                    
                    <div class="expense-categories">
                        <h3 style="color: #FF6B35; margin-bottom: 15px;">Monthly Essential Expenses</h3>
                        
                        <div class="expense-item">
                            <span>Housing (Rent/Mortgage)</span>
                            <input type="number" class="expense-input" id="housingExpense" value="1200" min="0" step="50">
                        </div>
                        
                        <div class="expense-item">
                            <span>Utilities & Bills</span>
                            <input type="number" class="expense-input" id="utilitiesExpense" value="300" min="0" step="10">
                        </div>
                        
                        <div class="expense-item">
                            <span>Food & Groceries</span>
                            <input type="number" class="expense-input" id="foodExpense" value="600" min="0" step="10">
                        </div>
                        
                        <div class="expense-item">
                            <span>Transportation</span>
                            <input type="number" class="expense-input" id="transportExpense" value="400" min="0" step="10">
                        </div>
                        
                        <div class="expense-item">
                            <span>Healthcare & Insurance</span>
                            <input type="number" class="expense-input" id="healthcareExpense" value="300" min="0" step="10">
                        </div>
                        
                        <div class="expense-item">
                            <span>Debt Payments</span>
                            <input type="number" class="expense-input" id="debtExpense" value="500" min="0" step="10">
                        </div>
                        
                        <div class="expense-item">
                            <span>Other Essentials</span>
                            <input type="number" class="expense-input" id="otherExpense" value="200" min="0" step="10">
                        </div>
                        
                        <div class="expense-item" style="border-top: 2px solid #FF6B35; padding-top: 15px; margin-top: 10px;">
                            <span><strong>Total Monthly Expenses</strong></span>
                            <strong id="totalExpensesDisplay">$3,500</strong>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentSavings">Current Emergency Savings</label>
                        <input type="number" id="currentSavings" value="2000" min="0" max="1000000" step="100" required>
                        <small>Amount you currently have saved for emergencies</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="monthlySavings">Monthly Savings Contribution</label>
                        <input type="number" id="monthlySavings" value="300" min="0" max="10000" step="10" required>
                        <small>How much you can save each month for emergency fund</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="dependents">Number of Dependents</label>
                        <input type="number" id="dependents" value="0" min="0" max="10" step="1" required>
                        <small>People who rely on your income</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Emergency Fund</button>
                </form>
                
                <div class="breakdown" style="margin-top: 30px;">
                    <h3>Emergency Fund Guidelines</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Basic Safety Net (3 months):</strong> Minimum for single income, stable job, no dependents</p>
                        <p><strong>Standard Safety Net (6 months):</strong> Recommended for most households, variable income, or 1-2 dependents</p>
                        <p><strong>Extended Safety Net (12 months):</strong> Business owners, commission-based, high dependents, or specialized careers</p>
                        <p><strong>Additional Factors:</strong> Add 1 month per dependent, +3 months for variable income, +25% for high cost of living area</p>
                    </div>
                </div>
            </div>

            <div class="results-section">
                <h2>Emergency Fund Analysis</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Recommended Emergency Fund</h3>
                    <div class="amount" id="recommendedFund">$10,500</div>
                    <div class="category" id="fundDuration">3 Months Expenses</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Current Savings</h4>
                        <div class="value" id="currentSavingsValue">$2,000</div>
                    </div>
                    <div class="metric-card">
                        <h4>Additional Needed</h4>
                        <div class="value" id="additionalNeeded">$8,500</div>
                    </div>
                    <div class="metric-card">
                        <h4>Months to Goal</h4>
                        <div class="value" id="monthsToGoal">28</div>
                    </div>
                    <div class="metric-card">
                        <h4>Safety Level</h4>
                        <div class="value" id="safetyLevel">Fair</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Fund Calculation Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Total Monthly Expenses</span>
                        <strong id="breakdownExpenses">$3,500</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Recommended Duration</span>
                        <strong id="breakdownDuration">3 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Base Emergency Fund</span>
                        <strong id="baseFund">$10,500</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Dependents Adjustment</span>
                        <strong id="dependentsAdjustment">+$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Income Stability Adjustment</span>
                        <strong id="incomeAdjustment">+$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #FF6B35; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Recommended Fund</strong></span>
                        <strong id="totalRecommended" style="font-size: 1.1em;">$10,500</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Current Progress</h3>
                    <div class="breakdown-item">
                        <span>Current Savings</span>
                        <strong id="progressCurrent">$2,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Target Fund</span>
                        <strong id="progressTarget">$10,500</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Progress</span>
                        <strong id="progressPercent">19%</strong>
                    </div>
                    <div class="progress-meter">
                        <div class="progress-level" id="progressBar" style="width: 19%; background: #FF6B35;"></div>
                    </div>
                </div>

                <div class="savings-plan">
                    <h3 style="color: #2E7D32; margin-bottom: 15px;">Savings Plan Timeline</h3>
                    <div class="plan-item">
                        <span>Monthly Savings</span>
                        <strong id="planMonthly">$300</strong>
                    </div>
                    <div class="plan-item">
                        <span>Time to Complete Fund</span>
                        <strong id="planTimeline">28 months</strong>
                    </div>
                    <div class="plan-item">
                        <span>Accelerated Timeline (15% more)</span>
                        <strong id="planAccelerated">24 months</strong>
                    </div>
                    <div class="plan-item">
                        <span>Completion Date</span>
                        <strong id="planCompletion">December 2025</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Monthly Savings Impact</h3>
                    <table class="timeline-chart">
                        <thead>
                            <tr>
                                <th>Savings Rate</th>
                                <th>Time to Goal</th>
                                <th>Monthly Impact</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Current ($300)</td>
                                <td id="timelineCurrent">28 months</td>
                                <td>Manageable</td>
                            </tr>
                            <tr>
                                <td>+25% ($375)</td>
                                <td id="timelinePlus25">22 months</td>
                                <td>Moderate</td>
                            </tr>
                            <tr>
                                <td>+50% ($450)</td>
                                <td id="timelinePlus50">19 months</td>
                                <td>Significant</td>
                            </tr>
                            <tr>
                                <td>Double ($600)</td>
                                <td id="timelineDouble">14 months</td>
                                <td>Major</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="priority-list">
                    <h3 style="color: #FF6B35; margin-bottom: 15px;">Priority Action Steps</h3>
                    <div class="priority-item">
                        <div class="priority-number">1</div>
                        <div>
                            <strong>Build Basic 1-Month Fund First</strong><br>
                            <span>Focus on saving $3,500 as immediate priority</span>
                        </div>
                    </div>
                    <div class="priority-item">
                        <div class="priority-number">2</div>
                        <div>
                            <strong>Reduce Non-Essential Spending</strong><br>
                            <span>Identify areas to increase monthly savings rate</span>
                        </div>
                    </div>
                    <div class="priority-item">
                        <div class="priority-number">3</div>
                        <div>
                            <strong>Explore Additional Income</strong><br>
                            <span>Consider side income to accelerate savings</span>
                        </div>
                    </div>
                    <div class="priority-item">
                        <div class="priority-number">4</div>
                        <div>
                            <strong>Review Insurance Coverage</strong><br>
                            <span>Ensure adequate health, disability, and life insurance</span>
                        </div>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Risk Assessment</h3>
                    <div id="riskAssessment" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="riskText" style="margin: 0;">With 19% of your recommended emergency fund saved, you have some financial protection but remain vulnerable to unexpected expenses or income loss. Focus on building your basic 1-month fund as immediate priority.</p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Emergency Fund Tips:</strong> Keep emergency fund in separate high-yield savings account. Only use for true emergencies: job loss, medical bills, major repairs. 3-6 months expenses recommended for most people. Include only essential expenses in calculation. Review and update annually or after life changes. Consider laddering CDs for portion of large emergency funds. Don't invest emergency money in stocks. Automate monthly transfers to emergency fund. Celebrate milestones (1 month, 3 months saved). Emergency fund reduces need for high-interest debt during crises. Separate from other savings goals. Consider health insurance deductibles and out-of-pocket maximums in your calculation.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('emergencyFundForm');
        const scenarioOptions = document.querySelectorAll('.scenario-option');
        const incomeOptions = document.querySelectorAll('.income-option');
        const expenseInputs = document.querySelectorAll('.expense-input');
        
        // Update total expenses in real-time
        expenseInputs.forEach(input => {
            input.addEventListener('input', function() {
                updateTotalExpenses();
                calculateEmergencyFund();
            });
        });
        
        // Scenario option selection
        scenarioOptions.forEach(option => {
            option.addEventListener('click', function() {
                scenarioOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('fundScenario').value = this.dataset.scenario;
                calculateEmergencyFund();
            });
        });
        
        // Income stability selection
        incomeOptions.forEach(option => {
            option.addEventListener('click', function() {
                incomeOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('incomeStability').value = this.dataset.stability;
                calculateEmergencyFund();
            });
        });
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateEmergencyFund();
        });

        function updateTotalExpenses() {
            let totalExpenses = 0;
            expenseInputs.forEach(input => {
                totalExpenses += parseFloat(input.value) || 0;
            });
            
            document.getElementById('totalExpensesDisplay').textContent = formatCurrency(totalExpenses);
        }

        function calculateEmergencyFund() {
            const scenario = document.getElementById('fundScenario').value;
            const incomeStability = document.getElementById('incomeStability').value;
            const monthlyIncome = parseFloat(document.getElementById('monthlyIncome').value) || 0;
            const currentSavings = parseFloat(document.getElementById('currentSavings').value) || 0;
            const monthlySavings = parseFloat(document.getElementById('monthlySavings').value) || 0;
            const dependents = parseInt(document.getElementById('dependents').value) || 0;
            
            // Calculate total monthly expenses
            let totalMonthlyExpenses = 0;
            expenseInputs.forEach(input => {
                totalMonthlyExpenses += parseFloat(input.value) || 0;
            });
            
            // Determine base months needed
            let baseMonths = 3;
            switch(scenario) {
                case 'basic':
                    baseMonths = 3;
                    break;
                case 'standard':
                    baseMonths = 6;
                    break;
                case 'extended':
                    baseMonths = 12;
                    break;
            }
            
            // Adjust for income stability
            let stabilityAdjustment = 0;
            if (incomeStability === 'variable') {
                stabilityAdjustment = 3; // Add 3 months for variable income
            }
            
            // Adjust for dependents
            const dependentsAdjustment = dependents; // Add 1 month per dependent
            
            // Calculate total months needed
            const totalMonthsNeeded = baseMonths + stabilityAdjustment + dependentsAdjustment;
            
            // Calculate recommended emergency fund
            const baseFund = totalMonthlyExpenses * baseMonths;
            const stabilityAddition = totalMonthlyExpenses * stabilityAdjustment;
            const dependentsAddition = totalMonthlyExpenses * dependentsAdjustment;
            const recommendedFund = baseFund + stabilityAddition + dependentsAddition;
            
            // Calculate additional needed
            const additionalNeeded = Math.max(0, recommendedFund - currentSavings);
            
            // Calculate months to reach goal
            const monthsToGoal = monthlySavings > 0 ? Math.ceil(additionalNeeded / monthlySavings) : 999;
            
            // Determine safety level
            let safetyLevel = '';
            let safetyClass = '';
            const coverageRatio = currentSavings / totalMonthlyExpenses;
            
            if (coverageRatio >= totalMonthsNeeded) {
                safetyLevel = 'Excellent';
                safetyClass = 'excellent';
            } else if (coverageRatio >= totalMonthsNeeded * 0.75) {
                safetyLevel = 'Good';
                safetyClass = 'good';
            } else if (coverageRatio >= totalMonthsNeeded * 0.5) {
                safetyLevel = 'Fair';
                safetyClass = 'fair';
            } else if (coverageRatio >= totalMonthsNeeded * 0.25) {
                safetyLevel = 'Poor';
                safetyClass = 'poor';
            } else {
                safetyLevel = 'Critical';
                safetyClass = 'critical';
            }
            
            // Calculate progress percentage
            const progressPercent = Math.min(100, Math.round((currentSavings / recommendedFund) * 100));
            
            // Calculate alternative timelines
            const timelinePlus25 = monthlySavings > 0 ? Math.ceil(additionalNeeded / (monthlySavings * 1.25)) : 999;
            const timelinePlus50 = monthlySavings > 0 ? Math.ceil(additionalNeeded / (monthlySavings * 1.5)) : 999;
            const timelineDouble = monthlySavings > 0 ? Math.ceil(additionalNeeded / (monthlySavings * 2)) : 999;
            
            // Calculate completion date
            const today = new Date();
            const completionDate = new Date(today);
            completionDate.setMonth(today.getMonth() + monthsToGoal);
            const completionText = completionDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            
            // Risk assessment text
            let riskText = '';
            if (coverageRatio >= 6) {
                riskText = 'Your emergency fund provides excellent financial protection. You are well-prepared for most unexpected financial challenges.';
            } else if (coverageRatio >= 3) {
                riskText = 'Your emergency fund provides good basic protection. Consider continuing to build toward 6 months for optimal security.';
            } else if (coverageRatio >= 1) {
                riskText = 'You have some emergency savings but remain vulnerable to extended income loss. Focus on building to at least 3 months of expenses.';
            } else {
                riskText = 'Your emergency savings are insufficient for basic financial protection. Prioritize building at least 1 month of essential expenses immediately.';
            }
            
            // Update UI
            const card = document.getElementById('resultCard');
            card.className = `result-card ${safetyClass}`;
            
            document.getElementById('recommendedFund').textContent = formatCurrency(recommendedFund);
            document.getElementById('fundDuration').textContent = `${totalMonthsNeeded} Months Coverage`;
            
            document.getElementById('currentSavingsValue').textContent = formatCurrency(currentSavings);
            document.getElementById('additionalNeeded').textContent = formatCurrency(additionalNeeded);
            document.getElementById('monthsToGoal').textContent = monthsToGoal > 100 ? '100+' : monthsToGoal;
            document.getElementById('safetyLevel').textContent = safetyLevel;
            
            document.getElementById('breakdownExpenses').textContent = formatCurrency(totalMonthlyExpenses);
            document.getElementById('breakdownDuration').textContent = `${baseMonths} months`;
            document.getElementById('baseFund').textContent = formatCurrency(baseFund);
            document.getElementById('dependentsAdjustment').textContent = `+${formatCurrency(dependentsAddition)}`;
            document.getElementById('incomeAdjustment').textContent = `+${formatCurrency(stabilityAddition)}`;
            document.getElementById('totalRecommended').textContent = formatCurrency(recommendedFund);
            
            document.getElementById('progressCurrent').textContent = formatCurrency(currentSavings);
            document.getElementById('progressTarget').textContent = formatCurrency(recommendedFund);
            document.getElementById('progressPercent').textContent = `${progressPercent}%`;
            document.getElementById('progressBar').style.width = `${progressPercent}%`;
            
            document.getElementById('planMonthly').textContent = formatCurrency(monthlySavings);
            document.getElementById('planTimeline').textContent = `${monthsToGoal} months`;
            document.getElementById('planAccelerated').textContent = `${timelinePlus25} months`;
            document.getElementById('planCompletion').textContent = completionText;
            
            document.getElementById('timelineCurrent').textContent = `${monthsToGoal} months`;
            document.getElementById('timelinePlus25').textContent = `${timelinePlus25} months`;
            document.getElementById('timelinePlus50').textContent = `${timelinePlus50} months`;
            document.getElementById('timelineDouble').textContent = `${timelineDouble} months`;
            
            document.getElementById('riskText').textContent = riskText;
        }

        function formatCurrency(amount) {
            return '$' + amount.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        window.addEventListener('load', function() {
            updateTotalExpenses();
            calculateEmergencyFund();
        });
    </script>
</body>
</html>
