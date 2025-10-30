<?php
/**
 * Angle Calculator
 * File: angle-calculator.php
 * Description: Convert angles, calculate trigonometric functions with decimal/fraction output
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angle Calculator - Convert & Calculate Angles Online</title>
    <meta name="description" content="Free angle calculator. Convert between degrees, radians, gradians. Calculate trigonometric functions with decimal or fraction output.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 15px; }
        header { background: rgba(255,255,255,0.1); color: white; padding: 25px 15px; text-align: center; border-radius: 15px; margin-bottom: 20px; backdrop-filter: blur(10px); }
        header h1 { margin: 0 0 8px 0; font-size: 1.8em; }
        header p { margin: 0; opacity: 0.9; font-size: 1em; }
        .container { max-width: 1000px; margin: 0 auto; }
        .breadcrumb { margin-bottom: 15px; text-align: center; }
        .breadcrumb a { color: white; text-decoration: none; font-weight: 500; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 8px; display: inline-block; backdrop-filter: blur(10px); }
        
        .calculator-body { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); margin-bottom: 20px; }
        
        /* Settings Panel */
        .settings-panel { background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); padding: 20px; border-radius: 12px; margin-bottom: 20px; border: 2px solid #667eea; }
        .settings-panel h4 { color: #667eea; margin-bottom: 15px; }
        .settings-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .setting-group { background: white; padding: 12px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .setting-group label { display: block; font-weight: 600; color: #555; margin-bottom: 8px; font-size: 0.9em; }
        .setting-group select { width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 6px; outline: none; cursor: pointer; }
        
        .calc-tabs { display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; }
        .tab-btn { flex: 1; min-width: 120px; padding: 12px; background: #f0f0f0; border: none; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .input-section { margin-bottom: 20px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .input-section input, .input-section select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1em; outline: none; }
        .input-section input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .input-group { display: grid; grid-template-columns: 1fr 150px; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 28px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1em; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; }
        .result-section.show { display: block; }
        .result-section h3 { color: #667eea; margin-bottom: 20px; font-size: 1.4em; }
        
        .result-box { background: white; padding: 20px; border-radius: 10px; margin-bottom: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; }
        .result-label { font-size: 0.9em; color: #666; margin-bottom: 5px; font-weight: 600; text-transform: uppercase; }
        .result-value { font-size: 1.5em; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; line-height: 1.6; }
        
        .fraction { display: inline-flex; flex-direction: column; align-items: center; vertical-align: middle; margin: 0 4px; }
        .fraction .numerator { border-bottom: 2px solid currentColor; padding: 0 8px 2px; }
        .fraction .denominator { padding: 2px 8px 0; }
        
        .info-box { background: white; padding: 25px; border-radius: 15px; line-height: 1.8; box-shadow: 0 10px 40px rgba(0,0,0,0.2); margin-top: 20px; }
        .info-box h3 { color: #667eea; margin-bottom: 15px; }
        .info-box p { margin-bottom: 12px; color: #555; }
        
        .formula-box { background: #f9f9f9; padding: 15px; border-radius: 8px; border-left: 4px solid #667eea; margin: 15px 0; }
        .formula-box strong { color: #667eea; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table th, table td { padding: 8px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        table th { background: #f5f5f5; font-weight: 600; }
        
        @media (max-width: 768px) {
            .calc-tabs { flex-direction: column; }
            .input-group { grid-template-columns: 1fr; }
            .settings-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header>
        <h1>📐 Angle Calculator</h1>
        <p>Convert, calculate, and analyze angles</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <!-- Settings Panel -->
            <div class="settings-panel">
                <h4>⚙️ Output Settings</h4>
                <div class="settings-row">
                    <div class="setting-group">
                        <label>📊 Output Format</label>
                        <select id="outputFormat">
                            <option value="decimal">Decimal (e.g., 0.7071)</option>
                            <option value="fraction">Fraction (e.g., 1/√2)</option>
                            <option value="both">Both Formats</option>
                        </select>
                    </div>
                    <div class="setting-group">
                        <label>🎯 Decimal Places</label>
                        <select id="decimalPlaces">
                            <option value="2">2 places</option>
                            <option value="4">4 places</option>
                            <option value="6" selected>6 places</option>
                            <option value="8">8 places</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Convert Angles</button>
                <button class="tab-btn" onclick="switchTab(1)">Trigonometry</button>
                <button class="tab-btn" onclick="switchTab(2)">Triangle Angles</button>
                <button class="tab-btn" onclick="switchTab(3)">Angle Types</button>
            </div>

            <!-- Tab 1: Convert Angles -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 15px;">🔄 Convert Between Angle Units</h3>
                
                <div class="input-section">
                    <label>Enter Angle Value</label>
                    <div class="input-group">
                        <input type="number" id="convertValue" value="45" step="any">
                        <select id="convertFrom">
                            <option value="degrees">Degrees (°)</option>
                            <option value="radians">Radians (rad)</option>
                            <option value="gradians">Gradians (gon)</option>
                            <option value="turns">Turns</option>
                        </select>
                    </div>
                </div>
                
                <button class="btn" onclick="convertAngle()">Convert Angle</button>
            </div>

            <!-- Tab 2: Trigonometry -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">📊 Trigonometric Functions</h3>
                
                <div class="input-section">
                    <label>Enter Angle</label>
                    <div class="input-group">
                        <input type="number" id="trigAngle" value="30" step="any">
                        <select id="trigUnit">
                            <option value="degrees">Degrees (°)</option>
                            <option value="radians">Radians (rad)</option>
                        </select>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateTrig()">Calculate Trig Functions</button>
            </div>

            <!-- Tab 3: Triangle Angles -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">📐 Find Missing Angle in Triangle</h3>
                <p style="margin-bottom: 15px; color: #666;">Sum of all angles in a triangle = 180°</p>
                
                <div class="input-section">
                    <label>Angle A (degrees)</label>
                    <input type="number" id="angleA" value="60" step="any">
                </div>
                
                <div class="input-section">
                    <label>Angle B (degrees)</label>
                    <input type="number" id="angleB" value="50" step="any">
                </div>
                
                <button class="btn" onclick="findMissingAngle()">Find Missing Angle C</button>
            </div>

            <!-- Tab 4: Angle Types -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">🔍 Identify Angle Type</h3>
                
                <div class="input-section">
                    <label>Enter Angle (degrees)</label>
                    <input type="number" id="identifyAngle" value="45" step="any">
                </div>
                
                <button class="btn" onclick="identifyAngleType()">Identify Angle Type</button>
            </div>

            <!-- Results -->
            <div class="result-section" id="resultSection">
                <h3>📊 Results</h3>
                <div id="resultContent"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Angle Calculator Guide</h3>
            
            <div class="formula-box">
                <strong>Angle Conversions:</strong><br>
                • Degrees to Radians: rad = deg × (π/180)<br>
                • Radians to Degrees: deg = rad × (180/π)<br>
                • Degrees to Gradians: gon = deg × (10/9)<br>
                • Turns: 1 turn = 360° = 2π rad
            </div>
            
            <div class="formula-box">
                <strong>Output Formats:</strong><br>
                • <strong>Decimal:</strong> Shows results as decimal points (e.g., 0.7071)<br>
                • <strong>Fraction:</strong> Shows results as fractions or exact forms (e.g., √2/2, 1/2)<br>
                • <strong>Both:</strong> Shows both decimal and fraction/exact form
            </div>
            
            <div class="formula-box">
                <strong>Special Trigonometric Values:</strong><br>
                • sin(30°) = 1/2<br>
                • sin(45°) = √2/2<br>
                • sin(60°) = √3/2<br>
                • cos(30°) = √3/2<br>
                • tan(45°) = 1
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

        function gcd(a, b) {
            a = Math.abs(Math.round(a * 1000000));
            b = Math.abs(Math.round(b * 1000000));
            while (b !== 0) {
                var temp = b;
                b = a % b;
                a = temp;
            }
            return a || 1;
        }

        function toFraction(decimal) {
            if (Math.abs(decimal - Math.round(decimal)) < 0.000001) {
                return { num: Math.round(decimal), den: 1, isInt: true };
            }
            
            var sign = decimal < 0 ? -1 : 1;
            decimal = Math.abs(decimal);
            
            var bestNum = 1, bestDen = 1, bestErr = Math.abs(decimal - 1);
            
            for (var den = 1; den <= 10000; den++) {
                var num = Math.round(decimal * den);
                var err = Math.abs(decimal - num / den);
                if (err < bestErr) {
                    bestNum = num;
                    bestDen = den;
                    bestErr = err;
                }
                if (err < 0.000001) break;
            }
            
            var divisor = gcd(bestNum, bestDen);
            return {
                num: sign * Math.round(bestNum / divisor),
                den: Math.round(bestDen / divisor),
                isInt: Math.round(bestDen / divisor) === 1
            };
        }

        function getExactTrigValue(angle, func) {
            // Common exact values
            var exactValues = {
                'sin': {
                    0: '0',
                    30: '1/2',
                    45: '√2/2',
                    60: '√3/2',
                    90: '1',
                    120: '√3/2',
                    135: '√2/2',
                    150: '1/2',
                    180: '0',
                    210: '-1/2',
                    225: '-√2/2',
                    240: '-√3/2',
                    270: '-1',
                    300: '-√3/2',
                    315: '-√2/2',
                    330: '-1/2',
                    360: '0'
                },
                'cos': {
                    0: '1',
                    30: '√3/2',
                    45: '√2/2',
                    60: '1/2',
                    90: '0',
                    120: '-1/2',
                    135: '-√2/2',
                    150: '-√3/2',
                    180: '-1',
                    210: '-√3/2',
                    225: '-√2/2',
                    240: '-1/2',
                    270: '0',
                    300: '1/2',
                    315: '√2/2',
                    330: '√3/2',
                    360: '1'
                },
                'tan': {
                    0: '0',
                    30: '1/√3',
                    45: '1',
                    60: '√3',
                    90: '∞',
                    135: '-1',
                    150: '-1/√3',
                    180: '0',
                    225: '1',
                    270: '∞',
                    315: '-1',
                    360: '0'
                }
            };
            
            if (exactValues[func] && exactValues[func][angle]) {
                return exactValues[func][angle];
            }
            return null;
        }

        function formatNumber(num, forceDecimal) {
            if (!isFinite(num)) return '∞';
            
            var format = forceDecimal ? 'decimal' : document.getElementById('outputFormat').value;
            var places = parseInt(document.getElementById('decimalPlaces').value);
            
            if (format === 'decimal') {
                return num.toFixed(places);
            } else if (format === 'fraction') {
                var frac = toFraction(num);
                if (frac.isInt) return frac.num.toString();
                return '<span class="fraction"><span class="numerator">' + frac.num + '</span><span class="denominator">' + frac.den + '</span></span>';
            } else { // both
                var frac = toFraction(num);
                if (frac.isInt) return frac.num.toString();
                return num.toFixed(places) + ' = <span class="fraction"><span class="numerator">' + frac.num + '</span><span class="denominator">' + frac.den + '</span></span>';
            }
        }

        function formatAngleValue(value, exact) {
            var format = document.getElementById('outputFormat').value;
            var places = parseInt(document.getElementById('decimalPlaces').value);
            
            if (format === 'decimal') {
                return value.toFixed(places);
            } else if (format === 'fraction' && exact) {
                return exact;
            } else if (format === 'both' && exact) {
                return value.toFixed(places) + ' = ' + exact;
            } else {
                return formatNumber(value);
            }
        }

        function convertAngle() {
            var value = parseFloat(document.getElementById('convertValue').value);
            var fromUnit = document.getElementById('convertFrom').value;
            
            if (isNaN(value)) {
                alert('⚠️ Please enter a valid number');
                return;
            }
            
            var degrees, radians, gradians, turns;
            
            switch(fromUnit) {
                case 'degrees':
                    degrees = value;
                    radians = value * (Math.PI / 180);
                    gradians = value * (10 / 9);
                    turns = value / 360;
                    break;
                case 'radians':
                    radians = value;
                    degrees = value * (180 / Math.PI);
                    gradians = degrees * (10 / 9);
                    turns = degrees / 360;
                    break;
                case 'gradians':
                    gradians = value;
                    degrees = value * (9 / 10);
                    radians = degrees * (Math.PI / 180);
                    turns = degrees / 360;
                    break;
                case 'turns':
                    turns = value;
                    degrees = value * 360;
                    radians = degrees * (Math.PI / 180);
                    gradians = degrees * (10 / 9);
                    break;
            }
            
            var html = '';
            html += '<div class="result-box">';
            html += '<div class="result-label">Original Value</div>';
            html += '<div class="result-value" style="color: #667eea;">' + value + ' ' + getUnitSymbol(fromUnit) + '</div>';
            html += '</div>';
            
            html += '<div class="result-box">';
            html += '<div class="result-label">🔵 Degrees</div>';
            html += '<div class="result-value">' + formatNumber(degrees, true) + '°</div>';
            html += '</div>';
            
            // Check for exact radian values
            var radExact = null;
            if (Math.abs(radians - 0) < 0.0001) radExact = '0';
            else if (Math.abs(radians - Math.PI/6) < 0.0001) radExact = 'π/6';
            else if (Math.abs(radians - Math.PI/4) < 0.0001) radExact = 'π/4';
            else if (Math.abs(radians - Math.PI/3) < 0.0001) radExact = 'π/3';
            else if (Math.abs(radians - Math.PI/2) < 0.0001) radExact = 'π/2';
            else if (Math.abs(radians - Math.PI) < 0.0001) radExact = 'π';
            else if (Math.abs(radians - 2*Math.PI) < 0.0001) radExact = '2π';
            
            html += '<div class="result-box">';
            html += '<div class="result-label">🔴 Radians</div>';
            html += '<div class="result-value">' + formatAngleValue(radians, radExact) + ' rad</div>';
            html += '</div>';
            
            html += '<div class="result-box">';
            html += '<div class="result-label">🟢 Gradians</div>';
            html += '<div class="result-value">' + formatNumber(gradians, true) + ' gon</div>';
            html += '</div>';
            
            html += '<div class="result-box">';
            html += '<div class="result-label">🟡 Turns</div>';
            html += '<div class="result-value">' + formatNumber(turns) + ' turns</div>';
            html += '</div>';
            
            document.getElementById('resultContent').innerHTML = html;
            document.getElementById('resultSection').classList.add('show');
        }

        function getUnitSymbol(unit) {
            switch(unit) {
                case 'degrees': return '°';
                case 'radians': return 'rad';
                case 'gradians': return 'gon';
                case 'turns': return 'turns';
                default: return '';
            }
        }

        function calculateTrig() {
            var angle = parseFloat(document.getElementById('trigAngle').value);
            var unit = document.getElementById('trigUnit').value;
            
            if (isNaN(angle)) {
                alert('⚠️ Please enter a valid angle');
                return;
            }
            
            var radians = unit === 'degrees' ? angle * (Math.PI / 180) : angle;
            var degrees = unit === 'degrees' ? angle : angle * (180 / Math.PI);
            
            // Normalize to 0-360
            var normDeg = ((degrees % 360) + 360) % 360;
            
            var sinVal = Math.sin(radians);
            var cosVal = Math.cos(radians);
            var tanVal = Math.tan(radians);
            var cscVal = 1 / sinVal;
            var secVal = 1 / cosVal;
            var cotVal = 1 / tanVal;
            
            var sinExact = getExactTrigValue(normDeg, 'sin');
            var cosExact = getExactTrigValue(normDeg, 'cos');
            var tanExact = getExactTrigValue(normDeg, 'tan');
            
            var html = '';
            html += '<div class="result-box">';
            html += '<div class="result-label">Input Angle</div>';
            html += '<div class="result-value" style="color: #667eea;">' + angle + ' ' + getUnitSymbol(unit) + '</div>';
            html += '</div>';
            
            html += '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">';
            
            html += '<div class="result-box" style="border-left-color: #2196F3;">';
            html += '<div class="result-label">sin(θ)</div>';
            html += '<div class="result-value" style="color: #2196F3;">' + formatAngleValue(sinVal, sinExact) + '</div>';
            html += '</div>';
            
            html += '<div class="result-box" style="border-left-color: #4CAF50;">';
            html += '<div class="result-label">cos(θ)</div>';
            html += '<div class="result-value" style="color: #4CAF50;">' + formatAngleValue(cosVal, cosExact) + '</div>';
            html += '</div>';
            
            html += '<div class="result-box" style="border-left-color: #FF9800;">';
            html += '<div class="result-label">tan(θ)</div>';
            html += '<div class="result-value" style="color: #FF9800;">' + (tanExact === '∞' ? '∞' : formatAngleValue(tanVal, tanExact)) + '</div>';
            html += '</div>';
            
            html += '<div class="result-box" style="border-left-color: #9C27B0;">';
            html += '<div class="result-label">csc(θ)</div>';
            html += '<div class="result-value" style="color: #9C27B0;">' + (isFinite(cscVal) ? formatNumber(cscVal) : '∞') + '</div>';
            html += '</div>';
            
            html += '<div class="result-box" style="border-left-color: #F44336;">';
            html += '<div class="result-label">sec(θ)</div>';
            html += '<div class="result-value" style="color: #F44336;">' + (isFinite(secVal) ? formatNumber(secVal) : '∞') + '</div>';
            html += '</div>';
            
            html += '<div class="result-box" style="border-left-color: #00BCD4;">';
            html += '<div class="result-label">cot(θ)</div>';
            html += '<div class="result-value" style="color: #00BCD4;">' + (isFinite(cotVal) ? formatNumber(cotVal) : '∞') + '</div>';
            html += '</div>';
            
            html += '</div>';
            
            // Special values table
            html += '<div class="formula-box" style="background: #fff3cd; margin-top: 15px;">';
            html += '<strong style="color: #f57c00;">📌 Special Angle Values:</strong><br>';
            html += '<table><tr><th>Angle</th><th>sin</th><th>cos</th><th>tan</th></tr>';
            html += '<tr><td>0°</td><td>0</td><td>1</td><td>0</td></tr>';
            html += '<tr><td>30°</td><td>1/2</td><td>√3/2</td><td>1/√3</td></tr>';
            html += '<tr><td>45°</td><td>√2/2</td><td>√2/2</td><td>1</td></tr>';
            html += '<tr><td>60°</td><td>√3/2</td><td>1/2</td><td>√3</td></tr>';
            html += '<tr><td>90°</td><td>1</td><td>0</td><td>∞</td></tr></table>';
            html += '</div>';
            
            document.getElementById('resultContent').innerHTML = html;
            document.getElementById('resultSection').classList.add('show');
        }

        function findMissingAngle() {
            var angleA = parseFloat(document.getElementById('angleA').value);
            var angleB = parseFloat(document.getElementById('angleB').value);
            
            if (isNaN(angleA) || isNaN(angleB)) {
                alert('⚠️ Please enter valid angles');
                return;
            }
            
            if (angleA <= 0 || angleB <= 0) {
                alert('⚠️ Angles must be positive');
                return;
            }
            
            if (angleA + angleB >= 180) {
                alert('⚠️ Sum of two angles cannot be ≥ 180°');
                return;
            }
            
            var angleC = 180 - angleA - angleB;
            
            var html = '';
            html += '<div class="result-box">';
            html += '<div class="result-label">Triangle Angles</div>';
            html += '<div class="result-value" style="color: #667eea; font-size: 1.2em;">';
            html += '∠A = ' + formatNumber(angleA, true) + '°<br>';
            html += '∠B = ' + formatNumber(angleB, true) + '°<br>';
            html += '∠C = ' + formatNumber(angleC, true) + '°';
            html += '</div></div>';
            
            html += '<div class="result-box" style="border-left-color: #4CAF50;">';
            html += '<div class="result-label">✓ Verification</div>';
            html += '<div class="result-value" style="color: #4CAF50; font-size: 1.1em;">';
            html += angleA + '° + ' + angleB + '° + ' + angleC.toFixed(2) + '° = 180°';
            html += '</div></div>';
            
            var triangleType = '';
            if (angleA === 90 || angleB === 90 || Math.abs(angleC - 90) < 0.01) {
                triangleType = 'Right Triangle';
            } else if (angleA < 90 && angleB < 90 && angleC < 90) {
                triangleType = 'Acute Triangle';
            } else {
                triangleType = 'Obtuse Triangle';
            }
            
            html += '<div class="formula-box" style="background: #e3f2fd;">';
            html += '<strong style="color: #1976d2;">📐 Triangle Type: ' + triangleType + '</strong>';
            html += '</div>';
            
            document.getElementById('resultContent').innerHTML = html;
            document.getElementById('resultSection').classList.add('show');
        }

        function identifyAngleType() {
            var angle = parseFloat(document.getElementById('identifyAngle').value);
            
            if (isNaN(angle)) {
                alert('⚠️ Please enter a valid angle');
                return;
            }
            
            angle = ((angle % 360) + 360) % 360;
            
            var type = '', description = '', color = '';
            
            if (angle === 0) {
                type = 'Zero Angle';
                description = 'An angle of exactly 0°';
                color = '#9E9E9E';
            } else if (angle > 0 && angle < 90) {
                type = 'Acute Angle';
                description = 'An angle between 0° and 90°';
                color = '#4CAF50';
            } else if (angle === 90) {
                type = 'Right Angle';
                description = 'An angle of exactly 90°';
                color = '#2196F3';
            } else if (angle > 90 && angle < 180) {
                type = 'Obtuse Angle';
                description = 'An angle between 90° and 180°';
                color = '#FF9800';
            } else if (angle === 180) {
                type = 'Straight Angle';
                description = 'An angle of exactly 180°';
                color = '#9C27B0';
            } else if (angle > 180 && angle < 360) {
                type = 'Reflex Angle';
                description = 'An angle between 180° and 360°';
                color = '#F44336';
            } else if (angle === 360) {
                type = 'Full Angle';
                description = 'An angle of exactly 360°';
                color = '#00BCD4';
            }
            
            var html = '';
            html += '<div class="result-box">';
            html += '<div class="result-label">Angle</div>';
            html += '<div class="result-value" style="color: #667eea;">' + formatNumber(angle, true) + '°</div>';
            html += '</div>';
            
            html += '<div class="result-box" style="border-left-color: ' + color + ';">';
            html += '<div class="result-label">Type</div>';
            html += '<div class="result-value" style="color: ' + color + ';">' + type + '</div>';
            html += '<p style="margin-top: 10px; color: #666;">' + description + '</p>';
            html += '</div>';
            
            if (angle < 90) {
                html += '<div class="formula-box" style="background: #e8f5e9;">';
                html += '<strong style="color: #4CAF50;">Related Angles:</strong><br>';
                html += '• Complementary: ' + formatNumber(90 - angle, true) + '°<br>';
                html += '• Supplementary: ' + formatNumber(180 - angle, true) + '°';
                html += '</div>';
            } else if (angle < 180) {
                html += '<div class="formula-box" style="background: #e8f5e9;">';
                html += '<strong style="color: #4CAF50;">Related Angles:</strong><br>';
                html += '• Supplementary: ' + formatNumber(180 - angle, true) + '°';
                html += '</div>';
            }
            
            document.getElementById('resultContent').innerHTML = html;
            document.getElementById('resultSection').classList.add('show');
        }
    </script>
</body>
</html>