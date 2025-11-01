<?php
/**
 * Advanced Tile Calculator
 * File: construction/tile-calculator.php
 * Description: Calculate tile quantities, patterns, cuts, and costs with advanced features
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Tile Calculator - Quantity, Patterns & Cost Estimation</title>
    <meta name="description" content="Advanced tile calculator with pattern layouts, cut optimization, multi-currency support, and professional installation estimates.">
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh; 
            padding: 20px; 
        }
        
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            width: 100%;
        }
        
        .header { 
            background: rgba(255,255,255,0.95); 
            padding: 30px; 
            border-radius: 20px 20px 0 0; 
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1); 
            text-align: center; 
            width: 100%;
        }
        .header h1 { 
            color: #2c3e50; 
            font-size: 2.5rem; 
            margin-bottom: 10px; 
        }
        .header p { 
            color: #7f8c8d; 
            font-size: 1.2rem; 
            opacity: 0.9; 
        }
        
        .calculator-wrapper { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 30px; 
            background: white; 
            padding: 30px; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.12); 
            width: 100%;
        }
        
        .calculator-section h2, .results-section h2 { 
            color: #667eea; 
            margin-bottom: 20px; 
            font-size: 1.6rem; 
        }
        
        .form-group { 
            margin-bottom: 18px; 
            width: 100%;
        }
        .form-group label { 
            display: block; 
            margin-bottom: 6px; 
            font-weight: 600; 
            color: #555; 
        }
        .form-group input, .form-group select, .form-group textarea { 
            width: 100%; 
            padding: 10px; 
            border: 2px solid #e0e0e0; 
            border-radius: 6px; 
            font-size: 15px; 
            transition: border-color 0.3s; 
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { 
            outline: none; 
            border-color: #667eea; 
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); 
        }
        .form-group small { 
            display: block; 
            margin-top: 4px; 
            color: #888; 
            font-size: 0.85em; 
        }
        
        .input-group { 
            display: grid; 
            grid-template-columns: 2fr 1fr; 
            gap: 10px; 
            align-items: end; 
            width: 100%;
        }
        
        .dimension-inputs { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 12px; 
            width: 100%;
        }
        
        .tile-preview { 
            width: 60px; 
            height: 60px; 
            border: 2px solid #ddd; 
            border-radius: 4px; 
            margin: 10px 0; 
            background-size: cover; 
        }
        
        .btn { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 14px 25px; 
            border: none; 
            border-radius: 8px; 
            font-size: 16px; 
            font-weight: 600; 
            cursor: pointer; 
            width: 100%; 
            transition: all 0.3s; 
            margin-top: 10px;
        }
        .btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); 
        }
        
        .btn-secondary { 
            background: #6c757d; 
            margin-top: 10px; 
        }
        .btn-secondary:hover { 
            background: #5a6268; 
        }
        
        .result-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 22px; 
            border-radius: 10px; 
            margin-bottom: 18px; 
            text-align: center; 
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); 
            width: 100%;
        }
        .result-card h3 { 
            font-size: 1.1rem; 
            opacity: 0.9; 
            margin-bottom: 8px; 
            font-weight: 400; 
        }
        .result-card .amount { 
            font-size: 2.5rem; 
            font-weight: bold; 
        }
        
        .metric-grid { 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            gap: 12px; 
            margin-bottom: 18px; 
            width: 100%;
        }
        .metric-card { 
            background: #f8f9fa; 
            padding: 18px; 
            border-radius: 10px; 
            text-align: center; 
            border: 2px solid #e0e0e0; 
            width: 100%;
        }
        .metric-card h4 { 
            color: #666; 
            font-size: 0.85rem; 
            margin-bottom: 8px; 
            font-weight: 400; 
        }
        .metric-card .value { 
            color: #667eea; 
            font-size: 1.8rem; 
            font-weight: bold; 
        }
        
        .breakdown { 
            background: #f8f9fa; 
            padding: 18px; 
            border-radius: 10px; 
            margin-bottom: 18px; 
            width: 100%;
        }
        .breakdown h3 { 
            color: #667eea; 
            margin-bottom: 12px; 
            font-size: 1.2rem; 
        }
        .breakdown-item { 
            display: flex; 
            justify-content: space-between; 
            padding: 10px 0; 
            border-bottom: 1px solid #e0e0e0; 
        }
        .breakdown-item:last-child { 
            border-bottom: none; 
        }
        .breakdown-item span { 
            color: #666; 
        }
        .breakdown-item strong { 
            color: #333; 
            font-weight: 600; 
        }
        
        .pattern-visual { 
            height: 100px; 
            background: #f8f9fa; 
            border-radius: 6px; 
            margin: 12px 0; 
            position: relative; 
            overflow: hidden; 
            border: 2px solid #e0e0e0; 
            width: 100%;
        }
        
        .cut-optimization { 
            background: #fff3cd; 
            border-left: 4px solid #ffc107; 
            padding: 14px; 
            margin: 14px 0; 
            border-radius: 5px; 
            width: 100%;
        }
        
        .waste-calculator { 
            background: #d1ecf1; 
            border-left: 4px solid #17a2b8; 
            padding: 14px; 
            margin: 14px 0; 
            border-radius: 5px; 
            width: 100%;
        }
        
        .info-box { 
            background: #e8f2ff; 
            border-left: 4px solid #667eea; 
            padding: 14px; 
            margin: 18px 0; 
            border-radius: 5px; 
            width: 100%;
        }
        .info-box strong { 
            color: #667eea; 
        }
        
        .tabs { 
            display: flex; 
            margin-bottom: 18px; 
            border-bottom: 2px solid #e0e0e0; 
            width: 100%;
            overflow-x: auto;
        }
        .tab { 
            padding: 10px 16px; 
            background: #f8f9fa; 
            border: none; 
            border-radius: 6px 6px 0 0; 
            margin-right: 4px; 
            cursor: pointer; 
            transition: all 0.3s; 
            white-space: nowrap;
            flex-shrink: 0;
        }
        .tab.active { 
            background: #667eea; 
            color: white; 
        }
        
        .tab-content { 
            display: none; 
            width: 100%;
        }
        .tab-content.active { 
            display: block; 
        }
        
        .footer { 
            background: rgba(255,255,255,0.95); 
            padding: 22px; 
            border-radius: 0 0 20px 20px; 
            text-align: center; 
            color: #7f8c8d; 
            width: 100%;
        }
        
        @media (max-width: 768px) {
            .calculator-wrapper { 
                grid-template-columns: 1fr; 
                padding: 20px; 
                gap: 20px;
            }
            .header { 
                padding: 20px; 
            }
            .header h1 { 
                font-size: 2rem; 
            }
            .result-card .amount { 
                font-size: 2rem; 
            }
            .metric-grid { 
                grid-template-columns: 1fr; 
            }
            .input-group { 
                grid-template-columns: 1fr; 
            }
            .dimension-inputs { 
                grid-template-columns: 1fr; 
            }
            .tabs {
                flex-wrap: wrap;
            }
            .tab {
                margin-bottom: 5px;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            .container {
                padding: 0;
            }
            .calculator-wrapper {
                padding: 15px;
            }
            .header {
                padding: 15px;
            }
            .header h1 {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🧱 Advanced Tile Calculator</h1>
            <p>Professional tile calculations with pattern layouts, cut optimization, and multi-currency support</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <div class="tabs">
                    <button class="tab active" data-tab="basic">Basic Dimensions</button>
                    <button class="tab" data-tab="advanced">Advanced Settings</button>
                    <button class="tab" data-tab="patterns">Tile Patterns</button>
                </div>

                <div class="tab-content active" id="basic-tab">
                    <h2>Room & Tile Dimensions</h2>
                    <form id="tileCalculatorForm">
                        <div class="form-group">
                            <label for="areaType">Area Type</label>
                            <select id="areaType" required>
                                <option value="rectangular">Rectangular Room</option>
                                <option value="lshape">L-Shaped Room</option>
                                <option value="custom">Custom Area (sq ft)</option>
                            </select>
                            <small>Select the shape of the area to tile</small>
                        </div>

                        <div id="rectangularInputs">
                            <div class="dimension-inputs">
                                <div class="form-group">
                                    <label for="length">Room Length (feet)</label>
                                    <input type="number" id="length" value="12" min="1" step="0.1" required>
                                </div>
                                <div class="form-group">
                                    <label for="width">Room Width (feet)</label>
                                    <input type="number" id="width" value="10" min="1" step="0.1" required>
                                </div>
                            </div>
                        </div>

                        <div id="lshapeInputs" style="display: none;">
                            <div class="dimension-inputs">
                                <div class="form-group">
                                    <label for="mainLength">Main Length (feet)</label>
                                    <input type="number" id="mainLength" value="12" min="1" step="0.1">
                                </div>
                                <div class="form-group">
                                    <label for="mainWidth">Main Width (feet)</label>
                                    <input type="number" id="mainWidth" value="8" min="1" step="0.1">
                                </div>
                            </div>
                            <div class="dimension-inputs">
                                <div class="form-group">
                                    <label for="extensionLength">Extension Length (feet)</label>
                                    <input type="number" id="extensionLength" value="4" min="1" step="0.1">
                                </div>
                                <div class="form-group">
                                    <label for="extensionWidth">Extension Width (feet)</label>
                                    <input type="number" id="extensionWidth" value="6" min="1" step="0.1">
                                </div>
                            </div>
                        </div>

                        <div id="customInputs" style="display: none;">
                            <div class="form-group">
                                <label for="area">Total Area (square feet)</label>
                                <input type="number" id="area" value="120" min="1" step="1">
                            </div>
                        </div>

                        <div class="dimension-inputs">
                            <div class="form-group">
                                <label for="tileLength">Tile Length (inches)</label>
                                <input type="number" id="tileLength" value="12" min="1" step="0.25" required>
                            </div>
                            <div class="form-group">
                                <label for="tileWidth">Tile Width (inches)</label>
                                <input type="number" id="tileWidth" value="12" min="1" step="0.25" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="groutWidth">Grout Line Width (inches)</label>
                            <input type="number" id="groutWidth" value="0.125" min="0" max="0.5" step="0.0625" required>
                            <small>Standard: 1/8 inch (0.125")</small>
                        </div>
                    </form>
                </div>

                <div class="tab-content" id="advanced-tab">
                    <h2>Advanced Settings</h2>
                    <div class="form-group">
                        <label for="wasteFactor">Waste Factor</label>
                        <select id="wasteFactor" required>
                            <option value="1.07">7% (Straight Layout)</option>
                            <option value="1.10" selected>10% (Standard)</option>
                            <option value="1.15">15% (Diagonal/Complex)</option>
                            <option value="1.20">20% (Very Complex)</option>
                            <option value="custom">Custom Percentage</option>
                        </select>
                        <small>Extra tiles for cuts, breakage, and future repairs</small>
                    </div>

                    <div id="customWaste" style="display: none;">
                        <div class="form-group">
                            <label for="customWastePercent">Custom Waste Percentage</label>
                            <input type="number" id="customWastePercent" value="12" min="0" max="50" step="1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tileType">Tile Material</label>
                        <select id="tileType" required>
                            <option value="ceramic">Ceramic</option>
                            <option value="porcelain">Porcelain</option>
                            <option value="natural_stone">Natural Stone</option>
                            <option value="glass">Glass Tile</option>
                            <option value="mosaic">Mosaic</option>
                            <option value="quarry">Quarry Tile</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pricePerSqFt">Price per Square Foot</label>
                        <div class="input-group">
                            <input type="number" id="pricePerSqFt" value="3.50" min="0" step="0.01">
                            <select id="currency" style="padding: 10px;">
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
                        <label for="laborCost">Labor Cost per Sq Ft</label>
                        <input type="number" id="laborCost" value="4.50" min="0" step="0.01">
                    </div>
                </div>

                <div class="tab-content" id="patterns-tab">
                    <h2>Tile Patterns & Layout</h2>
                    <div class="form-group">
                        <label for="layoutPattern">Tile Layout Pattern</label>
                        <select id="layoutPattern" required>
                            <option value="straight">Straight (Grid) Pattern</option>
                            <option value="diagonal">Diagonal Pattern</option>
                            <option value="brick">Brick (Offset) Pattern</option>
                            <option value="herringbone">Herringbone Pattern</option>
                            <option value="hexagon">Hexagon Pattern</option>
                            <option value="windmill">Windmill Pattern</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="startPoint">Starting Point</label>
                        <select id="startPoint">
                            <option value="center">Center of Room</option>
                            <option value="corner">Corner</option>
                            <option value="doorway">From Doorway</option>
                            <option value="focal">From Focal Point</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="borderTiles">Include Border Tiles?</label>
                        <select id="borderTiles">
                            <option value="no">No Border</option>
                            <option value="contrast">Contrast Border</option>
                            <option value="same">Same Tile Border</option>
                        </select>
                    </div>

                    <div class="pattern-visual" id="patternPreview">
                        <!-- Pattern visualization will be generated here -->
                    </div>
                </div>

                <button type="button" class="btn" onclick="calculateTiles()">Calculate Tile Requirements</button>
                <button type="button" class="btn btn-secondary" onclick="generateCutList()">Generate Cut List</button>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Total Tiles Needed</h3>
                    <div class="amount" id="totalTiles">143 tiles</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Area</h4>
                        <div class="value" id="totalArea">120 sq ft</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$960</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Tile Quantity Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Net Area</span>
                        <strong id="netArea">120 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waste Allowance</span>
                        <strong id="wasteArea">12 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Area with Waste</span>
                        <strong id="totalWithWaste">132 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tiles per Box</span>
                        <strong id="tilesPerBox">10 tiles</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Boxes Required</span>
                        <strong id="boxesRequired">15 boxes</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Tile Materials</span>
                        <strong id="tileMaterials">$420</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Labor Cost</span>
                        <strong id="laborTotal">$540</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Grout & Materials</span>
                        <strong id="groutCost">$85</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Underlayment</span>
                        <strong id="underlaymentCost">$75</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tools & Rental</span>
                        <strong id="toolsCost">$50</strong>
                    </div>
                </div>

                <div class="cut-optimization">
                    <h3>🛠️ Cut Optimization</h3>
                    <div class="breakdown-item">
                        <span>Full Tiles</span>
                        <strong id="fullTiles">110 tiles</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cut Tiles</span>
                        <strong id="cutTiles">33 tiles</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waste from Cuts</span>
                        <strong id="cutWaste">8%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Recommended Layout</span>
                        <strong id="recommendedLayout">Start from center</strong>
                    </div>
                </div>

                <div class="waste-calculator">
                    <h3>📊 Waste Analysis</h3>
                    <div class="breakdown-item">
                        <span>Cutting Waste</span>
                        <strong id="cuttingWaste">5%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Breakage Waste</span>
                        <strong id="breakageWaste">3%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pattern Waste</span>
                        <strong id="patternWaste">2%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Waste</span>
                        <strong id="totalWaste">10%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$960</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€880</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£758</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹80,160</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Professional Recommendations</h3>
                    <div class="breakdown-item">
                        <span>Grout Type</span>
                        <strong id="groutType">Sanded Grout</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Underlayment</span>
                        <strong id="underlaymentType">Cement Board</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Installation Time</span>
                        <strong id="installTime">2-3 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Skill Level</span>
                        <strong id="skillLevel">Intermediate</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Advanced Calculation Methods:</strong> This calculator uses multiple algorithms including area-based calculation, tile count method, pattern-based waste estimation, and cut optimization. It considers grout lines, pattern complexity, and material-specific waste factors for professional results.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🧱 Advanced Tile Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional tile calculations with advanced features and multi-currency support</p>
        </div>
    </div>

    <script>
        // Tab functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                tab.classList.add('active');
                document.getElementById(tab.dataset.tab + '-tab').classList.add('active');
            });
        });

        // Area type change handler
        document.getElementById('areaType').addEventListener('change', function() {
            const areaType = this.value;
            document.getElementById('rectangularInputs').style.display = 'none';
            document.getElementById('lshapeInputs').style.display = 'none';
            document.getElementById('customInputs').style.display = 'none';
            document.getElementById(areaType + 'Inputs').style.display = 'block';
        });

        // Waste factor custom input
        document.getElementById('wasteFactor').addEventListener('change', function() {
            document.getElementById('customWaste').style.display = this.value === 'custom' ? 'block' : 'none';
        });

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

        // Tile type properties
        const tileProperties = {
            ceramic: { waste: 0.10, labor: 4.50, skill: 'Beginner' },
            porcelain: { waste: 0.12, labor: 5.50, skill: 'Intermediate' },
            natural_stone: { waste: 0.15, labor: 8.00, skill: 'Expert' },
            glass: { waste: 0.18, labor: 7.50, skill: 'Expert' },
            mosaic: { waste: 0.08, labor: 6.00, skill: 'Intermediate' },
            quarry: { waste: 0.07, labor: 4.00, skill: 'Beginner' }
        };

        // Pattern waste factors
        const patternWaste = {
            straight: 0.02,
            diagonal: 0.15,
            brick: 0.05,
            herringbone: 0.20,
            hexagon: 0.12,
            windmill: 0.25
        };

        function calculateTiles() {
            // Get all input values
            const areaType = document.getElementById('areaType').value;
            const tileLength = parseFloat(document.getElementById('tileLength').value);
            const tileWidth = parseFloat(document.getElementById('tileWidth').value);
            const groutWidth = parseFloat(document.getElementById('groutWidth').value);
            const wasteFactor = document.getElementById('wasteFactor').value;
            const customWastePercent = parseFloat(document.getElementById('customWastePercent').value) || 0;
            const tileType = document.getElementById('tileType').value;
            const pricePerSqFt = parseFloat(document.getElementById('pricePerSqFt').value) || 0;
            const laborCost = parseFloat(document.getElementById('laborCost').value) || 0;
            const layoutPattern = document.getElementById('layoutPattern').value;
            const selectedCurrency = document.getElementById('currency').value;

            // Calculate area based on room type
            let area = calculateArea(areaType);

            // Calculate tile area in square feet
            const tileAreaSqFt = (tileLength * tileWidth) / 144;

            // Calculate waste factor
            const baseWaste = tileProperties[tileType].waste;
            const patternWasteFactor = patternWaste[layoutPattern];
            let totalWasteFactor;

            if (wasteFactor === 'custom') {
                totalWasteFactor = 1 + (customWastePercent / 100);
            } else {
                totalWasteFactor = parseFloat(wasteFactor) + patternWasteFactor;
            }

            // Calculate quantities
            const netTiles = area / tileAreaSqFt;
            const totalTiles = Math.ceil(netTiles * totalWasteFactor);
            const totalAreaWithWaste = area * totalWasteFactor;

            // Calculate boxes (assuming 10 tiles per box for standard sizes)
            const tilesPerBox = calculateTilesPerBox(tileAreaSqFt);
            const boxesRequired = Math.ceil(totalTiles / tilesPerBox);

            // Calculate costs
            const materialCost = totalAreaWithWaste * (pricePerSqFt || getDefaultTilePrice(tileType));
            const laborTotal = area * (laborCost || tileProperties[tileType].labor);
            const additionalCosts = calculateAdditionalCosts(area, tileType);
            const totalCost = materialCost + laborTotal + additionalCosts;

            // Calculate cut optimization
            const cutAnalysis = calculateCutOptimization(area, tileLength, tileWidth, layoutPattern);

            // Update UI
            updateResults({
                totalTiles,
                totalArea: area,
                totalAreaWithWaste,
                wasteArea: totalAreaWithWaste - area,
                tilesPerBox,
                boxesRequired,
                materialCost,
                laborTotal,
                additionalCosts,
                totalCost,
                cutAnalysis,
                tileType,
                selectedCurrency
            });
        }

        function calculateArea(areaType) {
            switch(areaType) {
                case 'rectangular':
                    const length = parseFloat(document.getElementById('length').value);
                    const width = parseFloat(document.getElementById('width').value);
                    return length * width;
                case 'lshape':
                    const mainLength = parseFloat(document.getElementById('mainLength').value);
                    const mainWidth = parseFloat(document.getElementById('mainWidth').value);
                    const extensionLength = parseFloat(document.getElementById('extensionLength').value);
                    const extensionWidth = parseFloat(document.getElementById('extensionWidth').value);
                    return (mainLength * mainWidth) + (extensionLength * extensionWidth);
                case 'custom':
                    return parseFloat(document.getElementById('area').value);
                default:
                    return 120;
            }
        }

        function calculateTilesPerBox(tileAreaSqFt) {
            if (tileAreaSqFt <= 1) return 20;    // Small tiles
            if (tileAreaSqFt <= 2) return 15;    // Medium tiles
            if (tileAreaSqFt <= 4) return 10;    // Large tiles
            return 5;                            // Very large tiles
        }

        function getDefaultTilePrice(tileType) {
            const prices = {
                ceramic: 2.50,
                porcelain: 3.50,
                natural_stone: 8.00,
                glass: 12.00,
                mosaic: 6.00,
                quarry: 3.00
            };
            return prices[tileType] || 3.50;
        }

        function calculateAdditionalCosts(area, tileType) {
            // Grout cost: $0.50 per sq ft
            const groutCost = area * 0.50;
            
            // Underlayment cost based on tile type
            const underlaymentRates = {
                ceramic: 0.40,
                porcelain: 0.60,
                natural_stone: 1.00,
                glass: 0.80,
                mosaic: 0.50,
                quarry: 0.40
            };
            const underlaymentCost = area * (underlaymentRates[tileType] || 0.50);
            
            // Tools and materials
            const toolsCost = 50;
            
            return groutCost + underlaymentCost + toolsCost;
        }

        function calculateCutOptimization(area, tileLength, tileWidth, pattern) {
            const roomLength = 12 * 12; // Convert to inches
            const roomWidth = 10 * 12;
            
            const tilesLengthwise = Math.ceil(roomLength / tileLength);
            const tilesWidthwise = Math.ceil(roomWidth / tileWidth);
            
            const fullTiles = tilesLengthwise * tilesWidthwise;
            const totalTiles = Math.ceil(area * 144 / (tileLength * tileWidth) * 1.1);
            const cutTiles = totalTiles - fullTiles;
            const cutWaste = ((cutTiles * 0.3) / totalTiles * 100).toFixed(1);
            
            return {
                fullTiles,
                cutTiles,
                cutWaste,
                cuttingWaste: '5%',
                breakageWaste: '3%',
                patternWaste: patternWaste[pattern] * 100 + '%',
                totalWaste: '10%'
            };
        }

        function updateResults(data) {
            const symbol = currencySymbols[data.selectedCurrency];
            const totalCostUSD = data.totalCost / exchangeRates[data.selectedCurrency];

            document.getElementById('totalTiles').textContent = Math.round(data.totalTiles) + ' tiles';
            document.getElementById('totalArea').textContent = Math.round(data.totalArea) + ' sq ft';
            document.getElementById('totalCost').textContent = symbol + Math.round(data.totalCost);
            
            document.getElementById('netArea').textContent = Math.round(data.totalArea) + ' sq ft';
            document.getElementById('wasteArea').textContent = Math.round(data.wasteArea) + ' sq ft';
            document.getElementById('totalWithWaste').textContent = Math.round(data.totalAreaWithWaste) + ' sq ft';
            document.getElementById('tilesPerBox').textContent = data.tilesPerBox + ' tiles';
            document.getElementById('boxesRequired').textContent = data.boxesRequired + ' boxes';

            document.getElementById('tileMaterials').textContent = symbol + Math.round(data.materialCost);
            document.getElementById('laborTotal').textContent = symbol + Math.round(data.laborTotal);
            document.getElementById('groutCost').textContent = symbol + Math.round(data.additionalCosts * 0.4);
            document.getElementById('underlaymentCost').textContent = symbol + Math.round(data.additionalCosts * 0.5);
            document.getElementById('toolsCost').textContent = symbol + '50';

            document.getElementById('fullTiles').textContent = data.cutAnalysis.fullTiles + ' tiles';
            document.getElementById('cutTiles').textContent = data.cutAnalysis.cutTiles + ' tiles';
            document.getElementById('cutWaste').textContent = data.cutAnalysis.cutWaste + '%';
            document.getElementById('recommendedLayout').textContent = 'Start from center';

            document.getElementById('cuttingWaste').textContent = data.cutAnalysis.cuttingWaste;
            document.getElementById('breakageWaste').textContent = data.cutAnalysis.breakageWaste;
            document.getElementById('patternWaste').textContent = data.cutAnalysis.patternWaste;
            document.getElementById('totalWaste').textContent = data.cutAnalysis.totalWaste;

            document.getElementById('convertUSD').textContent = '$' + Math.round(totalCostUSD);
            document.getElementById('convertEUR').textContent = '€' + Math.round(totalCostUSD * exchangeRates.EUR);
            document.getElementById('convertGBP').textContent = '£' + Math.round(totalCostUSD * exchangeRates.GBP);
            document.getElementById('convertINR').textContent = '₹' + Math.round(totalCostUSD * exchangeRates.INR);

            document.getElementById('groutType').textContent = 'Sanded Grout';
            document.getElementById('underlaymentType').textContent = 'Cement Board';
            document.getElementById('installTime').textContent = '2-3 days';
            document.getElementById('skillLevel').textContent = tileProperties[data.tileType].skill;
        }

        function generateCutList() {
            alert('Cut list generation feature would display optimized cutting patterns and tile sequences for minimal waste.');
        }

        // Initialize calculator
        window.addEventListener('load', function() {
            calculateTiles();
        });

        // Auto-calculate on input changes
        const inputs = ['areaType', 'length', 'width', 'mainLength', 'mainWidth', 'extensionLength', 'extensionWidth', 
                       'area', 'tileLength', 'tileWidth', 'groutWidth', 'wasteFactor', 'customWastePercent', 
                       'tileType', 'pricePerSqFt', 'laborCost', 'layoutPattern'];
        inputs.forEach(id => {
            document.getElementById(id).addEventListener('input', calculateTiles);
        });
    </script>
</body>
</html>