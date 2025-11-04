<?php
/**
 * Solar Panel Calculator
 * File: weather/solar-panel-calculator.php
 * Description: Calculate solar panel requirements, energy production, and ROI for residential and commercial installations
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solar Panel Calculator - Energy Production & ROI Analysis</title>
    <meta name="description" content="Calculate solar panel requirements, energy production, cost savings, and return on investment for your location.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: clamp(20px, 5vw, 30px); border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: clamp(1.5rem, 4vw, 2rem); margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: clamp(0.9rem, 2.5vw, 1.05rem); line-height: 1.6; }
        
        .calculator-card { background: white; padding: clamp(20px, 5vw, 35px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-sections { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: clamp(15px, 4vw, 25px); margin-bottom: 25px; }
        
        .input-group { background: #f8f9fa; padding: clamp(15px, 4vw, 25px); border-radius: 12px; }
        .input-group h3 { color: #2c3e50; margin-bottom: 15px; font-size: clamp(1rem, 3vw, 1.2rem); display: flex; align-items: center; gap: 8px; }
        
        .input-row { display: flex; gap: 15px; align-items: end; margin-bottom: 15px; }
        .input-wrapper { flex: 1; }
        .input-wrapper label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.9rem; }
        .input-field { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-field:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; }
        .unit-select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .slider-container { margin-bottom: 20px; }
        .slider-label { display: flex; justify-content: between; margin-bottom: 8px; }
        .slider-label span { color: #34495e; font-weight: 600; }
        .slider-value { color: #667eea; font-weight: bold; }
        .custom-slider { width: 100%; height: 8px; border-radius: 5px; background: #e0e0e0; outline: none; margin: 10px 0; }
        
        .calculate-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 16px 30px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin: 20px 0; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        
        .results-section { margin-top: 30px; }
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        
        .result-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; text-align: center; }
        .result-label { color: #4527a0; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-value { font-size: 1.4rem; font-weight: bold; color: #5e35b1; }
        .result-unit { color: #7e57c2; font-size: 0.9rem; margin-top: 5px; }
        
        .financial-breakdown { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .financial-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .financial-header h3 { color: #2c3e50; font-size: 1.1rem; }
        
        .financial-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; }
        .financial-item { display: flex; justify-content: between; align-items: center; padding: 15px; background: white; border-radius: 8px; }
        .financial-label { color: #2c3e50; font-weight: 600; }
        .financial-value { color: #667eea; font-weight: bold; font-size: 1.1rem; }
        
        .roi-timeline { margin-top: 25px; }
        .timeline-bar { height: 20px; background: #e0e0e0; border-radius: 10px; overflow: hidden; margin: 15px 0; position: relative; }
        .timeline-fill { height: 100%; background: linear-gradient(90deg, #27ae60, #2ecc71); transition: all 0.3s; }
        .timeline-marker { position: absolute; top: -25px; transform: translateX(-50%); font-size: 0.8rem; color: #7f8c8d; }
        
        .system-design { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .design-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .design-item { text-align: center; padding: 15px; background: white; border-radius: 8px; }
        .design-icon { font-size: 2rem; margin-bottom: 10px; }
        .design-value { font-size: 1.2rem; font-weight: bold; color: #667eea; }
        .design-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 5px; }
        
        .quick-scenarios { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-scenarios h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .scenarios-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; }
        .scenario-btn { padding: 15px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .scenario-btn:hover { border-color: #667eea; transform: translateY(-2px); }
        .scenario-value { font-weight: bold; color: #667eea; font-size: 1rem; }
        .scenario-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: clamp(1.2rem, 4vw, 1.4rem); }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: clamp(1rem, 3vw, 1.1rem); }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        
        .solar-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin: 20px 0; }
        .solar-card { background: #ede7f6; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; }
        .solar-card h4 { color: #4527a0; margin-bottom: 10px; }
        
        .comparison-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: clamp(0.8rem, 2vw, 0.9rem); }
        .comparison-table th, .comparison-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .comparison-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .comparison-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-row { flex-direction: column; }
            .results-grid { grid-template-columns: repeat(2, 1fr); }
            .financial-grid { grid-template-columns: 1fr; }
            .design-grid { grid-template-columns: repeat(2, 1fr); }
            .scenarios-grid { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (max-width: 480px) {
            .results-grid { grid-template-columns: 1fr; }
            .design-grid { grid-template-columns: 1fr; }
            .scenarios-grid { grid-template-columns: 1fr; }
            .input-sections { grid-template-columns: 1fr; }
            .calculator-card { padding: 15px; }
            .header { padding: 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>☀️ Solar Panel Calculator</h1>
            <p>Calculate solar panel requirements, energy production, cost savings, and return on investment for your location</p>
        </div>

        <div class="calculator-card">
            <div class="input-sections">
                <div class="input-group">
                    <h3>📍 Location & Energy</h3>
                    <div class="input-wrapper">
                        <label for="location">Your Location</label>
                        <select id="location" class="unit-select">
                            <option value="4.5">Sunny Region (5+ kWh/m²/day)</option>
                            <option value="4.0" selected>Moderate Sun (4 kWh/m²/day)</option>
                            <option value="3.5">Partly Cloudy (3.5 kWh/m²/day)</option>
                            <option value="3.0">Cloudy Region (3 kWh/m²/day)</option>
                            <option value="2.5">Northern Climate (2.5 kWh/m²/day)</option>
                        </select>
                    </div>
                    
                    <div class="input-wrapper">
                        <label for="energyUsage">Monthly Energy Usage (kWh)</label>
                        <input type="number" id="energyUsage" class="input-field" placeholder="Enter monthly usage" value="900" min="100" step="50">
                    </div>
                    
                    <div class="input-wrapper">
                        <label for="electricityRate">Electricity Rate ($/kWh)</label>
                        <input type="number" id="electricityRate" class="input-field" placeholder="0.15" value="0.15" min="0.05" step="0.01">
                    </div>
                </div>

                <div class="input-group">
                    <h3>🔧 System Configuration</h3>
                    <div class="slider-container">
                        <div class="slider-label">
                            <span>System Coverage:</span>
                            <span class="slider-value" id="coverageValue">100%</span>
                        </div>
                        <input type="range" id="coverageSlider" class="custom-slider" min="25" max="100" value="100" step="25">
                    </div>
                    
                    <div class="input-wrapper">
                        <label for="panelEfficiency">Panel Efficiency</label>
                        <select id="panelEfficiency" class="unit-select">
                            <option value="0.15">Standard Monocrystalline (15%)</option>
                            <option value="0.18">High-Efficiency Mono (18%)</option>
                            <option value="0.20" selected>Premium Mono (20%)</option>
                            <option value="0.22">Advanced Mono (22%)</option>
                            <option value="0.24">Top Tier Mono (24%)</option>
                        </select>
                    </div>
                    
                    <div class="input-wrapper">
                        <label for="roofAngle">Roof Angle (degrees)</label>
                        <input type="number" id="roofAngle" class="input-field" placeholder="30" value="30" min="0" max="90" step="5">
                    </div>
                    
                    <div class="input-wrapper">
                        <label for="roofDirection">Roof Direction</label>
                        <select id="roofDirection" class="unit-select">
                            <option value="1.0">South (Optimal)</option>
                            <option value="0.95">South-East/West (Very Good)</option>
                            <option value="0.85" selected>East/West (Good)</option>
                            <option value="0.65">North-East/West (Fair)</option>
                            <option value="0.5">North (Poor)</option>
                        </select>
                    </div>
                </div>

                <div class="input-group">
                    <h3>💰 Financial Settings</h3>
                    <div class="input-wrapper">
                        <label for="systemCost">System Cost per Watt ($/W)</label>
                        <input type="number" id="systemCost" class="input-field" placeholder="2.50" value="2.50" min="1.5" max="5.0" step="0.1">
                    </div>
                    
                    <div class="input-wrapper">
                        <label for="incentives">Tax Credits & Incentives (%)</label>
                        <input type="number" id="incentives" class="input-field" placeholder="30" value="30" min="0" max="100" step="5">
                    </div>
                    
                    <div class="input-wrapper">
                        <label for="degradation">Annual Degradation (%)</label>
                        <input type="number" id="degradation" class="input-field" placeholder="0.5" value="0.5" min="0" max="2" step="0.1">
                    </div>
                    
                    <div class="input-wrapper">
                        <label for="electricityIncrease">Annual Electricity Price Increase (%)</label>
                        <input type="number" id="electricityIncrease" class="input-field" placeholder="3.0" value="3.0" min="0" max="10" step="0.5">
                    </div>
                </div>
            </div>

            <button class="calculate-btn" id="calculateButton">Calculate Solar System</button>

            <div class="results-section">
                <div class="results-grid">
                    <div class="result-card">
                        <div class="result-label">System Size Needed</div>
                        <div class="result-value" id="systemSize">7.5</div>
                        <div class="result-unit">kW</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Number of Panels</div>
                        <div class="result-value" id="panelCount">20</div>
                        <div class="result-unit">panels</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Annual Production</div>
                        <div class="result-value" id="annualProduction">10,500</div>
                        <div class="result-unit">kWh</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Roof Space Required</div>
                        <div class="result-value" id="roofSpace">35</div>
                        <div class="result-unit">m²</div>
                    </div>
                </div>

                <div class="financial-breakdown">
                    <div class="financial-header">
                        <h3>💰 Financial Analysis</h3>
                    </div>
                    <div class="financial-grid">
                        <div class="financial-item">
                            <span class="financial-label">Total System Cost</span>
                            <span class="financial-value" id="totalCost">$18,750</span>
                        </div>
                        <div class="financial-item">
                            <span class="financial-label">After Incentives</span>
                            <span class="financial-value" id="netCost">$13,125</span>
                        </div>
                        <div class="financial-item">
                            <span class="financial-label">Annual Savings</span>
                            <span class="financial-value" id="annualSavings">$1,575</span>
                        </div>
                        <div class="financial-item">
                            <span class="financial-label">Payback Period</span>
                            <span class="financial-value" id="paybackPeriod">8.3 years</span>
                        </div>
                        <div class="financial-item">
                            <span class="financial-label">25-Year Savings</span>
                            <span class="financial-value" id="lifetimeSavings">$52,500</span>
                        </div>
                        <div class="financial-item">
                            <span class="financial-label">ROI</span>
                            <span class="financial-value" id="roiPercentage">300%</span>
                        </div>
                    </div>
                    
                    <div class="roi-timeline">
                        <div style="display: flex; justify-content: between; margin-bottom: 10px;">
                            <span>Year 0</span>
                            <span>Break-even: <strong id="breakEvenYear">8.3 years</strong></span>
                            <span>Year 25</span>
                        </div>
                        <div class="timeline-bar">
                            <div class="timeline-fill" id="timelineFill" style="width: 33%;"></div>
                            <div class="timeline-marker" id="breakEvenMarker" style="left: 33%;">Break-even</div>
                        </div>
                    </div>
                </div>

                <div class="system-design">
                    <div class="financial-header">
                        <h3>🔧 System Specifications</h3>
                    </div>
                    <div class="design-grid">
                        <div class="design-item">
                            <div class="design-icon">⚡</div>
                            <div class="design-value" id="panelWattage">375W</div>
                            <div class="design-label">Panel Wattage</div>
                        </div>
                        <div class="design-item">
                            <div class="design-icon">📐</div>
                            <div class="design-value" id="panelArea">1.8 m²</div>
                            <div class="design-label">Panel Area</div>
                        </div>
                        <div class="design-item">
                            <div class="design-icon">🔋</div>
                            <div class="design-value" id="inverterSize">6.0 kW</div>
                            <div class="design-label">Inverter Size</div>
                        </div>
                        <div class="design-item">
                            <div class="design-icon">🌞</div>
                            <div class="design-value" id="dailyProduction">28.8 kWh</div>
                            <div class="design-label">Daily Production</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="quick-scenarios">
                <h3>⚡ Common Scenarios</h3>
                <div class="scenarios-grid">
                    <div class="scenario-btn" onclick="setScenario(500, 0.12, 2.2)">
                        <div class="scenario-value">Small Home</div>
                        <div class="scenario-label">500 kWh/month</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(900, 0.15, 2.5)">
                        <div class="scenario-value">Average Home</div>
                        <div class="scenario-label">900 kWh/month</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(1500, 0.18, 2.8)">
                        <div class="scenario-value">Large Home</div>
                        <div class="scenario-label">1500 kWh/month</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(2500, 0.20, 2.0)">
                        <div class="scenario-value">Commercial</div>
                        <div class="scenario-label">2500 kWh/month</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(900, 0.10, 1.8)">
                        <div class="scenario-value">Low Cost Area</div>
                        <div class="scenario-label">$0.10/kWh</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(900, 0.25, 3.2)">
                        <div class="scenario-value">High Cost Area</div>
                        <div class="scenario-label">$0.25/kWh</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>☀️ Solar Energy Guide</h2>
            
            <p>Solar panels convert sunlight into electricity using photovoltaic cells. Understanding your solar potential helps maximize energy production and financial returns.</p>

            <div class="solar-grid">
                <div class="solar-card">
                    <h4>🌞 How Solar Panels Work</h4>
                    <p>Photovoltaic cells absorb sunlight, creating an electric field that generates direct current (DC) electricity, which is converted to alternating current (AC) for home use.</p>
                </div>
                <div class="solar-card">
                    <h4>💰 Financial Benefits</h4>
                    <p>Solar panels reduce electricity bills, provide protection against rising energy costs, and increase property value while reducing carbon footprint.</p>
                </div>
                <div class="solar-card">
                    <h4>🔧 System Components</h4>
                    <p>A complete system includes solar panels, inverters, mounting equipment, wiring, and monitoring systems for optimal performance.</p>
                </div>
            </div>

            <h3>📊 Solar Panel Types Comparison</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Panel Type</th>
                        <th>Efficiency</th>
                        <th>Cost</th>
                        <th>Lifespan</th>
                        <th>Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Monocrystalline</strong></td>
                        <td>15-22%</td>
                        <td>$$$</td>
                        <td>25-30 years</td>
                        <td>Limited space, high efficiency</td>
                    </tr>
                    <tr>
                        <td><strong>Polycrystalline</strong></td>
                        <td>13-16%</td>
                        <td>$$</td>
                        <td>23-27 years</td>
                        <td>Budget-conscious, ample space</td>
                    </tr>
                    <tr>
                        <td><strong>Thin-Film</strong></td>
                        <td>10-13%</td>
                        <td>$</td>
                        <td>10-20 years</td>
                        <td>Large areas, flexible installation</td>
                    </tr>
                    <tr>
                        <td><strong>Bifacial</strong></td>
                        <td>16-23%</td>
                        <td>$$$$</td>
                        <td>30+ years</td>
                        <td>Commercial, reflective surfaces</td>
                    </tr>
                </tbody>
            </table>

            <h3>🔬 Key Calculation Formulas</h3>
            <div class="formula-box">
                <strong>System Size Calculation:</strong><br>
                System Size (kW) = (Monthly Usage × 12) ÷ (Sun Hours × 365 × 0.8)<br><br>
                
                <strong>Energy Production:</strong><br>
                Annual Production = System Size × Sun Hours × 365 × Performance Ratio<br><br>
                
                <strong>Financial Analysis:</strong><br>
                Payback Period = Net System Cost ÷ Annual Savings<br>
                ROI = (Lifetime Savings - Net Cost) ÷ Net Cost × 100%
            </div>

            <h3>🌍 Regional Solar Potential</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Region Type</th>
                        <th>Daily Sun Hours</th>
                        <th>Annual Production per kW</th>
                        <th>Optimal System Tilt</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Desert/Sunny</strong></td>
                        <td>5.5-6.5 hours</td>
                        <td>1600-1900 kWh</td>
                        <td>20-30 degrees</td>
                    </tr>
                    <tr>
                        <td><strong>Temperate</strong></td>
                        <td>4.0-5.0 hours</td>
                        <td>1200-1500 kWh</td>
                        <td>30-40 degrees</td>
                    </tr>
                    <tr>
                        <td><strong>Northern</strong></td>
                        <td>3.0-4.0 hours</td>
                        <td>900-1200 kWh</td>
                        <td>35-45 degrees</td>
                    </tr>
                    <tr>
                        <td><strong>Coastal</strong></td>
                        <td>3.5-4.5 hours</td>
                        <td>1100-1400 kWh</td>
                        <td>25-35 degrees</td>
                    </tr>
                </tbody>
            </table>

            <h3>🏠 Residential System Sizing Guide</h3>
            <div class="solar-grid">
                <div class="solar-card">
                    <h4>👤 Small Household</h4>
                    <p><strong>1-2 people, 500-700 kWh/month</strong><br>
                    System: 3-5 kW<br>
                    Panels: 8-14<br>
                    Roof Space: 15-25 m²</p>
                </div>
                <div class="solar-card">
                    <h4>👨‍👩‍👧 Average Family</h4>
                    <p><strong>3-4 people, 800-1100 kWh/month</strong><br>
                    System: 6-8 kW<br>
                    Panels: 16-22<br>
                    Roof Space: 30-40 m²</p>
                </div>
                <div class="solar-card">
                    <h4>👨‍👩‍👧‍👦 Large Family</h4>
                    <p><strong>5+ people, 1200-2000 kWh/month</strong><br>
                    System: 9-15 kW<br>
                    Panels: 24-40<br>
                    Roof Space: 45-75 m²</p>
                </div>
            </div>

            <h3>💰 Financial Considerations</h3>
            <div class="formula-box">
                <strong>Key Financial Factors:</strong><br>
                • <strong>Upfront Cost:</strong> $2.50-$4.00 per watt installed<br>
                • <strong>Tax Credits:</strong> 26-30% federal tax credit available<br>
                • <strong>Payback Period:</strong> Typically 6-12 years<br>
                • <strong>Lifetime Savings:</strong> $20,000-$70,000 over 25 years<br>
                • <strong>Maintenance:</strong> Minimal, mostly cleaning and monitoring<br>
                • <strong>Warranty:</strong> 25-year performance, 10-12 year product
            </div>

            <h3>🔋 Battery Storage Options</h3>
            <ul>
                <li><strong>Lead-Acid:</strong> Affordable but shorter lifespan (3-7 years)</li>
                <li><strong>Lithium-Ion:</strong> Higher cost but longer life (10-15 years), better efficiency</li>
                <li><strong>Saltwater:</strong> Emerging technology, very safe but less energy dense</li>
                <li><strong>Flow Batteries:</strong> Commercial scale, very long lifespan</li>
            </ul>

            <h3>🌱 Environmental Impact</h3>
            <div class="solar-grid">
                <div class="solar-card">
                    <h4>📉 Carbon Reduction</h4>
                    <p>A typical 6 kW system offsets 4-6 tons of CO₂ annually, equivalent to planting 100 trees each year.</p>
                </div>
                <div class="solar-card">
                    <h4>💧 Water Savings</h4>
                    <p>Solar PV uses minimal water compared to fossil fuel power plants that require massive water for cooling.</p>
                </div>
                <div class="solar-card">
                    <h4>🔄 Energy Payback</h4>
                    <p>Modern solar panels recover their manufacturing energy in 1-4 years, then produce clean energy for decades.</p>
                </div>
            </div>

            <h3>⚡ Grid Connection & Net Metering</h3>
            <ul>
                <li><strong>Net Metering:</strong> Sell excess power back to grid, get credits on bill</li>
                <li><strong>Feed-in Tariffs:</strong> Fixed price for solar electricity exported</li>
                <li><strong>Time-of-Use:</strong> Higher rates during peak hours, optimize self-consumption</li>
                <li><strong>Grid Services:</strong> Some utilities offer payments for grid support services</li>
            </ul>

            <h3>🔧 Maintenance & Monitoring</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Frequency</th>
                        <th>Cost</th>
                        <th>Importance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Panel Cleaning</strong></td>
                        <td>1-2 times/year</td>
                        <td>$100-200 or DIY</td>
                        <td>High (5-15% production loss if dirty)</td>
                    </tr>
                    <tr>
                        <td><strong>System Monitoring</strong></td>
                        <td>Continuous</td>
                        <td>Included</td>
                        <td>High (early problem detection)</td>
                    </tr>
                    <tr>
                        <td><strong>Inverter Check</strong></td>
                        <td>5 years</td>
                        <td>$200-500</td>
                        <td>Medium (typical lifespan 10-15 years)</td>
                    </tr>
                    <tr>
                        <td><strong>Professional Inspection</strong></td>
                        <td>3-5 years</td>
                        <td>$300-600</td>
                        <td>Medium (safety and performance verification)</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>☀️ Solar Panel Calculator | Energy Production & ROI Analysis</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate system requirements, energy production, cost savings, and environmental impact for solar installations</p>
        </div>
    </div>

    <script>
        // DOM elements
        const locationSelect = document.getElementById('location');
        const energyUsageInput = document.getElementById('energyUsage');
        const electricityRateInput = document.getElementById('electricityRate');
        const coverageSlider = document.getElementById('coverageSlider');
        const coverageValue = document.getElementById('coverageValue');
        const panelEfficiencySelect = document.getElementById('panelEfficiency');
        const roofAngleInput = document.getElementById('roofAngle');
        const roofDirectionSelect = document.getElementById('roofDirection');
        const systemCostInput = document.getElementById('systemCost');
        const incentivesInput = document.getElementById('incentives');
        const degradationInput = document.getElementById('degradation');
        const electricityIncreaseInput = document.getElementById('electricityIncrease');
        const calculateButton = document.getElementById('calculateButton');

        // Results elements
        const systemSizeElement = document.getElementById('systemSize');
        const panelCountElement = document.getElementById('panelCount');
        const annualProductionElement = document.getElementById('annualProduction');
        const roofSpaceElement = document.getElementById('roofSpace');
        const totalCostElement = document.getElementById('totalCost');
        const netCostElement = document.getElementById('netCost');
        const annualSavingsElement = document.getElementById('annualSavings');
        const paybackPeriodElement = document.getElementById('paybackPeriod');
        const lifetimeSavingsElement = document.getElementById('lifetimeSavings');
        const roiPercentageElement = document.getElementById('roiPercentage');
        const breakEvenYearElement = document.getElementById('breakEvenYear');
        const timelineFillElement = document.getElementById('timelineFill');
        const breakEvenMarkerElement = document.getElementById('breakEvenMarker');
        const panelWattageElement = document.getElementById('panelWattage');
        const panelAreaElement = document.getElementById('panelArea');
        const inverterSizeElement = document.getElementById('inverterSize');
        const dailyProductionElement = document.getElementById('dailyProduction');

        // Event listeners
        calculateButton.addEventListener('click', calculateSolarSystem);
        coverageSlider.addEventListener('input', updateCoverageValue);
        
        // Initialize slider value
        updateCoverageValue();
        
        // Initial calculation
        calculateSolarSystem();

        function updateCoverageValue() {
            coverageValue.textContent = coverageSlider.value + '%';
        }

        function calculateSolarSystem() {
            // Get input values
            const sunHours = parseFloat(locationSelect.value);
            const monthlyUsage = parseFloat(energyUsageInput.value);
            const electricityRate = parseFloat(electricityRateInput.value);
            const coverage = parseFloat(coverageSlider.value) / 100;
            const panelEfficiency = parseFloat(panelEfficiencySelect.value);
            const roofAngle = parseFloat(roofAngleInput.value);
            const roofDirection = parseFloat(roofDirectionSelect.value);
            const costPerWatt = parseFloat(systemCostInput.value);
            const incentives = parseFloat(incentivesInput.value) / 100;
            const degradation = parseFloat(degradationInput.value) / 100;
            const electricityIncrease = parseFloat(electricityIncreaseInput.value) / 100;

            // Calculate system requirements
            const annualUsage = monthlyUsage * 12;
            const targetAnnualProduction = annualUsage * coverage;
            
            // System size calculation
            const performanceRatio = 0.8 * roofDirection; // Includes losses and orientation
            const systemSizeKW = targetAnnualProduction / (sunHours * 365 * performanceRatio);
            const systemSizeW = systemSizeKW * 1000;

            // Panel specifications
            const panelWattage = 375; // Standard panel wattage
            const panelCount = Math.ceil(systemSizeW / panelWattage);
            const panelAreaPerUnit = 1.8; // m² per panel
            const totalRoofSpace = panelCount * panelAreaPerUnit;

            // Energy production
            const annualProduction = systemSizeKW * sunHours * 365 * performanceRatio;
            const dailyProduction = annualProduction / 365;

            // Inverter sizing (typically 80% of system size)
            const inverterSize = systemSizeKW * 0.8;

            // Financial calculations
            const totalCost = systemSizeW * costPerWatt;
            const netCost = totalCost * (1 - incentives);
            const annualSavings = Math.min(annualProduction, annualUsage) * electricityRate;
            const paybackYears = netCost / annualSavings;

            // 25-year financial projection
            let lifetimeSavings = 0;
            let cumulativeSavings = 0;
            let currentProduction = annualProduction;
            
            for (let year = 1; year <= 25; year++) {
                const currentRate = electricityRate * Math.pow(1 + electricityIncrease, year - 1);
                const yearSavings = Math.min(currentProduction, annualUsage) * currentRate;
                lifetimeSavings += yearSavings;
                currentProduction *= (1 - degradation);
            }

            const roi = ((lifetimeSavings - netCost) / netCost) * 100;

            // Update results
            updateResults(
                systemSizeKW, panelCount, annualProduction, totalRoofSpace,
                totalCost, netCost, annualSavings, paybackYears, lifetimeSavings, roi,
                panelWattage, panelAreaPerUnit, inverterSize, dailyProduction
            );
        }

        function updateResults(
            systemSize, panelCount, annualProduction, roofSpace,
            totalCost, netCost, annualSavings, paybackYears, lifetimeSavings, roi,
            panelWattage, panelArea, inverterSize, dailyProduction
        ) {
            systemSizeElement.textContent = systemSize.toFixed(1);
            panelCountElement.textContent = panelCount;
            annualProductionElement.textContent = Math.round(annualProduction).toLocaleString();
            roofSpaceElement.textContent = Math.round(roofSpace);
            
            totalCostElement.textContent = '$' + Math.round(totalCost).toLocaleString();
            netCostElement.textContent = '$' + Math.round(netCost).toLocaleString();
            annualSavingsElement.textContent = '$' + Math.round(annualSavings).toLocaleString();
            paybackPeriodElement.textContent = paybackYears.toFixed(1) + ' years';
            lifetimeSavingsElement.textContent = '$' + Math.round(lifetimeSavings).toLocaleString();
            roiPercentageElement.textContent = roi.toFixed(0) + '%';
            
            breakEvenYearElement.textContent = paybackYears.toFixed(1) + ' years';
            
            // Update timeline (25 years total)
            const breakEvenPercentage = (paybackYears / 25) * 100;
            timelineFillElement.style.width = breakEvenPercentage + '%';
            breakEvenMarkerElement.style.left = breakEvenPercentage + '%';
            
            // Update system specifications
            panelWattageElement.textContent = panelWattage + 'W';
            panelAreaElement.textContent = panelArea.toFixed(1) + ' m²';
            inverterSizeElement.textContent = inverterSize.toFixed(1) + ' kW';
            dailyProductionElement.textContent = dailyProduction.toFixed(1) + ' kWh';
        }

        function setScenario(monthlyUsage, electricityRate, systemCost) {
            energyUsageInput.value = monthlyUsage;
            electricityRateInput.value = electricityRate;
            systemCostInput.value = systemCost;
            calculateSolarSystem();
        }

        // Make function available globally
        window.setScenario = setScenario;
    </script>
</body>
</html>
