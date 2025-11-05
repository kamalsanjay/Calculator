<?php
/**
 * Interest Rate Calculator
 * File: interest-rate-calculator.php
 * Description: Calculate effective interest rates, compare loan offers, and analyze borrowing costs
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interest Rate Calculator - Compare Loan Rates & Calculate APR</title>
    <meta name="description" content="Advanced Interest Rate Calculator. Calculate effective interest rates, compare loan offers, analyze APR, and understand true borrowing costs with fees and compounding.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>📊 Interest Rate Calculator</h1>
        <p>Compare loan rates, calculate APR, and understand true borrowing costs</p>
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
            background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
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
            color: #9C27B0;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #7B1FA2;
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
            color: #9C27B0;
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
            border-color: #9C27B0;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #888;
            font-size: 0.9em;
        }
        
        .btn {
            background: #9C27B0;
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
            background: #7B1FA2;
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
        
        .apr-card {
            background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
        }
        
        .effective-rate-card {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }
        
        .total-cost-card {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
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
            color: #9C27B0;
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
            color: #9C27B0;
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
            background: #f3e5f5;
            border-left: 4px solid #9C27B0;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box strong {
            color: #7B1FA2;
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
            background: #9C27B0;
            color: white;
            border-color: #7B1FA2;
        }
        
        .loan-comparison {
            background: #e8f5e9;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .comparison-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 15px;
        }
        
        .comparison-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border: 2px solid #c8e6c9;
        }
        
        .comparison-card h4 {
            color: #9C27B0;
            margin-bottom: 10px;
            font-size: 1.1em;
        }
        
        .rate-visual {
            height: 120px;
            background: #f8f9fa;
            border-radius: 8px;
            margin: 15px 0;
            position: relative;
            overflow: hidden;
        }
        
        .rate-bar {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: #9C27B0;
            border-radius: 4px 4px 0 0;
            transition: all 0.5s ease;
        }
        
        .rate-labels {
            display: flex;
            justify-content: space-between;
            position: absolute;
            bottom: -25px;
            width: 100%;
            font-size: 0.9em;
            color: #666;
        }
        
        .rate-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        
        .rate-table th, .rate-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .rate-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #555;
        }
        
        .rate-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .rate-table .best-option {
            background-color: #e8f5e9;
            font-weight: 600;
        }
        
        .fee-breakdown {
            background: #fff3e0;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .fee-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ffe0b2;
        }
        
        .fee-item:last-child {
            border-bottom: none;
        }
        
        .impact-analysis {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }
        
        .impact-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .impact-card h4 {
            color: #9C27B0;
            margin-bottom: 15px;
            font-size: 1.1em;
        }
        
        .scenario-slider {
            margin: 20px 0;
        }
        
        .slider-container {
            margin: 15px 0;
        }
        
        .slider-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .slider {
            width: 100%;
            height: 6px;
            background: #e0e0e0;
            border-radius: 3px;
            outline: none;
            -webkit-appearance: none;
        }
        
        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            background: #9C27B0;
            border-radius: 50%;
            cursor: pointer;
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
            
            .calculator-options {
                grid-template-columns: 1fr;
            }
            
            .comparison-grid {
                grid-template-columns: 1fr;
            }
            
            .impact-analysis {
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
                <h2>Loan Details</h2>
                <form id="interestRateForm">
                    <div class="form-group">
                        <label>Calculation Type</label>
                        <div class="calculator-options">
                            <div class="calculator-option active" data-type="apr">
                                <strong>APR Calculation</strong>
                                <div>Including fees and costs</div>
                            </div>
                            <div class="calculator-option" data-type="effective">
                                <strong>Effective Rate</strong>
                                <div>With compounding</div>
                            </div>
                        </div>
                        <input type="hidden" id="calculationType" value="apr">
                    </div>
                    
                    <div class="form-group">
                        <label for="loanAmount">Loan Amount</label>
                        <input type="number" id="loanAmount" value="25000" min="100" max="1000000" step="100" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Nominal Interest Rate (%)</label>
                        <input type="number" id="interestRate" value="5.5" min="0.1" max="50" step="0.1" required>
                        <small>Stated annual rate before fees</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Years)</label>
                        <input type="number" id="loanTerm" value="5" min="1" max="30" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Compounding Frequency</label>
                        <select id="compoundingFrequency">
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="semiannually">Semi-Annually</option>
                            <option value="annually">Annually</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="originationFee">Origination Fee (%)</label>
                        <input type="number" id="originationFee" value="1.0" min="0" max="10" step="0.1">
                        <small>Percentage of loan amount</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="applicationFee">Application Fee ($)</label>
                        <input type="number" id="applicationFee" value="250" min="0" max="5000" step="10">
                    </div>
                    
                    <div class="form-group">
                        <label for="otherFees">Other Fees ($)</label>
                        <input type="number" id="otherFees" value="150" min="0" max="10000" step="10">
                        <small>Closing costs, processing fees, etc.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="points">Discount Points</label>
                        <input type="number" id="points" value="0" min="0" max="5" step="0.125">
                        <small>Each point = 1% of loan amount</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Interest Rates</button>
                </form>
                
                <div class="scenario-slider">
                    <h3 style="color: #9C27B0; margin-bottom: 15px;">Rate Comparison Scenarios</h3>
                    
                    <div class="slider-container">
                        <div class="slider-label">
                            <span>Lower Rate (4.5%)</span>
                            <span id="currentRateDisplay">5.5%</span>
                            <span>Higher Rate (7.5%)</span>
                        </div>
                        <input type="range" min="4.5" max="7.5" step="0.1" value="5.5" class="slider" id="rateSlider">
                    </div>
                    
                    <div class="slider-container">
                        <div class="slider-label">
                            <span>Shorter Term (3 years)</span>
                            <span id="currentTermDisplay">5 years</span>
                            <span>Longer Term (7 years)</span>
                        </div>
                        <input type="range" min="3" max="7" step="1" value="5" class="slider" id="termSlider">
                    </div>
                </div>
                
                <div class="breakdown" style="margin-top: 30px;">
                    <h3>Understanding Interest Rates</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Nominal Rate:</strong> Stated interest rate before compounding and fees</p>
                        <p><strong>APR (Annual Percentage Rate):</strong> Total cost of borrowing including fees, expressed as yearly rate</p>
                        <p><strong>Effective Annual Rate (EAR):</strong> Actual interest rate with compounding effects</p>
                        <p><strong>Rule of Thumb:</strong> APR is typically 0.1-0.5% higher than nominal rate due to fees</p>
                    </div>
                </div>
            </div>

            <div class="results-section">
                <h2>Rate Analysis Results</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Annual Percentage Rate (APR)</h3>
                    <div class="amount" id="aprRate">5.72%</div>
                    <div class="category" id="aprDescription">True Cost of Borrowing</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Effective Annual Rate</h4>
                        <div class="value" id="effectiveRate">5.64%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Monthly Payment</h4>
                        <div class="value" id="monthlyPayment">$478</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Interest</h4>
                        <div class="value" id="totalInterest">$3,680</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$28,680</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Loan Principal</span>
                        <strong id="breakdownPrincipal">$25,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest</span>
                        <strong id="breakdownInterest">$3,680</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Origination Fee</span>
                        <strong id="breakdownOrigination">$250</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Application Fee</span>
                        <strong id="breakdownApplication">$250</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Other Fees</span>
                        <strong id="breakdownOtherFees">$150</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Points Cost</span>
                        <strong id="breakdownPoints">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #9C27B0; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Loan Cost</strong></span>
                        <strong id="breakdownTotal" style="font-size: 1.1em;">$29,330</strong>
                    </div>
                </div>

                <div class="fee-breakdown">
                    <h3 style="color: #FF9800; margin-bottom: 15px;">Fee Impact Analysis</h3>
                    <div class="fee-item">
                        <span>Fees as % of Loan</span>
                        <strong id="feesPercentage">2.6%</strong>
                    </div>
                    <div class="fee-item">
                        <span>Equivalent Rate Increase</span>
                        <strong id="rateIncrease">+0.22%</strong>
                    </div>
                    <div class="fee-item">
                        <span>Additional Interest Cost</span>
                        <strong id="additionalInterest">$275</strong>
                    </div>
                </div>

                <div class="loan-comparison">
                    <h3 style="color: #2E7D32; margin-bottom: 15px;">Loan Comparison</h3>
                    <div class="comparison-grid">
                        <div class="comparison-card">
                            <h4>Your Loan</h4>
                            <div class="breakdown-item">
                                <span>APR</span>
                                <strong>5.72%</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Monthly</span>
                                <strong>$478</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Total Cost</span>
                                <strong>$29,330</strong>
                            </div>
                        </div>
                        
                        <div class="comparison-card">
                            <h4>Lower Rate (4.5%)</h4>
                            <div class="breakdown-item">
                                <span>APR</span>
                                <strong>4.68%</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Monthly</span>
                                <strong>$456</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Total Cost</span>
                                <strong>$27,360</strong>
                            </div>
                        </div>
                        
                        <div class="comparison-card">
                            <h4>Higher Rate (7.5%)</h4>
                            <div class="breakdown-item">
                                <span>APR</span>
                                <strong>7.72%</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Monthly</span>
                                <strong>$501</strong>
                            </div>
                            <div class="breakdown-item">
                                <span>Total Cost</span>
                                <strong>$30,060</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Rate Comparison Table</h3>
                    <table class="rate-table">
                        <thead>
                            <tr>
                                <th>Interest Rate</th>
                                <th>APR</th>
                                <th>Monthly Payment</th>
                                <th>Total Interest</th>
                                <th>Savings</th>
                            </tr>
                        </thead>
                        <tbody id="rateComparisonTable">
                            <!-- Rate comparison data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <div class="impact-analysis">
                    <div class="impact-card">
                        <h4>📈 Rate Impact</h4>
                        <div class="breakdown-item">
                            <span>0.5% Rate Drop</span>
                            <strong id="halfPercentSave">-$1,970</strong>
                        </div>
                        <div class="breakdown-item">
                            <span>1.0% Rate Drop</span>
                            <strong id="onePercentSave">-$3,850</strong>
                        </div>
                        <div class="breakdown-item">
                            <span>Best Case Saving</span>
                            <strong id="bestCaseSave">-$5,720</strong>
                        </div>
                    </div>
                    
                    <div class="impact-card">
                        <h4>⏰ Term Impact</h4>
                        <div class="breakdown-item">
                            <span>3-Year Term</span>
                            <strong id="threeYearSave">-$2,150</strong>
                        </div>
                        <div class="breakdown-item">
                            <span>7-Year Term</span>
                            <strong id="sevenYearCost">+$1,380</strong>
                        </div>
                        <div class="breakdown-item">
                            <span>Optimal Term</span>
                            <strong id="optimalTerm">5 years</strong>
                        </div>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Recommendations</h3>
                    <div id="recommendations" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="recommendationText" style="margin: 0;">Your current loan offer has reasonable fees. Consider negotiating a 0.25% lower rate or asking the lender to waive the application fee. The APR is 0.22% higher than the nominal rate due to fees.</p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Interest Rate Tips:</strong> Always compare APRs not just interest rates. Even small rate differences save thousands over the loan term. Consider both monthly payment and total cost. Shorter terms usually have lower rates but higher payments. Improve credit score before applying for better rates. Negotiate fees - many are flexible. Consider loan points if planning to keep the loan long-term. Watch for prepayment penalties. Get multiple loan estimates to compare. Understand variable vs fixed rates. Consider refinancing when rates drop significantly. Calculate break-even point for refinancing costs. Factor in tax deductions for mortgage interest.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('interestRateForm');
        const calculationOptions = document.querySelectorAll('.calculator-option');
        const rateSlider = document.getElementById('rateSlider');
        const termSlider = document.getElementById('termSlider');
        
        // Calculation type selection
        calculationOptions.forEach(option => {
            option.addEventListener('click', function() {
                calculationOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('calculationType').value = this.dataset.type;
                calculateInterestRates();
            });
        });
        
        // Slider events
        rateSlider.addEventListener('input', function() {
            document.getElementById('currentRateDisplay').textContent = this.value + '%';
            document.getElementById('interestRate').value = this.value;
            calculateInterestRates();
        });
        
        termSlider.addEventListener('input', function() {
            document.getElementById('currentTermDisplay').textContent = this.value + ' years';
            document.getElementById('loanTerm').value = this.value;
            calculateInterestRates();
        });
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateInterestRates();
        });

        function calculateInterestRates() {
            const loanAmount = parseFloat(document.getElementById('loanAmount').value) || 0;
            const nominalRate = parseFloat(document.getElementById('interestRate').value) || 0;
            const loanTerm = parseFloat(document.getElementById('loanTerm').value) || 0;
            const compounding = document.getElementById('compoundingFrequency').value;
            const originationFeePercent = parseFloat(document.getElementById('originationFee').value) || 0;
            const applicationFee = parseFloat(document.getElementById('applicationFee').value) || 0;
            const otherFees = parseFloat(document.getElementById('otherFees').value) || 0;
            const points = parseFloat(document.getElementById('points').value) || 0;
            
            const decimalRate = nominalRate / 100;
            const months = loanTerm * 12;
            
            // Calculate fees
            const originationFeeAmount = loanAmount * (originationFeePercent / 100);
            const pointsCost = loanAmount * (points / 100);
            const totalFees = originationFeeAmount + applicationFee + otherFees + pointsCost;
            const netLoanAmount = loanAmount - totalFees;
            
            // Calculate monthly payment using standard formula
            const monthlyRate = decimalRate / 12;
            const monthlyPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, months)) / 
                                 (Math.pow(1 + monthlyRate, months) - 1);
            
            // Calculate total costs
            const totalPayment = monthlyPayment * months;
            const totalInterest = totalPayment - loanAmount;
            const totalCost = totalPayment + totalFees;
            
            // Calculate APR using iterative method (simplified)
            const apr = calculateAPR(loanAmount, totalFees, monthlyPayment, months);
            
            // Calculate effective annual rate based on compounding frequency
            let effectiveRate;
            switch(compounding) {
                case 'monthly':
                    effectiveRate = (Math.pow(1 + decimalRate/12, 12) - 1) * 100;
                    break;
                case 'quarterly':
                    effectiveRate = (Math.pow(1 + decimalRate/4, 4) - 1) * 100;
                    break;
                case 'semiannually':
                    effectiveRate = (Math.pow(1 + decimalRate/2, 2) - 1) * 100;
                    break;
                case 'annually':
                    effectiveRate = nominalRate;
                    break;
            }
            
            // Calculate fee impact
            const feesPercentage = (totalFees / loanAmount) * 100;
            const rateIncrease = apr - nominalRate;
            const additionalInterest = totalFees * (decimalRate * loanTerm);
            
            // Update UI
            const card = document.getElementById('resultCard');
            card.className = 'result-card apr-card';
            
            document.getElementById('aprRate').textContent = apr.toFixed(2) + '%';
            document.getElementById('effectiveRate').textContent = effectiveRate.toFixed(2) + '%';
            document.getElementById('monthlyPayment').textContent = formatCurrency(monthlyPayment);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest);
            document.getElementById('totalCost').textContent = formatCurrency(totalCost);
            
            document.getElementById('breakdownPrincipal').textContent = formatCurrency(loanAmount);
            document.getElementById('breakdownInterest').textContent = formatCurrency(totalInterest);
            document.getElementById('breakdownOrigination').textContent = formatCurrency(originationFeeAmount);
            document.getElementById('breakdownApplication').textContent = formatCurrency(applicationFee);
            document.getElementById('breakdownOtherFees').textContent = formatCurrency(otherFees);
            document.getElementById('breakdownPoints').textContent = formatCurrency(pointsCost);
            document.getElementById('breakdownTotal').textContent = formatCurrency(totalCost);
            
            document.getElementById('feesPercentage').textContent = feesPercentage.toFixed(1) + '%';
            document.getElementById('rateIncrease').textContent = '+' + rateIncrease.toFixed(2) + '%';
            document.getElementById('additionalInterest').textContent = formatCurrency(additionalInterest);
            
            // Generate rate comparison
            generateRateComparison(loanAmount, loanTerm, totalFees);
            
            // Generate impact analysis
            generateImpactAnalysis(loanAmount, nominalRate, loanTerm, totalFees);
            
            // Update recommendations
            let recommendation = '';
            if (rateIncrease > 0.5) {
                recommendation = 'Your loan has high fees that significantly increase the APR. Consider negotiating lower fees or shopping for better offers. ';
            } else if (rateIncrease > 0.2) {
                recommendation = 'Your current loan offer has reasonable fees. Consider negotiating a 0.25% lower rate or asking the lender to waive the application fee. ';
            } else {
                recommendation = 'Your loan offer has minimal fees. This is a competitive offer with a low APR. ';
            }
            
            recommendation += `The APR is ${rateIncrease.toFixed(2)}% higher than the nominal rate due to fees.`;
            document.getElementById('recommendationText').textContent = recommendation;
        }
        
        function calculateAPR(loanAmount, totalFees, monthlyPayment, months) {
            // Simplified APR calculation using iterative method
            const netAmount = loanAmount - totalFees;
            let rate = 0.05; // Start with 5% guess
            let precision = 0.0001;
            let maxIterations = 100;
            
            for (let i = 0; i < maxIterations; i++) {
                const monthlyRate = rate / 12;
                const calculatedPayment = netAmount * (monthlyRate * Math.pow(1 + monthlyRate, months)) / 
                                       (Math.pow(1 + monthlyRate, months) - 1);
                
                const difference = calculatedPayment - monthlyPayment;
                
                if (Math.abs(difference) < precision) {
                    break;
                }
                
                // Adjust rate based on difference
                if (difference > 0) {
                    rate -= rate * 0.01;
                } else {
                    rate += rate * 0.01;
                }
            }
            
            return rate * 100;
        }
        
        function generateRateComparison(loanAmount, loanTerm, totalFees) {
            const table = document.getElementById('rateComparisonTable');
            table.innerHTML = '';
            
            const rates = [4.0, 4.5, 5.0, 5.5, 6.0, 6.5, 7.0];
            const currentRate = parseFloat(document.getElementById('interestRate').value);
            
            rates.forEach(rate => {
                const months = loanTerm * 12;
                const monthlyRate = rate / 100 / 12;
                const monthlyPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, months)) / 
                                     (Math.pow(1 + monthlyRate, months) - 1);
                
                const totalPayment = monthlyPayment * months;
                const totalInterest = totalPayment - loanAmount;
                const apr = calculateAPR(loanAmount, totalFees, monthlyPayment, months);
                
                // Calculate savings compared to current rate
                const currentMonthly = parseFloat(document.getElementById('monthlyPayment').textContent.replace('$', '').replace(',', ''));
                const savings = (currentMonthly - monthlyPayment) * months;
                
                const isCurrent = Math.abs(rate - currentRate) < 0.1;
                const isBest = rate === Math.min(...rates);
                
                const row = document.createElement('tr');
                if (isCurrent) row.className = 'best-option';
                if (isBest) row.style.backgroundColor = '#e8f5e9';
                
                row.innerHTML = `
                    <td>${rate}%${isCurrent ? ' (Current)' : ''}</td>
                    <td>${apr.toFixed(2)}%</td>
                    <td>${formatCurrency(monthlyPayment)}</td>
                    <td>${formatCurrency(totalInterest)}</td>
                    <td>${savings > 0 ? '+' + formatCurrency(savings) : formatCurrency(savings)}</td>
                `;
                table.appendChild(row);
            });
        }
        
        function generateImpactAnalysis(loanAmount, currentRate, currentTerm, totalFees) {
            // Rate impact
            const halfPercentRate = currentRate - 0.5;
            const onePercentRate = currentRate - 1.0;
            const bestCaseRate = 4.0; // Assuming 4% is best available
            
            const halfPercentSave = calculateSavings(loanAmount, currentRate, halfPercentRate, currentTerm, totalFees);
            const onePercentSave = calculateSavings(loanAmount, currentRate, onePercentRate, currentTerm, totalFees);
            const bestCaseSave = calculateSavings(loanAmount, currentRate, bestCaseRate, currentTerm, totalFees);
            
            // Term impact
            const threeYearSave = calculateTermSavings(loanAmount, currentRate, currentTerm, 3, totalFees);
            const sevenYearCost = calculateTermSavings(loanAmount, currentRate, currentTerm, 7, totalFees);
            const optimalTerm = currentTerm; // Simplified - in reality would calculate based on total cost
            
            document.getElementById('halfPercentSave').textContent = formatCurrency(halfPercentSave);
            document.getElementById('onePercentSave').textContent = formatCurrency(onePercentSave);
            document.getElementById('bestCaseSave').textContent = formatCurrency(bestCaseSave);
            
            document.getElementById('threeYearSave').textContent = formatCurrency(threeYearSave);
            document.getElementById('sevenYearCost').textContent = formatCurrency(sevenYearCost);
            document.getElementById('optimalTerm').textContent = optimalTerm + ' years';
        }
        
        function calculateSavings(loanAmount, currentRate, newRate, term, fees) {
            const months = term * 12;
            
            const currentMonthlyRate = currentRate / 100 / 12;
            const currentPayment = loanAmount * (currentMonthlyRate * Math.pow(1 + currentMonthlyRate, months)) / 
                                 (Math.pow(1 + currentMonthlyRate, months) - 1);
            
            const newMonthlyRate = newRate / 100 / 12;
            const newPayment = loanAmount * (newMonthlyRate * Math.pow(1 + newMonthlyRate, months)) / 
                             (Math.pow(1 + newMonthlyRate, months) - 1);
            
            return (currentPayment - newPayment) * months;
        }
        
        function calculateTermSavings(loanAmount, rate, currentTerm, newTerm, fees) {
            const currentMonths = currentTerm * 12;
            const newMonths = newTerm * 12;
            const monthlyRate = rate / 100 / 12;
            
            const currentPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, currentMonths)) / 
                                 (Math.pow(1 + monthlyRate, currentMonths) - 1);
            
            const newPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, newMonths)) / 
                             (Math.pow(1 + monthlyRate, newMonths) - 1);
            
            if (newTerm < currentTerm) {
                // Shorter term - calculate interest savings
                return (currentPayment * currentMonths) - (newPayment * newMonths);
            } else {
                // Longer term - calculate additional cost
                return (newPayment * newMonths) - (currentPayment * currentMonths);
            }
        }
        
        function formatCurrency(amount) {
            if (amount >= 0) {
                return '$' + Math.abs(amount).toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            } else {
                return '-$' + Math.abs(amount).toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            }
        }

        window.addEventListener('load', function() {
            calculateInterestRates();
        });
    </script>
</body>
</html>
