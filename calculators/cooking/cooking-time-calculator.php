<?php
/**
 * Cooking Time Calculator
 * File: cooking/cooking-time-calculator.php
 * Description: Calculate cooking times for various foods based on weight, cooking method, and preferences
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cooking Time Calculator - Perfect Cooking Times Every Time</title>
    <meta name="description" content="Calculate precise cooking times for meats, vegetables, baked goods and more. Get perfect results with temperature and doneness adjustments.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .food-selection { margin-bottom: 25px; }
        .food-categories { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; margin-bottom: 20px; }
        .category-btn { padding: 15px; background: #f8f9fa; border: 2px solid #e0e0e0; border-radius: 10px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .category-btn:hover { border-color: #667eea; }
        .category-btn.active { background: #667eea; color: white; border-color: #667eea; }
        .category-icon { font-size: 1.5rem; margin-bottom: 5px; }
        .category-name { font-size: 0.9rem; font-weight: 600; }
        
        .food-items { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; }
        .food-item { padding: 15px; background: #f8f9fa; border-radius: 8px; cursor: pointer; transition: all 0.3s; border: 2px solid transparent; }
        .food-item:hover { border-color: #667eea; }
        .food-item.active { background: #ede7f6; border-color: #667eea; }
        .food-name { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .food-desc { font-size: 0.8rem; color: #7f8c8d; }
        
        .controls-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .input-with-unit { display: flex; align-items: center; gap: 10px; }
        .input-with-unit input { flex: 1; }
        .unit-label { min-width: 60px; font-size: 0.9rem; color: #7f8c8d; font-weight: 600; }
        
        .doneness-controls { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 10px; }
        .doneness-btn { padding: 12px; background: #f8f9fa; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .doneness-btn:hover { border-color: #667eea; }
        .doneness-btn.active { background: #667eea; color: white; border-color: #667eea; }
        
        .cooking-methods { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; margin-bottom: 20px; }
        .method-btn { padding: 15px; background: #f8f9fa; border: 2px solid #e0e0e0; border-radius: 10px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .method-btn:hover { border-color: #667eea; }
        .method-btn.active { background: #667eea; color: white; border-color: #667eea; }
        .method-icon { font-size: 1.5rem; margin-bottom: 5px; }
        .method-name { font-size: 0.9rem; font-weight: 600; }
        
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .result-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; text-align: center; }
        .result-card.highlight { background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); border-left-color: #4caf50; }
        .result-card.warning { background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); border-left-color: #ff9800; }
        .result-value { font-size: 1.5rem; font-weight: bold; color: #5e35b1; margin-bottom: 5px; }
        .result-card.highlight .result-value { color: #2e7d32; }
        .result-card.warning .result-value { color: #ef6c00; }
        .result-label { font-size: 0.85rem; color: #4527a0; font-weight: 600; }
        .result-card.highlight .result-label { color: #1b5e20; }
        .result-card.warning .result-label { color: #e65100; }
        .result-note { font-size: 0.75rem; color: #7f8c8d; margin-top: 5px; }
        
        .timeline { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .timeline h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .timeline-steps { display: flex; justify-content: space-between; position: relative; }
        .timeline-step { display: flex; flex-direction: column; align-items: center; flex: 1; position: relative; }
        .step-circle { width: 40px; height: 40px; border-radius: 50%; background: #e0e0e0; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; font-weight: bold; color: white; }
        .step-circle.active { background: #667eea; }
        .step-circle.completed { background: #4caf50; }
        .step-label { font-size: 0.8rem; color: #7f8c8d; text-align: center; }
        .step-time { font-size: 0.9rem; font-weight: 600; color: #2c3e50; margin-top: 5px; }
        
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
        
        .cooking-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .cooking-table th, .cooking-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .cooking-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .cooking-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .controls-row { grid-template-columns: 1fr; }
            .food-categories { grid-template-columns: repeat(3, 1fr); }
            .food-items { grid-template-columns: repeat(2, 1fr); }
            .results-grid { grid-template-columns: repeat(2, 1fr); }
            .timeline-steps { flex-direction: column; gap: 20px; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { grid-template-columns: 1fr; }
            .cooking-methods { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (max-width: 480px) {
            .food-categories { grid-template-columns: repeat(2, 1fr); }
            .food-items { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .calculator-card { padding: 20px; }
            .header { padding: 20px; }
            .tips-grid { grid-template-columns: 1fr; }
            .doneness-controls { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⏰ Cooking Time Calculator</h1>
            <p>Calculate perfect cooking times for meats, vegetables, baked goods and more. Get precise results based on weight, method, and doneness preferences.</p>
        </div>

        <div class="calculator-card">
            <div class="food-selection">
                <div class="food-categories">
                    <div class="category-btn active" data-category="meat">
                        <div class="category-icon">🍖</div>
                        <div class="category-name">Meat</div>
                    </div>
                    <div class="category-btn" data-category="poultry">
                        <div class="category-icon">🍗</div>
                        <div class="category-name">Poultry</div>
                    </div>
                    <div class="category-btn" data-category="seafood">
                        <div class="category-icon">🐟</div>
                        <div class="category-name">Seafood</div>
                    </div>
                    <div class="category-btn" data-category="vegetables">
                        <div class="category-icon">🥦</div>
                        <div class="category-name">Vegetables</div>
                    </div>
                    <div class="category-btn" data-category="baked">
                        <div class="category-icon">🍞</div>
                        <div class="category-name">Baked Goods</div>
                    </div>
                </div>
                
                <div class="food-items" id="foodItems">
                    <!-- Food items will be populated here -->
                </div>
            </div>
            
            <div class="controls-row">
                <div class="control-group">
                    <label for="foodWeight">Weight/Quantity</label>
                    <div class="input-with-unit">
                        <input type="number" id="foodWeight" value="1" min="0.1" step="0.1">
                        <div class="unit-label" id="weightUnit">lbs</div>
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="thickness">Thickness</label>
                    <div class="input-with-unit">
                        <input type="number" id="thickness" value="1" min="0.1" step="0.1">
                        <div class="unit-label" id="thicknessUnit">inches</div>
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="startTemp">Starting Temperature</label>
                    <select id="startTemp">
                        <option value="frozen">Frozen</option>
                        <option value="refrigerated" selected>Refrigerated</option>
                        <option value="room_temp">Room Temperature</option>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label>Cooking Method</label>
                <div class="cooking-methods">
                    <div class="method-btn active" data-method="oven">
                        <div class="method-icon">🔥</div>
                        <div class="method-name">Oven</div>
                    </div>
                    <div class="method-btn" data-method="grill">
                        <div class="method-icon">🍖</div>
                        <div class="method-name">Grill</div>
                    </div>
                    <div class="method-btn" data-method="stovetop">
                        <div class="method-icon">🍳</div>
                        <div class="method-name">Stovetop</div>
                    </div>
                    <div class="method-btn" data-method="slow_cooker">
                        <div class="method-icon">🍲</div>
                        <div class="method-name">Slow Cooker</div>
                    </div>
                    <div class="method-btn" data-method="air_fryer">
                        <div class="method-icon">💨</div>
                        <div class="method-name">Air Fryer</div>
                    </div>
                </div>
            </div>
            
            <div class="controls-row">
                <div class="control-group">
                    <label for="cookingTemp">Cooking Temperature</label>
                    <div class="input-with-unit">
                        <input type="number" id="cookingTemp" value="350" min="200" max="500" step="25">
                        <div class="unit-label">°F</div>
                    </div>
                </div>
                
                <div class="control-group">
                    <label>Doneness Level</label>
                    <div class="doneness-controls" id="donenessControls">
                        <!-- Doneness buttons will be populated here -->
                    </div>
                </div>
            </div>
            
            <div class="results-grid">
                <div class="result-card highlight">
                    <div class="result-value" id="totalTime">0:00</div>
                    <div class="result-label">TOTAL COOKING TIME</div>
                    <div class="result-note" id="timeNote">Estimated</div>
                </div>
                <div class="result-card">
                    <div class="result-value" id="internalTemp">-</div>
                    <div class="result-label">TARGET INTERNAL TEMP</div>
                    <div class="result-note">Safe minimum</div>
                </div>
                <div class="result-card">
                    <div class="result-value" id="restTime">0 min</div>
                    <div class="result-label">RESTING TIME</div>
                    <div class="result-note">After cooking</div>
                </div>
                <div class="result-card">
                    <div class="result-value" id="calories">-</div>
                    <div class="result-label">ESTIMATED CALORIES</div>
                    <div class="result-note">Per serving</div>
                </div>
            </div>
            
            <div class="timeline">
                <h3>📋 Cooking Timeline</h3>
                <div class="timeline-steps" id="timelineSteps">
                    <!-- Timeline steps will be generated here -->
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="action-btn" id="calculateBtn">
                    <span>🧮</span> Calculate Cooking Time
                </button>
                <button class="action-btn secondary" id="resetBtn">
                    <span>🔄</span> Reset
                </button>
                <button class="action-btn secondary" id="timerBtn">
                    <span>⏱️</span> Start Timer
                </button>
            </div>
            
            <div class="tips-grid" id="cookingTips">
                <!-- Cooking tips will be generated here -->
            </div>
        </div>

        <div class="info-section">
            <h2>🔥 Cooking Time Science</h2>
            
            <p>Cooking time calculations involve complex thermal dynamics, but understanding the basic principles can help you achieve perfect results every time.</p>

            <h3>🥩 Meat Cooking Guidelines</h3>
            <table class="cooking-table">
                <thead>
                    <tr>
                        <th>Meat Type</th>
                        <th>Doneness</th>
                        <th>Internal Temp</th>
                        <th>Time per lb (Oven)</th>
                        <th>Rest Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Beef Roast</td><td>Rare</td><td>120-125°F</td><td>15-20 min</td><td>15-20 min</td></tr>
                    <tr><td>Beef Roast</td><td>Medium</td><td>130-135°F</td><td>18-22 min</td><td>15-20 min</td></tr>
                    <tr><td>Beef Roast</td><td>Well</td><td>145°F+</td><td>20-25 min</td><td>15-20 min</td></tr>
                    <tr><td>Pork Roast</td><td>Medium</td><td>145°F</td><td>20-25 min</td><td>10-15 min</td></tr>
                    <tr><td>Pork Roast</td><td>Well</td><td>160°F</td><td>25-30 min</td><td>10-15 min</td></tr>
                    <tr><td>Whole Chicken</td><td>Done</td><td>165°F</td><td>20-25 min</td><td>15-20 min</td></tr>
                    <tr><td>Turkey</td><td>Done</td><td>165°F</td><td>13-15 min</td><td>30-45 min</td></tr>
                </tbody>
            </table>

            <h3>🌡️ Temperature Science</h3>
            <div class="formula-box">
                <strong>Heat Transfer Principles:</strong><br>
                • Conduction: Direct heat transfer (pan frying)<br>
                • Convection: Heat through fluid motion (oven, boiling)<br>
                • Radiation: Infrared heat transfer (grilling, broiling)<br><br>
                
                <strong>Critical Temperatures:</strong><br>
                • 40-140°F: Danger zone (bacterial growth)<br>
                • 145°F: Medium rare beef, pork safe temperature<br>
                • 160°F: Ground meats safe temperature<br>
                • 165°F: Poultry safe temperature<br>
                • 212°F: Water boiling point
            </div>

            <h3>🍗 Poultry Safety Standards</h3>
            <table class="cooking-table">
                <thead>
                    <tr>
                        <th>Poultry Type</th>
                        <th>Minimum Safe Temp</th>
                        <th>Carryover Cooking</th>
                        <th>Resting Time</th>
                        <th>Special Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Chicken Breast</td><td>165°F</td><td>5-10°F</td><td>5-10 min</td><td>Cook to 160°F, rest to 165°F</td></tr>
                    <tr><td>Chicken Thighs</td><td>165°F</td><td>5-10°F</td><td>5-10 min</td><td>More forgiving, can go higher</td></tr>
                    <tr><td>Whole Chicken</td><td>165°F</td><td>10-15°F</td><td>15-20 min</td><td>Check thigh joint for doneness</td></tr>
                    <tr><td>Turkey Breast</td><td>165°F</td><td>10-15°F</td><td>20-30 min</td><td>Brining recommended</td></tr>
                    <tr><td>Duck Breast</td><td>135°F (med-rare)</td><td>5-10°F</td><td>10 min</td><td>Score skin, render fat</td></tr>
                </tbody>
            </table>

            <h3>🐟 Seafood Cooking</h3>
            <ul>
                <li><strong>Fish Fillets:</strong> 10 minutes per inch thickness at 450°F</li>
                <li><strong>Whole Fish:</strong> 15-20 minutes per pound at 400°F</li>
                <li><strong>Shrimp:</strong> 2-3 minutes until pink and opaque</li>
                <li><strong>Scallops:</strong> 2-3 minutes per side until golden</li>
                <li><strong>Lobster:</strong> 12-15 minutes for 1-1.5 lb lobster</li>
                <li><strong>Salmon:</strong> 4-6 minutes per ½ inch thickness</li>
            </ul>

            <h3>🥦 Vegetable Cooking Times</h3>
            <table class="cooking-table">
                <thead>
                    <tr>
                        <th>Vegetable</th>
                        <th>Boiling</th>
                        <th>Steaming</th>
                        <th>Roasting</th>
                        <th>Sautéing</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Broccoli Florets</td><td>5-7 min</td><td>6-8 min</td><td>15-20 min</td><td>5-7 min</td></tr>
                    <tr><td>Carrots (sliced)</td><td>8-10 min</td><td>10-12 min</td><td>20-25 min</td><td>7-10 min</td></tr>
                    <tr><td>Potatoes (cubed)</td><td>10-12 min</td><td>12-15 min</td><td>25-30 min</td><td>15-20 min</td></tr>
                    <tr><td>Asparagus</td><td>3-5 min</td><td>4-6 min</td><td>10-15 min</td><td>5-8 min</td></tr>
                    <tr><td>Green Beans</td><td>4-6 min</td><td>5-7 min</td><td>15-20 min</td><td>6-8 min</td></tr>
                </tbody>
            </table>

            <h3>🍞 Baked Goods Timing</h3>
            <div class="formula-box">
                <strong>Baking Fundamentals:</strong><br>
                • Oven spring: Initial rapid rise in first 10-15 minutes<br>
                • Carryover baking: Items continue cooking out of oven<br>
                • Internal temperature: Bread done at 190-210°F<br>
                • Visual cues: Golden brown color, hollow sound when tapped<br><br>
                
                <strong>Common Baking Times:</strong><br>
                • Cookies: 8-12 minutes at 350°F<br>
                • Muffins: 18-25 minutes at 375°F<br>
                • Bread loaves: 30-45 minutes at 375°F<br>
                • Cakes: 25-35 minutes at 350°F
            </div>

            <h3>⚡ Cooking Method Variations</h3>
            <ul>
                <li><strong>Convection Oven:</strong> Reduce temperature by 25°F or time by 25%</li>
                <li><strong>Air Fryer:</strong> Reduce temperature by 25°F and time by 20%</li>
                <li><strong>Slow Cooker:</strong> Low: 7-8 hours, High: 3-4 hours</li>
                <li><strong>Pressure Cooker:</strong> Reduce time by 60-70% compared to conventional</li>
                <li><strong>Grill:</strong> Direct heat: quick cooking, Indirect heat: slower roasting</li>
            </ul>

            <h3>🎯 Precision Cooking Tips</h3>
            <table class="cooking-table">
                <thead>
                    <tr>
                        <th>Technique</th>
                        <th>Purpose</th>
                        <th>Application</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Brining</td><td>Moisture retention</td><td>Poultry, pork chops</td></tr>
                    <tr><td>Resting Meat</td><td>Juice redistribution</td><td>All meats after cooking</td></tr>
                    <tr><td>Carryover Cooking</td><td>Even doneness</td><td>Large roasts, whole birds</td></tr>
                    <tr><td>Thermometer Use</td><td>Precision doneness</td><td>All protein cooking</td></tr>
                    <tr><td>Room Temp Start</td><td>Even cooking</td><td>Meats, baked goods</td></tr>
                </tbody>
            </table>

            <h3>🌡️ Altitude Adjustments</h3>
            <ul>
                <li><strong>High Altitude (3000+ ft):</strong> Increase baking temperature by 15-25°F</li>
                <li><strong>Boiling Point:</strong> Decreases approximately 1°F per 500 ft elevation</li>
                <strong>Cooking Time:</strong> Increase by 25% for every 1500 ft above 3000 ft</li>
                <li><strong>Baking:</strong> May need additional liquid and less leavening</li>
            </ul>

            <h3>⚠️ Food Safety Guidelines</h3>
            <div class="formula-box">
                <strong>Critical Safety Rules:</strong><br>
                • Danger Zone: 40°F - 140°F (keep food out of this range)<br>
                • 2-Hour Rule: Discard food left at room temperature >2 hours<br>
                • Proper Thawing: Refrigerator, cold water, or microwave only<br>
                • Cross-Contamination: Use separate cutting boards for raw meats<br>
                • Hand Washing: 20 seconds with soap before and after handling food
            </div>
        </div>

        <div class="footer">
            <p>⏰ Professional Cooking Time Calculator | Perfect Results Every Time</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate precise cooking times for meats, poultry, seafood, vegetables and baked goods</p>
        </div>
    </div>

    <script>
        // DOM elements
        const foodItems = document.getElementById('foodItems');
        const foodWeight = document.getElementById('foodWeight');
        const thickness = document.getElementById('thickness');
        const startTemp = document.getElementById('startTemp');
        const cookingTemp = document.getElementById('cookingTemp');
        const donenessControls = document.getElementById('donenessControls');
        const calculateBtn = document.getElementById('calculateBtn');
        const resetBtn = document.getElementById('resetBtn');
        const timerBtn = document.getElementById('timerBtn');
        const totalTime = document.getElementById('totalTime');
        const internalTemp = document.getElementById('internalTemp');
        const restTime = document.getElementById('restTime');
        const calories = document.getElementById('calories');
        const timeNote = document.getElementById('timeNote');
        const timelineSteps = document.getElementById('timelineSteps');
        const cookingTips = document.getElementById('cookingTips');
        const categoryBtns = document.querySelectorAll('.category-btn');
        const methodBtns = document.querySelectorAll('.method-btn');

        // Food database
        const foodDatabase = {
            meat: [
                { id: 'beef_roast', name: 'Beef Roast', desc: 'Prime rib, chuck roast, etc.', unit: 'lbs', baseTime: 20, calories: 250 },
                { id: 'beef_steak', name: 'Beef Steak', desc: 'Ribeye, sirloin, filet', unit: 'inches', baseTime: 8, calories: 300 },
                { id: 'pork_roast', name: 'Pork Roast', desc: 'Pork loin, shoulder', unit: 'lbs', baseTime: 25, calories: 200 },
                { id: 'pork_chops', name: 'Pork Chops', desc: 'Bone-in or boneless', unit: 'inches', baseTime: 10, calories: 250 },
                { id: 'lamb_roast', name: 'Lamb Roast', desc: 'Leg of lamb, rack', unit: 'lbs', baseTime: 18, calories: 280 },
                { id: 'ground_beef', name: 'Ground Beef', desc: 'Burgers, meatloaf', unit: 'inches', baseTime: 12, calories: 280 }
            ],
            poultry: [
                { id: 'whole_chicken', name: 'Whole Chicken', desc: 'Roasting chicken', unit: 'lbs', baseTime: 22, calories: 180 },
                { id: 'chicken_breast', name: 'Chicken Breast', desc: 'Boneless, skinless', unit: 'inches', baseTime: 6, calories: 165 },
                { id: 'chicken_thighs', name: 'Chicken Thighs', desc: 'Bone-in or boneless', unit: 'inches', baseTime: 8, calories: 210 },
                { id: 'whole_turkey', name: 'Whole Turkey', desc: 'Holiday turkey', unit: 'lbs', baseTime: 13, calories: 160 },
                { id: 'turkey_breast', name: 'Turkey Breast', desc: 'Bone-in or boneless', unit: 'lbs', baseTime: 15, calories: 150 },
                { id: 'duck_breast', name: 'Duck Breast', desc: 'Magret, skin-on', unit: 'inches', baseTime: 7, calories: 300 }
            ],
            seafood: [
                { id: 'salmon_fillet', name: 'Salmon Fillet', desc: 'Fresh or frozen', unit: 'inches', baseTime: 5, calories: 220 },
                { id: 'white_fish', name: 'White Fish', desc: 'Cod, halibut, tilapia', unit: 'inches', baseTime: 4, calories: 120 },
                { id: 'shrimp', name: 'Shrimp', desc: 'Raw or cooked', unit: 'lbs', baseTime: 3, calories: 100 },
                { id: 'scallops', name: 'Scallops', desc: 'Sea or bay scallops', unit: 'lbs', baseTime: 4, calories: 110 },
                { id: 'lobster', name: 'Lobster', desc: 'Whole lobster', unit: 'lbs', baseTime: 12, calories: 90 },
                { id: 'mussels', name: 'Mussels', desc: 'Fresh mussels', unit: 'lbs', baseTime: 8, calories: 85 }
            ],
            vegetables: [
                { id: 'potatoes', name: 'Potatoes', desc: 'Roasted or baked', unit: 'inches', baseTime: 25, calories: 90 },
                { id: 'broccoli', name: 'Broccoli', desc: 'Florets or spears', unit: 'lbs', baseTime: 15, calories: 35 },
                { id: 'carrots', name: 'Carrots', desc: 'Sliced or whole', unit: 'lbs', baseTime: 20, calories: 40 },
                { id: 'asparagus', name: 'Asparagus', desc: 'Fresh spears', unit: 'lbs', baseTime: 12, calories: 20 },
                { id: 'brussels', name: 'Brussels Sprouts', desc: 'Halved or whole', unit: 'lbs', baseTime: 18, calories: 45 },
                { id: 'sweet_potato', name: 'Sweet Potato', desc: 'Baked or roasted', unit: 'inches', baseTime: 30, calories: 100 }
            ],
            baked: [
                { id: 'bread_loaf', name: 'Bread Loaf', desc: 'Yeast breads', unit: 'lbs', baseTime: 35, calories: 120 },
                { id: 'cookies', name: 'Cookies', desc: 'Drop cookies', unit: 'dozen', baseTime: 10, calories: 150 },
                { id: 'muffins', name: 'Muffins', desc: 'Standard muffins', unit: 'dozen', baseTime: 20, calories: 180 },
                { id: 'cake', name: 'Layer Cake', desc: '8-9 inch rounds', unit: 'inches', baseTime: 30, calories: 250 },
                { id: 'pie', name: 'Fruit Pie', desc: '9 inch pie', unit: 'each', baseTime: 45, calories: 300 },
                { id: 'pizza', name: 'Pizza', desc: '12 inch pizza', unit: 'each', baseTime: 15, calories: 200 }
            ]
        };

        // Doneness levels
        const donenessLevels = {
            meat: [
                { name: 'Rare', temp: 125, multiplier: 0.8 },
                { name: 'Medium Rare', temp: 135, multiplier: 1.0 },
                { name: 'Medium', temp: 145, multiplier: 1.2 },
                { name: 'Medium Well', temp: 155, multiplier: 1.4 },
                { name: 'Well Done', temp: 165, multiplier: 1.6 }
            ],
            poultry: [
                { name: 'Juicy', temp: 160, multiplier: 1.0 },
                { name: 'Standard', temp: 165, multiplier: 1.1 },
                { name: 'Well Done', temp: 170, multiplier: 1.3 }
            ],
            seafood: [
                { name: 'Rare', temp: 115, multiplier: 0.8 },
                { name: 'Medium Rare', temp: 125, multiplier: 1.0 },
                { name: 'Medium', temp: 135, multiplier: 1.2 },
                { name: 'Well Done', temp: 145, multiplier: 1.4 }
            ],
            vegetables: [
                { name: 'Crisp-Tender', temp: null, multiplier: 0.8 },
                { name: 'Tender', temp: null, multiplier: 1.0 },
                { name: 'Very Soft', temp: null, multiplier: 1.3 }
            ],
            baked: [
                { name: 'Light', temp: null, multiplier: 0.9 },
                { name: 'Golden', temp: null, multiplier: 1.0 },
                { name: 'Dark', temp: null, multiplier: 1.2 }
            ]
        };

        // Current state
        let currentCategory = 'meat';
        let currentFood = null;
        let currentMethod = 'oven';
        let currentDoneness = null;

        // Initialize
        loadFoodItems();
        setupEventListeners();
        calculateCookingTime();

        function setupEventListeners() {
            // Category buttons
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentCategory = this.dataset.category;
                    loadFoodItems();
                });
            });

            // Method buttons
            methodBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    methodBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentMethod = this.dataset.method;
                    calculateCookingTime();
                });
            });

            // Calculate button
            calculateBtn.addEventListener('click', calculateCookingTime);
            
            // Reset button
            resetBtn.addEventListener('click', resetCalculator);
            
            // Timer button
            timerBtn.addEventListener('click', startTimer);
            
            // Input listeners
            foodWeight.addEventListener('input', calculateCookingTime);
            thickness.addEventListener('input', calculateCookingTime);
            startTemp.addEventListener('change', calculateCookingTime);
            cookingTemp.addEventListener('input', calculateCookingTime);
        }

        function loadFoodItems() {
            const foods = foodDatabase[currentCategory];
            foodItems.innerHTML = '';
            
            foods.forEach((food, index) => {
                const foodItem = document.createElement('div');
                foodItem.className = `food-item ${index === 0 ? 'active' : ''}`;
                foodItem.innerHTML = `
                    <div class="food-name">${food.name}</div>
                    <div class="food-desc">${food.desc}</div>
                `;
                foodItem.addEventListener('click', function() {
                    document.querySelectorAll('.food-item').forEach(item => item.classList.remove('active'));
                    this.classList.add('active');
                    currentFood = food;
                    updateUnits();
                    loadDonenessLevels();
                    calculateCookingTime();
                });
                foodItems.appendChild(foodItem);
            });
            
            // Set first food as current
            currentFood = foods[0];
            updateUnits();
            loadDonenessLevels();
        }

        function updateUnits() {
            const weightUnit = document.getElementById('weightUnit');
            const thicknessUnit = document.getElementById('thicknessUnit');
            
            if (currentFood.unit === 'inches') {
                weightUnit.textContent = 'inches';
                thickness.style.display = 'none';
                document.querySelector('label[for="thickness"]').style.display = 'none';
            } else {
                weightUnit.textContent = currentFood.unit;
                thickness.style.display = 'block';
                document.querySelector('label[for="thickness"]').style.display = 'block';
            }
        }

        function loadDonenessLevels() {
            const levels = donenessLevels[currentCategory];
            donenessControls.innerHTML = '';
            
            levels.forEach((level, index) => {
                const btn = document.createElement('div');
                btn.className = `doneness-btn ${index === 1 ? 'active' : ''}`;
                btn.textContent = level.name;
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.doneness-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentDoneness = level;
                    calculateCookingTime();
                });
                donenessControls.appendChild(btn);
            });
            
            currentDoneness = levels[1];
        }

        function calculateCookingTime() {
            if (!currentFood || !currentDoneness) return;
            
            const weight = parseFloat(foodWeight.value);
            const thicknessVal = parseFloat(thickness.value);
            const temp = parseFloat(cookingTemp.value);
            
            if (isNaN(weight) || isNaN(temp)) return;
            
            // Base calculation
            let baseTime = currentFood.baseTime;
            
            // Adjust for weight/thickness
            let adjustedTime;
            if (currentFood.unit === 'inches') {
                adjustedTime = baseTime * weight;
            } else {
                adjustedTime = baseTime * weight;
                // Adjust for thickness if applicable
                if (thicknessVal > 1) {
                    adjustedTime *= (1 + (thicknessVal - 1) * 0.2);
                }
            }
            
            // Adjust for doneness
            adjustedTime *= currentDoneness.multiplier;
            
            // Adjust for starting temperature
            const startTempMultiplier = {
                'frozen': 1.5,
                'refrigerated': 1.0,
                'room_temp': 0.8
            };
            adjustedTime *= startTempMultiplier[startTemp.value];
            
            // Adjust for cooking method
            const methodMultiplier = {
                'oven': 1.0,
                'grill': 0.9,
                'stovetop': 0.7,
                'slow_cooker': 4.0,
                'air_fryer': 0.7
            };
            adjustedTime *= methodMultiplier[currentMethod];
            
            // Adjust for temperature (higher temp = less time)
            const tempAdjustment = 375 / temp; // Base at 375°F
            adjustedTime *= tempAdjustment;
            
            // Convert to minutes and round
            const totalMinutes = Math.round(adjustedTime);
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;
            
            // Update results
            totalTime.textContent = hours > 0 ? `${hours}:${minutes.toString().padStart(2, '0')}` : `${minutes} min`;
            internalTemp.textContent = currentDoneness.temp ? `${currentDoneness.temp}°F` : 'N/A';
            
            // Calculate resting time (10-20% of cooking time)
            const restMinutes = Math.max(5, Math.round(totalMinutes * 0.15));
            restTime.textContent = `${restMinutes} min`;
            
            // Update calories
            const calorieCount = currentFood.calories * (currentFood.unit === 'inches' ? 1 : weight);
            calories.textContent = Math.round(calorieCount);
            
            // Update time note
            timeNote.textContent = getTimeNote(totalMinutes);
            
            // Generate timeline
            generateTimeline(totalMinutes, restMinutes);
            
            // Generate tips
            generateCookingTips();
        }

        function getTimeNote(totalMinutes) {
            if (totalMinutes < 15) return 'Quick cooking';
            if (totalMinutes < 30) return 'Moderate time';
            if (totalMinutes < 60) return 'Plan ahead';
            return 'Long cooking time';
        }

        function generateTimeline(cookTime, restTime) {
            const steps = [
                { name: 'Prep', time: 10, note: 'Preparation time' },
                { name: 'Cook', time: cookTime, note: 'Active cooking' },
                { name: 'Rest', time: restTime, note: 'Resting period' },
                { name: 'Serve', time: 5, note: 'Final preparation' }
            ];
            
            let totalTime = 0;
            timelineSteps.innerHTML = '';
            
            steps.forEach((step, index) => {
                totalTime += step.time;
                const stepElement = document.createElement('div');
                stepElement.className = 'timeline-step';
                stepElement.innerHTML = `
                    <div class="step-circle">${index + 1}</div>
                    <div class="step-label">${step.name}</div>
                    <div class="step-time">${step.time} min</div>
                `;
                timelineSteps.appendChild(stepElement);
            });
        }

        function generateCookingTips() {
            const tips = [
                {
                    icon: '🌡️',
                    title: 'Use a Thermometer',
                    desc: 'Always verify internal temperature for food safety and perfect doneness.'
                },
                {
                    icon: '⏰',
                    title: 'Preheat Properly',
                    desc: 'Ensure your oven or cooking surface is fully preheated for accurate timing.'
                },
                {
                    icon: '🔄',
                    title: 'Rotate Food',
                    desc: 'Rotate pans and flip food halfway through for even cooking.'
                },
                {
                    icon: '🧊',
                    title: 'Rest Meat',
                    desc: 'Allow meat to rest after cooking for juicier results.'
                }
            ];
            
            cookingTips.innerHTML = tips.map(tip => `
                <div class="tip-card">
                    <div class="tip-icon">${tip.icon}</div>
                    <div class="tip-title">${tip.title}</div>
                    <div class="tip-desc">${tip.desc}</div>
                </div>
            `).join('');
        }

        function resetCalculator() {
            foodWeight.value = 1;
            thickness.value = 1;
            startTemp.value = 'refrigerated';
            cookingTemp.value = 350;
            
            // Reset to first category and food
            categoryBtns[0].click();
            calculateCookingTime();
        }

        function startTimer() {
            const timeText = totalTime.textContent;
            let totalSeconds = 0;
            
            if (timeText.includes(':')) {
                const [hours, minutes] = timeText.split(':').map(Number);
                totalSeconds = hours * 3600 + minutes * 60;
            } else {
                totalSeconds = parseInt(timeText) * 60;
            }
            
            if (totalSeconds > 0) {
                alert(`Timer started for ${timeText}! Check your device's timer app.`);
                // In a real implementation, this would start an actual timer
            }
        }

        // Initialize calculation
        calculateCookingTime();
    </script>
</body>
</html>
