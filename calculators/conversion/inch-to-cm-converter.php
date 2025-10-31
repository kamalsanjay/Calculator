<?php
/**
 * Inch to CM Converter
 * File: conversion/inch-to-cm-converter.php
 * Description: Convert inches to centimeters and vice versa
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inch to CM Converter - Inches to Centimeters Calculator</title>
    <meta name="description" content="Convert inches to centimeters (cm) and cm to inches instantly. Bidirectional length converter for measurements.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 900px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 70px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #f5576c; box-shadow: 0 0 0 3px rgba(245, 87, 108, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #f5576c; font-weight: 600; font-size: 0.95rem; }
        
        .swap-btn { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-box { background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #f5576c; margin-bottom: 25px; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.5rem; font-weight: bold; color: #f5576c; margin-bottom: 10px; }
        .result-formula { background: white; padding: 15px; border-radius: 8px; font-family: 'Courier New', monospace; color: #555; font-size: 0.9rem; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #f5576c; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(245, 87, 108, 0.15); }
        .quick-value { font-weight: bold; color: #f5576c; font-size: 1.1rem; }
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
        .conversion-table tr:hover { background: #fce4ec; }
        
        .formula-box { background: #fce4ec; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #f5576c; }
        .formula-box strong { color: #f5576c; }
        
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
            <h1>📏 Inch ⇄ CM Converter</h1>
            <p>Convert between inches and centimeters with bidirectional conversion</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inchInput">Inches</label>
                    <div class="input-wrapper">
                        <input type="number" id="inchInput" placeholder="Enter inches" step="0.01" min="0" value="12">
                        <span class="unit-label">in</span>
                    </div>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="cmInput">Centimeters</label>
                    <div class="input-wrapper">
                        <input type="number" id="cmInput" placeholder="Enter cm" step="0.1" min="0">
                        <span class="unit-label">cm</span>
                    </div>
                </div>
            </div>

            <div class="result-box">
                <div class="result-label">Result</div>
                <div class="result-value" id="resultValue">12 in = 30.48 cm</div>
                <div class="result-formula" id="resultFormula">12 inches × 2.54 = 30.48 cm</div>
            </div>

            <div class="quick-convert">
                <h3>📐 Common Measurements</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setInches(1)">
                        <div class="quick-value">1 in</div>
                        <div class="quick-label">2.54 cm</div>
                    </div>
                    <div class="quick-btn" onclick="setInches(6)">
                        <div class="quick-value">6 in</div>
                        <div class="quick-label">15.24 cm</div>
                    </div>
                    <div class="quick-btn" onclick="setInches(12)">
                        <div class="quick-value">12 in</div>
                        <div class="quick-label">1 Foot</div>
                    </div>
                    <div class="quick-btn" onclick="setInches(24)">
                        <div class="quick-value">24 in</div>
                        <div class="quick-label">2 Feet</div>
                    </div>
                    <div class="quick-btn" onclick="setInches(36)">
                        <div class="quick-value">36 in</div>
                        <div class="quick-label">1 Yard</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>📏 Inch to Centimeter Conversion</h2>
            
            <p>An <strong>inch</strong> is an imperial unit of length, while a <strong>centimeter</strong> is a metric unit. The inch is commonly used in the United States, United Kingdom, and Canada.</p>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>Inches to Centimeters:</strong><br>
                • Centimeters = Inches × 2.54<br>
                • 1 inch = 2.54 centimeters (exact)<br><br>
                <strong>Centimeters to Inches:</strong><br>
                • Inches = Centimeters ÷ 2.54<br>
                • 1 centimeter = 0.393701 inches
            </div>

            <h3>📊 Conversion Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Inches (in)</th>
                        <th>Centimeters (cm)</th>
                        <th>Common Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 in</td><td>2.54 cm</td><td>Thumb width</td></tr>
                    <tr><td>2 in</td><td>5.08 cm</td><td>Two fingers</td></tr>
                    <tr><td>3 in</td><td>7.62 cm</td><td>Credit card width</td></tr>
                    <tr><td>6 in</td><td>15.24 cm</td><td>Half foot / ruler</td></tr>
                    <tr><td>12 in</td><td>30.48 cm</td><td>One foot</td></tr>
                    <tr><td>24 in</td><td>60.96 cm</td><td>Two feet</td></tr>
                    <tr><td>36 in</td><td>91.44 cm</td><td>One yard</td></tr>
                    <tr><td>39.37 in</td><td>100 cm</td><td>One meter</td></tr>
                </tbody>
            </table>

            <h3>📱 Screen Sizes</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Device</th>
                        <th>Inches (diagonal)</th>
                        <th>Centimeters</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Smartphone</td><td>6-7 in</td><td>15.2-17.8 cm</td></tr>
                    <tr><td>Tablet</td><td>10-13 in</td><td>25.4-33 cm</td></tr>
                    <tr><td>Laptop</td><td>13-17 in</td><td>33-43.2 cm</td></tr>
                    <tr><td>Monitor</td><td>24-32 in</td><td>61-81.3 cm</td></tr>
                    <tr><td>TV</td><td>55-85 in</td><td>140-216 cm</td></tr>
                </tbody>
            </table>

            <h3>🎨 Paper Sizes</h3>
            <ul>
                <li><strong>Letter (US):</strong> 8.5 × 11 in (21.6 × 27.9 cm)</li>
                <li><strong>Legal (US):</strong> 8.5 × 14 in (21.6 × 35.6 cm)</li>
                <li><strong>A4 (International):</strong> 8.27 × 11.69 in (21 × 29.7 cm)</li>
                <li><strong>A3:</strong> 11.69 × 16.54 in (29.7 × 42 cm)</li>
                <li><strong>Tabloid:</strong> 11 × 17 in (27.9 × 43.2 cm)</li>
            </ul>

            <h3>📐 Common Objects</h3>
            <div class="formula-box">
                <strong>Everyday Items:</strong><br>
                • Credit card width: 3.37 in (8.56 cm)<br>
                • US Dollar bill: 6.14 × 2.61 in (15.6 × 6.6 cm)<br>
                • CD/DVD: 4.72 in diameter (12 cm)<br>
                • Standard keyboard: ~18 in (45.7 cm)<br>
                • Computer mouse: 4-5 in (10-12.7 cm)
            </div>

            <h3>🏗️ Construction & DIY</h3>
            <ul>
                <li><strong>2×4 lumber:</strong> Actually 1.5 × 3.5 in (3.8 × 8.9 cm)</li>
                <li><strong>Plywood thickness:</strong> 1/4, 1/2, 3/4 in (0.64, 1.27, 1.9 cm)</li>
                <li><strong>Drywall:</strong> 4 × 8 ft sheets, 1/2 in thick (1.27 cm)</li>
                <li><strong>Nail sizes:</strong> 2d (1 in), 8d (2.5 in), 16d (3.5 in)</li>
            </ul>

            <h3>🚗 Wheels & Tires</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Wheel Size</th>
                        <th>Inches</th>
                        <th>Centimeters</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Bicycle (road)</td><td>700c (27 in)</td><td>68.6 cm</td></tr>
                    <tr><td>Mountain bike</td><td>26-29 in</td><td>66-73.7 cm</td></tr>
                    <tr><td>Car (compact)</td><td>14-16 in</td><td>35.6-40.6 cm</td></tr>
                    <tr><td>Car (sedan)</td><td>17-18 in</td><td>43.2-45.7 cm</td></tr>
                    <tr><td>SUV/Truck</td><td>18-22 in</td><td>45.7-55.9 cm</td></tr>
                </tbody>
            </table>

            <h3>📺 TV & Monitor Sizing</h3>
            <div class="formula-box">
                <strong>Common TV Sizes:</strong><br>
                • 32 inch TV = 81.3 cm (small bedroom)<br>
                • 43 inch TV = 109.2 cm (medium room)<br>
                • 55 inch TV = 139.7 cm (living room)<br>
                • 65 inch TV = 165.1 cm (large living room)<br>
                • 75 inch TV = 190.5 cm (home theater)<br><br>
                <strong>Note:</strong> Screen size measured diagonally
            </div>

            <h3>👕 Clothing Measurements</h3>
            <ul>
                <li><strong>Waist size:</strong> 30-40 in (76-102 cm) typical</li>
                <li><strong>Inseam (pants):</strong> 28-36 in (71-91 cm)</li>
                <li><strong>Shirt collar:</strong> 14-18 in (35.6-45.7 cm)</li>
                <li><strong>Belt size:</strong> Measured in inches</li>
                <li><strong>Hat size:</strong> 21-24 in circumference (53-61 cm)</li>
            </ul>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>Simple Approximation:</strong><br>
                • Multiply inches by 2.5 for rough cm<br>
                • Example: 10 in × 2.5 = 25 cm<br>
                • Actual: 10 in = 25.4 cm (very close!)<br><br>
                <strong>Reverse Approximation:</strong><br>
                • Divide cm by 2.5 for rough inches<br>
                • Example: 50 cm ÷ 2.5 = 20 in<br>
                • Actual: 50 cm = 19.685 in (close!)
            </div>

            <h3>📏 Ruler Markings</h3>
            <ul>
                <li><strong>1 inch:</strong> Divided into 16 parts (1/16 inch each)</li>
                <li><strong>Major marks:</strong> 1/2, 1/4, 1/8 inch</li>
                <li><strong>Metric ruler:</strong> Millimeters and centimeters</li>
                <li><strong>1/16 inch:</strong> ≈ 1.6 mm</li>
                <li><strong>1/8 inch:</strong> ≈ 3.2 mm</li>
                <li><strong>1/4 inch:</strong> ≈ 6.4 mm</li>
            </ul>

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
                    <tr><td>United States</td><td>Inches</td><td>Used almost exclusively</td></tr>
                    <tr><td>United Kingdom</td><td>Both</td><td>Mixed usage</td></tr>
                    <tr><td>Canada</td><td>Both</td><td>Officially metric</td></tr>
                    <tr><td>Europe</td><td>Centimeters</td><td>Metric standard</td></tr>
                    <tr><td>Asia</td><td>Centimeters</td><td>Metric standard</td></tr>
                </tbody>
            </table>

            <h3>🔧 Tool Sizes</h3>
            <ul>
                <li><strong>Wrench sizes:</strong> 1/4, 3/8, 1/2, 3/4 inch</li>
                <li><strong>Socket sets:</strong> SAE (inches) and metric (mm)</li>
                <li><strong>Drill bits:</strong> Fractional inch (1/16, 1/8, etc.)</li>
                <li><strong>Pipe sizes:</strong> Nominal inch sizes (1/2", 3/4", 1")</li>
            </ul>

            <h3>📱 Practical Examples</h3>
            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • iPhone screen: 6.1 in = 15.5 cm<br>
                • iPad: 10.2 in = 25.9 cm<br>
                • MacBook: 13.3 in = 33.8 cm<br>
                • Waist 32 in = 81.3 cm<br>
                • 24" monitor = 61 cm<br>
                • 55" TV = 140 cm
            </div>

            <h3>📐 Fractional Inches to CM</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Fraction</th>
                        <th>Decimal</th>
                        <th>Centimeters</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1/8 in</td><td>0.125 in</td><td>0.318 cm</td></tr>
                    <tr><td>1/4 in</td><td>0.25 in</td><td>0.635 cm</td></tr>
                    <tr><td>3/8 in</td><td>0.375 in</td><td>0.953 cm</td></tr>
                    <tr><td>1/2 in</td><td>0.5 in</td><td>1.27 cm</td></tr>
                    <tr><td>5/8 in</td><td>0.625 in</td><td>1.588 cm</td></tr>
                    <tr><td>3/4 in</td><td>0.75 in</td><td>1.905 cm</td></tr>
                    <tr><td>7/8 in</td><td>0.875 in</td><td>2.223 cm</td></tr>
                </tbody>
            </table>

            <h3>🏛️ Historical Context</h3>
            <p>The inch was originally defined as the width of a man's thumb. The name comes from the Latin "uncia" meaning one-twelfth (of a foot). In 1959, the inch was officially defined as exactly 2.54 centimeters through international agreement. The centimeter is part of the metric system, defined as one-hundredth of a meter.</p>

            <h3>🎯 Key Points</h3>
            <ul>
                <li><strong>Exact conversion:</strong> 1 inch = 2.54 cm (by definition)</li>
                <li><strong>1 foot:</strong> 12 inches = 30.48 cm</li>
                <li><strong>1 yard:</strong> 36 inches = 91.44 cm</li>
                <li><strong>1 meter:</strong> 39.37 inches = 100 cm</li>
                <li><strong>Screen sizes:</strong> Always measured diagonally</li>
            </ul>
        </div>

        <div class="footer">
            <p>📏 Accurate Inch ⇄ CM Conversion | Bidirectional Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for screen sizes, measurements, DIY, and everyday conversions</p>
        </div>
    </div>

    <script>
        const CM_PER_INCH = 2.54;

        function convertInches() {
            const inches = parseFloat(document.getElementById('inchInput').value);
            
            if (isNaN(inches) || inches < 0) {
                return;
            }

            const cm = inches * CM_PER_INCH;
            document.getElementById('cmInput').value = cm.toFixed(2);
            
            document.getElementById('resultValue').textContent = 
                `${inches.toFixed(2)} in = ${cm.toFixed(2)} cm`;
            
            document.getElementById('resultFormula').textContent = 
                `${inches.toFixed(2)} inches × ${CM_PER_INCH} = ${cm.toFixed(2)} cm`;
        }

        function convertCM() {
            const cm = parseFloat(document.getElementById('cmInput').value);
            
            if (isNaN(cm) || cm < 0) {
                return;
            }

            const inches = cm / CM_PER_INCH;
            document.getElementById('inchInput').value = inches.toFixed(2);
            
            document.getElementById('resultValue').textContent = 
                `${cm.toFixed(2)} cm = ${inches.toFixed(2)} in`;
            
            document.getElementById('resultFormula').textContent = 
                `${cm.toFixed(2)} cm ÷ ${CM_PER_INCH} = ${inches.toFixed(2)} inches`;
        }

        function swapUnits() {
            const inchValue = document.getElementById('inchInput').value;
            const cmValue = document.getElementById('cmInput').value;
            
            document.getElementById('inchInput').value = cmValue;
            document.getElementById('cmInput').value = inchValue;
            
            if (inchValue) convertInches();
        }

        function setInches(value) {
            document.getElementById('inchInput').value = value;
            convertInches();
        }

        // Auto-convert on input
        document.getElementById('inchInput').addEventListener('input', convertInches);
        document.getElementById('cmInput').addEventListener('input', convertCM);

        // Initial conversion
        convertInches();
    </script>
</body>
</html>