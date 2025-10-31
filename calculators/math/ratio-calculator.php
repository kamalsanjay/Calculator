<?php
/**
 * Advanced Ratio Calculator
 * File: ratio-calculator.php
 * Description: Complete ratio calculator with simplification, scaling, and proportions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Advanced Ratio Calculator - Simplify, Scale & Solve</title>
    <meta name="description" content="Calculate, simplify, and scale ratios. Solve proportions with multiple methods and step-by-step solutions.">
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
        .ratio-preview { background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); padding: 18px; border-radius: 8px; text-align: center; margin-bottom: 16px; border: 2px solid #667eea; font-size: 1.5rem; font-weight: bold; color: #667eea; font-family: 'Courier New', monospace; min-height: 60px; display: flex; align-items: center; justify-content: center; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.05rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .examples { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin: 16px 0; }
        .example-btn { padding: 10px 6px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.8rem; transition: all 0.3s; white-space: nowrap; font-family: 'Courier New', monospace; }
        .example-btn:hover { background: #667eea; color: white; transform: translateY(-2px); }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 16px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; overflow: hidden; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.2rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 16px; }
        .result-box { background: white; padding: 14px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; overflow: hidden; }
        .result-label { font-size: 0.7rem; color: #666; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .result-value { font-size: 1.2rem; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; word-break: break-word; line-height: 1.4; }
        .formula-box { background: #f9f9f9; padding: 12px; border-radius: 8px; border-left: 4px solid #667eea; margin: 14px 0; font-size: 0.8rem; line-height: 1.6; overflow-wrap: break-word; }
        .formula-box strong { color: #667eea; display: block; margin-bottom: 6px; }
        .step-box { background: #fff3cd; padding: 12px; border-radius: 8px; border-left: 4px solid #ffc107; margin: 14px 0; overflow: hidden; }
        .step-box strong { color: #f57c00; display: block; margin-bottom: 8px; font-size: 0.85rem; }
        .step { padding: 5px 0; border-bottom: 1px solid #ffe082; font-family: 'Courier New', monospace; font-size: 0.75rem; word-break: break-word; }
        .step:last-child { border-bottom: none; }
        .info-box { background: white; padding: 16px; border-radius: 12px; line-height: 1.7; box-shadow: 0 8px 30px rgba(0,0,0,0.15); margin-top: 16px; overflow: hidden; }
        .info-box h3 { color: #667eea; margin-bottom: 14px; font-size: 1.1rem; }
        .input-grid { display: grid; grid-template-columns: 1fr auto 1fr; gap: 8px; align-items: center; }
        .colon { font-size: 1.5rem; font-weight: bold; color: #667eea; text-align: center; }
        
        @media (max-width: 479px) {
            .result-value { font-size: 1rem; }
            .ratio-preview { font-size: 1.2rem; padding: 15px; }
        }
        @media (min-width: 768px) { 
            body { padding: 20px; }
            .container { max-width: 700px; margin: 0 auto; }
            header h1 { font-size: 1.8rem; }
            .calculator-body { padding: 24px; }
            .calc-tabs { grid-template-columns: repeat(4, 1fr); }
        }
        @media (min-width: 1024px) { .container { max-width: 900px; } }
    </style>
</head>
<body>
    <header>
        <h1>⚖️ Ratio Calculator</h1>
        <p>Simplify, Scale & Solve Proportions</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Simplify<br>Ratio</button>
                <button class="tab-btn" onclick="switchTab(1)">Scale<br>Ratio</button>
                <button class="tab-btn" onclick="switchTab(2)">Solve<br>Proportion</button>
                <button class="tab-btn" onclick="switchTab(3)">3-Way<br>Ratio</button>
            </div>

            <!-- Tab 1: Simplify Ratio -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">Simplify Ratio</h3>
                <div class="ratio-preview" id="simp_preview">12 : 18</div>
                <div class="input-grid">
                    <input type="number" id="simp_a" value="12" step="any" min="0" oninput="updateSimpPreview()">
                    <div class="colon">:</div>
                    <input type="number" id="simp_b" value="18" step="any" min="0" oninput="updateSimpPreview()">
                </div>
                <div class="input-hint" style="margin-top: 16px;">Enter two numbers to simplify their ratio</div>
                <button class="btn" onclick="simplifyRatio()" style="margin-top: 16px;">Simplify</button>
                <div class="examples">
                    <button class="example-btn" onclick="setSimp(12,18)">12:18</button>
                    <button class="example-btn" onclick="setSimp(24,36)">24:36</button>
                    <button class="example-btn" onclick="setSimp(15,25)">15:25</button>
                </div>
            </div>

            <!-- Tab 2: Scale Ratio -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">Scale Ratio</h3>
                <div class="ratio-preview" id="scale_preview">2 : 3</div>
                <div class="input-section">
                    <label>Original Ratio</label>
                    <div class="input-grid">
                        <input type="number" id="scale_a" value="2" step="any" min="0" oninput="updateScalePreview()">
                        <div class="colon">:</div>
                        <input type="number" id="scale_b" value="3" step="any" min="0" oninput="updateScalePreview()">
                    </div>
                </div>
                <div class="input-section">
                    <label>Scale Factor</label>
                    <input type="number" id="scale_factor" value="5" step="any" min="0">
                    <div class="input-hint">Multiply ratio by this factor</div>
                </div>
                <button class="btn" onclick="scaleRatio()">Scale Ratio</button>
            </div>

            <!-- Tab 3: Solve Proportion -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">Solve Proportion: a:b = c:x</h3>
                <div class="ratio-preview" id="prop_preview">3 : 4 = 9 : x</div>
                <div class="input-section">
                    <label>Known Ratio (a : b)</label>
                    <div class="input-grid">
                        <input type="number" id="prop_a" value="3" step="any" oninput="updatePropPreview()">
                        <div class="colon">:</div>
                        <input type="number" id="prop_b" value="4" step="any" oninput="updatePropPreview()">
                    </div>
                </div>
                <div class="input-section">
                    <label>New First Value (c)</label>
                    <input type="number" id="prop_c" value="9" step="any" oninput="updatePropPreview()">
                    <div class="input-hint">Find: x where a:b = c:x</div>
                </div>
                <button class="btn" onclick="solveProportion()">Solve for x</button>
                <div class="examples">
                    <button class="example-btn" onclick="setProp(3,4,9)">3:4=9:x</button>
                    <button class="example-btn" onclick="setProp(2,5,8)">2:5=8:x</button>
                    <button class="example-btn" onclick="setProp(7,3,21)">7:3=21:x</button>
                </div>
            </div>

            <!-- Tab 4: 3-Way Ratio -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">3-Way Ratio</h3>
                <div class="ratio-preview" id="three_preview">2 : 3 : 5</div>
                <div class="input-section">
                    <label>Ratio Parts (a : b : c)</label>
                    <div style="display: grid; grid-template-columns: 1fr auto 1fr auto 1fr; gap: 8px; align-items: center;">
                        <input type="number" id="three_a" value="2" step="any" min="0" oninput="updateThreePreview()">
                        <div class="colon">:</div>
                        <input type="number" id="three_b" value="3" step="any" min="0" oninput="updateThreePreview()">
                        <div class="colon">:</div>
                        <input type="number" id="three_c" value="5" step="any" min="0" oninput="updateThreePreview()">
                    </div>
                </div>
                <div class="input-section">
                    <label>Total Amount</label>
                    <input type="number" id="three_total" value="100" step="any" min="0">
                    <div class="input-hint">Divide this amount by the ratio</div>
                </div>
                <button class="btn" onclick="calcThreeWay()">Calculate Shares</button>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Ratio Concepts</h3>
            <div class="formula-box">
                <strong>Ratio:</strong>
                Comparison of two or more quantities<br>
                Written as a:b or a/b
            </div>
            <div class="formula-box">
                <strong>Simplification:</strong>
                Divide by GCD (Greatest Common Divisor)<br>
                Example: 12:18 = 2:3 (divide by 6)
            </div>
            <div class="formula-box">
                <strong>Proportion:</strong>
                Two equal ratios: a:b = c:d<br>
                Cross multiply: a×d = b×c
            </div>
            <div class="formula-box">
                <strong>3-Way Ratio:</strong>
                a:b:c = parts of total<br>
                Each share = (part/sum) × total
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
        
        function gcd(a, b) {
            a = Math.abs(a);
            b = Math.abs(b);
            while(b !== 0) {
                let temp = b;
                b = a % b;
                a = temp;
            }
            return a || 1;
        }
        
        function updateSimpPreview() {
            const a = document.getElementById('simp_a').value || '?';
            const b = document.getElementById('simp_b').value || '?';
            document.getElementById('simp_preview').textContent = `${a} : ${b}`;
        }
        
        function updateScalePreview() {
            const a = document.getElementById('scale_a').value || '?';
            const b = document.getElementById('scale_b').value || '?';
            document.getElementById('scale_preview').textContent = `${a} : ${b}`;
        }
        
        function updatePropPreview() {
            const a = document.getElementById('prop_a').value || '?';
            const b = document.getElementById('prop_b').value || '?';
            const c = document.getElementById('prop_c').value || '?';
            document.getElementById('prop_preview').textContent = `${a} : ${b} = ${c} : x`;
        }
        
        function updateThreePreview() {
            const a = document.getElementById('three_a').value || '?';
            const b = document.getElementById('three_b').value || '?';
            const c = document.getElementById('three_c').value || '?';
            document.getElementById('three_preview').textContent = `${a} : ${b} : ${c}`;
        }
        
        function setSimp(a, b) {
            document.getElementById('simp_a').value = a;
            document.getElementById('simp_b').value = b;
            updateSimpPreview();
        }
        
        function setProp(a, b, c) {
            document.getElementById('prop_a').value = a;
            document.getElementById('prop_b').value = b;
            document.getElementById('prop_c').value = c;
            updatePropPreview();
        }
        
        function simplifyRatio() {
            const a = parseFloat(document.getElementById('simp_a').value);
            const b = parseFloat(document.getElementById('simp_b').value);
            
            if(isNaN(a) || isNaN(b) || a < 0 || b < 0) {
                return alert('⚠️ Enter positive numbers');
            }
            
            if(a === 0 || b === 0) {
                return alert('⚠️ Ratio cannot contain zero');
            }
            
            const g = gcd(a, b);
            const simpA = a / g;
            const simpB = b / g;
            
            const decimal = a / b;
            const percentage = (a / (a + b)) * 100;
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Simplified Ratio</div>
                    <div class="result-value" style="color:#4CAF50;">${simpA}:${simpB}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">GCD</div>
                    <div class="result-value" style="color:#2196F3;">${g}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Decimal Form</div>
                    <div class="result-value" style="color:#FF9800;">${decimal.toFixed(6)}</div>
                </div>
                <div class="result-box" style="border-left-color:#9C27B0;">
                    <div class="result-label">First Part %</div>
                    <div class="result-value" style="color:#9C27B0;">${percentage.toFixed(2)}%</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Simplification Steps:</strong>
                <div class="step">Original: ${a}:${b}</div>
                <div class="step">Find GCD(${a}, ${b}) = ${g}</div>
                <div class="step">Divide both by ${g}</div>
                <div class="step">${a}÷${g} : ${b}÷${g}</div>
                <div class="step">Simplified: ${simpA}:${simpB}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;">
                <strong style="color:#4CAF50;">📊 Ratio Analysis:</strong>
                • Original: ${a}:${b}<br>
                • Simplified: ${simpA}:${simpB}<br>
                • Decimal: ${decimal.toFixed(4)}<br>
                • First part: ${percentage.toFixed(1)}%<br>
                • Second part: ${(100-percentage).toFixed(1)}%
            </div>`;
            
            show(html);
        }
        
        function scaleRatio() {
            const a = parseFloat(document.getElementById('scale_a').value);
            const b = parseFloat(document.getElementById('scale_b').value);
            const factor = parseFloat(document.getElementById('scale_factor').value);
            
            if(isNaN(a) || isNaN(b) || isNaN(factor) || a < 0 || b < 0 || factor < 0) {
                return alert('⚠️ Enter positive numbers');
            }
            
            const newA = a * factor;
            const newB = b * factor;
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Scaled Ratio</div>
                    <div class="result-value" style="color:#4CAF50;">${newA}:${newB}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Scale Factor</div>
                    <div class="result-value" style="color:#2196F3;">×${factor}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">First Value</div>
                    <div class="result-value" style="color:#FF9800;">${newA}</div>
                </div>
                <div class="result-box" style="border-left-color:#9C27B0;">
                    <div class="result-label">Second Value</div>
                    <div class="result-value" style="color:#9C27B0;">${newB}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Scaling Steps:</strong>
                <div class="step">Original ratio: ${a}:${b}</div>
                <div class="step">Scale factor: ${factor}</div>
                <div class="step">New first: ${a} × ${factor} = ${newA}</div>
                <div class="step">New second: ${b} × ${factor} = ${newB}</div>
                <div class="step">Scaled ratio: ${newA}:${newB}</div>
            </div>`;
            
            show(html);
        }
        
        function solveProportion() {
            const a = parseFloat(document.getElementById('prop_a').value);
            const b = parseFloat(document.getElementById('prop_b').value);
            const c = parseFloat(document.getElementById('prop_c').value);
            
            if(isNaN(a) || isNaN(b) || isNaN(c) || a === 0 || b === 0) {
                return alert('⚠️ Enter valid non-zero values');
            }
            
            // a:b = c:x → x = (b×c)/a
            const x = (b * c) / a;
            
            let html = `<div class="result-box">
                <div class="result-label">Solution</div>
                <div class="result-value">x = ${x.toFixed(6)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Proportion Solution:</strong>
                <div class="step">Proportion: ${a}:${b} = ${c}:x</div>
                <div class="step">Cross multiply: ${a} × x = ${b} × ${c}</div>
                <div class="step">${a}x = ${b * c}</div>
                <div class="step">x = ${b * c} ÷ ${a}</div>
                <div class="step">x = ${x.toFixed(6)}</div>
            </div>`;
            
            const verify1 = a / b;
            const verify2 = c / x;
            html += `<div class="formula-box" style="background:#e8f5e9;">
                <strong style="color:#4CAF50;">✓ Verification:</strong>
                ${a}/${b} = ${verify1.toFixed(6)}<br>
                ${c}/${x.toFixed(4)} = ${verify2.toFixed(6)}<br>
                Equal ✓
            </div>`;
            
            show(html);
        }
        
        function calcThreeWay() {
            const a = parseFloat(document.getElementById('three_a').value);
            const b = parseFloat(document.getElementById('three_b').value);
            const c = parseFloat(document.getElementById('three_c').value);
            const total = parseFloat(document.getElementById('three_total').value);
            
            if(isNaN(a) || isNaN(b) || isNaN(c) || isNaN(total) || a < 0 || b < 0 || c < 0 || total < 0) {
                return alert('⚠️ Enter positive numbers');
            }
            
            const sum = a + b + c;
            if(sum === 0) return alert('⚠️ Sum cannot be zero');
            
            const shareA = (a / sum) * total;
            const shareB = (b / sum) * total;
            const shareC = (c / sum) * total;
            
            // Simplify ratio
            const g = gcd(gcd(a, b), c);
            const simpA = a / g;
            const simpB = b / g;
            const simpC = c / g;
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">First Share</div>
                    <div class="result-value" style="color:#4CAF50;">${shareA.toFixed(2)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Second Share</div>
                    <div class="result-value" style="color:#2196F3;">${shareB.toFixed(2)}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Third Share</div>
                    <div class="result-value" style="color:#FF9800;">${shareC.toFixed(2)}</div>
                </div>
                <div class="result-box" style="border-left-color:#9C27B0;">
                    <div class="result-label">Simplified</div>
                    <div class="result-value" style="color:#9C27B0;">${simpA}:${simpB}:${simpC}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Division Steps:</strong>
                <div class="step">Ratio: ${a}:${b}:${c}</div>
                <div class="step">Sum of parts: ${a}+${b}+${c} = ${sum}</div>
                <div class="step">First: (${a}/${sum}) × ${total} = ${shareA.toFixed(2)}</div>
                <div class="step">Second: (${b}/${sum}) × ${total} = ${shareB.toFixed(2)}</div>
                <div class="step">Third: (${c}/${sum}) × ${total} = ${shareC.toFixed(2)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;">
                <strong style="color:#4CAF50;">📊 Summary:</strong>
                • Total: ${total}<br>
                • Ratio: ${a}:${b}:${c} (simplified: ${simpA}:${simpB}:${simpC})<br>
                • Shares: ${shareA.toFixed(2)}, ${shareB.toFixed(2)}, ${shareC.toFixed(2)}<br>
                • Percentages: ${((shareA/total)*100).toFixed(1)}%, ${((shareB/total)*100).toFixed(1)}%, ${((shareC/total)*100).toFixed(1)}%
            </div>`;
            
            show(html);
        }
        
        // Initialize
        updateSimpPreview();
        updateScalePreview();
        updatePropPreview();
        updateThreePreview();
    </script>
</body>
</html>