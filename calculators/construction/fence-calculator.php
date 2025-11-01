<?php
/**
 * Fence Calculator
 * File: construction/fence-calculator.php
 * Description: Calculate fence materials, costs, and installation with multi-currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fence Calculator - Material & Cost Estimation</title>
    <meta name="description" content="Free fence calculator with multi-currency support. Calculate materials, costs, and installation for wood, vinyl, chain link, and aluminum fences.">
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
        
        @media (max-width: 768px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .header h1 { font-size: 2rem; }
            .result-card .amount { font-size: 2.5rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚧 Fence Calculator</h1>
            <p>Calculate fence materials, costs, and installation with multi-currency pricing</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Fence Dimensions</h2>
                <form id="fenceCalculatorForm">
                    <div class="form-group">
                        <label for="fenceLength">Fence Length (feet)</label>
                        <input type="number" id="fenceLength" value="100" min="1" step="1" required>
                        <small>Total length of the fence line</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="fenceHeight">Fence Height (feet)</label>
                        <input type="number" id="fenceHeight" value="6" min="1" step="0.5" required>
                        <small>Height of the fence</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="fenceType">Fence Type</label>
                        <select id="fenceType" required>
                            <option value="wood">Wood (Cedar)</option>
                            <option value="vinyl">Vinyl</option>
                            <option value="chainlink">Chain Link</option>
                            <option value="aluminum">Aluminum</option>
                            <option value="composite">Composite</option>
                            <option value="wroughtiron">Wrought Iron</option>
                        </select>
                        <small>Select the type of fence material</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="postSpacing">Post Spacing (feet)</label>
                        <input type="number" id="postSpacing" value="8" min="4" max="12" step="0.5" required>
                        <small>Distance between fence posts (typically 6-8 feet)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="gateCount">Number of Gates</label>
                        <input type="number" id="gateCount" value="1" min="0" required>
                        <small>How many gates in the fence</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="laborCost">Labor Cost per Linear Foot</label>
                        <div class="input-group">
                            <input type="number" id="laborCost" value="15" min="0" step="0.01">
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
                        <small>Optional: installation cost per linear foot</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Fence Materials & Cost</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Total Estimated Cost</h3>
                    <div class="amount" id="totalCost">$2,850</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Materials Cost</h4>
                        <div class="value" id="materialsCost">$1,350</div>
                    </div>
                    <div class="metric-card">
                        <h4>Labor Cost</h4>
                        <div class="value" id="laborTotal">$1,500</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Fence Details</h3>
                    <div class="breakdown-item">
                        <span>Fence Type</span>
                        <strong id="fenceTypeResult">Wood (Cedar)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Length</span>
                        <strong id="totalLength">100 feet</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fence Height</span>
                        <strong id="fenceHeightResult">6 feet</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Post Spacing</span>
                        <strong id="postSpacingResult">8 feet</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Materials Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Number of Posts</span>
                        <strong id="numPosts">14 posts</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Number of Rails</span>
                        <strong id="numRails">42 rails</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Number of Pickets</span>
                        <strong id="numPickets">600 pickets</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Concrete for Posts</span>
                        <strong id="concreteAmount">14 bags</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Number of Gates</span>
                        <strong id="numGates">1 gate</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Materials Cost</span>
                        <strong id="materialsCostBreakdown">$1,350</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Labor Cost</span>
                        <strong id="laborCostBreakdown">$1,500</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gate Cost</span>
                        <strong id="gateCost">$200</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hardware & Fasteners</span>
                        <strong id="hardwareCost">$150</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Concrete Cost</span>
                        <strong id="concreteCost">$70</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$2,850</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€2,613</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£2,245</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹238,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAD (Canadian Dollar)</span>
                        <strong id="convertCAD">C$3,905</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>AUD (Australian Dollar)</span>
                        <strong id="convertAUD">A$4,275</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Fence Type Comparison</h3>
                    <div class="breakdown-item">
                        <span>Wood (Cedar)</span>
                        <strong>$13.50/ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Vinyl</span>
                        <strong>$20-35/ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Chain Link</span>
                        <strong>$8-15/ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Aluminum</span>
                        <strong>$20-30/ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Wrought Iron</span>
                        <strong>$25-50/ft</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Fence Planning Tips:</strong> Always check local building codes and property lines before installation. Consider factors like wind load, soil conditions, and gate placement. For accurate estimates, consult with local suppliers for material costs and contractors for labor rates.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🚧 Fence Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional fence material and cost calculations with multi-currency support</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('fenceCalculatorForm');

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

        // Material cost per linear foot (USD)
        const materialCosts = {
            wood: 13.50,      // Wood (Cedar)
            vinyl: 25.00,     // Vinyl
            chainlink: 11.50, // Chain Link
            aluminum: 25.00,  // Aluminum
            composite: 30.00, // Composite
            wroughtiron: 37.50 // Wrought Iron
        };

        // Gate costs (USD)
        const gateCosts = {
            wood: 200,
            vinyl: 350,
            chainlink: 150,
            aluminum: 300,
            composite: 400,
            wroughtiron: 500
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateFence();
        });

        function calculateFence() {
            const fenceLength = parseFloat(document.getElementById('fenceLength').value);
            const fenceHeight = parseFloat(document.getElementById('fenceHeight').value);
            const fenceType = document.getElementById('fenceType').value;
            const postSpacing = parseFloat(document.getElementById('postSpacing').value);
            const gateCount = parseInt(document.getElementById('gateCount').value);
            const laborCostPerFoot = parseFloat(document.getElementById('laborCost').value) || 0;
            const selectedCurrency = document.getElementById('currency').value;

            // Calculate number of posts (add 1 for end post, round up)
            const numPosts = Math.ceil(fenceLength / postSpacing) + 1;
            
            // Calculate number of rails (typically 2-3 rails depending on height)
            const numRailsPerSection = fenceHeight <= 4 ? 2 : 3;
            const numRails = (numPosts - 1) * numRailsPerSection;
            
            // Calculate number of pickets (based on fence type and spacing)
            let picketsPerFoot;
            switch(fenceType) {
                case 'wood':
                    picketsPerFoot = 6; // 2-inch pickets with 1/4-inch gap
                    break;
                case 'vinyl':
                    picketsPerFoot = 5.5; // Slightly wider pickets
                    break;
                case 'chainlink':
                    picketsPerFoot = 0; // No pickets for chain link
                    break;
                case 'aluminum':
                    picketsPerFoot = 5; // Standard aluminum picket spacing
                    break;
                case 'composite':
                    picketsPerFoot = 5.5; // Similar to vinyl
                    break;
                case 'wroughtiron':
                    picketsPerFoot = 4; // Wider spacing for wrought iron
                    break;
                default:
                    picketsPerFoot = 6;
            }
            
            const numPickets = Math.ceil(fenceLength * picketsPerFoot);
            
            // Calculate concrete needed (1 bag per post)
            const concreteBags = numPosts;
            
            // Calculate material costs
            const materialCostPerFoot = materialCosts[fenceType];
            const materialsCost = fenceLength * materialCostPerFoot;
            const gateCost = gateCount * gateCosts[fenceType];
            const hardwareCost = materialsCost * 0.1; // 10% of materials cost
            const concreteCost = concreteBags * 5; // $5 per bag of concrete
            
            const totalMaterialsCost = materialsCost + gateCost + hardwareCost + concreteCost;
            
            // Calculate labor costs
            const laborCost = fenceLength * laborCostPerFoot;
            
            // Total project cost
            const totalCost = totalMaterialsCost + laborCost;

            // Convert to USD first if not already USD
            const totalCostUSD = totalCost / exchangeRates[selectedCurrency];
            const materialsCostUSD = totalMaterialsCost / exchangeRates[selectedCurrency];
            const laborCostUSD = laborCost / exchangeRates[selectedCurrency];

            // Get currency symbol
            const symbol = currencySymbols[selectedCurrency];

            // Format numbers with commas
            function formatNumber(num) {
                return num.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
            }

            // Update UI
            document.getElementById('totalCost').textContent = symbol + formatNumber(totalCost);
            document.getElementById('materialsCost').textContent = symbol + formatNumber(totalMaterialsCost);
            document.getElementById('laborTotal').textContent = symbol + formatNumber(laborCost);

            document.getElementById('fenceTypeResult').textContent = document.getElementById('fenceType').options[document.getElementById('fenceType').selectedIndex].text;
            document.getElementById('totalLength').textContent = formatNumber(fenceLength) + ' feet';
            document.getElementById('fenceHeightResult').textContent = fenceHeight + ' feet';
            document.getElementById('postSpacingResult').textContent = postSpacing + ' feet';

            document.getElementById('numPosts').textContent = formatNumber(numPosts) + ' posts';
            document.getElementById('numRails').textContent = formatNumber(numRails) + ' rails';
            document.getElementById('numPickets').textContent = formatNumber(numPickets) + ' pickets';
            document.getElementById('concreteAmount').textContent = formatNumber(concreteBags) + ' bags';
            document.getElementById('numGates').textContent = gateCount + ' gate' + (gateCount !== 1 ? 's' : '');

            document.getElementById('materialsCostBreakdown').textContent = symbol + formatNumber(materialsCost);
            document.getElementById('laborCostBreakdown').textContent = symbol + formatNumber(laborCost);
            document.getElementById('gateCost').textContent = symbol + formatNumber(gateCost);
            document.getElementById('hardwareCost').textContent = symbol + formatNumber(hardwareCost);
            document.getElementById('concreteCost').textContent = symbol + formatNumber(concreteCost);

            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + formatNumber(totalCostUSD);
            document.getElementById('convertEUR').textContent = '€' + formatNumber(totalCostUSD * exchangeRates.EUR);
            document.getElementById('convertGBP').textContent = '£' + formatNumber(totalCostUSD * exchangeRates.GBP);
            document.getElementById('convertINR').textContent = '₹' + formatNumber(totalCostUSD * exchangeRates.INR);
            document.getElementById('convertCAD').textContent = 'C$' + formatNumber(totalCostUSD * exchangeRates.CAD);
            document.getElementById('convertAUD').textContent = 'A$' + formatNumber(totalCostUSD * exchangeRates.AUD);
        }

        window.addEventListener('load', function() {
            calculateFence();
        });

        // Update calculations when currency changes
        document.getElementById('currency').addEventListener('change', calculateFence);
        
        // Update calculations when any input changes
        const inputs = ['fenceLength', 'fenceHeight', 'fenceType', 'postSpacing', 'gateCount', 'laborCost'];
        inputs.forEach(id => {
            document.getElementById(id).addEventListener('input', calculateFence);
        });
    </script>
</body>
</html>