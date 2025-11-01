<?php
/**
 * Gas Mileage Calculator
 * File: automotive/gas-mileage-calculator.php
 * Description: Advanced fuel efficiency calculator with cost analysis and multi-currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gas Mileage Calculator - Fuel Efficiency & MPG Calculator</title>
    <meta name="description" content="Advanced gas mileage calculator for fuel efficiency calculations, cost analysis, and vehicle comparison with multi-currency support.">
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
        
        .input-group { 
            display: grid; 
            grid-template-columns: 2fr 1fr; 
            gap: 10px; 
            align-items: end; 
        }
        
        .currency-selector {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }
        
        .currency-selector label {
            font-weight: 600;
            color: #555;
            white-space: nowrap;
        }
        
        .currency-selector select {
            flex: 1;
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 16px;
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
        
        .efficiency-meter { 
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
            background: linear-gradient(90deg, #e74c3c, #f39c12, #27ae60); 
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
        
        .comparison-grid { 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            gap: 15px; 
            margin: 15px 0; 
        }
        
        .comparison-card { 
            background: #f8f9fa; 
            padding: 15px; 
            border-radius: 8px; 
            text-align: center; 
            border: 2px solid #e0e0e0; 
        }
        
        .comparison-card h4 { 
            color: #666; 
            font-size: 0.9rem; 
            margin-bottom: 8px; 
        }
        
        .comparison-card .value { 
            color: #667eea; 
            font-size: 1.2rem; 
            font-weight: bold; 
        }
        
        .footer { 
            background: rgba(255,255,255,0.95); 
            padding: 20px; 
            border-radius: 0 0 15px 15px; 
            text-align: center; 
            color: #7f8c8d; 
            margin-top: 0;
        }
        
        .currency-symbol {
            font-weight: bold;
            color: #667eea;
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
            
            .comparison-grid {
                grid-template-columns: repeat(2, 1fr);
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
            
            .comparison-grid {
                grid-template-columns: 1fr;
            }
            
            .currency-selector {
                flex-direction: column;
                align-items: stretch;
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
            
            .efficiency-meter {
                padding: 15px;
            }
            
            .input-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⛽ Gas Mileage Calculator</h1>
            <p>Advanced fuel efficiency calculator with cost analysis and multi-currency support</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Trip Information</h2>
                
                <div class="currency-selector">
                    <label for="currency">Currency:</label>
                    <select id="currency" onchange="updateCurrency()">
                        <option value="USD">US Dollar ($)</option>
                        <option value="EUR">Euro (€)</option>
                        <option value="GBP">British Pound (£)</option>
                        <option value="JPY">Japanese Yen (¥)</option>
                        <option value="INR" selected>Indian Rupee (₹)</option>
                        <option value="CAD">Canadian Dollar (C$)</option>
                        <option value="AUD">Australian Dollar (A$)</option>
                        <option value="CNY">Chinese Yuan (¥)</option>
                    </select>
                </div>
                
                <form id="mileageForm">
                    <div class="form-group">
                        <label for="distance">Distance Traveled</label>
                        <div class="input-group">
                            <input type="number" id="distance" value="300" min="1" step="1" required>
                            <select id="distanceUnit" style="padding: 12px;">
                                <option value="miles">Miles</option>
                                <option value="kilometers">Kilometers</option>
                            </select>
                        </div>
                        <small>Total distance driven</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="fuelUsed">Fuel Used</label>
                        <div class="input-group">
                            <input type="number" id="fuelUsed" value="12" min="0.1" step="0.1" required>
                            <select id="fuelUnit" style="padding: 12px;">
                                <option value="gallons">Gallons</option>
                                <option value="liters">Liters</option>
                            </select>
                        </div>
                        <small>Amount of fuel consumed</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="fuelPrice">Fuel Price</label>
                        <div class="input-group">
                            <input type="number" id="fuelPrice" value="100" min="0.1" step="0.1" required>
                            <select id="priceUnit" style="padding: 12px;">
                                <option value="gallon">per Gallon</option>
                                <option value="liter">per Liter</option>
                            </select>
                        </div>
                        <small>Current fuel price in <span id="currencyLabel">₹</span></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="annualMileage">Annual Mileage</label>
                        <div class="input-group">
                            <input type="number" id="annualMileage" value="12000" min="100" step="100">
                            <select id="annualUnit" style="padding: 12px;">
                                <option value="miles">Miles</option>
                                <option value="kilometers">Kilometers</option>
                            </select>
                        </div>
                        <small>Estimated yearly driving distance</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Vehicle Presets</label>
                        <div class="preset-buttons">
                            <div class="preset-btn" onclick="setVehiclePreset('compact')">Compact Car</div>
                            <div class="preset-btn" onclick="setVehiclePreset('sedan')">Sedan</div>
                            <div class="preset-btn" onclick="setVehiclePreset('suv')">SUV</div>
                            <div class="preset-btn" onclick="setVehiclePreset('truck')">Truck</div>
                            <div class="preset-btn" onclick="setVehiclePreset('hybrid')">Hybrid</div>
                            <div class="preset-btn" onclick="setVehiclePreset('electric')">Electric</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="compareMpg">Compare With (MPG)</label>
                        <input type="number" id="compareMpg" value="35" min="1" step="1">
                        <small>Compare with another vehicle's fuel efficiency</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Mileage</button>
                </form>
                
                <div class="info-box">
                    <strong>Tip:</strong> Regular maintenance, proper tire inflation, and smooth driving can improve your fuel efficiency by up to 15%.
                </div>
            </div>

            <div class="results-section">
                <h2>Fuel Efficiency Analysis</h2>
                
                <div class="result-card">
                    <h3>Fuel Efficiency</h3>
                    <div class="amount" id="mpgResult">25.0 MPG</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Cost per Mile</h4>
                        <div class="value"><span class="currency-symbol" id="costSymbol">₹</span><span id="costPerMile">4.20</span></div>
                    </div>
                    <div class="metric-card">
                        <h4>Trip Cost</h4>
                        <div class="value"><span class="currency-symbol" id="tripSymbol">₹</span><span id="tripCost">1,260</span></div>
                    </div>
                    <div class="metric-card">
                        <h4>Annual Fuel Cost</h4>
                        <div class="value"><span class="currency-symbol" id="annualSymbol">₹</span><span id="annualCost">50,400</span></div>
                    </div>
                    <div class="metric-card">
                        <h4>Fuel Consumption</h4>
                        <div class="value" id="fuelConsumption">4.0 gal/100mi</div>
                    </div>
                </div>

                <div class="efficiency-meter">
                    <h3>Fuel Efficiency Rating</h3>
                    <div class="meter">
                        <div class="meter-fill" id="efficiencyMeter" style="width: 50%;"></div>
                    </div>
                    <div class="meter-labels">
                        <span>Poor</span>
                        <span>Average</span>
                        <span>Excellent</span>
                    </div>
                    <div id="efficiencyText" style="color: #f39c12; font-weight: bold; margin-top: 10px;">Average Efficiency</div>
                </div>

                <div class="breakdown">
                    <h3>Trip Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Distance Traveled</span>
                        <strong id="breakdownDistance">300 miles</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fuel Used</span>
                        <strong id="breakdownFuel">12 gallons</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fuel Price</span>
                        <strong id="breakdownPrice"><span class="currency-symbol" id="priceSymbol">₹</span>100/gallon</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fuel Efficiency</span>
                        <strong id="breakdownEfficiency">25.0 MPG</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Trip Fuel Cost</span>
                        <strong id="breakdownTripCost"><span class="currency-symbol" id="tripBreakdownSymbol">₹</span>1,260</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cost per Mile</span>
                        <strong id="breakdownCostPerMile"><span class="currency-symbol" id="mileSymbol">₹</span>4.20/mile</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Vehicle Comparison</h3>
                    <div class="comparison-grid">
                        <div class="comparison-card">
                            <h4>Your Vehicle</h4>
                            <div class="value" id="yourMpg">25.0 MPG</div>
                            <div style="font-size: 0.8rem; color: #666;">Annual Cost: <span class="currency-symbol" id="yourCostSymbol">₹</span><span id="yourAnnualCost">50,400</span></div>
                        </div>
                        <div class="comparison-card">
                            <h4>Comparison Vehicle</h4>
                            <div class="value" id="compareMpgResult">35.0 MPG</div>
                            <div style="font-size: 0.8rem; color: #666;">Annual Cost: <span class="currency-symbol" id="compareCostSymbol">₹</span><span id="compareAnnualCost">36,000</span></div>
                        </div>
                    </div>
                    <div class="breakdown-item" style="margin-top: 15px;">
                        <span>Annual Savings</span>
                        <strong id="annualSavings" style="color: #27ae60;"><span class="currency-symbol" id="savingsSymbol">₹</span>14,400</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fuel Savings</span>
                        <strong id="fuelSavings" style="color: #27ae60;">137 gallons/year</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Environmental Impact</h3>
                    <div class="breakdown-item">
                        <span>CO₂ Emissions</span>
                        <strong id="co2Emissions">240 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Annual CO₂</span>
                        <strong id="annualCo2">9,600 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Equivalent Trees</span>
                        <strong id="equivalentTrees">4 trees</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Carbon Offset Cost</span>
                        <strong id="carbonOffset"><span class="currency-symbol" id="carbonSymbol">₹</span>480</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> Fuel efficiency can vary based on driving conditions, vehicle maintenance, and driving habits. These calculations are estimates.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⛽ Gas Mileage Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced fuel efficiency calculation and cost analysis with multi-currency support</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('mileageForm');
        
        // Currency exchange rates (relative to USD)
        const exchangeRates = {
            USD: { symbol: '$', rate: 1, name: 'US Dollar' },
            EUR: { symbol: '€', rate: 0.85, name: 'Euro' },
            GBP: { symbol: '£', rate: 0.73, name: 'British Pound' },
            JPY: { symbol: '¥', rate: 110, name: 'Japanese Yen' },
            INR: { symbol: '₹', rate: 75, name: 'Indian Rupee' },
            CAD: { symbol: 'C$', rate: 1.25, name: 'Canadian Dollar' },
            AUD: { symbol: 'A$', rate: 1.35, name: 'Australian Dollar' },
            CNY: { symbol: '¥', rate: 6.45, name: 'Chinese Yuan' }
        };

        // Default fuel prices in different currencies (per gallon)
        const defaultFuelPrices = {
            USD: 3.50,
            EUR: 3.00,
            GBP: 2.60,
            JPY: 385,
            INR: 100,
            CAD: 4.40,
            AUD: 4.70,
            CNY: 22.50
        };

        // Vehicle presets with typical MPG values
        const vehiclePresets = {
            compact: {
                distance: 300,
                fuelUsed: 10,
                mpg: 30
            },
            sedan: {
                distance: 300,
                fuelUsed: 12,
                mpg: 25
            },
            suv: {
                distance: 300,
                fuelUsed: 15,
                mpg: 20
            },
            truck: {
                distance: 300,
                fuelUsed: 18,
                mpg: 16.7
            },
            hybrid: {
                distance: 300,
                fuelUsed: 8,
                mpg: 37.5
            },
            electric: {
                distance: 300,
                fuelUsed: 0,
                mpg: 999
            }
        };

        let currentCurrency = 'INR';

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateMileage();
        });

        function updateCurrency() {
            const currencySelect = document.getElementById('currency');
            currentCurrency = currencySelect.value;
            
            // Update currency symbol in labels
            document.getElementById('currencyLabel').textContent = exchangeRates[currentCurrency].symbol;
            
            // Update default fuel price for selected currency
            document.getElementById('fuelPrice').value = defaultFuelPrices[currentCurrency];
            
            // Recalculate with new currency
            calculateMileage();
        }

        function setVehiclePreset(presetName) {
            const preset = vehiclePresets[presetName];
            
            document.getElementById('distance').value = preset.distance;
            document.getElementById('fuelUsed').value = preset.fuelUsed;
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateMileage();
        }

        function formatCurrency(amount, currency) {
            const symbol = exchangeRates[currency].symbol;
            const rate = exchangeRates[currency].rate;
            
            // Convert amount to selected currency
            const convertedAmount = amount * rate;
            
            // Format number based on currency
            if (currency === 'JPY' || currency === 'INR') {
                return convertedAmount.toFixed(0);
            } else if (convertedAmount >= 1000) {
                return convertedAmount.toFixed(0);
            } else if (convertedAmount >= 100) {
                return convertedAmount.toFixed(0);
            } else {
                return convertedAmount.toFixed(2);
            }
        }

        function calculateMileage() {
            // Get inputs
            const distance = parseFloat(document.getElementById('distance').value);
            const fuelUsed = parseFloat(document.getElementById('fuelUsed').value);
            const fuelPrice = parseFloat(document.getElementById('fuelPrice').value);
            const annualMileage = parseFloat(document.getElementById('annualMileage').value);
            const compareMpg = parseFloat(document.getElementById('compareMpg').value);
            
            const distanceUnit = document.getElementById('distanceUnit').value;
            const fuelUnit = document.getElementById('fuelUnit').value;
            const priceUnit = document.getElementById('priceUnit').value;
            const annualUnit = document.getElementById('annualUnit').value;

            // Convert to standard units (miles and gallons)
            let distanceMiles = distance;
            let fuelGallons = fuelUsed;
            let annualMiles = annualMileage;
            let pricePerGallon = fuelPrice;

            // Convert distance to miles if in kilometers
            if (distanceUnit === 'kilometers') {
                distanceMiles = distance * 0.621371;
            }

            // Convert fuel to gallons if in liters
            if (fuelUnit === 'liters') {
                fuelGallons = fuelUsed * 0.264172;
            }

            // Convert annual mileage to miles if in kilometers
            if (annualUnit === 'kilometers') {
                annualMiles = annualMileage * 0.621371;
            }

            // Convert price to per gallon if per liter
            if (priceUnit === 'liter') {
                pricePerGallon = fuelPrice * 3.78541;
            }

            // Calculate MPG
            const mpg = distanceMiles / fuelGallons;
            
            // Calculate costs (in base currency - USD)
            const tripCostUSD = fuelGallons * (pricePerGallon / exchangeRates[currentCurrency].rate);
            const costPerMileUSD = tripCostUSD / distanceMiles;
            const annualFuelCostUSD = (annualMiles / mpg) * (pricePerGallon / exchangeRates[currentCurrency].rate);
            
            // Calculate fuel consumption (gallons per 100 miles)
            const fuelConsumption = (fuelGallons / distanceMiles) * 100;
            
            // Calculate comparison values
            const compareAnnualCostUSD = (annualMiles / compareMpg) * (pricePerGallon / exchangeRates[currentCurrency].rate);
            const annualSavingsUSD = annualFuelCostUSD - compareAnnualCostUSD;
            const fuelSavings = (annualMiles / mpg) - (annualMiles / compareMpg);
            
            // Calculate environmental impact
            const co2PerGallon = 19.6; // pounds of CO2 per gallon of gasoline
            const co2Emissions = fuelGallons * co2PerGallon;
            const annualCo2 = (annualMiles / mpg) * co2PerGallon;
            const equivalentTrees = annualCo2 / 48; // trees needed to offset (approx 48 lbs CO2 per tree per year)
            const carbonOffsetUSD = annualCo2 * 0.02; // $0.02 per pound of CO2

            // Update UI with formatted currency
            document.getElementById('mpgResult').textContent = `${mpg.toFixed(1)} MPG`;
            
            // Update metric cards with currency symbols
            document.getElementById('costSymbol').textContent = exchangeRates[currentCurrency].symbol;
            document.getElementById('costPerMile').textContent = formatCurrency(costPerMileUSD, currentCurrency);
            
            document.getElementById('tripSymbol').textContent = exchangeRates[currentCurrency].symbol;
            document.getElementById('tripCost').textContent = formatCurrency(tripCostUSD, currentCurrency);
            
            document.getElementById('annualSymbol').textContent = exchangeRates[currentCurrency].symbol;
            document.getElementById('annualCost').textContent = formatCurrency(annualFuelCostUSD, currentCurrency);
            
            document.getElementById('fuelConsumption').textContent = `${fuelConsumption.toFixed(1)} gal/100mi`;

            // Update breakdown
            document.getElementById('breakdownDistance').textContent = `${distanceMiles.toFixed(0)} miles`;
            document.getElementById('breakdownFuel').textContent = `${fuelGallons.toFixed(1)} gallons`;
            
            document.getElementById('priceSymbol').textContent = exchangeRates[currentCurrency].symbol;
            document.getElementById('breakdownPrice').innerHTML = `<span class="currency-symbol">${exchangeRates[currentCurrency].symbol}</span>${formatCurrency(pricePerGallon / exchangeRates[currentCurrency].rate, currentCurrency)}/gallon`;
            
            document.getElementById('breakdownEfficiency').textContent = `${mpg.toFixed(1)} MPG`;
            
            document.getElementById('tripBreakdownSymbol').textContent = exchangeRates[currentCurrency].symbol;
            document.getElementById('breakdownTripCost').innerHTML = `<span class="currency-symbol">${exchangeRates[currentCurrency].symbol}</span>${formatCurrency(tripCostUSD, currentCurrency)}`;
            
            document.getElementById('mileSymbol').textContent = exchangeRates[currentCurrency].symbol;
            document.getElementById('breakdownCostPerMile').innerHTML = `<span class="currency-symbol">${exchangeRates[currentCurrency].symbol}</span>${formatCurrency(costPerMileUSD, currentCurrency)}/mile`;

            // Update comparison
            document.getElementById('yourMpg').textContent = `${mpg.toFixed(1)} MPG`;
            document.getElementById('compareMpgResult').textContent = `${compareMpg.toFixed(1)} MPG`;
            
            document.getElementById('yourCostSymbol').textContent = exchangeRates[currentCurrency].symbol;
            document.getElementById('yourAnnualCost').textContent = formatCurrency(annualFuelCostUSD, currentCurrency);
            
            document.getElementById('compareCostSymbol').textContent = exchangeRates[currentCurrency].symbol;
            document.getElementById('compareAnnualCost').textContent = formatCurrency(compareAnnualCostUSD, currentCurrency);
            
            document.getElementById('savingsSymbol').textContent = exchangeRates[currentCurrency].symbol;
            document.getElementById('annualSavings').innerHTML = `<span class="currency-symbol">${exchangeRates[currentCurrency].symbol}</span>${formatCurrency(Math.abs(annualSavingsUSD), currentCurrency)}`;
            
            document.getElementById('fuelSavings').textContent = `${Math.abs(fuelSavings).toFixed(0)} gallons/year`;

            // Update environmental impact
            document.getElementById('co2Emissions').textContent = `${co2Emissions.toFixed(0)} lbs`;
            document.getElementById('annualCo2').textContent = `${annualCo2.toFixed(0)} lbs`;
            document.getElementById('equivalentTrees').textContent = `${equivalentTrees.toFixed(0)} trees`;
            
            document.getElementById('carbonSymbol').textContent = exchangeRates[currentCurrency].symbol;
            document.getElementById('carbonOffset').innerHTML = `<span class="currency-symbol">${exchangeRates[currentCurrency].symbol}</span>${formatCurrency(carbonOffsetUSD, currentCurrency)}`;

            // Update efficiency meter
            updateEfficiencyMeter(mpg);
        }

        function updateEfficiencyMeter(mpg) {
            const meter = document.getElementById('efficiencyMeter');
            const text = document.getElementById('efficiencyText');
            
            let meterWidth, status, color;
            
            if (mpg >= 35) {
                meterWidth = 90;
                status = 'Excellent';
                color = '#27ae60';
            } else if (mpg >= 25) {
                meterWidth = 60;
                status = 'Good';
                color = '#f39c12';
            } else if (mpg >= 20) {
                meterWidth = 40;
                status = 'Average';
                color = '#f39c12';
            } else if (mpg >= 15) {
                meterWidth = 25;
                status = 'Poor';
                color = '#e74c3c';
            } else {
                meterWidth = 10;
                status = 'Very Poor';
                color = '#e74c3c';
            }
            
            meter.style.width = `${meterWidth}%`;
            text.textContent = `${status} Efficiency (${mpg.toFixed(1)} MPG)`;
            text.style.color = color;
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateMileage();
        });
    </script>
</body>
</html>