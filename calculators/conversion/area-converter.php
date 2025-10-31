<?php
/**
 * Area Converter Calculator
 * File: conversion/area-converter.php
 * Description: Convert between all major area units
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Converter - Convert Area Units Online</title>
    <meta name="description" content="Convert between square feet, square meters, acres, hectares, and all area units instantly. Free online area converter calculator.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 30px; }
        
        .input-group { }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #3498db; box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; }
        .unit-select:focus { outline: none; border-color: #3498db; box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1); }
        
        .swap-btn { background: #3498db; color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); background: #2980b9; }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 30px; }
        .result-card { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #3498db; }
        .result-unit { color: #7f8c8d; font-size: 0.85rem; margin-bottom: 5px; }
        .result-value { font-size: 1.3rem; font-weight: bold; color: #2c3e50; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #3498db; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(52, 152, 219, 0.15); }
        .quick-value { font-weight: bold; color: #3498db; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 10px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #f8f9fa; }
        
        .formula-box { background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #3498db; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .converter-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .result-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>◼️ Area Converter</h1>
            <p>Convert between square feet, square meters, acres, hectares, and all area units instantly</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select" style="margin-top: 10px;">
                        <option value="sqm">Square Meter (m²)</option>
                        <option value="sqkm">Square Kilometer (km²)</option>
                        <option value="sqcm">Square Centimeter (cm²)</option>
                        <option value="sqmm">Square Millimeter (mm²)</option>
                        <option value="sqft" selected>Square Foot (ft²)</option>
                        <option value="sqyd">Square Yard (yd²)</option>
                        <option value="sqin">Square Inch (in²)</option>
                        <option value="sqmi">Square Mile (mi²)</option>
                        <option value="acre">Acre</option>
                        <option value="hectare">Hectare (ha)</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="sqm" selected>Square Meter (m²)</option>
                        <option value="sqkm">Square Kilometer (km²)</option>
                        <option value="sqcm">Square Centimeter (cm²)</option>
                        <option value="sqmm">Square Millimeter (mm²)</option>
                        <option value="sqft">Square Foot (ft²)</option>
                        <option value="sqyd">Square Yard (yd²)</option>
                        <option value="sqin">Square Inch (in²)</option>
                        <option value="sqmi">Square Mile (mi²)</option>
                        <option value="acre">Acre</option>
                        <option value="hectare">Hectare (ha)</option>
                    </select>
                    <div class="input-wrapper" style="margin-top: 10px;">
                        <input type="text" id="outputValue" placeholder="Result" readonly style="background: #f8f9fa; font-weight: 600; color: #2c3e50;">
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid"></div>

            <div class="quick-convert">
                <h3>⚡ Common Area Values</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setInputValue(1)">
                        <div class="quick-value">1</div>
                        <div class="quick-label">Unit</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(10)">
                        <div class="quick-value">10</div>
                        <div class="quick-label">Units</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(100)">
                        <div class="quick-value">100</div>
                        <div class="quick-label">Units</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(1000)">
                        <div class="quick-value">1,000</div>
                        <div class="quick-label">Units</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>📐 Area Conversion Guide</h2>
            
            <p><strong>Area</strong> measures the size of a two-dimensional surface. This converter supports all major area units used worldwide for real estate, construction, land measurement, and scientific applications.</p>

            <h3>🔢 Conversion Factors to Square Meters</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Equals (in m²)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Square Meter</td><td>m²</td><td>1</td></tr>
                    <tr><td>Square Kilometer</td><td>km²</td><td>1,000,000</td></tr>
                    <tr><td>Square Centimeter</td><td>cm²</td><td>0.0001</td></tr>
                    <tr><td>Square Millimeter</td><td>mm²</td><td>0.000001</td></tr>
                    <tr><td>Square Foot</td><td>ft²</td><td>0.092903</td></tr>
                    <tr><td>Square Yard</td><td>yd²</td><td>0.836127</td></tr>
                    <tr><td>Square Inch</td><td>in²</td><td>0.00064516</td></tr>
                    <tr><td>Square Mile</td><td>mi²</td><td>2,589,988</td></tr>
                    <tr><td>Acre</td><td>ac</td><td>4,046.86</td></tr>
                    <tr><td>Hectare</td><td>ha</td><td>10,000</td></tr>
                </tbody>
            </table>

            <h3>🏠 Common Area Conversions</h3>
            <div class="formula-box">
                <strong>Metric ↔ Imperial:</strong><br>
                • 1 m² = 10.764 ft²<br>
                • 1 ft² = 0.0929 m²<br>
                • 1 hectare = 2.471 acres<br>
                • 1 acre = 0.4047 hectares<br>
                • 1 km² = 0.386 mi²<br>
                • 1 mi² = 2.59 km²
            </div>

            <h3>📏 Metric Area Units</h3>
            <ul>
                <li><strong>Square Millimeter (mm²):</strong> 1/1,000,000 of a square meter</li>
                <li><strong>Square Centimeter (cm²):</strong> 1/10,000 of a square meter</li>
                <li><strong>Square Meter (m²):</strong> Base SI unit for area</li>
                <li><strong>Hectare (ha):</strong> 10,000 m² (100m × 100m)</li>
                <li><strong>Square Kilometer (km²):</strong> 1,000,000 m² (1,000m × 1,000m)</li>
            </ul>

            <h3>🇺🇸 Imperial/US Area Units</h3>
            <ul>
                <li><strong>Square Inch (in²):</strong> Area of 1" × 1" square</li>
                <li><strong>Square Foot (ft²):</strong> Area of 1 ft × 1 ft square</li>
                <li><strong>Square Yard (yd²):</strong> 9 square feet (3 ft × 3 ft)</li>
                <li><strong>Acre:</strong> 43,560 square feet (used for land)</li>
                <li><strong>Square Mile (mi²):</strong> 640 acres or 27,878,400 ft²</li>
            </ul>

            <h3>🌍 Real-World Examples</h3>
            <ul>
                <li><strong>Studio apartment:</strong> ~30-40 m² (323-430 ft²)</li>
                <li><strong>Small house:</strong> ~100-150 m² (1,076-1,614 ft²)</li>
                <li><strong>Tennis court:</strong> ~260 m² (2,800 ft²)</li>
                <li><strong>American football field:</strong> ~5,350 m² (1.32 acres)</li>
                <li><strong>City block:</strong> ~2-5 hectares (5-12 acres)</li>
                <li><strong>Central Park (NYC):</strong> ~341 hectares (843 acres)</li>
            </ul>

            <h3>💡 Usage Tips</h3>
            <ul>
                <li><strong>Real Estate:</strong> Use ft² or m² for rooms/apartments, acres for land</li>
                <li><strong>Construction:</strong> Plans typically in ft² (US) or m² (international)</li>
                <li><strong>Agriculture:</strong> Fields measured in acres (US) or hectares (metric)</li>
                <li><strong>Geography:</strong> Countries/regions measured in km² or mi²</li>
                <li><strong>Small items:</strong> Use cm² or in² for precision</li>
            </ul>

            <h3>🎯 Quick Reference</h3>
            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • 1 acre = 43,560 ft² = 4,047 m²<br>
                • 1 hectare = 10,000 m² = 2.471 acres<br>
                • 1 ft² = 144 in² = 929 cm²<br>
                • 1 m² = 10.764 ft² = 10,000 cm²<br>
                • 1 km² = 100 hectares = 247 acres
            </div>
        </div>

        <div class="footer">
            <p>◼️ Accurate Area Conversion | All Major Units Supported</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Real estate, construction, and land measurement calculations</p>
        </div>
    </div>

    <script>
        // Conversion factors to square meters
        const conversionFactors = {
            sqm: 1,
            sqkm: 1000000,
            sqcm: 0.0001,
            sqmm: 0.000001,
            sqft: 0.09290304,
            sqyd: 0.83612736,
            sqin: 0.00064516,
            sqmi: 2589988.110336,
            acre: 4046.8564224,
            hectare: 10000
        };

        const unitNames = {
            sqm: 'Square Meter (m²)',
            sqkm: 'Square Kilometer (km²)',
            sqcm: 'Square Centimeter (cm²)',
            sqmm: 'Square Millimeter (mm²)',
            sqft: 'Square Foot (ft²)',
            sqyd: 'Square Yard (yd²)',
            sqin: 'Square Inch (in²)',
            sqmi: 'Square Mile (mi²)',
            acre: 'Acre',
            hectare: 'Hectare (ha)'
        };

        function convertArea() {
            const inputValue = parseFloat(document.getElementById('inputValue').value);
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;

            if (isNaN(inputValue)) {
                document.getElementById('outputValue').value = '';
                document.getElementById('resultGrid').innerHTML = '';
                return;
            }

            // Convert to square meters first, then to target unit
            const valueInSqM = inputValue * conversionFactors[fromUnit];
            const result = valueInSqM / conversionFactors[toUnit];

            // Display main result
            document.getElementById('outputValue').value = formatNumber(result);

            // Display all conversions
            displayAllConversions(valueInSqM);
        }

        function displayAllConversions(valueInSqM) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInSqM / conversionFactors[unit];
                
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div class="result-unit">${name}</div>
                    <div class="result-value">${formatNumber(converted)}</div>
                `;
                resultGrid.appendChild(card);
            }
        }

        function formatNumber(num) {
            if (Math.abs(num) < 0.001 || Math.abs(num) > 1000000) {
                return num.toExponential(6);
            }
            return num.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 6
            });
        }

        function swapUnits() {
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;
            
            document.getElementById('fromUnit').value = toUnit;
            document.getElementById('toUnit').value = fromUnit;
            
            convertArea();
        }

        function setInputValue(value) {
            document.getElementById('inputValue').value = value;
            convertArea();
        }

        // Auto-convert on input
        document.getElementById('inputValue').addEventListener('input', convertArea);
        document.getElementById('fromUnit').addEventListener('change', convertArea);
        document.getElementById('toUnit').addEventListener('change', convertArea);

        // Initial conversion
        convertArea();
    </script>
</body>
</html>