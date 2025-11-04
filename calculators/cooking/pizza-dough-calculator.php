<?php
/**
 * Pizza Dough Calculator
 * File: cooking/pizza-dough-calculator.php
 * Description: Calculate perfect pizza dough ingredients and hydration levels for various pizza styles
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Dough Calculator - Perfect Dough Every Time</title>
    <meta name="description" content="Calculate precise pizza dough ingredients for Neapolitan, New York, Chicago, and other pizza styles. Get perfect hydration and fermentation times.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .pizza-style-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .style-card { background: #f8f9fa; padding: 20px; border-radius: 10px; cursor: pointer; transition: all 0.3s; border: 2px solid transparent; text-align: center; }
        .style-card:hover { transform: translateY(-2px); }
        .style-card.active { background: #ede7f6; border-color: #667eea; }
        .style-icon { font-size: 2rem; margin-bottom: 10px; }
        .style-name { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .style-desc { font-size: 0.8rem; color: #7f8c8d; }
        
        .controls-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .input-with-unit { display: flex; align-items: center; gap: 10px; }
        .input-with-unit input { flex: 1; }
        .unit-label { min-width: 60px; font-size: 0.9rem; color: #7f8c8d; font-weight: 600; }
        
        .hydration-control { margin-bottom: 20px; }
        .hydration-slider { width: 100%; margin: 10px 0; }
        .hydration-labels { display: flex; justify-content: space-between; font-size: 0.8rem; color: #7f8c8d; }
        
        .ingredients-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .ingredient-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; text-align: center; }
        .ingredient-card.highlight { background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); border-left-color: #4caf50; }
        .ingredient-value { font-size: 1.5rem; font-weight: bold; color: #5e35b1; margin-bottom: 5px; }
        .ingredient-card.highlight .ingredient-value { color: #2e7d32; }
        .ingredient-label { font-size: 0.85rem; color: #4527a0; font-weight: 600; }
        .ingredient-card.highlight .ingredient-label { color: #1b5e20; }
        .ingredient-note { font-size: 0.75rem; color: #7f8c8d; margin-top: 5px; }
        
        .dough-properties { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .dough-properties h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .properties-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .property-card { background: white; padding: 15px; border-radius: 8px; text-align: center; }
        .property-value { font-size: 1.2rem; font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .property-label { font-size: 0.8rem; color: #7f8c8d; }
        
        .fermentation-timeline { background: #fff3e0; padding: 25px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #ff9800; }
        .fermentation-timeline h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .timeline-steps { display: flex; justify-content: space-between; position: relative; }
        .timeline-step { display: flex; flex-direction: column; align-items: center; flex: 1; position: relative; }
        .step-circle { width: 40px; height: 40px; border-radius: 50%; background: #ff9800; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; font-weight: bold; color: white; }
        .step-label { font-size: 0.8rem; color: #7f8c8d; text-align: center; }
        .step-time { font-size: 0.9rem; font-weight: 600; color: #2c3e50; margin-top: 5px; }
        .step-desc { font-size: 0.75rem; color: #7f8c8d; text-align: center; margin-top: 3px; }
        
        .baker-percentage { background: #e8f5e8; padding: 25px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #4caf50; }
        .baker-percentage h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .percentage-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; }
        .percentage-item { background: white; padding: 15px; border-radius: 8px; text-align: center; }
        .percentage-value { font-size: 1.1rem; font-weight: bold; color: #2c3e50; }
        .percentage-label { font-size: 0.75rem; color: #7f8c8d; }
        
        .action-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .action-btn { padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3); }
        .action-btn.secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .action-btn.secondary:hover { border-color: #667eea; }
        
        .tips-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .tip-card { background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #2196f3; }
        .tip-icon { font-size: 1.5rem; margin-bottom: 10px; }
        .tip-title { font-weight: 600; color: #2c3e50; margin-bottom: 8px; }
        .tip-desc { font-size: 0.85rem; color: #555; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .pizza-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .pizza-table th, .pizza-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .pizza-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .pizza-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .controls-row { grid-template-columns: 1fr; }
            .pizza-style-grid { grid-template-columns: repeat(2, 1fr); }
            .ingredients-grid { grid-template-columns: repeat(2, 1fr); }
            .properties-grid { grid-template-columns: repeat(2, 1fr); }
            .timeline-steps { flex-direction: column; gap: 20px; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { grid-template-columns: 1fr; }
            .percentage-grid { grid-template-columns: repeat(3, 1fr); }
        }
        
        @media (max-width: 480px) {
            .pizza-style-grid { grid-template-columns: 1fr; }
            .ingredients-grid { grid-template-columns: 1fr; }
            .properties-grid { grid-template-columns: 1fr; }
            .calculator-card { padding: 20px; }
            .header { padding: 20px; }
            .tips-grid { grid-template-columns: 1fr; }
            .percentage-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍕 Pizza Dough Calculator</h1>
            <p>Calculate perfect pizza dough ingredients for Neapolitan, New York, Chicago, and other styles. Master hydration, fermentation, and baker's percentages.</p>
        </div>

        <div class="calculator-card">
            <div class="pizza-style-grid">
                <div class="style-card active" data-style="neapolitan">
                    <div class="style-icon">🇮🇹</div>
                    <div class="style-name">Neapolitan</div>
                    <div class="style-desc">Soft, elastic dough</div>
                </div>
                <div class="style-card" data-style="new_york">
                    <div class="style-icon">🗽</div>
                    <div class="style-name">New York</div>
                    <div class="style-desc">Thin, foldable crust</div>
                </div>
                <div class="style-card" data-style="chicago">
                    <div class="style-icon">🏙️</div>
                    <div class="style-name">Chicago Deep Dish</div>
                    <div class="style-desc">Thick, buttery crust</div>
                </div>
                <div class="style-card" data-style="sicilian">
                    <div class="style-icon">🍅</div>
                    <div class="style-name">Sicilian</div>
                    <div class="style-desc">Thick, rectangular</div>
                </div>
                <div class="style-card" data-style="detroit">
                    <div class="style-icon">🚗</div>
                    <div class="style-name">Detroit</div>
                    <div class="style-desc">Crispy, airy crust</div>
                </div>
                <div class="style-card" data-style="roman">
                    <div class="style-icon">🏛️</div>
                    <div class="style-name">Roman</div>
                    <div class="style-desc">Thin, cracker-like</div>
                </div>
            </div>
            
            <div class="controls-row">
                <div class="control-group">
                    <label for="pizzaCount">Number of Pizzas</label>
                    <input type="number" id="pizzaCount" value="2" min="1" max="10" step="1">
                </div>
                
                <div class="control-group">
                    <label for="pizzaSize">Pizza Size</label>
                    <div class="input-with-unit">
                        <input type="number" id="pizzaSize" value="12" min="8" max="18" step="1">
                        <div class="unit-label">inches</div>
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="doughThickness">Crust Thickness</label>
                    <select id="doughThickness">
                        <option value="thin">Thin Crust</option>
                        <option value="medium" selected>Medium Crust</option>
                        <option value="thick">Thick Crust</option>
                        <option value="extra_thick">Extra Thick</option>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label for="hydrationLevel">Dough Hydration Level</label>
                <input type="range" id="hydrationLevel" class="hydration-slider" min="55" max="80" value="65" step="0.5">
                <div class="hydration-labels">
                    <span>55% (Dry)</span>
                    <span>65% (Standard)</span>
                    <span>80% (Wet)</span>
                </div>
                <div class="unit-display" style="text-align: center; margin-top: 5px;">
                    Current: <span id="hydrationValue">65%</span> hydration
                </div>
            </div>
            
            <div class="controls-row">
                <div class="control-group">
                    <label for="fermentation">Fermentation Time</label>
                    <select id="fermentation">
                        <option value="quick">Quick (2-4 hours)</option>
                        <option value="standard" selected>Standard (12-24 hours)</option>
                        <option value="long">Long (48-72 hours)</option>
                        <option value="cold_ferment">Cold Ferment (3-5 days)</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label for="yeastType">Yeast Type</label>
                    <select id="yeastType">
                        <option value="instant">Instant Yeast</option>
                        <option value="active_dry" selected>Active Dry Yeast</option>
                        <option value="fresh">Fresh Yeast</option>
                        <option value="sourdough">Sourdough Starter</option>
                    </select>
                </div>
            </div>
            
            <div class="ingredients-grid">
                <div class="ingredient-card highlight">
                    <div class="ingredient-value" id="flourAmount">500g</div>
                    <div class="ingredient-label">BREAD FLOUR</div>
                    <div class="ingredient-note">High protein flour</div>
                </div>
                <div class="ingredient-card">
                    <div class="ingredient-value" id="waterAmount">325g</div>
                    <div class="ingredient-label">WATER</div>
                    <div class="ingredient-note">Lukewarm (90-100°F)</div>
                </div>
                <div class="ingredient-card">
                    <div class="ingredient-value" id="yeastAmount">3g</div>
                    <div class="ingredient-label">YEAST</div>
                    <div class="ingredient-note">Active dry yeast</div>
                </div>
                <div class="ingredient-card">
                    <div class="ingredient-value" id="saltAmount">10g</div>
                    <div class="ingredient-label">SALT</div>
                    <div class="ingredient-note">Fine sea salt</div>
                </div>
                <div class="ingredient-card">
                    <div class="ingredient-value" id="sugarAmount">5g</div>
                    <div class="ingredient-label">SUGAR</div>
                    <div class="ingredient-note">Optional for browning</div>
                </div>
                <div class="ingredient-card">
                    <div class="ingredient-value" id="oilAmount">15g</div>
                    <div class="ingredient-label">OLIVE OIL</div>
                    <div class="ingredient-note">Extra virgin</div>
                </div>
            </div>
            
            <div class="dough-properties">
                <h3>📊 Dough Properties</h3>
                <div class="properties-grid">
                    <div class="property-card">
                        <div class="property-value" id="totalDoughWeight">858g</div>
                        <div class="property-label">TOTAL DOUGH WEIGHT</div>
                    </div>
                    <div class="property-card">
                        <div class="property-value" id="doughBallWeight">429g</div>
                        <div class="property-label">DOUGH BALL WEIGHT</div>
                    </div>
                    <div class="property-card">
                        <div class="property-value" id="doughFactor">0.09</div>
                        <div class="property-label">DOUGH FACTOR (g/in²)</div>
                    </div>
                    <div class="property-card">
                        <div class="property-value" id="doughVolume">-</div>
                        <div class="property-label">ESTIMATED RISE</div>
                    </div>
                </div>
            </div>
            
            <div class="baker-percentage">
                <h3>🧮 Baker's Percentages</h3>
                <div class="percentage-grid">
                    <div class="percentage-item">
                        <div class="percentage-value">100%</div>
                        <div class="percentage-label">Flour</div>
                    </div>
                    <div class="percentage-item">
                        <div class="percentage-value" id="waterPercentage">65%</div>
                        <div class="percentage-label">Water</div>
                    </div>
                    <div class="percentage-item">
                        <div class="percentage-value" id="saltPercentage">2%</div>
                        <div class="percentage-label">Salt</div>
                    </div>
                    <div class="percentage-item">
                        <div class="percentage-value" id="yeastPercentage">0.6%</div>
                        <div class="percentage-label">Yeast</div>
                    </div>
                    <div class="percentage-item">
                        <div class="percentage-value" id="sugarPercentage">1%</div>
                        <div class="percentage-label">Sugar</div>
                    </div>
                    <div class="percentage-item">
                        <div class="percentage-value" id="oilPercentage">3%</div>
                        <div class="percentage-label">Oil</div>
                    </div>
                </div>
            </div>
            
            <div class="fermentation-timeline">
                <h3>⏰ Fermentation Timeline</h3>
                <div class="timeline-steps" id="timelineSteps">
                    <!-- Timeline steps will be generated here -->
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="action-btn" id="calculateBtn">
                    <span>🧮</span> Calculate Dough
                </button>
                <button class="action-btn secondary" id="resetBtn">
                    <span>🔄</span> Reset
                </button>
                <button class="action-btn secondary" id="switchUnitsBtn">
                    <span>⚖️</span> Switch to Ounces
                </button>
            </div>
            
            <div class="tips-grid" id="doughTips">
                <!-- Dough tips will be generated here -->
            </div>
        </div>

        <div class="info-section">
            <h2>🍕 Pizza Dough Science</h2>
            
            <p>Perfect pizza dough requires understanding the science behind flour, water, yeast, and fermentation. This calculator helps you master the art and science of pizza making.</p>

            <h3>🇮🇹 Pizza Style Characteristics</h3>
            <table class="pizza-table">
                <thead>
                    <tr>
                        <th>Style</th>
                        <th>Hydration</th>
                        <th>Thickness</th>
                        <th>Fermentation</th>
                        <th>Baking Temp</th>
                        <th>Key Features</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Neapolitan</td><td>60-65%</td><td>Thin center</td><td>8-24 hours</td><td>800-900°F</td><td>Soft, chewy, leopard spotting</td></tr>
                    <tr><td>New York</td><td>60-65%</td><td>Thin</td><td>24-48 hours</td><td>550-600°F</td><td>Foldable slice, crisp underside</td></tr>
                    <tr><td>Chicago Deep Dish</td><td>45-55%</td><td>Very thick</td><td>2-4 hours</td><td>425-475°F</td><td>Buttery crust, pan-baked</td></tr>
                    <tr><td>Sicilian</td><td>65-70%</td><td>Thick</td><td>2-6 hours</td><td>500-550°F</td><td>Rectangular, airy crumb</td></tr>
                    <tr><td>Detroit</td><td>70-75%</td><td>Medium-thick</td><td>12-24 hours</td><td>550-600°F</td><td>Crispy edges, Wisconsin brick cheese</td></tr>
                    <tr><td>Roman</td><td>50-55%</td><td>Very thin</td><td>24-72 hours</td><td>600-700°F</td><td>Cracker-like, minimal rise</td></tr>
                </tbody>
            </table>

            <h3>💧 Hydration Science</h3>
            <div class="formula-box">
                <strong>Hydration Percentage Formula:</strong><br>
                Hydration % = (Water Weight ÷ Flour Weight) × 100<br><br>
                
                <strong>Hydration Effects:</strong><br>
                • 55-60%: Firm dough, easier to handle, less open crumb<br>
                • 60-65%: Standard pizza dough, good balance<br>
                • 65-70%: Higher hydration, more open crumb, harder to handle<br>
                • 70-75%: Very wet dough, requires experience, excellent flavor<br>
                • 75-80%: Professional level, maximum flavor development
            </div>

            <h3>🌾 Flour Types & Protein Content</h3>
            <table class="pizza-table">
                <thead>
                    <tr>
                        <th>Flour Type</th>
                        <th>Protein Content</th>
                        <th>Best For</th>
                        <th>Water Absorption</th>
                        <th>Gluten Development</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Type 00</td><td>11-12%</td><td>Neapolitan pizza</td><td>Medium</td><td>Soft, elastic</td></tr>
                    <tr><td>Bread Flour</td><td>12-13%</td><td>New York style</td><td>High</td><td>Strong, chewy</td></tr>
                    <tr><td>All-Purpose</td><td>10-12%</td><td>General use</td><td>Medium</td><td>Moderate</td></tr>
                    <tr><td>Whole Wheat</td><td>13-14%</td><td>Healthier option</td><td>Very high</td><td>Dense, nutty</td></tr>
                    <tr><td>Caputo Pizzeria</td><td>12.5%</td><td>High-temperature</td><td>High</td><td>Excellent</td></tr>
                </tbody>
            </table>

            <h3>⏰ Fermentation & Proofing</h3>
            <ul>
                <li><strong>Bulk Fermentation:</strong> Initial rise of the entire dough mass</li>
                <li><strong>Cold Fermentation:</strong> Slower fermentation in refrigerator (develops flavor)</li>
                <li><strong>Proofing:</strong> Final rise after shaping dough balls</li>
                <li><strong>Yeast Activity:</strong> Doubles every hour at room temperature</li>
                <li><strong>Temperature Effect:</strong> Fermentation speed doubles every 18°F (10°C) increase</li>
            </ul>

            <h3>🧮 Baker's Percentage System</h3>
            <div class="formula-box">
                <strong>Standard Pizza Dough Formula:</strong><br>
                • Flour: 100% (base ingredient)<br>
                • Water: 60-65% (hydration)<br>
                • Salt: 2-3% (flavor, controls yeast)<br>
                • Yeast: 0.5-1% (leavening)<br>
                • Sugar: 0-2% (browning, yeast food)<br>
                • Oil: 1-3% (tenderness, flavor)<br><br>
                
                <strong>Calculation Example:</strong><br>
                500g flour × 65% hydration = 325g water<br>
                500g flour × 2% salt = 10g salt<br>
                500g flour × 0.6% yeast = 3g yeast
            </div>

            <h3>🔥 Baking Science</h3>
            <table class="pizza-table">
                <thead>
                    <tr>
                        <th>Oven Type</th>
                        <th>Temperature Range</th>
                        <th>Baking Time</th>
                        <th>Best For</th>
                        <th>Key Features</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Wood-fired</td><td>800-900°F</td><td>60-90 seconds</td><td>Neapolitan</td><td>Rapid rise, leopard spotting</td></tr>
                    <tr><td>Home Oven</td><td>500-550°F</td><td>8-12 minutes</td><td>New York, Detroit</td><td>Conventional baking</td></tr>
                    <tr><td>Pizza Stone</td><td>500-550°F</td><td>6-10 minutes</td><td>All styles</td><td>Crispy bottom crust</td></tr>
                    <tr><td>Pizza Steel</td><td>500-550°F</td><td>4-8 minutes</td><td>All styles</td><td>Superior heat transfer</td></tr>
                    <tr><td>Deck Oven</td><td>600-700°F</td><td>3-5 minutes</td><td>Commercial</td><td>Even bottom heat</td></tr>
                </tbody>
            </table>

            <h3>🎯 Dough Handling Techniques</h3>
            <ul>
                <li><strong>Autolyse:</strong> Rest flour and water before adding yeast and salt</li>
                <li><strong>Windowpane Test:</strong> Stretch dough to check gluten development</li>
                <li><strong>Stretch and Fold:</strong> Gentle technique for gluten development</li>
                <li><strong>Coil Fold:</strong> Advanced technique for high hydration doughs</li>
                <li><strong>Bench Rest:</strong> Allow dough to relax before shaping</li>
                <li><strong>Cold Proof:</strong> Develop flavor through slow fermentation</li>
            </ul>

            <h3>⚖️ Weight vs Volume Measurements</h3>
            <div class="formula-box">
                <strong>Why Weight Matters:</strong><br>
                • 1 cup flour ≈ 120-130g (varies by compaction)<br>
                • 1 cup water = 236g (consistent)<br>
                • 1 tsp instant yeast ≈ 3g<br>
                • 1 tsp salt ≈ 6g<br>
                • 1 tbsp olive oil ≈ 14g<br><br>
                
                <strong>Conversion Factors:</strong><br>
                1 ounce = 28.35 grams<br>
                1 pound = 453.59 grams<br>
                1 gram = 0.035 ounces
            </div>

            <h3>🔬 Food Science Principles</h3>
            <ul>
                <li><strong>Gluten Formation:</strong> Proteins gliadin and glutenin form gluten network</li>
                <strong>Enzyme Activity:</strong> Amylase breaks down starches into sugars for yeast</li>
                <li><strong>Maillard Reaction:</strong> Browning at 280-330°F creates flavor compounds</li>
                <li><strong>Gelatinization:</strong> Starch granules swell and absorb water at 140-180°F</li>
                <li><strong>Oven Spring:</strong> Rapid rise in first minutes of baking</li>
            </ul>

            <h3>⚠️ Common Problems & Solutions</h3>
            <table class="pizza-table">
                <thead>
                    <tr>
                        <th>Problem</th>
                        <th>Causes</th>
                        <th>Solutions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Tough Crust</td><td>Over-kneading, low hydration</td><td>Reduce kneading, increase hydration</td></tr>
                    <tr><td>Dense Crumb</td><td>Under-proofing, old yeast</td><td>Longer proof, fresh yeast</td></tr>
                    <tr><td>Bland Flavor</td><td>Short fermentation, low salt</td><td>Cold ferment, adjust salt</td></tr>
                    <tr><td>Sticky Dough</td><td>High hydration, warm environment</td><td>Bench flour, cold ferment</td></tr>
                    <tr><td>No Oven Spring</td><td>Over-proofing, low oven temp</td><td>Shorter proof, preheat properly</td></tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>🍕 Professional Pizza Dough Calculator | Perfect Crust Every Time</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate ingredients, hydration levels, and fermentation times for various pizza styles</p>
        </div>
    </div>

    <script>
        // DOM elements
        const styleCards = document.querySelectorAll('.style-card');
        const pizzaCount = document.getElementById('pizzaCount');
        const pizzaSize = document.getElementById('pizzaSize');
        const doughThickness = document.getElementById('doughThickness');
        const hydrationLevel = document.getElementById('hydrationLevel');
        const hydrationValue = document.getElementById('hydrationValue');
        const fermentation = document.getElementById('fermentation');
        const yeastType = document.getElementById('yeastType');
        const calculateBtn = document.getElementById('calculateBtn');
        const resetBtn = document.getElementById('resetBtn');
        const switchUnitsBtn = document.getElementById('switchUnitsBtn');
        const flourAmount = document.getElementById('flourAmount');
        const waterAmount = document.getElementById('waterAmount');
        const yeastAmount = document.getElementById('yeastAmount');
        const saltAmount = document.getElementById('saltAmount');
        const sugarAmount = document.getElementById('sugarAmount');
        const oilAmount = document.getElementById('oilAmount');
        const totalDoughWeight = document.getElementById('totalDoughWeight');
        const doughBallWeight = document.getElementById('doughBallWeight');
        const doughFactor = document.getElementById('doughFactor');
        const doughVolume = document.getElementById('doughVolume');
        const waterPercentage = document.getElementById('waterPercentage');
        const saltPercentage = document.getElementById('saltPercentage');
        const yeastPercentage = document.getElementById('yeastPercentage');
        const sugarPercentage = document.getElementById('sugarPercentage');
        const oilPercentage = document.getElementById('oilPercentage');
        const timelineSteps = document.getElementById('timelineSteps');
        const doughTips = document.getElementById('doughTips');

        // Pizza style database
        const pizzaStyles = {
            neapolitan: {
                name: 'Neapolitan',
                baseFlour: 250,
                hydration: 65,
                salt: 2.5,
                yeast: 0.6,
                sugar: 0,
                oil: 1,
                thicknessFactor: 0.08,
                fermentation: 'standard'
            },
            new_york: {
                name: 'New York',
                baseFlour: 250,
                hydration: 63,
                salt: 2.2,
                yeast: 0.5,
                sugar: 1,
                oil: 2,
                thicknessFactor: 0.07,
                fermentation: 'long'
            },
            chicago: {
                name: 'Chicago Deep Dish',
                baseFlour: 250,
                hydration: 55,
                salt: 2.8,
                yeast: 1.2,
                sugar: 2,
                oil: 8,
                thicknessFactor: 0.15,
                fermentation: 'quick'
            },
            sicilian: {
                name: 'Sicilian',
                baseFlour: 250,
                hydration: 68,
                salt: 2.3,
                yeast: 0.8,
                sugar: 1,
                oil: 3,
                thicknessFactor: 0.12,
                fermentation: 'standard'
            },
            detroit: {
                name: 'Detroit',
                baseFlour: 250,
                hydration: 72,
                salt: 2.4,
                yeast: 0.7,
                sugar: 1,
                oil: 4,
                thicknessFactor: 0.10,
                fermentation: 'standard'
            },
            roman: {
                name: 'Roman',
                baseFlour: 250,
                hydration: 58,
                salt: 2.6,
                yeast: 0.4,
                sugar: 0.5,
                oil: 1,
                thicknessFactor: 0.05,
                fermentation: 'long'
            }
        };

        // Current state
        let currentStyle = 'neapolitan';
        let isMetric = true;

        // Initialize
        setupEventListeners();
        updateHydrationDisplay();
        calculateDough();

        function setupEventListeners() {
            // Style cards
            styleCards.forEach(card => {
                card.addEventListener('click', function() {
                    styleCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    currentStyle = this.dataset.style;
                    loadStyleSettings();
                    calculateDough();
                });
            });

            // Hydration slider
            hydrationLevel.addEventListener('input', updateHydrationDisplay);
            
            // Calculate button
            calculateBtn.addEventListener('click', calculateDough);
            
            // Reset button
            resetBtn.addEventListener('click', resetCalculator);
            
            // Switch units button
            switchUnitsBtn.addEventListener('click', switchUnits);
            
            // Input listeners
            pizzaCount.addEventListener('input', calculateDough);
            pizzaSize.addEventListener('input', calculateDough);
            doughThickness.addEventListener('change', calculateDough);
            hydrationLevel.addEventListener('input', calculateDough);
            fermentation.addEventListener('change', calculateDough);
            yeastType.addEventListener('change', calculateDough);
        }

        function updateHydrationDisplay() {
            hydrationValue.textContent = `${hydrationLevel.value}%`;
        }

        function loadStyleSettings() {
            const style = pizzaStyles[currentStyle];
            hydrationLevel.value = style.hydration;
            updateHydrationDisplay();
        }

        function calculateDough() {
            const count = parseInt(pizzaCount.value);
            const size = parseInt(pizzaSize.value);
            const thickness = doughThickness.value;
            const hydration = parseFloat(hydrationLevel.value);
            const fermentType = fermentation.value;
            const yeast = yeastType.value;
            
            // Get base amounts from style
            const style = pizzaStyles[currentStyle];
            
            // Calculate flour based on pizza size and count
            const area = Math.PI * Math.pow(size / 2, 2);
            let thicknessMultiplier = 1;
            
            switch(thickness) {
                case 'thin': thicknessMultiplier = 0.7; break;
                case 'medium': thicknessMultiplier = 1.0; break;
                case 'thick': thicknessMultiplier = 1.3; break;
                case 'extra_thick': thicknessMultiplier = 1.6; break;
            }
            
            const totalFlour = Math.round(style.baseFlour * (size / 12) * thicknessMultiplier * count);
            
            // Calculate other ingredients based on baker's percentages
            const water = Math.round(totalFlour * (hydration / 100));
            const salt = Math.round(totalFlour * (style.salt / 100));
            const sugar = Math.round(totalFlour * (style.sugar / 100));
            const oil = Math.round(totalFlour * (style.oil / 100));
            
            // Adjust yeast based on fermentation time and type
            let yeastMultiplier = 1;
            switch(fermentType) {
                case 'quick': yeastMultiplier = 2.0; break;
                case 'standard': yeastMultiplier = 1.0; break;
                case 'long': yeastMultiplier = 0.5; break;
                case 'cold_ferment': yeastMultiplier = 0.3; break;
            }
            
            // Adjust for yeast type
            switch(yeast) {
                case 'instant': yeastMultiplier *= 1.0; break;
                case 'active_dry': yeastMultiplier *= 1.2; break;
                case 'fresh': yeastMultiplier *= 3.0; break;
                case 'sourdough': yeastMultiplier *= 0.2; break;
            }
            
            const yeastAmountValue = Math.round(totalFlour * (style.yeast / 100) * yeastMultiplier * 10) / 10;
            
            // Calculate totals
            const totalWeight = totalFlour + water + salt + sugar + oil + yeastAmountValue;
            const ballWeight = Math.round(totalWeight / count);
            const doughFactorValue = (ballWeight / area).toFixed(3);
            
            // Update display
            if (isMetric) {
                flourAmount.textContent = `${totalFlour}g`;
                waterAmount.textContent = `${water}g`;
                yeastAmount.textContent = `${yeastAmountValue}g`;
                saltAmount.textContent = `${salt}g`;
                sugarAmount.textContent = `${sugar}g`;
                oilAmount.textContent = `${oil}g`;
                totalDoughWeight.textContent = `${Math.round(totalWeight)}g`;
                doughBallWeight.textContent = `${ballWeight}g`;
            } else {
                flourAmount.textContent = `${gramsToOunces(totalFlour).toFixed(1)} oz`;
                waterAmount.textContent = `${gramsToOunces(water).toFixed(1)} oz`;
                yeastAmount.textContent = `${gramsToOunces(yeastAmountValue).toFixed(1)} oz`;
                saltAmount.textContent = `${gramsToOunces(salt).toFixed(1)} oz`;
                sugarAmount.textContent = `${gramsToOunces(sugar).toFixed(1)} oz`;
                oilAmount.textContent = `${gramsToOunces(oil).toFixed(1)} oz`;
                totalDoughWeight.textContent = `${gramsToOunces(totalWeight).toFixed(1)} oz`;
                doughBallWeight.textContent = `${gramsToOunces(ballWeight).toFixed(1)} oz`;
            }
            
            doughFactor.textContent = doughFactorValue;
            doughVolume.textContent = getDoughVolumeDescription(fermentType);
            
            // Update baker's percentages
            waterPercentage.textContent = `${hydration}%`;
            saltPercentage.textContent = `${style.salt}%`;
            yeastPercentage.textContent = `${(style.yeast * yeastMultiplier).toFixed(1)}%`;
            sugarPercentage.textContent = `${style.sugar}%`;
            oilPercentage.textContent = `${style.oil}%`;
            
            // Generate timeline
            generateTimeline(fermentType);
            
            // Generate tips
            generateDoughTips();
        }

        function gramsToOunces(grams) {
            return grams * 0.035274;
        }

        function ouncesToGrams(ounces) {
            return ounces * 28.3495;
        }

        function getDoughVolumeDescription(fermentType) {
            switch(fermentType) {
                case 'quick': return 'Small rise';
                case 'standard': return 'Good rise';
                case 'long': return 'Large rise';
                case 'cold_ferment': return 'Excellent rise';
                default: return 'Standard rise';
            }
        }

        function generateTimeline(fermentType) {
            let steps = [];
            
            switch(fermentType) {
                case 'quick':
                    steps = [
                        { time: '0:00', desc: 'Mix ingredients' },
                        { time: '1:00', desc: 'Bulk ferment' },
                        { time: '2:00', desc: 'Divide & shape' },
                        { time: '3:00', desc: 'Final proof' },
                        { time: '4:00', desc: 'Bake pizza' }
                    ];
                    break;
                case 'standard':
                    steps = [
                        { time: 'Day 1 - 9:00', desc: 'Mix ingredients' },
                        { time: 'Day 1 - 21:00', desc: 'Bulk ferment' },
                        { time: 'Day 2 - 9:00', desc: 'Divide & shape' },
                        { time: 'Day 2 - 17:00', desc: 'Final proof' },
                        { time: 'Day 2 - 18:00', desc: 'Bake pizza' }
                    ];
                    break;
                case 'long':
                    steps = [
                        { time: 'Day 1 - 9:00', desc: 'Mix ingredients' },
                        { time: 'Day 2 - 21:00', desc: 'Bulk ferment' },
                        { time: 'Day 3 - 9:00', desc: 'Divide & shape' },
                        { time: 'Day 3 - 17:00', desc: 'Final proof' },
                        { time: 'Day 3 - 18:00', desc: 'Bake pizza' }
                    ];
                    break;
                case 'cold_ferment':
                    steps = [
                        { time: 'Day 1 - 9:00', desc: 'Mix ingredients' },
                        { time: 'Day 2 - 9:00', desc: 'Cold bulk ferment' },
                        { time: 'Day 4 - 9:00', desc: 'Divide & shape' },
                        { time: 'Day 4 - 17:00', desc: 'Final proof' },
                        { time: 'Day 4 - 18:00', desc: 'Bake pizza' }
                    ];
                    break;
            }
            
            timelineSteps.innerHTML = steps.map((step, index) => `
                <div class="timeline-step">
                    <div class="step-circle">${index + 1}</div>
                    <div class="step-time">${step.time}</div>
                    <div class="step-desc">${step.desc}</div>
                </div>
            `).join('');
        }

        function generateDoughTips() {
            const tips = [
                {
                    icon: '💧',
                    title: 'Water Temperature',
                    desc: 'Use lukewarm water (90-100°F) for optimal yeast activity and gluten development.'
                },
                {
                    icon: '⏰',
                    title: 'Be Patient',
                    desc: 'Longer fermentation develops better flavor. Cold fermentation is worth the wait!'
                },
                {
                    icon: '👐',
                    title: 'Handle Gently',
                    desc: 'Avoid over-kneading. Gentle folding develops gluten without toughening the dough.'
                },
                {
                    icon: '🌡️',
                    title: 'Temperature Control',
                    desc: 'Dough temperature affects fermentation speed. Ideal dough temp is 75-78°F.'
                }
            ];
            
            doughTips.innerHTML = tips.map(tip => `
                <div class="tip-card">
                    <div class="tip-icon">${tip.icon}</div>
                    <div class="tip-title">${tip.title}</div>
                    <div class="tip-desc">${tip.desc}</div>
                </div>
            `).join('');
        }

        function resetCalculator() {
            pizzaCount.value = 2;
            pizzaSize.value = 12;
            doughThickness.value = 'medium';
            fermentation.value = 'standard';
            yeastType.value = 'active_dry';
            
            // Reset to first style
            styleCards[0].click();
            calculateDough();
        }

        function switchUnits() {
            isMetric = !isMetric;
            switchUnitsBtn.innerHTML = isMetric ? 
                '<span>⚖️</span> Switch to Ounces' : 
                '<span>⚖️</span> Switch to Grams';
            calculateDough();
        }

        // Initialize calculation
        calculateDough();
    </script>
</body>
</html>
