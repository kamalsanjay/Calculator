<?php
/**
 * BTU Calculator
 * File: weather/btu-calculator.php
 * Description: Advanced BTU calculator for heating and cooling requirements with room analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BTU Calculator - Advanced Heating & Cooling Requirements</title>
    <meta name="description" content="Calculate precise BTU requirements for rooms, HVAC systems, and appliances with advanced room analysis and climate factors.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-tabs { display: flex; gap: 10px; margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; flex-wrap: wrap; }
        .tab { padding: 12px 24px; background: #f8f9fa; border: none; border-radius: 8px 8px 0 0; cursor: pointer; transition: all 0.3s; font-weight: 600; color: #7f8c8d; }
        .tab.active { background: #74b9ff; color: white; }
        
        .input-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px; }
        
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input, .input-wrapper select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus { outline: none; border-color: #74b9ff; box-shadow: 0 0 0 3px rgba(116, 185, 255, 0.1); }
        .unit { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #7f8c8d; font-weight: 600; }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .checkbox-group input[type="checkbox"] { width: 18px; height: 18px; }
        
        .calculate-btn { background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%); color: white; border: none; padding: 16px 32px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin: 20px 0; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(116, 185, 255, 0.3); }
        
        .results-section { margin-top: 30px; }
        .results-section h3 { color: #2c3e50; margin-bottom: 20px; font-size: 1.3rem; }
        
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .result-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 25px; border-radius: 12px; border-left: 4px solid #74b9ff; text-align: center; }
        .result-label { color: #4527a0; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-value { font-size: 1.5rem; font-weight: bold; color: #5e35b1; margin-bottom: 5px; }
        .result-unit { color: #7e57c2; font-size: 0.9rem; }
        
        .recommendation-box { background: #e3f2fd; padding: 25px; border-radius: 12px; border-left: 4px solid #2196f3; margin: 25px 0; }
        .recommendation-box h4 { color: #1976d2; margin-bottom: 15px; font-size: 1.1rem; }
        .recommendation-list { list-style: none; }
        .recommendation-list li { padding: 8px 0; color: #555; position: relative; padding-left: 20px; }
        .recommendation-list li:before { content: "✓"; position: absolute; left: 0; color: #4caf50; font-weight: bold; }
        
        .room-analysis { background: white; border: 2px solid #e0e0e0; border-radius: 12px; padding: 25px; margin-top: 25px; }
        .room-analysis h4 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        
        .comparison-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .comparison-table th, .comparison-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .comparison-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .comparison-table tr:hover { background: #f5f5f5; }
        
        .action-buttons { display: flex; gap: 12px; margin-top: 20px; flex-wrap: wrap; }
        .action-btn { padding: 12px 20px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; }
        .action-btn:hover { border-color: #74b9ff; background: #f0f8ff; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .formula-box { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #2196f3; }
        .formula-box strong { color: #1976d2; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-grid { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .calculator-tabs { flex-direction: column; }
            .tab { border-radius: 8px; margin-bottom: 5px; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { flex-direction: column; }
        }
        
        /* Room visualization */
        .room-visualization { width: 100%; height: 200px; background: #f8f9fa; border-radius: 8px; margin: 20px 0; position: relative; border: 2px solid #e0e0e0; }
        .room-walls { position: absolute; top: 10px; left: 10px; right: 10px; bottom: 10px; border: 2px solid #bdc3c7; }
        .room-window { position: absolute; top: 20px; right: 30px; width: 40px; height: 60px; background: #74b9ff; opacity: 0.6; }
        .room-door { position: absolute; bottom: 10px; left: 50px; width: 30px; height: 50px; background: #8b4513; }
        
        /* Progress bars */
        .factor-bars { margin: 20px 0; }
        .factor-bar { margin-bottom: 15px; }
        .factor-label { display: flex; justify-content: between; margin-bottom: 5px; }
        .factor-name { font-weight: 600; color: #34495e; }
        .factor-value { color: #7f8c8d; }
        .factor-progress { height: 8px; background: #ecf0f1; border-radius: 4px; overflow: hidden; }
        .factor-progress-fill { height: 100%; background: linear-gradient(90deg, #74b9ff, #0984e3); border-radius: 4px; transition: width 0.5s ease; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔥 BTU Calculator</h1>
            <p>Calculate precise British Thermal Unit requirements for heating and cooling with advanced room analysis</p>
        </div>

        <div class="calculator-card">
            <div class="calculator-tabs">
                <button class="tab active" onclick="switchTab('room')">Room Calculator</button>
                <button class="tab" onclick="switchTab('appliance')">Appliance Calculator</button>
                <button class="tab" onclick="switchTab('advanced')">Advanced Analysis</button>
            </div>

            <div id="roomTab" class="tab-content">
                <div class="input-grid">
                    <div class="input-group">
                        <label for="roomLength">Room Length</label>
                        <div class="input-wrapper">
                            <input type="number" id="roomLength" placeholder="Enter length" value="15" step="0.1">
                            <span class="unit">ft</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="roomWidth">Room Width</label>
                        <div class="input-wrapper">
                            <input type="number" id="roomWidth" placeholder="Enter width" value="12" step="0.1">
                            <span class="unit">ft</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="ceilingHeight">Ceiling Height</label>
                        <div class="input-wrapper">
                            <input type="number" id="ceilingHeight" placeholder="Enter height" value="8" step="0.1">
                            <span class="unit">ft</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="roomType">Room Type</label>
                        <div class="input-wrapper">
                            <select id="roomType">
                                <option value="living">Living Room / Bedroom</option>
                                <option value="kitchen">Kitchen</option>
                                <option value="bathroom">Bathroom</option>
                                <option value="garage">Garage / Workshop</option>
                                <option value="office">Office</option>
                                <option value="basement">Basement</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="input-grid">
                    <div class="input-group">
                        <label for="climateZone">Climate Zone</label>
                        <div class="input-wrapper">
                            <select id="climateZone">
                                <option value="hot">Hot (Southern US)</option>
                                <option value="moderate" selected>Moderate (Central US)</option>
                                <option value="cold">Cold (Northern US)</option>
                                <option value="very_cold">Very Cold (Canada/Alaska)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="insulation">Insulation Quality</label>
                        <div class="input-wrapper">
                            <select id="insulation">
                                <option value="poor">Poor (Old construction)</option>
                                <option value="average" selected>Average (Standard)</option>
                                <option value="good">Good (Well insulated)</option>
                                <option value="excellent">Excellent (New construction)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="windowCount">Number of Windows</label>
                        <div class="input-wrapper">
                            <input type="number" id="windowCount" placeholder="Number of windows" value="2" min="0">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="sunExposure">Sun Exposure</label>
                        <div class="input-wrapper">
                            <select id="sunExposure">
                                <option value="heavy_shade">Heavy Shade</option>
                                <option value="partial_shade">Partial Shade</option>
                                <option value="mixed" selected>Mixed Sun/Shade</option>
                                <option value="partial_sun">Partial Sun</option>
                                <option value="full_sun">Full Sun</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="room-visualization">
                    <div class="room-walls">
                        <div class="room-window"></div>
                        <div class="room-door"></div>
                    </div>
                </div>

                <h4 style="color: #2c3e50; margin: 20px 0 15px 0;">Additional Factors</h4>
                <div class="input-grid">
                    <div class="checkbox-group">
                        <input type="checkbox" id="hasAC" checked>
                        <label for="hasAC">Room has air conditioning</label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="hasHeating">
                        <label for="hasHeating">Room has heating</label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="hasComputers">
                        <label for="hasComputers">Computers/electronics present</label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="hasPeople">
                        <label for="hasPeople">Regularly occupied by people</label>
                    </div>
                </div>
            </div>

            <div id="applianceTab" class="tab-content" style="display: none;">
                <div class="input-grid">
                    <div class="input-group">
                        <label for="applianceType">Appliance Type</label>
                        <div class="input-wrapper">
                            <select id="applianceType">
                                <option value="refrigerator">Refrigerator</option>
                                <option value="freezer">Freezer</option>
                                <option value="oven">Oven/Range</option>
                                <option value="microwave">Microwave</option>
                                <option value="dishwasher">Dishwasher</option>
                                <option value="washer">Washing Machine</option>
                                <option value="dryer">Dryer</option>
                                <option value="ac_unit">AC Unit</option>
                                <option value="heater">Space Heater</option>
                                <option value="computer">Computer/Server</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="appliancePower">Power Consumption</label>
                        <div class="input-wrapper">
                            <input type="number" id="appliancePower" placeholder="Enter power" value="1500" step="10">
                            <span class="unit">watts</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="usageHours">Daily Usage Hours</label>
                        <div class="input-wrapper">
                            <input type="number" id="usageHours" placeholder="Hours per day" value="8" step="0.5" min="0" max="24">
                            <span class="unit">hours</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="efficiency">Efficiency Rating</label>
                        <div class="input-wrapper">
                            <select id="efficiency">
                                <option value="low">Low Efficiency</option>
                                <option value="standard" selected>Standard</option>
                                <option value="high">High Efficiency</option>
                                <option value="energy_star">Energy Star</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="advancedTab" class="tab-content" style="display: none;">
                <div class="input-grid">
                    <div class="input-group">
                        <label for="desiredTemp">Desired Temperature</label>
                        <div class="input-wrapper">
                            <input type="number" id="desiredTemp" placeholder="Target temperature" value="72" step="1">
                            <span class="unit">°F</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="outsideTemp">Outside Temperature</label>
                        <div class="input-wrapper">
                            <input type="number" id="outsideTemp" placeholder="Outside temp" value="32" step="1">
                            <span class="unit">°F</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="humidity">Humidity Level</label>
                        <div class="input-wrapper">
                            <select id="humidity">
                                <option value="dry">Dry (0-30%)</option>
                                <option value="comfortable" selected>Comfortable (30-50%)</option>
                                <option value="humid">Humid (50-70%)</option>
                                <option value="very_humid">Very Humid (70%+)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="airChanges">Air Changes per Hour</label>
                        <div class="input-wrapper">
                            <select id="airChanges">
                                <option value="tight">Tight (0.2-0.3)</option>
                                <option value="average" selected>Average (0.5-0.7)</option>
                                <option value="leaky">Leaky (1.0-1.5)</option>
                                <option value="very_leaky">Very Leaky (2.0+)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <button class="calculate-btn" onclick="calculateBTU()">🔥 Calculate BTU Requirements</button>

            <div class="results-section" id="resultsSection" style="display: none;">
                <h3>📊 BTU Calculation Results</h3>
                
                <div class="results-grid">
                    <div class="result-card">
                        <div class="result-label">Total BTU Required</div>
                        <div class="result-value" id="totalBTU">0</div>
                        <div class="result-unit">BTU/hr</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Recommended AC Size</div>
                        <div class="result-value" id="acSize">0</div>
                        <div class="result-unit">Tons</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Room Volume</div>
                        <div class="result-value" id="roomVolume">0</div>
                        <div class="result-unit">cubic feet</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Heat Load Factor</div>
                        <div class="result-value" id="heatLoad">0</div>
                        <div class="result-unit">BTU/ft³</div>
                    </div>
                </div>

                <div class="factor-bars">
                    <h4 style="color: #2c3e50; margin-bottom: 15px;">Heat Load Factors</h4>
                    <div class="factor-bar">
                        <div class="factor-label">
                            <span class="factor-name">Room Size</span>
                            <span class="factor-value" id="sizeFactor">0%</span>
                        </div>
                        <div class="factor-progress">
                            <div class="factor-progress-fill" id="sizeProgress" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <div class="factor-bar">
                        <div class="factor-label">
                            <span class="factor-name">Insulation</span>
                            <span class="factor-value" id="insulationFactor">0%</span>
                        </div>
                        <div class="factor-progress">
                            <div class="factor-progress-fill" id="insulationProgress" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <div class="factor-bar">
                        <div class="factor-label">
                            <span class="factor-name">Windows</span>
                            <span class="factor-value" id="windowFactor">0%</span>
                        </div>
                        <div class="factor-progress">
                            <div class="factor-progress-fill" id="windowProgress" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <div class="factor-bar">
                        <div class="factor-label">
                            <span class="factor-name">Climate</span>
                            <span class="factor-value" id="climateFactor">0%</span>
                        </div>
                        <div class="factor-progress">
                            <div class="factor-progress-fill" id="climateProgress" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <div class="recommendation-box">
                    <h4>💡 Recommended Equipment</h4>
                    <ul class="recommendation-list" id="equipmentList">
                        <!-- Recommendations will be populated here -->
                    </ul>
                </div>

                <div class="room-analysis">
                    <h4>🏠 Room Analysis</h4>
                    <table class="comparison-table">
                        <thead>
                            <tr>
                                <th>Factor</th>
                                <th>Current</th>
                                <th>Impact</th>
                                <th>Improvement</th>
                            </tr>
                        </thead>
                        <tbody id="analysisTable">
                            <!-- Analysis data will be populated here -->
                        </tbody>
                    </table>
                </div>

                <div class="action-buttons">
                    <button class="action-btn" onclick="saveCalculation()">
                        💾 Save Calculation
                    </button>
                    <button class="action-btn" onclick="printResults()">
                        🖨️ Print Results
                    </button>
                    <button class="action-btn" onclick="shareResults()">
                        📤 Share Results
                    </button>
                    <button class="action-btn" onclick="resetCalculator()">
                        🔄 Reset Calculator
                    </button>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🔥 Understanding BTU Calculations</h2>
            
            <p>BTU (British Thermal Unit) is the amount of heat required to raise the temperature of one pound of water by one degree Fahrenheit. Accurate BTU calculation is essential for proper HVAC system sizing and energy efficiency.</p>

            <h3>📊 Key BTU Calculation Factors</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Factor</th>
                        <th>Impact on BTU</th>
                        <th>Typical Range</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Room Size</strong></td>
                        <td>Direct proportional relationship</td>
                        <td>20-50 BTU/ft²</td>
                    </tr>
                    <tr>
                        <td><strong>Insulation</strong></td>
                        <td>Poor insulation increases BTU needs</td>
                        <td>±15-30%</td>
                    </tr>
                    <tr>
                        <td><strong>Windows</strong></td>
                        <td>Each window adds significant load</td>
                        <td>100-500 BTU/window</td>
                    </tr>
                    <tr>
                        <td><strong>Climate Zone</strong></td>
                        <td>Colder climates require more heating</td>
                        <td>±20-40%</td>
                    </tr>
                    <tr>
                        <td><strong>Occupancy</strong></td>
                        <td>Each person adds body heat</td>
                        <td>400 BTU/person</td>
                    </tr>
                    <tr>
                        <td><strong>Electronics</strong></td>
                        <td>Equipment generates additional heat</td>
                        <td>3.41 BTU/watt</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Basic BTU Calculation Formula:</strong><br>
                BTU = (Room Volume × Temperature Difference × Air Changes × 0.018) + (Window Area × 20) + (Number of Occupants × 400) + (Equipment Watts × 3.41)
            </div>

            <h3>🎯 Room Type Guidelines</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Room Type</th>
                        <th>Recommended BTU/ft²</th>
                        <th>Special Considerations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Living Room/Bedroom</strong></td>
                        <td>20-25 BTU/ft²</td>
                        <td>Standard occupancy, moderate equipment</td>
                    </tr>
                    <tr>
                        <td><strong>Kitchen</strong></td>
                        <td>30-40 BTU/ft²</td>
                        <td>Appliances generate significant heat</td>
                    </tr>
                    <tr>
                        <td><strong>Bathroom</strong></td>
                        <td>15-20 BTU/ft²</td>
                        <td>Small space, high humidity considerations</td>
                    </tr>
                    <tr>
                        <td><strong>Garage/Workshop</strong></td>
                        <td>25-35 BTU/ft²</td>
                        <td>Poor insulation, equipment heat</td>
                    </tr>
                    <tr>
                        <td><strong>Office</strong></td>
                        <td>25-30 BTU/ft²</td>
                        <td>Computer equipment, longer occupancy</td>
                    </tr>
                    <tr>
                        <td><strong>Basement</strong></td>
                        <td>15-20 BTU/ft²</td>
                        <td>Natural insulation, limited windows</td>
                    </tr>
                </tbody>
            </table>

            <h3>🌡️ Climate Zone Adjustments</h3>
            <ul>
                <li><strong>Hot Climate:</strong> Focus on cooling, reduce heating BTU by 20%</li>
                <li><strong>Moderate Climate:</strong> Balanced heating and cooling needs</li>
                <li><strong>Cold Climate:</strong> Increase heating BTU by 25-40%</li>
                <li><strong>Very Cold Climate:</strong> Increase heating BTU by 40-60%</li>
            </ul>

            <h3>💡 Energy Efficiency Tips</h3>
            <div class="formula-box">
                <strong>Improving Efficiency:</strong><br>
                • Upgrade insulation (reduces BTU needs by 15-30%)<br>
                • Install energy-efficient windows (reduces load by 10-20%)<br>
                • Use programmable thermostats (saves 5-15% on energy)<br>
                • Seal air leaks (reduces infiltration by 10-30%)<br>
                • Regular HVAC maintenance (improves efficiency by 5-15%)
            </div>

            <h3>🔧 HVAC Sizing Guidelines</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>BTU Range</th>
                        <th>Recommended AC Size</th>
                        <th>Room Size (approx.)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>5,000 - 7,000 BTU</td>
                        <td>0.5 Ton</td>
                        <td>100-300 ft²</td>
                    </tr>
                    <tr>
                        <td>8,000 - 12,000 BTU</td>
                        <td>1 Ton</td>
                        <td>300-500 ft²</td>
                    </tr>
                    <tr>
                        <td>13,000 - 18,000 BTU</td>
                        <td>1.5 Ton</td>
                        <td>500-750 ft²</td>
                    </tr>
                    <tr>
                        <td>19,000 - 24,000 BTU</td>
                        <td>2 Ton</td>
                        <td>750-1,000 ft²</td>
                    </tr>
                    <tr>
                        <td>25,000 - 30,000 BTU</td>
                        <td>2.5 Ton</td>
                        <td>1,000-1,300 ft²</td>
                    </tr>
                    <tr>
                        <td>31,000 - 36,000 BTU</td>
                        <td>3 Ton</td>
                        <td>1,300-1,500 ft²</td>
                    </tr>
                </tbody>
            </table>

            <h3>⚠️ Common Mistakes to Avoid</h3>
            <ul>
                <li><strong>Oversizing:</strong> Leads to short cycling, reduced efficiency, and poor humidity control</li>
                <li><strong>Undersizing:</strong> Results in inadequate temperature control and excessive runtime</li>
                <li><strong>Ignoring insulation:</strong> Fails to account for significant heat transfer</li>
                <li><strong>Overlooking windows:</strong> Windows account for 25-40% of heat gain/loss</li>
                <li><strong>Not considering occupancy:</strong> People and equipment add significant heat load</li>
            </ul>
        </div>

        <div class="footer">
            <p>🔥 Advanced BTU Calculator | Professional Heating & Cooling Analysis</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Room analysis, climate factors, equipment recommendations, and energy efficiency guidance</p>
        </div>
    </div>

    <script>
        // DOM elements
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');
        const resultsSection = document.getElementById('resultsSection');

        // Switch between tabs
        function switchTab(tabName) {
            // Update tab buttons
            tabs.forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');
            
            // Show selected tab content
            tabContents.forEach(content => content.style.display = 'none');
            document.getElementById(tabName + 'Tab').style.display = 'block';
        }

        // Calculate BTU requirements
        function calculateBTU() {
            // Get input values
            const length = parseFloat(document.getElementById('roomLength').value) || 0;
            const width = parseFloat(document.getElementById('roomWidth').value) || 0;
            const height = parseFloat(document.getElementById('ceilingHeight').value) || 0;
            const roomType = document.getElementById('roomType').value;
            const climateZone = document.getElementById('climateZone').value;
            const insulation = document.getElementById('insulation').value;
            const windowCount = parseInt(document.getElementById('windowCount').value) || 0;
            const sunExposure = document.getElementById('sunExposure').value;
            
            // Calculate room volume and area
            const roomArea = length * width;
            const roomVolume = roomArea * height;
            
            // Base BTU calculation (20 BTU per square foot as starting point)
            let baseBTU = roomArea * 20;
            
            // Room type multiplier
            const roomMultipliers = {
                'living': 1.0,
                'kitchen': 1.4,
                'bathroom': 0.8,
                'garage': 1.3,
                'office': 1.2,
                'basement': 0.9
            };
            baseBTU *= roomMultipliers[roomType];
            
            // Climate zone adjustment
            const climateMultipliers = {
                'hot': 0.9,
                'moderate': 1.0,
                'cold': 1.25,
                'very_cold': 1.5
            };
            baseBTU *= climateMultipliers[climateZone];
            
            // Insulation adjustment
            const insulationMultipliers = {
                'poor': 1.3,
                'average': 1.0,
                'good': 0.85,
                'excellent': 0.7
            };
            baseBTU *= insulationMultipliers[insulation];
            
            // Window adjustment
            const windowBTU = windowCount * 250;
            baseBTU += windowBTU;
            
            // Sun exposure adjustment
            const sunMultipliers = {
                'heavy_shade': 0.9,
                'partial_shade': 0.95,
                'mixed': 1.0,
                'partial_sun': 1.1,
                'full_sun': 1.2
            };
            baseBTU *= sunMultipliers[sunExposure];
            
            // Additional factors
            if (document.getElementById('hasComputers').checked) baseBTU += 500;
            if (document.getElementById('hasPeople').checked) baseBTU += 400;
            
            // Round to nearest 1000
            const totalBTU = Math.round(baseBTU / 1000) * 1000;
            
            // Calculate AC size (1 ton = 12,000 BTU)
            const acSize = (totalBTU / 12000).toFixed(1);
            
            // Calculate heat load factor
            const heatLoad = (totalBTU / roomVolume).toFixed(2);
            
            // Update results
            document.getElementById('totalBTU').textContent = totalBTU.toLocaleString();
            document.getElementById('acSize').textContent = acSize;
            document.getElementById('roomVolume').textContent = Math.round(roomVolume).toLocaleString();
            document.getElementById('heatLoad').textContent = heatLoad;
            
            // Update factor bars
            updateFactorBars(roomArea, insulation, windowCount, climateZone);
            
            // Generate recommendations
            generateRecommendations(totalBTU, roomType, insulation);
            
            // Generate analysis
            generateAnalysis(length, width, height, roomType, insulation, windowCount);
            
            // Show results section
            resultsSection.style.display = 'block';
            
            // Scroll to results
            resultsSection.scrollIntoView({ behavior: 'smooth' });
        }

        // Update factor progress bars
        function updateFactorBars(roomArea, insulation, windowCount, climateZone) {
            // Size factor (based on room area, normalized)
            const sizeFactor = Math.min((roomArea / 300) * 100, 100);
            document.getElementById('sizeFactor').textContent = Math.round(sizeFactor) + '%';
            document.getElementById('sizeProgress').style.width = sizeFactor + '%';
            
            // Insulation factor
            const insulationFactors = { 'poor': 100, 'average': 75, 'good': 50, 'excellent': 25 };
            document.getElementById('insulationFactor').textContent = insulationFactors[insulation] + '%';
            document.getElementById('insulationProgress').style.width = insulationFactors[insulation] + '%';
            
            // Window factor
            const windowFactor = Math.min((windowCount / 8) * 100, 100);
            document.getElementById('windowFactor').textContent = Math.round(windowFactor) + '%';
            document.getElementById('windowProgress').style.width = windowFactor + '%';
            
            // Climate factor
            const climateFactors = { 'hot': 60, 'moderate': 75, 'cold': 90, 'very_cold': 100 };
            document.getElementById('climateFactor').textContent = climateFactors[climateZone] + '%';
            document.getElementById('climateProgress').style.width = climateFactors[climateZone] + '%';
        }

        // Generate equipment recommendations
        function generateRecommendations(totalBTU, roomType, insulation) {
            const equipmentList = document.getElementById('equipmentList');
            equipmentList.innerHTML = '';
            
            const recommendations = [
                `Portable AC unit (${Math.round(totalBTU/1000)}k BTU) for flexible cooling`,
                `Programmable thermostat for energy savings`,
                `Ceiling fan to improve air circulation`
            ];
            
            if (insulation === 'poor') {
                recommendations.push('Insulation upgrade to reduce energy costs by 20-30%');
            }
            
            if (roomType === 'kitchen') {
                recommendations.push('Range hood with exterior ventilation');
            }
            
            if (totalBTU > 18000) {
                recommendations.push('Consider mini-split system for better efficiency');
            }
            
            recommendations.forEach(rec => {
                const li = document.createElement('li');
                li.textContent = rec;
                equipmentList.appendChild(li);
            });
        }

        // Generate room analysis
        function generateAnalysis(length, width, height, roomType, insulation, windowCount) {
            const analysisTable = document.getElementById('analysisTable');
            analysisTable.innerHTML = '';
            
            const roomArea = length * width;
            const roomVolume = roomArea * height;
            
            const analysisData = [
                ['Room Size', `${roomArea.toLocaleString()} ft²`, 'Large rooms require more BTU', 'Consider room dividers for zoning'],
                ['Insulation', insulation.charAt(0).toUpperCase() + insulation.slice(1), getInsulationImpact(insulation), getInsulationImprovement(insulation)],
                ['Windows', windowCount + ' windows', `${(windowCount * 250).toLocaleString()} BTU additional load`, 'Consider energy-efficient windows'],
                ['Room Type', roomType.charAt(0).toUpperCase() + roomType.slice(1), getRoomTypeImpact(roomType), getRoomTypeSuggestion(roomType)],
                ['Volume', `${Math.round(roomVolume).toLocaleString()} ft³`, 'Affects air circulation needs', 'Ensure proper ventilation']
            ];
            
            analysisData.forEach(row => {
                const tr = document.createElement('tr');
                row.forEach(cell => {
                    const td = document.createElement('td');
                    td.textContent = cell;
                    tr.appendChild(td);
                });
                analysisTable.appendChild(tr);
            });
        }

        // Helper functions for analysis
        function getInsulationImpact(insulation) {
            const impacts = {
                'poor': 'High heat loss/gain',
                'average': 'Moderate efficiency',
                'good': 'Good thermal retention',
                'excellent': 'Excellent efficiency'
            };
            return impacts[insulation];
        }

        function getInsulationImprovement(insulation) {
            const improvements = {
                'poor': 'Upgrade recommended',
                'average': 'Consider improvements',
                'good': 'Maintain current',
                'excellent': 'Optimal condition'
            };
            return improvements[insulation];
        }

        function getRoomTypeImpact(roomType) {
            const impacts = {
                'living': 'Standard occupancy',
                'kitchen': 'High appliance load',
                'bathroom': 'Humidity concerns',
                'garage': 'Poor insulation',
                'office': 'Equipment heat',
                'basement': 'Natural insulation'
            };
            return impacts[roomType];
        }

        function getRoomTypeSuggestion(roomType) {
            const suggestions = {
                'living': 'Standard HVAC adequate',
                'kitchen': 'Ventilation important',
                'bathroom': 'Consider exhaust fan',
                'garage': 'Supplemental heating',
                'office': 'Zone cooling option',
                'basement': 'Dehumidifier recommended'
            };
            return suggestions[roomType];
        }

        // Action functions
        function saveCalculation() {
            const data = {
                totalBTU: document.getElementById('totalBTU').textContent,
                timestamp: new Date().toLocaleString()
            };
            localStorage.setItem('btuCalculation', JSON.stringify(data));
            alert('Calculation saved successfully!');
        }

        function printResults() {
            window.print();
        }

        function shareResults() {
            const totalBTU = document.getElementById('totalBTU').textContent;
            const acSize = document.getElementById('acSize').textContent;
            
            if (navigator.share) {
                navigator.share({
                    title: 'BTU Calculation Results',
                    text: `My room requires ${totalBTU} BTU (${acSize} tons AC)`,
                    url: window.location.href
                });
            } else {
                alert('Share functionality not available in this browser. Results copied to clipboard.');
                navigator.clipboard.writeText(`BTU Calculation: ${totalBTU} BTU required, ${acSize} tons AC recommended`);
            }
        }

        function resetCalculator() {
            document.getElementById('roomLength').value = '15';
            document.getElementById('roomWidth').value = '12';
            document.getElementById('ceilingHeight').value = '8';
            document.getElementById('roomType').value = 'living';
            document.getElementById('climateZone').value = 'moderate';
            document.getElementById('insulation').value = 'average';
            document.getElementById('windowCount').value = '2';
            document.getElementById('sunExposure').value = 'mixed';
            
            document.getElementById('hasAC').checked = true;
            document.getElementById('hasHeating').checked = false;
            document.getElementById('hasComputers').checked = false;
            document.getElementById('hasPeople').checked = false;
            
            resultsSection.style.display = 'none';
        }

        // Initialize calculator
        document.addEventListener('DOMContentLoaded', function() {
            // Add input validation
            const numberInputs = document.querySelectorAll('input[type="number"]');
            numberInputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value < 0) this.value = 0;
                });
            });
        });
    </script>
</body>
</html>
