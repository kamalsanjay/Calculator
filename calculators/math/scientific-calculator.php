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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 15px;
        }

        header {
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 25px 15px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
        }

        header h1 {
            margin: 0 0 8px 0;
            font-size: 1.8em;
        }

        header p {
            margin: 0;
            opacity: 0.9;
            font-size: 1em;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .breadcrumb {
            margin-bottom: 15px;
            text-align: center;
        }

        .breadcrumb a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            background: rgba(255,255,255,0.2);
            padding: 8px 16px;
            border-radius: 8px;
            display: inline-block;
            backdrop-filter: blur(10px);
            font-size: 0.9em;
        }

        .calculator-body {
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .calc-display {
            background: #1a1a2e;
            color: #00ff88;
            padding: 20px 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            min-height: 120px;
            font-family: 'Courier New', monospace;
        }
        
        .calc-expression {
            font-size: 0.95em;
            color: #888;
            min-height: 25px;
            margin-bottom: 8px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        .calc-result {
            font-size: 2.2em;
            font-weight: bold;
            text-align: right;
            word-wrap: break-word;
            overflow-wrap: break-word;
            color: #00ff88;
        }
        
        .calc-mode {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .mode-btn {
            flex: 1;
            padding: 12px;
            background: #f0f0f0;
            border: 2px solid transparent;
            border-radius: 8px;
            color: #333;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
            font-size: 1em;
            outline: none;
        }
        
        .mode-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }
        
        .calc-buttons {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
        }
        
        .calc-btn {
            padding: 16px 8px;
            border: none;
            border-radius: 10px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            background: #f5f5f5;
            color: #333;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            user-select: none;
            white-space: nowrap;
            overflow: hidden;
            outline: none;
        }
        
        .calc-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        
        .calc-btn:active {
            transform: scale(0.95);
        }
        
        .calc-btn.operator {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
        }
        
        .calc-btn.function {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a3a1 100%);
            color: white;
            font-size: 0.85em;
        }
        
        .calc-btn.number {
            background: white;
            color: #333;
            font-size: 1.2em;
        }
        
        .calc-btn.special {
            background: #ffd93d;
            color: #333;
        }
        
        .calc-btn.equals {
            background: linear-gradient(135deg, #00ff88 0%, #00d4ff 100%);
            color: white;
            grid-column: span 2;
        }
        
        .calc-btn.clear {
            background: linear-gradient(135deg, #ff9ff3 0%, #ff6b9d 100%);
            color: white;
        }
        
        .calc-btn.wide {
            grid-column: span 2;
        }

        .angle-mode {
            display: flex;
            gap: 8px;
            margin-bottom: 15px;
            justify-content: center;
        }

        .angle-btn {
            padding: 8px 16px;
            background: #f0f0f0;
            border: 2px solid transparent;
            border-radius: 6px;
            color: #333;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
            font-size: 0.9em;
            outline: none;
        }

        .angle-btn.active {
            background: #4ecdc4;
            color: white;
            border-color: #44a3a1;
        }
        
        .history-panel {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            max-height: 300px;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        
        .history-item {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-family: 'Courier New', monospace;
            cursor: pointer;
            transition: all 0.2s;
            border-left: 3px solid #667eea;
            margin-bottom: 8px;
            background: #f9f9f9;
            border-radius: 5px;
        }

        .history-item:hover {
            background: #fff;
            transform: translateX(5px);
        }
        
        .history-expr {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 4px;
        }
        
        .history-result {
            color: #667eea;
            font-weight: bold;
            font-size: 1em;
        }

        .info-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
            line-height: 1.7;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        .info-box h3 {
            color: #667eea;
            margin-bottom: 12px;
        }

        .info-box p {
            margin-bottom: 10px;
            color: #555;
            font-size: 0.95em;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            width: 100%;
            margin-top: 10px;
            outline: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        @media (max-width: 500px) {
            body {
                padding: 10px;
            }

            header h1 {
                font-size: 1.5em;
            }

            .calculator-body {
                padding: 15px;
            }
            
            .calc-buttons {
                grid-template-columns: repeat(5, 1fr);
                gap: 6px;
            }
            
            .calc-btn {
                padding: 14px 4px;
                font-size: 0.85em;
                min-height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .calc-btn.number {
                font-size: 1.1em;
            }

            .calc-btn.function {
                font-size: 0.75em;
            }
            
            .calc-result {
                font-size: 1.8em;
            }

            .calc-expression {
                font-size: 0.85em;
            }

            .mode-btn {
                padding: 10px;
                font-size: 0.9em;
            }
        }

        @media (max-width: 380px) {
            .calc-btn {
                padding: 12px 2px;
                font-size: 0.75em;
                min-height: 45px;
            }

            .calc-btn.number {
                font-size: 1em;
            }

            .calc-btn.function {
                font-size: 0.65em;
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
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-display">
                <div class="calc-expression" id="expression">&nbsp;</div>
                <div class="calc-result" id="result">0</div>
            </div>

            <div class="calc-mode">
                <button class="mode-btn active" id="modeBasic" type="button" onclick="switchMode('basic')">Basic</button>
                <button class="mode-btn" id="modeScientific" type="button" onclick="switchMode('scientific')">Scientific</button>
            </div>

            <div class="angle-mode" id="angleMode" style="display: none;">
                <button class="angle-btn active" id="angleDeg" type="button" onclick="setAngleMode('deg')">DEG</button>
                <button class="angle-btn" id="angleRad" type="button" onclick="setAngleMode('rad')">RAD</button>
            </div>

            <div id="basicButtons" style="display: block;">
                <div class="calc-buttons">
                    <button class="calc-btn clear" type="button" onclick="handleBtn('AC')">AC</button>
                    <button class="calc-btn special" type="button" onclick="handleBtn('CE')">CE</button>
                    <button class="calc-btn special" type="button" onclick="handleBtn('⌫')">⌫</button>
                    <button class="calc-btn operator" type="button" onclick="handleBtn('÷')">÷</button>
                    <button class="calc-btn operator" type="button" onclick="handleBtn('×')">×</button>

                    <button class="calc-btn number" type="button" onclick="handleBtn('7')">7</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('8')">8</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('9')">9</button>
                    <button class="calc-btn operator" type="button" onclick="handleBtn('−')">−</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('x²')">x²</button>

                    <button class="calc-btn number" type="button" onclick="handleBtn('4')">4</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('5')">5</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('6')">6</button>
                    <button class="calc-btn operator" type="button" onclick="handleBtn('+')">+</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('√x')">√x</button>

                    <button class="calc-btn number" type="button" onclick="handleBtn('1')">1</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('2')">2</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('3')">3</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('%')">%</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('1/x')">1/x</button>

                    <button class="calc-btn special" type="button" onclick="handleBtn('0')">0</button>
                    <button class="calc-btn special" type="button" onclick="handleBtn('.')">.</button>
                    <button class="calc-btn special" type="button" onclick="handleBtn('±')">±</button>
                    <button class="calc-btn equals" type="button" onclick="handleBtn('=')">=</button>
                </div>
            </div>

            <div id="scientificButtons" style="display: none;">
                <div class="calc-buttons">
                    <button class="calc-btn clear" type="button" onclick="handleBtn('AC')">AC</button>
                    <button class="calc-btn special" type="button" onclick="handleBtn('CE')">CE</button>
                    <button class="calc-btn special" type="button" onclick="handleBtn('⌫')">⌫</button>
                    <button class="calc-btn special" type="button" onclick="handleBtn('(')">(</button>
                    <button class="calc-btn special" type="button" onclick="handleBtn(')')">)</button>

                    <button class="calc-btn function" type="button" onclick="handleBtn('sin')">sin</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('cos')">cos</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('tan')">tan</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('sinh')">sinh</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('cosh')">cosh</button>

                    <button class="calc-btn function" type="button" onclick="handleBtn('tanh')">tanh</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('sin⁻¹')">sin⁻¹</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('cos⁻¹')">cos⁻¹</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('tan⁻¹')">tan⁻¹</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('x!')">x!</button>

                    <button class="calc-btn function" type="button" onclick="handleBtn('log')">log</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('ln')">ln</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('logₐb')">logₐb</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('10ˣ')">10ˣ</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('eˣ')">eˣ</button>

                    <button class="calc-btn function" type="button" onclick="handleBtn('x²')">x²</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('x³')">x³</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('xʸ')">xʸ</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('√x')">√x</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('∛x')">∛x</button>

                    <button class="calc-btn function" type="button" onclick="handleBtn('ʸ√x')">ʸ√x</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('7')">7</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('8')">8</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('9')">9</button>
                    <button class="calc-btn operator" type="button" onclick="handleBtn('÷')">÷</button>

                    <button class="calc-btn function" type="button" onclick="handleBtn('|x|')">|x|</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('4')">4</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('5')">5</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('6')">6</button>
                    <button class="calc-btn operator" type="button" onclick="handleBtn('×')">×</button>

                    <button class="calc-btn function" type="button" onclick="handleBtn('%')">%</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('1')">1</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('2')">2</button>
                    <button class="calc-btn number" type="button" onclick="handleBtn('3')">3</button>
                    <button class="calc-btn operator" type="button" onclick="handleBtn('−')">−</button>

                    <button class="calc-btn function" type="button" onclick="handleBtn('1/x')">1/x</button>
                    <button class="calc-btn special" type="button" onclick="handleBtn('0')">0</button>
                    <button class="calc-btn special" type="button" onclick="handleBtn('.')">.</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('π')">π</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('e')">e</button>

                    <button class="calc-btn operator" type="button" onclick="handleBtn('+')">+</button>
                    <button class="calc-btn function" type="button" onclick="handleBtn('Ans')">Ans</button>
                    <button class="calc-btn special" type="button" onclick="handleBtn('EXP')">EXP</button>
                    <button class="calc-btn special" type="button" onclick="handleBtn('±')">±</button>
                    <button class="calc-btn equals wide" type="button" onclick="handleBtn('=')">=</button>
                </div>
            </div>
        </div>

        <div class="history-panel">
            <h3 style="margin: 0 0 15px 0; color: #667eea;">📊 Calculation History</h3>
            <div id="history">
                <p style="color: #999; text-align: center;">No calculations yet</p>
            </div>
            <button class="btn" type="button" onclick="clearHistory()">Clear History</button>
        </div>

        <div class="info-box">
            <h3>📖 How to Use</h3>
            <p><strong>Basic Mode:</strong> Simple operations (+, −, ×, ÷, x², √x, %, 1/x)</p>
            <p><strong>Scientific Mode:</strong> Trigonometric (sin, cos, tan, sinh, cosh, tanh), Inverse trig (sin⁻¹, cos⁻¹, tan⁻¹), Logarithms (log, ln, logₐb), Exponentials (eˣ, 10ˣ), Powers (x², x³, xʸ), Roots (√x, ∛x, ʸ√x), Factorial (x!), Absolute value (|x|), Constants (π, e)</p>
            <p><strong>Angle Mode:</strong> Switch between DEG (degrees) and RAD (radians) for trigonometric functions</p>
            <p><strong>Percentage:</strong> For basic %, enter number then % (e.g., 50% = 0.5). For expressions like 10%2, it calculates modulo (remainder)</p>
            <p><strong>Logarithms:</strong> Enter number first, then click log or ln. For custom base like log₂(8), use: 2 logₐb 8 =</p>
            <p><strong>Modulo:</strong> Use % button in expressions: 10%2 = 0 (remainder of 10÷2)</p>
            <p><strong>Ans:</strong> Recalls the last answer for reuse in calculations</p>
            <p><strong>EXP:</strong> Scientific notation (e.g., 1.5 EXP 3 = 1500)</p>
            <p><strong>Keyboard:</strong> Numbers (0-9), Operators (+, -, *, /), Enter (=), Esc (AC), Backspace (⌫)</p>
        </div>
    </div>

    <script>
        var currentMode = 'basic';
        var angleMode = 'deg'; // deg or rad
        var expr = '';
        var res = '0';
        var lastAnswer = '0';
        var historyList = [];
        var waiting = false;
        var lastOperation = '';

        updateScreen();

        // Keyboard support
        document.addEventListener('keydown', function(e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                return;
            }
            
            e.preventDefault();
            
            if (e.key >= '0' && e.key <= '9') {
                handleBtn(e.key);
            } else if (e.key === '.') {
                handleBtn('.');
            } else if (e.key === '+') {
                handleBtn('+');
            } else if (e.key === '-') {
                handleBtn('−');
            } else if (e.key === '*') {
                handleBtn('×');
            } else if (e.key === '/') {
                handleBtn('÷');
            } else if (e.key === 'Enter' || e.key === '=') {
                handleBtn('=');
            } else if (e.key === 'Escape') {
                handleBtn('AC');
            } else if (e.key === 'Backspace') {
                handleBtn('⌫');
            } else if (e.key === '%') {
                handleBtn('%');
            } else if (e.key === '(' || e.key === ')') {
                handleBtn(e.key);
            }
        });

        function updateScreen() {
            document.getElementById('expression').textContent = expr || ' ';
            document.getElementById('result').textContent = res;
        }

        function switchMode(mode) {
            currentMode = mode;
            document.getElementById('modeBasic').className = mode === 'basic' ? 'mode-btn active' : 'mode-btn';
            document.getElementById('modeScientific').className = mode === 'scientific' ? 'mode-btn active' : 'mode-btn';
            document.getElementById('basicButtons').style.display = mode === 'basic' ? 'block' : 'none';
            document.getElementById('scientificButtons').style.display = mode === 'scientific' ? 'block' : 'none';
            document.getElementById('angleMode').style.display = mode === 'scientific' ? 'flex' : 'none';
        }

        function setAngleMode(mode) {
            angleMode = mode;
            document.getElementById('angleDeg').className = mode === 'deg' ? 'angle-btn active' : 'angle-btn';
            document.getElementById('angleRad').className = mode === 'rad' ? 'angle-btn active' : 'angle-btn';
        }

        function toRadians(degrees) {
            return degrees * (Math.PI / 180);
        }

        function toDegrees(radians) {
            return radians * (180 / Math.PI);
        }

        function handleBtn(val) {
            if (val >= '0' && val <= '9') {
                addNumber(val);
            } else if (val === '.') {
                addNumber('.');
            } else if (['+', '−', '×', '÷'].includes(val)) {
                var op = val;
                if (val === '×') op = '*';
                if (val === '÷') op = '/';
                if (val === '−') op = '-';
                addOperator(op);
            } else if (val === '=') {
                calc();
            } else if (val === 'AC') {
                clearAll();
            } else if (val === 'CE') {
                clearEntry();
            } else if (val === '⌫') {
                backSpace();
            } else if (val === '±') {
                toggleSign();
            } else if (val === '%') {
                handlePercent();
            } else if (val === 'x²') {
                calcPower(2);
            } else if (val === 'x³') {
                calcPower(3);
            } else if (val === '√x') {
                calcRoot(2);
            } else if (val === '∛x') {
                calcRoot(3);
            } else if (val === '1/x') {
                calcInverse();
            } else if (val === '|x|') {
                calcAbs();
            } else if (val === 'xʸ') {
                addOperator('**');
            } else if (val === 'ʸ√x') {
                addOperator('√√');
            } else if (val === '(' || val === ')') {
                addParen(val);
            } else if (val === 'π') {
                addConst('pi');
            } else if (val === 'e') {
                addConst('e');
            } else if (val === 'Ans') {
                addConst('ans');
            } else if (val === 'EXP') {
                addOperator('e');
            } else if (val === 'logₐb') {
                addCustomLog();
            } else if (['sin', 'cos', 'tan', 'sinh', 'cosh', 'tanh', 'sin⁻¹', 'cos⁻¹', 'tan⁻¹', 'log', 'ln', '10ˣ', 'eˣ', 'x!'].includes(val)) {
                applyFunc(val);
            }
        }

        function addNumber(num) {
            if (waiting) {
                expr = '';
                waiting = false;
            }

            if (num === '.') {
                var parts = expr.split(/[\+\-\*\/\(\)\%]/);
                var last = parts[parts.length - 1];
                if (last.includes('.')) return;
                if (expr === '' || /[\+\-\*\/\(]$/.test(expr)) {
                    expr += '0.';
                } else {
                    expr += '.';
                }
            } else {
                expr += num;
            }

            res = expr || '0';
            updateScreen();
        }

        function addOperator(op) {
            waiting = false;
            
            if (expr === '' && res !== '0' && res !== 'Error') {
                expr = res;
            }
            
            if (expr === '') {
                if (op === '-') {
                    expr = '-';
                }
                updateScreen();
                return;
            }
            
            var last = expr[expr.length - 1];
            
            // Handle special operators
            if (op === 'e') { // EXP for scientific notation
                expr += 'e';
                updateScreen();
                return;
            }
            
            if (op === '√√') { // nth root
                expr += '√√';
                updateScreen();
                return;
            }
            
            // Remove trailing operators before adding new one
            if (['+', '-', '*', '/', '%'].includes(last)) {
                expr = expr.slice(0, -1);
            } else if (expr.length >= 2 && last === '*' && expr[expr.length - 2] === '*') {
                expr = expr.slice(0, -2);
            }
            
            expr += op;
            updateScreen();
        }

        function addParen(p) {
            waiting = false;
            expr += p;
            updateScreen();
        }

        function addConst(c) {
            if (waiting) {
                expr = '';
                waiting = false;
            }
            
            var val;
            if (c === 'pi') {
                val = Math.PI.toString();
            } else if (c === 'e') {
                val = Math.E.toString();
            } else if (c === 'ans') {
                val = lastAnswer;
            }
            
            expr += val;
            res = expr;
            updateScreen();
        }

        function addCustomLog() {
            if (waiting) {
                expr = '';
                waiting = false;
            }
            
            expr += 'log(';
            res = expr;
            updateScreen();
        }

        function handlePercent() {
            // Check if there's an expression with operators (modulo operation)
            if (expr.match(/[\+\-\*\/]/)) {
                addOperator('%');
            } else {
                // Simple percentage conversion
                calcPercent();
            }
        }

        function applyFunc(fn) {
            if (expr === '' && res !== '0' && res !== 'Error') {
                expr = res;
            }
            
            if (expr === '') expr = '0';
            
            try {
                var v = parseFloat(expr);
                var r;
                var angleValue = v;

                // Convert angle for trig functions
                if (['sin', 'cos', 'tan'].includes(fn) && angleMode === 'deg') {
                    angleValue = toRadians(v);
                }

                if (fn === 'sin') {
                    r = Math.sin(angleValue);
                } else if (fn === 'cos') {
                    r = Math.cos(angleValue);
                } else if (fn === 'tan') {
                    r = Math.tan(angleValue);
                } else if (fn === 'sinh') {
                    r = Math.sinh(v);
                } else if (fn === 'cosh') {
                    r = Math.cosh(v);
                } else if (fn === 'tanh') {
                    r = Math.tanh(v);
                } else if (fn === 'sin⁻¹') {
                    if (v < -1 || v > 1) throw 'Error';
                    r = Math.asin(v);
                    if (angleMode === 'deg') r = toDegrees(r);
                } else if (fn === 'cos⁻¹') {
                    if (v < -1 || v > 1) throw 'Error';
                    r = Math.acos(v);
                    if (angleMode === 'deg') r = toDegrees(r);
                } else if (fn === 'tan⁻¹') {
                    r = Math.atan(v);
                    if (angleMode === 'deg') r = toDegrees(r);
                } else if (fn === 'log') {
                    if (v <= 0) throw 'Error';
                    r = Math.log10(v);
                } else if (fn === 'ln') {
                    if (v <= 0) throw 'Error';
                    r = Math.log(v);
                } else if (fn === '10ˣ') {
                    r = Math.pow(10, v);
                } else if (fn === 'eˣ') {
                    r = Math.exp(v);
                } else if (fn === 'x!') {
                    if (v < 0 || v !== Math.floor(v) || v > 170) throw 'Error';
                    r = factorial(v);
                }

                if (!isFinite(r)) {
                    res = 'Error';
                } else {
                    r = cleanNumber(r);
                    res = r.toString();
                    lastAnswer = res;
                    saveHistory(fn + '(' + expr + ')', res);
                }
                
                expr = '';
                waiting = true;
                updateScreen();
            } catch(e) {
                res = 'Error';
                expr = '';
                updateScreen();
            }
        }

        function factorial(n) {
            if (n === 0 || n === 1) return 1;
            var result = 1;
            for (var i = 2; i <= n; i++) {
                result *= i;
            }
            return result;
        }

        function calcPower(power) {
            if (expr === '' && res !== '0' && res !== 'Error') {
                expr = res;
            }
            
            try {
                var v = parseFloat(expr);
                var r = Math.pow(v, power);
                r = cleanNumber(r);
                res = r.toString();
                lastAnswer = res;
                var powerStr = power === 2 ? '²' : '³';
                saveHistory(expr + powerStr, res);
                expr = '';
                waiting = true;
                updateScreen();
            } catch(e) {
                res = 'Error';
                expr = '';
                updateScreen();
            }
        }

        function calcRoot(root) {
            if (expr === '' && res !== '0' && res !== 'Error') {
                expr = res;
            }
            
            try {
                var v = parseFloat(expr);
                if (v < 0 && root % 2 === 0) throw 'Error';
                var r = Math.pow(v, 1/root);
                r = cleanNumber(r);
                res = r.toString();
                lastAnswer = res;
                var rootStr = root === 2 ? '√' : '∛';
                saveHistory(rootStr + expr, res);
                expr = '';
                waiting = true;
                updateScreen();
            } catch(e) {
                res = 'Error';
                expr = '';
                updateScreen();
            }
        }

        function calcInverse() {
            if (expr === '' && res !== '0' && res !== 'Error') {
                expr = res;
            }
            
            try {
                var v = parseFloat(expr);
                if (v === 0) throw 'Error';
                var r = 1 / v;
                r = cleanNumber(r);
                res = r.toString();
                lastAnswer = res;
                saveHistory('1/' + expr, res);
                expr = '';
                waiting = true;
                updateScreen();
            } catch(e) {
                res = 'Error';
                expr = '';
                updateScreen();
            }
        }

        function calcAbs() {
            if (expr === '' && res !== '0' && res !== 'Error') {
                expr = res;
            }
            
            try {
                var v = parseFloat(expr);
                var r = Math.abs(v);
                r = cleanNumber(r);
                res = r.toString();
                lastAnswer = res;
                saveHistory('|' + expr + '|', res);
                expr = '';
                waiting = true;
                updateScreen();
            } catch(e) {
                res = 'Error';
                expr = '';
                updateScreen();
            }
        }

        function calcPercent() {
            if (expr === '' && res !== '0' && res !== 'Error') {
                expr = res;
            }

            try {
                var v = parseFloat(expr);
                var r = v / 100;
                r = cleanNumber(r);
                res = r.toString();
                lastAnswer = res;
                saveHistory(expr + '%', res);
                expr = '';
                waiting = true;
                updateScreen();
            } catch(e) {
                res = 'Error';
                expr = '';
                updateScreen();
            }
        }

        function toggleSign() {
            if (expr === '') {
                if (res !== '0' && res !== 'Error') {
                    var v = parseFloat(res);
                    res = (-v).toString();
                    lastAnswer = res;
                    updateScreen();
                }
            } else {
                try {
                    var v = parseFloat(expr);
                    expr = (-v).toString();
                    res = expr;
                    updateScreen();
                } catch(e) {
                    // If expr is not a simple number, prepend with minus
                    if (expr[0] === '-') {
                        expr = expr.substring(1);
                    } else {
                        expr = '-' + expr;
                    }
                    updateScreen();
                }
            }
        }

        function clearAll() {
            expr = '';
            res = '0';
            waiting = false;
            updateScreen();
        }

        function clearEntry() {
            expr = '';
            res = '0';
            updateScreen();
        }

        function backSpace() {
            if (expr.length > 0) {
                expr = expr.slice(0, -1);
                res = expr || '0';
                updateScreen();
            }
        }

        function calc() {
            if (expr === '') return;
            
            try {
                var evalExpr = expr;
                
                // Replace display operators with JavaScript operators
                evalExpr = evalExpr.replace(/×/g, '*');
                evalExpr = evalExpr.replace(/÷/g, '/');
                evalExpr = evalExpr.replace(/−/g, '-');
                
                // Handle nth root operation (a√√b = b^(1/a))
                evalExpr = evalExpr.replace(/([0-9.]+)√√([0-9.]+)/g, function(match, base, value) {
                    return 'Math.pow(' + value + ', 1/' + base + ')';
                });
                
                // Handle power operations (**) - convert to Math.pow
                evalExpr = evalExpr.replace(/([0-9.]+)\*\*([0-9.]+)/g, function(match, base, exp) {
                    return 'Math.pow(' + base + ',' + exp + ')';
                });
                
                // Handle modulo operation (%)
                evalExpr = evalExpr.replace(/([0-9.]+)%([0-9.]+)/g, function(match, a, b) {
                    return '(' + a + '%' + b + ')';
                });
                
                // Handle scientific notation (e)
                evalExpr = evalExpr.replace(/([0-9.]+)e([+-]?[0-9]+)/gi, function(match, mantissa, exponent) {
                    return mantissa + '*Math.pow(10,' + exponent + ')';
                });
                
                // Handle custom base logarithm (log(a,b) format)
                evalExpr = evalExpr.replace(/log\(([0-9.]+),([0-9.]+)\)/g, function(match, base, value) {
                    return 'Math.log(' + value + ')/Math.log(' + base + ')';
                });
                
                var result = eval(evalExpr);
                
                if (!isFinite(result)) {
                    res = 'Error';
                } else {
                    result = cleanNumber(result);
                    res = result.toString();
                    lastAnswer = res;
                    saveHistory(expr, res);
                }
                
                expr = '';
                waiting = true;
                updateScreen();
            } catch(e) {
                res = 'Error';
                expr = '';
                updateScreen();
            }
        }

        function cleanNumber(num) {
            // Remove floating point errors and unnecessary decimals
            if (Math.abs(num) < 1e-10) return 0;
            
            var rounded = Math.round(num * 1e10) / 1e10;
            
            // Check if it's close enough to an integer
            if (Math.abs(rounded - Math.round(rounded)) < 1e-10) {
                return Math.round(rounded);
            }
            
            return rounded;
        }

        function saveHistory(expression, result) {
            var item = {
                expr: expression,
                res: result,
                time: new Date().toLocaleTimeString()
            };
            
            historyList.unshift(item);
            
            if (historyList.length > 50) {
                historyList.pop();
            }
            
            updateHistory();
        }

        function updateHistory() {
            var historyDiv = document.getElementById('history');
            
            if (historyList.length === 0) {
                historyDiv.innerHTML = '<p style="color: #999; text-align: center;">No calculations yet</p>';
                return;
            }
            
            var html = '';
            for (var i = 0; i < historyList.length; i++) {
                var item = historyList[i];
                html += '<div class="history-item" onclick="useHistoryResult(\'' + escapeQuotes(item.res) + '\')">';
                html += '<div class="history-expr">' + escapeHtml(item.expr) + '</div>';
                html += '<div class="history-result">= ' + escapeHtml(item.res) + '</div>';
                html += '</div>';
            }
            
            historyDiv.innerHTML = html;
        }

        function escapeHtml(text) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        function escapeQuotes(text) {
            return text.replace(/'/g, "\\'").replace(/"/g, '\\"');
        }

        function useHistoryResult(value) {
            expr = value;
            res = value;
            waiting = false;
            updateScreen();
        }

        function clearHistory() {
            if (historyList.length === 0) return;
            
            if (confirm('Clear all calculation history?')) {
                historyList = [];
                updateHistory();
            }
        }
    </script>
</body>
</html>