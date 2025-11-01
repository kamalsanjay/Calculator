<?php
/**
 * Flooring Calculator
 * File: construction/flooring-calculator.php
 * Description: Calculate flooring materials needed for hardwood, laminate, vinyl, and tile
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flooring Calculator - Estimate Hardwood, Laminate & Vinyl Materials</title>
    <meta name="description" content="Free flooring calculator with multi-currency support. Calculate square footage, materials, and costs for hardwood, laminate, vinyl, and tile flooring projects.">
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
        
        .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
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
            .input-row { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 Flooring Calculator</h1>
            <p>Calculate materials and costs for hardwood, laminate, vinyl, and tile flooring</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Room Dimensions</h2>
                <form id="flooringForm">
                    <div class="form-group">
                        <label>Room Size</label>
                        <div class="input-row">
                            <div>
                                <input type="number" id="roomLength" value="20" min="1" step="0.5" required>
                                <small>Length (feet)</small>
                            </div>
                            <div>
                                <input type="number" id="roomWidth" value="15" min="1" step="0.5" required>
                                <small>Width (feet)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="flooringType">Flooring Type</label>
                        <select id="flooringType">
                            <option value="hardwood">Hardwood</option>
                            <option value="laminate">Laminate</option>
                            <option value="vinyl">Vinyl Plank/Tile</option>
                            <option value="tile">Ceramic/Porcelain Tile</option>
                            <option value="carpet">Carpet</option>
                        </select>
                        <small>Select flooring material type</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="plankWidth">Plank/Tile Width (inches)</label>
                        <select id="plankWidth">
                            <option value="3">3 inches</option>
                            <option value="5">5 inches</option>
                            <option value="7">7 inches</option>
                            <option value="12" selected>12 inches (1 foot)</option>
                            <option value="24">24 inches (2 feet)</option>
                        </select>
                        <small>Width of flooring planks or tiles</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="wastePercentage">Waste Factor (%)</label>
                        <input type="number" id="wastePercentage" value="10" min="0" max="50" step="1">
                        <small>Account for cuts and waste (5-15% typical)</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Pricing</label>
                        <div class="input-group">
                            <input type="number" id="pricePerSqFt" value="5.50" min="0" step="0.01">
                            <select id="currency" style="padding: 12px;">
                                <option value="USD">USD $</option>
                                <option value="EUR">EUR €</option>
                                <option value="GBP">GBP £</option>
                                <option value="INR">INR ₹</option>
                                <option value="CAD">CAD $</option>
                                <option value="AUD">AUD $</option>
                            </select>
                        </div>
                        <small>Price per square foot in selected currency</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="underlaymentPrice">Underlayment (optional)</label>
                        <input type="number" id="underlaymentPrice" value="0.50" min="0" step="0.01">
                        <small>Price per sq ft for underlayment/padding</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Flooring</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Total Area</h3>
                    <div class="amount" id="totalArea">330 ft²</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Materials Needed</h4>
                        <div class="value" id="materialsNeeded">330 ft²</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$1,980</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Room Details</h3>
                    <div class="breakdown-item">
                        <span>Room Dimensions</span>
                        <strong id="roomDims">20' × 15'</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Room Area</span>
                        <strong id="roomArea">300 square feet</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Flooring Type</span>
                        <strong id="flooringTypeDisplay">Hardwood</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Plank/Tile Width</span>
                        <strong id="plankWidthDisplay">12 inches</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Material Calculation</h3>
                    <div class="breakdown-item">
                        <span>Base Area</span>
                        <strong id="baseArea">300 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waste Factor (10%)</span>
                        <strong id="wasteAmount">30 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Material Needed</span>
                        <strong id="totalMaterial">330 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Boxes/Cartons (20 sq ft/box)</span>
                        <strong id="boxes">17 boxes</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Price per Square Foot</span>
                        <strong id="pricePerSq">$5.50 / sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Flooring Cost</span>
                        <strong id="flooringCost">$1,815.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Underlayment Cost</span>
                        <strong id="underlaymentCost">$165.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Project Cost</span>
                        <strong id="projectTotal">$1,980.00</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$1,980.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€1,821.60</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£1,564.20</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹1,65,330</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Additional Estimates</h3>
                    <div class="breakdown-item">
                        <span>Installation Time</span>
                        <strong id="installTime">2-3 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Labor Cost Estimate</span>
                        <strong id="laborCost">$900 - $1,500</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Trim/Molding (linear ft)</span>
                        <strong id="trimLength">70 feet</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Pro Tip:</strong> Always order 5-15% extra material to account for waste, cuts, pattern matching, and future repairs. Store extra flooring in a dry place for future use.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📦 Flooring Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Accurate flooring material and cost estimation for any project</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('flooringForm');

        // Currency conversion rates
        const exchangeRates = {
            USD: 1.00,
            EUR: 0.92,
            GBP: 0.79,
            INR: 83.50,
            CAD: 1.37,
            AUD: 1.50
        };

        const currencySymbols = {
            USD: '$',
            EUR: '€',
            GBP: '£',
            INR: '₹',
            CAD: 'C$',
            AUD: 'A$'
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateFlooring();
        });

        function calculateFlooring() {
            const roomLength = parseFloat(document.getElementById('roomLength').value);
            const roomWidth = parseFloat(document.getElementById('roomWidth').value);
            const roomArea = roomLength * roomWidth;
            
            const flooringType = document.getElementById('flooringType').value;
            const flooringTypes = {
                hardwood: 'Hardwood',
                laminate: 'Laminate',
                vinyl: 'Vinyl Plank/Tile',
                tile: 'Ceramic/Porcelain Tile',
                carpet: 'Carpet'
            };
            
            const plankWidth = parseFloat(document.getElementById('plankWidth').value);
            const wastePercentage = parseFloat(document.getElementById('wastePercentage').value);
            const pricePerSqFt = parseFloat(document.getElementById('pricePerSqFt').value);
            const underlaymentPrice = parseFloat(document.getElementById('underlaymentPrice').value);
            const selectedCurrency = document.getElementById('currency').value;
            
            // Calculate materials
            const wasteAmount = roomArea * (wastePercentage / 100);
            const totalMaterial = roomArea + wasteAmount;
            const boxes = Math.ceil(totalMaterial / 20); // 20 sq ft per box average
            
            // Calculate costs
            const symbol = currencySymbols[selectedCurrency];
            const flooringCost = totalMaterial * pricePerSqFt;
            const underlaymentCost = totalMaterial * underlaymentPrice;
            const totalCost = flooringCost + underlaymentCost;
            
            // Currency conversions
            const totalCostUSD = totalCost / exchangeRates[selectedCurrency];
            
            // Installation estimates
            const installDays = roomArea < 200 ? '1-2' : roomArea < 400 ? '2-3' : '3-5';
            const laborMin = Math.round((totalCostUSD * 0.45) / 10) * 10;
            const laborMax = Math.round((totalCostUSD * 0.75) / 10) * 10;
            
            // Trim length (perimeter)
            const trimLength = (roomLength * 2 + roomWidth * 2);
            
            // Update UI
            document.getElementById('totalArea').textContent = Math.round(totalMaterial) + ' ft²';
            document.getElementById('materialsNeeded').textContent = Math.round(totalMaterial) + ' ft²';
            document.getElementById('totalCost').textContent = symbol + Math.round(totalCost).toLocaleString();
            
            document.getElementById('roomDims').textContent = `${roomLength}' × ${roomWidth}'`;
            document.getElementById('roomArea').textContent = roomArea.toFixed(0) + ' square feet';
            document.getElementById('flooringTypeDisplay').textContent = flooringTypes[flooringType];
            document.getElementById('plankWidthDisplay').textContent = plankWidth + ' inches';
            
            document.getElementById('baseArea').textContent = roomArea.toFixed(0) + ' sq ft';
            document.getElementById('wasteAmount').textContent = wasteAmount.toFixed(0) + ' sq ft';
            document.getElementById('totalMaterial').textContent = totalMaterial.toFixed(0) + ' sq ft';
            document.getElementById('boxes').textContent = boxes + ' boxes';
            
            document.getElementById('pricePerSq').textContent = symbol + pricePerSqFt.toFixed(2) + ' / sq ft';
            document.getElementById('flooringCost').textContent = symbol + flooringCost.toFixed(2);
            document.getElementById('underlaymentCost').textContent = symbol + underlaymentCost.toFixed(2);
            document.getElementById('projectTotal').textContent = symbol + totalCost.toFixed(2);
            
            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + totalCostUSD.toFixed(2);
            document.getElementById('convertEUR').textContent = '€' + (totalCostUSD * exchangeRates.EUR).toFixed(2);
            document.getElementById('convertGBP').textContent = '£' + (totalCostUSD * exchangeRates.GBP).toFixed(2);
            document.getElementById('convertINR').textContent = '₹' + Math.round(totalCostUSD * exchangeRates.INR).toLocaleString();
            
            document.getElementById('installTime').textContent = installDays + ' days';
            document.getElementById('laborCost').textContent = '$' + laborMin.toLocaleString() + ' - $' + laborMax.toLocaleString();
            document.getElementById('trimLength').textContent = Math.round(trimLength) + ' feet';
        }

        window.addEventListener('load', calculateFlooring);
        document.getElementById('currency').addEventListener('change', calculateFlooring);
    </script>
</body>
</html>