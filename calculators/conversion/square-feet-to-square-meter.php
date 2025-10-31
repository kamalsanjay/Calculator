<?php
/**
 * Square Feet to Square Meter Converter
 * File: conversion/square-feet-to-square-meter.php
 * Description: Convert square feet to square meters and vice versa
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Square Feet to Square Meter Converter - ft² to m² Calculator</title>
    <meta name="description" content="Convert square feet to square meters (m²) and m² to ft² instantly. Bidirectional area converter for real estate and measurements.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 900px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 70px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #11998e; box-shadow: 0 0 0 3px rgba(17, 153, 142, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #11998e; font-weight: 600; font-size: 0.95rem; }
        
        .swap-btn { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-box { background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #11998e; margin-bottom: 25px; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.5rem; font-weight: bold; color: #11998e; margin-bottom: 10px; }
        .result-formula { background: white; padding: 15px; border-radius: 8px; font-family: 'Courier New', monospace; color: #555; font-size: 0.9rem; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #11998e; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(17, 153, 142, 0.15); }
        .quick-value { font-weight: bold; color: #11998e; font-size: 1.1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #e8f5e9; }
        
        .formula-box { background: #e8f5e9; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #11998e; }
        .formula-box strong { color: #11998e; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .converter-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .header h1 { font-size: 1.5rem; }
            .result-value { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏠 Square Feet ⇄ Square Meter</h1>
            <p>Convert between square feet and square meters with bidirectional conversion</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="sqftInput">Square Feet</label>
                    <div class="input-wrapper">
                        <input type="number" id="sqftInput" placeholder="Enter sq ft" step="0.01" min="0" value="1000">
                        <span class="unit-label">ft²</span>
                    </div>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="sqmInput">Square Meters</label>
                    <div class="input-wrapper">
                        <input type="number" id="sqmInput" placeholder="Enter m²" step="0.01" min="0">
                        <span class="unit-label">m²</span>
                    </div>
                </div>
            </div>

            <div class="result-box">
                <div class="result-label">Result</div>
                <div class="result-value" id="resultValue">1,000 ft² = 92.90 m²</div>
                <div class="result-formula" id="resultFormula">1,000 sq ft × 0.092903 = 92.90 m²</div>
            </div>

            <div class="quick-convert">
                <h3>🏠 Common Areas</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setSqFt(500)">
                        <div class="quick-value">500 ft²</div>
                        <div class="quick-label">Studio</div>
                    </div>
                    <div class="quick-btn" onclick="setSqFt(1000)">
                        <div class="quick-value">1,000 ft²</div>
                        <div class="quick-label">Small House</div>
                    </div>
                    <div class="quick-btn" onclick="setSqFt(2000)">
                        <div class="quick-value">2,000 ft²</div>
                        <div class="quick-label">Medium House</div>
                    </div>
                    <div class="quick-btn" onclick="setSqFt(3000)">
                        <div class="quick-value">3,000 ft²</div>
                        <div class="quick-label">Large House</div>
                    </div>
                    <div class="quick-btn" onclick="setSqFt(5000)">
                        <div class="quick-value">5,000 ft²</div>
                        <div class="quick-label">Mansion</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🏠 Square Feet to Square Meter Conversion</h2>
            
            <p><strong>Square feet (ft²)</strong> is the imperial unit of area used primarily in the United States, while <strong>square meters (m²)</strong> is the metric standard used worldwide for measuring floor space and land area.</p>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>Square Feet to Square Meters:</strong><br>
                • Square Meters = Square Feet × 0.092903<br>
                • 1 ft² = 0.092903 m² (exact)<br><br>
                <strong>Square Meters to Square Feet:</strong><br>
                • Square Feet = Square Meters ÷ 0.092903<br>
                • 1 m² = 10.7639 ft²
            </div>

            <h3>📊 Area Comparison Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Square Feet (ft²)</th>
                        <th>Square Meters (m²)</th>
                        <th>Common Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>100 ft²</td><td>9.29 m²</td><td>Small bedroom</td></tr>
                    <tr><td>500 ft²</td><td>46.45 m²</td><td>Studio apartment</td></tr>
                    <tr><td>1,000 ft²</td><td>92.90 m²</td><td>Small house</td></tr>
                    <tr><td>1,500 ft²</td><td>139.35 m²</td><td>Average house</td></tr>
                    <tr><td>2,000 ft²</td><td>185.81 m²</td><td>Medium house</td></tr>
                    <tr><td>3,000 ft²</td><td>278.71 m²</td><td>Large house</td></tr>
                    <tr><td>5,000 ft²</td><td>464.52 m²</td><td>Mansion</td></tr>
                    <tr><td>10,000 ft²</td><td>929.03 m²</td><td>Large property</td></tr>
                </tbody>
            </table>

            <h3>🏡 Home Sizes</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Property Type</th>
                        <th>Square Feet</th>
                        <th>Square Meters</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Studio apartment</td><td>400-600 ft²</td><td>37-56 m²</td></tr>
                    <tr><td>1-bedroom apt</td><td>600-900 ft²</td><td>56-84 m²</td></tr>
                    <tr><td>2-bedroom apt</td><td>900-1,200 ft²</td><td>84-111 m²</td></tr>
                    <tr><td>3-bedroom house</td><td>1,500-2,000 ft²</td><td>139-186 m²</td></tr>
                    <tr><td>4-bedroom house</td><td>2,000-3,000 ft²</td><td>186-279 m²</td></tr>
                    <tr><td>5+ bedroom house</td><td>3,000-5,000+ ft²</td><td>279-465+ m²</td></tr>
                </tbody>
            </table>

            <h3>🏢 Room Sizes</h3>
            <ul>
                <li><strong>Master bedroom:</strong> 200-400 ft² (18.6-37.2 m²)</li>
                <li><strong>Standard bedroom:</strong> 100-200 ft² (9.3-18.6 m²)</li>
                <li><strong>Living room:</strong> 200-400 ft² (18.6-37.2 m²)</li>
                <li><strong>Kitchen:</strong> 100-200 ft² (9.3-18.6 m²)</li>
                <li><strong>Bathroom:</strong> 35-100 ft² (3.3-9.3 m²)</li>
                <li><strong>Garage (1-car):</strong> 200-250 ft² (18.6-23.2 m²)</li>
                <li><strong>Garage (2-car):</strong> 400-600 ft² (37.2-55.7 m²)</li>
            </ul>

            <h3>🏗️ Construction Standards</h3>
            <div class="formula-box">
                <strong>Building Measurements:</strong><br>
                • Small lot: 5,000-7,500 ft² (465-697 m²)<br>
                • Average lot: 8,000-10,000 ft² (743-929 m²)<br>
                • Large lot: 15,000-20,000 ft² (1,394-1,858 m²)<br>
                • Acre: 43,560 ft² (4,047 m²)<br>
                • Hectare: 107,639 ft² (10,000 m²)<br>
                • Square mile: 27,878,400 ft² (2.59 km²)
            </div>

            <h3>🏬 Commercial Spaces</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Space Type</th>
                        <th>Typical Size</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Small retail shop</td><td>500-1,000 ft² (46-93 m²)</td></tr>
                    <tr><td>Restaurant</td><td>2,000-5,000 ft² (186-465 m²)</td></tr>
                    <tr><td>Small office</td><td>1,000-2,500 ft² (93-232 m²)</td></tr>
                    <tr><td>Warehouse</td><td>10,000-50,000 ft² (929-4,645 m²)</td></tr>
                    <tr><td>Supermarket</td><td>40,000-60,000 ft² (3,716-5,574 m²)</td></tr>
                </tbody>
            </table>

            <h3>🏘️ Land Measurements</h3>
            <ul>
                <li><strong>1 acre:</strong> 43,560 ft² = 4,047 m² = 0.4047 hectares</li>
                <li><strong>1 hectare:</strong> 107,639 ft² = 10,000 m² = 2.471 acres</li>
                <li><strong>Quarter acre:</strong> 10,890 ft² = 1,012 m²</li>
                <li><strong>Half acre:</strong> 21,780 ft² = 2,023 m²</li>
                <li><strong>Basketball court:</strong> 4,700 ft² = 437 m²</li>
                <li><strong>Tennis court:</strong> 2,808 ft² = 261 m²</li>
            </ul>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>Square Feet to Square Meters (Easy):</strong><br>
                • Divide ft² by 10 for rough m²<br>
                • Example: 1,000 ft² ÷ 10 = 100 m²<br>
                • Actual: 1,000 ft² = 92.9 m² (close!)<br><br>
                <strong>Square Meters to Square Feet (Easy):</strong><br>
                • Multiply m² by 10 for rough ft²<br>
                • Example: 100 m² × 10 = 1,000 ft²<br>
                • Actual: 100 m² = 1,076 ft² (rough estimate)
            </div>

            <h3>🏠 Real Estate Usage</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Region</th>
                        <th>Primary Unit</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>United States</td><td>Square Feet</td><td>Almost exclusive use</td></tr>
                    <tr><td>United Kingdom</td><td>Square Feet</td><td>Real estate listings</td></tr>
                    <tr><td>Canada</td><td>Both</td><td>Transitioning to m²</td></tr>
                    <tr><td>Europe</td><td>Square Meters</td><td>Standard unit</td></tr>
                    <tr><td>Asia</td><td>Square Meters</td><td>Metric standard</td></tr>
                    <tr><td>Australia</td><td>Square Meters</td><td>Metric system</td></tr>
                </tbody>
            </table>

            <h3>📐 Floor Plan Dimensions</h3>
            <ul>
                <li><strong>10 × 10 room:</strong> 100 ft² = 9.3 m²</li>
                <li><strong>12 × 12 room:</strong> 144 ft² = 13.4 m²</li>
                <li><strong>15 × 15 room:</strong> 225 ft² = 20.9 m²</li>
                <li><strong>20 × 20 room:</strong> 400 ft² = 37.2 m²</li>
                <li><strong>25 × 30 room:</strong> 750 ft² = 69.7 m²</li>
            </ul>

            <h3>🏢 Office Space</h3>
            <div class="formula-box">
                <strong>Per Person Requirements:</strong><br>
                • Open office: 100-150 ft² per person (9-14 m²)<br>
                • Private office: 150-300 ft² (14-28 m²)<br>
                • Executive office: 300-500 ft² (28-46 m²)<br>
                • Cubicle: 64-100 ft² (6-9 m²)<br>
                • Conference room: 25-40 ft² per seat (2.3-3.7 m²)
            </div>

            <h3>🎯 Practical Examples</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Space</th>
                        <th>Square Feet</th>
                        <th>Square Meters</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Parking space</td><td>180 ft²</td><td>16.7 m²</td></tr>
                    <tr><td>Swimming pool (small)</td><td>300-500 ft²</td><td>28-46 m²</td></tr>
                    <tr><td>Basketball court</td><td>4,700 ft²</td><td>437 m²</td></tr>
                    <tr><td>Soccer field</td><td>64,000-81,000 ft²</td><td>5,945-7,525 m²</td></tr>
                    <tr><td>Football field</td><td>57,600 ft²</td><td>5,351 m²</td></tr>
                </tbody>
            </table>

            <h3>🏛️ Historical Context</h3>
            <p>The <strong>square foot</strong> is derived from the foot, an ancient unit based on human body measurements. The <strong>square meter</strong> is part of the metric system established in France in 1795. One square meter is the area of a square with sides of one meter (approximately 3.28 feet).</p>

            <h3>📏 Conversion Tips</h3>
            <ul>
                <li><strong>For linear to area:</strong> Square both measurements first</li>
                <li><strong>Example:</strong> 10 ft × 10 ft = 100 ft² = 9.29 m²</li>
                <li><strong>Not:</strong> 10 ft = 3.05 m, so 3.05 × 3.05 = 9.3 m² ✓</li>
                <li><strong>Remember:</strong> 1 ft² ≠ (1 ft)² in conversions</li>
            </ul>

            <h3>🔑 Key Conversions</h3>
            <ul>
                <li><strong>1 ft² = 0.092903 m²</strong> (exact)</li>
                <li><strong>1 m² = 10.7639 ft²</strong></li>
                <li><strong>100 ft² ≈ 9.3 m²</strong></li>
                <li><strong>1,000 ft² ≈ 93 m²</strong></li>
                <li><strong>1 acre = 43,560 ft² = 4,047 m²</strong></li>
                <li><strong>Quick rule:</strong> Divide ft² by 10.76 to get m²</li>
            </ul>
        </div>

        <div class="footer">
            <p>🏠 Accurate Square Feet ⇄ Square Meter Conversion</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for real estate, construction, floor plans, and property measurements</p>
        </div>
    </div>

    <script>
        const SQM_PER_SQFT = 0.092903;

        function convertSqFt() {
            const sqft = parseFloat(document.getElementById('sqftInput').value);
            
            if (isNaN(sqft) || sqft < 0) {
                return;
            }

            const sqm = sqft * SQM_PER_SQFT;
            document.getElementById('sqmInput').value = sqm.toFixed(2);
            
            document.getElementById('resultValue').textContent = 
                `${sqft.toLocaleString('en-US', {maximumFractionDigits: 0})} ft² = ${sqm.toFixed(2)} m²`;
            
            document.getElementById('resultFormula').textContent = 
                `${sqft.toLocaleString('en-US', {maximumFractionDigits: 2})} sq ft × ${SQM_PER_SQFT} = ${sqm.toFixed(2)} m²`;
        }

        function convertSqM() {
            const sqm = parseFloat(document.getElementById('sqmInput').value);
            
            if (isNaN(sqm) || sqm < 0) {
                return;
            }

            const sqft = sqm / SQM_PER_SQFT;
            document.getElementById('sqftInput').value = sqft.toFixed(2);
            
            document.getElementById('resultValue').textContent = 
                `${sqm.toFixed(2)} m² = ${sqft.toLocaleString('en-US', {maximumFractionDigits: 0})} ft²`;
            
            document.getElementById('resultFormula').textContent = 
                `${sqm.toFixed(2)} m² ÷ ${SQM_PER_SQFT} = ${sqft.toFixed(2)} sq ft`;
        }

        function swapUnits() {
            const sqftValue = document.getElementById('sqftInput').value;
            const sqmValue = document.getElementById('sqmInput').value;
            
            document.getElementById('sqftInput').value = sqmValue;
            document.getElementById('sqmInput').value = sqftValue;
            
            if (sqftValue) convertSqFt();
        }

        function setSqFt(value) {
            document.getElementById('sqftInput').value = value;
            convertSqFt();
        }

        // Auto-convert on input
        document.getElementById('sqftInput').addEventListener('input', convertSqFt);
        document.getElementById('sqmInput').addEventListener('input', convertSqM);

        // Initial conversion
        convertSqFt();
    </script>
</body>
</html>