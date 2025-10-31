<?php
/**
 * Weight Converter
 * File: conversion/weight-converter.php
 * Description: Convert between weight/mass units including kilograms, pounds, ounces, grams, and more
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weight Converter - Mass Unit Conversion Calculator</title>
    <meta name="description" content="Convert between weight units: kilograms, pounds, ounces, grams, stones, and more. Essential for cooking, science, shipping, and health applications.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #ff6b6b; box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; margin-top: 10px; }
        .unit-select:focus { outline: none; border-color: #ff6b6b; box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #ffeb3b 0%, #ff9800 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #ff6b6b; }
        .result-unit { color: #d84315; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #e65100; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #ff6b6b; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255, 107, 107, 0.15); }
        .quick-value { font-weight: bold; color: #ff6b6b; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .common-weights { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .common-weights h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        
        .weight-scale { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .weight-scale-bar { height: 30px; background: linear-gradient(90deg, #4caf50, #ffeb3b, #ff9800, #f44336); border-radius: 15px; margin: 10px 0; position: relative; }
        .weight-scale-labels { display: flex; justify-content: space-between; font-size: 0.8rem; color: #555; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #ffeb3b; }
        
        .formula-box { background: #ffeb3b; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff6b6b; }
        .formula-box strong { color: #ff6b6b; }
        
        .cooking-box { background: #fff3e0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff9800; }
        
        .health-box { background: #e8f5e8; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #4caf50; }
        
        .shipping-box { background: #f3e5f5; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #9c27b0; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .weight-highlight { background: #fff3e0; padding: 3px 6px; border-radius: 4px; font-weight: bold; }
        
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
            <h1>⚖️ Weight Converter</h1>
            <p>Convert between weight units: kilograms, pounds, ounces, grams, stones, and more. Essential for cooking, science, shipping, and health applications.</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="kg" selected>Kilogram (kg)</option>
                        <option value="g">Gram (g)</option>
                        <option value="mg">Milligram (mg)</option>
                        <option value="lb">Pound (lb)</option>
                        <option value="oz">Ounce (oz)</option>
                        <option value="stone">Stone (st)</option>
                        <option value="ton_us">US Ton (ton)</option>
                        <option value="ton_uk">UK Ton (ton UK)</option>
                        <option value="tonne">Metric Tonne (t)</option>
                        <option value="carat">Carat (ct)</option>
                        <option value="grain">Grain (gr)</option>
                        <option value="dram">Dram (dr)</option>
                        <option value="newton">Newton (N)</option>
                        <option value="slug">Slug</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="kg">Kilogram (kg)</option>
                        <option value="g">Gram (g)</option>
                        <option value="mg">Milligram (mg)</option>
                        <option value="lb" selected>Pound (lb)</option>
                        <option value="oz">Ounce (oz)</option>
                        <option value="stone">Stone (st)</option>
                        <option value="ton_us">US Ton (ton)</option>
                        <option value="ton_uk">UK Ton (ton UK)</option>
                        <option value="tonne">Metric Tonne (t)</option>
                        <option value="carat">Carat (ct)</option>
                        <option value="grain">Grain (gr)</option>
                        <option value="dram">Dram (dr)</option>
                        <option value="newton">Newton (N)</option>
                        <option value="slug">Slug</option>
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
                        <div class="quick-label">Kilogram</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(2.20462)">
                        <div class="quick-value">2.20462</div>
                        <div class="quick-label">Pounds (1 kg)</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(1000)">
                        <div class="quick-value">1000</div>
                        <div class="quick-label">Grams (1 kg)</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(35.274)">
                        <div class="quick-value">35.274</div>
                        <div class="quick-label">Ounces (1 kg)</div>
                    </div>
                </div>
            </div>

            <div class="common-weights">
                <h3>🎯 Common Weight Values</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setCommonWeight(0.028, 'Standard letter weight')">
                        <div class="quick-value">28 g</div>
                        <div class="quick-label">Letter</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonWeight(0.454, 'One pound weight')">
                        <div class="quick-value">454 g</div>
                        <div class="quick-label">1 Pound</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonWeight(68, 'Average human body weight')">
                        <div class="quick-value">68 kg</div>
                        <div class="quick-label">Average Person</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonWeight(907.185, 'One US ton')">
                        <div class="quick-value">907 kg</div>
                        <div class="quick-label">US Ton</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⚖️ Weight Unit Conversion</h2>
            
            <p>Convert between weight units used worldwide for science, commerce, health, cooking, and everyday applications.</p>

            <div class="weight-scale">
                <h3>📊 Weight Scale Spectrum</h3>
                <div class="weight-scale-bar"></div>
                <div class="weight-scale-labels">
                    <span>Milligrams<br>(mg)</span>
                    <span>Grams<br>(g)</span>
                    <span>Kilograms<br>(kg)</span>
                    <span>Pounds<br>(lb)</span>
                    <span>Tons<br>(ton)</span>
                </div>
            </div>

            <h3>📊 Conversion Factors to Kilograms</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Kilograms</th>
                        <th>Common Usage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Kilogram</td><td>kg</td><td>1</td><td>SI base unit</td></tr>
                    <tr><td>Gram</td><td>g</td><td>0.001</td><td>Cooking, science</td></tr>
                    <tr><td>Milligram</td><td>mg</td><td>0.000001</td><td>Medicine, supplements</td></tr>
                    <tr><td>Pound</td><td>lb</td><td>0.453592</td><td>US/UK weight</td></tr>
                    <tr><td>Ounce</td><td>oz</td><td>0.0283495</td><td>US/UK small weights</td></tr>
                    <tr><td>Stone</td><td>st</td><td>6.35029</td><td>UK body weight</td></tr>
                    <tr><td>US Ton</td><td>ton</td><td>907.185</td><td>US shipping, industry</td></tr>
                    <tr><td>UK Ton</td><td>ton UK</td><td>1,016.05</td><td>UK shipping, industry</td></tr>
                    <tr><td>Metric Tonne</td><td>t</td><td>1,000</td><td>International trade</td></tr>
                    <tr><td>Carat</td><td>ct</td><td>0.0002</td><td>Gemstones, pearls</td></tr>
                    <tr><td>Grain</td><td>gr</td><td>0.0000648</td><td>Ammunition, arrows</td></tr>
                    <tr><td>Dram</td><td>dr</td><td>0.00177185</td><td>Apothecary, historical</td></tr>
                    <tr><td>Newton</td><td>N</td><td>0.101972</td><td>Force measurement</td></tr>
                    <tr><td>Slug</td><td>slug</td><td>14.5939</td><td>Imperial mass unit</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Weight Conversion Formulas:</strong><br>
                • <strong>1 Kilogram</strong> = 1,000 grams = 2.20462 pounds<br>
                • <strong>1 Pound</strong> = 16 ounces = 0.453592 kilograms<br>
                • <strong>1 Ounce</strong> = 28.3495 grams = 0.0625 pounds<br>
                • <strong>1 Stone</strong> = 14 pounds = 6.35029 kilograms<br>
                • <strong>1 US Ton</strong> = 2,000 pounds = 907.185 kilograms<br>
                • <strong>1 UK Ton</strong> = 2,240 pounds = 1,016.05 kilograms<br>
                • <strong>1 Metric Tonne</strong> = 1,000 kilograms = 2,204.62 pounds
            </div>

            <h3>🍳 Cooking & Food Measurements</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Ingredient</th>
                        <th>Volume to Weight</th>
                        <th>Common Measurement</th>
                        <th>Approximate Weight</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>All-purpose flour</td><td>1 cup</td><td>Spooned & leveled</td><td>120-125 grams</td></tr>
                    <tr><td>Granulated sugar</td><td>1 cup</td><td>Standard packing</td><td>200 grams</td></tr>
                    <tr><td>Brown sugar</td><td>1 cup</td><td>Firmly packed</td><td>220 grams</td></tr>
                    <tr><td>Butter</td><td>1 cup</td><td>2 sticks</td><td>227 grams</td></tr>
                    <tr><td>Milk</td><td>1 cup</td><td>Liquid measure</td><td>240 grams</td></tr>
                    <tr><td>Water</td><td>1 cup</td><td>Liquid measure</td><td>236 grams</td></tr>
                    <tr><td>Rice (uncooked)</td><td>1 cup</td><td>Standard measure</td><td>185 grams</td></tr>
                    <tr><td>Oats (rolled)</td><td>1 cup</td><td>Standard measure</td><td>80 grams</td></tr>
                    <tr><td>Honey</td><td>1 cup</td><td>Liquid measure</td><td>340 grams</td></tr>
                    <tr><td>Salt</td><td>1 teaspoon</td><td>Fine grain</td><td>5.7 grams</td></tr>
                </tbody>
            </table>

            <div class="cooking-box">
                <strong>👨‍🍳 Cooking Weight Tips:</strong><br>
                • <span class="weight-highlight">Baking precision:</span> Use weight measurements for consistent results<br>
                • <span class="weight-highlight">Flour measurement:</span> Can vary by 30% between scooping and spooning<br>
                • <span class="weight-highlight">Butter conversions:</span> 1 stick = ½ cup = 8 tbsp = 113.4 grams<br>
                • <span class="weight-highlight">Liquid ingredients:</span> 1 mL ≈ 1 gram for water-based liquids<br>
                • <span class="weight-highlight">Professional kitchens:</span> Almost exclusively use weight measurements
            </div>

            <h3>⚕️ Health & Body Weight</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Kilograms</th>
                        <th>Pounds</th>
                        <th>Stone (UK)</th>
                        <th>Health Context</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Newborn baby</td><td>2.5-4.5</td><td>5.5-10</td><td>0.4-0.7</td><td>Healthy birth weight</td></tr>
                    <tr><td>1-year-old</td><td>8-12</td><td>18-26</td><td>1.3-1.9</td><td>Typical development</td></tr>
                    <tr><td>Average adult female</td><td>54-64</td><td>119-141</td><td>8.5-10.1</td><td>Global average</td></tr>
                    <tr><td>Average adult male</td><td>69-83</td><td>152-183</td><td>10.9-13.1</td><td>Global average</td></tr>
                    <tr><td>Underweight (adult)</td><td>&lt;18.5 BMI</td><td>&lt;18.5 BMI</td><td>&lt;18.5 BMI</td><td>Health risk</td></tr>
                    <tr><td>Normal weight</td><td>18.5-24.9 BMI</td><td>18.5-24.9 BMI</td><td>18.5-24.9 BMI</td><td>Healthy range</td></tr>
                    <tr><td>Overweight</td><td>25-29.9 BMI</td><td>25-29.9 BMI</td><td>25-29.9 BMI</td><td>Increased risk</td></tr>
                    <tr><td>Obese</td><td>≥30 BMI</td><td>≥30 BMI</td><td>≥30 BMI</td><td>High health risk</td></tr>
                </tbody>
            </table>

            <div class="health-box">
                <strong>💪 Health & Fitness:</strong><br>
                • <span class="weight-highlight">BMI Formula:</span> Weight (kg) ÷ [Height (m)]²<br>
                • <span class="weight-highlight">Weight loss:</span> 0.5-1 kg (1-2 lb) per week is considered healthy<br>
                • <span class="weight-highlight">Muscle vs Fat:</span> Muscle is denser - 1 liter muscle ≈ 1.06 kg, fat ≈ 0.9 kg<br>
                • <span class="weight-highlight">Water weight:</span> Can fluctuate 1-2 kg daily due to hydration<br>
                • <span class="weight-highlight">Weight training:</span> Typical dumbbells: 2.5-25 kg (5-55 lb)
            </div>

            <h3>📦 Shipping & Postal Weights</h3>
            <ul>
                <li><strong>Standard letter:</strong> Up to 28 grams (1 ounce) for basic postage</li>
                <li><strong>Large envelope:</strong> 28-227 grams (1-8 ounces)</li>
                <li><strong>Small package:</strong> 227 grams - 2.3 kg (8 ounces - 5 pounds)</li>
                <li><strong>Medium package:</strong> 2.3-9 kg (5-20 pounds)</li>
                <li><strong>Heavy package:</strong> 9-23 kg (20-50 pounds) - typical shipping limit</li>
                <li><strong>Freight shipments:</strong> 23+ kg (50+ pounds) - palletized goods</li>
                <li><strong>Airline baggage:</strong> Typically 23 kg (50 lb) checked, 7-10 kg (15-22 lb) carry-on</li>
            </ul>

            <h3>🏭 Industrial & Commercial Weights</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Item/Context</th>
                        <th>Typical Weight</th>
                        <th>Equivalent</th>
                        <th>Industry</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Brick (standard)</td><td>2.0-2.5 kg</td><td>4.4-5.5 lb</td><td>Construction</td></tr>
                    <tr><td>Concrete block</td><td>11-16 kg</td><td>24-35 lb</td><td>Construction</td></tr>
                    <tr><td>Car (compact)</td><td>1,100-1,300 kg</td><td>2,400-2,900 lb</td><td>Automotive</td></tr>
                    <tr><td>Car (SUV)</td><td>1,800-2,400 kg</td><td>4,000-5,300 lb</td><td>Automotive</td></tr>
                    <tr><td>Shipping container (empty)</td><td>2,200-3,800 kg</td><td>4,800-8,400 lb</td><td>Logistics</td></tr>
                    <tr><td>Elephant (African)</td><td>3,000-6,000 kg</td><td>6,600-13,200 lb</td><td>Zoology</td></tr>
                    <tr><td>Blue whale</td><td>100,000-150,000 kg</td><td>220,000-330,000 lb</td><td>Marine biology</td></tr>
                    <tr><td>Commercial aircraft (empty)</td><td>40,000-180,000 kg</td><td>88,000-400,000 lb</td><td>Aviation</td></tr>
                </tbody>
            </table>

            <div class="shipping-box">
                <strong>🚚 Shipping & Logistics:</strong><br>
                • <span class="weight-highlight">Freight class:</span> Based on weight and density for pricing<br>
                • <span class="weight-highlight">Pallet weight:</span> Standard pallet ≈ 25 kg (55 lb) empty<br>
                • <span class="weight-highlight">Container ship:</span> Can carry 200,000+ metric tonnes<br>
                • <span class="weight-highlight">Weight limits:</span> Trucks: 36,000 kg (80,000 lb) in US<br>
                • <span class="weight-highlight">Air freight:</span> Chargeable weight considers both actual and volumetric weight
            </div>

            <h3>💎 Precious Metals & Gemstones</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Grams</th>
                        <th>Ounces</th>
                        <th>Grains</th>
                        <th>Usage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Carat (metric)</td><td>0.2</td><td>0.007055</td><td>3.08647</td><td>Gemstones worldwide</td></tr>
                    <tr><td>Troy Ounce</td><td>31.1035</td><td>1</td><td>480</td><td>Precious metals</td></tr>
                    <tr><td>Pennyweight</td><td>1.55517</td><td>0.05</td><td>24</td><td>Jewelry (historical)</td></tr>
                    <tr><td>Tola (India)</td><td>11.6638</td><td>0.375</td><td>180</td><td>Gold in South Asia</td></tr>
                    <tr><td>Tael (Chinese)</td><td>37.5</td><td>1.20565</td><td>578.713</td><td>Gold in East Asia</td></tr>
                    <tr><td>Baht (Thai)</td><td>15.244</td><td>0.49025</td><td>235.301</td><td>Gold in Thailand</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>Easy-to-Remember Approximations:</strong><br>
                • <strong>Kilograms to Pounds:</strong> Multiply by 2.2 (kg × 2.2 ≈ lb)<br>
                • <strong>Pounds to Kilograms:</strong> Divide by 2.2 (lb ÷ 2.2 ≈ kg)<br>
                • <strong>Grams to Ounces:</strong> Divide by 28 (g ÷ 28 ≈ oz)<br>
                • <strong>Ounces to Grams:</strong> Multiply by 28 (oz × 28 ≈ g)<br>
                • <strong>Stones to Pounds:</strong> Multiply by 14 (st × 14 = lb)<br>
                • <strong>Pounds to Stones:</strong> Divide by 14 (lb ÷ 14 = st)<br>
                • <strong>Quick reference:</strong> 1 kg ≈ 2.2 lb, 1 lb ≈ 0.45 kg
            </div>

            <h3>🌎 Regional Weight Standards</h3>
            <ul>
                <li><strong>United States:</strong> Pounds and ounces for most applications</li>
                <li><strong>United Kingdom:</strong> Stones and pounds for body weight, metric for other uses</li>
                <li><strong>Canada:</strong> Officially metric, but some imperial use persists</li>
                <li><strong>Australia/New Zealand:</strong> Fully metric (kilograms)</li>
                <li><strong>European Union:</strong> Exclusively metric (kilograms and grams)</li>
                <li><strong>Japan:</strong> Metric system with traditional units (monme, kan)</li>
                <li><strong>China:</strong> Metric system with traditional units (jin, liang)</li>
                <li><strong>India:</strong> Metric system with traditional units (tola, ser)</li>
            </ul>

            <h3>⚖️ Historical Context</h3>
            <p>The <strong>kilogram</strong> was defined in 1795 as the mass of one liter of water. Today it's defined by the Planck constant. The <strong>pound</strong> has origins in Roman libra, while the <strong>ounce</strong> comes from Roman uncia. The <strong>stone</strong> was historically used for weighing commodities and varied by location until standardized in the 19th century. The international avoirdupois pound was defined in 1959 as exactly 0.45359237 kilograms.</p>

            <h3>📏 Weight Measurement Tools</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Measurement Tool</th>
                        <th>Typical Range</th>
                        <th>Accuracy</th>
                        <th>Applications</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Laboratory balance</td><td>0.1 mg - 30 kg</td><td>0.001%</td><td>Scientific research</td></tr>
                    <tr><td>Kitchen scale</td><td>1 g - 10 kg</td><td>0.1-1%</td><td>Cooking, baking</td></tr>
                    <tr><td>Bathroom scale</td><td>0.1 kg - 180 kg</td><td>0.1-0.5%</td><td>Personal health</td></tr>
                    <tr><td>Postal scale</td><td>1 g - 50 kg</td><td>0.5-1%</td><td>Shipping, mailing</td></tr>
                    <tr><td>Industrial scale</td><td>1 kg - 100 tons</td><td>0.01-0.5%</td><td>Manufacturing, shipping</td></tr>
                    <tr><td>Medical scale</td><td>0.1 kg - 250 kg</td><td>0.05%</td><td>Healthcare</td></tr>
                    <tr><td>Jewelry scale</td><td>0.001 g - 500 g</td><td>0.001%</td><td>Gemstones, precious metals</td></tr>
                </tbody>
            </table>

            <h3>🎯 Key Conversions to Remember</h3>
            <ul>
                <li><strong>1 Kilogram = 2.20462 Pounds = 35.274 Ounces</strong></li>
                <li><strong>1 Pound = 0.453592 Kilograms = 16 Ounces</strong></li>
                <li><strong>1 Ounce = 28.3495 Grams = 0.0625 Pounds</strong></li>
                <li><strong>1 Stone = 14 Pounds = 6.35029 Kilograms</strong></li>
                <li><strong>1 US Ton = 2,000 Pounds = 907.185 Kilograms</strong></li>
                <li><strong>1 Metric Tonne = 1,000 Kilograms = 2,204.62 Pounds</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>⚖️ Weight Converter | Complete Weight Unit Conversion</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert kilograms, pounds, ounces, grams, stones, and other weight units with precision</p>
        </div>
    </div>

    <script>
        // Conversion factors to kilograms
        const toKilograms = {
            kg: 1,
            g: 0.001,
            mg: 0.000001,
            lb: 0.45359237,
            oz: 0.028349523125,
            stone: 6.35029318,
            ton_us: 907.18474,
            ton_uk: 1016.0469088,
            tonne: 1000,
            carat: 0.0002,
            grain: 0.00006479891,
            dram: 0.0017718451953125,
            newton: 0.10197162129779,
            slug: 14.593902937206
        };

        const unitNames = {
            kg: 'Kilogram (kg)',
            g: 'Gram (g)',
            mg: 'Milligram (mg)',
            lb: 'Pound (lb)',
            oz: 'Ounce (oz)',
            stone: 'Stone (st)',
            ton_us: 'US Ton (ton)',
            ton_uk: 'UK Ton (ton UK)',
            tonne: 'Metric Tonne (t)',
            carat: 'Carat (ct)',
            grain: 'Grain (gr)',
            dram: 'Dram (dr)',
            newton: 'Newton (N)',
            slug: 'Slug'
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

            // Convert to kilograms first
            const valueInKilograms = inputValue * toKilograms[fromUnit];
            
            // Convert to target unit
            const result = valueInKilograms / toKilograms[toUnit];
            
            document.getElementById('outputValue').value = formatNumber(result);
            
            displayAllConversions(valueInKilograms);
        }

        function displayAllConversions(valueInKilograms) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInKilograms / toKilograms[unit];
                
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

        function setCommonWeight(value, description) {
            document.getElementById('inputValue').value = value;
            document.getElementById('fromUnit').value = 'kg';
            document.getElementById('toUnit').value = 'lb';
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