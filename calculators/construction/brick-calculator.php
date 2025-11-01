<?php
/**
 * Brick Calculator
 * File: construction/brick-calculator.php
 * Description: Calculate bricks needed for walls and structures with mortar requirements
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brick Calculator - Estimate Bricks & Mortar for Walls</title>
    <meta name="description" content="Free brick calculator with multi-currency support. Calculate bricks needed for walls, patios, and structures. Includes mortar requirements and cost estimation.">
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
            <h1>🧱 Brick Calculator</h1>
            <p>Calculate bricks needed for walls and structures with mortar requirements</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Wall Dimensions</h2>
                <form id="brickForm">
                    <div class="form-group">
                        <label>Wall Area</label>
                        <div class="input-row">
                            <div>
                                <input type="number" id="wallLength" value="20" min="1" step="0.5" required>
                                <small>Length (feet)</small>
                            </div>
                            <div>
                                <input type="number" id="wallHeight" value="8" min="1" step="0.5" required>
                                <small>Height (feet)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="brickSize">Brick Size</label>
                        <select id="brickSize">
                            <option value="standard">Standard (8" × 4")</option>
                            <option value="modular">Modular (7.625" × 3.625")</option>
                            <option value="queen">Queen (9.625" × 2.75")</option>
                            <option value="king">King (9.625" × 2.625")</option>
                            <option value="custom">Custom Size</option>
                        </select>
                        <small>Select brick dimensions</small>
                    </div>
                    
                    <div class="form-group" id="customSizeGroup" style="display: none;">
                        <label>Custom Brick Size</label>
                        <div class="input-row">
                            <div>
                                <input type="number" id="customLength" value="8" min="1" step="0.125">
                                <small>Length (inches)</small>
                            </div>
                            <div>
                                <input type="number" id="customHeight" value="4" min="1" step="0.125">
                                <small>Height (inches)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="mortarThickness">Mortar Joint Thickness</label>
                        <select id="mortarThickness">
                            <option value="0.375">3/8 inch</option>
                            <option value="0.5" selected>1/2 inch (standard)</option>
                            <option value="0.625">5/8 inch</option>
                        </select>
                        <small>Joint thickness between bricks</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="wastePercentage">Waste/Breakage (%)</label>
                        <input type="number" id="wastePercentage" value="10" min="0" max="50" step="1">
                        <small>Account for cuts and breakage (5-15% typical)</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Pricing (Optional)</label>
                        <div class="input-group">
                            <input type="number" id="pricePerBrick" value="0.50" min="0" step="0.01">
                            <select id="currency" style="padding: 12px;">
                                <option value="USD">USD $</option>
                                <option value="EUR">EUR €</option>
                                <option value="GBP">GBP £</option>
                                <option value="INR">INR ₹</option>
                                <option value="CAD">CAD $</option>
                                <option value="AUD">AUD $</option>
                            </select>
                        </div>
                        <small>Price per brick in selected currency</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Bricks</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Total Bricks Needed</h3>
                    <div class="amount" id="totalBricks">880</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Wall Area</h4>
                        <div class="value" id="wallArea">160 ft²</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$440.00</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Brick Details</h3>
                    <div class="breakdown-item">
                        <span>Wall Dimensions</span>
                        <strong id="wallDims">20' × 8'</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Wall Area</span>
                        <strong id="wallAreaDetail">160 square feet</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Brick Size</span>
                        <strong id="brickSizeDisplay">8" × 4" (Standard)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Bricks per Square Foot</span>
                        <strong id="bricksPerSqFt">5.5 bricks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Bricks Needed (No Waste)</span>
                        <strong id="bricksNoWaste">800 bricks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waste/Breakage (10%)</span>
                        <strong id="wasteBricks">80 bricks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Bricks to Order</span>
                        <strong id="totalBricksOrder">880 bricks</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Mortar Requirements</h3>
                    <div class="breakdown-item">
                        <span>Mortar Joint Thickness</span>
                        <strong id="mortarJoint">1/2 inch</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mortar Volume</span>
                        <strong id="mortarVolume">3.2 cubic feet</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mortar Bags (60 lb)</span>
                        <strong id="mortarBags">2 bags</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mortar Bags (80 lb)</span>
                        <strong id="mortarBags80">1.5 bags</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Price per Brick</span>
                        <strong id="pricePer">$0.50</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Brick Cost</span>
                        <strong id="brickCost">$440.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated Mortar Cost</span>
                        <strong id="mortarCost">$24.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Project Cost</span>
                        <strong id="projectTotal">$464.00</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$464.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€426.88</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£366.56</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹38,744</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Pro Tip:</strong> Always order 5-15% extra bricks to account for waste, breakage, and future repairs. Standard mortar coverage is approximately 30-40 bricks per 60 lb bag depending on joint thickness.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🧱 Brick Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Accurate brick and mortar estimation for construction projects</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('brickForm');
        const brickSizeSelect = document.getElementById('brickSize');
        const customSizeGroup = document.getElementById('customSizeGroup');

        // Brick dimensions (length × height in inches)
        const brickSizes = {
            standard: { length: 8, height: 4, name: 'Standard' },
            modular: { length: 7.625, height: 3.625, name: 'Modular' },
            queen: { length: 9.625, height: 2.75, name: 'Queen' },
            king: { length: 9.625, height: 2.625, name: 'King' },
            custom: { length: 8, height: 4, name: 'Custom' }
        };

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

        brickSizeSelect.addEventListener('change', function() {
            customSizeGroup.style.display = this.value === 'custom' ? 'block' : 'none';
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBricks();
        });

        function calculateBricks() {
            const wallLength = parseFloat(document.getElementById('wallLength').value);
            const wallHeight = parseFloat(document.getElementById('wallHeight').value);
            const wallArea = wallLength * wallHeight;
            
            const brickSizeType = document.getElementById('brickSize').value;
            let brickLength, brickHeight, brickName;
            
            if (brickSizeType === 'custom') {
                brickLength = parseFloat(document.getElementById('customLength').value);
                brickHeight = parseFloat(document.getElementById('customHeight').value);
                brickName = 'Custom';
            } else {
                const size = brickSizes[brickSizeType];
                brickLength = size.length;
                brickHeight = size.height;
                brickName = size.name;
            }
            
            const mortarThickness = parseFloat(document.getElementById('mortarThickness').value);
            const wastePercentage = parseFloat(document.getElementById('wastePercentage').value);
            const pricePerBrick = parseFloat(document.getElementById('pricePerBrick').value) || 0;
            const selectedCurrency = document.getElementById('currency').value;
            
            // Calculate brick dimensions with mortar
            const brickWithMortarLength = (brickLength + mortarThickness) / 12; // feet
            const brickWithMortarHeight = (brickHeight + mortarThickness) / 12; // feet
            const brickArea = brickWithMortarLength * brickWithMortarHeight;
            
            // Calculate bricks needed
            const bricksPerSqFt = 1 / brickArea;
            const bricksNoWaste = Math.ceil(wallArea * bricksPerSqFt);
            const wasteBricks = Math.ceil(bricksNoWaste * (wastePercentage / 100));
            const totalBricks = bricksNoWaste + wasteBricks;
            
            // Mortar calculations
            const mortarVolumeCuFt = (wallArea * mortarThickness) / 12;
            const mortarBags60 = Math.ceil(mortarVolumeCuFt / 0.45); // 60lb bag ~0.45 cu ft
            const mortarBags80 = (mortarVolumeCuFt / 0.60).toFixed(1); // 80lb bag ~0.60 cu ft
            
            // Cost calculations
            const symbol = currencySymbols[selectedCurrency];
            const brickCost = totalBricks * pricePerBrick;
            const mortarCost = mortarBags60 * 12; // $12 per 60lb bag estimate
            const totalCost = brickCost + mortarCost;
            
            // Currency conversions
            const totalCostUSD = totalCost / exchangeRates[selectedCurrency];
            
            // Update UI
            document.getElementById('totalBricks').textContent = totalBricks.toLocaleString();
            document.getElementById('wallArea').textContent = wallArea.toFixed(0) + ' ft²';
            document.getElementById('totalCost').textContent = symbol + brickCost.toFixed(2);
            
            document.getElementById('wallDims').textContent = `${wallLength}' × ${wallHeight}'`;
            document.getElementById('wallAreaDetail').textContent = wallArea.toFixed(0) + ' square feet';
            document.getElementById('brickSizeDisplay').textContent = `${brickLength}" × ${brickHeight}" (${brickName})`;
            document.getElementById('bricksPerSqFt').textContent = bricksPerSqFt.toFixed(1) + ' bricks';
            document.getElementById('bricksNoWaste').textContent = bricksNoWaste.toLocaleString() + ' bricks';
            document.getElementById('wasteBricks').textContent = wasteBricks.toLocaleString() + ' bricks';
            document.getElementById('totalBricksOrder').textContent = totalBricks.toLocaleString() + ' bricks';
            
            const mortarThicknessFrac = mortarThickness === 0.375 ? '3/8' : mortarThickness === 0.5 ? '1/2' : '5/8';
            document.getElementById('mortarJoint').textContent = mortarThicknessFrac + ' inch';
            document.getElementById('mortarVolume').textContent = mortarVolumeCuFt.toFixed(1) + ' cubic feet';
            document.getElementById('mortarBags').textContent = mortarBags60 + ' bags';
            document.getElementById('mortarBags80').textContent = mortarBags80 + ' bags';
            
            document.getElementById('pricePer').textContent = symbol + pricePerBrick.toFixed(2);
            document.getElementById('brickCost').textContent = symbol + brickCost.toFixed(2);
            document.getElementById('mortarCost').textContent = symbol + mortarCost.toFixed(2);
            document.getElementById('projectTotal').textContent = symbol + totalCost.toFixed(2);
            
            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + totalCostUSD.toFixed(2);
            document.getElementById('convertEUR').textContent = '€' + (totalCostUSD * exchangeRates.EUR).toFixed(2);
            document.getElementById('convertGBP').textContent = '£' + (totalCostUSD * exchangeRates.GBP).toFixed(2);
            document.getElementById('convertINR').textContent = '₹' + Math.round(totalCostUSD * exchangeRates.INR).toLocaleString();
        }

        window.addEventListener('load', calculateBricks);
        document.getElementById('currency').addEventListener('change', calculateBricks);
    </script>
</body>
</html>