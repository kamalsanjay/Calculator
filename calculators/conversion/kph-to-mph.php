<?php
/**
 * KPH to MPH Converter
 * File: conversion/kph-to-mph.php
 * Description: Convert kilometers per hour to miles per hour and vice versa
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPH to MPH Converter - km/h to mph Calculator</title>
    <meta name="description" content="Convert kilometers per hour (km/h) to miles per hour (mph) and vice versa. Bidirectional speed converter for driving and travel.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #f953c6 0%, #b91d73 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 900px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 80px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #f953c6; box-shadow: 0 0 0 3px rgba(249, 83, 198, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #f953c6; font-weight: 600; font-size: 0.95rem; }
        
        .swap-btn { background: linear-gradient(135deg, #f953c6 0%, #b91d73 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-box { background: linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #f953c6; margin-bottom: 25px; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.5rem; font-weight: bold; color: #b91d73; margin-bottom: 10px; }
        .result-formula { background: white; padding: 15px; border-radius: 8px; font-family: 'Courier New', monospace; color: #555; font-size: 0.9rem; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #f953c6; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(249, 83, 198, 0.15); }
        .quick-value { font-weight: bold; color: #f953c6; font-size: 1.1rem; }
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
        
        .formula-box { background: #fce4ec; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #f953c6; }
        .formula-box strong { color: #f953c6; }
        
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
            <h1>🚗 KPH ⇄ MPH Converter</h1>
            <p>Convert between kilometers per hour and miles per hour with bidirectional conversion</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="kphInput">Kilometers per Hour</label>
                    <div class="input-wrapper">
                        <input type="number" id="kphInput" placeholder="Enter km/h" step="0.1" min="0" value="100">
                        <span class="unit-label">km/h</span>
                    </div>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="mphInput">Miles per Hour</label>
                    <div class="input-wrapper">
                        <input type="number" id="mphInput" placeholder="Enter mph" step="0.1" min="0">
                        <span class="unit-label">mph</span>
                    </div>
                </div>
            </div>

            <div class="result-box">
                <div class="result-label">Result</div>
                <div class="result-value" id="resultValue">100 km/h = 62.14 mph</div>
                <div class="result-formula" id="resultFormula">100 km/h ÷ 1.60934 = 62.14 mph</div>
            </div>

            <div class="quick-convert">
                <h3>🚗 Common Speeds</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setKph(50)">
                        <div class="quick-value">50 km/h</div>
                        <div class="quick-label">City Speed</div>
                    </div>
                    <div class="quick-btn" onclick="setKph(80)">
                        <div class="quick-value">80 km/h</div>
                        <div class="quick-label">Highway</div>
                    </div>
                    <div class="quick-btn" onclick="setKph(100)">
                        <div class="quick-value">100 km/h</div>
                        <div class="quick-label">Motorway</div>
                    </div>
                    <div class="quick-btn" onclick="setKph(120)">
                        <div class="quick-value">120 km/h</div>
                        <div class="quick-label">Fast Highway</div>
                    </div>
                    <div class="quick-btn" onclick="setKph(200)">
                        <div class="quick-value">200 km/h</div>
                        <div class="quick-label">High Speed</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🚗 KPH to MPH Conversion Guide</h2>
            
            <p><strong>Kilometers per hour (km/h)</strong> is the metric unit for speed, while <strong>miles per hour (mph)</strong> is used primarily in the United States and United Kingdom.</p>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>KPH to MPH:</strong><br>
                • Miles per Hour = KPH ÷ 1.60934<br>
                • Or: MPH = KPH × 0.621371<br>
                • 1 km/h = 0.621371 mph<br><br>
                <strong>MPH to KPH:</strong><br>
                • Kilometers per Hour = MPH × 1.60934<br>
                • 1 mph = 1.60934 km/h
            </div>

            <h3>📊 Speed Comparison Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>KM/H</th>
                        <th>MPH</th>
                        <th>Common Speed Limit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>30 km/h</td><td>18.6 mph</td><td>Residential zone</td></tr>
                    <tr><td>50 km/h</td><td>31.1 mph</td><td>City streets</td></tr>
                    <tr><td>60 km/h</td><td>37.3 mph</td><td>Urban roads</td></tr>
                    <tr><td>80 km/h</td><td>49.7 mph</td><td>Rural roads</td></tr>
                    <tr><td>90 km/h</td><td>55.9 mph</td><td>Highway</td></tr>
                    <tr><td>100 km/h</td><td>62.1 mph</td><td>Motorway</td></tr>
                    <tr><td>120 km/h</td><td>74.6 mph</td><td>Fast highway</td></tr>
                    <tr><td>130 km/h</td><td>80.8 mph</td><td>European motorway</td></tr>
                </tbody>
            </table>

            <h3>🌍 Speed Limits by Country</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Urban</th>
                        <th>Highway</th>
                        <th>Motorway</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>USA</td><td>25-35 mph</td><td>55-70 mph</td><td>65-85 mph</td></tr>
                    <tr><td>UK</td><td>30 mph</td><td>60 mph</td><td>70 mph</td></tr>
                    <tr><td>Germany</td><td>50 km/h</td><td>100 km/h</td><td>No limit*</td></tr>
                    <tr><td>France</td><td>50 km/h</td><td>80 km/h</td><td>130 km/h</td></tr>
                    <tr><td>Canada</td><td>50 km/h</td><td>80-90 km/h</td><td>100-110 km/h</td></tr>
                    <tr><td>Australia</td><td>50 km/h</td><td>100 km/h</td><td>110 km/h</td></tr>
                    <tr><td>Japan</td><td>40 km/h</td><td>60 km/h</td><td>100 km/h</td></tr>
                    <tr><td>Italy</td><td>50 km/h</td><td>90 km/h</td><td>130 km/h</td></tr>
                </tbody>
            </table>
            <p style="font-size: 0.85rem; color: #777;">*Germany's Autobahn has advisory speed of 130 km/h (81 mph)</p>

            <h3>🚙 Vehicle Speeds</h3>
            <ul>
                <li><strong>Walking speed:</strong> 5 km/h (3.1 mph)</li>
                <li><strong>Bicycle (casual):</strong> 15-20 km/h (9-12 mph)</li>
                <li><strong>Bicycle (racing):</strong> 40-50 km/h (25-31 mph)</li>
                <li><strong>School zone:</strong> 25-40 km/h (15-25 mph)</li>
                <li><strong>City driving:</strong> 50-60 km/h (31-37 mph)</li>
                <li><strong>Highway cruising:</strong> 100-120 km/h (62-75 mph)</li>
                <li><strong>Sports car (top speed):</strong> 250-350 km/h (155-217 mph)</li>
            </ul>

            <h3>🏎️ Racing Speeds</h3>
            <div class="formula-box">
                <strong>Motorsports:</strong><br>
                • Formula 1 (average): 200-230 km/h (124-143 mph)<br>
                • Formula 1 (top speed): 350+ km/h (217+ mph)<br>
                • NASCAR (average): 200-240 km/h (124-149 mph)<br>
                • MotoGP (top speed): 350+ km/h (217+ mph)<br>
                • IndyCar (average): 320+ km/h (199+ mph)<br>
                • Drag racing (top fuel): 530+ km/h (329+ mph)
            </div>

            <h3>🚄 Train Speeds</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Train Type</th>
                        <th>KM/H</th>
                        <th>MPH</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Regional train</td><td>120-160 km/h</td><td>75-99 mph</td></tr>
                    <tr><td>Intercity train</td><td>160-200 km/h</td><td>99-124 mph</td></tr>
                    <tr><td>High-speed (Europe)</td><td>250-320 km/h</td><td>155-199 mph</td></tr>
                    <tr><td>Japanese Shinkansen</td><td>285-320 km/h</td><td>177-199 mph</td></tr>
                    <tr><td>Chinese CRH</td><td>350 km/h</td><td>217 mph</td></tr>
                    <tr><td>Maglev (Shanghai)</td><td>430 km/h</td><td>267 mph</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>KPH to MPH (Easy):</strong><br>
                • Divide by 1.6 (or multiply by 0.6)<br>
                • Example: 100 km/h ÷ 1.6 ≈ 62.5 mph<br>
                • Actual: 100 km/h = 62.14 mph (very close!)<br><br>
                <strong>MPH to KPH (Easy):</strong><br>
                • Multiply by 1.6<br>
                • Example: 60 mph × 1.6 = 96 km/h<br>
                • Actual: 60 mph = 96.56 km/h (close!)
            </div>

            <h3>🛣️ US Interstate Speed Limits</h3>
            <ul>
                <li><strong>Urban interstates:</strong> 55-65 mph (89-105 km/h)</li>
                <li><strong>Rural interstates:</strong> 65-80 mph (105-129 km/h)</li>
                <li><strong>Texas (rural):</strong> 80-85 mph (129-137 km/h)</li>
                <li><strong>Montana (day):</strong> 80 mph (129 km/h)</li>
                <li><strong>School zones:</strong> 15-25 mph (24-40 km/h)</li>
            </ul>

            <h3>🌎 Metric vs Imperial Usage</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Region</th>
                        <th>Primary Unit</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>United States</td><td>MPH</td><td>Only major country using mph</td></tr>
                    <tr><td>United Kingdom</td><td>MPH</td><td>Uses mph despite metric system</td></tr>
                    <tr><td>Canada</td><td>KM/H</td><td>Officially metric since 1977</td></tr>
                    <tr><td>Australia</td><td>KM/H</td><td>Metric system</td></tr>
                    <tr><td>Europe</td><td>KM/H</td><td>All countries use km/h</td></tr>
                    <tr><td>Asia</td><td>KM/H</td><td>Metric standard</td></tr>
                </tbody>
            </table>

            <h3>🚦 Traffic & Safety</h3>
            <ul>
                <li><strong>Stopping distance doubles:</strong> When speed increases from 50 to 70 km/h</li>
                <li><strong>Reaction time:</strong> ~1 second at any speed</li>
                <li><strong>At 100 km/h:</strong> Travel 28 meters per second</li>
                <li><strong>At 60 mph:</strong> Travel 88 feet per second</li>
                <li><strong>Fatal crash risk:</strong> Doubles for every 10 km/h over 60 km/h</li>
            </ul>

            <h3>📱 GPS & Navigation</h3>
            <div class="formula-box">
                <strong>Navigation Systems:</strong><br>
                • Can display either km/h or mph<br>
                • Settings changeable in most devices<br>
                • Real-time speed monitoring<br>
                • Speed limit warnings<br>
                • Average speed calculations
            </div>

            <h3>🏁 Speed Records</h3>
            <ul>
                <li><strong>Land speed record:</strong> 1,228 km/h (763 mph)</li>
                <li><strong>Production car record:</strong> 490+ km/h (304+ mph)</li>
                <li><strong>Fastest motorcycle:</strong> 605 km/h (376 mph)</li>
                <li><strong>Bullet train record:</strong> 603 km/h (375 mph)</li>
                <li><strong>Commercial airliner:</strong> 900-950 km/h (560-590 mph)</li>
            </ul>

            <h3>🎯 Practical Examples</h3>
            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • 30 km/h = 18.6 mph (school zone)<br>
                • 50 km/h = 31.1 mph (city limit)<br>
                • 80 km/h = 49.7 mph (highway)<br>
                • 100 km/h = 62.1 mph (motorway)<br>
                • 120 km/h = 74.6 mph (fast highway)<br>
                • 200 km/h = 124.3 mph (race track)
            </div>

            <h3>🚨 Speeding Fines</h3>
            <p>Speeding penalties vary by jurisdiction but typically increase with the amount over the limit:</p>
            <ul>
                <li><strong>1-10 over:</strong> Warning or small fine</li>
                <li><strong>11-20 over:</strong> Moderate fine</li>
                <li><strong>21-30 over:</strong> Heavy fine + points</li>
                <li><strong>31+ over:</strong> Severe fine + suspension possible</li>
            </ul>

            <h3>🏛️ Historical Context</h3>
            <p>The <strong>kilometer</strong> comes from the Greek "khilioi" (thousand) and French "mètre." The <strong>mile</strong> derives from the Latin "mille passus" (thousand paces). Most countries adopted the metric system in the 19th-20th centuries, but the US and UK retained miles for road distances.</p>

            <h3>🔑 Key Conversions</h3>
            <ul>
                <li><strong>1 km/h = 0.621371 mph</strong></li>
                <li><strong>1 mph = 1.60934 km/h</strong></li>
                <li><strong>100 km/h ≈ 62 mph</strong> (easy to remember)</li>
                <li><strong>60 mph ≈ 96.5 km/h</strong></li>
                <li><strong>1 km = 0.621371 miles</strong></li>
            </ul>

            <h3>🌟 Fun Facts</h3>
            <ul>
                <li><strong>Fastest human (Usain Bolt):</strong> 44.72 km/h (27.8 mph)</li>
                <li><strong>Cheetah top speed:</strong> 110-120 km/h (68-75 mph)</li>
                <li><strong>Sound speed (sea level):</strong> 1,235 km/h (767 mph)</li>
                <li><strong>Earth's rotation (equator):</strong> 1,674 km/h (1,040 mph)</li>
            </ul>
        </div>

        <div class="footer">
            <p>🚗 Accurate KPH ⇄ MPH Conversion | Bidirectional Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for driving, travel, speed limits, and road trips</p>
        </div>
    </div>

    <script>
        const KM_PER_MILE = 1.60934;

        function convertKph() {
            const kph = parseFloat(document.getElementById('kphInput').value);
            
            if (isNaN(kph) || kph < 0) {
                return;
            }

            const mph = kph / KM_PER_MILE;
            document.getElementById('mphInput').value = mph.toFixed(2);
            
            document.getElementById('resultValue').textContent = 
                `${kph.toFixed(2)} km/h = ${mph.toFixed(2)} mph`;
            
            document.getElementById('resultFormula').textContent = 
                `${kph.toFixed(2)} km/h ÷ ${KM_PER_MILE.toFixed(5)} = ${mph.toFixed(2)} mph`;
        }

        function convertMph() {
            const mph = parseFloat(document.getElementById('mphInput').value);
            
            if (isNaN(mph) || mph < 0) {
                return;
            }

            const kph = mph * KM_PER_MILE;
            document.getElementById('kphInput').value = kph.toFixed(2);
            
            document.getElementById('resultValue').textContent = 
                `${mph.toFixed(2)} mph = ${kph.toFixed(2)} km/h`;
            
            document.getElementById('resultFormula').textContent = 
                `${mph.toFixed(2)} mph × ${KM_PER_MILE.toFixed(5)} = ${kph.toFixed(2)} km/h`;
        }

        function swapUnits() {
            const kphValue = document.getElementById('kphInput').value;
            const mphValue = document.getElementById('mphInput').value;
            
            document.getElementById('kphInput').value = mphValue;
            document.getElementById('mphInput').value = kphValue;
            
            if (kphValue) convertKph();
        }

        function setKph(value) {
            document.getElementById('kphInput').value = value;
            convertKph();
        }

        // Auto-convert on input
        document.getElementById('kphInput').addEventListener('input', convertKph);
        document.getElementById('mphInput').addEventListener('input', convertMph);

        // Initial conversion
        convertKph();
    </script>
</body>
</html>