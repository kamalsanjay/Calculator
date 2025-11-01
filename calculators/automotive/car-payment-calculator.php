<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Payment Calculator - Auto Loan & Financing Calculator</title>
    <meta name="description" content="Advanced car payment calculator for auto loan calculations, financing options, and affordability analysis.">
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh; 
            padding: 20px; 
        }
        
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
        }
        
        .header { 
            background: rgba(255,255,255,0.95); 
            padding: 25px; 
            border-radius: 15px 15px 0 0; 
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1); 
            text-align: center; 
            margin-bottom: 0;
        }
        
        .header h1 { 
            color: #2c3e50; 
            font-size: 2.2rem; 
            margin-bottom: 10px; 
        }
        
        .header p { 
            color: #7f8c8d; 
            font-size: 1.1rem; 
            opacity: 0.9; 
        }
        
        .calculator-wrapper { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 25px; 
            background: white; 
            padding: 30px; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.12); 
            border-radius: 0 0 15px 15px;
        }
        
        .calculator-section h2, .results-section h2 { 
            color: #667eea; 
            margin-bottom: 20px; 
            font-size: 1.6rem; 
        }
        
        .form-group { 
            margin-bottom: 18px; 
        }
        
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            color: #555; 
        }
        
        .form-group input, .form-group select { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #e0e0e0; 
            border-radius: 8px; 
            font-size: 16px; 
            transition: border-color 0.3s; 
        }
        
        .form-group input:focus, .form-group select:focus { 
            outline: none; 
            border-color: #667eea; 
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); 
        }
        
        .form-group small { 
            display: block; 
            margin-top: 5px; 
            color: #888; 
            font-size: 0.85em; 
        }
        
        .btn { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 14px 25px; 
            border: none; 
            border-radius: 8px; 
            font-size: 16px; 
            font-weight: 600; 
            cursor: pointer; 
            width: 100%; 
            transition: all 0.3s; 
            margin-top: 10px;
        }
        
        .btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); 
        }
        
        .result-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 20px; 
            border-radius: 10px; 
            margin-bottom: 20px; 
            text-align: center; 
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); 
            position: relative; 
            overflow: hidden; 
        }
        
        .result-card::before { 
            content: ''; 
            position: absolute; 
            top: -50%; 
            right: -50%; 
            width: 200%; 
            height: 200%; 
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); 
            animation: pulse 3s ease-in-out infinite; 
        }
        
        @keyframes pulse { 
            0%, 100% { transform: scale(1); opacity: 0.5; } 
            50% { transform: scale(1.1); opacity: 0.8; } 
        }
        
        .result-card h3 { 
            font-size: 1.1rem; 
            opacity: 0.9; 
            margin-bottom: 10px; 
            font-weight: 400; 
            position: relative; 
            z-index: 1; 
        }
        
        .result-card .amount { 
            font-size: 2.2rem; 
            font-weight: bold; 
            position: relative; 
            z-index: 1; 
        }
        
        .metric-grid { 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            gap: 12px; 
            margin-bottom: 20px; 
        }
        
        .metric-card { 
            background: #f8f9fa; 
            padding: 15px; 
            border-radius: 10px; 
            text-align: center; 
            border: 2px solid #e0e0e0; 
            transition: all 0.3s; 
        }
        
        .metric-card:hover { 
            transform: translateY(-2px); 
            border-color: #667eea; 
        }
        
        .metric-card h4 { 
            color: #666; 
            font-size: 0.85rem; 
            margin-bottom: 8px; 
            font-weight: 400; 
        }
        
        .metric-card .value { 
            color: #667eea; 
            font-size: 1.4rem; 
            font-weight: bold; 
        }
        
        .breakdown { 
            background: #f8f9fa; 
            padding: 18px; 
            border-radius: 10px; 
            margin-bottom: 20px; 
        }
        
        .breakdown h3 { 
            color: #667eea; 
            margin-bottom: 15px; 
            font-size: 1.2rem; 
        }
        
        .breakdown-item { 
            display: flex; 
            justify-content: space-between; 
            padding: 10px 0; 
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
        
        .preset-buttons { 
            display: grid; 
            grid-template-columns: repeat(3, 1fr); 
            gap: 8px; 
            margin-top: 10px; 
        }
        
        .preset-btn { 
            padding: 10px 8px; 
            background: #f0f0f0; 
            border: 2px solid #e0e0e0; 
            border-radius: 6px; 
            cursor: pointer; 
            text-align: center; 
            font-size: 0.8rem; 
            transition: all 0.3s; 
        }
        
        .preset-btn:hover { 
            background: #667eea; 
            color: white; 
            border-color: #667eea; 
        }
        
        .preset-btn.active { 
            background: #667eea; 
            color: white; 
            border-color: #667eea; 
        }
        
        .info-box { 
            background: #e8f2ff; 
            border-left: 4px solid #667eea; 
            padding: 15px; 
            margin: 20px 0; 
            border-radius: 5px; 
            font-size: 0.9rem;
        }
        
        .info-box strong { 
            color: #667eea; 
        }
        
        .affordability-meter { 
            background: #f8f9fa; 
            padding: 18px; 
            border-radius: 10px; 
            margin-bottom: 20px; 
            text-align: center; 
        }
        
        .meter { 
            width: 100%; 
            height: 25px; 
            background: #e0e0e0; 
            border-radius: 12px; 
            overflow: hidden; 
            margin: 15px 0; 
            position: relative; 
        }
        
        .meter-fill { 
            height: 100%; 
            background: linear-gradient(90deg, #27ae60, #f39c12, #e74c3c); 
            transition: width 1s ease; 
            border-radius: 12px;
        }
        
        .meter-labels { 
            display: flex; 
            justify-content: space-between; 
            margin-top: 5px; 
            font-size: 0.75rem; 
            color: #666; 
        }
        
        .footer { 
            background: rgba(255,255,255,0.95); 
            padding: 20px; 
            border-radius: 0 0 15px 15px; 
            text-align: center; 
            color: #7f8c8d; 
            margin-top: 0;
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .calculator-wrapper { 
                grid-template-columns: 1fr; 
                padding: 25px; 
                gap: 20px;
            }
            
            .result-card .amount { 
                font-size: 2rem; 
            }
            
            .metric-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .header h1 { 
                font-size: 1.8rem; 
            }
            
            .header p {
                font-size: 1rem;
            }
            
            .calculator-wrapper {
                padding: 20px;
            }
            
            .metric-grid { 
                grid-template-columns: repeat(2, 1fr); 
            }
            
            .preset-buttons { 
                grid-template-columns: repeat(2, 1fr); 
            }
            
            .calculator-section h2, .results-section h2 {
                font-size: 1.4rem;
            }
        }
        
        @media (max-width: 480px) {
            .header h1 { 
                font-size: 1.5rem; 
            }
            
            .header p { 
                font-size: 0.9rem; 
            }
            
            .result-card .amount { 
                font-size: 1.8rem; 
            }
            
            body { 
                padding: 10px; 
            }
            
            .calculator-wrapper {
                padding: 15px;
            }
            
            .metric-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .metric-card .value {
                font-size: 1.2rem;
            }
            
            .preset-buttons {
                grid-template-columns: 1fr;
            }
            
            .breakdown {
                padding: 15px;
            }
            
            .affordability-meter {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚗 Car Payment Calculator</h1>
            <p>Advanced auto loan calculator with payment analysis and affordability assessment</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Loan Parameters</h2>
                <form id="paymentForm">
                    <div class="form-group">
                        <label for="vehiclePrice">Vehicle Price ($)</label>
                        <input type="number" id="vehiclePrice" value="30000" min="0" step="100" required>
                        <small>Total cost of the vehicle before any discounts</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="downPayment">Down Payment ($)</label>
                        <input type="number" id="downPayment" value="5000" min="0" step="100" required>
                        <small>Amount you're paying upfront</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="tradeIn">Trade-in Value ($)</label>
                        <input type="number" id="tradeIn" value="0" min="0" step="100">
                        <small>Value of your current vehicle (if applicable)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Months)</label>
                        <input type="number" id="loanTerm" value="60" min="12" max="84" step="12" required>
                        <small>Duration of the loan in months</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Interest Rate (%)</label>
                        <input type="number" id="interestRate" value="4.5" min="0" max="30" step="0.1" required>
                        <small>Annual percentage rate (APR)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="salesTax">Sales Tax Rate (%)</label>
                        <input type="number" id="salesTax" value="7.5" min="0" max="15" step="0.1">
                        <small>Your local sales tax rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Loan Presets</label>
                        <div class="preset-buttons">
                            <div class="preset-btn" onclick="setLoanPreset('short')">Short Term (36 mo)</div>
                            <div class="preset-btn" onclick="setLoanPreset('standard')">Standard (60 mo)</div>
                            <div class="preset-btn" onclick="setLoanPreset('long')">Long Term (72 mo)</div>
                            <div class="preset-btn" onclick="setLoanPreset('newCar')">New Car Rate</div>
                            <div class="preset-btn" onclick="setLoanPreset('usedCar')">Used Car Rate</div>
                            <div class="preset-btn" onclick="setLoanPreset('excellent')">Excellent Credit</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="monthlyIncome">Monthly Income ($)</label>
                        <input type="number" id="monthlyIncome" value="5000" min="0" step="100">
                        <small>Your gross monthly income for affordability calculation</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="otherDebts">Other Monthly Debts ($)</label>
                        <input type="number" id="otherDebts" value="500" min="0" step="50">
                        <small>Other monthly debt payments (credit cards, student loans, etc.)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Payment</button>
                </form>
                
                <div class="info-box">
                    <strong>Tip:</strong> Financial experts recommend keeping your total monthly car payment below 10-15% of your gross monthly income.
                </div>
            </div>

            <div class="results-section">
                <h2>Payment Analysis</h2>
                
                <div class="result-card">
                    <h3>Monthly Payment</h3>
                    <div class="amount" id="monthlyPayment">$456.33</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Loan Amount</h4>
                        <div class="value" id="totalLoan">$25,000</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Interest</h4>
                        <div class="value" id="totalInterest">$2,380</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$27,380</div>
                    </div>
                    <div class="metric-card">
                        <h4>Payoff Date</h4>
                        <div class="value" id="payoffDate">Jun 2028</div>
                    </div>
                </div>

                <div class="affordability-meter">
                    <h3>Payment Affordability</h3>
                    <div class="meter">
                        <div class="meter-fill" id="affordabilityMeter" style="width: 30%;"></div>
                    </div>
                    <div class="meter-labels">
                        <span>Comfortable</span>
                        <span>Moderate</span>
                        <span>Strained</span>
                    </div>
                    <div id="affordabilityText" style="color: #27ae60; font-weight: bold; margin-top: 10px;">Comfortable Payment</div>
                </div>

                <div class="breakdown">
                    <h3>Loan Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Vehicle Price</span>
                        <strong id="breakdownPrice">$30,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Down Payment</span>
                        <strong id="breakdownDown">$5,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Trade-in Value</span>
                        <strong id="breakdownTrade">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Sales Tax</span>
                        <strong id="breakdownTax">$2,250</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="breakdownLoan">$25,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest</span>
                        <strong id="breakdownInterest">$2,380</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Cost</span>
                        <strong id="breakdownTotal">$27,380</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> Longer loan terms result in lower monthly payments but higher total interest costs over the life of the loan.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🚗 Car Payment Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced auto loan calculation and payment analysis</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('paymentForm');

        // Loan presets
        const loanPresets = {
            short: {
                loanTerm: 36,
                interestRate: 3.5
            },
            standard: {
                loanTerm: 60,
                interestRate: 4.5
            },
            long: {
                loanTerm: 72,
                interestRate: 5.5
            },
            newCar: {
                interestRate: 3.9
            },
            usedCar: {
                interestRate: 6.5
            },
            excellent: {
                interestRate: 2.9
            }
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculatePayment();
        });

        function setLoanPreset(presetName) {
            const preset = loanPresets[presetName];
            
            if (preset.loanTerm) {
                document.getElementById('loanTerm').value = preset.loanTerm;
            }
            if (preset.interestRate) {
                document.getElementById('interestRate').value = preset.interestRate;
            }
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculatePayment();
        }

        function calculatePayment() {
            // Get inputs
            const vehiclePrice = parseFloat(document.getElementById('vehiclePrice').value);
            const downPayment = parseFloat(document.getElementById('downPayment').value);
            const tradeIn = parseFloat(document.getElementById('tradeIn').value);
            const loanTerm = parseInt(document.getElementById('loanTerm').value);
            const interestRate = parseFloat(document.getElementById('interestRate').value);
            const salesTax = parseFloat(document.getElementById('salesTax').value);
            const monthlyIncome = parseFloat(document.getElementById('monthlyIncome').value);
            const otherDebts = parseFloat(document.getElementById('otherDebts').value);

            // Calculate tax amount
            const taxAmount = vehiclePrice * (salesTax / 100);
            
            // Calculate loan amount
            const loanAmount = vehiclePrice + taxAmount - downPayment - tradeIn;
            
            // Calculate monthly payment
            const monthlyRate = interestRate / 100 / 12;
            const monthlyPayment = loanAmount * monthlyRate * Math.pow(1 + monthlyRate, loanTerm) / (Math.pow(1 + monthlyRate, loanTerm) - 1);
            
            // Calculate totals
            const totalPayment = monthlyPayment * loanTerm;
            const totalInterest = totalPayment - loanAmount;
            const totalCost = vehiclePrice + taxAmount + totalInterest;
            
            // Calculate affordability
            const carPaymentRatio = (monthlyPayment / monthlyIncome) * 100;
            
            // Calculate payoff date
            const today = new Date();
            const payoffDate = new Date(today.getFullYear(), today.getMonth() + loanTerm, today.getDate());
            
            // Update UI
            document.getElementById('monthlyPayment').textContent = `$${monthlyPayment.toFixed(2)}`;
            document.getElementById('totalLoan').textContent = `$${loanAmount.toFixed(0)}`;
            document.getElementById('totalInterest').textContent = `$${totalInterest.toFixed(0)}`;
            document.getElementById('totalCost').textContent = `$${totalCost.toFixed(0)}`;
            document.getElementById('payoffDate').textContent = payoffDate.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
            
            // Update breakdown
            document.getElementById('breakdownPrice').textContent = `$${vehiclePrice.toFixed(0)}`;
            document.getElementById('breakdownDown').textContent = `$${downPayment.toFixed(0)}`;
            document.getElementById('breakdownTrade').textContent = `$${tradeIn.toFixed(0)}`;
            document.getElementById('breakdownTax').textContent = `$${taxAmount.toFixed(0)}`;
            document.getElementById('breakdownLoan').textContent = `$${loanAmount.toFixed(0)}`;
            document.getElementById('breakdownInterest').textContent = `$${totalInterest.toFixed(0)}`;
            document.getElementById('breakdownTotal').textContent = `$${totalCost.toFixed(0)}`;
            
            // Update affordability meter
            updateAffordabilityMeter(carPaymentRatio);
        }

        function updateAffordabilityMeter(carPaymentRatio) {
            const meter = document.getElementById('affordabilityMeter');
            const text = document.getElementById('affordabilityText');
            
            let meterWidth, status, color;
            
            if (carPaymentRatio <= 10) {
                meterWidth = 30;
                status = 'Comfortable';
                color = '#27ae60';
            } else if (carPaymentRatio <= 15) {
                meterWidth = 60;
                status = 'Moderate';
                color = '#f39c12';
            } else {
                meterWidth = 90;
                status = 'Strained';
                color = '#e74c3c';
            }
            
            meter.style.width = `${meterWidth}%`;
            text.textContent = `${status} Payment (${carPaymentRatio.toFixed(1)}% of income)`;
            text.style.color = color;
        }

        // Initialize
        window.addEventListener('load', function() {
            calculatePayment();
        });
    </script>
</body>
</html>