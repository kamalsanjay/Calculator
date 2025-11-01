<?php
/**
 * Gravel Calculator
 * File: construction/gravel-calculator.php
 * Description: Calculate gravel volume, materials, and costs with multi-currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gravel Calculator - Volume, Materials & Cost Estimation</title>
    <meta name="description" content="Free gravel calculator with multi-currency support. Calculate gravel volume, estimate materials, costs in USD, EUR, GBP, INR, and more.">
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
        
        .depth-presets { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 15px; }
        .depth-btn { padding: 10px; border: 2px solid #e0e0e0; border-radius: 6px; background: white; cursor: pointer; text-align: center; transition: all 0.3s; font-size: 0.9rem; }
        .depth-btn.active { border-color: #667eea; background: #f0f4ff; }
        .depth-btn:hover { border-color: #667eea; }
        
        @media (max-width: 768px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .header h1 { font-size: 2rem; }
            .result-card .amount { font-size: 2.5rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .shape-selector { grid-template-columns: repeat(2, 1fr); }
            .depth-presets { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🪨 Gravel Calculator</h1>
            <p>Calculate gravel volume, materials, and costs with multi-currency support</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Project Details</h2>
                <form id="gravelForm">
                    <div class="form-group">
                        <label>Select Area Shape</label>
                        <div class="shape-selector">
                            <div class="shape-btn active" data-shape="rectangle">Rectangle</div>
                            <div class="shape-btn" data-shape="circle">Circle</div>
                            <div class="shape-btn" data-shape="triangle">Triangle</div>
                            <div class="shape-btn" data-shape="trapezoid">Trapezoid</div>
                            <div class="shape-btn" data-shape="irregular">Custom Area</div>
                        </div>
                    </div>
                    
                    <!-- Rectangle Inputs -->
                    <div class="shape-inputs active" id="rectangle-inputs">
                        <div class="form-group">
                            <label for="length">Length (feet)</label>
                            <input type="number" id="length" value="20" min="0.1" step="0.1" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="width">Width (feet)</label>
                            <input type="number" id="width" value="10" min="0.1" step="0.1" required>
                        </div>
                    </div>
                    
                    <!-- Circle Inputs -->
                    <div class="shape-inputs" id="circle-inputs">
                        <div class="form-group">
                            <label for="radius">Radius (feet)</label>
                            <input type="number" id="radius" value="8" min="0.1" step="0.1">
                        </div>
                    </div>
                    
                    <!-- Triangle Inputs -->
                    <div class="shape-inputs" id="triangle-inputs">
                        <div class="form-group">
                            <label for="base">Base (feet)</label>
                            <input type="number" id="base" value="15" min="0.1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="height">Height (feet)</label>
                            <input type="number" id="height" value="12" min="0.1" step="0.1">
                        </div>
                    </div>
                    
                    <!-- Trapezoid Inputs -->
                    <div class="shape-inputs" id="trapezoid-inputs">
                        <div class="form-group">
                            <label for="base1">Base 1 (feet)</label>
                            <input type="number" id="base1" value="20" min="0.1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="base2">Base 2 (feet)</label>
                            <input type="number" id="base2" value="15" min="0.1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="trap-height">Height (feet)</label>
                            <input type="number" id="trap-height" value="10" min="0.1" step="0.1">
                        </div>
                    </div>
                    
                    <!-- Irregular Inputs -->
                    <div class="shape-inputs" id="irregular-inputs">
                        <div class="form-group">
                            <label for="area">Total Area (square feet)</label>
                            <input type="number" id="area" value="200" min="0.1" step="0.1">
                            <small>Enter the total area to be covered with gravel</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Gravel Depth</label>
                        <div class="depth-presets">
                            <div class="depth-btn active" data-depth="2">2" (Path)</div>
                            <div class="depth-btn" data-depth="3">3" (Driveway)</div>
                            <div class="depth-btn" data-depth="4">4" (Landscape)</div>
                            <div class="depth-btn" data-depth="6">6" (Base)</div>
                        </div>
                        <input type="number" id="depth" value="2" min="0.5" step="0.5" required>
                        <small>Depth in inches (1-6 inches recommended)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="gravel-type">Gravel Type</label>
                        <select id="gravel-type" style="padding: 12px;">
                            <option value="crushed">Crushed Stone (1.35 tons/cu yd)</option>
                            <option value="pea">Pea Gravel (1.40 tons/cu yd)</option>
                            <option value="river">River Rock (1.55 tons/cu yd)</option>
                            <option value="decomposed">Decomposed Granite (1.25 tons/cu yd)</option>
                            <option value="limestone">Limestone (1.45 tons/cu yd)</option>
                            <option value="marble">Marble Chips (1.35 tons/cu yd)</option>
                        </select>
                        <small>Different gravel types have different weights and compaction rates</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="compaction">Compaction Factor</label>
                        <select id="compaction" style="padding: 12px;">
                            <option value="1.0">No Compaction (Loose)</option>
                            <option value="1.1">Light Compaction (Paths)</option>
                            <option value="1.25" selected>Standard Compaction (Driveways)</option>
                            <option value="1.4">Heavy Compaction (Base Layer)</option>
                        </select>
                        <small>Accounts for gravel settling over time</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="wasteFactor">Waste Factor (%)</label>
                        <input type="number" id="wasteFactor" value="10" min="0" max="30" step="1">
                        <small>Extra material for spillage, uneven surfaces, and future repairs</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="pricePerTon">Price per Ton</label>
                        <div class="input-group">
                            <input type="number" id="pricePerTon" value="45" min="0" step="0.01">
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
                        <small>Cost per ton of gravel (delivered)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Gravel</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Total Gravel Needed</h3>
                    <div class="amount" id="totalGravel">1.23 tons</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>In Cubic Yards</h4>
                        <div class="value" id="cubicYards">0.91</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$55.35</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Material Requirements</h3>
                    <div class="breakdown-item">
                        <span>Total Weight</span>
                        <strong id="totalWeight">2,460 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Volume in Cubic Yards</span>
                        <strong id="volumeCY">0.91 cu yd</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Volume in Cubic Feet</span>
                        <strong id="volumeCF">24.67 cu ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Bags Required (50 lb)</span>
                        <strong id="bags50">50 bags</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Delivery Truck Size</span>
                        <strong id="truckSize">1/4 ton truck</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Price per Ton</span>
                        <strong id="priceTon">$45.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gravel Cost</span>
                        <strong id="gravelCost">$49.50</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waste Factor (10%)</span>
                        <strong id="wasteCost">$4.95</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Delivery Estimate</span>
                        <strong id="deliveryCost">$50-100</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Project Cost</span>
                        <strong id="projectCost">$55.35</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$55.35</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€50.74</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£43.73</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹4,621</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAD (Canadian Dollar)</span>
                        <strong id="convertCAD">C$75.83</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>AUD (Australian Dollar)</span>
                        <strong id="convertAUD">A$83.03</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Project Details</h3>
                    <div class="breakdown-item">
                        <span>Area Covered</span>
                        <strong id="areaCovered">200 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gravel Depth</span>
                        <strong id="gravelDepth">2 inches</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gravel Type</span>
                        <strong id="gravelType">Crushed Stone</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Compaction Factor</span>
                        <strong id="compactionFactor">1.25x</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Common Project Estimates</h3>
                    <div class="breakdown-item">
                        <span>Driveway (12×40, 3")</span>
                        <strong>4.44 tons</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Path (3×50, 2")</span>
                        <strong>0.93 tons</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Patio (12×12, 4")</span>
                        <strong>1.33 tons</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Landscape (20×30, 3")</span>
                        <strong>3.70 tons</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Gravel Calculation Formula:</strong> Volume (cubic yards) = (Area in sq ft × Depth in inches) ÷ 324. Weight (tons) = Volume × Density × Compaction. Standard gravel weighs 1.35-1.55 tons per cubic yard. Always order 10-15% extra to account for compaction and waste.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🪨 Gravel Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional gravel volume and cost calculations with multi-currency support</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('gravelForm');
        const shapeButtons = document.querySelectorAll('.shape-btn');
        const depthButtons = document.querySelectorAll('.depth-btn');
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

        // Gravel type densities (tons per cubic yard)
        const gravelDensities = {
            'crushed': 1.35,
            'pea': 1.40,
            'river': 1.55,
            'decomposed': 1.25,
            'limestone': 1.45,
            'marble': 1.35
        };

        // Gravel type names
        const gravelNames = {
            'crushed': 'Crushed Stone',
            'pea': 'Pea Gravel',
            'river': 'River Rock',
            'decomposed': 'Decomposed Granite',
            'limestone': 'Limestone',
            'marble': 'Marble Chips'
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
                calculateGravel();
            });
        });

        // Set up depth presets
        depthButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                depthButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Set depth input value
                const depth = this.getAttribute('data-depth');
                document.getElementById('depth').value = depth;
                
                // Recalculate
                calculateGravel();
            });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateGravel();
        });

        function calculateGravel() {
            // Get active shape
            const activeShape = document.querySelector('.shape-btn.active').getAttribute('data-shape');
            
            // Get common inputs
            const depth = parseFloat(document.getElementById('depth').value);
            const wasteFactor = parseFloat(document.getElementById('wasteFactor').value) || 0;
            const pricePerTon = parseFloat(document.getElementById('pricePerTon').value) || 0;
            const selectedCurrency = document.getElementById('currency').value;
            const gravelType = document.getElementById('gravel-type').value;
            const compaction = parseFloat(document.getElementById('compaction').value);
            
            const density = gravelDensities[gravelType];
            let area = 0;
            let description = "";
            
            // Calculate area based on shape
            switch(activeShape) {
                case 'rectangle':
                    const length = parseFloat(document.getElementById('length').value);
                    const width = parseFloat(document.getElementById('width').value);
                    area = length * width;
                    description = `${length}' × ${width}' rectangle`;
                    break;
                    
                case 'circle':
                    const radius = parseFloat(document.getElementById('radius').value);
                    area = Math.PI * Math.pow(radius, 2);
                    description = `${radius * 2}' diameter circle`;
                    break;
                    
                case 'triangle':
                    const base = parseFloat(document.getElementById('base').value);
                    const height = parseFloat(document.getElementById('height').value);
                    area = 0.5 * base * height;
                    description = `${base}' × ${height}' triangle`;
                    break;
                    
                case 'trapezoid':
                    const base1 = parseFloat(document.getElementById('base1').value);
                    const base2 = parseFloat(document.getElementById('base2').value);
                    const trapHeight = parseFloat(document.getElementById('trap-height').value);
                    area = 0.5 * (base1 + base2) * trapHeight;
                    description = `${base1}' × ${base2}' × ${trapHeight}' trapezoid`;
                    break;
                    
                case 'irregular':
                    area = parseFloat(document.getElementById('area').value);
                    description = `${area} sq ft custom area`;
                    break;
            }
            
            // Calculate volume in cubic feet and cubic yards
            const volumeCubicFeet = area * (depth / 12); // Convert inches to feet
            const volumeCubicYards = volumeCubicFeet / 27;
            
            // Apply compaction factor
            const compactedVolumeCY = volumeCubicYards * compaction;
            
            // Apply waste factor
            const wasteMultiplier = 1 + (wasteFactor / 100);
            const adjustedVolumeCY = compactedVolumeCY * wasteMultiplier;
            
            // Calculate weight in tons
            const weightTons = adjustedVolumeCY * density;
            const weightPounds = weightTons * 2000;
            
            // Calculate costs in selected currency
            const gravelCost = weightTons * pricePerTon;
            const wasteCost = gravelCost * (wasteFactor / 100);
            const totalCost = gravelCost + wasteCost;
            
            // Convert to USD first if not already USD
            const totalCostUSD = totalCost / exchangeRates[selectedCurrency];
            
            // Calculate number of bags (50 lb bags)
            const bags50 = Math.ceil(weightPounds / 50);
            
            // Determine truck size
            let truckSize = "";
            if (weightTons < 0.5) {
                truckSize = "Pickup truck";
            } else if (weightTons < 1) {
                truckSize = "1/4 ton truck";
            } else if (weightTons < 3) {
                truckSize = "1/2 ton truck";
            } else if (weightTons < 6) {
                truckSize = "3/4 ton truck";
            } else {
                truckSize = "1 ton+ truck";
            }
            
            // Estimate delivery cost range
            let deliveryCost = "";
            if (weightTons < 1) {
                deliveryCost = "$30-60";
            } else if (weightTons < 3) {
                deliveryCost = "$50-100";
            } else if (weightTons < 6) {
                deliveryCost = "$75-150";
            } else {
                deliveryCost = "$100-200+";
            }
            
            // Get currency symbol
            const symbol = currencySymbols[selectedCurrency];
            
            // Update UI
            document.getElementById('totalGravel').textContent = weightTons.toFixed(2) + ' tons';
            document.getElementById('cubicYards').textContent = adjustedVolumeCY.toFixed(2);
            document.getElementById('totalCost').textContent = symbol + totalCost.toFixed(2);
            
            document.getElementById('totalWeight').textContent = Math.round(weightPounds).toLocaleString() + ' lbs';
            document.getElementById('volumeCY').textContent = adjustedVolumeCY.toFixed(2) + ' cu yd';
            document.getElementById('volumeCF').textContent = Math.round(volumeCubicFeet).toLocaleString() + ' cu ft';
            document.getElementById('bags50').textContent = bags50 + ' bags';
            document.getElementById('truckSize').textContent = truckSize;
            
            document.getElementById('priceTon').textContent = symbol + pricePerTon.toFixed(2);
            document.getElementById('gravelCost').textContent = symbol + gravelCost.toFixed(2);
            document.getElementById('wasteCost').textContent = symbol + wasteCost.toFixed(2);
            document.getElementById('deliveryCost').textContent = deliveryCost;
            document.getElementById('projectCost').textContent = symbol + totalCost.toFixed(2);
            
            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + totalCostUSD.toFixed(2);
            document.getElementById('convertEUR').textContent = '€' + (totalCostUSD * exchangeRates.EUR).toFixed(2);
            document.getElementById('convertGBP').textContent = '£' + (totalCostUSD * exchangeRates.GBP).toFixed(2);
            document.getElementById('convertINR').textContent = '₹' + Math.round(totalCostUSD * exchangeRates.INR).toLocaleString();
            document.getElementById('convertCAD').textContent = 'C$' + (totalCostUSD * exchangeRates.CAD).toFixed(2);
            document.getElementById('convertAUD').textContent = 'A$' + (totalCostUSD * exchangeRates.AUD).toFixed(2);
            
            document.getElementById('areaCovered').textContent = Math.round(area).toLocaleString() + ' sq ft';
            document.getElementById('gravelDepth').textContent = depth + ' inches';
            document.getElementById('gravelType').textContent = gravelNames[gravelType];
            document.getElementById('compactionFactor').textContent = compaction + 'x';
        }

        window.addEventListener('load', function() {
            calculateGravel();
        });

        // Update calculations when currency changes
        document.getElementById('currency').addEventListener('change', calculateGravel);
        
        // Update calculations when any input changes
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('input', calculateGravel);
        });
    </script>
</body>
</html>
