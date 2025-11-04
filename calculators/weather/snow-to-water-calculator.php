<?php
/**
 * Snow to Water Calculator
 * File: weather/snow-to-water-calculator.php
 * Description: Calculate water equivalent of snow based on density and temperature
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snow to Water Calculator - Water Equivalent Conversion</title>
    <meta name="description" content="Calculate water equivalent of snow based on density, temperature, and snow type. Essential for hydrology and winter sports.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .controls-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .unit-display { margin-top: 5px; font-size: 0.85rem; color: #7f8c8d; }
        
        .input-with-unit { display: flex; align-items: center; gap: 10px; }
        .input-with-unit input { flex: 1; }
        .unit-label { min-width: 60px; font-size: 0.9rem; color: #7f8c8d; font-weight: 600; }
        
        .snow-type-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .snow-type-card { background: #f8f9fa; padding: 20px; border-radius: 10px; cursor: pointer; transition: all 0.3s; border: 2px solid transparent; text-align: center; }
        .snow-type-card:hover { transform: translateY(-2px); }
        .snow-type-card.active { border-color: #667eea; background: #ede7f6; }
        .snow-icon { font-size: 2rem; margin-bottom: 10px; }
        .snow-name { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .snow-density { font-size: 0.85rem; color: #7f8c8d; }
        
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .result-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; text-align: center; }
        .result-card.highlight { background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-left-color: #2196f3; }
        .result-value { font-size: 1.5rem; font-weight: bold; color: #5e35b1; margin-bottom: 5px; }
        .result-card.highlight .result-value { color: #1565c0; }
        .result-label { font-size: 0.85rem; color: #4527a0; font-weight: 600; }
        .result-card.highlight .result-label { color: #0d47a1; }
        .result-note { font-size: 0.75rem; color: #7f8c8d; margin-top: 5px; }
        
        .conversion-visual { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .conversion-visual h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .visual-container { display: flex; align-items: end; justify-content: center; gap: 30px; padding: 20px; }
        .snow-column, .water-column { display: flex; flex-direction: column; align-items: center; }
        .column-label { margin-bottom: 10px; font-weight: 600; color: #2c3e50; }
        .snow-visual, .water-visual { width: 80px; background: linear-gradient(180deg, #e3f2fd 0%, #bbdefb 100%); border-radius: 8px 8px 0 0; position: relative; }
        .water-visual { background: linear-gradient(180deg, #e3f2fd 0%, #64b5f6 100%); }
        .visual-height { position: absolute; top: -25px; left: 0; right: 0; text-align: center; font-weight: 600; color: #2c3e50; }
        .equals-sign { font-size: 2rem; color: #7f8c8d; align-self: center; }
        
        .density-scale { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .density-scale h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .scale-container { height: 20px; background: linear-gradient(90deg, #e3f2fd 0%, #64b5f6 50%, #1976d2 100%); border-radius: 10px; margin: 15px 0; position: relative; }
        .scale-marker { position: absolute; top: -5px; width: 2px; height: 30px; background: #2c3e50; }
        .scale-labels { display: flex; justify-content: space-between; font-size: 0.8rem; color: #7f8c8d; }
        
        .action-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .action-btn { padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3); }
        .action-btn.secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .action-btn.secondary:hover { border-color: #667eea; }
        
        .applications-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .application-card { background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #2196f3; }
        .application-icon { font-size: 1.5rem; margin-bottom: 10px; }
        .application-title { font-weight: 600; color: #2c3e50; margin-bottom: 8px; }
        .application-desc { font-size: 0.85rem; color: #555; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .snow-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .snow-table th, .snow-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .snow-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .snow-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .controls-row { grid-template-columns: 1fr; }
            .snow-type-grid { grid-template-columns: repeat(2, 1fr); }
            .results-grid { grid-template-columns: repeat(2, 1fr); }
            .visual-container { flex-direction: column; align-items: center; gap: 20px; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 480px) {
            .snow-type-grid { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .calculator-card { padding: 20px; }
            .header { padding: 20px; }
            .applications-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>❄️ Snow to Water Calculator</h1>
            <p>Calculate water equivalent of snow based on density, temperature, and snow type for hydrology and winter planning</p>
        </div>

        <div class="calculator-card">
            <div class="controls-row">
                <div class="control-group">
                    <label for="snowDepth">Snow Depth</label>
                    <div class="input-with-unit">
                        <input type="number" id="snowDepth" value="12" min="0" step="0.1">
                        <div class="unit-label">inches</div>
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="snowDensity">Snow Density</label>
                    <div class="input-with-unit">
                        <input type="number" id="snowDensity" value="10" min="1" max="50" step="0.1">
                        <div class="unit-label">%</div>
                    </div>
                    <div class="unit-display">Density: <span id="densityValue">10%</span> (0.1 g/cm³)</div>
                </div>
                
                <div class="control-group">
                    <label for="temperature">Air Temperature</label>
                    <div class="input-with-unit">
                        <input type="number" id="temperature" value="25" min="-40" max="40" step="1">
                        <div class="unit-label">°F</div>
                    </div>
                </div>
            </div>
            
            <div class="control-group">
                <label>Snow Type Presets</label>
                <div class="snow-type-grid">
                    <div class="snow-type-card active" data-density="5" data-temp="10">
                        <div class="snow-icon">🥶</div>
                        <div class="snow-name">Fresh Powder</div>
                        <div class="snow-density">5% density</div>
                    </div>
                    <div class="snow-type-card" data-density="10" data-temp="20">
                        <div class="snow-icon">❄️</div>
                        <div class="snow-name">Settled Snow</div>
                        <div class="snow-density">10% density</div>
                    </div>
                    <div class="snow-type-card" data-density="20" data-temp="30">
                        <div class="snow-icon">🌨️</div>
                        <div class="snow-name">Wet Snow</div>
                        <div class="snow-density">20% density</div>
                    </div>
                    <div class="snow-type-card" data-density="30" data-temp="35">
                        <div class="snow-icon">🧊</div>
                        <div class="snow-name">Very Wet Snow</div>
                        <div class="snow-density">30% density</div>
                    </div>
                    <div class="snow-type-card" data-density="40" data-temp="33">
                        <div class="snow-icon">⛸️</div>
                        <div class="snow-name">Slush</div>
                        <div class="snow-density">40% density</div>
                    </div>
                    <div class="snow-type-card" data-density="50" data-temp="32">
                        <div class="snow-icon">💧</div>
                        <div class="snow-name">Almost Water</div>
                        <div class="snow-density">50% density</div>
                    </div>
                </div>
            </div>
            
            <div class="results-grid">
                <div class="result-card highlight">
                    <div class="result-value" id="waterEquivalent">1.2</div>
                    <div class="result-label">INCHES OF WATER</div>
                    <div class="result-note">Snow Water Equivalent</div>
                </div>
                <div class="result-card">
                    <div class="result-value" id="conversionRatio">10:1</div>
                    <div class="result-label">SNOW TO WATER RATIO</div>
                    <div class="result-note">Depth ratio</div>
                </div>
                <div class="result-card">
                    <div class="result-value" id="snowWeight">31.2</div>
                    <div class="result-label">LBS PER SQ FT</div>
                    <div class="result-note">Snow load</div>
                </div>
                <div class="result-card">
                    <div class="result-value" id="waterVolume">0.62</div>
                    <div class="result-label">GALLONS PER SQ FT</div>
                    <div class="result-note">Water volume</div>
                </div>
            </div>
            
            <div class="conversion-visual">
                <h3>📊 Snow to Water Conversion</h3>
                <div class="visual-container">
                    <div class="snow-column">
                        <div class="column-label">Snow Depth</div>
                        <div class="snow-visual" id="snowVisual" style="height: 120px;">
                            <div class="visual-height" id="snowHeight">12"</div>
                        </div>
                    </div>
                    <div class="equals-sign">=</div>
                    <div class="water-column">
                        <div class="column-label">Water Equivalent</div>
                        <div class="water-visual" id="waterVisual" style="height: 12px;">
                            <div class="visual-height" id="waterHeight">1.2"</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="density-scale">
                <h3>📈 Snow Density Scale</h3>
                <div class="scale-container" id="densityScale">
                    <div class="scale-marker" id="densityMarker" style="left: 10%;"></div>
                </div>
                <div class="scale-labels">
                    <span>5% (Light Powder)</span>
                    <span>25% (Average)</span>
                    <span>50% (Heavy/Wet)</span>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="action-btn" id="calculateBtn">
                    <span>🧮</span> Calculate
                </button>
                <button class="action-btn secondary" id="resetBtn">
                    <span>🔄</span> Reset
                </button>
                <button class="action-btn secondary" id="swapUnitsBtn">
                    <span>📏</span> Switch Units
                </button>
            </div>
            
            <div class="applications-grid">
                <div class="application-card">
                    <div class="application-icon">💧</div>
                    <div class="application-title">Hydrology</div>
                    <div class="application-desc">Predict spring runoff and water supply from snowpack</div>
                </div>
                <div class="application-card">
                    <div class="application-icon">🏔️</div>
                    <div class="application-title">Avalanche Safety</div>
                    <div class="application-desc">Assess snowpack stability and water content</div>
                </div>
                <div class="application-card">
                    <div class="application-icon">🏠</div>
                    <div class="application-title">Roof Loading</div>
                    <div class="application-desc">Calculate structural load from snow accumulation</div>
                </div>
                <div class="application-card">
                    <div class="application-icon">🎿</div>
                    <div class="application-title">Winter Sports</div>
                    <div class="application-desc">Understand snow conditions for skiing and snowboarding</div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>❄️ Snow Water Equivalent Science</h2>
            
            <p>Snow Water Equivalent (SWE) is a critical measurement in hydrology that represents the amount of water contained within a snowpack. This calculation is essential for water resource management, flood forecasting, and winter sports safety.</p>

            <h3>📊 Snow Density Basics</h3>
            <table class="snow-table">
                <thead>
                    <tr>
                        <th>Snow Type</th>
                        <th>Density Range</th>
                        <th>Water Equivalent</th>
                        <th>Typical Ratio</th>
                        <th>Characteristics</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Fresh Powder</td><td>5-8%</td><td>Very Low</td><td>12-20:1</td><td>Light, fluffy, low moisture</td></tr>
                    <tr><td>Settled Snow</td><td>8-15%</td><td>Low</td><td>7-12:1</td><td>Moderate density, common</td></tr>
                    <tr><td>Wind Packed</td><td>15-25%</td><td>Medium</td><td>4-7:1</td><td>Dense, cohesive layers</td></tr>
                    <tr><td>Wet Snow</td><td>25-35%</td><td>High</td><td>3-4:1</td><td>Heavy, high water content</td></tr>
                    <tr><td>Slush</td><td>35-45%</td><td>Very High</td><td>2-3:1</td><td>Partially melted, saturated</td></tr>
                    <tr><td>Firn/Ice</td><td>45-50%</td><td>Maximum</td><td>2:1</td><td>Granular, old snow</td></tr>
                </tbody>
            </table>

            <h3>🧮 Calculation Formulas</h3>
            <div class="formula-box">
                <strong>Snow Water Equivalent (SWE):</strong><br>
                SWE = Snow Depth × (Snow Density / 100)<br><br>
                
                <strong>Snow to Water Ratio:</strong><br>
                Ratio = Snow Depth ÷ SWE<br><br>
                
                <strong>Snow Load (Weight):</strong><br>
                Weight = SWE × 5.2 lbs/ft² per inch of water<br><br>
                
                <strong>Water Volume:</strong><br>
                Volume = SWE × 0.623 gallons/ft² per inch of water
            </div>

            <h3>🌡️ Temperature Effects</h3>
            <ul>
                <li><strong>Below 15°F (-9°C):</strong> Low-density snow (5-10%), light crystals</li>
                <li><strong>15-25°F (-9 to -4°C):</strong> Moderate density (10-20%), settled snow</li>
                <li><strong>25-32°F (-4 to 0°C):</strong> High-density snow (20-30%), wet snow</li>
                <li><strong>Above 32°F (0°C):</strong> Maximum density (30-50%), melting occurs</li>
                <li><strong>Temperature gradient:</strong> Affects crystal structure and settling rate</li>
            </ul>

            <h3>🏔️ Geographic Variations</h3>
            <table class="snow-table">
                <thead>
                    <tr>
                        <th>Region</th>
                        <th>Average Density</th>
                        <th>Typical Ratio</th>
                        <th>Climate Factors</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Rocky Mountains</td><td>8-12%</td><td>10:1</td><td>Cold, dry climate</td></tr>
                    <tr><td>Sierra Nevada</td><td>15-25%</td><td>6:1</td><td>Maritime influence</td></tr>
                    <tr><td>Northeast US</td><td>12-20%</td><td>8:1</td><td>Variable temperatures</td></tr>
                    <tr><td>Coastal Alaska</td><td>20-30%</td><td>4:1</td><td>Wet, warm storms</td></tr>
                    <tr><td>Arctic</td><td>5-10%</td><td>12:1</td><td>Extreme cold, low humidity</td></tr>
                </tbody>
            </table>

            <h3>💧 Hydrological Importance</h3>
            <div class="formula-box">
                <strong>Water Resource Planning:</strong><br>
                • 1 inch of SWE = 27,154 gallons per acre<br>
                • Sierra snowpack provides 30% of California's water<br>
                • Colorado River basin depends on Rocky Mountain snowmelt<br>
                • Accurate SWE measurements critical for drought monitoring
            </div>

            <h3>🎿 Winter Sports Applications</h3>
            <ul>
                <li><strong>Skiing:</strong> Ideal density 8-15% for powder skiing</li>
                <li><strong>Snowboarding:</strong> Prefers 10-20% density for good carving</li>
                <li><strong>Snowmobiling:</strong> Higher density (15-25%) provides better traction</li>
                <li><strong>Snowshoeing:</strong> Varies by snow conditions and user weight</li>
                <li><strong>Avalanche risk:</strong> High density increases slab avalanche potential</li>
            </ul>

            <h3>🏗️ Structural Engineering</h3>
            <table class="snow-table">
                <thead>
                    <tr>
                        <th>Roof Type</th>
                        <th>Design Load</th>
                        <th>Equivalent Snow</th>
                        <th>Safety Factor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Residential (Normal)</td><td>20-30 psf</td><td>20-40 inches</td><td>1.5x</td></tr>
                    <tr><td>Commercial</td><td>30-50 psf</td><td>40-80 inches</td><td>2.0x</td></tr>
                    <tr><td>Mountain Structures</td><td>50-100 psf</td><td>80-200 inches</td><td>2.5x</td></tr>
                    <tr><td>Aircraft Hangars</td><td>100+ psf</td><td>200+ inches</td><td>3.0x</td></tr>
                </tbody>
            </table>

            <h3>📡 Measurement Techniques</h3>
            <ul>
                <li><strong>Snow Core Samples:</strong> Direct measurement using snow tubes</li>
                <li><strong>Snow Pillows:</strong> Pressure sensors measuring snow weight</li>
                <li><strong>Gamma Radiation:</strong> Airborne surveys measuring water content</li>
                <li><strong>Remote Sensing:</strong> Satellite and radar-based measurements</li>
                <li><strong>Manual Surveys:</strong> Regular snow course measurements</li>
            </ul>

            <h3>🌍 Climate Change Impact</h3>
            <div class="formula-box">
                <strong>Observed Changes:</strong><br>
                • Decreasing snowpack in many mountain regions<br>
                • Earlier snowmelt and runoff timing<br>
                • Increased rain-on-snow events<br>
                • Changing snow density patterns<br>
                • Impacts on water availability and winter tourism
            </div>

            <h3>⚠️ Safety Considerations</h3>
            <ul>
                <li><strong>Avalanches:</strong> High-density snow increases slab formation risk</li>
                <li><strong>Roof Collapse:</strong> Wet, heavy snow poses structural dangers</li>
                <li><strong>Flooding:</strong> Rapid snowmelt can cause river flooding</li>
                <li><strong>Travel:</strong> Snow density affects road conditions and traction</li>
                <li><strong>Measurement Safety:</strong> Proper techniques for snow sampling</li>
            </ul>
        </div>

        <div class="footer">
            <p>❄️ Professional Snow to Water Calculator | Hydrological Analysis</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate water equivalent, snow loads, and conversion ratios for various snow types</p>
        </div>
    </div>

    <script>
        // DOM elements
        const snowDepth = document.getElementById('snowDepth');
        const snowDensity = document.getElementById('snowDensity');
        const temperature = document.getElementById('temperature');
        const densityValue = document.getElementById('densityValue');
        const calculateBtn = document.getElementById('calculateBtn');
        const resetBtn = document.getElementById('resetBtn');
        const swapUnitsBtn = document.getElementById('swapUnitsBtn');
        const waterEquivalent = document.getElementById('waterEquivalent');
        const conversionRatio = document.getElementById('conversionRatio');
        const snowWeight = document.getElementById('snowWeight');
        const waterVolume = document.getElementById('waterVolume');
        const snowVisual = document.getElementById('snowVisual');
        const waterVisual = document.getElementById('waterVisual');
        const snowHeight = document.getElementById('snowHeight');
        const waterHeight = document.getElementById('waterHeight');
        const densityMarker = document.getElementById('densityMarker');
        const snowTypeCards = document.querySelectorAll('.snow-type-card');

        // Unit state
        let isMetric = false;

        // Initialize
        updateCalculations();
        setupSnowTypeCards();

        // Event listeners
        calculateBtn.addEventListener('click', updateCalculations);
        resetBtn.addEventListener('click', resetValues);
        swapUnitsBtn.addEventListener('click', swapUnits);
        snowDepth.addEventListener('input', updateCalculations);
        snowDensity.addEventListener('input', updateDensityDisplay);
        temperature.addEventListener('input', updateCalculations);

        function updateDensityDisplay() {
            const density = parseFloat(snowDensity.value);
            densityValue.textContent = `${density}%`;
            
            // Update density marker position (5-50% range)
            const markerPosition = ((density - 5) / 45) * 100;
            densityMarker.style.left = `${Math.max(0, Math.min(100, markerPosition))}%`;
            
            updateCalculations();
        }

        function setupSnowTypeCards() {
            snowTypeCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Remove active class from all cards
                    snowTypeCards.forEach(c => c.classList.remove('active'));
                    // Add active class to clicked card
                    this.classList.add('active');
                    
                    // Update inputs with card data
                    const density = this.dataset.density;
                    const temp = this.dataset.temp;
                    
                    snowDensity.value = density;
                    temperature.value = temp;
                    
                    updateDensityDisplay();
                    updateCalculations();
                });
            });
        }

        function updateCalculations() {
            const depth = parseFloat(snowDepth.value);
            const density = parseFloat(snowDensity.value);
            const temp = parseFloat(temperature.value);
            
            if (isNaN(depth) || isNaN(density) || isNaN(temp)) {
                return;
            }
            
            // Calculate Snow Water Equivalent (SWE)
            const swe = depth * (density / 100);
            
            // Calculate snow to water ratio
            const ratio = depth / swe;
            
            // Calculate snow weight (lbs per square foot)
            const weight = swe * 5.2; // 1 inch water = 5.2 lbs/ft²
            
            // Calculate water volume (gallons per square foot)
            const volume = swe * 0.623; // 1 inch water = 0.623 gallons/ft²
            
            // Update display
            waterEquivalent.textContent = swe.toFixed(2);
            conversionRatio.textContent = `${ratio.toFixed(1)}:1`;
            snowWeight.textContent = weight.toFixed(1);
            waterVolume.textContent = volume.toFixed(2);
            
            // Update visual representation
            updateVisualization(depth, swe);
        }

        function updateVisualization(snowDepthValue, waterEquiv) {
            // Set snow visual height (max 200px for visualization)
            const snowHeightPx = Math.min(200, snowDepthValue * 10);
            snowVisual.style.height = `${snowHeightPx}px`;
            snowHeight.textContent = isMetric ? 
                `${(snowDepthValue * 2.54).toFixed(1)} cm` : 
                `${snowDepthValue}"`;
            
            // Set water visual height (scale relative to snow)
            const waterHeightPx = Math.min(200, waterEquiv * 10);
            waterVisual.style.height = `${waterHeightPx}px`;
            waterHeight.textContent = isMetric ?
                `${(waterEquiv * 2.54).toFixed(1)} cm` :
                `${waterEquiv.toFixed(1)}"`;
        }

        function resetValues() {
            snowDepth.value = 12;
            snowDensity.value = 10;
            temperature.value = 25;
            updateDensityDisplay();
            updateCalculations();
            
            // Reset to first snow type
            snowTypeCards.forEach((card, index) => {
                card.classList.remove('active');
                if (index === 0) card.classList.add('active');
            });
        }

        function swapUnits() {
            isMetric = !isMetric;
            
            if (isMetric) {
                // Convert to metric
                const currentDepth = parseFloat(snowDepth.value);
                const currentTemp = parseFloat(temperature.value);
                
                snowDepth.value = (currentDepth * 2.54).toFixed(1);
                temperature.value = ((currentTemp - 32) * 5/9).toFixed(1);
                
                swapUnitsBtn.innerHTML = '<span>📏</span> Switch to Imperial';
            } else {
                // Convert to imperial
                const currentDepth = parseFloat(snowDepth.value);
                const currentTemp = parseFloat(temperature.value);
                
                snowDepth.value = (currentDepth / 2.54).toFixed(1);
                temperature.value = (currentTemp * 9/5 + 32).toFixed(1);
                
                swapUnitsBtn.innerHTML = '<span>📏</span> Switch to Metric';
            }
            
            updateCalculations();
        }

        // Initialize density display
        updateDensityDisplay();
    </script>
</body>
</html>
