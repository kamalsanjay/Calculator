<?php
/**
 * ROI Calculator
 * File: roi-calculator.php
 * Description: Calculate Return on Investment (USD/INR/EUR/GBP)
 */

$page_title = "ROI Calculator - Calculate Return on Investment (USD/INR/EUR/GBP)";
$page_description = "Free ROI calculator. Calculate return on investment percentage, profit, and payback period. Compare investment options. USD, INR, EUR, GBP.";

include 'includes/header.php';
?>

<header>
    <h1>📊 ROI Calculator</h1>
    <p>Calculate Return on Investment for any project or investment</p>
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
            <h2>Investment Details</h2>
            <form id="roiForm">
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
                    <label for="investmentCost">Investment Cost (<span id="currencyLabel1">$</span>)</label>
                    <input type="number" id="investmentCost" value="10000" min="1" step="100" required>
                    <small>Initial investment or cost</small>
                </div>
                
                <div class="form-group">
                    <label for="finalValue">Final Value / Return (<span id="currencyLabel2">$</span>)</label>
                    <input type="number" id="finalValue" value="15000" min="0" step="100" required>
                    <small>Total value received or returned</small>
                </div>
                
                <div class="form-group">
                    <label for="additionalCosts">Additional Costs (<span id="currencyLabel3">$</span>)</label>
                    <input type="number" id="additionalCosts" value="0" min="0" step="100">
                    <small>Fees, commissions, maintenance (optional)</small>
                </div>
                
                <div class="form-group">
                    <label for="timeHorizon">Investment Duration (Years)</label>
                    <input type="number" id="timeHorizon" value="3" min="0.1" max="50" step="0.1" required>
                    <small>Holding period</small>
                </div>
                
                <button type="submit" class="btn">Calculate ROI</button>
            </form>
        </div>

        <div class="results-section">
            <h2>ROI Results</h2>
            
            <div class="result-card success">
                <h3>Return on Investment</h3>
                <div class="amount" id="roiPercent">0%</div>
            </div>

            <div class="metric-grid">
                <div class="metric-card">
                    <h4>Total Gain/Loss</h4>
                    <div class="value" id="totalGain">$0</div>
                </div>
                <div class="metric-card">
                    <h4>Annualized ROI</h4>
                    <div class="value" id="annualizedROI">0%</div>
                </div>
                <div class="metric-card">
                    <h4>Total Investment</h4>
                    <div class="value" id="totalInvestment">$0</div>
                </div>
                <div class="metric-card">
                    <h4>Payback Period</h4>
                    <div class="value" id="paybackPeriod">0 yrs</div>
                </div>
            </div>

            <div class="breakdown">
                <h3>Investment Summary</h3>
                <div class="breakdown-item">
                    <span>Initial Investment</span>
                    <strong id="initialInvestment">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Additional Costs</span>
                    <strong id="additionalCostsDisplay">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Investment Cost</span>
                    <strong id="totalCost" style="color: #667eea;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Final Value</span>
                    <strong id="finalValueDisplay">$0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>ROI Calculation</h3>
                <div class="breakdown-item">
                    <span>Total Investment</span>
                    <strong id="investmentAmount">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Final Return</span>
                    <strong id="finalReturn">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Net Gain/Loss</span>
                    <strong id="netGain" style="color: #4CAF50;">$0</strong>
                </div>
                <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                    <span><strong>ROI Percentage</strong></span>
                    <strong id="roiPercentage" style="color: #667eea; font-size: 1.2em;">0%</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Performance Metrics</h3>
                <div class="breakdown-item">
                    <span>Holding Period</span>
                    <strong id="holdingPeriod">3 years</strong>
                </div>
                <div class="breakdown-item">
                    <span>ROI (Total Return)</span>
                    <strong id="totalROI">0%</strong>
                </div>
                <div class="breakdown-item">
                    <span>Annualized ROI</span>
                    <strong id="annualROI" style="color: #667eea;">0%</strong>
                </div>
                <div class="breakdown-item">
                    <span>Return Multiple</span>
                    <strong id="returnMultiple">0x</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Annual Breakdown</h3>
                <div class="breakdown-item">
                    <span>Average Annual Gain</span>
                    <strong id="avgAnnualGain">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Average Annual Return %</span>
                    <strong id="avgAnnualReturn">0%</strong>
                </div>
                <div class="breakdown-item">
                    <span>Monthly Return (avg)</span>
                    <strong id="monthlyReturn">$0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>ROI Rating</h3>
                <div id="roiRating" style="padding: 20px; background: #f8f9fa; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2em; margin-bottom: 10px;" id="ratingIcon">📊</div>
                    <div style="font-size: 1.3em; color: #667eea; font-weight: 600;" id="ratingText">Calculate to see rating</div>
                    <div style="margin-top: 10px; color: #666;" id="ratingDescription">Enter values and calculate</div>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>ROI Formula</h3>
                <div class="breakdown-item">
                    <span>Formula</span>
                    <strong>ROI = (Gain - Cost) / Cost × 100</strong>
                </div>
                <div class="breakdown-item">
                    <span>Your Calculation</span>
                    <strong id="formulaCalculation">(15000 - 10000) / 10000 × 100</strong>
                </div>
                <div class="breakdown-item">
                    <span>Result</span>
                    <strong id="formulaResult" style="color: #4CAF50;">50%</strong>
                </div>
            </div>
            
            <div class="info-box">
                <strong>ROI Tips:</strong> Positive ROI = profitable investment. Higher ROI = better return. Compare ROI across investments. Consider time value of money (annualized ROI). Factor in all costs. Risk-adjusted ROI matters. ROI >10% annually is typically good. Real estate ~8-12%, stocks ~10%, bonds ~5%.
            </div>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('roiForm');
    const currencySelect = document.getElementById('currency');

    currencySelect.addEventListener('change', function() {
        updateCurrencyLabels();
        calculateROI();
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
        for (let i = 1; i <= 3; i++) {
            document.getElementById('currencyLabel' + i).textContent = symbol;
        }
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        calculateROI();
    });

    function calculateROI() {
        const investmentCost = parseFloat(document.getElementById('investmentCost').value) || 0;
        const finalValue = parseFloat(document.getElementById('finalValue').value) || 0;
        const additionalCosts = parseFloat(document.getElementById('additionalCosts').value) || 0;
        const years = parseFloat(document.getElementById('timeHorizon').value) || 3;
        const currency = currencySelect.value;

        // Calculate total investment
        const totalInvestment = investmentCost + additionalCosts;

        // Calculate ROI
        const netGain = finalValue - totalInvestment;
        const roiPercent = totalInvestment > 0 ? (netGain / totalInvestment) * 100 : 0;

        // Annualized ROI
        const annualizedROI = years > 0 ? roiPercent / years : roiPercent;

        // Return multiple
        const returnMultiple = totalInvestment > 0 ? finalValue / totalInvestment : 0;

        // Payback period (simplified)
        const paybackPeriod = roiPercent > 0 ? 100 / roiPercent : 0;

        // Annual averages
        const avgAnnualGain = years > 0 ? netGain / years : netGain;
        const avgAnnualReturn = annualizedROI;
        const monthlyReturn = avgAnnualGain / 12;

        // ROI Rating
        let ratingIcon = '📊';
        let ratingText = 'Average';
        let ratingDescription = 'Moderate return';
        let ratingColor = '#FF9800';

        if (roiPercent < 0) {
            ratingIcon = '❌';
            ratingText = 'Negative Return';
            ratingDescription = 'Loss on investment';
            ratingColor = '#f44336';
        } else if (roiPercent < 5) {
            ratingIcon = '📉';
            ratingText = 'Poor';
            ratingDescription = 'Below inflation';
            ratingColor = '#f44336';
        } else if (roiPercent < 10) {
            ratingIcon = '📊';
            ratingText = 'Fair';
            ratingDescription = 'Below market average';
            ratingColor = '#FF9800';
        } else if (roiPercent < 20) {
            ratingIcon = '📈';
            ratingText = 'Good';
            ratingDescription = 'Above market average';
            ratingColor = '#4CAF50';
        } else if (roiPercent < 50) {
            ratingIcon = '🚀';
            ratingText = 'Excellent';
            ratingDescription = 'Strong performance';
            ratingColor = '#4CAF50';
        } else {
            ratingIcon = '🏆';
            ratingText = 'Outstanding';
            ratingDescription = 'Exceptional returns';
            ratingColor = '#4CAF50';
        }

        // Update UI
        document.getElementById('roiPercent').textContent = roiPercent.toFixed(2) + '%';
        document.getElementById('totalGain').textContent = formatCurrency(netGain, currency);
        document.getElementById('annualizedROI').textContent = annualizedROI.toFixed(2) + '%';
        document.getElementById('totalInvestment').textContent = formatCurrency(totalInvestment, currency);
        document.getElementById('paybackPeriod').textContent = paybackPeriod.toFixed(1) + ' yrs';

        document.getElementById('initialInvestment').textContent = formatCurrency(investmentCost, currency);
        document.getElementById('additionalCostsDisplay').textContent = formatCurrency(additionalCosts, currency);
        document.getElementById('totalCost').textContent = formatCurrency(totalInvestment, currency);
        document.getElementById('finalValueDisplay').textContent = formatCurrency(finalValue, currency);

        document.getElementById('investmentAmount').textContent = formatCurrency(totalInvestment, currency);
        document.getElementById('finalReturn').textContent = formatCurrency(finalValue, currency);
        document.getElementById('netGain').textContent = formatCurrency(netGain, currency);
        document.getElementById('roiPercentage').textContent = roiPercent.toFixed(2) + '%';

        document.getElementById('holdingPeriod').textContent = years + ' years';
        document.getElementById('totalROI').textContent = roiPercent.toFixed(2) + '%';
        document.getElementById('annualROI').textContent = annualizedROI.toFixed(2) + '%';
        document.getElementById('returnMultiple').textContent = returnMultiple.toFixed(2) + 'x';

        document.getElementById('avgAnnualGain').textContent = formatCurrency(avgAnnualGain, currency);
        document.getElementById('avgAnnualReturn').textContent = avgAnnualReturn.toFixed(2) + '%';
        document.getElementById('monthlyReturn').textContent = formatCurrency(monthlyReturn, currency);

        // Update rating
        document.getElementById('ratingIcon').textContent = ratingIcon;
        document.getElementById('ratingText').textContent = ratingText;
        document.getElementById('ratingText').style.color = ratingColor;
        document.getElementById('ratingDescription').textContent = ratingDescription;

        // Update formula
        document.getElementById('formulaCalculation').textContent = 
            `(${finalValue} - ${totalInvestment}) / ${totalInvestment} × 100`;
        document.getElementById('formulaResult').textContent = roiPercent.toFixed(2) + '%';
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
        calculateROI();
    });
</script>

<?php include 'includes/footer.php'; ?>