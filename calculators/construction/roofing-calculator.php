<?php
/**
 * Roofing Calculator
 * File: construction/roofing-calculator.php
 * Description: Calculate roofing materials, costs, and installation requirements with multi-currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roofing Calculator - Materials, Cost & Installation Planning</title>
    <meta name="description" content="Free roofing calculator with multi-currency support. Calculate shingles, underlayment, flashing and total costs in USD, EUR, GBP, INR, and more.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #667eea; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .dimension-inputs { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        
        .roof-type-options { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .roof-type-card { border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .roof-type-card.selected { border-color: #667eea; background: #f0f4ff; }
        .roof-type-card h4 { color: #333; margin-bottom: 5px; }
        .roof-type-card .pitch { color: #e74c3c; font-weight: bold; font-size: 0.9em; }
        
        .material-options { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .material-card { border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; cursor: pointer; transition: all 0.3s; }
        .material-card.selected { border-color: #667eea; background: #f0f4ff; }
        .material-card h4 { color: #333; margin-bottom: 5px; }
        .material-card .lifespan { color: #27ae60; font-weight: bold; font-size: 0.9em; }
        .material-card .price { color: #667eea; font-weight: bold; }
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; }
        .result-card .amount { font-size: 3rem; font-weight: bold; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #667eea; font-size: 2rem; font-weight: bold; }
        
        .materials-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px; }
        .material-item { background: white; padding: 15px; border-radius: 8px; border: 2px solid #e0e0e0; }
        .material-item h4 { color: #667eea; margin-bottom: 10px; }
        .material-item .quantity { font-size: 1.5rem; font-weight: bold; color: #333; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #667eea; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .pitch-indicator { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; text-align: center; }
        .pitch-visual { height: 100px; background: linear-gradient(45deg, #e0e0e0 50%, transparent 50%); margin: 15px 0; position: relative; }
        .pitch-value { font-size: 2rem; font-weight: bold; color: #667eea; }
        
        .info-box { background: #e8f2ff; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .header h1 { font-size: 2rem; }
            .result-card .amount { font-size: 2.5rem; }
            .metric-grid, .materials-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .dimension-inputs { grid-template-columns: 1fr; }
            .roof-type-options, .material-options { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏠 Roofing Calculator</h1>
            <p>Calculate roofing materials, costs, and installation requirements</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Roof Specifications</h2>
                <form id="roofingForm">
                    <div class="form-group">
                        <label for="roofType">Roof Type</label>
                        <div class="roof-type-options">
                            <div class="roof-type-card selected" data-type="gable" data-pitch="4:12 to 12:12">
                                <h4>Gable Roof</h4>
                                <div class="pitch">Standard pitch</div>
                                <small>Two sloping sides</small>
                            </div>
                            <div class="roof-type-card" data-type="hip" data-pitch="4:12 to 9:12">
                                <h4>Hip Roof</h4>
                                <div class="pitch">Moderate pitch</div>
                                <small>Four sloping sides</small>
                            </div>
                            <div class="roof-type-card" data-type="flat" data-pitch="1:12 to 2:12">
                                <h4>Flat Roof</h4>
                                <div class="pitch">Low slope</div>
                                <small>Nearly horizontal</small>
                            </div>
                            <div class="roof-type-card" data-type="mansard" data-pitch="12:12 to 20:12">
                                <h4>Mansard Roof</h4>
                                <div class="pitch">Steep pitch</div>
                                <small>French style</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dimension-inputs">
                        <div class="form-group">
                            <label for="length">House Length (feet)</label>
                            <input type="number" id="length" value="40" min="10" step="1" required>
                        </div>
                        <div class="form-group">
                            <label for="width">House Width (feet)</label>
                            <input type="number" id="width" value="30" min="10" step="1" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="pitch">Roof Pitch</label>
                        <select id="pitch">
                            <option value="3">3/12 (Low slope)</option>
                            <option value="4">4/12 (Conventional)</option>
                            <option value="5">5/12 (Moderate)</option>
                            <option value="6" selected>6/12 (Standard)</option>
                            <option value="8">8/12 (Steep)</option>
                            <option value="10">10/12 (Very steep)</option>
                            <option value="12">12/12 (45° angle)</option>
                        </select>
                        <small>Rise over run ratio</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="overhang">Overhang (inches)</label>
                        <input type="number" id="overhang" value="12" min="0" step="1" required>
                        <small>Roof extension beyond walls</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Roofing Material</label>
                        <div class="material-options">
                            <div class="material-card selected" data-material="asphalt" data-price="120" data-lifespan="20-30">
                                <h4>Asphalt Shingles</h4>
                                <div class="lifespan">20-30 years</div>
                                <div class="price">$120/square</div>
                                <small>Most common, economical</small>
                            </div>
                            <div class="material-card" data-material="metal" data-price="300" data-lifespan="40-70">
                                <h4>Metal Roofing</h4>
                                <div class="lifespan">40-70 years</div>
                                <div class="price">$300/square</div>
                                <small>Durable, energy efficient</small>
                            </div>
                            <div class="material-card" data-material="clay" data-price="600" data-lifespan="50-100">
                                <h4>Clay Tiles</h4>
                                <div class="lifespan">50-100 years</div>
                                <div class="price">$600/square</div>
                                <small>Traditional, heavy</small>
                            </div>
                            <div class="material-card" data-material="slate" data-price="800" data-lifespan="75-200">
                                <h4>Slate Tiles</h4>
                                <div class="lifespan">75-200 years</div>
                                <div class="price">$800/square</div>
                                <small>Premium, natural stone</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="wasteFactor">Waste Factor</label>
                        <select id="wasteFactor">
                            <option value="10">10% (Simple roof)</option>
                            <option value="15" selected>15% (Standard)</option>
                            <option value="20">20% (Complex roof)</option>
                            <option value="25">25% (Many valleys)</option>
                        </select>
                        <small>Extra material for cuts and waste</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="laborCost">Labor Cost</label>
                        <div class="input-group">
                            <input type="number" id="laborCost" value="150" min="0" step="10">
                            <select id="currency" style="padding: 12px;">
                                <option value="USD">USD $</option>
                                <option value="EUR">EUR €</option>
                                <option value="GBP">GBP £</option>
                                <option value="INR">INR ₹</option>
                                <option value="CAD">CAD $</option>
                                <option value="AUD">AUD $</option>
                                <option value="JPY">JPY ¥</option>
                                <option value="CNY">CNY ¥</option>
                            </select>
                        </div>
                        <small>Cost per square for professional installation</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="tearOff">Tear-off Existing Roof</label>
                        <select id="tearOff">
                            <option value="0">No tear-off needed</option>
                            <option value="50" selected>1 layer ($50/square)</option>
                            <option value="75">2 layers ($75/square)</option>
                            <option value="100">3+ layers ($100/square)</option>
                        </select>
                        <small>Cost to remove old roofing</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Roofing Requirements</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Roofing Project Summary</h2>
                
                <div class="result-card">
                    <h3>Total Project Cost</h3>
                    <div class="amount" id="totalCost">$5,847</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Roof Area</h4>
                        <div class="value" id="roofArea">31.6 sq</div>
                    </div>
                    <div class="metric-card">
                        <h4>Materials Cost</h4>
                        <div class="value" id="materialsCost">$4,362</div>
                    </div>
                </div>

                <div class="pitch-indicator">
                    <h3>Roof Pitch: <span class="pitch-value" id="pitchValue">6/12</span></h3>
                    <div class="pitch-visual" id="pitchVisual"></div>
                    <small>Rise: <span id="pitchRise">6"</span> per 12" run</small>
                </div>

                <div class="materials-grid">
                    <div class="material-item">
                        <h4>Shingles</h4>
                        <div class="quantity" id="shinglesCount">37 squares</div>
                        <small>3 bundles per square</small>
                    </div>
                    <div class="material-item">
                        <h4>Underlayment</h4>
                        <div class="quantity" id="underlaymentRolls">8 rolls</div>
                        <small>#15 felt</small>
                    </div>
                    <div class="material-item">
                        <h4>Roofing Nails</h4>
                        <div class="quantity" id="nailsCount">12 lbs</div>
                        <small>Galvanized</small>
                    </div>
                    <div class="material-item">
                        <h4>Flashing</h4>
                        <div class="quantity" id="flashingLength">85 ft</div>
                        <small>Aluminum</small>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Roof Dimensions</h3>
                    <div class="breakdown-item">
                        <span>House Footprint</span>
                        <strong id="houseSize">40' × 30'</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Roof Pitch</span>
                        <strong id="roofPitch">6/12</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Roof Area</span>
                        <strong id="calculatedArea">3,160 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Roof Squares</span>
                        <strong id="roofSquares">31.6 squares</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Materials Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Shingles</span>
                        <strong id="shinglesCost">$3,792</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Underlayment</span>
                        <strong id="underlaymentCost">$240</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Flashing & Drip Edge</span>
                        <strong id="flashingCost">$180</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ventilation</span>
                        <strong id="ventilationCost">$150</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fasteners & Supplies</span>
                        <strong id="fastenersCost">$75</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waste Factor (15%)</span>
                        <strong id="wasteCost">$568</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Subtotal Materials</span>
                        <strong id="subtotalMaterials">$4,362</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Materials Cost</span>
                        <strong id="materialsTotal">$4,362</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Labor Cost</span>
                        <strong id="laborTotal">$4,740</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tear-off Cost</span>
                        <strong id="tearOffCost">$1,580</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Subtotal</span>
                        <strong id="costSubtotal">$10,682</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax (8%)</span>
                        <strong id="taxAmount">$854</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Project Cost</span>
                        <strong id="finalTotal">$11,536</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Project Timeline</h3>
                    <div class="breakdown-item">
                        <span>Tear-off & Prep</span>
                        <strong>1-2 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Underlayment</span>
                        <strong>1 day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Shingle Installation</span>
                        <strong>2-3 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Flashing & Finishing</span>
                        <strong>1 day</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Duration</span>
                        <strong id="projectDuration">5-7 days</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$11,536</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€10,578</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£9,113</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹963,256</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAD (Canadian Dollar)</span>
                        <strong id="convertCAD">C$15,804</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>AUD (Australian Dollar)</span>
                        <strong id="convertAUD">A$17,304</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Roofing Tip:</strong> Always include 10-15% extra material for waste, especially on complex roofs with multiple valleys and hips. Consider local building codes for required underlayment and ventilation. Metal roofs last longer but cost more upfront.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🏠 Roofing Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional roofing estimation with multi-currency support</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('roofingForm');
        const materialCards = document.querySelectorAll('.material-card');
        const roofTypeCards = document.querySelectorAll('.roof-type-card');
        let selectedMaterial = 'asphalt';
        let selectedMaterialPrice = 120;
        let selectedLifespan = '20-30';
        let selectedRoofType = 'gable';

        // Currency conversion rates (approximate, relative to USD)
        const exchangeRates = {
            USD: 1.00,
            EUR: 0.92,
            GBP: 0.79,
            INR: 83.50,
            CAD: 1.37,
            AUD: 1.50,
            JPY: 149.50,
            CNY: 7.25
        };

        // Currency symbols
        const currencySymbols = {
            USD: '$',
            EUR: '€',
            GBP: '£',
            INR: '₹',
            CAD: 'C$',
            AUD: 'A$',
            JPY: '¥',
            CNY: '¥'
        };

        // Material selection
        materialCards.forEach(card => {
            card.addEventListener('click', function() {
                materialCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedMaterial = this.dataset.material;
                selectedMaterialPrice = parseFloat(this.dataset.price);
                selectedLifespan = this.dataset.lifespan;
            });
        });

        // Roof type selection
        roofTypeCards.forEach(card => {
            card.addEventListener('click', function() {
                roofTypeCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedRoofType = this.dataset.type;
            });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateRoofing();
        });

        function calculateRoofing() {
            const length = parseFloat(document.getElementById('length').value);
            const width = parseFloat(document.getElementById('width').value);
            const pitch = parseFloat(document.getElementById('pitch').value);
            const overhang = parseFloat(document.getElementById('overhang').value);
            const wasteFactor = parseFloat(document.getElementById('wasteFactor').value);
            const laborCost = parseFloat(document.getElementById('laborCost').value) || 0;
            const tearOffCost = parseFloat(document.getElementById('tearOff').value) || 0;
            const selectedCurrency = document.getElementById('currency').value;
            const symbol = currencySymbols[selectedCurrency];

            // Convert overhang to feet
            const overhangFeet = overhang / 12;

            // Calculate roof area with pitch factor
            // Pitch multiplier based on common roof pitches
            const pitchMultipliers = {
                3: 1.03, 4: 1.06, 5: 1.08, 6: 1.12, 8: 1.20, 10: 1.30, 12: 1.41
            };
            const pitchMultiplier = pitchMultipliers[pitch] || 1.12;

            // Calculate roof area (including overhang)
            const roofLength = length + (overhangFeet * 2);
            const roofWidth = width + (overhangFeet * 2);
            const footprintArea = roofLength * roofWidth;
            const roofArea = footprintArea * pitchMultiplier;
            
            // Convert to squares (1 square = 100 sq ft)
            const roofSquares = roofArea / 100;
            const roofSquaresWithWaste = roofSquares * (1 + wasteFactor / 100);

            // Calculate materials
            const shinglesSquares = Math.ceil(roofSquaresWithWaste);
            const underlaymentRolls = Math.ceil(roofArea / 200); // 1 roll covers 200 sq ft
            const nailsPounds = Math.ceil(roofArea / 250); // 1 lb per 250 sq ft
            const flashingFeet = Math.ceil((roofLength + roofWidth) * 2 * 0.7); // Perimeter with factor

            // Calculate costs
            const shinglesCost = shinglesSquares * selectedMaterialPrice;
            const underlaymentCost = underlaymentRolls * 30; // $30 per roll
            const flashingCost = flashingFeet * 2.50; // $2.50 per foot
            const ventilationCost = roofSquares * 5; // $5 per square
            const fastenersCost = nailsPounds * 6; // $6 per pound
            const materialsSubtotal = shinglesCost + underlaymentCost + flashingCost + ventilationCost + fastenersCost;
            const wasteCost = materialsSubtotal * (wasteFactor / 100);
            const totalMaterials = materialsSubtotal + wasteCost;

            const laborTotal = laborCost * roofSquares;
            const tearOffTotal = tearOffCost * roofSquares;

            const costSubtotal = totalMaterials + laborTotal + tearOffTotal;
            const taxRate = 0.08;
            const taxAmount = costSubtotal * taxRate;
            const finalTotal = costSubtotal + taxAmount;

            // Convert to USD first if not already USD
            const finalTotalUSD = finalTotal / exchangeRates[selectedCurrency];

            // Update pitch visual
            const pitchAngle = Math.atan(pitch / 12) * (180 / Math.PI);
            document.getElementById('pitchVisual').style.background = `linear-gradient(${pitchAngle}deg, #e0e0e0 50%, transparent 50%)`;

            // Update UI
            document.getElementById('totalCost').textContent = symbol + Math.round(finalTotal).toLocaleString();
            document.getElementById('roofArea').textContent = roofSquares.toFixed(1) + ' sq';
            document.getElementById('materialsCost').textContent = symbol + Math.round(totalMaterials).toLocaleString();

            document.getElementById('pitchValue').textContent = pitch + '/12';
            document.getElementById('pitchRise').textContent = pitch + '"';

            document.getElementById('shinglesCount').textContent = shinglesSquares + ' squares';
            document.getElementById('underlaymentRolls').textContent = underlaymentRolls + ' rolls';
            document.getElementById('nailsCount').textContent = nailsPounds + ' lbs';
            document.getElementById('flashingLength').textContent = flashingFeet + ' ft';

            document.getElementById('houseSize').textContent = length + "' × " + width + "'";
            document.getElementById('roofPitch').textContent = pitch + '/12';
            document.getElementById('calculatedArea').textContent = Math.round(roofArea) + ' sq ft';
            document.getElementById('roofSquares').textContent = roofSquares.toFixed(1) + ' squares';

            document.getElementById('shinglesCost').textContent = symbol + Math.round(shinglesCost);
            document.getElementById('underlaymentCost').textContent = symbol + Math.round(underlaymentCost);
            document.getElementById('flashingCost').textContent = symbol + Math.round(flashingCost);
            document.getElementById('ventilationCost').textContent = symbol + Math.round(ventilationCost);
            document.getElementById('fastenersCost').textContent = symbol + Math.round(fastenersCost);
            document.getElementById('wasteCost').textContent = symbol + Math.round(wasteCost);
            document.getElementById('subtotalMaterials').textContent = symbol + Math.round(totalMaterials);

            document.getElementById('materialsTotal').textContent = symbol + Math.round(totalMaterials);
            document.getElementById('laborTotal').textContent = symbol + Math.round(laborTotal);
            document.getElementById('tearOffCost').textContent = symbol + Math.round(tearOffTotal);
            document.getElementById('costSubtotal').textContent = symbol + Math.round(costSubtotal);
            document.getElementById('taxAmount').textContent = symbol + Math.round(taxAmount);
            document.getElementById('finalTotal').textContent = symbol + Math.round(finalTotal);

            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + Math.round(finalTotalUSD).toLocaleString();
            document.getElementById('convertEUR').textContent = '€' + Math.round(finalTotalUSD * exchangeRates.EUR).toLocaleString();
            document.getElementById('convertGBP').textContent = '£' + Math.round(finalTotalUSD * exchangeRates.GBP).toLocaleString();
            document.getElementById('convertINR').textContent = '₹' + Math.round(finalTotalUSD * exchangeRates.INR).toLocaleString();
            document.getElementById('convertCAD').textContent = 'C$' + Math.round(finalTotalUSD * exchangeRates.CAD).toLocaleString();
            document.getElementById('convertAUD').textContent = 'A$' + Math.round(finalTotalUSD * exchangeRates.AUD).toLocaleString();
        }

        window.addEventListener('load', function() {
            calculateRoofing();
        });

        // Update calculations when inputs change
        document.getElementById('currency').addEventListener('change', calculateRoofing);
        document.getElementById('pitch').addEventListener('change', calculateRoofing);
        document.getElementById('wasteFactor').addEventListener('change', calculateRoofing);
        document.getElementById('tearOff').addEventListener('change', calculateRoofing);
    </script>
</body>
</html>
