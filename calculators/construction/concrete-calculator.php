<?php
/**
 * Concrete Calculator
 * File: construction/concrete-calculator.php
 * Description: Calculate concrete volume, materials, and costs with multi-currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concrete Calculator - Volume, Materials & Cost Estimation</title>
    <meta name="description" content="Free concrete calculator with multi-currency support. Calculate concrete volume, estimate materials, costs in USD, EUR, GBP, INR, and more.">
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
        
        .shape-selector { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; }
        .shape-btn { padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; background: white; cursor: pointer; text-align: center; transition: all 0.3s; }
        .shape-btn.active { border-color: #667eea; background: #f0f4ff; }
        .shape-btn:hover { border-color: #667eea; }
        
        .shape-inputs { display: none; }
        .shape-inputs.active { display: block; }
        
        @media (max-width: 768px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .header h1 { font-size: 2rem; }
            .result-card .amount { font-size: 2.5rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .shape-selector { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏗️ Concrete Calculator</h1>
            <p>Calculate concrete volume, materials, and costs with multi-currency support</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Project Details</h2>
                <form id="concreteForm">
                    <div class="form-group">
                        <label>Select Shape</label>
                        <div class="shape-selector">
                            <div class="shape-btn active" data-shape="slab">Slab</div>
                            <div class="shape-btn" data-shape="footing">Footing</div>
                            <div class="shape-btn" data-shape="column">Column</div>
                            <div class="shape-btn" data-shape="wall">Wall</div>
                            <div class="shape-btn" data-shape="tube">Tube</div>
                            <div class="shape-btn" data-shape="stairs">Stairs</div>
                        </div>
                    </div>
                    
                    <!-- Slab Inputs -->
                    <div class="shape-inputs active" id="slab-inputs">
                        <div class="form-group">
                            <label for="length">Length (feet)</label>
                            <input type="number" id="length" value="10" min="0.1" step="0.1" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="width">Width (feet)</label>
                            <input type="number" id="width" value="8" min="0.1" step="0.1" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="thickness">Thickness (inches)</label>
                            <input type="number" id="thickness" value="4" min="1" step="0.25" required>
                        </div>
                    </div>
                    
                    <!-- Footing Inputs -->
                    <div class="shape-inputs" id="footing-inputs">
                        <div class="form-group">
                            <label for="footing-length">Length (feet)</label>
                            <input type="number" id="footing-length" value="20" min="0.1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="footing-width">Width (inches)</label>
                            <input type="number" id="footing-width" value="12" min="1" step="0.25">
                        </div>
                        
                        <div class="form-group">
                            <label for="footing-depth">Depth (inches)</label>
                            <input type="number" id="footing-depth" value="8" min="1" step="0.25">
                        </div>
                    </div>
                    
                    <!-- Column Inputs -->
                    <div class="shape-inputs" id="column-inputs">
                        <div class="form-group">
                            <label for="column-diameter">Diameter (inches)</label>
                            <input type="number" id="column-diameter" value="12" min="1" step="0.25">
                        </div>
                        
                        <div class="form-group">
                            <label for="column-height">Height (feet)</label>
                            <input type="number" id="column-height" value="8" min="0.1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="column-count">Number of Columns</label>
                            <input type="number" id="column-count" value="4" min="1" step="1">
                        </div>
                    </div>
                    
                    <!-- Wall Inputs -->
                    <div class="shape-inputs" id="wall-inputs">
                        <div class="form-group">
                            <label for="wall-length">Length (feet)</label>
                            <input type="number" id="wall-length" value="20" min="0.1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="wall-height">Height (feet)</label>
                            <input type="number" id="wall-height" value="6" min="0.1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="wall-thickness">Thickness (inches)</label>
                            <input type="number" id="wall-thickness" value="8" min="1" step="0.25">
                        </div>
                    </div>
                    
                    <!-- Tube Inputs -->
                    <div class="shape-inputs" id="tube-inputs">
                        <div class="form-group">
                            <label for="tube-diameter">Diameter (inches)</label>
                            <input type="number" id="tube-diameter" value="12" min="1" step="0.25">
                        </div>
                        
                        <div class="form-group">
                            <label for="tube-depth">Depth (feet)</label>
                            <input type="number" id="tube-depth" value="3" min="0.1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="tube-count">Number of Tubes</label>
                            <input type="number" id="tube-count" value="6" min="1" step="1">
                        </div>
                    </div>
                    
                    <!-- Stairs Inputs -->
                    <div class="shape-inputs" id="stairs-inputs">
                        <div class="form-group">
                            <label for="stairs-width">Width (feet)</label>
                            <input type="number" id="stairs-width" value="3" min="0.1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="stairs-rise">Total Rise (feet)</label>
                            <input type="number" id="stairs-rise" value="8" min="0.1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="stairs-run">Total Run (feet)</label>
                            <input type="number" id="stairs-run" value="10" min="0.1" step="0.1">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="wasteFactor">Waste Factor (%)</label>
                        <input type="number" id="wasteFactor" value="10" min="0" max="50" step="1">
                        <small>Extra concrete to account for spillage and over-excavation</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="pricePerCubicYard">Price per Cubic Yard</label>
                        <div class="input-group">
                            <input type="number" id="pricePerCubicYard" value="150" min="0" step="0.01">
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
                        <small>Cost per cubic yard of ready-mix concrete</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Concrete</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Total Concrete Needed</h3>
                    <div class="amount" id="totalConcrete">0.99 cu yd</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>In Cubic Feet</h4>
                        <div class="value" id="cubicFeet">26.67</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$148.50</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Material Requirements</h3>
                    <div class="breakdown-item">
                        <span>80-lb Bags of Mix</span>
                        <strong id="bags80">45 bags</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>60-lb Bags of Mix</span>
                        <strong id="bags60">60 bags</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>40-lb Bags of Mix</span>
                        <strong id="bags40">90 bags</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ready-Mix Truckloads</span>
                        <strong id="truckloads">1 mini-truck</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Price per Cubic Yard</span>
                        <strong id="priceCY">$150.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Concrete Cost</span>
                        <strong id="concreteCost">$135.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waste Factor (10%)</span>
                        <strong id="wasteCost">$13.50</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Project Cost</span>
                        <strong id="projectCost">$148.50</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$148.50</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€136.17</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£117.32</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹12,400</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAD (Canadian Dollar)</span>
                        <strong id="convertCAD">C$203.45</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>AUD (Australian Dollar)</span>
                        <strong id="convertAUD">A$222.75</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Weight & Volume</h3>
                    <div class="breakdown-item">
                        <span>Total Weight</span>
                        <strong id="totalWeight">4,010 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Water Required</span>
                        <strong id="waterRequired">20-25 gallons</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Curing Time</span>
                        <strong id="curingTime">7-14 days</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Common Project Estimates</h3>
                    <div class="breakdown-item">
                        <span>10×10 Slab (4")</span>
                        <strong>1.23 cu yd</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Driveway (12×40, 6")</span>
                        <strong>8.89 cu yd</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Patio (12×16, 4")</span>
                        <strong>2.37 cu yd</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Sidewalk (4×50, 4")</span>
                        <strong>2.47 cu yd</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Concrete Calculation Formula:</strong> Volume = Length × Width × Height (all in consistent units). For cubic yards: divide cubic feet by 27. Standard concrete weighs about 150 lbs per cubic foot. Always order 5-10% extra to account for waste and spillage.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🏗️ Concrete Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional concrete volume and cost calculations with multi-currency support</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('concreteForm');
        const shapeButtons = document.querySelectorAll('.shape-btn');
        const shapeInputs = document.querySelectorAll('.shape-inputs');

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

        // Set up shape selector
        shapeButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons and inputs
                shapeButtons.forEach(btn => btn.classList.remove('active'));
                shapeInputs.forEach(input => input.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Show corresponding inputs
                const shape = this.getAttribute('data-shape');
                document.getElementById(`${shape}-inputs`).classList.add('active');
                
                // Recalculate
                calculateConcrete();
            });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateConcrete();
        });

        function calculateConcrete() {
            // Get active shape
            const activeShape = document.querySelector('.shape-btn.active').getAttribute('data-shape');
            
            // Get common inputs
            const wasteFactor = parseFloat(document.getElementById('wasteFactor').value) || 0;
            const pricePerCY = parseFloat(document.getElementById('pricePerCubicYard').value) || 0;
            const selectedCurrency = document.getElementById('currency').value;
            
            let volumeCubicFeet = 0;
            let description = "";
            
            // Calculate volume based on shape
            switch(activeShape) {
                case 'slab':
                    const length = parseFloat(document.getElementById('length').value);
                    const width = parseFloat(document.getElementById('width').value);
                    const thickness = parseFloat(document.getElementById('thickness').value);
                    volumeCubicFeet = length * width * (thickness / 12);
                    description = `${length}' × ${width}' × ${thickness}" slab`;
                    break;
                    
                case 'footing':
                    const fLength = parseFloat(document.getElementById('footing-length').value);
                    const fWidth = parseFloat(document.getElementById('footing-width').value);
                    const fDepth = parseFloat(document.getElementById('footing-depth').value);
                    volumeCubicFeet = fLength * (fWidth / 12) * (fDepth / 12);
                    description = `${fLength}' × ${fWidth}" × ${fDepth}" footing`;
                    break;
                    
                case 'column':
                    const diameter = parseFloat(document.getElementById('column-diameter').value);
                    const height = parseFloat(document.getElementById('column-height').value);
                    const count = parseInt(document.getElementById('column-count').value);
                    const radius = diameter / 2;
                    // Volume of cylinder: πr²h
                    volumeCubicFeet = Math.PI * Math.pow(radius/12, 2) * height * count;
                    description = `${count} × ${diameter}" diameter × ${height}' columns`;
                    break;
                    
                case 'wall':
                    const wLength = parseFloat(document.getElementById('wall-length').value);
                    const wHeight = parseFloat(document.getElementById('wall-height').value);
                    const wThickness = parseFloat(document.getElementById('wall-thickness').value);
                    volumeCubicFeet = wLength * wHeight * (wThickness / 12);
                    description = `${wLength}' × ${wHeight}' × ${wThickness}" wall`;
                    break;
                    
                case 'tube':
                    const tDiameter = parseFloat(document.getElementById('tube-diameter').value);
                    const tDepth = parseFloat(document.getElementById('tube-depth').value);
                    const tCount = parseInt(document.getElementById('tube-count').value);
                    const tRadius = tDiameter / 2;
                    volumeCubicFeet = Math.PI * Math.pow(tRadius/12, 2) * tDepth * tCount;
                    description = `${tCount} × ${tDiameter}" diameter × ${tDepth}' tubes`;
                    break;
                    
                case 'stairs':
                    const sWidth = parseFloat(document.getElementById('stairs-width').value);
                    const sRise = parseFloat(document.getElementById('stairs-rise').value);
                    const sRun = parseFloat(document.getElementById('stairs-run').value);
                    // Approximate volume for stairs
                    volumeCubicFeet = sWidth * sRun * (sRise / 2);
                    description = `${sWidth}' wide × ${sRise}' rise × ${sRun}' run stairs`;
                    break;
            }
            
            // Apply waste factor
            const wasteMultiplier = 1 + (wasteFactor / 100);
            const adjustedVolumeCubicFeet = volumeCubicFeet * wasteMultiplier;
            
            // Convert to cubic yards
            const volumeCubicYards = adjustedVolumeCubicFeet / 27;
            
            // Calculate costs in selected currency
            const concreteCost = volumeCubicYards * pricePerCY;
            const wasteCost = concreteCost * (wasteFactor / 100);
            const totalCost = concreteCost + wasteCost;
            
            // Convert to USD first if not already USD
            const totalCostUSD = totalCost / exchangeRates[selectedCurrency];
            
            // Calculate material requirements
            const bags80 = Math.ceil(adjustedVolumeCubicFeet / 0.6); // 80lb bag = 0.6 cu ft
            const bags60 = Math.ceil(adjustedVolumeCubicFeet / 0.45); // 60lb bag = 0.45 cu ft
            const bags40 = Math.ceil(adjustedVolumeCubicFeet / 0.3); // 40lb bag = 0.3 cu ft
            
            // Determine truckload size
            let truckloads = "";
            if (volumeCubicYards < 2) {
                truckloads = "1 mini-truck";
            } else if (volumeCubicYards < 10) {
                truckloads = "1 small truck";
            } else {
                const trucks = Math.ceil(volumeCubicYards / 10);
                truckloads = `${trucks} standard truck${trucks > 1 ? 's' : ''}`;
            }
            
            // Calculate weight
            const totalWeight = Math.round(adjustedVolumeCubicFeet * 150); // 150 lbs per cubic foot
            
            // Estimate water required
            const waterRequired = `${Math.round(adjustedVolumeCubicFeet * 0.75)}-${Math.round(adjustedVolumeCubicFeet * 0.9)} gallons`;
            
            // Get currency symbol
            const symbol = currencySymbols[selectedCurrency];
            
            // Update UI
            document.getElementById('totalConcrete').textContent = volumeCubicYards.toFixed(2) + ' cu yd';
            document.getElementById('cubicFeet').textContent = adjustedVolumeCubicFeet.toFixed(2);
            document.getElementById('totalCost').textContent = symbol + totalCost.toFixed(2);
            
            document.getElementById('bags80').textContent = bags80 + ' bags';
            document.getElementById('bags60').textContent = bags60 + ' bags';
            document.getElementById('bags40').textContent = bags40 + ' bags';
            document.getElementById('truckloads').textContent = truckloads;
            
            document.getElementById('priceCY').textContent = symbol + pricePerCY.toFixed(2);
            document.getElementById('concreteCost').textContent = symbol + concreteCost.toFixed(2);
            document.getElementById('wasteCost').textContent = symbol + wasteCost.toFixed(2);
            document.getElementById('projectCost').textContent = symbol + totalCost.toFixed(2);
            
            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + totalCostUSD.toFixed(2);
            document.getElementById('convertEUR').textContent = '€' + (totalCostUSD * exchangeRates.EUR).toFixed(2);
            document.getElementById('convertGBP').textContent = '£' + (totalCostUSD * exchangeRates.GBP).toFixed(2);
            document.getElementById('convertINR').textContent = '₹' + Math.round(totalCostUSD * exchangeRates.INR).toLocaleString();
            document.getElementById('convertCAD').textContent = 'C$' + (totalCostUSD * exchangeRates.CAD).toFixed(2);
            document.getElementById('convertAUD').textContent = 'A$' + (totalCostUSD * exchangeRates.AUD).toFixed(2);
            
            document.getElementById('totalWeight').textContent = totalWeight.toLocaleString() + ' lbs';
            document.getElementById('waterRequired').textContent = waterRequired;
            document.getElementById('curingTime').textContent = volumeCubicYards > 5 ? '14-28 days' : '7-14 days';
        }

        window.addEventListener('load', function() {
            calculateConcrete();
        });

        // Update calculations when currency changes
        document.getElementById('currency').addEventListener('change', calculateConcrete);
        
        // Update calculations when any input changes
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', calculateConcrete);
        });
    </script>
</body>
</html>
