<?php
/**
 * Algebra Calculator
 * File: algebra-calculator.php
 * Description: Solve algebraic equations, simplify expressions, and factor polynomials
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Algebra Calculator - Solve Equations & Simplify Expressions Online</title>
    <meta name="description" content="Free algebra calculator online. Solve linear equations, quadratic equations, simplify expressions, factor polynomials, and expand algebraic expressions.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 15px; }
        header { background: rgba(255,255,255,0.1); color: white; padding: 25px 15px; text-align: center; border-radius: 15px; margin-bottom: 20px; backdrop-filter: blur(10px); }
        header h1 { margin: 0 0 8px 0; font-size: 1.8em; }
        header p { margin: 0; opacity: 0.9; font-size: 1em; }
        .container { max-width: 900px; margin: 0 auto; }
        .breadcrumb { margin-bottom: 15px; text-align: center; }
        .breadcrumb a { color: white; text-decoration: none; font-weight: 500; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 8px; display: inline-block; backdrop-filter: blur(10px); font-size: 0.9em; }
        .calculator-body { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); margin-bottom: 20px; }
        .calc-type { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; margin-bottom: 25px; }
        .type-btn { padding: 12px; background: #f0f0f0; border: 2px solid transparent; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; outline: none; }
        .type-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-color: #667eea; }
        .input-section { margin-bottom: 20px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .input-section input, .input-section select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1em; outline: none; transition: all 0.3s; font-family: 'Courier New', monospace; }
        .input-section input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 28px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s; width: 100%; font-size: 1.1em; outline: none; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .result-section { background: #f9f9f9; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; margin-top: 20px; display: none; }
        .result-section.show { display: block; }
        .result-section h3 { color: #667eea; margin-bottom: 15px; }
        .result-item { background: white; padding: 15px; border-radius: 8px; margin-bottom: 10px; font-family: 'Courier New', monospace; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .result-label { font-weight: 600; color: #666; margin-bottom: 5px; }
        .result-value { font-size: 1.2em; color: #333; }
        .info-box { background: white; padding: 20px; border-radius: 15px; margin-top: 20px; line-height: 1.7; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        .info-box h3 { color: #667eea; margin-bottom: 12px; }
        .info-box p { margin-bottom: 10px; color: #555; font-size: 0.95em; }
        .examples { background: #e3f2fd; padding: 15px; border-radius: 8px; margin-top: 15px; }
        .examples h4 { color: #1976d2; margin-bottom: 10px; }
        .examples code { background: white; padding: 4px 8px; border-radius: 4px; font-family: 'Courier New', monospace; color: #d32f2f; }
        .steps { background: #fff3e0; padding: 15px; border-radius: 8px; margin-top: 10px; }
        .steps h4 { color: #f57c00; margin-bottom: 10px; }
        .steps ol { margin-left: 20px; }
        .steps li { margin-bottom: 8px; }
        @media (max-width: 600px) {
            body { padding: 10px; }
            header h1 { font-size: 1.5em; }
            .calculator-body { padding: 15px; }
            .calc-type { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header>
        <h1>🔢 Algebra Calculator</h1>
        <p>Solve equations and simplify expressions</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-type">
                <button class="type-btn active" type="button" onclick="setCalcType('linear')">Linear Equation</button>
                <button class="type-btn" type="button" onclick="setCalcType('quadratic')">Quadratic Equation</button>
                <button class="type-btn" type="button" onclick="setCalcType('simplify')">Simplify Expression</button>
                <button class="type-btn" type="button" onclick="setCalcType('factor')">Factor Polynomial</button>
            </div>

            <!-- Linear Equation -->
            <div id="linearSection" style="display: block;">
                <h3 style="color: #667eea; margin-bottom: 15px;">Solve Linear Equation</h3>
                <p style="margin-bottom: 15px; color: #666;">Format: ax + b = c (e.g., 2x + 5 = 13)</p>
                
                <div class="input-section">
                    <label>Coefficient (a)</label>
                    <input type="number" id="linearA" value="2" step="any">
                </div>
                
                <div class="input-section">
                    <label>Constant (b)</label>
                    <input type="number" id="linearB" value="5" step="any">
                </div>
                
                <div class="input-section">
                    <label>Result (c)</label>
                    <input type="number" id="linearC" value="13" step="any">
                </div>
                
                <button class="btn" onclick="solveLinear()">Solve Linear Equation</button>
            </div>

            <!-- Quadratic Equation -->
            <div id="quadraticSection" style="display: none;">
                <h3 style="color: #667eea; margin-bottom: 15px;">Solve Quadratic Equation</h3>
                <p style="margin-bottom: 15px; color: #666;">Format: ax² + bx + c = 0 (e.g., x² - 5x + 6 = 0)</p>
                
                <div class="input-section">
                    <label>Coefficient a (x²)</label>
                    <input type="number" id="quadA" value="1" step="any">
                </div>
                
                <div class="input-section">
                    <label>Coefficient b (x)</label>
                    <input type="number" id="quadB" value="-5" step="any">
                </div>
                
                <div class="input-section">
                    <label>Constant c</label>
                    <input type="number" id="quadC" value="6" step="any">
                </div>
                
                <button class="btn" onclick="solveQuadratic()">Solve Quadratic Equation</button>
            </div>

            <!-- Simplify Expression -->
            <div id="simplifySection" style="display: none;">
                <h3 style="color: #667eea; margin-bottom: 15px;">Simplify Algebraic Expression</h3>
                <p style="margin-bottom: 15px; color: #666;">Enter expression to simplify (e.g., 3x + 2x - 5 + 10)</p>
                
                <div class="input-section">
                    <label>Expression</label>
                    <input type="text" id="simplifyExpr" value="3x + 2x - 5 + 10" placeholder="e.g., 2x + 3x + 5">
                </div>
                
                <button class="btn" onclick="simplifyExpression()">Simplify Expression</button>
            </div>

            <!-- Factor Polynomial -->
            <div id="factorSection" style="display: none;">
                <h3 style="color: #667eea; margin-bottom: 15px;">Factor Quadratic Polynomial</h3>
                <p style="margin-bottom: 15px; color: #666;">Format: ax² + bx + c (e.g., x² + 5x + 6)</p>
                
                <div class="input-section">
                    <label>Coefficient a (x²)</label>
                    <input type="number" id="factorA" value="1" step="any">
                </div>
                
                <div class="input-section">
                    <label>Coefficient b (x)</label>
                    <input type="number" id="factorB" value="5" step="any">
                </div>
                
                <div class="input-section">
                    <label>Constant c</label>
                    <input type="number" id="factorC" value="6" step="any">
                </div>
                
                <button class="btn" onclick="factorPolynomial()">Factor Polynomial</button>
            </div>

            <!-- Results Section -->
            <div class="result-section" id="resultSection">
                <h3>📊 Solution</h3>
                <div id="resultContent"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 How to Use</h3>
            <p><strong>Linear Equation:</strong> Solves equations in the form ax + b = c. Enter coefficients and get the value of x.</p>
            <p><strong>Quadratic Equation:</strong> Solves ax² + bx + c = 0 using the quadratic formula. Returns two solutions (roots).</p>
            <p><strong>Simplify Expression:</strong> Combines like terms in algebraic expressions (e.g., 3x + 2x becomes 5x).</p>
            <p><strong>Factor Polynomial:</strong> Factors quadratic expressions into two binomials (e.g., x² + 5x + 6 = (x + 2)(x + 3)).</p>

            <div class="examples">
                <h4>💡 Examples</h4>
                <p><strong>Linear:</strong> <code>2x + 5 = 13</code> → x = 4</p>
                <p><strong>Quadratic:</strong> <code>x² - 5x + 6 = 0</code> → x = 2 or x = 3</p>
                <p><strong>Simplify:</strong> <code>3x + 2x - 5 + 10</code> → 5x + 5</p>
                <p><strong>Factor:</strong> <code>x² + 5x + 6</code> → (x + 2)(x + 3)</p>
            </div>

            <div class="steps">
                <h4>📝 Formulas Used</h4>
                <ol>
                    <li><strong>Linear:</strong> x = (c - b) / a</li>
                    <li><strong>Quadratic:</strong> x = [-b ± √(b² - 4ac)] / 2a</li>
                    <li><strong>Discriminant:</strong> Δ = b² - 4ac (determines number of solutions)</li>
                    <li><strong>Factoring:</strong> Find two numbers that multiply to ac and add to b</li>
                </ol>
            </div>
        </div>
    </div>

    <script>
        var currentType = 'linear';

        function setCalcType(type) {
            currentType = type;
            
            // Update buttons
            document.querySelectorAll('.type-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Hide all sections
            document.getElementById('linearSection').style.display = 'none';
            document.getElementById('quadraticSection').style.display = 'none';
            document.getElementById('simplifySection').style.display = 'none';
            document.getElementById('factorSection').style.display = 'none';
            document.getElementById('resultSection').classList.remove('show');
            
            // Show selected section
            if (type === 'linear') document.getElementById('linearSection').style.display = 'block';
            else if (type === 'quadratic') document.getElementById('quadraticSection').style.display = 'block';
            else if (type === 'simplify') document.getElementById('simplifySection').style.display = 'block';
            else if (type === 'factor') document.getElementById('factorSection').style.display = 'block';
        }

        function solveLinear() {
            var a = parseFloat(document.getElementById('linearA').value);
            var b = parseFloat(document.getElementById('linearB').value);
            var c = parseFloat(document.getElementById('linearC').value);
            
            if (isNaN(a) || isNaN(b) || isNaN(c)) {
                alert('Please enter valid numbers');
                return;
            }
            
            if (a === 0) {
                alert('Coefficient a cannot be zero');
                return;
            }
            
            var x = (c - b) / a;
            
            var html = '';
            html += '<div class="result-item">';
            html += '<div class="result-label">Original Equation</div>';
            html += '<div class="result-value">' + a + 'x + ' + b + ' = ' + c + '</div>';
            html += '</div>';
            
            html += '<div class="result-item">';
            html += '<div class="result-label">Solution</div>';
            html += '<div class="result-value" style="color: #4CAF50; font-size: 1.5em;">x = ' + x.toFixed(4) + '</div>';
            html += '</div>';
            
            html += '<div class="steps">';
            html += '<h4>Solution Steps</h4>';
            html += '<ol>';
            html += '<li>Start with: ' + a + 'x + ' + b + ' = ' + c + '</li>';
            html += '<li>Subtract ' + b + ' from both sides: ' + a + 'x = ' + (c - b) + '</li>';
            html += '<li>Divide both sides by ' + a + ': x = ' + x.toFixed(4) + '</li>';
            html += '</ol>';
            html += '</div>';
            
            html += '<div class="result-item">';
            html += '<div class="result-label">Verification</div>';
            html += '<div class="result-value">' + a + '(' + x.toFixed(4) + ') + ' + b + ' = ' + (a * x + b).toFixed(4) + ' ✓</div>';
            html += '</div>';
            
            document.getElementById('resultContent').innerHTML = html;
            document.getElementById('resultSection').classList.add('show');
        }

        function solveQuadratic() {
            var a = parseFloat(document.getElementById('quadA').value);
            var b = parseFloat(document.getElementById('quadB').value);
            var c = parseFloat(document.getElementById('quadC').value);
            
            if (isNaN(a) || isNaN(b) || isNaN(c)) {
                alert('Please enter valid numbers');
                return;
            }
            
            if (a === 0) {
                alert('Coefficient a cannot be zero for quadratic equation');
                return;
            }
            
            var discriminant = b * b - 4 * a * c;
            
            var html = '';
            html += '<div class="result-item">';
            html += '<div class="result-label">Original Equation</div>';
            html += '<div class="result-value">' + a + 'x² + ' + b + 'x + ' + c + ' = 0</div>';
            html += '</div>';
            
            html += '<div class="result-item">';
            html += '<div class="result-label">Discriminant (Δ = b² - 4ac)</div>';
            html += '<div class="result-value">Δ = ' + discriminant.toFixed(4) + '</div>';
            html += '</div>';
            
            if (discriminant > 0) {
                var x1 = (-b + Math.sqrt(discriminant)) / (2 * a);
                var x2 = (-b - Math.sqrt(discriminant)) / (2 * a);
                
                html += '<div class="result-item">';
                html += '<div class="result-label">Two Real Solutions</div>';
                html += '<div class="result-value" style="color: #4CAF50; font-size: 1.3em;">x₁ = ' + x1.toFixed(4) + '<br>x₂ = ' + x2.toFixed(4) + '</div>';
                html += '</div>';
                
                html += '<div class="steps">';
                html += '<h4>Solution Steps</h4>';
                html += '<ol>';
                html += '<li>Use quadratic formula: x = [-b ± √(b² - 4ac)] / 2a</li>';
                html += '<li>Calculate discriminant: Δ = (' + b + ')² - 4(' + a + ')(' + c + ') = ' + discriminant.toFixed(4) + '</li>';
                html += '<li>Since Δ > 0, there are two real solutions</li>';
                html += '<li>x₁ = [' + (-b) + ' + √' + discriminant.toFixed(4) + '] / ' + (2 * a) + ' = ' + x1.toFixed(4) + '</li>';
                html += '<li>x₂ = [' + (-b) + ' - √' + discriminant.toFixed(4) + '] / ' + (2 * a) + ' = ' + x2.toFixed(4) + '</li>';
                html += '</ol>';
                html += '</div>';
                
            } else if (discriminant === 0) {
                var x = -b / (2 * a);
                
                html += '<div class="result-item">';
                html += '<div class="result-label">One Real Solution (Double Root)</div>';
                html += '<div class="result-value" style="color: #FF9800; font-size: 1.3em;">x = ' + x.toFixed(4) + '</div>';
                html += '</div>';
                
                html += '<div class="steps">';
                html += '<h4>Solution Steps</h4>';
                html += '<ol>';
                html += '<li>Discriminant = 0, so there is one repeated root</li>';
                html += '<li>x = -b / 2a = ' + (-b) + ' / ' + (2 * a) + ' = ' + x.toFixed(4) + '</li>';
                html += '</ol>';
                html += '</div>';
                
            } else {
                var realPart = -b / (2 * a);
                var imagPart = Math.sqrt(-discriminant) / (2 * a);
                
                html += '<div class="result-item">';
                html += '<div class="result-label">Two Complex Solutions</div>';
                html += '<div class="result-value" style="color: #2196F3; font-size: 1.3em;">';
                html += 'x₁ = ' + realPart.toFixed(4) + ' + ' + imagPart.toFixed(4) + 'i<br>';
                html += 'x₂ = ' + realPart.toFixed(4) + ' - ' + imagPart.toFixed(4) + 'i';
                html += '</div>';
                html += '</div>';
                
                html += '<div class="steps">';
                html += '<h4>Solution Steps</h4>';
                html += '<ol>';
                html += '<li>Discriminant < 0, so there are two complex conjugate solutions</li>';
                html += '<li>Real part = -b / 2a = ' + realPart.toFixed(4) + '</li>';
                html += '<li>Imaginary part = √|Δ| / 2a = ' + imagPart.toFixed(4) + '</li>';
                html += '</ol>';
                html += '</div>';
            }
            
            document.getElementById('resultContent').innerHTML = html;
            document.getElementById('resultSection').classList.add('show');
        }

        function simplifyExpression() {
            var expr = document.getElementById('simplifyExpr').value.trim();
            
            if (!expr) {
                alert('Please enter an expression');
                return;
            }
            
            // Parse and simplify
            var xCoeff = 0;
            var constant = 0;
            
            // Remove spaces
            expr = expr.replace(/s+/g, '');
            
            // Split by + and -
            var terms = expr.match(/[+-]?[^+-]+/g);
            
            if (!terms) {
                alert('Invalid expression format');
                return;
            }
            
            for (var i = 0; i < terms.length; i++) {
                var term = terms[i].trim();
                
                if (term.includes('x')) {
                    var coeff = term.replace('x', '');
                    if (coeff === '' || coeff === '+') coeff = '1';
                    else if (coeff === '-') coeff = '-1';
                    xCoeff += parseFloat(coeff);
                } else {
                    constant += parseFloat(term);
                }
            }
            
            var simplified = '';
            if (xCoeff !== 0) {
                simplified += xCoeff + 'x';
                if (constant > 0) simplified += ' + ' + constant;
                else if (constant < 0) simplified += ' - ' + Math.abs(constant);
            } else {
                simplified = constant.toString();
            }
            
            var html = '';
            html += '<div class="result-item">';
            html += '<div class="result-label">Original Expression</div>';
            html += '<div class="result-value">' + expr + '</div>';
            html += '</div>';
            
            html += '<div class="result-item">';
            html += '<div class="result-label">Simplified Expression</div>';
            html += '<div class="result-value" style="color: #4CAF50; font-size: 1.5em;">' + simplified + '</div>';
            html += '</div>';
            
            html += '<div class="steps">';
            html += '<h4>Simplification Steps</h4>';
            html += '<ol>';
            html += '<li>Identify like terms</li>';
            html += '<li>Combine x terms: ' + xCoeff + 'x</li>';
            html += '<li>Combine constants: ' + constant + '</li>';
            html += '<li>Final result: ' + simplified + '</li>';
            html += '</ol>';
            html += '</div>';
            
            document.getElementById('resultContent').innerHTML = html;
            document.getElementById('resultSection').classList.add('show');
        }

        function factorPolynomial() {
            var a = parseFloat(document.getElementById('factorA').value);
            var b = parseFloat(document.getElementById('factorB').value);
            var c = parseFloat(document.getElementById('factorC').value);
            
            if (isNaN(a) || isNaN(b) || isNaN(c)) {
                alert('Please enter valid numbers');
                return;
            }
            
            // For simple case where a = 1
            var factored = '';
            var success = false;
            
            // Find two numbers that multiply to c and add to b
            for (var i = -100; i <= 100; i++) {
                for (var j = -100; j <= 100; j++) {
                    if (i * j === c && i + j === b) {
                        factored = '(x + ' + i + ')(x + ' + j + ')';
                        success = true;
                        break;
                    }
                }
                if (success) break;
            }
            
            var html = '';
            html += '<div class="result-item">';
            html += '<div class="result-label">Original Polynomial</div>';
            html += '<div class="result-value">' + a + 'x² + ' + b + 'x + ' + c + '</div>';
            html += '</div>';
            
            if (success && a === 1) {
                html += '<div class="result-item">';
                html += '<div class="result-label">Factored Form</div>';
                html += '<div class="result-value" style="color: #4CAF50; font-size: 1.5em;">' + factored + '</div>';
                html += '</div>';
                
                html += '<div class="steps">';
                html += '<h4>Factoring Steps</h4>';
                html += '<ol>';
                html += '<li>Find two numbers that multiply to ' + c + ' and add to ' + b + '</li>';
                html += '<li>These numbers are found in the factored form</li>';
                html += '<li>Result: ' + factored + '</li>';
                html += '</ol>';
                html += '</div>';
            } else {
                // Use quadratic formula to find roots
                var disc = b * b - 4 * a * c;
                
                if (disc >= 0) {
                    var r1 = (-b + Math.sqrt(disc)) / (2 * a);
                    var r2 = (-b - Math.sqrt(disc)) / (2 * a);
                    
                    factored = a + '(x - ' + r1.toFixed(2) + ')(x - ' + r2.toFixed(2) + ')';
                    
                    html += '<div class="result-item">';
                    html += '<div class="result-label">Factored Form (approximate)</div>';
                    html += '<div class="result-value" style="color: #4CAF50; font-size: 1.3em;">' + factored + '</div>';
                    html += '</div>';
                } else {
                    html += '<div class="result-item">';
                    html += '<div class="result-label">Result</div>';
                    html += '<div class="result-value" style="color: #f44336;">Cannot be factored over real numbers (complex roots)</div>';
                    html += '</div>';
                }
            }
            
            document.getElementById('resultContent').innerHTML = html;
            document.getElementById('resultSection').classList.add('show');
        }
    </script>
</body>
</html>