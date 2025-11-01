<?php
/**
 * Car Depreciation Calculator
 * File: automotive/car-depreciation-calculator.php
 * Description: Advanced calculator for vehicle depreciation, value projection, and ownership cost analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Depreciation Calculator - Vehicle Value & Ownership Cost Analysis</title>
    <meta name="description" content="Advanced car depreciation calculator. Calculate vehicle value loss, ownership costs, and future value projections.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #ff6b35; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #ff6b35; box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255, 107, 53, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3); position: relative; overflow: hidden; }
        .result-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 0.8; } }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; position: relative; z-index: 1; }
        .result-card .amount { font-size: 3rem; font-weight: bold; position: relative; z-index: 1; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #ff6b35; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #ff6b35; font-size: 1.8rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #ff6b35; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .progress-bar { background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #ff6b35 0%, #f7931e 100%); width: 0%; transition: width 1s ease-out; }
        
        .info-box { background: #ffe8e0; border-left: 4px solid #ff6b35; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #ff6b35; }
        
        .car-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 8px; margin-top: 10px; }
        .car-btn { padding: 10px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .car-btn:hover { background: #ff6b35; color: white; border-color: #ff6b35; }
        .car-btn.active { background: #ff6b35; color: white; border-color: #ff6b35; }
        
        .condition-slider { display: flex; align-items: center; gap: 15px; margin-top: 10px; }
        .condition-slider input { flex: 1; }
        .condition-value { min-width: 60px; text-align: center; font-weight: 600; color: #ff6b35; }
        
        .depreciation-chart { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .chart-container { height: 300px; position: relative; margin: 20px 0; }
        .chart-bar { position: absolute; bottom: 0; background: linear-gradient(to top, #ff6b35, #f7931e); border-radius: 4px 4px 0 0; transition: all 0.5s ease-out; width: 30px; }
        .chart-label { position: absolute; bottom: -25px; text-align: center; font-size: 0.8rem; color: #666; width: 100%; }
        .chart-year { position: absolute; top: -25px; text-align: center; font-size: 0.9rem; font-weight: 600; color: #333; width: 100%; }
        
        .value-comparison { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
        .comparison-card { background: white; padding: 15px; border-radius: 8px; border: 2px solid #e0e0e0; text-align: center; }
        .comparison-card h4 { color: #666; margin-bottom: 10px; font-size: 0.9rem; }
        .comparison-value { font-size: 1.5rem; font-weight: bold; color: #ff6b35; }
        
        .ownership-costs { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .cost-item { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0; }
        .cost-item:last-child { border-bottom: none; margin-bottom: 0; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
            .value-comparison { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .car-preset { grid-template-columns: repeat(2, 1fr); }
            .chart-container { height: 250px; }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
            .chart-container { height: 200px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚗 Car Depreciation Calculator</h1>
            <p>Calculate vehicle value loss, ownership costs, and future value projections</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Vehicle Information</h2>
                <form id="depreciationForm">
                    <div class="form-group">
                        <label for="vehiclePrice">Vehicle Purchase Price ($)</label>
                        <input type="number" id="vehiclePrice" value="35000" min="1000" step="1000" required>
                        <small>Original purchase price of the vehicle</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="vehicleAge">Current Vehicle Age (years)</label>
                        <input type="number" id="vehicleAge" value="3" min="0" max="50" step="1" required>
                        <small>How many years since the vehicle was new</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="vehicleType">Vehicle Type</label>
                        <select id="vehicleType" style="padding: 12px;">
                            <option value="sedan">Sedan</option>
                            <option value="suv" selected>SUV</option>
                            <option value="truck">Truck</option>
                            <option value="luxury">Luxury Vehicle</option>
                            <option value="sports">Sports Car</option>
                            <option value="electric">Electric Vehicle</option>
                            <option value="hybrid">Hybrid Vehicle</option>
                        </select>
                        <small>Type of vehicle affects depreciation rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="vehicleBrand">Vehicle Brand</label>
                        <select id="vehicleBrand" style="padding: 12px;">
                            <option value="toyota">Toyota</option>
                            <option value="honda">Honda</option>
                            <option value="ford" selected>Ford</option>
                            <option value="chevrolet">Chevrolet</option>
                            <option value="bmw">BMW</option>
                            <option value="mercedes">Mercedes-Benz</option>
                            <option value="audi">Audi</option>
                            <option value="tesla">Tesla</option>
                        </select>
                        <small>Brand reputation affects resale value</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Vehicle Presets</label>
                        <div class="car-preset">
                            <div class="car-btn" onclick="setVehiclePreset('economy')">Economy Car</div>
                            <div class="car-btn" onclick="setVehiclePreset('midsize')">Midsize SUV</div>
                            <div class="car-btn" onclick="setVehiclePreset('luxury')">Luxury Sedan</div>
                            <div class="car-btn" onclick="setVehiclePreset('truck')">Pickup Truck</div>
                            <div class="car-btn" onclick="setVehiclePreset('electric')">Electric Vehicle</div>
                            <div class="car-btn" onclick="setVehiclePreset('sports')">Sports Car</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="mileage">Current Mileage</label>
                        <div class="input-group">
                            <input type="number" id="mileage" value="36000" min="0" step="1000" required>
                            <select id="mileageUnit" style="padding: 12px;">
                                <option value="miles" selected>Miles</option>
                                <option value="km">Kilometers</option>
                            </select>
                        </div>
                        <small>Total miles/kilometers driven</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="annualMileage">Annual Mileage</label>
                        <div class="input-group">
                            <input type="number" id="annualMileage" value="12000" min="1000" step="1000" required>
                            <select id="annualMileageUnit" style="padding: 12px;">
                                <option value="miles" selected>Miles</option>
                                <option value="km">Kilometers</option>
                            </select>
                        </div>
                        <small>Average miles/kilometers driven per year</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="vehicleCondition">Vehicle Condition</label>
                        <div class="condition-slider">
                            <span>Poor</span>
                            <input type="range" id="vehicleCondition" min="1" max="5" value="4" step="1">
                            <span>Excellent</span>
                            <div class="condition-value" id="conditionValue">Very Good</div>
                        </div>
                        <small>Overall condition and maintenance history</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="ownershipPeriod">Ownership Period (years)</label>
                        <input type="number" id="ownershipPeriod" value="5" min="1" max="20" step="1" required>
                        <small>How long you plan to keep the vehicle</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="marketTrends">Market Trends</label>
                        <select id="marketTrends" style="padding: 12px;">
                            <option value="normal" selected>Normal Market</option>
                            <option value="strong">Strong Resale Market</option>
                            <option value="weak">Weak Resale Market</option>
                            <option value="covid">Post-COVID Market</option>
                        </select>
                        <small>Current used car market conditions</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Depreciation</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Depreciation Analysis</h2>
                
                <div class="result-card">
                    <h3>Current Vehicle Value</h3>
                    <div class="amount" id="currentValue">$21,750</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Depreciation</h4>
                        <div class="value" id="totalDepreciation">$13,250</div>
                    </div>
                    <div class="metric-card">
                        <h4>Depreciation Rate</h4>
                        <div class="value" id="depreciationRate">38%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Annual Loss</h4>
                        <div class="value" id="annualLoss">$4,417</div>
                    </div>
                </div>

                <div class="depreciation-chart">
                    <h3>Value Depreciation Over Time</h3>
                    <div class="chart-container" id="depreciationChart">
                        <!-- Chart bars will be generated dynamically -->
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Value Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Original Purchase Price</span>
                        <strong id="originalPrice">$35,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Estimated Value</span>
                        <strong id="displayCurrentValue">$21,750</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Value Lost</span>
                        <strong id="valueLost">$13,250</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Future Value (5 years)</span>
                        <strong id="futureValue">$12,400</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Ownership Cost</span>
                        <strong id="ownershipCost">$22,600</strong>
                    </div>
                </div>

                <div class="value-comparison">
                    <div class="comparison-card">
                        <h4>Best Case Value</h4>
                        <div class="comparison-value" id="bestCase">$25,900</div>
                        <small>Excellent condition, low mileage</small>
                    </div>
                    <div class="comparison-card">
                        <h4>Worst Case Value</h4>
                        <div class="comparison-value" id="worstCase">$17,600</div>
                        <small>Poor condition, high mileage</small>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Depreciation Factors</h3>
                    <div class="breakdown-item">
                        <span>Vehicle Type Impact</span>
                        <strong id="typeImpact">-12%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Brand Reputation</span>
                        <strong id="brandImpact">+8%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mileage Impact</span>
                        <strong id="mileageImpact">-15%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Condition Impact</span>
                        <strong id="conditionImpact">+10%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Market Conditions</span>
                        <strong id="marketImpact">-5%</strong>
                    </div>
                </div>

                <div class="ownership-costs">
                    <h3>5-Year Ownership Cost Breakdown</h3>
                    <div class="cost-item">
                        <span>Depreciation</span>
                        <strong id="costDepreciation">$22,600</strong>
                    </div>
                    <div class="cost-item">
                        <span>Insurance (est.)</span>
                        <strong>$7,500</strong>
                    </div>
                    <div class="cost-item">
                        <span>Maintenance (est.)</span>
                        <strong>$4,200</strong>
                    </div>
                    <div class="cost-item">
                        <span>Fuel (est.)</span>
                        <strong>$9,000</strong>
                    </div>
                    <div class="cost-item" style="border-top: 2px solid #ff6b35; padding-top: 10px;">
                        <span style="font-weight: 600;">Total 5-Year Cost</span>
                        <strong style="color: #ff6b35; font-size: 1.1rem;" id="totalCost">$43,300</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Resale Value Health</h3>
                    <div class="breakdown-item" style="flex-direction: column; align-items: flex-start;">
                        <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 5px;">
                            <span>Value Retention Score</span>
                            <strong id="retentionScore">72%</strong>
                        </div>
                        <div class="progress-bar" style="width: 100%;">
                            <div class="progress-fill" id="retentionBar"></div>
                        </div>
                        <small style="margin-top: 5px;">Compared to average vehicles in same class</small>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Tip:</strong> Vehicles typically lose 20-30% of their value in the first year and about 15-18% each subsequent year. Luxury and electric vehicles often have different depreciation patterns. Regular maintenance and lower mileage can significantly improve resale value.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🚗 Car Depreciation Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced vehicle value analysis and ownership cost projections</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('depreciationForm');
        const conditionSlider = document.getElementById('vehicleCondition');
        const conditionValue = document.getElementById('conditionValue');

        // Vehicle type depreciation rates (annual %)
        const vehicleTypes = {
            'sedan': { rate: 16, name: 'Sedan' },
            'suv': { rate: 15, name: 'SUV' },
            'truck': { rate: 14, name: 'Truck' },
            'luxury': { rate: 18, name: 'Luxury Vehicle' },
            'sports': { rate: 20, name: 'Sports Car' },
            'electric': { rate: 22, name: 'Electric Vehicle' },
            'hybrid': { rate: 17, name: 'Hybrid Vehicle' }
        };

        // Brand value multipliers (affects resale value)
        const brandMultipliers = {
            'toyota': 1.15,
            'honda': 1.12,
            'ford': 1.05,
            'chevrolet': 1.03,
            'bmw': 0.95,
            'mercedes': 0.92,
            'audi': 0.94,
            'tesla': 1.25
        };

        // Condition multipliers
        const conditionLevels = {
            1: { label: 'Poor', multiplier: 0.7 },
            2: { label: 'Fair', multiplier: 0.8 },
            3: { label: 'Good', multiplier: 0.9 },
            4: { label: 'Very Good', multiplier: 1.0 },
            5: { label: 'Excellent', multiplier: 1.1 }
        };

        // Market trend multipliers
        const marketTrends = {
            'normal': 1.0,
            'strong': 1.15,
            'weak': 0.85,
            'covid': 1.25  // Post-COVID market with higher used car values
        };

        // Vehicle presets
        const vehiclePresets = {
            'economy': { price: 25000, type: 'sedan', brand: 'toyota', age: 2, mileage: 24000 },
            'midsize': { price: 35000, type: 'suv', brand: 'ford', age: 3, mileage: 36000 },
            'luxury': { price: 60000, type: 'luxury', brand: 'mercedes', age: 4, mileage: 40000 },
            'truck': { price: 45000, type: 'truck', brand: 'ford', age: 2, mileage: 30000 },
            'electric': { price: 50000, type: 'electric', brand: 'tesla', age: 2, mileage: 20000 },
            'sports': { price: 55000, type: 'sports', brand: 'bmw', age: 3, mileage: 15000 }
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateDepreciation();
        });

        conditionSlider.addEventListener('input', function() {
            const value = parseInt(this.value);
            conditionValue.textContent = conditionLevels[value].label;
            calculateDepreciation();
        });

        function setVehiclePreset(preset) {
            const config = vehiclePresets[preset];
            document.getElementById('vehiclePrice').value = config.price;
            document.getElementById('vehicleType').value = config.type;
            document.getElementById('vehicleBrand').value = config.brand;
            document.getElementById('vehicleAge').value = config.age;
            document.getElementById('mileage').value = config.mileage;
            
            // Visual feedback
            document.querySelectorAll('.car-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateDepreciation();
        }

        function calculateDepreciation() {
            // Get inputs
            const purchasePrice = parseFloat(document.getElementById('vehiclePrice').value);
            const vehicleAge = parseInt(document.getElementById('vehicleAge').value);
            const vehicleType = document.getElementById('vehicleType').value;
            const vehicleBrand = document.getElementById('vehicleBrand').value;
            const mileage = parseFloat(document.getElementById('mileage').value);
            const annualMileage = parseFloat(document.getElementById('annualMileage').value);
            const vehicleCondition = parseInt(document.getElementById('vehicleCondition').value);
            const ownershipPeriod = parseInt(document.getElementById('ownershipPeriod').value);
            const marketTrend = document.getElementById('marketTrends').value;

            // Get base depreciation rate
            const baseDepreciationRate = vehicleTypes[vehicleType].rate / 100;
            
            // Apply brand multiplier
            const brandMultiplier = brandMultipliers[vehicleBrand];
            
            // Apply condition multiplier
            const conditionMultiplier = conditionLevels[vehicleCondition].multiplier;
            
            // Apply market trend multiplier
            const marketMultiplier = marketTrends[marketTrend];
            
            // Calculate mileage impact (typical car loses $0.08 per mile after 100,000 miles)
            const mileageImpact = Math.max(0, (mileage - 100000) * 0.08);
            const mileageMultiplier = Math.max(0.5, 1 - (mileageImpact / purchasePrice));
            
            // Calculate current value using compound depreciation
            let currentValue = purchasePrice;
            for (let year = 1; year <= vehicleAge; year++) {
                // Higher depreciation in first year
                const yearRate = year === 1 ? baseDepreciationRate * 1.5 : baseDepreciationRate;
                currentValue *= (1 - yearRate);
            }
            
            // Apply multipliers
            currentValue *= brandMultiplier * conditionMultiplier * marketMultiplier * mileageMultiplier;
            
            // Calculate future value
            let futureValue = currentValue;
            const futureYears = ownershipPeriod;
            for (let year = 1; year <= futureYears; year++) {
                futureValue *= (1 - baseDepreciationRate);
            }
            
            // Calculate metrics
            const totalDepreciation = purchasePrice - currentValue;
            const depreciationRate = (totalDepreciation / purchasePrice) * 100;
            const annualLoss = totalDepreciation / Math.max(1, vehicleAge);
            
            // Calculate ownership costs
            const insuranceCost = purchasePrice * 0.04 * ownershipPeriod; // 4% of value per year
            const maintenanceCost = purchasePrice * 0.02 * ownershipPeriod; // 2% of value per year
            const fuelCost = (annualMileage * ownershipPeriod * 3.50) / 25; // $3.50/gal, 25 MPG
            const totalOwnershipCost = (purchasePrice - futureValue) + insuranceCost + maintenanceCost + fuelCost;
            
            // Calculate impact factors for display
            const typeImpact = ((brandMultipliers[vehicleBrand] - 1) * 100).toFixed(0);
            const brandImpact = ((brandMultiplier - 1) * 100).toFixed(0);
            const mileageImpactPercent = ((mileageMultiplier - 1) * 100).toFixed(0);
            const conditionImpactPercent = ((conditionMultiplier - 1) * 100).toFixed(0);
            const marketImpactPercent = ((marketMultiplier - 1) * 100).toFixed(0);
            
            // Calculate best/worst case scenarios
            const bestCaseValue = currentValue * 1.2; // 20% better than estimated
            const worstCaseValue = currentValue * 0.8; // 20% worse than estimated
            
            // Calculate retention score (0-100%)
            const retentionScore = Math.min(100, Math.max(0, (currentValue / purchasePrice) * 100 * 1.3));
            
            // Update UI
            document.getElementById('currentValue').textContent = '$' + formatNumber(currentValue);
            document.getElementById('totalDepreciation').textContent = '$' + formatNumber(totalDepreciation);
            document.getElementById('depreciationRate').textContent = depreciationRate.toFixed(0) + '%';
            document.getElementById('annualLoss').textContent = '$' + formatNumber(annualLoss);
            
            document.getElementById('originalPrice').textContent = '$' + formatNumber(purchasePrice);
            document.getElementById('displayCurrentValue').textContent = '$' + formatNumber(currentValue);
            document.getElementById('valueLost').textContent = '$' + formatNumber(totalDepreciation);
            document.getElementById('futureValue').textContent = '$' + formatNumber(futureValue);
            document.getElementById('ownershipCost').textContent = '$' + formatNumber(purchasePrice - futureValue);
            
            document.getElementById('bestCase').textContent = '$' + formatNumber(bestCaseValue);
            document.getElementById('worstCase').textContent = '$' + formatNumber(worstCaseValue);
            
            document.getElementById('typeImpact').textContent = typeImpact + '%';
            document.getElementById('brandImpact').textContent = (brandImpact > 0 ? '+' : '') + brandImpact + '%';
            document.getElementById('mileageImpact').textContent = mileageImpactPercent + '%';
            document.getElementById('conditionImpact').textContent = (conditionImpactPercent > 0 ? '+' : '') + conditionImpactPercent + '%';
            document.getElementById('marketImpact').textContent = marketImpactPercent + '%';
            
            document.getElementById('costDepreciation').textContent = '$' + formatNumber(purchasePrice - futureValue);
            document.getElementById('totalCost').textContent = '$' + formatNumber(totalOwnershipCost);
            
            // Update retention score
            updateRetentionScore(retentionScore);
            
            // Generate depreciation chart
            generateDepreciationChart(purchasePrice, vehicleAge, ownershipPeriod, baseDepreciationRate, 
                                    brandMultiplier, conditionMultiplier, marketMultiplier, mileageMultiplier);
        }

        function generateDepreciationChart(purchasePrice, currentAge, ownershipPeriod, baseRate, 
                                         brandMulti, conditionMulti, marketMulti, mileageMulti) {
            const chartContainer = document.getElementById('depreciationChart');
            chartContainer.innerHTML = '';
            
            const totalYears = currentAge + ownershipPeriod;
            const barWidth = (100 / (totalYears + 1)) - 2;
            
            // Calculate values for each year
            for (let year = 0; year <= totalYears; year++) {
                let value = purchasePrice;
                
                // Calculate depreciation for each year
                for (let y = 1; y <= year; y++) {
                    const yearRate = y === 1 ? baseRate * 1.5 : baseRate;
                    value *= (1 - yearRate);
                }
                
                // Apply multipliers (only after purchase)
                if (year > 0) {
                    value *= brandMulti * conditionMulti * marketMulti * mileageMulti;
                }
                
                // Calculate bar height (as percentage of original price)
                const barHeight = (value / purchasePrice) * 100;
                
                const bar = document.createElement('div');
                bar.className = 'chart-bar';
                bar.style.left = `${(year * (100 / (totalYears + 1)))}%`;
                bar.style.width = `${barWidth}%`;
                bar.style.height = '0%';
                
                const yearLabel = document.createElement('div');
                yearLabel.className = 'chart-year';
                yearLabel.textContent = `Year ${year}`;
                yearLabel.style.left = `${(year * (100 / (totalYears + 1)))}%`;
                yearLabel.style.width = `${barWidth}%`;
                
                const valueLabel = document.createElement('div');
                valueLabel.className = 'chart-label';
                valueLabel.textContent = `$${formatNumber(value)}`;
                valueLabel.style.left = `${(year * (100 / (totalYears + 1)))}%`;
                valueLabel.style.width = `${barWidth}%`;
                
                chartContainer.appendChild(bar);
                chartContainer.appendChild(yearLabel);
                chartContainer.appendChild(valueLabel);
                
                // Animate bar growth
                setTimeout(() => {
                    bar.style.height = `${barHeight}%`;
                }, year * 100);
            }
        }

        function updateRetentionScore(score) {
            const retentionBar = document.getElementById('retentionBar');
            const retentionText = document.getElementById('retentionScore');
            
            retentionBar.style.width = '0%';
            retentionText.textContent = '0%';
            
            setTimeout(() => {
                retentionBar.style.width = score + '%';
                retentionText.textContent = Math.round(score) + '%';
                
                // Change color based on score
                if (score >= 80) {
                    retentionBar.style.background = 'linear-gradient(90deg, #4CAF50 0%, #8BC34A 100%)';
                } else if (score >= 60) {
                    retentionBar.style.background = 'linear-gradient(90deg, #ff9800 0%, #ffc107 100%)';
                } else {
                    retentionBar.style.background = 'linear-gradient(90deg, #f44336 0%, #ff5722 100%)';
                }
            }, 100);
        }

        function formatNumber(num) {
            return Math.round(num).toLocaleString();
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateDepreciation();
        });
    </script>
</body>
</html>
