<?php
/**
 * Break-Even Calculator
 * File: break-even-calculator.php
 * Description: Calculate business break-even point (USD/INR/EUR/GBP)
 */

$page_title = "Break-Even Calculator - Calculate Break-Even Point (USD/INR/EUR/GBP)";
$page_description = "Free break-even calculator. Calculate units and revenue needed to break even. Analyze fixed costs, variable costs, and pricing. USD, INR, EUR, GBP.";

include 'includes/header.php';
?>

<header>
    <h1>📊 Break-Even Calculator</h1>
    <p>Calculate when your business will break even</p>
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
            <h2>Business Costs & Pricing</h2>
            <form id="breakEvenForm">
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
                    <label for="fixedCosts">Fixed Costs (<span id="currencyLabel1">$</span>)</label>
                    <input type="number" id="fixedCosts" value="50000" min="0" step="100" required>
                    <small>Rent, salaries, insurance (monthly/annual)</small>
                </div>
                
                <div class="form-group">
                    <label for="variableCostPerUnit">Variable Cost per Unit (<span id="currencyLabel2">$</span>)</label>
                    <input type="number" id="variableCostPerUnit" value="20" min="0" step="0.01" required>
                    <small>Materials, labor, shipping per unit</small>
                </div>
                
                <div class="form-group">
                    <label for="pricePerUnit">Price per Unit (<span id="currencyLabel3">$</span>)</label>
                    <input type="number" id="pricePerUnit" value="50" min="0.01" step="0.01" required>
                    <small>Selling price per unit</small>
                </div>
                
                <div class="form-group">
                    <label for="targetProfit">Target Profit (<span id="currencyLabel4">$</span>)</label>
                    <input type="number" id="targetProfit" value="20000" min="0" step="1000">
                    <small>Desired profit (optional)</small>
                </div>
                
                <button type="submit" class="btn">Calculate Break-Even</button>
            </form>
        </div>

        <div class="results-section">
            <h2>Break-Even Analysis</h2>
            
            <div class="result-card success">
                <h3>Break-Even Units</h3>
                <div class="amount" id="breakEvenUnits">0</div>
            </div>

            <div class="metric-grid">
                <div class="metric-card">
                    <h4>Break-Even Revenue</h4>
                    <div class="value" id="breakEvenRevenue">$0</div>
                </div>
                <div class="metric-card">
                    <h4>Contribution Margin</h4>
                    <div class="value" id="contributionMargin">$0</div>
                </div>
                <div class="metric-card">
                    <h4>Margin %</h4>
                    <div class="value" id="marginPercent">0%</div>
                </div>
                <div class="metric-card">
                    <h4>Units for Target</h4>
                    <div class="value" id="targetUnits">0</div>
                </div>
            </div>

            <div class="breakdown">
                <h3>Cost Structure</h3>
                <div class="breakdown-item">
                    <span>Fixed Costs</span>
                    <strong id="fixedCostsDisplay">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Variable Cost per Unit</span>
                    <strong id="variableCostDisplay">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Price per Unit</span>
                    <strong id="priceDisplay">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Contribution Margin per Unit</span>
                    <strong id="contributionPerUnit" style="color: #4CAF50;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Contribution Margin %</span>
                    <strong id="contributionPercent" style="color: #667eea;">0%</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Break-Even Point</h3>
                <div class="breakdown-item">
                    <span>Units to Sell</span>
                    <strong id="unitsToSell" style="color: #667eea; font-size: 1.1em;">0 units</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Revenue Needed</span>
                    <strong id="revenueNeeded" style="color: #667eea;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Variable Costs</span>
                    <strong id="totalVariableCosts">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Costs (Fixed + Variable)</span>
                    <strong id="totalCosts">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Profit at Break-Even</span>
                    <strong id="profitBreakEven">$0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Target Profit Analysis</h3>
                <div class="breakdown-item">
                    <span>Target Profit</span>
                    <strong id="targetProfitDisplay">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Units Needed for Target</span>
                    <strong id="unitsForTarget" style="color: #4CAF50;">0 units</strong>
                </div>
                <div class="breakdown-item">
                    <span>Revenue for Target Profit</span>
                    <strong id="revenueForTarget" style="color: #4CAF50;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Additional Units Above Break-Even</span>
                    <strong id="additionalUnits">0 units</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Sales Scenarios</h3>
                <div class="breakdown-item">
                    <span>@ 50 units</span>
                    <strong id="scenario50" style="color: #f44336;">Loss: $0</strong>
                </div>
                <div class="breakdown-item">
                    <span>@ 100 units</span>
                    <strong id="scenario100">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>@ 500 units</span>
                    <strong id="scenario500" style="color: #4CAF50;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>@ 1000 units</span>
                    <strong id="scenario1000" style="color: #4CAF50;">$0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Break-Even Formula</h3>
                <div class="breakdown-item">
                    <span>Formula</span>
                    <strong>Fixed Costs ÷ (Price - Variable Cost)</strong>
                </div>
                <div class="breakdown-item">
                    <span>Your Calculation</span>
                    <strong id="formulaCalculation">50000 ÷ (50 - 20)</strong>
                </div>
                <div class="breakdown-item">
                    <span>Break-Even Units</span>
                    <strong id="formulaResult" style="color: #667eea;">0 units</strong>
                </div>
            </div>
            
            <div class="info-box">
                <strong>Break-Even Tips:</strong> Lower break-even = less risk. Increase price or decrease costs to improve. Contribution margin = profit per unit. Above break-even = profit zone. Monitor monthly. Fixed costs must be covered first. Economies of scale reduce variable costs. Analyze sensitivity to price changes.
            </div>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('breakEvenForm');
    const currencySelect = document.getElementById('currency');

    currencySelect.addEventListener('change', function() {
        updateCurrencyLabels();
        calculateBreakEven();
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
        for (let i = 1; i <= 4; i++) {
            document.getElementById('currencyLabel' + i).textContent = symbol;
        }
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        calculateBreakEven();
    });

    function calculateBreakEven() {
        const fixedCosts = parseFloat(document.getElementById('fixedCosts').value) || 0;
        const variableCostPerUnit = parseFloat(document.getElementById('variableCostPerUnit').value) || 0;
        const pricePerUnit = parseFloat(document.getElementById('pricePerUnit').value) || 1;
        const targetProfit = parseFloat(document.getElementById('targetProfit').value) || 0;
        const currency = currencySelect.value;

        // Calculate contribution margin
        const contributionMargin = pricePerUnit - variableCostPerUnit;
        const contributionMarginPercent = pricePerUnit > 0 ? (contributionMargin / pricePerUnit) * 100 : 0;

        // Break-even units
        const breakEvenUnits = contributionMargin > 0 ? Math.ceil(fixedCosts / contributionMargin) : 0;
        const breakEvenRevenue = breakEvenUnits * pricePerUnit;
        const totalVariableCosts = breakEvenUnits * variableCostPerUnit;
        const totalCosts = fixedCosts + totalVariableCosts;

        // Units for target profit
        const unitsForTarget = contributionMargin > 0 ? 
            Math.ceil((fixedCosts + targetProfit) / contributionMargin) : 0;
        const revenueForTarget = unitsForTarget * pricePerUnit;
        const additionalUnits = unitsForTarget - breakEvenUnits;

        // Sales scenarios
        function calculateProfit(units) {
            const revenue = units * pricePerUnit;
            const variableCosts = units * variableCostPerUnit;
            const profit = revenue - fixedCosts - variableCosts;
            return profit;
        }

        const profit50 = calculateProfit(50);
        const profit100 = calculateProfit(100);
        const profit500 = calculateProfit(500);
        const profit1000 = calculateProfit(1000);

        // Update UI
        document.getElementById('breakEvenUnits').textContent = breakEvenUnits.toLocaleString();
        document.getElementById('breakEvenRevenue').textContent = formatCurrency(breakEvenRevenue, currency);
        document.getElementById('contributionMargin').textContent = formatCurrency(contributionMargin, currency);
        document.getElementById('marginPercent').textContent = contributionMarginPercent.toFixed(1) + '%';
        document.getElementById('targetUnits').textContent = unitsForTarget.toLocaleString();

        document.getElementById('fixedCostsDisplay').textContent = formatCurrency(fixedCosts, currency);
        document.getElementById('variableCostDisplay').textContent = formatCurrency(variableCostPerUnit, currency);
        document.getElementById('priceDisplay').textContent = formatCurrency(pricePerUnit, currency);
        document.getElementById('contributionPerUnit').textContent = formatCurrency(contributionMargin, currency);
        document.getElementById('contributionPercent').textContent = contributionMarginPercent.toFixed(1) + '%';

        document.getElementById('unitsToSell').textContent = breakEvenUnits.toLocaleString() + ' units';
        document.getElementById('revenueNeeded').textContent = formatCurrency(breakEvenRevenue, currency);
        document.getElementById('totalVariableCosts').textContent = formatCurrency(totalVariableCosts, currency);
        document.getElementById('totalCosts').textContent = formatCurrency(totalCosts, currency);
        document.getElementById('profitBreakEven').textContent = formatCurrency(0, currency);

        document.getElementById('targetProfitDisplay').textContent = formatCurrency(targetProfit, currency);
        document.getElementById('unitsForTarget').textContent = unitsForTarget.toLocaleString() + ' units';
        document.getElementById('revenueForTarget').textContent = formatCurrency(revenueForTarget, currency);
        document.getElementById('additionalUnits').textContent = additionalUnits.toLocaleString() + ' units';

        // Scenarios
        document.getElementById('scenario50').textContent = 
            (profit50 < 0 ? 'Loss: ' : 'Profit: ') + formatCurrency(Math.abs(profit50), currency);
        document.getElementById('scenario50').style.color = profit50 < 0 ? '#f44336' : '#4CAF50';

        document.getElementById('scenario100').textContent = 
            (profit100 < 0 ? 'Loss: ' : 'Profit: ') + formatCurrency(Math.abs(profit100), currency);
        document.getElementById('scenario100').style.color = profit100 < 0 ? '#f44336' : '#4CAF50';

        document.getElementById('scenario500').textContent = 
            'Profit: ' + formatCurrency(profit500, currency);
        
        document.getElementById('scenario1000').textContent = 
            'Profit: ' + formatCurrency(profit1000, currency);

        // Formula
        document.getElementById('formulaCalculation').textContent = 
            `${fixedCosts} ÷ (${pricePerUnit} - ${variableCostPerUnit})`;
        document.getElementById('formulaResult').textContent = breakEvenUnits.toLocaleString() + ' units';
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
        calculateBreakEven();
    });
</script>

<?php include 'includes/footer.php'; ?>