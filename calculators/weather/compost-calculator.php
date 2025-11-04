<?php
/**
 * Compost Calculator
 * File: weather/compost-calculator.php
 * Description: Calculate compost requirements and carbon-to-nitrogen ratios for optimal composting
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compost Calculator - Optimize Your Composting Process</title>
    <meta name="description" content="Calculate compost requirements, carbon-to-nitrogen ratios, and optimize your composting process for better garden results.">
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
        
        .materials-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 25px; }
        .material-section { background: #f8f9fa; padding: 25px; border-radius: 12px; }
        .material-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }
        .material-item { display: flex; justify-content: between; align-items: center; padding: 12px; background: white; margin-bottom: 10px; border-radius: 8px; border-left: 4px solid; }
        .material-item.green { border-left-color: #4caf50; }
        .material-item.brown { border-left-color: #8d6e63; }
        .material-info { flex: 1; }
        .material-name { font-weight: 600; color: #2c3e50; }
        .material-ratio { font-size: 0.85rem; color: #7f8c8d; }
        .material-input { width: 80px; padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px; text-align: center; }
        
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .result-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; text-align: center; }
        .result-card.optimal { background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); border-left-color: #4caf50; }
        .result-card.warning { background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); border-left-color: #ff9800; }
        .result-card.error { background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); border-left-color: #f44336; }
        .result-value { font-size: 1.5rem; font-weight: bold; color: #5e35b1; margin-bottom: 5px; }
        .result-card.optimal .result-value { color: #2e7d32; }
        .result-card.warning .result-value { color: #ef6c00; }
        .result-card.error .result-value { color: #c62828; }
        .result-label { font-size: 0.85rem; color: #4527a0; font-weight: 600; }
        .result-card.optimal .result-label { color: #1b5e20; }
        .result-card.warning .result-label { color: #e65100; }
        .result-card.error .result-label { color: #b71c1c; }
        
        .ratio-indicator { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .ratio-indicator h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .ratio-scale { height: 20px; background: linear-gradient(90deg, #f44336 0%, #ff9800 20%, #4caf50 40%, #4caf50 60%, #ff9800 80%, #f44336 100%); border-radius: 10px; margin: 15px 0; position: relative; }
        .ratio-marker { position: absolute; top: -5px; width: 2px; height: 30px; background: #2c3e50; }
        .ratio-labels { display: flex; justify-content: space-between; font-size: 0.8rem; color: #7f8c8d; }
        
        .action-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .action-btn { padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3); }
        .action-btn.secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .action-btn.secondary:hover { border-color: #667eea; }
        
        .composting-tips { background: #e8f5e8; padding: 25px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #4caf50; }
        .composting-tips h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }
        .tips-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; }
        .tip-card { background: white; padding: 15px; border-radius: 8px; }
        .tip-icon { font-size: 1.5rem; margin-bottom: 8px; }
        .tip-title { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .tip-desc { font-size: 0.85rem; color: #555; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .materials-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .materials-table th, .materials-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .materials-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .materials-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .controls-row { grid-template-columns: 1fr; }
            .materials-grid { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: repeat(2, 1fr); }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { grid-template-columns: 1fr; }
            .material-item { flex-direction: column; align-items: flex-start; gap: 10px; }
            .material-input { width: 100%; }
        }
        
        @media (max-width: 480px) {
            .results-grid { grid-template-columns: 1fr; }
            .calculator-card { padding: 20px; }
            .header { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌱 Compost Calculator</h1>
            <p>Optimize your composting process with perfect carbon-to-nitrogen ratios and material balancing</p>
        </div>

        <div class="calculator-card">
            <div class="controls-row">
                <div class="control-group">
                    <label for="compostSize">Compost Bin Size</label>
                    <select id="compostSize">
                        <option value="small">Small (5-10 gallons)</option>
                        <option value="medium" selected>Medium (20-30 gallons)</option>
                        <option value="large">Large (50+ gallons)</option>
                        <option value="custom">Custom Size</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label for="compostMethod">Composting Method</label>
                    <select id="compostMethod">
                        <option value="hot">Hot Composting</option>
                        <option value="cold" selected>Cold Composting</option>
                        <option value="vermicompost">Vermicomposting</option>
                        <option value="tumbler">Tumbler Composting</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label for="targetRatio">Target C:N Ratio</label>
                    <select id="targetRatio">
                        <option value="25">25:1 (Fastest)</option>
                        <option value="30" selected>30:1 (Optimal)</option>
                        <option value="35">35:1 (Standard)</option>
                        <option value="40">40:1 (Slower)</option>
                    </select>
                </div>
            </div>
            
            <div class="materials-grid">
                <div class="material-section">
                    <h3>🌿 Green Materials (Nitrogen-rich)</h3>
                    <div class="material-item green">
                        <div class="material-info">
                            <div class="material-name">Kitchen Scraps</div>
                            <div class="material-ratio">C:N 15:1</div>
                        </div>
                        <input type="number" class="material-input" id="kitchenScraps" value="5" min="0" step="0.5">
                    </div>
                    <div class="material-item green">
                        <div class="material-info">
                            <div class="material-name">Grass Clippings</div>
                            <div class="material-ratio">C:N 20:1</div>
                        </div>
                        <input type="number" class="material-input" id="grassClippings" value="3" min="0" step="0.5">
                    </div>
                    <div class="material-item green">
                        <div class="material-info">
                            <div class="material-name">Coffee Grounds</div>
                            <div class="material-ratio">C:N 20:1</div>
                        </div>
                        <input type="number" class="material-input" id="coffeeGrounds" value="2" min="0" step="0.5">
                    </div>
                    <div class="material-item green">
                        <div class="material-info">
                            <div class="material-name">Manure</div>
                            <div class="material-ratio">C:N 15:1</div>
                        </div>
                        <input type="number" class="material-input" id="manure" value="0" min="0" step="0.5">
                    </div>
                </div>
                
                <div class="material-section">
                    <h3>🍂 Brown Materials (Carbon-rich)</h3>
                    <div class="material-item brown">
                        <div class="material-info">
                            <div class="material-name">Dry Leaves</div>
                            <div class="material-ratio">C:N 60:1</div>
                        </div>
                        <input type="number" class="material-input" id="dryLeaves" value="8" min="0" step="0.5">
                    </div>
                    <div class="material-item brown">
                        <div class="material-info">
                            <div class="material-name">Straw/Hay</div>
                            <div class="material-ratio">C:N 80:1</div>
                        </div>
                        <input type="number" class="material-input" id="straw" value="4" min="0" step="0.5">
                    </div>
                    <div class="material-item brown">
                        <div class="material-info">
                            <div class="material-name">Wood Chips</div>
                            <div class="material-ratio">C:N 400:1</div>
                        </div>
                        <input type="number" class="material-input" id="woodChips" value="2" min="0" step="0.5">
                    </div>
                    <div class="material-item brown">
                        <div class="material-info">
                            <div class="material-name">Cardboard</div>
                            <div class="material-ratio">C:N 350:1</div>
                        </div>
                        <input type="number" class="material-input" id="cardboard" value="1" min="0" step="0.5">
                    </div>
                </div>
            </div>
            
            <div class="results-grid">
                <div class="result-card" id="ratioCard">
                    <div class="result-value" id="currentRatio">30:1</div>
                    <div class="result-label">CURRENT C:N RATIO</div>
                </div>
                <div class="result-card">
                    <div class="result-value" id="totalVolume">23 lbs</div>
                    <div class="result-label">TOTAL MATERIALS</div>
                </div>
                <div class="result-card">
                    <div class="result-value" id="compostTime">3-6 months</div>
                    <div class="result-label">ESTIMATED TIME</div>
                </div>
                <div class="result-card">
                    <div class="result-value" id="finalCompost">15 lbs</div>
                    <div class="result-label">FINAL COMPOST</div>
                </div>
            </div>
            
            <div class="ratio-indicator">
                <h3>⚖️ Carbon-to-Nitrogen Ratio Scale</h3>
                <div class="ratio-scale" id="ratioScale">
                    <div class="ratio-marker" id="ratioMarker" style="left: 50%;"></div>
                </div>
                <div class="ratio-labels">
                    <span>10:1 (Too Nitrogen-rich)</span>
                    <span>25-35:1 (Ideal Range)</span>
                    <span>50:1+ (Too Carbon-rich)</span>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="action-btn" id="calculateBtn">
                    <span>🧮</span> Calculate Compost
                </button>
                <button class="action-btn secondary" id="resetBtn">
                    <span>🔄</span> Reset Values
                </button>
                <button class="action-btn secondary" id="optimizeBtn">
                    <span>⚡</span> Optimize Ratio
                </button>
            </div>
            
            <div class="composting-tips">
                <h3>💡 Composting Tips & Recommendations</h3>
                <div class="tips-grid" id="compostTips">
                    <!-- Tips will be generated here -->
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🌱 Understanding Compost Science</h2>
            
            <p>Composting is a natural process that transforms organic materials into nutrient-rich soil amendment through controlled decomposition.</p>

            <h3>📊 Carbon-to-Nitrogen Ratio Explained</h3>
            <table class="materials-table">
                <thead>
                    <tr>
                        <th>C:N Ratio</th>
                        <th>Decomposition Speed</th>
                        <th>Temperature</th>
                        <th>Result Quality</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>10:1 - 20:1</td><td>Very Fast</td><td>Hot (>60°C)</td><td>Nitrogen-rich, may smell</td></tr>
                    <tr><td>25:1 - 35:1</td><td>Optimal</td><td>Warm (45-60°C)</td><td>Balanced, no odor</td></tr>
                    <tr><td>40:1 - 50:1</td><td>Slow</td><td>Cool (30-45°C)</td><td>Carbon-rich, takes longer</td></tr>
                    <tr><td>60:1+</td><td>Very Slow</td><td>Cold (<30°C)</td><td>Poor decomposition</td></tr>
                </tbody>
            </table>

            <h3>🌿 Green Materials (Nitrogen Sources)</h3>
            <div class="formula-box">
                <strong>High Nitrogen Materials:</strong><br>
                • Kitchen scraps (15:1) - Fruits, vegetables, coffee grounds<br>
                • Fresh grass clippings (20:1) - High moisture content<br>
                • Manure (15:1) - Animal waste, excellent activator<br>
                • Garden waste (30:1) - Green plant material<br>
                • Seaweed (19:1) - Mineral-rich, fast decomposing
            </div>

            <h3>🍂 Brown Materials (Carbon Sources)</h3>
            <table class="materials-table">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>C:N Ratio</th>
                        <th>Decomposition Time</th>
                        <th>Best Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Dry leaves</td><td>60:1</td><td>6-12 months</td><td>Base material</td></tr>
                    <tr><td>Straw/hay</td><td>80:1</td><td>3-6 months</td><td>Bulking agent</td></tr>
                    <tr><td>Wood chips</td><td>400:1</td><td>12-24 months</td><td>Aeration</td></tr>
                    <tr><td>Cardboard</td><td>350:1</td><td>6-12 months</td><td>Shredded</td></tr>
                    <tr><td>Sawdust</td><td>500:1</td><td>12-24 months</td><td>Small amounts</td></tr>
                    <tr><td>Paper</td><td>170:1</td><td>3-6 months</td><td>Shredded</td></tr>
                </tbody>
            </table>

            <h3>🔥 Composting Methods</h3>
            <ul>
                <li><strong>Hot Composting:</strong> Fast (2-3 months), requires turning, kills pathogens</li>
                <li><strong>Cold Composting:</strong> Slow (6-12 months), minimal maintenance</li>
                <li><strong>Vermicomposting:</strong> Worm-based, continuous, excellent for kitchens</li>
                <li><strong>Tumbler Composting:</strong> Contained, easy turning, rodent-resistant</li>
                <li><strong>Bokashi:</strong> Fermentation method, works with all food waste</li>
            </ul>

            <h3>📈 Volume Reduction & Yield</h3>
            <div class="formula-box">
                <strong>Typical Volume Reduction:</strong><br>
                • Initial volume reduction: 50-70% during composting<br>
                • Final compost yield: 30-50% of original volume<br>
                • 100 lbs organic material → 30-50 lbs finished compost<br>
                • Density increases from 10-20 lbs/cu.ft to 40-50 lbs/cu.ft
            </div>

            <h3>🌡️ Temperature Guidelines</h3>
            <table class="materials-table">
                <thead>
                    <tr>
                        <th>Temperature Range</th>
                        <th>Process Stage</th>
                        <th>Duration</th>
                        <th>Action Required</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>20-40°C (68-104°F)</td><td>Mesophilic</td><td>2-5 days</td><td>Initial breakdown</td></tr>
                    <tr><td>40-60°C (104-140°F)</td><td>Thermophilic</td><td>2-6 weeks</td><td>Pathogen kill, turn pile</td></tr>
                    <tr><td>20-40°C (68-104°F)</td><td>Curing</td><td>1-3 months</td><td>Maturation, no turning</td></tr>
                </tbody>
            </table>

            <h3>💧 Moisture Management</h3>
            <ul>
                <li><strong>Ideal moisture:</strong> 40-60% (feels like a wrung-out sponge)</li>
                <li><strong>Too dry:</strong> Below 40% - decomposition slows significantly</li>
                <li><strong>Too wet:</strong> Above 60% - becomes anaerobic and smelly</li>
                <li><strong>Testing:</strong> Squeeze test - should release 1-2 drops of water</li>
            </ul>

            <h3>🕒 Time Factors</h3>
            <div class="formula-box">
                <strong>Decomposition Timeline:</strong><br>
                • Hot composting: 2-3 months with proper management<br>
                • Cold composting: 6-12 months with minimal turning<br>
                • Vermicomposting: 2-3 months with worms<br>
                • Factors affecting speed: C:N ratio, particle size, aeration, moisture, temperature
            </div>

            <h3>🐛 Vermicomposting Specifics</h3>
            <ul>
                <li><strong>Worm species:</strong> Red wigglers (Eisenia fetida) most common</li>
                <li><strong>Feeding rate:</strong> Worms eat half their weight daily</li>
                <li><strong>Temperature:</strong> Ideal 15-25°C (59-77°F)</li>
                <li><strong>pH:</strong> Neutral (6.5-7.5) preferred</li>
                <li><strong>Avoid:</strong> Citrus, onions, garlic, meat, dairy</li>
            </ul>

            <h3>🌍 Environmental Benefits</h3>
            <table class="materials-table">
                <thead>
                    <tr>
                        <th>Benefit</th>
                        <th>Impact</th>
                        <th>Scale</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Waste Reduction</td><td>30-50% landfill diversion</td><td>Household level</td></tr>
                    <tr><td>Methane Reduction</td><td>Aerobic vs anaerobic decomposition</td><td>Global impact</td></tr>
                    <tr><td>Soil Health</td><td>Improves structure, water retention</td><td>Local gardens</td></tr>
                    <tr><td>Chemical Reduction</td><td>Less fertilizer needed</td><td>Agricultural scale</td></tr>
                </tbody>
            </table>

            <h3>⚠️ Common Problems & Solutions</h3>
            <div class="formula-box">
                <strong>Troubleshooting Guide:</strong><br>
                • <strong>Smelly compost:</strong> Too wet or nitrogen-rich - add browns, turn pile<br>
                • <strong>Not heating up:</strong> Too dry or carbon-rich - add greens, water<br>
                • <strong>Attracting pests:</strong> Exposed food - bury scraps, use covered bin<br>
                • <strong>Slow decomposition:</strong> Poor aeration - turn pile, chop materials smaller
            </div>

            <h3>📏 Bin Sizing Guidelines</h3>
            <ul>
                <li><strong>Small (5-10 gal):</strong> Apartment composting, vermicomposting</li>
                <li><strong>Medium (20-30 gal):</strong> Family of 2-4, standard backyard</li>
                <li><strong>Large (50+ gal):</strong> Large families, serious gardeners</li>
                <li><strong>Minimum size:</strong> 3×3×3 ft for hot composting to retain heat</li>
            </ul>
        </div>

        <div class="footer">
            <p>🌱 Professional Compost Calculator | Perfect C:N Ratios</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Optimize your composting process for faster results and better garden soil</p>
        </div>
    </div>

    <script>
        // DOM elements
        const compostSize = document.getElementById('compostSize');
        const compostMethod = document.getElementById('compostMethod');
        const targetRatio = document.getElementById('targetRatio');
        const calculateBtn = document.getElementById('calculateBtn');
        const resetBtn = document.getElementById('resetBtn');
        const optimizeBtn = document.getElementById('optimizeBtn');
        const ratioCard = document.getElementById('ratioCard');
        const currentRatio = document.getElementById('currentRatio');
        const totalVolume = document.getElementById('totalVolume');
        const compostTime = document.getElementById('compostTime');
        const finalCompost = document.getElementById('finalCompost');
        const ratioMarker = document.getElementById('ratioMarker');
        const compostTips = document.getElementById('compostTips');

        // Material inputs
        const materialInputs = [
            'kitchenScraps', 'grassClippings', 'coffeeGrounds', 'manure',
            'dryLeaves', 'straw', 'woodChips', 'cardboard'
        ];

        // Material data (C:N ratios)
        const materialRatios = {
            kitchenScraps: 15,
            grassClippings: 20,
            coffeeGrounds: 20,
            manure: 15,
            dryLeaves: 60,
            straw: 80,
            woodChips: 400,
            cardboard: 350
        };

        // Initialize
        calculateCompost();

        // Event listeners
        calculateBtn.addEventListener('click', calculateCompost);
        resetBtn.addEventListener('click', resetValues);
        optimizeBtn.addEventListener('click', optimizeRatio);
        
        // Add input listeners to all material inputs
        materialInputs.forEach(id => {
            document.getElementById(id).addEventListener('input', calculateCompost);
        });

        // Add listeners to select elements
        compostSize.addEventListener('change', calculateCompost);
        compostMethod.addEventListener('change', calculateCompost);
        targetRatio.addEventListener('change', calculateCompost);

        function calculateCompost() {
            let totalCarbon = 0;
            let totalNitrogen = 0;
            let totalWeight = 0;

            // Calculate totals from all materials
            materialInputs.forEach(id => {
                const weight = parseFloat(document.getElementById(id).value) || 0;
                const ratio = materialRatios[id];
                
                if (weight > 0) {
                    // Carbon weight = total weight * (C/(C+N))
                    const carbonWeight = weight * (ratio / (ratio + 1));
                    // Nitrogen weight = total weight * (1/(C+N))
                    const nitrogenWeight = weight * (1 / (ratio + 1));
                    
                    totalCarbon += carbonWeight;
                    totalNitrogen += nitrogenWeight;
                    totalWeight += weight;
                }
            });

            // Calculate current C:N ratio
            const currentCN = totalNitrogen > 0 ? (totalCarbon / totalNitrogen).toFixed(1) : 0;
            const targetCN = parseInt(targetRatio.value);

            // Update results
            currentRatio.textContent = `${currentCN}:1`;
            totalVolume.textContent = `${totalWeight.toFixed(1)} lbs`;
            
            // Update ratio card appearance
            updateRatioCard(currentCN, targetCN);
            
            // Update ratio marker position
            updateRatioMarker(currentCN);
            
            // Calculate and update times and yields
            updateCompostDetails(totalWeight, currentCN, targetCN);
            
            // Generate tips
            generateCompostTips(currentCN, targetCN, totalWeight);
        }

        function updateRatioCard(currentCN, targetCN) {
            const difference = Math.abs(currentCN - targetCN);
            
            ratioCard.className = 'result-card';
            
            if (currentCN === 0) {
                ratioCard.classList.add('error');
            } else if (difference <= 5) {
                ratioCard.classList.add('optimal');
            } else if (difference <= 15) {
                ratioCard.classList.add('warning');
            } else {
                ratioCard.classList.add('error');
            }
        }

        function updateRatioMarker(currentCN) {
            // Map C:N ratio to percentage (10:1 = 0%, 50:1 = 100%)
            let position = ((currentCN - 10) / 40) * 100;
            position = Math.max(0, Math.min(100, position)); // Clamp between 0-100%
            ratioMarker.style.left = `${position}%`;
        }

        function updateCompostDetails(totalWeight, currentCN, targetCN) {
            const method = compostMethod.value;
            const size = compostSize.value;
            
            // Calculate composting time based on method and ratio
            let time = '3-6 months';
            if (method === 'hot') time = '2-3 months';
            if (method === 'vermicompost') time = '2-3 months';
            if (method === 'tumbler') time = '4-8 weeks';
            
            // Adjust time based on C:N ratio
            const ratioDiff = Math.abs(currentCN - targetCN);
            if (ratioDiff > 15) time += '+ (slow)';
            if (ratioDiff <= 5) time = time.replace(/\d+/, match => parseInt(match) - 1);
            
            compostTime.textContent = time;
            
            // Calculate final compost yield (typically 30-50% of input)
            const yieldPercentage = 0.4; // 40% average
            const finalYield = totalWeight * yieldPercentage;
            finalCompost.textContent = `${finalYield.toFixed(1)} lbs`;
        }

        function generateCompostTips(currentCN, targetCN, totalWeight) {
            const tips = [];
            const difference = currentCN - targetCN;
            
            // Ratio-based tips
            if (currentCN === 0) {
                tips.push({
                    icon: '📝',
                    title: 'Add Materials',
                    desc: 'Start by adding both green and brown materials to your compost.'
                });
            } else if (difference < -10) {
                tips.push({
                    icon: '🍂',
                    title: 'Add Brown Materials',
                    desc: 'Your compost needs more carbon-rich materials like leaves or straw.'
                });
            } else if (difference > 10) {
                tips.push({
                    icon: '🌿',
                    title: 'Add Green Materials',
                    desc: 'Your compost needs more nitrogen-rich materials like kitchen scraps.'
                });
            } else if (Math.abs(difference) <= 5) {
                tips.push({
                    icon: '✅',
                    title: 'Perfect Ratio',
                    desc: 'Your C:N ratio is ideal! Maintain this balance for fast composting.'
                });
            }
            
            // Volume-based tips
            if (totalWeight < 10) {
                tips.push({
                    icon: '📦',
                    title: 'Increase Volume',
                    desc: 'Add more materials to reach optimal composting mass (20+ lbs).'
                });
            } else if (totalWeight > 50) {
                tips.push({
                    icon: '⚖️',
                    title: 'Consider Second Bin',
                    desc: 'Large volume - consider starting a second compost bin.'
                });
            }
            
            // Method-specific tips
            const method = compostMethod.value;
            if (method === 'hot') {
                tips.push({
                    icon: '🔥',
                    title: 'Turn Regularly',
                    desc: 'Turn your compost every 3-5 days to maintain high temperatures.'
                });
            } else if (method === 'vermicompost') {
                tips.push({
                    icon: '🐛',
                    title: 'Monitor Worms',
                    desc: 'Ensure worms are active and not trying to escape (sign of issues).'
                });
            }
            
            // General tips
            tips.push({
                icon: '💧',
                title: 'Check Moisture',
                desc: 'Compost should feel like a wrung-out sponge. Add water if too dry.'
            });
            
            tips.push({
                icon: '🔄',
                title: 'Mix Well',
                desc: 'Thoroughly mix green and brown layers for even decomposition.'
            });
            
            // Display tips
            compostTips.innerHTML = tips.map(tip => `
                <div class="tip-card">
                    <div class="tip-icon">${tip.icon}</div>
                    <div class="tip-title">${tip.title}</div>
                    <div class="tip-desc">${tip.desc}</div>
                </div>
            `).join('');
        }

        function resetValues() {
            // Reset all material inputs to default values
            document.getElementById('kitchenScraps').value = 5;
            document.getElementById('grassClippings').value = 3;
            document.getElementById('coffeeGrounds').value = 2;
            document.getElementById('manure').value = 0;
            document.getElementById('dryLeaves').value = 8;
            document.getElementById('straw').value = 4;
            document.getElementById('woodChips').value = 2;
            document.getElementById('cardboard').value = 1;
            
            // Reset selects to default
            compostSize.value = 'medium';
            compostMethod.value = 'cold';
            targetRatio.value = '30';
            
            calculateCompost();
        }

        function optimizeRatio() {
            const targetCN = parseInt(targetRatio.value);
            let currentCN = parseFloat(currentRatio.textContent);
            
            if (currentCN === 0 || isNaN(currentCN)) {
                alert('Please add some materials first to optimize the ratio.');
                return;
            }
            
            const difference = currentCN - targetCN;
            
            if (Math.abs(difference) <= 2) {
                alert('Your compost ratio is already well optimized!');
                return;
            }
            
            if (difference > 0) {
                // Too carbon-rich - need more greens
                const additionalGreens = (difference * 0.5).toFixed(1);
                document.getElementById('kitchenScraps').value = 
                    (parseFloat(document.getElementById('kitchenScraps').value) + parseFloat(additionalGreens)).toFixed(1);
            } else {
                // Too nitrogen-rich - need more browns
                const additionalBrowns = (Math.abs(difference) * 0.3).toFixed(1);
                document.getElementById('dryLeaves').value = 
                    (parseFloat(document.getElementById('dryLeaves').value) + parseFloat(additionalBrowns)).toFixed(1);
            }
            
            calculateCompost();
            alert('Ratio optimized! Check the updated values.');
        }
    </script>
</body>
</html>
