<?php
/**
 * Dividend Calculator
 * File: dividend-calculator.php
 * Description: Calculate dividend income and reinvestment growth (USD/INR/EUR/GBP)
 */

$page_title = "Dividend Calculator - Calculate Dividend Income (USD/INR/EUR/GBP)";
$page_description = "Free dividend calculator. Calculate dividend income, yield, and DRIP reinvestment growth. Track passive income from dividend stocks. USD, INR, EUR, GBP.";

include 'includes/header.php';
?>

<header>
    <h1>💰 Dividend Calculator</h1>
    <p>Calculate dividend income and reinvestment returns</p>
</header>

<div class="container">
    <div class="breadcrumb">
        <a href="index.php">← Back to Financial Calculators</a>
    </div>

    <div class="calculator-wrapper">
        <div class="calculator-section">
            <h2>Dividend Investment</h2>
            <form id="dividendForm">
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
                    <label for="investment">Initial Investment (<span id="currencyLabel1">$</span>)</label>
                    <input type="number" id="investment" value="50000" min="1000" step="1000" required>
                </div>
                
                <div class="form-group">
                    <label for="sharePrice">Share Price (<span id="currencyLabel2">$</span>)</label>
                    <input type="number" id="sharePrice" value="100" min="1" step="1" required>
                </div>
                
                <div class="form-group">
                    <label for="dividendYield">Annual Dividend Yield (%)</label>
                    <input type="number" id="dividendYield" value="4" min="0" max="20" step="0.1" required>
                    <small>Current dividend yield</small>
                </div>
                
                <div class="form-group">
                    <label for="dividendGrowth">Annual Dividend Growth Rate (%)</label>
                    <input type="number" id="dividendGrowth" value="5" min="0" max="20" step="0.1">
                    <small>Expected yearly dividend increase</small>
                </div>
                
                <div class="form-group">
                    <label for="priceAppreciation">Stock Price Appreciation (%)</label>
                    <input type="number" id="priceAppreciation" value="6" min="-10" max="30" step="0.1">
                    <small>Expected annual price growth</small>
                </div>
                
                <div class="form-group">
                    <label for="reinvest">Reinvest Dividends?</label>
                    <select id="reinvest">
                        <option value="yes" selected>Yes - DRIP (Dividend Reinvestment)</option>
                        <option value="no">No - Take as Income</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="years">Investment Period (Years)</label>
                    <input type="number" id="years" value="20" min="1" max="50" step="1" required>
                </div>
                
                <button type="submit" class="btn">Calculate Dividends</button>
            </form>
        </div>

        <div class="results-section">
            <h2>Dividend Analysis</h2>
            
            <div class="result-card success">
                <h3>Total Value After Period</h3>
                <div class="amount" id="totalValue">$0</div>
            </div>

            <div class="metric-grid">
                <div class="metric-card">
                    <h4>Total Dividends</h4>
                    <div class="value" id="totalDividends">$0</div>
                </div>
                <div class="metric-card">
                    <h4>Annual Dividend Income</h4>
                    <div class="value" id="annualIncome">$0</div>
                </div>
                <div class="metric-card">
                    <h4>Total Gain</h4>
                    <div class="value" id="totalGain">$0</div>
                </div>
                <div class="metric-card">
                    <h4>Total Return %</h4>
                    <div class="value" id="totalReturn">0%</div>
                </div>
            </div>

            <div class="breakdown">
                <h3>Initial Position</h3>
                <div class="breakdown-item">
                    <span>Initial Investment</span>
                    <strong id="initialInvestment">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Share Price</span>
                    <strong id="sharePriceDisplay">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Number of Shares</span>
                    <strong id="initialShares">0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Dividend Yield</span>
                    <strong id="yieldDisplay">0%</strong>
                </div>
                <div class="breakdown-item">
                    <span>Annual Dividend (Year 1)</span>
                    <strong id="firstYearDividend" style="color: #4CAF50;">$0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>End Position</h3>
                <div class="breakdown-item">
                    <span>Final Share Price</span>
                    <strong id="finalSharePrice">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Shares Owned</span>
                    <strong id="finalShares" style="color: #4CAF50;">0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Portfolio Value</span>
                    <strong id="portfolioValue" style="color: #667eea; font-size: 1.1em;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Annual Dividend Income (Final Year)</span>
                    <strong id="finalYearDividend" style="color: #4CAF50;">$0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Dividend Summary</h3>
                <div class="breakdown-item">
                    <span>Total Dividends Received</span>
                    <strong id="totalDividendsReceived" style="color: #4CAF50;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Dividends Reinvested</span>
                    <strong id="dividendsReinvested">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Additional Shares from DRIP</span>
                    <strong id="dripShares">0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Returns Breakdown</h3>
                <div class="breakdown-item">
                    <span>Initial Investment</span>
                    <strong id="investmentAmount">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Price Appreciation</span>
                    <strong id="priceGain" style="color: #4CAF50;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Dividend Income/Growth</span>
                    <strong id="dividendGain" style="color: #4CAF50;">$0</strong>
                </div>
                <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                    <span><strong>Total Portfolio Value</strong></span>
                    <strong id="finalValue" style="color: #667eea; font-size: 1.2em;">$0</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Performance Metrics</h3>
                <div class="breakdown-item">
                    <span>Total Return</span>
                    <strong id="returnPercent">0%</strong>
                </div>
                <div class="breakdown-item">
                    <span>CAGR (Annualized)</span>
                    <strong id="cagr" style="color: #667eea;">0%</strong>
                </div>
                <div class="breakdown-item">
                    <span>Yield on Cost (YOC)</span>
                    <strong id="yieldOnCost" style="color: #4CAF50;">0%</strong>
                </div>
                <div class="breakdown-item">
                    <span>Return Multiple</span>
                    <strong id="returnMultiple">0x</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Monthly Income (Final Year)</h3>
                <div class="breakdown-item">
                    <span>Monthly Dividend Income</span>
                    <strong id="monthlyIncome" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Quarterly Dividend</span>
                    <strong id="quarterlyIncome">$0</strong>
                </div>
            </div>
            
            <div class="info-box">
                <strong>Dividend Investing Tips:</strong> DRIP accelerates wealth with compound growth. Dividend aristocrats = 25+ years of increases. Focus on sustainable payout ratios (<60%). Diversify across sectors. Yield on Cost increases over time. Consider tax implications. Reinvest early for maximum compounding.
            </div>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('dividendForm');
    const currencySelect = document.getElementById('currency');

    currencySelect.addEventListener('change', function() {
        updateCurrencyLabels();
        calculateDividends();
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
        document.getElementById('currencyLabel1').textContent = symbol;
        document.getElementById('currencyLabel2').textContent = symbol;
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        calculateDividends();
    });

    function calculateDividends() {
        const investment = parseFloat(document.getElementById('investment').value) || 0;
        const sharePrice = parseFloat(document.getElementById('sharePrice').value) || 100;
        const dividendYield = parseFloat(document.getElementById('dividendYield').value) / 100 || 0.04;
        const dividendGrowth = parseFloat(document.getElementById('dividendGrowth').value) / 100 || 0.05;
        const priceAppreciation = parseFloat(document.getElementById('priceAppreciation').value) / 100 || 0.06;
        const reinvest = document.getElementById('reinvest').value === 'yes';
        const years = parseInt(document.getElementById('years').value) || 20;
        const currency = currencySelect.value;

        // Initial shares
        let shares = investment / sharePrice;
        let currentPrice = sharePrice;
        let totalDividends = 0;
        let totalReinvested = 0;
        let additionalShares = 0;

        // Year-by-year calculation
        for (let year = 1; year <= years; year++) {
            // Calculate dividend for this year
            const dividendPerShare = currentPrice * dividendYield * Math.pow(1 + dividendGrowth, year - 1);
            const yearDividend = shares * dividendPerShare;
            totalDividends += yearDividend;

            // Reinvest if DRIP
            if (reinvest) {
                const newShares = yearDividend / currentPrice;
                shares += newShares;
                totalReinvested += yearDividend;
                additionalShares += newShares;
            }

            // Update share price
            currentPrice = currentPrice * (1 + priceAppreciation);
        }

        // Final calculations
        const finalSharePrice = sharePrice * Math.pow(1 + priceAppreciation, years);
        const portfolioValue = shares * finalSharePrice;
        const totalGain = portfolioValue - investment;
        const totalReturn = (totalGain / investment) * 100;
        const cagr = (Math.pow(portfolioValue / investment, 1 / years) - 1) * 100;
        const returnMultiple = portfolioValue / investment;

        // Final year dividend
        const finalDividendPerShare = finalSharePrice * dividendYield * Math.pow(1 + dividendGrowth, years - 1);
        const finalYearDividend = shares * finalDividendPerShare;
        const monthlyIncome = finalYearDividend / 12;
        const quarterlyIncome = finalYearDividend / 4;

        // Yield on Cost
        const yieldOnCost = (finalYearDividend / investment) * 100;

        // First year dividend
        const firstYearDividend = (investment / sharePrice) * (sharePrice * dividendYield);

        // Price gain vs dividend gain
        const priceGain = (shares * finalSharePrice) - (shares * sharePrice);
        const dividendGain = reinvest ? totalReinvested * (finalSharePrice / sharePrice) : totalDividends;

        // Update UI
        document.getElementById('totalValue').textContent = formatCurrency(portfolioValue, currency);
        document.getElementById('totalDividends').textContent = formatCurrency(totalDividends, currency);
        document.getElementById('annualIncome').textContent = formatCurrency(finalYearDividend, currency);
        document.getElementById('totalGain').textContent = formatCurrency(totalGain, currency);
        document.getElementById('totalReturn').textContent = totalReturn.toFixed(2) + '%';

        document.getElementById('initialInvestment').textContent = formatCurrency(investment, currency);
        document.getElementById('sharePriceDisplay').textContent = formatCurrency(sharePrice, currency);
        document.getElementById('initialShares').textContent = (investment / sharePrice).toFixed(2);
        document.getElementById('yieldDisplay').textContent = (dividendYield * 100).toFixed(2) + '%';
        document.getElementById('firstYearDividend').textContent = formatCurrency(firstYearDividend, currency);

        document.getElementById('finalSharePrice').textContent = formatCurrency(finalSharePrice, currency);
        document.getElementById('finalShares').textContent = shares.toFixed(2);
        document.getElementById('portfolioValue').textContent = formatCurrency(portfolioValue, currency);
        document.getElementById('finalYearDividend').textContent = formatCurrency(finalYearDividend, currency);

        document.getElementById('totalDividendsReceived').textContent = formatCurrency(totalDividends, currency);
        document.getElementById('dividendsReinvested').textContent = formatCurrency(totalReinvested, currency);
        document.getElementById('dripShares').textContent = additionalShares.toFixed(2);

        document.getElementById('investmentAmount').textContent = formatCurrency(investment, currency);
        document.getElementById('priceGain').textContent = formatCurrency(priceGain, currency);
        document.getElementById('dividendGain').textContent = formatCurrency(dividendGain, currency);
        document.getElementById('finalValue').textContent = formatCurrency(portfolioValue, currency);

        document.getElementById('returnPercent').textContent = totalReturn.toFixed(2) + '%';
        document.getElementById('cagr').textContent = cagr.toFixed(2) + '%';
        document.getElementById('yieldOnCost').textContent = yieldOnCost.toFixed(2) + '%';
        document.getElementById('returnMultiple').textContent = returnMultiple.toFixed(2) + 'x';

        document.getElementById('monthlyIncome').textContent = formatCurrency(monthlyIncome, currency);
        document.getElementById('quarterlyIncome').textContent = formatCurrency(quarterlyIncome, currency);
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
        calculateDividends();
    });
</script>

<?php include 'includes/footer.php'; ?>