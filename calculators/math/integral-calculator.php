<?php
/**
 * Integral Calculator
 * File: integral-calculator.php
 * Description: Calculate indefinite and definite integrals with formulas
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Integral Calculator - Indefinite & Definite Integrals with Solutions</title>
    <meta name="description" content="Calculate integrals with step-by-step solutions. Power rule, trigonometric, exponential, and logarithmic integrals.">
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
        .input-section input { font-family: 'Courier New', monospace; }
        .input-section input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .input-hint { font-size: 0.8rem; color: #666; margin-top: 6px; font-style: italic; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .examples { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; margin: 16px 0; }
        .example-btn { padding: 10px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; font-family: 'Courier New', monospace; }
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
        <h1>∫ Integral Calculator</h1>
        <p>Indefinite & Definite Integrals with Solutions</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Power</button>
                <button class="tab-btn" onclick="switchTab(1)">Trig</button>
                <button class="tab-btn" onclick="switchTab(2)">Exponential</button>
                <button class="tab-btn" onclick="switchTab(3)">Definite</button>
            </div>

            <!-- Tab 1: Power Rule -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📐 Power Rule Integration</h3>
                <div class="input-section">
                    <label>Coefficient (a)</label>
                    <input type="number" id="pow_a" value="3" step="any">
                </div>
                <div class="input-section">
                    <label>Exponent (n)</label>
                    <input type="number" id="pow_n" value="2" step="any">
                    <div class="input-hint">∫ ax^n dx (n ≠ -1)</div>
                </div>
                <button class="btn" onclick="calcPower()">Calculate Integral</button>
                <div class="examples">
                    <button class="example-btn" onclick="setPower(1,2)">x²</button>
                    <button class="example-btn" onclick="setPower(3,2)">3x²</button>
                    <button class="example-btn" onclick="setPower(2,3)">2x³</button>
                    <button class="example-btn" onclick="setPower(1,0)">1</button>
                </div>
            </div>

            <!-- Tab 2: Trigonometric -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📐 Trigonometric Integrals</h3>
                <div class="input-section">
                    <label>Function Type</label>
                    <select id="trig_type">
                        <option value="sin">sin(x)</option>
                        <option value="cos">cos(x)</option>
                        <option value="sec2">sec²(x)</option>
                        <option value="csc2">csc²(x)</option>
                        <option value="sectan">sec(x)tan(x)</option>
                        <option value="csccot">csc(x)cot(x)</option>
                    </select>
                </div>
                <button class="btn" onclick="calcTrig()">Calculate Integral</button>
            </div>

            <!-- Tab 3: Exponential -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📊 Exponential & Logarithmic</h3>
                <div class="input-section">
                    <label>Function Type</label>
                    <select id="exp_type">
                        <option value="ex">e^x</option>
                        <option value="ax">a^x</option>
                        <option value="1x">1/x</option>
                    </select>
                </div>
                <div class="input-section" id="base_section" style="display:none;">
                    <label>Base (a)</label>
                    <input type="number" id="exp_base" value="2" step="any">
                </div>
                <button class="btn" onclick="calcExp()">Calculate Integral</button>
            </div>

            <!-- Tab 4: Definite Integral -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">🔢 Definite Integral</h3>
                <div class="input-section">
                    <label>Function: ax^n</label>
                    <input type="number" id="def_a" value="2" step="any" placeholder="Coefficient">
                </div>
                <div class="input-section">
                    <label>Exponent (n)</label>
                    <input type="number" id="def_n" value="2" step="any">
                </div>
                <div class="input-section">
                    <label>Lower Limit (a)</label>
                    <input type="number" id="def_lower" value="0" step="any">
                </div>
                <div class="input-section">
                    <label>Upper Limit (b)</label>
                    <input type="number" id="def_upper" value="2" step="any">
                    <div class="input-hint">∫[a to b] f(x) dx</div>
                </div>
                <button class="btn" onclick="calcDefinite()">Calculate Definite Integral</button>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Integration Rules</h3>
            <div class="rule-grid">
                <div class="rule-card">
                    <strong>Power Rule</strong>
                    <code>∫ x^n dx = x^(n+1)/(n+1) + C</code>
                </div>
                <div class="rule-card">
                    <strong>Constant Rule</strong>
                    <code>∫ a dx = ax + C</code>
                </div>
                <div class="rule-card">
                    <strong>sin(x)</strong>
                    <code>∫ sin(x) dx = -cos(x) + C</code>
                </div>
                <div class="rule-card">
                    <strong>cos(x)</strong>
                    <code>∫ cos(x) dx = sin(x) + C</code>
                </div>
                <div class="rule-card">
                    <strong>e^x</strong>
                    <code>∫ e^x dx = e^x + C</code>
                </div>
                <div class="rule-card">
                    <strong>1/x</strong>
                    <code>∫ 1/x dx = ln|x| + C</code>
                </div>
            </div>
            
            <div class="formula-box">
                <strong>Fundamental Theorem of Calculus:</strong>
                ∫[a to b] f(x) dx = F(b) - F(a)<br>
                where F'(x) = f(x)
            </div>
        </div>
    </div>

    <script>
        document.getElementById('exp_type').addEventListener('change', function() {
            document.getElementById('base_section').style.display = 
                this.value === 'ax' ? 'block' : 'none';
        });
        
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
        
        function setPower(a,n) {
            document.getElementById('pow_a').value = a;
            document.getElementById('pow_n').value = n;
        }
        
        function formatTerm(coef, power) {
            if(power === 0) return coef.toString();
            if(power === 1) return coef === 1 ? 'x' : `${coef}x`;
            return coef === 1 ? `x^${power}` : `${coef}x^${power}`;
        }
        
        function calcPower() {
            const a = parseFloat(document.getElementById('pow_a').value);
            const n = parseFloat(document.getElementById('pow_n').value);
            
            if(isNaN(a) || isNaN(n)) {
                return alert('⚠️ Please enter valid numbers');
            }
            
            if(n === -1) {
                return alert('⚠️ Use n ≠ -1 (for 1/x, use Exponential tab)');
            }
            
            const newPower = n + 1;
            const newCoef = a / newPower;
            
            const original = n === 0 ? (a === 1 ? '1' : a.toString()) : formatTerm(a, n);
            const result = formatTerm(newCoef, newPower);
            
            let html = `<div class="result-box">
                <div class="result-label">Original Function</div>
                <div class="result-value">f(x) = ${original}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Integral (Antiderivative)</div>
                <div class="result-value" style="color:#2196F3;">∫ ${original} dx = ${result} + C</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Solution Steps:</strong>
                <div class="step">Step 1: Apply power rule ∫ x^n dx = x^(n+1)/(n+1)</div>
                <div class="step">Step 2: ∫ ${original} dx = ${a}x^(${n}+1)/(${n}+1)</div>
                <div class="step">Step 3: = ${a}x^${newPower}/${newPower}</div>
                <div class="step">Step 4: = ${result} + C</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Rule Used:</strong>
                Power Rule: ∫ ax^n dx = a·x^(n+1)/(n+1) + C
            </div>`;
            
            show(html);
        }
        
        function calcTrig() {
            const type = document.getElementById('trig_type').value;
            
            const integrals = {
                'sin': {
                    func: 'sin(x)',
                    result: '-cos(x)',
                    rule: '∫ sin(x) dx = -cos(x) + C'
                },
                'cos': {
                    func: 'cos(x)',
                    result: 'sin(x)',
                    rule: '∫ cos(x) dx = sin(x) + C'
                },
                'sec2': {
                    func: 'sec²(x)',
                    result: 'tan(x)',
                    rule: '∫ sec²(x) dx = tan(x) + C'
                },
                'csc2': {
                    func: 'csc²(x)',
                    result: '-cot(x)',
                    rule: '∫ csc²(x) dx = -cot(x) + C'
                },
                'sectan': {
                    func: 'sec(x)tan(x)',
                    result: 'sec(x)',
                    rule: '∫ sec(x)tan(x) dx = sec(x) + C'
                },
                'csccot': {
                    func: 'csc(x)cot(x)',
                    result: '-csc(x)',
                    rule: '∫ csc(x)cot(x) dx = -csc(x) + C'
                }
            };
            
            const i = integrals[type];
            
            let html = `<div class="result-box">
                <div class="result-label">Function</div>
                <div class="result-value">f(x) = ${i.func}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Integral</div>
                <div class="result-value" style="color:#2196F3;">∫ ${i.func} dx = ${i.result} + C</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula:</strong>
                ${i.rule}
            </div>`;
            
            show(html);
        }
        
        function calcExp() {
            const type = document.getElementById('exp_type').value;
            let func, result, rule;
            
            if(type === 'ex') {
                func = 'e^x';
                result = 'e^x';
                rule = '∫ e^x dx = e^x + C';
            } else if(type === 'ax') {
                const base = parseFloat(document.getElementById('exp_base').value);
                if(isNaN(base)) return alert('⚠️ Enter valid base');
                func = `${base}^x`;
                result = `${base}^x / ln(${base})`;
                rule = `∫ a^x dx = a^x / ln(a) + C`;
            } else {
                func = '1/x';
                result = 'ln|x|';
                rule = '∫ 1/x dx = ln|x| + C';
            }
            
            let html = `<div class="result-box">
                <div class="result-label">Function</div>
                <div class="result-value">f(x) = ${func}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Integral</div>
                <div class="result-value" style="color:#2196F3;">∫ ${func} dx = ${result} + C</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula:</strong>
                ${rule}
            </div>`;
            
            show(html);
        }
        
        function calcDefinite() {
            const a = parseFloat(document.getElementById('def_a').value);
            const n = parseFloat(document.getElementById('def_n').value);
            const lower = parseFloat(document.getElementById('def_lower').value);
            const upper = parseFloat(document.getElementById('def_upper').value);
            
            if(isNaN(a)||isNaN(n)||isNaN(lower)||isNaN(upper)) {
                return alert('⚠️ Please enter valid numbers');
            }
            
            if(n === -1) {
                return alert('⚠️ n cannot be -1 for power rule');
            }
            
            // Calculate antiderivative coefficient
            const newPower = n + 1;
            const antiderivCoef = a / newPower;
            
            // Evaluate at bounds
            const upperVal = antiderivCoef * Math.pow(upper, newPower);
            const lowerVal = antiderivCoef * Math.pow(lower, newPower);
            const result = upperVal - lowerVal;
            
            const funcStr = formatTerm(a, n);
            const antiderivStr = formatTerm(antiderivCoef, newPower);
            
            let html = `<div class="result-box">
                <div class="result-label">Definite Integral</div>
                <div class="result-value">∫[${lower} to ${upper}] ${funcStr} dx</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Result</div>
                <div class="result-value" style="color:#2196F3;">${result.toFixed(6)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Solution Steps:</strong>
                <div class="step">Step 1: Find antiderivative F(x) = ${antiderivStr}</div>
                <div class="step">Step 2: Evaluate F(${upper}) = ${upperVal.toFixed(6)}</div>
                <div class="step">Step 3: Evaluate F(${lower}) = ${lowerVal.toFixed(6)}</div>
                <div class="step">Step 4: F(${upper}) - F(${lower}) = ${result.toFixed(6)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e3f2fd;border-left-color:#2196F3;">
                <strong style="color:#1976d2;">Fundamental Theorem:</strong>
                ∫[a to b] f(x) dx = F(b) - F(a)
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>