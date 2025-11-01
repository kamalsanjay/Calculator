<?php
/**
 * Power Supply Calculator
 * File: electronics/power-supply-calculator.php
 * Description: Advanced calculator for power supply requirements, efficiency, and energy consumption
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Supply Calculator - PSU Requirements & Efficiency</title>
    <meta name="description" content="Advanced power supply calculator. Calculate PSU requirements, efficiency, energy costs, and system power consumption.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #ff6b6b; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #ff6b6b; box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3); position: relative; overflow: hidden; }
        .result-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 0.8; } }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; position: relative; z-index: 1; }
        .result-card .amount { font-size: 3rem; font-weight: bold; position: relative; z-index: 1; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #ff6b6b; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #ff6b6b; font-size: 1.8rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #ff6b6b; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .progress-bar { background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #ff6b6b 0%, #ffa500 100%); width: 0%; transition: width 1s ease-out; }
        
        .info-box { background: #ffe8e8; border-left: 4px solid #ff6b6b; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #ff6b6b; }
        
        .component-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 8px; margin-top: 10px; }
        .component-btn { padding: 8px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .component-btn:hover { background: #ff6b6b; color: white; border-color: #ff6b6b; }
        .component-btn.active { background: #ff6b6b; color: white; border-color: #ff6b6b; }
        
        .component-list { max-height: 300px; overflow-y: auto; border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
        .component-item { display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #e0e0e0; }
        .component-item:last-child { border-bottom: none; }
        .component-info { flex: 1; }
        .component-name { font-weight: 600; color: #333; }
        .component-wattage { color: #ff6b6b; font-weight: 600; }
        .component-remove { background: #ff6b6b; color: white; border: none; border-radius: 4px; padding: 5px 10px; cursor: pointer; font-size: 0.8rem; }
        
        .efficiency-slider { display: flex; align-items: center; gap: 15px; margin-top: 10px; }
        .efficiency-slider input { flex: 1; }
        .efficiency-value { min-width: 50px; text-align: center; font-weight: 600; color: #ff6b6b; }
        
        .psu-visual { display: flex; flex-direction: column; align-items: center; margin: 20px 0; }
        .psu-outline { width: 200px; height: 100px; border: 3px solid #333; border-radius: 8px; position: relative; margin-bottom: 10px; background: #f8f9fa; }
        .psu-fan { position: absolute; top: 20px; left: 20px; width: 60px; height: 60px; border: 2px solid #333; border-radius: 50%; background: #e0e0e0; }
        .psu-fan::before { content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 20px; height: 20px; background: #333; border-radius: 50%; }
        .psu-connectors { position: absolute; top: 30px; right: 20px; display: flex; flex-direction: column; gap: 5px; }
        .psu-connector { width: 40px; height: 8px; background: #333; border-radius: 2px; }
        .psu-load { position: absolute; bottom: 10px; left: 10px; right: 10px; height: 20px; background: #e0e0e0; border-radius: 4px; overflow: hidden; }
        .psu-load-fill { height: 100%; background: linear-gradient(90deg, #ff6b6b 0%, #ffa500 100%); width: 0%; transition: width 1s ease-out; }
        .psu-level { font-size: 1.2rem; font-weight: bold; color: #ff6b6b; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .component-preset { grid-template-columns: repeat(2, 1fr); }
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
            <h1>⚡ Power Supply Calculator</h1>
            <p>Calculate PSU requirements, efficiency, and energy consumption</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>System Components</h2>
                
                <div class="form-group">
                    <label>Quick Component Presets</label>
                    <div class="component-preset">
                        <div class="component-btn" onclick="addComponent('CPU - High End', 150)">High-End CPU</div>
                        <div class="component-btn" onclick="addComponent('GPU - Gaming', 250)">Gaming GPU</div>
                        <div class="component-btn" onclick="addComponent('Motherboard', 80)">Motherboard</div>
                        <div class="component-btn" onclick="addComponent('RAM (32GB)', 20)">RAM</div>
                        <div class="component-btn" onclick="addComponent('SSD (1TB)', 5)">SSD</div>
                        <div class="component-btn" onclick="addComponent('HDD (4TB)', 15)">HDD</div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="customComponent">Add Custom Component</label>
                    <div class="input-group">
                        <input type="text" id="customComponent" placeholder="Component name">
                        <input type="number" id="customWattage" placeholder="Wattage" min="1" step="1">
                    </div>
                    <button type="button" class="btn" onclick="addCustomComponent()" style="margin-top: 10px; padding: 10px;">Add Component</button>
                </div>
                
                <div class="component-list" id="componentList">
                    <div class="component-item">
                        <div class="component-info">
                            <div class="component-name">CPU - Standard</div>
                            <div class="component-wattage">65 W</div>
                        </div>
                        <button class="component-remove" onclick="removeComponent(this)">Remove</button>
                    </div>
                    <div class="component-item">
                        <div class="component-info">
                            <div class="component-name">GPU - Standard</div>
                            <div class="component-wattage">150 W</div>
                        </div>
                        <button class="component-remove" onclick="removeComponent(this)">Remove</button>
                    </div>
                </div>

                <h2>Power Supply Settings</h2>
                <form id="psuForm">
                    <div class="form-group">
                        <label for="psuEfficiency">PSU Efficiency Rating</label>
                        <div class="efficiency-slider">
                            <span>80+ Bronze</span>
                            <input type="range" id="psuEfficiency" min="1" max="5" value="3" step="1">
                            <span>80+ Titanium</span>
                            <div class="efficiency-value" id="efficiencyValue">80+ Gold</div>
                        </div>
                        <small>Higher efficiency means less energy waste as heat</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="loadFactor">Load Factor (%)</label>
                        <input type="number" id="loadFactor" value="80" min="50" max="100" step="1">
                        <small>Recommended to run at 80% of PSU capacity for optimal efficiency</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="dailyUsage">Daily Usage (hours)</label>
                        <input type="number" id="dailyUsage" value="8" min="1" max="24" step="0.5">
                        <small>Average hours of use per day</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="electricityCost">Electricity Cost ($/kWh)</label>
                        <input type="number" id="electricityCost" value="0.12" min="0.01" step="0.01">
                        <small>Your local electricity rate per kilowatt-hour</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="overclocking">Overclocking Headroom (%)</label>
                        <input type="number" id="overclocking" value="20" min="0" max="100" step="5">
                        <small>Additional capacity for overclocking and future upgrades</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate PSU Requirements</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Power Analysis</h2>
                
                <div class="result-card">
                    <h3>Recommended PSU Wattage</h3>
                    <div class="amount" id="recommendedPSU">650 W</div>
                </div>

                <div class="psu-visual">
                    <div class="psu-outline">
                        <div class="psu-fan"></div>
                        <div class="psu-connectors">
                            <div class="psu-connector"></div>
                            <div class="psu-connector"></div>
                            <div class="psu-connector"></div>
                        </div>
                        <div class="psu-load">
                            <div class="psu-load-fill" id="psuLoadFill"></div>
                        </div>
                    </div>
                    <div class="psu-level" id="psuLevel">65% Load</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total System Power</h4>
                        <div class="value" id="totalPower">215 W</div>
                    </div>
                    <div class="metric-card">
                        <h4>PSU Efficiency</h4>
                        <div class="value" id="efficiency">90%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Wall Power Draw</h4>
                        <div class="value" id="wallPower">239 W</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Power Consumption Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Total Components Power</span>
                        <strong id="componentsPower">215 W</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Overclocking Headroom</span>
                        <strong id="ocHeadroom">43 W</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Recommended PSU Capacity</span>
                        <strong id="psuCapacity">650 W</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Optimal Load (80%)</span>
                        <strong id="optimalLoad">520 W</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Load Percentage</span>
                        <strong id="loadPercentage">41%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Energy Efficiency</h3>
                    <div class="breakdown-item">
                        <span>PSU Efficiency Rating</span>
                        <strong id="efficiencyRating">80+ Gold</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Efficiency at Current Load</span>
                        <strong id="currentEfficiency">90%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Power Loss as Heat</span>
                        <strong id="powerLoss">24 W</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Energy Savings vs 80+ Bronze</span>
                        <strong id="energySavings">15%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Analysis</h3>
                    <div class="breakdown-item">
                        <span>Daily Energy Consumption</span>
                        <strong id="dailyConsumption">1.91 kWh</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Energy Cost</span>
                        <strong id="monthlyCost">$6.88</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Yearly Energy Cost</span>
                        <strong id="yearlyCost">$82.56</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>5-Year Energy Cost</span>
                        <strong id="fiveYearCost">$412.80</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Environmental Impact</h3>
                    <div class="breakdown-item">
                        <span>Daily Carbon Footprint</span>
                        <strong id="dailyCarbon">0.96 kg CO₂</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Carbon Footprint</span>
                        <strong id="monthlyCarbon">28.8 kg CO₂</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Equivalent Trees Needed</span>
                        <strong id="treesNeeded">1.4 trees</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>PSU Load Distribution</h3>
                    <div class="breakdown-item" style="flex-direction: column; align-items: flex-start;">
                        <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 5px;">
                            <span>Current Load Level</span>
                            <strong id="loadLevel">41%</strong>
                        </div>
                        <div class="progress-bar" style="width: 100%;">
                            <div class="progress-fill" id="loadBar"></div>
                        </div>
                        <small style="margin-top: 5px;">Optimal efficiency range: 40-80% load</small>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Recommendation:</strong> For optimal efficiency and longevity, choose a PSU that operates at 40-80% of its capacity during normal use. Higher efficiency PSUs (80+ Gold or better) save energy and reduce heat output.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⚡ Power Supply Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced PSU requirements and efficiency calculations</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('psuForm');
        const efficiencySlider = document.getElementById('psuEfficiency');
        const efficiencyValue = document.getElementById('efficiencyValue');
        let loadInterval;

        // PSU efficiency ratings with typical efficiency curves
        const efficiencyRatings = {
            1: { label: '80+ Bronze', efficiency: [82, 85, 82] }, // 20%, 50%, 100% load
            2: { label: '80+ Silver', efficiency: [85, 88, 85] },
            3: { label: '80+ Gold', efficiency: [87, 90, 87] },
            4: { label: '80+ Platinum', efficiency: [90, 92, 89] },
            5: { label: '80+ Titanium', efficiency: [92, 94, 90] }
        };

        // Component database
        let components = [
            { name: 'CPU - Standard', wattage: 65 },
            { name: 'GPU - Standard', wattage: 150 }
        ];

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculatePSURequirements();
        });

        efficiencySlider.addEventListener('input', function() {
            const value = parseInt(this.value);
            efficiencyValue.textContent = efficiencyRatings[value].label;
            calculatePSURequirements();
        });

        function addComponent(name, wattage) {
            components.push({ name, wattage });
            updateComponentList();
            calculatePSURequirements();
        }

        function addCustomComponent() {
            const name = document.getElementById('customComponent').value;
            const wattage = parseInt(document.getElementById('customWattage').value);
            
            if (name && wattage) {
                components.push({ name, wattage });
                updateComponentList();
                calculatePSURequirements();
                
                // Clear inputs
                document.getElementById('customComponent').value = '';
                document.getElementById('customWattage').value = '';
            }
        }

        function removeComponent(button) {
            const componentItem = button.parentElement;
            const componentName = componentItem.querySelector('.component-name').textContent;
            
            components = components.filter(comp => comp.name !== componentName);
            updateComponentList();
            calculatePSURequirements();
        }

        function updateComponentList() {
            const componentList = document.getElementById('componentList');
            componentList.innerHTML = '';
            
            components.forEach(component => {
                const componentItem = document.createElement('div');
                componentItem.className = 'component-item';
                componentItem.innerHTML = `
                    <div class="component-info">
                        <div class="component-name">${component.name}</div>
                        <div class="component-wattage">${component.wattage} W</div>
                    </div>
                    <button class="component-remove" onclick="removeComponent(this)">Remove</button>
                `;
                componentList.appendChild(componentItem);
            });
        }

        function calculatePSURequirements() {
            // Get inputs
            const efficiencyLevel = parseInt(document.getElementById('psuEfficiency').value);
            const loadFactor = parseFloat(document.getElementById('loadFactor').value) / 100;
            const dailyUsage = parseFloat(document.getElementById('dailyUsage').value);
            const electricityCost = parseFloat(document.getElementById('electricityCost').value);
            const overclocking = parseFloat(document.getElementById('overclocking').value) / 100;
            
            // Calculate total system power
            const totalComponentsPower = components.reduce((sum, comp) => sum + comp.wattage, 0);
            const overclockingHeadroom = totalComponentsPower * overclocking;
            const totalSystemPower = totalComponentsPower + overclockingHeadroom;
            
            // Calculate recommended PSU wattage
            const recommendedPSU = Math.ceil(totalSystemPower / loadFactor / 50) * 50; // Round to nearest 50W
            
            // Calculate current load percentage
            const loadPercentage = (totalSystemPower / recommendedPSU) * 100;
            
            // Get efficiency based on load percentage
            const efficiencyRating = efficiencyRatings[efficiencyLevel];
            let efficiency;
            if (loadPercentage <= 20) {
                efficiency = efficiencyRating.efficiency[0] / 100;
            } else if (loadPercentage <= 50) {
                efficiency = efficiencyRating.efficiency[1] / 100;
            } else {
                efficiency = efficiencyRating.efficiency[2] / 100;
            }
            
            // Calculate wall power draw
            const wallPower = totalSystemPower / efficiency;
            const powerLoss = wallPower - totalSystemPower;
            
            // Calculate energy consumption and costs
            const dailyConsumption = (wallPower * dailyUsage) / 1000; // kWh
            const monthlyCost = dailyConsumption * 30 * electricityCost;
            const yearlyCost = monthlyCost * 12;
            const fiveYearCost = yearlyCost * 5;
            
            // Calculate environmental impact (0.5 kg CO₂ per kWh)
            const dailyCarbon = dailyConsumption * 0.5;
            const monthlyCarbon = dailyCarbon * 30;
            const treesNeeded = (yearlyCost * 1000 / 60).toFixed(1); // Rough estimate
            
            // Calculate energy savings vs 80+ Bronze
            const bronzeEfficiency = efficiencyRatings[1].efficiency[1] / 100;
            const bronzeWallPower = totalSystemPower / bronzeEfficiency;
            const energySavings = ((bronzeWallPower - wallPower) / bronzeWallPower * 100).toFixed(0);
            
            // Update UI
            document.getElementById('recommendedPSU').textContent = recommendedPSU + ' W';
            document.getElementById('totalPower').textContent = totalSystemPower.toFixed(0) + ' W';
            document.getElementById('efficiency').textContent = (efficiency * 100).toFixed(0) + '%';
            document.getElementById('wallPower').textContent = wallPower.toFixed(0) + ' W';
            
            document.getElementById('componentsPower').textContent = totalComponentsPower + ' W';
            document.getElementById('ocHeadroom').textContent = overclockingHeadroom.toFixed(0) + ' W';
            document.getElementById('psuCapacity').textContent = recommendedPSU + ' W';
            document.getElementById('optimalLoad').textContent = (recommendedPSU * 0.8).toFixed(0) + ' W';
            document.getElementById('loadPercentage').textContent = loadPercentage.toFixed(0) + '%';
            
            document.getElementById('efficiencyRating').textContent = efficiencyRating.label;
            document.getElementById('currentEfficiency').textContent = (efficiency * 100).toFixed(0) + '%';
            document.getElementById('powerLoss').textContent = powerLoss.toFixed(0) + ' W';
            document.getElementById('energySavings').textContent = energySavings + '%';
            
            document.getElementById('dailyConsumption').textContent = dailyConsumption.toFixed(2) + ' kWh';
            document.getElementById('monthlyCost').textContent = '$' + monthlyCost.toFixed(2);
            document.getElementById('yearlyCost').textContent = '$' + yearlyCost.toFixed(2);
            document.getElementById('fiveYearCost').textContent = '$' + fiveYearCost.toFixed(2);
            
            document.getElementById('dailyCarbon').textContent = dailyCarbon.toFixed(2) + ' kg CO₂';
            document.getElementById('monthlyCarbon').textContent = monthlyCarbon.toFixed(1) + ' kg CO₂';
            document.getElementById('treesNeeded').textContent = treesNeeded + ' trees';
            
            // Update PSU visual
            updatePSUVisual(loadPercentage);
            
            // Animate load level
            animateLoadLevel(loadPercentage);
        }

        function updatePSUVisual(loadPercentage) {
            const psuLoadFill = document.getElementById('psuLoadFill');
            const psuLevel = document.getElementById('psuLevel');
            
            psuLoadFill.style.width = Math.min(loadPercentage, 100) + '%';
            psuLevel.textContent = loadPercentage.toFixed(0) + '% Load';
            
            // Change color based on load level
            if (loadPercentage <= 40) {
                psuLoadFill.style.background = 'linear-gradient(90deg, #4CAF50 0%, #8BC34A 100%)';
            } else if (loadPercentage <= 80) {
                psuLoadFill.style.background = 'linear-gradient(90deg, #ff6b6b 0%, #ffa500 100%)';
            } else {
                psuLoadFill.style.background = 'linear-gradient(90deg, #f44336 0%, #ff9800 100%)';
            }
        }

        function animateLoadLevel(targetPercentage) {
            clearInterval(loadInterval);
            const loadBar = document.getElementById('loadBar');
            const loadText = document.getElementById('loadLevel');
            
            loadBar.style.width = '0%';
            loadText.textContent = '0%';
            
            let progress = 0;
            loadInterval = setInterval(() => {
                progress += 2;
                if (progress > targetPercentage) {
                    progress = targetPercentage;
                    clearInterval(loadInterval);
                }
                loadBar.style.width = progress + '%';
                loadText.textContent = progress.toFixed(0) + '%';
            }, 30);
        }

        // Initialize
        window.addEventListener('load', function() {
            updateComponentList();
            calculatePSURequirements();
        });

        // Stop animation on page unload
        window.addEventListener('beforeunload', function() {
            clearInterval(loadInterval);
        });
    </script>
</body>
</html>
