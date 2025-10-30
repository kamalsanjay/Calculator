<?php
/**
 * Triangle Calculator
 * File: triangle-calculator.php
 * Description: Calculate area, perimeter, angles for all triangle types
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Triangle Calculator - Area, Perimeter, Angles & More</title>
    <meta name="description" content="Calculate triangle properties using various methods: Heron's formula, base-height, SSS, SAS, ASA with step-by-step solutions.">
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
        .calc-tabs { display: grid; grid-template-columns: repeat(auto-fit, minmax(85px, 1fr)); gap: 8px; margin-bottom: 16px; }
        .tab-btn { padding: 10px 6px; background: #f0f0f0; border: none; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; font-size: 0.7rem; line-height: 1.3; white-space: nowrap; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .input-section { margin-bottom: 16px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 0.9rem; }
        .input-section input { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; font-family: 'Courier New', monospace; }
        .input-section input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .input-hint { font-size: 0.75rem; color: #666; margin-top: 6px; font-style: italic; line-height: 1.4; }
        .shape-preview { background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); padding: 30px; border-radius: 8px; text-align: center; margin-bottom: 16px; border: 2px solid #667eea; min-height: 100px; display: flex; align-items: center; justify-content: center; }
        .shape-icon { font-size: 5rem; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.05rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .examples { display: grid; grid-template-columns: repeat(auto-fit, minmax(95px, 1fr)); gap: 8px; margin: 16px 0; }
        .example-btn { padding: 10px 6px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.8rem; transition: all 0.3s; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .example-btn:hover { background: #667eea; color: white; transform: translateY(-2px); }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 16px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; overflow: hidden; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.2rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; margin-bottom: 16px; }
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
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .result-value { font-size: 1rem; }
            .shape-icon { font-size: 3.5rem; }
            .btn { font-size: 0.95rem; padding: 12px 16px; }
        }
        @media (min-width: 768px) { 
            body { padding: 20px; }
            .container { max-width: 700px; margin: 0 auto; }
            header h1 { font-size: 1.8rem; }
            .calculator-body { padding: 24px; }
        }
        @media (min-width: 1024px) { .container { max-width: 900px; } }
        @media (min-width: 1280px) { .container { max-width: 1000px; } }
    </style>
</head>
<body>
    <header>
        <h1>🔺 Triangle Calculator</h1>
        <p>Area, Perimeter, Angles & All Properties</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">3 Sides<br>(SSS)</button>
                <button class="tab-btn" onclick="switchTab(1)">Base &<br>Height</button>
                <button class="tab-btn" onclick="switchTab(2)">2 Sides +<br>Angle (SAS)</button>
                <button class="tab-btn" onclick="switchTab(3)">2 Angles +<br>Side (ASA)</button>
                <button class="tab-btn" onclick="switchTab(4)">Right<br>Triangle</button>
            </div>

            <!-- Tab 1: Three Sides (SSS) -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">📏 Three Sides (SSS)</h3>
                <div class="shape-preview">
                    <div class="shape-icon">🔺</div>
                </div>
                <div class="input-section">
                    <label>Side A</label>
                    <input type="number" id="sss_a" value="3" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Side B</label>
                    <input type="number" id="sss_b" value="4" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Side C</label>
                    <input type="number" id="sss_c" value="5" step="any" min="0">
                    <div class="input-hint">Uses Heron's formula</div>
                </div>
                <button class="btn" onclick="calcSSS()">Calculate</button>
                <div class="examples">
                    <button class="example-btn" onclick="setSSS(3,4,5)">3-4-5</button>
                    <button class="example-btn" onclick="setSSS(5,5,5)">Equilateral</button>
                    <button class="example-btn" onclick="setSSS(5,5,8)">Isosceles</button>
                </div>
            </div>

            <!-- Tab 2: Base & Height -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">📐 Base & Height</h3>
                <div class="shape-preview">
                    <div class="shape-icon">🔺</div>
                </div>
                <div class="input-section">
                    <label>Base</label>
                    <input type="number" id="bh_base" value="6" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Height</label>
                    <input type="number" id="bh_height" value="4" step="any" min="0">
                    <div class="input-hint">Simplest area formula</div>
                </div>
                <button class="btn" onclick="calcBaseHeight()">Calculate Area</button>
            </div>

            <!-- Tab 3: SAS (Two Sides + Included Angle) -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">📊 Two Sides + Angle (SAS)</h3>
                <div class="shape-preview">
                    <div class="shape-icon">🔺</div>
                </div>
                <div class="input-section">
                    <label>Side A</label>
                    <input type="number" id="sas_a" value="5" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Side B</label>
                    <input type="number" id="sas_b" value="6" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Angle C (between sides, degrees)</label>
                    <input type="number" id="sas_angle" value="60" step="any" min="0" max="180">
                    <div class="input-hint">Angle between the two sides</div>
                </div>
                <button class="btn" onclick="calcSAS()">Calculate</button>
            </div>

            <!-- Tab 4: ASA (Two Angles + Included Side) -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">🔢 Two Angles + Side (ASA)</h3>
                <div class="shape-preview">
                    <div class="shape-icon">🔺</div>
                </div>
                <div class="input-section">
                    <label>Angle A (degrees)</label>
                    <input type="number" id="asa_angleA" value="60" step="any" min="0" max="180">
                </div>
                <div class="input-section">
                    <label>Side B (between angles)</label>
                    <input type="number" id="asa_side" value="7" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Angle C (degrees)</label>
                    <input type="number" id="asa_angleC" value="60" step="any" min="0" max="180">
                    <div class="input-hint">Third angle calculated automatically</div>
                </div>
                <button class="btn" onclick="calcASA()">Calculate</button>
            </div>

            <!-- Tab 5: Right Triangle -->
            <div id="tab4" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">⊿ Right Triangle</h3>
                <div class="shape-preview">
                    <div class="shape-icon">🔺</div>
                </div>
                <div class="input-section">
                    <label>Side A (leg)</label>
                    <input type="number" id="rt_a" value="3" step="any" min="0">
                </div>
                <div class="input-section">
                    <label>Side B (leg)</label>
                    <input type="number" id="rt_b" value="4" step="any" min="0">
                    <div class="input-hint">Hypotenuse calculated using Pythagorean theorem</div>
                </div>
                <button class="btn" onclick="calcRightTriangle()">Calculate</button>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Triangle Properties</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Triangle Formulas</h3>
            <div class="formula-box">
                <strong>Heron's Formula (SSS):</strong>
                s = (a+b+c)/2<br>
                A = √[s(s-a)(s-b)(s-c)]
            </div>
            <div class="formula-box">
                <strong>Base-Height:</strong>
                A = ½ × base × height
            </div>
            <div class="formula-box">
                <strong>SAS:</strong>
                A = ½ × a × b × sin(C)
            </div>
            <div class="formula-box">
                <strong>Right Triangle:</strong>
                c² = a² + b² (Pythagorean)<br>
                A = ½ × a × b
            </div>
        </div>
    </div>

    <script>
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
        
        function setSSS(a,b,c) {
            document.getElementById('sss_a').value = a;
            document.getElementById('sss_b').value = b;
            document.getElementById('sss_c').value = c;
        }
        
        function calcSSS() {
            const a = parseFloat(document.getElementById('sss_a').value);
            const b = parseFloat(document.getElementById('sss_b').value);
            const c = parseFloat(document.getElementById('sss_c').value);
            
            if(isNaN(a)||isNaN(b)||isNaN(c)||a<=0||b<=0||c<=0) {
                return alert('⚠️ Enter valid positive sides');
            }
            
            if(a+b<=c || a+c<=b || b+c<=a) {
                return alert('⚠️ Invalid triangle! Sum of two sides must exceed third');
            }
            
            const s = (a+b+c)/2;
            const area = Math.sqrt(s*(s-a)*(s-b)*(s-c));
            const perimeter = a+b+c;
            
            // Law of cosines for angles
            const angleA = Math.acos((b*b + c*c - a*a)/(2*b*c)) * 180/Math.PI;
            const angleB = Math.acos((a*a + c*c - b*b)/(2*a*c)) * 180/Math.PI;
            const angleC = 180 - angleA - angleB;
            
            let type = 'Scalene';
            if(Math.abs(a-b)<0.001 && Math.abs(b-c)<0.001) type = 'Equilateral';
            else if(Math.abs(a-b)<0.001 || Math.abs(b-c)<0.001 || Math.abs(a-c)<0.001) type = 'Isosceles';
            
            const isRight = Math.abs(angleA-90)<0.1 || Math.abs(angleB-90)<0.1 || Math.abs(angleC-90)<0.1;
            
            let html = `<div class="result-box">
                <div class="result-label">Type</div>
                <div class="result-value">${type}${isRight?' Right':''}</div>
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
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Angle A</div>
                    <div class="result-value" style="color:#FF9800;">${angleA.toFixed(2)}°</div>
                </div>
                <div class="result-box" style="border-left-color:#9C27B0;">
                    <div class="result-label">Angle B</div>
                    <div class="result-value" style="color:#9C27B0;">${angleB.toFixed(2)}°</div>
                </div>
                <div class="result-box" style="border-left-color:#F44336;">
                    <div class="result-label">Angle C</div>
                    <div class="result-value" style="color:#F44336;">${angleC.toFixed(2)}°</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Heron's Formula:</strong>
                <div class="step">s = (${a}+${b}+${c})/2 = ${s.toFixed(4)}</div>
                <div class="step">A = √[${s.toFixed(2)}×${(s-a).toFixed(2)}×${(s-b).toFixed(2)}×${(s-c).toFixed(2)}]</div>
                <div class="step">A = ${area.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">📊 Summary:</strong>
                Type: ${type}${isRight?' Right':''}<br>
                Sides: ${a}, ${b}, ${c}<br>
                Area: ${area.toFixed(2)}<br>
                Perimeter: ${perimeter.toFixed(2)}<br>
                Angles: ${angleA.toFixed(1)}°, ${angleB.toFixed(1)}°, ${angleC.toFixed(1)}°
            </div>`;
            
            show(html);
        }
        
        function calcBaseHeight() {
            const base = parseFloat(document.getElementById('bh_base').value);
            const height = parseFloat(document.getElementById('bh_height').value);
            
            if(isNaN(base)||isNaN(height)||base<=0||height<=0) {
                return alert('⚠️ Enter valid positive values');
            }
            
            const area = 0.5 * base * height;
            
            let html = `<div class="result-box" style="border-left-color:#4CAF50;">
                <div class="result-label">Area</div>
                <div class="result-value" style="color:#4CAF50;">${area.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculation:</strong>
                <div class="step">A = ½ × base × height</div>
                <div class="step">A = ½ × ${base} × ${height}</div>
                <div class="step">A = ${area.toFixed(4)}</div>
            </div>`;
            
            show(html);
        }
        
        function calcSAS() {
            const a = parseFloat(document.getElementById('sas_a').value);
            const b = parseFloat(document.getElementById('sas_b').value);
            const angleC = parseFloat(document.getElementById('sas_angle').value);
            
            if(isNaN(a)||isNaN(b)||isNaN(angleC)||a<=0||b<=0||angleC<=0||angleC>=180) {
                return alert('⚠️ Enter valid values (angle: 0-180°)');
            }
            
            const angleRad = angleC * Math.PI/180;
            const area = 0.5 * a * b * Math.sin(angleRad);
            
            // Law of cosines for third side
            const c = Math.sqrt(a*a + b*b - 2*a*b*Math.cos(angleRad));
            const perimeter = a + b + c;
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Area</div>
                    <div class="result-value" style="color:#4CAF50;">${area.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Third Side</div>
                    <div class="result-value" style="color:#2196F3;">${c.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Perimeter</div>
                    <div class="result-value" style="color:#FF9800;">${perimeter.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 SAS Formula:</strong>
                <div class="step">A = ½ × a × b × sin(C)</div>
                <div class="step">A = ½ × ${a} × ${b} × sin(${angleC}°)</div>
                <div class="step">A = ${area.toFixed(4)}</div>
            </div>`;
            
            show(html);
        }
        
        function calcASA() {
            const angleA = parseFloat(document.getElementById('asa_angleA').value);
            const b = parseFloat(document.getElementById('asa_side').value);
            const angleC = parseFloat(document.getElementById('asa_angleC').value);
            
            if(isNaN(angleA)||isNaN(b)||isNaN(angleC)||b<=0||angleA<=0||angleC<=0) {
                return alert('⚠️ Enter valid values');
            }
            
            const angleB = 180 - angleA - angleC;
            
            if(angleB <= 0) {
                return alert('⚠️ Invalid angles! Sum must be less than 180°');
            }
            
            // Law of sines
            const a = b * Math.sin(angleA*Math.PI/180) / Math.sin(angleB*Math.PI/180);
            const c = b * Math.sin(angleC*Math.PI/180) / Math.sin(angleB*Math.PI/180);
            
            const s = (a+b+c)/2;
            const area = Math.sqrt(s*(s-a)*(s-b)*(s-c));
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Area</div>
                    <div class="result-value" style="color:#4CAF50;">${area.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Side A</div>
                    <div class="result-value" style="color:#2196F3;">${a.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Side C</div>
                    <div class="result-value" style="color:#FF9800;">${c.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#9C27B0;">
                    <div class="result-label">Angle B</div>
                    <div class="result-value" style="color:#9C27B0;">${angleB.toFixed(2)}°</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 ASA Method:</strong>
                <div class="step">Angle B = 180° - ${angleA}° - ${angleC}° = ${angleB.toFixed(2)}°</div>
                <div class="step">Using Law of Sines to find sides</div>
                <div class="step">Area = ${area.toFixed(4)}</div>
            </div>`;
            
            show(html);
        }
        
        function calcRightTriangle() {
            const a = parseFloat(document.getElementById('rt_a').value);
            const b = parseFloat(document.getElementById('rt_b').value);
            
            if(isNaN(a)||isNaN(b)||a<=0||b<=0) {
                return alert('⚠️ Enter valid positive legs');
            }
            
            const c = Math.sqrt(a*a + b*b);
            const area = 0.5 * a * b;
            const perimeter = a + b + c;
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Area</div>
                    <div class="result-value" style="color:#4CAF50;">${area.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Hypotenuse</div>
                    <div class="result-value" style="color:#2196F3;">${c.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Perimeter</div>
                    <div class="result-value" style="color:#FF9800;">${perimeter.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Right Triangle:</strong>
                <div class="step">c² = a² + b² = ${a}² + ${b}²</div>
                <div class="step">c = √${a*a + b*b} = ${c.toFixed(4)}</div>
                <div class="step">Area = ½ × ${a} × ${b} = ${area.toFixed(4)}</div>
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>