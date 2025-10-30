<?php
/**
 * Advanced Polygon Calculator
 * File: polygon-calculator.php
 * Description: Complete polygon calculator with regular, irregular, coordinate-based calculations
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Advanced Polygon Calculator - All Types & Methods</title>
    <meta name="description" content="Calculate area, perimeter, angles for regular & irregular polygons. Includes coordinate method, Heron's formula, and all polygon properties.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 12px; }
        header { background: rgba(255,255,255,0.1); color: white; padding: 20px 16px; text-align: center; border-radius: 12px; margin-bottom: 16px; backdrop-filter: blur(10px); }
        header h1 { font-size: 1.5rem; margin-bottom: 8px; font-weight: 700; }
        header p { font-size: 0.875rem; opacity: 0.9; }
        .container { max-width: 100%; margin: 0 auto; }
        .breadcrumb { margin-bottom: 16px; text-align: center; }
        .breadcrumb a { color: white; text-decoration: none; font-weight: 500; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 8px; display: inline-block; backdrop-filter: blur(10px); font-size: 0.875rem; }
        .calculator-body { background: white; padding: 16px; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); margin-bottom: 16px; }
        .calc-tabs { display: grid; grid-template-columns: repeat(auto-fit, minmax(85px, 1fr)); gap: 8px; margin-bottom: 16px; }
        .tab-btn { padding: 12px 8px; background: #f0f0f0; border: none; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; font-size: 0.75rem; line-height: 1.3; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .input-section { margin-bottom: 16px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 0.9rem; }
        .input-section input, .input-section select, .input-section textarea { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; }
        .input-section input, .input-section textarea { font-family: 'Courier New', monospace; }
        .input-section textarea { min-height: 80px; resize: vertical; }
        .input-section input:focus, .input-section textarea:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .input-hint { font-size: 0.8rem; color: #666; margin-top: 6px; font-style: italic; }
        .polygon-preview { background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 16px; border: 2px solid #667eea; }
        .polygon-name { font-size: 1.2rem; font-weight: bold; color: #667eea; margin-bottom: 8px; }
        .polygon-icon { font-size: 4rem; margin: 10px 0; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .examples { display: grid; grid-template-columns: repeat(auto-fit, minmax(110px, 1fr)); gap: 8px; margin: 16px 0; }
        .example-btn { padding: 10px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .example-btn:hover { background: #667eea; color: white; transform: translateY(-2px); }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.3rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px; margin-bottom: 16px; }
        .result-box { background: white; padding: 16px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; }
        .result-label { font-size: 0.75rem; color: #666; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .result-value { font-size: 1.3rem; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; word-break: break-word; line-height: 1.4; }
        .formula-box { background: #f9f9f9; padding: 14px; border-radius: 8px; border-left: 4px solid #667eea; margin: 14px 0; font-size: 0.85rem; line-height: 1.7; }
        .formula-box strong { color: #667eea; display: block; margin-bottom: 6px; }
        .step-box { background: #fff3cd; padding: 14px; border-radius: 8px; border-left: 4px solid #ffc107; margin: 14px 0; }
        .step-box strong { color: #f57c00; display: block; margin-bottom: 8px; }
        .step { padding: 6px 0; border-bottom: 1px solid #ffe082; font-family: 'Courier New', monospace; font-size: 0.85rem; }
        .step:last-child { border-bottom: none; }
        .info-box { background: white; padding: 20px; border-radius: 12px; line-height: 1.8; box-shadow: 0 8px 30px rgba(0,0,0,0.15); margin-top: 16px; }
        .info-box h3 { color: #667eea; margin-bottom: 14px; font-size: 1.2rem; }
        
        @media (min-width: 768px) { 
            body { padding: 24px; }
            .container { max-width: 720px; margin: 0 auto; }
            header h1 { font-size: 2rem; }
            .calculator-body { padding: 24px; }
        }
        @media (min-width: 1024px) { .container { max-width: 960px; } }
        @media (min-width: 1280px) { .container { max-width: 1100px; } }
        @media (max-width: 479px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .result-value { font-size: 1.1rem; }
            .calc-tabs { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <header>
        <h1>⬡ Advanced Polygon Calculator</h1>
        <p>Regular, Irregular & All Calculation Methods</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="javascript:void(0)" onclick="alert('Back to calculators - replace with actual link')">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Regular<br>Polygon</button>
                <button class="tab-btn" onclick="switchTab(1)">By<br>Apothem</button>
                <button class="tab-btn" onclick="switchTab(2)">By<br>Radius</button>
                <button class="tab-btn" onclick="switchTab(3)">Triangle<br>(3 sides)</button>
                <button class="tab-btn" onclick="switchTab(4)">Irregular<br>Polygon</button>
                <button class="tab-btn" onclick="switchTab(5)">By<br>Coordinates</button>
            </div>

            <!-- Tab 1: Regular Polygon by Side -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📏 Regular Polygon (Side Length)</h3>
                
                <div class="polygon-preview" id="preview_side">
                    <div class="polygon-name">Regular Hexagon</div>
                    <div class="polygon-icon">⬡</div>
                    <div style="font-size:0.9rem;color:#666;">6 sides</div>
                </div>
                
                <div class="input-section">
                    <label>Number of Sides (n)</label>
                    <select id="sides_n" onchange="updatePreview('side')">
                        <option value="3">3 - Triangle</option>
                        <option value="4">4 - Square</option>
                        <option value="5">5 - Pentagon</option>
                        <option value="6" selected>6 - Hexagon</option>
                        <option value="7">7 - Heptagon</option>
                        <option value="8">8 - Octagon</option>
                        <option value="9">9 - Nonagon</option>
                        <option value="10">10 - Decagon</option>
                        <option value="12">12 - Dodecagon</option>
                        <option value="20">20 - Icosagon</option>
                    </select>
                </div>
                <div class="input-section">
                    <label>Side Length (s)</label>
                    <input type="number" id="side_length" value="5" step="any" min="0">
                    <div class="input-hint">Length of one side</div>
                </div>
                <button class="btn" onclick="calcBySide()">Calculate All Properties</button>
                <div class="examples">
                    <button class="example-btn" onclick="setSide(6,5)">Hexagon s=5</button>
                    <button class="example-btn" onclick="setSide(8,4)">Octagon s=4</button>
                    <button class="example-btn" onclick="setSide(5,6)">Pentagon s=6</button>
                </div>
            </div>

            <!-- Tab 2: By Apothem -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📐 Calculate by Apothem</h3>
                
                <div class="polygon-preview" id="preview_apothem">
                    <div class="polygon-name">Regular Hexagon</div>
                    <div class="polygon-icon">⬡</div>
                    <div style="font-size:0.9rem;color:#666;">6 sides</div>
                </div>
                
                <div class="input-section">
                    <label>Number of Sides (n)</label>
                    <select id="apothem_n" onchange="updatePreview('apothem')">
                        <option value="3">3 - Triangle</option>
                        <option value="4">4 - Square</option>
                        <option value="5">5 - Pentagon</option>
                        <option value="6" selected>6 - Hexagon</option>
                        <option value="8">8 - Octagon</option>
                        <option value="10">10 - Decagon</option>
                    </select>
                </div>
                <div class="input-section">
                    <label>Apothem (a)</label>
                    <input type="number" id="apothem_value" value="4.33" step="any" min="0">
                    <div class="input-hint">Distance from center to side midpoint</div>
                </div>
                <button class="btn" onclick="calcByApothem()">Calculate Properties</button>
            </div>

            <!-- Tab 3: By Circumradius -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">⭕ Calculate by Circumradius</h3>
                
                <div class="polygon-preview" id="preview_radius">
                    <div class="polygon-name">Regular Hexagon</div>
                    <div class="polygon-icon">⬡</div>
                    <div style="font-size:0.9rem;color:#666;">6 sides</div>
                </div>
                
                <div class="input-section">
                    <label>Number of Sides (n)</label>
                    <select id="radius_n" onchange="updatePreview('radius')">
                        <option value="3">3 - Triangle</option>
                        <option value="4">4 - Square</option>
                        <option value="5">5 - Pentagon</option>
                        <option value="6" selected>6 - Hexagon</option>
                        <option value="8">8 - Octagon</option>
                    </select>
                </div>
                <div class="input-section">
                    <label>Circumradius (R)</label>
                    <input type="number" id="radius_value" value="5" step="any" min="0">
                    <div class="input-hint">Distance from center to vertex</div>
                </div>
                <button class="btn" onclick="calcByRadius()">Calculate Properties</button>
            </div>

            <!-- Tab 4: Triangle (Heron's Formula) -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">🔺 Triangle - All 3 Sides</h3>
                
                <div class="polygon-preview">
                    <div class="polygon-icon">🔺</div>
                    <div style="font-size:0.9rem;color:#666;">3 sides</div>
                </div>
                
                <div class="input-section">
                    <label>Side A</label>
                    <input type="number" id="tri_a" value="3" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Side B</label>
                    <input type="number" id="tri_b" value="4" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Side C</label>
                    <input type="number" id="tri_c" value="5" step="any" min="0">
                </div>
                <button class="btn" onclick="calcTriangle()">Calculate Triangle</button>
                <div class="examples">
                    <button class="example-btn" onclick="setTri(3,4,5)">3-4-5</button>
                    <button class="example-btn" onclick="setTri(5,5,5)">Equilateral</button>
                    <button class="example-btn" onclick="setTri(5,5,8)">Isosceles</button>
                </div>
            </div>

            <!-- Tab 5: Irregular Polygon -->
            <div id="tab4" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📊 Irregular Polygon (All Sides)</h3>
                
                <div class="input-section">
                    <label>Enter All Side Lengths</label>
                    <textarea id="irregular_sides" placeholder="Enter sides separated by commas or spaces&#10;Example: 3, 4, 5, 6">5, 7, 8, 6</textarea>
                    <div class="input-hint">For perimeter only (area requires coordinates)</div>
                </div>
                <button class="btn" onclick="calcIrregular()">Calculate Perimeter</button>
                <div class="examples">
                    <button class="example-btn" onclick="setIrregular('5,7,8,6')">Quadrilateral</button>
                    <button class="example-btn" onclick="setIrregular('3,4,5,6,7')">Pentagon</button>
                </div>
            </div>

            <!-- Tab 6: By Coordinates (Shoelace Formula) -->
            <div id="tab5" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📍 Polygon from Coordinates</h3>
                
                <div class="input-section">
                    <label>Enter Coordinates (x, y)</label>
                    <textarea id="coord_input" placeholder="Enter coordinates as x,y pairs (one per line)&#10;Example:&#10;0, 0&#10;4, 0&#10;4, 3&#10;0, 3">0, 0
4, 0
4, 3
0, 3</textarea>
                    <div class="input-hint">Uses Shoelace formula for area</div>
                </div>
                <button class="btn" onclick="calcByCoordinates()">Calculate Area & Perimeter</button>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Advanced Methods & Formulas</h3>
            <div class="formula-box">
                <strong>Regular Polygon - Side Length:</strong>
                • Perimeter: P = n × s<br>
                • Area: A = (n × s² × cot(π/n)) / 4<br>
                • Interior Angle: (n-2) × 180° / n
            </div>
            <div class="formula-box">
                <strong>Triangle - Heron's Formula:</strong>
                • Semi-perimeter: s = (a + b + c) / 2<br>
                • Area: A = √[s(s-a)(s-b)(s-c)]
            </div>
            <div class="formula-box">
                <strong>Shoelace Formula (Coordinates):</strong>
                Area = ½|Σ(x<sub>i</sub>y<sub>i+1</sub> - x<sub>i+1</sub>y<sub>i</sub>)|
            </div>
            <div class="formula-box">
                <strong>By Apothem:</strong>
                • Side: s = 2a × tan(π/n)<br>
                • Area: A = (perimeter × apothem) / 2
            </div>
            <div class="formula-box">
                <strong>By Circumradius:</strong>
                • Side: s = 2R × sin(π/n)<br>
                • Apothem: a = R × cos(π/n)
            </div>
        </div>
    </div>

    <script>
        const polygonNames = {
            3: {name: 'Triangle', icon: '🔺'},
            4: {name: 'Square', icon: '⬛'},
            5: {name: 'Pentagon', icon: '⬟'},
            6: {name: 'Hexagon', icon: '⬡'},
            7: {name: 'Heptagon', icon: '⬢'},
            8: {name: 'Octagon', icon: '⯃'},
            9: {name: 'Nonagon', icon: '⬢'},
            10: {name: 'Decagon', icon: '⬢'},
            12: {name: 'Dodecagon', icon: '⬢'},
            20: {name: 'Icosagon', icon: '⬢'}
        };
        
        function switchTab(i) {
            document.querySelectorAll('.tab-btn').forEach((b,j) => {
                b.className = j === i ? 'tab-btn active' : 'tab-btn';
            });
            document.querySelectorAll('.tab-content').forEach((c,j) => {
                c.className = j === i ? 'tab-content active' : 'tab-content';
            });
            document.getElementById('result').classList.remove('show');
        }
        
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
            document.getElementById('result').scrollIntoView({behavior: 'smooth', block: 'nearest'});
        }
        
        function updatePreview(type) {
            const n = parseInt(document.getElementById(type + '_n').value);
            const info = polygonNames[n] || {name: `${n}-sided Polygon`, icon: '⬢'};
            
            const preview = document.getElementById('preview_' + type);
            if (preview) {
                const nameElement = preview.querySelector('.polygon-name');
                const iconElement = preview.querySelector('.polygon-icon');
                const sidesElement = preview.querySelector('div:last-child');
                
                if (nameElement) nameElement.textContent = 'Regular ' + info.name;
                if (iconElement) iconElement.textContent = info.icon;
                if (sidesElement) sidesElement.textContent = `${n} sides`;
            }
        }
        
        function setSide(n,s) {
            document.getElementById('sides_n').value = n;
            document.getElementById('side_length').value = s;
            updatePreview('side');
        }
        
        function setTri(a,b,c) {
            document.getElementById('tri_a').value = a;
            document.getElementById('tri_b').value = b;
            document.getElementById('tri_c').value = c;
        }
        
        function setIrregular(str) {
            document.getElementById('irregular_sides').value = str;
        }
        
        function calcBySide() {
            const n = parseInt(document.getElementById('sides_n').value);
            const s = parseFloat(document.getElementById('side_length').value);
            
            if(isNaN(n) || n < 3) return alert('⚠️ Sides must be ≥ 3');
            if(isNaN(s) || s <= 0) return alert('⚠️ Enter valid side length');
            
            calculateRegularPolygon(n, s, 'side');
        }
        
        function calcByApothem() {
            const n = parseInt(document.getElementById('apothem_n').value);
            const a = parseFloat(document.getElementById('apothem_value').value);
            
            if(isNaN(n) || n < 3) return alert('⚠️ Sides must be ≥ 3');
            if(isNaN(a) || a <= 0) return alert('⚠️ Enter valid apothem');
            
            const s = 2 * a * Math.tan(Math.PI / n);
            calculateRegularPolygon(n, s, 'apothem', a);
        }
        
        function calcByRadius() {
            const n = parseInt(document.getElementById('radius_n').value);
            const r = parseFloat(document.getElementById('radius_value').value);
            
            if(isNaN(n) || n < 3) return alert('⚠️ Sides must be ≥ 3');
            if(isNaN(r) || r <= 0) return alert('⚠️ Enter valid radius');
            
            const s = 2 * r * Math.sin(Math.PI / n);
            calculateRegularPolygon(n, s, 'radius', r);
        }
        
        function calculateRegularPolygon(n, s, type, val) {
            const info = polygonNames[n] || {name: `${n}-sided Polygon`, icon: '⬢'};
            
            const perimeter = n * s;
            const apothem = s / (2 * Math.tan(Math.PI / n));
            const area = (n * s * s) / (4 * Math.tan(Math.PI / n));
            const radius = s / (2 * Math.sin(Math.PI / n));
            const interiorAngle = ((n - 2) * 180) / n;
            const exteriorAngle = 360 / n;
            const diagonals = (n * (n - 3)) / 2;
            const sumAngles = (n - 2) * 180;
            
            let html = `<div style="text-align:center;font-size:3rem;margin-bottom:16px;">${info.icon}</div>`;
            
            html += `<div class="result-box" style="border-left-color:#667eea;margin-bottom:16px;">
                <div class="result-label">Polygon Type</div>
                <div class="result-value" style="color:#667eea;font-size:1.2rem;">Regular ${info.name} (${n} sides)</div>
            </div>`;
            
            html += `<div class="stats-grid">
                <div class="result-box">
                    <div class="result-label">Side Length</div>
                    <div class="result-value">${s.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Perimeter</div>
                    <div class="result-value" style="color:#2196F3;">${perimeter.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Area</div>
                    <div class="result-value" style="color:#4CAF50;">${area.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Apothem</div>
                    <div class="result-value" style="color:#FF9800;">${apothem.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#9C27B0;">
                    <div class="result-label">Circumradius</div>
                    <div class="result-value" style="color:#9C27B0;">${radius.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#F44336;">
                    <div class="result-label">Interior Angle</div>
                    <div class="result-value" style="color:#F44336;">${interiorAngle.toFixed(2)}°</div>
                </div>
                <div class="result-box" style="border-left-color:#00BCD4;">
                    <div class="result-label">Exterior Angle</div>
                    <div class="result-value" style="color:#00BCD4;">${exteriorAngle.toFixed(2)}°</div>
                </div>
                <div class="result-box" style="border-left-color:#673AB7;">
                    <div class="result-label">Diagonals</div>
                    <div class="result-value" style="color:#673AB7;">${diagonals}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculations:</strong>
                <div class="step">Perimeter = ${n} × ${s.toFixed(2)} = ${perimeter.toFixed(4)}</div>
                <div class="step">Area = (n × s² × cot(π/n))/4 = ${area.toFixed(4)}</div>
                <div class="step">Apothem = ${apothem.toFixed(4)}</div>
                <div class="step">Circumradius = ${radius.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Summary:</strong>
                ${info.name} with ${n} equal sides of ${s.toFixed(2)} units<br>
                • Perimeter: ${perimeter.toFixed(2)} | Area: ${area.toFixed(2)}<br>
                • Interior angles: ${n} × ${interiorAngle.toFixed(1)}° = ${sumAngles}°
            </div>`;
            
            show(html);
        }
        
        function calcTriangle() {
            const a = parseFloat(document.getElementById('tri_a').value);
            const b = parseFloat(document.getElementById('tri_b').value);
            const c = parseFloat(document.getElementById('tri_c').value);
            
            if(isNaN(a)||isNaN(b)||isNaN(c)||a<=0||b<=0||c<=0) {
                return alert('⚠️ Enter valid side lengths');
            }
            
            if(a+b<=c || a+c<=b || b+c<=a) {
                return alert('⚠️ Invalid triangle! Sum of two sides must exceed the third');
            }
            
            const perimeter = a + b + c;
            const s = perimeter / 2;
            const area = Math.sqrt(s * (s-a) * (s-b) * (s-c));
            
            let type = 'Scalene';
            if(a===b && b===c) type = 'Equilateral';
            else if(a===b || b===c || a===c) type = 'Isosceles';
            
            const isRight = Math.abs(a*a + b*b - c*c) < 0.001 || 
                           Math.abs(a*a + c*c - b*b) < 0.001 || 
                           Math.abs(b*b + c*c - a*a) < 0.001;
            
            let html = `<div style="text-align:center;font-size:3rem;margin-bottom:16px;">🔺</div>`;
            
            html += `<div class="result-box" style="border-left-color:#667eea;margin-bottom:16px;">
                <div class="result-label">Triangle Type</div>
                <div class="result-value" style="color:#667eea;font-size:1.1rem;">${type}${isRight ? ' Right' : ''} Triangle</div>
            </div>`;
            
            html += `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Perimeter</div>
                    <div class="result-value" style="color:#2196F3;">${perimeter.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Area</div>
                    <div class="result-value" style="color:#4CAF50;">${area.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Heron's Formula:</strong>
                <div class="step">Semi-perimeter: s = (${a}+${b}+${c})/2 = ${s.toFixed(4)}</div>
                <div class="step">Area = √[s(s-a)(s-b)(s-c)]</div>
                <div class="step">Area = √[${s.toFixed(2)}×${(s-a).toFixed(2)}×${(s-b).toFixed(2)}×${(s-c).toFixed(2)}]</div>
                <div class="step">Area = ${area.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Triangle Properties:</strong>
                Type: ${type}${isRight ? ' Right' : ''}<br>
                Sides: ${a}, ${b}, ${c}<br>
                Perimeter: ${perimeter.toFixed(2)}<br>
                Area: ${area.toFixed(2)}
            </div>`;
            
            show(html);
        }
        
        function calcIrregular() {
            const input = document.getElementById('irregular_sides').value;
            const sides = input.split(/[,\s]+/).map(v => parseFloat(v.trim())).filter(v => !isNaN(v) && v > 0);
            
            if(sides.length < 3) {
                return alert('⚠️ Need at least 3 sides');
            }
            
            const perimeter = sides.reduce((a,b) => a+b, 0);
            const n = sides.length;
            
            let html = `<div class="result-box" style="border-left-color:#667eea;margin-bottom:16px;">
                <div class="result-label">Polygon Type</div>
                <div class="result-value" style="color:#667eea;font-size:1.1rem;">Irregular ${n}-sided Polygon</div>
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Perimeter</div>
                <div class="result-value" style="color:#2196F3;">${perimeter.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculation:</strong>
                <div class="step">Sides: ${sides.join(', ')}</div>
                <div class="step">Perimeter = ${sides.join(' + ')} = ${perimeter.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#fff3e0;border-left-color:#FF9800;">
                <strong style="color:#FF9800;">Note:</strong>
                Area calculation requires coordinates or specific geometry
            </div>`;
            
            show(html);
        }
        
        function calcByCoordinates() {
            const input = document.getElementById('coord_input').value;
            const lines = input.split('\n').filter(l => l.trim());
            
            const points = lines.map(line => {
                const parts = line.split(',').map(v => parseFloat(v.trim()));
                return {x: parts[0], y: parts[1]};
            }).filter(p => !isNaN(p.x) && !isNaN(p.y));
            
            if(points.length < 3) {
                return alert('⚠️ Need at least 3 coordinate pairs');
            }
            
            // Shoelace formula for area
            let area = 0;
            for(let i = 0; i < points.length; i++) {
                const j = (i + 1) % points.length;
                area += points[i].x * points[j].y;
                area -= points[j].x * points[i].y;
            }
            area = Math.abs(area) / 2;
            
            // Calculate perimeter
            let perimeter = 0;
            for(let i = 0; i < points.length; i++) {
                const j = (i + 1) % points.length;
                const dx = points[j].x - points[i].x;
                const dy = points[j].y - points[i].y;
                perimeter += Math.sqrt(dx*dx + dy*dy);
            }
            
            let html = `<div class="result-box" style="border-left-color:#667eea;margin-bottom:16px;">
                <div class="result-label">Polygon Type</div>
                <div class="result-value" style="color:#667eea;font-size:1.1rem;">${points.length}-sided Polygon (Coordinates)</div>
            </div>`;
            
            html += `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Area</div>
                    <div class="result-value" style="color:#4CAF50;">${area.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Perimeter</div>
                    <div class="result-value" style="color:#2196F3;">${perimeter.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Shoelace Formula:</strong>
                <div class="step">Vertices: ${points.length}</div>
                <div class="step">Area = ½|Σ(x<sub>i</sub>y<sub>i+1</sub> - x<sub>i+1</sub>y<sub>i</sub>)|</div>
                <div class="step">Area = ${area.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Coordinate Method:</strong>
                Used ${points.length} coordinate pairs<br>
                Area calculated using Shoelace formula<br>
                Perimeter from distance formula
            </div>`;
            
            show(html);
        }
        
        // Initialize
        updatePreview('side');
        updatePreview('apothem');
        updatePreview('radius');
    </script>
</body>
</html>