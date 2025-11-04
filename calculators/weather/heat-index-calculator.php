<?php
/**
 * Heat Index Calculator
 * File: weather/heat-index-calculator.php
 * Description: Advanced heat index calculator with safety recommendations and risk analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heat Index Calculator - Advanced Temperature & Humidity Analysis</title>
    <meta name="description" content="Calculate heat index (feels-like temperature) with safety recommendations, risk analysis, and protective measures for hot weather conditions.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin-bottom: 30px; }
        
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input, .input-wrapper select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus { outline: none; border-color: #ff6b6b; box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1); }
        .unit { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #7f8c8d; font-weight: 600; }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .checkbox-group input[type="checkbox"] { width: 18px; height: 18px; }
        
        .calculate-btn { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); color: white; border: none; padding: 16px 32px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin: 20px 0; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3); }
        
        .results-section { margin-top: 30px; }
        .results-section h3 { color: #2c3e50; margin-bottom: 20px; font-size: 1.3rem; }
        
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .result-card { background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); padding: 25px; border-radius: 12px; border-left: 4px solid #ff6b6b; text-align: center; }
        .result-label { color: #c62828; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-value { font-size: 1.5rem; font-weight: bold; color: #d32f2f; margin-bottom: 5px; }
        .result-unit { color: #e53935; font-size: 0.9rem; }
        
        .risk-indicator { margin: 25px 0; padding: 20px; border-radius: 12px; text-align: center; transition: all 0.3s; }
        .risk-level { font-size: 1.4rem; font-weight: bold; margin-bottom: 10px; }
        .risk-description { font-size: 1rem; line-height: 1.5; }
        
        .safety-recommendations { background: #fff3e0; padding: 25px; border-radius: 12px; border-left: 4px solid #ff9800; margin: 25px 0; }
        .safety-recommendations h4 { color: #ef6c00; margin-bottom: 15px; font-size: 1.1rem; }
        .recommendation-list { list-style: none; }
        .recommendation-list li { padding: 10px 0; color: #555; position: relative; padding-left: 30px; border-bottom: 1px solid #ffe0b2; }
        .recommendation-list li:last-child { border-bottom: none; }
        .recommendation-list li:before { content: "⚠️"; position: absolute; left: 0; top: 10px; }
        
        .comparison-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .comparison-table th, .comparison-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .comparison-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .comparison-table tr:hover { background: #f5f5f5; }
        
        .action-buttons { display: flex; gap: 12px; margin-top: 20px; flex-wrap: wrap; }
        .action-btn { padding: 12px 20px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; }
        .action-btn:hover { border-color: #ff6b6b; background: #fff5f5; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .formula-box { background: #fff3e0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff9800; }
        .formula-box strong { color: #ef6c00; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        /* Risk level colors */
        .risk-caution { background: #fff3cd; border: 2px solid #ffeaa7; color: #856404; }
        .risk-extreme-caution { background: #ffeaa7; border: 2px solid #fdcb6e; color: #856404; }
        .risk-danger { background: #f8d7da; border: 2px solid #f1aeb5; color: #721c24; }
        .risk-extreme-danger { background: #f5c6cb; border: 2px solid #e9aeb4; color: #721c24; }
        
        /* Heat visualization */
        .heat-visualization { width: 100%; height: 120px; background: linear-gradient(90deg, #74b9ff, #ff6b6b, #c23616); border-radius: 8px; margin: 20px 0; position: relative; }
        .heat-marker { position: absolute; top: -25px; width: 2px; height: 140px; background: #2c3e50; }
        .heat-marker:after { content: attr(data-value); position: absolute; top: -20px; left: -15px; background: #2c3e50; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem; }
        
        @media (max-width: 768px) {
            .input-grid { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { flex-direction: column; }
        }
        
        /* Gauge styles */
        .risk-gauge { width: 200px; height: 200px; margin: 0 auto; position: relative; }
        .gauge-background { width: 100%; height: 100%; border-radius: 50%; background: conic-gradient(#74b9ff 0%, #ffeaa7 25%, #fdcb6e 50%, #f1aeb5 75%, #e9aeb4 100%); }
        .gauge-needle { position: absolute; top: 50%; left: 50%; width: 2px; height: 90px; background: #2c3e50; transform-origin: bottom center; transition: transform 0.5s ease; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌡️ Heat Index Calculator</h1>
            <p>Calculate feels-like temperature and heat-related health risks with safety recommendations</p>
        </div>

        <div class="calculator-card">
            <div class="input-grid">
                <div class="input-group">
                    <label for="temperature">Temperature</label>
                    <div class="input-wrapper">
                        <input type="number" id="temperature" placeholder="Enter temperature" value="90" step="0.1" min="-50" max="150">
                        <span class="unit">°F</span>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="humidity">Relative Humidity</label>
                    <div class="input-wrapper">
                        <input type="number" id="humidity" placeholder="Enter humidity" value="60" step="1" min="0" max="100">
                        <span class="unit">%</span>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="activityLevel">Activity Level</label>
                    <div class="input-wrapper">
                        <select id="activityLevel">
                            <option value="resting">Resting (Seated)</option>
                            <option value="light" selected>Light Activity (Walking)</option>
                            <option value="moderate">Moderate Activity</option>
                            <option value="heavy">Heavy Activity</option>
                            <option value="intense">Intense Exercise</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="sunExposure">Sun Exposure</label>
                    <div class="input-wrapper">
                        <select id="sunExposure">
                            <option value="shade">Full Shade</option>
                            <option value="partial">Partial Sun</option>
                            <option value="full" selected>Full Sun</option>
                            <option value="reflective">Reflective Surface</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="input-grid">
                <div class="input-group">
                    <label for="windSpeed">Wind Speed</label>
                    <div class="input-wrapper">
                        <input type="number" id="windSpeed" placeholder="Enter wind speed" value="5" step="0.1" min="0" max="100">
                        <span class="unit">mph</span>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="acclimation">Heat Acclimation</label>
                    <div class="input-wrapper">
                        <select id="acclimation">
                            <option value="unacclimated">Not Acclimated</option>
                            <option value="partially">Partially Acclimated</option>
                            <option value="acclimated" selected>Fully Acclimated</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="ageGroup">Age Group</label>
                    <div class="input-wrapper">
                        <select id="ageGroup">
                            <option value="child">Child (Under 12)</option>
                            <option value="teen">Teen (13-17)</option>
                            <option value="adult" selected>Adult (18-64)</option>
                            <option value="senior">Senior (65+)</option>
                        </select>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="healthCondition">Health Condition</label>
                    <div class="input-wrapper">
                        <select id="healthCondition">
                            <option value="excellent">Excellent</option>
                            <option value="good" selected>Good</option>
                            <option value="fair">Fair</option>
                            <option value="poor">Poor</option>
                            <option value="chronic">Chronic Condition</option>
                        </select>
                    </div>
                </div>
            </div>

            <h4 style="color: #2c3e50; margin: 20px 0 15px 0;">Additional Factors</h4>
            <div class="input-grid">
                <div class="checkbox-group">
                    <input type="checkbox" id="directSun" checked>
                    <label for="directSun">Direct sunlight exposure</label>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="hydration">
                    <label for="hydration">Adequately hydrated</label>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="protectiveClothing">
                    <label for="protectiveClothing">Wearing protective clothing</label>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="medicalCondition">
                    <label for="medicalCondition">Pre-existing medical condition</label>
                </div>
            </div>

            <button class="calculate-btn" onclick="calculateHeatIndex()">🌡️ Calculate Heat Index</button>

            <div class="results-section" id="resultsSection" style="display: none;">
                <h3>📊 Heat Index Analysis</h3>
                
                <div class="results-grid">
                    <div class="result-card">
                        <div class="result-label">Heat Index</div>
                        <div class="result-value" id="heatIndex">0</div>
                        <div class="result-unit">°F (Feels Like)</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Risk Level</div>
                        <div class="result-value" id="riskLevel">-</div>
                        <div class="result-unit" id="riskCategory"></div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Dew Point</div>
                        <div class="result-value" id="dewPoint">0</div>
                        <div class="result-unit">°F</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Humidex</div>
                        <div class="result-value" id="humidex">0</div>
                        <div class="result-unit">Index</div>
                    </div>
                </div>

                <div class="risk-indicator" id="riskIndicator">
                    <div class="risk-level" id="riskTitle">-</div>
                    <div class="risk-description" id="riskDescription">-</div>
                </div>

                <div class="heat-visualization" id="heatVisualization">
                    <!-- Heat marker will be positioned here -->
                </div>

                <div class="safety-recommendations">
                    <h4>🛡️ Safety Recommendations</h4>
                    <ul class="recommendation-list" id="safetyList">
                        <!-- Safety recommendations will be populated here -->
                    </ul>
                </div>

                <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; margin: 20px 0;">
                    <h4 style="color: #2c3e50; margin-bottom: 15px;">📈 Risk Timeline</h4>
                    <table class="comparison-table">
                        <thead>
                            <tr>
                                <th>Time Exposure</th>
                                <th>Risk Level</th>
                                <th>Recommended Action</th>
                                <th>Water Intake</th>
                            </tr>
                        </thead>
                        <tbody id="timelineTable">
                            <!-- Timeline data will be populated here -->
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
                        📤 Share Alert
                    </button>
                    <button class="action-btn" onclick="resetCalculator()">
                        🔄 Reset Calculator
                    </button>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🌡️ Understanding Heat Index</h2>
            
            <p>The Heat Index is a measure of how hot it really feels when relative humidity is factored in with the actual air temperature. It's also known as the "apparent temperature" or "feels-like" temperature.</p>

            <h3>📊 Heat Index Risk Categories</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Heat Index</th>
                        <th>Risk Level</th>
                        <th>Health Effects</th>
                        <th>Precautions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>80°F - 90°F</td>
                        <td style="color: #27ae60;">Caution</td>
                        <td>Fatigue possible</td>
                        <td>Stay hydrated</td>
                    </tr>
                    <tr>
                        <td>91°F - 103°F</td>
                        <td style="color: #f39c12;">Extreme Caution</td>
                        <td>Heat cramps, exhaustion</td>
                        <td>Limit outdoor activity</td>
                    </tr>
                    <tr>
                        <td>104°F - 124°F</td>
                        <td style="color: #e74c3c;">Danger</td>
                        <td>Heat cramps, exhaustion likely</td>
                        <td>Avoid strenuous activity</td>
                    </tr>
                    <tr>
                        <td>125°F+</td>
                        <td style="color: #c0392b;">Extreme Danger</td>
                        <td>Heat stroke imminent</td>
                        <td>Seek air conditioning</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Heat Index Formula (Rothfusz regression):</strong><br>
                HI = -42.379 + 2.04901523×T + 10.14333127×RH - 0.22475541×T×RH - 6.83783×10⁻³×T² - 5.481717×10⁻²×RH² + 1.22874×10⁻³×T²×RH + 8.5282×10⁻⁴×T×RH² - 1.99×10⁻⁶×T²×RH²
            </div>

            <h3>🎯 Factors Affecting Heat Perception</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Factor</th>
                        <th>Impact</th>
                        <th>Adjustment Range</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Wind Speed</strong></td>
                        <td>Increased evaporation cooling</td>
                        <td>-2°F to -10°F</td>
                    </tr>
                    <tr>
                        <td><strong>Sun Exposure</strong></td>
                        <td>Direct radiation increases felt temperature</td>
                        <td>+8°F to +15°F</td>
                    </tr>
                    <tr>
                        <td><strong>Activity Level</strong></td>
                        <td>Metabolic heat production</td>
                        <td>+5°F to +20°F</td>
                    </tr>
                    <tr>
                        <td><strong>Acclimation</strong></td>
                        <td>Body adaptation to heat</td>
                        <td>-3°F to -8°F perceived</td>
                    </tr>
                    <tr>
                        <td><strong>Clothing</strong></td>
                        <td>Affects heat retention and evaporation</td>
                        <td>±5°F to ±15°F</td>
                    </tr>
                    <tr>
                        <td><strong>Hydration</strong></td>
                        <td>Affects body's cooling ability</td>
                        <td>Critical for safety</td>
                    </tr>
                </tbody>
            </table>

            <h3>🩺 Health Risk Factors</h3>
            <div class="formula-box">
                <strong>High-Risk Groups:</strong><br>
                • <strong>Children:</strong> Underdeveloped thermoregulation<br>
                • <strong>Seniors:</strong> Reduced sweating capacity<br>
                • <strong>Chronic Illness:</strong> Heart, lung, kidney conditions<br>
                • <strong>Obesity:</strong> Reduced heat dissipation<br>
                • <strong>Medications:</strong> Diuretics, beta-blockers, antihistamines<br>
                • <strong>Dehydration:</strong> Impaired cooling mechanism
            </div>

            <h3>🚨 Heat-Related Illnesses</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Illness</th>
                        <th>Symptoms</th>
                        <th>First Aid</th>
                        <th>Medical Attention</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Heat Cramps</strong></td>
                        <td>Muscle pains, spasms</td>
                        <td>Rest, electrolyte drinks</td>
                        <td>If severe or prolonged</td>
                    </tr>
                    <tr>
                        <td><strong>Heat Exhaustion</strong></td>
                        <td>Heavy sweating, weakness, nausea</td>
                        <td>Cool environment, hydration</td>
                        <td>If symptoms worsen</td>
                    </tr>
                    <tr>
                        <td><strong>Heat Stroke</strong></td>
                        <td>No sweating, confusion, high temperature</td>
                        <td>Emergency cooling, call 911</td>
                        <td>Immediate emergency</td>
                    </tr>
                </tbody>
            </table>

            <h3>💧 Hydration Guidelines</h3>
            <ul>
                <li><strong>Before activity:</strong> 16-20 oz of water 2-3 hours prior</li>
                <li><strong>During activity:</strong> 7-10 oz every 10-20 minutes</li>
                <li><strong>After activity:</strong> 16-24 oz for every pound lost</li>
                <li><strong>Electrolytes:</strong> Needed for activities over 1 hour</li>
                <li><strong>Monitoring:</strong> Clear urine indicates good hydration</li>
            </ul>

            <h3>🏠 Cooling Strategies</h3>
            <div class="formula-box">
                <strong>Effective Cooling Methods:</strong><br>
                • <strong>Air Conditioning:</strong> Most effective for heat illness prevention<br>
                • <strong>Fans:</strong> Helpful below 95°F, dangerous above<br>
                • <strong>Cool Showers:</strong> Immediate temperature reduction<br>
                • <strong>Hydration:</strong> Internal cooling mechanism<br>
                • <strong>Light Clothing:</strong> Light colors, loose fit, moisture-wicking<br>
                • <strong>Schedule:</strong> Avoid peak heat hours (10 AM - 4 PM)
            </div>

            <h3>📱 Monitoring and Prevention</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Prevention Method</th>
                        <th>Effectiveness</th>
                        <th>Implementation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Weather Monitoring</strong></td>
                        <td>High</td>
                        <td>Check heat index regularly</td>
                    </tr>
                    <tr>
                        <td><strong>Work/Rest Cycles</strong></td>
                        <td>High</td>
                        <td>Frequent breaks in shade/AC</td>
                    </tr>
                    <tr>
                        <td><strong>Acclimation Program</strong></td>
                        <td>Medium-High</td>
                        <td>Gradual exposure over 7-14 days</td>
                    </tr>
                    <tr>
                        <td><strong>Buddy System</strong></td>
                        <td>High</td>
                        <td>Monitor each other for symptoms</td>
                    </tr>
                </tbody>
            </table>

            <h3>⚠️ Emergency Response</h3>
            <ul>
                <li><strong>Call 911 immediately for heat stroke</strong></li>
                <li>Move person to cool environment</li>
                <li>Remove excess clothing</li>
                <li>Cool with water, ice packs, or wet sheets</li>
                <li>Do not give fluids if unconscious</li>
                <li>Monitor breathing and consciousness</li>
            </ul>
        </div>

        <div class="footer">
            <p>🌡️ Advanced Heat Index Calculator | Safety Recommendations & Risk Analysis</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Heat illness prevention, hydration guidelines, and emergency response procedures</p>
        </div>
    </div>

    <script>
        // DOM elements
        const resultsSection = document.getElementById('resultsSection');
        const heatVisualization = document.getElementById('heatVisualization');

        // Calculate Heat Index
        function calculateHeatIndex() {
            // Get input values
            const temperature = parseFloat(document.getElementById('temperature').value) || 0;
            const humidity = parseFloat(document.getElementById('humidity').value) || 0;
            const activityLevel = document.getElementById('activityLevel').value;
            const sunExposure = document.getElementById('sunExposure').value;
            const windSpeed = parseFloat(document.getElementById('windSpeed').value) || 0;
            const acclimation = document.getElementById('acclimation').value;
            const ageGroup = document.getElementById('ageGroup').value;
            const healthCondition = document.getElementById('healthCondition').value;
            
            // Calculate base heat index using Rothfusz formula
            const baseHeatIndex = calculateBaseHeatIndex(temperature, humidity);
            
            // Apply adjustments based on additional factors
            const adjustedHeatIndex = applyAdjustments(baseHeatIndex, {
                activityLevel,
                sunExposure,
                windSpeed,
                acclimation,
                ageGroup,
                healthCondition,
                directSun: document.getElementById('directSun').checked,
                hydration: document.getElementById('hydration').checked,
                protectiveClothing: document.getElementById('protectiveClothing').checked,
                medicalCondition: document.getElementById('medicalCondition').checked
            });
            
            // Calculate dew point
            const dewPoint = calculateDewPoint(temperature, humidity);
            
            // Calculate humidex
            const humidex = calculateHumidex(temperature, humidity);
            
            // Determine risk level
            const riskAnalysis = analyzeRisk(adjustedHeatIndex, ageGroup, healthCondition);
            
            // Update results
            document.getElementById('heatIndex').textContent = Math.round(adjustedHeatIndex);
            document.getElementById('dewPoint').textContent = Math.round(dewPoint);
            document.getElementById('humidex').textContent = Math.round(humidex);
            document.getElementById('riskLevel').textContent = riskAnalysis.level;
            document.getElementById('riskCategory').textContent = riskAnalysis.category;
            
            // Update risk indicator
            updateRiskIndicator(riskAnalysis);
            
            // Update heat visualization
            updateHeatVisualization(adjustedHeatIndex);
            
            // Generate safety recommendations
            generateSafetyRecommendations(riskAnalysis, adjustedHeatIndex, activityLevel);
            
            // Generate timeline
            generateTimeline(adjustedHeatIndex, activityLevel);
            
            // Show results section
            resultsSection.style.display = 'block';
            
            // Scroll to results
            resultsSection.scrollIntoView({ behavior: 'smooth' });
        }

        // Calculate base heat index using Rothfusz regression
        function calculateBaseHeatIndex(T, RH) {
            // Simplified Rothfusz formula
            const HI = -42.379 + 
                      2.04901523 * T + 
                      10.14333127 * RH - 
                      0.22475541 * T * RH - 
                      0.00683783 * T * T - 
                      0.05481717 * RH * RH + 
                      0.00122874 * T * T * RH + 
                      0.00085282 * T * RH * RH - 
                      0.00000199 * T * T * RH * RH;
            
            return HI;
        }

        // Apply adjustments based on environmental and personal factors
        function applyAdjustments(baseHI, factors) {
            let adjustedHI = baseHI;
            
            // Activity level adjustments
            const activityAdjustments = {
                'resting': 0,
                'light': 5,
                'moderate': 10,
                'heavy': 15,
                'intense': 20
            };
            adjustedHI += activityAdjustments[factors.activityLevel];
            
            // Sun exposure adjustments
            const sunAdjustments = {
                'shade': -5,
                'partial': 0,
                'full': 8,
                'reflective': 12
            };
            adjustedHI += sunAdjustments[factors.sunExposure];
            
            // Wind speed cooling effect (diminishing returns)
            if (factors.windSpeed > 0) {
                const windCooling = Math.min(factors.windSpeed * 0.5, 10);
                adjustedHI -= windCooling;
            }
            
            // Acclimation adjustments
            const acclimationAdjustments = {
                'unacclimated': 5,
                'partially': 2,
                'acclimated': 0
            };
            adjustedHI += acclimationAdjustments[factors.acclimation];
            
            // Age group vulnerability
            const ageAdjustments = {
                'child': 3,
                'teen': 1,
                'adult': 0,
                'senior': 4
            };
            adjustedHI += ageAdjustments[factors.ageGroup];
            
            // Health condition adjustments
            const healthAdjustments = {
                'excellent': -2,
                'good': 0,
                'fair': 3,
                'poor': 6,
                'chronic': 8
            };
            adjustedHI += healthAdjustments[factors.healthCondition];
            
            // Additional factor adjustments
            if (factors.directSun) adjustedHI += 3;
            if (factors.hydration) adjustedHI -= 2;
            if (factors.protectiveClothing) adjustedHI -= 4;
            if (factors.medicalCondition) adjustedHI += 5;
            
            return Math.max(adjustedHI, baseHI * 0.8); // Minimum 80% of base
        }

        // Calculate dew point
        function calculateDewPoint(T, RH) {
            const a = 17.27;
            const b = 237.7;
            const alpha = ((a * T) / (b + T)) + Math.log(RH / 100);
            return (b * alpha) / (a - alpha);
        }

        // Calculate humidex (Canadian heat index)
        function calculateHumidex(T, RH) {
            const dewPoint = calculateDewPoint(T, RH);
            return T + 0.5555 * (6.11 * Math.exp(5417.7530 * ((1/273.16) - (1/(dewPoint + 273.15)))) - 10);
        }

        // Analyze risk level based on heat index and personal factors
        function analyzeRisk(heatIndex, ageGroup, healthCondition) {
            let riskLevel, riskCategory, description;
            
            if (heatIndex < 80) {
                riskLevel = "Low";
                riskCategory = "Comfortable";
                description = "Generally comfortable conditions";
            } else if (heatIndex < 91) {
                riskLevel = "Caution";
                riskCategory = "Moderate Risk";
                description = "Fatigue possible with prolonged exposure";
            } else if (heatIndex < 103) {
                riskLevel = "Extreme Caution";
                riskCategory = "High Risk";
                description = "Heat cramps and exhaustion possible";
            } else if (heatIndex < 125) {
                riskLevel = "Danger";
                riskCategory = "Very High Risk";
                description = "Heat cramps and exhaustion likely, heat stroke possible";
            } else {
                riskLevel = "Extreme Danger";
                riskCategory = "Emergency";
                description = "Heat stroke highly likely";
            }
            
            // Adjust for vulnerable groups
            if ((ageGroup === 'child' || ageGroup === 'senior' || healthCondition === 'poor' || healthCondition === 'chronic') && heatIndex >= 90) {
                riskLevel += " (Vulnerable)";
                description += " - Higher risk for vulnerable individuals";
            }
            
            return {
                level: riskLevel,
                category: riskCategory,
                description: description,
                numeric: heatIndex
            };
        }

        // Update risk indicator with appropriate styling
        function updateRiskIndicator(riskAnalysis) {
            const indicator = document.getElementById('riskIndicator');
            const title = document.getElementById('riskTitle');
            const description = document.getElementById('riskDescription');
            
            // Clear previous classes
            indicator.className = 'risk-indicator';
            
            // Apply appropriate styling based on risk level
            if (riskAnalysis.level.includes('Low')) {
                indicator.classList.add('risk-caution');
            } else if (riskAnalysis.level.includes('Caution')) {
                indicator.classList.add('risk-extreme-caution');
            } else if (riskAnalysis.level.includes('Danger')) {
                indicator.classList.add('risk-danger');
            } else if (riskAnalysis.level.includes('Extreme Danger')) {
                indicator.classList.add('risk-extreme-danger');
            }
            
            title.textContent = riskAnalysis.level;
            description.textContent = riskAnalysis.description;
        }

        // Update heat visualization
        function updateHeatVisualization(heatIndex) {
            heatVisualization.innerHTML = '';
            
            // Create heat scale marker
            const marker = document.createElement('div');
            marker.className = 'heat-marker';
            marker.setAttribute('data-value', Math.round(heatIndex) + '°F');
            
            // Position marker on scale (50°F to 130°F range)
            const minTemp = 50;
            const maxTemp = 130;
            const position = ((heatIndex - minTemp) / (maxTemp - minTemp)) * 100;
            marker.style.left = Math.min(Math.max(position, 0), 100) + '%';
            
            heatVisualization.appendChild(marker);
        }

        // Generate safety recommendations
        function generateSafetyRecommendations(riskAnalysis, heatIndex, activityLevel) {
            const safetyList = document.getElementById('safetyList');
            safetyList.innerHTML = '';
            
            const recommendations = [];
            
            // Base recommendations based on risk level
            if (heatIndex >= 80) {
                recommendations.push("Drink plenty of water - at least 8 oz every 20 minutes during activity");
            }
            
            if (heatIndex >= 90) {
                recommendations.push("Take frequent breaks in shaded or air-conditioned areas");
                recommendations.push("Wear light-colored, loose-fitting clothing");
            }
            
            if (heatIndex >= 103) {
                recommendations.push("Limit outdoor activity to essential tasks only");
                recommendations.push("Schedule strenuous work for cooler morning or evening hours");
            }
            
            if (heatIndex >= 125) {
                recommendations.push("Seek air-conditioned environments immediately");
                recommendations.push("Cancel all non-essential outdoor activities");
            }
            
            // Activity-specific recommendations
            if (activityLevel === 'heavy' || activityLevel === 'intense') {
                recommendations.push("Increase water intake to 10-12 oz every 20 minutes");
                recommendations.push("Implement work/rest cycles (45 min work, 15 min rest)");
            }
            
            // Additional general recommendations
            recommendations.push("Monitor yourself and others for signs of heat illness");
            recommendations.push("Avoid alcohol and caffeine as they can dehydrate you");
            recommendations.push("Use sunscreen to prevent sunburn which affects cooling");
            
            // Add recommendations to list
            recommendations.forEach(rec => {
                const li = document.createElement('li');
                li.textContent = rec;
                safetyList.appendChild(li);
            });
        }

        // Generate risk timeline
        function generateTimeline(heatIndex, activityLevel) {
            const timelineTable = document.getElementById('timelineTable');
            timelineTable.innerHTML = '';
            
            const timelines = [
                { time: '30 minutes', risk: getTimelineRisk(heatIndex, 0.5), action: getTimelineAction(heatIndex, 0.5), water: '8-12 oz' },
                { time: '1 hour', risk: getTimelineRisk(heatIndex, 1), action: getTimelineAction(heatIndex, 1), water: '16-24 oz' },
                { time: '2 hours', risk: getTimelineRisk(heatIndex, 2), action: getTimelineAction(heatIndex, 2), water: '32-48 oz' },
                { time: '4 hours', risk: getTimelineRisk(heatIndex, 4), action: getTimelineAction(heatIndex, 4), water: '64-96 oz + electrolytes' }
            ];
            
            timelines.forEach(timeline => {
                const tr = document.createElement('tr');
                
                const timeTd = document.createElement('td');
                timeTd.textContent = timeline.time;
                tr.appendChild(timeTd);
                
                const riskTd = document.createElement('td');
                riskTd.textContent = timeline.risk;
                riskTd.style.color = getRiskColor(timeline.risk);
                tr.appendChild(riskTd);
                
                const actionTd = document.createElement('td');
                actionTd.textContent = timeline.action;
                tr.appendChild(actionTd);
                
                const waterTd = document.createElement('td');
                waterTd.textContent = timeline.water;
                tr.appendChild(waterTd);
                
                timelineTable.appendChild(tr);
            });
        }

        // Helper functions for timeline
        function getTimelineRisk(heatIndex, hours) {
            const adjustedRisk = heatIndex + (hours * 2); // Risk increases with exposure time
            if (adjustedRisk < 90) return 'Low';
            if (adjustedRisk < 103) return 'Moderate';
            if (adjustedRisk < 125) return 'High';
            return 'Extreme';
        }

        function getTimelineAction(heatIndex, hours) {
            const adjustedRisk = heatIndex + (hours * 2);
            if (adjustedRisk < 90) return 'Normal activity';
            if (adjustedRisk < 103) return 'Take breaks every hour';
            if (adjustedRisk < 125) return 'Limit to 30 min sessions';
            return 'Avoid exposure';
        }

        function getRiskColor(risk) {
            switch(risk) {
                case 'Low': return '#27ae60';
                case 'Moderate': return '#f39c12';
                case 'High': return '#e74c3c';
                case 'Extreme': return '#c0392b';
                default: return '#7f8c8d';
            }
        }

        // Action functions
        function saveCalculation() {
            const data = {
                heatIndex: document.getElementById('heatIndex').textContent,
                riskLevel: document.getElementById('riskLevel').textContent,
                timestamp: new Date().toLocaleString()
            };
            localStorage.setItem('heatIndexCalculation', JSON.stringify(data));
            alert('Calculation saved successfully!');
        }

        function printResults() {
            window.print();
        }

        function shareResults() {
            const heatIndex = document.getElementById('heatIndex').textContent;
            const riskLevel = document.getElementById('riskLevel').textContent;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Heat Index Alert',
                    text: `Current heat index: ${heatIndex}°F - Risk Level: ${riskLevel}`,
                    url: window.location.href
                });
            } else {
                alert('Share functionality not available in this browser. Results copied to clipboard.');
                navigator.clipboard.writeText(`Heat Index Alert: ${heatIndex}°F - ${riskLevel} Risk`);
            }
        }

        function resetCalculator() {
            document.getElementById('temperature').value = '90';
            document.getElementById('humidity').value = '60';
            document.getElementById('activityLevel').value = 'light';
            document.getElementById('sunExposure').value = 'full';
            document.getElementById('windSpeed').value = '5';
            document.getElementById('acclimation').value = 'acclimated';
            document.getElementById('ageGroup').value = 'adult';
            document.getElementById('healthCondition').value = 'good';
            
            document.getElementById('directSun').checked = true;
            document.getElementById('hydration').checked = false;
            document.getElementById('protectiveClothing').checked = false;
            document.getElementById('medicalCondition').checked = false;
            
            resultsSection.style.display = 'none';
        }

        // Initialize calculator with example values
        document.addEventListener('DOMContentLoaded', function() {
            // Add input validation
            const numberInputs = document.querySelectorAll('input[type="number"]');
            numberInputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.id === 'humidity' && this.value > 100) this.value = 100;
                    if (this.id === 'humidity' && this.value < 0) this.value = 0;
                });
            });
            
            // Calculate on page load with default values
            calculateHeatIndex();
        });
    </script>
</body>
</html>
