<?php
/**
 * Knots Converter
 * File: conversion/knots-converter.php
 * Description: Convert knots to mph, km/h, and meters per second
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knots Converter - Knots to MPH, KM/H, M/S Calculator</title>
    <meta name="description" content="Convert knots to mph, km/h, and meters per second. Perfect for nautical, aviation, and weather speed conversions.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-section { margin-bottom: 25px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 80px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #4facfe; box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #4facfe; font-weight: 600; font-size: 0.95rem; }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #e3f2fd 0%, #b3e5fc 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #4facfe; }
        .result-unit { color: #01579b; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-value { font-size: 1.8rem; font-weight: bold; color: #0277bd; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #4facfe; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(79, 172, 254, 0.15); }
        .quick-value { font-weight: bold; color: #4facfe; font-size: 1rem; }
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
        .conversion-table tr:hover { background: #e3f2fd; }
        
        .formula-box { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #4facfe; }
        .formula-box strong { color: #4facfe; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .result-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⛵ Knots Speed Converter</h1>
            <p>Convert knots to mph, km/h, and meters per second - Nautical & aviation speed calculator</p>
        </div>

        <div class="converter-card">
            <div class="input-section">
                <div class="input-group">
                    <label for="knotsInput">Speed in Knots (kt or kn)</label>
                    <div class="input-wrapper">
                        <input type="number" id="knotsInput" placeholder="Enter knots" step="0.1" min="0" value="10">
                        <span class="unit-label">knots</span>
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid">
                <div class="result-card">
                    <div class="result-unit">Miles per Hour (mph)</div>
                    <div class="result-value" id="mphValue">11.51 mph</div>
                </div>
                <div class="result-card">
                    <div class="result-unit">Kilometers per Hour (km/h)</div>
                    <div class="result-value" id="kmhValue">18.52 km/h</div>
                </div>
                <div class="result-card">
                    <div class="result-unit">Meters per Second (m/s)</div>
                    <div class="result-value" id="msValue">5.14 m/s</div>
                </div>
            </div>

            <div class="quick-convert">
                <h3>⛵ Common Speeds</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setKnots(5)">
                        <div class="quick-value">5 knots</div>
                        <div class="quick-label">Slow Sail</div>
                    </div>
                    <div class="quick-btn" onclick="setKnots(10)">
                        <div class="quick-value">10 knots</div>
                        <div class="quick-label">Moderate</div>
                    </div>
                    <div class="quick-btn" onclick="setKnots(20)">
                        <div class="quick-value">20 knots</div>
                        <div class="quick-label">Fast Sail</div>
                    </div>
                    <div class="quick-btn" onclick="setKnots(30)">
                        <div class="quick-value">30 knots</div>
                        <div class="quick-label">Speed Boat</div>
                    </div>
                    <div class="quick-btn" onclick="setKnots(50)">
                        <div class="quick-value">50 knots</div>
                        <div class="quick-label">Fast Boat</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⛵ Knots Speed Conversion Guide</h2>
            
            <p>A <strong>knot</strong> is a unit of speed equal to one nautical mile per hour. It's primarily used in maritime and aviation contexts.</p>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>Knots to Other Units:</strong><br>
                • Miles per Hour (mph) = Knots × 1.15078<br>
                • Kilometers per Hour (km/h) = Knots × 1.852<br>
                • Meters per Second (m/s) = Knots × 0.514444<br><br>
                <strong>Base Conversion:</strong><br>
                • 1 knot = 1 nautical mile per hour<br>
                • 1 nautical mile = 1.852 kilometers (exact)<br>
                • 1 nautical mile ≈ 1.15078 statute miles
            </div>

            <h3>📊 Speed Comparison Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Knots</th>
                        <th>MPH</th>
                        <th>KM/H</th>
                        <th>M/S</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1 kt</td><td>1.15 mph</td><td>1.85 km/h</td><td>0.51 m/s</td></tr>
                    <tr><td>5 kt</td><td>5.75 mph</td><td>9.26 km/h</td><td>2.57 m/s</td></tr>
                    <tr><td>10 kt</td><td>11.51 mph</td><td>18.52 km/h</td><td>5.14 m/s</td></tr>
                    <tr><td>20 kt</td><td>23.02 mph</td><td>37.04 km/h</td><td>10.29 m/s</td></tr>
                    <tr><td>30 kt</td><td>34.52 mph</td><td>55.56 km/h</td><td>15.43 m/s</td></tr>
                    <tr><td>50 kt</td><td>57.54 mph</td><td>92.60 km/h</td><td>25.72 m/s</td></tr>
                    <tr><td>100 kt</td><td>115.08 mph</td><td>185.20 km/h</td><td>51.44 m/s</td></tr>
                    <tr><td>500 kt</td><td>575.39 mph</td><td>926.00 km/h</td><td>257.22 m/s</td></tr>
                </tbody>
            </table>

            <h3>⛵ Sailing Speeds</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Vessel Type</th>
                        <th>Typical Speed</th>
                        <th>MPH</th>
                        <th>KM/H</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Kayak/Canoe</td><td>3-5 knots</td><td>3.5-5.8 mph</td><td>5.6-9.3 km/h</td></tr>
                    <tr><td>Sailboat (cruising)</td><td>5-8 knots</td><td>5.8-9.2 mph</td><td>9.3-14.8 km/h</td></tr>
                    <tr><td>Racing sailboat</td><td>10-20 knots</td><td>11.5-23 mph</td><td>18.5-37 km/h</td></tr>
                    <tr><td>Motor yacht</td><td>15-30 knots</td><td>17-35 mph</td><td>28-56 km/h</td></tr>
                    <tr><td>Ferry</td><td>20-40 knots</td><td>23-46 mph</td><td>37-74 km/h</td></tr>
                    <tr><td>Speedboat</td><td>40-60 knots</td><td>46-69 mph</td><td>74-111 km/h</td></tr>
                    <tr><td>Cargo ship</td><td>12-20 knots</td><td>14-23 mph</td><td>22-37 km/h</td></tr>
                    <tr><td>Cruise ship</td><td>20-25 knots</td><td>23-29 mph</td><td>37-46 km/h</td></tr>
                </tbody>
            </table>

            <h3>✈️ Aviation Speeds</h3>
            <ul>
                <li><strong>Small aircraft (Cessna):</strong> 100-150 knots (115-173 mph)</li>
                <li><strong>Regional jet:</strong> 250-350 knots (288-403 mph)</li>
                <li><strong>Commercial airliner (cruise):</strong> 450-500 knots (518-575 mph)</li>
                <li><strong>Supersonic jet:</strong> 1,000+ knots (1,150+ mph)</li>
                <li><strong>Helicopter:</strong> 120-150 knots (138-173 mph)</li>
            </ul>

            <h3>🌊 Beaufort Wind Scale</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Force</th>
                        <th>Description</th>
                        <th>Wind Speed (knots)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>0</td><td>Calm</td><td>< 1 knot</td></tr>
                    <tr><td>1</td><td>Light air</td><td>1-3 knots</td></tr>
                    <tr><td>2</td><td>Light breeze</td><td>4-6 knots</td></tr>
                    <tr><td>3</td><td>Gentle breeze</td><td>7-10 knots</td></tr>
                    <tr><td>4</td><td>Moderate breeze</td><td>11-16 knots</td></tr>
                    <tr><td>5</td><td>Fresh breeze</td><td>17-21 knots</td></tr>
                    <tr><td>6</td><td>Strong breeze</td><td>22-27 knots</td></tr>
                    <tr><td>7</td><td>Near gale</td><td>28-33 knots</td></tr>
                    <tr><td>8</td><td>Gale</td><td>34-40 knots</td></tr>
                    <tr><td>9</td><td>Strong gale</td><td>41-47 knots</td></tr>
                    <tr><td>10</td><td>Storm</td><td>48-55 knots</td></tr>
                    <tr><td>11</td><td>Violent storm</td><td>56-63 knots</td></tr>
                    <tr><td>12</td><td>Hurricane</td><td>64+ knots</td></tr>
                </tbody>
            </table>

            <h3>🌀 Hurricane Categories</h3>
            <div class="formula-box">
                <strong>Saffir-Simpson Scale:</strong><br>
                • Category 1: 64-82 knots (74-95 mph)<br>
                • Category 2: 83-95 knots (96-110 mph)<br>
                • Category 3: 96-112 knots (111-129 mph)<br>
                • Category 4: 113-136 knots (130-156 mph)<br>
                • Category 5: 137+ knots (157+ mph)
            </div>

            <h3>🚢 Ship Classifications</h3>
            <ul>
                <li><strong>Displacement hull:</strong> Max 8-10 knots (hull speed limited)</li>
                <li><strong>Semi-displacement:</strong> 10-25 knots</li>
                <li><strong>Planing hull:</strong> 25-50+ knots</li>
                <li><strong>Hydrofoil:</strong> 40-60 knots</li>
                <li><strong>Hovercraft:</strong> 30-50 knots</li>
            </ul>

            <h3>💡 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>Knots to MPH:</strong><br>
                • Add 15% to knots<br>
                • Example: 20 knots + 15% = 23 mph<br>
                • Actual: 20 knots = 23.02 mph (exact!)<br><br>
                <strong>Knots to KM/H:</strong><br>
                • Double knots for rough km/h<br>
                • Example: 20 knots × 2 ≈ 40 km/h<br>
                • Actual: 20 knots = 37.04 km/h (close!)
            </div>

            <h3>🌊 Ocean Currents</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Current</th>
                        <th>Speed</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Gulf Stream (max)</td><td>5-6 knots</td></tr>
                    <tr><td>Typical ocean current</td><td>1-3 knots</td></tr>
                    <tr><td>Tidal current</td><td>1-5 knots</td></tr>
                    <tr><td>Strong tidal rapids</td><td>8-12 knots</td></tr>
                </tbody>
            </table>

            <h3>🏁 Speed Records</h3>
            <ul>
                <li><strong>Sailboat (speed record):</strong> 65.45 knots (75.3 mph)</li>
                <li><strong>Powerboat (water speed):</strong> 276 knots (318 mph)</li>
                <li><strong>Fastest ship:</strong> ~50 knots (naval vessels)</li>
                <li><strong>Average cruise ship:</strong> 20-25 knots</li>
            </ul>

            <h3>📐 Nautical Mile Definition</h3>
            <p>A <strong>nautical mile</strong> was originally defined as one minute of arc along a meridian of the Earth. This made it extremely useful for navigation, as distances on nautical charts directly correspond to degrees and minutes of latitude.</p>

            <div class="formula-box">
                <strong>Why Nautical Miles?</strong><br>
                • Based on Earth's geometry<br>
                • 1 nautical mile = 1 minute of latitude<br>
                • 60 nautical miles = 1 degree of latitude<br>
                • Makes chart navigation simpler<br>
                • International standard: 1,852 meters (exact)
            </div>

            <h3>✈️ Aviation Usage</h3>
            <ul>
                <li><strong>Airspeed:</strong> Measured in knots (IAS, TAS)</li>
                <li><strong>Flight levels:</strong> Altitude in hundreds of feet</li>
                <li><strong>Ground speed:</strong> Speed over ground (knots)</li>
                <li><strong>Wind reports:</strong> Direction in degrees, speed in knots</li>
                <li><strong>METAR/TAF:</strong> Weather reports use knots</li>
            </ul>

            <h3>🌍 Regional Usage</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Context</th>
                        <th>Primary Unit</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Maritime/Naval</td><td>Knots</td><td>Universal standard</td></tr>
                    <tr><td>Aviation</td><td>Knots</td><td>International standard</td></tr>
                    <tr><td>Weather (marine)</td><td>Knots</td><td>Wind speeds</td></tr>
                    <tr><td>Land vehicles (US)</td><td>MPH</td><td>Statute miles</td></tr>
                    <tr><td>Land vehicles (global)</td><td>KM/H</td><td>Metric standard</td></tr>
                </tbody>
            </table>

            <h3>🎯 Practical Examples</h3>
            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • Calm sailing: 5 knots = 5.8 mph = 9.3 km/h<br>
                • Good sailing: 10 knots = 11.5 mph = 18.5 km/h<br>
                • Fast sailing: 20 knots = 23 mph = 37 km/h<br>
                • Speed boat: 40 knots = 46 mph = 74 km/h<br>
                • Hurricane: 64+ knots = 74+ mph = 119+ km/h<br>
                • Jet cruise: 500 knots = 575 mph = 926 km/h
            </div>

            <h3>🏛️ Historical Context</h3>
            <p>The term "knot" comes from the practice of measuring a ship's speed using a "common log" - a rope with knots tied at regular intervals (typically 47 feet 3 inches apart). The rope was attached to a wooden board thrown overboard, and sailors counted how many knots passed through their hands in 28 seconds (1/120th of an hour), giving speed in nautical miles per hour.</p>

            <h3>🔑 Key Conversions</h3>
            <ul>
                <li><strong>1 knot = 1.15078 mph</strong> (statute miles per hour)</li>
                <li><strong>1 knot = 1.852 km/h</strong> (exact by definition)</li>
                <li><strong>1 knot = 0.514444 m/s</strong> (meters per second)</li>
                <li><strong>1 nautical mile = 1.852 km</strong> (exact)</li>
                <li><strong>1 nautical mile = 1.15078 statute miles</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>⛵ Accurate Knots Speed Conversion | Nautical & Aviation Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for sailing, boating, aviation, and marine weather</p>
        </div>
    </div>

    <script>
        const MPH_PER_KNOT = 1.15077945;
        const KMH_PER_KNOT = 1.852;
        const MS_PER_KNOT = 0.514444444;

        function convertKnots() {
            const knots = parseFloat(document.getElementById('knotsInput').value);
            
            if (isNaN(knots) || knots < 0) {
                return;
            }

            const mph = knots * MPH_PER_KNOT;
            const kmh = knots * KMH_PER_KNOT;
            const ms = knots * MS_PER_KNOT;
            
            document.getElementById('mphValue').textContent = mph.toFixed(2) + ' mph';
            document.getElementById('kmhValue').textContent = kmh.toFixed(2) + ' km/h';
            document.getElementById('msValue').textContent = ms.toFixed(2) + ' m/s';
        }

        function setKnots(value) {
            document.getElementById('knotsInput').value = value;
            convertKnots();
        }

        // Auto-convert on input
        document.getElementById('knotsInput').addEventListener('input', convertKnots);

        // Initial conversion
        convertKnots();
    </script>
</body>
</html>