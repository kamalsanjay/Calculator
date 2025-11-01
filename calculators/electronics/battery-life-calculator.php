<?php
/**
 * Battery Life Calculator
 * File: electronics/battery-life-calculator.php
 * Description: Advanced calculator for estimating battery life across various devices
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Battery Life Calculator - Estimate Device Runtime</title>
    <meta name="description" content="Advanced battery life calculator. Calculate device runtime, power consumption, battery capacity conversions, and energy efficiency metrics.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #4facfe; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #4facfe; box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3); position: relative; overflow: hidden; }
        .result-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 0.8; } }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; position: relative; z-index: 1; }
        .result-card .amount { font-size: 3rem; font-weight: bold; position: relative; z-index: 1; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #4facfe; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #4facfe; font-size: 1.8rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #4facfe; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .progress-bar { background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%); width: 0%; transition: width 1s ease-out; }
        
        .info-box { background: #e8f2ff; border-left: 4px solid #4facfe; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #4facfe; }
        
        .device-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 8px; margin-top: 10px; }
        .device-btn { padding: 8px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .device-btn:hover { background: #4facfe; color: white; border-color: #4facfe; }
        .device-btn.active { background: #4facfe; color: white; border-color: #4facfe; }
        
        .usage-slider { display: flex; align-items: center; gap: 15px; margin-top: 10px; }
        .usage-slider input { flex: 1; }
        .usage-value { min-width: 50px; text-align: center; font-weight: 600; color: #4facfe; }
        
        .battery-visual { display: flex; flex-direction: column; align-items: center; margin: 20px 0; }
        .battery-outline { width: 120px; height: 60px; border: 3px solid #333; border-radius: 8px; position: relative; margin-bottom: 10px; }
        .battery-outline::after { content: ''; position: absolute; right: -10px; top: 20px; width: 8px; height: 20px; background: #333; border-radius: 0 4px 4px 0; }
        .battery-fill { height: 100%; background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%); border-radius: 5px; width: 0%; transition: width 1s ease-out; }
        .battery-level { font-size: 1.2rem; font-weight: bold; color: #4facfe; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .device-preset { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔋 Battery Life Calculator</h1>
            <p>Calculate device runtime, power consumption, and battery efficiency</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Battery & Device Parameters</h2>
                <form id="batteryForm">
                    <div class="form-group">
                        <label for="batteryCapacity">Battery Capacity</label>
                        <div class="input-group">
                            <input type="number" id="batteryCapacity" value="4000" min="1" step="1" required>
                            <select id="capacityUnit" style="padding: 12px;">
                                <option value="mAh" selected>mAh</option>
                                <option value="Ah">Ah</option>
                                <option value="Wh">Wh</option>
                            </select>
                        </div>
                        <small>Total energy storage capacity</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="deviceVoltage">Device Voltage</label>
                        <div class="input-group">
                            <input type="number" id="deviceVoltage" value="3.7" min="1" step="0.1" required>
                            <select id="voltageUnit" style="padding: 12px;">
                                <option value="V" selected>Volts (V)</option>
                            </select>
                        </div>
                        <small>Operating voltage of the device</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="powerConsumption">Power Consumption</label>
                        <div class="input-group">
                            <input type="number" id="powerConsumption" value="5" min="0.1" step="0.1" required>
                            <select id="powerUnit" style="padding: 12px;">
                                <option value="W" selected>Watts (W)</option>
                                <option value="mA">mA</option>
                            </select>
                        </div>
                        <small>Device power draw during use</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Device Presets</label>
                        <div class="device-preset">
                            <div class="device-btn" onclick="setDevicePreset('smartphone')">Smartphone</div>
                            <div class="device-btn" onclick="setDevicePreset('laptop')">Laptop</div>
                            <div class="device-btn" onclick="setDevicePreset('tablet')">Tablet</div>
                            <div class="device-btn" onclick="setDevicePreset('smartwatch')">Smartwatch</div>
                            <div class="device-btn" onclick="setDevicePreset('headphones')">Headphones</div>
                            <div class="device-btn" onclick="setDevicePreset('powerbank')">Power Bank</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="usagePattern">Usage Pattern</label>
                        <div class="usage-slider">
                            <span>Light</span>
                            <input type="range" id="usagePattern" min="1" max="5" value="3" step="1">
                            <span>Heavy</span>
                            <div class="usage-value" id="usageValue">Medium</div>
                        </div>
                        <small>Adjust for typical usage intensity</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="batteryHealth">Battery Health (%)</label>
                        <input type="number" id="batteryHealth" value="100" min="1" max="100" step="1">
                        <small>Account for battery degradation (new battery = 100%)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="standbyPower">Standby Power (mW)</label>
                        <input type="number" id="standbyPower" value="50" min="0" step="1">
                        <small>Power consumption when device is idle</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Battery Life</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Battery Analysis</h2>
                
                <div class="result-card">
                    <h3>Estimated Runtime</h3>
                    <div class="amount" id="runtime">8.0 hrs</div>
                </div>

                <div class="battery-visual">
                    <div class="battery-outline">
                        <div class="battery-fill" id="batteryFill"></div>
                    </div>
                    <div class="battery-level" id="batteryLevel">100%</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Hours</h4>
                        <div class="value" id="hours">8.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Minutes</h4>
                        <div class="value" id="minutes">480</div>
                    </div>
                    <div class="metric-card">
                        <h4>Days (standby)</h4>
                        <div class="value" id="days">33.3</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Battery Specifications</h3>
                    <div class="breakdown-item">
                        <span>Battery Capacity</span>
                        <strong id="capacityDisplay">4000 mAh</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Energy Capacity</span>
                        <strong id="energyDisplay">14.8 Wh</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Device Voltage</span>
                        <strong id="voltageDisplay">3.7 V</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Battery Health</span>
                        <strong id="healthDisplay">100%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Effective Capacity</span>
                        <strong id="effectiveCapacity">4000 mAh</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Power Consumption</h3>
                    <div class="breakdown-item">
                        <span>Active Power</span>
                        <strong id="activePower">5.0 W</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Standby Power</span>
                        <strong id="standbyDisplay">50 mW</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Usage Pattern</span>
                        <strong id="usageDisplay">Medium</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Current</span>
                        <strong id="currentDisplay">1351 mA</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Time Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Active Use Time</span>
                        <strong id="activeTime">2.96 hrs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Standby Time</span>
                        <strong id="standbyTime">12.3 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mixed Usage Time</span>
                        <strong id="mixedTime">8.0 hrs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Charging Time (10W)</span>
                        <strong id="chargeTime">1.48 hrs</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Energy Metrics</h3>
                    <div class="breakdown-item">
                        <span>Energy Consumption</span>
                        <strong id="energyConsumption">40.0 Wh</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Daily Energy Use</span>
                        <strong id="dailyEnergy">120 Wh</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Energy Cost</span>
                        <strong id="monthlyCost">$1.44</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Carbon Footprint</span>
                        <strong id="carbonFootprint">0.06 kg CO₂</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Battery Health</h3>
                    <div class="breakdown-item" style="flex-direction: column; align-items: flex-start;">
                        <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 5px;">
                            <span>Battery Wear Level</span>
                            <strong id="wearLevel">0%</strong>
                        </div>
                        <div class="progress-bar" style="width: 100%;">
                            <div class="progress-fill" id="wearBar"></div>
                        </div>
                        <small style="margin-top: 5px;">Estimated battery degradation over time</small>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> Actual battery life may vary due to temperature, age of battery, charging habits, and other environmental factors. These calculations provide estimates based on ideal conditions.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🔋 Battery Life Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced device runtime and power consumption calculations</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('batteryForm');
        const usageSlider = document.getElementById('usagePattern');
        const usageValue = document.getElementById('usageValue');
        let wearInterval;

        // Device presets (capacity in mAh, voltage in V, power in W)
        const devicePresets = {
            smartphone: { capacity: 4000, voltage: 3.7, power: 5, unit: 'W' },
            laptop: { capacity: 5000, voltage: 11.1, power: 45, unit: 'W' },
            tablet: { capacity: 7500, voltage: 3.7, power: 8, unit: 'W' },
            smartwatch: { capacity: 300, voltage: 3.7, power: 0.5, unit: 'W' },
            headphones: { capacity: 500, voltage: 3.7, power: 0.2, unit: 'W' },
            powerbank: { capacity: 10000, voltage: 3.7, power: 10, unit: 'W' }
        };

        // Usage pattern multipliers (affects power consumption)
        const usageMultipliers = {
            1: { label: 'Light', multiplier: 0.5 },
            2: { label: 'Light-Medium', multiplier: 0.75 },
            3: { label: 'Medium', multiplier: 1.0 },
            4: { label: 'Medium-Heavy', multiplier: 1.5 },
            5: { label: 'Heavy', multiplier: 2.0 }
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBatteryLife();
        });

        usageSlider.addEventListener('input', function() {
            const value = parseInt(this.value);
            usageValue.textContent = usageMultipliers[value].label;
            calculateBatteryLife();
        });

        function setDevicePreset(device) {
            const preset = devicePresets[device];
            document.getElementById('batteryCapacity').value = preset.capacity;
            document.getElementById('deviceVoltage').value = preset.voltage;
            document.getElementById('powerConsumption').value = preset.power;
            document.getElementById('powerUnit').value = preset.unit;
            
            // Visual feedback
            document.querySelectorAll('.device-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateBatteryLife();
        }

        function calculateBatteryLife() {
            // Get inputs
            const batteryCapacity = parseFloat(document.getElementById('batteryCapacity').value);
            const capacityUnit = document.getElementById('capacityUnit').value;
            const deviceVoltage = parseFloat(document.getElementById('deviceVoltage').value);
            const powerConsumption = parseFloat(document.getElementById('powerConsumption').value);
            const powerUnit = document.getElementById('powerUnit').value;
            const usagePattern = parseInt(document.getElementById('usagePattern').value);
            const batteryHealth = parseFloat(document.getElementById('batteryHealth').value) / 100;
            const standbyPower = parseFloat(document.getElementById('standbyPower').value) / 1000; // Convert to W
            
            // Convert capacity to mAh if needed
            let capacityMAh;
            if (capacityUnit === 'mAh') {
                capacityMAh = batteryCapacity;
            } else if (capacityUnit === 'Ah') {
                capacityMAh = batteryCapacity * 1000;
            } else if (capacityUnit === 'Wh') {
                // Convert Wh to mAh: mAh = (Wh * 1000) / V
                capacityMAh = (batteryCapacity * 1000) / deviceVoltage;
            }
            
            // Apply battery health
            const effectiveCapacityMAh = capacityMAh * batteryHealth;
            
            // Calculate energy capacity in Wh
            const energyCapacityWh = (effectiveCapacityMAh * deviceVoltage) / 1000;
            
            // Convert power consumption to Watts if needed
            let powerW;
            if (powerUnit === 'W') {
                powerW = powerConsumption;
            } else if (powerUnit === 'mA') {
                // Convert mA to W: W = (mA * V) / 1000
                powerW = (powerConsumption * deviceVoltage) / 1000;
            }
            
            // Apply usage pattern multiplier
            const usageMultiplier = usageMultipliers[usagePattern].multiplier;
            const adjustedPowerW = powerW * usageMultiplier;
            
            // Calculate runtime in hours
            const runtimeHours = energyCapacityWh / adjustedPowerW;
            
            // Calculate standby time
            const standbyHours = energyCapacityWh / (standbyPower / 1000); // Convert mW to W
            
            // Calculate mixed usage time (assuming 25% active, 75% standby)
            const mixedHours = energyCapacityWh / ((adjustedPowerW * 0.25) + (standbyPower * 0.75));
            
            // Calculate charging time (assuming 10W charger)
            const chargeTimeHours = energyCapacityWh / 10;
            
            // Calculate average current
            const averageCurrentMA = (adjustedPowerW * 1000) / deviceVoltage;
            
            // Calculate energy metrics
            const energyConsumptionWh = adjustedPowerW * runtimeHours;
            const dailyEnergyWh = adjustedPowerW * 8; // Assuming 8 hours of use per day
            const monthlyCost = (dailyEnergyWh * 30) / 1000 * 0.12; // Assuming $0.12 per kWh
            const carbonFootprint = (dailyEnergyWh * 30) / 1000 * 0.5; // Assuming 0.5 kg CO₂ per kWh
            
            // Time conversions
            const runtimeMinutes = runtimeHours * 60;
            const standbyDays = standbyHours / 24;
            
            // Display best time format
            let runtimeDisplay;
            if (runtimeHours < 1) {
                runtimeDisplay = runtimeMinutes.toFixed(0) + ' min';
            } else if (runtimeHours < 24) {
                runtimeDisplay = runtimeHours.toFixed(1) + ' hrs';
            } else {
                runtimeDisplay = (runtimeHours / 24).toFixed(1) + ' days';
            }
            
            // Update UI
            document.getElementById('runtime').textContent = runtimeDisplay;
            document.getElementById('hours').textContent = runtimeHours.toFixed(1);
            document.getElementById('minutes').textContent = runtimeMinutes.toFixed(0);
            document.getElementById('days').textContent = standbyDays.toFixed(1);
            
            document.getElementById('capacityDisplay').textContent = batteryCapacity + ' ' + capacityUnit;
            document.getElementById('energyDisplay').textContent = energyCapacityWh.toFixed(1) + ' Wh';
            document.getElementById('voltageDisplay').textContent = deviceVoltage + ' V';
            document.getElementById('healthDisplay').textContent = (batteryHealth * 100).toFixed(0) + '%';
            document.getElementById('effectiveCapacity').textContent = effectiveCapacityMAh.toFixed(0) + ' mAh';
            
            document.getElementById('activePower').textContent = powerW.toFixed(1) + ' W';
            document.getElementById('standbyDisplay').textContent = (standbyPower * 1000).toFixed(0) + ' mW';
            document.getElementById('usageDisplay').textContent = usageMultipliers[usagePattern].label;
            document.getElementById('currentDisplay').textContent = averageCurrentMA.toFixed(0) + ' mA';
            
            document.getElementById('activeTime').textContent = runtimeHours.toFixed(2) + ' hrs';
            document.getElementById('standbyTime').textContent = (standbyHours / 24).toFixed(1) + ' days';
            document.getElementById('mixedTime').textContent = mixedHours.toFixed(1) + ' hrs';
            document.getElementById('chargeTime').textContent = chargeTimeHours.toFixed(2) + ' hrs';
            
            document.getElementById('energyConsumption').textContent = energyConsumptionWh.toFixed(1) + ' Wh';
            document.getElementById('dailyEnergy').textContent = dailyEnergyWh.toFixed(0) + ' Wh';
            document.getElementById('monthlyCost').textContent = '$' + monthlyCost.toFixed(2);
            document.getElementById('carbonFootprint').textContent = carbonFootprint.toFixed(2) + ' kg CO₂';
            
            // Update battery visual
            updateBatteryVisual(batteryHealth);
            
            // Animate wear level
            animateWearLevel();
        }

        function updateBatteryVisual(health) {
            const batteryFill = document.getElementById('batteryFill');
            const batteryLevel = document.getElementById('batteryLevel');
            
            const fillPercentage = health * 100;
            batteryFill.style.width = fillPercentage + '%';
            batteryLevel.textContent = fillPercentage.toFixed(0) + '%';
            
            // Change color based on battery level
            if (fillPercentage > 70) {
                batteryFill.style.background = 'linear-gradient(90deg, #4facfe 0%, #00f2fe 100%)';
            } else if (fillPercentage > 30) {
                batteryFill.style.background = 'linear-gradient(90deg, #f6d365 0%, #fda085 100%)';
            } else {
                batteryFill.style.background = 'linear-gradient(90deg, #ff9a9e 0%, #fecfef 100%)';
            }
        }

        function animateWearLevel() {
            clearInterval(wearInterval);
            const wearBar = document.getElementById('wearBar');
            const wearText = document.getElementById('wearLevel');
            const batteryHealth = parseFloat(document.getElementById('batteryHealth').value);
            const wearLevel = 100 - batteryHealth;
            
            wearBar.style.width = '0%';
            wearText.textContent = '0%';
            
            let progress = 0;
            wearInterval = setInterval(() => {
                progress += 2;
                if (progress > wearLevel) {
                    progress = wearLevel;
                    clearInterval(wearInterval);
                }
                wearBar.style.width = progress + '%';
                wearText.textContent = progress.toFixed(0) + '%';
            }, 30);
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateBatteryLife();
        });

        // Stop animation on page unload
        window.addEventListener('beforeunload', function() {
            clearInterval(wearInterval);
        });
    </script>
</body>
</html>
