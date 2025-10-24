<?php
/**
 * Budget Calculator
 * File: budget-calculator.php
 * Description: Calculate monthly budget and track expenses (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Calculator - Monthly Budget Planner (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free budget calculator. Plan monthly budget with income and expenses tracking. Follow 50/30/20 rule for optimal budgeting. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>💰 Budget Calculator</h1>
        <p>Plan your monthly budget and track expenses</p>
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
                <h2>Income & Expenses</h2>
                <form id="budgetForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD ($)</option>
                            <option value="INR">INR (₹)</option>
                            <option value="EUR">EUR (€)</option>
                            <option value="GBP">GBP (£)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Monthly Income</h3>
                    
                    <div class="form-group">
                        <label for="salary">Salary (After Tax) (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="salary" value="5000" min="0" step="100" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="otherIncome">Other Income (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="otherIncome" value="0" min="0" step="50">
                        <small>Freelance, investments, etc.</small>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Needs (50%)</h3>
                    
                    <div class="form-group">
                        <label for="housing">Housing / Rent (<span id="currencyLabel3">$</span>)</label>
                        <input type="number" id="housing" value="1500" min="0" step="50">
                    </div>
                    
                    <div class="form-group">
                        <label for="utilities">Utilities (<span id="currencyLabel4">$</span>)</label>
                        <input type="number" id="utilities" value="200" min="0" step="10">
                        <small>Electric, water, gas, internet</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="groceries">Groceries (<span id="currencyLabel5">$</span>)</label>
                        <input type="number" id="groceries" value="400" min="0" step="10">
                    </div>
                    
                    <div class="form-group">
                        <label for="transportation">Transportation (<span id="currencyLabel6">$</span>)</label>
                        <input type="number" id="transportation" value="300" min="0" step="10">
                        <small>Gas, public transit, car payment</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="insurance">Insurance (<span id="currencyLabel7">$</span>)</label>
                        <input type="number" id="insurance" value="250" min="0" step="10">
                        <small>Health, auto, life insurance</small>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Wants (30%)</h3>
                    
                    <div class="form-group">
                        <label for="entertainment">Entertainment (<span id="currencyLabel8">$</span>)</label>
                        <input type="number" id="entertainment" value="200" min="0" step="10">
                        <small>Streaming, dining out, hobbies</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="shopping">Shopping (<span id="currencyLabel9">$</span>)</label>
                        <input type="number" id="shopping" value="150" min="0" step="10">
                        <small>Clothes, gadgets, non-essentials</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="travel">Travel / Vacation (<span id="currencyLabel10">$</span>)</label>
                        <input type="number" id="travel" value="100" min="0" step="10">
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Savings (20%)</h3>
                    
                    <div class="form-group">
                        <label for="savings">Savings / Investments (<span id="currencyLabel11">$</span>)</label>
                        <input type="number" id="savings" value="500" min="0" step="10">
                    </div>
                    
                    <div class="form-group">
                        <label for="debtPayment">Debt Payment (<span id="currencyLabel12">$</span>)</label>
                        <input type="number" id="debtPayment" value="300" min="0" step="10">
                        <small>Credit cards, loans</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Budget</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Budget Summary</h2>
                
                <div class="result-card success">
                    <h3>Budget Status</h3>
                    <div class="amount" id="budgetStatus">Balanced</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Income</h4>
                        <div class="value" id="totalIncome">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Expenses</h4>
                        <div class="value" id="totalExpenses">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Net Savings</h4>
                        <div class="value" id="netSavings">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Savings Rate</h4>
                        <div class="value" id="savingsRate">0%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Income Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Salary (After Tax)</span>
                        <strong id="salaryDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Income</span>
                        <strong id="otherIncomeDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Monthly Income</strong></span>
                        <strong id="totalIncomeDisplay" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Needs (Essential - 50%)</h3>
                    <div class="breakdown-item">
                        <span>Housing / Rent</span>
                        <strong id="housingDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Utilities</span>
                        <strong id="utilitiesDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Groceries</span>
                        <strong id="groceriesDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Transportation</span>
                        <strong id="transportationDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Insurance</span>
                        <strong id="insuranceDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Needs</strong></span>
                        <strong id="totalNeeds" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>% of Income</span>
                        <strong id="needsPercent">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Wants (Discretionary - 30%)</h3>
                    <div class="breakdown-item">
                        <span>Entertainment</span>
                        <strong id="entertainmentDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Shopping</span>
                        <strong id="shoppingDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Travel / Vacation</span>
                        <strong id="travelDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Wants</strong></span>
                        <strong id="totalWants" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>% of Income</span>
                        <strong id="wantsPercent">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Savings & Debt (20%)</h3>
                    <div class="breakdown-item">
                        <span>Savings / Investments</span>
                        <strong id="savingsDisplay" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Debt Payment</span>
                        <strong id="debtDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Savings</strong></span>
                        <strong id="totalSavingsDisplay" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>% of Income</span>
                        <strong id="savingsPercent">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>50/30/20 Rule Analysis</h3>
                    <div class="breakdown-item">
                        <span>Needs (Target: 50%)</span>
                        <strong id="needsTarget">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Wants (Target: 30%)</span>
                        <strong id="wantsTarget">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Savings (Target: 20%)</span>
                        <strong id="savingsTarget">0%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Budget Health</h3>
                    <div class="breakdown-item">
                        <span>Total Income</span>
                        <strong id="incomeTotal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Expenses</span>
                        <strong id="expensesTotal">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Surplus / Deficit</strong></span>
                        <strong id="surplusDeficit" style="font-size: 1.2em;">$0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>50/30/20 Rule:</strong> 50% needs (essentials), 30% wants (lifestyle), 20% savings (future). Adjust based on goals. Track expenses monthly. Cut wants before needs. Automate savings. Emergency fund = 3-6 months expenses. Pay high-interest debt first. Review budget quarterly.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('budgetForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateBudget();
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
            calculateBudget();
        });

        function calculateBudget() {
            const salary = parseFloat(document.getElementById('salary').value) || 0;
            const otherIncome = parseFloat(document.getElementById('otherIncome').value) || 0;
            const housing = parseFloat(document.getElementById('housing').value) || 0;
            const utilities = parseFloat(document.getElementById('utilities').value) || 0;
            const groceries = parseFloat(document.getElementById('groceries').value) || 0;
            const transportation = parseFloat(document.getElementById('transportation').value) || 0;
            const insurance = parseFloat(document.getElementById('insurance').value) || 0;
            const entertainment = parseFloat(document.getElementById('entertainment').value) || 0;
            const shopping = parseFloat(document.getElementById('shopping').value) || 0;
            const travel = parseFloat(document.getElementById('travel').value) || 0;
            const savings = parseFloat(document.getElementById('savings').value) || 0;
            const debtPayment = parseFloat(document.getElementById('debtPayment').value) || 0;
            const currency = currencySelect.value;

            // Calculate totals
            const totalIncome = salary + otherIncome;
            const totalNeeds = housing + utilities + groceries + transportation + insurance;
            const totalWants = entertainment + shopping + travel;
            const totalSavings = savings + debtPayment;
            const totalExpenses = totalNeeds + totalWants + totalSavings;
            const surplusDeficit = totalIncome - totalExpenses;
            const netSavings = surplusDeficit + totalSavings;

            // Percentages
            const needsPercent = totalIncome > 0 ? (totalNeeds / totalIncome) * 100 : 0;
            const wantsPercent = totalIncome > 0 ? (totalWants / totalIncome) * 100 : 0;
            const savingsPercent = totalIncome > 0 ? (totalSavings / totalIncome) * 100 : 0;
            const savingsRate = totalIncome > 0 ? (netSavings / totalIncome) * 100 : 0;

            // Budget status
            let budgetStatus = '';
            if (surplusDeficit > 0) {
                budgetStatus = 'Surplus 💰';
            } else if (surplusDeficit === 0) {
                budgetStatus = 'Balanced ⚖️';
            } else {
                budgetStatus = 'Deficit ⚠️';
            }

            // Update UI
            document.getElementById('budgetStatus').textContent = budgetStatus;
            document.getElementById('totalIncome').textContent = formatCurrency(totalIncome, currency);
            document.getElementById('totalExpenses').textContent = formatCurrency(totalExpenses, currency);
            document.getElementById('netSavings').textContent = formatCurrency(netSavings, currency);
            document.getElementById('savingsRate').textContent = savingsRate.toFixed(1) + '%';

            document.getElementById('salaryDisplay').textContent = formatCurrency(salary, currency);
            document.getElementById('otherIncomeDisplay').textContent = formatCurrency(otherIncome, currency);
            document.getElementById('totalIncomeDisplay').textContent = formatCurrency(totalIncome, currency);

            document.getElementById('housingDisplay').textContent = formatCurrency(housing, currency);
            document.getElementById('utilitiesDisplay').textContent = formatCurrency(utilities, currency);
            document.getElementById('groceriesDisplay').textContent = formatCurrency(groceries, currency);
            document.getElementById('transportationDisplay').textContent = formatCurrency(transportation, currency);
            document.getElementById('insuranceDisplay').textContent = formatCurrency(insurance, currency);
            document.getElementById('totalNeeds').textContent = formatCurrency(totalNeeds, currency);
            document.getElementById('needsPercent').textContent = needsPercent.toFixed(1) + '%';

            document.getElementById('entertainmentDisplay').textContent = formatCurrency(entertainment, currency);
            document.getElementById('shoppingDisplay').textContent = formatCurrency(shopping, currency);
            document.getElementById('travelDisplay').textContent = formatCurrency(travel, currency);
            document.getElementById('totalWants').textContent = formatCurrency(totalWants, currency);
            document.getElementById('wantsPercent').textContent = wantsPercent.toFixed(1) + '%';

            document.getElementById('savingsDisplay').textContent = formatCurrency(savings, currency);
            document.getElementById('debtDisplay').textContent = formatCurrency(debtPayment, currency);
            document.getElementById('totalSavingsDisplay').textContent = formatCurrency(totalSavings, currency);
            document.getElementById('savingsPercent').textContent = savingsPercent.toFixed(1) + '%';

            document.getElementById('needsTarget').textContent = needsPercent.toFixed(1) + '% (Target: 50%)';
            document.getElementById('wantsTarget').textContent = wantsPercent.toFixed(1) + '% (Target: 30%)';
            document.getElementById('savingsTarget').textContent = savingsPercent.toFixed(1) + '% (Target: 20%)';

            document.getElementById('incomeTotal').textContent = formatCurrency(totalIncome, currency);
            document.getElementById('expensesTotal').textContent = formatCurrency(totalExpenses, currency);
            document.getElementById('surplusDeficit').textContent = formatCurrency(surplusDeficit, currency);

            // Color code surplus/deficit
            const surplusElement = document.getElementById('surplusDeficit');
            if (surplusDeficit > 0) {
                surplusElement.style.color = '#4CAF50';
            } else if (surplusDeficit < 0) {
                surplusElement.style.color = '#f44336';
            } else {
                surplusElement.style.color = '#667eea';
            }
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
            calculateBudget();
        });
    </script>
</body>
</html>