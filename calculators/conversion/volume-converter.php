<?php
/**
 * Volume Converter
 * File: conversion/volume-converter.php
 * Description: Convert between volume units including liters, gallons, milliliters, cups, and more
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volume Converter - Liquid & Dry Volume Unit Conversion Calculator</title>
    <meta name="description" content="Convert between volume units: liters, gallons, milliliters, cups, cubic meters, and more. Essential for cooking, science, and industrial applications.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; margin-top: 10px; }
        .unit-select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #667eea; }
        .result-unit { color: #0984e3; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #00cec9; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #667eea; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15); }
        .quick-value { font-weight: bold; color: #667eea; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .common-volumes { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .common-volumes h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        
        .volume-scale { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .volume-scale-bar { height: 30px; background: linear-gradient(90deg, #4caf50, #ffeb3b, #ff9800, #f44336); border-radius: 15px; margin: 10px 0; position: relative; }
        .volume-scale-labels { display: flex; justify-content: space-between; font-size: 0.8rem; color: #555; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #a8edea; }
        
        .formula-box { background: #a8edea; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .cooking-box { background: #fff3e0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff9800; }
        
        .industrial-box { background: #f3e5f5; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #9c27b0; }
        
        .scientific-box { background: #e8f5e8; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #4caf50; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .volume-highlight { background: #e3f2fd; padding: 3px 6px; border-radius: 4px; font-weight: bold; }
        
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
            <h1>🧪 Volume Converter</h1>
            <p>Convert between volume units: liters, gallons, milliliters, cups, cubic meters, and more. Essential for cooking, science, and industrial applications.</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="liter" selected>Liter (L)</option>
                        <option value="ml">Milliliter (mL)</option>
                        <option value="gal_us">US Gallon (gal)</option>
                        <option value="gal_uk">UK Gallon (gal UK)</option>
                        <option value="cup_us">US Cup (cup)</option>
                        <option value="cup_uk">UK Cup (cup UK)</option>
                        <option value="pint_us">US Pint (pt)</option>
                        <option value="pint_uk">UK Pint (pt UK)</option>
                        <option value="quart_us">US Quart (qt)</option>
                        <option value="quart_uk">UK Quart (qt UK)</option>
                        <option value="floz_us">US Fluid Ounce (fl oz)</option>
                        <option value="floz_uk">UK Fluid Ounce (fl oz UK)</option>
                        <option value="tbsp">Tablespoon (tbsp)</option>
                        <option value="tsp">Teaspoon (tsp)</option>
                        <option value="cubic_m">Cubic Meter (m³)</option>
                        <option value="cubic_cm">Cubic Centimeter (cm³)</option>
                        <option value="cubic_in">Cubic Inch (in³)</option>
                        <option value="cubic_ft">Cubic Foot (ft³)</option>
                        <option value="cubic_yd">Cubic Yard (yd³)</option>
                        <option value="barrel">Barrel (oil)</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="liter">Liter (L)</option>
                        <option value="ml" selected>Milliliter (mL)</option>
                        <option value="gal_us">US Gallon (gal)</option>
                        <option value="gal_uk">UK Gallon (gal UK)</option>
                        <option value="cup_us">US Cup (cup)</option>
                        <option value="cup_uk">UK Cup (cup UK)</option>
                        <option value="pint_us">US Pint (pt)</option>
                        <option value="pint_uk">UK Pint (pt UK)</option>
                        <option value="quart_us">US Quart (qt)</option>
                        <option value="quart_uk">UK Quart (qt UK)</option>
                        <option value="floz_us">US Fluid Ounce (fl oz)</option>
                        <option value="floz_uk">UK Fluid Ounce (fl oz UK)</option>
                        <option value="tbsp">Tablespoon (tbsp)</option>
                        <option value="tsp">Teaspoon (tsp)</option>
                        <option value="cubic_m">Cubic Meter (m³)</option>
                        <option value="cubic_cm">Cubic Centimeter (cm³)</option>
                        <option value="cubic_in">Cubic Inch (in³)</option>
                        <option value="cubic_ft">Cubic Foot (ft³)</option>
                        <option value="cubic_yd">Cubic Yard (yd³)</option>
                        <option value="barrel">Barrel (oil)</option>
                    </select>
                    <div class="input-wrapper" style="margin-top: 10px;">
                        <input type="text" id="outputValue" placeholder="Result" readonly style="background: #f8f9fa; font-weight: 600; color: #2c3e50;">
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid"></div>

            <div class="quick-convert">
                <h3>⚡ Quick Conversions</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setInput(1)">
                        <div class="quick-value">1</div>
                        <div class="quick-label">Liter</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(3.785)">
                        <div class="quick-value">3.785</div>
                        <div class="quick-label">1 US Gallon</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(1000)">
                        <div class="quick-value">1000</div>
                        <div class="quick-label">mL (1 Liter)</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(0.2366)">
                        <div class="quick-value">0.2366</div>
                        <div class="quick-label">1 US Cup</div>
                    </div>
                </div>
            </div>

            <div class="common-volumes">
                <h3>🎯 Common Volume Values</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setCommonVolume(0.33, 'Standard soda can volume')">
                        <div class="quick-value">0.33 L</div>
                        <div class="quick-label">Soda Can</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonVolume(0.5, 'Standard water bottle')">
                        <div class="quick-value">0.5 L</div>
                        <div class="quick-label">Water Bottle</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonVolume(1, 'Standard water bottle large')">
                        <div class="quick-value">1 L</div>
                        <div class="quick-label">Large Bottle</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonVolume(18.9, 'Standard water cooler bottle')">
                        <div class="quick-value">18.9 L</div>
                        <div class="quick-label">Water Cooler</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🧪 Volume Unit Conversion</h2>
            
            <p>Convert between volume units used worldwide for cooking, science, industry, and everyday applications.</p>

            <div class="volume-scale">
                <h3>📊 Volume Scale Spectrum</h3>
                <div class="volume-scale-bar"></div>
                <div class="volume-scale-labels">
                    <span>Milliliters<br>(mL)</span>
                    <span>Liters<br>(L)</span>
                    <span>Gallons<br>(gal)</span>
                    <span>Cubic Meters<br>(m³)</span>
                    <span>Olympic Pools<br>(2,500 m³)</span>
                </div>
            </div>

            <h3>📊 Conversion Factors to Liters</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Liters</th>
                        <th>Common Usage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Liter</td><td>L</td><td>1</td><td>SI metric unit</td></tr>
                    <tr><td>Milliliter</td><td>mL</td><td>0.001</td><td>Cooking, medicine</td></tr>
                    <tr><td>US Gallon</td><td>gal</td><td>3.78541</td><td>US liquid measure</td></tr>
                    <tr><td>UK Gallon</td><td>gal UK</td><td>4.54609</td><td>UK imperial measure</td></tr>
                    <tr><td>US Cup</td><td>cup</td><td>0.236588</td><td>US cooking</td></tr>
                    <tr><td>UK Cup</td><td>cup UK</td><td>0.284131</td><td>UK cooking</td></tr>
                    <tr><td>US Pint</td><td>pt</td><td>0.473176</td><td>US liquid</td></tr>
                    <tr><td>UK Pint</td><td>pt UK</td><td>0.568261</td><td>UK pubs</td></tr>
                    <tr><td>US Quart</td><td>qt</td><td>0.946353</td><td>US liquid</td></tr>
                    <tr><td>UK Quart</td><td>qt UK</td><td>1.13652</td><td>UK liquid</td></tr>
                    <tr><td>US Fluid Ounce</td><td>fl oz</td><td>0.0295735</td><td>US recipes</td></tr>
                    <tr><td>UK Fluid Ounce</td><td>fl oz UK</td><td>0.0284131</td><td>UK recipes</td></tr>
                    <tr><td>Tablespoon</td><td>tbsp</td><td>0.0147868</td><td>Cooking worldwide</td></tr>
                    <tr><td>Teaspoon</td><td>tsp</td><td>0.00492892</td><td>Cooking worldwide</td></tr>
                    <tr><td>Cubic Meter</td><td>m³</td><td>1000</td><td>SI derived unit</td></tr>
                    <tr><td>Cubic Centimeter</td><td>cm³</td><td>0.001</td><td>Science, engineering</td></tr>
                    <tr><td>Cubic Inch</td><td>in³</td><td>0.0163871</td><td>Engine displacement</td></tr>
                    <tr><td>Cubic Foot</td><td>ft³</td><td>28.3168</td><td>Construction, shipping</td></tr>
                    <tr><td>Cubic Yard</td><td>yd³</td><td>764.555</td><td>Construction, landscaping</td></tr>
                    <tr><td>Barrel (oil)</td><td>bbl</td><td>158.987</td><td>Petroleum industry</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Volume Conversion Formulas:</strong><br>
                • <strong>1 Liter</strong> = 1,000 mL = 1,000 cm³ = 0.001 m³<br>
                • <strong>1 US Gallon</strong> = 3.78541 L = 4 US Quarts = 8 US Pints = 128 US fl oz<br>
                • <strong>1 UK Gallon</strong> = 4.54609 L = 4 UK Quarts = 8 UK Pints = 160 UK fl oz<br>
                • <strong>1 Cubic Meter</strong> = 1,000 L = 1,000,000 mL = 35.3147 ft³<br>
                • <strong>1 US Cup</strong> = 236.588 mL = 16 US Tablespoons = 48 US Teaspoons<br>
                • <strong>1 Barrel (oil)</strong> = 42 US Gallons = 158.987 L
            </div>

            <h3>🍳 Cooking & Kitchen Measurements</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Measurement</th>
                        <th>US Volume</th>
                        <th>Metric Volume</th>
                        <th>Common Uses</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Pinch</td><td>1/16 tsp</td><td>0.31 mL</td><td>Salt, spices</td></tr>
                    <tr><td>Dash</td><td>1/8 tsp</td><td>0.62 mL</td><td>Bitters, extracts</td></tr>
                    <tr><td>Teaspoon</td><td>1 tsp</td><td>4.93 mL</td><td>Spices, baking powder</td></tr>
                    <tr><td>Tablespoon</td><td>1 tbsp</td><td>14.79 mL</td><td>Oil, butter, sauces</td></tr>
                    <tr><td>Fluid Ounce</td><td>1 fl oz</td><td>29.57 mL</td><td>Liquids, extracts</td></tr>
                    <tr><td>Shot (US)</td><td>1.5 fl oz</td><td>44.36 mL</td><td>Spirits, alcohol</td></tr>
                    <tr><td>Gill (UK)</td><td>5 fl oz</td><td>142.07 mL</td><td>Traditional UK measure</td></tr>
                    <tr><td>US Cup</td><td>1 cup</td><td>236.59 mL</td><td>Flour, sugar, liquids</td></tr>
                    <tr><td>US Pint</td><td>1 pt</td><td>473.18 mL</td><td>Cream, berries</td></tr>
                    <tr><td>US Quart</td><td>1 qt</td><td>946.35 mL</td><td>Liquids, stocks</td></tr>
                </tbody>
            </table>

            <div class="cooking-box">
                <strong>👨‍🍳 Cooking Measurement Tips:</strong><br>
                • <span class="volume-highlight">Liquid vs Dry:</span> Use liquid measuring cups for liquids, dry cups for powders<br>
                • <span class="volume-highlight">Spoon & Level:</span> For flour, spoon into cup and level with straight edge<br>
                • <span class="volume-highlight">Butter Sticks:</span> 1 stick = ½ cup = 8 tbsp = 113.4 grams<br>
                • <span class="volume-highlight">Metric Advantage:</span> Weight measurements (grams) are more accurate than volume<br>
                • <span class="volume-highlight">Conversion Tip:</span> 1 mL of water weighs 1 gram at 4°C
            </div>

            <h3>🌍 International Volume Standards</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Country/System</th>
                        <th>Gallon Size</th>
                        <th>Pint Size</th>
                        <th>Cup Size</th>
                        <th>Primary Usage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>United States</td><td>3.785 L</td><td>473.18 mL</td><td>236.59 mL</td><td>All applications</td></tr>
                    <tr><td>United Kingdom</td><td>4.546 L</td><td>568.26 mL</td><td>284.13 mL</td><td>Liquids, pubs</td></tr>
                    <tr><td>Canada</td><td>4.546 L*</td><td>568.26 mL*</td><td>250 mL</td><td>Mixed usage</td></tr>
                    <tr><td>Australia</td><td>4.546 L</td><td>568.26 mL</td><td>250 mL</td><td>Metric with imperial legacy</td></tr>
                    <tr><td>European Union</td><td>N/A</td><td>N/A</td><td>250 mL</td><td>Metric only</td></tr>
                    <tr><td>Japan</td><td>N/A</td><td>N/A</td><td>200 mL</td><td>Traditional cup size</td></tr>
                </tbody>
            </table>
            <p style="font-size: 0.9rem; color: #777;">* Canada officially uses imperial gallons but often references US measurements</p>

            <div class="industrial-box">
                <strong>🏭 Industrial Volume Applications:</strong><br>
                • <span class="volume-highlight">Petroleum:</span> Barrel = 42 US gallons = 158.987 L<br>
                • <span class="volume-highlight">Shipping:</span> Twenty-foot Equivalent Unit (TEU) = 38.5 m³<br>
                • <span class="volume-highlight">Agriculture:</span> Acre-foot = 1,233.5 m³ (water volume for 1 acre)<br>
                • <span class="volume-highlight">Brewing:</span> Barrel (US beer) = 31 US gallons = 117.348 L<br>
                • <span class="volume-highlight">Wine:</span> Barrel = 60 US gallons = 227.125 L (varies by region)<br>
                • <span class="volume-highlight">Concrete:</span> Cubic yard = 0.764555 m³ (standard measurement)
            </div>

            <h3>🔬 Scientific & Laboratory</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Volume</th>
                        <th>Equivalent</th>
                        <th>Scientific Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Microliter</td><td>μL</td><td>0.000001 L</td><td>Chemistry, biology</td></tr>
                    <tr><td>Milliliter</td><td>mL</td><td>0.001 L</td><td>Standard lab measure</td></tr>
                    <tr><td>Centiliter</td><td>cL</td><td>0.01 L</td><td>European recipes, bars</td></tr>
                    <tr><td>Deciliter</td><td>dL</td><td>0.1 L</td><td>Scandinavian cooking</td></tr>
                    <tr><td>Liter</td><td>L</td><td>1 L</td><td>SI accepted unit</td></tr>
                    <tr><td>Cubic Centimeter</td><td>cm³</td><td>0.001 L</td><td>Medicine, engineering</td></tr>
                    <tr><td>Cubic Decimeter</td><td>dm³</td><td>1 L</td><td>Equivalent to liter</td></tr>
                    <tr><td>Hectoliter</td><td>hL</td><td>100 L</td><td>Agriculture, brewing</td></tr>
                    <tr><td>Kiloliter</td><td>kL</td><td>1,000 L</td><td>Industrial quantities</td></tr>
                </tbody>
            </table>

            <h3>🚗 Automotive & Engineering</h3>
            <ul>
                <li><strong>Engine displacement:</strong> Measured in liters (L) or cubic inches (in³)</li>
                <li><strong>Fuel tank capacity:</strong> Liters (metric) or gallons (US)</li>
                <li><strong>Oil changes:</strong> Typically 4-6 liters (4.2-6.3 US quarts)</li>
                <li><strong>Coolant systems:</strong> 8-16 liters for most passenger vehicles</li>
                <li><strong>Common conversions:</strong> 1 liter ≈ 61 cubic inches, 1000 cm³ = 1 liter</li>
                <li><strong>Hybrid/electric:</strong> Battery capacity in kilowatt-hours (kWh), not volume</li>
            </ul>

            <div class="scientific-box">
                <strong>🔍 Scientific Volume Relationships:</strong><br>
                • <span class="volume-highlight">Water Volume:</span> 1 mL water = 1 cm³ = 1 gram at 4°C<br>
                • <span class="volume-highlight">Gas Volume:</span> 1 mole of gas = 22.4 L at STP (Standard Temperature and Pressure)<br>
                • <span class="volume-highlight">Density Formula:</span> Density = Mass ÷ Volume<br>
                • <span class="volume-highlight">Container Volume:</span> Cube = side³, Cylinder = π × radius² × height<br>
                • <span class="volume-highlight">Ocean Volume:</span> ≈ 1.332 billion km³ (total Earth ocean volume)
            </div>

            <h3>🏠 Everyday Volume References</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Approximate Volume</th>
                        <th>Metric Equivalent</th>
                        <th>US Equivalent</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Teaspoon</td><td>5 mL</td><td>5 mL</td><td>1 tsp</td></tr>
                    <tr><td>Tablespoon</td><td>15 mL</td><td>15 mL</td><td>1 tbsp</td></tr>
                    <tr><td>Shot glass</td><td>44 mL</td><td>44 mL</td><td>1.5 fl oz</td></tr>
                    <tr><td>Standard soda can</td><td>355 mL</td><td>0.355 L</td><td>12 fl oz</td></tr>
                    <tr><td>Wine bottle</td><td>750 mL</td><td>0.75 L</td><td>25.4 fl oz</td></tr>
                    <tr><td>Milk jug</td><td>3.78 L</td><td>3.78 L</td><td>1 gallon</td></tr>
                    <tr><td>Gasoline (car tank)</td><td>45-75 L</td><td>45-75 L</td><td>12-20 gallons</td></tr>
                    <tr><td>Bathtub</td><td>150-250 L</td><td>150-250 L</td><td>40-66 gallons</td></tr>
                    <tr><td>Swimming pool (avg)</td><td>75,000 L</td><td>75 m³</td><td>19,800 gallons</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>Easy-to-Remember Approximations:</strong><br>
                • <strong>Liters to Gallons:</strong> Divide liters by 4 for rough gallons (L ÷ 4 ≈ gal)<br>
                • <strong>Gallons to Liters:</strong> Multiply gallons by 4 for rough liters (gal × 4 ≈ L)<br>
                • <strong>Cups to Milliliters:</strong> Multiply cups by 240 for rough mL (cups × 240 ≈ mL)<br>
                • <strong>Milliliters to Cups:</strong> Divide mL by 240 for rough cups (mL ÷ 240 ≈ cups)<br>
                • <strong>Fluid Ounces to Milliliters:</strong> Multiply by 30 for rough mL (fl oz × 30 ≈ mL)<br>
                • <strong>Cubic Meters to Liters:</strong> Multiply by 1,000 (m³ × 1000 = L)
            </div>

            <h3>⚖️ Historical Context</h3>
            <p>The <strong>liter</strong> was introduced in 1795 during the French Revolution as part of the metric system, originally defined as the volume of 1 kilogram of water. The <strong>gallon</strong> has ancient origins, with the US gallon based on the British wine gallon and the UK gallon based on the ale gallon. The <strong>cup</strong> as a cooking measurement became standardized in the 19th century with the publication of cookbooks. The <strong>cubic meter</strong> became the SI unit of volume in 1960, defined as the volume of a cube with 1-meter sides.</p>

            <h3>📏 Volume Measurement Tools</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Tool</th>
                        <th>Typical Range</th>
                        <th>Accuracy</th>
                        <th>Applications</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Graduated cylinder</td><td>10 mL - 2 L</td><td>High</td><td>Laboratory, precise measurements</td></tr>
                    <tr><td>Beaker</td><td>50 mL - 4 L</td><td>Medium</td><td>General lab use, mixing</td></tr>
                    <tr><td>Burette</td><td>25-100 mL</td><td>Very high</td><td>Titration, precise dispensing</td></tr>
                    <tr><td>Measuring cups</td><td>¼ cup - 4 cups</td><td>Medium</td><td>Cooking, baking</td></tr>
                    <tr><td>Measuring spoons</td><td>⅛ tsp - 1 tbsp</td><td>Medium</td><td>Cooking, small quantities</td></tr>
                    <tr><td>Flow meter</td><td>Varies widely</td><td>High</td><td>Industrial, plumbing</td></tr>
                    <tr><td>Gas meter</td><td>Residential use</td><td>High</td><td>Utility measurement</td></tr>
                </tbody>
            </table>

            <h3>🎯 Key Conversions to Remember</h3>
            <ul>
                <li><strong>1 Liter = 1,000 mL = 0.264172 US Gallons</strong></li>
                <li><strong>1 US Gallon = 3.78541 Liters = 128 US Fluid Ounces</strong></li>
                <li><strong>1 UK Gallon = 4.54609 Liters = 160 UK Fluid Ounces</strong></li>
                <li><strong>1 US Cup = 236.588 mL = 16 US Tablespoons</strong></li>
                <li><strong>1 Cubic Meter = 1,000 Liters = 264.172 US Gallons</strong></li>
                <li><strong>1 Barrel (oil) = 42 US Gallons = 158.987 Liters</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>🧪 Volume Converter | Complete Volume Unit Conversion</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert liters, gallons, milliliters, cups, cubic meters, and other volume units with precision</p>
        </div>
    </div>

    <script>
        // Conversion factors to liters
        const toLiters = {
            liter: 1,
            ml: 0.001,
            gal_us: 3.78541,
            gal_uk: 4.54609,
            cup_us: 0.236588,
            cup_uk: 0.284131,
            pint_us: 0.473176,
            pint_uk: 0.568261,
            quart_us: 0.946353,
            quart_uk: 1.13652,
            floz_us: 0.0295735,
            floz_uk: 0.0284131,
            tbsp: 0.0147868,
            tsp: 0.00492892,
            cubic_m: 1000,
            cubic_cm: 0.001,
            cubic_in: 0.0163871,
            cubic_ft: 28.3168,
            cubic_yd: 764.555,
            barrel: 158.987
        };

        const unitNames = {
            liter: 'Liter (L)',
            ml: 'Milliliter (mL)',
            gal_us: 'US Gallon (gal)',
            gal_uk: 'UK Gallon (gal UK)',
            cup_us: 'US Cup (cup)',
            cup_uk: 'UK Cup (cup UK)',
            pint_us: 'US Pint (pt)',
            pint_uk: 'UK Pint (pt UK)',
            quart_us: 'US Quart (qt)',
            quart_uk: 'UK Quart (qt UK)',
            floz_us: 'US Fluid Ounce (fl oz)',
            floz_uk: 'UK Fluid Ounce (fl oz UK)',
            tbsp: 'Tablespoon (tbsp)',
            tsp: 'Teaspoon (tsp)',
            cubic_m: 'Cubic Meter (m³)',
            cubic_cm: 'Cubic Centimeter (cm³)',
            cubic_in: 'Cubic Inch (in³)',
            cubic_ft: 'Cubic Foot (ft³)',
            cubic_yd: 'Cubic Yard (yd³)',
            barrel: 'Barrel (oil)'
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

            // Convert to liters first
            const valueInLiters = inputValue * toLiters[fromUnit];
            
            // Convert to target unit
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
            if (Math.abs(num) < 0.01) {
                return num.toFixed(8);
            }
            if (Math.abs(num) < 1) {
                return num.toFixed(6);
            }
            return num.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 4
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

        function setCommonVolume(value, description) {
            document.getElementById('inputValue').value = value;
            document.getElementById('fromUnit').value = 'liter';
            document.getElementById('toUnit').value = 'ml';
            convert();
            console.log(description);
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