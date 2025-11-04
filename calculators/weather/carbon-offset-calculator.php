<?php
/**
 * Carbon Offset Calculator
 * File: weather/carbon-offset-calculator.php
 * Description: Advanced carbon footprint calculator with offset recommendations and environmental impact analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carbon Offset Calculator - Environmental Impact Analysis Tool</title>
    <meta name="description" content="Calculate your carbon footprint and discover offset solutions with comprehensive environmental impact analysis and sustainability recommendations.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #00b894 0%, #00a085 100%); min-height: 100vh; padding: 20px; }
        
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
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%); 
            color: white; 
            border-color: #00b894;
        }
        .tab-btn:hover:not(.active) {
            border-color: #00b894;
            transform: translateY(-2px);
        }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; background: white; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #00b894; box-shadow: 0 0 0 3px rgba(0, 184, 148, 0.1); }
        
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
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .checkbox-group input { width: auto; }
        
        .action-buttons { display: flex; gap: 15px; margin-top: 25px; flex-wrap: wrap; }
        .btn { padding: 14px 24px; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; font-weight: 600; }
        .btn-primary { background: linear-gradient(135deg, #00b894 0%, #00a085 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 184, 148, 0.3); }
        .btn-secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .btn-secondary:hover { background: #e9ecef; }
        
        .quick-calculate { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-calculate h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #00b894; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 184, 148, 0.15); }
        .quick-value { font-weight: bold; color: #00b894; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .results-section { margin-top: 30px; }
        
        .carbon-summary { 
            background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%); 
            padding: 30px; 
            border-radius: 15px; 
            margin-bottom: 25px;
            text-align: center;
        }
        .summary-title { 
            font-size: 1.4rem; 
            font-weight: bold; 
            color: #2c3e50; 
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .carbon-total { 
            font-size: 3.5rem; 
            font-weight: bold; 
            color: #e17055; 
            margin-bottom: 10px;
            line-height: 1;
        }
        .total-label { 
            font-size: 1.1rem; 
            color: #2c3e50; 
            font-weight: 600;
            margin-bottom: 15px;
        }
        .comparison { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-top: 20px;
        }
        .comparison-item { 
            background: rgba(255,255,255,0.9); 
            padding: 15px; 
            border-radius: 10px; 
        }
        .comparison-value { 
            font-size: 1.3rem; 
            font-weight: bold; 
            color: #00b894; 
            margin-bottom: 5px;
        }
        .comparison-label { 
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
            border-left: 4px solid #00b894;
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
            color: #00b894;
            font-weight: bold;
        }
        
        .offset-solutions {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            margin-top: 25px;
        }
        .solutions-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .solutions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .solution-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s;
            border: 2px solid #e0e0e0;
        }
        .solution-card:hover {
            transform: translateY(-5px);
            border-color: #00b894;
        }
        .solution-icon {
            font-size: 2rem;
            margin-bottom: 15px;
        }
        .solution-name {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .solution-desc {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-bottom: 15px;
            line-height: 1.4;
        }
        .solution-cost {
            font-weight: bold;
            color: #00b894;
            font-size: 1.1rem;
        }
        
        .progress-chart {
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
            background: linear-gradient(90deg, #00b894, #00a085);
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
        
        .emission-sources { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin: 20px 0; }
        .source-card { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #00b894; }
        .source-name { font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .source-desc { font-size: 0.85rem; color: #7f8c8d; }
        
        .formula-box { background: #f0f8f5; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #00b894; }
        .formula-box strong { color: #00b894; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #f0f8f5; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .tab-navigation { flex-direction: column; }
            .action-buttons { flex-direction: column; }
            .impact-grid { grid-template-columns: 1fr; }
            .solutions-grid { grid-template-columns: 1fr; }
            .comparison { grid-template-columns: 1fr; }
            .carbon-total { font-size: 2.5rem; }
            .header h1 { font-size: 1.5rem; }
        }
        
        @media (max-width: 480px) {
            .calculator-card { padding: 20px; }
            .header { padding: 20px; }
            .carbon-summary { padding: 20px; }
            .impact-card { padding: 20px; }
            .chart-bar { flex-direction: column; align-items: flex-start; gap: 8px; }
            .chart-label { width: auto; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌍 Carbon Offset Calculator</h1>
            <p>Calculate your carbon footprint and discover offset solutions with comprehensive environmental impact analysis and sustainability recommendations</p>
        </div>

        <div class="calculator-card">
            <div class="tab-navigation">
                <button class="tab-btn active" onclick="switchTab('transport')">🚗 Transportation</button>
                <button class="tab-btn" onclick="switchTab('home')">🏠 Home Energy</button>
                <button class="tab-btn" onclick="switchTab('food')">🍽️ Food & Diet</button>
                <button class="tab-btn" onclick="switchTab('shopping')">🛍️ Shopping</button>
                <button class="tab-btn" onclick="switchTab('results')">📊 Results</button>
            </div>

            <!-- Transportation Tab -->
            <div class="tab-content active" id="transport-tab">
                <h3>🚗 Transportation Emissions</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="carMileage">Car Mileage (miles/year)</label>
                        <div class="input-with-unit">
                            <input type="number" id="carMileage" placeholder="e.g., 12000" value="12000">
                            <span class="unit-display">miles</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="fuelEfficiency">Fuel Efficiency</label>
                        <select id="fuelEfficiency" class="control-select">
                            <option value="15">Low (15 mpg)</option>
                            <option value="20">Below Average (20 mpg)</option>
                            <option value="25" selected>Average (25 mpg)</option>
                            <option value="30">Above Average (30 mpg)</option>
                            <option value="40">High (40 mpg)</option>
                            <option value="50">Hybrid/Electric Equivalent</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="flightHours">Flight Hours (per year)</label>
                        <div class="input-with-unit">
                            <input type="number" id="flightHours" placeholder="e.g., 10" value="5">
                            <span class="unit-display">hours</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="publicTransport">Public Transport (miles/week)</label>
                        <div class="input-with-unit">
                            <input type="number" id="publicTransport" placeholder="e.g., 50" value="20">
                            <span class="unit-display">miles</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Home Energy Tab -->
            <div class="tab-content" id="home-tab">
                <h3>🏠 Home Energy Consumption</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="electricityUsage">Electricity Usage (kWh/month)</label>
                        <div class="input-with-unit">
                            <input type="number" id="electricityUsage" placeholder="e.g., 900" value="900">
                            <span class="unit-display">kWh</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="heatingType">Heating Type</label>
                        <select id="heatingType" class="control-select">
                            <option value="natural_gas">Natural Gas</option>
                            <option value="electric">Electric</option>
                            <option value="oil">Heating Oil</option>
                            <option value="propane">Propane</option>
                            <option value="wood">Wood</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="heatingUsage">Heating Usage (therms/month)</label>
                        <div class="input-with-unit">
                            <input type="number" id="heatingUsage" placeholder="e.g., 100" value="80">
                            <span class="unit-display">therms</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="houseSize">House Size</label>
                        <select id="houseSize" class="control-select">
                            <option value="small">Small (under 1500 sq ft)</option>
                            <option value="medium" selected>Medium (1500-2500 sq ft)</option>
                            <option value="large">Large (over 2500 sq ft)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Food & Diet Tab -->
            <div class="tab-content" id="food-tab">
                <h3>🍽️ Food & Dietary Choices</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="dietType">Primary Diet Type</label>
                        <select id="dietType" class="control-select">
                            <option value="meat_heavy">Meat Heavy</option>
                            <option value="average" selected>Average</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="vegan">Vegan</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="foodWaste">Food Waste</label>
                        <select id="foodWaste" class="control-select">
                            <option value="high">High Waste</option>
                            <option value="average" selected>Average</option>
                            <option value="low">Low Waste</option>
                            <option value="minimal">Minimal Waste</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="localFood">Local/Organic Food (%)</label>
                        <input type="range" id="localFood" min="0" max="100" value="30" class="probability-slider">
                        <div class="slider-value" id="localFoodValue">30%</div>
                    </div>
                </div>
            </div>

            <!-- Shopping Tab -->
            <div class="tab-content" id="shopping-tab">
                <h3>🛍️ Shopping & Consumption</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="clothingBudget">Clothing Budget ($/month)</label>
                        <div class="input-with-unit">
                            <input type="number" id="clothingBudget" placeholder="e.g., 200" value="150">
                            <span class="unit-display">$</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="electronics">Electronics Purchases</label>
                        <select id="electronics" class="control-select">
                            <option value="minimal">Minimal (replace when broken)</option>
                            <option value="average" selected>Average (upgrade every 2-3 years)</option>
                            <option value="frequent">Frequent (yearly upgrades)</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="recycling">Recycling Habits</label>
                        <select id="recycling" class="control-select">
                            <option value="none">No Recycling</option>
                            <option value="basic">Basic Recycling</option>
                            <option value="comprehensive" selected>Comprehensive Recycling</option>
                            <option value="zero_waste">Zero Waste Lifestyle</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Results Tab -->
            <div class="tab-content" id="results-tab">
                <h3>📊 Carbon Footprint Results</h3>
                <div class="results-section">
                    <div class="carbon-summary">
                        <div class="summary-title">🌍 Your Annual Carbon Footprint</div>
                        <div class="carbon-total" id="carbonTotal">0.0</div>
                        <div class="total-label" id="carbonLabel">metric tons of CO₂ equivalent</div>
                        
                        <div class="comparison">
                            <div class="comparison-item">
                                <div class="comparison-value" id="usAverage">0.0</div>
                                <div class="comparison-label">US Average</div>
                            </div>
                            <div class="comparison-item">
                                <div class="comparison-value" id="globalAverage">0.0</div>
                                <div class="comparison-label">Global Average</div>
                            </div>
                            <div class="comparison-item">
                                <div class="comparison-value" id="climateGoal">0.0</div>
                                <div class="comparison-label">Climate Goal</div>
                            </div>
                        </div>
                    </div>

                    <div class="impact-grid">
                        <div class="impact-card">
                            <div class="impact-title">📊 Emission Breakdown</div>
                            <div class="impact-list">
                                <div class="impact-item">
                                    <span class="item-label">Transportation</span>
                                    <span class="item-value" id="transportEmissions">0.0 t</span>
                                </div>
                                <div class="impact-item">
                                    <span class="item-label">Home Energy</span>
                                    <span class="item-value" id="homeEmissions">0.0 t</span>
                                </div>
                                <div class="impact-item">
                                    <span class="item-label">Food & Diet</span>
                                    <span class="item-value" id="foodEmissions">0.0 t</span>
                                </div>
                                <div class="impact-item">
                                    <span class="item-label">Shopping</span>
                                    <span class="item-value" id="shoppingEmissions">0.0 t</span>
                                </div>
                                <div class="impact-item">
                                    <span class="item-label">Other</span>
                                    <span class="item-value" id="otherEmissions">0.0 t</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="impact-card">
                            <div class="impact-title">🎯 Reduction Opportunities</div>
                            <div class="impact-list">
                                <div class="impact-item">
                                    <span class="item-label">Transportation</span>
                                    <span class="item-value" id="transportReduction">0.0 t</span>
                                </div>
                                <div class="impact-item">
                                    <span class="item-label">Home Energy</span>
                                    <span class="item-value" id="homeReduction">0.0 t</span>
                                </div>
                                <div class="impact-item">
                                    <span class="item-label">Food Choices</span>
                                    <span class="item-value" id="foodReduction">0.0 t</span>
                                </div>
                                <div class="impact-item">
                                    <span class="item-label">Shopping</span>
                                    <span class="item-value" id="shoppingReduction">0.0 t</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="progress-chart">
                        <div class="chart-title">📈 Emission Distribution</div>
                        <div id="emissionChart">
                            <!-- Chart bars will be generated here -->
                        </div>
                    </div>

                    <div class="offset-solutions">
                        <div class="solutions-title">💚 Carbon Offset Solutions</div>
                        <div class="solutions-grid">
                            <div class="solution-card">
                                <div class="solution-icon">🌳</div>
                                <div class="solution-name">Tree Planting</div>
                                <div class="solution-desc">Plant trees to absorb CO₂ through reforestation projects</div>
                                <div class="solution-cost" id="treeCost">$0</div>
                            </div>
                            <div class="solution-card">
                                <div class="solution-icon">☀️</div>
                                <div class="solution-name">Renewable Energy</div>
                                <div class="solution-desc">Invest in solar and wind energy projects to replace fossil fuels</div>
                                <div class="solution-cost" id="energyCost">$0</div>
                            </div>
                            <div class="solution-card">
                                <div class="solution-icon">🏭</div>
                                <div class="solution-name">Carbon Capture</div>
                                <div class="solution-desc">Support direct air capture and storage technologies</div>
                                <div class="solution-cost" id="captureCost">$0</div>
                            </div>
                            <div class="solution-card">
                                <div class="solution-icon">🚰</div>
                                <div class="solution-name">Clean Water</div>
                                <div class="solution-desc">Provide clean water solutions to reduce wood burning</div>
                                <div class="solution-cost" id="waterCost">$0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button class="btn btn-primary" onclick="calculateFootprint()">🌍 Calculate Footprint</button>
                <button class="btn btn-secondary" onclick="resetCalculator()">🔄 Reset</button>
                <button class="btn btn-secondary" onclick="saveResults()">💾 Save Results</button>
            </div>
        </div>

        <div class="info-section">
            <h2>🌍 Carbon Footprint Analysis</h2>
            
            <p>Understand and reduce your environmental impact with comprehensive carbon footprint calculation and personalized offset recommendations for sustainable living.</p>

            <h3>📊 Emission Sources & Impact</h3>
            <div class="emission-sources">
                <div class="source-card">
                    <div class="source-name">🚗 Transportation</div>
                    <div class="source-desc">Cars, flights, public transport - largest source for most individuals</div>
                </div>
                <div class="source-card">
                    <div class="source-name">🏠 Home Energy</div>
                    <div class="source-desc">Electricity, heating, cooling - varies by energy source and efficiency</div>
                </div>
                <div class="source-card">
                    <div class="source-name">🍽️ Food Production</div>
                    <div class="source-desc">Agriculture, processing, transportation - meat has highest impact</div>
                </div>
                <div class="source-card">
                    <div class="source-name">🛍️ Goods & Services</div>
                    <div class="source-desc">Manufacturing, packaging, transportation of consumer goods</div>
                </div>
            </div>

            <h3>📈 Global Carbon Statistics</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Country/Region</th>
                        <th>Average Footprint</th>
                        <th>Global Comparison</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>United States</td><td>16.0 tons CO₂e</td><td>3.5x global average</td></tr>
                    <tr><td>European Union</td><td>6.4 tons CO₂e</td><td>1.4x global average</td></tr>
                    <tr><td>China</td><td>7.4 tons CO₂e</td><td>1.6x global average</td></tr>
                    <tr><td>Global Average</td><td>4.6 tons CO₂e</td><td>Baseline</td></tr>
                    <tr><td>India</td><td>1.8 tons CO₂e</td><td>0.4x global average</td></tr>
                    <tr><td>Climate Goal 2030</td><td>2.0 tons CO₂e</td><td>Required for 2°C target</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Carbon Calculation Methods:</strong><br>
                • <strong>Transportation:</strong> miles × emission factor × fuel efficiency<br>
                • <strong>Electricity:</strong> kWh × grid emission factor × 12 months<br>
                • <strong>Heating:</strong> therms × fuel-specific emission factor<br>
                • <strong>Food:</strong> diet type multiplier × waste factor<br>
                • <strong>Shopping:</strong> spending × category-specific emission factors
            </div>

            <h3>💚 Effective Offset Strategies</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Offset Method</th>
                        <th>Cost per ton</th>
                        <th>Effectiveness</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Tree Planting</td><td>$5-15</td><td>Long-term, verifiable sequestration</td></tr>
                    <tr><td>Renewable Energy</td><td>$10-25</td><td>Immediate fossil fuel displacement</td></tr>
                    <tr><td>Methane Capture</td><td>$8-20</td><td>High-impact, short-term benefits</td></tr>
                    <tr><td>Energy Efficiency</td><td>$15-30</td><td>Ongoing reduction benefits</td></tr>
                    <tr><td>Carbon Capture Tech</td><td>$50-200</td><td>Direct removal, scalable potential</td></tr>
                </tbody>
            </table>

            <h3>🌱 Reduction Strategies</h3>
            <div class="probability-grid">
                <div class="probability-item">
                    <div class="prob-value">2.5 tons</div>
                    <div class="prob-label">Electric Vehicle</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">1.8 tons</div>
                    <div class="prob-label">Solar Panels</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">1.2 tons</div>
                    <div class="prob-label">Vegetarian Diet</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">0.8 tons</div>
                    <div class="prob-label">Energy Star Home</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">0.5 tons</div>
                    <div class="prob-label">Public Transport</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">0.3 tons</div>
                    <div class="prob-label">LED Lighting</div>
                </div>
            </div>

            <h3>🌍 Climate Goals & Targets</h3>
            <ul>
                <li><strong>Paris Agreement:</strong> Limit warming to 1.5-2°C above pre-industrial levels</li>
                <li><strong>Net Zero 2050:</strong> Balance emissions with removal by 2050</li>
                <li><strong>2030 Target:</strong> 45% reduction from 2010 levels</li>
                <li><strong>Sustainable Footprint:</strong> 2.0 tons CO₂e per person annually</li>
                <li><strong>Carbon Budget:</strong> 400 billion tons remaining for 1.5°C target</li>
            </ul>

            <h3>🔬 Scientific Background</h3>
            <div class="formula-box">
                <strong>Key Climate Metrics:</strong><br>
                • <strong>CO₂ Equivalent:</strong> Standardized measure of all greenhouse gases<br>
                • <strong>Global Warming Potential:</strong> Comparative impact of different gases<br>
                • <strong>Carbon Budget:</strong> Total CO₂ that can be emitted while staying below temperature targets<br>
                • <strong>Sequestration Rate:</strong> How quickly natural systems absorb CO₂<br>
                • <strong>Social Cost of Carbon:</strong> Economic damage per ton of CO₂ emitted
            </div>

            <h3>🏆 Certification Standards</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Standard</th>
                        <th>Focus Area</th>
                        <th>Verification</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Gold Standard</td><td>Renewable energy, efficiency</td><td>Third-party verified</td></tr>
                    <tr><td>Verified Carbon Standard</td><td>Various project types</td><td>Independent audit</td></tr>
                    <tr><td>American Carbon Registry</td><td>US-based projects</td><td>Rigorous protocols</td></tr>
                    <tr><td>Climate Action Reserve</td><td>North American projects</td><td>Transparent tracking</td></tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>🌍 Carbon Offset Calculator | Environmental Impact Analysis</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Make informed decisions to reduce your carbon footprint and support sustainable solutions</p>
        </div>
    </div>

    <script>
        let calculationHistory = [];
        
        // Update slider value display
        document.getElementById('localFood').addEventListener('input', function() {
            document.getElementById('localFoodValue').textContent = this.value + '%';
        });

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

        function calculateFootprint() {
            // Get transportation data
            const carMileage = parseFloat(document.getElementById('carMileage').value) || 0;
            const fuelEfficiency = parseFloat(document.getElementById('fuelEfficiency').value);
            const flightHours = parseFloat(document.getElementById('flightHours').value) || 0;
            const publicTransport = parseFloat(document.getElementById('publicTransport').value) || 0;
            
            // Get home energy data
            const electricityUsage = parseFloat(document.getElementById('electricityUsage').value) || 0;
            const heatingType = document.getElementById('heatingType').value;
            const heatingUsage = parseFloat(document.getElementById('heatingUsage').value) || 0;
            const houseSize = document.getElementById('houseSize').value;
            
            // Get food data
            const dietType = document.getElementById('dietType').value;
            const foodWaste = document.getElementById('foodWaste').value;
            const localFood = parseInt(document.getElementById('localFood').value);
            
            // Get shopping data
            const clothingBudget = parseFloat(document.getElementById('clothingBudget').value) || 0;
            const electronics = document.getElementById('electronics').value;
            const recycling = document.getElementById('recycling').value;
            
            // Calculate emissions by category
            const transportEmissions = calculateTransportEmissions(carMileage, fuelEfficiency, flightHours, publicTransport);
            const homeEmissions = calculateHomeEmissions(electricityUsage, heatingType, heatingUsage, houseSize);
            const foodEmissions = calculateFoodEmissions(dietType, foodWaste, localFood);
            const shoppingEmissions = calculateShoppingEmissions(clothingBudget, electronics, recycling);
            const otherEmissions = 1.5; // Baseline other emissions
            
            const totalEmissions = transportEmissions + homeEmissions + foodEmissions + shoppingEmissions + otherEmissions;
            
            // Calculate reduction potential
            const reductionPotential = calculateReductionPotential(transportEmissions, homeEmissions, foodEmissions, shoppingEmissions);
            
            // Update display
            updateResults(totalEmissions, transportEmissions, homeEmissions, foodEmissions, shoppingEmissions, otherEmissions, reductionPotential);
            
            // Switch to results tab
            switchTab('results');
            
            // Add to history
            addToHistory(totalEmissions);
        }
        
        function calculateTransportEmissions(carMileage, fuelEfficiency, flightHours, publicTransport) {
            // Car emissions: miles × (lbs CO2/gallon) / mpg × conversion to tons
            const carEmissions = carMileage * (19.6 / fuelEfficiency) * 0.000453592;
            
            // Flight emissions: hours × average emissions per hour
            const flightEmissions = flightHours * 90; // kg CO2 per hour
            const flightEmissionsTons = flightEmissions * 0.001;
            
            // Public transport emissions (much lower per mile)
            const publicTransportEmissions = publicTransport * 52 * 0.00017; // Weekly to annual, tons per mile
            
            return carEmissions + flightEmissionsTons + publicTransportEmissions;
        }
        
        function calculateHomeEmissions(electricityUsage, heatingType, heatingUsage, houseSize) {
            // Electricity emissions (US average: 0.85 lbs CO2 per kWh)
            const electricityEmissions = electricityUsage * 12 * 0.85 * 0.000453592;
            
            // Heating emissions based on fuel type (lbs CO2 per therm)
            const heatingFactors = {
                'natural_gas': 11.7,
                'electric': 0.0, // Already counted in electricity
                'oil': 15.9,
                'propane': 12.7,
                'wood': 0.0 // Considered carbon neutral
            };
            
            const heatingEmissions = heatingUsage * 12 * heatingFactors[heatingType] * 0.000453592;
            
            // House size multiplier
            const sizeMultipliers = {
                'small': 0.8,
                'medium': 1.0,
                'large': 1.3
            };
            
            return (electricityEmissions + heatingEmissions) * sizeMultipliers[houseSize];
        }
        
        function calculateFoodEmissions(dietType, foodWaste, localFood) {
            // Base emissions by diet type (tons CO2 per year)
            const dietFactors = {
                'meat_heavy': 2.5,
                'average': 1.8,
                'vegetarian': 1.2,
                'vegan': 0.9
            };
            
            // Waste multiplier
            const wasteFactors = {
                'high': 1.3,
                'average': 1.0,
                'low': 0.8,
                'minimal': 0.6
            };
            
            // Local food reduction (0-20% reduction)
            const localReduction = localFood * 0.002;
            
            return dietFactors[dietType] * wasteFactors[foodWaste] * (1 - localReduction);
        }
        
        function calculateShoppingEmissions(clothingBudget, electronics, recycling) {
            // Clothing emissions ($1 ≈ 0.5 kg CO2)
            const clothingEmissions = clothingBudget * 12 * 0.0005;
            
            // Electronics multiplier
            const electronicsFactors = {
                'minimal': 0.1,
                'average': 0.3,
                'frequent': 0.7
            };
            
            const electronicsEmissions = electronicsFactors[electronics] * 0.5;
            
            // Recycling reduction
            const recyclingFactors = {
                'none': 1.0,
                'basic': 0.9,
                'comprehensive': 0.7,
                'zero_waste': 0.4
            };
            
            return (clothingEmissions + electronicsEmissions) * recyclingFactors[recycling];
        }
        
        function calculateReductionPotential(transport, home, food, shopping) {
            return {
                transport: transport * 0.6, // 60% reduction potential
                home: home * 0.4, // 40% reduction potential
                food: food * 0.5, // 50% reduction potential
                shopping: shopping * 0.7 // 70% reduction potential
            };
        }
        
        function updateResults(total, transport, home, food, shopping, other, reduction) {
            // Update main total
            document.getElementById('carbonTotal').textContent = total.toFixed(1);
            document.getElementById('carbonLabel').textContent = `metric tons of CO₂ equivalent annually`;
            
            // Update comparison values
            document.getElementById('usAverage').textContent = '16.0';
            document.getElementById('globalAverage').textContent = '4.6';
            document.getElementById('climateGoal').textContent = '2.0';
            
            // Update emission breakdown
            document.getElementById('transportEmissions').textContent = transport.toFixed(1) + ' t';
            document.getElementById('homeEmissions').textContent = home.toFixed(1) + ' t';
            document.getElementById('foodEmissions').textContent = food.toFixed(1) + ' t';
            document.getElementById('shoppingEmissions').textContent = shopping.toFixed(1) + ' t';
            document.getElementById('otherEmissions').textContent = other.toFixed(1) + ' t';
            
            // Update reduction potential
            document.getElementById('transportReduction').textContent = reduction.transport.toFixed(1) + ' t';
            document.getElementById('homeReduction').textContent = reduction.home.toFixed(1) + ' t';
            document.getElementById('foodReduction').textContent = reduction.food.toFixed(1) + ' t';
            document.getElementById('shoppingReduction').textContent = reduction.shopping.toFixed(1) + ' t';
            
            // Update offset costs
            document.getElementById('treeCost').textContent = '$' + Math.round(total * 10);
            document.getElementById('energyCost').textContent = '$' + Math.round(total * 15);
            document.getElementById('captureCost').textContent = '$' + Math.round(total * 50);
            document.getElementById('waterCost').textContent = '$' + Math.round(total * 12);
            
            // Update emission chart
            updateEmissionChart(transport, home, food, shopping, other, total);
        }
        
        function updateEmissionChart(transport, home, food, shopping, other, total) {
            const container = document.getElementById('emissionChart');
            container.innerHTML = '';
            
            const categories = [
                { name: 'Transportation', value: transport, color: '#e74c3c' },
                { name: 'Home Energy', value: home, color: '#3498db' },
                { name: 'Food & Diet', value: food, color: '#2ecc71' },
                { name: 'Shopping', value: shopping, color: '#f39c12' },
                { name: 'Other', value: other, color: '#9b59b6' }
            ];
            
            categories.forEach(category => {
                if (category.value > 0) {
                    const percentage = (category.value / total) * 100;
                    const bar = document.createElement('div');
                    bar.className = 'chart-bar';
                    bar.innerHTML = `
                        <div class="chart-label">${category.name}</div>
                        <div class="chart-bar-inner">
                            <div class="chart-bar-fill" style="width: ${percentage}%; background: ${category.color}"></div>
                        </div>
                        <div class="chart-percentage">${percentage.toFixed(1)}%</div>
                    `;
                    container.appendChild(bar);
                }
            });
        }
        
        function addToHistory(totalEmissions) {
            const timestamp = new Date().toLocaleString();
            calculationHistory.unshift({
                timestamp,
                total: totalEmissions
            });
            
            // Keep only last 10 calculations
            if (calculationHistory.length > 10) {
                calculationHistory = calculationHistory.slice(0, 10);
            }
        }
        
        function resetCalculator() {
            // Reset all inputs to default values
            document.getElementById('carMileage').value = '12000';
            document.getElementById('fuelEfficiency').value = '25';
            document.getElementById('flightHours').value = '5';
            document.getElementById('publicTransport').value = '20';
            document.getElementById('electricityUsage').value = '900';
            document.getElementById('heatingType').value = 'natural_gas';
            document.getElementById('heatingUsage').value = '80';
            document.getElementById('houseSize').value = 'medium';
            document.getElementById('dietType').value = 'average';
            document.getElementById('foodWaste').value = 'average';
            document.getElementById('localFood').value = '30';
            document.getElementById('localFoodValue').textContent = '30%';
            document.getElementById('clothingBudget').value = '150';
            document.getElementById('electronics').value = 'average';
            document.getElementById('recycling').value = 'comprehensive';
        }
        
        function saveResults() {
            const total = document.getElementById('carbonTotal').textContent;
            const transport = document.getElementById('transportEmissions').textContent;
            const home = document.getElementById('homeEmissions').textContent;
            
            let results = 'Carbon Footprint Analysis\n';
            results += 'Generated: ' + new Date().toLocaleString() + '\n\n';
            results += `Total Carbon Footprint: ${total} tons CO₂e\n`;
            results += `Transportation: ${transport}\n`;
            results += `Home Energy: ${home}\n\n`;
            results += 'Reduction recommendations and offset solutions provided.';
            
            const blob = new Blob([results], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'carbon-footprint-analysis.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        // Initialize calculator
        window.onload = function() {
            // Set initial slider value display
            document.getElementById('localFoodValue').textContent = document.getElementById('localFood').value + '%';
        };
    </script>
</body>
</html>
