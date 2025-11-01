<?php
/**
 * Sod Calculator
 * File: construction/sod-calculator.php
 * Description: Calculate sod rolls, pallets needed, and costs with multi-currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sod Calculator - Lawn Installation & Cost Estimation</title>
    <meta name="description" content="Free sod calculator with multi-currency support. Calculate sod rolls, pallets, installation costs for Bermuda, Zoysia, St. Augustine, and more.">
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
        
        .grass-type { display: flex; align-items: center; margin-bottom: 10px; }
        .grass-color { width: 20px; height: 20px; border-radius: 50%; margin-right: 10px; border: 2px solid #e0e0e0; }
        
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
            <h1>🌱 Sod Calculator</h1>
            <p>Calculate sod rolls, pallets, and installation costs with multi-currency pricing</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Lawn Dimensions</h2>
                <form id="sodCalculatorForm">
                    <div class="form-group">
                        <label for="areaType">Area Shape</label>
                        <select id="areaType" required>
                            <option value="rectangular">Rectangular Lawn</option>
                            <option value="circular">Circular Lawn</option>
                            <option value="triangular">Triangular Area</option>
                            <option value="custom">Custom Area (sq ft)</option>
                        </select>
                        <small>Select the shape of the area to sod</small>
                    </div>

                    <div id="rectangularInputs">
                        <div class="dimension-inputs">
                            <div class="form-group">
                                <label for="length">Length (feet)</label>
                                <input type="number" id="length" value="50" min="1" step="0.5" required>
                            </div>
                            <div class="form-group">
                                <label for="width">Width (feet)</label>
                                <input type="number" id="width" value="30" min="1" step="0.5" required>
                            </div>
                        </div>
                    </div>

                    <div id="circularInputs" style="display: none;">
                        <div class="form-group">
                            <label for="radius">Radius (feet)</label>
                            <input type="number" id="radius" value="20" min="1" step="0.5">
                        </div>
                    </div>

                    <div id="triangularInputs" style="display: none;">
                        <div class="dimension-inputs">
                            <div class="form-group">
                                <label for="base">Base (feet)</label>
                                <input type="number" id="base" value="40" min="1" step="0.5">
                            </div>
                            <div class="form-group">
                                <label for="height">Height (feet)</label>
                                <input type="number" id="height" value="25" min="1" step="0.5">
                            </div>
                        </div>
                    </div>

                    <div id="customInputs" style="display: none;">
                        <div class="form-group">
                            <label for="area">Area (square feet)</label>
                            <input type="number" id="area" value="1500" min="1" step="1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="wasteFactor">Waste Factor</label>
                        <select id="wasteFactor" required>
                            <option value="1.05">5% (Simple Shape)</option>
                            <option value="1.10" selected>10% (Standard)</option>
                            <option value="1.15">15% (Complex Shape)</option>
                            <option value="1.20">20% (Very Complex)</option>
                        </select>
                        <small>Extra sod for cutting waste and irregular shapes</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="grassType">Grass Type</label>
                        <select id="grassType" required>
                            <option value="bermuda">Bermuda Grass</option>
                            <option value="zoysia">Zoysia Grass</option>
                            <option value="st_augustine">St. Augustine</option>
                            <option value="kentucky_bluegrass">Kentucky Bluegrass</option>
                            <option value="fescue">Fescue</option>
                            <option value="ryegrass">Ryegrass</option>
                            <option value="centipede">Centipede Grass</option>
                        </select>
                        <small>Select the type of grass sod</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="purchaseType">Purchase Method</label>
                        <select id="purchaseType" required>
                            <option value="rolls">Individual Rolls</option>
                            <option value="pallets" selected>Full Pallets</option>
                            <option value="bulk">Bulk by Square Foot</option>
                        </select>
                        <small>How you plan to purchase the sod</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="pricePerUnit">Price per Roll/Pallet</label>
                        <div class="input-group">
                            <input type="number" id="pricePerUnit" value="450" min="0" step="0.01">
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
                        <small>Cost per roll, pallet, or per square foot</small>
                    </div>

                    <div class="form-group">
                        <label for="laborCost">Labor Cost per Square Foot</label>
                        <input type="number" id="laborCost" value="1.50" min="0" step="0.01">
                        <small>Optional: installation cost per square foot</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Sod Needs</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Total Sod Needed</h3>
                    <div class="amount" id="totalSod">1,650 sq ft</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Pallets Required</h4>
                        <div class="value" id="palletsRequired">3 pallets</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$1,575</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Lawn Details</h3>
                    <div class="breakdown-item">
                        <span>Area Shape</span>
                        <strong id="areaShape">Rectangular</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Area</span>
                        <strong id="totalArea">1,500 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waste Factor</span>
                        <strong id="wasteFactorResult">10%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Grass Type</span>
                        <strong id="grassTypeResult">Bermuda Grass</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Sod Quantity Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Net Area</span>
                        <strong id="netArea">1,500 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waste Allowance</span>
                        <strong id="wasteArea">150 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Sod Needed</span>
                        <strong id="totalSodNeeded">1,650 sq ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Individual Rolls</span>
                        <strong id="individualRolls">165 rolls</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Full Pallets</span>
                        <strong id="fullPallets">3 pallets</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Sod Materials</span>
                        <strong id="sodMaterials">$1,350</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Labor Cost</span>
                        <strong id="laborTotal">$2,250</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Soil Preparation</span>
                        <strong id="soilPrep">$300</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fertilizer & Starter</span>
                        <strong id="fertilizerCost">$150</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Delivery Fee</span>
                        <strong id="deliveryCost">$75</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$1,575</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€1,444</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£1,244</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹131,513</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAD (Canadian Dollar)</span>
                        <strong id="convertCAD">C$2,158</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>AUD (Australian Dollar)</span>
                        <strong id="convertAUD">A$2,363</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Grass Type Comparison</h3>
                    <div class="breakdown-item grass-type">
                        <span><div class="grass-color" style="background: #2d5016;"></div>Bermuda Grass</span>
                        <strong>$0.30-0.45/sq ft</strong>
                    </div>
                    <div class="breakdown-item grass-type">
                        <span><div class="grass-color" style="background: #3a5c1e;"></div>Zoysia Grass</span>
                        <strong>$0.40-0.60/sq ft</strong>
                    </div>
                    <div class="breakdown-item grass-type">
                        <span><div class="grass-color" style="background: #456b22;"></div>St. Augustine</span>
                        <strong>$0.35-0.50/sq ft</strong>
                    </div>
                    <div class="breakdown-item grass-type">
                        <span><div class="grass-color" style="background: #4c7a29;"></div>Kentucky Bluegrass</span>
                        <strong>$0.35-0.55/sq ft</strong>
                    </div>
                    <div class="breakdown-item grass-type">
                        <span><div class="grass-color" style="background: #558b2f;"></div>Fescue</span>
                        <strong>$0.30-0.45/sq ft</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Sod Coverage Reference</h3>
                    <div class="breakdown-item">
                        <span>Standard Roll Size</span>
                        <strong>10 sq ft (2'×5')</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Rolls per Pallet</span>
                        <strong>50-60 rolls (500-600 sq ft)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pallet Weight</span>
                        <strong>2,000-3,000 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Installation Rate</span>
                        <strong>500-1,000 sq ft/hour</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Sod Installation Tips:</strong> Prepare soil by removing old grass and weeds. Grade area with 1-2% slope away from buildings. Install sod within 24 hours of delivery. Water immediately after installation (1 inch deep). Keep soil moist for 2 weeks. Avoid foot traffic for 2-3 weeks. Mow when grass reaches 3-4 inches height.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🌱 Sod Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional sod quantity and cost calculations with multi-currency support</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('sodCalculatorForm');
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

        // Grass type prices per square foot (USD)
        const grassPrices = {
            bermuda: 0.35,
            zoysia: 0.50,
            st_augustine: 0.40,
            kentucky_bluegrass: 0.45,
            fescue: 0.35,
            ryegrass: 0.30,
            centipede: 0.38
        };

        // Pallet prices (USD) - approximately 500 sq ft per pallet
        const palletPrices = {
            bermuda: 175,
            zoysia: 250,
            st_augustine: 200,
            kentucky_bluegrass: 225,
            fescue: 175,
            ryegrass: 150,
            centipede: 190
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
            calculateSod();
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateSod();
        });

        function calculateSod() {
            const areaType = document.getElementById('areaType').value;
            const wasteFactor = parseFloat(document.getElementById('wasteFactor').value);
            const grassType = document.getElementById('grassType').value;
            const purchaseType = document.getElementById('purchaseType').value;
            const pricePerUnit = parseFloat(document.getElementById('pricePerUnit').value) || 0;
            const laborCostPerSqFt = parseFloat(document.getElementById('laborCost').value) || 0;
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

            // Calculate total sod needed with waste factor
            const netArea = area;
            const totalSqFt = area * wasteFactor;
            const wasteArea = totalSqFt - netArea;

            // Calculate quantities
            const rollsPerSqFt = 0.1; // 10 sq ft per roll
            const sqFtPerPallet = 500; // Standard pallet size
            
            const individualRolls = Math.ceil(totalSqFt * rollsPerSqFt);
            const fullPallets = Math.ceil(totalSqFt / sqFtPerPallet);

            // Calculate costs
            const grassPrice = grassPrices[grassType] || 0.35;
            const palletPrice = palletPrices[grassType] || 175;
            
            let materialCost = 0;
            if (purchaseType === 'rolls') {
                materialCost = individualRolls * (pricePerUnit || (grassPrice * 10)); // $ per roll
            } else if (purchaseType === 'pallets') {
                materialCost = fullPallets * (pricePerUnit || palletPrice);
            } else { // bulk
                materialCost = totalSqFt * (pricePerUnit || grassPrice);
            }

            // Additional costs
            const laborCost = laborCostPerSqFt * totalSqFt;
            const soilPrepCost = totalSqFt * 0.20; // $0.20 per sq ft
            const fertilizerCost = totalSqFt * 0.10; // $0.10 per sq ft
            const deliveryCost = fullPallets > 0 ? 75 : 0;

            const totalCost = materialCost + laborCost + soilPrepCost + fertilizerCost + deliveryCost;

            // Convert to USD first if not already USD
            const totalCostUSD = totalCost / exchangeRates[selectedCurrency];
            const materialCostUSD = materialCost / exchangeRates[selectedCurrency];

            // Get currency symbol
            const symbol = currencySymbols[selectedCurrency];

            // Format numbers
            function formatNumber(num, decimals = 0) {
                return num.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
            }

            function formatCurrency(num, decimals = 0) {
                return symbol + formatNumber(num, decimals);
            }

            // Update UI
            document.getElementById('totalSod').textContent = formatNumber(totalSqFt) + ' sq ft';
            document.getElementById('palletsRequired').textContent = formatNumber(fullPallets) + ' pallets';
            document.getElementById('totalCost').textContent = formatCurrency(totalCost);

            document.getElementById('areaShape').textContent = document.getElementById('areaType').options[document.getElementById('areaType').selectedIndex].text;
            document.getElementById('totalArea').textContent = formatNumber(netArea) + ' sq ft';
            document.getElementById('wasteFactorResult').textContent = ((wasteFactor - 1) * 100) + '%';
            document.getElementById('grassTypeResult').textContent = document.getElementById('grassType').options[document.getElementById('grassType').selectedIndex].text;

            document.getElementById('netArea').textContent = formatNumber(netArea) + ' sq ft';
            document.getElementById('wasteArea').textContent = formatNumber(wasteArea) + ' sq ft';
            document.getElementById('totalSodNeeded').textContent = formatNumber(totalSqFt) + ' sq ft';
            document.getElementById('individualRolls').textContent = formatNumber(individualRolls) + ' rolls';
            document.getElementById('fullPallets').textContent = formatNumber(fullPallets) + ' pallets';

            document.getElementById('sodMaterials').textContent = formatCurrency(materialCost);
            document.getElementById('laborTotal').textContent = formatCurrency(laborCost);
            document.getElementById('soilPrep').textContent = formatCurrency(soilPrepCost);
            document.getElementById('fertilizerCost').textContent = formatCurrency(fertilizerCost);
            document.getElementById('deliveryCost').textContent = formatCurrency(deliveryCost);

            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + formatNumber(totalCostUSD);
            document.getElementById('convertEUR').textContent = '€' + formatNumber(totalCostUSD * exchangeRates.EUR);
            document.getElementById('convertGBP').textContent = '£' + formatNumber(totalCostUSD * exchangeRates.GBP);
            document.getElementById('convertINR').textContent = '₹' + formatNumber(totalCostUSD * exchangeRates.INR);
            document.getElementById('convertCAD').textContent = 'C$' + formatNumber(totalCostUSD * exchangeRates.CAD);
            document.getElementById('convertAUD').textContent = 'A$' + formatNumber(totalCostUSD * exchangeRates.AUD);
        }

        window.addEventListener('load', function() {
            calculateSod();
        });

        // Update calculations when currency changes
        document.getElementById('currency').addEventListener('change', calculateSod);
        
        // Update calculations when any input changes
        const inputs = ['areaType', 'length', 'width', 'radius', 'base', 'height', 'area', 'wasteFactor', 'grassType', 'purchaseType', 'pricePerUnit', 'laborCost'];
        inputs.forEach(id => {
            document.getElementById(id).addEventListener('input', calculateSod);
        });
    </script>
</body>
</html>