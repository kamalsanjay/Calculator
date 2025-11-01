<?php
/**
 * Board Feet Calculator
 * File: construction/board-feet-calculator.php
 * Description: Calculate lumber volume in board feet with multi-currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Board Feet Calculator - Lumber Volume & Cost Estimation</title>
    <meta name="description" content="Free board feet calculator with multi-currency support. Calculate lumber volume in board feet, estimate costs in USD, EUR, GBP, INR, and more.">
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
            <h1>🪵 Board Feet Calculator</h1>
            <p>Calculate lumber volume in board feet with multi-currency pricing</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Lumber Dimensions</h2>
                <form id="boardFeetForm">
                    <div class="form-group">
                        <label for="thickness">Thickness (inches)</label>
                        <input type="number" id="thickness" value="2" min="0.25" step="0.25" required>
                        <small>Actual thickness in inches (e.g., 2 for 2×4)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="width">Width (inches)</label>
                        <input type="number" id="width" value="4" min="0.5" step="0.25" required>
                        <small>Actual width in inches (e.g., 4 for 2×4)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="length">Length (feet)</label>
                        <input type="number" id="length" value="8" min="1" step="0.5" required>
                        <small>Total length in feet</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantity">Number of Boards</label>
                        <input type="number" id="quantity" value="10" min="1" required>
                        <small>How many boards of this size</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="pricePerBoardFoot">Price per Board Foot</label>
                        <div class="input-group">
                            <input type="number" id="pricePerBoardFoot" value="3.50" min="0" step="0.01">
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
                        <small>Optional: cost per board foot in selected currency</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Board Feet</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Calculation Results</h2>
                
                <div class="result-card">
                    <h3>Total Board Feet</h3>
                    <div class="amount" id="totalBoardFeet">53.33 BF</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Per Board</h4>
                        <div class="value" id="perBoard">5.33 BF</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Cost</h4>
                        <div class="value" id="totalCost">$186.67</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Board Details</h3>
                    <div class="breakdown-item">
                        <span>Board Size</span>
                        <strong id="boardSize">2" × 4" × 8'</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Board Feet per Board</span>
                        <strong id="bfPerBoard">5.33 BF</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Number of Boards</span>
                        <strong id="numBoards">10 boards</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Board Feet</span>
                        <strong id="totalBF">53.33 BF</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Cost Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Price per Board Foot</span>
                        <strong id="priceBF">$3.50 / BF</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cost per Board</span>
                        <strong id="costPerBoard">$18.67</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Project Cost</span>
                        <strong id="projectCost">$186.67</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Currency Conversions</h3>
                    <div class="breakdown-item">
                        <span>USD (US Dollar)</span>
                        <strong id="convertUSD">$186.67</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>EUR (Euro)</span>
                        <strong id="convertEUR">€171.14</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GBP (British Pound)</span>
                        <strong id="convertGBP">£147.00</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>INR (Indian Rupee)</span>
                        <strong id="convertINR">₹15,667</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CAD (Canadian Dollar)</span>
                        <strong id="convertCAD">C$255.33</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>AUD (Australian Dollar)</span>
                        <strong id="convertAUD">A$280.00</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Volume & Weight</h3>
                    <div class="breakdown-item">
                        <span>Total Volume</span>
                        <strong id="totalVolume">6.67 cubic feet</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Approx. Weight (Pine)</span>
                        <strong id="weightPine">167 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Approx. Weight (Oak)</span>
                        <strong id="weightOak">300 lbs</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Common Sizes Reference</h3>
                    <div class="breakdown-item">
                        <span>2×4 × 8' Board</span>
                        <strong>5.33 BF</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>2×6 × 8' Board</span>
                        <strong>8.00 BF</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>2×8 × 8' Board</span>
                        <strong>10.67 BF</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>1×12 × 8' Board</span>
                        <strong>8.00 BF</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Board Feet Formula:</strong> Board Feet = (Thickness in inches × Width in inches × Length in feet) ÷ 12. This standard measurement helps you compare lumber prices and estimate project costs across different currencies and markets.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🪵 Board Feet Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Essential lumber volume calculations with multi-currency support</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('boardFeetForm');

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

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBoardFeet();
        });

        function calculateBoardFeet() {
            const thickness = parseFloat(document.getElementById('thickness').value);
            const width = parseFloat(document.getElementById('width').value);
            const length = parseFloat(document.getElementById('length').value);
            const quantity = parseInt(document.getElementById('quantity').value);
            const pricePerBF = parseFloat(document.getElementById('pricePerBoardFoot').value) || 0;
            const selectedCurrency = document.getElementById('currency').value;

            // Calculate board feet per board
            const bfPerBoard = (thickness * width * length) / 12;
            
            // Calculate total board feet
            const totalBF = bfPerBoard * quantity;

            // Calculate costs in selected currency
            const costPerBoard = bfPerBoard * pricePerBF;
            const totalCost = totalBF * pricePerBF;

            // Convert to USD first if not already USD
            const totalCostUSD = totalCost / exchangeRates[selectedCurrency];

            // Calculate volume in cubic feet
            const volumePerBoard = (thickness * width * length) / 144;
            const totalVolume = volumePerBoard * quantity;

            // Estimate weights
            const pineDensity = 25;
            const oakDensity = 45;
            const weightPine = Math.round(totalVolume * pineDensity);
            const weightOak = Math.round(totalVolume * oakDensity);

            // Get currency symbol
            const symbol = currencySymbols[selectedCurrency];

            // Update UI
            document.getElementById('totalBoardFeet').textContent = totalBF.toFixed(2) + ' BF';
            document.getElementById('perBoard').textContent = bfPerBoard.toFixed(2) + ' BF';
            document.getElementById('totalCost').textContent = symbol + totalCost.toFixed(2);

            document.getElementById('boardSize').textContent = `${thickness}" × ${width}" × ${length}'`;
            document.getElementById('bfPerBoard').textContent = bfPerBoard.toFixed(2) + ' BF';
            document.getElementById('numBoards').textContent = quantity + ' board' + (quantity !== 1 ? 's' : '');
            document.getElementById('totalBF').textContent = totalBF.toFixed(2) + ' BF';

            document.getElementById('priceBF').textContent = symbol + pricePerBF.toFixed(2) + ' / BF';
            document.getElementById('costPerBoard').textContent = symbol + costPerBoard.toFixed(2);
            document.getElementById('projectCost').textContent = symbol + totalCost.toFixed(2);

            // Currency conversions
            document.getElementById('convertUSD').textContent = '$' + totalCostUSD.toFixed(2);
            document.getElementById('convertEUR').textContent = '€' + (totalCostUSD * exchangeRates.EUR).toFixed(2);
            document.getElementById('convertGBP').textContent = '£' + (totalCostUSD * exchangeRates.GBP).toFixed(2);
            document.getElementById('convertINR').textContent = '₹' + Math.round(totalCostUSD * exchangeRates.INR).toLocaleString();
            document.getElementById('convertCAD').textContent = 'C$' + (totalCostUSD * exchangeRates.CAD).toFixed(2);
            document.getElementById('convertAUD').textContent = 'A$' + (totalCostUSD * exchangeRates.AUD).toFixed(2);

            document.getElementById('totalVolume').textContent = totalVolume.toFixed(2) + ' cubic feet';
            document.getElementById('weightPine').textContent = weightPine.toLocaleString() + ' lbs';
            document.getElementById('weightOak').textContent = weightOak.toLocaleString() + ' lbs';
        }

        window.addEventListener('load', function() {
            calculateBoardFeet();
        });

        // Update calculations when currency changes
        document.getElementById('currency').addEventListener('change', calculateBoardFeet);
    </script>
</body>
</html>