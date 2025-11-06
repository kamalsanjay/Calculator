<?php
/**
 * Mutual Fund Calculator
 * File: mutual-fund-calculator.php
 * Description: Calculate mutual fund returns with SIP and lumpsum (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutual Fund Calculator - SIP & Lumpsum Returns (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free mutual fund calculator. Calculate SIP and lumpsum investment returns with compound growth. Compare investment strategies. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128200; Mutual Fund Calculator</h1>
        <p>Calculate SIP and lumpsum investment returns</p>
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
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
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
            <a href="index.php">&larr; Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Investment Details</h2>
                <form id="mfForm">
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
                        <label for="investmentType">Investment Type</label>
                        <select id="investmentType">
                            <option value="sip">SIP (Systematic Investment Plan)</option>
                            <option value="lumpsum">Lumpsum Investment</option>
                            <option value="both">Both SIP + Lumpsum</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="sipAmountGroup">
                        <label for="sipAmount">Monthly SIP Amount (<span id="currencyLabel1">$</span>)</label>
                        <input type="number" id="sipAmount" value="500" min="0" step="50">
                    </div>
                    
                    <div class="form-group" id="lumpsumAmountGroup">
                        <label for="lumpsumAmount">Lumpsum Amount (<span id="currencyLabel2">$</span>)</label>
                        <input type="number" id="lumpsumAmount" value="10000" min="0" step="1000">
                    </div>
                    
                    <div class="form-group">
                        <label for="investmentPeriod">Investment Period (Years)</label>
                        <input type="number" id="investmentPeriod" value="10" min="1" max="50" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="expectedReturn">Expected Annual Return (%)</label>
                        <input type="number" id="expectedReturn" value="12" min="0" max="50" step="0.5" required>
                        <small>Historical avg: 10-15% for equity funds</small>
                    </div>
                    
                    <div class="form-group" id="sipIncreaseGroup">
                        <label for="sipIncrease">Annual SIP Increase (%)</label>
                        <input type="number" id="sipIncrease" value="0" min="0" max="20" step="1">
                        <small>Step-up SIP: increase yearly</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Returns</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Investment Returns</h2>
                
                <div class="result-card success">
                    <h3>Estimated Returns</h3>
                    <div class="amount" id="totalValue">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Investment</h4>
                        <div class="value" id="totalInvested">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Gains</h4>
                        <div class="value" id="totalGains">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Absolute Return</h4>
                        <div class="value" id="absoluteReturn">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>CAGR</h4>
                        <div class="value" id="cagr">12%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Investment Summary</h3>
                    <div class="breakdown-item">
                        <span>Investment Type</span>
                        <strong id="typeDisplay">SIP</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Investment Period</span>
                        <strong id="periodDisplay">10 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Expected Return</span>
                        <strong id="returnDisplay">12% per annum</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Amount Invested</span>
                        <strong id="investedDisplay" style="color: #667eea;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;" id="sipBreakdown">
                    <h3>SIP Details</h3>
                    <div class="breakdown-item">
                        <span>Monthly SIP Amount</span>
                        <strong id="sipAmountDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total SIP Contributions</span>
                        <strong id="sipContributions">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>SIP Returns</span>
                        <strong id="sipReturns" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>SIP Final Value</span>
                        <strong id="sipValue" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;" id="lumpsumBreakdown">
                    <h3>Lumpsum Details</h3>
                    <div class="breakdown-item">
                        <span>Lumpsum Investment</span>
                        <strong id="lumpsumAmountDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lumpsum Returns</span>
                        <strong id="lumpsumReturns" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lumpsum Final Value</span>
                        <strong id="lumpsumValue" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Wealth Growth</h3>
                    <div class="breakdown-item">
                        <span>Amount Invested</span>
                        <strong id="totalInvestedBreakdown">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gains from Returns</span>
                        <strong id="totalGainsBreakdown" style="color: #4CAF50;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gains as % of Investment</span>
                        <strong id="gainsPercent" style="color: #4CAF50;">0%</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Final Corpus</strong></span>
                        <strong id="finalCorpus" style="color: #667eea; font-size: 1.2em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Return Analysis</h3>
                    <div class="breakdown-item">
                        <span>Absolute Return</span>
                        <strong id="absReturn">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAGR (Compound Annual Growth)</span>
                        <strong id="cagrDisplay" style="color: #667eea;">12%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>XIRR (Actual Return)</span>
                        <strong id="xirrDisplay">12%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Money Multiplier</span>
                        <strong id="multiplier" style="color: #4CAF50;">0x</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Year-wise Value</h3>
                    <div class="breakdown-item">
                        <span>After 5 Years</span>
                        <strong id="value5">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 10 Years</span>
                        <strong id="value10">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 15 Years</span>
                        <strong id="value15">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 20 Years</span>
                        <strong id="value20">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 30 Years</span>
                        <strong id="value30">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Return Scenarios</h3>
                    <div class="breakdown-item">
                        <span>Conservative (8%)</span>
                        <strong id="return8" style="color: #FF9800;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Moderate (12%)</span>
                        <strong id="return12" style="color: #667eea;">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Aggressive (15%)</span>
                        <strong id="return15" style="color: #4CAF50;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="interpretation" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="interpretationText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Mutual Fund Tips:</strong> SIP averages market volatility. Lumpsum good with large capital. Long-term = better returns. Equity funds for 5+ years. Debt funds for 1-3 years. Diversify across funds. Direct plans have lower fees. Review portfolio annually. Don't panic sell. Stay invested. Past returns ≠ future. Check expense ratio. Tax benefits: ELSS funds. Exit load? Check first. SIP autopay = discipline. Start early, invest regularly.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('mfForm');
        const currencySelect = document.getElementById('currency');
        const investmentType = document.getElementById('investmentType');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateReturns();
        });

        investmentType.addEventListener('change', function() {
            toggleFields();
            calculateReturns();
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

        function toggleFields() {
            const type = investmentType.value;
            const sipGroups = document.querySelectorAll('#sipAmountGroup, #sipIncreaseGroup');
            const lumpsumGroup = document.getElementById('lumpsumAmountGroup');
            
            if (type === 'sip') {
                sipGroups.forEach(g => g.style.display = 'block');
                lumpsumGroup.style.display = 'none';
            } else if (type === 'lumpsum') {
                sipGroups.forEach(g => g.style.display = 'none');
                lumpsumGroup.style.display = 'block';
            } else {
                sipGroups.forEach(g => g.style.display = 'block');
                lumpsumGroup.style.display = 'block';
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateReturns();
        });

        function calculateReturns() {
            const type = investmentType.value;
            const sipAmount = parseFloat(document.getElementById('sipAmount').value) || 0;
            const lumpsumAmount = parseFloat(document.getElementById('lumpsumAmount').value) || 0;
            const years = parseInt(document.getElementById('investmentPeriod').value) || 10;
            const annualReturn = parseFloat(document.getElementById('expectedReturn').value) / 100 || 0.12;
            const sipIncrease = parseFloat(document.getElementById('sipIncrease').value) / 100 || 0;
            const currency = currencySelect.value;

            const monthlyRate = annualReturn / 12;
            const months = years * 12;

            let sipValue = 0;
            let sipContributions = 0;
            let currentSip = sipAmount;

            // Calculate SIP
            if (type === 'sip' || type === 'both') {
                for (let month = 1; month <= months; month++) {
                    sipValue = (sipValue + currentSip) * (1 + monthlyRate);
                    sipContributions += currentSip;
                    
                    // Increase SIP annually
                    if (month % 12 === 0) {
                        currentSip = currentSip * (1 + sipIncrease);
                    }
                }
            }

            // Calculate Lumpsum
            let lumpsumValue = 0;
            if (type === 'lumpsum' || type === 'both') {
                lumpsumValue = lumpsumAmount * Math.pow(1 + annualReturn, years);
            }

            const totalValue = sipValue + lumpsumValue;
            const totalInvested = sipContributions + lumpsumAmount;
            const totalGains = totalValue - totalInvested;
            const absoluteReturn = totalInvested > 0 ? ((totalGains / totalInvested) * 100) : 0;
            const cagr = totalInvested > 0 ? ((Math.pow(totalValue / totalInvested, 1/years) - 1) * 100) : 0;
            const multiplier = totalInvested > 0 ? (totalValue / totalInvested) : 0;

            // Calculate year-wise values
            const value5 = calculateValueAtYear(sipAmount, lumpsumAmount, 5, annualReturn, sipIncrease, type);
            const value10 = calculateValueAtYear(sipAmount, lumpsumAmount, 10, annualReturn, sipIncrease, type);
            const value15 = calculateValueAtYear(sipAmount, lumpsumAmount, 15, annualReturn, sipIncrease, type);
            const value20 = calculateValueAtYear(sipAmount, lumpsumAmount, 20, annualReturn, sipIncrease, type);
            const value30 = calculateValueAtYear(sipAmount, lumpsumAmount, 30, annualReturn, sipIncrease, type);

            // Calculate different return scenarios
            const return8 = calculateValueAtYear(sipAmount, lumpsumAmount, years, 0.08, sipIncrease, type);
            const return12 = calculateValueAtYear(sipAmount, lumpsumAmount, years, 0.12, sipIncrease, type);
            const return15 = calculateValueAtYear(sipAmount, lumpsumAmount, years, 0.15, sipIncrease, type);

            // Interpretation
            let interpretation = '';
            if (type === 'sip') {
                interpretation = `By investing ${formatCurrency(sipAmount, currency)} monthly for ${years} years at ${(annualReturn * 100).toFixed(1)}% return, your investment of ${formatCurrency(totalInvested, currency)} will grow to ${formatCurrency(totalValue, currency)}. `;
            } else if (type === 'lumpsum') {
                interpretation = `A lumpsum investment of ${formatCurrency(lumpsumAmount, currency)} for ${years} years at ${(annualReturn * 100).toFixed(1)}% return will grow to ${formatCurrency(totalValue, currency)}. `;
            } else {
                interpretation = `By combining a lumpsum of ${formatCurrency(lumpsumAmount, currency)} with monthly SIP of ${formatCurrency(sipAmount, currency)} for ${years} years at ${(annualReturn * 100).toFixed(1)}% return, your total investment of ${formatCurrency(totalInvested, currency)} will grow to ${formatCurrency(totalValue, currency)}. `;
            }
            interpretation += `You will earn ${formatCurrency(totalGains, currency)} in returns, representing a ${absoluteReturn.toFixed(1)}% absolute return and ${cagr.toFixed(1)}% CAGR.`;

            // Update UI
            document.getElementById('totalValue').textContent = formatCurrency(totalValue, currency);
            document.getElementById('totalInvested').textContent = formatCurrency(totalInvested, currency);
            document.getElementById('totalGains').textContent = formatCurrency(totalGains, currency);
            document.getElementById('absoluteReturn').textContent = absoluteReturn.toFixed(1) + '%';
            document.getElementById('cagr').textContent = cagr.toFixed(1) + '%';

            const typeNames = {'sip': 'SIP', 'lumpsum': 'Lumpsum', 'both': 'SIP + Lumpsum'};
            document.getElementById('typeDisplay').textContent = typeNames[type];
            document.getElementById('periodDisplay').textContent = years + ' years (' + months + ' months)';
            document.getElementById('returnDisplay').textContent = (annualReturn * 100).toFixed(1) + '% per annum';
            document.getElementById('investedDisplay').textContent = formatCurrency(totalInvested, currency);

            // SIP breakdown
            const sipBreakdown = document.getElementById('sipBreakdown');
            if (type === 'sip' || type === 'both') {
                sipBreakdown.style.display = 'block';
                document.getElementById('sipAmountDisplay').textContent = formatCurrency(sipAmount, currency);
                document.getElementById('sipContributions').textContent = formatCurrency(sipContributions, currency);
                document.getElementById('sipReturns').textContent = formatCurrency(sipValue - sipContributions, currency);
                document.getElementById('sipValue').textContent = formatCurrency(sipValue, currency);
            } else {
                sipBreakdown.style.display = 'none';
            }

            // Lumpsum breakdown
            const lumpsumBreakdown = document.getElementById('lumpsumBreakdown');
            if (type === 'lumpsum' || type === 'both') {
                lumpsumBreakdown.style.display = 'block';
                document.getElementById('lumpsumAmountDisplay').textContent = formatCurrency(lumpsumAmount, currency);
                document.getElementById('lumpsumReturns').textContent = formatCurrency(lumpsumValue - lumpsumAmount, currency);
                document.getElementById('lumpsumValue').textContent = formatCurrency(lumpsumValue, currency);
            } else {
                lumpsumBreakdown.style.display = 'none';
            }

            document.getElementById('totalInvestedBreakdown').textContent = formatCurrency(totalInvested, currency);
            document.getElementById('totalGainsBreakdown').textContent = formatCurrency(totalGains, currency);
            document.getElementById('gainsPercent').textContent = absoluteReturn.toFixed(1) + '%';
            document.getElementById('finalCorpus').textContent = formatCurrency(totalValue, currency);

            document.getElementById('absReturn').textContent = absoluteReturn.toFixed(1) + '%';
            document.getElementById('cagrDisplay').textContent = cagr.toFixed(1) + '%';
            document.getElementById('xirrDisplay').textContent = cagr.toFixed(1) + '%';
            document.getElementById('multiplier').textContent = multiplier.toFixed(2) + 'x';

            document.getElementById('value5').textContent = formatCurrency(value5, currency);
            document.getElementById('value10').textContent = formatCurrency(value10, currency);
            document.getElementById('value15').textContent = formatCurrency(value15, currency);
            document.getElementById('value20').textContent = formatCurrency(value20, currency);
            document.getElementById('value30').textContent = formatCurrency(value30, currency);

            document.getElementById('return8').textContent = formatCurrency(return8, currency);
            document.getElementById('return12').textContent = formatCurrency(return12, currency);
            document.getElementById('return15').textContent = formatCurrency(return15, currency);

            document.getElementById('interpretationText').textContent = interpretation;
        }

        function calculateValueAtYear(sip, lumpsum, years, rate, increase, type) {
            const monthlyRate = rate / 12;
            const months = years * 12;
            
            let sipValue = 0;
            let currentSip = sip;
            
            if (type === 'sip' || type === 'both') {
                for (let month = 1; month <= months; month++) {
                    sipValue = (sipValue + currentSip) * (1 + monthlyRate);
                    if (month % 12 === 0) {
                        currentSip = currentSip * (1 + increase);
                    }
                }
            }
            
            let lumpsumValue = 0;
            if (type === 'lumpsum' || type === 'both') {
                lumpsumValue = lumpsum * Math.pow(1 + rate, years);
            }
            
            return sipValue + lumpsumValue;
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
            toggleFields();
            calculateReturns();
        });
    </script>
</body>
</html>