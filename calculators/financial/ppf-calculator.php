<?php
/**
 * PPF Calculator
 * File: ppf-calculator.php
 * Description: Calculate Public Provident Fund maturity for India (15 years, 7.1% rate)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPF Calculator India 2025 - Calculate Public Provident Fund Maturity (7.1%)</title>
    <meta name="description" content="Free PPF calculator for India. Calculate Public Provident Fund maturity amount with 7.1% interest rate. Get yearly investment breakdown for 15-year tenure. Plan your PPF investment.">
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
</head>
<body>
    <header>
        <h1>🏦 PPF Calculator</h1>
        <p>Calculate Public Provident Fund maturity for India (7.1% p.a.)</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>PPF Investment Details</h2>
                <form id="ppfForm">
                    <div class="form-group">
                        <label for="yearlyInvestment">Yearly Investment (₹)</label>
                        <input type="number" id="yearlyInvestment" value="150000" min="500" max="150000" step="1000" required>
                        <small>Min: ₹500, Max: ₹1,50,000 per year</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="tenure">Tenure (Years)</label>
                        <input type="number" id="tenure" value="15" min="15" max="50" step="1" required>
                        <small>Minimum 15 years (can extend in blocks of 5)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (% p.a.)</label>
                        <input type="number" id="interestRate" value="7.1" min="0" max="15" step="0.1" required>
                        <small>Current rate: 7.1% (Q4 FY 2025-26)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate PPF Maturity</button>
                </form>
            </div>

            <div class="results-section">
                <h2>PPF Maturity Details</h2>
                
                <div class="result-card">
                    <h3>Maturity Amount</h3>
                    <div class="amount" id="maturityAmount">₹40,68,209</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Invested</h4>
                        <div class="value" id="totalInvested">₹22,50,000</div>
                    </div>
                    <div class="metric-card">
                        <h4>Interest Earned</h4>
                        <div class="value" id="interestEarned">₹18,18,209</div>
                    </div>
                    <div class="metric-card">
                        <h4>Interest Rate</h4>
                        <div class="value" id="rateDisplay">7.1%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Tenure</h4>
                        <div class="value" id="tenureDisplay">15 years</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>PPF Formula</h3>
                    <div class="breakdown-item">
                        <span>Formula</span>
                        <strong>M = P [ ({(1+i)^n}-1) / i ]</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>P (Yearly Investment)</span>
                        <strong id="pValue">₹1,50,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>i (Interest Rate)</span>
                        <strong id="iValue">7.1% (0.071)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>n (Years)</span>
                        <strong id="nValue">15</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Investment Summary</h3>
                    <div class="breakdown-item">
                        <span>Yearly Investment</span>
                        <strong id="yearlyAmount">₹1,50,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Years</span>
                        <strong id="totalYears">15 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Amount Invested</span>
                        <strong id="totalPrincipal">₹22,50,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest</span>
                        <strong id="totalInterest" style="color: #4CAF50;">₹18,18,209</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Maturity Value</strong></span>
                        <strong id="maturityValue" style="color: #667eea; font-size: 1.2em;">₹40,68,209</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Year-by-Year Growth</h3>
                    <div class="breakdown-item">
                        <span>After 5 Years</span>
                        <strong id="year5">₹8,63,092</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 10 Years</span>
                        <strong id="year10">₹20,74,616</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 15 Years</span>
                        <strong id="year15">₹40,68,209</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 20 Years</span>
                        <strong id="year20">₹66,58,288</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>After 30 Years</span>
                        <strong id="year30">₹1,54,50,911</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Return Analysis</h3>
                    <div class="breakdown-item">
                        <span>Total Return %</span>
                        <strong id="totalReturn">80.81%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Effective Annual Return</span>
                        <strong id="effectiveReturn">7.1%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest-to-Principal Ratio</span>
                        <strong id="interestRatio">0.81</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>PPF Benefits:</strong> Tax-free returns under EEE. Interest rate: 7.1% (Q4 FY 2025-26). Min: ₹500/year, Max: ₹1.5L/year. Lock-in: 15 years (extendable). Partial withdrawal after 7 years. Loan facility after 3 years. Government-backed, risk-free investment.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('ppfForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculatePPF();
        });

        function calculatePPF() {
            const yearlyInvestment = parseFloat(document.getElementById('yearlyInvestment').value) || 150000;
            const tenure = parseInt(document.getElementById('tenure').value) || 15;
            const interestRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0.071;

            // PPF Formula: M = P [ ({(1+i)^n}-1) / i ]
            const maturityAmount = yearlyInvestment * ((Math.pow(1 + interestRate, tenure) - 1) / interestRate);
            
            const totalInvestedAmount = yearlyInvestment * tenure;
            const interestEarnedAmount = maturityAmount - totalInvestedAmount;
            const totalReturnPercent = (interestEarnedAmount / totalInvestedAmount) * 100;
            const interestRatioValue = interestEarnedAmount / totalInvestedAmount;

            // Year-wise calculations
            function calculateYearValue(years) {
                return yearlyInvestment * ((Math.pow(1 + interestRate, years) - 1) / interestRate);
            }

            const year5Value = calculateYearValue(5);
            const year10Value = calculateYearValue(10);
            const year15Value = calculateYearValue(15);
            const year20Value = calculateYearValue(20);
            const year30Value = calculateYearValue(30);

            // Update UI
            document.getElementById('maturityAmount').textContent = formatINR(maturityAmount);
            document.getElementById('totalInvested').textContent = formatINR(totalInvestedAmount);
            document.getElementById('interestEarned').textContent = formatINR(interestEarnedAmount);
            document.getElementById('rateDisplay').textContent = (interestRate * 100).toFixed(1) + '%';
            document.getElementById('tenureDisplay').textContent = tenure + ' years';

            document.getElementById('pValue').textContent = formatINR(yearlyInvestment);
            document.getElementById('iValue').textContent = (interestRate * 100).toFixed(1) + '% (' + interestRate.toFixed(3) + ')';
            document.getElementById('nValue').textContent = tenure;

            document.getElementById('yearlyAmount').textContent = formatINR(yearlyInvestment);
            document.getElementById('totalYears').textContent = tenure + ' years';
            document.getElementById('totalPrincipal').textContent = formatINR(totalInvestedAmount);
            document.getElementById('totalInterest').textContent = formatINR(interestEarnedAmount);
            document.getElementById('maturityValue').textContent = formatINR(maturityAmount);

            document.getElementById('year5').textContent = formatINR(year5Value);
            document.getElementById('year10').textContent = formatINR(year10Value);
            document.getElementById('year15').textContent = formatINR(year15Value);
            document.getElementById('year20').textContent = formatINR(year20Value);
            document.getElementById('year30').textContent = formatINR(year30Value);

            document.getElementById('totalReturn').textContent = totalReturnPercent.toFixed(2) + '%';
            document.getElementById('effectiveReturn').textContent = (interestRate * 100).toFixed(1) + '%';
            document.getElementById('interestRatio').textContent = interestRatioValue.toFixed(2);
        }

        function formatINR(amount) {
            return new Intl.NumberFormat('en-IN', {
                style: 'currency',
                currency: 'INR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        }

        window.addEventListener('load', function() {
            calculatePPF();
        });
    </script>
</body>
</html>