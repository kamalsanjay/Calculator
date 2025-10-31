<?php
/**
 * Power Converter
 * File: conversion/power-converter.php
 * Description: Convert between power units including watts, horsepower, kilowatts, and more
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Converter - Energy Transfer Rate Unit Conversion Calculator</title>
    <meta name="description" content="Convert between power units: watts, horsepower, kilowatts, BTU/hour, and more. Essential for electrical, mechanical, and energy applications.">
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
        
        .common-powers { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .common-powers h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        
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
        
        .efficiency-box { background: #c8e6c9; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #4caf50; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .power-scale { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .power-scale-bar { height: 30px; background: linear-gradient(90deg, #4caf50, #ffeb3b, #ff9800, #f44336); border-radius: 15px; margin: 10px 0; position: relative; }
        .power-scale-labels { display: flex; justify-content: space-between; font-size: 0.8rem; color: #555; }
        
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
            <h1>⚡ Power Converter</h1>
            <p>Convert between power units: watts, horsepower, kilowatts, BTU/hour, and more. Essential for electrical, mechanical, and energy applications.</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="w" selected>Watt (W)</option>
                        <option value="kw">Kilowatt (kW)</option>
                        <option value="mw">Megawatt (MW)</option>
                        <option value="hp">Horsepower (hp)</option>
                        <option value="hp_metric">Metric Horsepower (PS)</option>
                        <option value="btuh">BTU/hour (BTU/h)</option>
                        <option value="btum">BTU/minute</option>
                        <option value="btus">BTU/second</option>
                        <option value="kcalh">Kilocalorie/hour</option>
                        <option value="tons">Tons of Refrigeration</option>
                        <option value="va">Volt-Ampere (VA)</option>
                        <option value="kva">Kilovolt-Ampere (kVA)</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="w">Watt (W)</option>
                        <option value="kw" selected>Kilowatt (kW)</option>
                        <option value="mw">Megawatt (MW)</option>
                        <option value="hp">Horsepower (hp)</option>
                        <option value="hp_metric">Metric Horsepower (PS)</option>
                        <option value="btuh">BTU/hour (BTU/h)</option>
                        <option value="btum">BTU/minute</option>
                        <option value="btus">BTU/second</option>
                        <option value="kcalh">Kilocalorie/hour</option>
                        <option value="tons">Tons of Refrigeration</option>
                        <option value="va">Volt-Ampere (VA)</option>
                        <option value="kva">Kilovolt-Ampere (kVA)</option>
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

            <div class="common-powers">
                <h3>🏠 Common Power Values</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setCommonPower(100, 'Typical incandescent light bulb')">
                        <div class="quick-value">100 W</div>
                        <div class="quick-label">Light Bulb</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonPower(1500, 'Typical hair dryer or microwave')">
                        <div class="quick-value">1.5 kW</div>
                        <div class="quick-label">Hair Dryer</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonPower(50000, 'Small car engine power')">
                        <div class="quick-value">50 kW</div>
                        <div class="quick-label">Small Car</div>
                    </div>
                    <div class="quick-btn" onclick="setCommonPower(1000000, '1 Megawatt power plant')">
                        <div class="quick-value">1 MW</div>
                        <div class="quick-label">Power Plant</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⚡ Power Unit Conversion</h2>
            
            <p>Convert between power units used worldwide for electrical systems, mechanical engines, heating, cooling, and energy applications.</p>

            <div class="power-scale">
                <h3>📊 Power Scale Spectrum</h3>
                <div class="power-scale-bar"></div>
                <div class="power-scale-labels">
                    <span>Milliwatts (mW)</span>
                    <span>Watts (W)</span>
                    <span>Kilowatts (kW)</span>
                    <span>Megawatts (MW)</span>
                    <span>Gigawatts (GW)</span>
                </div>
            </div>

            <h3>📊 Conversion Factors to Watts</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Watts Equivalent</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Watt</td><td>W</td><td>1</td></tr>
                    <tr><td>Kilowatt</td><td>kW</td><td>1,000</td></tr>
                    <tr><td>Megawatt</td><td>MW</td><td>1,000,000</td></tr>
                    <tr><td>Horsepower (mechanical)</td><td>hp</td><td>745.7</td></tr>
                    <tr><td>Horsepower (metric)</td><td>PS</td><td>735.5</td></tr>
                    <tr><td>BTU per hour</td><td>BTU/h</td><td>0.293071</td></tr>
                    <tr><td>BTU per minute</td><td>BTU/min</td><td>17.5843</td></tr>
                    <tr><td>BTU per second</td><td>BTU/s</td><td>1,055.06</td></tr>
                    <tr><td>Kilocalorie per hour</td><td>kcal/h</td><td>1.163</td></tr>
                    <tr><td>Ton of refrigeration</td><td>TR</td><td>3,516.85</td></tr>
                    <tr><td>Volt-Ampere</td><td>VA</td><td>1*</td></tr>
                    <tr><td>Kilovolt-Ampere</td><td>kVA</td><td>1,000*</td></tr>
                </tbody>
            </table>
            <p style="font-size: 0.9rem; color: #777;">* VA and Watts are equal for resistive loads only</p>

            <div class="formula-box">
                <strong>Key Conversion Formulas:</strong><br>
                • 1 kW = 1,000 W<br>
                • 1 MW = 1,000,000 W<br>
                • 1 hp = 745.7 W<br>
                • 1 PS = 735.5 W<br>
                • 1 BTU/h = 0.293071 W<br>
                • 1 ton refrigeration = 12,000 BTU/h = 3,516.85 W<br>
                • 1 kcal/h = 1.163 W
            </div>

            <h3>🏠 Household Appliances</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Appliance</th>
                        <th>Typical Power</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>LED Light Bulb</td><td>5-15 W</td><td>Energy efficient lighting</td></tr>
                    <tr><td>Laptop Computer</td><td>30-90 W</td><td>Varies with usage</td></tr>
                    <tr><td>Refrigerator</td><td>100-800 W</td><td>Cycles on/off</td></tr>
                    <tr><td>Television</td><td>50-400 W</td><td>Size and technology dependent</td></tr>
                    <tr><td>Microwave Oven</td><td>600-1,500 W</td><td>Cooking power</td></tr>
                    <tr><td>Hair Dryer</td><td>800-1,800 W</td><td>Multiple heat settings</td></tr>
                    <tr><td>Electric Kettle</td><td>1,500-3,000 W</td><td>Rapid water heating</td></tr>
                    <tr><td>Air Conditioner</td><td>1,000-5,000 W</td><td>Room unit capacity</td></tr>
                    <tr><td>Electric Vehicle Charger</td><td>3,000-19,000 W</td><td>Level 2 charging</td></tr>
                </tbody>
            </table>

            <div class="efficiency-box">
                <strong>💡 Energy Efficiency:</strong><br>
                • Power Factor: Ratio of real power (W) to apparent power (VA)<br>
                • Motor Efficiency: Typically 70-95% for electric motors<br>
                • LED vs Incandescent: 85% less power for same light output<br>
                • Energy Star appliances: 10-50% more efficient<br>
                • Power conversion losses: 5-20% in typical systems
            </div>

            <h3>🚗 Automotive Power</h3>
            <ul>
                <li><strong>Compact car:</strong> 75-150 hp (56-112 kW)</li>
                <li><strong>Family sedan:</strong> 150-300 hp (112-224 kW)</li>
                <li><strong>Sports car:</strong> 300-700 hp (224-522 kW)</li>
                <li><strong>Supercar:</strong> 700-1,500+ hp (522-1,119+ kW)</li>
                <li><strong>Formula 1 car:</strong> 1,000+ hp (746+ kW) with hybrid systems</li>
                <li><strong>Electric vehicles:</strong> 100-1,000+ kW motor power</li>
            </ul>

            <h3>🏭 Industrial & Commercial</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Power Range</th>
                        <th>Purpose</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Small workshop motor</td><td>1-10 hp (0.75-7.5 kW)</td><td>Drilling, cutting, milling</td></tr>
                    <tr><td>Industrial pump</td><td>10-500 hp (7.5-373 kW)</td><td>Water, chemical processing</td></tr>
                    <tr><td>Factory compressor</td><td>50-1,000 hp (37-746 kW)</td><td>Air systems, refrigeration</td></tr>
                    <tr><td>Elevator motor</td><td>10-100 hp (7.5-75 kW)</td><td>Building transportation</td></tr>
                    <tr><td>Data center rack</td><td>5-40 kW per rack</td><td>IT equipment power</td></tr>
                    <tr><td>Commercial HVAC</td><td>10-1,000+ kW</td><td>Building climate control</td></tr>
                </tbody>
            </table>

            <h3>⚡ Electrical Systems</h3>
            <div class="formula-box">
                <strong>Electrical Power Formulas:</strong><br>
                • DC Power: P = V × I (Volts × Amps)<br>
                • AC Real Power: P = V × I × PF (Power Factor)<br>
                • AC Apparent Power: S = V × I (Volt-Amperes)<br>
                • Three Phase Power: P = √3 × V × I × PF<br>
                • Energy: E = P × t (Power × Time)<br>
                • 1 kWh = 3,600,000 Joules = 3,412 BTU
            </div>

            <h3>🌍 Energy Generation</h3>
            <ul>
                <li><strong>Residential solar:</strong> 3-10 kW typical installation</li>
                <li><strong>Wind turbine:</strong> 1-8 MW per turbine</li>
                <li><strong>Nuclear reactor:</strong> 500-1,600 MW per unit</li>
                <li><strong>Coal power plant:</strong> 300-1,000 MW per unit</li>
                <li><strong>Hydroelectric dam:</strong> 10-22,000 MW (Three Gorges)</li>
                <li><strong>Geothermal plant:</strong> 10-100 MW typical</li>
            </ul>

            <h3>🚀 Transportation Power</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Power Output</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Electric scooter</td><td>250-1,000 W</td><td>Personal mobility</td></tr>
                    <tr><td>Motorcycle</td><td>10-150 kW</td><td>Street and racing models</td></tr>
                    <tr><td>Passenger aircraft</td><td>30-100 MW per engine</td><td>Jet engines</td></tr>
                    <tr><td>High-speed train</td><td>5-20 MW</td><td>Electric multiple units</td></tr>
                    <tr><td>Container ship</td><td>40-80 MW</td><td>Marine diesel engines</td></tr>
                    <tr><td>Space rocket</td><td>10-30 GW during launch</td><td>Short duration peak power</td></tr>
                </tbody>
            </table>

            <h3>💡 Quick Mental Conversions</h3>
            <div class="formula-box">
                <strong>Horsepower ↔ Kilowatts:</strong><br>
                • Multiply hp by 0.75 for rough kW<br>
                • Multiply kW by 1.34 for rough hp<br><br>
                <strong>BTU/h ↔ Watts:</strong><br>
                • Multiply BTU/h by 0.3 for rough watts<br>
                • Multiply watts by 3.4 for rough BTU/h<br><br>
                <strong>kW ↔ Tons Refrigeration:</strong><br>
                • Divide kW by 3.5 for rough tons<br>
                • Multiply tons by 3.5 for rough kW
            </div>

            <h3>🌎 Regional Standards</h3>
            <ul>
                <li><strong>United States:</strong> Horsepower (hp), BTU/h, tons refrigeration</li>
                <li><strong>Europe:</strong> Metric horsepower (PS), kilowatts (kW)</li>
                <li><strong>Scientific:</strong> Watts (W) as SI unit</li>
                <li><strong>Automotive:</strong> Mixed usage (hp in US, kW in Europe)</li>
                <li><strong>HVAC:</strong> Tons refrigeration (US), kW (Europe)</li>
            </ul>

            <h3>⚖️ Historical Context</h3>
            <p>The <strong>watt</strong> is named after James Watt, inventor of the steam engine, and was adopted as the SI unit of power in 1960. <strong>Horsepower</strong> was developed by James Watt to compare steam engine power to draft horses. One horsepower was defined as the power needed to lift 33,000 pounds one foot in one minute. The <strong>BTU</strong> (British Thermal Unit) comes from the imperial system and represents the heat needed to raise 1 pound of water by 1°F.</p>

            <h3>🔧 Power Measurement</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Measurement Tool</th>
                        <th>Typical Range</th>
                        <th>Applications</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Wattmeter</td><td>1 W - 10 kW</td><td>Electrical power measurement</td></tr>
                    <tr><td>Power analyzer</td><td>Up to 100 MW</td><td>Industrial power quality</td></tr>
                    <tr><td>Dynamometer</td><td>Up to 10,000 hp</td><td>Engine and motor testing</td></tr>
                    <tr><td>Clamp meter</td><td>Up to 1,000 A</td><td>Current and power estimation</td></tr>
                    <tr><td>Energy monitor</td><td>Household circuits</td><td>Home energy tracking</td></tr>
                </tbody>
            </table>

            <h3>🎯 Key Conversions to Remember</h3>
            <ul>
                <li><strong>1 hp = 745.7 W = 0.7457 kW</strong></li>
                <li><strong>1 kW = 1,000 W = 1.341 hp</strong></li>
                <li><strong>1 BTU/h = 0.293071 W</strong></li>
                <li><strong>1 ton refrigeration = 12,000 BTU/h = 3,516.85 W</strong></li>
                <li><strong>1 PS = 735.5 W = 0.986 hp</strong></li>
                <li><strong>1 kcal/h = 1.163 W</strong></li>
            </ul>
        </div>

        <div class="footer">
            <p>⚡ Power Converter | Complete Power Unit Conversion</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert watts, horsepower, kilowatts, BTU/hour, and other power units with precision</p>
        </div>
    </div>

    <script>
        // Conversion factors to watts
        const toWatts = {
            w: 1,
            kw: 1000,
            mw: 1000000,
            hp: 745.699872,
            hp_metric: 735.49875,
            btuh: 0.29307107,
            btum: 17.5842642,
            btus: 1055.05585,
            kcalh: 1.163,
            tons: 3516.85284,
            va: 1,
            kva: 1000
        };

        const unitNames = {
            w: 'Watt (W)',
            kw: 'Kilowatt (kW)',
            mw: 'Megawatt (MW)',
            hp: 'Horsepower (hp)',
            hp_metric: 'Metric Horsepower (PS)',
            btuh: 'BTU per Hour',
            btum: 'BTU per Minute',
            btus: 'BTU per Second',
            kcalh: 'Kilocalorie per Hour',
            tons: 'Ton of Refrigeration',
            va: 'Volt-Ampere (VA)',
            kva: 'Kilovolt-Ampere (kVA)'
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

            // Convert to watts first
            const valueInWatts = inputValue * toWatts[fromUnit];
            
            // Convert to target unit
            const result = valueInWatts / toWatts[toUnit];
            
            document.getElementById('outputValue').value = formatNumber(result);
            
            displayAllConversions(valueInWatts);
        }

        function displayAllConversions(valueInWatts) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInWatts / toWatts[unit];
                
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

        function setCommonPower(value, description) {
            document.getElementById('inputValue').value = value;
            document.getElementById('fromUnit').value = 'w';
            document.getElementById('toUnit').value = 'kw';
            convert();
            // Optional: Show a tooltip or notification about the description
            console.log(description); // Could be enhanced with a toast notification
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