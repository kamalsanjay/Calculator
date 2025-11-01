<?php
/**
 * Car Lease Calculator
 * File: automotive/car-lease-calculator.php
 * Description: Advanced car lease calculator with payment analysis, terms, and detailed breakdown
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Lease Calculator - Monthly Payments & Lease Terms Analysis</title>
    <meta name="description" content="Advanced car lease calculator. Calculate monthly payments, total costs, and analyze lease terms with detailed breakdowns.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh; 
            padding: 20px; 
        }
        
        .container { 
            max-width: 1400px; 
            margin: 0 auto; 
        }
        
        .header { 
            background: rgba(255,255,255,0.95); 
            padding: 30px; 
            border-radius: 20px 20px 0 0; 
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1); 
            text-align: center; 
        }
        .header h1 { 
            color: #2c3e50; 
            font-size: 2.5rem; 
            margin-bottom: 10px; 
        }
        .header p { 
            color: #7f8c8d; 
            font-size: 1.2rem; 
            opacity: 0.9; 
        }
        
        .calculator-wrapper { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 30px; 
            background: white; 
            padding: 35px; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.12); 
        }
        
        .calculator-section h2, .results-section h2 { 
            color: #667eea; 
            margin-bottom: 25px; 
            font-size: 1.8rem; 
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
            font-size: 0.9em; 
        }
        
        .input-group { 
            display: grid; 
            grid-template-columns: 1fr auto; 
            gap: 10px; 
            align-items: center; 
        }
        
        .currency-input { 
            position: relative; 
        }
        .currency-input::before { 
            content: '$'; 
            position: absolute; 
            left: 12px; 
            top: 50%; 
            transform: translateY(-50%); 
            color: #666; 
            font-weight: 600; 
        }
        .currency-input input { 
            padding-left: 25px !important; 
        }
        
        .percent-input { 
            position: relative; 
        }
        .percent-input::after { 
            content: '%'; 
            position: absolute; 
            right: 12px; 
            top: 50%; 
            transform: translateY(-50%); 
            color: #666; 
            font-weight: 600; 
        }
        .percent-input input { 
            padding-right: 25px !important; 
        }
        
        .btn { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 15px 30px; 
            border: none; 
            border-radius: 8px; 
            font-size: 18px; 
            font-weight: 600; 
            cursor: pointer; 
            width: 100%; 
            transition: all 0.3s; 
        }
        .btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); 
        }
        
        .result-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 25px; 
            border-radius: 12px; 
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
            font-size: 1.2rem; 
            opacity: 0.9; 
            margin-bottom: 10px; 
            font-weight: 400; 
            position: relative; 
            z-index: 1; 
        }
        .result-card .amount { 
            font-size: 3rem; 
            font-weight: bold; 
            position: relative; 
            z-index: 1; 
        }
        
        .metric-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-bottom: 20px; 
        }
        .metric-card { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 12px; 
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
            font-size: 0.9rem; 
            margin-bottom: 10px; 
            font-weight: 400; 
        }
        .metric-card .value { 
            color: #667eea; 
            font-size: 1.8rem; 
            font-weight: bold; 
        }
        
        .breakdown { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 12px; 
            margin-bottom: 20px; 
        }
        .breakdown h3 { 
            color: #667eea; 
            margin-bottom: 15px; 
            font-size: 1.3rem; 
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
        
        .cost-comparison { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 15px; 
            margin-top: 15px; 
        }
        .cost-card { 
            background: white; 
            padding: 15px; 
            border-radius: 8px; 
            border: 2px solid #e0e0e0; 
            text-align: center; 
            transition: all 0.3s; 
        }
        .cost-card:hover { 
            transform: translateY(-2px); 
            border-color: #667eea; 
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.2); 
        }
        .cost-card h4 { 
            color: #667eea; 
            margin-bottom: 10px; 
        }
        .cost-card .cost { 
            font-size: 1.5rem; 
            font-weight: bold; 
            color: #333; 
        }
        .cost-card .period { 
            color: #666; 
            font-size: 0.9rem; 
        }
        
        .lease-preset { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
            gap: 8px; 
            margin-top: 10px; 
        }
        .preset-btn { 
            padding: 10px 12px; 
            background: #f0f0f0; 
            border: 2px solid #e0e0e0; 
            border-radius: 6px; 
            cursor: pointer; 
            text-align: center; 
            font-size: 0.85rem; 
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
        
        .progress-bar { 
            background: #e0e0e0; 
            height: 8px; 
            border-radius: 4px; 
            overflow: hidden; 
            margin: 10px 0; 
        }
        .progress-fill { 
            height: 100%; 
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); 
            width: 0%; 
            transition: width 1s ease-out; 
        }
        
        .info-box { 
            background: #e8f2ff; 
            border-left: 4px solid #667eea; 
            padding: 15px; 
            margin: 20px 0; 
            border-radius: 5px; 
        }
        .info-box strong { 
            color: #667eea; 
        }
        
        .footer { 
            background: rgba(255,255,255,0.95); 
            padding: 25px; 
            border-radius: 0 0 20px 20px; 
            text-align: center; 
            color: #7f8c8d; 
        }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { 
                grid-template-columns: 1fr; 
                padding: 25px; 
            }
            .result-card .amount { 
                font-size: 2.5rem; 
            }
        }
        
        @media (max-width: 768px) {
            .header h1 { 
                font-size: 2rem; 
            }
            .metric-grid { 
                grid-template-columns: 1fr; 
            }
            .input-group { 
                grid-template-columns: 1fr; 
            }
            .lease-preset { 
                grid-template-columns: repeat(2, 1fr); 
            }
            .cost-comparison { 
                grid-template-columns: 1fr; 
            }
        }
        
        @media (max-width: 480px) {
            .header h1 { 
                font-size: 1.5rem; 
            }
            .header p { 
                font-size: 1rem; 
            }
            .result-card .amount { 
                font-size: 2rem; 
            }
            body { 
                padding: 10px; 
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚗 Car Lease Calculator</h1>
            <p>Calculate monthly payments, total costs, and analyze lease terms</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Lease Details</h2>
                <form id="leaseForm">
                    <div class="form-group">
                        <label for="vehiclePrice">Vehicle Price (MSRP)</label>
                        <div class="currency-input">
                            <input type="number" id="vehiclePrice" value="35000" min="1000" max="500000" step="1000" required>
                        </div>
                        <small>Manufacturer's Suggested Retail Price</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="downPayment">Down Payment</label>
                        <div class="currency-input">
                            <input type="number" id="downPayment" value="3000" min="0" max="100000" step="100" required>
                        </div>
                        <small>Initial payment to reduce monthly costs</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="tradeInValue">Trade-in Value</label>
                        <div class="currency-input">
                            <input type="number" id="tradeInValue" value="0" min="0" max="100000" step="100" required>
                        </div>
                        <small>Value of your current vehicle (if applicable)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="leaseTerm">Lease Term (Months)</label>
                        <select id="leaseTerm" style="padding: 12px;">
                            <option value="24">24 Months</option>
                            <option value="36" selected>36 Months</option>
                            <option value="48">48 Months</option>
                            <option value="60">60 Months</option>
                        </select>
                        <small>Duration of the lease agreement</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Money Factor (Interest Rate)</label>
                        <div class="percent-input">
                            <input type="number" id="interestRate" value="3.5" min="0.1" max="20" step="0.1" required>
                        </div>
                        <small>Lease interest rate (money factor converted to APR)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="residualValue">Residual Value Percentage</label>
                        <div class="percent-input">
                            <input type="number" id="residualValue" value="55" min="10" max="80" step="1" required>
                        </div>
                        <small>Vehicle's estimated value at lease end (40-60% typical)</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Lease Presets</label>
                        <div class="lease-preset">
                            <div class="preset-btn" onclick="setPreset('Economy', '25000', '2000', '0', '36', '4.5', '55')">Economy Car</div>
                            <div class="preset-btn" onclick="setPreset('Luxury', '60000', '5000', '0', '36', '2.9', '50')">Luxury Car</div>
                            <div class="preset-btn" onclick="setPreset('SUV', '45000', '3000', '0', '48', '3.9', '52')">SUV</div>
                            <div class="preset-btn" onclick="setPreset('EV', '55000', '4000', '0', '36', '2.5', '45')">Electric Vehicle</div>
                            <div class="preset-btn" onclick="setPreset('Short', '40000', '2500', '0', '24', '3.0', '60')">Short Term</div>
                            <div class="preset-btn" onclick="setPreset('Long', '35000', '2000', '0', '60', '4.5', '40')">Long Term</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="salesTax">Sales Tax Rate</label>
                        <div class="percent-input">
                            <input type="number" id="salesTax" value="7.5" min="0" max="15" step="0.1" required>
                        </div>
                        <small>Your local sales tax percentage</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="fees">Fees & Acquisition Cost</label>
                        <div class="currency-input">
                            <input type="number" id="fees" value="1000" min="0" max="5000" step="50" required>
                        </div>
                        <small>Documentation, acquisition, and other fees</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="mileageLimit">Annual Mileage Limit</label>
                        <select id="mileageLimit" style="padding: 12px;">
                            <option value="10000">10,000 miles</option>
                            <option value="12000" selected>12,000 miles</option>
                            <option value="15000">15,000 miles</option>
                            <option value="18000">18,000 miles</option>
                        </select>
                        <small>Maximum miles allowed per year</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Lease Payments</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Lease Analysis</h2>
                
                <div class="result-card">
                    <h3>Monthly Lease Payment</h3>
                    <div class="amount" id="monthlyPayment">$478</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Lease Cost</h4>
                        <div class="value" id="totalCost">$17,208</div>
                    </div>
                    <div class="metric-card">
                        <h4>Due at Signing</h4>
                        <div class="value" id="dueAtSigning">$4,000</div>
                    </div>
                    <div class="metric-card">
                        <h4>Residual Value</h4>
                        <div class="value" id="residualAmount">$19,250</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Payment Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Depreciation Amount</span>
                        <strong id="depreciationAmount">$12,750</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Depreciation</span>
                        <strong id="monthlyDepreciation">$354</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Finance Charge</span>
                        <strong id="financeCharge">$124</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Finance</span>
                        <strong id="monthlyFinance">$3.44</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Sales Tax (Monthly)</span>
                        <strong id="monthlyTax">$36</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fees (Amortized)</span>
                        <strong id="monthlyFees">$28</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Lease Terms</h3>
                    <div class="breakdown-item">
                        <span>Lease Term</span>
                        <strong id="leaseTermDisplay">36 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Miles Allowed</span>
                        <strong id="totalMiles">36,000 miles</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cost per Mile</span>
                        <strong id="costPerMile">$0.48/mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Money Factor</span>
                        <strong id="moneyFactor">0.00146</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Effective Interest Rate</span>
                        <strong id="effectiveRate">3.5% APR</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Comparison</h3>
                    <div class="cost-comparison">
                        <div class="cost-card">
                            <h4>Monthly</h4>
                            <div class="cost" id="costMonthly">$478</div>
                            <div class="period">Per Month</div>
                        </div>
                        <div class="cost-card">
                            <h4>Annual</h4>
                            <div class="cost" id="costAnnual">$5,736</div>
                            <div class="period">Per Year</div>
                        </div>
                        <div class="cost-card">
                            <h4>Total Lease</h4>
                            <div class="cost" id="costTotal">$17,208</div>
                            <div class="period">Over 36 months</div>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Equity & Value Analysis</h3>
                    <div class="breakdown-item">
                        <span>Vehicle Value Today</span>
                        <strong id="vehicleValue">$35,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Amount Financed</span>
                        <strong id="amountFinanced">$32,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Residual Percentage</span>
                        <strong id="residualPercent">55%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Residual Value</span>
                        <strong id="residualValueDisplay">$19,250</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Potential Buyout</span>
                        <strong id="buyoutPrice">$19,250</strong>
                    </div>
                    
                    <div class="progress-bar">
                        <div class="progress-fill" id="depreciationProgress"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: #666;">
                        <span>Start: $35,000</span>
                        <span>End: $19,250</span>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Additional Costs</h3>
                    <div class="breakdown-item">
                        <span>Upfront Costs</span>
                        <strong id="upfrontCosts">$4,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Excess Mileage Cost</span>
                        <strong id="excessMileage">$0.25/mile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Potential Wear & Tear</span>
                        <strong id="wearTear">$500-1,500</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Disposition Fee</span>
                        <strong id="dispositionFee">$395</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> Lease calculations assume standard terms. Actual payments may vary based on credit score, dealer incentives, and regional factors. Always review the full lease agreement before signing.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🚗 Car Lease Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced lease payment calculations and analysis</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('leaseForm');
        let currentPreset = '';

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateLease();
        });

        function setPreset(name, price, down, trade, term, rate, residual) {
            document.getElementById('vehiclePrice').value = price;
            document.getElementById('downPayment').value = down;
            document.getElementById('tradeInValue').value = trade;
            document.getElementById('leaseTerm').value = term;
            document.getElementById('interestRate').value = rate;
            document.getElementById('residualValue').value = residual;
            currentPreset = name;
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateLease();
        }

        function calculateLease() {
            // Get inputs
            const vehiclePrice = parseFloat(document.getElementById('vehiclePrice').value);
            const downPayment = parseFloat(document.getElementById('downPayment').value);
            const tradeInValue = parseFloat(document.getElementById('tradeInValue').value);
            const leaseTerm = parseInt(document.getElementById('leaseTerm').value);
            const interestRate = parseFloat(document.getElementById('interestRate').value);
            const residualPercentage = parseFloat(document.getElementById('residualValue').value);
            const salesTax = parseFloat(document.getElementById('salesTax').value);
            const fees = parseFloat(document.getElementById('fees').value);
            const mileageLimit = parseInt(document.getElementById('mileageLimit').value);
            
            // Convert APR to money factor
            const moneyFactor = interestRate / 2400;
            
            // Calculate residual value
            const residualValue = vehiclePrice * (residualPercentage / 100);
            
            // Calculate depreciation
            const netCapitalizedCost = vehiclePrice - downPayment - tradeInValue;
            const totalDepreciation = netCapitalizedCost - residualValue;
            const monthlyDepreciation = totalDepreciation / leaseTerm;
            
            // Calculate finance charge
            const averageBalance = (netCapitalizedCost + residualValue) / 2;
            const monthlyFinanceCharge = averageBalance * moneyFactor;
            
            // Calculate base monthly payment
            const baseMonthlyPayment = monthlyDepreciation + monthlyFinanceCharge;
            
            // Calculate sales tax
            const monthlyTax = baseMonthlyPayment * (salesTax / 100);
            
            // Amortize fees
            const monthlyFees = fees / leaseTerm;
            
            // Calculate total monthly payment
            const totalMonthlyPayment = baseMonthlyPayment + monthlyTax + monthlyFees;
            
            // Calculate total costs
            const totalLeaseCost = totalMonthlyPayment * leaseTerm;
            const dueAtSigning = downPayment + tradeInValue + (totalMonthlyPayment); // First payment + fees
            const totalCost = totalLeaseCost + dueAtSigning;
            
            // Calculate additional metrics
            const totalMiles = (mileageLimit / 12) * leaseTerm;
            const costPerMile = totalLeaseCost / totalMiles;
            const amountFinanced = vehiclePrice - downPayment - tradeInValue;
            
            // Calculate excess mileage cost (typical $0.15-$0.30 per mile)
            const excessMileageRate = 0.25;
            
            // Typical fees
            const dispositionFee = 395;
            const wearTearMin = 500;
            const wearTearMax = 1500;
            
            // Update UI
            document.getElementById('monthlyPayment').textContent = '$' + Math.round(totalMonthlyPayment);
            document.getElementById('totalCost').textContent = '$' + formatNumber(Math.round(totalLeaseCost));
            document.getElementById('dueAtSigning').textContent = '$' + formatNumber(Math.round(dueAtSigning));
            document.getElementById('residualAmount').textContent = '$' + formatNumber(Math.round(residualValue));
            
            document.getElementById('depreciationAmount').textContent = '$' + formatNumber(Math.round(totalDepreciation));
            document.getElementById('monthlyDepreciation').textContent = '$' + Math.round(monthlyDepreciation);
            document.getElementById('financeCharge').textContent = '$' + Math.round(monthlyFinanceCharge * leaseTerm);
            document.getElementById('monthlyFinance').textContent = '$' + monthlyFinanceCharge.toFixed(2);
            document.getElementById('monthlyTax').textContent = '$' + Math.round(monthlyTax);
            document.getElementById('monthlyFees').textContent = '$' + monthlyFees.toFixed(2);
            
            document.getElementById('leaseTermDisplay').textContent = leaseTerm + ' months';
            document.getElementById('totalMiles').textContent = formatNumber(totalMiles) + ' miles';
            document.getElementById('costPerMile').textContent = '$' + costPerMile.toFixed(2) + '/mile';
            document.getElementById('moneyFactor').textContent = moneyFactor.toFixed(5);
            document.getElementById('effectiveRate').textContent = interestRate.toFixed(1) + '% APR';
            
            document.getElementById('costMonthly').textContent = '$' + Math.round(totalMonthlyPayment);
            document.getElementById('costAnnual').textContent = '$' + formatNumber(Math.round(totalMonthlyPayment * 12));
            document.getElementById('costTotal').textContent = '$' + formatNumber(Math.round(totalLeaseCost));
            
            document.getElementById('vehicleValue').textContent = '$' + formatNumber(vehiclePrice);
            document.getElementById('amountFinanced').textContent = '$' + formatNumber(Math.round(amountFinanced));
            document.getElementById('residualPercent').textContent = residualPercentage + '%';
            document.getElementById('residualValueDisplay').textContent = '$' + formatNumber(Math.round(residualValue));
            document.getElementById('buyoutPrice').textContent = '$' + formatNumber(Math.round(residualValue));
            
            document.getElementById('upfrontCosts').textContent = '$' + formatNumber(Math.round(dueAtSigning));
            document.getElementById('excessMileage').textContent = '$' + excessMileageRate.toFixed(2) + '/mile';
            document.getElementById('wearTear').textContent = '$' + wearTearMin + '-' + formatNumber(wearTearMax);
            document.getElementById('dispositionFee').textContent = '$' + dispositionFee;
            
            // Update depreciation progress bar
            const depreciationProgress = ((vehiclePrice - residualValue) / vehiclePrice) * 100;
            document.getElementById('depreciationProgress').style.width = depreciationProgress + '%';
        }
        
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateLease();
        });
    </script>
</body>
</html>
