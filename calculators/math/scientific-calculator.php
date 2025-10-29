<?php
/**
 * Scientific Calculator
 * File: scientific-calculator.php
 * Description: Advanced scientific calculator with all mathematical functions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scientific Calculator - Advanced Math Calculator Online</title>
    <meta name="description" content="Free scientific calculator online. Calculate trigonometry, logarithms, exponentials, roots, factorials, and complex mathematical expressions.">
    <link rel="stylesheet" href="../assets/css/calculator.css">
    <style>
        .calculator-body {
            max-width: 500px;
            margin: 30px auto;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        
        .calc-display {
            background: #1a1a2e;
            color: #00ff88;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            min-height: 120px;
            font-family: 'Courier New', monospace;
        }
        
        .calc-expression {
            font-size: 0.9em;
            color: #888;
            min-height: 25px;
            margin-bottom: 10px;
            word-wrap: break-word;
        }
        
        .calc-result {
            font-size: 2.5em;
            font-weight: bold;
            text-align: right;
            min-height: 50px;
            word-wrap: break-word;
        }
        
        .calc-mode {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .mode-btn {
            flex: 1;
            padding: 10px;
            background: rgba(255,255,255,0.2);
            border: 2px solid transparent;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
        }
        
        .mode-btn.active {
            background: white;
            color: #667eea;
            border-color: white;
        }
        
        .calc-buttons {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
        }
        
        .calc-btn {
            padding: 18px 10px;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
            background: rgba(255,255,255,0.9);
            color: #333;
        }
        
        .calc-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .calc-btn:active {
            transform: scale(0.95);
        }
        
        .calc-btn.operator {
            background: #ff6b6b;
            color: white;
        }
        
        .calc-btn.function {
            background: #4ecdc4;
            color: white;
            font-size: 0.9em;
        }
        
        .calc-btn.number {
            background: white;
            color: #333;
        }
        
        .calc-btn.special {
            background: #95e1d3;
            color: #333;
        }
        
        .calc-btn.equals {
            background: #00ff88;
            color: #1a1a2e;
            grid-column: span 2;
        }
        
        .calc-btn.clear {
            background: #ff9ff3;
            color: white;
        }
        
        .calc-btn.wide {
            grid-column: span 2;
        }
        
        .history-panel {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .history-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-family: 'Courier New', monospace;
        }
        
        .history-item:last-child {
            border-bottom: none;
        }
        
        .history-expr {
            color: #666;
            font-size: 0.9em;
        }
        
        .history-result {
            color: #667eea;
            font-weight: bold;
            font-size: 1.1em;
        }
        
        @media (max-width: 600px) {
            .calculator-body {
                padding: 15px;
            }
            
            .calc-buttons {
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
            }
            
            .calc-btn {
                padding: 15px 8px;
                font-size: 0.95em;
            }
            
            .calc-result {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>🔬 Scientific Calculator</h1>
        <p>Advanced mathematical calculations</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">&larr; Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-display">
                <div class="calc-expression" id="expression"></div>
                <div class="calc-result" id="result">0</div>
            </div>

            <div class="calc-mode">
                <button class="mode-btn active" id="modeBasic" onclick="setMode('basic')">Basic</button>
                <button class="mode-btn" id="modeScientific" onclick="setMode('scientific')">Scientific</button>
            </div>

            <div id="basicButtons">
                <div class="calc-buttons">
                    <!-- Row 1 -->
                    <button class="calc-btn clear" onclick="clearAll()">AC</button>
                    <button class="calc-btn special" onclick="clearEntry()">CE</button>
                    <button class="calc-btn special" onclick="backspace()">⌫</button>
                    <button class="calc-btn operator" onclick="appendOperator('/')">÷</button>
                    <button class="calc-btn operator" onclick="appendOperator('*')">×</button>

                    <!-- Row 2 -->
                    <button class="calc-btn number" onclick="appendNumber('7')">7</button>
                    <button class="calc-btn number" onclick="appendNumber('8')">8</button>
                    <button class="calc-btn number" onclick="appendNumber('9')">9</button>
                    <button class="calc-btn operator" onclick="appendOperator('-')">−</button>
                    <button class="calc-btn function" onclick="calculateSquare()">x²</button>

                    <!-- Row 3 -->
                    <button class="calc-btn number" onclick="appendNumber('4')">4</button>
                    <button class="calc-btn number" onclick="appendNumber('5')">5</button>
                    <button class="calc-btn number" onclick="appendNumber('6')">6</button>
                    <button class="calc-btn operator" onclick="appendOperator('+')">+</button>
                    <button class="calc-btn function" onclick="calculateSqrt()">√x</button>

                    <!-- Row 4 -->
                    <button class="calc-btn number" onclick="appendNumber('1')">1</button>
                    <button class="calc-btn number" onclick="appendNumber('2')">2</button>
                    <button class="calc-btn number" onclick="appendNumber('3')">3</button>
                    <button class="calc-btn operator" onclick="appendOperator('**')">xʸ</button>
                    <button class="calc-btn function" onclick="calculateInverse()">1/x</button>

                    <!-- Row 5 -->
                    <button class="calc-btn special" onclick="appendNumber('0')">0</button>
                    <button class="calc-btn special" onclick="appendNumber('.')">.</button>
                    <button class="calc-btn special" onclick="toggleSign()">±</button>
                    <button class="calc-btn equals" onclick="calculate()">=</button>
                </div>
            </div>

            <div id="scientificButtons" style="display: none;">
                <div class="calc-buttons">
                    <!-- Row 1 - Memory & Clear -->
                    <button class="calc-btn clear" onclick="clearAll()">AC</button>
                    <button class="calc-btn special" onclick="clearEntry()">CE</button>
                    <button class="calc-btn special" onclick="backspace()">⌫</button>
                    <button class="calc-btn special" onclick="insertParenthesis('(')">(</button>
                    <button class="calc-btn special" onclick="insertParenthesis(')')">)</button>

                    <!-- Row 2 - Trig Functions -->
                    <button class="calc-btn function" onclick="applyFunction('sin')">sin</button>
                    <button class="calc-btn function" onclick="applyFunction('cos')">cos</button>
                    <button class="calc-btn function" onclick="applyFunction('tan')">tan</button>
                    <button class="calc-btn function" onclick="applyFunction('asin')">sin⁻¹</button>
                    <button class="calc-btn function" onclick="applyFunction('acos')">cos⁻¹</button>

                    <!-- Row 3 - Advanced Functions -->
                    <button class="calc-btn function" onclick="applyFunction('atan')">tan⁻¹</button>
                    <button class="calc-btn function" onclick="applyFunction('log')">log</button>
                    <button class="calc-btn function" onclick="applyFunction('ln')">ln</button>
                    <button class="calc-btn function" onclick="applyFunction('exp')">eˣ</button>
                    <button class="calc-btn function" onclick="insertConstant('e')">e</button>

                    <!-- Row 4 - Numbers & Operators -->
                    <button class="calc-btn number" onclick="appendNumber('7')">7</button>
                    <button class="calc-btn number" onclick="appendNumber('8')">8</button>
                    <button class="calc-btn number" onclick="appendNumber('9')">9</button>
                    <button class="calc-btn operator" onclick="appendOperator('/')">÷</button>
                    <button class="calc-btn function" onclick="calculateSquare()">x²</button>

                    <!-- Row 5 -->
                    <button class="calc-btn number" onclick="appendNumber('4')">4</button>
                    <button class="calc-btn number" onclick="appendNumber('5')">5</button>
                    <button class="calc-btn number" onclick="appendNumber('6')">6</button>
                    <button class="calc-btn operator" onclick="appendOperator('*')">×</button>
                    <button class="calc-btn function" onclick="calculateSqrt()">√x</button>

                    <!-- Row 6 -->
                    <button class="calc-btn number" onclick="appendNumber('1')">1</button>
                    <button class="calc-btn number" onclick="appendNumber('2')">2</button>
                    <button class="calc-btn number" onclick="appendNumber('3')">3</button>
                    <button class="calc-btn operator" onclick="appendOperator('-')">−</button>
                    <button class="calc-btn function" onclick="appendOperator('**')">xʸ</button>

                    <!-- Row 7 -->
                    <button class="calc-btn special" onclick="appendNumber('0')">0</button>
                    <button class="calc-btn special" onclick="appendNumber('.')">.</button>
                    <button class="calc-btn function" onclick="insertConstant('pi')">π</button>
                    <button class="calc-btn operator" onclick="appendOperator('+')">+</button>
                    <button class="calc-btn function" onclick="applyFunction('factorial')">x!</button>

                    <!-- Row 8 -->
                    <button class="calc-btn special" onclick="toggleSign()">±</button>
                    <button class="calc-btn function" onclick="applyFunction('abs')">|x|</button>
                    <button class="calc-btn function" onclick="calculateInverse()">1/x</button>
                    <button class="calc-btn equals wide" onclick="calculate()">=</button>
                </div>
            </div>
        </div>

        <div class="history-panel">
            <h3 style="margin: 0 0 15px 0; color: #667eea;">📊 Calculation History</h3>
            <div id="history">
                <p style="color: #999; text-align: center;">No calculations yet</p>
            </div>
            <button class="btn" style="width: 100%; margin-top: 10px;" onclick="clearHistory()">Clear History</button>
        </div>

        <div class="info-box" style="margin-top: 30px;">
            <h3 style="margin: 0 0 10px 0;">📖 How to Use</h3>
            <p><strong>Basic Mode:</strong> Simple arithmetic operations (+, −, ×, ÷), powers, square root, and reciprocal.</p>
            <p><strong>Scientific Mode:</strong> Trigonometric functions (sin, cos, tan), logarithms (log, ln), exponentials (eˣ), factorials (x!), absolute value |x|, and constants (π, e).</p>
            <p><strong>Keyboard Shortcuts:</strong> Numbers (0-9), Operators (+, -, *, /), Enter (=), Backspace (⌫), Escape (AC)</p>
            <p><strong>Functions:</strong> All trig functions use radians. Use sin⁻¹, cos⁻¹, tan⁻¹ for inverse trig. Use () for grouping expressions.</p>
        </div>
    </div>

    <script>
        let currentMode = 'basic';
        let expression = '';
        let result = '0';
        let history = [];

        function setMode(mode) {
            currentMode = mode;
            document.getElementById('modeBasic').classList.toggle('active', mode === 'basic');
            document.getElementById('modeScientific').classList.toggle('active', mode === 'scientific');
            document.getElementById('basicButtons').style.display = mode === 'basic' ? 'block' : 'none';
            document.getElementById('scientificButtons').style.display = mode === 'scientific' ? 'block' : 'none';
        }

        function updateDisplay() {
            document.getElementById('expression').textContent = expression || '';
            document.getElementById('result').textContent = result;
        }

        function appendNumber(num) {
            if (result !== '0' && expression === '') {
                expression = result;
            }
            expression += num;
            updateDisplay();
        }

        function appendOperator(op) {
            if (expression === '' && result !== '0') {
                expression = result;
            }
            if (expression !== '' && !isNaN(expression[expression.length - 1])) {
                expression += op;
                updateDisplay();
            }
        }

        function insertParenthesis(paren) {
            expression += paren;
            updateDisplay();
        }

        function insertConstant(constant) {
            const value = constant === 'pi' ? Math.PI : Math.E;
            expression += value;
            updateDisplay();
        }

        function applyFunction(func) {
            if (expression === '' && result !== '0') {
                expression = result;
            }
            
            switch(func) {
                case 'sin':
                case 'cos':
                case 'tan':
                case 'asin':
                case 'acos':
                case 'atan':
                    expression = `Math.${func}(${expression})`;
                    break;
                case 'log':
                    expression = `Math.log10(${expression})`;
                    break;
                case 'ln':
                    expression = `Math.log(${expression})`;
                    break;
                case 'exp':
                    expression = `Math.exp(${expression})`;
                    break;
                case 'abs':
                    expression = `Math.abs(${expression})`;
                    break;
                case 'factorial':
                    const num = parseFloat(expression);
                    if (!isNaN(num) && num >= 0 && num === Math.floor(num)) {
                        expression = factorial(num).toString();
                    }
                    break;
            }
            updateDisplay();
        }

        function factorial(n) {
            if (n === 0 || n === 1) return 1;
            let result = 1;
            for (let i = 2; i <= n; i++) {
                result *= i;
            }
            return result;
        }

        function calculateSquare() {
            if (expression === '' && result !== '0') {
                expression = result;
            }
            expression = `Math.pow(${expression}, 2)`;
            calculate();
        }

        function calculateSqrt() {
            if (expression === '' && result !== '0') {
                expression = result;
            }
            expression = `Math.sqrt(${expression})`;
            calculate();
        }

        function calculateInverse() {
            if (expression === '' && result !== '0') {
                expression = result;
            }
            expression = `1/(${expression})`;
            calculate();
        }

        function toggleSign() {
            if (result !== '0') {
                result = (parseFloat(result) * -1).toString();
                expression = result;
                updateDisplay();
            }
        }

        function calculate() {
            if (expression === '') return;
            
            try {
                const cleanExpr = expression.replace(/×/g, '*').replace(/÷/g, '/').replace(/−/g, '-');
                const calcResult = eval(cleanExpr);
                
                if (isNaN(calcResult) || !isFinite(calcResult)) {
                    result = 'Error';
                } else {
                    result = parseFloat(calcResult.toFixed(10)).toString();
                    addToHistory(expression, result);
                }
                
                expression = '';
                updateDisplay();
            } catch (error) {
                result = 'Error';
                expression = '';
                updateDisplay();
            }
        }

        function clearAll() {
            expression = '';
            result = '0';
            updateDisplay();
        }

        function clearEntry() {
            expression = '';
            updateDisplay();
        }

        function backspace() {
            if (expression.length > 0) {
                expression = expression.slice(0, -1);
                updateDisplay();
            }
        }

        function addToHistory(expr, res) {
            history.unshift({ expression: expr, result: res });
            if (history.length > 10) history.pop();
            updateHistory();
        }

        function updateHistory() {
            const historyDiv = document.getElementById('history');
            if (history.length === 0) {
                historyDiv.innerHTML = '<p style="color: #999; text-align: center;">No calculations yet</p>';
            } else {
                historyDiv.innerHTML = history.map(item => `
                    <div class="history-item">
                        <div class="history-expr">${item.expression}</div>
                        <div class="history-result">= ${item.result}</div>
                    </div>
                `).join('');
            }
        }

        function clearHistory() {
            history = [];
            updateHistory();
        }

        // Keyboard support
        document.addEventListener('keydown', (e) => {
            if (e.key >= '0' && e.key <= '9') appendNumber(e.key);
            else if (e.key === '.') appendNumber('.');
            else if (e.key === '+') appendOperator('+');
            else if (e.key === '-') appendOperator('-');
            else if (e.key === '*') appendOperator('*');
            else if (e.key === '/') appendOperator('/');
            else if (e.key === 'Enter' || e.key === '=') calculate();
            else if (e.key === 'Escape') clearAll();
            else if (e.key === 'Backspace') backspace();
            else if (e.key === '(') insertParenthesis('(');
            else if (e.key === ')') insertParenthesis(')');
        });

        // Initialize
        updateDisplay();
    </script>
</body>
</html>