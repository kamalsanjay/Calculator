<?php
/**
 * Paint Calculator
 * File: construction/paint-calculator.php
 * Description: Calculate paint gallons needed for walls, ceilings, and trim
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paint Calculator - Estimate Paint Gallons & Cost for Walls & Ceilings</title>
    <meta name="description" content="Free paint calculator with multi-currency support. Calculate paint gallons needed for walls, ceilings, and trim. Includes coverage rates and cost estimation.">
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
        
        .metric-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px; }
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
            <h1>🎨 Paint Calculator</h1>
            <p>Calculate paint gallons needed for walls, ceilings, and trim</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Paint Area</h2>
                <form id="paintForm">
                    <div class="form-group">
                        <label>Room Dimensions</label>
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
                        <label for="ceilingHeight">Ceiling Height (feet)</label>
                        <input type="number" id="ceilingHeight" value="8" min="6" max="20" step="0.5" required>
                        <small>Standard ceiling height is 8 feet</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Paint Areas</label>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="display: flex; align-items: center; gap: 8px; font-weight: 400;">
                                <input type="checkbox" id="paintWalls" checked style="width: auto;">
                                Paint Walls
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; font-weight: 400;">
                                <input type="checkbox" id="paintCeiling" style="width: auto;">
                                Paint Ceiling
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; font-weight: 400;">
                                <input type="checkbox" id="paintTrim" style="width: auto;">
                                Paint Trim/Molding
                            </label>
                        </div>
                        <small>Select surfaces to paint</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="coats">Number of Coats</label>
                        <select id="coats">
                            <option value="1">1 Coat</option>
                            <option value="2" selected>2 Coats (Recommended)</option>
                            <option value="3">3 Coats</option>
                        </select>
                        <small>2 coats recommended for best coverage</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="coverage">Paint Coverage (sq ft/gallon)</label>
                        <select id="coverage">
                            <option value="250">250 sq ft (Rough/Textured)</option>
                            <option value="350" selected>350 sq ft (Standard)</option>
                            <option value="400">400 sq ft (Smooth/Primer)</option>
                        </select>
                        <small>Coverage varies by surface texture</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Paint Price per Gallon</label>
                        <div class="input-group">
                            <input type="number" id="pricePerGallon" value="35.00" min="0" step="0.01">
                            <select id="currency" style="padding: 12px;">
                                <option value="USD">USD $</option>
                                <option value="EUR">EUR €</option>
                                <option value="GBP">GBP £</option>
                                <option value="INR">INR ₹</option>
                                <option value="CAD">CAD $</option>
                                <option value="AUD">AUD $</option>
                            </select>
                        </div>
                        <small>Price per gallon in selected currency</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Paint</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Paint Requirements</h2>
                
                <div class="result-card">
                    <h3>Paint Needed</h3>
                    <div class="amount" id="totalGallons">2.0 gal</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Gallons</h4>
                        <div class="value" id="gallons">2.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Quarts</h4>
                        <div class="value" id="quarts">8</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$70</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Surface Areas</h3>
                    <div class="breakdown-item">
                        <span>Room Dimensions</span>
                        <strong id="roomDims">20' × 15' × 8'</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Wall Area</span>
                        <strong id="wallArea">560 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ceiling Area</span>
                        <strong id="ceilingArea">300 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Trim/Molding Area</span>
                        <strong id="trimArea">70 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Paintable Area</span>
                        <strong id="totalArea">560 sq ft</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Paint Calculation</h3>
                    <div class="breakdown-item">
                        <span>Number of Coats</span>
                        <strong id="coatsDisplay">2 coats</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Coverage Rate</span>
                        <strong id="coverageDisplay">350 sq ft/gallon</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Area to Cover (with coats)</span>
                        <strong id="totalCoverageArea">1,120 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Paint Required</span>
                        <strong id="paintRequired">3.2 gallons</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gallons to Purchase</span>
                        <strong id="gallonsToBuy">4 gallons</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Price per Gallon</span>
                        <strong id="pricePerGal">$35.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gallons Needed</span>
                        <strong id="gallonsNeeded">4 gallons</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Paint Cost</span>
                        <strong id="paintCost">$140.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Supplies (Brushes, Rollers)</span>
                        <strong id="suppliesCost">$25.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Project Cost</span>
                        <strong id="projectTotal">$165.00</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$165.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€151.80</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£130.35</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹13,778</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Pro Tip:</strong> Always buy paint in full gallons rather than quarts for better value. One gallon typically covers 350 sq ft with one coat. Textured or porous surfaces may require more paint.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🎨 Paint Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Accurate paint estimation for walls, ceilings, and trim</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('paintForm');

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
            calculatePaint();
        });

        function calculatePaint() {
            const roomLength = parseFloat(document.getElementById('roomLength').value);
            const roomWidth = parseFloat(document.getElementById('roomWidth').value);
            const ceilingHeight = parseFloat(document.getElementById('ceilingHeight').value);
            
            const paintWalls = document.getElementById('paintWalls').checked;
            const paintCeiling = document.getElementById('paintCeiling').checked;
            const paintTrim = document.getElementById('paintTrim').checked;
            
            const coats = parseInt(document.getElementById('coats').value);
            const coverage = parseFloat(document.getElementById('coverage').value);
            const pricePerGallon = parseFloat(document.getElementById('pricePerGallon').value);
            const selectedCurrency = document.getElementById('currency').value;
            
            // Calculate areas
            const wallArea = 2 * (roomLength + roomWidth) * ceilingHeight;
            const ceilingArea = roomLength * roomWidth;
            const trimArea = 2 * (roomLength + roomWidth); // Linear feet as sq ft estimate
            
            // Total paintable area
            let totalPaintArea = 0;
            if (paintWalls) totalPaintArea += wallArea;
            if (paintCeiling) totalPaintArea += ceilingArea;
            if (paintTrim) totalPaintArea += trimArea;
            
            // Calculate paint needed
            const totalCoverageArea = totalPaintArea * coats;
            const gallonsRequired = totalCoverageArea / coverage;
            const gallonsToBuy = Math.ceil(gallonsRequired);
            const quartsEquivalent = gallonsToBuy * 4;
            
            // Calculate costs
            const symbol = currencySymbols[selectedCurrency];
            const paintCost = gallonsToBuy * pricePerGallon;
            const suppliesCost = 25 * (exchangeRates[selectedCurrency]); // Supplies estimate
            const totalCost = paintCost + suppliesCost;
            
            // Currency conversions
            const totalCostUSD = totalCost / exchangeRates[selectedCurrency];
            
            // Update UI
            document.getElementById('totalGallons').textContent = gallonsToBuy.toFixed(1) + ' gal';
            document.getElementById('gallons').textContent = gallonsToBuy.toFixed(1);
            document.getElementById('quarts').textContent = quartsEquivalent;
            document.getElementById('totalCost').textContent = symbol + Math.round(totalCost);
            
            document.getElementById('roomDims').textContent = `${roomLength}' × ${roomWidth}' × ${ceilingHeight}'`;
            document.getElementById('wallArea').textContent = Math.round(wallArea) + ' sq ft';
            document.getElementById('ceilingArea').textContent = Math.round(ceilingArea) + ' sq ft';
            document.getElementById('trimArea').textContent = Math.round(trimArea) + ' sq ft';
            document.getElementById('totalArea').textContent = Math.round(totalPaintArea) + ' sq ft';
            
            document.getElementById('coatsDisplay').textContent = coats + ' coat' + (coats > 1 ? 's' : '');
            document.getElementById('coverageDisplay').textContent = coverage + ' sq ft/gallon';
            document.getElementById('totalCoverageArea').textContent = Math.round(totalCoverageArea).toLocaleString() + ' sq ft';
            document.getElementById('paintRequired').textContent = gallonsRequired.toFixed(1) + ' gallons';
            document.getElementById('gallonsToBuy').textContent = gallonsToBuy + ' gallons';
            
            document.getElementById('pricePerGal').textContent = symbol + pricePerGallon.toFixed(2);
            document.getElementById('gallonsNeeded').textContent = gallonsToBuy + ' gallons';
            document.getElementById('paintCost').textContent = symbol + paintCost.toFixed(2);
            document.getElementById('suppliesCost').textContent = symbol + suppliesCost.toFixed(2);
            document.getElementById('projectTotal').textContent = symbol + totalCost.toFixed(2);
            
            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + totalCostUSD.toFixed(2);
            document.getElementById('convertEUR').textContent = '€' + (totalCostUSD * exchangeRates.EUR).toFixed(2);
            document.getElementById('convertGBP').textContent = '£' + (totalCostUSD * exchangeRates.GBP).toFixed(2);
            document.getElementById('convertINR').textContent = '₹' + Math.round(totalCostUSD * exchangeRates.INR).toLocaleString();
        }

        window.addEventListener('load', calculatePaint);
        document.getElementById('currency').addEventListener('change', calculatePaint);
        
        // Recalculate on checkbox change
        document.getElementById('paintWalls').addEventListener('change', calculatePaint);
        document.getElementById('paintCeiling').addEventListener('change', calculatePaint);
        document.getElementById('paintTrim').addEventListener('change', calculatePaint);
    </script>
</body>
</html>