<?php
/**
 * Hectare Converter
 * File: conversion/hectare-converter.php
 * Description: Convert hectares to acres, square meters, square feet, and other area units
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hectare Converter - ha to Acres, m², ft² Calculator</title>
    <meta name="description" content="Convert hectares to acres, square meters, square feet, and all area units instantly. Free land area converter for real estate and agriculture.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #38ef7d; box-shadow: 0 0 0 3px rgba(56, 239, 125, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; }
        .unit-select:focus { outline: none; border-color: #38ef7d; box-shadow: 0 0 0 3px rgba(56, 239, 125, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #38ef7d; }
        .result-unit { color: #2c5f2d; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #1b5e20; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #38ef7d; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(56, 239, 125, 0.15); }
        .quick-value { font-weight: bold; color: #11998e; font-size: 1rem; }
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
        
        .formula-box { background: #e8f5e9; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #38ef7d; }
        .formula-box strong { color: #11998e; }
        
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
            <h1>🌾 Hectare Converter</h1>
            <p>Convert hectares to acres, square meters, square feet, and all area units instantly</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select" style="margin-top: 10px;">
                        <option value="ha" selected>Hectare (ha)</option>
                        <option value="acre">Acre</option>
                        <option value="sqm">Square Meter (m²)</option>
                        <option value="sqkm">Square Kilometer (km²)</option>
                        <option value="sqft">Square Foot (ft²)</option>
                        <option value="sqyd">Square Yard (yd²)</option>
                        <option value="sqmi">Square Mile (mi²)</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="ha">Hectare (ha)</option>
                        <option value="acre" selected>Acre</option>
                        <option value="sqm">Square Meter (m²)</option>
                        <option value="sqkm">Square Kilometer (km²)</option>
                        <option value="sqft">Square Foot (ft²)</option>
                        <option value="sqyd">Square Yard (yd²)</option>
                        <option value="sqmi">Square Mile (mi²)</option>
                    </select>
                    <div class="input-wrapper" style="margin-top: 10px;">
                        <input type="text" id="outputValue" placeholder="Result" readonly style="background: #f8f9fa; font-weight: 600; color: #2c3e50;">
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid"></div>

            <div class="quick-convert">
                <h3>🌾 Common Land Sizes</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setInputValue(0.5)">
                        <div class="quick-value">0.5 ha</div>
                        <div class="quick-label">Small Plot</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(1)">
                        <div class="quick-value">1 ha</div>
                        <div class="quick-label">One Hectare</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(10)">
                        <div class="quick-value">10 ha</div>
                        <div class="quick-label">Small Farm</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(100)">
                        <div class="quick-value">100 ha</div>
                        <div class="quick-label">Large Farm</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🌾 Hectare Conversion Guide</h2>
            
            <p>A <strong>hectare (ha)</strong> is a metric unit of area commonly used for land measurement, especially in agriculture, forestry, and real estate.</p>

            <h3>📊 Conversion Factors to Hectares</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Equals (in Hectares)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Hectare</td><td>ha</td><td>1</td></tr>
                    <tr><td>Acre</td><td>ac</td><td>0.404686</td></tr>
                    <tr><td>Square Meter</td><td>m²</td><td>0.0001</td></tr>
                    <tr><td>Square Kilometer</td><td>km²</td><td>100</td></tr>
                    <tr><td>Square Foot</td><td>ft²</td><td>0.0000092903</td></tr>
                    <tr><td>Square Yard</td><td>yd²</td><td>0.000083613</td></tr>
                    <tr><td>Square Mile</td><td>mi²</td><td>259</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • 1 hectare = 10,000 m²<br>
                • 1 hectare = 2.471 acres<br>
                • 1 hectare = 107,639 ft²<br>
                • 1 hectare = 0.01 km²<br>
                • 1 acre = 0.4047 hectares<br>
                • 1 km² = 100 hectares
            </div>

            <h3>📏 Hectare to Acre Conversion Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Hectares (ha)</th>
                        <th>Acres</th>
                        <th>Square Meters (m²)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>0.1 ha</td><td>0.247 acres</td><td>1,000 m²</td></tr>
                    <tr><td>0.5 ha</td><td>1.235 acres</td><td>5,000 m²</td></tr>
                    <tr><td>1 ha</td><td>2.471 acres</td><td>10,000 m²</td></tr>
                    <tr><td>2 ha</td><td>4.942 acres</td><td>20,000 m²</td></tr>
                    <tr><td>5 ha</td><td>12.355 acres</td><td>50,000 m²</td></tr>
                    <tr><td>10 ha</td><td>24.711 acres</td><td>100,000 m²</td></tr>
                    <tr><td>50 ha</td><td>123.55 acres</td><td>500,000 m²</td></tr>
                    <tr><td>100 ha</td><td>247.11 acres</td><td>1,000,000 m²</td></tr>
                </tbody>
            </table>

            <h3>🏡 Real Estate & Property</h3>
            <ul>
                <li><strong>Residential lot:</strong> 0.04-0.1 ha (0.1-0.25 acres)</li>
                <li><strong>Large house lot:</strong> 0.2-0.5 ha (0.5-1.2 acres)</li>
                <li><strong>Small estate:</strong> 1-2 ha (2.5-5 acres)</li>
                <li><strong>Large estate:</strong> 5-10 ha (12-25 acres)</li>
                <li><strong>Golf course:</strong> 50-100 ha (120-250 acres)</li>
            </ul>

            <h3>🌱 Agricultural Land</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Farm Type</th>
                        <th>Typical Size</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Small hobby farm</td><td>2-10 hectares</td></tr>
                    <tr><td>Medium farm</td><td>50-100 hectares</td></tr>
                    <tr><td>Large farm</td><td>200-500 hectares</td></tr>
                    <tr><td>Commercial farm</td><td>500-2,000 hectares</td></tr>
                    <tr><td>Mega farm</td><td>5,000+ hectares</td></tr>
                </tbody>
            </table>

            <h3>⚽ Sports Fields</h3>
            <div class="formula-box">
                <strong>Field Sizes:</strong><br>
                • Soccer field: 0.7-1 hectare<br>
                • American football field: 0.53 hectares<br>
                • Cricket field: 1.2-2 hectares<br>
                • Baseball field: 0.8-1 hectare<br>
                • Rugby field: 1 hectare
            </div>

            <h3>🌳 Forestry & Conservation</h3>
            <ul>
                <li><strong>Small woodlot:</strong> 5-20 hectares</li>
                <li><strong>Forest plot:</strong> 50-100 hectares</li>
                <li><strong>Large forest:</strong> 500-5,000 hectares</li>
                <li><strong>National park:</strong> 10,000-100,000+ hectares</li>
                <li><strong>Trees per hectare:</strong> 400-1,000 (depending on species)</li>
            </ul>

            <h3>🏙️ Urban Planning</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Urban Feature</th>
                        <th>Typical Size</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>City block</td><td>0.4-1 hectare</td></tr>
                    <tr><td>Shopping center</td><td>2-10 hectares</td></tr>
                    <tr><td>City park</td><td>5-50 hectares</td></tr>
                    <tr><td>University campus</td><td>50-200 hectares</td></tr>
                    <tr><td>Airport</td><td>500-5,000 hectares</td></tr>
                </tbody>
            </table>

            <h3>🌍 Famous Land Areas</h3>
            <ul>
                <li><strong>Vatican City:</strong> 44 hectares (109 acres)</li>
                <li><strong>Monaco:</strong> 202 hectares (499 acres)</li>
                <li><strong>Central Park (NYC):</strong> 341 hectares (843 acres)</li>
                <li><strong>Golden Gate Park (SF):</strong> 412 hectares (1,017 acres)</li>
                <li><strong>Hyde Park (London):</strong> 142 hectares (350 acres)</li>
            </ul>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>Hectares to Acres:</strong><br>
                • Multiply hectares by 2.5 for rough acres<br>
                • Example: 10 ha × 2.5 ≈ 25 acres<br>
                • Actual: 10 ha = 24.71 acres (close!)<br><br>
                <strong>Acres to Hectares:</strong><br>
                • Divide acres by 2.5 for rough hectares<br>
                • Example: 50 acres ÷ 2.5 = 20 ha<br>
                • Actual: 50 acres = 20.23 ha (very close!)
            </div>

            <h3>📐 Visual Size Comparisons</h3>
            <ul>
                <li><strong>1 hectare:</strong> 100m × 100m square</li>
                <li><strong>1 hectare:</strong> About 2.5 soccer fields</li>
                <li><strong>1 hectare:</strong> Roughly 2 American football fields</li>
                <li><strong>10 hectares:</strong> Size of ~18 soccer fields</li>
                <li><strong>100 hectares:</strong> 1 km²</li>
            </ul>

            <h3>🏗️ Construction & Development</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Development Type</th>
                        <th>Land Required</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Single house</td><td>0.04-0.1 hectare</td></tr>
                    <tr><td>Housing subdivision (20 homes)</td><td>2-5 hectares</td></tr>
                    <tr><td>Apartment complex</td><td>1-5 hectares</td></tr>
                    <tr><td>Industrial park</td><td>20-100 hectares</td></tr>
                    <tr><td>New town</td><td>500-5,000 hectares</td></tr>
                </tbody>
            </table>

            <h3>🌾 Crop Yields</h3>
            <div class="formula-box">
                <strong>Production per Hectare:</strong><br>
                • Wheat: 3-8 tonnes/ha<br>
                • Corn: 8-12 tonnes/ha<br>
                • Rice: 4-8 tonnes/ha<br>
                • Soybeans: 2-4 tonnes/ha<br>
                • Potatoes: 20-50 tonnes/ha<br>
                • Grapes (wine): 5-15 tonnes/ha
            </div>

            <h3>🌍 Global Land Use</h3>
            <ul>
                <li><strong>Total Earth land:</strong> 15 billion hectares</li>
                <li><strong>Agricultural land:</strong> 5 billion hectares</li>
                <li><strong>Forest land:</strong> 4 billion hectares</li>
                <li><strong>Urban areas:</strong> 300 million hectares</li>
                <li><strong>Protected areas:</strong> 2 billion hectares</li>
            </ul>

            <h3>📊 Country Comparisons</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Area (hectares)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Russia</td><td>1.7 billion ha</td></tr>
                    <tr><td>Canada</td><td>998 million ha</td></tr>
                    <tr><td>China</td><td>960 million ha</td></tr>
                    <tr><td>United States</td><td>983 million ha</td></tr>
                    <tr><td>Brazil</td><td>851 million ha</td></tr>
                    <tr><td>Australia</td><td>774 million ha</td></tr>
                </tbody>
            </table>

            <h3>🎯 Practical Examples</h3>
            <div class="formula-box">
                <strong>Real-World Sizes:</strong><br>
                • Walmart Supercenter: 2-4 hectares<br>
                • Small vineyard: 5-20 hectares<br>
                • Dairy farm: 50-200 hectares<br>
                • Ranch: 500-5,000 hectares<br>
                • Nature reserve: 1,000-100,000 hectares
            </div>

            <h3>🏛️ Historical Context</h3>
            <p>The hectare was introduced in 1795 with the metric system in France. The name comes from the Greek "hekaton" (hundred) and the Latin "area." One hectare equals 100 ares or 10,000 square meters. It's now the legal unit of land measurement in most countries, though acres remain common in the United States, UK, and other Commonwealth nations.</p>
        </div>

        <div class="footer">
            <p>🌾 Accurate Hectare Conversion | All Major Area Units</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for real estate, agriculture, forestry, and land planning</p>
        </div>
    </div>

    <script>
        // Conversion factors to square meters
        const conversionFactors = {
            ha: 10000,
            acre: 4046.86,
            sqm: 1,
            sqkm: 1000000,
            sqft: 0.092903,
            sqyd: 0.836127,
            sqmi: 2589988
        };

        const unitNames = {
            ha: 'Hectare (ha)',
            acre: 'Acre',
            sqm: 'Square Meter (m²)',
            sqkm: 'Square Kilometer (km²)',
            sqft: 'Square Foot (ft²)',
            sqyd: 'Square Yard (yd²)',
            sqmi: 'Square Mile (mi²)'
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

            const valueInSqM = inputValue * conversionFactors[fromUnit];
            const result = valueInSqM / conversionFactors[toUnit];

            document.getElementById('outputValue').value = formatNumber(result);
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
            if (Math.abs(num) < 0.000001 || Math.abs(num) > 1e12) {
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