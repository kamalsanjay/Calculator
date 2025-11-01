<?php
/**
 * Deck Calculator
 * File: construction/deck-calculator.php
 * Description: Calculate deck materials, costs, and construction requirements with multi-currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deck Calculator - Materials, Cost & Construction Planning</title>
    <meta name="description" content="Free deck calculator with multi-currency support. Calculate deck boards, joists, concrete, and total costs in USD, EUR, GBP, INR, and more.">
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
        
        .material-options { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .material-card { border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; cursor: pointer; transition: all 0.3s; }
        .material-card.selected { border-color: #667eea; background: #f0f4ff; }
        .material-card h4 { color: #333; margin-bottom: 5px; }
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
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #667eea; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .materials-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px; }
        .material-item { background: white; padding: 15px; border-radius: 8px; border: 2px solid #e0e0e0; }
        .material-item h4 { color: #667eea; margin-bottom: 10px; }
        .material-item .quantity { font-size: 1.5rem; font-weight: bold; color: #333; }
        
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
            .material-options { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🪵 Deck Calculator</h1>
            <p>Calculate deck materials, costs, and construction requirements</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Deck Specifications</h2>
                <form id="deckForm">
                    <div class="form-group">
                        <label for="deckShape">Deck Shape</label>
                        <select id="deckShape">
                            <option value="rectangle">Rectangle</option>
                            <option value="square">Square</option>
                            <option value="lshape">L-Shaped</option>
                            <option value="multi">Multi-Level</option>
                        </select>
                    </div>
                    
                    <div class="dimension-inputs">
                        <div class="form-group">
                            <label for="length">Length (feet)</label>
                            <input type="number" id="length" value="16" min="4" step="0.5" required>
                        </div>
                        <div class="form-group">
                            <label for="width">Width (feet)</label>
                            <input type="number" id="width" value="12" min="4" step="0.5" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="deckHeight">Deck Height (inches)</label>
                        <select id="deckHeight">
                            <option value="12">12" (Ground Level)</option>
                            <option value="24" selected>24" (Knee Level)</option>
                            <option value="36">36" (Waist Level)</option>
                            <option value="48">48" (Chest Level)</option>
                            <option value="96">96" (Second Story)</option>
                        </select>
                        <small>Distance from ground to deck surface</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Deck Board Material</label>
                        <div class="material-options">
                            <div class="material-card selected" data-material="pressure-treated" data-price="2.25">
                                <h4>Pressure Treated</h4>
                                <div class="price">$2.25/LF</div>
                                <small>Economical, durable</small>
                            </div>
                            <div class="material-card" data-material="cedar" data-price="4.50">
                                <h4>Cedar</h4>
                                <div class="price">$4.50/LF</div>
                                <small>Natural, rot-resistant</small>
                            </div>
                            <div class="material-card" data-material="composite" data-price="6.75">
                                <h4>Composite</h4>
                                <div class="price">$6.75/LF</div>
                                <small>Low maintenance</small>
                            </div>
                            <div class="material-card" data-material="ipe" data-price="12.00">
                                <h4>Ipe Hardwood</h4>
                                <div class="price">$12.00/LF</div>
                                <small>Premium, durable</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="boardWidth">Deck Board Width</label>
                        <select id="boardWidth">
                            <option value="5.5">5.5" (Standard)</option>
                            <option value="3.5">3.5" (Narrow)</option>
                            <option value="7.25">7.25" (Wide)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="joistSpacing">Joist Spacing</label>
                        <select id="joistSpacing">
                            <option value="12">12" (Composite)</option>
                            <option value="16" selected>16" (Standard)</option>
                            <option value="24">24" (Heavy Boards)</option>
                        </select>
                        <small>Distance between joists</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="footingSpacing">Footing Spacing</label>
                        <select id="footingSpacing">
                            <option value="6">6 feet</option>
                            <option value="8" selected>8 feet</option>
                            <option value="10">10 feet</option>
                            <option value="12">12 feet</option>
                        </select>
                        <small>Distance between concrete footings</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="railingLength">Railing Length (linear feet)</label>
                        <input type="number" id="railingLength" value="40" min="0" step="1">
                        <small>Total length of railing needed</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="laborCost">Labor Cost</label>
                        <div class="input-group">
                            <input type="number" id="laborCost" value="15" min="0" step="0.5">
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
                        <small>Cost per square foot for professional installation</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Deck Materials</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Deck Construction Plan</h2>
                
                <div class="result-card">
                    <h3>Total Project Cost</h3>
                    <div class="amount" id="totalCost">$3,847</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Deck Area</h4>
                        <div class="value" id="deckArea">192 sq ft</div>
                    </div>
                    <div class="metric-card">
                        <h4>Materials Cost</h4>
                        <div class="value" id="materialsCost">$1,447</div>
                    </div>
                </div>

                <div class="materials-grid">
                    <div class="material-item">
                        <h4>Deck Boards</h4>
                        <div class="quantity" id="deckBoards">38 boards</div>
                        <small>5.5" wide</small>
                    </div>
                    <div class="material-item">
                        <h4>Joists</h4>
                        <div class="quantity" id="joistsCount">13 pieces</div>
                        <small>2×8 lumber</small>
                    </div>
                    <div class="material-item">
                        <h4>Concrete Footings</h4>
                        <div class="quantity" id="footingsCount">6 footings</div>
                        <small>12" diameter</small>
                    </div>
                    <div class="material-item">
                        <h4>Beams</h4>
                        <div class="quantity" id="beamsCount">3 beams</div>
                        <small>2×10 lumber</small>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Deck Dimensions</h3>
                    <div class="breakdown-item">
                        <span>Deck Size</span>
                        <strong id="deckSize">16' × 12'</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Area</span>
                        <strong id="totalArea">192 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Perimeter</span>
                        <strong id="perimeter">56 linear ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Deck Height</span>
                        <strong id="heightDisplay">24 inches</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Materials Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Deck Boards</span>
                        <strong id="boardsCost">$864</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Joists & Beams</span>
                        <strong id="framingCost">$312</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Concrete & Footings</span>
                        <strong id="concreteCost">$180</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fasteners & Hardware</span>
                        <strong id="hardwareCost">$91</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Railing System</span>
                        <strong id="railingCost">$800</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Subtotal Materials</span>
                        <strong id="subtotalMaterials">$1,447</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Materials Cost</span>
                        <strong id="materialsTotal">$1,447</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Labor Cost</span>
                        <strong id="laborTotal">$2,880</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Subtotal</span>
                        <strong id="costSubtotal">$4,327</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax (8%)</span>
                        <strong id="taxAmount">$346</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Project Cost</span>
                        <strong id="finalTotal">$4,673</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Construction Details</h3>
                    <div class="breakdown-item">
                        <span>Joist Spacing</span>
                        <strong id="joistSpacingDisplay">16 inches</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Footing Spacing</span>
                        <strong id="footingSpacingDisplay">8 feet</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Posts Needed</span>
                        <strong id="postsCount">6 posts</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Deck Board Length</span>
                        <strong id="boardLength">12 feet</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$4,673</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€4,284</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£3,692</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹390,196</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAD (Canadian Dollar)</span>
                        <strong id="convertCAD">C$6,402</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>AUD (Australian Dollar)</span>
                        <strong id="convertAUD">A$7,010</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Building Tips:</strong> Always check local building codes for requirements. Use pressure-treated lumber for ground contact. Allow 1/8" gap between deck boards for drainage. Consider composite materials for low-maintenance decks in wet climates.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🪵 Deck Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional deck construction planning with multi-currency support</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('deckForm');
        const materialCards = document.querySelectorAll('.material-card');
        let selectedMaterial = 'pressure-treated';
        let selectedMaterialPrice = 2.25;

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
            });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateDeck();
        });

        function calculateDeck() {
            const length = parseFloat(document.getElementById('length').value);
            const width = parseFloat(document.getElementById('width').value);
            const deckHeight = parseInt(document.getElementById('deckHeight').value);
            const boardWidth = parseFloat(document.getElementById('boardWidth').value);
            const joistSpacing = parseInt(document.getElementById('joistSpacing').value);
            const footingSpacing = parseInt(document.getElementById('footingSpacing').value);
            const railingLength = parseFloat(document.getElementById('railingLength').value) || 0;
            const laborCost = parseFloat(document.getElementById('laborCost').value) || 0;
            const selectedCurrency = document.getElementById('currency').value;
            const symbol = currencySymbols[selectedCurrency];

            // Calculate deck area and perimeter
            const deckArea = length * width;
            const perimeter = 2 * (length + width);

            // Calculate deck boards
            const boardWidthFeet = boardWidth / 12;
            const boardsNeeded = Math.ceil(width / boardWidthFeet);
            const boardLinearFeet = boardsNeeded * length;
            const boardsCost = boardLinearFeet * selectedMaterialPrice;

            // Calculate joists
            const joistsNeeded = Math.ceil(length * 12 / joistSpacing) + 1;
            const joistCost = joistsNeeded * 8.50; // $8.50 per 2x8x8

            // Calculate beams
            const beamsNeeded = Math.ceil(width / footingSpacing);
            const beamCost = beamsNeeded * 22.00; // $22.00 per 2x10x12

            // Calculate footings and posts
            const footingsPerBeam = Math.ceil(length / 8) + 1;
            const totalFootings = beamsNeeded * footingsPerBeam;
            const concreteCost = totalFootings * 30.00; // $30 per footing

            // Calculate hardware and fasteners
            const hardwareCost = deckArea * 0.75; // $0.75 per sq ft

            // Calculate railing cost
            const railingCost = railingLength * 20.00; // $20 per linear foot

            // Calculate labor
            const laborTotal = laborCost * deckArea;

            // Calculate totals
            const materialsSubtotal = boardsCost + joistCost + beamCost + concreteCost + hardwareCost + railingCost;
            const costSubtotal = materialsSubtotal + laborTotal;
            const taxRate = 0.08;
            const taxAmount = costSubtotal * taxRate;
            const finalTotal = costSubtotal + taxAmount;

            // Convert to USD first if not already USD
            const finalTotalUSD = finalTotal / exchangeRates[selectedCurrency];

            // Update UI
            document.getElementById('totalCost').textContent = symbol + Math.round(finalTotal).toLocaleString();
            document.getElementById('deckArea').textContent = deckArea + ' sq ft';
            document.getElementById('materialsCost').textContent = symbol + Math.round(materialsSubtotal).toLocaleString();

            document.getElementById('deckBoards').textContent = boardsNeeded + ' boards';
            document.getElementById('joistsCount').textContent = joistsNeeded + ' pieces';
            document.getElementById('footingsCount').textContent = totalFootings + ' footings';
            document.getElementById('beamsCount').textContent = beamsNeeded + ' beams';

            document.getElementById('deckSize').textContent = length + "' × " + width + "'";
            document.getElementById('totalArea').textContent = deckArea + ' sq ft';
            document.getElementById('perimeter').textContent = perimeter + ' linear ft';
            document.getElementById('heightDisplay').textContent = deckHeight + ' inches';

            document.getElementById('boardsCost').textContent = symbol + Math.round(boardsCost);
            document.getElementById('framingCost').textContent = symbol + Math.round(joistCost + beamCost);
            document.getElementById('concreteCost').textContent = symbol + Math.round(concreteCost);
            document.getElementById('hardwareCost').textContent = symbol + Math.round(hardwareCost);
            document.getElementById('railingCost').textContent = symbol + Math.round(railingCost);
            document.getElementById('subtotalMaterials').textContent = symbol + Math.round(materialsSubtotal);

            document.getElementById('materialsTotal').textContent = symbol + Math.round(materialsSubtotal);
            document.getElementById('laborTotal').textContent = symbol + Math.round(laborTotal);
            document.getElementById('costSubtotal').textContent = symbol + Math.round(costSubtotal);
            document.getElementById('taxAmount').textContent = symbol + Math.round(taxAmount);
            document.getElementById('finalTotal').textContent = symbol + Math.round(finalTotal);

            document.getElementById('joistSpacingDisplay').textContent = joistSpacing + ' inches';
            document.getElementById('footingSpacingDisplay').textContent = footingSpacing + ' feet';
            document.getElementById('postsCount').textContent = totalFootings + ' posts';
            document.getElementById('boardLength').textContent = length + ' feet';

            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + Math.round(finalTotalUSD).toLocaleString();
            document.getElementById('convertEUR').textContent = '€' + Math.round(finalTotalUSD * exchangeRates.EUR).toLocaleString();
            document.getElementById('convertGBP').textContent = '£' + Math.round(finalTotalUSD * exchangeRates.GBP).toLocaleString();
            document.getElementById('convertINR').textContent = '₹' + Math.round(finalTotalUSD * exchangeRates.INR).toLocaleString();
            document.getElementById('convertCAD').textContent = 'C$' + Math.round(finalTotalUSD * exchangeRates.CAD).toLocaleString();
            document.getElementById('convertAUD').textContent = 'A$' + Math.round(finalTotalUSD * exchangeRates.AUD).toLocaleString();
        }

        window.addEventListener('load', function() {
            calculateDeck();
        });

        // Update calculations when inputs change
        document.getElementById('currency').addEventListener('change', calculateDeck);
        document.getElementById('deckHeight').addEventListener('change', calculateDeck);
        document.getElementById('boardWidth').addEventListener('change', calculateDeck);
        document.getElementById('joistSpacing').addEventListener('change', calculateDeck);
        document.getElementById('footingSpacing').addEventListener('change', calculateDeck);
    </script>
</body>
</html>
