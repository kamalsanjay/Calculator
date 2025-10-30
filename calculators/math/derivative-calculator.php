<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Derivative Calculator - Fixed Version</title>
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
            max-width: 800px;
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
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); 
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
        }
        
        .input-section input { 
            font-family: 'Courier New', monospace; 
        }
        
        .input-section input:focus { 
            border-color: #667eea; 
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); 
        }
        
        .input-hint { 
            font-size: 0.85rem; 
            color: #666; 
            margin-top: 6px; 
            font-style: italic; 
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
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); 
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
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
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
                grid-template-columns: repeat(2, 1fr); 
            }
            .result-value { 
                font-size: 1.2rem; 
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📐 Derivative Calculator</h1>
            <p>Calculate derivatives with step-by-step solutions</p>
        </header>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Power Rule</button>
                <button class="tab-btn" onclick="switchTab(1)">Polynomial</button>
                <button class="tab-btn" onclick="switchTab(2)">Trigonometric</button>
                <button class="tab-btn" onclick="switchTab(3)">Exponential</button>
            </div>

            <!-- Tab 1: Power Rule -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 15px;">📊 Power Rule Derivatives</h3>
                <div class="input-section">
                    <label>Enter Function</label>
                    <input type="text" id="func" value="x^2" placeholder="e.g., x^2, 3*x^2, x^3">
                    <div class="input-hint">Format: x^n (e.g., x^2, x^3, 5*x^4)</div>
                </div>
                <button class="btn" onclick="calculate()">Calculate Derivative</button>
                <div class="examples">
                    <button class="example-btn" onclick="setFunc('x^2')">x²</button>
                    <button class="example-btn" onclick="setFunc('x^3')">x³</button>
                    <button class="example-btn" onclick="setFunc('3*x^2')">3x²</button>
                    <button class="example-btn" onclick="setFunc('5*x^4')">5x⁴</button>
                    <button class="example-btn" onclick="setFunc('x')">x</button>
                    <button class="example-btn" onclick="setFunc('7')">7</button>
                </div>
            </div>

            <!-- Tab 2: Polynomial -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">📈 Polynomial Derivatives</h3>
                <div class="input-section">
                    <label>Enter Polynomial</label>
                    <input type="text" id="poly" value="x^3 + 2*x^2 - 5*x + 1" placeholder="e.g., x^3 + 2*x^2 - 5*x + 1">
                    <div class="input-hint">Use +, -, * operators</div>
                </div>
                <button class="btn" onclick="calculatePoly()">Calculate Derivative</button>
                <div class="examples">
                    <button class="example-btn" onclick="setPoly('x^2 + 3*x')">x² + 3x</button>
                    <button class="example-btn" onclick="setPoly('x^3 - x')">x³ - x</button>
                    <button class="example-btn" onclick="setPoly('2*x^4 + x^2 - 7')">2x⁴+x²-7</button>
                </div>
            </div>

            <!-- Tab 3: Trigonometric -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">📐 Trigonometric Derivatives</h3>
                <div class="input-section">
                    <label>Enter Trigonometric Function</label>
                    <input type="text" id="trigInput" value="sin(x)" placeholder="e.g., sin(x), cos(2*x), tan(x/2)">
                    <div class="input-hint">Format: sin(expr), cos(expr), tan(expr), etc.</div>
                </div>
                <button class="btn" onclick="calculateTrig()">Calculate Derivative</button>
                <div class="examples">
                    <button class="example-btn" onclick="setTrig('sin(x)')">sin(x)</button>
                    <button class="example-btn" onclick="setTrig('cos(x)')">cos(x)</button>
                    <button class="example-btn" onclick="setTrig('tan(x)')">tan(x)</button>
                    <button class="example-btn" onclick="setTrig('sin(2*x)')">sin(2x)</button>
                    <button class="example-btn" onclick="setTrig('cos(x^2)')">cos(x²)</button>
                    <button class="example-btn" onclick="setTrig('tan(3*x+1)')">tan(3x+1)</button>
                </div>
            </div>

            <!-- Tab 4: Exponential -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">📊 Exponential & Log Derivatives</h3>
                <div class="input-section">
                    <label>Enter Exponential/Log Function</label>
                    <input type="text" id="expInput" value="e^x" placeholder="e.g., e^x, 2^x, ln(x), log(x)">
                    <div class="input-hint">Format: e^expr, a^expr, ln(expr), log(expr)</div>
                </div>
                <button class="btn" onclick="calculateExp()">Calculate Derivative</button>
                <div class="examples">
                    <button class="example-btn" onclick="setExp('e^x')">e^x</button>
                    <button class="example-btn" onclick="setExp('2^x')">2^x</button>
                    <button class="example-btn" onclick="setExp('10^x')">10^x</button>
                    <button class="example-btn" onclick="setExp('ln(x)')">ln(x)</button>
                    <button class="example-btn" onclick="setExp('log(x)')">log(x)</button>
                    <button class="example-btn" onclick="setExp('e^(2*x)')">e^(2x)</button>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Derivative Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Derivative Rules Reference</h3>
            <div class="rule-grid">
                <div class="rule-card">
                    <strong>Power Rule</strong>
                    <code>d/dx[x^n] = n·x^(n-1)</code>
                </div>
                <div class="rule-card">
                    <strong>Constant Rule</strong>
                    <code>d/dx[c] = 0</code>
                </div>
                <div class="rule-card">
                    <strong>Sum Rule</strong>
                    <code>d/dx[f+g] = f' + g'</code>
                </div>
                <div class="rule-card">
                    <strong>Product Rule</strong>
                    <code>d/dx[f·g] = f'g + fg'</code>
                </div>
                <div class="rule-card">
                    <strong>Chain Rule</strong>
                    <code>d/dx[f(g(x))] = f'(g(x))·g'(x)</code>
                </div>
                <div class="rule-card">
                    <strong>sin(x)</strong>
                    <code>d/dx[sin(x)] = cos(x)</code>
                </div>
                <div class="rule-card">
                    <strong>cos(x)</strong>
                    <code>d/dx[cos(x)] = -sin(x)</code>
                </div>
                <div class="rule-card">
                    <strong>tan(x)</strong>
                    <code>d/dx[tan(x)] = sec²(x)</code>
                </div>
                <div class="rule-card">
                    <strong>e^x</strong>
                    <code>d/dx[e^x] = e^x</code>
                </div>
                <div class="rule-card">
                    <strong>ln(x)</strong>
                    <code>d/dx[ln(x)] = 1/x</code>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching function
        function switchTab(i) {
            document.querySelectorAll('.tab-btn').forEach((btn, index) => {
                btn.classList.toggle('active', index === i);
            });
            
            document.querySelectorAll('.tab-content').forEach((content, index) => {
                content.classList.toggle('active', index === i);
            });
            
            document.getElementById('result').classList.remove('show');
        }
        
        // Set function for power rule
        function setFunc(f) { 
            document.getElementById('func').value = f; 
        }
        
        // Set function for polynomial
        function setPoly(f) { 
            document.getElementById('poly').value = f; 
        }
        
        // Set function for trigonometric - NEW FUNCTION
        function setTrig(f) { 
            document.getElementById('trigInput').value = f; 
        }
        
        // Set function for exponential - NEW FUNCTION
        function setExp(f) { 
            document.getElementById('expInput').value = f; 
        }
        
        // Show results
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
            document.getElementById('result').scrollIntoView({behavior: 'smooth', block: 'nearest'});
        }
        
        // POWER RULE CALCULATOR
        function calculate() {
            const input = document.getElementById('func').value.trim();
            if(!input) {
                alert('⚠️ Please enter a function');
                return;
            }
            
            let coef = 1, power = 1;
            
            // Parse coefficient and power
            if(input.match(/^(-?\d*\.?\d*)\*?x\^(\d+)$/)) {
                const parts = input.match(/^(-?\d*\.?\d*)\*?x\^(\d+)$/);
                coef = parts[1] === '' || parts[1] === '-' ? (parts[1] === '-' ? -1 : 1) : parseFloat(parts[1]);
                power = parseInt(parts[2]);
            } else if(input.match(/^(-?\d*\.?\d*)\*?x$/)) {
                const parts = input.match(/^(-?\d*\.?\d*)\*?x$/);
                coef = parts[1] === '' || parts[1] === '-' ? (parts[1] === '-' ? -1 : 1) : parseFloat(parts[1]);
                power = 1;
            } else if(input.match(/^-?\d+\.?\d*$/)) {
                coef = parseFloat(input);
                power = 0;
            } else {
                alert('⚠️ Invalid format. Use: x^n or c*x^n');
                return;
            }
            
            // Calculate derivative
            let result, steps;
            if(power === 0) {
                result = '0';
                steps = `Step 1: d/dx[${coef}] = 0 (constant rule)`;
            } else {
                const newCoef = coef * power;
                const newPower = power - 1;
                
                if(newPower === 0) {
                    result = newCoef.toString();
                } else if(newPower === 1) {
                    result = newCoef === 1 ? 'x' : (newCoef === -1 ? '-x' : newCoef + '*x');
                } else {
                    result = (newCoef === 1 ? '' : (newCoef === -1 ? '-' : newCoef + '*')) + 'x^' + newPower;
                }
                
                steps = `Step 1: Apply power rule d/dx[x^n] = n·x^(n-1)<br>
Step 2: d/dx[${coef === 1 ? '' : coef + '*'}x^${power}] = ${power}·${coef === 1 ? '' : coef + '·'}x^${power-1}<br>
Step 3: Simplify: ${newCoef}·x^${newPower} = ${result}`;
            }
            
            let html = `<div class="result-box">
                <div class="result-label">Original Function f(x)</div>
                <div class="result-value">${input}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Derivative f'(x)</div>
                <div class="result-value" style="color:#2196F3;">${result}</div>
            </div>
            <div class="step-box">
                <strong>📝 Solution Steps:</strong>
                <div class="step">${steps}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Rule Applied:</strong>
                Power Rule: d/dx[x^n] = n·x^(n-1)
            </div>`;
            
            show(html);
        }
        
        // POLYNOMIAL CALCULATOR
        function calculatePoly() {
            const input = document.getElementById('poly').value.trim();
            if(!input) {
                alert('⚠️ Please enter a polynomial');
                return;
            }
            
            // Split into terms
            const terms = input.replace(/\s+/g, '').split(/(?=[+-])/);
            let results = [];
            let steps = [];
            
            terms.forEach(term => {
                if(!term) return;
                
                let coef = 1, power = 0;
                
                // Handle terms like +x^2, -3x^2, x^3, etc.
                if(term.match(/^([+-]?\d*\.?\d*)\*?x\^(\d+)$/)) {
                    const m = term.match(/^([+-]?\d*\.?\d*)\*?x\^(\d+)$/);
                    coef = m[1] === '' || m[1] === '+' || m[1] === '-' ? 
                          (m[1] === '-' ? -1 : 1) : parseFloat(m[1]);
                    power = parseInt(m[2]);
                } else if(term.match(/^([+-]?\d*\.?\d*)\*?x$/)) {
                    const m = term.match(/^([+-]?\d*\.?\d*)\*?x$/);
                    coef = m[1] === '' || m[1] === '+' || m[1] === '-' ? 
                          (m[1] === '-' ? -1 : 1) : parseFloat(m[1]);
                    power = 1;
                } else if(term.match(/^[+-]?\d+\.?\d*$/)) {
                    coef = parseFloat(term);
                    power = 0;
                } else {
                    // If we can't parse, skip this term
                    return;
                }
                
                if(power === 0) {
                    steps.push(`d/dx[${coef}] = 0`);
                    return;
                }
                
                const newCoef = coef * power;
                const newPower = power - 1;
                
                let result;
                if(newPower === 0) {
                    result = newCoef.toString();
                } else if(newPower === 1) {
                    result = newCoef === 1 ? 'x' : (newCoef === -1 ? '-x' : newCoef + '*x');
                } else {
                    result = (newCoef === 1 ? '' : (newCoef === -1 ? '-' : newCoef + '*')) + 'x^' + newPower;
                }
                
                results.push(result);
                steps.push(`d/dx[${term}] = ${result}`);
            });
            
            const derivative = results.join(' + ').replace(/\+\s*-/g, '- ') || '0';
            
            let html = `<div class="result-box">
                <div class="result-label">Original Polynomial</div>
                <div class="result-value">${input}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Derivative</div>
                <div class="result-value" style="color:#2196F3;">${derivative}</div>
            </div>
            <div class="step-box">
                <strong>📝 Term-by-Term Differentiation:</strong>
                ${steps.map(s => '<div class="step">' + s + '</div>').join('')}
            </div>`;
            
            show(html);
        }
        
        // TRIGONOMETRIC CALCULATOR - FIXED
        function calculateTrig() {
            const input = document.getElementById('trigInput').value.trim();
            if(!input) {
                alert('⚠️ Please enter a trigonometric function');
                return;
            }
            
            // Parse trigonometric function
            let func, innerExpr, derivative, steps;
            
            // Match patterns like sin(expr), cos(expr), tan(expr), etc.
            const trigMatch = input.match(/^(sin|cos|tan|sec|csc|cot)\((.*)\)$/);
            
            if(trigMatch) {
                func = trigMatch[1];
                innerExpr = trigMatch[2];
                
                // Define derivatives for each trigonometric function
                const trigDerivatives = {
                    'sin': { 
                        derivative: 'cos', 
                        rule: 'd/dx[sin(u)] = cos(u)·du/dx',
                        chainRule: true
                    },
                    'cos': { 
                        derivative: '-sin', 
                        rule: 'd/dx[cos(u)] = -sin(u)·du/dx',
                        chainRule: true
                    },
                    'tan': { 
                        derivative: 'sec²', 
                        rule: 'd/dx[tan(u)] = sec²(u)·du/dx',
                        chainRule: true
                    },
                    'sec': { 
                        derivative: 'sec·tan', 
                        rule: 'd/dx[sec(u)] = sec(u)·tan(u)·du/dx',
                        chainRule: true
                    },
                    'csc': { 
                        derivative: '-csc·cot', 
                        rule: 'd/dx[csc(u)] = -csc(u)·cot(u)·du/dx',
                        chainRule: true
                    },
                    'cot': { 
                        derivative: '-csc²', 
                        rule: 'd/dx[cot(u)] = -csc²(u)·du/dx',
                        chainRule: true
                    }
                };
                
                const trigInfo = trigDerivatives[func];
                
                if(innerExpr === 'x') {
                    // Simple case: sin(x), cos(x), etc.
                    derivative = `${trigInfo.derivative}(${innerExpr})`;
                    steps = `Step 1: Apply derivative rule for ${func}(x)<br>
Step 2: d/dx[${func}(x)] = ${trigInfo.derivative}(x)`;
                } else {
                    // Chain rule case: sin(2x), cos(x^2), etc.
                    derivative = `${trigInfo.derivative}(${innerExpr})·d/dx[${innerExpr}]`;
                    steps = `Step 1: Apply chain rule: d/dx[f(g(x))] = f'(g(x))·g'(x)<br>
Step 2: f(u) = ${func}(u), f'(u) = ${trigInfo.derivative}(u)<br>
Step 3: g(x) = ${innerExpr}, g'(x) = d/dx[${innerExpr}]<br>
Step 4: d/dx[${func}(${innerExpr})] = ${trigInfo.derivative}(${innerExpr})·d/dx[${innerExpr}]`;
                }
                
                let html = `<div class="result-box">
                    <div class="result-label">Original Function</div>
                    <div class="result-value">${input}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Derivative</div>
                    <div class="result-value" style="color:#2196F3;">${derivative}</div>
                </div>
                <div class="step-box">
                    <strong>📝 Solution Steps:</strong>
                    <div class="step">${steps}</div>
                </div>
                <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                    <strong style="color:#4CAF50;">Rule Applied:</strong>
                    ${trigInfo.rule}
                </div>`;
                
                show(html);
            } else {
                alert('⚠️ Invalid trigonometric function format. Use: sin(expr), cos(expr), etc.');
            }
        }
        
        // EXPONENTIAL CALCULATOR - FIXED
        function calculateExp() {
            const input = document.getElementById('expInput').value.trim();
            if(!input) {
                alert('⚠️ Please enter an exponential or logarithmic function');
                return;
            }
            
            let derivative, steps, rule;
            
            // Parse exponential and logarithmic functions
            if(input === 'e^x') {
                derivative = 'e^x';
                steps = 'Step 1: Apply derivative rule for e^x<br>Step 2: d/dx[e^x] = e^x';
                rule = 'd/dx[e^x] = e^x';
            } 
            else if(input.match(/^e\^\((.*)\)$/)) {
                const innerExpr = input.match(/^e\^\((.*)\)$/)[1];
                derivative = `e^(${innerExpr})·d/dx[${innerExpr}]`;
                steps = `Step 1: Apply chain rule for exponential functions<br>
Step 2: d/dx[e^u] = e^u·du/dx<br>
Step 3: u = ${innerExpr}<br>
Step 4: d/dx[e^(${innerExpr})] = e^(${innerExpr})·d/dx[${innerExpr}]`;
                rule = 'd/dx[e^u] = e^u·du/dx';
            }
            else if(input.match(/^(\d+)\^x$/)) {
                const base = input.match(/^(\d+)\^x$/)[1];
                derivative = `${base}^x · ln(${base})`;
                steps = `Step 1: Apply derivative rule for a^x<br>
Step 2: d/dx[${base}^x] = ${base}^x · ln(${base})`;
                rule = `d/dx[a^x] = a^x · ln(a)`;
            }
            else if(input.match(/^(\d+)\^\((.*)\)$/)) {
                const base = input.match(/^(\d+)\^\((.*)\)$/)[1];
                const innerExpr = input.match(/^(\d+)\^\((.*)\)$/)[2];
                derivative = `${base}^(${innerExpr}) · ln(${base}) · d/dx[${innerExpr}]`;
                steps = `Step 1: Apply chain rule for exponential functions<br>
Step 2: d/dx[a^u] = a^u · ln(a) · du/dx<br>
Step 3: a = ${base}, u = ${innerExpr}<br>
Step 4: d/dx[${base}^(${innerExpr})] = ${base}^(${innerExpr}) · ln(${base}) · d/dx[${innerExpr}]`;
                rule = 'd/dx[a^u] = a^u · ln(a) · du/dx';
            }
            else if(input === 'ln(x)') {
                derivative = '1/x';
                steps = 'Step 1: Apply derivative rule for ln(x)<br>Step 2: d/dx[ln(x)] = 1/x';
                rule = 'd/dx[ln(x)] = 1/x';
            }
            else if(input.match(/^ln\((.*)\)$/)) {
                const innerExpr = input.match(/^ln\((.*)\)$/)[1];
                derivative = `1/(${innerExpr}) · d/dx[${innerExpr}]`;
                steps = `Step 1: Apply chain rule for natural logarithm<br>
Step 2: d/dx[ln(u)] = 1/u · du/dx<br>
Step 3: u = ${innerExpr}<br>
Step 4: d/dx[ln(${innerExpr})] = 1/(${innerExpr}) · d/dx[${innerExpr}]`;
                rule = 'd/dx[ln(u)] = 1/u · du/dx';
            }
            else if(input === 'log(x)') {
                derivative = '1/(x·ln(10))';
                steps = 'Step 1: Apply derivative rule for log(x)<br>Step 2: d/dx[log(x)] = 1/(x·ln(10))';
                rule = 'd/dx[log(x)] = 1/(x·ln(10))';
            }
            else if(input.match(/^log\((.*)\)$/)) {
                const innerExpr = input.match(/^log\((.*)\)$/)[1];
                derivative = `1/(${innerExpr}·ln(10)) · d/dx[${innerExpr}]`;
                steps = `Step 1: Apply chain rule for common logarithm<br>
Step 2: d/dx[log(u)] = 1/(u·ln(10)) · du/dx<br>
Step 3: u = ${innerExpr}<br>
Step 4: d/dx[log(${innerExpr})] = 1/(${innerExpr}·ln(10)) · d/dx[${innerExpr}]`;
                rule = 'd/dx[log(u)] = 1/(u·ln(10)) · du/dx';
            }
            else {
                alert('⚠️ Invalid exponential/logarithmic function format. Use: e^x, 2^x, ln(x), log(x), etc.');
                return;
            }
            
            let html = `<div class="result-box">
                <div class="result-label">Original Function</div>
                <div class="result-value">${input}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Derivative</div>
                <div class="result-value" style="color:#2196F3;">${derivative}</div>
            </div>
            <div class="step-box">
                <strong>📝 Solution Steps:</strong>
                <div class="step">${steps}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Rule Applied:</strong>
                ${rule}
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>