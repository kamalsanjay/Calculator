<?php
/**
 * Equation Solver
 * File: equation-solver.php
 * Description: Solve linear, quadratic equations and systems of equations
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Equation Solver - Linear, Quadratic & System Solver Online</title>
    <meta name="description" content="Solve linear equations, quadratic equations, and systems of equations with step-by-step solutions.">
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
        .input-section input, .input-section select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; font-family: 'Courier New', monospace; }
        .input-section input:focus, .input-section select:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .input-hint { font-size: 0.8rem; color: #666; margin-top: 6px; font-style: italic; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .examples { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 8px; margin: 16px 0; }
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
        .equation-display { background: #f8f9fa; padding: 16px; border-radius: 8px; margin: 16px 0; text-align: center; font-family: 'Courier New', monospace; font-size: 1.2rem; border: 2px solid #e9ecef; }
        .operator-select { background: #e3f2fd; border-color: #2196F3 !important; }
        
        @media (min-width: 768px) { 
            body { padding: 24px; }
            .container { max-width: 720px; margin: 0 auto; }
            header h1 { font-size: 2rem; }
            .calculator-body { padding: 24px; }
        }
        @media (min-width: 1024px) { .container { max-width: 960px; } }
        @media (min-width: 1280px) { .container { max-width: 1100px; } }
        @media (max-width: 479px) {
            .examples { grid-template-columns: 1fr; }
            .result-value { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    <header>
        <h1>🔢 Equation Solver</h1>
        <p>Solve Linear, Quadratic & System of Equations</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Linear</button>
                <button class="tab-btn" onclick="switchTab(1)">Quadratic</button>
                <button class="tab-btn" onclick="switchTab(2)">System 2×2</button>
            </div>

            <!-- Tab 1: Linear Equation -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📐 Linear Equation (ax + b = c)</h3>
                
                <div class="equation-display" id="linearPreview">2x - 4 = 10</div>
                
                <div class="input-section">
                    <label>Operator for a</label>
                    <select id="lin_op_a" class="operator-select" onchange="updateLinearPreview()">
                        <option value="+">+</option>
                        <option value="-">-</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>Coefficient a</label>
                    <input type="number" id="lin_a" value="2" step="any" oninput="updateLinearPreview()">
                </div>
                
                <div class="input-section">
                    <label>Operator for b</label>
                    <select id="lin_op_b" class="operator-select" onchange="updateLinearPreview()">
                        <option value="+">+</option>
                        <option value="-">-</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>Coefficient b</label>
                    <input type="number" id="lin_b" value="4" step="any" oninput="updateLinearPreview()">
                </div>
                
                <div class="input-section">
                    <label>Operator for c</label>
                    <select id="lin_op_c" class="operator-select" onchange="updateLinearPreview()">
                        <option value="=">=</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>Constant c</label>
                    <input type="number" id="lin_c" value="10" step="any" oninput="updateLinearPreview()">
                </div>
                
                <button class="btn" onclick="solveLinear()">Solve Linear Equation</button>
                <div class="examples">
                    <button class="example-btn" onclick="setLinear('+',2,'-',4,10)">2x - 4 = 10</button>
                    <button class="example-btn" onclick="setLinear('+',3,'+',5,20)">3x + 5 = 20</button>
                    <button class="example-btn" onclick="setLinear('+',5,'-',2,13)">5x - 2 = 13</button>
                </div>
            </div>

            <!-- Tab 2: Quadratic Equation -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📈 Quadratic Equation (ax² + bx + c = 0)</h3>
                
                <div class="equation-display" id="quadraticPreview">x² - 5x + 6 = 0</div>
                
                <div class="input-section">
                    <label>Operator for a</label>
                    <select id="quad_op_a" class="operator-select" onchange="updateQuadraticPreview()">
                        <option value="+">+</option>
                        <option value="-">-</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>Coefficient a (x²)</label>
                    <input type="number" id="quad_a" value="1" step="any" oninput="updateQuadraticPreview()">
                </div>
                
                <div class="input-section">
                    <label>Operator for b</label>
                    <select id="quad_op_b" class="operator-select" onchange="updateQuadraticPreview()">
                        <option value="+">+</option>
                        <option value="-">-</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>Coefficient b (x)</label>
                    <input type="number" id="quad_b" value="5" step="any" oninput="updateQuadraticPreview()">
                </div>
                
                <div class="input-section">
                    <label>Operator for c</label>
                    <select id="quad_op_c" class="operator-select" onchange="updateQuadraticPreview()">
                        <option value="+">+</option>
                        <option value="-">-</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>Coefficient c (constant)</label>
                    <input type="number" id="quad_c" value="6" step="any" oninput="updateQuadraticPreview()">
                </div>
                
                <button class="btn" onclick="solveQuadratic()">Solve Quadratic Equation</button>
                <div class="examples">
                    <button class="example-btn" onclick="setQuad('+',1,'-',5,'+',6)">x² - 5x + 6 = 0</button>
                    <button class="example-btn" onclick="setQuad('+',1,'+',0,'-',9)">x² - 9 = 0</button>
                    <button class="example-btn" onclick="setQuad('+',2,'+',3,'-',2)">2x² + 3x - 2 = 0</button>
                </div>
            </div>

            <!-- Tab 3: System of Equations -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">🔄 System of 2 Equations</h3>
                <p style="margin-bottom: 16px; color: #666; font-size: 0.9rem;">a₁x + b₁y = c₁<br>a₂x + b₂y = c₂</p>
                
                <div class="equation-display" id="systemPreview">2x + 3y = 12<br>4x - 2y = 8</div>
                
                <h4 style="color: #555; margin: 16px 0 12px; font-size: 0.95rem;">Equation 1:</h4>
                
                <div class="input-section">
                    <label>Operator for a₁</label>
                    <select id="sys_op_a1" class="operator-select" onchange="updateSystemPreview()">
                        <option value="+">+</option>
                        <option value="-">-</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>a₁ (coefficient of x)</label>
                    <input type="number" id="sys_a1" value="2" step="any" oninput="updateSystemPreview()">
                </div>
                
                <div class="input-section">
                    <label>Operator for b₁</label>
                    <select id="sys_op_b1" class="operator-select" onchange="updateSystemPreview()">
                        <option value="+">+</option>
                        <option value="-">-</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>b₁ (coefficient of y)</label>
                    <input type="number" id="sys_b1" value="3" step="any" oninput="updateSystemPreview()">
                </div>
                
                <div class="input-section">
                    <label>Operator for c₁</label>
                    <select id="sys_op_c1" class="operator-select" onchange="updateSystemPreview()">
                        <option value="=">=</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>c₁ (constant)</label>
                    <input type="number" id="sys_c1" value="12" step="any" oninput="updateSystemPreview()">
                </div>
                
                <h4 style="color: #555; margin: 16px 0 12px; font-size: 0.95rem;">Equation 2:</h4>
                
                <div class="input-section">
                    <label>Operator for a₂</label>
                    <select id="sys_op_a2" class="operator-select" onchange="updateSystemPreview()">
                        <option value="+">+</option>
                        <option value="-">-</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>a₂ (coefficient of x)</label>
                    <input type="number" id="sys_a2" value="4" step="any" oninput="updateSystemPreview()">
                </div>
                
                <div class="input-section">
                    <label>Operator for b₂</label>
                    <select id="sys_op_b2" class="operator-select" onchange="updateSystemPreview()">
                        <option value="+">+</option>
                        <option value="-">-</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>b₂ (coefficient of y)</label>
                    <input type="number" id="sys_b2" value="2" step="any" oninput="updateSystemPreview()">
                </div>
                
                <div class="input-section">
                    <label>Operator for c₂</label>
                    <select id="sys_op_c2" class="operator-select" onchange="updateSystemPreview()">
                        <option value="=">=</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>c₂ (constant)</label>
                    <input type="number" id="sys_c2" value="8" step="any" oninput="updateSystemPreview()">
                </div>
                
                <button class="btn" onclick="solveSystem()">Solve System</button>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Solution</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Equation Solving Methods</h3>
            <div class="formula-box">
                <strong>Linear Equation (ax + b = c):</strong>
                Solution: x = (c - b) / a<br>
                Example: 2x - 4 = 10 → x = (10 + 4) / 2 = 7
            </div>
            <div class="formula-box">
                <strong>Quadratic Equation (ax² + bx + c = 0):</strong>
                x = [-b ± √(b² - 4ac)] / 2a<br>
                Discriminant Δ = b² - 4ac<br>
                • Δ > 0: Two real solutions<br>
                • Δ = 0: One real solution<br>
                • Δ < 0: Two complex solutions
            </div>
            <div class="formula-box">
                <strong>System of Equations (Cramer's Rule):</strong>
                x = (c₁b₂ - c₂b₁) / (a₁b₂ - a₂b₁)<br>
                y = (a₁c₂ - a₂c₁) / (a₁b₂ - a₂b₁)<br>
                Determinant D = a₁b₂ - a₂b₁
            </div>
        </div>
    </div>

    <script>
        // Initialize previews on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateLinearPreview();
            updateQuadraticPreview();
            updateSystemPreview();
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
        
        // Linear Equation Functions
        function updateLinearPreview() {
            const opA = document.getElementById('lin_op_a').value;
            const a = parseFloat(document.getElementById('lin_a').value) || 0;
            const opB = document.getElementById('lin_op_b').value;
            const b = parseFloat(document.getElementById('lin_b').value) || 0;
            const c = parseFloat(document.getElementById('lin_c').value) || 0;
            
            let equation = '';
            if (a !== 0) {
                equation += (opA === '+' ? '' : '-') + (Math.abs(a) === 1 ? '' : Math.abs(a)) + 'x';
            }
            
            if (b !== 0) {
                equation += ' ' + opB + ' ' + Math.abs(b);
            }
            
            if (equation === '') {
                equation = '0';
            }
            
            document.getElementById('linearPreview').textContent = equation + ' = ' + c;
        }
        
        function setLinear(opA, a, opB, b, c) {
            document.getElementById('lin_op_a').value = opA;
            document.getElementById('lin_a').value = a;
            document.getElementById('lin_op_b').value = opB;
            document.getElementById('lin_b').value = b;
            document.getElementById('lin_c').value = c;
            updateLinearPreview();
        }
        
        function solveLinear() {
            const opA = document.getElementById('lin_op_a').value;
            const a = parseFloat(document.getElementById('lin_a').value);
            const opB = document.getElementById('lin_op_b').value;
            const b = parseFloat(document.getElementById('lin_b').value);
            const c = parseFloat(document.getElementById('lin_c').value);
            
            if(isNaN(a) || isNaN(b) || isNaN(c)) {
                return alert('⚠️ Please enter valid numbers');
            }
            
            if(a === 0) {
                return alert('⚠️ Coefficient a cannot be zero');
            }
            
            // Apply operators to coefficients
            const finalA = opA === '+' ? a : -a;
            const finalB = opB === '+' ? b : -b;
            const x = (c - finalB) / finalA;
            
            const equation = document.getElementById('linearPreview').textContent;
            
            let html = `<div class="result-box">
                <div class="result-label">Original Equation</div>
                <div class="result-value">${equation}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Solution</div>
                <div class="result-value" style="color:#2196F3;">x = ${x.toFixed(4)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Step-by-Step Solution:</strong>
                <div class="step">Step 1: ${equation}</div>
                <div class="step">Step 2: ${finalA}x = ${c} - (${finalB}) = ${c - finalB}</div>
                <div class="step">Step 3: x = ${c - finalB} / ${finalA} = ${x.toFixed(4)}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">✅ Verification:</strong>
                ${finalA}(${x.toFixed(4)}) + ${finalB} = ${(finalA*x + finalB).toFixed(4)} ≈ ${c}
            </div>`;
            
            show(html);
        }
        
        // Quadratic Equation Functions - FIXED
        function updateQuadraticPreview() {
            const opA = document.getElementById('quad_op_a').value;
            const a = parseFloat(document.getElementById('quad_a').value) || 0;
            const opB = document.getElementById('quad_op_b').value;
            const b = parseFloat(document.getElementById('quad_b').value) || 0;
            const opC = document.getElementById('quad_op_c').value;
            const c = parseFloat(document.getElementById('quad_c').value) || 0;
            
            let equation = '';
            
            if (a !== 0) {
                equation += (opA === '+' ? '' : '-') + (Math.abs(a) === 1 ? '' : Math.abs(a)) + 'x²';
            }
            
            if (b !== 0) {
                equation += ' ' + opB + ' ' + (Math.abs(b) === 1 ? '' : Math.abs(b)) + 'x';
            }
            
            if (c !== 0) {
                equation += ' ' + opC + ' ' + Math.abs(c);
            }
            
            if (equation === '') {
                equation = '0';
            }
            
            document.getElementById('quadraticPreview').textContent = equation + ' = 0';
        }
        
        function setQuad(opA, a, opB, b, opC, c) {
            document.getElementById('quad_op_a').value = opA;
            document.getElementById('quad_a').value = a;
            document.getElementById('quad_op_b').value = opB;
            document.getElementById('quad_b').value = b;
            document.getElementById('quad_op_c').value = opC;
            document.getElementById('quad_c').value = c;
            updateQuadraticPreview();
        }
        
        function solveQuadratic() {
            const opA = document.getElementById('quad_op_a').value;
            const a = parseFloat(document.getElementById('quad_a').value);
            const opB = document.getElementById('quad_op_b').value;
            const b = parseFloat(document.getElementById('quad_b').value);
            const opC = document.getElementById('quad_op_c').value;
            const c = parseFloat(document.getElementById('quad_c').value);
            
            if(isNaN(a) || isNaN(b) || isNaN(c)) {
                return alert('⚠️ Please enter valid numbers');
            }
            
            if(a === 0) {
                return alert('⚠️ Coefficient a cannot be zero for quadratic equation');
            }
            
            // Apply operators to coefficients - FIXED: Now correctly handles operator for 'a'
            const finalA = opA === '+' ? a : -a;
            const finalB = opB === '+' ? b : -b;
            const finalC = opC === '+' ? c : -c;
            
            const discriminant = finalB*finalB - 4*finalA*finalC;
            const equation = document.getElementById('quadraticPreview').textContent;
            
            let html = `<div class="result-box">
                <div class="result-label">Original Equation</div>
                <div class="result-value">${equation}</div>
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#FF9800;">
                <div class="result-label">Discriminant (Δ = b² - 4ac)</div>
                <div class="result-value" style="color:#FF9800;">Δ = ${discriminant.toFixed(4)}</div>
            </div>`;
            
            if(discriminant > 0) {
                const x1 = (-finalB + Math.sqrt(discriminant)) / (2*finalA);
                const x2 = (-finalB - Math.sqrt(discriminant)) / (2*finalA);
                
                html += `<div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Solution (Two Real Roots)</div>
                    <div class="result-value" style="color:#2196F3;">x₁ = ${x1.toFixed(4)}<br>x₂ = ${x2.toFixed(4)}</div>
                </div>`;
                
                html += `<div class="step-box">
                    <strong>📝 Solution Steps:</strong>
                    <div class="step">Step 1: Calculate discriminant Δ = ${finalB}² - 4(${finalA})(${finalC}) = ${discriminant.toFixed(4)}</div>
                    <div class="step">Step 2: √Δ = ${Math.sqrt(discriminant).toFixed(4)}</div>
                    <div class="step">Step 3: x₁ = [-${finalB} + ${Math.sqrt(discriminant).toFixed(4)}] / ${2*finalA} = ${x1.toFixed(4)}</div>
                    <div class="step">Step 4: x₂ = [-${finalB} - ${Math.sqrt(discriminant).toFixed(4)}] / ${2*finalA} = ${x2.toFixed(4)}</div>
                </div>`;
            } else if(Math.abs(discriminant) < 1e-10) {
                const x = -finalB / (2*finalA);
                
                html += `<div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Solution (One Real Root)</div>
                    <div class="result-value" style="color:#2196F3;">x = ${x.toFixed(4)}</div>
                </div>`;
                
                html += `<div class="step-box">
                    <strong>📝 Solution Steps:</strong>
                    <div class="step">Discriminant = 0 (repeated root)</div>
                    <div class="step">x = -b / 2a = -${finalB} / ${2*finalA} = ${x.toFixed(4)}</div>
                </div>`;
            } else {
                const realPart = -finalB / (2*finalA);
                const imagPart = Math.sqrt(-discriminant) / (2*finalA);
                
                html += `<div class="result-box" style="border-left-color:#9C27B0;">
                    <div class="result-label">Solution (Complex Roots)</div>
                    <div class="result-value" style="color:#9C27B0;">x₁ = ${realPart.toFixed(4)} + ${imagPart.toFixed(4)}i<br>x₂ = ${realPart.toFixed(4)} - ${imagPart.toFixed(4)}i</div>
                </div>`;
                
                html += `<div class="step-box">
                    <strong>📝 Solution Steps:</strong>
                    <div class="step">Discriminant < 0 (complex roots)</div>
                    <div class="step">Real part: -b/2a = ${realPart.toFixed(4)}</div>
                    <div class="step">Imaginary part: √|Δ|/2a = ${imagPart.toFixed(4)}</div>
                </div>`;
            }
            
            html += `<div class="formula-box" style="background:#e3f2fd;border-left-color:#2196F3;">
                <strong style="color:#1976d2;">Formula Used:</strong>
                x = [-b ± √(b² - 4ac)] / 2a
            </div>`;
            
            show(html);
        }
        
        // System of Equations Functions
        function updateSystemPreview() {
            const opA1 = document.getElementById('sys_op_a1').value;
            const a1 = parseFloat(document.getElementById('sys_a1').value) || 0;
            const opB1 = document.getElementById('sys_op_b1').value;
            const b1 = parseFloat(document.getElementById('sys_b1').value) || 0;
            const c1 = parseFloat(document.getElementById('sys_c1').value) || 0;
            
            const opA2 = document.getElementById('sys_op_a2').value;
            const a2 = parseFloat(document.getElementById('sys_a2').value) || 0;
            const opB2 = document.getElementById('sys_op_b2').value;
            const b2 = parseFloat(document.getElementById('sys_b2').value) || 0;
            const c2 = parseFloat(document.getElementById('sys_c2').value) || 0;
            
            const eq1 = `${opA1 === '+' ? '' : '-'}${Math.abs(a1)}x ${opB1} ${Math.abs(b1)}y = ${c1}`;
            const eq2 = `${opA2 === '+' ? '' : '-'}${Math.abs(a2)}x ${opB2} ${Math.abs(b2)}y = ${c2}`;
            
            document.getElementById('systemPreview').innerHTML = eq1 + '<br>' + eq2;
        }
        
        function solveSystem() {
            const opA1 = document.getElementById('sys_op_a1').value;
            const a1 = parseFloat(document.getElementById('sys_a1').value);
            const opB1 = document.getElementById('sys_op_b1').value;
            const b1 = parseFloat(document.getElementById('sys_b1').value);
            const c1 = parseFloat(document.getElementById('sys_c1').value);
            
            const opA2 = document.getElementById('sys_op_a2').value;
            const a2 = parseFloat(document.getElementById('sys_a2').value);
            const opB2 = document.getElementById('sys_op_b2').value;
            const b2 = parseFloat(document.getElementById('sys_b2').value);
            const c2 = parseFloat(document.getElementById('sys_c2').value);
            
            if(isNaN(a1)||isNaN(b1)||isNaN(c1)||isNaN(a2)||isNaN(b2)||isNaN(c2)) {
                return alert('⚠️ Please enter valid numbers');
            }
            
            // Apply operators to coefficients
            const finalA1 = opA1 === '+' ? a1 : -a1;
            const finalB1 = opB1 === '+' ? b1 : -b1;
            const finalA2 = opA2 === '+' ? a2 : -a2;
            const finalB2 = opB2 === '+' ? b2 : -b2;
            
            const det = finalA1*finalB2 - finalA2*finalB1;
            
            if(Math.abs(det) < 1e-10) {
                return alert('⚠️ System has no unique solution (determinant = 0)');
            }
            
            const x = (c1*finalB2 - c2*finalB1) / det;
            const y = (finalA1*c2 - finalA2*c1) / det;
            
            const eq1 = `${opA1 === '+' ? '' : '-'}${Math.abs(a1)}x ${opB1} ${Math.abs(b1)}y = ${c1}`;
            const eq2 = `${opA2 === '+' ? '' : '-'}${Math.abs(a2)}x ${opB2} ${Math.abs(b2)}y = ${c2}`;
            
            let html = `<div class="result-box">
                <div class="result-label">System of Equations</div>
                <div class="result-value" style="font-size:1.1rem;">${eq1}<br>${eq2}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Solution</div>
                <div class="result-value" style="color:#2196F3;">x = ${x.toFixed(4)}<br>y = ${y.toFixed(4)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Solution Using Cramer's Rule:</strong>
                <div class="step">Step 1: Determinant D = ${finalA1}×${finalB2} - ${finalA2}×${finalB1} = ${det.toFixed(4)}</div>
                <div class="step">Step 2: Dx = ${c1}×${finalB2} - ${c2}×${finalB1} = ${(c1*finalB2 - c2*finalB1).toFixed(4)}</div>
                <div class="step">Step 3: Dy = ${finalA1}×${c2} - ${finalA2}×${c1} = ${(finalA1*c2 - finalA2*c1).toFixed(4)}</div>
                <div class="step">Step 4: x = Dx / D = ${x.toFixed(4)}</div>
                <div class="step">Step 5: y = Dy / D = ${y.toFixed(4)}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">✅ Verification:</strong>
                Equation 1: ${finalA1}(${x.toFixed(4)}) + ${finalB1}(${y.toFixed(4)}) = ${(finalA1*x + finalB1*y).toFixed(4)} ≈ ${c1}<br>
                Equation 2: ${finalA2}(${x.toFixed(4)}) + ${finalB2}(${y.toFixed(4)}) = ${(finalA2*x + finalB2*y).toFixed(4)} ≈ ${c2}
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>