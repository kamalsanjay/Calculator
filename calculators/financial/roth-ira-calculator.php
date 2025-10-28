<?php
/**
 * Roth IRA Calculator
 * File: roth-ira-calculator.php
 * Description: Calculate Roth IRA retirement savings with tax-free growth (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roth IRA Calculator - Calculate Tax-Free Retirement (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free Roth IRA calculator. Calculate tax-free retirement savings with compound growth. Compare Traditional vs Roth IRA. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128181; Roth IRA Calculator</h1>
        <p>Calculate tax-free retirement savings</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Roth IRA Details</h2>
                <form id="rothForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select id="currency">
                            <option value="USD">USD (&#36;)</option>
                            <option value="INR">INR (&#8377;)</option>
                            <option value="EUR">EUR (&#8364;)</option>
                            <option value="GBP">GBP (&#163;)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentAge">Current Age</label>
                        <input type="number" id="currentAge" value="30" min="18" max="100" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="retirementAge">Retirement Age</label>
                        <input type="number" id="retirementAge" value="65" min="18" max="100" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentBalance">Current Roth IRA Balance (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="currentBalance" value="10000" min="0" step="1000">
                    </div>
                    
                    <div class="form-group">
                        <label for="annualContribution">Annual Contribution (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="annualContribution" value="6500" min="0" step="100" required>
                        <small>2024 limit: $6,500 (under 50), $7,500 (50+)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="contributionIncrease">Annual Contribution Increase (%)</label>
                        <input type="number" id="contributionIncrease" value="2" min="0" max="20" step="0.5">
                        <small>Increase contributions each year</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="returnRate">Expected Annual Return (%)</label>
                        <input type="number" id="returnRate" value="8" min="0" max="30" step="0.1" required>
                        <small>Historical avg: 7-10% for stock funds</small>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Tax Comparison</h3>
                    
                    <div class="form-group">
                        <label for="currentTaxRate">Current Tax Rate (%)</label>
                        <input type="number" id="currentTaxRate" value="22" min="0" max="50" step="1">
                        <small>For Traditional IRA comparison</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="retirementTaxRate">Expected Retirement Tax Rate (%)</label>
                        <input type="number" id="retirementTaxRate" value="22" min="0" max="50" step="1">
                        <small>Tax rate when withdrawing</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Roth IRA</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Roth IRA Projection</h2>
                
                <div class="result-card success">
                    <h3>Tax-Free Balance at Retirement</h3>
                    <div class="amount" id="finalBalance">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Contributions</h4>
                        <div class="value" id="totalContributions">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Tax-Free Earnings</h4>
                        <div class="value" id="totalEarnings">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Years to Retirement</h4>
                        <div class="value" id="yearsToRetirement">35</div>
                    </div>
                    <div class="metric-card">
                        <h4>Tax Savings vs Traditional</h4>
                        <div class="value" id="taxSavings">$0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Retirement Summary</h3>
                    <div class="breakdown-item">
                        <span>Current Age</span>
                        <strong id="ageDisplay">30</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Retirement Age</span>
                        <strong id="retireAgeDisplay">65</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Years Until Retirement</span>
                        <strong id="yearsDisplay" style="color: #667eea;">35 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Account Type</span>
                        <strong id="accountType">Roth IRA (Tax-Free)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Account Growth</h3>
                    <div class="breakdown-item">
                        <span>Starting Balance</span>
                        <strong id="startBalance">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Contributions</span>
                        <strong id="contributionsTotal" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Investment Growth</span>
                        <strong id="investmentGrowth" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Tax-Free Balance at 65</strong></span>
                        <strong id="finalBalanceDisplay" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Roth IRA Benefits</h3>
                    <div class="breakdown-item">
                        <span>Balance at Retirement</span>
                        <strong id="rothBalance">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax Owed on Withdrawals</span>
                        <strong id="rothTax" style="color: #4CAF50;">$0 (TAX-FREE!)</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>After-Tax Value</strong></span>
                        <strong id="rothAfterTax" style="color: #4CAF50; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Traditional IRA Comparison</h3>
                    <div class="breakdown-item">
                        <span>Traditional IRA Balance</span>
                        <strong id="traditionalBalance">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax Owed at Retirement</span>
                        <strong id="traditionalTax" style="color: #f44336;">-$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After-Tax Value (Traditional)</span>
                        <strong id="traditionalAfterTax">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #4CAF50; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Roth IRA Advantage</strong></span>
                        <strong id="rothAdvantage" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Contribution Strategy</h3>
                    <div class="breakdown-item">
                        <span>Starting Annual Contribution</span>
                        <strong id="startContribution">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual Increase</span>
                        <strong id="contribIncrease">2%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Final Year Contribution</span>
                        <strong id="finalContribution">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Annual Contribution</span>
                        <strong id="avgContribution">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Investment Performance</h3>
                    <div class="breakdown-item">
                        <span>Expected Annual Return</span>
                        <strong id="returnDisplay">8%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Amount Invested</span>
                        <strong id="totalInvested">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Growth</span>
                        <strong id="totalGrowth" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Return Multiple</span>
                        <strong id="returnMultiple" style="color: #667eea;">0x</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Retirement Income (4% Rule)</h3>
                    <div class="breakdown-item">
                        <span>Annual Withdrawal (4%)</span>
                        <strong id="annualWithdrawal" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Income (Tax-Free)</span>
                        <strong id="monthlyIncome" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Traditional IRA Monthly Income</span>
                        <strong id="traditionalMonthly">$0 (after tax)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Income Advantage</span>
                        <strong id="incomeAdvantage" style="color: #4CAF50;">$0 more/month</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Milestone Balances</h3>
                    <div class="breakdown-item">
                        <span>At Age 40</span>
                        <strong id="balance40">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At Age 50</span>
                        <strong id="balance50">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At Age 60</span>
                        <strong id="balance60">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At Age 65 (Retirement)</span>
                        <strong id="balance65" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Roth IRA vs Traditional IRA</h3>
                    <div class="breakdown-item">
                        <span>Roth: Pay Tax Now</span>
                        <strong id="rothTaxNow" style="color: #f44336;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Roth: Tax in Retirement</span>
                        <strong id="rothTaxRetirement" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Traditional: Tax Savings Now</span>
                        <strong id="traditionalTaxNow" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Traditional: Tax in Retirement</span>
                        <strong id="traditionalTaxRetirement" style="color: #f44336;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Roth IRA Tips:</strong> Contributions NOT tax deductible. Withdrawals 100% tax-free in retirement. Can withdraw contributions anytime. Earnings tax-free after 59½. No required distributions (unlike Traditional). Income limits apply. Better if expecting higher tax rate. Tax-free growth = huge advantage. Backdoor Roth for high earners. Max early: $6,500 (2024), $7,500 if 50+. 5-year rule for conversions. Estate planning benefit. Consider Roth 401(k) too. Long-term = more tax savings. Review annually.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('rothForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateRoth();
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
            for (let i = 1; i <= 2; i++) {
                document.getElementById('currencyLabel' + i).textContent = symbol;
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateRoth();
        });

        function calculateRoth() {
            const currentAge = parseInt(document.getElementById('currentAge').value) || 30;
            const retirementAge = parseInt(document.getElementById('retirementAge').value) || 65;
            const currentBalance = parseFloat(document.getElementById('currentBalance').value) || 0;
            const annualContribution = parseFloat(document.getElementById('annualContribution').value) || 0;
            const contributionIncrease = parseFloat(document.getElementById('contributionIncrease').value) / 100 || 0;
            const returnRate = parseFloat(document.getElementById('returnRate').value) / 100 || 0.08;
            const currentTaxRate = parseFloat(document.getElementById('currentTaxRate').value) / 100 || 0.22;
            const retirementTaxRate = parseFloat(document.getElementById('retirementTaxRate').value) / 100 || 0.22;
            const currency = currencySelect.value;

            const years = retirementAge - currentAge;

            // Calculate year-by-year
            let balance = currentBalance;
            let totalContributions = 0;
            let contribution = annualContribution;
            let balance40 = 0, balance50 = 0, balance60 = 0;

            for (let year = 1; year <= years; year++) {
                const currentAgeInYear = currentAge + year;
                
                balance = balance * (1 + returnRate) + contribution;
                totalContributions += contribution;
                contribution = contribution * (1 + contributionIncrease);

                if (currentAgeInYear === 40) balance40 = balance;
                if (currentAgeInYear === 50) balance50 = balance;
                if (currentAgeInYear === 60) balance60 = balance;
            }

            const finalBalance = balance;
            const totalEarnings = finalBalance - currentBalance - totalContributions;

            // Traditional IRA comparison
            const traditionalBalance = finalBalance; // Same growth
            const traditionalTaxOwed = traditionalBalance * retirementTaxRate;
            const traditionalAfterTax = traditionalBalance - traditionalTaxOwed;

            // Roth advantages
            const rothAdvantage = finalBalance - traditionalAfterTax;
            const taxSavings = traditionalTaxOwed;

            // Contributions analysis
            const finalYearContrib = annualContribution * Math.pow(1 + contributionIncrease, years - 1);
            const avgContribution = totalContributions / years;

            // Total invested
            const totalInvested = currentBalance + totalContributions;
            const returnMultiple = totalInvested > 0 ? (finalBalance / totalInvested) : 0;

            // Retirement income (4% rule)
            const annualWithdrawal = finalBalance * 0.04;
            const monthlyIncome = annualWithdrawal / 12;
            const traditionalMonthly = (traditionalAfterTax * 0.04) / 12;
            const incomeAdvantage = monthlyIncome - traditionalMonthly;

            // Tax comparison
            const rothTaxNow = totalContributions * currentTaxRate; // Paid from other income
            const rothTaxRetirement = 0; // Tax-free!
            const traditionalTaxNow = totalContributions * currentTaxRate; // Saved
            const traditionalTaxRetirement = traditionalTaxOwed;

            // Analysis
            let analysis = `By contributing ${formatCurrency(annualContribution, currency)} annually to a Roth IRA for ${years} years, you will accumulate ${formatCurrency(finalBalance, currency)} - completely TAX-FREE. `;
            analysis += `Your total contributions of ${formatCurrency(totalContributions, currency)} will grow to include ${formatCurrency(totalEarnings, currency)} in tax-free earnings. `;
            
            if (rothAdvantage > 0) {
                analysis += `Compared to a Traditional IRA, the Roth saves you ${formatCurrency(taxSavings, currency)} in retirement taxes, giving you ${formatCurrency(rothAdvantage, currency)} more spending power. `;
            }
            
            analysis += `Using the 4% rule, you can withdraw ${formatCurrency(monthlyIncome, currency)} per month tax-free in retirement.`;

            // Update UI
            document.getElementById('finalBalance').textContent = formatCurrency(finalBalance, currency);
            document.getElementById('totalContributions').textContent = formatCurrency(totalContributions, currency);
            document.getElementById('totalEarnings').textContent = formatCurrency(totalEarnings, currency);
            document.getElementById('yearsToRetirement').textContent = years;
            document.getElementById('taxSavings').textContent = formatCurrency(taxSavings, currency);

            document.getElementById('ageDisplay').textContent = currentAge;
            document.getElementById('retireAgeDisplay').textContent = retirementAge;
            document.getElementById('yearsDisplay').textContent = years + ' years';

            document.getElementById('startBalance').textContent = formatCurrency(currentBalance, currency);
            document.getElementById('contributionsTotal').textContent = formatCurrency(totalContributions, currency);
            document.getElementById('investmentGrowth').textContent = formatCurrency(totalEarnings, currency);
            document.getElementById('finalBalanceDisplay').textContent = formatCurrency(finalBalance, currency);

            document.getElementById('rothBalance').textContent = formatCurrency(finalBalance, currency);
            document.getElementById('rothAfterTax').textContent = formatCurrency(finalBalance, currency);

            document.getElementById('traditionalBalance').textContent = formatCurrency(traditionalBalance, currency);
            document.getElementById('traditionalTax').textContent = formatCurrency(traditionalTaxOwed, currency);
            document.getElementById('traditionalAfterTax').textContent = formatCurrency(traditionalAfterTax, currency);
            document.getElementById('rothAdvantage').textContent = formatCurrency(rothAdvantage, currency);

            document.getElementById('startContribution').textContent = formatCurrency(annualContribution, currency);
            document.getElementById('contribIncrease').textContent = (contributionIncrease * 100).toFixed(1) + '% annually';
            document.getElementById('finalContribution').textContent = formatCurrency(finalYearContrib, currency);
            document.getElementById('avgContribution').textContent = formatCurrency(avgContribution, currency);

            document.getElementById('returnDisplay').textContent = (returnRate * 100).toFixed(1) + '% annually';
            document.getElementById('totalInvested').textContent = formatCurrency(totalInvested, currency);
            document.getElementById('totalGrowth').textContent = formatCurrency(totalEarnings, currency);
            document.getElementById('returnMultiple').textContent = returnMultiple.toFixed(2) + 'x';

            document.getElementById('annualWithdrawal').textContent = formatCurrency(annualWithdrawal, currency);
            document.getElementById('monthlyIncome').textContent = formatCurrency(monthlyIncome, currency);
            document.getElementById('traditionalMonthly').textContent = formatCurrency(traditionalMonthly, currency);
            document.getElementById('incomeAdvantage').textContent = formatCurrency(incomeAdvantage, currency) + ' more/month';

            document.getElementById('balance40').textContent = formatCurrency(balance40, currency);
            document.getElementById('balance50').textContent = formatCurrency(balance50, currency);
            document.getElementById('balance60').textContent = formatCurrency(balance60, currency);
            document.getElementById('balance65').textContent = formatCurrency(finalBalance, currency);

            document.getElementById('rothTaxNow').textContent = formatCurrency(rothTaxNow, currency);
            document.getElementById('rothTaxRetirement').textContent = formatCurrency(0, currency);
            document.getElementById('traditionalTaxNow').textContent = formatCurrency(traditionalTaxNow, currency);
            document.getElementById('traditionalTaxRetirement').textContent = formatCurrency(traditionalTaxRetirement, currency);

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
            calculateRoth();
        });
    </script>
</body>
</html>