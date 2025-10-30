<?php
/**
 * Exponent Calculator
 * File: exponent-calculator.php
 * Description: Calculate powers, roots, and apply exponent rules
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Exponent Calculator - Powers, Roots & Exponent Rules</title>
    <meta name="description" content="Calculate exponents, powers, roots, and apply exponent rules with step-by-step solutions.">
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
        .calc-tabs { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; margin-bottom: 16px; }
        .tab-btn { padding: 12px 8px; background: #f0f0f0; border: none; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; font-size: 0.8rem; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .input-section { margin-bottom: 16px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 0.9rem; }
        .input-section input, .input-section select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; }
        .input-section input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .input-hint { font-size: 0.8rem; color: #666; margin-top: 6px; font-style: italic; }
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
        .step { padding: 8px 0; border-bottom: 1px solid #ffe082; font-size: 0.9rem; }
        .step:last-child { border-bottom: none; }
        .info-box { background: white; padding: 20px; border-radius: 12px; line-height: 1.8; box-shadow: 0 8px 30px rgba(0,0,0,0.15); margin-top: 16px; }
        .info-box h3 { color: #667eea; margin-bottom: 14px; font-size: 1.2rem; }
        .rule-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin: 16px 0; }
        .rule-card { background: #f5f5f5; padding: 12px; border-radius: 8px; border-left: 3px solid #667eea; }
        .rule-card strong { color: #667eea; display: block; margin-bottom: 4px; font-size: 0.9rem; }
        .rule-card code { font-family: 'Courier New', monospace; font-size: 0.85rem; color: #333; display: block; }
        
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
        <h1>🔢 Exponent Calculator</h1>
        <p>Powers, Roots & Exponent Rules</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Power</button>
                <button class="tab-btn" onclick="switchTab(1)">Root</button>
                <button class="tab-btn" onclick="switchTab(2)">Multiply</button>
                <button class="tab-btn" onclick="switchTab(3)">Divide</button>
            </div>

            <!-- Tab 1: Power -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">⚡ Power (aⁿ)</h3>
                <div class="input-section">
                    <label>Base (a)</label>
                    <input type="number" id="pow_base" value="2" step="any">
                </div>
                <div class="input-section">
                    <label>Exponent (n)</label>
                    <input type="number" id="pow_exp" value="3" step="any">
                    <div class="input-hint">Can be positive, negative, or decimal</div>
                </div>
                <button class="btn" onclick="calcPower()">Calculate Power</button>
                <div class="examples">
                    <button class="example-btn" onclick="setPower(2,3)">2³</button>
                    <button class="example-btn" onclick="setPower(5,2)">5²</button>
                    <button class="example-btn" onclick="setPower(10,4)">10⁴</button>
                    <button class="example-btn" onclick="setPower(3,-2)">3⁻²</button>
                    <button class="example-btn" onclick="setPower(4,0.5)">4^0.5</button>
                </div>
            </div>

            <!-- Tab 2: Root -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">√ Root (ⁿ√a)</h3>
                <div class="input-section">
                    <label>Radicand (a)</label>
                    <input type="number" id="root_num" value="8" step="any">
                </div>
                <div class="input-section">
                    <label>Root Index (n)</label>
                    <input type="number" id="root_index" value="3" step="any">
                    <div class="input-hint">2 = square root, 3 = cube root, etc.</div>
                </div>
                <button class="btn" onclick="calcRoot()">Calculate Root</button>
                <div class="examples">
                    <button class="example-btn" onclick="setRoot(16,2)">√16</button>
                    <button class="example-btn" onclick="setRoot(27,3)">³√27</button>
                    <button class="example-btn" onclick="setRoot(32,5)">⁵√32</button>
                    <button class="example-btn" onclick="setRoot(100,2)">√100</button>
                </div>
            </div>

            <!-- Tab 3: Multiply Powers -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">✖️ Multiply Powers (aᵐ × aⁿ)</h3>
                <div class="input-section">
                    <label>Base (a)</label>
                    <input type="number" id="mul_base" value="2" step="any">
                </div>
                <div class="input-section">
                    <label>First Exponent (m)</label>
                    <input type="number" id="mul_exp1" value="3" step="any">
                </div>
                <div class="input-section">
                    <label>Second Exponent (n)</label>
                    <input type="number" id="mul_exp2" value="4" step="any">
                </div>
                <button class="btn" onclick="calcMultiply()">Apply Multiplication Rule</button>
                <div class="examples">
                    <button class="example-btn" onclick="setMul(2,3,4)">2³ × 2⁴</button>
                    <button class="example-btn" onclick="setMul(5,2,3)">5² × 5³</button>
                    <button class="example-btn" onclick="setMul(3,1,5)">3¹ × 3⁵</button>
                </div>
            </div>

            <!-- Tab 4: Divide Powers -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">➗ Divide Powers (aᵐ ÷ aⁿ)</h3>
                <div class="input-section">
                    <label>Base (a)</label>
                    <input type="number" id="div_base" value="3" step="any">
                </div>
                <div class="input-section">
                    <label>Numerator Exponent (m)</label>
                    <input type="number" id="div_exp1" value="5" step="any">
                </div>
                <div class="input-section">
                    <label>Denominator Exponent (n)</label>
                    <input type="number" id="div_exp2" value="2" step="any">
                </div>
                <button class="btn" onclick="calcDivide()">Apply Division Rule</button>
                <div class="examples">
                    <button class="example-btn" onclick="setDiv(2,5,2)">2⁵ ÷ 2²</button>
                    <button class="example-btn" onclick="setDiv(4,6,3)">4⁶ ÷ 4³</button>
                    <button class="example-btn" onclick="setDiv(5,4,4)">5⁴ ÷ 5⁴</button>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Exponent Rules</h3>
            <div class="rule-grid">
                <div class="rule-card">
                    <strong>Product Rule</strong>
                    <code>aᵐ × aⁿ = a^(m+n)</code>
                </div>
                <div class="rule-card">
                    <strong>Quotient Rule</strong>
                    <code>aᵐ ÷ aⁿ = a^(m-n)</code>
                </div>
                <div class="rule-card">
                    <strong>Power Rule</strong>
                    <code>(aᵐ)ⁿ = a^(m×n)</code>
                </div>
                <div class="rule-card">
                    <strong>Zero Exponent</strong>
                    <code>a⁰ = 1 (a ≠ 0)</code>
                </div>
                <div class="rule-card">
                    <strong>Negative Exponent</strong>
                    <code>a⁻ⁿ = 1/aⁿ</code>
                </div>
                <div class="rule-card">
                    <strong>Fractional Exponent</strong>
                    <code>a^(m/n) = ⁿ√(aᵐ)</code>
                </div>
            </div>
            
            <div class="formula-box">
                <strong>Special Cases:</strong>
                • 1ⁿ = 1 (any exponent)<br>
                • 0ⁿ = 0 (n > 0)<br>
                • (ab)ⁿ = aⁿ × bⁿ<br>
                • (a/b)ⁿ = aⁿ / bⁿ
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
        
        function setPower(b,e) {
            document.getElementById('pow_base').value = b;
            document.getElementById('pow_exp').value = e;
        }
        
        function setRoot(n,i) {
            document.getElementById('root_num').value = n;
            document.getElementById('root_index').value = i;
        }
        
        function setMul(b,e1,e2) {
            document.getElementById('mul_base').value = b;
            document.getElementById('mul_exp1').value = e1;
            document.getElementById('mul_exp2').value = e2;
        }
        
        function setDiv(b,e1,e2) {
            document.getElementById('div_base').value = b;
            document.getElementById('div_exp1').value = e1;
            document.getElementById('div_exp2').value = e2;
        }
        
        function formatNumber(n) {
            if(Math.abs(n) > 1e10 || (Math.abs(n) < 1e-4 && n !== 0)) {
                return n.toExponential(4);
            }
            return n.toFixed(6).replace(/.?0+$/, '');
        }
        
        function calcPower() {
            const base = parseFloat(document.getElementById('pow_base').value);
            const exp = parseFloat(document.getElementById('pow_exp').value);
            
            if(isNaN(base) || isNaN(exp)) {
                return alert('⚠️ Please enter valid numbers');
            }
            
            if(base === 0 && exp <= 0) {
                return alert('⚠️ 0 cannot have zero or negative exponent');
            }
            
            const result = Math.pow(base, exp);
            const expression = `${base}^${exp}`;
            
            let html = `<div class="result-box">
                <div class="result-label">Expression</div>
                <div class="result-value">${expression}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Result</div>
                <div class="result-value" style="color:#2196F3;">${formatNumber(result)}</div>
            </div>`;
            
            let explanation = '';
            if(exp === 0) {
                explanation = `Any non-zero number to the power of 0 equals 1<br>${base}⁰ = 1`;
            } else if(exp === 1) {
                explanation = `Any number to the power of 1 equals itself<br>${base}¹ = ${base}`;
            } else if(exp < 0) {
                explanation = `Negative exponent means reciprocal<br>${base}^${exp} = 1/${base}^${Math.abs(exp)} = ${formatNumber(result)}`;
            } else if(exp % 1 !== 0) {
                explanation = `Fractional exponent represents a root<br>${base}^${exp} = ${formatNumber(result)}`;
            } else {
                const steps = [];
                for(let i = 1; i <= Math.min(exp, 5); i++) {
                    steps.push(`${base}^${i} = ${formatNumber(Math.pow(base, i))}`);
                }
                if(exp > 5) steps.push('...');
                explanation = steps.join('<br>');
            }
            
            html += `<div class="step-box">
                <strong>📝 Calculation:</strong>
                <div class="step">${explanation}</div>
            </div>`;
            
            if(base > 0 && exp % 1 !== 0) {
                html += `<div class="formula-box" style="background:#e3f2fd;border-left-color:#2196F3;">
                    <strong style="color:#1976d2;">💡 Note:</strong>
                    ${base}^${exp} can also be written as ⁿ√(${base}^m) where ${exp} = m/n
                </div>`;
            }
            
            show(html);
        }
        
        function calcRoot() {
            const num = parseFloat(document.getElementById('root_num').value);
            const index = parseFloat(document.getElementById('root_index').value);
            
            if(isNaN(num) || isNaN(index)) {
                return alert('⚠️ Please enter valid numbers');
            }
            
            if(index === 0) {
                return alert('⚠️ Root index cannot be zero');
            }
            
            if(num < 0 && index % 2 === 0) {
                return alert('⚠️ Cannot take even root of negative number');
            }
            
            const result = Math.pow(num, 1/index);
            const rootSymbol = index === 2 ? '√' : index === 3 ? '³√' : `${index}√`;
            
            let html = `<div class="result-box">
                <div class="result-label">Expression</div>
                <div class="result-value">${rootSymbol}${num}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Result</div>
                <div class="result-value" style="color:#2196F3;">${formatNumber(result)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Calculation:</strong>
                <div class="step">${rootSymbol}${num} = ${num}^(1/${index}) = ${formatNumber(result)}</div>
                <div class="step">Verification: ${formatNumber(result)}^${index} = ${formatNumber(Math.pow(result, index))}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula:</strong>
                ⁿ√a = a^(1/n)
            </div>`;
            
            show(html);
        }
        
        function calcMultiply() {
            const base = parseFloat(document.getElementById('mul_base').value);
            const exp1 = parseFloat(document.getElementById('mul_exp1').value);
            const exp2 = parseFloat(document.getElementById('mul_exp2').value);
            
            if(isNaN(base) || isNaN(exp1) || isNaN(exp2)) {
                return alert('⚠️ Please enter valid numbers');
            }
            
            const sumExp = exp1 + exp2;
            const result = Math.pow(base, sumExp);
            const val1 = Math.pow(base, exp1);
            const val2 = Math.pow(base, exp2);
            
            let html = `<div class="result-box">
                <div class="result-label">Expression</div>
                <div class="result-value">${base}^${exp1} × ${base}^${exp2}</div>
            </div>
            <div class="result-box" style="border-left-color:#FF9800;">
                <div class="result-label">Simplified Form</div>
                <div class="result-value" style="color:#FF9800;">${base}^${sumExp}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Result</div>
                <div class="result-value" style="color:#2196F3;">${formatNumber(result)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Step-by-Step:</strong>
                <div class="step">Step 1: ${base}^${exp1} = ${formatNumber(val1)}</div>
                <div class="step">Step 2: ${base}^${exp2} = ${formatNumber(val2)}</div>
                <div class="step">Step 3: ${formatNumber(val1)} × ${formatNumber(val2)} = ${formatNumber(result)}</div>
                <div class="step">Step 4: Using rule: ${base}^${exp1} × ${base}^${exp2} = ${base}^(${exp1}+${exp2}) = ${base}^${sumExp}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Product Rule:</strong>
                aᵐ × aⁿ = a^(m+n)<br>
                When multiplying same bases, add exponents
            </div>`;
            
            show(html);
        }
        
        function calcDivide() {
            const base = parseFloat(document.getElementById('div_base').value);
            const exp1 = parseFloat(document.getElementById('div_exp1').value);
            const exp2 = parseFloat(document.getElementById('div_exp2').value);
            
            if(isNaN(base) || isNaN(exp1) || isNaN(exp2)) {
                return alert('⚠️ Please enter valid numbers');
            }
            
            if(base === 0) {
                return alert('⚠️ Base cannot be zero');
            }
            
            const diffExp = exp1 - exp2;
            const result = Math.pow(base, diffExp);
            const val1 = Math.pow(base, exp1);
            const val2 = Math.pow(base, exp2);
            
            let html = `<div class="result-box">
                <div class="result-label">Expression</div>
                <div class="result-value">${base}^${exp1} ÷ ${base}^${exp2}</div>
            </div>
            <div class="result-box" style="border-left-color:#FF9800;">
                <div class="result-label">Simplified Form</div>
                <div class="result-value" style="color:#FF9800;">${base}^${diffExp}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Result</div>
                <div class="result-value" style="color:#2196F3;">${formatNumber(result)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Step-by-Step:</strong>
                <div class="step">Step 1: ${base}^${exp1} = ${formatNumber(val1)}</div>
                <div class="step">Step 2: ${base}^${exp2} = ${formatNumber(val2)}</div>
                <div class="step">Step 3: ${formatNumber(val1)} ÷ ${formatNumber(val2)} = ${formatNumber(result)}</div>
                <div class="step">Step 4: Using rule: ${base}^${exp1} ÷ ${base}^${exp2} = ${base}^(${exp1}-${exp2}) = ${base}^${diffExp}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Quotient Rule:</strong>
                aᵐ ÷ aⁿ = a^(m-n)<br>
                When dividing same bases, subtract exponents
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>