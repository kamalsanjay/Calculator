<?php
/**
 * Perimeter Calculator
 * File: perimeter-calculator.php
 * Description: Calculate perimeter/circumference for all common shapes
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Perimeter Calculator - All Shapes with Formulas</title>
    <meta name="description" content="Calculate perimeter and circumference for square, rectangle, circle, triangle, and polygon shapes with step-by-step solutions.">
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
        .calc-tabs { display: grid; grid-template-columns: repeat(auto-fit, minmax(90px, 1fr)); gap: 8px; margin-bottom: 16px; }
        .tab-btn { padding: 12px 8px; background: #f0f0f0; border: none; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; font-size: 0.8rem; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .input-section { margin-bottom: 16px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 0.9rem; }
        .input-section input { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; font-family: 'Courier New', monospace; }
        .input-section input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .input-hint { font-size: 0.8rem; color: #666; margin-top: 6px; font-style: italic; }
        .shape-preview { background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 16px; border: 2px solid #667eea; min-height: 100px; display: flex; align-items: center; justify-content: center; }
        .shape-icon { font-size: 4rem; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .examples { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; margin: 16px 0; }
        .example-btn { padding: 10px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .example-btn:hover { background: #667eea; color: white; transform: translateY(-2px); }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.3rem; }
        .result-box { background: white; padding: 16px; border-radius: 10px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; }
        .result-label { font-size: 0.8rem; color: #666; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; }
        .result-value { font-size: 1.4rem; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; word-break: break-word; line-height: 1.5; }
        .formula-box { background: #f9f9f9; padding: 14px; border-radius: 8px; border-left: 4px solid #667eea; margin: 14px 0; font-size: 0.85rem; line-height: 1.7; }
        .formula-box strong { color: #667eea; display: block; margin-bottom: 6px; }
        .step-box { background: #fff3cd; padding: 14px; border-radius: 8px; border-left: 4px solid #ffc107; margin: 14px 0; }
        .step-box strong { color: #f57c00; display: block; margin-bottom: 8px; }
        .step { padding: 8px 0; border-bottom: 1px solid #ffe082; font-family: 'Courier New', monospace; font-size: 0.9rem; }
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
            .examples { grid-template-columns: repeat(2, 1fr); }
            .result-value { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    <header>
        <h1>📐 Perimeter Calculator</h1>
        <p>All Shapes with Formulas & Solutions</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Square</button>
                <button class="tab-btn" onclick="switchTab(1)">Rectangle</button>
                <button class="tab-btn" onclick="switchTab(2)">Circle</button>
                <button class="tab-btn" onclick="switchTab(3)">Triangle</button>
                <button class="tab-btn" onclick="switchTab(4)">Polygon</button>
            </div>

            <!-- Tab 1: Square -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">⬛ Square Perimeter</h3>
                <div class="shape-preview">
                    <div class="shape-icon">⬛</div>
                </div>
                <div class="input-section">
                    <label>Side Length (s)</label>
                    <input type="number" id="sq_side" value="5" step="any" min="0">
                    <div class="input-hint">Length of one side</div>
                </div>
                <button class="btn" onclick="calcSquare()">Calculate Perimeter</button>
                <div class="examples">
                    <button class="example-btn" onclick="setSquare(5)">Side = 5</button>
                    <button class="example-btn" onclick="setSquare(10)">Side = 10</button>
                    <button class="example-btn" onclick="setSquare(7.5)">Side = 7.5</button>
                </div>
            </div>

            <!-- Tab 2: Rectangle -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">▭ Rectangle Perimeter</h3>
                <div class="shape-preview">
                    <div class="shape-icon">▭</div>
                </div>
                <div class="input-section">
                    <label>Length (l)</label>
                    <input type="number" id="rect_length" value="8" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Width (w)</label>
                    <input type="number" id="rect_width" value="5" step="any" min="0">
                </div>
                <button class="btn" onclick="calcRectangle()">Calculate Perimeter</button>
                <div class="examples">
                    <button class="example-btn" onclick="setRect(8,5)">8 × 5</button>
                    <button class="example-btn" onclick="setRect(10,6)">10 × 6</button>
                </div>
            </div>

            <!-- Tab 3: Circle -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">⭕ Circle Circumference</h3>
                <div class="shape-preview">
                    <div class="shape-icon">⭕</div>
                </div>
                <div class="input-section">
                    <label>Radius (r)</label>
                    <input type="number" id="circ_radius" value="7" step="any" min="0">
                    <div class="input-hint">Distance from center to edge</div>
                </div>
                <button class="btn" onclick="calcCircle()">Calculate Circumference</button>
                <div class="examples">
                    <button class="example-btn" onclick="setCircle(7)">r = 7</button>
                    <button class="example-btn" onclick="setCircle(10)">r = 10</button>
                    <button class="example-btn" onclick="setCircle(3.5)">r = 3.5</button>
                </div>
            </div>

            <!-- Tab 4: Triangle -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">🔺 Triangle Perimeter</h3>
                <div class="shape-preview">
                    <div class="shape-icon">🔺</div>
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
                <button class="btn" onclick="calcTriangle()">Calculate Perimeter</button>
                <div class="examples">
                    <button class="example-btn" onclick="setTri(3,4,5)">3-4-5</button>
                    <button class="example-btn" onclick="setTri(5,5,5)">5-5-5</button>
                </div>
            </div>

            <!-- Tab 5: Regular Polygon -->
            <div id="tab4" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">⬡ Regular Polygon Perimeter</h3>
                <div class="shape-preview">
                    <div class="shape-icon">⬡</div>
                </div>
                <div class="input-section">
                    <label>Number of Sides (n)</label>
                    <input type="number" id="poly_sides" value="6" step="1" min="3">
                    <div class="input-hint">3 = triangle, 4 = square, 5 = pentagon, 6 = hexagon...</div>
                </div>
                <div class="input-section">
                    <label>Side Length (s)</label>
                    <input type="number" id="poly_side" value="4" step="any" min="0">
                </div>
                <button class="btn" onclick="calcPolygon()">Calculate Perimeter</button>
                <div class="examples">
                    <button class="example-btn" onclick="setPoly(6,4)">Hexagon</button>
                    <button class="example-btn" onclick="setPoly(8,3)">Octagon</button>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Perimeter Formulas</h3>
            <div class="formula-box">
                <strong>Square:</strong>
                P = 4s<br>
                (4 times the side length)
            </div>
            <div class="formula-box">
                <strong>Rectangle:</strong>
                P = 2(l + w)<br>
                (2 times length plus width)
            </div>
            <div class="formula-box">
                <strong>Circle (Circumference):</strong>
                C = 2πr = πd<br>
                (2 times pi times radius)
            </div>
            <div class="formula-box">
                <strong>Triangle:</strong>
                P = a + b + c<br>
                (sum of all three sides)
            </div>
            <div class="formula-box">
                <strong>Regular Polygon:</strong>
                P = n × s<br>
                (number of sides times side length)
            </div>
        </div>
    </div>

    <script>
        const PI = Math.PI;
        
        function switchTab(i) {
            document.querySelectorAll('.tab-btn').forEach((b,j)=>b.className=j===i?'tab-btn active':'tab-btn');
            document.querySelectorAll('.tab-content').forEach((c,j)=>c.className=j===i?'tab-content active':'tab-content');
            document.getElementById('result').classList.remove('show');
        }
        
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
            document.getElementById('result').scrollIntoView({behavior: 'smooth', block: 'nearest'});
        }
        
        function setSquare(s) { document.getElementById('sq_side').value = s; }
        function setRect(l,w) {
            document.getElementById('rect_length').value = l;
            document.getElementById('rect_width').value = w;
        }
        function setCircle(r) { document.getElementById('circ_radius').value = r; }
        function setTri(a,b,c) {
            document.getElementById('tri_a').value = a;
            document.getElementById('tri_b').value = b;
            document.getElementById('tri_c').value = c;
        }
        function setPoly(n,s) {
            document.getElementById('poly_sides').value = n;
            document.getElementById('poly_side').value = s;
        }
        
        function calcSquare() {
            const side = parseFloat(document.getElementById('sq_side').value);
            
            if(isNaN(side) || side <= 0) {
                return alert('⚠️ Please enter a valid positive side length');
            }
            
            const perimeter = 4 * side;
            
            let html = `<div class="result-box">
                <div class="result-label">Shape</div>
                <div class="result-value">Square with side = ${side}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Perimeter</div>
                <div class="result-value" style="color:#2196F3;">${perimeter.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculation Steps:</strong>
                <div class="step">Formula: P = 4s</div>
                <div class="step">P = 4 × ${side}</div>
                <div class="step">P = ${perimeter.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula Used:</strong>
                Square Perimeter = 4 × side<br>
                All four sides are equal in a square
            </div>`;
            
            show(html);
        }
        
        function calcRectangle() {
            const length = parseFloat(document.getElementById('rect_length').value);
            const width = parseFloat(document.getElementById('rect_width').value);
            
            if(isNaN(length) || isNaN(width) || length <= 0 || width <= 0) {
                return alert('⚠️ Please enter valid positive dimensions');
            }
            
            const perimeter = 2 * (length + width);
            
            let html = `<div class="result-box">
                <div class="result-label">Shape</div>
                <div class="result-value">Rectangle ${length} × ${width}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Perimeter</div>
                <div class="result-value" style="color:#2196F3;">${perimeter.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculation Steps:</strong>
                <div class="step">Formula: P = 2(l + w)</div>
                <div class="step">P = 2(${length} + ${width})</div>
                <div class="step">P = 2 × ${length + width}</div>
                <div class="step">P = ${perimeter.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula Used:</strong>
                Rectangle Perimeter = 2 × (length + width)<br>
                Sum of all four sides
            </div>`;
            
            show(html);
        }
        
        function calcCircle() {
            const radius = parseFloat(document.getElementById('circ_radius').value);
            
            if(isNaN(radius) || radius <= 0) {
                return alert('⚠️ Please enter a valid positive radius');
            }
            
            const circumference = 2 * PI * radius;
            const diameter = 2 * radius;
            
            let html = `<div class="result-box">
                <div class="result-label">Shape</div>
                <div class="result-value">Circle with radius = ${radius}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Circumference</div>
                <div class="result-value" style="color:#2196F3;">${circumference.toFixed(4)}</div>
            </div>
            <div class="result-box" style="border-left-color:#FF9800;">
                <div class="result-label">Diameter</div>
                <div class="result-value" style="color:#FF9800;">${diameter.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculation Steps:</strong>
                <div class="step">Formula: C = 2πr</div>
                <div class="step">C = 2 × π × ${radius}</div>
                <div class="step">C = 2 × ${PI.toFixed(6)} × ${radius}</div>
                <div class="step">C = ${circumference.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formulas:</strong>
                • Circumference = 2πr = πd<br>
                • π (pi) ≈ ${PI.toFixed(6)}<br>
                • Diameter = 2 × radius = ${diameter}
            </div>`;
            
            show(html);
        }
        
        function calcTriangle() {
            const a = parseFloat(document.getElementById('tri_a').value);
            const b = parseFloat(document.getElementById('tri_b').value);
            const c = parseFloat(document.getElementById('tri_c').value);
            
            if(isNaN(a) || isNaN(b) || isNaN(c) || a <= 0 || b <= 0 || c <= 0) {
                return alert('⚠️ Please enter valid positive side lengths');
            }
            
            // Triangle inequality check
            if(a + b <= c || a + c <= b || b + c <= a) {
                return alert('⚠️ Invalid triangle! Sum of any two sides must be greater than the third side');
            }
            
            const perimeter = a + b + c;
            
            // Determine triangle type
            let type = 'Scalene';
            if(a === b && b === c) type = 'Equilateral';
            else if(a === b || b === c || a === c) type = 'Isosceles';
            
            let html = `<div class="result-box">
                <div class="result-label">Shape</div>
                <div class="result-value">${type} Triangle</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Perimeter</div>
                <div class="result-value" style="color:#2196F3;">${perimeter.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculation Steps:</strong>
                <div class="step">Formula: P = a + b + c</div>
                <div class="step">P = ${a} + ${b} + ${c}</div>
                <div class="step">P = ${perimeter.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Triangle Info:</strong>
                • Type: ${type}<br>
                • Sides: ${a}, ${b}, ${c}<br>
                • Perimeter = sum of all three sides
            </div>`;
            
            show(html);
        }
        
        function calcPolygon() {
            const sides = parseInt(document.getElementById('poly_sides').value);
            const sideLength = parseFloat(document.getElementById('poly_side').value);
            
            if(isNaN(sides) || sides < 3) {
                return alert('⚠️ Number of sides must be at least 3');
            }
            
            if(isNaN(sideLength) || sideLength <= 0) {
                return alert('⚠️ Please enter a valid positive side length');
            }
            
            const perimeter = sides * sideLength;
            
            const names = {
                3: 'Triangle', 4: 'Quadrilateral', 5: 'Pentagon',
                6: 'Hexagon', 7: 'Heptagon', 8: 'Octagon',
                9: 'Nonagon', 10: 'Decagon', 12: 'Dodecagon'
            };
            const shapeName = names[sides] || `${sides}-sided Polygon`;
            
            let html = `<div class="result-box">
                <div class="result-label">Shape</div>
                <div class="result-value">Regular ${shapeName}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Perimeter</div>
                <div class="result-value" style="color:#2196F3;">${perimeter.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculation Steps:</strong>
                <div class="step">Formula: P = n × s</div>
                <div class="step">P = ${sides} × ${sideLength}</div>
                <div class="step">P = ${perimeter.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Polygon Info:</strong>
                • Name: ${shapeName}<br>
                • Sides: ${sides}<br>
                • Side Length: ${sideLength}<br>
                • Regular polygon = all sides equal
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>