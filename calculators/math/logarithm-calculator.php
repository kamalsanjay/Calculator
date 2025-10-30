<?php
/**
 * Logarithm Calculator
 * File: logarithm-calculator.php
 * Description: Calculate logarithms with various bases and methods
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logarithm Calculator - All Functions & Methods</title>
    <meta name="description" content="Calculate logarithms with various bases, natural logs, common logs, and custom bases with step-by-step solutions.">
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh; 
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        header { 
            background: rgba(255,255,255,0.1); 
            color: white; 
            padding: 25px 20px; 
            text-align: center; 
            border-radius: 15px; 
            margin-bottom: 20px; 
            backdrop-filter: blur(10px); 
        }
        
        header h1 { 
            font-size: 2rem; 
            margin-bottom: 10px; 
            font-weight: 700; 
        }
        
        header p { 
            font-size: 1rem; 
            opacity: 0.9; 
        }
        
        .calculator-body { 
            background: white; 
            padding: 25px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
            margin-bottom: 20px; 
        }
        
        .calc-tabs { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); 
            gap: 10px; 
            margin-bottom: 20px; 
        }
        
        .tab-btn { 
            padding: 12px 10px; 
            background: #f0f0f0; 
            border: none; 
            border-radius: 8px; 
            color: #333; 
            cursor: pointer; 
            transition: all 0.3s; 
            font-weight: 600; 
            text-align: center; 
            font-size: 0.9rem; 
        }
        
        .tab-btn.active { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            transform: translateY(-2px); 
            box-shadow: 0 4px 8px rgba(0,0,0,0.15); 
        }
        
        .tab-content { 
            display: none; 
        }
        
        .tab-content.active { 
            display: block; 
            animation: fadeIn 0.3s; 
        }
        
        @keyframes fadeIn { 
            from { opacity: 0; transform: translateY(10px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        
        .input-section { 
            margin-bottom: 20px; 
        }
        
        .input-section label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            color: #333; 
            font-size: 1rem; 
        }
        
        .input-section input, .input-section select { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #e0e0e0; 
            border-radius: 8px; 
            font-size: 1rem; 
            outline: none; 
            transition: all 0.3s; 
            font-family: 'Courier New', monospace; 
        }
        
        .input-section input:focus, .input-section select:focus { 
            border-color: #667eea; 
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); 
        }
        
        .input-hint { 
            font-size: 0.85rem; 
            color: #666; 
            margin-top: 6px; 
            font-style: italic; 
        }
        
        .input-group {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 15px;
            align-items: end;
            margin-bottom: 15px;
        }
        
        .log-expression {
            text-align: center;
            font-family: 'Courier New', monospace;
            font-size: 1.2rem;
            margin: 15px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }
        
        .operator-select { 
            background: #e3f2fd;
            border: 2px solid #2196F3;
            border-radius: 8px;
            padding: 12px;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            outline: none;
            min-width: 60px;
        }
        
        .btn { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            border: none; 
            padding: 14px 24px; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: 600; 
            width: 100%; 
            font-size: 1.1rem; 
            transition: all 0.3s; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.15); 
            margin-top: 10px;
        }
        
        .btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 4px 12px rgba(0,0,0,0.2); 
        }
        
        .btn:active { 
            transform: translateY(0); 
        }
        
        .examples { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
            gap: 10px; 
            margin: 20px 0; 
        }
        
        .example-btn { 
            padding: 10px; 
            background: #f0f0f0; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            cursor: pointer; 
            text-align: center; 
            font-size: 0.9rem; 
            transition: all 0.3s; 
            font-family: 'Courier New', monospace;
        }
        
        .example-btn:hover { 
            background: #667eea; 
            color: white; 
            transform: translateY(-2px); 
        }
        
        .result-section { 
            background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); 
            padding: 25px; 
            border-radius: 12px; 
            border-left: 5px solid #667eea; 
            margin-top: 25px; 
            display: none; 
        }
        
        .result-section.show { 
            display: block; 
            animation: slideIn 0.3s; 
        }
        
        @keyframes slideIn { 
            from { opacity: 0; transform: translateY(20px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        
        .result-section h3 { 
            color: #667eea; 
            margin-bottom: 20px; 
            font-size: 1.5rem; 
        }
        
        .result-box { 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
            margin-bottom: 15px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
            border-left: 4px solid #4CAF50; 
        }
        
        .result-label { 
            font-size: 0.9rem; 
            color: #666; 
            margin-bottom: 8px; 
            font-weight: 600; 
            text-transform: uppercase; 
        }
        
        .result-value { 
            font-size: 1.5rem; 
            color: #4CAF50; 
            font-weight: bold; 
            font-family: 'Courier New', monospace; 
            word-break: break-word; 
            line-height: 1.5; 
            text-align: center;
        }
        
        .formula-box { 
            background: #f9f9f9; 
            padding: 16px; 
            border-radius: 8px; 
            border-left: 4px solid #667eea; 
            margin: 16px 0; 
            font-size: 0.9rem; 
            line-height: 1.7; 
        }
        
        .formula-box strong { 
            color: #667eea; 
            display: block; 
            margin-bottom: 8px; 
        }
        
        .step-box { 
            background: #fff3cd; 
            padding: 16px; 
            border-radius: 8px; 
            border-left: 4px solid #ffc107; 
            margin: 16px 0; 
        }
        
        .step-box strong { 
            color: #f57c00; 
            display: block; 
            margin-bottom: 10px; 
        }
        
        .step { 
            padding: 8px 0; 
            border-bottom: 1px solid #ffe082; 
            font-family: 'Courier New', monospace; 
            font-size: 0.95rem; 
        }
        
        .step:last-child { 
            border-bottom: none; 
        }
        
        .info-box { 
            background: white; 
            padding: 25px; 
            border-radius: 12px; 
            line-height: 1.8; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.15); 
            margin-top: 20px; 
        }
        
        .info-box h3 { 
            color: #667eea; 
            margin-bottom: 16px; 
            font-size: 1.3rem; 
        }
        
        .rule-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 15px; 
            margin: 20px 0; 
        }
        
        .rule-card { 
            background: #f5f5f5; 
            padding: 15px; 
            border-radius: 8px; 
            border-left: 3px solid #667eea; 
        }
        
        .rule-card strong { 
            color: #667eea; 
            display: block; 
            margin-bottom: 6px; 
            font-size: 0.95rem; 
        }
        
        .rule-card code { 
            font-family: 'Courier New', monospace; 
            font-size: 0.85rem; 
            color: #333; 
            display: block; 
        }
        
        @media (max-width: 600px) {
            .examples { 
                grid-template-columns: 1fr; 
            }
            .result-value { 
                font-size: 1.2rem; 
            }
            .input-group {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .operator-select {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📊 Logarithm Calculator</h1>
            <p>Calculate logs with various bases, methods, and functions</p>
        </header>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Basic Log</button>
                <button class="tab-btn" onclick="switchTab(1)">Natural Log</button>
                <button class="tab-btn" onclick="switchTab(2)">Common Log</button>
                <button class="tab-btn" onclick="switchTab(3)">Custom Base</button>
                <button class="tab-btn" onclick="switchTab(4)">Log Properties</button>
            </div>

            <!-- Tab 1: Basic Logarithm -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 15px;">🔢 Basic Logarithm</h3>
                
                <div class="log-expression" id="basicLogPreview">log₂(8) = ?</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <div>
                            <label>Base</label>
                            <input type="number" id="basic_base" value="2" step="any" min="0.001" oninput="updateBasicLogPreview()">
                        </div>
                        <div style="text-align: center;">
                            <label>log</label>
                            <div style="font-size: 1.5rem; font-weight: bold;">ₓ</div>
                        </div>
                        <div>
                            <label>Number</label>
                            <input type="number" id="basic_number" value="8" step="any" min="0.001" oninput="updateBasicLogPreview()">
                        </div>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateBasicLog()">Calculate Logarithm</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="setBasicLog(2,8)">log₂(8)</button>
                    <button class="example-btn" onclick="setBasicLog(10,100)">log₁₀(100)</button>
                    <button class="example-btn" onclick="setBasicLog(3,27)">log₃(27)</button>
                    <button class="example-btn" onclick="setBasicLog(5,125)">log₅(125)</button>
                </div>
            </div>

            <!-- Tab 2: Natural Logarithm -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">🌿 Natural Logarithm (ln)</h3>
                
                <div class="log-expression" id="naturalLogPreview">ln(e) = ?</div>
                
                <div class="input-section">
                    <label>Number (x > 0)</label>
                    <input type="number" id="natural_number" value="2.71828" step="any" min="0.001" oninput="updateNaturalLogPreview()">
                    <div class="input-hint">Natural log uses base e ≈ 2.71828</div>
                </div>
                
                <button class="btn" onclick="calculateNaturalLog()">Calculate Natural Log</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="setNaturalLog(2.71828)">ln(e)</button>
                    <button class="example-btn" onclick="setNaturalLog(1)">ln(1)</button>
                    <button class="example-btn" onclick="setNaturalLog(10)">ln(10)</button>
                    <button class="example-btn" onclick="setNaturalLog(100)">ln(100)</button>
                </div>
            </div>

            <!-- Tab 3: Common Logarithm -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">🔟 Common Logarithm (log₁₀)</h3>
                
                <div class="log-expression" id="commonLogPreview">log₁₀(100) = ?</div>
                
                <div class="input-section">
                    <label>Number (x > 0)</label>
                    <input type="number" id="common_number" value="100" step="any" min="0.001" oninput="updateCommonLogPreview()">
                    <div class="input-hint">Common log uses base 10</div>
                </div>
                
                <button class="btn" onclick="calculateCommonLog()">Calculate Common Log</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="setCommonLog(100)">log₁₀(100)</button>
                    <button class="example-btn" onclick="setCommonLog(1000)">log₁₀(1000)</button>
                    <button class="example-btn" onclick="setCommonLog(0.1)">log₁₀(0.1)</button>
                    <button class="example-btn" onclick="setCommonLog(50)">log₁₀(50)</button>
                </div>
            </div>

            <!-- Tab 4: Custom Base -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">🎯 Custom Base Logarithm</h3>
                
                <div class="log-expression" id="customLogPreview">log₄(64) = ?</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <div>
                            <label>From Base</label>
                            <input type="number" id="from_base" value="4" step="any" min="0.001" oninput="updateCustomLogPreview()">
                        </div>
                        <div style="text-align: center;">
                            <label>Convert</label>
                            <div style="font-size: 1.2rem; font-weight: bold;">→</div>
                        </div>
                        <div>
                            <label>To Base</label>
                            <input type="number" id="to_base" value="2" step="any" min="0.001" oninput="updateCustomLogPreview()">
                        </div>
                    </div>
                    
                    <div style="margin-top: 15px;">
                        <label>Number</label>
                        <input type="number" id="custom_number" value="64" step="any" min="0.001" oninput="updateCustomLogPreview()">
                    </div>
                </div>
                
                <button class="btn" onclick="calculateCustomLog()">Convert Base</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="setCustomLog(4,2,64)">log₄(64)→log₂</button>
                    <button class="example-btn" onclick="setCustomLog(8,2,64)">log₈(64)→log₂</button>
                    <button class="example-btn" onclick="setCustomLog(16,4,256)">log₁₆(256)→log₄</button>
                    <button class="example-btn" onclick="setCustomLog(27,3,81)">log₂₇(81)→log₃</button>
                </div>
            </div>

            <!-- Tab 5: Log Properties -->
            <div id="tab4" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">⚡ Logarithm Properties</h3>
                
                <div class="input-section">
                    <label>Select Property</label>
                    <select id="log_property" onchange="updatePropertyPreview()">
                        <option value="product">Product Rule: logₐ(mn)</option>
                        <option value="quotient">Quotient Rule: logₐ(m/n)</option>
                        <option value="power">Power Rule: logₐ(mⁿ)</option>
                        <option value="change_base">Change of Base</option>
                    </select>
                </div>
                
                <div class="log-expression" id="propertyPreview">logₐ(m × n) = logₐ(m) + logₐ(n)</div>
                
                <div class="input-section" id="propertyInputs">
                    <div class="input-group">
                        <div>
                            <label>Base (a)</label>
                            <input type="number" id="prop_base" value="2" step="any" min="0.001">
                        </div>
                        <div>
                            <label>m</label>
                            <input type="number" id="prop_m" value="4" step="any" min="0.001">
                        </div>
                        <div>
                            <label>n</label>
                            <input type="number" id="prop_n" value="8" step="any" min="0.001">
                        </div>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateProperty()">Apply Property</button>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Solution</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Logarithm Rules & Properties</h3>
            <div class="rule-grid">
                <div class="rule-card">
                    <strong>Basic Definition</strong>
                    <code>logₐ(b) = c ⇔ aᶜ = b</code>
                </div>
                <div class="rule-card">
                    <strong>Product Rule</strong>
                    <code>logₐ(mn) = logₐ(m) + logₐ(n)</code>
                </div>
                <div class="rule-card">
                    <strong>Quotient Rule</strong>
                    <code>logₐ(m/n) = logₐ(m) - logₐ(n)</code>
                </div>
                <div class="rule-card">
                    <strong>Power Rule</strong>
                    <code>logₐ(mⁿ) = n × logₐ(m)</code>
                </div>
                <div class="rule-card">
                    <strong>Change of Base</strong>
                    <code>logₐ(b) = logₓ(b) / logₓ(a)</code>
                </div>
                <div class="rule-card">
                    <strong>Natural Log</strong>
                    <code>ln(x) = logₑ(x)</code>
                </div>
                <div class="rule-card">
                    <strong>Common Log</strong>
                    <code>log(x) = log₁₀(x)</code>
                </div>
                <div class="rule-card">
                    <strong>Identity Rules</strong>
                    <code>logₐ(a) = 1<br>logₐ(1) = 0</code>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize previews on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateBasicLogPreview();
            updateNaturalLogPreview();
            updateCommonLogPreview();
            updateCustomLogPreview();
            updatePropertyPreview();
        });

        function switchTab(i) {
            document.querySelectorAll('.tab-btn').forEach((btn, index) => {
                btn.classList.toggle('active', index === i);
            });
            
            document.querySelectorAll('.tab-content').forEach((content, index) => {
                content.classList.toggle('active', index === i);
            });
            
            document.getElementById('result').classList.remove('show');
        }
        
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
            document.getElementById('result').scrollIntoView({behavior: 'smooth', block: 'nearest'});
        }
        
        // Preview updaters
        function updateBasicLogPreview() {
            const base = document.getElementById('basic_base').value || 'x';
            const number = document.getElementById('basic_number').value || 'n';
            document.getElementById('basicLogPreview').textContent = `log${getSubscript(base)}(${number}) = ?`;
        }
        
        function updateNaturalLogPreview() {
            const number = document.getElementById('natural_number').value || 'x';
            document.getElementById('naturalLogPreview').textContent = `ln(${number}) = ?`;
        }
        
        function updateCommonLogPreview() {
            const number = document.getElementById('common_number').value || 'x';
            document.getElementById('commonLogPreview').textContent = `log₁₀(${number}) = ?`;
        }
        
        function updateCustomLogPreview() {
            const fromBase = document.getElementById('from_base').value || 'a';
            const toBase = document.getElementById('to_base').value || 'b';
            const number = document.getElementById('custom_number').value || 'x';
            document.getElementById('customLogPreview').textContent = `log${getSubscript(fromBase)}(${number}) → log${getSubscript(toBase)} = ?`;
        }
        
        function updatePropertyPreview() {
            const property = document.getElementById('log_property').value;
            let expression = '';
            
            switch(property) {
                case 'product':
                    expression = 'logₐ(m × n) = logₐ(m) + logₐ(n)';
                    break;
                case 'quotient':
                    expression = 'logₐ(m ÷ n) = logₐ(m) - logₐ(n)';
                    break;
                case 'power':
                    expression = 'logₐ(mⁿ) = n × logₐ(m)';
                    break;
                case 'change_base':
                    expression = 'logₐ(b) = logₓ(b) ÷ logₓ(a)';
                    break;
            }
            
            document.getElementById('propertyPreview').textContent = expression;
        }
        
        function getSubscript(num) {
            const subscripts = {'0':'₀','1':'₁','2':'₂','3':'₃','4':'₄','5':'₅','6':'₆','7':'₇','8':'₈','9':'₉'};
            return num.toString().split('').map(char => subscripts[char] || char).join('');
        }
        
        // Example setters
        function setBasicLog(base, number) {
            document.getElementById('basic_base').value = base;
            document.getElementById('basic_number').value = number;
            updateBasicLogPreview();
        }
        
        function setNaturalLog(number) {
            document.getElementById('natural_number').value = number;
            updateNaturalLogPreview();
        }
        
        function setCommonLog(number) {
            document.getElementById('common_number').value = number;
            updateCommonLogPreview();
        }
        
        function setCustomLog(fromBase, toBase, number) {
            document.getElementById('from_base').value = fromBase;
            document.getElementById('to_base').value = toBase;
            document.getElementById('custom_number').value = number;
            updateCustomLogPreview();
        }
        
        // Calculation functions
        function calculateBasicLog() {
            const base = parseFloat(document.getElementById('basic_base').value);
            const number = parseFloat(document.getElementById('basic_number').value);
            
            if (isNaN(base) || isNaN(number) || base <= 0 || number <= 0 || base === 1) {
                alert('⚠️ Please enter valid numbers (base > 0, base ≠ 1, number > 0)');
                return;
            }
            
            const result = Math.log(number) / Math.log(base);
            const verification = Math.pow(base, result);
            
            let html = `<div class="result-box">
                <div class="result-label">Logarithm Expression</div>
                <div class="result-value">log${getSubscript(base)}(${number})</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Solution</div>
                <div class="result-value" style="color:#2196F3;">${result.toFixed(6)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Step-by-Step Solution:</strong>
                <div class="step">Step 1: Use change of base formula: log${getSubscript(base)}(${number}) = ln(${number}) ÷ ln(${base})</div>
                <div class="step">Step 2: Calculate ln(${number}) = ${Math.log(number).toFixed(6)}</div>
                <div class="step">Step 3: Calculate ln(${base}) = ${Math.log(base).toFixed(6)}</div>
                <div class="step">Step 4: Divide: ${Math.log(number).toFixed(6)} ÷ ${Math.log(base).toFixed(6)} = ${result.toFixed(6)}</div>
                <div class="step">Step 5: Verify: ${base}^${result.toFixed(6)} ≈ ${verification.toFixed(6)} ≈ ${number}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula Used:</strong>
                logₐ(b) = ln(b) ÷ ln(a)
            </div>`;
            
            show(html);
        }
        
        function calculateNaturalLog() {
            const number = parseFloat(document.getElementById('natural_number').value);
            
            if (isNaN(number) || number <= 0) {
                alert('⚠️ Please enter a valid number (x > 0)');
                return;
            }
            
            const result = Math.log(number);
            const verification = Math.exp(result);
            
            let html = `<div class="result-box">
                <div class="result-label">Natural Logarithm</div>
                <div class="result-value">ln(${number})</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Solution</div>
                <div class="result-value" style="color:#2196F3;">${result.toFixed(6)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Step-by-Step Solution:</strong>
                <div class="step">Step 1: Natural log is base e (e ≈ 2.71828)</div>
                <div class="step">Step 2: ln(${number}) = power to which e must be raised to get ${number}</div>
                <div class="step">Step 3: Direct calculation using natural log function</div>
                <div class="step">Step 4: Result: ${result.toFixed(6)}</div>
                <div class="step">Step 5: Verify: e^${result.toFixed(6)} ≈ ${verification.toFixed(6)} ≈ ${number}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Special Values:</strong>
                ln(1) = 0, ln(e) = 1, ln(eⁿ) = n
            </div>`;
            
            show(html);
        }
        
        function calculateCommonLog() {
            const number = parseFloat(document.getElementById('common_number').value);
            
            if (isNaN(number) || number <= 0) {
                alert('⚠️ Please enter a valid number (x > 0)');
                return;
            }
            
            const result = Math.log10(number);
            const verification = Math.pow(10, result);
            
            let html = `<div class="result-box">
                <div class="result-label">Common Logarithm</div>
                <div class="result-value">log₁₀(${number})</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Solution</div>
                <div class="result-value" style="color:#2196F3;">${result.toFixed(6)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Step-by-Step Solution:</strong>
                <div class="step">Step 1: Common log is base 10</div>
                <div class="step">Step 2: log₁₀(${number}) = power to which 10 must be raised to get ${number}</div>
                <div class="step">Step 3: Direct calculation using base-10 log function</div>
                <div class="step">Step 4: Result: ${result.toFixed(6)}</div>
                <div class="step">Step 5: Verify: 10^${result.toFixed(6)} ≈ ${verification.toFixed(6)} ≈ ${number}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Special Values:</strong>
                log₁₀(1) = 0, log₁₀(10) = 1, log₁₀(10ⁿ) = n
            </div>`;
            
            show(html);
        }
        
        function calculateCustomLog() {
            const fromBase = parseFloat(document.getElementById('from_base').value);
            const toBase = parseFloat(document.getElementById('to_base').value);
            const number = parseFloat(document.getElementById('custom_number').value);
            
            if (isNaN(fromBase) || isNaN(toBase) || isNaN(number) || fromBase <= 0 || toBase <= 0 || number <= 0 || fromBase === 1 || toBase === 1) {
                alert('⚠️ Please enter valid numbers (bases > 0, bases ≠ 1, number > 0)');
                return;
            }
            
            const originalLog = Math.log(number) / Math.log(fromBase);
            const convertedLog = Math.log(number) / Math.log(toBase);
            const verification = Math.pow(toBase, convertedLog);
            
            let html = `<div class="result-box">
                <div class="result-label">Original Logarithm</div>
                <div class="result-value">log${getSubscript(fromBase)}(${number}) = ${originalLog.toFixed(6)}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Converted Logarithm</div>
                <div class="result-value" style="color:#2196F3;">log${getSubscript(toBase)}(${number}) = ${convertedLog.toFixed(6)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Step-by-Step Conversion:</strong>
                <div class="step">Step 1: Change of base formula: log${getSubscript(toBase)}(${number}) = log${getSubscript(fromBase)}(${number}) ÷ log${getSubscript(fromBase)}(${toBase})</div>
                <div class="step">Step 2: Calculate log${getSubscript(fromBase)}(${number}) = ${originalLog.toFixed(6)}</div>
                <div class="step">Step 3: Calculate log${getSubscript(fromBase)}(${toBase}) = ${(Math.log(toBase) / Math.log(fromBase)).toFixed(6)}</div>
                <div class="step">Step 4: Divide: ${originalLog.toFixed(6)} ÷ ${(Math.log(toBase) / Math.log(fromBase)).toFixed(6)} = ${convertedLog.toFixed(6)}</div>
                <div class="step">Step 5: Verify: ${toBase}^${convertedLog.toFixed(6)} ≈ ${verification.toFixed(6)} ≈ ${number}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Change of Base Formula:</strong>
                logₐ(b) = logₓ(b) ÷ logₓ(a)
            </div>`;
            
            show(html);
        }
        
        function calculateProperty() {
            const property = document.getElementById('log_property').value;
            const base = parseFloat(document.getElementById('prop_base').value);
            const m = parseFloat(document.getElementById('prop_m').value);
            const n = parseFloat(document.getElementById('prop_n').value);
            
            if (isNaN(base) || isNaN(m) || (property !== 'power' && isNaN(n)) || base <= 0 || base === 1 || m <= 0 || (property !== 'power' && n <= 0)) {
                alert('⚠️ Please enter valid numbers (base > 0, base ≠ 1, m > 0, n > 0)');
                return;
            }
            
            let leftSide, rightSide, steps, formula;
            
            switch(property) {
                case 'product':
                    leftSide = Math.log(m * n) / Math.log(base);
                    rightSide = (Math.log(m) / Math.log(base)) + (Math.log(n) / Math.log(base));
                    steps = [
                        `Step 1: Calculate left side: log${getSubscript(base)}(${m} × ${n}) = log${getSubscript(base)}(${m*n}) = ${leftSide.toFixed(6)}`,
                        `Step 2: Calculate right side: log${getSubscript(base)}(${m}) + log${getSubscript(base)}(${n})`,
                        `Step 3: log${getSubscript(base)}(${m}) = ${(Math.log(m) / Math.log(base)).toFixed(6)}`,
                        `Step 4: log${getSubscript(base)}(${n}) = ${(Math.log(n) / Math.log(base)).toFixed(6)}`,
                        `Step 5: Sum: ${(Math.log(m) / Math.log(base)).toFixed(6)} + ${(Math.log(n) / Math.log(base)).toFixed(6)} = ${rightSide.toFixed(6)}`,
                        `Step 6: Verification: ${leftSide.toFixed(6)} ≈ ${rightSide.toFixed(6)}`
                    ];
                    formula = `Product Rule: logₐ(mn) = logₐ(m) + logₐ(n)`;
                    break;
                    
                case 'quotient':
                    leftSide = Math.log(m / n) / Math.log(base);
                    rightSide = (Math.log(m) / Math.log(base)) - (Math.log(n) / Math.log(base));
                    steps = [
                        `Step 1: Calculate left side: log${getSubscript(base)}(${m} ÷ ${n}) = log${getSubscript(base)}(${(m/n).toFixed(6)}) = ${leftSide.toFixed(6)}`,
                        `Step 2: Calculate right side: log${getSubscript(base)}(${m}) - log${getSubscript(base)}(${n})`,
                        `Step 3: log${getSubscript(base)}(${m}) = ${(Math.log(m) / Math.log(base)).toFixed(6)}`,
                        `Step 4: log${getSubscript(base)}(${n}) = ${(Math.log(n) / Math.log(base)).toFixed(6)}`,
                        `Step 5: Difference: ${(Math.log(m) / Math.log(base)).toFixed(6)} - ${(Math.log(n) / Math.log(base)).toFixed(6)} = ${rightSide.toFixed(6)}`,
                        `Step 6: Verification: ${leftSide.toFixed(6)} ≈ ${rightSide.toFixed(6)}`
                    ];
                    formula = `Quotient Rule: logₐ(m/n) = logₐ(m) - logₐ(n)`;
                    break;
                    
                case 'power':
                    leftSide = Math.log(Math.pow(m, n)) / Math.log(base);
                    rightSide = n * (Math.log(m) / Math.log(base));
                    steps = [
                        `Step 1: Calculate left side: log${getSubscript(base)}(${m}^${n}) = log${getSubscript(base)}(${Math.pow(m, n).toFixed(6)}) = ${leftSide.toFixed(6)}`,
                        `Step 2: Calculate right side: ${n} × log${getSubscript(base)}(${m})`,
                        `Step 3: log${getSubscript(base)}(${m}) = ${(Math.log(m) / Math.log(base)).toFixed(6)}`,
                        `Step 4: Multiply: ${n} × ${(Math.log(m) / Math.log(base)).toFixed(6)} = ${rightSide.toFixed(6)}`,
                        `Step 5: Verification: ${leftSide.toFixed(6)} ≈ ${rightSide.toFixed(6)}`
                    ];
                    formula = `Power Rule: logₐ(mⁿ) = n × logₐ(m)`;
                    break;
                    
                case 'change_base':
                    const newBase = n; // Using n as the new base for change of base
                    leftSide = Math.log(m) / Math.log(base);
                    rightSide = (Math.log(m) / Math.log(newBase)) / (Math.log(base) / Math.log(newBase));
                    steps = [
                        `Step 1: Original: log${getSubscript(base)}(${m}) = ${leftSide.toFixed(6)}`,
                        `Step 2: Change to base ${newBase}: log${getSubscript(newBase)}(${m}) ÷ log${getSubscript(newBase)}(${base})`,
                        `Step 3: log${getSubscript(newBase)}(${m}) = ${(Math.log(m) / Math.log(newBase)).toFixed(6)}`,
                        `Step 4: log${getSubscript(newBase)}(${base}) = ${(Math.log(base) / Math.log(newBase)).toFixed(6)}`,
                        `Step 5: Divide: ${(Math.log(m) / Math.log(newBase)).toFixed(6)} ÷ ${(Math.log(base) / Math.log(newBase)).toFixed(6)} = ${rightSide.toFixed(6)}`,
                        `Step 6: Verification: ${leftSide.toFixed(6)} ≈ ${rightSide.toFixed(6)}`
                    ];
                    formula = `Change of Base: logₐ(b) = logₓ(b) ÷ logₓ(a)`;
                    break;
            }
            
            let html = `<div class="result-box">
                <div class="result-label">Logarithm Property</div>
                <div class="result-value">${formula.split(':')[0]}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Verification</div>
                <div class="result-value" style="color:#2196F3; font-size: 1.2rem;">Left Side ≈ Right Side<br>${leftSide.toFixed(6)} ≈ ${rightSide.toFixed(6)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Step-by-Step Verification:</strong>
                ${steps.map(step => `<div class="step">${step}</div>`).join('')}
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Property Formula:</strong>
                ${formula}
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>