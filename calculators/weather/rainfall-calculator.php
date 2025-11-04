<?php
/**
 * Rainfall Calculator
 * File: weather/rainfall-calculator.php
 * Description: Advanced rainfall calculation with volume analysis, intensity classification, and hydrological impact assessment
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rainfall Calculator - Precipitation Analysis Tool</title>
    <meta name="description" content="Calculate rainfall volume, intensity, and hydrological impact with comprehensive precipitation analysis and weather pattern assessment.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .tab-navigation { display: flex; gap: 10px; margin-bottom: 25px; flex-wrap: wrap; }
        .tab-btn { 
            padding: 12px 24px; 
            background: #f8f9fa; 
            border: 2px solid #e0e0e0; 
            border-radius: 8px; 
            cursor: pointer; 
            transition: all 0.3s;
            font-weight: 600;
            color: #2c3e50;
        }
        .tab-btn.active { 
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%); 
            color: white; 
            border-color: #74b9ff;
        }
        .tab-btn:hover:not(.active) {
            border-color: #74b9ff;
            transform: translateY(-2px);
        }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; background: white; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #74b9ff; box-shadow: 0 0 0 3px rgba(116, 185, 255, 0.1); }
        
        .input-with-unit { position: relative; }
        .input-with-unit input { padding-right: 60px; }
        .unit-display { 
            position: absolute; 
            right: 16px; 
            top: 50%; 
            transform: translateY(-50%); 
            color: #7f8c8d; 
            font-weight: 600;
        }
        
        .dimension-inputs { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .checkbox-group input { width: auto; }
        
        .action-buttons { display: flex; gap: 15px; margin-top: 25px; flex-wrap: wrap; }
        .btn { padding: 14px 24px; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; font-weight: 600; }
        .btn-primary { background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(116, 185, 255, 0.3); }
        .btn-secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .btn-secondary:hover { background: #e9ecef; }
        
        .quick-calculate { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-calculate h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #74b9ff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(116, 185, 255, 0.15); }
        .quick-value { font-weight: bold; color: #0984e3; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .results-section { margin-top: 30px; }
        
        .rainfall-summary { 
            background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%); 
            padding: 30px; 
            border-radius: 15px; 
            margin-bottom: 25px;
            text-align: center;
            color: white;
        }
        .summary-title { 
            font-size: 1.4rem; 
            font-weight: bold; 
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .rainfall-total { 
            font-size: 3.5rem; 
            font-weight: bold; 
            margin-bottom: 10px;
            line-height: 1;
        }
        .total-label { 
            font-size: 1.1rem; 
            font-weight: 600;
            margin-bottom: 15px;
            opacity: 0.9;
        }
        .intensity-indicator {
            display: inline-block;
            padding: 8px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            font-weight: 600;
            margin-top: 10px;
        }
        
        .volume-comparison { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-top: 20px;
        }
        .volume-item { 
            background: rgba(255,255,255,0.9); 
            padding: 15px; 
            border-radius: 10px; 
            color: #2c3e50;
        }
        .volume-value { 
            font-size: 1.3rem; 
            font-weight: bold; 
            color: #0984e3; 
            margin-bottom: 5px;
        }
        .volume-label { 
            font-size: 0.9rem; 
            color: #7f8c8d; 
        }
        
        .impact-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px;
        }
        .impact-card { 
            background: white; 
            padding: 25px; 
            border-radius: 12px; 
            border-left: 4px solid #74b9ff;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        .impact-title { 
            font-size: 1.1rem; 
            font-weight: bold; 
            color: #2c3e50; 
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .impact-list {
            list-style: none;
        }
        .impact-item {
            padding: 10px 0;
            border-bottom: 1px solid #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .impact-item:last-child {
            border-bottom: none;
        }
        .item-label {
            color: #34495e;
            font-weight: 500;
        }
        .item-value {
            color: #0984e3;
            font-weight: bold;
        }
        
        .intensity-scale {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            margin-top: 25px;
        }
        .scale-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .scale-levels {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .scale-level {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #e0e0e0;
            transition: transform 0.3s;
        }
        .scale-level.active {
            border-color: #74b9ff;
            transform: scale(1.05);
        }
        .level-intensity {
            font-size: 1.1rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        .level-range {
            font-size: 0.9rem;
            color: #0984e3;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .level-desc {
            font-size: 0.85rem;
            color: #7f8c8d;
            line-height: 1.4;
        }
        
        .rainfall-chart {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-top: 25px;
        }
        .chart-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .chart-bar {
            display: flex;
            align-items: center;
            margin: 15px 0;
            gap: 15px;
        }
        .chart-label {
            width: 120px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
        }
        .chart-bar-inner {
            flex: 1;
            height: 30px;
            background: #ecf0f1;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }
        .chart-bar-fill {
            height: 100%;
            border-radius: 15px;
            transition: width 0.5s ease-in-out;
            background: linear-gradient(90deg, #74b9ff, #0984e3);
        }
        .chart-percentage {
            width: 80px;
            text-align: right;
            font-weight: bold;
            color: #2c3e50;
            font-size: 0.9rem;
        }
        
        .history-section { margin-top: 30px; }
        .history-list { 
            max-height: 300px; 
            overflow-y: auto; 
            border: 1px solid #e0e0e0; 
            border-radius: 12px; 
            padding: 15px;
            background: #f8f9fa;
        }
        .history-item { 
            padding: 12px 15px; 
            border-bottom: 1px solid #e0e0e0; 
            display: flex; 
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s;
        }
        .history-item:hover { background: white; }
        .history-item:last-child { border-bottom: none; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .rainfall-types { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin: 20px 0; }
        .type-card { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #74b9ff; }
        .type-name { font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .type-desc { font-size: 0.85rem; color: #7f8c8d; }
        
        .formula-box { background: #f0f8ff; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #74b9ff; }
        .formula-box strong { color: #0984e3; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #f0f8ff; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .tab-navigation { flex-direction: column; }
            .action-buttons { flex-direction: column; }
            .impact-grid { grid-template-columns: 1fr; }
            .scale-levels { grid-template-columns: 1fr; }
            .volume-comparison { grid-template-columns: 1fr; }
            .rainfall-total { font-size: 2.5rem; }
            .dimension-inputs { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
        }
        
        @media (max-width: 480px) {
            .calculator-card { padding: 20px; }
            .header { padding: 20px; }
            .rainfall-summary { padding: 20px; }
            .impact-card { padding: 20px; }
            .chart-bar { flex-direction: column; align-items: flex-start; gap: 8px; }
            .chart-label { width: auto; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌧️ Rainfall Calculator</h1>
            <p>Calculate rainfall volume, intensity, and hydrological impact with comprehensive precipitation analysis and weather pattern assessment</p>
        </div>

        <div class="calculator-card">
            <div class="tab-navigation">
                <button class="tab-btn active" onclick="switchTab('basic')">📏 Basic Calculation</button>
                <button class="tab-btn" onclick="switchTab('advanced')">📊 Advanced Analysis</button>
                <button class="tab-btn" onclick="switchTab('intensity')">⚡ Intensity</button>
                <button class="tab-btn" onclick="switchTab('results')">📈 Results</button>
            </div>

            <!-- Basic Calculation Tab -->
            <div class="tab-content active" id="basic-tab">
                <h3>📏 Basic Rainfall Calculation</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="rainfallAmount">Rainfall Amount</label>
                        <div class="input-with-unit">
                            <input type="number" id="rainfallAmount" placeholder="e.g., 25" value="25" step="0.1">
                            <span class="unit-display">mm</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="areaType">Area Type</label>
                        <select id="areaType" class="control-select">
                            <option value="roof">Roof Surface</option>
                            <option value="garden">Garden/Lawn</option>
                            <option value="field" selected>Agricultural Field</option>
                            <option value="park">Park/Recreation</option>
                            <option value="urban">Urban Area</option>
                            <option value="custom">Custom Area</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="areaSize">Area Size</label>
                        <div class="dimension-inputs">
                            <div class="input-with-unit">
                                <input type="number" id="areaLength" placeholder="Length" value="10">
                                <span class="unit-display">m</span>
                            </div>
                            <div class="input-with-unit">
                                <input type="number" id="areaWidth" placeholder="Width" value="10">
                                <span class="unit-display">m</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="duration">Rainfall Duration</label>
                        <div class="input-with-unit">
                            <input type="number" id="duration" placeholder="e.g., 2" value="2" step="0.1">
                            <span class="unit-display">hours</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Analysis Tab -->
            <div class="tab-content" id="advanced-tab">
                <h3>📊 Advanced Rainfall Analysis</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="rainfallType">Rainfall Type</label>
                        <select id="rainfallType" class="control-select">
                            <option value="drizzle">Drizzle</option>
                            <option value="light">Light Rain</option>
                            <option value="moderate" selected>Moderate Rain</option>
                            <option value="heavy">Heavy Rain</option>
                            <option value="storm">Storm</option>
                            <option value="monsoon">Monsoon Rain</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="soilType">Soil Type</label>
                        <select id="soilType" class="control-select">
                            <option value="sandy">Sandy (High Drainage)</option>
                            <option value="loamy" selected>Loamy (Medium Drainage)</option>
                            <option value="clay">Clay (Low Drainage)</option>
                            <option value="urban">Urban (Impervious)</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="slope">Surface Slope</label>
                        <select id="slope" class="control-select">
                            <option value="flat">Flat (0-2%)</option>
                            <option value="gentle" selected>Gentle (2-5%)</option>
                            <option value="moderate">Moderate (5-10%)</option>
                            <option value="steep">Steep (10%+)</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="season">Season</label>
                        <select id="season" class="control-select">
                            <option value="spring">Spring</option>
                            <option value="summer">Summer</option>
                            <option value="autumn" selected>Autumn</option>
                            <option value="winter">Winter</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Intensity Tab -->
            <div class="tab-content" id="intensity-tab">
                <h3>⚡ Rainfall Intensity Analysis</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="intensityType">Intensity Classification</label>
                        <select id="intensityType" class="control-select" onchange="updateIntensityValues()">
                            <option value="auto">Auto-calculate from duration</option>
                            <option value="manual">Manual intensity input</option>
                        </select>
                    </div>
                    
                    <div class="control-group" id="manualIntensityGroup" style="display: none;">
                        <label for="manualIntensity">Rainfall Intensity</label>
                        <div class="input-with-unit">
                            <input type="number" id="manualIntensity" placeholder="e.g., 15" value="15" step="0.1">
                            <span class="unit-display">mm/h</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="returnPeriod">Return Period</label>
                        <select id="returnPeriod" class="control-select">
                            <option value="1">1 year (Common)</option>
                            <option value="5" selected>5 years (Frequent)</option>
                            <option value="10">10 years (Occasional)</option>
                            <option value="25">25 years (Rare)</option>
                            <option value="50">50 years (Very Rare)</option>
                            <option value="100">100 years (Extreme)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Results Tab -->
            <div class="tab-content" id="results-tab">
                <h3>📈 Rainfall Analysis Results</h3>
                <div class="results-section">
                    <div class="rainfall-summary">
                        <div class="summary-title">🌧️ Rainfall Analysis Summary</div>
                        <div class="rainfall-total" id="rainfallVolume">0.0</div>
                        <div class="total-label" id="volumeLabel">liters of rainwater</div>
                        <div class="intensity-indicator" id="intensityIndicator">Light Rain</div>
                        
                        <div class="volume-comparison">
                            <div class="volume-item">
                                <div class="volume-value" id="volumeGallons">0</div>
                                <div class="volume-label">Gallons</div>
                            </div>
                            <div class="volume-item">
                                <div class="volume-value" id="volumeCubicMeters">0.0</div>
                                <div class="volume-label">Cubic Meters</div>
                            </div>
                            <div class="volume-item">
                                <div class="volume-value" id="volumeBathtubs">0</div>
                                <div class="volume-label">Bathtubs</div>
                            </div>
                            <div class="volume-item">
                                <div class="volume-value" id="volumeBottles">0</div>
                                <div class="volume-label">Water Bottles</div>
                            </div>
                        </div>
                    </div>

                    <div class="impact-grid">
                        <div class="impact-card">
                            <div class="impact-title">💧 Water Collection</div>
                            <div class="impact-list">
                                <div class="impact-item">
                                    <span class="item-label">Roof Collection</span>
                                    <span class="item-value" id="roofCollection">0%</span>
                                </div>
                                <div class="impact-item">
                                    <span class="item-label">Garden Irrigation</span>
                                    <span class="item-value" id="gardenIrrigation">0 days</span>
                                </div>
                                <div class="impact-item">
                                    <span class="item-label">Pool Refill</span>
                                    <span class="item-value" id="poolRefill">0%</span>
                                </div>
                                <div class="impact-item">
                                    <span class="item-label">Car Washes</span>
                                    <span class="item-value" id="carWashes">0</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="impact-card">
                            <div class="impact-title">🌱 Environmental Impact</div>
                            <div class="impact-list">
                                <div class="impact-item">
                                    <span class="item-label">Soil Saturation</span>
                                    <span class="item-value" id="soilSaturation">Low</span>
                                </div>
                                <div class="impact-item">
                                    <span class="item-label">Runoff Potential</span>
                                    <span class="item-value" id="runoffPotential">Low</span>
                                </div>
                                <div class="impact-item">
                                    <span class="item-label">Erosion Risk</span>
                                    <span class="item-value" id="erosionRisk">Low</span>
                                </div>
                                <div class="impact-item">
                                    <span class="item-label">Groundwater Recharge</span>
                                    <span class="item-value" id="groundwaterRecharge">Good</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="intensity-scale">
                        <div class="scale-title">📊 Rainfall Intensity Scale</div>
                        <div class="scale-levels" id="intensityScale">
                            <!-- Intensity levels will be generated here -->
                        </div>
                    </div>

                    <div class="rainfall-chart">
                        <div class="chart-title">📈 Volume Distribution</div>
                        <div id="volumeChart">
                            <!-- Chart bars will be generated here -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="quick-calculate">
                <h3>⚡ Common Scenarios</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="loadScenario('lightShower')">
                        <div class="quick-value">Light Shower</div>
                        <div class="quick-label">5mm, 1 hour</div>
                    </div>
                    <div class="quick-btn" onclick="loadScenario('moderateRain')">
                        <div class="quick-value">Moderate Rain</div>
                        <div class="quick-label">25mm, 2 hours</div>
                    </div>
                    <div class="quick-btn" onclick="loadScenario('heavyStorm')">
                        <div class="quick-value">Heavy Storm</div>
                        <div class="quick-label">50mm, 3 hours</div>
                    </div>
                    <div class="quick-btn" onclick="loadScenario('gardenArea')">
                        <div class="quick-value">Small Garden</div>
                        <div class="quick-label">50m² area</div>
                    </div>
                    <div class="quick-btn" onclick="loadScenario('roofArea')">
                        <div class="quick-value">House Roof</div>
                        <div class="quick-label">150m² area</div>
                    </div>
                    <div class="quick-btn" onclick="loadScenario('fieldArea')">
                        <div class="quick-value">Farm Field</div>
                        <div class="quick-label">1000m² area</div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button class="btn btn-primary" onclick="calculateRainfall()">🌧️ Calculate Rainfall</button>
                <button class="btn btn-secondary" onclick="resetCalculator()">🔄 Reset</button>
                <button class="btn btn-secondary" onclick="saveResults()">💾 Save Results</button>
            </div>
        </div>

        <div class="info-section">
            <h2>🌧️ Rainfall Analysis & Hydrology</h2>
            
            <p>Comprehensive rainfall calculation tool for understanding precipitation volume, intensity classification, and hydrological impacts for agricultural, urban planning, and environmental applications.</p>

            <h3>📊 Rainfall Intensity Classification</h3>
            <div class="rainfall-types">
                <div class="type-card">
                    <div class="type-name">🌦️ Drizzle</div>
                    <div class="type-desc">Less than 0.5 mm/h - Light mist, barely wet surfaces</div>
                </div>
                <div class="type-card">
                    <div class="type-name">🌧️ Light Rain</div>
                    <div class="type-desc">0.5-2.5 mm/h - Individual drops visible, small puddles</div>
                </div>
                <div class="type-card">
                    <div class="type-name">🌧️ Moderate Rain</div>
                    <div class="type-desc">2.5-7.5 mm/h - Rapid puddle formation, audible on roof</div>
                </div>
                <div class="type-card">
                    <div class="type-name">🌧️ Heavy Rain</div>
                    <div class="type-desc">7.5-50 mm/h - Rapid runoff, poor visibility</div>
                </div>
                <div class="type-card">
                    <div class="type-name">⛈️ Violent Rain</div>
                    <div class="type-desc">Over 50 mm/h - Torrential downpour, flash flood risk</div>
                </div>
                <div class="type-card">
                    <div class="type-name">🌊 Cloudburst</div>
                    <div class="type-desc">Over 100 mm/h - Extreme rainfall, severe flooding</div>
                </div>
            </div>

            <h3>📈 Global Rainfall Records</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Record Type</th>
                        <th>Amount</th>
                        <th>Location</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 Minute</td><td>38 mm</td><td>Barot, Guadeloupe</td><td>1970</td></tr>
                    <tr><td>1 Hour</td><td>305 mm</td><td>Holt, Missouri</td><td>1947</td></tr>
                    <tr><td>12 Hours</td><td>1,144 mm</td><td>Foc-Foc, Réunion</td><td>1966</td></tr>
                    <tr><td>24 Hours</td><td>1,825 mm</td><td>Foc-Foc, Réunion</td><td>1966</td></tr>
                    <tr><td>1 Month</td><td>9,300 mm</td><td>Cherrapunji, India</td><td>1861</td></tr>
                    <tr><td>1 Year</td><td>26,467 mm</td><td>Cherrapunji, India</td><td>1860-1861</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Rainfall Calculation Formulas:</strong><br>
                • <strong>Volume:</strong> Rainfall (mm) × Area (m²) = Liters<br>
                • <strong>Intensity:</strong> Rainfall (mm) ÷ Duration (hours) = mm/hour<br>
                • <strong>Runoff:</strong> Volume × Runoff Coefficient = Runoff Volume<br>
                • <strong>Infiltration:</strong> Volume × Infiltration Rate = Groundwater Recharge<br>
                • <strong>Return Period:</strong> Statistical probability of rainfall intensity occurrence
            </div>

            <h3>💧 Water Collection & Usage</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Water Required</th>
                        <th>Equivalent Rainfall</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Shower (5 min)</td><td>75 liters</td><td>0.75 mm on 100m²</td></tr>
                    <tr><td>Car Wash</td><td>150 liters</td><td>1.5 mm on 100m²</td></tr>
                    <tr><td>Garden Irrigation</td><td>500 liters</td><td>5 mm on 100m²</td></tr>
                    <tr><td>Swimming Pool</td><td>50,000 liters</td><td>500 mm on 100m²</td></tr>
                    <tr><td>Toilet Flush</td><td>6 liters</td><td>0.06 mm on 100m²</td></tr>
                    <tr><td>Drinking Water (daily)</td><td>2 liters</td><td>0.02 mm on 100m²</td></tr>
                </tbody>
            </table>

            <h3>🌱 Agricultural Impact</h3>
            <div class="probability-grid">
                <div class="probability-item">
                    <div class="prob-value">10-20 mm</div>
                    <div class="prob-label">Light Irrigation</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">20-40 mm</div>
                    <div class="prob-label">Good Soaking</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">40-60 mm</div>
                    <div class="prob-label">Heavy Watering</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">60-100 mm</div>
                    <div class="prob-label">Field Saturation</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">100+ mm</div>
                    <div class="prob-label">Flood Risk</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">500+ mm</div>
                    <div class="prob-label">Crop Damage</div>
                </div>
            </div>

            <h3>🏙️ Urban Hydrology</h3>
            <ul>
                <li><strong>Runoff Coefficient:</strong> Percentage of rainfall that becomes surface runoff</li>
                <li><strong>Impervious Surfaces:</strong> Concrete, asphalt - 85-95% runoff</li>
                <li><strong>Lawns & Gardens:</strong> 10-30% runoff depending on slope and soil</li>
                <li><strong>Forests & Parks:</strong> 5-15% runoff with high infiltration</li>
                <li><strong>Drainage Systems:</strong> Designed for specific return period storms</li>
                <li><strong>Flash Floods:</strong> Occur when rainfall exceeds drainage capacity</li>
            </ul>

            <h3>🌍 Climate Patterns</h3>
            <div class="formula-box">
                <strong>Global Rainfall Patterns:</strong><br>
                • <strong>Tropical:</strong> High annual rainfall, consistent throughout year<br>
                • <strong>Arid/Desert:</strong> Less than 250 mm annually, highly variable<br>
                • <strong>Temperate:</strong> Moderate rainfall, seasonal patterns<br>
                • <strong>Mediterranean:</strong> Wet winters, dry summers<br>
                • <strong>Monsoon:</strong> Seasonal heavy rainfall patterns<br>
                • <strong>Polar:</strong> Low precipitation, mostly snow
            </div>

            <h3>📊 Measurement Standards</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Measurement</th>
                        <th>Standard Unit</th>
                        <th>Conversion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Rainfall Depth</td><td>Millimeters (mm)</td><td>1 mm = 1 liter/m²</td></tr>
                    <tr><td>Rainfall Volume</td><td>Liters (L)</td><td>1 m³ = 1000 liters</td></tr>
                    <tr><td>Rainfall Intensity</td><td>mm/hour</td><td>25.4 mm = 1 inch</td></tr>
                    <tr><td>Water Flow</td><td>Liters/second</td><td>1 L/s = 3.6 m³/hour</td></tr>
                    <tr><td>Catchment Area</td><td>Square meters (m²)</td><td>1 hectare = 10,000 m²</td></tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>🌧️ Rainfall Calculator | Hydrological Analysis Tool</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Essential for agriculture, urban planning, water management, and environmental assessment</p>
        </div>
    </div>

    <script>
        let calculationHistory = [];
        
        function updateIntensityValues() {
            const intensityType = document.getElementById('intensityType').value;
            const manualGroup = document.getElementById('manualIntensityGroup');
            
            if (intensityType === 'manual') {
                manualGroup.style.display = 'block';
            } else {
                manualGroup.style.display = 'none';
            }
        }

        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Activate selected button
            event.target.classList.add('active');
        }

        function calculateRainfall() {
            // Get basic calculation data
            const rainfallAmount = parseFloat(document.getElementById('rainfallAmount').value) || 0;
            const areaType = document.getElementById('areaType').value;
            const areaLength = parseFloat(document.getElementById('areaLength').value) || 0;
            const areaWidth = parseFloat(document.getElementById('areaWidth').value) || 0;
            const duration = parseFloat(document.getElementById('duration').value) || 1;
            
            // Get advanced analysis data
            const rainfallType = document.getElementById('rainfallType').value;
            const soilType = document.getElementById('soilType').value;
            const slope = document.getElementById('slope').value;
            const season = document.getElementById('season').value;
            
            // Get intensity data
            const intensityType = document.getElementById('intensityType').value;
            const manualIntensity = parseFloat(document.getElementById('manualIntensity').value) || 0;
            const returnPeriod = parseInt(document.getElementById('returnPeriod').value);
            
            // Calculate area
            const area = areaLength * areaWidth;
            
            // Calculate volume (1 mm rain = 1 liter per m²)
            const volumeLiters = rainfallAmount * area;
            
            // Calculate intensity
            let intensity;
            if (intensityType === 'manual' && manualIntensity > 0) {
                intensity = manualIntensity;
            } else {
                intensity = rainfallAmount / duration;
            }
            
            // Calculate additional volumes and impacts
            const volumeGallons = volumeLiters * 0.264172;
            const volumeCubicMeters = volumeLiters / 1000;
            const volumeBathtubs = volumeLiters / 150; // Average bathtub capacity
            const volumeBottles = volumeLiters / 0.5; // 500ml water bottles
            
            // Calculate impacts based on parameters
            const impacts = calculateImpacts(volumeLiters, rainfallAmount, intensity, areaType, soilType, slope, returnPeriod);
            
            // Update display
            updateResults(volumeLiters, volumeGallons, volumeCubicMeters, volumeBathtubs, volumeBottles, intensity, impacts);
            
            // Switch to results tab
            switchTab('results');
            
            // Add to history
            addToHistory(volumeLiters, rainfallAmount, area);
        }
        
        function calculateImpacts(volume, rainfall, intensity, areaType, soilType, slope, returnPeriod) {
            // Roof collection efficiency (percentage)
            const roofEfficiency = areaType === 'roof' ? 85 : 0;
            
            // Garden irrigation days (based on typical garden water needs)
            const gardenDays = Math.floor(volume / 500); // 500L per irrigation
            
            // Pool refill percentage (standard pool 50,000L)
            const poolRefill = Math.min((volume / 50000) * 100, 100);
            
            // Car washes (150L per wash)
            const carWashes = Math.floor(volume / 150);
            
            // Environmental impacts
            const soilSaturation = calculateSoilSaturation(rainfall, soilType);
            const runoffPotential = calculateRunoffPotential(intensity, soilType, slope);
            const erosionRisk = calculateErosionRisk(intensity, slope, soilType);
            const groundwaterRecharge = calculateGroundwaterRecharge(rainfall, soilType, intensity);
            
            return {
                roofCollection: roofEfficiency,
                gardenIrrigation: gardenDays,
                poolRefill: poolRefill,
                carWashes: carWashes,
                soilSaturation: soilSaturation,
                runoffPotential: runoffPotential,
                erosionRisk: erosionRisk,
                groundwaterRecharge: groundwaterRecharge
            };
        }
        
        function calculateSoilSaturation(rainfall, soilType) {
            const saturationLevels = {
                'sandy': { light: 10, moderate: 25, heavy: 50 },
                'loamy': { light: 15, moderate: 35, heavy: 70 },
                'clay': { light: 20, moderate: 45, heavy: 90 },
                'urban': { light: 5, moderate: 15, heavy: 30 }
            };
            
            const levels = saturationLevels[soilType];
            if (rainfall < levels.light) return 'Low';
            if (rainfall < levels.moderate) return 'Moderate';
            if (rainfall < levels.heavy) return 'High';
            return 'Saturated';
        }
        
        function calculateRunoffPotential(intensity, soilType, slope) {
            let baseRunoff = 0;
            
            // Soil type factors
            const soilFactors = {
                'sandy': 0.2,
                'loamy': 0.4,
                'clay': 0.6,
                'urban': 0.9
            };
            
            // Slope factors
            const slopeFactors = {
                'flat': 1.0,
                'gentle': 1.2,
                'moderate': 1.5,
                'steep': 2.0
            };
            
            // Intensity factors
            let intensityFactor = 1.0;
            if (intensity > 50) intensityFactor = 2.5;
            else if (intensity > 25) intensityFactor = 2.0;
            else if (intensity > 10) intensityFactor = 1.5;
            else if (intensity > 2.5) intensityFactor = 1.2;
            
            baseRunoff = soilFactors[soilType] * slopeFactors[slope] * intensityFactor;
            
            if (baseRunoff < 0.3) return 'Low';
            if (baseRunoff < 0.6) return 'Moderate';
            if (baseRunoff < 0.8) return 'High';
            return 'Very High';
        }
        
        function calculateErosionRisk(intensity, slope, soilType) {
            let risk = 0;
            
            // Intensity contribution
            if (intensity > 25) risk += 3;
            else if (intensity > 10) risk += 2;
            else if (intensity > 2.5) risk += 1;
            
            // Slope contribution
            if (slope === 'steep') risk += 3;
            else if (slope === 'moderate') risk += 2;
            else if (slope === 'gentle') risk += 1;
            
            // Soil type contribution (clay resists erosion better)
            if (soilType === 'sandy') risk += 2;
            else if (soilType === 'loamy') risk += 1;
            
            if (risk <= 2) return 'Low';
            if (risk <= 4) return 'Moderate';
            if (risk <= 6) return 'High';
            return 'Very High';
        }
        
        function calculateGroundwaterRecharge(rainfall, soilType, intensity) {
            const rechargeFactors = {
                'sandy': 0.6,
                'loamy': 0.4,
                'clay': 0.2,
                'urban': 0.1
            };
            
            // High intensity reduces recharge due to runoff
            let intensityFactor = 1.0;
            if (intensity > 25) intensityFactor = 0.3;
            else if (intensity > 10) intensityFactor = 0.6;
            else if (intensity > 2.5) intensityFactor = 0.8;
            
            const rechargePotential = rechargeFactors[soilType] * intensityFactor;
            
            if (rechargePotential > 0.5) return 'Excellent';
            if (rechargePotential > 0.3) return 'Good';
            if (rechargePotential > 0.15) return 'Fair';
            return 'Poor';
        }
        
        function updateResults(volumeLiters, volumeGallons, volumeCubicMeters, volumeBathtubs, volumeBottles, intensity, impacts) {
            // Format large numbers
            const formatVolume = (vol) => {
                if (vol >= 1000000) return (vol / 1000000).toFixed(1) + 'M';
                if (vol >= 1000) return (vol / 1000).toFixed(1) + 'K';
                return Math.round(vol).toLocaleString();
            };
            
            // Update main volume
            document.getElementById('rainfallVolume').textContent = formatVolume(volumeLiters);
            document.getElementById('volumeLabel').textContent = `liters of rainwater collected`;
            
            // Update volume comparisons
            document.getElementById('volumeGallons').textContent = formatVolume(volumeGallons);
            document.getElementById('volumeCubicMeters').textContent = volumeCubicMeters.toFixed(1);
            document.getElementById('volumeBathtubs').textContent = formatVolume(volumeBathtubs);
            document.getElementById('volumeBottles').textContent = formatVolume(volumeBottles);
            
            // Update intensity indicator
            const intensityLevel = getIntensityLevel(intensity);
            document.getElementById('intensityIndicator').textContent = intensityLevel.name;
            document.getElementById('intensityIndicator').style.background = intensityLevel.color;
            
            // Update impact values
            document.getElementById('roofCollection').textContent = impacts.roofCollection + '%';
            document.getElementById('gardenIrrigation').textContent = impacts.gardenIrrigation + ' days';
            document.getElementById('poolRefill').textContent = impacts.poolRefill.toFixed(1) + '%';
            document.getElementById('carWashes').textContent = impacts.carWashes;
            document.getElementById('soilSaturation').textContent = impacts.soilSaturation;
            document.getElementById('runoffPotential').textContent = impacts.runoffPotential;
            document.getElementById('erosionRisk').textContent = impacts.erosionRisk;
            document.getElementById('groundwaterRecharge').textContent = impacts.groundwaterRecharge;
            
            // Update intensity scale
            updateIntensityScale(intensity);
            
            // Update volume chart
            updateVolumeChart(volumeLiters, volumeGallons, volumeCubicMeters);
        }
        
        function getIntensityLevel(intensity) {
            if (intensity < 0.5) return { name: 'Drizzle', color: '#74b9ff' };
            if (intensity < 2.5) return { name: 'Light Rain', color: '#3498db' };
            if (intensity < 7.5) return { name: 'Moderate Rain', color: '#2980b9' };
            if (intensity < 50) return { name: 'Heavy Rain', color: '#e74c3c' };
            return { name: 'Violent Rain', color: '#c0392b' };
        }
        
        function updateIntensityScale(currentIntensity) {
            const container = document.getElementById('intensityScale');
            container.innerHTML = '';
            
            const intensityLevels = [
                { range: '0-0.5', name: 'Drizzle', desc: 'Light mist, barely wet surfaces' },
                { range: '0.5-2.5', name: 'Light Rain', desc: 'Individual drops visible' },
                { range: '2.5-7.5', name: 'Moderate Rain', desc: 'Rapid puddle formation' },
                { range: '7.5-50', name: 'Heavy Rain', desc: 'Rapid runoff, poor visibility' },
                { range: '50+', name: 'Violent Rain', desc: 'Torrential, flood risk' }
            ];
            
            intensityLevels.forEach(level => {
                const levelElement = document.createElement('div');
                levelElement.className = 'scale-level';
                
                const rangeParts = level.range.split('-');
                const minIntensity = parseFloat(rangeParts[0]);
                const maxIntensity = rangeParts[1] === '+' ? Infinity : parseFloat(rangeParts[1]);
                
                if (currentIntensity >= minIntensity && currentIntensity <= maxIntensity) {
                    levelElement.classList.add('active');
                }
                
                levelElement.innerHTML = `
                    <div class="level-intensity">${level.name}</div>
                    <div class="level-range">${level.range} mm/h</div>
                    <div class="level-desc">${level.desc}</div>
                `;
                container.appendChild(levelElement);
            });
        }
        
        function updateVolumeChart(liters, gallons, cubicMeters) {
            const container = document.getElementById('volumeChart');
            container.innerHTML = '';
            
            const maxVolume = Math.max(liters, gallons, cubicMeters * 1000);
            
            const volumes = [
                { name: 'Liters', value: liters, color: '#74b9ff' },
                { name: 'Gallons', value: gallons, color: '#3498db' },
                { name: 'Cubic Meters', value: cubicMeters * 1000, color: '#2980b9' }
            ];
            
            volumes.forEach(volume => {
                if (volume.value > 0) {
                    const percentage = (volume.value / maxVolume) * 100;
                    const bar = document.createElement('div');
                    bar.className = 'chart-bar';
                    bar.innerHTML = `
                        <div class="chart-label">${volume.name}</div>
                        <div class="chart-bar-inner">
                            <div class="chart-bar-fill" style="width: ${percentage}%; background: ${volume.color}"></div>
                        </div>
                        <div class="chart-percentage">${volume.value.toLocaleString()}</div>
                    `;
                    container.appendChild(bar);
                }
            });
        }
        
        function loadScenario(scenario) {
            const scenarios = {
                'lightShower': { amount: 5, duration: 1, length: 10, width: 10 },
                'moderateRain': { amount: 25, duration: 2, length: 10, width: 10 },
                'heavyStorm': { amount: 50, duration: 3, length: 10, width: 10 },
                'gardenArea': { amount: 25, duration: 2, length: 5, width: 10 },
                'roofArea': { amount: 25, duration: 2, length: 10, width: 15 },
                'fieldArea': { amount: 25, duration: 2, length: 25, width: 40 }
            };
            
            const config = scenarios[scenario];
            if (config) {
                document.getElementById('rainfallAmount').value = config.amount;
                document.getElementById('duration').value = config.duration;
                document.getElementById('areaLength').value = config.length;
                document.getElementById('areaWidth').value = config.width;
            }
        }
        
        function addToHistory(volume, rainfall, area) {
            const timestamp = new Date().toLocaleString();
            calculationHistory.unshift({
                timestamp,
                volume,
                rainfall,
                area
            });
            
            // Keep only last 10 calculations
            if (calculationHistory.length > 10) {
                calculationHistory = calculationHistory.slice(0, 10);
            }
        }
        
        function resetCalculator() {
            // Reset all inputs to default values
            document.getElementById('rainfallAmount').value = '25';
            document.getElementById('areaType').value = 'field';
            document.getElementById('areaLength').value = '10';
            document.getElementById('areaWidth').value = '10';
            document.getElementById('duration').value = '2';
            document.getElementById('rainfallType').value = 'moderate';
            document.getElementById('soilType').value = 'loamy';
            document.getElementById('slope').value = 'gentle';
            document.getElementById('season').value = 'autumn';
            document.getElementById('intensityType').value = 'auto';
            document.getElementById('manualIntensity').value = '15';
            document.getElementById('returnPeriod').value = '5';
            
            // Hide manual intensity group
            document.getElementById('manualIntensityGroup').style.display = 'none';
        }
        
        function saveResults() {
            const volume = document.getElementById('rainfallVolume').textContent;
            const intensity = document.getElementById('intensityIndicator').textContent;
            
            let results = 'Rainfall Analysis Results\n';
            results += 'Generated: ' + new Date().toLocaleString() + '\n\n';
            results += `Total Volume: ${volume} liters\n`;
            results += `Rainfall Intensity: ${intensity}\n\n`;
            results += 'Detailed analysis and impact assessment provided.';
            
            const blob = new Blob([results], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'rainfall-analysis.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        // Initialize calculator
        window.onload = function() {
            // Set initial state
            updateIntensityValues();
        };
    </script>
</body>
</html>
