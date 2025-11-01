<?php
/**
 * Insulation Calculator
 * File: construction/insulation-calculator.php
 * Description: Calculate insulation requirements, R-values, and costs with multi-currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insulation Calculator - R-Value, Materials & Cost Estimation</title>
    <meta name="description" content="Free insulation calculator with multi-currency support. Calculate insulation batts, rolls, spray foam requirements and costs in USD, EUR, GBP, INR, and more.">
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
        
        .insulation-options { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .insulation-card { border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; cursor: pointer; transition: all 0.3s; }
        .insulation-card.selected { border-color: #667eea; background: #f0f4ff; }
        .insulation-card h4 { color: #333; margin-bottom: 5px; }
        .insulation-card .r-value { color: #e74c3c; font-weight: bold; font-size: 0.9em; }
        .insulation-card .price { color: #667eea; font-weight: bold; }
        
        .area-type-options { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; }
        .area-type-card { border: 2px solid #e0e0e0; border-radius: 8px; padding: 12px; text-align: center; cursor: pointer; transition: all 0.3s; }
        .area-type-card.selected { border-color: #667eea; background: #f0f4ff; }
        .area-type-card h4 { color: #333; margin-bottom: 5px; font-size: 0.9em; }
        .area-type-card .r-recommended { color: #e74c3c; font-size: 0.8em; }
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; }
        .result-card .amount { font-size: 3rem; font-weight: bold; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #667eea; font-size: 2rem; font-weight: bold; }
        
        .materials-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px; }
        .material-item { background: white; padding: 15px; border-radius: 8px; border: 2px solid #e0e0e0; }
        .material-item h4 { color: #667eea; margin-bottom: 10px; }
        .material-item .quantity { font-size: 1.5rem; font-weight: bold; color: #333; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #667eea; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .r-value-scale { background: linear-gradient(90deg, #3498db, #2ecc71, #f39c12, #e74c3c); height: 20px; border-radius: 10px; margin: 15px 0; position: relative; }
        .r-value-marker { position: absolute; top: -5px; width: 4px; height: 30px; background: #333; transform: translateX(-50%); }
        
        .info-box { background: #e8f2ff; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .header h1 { font-size: 2rem; }
            .result-card .amount { font-size: 2.5rem; }
            .metric-grid, .materials-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .dimension-inputs { grid-template-columns: 1fr; }
            .insulation-options { grid-template-columns: 1fr; }
            .area-type-options { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🧱 Insulation Calculator</h1>
            <p>Calculate insulation requirements, R-values, and energy savings</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Project Specifications</h2>
                <form id="insulationForm">
                    <div class="form-group">
                        <label for="areaType">Area to Insulate</label>
                        <div class="area-type-options">
                            <div class="area-type-card selected" data-type="wall" data-rrecommended="13-21">
                                <h4>Exterior Wall</h4>
                                <div class="r-recommended">R-13 to R-21</div>
                            </div>
                            <div class="area-type-card" data-type="attic" data-rrecommended="30-60">
                                <h4>Attic</h4>
                                <div class="r-recommended">R-30 to R-60</div>
                            </div>
                            <div class="area-type-card" data-type="floor" data-rrecommended="25-30">
                                <h4>Floor</h4>
                                <div class="r-recommended">R-25 to R-30</div>
                            </div>
                            <div class="area-type-card" data-type="ceiling" data-rrecommended="30-38">
                                <h4>Ceiling</h4>
                                <div class="r-recommended">R-30 to R-38</div>
                            </div>
                            <div class="area-type-card" data-type="basement" data-rrecommended="10-15">
                                <h4>Basement Wall</h4>
                                <div class="r-recommended">R-10 to R-15</div>
                            </div>
                            <div class="area-type-card" data-type="custom" data-rrecommended="custom">
                                <h4>Custom Area</h4>
                                <div class="r-recommended">Set R-Value</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dimension-inputs">
                        <div class="form-group">
                            <label for="length">Length (feet)</label>
                            <input type="number" id="length" value="20" min="1" step="0.5" required>
                        </div>
                        <div class="form-group">
                            <label for="height">Height (feet)</label>
                            <input type="number" id="height" value="8" min="1" step="0.5" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="rValue">Desired R-Value</label>
                        <input type="number" id="rValue" value="21" min="1" max="60" step="1" required>
                        <small>Thermal resistance value (higher = better insulation)</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Insulation Type</label>
                        <div class="insulation-options">
                            <div class="insulation-card selected" data-type="fiberglass" data-price="0.50" data-rperinch="3.2">
                                <h4>Fiberglass Batts</h4>
                                <div class="r-value">R-3.2 per inch</div>
                                <div class="price">$0.50/sq ft</div>
                                <small>Standard, easy installation</small>
                            </div>
                            <div class="insulation-card" data-type="cellulose" data-price="0.65" data-rperinch="3.7">
                                <h4>Blown Cellulose</h4>
                                <div class="r-value">R-3.7 per inch</div>
                                <div class="price">$0.65/sq ft</div>
                                <small>Good for attics, eco-friendly</small>
                            </div>
                            <div class="insulation-card" data-type="sprayfoam" data-price="2.50" data-rperinch="6.5">
                                <h4>Spray Foam</h4>
                                <div class="r-value">R-6.5 per inch</div>
                                <div class="price">$2.50/sq ft</div>
                                <small>High performance, air sealing</small>
                            </div>
                            <div class="insulation-card" data-type="mineralwool" data-price="0.85" data-rperinch="4.0">
                                <h4>Mineral Wool</h4>
                                <div class="r-value">R-4.0 per inch</div>
                                <div class="price">$0.85/sq ft</div>
                                <small>Fire resistant, sound proofing</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="thickness">Insulation Thickness (inches)</label>
                        <select id="thickness">
                            <option value="3.5">3.5" (2×4 wall)</option>
                            <option value="5.5" selected>5.5" (2×6 wall)</option>
                            <option value="8">8" (Attic)</option>
                            <option value="10">10" (Deep attic)</option>
                            <option value="12">12" (Maximum)</option>
                        </select>
                        <small>Available space for insulation</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="laborCost">Labor Cost</label>
                        <div class="input-group">
                            <input type="number" id="laborCost" value="1.25" min="0" step="0.25">
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
                        <small>Cost per square foot for professional installation</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="climateZone">Climate Zone</label>
                        <select id="climateZone">
                            <option value="1">Zone 1 (Hot) - R-13 walls, R-30 attic</option>
                            <option value="2">Zone 2 (Warm) - R-13 walls, R-38 attic</option>
                            <option value="3" selected>Zone 3 (Moderate) - R-19 walls, R-38 attic</option>
                            <option value="4">Zone 4 (Cool) - R-21 walls, R-49 attic</option>
                            <option value="5">Zone 5 (Cold) - R-21 walls, R-60 attic</option>
                            <option value="6">Zone 6 (Very Cold) - R-21 walls, R-60 attic</option>
                            <option value="7">Zone 7 (Arctic) - R-21 walls, R-60 attic</option>
                        </select>
                        <small>Recommended R-values based on your climate</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Insulation</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Insulation Analysis</h2>
                
                <div class="result-card">
                    <h3>Total Project Cost</h3>
                    <div class="amount" id="totalCost">$420</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Area to Cover</h4>
                        <div class="value" id="totalArea">160 sq ft</div>
                    </div>
                    <div class="metric-card">
                        <h4>Actual R-Value</h4>
                        <div class="value" id="actualRValue">R-17.6</div>
                    </div>
                </div>

                <div class="materials-grid">
                    <div class="material-item">
                        <h4>Insulation Batts</h4>
                        <div class="quantity" id="battsCount">10 batts</div>
                        <small>15" × 93" each</small>
                    </div>
                    <div class="material-item">
                        <h4>Rolls Needed</h4>
                        <div class="quantity" id="rollsCount">2 rolls</div>
                        <small>Coverage per roll</small>
                    </div>
                    <div class="material-item">
                        <h4>Vapor Barrier</h4>
                        <div class="quantity" id="barrierRolls">1 roll</div>
                        <small>6 mil polyethylene</small>
                    </div>
                    <div class="material-item">
                        <h4>Fasteners</h4>
                        <div class="quantity" id="fastenersCount">48 staples</div>
                        <small>Insulation staples</small>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>R-Value Analysis</h3>
                    <div class="r-value-scale">
                        <div class="r-value-marker" id="rValueMarker" style="left: 35%;"></div>
                    </div>
                    <div class="breakdown-item">
                        <span>Desired R-Value</span>
                        <strong id="desiredRValue">R-21</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Actual R-Value</span>
                        <strong id="calculatedRValue">R-17.6</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Efficiency</span>
                        <strong id="efficiency">83.8%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Recommended for Zone</span>
                        <strong id="zoneRecommendation">R-19 walls</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Insulation Material</span>
                        <strong id="materialCost">$80.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Vapor Barrier</span>
                        <strong id="barrierCost">$25.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fasteners & Supplies</span>
                        <strong id="suppliesCost">$15.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Labor Cost</span>
                        <strong id="laborTotal">$200.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Subtotal</span>
                        <strong id="costSubtotal">$320.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Tax (8%)</span>
                        <strong id="taxAmount">$25.60</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Project Cost</span>
                        <strong id="finalTotal">$345.60</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Energy Savings</h3>
                    <div class="breakdown-item">
                        <span>Heat Loss Reduction</span>
                        <strong id="heatLossReduction">78%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated Annual Savings</span>
                        <strong id="annualSavings">$285</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Payback Period</span>
                        <strong id="paybackPeriod">1.2 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CO₂ Reduction</span>
                        <strong id="co2Reduction">1.2 tons/year</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Material Specifications</h3>
                    <div class="breakdown-item">
                        <span>Insulation Type</span>
                        <strong id="insulationType">Fiberglass Batts</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Thickness</span>
                        <strong id="insulationThickness">5.5 inches</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>R-Value per Inch</span>
                        <strong id="rPerInch">R-3.2</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Coverage Area</span>
                        <strong id="coverageArea">160 sq ft</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$345.60</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€317.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£273.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹28,857</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAD (Canadian Dollar)</span>
                        <strong id="convertCAD">C$473.47</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>AUD (Australian Dollar)</span>
                        <strong id="convertAUD">A$518.40</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Energy Efficiency Tip:</strong> Proper insulation can reduce heating and cooling costs by 20-30%. Consider air sealing before insulating for maximum efficiency. Higher R-values provide better thermal resistance but require more space and material.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🧱 Insulation Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional insulation planning with energy savings analysis</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('insulationForm');
        const insulationCards = document.querySelectorAll('.insulation-card');
        const areaTypeCards = document.querySelectorAll('.area-type-card');
        let selectedInsulation = 'fiberglass';
        let selectedInsulationPrice = 0.50;
        let selectedRPerInch = 3.2;
        let selectedAreaType = 'wall';
        let recommendedRValue = '13-21';

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

        // Climate zone recommendations
        const zoneRecommendations = {
            1: { walls: 'R-13', attic: 'R-30' },
            2: { walls: 'R-13', attic: 'R-38' },
            3: { walls: 'R-19', attic: 'R-38' },
            4: { walls: 'R-21', attic: 'R-49' },
            5: { walls: 'R-21', attic: 'R-60' },
            6: { walls: 'R-21', attic: 'R-60' },
            7: { walls: 'R-21', attic: 'R-60' }
        };

        // Insulation selection
        insulationCards.forEach(card => {
            card.addEventListener('click', function() {
                insulationCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedInsulation = this.dataset.type;
                selectedInsulationPrice = parseFloat(this.dataset.price);
                selectedRPerInch = parseFloat(this.dataset.rperinch);
            });
        });

        // Area type selection
        areaTypeCards.forEach(card => {
            card.addEventListener('click', function() {
                areaTypeCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedAreaType = this.dataset.type;
                recommendedRValue = this.dataset.rrecommended;
                
                // Update R-value input based on selection
                if (selectedAreaType !== 'custom') {
                    const rRange = recommendedRValue.split('-');
                    const recommendedR = parseInt(rRange[0]);
                    document.getElementById('rValue').value = recommendedR;
                }
            });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateInsulation();
        });

        function calculateInsulation() {
            const length = parseFloat(document.getElementById('length').value);
            const height = parseFloat(document.getElementById('height').value);
            const desiredRValue = parseFloat(document.getElementById('rValue').value);
            const thickness = parseFloat(document.getElementById('thickness').value);
            const laborCost = parseFloat(document.getElementById('laborCost').value) || 0;
            const climateZone = parseInt(document.getElementById('climateZone').value);
            const selectedCurrency = document.getElementById('currency').value;
            const symbol = currencySymbols[selectedCurrency];

            // Calculate area
            const totalArea = length * height;

            // Calculate actual R-value based on thickness and material
            const actualRValue = thickness * selectedRPerInch;

            // Calculate materials
            const battsPerSqFt = 0.75; // 1 batt covers ~10.67 sq ft
            const battsNeeded = Math.ceil(totalArea * battsPerSqFt);
            const rollsNeeded = Math.ceil(totalArea / 100); // 1 roll covers ~100 sq ft
            const barrierRolls = Math.ceil(totalArea / 500); // 1 roll covers 500 sq ft
            const fastenersNeeded = Math.ceil(totalArea * 0.3); // ~1 fastener per 3 sq ft

            // Calculate costs
            const materialCost = totalArea * selectedInsulationPrice;
            const barrierCost = barrierRolls * 25;
            const suppliesCost = fastenersNeeded * 0.15 + 10; // staples + misc
            const laborTotal = laborCost * totalArea;

            const costSubtotal = materialCost + barrierCost + suppliesCost + laborTotal;
            const taxRate = 0.08;
            const taxAmount = costSubtotal * taxRate;
            const finalTotal = costSubtotal + taxAmount;

            // Convert to USD first if not already USD
            const finalTotalUSD = finalTotal / exchangeRates[selectedCurrency];

            // Calculate energy savings
            const efficiency = Math.min(100, (actualRValue / desiredRValue) * 100);
            const heatLossReduction = Math.min(90, (actualRValue / (actualRValue + 5)) * 100);
            const annualSavings = totalArea * 0.35 * (heatLossReduction / 100) * 12;
            const paybackPeriod = finalTotal / annualSavings;
            const co2Reduction = (annualSavings / 100) * 0.42; // tons of CO2

            // Update R-value marker position
            const rValuePercentage = Math.min(100, (actualRValue / 60) * 100);
            document.getElementById('rValueMarker').style.left = rValuePercentage + '%';

            // Update UI
            document.getElementById('totalCost').textContent = symbol + Math.round(finalTotal);
            document.getElementById('totalArea').textContent = totalArea + ' sq ft';
            document.getElementById('actualRValue').textContent = 'R-' + actualRValue.toFixed(1);

            document.getElementById('battsCount').textContent = battsNeeded + ' batts';
            document.getElementById('rollsCount').textContent = rollsNeeded + ' rolls';
            document.getElementById('barrierRolls').textContent = barrierRolls + ' roll' + (barrierRolls !== 1 ? 's' : '');
            document.getElementById('fastenersCount').textContent = fastenersNeeded + ' staples';

            document.getElementById('desiredRValue').textContent = 'R-' + desiredRValue;
            document.getElementById('calculatedRValue').textContent = 'R-' + actualRValue.toFixed(1);
            document.getElementById('efficiency').textContent = efficiency.toFixed(1) + '%';
            document.getElementById('zoneRecommendation').textContent = zoneRecommendations[climateZone].walls + ' walls, ' + zoneRecommendations[climateZone].attic + ' attic';

            document.getElementById('materialCost').textContent = symbol + materialCost.toFixed(2);
            document.getElementById('barrierCost').textContent = symbol + barrierCost.toFixed(2);
            document.getElementById('suppliesCost').textContent = symbol + suppliesCost.toFixed(2);
            document.getElementById('laborTotal').textContent = symbol + laborTotal.toFixed(2);
            document.getElementById('costSubtotal').textContent = symbol + costSubtotal.toFixed(2);
            document.getElementById('taxAmount').textContent = symbol + taxAmount.toFixed(2);
            document.getElementById('finalTotal').textContent = symbol + finalTotal.toFixed(2);

            document.getElementById('heatLossReduction').textContent = heatLossReduction.toFixed(0) + '%';
            document.getElementById('annualSavings').textContent = symbol + Math.round(annualSavings);
            document.getElementById('paybackPeriod').textContent = paybackPeriod.toFixed(1) + ' years';
            document.getElementById('co2Reduction').textContent = co2Reduction.toFixed(1) + ' tons/year';

            document.getElementById('insulationType').textContent = selectedInsulation.charAt(0).toUpperCase() + selectedInsulation.slice(1);
            document.getElementById('insulationThickness').textContent = thickness + ' inches';
            document.getElementById('rPerInch').textContent = 'R-' + selectedRPerInch.toFixed(1);
            document.getElementById('coverageArea').textContent = totalArea + ' sq ft';

            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + finalTotalUSD.toFixed(2);
            document.getElementById('convertEUR').textContent = '€' + (finalTotalUSD * exchangeRates.EUR).toFixed(2);
            document.getElementById('convertGBP').textContent = '£' + (finalTotalUSD * exchangeRates.GBP).toFixed(2);
            document.getElementById('convertINR').textContent = '₹' + Math.round(finalTotalUSD * exchangeRates.INR).toLocaleString();
            document.getElementById('convertCAD').textContent = 'C$' + (finalTotalUSD * exchangeRates.CAD).toFixed(2);
            document.getElementById('convertAUD').textContent = 'A$' + (finalTotalUSD * exchangeRates.AUD).toFixed(2);
        }

        window.addEventListener('load', function() {
            calculateInsulation();
        });

        // Update calculations when inputs change
        document.getElementById('currency').addEventListener('change', calculateInsulation);
        document.getElementById('thickness').addEventListener('change', calculateInsulation);
        document.getElementById('climateZone').addEventListener('change', calculateInsulation);
        document.getElementById('rValue').addEventListener('input', calculateInsulation);
    </script>
</body>
</html>
