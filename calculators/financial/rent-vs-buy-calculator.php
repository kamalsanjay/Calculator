<?php
/**
 * Rent vs Buy Calculator
 * File: rent-vs-buy-calculator.php
 * Description: Compare renting vs buying a home (USD/INR/EUR/GBP)
 */

$page_title = "Rent vs Buy Calculator - Should I Rent or Buy? (USD/INR/EUR/GBP)";
$page_description = "Free rent vs buy calculator. Compare renting versus buying a home over time. Factor in mortgage, rent, appreciation, and opportunity costs. USD, INR, EUR, GBP.";

include 'includes/header.php';
?>

<header>
    <h1>🏠 Rent vs Buy Calculator</h1>
    <p>Compare the true cost of renting versus buying a home</p>
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
            <h2>Compare Rent vs Buy</h2>
            <form id="rentBuyForm">
                <div class="form-group">
                    <label for="currency">Currency</label>
                    <select id="currency">
                        <option value="USD">USD ($)</option>
                        <option value="INR">INR (₹)</option>
                        <option value="EUR">EUR (€)</option>
                        <option value="GBP">GBP (£)</option>
                    </select>
                </div>
                
                <h3 style="color: #667eea; margin: 25px 0 15px;">Buying Scenario</h3>
                
                <div class="form-group">
                    <label for="homePrice">Home Price (<span id="currencyLabel1">$</span>)</label>
                    <input type="number" id="homePrice" value="300000" min="50000" step="5000" required>
                </div>
                
                <div class="form-group">
                    <label for="downPayment">Down Payment (<span id="currencyLabel2">$</span>)</label>
                    <input type="number" id="downPayment" value="60000" min="0" step="5000" required>
                </div>
                
                <div class="form-group">
                    <label for="mortgageRate">Mortgage Rate (%)</label>
                    <input type="number" id="mortgageRate" value="7" min="1" max="15" step="0.1" required>
                </div>
                
                <div class="form-group">
                    <label for="propertyTax">Annual Property Tax (<span id="currencyLabel3">$</span>)</label>
                    <input type="number" id="propertyTax" value="3000" min="0" step="100">
                </div>
                
                <div class="form-group">
                    <label for="maintenance">Annual Maintenance (<span id="currencyLabel4">$</span>)</label>
                    <input type="number" id="maintenance" value="3000" min="0" step="100">
                    <small>Typically 1% of home value</small>
                </div>
                
                <div class="form-group">
                    <label for="appreciation">Home Appreciation Rate (%)</label>
                    <input type="number" id="appreciation" value="3" min="0" max="10" step="0.1">
                </div>
                
                <h3 style="color: #667eea; margin: 25px 0 15px;">Renting Scenario</h3>
                
                <div class="form-group">
                    <label for="monthlyRent">Monthly Rent (<span id="currencyLabel5">$</span>)</label>
                    <input type="number" id="monthlyRent" value="1800" min="500" step="50" required>
                </div>
                
                <div class="form-group">
                    <label for="rentIncrease">Annual Rent Increase (%)</label>
                    <input type="number" id="rentIncrease" value="3" min="0" max="10" step="0.1">
                </div>
                
                <div class="form-group">
                    <label for="yearsToCompare">Years to Compare</label>
                    <input type="number" id="yearsToCompare" value="5" min="1" max="30" step="1" required>
                </div>
                
                <button type="submit" class="btn">Compare Rent vs Buy</button>
            </form>
        </div>

        <div class="results-section">
            <h2>Cost Comparison</h2>
            
            <div class="result-card success">
                <h3 id="recommendationTitle">Better Option</h3>
                <div class="amount" id="recommendation">Calculate</div>
            </div>

            <div class="metric-grid">
                <div class="metric-card">
                    <h4>Total Cost to Buy</h4>
                    <div class="value" id="totalBuyCost">$0</div>
                </div>
                <div class="metric-card">
                    <h4>Total Cost to Rent</h4>
                    <div class="value" id="totalRentCost">$0</div>
                </div>
                <div class="metric-card">
                    <h4>Home Equity Built</h4>
                    <div class="value" id="equityBuilt">$0</div>
                </div>
                <div class="metric-card">
                    <h4>Net Difference</h4>
                    <div class="value" id="netDifference">$0</div>
                </div>
            </div>

            <div class="breakdown">
                <h3>Buying Costs</h3>
                <div class="breakdown-item">
                    <span>Down Payment</span>
                    <strong id="downPaymentDisplay">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Monthly Mortgage Payment</span>
                    <strong id="mortgagePayment">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Mortgage Payments</span>
                    <strong id="totalMortgage">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Property Tax</span>
                    <strong id="totalPropertyTax">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Maintenance</span>
                    <strong id="totalMaintenance">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Closing Costs (3%)</span>
                    <strong id="closingCosts">$0</strong>
                </div>
                <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                    <span><strong>Total Cost to Buy</strong></span>
                    <strong id="buyTotal" style="color: #667eea; font-size: 1.1em;">$0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Renting Costs</h3>
                <div class="breakdown-item">
                    <span>Starting Monthly Rent</span>
                    <strong id="startingRent">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Rent Increase Rate</span>
                    <strong id="rentIncreaseRate">0%</strong>
                </div>
                <div class="breakdown-item">
                    <span>Security Deposit (1 month)</span>
                    <strong id="securityDeposit">$0</strong>
                </div>
                <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                    <span><strong>Total Cost to Rent</strong></span>
                    <strong id="rentTotal" style="color: #667eea; font-size: 1.1em;">$0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Home Ownership Benefits</h3>
                <div class="breakdown-item">
                    <span>Home Value After Period</span>
                    <strong id="futureHomeValue" style="color: #4CAF50;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Remaining Mortgage</span>
                    <strong id="remainingMortgage">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Home Equity Built</span>
                    <strong id="homeEquity" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Net Cost Analysis</h3>
                <div class="breakdown-item">
                    <span>Buy: Total Cost - Equity</span>
                    <strong id="netBuyCost">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Rent: Total Cost</span>
                    <strong id="netRentCost">$0</strong>
                </div>
                <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                    <span><strong>Difference (Rent - Buy)</strong></span>
                    <strong id="finalDifference" style="color: #667eea; font-size: 1.2em;">$0</strong>
                </div>
            </div>
            
            <div class="info-box">
                <strong>Rent vs Buy Factors:</strong> Buying builds equity and wealth. Renting offers flexibility. Consider: job stability, local market, down payment ready, maintenance comfort, tax benefits (mortgage interest deduction), break-even typically 3-5 years.
            </div>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('rentBuyForm');
    const currencySelect = document.getElementById('currency');

    currencySelect.addEventListener('change', function() {
        updateCurrencyLabels();
        calculateRentVsBuy();
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
        calculateRentVsBuy();
    });

    function calculateRentVsBuy() {
        const homePrice = parseFloat(document.getElementById('homePrice').value) || 0;
        const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
        const mortgageRate = parseFloat(document.getElementById('mortgageRate').value) / 100 || 0;
        const propertyTax = parseFloat(document.getElementById('propertyTax').value) || 0;
        const maintenance = parseFloat(document.getElementById('maintenance').value) || 0;
        const appreciation = parseFloat(document.getElementById('appreciation').value) / 100 || 0;
        const monthlyRent = parseFloat(document.getElementById('monthlyRent').value) || 0;
        const rentIncrease = parseFloat(document.getElementById('rentIncrease').value) / 100 || 0;
        const years = parseInt(document.getElementById('yearsToCompare').value) || 5;
        const currency = currencySelect.value;

        // Buying calculations
        const loanAmount = homePrice - downPayment;
        const monthlyRate = mortgageRate / 12;
        const numberOfPayments = 30 * 12; // 30-year mortgage
        
        let mortgagePayment = 0;
        if (monthlyRate > 0) {
            mortgagePayment = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)) /
                            (Math.pow(1 + monthlyRate, numberOfPayments) - 1);
        } else {
            mortgagePayment = loanAmount / numberOfPayments;
        }

        const totalMortgagePayments = mortgagePayment * (years * 12);
        const totalPropertyTax = propertyTax * years;
        const totalMaintenance = maintenance * years;
        const closingCosts = homePrice * 0.03;
        const totalBuyCost = downPayment + totalMortgagePayments + totalPropertyTax + totalMaintenance + closingCosts;

        // Calculate remaining mortgage balance after years
        let balance = loanAmount;
        for (let i = 0; i < years * 12; i++) {
            const interest = balance * monthlyRate;
            const principal = mortgagePayment - interest;
            balance -= principal;
        }
        const remainingMortgage = Math.max(0, balance);

        // Home appreciation
        const futureHomeValue = homePrice * Math.pow(1 + appreciation, years);
        const homeEquity = futureHomeValue - remainingMortgage;

        // Renting calculations
        let totalRentCost = monthlyRent; // Security deposit
        let currentRent = monthlyRent;
        
        for (let year = 0; year < years; year++) {
            totalRentCost += currentRent * 12;
            currentRent = currentRent * (1 + rentIncrease);
        }

        // Net cost analysis
        const netBuyCost = totalBuyCost - homeEquity;
        const netRentCost = totalRentCost;
        const difference = netRentCost - netBuyCost;

        // Recommendation
        let recommendation = '';
        let recommendationTitle = '';
        if (difference > 0) {
            recommendation = 'Buying is Better';
            recommendationTitle = 'Buy Saves ' + formatCurrency(Math.abs(difference), currency);
        } else {
            recommendation = 'Renting is Better';
            recommendationTitle = 'Rent Saves ' + formatCurrency(Math.abs(difference), currency);
        }

        // Update UI
        document.getElementById('recommendation').textContent = recommendation;
        document.getElementById('recommendationTitle').textContent = recommendationTitle;
        document.getElementById('totalBuyCost').textContent = formatCurrency(totalBuyCost, currency);
        document.getElementById('totalRentCost').textContent = formatCurrency(totalRentCost, currency);
        document.getElementById('equityBuilt').textContent = formatCurrency(homeEquity, currency);
        document.getElementById('netDifference').textContent = formatCurrency(Math.abs(difference), currency);

        document.getElementById('downPaymentDisplay').textContent = formatCurrency(downPayment, currency);
        document.getElementById('mortgagePayment').textContent = formatCurrency(mortgagePayment, currency);
        document.getElementById('totalMortgage').textContent = formatCurrency(totalMortgagePayments, currency);
        document.getElementById('totalPropertyTax').textContent = formatCurrency(totalPropertyTax, currency);
        document.getElementById('totalMaintenance').textContent = formatCurrency(totalMaintenance, currency);
        document.getElementById('closingCosts').textContent = formatCurrency(closingCosts, currency);
        document.getElementById('buyTotal').textContent = formatCurrency(totalBuyCost, currency);

        document.getElementById('startingRent').textContent = formatCurrency(monthlyRent, currency);
        document.getElementById('rentIncreaseRate').textContent = (rentIncrease * 100).toFixed(1) + '%';
        document.getElementById('securityDeposit').textContent = formatCurrency(monthlyRent, currency);
        document.getElementById('rentTotal').textContent = formatCurrency(totalRentCost, currency);

        document.getElementById('futureHomeValue').textContent = formatCurrency(futureHomeValue, currency);
        document.getElementById('remainingMortgage').textContent = formatCurrency(remainingMortgage, currency);
        document.getElementById('homeEquity').textContent = formatCurrency(homeEquity, currency);

        document.getElementById('netBuyCost').textContent = formatCurrency(netBuyCost, currency);
        document.getElementById('netRentCost').textContent = formatCurrency(netRentCost, currency);
        document.getElementById('finalDifference').textContent = formatCurrency(difference, currency);
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
        calculateRentVsBuy();
    });
</script>

<?php include 'includes/footer.php'; ?>