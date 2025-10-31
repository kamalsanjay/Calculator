<?php
/**
 * Mile to KM Converter
 * File: conversion/mile-to-km-converter.php
 * Description: Convert miles to kilometers and vice versa
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mile to KM Converter - Miles to Kilometers Calculator</title>
    <meta name="description" content="Convert miles to kilometers (km) and km to miles instantly. Bidirectional distance converter for travel and navigation.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 900px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 70px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #fa709a; box-shadow: 0 0 0 3px rgba(250, 112, 154, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #fa709a; font-weight: 600; font-size: 0.95rem; }
        
        .swap-btn { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-box { background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #fa709a; margin-bottom: 25px; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.5rem; font-weight: bold; color: #d84315; margin-bottom: 10px; }
        .result-formula { background: white; padding: 15px; border-radius: 8px; font-family: 'Courier New', monospace; color: #555; font-size: 0.9rem; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #fa709a; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(250, 112, 154, 0.15); }
        .quick-value { font-weight: bold; color: #fa709a; font-size: 1.1rem; }
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
        
        .formula-box { background: #fff3e0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #fa709a; }
        .formula-box strong { color: #fa709a; }
        
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
            <h1>🗺️ Mile ⇄ KM Converter</h1>
            <p>Convert between miles and kilometers with bidirectional conversion</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="mileInput">Miles</label>
                    <div class="input-wrapper">
                        <input type="number" id="mileInput" placeholder="Enter miles" step="0.01" min="0" value="10">
                        <span class="unit-label">mi</span>
                    </div>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="kmInput">Kilometers</label>
                    <div class="input-wrapper">
                        <input type="number" id="kmInput" placeholder="Enter km" step="0.1" min="0">
                        <span class="unit-label">km</span>
                    </div>
                </div>
            </div>

            <div class="result-box">
                <div class="result-label">Result</div>
                <div class="result-value" id="resultValue">10 mi = 16.09 km</div>
                <div class="result-formula" id="resultFormula">10 miles × 1.60934 = 16.09 km</div>
            </div>

            <div class="quick-convert">
                <h3>🗺️ Common Distances</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setMiles(1)">
                        <div class="quick-value">1 mi</div>
                        <div class="quick-label">1.61 km</div>
                    </div>
                    <div class="quick-btn" onclick="setMiles(5)">
                        <div class="quick-value">5 mi</div>
                        <div class="quick-label">5K Race</div>
                    </div>
                    <div class="quick-btn" onclick="setMiles(10)">
                        <div class="quick-value">10 mi</div>
                        <div class="quick-label">Short Trip</div>
                    </div>
                    <div class="quick-btn" onclick="setMiles(26.2)">
                        <div class="quick-value">26.2 mi</div>
                        <div class="quick-label">Marathon</div>
                    </div>
                    <div class="quick-btn" onclick="setMiles(100)">
                        <div class="quick-value">100 mi</div>
                        <div class="quick-label">Long Trip</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🗺️ Mile to Kilometer Conversion</h2>
            
            <p>The <strong>mile</strong> is an imperial unit of distance used primarily in the United States and United Kingdom, while the <strong>kilometer</strong> is the metric standard used worldwide.</p>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>Miles to Kilometers:</strong><br>
                • Kilometers = Miles × 1.60934<br>
                • 1 mile = 1.60934 kilometers (exact)<br><br>
                <strong>Kilometers to Miles:</strong><br>
                • Miles = Kilometers ÷ 1.60934<br>
                • 1 kilometer = 0.621371 miles
            </div>

            <h3>📊 Conversion Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Miles (mi)</th>
                        <th>Kilometers (km)</th>
                        <th>Common Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 mi</td><td>1.61 km</td><td>Short walk</td></tr>
                    <tr><td>5 mi</td><td>8.05 km</td><td>5K race</td></tr>
                    <tr><td>10 mi</td><td>16.09 km</td><td>10K race</td></tr>
                    <tr><td>13.1 mi</td><td>21.1 km</td><td>Half marathon</td></tr>
                    <tr><td>26.2 mi</td><td>42.2 km</td><td>Marathon</td></tr>
                    <tr><td>50 mi</td><td>80.47 km</td><td>Ultramarathon</td></tr>
                    <tr><td>100 mi</td><td>160.93 km</td><td>Century ride</td></tr>
                    <tr><td>1,000 mi</td><td>1,609.34 km</td><td>Long road trip</td></tr>
                </tbody>
            </table>

            <h3>🏃 Running & Racing</h3>
            <ul>
                <li><strong>5K race:</strong> 3.11 miles (5 kilometers)</li>
                <li><strong>10K race:</strong> 6.21 miles (10 kilometers)</li>
                <li><strong>Half marathon:</strong> 13.1 miles (21.1 km)</li>
                <li><strong>Marathon:</strong> 26.2 miles (42.195 km)</li>
                <li><strong>50K ultramarathon:</strong> 31.07 miles</li>
                <li><strong>100K ultramarathon:</strong> 62.14 miles</li>
            </ul>

            <h3>🚗 Driving Distances</h3>
            <div class="formula-box">
                <strong>Typical Distances:</strong><br>
                • Commute: 10-30 miles (16-48 km)<br>
                • Day trip: 50-100 miles (80-160 km)<br>
                • Road trip: 200-500 miles (322-805 km)<br>
                • Cross-country (US): ~3,000 miles (4,828 km)<br>
                • Coast to coast (US): 2,800-3,200 miles (4,506-5,149 km)
            </div>

            <h3>🌍 Country Distances</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Route</th>
                        <th>Miles</th>
                        <th>Kilometers</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>New York to LA</td><td>2,789 mi</td><td>4,488 km</td></tr>
                    <tr><td>London to Edinburgh</td><td>414 mi</td><td>666 km</td></tr>
                    <tr><td>Paris to Berlin</td><td>546 mi</td><td>878 km</td></tr>
                    <tr><td>Tokyo to Osaka</td><td>314 mi</td><td>505 km</td></tr>
                    <tr><td>Sydney to Melbourne</td><td>545 mi</td><td>877 km</td></tr>
                </tbody>
            </table>

            <h3>✈️ Flight Distances</h3>
            <ul>
                <li><strong>Short-haul:</strong> < 500 miles (805 km)</li>
                <li><strong>Medium-haul:</strong> 500-1,500 miles (805-2,414 km)</li>
                <li><strong>Long-haul:</strong> 1,500-4,000 miles (2,414-6,437 km)</li>
                <li><strong>Ultra long-haul:</strong> > 4,000 miles (6,437 km)</li>
                <li><strong>Around the world:</strong> ~25,000 miles (40,234 km)</li>
            </ul>

            <h3>🚲 Cycling</h3>
            <div class="formula-box">
                <strong>Cycling Distances:</strong><br>
                • Easy ride: 10-20 miles (16-32 km)<br>
                • Moderate ride: 30-50 miles (48-80 km)<br>
                • Long ride: 60-80 miles (97-129 km)<br>
                • Century ride: 100 miles (161 km)<br>
                • Tour de France stage: 100-150 miles (161-241 km)
            </div>

            <h3>🏔️ Hiking & Trails</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Trail</th>
                        <th>Length</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Appalachian Trail</td><td>2,190 mi (3,524 km)</td></tr>
                    <tr><td>Pacific Crest Trail</td><td>2,650 mi (4,265 km)</td></tr>
                    <tr><td>Continental Divide Trail</td><td>3,100 mi (4,989 km)</td></tr>
                    <tr><td>Camino de Santiago</td><td>500 mi (805 km)</td></tr>
                    <tr><td>Great Wall of China</td><td>13,171 mi (21,196 km)</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>Miles to KM (Easy):</strong><br>
                • Multiply miles by 1.6 (or 8/5)<br>
                • Example: 10 mi × 1.6 = 16 km<br>
                • Actual: 10 mi = 16.09 km (very close!)<br><br>
                <strong>KM to Miles (Easy):</strong><br>
                • Multiply km by 0.6 (or 5/8)<br>
                • Example: 100 km × 0.6 = 60 miles<br>
                • Actual: 100 km = 62.14 miles (close!)
            </div>

            <h3>🚙 Speed Limits</h3>
            <ul>
                <li><strong>US school zone:</strong> 15-25 mph (24-40 km/h)</li>
                <li><strong>US residential:</strong> 25-35 mph (40-56 km/h)</li>
                <li><strong>US highway:</strong> 55-70 mph (89-113 km/h)</li>
                <li><strong>US interstate:</strong> 65-80 mph (105-129 km/h)</li>
                <li><strong>UK motorway:</strong> 70 mph (113 km/h)</li>
                <li><strong>German autobahn:</strong> Often no limit (advised 130 km/h = 81 mph)</li>
            </ul>

            <h3>⛽ Fuel Economy</h3>
            <div class="formula-box">
                <strong>MPG vs L/100km:</strong><br>
                • US uses miles per gallon (MPG)<br>
                • Europe uses liters per 100 kilometers (L/100km)<br>
                • 30 MPG ≈ 7.8 L/100km<br>
                • 40 MPG ≈ 5.9 L/100km<br>
                • 50 MPG ≈ 4.7 L/100km
            </div>

            <h3>🌎 Regional Usage</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Region</th>
                        <th>Primary Unit</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>United States</td><td>Miles</td><td>Exclusive use</td></tr>
                    <tr><td>United Kingdom</td><td>Miles</td><td>Road distances</td></tr>
                    <tr><td>Canada</td><td>Kilometers</td><td>Officially metric</td></tr>
                    <tr><td>Europe</td><td>Kilometers</td><td>Metric standard</td></tr>
                    <tr><td>Asia</td><td>Kilometers</td><td>Metric standard</td></tr>
                    <tr><td>Australia</td><td>Kilometers</td><td>Metric system</td></tr>
                </tbody>
            </table>

            <h3>🏎️ Racing</h3>
            <ul>
                <li><strong>NASCAR track:</strong> 0.5-2.66 miles (0.8-4.3 km)</li>
                <li><strong>Formula 1 circuit:</strong> 2-4 miles (3.2-6.4 km)</li>
                <li><strong>Daytona 500:</strong> 500 miles (805 km)</li>
                <li><strong>Indy 500:</strong> 500 miles (805 km)</li>
                <li><strong>24 Hours of Le Mans:</strong> ~3,100 miles (5,000 km) total</li>
            </ul>

            <h3>🛣️ Interstate System (US)</h3>
            <div class="formula-box">
                <strong>Major Interstate Lengths:</strong><br>
                • I-90 (Seattle to Boston): 3,020 miles (4,861 km)<br>
                • I-80 (San Francisco to NYC): 2,900 miles (4,667 km)<br>
                • I-10 (LA to Jacksonville): 2,460 miles (3,959 km)<br>
                • I-95 (Miami to Maine): 1,920 miles (3,090 km)<br>
                • I-5 (San Diego to Canada): 1,381 miles (2,222 km)
            </div>

            <h3>📐 Nautical Miles</h3>
            <p>Different from statute miles:</p>
            <ul>
                <li><strong>1 nautical mile:</strong> 1.15078 statute miles</li>
                <li><strong>1 nautical mile:</strong> 1.852 kilometers (exact)</li>
                <li><strong>Used for:</strong> Aviation and maritime navigation</li>
                <li><strong>Based on:</strong> Earth's circumference (1 minute of latitude)</li>
            </ul>

            <h3>🎯 Practical Examples</h3>
            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • 1 mile = 1.61 km (easy to remember)<br>
                • 5 miles = 8 km (5K race)<br>
                • 10 miles = 16 km<br>
                • 50 miles = 80 km<br>
                • 100 miles = 161 km<br>
                • 1,000 miles = 1,609 km
            </div>

            <h3>🏛️ Historical Context</h3>
            <p>The <strong>mile</strong> comes from the Latin "mille passus" (thousand paces), originally defined as 1,000 Roman paces (about 5,000 feet). The modern statute mile is 5,280 feet. The <strong>kilometer</strong> (from Greek "khilioi" meaning thousand) is 1,000 meters, part of the metric system established in France in 1795.</p>

            <h3>🗺️ GPS & Navigation</h3>
            <ul>
                <li><strong>GPS accuracy:</strong> Within 5-10 meters (16-33 feet)</li>
                <li><strong>Distance calculation:</strong> Uses Haversine formula</li>
                <li><strong>Map apps:</strong> Can display either miles or kilometers</li>
                <li><strong>Odometer:</strong> Measures distance traveled</li>
            </ul>

            <h3>🔑 Key Conversions</h3>
            <ul>
                <li><strong>1 mile = 1.60934 kilometers</strong> (exact)</li>
                <li><strong>1 kilometer = 0.621371 miles</strong></li>
                <li><strong>1 mile = 5,280 feet = 1,760 yards</strong></li>
                <li><strong>1 kilometer = 1,000 meters</strong></li>
                <li><strong>Quick approximation:</strong> 5 miles ≈ 8 km</li>
            </ul>
        </div>

        <div class="footer">
            <p>🗺️ Accurate Mile ⇄ KM Conversion | Bidirectional Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for travel, running, driving, and navigation</p>
        </div>
    </div>

    <script>
        const KM_PER_MILE = 1.60934;

        function convertMiles() {
            const miles = parseFloat(document.getElementById('mileInput').value);
            
            if (isNaN(miles) || miles < 0) {
                return;
            }

            const km = miles * KM_PER_MILE;
            document.getElementById('kmInput').value = km.toFixed(2);
            
            document.getElementById('resultValue').textContent = 
                `${miles.toFixed(2)} mi = ${km.toFixed(2)} km`;
            
            document.getElementById('resultFormula').textContent = 
                `${miles.toFixed(2)} miles × ${KM_PER_MILE} = ${km.toFixed(2)} km`;
        }

        function convertKm() {
            const km = parseFloat(document.getElementById('kmInput').value);
            
            if (isNaN(km) || km < 0) {
                return;
            }

            const miles = km / KM_PER_MILE;
            document.getElementById('mileInput').value = miles.toFixed(2);
            
            document.getElementById('resultValue').textContent = 
                `${km.toFixed(2)} km = ${miles.toFixed(2)} mi`;
            
            document.getElementById('resultFormula').textContent = 
                `${km.toFixed(2)} km ÷ ${KM_PER_MILE} = ${miles.toFixed(2)} miles`;
        }

        function swapUnits() {
            const mileValue = document.getElementById('mileInput').value;
            const kmValue = document.getElementById('kmInput').value;
            
            document.getElementById('mileInput').value = kmValue;
            document.getElementById('kmInput').value = mileValue;
            
            if (mileValue) convertMiles();
        }

        function setMiles(value) {
            document.getElementById('mileInput').value = value;
            convertMiles();
        }

        // Auto-convert on input
        document.getElementById('mileInput').addEventListener('input', convertMiles);
        document.getElementById('kmInput').addEventListener('input', convertKm);

        // Initial conversion
        convertMiles();
    </script>
</body>
</html>