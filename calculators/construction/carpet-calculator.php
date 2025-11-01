<?php
/**
 * Carpet Calculator
 * File: construction/carpet-calculator.php
 * Description: Calculate carpet area, cost, and materials with multi-currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpet Calculator - Area, Cost & Materials Estimation</title>
    <meta name="description" content="Free carpet calculator with multi-currency support. Calculate carpet area, estimate costs in USD, EUR, GBP, INR, and plan your flooring project.">
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
        
        .info-box { background: #e8f2ff; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .header h1 { font-size: 2rem; }
            .result-card .amount { font-size: 2.5rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .dimension-inputs { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏠 Carpet Calculator</h1>
            <p>Calculate carpet area, cost, and materials with multi-currency pricing</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Room Dimensions</h2>
                <form id="carpetForm">
                    <div class="form-group">
                        <label for="roomShape">Room Shape</label>
                        <select id="roomShape">
                            <option value="rectangle">Rectangle</option>
                            <option value="square">Square</option>
                            <option value="lshape">L-Shaped</option>
                            <option value="custom">Custom Area</option>
                        </select>
                    </div>
                    
                    <div id="dimensionInputs">
                        <div class="dimension-inputs">
                            <div class="form-group">
                                <label for="length">Length (feet)</label>
                                <input type="number" id="length" value="12" min="1" step="0.5" required>
                            </div>
                            <div class="form-group">
                                <label for="width">Width (feet)</label>
                                <input type="number" id="width" value="10" min="1" step="0.5" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="carpetPrice">Carpet Price per Square Foot</label>
                        <div class="input-group">
                            <input type="number" id="carpetPrice" value="2.50" min="0" step="0.01">
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
                        <small>Cost per square foot in selected currency</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="paddingPrice">Padding Price per Square Foot</label>
                        <input type="number" id="paddingPrice" value="0.75" min="0" step="0.01">
                        <small>Optional: cost of carpet padding</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="installationCost">Installation Cost</label>
                        <input type="number" id="installationCost" value="200" min="0" step="1">
                        <small>Optional: professional installation cost</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="wastePercentage">Waste Factor</label>
                        <select id="wastePercentage">
                            <option value="5">5% (Standard rooms)</option>
                            <option value="10" selected>10% (Average)</option>
                            <option value="15">15% (Complex shapes)</option>
                            <option value="20">20% (Pattern matching)</option>
                        </select>
                        <small>Extra material for cuts and pattern matching</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Carpet Requirements</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Total Project Cost</h3>
                    <div class="amount" id="totalCost">$545.00</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Room Area</h4>
                        <div class="value" id="roomArea">120 sq ft</div>
                    </div>
                    <div class="metric-card">
                        <h4>Carpet Needed</h4>
                        <div class="value" id="carpetNeeded">132 sq ft</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Area Calculation</h3>
                    <div class="breakdown-item">
                        <span>Room Dimensions</span>
                        <strong id="roomDimensions">12' × 10'</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Room Area</span>
                        <strong id="calculatedArea">120 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waste Factor</span>
                        <strong id="wasteFactor">10% (+12 sq ft)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Carpet Needed</span>
                        <strong id="totalCarpetNeeded">132 sq ft</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Carpet Material</span>
                        <strong id="carpetMaterialCost">$330.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Carpet Padding</span>
                        <strong id="paddingCost">$99.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Installation</span>
                        <strong id="installationTotal">$200.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Subtotal</span>
                        <strong id="subtotal">$629.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax (8%)</span>
                        <strong id="taxAmount">$50.32</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Project Cost</span>
                        <strong id="finalTotal">$679.32</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$679.32</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€623.14</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£535.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹56,723</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAD (Canadian Dollar)</span>
                        <strong id="convertCAD">C$924.67</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>AUD (Australian Dollar)</span>
                        <strong id="convertAUD">A$1,019.00</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Carpet Roll Planning</h3>
                    <div class="breakdown-item">
                        <span>Standard Roll Width</span>
                        <strong>12 feet</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Rolls Needed</span>
                        <strong id="rollsNeeded">1 roll</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waste Percentage</span>
                        <strong id="actualWaste">9.1%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Seam Placement</span>
                        <strong>Along length</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Common Carpet Prices</h3>
                    <div class="breakdown-item">
                        <span>Economy Grade</span>
                        <strong>$1.50 - $2.50 / sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mid-Grade</span>
                        <strong>$2.50 - $4.50 / sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Premium Grade</span>
                        <strong>$4.50 - $7.00+ / sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Commercial Grade</span>
                        <strong>$3.00 - $6.00 / sq ft</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Pro Tip:</strong> Always add 10-15% extra carpet for waste, cuts, and pattern matching. Consider carpet padding for comfort and longevity. Professional installation typically costs $2-5 per square foot.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🏠 Carpet Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional carpet estimation with multi-currency support</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('carpetForm');
        const roomShape = document.getElementById('roomShape');
        const dimensionInputs = document.getElementById('dimensionInputs');

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

        // Update dimension inputs based on room shape
        roomShape.addEventListener('change', updateDimensionInputs);
        
        function updateDimensionInputs() {
            const shape = roomShape.value;
            let html = '';
            
            switch(shape) {
                case 'rectangle':
                case 'square':
                    html = `
                        <div class="dimension-inputs">
                            <div class="form-group">
                                <label for="length">Length (feet)</label>
                                <input type="number" id="length" value="12" min="1" step="0.5" required>
                            </div>
                            <div class="form-group">
                                <label for="width">Width (feet)</label>
                                <input type="number" id="width" value="10" min="1" step="0.5" required>
                            </div>
                        </div>
                    `;
                    break;
                case 'lshape':
                    html = `
                        <div class="form-group">
                            <label>Main Section</label>
                            <div class="dimension-inputs">
                                <input type="number" id="length1" value="12" min="1" step="0.5" placeholder="Length" required>
                                <input type="number" id="width1" value="8" min="1" step="0.5" placeholder="Width" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Extension Section</label>
                            <div class="dimension-inputs">
                                <input type="number" id="length2" value="6" min="1" step="0.5" placeholder="Length" required>
                                <input type="number" id="width2" value="4" min="1" step="0.5" placeholder="Width" required>
                            </div>
                        </div>
                    `;
                    break;
                case 'custom':
                    html = `
                        <div class="form-group">
                            <label for="totalArea">Total Area (square feet)</label>
                            <input type="number" id="totalArea" value="120" min="1" step="1" required>
                        </div>
                    `;
                    break;
            }
            
            dimensionInputs.innerHTML = html;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateCarpet();
        });

        function calculateCarpet() {
            const shape = roomShape.value;
            const carpetPrice = parseFloat(document.getElementById('carpetPrice').value) || 0;
            const paddingPrice = parseFloat(document.getElementById('paddingPrice').value) || 0;
            const installationCost = parseFloat(document.getElementById('installationCost').value) || 0;
            const wastePercentage = parseInt(document.getElementById('wastePercentage').value);
            const selectedCurrency = document.getElementById('currency').value;
            const symbol = currencySymbols[selectedCurrency];

            let roomArea = 0;

            // Calculate area based on room shape
            switch(shape) {
                case 'rectangle':
                case 'square':
                    const length = parseFloat(document.getElementById('length').value);
                    const width = parseFloat(document.getElementById('width').value);
                    roomArea = length * width;
                    document.getElementById('roomDimensions').textContent = `${length}' × ${width}'`;
                    break;
                case 'lshape':
                    const length1 = parseFloat(document.getElementById('length1').value);
                    const width1 = parseFloat(document.getElementById('width1').value);
                    const length2 = parseFloat(document.getElementById('length2').value);
                    const width2 = parseFloat(document.getElementById('width2').value);
                    roomArea = (length1 * width1) + (length2 * width2);
                    document.getElementById('roomDimensions').textContent = `L-Shape: ${length1}'×${width1}' + ${length2}'×${width2}'`;
                    break;
                case 'custom':
                    roomArea = parseFloat(document.getElementById('totalArea').value);
                    document.getElementById('roomDimensions').textContent = 'Custom Area';
                    break;
            }

            // Calculate carpet needed with waste factor
            const wasteArea = roomArea * (wastePercentage / 100);
            const totalCarpetNeeded = roomArea + wasteArea;

            // Calculate costs in selected currency
            const carpetMaterialCost = totalCarpetNeeded * carpetPrice;
            const paddingCost = totalCarpetNeeded * paddingPrice;
            const subtotal = carpetMaterialCost + paddingCost + installationCost;
            const taxRate = 0.08; // 8% tax
            const taxAmount = subtotal * taxRate;
            const finalTotal = subtotal + taxAmount;

            // Convert to USD first if not already USD
            const finalTotalUSD = finalTotal / exchangeRates[selectedCurrency];

            // Calculate rolls needed (standard 12ft wide rolls)
            const standardRollWidth = 12;
            const rollsNeeded = Math.ceil(totalCarpetNeeded / (standardRollWidth * Math.ceil(roomArea / standardRollWidth)));
            const actualWastePercentage = ((totalCarpetNeeded - roomArea) / totalCarpetNeeded * 100).toFixed(1);

            // Update UI
            document.getElementById('totalCost').textContent = symbol + finalTotal.toFixed(2);
            document.getElementById('roomArea').textContent = roomArea.toFixed(0) + ' sq ft';
            document.getElementById('carpetNeeded').textContent = totalCarpetNeeded.toFixed(0) + ' sq ft';

            document.getElementById('calculatedArea').textContent = roomArea.toFixed(0) + ' sq ft';
            document.getElementById('wasteFactor').textContent = wastePercentage + '% (+' + wasteArea.toFixed(0) + ' sq ft)';
            document.getElementById('totalCarpetNeeded').textContent = totalCarpetNeeded.toFixed(0) + ' sq ft';

            document.getElementById('carpetMaterialCost').textContent = symbol + carpetMaterialCost.toFixed(2);
            document.getElementById('paddingCost').textContent = symbol + paddingCost.toFixed(2);
            document.getElementById('installationTotal').textContent = symbol + installationCost.toFixed(2);
            document.getElementById('subtotal').textContent = symbol + subtotal.toFixed(2);
            document.getElementById('taxAmount').textContent = symbol + taxAmount.toFixed(2);
            document.getElementById('finalTotal').textContent = symbol + finalTotal.toFixed(2);

            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + finalTotalUSD.toFixed(2);
            document.getElementById('convertEUR').textContent = '€' + (finalTotalUSD * exchangeRates.EUR).toFixed(2);
            document.getElementById('convertGBP').textContent = '£' + (finalTotalUSD * exchangeRates.GBP).toFixed(2);
            document.getElementById('convertINR').textContent = '₹' + Math.round(finalTotalUSD * exchangeRates.INR).toLocaleString();
            document.getElementById('convertCAD').textContent = 'C$' + (finalTotalUSD * exchangeRates.CAD).toFixed(2);
            document.getElementById('convertAUD').textContent = 'A$' + (finalTotalUSD * exchangeRates.AUD).toFixed(2);

            document.getElementById('rollsNeeded').textContent = rollsNeeded + ' roll' + (rollsNeeded !== 1 ? 's' : '');
            document.getElementById('actualWaste').textContent = actualWastePercentage + '%';
        }

        window.addEventListener('load', function() {
            updateDimensionInputs();
            calculateCarpet();
        });

        // Update calculations when inputs change
        document.getElementById('currency').addEventListener('change', calculateCarpet);
        document.getElementById('wastePercentage').addEventListener('change', calculateCarpet);
    </script>
</body>
</html>
