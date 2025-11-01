<?php
/**
 * Drywall Calculator
 * File: construction/drywall-calculator.php
 * Description: Calculate drywall sheets, materials, and costs with multi-currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drywall Calculator - Sheet Estimation & Cost Calculation</title>
    <meta name="description" content="Free drywall calculator with multi-currency support. Calculate drywall sheets, materials, costs in USD, EUR, GBP, INR, and more.">
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
        
        .room-type-selector { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; }
        .room-btn { padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; background: white; cursor: pointer; text-align: center; transition: all 0.3s; }
        .room-btn.active { border-color: #667eea; background: #f0f4ff; }
        .room-btn:hover { border-color: #667eea; }
        
        .wall-inputs { margin-bottom: 15px; }
        .wall-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .wall-header h4 { color: #667eea; }
        .remove-wall { background: #ff6b6b; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; }
        
        .wall-dimensions { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
        
        .add-wall-btn { background: #51cf66; color: white; border: none; padding: 10px; border-radius: 8px; cursor: pointer; margin-bottom: 20px; width: 100%; }
        
        @media (max-width: 768px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .header h1 { font-size: 2rem; }
            .result-card .amount { font-size: 2.5rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .room-type-selector { grid-template-columns: repeat(2, 1fr); }
            .wall-dimensions { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🧱 Drywall Calculator</h1>
            <p>Calculate drywall sheets, materials, and costs with multi-currency support</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Room Dimensions</h2>
                <form id="drywallForm">
                    <div class="form-group">
                        <label>Room Type</label>
                        <div class="room-type-selector">
                            <div class="room-btn active" data-type="rectangular">Rectangular</div>
                            <div class="room-btn" data-type="l-shaped">L-Shaped</div>
                            <div class="room-btn" data-type="custom">Custom Walls</div>
                        </div>
                    </div>
                    
                    <!-- Rectangular Room Inputs -->
                    <div id="rectangular-inputs">
                        <div class="form-group">
                            <label for="room-length">Room Length (feet)</label>
                            <input type="number" id="room-length" value="12" min="1" step="0.1" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="room-width">Room Width (feet)</label>
                            <input type="number" id="room-width" value="10" min="1" step="0.1" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="room-height">Ceiling Height (feet)</label>
                            <input type="number" id="room-height" value="8" min="6" step="0.1" required>
                        </div>
                    </div>
                    
                    <!-- L-Shaped Room Inputs -->
                    <div id="l-shaped-inputs" style="display: none;">
                        <div class="form-group">
                            <label for="l-length1">Main Length (feet)</label>
                            <input type="number" id="l-length1" value="12" min="1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="l-width1">Main Width (feet)</label>
                            <input type="number" id="l-width1" value="10" min="1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="l-length2">Extension Length (feet)</label>
                            <input type="number" id="l-length2" value="6" min="1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="l-width2">Extension Width (feet)</label>
                            <input type="number" id="l-width2" value="4" min="1" step="0.1">
                        </div>
                        
                        <div class="form-group">
                            <label for="l-height">Ceiling Height (feet)</label>
                            <input type="number" id="l-height" value="8" min="6" step="0.1">
                        </div>
                    </div>
                    
                    <!-- Custom Walls Inputs -->
                    <div id="custom-inputs" style="display: none;">
                        <div class="form-group">
                            <label for="ceiling-height">Ceiling Height (feet)</label>
                            <input type="number" id="ceiling-height" value="8" min="6" step="0.1">
                        </div>
                        
                        <div id="walls-container">
                            <div class="wall-inputs">
                                <div class="wall-header">
                                    <h4>Wall 1</h4>
                                    <button type="button" class="remove-wall" onclick="removeWall(this)">Remove</button>
                                </div>
                                <div class="wall-dimensions">
                                    <div class="form-group">
                                        <label>Length (feet)</label>
                                        <input type="number" class="wall-length" value="12" min="1" step="0.1">
                                    </div>
                                    <div class="form-group">
                                        <label>Height (feet)</label>
                                        <input type="number" class="wall-height" value="8" min="1" step="0.1">
                                    </div>
                                    <div class="form-group">
                                        <label>Windows/Doors</label>
                                        <input type="number" class="wall-openings" value="0" min="0" step="1" placeholder="Number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" class="add-wall-btn" onclick="addWall()">+ Add Another Wall</button>
                    </div>
                    
                    <div class="form-group">
                        <label for="drywall-type">Drywall Sheet Size</label>
                        <select id="drywall-type" style="padding: 12px;">
                            <option value="4x8">4×8 feet (Standard)</option>
                            <option value="4x10">4×10 feet</option>
                            <option value="4x12">4×12 feet</option>
                            <option value="4x14">4×14 feet</option>
                        </select>
                        <small>Standard 4×8 sheets are most common for residential projects</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="wasteFactor">Waste Factor (%)</label>
                        <input type="number" id="wasteFactor" value="10" min="0" max="30" step="1">
                        <small>Extra material for cuts, mistakes, and future repairs</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="pricePerSheet">Price per Drywall Sheet</label>
                        <div class="input-group">
                            <input type="number" id="pricePerSheet" value="12" min="0" step="0.01">
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
                        <small>Cost per sheet of drywall</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="includeMaterials">Include Finishing Materials</label>
                        <select id="includeMaterials" style="padding: 12px;">
                            <option value="yes">Yes - Include tape, compound, screws</option>
                            <option value="no">No - Drywall sheets only</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Drywall</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Total Drywall Sheets Needed</h3>
                    <div class="amount" id="totalSheets">14 sheets</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Area</h4>
                        <div class="value" id="totalArea">448 sq ft</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$302.40</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Material Requirements</h3>
                    <div class="breakdown-item">
                        <span>Drywall Sheets (4×8)</span>
                        <strong id="sheetsNeeded">14 sheets</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Joint Compound</span>
                        <strong id="jointCompound">18 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Drywall Tape</span>
                        <strong id="drywallTape">250 ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Drywall Screws</span>
                        <strong id="drywallScrews">1,120 screws</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Corner Beads</span>
                        <strong id="cornerBeads">4 pieces</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Price per Sheet</span>
                        <strong id="priceSheet">$12.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Drywall Sheets Cost</span>
                        <strong id="sheetsCost">$168.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Finishing Materials</span>
                        <strong id="materialsCost">$107.40</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waste Factor (10%)</span>
                        <strong id="wasteCost">$27.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Project Cost</span>
                        <strong id="projectCost">$302.40</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$302.40</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€277.20</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£238.90</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹25,250</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAD (Canadian Dollar)</span>
                        <strong id="convertCAD">C$414.29</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>AUD (Australian Dollar)</span>
                        <strong id="convertAUD">A$453.60</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Project Details</h3>
                    <div class="breakdown-item">
                        <span>Wall Area</span>
                        <strong id="wallArea">352 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ceiling Area</span>
                        <strong id="ceilingArea">120 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Area with Waste</span>
                        <strong id="totalWithWaste">492.8 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated Labor Time</span>
                        <strong id="laborTime">2-3 days</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Common Room Estimates</h3>
                    <div class="breakdown-item">
                        <span>12×12 Bedroom</span>
                        <strong>11-13 sheets</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>16×20 Living Room</span>
                        <strong>18-22 sheets</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>10×12 Kitchen</span>
                        <strong>10-12 sheets</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>8×10 Bathroom</span>
                        <strong>8-10 sheets</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Drywall Calculation Formula:</strong> Total Area = (Wall Perimeter × Ceiling Height) + Ceiling Area. Standard 4×8 sheet covers 32 sq ft. Allow 10-15% extra for waste. One 5-gallon bucket of joint compound covers approximately 500-600 sq ft. Plan for 1 screw every 12 inches on ceilings and 16 inches on walls.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🧱 Drywall Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional drywall estimation and cost calculations with multi-currency support</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('drywallForm');
        const roomButtons = document.querySelectorAll('.room-btn');
        let wallCount = 1;

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

        // Drywall sheet sizes (width × height in feet)
        const sheetSizes = {
            '4x8': { width: 4, height: 8, area: 32 },
            '4x10': { width: 4, height: 10, area: 40 },
            '4x12': { width: 4, height: 12, area: 48 },
            '4x14': { width: 4, height: 14, area: 56 }
        };

        // Set up room type selector
        roomButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                roomButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Show corresponding inputs
                const roomType = this.getAttribute('data-type');
                document.getElementById('rectangular-inputs').style.display = roomType === 'rectangular' ? 'block' : 'none';
                document.getElementById('l-shaped-inputs').style.display = roomType === 'l-shaped' ? 'block' : 'none';
                document.getElementById('custom-inputs').style.display = roomType === 'custom' ? 'block' : 'none';
                
                // Recalculate
                calculateDrywall();
            });
        });

        function addWall() {
            wallCount++;
            const wallsContainer = document.getElementById('walls-container');
            const newWall = document.createElement('div');
            newWall.className = 'wall-inputs';
            newWall.innerHTML = `
                <div class="wall-header">
                    <h4>Wall ${wallCount}</h4>
                    <button type="button" class="remove-wall" onclick="removeWall(this)">Remove</button>
                </div>
                <div class="wall-dimensions">
                    <div class="form-group">
                        <label>Length (feet)</label>
                        <input type="number" class="wall-length" value="10" min="1" step="0.1">
                    </div>
                    <div class="form-group">
                        <label>Height (feet)</label>
                        <input type="number" class="wall-height" value="8" min="1" step="0.1">
                    </div>
                    <div class="form-group">
                        <label>Windows/Doors</label>
                        <input type="number" class="wall-openings" value="0" min="0" step="1" placeholder="Number">
                    </div>
                </div>
            `;
            wallsContainer.appendChild(newWall);
        }

        function removeWall(button) {
            if (wallCount > 1) {
                button.closest('.wall-inputs').remove();
                wallCount--;
                // Renumber remaining walls
                const walls = document.querySelectorAll('.wall-inputs');
                walls.forEach((wall, index) => {
                    wall.querySelector('h4').textContent = `Wall ${index + 1}`;
                });
                calculateDrywall();
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateDrywall();
        });

        function calculateDrywall() {
            // Get active room type
            const activeRoomType = document.querySelector('.room-btn.active').getAttribute('data-type');
            
            // Get common inputs
            const wasteFactor = parseFloat(document.getElementById('wasteFactor').value) || 0;
            const pricePerSheet = parseFloat(document.getElementById('pricePerSheet').value) || 0;
            const selectedCurrency = document.getElementById('currency').value;
            const drywallType = document.getElementById('drywall-type').value;
            const includeMaterials = document.getElementById('includeMaterials').value === 'yes';
            
            const sheetArea = sheetSizes[drywallType].area;
            let totalWallArea = 0;
            let ceilingArea = 0;
            let description = "";
            
            // Calculate area based on room type
            switch(activeRoomType) {
                case 'rectangular':
                    const roomLength = parseFloat(document.getElementById('room-length').value);
                    const roomWidth = parseFloat(document.getElementById('room-width').value);
                    const roomHeight = parseFloat(document.getElementById('room-height').value);
                    
                    // Wall area: perimeter × height
                    const wallPerimeter = 2 * (roomLength + roomWidth);
                    totalWallArea = wallPerimeter * roomHeight;
                    ceilingArea = roomLength * roomWidth;
                    description = `${roomLength}' × ${roomWidth}' × ${roomHeight}' room`;
                    break;
                    
                case 'l-shaped':
                    const lLength1 = parseFloat(document.getElementById('l-length1').value);
                    const lWidth1 = parseFloat(document.getElementById('l-width1').value);
                    const lLength2 = parseFloat(document.getElementById('l-length2').value);
                    const lWidth2 = parseFloat(document.getElementById('l-width2').value);
                    const lHeight = parseFloat(document.getElementById('l-height').value);
                    
                    // Calculate perimeter for L-shaped room
                    const lPerimeter = 2 * (lLength1 + lWidth1 + lLength2 + lWidth2) - 2 * Math.min(lWidth1, lWidth2);
                    totalWallArea = lPerimeter * lHeight;
                    ceilingArea = (lLength1 * lWidth1) + (lLength2 * lWidth2);
                    description = `L-shaped room ${lLength1}'×${lWidth1}' + ${lLength2}'×${lWidth2}'`;
                    break;
                    
                case 'custom':
                    const ceilingHeight = parseFloat(document.getElementById('ceiling-height').value);
                    const walls = document.querySelectorAll('.wall-inputs');
                    
                    walls.forEach(wall => {
                        const length = parseFloat(wall.querySelector('.wall-length').value);
                        const height = parseFloat(wall.querySelector('.wall-height').value) || ceilingHeight;
                        const openings = parseFloat(wall.querySelector('.wall-openings').value) || 0;
                        
                        // Subtract 15 sq ft for each window/door (approximate)
                        totalWallArea += (length * height) - (openings * 15);
                    });
                    
                    // For custom walls, we don't calculate ceiling automatically
                    ceilingArea = 0;
                    description = `${walls.length} custom walls`;
                    break;
            }
            
            // Total area including ceiling
            const totalArea = totalWallArea + ceilingArea;
            
            // Apply waste factor
            const wasteMultiplier = 1 + (wasteFactor / 100);
            const adjustedTotalArea = totalArea * wasteMultiplier;
            
            // Calculate number of sheets needed
            const sheetsNeeded = Math.ceil(adjustedTotalArea / sheetArea);
            
            // Calculate drywall costs
            const sheetsCost = sheetsNeeded * pricePerSheet;
            
            // Calculate finishing materials cost (if included)
            let materialsCost = 0;
            if (includeMaterials) {
                // Joint compound: 1 lb per 25 sq ft
                const jointCompound = Math.ceil(adjustedTotalArea / 25) * 8; // $8 per 25 lb bag
                
                // Drywall tape: 1 roll per 200 sq ft
                const drywallTape = Math.ceil(adjustedTotalArea / 200) * 6; // $6 per roll
                
                // Screws: 1 lb per 100 sq ft
                const screws = Math.ceil(adjustedTotalArea / 100) * 12; // $12 per 5 lb box
                
                // Corner beads: estimate based on room corners
                const cornerBeads = Math.ceil(totalWallArea / 100) * 4; // $4 per bead
                
                materialsCost = jointCompound + drywallTape + screws + cornerBeads;
            }
            
            // Calculate waste cost
            const wasteCost = (sheetsCost + materialsCost) * (wasteFactor / 100);
            
            // Total cost
            const totalCost = sheetsCost + materialsCost + wasteCost;
            
            // Convert to USD first if not already USD
            const totalCostUSD = totalCost / exchangeRates[selectedCurrency];
            
            // Calculate material quantities
            const jointCompoundLbs = Math.ceil(adjustedTotalArea / 25);
            const drywallTapeFt = Math.ceil(adjustedTotalArea / 2); // 2 sq ft per foot of tape
            const drywallScrewsCount = Math.ceil(adjustedTotalArea * 2.5); // 2.5 screws per sq ft
            const cornerBeadsCount = Math.ceil(totalWallArea / 100) * 2; // 2 beads per 100 sq ft
            
            // Estimate labor time
            let laborTime = "";
            if (adjustedTotalArea < 500) {
                laborTime = "1-2 days";
            } else if (adjustedTotalArea < 1000) {
                laborTime = "2-3 days";
            } else {
                laborTime = "3-5 days";
            }
            
            // Get currency symbol
            const symbol = currencySymbols[selectedCurrency];
            
            // Update UI
            document.getElementById('totalSheets').textContent = sheetsNeeded + ' sheets';
            document.getElementById('totalArea').textContent = Math.round(totalArea) + ' sq ft';
            document.getElementById('totalCost').textContent = symbol + totalCost.toFixed(2);
            
            document.getElementById('sheetsNeeded').textContent = sheetsNeeded + ' sheets';
            document.getElementById('jointCompound').textContent = jointCompoundLbs + ' lbs';
            document.getElementById('drywallTape').textContent = drywallTapeFt + ' ft';
            document.getElementById('drywallScrews').textContent = drywallScrewsCount.toLocaleString() + ' screws';
            document.getElementById('cornerBeads').textContent = cornerBeadsCount + ' pieces';
            
            document.getElementById('priceSheet').textContent = symbol + pricePerSheet.toFixed(2);
            document.getElementById('sheetsCost').textContent = symbol + sheetsCost.toFixed(2);
            document.getElementById('materialsCost').textContent = includeMaterials ? symbol + materialsCost.toFixed(2) : 'Not included';
            document.getElementById('wasteCost').textContent = symbol + wasteCost.toFixed(2);
            document.getElementById('projectCost').textContent = symbol + totalCost.toFixed(2);
            
            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + totalCostUSD.toFixed(2);
            document.getElementById('convertEUR').textContent = '€' + (totalCostUSD * exchangeRates.EUR).toFixed(2);
            document.getElementById('convertGBP').textContent = '£' + (totalCostUSD * exchangeRates.GBP).toFixed(2);
            document.getElementById('convertINR').textContent = '₹' + Math.round(totalCostUSD * exchangeRates.INR).toLocaleString();
            document.getElementById('convertCAD').textContent = 'C$' + (totalCostUSD * exchangeRates.CAD).toFixed(2);
            document.getElementById('convertAUD').textContent = 'A$' + (totalCostUSD * exchangeRates.AUD).toFixed(2);
            
            document.getElementById('wallArea').textContent = Math.round(totalWallArea) + ' sq ft';
            document.getElementById('ceilingArea').textContent = Math.round(ceilingArea) + ' sq ft';
            document.getElementById('totalWithWaste').textContent = Math.round(adjustedTotalArea) + ' sq ft';
            document.getElementById('laborTime').textContent = laborTime;
        }

        window.addEventListener('load', function() {
            calculateDrywall();
        });

        // Update calculations when currency changes
        document.getElementById('currency').addEventListener('change', calculateDrywall);
        
        // Update calculations when any input changes
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('input', calculateDrywall);
        });
    </script>
</body>
</html>
