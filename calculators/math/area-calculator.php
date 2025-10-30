<?php
/**
 * Area Calculator
 * File: area-calculator.php
 * Description: Calculate area of various geometric shapes with unit conversion
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Calculator - Calculate Area of All Shapes Online</title>
    <meta name="description" content="Free area calculator. Calculate area of square, rectangle, circle, triangle, parallelogram, trapezoid, ellipse, and more shapes.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 15px; }
        header { background: rgba(255,255,255,0.1); color: white; padding: 25px 15px; text-align: center; border-radius: 15px; margin-bottom: 20px; backdrop-filter: blur(10px); }
        header h1 { margin: 0 0 8px 0; font-size: 1.8em; }
        header p { margin: 0; opacity: 0.9; font-size: 1em; }
        .container { max-width: 1100px; margin: 0 auto; }
        .breadcrumb { margin-bottom: 15px; text-align: center; }
        .breadcrumb a { color: white; text-decoration: none; font-weight: 500; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 8px; display: inline-block; backdrop-filter: blur(10px); }
        
        .calculator-body { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); margin-bottom: 20px; }
        
        /* Settings */
        .settings-panel { background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); padding: 20px; border-radius: 12px; margin-bottom: 20px; border: 2px solid #667eea; }
        .settings-panel h4 { color: #667eea; margin-bottom: 15px; }
        .settings-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .setting-group { background: white; padding: 12px; border-radius: 8px; }
        .setting-group label { display: block; font-weight: 600; color: #555; margin-bottom: 8px; font-size: 0.9em; }
        .setting-group select { width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 6px; outline: none; }
        
        .calc-tabs { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 8px; margin-bottom: 20px; }
        .tab-btn { padding: 12px; background: #f0f0f0; border: none; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .input-section { margin-bottom: 20px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .input-section input, .input-section select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1em; outline: none; }
        .input-section input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 28px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1em; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; }
        .result-section.show { display: block; }
        .result-section h3 { color: #667eea; margin-bottom: 20px; font-size: 1.4em; }
        
        .result-box { background: white; padding: 20px; border-radius: 10px; margin-bottom: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; }
        .result-label { font-size: 0.9em; color: #666; margin-bottom: 5px; font-weight: 600; text-transform: uppercase; }
        .result-value { font-size: 1.6em; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; }
        
        .formula-box { background: #f9f9f9; padding: 15px; border-radius: 8px; border-left: 4px solid #667eea; margin: 15px 0; }
        .formula-box strong { color: #667eea; }
        
        .shape-visual { background: white; padding: 20px; border-radius: 10px; text-align: center; margin: 20px 0; border: 2px solid #e0e0e0; }
        .shape-visual img { max-width: 200px; height: auto; }
        
        .info-box { background: white; padding: 25px; border-radius: 15px; line-height: 1.8; box-shadow: 0 10px 40px rgba(0,0,0,0.2); margin-top: 20px; }
        .info-box h3 { color: #667eea; margin-bottom: 15px; }
        .info-box p { margin-bottom: 12px; color: #555; }
        
        @media (max-width: 768px) {
            .calc-tabs { grid-template-columns: repeat(2, 1fr); }
            .settings-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header>
        <h1>📐 Area Calculator</h1>
        <p>Calculate area of all geometric shapes</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <!-- Settings -->
            <div class="settings-panel">
                <h4>⚙️ Unit Settings</h4>
                <div class="settings-row">
                    <div class="setting-group">
                        <label>Input Unit</label>
                        <select id="inputUnit">
                            <option value="m">Meters (m)</option>
                            <option value="cm">Centimeters (cm)</option>
                            <option value="mm">Millimeters (mm)</option>
                            <option value="km">Kilometers (km)</option>
                            <option value="in">Inches (in)</option>
                            <option value="ft">Feet (ft)</option>
                            <option value="yd">Yards (yd)</option>
                            <option value="mi">Miles (mi)</option>
                        </select>
                    </div>
                    <div class="setting-group">
                        <label>Output Unit</label>
                        <select id="outputUnit">
                            <option value="m2">Square Meters (m²)</option>
                            <option value="cm2">Square Centimeters (cm²)</option>
                            <option value="mm2">Square Millimeters (mm²)</option>
                            <option value="km2">Square Kilometers (km²)</option>
                            <option value="in2">Square Inches (in²)</option>
                            <option value="ft2">Square Feet (ft²)</option>
                            <option value="yd2">Square Yards (yd²)</option>
                            <option value="mi2">Square Miles (mi²)</option>
                            <option value="ha">Hectares (ha)</option>
                            <option value="acre">Acres</option>
                        </select>
                    </div>
                    <div class="setting-group">
                        <label>Decimal Places</label>
                        <select id="decimalPlaces">
                            <option value="2">2 places</option>
                            <option value="4" selected>4 places</option>
                            <option value="6">6 places</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Square</button>
                <button class="tab-btn" onclick="switchTab(1)">Rectangle</button>
                <button class="tab-btn" onclick="switchTab(2)">Circle</button>
                <button class="tab-btn" onclick="switchTab(3)">Triangle</button>
                <button class="tab-btn" onclick="switchTab(4)">Parallelogram</button>
                <button class="tab-btn" onclick="switchTab(5)">Trapezoid</button>
                <button class="tab-btn" onclick="switchTab(6)">Ellipse</button>
                <button class="tab-btn" onclick="switchTab(7)">Sector</button>
            </div>

            <!-- Square -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 15px;">⬜ Square Area</h3>
                <div class="input-section">
                    <label>Side Length</label>
                    <input type="number" id="square_side" value="5" step="any">
                </div>
                <button class="btn" onclick="calculateSquare()">Calculate Area</button>
            </div>

            <!-- Rectangle -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">▭ Rectangle Area</h3>
                <div class="input-section">
                    <label>Length</label>
                    <input type="number" id="rect_length" value="8" step="any">
                </div>
                <div class="input-section">
                    <label>Width</label>
                    <input type="number" id="rect_width" value="5" step="any">
                </div>
                <button class="btn" onclick="calculateRectangle()">Calculate Area</button>
            </div>

            <!-- Circle -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">⭕ Circle Area</h3>
                <div class="input-section">
                    <label>Radius</label>
                    <input type="number" id="circle_radius" value="5" step="any">
                </div>
                <button class="btn" onclick="calculateCircle()">Calculate Area</button>
            </div>

            <!-- Triangle -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">▲ Triangle Area</h3>
                <div class="input-section">
                    <label>Base</label>
                    <input type="number" id="tri_base" value="6" step="any">
                </div>
                <div class="input-section">
                    <label>Height</label>
                    <input type="number" id="tri_height" value="4" step="any">
                </div>
                <button class="btn" onclick="calculateTriangle()">Calculate Area</button>
            </div>

            <!-- Parallelogram -->
            <div id="tab4" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">▱ Parallelogram Area</h3>
                <div class="input-section">
                    <label>Base</label>
                    <input type="number" id="para_base" value="7" step="any">
                </div>
                <div class="input-section">
                    <label>Height</label>
                    <input type="number" id="para_height" value="4" step="any">
                </div>
                <button class="btn" onclick="calculateParallelogram()">Calculate Area</button>
            </div>

            <!-- Trapezoid -->
            <div id="tab5" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">⏢ Trapezoid Area</h3>
                <div class="input-section">
                    <label>Base 1 (top)</label>
                    <input type="number" id="trap_base1" value="5" step="any">
                </div>
                <div class="input-section">
                    <label>Base 2 (bottom)</label>
                    <input type="number" id="trap_base2" value="9" step="any">
                </div>
                <div class="input-section">
                    <label>Height</label>
                    <input type="number" id="trap_height" value="4" step="any">
                </div>
                <button class="btn" onclick="calculateTrapezoid()">Calculate Area</button>
            </div>

            <!-- Ellipse -->
            <div id="tab6" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">⬭ Ellipse Area</h3>
                <div class="input-section">
                    <label>Major Axis (a)</label>
                    <input type="number" id="ellipse_a" value="6" step="any">
                </div>
                <div class="input-section">
                    <label>Minor Axis (b)</label>
                    <input type="number" id="ellipse_b" value="4" step="any">
                </div>
                <button class="btn" onclick="calculateEllipse()">Calculate Area</button>
            </div>

            <!-- Sector -->
            <div id="tab7" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">◔ Sector Area</h3>
                <div class="input-section">
                    <label>Radius</label>
                    <input type="number" id="sector_radius" value="5" step="any">
                </div>
                <div class="input-section">
                    <label>Central Angle (degrees)</label>
                    <input type="number" id="sector_angle" value="90" step="any">
                </div>
                <button class="btn" onclick="calculateSector()">Calculate Area</button>
            </div>

            <!-- Results -->
            <div class="result-section" id="resultSection">
                <h3>📊 Results</h3>
                <div id="resultContent"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Area Formulas</h3>
            
            <div class="formula-box">
                <strong>Basic Shapes:</strong><br>
                • Square: A = side²<br>
                • Rectangle: A = length × width<br>
                • Circle: A = πr²<br>
                • Triangle: A = (base × height) / 2
            </div>
            
            <div class="formula-box">
                <strong>Quadrilaterals:</strong><br>
                • Parallelogram: A = base × height<br>
                • Trapezoid: A = [(base₁ + base₂) × height] / 2<br>
                • Rhombus: A = (diagonal₁ × diagonal₂) / 2
            </div>
            
            <div class="formula-box">
                <strong>Other Shapes:</strong><br>
                • Ellipse: A = π × a × b<br>
                • Sector: A = (θ/360) × πr²<br>
                • Regular Polygon: A = (perimeter × apothem) / 2
            </div>
            
            <div class="formula-box">
                <strong>Unit Conversions:</strong><br>
                • 1 m² = 10,000 cm² = 10.764 ft²<br>
                • 1 hectare = 10,000 m² = 2.471 acres<br>
                • 1 acre = 43,560 ft² = 4,047 m²<br>
                • 1 km² = 100 hectares = 0.386 mi²
            </div>
        </div>
    </div>

    <script>
        var currentTab = 0;

        function switchTab(index) {
            currentTab = index;
            document.querySelectorAll('.tab-btn').forEach((btn, i) => {
                btn.className = i === index ? 'tab-btn active' : 'tab-btn';
            });
            document.querySelectorAll('.tab-content').forEach((content, i) => {
                content.className = i === index ? 'tab-content active' : 'tab-content';
            });
            document.getElementById('resultSection').classList.remove('show');
        }

        function convertLength(value, fromUnit) {
            // Convert to meters first
            var toMeters = {
                'm': 1,
                'cm': 0.01,
                'mm': 0.001,
                'km': 1000,
                'in': 0.0254,
                'ft': 0.3048,
                'yd': 0.9144,
                'mi': 1609.34
            };
            return value * toMeters[fromUnit];
        }

        function convertArea(value, toUnit) {
            // value is in m², convert to desired unit
            var fromM2 = {
                'm2': 1,
                'cm2': 10000,
                'mm2': 1000000,
                'km2': 0.000001,
                'in2': 1550.0031,
                'ft2': 10.7639,
                'yd2': 1.19599,
                'mi2': 3.861e-7,
                'ha': 0.0001,
                'acre': 0.000247105
            };
            return value * fromM2[toUnit];
        }

        function formatResult(area, formula, shape) {
            var inputUnit = document.getElementById('inputUnit').value;
            var outputUnit = document.getElementById('outputUnit').value;
            var places = parseInt(document.getElementById('decimalPlaces').value);
            
            var unitSymbols = {
                'm2': 'm²', 'cm2': 'cm²', 'mm2': 'mm²', 'km2': 'km²',
                'in2': 'in²', 'ft2': 'ft²', 'yd2': 'yd²', 'mi2': 'mi²',
                'ha': 'ha', 'acre': 'acres'
            };
            
            var areaConverted = convertArea(area, outputUnit);
            
            var html = '';
            html += '<div class="result-box">';
            html += '<div class="result-label">Shape</div>';
            html += '<div class="result-value" style="color: #667eea;">' + shape + '</div>';
            html += '</div>';
            
            html += '<div class="result-box">';
            html += '<div class="result-label">Area</div>';
            html += '<div class="result-value">' + areaConverted.toFixed(places) + ' ' + unitSymbols[outputUnit] + '</div>';
            html += '</div>';
            
            html += '<div class="formula-box" style="background: #e8f5e9; border-left-color: #4CAF50;">';
            html += '<strong style="color: #4CAF50;">Formula Used:</strong><br>' + formula;
            html += '</div>';
            
            // Additional conversions
            html += '<div class="formula-box">';
            html += '<strong>Other Common Units:</strong><br>';
            html += '• ' + convertArea(area, 'm2').toFixed(places) + ' m²<br>';
            html += '• ' + convertArea(area, 'cm2').toFixed(places) + ' cm²<br>';
            html += '• ' + convertArea(area, 'ft2').toFixed(places) + ' ft²<br>';
            html += '• ' + convertArea(area, 'in2').toFixed(places) + ' in²';
            html += '</div>';
            
            return html;
        }

        function calculateSquare() {
            var side = parseFloat(document.getElementById('square_side').value);
            var inputUnit = document.getElementById('inputUnit').value;
            
            if (isNaN(side) || side <= 0) {
                alert('⚠️ Please enter a valid positive number');
                return;
            }
            
            var sideInMeters = convertLength(side, inputUnit);
            var area = sideInMeters * sideInMeters;
            
            var formula = 'A = side² = ' + side + '² = ' + (side * side).toFixed(4);
            
            document.getElementById('resultContent').innerHTML = formatResult(area, formula, 'Square');
            document.getElementById('resultSection').classList.add('show');
        }

        function calculateRectangle() {
            var length = parseFloat(document.getElementById('rect_length').value);
            var width = parseFloat(document.getElementById('rect_width').value);
            var inputUnit = document.getElementById('inputUnit').value;
            
            if (isNaN(length) || isNaN(width) || length <= 0 || width <= 0) {
                alert('⚠️ Please enter valid positive numbers');
                return;
            }
            
            var lengthM = convertLength(length, inputUnit);
            var widthM = convertLength(width, inputUnit);
            var area = lengthM * widthM;
            
            var formula = 'A = length × width = ' + length + ' × ' + width + ' = ' + (length * width).toFixed(4);
            
            document.getElementById('resultContent').innerHTML = formatResult(area, formula, 'Rectangle');
            document.getElementById('resultSection').classList.add('show');
        }

        function calculateCircle() {
            var radius = parseFloat(document.getElementById('circle_radius').value);
            var inputUnit = document.getElementById('inputUnit').value;
            
            if (isNaN(radius) || radius <= 0) {
                alert('⚠️ Please enter a valid positive radius');
                return;
            }
            
            var radiusM = convertLength(radius, inputUnit);
            var area = Math.PI * radiusM * radiusM;
            
            var formula = 'A = πr² = π × ' + radius + '² = ' + (Math.PI * radius * radius).toFixed(4);
            
            document.getElementById('resultContent').innerHTML = formatResult(area, formula, 'Circle');
            document.getElementById('resultSection').classList.add('show');
        }

        function calculateTriangle() {
            var base = parseFloat(document.getElementById('tri_base').value);
            var height = parseFloat(document.getElementById('tri_height').value);
            var inputUnit = document.getElementById('inputUnit').value;
            
            if (isNaN(base) || isNaN(height) || base <= 0 || height <= 0) {
                alert('⚠️ Please enter valid positive numbers');
                return;
            }
            
            var baseM = convertLength(base, inputUnit);
            var heightM = convertLength(height, inputUnit);
            var area = (baseM * heightM) / 2;
            
            var formula = 'A = (base × height) / 2 = (' + base + ' × ' + height + ') / 2 = ' + ((base * height) / 2).toFixed(4);
            
            document.getElementById('resultContent').innerHTML = formatResult(area, formula, 'Triangle');
            document.getElementById('resultSection').classList.add('show');
        }

        function calculateParallelogram() {
            var base = parseFloat(document.getElementById('para_base').value);
            var height = parseFloat(document.getElementById('para_height').value);
            var inputUnit = document.getElementById('inputUnit').value;
            
            if (isNaN(base) || isNaN(height) || base <= 0 || height <= 0) {
                alert('⚠️ Please enter valid positive numbers');
                return;
            }
            
            var baseM = convertLength(base, inputUnit);
            var heightM = convertLength(height, inputUnit);
            var area = baseM * heightM;
            
            var formula = 'A = base × height = ' + base + ' × ' + height + ' = ' + (base * height).toFixed(4);
            
            document.getElementById('resultContent').innerHTML = formatResult(area, formula, 'Parallelogram');
            document.getElementById('resultSection').classList.add('show');
        }

        function calculateTrapezoid() {
            var base1 = parseFloat(document.getElementById('trap_base1').value);
            var base2 = parseFloat(document.getElementById('trap_base2').value);
            var height = parseFloat(document.getElementById('trap_height').value);
            var inputUnit = document.getElementById('inputUnit').value;
            
            if (isNaN(base1) || isNaN(base2) || isNaN(height) || base1 <= 0 || base2 <= 0 || height <= 0) {
                alert('⚠️ Please enter valid positive numbers');
                return;
            }
            
            var base1M = convertLength(base1, inputUnit);
            var base2M = convertLength(base2, inputUnit);
            var heightM = convertLength(height, inputUnit);
            var area = ((base1M + base2M) * heightM) / 2;
            
            var formula = 'A = [(base₁ + base₂) × height] / 2 = [(' + base1 + ' + ' + base2 + ') × ' + height + '] / 2 = ' + (((base1 + base2) * height) / 2).toFixed(4);
            
            document.getElementById('resultContent').innerHTML = formatResult(area, formula, 'Trapezoid');
            document.getElementById('resultSection').classList.add('show');
        }

        function calculateEllipse() {
            var a = parseFloat(document.getElementById('ellipse_a').value);
            var b = parseFloat(document.getElementById('ellipse_b').value);
            var inputUnit = document.getElementById('inputUnit').value;
            
            if (isNaN(a) || isNaN(b) || a <= 0 || b <= 0) {
                alert('⚠️ Please enter valid positive numbers');
                return;
            }
            
            var aM = convertLength(a, inputUnit);
            var bM = convertLength(b, inputUnit);
            var area = Math.PI * aM * bM;
            
            var formula = 'A = π × a × b = π × ' + a + ' × ' + b + ' = ' + (Math.PI * a * b).toFixed(4);
            
            document.getElementById('resultContent').innerHTML = formatResult(area, formula, 'Ellipse');
            document.getElementById('resultSection').classList.add('show');
        }

        function calculateSector() {
            var radius = parseFloat(document.getElementById('sector_radius').value);
            var angle = parseFloat(document.getElementById('sector_angle').value);
            var inputUnit = document.getElementById('inputUnit').value;
            
            if (isNaN(radius) || isNaN(angle) || radius <= 0 || angle <= 0) {
                alert('⚠️ Please enter valid positive numbers');
                return;
            }
            
            var radiusM = convertLength(radius, inputUnit);
            var area = (angle / 360) * Math.PI * radiusM * radiusM;
            
            var formula = 'A = (θ/360) × πr² = (' + angle + '/360) × π × ' + radius + '² = ' + ((angle / 360) * Math.PI * radius * radius).toFixed(4);
            
            document.getElementById('resultContent').innerHTML = formatResult(area, formula, 'Sector');
            document.getElementById('resultSection').classList.add('show');
        }
    </script>
</body>
</html>