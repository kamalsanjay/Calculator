<?php
/**
 * Mulch Calculator
 * File: construction/mulch-calculator.php
 * Description: Calculate mulch volume, bags needed, and costs with multi-currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mulch Calculator - Volume & Cost Estimation</title>
    <meta name="description" content="Free mulch calculator with multi-currency support. Calculate mulch volume, bags needed, costs for bark, wood chips, rubber, and more.">
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
            <h1>🌿 Mulch Calculator</h1>
            <p>Calculate mulch volume, bags needed, and costs with multi-currency pricing</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Area Dimensions</h2>
                <form id="mulchCalculatorForm">
                    <div class="form-group">
                        <label for="areaType">Area Shape</label>
                        <select id="areaType" required>
                            <option value="rectangular">Rectangular Area</option>
                            <option value="circular">Circular Area</option>
                            <option value="triangular">Triangular Area</option>
                            <option value="custom">Custom Area (sq ft)</option>
                        </select>
                        <small>Select the shape of the area to mulch</small>
                    </div>

                    <div id="rectangularInputs">
                        <div class="dimension-inputs">
                            <div class="form-group">
                                <label for="length">Length (feet)</label>
                                <input type="number" id="length" value="20" min="1" step="0.5" required>
                            </div>
                            <div class="form-group">
                                <label for="width">Width (feet)</label>
                                <input type="number" id="width" value="10" min="1" step="0.5" required>
                            </div>
                        </div>
                    </div>

                    <div id="circularInputs" style="display: none;">
                        <div class="form-group">
                            <label for="radius">Radius (feet)</label>
                            <input type="number" id="radius" value="8" min="1" step="0.5">
                        </div>
                    </div>

                    <div id="triangularInputs" style="display: none;">
                        <div class="dimension-inputs">
                            <div class="form-group">
                                <label for="base">Base (feet)</label>
                                <input type="number" id="base" value="15" min="1" step="0.5">
                            </div>
                            <div class="form-group">
                                <label for="height">Height (feet)</label>
                                <input type="number" id="height" value="12" min="1" step="0.5">
                            </div>
                        </div>
                    </div>

                    <div id="customInputs" style="display: none;">
                        <div class="form-group">
                            <label for="area">Area (square feet)</label>
                            <input type="number" id="area" value="200" min="1" step="1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="depth">Mulch Depth (inches)</label>
                        <input type="number" id="depth" value="3" min="1" max="12" step="0.5" required>
                        <small>Recommended depth: 2-4 inches for most applications</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="mulchType">Mulch Type</label>
                        <select id="mulchType" required>
                            <option value="bark">Bark Mulch</option>
                            <option value="woodchips">Wood Chips</option>
                            <option value="rubber">Rubber Mulch</option>
                            <option value="straw">Straw Mulch</option>
                            <option value="pine">Pine Needles</option>
                            <option value="stone">Decorative Stone</option>
                            <option value="cocoa">Cocoa Bean Hulls</option>
                        </select>
                        <small>Select the type of mulch material</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="bagSize">Bag Size</label>
                        <select id="bagSize" required>
                            <option value="2">2 cubic feet</option>
                            <option value="3" selected>3 cubic feet</option>
                            <option value="1">1 cubic foot</option>
                            <option value="bulk">Bulk Delivery</option>
                        </select>
                        <small>Standard bag sizes or bulk delivery</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="pricePerBag">Price per Bag/Unit</label>
                        <div class="input-group">
                            <input type="number" id="pricePerBag" value="4.50" min="0" step="0.01">
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
                        <small>Cost per bag or per cubic yard for bulk</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Mulch Needs</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Total Mulch Needed</h3>
                    <div class="amount" id="totalMulch">16.67 cu ft</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Bags Required</h4>
                        <div class="value" id="bagsRequired">6 bags</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$27.00</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Area Details</h3>
                    <div class="breakdown-item">
                        <span>Area Shape</span>
                        <strong id="areaShape">Rectangular</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Area</span>
                        <strong id="totalArea">200 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mulch Depth</span>
                        <strong id="mulchDepth">3 inches</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mulch Type</span>
                        <strong id="mulchTypeResult">Bark Mulch</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Volume Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Cubic Feet</span>
                        <strong id="cubicFeet">16.67 cu ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cubic Yards</span>
                        <strong id="cubicYards">0.62 cu yd</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Bags Required</span>
                        <strong id="bagsNeeded">6 bags</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Bag Size</span>
                        <strong id="bagSizeResult">3 cu ft</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Price per Bag</span>
                        <strong id="pricePerBagResult">$4.50</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Bag Cost</span>
                        <strong id="bagCost">$27.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Bulk Cost (per yard)</span>
                        <strong id="bulkCost">$40.50</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Delivery Estimate</span>
                        <strong id="deliveryCost">$75.00</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$27.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€24.75</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£21.33</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹2,255</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAD (Canadian Dollar)</span>
                        <strong id="convertCAD">C$37.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>AUD (Australian Dollar)</span>
                        <strong id="convertAUD">A$40.50</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Mulch Type Comparison</h3>
                    <div class="breakdown-item">
                        <span>Bark Mulch</span>
                        <strong>$4.50/bag</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Wood Chips</span>
                        <strong>$2.50/bag</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Rubber Mulch</span>
                        <strong>$8.00/bag</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Straw Mulch</span>
                        <strong>$3.50/bag</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Decorative Stone</span>
                        <strong>$6.00/bag</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Coverage Reference</h3>
                    <div class="breakdown-item">
                        <span>1 cu yd at 3" depth</span>
                        <strong>108 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>1 cu yd at 2" depth</span>
                        <strong>162 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>1 cu yd at 4" depth</span>
                        <strong>81 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>3 cu ft bag at 3"</span>
                        <strong>12 sq ft</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Mulching Tips:</strong> For best results, apply 2-4 inches of mulch. Remove old mulch before applying new. Keep mulch 2-3 inches away from plant stems and tree trunks. Water thoroughly after application. Consider using landscape fabric underneath to suppress weeds.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🌿 Mulch Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional mulch volume and cost calculations with multi-currency support</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('mulchCalculatorForm');
        const areaTypeSelect = document.getElementById('areaType');

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

        // Mulch type prices per bag (USD)
        const mulchPrices = {
            bark: 4.50,
            woodchips: 2.50,
            rubber: 8.00,
            straw: 3.50,
            pine: 5.00,
            stone: 6.00,
            cocoa: 7.50
        };

        // Bulk prices per cubic yard (USD)
        const bulkPrices = {
            bark: 35.00,
            woodchips: 20.00,
            rubber: 65.00,
            straw: 25.00,
            pine: 40.00,
            stone: 50.00,
            cocoa: 60.00
        };

        // Show/hide input fields based on area type
        areaTypeSelect.addEventListener('change', function() {
            const areaType = this.value;
            
            // Hide all input sections
            document.getElementById('rectangularInputs').style.display = 'none';
            document.getElementById('circularInputs').style.display = 'none';
            document.getElementById('triangularInputs').style.display = 'none';
            document.getElementById('customInputs').style.display = 'none';
            
            // Show the selected input section
            document.getElementById(areaType + 'Inputs').style.display = 'block';
            
            // Recalculate
            calculateMulch();
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateMulch();
        });

        function calculateMulch() {
            const areaType = document.getElementById('areaType').value;
            const depth = parseFloat(document.getElementById('depth').value);
            const mulchType = document.getElementById('mulchType').value;
            const bagSize = document.getElementById('bagSize').value;
            const pricePerBag = parseFloat(document.getElementById('pricePerBag').value) || 0;
            const selectedCurrency = document.getElementById('currency').value;

            let area = 0;

            // Calculate area based on shape
            switch(areaType) {
                case 'rectangular':
                    const length = parseFloat(document.getElementById('length').value);
                    const width = parseFloat(document.getElementById('width').value);
                    area = length * width;
                    break;
                case 'circular':
                    const radius = parseFloat(document.getElementById('radius').value);
                    area = Math.PI * radius * radius;
                    break;
                case 'triangular':
                    const base = parseFloat(document.getElementById('base').value);
                    const height = parseFloat(document.getElementById('height').value);
                    area = 0.5 * base * height;
                    break;
                case 'custom':
                    area = parseFloat(document.getElementById('area').value);
                    break;
            }

            // Calculate volume in cubic feet
            const cubicFeet = area * (depth / 12);
            
            // Calculate cubic yards
            const cubicYards = cubicFeet / 27;

            // Calculate number of bags
            let bagsRequired = 0;
            let bagSizeText = '';
            
            if (bagSize === 'bulk') {
                bagsRequired = cubicYards;
                bagSizeText = 'cubic yards';
            } else {
                const bagSizeNum = parseFloat(bagSize);
                bagsRequired = Math.ceil(cubicFeet / bagSizeNum);
                bagSizeText = bagSize + ' cu ft';
            }

            // Calculate costs
            const materialPrice = mulchPrices[mulchType] || 4.50;
            const bulkPrice = bulkPrices[mulchType] || 35.00;
            
            let totalCost = 0;
            if (bagSize === 'bulk') {
                totalCost = cubicYards * (pricePerBag || bulkPrice);
            } else {
                totalCost = bagsRequired * (pricePerBag || materialPrice);
            }

            // Delivery cost estimate
            const deliveryCost = bagSize === 'bulk' ? 75 : 0;

            // Convert to USD first if not already USD
            const totalCostUSD = totalCost / exchangeRates[selectedCurrency];
            const deliveryCostUSD = deliveryCost / exchangeRates[selectedCurrency];

            // Get currency symbol
            const symbol = currencySymbols[selectedCurrency];

            // Format numbers
            function formatNumber(num, decimals = 2) {
                return num.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
            }

            function formatWhole(num) {
                return num.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
            }

            // Update UI
            document.getElementById('totalMulch').textContent = formatNumber(cubicFeet) + ' cu ft';
            document.getElementById('bagsRequired').textContent = formatWhole(bagsRequired) + (bagSize === 'bulk' ? ' cu yd' : ' bags');
            document.getElementById('totalCost').textContent = symbol + formatNumber(totalCost);

            document.getElementById('areaShape').textContent = document.getElementById('areaType').options[document.getElementById('areaType').selectedIndex].text;
            document.getElementById('totalArea').textContent = formatNumber(area) + ' sq ft';
            document.getElementById('mulchDepth').textContent = depth + ' inches';
            document.getElementById('mulchTypeResult').textContent = document.getElementById('mulchType').options[document.getElementById('mulchType').selectedIndex].text;

            document.getElementById('cubicFeet').textContent = formatNumber(cubicFeet) + ' cu ft';
            document.getElementById('cubicYards').textContent = formatNumber(cubicYards) + ' cu yd';
            document.getElementById('bagsNeeded').textContent = formatWhole(bagsRequired) + (bagSize === 'bulk' ? ' cu yd' : ' bags');
            document.getElementById('bagSizeResult').textContent = bagSizeText;

            document.getElementById('pricePerBagResult').textContent = symbol + formatNumber(pricePerBag || materialPrice);
            document.getElementById('bagCost').textContent = symbol + formatNumber(totalCost);
            document.getElementById('bulkCost').textContent = symbol + formatNumber(bulkPrice) + '/yd';
            document.getElementById('deliveryCost').textContent = symbol + formatNumber(deliveryCost);

            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + formatNumber(totalCostUSD);
            document.getElementById('convertEUR').textContent = '€' + formatNumber(totalCostUSD * exchangeRates.EUR);
            document.getElementById('convertGBP').textContent = '£' + formatNumber(totalCostUSD * exchangeRates.GBP);
            document.getElementById('convertINR').textContent = '₹' + formatWhole(totalCostUSD * exchangeRates.INR);
            document.getElementById('convertCAD').textContent = 'C$' + formatNumber(totalCostUSD * exchangeRates.CAD);
            document.getElementById('convertAUD').textContent = 'A$' + formatNumber(totalCostUSD * exchangeRates.AUD);
        }

        window.addEventListener('load', function() {
            calculateMulch();
        });

        // Update calculations when currency changes
        document.getElementById('currency').addEventListener('change', calculateMulch);
        
        // Update calculations when any input changes
        const inputs = ['areaType', 'length', 'width', 'radius', 'base', 'height', 'area', 'depth', 'mulchType', 'bagSize', 'pricePerBag'];
        inputs.forEach(id => {
            document.getElementById(id).addEventListener('input', calculateMulch);
        });
    </script>
</body>
</html>