<?php
/**
 * Energy Converter
 * File: conversion/energy-converter.php
 * Description: Convert between joules, calories, kWh, BTU, and all energy units
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy Converter - Joules, Calories, kWh, BTU Calculator</title>
    <meta name="description" content="Convert between joules, calories, kilocalories, kWh, BTU, and all energy units. Free online energy converter calculator.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #fda085; box-shadow: 0 0 0 3px rgba(253, 160, 133, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; }
        .unit-select:focus { outline: none; border-color: #fda085; box-shadow: 0 0 0 3px rgba(253, 160, 133, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #fda085; }
        .result-unit { color: #7f8c8d; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #2c3e50; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #fda085; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(253, 160, 133, 0.15); }
        .quick-value { font-weight: bold; color: #fda085; font-size: 1rem; }
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
        .conversion-table tr:hover { background: #fff9f5; }
        
        .formula-box { background: #fff9f5; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #fda085; }
        .formula-box strong { color: #fda085; }
        
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
            <h1>⚡ Energy Converter</h1>
            <p>Convert between joules, calories, kilowatt-hours, BTU, and all energy units instantly</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1000">
                    </div>
                    <select id="fromUnit" class="unit-select" style="margin-top: 10px;">
                        <option value="j" selected>Joule (J)</option>
                        <option value="kj">Kilojoule (kJ)</option>
                        <option value="cal">Calorie (cal)</option>
                        <option value="kcal">Kilocalorie (kcal)</option>
                        <option value="wh">Watt-hour (Wh)</option>
                        <option value="kwh">Kilowatt-hour (kWh)</option>
                        <option value="ev">Electronvolt (eV)</option>
                        <option value="btu">British Thermal Unit (BTU)</option>
                        <option value="ftlb">Foot-pound (ft·lb)</option>
                        <option value="erg">Erg</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="j">Joule (J)</option>
                        <option value="kj">Kilojoule (kJ)</option>
                        <option value="cal">Calorie (cal)</option>
                        <option value="kcal" selected>Kilocalorie (kcal)</option>
                        <option value="wh">Watt-hour (Wh)</option>
                        <option value="kwh">Kilowatt-hour (kWh)</option>
                        <option value="ev">Electronvolt (eV)</option>
                        <option value="btu">British Thermal Unit (BTU)</option>
                        <option value="ftlb">Foot-pound (ft·lb)</option>
                        <option value="erg">Erg</option>
                    </select>
                    <div class="input-wrapper" style="margin-top: 10px;">
                        <input type="text" id="outputValue" placeholder="Result" readonly style="background: #f8f9fa; font-weight: 600; color: #2c3e50;">
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid"></div>

            <div class="quick-convert">
                <h3>⚡ Common Energy Values</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setInputValue(1000)">
                        <div class="quick-value">1,000</div>
                        <div class="quick-label">Units</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(10000)">
                        <div class="quick-value">10,000</div>
                        <div class="quick-label">Units</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(100000)">
                        <div class="quick-value">100k</div>
                        <div class="quick-label">Units</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(1000000)">
                        <div class="quick-value">1M</div>
                        <div class="quick-label">Units</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⚡ Energy Conversion Guide</h2>
            
            <p><strong>Energy</strong> is the capacity to do work. This converter supports all major energy units from joules to kilowatt-hours, covering scientific, nutritional, and practical applications.</p>

            <h3>📊 Conversion Factors to Joules</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Equals (in Joules)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Joule</td><td>J</td><td>1</td></tr>
                    <tr><td>Kilojoule</td><td>kJ</td><td>1,000</td></tr>
                    <tr><td>Calorie</td><td>cal</td><td>4.184</td></tr>
                    <tr><td>Kilocalorie</td><td>kcal</td><td>4,184</td></tr>
                    <tr><td>Watt-hour</td><td>Wh</td><td>3,600</td></tr>
                    <tr><td>Kilowatt-hour</td><td>kWh</td><td>3,600,000</td></tr>
                    <tr><td>Electronvolt</td><td>eV</td><td>1.602 × 10⁻¹⁹</td></tr>
                    <tr><td>British Thermal Unit</td><td>BTU</td><td>1,055.06</td></tr>
                    <tr><td>Foot-pound</td><td>ft·lb</td><td>1.35582</td></tr>
                    <tr><td>Erg</td><td>erg</td><td>1 × 10⁻⁷</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • 1 kWh = 3,600,000 J = 3.6 MJ<br>
                • 1 kcal = 4,184 J ≈ 4.2 kJ<br>
                • 1 BTU = 1,055 J ≈ 1.06 kJ<br>
                • 1 Wh = 3,600 J = 3.6 kJ<br>
                • 1 cal = 4.184 J
            </div>

            <h3>🍎 Nutritional Energy (Food Calories)</h3>
            <ul>
                <li><strong>Food Calorie:</strong> Actually kilocalorie (kcal), written as "Calorie" with capital C</li>
                <li><strong>1 Food Calorie:</strong> 1 kcal = 1,000 cal = 4,184 J = 4.184 kJ</li>
                <li><strong>Daily intake:</strong> ~2,000 kcal (8,368 kJ) for adults</li>
                <li><strong>Carbohydrates:</strong> 4 kcal/gram</li>
                <li><strong>Protein:</strong> 4 kcal/gram</li>
                <li><strong>Fat:</strong> 9 kcal/gram</li>
                <li><strong>Alcohol:</strong> 7 kcal/gram</li>
            </ul>

            <h3>⚡ Electrical Energy</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Device</th>
                        <th>Power</th>
                        <th>Energy (1 hour use)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>LED bulb (10W)</td><td>10 W</td><td>0.01 kWh = 36 kJ</td></tr>
                    <tr><td>Laptop (50W)</td><td>50 W</td><td>0.05 kWh = 180 kJ</td></tr>
                    <tr><td>Desktop PC (200W)</td><td>200 W</td><td>0.2 kWh = 720 kJ</td></tr>
                    <tr><td>Microwave (1000W)</td><td>1,000 W</td><td>1 kWh = 3.6 MJ</td></tr>
                    <tr><td>Air conditioner (2000W)</td><td>2,000 W</td><td>2 kWh = 7.2 MJ</td></tr>
                    <tr><td>Electric water heater (4000W)</td><td>4,000 W</td><td>4 kWh = 14.4 MJ</td></tr>
                </tbody>
            </table>

            <h3>🔋 Battery Capacities</h3>
            <ul>
                <li><strong>AA battery:</strong> ~3 Wh (10.8 kJ)</li>
                <li><strong>Smartphone battery:</strong> 10-15 Wh (36-54 kJ)</li>
                <li><strong>Laptop battery:</strong> 50-100 Wh (180-360 kJ)</li>
                <li><strong>Electric car battery:</strong> 60-100 kWh (216-360 MJ)</li>
                <li><strong>Power bank (20,000 mAh):</strong> ~70 Wh (252 kJ)</li>
            </ul>

            <h3>🏠 Heating & Cooling</h3>
            <div class="formula-box">
                <strong>BTU (British Thermal Unit):</strong><br>
                • Energy to raise 1 pound of water by 1°F<br>
                • 1 BTU = 1,055 J ≈ 0.293 Wh<br>
                • Air conditioner: 5,000-24,000 BTU/hr<br>
                • Small AC (5,000 BTU/hr) ≈ 1.5 kW<br>
                • Large AC (18,000 BTU/hr) ≈ 5.3 kW
            </div>

            <h3>🔬 Scientific Energy Units</h3>
            <ul>
                <li><strong>Electronvolt (eV):</strong> Energy of electron accelerated by 1 volt</li>
                <li><strong>Used in:</strong> Atomic and nuclear physics</li>
                <li><strong>X-rays:</strong> 100 eV - 100 keV</li>
                <li><strong>Visible light:</strong> 1.8-3.1 eV</li>
                <li><strong>Chemical bonds:</strong> 1-10 eV</li>
            </ul>

            <h3>⚙️ Mechanical Energy</h3>
            <ul>
                <li><strong>Foot-pound (ft·lb):</strong> Work done lifting 1 pound by 1 foot</li>
                <li><strong>1 ft·lb:</strong> 1.356 J</li>
                <li><strong>Used in:</strong> Torque specifications, mechanical work</li>
                <li><strong>Car engine torque:</strong> 100-400 ft·lb typical</li>
            </ul>

            <h3>🏃 Human Energy Expenditure</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Energy per hour</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Sleeping</td><td>50-70 kcal (210-293 kJ)</td></tr>
                    <tr><td>Sitting/reading</td><td>80-100 kcal (335-418 kJ)</td></tr>
                    <tr><td>Walking (3 mph)</td><td>200-300 kcal (837-1,255 kJ)</td></tr>
                    <tr><td>Jogging (5 mph)</td><td>400-600 kcal (1,674-2,511 kJ)</td></tr>
                    <tr><td>Running (8 mph)</td><td>700-900 kcal (2,930-3,766 kJ)</td></tr>
                    <tr><td>Cycling (moderate)</td><td>400-500 kcal (1,674-2,092 kJ)</td></tr>
                    <tr><td>Swimming</td><td>500-700 kcal (2,092-2,930 kJ)</td></tr>
                </tbody>
            </table>

            <h3>💡 Energy Efficiency</h3>
            <ul>
                <li><strong>LED bulb:</strong> 80-100 lumens/watt</li>
                <li><strong>CFL bulb:</strong> 50-70 lumens/watt</li>
                <li><strong>Incandescent:</strong> 10-17 lumens/watt</li>
                <li><strong>Solar panel:</strong> 15-22% efficiency typical</li>
                <li><strong>Car engine:</strong> 20-30% thermal efficiency</li>
                <li><strong>Electric motor:</strong> 85-95% efficiency</li>
            </ul>

            <h3>🌍 Large-Scale Energy</h3>
            <div class="formula-box">
                <strong>Energy Equivalents:</strong><br>
                • 1 ton of TNT = 4.184 GJ (gigajoules)<br>
                • 1 barrel of oil = 6.1 GJ<br>
                • 1 cubic meter natural gas = 38 MJ<br>
                • 1 kg coal = 24 MJ<br>
                • 1 kg gasoline = 46 MJ<br>
                • Nuclear fission (1 kg U-235) = 82 TJ (terajoules)
            </div>

            <h3>📱 Practical Examples</h3>
            <ul>
                <li><strong>Charge smartphone:</strong> ~15 Wh (54 kJ)</li>
                <li><strong>Boil 1 liter water:</strong> ~330 kJ (0.092 kWh)</li>
                <li><strong>Run dishwasher:</strong> 1-2 kWh (3.6-7.2 MJ)</li>
                <li><strong>Drive 100 km (electric car):</strong> 15-20 kWh (54-72 MJ)</li>
                <li><strong>Heat house (1 day, winter):</strong> 100-300 kWh (360-1,080 MJ)</li>
            </ul>

            <h3>⚖️ Energy Density</h3>
            <ul>
                <li><strong>Lithium battery:</strong> 0.5-0.9 MJ/kg</li>
                <li><strong>Gasoline:</strong> 46 MJ/kg</li>
                <li><strong>Diesel:</strong> 45 MJ/kg</li>
                <li><strong>Natural gas:</strong> 55 MJ/kg</li>
                <li><strong>Hydrogen:</strong> 142 MJ/kg</li>
                <li><strong>Uranium (fission):</strong> 80,620,000 MJ/kg</li>
            </ul>

            <h3>🎯 Quick Reference</h3>
            <div class="formula-box">
                <strong>Remember:</strong><br>
                • 1 kWh = 3.6 MJ (electricity bills)<br>
                • 1 food Calorie = 1 kcal = 4.2 kJ<br>
                • 1 BTU ≈ 1 kJ (heating/cooling)<br>
                • 1 Wh = 3.6 kJ<br>
                • Energy = Power × Time
            </div>
        </div>

        <div class="footer">
            <p>⚡ Accurate Energy Conversion | All Major Units Supported</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for nutrition, electricity, heating, and scientific calculations</p>
        </div>
    </div>

    <script>
        // Conversion factors to joules
        const conversionFactors = {
            j: 1,
            kj: 1000,
            cal: 4.184,
            kcal: 4184,
            wh: 3600,
            kwh: 3600000,
            ev: 1.602176634e-19,
            btu: 1055.06,
            ftlb: 1.35582,
            erg: 1e-7
        };

        const unitNames = {
            j: 'Joule (J)',
            kj: 'Kilojoule (kJ)',
            cal: 'Calorie (cal)',
            kcal: 'Kilocalorie (kcal)',
            wh: 'Watt-hour (Wh)',
            kwh: 'Kilowatt-hour (kWh)',
            ev: 'Electronvolt (eV)',
            btu: 'BTU',
            ftlb: 'Foot-pound (ft·lb)',
            erg: 'Erg'
        };

        function convertEnergy() {
            const inputValue = parseFloat(document.getElementById('inputValue').value);
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;

            if (isNaN(inputValue)) {
                document.getElementById('outputValue').value = '';
                document.getElementById('resultGrid').innerHTML = '';
                return;
            }

            const valueInJoules = inputValue * conversionFactors[fromUnit];
            const result = valueInJoules / conversionFactors[toUnit];

            document.getElementById('outputValue').value = formatNumber(result);
            displayAllConversions(valueInJoules);
        }

        function displayAllConversions(valueInJoules) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInJoules / conversionFactors[unit];
                
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
            return num.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 6
            });
        }

        function swapUnits() {
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;
            
            document.getElementById('fromUnit').value = toUnit;
            document.getElementById('toUnit').value = fromUnit;
            
            convertEnergy();
        }

        function setInputValue(value) {
            document.getElementById('inputValue').value = value;
            convertEnergy();
        }

        // Auto-convert on input
        document.getElementById('inputValue').addEventListener('input', convertEnergy);
        document.getElementById('fromUnit').addEventListener('change', convertEnergy);
        document.getElementById('toUnit').addEventListener('change', convertEnergy);

        // Initial conversion
        convertEnergy();
    </script>
</body>
</html>