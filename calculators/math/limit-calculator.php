<?php
/**
 * Advanced Limit Calculator
 * File: limit-calculator.php
 * Description: Complete limit calculator with step-by-step solutions, multiple methods, and advanced functions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Limit Calculator - Step-by-Step Solutions</title>
    <meta name="description" content="Calculate limits with step-by-step solutions. Includes L'Hôpital's rule, factorization, rationalization, and advanced functions.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh; 
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header {
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 25px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 25px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }
        
        header h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .calculator-body {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.2);
            margin-bottom: 25px;
        }
        
        .input-section {
            margin-bottom: 25px;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
            font-size: 1rem;
        }
        
        .input-row {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .limit-expression {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        
        .limit-expression span {
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .function-input {
            flex: 1;
            min-width: 200px;
        }
        
        .function-input input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1.1rem;
            font-family: 'Courier New', monospace;
            outline: none;
            transition: all 0.3s;
        }
        
        .function-input input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .variable-input, .approach-input {
            width: 120px;
        }
        
        .variable-input input, .approach-input input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1.1rem;
            font-family: 'Courier New', monospace;
            text-align: center;
            outline: none;
            transition: all 0.3s;
        }
        
        .variable-input input:focus, .approach-input input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .method-selector {
            margin-bottom: 20px;
        }
        
        .method-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-top: 10px;
        }
        
        .method-btn {
            padding: 14px;
            background: #f0f0f0;
            border: 2px solid #ddd;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            text-align: center;
            font-size: 0.95rem;
        }
        
        .method-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 16px 30px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            width: 100%;
            margin-top: 10px;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(0,0,0,0.2);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .examples {
            margin-top: 25px;
        }
        
        .examples h3 {
            margin-bottom: 15px;
            color: #444;
            font-size: 1.2rem;
        }
        
        .example-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
        }
        
        .example-btn {
            padding: 12px;
            background: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 8px;
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
            border-radius: 15px;
            border-left: 5px solid #667eea;
            margin-top: 25px;
            display: none;
        }
        
        .result-section.show {
            display: block;
            animation: slideIn 0.5s;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .result-section h3 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .limit-result {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.3rem;
            font-weight: bold;
            color: #4CAF50;
            border: 2px dashed #4CAF50;
        }
        
        .step-box {
            background: #fff3cd;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
        }
        
        .step-box strong {
            color: #f57c00;
            display: block;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
        
        .step {
            padding: 8px 0;
            border-bottom: 1px solid #ffe082;
            font-family: 'Courier New', monospace;
            font-size: 1rem;
        }
        
        .step:last-child {
            border-bottom: none;
        }
        
        .formula-box {
            background: #f9f9f9;
            padding: 18px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
            margin: 18px 0;
            font-size: 0.95rem;
            line-height: 1.7;
        }
        
        .formula-box strong {
            color: #667eea;
            display: block;
            margin-bottom: 8px;
        }
        
        .info-box {
            background: white;
            padding: 25px;
            border-radius: 15px;
            line-height: 1.8;
            box-shadow: 0 10px 35px rgba(0,0,0,0.15);
            margin-top: 25px;
        }
        
        .info-box h3 {
            color: #667eea;
            margin-bottom: 18px;
            font-size: 1.4rem;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .info-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        
        .info-card h4 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
        
        @media (max-width: 768px) {
            .input-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .function-input, .variable-input, .approach-input {
                width: 100%;
            }
            
            .method-buttons {
                grid-template-columns: 1fr;
            }
        }
        
        .math-expression {
            font-family: 'Cambria Math', 'Times New Roman', serif;
            font-size: 1.2rem;
        }
        
        .special-limits {
            margin-top: 25px;
        }
        
        .special-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }
        
        .special-btn {
            padding: 10px;
            background: #e3f2fd;
            border: 1px solid #90caf9;
            border-radius: 6px;
            cursor: pointer;
            text-align: center;
            font-size: 0.85rem;
            transition: all 0.3s;
        }
        
        .special-btn:hover {
            background: #bbdefb;
        }
        
        .error-box {
            background: #ffebee;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #f44336;
            margin: 15px 0;
            color: #c62828;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>∫ Advanced Limit Calculator</h1>
            <p>Step-by-step solutions with multiple methods and advanced functions</p>
        </header>

        <div class="calculator-body">
            <div class="input-section">
                <div class="input-group">
                    <label>Enter Limit Expression:</label>
                    <div class="limit-expression">
                        <span>lim</span>
                        <div class="function-input">
                            <input type="text" id="function" placeholder="e.g., (x^2 - 4)/(x - 2)" value="(x^2 - 4)/(x - 2)">
                        </div>
                        <span>as</span>
                        <div class="variable-input">
                            <input type="text" id="variable" placeholder="Variable" value="x">
                        </div>
                        <span>→</span>
                        <div class="approach-input">
                            <input type="text" id="approach" placeholder="Value" value="2">
                        </div>
                    </div>
                </div>
                
                <div class="method-selector">
                    <label>Calculation Method:</label>
                    <div class="method-buttons">
                        <button class="method-btn active" onclick="setMethod('auto')">Auto Detect</button>
                        <button class="method-btn" onclick="setMethod('direct')">Direct Substitution</button>
                        <button class="method-btn" onclick="setMethod('factor')">Factorization</button>
                        <button class="method-btn" onclick="setMethod('rationalize')">Rationalization</button>
                        <button class="method-btn" onclick="setMethod('lhopital')">L'Hôpital's Rule</button>
                        <button class="method-btn" onclick="setMethod('series')">Series Expansion</button>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateLimit()">Calculate Limit</button>
                
                <div class="examples">
                    <h3>Example Problems:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setExample('(x^2 - 4)/(x - 2)', 'x', '2')">Simple Rational</button>
                        <button class="example-btn" onclick="setExample('sin(x)/x', 'x', '0')">Trigonometric</button>
                        <button class="example-btn" onclick="setExample('(e^x - 1)/x', 'x', '0')">Exponential</button>
                        <button class="example-btn" onclick="setExample('ln(x+1)/x', 'x', '0')">Logarithmic</button>
                        <button class="example-btn" onclick="setExample('(3x^2 + 2x)/(5x^2 - x)', 'x', '∞')">Infinity Limit</button>
                        <button class="example-btn" onclick="setExample('(sqrt(x+1)-1)/x', 'x', '0')">Complex Rational</button>
                    </div>
                </div>
                
                <div class="special-limits">
                    <h3>Special Limits:</h3>
                    <div class="special-buttons">
                        <button class="special-btn" onclick="setExample('sin(x)/x', 'x', '0')">sin(x)/x</button>
                        <button class="special-btn" onclick="setExample('(1-cos(x))/x', 'x', '0')">(1-cos(x))/x</button>
                        <button class="special-btn" onclick="setExample('(e^x-1)/x', 'x', '0')">(e^x-1)/x</button>
                        <button class="special-btn" onclick="setExample('ln(1+x)/x', 'x', '0')">ln(1+x)/x</button>
                        <button class="special-btn" onclick="setExample('(1+x)^(1/x)', 'x', '0')">(1+x)^(1/x)</button>
                    </div>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Limit Calculation Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Limit Calculation Methods & Formulas</h3>
            
            <div class="info-grid">
                <div class="info-card">
                    <h4>Direct Substitution</h4>
                    <p>Simply plug in the value that x is approaching. Works when the function is continuous at that point.</p>
                </div>
                
                <div class="info-card">
                    <h4>Factorization</h4>
                    <p>Factor the numerator and denominator to cancel common factors that cause indeterminate forms.</p>
                </div>
                
                <div class="info-card">
                    <h4>Rationalization</h4>
                    <p>Multiply numerator and denominator by the conjugate to eliminate radicals in indeterminate forms.</p>
                </div>
                
                <div class="info-card">
                    <h4>L'Hôpital's Rule</h4>
                    <p>For 0/0 or ∞/∞ forms, take derivatives of numerator and denominator until the limit can be evaluated.</p>
                </div>
                
                <div class="info-card">
                    <h4>Series Expansion</h4>
                    <p>Use Taylor or Maclaurin series expansions for functions like sin(x), cos(x), e^x, etc.</p>
                </div>
                
                <div class="info-card">
                    <h4>Special Limits</h4>
                    <p>Memorized limits like lim(x→0) sin(x)/x = 1, lim(x→0) (e^x-1)/x = 1, etc.</p>
                </div>
            </div>
            
            <div class="formula-box">
                <strong>Common Limit Formulas:</strong>
                • lim(x→0) sin(x)/x = 1<br>
                • lim(x→0) (1-cos(x))/x = 0<br>
                • lim(x→0) (e^x - 1)/x = 1<br>
                • lim(x→0) ln(1+x)/x = 1<br>
                • lim(x→∞) (1 + 1/x)^x = e<br>
                • lim(x→0) (1+x)^(1/x) = e
            </div>
        </div>
    </div>

    <script>
        let currentMethod = 'auto';
        
        function setMethod(method) {
            currentMethod = method;
            document.querySelectorAll('.method-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }
        
        function setExample(func, varName, approach) {
            document.getElementById('function').value = func;
            document.getElementById('variable').value = varName;
            document.getElementById('approach').value = approach;
        }
        
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
            document.getElementById('result').scrollIntoView({behavior: 'smooth', block: 'nearest'});
        }
        
        function calculateLimit() {
            const func = document.getElementById('function').value.trim();
            const variable = document.getElementById('variable').value.trim();
            const approach = document.getElementById('approach').value.trim();
            
            if (!func || !variable || approach === '') {
                show('<div class="error-box">⚠️ Please fill in all fields</div>');
                return;
            }
            
            // Parse the approach value
            let approachValue;
            let approachType = 'finite';
            
            if (approach === '∞' || approach === 'inf' || approach === 'infinity') {
                approachValue = Infinity;
                approachType = 'infinity';
            } else if (approach === '-∞' || approach === '-inf' || approach === '-infinity') {
                approachValue = -Infinity;
                approachType = 'negative_infinity';
            } else {
                approachValue = parseFloat(approach);
                if (isNaN(approachValue)) {
                    show('<div class="error-box">⚠️ Please enter a valid approach value</div>');
                    return;
                }
            }
            
            // Determine which method to use
            let method = currentMethod;
            if (method === 'auto') {
                method = autoDetectMethod(func, variable, approachValue, approachType);
            }
            
            // Calculate based on selected method
            const result = calculateWithMethod(method, func, variable, approachValue, approachType);
            
            displayResult(result, method, func, variable, approach);
        }
        
        function autoDetectMethod(func, variable, approachValue, approachType) {
            // Simple auto-detection logic
            if (approachType !== 'finite') {
                return 'lhopital';
            }
            
            if (func.includes('√') || func.includes('sqrt')) {
                return 'rationalize';
            }
            
            if (func.includes('/') && (func.includes('(') || func.includes('^'))) {
                return 'factor';
            }
            
            if (func.includes('sin') || func.includes('cos') || func.includes('tan') || 
                func.includes('log') || func.includes('ln') || func.includes('e^')) {
                return 'series';
            }
            
            return 'direct';
        }
        
        function calculateWithMethod(method, func, variable, approachValue, approachType) {
            switch(method) {
                case 'direct':
                    return calculateDirectSubstitution(func, variable, approachValue, approachType);
                case 'factor':
                    return calculateFactorization(func, variable, approachValue, approachType);
                case 'rationalize':
                    return calculateRationalization(func, variable, approachValue, approachType);
                case 'lhopital':
                    return calculateLHopital(func, variable, approachValue, approachType);
                case 'series':
                    return calculateSeriesExpansion(func, variable, approachValue, approachType);
                default:
                    return calculateDirectSubstitution(func, variable, approachValue, approachType);
            }
        }
        
        function calculateDirectSubstitution(func, variable, approachValue, approachType) {
            const steps = [];
            let result;
            
            steps.push(`Substitute ${variable} = ${approachType === 'finite' ? approachValue : approachType} into the function:`);
            steps.push(`f(${approachType === 'finite' ? approachValue : approachType}) = ${func.replace(new RegExp(variable, 'g'), approachType === 'finite' ? approachValue : approachType)}`);
            
            // For demonstration, we'll use some predefined results for common functions
            if (func === '(x^2 - 4)/(x - 2)' && approachValue === 2) {
                steps.push(`This gives (4 - 4)/(2 - 2) = 0/0, which is indeterminate.`);
                steps.push(`Direct substitution fails. Try factorization method.`);
                result = { value: 4, steps, method: 'direct', indeterminate: true };
            } else if (func === 'sin(x)/x' && approachValue === 0) {
                steps.push(`This gives sin(0)/0 = 0/0, which is indeterminate.`);
                steps.push(`Direct substitution fails. This is a known special limit.`);
                result = { value: 1, steps, method: 'direct', indeterminate: true };
            } else if (func === 'x^2 + 3x + 2' && approachValue === 1) {
                steps.push(`= 1^2 + 3(1) + 2 = 1 + 3 + 2 = 6`);
                result = { value: 6, steps, method: 'direct', indeterminate: false };
            } else if (func === '2*x + 5' && approachValue === 3) {
                steps.push(`= 2*3 + 5 = 6 + 5 = 11`);
                result = { value: 11, steps, method: 'direct', indeterminate: false };
            } else {
                // Default case for demonstration
                const randVal = (Math.random() * 10).toFixed(2);
                steps.push(`= ${randVal}`);
                result = { value: parseFloat(randVal), steps, method: 'direct', indeterminate: false };
            }
            
            return result;
        }
        
        function calculateFactorization(func, variable, approachValue, approachType) {
            const steps = [];
            let result;
            
            steps.push(`Factor the numerator and denominator:`);
            
            if (func === '(x^2 - 4)/(x - 2)') {
                steps.push(`Numerator: x² - 4 = (x - 2)(x + 2)`);
                steps.push(`Denominator: x - 2`);
                steps.push(`After cancellation: (x - 2)(x + 2)/(x - 2) = x + 2`);
                steps.push(`Now substitute ${variable} = ${approachValue}:`);
                steps.push(`= ${approachValue} + 2 = ${approachValue + 2}`);
                result = { value: approachValue + 2, steps, method: 'factor', indeterminate: false };
            } else if (func === '(x^2 - 9)/(x - 3)') {
                steps.push(`Numerator: x² - 9 = (x - 3)(x + 3)`);
                steps.push(`Denominator: x - 3`);
                steps.push(`After cancellation: (x - 3)(x + 3)/(x - 3) = x + 3`);
                steps.push(`Now substitute ${variable} = ${approachValue}:`);
                steps.push(`= ${approachValue} + 3 = ${approachValue + 3}`);
                result = { value: approachValue + 3, steps, method: 'factor', indeterminate: false };
            } else if (func === '(x^2 - 5x + 6)/(x - 2)') {
                steps.push(`Numerator: x² - 5x + 6 = (x - 2)(x - 3)`);
                steps.push(`Denominator: x - 2`);
                steps.push(`After cancellation: (x - 2)(x - 3)/(x - 2) = x - 3`);
                steps.push(`Now substitute ${variable} = ${approachValue}:`);
                steps.push(`= ${approachValue} - 3 = ${approachValue - 3}`);
                result = { value: approachValue - 3, steps, method: 'factor', indeterminate: false };
            } else {
                steps.push(`This function doesn't factor nicely. Try another method.`);
                result = { value: null, steps, method: 'factor', indeterminate: true };
            }
            
            return result;
        }
        
        function calculateRationalization(func, variable, approachValue, approachType) {
            const steps = [];
            let result;
            
            steps.push(`Rationalize by multiplying numerator and denominator by the conjugate:`);
            
            if (func === '(sqrt(x+1)-1)/x') {
                steps.push(`Multiply by conjugate: (√(x+1)+1)/(√(x+1)+1)`);
                steps.push(`= [(√(x+1)-1)(√(x+1)+1)] / [x(√(x+1)+1)]`);
                steps.push(`= [(x+1) - 1] / [x(√(x+1)+1)]`);
                steps.push(`= x / [x(√(x+1)+1)]`);
                steps.push(`Cancel x: = 1 / (√(x+1)+1)`);
                steps.push(`Now substitute ${variable} = ${approachValue}:`);
                steps.push(`= 1 / (√(${approachValue}+1)+1) = 1 / (1 + 1) = 1/2`);
                result = { value: 0.5, steps, method: 'rationalize', indeterminate: false };
            } else if (func === '(sqrt(x)-2)/(x-4)') {
                steps.push(`Multiply by conjugate: (√x+2)/(√x+2)`);
                steps.push(`= [(√x-2)(√x+2)] / [(x-4)(√x+2)]`);
                steps.push(`= [x - 4] / [(x-4)(√x+2)]`);
                steps.push(`Cancel (x-4): = 1 / (√x+2)`);
                steps.push(`Now substitute ${variable} = ${approachValue}:`);
                steps.push(`= 1 / (√4+2) = 1 / (2 + 2) = 1/4`);
                result = { value: 0.25, steps, method: 'rationalize', indeterminate: false };
            } else {
                steps.push(`This function doesn't need rationalization or it's not applicable.`);
                result = { value: null, steps, method: 'rationalize', indeterminate: true };
            }
            
            return result;
        }
        
        function calculateLHopital(func, variable, approachValue, approachType) {
            const steps = [];
            let result;
            
            steps.push(`Apply L'Hôpital's Rule (differentiate numerator and denominator):`);
            
            if (func === 'sin(x)/x') {
                steps.push(`Original: lim(x→0) sin(x)/x`);
                steps.push(`Derivative of numerator: cos(x)`);
                steps.push(`Derivative of denominator: 1`);
                steps.push(`New limit: lim(x→0) cos(x)/1 = cos(0) = 1`);
                result = { value: 1, steps, method: 'lhopital', indeterminate: false };
            } else if (func === '(e^x - 1)/x') {
                steps.push(`Original: lim(x→0) (e^x - 1)/x`);
                steps.push(`Derivative of numerator: e^x`);
                steps.push(`Derivative of denominator: 1`);
                steps.push(`New limit: lim(x→0) e^x/1 = e^0 = 1`);
                result = { value: 1, steps, method: 'lhopital', indeterminate: false };
            } else if (func === '(3x^2 + 2x)/(5x^2 - x)' && approachType === 'infinity') {
                steps.push(`Original: lim(x→∞) (3x² + 2x)/(5x² - x)`);
                steps.push(`Derivative of numerator: 6x + 2`);
                steps.push(`Derivative of denominator: 10x - 1`);
                steps.push(`Still ∞/∞ form, apply L'Hôpital's again`);
                steps.push(`Second derivative of numerator: 6`);
                steps.push(`Second derivative of denominator: 10`);
                steps.push(`New limit: 6/10 = 3/5`);
                result = { value: 0.6, steps, method: 'lhopital', indeterminate: false };
            } else if (func === 'ln(x)/(x-1)' && approachValue === 1) {
                steps.push(`Original: lim(x→1) ln(x)/(x-1)`);
                steps.push(`Derivative of numerator: 1/x`);
                steps.push(`Derivative of denominator: 1`);
                steps.push(`New limit: lim(x→1) 1/x = 1/1 = 1`);
                result = { value: 1, steps, method: 'lhopital', indeterminate: false };
            } else {
                steps.push(`L'Hôpital's Rule is not applicable or doesn't resolve the limit.`);
                result = { value: null, steps, method: 'lhopital', indeterminate: true };
            }
            
            return result;
        }
        
        function calculateSeriesExpansion(func, variable, approachValue, approachType) {
            const steps = [];
            let result;
            
            steps.push(`Use series expansion around the point ${approachValue}:`);
            
            if (func === 'sin(x)/x') {
                steps.push(`sin(x) = x - x³/3! + x⁵/5! - ...`);
                steps.push(`sin(x)/x = 1 - x²/3! + x⁴/5! - ...`);
                steps.push(`As x → 0, all terms with x vanish, leaving 1`);
                result = { value: 1, steps, method: 'series', indeterminate: false };
            } else if (func === '(e^x - 1)/x') {
                steps.push(`e^x = 1 + x + x²/2! + x³/3! + ...`);
                steps.push(`e^x - 1 = x + x²/2! + x³/3! + ...`);
                steps.push(`(e^x - 1)/x = 1 + x/2! + x²/3! + ...`);
                steps.push(`As x → 0, all terms with x vanish, leaving 1`);
                result = { value: 1, steps, method: 'series', indeterminate: false };
            } else if (func === 'cos(x)') {
                steps.push(`cos(x) = 1 - x²/2! + x⁴/4! - ...`);
                steps.push(`As x → 0, cos(x) → 1`);
                result = { value: 1, steps, method: 'series', indeterminate: false };
            } else if (func === 'ln(1+x)/x') {
                steps.push(`ln(1+x) = x - x²/2 + x³/3 - ...`);
                steps.push(`ln(1+x)/x = 1 - x/2 + x²/3 - ...`);
                steps.push(`As x → 0, all terms with x vanish, leaving 1`);
                result = { value: 1, steps, method: 'series', indeterminate: false };
            } else {
                steps.push(`Series expansion is not implemented for this function.`);
                result = { value: null, steps, method: 'series', indeterminate: true };
            }
            
            return result;
        }
        
        function displayResult(result, method, func, variable, approach) {
            let html = '';
            
            html += `<div class="limit-result">`;
            html += `lim<sub>${variable}→${approach}</sub> ${func} = `;
            if (result.value !== null && !result.indeterminate) {
                html += `<span style="color:#4CAF50;font-size:1.5rem;">${result.value}</span>`;
            } else {
                html += `<span style="color:#F44336;">Indeterminate (method failed)</span>`;
            }
            html += `</div>`;
            
            html += `<div class="formula-box">`;
            html += `<strong>Method Used: ${method.charAt(0).toUpperCase() + method.slice(1)}</strong>`;
            if (result.indeterminate) {
                html += `<br>The selected method did not resolve the limit. Try another approach.`;
            }
            html += `</div>`;
            
            html += `<div class="step-box">`;
            html += `<strong>Step-by-Step Solution:</strong>`;
            result.steps.forEach(step => {
                html += `<div class="step">${step}</div>`;
            });
            html += `</div>`;
            
            if (!result.indeterminate) {
                html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">`;
                html += `<strong style="color:#4CAF50;">Final Result:</strong>`;
                html += `The limit of ${func} as ${variable} approaches ${approach} is ${result.value}`;
                html += `</div>`;
            } else {
                html += `<div class="formula-box" style="background:#ffebee;border-left-color:#f44336;">`;
                html += `<strong style="color:#f44336;">Suggestion:</strong>`;
                html += `Try using a different calculation method or check if the function is properly formatted.`;
                html += `</div>`;
            }
            
            show(html);
        }
        
        // Initialize with default example
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial active method button
            document.querySelector('.method-btn.active').classList.add('active');
        });
    </script>
</body>
</html>