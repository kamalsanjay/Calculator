<?php
/**
 * Height Converter
 * File: conversion/height-converter.php
 * Description: Convert height between feet/inches and centimeters/meters
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Height Converter - Feet/Inches to cm/m Calculator</title>
    <meta name="description" content="Convert height between feet/inches and centimeters/meters. Perfect for measuring human height with bidirectional conversion.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 950px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: start; margin-bottom: 25px; }
        
        .input-section { }
        .section-label { font-weight: 600; color: #34495e; font-size: 1rem; margin-bottom: 15px; }
        
        .imperial-inputs { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .input-group { margin-bottom: 12px; }
        .input-group label { display: block; margin-bottom: 6px; font-weight: 500; color: #555; font-size: 0.9rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 12px 50px 12px 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.05rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .unit-label { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #667eea; font-weight: 600; font-size: 0.9rem; }
        
        .swap-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; margin-top: 30px; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-box { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #667eea; margin-bottom: 25px; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.2rem; font-weight: bold; color: #667eea; margin-bottom: 10px; }
        .result-breakdown { background: white; padding: 15px; border-radius: 8px; font-size: 0.95rem; color: #555; }
        .result-breakdown div { margin-bottom: 6px; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #667eea; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15); }
        .quick-value { font-weight: bold; color: #667eea; font-size: 1rem; }
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
        .conversion-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .converter-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .imperial-inputs { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .result-value { font-size: 1.8rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📏 Height Converter</h1>
            <p>Convert height between feet/inches and centimeters/meters with bidirectional conversion</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-section">
                    <div class="section-label">Imperial (Feet & Inches)</div>
                    <div class="imperial-inputs">
                        <div class="input-group">
                            <label for="feetInput">Feet</label>
                            <div class="input-wrapper">
                                <input type="number" id="feetInput" placeholder="0" min="0" max="9" step="1" value="5">
                                <span class="unit-label">ft</span>
                            </div>
                        </div>
                        <div class="input-group">
                            <label for="inchesInput">Inches</label>
                            <div class="input-wrapper">
                                <input type="number" id="inchesInput" placeholder="0" min="0" max="11.99" step="0.1" value="10">
                                <span class="unit-label">in</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-section">
                    <div class="section-label">Metric (Centimeters)</div>
                    <div class="input-group">
                        <label for="cmInput">Centimeters</label>
                        <div class="input-wrapper">
                            <input type="number" id="cmInput" placeholder="0" min="0" step="0.1">
                            <span class="unit-label">cm</span>
                        </div>
                    </div>
                    <div class="input-group" style="margin-top: 12px;">
                        <label for="metersInput">Meters</label>
                        <div class="input-wrapper">
                            <input type="number" id="metersInput" placeholder="0" min="0" step="0.01">
                            <span class="unit-label">m</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="result-box">
                <div class="result-label">Conversion Result</div>
                <div class="result-value" id="resultValue">5'10" = 177.8 cm</div>
                <div class="result-breakdown" id="resultBreakdown">
                    <div><strong>Imperial:</strong> 5 feet 10 inches</div>
                    <div><strong>Metric:</strong> 177.8 cm = 1.778 m</div>
                    <div><strong>Total Inches:</strong> 70 inches</div>
                </div>
            </div>

            <div class="quick-convert">
                <h3>👤 Common Heights</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setHeight(5, 0)">
                        <div class="quick-value">5'0"</div>
                        <div class="quick-label">152.4 cm</div>
                    </div>
                    <div class="quick-btn" onclick="setHeight(5, 6)">
                        <div class="quick-value">5'6"</div>
                        <div class="quick-label">167.6 cm</div>
                    </div>
                    <div class="quick-btn" onclick="setHeight(5, 10)">
                        <div class="quick-value">5'10"</div>
                        <div class="quick-label">177.8 cm</div>
                    </div>
                    <div class="quick-btn" onclick="setHeight(6, 0)">
                        <div class="quick-value">6'0"</div>
                        <div class="quick-label">182.9 cm</div>
                    </div>
                    <div class="quick-btn" onclick="setHeight(6, 6)">
                        <div class="quick-value">6'6"</div>
                        <div class="quick-label">198.1 cm</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>📏 Height Conversion Guide</h2>
            
            <p><strong>Height</strong> is commonly measured in feet and inches in the United States, while most of the world uses centimeters and meters.</p>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>Feet/Inches to Centimeters:</strong><br>
                • Total inches = (Feet × 12) + Inches<br>
                • Centimeters = Total inches × 2.54<br><br>
                <strong>Centimeters to Feet/Inches:</strong><br>
                • Total inches = Centimeters ÷ 2.54<br>
                • Feet = Total inches ÷ 12 (whole number)<br>
                • Inches = Remainder from division
            </div>

            <h3>📊 Height Comparison Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Feet & Inches</th>
                        <th>Total Inches</th>
                        <th>Centimeters</th>
                        <th>Meters</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>4'0"</td><td>48"</td><td>121.9 cm</td><td>1.22 m</td></tr>
                    <tr><td>4'6"</td><td>54"</td><td>137.2 cm</td><td>1.37 m</td></tr>
                    <tr><td>5'0"</td><td>60"</td><td>152.4 cm</td><td>1.52 m</td></tr>
                    <tr><td>5'3"</td><td>63"</td><td>160.0 cm</td><td>1.60 m</td></tr>
                    <tr><td>5'6"</td><td>66"</td><td>167.6 cm</td><td>1.68 m</td></tr>
                    <tr><td>5'9"</td><td>69"</td><td>175.3 cm</td><td>1.75 m</td></tr>
                    <tr><td>6'0"</td><td>72"</td><td>182.9 cm</td><td>1.83 m</td></tr>
                    <tr><td>6'3"</td><td>75"</td><td>190.5 cm</td><td>1.91 m</td></tr>
                    <tr><td>6'6"</td><td>78"</td><td>198.1 cm</td><td>1.98 m</td></tr>
                    <tr><td>7'0"</td><td>84"</td><td>213.4 cm</td><td>2.13 m</td></tr>
                </tbody>
            </table>

            <h3>👨 Average Adult Male Heights</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Country/Region</th>
                        <th>Average Height</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Netherlands</td><td>6'0" (183 cm)</td></tr>
                    <tr><td>Denmark</td><td>5'11" (181 cm)</td></tr>
                    <tr><td>Germany</td><td>5'11" (180 cm)</td></tr>
                    <tr><td>United States</td><td>5'9" (175 cm)</td></tr>
                    <tr><td>United Kingdom</td><td>5'9" (175 cm)</td></tr>
                    <tr><td>Canada</td><td>5'9" (175 cm)</td></tr>
                    <tr><td>Australia</td><td>5'10" (178 cm)</td></tr>
                    <tr><td>China</td><td>5'7" (171 cm)</td></tr>
                    <tr><td>Japan</td><td>5'7" (172 cm)</td></tr>
                    <tr><td>India</td><td>5'5" (165 cm)</td></tr>
                </tbody>
            </table>

            <h3>👩 Average Adult Female Heights</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Country/Region</th>
                        <th>Average Height</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Netherlands</td><td>5'7" (170 cm)</td></tr>
                    <tr><td>Denmark</td><td>5'6" (168 cm)</td></tr>
                    <tr><td>Germany</td><td>5'6" (166 cm)</td></tr>
                    <tr><td>United States</td><td>5'4" (162 cm)</td></tr>
                    <tr><td>United Kingdom</td><td>5'3" (161 cm)</td></tr>
                    <tr><td>Canada</td><td>5'4" (163 cm)</td></tr>
                    <tr><td>Australia</td><td>5'5" (165 cm)</td></tr>
                    <tr><td>China</td><td>5'3" (159 cm)</td></tr>
                    <tr><td>Japan</td><td>5'2" (158 cm)</td></tr>
                    <tr><td>India</td><td>5'0" (152 cm)</td></tr>
                </tbody>
            </table>

            <h3>👶 Children's Average Heights by Age</h3>
            <div class="formula-box">
                <strong>Boys:</strong><br>
                • Age 2: 2'10" (86 cm)<br>
                • Age 5: 3'7" (109 cm)<br>
                • Age 10: 4'6" (138 cm)<br>
                • Age 15: 5'7" (170 cm)<br>
                • Age 18: 5'9" (175 cm)<br><br>
                <strong>Girls:</strong><br>
                • Age 2: 2'9" (85 cm)<br>
                • Age 5: 3'6" (107 cm)<br>
                • Age 10: 4'6" (138 cm)<br>
                • Age 15: 5'4" (163 cm)<br>
                • Age 18: 5'4" (163 cm)
            </div>

            <h3>🏀 Sports & Height</h3>
            <ul>
                <li><strong>NBA average:</strong> 6'6" (198 cm)</li>
                <li><strong>WNBA average:</strong> 6'0" (183 cm)</li>
                <li><strong>NFL average:</strong> 6'2" (188 cm)</li>
                <li><strong>MLB average:</strong> 6'1" (185 cm)</li>
                <li><strong>Olympic gymnasts (female):</strong> 5'0"-5'4" (152-163 cm)</li>
                <li><strong>Jockeys:</strong> 5'0"-5'6" (152-168 cm)</li>
            </ul>

            <h3>📐 Height Categories</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Men</th>
                        <th>Women</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Very Short</td><td>< 5'4" (163 cm)</td><td>< 4'11" (150 cm)</td></tr>
                    <tr><td>Short</td><td>5'4"-5'7" (163-170 cm)</td><td>4'11"-5'2" (150-157 cm)</td></tr>
                    <tr><td>Average</td><td>5'8"-5'11" (173-180 cm)</td><td>5'3"-5'6" (160-168 cm)</td></tr>
                    <tr><td>Tall</td><td>6'0"-6'3" (183-191 cm)</td><td>5'7"-5'10" (170-178 cm)</td></tr>
                    <tr><td>Very Tall</td><td>> 6'3" (191 cm)</td><td>> 5'10" (178 cm)</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>Feet/Inches to CM (Rough):</strong><br>
                • 5 feet = ~150 cm<br>
                • Add 2.5 cm per inch<br>
                • Example: 5'10" = 150 + (10 × 2.5) = 175 cm<br>
                • Actual: 177.8 cm (close!)<br><br>
                <strong>CM to Feet (Rough):</strong><br>
                • Divide cm by 30 for approximate feet<br>
                • Example: 180 cm ÷ 30 = 6 feet<br>
                • Actual: 5'11" (close!)
            </div>

            <h3>🌍 Global Height Trends</h3>
            <ul>
                <li><strong>Tallest populations:</strong> Netherlands, Denmark, Norway</li>
                <li><strong>Average increase:</strong> ~1 cm per decade (20th century)</li>
                <li><strong>Factors:</strong> Nutrition, healthcare, genetics</li>
                <li><strong>Height plateau:</strong> Some countries reaching genetic limits</li>
            </ul>

            <h3>🏥 Medical Height Measurements</h3>
            <div class="formula-box">
                <strong>Medical Standards:</strong><br>
                • Measured without shoes<br>
                • Standing straight, heels together<br>
                • Head level (Frankfort plane)<br>
                • Morning height ~1 cm taller (spine compression)<br>
                • Growth charts use cm in most countries<br>
                • Percentiles track child development
            </div>

            <h3>🎯 Interesting Height Facts</h3>
            <ul>
                <li><strong>Tallest person ever:</strong> Robert Wadlow - 8'11" (272 cm)</li>
                <li><strong>Shortest adult:</strong> Chandra Bahadur Dangi - 1'9.5" (54.6 cm)</li>
                <li><strong>Height loss with age:</strong> ~1-2 inches (2.5-5 cm) from 30 to 80</li>
                <li><strong>Morning vs evening:</strong> ~0.5-1 inch (1-2.5 cm) difference</li>
                <li><strong>Space height gain:</strong> Astronauts grow ~2 inches (5 cm) temporarily</li>
            </ul>

            <h3>📏 Measurement Tips</h3>
            <ul>
                <li><strong>Time of day:</strong> Measure in morning for maximum height</li>
                <li><strong>Remove shoes:</strong> Always measure barefoot</li>
                <li><strong>Stand straight:</strong> Heels, buttocks, shoulders touch wall</li>
                <li><strong>Look forward:</strong> Eyes level with horizon</li>
                <li><strong>Mark carefully:</strong> Use flat object on top of head</li>
            </ul>

            <h3>🏛️ Historical Context</h3>
            <p>The foot measurement dates back to ancient civilizations, originally based on the actual length of a human foot. In 1959, the international foot was defined as exactly 0.3048 meters. The inch, originally the width of a thumb, became standardized as 2.54 centimeters. Most countries now use the metric system for height, though the United States, United Kingdom, and some Commonwealth nations still commonly use feet and inches.</p>
        </div>

        <div class="footer">
            <p>📏 Accurate Height Conversion | Feet/Inches ⇄ CM/Meters</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for medical records, travel documents, sports, and everyday use</p>
        </div>
    </div>

    <script>
        const CM_PER_INCH = 2.54;
        const INCHES_PER_FOOT = 12;

        function convertFromImperial() {
            const feet = parseFloat(document.getElementById('feetInput').value) || 0;
            const inches = parseFloat(document.getElementById('inchesInput').value) || 0;
            
            const totalInches = (feet * INCHES_PER_FOOT) + inches;
            const cm = totalInches * CM_PER_INCH;
            const meters = cm / 100;
            
            document.getElementById('cmInput').value = cm.toFixed(1);
            document.getElementById('metersInput').value = meters.toFixed(3);
            
            updateResult(feet, inches, cm, meters, totalInches);
        }

        function convertFromMetric() {
            const cm = parseFloat(document.getElementById('cmInput').value) || 0;
            
            const totalInches = cm / CM_PER_INCH;
            const feet = Math.floor(totalInches / INCHES_PER_FOOT);
            const inches = totalInches % INCHES_PER_FOOT;
            const meters = cm / 100;
            
            document.getElementById('feetInput').value = feet;
            document.getElementById('inchesInput').value = inches.toFixed(1);
            document.getElementById('metersInput').value = meters.toFixed(3);
            
            updateResult(feet, inches, cm, meters, totalInches);
        }

        function convertFromMeters() {
            const meters = parseFloat(document.getElementById('metersInput').value) || 0;
            const cm = meters * 100;
            
            document.getElementById('cmInput').value = cm.toFixed(1);
            convertFromMetric();
        }

        function updateResult(feet, inches, cm, meters, totalInches) {
            const feetInt = Math.floor(feet);
            const inchesRounded = Math.round(inches * 10) / 10;
            
            document.getElementById('resultValue').textContent = 
                `${feetInt}'${inchesRounded}" = ${cm.toFixed(1)} cm`;
            
            document.getElementById('resultBreakdown').innerHTML = `
                <div><strong>Imperial:</strong> ${feetInt} feet ${inchesRounded} inches</div>
                <div><strong>Metric:</strong> ${cm.toFixed(1)} cm = ${meters.toFixed(3)} m</div>
                <div><strong>Total Inches:</strong> ${totalInches.toFixed(1)} inches</div>
            `;
        }

        function swapUnits() {
            // Not really needed for height, but kept for consistency
            convertFromImperial();
        }

        function setHeight(feet, inches) {
            document.getElementById('feetInput').value = feet;
            document.getElementById('inchesInput').value = inches;
            convertFromImperial();
        }

        // Auto-convert on input
        document.getElementById('feetInput').addEventListener('input', convertFromImperial);
        document.getElementById('inchesInput').addEventListener('input', convertFromImperial);
        document.getElementById('cmInput').addEventListener('input', convertFromMetric);
        document.getElementById('metersInput').addEventListener('input', convertFromMeters);

        // Initial conversion
        convertFromImperial();
    </script>
</body>
</html>