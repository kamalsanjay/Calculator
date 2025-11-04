<?php
/**
 * Wind Chill Calculator
 * File: weather/wind-chill-calculator.php
 * Description: Calculate wind chill temperature and understand cold weather risks
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wind Chill Calculator - Temperature & Wind Speed Analysis</title>
    <meta name="description" content="Calculate wind chill temperature from air temperature and wind speed. Understand cold weather risks and safety precautions.">
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
        
        .calculate-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 16px 30px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin: 20px 0; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        
        .results-section { margin-top: 30px; }
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        
        .result-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; text-align: center; }
        .result-label { color: #4527a0; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-value { font-size: 1.4rem; font-weight: bold; color: #5e35b1; }
        .result-unit { color: #7e57c2; font-size: 0.9rem; margin-top: 5px; }
        
        .risk-assessment { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .risk-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .risk-header h3 { color: #2c3e50; font-size: 1.1rem; }
        
        .risk-level { display: flex; align-items: center; gap: 15px; padding: 20px; background: white; border-radius: 10px; margin-bottom: 20px; }
        .risk-icon { font-size: 2.5rem; }
        .risk-text { flex: 1; }
        .risk-title { font-weight: 600; color: #2c3e50; margin-bottom: 5px; font-size: 1.2rem; }
        .risk-desc { color: #7f8c8d; font-size: 0.9rem; line-height: 1.5; }
        
        .safety-tips { background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #e74c3c; }
        .safety-tips h4 { color: #c0392b; margin-bottom: 15px; }
        .safety-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 10px; }
        .safety-item { display: flex; align-items: start; gap: 10px; margin-bottom: 10px; }
        .safety-bullet { color: #e74c3c; font-weight: bold; min-width: 20px; }
        
        .wind-chill-chart { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .chart-container { overflow-x: auto; }
        .chart-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        .chart-table th, .chart-table td { padding: 10px; text-align: center; border: 1px solid #e0e0e0; }
        .chart-table th { background: #667eea; color: white; font-weight: 600; }
        .chart-table tr:nth-child(even) { background: #f8f9fa; }
        
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
        
        .weather-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin: 20px 0; }
        .weather-card { background: #ede7f6; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; }
        .weather-card h4 { color: #4527a0; margin-bottom: 10px; }
        
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
            .risk-level { flex-direction: column; text-align: center; }
            .safety-list { grid-template-columns: 1fr; }
            .scenarios-grid { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (max-width: 480px) {
            .results-grid { grid-template-columns: 1fr; }
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
            <h1>💨 Wind Chill Calculator</h1>
            <p>Calculate wind chill temperature and understand cold weather risks based on temperature and wind speed</p>
        </div>

        <div class="calculator-card">
            <div class="input-sections">
                <div class="input-group">
                    <h3>🌡️ Temperature Input</h3>
                    <div class="input-row">
                        <div class="input-wrapper">
                            <label for="temperature">Air Temperature</label>
                            <input type="number" id="temperature" class="input-field" placeholder="Enter temperature" value="0" step="0.1">
                        </div>
                        <div class="input-wrapper">
                            <label for="tempUnit">Unit</label>
                            <select id="tempUnit" class="unit-select">
                                <option value="c" selected>°C</option>
                                <option value="f">°F</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <h3>💨 Wind Speed Input</h3>
                    <div class="input-row">
                        <div class="input-wrapper">
                            <label for="windSpeed">Wind Speed</label>
                            <input type="number" id="windSpeed" class="input-field" placeholder="Enter wind speed" value="15" min="0" step="0.1">
                        </div>
                        <div class="input-wrapper">
                            <label for="windUnit">Unit</label>
                            <select id="windUnit" class="unit-select">
                                <option value="kph" selected>km/h</option>
                                <option value="mph">mph</option>
                                <option value="mps">m/s</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <button class="calculate-btn" id="calculateButton">Calculate Wind Chill</button>

            <div class="results-section">
                <div class="results-grid">
                    <div class="result-card">
                        <div class="result-label">Wind Chill Temperature</div>
                        <div class="result-value" id="windChillValue">-3.6</div>
                        <div class="result-unit" id="windChillUnit">°C</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Feels Like</div>
                        <div class="result-value" id="feelsLikeValue">Much Colder</div>
                        <div class="result-unit">Perception</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Frostbite Risk</div>
                        <div class="result-value" id="frostbiteRisk">Low</div>
                        <div class="result-unit">30+ minutes</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Heat Loss Rate</div>
                        <div class="result-value" id="heatLossRate">2.3x</div>
                        <div class="result-unit">Normal rate</div>
                    </div>
                </div>

                <div class="risk-assessment">
                    <div class="risk-header">
                        <h3>⚠️ Risk Assessment & Safety</h3>
                    </div>
                    <div class="risk-level">
                        <div class="risk-icon" id="riskIcon">😊</div>
                        <div class="risk-text">
                            <div class="risk-title" id="riskTitle">Low Risk</div>
                            <div class="risk-desc" id="riskDesc">Generally safe conditions with minimal risk of cold-related injuries. Normal outdoor activities are safe with appropriate clothing.</div>
                        </div>
                    </div>
                    
                    <div class="safety-tips">
                        <h4>🧤 Safety Recommendations</h4>
                        <div class="safety-list" id="safetyTips">
                            <div class="safety-item">
                                <span class="safety-bullet">•</span>
                                <span>Wear layers of warm clothing</span>
                            </div>
                            <div class="safety-item">
                                <span class="safety-bullet">•</span>
                                <span>Protect exposed skin from wind</span>
                            </div>
                            <div class="safety-item">
                                <span class="safety-bullet">•</span>
                                <span>Stay dry and avoid sweating</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wind-chill-chart">
                    <h3>📊 Wind Chill Reference Chart (°C)</h3>
                    <div class="chart-container">
                        <table class="chart-table">
                            <thead>
                                <tr>
                                    <th>Wind Speed (km/h)</th>
                                    <th>5°C</th>
                                    <th>0°C</th>
                                    <th>-5°C</th>
                                    <th>-10°C</th>
                                    <th>-15°C</th>
                                    <th>-20°C</th>
                                </tr>
                            </thead>
                            <tbody id="windChillChart">
                                <!-- Chart will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="quick-scenarios">
                <h3>⚡ Common Weather Scenarios</h3>
                <div class="scenarios-grid">
                    <div class="scenario-btn" onclick="setScenario(5, 20)">
                        <div class="scenario-value">5°C, 20 km/h</div>
                        <div class="scenario-label">Chilly Breeze</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(-5, 30)">
                        <div class="scenario-value">-5°C, 30 km/h</div>
                        <div class="scenario-label">Cold Wind</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(-15, 40)">
                        <div class="scenario-value">-15°C, 40 km/h</div>
                        <div class="scenario-label">Very Cold</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(-25, 25)">
                        <div class="scenario-value">-25°C, 25 km/h</div>
                        <div class="scenario-label">Extreme Cold</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(10, 35)">
                        <div class="scenario-value">10°C, 35 km/h</div>
                        <div class="scenario-label">Windy Day</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(-30, 50)">
                        <div class="scenario-value">-30°C, 50 km/h</div>
                        <div class="scenario-label">Arctic Conditions</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>💨 Understanding Wind Chill</h2>
            
            <p>Wind chill is the perceived decrease in air temperature felt by the body on exposed skin due to the flow of air. It's based on the rate of heat loss from exposed skin caused by wind and cold.</p>

            <div class="weather-grid">
                <div class="weather-card">
                    <h4>🌡️ What is Wind Chill?</h4>
                    <p>Wind chill describes how cold it feels when wind is factored in with the actual air temperature. It's not the actual temperature, but rather how cold it feels to humans and animals.</p>
                </div>
                <div class="weather-card">
                    <h4>💨 How Wind Increases Cold</h4>
                    <p>Wind removes the thin layer of warm air that surrounds your body, accelerating heat loss and making you feel colder than the actual air temperature.</p>
                </div>
                <div class="weather-card">
                    <h4>🔬 The Science Behind It</h4>
                    <p>Wind chill is calculated based on heat transfer theory, specifically convective heat loss from exposed skin to the surrounding air.</p>
                </div>
            </div>

            <h3>📊 Wind Chill Risk Categories</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Wind Chill Range</th>
                        <th>Risk Level</th>
                        <th>Frostbite Time</th>
                        <th>Recommended Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>0 to -10°C (32 to 14°F)</td>
                        <td>Low</td>
                        <td>30+ minutes</td>
                        <td>Dress warmly, cover exposed skin</td>
                    </tr>
                    <tr>
                        <td>-10 to -28°C (14 to -18°F)</td>
                        <td>Moderate</td>
                        <td>10-30 minutes</td>
                        <td>Wear layers, limit outdoor time</td>
                    </tr>
                    <tr>
                        <td>-28 to -40°C (-18 to -40°F)</td>
                        <td>High</td>
                        <td>5-10 minutes</td>
                        <td>Cover all skin, minimize exposure</td>
                    </tr>
                    <tr>
                        <td>-40 to -48°C (-40 to -54°F)</td>
                        <td>Very High</td>
                        <td>2-5 minutes</td>
                        <td>Dangerous conditions, stay indoors</td>
                    </tr>
                    <tr>
                        <td>Below -48°C (Below -54°F)</td>
                        <td>Extreme</td>
                        <td>Under 2 minutes</td>
                        <td>Life-threatening, avoid outdoors</td>
                    </tr>
                </tbody>
            </table>

            <h3>🔬 Wind Chill Calculation Formulas</h3>
            <div class="formula-box">
                <strong>Current Formula (2001 North American):</strong><br>
                Wind Chill (°C) = 13.12 + 0.6215T - 11.37V<sup>0.16</sup> + 0.3965TV<sup>0.16</sup><br>
                Where T = air temperature (°C), V = wind speed (km/h)<br><br>
                
                <strong>Old Formula (pre-2001):</strong><br>
                Wind Chill = 0.0817(3.71√V + 5.81 - 0.25V)(T - 91.4) + 91.4<br><br>
                
                <strong>Key Limitations:</strong><br>
                • Only valid for temperatures at or below 10°C (50°F)<br>
                • Only valid for wind speeds above 4.8 km/h (3 mph)<br>
                • Calculated for exposed facial skin
            </div>

            <h3>❄️ Frostbite & Hypothermia Risks</h3>
            <div class="weather-grid">
                <div class="weather-card">
                    <h4>🥶 Frostbite</h4>
                    <p>Freezing of body tissues, typically affecting extremities like fingers, toes, nose, and ears. Wind dramatically increases frostbite risk by accelerating heat loss.</p>
                </div>
                <div class="weather-card">
                    <h4>😴 Hypothermia</h4>
                    <p>Dangerous drop in body core temperature. Wind chill increases hypothermia risk by making it harder for the body to maintain its normal temperature.</p>
                </div>
                <div class="weather-card">
                    <h4>👃 Facial Protection</h4>
                    <p>Face and head are particularly vulnerable to wind chill since they're often exposed. A balaclava or face mask provides essential protection.</p>
                </div>
            </div>

            <h3>👕 Protective Clothing Guidelines</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Wind Chill Range</th>
                        <th>Clothing Recommendations</th>
                        <th>Additional Protection</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>0 to -10°C</td>
                        <td>Heavy coat, hat, gloves</td>
                        <td>Scarf for face protection</td>
                    </tr>
                    <tr>
                        <td>-10 to -25°C</td>
                        <td>Layered clothing, insulated boots</td>
                        <td>Face mask, thermal underwear</td>
                    </tr>
                    <tr>
                        <td>-25 to -40°C</td>
                        <td>Heavy layers, windproof outer shell</td>
                        <td>Balaclava, goggles, thick mittens</td>
                    </tr>
                    <tr>
                        <td>Below -40°C</td>
                        <td>Maximum insulation, multiple layers</td>
                        <td>Full face protection, limit exposure</td>
                    </tr>
                </tbody>
            </table>

            <h3>🌡️ Historical Development</h3>
            <div class="formula-box">
                <strong>1945:</strong> First wind chill index developed by Antarctic explorers Paul Siple and Charles Passel<br>
                <strong>1960s-1990s:</strong> Original formula used widely but found to overestimate heat loss<br>
                <strong>2001:</strong> New Wind Chill Temperature (WCT) index introduced by US and Canadian weather services<br>
                <strong>Current:</strong> Based on human face model and modern heat transfer science
            </div>

            <h3>🌍 Regional Considerations</h3>
            <ul>
                <li><strong>Arctic regions:</strong> Wind chill is a critical safety factor year-round</li>
                <li><strong>Temperate regions:</strong> Important during winter months, especially in windy areas</li>
                <li><strong>Mountainous areas:</strong> Higher altitudes combined with wind create extreme wind chill</li>
                <li><strong>Coastal areas:</strong> Sea breezes can create significant wind chill even in moderate temperatures</li>
            </ul>

            <h3>⚠️ Safety Precautions by Risk Level</h3>
            <div class="weather-grid">
                <div class="weather-card">
                    <h4>🟢 Low Risk (-9°C and warmer)</h4>
                    <p>• Dress in layers<br>• Cover ears and hands<br>• Stay dry<br>• Normal outdoor activities safe</p>
                </div>
                <div class="weather-card">
                    <h4>🟡 Moderate Risk (-10 to -27°C)</h4>
                    <p>• Wear hat and scarf<br>• Limit outdoor time to 30 min<br>• Watch for frostnip<br>• Keep moving outdoors</p>
                </div>
                <div class="weather-card">
                    <h4>🔴 High Risk (-28 to -39°C)</h4>
                    <p>• Cover all exposed skin<br>• Limit exposure to 10-30 min<br>• Wear insulated boots<br>• Seek shelter frequently</p>
                </div>
                <div class="weather-card">
                    <h4>⚫ Extreme Risk (-40°C and colder)</h4>
                    <p>• Stay indoors if possible<br>• Emergency outdoor exposure only<br>• Full face protection required<br>• Frostbite in 2-5 minutes</p>
                </div>
            </div>

            <h3>🔍 Special Considerations</h3>
            <ul>
                <li><strong>Children:</strong> More vulnerable due to higher surface area to volume ratio</li>
                <li><strong>Elderly:</strong> Reduced circulation increases frostbite risk</li>
                <li><strong>Medical conditions:</strong> Diabetes, circulatory issues increase vulnerability</li>
                <li><strong>Wet clothing:</strong> Dramatically increases heat loss rate</li>
                <li><strong>Alcohol:</strong> Increases heat loss and impairs judgment of cold</li>
            </ul>

            <h3>📱 Practical Applications</h3>
            <div class="formula-box">
                <strong>Outdoor Workers:</strong> Determine safe work durations and required protective equipment<br>
                <strong>Schools:</strong> Make informed decisions about outdoor recess and activities<br>
                <strong>Event Planning:</strong> Assess safety for outdoor events and provide warnings<br>
                <strong>Travel:</strong> Prepare appropriately for cold weather destinations<br>
                <strong>Emergency Services:</strong> Plan responses and protective measures for cold weather incidents
            </div>
        </div>

        <div class="footer">
            <p>💨 Wind Chill Calculator | Temperature & Wind Speed Analysis</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate wind chill temperature, assess cold weather risks, and get safety recommendations</p>
        </div>
    </div>

    <script>
        // DOM elements
        const temperatureInput = document.getElementById('temperature');
        const tempUnitSelect = document.getElementById('tempUnit');
        const windSpeedInput = document.getElementById('windSpeed');
        const windUnitSelect = document.getElementById('windUnit');
        const calculateButton = document.getElementById('calculateButton');
        
        const windChillValue = document.getElementById('windChillValue');
        const windChillUnit = document.getElementById('windChillUnit');
        const feelsLikeValue = document.getElementById('feelsLikeValue');
        const frostbiteRisk = document.getElementById('frostbiteRisk');
        const heatLossRate = document.getElementById('heatLossRate');
        
        const riskIcon = document.getElementById('riskIcon');
        const riskTitle = document.getElementById('riskTitle');
        const riskDesc = document.getElementById('riskDesc');
        const safetyTips = document.getElementById('safetyTips');
        const windChillChart = document.getElementById('windChillChart');

        // Event listeners
        calculateButton.addEventListener('click', calculateWindChill);
        temperatureInput.addEventListener('input', calculateWindChill);
        windSpeedInput.addEventListener('input', calculateWindChill);
        tempUnitSelect.addEventListener('change', calculateWindChill);
        windUnitSelect.addEventListener('change', calculateWindChill);

        // Initial calculation and chart
        calculateWindChill();
        generateWindChillChart();

        function calculateWindChill() {
            let temp = parseFloat(temperatureInput.value);
            const tempUnit = tempUnitSelect.value;
            let windSpeed = parseFloat(windSpeedInput.value);
            const windUnit = windUnitSelect.value;

            if (isNaN(temp) || isNaN(windSpeed) || windSpeed < 0) {
                return;
            }

            // Convert to metric for calculation
            let tempC;
            if (tempUnit === 'f') {
                tempC = (temp - 32) * 5/9;
            } else {
                tempC = temp;
            }

            let windKph;
            switch (windUnit) {
                case 'mph':
                    windKph = windSpeed * 1.60934;
                    break;
                case 'mps':
                    windKph = windSpeed * 3.6;
                    break;
                default:
                    windKph = windSpeed;
            }

            // Apply minimum wind speed for calculation
            const effectiveWindSpeed = Math.max(windKph, 4.8);

            // Calculate wind chill using North American formula
            let windChillC;
            if (tempC <= 10 && effectiveWindSpeed >= 4.8) {
                windChillC = 13.12 + 0.6215 * tempC - 11.37 * Math.pow(effectiveWindSpeed, 0.16) + 0.3965 * tempC * Math.pow(effectiveWindSpeed, 0.16);
            } else {
                windChillC = tempC; // No significant wind chill effect
            }

            // Convert back to original unit if needed
            let windChillDisplay, displayUnit;
            if (tempUnit === 'f') {
                windChillDisplay = (windChillC * 9/5) + 32;
                displayUnit = '°F';
            } else {
                windChillDisplay = windChillC;
                displayUnit = '°C';
            }

            // Update results
            updateResults(windChillDisplay, displayUnit, tempC, windChillC, effectiveWindSpeed);
        }

        function updateResults(windChill, unit, originalTempC, windChillC, windSpeedKph) {
            windChillValue.textContent = windChill.toFixed(1);
            windChillUnit.textContent = unit;

            // Determine "feels like" description
            const difference = windChillC - originalTempC;
            let feelsLike;
            if (difference > -2) {
                feelsLike = 'Slightly Colder';
            } else if (difference > -5) {
                feelsLike = 'Colder';
            } else if (difference > -10) {
                feelsLike = 'Much Colder';
            } else if (difference > -15) {
                feelsLike = 'Very Cold';
            } else {
                feelsLike = 'Extremely Cold';
            }
            feelsLikeValue.textContent = feelsLike;

            // Calculate heat loss rate (simplified)
            const baseLoss = 1.0;
            const windEffect = Math.min(windSpeedKph / 10, 5); // Cap at 5x
            const lossRate = (baseLoss + windEffect * 0.3).toFixed(1);
            heatLossRate.textContent = lossRate + 'x';

            // Update risk assessment
            updateRiskAssessment(windChillC);
        }

        function updateRiskAssessment(windChillC) {
            let icon, title, description, frostbiteTime, tips;

            if (windChillC > 0) {
                icon = '😊';
                title = 'Minimal Risk';
                description = 'Comfortable conditions with no significant wind chill effect. Normal outdoor activities are safe.';
                frostbiteTime = 'No risk';
                tips = [
                    'Normal seasonal clothing',
                    'Enjoy outdoor activities',
                    'Stay hydrated'
                ];
            } else if (windChillC >= -10) {
                icon = '😐';
                title = 'Low Risk';
                description = 'Cold conditions with some wind chill effect. Dress warmly and cover exposed skin.';
                frostbiteTime = '30+ minutes';
                tips = [
                    'Wear layers of warm clothing',
                    'Protect exposed skin from wind',
                    'Stay dry and avoid sweating'
                ];
            } else if (windChillC >= -28) {
                icon = '🥶';
                title = 'Moderate Risk';
                description = 'Very cold with significant wind chill. Frostbite possible in 10-30 minutes on exposed skin.';
                frostbiteTime = '10-30 minutes';
                tips = [
                    'Wear hat, scarf, and gloves',
                    'Limit outdoor time to 30 minutes',
                    'Watch for signs of frostnip'
                ];
            } else if (windChillC >= -40) {
                icon = '⚠️';
                title = 'High Risk';
                description = 'Dangerously cold. Frostbite can occur in 5-10 minutes. Limit outdoor exposure.';
                frostbiteTime = '5-10 minutes';
                tips = [
                    'Cover all exposed skin',
                    'Wear insulated waterproof boots',
                    'Seek shelter frequently'
                ];
            } else {
                icon = '🚨';
                title = 'Extreme Risk';
                description = 'Life-threatening cold. Frostbite can occur in under 5 minutes. Stay indoors if possible.';
                frostbiteTime = 'Under 5 minutes';
                tips = [
                    'Stay indoors if possible',
                    'Full face protection required',
                    'Emergency exposure only'
                ];
            }

            riskIcon.textContent = icon;
            riskTitle.textContent = title;
            riskDesc.textContent = description;
            frostbiteRisk.textContent = frostbiteTime;

            // Update safety tips
            safetyTips.innerHTML = '';
            tips.forEach(tip => {
                const tipElement = document.createElement('div');
                tipElement.className = 'safety-item';
                tipElement.innerHTML = `
                    <span class="safety-bullet">•</span>
                    <span>${tip}</span>
                `;
                safetyTips.appendChild(tipElement);
            });
        }

        function generateWindChillChart() {
            const windSpeeds = [5, 10, 15, 20, 25, 30, 40, 50];
            const temperatures = [5, 0, -5, -10, -15, -20];
            
            windChillChart.innerHTML = '';
            
            windSpeeds.forEach(speed => {
                const row = document.createElement('tr');
                let rowHTML = `<td>${speed}</td>`;
                
                temperatures.forEach(temp => {
                    let windChill;
                    if (temp <= 10 && speed >= 4.8) {
                        windChill = 13.12 + 0.6215 * temp - 11.37 * Math.pow(speed, 0.16) + 0.3965 * temp * Math.pow(speed, 0.16);
                    } else {
                        windChill = temp;
                    }
                    
                    // Color code based on risk
                    let cellClass = '';
                    if (windChill <= -40) cellClass = 'style="background: #c0392b; color: white;"';
                    else if (windChill <= -28) cellClass = 'style="background: #e74c3c; color: white;"';
                    else if (windChill <= -10) cellClass = 'style="background: #f39c12; color: white;"';
                    else if (windChill <= 0) cellClass = 'style="background: #f1c40f;"';
                    
                    rowHTML += `<td ${cellClass}>${windChill.toFixed(1)}</td>`;
                });
                
                row.innerHTML = rowHTML;
                windChillChart.appendChild(row);
            });
        }

        function setScenario(temperature, windSpeed) {
            temperatureInput.value = temperature;
            windSpeedInput.value = windSpeed;
            calculateWindChill();
        }

        // Make function available globally
        window.setScenario = setScenario;
    </script>
</body>
</html>
