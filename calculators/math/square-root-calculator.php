<?php
/**
 * Square Root Calculator
 * File: square-root-calculator.php
 * Description: Calculate square roots, cube roots, nth roots with simplification
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Root Calculator - Square Root, Cube Root & Nth Root</title>
    <meta name="description" content="Calculate square roots, cube roots, nth roots with simplification and step-by-step solutions.">
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
        .preview-box { background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 16px; border: 2px solid #667eea; font-size: 1.8rem; font-weight: bold; color: #667eea; font-family: 'Courier New', monospace; min-height: 80px; display: flex; align-items: center; justify-content: center; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .examples { display: grid; grid-template-columns: repeat(auto-fit, minmax(90px, 1fr)); gap: 8px; margin: 16px 0; }
        .example-btn { padding: 10px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; white-space: nowrap; }
        .example-btn:hover { background: #667eea; color: white; transform: translateY(-2px); }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; overflow: hidden; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.3rem; }
        .result-box { background: white; padding: 16px; border-radius: 10px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; overflow: hidden; }
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
            .preview-box { font-size: 1.4rem; padding: 15px; }
        }
        @media (min-width: 768px) { 
            body { padding: 24px; }
            .container { max-width: 720px; margin: 0 auto; }
            header h1 { font-size: 2rem; }
            .calculator-body { padding: 24px; }
        }
        @media (min-width: 1024px) { .container { max-width: 960px; } }
        @media (min-width: 1280px) { .container { max-width: 1100px; } }
    </style>
</head>
<body>
    <header>
        <h1>√ Root Calculator</h1>
        <p>Square Root, Cube Root & Nth Root</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Square Root</button>
                <button class="tab-btn" onclick="switchTab(1)">Cube Root</button>
                <button class="tab-btn" onclick="switchTab(2)">Nth Root</button>
            </div>

            <!-- Tab 1: Square Root -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">√ Square Root</h3>
                <div class="preview-box" id="sqrt_preview">√x</div>
                <div class="input-section">
                    <label>Number (x)</label>
                    <input type="number" id="sqrt_num" value="16" step="any" min="0" oninput="updateSqrtPreview()">
                    <div class="input-hint">Find √x</div>
                </div>
                <button class="btn" onclick="calcSquareRoot()">Calculate √</button>
                <div class="examples">
                    <button class="example-btn" onclick="setSqrt(4)">√4</button>
                    <button class="example-btn" onclick="setSqrt(9)">√9</button>
                    <button class="example-btn" onclick="setSqrt(16)">√16</button>
                    <button class="example-btn" onclick="setSqrt(25)">√25</button>
                    <button class="example-btn" onclick="setSqrt(50)">√50</button>
                </div>
            </div>

            <!-- Tab 2: Cube Root -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">∛ Cube Root</h3>
                <div class="preview-box" id="cbrt_preview">∛x</div>
                <div class="input-section">
                    <label>Number (x)</label>
                    <input type="number" id="cbrt_num" value="27" step="any" oninput="updateCbrtPreview()">
                    <div class="input-hint">Find ∛x (accepts negative numbers)</div>
                </div>
                <button class="btn" onclick="calcCubeRoot()">Calculate ∛</button>
                <div class="examples">
                    <button class="example-btn" onclick="setCbrt(8)">∛8</button>
                    <button class="example-btn" onclick="setCbrt(27)">∛27</button>
                    <button class="example-btn" onclick="setCbrt(64)">∛64</button>
                    <button class="example-btn" onclick="setCbrt(-8)">∛-8</button>
                </div>
            </div>

            <!-- Tab 3: Nth Root -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">ⁿ√ Nth Root</h3>
                <div class="preview-box" id="nth_preview">ⁿ√x</div>
                <div class="input-section">
                    <label>Number (x)</label>
                    <input type="number" id="nth_num" value="32" step="any" oninput="updateNthPreview()">
                </div>
                <div class="input-section">
                    <label>Root Index (n)</label>
                    <input type="number" id="nth_index" value="5" step="1" min="2" oninput="updateNthPreview()">
                    <div class="input-hint">n = 2 for square root, n = 3 for cube root</div>
                </div>
                <button class="btn" onclick="calcNthRoot()">Calculate ⁿ√x</button>
                <div class="examples">
                    <button class="example-btn" onclick="setNth(32,5)">⁵√32</button>
                    <button class="example-btn" onclick="setNth(64,6)">⁶√64</button>
                    <button class="example-btn" onclick="setNth(128,7)">⁷√128</button>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Root Concepts</h3>
            <div class="formula-box">
                <strong>Square Root (√):</strong>
                √x = number that when squared gives x<br>
                √16 = 4 because 4² = 16
            </div>
            <div class="formula-box">
                <strong>Cube Root (∛):</strong>
                ∛x = number that when cubed gives x<br>
                ∛27 = 3 because 3³ = 27
            </div>
            <div class="formula-box">
                <strong>Nth Root (ⁿ√):</strong>
                ⁿ√x = number that when raised to power n gives x<br>
                ⁵√32 = 2 because 2⁵ = 32
            </div>
            <div class="formula-box">
                <strong>Perfect Squares:</strong>
                1, 4, 9, 16, 25, 36, 49, 64, 81, 100...
            </div>
            <div class="formula-box">
                <strong>Perfect Cubes:</strong>
                1, 8, 27, 64, 125, 216, 343, 512, 729, 1000...
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
        
        function updateSqrtPreview() {
            const x = document.getElementById('sqrt_num').value || 'x';
            document.getElementById('sqrt_preview').textContent = `√${x}`;
        }
        
        function updateCbrtPreview() {
            const x = document.getElementById('cbrt_num').value || 'x';
            document.getElementById('cbrt_preview').textContent = `∛${x}`;
        }
        
        function updateNthPreview() {
            const x = document.getElementById('nth_num').value || 'x';
            const n = document.getElementById('nth_index').value || 'n';
            document.getElementById('nth_preview').textContent = `${n}√${x}`;
        }
        
        function setSqrt(val) {
            document.getElementById('sqrt_num').value = val;
            updateSqrtPreview();
        }
        
        function setCbrt(val) {
            document.getElementById('cbrt_num').value = val;
            updateCbrtPreview();
        }
        
        function setNth(x, n) {
            document.getElementById('nth_num').value = x;
            document.getElementById('nth_index').value = n;
            updateNthPreview();
        }
        
        function isPerfectSquare(n) {
            const sqrt = Math.sqrt(n);
            return sqrt === Math.floor(sqrt);
        }
        
        function isPerfectCube(n) {
            const cbrt = Math.cbrt(Math.abs(n));
            return Math.abs(cbrt - Math.round(cbrt)) < 0.0001;
        }
        
        function simplifySquareRoot(n) {
            if(n <= 0) return null;
            
            let outside = 1;
            let inside = n;
            
            for(let i = 2; i * i <= inside; i++) {
                while(inside % (i*i) === 0) {
                    outside *= i;
                    inside /= (i*i);
                }
            }
            
            return {outside, inside};
        }
        
        function calcSquareRoot() {
            const x = parseFloat(document.getElementById('sqrt_num').value);
            
            if(isNaN(x) || x < 0) {
                return alert('⚠️ Enter non-negative number');
            }
            
            const result = Math.sqrt(x);
            const isPerfect = isPerfectSquare(x);
            const simplified = simplifySquareRoot(x);
            
            let html = `<div class="result-box">
                <div class="result-label">√${x}</div>
                <div class="result-value">${result.toFixed(6)}</div>
            </div>`;
            
            if(isPerfect) {
                html += `<div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Perfect Square</div>
                    <div class="result-value" style="color:#4CAF50;">YES ✓</div>
                </div>`;
            }
            
            if(simplified && simplified.outside > 1) {
                const simplifiedStr = simplified.inside === 1 ? 
                    `${simplified.outside}` : 
                    `${simplified.outside}√${simplified.inside}`;
                    
                html += `<div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Simplified</div>
                    <div class="result-value" style="color:#2196F3;">${simplifiedStr}</div>
                </div>`;
            }
            
            html += `<div class="step-box">
                <strong>📝 Calculation:</strong>
                <div class="step">√${x} = ${result.toFixed(6)}</div>
                <div class="step">Verification: ${result.toFixed(3)}² = ${(result*result).toFixed(3)}</div>`;
            
            if(isPerfect) {
                html += `<div class="step">Perfect square: ${Math.sqrt(x)}² = ${x}</div>`;
            }
            
            html += `</div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">📊 Properties:</strong>
                • Original: ${x}<br>
                • Square root: ${result.toFixed(4)}<br>
                • Perfect square: ${isPerfect ? 'Yes' : 'No'}<br>
                • Decimal places: ${result.toString().split('.')[1]?.length || 0}
            </div>`;
            
            show(html);
        }
        
        function calcCubeRoot() {
            const x = parseFloat(document.getElementById('cbrt_num').value);
            
            if(isNaN(x)) {
                return alert('⚠️ Enter valid number');
            }
            
            const result = x >= 0 ? Math.cbrt(x) : -Math.cbrt(Math.abs(x));
            const isPerfect = isPerfectCube(x);
            
            let html = `<div class="result-box">
                <div class="result-label">∛${x}</div>
                <div class="result-value">${result.toFixed(6)}</div>
            </div>`;
            
            if(isPerfect) {
                html += `<div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Perfect Cube</div>
                    <div class="result-value" style="color:#4CAF50;">YES ✓</div>
                </div>`;
            }
            
            html += `<div class="step-box">
                <strong>📝 Calculation:</strong>
                <div class="step">∛${x} = ${result.toFixed(6)}</div>
                <div class="step">Verification: ${result.toFixed(3)}³ = ${(result*result*result).toFixed(3)}</div>`;
            
            if(isPerfect) {
                html += `<div class="step">Perfect cube: ${Math.round(result)}³ = ${x}</div>`;
            }
            
            html += `</div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">📊 Properties:</strong>
                • Original: ${x}<br>
                • Cube root: ${result.toFixed(4)}<br>
                • Perfect cube: ${isPerfect ? 'Yes' : 'No'}<br>
                • Sign: ${x >= 0 ? 'Positive' : 'Negative'}
            </div>`;
            
            show(html);
        }
        
        function calcNthRoot() {
            const x = parseFloat(document.getElementById('nth_num').value);
            const n = parseInt(document.getElementById('nth_index').value);
            
            if(isNaN(x) || isNaN(n) || n < 2) {
                return alert('⚠️ Enter valid number and root index (n ≥ 2)');
            }
            
            if(x < 0 && n % 2 === 0) {
                return alert('⚠️ Even roots of negative numbers are not real');
            }
            
            const result = x >= 0 ? Math.pow(x, 1/n) : -Math.pow(Math.abs(x), 1/n);
            const verification = Math.pow(result, n);
            const isPerfect = Math.abs(verification - x) < 0.0001 && Math.abs(result - Math.round(result)) < 0.0001;
            
            let html = `<div class="result-box">
                <div class="result-label">${n}√${x}</div>
                <div class="result-value">${result.toFixed(6)}</div>
            </div>`;
            
            if(isPerfect) {
                html += `<div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Perfect ${n}th Power</div>
                    <div class="result-value" style="color:#4CAF50;">YES ✓</div>
                </div>`;
            }
            
            html += `<div class="step-box">
                <strong>📝 Calculation:</strong>
                <div class="step">${n}√${x} = ${x}^(1/${n})</div>
                <div class="step">Result = ${result.toFixed(6)}</div>
                <div class="step">Verification: ${result.toFixed(3)}^${n} = ${verification.toFixed(3)}</div>`;
            
            if(isPerfect) {
                html += `<div class="step">Perfect power: ${Math.round(result)}^${n} = ${x}</div>`;
            }
            
            html += `</div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">📊 Properties:</strong>
                • Original: ${x}<br>
                • Root index: ${n}<br>
                • ${n}th root: ${result.toFixed(4)}<br>
                • Perfect ${n}th power: ${isPerfect ? 'Yes' : 'No'}
            </div>`;
            
            show(html);
        }
        
        // Initialize
        updateSqrtPreview();
        updateCbrtPreview();
        updateNthPreview();
    </script>
</body>
</html>