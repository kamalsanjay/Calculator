<?php
/**
 * Fuel Cost Calculator
 * File: automotive/fuel-cost-calculator.php
 * Description: Advanced calculator for fuel expenses, trip cost estimation, and consumption analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuel Cost Calculator - Trip Expenses & Consumption Analysis</title>
    <meta name="description" content="Advanced fuel cost calculator. Calculate trip expenses, fuel consumption, and optimize driving costs.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #00b4db; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #00b4db; box-shadow: 0 0 0 3px rgba(0, 180, 219, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0, 180, 219, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(0, 180, 219, 0.3); position: relative; overflow: hidden; }
        .result-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 0.8; } }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; position: relative; z-index: 1; }
        .result-card .amount { font-size: 3rem; font-weight: bold; position: relative; z-index: 1; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #00b4db; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #00b4db; font-size: 1.8rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #00b4db; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .progress-bar { background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #00b4db 0%, #0083b0 100%); width: 0%; transition: width 1s ease-out; }
        
        .info-box { background: #e0f7ff; border-left: 4px solid #00b4db; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #00b4db; }
        
        .vehicle-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 8px; margin-top: 10px; }
        .vehicle-btn { padding: 10px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .vehicle-btn:hover { background: #00b4db; color: white; border-color: #00b4db; }
        .vehicle-btn.active { background: #00b4db; color: white; border-color: #00b4db; }
        
        .fuel-price-slider { display: flex; align-items: center; gap: 15px; margin-top: 10px; }
        .fuel-price-slider input { flex: 1; }
        .fuel-price-value { min-width: 80px; text-align: center; font-weight: 600; color: #00b4db; }
        
        .fuel-visual { display: flex; flex-direction: column; align-items: center; margin: 20px 0; }
        .fuel-tank { width: 120px; height: 180px; border: 3px solid #333; border-radius: 8px; position: relative; background: #f8f9fa; overflow: hidden; margin-bottom: 15px; }
        .fuel-level { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, #00b4db, #0083b0); border-radius: 5px 5px 0 0; transition: height 1s ease-out; }
        .fuel-amount { font-size: 1.2rem; font-weight: bold; color: #00b4db; }
        
        .comparison-chart { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .chart-container { height: 200px; position: relative; margin: 20px 0; display: flex; align-items: end; gap: 10px; }
        .chart-bar { flex: 1; background: linear-gradient(to top, #00b4db, #0083b0); border-radius: 4px 4px 0 0; transition: height 1s ease-out; position: relative; }
        .chart-label { position: absolute; bottom: -25px; text-align: center; font-size: 0.8rem; color: #666; width: 100%; }
        .chart-value { position: absolute; top: -25px; text-align: center; font-size: 0.9rem; font-weight: 600; color: #333; width: 100%; }
        
        .trip-comparison { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
        .comparison-card { background: white; padding: 15px; border-radius: 8px; border: 2px solid #e0e0e0; text-align: center; }
        .comparison-card h4 { color: #666; margin-bottom: 10px; font-size: 0.9rem; }
        .comparison-value { font-size: 1.5rem; font-weight: bold; color: #00b4db; }
        
        .savings-calculator { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .savings-item { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0; }
        .savings-item:last-child { border-bottom: none; margin-bottom: 0; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
            .trip-comparison { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .vehicle-preset { grid-template-columns: repeat(2, 1fr); }
            .chart-container { height: 150px; }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
            .chart-container { height: 120px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⛽ Fuel Cost Calculator</h1>
            <p>Calculate trip expenses, fuel consumption, and optimize driving costs</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Trip & Vehicle Information</h2>
                <form id="fuelForm">
                    <div class="form-group">
                        <label for="tripDistance">Trip Distance</label>
                        <div class="input-group">
                            <input type="number" id="tripDistance" value="300" min="1" step="1" required>
                            <select id="distanceUnit" style="padding: 12px;">
                                <option value="miles" selected>Miles</option>
                                <option value="km">Kilometers</option>
                            </select>
                        </div>
                        <small>Total distance for your trip</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="fuelEfficiency">Fuel Efficiency</label>
                        <div class="input-group">
                            <input type="number" id="fuelEfficiency" value="25" min="1" step="0.1" required>
                            <select id="efficiencyUnit" style="padding: 12px;">
                                <option value="mpg" selected>MPG</option>
                                <option value="l_100km">L/100km</option>
                                <option value="km_l">km/L</option>
                            </select>
                        </div>
                        <small>Vehicle fuel consumption rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="fuelPrice">Fuel Price</label>
                        <div class="input-group">
                            <input type="number" id="fuelPrice" value="3.50" min="0.1" step="0.01" required>
                            <select id="priceUnit" style="padding: 12px;">
                                <option value="gallon" selected>per gallon</option>
                                <option value="liter">per liter</option>
                            </select>
                        </div>
                        <small>Current fuel price at pump</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Vehicle Presets</label>
                        <div class="vehicle-preset">
                            <div class="vehicle-btn" onclick="setVehiclePreset('economy')">Economy Car</div>
                            <div class="vehicle-btn" onclick="setVehiclePreset('sedan')">Midsize Sedan</div>
                            <div class="vehicle-btn" onclick="setVehiclePreset('suv')">SUV</div>
                            <div class="vehicle-btn" onclick="setVehiclePreset('truck')">Pickup Truck</div>
                            <div class="vehicle-btn" onclick="setVehiclePreset('hybrid')">Hybrid</div>
                            <div class="vehicle-btn" onclick="setVehiclePreset('electric')">Electric</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="fuelType">Fuel Type</label>
                        <select id="fuelType" style="padding: 12px;">
                            <option value="regular" selected>Regular Unleaded</option>
                            <option value="midgrade">Mid-Grade</option>
                            <option value="premium">Premium</option>
                            <option value="diesel">Diesel</option>
                            <option value="electric">Electric</option>
                        </select>
                        <small>Type of fuel your vehicle uses</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="passengers">Number of Passengers</label>
                        <input type="number" id="passengers" value="1" min="1" max="10" step="1">
                        <small>Including driver (affects efficiency)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="drivingStyle">Driving Style</label>
                        <select id="drivingStyle" style="padding: 12px;">
                            <option value="eco">Eco-Friendly</option>
                            <option value="normal" selected>Normal</option>
                            <option value="aggressive">Aggressive</option>
                            <option value="highway">Highway Cruising</option>
                            <option value="city">City Driving</option>
                        </select>
                        <small>Your typical driving behavior</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="terrainType">Terrain Type</label>
                        <select id="terrainType" style="padding: 12px;">
                            <option value="flat" selected>Flat Highway</option>
                            <option value="hilly">Hilly Terrain</option>
                            <option value="mountain">Mountainous</option>
                            <option value="city">Urban/City</option>
                            <option value="mixed">Mixed</option>
                        </select>
                        <small>Primary terrain for your trip</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="tripFrequency">Trip Frequency</label>
                        <select id="tripFrequency" style="padding: 12px;">
                            <option value="once">One-Time Trip</option>
                            <option value="daily" selected>Daily Commute</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                        <small>How often you make this trip</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Fuel Cost</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Fuel Cost Analysis</h2>
                
                <div class="result-card">
                    <h3>Total Trip Cost</h3>
                    <div class="amount" id="totalCost">$42.00</div>
                </div>

                <div class="fuel-visual">
                    <div class="fuel-tank">
                        <div class="fuel-level" id="fuelLevel"></div>
                    </div>
                    <div class="fuel-amount" id="fuelAmount">12.0 gallons</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Fuel Required</h4>
                        <div class="value" id="fuelRequired">12.0 gal</div>
                    </div>
                    <div class="metric-card">
                        <h4>Cost per Mile</h4>
                        <div class="value" id="costPerMile">$0.14</div>
                    </div>
                    <div class="metric-card">
                        <h4>Effective MPG</h4>
                        <div class="value" id="effectiveMPG">23.8 mpg</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Trip Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Distance Traveled</span>
                        <strong id="distanceTraveled">300 miles</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fuel Consumption</span>
                        <strong id="fuelConsumption">12.0 gallons</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fuel Price</span>
                        <strong id="displayFuelPrice">$3.50/gal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Base Fuel Cost</span>
                        <strong id="baseFuelCost">$42.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Efficiency Adjustment</span>
                        <strong id="efficiencyAdjustment">+$3.50</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #00b4db; padding-top: 10px;">
                        <span style="font-weight: 600;">Total Trip Cost</span>
                        <strong style="color: #00b4db; font-size: 1.1rem;" id="finalTripCost">$45.50</strong>
                    </div>
                </div>

                <div class="comparison-chart">
                    <h3>Vehicle Type Comparison</h3>
                    <div class="chart-container" id="vehicleComparisonChart">
                        <!-- Chart bars will be generated dynamically -->
                    </div>
                </div>

                <div class="trip-comparison">
                    <div class="comparison-card">
                        <h4>Daily Commute Cost</h4>
                        <div class="comparison-value" id="dailyCost">$9.10</div>
                        <small>Based on 60 miles round trip</small>
                    </div>
                    <div class="comparison-card">
                        <h4>Monthly Fuel Cost</h4>
                        <div class="comparison-value" id="monthlyCost">$200.20</div>
                        <small>22 working days per month</small>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Efficiency Factors</h3>
                    <div class="breakdown-item">
                        <span>Driving Style Impact</span>
                        <strong id="drivingImpact">-8%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Terrain Impact</span>
                        <strong id="terrainImpact">-5%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Passenger Load</span>
                        <strong id="passengerImpact">-3%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Vehicle Condition</span>
                        <strong id="conditionImpact">-2%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Efficiency Loss</span>
                        <strong id="totalEfficiencyLoss">-18%</strong>
                    </div>
                </div>

                <div class="savings-calculator">
                    <h3>Potential Savings</h3>
                    <div class="savings-item">
                        <span>10% Better Efficiency</span>
                        <strong id="savings10">$4.55</strong>
                    </div>
                    <div class="savings-item">
                        <span>20% Better Efficiency</span>
                        <strong id="savings20">$9.10</strong>
                    </div>
                    <div class="savings-item">
                        <span>$0.50/gal Price Drop</span>
                        <strong id="savingsPrice">$6.50</strong>
                    </div>
                    <div class="savings-item">
                        <span>Carpool (2 people)</span>
                        <strong id="savingsCarpool">$22.75</strong>
                    </div>
                    <div class="savings-item" style="border-top: 2px solid #00b4db; padding-top: 10px;">
                        <span style="font-weight: 600;">Annual Potential Savings</span>
                        <strong style="color: #00b4db; font-size: 1.1rem;" id="annualSavings">$546.00</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Environmental Impact</h3>
                    <div class="breakdown-item" style="flex-direction: column; align-items: flex-start;">
                        <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 5px;">
                            <span>Carbon Footprint</span>
                            <strong id="carbonFootprint">108 kg CO₂</strong>
                        </div>
                        <div class="progress-bar" style="width: 100%;">
                            <div class="progress-fill" id="carbonBar"></div>
                        </div>
                        <small style="margin-top: 5px;">Based on 8.89 kg CO₂ per gallon of gasoline</small>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Fuel Saving Tips:</strong> Maintain proper tire pressure, reduce idling time, use cruise control on highways, remove roof racks when not needed, and combine trips to improve fuel efficiency by 10-20%.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⛽ Fuel Cost Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced trip cost analysis and fuel efficiency optimization</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('fuelForm');
        let currentAnimation;

        // Vehicle presets with fuel efficiency data
        const vehiclePresets = {
            'economy': { efficiency: 35, type: 'regular', name: 'Economy Car' },
            'sedan': { efficiency: 25, type: 'regular', name: 'Midsize Sedan' },
            'suv': { efficiency: 20, type: 'regular', name: 'SUV' },
            'truck': { efficiency: 16, type: 'regular', name: 'Pickup Truck' },
            'hybrid': { efficiency: 50, type: 'regular', name: 'Hybrid Vehicle' },
            'electric': { efficiency: 110, type: 'electric', name: 'Electric Vehicle' } // MPGe
        };

        // Fuel type price multipliers
        const fuelTypes = {
            'regular': { multiplier: 1.0, name: 'Regular Unleaded' },
            'midgrade': { multiplier: 1.15, name: 'Mid-Grade' },
            'premium': { multiplier: 1.30, name: 'Premium' },
            'diesel': { multiplier: 1.10, name: 'Diesel' },
            'electric': { multiplier: 0.3, name: 'Electric' } // Relative cost per "gallon equivalent"
        };

        // Driving style efficiency multipliers
        const drivingStyles = {
            'eco': { multiplier: 1.15, name: 'Eco-Friendly' },
            'normal': { multiplier: 1.0, name: 'Normal' },
            'aggressive': { multiplier: 0.8, name: 'Aggressive' },
            'highway': { multiplier: 1.1, name: 'Highway Cruising' },
            'city': { multiplier: 0.9, name: 'City Driving' }
        };

        // Terrain type efficiency multipliers
        const terrainTypes = {
            'flat': { multiplier: 1.05, name: 'Flat Highway' },
            'hilly': { multiplier: 0.95, name: 'Hilly Terrain' },
            'mountain': { multiplier: 0.85, name: 'Mountainous' },
            'city': { multiplier: 0.9, name: 'Urban/City' },
            'mixed': { multiplier: 1.0, name: 'Mixed' }
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateFuelCost();
        });

        function setVehiclePreset(preset) {
            const config = vehiclePresets[preset];
            document.getElementById('fuelEfficiency').value = config.efficiency;
            document.getElementById('fuelType').value = config.type;
            
            // Visual feedback
            document.querySelectorAll('.vehicle-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateFuelCost();
        }

        function calculateFuelCost() {
            // Get inputs
            const tripDistance = parseFloat(document.getElementById('tripDistance').value);
            const distanceUnit = document.getElementById('distanceUnit').value;
            const fuelEfficiency = parseFloat(document.getElementById('fuelEfficiency').value);
            const efficiencyUnit = document.getElementById('efficiencyUnit').value;
            const fuelPrice = parseFloat(document.getElementById('fuelPrice').value);
            const priceUnit = document.getElementById('priceUnit').value;
            const fuelType = document.getElementById('fuelType').value;
            const passengers = parseInt(document.getElementById('passengers').value);
            const drivingStyle = document.getElementById('drivingStyle').value;
            const terrainType = document.getElementById('terrainType').value;
            const tripFrequency = document.getElementById('tripFrequency').value;

            // Convert to standard units (miles and gallons)
            let distanceMiles = tripDistance;
            if (distanceUnit === 'km') {
                distanceMiles = tripDistance * 0.621371;
            }

            let efficiencyMPG = fuelEfficiency;
            if (efficiencyUnit === 'l_100km') {
                efficiencyMPG = 235.214 / fuelEfficiency;
            } else if (efficiencyUnit === 'km_l') {
                efficiencyMPG = fuelEfficiency * 2.35214;
            }

            let pricePerGallon = fuelPrice;
            if (priceUnit === 'liter') {
                pricePerGallon = fuelPrice * 3.78541;
            }

            // Apply fuel type multiplier to price
            const fuelTypeMultiplier = fuelTypes[fuelType].multiplier;
            const adjustedPricePerGallon = pricePerGallon * fuelTypeMultiplier;

            // Apply efficiency modifiers
            const drivingMultiplier = drivingStyles[drivingStyle].multiplier;
            const terrainMultiplier = terrainTypes[terrainType].multiplier;
            const passengerMultiplier = Math.max(0.7, 1 - ((passengers - 1) * 0.03)); // 3% loss per additional passenger
            
            // Calculate effective efficiency
            const effectiveMPG = efficiencyMPG * drivingMultiplier * terrainMultiplier * passengerMultiplier;

            // Calculate fuel required
            const fuelRequiredGallons = distanceMiles / effectiveMPG;

            // Calculate costs
            const baseFuelCost = fuelRequiredGallons * adjustedPricePerGallon;
            const costPerMile = baseFuelCost / distanceMiles;

            // Calculate efficiency impacts for display
            const drivingImpact = ((drivingMultiplier - 1) * 100).toFixed(0);
            const terrainImpact = ((terrainMultiplier - 1) * 100).toFixed(0);
            const passengerImpact = ((passengerMultiplier - 1) * 100).toFixed(0);
            const totalEfficiencyLoss = ((1 - (drivingMultiplier * terrainMultiplier * passengerMultiplier)) * 100).toFixed(0);

            // Calculate recurring costs
            const dailyCommuteDistance = 60; // 30 miles each way
            const dailyFuelCost = (dailyCommuteDistance / effectiveMPG) * adjustedPricePerGallon;
            const monthlyFuelCost = dailyFuelCost * 22; // 22 working days

            // Calculate potential savings
            const savings10 = baseFuelCost * 0.1;
            const savings20 = baseFuelCost * 0.2;
            const savingsPrice = fuelRequiredGallons * 0.50;
            const savingsCarpool = baseFuelCost * 0.5; // Split cost with another person
            const annualSavings = savings20 * 52; // Weekly trips for a year

            // Calculate environmental impact (8.89 kg CO₂ per gallon of gasoline)
            const carbonFootprint = fuelType === 'electric' ? 0 : fuelRequiredGallons * 8.89;

            // Update UI
            document.getElementById('totalCost').textContent = '$' + baseFuelCost.toFixed(2);
            document.getElementById('fuelRequired').textContent = fuelRequiredGallons.toFixed(1) + ' gal';
            document.getElementById('costPerMile').textContent = '$' + costPerMile.toFixed(2);
            document.getElementById('effectiveMPG').textContent = effectiveMPG.toFixed(1) + ' mpg';

            document.getElementById('distanceTraveled').textContent = distanceMiles.toFixed(0) + ' miles';
            document.getElementById('fuelConsumption').textContent = fuelRequiredGallons.toFixed(1) + ' gallons';
            document.getElementById('displayFuelPrice').textContent = '$' + adjustedPricePerGallon.toFixed(2) + '/gal';
            document.getElementById('baseFuelCost').textContent = '$' + baseFuelCost.toFixed(2);
            document.getElementById('efficiencyAdjustment').textContent = '+$' + (baseFuelCost * 0.083).toFixed(2);
            document.getElementById('finalTripCost').textContent = '$' + (baseFuelCost * 1.083).toFixed(2);

            document.getElementById('dailyCost').textContent = '$' + dailyFuelCost.toFixed(2);
            document.getElementById('monthlyCost').textContent = '$' + monthlyFuelCost.toFixed(2);

            document.getElementById('drivingImpact').textContent = drivingImpact + '%';
            document.getElementById('terrainImpact').textContent = terrainImpact + '%';
            document.getElementById('passengerImpact').textContent = passengerImpact + '%';
            document.getElementById('conditionImpact').textContent = '-2%';
            document.getElementById('totalEfficiencyLoss').textContent = '-' + totalEfficiencyLoss + '%';

            document.getElementById('savings10').textContent = '$' + savings10.toFixed(2);
            document.getElementById('savings20').textContent = '$' + savings20.toFixed(2);
            document.getElementById('savingsPrice').textContent = '$' + savingsPrice.toFixed(2);
            document.getElementById('savingsCarpool').textContent = '$' + savingsCarpool.toFixed(2);
            document.getElementById('annualSavings').textContent = '$' + annualSavings.toFixed(2);

            document.getElementById('carbonFootprint').textContent = carbonFootprint.toFixed(0) + ' kg CO₂';

            // Update fuel tank visual
            updateFuelTank(fuelRequiredGallons);

            // Update carbon footprint bar
            updateCarbonFootprint(carbonFootprint);

            // Generate comparison chart
            generateComparisonChart(distanceMiles, adjustedPricePerGallon, effectiveMPG);
        }

        function updateFuelTank(fuelGallons) {
            const fuelLevel = document.getElementById('fuelLevel');
            const fuelAmount = document.getElementById('fuelAmount');
            
            // Calculate percentage for visual (max 20 gallons for visualization)
            const tankPercentage = Math.min(100, (fuelGallons / 20) * 100);
            
            fuelLevel.style.height = '0%';
            fuelAmount.textContent = '0.0 gallons';
            
            // Animate fuel level
            clearTimeout(currentAnimation);
            let currentHeight = 0;
            const targetHeight = tankPercentage;
            const animationSpeed = 20;
            
            currentAnimation = setInterval(() => {
                currentHeight += 1;
                if (currentHeight >= targetHeight) {
                    currentHeight = targetHeight;
                    clearInterval(currentAnimation);
                }
                fuelLevel.style.height = currentHeight + '%';
                fuelAmount.textContent = (fuelGallons * (currentHeight / targetHeight)).toFixed(1) + ' gallons';
            }, animationSpeed);
        }

        function updateCarbonFootprint(carbonAmount) {
            const carbonBar = document.getElementById('carbonBar');
            const maxCarbon = 200; // kg CO₂ for visualization
            
            const carbonPercentage = Math.min(100, (carbonAmount / maxCarbon) * 100);
            
            carbonBar.style.width = '0%';
            
            setTimeout(() => {
                carbonBar.style.width = carbonPercentage + '%';
                
                // Change color based on environmental impact
                if (carbonAmount <= 50) {
                    carbonBar.style.background = 'linear-gradient(90deg, #4CAF50 0%, #8BC34A 100%)';
                } else if (carbonAmount <= 100) {
                    carbonBar.style.background = 'linear-gradient(90deg, #ff9800 0%, #ffc107 100%)';
                } else {
                    carbonBar.style.background = 'linear-gradient(90deg, #f44336 0%, #ff5722 100%)';
                }
            }, 100);
        }

        function generateComparisonChart(distanceMiles, pricePerGallon, currentMPG) {
            const chartContainer = document.getElementById('vehicleComparisonChart');
            chartContainer.innerHTML = '';
            
            const vehicleTypes = ['Economy', 'Sedan', 'SUV', 'Truck', 'Hybrid', 'Electric'];
            const efficiencies = [35, 25, 20, 16, 50, 110]; // MPG or MPGe
            
            // Calculate costs for each vehicle type
            vehicleTypes.forEach((vehicle, index) => {
                const efficiency = efficiencies[index];
                const fuelCost = (distanceMiles / efficiency) * pricePerGallon;
                const maxCost = (distanceMiles / 16) * pricePerGallon; // Truck as baseline
                const barHeight = (fuelCost / maxCost) * 100;
                
                const bar = document.createElement('div');
                bar.className = 'chart-bar';
                bar.style.height = '0%';
                
                const valueLabel = document.createElement('div');
                valueLabel.className = 'chart-value';
                valueLabel.textContent = '$' + fuelCost.toFixed(0);
                
                const typeLabel = document.createElement('div');
                typeLabel.className = 'chart-label';
                typeLabel.textContent = vehicle;
                
                chartContainer.appendChild(bar);
                chartContainer.appendChild(valueLabel);
                chartContainer.appendChild(typeLabel);
                
                // Animate bar growth
                setTimeout(() => {
                    bar.style.height = barHeight + '%';
                }, index * 150);
            });
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateFuelCost();
        });
    </script>
</body>
</html>
