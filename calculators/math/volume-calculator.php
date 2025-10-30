<?php
/**
 * Volume Calculator
 * File: volume-calculator.php
 * Description: Calculate volume and surface area for all 3D shapes
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Volume Calculator - Cube, Sphere, Cylinder & More</title>
    <meta name="description" content="Calculate volume and surface area for cube, sphere, cylinder, cone, pyramid and all 3D shapes.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 12px; overflow-x: hidden; }
        header { background: rgba(255,255,255,0.1); color: white; padding: 20px 16px; text-align: center; border-radius: 12px; margin-bottom: 16px; backdrop-filter: blur(10px); }
        header h1 { font-size: 1.5rem; margin-bottom: 8px; font-weight: 700; }
        header p { font-size: 0.875rem; opacity: 0.9; }
        .container { max-width: 100%; margin: 0 auto; overflow-x: hidden; }
        .breadcrumb { margin-bottom: 16px; text-align: center; }
        .breadcrumb a { color: white; text-decoration: none; font-weight: 500; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 8px; display: inline-block; backdrop-filter: blur(10px); font-size: 0.875rem; }
        .calculator-body { background: white; padding: 16px; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); margin-bottom: 16px; overflow: hidden; }
        .calc-tabs { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 16px; }
        .tab-btn { padding: 10px 6px; background: #f0f0f0; border: none; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; font-size: 0.75rem; line-height: 1.3; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .input-section { margin-bottom: 16px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 0.9rem; }
        .input-section input { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; font-family: 'Courier New', monospace; }
        .input-section input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .input-hint { font-size: 0.75rem; color: #666; margin-top: 6px; font-style: italic; line-height: 1.4; }
        .shape-preview { background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); padding: 25px; border-radius: 8px; text-align: center; margin-bottom: 16px; border: 2px solid #667eea; }
        .shape-name { font-size: 1.1rem; font-weight: bold; color: #667eea; margin-bottom: 8px; }
        .shape-icon { font-size: 4rem; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.05rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .examples { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin: 16px 0; }
        .example-btn { padding: 10px 6px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.8rem; transition: all 0.3s; }
        .example-btn:hover { background: #667eea; color: white; transform: translateY(-2px); }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 16px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; overflow: hidden; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.2rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 16px; }
        .result-box { background: white; padding: 14px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; overflow: hidden; }
        .result-label { font-size: 0.7rem; color: #666; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .result-value { font-size: 1.15rem; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; word-break: break-word; line-height: 1.4; }
        .formula-box { background: #f9f9f9; padding: 12px; border-radius: 8px; border-left: 4px solid #667eea; margin: 14px 0; font-size: 0.8rem; line-height: 1.6; overflow-wrap: break-word; }
        .formula-box strong { color: #667eea; display: block; margin-bottom: 6px; }
        .step-box { background: #fff3cd; padding: 12px; border-radius: 8px; border-left: 4px solid #ffc107; margin: 14px 0; overflow: hidden; }
        .step-box strong { color: #f57c00; display: block; margin-bottom: 8px; font-size: 0.85rem; }
        .step { padding: 5px 0; border-bottom: 1px solid #ffe082; font-family: 'Courier New', monospace; font-size: 0.75rem; word-break: break-word; }
        .step:last-child { border-bottom: none; }
        .info-box { background: white; padding: 16px; border-radius: 12px; line-height: 1.7; box-shadow: 0 8px 30px rgba(0,0,0,0.15); margin-top: 16px; overflow: hidden; }
        .info-box h3 { color: #667eea; margin-bottom: 14px; font-size: 1.1rem; }
        
        @media (max-width: 479px) {
            .result-value { font-size: 1rem; }
            .shape-icon { font-size: 3rem; }
            .btn { font-size: 0.95rem; padding: 12px 16px; }
        }
        @media (min-width: 768px) { 
            body { padding: 20px; }
            .container { max-width: 700px; margin: 0 auto; }
            header h1 { font-size: 1.8rem; }
            .calculator-body { padding: 24px; }
            .calc-tabs { grid-template-columns: repeat(6, 1fr); }
        }
        @media (min-width: 1024px) { .container { max-width: 900px; } }
    </style>
</head>
<body>
    <header>
        <h1>📦 Volume Calculator</h1>
        <p>All 3D Shapes - Volume & Surface Area</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Cube</button>
                <button class="tab-btn" onclick="switchTab(1)">Sphere</button>
                <button class="tab-btn" onclick="switchTab(2)">Cylinder</button>
                <button class="tab-btn" onclick="switchTab(3)">Cone</button>
                <button class="tab-btn" onclick="switchTab(4)">Pyramid</button>
                <button class="tab-btn" onclick="switchTab(5)">Box</button>
            </div>

            <!-- Tab 1: Cube -->
            <div id="tab0" class="tab-content active">
                <div class="shape-preview">
                    <div class="shape-name">Cube</div>
                    <div class="shape-icon">◼️</div>
                </div>
                <div class="input-section">
                    <label>Side Length (a)</label>
                    <input type="number" id="cube_side" value="5" step="any" min="0">
                    <div class="input-hint">All sides equal</div>
                </div>
                <button class="btn" onclick="calcCube()">Calculate</button>
                <div class="examples">
                    <button class="example-btn" onclick="set('cube_side',5)">5</button>
                    <button class="example-btn" onclick="set('cube_side',8)">8</button>
                    <button class="example-btn" onclick="set('cube_side',10)">10</button>
                </div>
            </div>

            <!-- Tab 2: Sphere -->
            <div id="tab1" class="tab-content">
                <div class="shape-preview">
                    <div class="shape-name">Sphere</div>
                    <div class="shape-icon">🔵</div>
                </div>
                <div class="input-section">
                    <label>Radius (r)</label>
                    <input type="number" id="sphere_radius" value="4" step="any" min="0">
                    <div class="input-hint">Distance from center to surface</div>
                </div>
                <button class="btn" onclick="calcSphere()">Calculate</button>
                <div class="examples">
                    <button class="example-btn" onclick="set('sphere_radius',3)">r=3</button>
                    <button class="example-btn" onclick="set('sphere_radius',5)">r=5</button>
                    <button class="example-btn" onclick="set('sphere_radius',7)">r=7</button>
                </div>
            </div>

            <!-- Tab 3: Cylinder -->
            <div id="tab2" class="tab-content">
                <div class="shape-preview">
                    <div class="shape-name">Cylinder</div>
                    <div class="shape-icon">🥫</div>
                </div>
                <div class="input-section">
                    <label>Radius (r)</label>
                    <input type="number" id="cyl_radius" value="3" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Height (h)</label>
                    <input type="number" id="cyl_height" value="8" step="any" min="0">
                </div>
                <button class="btn" onclick="calcCylinder()">Calculate</button>
                <div class="examples">
                    <button class="example-btn" onclick="setCyl(3,8)">3×8</button>
                    <button class="example-btn" onclick="setCyl(5,10)">5×10</button>
                    <button class="example-btn" onclick="setCyl(4,6)">4×6</button>
                </div>
            </div>

            <!-- Tab 4: Cone -->
            <div id="tab3" class="tab-content">
                <div class="shape-preview">
                    <div class="shape-name">Cone</div>
                    <div class="shape-icon">🔺</div>
                </div>
                <div class="input-section">
                    <label>Radius (r)</label>
                    <input type="number" id="cone_radius" value="3" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Height (h)</label>
                    <input type="number" id="cone_height" value="9" step="any" min="0">
                </div>
                <button class="btn" onclick="calcCone()">Calculate</button>
                <div class="examples">
                    <button class="example-btn" onclick="setCone(3,9)">3×9</button>
                    <button class="example-btn" onclick="setCone(4,12)">4×12</button>
                    <button class="example-btn" onclick="setCone(5,15)">5×15</button>
                </div>
            </div>

            <!-- Tab 5: Pyramid -->
            <div id="tab4" class="tab-content">
                <div class="shape-preview">
                    <div class="shape-name">Square Pyramid</div>
                    <div class="shape-icon">🔻</div>
                </div>
                <div class="input-section">
                    <label>Base Side (a)</label>
                    <input type="number" id="pyr_base" value="6" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Height (h)</label>
                    <input type="number" id="pyr_height" value="8" step="any" min="0">
                </div>
                <button class="btn" onclick="calcPyramid()">Calculate</button>
            </div>

            <!-- Tab 6: Rectangular Box -->
            <div id="tab5" class="tab-content">
                <div class="shape-preview">
                    <div class="shape-name">Rectangular Box</div>
                    <div class="shape-icon">📦</div>
                </div>
                <div class="input-section">
                    <label>Length (l)</label>
                    <input type="number" id="box_length" value="8" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Width (w)</label>
                    <input type="number" id="box_width" value="5" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Height (h)</label>
                    <input type="number" id="box_height" value="4" step="any" min="0">
                </div>
                <button class="btn" onclick="calcBox()">Calculate</button>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Volume Formulas</h3>
            <div class="formula-box">
                <strong>Cube:</strong> V = a³, SA = 6a²
            </div>
            <div class="formula-box">
                <strong>Sphere:</strong> V = (4/3)πr³, SA = 4πr²
            </div>
            <div class="formula-box">
                <strong>Cylinder:</strong> V = πr²h, SA = 2πr² + 2πrh
            </div>
            <div class="formula-box">
                <strong>Cone:</strong> V = (1/3)πr²h, SA = πr² + πr√(r²+h²)
            </div>
            <div class="formula-box">
                <strong>Pyramid:</strong> V = (1/3)a²h
            </div>
            <div class="formula-box">
                <strong>Box:</strong> V = l×w×h, SA = 2(lw + lh + wh)
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
        
        function set(id,val) { document.getElementById(id).value = val; }
        function setCyl(r,h) { set('cyl_radius',r); set('cyl_height',h); }
        function setCone(r,h) { set('cone_radius',r); set('cone_height',h); }
        
        function calcCube() {
            const a = parseFloat(document.getElementById('cube_side').value);
            if(isNaN(a)||a<=0) return alert('⚠️ Enter valid side length');
            
            const volume = a*a*a;
            const surfaceArea = 6*a*a;
            const diagonal = a*Math.sqrt(3);
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Volume</div>
                    <div class="result-value" style="color:#4CAF50;">${volume.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Surface Area</div>
                    <div class="result-value" style="color:#2196F3;">${surfaceArea.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Diagonal</div>
                    <div class="result-value" style="color:#FF9800;">${diagonal.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculations:</strong>
                <div class="step">Volume = a³ = ${a}³ = ${volume.toFixed(4)}</div>
                <div class="step">Surface Area = 6a² = 6×${a}² = ${surfaceArea.toFixed(4)}</div>
                <div class="step">Space Diagonal = a√3 = ${diagonal.toFixed(4)}</div>
            </div>`;
            
            show(html);
        }
        
        function calcSphere() {
            const r = parseFloat(document.getElementById('sphere_radius').value);
            if(isNaN(r)||r<=0) return alert('⚠️ Enter valid radius');
            
            const volume = (4/3) * PI * r*r*r;
            const surfaceArea = 4 * PI * r*r;
            const diameter = 2*r;
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Volume</div>
                    <div class="result-value" style="color:#4CAF50;">${volume.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Surface Area</div>
                    <div class="result-value" style="color:#2196F3;">${surfaceArea.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Diameter</div>
                    <div class="result-value" style="color:#FF9800;">${diameter.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculations:</strong>
                <div class="step">V = (4/3)πr³ = ${volume.toFixed(4)}</div>
                <div class="step">SA = 4πr² = ${surfaceArea.toFixed(4)}</div>
            </div>`;
            
            show(html);
        }
        
        function calcCylinder() {
            const r = parseFloat(document.getElementById('cyl_radius').value);
            const h = parseFloat(document.getElementById('cyl_height').value);
            if(isNaN(r)||isNaN(h)||r<=0||h<=0) return alert('⚠️ Enter valid dimensions');
            
            const volume = PI * r*r * h;
            const surfaceArea = 2*PI*r*r + 2*PI*r*h;
            const lateralArea = 2*PI*r*h;
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Volume</div>
                    <div class="result-value" style="color:#4CAF50;">${volume.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Surface Area</div>
                    <div class="result-value" style="color:#2196F3;">${surfaceArea.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Lateral Area</div>
                    <div class="result-value" style="color:#FF9800;">${lateralArea.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculations:</strong>
                <div class="step">V = πr²h = π×${r}²×${h} = ${volume.toFixed(4)}</div>
                <div class="step">SA = 2πr² + 2πrh = ${surfaceArea.toFixed(4)}</div>
            </div>`;
            
            show(html);
        }
        
        function calcCone() {
            const r = parseFloat(document.getElementById('cone_radius').value);
            const h = parseFloat(document.getElementById('cone_height').value);
            if(isNaN(r)||isNaN(h)||r<=0||h<=0) return alert('⚠️ Enter valid dimensions');
            
            const volume = (1/3) * PI * r*r * h;
            const slantHeight = Math.sqrt(r*r + h*h);
            const surfaceArea = PI*r*r + PI*r*slantHeight;
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Volume</div>
                    <div class="result-value" style="color:#4CAF50;">${volume.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Surface Area</div>
                    <div class="result-value" style="color:#2196F3;">${surfaceArea.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Slant Height</div>
                    <div class="result-value" style="color:#FF9800;">${slantHeight.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculations:</strong>
                <div class="step">V = (1/3)πr²h = ${volume.toFixed(4)}</div>
                <div class="step">Slant = √(r²+h²) = ${slantHeight.toFixed(4)}</div>
                <div class="step">SA = πr² + πr×slant = ${surfaceArea.toFixed(4)}</div>
            </div>`;
            
            show(html);
        }
        
        function calcPyramid() {
            const a = parseFloat(document.getElementById('pyr_base').value);
            const h = parseFloat(document.getElementById('pyr_height').value);
            if(isNaN(a)||isNaN(h)||a<=0||h<=0) return alert('⚠️ Enter valid dimensions');
            
            const volume = (1/3) * a*a * h;
            const slantHeight = Math.sqrt((a/2)*(a/2) + h*h);
            const baseArea = a*a;
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Volume</div>
                    <div class="result-value" style="color:#4CAF50;">${volume.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Base Area</div>
                    <div class="result-value" style="color:#2196F3;">${baseArea.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Slant Height</div>
                    <div class="result-value" style="color:#FF9800;">${slantHeight.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculations:</strong>
                <div class="step">V = (1/3)a²h = (1/3)×${a}²×${h} = ${volume.toFixed(4)}</div>
                <div class="step">Base Area = ${a}² = ${baseArea.toFixed(4)}</div>
            </div>`;
            
            show(html);
        }
        
        function calcBox() {
            const l = parseFloat(document.getElementById('box_length').value);
            const w = parseFloat(document.getElementById('box_width').value);
            const h = parseFloat(document.getElementById('box_height').value);
            if(isNaN(l)||isNaN(w)||isNaN(h)||l<=0||w<=0||h<=0) return alert('⚠️ Enter valid dimensions');
            
            const volume = l * w * h;
            const surfaceArea = 2*(l*w + l*h + w*h);
            const diagonal = Math.sqrt(l*l + w*w + h*h);
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Volume</div>
                    <div class="result-value" style="color:#4CAF50;">${volume.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Surface Area</div>
                    <div class="result-value" style="color:#2196F3;">${surfaceArea.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Diagonal</div>
                    <div class="result-value" style="color:#FF9800;">${diagonal.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculations:</strong>
                <div class="step">V = l×w×h = ${l}×${w}×${h} = ${volume.toFixed(4)}</div>
                <div class="step">SA = 2(lw+lh+wh) = ${surfaceArea.toFixed(4)}</div>
                <div class="step">Diagonal = √(l²+w²+h²) = ${diagonal.toFixed(4)}</div>
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>