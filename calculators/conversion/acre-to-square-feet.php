<?php
/**
 * Acre to Square Feet Converter
 * File: conversion/acre-to-square-feet.php
 * Description: Convert acres to square feet for land measurement
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acre to Square Feet Converter - Land Area Calculator</title>
    <meta name="description" content="Convert acres to square feet instantly. Accurate land area conversion calculator with formulas and reverse conversion.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 900px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-group { margin-bottom: 25px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 80px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #3498db; box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #7f8c8d; font-weight: 600; font-size: 0.9rem; }
        
        .convert-btn { width: 100%; padding: 16px; background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-bottom: 20px; }
        .convert-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4); }
        
        .result-box { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #3498db; margin-bottom: 25px; display: none; }
        .result-box.show { display: block; animation: slideIn 0.4s ease; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2rem; font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .result-formula { background: white; padding: 15px; border-radius: 8px; margin-top: 15px; font-family: 'Courier New', monospace; color: #555; font-size: 0.9rem; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #3498db; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(52, 152, 219, 0.15); }
        .quick-value { font-weight: bold; color: #3498db; font-size: 1.1rem; }
        .quick-label { font-size: 0.85rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .formula-box { background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #3498db; }
        .formula-box strong { color: #2c3e50; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #f8f9fa; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @keyframes slideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 1.5rem; }
            .result-value { font-size: 1.6rem; }
            .quick-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌾 Acre to Square Feet Converter</h1>
            <p>Convert acres to square feet instantly for land measurement, real estate, and agriculture</p>
        </div>

        <div class="converter-card">
            <div class="input-group">
                <label for="acresInput">Enter Area in Acres</label>
                <div class="input-wrapper">
                    <input type="number" id="acresInput" placeholder="Enter acres" step="0.01" min="0" value="1">
                    <span class="unit-label">acres</span>
                </div>
            </div>

            <button class="convert-btn" onclick="convertAcres()">🔄 Convert to Square Feet</button>

            <div class="result-box" id="resultBox">
                <div class="result-label">Square Feet</div>
                <div class="result-value" id="resultValue">43,560 sq ft</div>
                <div class="result-formula" id="resultFormula">1 acre × 43,560 = 43,560 sq ft</div>
            </div>

            <div class="quick-convert">
                <h3>⚡ Quick Conversions</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setAcres(0.25)">
                        <div class="quick-value">0.25</div>
                        <div class="quick-label">Quarter Acre</div>
                    </div>
                    <div class="quick-btn" onclick="setAcres(0.5)">
                        <div class="quick-value">0.5</div>
                        <div class="quick-label">Half Acre</div>
                    </div>
                    <div class="quick-btn" onclick="setAcres(1)">
                        <div class="quick-value">1</div>
                        <div class="quick-label">1 Acre</div>
                    </div>
                    <div class="quick-btn" onclick="setAcres(2)">
                        <div class="quick-value">2</div>
                        <div class="quick-label">2 Acres</div>
                    </div>
                    <div class="quick-btn" onclick="setAcres(5)">
                        <div class="quick-value">5</div>
                        <div class="quick-label">5 Acres</div>
                    </div>
                    <div class="quick-btn" onclick="setAcres(10)">
                        <div class="quick-value">10</div>
                        <div class="quick-label">10 Acres</div>
                    </div>
                </div>
            </div>

            <!-- Reverse Conversion -->
            <div class="input-group" style="margin-top: 30px; padding-top: 30px; border-top: 2px solid #f0f0f0;">
                <label for="sqftInput">Reverse: Square Feet to Acres</label>
                <div class="input-wrapper">
                    <input type="number" id="sqftInput" placeholder="Enter square feet" step="1" min="0">
                    <span class="unit-label">sq ft</span>
                </div>
            </div>

            <button class="convert-btn" onclick="convertSqFt()" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%);">
                🔄 Convert to Acres
            </button>

            <div class="result-box" id="reverseResultBox">
                <div class="result-label">Acres</div>
                <div class="result-value" id="reverseResultValue">0 acres</div>
                <div class="result-formula" id="reverseResultFormula">0 sq ft ÷ 43,560 = 0 acres</div>
            </div>
        </div>

        <div class="info-section">
            <h2>📏 Understanding Acre to Square Feet Conversion</h2>
            
            <p>An <strong>acre</strong> is a unit of land area used primarily in the United States and UK. One acre equals exactly <strong>43,560 square feet</strong>. This conversion is fundamental for real estate, agriculture, land surveying, and property measurement.</p>

            <div class="formula-box">
                <strong>Conversion Formula:</strong><br>
                Square Feet = Acres × 43,560<br>
                Acres = Square Feet ÷ 43,560
            </div>

            <h3>🔢 Common Acre Conversions</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Acres</th>
                        <th>Square Feet</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>0.25</td>
                        <td>10,890 sq ft</td>
                        <td>Quarter acre (typical suburban lot)</td>
                    </tr>
                    <tr>
                        <td>0.5</td>
                        <td>21,780 sq ft</td>
                        <td>Half acre</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>43,560 sq ft</td>
                        <td>One acre (208.71 ft × 208.71 ft)</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>87,120 sq ft</td>
                        <td>Two acres</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>217,800 sq ft</td>
                        <td>Five acres (small farm)</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>435,600 sq ft</td>
                        <td>Ten acres</td>
                    </tr>
                </tbody>
            </table>

            <h3>📐 What is an Acre?</h3>
            <ul>
                <li><strong>Definition:</strong> 43,560 square feet or 4,840 square yards</li>
                <li><strong>Dimensions:</strong> Approximately 208.71 feet × 208.71 feet (square)</li>
                <li><strong>Origin:</strong> Historically, the amount of land tillable by one man behind one ox in one day</li>
                <li><strong>Modern use:</strong> Standard unit for land measurement in US real estate and agriculture</li>
                <li><strong>Visualization:</strong> About 75% of an American football field (without end zones)</li>
            </ul>

            <h3>🏡 Common Uses</h3>
            <ul>
                <li><strong>Real Estate:</strong> Property listings, lot sizes, land parcels</li>
                <li><strong>Agriculture:</strong> Farm land measurement, crop planning</li>
                <li><strong>Construction:</strong> Building site planning, development projects</li>
                <li><strong>Zoning:</strong> Minimum lot size requirements, density calculations</li>
                <li><strong>Land Surveying:</strong> Property boundaries, legal descriptions</li>
            </ul>

            <h3>🌍 Related Conversions</h3>
            <ul>
                <li>1 acre = 43,560 square feet</li>
                <li>1 acre = 4,840 square yards</li>
                <li>1 acre = 4,047 square meters</li>
                <li>1 acre = 0.4047 hectares</li>
                <li>1 acre = 0.001563 square miles</li>
                <li>1 acre = 160 square rods</li>
            </ul>

            <h3>💡 Practical Examples</h3>
            <ul>
                <li><strong>Small residential lot:</strong> 0.25 acres = 10,890 sq ft (typical suburban)</li>
                <li><strong>Large residential lot:</strong> 0.5 acres = 21,780 sq ft (spacious property)</li>
                <li><strong>Country home:</strong> 2 acres = 87,120 sq ft (room for gardens, outbuildings)</li>
                <li><strong>Small farm:</strong> 10 acres = 435,600 sq ft (hobby farm or ranch)</li>
                <li><strong>Football field:</strong> 1.32 acres = 57,600 sq ft (including end zones)</li>
            </ul>

            <h3>🎯 Quick Reference</h3>
            <div class="formula-box">
                <strong>Remember:</strong><br>
                • 1 acre = 43,560 sq ft (the key conversion factor)<br>
                • 1 square foot = 0.0000229568 acres<br>
                • To convert acres to sq ft: multiply by 43,560<br>
                • To convert sq ft to acres: divide by 43,560
            </div>

            <h3>📊 Acre Size Comparisons</h3>
            <ul>
                <li>1 acre ≈ 0.75 football fields (without end zones)</li>
                <li>1 acre ≈ 16 tennis courts</li>
                <li>1 acre ≈ 208.71 ft × 208.71 ft square</li>
                <li>1 acre ≈ 660 ft × 66 ft rectangle (1 furlong × 1 chain)</li>
                <li>1 acre ≈ Walking perimeter of about 835 feet</li>
            </ul>
        </div>

        <div class="footer">
            <p>🌾 Accurate Acre to Square Feet Conversion | Perfect for Land Measurement</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Real estate, agriculture, and surveying calculations</p>
        </div>
    </div>

    <script>
        function convertAcres() {
            const acres = parseFloat(document.getElementById('acresInput').value);
            const resultBox = document.getElementById('resultBox');
            
            if (isNaN(acres) || acres < 0) {
                alert('Please enter a valid positive number for acres');
                return;
            }

            const sqft = acres * 43560;
            
            document.getElementById('resultValue').textContent = sqft.toLocaleString('en-US', {maximumFractionDigits: 2}) + ' sq ft';
            document.getElementById('resultFormula').textContent = `${acres.toLocaleString()} acre${acres !== 1 ? 's' : ''} × 43,560 = ${sqft.toLocaleString('en-US', {maximumFractionDigits: 2})} sq ft`;
            
            resultBox.classList.add('show');
        }

        function convertSqFt() {
            const sqft = parseFloat(document.getElementById('sqftInput').value);
            const resultBox = document.getElementById('reverseResultBox');
            
            if (isNaN(sqft) || sqft < 0) {
                alert('Please enter a valid positive number for square feet');
                return;
            }

            const acres = sqft / 43560;
            
            document.getElementById('reverseResultValue').textContent = acres.toLocaleString('en-US', {maximumFractionDigits: 4}) + ' acres';
            document.getElementById('reverseResultFormula').textContent = `${sqft.toLocaleString()} sq ft ÷ 43,560 = ${acres.toLocaleString('en-US', {maximumFractionDigits: 4})} acres`;
            
            resultBox.classList.add('show');
        }

        function setAcres(value) {
            document.getElementById('acresInput').value = value;
            convertAcres();
        }

        // Auto-convert on input
        document.getElementById('acresInput').addEventListener('input', function() {
            if (this.value) convertAcres();
        });

        document.getElementById('sqftInput').addEventListener('input', function() {
            if (this.value) convertSqFt();
        });

        // Initial conversion
        convertAcres();
    </script>
</body>
</html>