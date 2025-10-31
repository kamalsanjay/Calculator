<?php
/**
 * MPH to KPH Converter
 * File: conversion/mph-to-kph.php
 * Description: Convert miles per hour to kilometers per hour and vice versa
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MPH to KPH Converter - Miles per Hour to km/h Calculator</title>
    <meta name="description" content="Convert miles per hour (mph) to kilometers per hour (km/h) and vice versa. Bidirectional speed converter for driving and travel.">
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
        
        .result-box { background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #f953c6; margin-bottom: 25px; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.5rem; font-weight: bold; color: #d84315; margin-bottom: 10px; }
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
        .conversion-table tr:hover { background: #fff3e0; }
        
        .formula-box { background: #fff3e0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #f953c6; }
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
            <h1>🚗 MPH ⇄ KPH Converter</h1>
            <p>Convert between miles per hour and kilometers per hour with bidirectional conversion</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="mphInput">Miles per Hour</label>
                    <div class="input-wrapper">
                        <input type="number" id="mphInput" placeholder="Enter mph" step="0.1" min="0" value="60">
                        <span class="unit-label">mph</span>
                    </div>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="kphInput">Kilometers per Hour</label>
                    <div class="input-wrapper">
                        <input type="number" id="kphInput" placeholder="Enter km/h" step="0.1" min="0">
                        <span class="unit-label">km/h</span>
                    </div>
                </div>
            </div>

            <div class="result-box">
                <div class="result-label">Result</div>
                <div class="result-value" id="resultValue">60 mph = 96.56 km/h</div>
                <div class="result-formula" id="resultFormula">60 mph × 1.60934 = 96.56 km/h</div>
            </div>

            <div class="quick-convert">
                <h3>🚗 Common Speeds</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setMph(25)">
                        <div class="quick-value">25 mph</div>
                        <div class="quick-label">City Speed</div>
                    </div>
                    <div class="quick-btn" onclick="setMph(55)">
                        <div class="quick-value">55 mph</div>
                        <div class="quick-label">Highway</div>
                    </div>
                    <div class="quick-btn" onclick="setMph(65)">
                        <div class="quick-value">65 mph</div>
                        <div class="quick-label">Interstate</div>
                    </div>
                    <div class="quick-btn" onclick="setMph(70)">
                        <div class="quick-value">70 mph</div>
                        <div class="quick-label">UK Motorway</div>
                    </div>
                    <div class="quick-btn" onclick="setMph(100)">
                        <div class="quick-value">100 mph</div>
                        <div class="quick-label">High Speed</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🚗 MPH to KPH Conversion Guide</h2>
            
            <p><strong>Miles per hour (mph)</strong> is used primarily in the United States and United Kingdom, while <strong>kilometers per hour (km/h)</strong> is the metric standard used worldwide.</p>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>MPH to KPH:</strong><br>
                • Kilometers per Hour = MPH × 1.60934<br>
                • 1 mph = 1.60934 km/h<br><br>
                <strong>KPH to MPH:</strong><br>
                • Miles per Hour = KPH ÷ 1.60934<br>
                • 1 km/h = 0.621371 mph
            </div>

            <h3>📊 Speed Comparison Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>MPH</th>
                        <th>KM/H</th>
                        <th>Common Speed Limit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>15 mph</td><td>24.1 km/h</td><td>School zone</td></tr>
                    <tr><td>25 mph</td><td>40.2 km/h</td><td>Residential</td></tr>
                    <tr><td>35 mph</td><td>56.3 km/h</td><td>City streets</td></tr>
                    <tr><td>45 mph</td><td>72.4 km/h</td><td>Main roads</td></tr>
                    <tr><td>55 mph</td><td>88.5 km/h</td><td>Highway</td></tr>
                    <tr><td>65 mph</td><td>104.6 km/h</td><td>Interstate</td></tr>
                    <tr><td>70 mph</td><td>112.7 km/h</td><td>UK motorway</td></tr>
                    <tr><td>80 mph</td><td>128.7 km/h</td><td>High-speed limit</td></tr>
                </tbody>
            </table>

            <h3>🌍 Speed Limits by Region</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Urban</th>
                        <th>Highway</th>
                        <th>Motorway</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>USA (mph)</td><td>25-35</td><td>55-70</td><td>65-85</td></tr>
                    <tr><td>USA (km/h)</td><td>40-56</td><td>89-113</td><td>105-137</td></tr>
                    <tr><td>UK (mph)</td><td>30</td><td>60</td><td>70</td></tr>
                    <tr><td>UK (km/h)</td><td>48</td><td>97</td><td>113</td></tr>
                    <tr><td>Canada</td><td>50 km/h</td><td>80-90 km/h</td><td>100-110 km/h</td></tr>
                    <tr><td>Europe</td><td>50 km/h</td><td>90-100 km/h</td><td>120-130 km/h</td></tr>
                </tbody>
            </table>

            <h3>🏁 Racing Speeds</h3>
            <ul>
                <li><strong>NASCAR average:</strong> 160-180 mph (257-290 km/h)</li>
                <li><strong>Formula 1 average:</strong> 130-150 mph (209-241 km/h)</li>
                <li><strong>Formula 1 top speed:</strong> 220+ mph (354+ km/h)</li>
                <li><strong>IndyCar average:</strong> 200+ mph (322+ km/h)</li>
                <li><strong>MotoGP top speed:</strong> 220+ mph (354+ km/h)</li>
            </ul>

            <h3>🚙 Vehicle Performance</h3>
            <div class="formula-box">
                <strong>0-60 mph Performance:</strong><br>
                • Economy car: 10-12 seconds<br>
                • Family sedan: 7-9 seconds<br>
                • Sports sedan: 5-7 seconds<br>
                • Sports car: 3-5 seconds<br>
                • Supercar: < 3 seconds<br><br>
                <strong>Note:</strong> 0-60 mph = 0-96.6 km/h
            </div>

            <h3>✈️ Aircraft Speeds</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Aircraft Type</th>
                        <th>Speed (mph)</th>
                        <th>Speed (km/h)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Cessna (small plane)</td><td>120-150 mph</td><td>193-241 km/h</td></tr>
                    <tr><td>Regional jet</td><td>300-400 mph</td><td>483-644 km/h</td></tr>
                    <tr><td>Commercial airliner</td><td>500-600 mph</td><td>805-966 km/h</td></tr>
                    <tr><td>Fighter jet</td><td>1,200-1,500 mph</td><td>1,931-2,414 km/h</td></tr>
                    <tr><td>Concorde (retired)</td><td>1,350 mph</td><td>2,173 km/h</td></tr>
                </tbody>
            </table>

            <h3>🚆 Train Speeds</h3>
            <ul>
                <li><strong>Conventional train:</strong> 80-110 mph (129-177 km/h)</li>
                <li><strong>High-speed rail:</strong> 155-200 mph (250-322 km/h)</li>
                <li><strong>Japanese Shinkansen:</strong> 200 mph (320 km/h)</li>
                <li><strong>Maglev (Shanghai):</strong> 268 mph (431 km/h)</li>
            </ul>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>MPH to KPH (Easy):</strong><br>
                • Multiply mph by 1.6<br>
                • Example: 60 mph × 1.6 = 96 km/h<br>
                • Actual: 60 mph = 96.56 km/h (very close!)<br><br>
                <strong>KPH to MPH (Easy):</strong><br>
                • Multiply km/h by 0.6<br>
                • Example: 100 km/h × 0.6 = 60 mph<br>
                • Actual: 100 km/h = 62.14 mph (close!)
            </div>

            <h3>🚓 Police Chase & Pursuit</h3>
            <ul>
                <li><strong>Standard patrol:</strong> Up to 120-140 mph (193-225 km/h)</li>
                <li><strong>Highway pursuit:</strong> 100-130 mph (161-209 km/h)</li>
                <li><strong>Helicopter pursuit:</strong> 120-150 mph (193-241 km/h)</li>
            </ul>

            <h3>🏍️ Motorcycle Speeds</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Top Speed (mph)</th>
                        <th>Top Speed (km/h)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Scooter</td><td>30-60 mph</td><td>48-97 km/h</td></tr>
                    <tr><td>Cruiser</td><td>100-120 mph</td><td>161-193 km/h</td></tr>
                    <tr><td>Sport bike</td><td>160-200 mph</td><td>257-322 km/h</td></tr>
                    <tr><td>Superbike</td><td>180-220 mph</td><td>290-354 km/h</td></tr>
                </tbody>
            </table>

            <h3>🌪️ Wind & Weather</h3>
            <div class="formula-box">
                <strong>Wind Speeds:</strong><br>
                • Light breeze: 5-10 mph (8-16 km/h)<br>
                • Moderate wind: 15-25 mph (24-40 km/h)<br>
                • Strong wind: 30-40 mph (48-64 km/h)<br>
                • Hurricane Cat 1: 74-95 mph (119-153 km/h)<br>
                • Hurricane Cat 5: 157+ mph (252+ km/h)<br>
                • Tornado: 100-300 mph (161-483 km/h)
            </div>

            <h3>🚤 Water Craft</h3>
            <ul>
                <li><strong>Sailboat:</strong> 5-15 mph (8-24 km/h)</li>
                <li><strong>Motorboat:</strong> 30-50 mph (48-80 km/h)</li>
                <li><strong>Speedboat:</strong> 60-100 mph (97-161 km/h)</li>
                <li><strong>Racing boat:</strong> 150-200+ mph (241-322+ km/h)</li>
            </ul>

            <h3>⚡ Speed Records</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Record</th>
                        <th>Speed</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Land speed record</td><td>763 mph (1,228 km/h)</td></tr>
                    <tr><td>Production car record</td><td>304 mph (490 km/h)</td></tr>
                    <tr><td>Motorcycle record</td><td>376 mph (605 km/h)</td></tr>
                    <tr><td>Fastest human (Usain Bolt)</td><td>27.8 mph (44.7 km/h)</td></tr>
                    <tr><td>Cheetah (fastest animal)</td><td>70 mph (113 km/h)</td></tr>
                </tbody>
            </table>

            <h3>🚗 Fuel Efficiency</h3>
            <p>Speed affects fuel economy:</p>
            <ul>
                <li><strong>Optimal speed:</strong> 45-55 mph (72-89 km/h)</li>
                <li><strong>At 70 mph:</strong> 15-20% worse than optimal</li>
                <li><strong>At 80 mph:</strong> 25-30% worse than optimal</li>
                <li><strong>City driving:</strong> 25-35 mph average (40-56 km/h)</li>
            </ul>

            <h3>🎯 Practical Examples</h3>
            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • School zone: 20 mph = 32 km/h<br>
                • Residential: 30 mph = 48 km/h<br>
                • Highway: 60 mph = 97 km/h<br>
                • Interstate: 70 mph = 113 km/h<br>
                • High speed: 100 mph = 161 km/h<br>
                • Supercar: 200 mph = 322 km/h
            </div>

            <h3>🏛️ Historical Context</h3>
            <p>The <strong>mile per hour</strong> has been used since the invention of automobiles, with miles being the traditional imperial distance unit. <strong>Kilometers per hour</strong> became standard with the metric system adoption. The UK still uses mph for road speeds despite otherwise using metric units.</p>

            <h3>🔑 Key Conversions</h3>
            <ul>
                <li><strong>1 mph = 1.60934 km/h</strong> (exact)</li>
                <li><strong>1 km/h = 0.621371 mph</strong></li>
                <li><strong>60 mph ≈ 96.6 km/h</strong> (common highway speed)</li>
                <li><strong>100 km/h ≈ 62.1 mph</strong></li>
                <li><strong>Quick rule:</strong> MPH × 1.6 ≈ KPH</li>
            </ul>
        </div>

        <div class="footer">
            <p>🚗 Accurate MPH ⇄ KPH Conversion | Bidirectional Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for driving, travel, speed limits, and international conversions</p>
        </div>
    </div>

    <script>
        const KM_PER_MILE = 1.60934;

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
                `${mph.toFixed(2)} mph × ${KM_PER_MILE} = ${kph.toFixed(2)} km/h`;
        }

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
                `${kph.toFixed(2)} km/h ÷ ${KM_PER_MILE} = ${mph.toFixed(2)} mph`;
        }

        function swapUnits() {
            const mphValue = document.getElementById('mphInput').value;
            const kphValue = document.getElementById('kphInput').value;
            
            document.getElementById('mphInput').value = kphValue;
            document.getElementById('kphInput').value = mphValue;
            
            if (mphValue) convertMph();
        }

        function setMph(value) {
            document.getElementById('mphInput').value = value;
            convertMph();
        }

        // Auto-convert on input
        document.getElementById('mphInput').addEventListener('input', convertMph);
        document.getElementById('kphInput').addEventListener('input', convertKph);

        // Initial conversion
        convertMph();
    </script>
</body>
</html>