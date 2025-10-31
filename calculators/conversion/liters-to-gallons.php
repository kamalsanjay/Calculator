<?php
/**
 * Liters to Gallons Converter
 * File: conversion/liters-to-gallons.php
 * Description: Convert liters to US/UK gallons and vice versa
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liters to Gallons Converter - L to Gal Calculator</title>
    <meta name="description" content="Convert liters to US gallons, UK gallons, and other volume units. Bidirectional liquid volume converter.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 70px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #43e97b; box-shadow: 0 0 0 3px rgba(67, 233, 123, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #43e97b; font-weight: 600; font-size: 0.95rem; }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; margin-top: 10px; }
        .unit-select:focus { outline: none; border-color: #43e97b; box-shadow: 0 0 0 3px rgba(67, 233, 123, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #43e97b; }
        .result-unit { color: #2e7d32; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #388e3c; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #43e97b; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(67, 233, 123, 0.15); }
        .quick-value { font-weight: bold; color: #43e97b; font-size: 1rem; }
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
        
        .formula-box { background: #e8f5e9; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #43e97b; }
        .formula-box strong { color: #43e97b; }
        
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
            <h1>💧 Liters ⇄ Gallons Converter</h1>
            <p>Convert between liters, US gallons, UK gallons, and other volume units</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="0.01" min="0" value="10">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="L" selected>Liter (L)</option>
                        <option value="mL">Milliliter (mL)</option>
                        <option value="gal_us">US Gallon</option>
                        <option value="gal_uk">UK Gallon</option>
                        <option value="qt_us">US Quart</option>
                        <option value="pt_us">US Pint</option>
                        <option value="cup_us">US Cup</option>
                        <option value="fl_oz_us">US Fluid Ounce</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="L">Liter (L)</option>
                        <option value="mL">Milliliter (mL)</option>
                        <option value="gal_us" selected>US Gallon</option>
                        <option value="gal_uk">UK Gallon</option>
                        <option value="qt_us">US Quart</option>
                        <option value="pt_us">US Pint</option>
                        <option value="cup_us">US Cup</option>
                        <option value="fl_oz_us">US Fluid Ounce</option>
                    </select>
                    <div class="input-wrapper" style="margin-top: 10px;">
                        <input type="text" id="outputValue" placeholder="Result" readonly style="background: #f8f9fa; font-weight: 600; color: #2c3e50;">
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid"></div>

            <div class="quick-convert">
                <h3>💧 Common Volumes</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setInput(1)">
                        <div class="quick-value">1 L</div>
                        <div class="quick-label">Water Bottle</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(5)">
                        <div class="quick-value">5 L</div>
                        <div class="quick-label">Large Bottle</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(10)">
                        <div class="quick-value">10 L</div>
                        <div class="quick-label">Bucket</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(50)">
                        <div class="quick-value">50 L</div>
                        <div class="quick-label">Tank</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(100)">
                        <div class="quick-value">100 L</div>
                        <div class="quick-label">Large Tank</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>💧 Liters to Gallons Conversion</h2>
            
            <p>The <strong>liter (L)</strong> is the metric unit of volume, while <strong>gallons</strong> are used primarily in the US and UK with different sizes.</p>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>Liters to US Gallons:</strong><br>
                • US Gallons = Liters ÷ 3.78541<br>
                • 1 liter = 0.264172 US gallons<br><br>
                <strong>Liters to UK Gallons:</strong><br>
                • UK Gallons = Liters ÷ 4.54609<br>
                • 1 liter = 0.219969 UK gallons<br><br>
                <strong>Key Difference:</strong><br>
                • 1 US gallon = 3.78541 liters<br>
                • 1 UK (Imperial) gallon = 4.54609 liters
            </div>

            <h3>📊 Volume Comparison Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Liters</th>
                        <th>US Gallons</th>
                        <th>UK Gallons</th>
                        <th>Milliliters</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 L</td><td>0.264 gal</td><td>0.220 gal</td><td>1,000 mL</td></tr>
                    <tr><td>5 L</td><td>1.321 gal</td><td>1.100 gal</td><td>5,000 mL</td></tr>
                    <tr><td>10 L</td><td>2.642 gal</td><td>2.200 gal</td><td>10,000 mL</td></tr>
                    <tr><td>20 L</td><td>5.283 gal</td><td>4.399 gal</td><td>20,000 mL</td></tr>
                    <tr><td>50 L</td><td>13.209 gal</td><td>10.998 gal</td><td>50,000 mL</td></tr>
                    <tr><td>100 L</td><td>26.417 gal</td><td>21.997 gal</td><td>100,000 mL</td></tr>
                </tbody>
            </table>

            <h3>🥤 Common Container Sizes</h3>
            <ul>
                <li><strong>Water bottle:</strong> 500 mL = 0.5 L = 0.13 US gal</li>
                <li><strong>Large water bottle:</strong> 1 L = 0.26 US gal = 0.22 UK gal</li>
                <li><strong>Milk jug (US):</strong> 1 US gallon = 3.79 L</li>
                <li><strong>Milk bottle (UK):</strong> 2 pints = 1.14 L</li>
                <li><strong>Soda bottle:</strong> 2 L = 0.53 US gal</li>
                <li><strong>Wine bottle:</strong> 750 mL = 0.75 L</li>
            </ul>

            <h3>⛽ Fuel & Gas</h3>
            <div class="formula-box">
                <strong>Fuel Tank Sizes:</strong><br>
                • Compact car: 45-50 L (12-13 US gal)<br>
                • Sedan: 55-70 L (15-18 US gal)<br>
                • SUV: 75-100 L (20-26 US gal)<br>
                • Pickup truck: 80-136 L (21-36 US gal)<br>
                • Motorcycle: 12-20 L (3-5 US gal)<br>
                • Semi-truck: 300-600 L (80-160 US gal)
            </div>

            <h3>🏠 Household Appliances</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Appliance</th>
                        <th>Capacity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Washing machine</td><td>40-70 L (10-18 US gal)</td></tr>
                    <tr><td>Dishwasher</td><td>10-15 L per cycle (2.6-4 US gal)</td></tr>
                    <tr><td>Water heater (small)</td><td>40-80 L (10-21 US gal)</td></tr>
                    <tr><td>Water heater (large)</td><td>150-300 L (40-80 US gal)</td></tr>
                    <tr><td>Bathtub</td><td>150-300 L (40-80 US gal)</td></tr>
                    <tr><td>Hot tub</td><td>1,000-2,000 L (265-530 US gal)</td></tr>
                </tbody>
            </table>

            <h3>🍺 Beverage Industry</h3>
            <ul>
                <li><strong>Beer keg (half barrel):</strong> 58.67 L (15.5 US gal)</li>
                <li><strong>Quarter barrel:</strong> 29.34 L (7.75 US gal)</li>
                <li><strong>Pint (US):</strong> 473 mL = 0.473 L</li>
                <li><strong>Pint (UK):</strong> 568 mL = 0.568 L</li>
                <li><strong>Standard drink:</strong> 355 mL can, 473 mL pint</li>
            </ul>

            <h3>🌊 Swimming Pools</h3>
            <div class="formula-box">
                <strong>Pool Volumes:</strong><br>
                • Kiddie pool: 200-500 L (50-130 US gal)<br>
                • Above-ground pool: 10,000-20,000 L (2,600-5,300 US gal)<br>
                • Small in-ground: 40,000-60,000 L (10,500-16,000 US gal)<br>
                • Large in-ground: 80,000-150,000 L (21,000-40,000 US gal)<br>
                • Olympic pool: 2,500,000 L (660,000 US gal)
            </div>

            <h3>🚿 Water Usage</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Water Used</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Shower (10 min)</td><td>75-150 L (20-40 US gal)</td></tr>
                    <tr><td>Bath</td><td>150-300 L (40-80 US gal)</td></tr>
                    <tr><td>Toilet flush</td><td>6-13 L (1.6-3.5 US gal)</td></tr>
                    <tr><td>Dishwasher cycle</td><td>10-15 L (2.6-4 US gal)</td></tr>
                    <tr><td>Washing machine</td><td>40-150 L (10-40 US gal)</td></tr>
                    <tr><td>Garden hose (1 min)</td><td>10-20 L (2.6-5.3 US gal)</td></tr>
                </tbody>
            </table>

            <h3>🧪 Cooking & Baking</h3>
            <ul>
                <li><strong>Cup (US):</strong> 237 mL = 0.237 L</li>
                <li><strong>Cup (metric):</strong> 250 mL = 0.25 L</li>
                <li><strong>Tablespoon (US):</strong> 15 mL</li>
                <li><strong>Teaspoon (US):</strong> 5 mL</li>
                <li><strong>Fluid ounce (US):</strong> 29.57 mL</li>
                <li><strong>Quart (US):</strong> 946 mL = 0.946 L</li>
            </ul>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>Liters to US Gallons:</strong><br>
                • Divide liters by 4 for rough gallons<br>
                • Example: 20 L ÷ 4 = 5 gallons<br>
                • Actual: 20 L = 5.28 US gal (close!)<br><br>
                <strong>US Gallons to Liters:</strong><br>
                • Multiply gallons by 4 for rough liters<br>
                • Example: 10 gal × 4 = 40 L<br>
                • Actual: 10 US gal = 37.85 L (close!)
            </div>

            <h3>🌍 Regional Usage</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Region</th>
                        <th>Primary Unit</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>United States</td><td>US Gallon</td><td>3.785 liters</td></tr>
                    <tr><td>United Kingdom</td><td>Liter (fuel)</td><td>UK gallon for older contexts</td></tr>
                    <tr><td>Canada</td><td>Liter</td><td>Metric system</td></tr>
                    <tr><td>Europe</td><td>Liter</td><td>Metric standard</td></tr>
                    <tr><td>Australia</td><td>Liter</td><td>Metric system</td></tr>
                </tbody>
            </table>

            <h3>⚗️ Scientific & Medical</h3>
            <ul>
                <li><strong>IV bag:</strong> 500 mL or 1 L</li>
                <li><strong>Blood donation:</strong> 450-500 mL</li>
                <li><strong>Laboratory flask:</strong> 100 mL, 250 mL, 500 mL, 1 L</li>
                <li><strong>Beaker sizes:</strong> 50 mL to 5 L</li>
                <li><strong>Medicine dose:</strong> Usually in mL</li>
            </ul>

            <h3>🚰 Bottled Water Industry</h3>
            <div class="formula-box">
                <strong>Standard Bottle Sizes:</strong><br>
                • Mini: 200-330 mL<br>
                • Standard: 500 mL (16.9 fl oz)<br>
                • Large: 1 L (33.8 fl oz)<br>
                • Extra large: 1.5 L<br>
                • Family size: 2-5 L<br>
                • Water cooler bottle: 18-20 L (5 US gal)
            </div>

            <h3>🎯 Practical Examples</h3>
            <ul>
                <li><strong>Fill a car tank:</strong> 50 L = 13.2 US gal</li>
                <li><strong>Drink recommendation:</strong> 2-3 L per day</li>
                <li><strong>Aquarium (small):</strong> 40 L = 10.6 US gal</li>
                <li><strong>Aquarium (large):</strong> 200 L = 52.8 US gal</li>
                <li><strong>Paint can:</strong> 3.78 L = 1 US gal</li>
            </ul>

            <h3>🏛️ Historical Context</h3>
            <p>The <strong>liter</strong> was introduced in France in 1795 as part of the metric system, originally defined as the volume of 1 kilogram of water. The <strong>gallon</strong> has ancient origins and varies by country - the US gallon is based on the wine gallon, while the UK imperial gallon is based on the volume of 10 pounds of water.</p>

            <h3>🔑 Key Conversions</h3>
            <ul>
                <li><strong>1 liter = 0.264172 US gallons</strong></li>
                <li><strong>1 liter = 0.219969 UK gallons</strong></li>
                <li><strong>1 US gallon = 3.78541 liters</strong></li>
                <li><strong>1 UK gallon = 4.54609 liters</strong></li>
                <li><strong>1 liter = 1,000 milliliters</strong></li>
                <li><strong>1 US gallon = 128 US fluid ounces</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>💧 Accurate Liters ⇄ Gallons Conversion | All Volume Units</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for fuel, cooking, water measurement, and everyday volume conversions</p>
        </div>
    </div>

    <script>
        // Conversion factors to liters
        const toLiters = {
            L: 1,
            mL: 0.001,
            gal_us: 3.78541,
            gal_uk: 4.54609,
            qt_us: 0.946353,
            pt_us: 0.473176,
            cup_us: 0.236588,
            fl_oz_us: 0.0295735
        };

        const unitNames = {
            L: 'Liter (L)',
            mL: 'Milliliter (mL)',
            gal_us: 'US Gallon',
            gal_uk: 'UK Gallon',
            qt_us: 'US Quart',
            pt_us: 'US Pint',
            cup_us: 'US Cup',
            fl_oz_us: 'US Fluid Ounce'
        };

        function convert() {
            const inputValue = parseFloat(document.getElementById('inputValue').value);
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;

            if (isNaN(inputValue)) {
                document.getElementById('outputValue').value = '';
                document.getElementById('resultGrid').innerHTML = '';
                return;
            }

            const valueInLiters = inputValue * toLiters[fromUnit];
            const result = valueInLiters / toLiters[toUnit];
            
            document.getElementById('outputValue').value = formatNumber(result);
            displayAllConversions(valueInLiters);
        }

        function displayAllConversions(valueInLiters) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInLiters / toLiters[unit];
                
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
            
            convert();
        }

        function setInput(value) {
            document.getElementById('inputValue').value = value;
            convert();
        }

        // Auto-convert on input
        document.getElementById('inputValue').addEventListener('input', convert);
        document.getElementById('fromUnit').addEventListener('change', convert);
        document.getElementById('toUnit').addEventListener('change', convert);

        // Initial conversion
        convert();
    </script>
</body>
</html>