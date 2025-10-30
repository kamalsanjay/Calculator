<?php
/**
 * Square Calculator
 * File: square-calculator.php
 * Description: Calculate area, perimeter, diagonal for squares by various methods
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Square Calculator - Area, Perimeter, Diagonal & Properties</title>
    <meta name="description" content="Calculate square properties using side, area, perimeter, or diagonal with step-by-step solutions.">
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
        .calc-tabs { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-bottom: 16px; }
        .tab-btn { padding: 12px 8px; background: #f0f0f0; border: none; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; font-size: 0.8rem; white-space: nowrap; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .input-section { margin-bottom: 16px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 0.9rem; }
        .input-section input { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; font-family: 'Courier New', monospace; }
        .input-section input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .input-hint { font-size: 0.8rem; color: #666; margin-top: 6px; font-style: italic; }
        .shape-preview { background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); padding: 30px; border-radius: 8px; text-align: center; margin-bottom: 16px; border: 2px solid #667eea; min-height: 120px; display: flex; align-items: center; justify-content: center; }
        .shape-icon { font-size: 5rem; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .examples { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin: 16px 0; }
        .example-btn { padding: 10px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; white-space: nowrap; }
        .example-btn:hover { background: #667eea; color: white; transform: translateY(-2px); }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; overflow: hidden; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.3rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 16px; }
        .result-box { background: white; padding: 16px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; overflow: hidden; }
        .result-label { font-size: 0.75rem; color: #666; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .result-value { font-size: 1.3rem; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; word-break: break-word; line-height: 1.4; }
        .formula-box { background: #f9f9f9; padding: 14px; border-radius: 8px; border-left: 4px solid #667eea; margin: 14px 0; font-size: 0.85rem; line-height: 1.7; overflow-wrap: break-word; }
        .formula-box strong { color: #667eea; display: block; margin-bottom: 6px; }
        .step-box { background: #fff3cd; padding: 14px; border-radius: 8px; border-left: 4px solid #ffc107; margin: 14px 0; overflow: hidden; }
        .step-box strong { color: #f57c00; display: block; margin-bottom: 8px; }
        .step { padding: 6px 0; border-bottom: 1px solid #ffe082; font-family: 'Courier New', monospace; font-size: 0.85rem; word-break: break-word; }
        .step:last-child { border-bottom: none; }
        .info-box { background: white; padding: 20px; border-radius: 12px; line-height: 1.8; box-shadow: 0 8px 30px rgba(0,0,0,0.15); margin-top: 16px; overflow: hidden; }
        .info-box h3 { color: #667eea; margin-bottom: 14px; font-size: 1.2rem; }
        
        @media (max-width: 479px) {
            .result-value { font-size: 1.1rem; }
            .shape-icon { font-size: 3.5rem; }
        }
        @media (min-width: 768px) { 
            body { padding: 24px; }
            .container { max-width: 720px; margin: 0 auto; }
            header h1 { font-size: 2rem; }
            .calculator-body { padding: 24px; }
            .calc-tabs { grid-template-columns: repeat(4, 1fr); }
        }
        @media (min-width: 1024px) { .container { max-width: 960px; } }
        @media (min-width: 1280px) { .container { max-width: 1100px; } }
    </style>
</head>
<body>
    <header>
        <h1>⬛ Square Calculator</h1>
        <p>Area, Perimeter, Diagonal & All Properties</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">By Side</button>
                <button class="tab-btn" onclick="switchTab(1)">By Area</button>
                <button class="tab-btn" onclick="switchTab(2)">By Perimeter</button>
                <button class="tab-btn" onclick="switchTab(3)">By Diagonal</button>
            </div>

            <!-- Tab 1: By Side Length -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📏 By Side Length</h3>
                <div class="shape-preview">
                    <div class="shape-icon">⬛</div>
                </div>
                <div class="input-section">
                    <label>Side Length (s)</label>
                    <input type="number" id="side_val" value="5" step="any" min="0">
                    <div class="input-hint">All sides are equal</div>
                </div>
                <button class="btn" onclick="calcBySide()">Calculate All Properties</button>
                <div class="examples">
                    <button class="example-btn" onclick="setVal('side_val',4)">s = 4</button>
                    <button class="example-btn" onclick="setVal('side_val',7)">s = 7</button>
                    <button class="example-btn" onclick="setVal('side_val',10)">s = 10</button>
                </div>
            </div>

            <!-- Tab 2: By Area -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📊 By Area</h3>
                <div class="shape-preview">
                    <div class="shape-icon">⬛</div>
                </div>
                <div class="input-section">
                    <label>Area (A)</label>
                    <input type="number" id="area_val" value="25" step="any" min="0">
                    <div class="input-hint">Find side length from area</div>
                </div>
                <button class="btn" onclick="calcByArea()">Calculate Properties</button>
                <div class="examples">
                    <button class="example-btn" onclick="setVal('area_val',16)">A = 16</button>
                    <button class="example-btn" onclick="setVal('area_val',36)">A = 36</button>
                    <button class="example-btn" onclick="setVal('area_val',49)">A = 49</button>
                </div>
            </div>

            <!-- Tab 3: By Perimeter -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">⬜ By Perimeter</h3>
                <div class="shape-preview">
                    <div class="shape-icon">⬛</div>
                </div>
                <div class="input-section">
                    <label>Perimeter (P)</label>
                    <input type="number" id="perim_val" value="20" step="any" min="0">
                    <div class="input-hint">Sum of all four sides</div>
                </div>
                <button class="btn" onclick="calcByPerimeter()">Calculate Properties</button>
                <div class="examples">
                    <button class="example-btn" onclick="setVal('perim_val',16)">P = 16</button>
                    <button class="example-btn" onclick="setVal('perim_val',28)">P = 28</button>
                    <button class="example-btn" onclick="setVal('perim_val',40)">P = 40</button>
                </div>
            </div>

            <!-- Tab 4: By Diagonal -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📐 By Diagonal</h3>
                <div class="shape-preview">
                    <div class="shape-icon">⬛</div>
                </div>
                <div class="input-section">
                    <label>Diagonal (d)</label>
                    <input type="number" id="diag_val" value="7.07" step="any" min="0">
                    <div class="input-hint">Corner to opposite corner</div>
                </div>
                <button class="btn" onclick="calcByDiagonal()">Calculate Properties</button>
                <div class="examples">
                    <button class="example-btn" onclick="setVal('diag_val',5.66)">d ≈ 5.66</button>
                    <button class="example-btn" onclick="setVal('diag_val',8.49)">d ≈ 8.49</button>
                    <button class="example-btn" onclick="setVal('diag_val',14.14)">d ≈ 14.14</button>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Square Properties</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Square Formulas</h3>
            <div class="formula-box">
                <strong>Area:</strong>
                A = s² (side squared)
            </div>
            <div class="formula-box">
                <strong>Perimeter:</strong>
                P = 4s (four times side)
            </div>
            <div class="formula-box">
                <strong>Diagonal:</strong>
                d = s√2 (side times root 2)
            </div>
            <div class="formula-box">
                <strong>From Area:</strong>
                s = √A
            </div>
            <div class="formula-box">
                <strong>From Perimeter:</strong>
                s = P/4
            </div>
            <div class="formula-box">
                <strong>From Diagonal:</strong>
                s = d/√2
            </div>
            <div class="formula-box">
                <strong>Properties:</strong>
                • All sides equal<br>
                • All angles 90°<br>
                • Diagonals equal and perpendicular
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
        
        function setVal(id, val) {
            document.getElementById(id).value = val;
        }
        
        function displayResults(s, method) {
            const area = s * s;
            const perimeter = 4 * s;
            const diagonal = s * Math.sqrt(2);
            
            let html = `<div class="result-box">
                <div class="result-label">Square</div>
                <div class="result-value">Side = ${s.toFixed(4)}</div>
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
                    <div class="result-label">Diagonal</div>
                    <div class="result-value" style="color:#FF9800;">${diagonal.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculations:</strong>
                <div class="step">Side = ${s.toFixed(4)}</div>
                <div class="step">Area = s² = ${s.toFixed(2)}² = ${area.toFixed(4)}</div>
                <div class="step">Perimeter = 4s = 4×${s.toFixed(2)} = ${perimeter.toFixed(4)}</div>
                <div class="step">Diagonal = s√2 = ${s.toFixed(2)}×√2 = ${diagonal.toFixed(4)}</div>
            </div>`;
            
            if(method) {
                html += `<div class="step-box">
                    <strong>🔍 Method Used:</strong>
                    <div class="step">${method}</div>
                </div>`;
            }
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">📊 Summary:</strong>
                • Side length: ${s.toFixed(2)} units<br>
                • Area: ${area.toFixed(2)} square units<br>
                • Perimeter: ${perimeter.toFixed(2)} units<br>
                • Diagonal: ${diagonal.toFixed(2)} units<br>
                • All angles: 90°<br>
                • All sides equal
            </div>`;
            
            show(html);
        }
        
        function calcBySide() {
            const s = parseFloat(document.getElementById('side_val').value);
            
            if(isNaN(s) || s <= 0) {
                return alert('⚠️ Enter valid positive side length');
            }
            
            displayResults(s, 'Direct calculation from side length');
        }
        
        function calcByArea() {
            const area = parseFloat(document.getElementById('area_val').value);
            
            if(isNaN(area) || area <= 0) {
                return alert('⚠️ Enter valid positive area');
            }
            
            const s = Math.sqrt(area);
            displayResults(s, `From area: s = √${area} = ${s.toFixed(4)}`);
        }
        
        function calcByPerimeter() {
            const perim = parseFloat(document.getElementById('perim_val').value);
            
            if(isNaN(perim) || perim <= 0) {
                return alert('⚠️ Enter valid positive perimeter');
            }
            
            const s = perim / 4;
            displayResults(s, `From perimeter: s = ${perim}/4 = ${s.toFixed(4)}`);
        }
        
        function calcByDiagonal() {
            const diag = parseFloat(document.getElementById('diag_val').value);
            
            if(isNaN(diag) || diag <= 0) {
                return alert('⚠️ Enter valid positive diagonal');
            }
            
            const s = diag / Math.sqrt(2);
            displayResults(s, `From diagonal: s = ${diag}/√2 = ${s.toFixed(4)}`);
        }
    </script>
</body>
</html>