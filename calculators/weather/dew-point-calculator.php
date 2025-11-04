<?php
/**
 * Dew Point Calculator
 * File: weather/dew-point-calculator.php
 * Description: Calculate dew point from temperature and humidity with advanced weather insights
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dew Point Calculator - Temperature & Humidity Analysis Tool</title>
    <meta name="description" content="Calculate dew point from temperature and humidity. Understand comfort levels, condensation risks, and weather forecasting.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: clamp(1.5rem, 4vw, 2rem); margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: clamp(0.9rem, 2.5vw, 1.05rem); line-height: 1.6; }
        
        .calculator-card { background: white; padding: clamp(20px, 5vw, 35px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: clamp(15px, 4vw, 25px); margin-bottom: 25px; }
        
        .input-group { background: #f8f9fa; padding: clamp(15px, 4vw, 25px); border-radius: 12px; }
        .input-group h3 { color: #2c3e50; margin-bottom: 15px; font-size: clamp(1rem, 3vw, 1.2rem); display: flex; align-items: center; gap: 8px; }
        
        .input-row { display: flex; gap: 15px; align-items: end; margin-bottom: 15px; }
        .input-wrapper { flex: 1; }
        .input-wrapper label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.9rem; }
        .input-field { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-field:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; }
        .unit-select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .calculate-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 16px 30px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        
        .results-section { margin-top: 30px; }
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        
        .result-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; text-align: center; }
        .result-label { color: #4527a0; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-value { font-size: 1.4rem; font-weight: bold; color: #5e35b1; }
        .result-unit { color: #7e57c2; font-size: 0.9rem; margin-top: 5px; }
        
        .comfort-indicator { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .comfort-header { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .comfort-header h3 { color: #2c3e50; font-size: 1.1rem; }
        .comfort-level { display: flex; align-items: center; gap: 15px; padding: 15px; background: white; border-radius: 10px; margin-bottom: 15px; }
        .comfort-icon { font-size: 2rem; }
        .comfort-text { flex: 1; }
        .comfort-title { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .comfort-desc { color: #7f8c8d; font-size: 0.9rem; }
        
        .risk-meter { height: 10px; background: #e0e0e0; border-radius: 5px; overflow: hidden; margin-top: 10px; }
        .meter-fill { height: 100%; transition: all 0.3s; }
        
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
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: clamp(0.8rem, 2vw, 0.9rem); }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-row { flex-direction: column; }
            .results-grid { grid-template-columns: repeat(2, 1fr); }
            .scenarios-grid { grid-template-columns: repeat(2, 1fr); }
            .comfort-level { flex-direction: column; text-align: center; }
        }
        
        @media (max-width: 480px) {
            .results-grid { grid-template-columns: 1fr; }
            .scenarios-grid { grid-template-columns: 1fr; }
            .input-grid { grid-template-columns: 1fr; }
            .calculator-card { padding: 15px; }
            .header { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💧 Dew Point Calculator</h1>
            <p>Calculate dew point temperature from air temperature and relative humidity. Understand condensation risks and comfort levels.</p>
        </div>

        <div class="calculator-card">
            <div class="input-grid">
                <div class="input-group">
                    <h3>🌡️ Temperature Input</h3>
                    <div class="input-row">
                        <div class="input-wrapper">
                            <label for="temperature">Temperature</label>
                            <input type="number" id="temperature" class="input-field" placeholder="Enter temperature" value="25" step="0.1">
                        </div>
                        <div class="input-wrapper">
                            <label for="tempUnit">Unit</label>
                            <select id="tempUnit" class="unit-select">
                                <option value="c" selected>°C</option>
                                <option value="f">°F</option>
                                <option value="k">K</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <h3>💦 Humidity Input</h3>
                    <div class="input-row">
                        <div class="input-wrapper">
                            <label for="humidity">Relative Humidity (%)</label>
                            <input type="number" id="humidity" class="input-field" placeholder="Enter humidity" value="60" min="0" max="100" step="1">
                        </div>
                        <div class="input-wrapper">
                            <label for="pressure">Pressure (hPa)</label>
                            <input type="number" id="pressure" class="input-field" placeholder="1013.25" value="1013.25" step="0.1">
                        </div>
                    </div>
                </div>
            </div>

            <button class="calculate-btn" id="calculateButton">Calculate Dew Point</button>

            <div class="results-section">
                <div class="results-grid">
                    <div class="result-card">
                        <div class="result-label">Dew Point Temperature</div>
                        <div class="result-value" id="dewPointValue">16.7</div>
                        <div class="result-unit" id="dewPointUnit">°C</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Absolute Humidity</div>
                        <div class="result-value" id="absHumidityValue">11.8</div>
                        <div class="result-unit">g/m³</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Vapor Pressure</div>
                        <div class="result-value" id="vaporPressureValue">19.0</div>
                        <div class="result-unit">hPa</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Mixing Ratio</div>
                        <div class="result-value" id="mixingRatioValue">11.8</div>
                        <div class="result-unit">g/kg</div>
                    </div>
                </div>

                <div class="comfort-indicator">
                    <div class="comfort-header">
                        <h3>😊 Comfort Level & Risks</h3>
                    </div>
                    <div class="comfort-level">
                        <div class="comfort-icon" id="comfortIcon">😊</div>
                        <div class="comfort-text">
                            <div class="comfort-title" id="comfortTitle">Comfortable</div>
                            <div class="comfort-desc" id="comfortDesc">Pleasant conditions with low condensation risk</div>
                            <div class="risk-meter">
                                <div class="meter-fill" id="riskMeter" style="width: 30%; background: #27ae60;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="quick-scenarios">
                <h3>⚡ Common Weather Scenarios</h3>
                <div class="scenarios-grid">
                    <div class="scenario-btn" onclick="setScenario(30, 80)">
                        <div class="scenario-value">30°C, 80%</div>
                        <div class="scenario-label">Tropical Day</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(20, 50)">
                        <div class="scenario-value">20°C, 50%</div>
                        <div class="scenario-label">Comfortable</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(10, 90)">
                        <div class="scenario-value">10°C, 90%</div>
                        <div class="scenario-label">Foggy Morning</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(-5, 70)">
                        <div class="scenario-value">-5°C, 70%</div>
                        <div class="scenario-label">Winter Day</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(35, 20)">
                        <div class="scenario-value">35°C, 20%</div>
                        <div class="scenario-label">Desert Climate</div>
                    </div>
                    <div class="scenario-btn" onclick="setScenario(15, 30)">
                        <div class="scenario-value">15°C, 30%</div>
                        <div class="scenario-label">Dry & Cool</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>💧 Understanding Dew Point</h2>
            
            <p>The dew point is the temperature to which air must be cooled to become saturated with water vapor. When cooled further, airborne water vapor will condense to form liquid water (dew).</p>

            <div class="weather-grid">
                <div class="weather-card">
                    <h4>🌡️ What is Dew Point?</h4>
                    <p>The temperature at which condensation begins. Higher dew points mean more moisture in the air.</p>
                </div>
                <div class="weather-card">
                    <h4>💦 Relative Humidity vs Dew Point</h4>
                    <p>Relative humidity depends on temperature, while dew point is an absolute measure of moisture content.</p>
                </div>
                <div class="weather-card">
                    <h4>🔍 Why It Matters</h4>
                    <p>Dew point determines comfort levels, fog formation, and precipitation probability.</p>
                </div>
            </div>

            <h3>📊 Dew Point Comfort Scale</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Dew Point Range</th>
                        <th>Perception</th>
                        <th>Comfort Level</th>
                        <th>Relative Humidity at 25°C</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Below 10°C (50°F)</td>
                        <td>Dry, comfortable</td>
                        <td>Very comfortable</td>
                        <td>Below 40%</td>
                    </tr>
                    <tr>
                        <td>10-16°C (50-60°F)</td>
                        <td>Pleasant</td>
                        <td>Comfortable</td>
                        <td>40-60%</td>
                    </tr>
                    <tr>
                        <td>16-18°C (60-65°F)</td>
                        <td>OK for most</td>
                        <td>Moderate</td>
                        <td>60-70%</td>
                    </tr>
                    <tr>
                        <td>18-21°C (65-70°F)</td>
                        <td>Somewhat uncomfortable</td>
                        <td>Uncomfortable</td>
                        <td>70-80%</td>
                    </tr>
                    <tr>
                        <td>21-24°C (70-75°F)</td>
                        <td>Quite uncomfortable</td>
                        <td>Very uncomfortable</td>
                        <td>80-90%</td>
                    </tr>
                    <tr>
                        <td>Above 24°C (75°F)</td>
                        <td>Extremely uncomfortable</td>
                        <td>Severely uncomfortable</td>
                        <td>Above 90%</td>
                    </tr>
                </tbody>
            </table>

            <h3>🔬 Scientific Formulas</h3>
            <div class="formula-box">
                <strong>Magnus-Tetens Formula (for dew point calculation):</strong><br>
                T<sub>d</sub> = (b × α(T,RH)) / (a - α(T,RH))<br>
                Where α(T,RH) = (a × T) / (b + T) + ln(RH/100)<br><br>
                
                <strong>Constants:</strong><br>
                • a = 17.27, b = 237.7°C (for T ≥ 0°C)<br>
                • a = 17.27, b = 265.5°C (for T < 0°C)<br><br>
                
                <strong>Absolute Humidity:</strong><br>
                AH = (6.112 × e<sup>(17.67×T/(T+243.5))</sup> × RH × 2.1674) / (273.15 + T)
            </div>

            <h3>🌤️ Weather Forecasting Applications</h3>
            <div class="weather-grid">
                <div class="weather-card">
                    <h4>🌫️ Fog Prediction</h4>
                    <p>When temperature approaches dew point, fog is likely to form. Fog occurs when temperature-dew point spread is less than 2.5°C.</p>
                </div>
                <div class="weather-card">
                    <h4>🌧️ Precipitation</h4>
                    <p>High dew points indicate ample moisture for cloud formation and precipitation. Thunderstorms are more likely with dew points above 15°C.</p>
                </div>
                <div class="weather-card">
                    <h4>❄️ Frost Formation</h4>
                    <p>Frost forms when temperature drops below freezing and dew point is below freezing. The difference determines frost intensity.</p>
                </div>
            </div>

            <h3>🏠 Practical Applications</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Ideal Dew Point</th>
                        <th>Considerations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Indoor Comfort</td>
                        <td>10-16°C</td>
                        <td>Prevents mold, maintains comfort</td>
                    </tr>
                    <tr>
                        <td>Agriculture</td>
                        <td>Varies by crop</td>
                        <td>Affects transpiration, disease risk</td>
                    </tr>
                    <tr>
                        <td>Aviation</td>
                        <td>Monitor closely</td>
                        <td>Fog, icing conditions critical</td>
                    </tr>
                    <tr>
                        <td>Construction</td>
                        <td>Below surface temp</td>
                        <td>Prevents condensation in materials</td>
                    </tr>
                    <tr>
                        <td>Museums/Archives</td>
                        <td>5-15°C</td>
                        <td>Preservation of materials</td>
                    </tr>
                </tbody>
            </table>

            <h3>🌡️ Temperature-Dew Point Relationship</h3>
            <div class="formula-box">
                <strong>Temperature-Dew Point Spread:</strong><br>
                • < 2.5°C: Fog likely<br>
                • 2.5-5°C: Humid conditions<br>
                • 5-10°C: Moderate humidity<br>
                • 10-15°C: Dry conditions<br>
                • > 15°C: Very dry conditions<br><br>
                
                <strong>Weather Indicators:</strong><br>
                • Small spread: Stable air, possible precipitation<br>
                • Large spread: Dry air, clear skies likely
            </div>

            <h3>🌍 Regional Variations</h3>
            <ul>
                <li><strong>Tropical regions:</strong> Consistently high dew points (20-26°C)</li>
                <li><strong>Desert regions:</strong> Large temperature-dew point spreads</li>
                <li><strong>Temperate regions:</strong> Seasonal variations in dew points</li>
                <li><strong>Polar regions:</strong> Very low dew points year-round</li>
                <li><strong>Coastal areas:</strong> More stable dew points due to water influence</li>
            </ul>

            <h3>🔧 Measurement Instruments</h3>
            <div class="weather-grid">
                <div class="weather-card">
                    <h4>🌡️ Psychrometer</h4>
                    <p>Uses wet-bulb and dry-bulb thermometers to calculate humidity and dew point.</p>
                </div>
                <div class="weather-card">
                    <h4>💧 Hygrometer</h4>
                    <p>Directly measures relative humidity, from which dew point can be calculated.</p>
                </div>
                <div class="weather-card">
                    <h4>📡 Dew Point Meter</h4>
                    <p>Specialized instruments that directly measure dew point temperature.</p>
                </div>
            </div>

            <h3>⚠️ Health & Safety Considerations</h3>
            <ul>
                <li><strong>High dew points:</strong> Increase heat stress, mold growth risk</li>
                <li><strong>Low dew points:</strong> Can cause dry skin, respiratory irritation</li>
                <li><strong>Rapid changes:</strong> May trigger migraines in sensitive individuals</li>
                <li><strong>Extreme values:</strong> Require special HVAC considerations</li>
            </ul>

            <h3>📈 Climate Change Impact</h3>
            <p>As global temperatures rise, dew points are also increasing in many regions, leading to more frequent and intense humid heat events. This has significant implications for human health, agriculture, and energy demand for cooling.</p>
        </div>

        <div class="footer">
            <p>💧 Dew Point Calculator | Temperature & Humidity Analysis</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate dew point, absolute humidity, and assess comfort levels for any weather conditions</p>
        </div>
    </div>

    <script>
        // DOM elements
        const temperatureInput = document.getElementById('temperature');
        const tempUnitSelect = document.getElementById('tempUnit');
        const humidityInput = document.getElementById('humidity');
        const pressureInput = document.getElementById('pressure');
        const calculateButton = document.getElementById('calculateButton');
        
        const dewPointValue = document.getElementById('dewPointValue');
        const dewPointUnit = document.getElementById('dewPointUnit');
        const absHumidityValue = document.getElementById('absHumidityValue');
        const vaporPressureValue = document.getElementById('vaporPressureValue');
        const mixingRatioValue = document.getElementById('mixingRatioValue');
        
        const comfortIcon = document.getElementById('comfortIcon');
        const comfortTitle = document.getElementById('comfortTitle');
        const comfortDesc = document.getElementById('comfortDesc');
        const riskMeter = document.getElementById('riskMeter');

        // Event listeners
        calculateButton.addEventListener('click', calculateDewPoint);
        temperatureInput.addEventListener('input', calculateDewPoint);
        humidityInput.addEventListener('input', calculateDewPoint);
        pressureInput.addEventListener('input', calculateDewPoint);
        tempUnitSelect.addEventListener('change', calculateDewPoint);

        // Initial calculation
        calculateDewPoint();

        function calculateDewPoint() {
            let temp = parseFloat(temperatureInput.value);
            const unit = tempUnitSelect.value;
            const humidity = parseFloat(humidityInput.value);
            const pressure = parseFloat(pressureInput.value) || 1013.25;

            if (isNaN(temp) || isNaN(humidity) || humidity < 0 || humidity > 100) {
                return;
            }

            // Convert temperature to Celsius for calculations
            let tempC;
            switch (unit) {
                case 'c':
                    tempC = temp;
                    break;
                case 'f':
                    tempC = (temp - 32) * 5/9;
                    break;
                case 'k':
                    tempC = temp - 273.15;
                    break;
                default:
                    tempC = temp;
            }

            // Calculate dew point using Magnus formula
            const alpha = (17.27 * tempC) / (237.7 + tempC) + Math.log(humidity / 100);
            const dewPointC = (237.7 * alpha) / (17.27 - alpha);

            // Calculate other parameters
            const vaporPressure = (humidity / 100) * 6.112 * Math.exp((17.67 * tempC) / (tempC + 243.5));
            const absoluteHumidity = (vaporPressure * 100) / (0.4615 * (tempC + 273.15)) * 1000; // g/m³
            const mixingRatio = (0.622 * vaporPressure) / (pressure - vaporPressure) * 1000; // g/kg

            // Display results
            displayResults(dewPointC, absoluteHumidity, vaporPressure, mixingRatio, unit);
            updateComfortLevel(dewPointC, tempC);
        }

        function displayResults(dewPointC, absHumidity, vaporPressure, mixingRatio, unit) {
            // Convert dew point to selected unit for display
            let dewPointDisplay, unitSymbol;
            switch (unit) {
                case 'c':
                    dewPointDisplay = dewPointC;
                    unitSymbol = '°C';
                    break;
                case 'f':
                    dewPointDisplay = (dewPointC * 9/5) + 32;
                    unitSymbol = '°F';
                    break;
                case 'k':
                    dewPointDisplay = dewPointC + 273.15;
                    unitSymbol = 'K';
                    break;
                default:
                    dewPointDisplay = dewPointC;
                    unitSymbol = '°C';
            }

            dewPointValue.textContent = dewPointDisplay.toFixed(1);
            dewPointUnit.textContent = unitSymbol;
            absHumidityValue.textContent = absHumidity.toFixed(1);
            vaporPressureValue.textContent = vaporPressure.toFixed(1);
            mixingRatioValue.textContent = mixingRatio.toFixed(1);
        }

        function updateComfortLevel(dewPointC, tempC) {
            let icon, title, description, riskPercent, riskColor;
            const spread = tempC - dewPointC;

            if (dewPointC < 10) {
                icon = '😊';
                title = 'Very Comfortable';
                description = 'Dry conditions, very low condensation risk';
                riskPercent = 10;
                riskColor = '#27ae60';
            } else if (dewPointC >= 10 && dewPointC < 16) {
                icon = '😊';
                title = 'Comfortable';
                description = 'Pleasant conditions with low condensation risk';
                riskPercent = 30;
                riskColor = '#2ecc71';
            } else if (dewPointC >= 16 && dewPointC < 18) {
                icon = '😐';
                title = 'Moderate';
                description = 'OK for most people, some may feel discomfort';
                riskPercent = 50;
                riskColor = '#f39c12';
            } else if (dewPointC >= 18 && dewPointC < 21) {
                icon = '😓';
                title = 'Uncomfortable';
                description = 'Somewhat uncomfortable, moderate condensation risk';
                riskPercent = 70;
                riskColor = '#e67e22';
            } else if (dewPointC >= 21 && dewPointC < 24) {
                icon = '😫';
                title = 'Very Uncomfortable';
                description = 'Quite uncomfortable, high condensation risk';
                riskPercent = 85;
                riskColor = '#e74c3c';
            } else {
                icon = '🥵';
                title = 'Severely Uncomfortable';
                description = 'Extremely uncomfortable, very high condensation risk';
                riskPercent = 95;
                riskColor = '#c0392b';
            }

            // Adjust for temperature-dew point spread (fog risk)
            if (spread < 2.5) {
                description += '. Fog likely.';
                riskPercent = Math.min(riskPercent + 20, 95);
            } else if (spread < 5) {
                description += '. Humid conditions.';
                riskPercent = Math.min(riskPercent + 10, 95);
            }

            comfortIcon.textContent = icon;
            comfortTitle.textContent = title;
            comfortDesc.textContent = description;
            riskMeter.style.width = riskPercent + '%';
            riskMeter.style.background = riskColor;
        }

        function setScenario(temp, humidity) {
            temperatureInput.value = temp;
            humidityInput.value = humidity;
            calculateDewPoint();
        }

        // Make function available globally
        window.setScenario = setScenario;
    </script>
</body>
</html>
