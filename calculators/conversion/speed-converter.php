<?php
/**
 * Speed Converter
 * File: conversion/speed-converter.php
 * Description: Convert between speed units including mph, kph, knots, mach, and more
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speed Converter - Velocity Unit Conversion Calculator</title>
    <meta name="description" content="Convert between speed units: mph, kph, knots, mach, meters per second, and more. Essential for travel, sports, aviation, and scientific applications.">
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
        
        .common-speeds { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .common-speeds h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        
        .speed-scale { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .speed-scale-bar { height: 30px; background: linear-gradient(90deg, #4caf50, #ffeb3b, #ff9800, #f44336); border-radius: 15px; margin: 10px 0; position: relative; }
        .speed-scale-labels { display: flex; justify-content: space-between; font-size: 0.8rem; color: #555; }
        
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
        
        .speed-limits { background: #ffeaa7; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #fdcb6e; }
        
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
            <h1>🚀 Speed Converter</h1>
            <p>Convert between speed units: mph, kph, knots, mach, meters per second, and more. Essential for travel, sports, aviation, and scientific applications.</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="ms" selected>Meters per Second (m/s)</option>
                        <option value="kph">Kilometers per Hour (km/h)</option>
                        <option value="mph">Miles per Hour (mph)</option>
                        <option value="knots">Knots (kn)</option>
                        <option value="mach">Mach Number (M)</option>
                        <option value="fts">Feet per Second (ft/s)</option>
                        <option value="ips">Inches per Second (in/s)</option>
                        <option value="c">Speed of Light (c)</option>
                        <option value="fps">Frames per Second (fps)</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="ms">Meters per Second (m/s)</option>
                        <option value="kph" selected>Kilometers per Hour (km/h)</option>
                        <option value="mph">Miles per Hour (mph)</option>
                        <option value="knots">Knots (kn)</option>
                        <option value="mach">Mach Number (M)</option>
                        <option value="fts">Feet per Second (ft/s)</option>
                        <option value="ips">Inches per Second (in/s)</option>
                        <option value="c">Speed of Light (c)</option>
                        <option value="fps">Frames per Second (fps)</option>
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
                        <div class="quick-label">Unit</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(10)">
                        <div class="quick-value">10</div>
                        <div class="quick-label">Units</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(100)">
                        <div class="quick-value">100</div>
                        <div class="quick-label">Units</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(1000)">
                        <div class="quick-value">1000</div>
                        <div class="quick-label">Units</div>
                    </div>
                </div>
            </div>

            <div class="common-speeds">
                <h3>🎯 Common Speed Values</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setCommonSpeed(5, 'Average human walking speed')">
                        <div class="quick-value">5 km/h</div>
                        <div class="quick-label">Walking</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonSpeed(50, 'Typical city driving speed')">
                        <div class="quick-value">50 km/h</div>
                        <div class="quick-label">City Driving</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonSpeed(250, 'High-speed train speed')">
                        <div class="quick-value">250 km/h</div>
                        <div class="quick-label">High-speed Train</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonSpeed(343, 'Speed of sound at sea level')">
                        <div class="quick-value">343 m/s</div>
                        <div class="quick-label">Speed of Sound</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🚀 Speed Unit Conversion</h2>
            
            <p>Convert between speed units used worldwide for transportation, sports, science, and everyday applications.</p>

            <div class="speed-scale">
                <h3>📊 Speed Scale Spectrum</h3>
                <div class="speed-scale-bar"></div>
                <div class="speed-scale-labels">
                    <span>Walking<br>(1-2 m/s)</span>
                    <span>Driving<br>(10-30 m/s)</span>
                    <span>Flying<br>(50-250 m/s)</span>
                    <span>Supersonic<br>(340+ m/s)</span>
                    <span>Space<br>(1,000+ m/s)</span>
                </div>
            </div>

            <h3>📊 Conversion Factors to Meters per Second</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>m/s Equivalent</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Meters per Second</td><td>m/s</td><td>1</td></tr>
                    <tr><td>Kilometers per Hour</td><td>km/h</td><td>0.277778</td></tr>
                    <tr><td>Miles per Hour</td><td>mph</td><td>0.44704</td></tr>
                    <tr><td>Knots</td><td>kn</td><td>0.514444</td></tr>
                    <tr><td>Mach (sea level)</td><td>M</td><td>343</td></tr>
                    <tr><td>Feet per Second</td><td>ft/s</td><td>0.3048</td></tr>
                    <tr><td>Inches per Second</td><td>in/s</td><td>0.0254</td></tr>
                    <tr><td>Speed of Light</td><td>c</td><td>299,792,458</td></tr>
                    <tr><td>Frames per Second</td><td>fps</td><td>Depends on scale*</td></tr>
                </tbody>
            </table>
            <p style="font-size: 0.9rem; color: #777;">* FPS to m/s conversion depends on the real-world distance per frame</p>

            <div class="formula-box">
                <strong>Key Conversion Formulas:</strong><br>
                • 1 km/h = 0.277778 m/s<br>
                • 1 mph = 0.44704 m/s<br>
                • 1 knot = 0.514444 m/s<br>
                • 1 Mach = 343 m/s (at sea level, 20°C)<br>
                • 1 ft/s = 0.3048 m/s<br>
                • 1 in/s = 0.0254 m/s<br>
                • Speed of light = 299,792,458 m/s
            </div>

            <h3>🚶 Human Movement Speeds</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Typical Speed</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Walking (slow)</td><td>3-4 km/h (0.8-1.1 m/s)</td><td>Leisurely pace</td></tr>
                    <tr><td>Walking (brisk)</td><td>5-6 km/h (1.4-1.7 m/s)</td><td>Exercise walking</td></tr>
                    <tr><td>Running (jogging)</td><td>8-12 km/h (2.2-3.3 m/s)</td><td>Recreational running</td></tr>
                    <tr><td>Running (sprinting)</td><td>18-27 km/h (5-7.5 m/s)</td><td>Elite athletes</td></tr>
                    <tr><td>Swimming (freestyle)</td><td>3-5 km/h (0.8-1.4 m/s)</td><td>Competitive swimmers</td></tr>
                    <tr><td>Cycling (leisure)</td><td>15-20 km/h (4.2-5.6 m/s)</td><td>Casual biking</td></tr>
                    <tr><td>Cycling (racing)</td><td>40-45 km/h (11-12.5 m/s)</td><td>Professional cyclists</td></tr>
                </tbody>
            </table>

            <div class="speed-limits">
                <strong>🚦 Speed Limits Worldwide:</strong><br>
                • Urban areas: 30-50 km/h (20-30 mph)<br>
                • Rural roads: 80-100 km/h (50-60 mph)<br>
                • Highways: 100-130 km/h (60-80 mph)<br>
                • German Autobahn: Recommended 130 km/h, some sections unlimited<br>
                • School zones: 20-40 km/h (15-25 mph)<br>
                • Residential areas: 30-40 km/h (20-25 mph)
            </div>

            <h3>🚗 Automotive Speeds</h3>
            <ul>
                <li><strong>City driving:</strong> 30-60 km/h (20-40 mph)</li>
                <li><strong>Highway cruising:</strong> 100-120 km/h (60-75 mph)</li>
                <li><strong>Speed limits (US):</strong> 55-85 mph (88-137 km/h)</li>
                <li><strong>Sports cars:</strong> Top speeds 250-350 km/h (155-220 mph)</li>
                <li><strong>Formula 1:</strong> Average race speeds 220-240 km/h (137-149 mph)</li>
                <li><strong>Land speed record:</strong> 1,228 km/h (763 mph) - ThrustSSC</li>
            </ul>

            <h3>✈️ Aviation Speeds</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Aircraft</th>
                        <th>Cruising Speed</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Small propeller plane</td><td>150-250 km/h (80-135 knots)</td><td>General aviation</td></tr>
                    <tr><td>Commercial jet</td><td>850-900 km/h (460-485 knots)</td><td>Mach 0.78-0.83</td></tr>
                    <tr><td>Supersonic (Concorde)</td><td>2,180 km/h (1,177 knots)</td><td>Mach 2.02</td></tr>
                    <tr><td>Fighter jet</td><td>1,500-2,500 km/h (810-1,350 knots)</td><td>Mach 1.2-2.0+</td></tr>
                    <tr><td>SR-71 Blackbird</td><td>3,540 km/h (1,910 knots)</td><td>Mach 3.3</td></tr>
                    <tr><td>Space shuttle</td><td>28,000 km/h (15,100 knots)</td><td>Orbital velocity</td></tr>
                </tbody>
            </table>

            <h3>🌊 Maritime Speeds</h3>
            <div class="formula-box">
                <strong>Marine Speed Ranges:</strong><br>
                • Container ship: 20-25 knots (37-46 km/h)<br>
                • Cruise ship: 20-24 knots (37-44 km/h)<br>
                • Navy destroyer: 30+ knots (56+ km/h)<br>
                • Speedboat: 50-100 knots (93-185 km/h)<br>
                • Hydrofoil: 40-60 knots (74-111 km/h)<br>
                • Sailboat (racing): 15-25 knots (28-46 km/h)<br>
                • World sailing speed record: 65.45 knots (121.06 km/h)
            </div>

            <h3>🚄 Rail Transportation</h3>
            <ul>
                <li><strong>Commuter train:</strong> 80-120 km/h (50-75 mph)</li>
                <li><strong>Intercity train:</strong> 160-200 km/h (100-125 mph)</li>
                <li><strong>High-speed rail:</strong> 250-320 km/h (155-200 mph)</li>
                <li><strong>Maglev train:</strong> 400-600 km/h (250-370 mph)</li>
                <li><strong>World record (rail):</strong> 603 km/h (375 mph) - Maglev</li>
                <li><strong>Bullet train (Shinkansen):</strong> 240-320 km/h (150-200 mph)</li>
            </ul>

            <h3>🌍 Natural Phenomena</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Phenomenon</th>
                        <th>Speed</th>
                        <th>Context</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Wind (breeze)</td><td>5-20 km/h (3-12 mph)</td><td>Gentle to moderate</td></tr>
                    <tr><td>Wind (gale)</td><td>50-75 km/h (31-47 mph)</td><td>Strong wind</td></tr>
                    <tr><td>Wind (hurricane)</td><td>120+ km/h (75+ mph)</td><td>Category 1+</td></tr>
                    <tr><td>Tornado winds</td><td>100-500 km/h (60-310 mph)</td><td>F0-F5 scale</td></tr>
                    <tr><td>Ocean current</td><td>1-9 km/h (0.5-5 knots)</td><td>Major currents</td></tr>
                    <tr><td>Tsunami wave</td><td>500-800 km/h (310-500 mph)</td><td>Deep ocean</td></tr>
                    <tr><td>Sound in air</td><td>1,235 km/h (767 mph)</td><td>Mach 1 at sea level</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>mph ↔ km/h:</strong><br>
                • Multiply mph by 1.6 for rough km/h<br>
                • Multiply km/h by 0.6 for rough mph<br><br>
                <strong>knots ↔ km/h:</strong><br>
                • Multiply knots by 1.85 for rough km/h<br>
                • Multiply km/h by 0.54 for rough knots<br><br>
                <strong>m/s ↔ km/h:</strong><br>
                • Multiply m/s by 3.6 for km/h<br>
                • Divide km/h by 3.6 for m/s
            </div>

            <h3>🌎 Regional Standards</h3>
            <ul>
                <li><strong>United States:</strong> Miles per hour (mph) for roads, knots for aviation/marine</li>
                <li><strong>United Kingdom:</strong> Miles per hour (roads), knots (aviation/marine)</li>
                <li><strong>Europe:</strong> Kilometers per hour (km/h) for roads, knots for aviation/marine</li>
                <li><strong>Scientific:</strong> Meters per second (m/s) as SI unit</li>
                <li><strong>Aviation worldwide:</strong> Knots (standard)</li>
                <li><strong>Maritime worldwide:</strong> Knots (standard)</li>
            </ul>

            <h3>⚖️ Historical Context</h3>
            <p>The <strong>knot</strong> dates back to the 17th century when sailors measured ship speed by throwing a log attached to a rope with knots tied at regular intervals. The <strong>mile per hour</strong> comes from the Roman mile of 5,000 feet. The <strong>meter per second</strong> became the SI unit for speed in 1960. <strong>Mach number</strong> is named after Ernst Mach, who studied supersonic motion.</p>

            <h3>🔧 Speed Measurement</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Measurement Tool</th>
                        <th>Typical Range</th>
                        <th>Applications</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Radar gun</td><td>10-200 mph</td><td>Traffic enforcement, sports</td></tr>
                    <tr><td>GPS speedometer</td><td>0-1,000+ mph</td><td>Vehicles, aviation</td></tr>
                    <tr><td>Pitot tube</td><td>Aircraft speeds</td><td>Aviation airspeed</td></tr>
                    <tr><td>Laser Doppler</td><td>Precision measurement</td><td>Scientific research</td></tr>
                    <tr><td>Speed trap</td><td>Road vehicles</td><td>Traffic monitoring</td></tr>
                </tbody>
            </table>

            <h3>🎯 Key Conversions to Remember</h3>
            <ul>
                <li><strong>1 mph = 1.60934 km/h</strong></li>
                <li><strong>1 km/h = 0.621371 mph</strong></li>
                <li><strong>1 knot = 1.852 km/h = 1.15078 mph</strong></li>
                <li><strong>1 m/s = 3.6 km/h = 2.23694 mph</strong></li>
                <li><strong>Mach 1 = 343 m/s = 1,235 km/h = 767 mph</strong></li>
                <li><strong>Speed of light = 299,792,458 m/s</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>🚀 Speed Converter | Complete Speed Unit Conversion</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert mph, kph, knots, mach, meters per second, and other speed units with precision</p>
        </div>
    </div>

    <script>
        // Conversion factors to meters per second
        const toMetersPerSecond = {
            ms: 1,
            kph: 0.277778,
            mph: 0.44704,
            knots: 0.514444,
            mach: 343,
            fts: 0.3048,
            ips: 0.0254,
            c: 299792458,
            fps: 1 // Note: FPS conversion depends on context
        };

        const unitNames = {
            ms: 'Meters per Second (m/s)',
            kph: 'Kilometers per Hour (km/h)',
            mph: 'Miles per Hour (mph)',
            knots: 'Knots (kn)',
            mach: 'Mach Number (M)',
            fts: 'Feet per Second (ft/s)',
            ips: 'Inches per Second (in/s)',
            c: 'Speed of Light (c)',
            fps: 'Frames per Second (fps)*'
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

            // Convert to meters per second first
            const valueInMps = inputValue * toMetersPerSecond[fromUnit];
            
            // Convert to target unit
            const result = valueInMps / toMetersPerSecond[toUnit];
            
            document.getElementById('outputValue').value = formatNumber(result);
            
            displayAllConversions(valueInMps);
        }

        function displayAllConversions(valueInMps) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                // Special handling for FPS - it's not a direct speed unit
                if (unit === 'fps') {
                    continue; // Skip FPS from the grid as it's context-dependent
                }
                
                const converted = valueInMps / toMetersPerSecond[unit];
                
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

        function setCommonSpeed(value, description) {
            // Determine the unit from the value description
            let fromUnit = 'kph';
            if (description.includes('m/s')) fromUnit = 'ms';
            if (description.includes('mph')) fromUnit = 'mph';
            
            document.getElementById('inputValue').value = value;
            document.getElementById('fromUnit').value = fromUnit;
            document.getElementById('toUnit').value = 'kph';
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