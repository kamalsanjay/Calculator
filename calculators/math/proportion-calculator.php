<?php
/**
 * Proportion Calculator - FIXED RESPONSIVE VERSION
 * File: proportion-calculator.php
 * Description: Fully responsive proportion calculator with proper layout
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Proportion Calculator - Ratios & Cross Multiplication</title>
    <meta name="description" content="Solve proportions, ratios, direct/inverse proportions with step-by-step solutions.">
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
        .proportion-preview { background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); padding: 16px 12px; border-radius: 8px; text-align: center; margin-bottom: 16px; border: 2px solid #667eea; font-size: 1.2rem; font-weight: bold; color: #667eea; font-family: 'Courier New', monospace; word-break: break-word; overflow-wrap: break-word; }
        .fraction-input { display: grid; grid-template-columns: 1fr 30px 1fr 30px 1fr 30px 1fr; gap: 6px; align-items: center; margin-bottom: 16px; }
        .fraction-input input { text-align: center; padding: 10px 4px; font-size: 0.95rem; min-width: 0; }
        .fraction-input span { font-size: 1.3rem; font-weight: bold; color: #667eea; text-align: center; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.05rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .examples { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; margin: 16px 0; }
        .example-btn { padding: 10px 6px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.8rem; transition: all 0.3s; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .example-btn:hover { background: #667eea; color: white; transform: translateY(-2px); }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 16px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; overflow: hidden; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.2rem; }
        .result-box { background: white; padding: 14px; border-radius: 10px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; overflow: hidden; }
        .result-label { font-size: 0.7rem; color: #666; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .result-value { font-size: 1.2rem; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; word-break: break-word; line-height: 1.4; overflow-wrap: break-word; }
        .formula-box { background: #f9f9f9; padding: 12px; border-radius: 8px; border-left: 4px solid #667eea; margin: 14px 0; font-size: 0.8rem; line-height: 1.6; overflow-wrap: break-word; }
        .formula-box strong { color: #667eea; display: block; margin-bottom: 6px; }
        .step-box { background: #fff3cd; padding: 12px; border-radius: 8px; border-left: 4px solid #ffc107; margin: 14px 0; overflow: hidden; }
        .step-box strong { color: #f57c00; display: block; margin-bottom: 8px; font-size: 0.85rem; }
        .step { padding: 6px 0; border-bottom: 1px solid #ffe082; font-family: 'Courier New', monospace; font-size: 0.8rem; word-break: break-word; overflow-wrap: break-word; }
        .step:last-child { border-bottom: none; }
        .info-box { background: white; padding: 16px; border-radius: 12px; line-height: 1.7; box-shadow: 0 8px 30px rgba(0,0,0,0.15); margin-top: 16px; overflow: hidden; }
        .info-box h3 { color: #667eea; margin-bottom: 14px; font-size: 1.1rem; }
        
        @media (max-width: 479px) {
            header h1 { font-size: 1.3rem; }
            .proportion-preview { font-size: 1rem; padding: 12px 8px; }
            .fraction-input { grid-template-columns: 1fr 25px 1fr 25px 1fr 25px 1fr; gap: 4px; }
            .fraction-input input { font-size: 0.85rem; padding: 8px 2px; }
            .fraction-input span { font-size: 1.1rem; }
            .result-value { font-size: 1rem; }
            .btn { font-size: 0.95rem; padding: 12px 16px; }
            .calc-tabs { grid-template-columns: repeat(2, 1fr); gap: 6px; }
            .tab-btn { font-size: 0.65rem; padding: 8px 4px; }
            .examples { grid-template-columns: repeat(2, 1fr); }
            .example-btn { font-size: 0.75rem; padding: 8px 4px; }
            .step { font-size: 0.75rem; }
        }
        
        @media (min-width: 480px) and (max-width: 767px) {
            .calc-tabs { grid-template-columns: repeat(3, 1fr); }
        }
        
        @media (min-width: 768px) { 
            body { padding: 20px; }
            .container { max-width: 700px; margin: 0 auto; }
            header h1 { font-size: 1.8rem; }
            .calculator-body { padding: 24px; }
            .proportion-preview { font-size: 1.4rem; }
            .result-value { font-size: 1.3rem; }
        }
        @media (min-width: 1024px) { .container { max-width: 900px; } }
        @media (min-width: 1280px) { .container { max-width: 1000px; } }
    </style>
</head>
<body>
    <header>
        <h1>⚖️ Proportion Calculator</h1>
        <p>Ratios, Cross Multiplication & More</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Solve Proportion</button>
                <button class="tab-btn" onclick="switchTab(1)">Simplify Ratio</button>
                <button class="tab-btn" onclick="switchTab(2)">Direct Proportion</button>
                <button class="tab-btn" onclick="switchTab(3)">Inverse Proportion</button>
                <button class="tab-btn" onclick="switchTab(4)">Equivalent Ratios</button>
            </div>

            <!-- Tab 1: Solve Proportion -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">🔍 Solve Proportion</h3>
                <div class="proportion-preview" id="prop_preview">a/b = c/x</div>
                
                <div class="fraction-input">
                    <input type="number" id="prop_a" value="3" step="any" placeholder="a" oninput="updatePropPreview()">
                    <span>/</span>
                    <input type="number" id="prop_b" value="4" step="any" placeholder="b" oninput="updatePropPreview()">
                    <span>=</span>
                    <input type="number" id="prop_c" value="6" step="any" placeholder="c" oninput="updatePropPreview()">
                    <span>/</span>
                    <input type="text" id="prop_d" value="x" placeholder="x" readonly style="background:#f0f0f0;">
                </div>
                <div class="input-hint">Enter 3 values to find x using cross multiplication</div>
                <button class="btn" onclick="solveProportion()">Solve for x</button>
                <div class="examples">
                    <button class="example-btn" onclick="setProp(3,4,6,'x')">3/4 = 6/x</button>
                    <button class="example-btn" onclick="setProp(2,5,'x',10)">2/5 = x/10</button>
                    <button class="example-btn" onclick="setProp(5,8,10,'x')">5/8 = 10/x</button>
                </div>
            </div>

            <!-- Tab 2: Simplify Ratio -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">📉 Simplify Ratio</h3>
                <div class="input-section">
                    <label>First Number</label>
                    <input type="number" id="ratio_a" value="12" step="any">
                </div>
                <div class="input-section">
                    <label>Second Number</label>
                    <input type="number" id="ratio_b" value="18" step="any">
                </div>
                <button class="btn" onclick="simplifyRatio()">Simplify Ratio</button>
                <div class="examples">
                    <button class="example-btn" onclick="setRatio(12,18)">12:18</button>
                    <button class="example-btn" onclick="setRatio(24,36)">24:36</button>
                    <button class="example-btn" onclick="setRatio(15,25)">15:25</button>
                </div>
            </div>

            <!-- Tab 3: Direct Proportion -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">↗️ Direct Proportion</h3>
                <p style="margin-bottom:14px;font-size:0.85rem;color:#666;">If a increases, b increases</p>
                <div class="input-section">
                    <label>When a = </label>
                    <input type="number" id="direct_a1" value="3" step="any">
                </div>
                <div class="input-section">
                    <label>Then b = </label>
                    <input type="number" id="direct_b1" value="12" step="any">
                </div>
                <div class="input-section">
                    <label>Find b when a = </label>
                    <input type="number" id="direct_a2" value="5" step="any">
                </div>
                <button class="btn" onclick="calcDirect()">Calculate</button>
            </div>

            <!-- Tab 4: Inverse Proportion -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">↙️ Inverse Proportion</h3>
                <p style="margin-bottom:14px;font-size:0.85rem;color:#666;">If a increases, b decreases</p>
                <div class="input-section">
                    <label>When a = </label>
                    <input type="number" id="inverse_a1" value="4" step="any">
                </div>
                <div class="input-section">
                    <label>Then b = </label>
                    <input type="number" id="inverse_b1" value="12" step="any">
                </div>
                <div class="input-section">
                    <label>Find b when a = </label>
                    <input type="number" id="inverse_a2" value="6" step="any">
                </div>
                <button class="btn" onclick="calcInverse()">Calculate</button>
            </div>

            <!-- Tab 5: Equivalent Ratios -->
            <div id="tab4" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">🔄 Equivalent Ratios</h3>
                <div class="input-section">
                    <label>Original Ratio (a:b)</label>
                    <div style="display:grid;grid-template-columns:1fr auto 1fr;gap:10px;align-items:center;">
                        <input type="number" id="equiv_a" value="3" step="any">
                        <span style="font-size:1.3rem;font-weight:bold;color:#667eea;">:</span>
                        <input type="number" id="equiv_b" value="4" step="any">
                    </div>
                </div>
                <div class="input-section">
                    <label>Number of Ratios</label>
                    <input type="number" id="equiv_count" value="5" min="1" max="10" step="1">
                </div>
                <button class="btn" onclick="findEquivalent()">Generate</button>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Concepts</h3>
            <div class="formula-box">
                <strong>Proportion:</strong>
                a/b = c/d → Cross multiply: a×d = b×c
            </div>
            <div class="formula-box">
                <strong>Direct Proportion:</strong>
                y = kx (k constant) - Both increase together
            </div>
            <div class="formula-box">
                <strong>Inverse Proportion:</strong>
                y = k/x (k constant) - One increases, other decreases
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
            return a;
        }
        
        function updatePropPreview() {
            const a = document.getElementById('prop_a').value || 'a';
            const b = document.getElementById('prop_b').value || 'b';
            const c = document.getElementById('prop_c').value || 'c';
            document.getElementById('prop_preview').textContent = `${a}/${b} = ${c}/x`;
        }
        
        function setProp(a,b,c,d) {
            document.getElementById('prop_a').value = a;
            document.getElementById('prop_b').value = b;
            document.getElementById('prop_c').value = c === 'x' ? '' : c;
            updatePropPreview();
        }
        
        function setRatio(a,b) {
            document.getElementById('ratio_a').value = a;
            document.getElementById('ratio_b').value = b;
        }
        
        function solveProportion() {
            const a = parseFloat(document.getElementById('prop_a').value);
            const b = parseFloat(document.getElementById('prop_b').value);
            const c = parseFloat(document.getElementById('prop_c').value);
            
            if(isNaN(a)||isNaN(b)||isNaN(c)||b===0) {
                return alert('⚠️ Enter valid numbers (b ≠ 0)');
            }
            
            const x = (b * c) / a;
            
            let html = `<div class="result-box">
                <div class="result-label">Proportion</div>
                <div class="result-value">${a}/${b} = ${c}/x</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Solution</div>
                <div class="result-value" style="color:#2196F3;">x = ${x.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Cross Multiplication:</strong>
                <div class="step">a × x = b × c</div>
                <div class="step">${a} × x = ${b} × ${c}</div>
                <div class="step">x = (${b} × ${c}) / ${a}</div>
                <div class="step">x = ${x.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">✓ Verification:</strong>
                ${a}/${b} = ${(a/b).toFixed(4)}<br>
                ${c}/${x.toFixed(2)} = ${(c/x).toFixed(4)}<br>
                Equal: ${Math.abs((a/b) - (c/x)) < 0.0001 ? 'YES ✓' : 'Check'}
            </div>`;
            
            show(html);
        }
        
        function simplifyRatio() {
            const a = parseFloat(document.getElementById('ratio_a').value);
            const b = parseFloat(document.getElementById('ratio_b').value);
            
            if(isNaN(a)||isNaN(b)||b===0) {
                return alert('⚠️ Enter valid numbers');
            }
            
            const g = gcd(a, b);
            const simA = a / g;
            const simB = b / g;
            
            let html = `<div class="result-box">
                <div class="result-label">Original</div>
                <div class="result-value">${a} : ${b}</div>
            </div>
            <div class="result-box" style="border-left-color:#4CAF50;">
                <div class="result-label">Simplified</div>
                <div class="result-value" style="color:#4CAF50;">${simA} : ${simB}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Steps:</strong>
                <div class="step">GCD(${a}, ${b}) = ${g}</div>
                <div class="step">${a}÷${g} : ${b}÷${g}</div>
                <div class="step">= ${simA} : ${simB}</div>
            </div>`;
            
            show(html);
        }
        
        function calcDirect() {
            const a1 = parseFloat(document.getElementById('direct_a1').value);
            const b1 = parseFloat(document.getElementById('direct_b1').value);
            const a2 = parseFloat(document.getElementById('direct_a2').value);
            
            if(isNaN(a1)||isNaN(b1)||isNaN(a2)||a1===0) {
                return alert('⚠️ Enter valid numbers');
            }
            
            const b2 = (b1 * a2) / a1;
            const k = b1 / a1;
            
            let html = `<div class="result-box">
                <div class="result-label">Result</div>
                <div class="result-value">b = ${b2.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Direct: b = k×a</strong>
                <div class="step">k = ${b1}/${a1} = ${k.toFixed(4)}</div>
                <div class="step">b = ${k.toFixed(4)} × ${a2}</div>
                <div class="step">b = ${b2.toFixed(4)}</div>
            </div>`;
            
            show(html);
        }
        
        function calcInverse() {
            const a1 = parseFloat(document.getElementById('inverse_a1').value);
            const b1 = parseFloat(document.getElementById('inverse_b1').value);
            const a2 = parseFloat(document.getElementById('inverse_a2').value);
            
            if(isNaN(a1)||isNaN(b1)||isNaN(a2)||a2===0) {
                return alert('⚠️ Enter valid numbers');
            }
            
            const b2 = (a1 * b1) / a2;
            const k = a1 * b1;
            
            let html = `<div class="result-box">
                <div class="result-label">Result</div>
                <div class="result-value">b = ${b2.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Inverse: a×b = k</strong>
                <div class="step">k = ${a1}×${b1} = ${k}</div>
                <div class="step">b = ${k}/${a2}</div>
                <div class="step">b = ${b2.toFixed(4)}</div>
            </div>`;
            
            show(html);
        }
        
        function findEquivalent() {
            const a = parseFloat(document.getElementById('equiv_a').value);
            const b = parseFloat(document.getElementById('equiv_b').value);
            const count = parseInt(document.getElementById('equiv_count').value);
            
            if(isNaN(a)||isNaN(b)||b===0||isNaN(count)||count<1||count>10) {
                return alert('⚠️ Valid numbers needed (count: 1-10)');
            }
            
            let html = `<div class="result-box">
                <div class="result-label">Original</div>
                <div class="result-value">${a} : ${b}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Equivalent Ratios:</strong>`;
            
            for(let i = 1; i <= count; i++) {
                html += `<div class="step">${(a*i).toFixed(1)} : ${(b*i).toFixed(1)}</div>`;
            }
            html += `</div>`;
            
            show(html);
        }
        
        updatePropPreview();
    </script>
</body>
</html>