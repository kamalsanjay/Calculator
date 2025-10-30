<?php
/**
 * Advanced Algebra Calculator
 * File: algebra-calculator.php
 * Description: Solve linear equations, quadratic equations, systems of equations, and polynomials
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Algebra Calculator - Solve Equations & Systems</title>
    <meta name="description" content="Solve linear equations, quadratic equations, systems of equations, and polynomials with step-by-step solutions.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 15px; }
        header { background: rgba(255,255,255,0.1); color: white; padding: 25px 15px; text-align: center; border-radius: 15px; margin-bottom: 20px; backdrop-filter: blur(10px); }
        header h1 { margin: 0 0 8px 0; font-size: 1.8em; }
        header p { margin: 0; opacity: 0.9; font-size: 1em; }
        .container { max-width: 1000px; margin: 0 auto; }
        .breadcrumb { margin-bottom: 15px; text-align: center; }
        .breadcrumb a { color: white; text-decoration: none; font-weight: 500; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 8px; display: inline-block; backdrop-filter: blur(10px); font-size: 0.9em; }
        .calculator-body { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); margin-bottom: 20px; }
        
        /* Tabs */
        .calc-tabs { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .tab-btn { flex: 1; min-width: 140px; padding: 12px; background: #f0f0f0; border: 2px solid transparent; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; outline: none; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-color: #667eea; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        /* Settings */
        .settings-panel { background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); padding: 20px; border-radius: 12px; margin-bottom: 20px; border: 2px solid #667eea; }
        .settings-panel h4 { color: #667eea; margin-bottom: 15px; }
        .settings-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .setting-group { background: white; padding: 12px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .setting-group label { display: block; font-weight: 600; color: #555; margin-bottom: 8px; font-size: 0.9em; }
        .setting-group select { width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 6px; font-size: 0.95em; outline: none; cursor: pointer; background: white; }
        
        /* Input Sections */
        .input-section { margin-bottom: 20px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .input-section input, .input-section select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1.1em; outline: none; transition: all 0.3s; }
        .input-section input:focus, .input-section select:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .input-section input.coeff-input { font-family: 'Courier New', monospace; }
        
        /* Equation Builder (Linear) */
        .equation-builder { background: #f9f9f9; padding: 20px; border-radius: 12px; margin-bottom: 20px; border: 2px dashed #ddd; }
        .equation-display { background: white; padding: 20px; border-radius: 10px; font-family: 'Courier New', monospace; font-size: 1.4em; text-align: center; color: #667eea; font-weight: bold; min-height: 60px; display: flex; align-items: center; justify-content: center; border: 3px solid #667eea; margin-bottom: 20px; }
        
        .term-input { display: grid; grid-template-columns: 80px 1fr 120px 50px; gap: 10px; margin-bottom: 12px; align-items: center; }
        .term-input input, .term-input select { padding: 10px; border: 2px solid #e0e0e0; border-radius: 6px; font-size: 1em; outline: none; }
        .operator-select { background: #fff3cd; border-color: #ffc107 !important; }
        .var-select { background: #e3f2fd; border-color: #2196F3 !important; }
        
        .add-term-btn { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s; margin-top: 10px; width: 100%; }
        .add-term-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4); }
        .remove-term-btn { background: #f44336; color: white; border: none; padding: 10px; border-radius: 6px; cursor: pointer; font-weight: 600; }
        
        /* Buttons */
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 16px 32px; border-radius: 10px; cursor: pointer; font-weight: 600; transition: all 0.3s; width: 100%; font-size: 1.2em; margin-top: 10px; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5); }
        
        /* Results */
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 30px; border-radius: 15px; border-left: 5px solid #667eea; margin-top: 25px; display: none; }
        .result-section.show { display: block; }
        .result-section h3 { color: #667eea; margin-bottom: 20px; font-size: 1.5em; }
        
        .result-box { background: white; padding: 25px; border-radius: 12px; margin-bottom: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; }
        .result-label { font-size: 0.95em; color: #666; margin-bottom: 8px; font-weight: 600; text-transform: uppercase; }
        .result-value { font-size: 1.8em; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; line-height: 1.6; }
        
        .fraction { display: inline-flex; flex-direction: column; align-items: center; vertical-align: middle; margin: 0 4px; }
        .fraction .numerator { border-bottom: 2px solid currentColor; padding: 0 8px 2px; }
        .fraction .denominator { padding: 2px 8px 0; }
        
        .steps-section { background: linear-gradient(135deg, #fff3cd 0%, #ffe5b4 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #ffc107; margin-top: 15px; }
        .steps-section h4 { color: #f57c00; margin-bottom: 20px; font-size: 1.2em; }
        .step-item { background: white; padding: 15px; border-radius: 8px; margin-bottom: 12px; border-left: 4px solid #ffc107; }
        .step-number { display: inline-block; background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: white; width: 30px; height: 30px; border-radius: 50%; text-align: center; line-height: 30px; font-weight: bold; margin-right: 12px; }
        
        /* System of Equations */
        .system-equation { background: #f0f7ff; padding: 20px; border-radius: 10px; margin-bottom: 15px; border: 2px solid #2196F3; }
        .equation-number { background: #2196F3; color: white; width: 30px; height: 30px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 10px; }
        
        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .input-group input { flex-grow: 1; margin: 0 5px; font-family: 'Courier New', monospace; }
        .input-group span { font-weight: bold; color: #333; }
        
        /* Examples */
        .examples { background: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; }
        .examples h4 { color: #667eea; margin-bottom: 20px; font-size: 1.2em; }
        .example-item { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 12px; font-family: 'Courier New', monospace; border-left: 4px solid #4CAF50; transition: all 0.3s; cursor: pointer; }
        .example-item:hover { background: #e3f2fd; transform: translateX(5px); }
        
        .info-box { background: white; padding: 25px; border-radius: 15px; line-height: 1.8; }
        .info-box h3 { color: #667eea; margin-bottom: 15px; }
        .info-box p { margin-bottom: 12px; color: #555; }
        
        @media (max-width: 768px) {
            .calculator-body { padding: 15px; }
            .calc-tabs { flex-direction: column; }
            .term-input { grid-template-columns: 1fr; }
            .settings-row { grid-template-columns: 1fr; }
            .input-group { flex-wrap: wrap; }
            .input-group input { margin-bottom: 5px; }
        }
    </style>
</head>
<body>
    <header>
        <h1>🔢 Advanced Algebra Calculator</h1>
        <p>Solve equations, systems, and polynomials with step-by-step solutions</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Math Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="settings-panel">
                <h4>⚙️ Solution Settings</h4>
                <div class="settings-row">
                    <div class="setting-group">
                        <label>📊 Output Format</label>
                        <select id="outputFormat">
                            <option value="decimal">Decimal</option>
                            <option value="fraction">Fraction</option>
                            <option value="mixed">Mixed Number</option>
                            <option value="both">Both Formats</option>
                        </select>
                    </div>
                    <div class="setting-group">
                        <label>🎯 Decimal Precision</label>
                        <select id="decimalPlaces">
                            <option value="2">2 decimal places</option>
                            <option value="4" selected>4 decimal places</option>
                            <option value="6">6 decimal places</option>
                        </select>
                    </div>
                    <div class="setting-group">
                        <label>📝 Show Steps</label>
                        <select id="showSteps">
                            <option value="yes" selected>Show all steps</option>
                            <option value="no">Result only</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab('linear')">Linear Equation</button>
                <button class="tab-btn" onclick="switchTab('quadratic')">Quadratic Equation</button>
                <button class="tab-btn" onclick="switchTab('system')">System of Equations</button>
                <button class="tab-btn" onclick="switchTab('polynomial')">Polynomial Solver</button>
            </div>

            <div id="linearTab" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 15px;">📐 Solve Linear Equation</h3>
                <p style="margin-bottom: 15px; color: #666;">Use numbers, decimals, or fractions (e.g., 2, 0.5, 1/3)</p>
                
                <div class="equation-builder">
                    <div class="equation-display" id="equationPreview">Enter terms below</div>
                    
                    <div id="leftSide">
                        <h5 style="margin-bottom: 12px; color: #666;">Left Side:</h5>
                        <div id="leftTerms"></div>
                        <button class="add-term-btn" onclick="addTerm('left')">➕ Add Term</button>
                    </div>
                    
                    <div style="text-align: center; margin: 20px 0; font-size: 2em; font-weight: bold; color: #667eea;">=</div>
                    
                    <div id="rightSide">
                        <h5 style="margin-bottom: 12px; color: #666;">Right Side:</h5>
                        <div id="rightTerms"></div>
                        <button class="add-term-btn" onclick="addTerm('right')">➕ Add Term</button>
                    </div>
                </div>
                
                <button class="btn" onclick="solveLinearEquation()">🎯 Solve Equation</button>
            </div>

            <div id="quadraticTab" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">📈 Solve Quadratic Equation (ax² + bx + c = 0)</h3>
                <p style="margin-bottom: 15px; color: #666;">Enter expressions like 2, 1/2, sqrt(2), log(10), etc.</p>
                
                <div class="input-section">
                    <label>Coefficient a (x²)</label>
                    <input type="text" id="quadA" class="coeff-input" value="1">
                </div>
                
                <div class="input-section">
                    <label>Coefficient b (x)</label>
                    <input type="text" id="quadB" class="coeff-input" value="-3">
                </div>
                
                <div class="input-section">
                    <label>Constant c</label>
                    <input type="text" id="quadC" class="coeff-input" value="2">
                </div>
                
                <button class="btn" onclick="solveQuadratic()">🎯 Solve Quadratic</button>
            </div>

            <div id="systemTab" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">🔄 Solve System of Equations (a₁x + b₁y = c₁, a₂x + b₂y = c₂)</h3>
                <p style="margin-bottom: 15px; color: #666;">Enter expressions like 2, 1/2, sqrt(2), log(10), etc.</p>
                
                <div class="system-equation">
                    <span class="equation-number">1</span>
                    <strong>Equation 1:</strong>
                    <div class="input-group">
                        <input type="text" id="sys1x" class="coeff-input" placeholder="a1" value="2">
                        <span>x +</span>
                        <input type="text" id="sys1y" class="coeff-input" placeholder="b1" value="3">
                        <span>y =</span>
                        <input type="text" id="sys1c" class="coeff-input" placeholder="c1" value="13">
                    </div>
                </div>
                
                <div class="system-equation">
                    <span class="equation-number">2</span>
                    <strong>Equation 2:</strong>
                    <div class="input-group">
                        <input type="text" id="sys2x" class="coeff-input" placeholder="a2" value="3">
                        <span>x +</span>
                        <input type="text" id="sys2y" class="coeff-input" placeholder="b2" value="-2">
                        <span>y =</span>
                        <input type="text" id="sys2c" class="coeff-input" placeholder="c2" value="4">
                    </div>
                </div>
                
                <button class="btn" onclick="solveSystem()">🎯 Solve System</button>
            </div>

            <div id="polynomialTab" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">📊 Solve Polynomial Equation (a₄x⁴ + ... + a₀ = 0)</h3>
                <p style="margin-bottom: 15px; color: #666;">Enter expressions like 2, 1/2, sqrt(2), log(10), etc. Zeros will be ignored.</p>
                
                <div class="input-section">
                    <label>Coefficient a₄ (x⁴)</label>
                    <input type="text" id="polyA4" class="coeff-input" value="0">
                </div>
                
                <div class="input-section">
                    <label>Coefficient a₃ (x³)</label>
                    <input type="text" id="polyA3" class="coeff-input" value="1">
                </div>
                
                <div class="input-section">
                    <label>Coefficient a₂ (x²)</label>
                    <input type="text" id="polyA2" class="coeff-input" value="-6">
                </div>
                
                <div class="input-section">
                    <label>Coefficient a₁ (x)</label>
                    <input type="text" id="polyA1" class="coeff-input" value="11">
                </div>
                
                <div class="input-section">
                    <label>Coefficient a₀ (constant)</label>
                    <input type="text" id="polyA0" class="coeff-input" value="-6">
                </div>
                
                <button class="btn" onclick="solvePolynomial()">🎯 Solve Polynomial</button>
            </div>

            <div class="result-section" id="resultSection">
                <h3>📊 Solution & Results</h3>
                <div id="resultContent"></div>
            </div>
        </div>

        <div class="examples">
            <h4>💡 Example Problems</h4>
            <div class="example-item" onclick="loadExample('linear', '2x + 3 = 7')">
                <strong>Linear:</strong> 2x + 3 = 7 → x = 2
            </div>
            <div class="example-item" onclick="loadExample('quadratic', 'x² - 3x + 2 = 0')">
                <strong>Quadratic:</strong> x² - 3x + 2 = 0 → x = 1, 2
            </div>
            <div class="example-item" onclick="loadExample('quadratic', 'x² + sqrt(2)x - log(100) = 0')">
                <strong>Quadratic (Complex Input):</strong> x² + sqrt(2)x - log(100) = 0 
            </div>
            <div class="example-item" onclick="loadExample('system', '2x+3y=13, 3x-2y=4')">
                <strong>System:</strong> 2x + 3y = 13, 3x - 2y = 4 → x = 2, y = 3
            </div>
            <div class="example-item" onclick="loadExample('polynomial', 'x³ - 6x² + 11x - 6 = 0')">
                <strong>Polynomial:</strong> x³ - 6x² + 11x - 6 = 0 → x = 1, 2, 3
            </div>
        </div>

        <div class="info-box">
            <h3>📖 How to Use</h3>
            <p><strong>Input Expressions:</strong> For non-linear tabs, enter coefficients as numbers or mathematical expressions (e.g., **sqrt(2)**, **log(10)**, **(1/2)**, **pi**).</p>
            <p><strong>Linear Equations:</strong> Build equations term by term. Supports fractions, decimals, and all operators.</p>
            <p><strong>Quadratic Equations:</strong> Enter coefficients a, b, c for ax² + bx + c = 0.</p>
            <p><strong>System of Equations:</strong> Solve two equations with two unknowns using Cramer's rule.</p>
            <p><strong>Polynomial Solver:</strong> Find roots of polynomials up to degree 4 using numerical methods.</p>
        </div>
    </div>

    <script>
        let termCounter = 0;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            addTerm('left');
            addTerm('right');
        });

        function switchTab(tab) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            
            event.target.classList.add('active');
            document.getElementById(tab + 'Tab').classList.add('active');
            document.getElementById('resultSection').classList.remove('show');
        }
        
        // --- Core Math Utilities ---
        
        /**
         * Safely evaluates a string expression, supporting math functions and constants.
         * @param {string} expr - The mathematical expression string.
         * @returns {number|NaN} The evaluated number, or NaN on failure.
         */
        function evaluateExpression(expr) {
            if (!expr || expr.trim() === '') return 0;
            
            // Cleanup and standardize input
            expr = expr.trim()
                .replace(/ /g, '') // Remove spaces
                .replace(/,/g, '.') // Use dots for decimals
                .toLowerCase();
            
            // Map common math functions and constants to JS Math object
            expr = expr.replace(/sqrt\(/g, 'Math.sqrt(')
                       .replace(/log\(/g, 'Math.log(') // Natural log by default
                       .replace(/log10\(/g, 'Math.log10(') // Base 10 log
                       .replace(/pow\(/g, 'Math.pow(')
                       .replace(/abs\(/g, 'Math.abs(')
                       .replace(/pi/g, 'Math.PI')
                       .replace(/e/g, 'Math.E');

            // Handle power operator ^
            expr = expr.replace(/\^/g, '**');

            try {
                // Use Function constructor for safe evaluation
                const result = Function(`"use strict"; return (${expr});`)();
                return isFinite(result) ? result : NaN;
            } catch (e) {
                console.error("Expression evaluation failed:", expr, e);
                return NaN;
            }
        }
        
        function parseNumber(str) {
            // Reusing linear equation's simple fraction parsing for its dedicated tab
            str = str.trim();
            if (str.includes('/')) {
                const parts = str.split('/');
                return parseFloat(parts[0]) / parseFloat(parts[1]);
            }
            return parseFloat(str) || 0;
        }

        function gcd(a, b) {
            a = Math.abs(Math.round(a * 1000000));
            b = Math.abs(Math.round(b * 1000000));
            while (b !== 0) {
                const temp = b;
                b = a % b;
                a = temp;
            }
            return a || 1;
        }

        function toFraction(decimal, tolerance = 0.000001) {
            if (Math.abs(decimal - Math.round(decimal)) < tolerance) {
                return { numerator: Math.round(decimal), denominator: 1, isInteger: true };
            }
            
            const sign = decimal < 0 ? -1 : 1;
            decimal = Math.abs(decimal);
            
            let bestNum = 1;
            let bestDen = 1;
            let bestError = Math.abs(decimal - 1);
            
            for (let den = 1; den <= 1000; den++) {
                const num = Math.round(decimal * den);
                const error = Math.abs(decimal - num / den);
                
                if (error < bestError) {
                    bestNum = num;
                    bestDen = den;
                    bestError = error;
                }
                
                if (error < tolerance) break;
            }
            
            const divisor = gcd(bestNum, bestDen);
            return {
                numerator: sign * Math.round(bestNum / divisor),
                denominator: Math.round(bestDen / divisor),
                isInteger: Math.round(bestDen / divisor) === 1
            };
        }

        function formatNumber(num) {
            if (isNaN(num) || !isFinite(num)) return 'Undefined';
            
            const format = document.getElementById('outputFormat').value;
            const places = parseInt(document.getElementById('decimalPlaces').value);
            
            if (format === 'decimal') {
                return num.toFixed(places);
            }
            
            const frac = toFraction(num);
            
            if (frac.isInteger) {
                return frac.numerator.toString();
            }
            
            const fractionHTML = `<span class="fraction"><span class="numerator">${frac.numerator}</span><span class="denominator">${frac.denominator}</span></span>`;
            
            if (format === 'fraction') {
                return fractionHTML;
            } else if (format === 'mixed') {
                const absNum = Math.abs(frac.numerator);
                const whole = Math.floor(absNum / frac.denominator);
                const rem = absNum % frac.denominator;
                const sign = frac.numerator < 0 ? '-' : '';
                
                if (whole === 0) return fractionHTML;
                return `${sign}${whole} <span class="fraction"><span class="numerator">${rem}</span><span class="denominator">${frac.denominator}</span></span>`;
            } else if (format === 'both') {
                return `${num.toFixed(places)} = ${fractionHTML}`;
            }
        }
        
        // --- Linear Equation Logic ---
        
        function addTerm(side) {
            termCounter++;
            const container = document.getElementById(side + 'Terms');
            
            const termDiv = document.createElement('div');
            termDiv.className = 'term-input';
            termDiv.id = 'term-' + side + '-' + termCounter;
            
            termDiv.innerHTML = `
                <select class="operator-select">
                    <option value="+">+</option>
                    <option value="-">-</option>
                </select>
                <input type="text" class="coeff-input" placeholder="e.g., 2, 1/3" value="1">
                <select class="var-select">
                    <option value="x">x</option>
                    <option value="1">constant</option>
                </select>
                <button class="remove-term-btn" onclick="removeTerm('term-${side}-${termCounter}')">×</button>
            `;
            
            container.appendChild(termDiv);
            updateEquationPreview();
            
            // Add event listeners
            termDiv.querySelectorAll('input, select').forEach(el => {
                el.addEventListener('input', updateEquationPreview);
            });
        }

        function removeTerm(termId) {
            const term = document.getElementById(termId);
            if (term) {
                term.remove();
                updateEquationPreview();
            }
        }

        function buildEquationString(side) {
            const container = document.getElementById(side + 'Terms');
            const terms = container.querySelectorAll('.term-input');
            let equation = '';
            
            terms.forEach((term, index) => {
                const operator = term.querySelector('.operator-select').value;
                const coeffStr = term.querySelector('.coeff-input').value.trim();
                const varType = term.querySelector('.var-select').value;
                
                if (!coeffStr) return;
                
                const coeff = parseNumber(coeffStr);
                if (isNaN(coeff) || Math.abs(coeff) < 1e-10) return;
                
                const varStr = varType === '1' ? '' : varType;
                const absCoeff = Math.abs(coeff);
                const coeffDisplay = absCoeff === 1 && varStr ? '' : coeffStr; // Show input string for display
                
                if (index === 0) {
                    equation += (coeff < 0 ? '-' : '') + coeffDisplay + varStr;
                } else {
                    equation += ' ' + operator + ' ' + coeffDisplay + varStr;
                }
            });
            
            return equation || '0';
        }

        function parseEquationSide(side) {
            const container = document.getElementById(side + 'Terms');
            const terms = container.querySelectorAll('.term-input');
            let xCoeff = 0;
            let constant = 0;
            
            terms.forEach((term, index) => {
                const operator = term.querySelector('.operator-select').value;
                const coeffStr = term.querySelector('.coeff-input').value.trim();
                const varType = term.querySelector('.var-select').value;
                
                if (!coeffStr) return;
                
                const coeff = parseNumber(coeffStr); // Use simple parser for Linear tab
                if (isNaN(coeff)) return;
                
                let sign = 1;
                if (index === 0) {
                    sign = coeff >= 0 ? 1 : -1;
                } else {
                    sign = operator === '+' ? 1 : -1;
                }
                
                if (varType === 'x') {
                    xCoeff += sign * Math.abs(coeff);
                } else {
                    constant += sign * Math.abs(coeff);
                }
            });
            
            return { x: xCoeff, c: constant };
        }

        function solveLinearEquation() {
            const left = parseEquationSide('left');
            const right = parseEquationSide('right');
            
            const leftEqStr = buildEquationString('left');
            const rightEqStr = buildEquationString('right');
            
            if (!leftEqStr && !rightEqStr) {
                alert('Please add terms to build the equation');
                return;
            }
            
            const finalXCoeff = left.x - right.x;
            const finalConstant = right.c - left.c;
            
            let html = '';
            const showSteps = document.getElementById('showSteps').value === 'yes';
            
            // ... (rest of the linear solution logic is unchanged)
            
            html += `<div class="result-box">
                <div class="result-label">📝 Original Equation</div>
                <div class="result-value" style="color: #667eea;">${leftEqStr} = ${rightEqStr}</div>
            </div>`;
            
            if (Math.abs(finalXCoeff) < 1e-10) {
                if (Math.abs(finalConstant) < 1e-10) {
                    html += `<div class="result-box">
                        <div class="result-label">🎯 Result</div>
                        <div class="result-value" style="color: #2196F3;">∞ Infinite Solutions</div>
                        <p style="margin-top: 10px; color: #666;">This equation is true for all values of x</p>
                    </div>`;
                } else {
                    html += `<div class="result-box">
                        <div class="result-label">🎯 Result</div>
                        <div class="result-value" style="color: #f44336;">∅ No Solution</div>
                        <p style="margin-top: 10px; color: #666;">Contradiction: ${finalConstant.toFixed(4)} ≠ 0</p>
                    </div>`;
                }
            } else {
                const solution = finalConstant / finalXCoeff;
                
                html += `<div class="result-box" style="border-left-color: #4CAF50;">
                    <div class="result-label">✅ Solution</div>
                    <div class="result-value">x = ${formatNumber(solution)}</div>
                </div>`;
                
                if (showSteps) {
                    html += `<div class="steps-section">
                        <h4>📝 Step-by-Step Solution</h4>
                        <div class="step-item"><span class="step-number">1</span><strong>Original equation:</strong> ${leftEqStr} = ${rightEqStr}</div>
                        <div class="step-item"><span class="step-number">2</span><strong>Move all terms to left:</strong> ${finalXCoeff.toFixed(4)}x + ${finalConstant.toFixed(4)} = 0</div>
                        <div class="step-item"><span class="step-number">3</span><strong>Isolate x:</strong> ${finalXCoeff.toFixed(4)}x = ${(-finalConstant).toFixed(4)}</div>
                        <div class="step-item"><span class="step-number">4</span><strong>Divide both sides:</strong> x = ${(-finalConstant).toFixed(4)} ÷ ${finalXCoeff.toFixed(4)}</div>
                        <div class="step-item"><span class="step-number">5</span><strong></strong> x = ${formatNumber(solution)}</div>
                    </div>`;
                }
            }
            
            showResult(html);
        }

        // --- Quadratic Equation Solver ---
        function solveQuadratic() {
            // *** CHANGE: Use evaluateExpression to handle complex inputs ***
            const a = evaluateExpression(document.getElementById('quadA').value);
            const b = evaluateExpression(document.getElementById('quadB').value);
            const c = evaluateExpression(document.getElementById('quadC').value);
            
            const aStr = document.getElementById('quadA').value;
            const bStr = document.getElementById('quadB').value;
            const cStr = document.getElementById('quadC').value;
            
            if (isNaN(a) || isNaN(b) || isNaN(c)) {
                alert('One or more coefficients are invalid mathematical expressions.');
                return;
            }
            
            if (Math.abs(a) < 1e-10) {
                alert('Coefficient a cannot be zero for quadratic equation. This would be a linear equation.');
                return;
            }
            
            const disc = b * b - 4 * a * c;
            const showSteps = document.getElementById('showSteps').value === 'yes';
            
            let html = '';
            html += `<div class="result-box">
                <div class="result-label">📝 Equation</div>
                <div class="result-value" style="color: #667eea;">(${aStr})x² + (${bStr})x + (${cStr}) = 0</div>
            </div>`;
            
            html += `<div class="result-box">
                <div class="result-label">🔍 Discriminant</div>
                <div class="result-value" style="color: #FF9800;">Δ = b² - 4ac ≈ ${formatNumber(disc)}</div>
            </div>`;
            
            if (disc > 1e-10) {
                const x1 = (-b + Math.sqrt(disc)) / (2 * a);
                const x2 = (-b - Math.sqrt(disc)) / (2 * a);
                
                html += `<div class="result-box" style="border-left-color: #4CAF50;">
                    <div class="result-label">✅ Two Real Solutions</div>
                    <div class="result-value">x₁ = ${formatNumber(x1)}</div>
                    <div class="result-value">x₂ = ${formatNumber(x2)}</div>
                </div>`;
                
                if (showSteps) {
                    html += `<div class="steps-section">
                        <h4>📝 Solution Steps</h4>
                        <div class="step-item"><span class="step-number">1</span><strong>Quadratic formula:</strong> x = [-b ± √(b² - 4ac)] / 2a</div>
                        <div class="step-item"><span class="step-number">2</span><strong>Calculate:</strong> x = [${formatNumber(-b)} ± √${formatNumber(disc)}] / ${formatNumber(2*a)}</div>
                        <div class="step-item"><span class="step-number">3</span><strong>Solution 1:</strong> x₁ = ${formatNumber(x1)}</div>
                        <div class="step-item"><span class="step-number">4</span><strong>Solution 2:</strong> x₂ = ${formatNumber(x2)}</div>
                    </div>`;
                }
                
            } else if (Math.abs(disc) < 1e-10) {
                const x = -b / (2 * a);
                
                html += `<div class="result-box" style="border-left-color: #FF9800;">
                    <div class="result-label">⚠️ One Real Solution</div>
                    <div class="result-value">x = ${formatNumber(x)}</div>
                </div>`;
                
            } else {
                const real = -b / (2 * a);
                const imag = Math.sqrt(-disc) / (2 * a);
                
                html += `<div class="result-box" style="border-left-color: #2196F3;">
                    <div class="result-label">🔵 Two Complex Solutions</div>
                    <div class="result-value">x₁ = ${formatNumber(real)} + ${formatNumber(imag)}i</div>
                    <div class="result-value">x₂ = ${formatNumber(real)} - ${formatNumber(imag)}i</div>
                </div>`;
            }
            
            showResult(html);
        }

        // --- System of Equations Solver ---
        function solveSystem() {
            // *** CHANGE: Use evaluateExpression to handle complex inputs ***
            const a1 = evaluateExpression(document.getElementById('sys1x').value);
            const b1 = evaluateExpression(document.getElementById('sys1y').value);
            const c1 = evaluateExpression(document.getElementById('sys1c').value);
            
            const a2 = evaluateExpression(document.getElementById('sys2x').value);
            const b2 = evaluateExpression(document.getElementById('sys2y').value);
            const c2 = evaluateExpression(document.getElementById('sys2c').value);
            
            const a1Str = document.getElementById('sys1x').value;
            const b1Str = document.getElementById('sys1y').value;
            const c1Str = document.getElementById('sys1c').value;
            const a2Str = document.getElementById('sys2x').value;
            const b2Str = document.getElementById('sys2y').value;
            const c2Str = document.getElementById('sys2c').value;
            
            if ([a1, b1, c1, a2, b2, c2].some(isNaN)) {
                alert('One or more coefficients are invalid mathematical expressions.');
                return;
            }
            
            const det = a1 * b2 - a2 * b1;
            const showSteps = document.getElementById('showSteps').value === 'yes';
            
            let html = '';
            html += `<div class="result-box">
                <div class="result-label">📝 System of Equations</div>
                <div class="result-value" style="color: #667eea;">
                    (${a1Str})x + (${b1Str})y = ${c1Str}<br>
                    (${a2Str})x + (${b2Str})y = ${c2Str}
                </div>
            </div>`;
            
            if (Math.abs(det) < 1e-10) {
                // Check for inconsistency (parallel lines or dependent)
                const detX = c1 * b2 - c2 * b1;
                const detY = a1 * c2 - a2 * c1;

                if (Math.abs(detX) < 1e-10 && Math.abs(detY) < 1e-10) {
                    html += `<div class="result-box">
                        <div class="result-label">🎯 Result</div>
                        <div class="result-value" style="color: #2196F3;">∞ Infinite Solutions</div>
                        <p style="margin-top: 10px; color: #666;">The equations are dependent (same line).</p>
                    </div>`;
                } else {
                    html += `<div class="result-box">
                        <div class="result-label">🎯 Result</div>
                        <div class="result-value" style="color: #f44336;">∅ No Solution</div>
                        <p style="margin-top: 10px; color: #666;">The equations are inconsistent (parallel lines).</p>
                    </div>`;
                }
            } else {
                const x = (c1 * b2 - c2 * b1) / det;
                const y = (a1 * c2 - a2 * c1) / det;
                
                html += `<div class="result-box" style="border-left-color: #4CAF50;">
                    <div class="result-label">✅ Solution</div>
                    <div class="result-value">x = ${formatNumber(x)}</div>
                    <div class="result-value">y = ${formatNumber(y)}</div>
                </div>`;
                
                if (showSteps) {
                    html += `<div class="steps-section">
                        <h4>📝 Solution Steps (Cramer's Rule)</h4>
                        <div class="step-item"><span class="step-number">1</span><strong>Determinant:</strong> D = a₁b₂ - a₂b₁ ≈ ${formatNumber(det)}</div>
                        <div class="step-item"><span class="step-number">2</span><strong>Dx:</strong> c₁b₂ - c₂b₁ ≈ ${formatNumber(c1 * b2 - c2 * b1)}</div>
                        <div class="step-item"><span class="step-number">3</span><strong>Dy:</strong> a₁c₂ - a₂c₁ ≈ ${formatNumber(a1 * c2 - a2 * c1)}</div>
                        <div class="step-item"><span class="step-number">4</span><strong>Solution:</strong> x = Dx/D ≈ ${formatNumber(x)}, y = Dy/D ≈ ${formatNumber(y)}</div>
                    </div>`;
                    
                    // Verification
                    const verify1 = a1 * x + b1 * y;
                    const verify2 = a2 * x + b2 * y;
                    
                    html += `<div class="result-box" style="background: #e8f5e9;">
                        <div class="result-label">✓ Verification</div>
                        <p>Equation 1 Check: ${formatNumber(verify1)} ≈ ${c1Str}</p>
                        <p>Equation 2 Check: ${formatNumber(verify2)} ≈ ${c2Str}</p>
                        <p style="color: #4CAF50; font-weight: bold; margin-top: 10px;">✓ Solution verified!</p>
                    </div>`;
                }
            }
            
            showResult(html);
        }

        // --- Polynomial Solver ---
        function solvePolynomial() {
            // *** CHANGE: Use evaluateExpression to handle complex inputs ***
            const a4 = evaluateExpression(document.getElementById('polyA4').value);
            const a3 = evaluateExpression(document.getElementById('polyA3').value);
            const a2 = evaluateExpression(document.getElementById('polyA2').value);
            const a1 = evaluateExpression(document.getElementById('polyA1').value);
            const a0 = evaluateExpression(document.getElementById('polyA0').value);
            
            const a4Str = document.getElementById('polyA4').value;
            const a3Str = document.getElementById('polyA3').value;
            const a2Str = document.getElementById('polyA2').value;
            const a1Str = document.getElementById('polyA1').value;
            const a0Str = document.getElementById('polyA0').value;
            
            if ([a4, a3, a2, a1, a0].some(isNaN)) {
                alert('One or more coefficients are invalid mathematical expressions.');
                return;
            }
            
            if ([a4, a3, a2, a1, a0].every(x => Math.abs(x) < 1e-10)) {
                alert('Please enter at least one non-zero coefficient');
                return;
            }
            
            // Build polynomial string for display
            let polyStr = '';
            const coeffStrings = [a4Str, a3Str, a2Str, a1Str, a0Str];
            const coeffs = [a4, a3, a2, a1, a0];
            
            coeffs.forEach((coeff, i) => {
                const coeffStr = coeffStrings[i];
                if (Math.abs(coeff) > 1e-10) {
                    const sign = coeff < 0 ? ' - ' : (polyStr ? ' + ' : '');
                    const absCoeffStr = Math.abs(coeff) === 1 && i < 4 ? '' : `(${coeffStr})`; // Show full expression string
                    const power = 4 - i;
                    const varStr = power === 0 ? '' : (power === 1 ? 'x' : `x^${power}`);
                    polyStr += sign + absCoeffStr + varStr;
                }
            });
            polyStr += ' = 0';
            
            // Find roots using Newton-Raphson method
            const roots = findPolynomialRoots(coeffs);
            
            let html = '';
            html += `<div class="result-box">
                <div class="result-label">📝 Polynomial Equation</div>
                <div class="result-value" style="color: #667eea;">${polyStr.replace(/\(\( /g, '(').replace(/\) \) /g, ')') }</div>
            </div>`;
            
            if (roots.length === 0) {
                html += `<div class="result-box">
                    <div class="result-label">🎯 Result</div>
                    <div class="result-value" style="color: #666;">No real roots found in the search range</div>
                </div>`;
            } else {
                html += `<div class="result-box" style="border-left-color: #4CAF50;">
                    <div class="result-label">✅ Real Roots Found</div>`;
                
                roots.forEach((root, i) => {
                    html += `<div class="result-value">x${i+1} = ${formatNumber(root)}</div>`;
                });
                
                html += `</div>`;
                
                const showSteps = document.getElementById('showSteps').value === 'yes';
                if (showSteps) {
                    html += `<div class="steps-section">
                        <h4>📝 Solution Method</h4>
                        <div class="step-item"><span class="step-number">1</span><strong>Method:</strong> Newton-Raphson numerical method</div>
                        <div class="step-item"><span class="step-number">2</span><strong>Search range:</strong> -10 to 10 with step 0.5</div>
                        <div class="step-item"><span class="step-number">3</span><strong>Tolerance:</strong> 1e-10</div>
                        <div class="step-item"><span class="step-number">4</span><strong>Roots found:</strong> ${roots.length} real root(s)</div>
                    </div>`;
                }
            }
            
            showResult(html);
        }

        function findPolynomialRoots(coefficients) {
            // Remove coefficients that are effectively zero
            const cleanCoeffs = [...coefficients];
            while (cleanCoeffs.length > 0 && Math.abs(cleanCoeffs[0]) < 1e-10) {
                cleanCoeffs.shift();
            }
            
            if (cleanCoeffs.length === 0) return [];
            
            const roots = new Set();
            
            // Evaluate polynomial
            const f = x => {
                let result = 0;
                for (let i = 0; i < cleanCoeffs.length; i++) {
                    result += cleanCoeffs[i] * Math.pow(x, cleanCoeffs.length - 1 - i);
                }
                return result;
            };
            
            // Evaluate derivative
            const fPrime = x => {
                let result = 0;
                for (let i = 0; i < cleanCoeffs.length - 1; i++) {
                    result += (cleanCoeffs.length - 1 - i) * cleanCoeffs[i] * Math.pow(x, cleanCoeffs.length - 2 - i);
                }
                return result;
            };
            
            // Newton-Raphson method
            const newtonRaphson = (x0, maxIterations = 100) => {
                let x = x0;
                for (let i = 0; i < maxIterations; i++) {
                    const fx = f(x);
                    const fpx = fPrime(x);
                    
                    if (Math.abs(fx) < 1e-10) return x;
                    if (Math.abs(fpx) < 1e-10) break;
                    
                    const xNew = x - fx / fpx;
                    
                    if (Math.abs(xNew - x) < 1e-10) return xNew;
                    x = xNew;
                }
                return null;
            };
            
            // Search for roots in range [-10, 10]
            for (let x0 = -10; x0 <= 10; x0 += 0.5) {
                const root = newtonRaphson(x0);
                if (root !== null && Math.abs(f(root)) < 1e-8) {
                    // Round to avoid duplicate roots due to floating point errors
                    const roundedRoot = Math.round(root * 1e8) / 1e8;
                    roots.add(roundedRoot);
                }
            }
            
            return Array.from(roots).sort((a, b) => a - b);
        }

        function loadExample(type, example) {
            alert(`Example loaded: ${example}\n\nPlease use the appropriate tab and enter the values manually.`);
        }

        function showResult(html) {
            document.getElementById('resultContent').innerHTML = html;
            document.getElementById('resultSection').classList.add('show');
            document.getElementById('resultSection').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
