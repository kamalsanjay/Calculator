<?php
/**
 * Fraction Calculator
 * File: fraction-calculator.php
 * Description: Perform fraction operations with step-by-step solutions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fraction Calculator - Add, Subtract, Multiply & Divide Fractions</title>
    <meta name="description" content="Perform fraction operations with step-by-step solutions. Add, subtract, multiply, and divide fractions.">
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
        
        .fraction-input-group {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 10px;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .fraction-input {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .fraction-input input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            text-align: center;
            outline: none;
            transition: all 0.3s;
        }
        
        .fraction-input input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .fraction-line {
            width: 100%;
            height: 2px;
            background: #333;
            margin: 5px 0;
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
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); 
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
            word-break: break-word; 
            line-height: 1.5; 
            text-align: center;
        }
        
        .fraction-display {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            margin: 0 10px;
            vertical-align: middle;
        }
        
        .fraction-numerator {
            border-bottom: 2px solid currentColor;
            padding: 0 15px 2px;
            font-size: 1.3em;
        }
        
        .fraction-denominator {
            padding: 2px 15px 0;
            font-size: 1.3em;
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
        
        @media (max-width: 600px) {
            .examples { 
                grid-template-columns: 1fr; 
            }
            .result-value { 
                font-size: 1.2rem; 
            }
            .fraction-input-group {
                grid-template-columns: 1fr;
                gap: 15px;
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
            <h1>🔢 Fraction Calculator</h1>
            <p>Add, Subtract, Multiply & Divide Fractions</p>
        </header>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Addition</button>
                <button class="tab-btn" onclick="switchTab(1)">Subtraction</button>
                <button class="tab-btn" onclick="switchTab(2)">Multiplication</button>
                <button class="tab-btn" onclick="switchTab(3)">Division</button>
                <button class="tab-btn" onclick="switchTab(4)">Simplify</button>
            </div>

            <!-- Tab 1: Addition -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 15px;">➕ Fraction Addition</h3>
                
                <div class="input-section">
                    <label>First Fraction</label>
                    <div class="fraction-input-group">
                        <div class="fraction-input">
                            <input type="number" id="add_num1" value="1" placeholder="Numerator">
                            <div class="fraction-line"></div>
                            <input type="number" id="add_den1" value="2" placeholder="Denominator">
                        </div>
                        
                        <select class="operator-select" id="add_operator">
                            <option value="+">+</option>
                        </select>
                        
                        <div class="fraction-input">
                            <input type="number" id="add_num2" value="1" placeholder="Numerator">
                            <div class="fraction-line"></div>
                            <input type="number" id="add_den2" value="3" placeholder="Denominator">
                        </div>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateAddition()">Calculate Addition</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="setAddition(1,2,1,3)">1/2 + 1/3</button>
                    <button class="example-btn" onclick="setAddition(3,4,1,8)">3/4 + 1/8</button>
                    <button class="example-btn" onclick="setAddition(2,5,3,7)">2/5 + 3/7</button>
                    <button class="example-btn" onclick="setAddition(5,6,1,6)">5/6 + 1/6</button>
                </div>
            </div>

            <!-- Tab 2: Subtraction -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">➖ Fraction Subtraction</h3>
                
                <div class="input-section">
                    <label>First Fraction</label>
                    <div class="fraction-input-group">
                        <div class="fraction-input">
                            <input type="number" id="sub_num1" value="3" placeholder="Numerator">
                            <div class="fraction-line"></div>
                            <input type="number" id="sub_den1" value="4" placeholder="Denominator">
                        </div>
                        
                        <select class="operator-select" id="sub_operator">
                            <option value="-">-</option>
                        </select>
                        
                        <div class="fraction-input">
                            <input type="number" id="sub_num2" value="1" placeholder="Numerator">
                            <div class="fraction-line"></div>
                            <input type="number" id="sub_den2" value="4" placeholder="Denominator">
                        </div>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateSubtraction()">Calculate Subtraction</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="setSubtraction(3,4,1,4)">3/4 - 1/4</button>
                    <button class="example-btn" onclick="setSubtraction(5,6,1,3)">5/6 - 1/3</button>
                    <button class="example-btn" onclick="setSubtraction(7,8,1,2)">7/8 - 1/2</button>
                    <button class="example-btn" onclick="setSubtraction(4,5,2,7)">4/5 - 2/7</button>
                </div>
            </div>

            <!-- Tab 3: Multiplication -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">✖️ Fraction Multiplication</h3>
                
                <div class="input-section">
                    <label>First Fraction</label>
                    <div class="fraction-input-group">
                        <div class="fraction-input">
                            <input type="number" id="mul_num1" value="2" placeholder="Numerator">
                            <div class="fraction-line"></div>
                            <input type="number" id="mul_den1" value="3" placeholder="Denominator">
                        </div>
                        
                        <select class="operator-select" id="mul_operator">
                            <option value="×">×</option>
                        </select>
                        
                        <div class="fraction-input">
                            <input type="number" id="mul_num2" value="3" placeholder="Numerator">
                            <div class="fraction-line"></div>
                            <input type="number" id="mul_den2" value="4" placeholder="Denominator">
                        </div>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateMultiplication()">Calculate Multiplication</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="setMultiplication(2,3,3,4)">2/3 × 3/4</button>
                    <button class="example-btn" onclick="setMultiplication(1,2,2,5)">1/2 × 2/5</button>
                    <button class="example-btn" onclick="setMultiplication(3,5,5,6)">3/5 × 5/6</button>
                    <button class="example-btn" onclick="setMultiplication(4,7,2,3)">4/7 × 2/3</button>
                </div>
            </div>

            <!-- Tab 4: Division -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">➗ Fraction Division</h3>
                
                <div class="input-section">
                    <label>First Fraction</label>
                    <div class="fraction-input-group">
                        <div class="fraction-input">
                            <input type="number" id="div_num1" value="2" placeholder="Numerator">
                            <div class="fraction-line"></div>
                            <input type="number" id="div_den1" value="3" placeholder="Denominator">
                        </div>
                        
                        <select class="operator-select" id="div_operator">
                            <option value="÷">÷</option>
                        </select>
                        
                        <div class="fraction-input">
                            <input type="number" id="div_num2" value="3" placeholder="Numerator">
                            <div class="fraction-line"></div>
                            <input type="number" id="div_den2" value="4" placeholder="Denominator">
                        </div>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateDivision()">Calculate Division</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="setDivision(2,3,3,4)">2/3 ÷ 3/4</button>
                    <button class="example-btn" onclick="setDivision(5,6,2,3)">5/6 ÷ 2/3</button>
                    <button class="example-btn" onclick="setDivision(3,4,1,2)">3/4 ÷ 1/2</button>
                    <button class="example-btn" onclick="setDivision(7,8,3,4)">7/8 ÷ 3/4</button>
                </div>
            </div>

            <!-- Tab 5: Simplify -->
            <div id="tab4" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">🔧 Simplify Fraction</h3>
                
                <div class="input-section">
                    <label>Fraction to Simplify</label>
                    <div class="fraction-input-group" style="grid-template-columns: 1fr; justify-items: center;">
                        <div class="fraction-input">
                            <input type="number" id="sim_num" value="4" placeholder="Numerator">
                            <div class="fraction-line"></div>
                            <input type="number" id="sim_den" value="8" placeholder="Denominator">
                        </div>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateSimplify()">Simplify Fraction</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="setSimplify(4,8)">4/8</button>
                    <button class="example-btn" onclick="setSimplify(9,12)">9/12</button>
                    <button class="example-btn" onclick="setSimplify(15,25)">15/25</button>
                    <button class="example-btn" onclick="setSimplify(18,24)">18/24</button>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Solution</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Fraction Operations Guide</h3>
            <div class="formula-box">
                <strong>Addition & Subtraction:</strong>
                a/b ± c/d = (a×d ± b×c) / (b×d)<br>
                Find common denominator, then add/subtract numerators
            </div>
            <div class="formula-box">
                <strong>Multiplication:</strong>
                a/b × c/d = (a×c) / (b×d)<br>
                Multiply numerators and denominators directly
            </div>
            <div class="formula-box">
                <strong>Division:</strong>
                a/b ÷ c/d = (a×d) / (b×c)<br>
                Multiply by the reciprocal of the second fraction
            </div>
            <div class="formula-box">
                <strong>Simplification:</strong>
                Find GCD of numerator and denominator, divide both by GCD<br>
                Example: 4/8 = 1/2 (GCD of 4 and 8 is 4)
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
        
        // Show results
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
            document.getElementById('result').scrollIntoView({behavior: 'smooth', block: 'nearest'});
        }
        
        // Math utility functions
        function gcd(a, b) {
            a = Math.abs(a);
            b = Math.abs(b);
            while (b !== 0) {
                const temp = b;
                b = a % b;
                a = temp;
            }
            return a;
        }
        
        function simplifyFraction(numerator, denominator) {
            if (denominator === 0) return { numerator: 0, denominator: 1 };
            
            const divisor = gcd(numerator, denominator);
            const simplifiedNum = numerator / divisor;
            const simplifiedDen = denominator / divisor;
            
            // Handle negative signs
            if (simplifiedDen < 0) {
                return { numerator: -simplifiedNum, denominator: -simplifiedDen };
            }
            return { numerator: simplifiedNum, denominator: simplifiedDen };
        }
        
        function formatFraction(numerator, denominator) {
            if (denominator === 1) {
                return numerator.toString();
            }
            if (numerator === 0) {
                return '0';
            }
            return `<span class="fraction-display">
                <span class="fraction-numerator">${numerator}</span>
                <span class="fraction-denominator">${denominator}</span>
            </span>`;
        }
        
        // Example setters
        function setAddition(num1, den1, num2, den2) {
            document.getElementById('add_num1').value = num1;
            document.getElementById('add_den1').value = den1;
            document.getElementById('add_num2').value = num2;
            document.getElementById('add_den2').value = den2;
        }
        
        function setSubtraction(num1, den1, num2, den2) {
            document.getElementById('sub_num1').value = num1;
            document.getElementById('sub_den1').value = den1;
            document.getElementById('sub_num2').value = num2;
            document.getElementById('sub_den2').value = den2;
        }
        
        function setMultiplication(num1, den1, num2, den2) {
            document.getElementById('mul_num1').value = num1;
            document.getElementById('mul_den1').value = den1;
            document.getElementById('mul_num2').value = num2;
            document.getElementById('mul_den2').value = den2;
        }
        
        function setDivision(num1, den1, num2, den2) {
            document.getElementById('div_num1').value = num1;
            document.getElementById('div_den1').value = den1;
            document.getElementById('div_num2').value = num2;
            document.getElementById('div_den2').value = den2;
        }
        
        function setSimplify(num, den) {
            document.getElementById('sim_num').value = num;
            document.getElementById('sim_den').value = den;
        }
        
        // Calculation functions
        function calculateAddition() {
            const num1 = parseInt(document.getElementById('add_num1').value);
            const den1 = parseInt(document.getElementById('add_den1').value);
            const num2 = parseInt(document.getElementById('add_num2').value);
            const den2 = parseInt(document.getElementById('add_den2').value);
            
            if (isNaN(num1) || isNaN(den1) || isNaN(num2) || isNaN(den2) || den1 === 0 || den2 === 0) {
                alert('⚠️ Please enter valid numbers (denominators cannot be zero)');
                return;
            }
            
            const commonDenominator = den1 * den2;
            const newNum1 = num1 * den2;
            const newNum2 = num2 * den1;
            const resultNum = newNum1 + newNum2;
            
            const simplified = simplifyFraction(resultNum, commonDenominator);
            const decimalValue = resultNum / commonDenominator;
            
            let html = `<div class="result-box">
                <div class="result-label">Problem</div>
                <div class="result-value">${formatFraction(num1, den1)} + ${formatFraction(num2, den2)}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Solution</div>
                <div class="result-value" style="color:#2196F3;">${formatFraction(simplified.numerator, simplified.denominator)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Step-by-Step Solution:</strong>
                <div class="step">Step 1: Find common denominator: ${den1} × ${den2} = ${commonDenominator}</div>
                <div class="step">Step 2: Convert fractions: ${formatFraction(num1, den1)} = ${formatFraction(newNum1, commonDenominator)}, ${formatFraction(num2, den2)} = ${formatFraction(newNum2, commonDenominator)}</div>
                <div class="step">Step 3: Add numerators: ${newNum1} + ${newNum2} = ${resultNum}</div>
                <div class="step">Step 4: Result: ${formatFraction(resultNum, commonDenominator)}</div>
                <div class="step">Step 5: Simplify: ${formatFraction(resultNum, commonDenominator)} = ${formatFraction(simplified.numerator, simplified.denominator)}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Decimal Value:</strong> ${decimalValue.toFixed(6)}
            </div>`;
            
            show(html);
        }
        
        function calculateSubtraction() {
            const num1 = parseInt(document.getElementById('sub_num1').value);
            const den1 = parseInt(document.getElementById('sub_den1').value);
            const num2 = parseInt(document.getElementById('sub_num2').value);
            const den2 = parseInt(document.getElementById('sub_den2').value);
            
            if (isNaN(num1) || isNaN(den1) || isNaN(num2) || isNaN(den2) || den1 === 0 || den2 === 0) {
                alert('⚠️ Please enter valid numbers (denominators cannot be zero)');
                return;
            }
            
            const commonDenominator = den1 * den2;
            const newNum1 = num1 * den2;
            const newNum2 = num2 * den1;
            const resultNum = newNum1 - newNum2;
            
            const simplified = simplifyFraction(resultNum, commonDenominator);
            const decimalValue = resultNum / commonDenominator;
            
            let html = `<div class="result-box">
                <div class="result-label">Problem</div>
                <div class="result-value">${formatFraction(num1, den1)} - ${formatFraction(num2, den2)}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Solution</div>
                <div class="result-value" style="color:#2196F3;">${formatFraction(simplified.numerator, simplified.denominator)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Step-by-Step Solution:</strong>
                <div class="step">Step 1: Find common denominator: ${den1} × ${den2} = ${commonDenominator}</div>
                <div class="step">Step 2: Convert fractions: ${formatFraction(num1, den1)} = ${formatFraction(newNum1, commonDenominator)}, ${formatFraction(num2, den2)} = ${formatFraction(newNum2, commonDenominator)}</div>
                <div class="step">Step 3: Subtract numerators: ${newNum1} - ${newNum2} = ${resultNum}</div>
                <div class="step">Step 4: Result: ${formatFraction(resultNum, commonDenominator)}</div>
                <div class="step">Step 5: Simplify: ${formatFraction(resultNum, commonDenominator)} = ${formatFraction(simplified.numerator, simplified.denominator)}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Decimal Value:</strong> ${decimalValue.toFixed(6)}
            </div>`;
            
            show(html);
        }
        
        function calculateMultiplication() {
            const num1 = parseInt(document.getElementById('mul_num1').value);
            const den1 = parseInt(document.getElementById('mul_den1').value);
            const num2 = parseInt(document.getElementById('mul_num2').value);
            const den2 = parseInt(document.getElementById('mul_den2').value);
            
            if (isNaN(num1) || isNaN(den1) || isNaN(num2) || isNaN(den2) || den1 === 0 || den2 === 0) {
                alert('⚠️ Please enter valid numbers (denominators cannot be zero)');
                return;
            }
            
            const resultNum = num1 * num2;
            const resultDen = den1 * den2;
            
            const simplified = simplifyFraction(resultNum, resultDen);
            const decimalValue = resultNum / resultDen;
            
            let html = `<div class="result-box">
                <div class="result-label">Problem</div>
                <div class="result-value">${formatFraction(num1, den1)} × ${formatFraction(num2, den2)}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Solution</div>
                <div class="result-value" style="color:#2196F3;">${formatFraction(simplified.numerator, simplified.denominator)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Step-by-Step Solution:</strong>
                <div class="step">Step 1: Multiply numerators: ${num1} × ${num2} = ${resultNum}</div>
                <div class="step">Step 2: Multiply denominators: ${den1} × ${den2} = ${resultDen}</div>
                <div class="step">Step 3: Result: ${formatFraction(resultNum, resultDen)}</div>
                <div class="step">Step 4: Simplify: ${formatFraction(resultNum, resultDen)} = ${formatFraction(simplified.numerator, simplified.denominator)}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Decimal Value:</strong> ${decimalValue.toFixed(6)}
            </div>`;
            
            show(html);
        }
        
        function calculateDivision() {
            const num1 = parseInt(document.getElementById('div_num1').value);
            const den1 = parseInt(document.getElementById('div_den1').value);
            const num2 = parseInt(document.getElementById('div_num2').value);
            const den2 = parseInt(document.getElementById('div_den2').value);
            
            if (isNaN(num1) || isNaN(den1) || isNaN(num2) || isNaN(den2) || den1 === 0 || den2 === 0 || num2 === 0) {
                alert('⚠️ Please enter valid numbers (denominators and second numerator cannot be zero)');
                return;
            }
            
            const resultNum = num1 * den2;
            const resultDen = den1 * num2;
            
            const simplified = simplifyFraction(resultNum, resultDen);
            const decimalValue = resultNum / resultDen;
            
            let html = `<div class="result-box">
                <div class="result-label">Problem</div>
                <div class="result-value">${formatFraction(num1, den1)} ÷ ${formatFraction(num2, den2)}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Solution</div>
                <div class="result-value" style="color:#2196F3;">${formatFraction(simplified.numerator, simplified.denominator)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Step-by-Step Solution:</strong>
                <div class="step">Step 1: Reciprocal of second fraction: ${formatFraction(num2, den2)} → ${formatFraction(den2, num2)}</div>
                <div class="step">Step 2: Multiply: ${formatFraction(num1, den1)} × ${formatFraction(den2, num2)}</div>
                <div class="step">Step 3: Multiply numerators: ${num1} × ${den2} = ${resultNum}</div>
                <div class="step">Step 4: Multiply denominators: ${den1} × ${num2} = ${resultDen}</div>
                <div class="step">Step 5: Result: ${formatFraction(resultNum, resultDen)}</div>
                <div class="step">Step 6: Simplify: ${formatFraction(resultNum, resultDen)} = ${formatFraction(simplified.numerator, simplified.denominator)}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Decimal Value:</strong> ${decimalValue.toFixed(6)}
            </div>`;
            
            show(html);
        }
        
        function calculateSimplify() {
            const num = parseInt(document.getElementById('sim_num').value);
            const den = parseInt(document.getElementById('sim_den').value);
            
            if (isNaN(num) || isNaN(den) || den === 0) {
                alert('⚠️ Please enter valid numbers (denominator cannot be zero)');
                return;
            }
            
            const simplified = simplifyFraction(num, den);
            const gcdValue = gcd(num, den);
            const decimalValue = num / den;
            
            let html = `<div class="result-box">
                <div class="result-label">Original Fraction</div>
                <div class="result-value">${formatFraction(num, den)}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Simplified Fraction</div>
                <div class="result-value" style="color:#2196F3;">${formatFraction(simplified.numerator, simplified.denominator)}</div>
            </div>
            <div class="step-box">
                <strong>📝 Step-by-Step Solution:</strong>
                <div class="step">Step 1: Find GCD of ${num} and ${den}</div>
                <div class="step">Step 2: GCD(${num}, ${den}) = ${gcdValue}</div>
                <div class="step">Step 3: Divide numerator by GCD: ${num} ÷ ${gcdValue} = ${simplified.numerator}</div>
                <div class="step">Step 4: Divide denominator by GCD: ${den} ÷ ${gcdValue} = ${simplified.denominator}</div>
                <div class="step">Step 5: Simplified fraction: ${formatFraction(simplified.numerator, simplified.denominator)}</div>
            </div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Decimal Value:</strong> ${decimalValue.toFixed(6)}
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>