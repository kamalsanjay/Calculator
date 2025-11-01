<?php
/**
 * Rafter Calculator
 * File: construction/rafter-calculator.php
 * Description: Calculate rafter lengths, materials, and costs with multi-currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rafter Calculator - Length, Materials & Cost Estimation</title>
    <meta name="description" content="Free rafter calculator with multi-currency support. Calculate rafter lengths, estimate materials, costs in USD, EUR, GBP, INR, and more.">
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
        
        .roof-type-selector { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; }
        .roof-btn { padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; background: white; cursor: pointer; text-align: center; transition: all 0.3s; }
        .roof-btn.active { border-color: #667eea; background: #f0f4ff; }
        .roof-btn:hover { border-color: #667eea; }
        
        .roof-inputs { display: none; }
        .roof-inputs.active { display: block; }
        
        .spacing-presets { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 15px; }
        .spacing-btn { padding: 10px; border: 2px solid #e0e0e0; border-radius: 6px; background: white; cursor: pointer; text-align: center; transition: all 0.3s; font-size: 0.9rem; }
        .spacing-btn.active { border-color: #667eea; background: #f0f4ff; }
        .spacing-btn:hover { border-color: #667eea; }
        
        .roof-diagram { background: #f8f9fa; padding: 20px; border-radius: 12px; margin: 20px 0; text-align: center; }
        .roof-diagram svg { max-width: 100%; height: auto; }
        
        .warning-box { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .warning-box strong { color: #856404; }
        
        @media (max-width: 768px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .header h1 { font-size: 2rem; }
            .result-card .amount { font-size: 2.5rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .roof-type-selector { grid-template-columns: repeat(2, 1fr); }
            .spacing-presets { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏠 Rafter Calculator</h1>
            <p>Calculate rafter lengths, materials, and costs with multi-currency support</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Roof Specifications</h2>
                <form id="rafterForm">
                    <div class="form-group">
                        <label>Roof Type</label>
                        <div class="roof-type-selector">
                            <div class="roof-btn active" data-type="gable">Gable Roof</div>
                            <div class="roof-btn" data-type="hip">Hip Roof</div>
                            <div class="roof-btn" data-type="shed">Shed Roof</div>
                            <div class="roof-btn" data-type="gambrel">Gambrel</div>
                            <div class="roof-btn" data-type="mansard">Mansard</div>
                        </div>
                    </div>
                    
                    <!-- Common Inputs -->
                    <div class="roof-inputs active" id="common-inputs">
                        <div class="form-group">
                            <label for="building-width">Building Width (feet)</label>
                            <input type="number" id="building-width" value="24" min="8" step="0.1" required>
                            <small>Total width of the building (wall to wall)</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="roof-pitch">Roof Pitch</label>
                            <div class="input-group">
                                <input type="number" id="roof-pitch" value="6" min="2" max="18" step="0.5" required>
                                <select id="pitch-format" style="padding: 12px;">
                                    <option value="rise">in 12</option>
                                    <option value="degrees">degrees</option>
                                    <option value="percent">percent</option>
                                </select>
                            </div>
                            <small>Common pitches: 4/12 (low), 6/12 (medium), 12/12 (steep)</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="overhang">Overhang (inches)</label>
                            <input type="number" id="overhang" value="12" min="0" step="1" required>
                            <small>Rafter extension beyond wall (typically 12-24 inches)</small>
                        </div>
                    </div>
                    
                    <!-- Additional Hip Roof Inputs -->
                    <div class="roof-inputs" id="hip-inputs">
                        <div class="form-group">
                            <label for="building-length">Building Length (feet)</label>
                            <input type="number" id="building-length" value="30" min="8" step="0.1">
                            <small>Total length of the building</small>
                        </div>
                    </div>
                    
                    <!-- Additional Shed Roof Inputs -->
                    <div class="roof-inputs" id="shed-inputs">
                        <div class="form-group">
                            <label for="rise-height">Rise Height (feet)</label>
                            <input type="number" id="rise-height" value="4" min="1" step="0.1">
                            <small>Height difference between low and high walls</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Rafter Spacing</label>
                        <div class="spacing-presets">
                            <div class="spacing-btn active" data-spacing="12">12" OC</div>
                            <div class="spacing-btn" data-spacing="16">16" OC</div>
                            <div class="spacing-btn" data-spacing="19.2">19.2" OC</div>
                            <div class="spacing-btn" data-spacing="24">24" OC</div>
                        </div>
                        <input type="number" id="spacing" value="16" min="12" max="48" step="0.1" required>
                        <small>Distance between rafters (12", 16", 19.2", or 24" typical)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="rafter-size">Rafter Lumber Size</label>
                        <select id="rafter-size" style="padding: 12px;">
                            <option value="2x4">2×4</option>
                            <option value="2x6" selected>2×6</option>
                            <option value="2x8">2×8</option>
                            <option value="2x10">2×10</option>
                            <option value="2x12">2×12</option>
                        </select>
                        <small>Common rafter sizes based on span and load requirements</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="lumber-price">Price per Board Foot</label>
                        <div class="input-group">
                            <input type="number" id="lumber-price" value="3.50" min="0" step="0.01">
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
                        <small>Cost per board foot of lumber</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="include-hardware">Include Hardware</label>
                        <select id="include-hardware" style="padding: 12px;">
                            <option value="yes">Yes - Include hangers, connectors</option>
                            <option value="no">No - Lumber only</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Rafters</button>
                </form>
                
                <div class="roof-diagram">
                    <h3>Roof Diagram</h3>
                    <svg viewBox="0 0 300 200" xmlns="http://www.w3.org/2000/svg">
                        <rect x="50" y="150" width="200" height="20" fill="#8B4513"/>
                        <polygon points="50,150 150,50 250,150" fill="#CD5C5C"/>
                        <line x1="150" y1="50" x2="150" y2="150" stroke="#667eea" stroke-width="2" stroke-dasharray="5,5"/>
                        <text x="145" y="130" text-anchor="middle" fill="#667eea" font-size="12">Rise</text>
                        <line x1="50" y1="150" x2="250" y2="150" stroke="#667eea" stroke-width="2" stroke-dasharray="5,5"/>
                        <text x="150" y="165" text-anchor="middle" fill="#667eea" font-size="12">Run</text>
                        <text x="150" y="180" text-anchor="middle" fill="#333" font-size="10">Roof Pitch Visualization</text>
                    </svg>
                </div>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Common Rafter Length</h3>
                    <div class="amount" id="rafterLength">14' 5"</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Rafters Needed</h4>
                        <div class="value" id="totalRafters">15</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$186.67</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Material Requirements</h3>
                    <div class="breakdown-item">
                        <span>Common Rafters</span>
                        <strong id="commonRafters">15 pieces</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hip Rafters</span>
                        <strong id="hipRafters">0 pieces</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Valley Rafters</span>
                        <strong id="valleyRafters">0 pieces</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ridge Board Length</span>
                        <strong id="ridgeLength">22 feet</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Board Feet</span>
                        <strong id="totalBoardFeet">53.33 BF</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Price per Board Foot</span>
                        <strong id="priceBF">$3.50</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lumber Cost</span>
                        <strong id="lumberCost">$186.67</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hardware Cost</span>
                        <strong id="hardwareCost">$45.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Project Cost</span>
                        <strong id="projectCost">$231.67</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Structural Details</h3>
                    <div class="breakdown-item">
                        <span>Roof Pitch</span>
                        <strong id="pitchDisplay">6/12 (26.57°)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Rafter Span</span>
                        <strong id="rafterSpan">12 feet</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Spacing</span>
                        <strong id="spacingDisplay">16 inches OC</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lumber Size</span>
                        <strong id="lumberSize">2×6</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$231.67</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€212.34</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£183.02</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹19,344</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAD (Canadian Dollar)</span>
                        <strong id="convertCAD">C$317.39</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>AUD (Australian Dollar)</span>
                        <strong id="convertAUD">A$347.51</strong>
                    </div>
                </div>

                <div class="warning-box">
                    <strong>Building Code Notice:</strong> Always consult local building codes for rafter sizing, spacing, and span requirements. This calculator provides estimates only - structural engineering may be required for final design.
                </div>

                <div class="breakdown">
                    <h3>Common Rafter Lengths Reference</h3>
                    <div class="breakdown-item">
                        <span>12' span @ 4/12 pitch</span>
                        <strong>12' 6"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>16' span @ 6/12 pitch</span>
                        <strong>17' 10"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>20' span @ 8/12 pitch</span>
                        <strong>23' 10"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>24' span @ 12/12 pitch</span>
                        <strong>33' 12"</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Rafter Calculation Formula:</strong> Rafter Length = √(Run² + Rise²) + Overhang. The Pythagorean theorem calculates the diagonal length. For pitch: Rise = Run × (Pitch/12). Always add overhang and account for ridge board thickness in final calculations.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🏠 Rafter Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional rafter estimation and cost calculations with multi-currency support</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('rafterForm');
        const roofButtons = document.querySelectorAll('.roof-btn');
        const spacingButtons = document.querySelectorAll('.spacing-btn');
        const roofInputs = document.querySelectorAll('.roof-inputs');

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

        // Lumber sizes (actual dimensions in inches)
        const lumberSizes = {
            '2x4': { thickness: 1.5, width: 3.5, bfPerFoot: (1.5 * 3.5) / 12 },
            '2x6': { thickness: 1.5, width: 5.5, bfPerFoot: (1.5 * 5.5) / 12 },
            '2x8': { thickness: 1.5, width: 7.25, bfPerFoot: (1.5 * 7.25) / 12 },
            '2x10': { thickness: 1.5, width: 9.25, bfPerFoot: (1.5 * 9.25) / 12 },
            '2x12': { thickness: 1.5, width: 11.25, bfPerFoot: (1.5 * 11.25) / 12 }
        };

        // Set up roof type selector
        roofButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                roofButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Show corresponding inputs
                const roofType = this.getAttribute('data-type');
                document.getElementById('common-inputs').classList.add('active');
                
                // Hide all specialty inputs first
                document.getElementById('hip-inputs').classList.remove('active');
                document.getElementById('shed-inputs').classList.remove('active');
                
                // Show specialty inputs if needed
                if (roofType === 'hip') {
                    document.getElementById('hip-inputs').classList.add('active');
                } else if (roofType === 'shed') {
                    document.getElementById('shed-inputs').classList.add('active');
                }
                
                // Recalculate
                calculateRafters();
            });
        });

        // Set up spacing presets
        spacingButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                spacingButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Set spacing input value
                const spacing = this.getAttribute('data-spacing');
                document.getElementById('spacing').value = spacing;
                
                // Recalculate
                calculateRafters();
            });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateRafters();
        });

        function calculateRafters() {
            // Get active roof type
            const activeRoofType = document.querySelector('.roof-btn.active').getAttribute('data-type');
            
            // Get common inputs
            const buildingWidth = parseFloat(document.getElementById('building-width').value);
            const pitchValue = parseFloat(document.getElementById('roof-pitch').value);
            const pitchFormat = document.getElementById('pitch-format').value;
            const overhang = parseFloat(document.getElementById('overhang').value);
            const spacing = parseFloat(document.getElementById('spacing').value);
            const lumberSize = document.getElementById('rafter-size').value;
            const lumberPrice = parseFloat(document.getElementById('lumber-price').value) || 0;
            const selectedCurrency = document.getElementById('currency').value;
            const includeHardware = document.getElementById('include-hardware').value === 'yes';
            
            // Convert pitch to rise in 12 format
            let pitchRise;
            let pitchDegrees;
            
            switch(pitchFormat) {
                case 'rise':
                    pitchRise = pitchValue;
                    pitchDegrees = Math.atan(pitchValue / 12) * (180 / Math.PI);
                    break;
                case 'degrees':
                    pitchDegrees = pitchValue;
                    pitchRise = Math.tan(pitchValue * Math.PI / 180) * 12;
                    break;
                case 'percent':
                    pitchRise = (pitchValue / 100) * 12;
                    pitchDegrees = Math.atan(pitchRise / 12) * (180 / Math.PI);
                    break;
            }
            
            // Calculate run (half of building width minus half of ridge board)
            const run = (buildingWidth / 2) - 0.75; // Assuming 1.5" ridge board
            
            // Calculate rise
            const rise = run * (pitchRise / 12);
            
            // Calculate rafter length using Pythagorean theorem
            const rafterLengthInches = Math.sqrt(Math.pow(run * 12, 2) + Math.pow(rise * 12, 2));
            const rafterLengthFeet = rafterLengthInches / 12;
            
            // Add overhang
            const totalRafterLengthFeet = rafterLengthFeet + (overhang / 12);
            
            // Calculate number of rafters based on building length and spacing
            let buildingLength = buildingWidth; // Default for gable roof
            
            if (activeRoofType === 'hip') {
                buildingLength = parseFloat(document.getElementById('building-length').value) || buildingWidth;
            }
            
            const numberOfRafters = Math.ceil((buildingLength * 12) / spacing) + 1;
            
            // Calculate additional rafters for complex roofs
            let hipRafters = 0;
            let valleyRafters = 0;
            
            if (activeRoofType === 'hip') {
                hipRafters = 4; // Four hip rafters for a rectangular hip roof
            } else if (activeRoofType === 'gambrel') {
                // Gambrel has two different rafter sections
                valleyRafters = numberOfRafters;
            }
            
            // Calculate total rafters
            const totalRafters = numberOfRafters + hipRafters + valleyRafters;
            
            // Calculate ridge board length
            const ridgeLength = buildingLength - (2 * run);
            
            // Calculate board feet
            const bfPerFoot = lumberSizes[lumberSize].bfPerFoot;
            const totalBoardFeet = totalRafters * totalRafterLengthFeet * bfPerFoot;
            
            // Calculate costs
            const lumberCost = totalBoardFeet * lumberPrice;
            
            // Hardware cost estimation
            let hardwareCost = 0;
            if (includeHardware) {
                // Estimate hardware costs
                const hangers = numberOfRafters * 2; // Two hangers per rafter typically
                const connectors = numberOfRafters;
                hardwareCost = (hangers * 2.5) + (connectors * 1.5); // $2.50 per hanger, $1.50 per connector
            }
            
            const totalCost = lumberCost + hardwareCost;
            
            // Convert to USD first if not already USD
            const totalCostUSD = totalCost / exchangeRates[selectedCurrency];
            
            // Format rafter length for display
            const rafterFeet = Math.floor(totalRafterLengthFeet);
            const rafterInches = Math.round((totalRafterLengthFeet - rafterFeet) * 12);
            const formattedLength = `${rafterFeet}' ${rafterInches}"`;
            
            // Get currency symbol
            const symbol = currencySymbols[selectedCurrency];
            
            // Update UI
            document.getElementById('rafterLength').textContent = formattedLength;
            document.getElementById('totalRafters').textContent = totalRafters;
            document.getElementById('totalCost').textContent = symbol + totalCost.toFixed(2);
            
            document.getElementById('commonRafters').textContent = numberOfRafters + ' pieces';
            document.getElementById('hipRafters').textContent = hipRafters + ' pieces';
            document.getElementById('valleyRafters').textContent = valleyRafters + ' pieces';
            document.getElementById('ridgeLength').textContent = ridgeLength.toFixed(1) + ' feet';
            document.getElementById('totalBoardFeet').textContent = totalBoardFeet.toFixed(2) + ' BF';
            
            document.getElementById('priceBF').textContent = symbol + lumberPrice.toFixed(2);
            document.getElementById('lumberCost').textContent = symbol + lumberCost.toFixed(2);
            document.getElementById('hardwareCost').textContent = includeHardware ? symbol + hardwareCost.toFixed(2) : 'Not included';
            document.getElementById('projectCost').textContent = symbol + totalCost.toFixed(2);
            
            document.getElementById('pitchDisplay').textContent = `${pitchRise.toFixed(1)}/12 (${pitchDegrees.toFixed(2)}°)`;
            document.getElementById('rafterSpan').textContent = run.toFixed(1) + ' feet';
            document.getElementById('spacingDisplay').textContent = spacing + ' inches OC';
            document.getElementById('lumberSize').textContent = lumberSize.toUpperCase();
            
            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + totalCostUSD.toFixed(2);
            document.getElementById('convertEUR').textContent = '€' + (totalCostUSD * exchangeRates.EUR).toFixed(2);
            document.getElementById('convertGBP').textContent = '£' + (totalCostUSD * exchangeRates.GBP).toFixed(2);
            document.getElementById('convertINR').textContent = '₹' + Math.round(totalCostUSD * exchangeRates.INR).toLocaleString();
            document.getElementById('convertCAD').textContent = 'C$' + (totalCostUSD * exchangeRates.CAD).toFixed(2);
            document.getElementById('convertAUD').textContent = 'A$' + (totalCostUSD * exchangeRates.AUD).toFixed(2);
        }

        window.addEventListener('load', function() {
            calculateRafters();
        });

        // Update calculations when currency changes
        document.getElementById('currency').addEventListener('change', calculateRafters);
        
        // Update calculations when any input changes
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('input', calculateRafters);
        });
    </script>
</body>
</html>
