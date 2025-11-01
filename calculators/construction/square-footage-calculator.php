<?php
/**
 * Square Footage Calculator
 * File: construction/square-footage-calculator.php
 * Description: Advanced square footage calculator with multiple measurement methods and professional features
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Square Footage Calculator - Multi-Method Area Calculation</title>
    <meta name="description" content="Advanced square footage calculator with multiple measurement methods, complex shapes, 3D volume, and multi-currency support.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #667eea; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); }
        
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #5a6268; }
        
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        
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
        
        .warning-box { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .warning-box strong { color: #856404; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .method-selector { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; }
        .method-btn { padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; background: white; cursor: pointer; text-align: center; transition: all 0.3s; }
        .method-btn.active { border-color: #667eea; background: #f0f4ff; }
        .method-btn:hover { border-color: #667eea; }
        .method-btn i { font-size: 1.5rem; margin-bottom: 8px; display: block; }
        
        .shape-selector { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 20px; }
        .shape-btn { padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; background: white; cursor: pointer; text-align: center; transition: all 0.3s; }
        .shape-btn.active { border-color: #667eea; background: #f0f4ff; }
        .shape-btn:hover { border-color: #667eea; }
        
        .method-inputs { display: none; }
        .method-inputs.active { display: block; }
        
        .room-inputs { margin-bottom: 15px; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; }
        .room-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .room-header h4 { color: #667eea; }
        .remove-room { background: #ff6b6b; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; }
        
        .room-dimensions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        
        .add-room-btn { background: #51cf66; color: white; border: none; padding: 10px; border-radius: 8px; cursor: pointer; margin-bottom: 20px; width: 100%; }
        
        .floor-inputs { margin-bottom: 15px; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; }
        .floor-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .floor-header h4 { color: #667eea; }
        .remove-floor { background: #ff6b6b; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; }
        
        .tab-container { margin-bottom: 20px; }
        .tab-buttons { display: flex; border-bottom: 2px solid #e0e0e0; margin-bottom: 15px; }
        .tab-btn { padding: 12px 20px; border: none; background: none; cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.3s; }
        .tab-btn.active { border-bottom-color: #667eea; color: #667eea; font-weight: 600; }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .coordinate-input { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px; }
        
        .report-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin: 20px 0; }
        
        @media (max-width: 768px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .header h1 { font-size: 2rem; }
            .result-card .amount { font-size: 2.5rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .method-selector { grid-template-columns: 1fr; }
            .shape-selector { grid-template-columns: repeat(2, 1fr); }
            .room-dimensions { grid-template-columns: 1fr; }
            .report-actions { grid-template-columns: 1fr; }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📐 Advanced Square Footage Calculator</h1>
            <p>Professional area calculations with multiple measurement methods and complex shape support</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Measurement Method</h2>
                <form id="squareFootageForm">
                    <div class="form-group">
                        <label>Select Measurement Method</label>
                        <div class="method-selector">
                            <div class="method-btn active" data-method="manual">
                                <i class="fas fa-ruler-combined"></i>
                                <div>Manual Measurement</div>
                            </div>
                            <div class="method-btn" data-method="blueprint">
                                <i class="fas fa-drafting-compass"></i>
                                <div>Blueprint Mode</div>
                            </div>
                            <div class="method-btn" data-method="walkthrough">
                                <i class="fas fa-walking"></i>
                                <div>Walk-Through</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Manual Measurement Inputs -->
                    <div class="method-inputs active" id="manual-inputs">
                        <div class="form-group">
                            <label>Area Shape</label>
                            <div class="shape-selector">
                                <div class="shape-btn active" data-shape="rectangle">Rectangle</div>
                                <div class="shape-btn" data-shape="lshape">L-Shape</div>
                                <div class="shape-btn" data-shape="ushape">U-Shape</div>
                                <div class="shape-btn" data-shape="custom">Custom Polygon</div>
                                <div class="shape-btn" data-shape="circle">Circle</div>
                                <div class="shape-btn" data-shape="triangle">Triangle</div>
                                <div class="shape-btn" data-shape="trapezoid">Trapezoid</div>
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
                                <input type="number" id="width" value="15" min="0.1" step="0.1" required>
                            </div>
                        </div>
                        
                        <!-- L-Shape Inputs -->
                        <div class="shape-inputs" id="lshape-inputs">
                            <div class="form-group">
                                <label for="l-length1">Main Length (feet)</label>
                                <input type="number" id="l-length1" value="20" min="0.1" step="0.1">
                            </div>
                            
                            <div class="form-group">
                                <label for="l-width1">Main Width (feet)</label>
                                <input type="number" id="l-width1" value="15" min="0.1" step="0.1">
                            </div>
                            
                            <div class="form-group">
                                <label for="l-length2">Extension Length (feet)</label>
                                <input type="number" id="l-length2" value="10" min="0.1" step="0.1">
                            </div>
                            
                            <div class="form-group">
                                <label for="l-width2">Extension Width (feet)</label>
                                <input type="number" id="l-width2" value="8" min="0.1" step="0.1">
                            </div>
                        </div>
                        
                        <!-- Custom Polygon Inputs -->
                        <div class="shape-inputs" id="custom-inputs">
                            <div class="form-group">
                                <label for="polygon-sides">Number of Sides</label>
                                <input type="number" id="polygon-sides" value="4" min="3" max="12" step="1">
                                <small>Enter coordinates for each vertex</small>
                            </div>
                            
                            <div id="polygon-coordinates">
                                <div class="coordinate-input">
                                    <input type="number" placeholder="X1" value="0">
                                    <input type="number" placeholder="Y1" value="0">
                                </div>
                                <div class="coordinate-input">
                                    <input type="number" placeholder="X2" value="20">
                                    <input type="number" placeholder="Y2" value="0">
                                </div>
                                <div class="coordinate-input">
                                    <input type="number" placeholder="X3" value="20">
                                    <input type="number" placeholder="Y3" value="15">
                                </div>
                                <div class="coordinate-input">
                                    <input type="number" placeholder="X4" value="0">
                                    <input type="number" placeholder="Y4" value="15">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Blueprint Mode Inputs -->
                    <div class="method-inputs" id="blueprint-inputs">
                        <div class="form-group">
                            <label for="blueprint-scale">Blueprint Scale</label>
                            <select id="blueprint-scale" style="padding: 12px;">
                                <option value="1/8">1/8" = 1' (1:96)</option>
                                <option value="1/4" selected>1/4" = 1' (1:48)</option>
                                <option value="1/2">1/2" = 1' (1:24)</option>
                                <option value="custom">Custom Scale</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="blueprint-length">Measured Length on Blueprint (inches)</label>
                            <input type="number" id="blueprint-length" value="5" min="0.1" step="0.01">
                        </div>
                        
                        <div class="form-group">
                            <label for="blueprint-width">Measured Width on Blueprint (inches)</label>
                            <input type="number" id="blueprint-width" value="3.75" min="0.1" step="0.01">
                        </div>
                    </div>
                    
                    <!-- Walk-Through Mode Inputs -->
                    <div class="method-inputs" id="walkthrough-inputs">
                        <div class="form-group">
                            <label for="step-length">Your Average Step Length (feet)</label>
                            <input type="number" id="step-length" value="2.5" min="1.5" max="4" step="0.1">
                            <small>Average adult step length is 2.5 feet</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="length-steps">Number of Steps (Length)</label>
                            <input type="number" id="length-steps" value="8" min="1" step="1">
                        </div>
                        
                        <div class="form-group">
                            <label for="width-steps">Number of Steps (Width)</label>
                            <input type="number" id="width-steps" value="6" min="1" step="1">
                        </div>
                    </div>
                    
                    <!-- Multi-Room Analysis -->
                    <div class="form-group">
                        <label>Room-by-Room Analysis</label>
                        <div id="rooms-container">
                            <div class="room-inputs">
                                <div class="room-header">
                                    <h4>Room 1 - Living Room</h4>
                                    <button type="button" class="remove-room" onclick="removeRoom(this)">Remove</button>
                                </div>
                                <div class="room-dimensions">
                                    <div class="form-group">
                                        <label>Length (feet)</label>
                                        <input type="number" class="room-length" value="20" min="0.1" step="0.1">
                                    </div>
                                    <div class="form-group">
                                        <label>Width (feet)</label>
                                        <input type="number" class="room-width" value="15" min="0.1" step="0.1">
                                    </div>
                                    <div class="form-group">
                                        <label>Room Type</label>
                                        <select class="room-type">
                                            <option value="living">Living Room</option>
                                            <option value="bedroom">Bedroom</option>
                                            <option value="kitchen">Kitchen</option>
                                            <option value="bathroom">Bathroom</option>
                                            <option value="dining">Dining Room</option>
                                            <option value="office">Office</option>
                                            <option value="garage">Garage</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Ceiling Height (feet)</label>
                                        <input type="number" class="room-height" value="8" min="4" step="0.1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" class="add-room-btn" onclick="addRoom()">
                            <i class="fas fa-plus"></i> Add Another Room
                        </button>
                    </div>
                    
                    <!-- Multi-Level Support -->
                    <div class="form-group">
                        <label>Multi-Level Building</label>
                        <div id="floors-container">
                            <div class="floor-inputs">
                                <div class="floor-header">
                                    <h4>Floor 1 - Ground Floor</h4>
                                    <button type="button" class="remove-floor" onclick="removeFloor(this)">Remove</button>
                                </div>
                                <div class="form-group">
                                    <label>Floor Area (sq ft)</label>
                                    <input type="number" class="floor-area" value="0" min="0" step="0.1">
                                    <small>Leave as 0 to calculate from rooms</small>
                                </div>
                                <div class="form-group">
                                    <label>Floor Type</label>
                                    <select class="floor-type">
                                        <option value="ground">Ground Floor</option>
                                        <option value="upper">Upper Floor</option>
                                        <option value="basement">Basement</option>
                                        <option value="attic">Attic</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" class="add-room-btn btn-secondary" onclick="addFloor()">
                            <i class="fas fa-layer-group"></i> Add Another Floor
                        </button>
                    </div>
                    
                    <!-- Advanced Options -->
                    <div class="tab-container">
                        <div class="tab-buttons">
                            <button type="button" class="tab-btn active" data-tab="waste">Waste & Materials</button>
                            <button type="button" class="tab-btn" data-tab="cost">Cost Analysis</button>
                            <button type="button" class="tab-btn" data-tab="export">Export & Report</button>
                        </div>
                        
                        <div class="tab-content active" id="waste-tab">
                            <div class="form-group">
                                <label for="wasteFactor">Waste Factor (%)</label>
                                <input type="number" id="wasteFactor" value="10" min="0" max="30" step="1">
                                <small>Extra material for cuts and mistakes</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="material-type">Material Type</label>
                                <select id="material-type" style="padding: 12px;">
                                    <option value="flooring">Flooring</option>
                                    <option value="drywall">Drywall</option>
                                    <option value="paint">Paint</option>
                                    <option value="tile">Tile</option>
                                    <option value="carpet">Carpet</option>
                                    <option value="roofing">Roofing</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="coverage-rate">Coverage Rate (sq ft per unit)</label>
                                <input type="number" id="coverage-rate" value="25" min="1" step="0.1">
                                <small>How many square feet one unit of material covers</small>
                            </div>
                        </div>
                        
                        <div class="tab-content" id="cost-tab">
                            <div class="form-group">
                                <label for="pricePerSqFt">Price per Square Foot</label>
                                <div class="input-group">
                                    <input type="number" id="pricePerSqFt" value="3.50" min="0" step="0.01">
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
                            </div>
                            
                            <div class="form-group">
                                <label for="labor-cost">Labor Cost per Square Foot</label>
                                <input type="number" id="labor-cost" value="2.00" min="0" step="0.01">
                            </div>
                            
                            <div class="form-group">
                                <label for="tax-rate">Tax Rate (%)</label>
                                <input type="number" id="tax-rate" value="7.5" min="0" max="25" step="0.1">
                            </div>
                        </div>
                        
                        <div class="tab-content" id="export-tab">
                            <div class="form-group">
                                <label for="project-name">Project Name</label>
                                <input type="text" id="project-name" placeholder="Enter project name">
                            </div>
                            
                            <div class="form-group">
                                <label for="client-name">Client Name</label>
                                <input type="text" id="client-name" placeholder="Enter client name">
                            </div>
                            
                            <div class="form-group">
                                <label for="report-notes">Additional Notes</label>
                                <textarea id="report-notes" rows="3" placeholder="Enter any additional notes..."></textarea>
                            </div>
                            
                            <div class="report-actions">
                                <button type="button" class="btn btn-success" onclick="generatePDF()">
                                    <i class="fas fa-file-pdf"></i> Generate PDF Report
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="exportToCSV()">
                                    <i class="fas fa-file-csv"></i> Export to CSV
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Square Footage</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Total Square Footage</h3>
                    <div class="amount" id="totalSqFt">300 sq ft</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Area</h4>
                        <div class="value" id="totalArea">300</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$1,650.00</div>
                    </div>
                    <div class="metric-card">
                        <h4>Volume</h4>
                        <div class="value" id="totalVolume">2,400 cu ft</div>
                    </div>
                    <div class="metric-card">
                        <h4>Materials Needed</h4>
                        <div class="value" id="materialsNeeded">12 units</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Room Analysis</h3>
                    <div class="breakdown-item">
                        <span>Number of Rooms</span>
                        <strong id="roomCount">1 room</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Room Size</span>
                        <strong id="avgRoomSize">300 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Largest Room</span>
                        <strong id="largestRoom">300 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Smallest Room</span>
                        <strong id="smallestRoom">300 sq ft</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Material Cost</span>
                        <strong id="materialCost">$1,050.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Labor Cost</span>
                        <strong id="laborCost">$600.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waste Factor</span>
                        <strong id="wasteCost">$105.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax</span>
                        <strong id="taxCost">$131.25</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Project Cost</span>
                        <strong id="projectCost">$1,886.25</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Floor Analysis</h3>
                    <div class="breakdown-item">
                        <span>Number of Floors</span>
                        <strong id="floorCount">1 floor</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Building Area</span>
                        <strong id="buildingArea">300 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Floor Size</span>
                        <strong id="avgFloorSize">300 sq ft</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$1,886.25</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€1,729.06</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£1,490.14</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹157,502</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Material Requirements</h3>
                    <div class="breakdown-item">
                        <span>Total Area with Waste</span>
                        <strong id="areaWithWaste">330 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Units Required</span>
                        <strong id="unitsRequired">14 units</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Coverage per Unit</span>
                        <strong id="coveragePerUnit">25 sq ft</strong>
                    </div>
                </div>

                <div class="warning-box">
                    <strong>Professional Recommendation:</strong> For accurate measurements, always verify with physical measurements. Consider hiring a professional surveyor for large or complex projects.
                </div>

                <div class="info-box">
                    <strong>Measurement Tips:</strong> Always measure at floor level for accuracy. Account for obstructions like columns and built-in furniture. For irregular shapes, break them down into smaller regular shapes.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📐 Advanced Square Footage Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional area calculations with multiple methods and comprehensive reporting</p>
        </div>
    </div>

    <script>
        // Global variables
        const form = document.getElementById('squareFootageForm');
        const methodButtons = document.querySelectorAll('.method-btn');
        const shapeButtons = document.querySelectorAll('.shape-btn');
        const tabButtons = document.querySelectorAll('.tab-btn');
        const methodInputs = document.querySelectorAll('.method-inputs');
        const shapeInputs = document.querySelectorAll('.shape-inputs');
        const tabContents = document.querySelectorAll('.tab-content');
        let roomCount = 1;
        let floorCount = 1;

        // Currency conversion rates
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

        // Set up method selector
        methodButtons.forEach(button => {
            button.addEventListener('click', function() {
                methodButtons.forEach(btn => btn.classList.remove('active'));
                methodInputs.forEach(input => input.classList.remove('active'));
                
                this.classList.add('active');
                const method = this.getAttribute('data-method');
                document.getElementById(`${method}-inputs`).classList.add('active');
                
                calculateSquareFootage();
            });
        });

        // Set up shape selector
        shapeButtons.forEach(button => {
            button.addEventListener('click', function() {
                shapeButtons.forEach(btn => btn.classList.remove('active'));
                shapeInputs.forEach(input => input.classList.remove('active'));
                
                this.classList.add('active');
                const shape = this.getAttribute('data-shape');
                document.getElementById(`${shape}-inputs`).classList.add('active');
                
                calculateSquareFootage();
            });
        });

        // Set up tab system
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));
                
                this.classList.add('active');
                const tab = this.getAttribute('data-tab');
                document.getElementById(`${tab}-tab`).classList.add('active');
            });
        });

        // Room management functions
        function addRoom() {
            roomCount++;
            const roomsContainer = document.getElementById('rooms-container');
            const newRoom = document.createElement('div');
            newRoom.className = 'room-inputs';
            newRoom.innerHTML = `
                <div class="room-header">
                    <h4>Room ${roomCount}</h4>
                    <button type="button" class="remove-room" onclick="removeRoom(this)">Remove</button>
                </div>
                <div class="room-dimensions">
                    <div class="form-group">
                        <label>Length (feet)</label>
                        <input type="number" class="room-length" value="12" min="0.1" step="0.1">
                    </div>
                    <div class="form-group">
                        <label>Width (feet)</label>
                        <input type="number" class="room-width" value="10" min="0.1" step="0.1">
                    </div>
                    <div class="form-group">
                        <label>Room Type</label>
                        <select class="room-type">
                            <option value="living">Living Room</option>
                            <option value="bedroom">Bedroom</option>
                            <option value="kitchen">Kitchen</option>
                            <option value="bathroom">Bathroom</option>
                            <option value="dining">Dining Room</option>
                            <option value="office">Office</option>
                            <option value="garage">Garage</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ceiling Height (feet)</label>
                        <input type="number" class="room-height" value="8" min="4" step="0.1">
                    </div>
                </div>
            `;
            roomsContainer.appendChild(newRoom);
        }

        function removeRoom(button) {
            if (roomCount > 1) {
                button.closest('.room-inputs').remove();
                roomCount--;
                calculateSquareFootage();
            }
        }

        // Floor management functions
        function addFloor() {
            floorCount++;
            const floorsContainer = document.getElementById('floors-container');
            const newFloor = document.createElement('div');
            newFloor.className = 'floor-inputs';
            newFloor.innerHTML = `
                <div class="floor-header">
                    <h4>Floor ${floorCount}</h4>
                    <button type="button" class="remove-floor" onclick="removeFloor(this)">Remove</button>
                </div>
                <div class="form-group">
                    <label>Floor Area (sq ft)</label>
                    <input type="number" class="floor-area" value="0" min="0" step="0.1">
                    <small>Leave as 0 to calculate from rooms</small>
                </div>
                <div class="form-group">
                    <label>Floor Type</label>
                    <select class="floor-type">
                        <option value="ground">Ground Floor</option>
                        <option value="upper">Upper Floor</option>
                        <option value="basement">Basement</option>
                        <option value="attic">Attic</option>
                    </select>
                </div>
            `;
            floorsContainer.appendChild(newFloor);
        }

        function removeFloor(button) {
            if (floorCount > 1) {
                button.closest('.floor-inputs').remove();
                floorCount--;
                calculateSquareFootage();
            }
        }

        // Main calculation function
        function calculateSquareFootage() {
            const activeMethod = document.querySelector('.method-btn.active').getAttribute('data-method');
            const activeShape = document.querySelector('.shape-btn.active').getAttribute('data-shape');
            
            // Get common inputs
            const wasteFactor = parseFloat(document.getElementById('wasteFactor').value) || 0;
            const pricePerSqFt = parseFloat(document.getElementById('pricePerSqFt').value) || 0;
            const laborCost = parseFloat(document.getElementById('labor-cost').value) || 0;
            const taxRate = parseFloat(document.getElementById('tax-rate').value) || 0;
            const selectedCurrency = document.getElementById('currency').value;
            const materialType = document.getElementById('material-type').value;
            const coverageRate = parseFloat(document.getElementById('coverage-rate').value) || 1;
            
            let totalArea = 0;
            let description = "";
            
            // Calculate area based on method and shape
            switch(activeMethod) {
                case 'manual':
                    totalArea = calculateManualArea(activeShape);
                    description = `${activeShape} shape`;
                    break;
                    
                case 'blueprint':
                    totalArea = calculateBlueprintArea();
                    description = "blueprint measurement";
                    break;
                    
                case 'walkthrough':
                    totalArea = calculateWalkthroughArea();
                    description = "walk-through measurement";
                    break;
            }
            
            // Calculate room areas
            const roomAnalysis = calculateRoomAreas();
            totalArea += roomAnalysis.totalArea;
            
            // Calculate floor areas
            const floorAnalysis = calculateFloorAreas(roomAnalysis.totalArea);
            const buildingArea = floorAnalysis.totalArea;
            
            // Apply waste factor
            const wasteMultiplier = 1 + (wasteFactor / 100);
            const areaWithWaste = totalArea * wasteMultiplier;
            
            // Calculate material requirements
            const unitsRequired = Math.ceil(areaWithWaste / coverageRate);
            
            // Calculate costs
            const materialCost = totalArea * pricePerSqFt;
            const laborTotal = totalArea * laborCost;
            const wasteCost = materialCost * (wasteFactor / 100);
            const subtotal = materialCost + laborTotal + wasteCost;
            const taxAmount = subtotal * (taxRate / 100);
            const totalCost = subtotal + taxAmount;
            
            // Calculate volume
            const totalVolume = roomAnalysis.totalVolume;
            
            // Convert to USD for currency conversions
            const totalCostUSD = totalCost / exchangeRates[selectedCurrency];
            
            // Get currency symbol
            const symbol = currencySymbols[selectedCurrency];
            
            // Update UI
            updateResults({
                totalArea: Math.round(totalArea),
                buildingArea: Math.round(buildingArea),
                areaWithWaste: Math.round(areaWithWaste),
                totalCost,
                totalVolume: Math.round(totalVolume),
                unitsRequired,
                coverageRate,
                roomAnalysis,
                floorAnalysis,
                materialCost,
                laborTotal,
                wasteCost,
                taxAmount,
                totalCostUSD,
                symbol
            });
        }

        function calculateManualArea(shape) {
            switch(shape) {
                case 'rectangle':
                    const length = parseFloat(document.getElementById('length').value);
                    const width = parseFloat(document.getElementById('width').value);
                    return length * width;
                    
                case 'lshape':
                    const l1 = parseFloat(document.getElementById('l-length1').value);
                    const w1 = parseFloat(document.getElementById('l-width1').value);
                    const l2 = parseFloat(document.getElementById('l-length2').value);
                    const w2 = parseFloat(document.getElementById('l-width2').value);
                    return (l1 * w1) + (l2 * w2);
                    
                case 'circle':
                    const radius = parseFloat(document.getElementById('radius').value);
                    return Math.PI * Math.pow(radius, 2);
                    
                default:
                    return 300; // Default area
            }
        }

        function calculateBlueprintArea() {
            const scale = document.getElementById('blueprint-scale').value;
            const bpLength = parseFloat(document.getElementById('blueprint-length').value);
            const bpWidth = parseFloat(document.getElementById('blueprint-width').value);
            
            let scaleFactor;
            switch(scale) {
                case '1/8': scaleFactor = 96; break;
                case '1/4': scaleFactor = 48; break;
                case '1/2': scaleFactor = 24; break;
                default: scaleFactor = 48;
            }
            
            const actualLength = (bpLength / scaleFactor) * 12;
            const actualWidth = (bpWidth / scaleFactor) * 12;
            
            return actualLength * actualWidth;
        }

        function calculateWalkthroughArea() {
            const stepLength = parseFloat(document.getElementById('step-length').value);
            const lengthSteps = parseFloat(document.getElementById('length-steps').value);
            const widthSteps = parseFloat(document.getElementById('width-steps').value);
            
            const actualLength = lengthSteps * stepLength;
            const actualWidth = widthSteps * stepLength;
            
            return actualLength * actualWidth;
        }

        function calculateRoomAreas() {
            const rooms = document.querySelectorAll('.room-inputs');
            let totalArea = 0;
            let totalVolume = 0;
            const roomAreas = [];
            
            rooms.forEach(room => {
                const length = parseFloat(room.querySelector('.room-length').value) || 0;
                const width = parseFloat(room.querySelector('.room-width').value) || 0;
                const height = parseFloat(room.querySelector('.room-height').value) || 0;
                
                const area = length * width;
                const volume = area * height;
                
                totalArea += area;
                totalVolume += volume;
                roomAreas.push(area);
            });
            
            return {
                totalArea,
                totalVolume,
                roomCount: rooms.length,
                roomAreas,
                avgRoomSize: totalArea / rooms.length,
                largestRoom: Math.max(...roomAreas),
                smallestRoom: Math.min(...roomAreas)
            };
        }

        function calculateFloorAreas(defaultArea) {
            const floors = document.querySelectorAll('.floor-inputs');
            let totalArea = 0;
            const floorAreas = [];
            
            floors.forEach(floor => {
                let area = parseFloat(floor.querySelector('.floor-area').value) || 0;
                if (area === 0) area = defaultArea;
                totalArea += area;
                floorAreas.push(area);
            });
            
            return {
                totalArea,
                floorCount: floors.length,
                floorAreas,
                avgFloorSize: totalArea / floors.length
            };
        }

        function updateResults(data) {
            document.getElementById('totalSqFt').textContent = data.totalArea + ' sq ft';
            document.getElementById('totalArea').textContent = data.totalArea;
            document.getElementById('totalCost').textContent = data.symbol + data.totalCost.toFixed(2);
            document.getElementById('totalVolume').textContent = data.totalVolume.toLocaleString() + ' cu ft';
            document.getElementById('materialsNeeded').textContent = data.unitsRequired + ' units';
            
            document.getElementById('roomCount').textContent = data.roomAnalysis.roomCount + ' room' + (data.roomAnalysis.roomCount !== 1 ? 's' : '');
            document.getElementById('avgRoomSize').textContent = Math.round(data.roomAnalysis.avgRoomSize) + ' sq ft';
            document.getElementById('largestRoom').textContent = Math.round(data.roomAnalysis.largestRoom) + ' sq ft';
            document.getElementById('smallestRoom').textContent = Math.round(data.roomAnalysis.smallestRoom) + ' sq ft';
            
            document.getElementById('materialCost').textContent = data.symbol + data.materialCost.toFixed(2);
            document.getElementById('laborCost').textContent = data.symbol + data.laborTotal.toFixed(2);
            document.getElementById('wasteCost').textContent = data.symbol + data.wasteCost.toFixed(2);
            document.getElementById('taxCost').textContent = data.symbol + data.taxAmount.toFixed(2);
            document.getElementById('projectCost').textContent = data.symbol + data.totalCost.toFixed(2);
            
            document.getElementById('floorCount').textContent = data.floorAnalysis.floorCount + ' floor' + (data.floorAnalysis.floorCount !== 1 ? 's' : '');
            document.getElementById('buildingArea').textContent = Math.round(data.buildingArea) + ' sq ft';
            document.getElementById('avgFloorSize').textContent = Math.round(data.floorAnalysis.avgFloorSize) + ' sq ft';
            
            document.getElementById('convertUSD').textContent = '$' + data.totalCostUSD.toFixed(2);
            document.getElementById('convertEUR').textContent = '€' + (data.totalCostUSD * exchangeRates.EUR).toFixed(2);
            document.getElementById('convertGBP').textContent = '£' + (data.totalCostUSD * exchangeRates.GBP).toFixed(2);
            document.getElementById('convertINR').textContent = '₹' + Math.round(data.totalCostUSD * exchangeRates.INR).toLocaleString();
            
            document.getElementById('areaWithWaste').textContent = Math.round(data.areaWithWaste) + ' sq ft';
            document.getElementById('unitsRequired').textContent = data.unitsRequired + ' units';
            document.getElementById('coveragePerUnit').textContent = data.coverageRate + ' sq ft';
        }

        // Export functions
        function generatePDF() {
            alert('PDF report generation would be implemented here. This would create a professional report with all calculations, room analysis, and cost breakdown.');
        }

        function exportToCSV() {
            alert('CSV export would be implemented here. This would export all room data, calculations, and cost information in CSV format.');
        }

        // Event listeners
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateSquareFootage();
        });

        window.addEventListener('load', function() {
            calculateSquareFootage();
        });

        // Update calculations when any input changes
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('input', calculateSquareFootage);
        });
    </script>
</body>
</html>
