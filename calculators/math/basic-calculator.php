<?php
/**
 * Basic Calculator (Fixed Version)
 * File: basic-calculator.php
 * Description: Simple and elegant basic calculator for everyday calculations
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Basic Calculator - Simple Online Calculator</title>
<meta name="description" content="Free basic calculator online. Simple and easy-to-use calculator for addition, subtraction, multiplication, and division.">
<style>
    * {margin:0;padding:0;box-sizing:border-box;}
    body {font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);min-height:100vh;padding:20px;}
    header {background:rgba(255,255,255,0.1);color:white;padding:30px 20px;text-align:center;border-radius:15px;margin-bottom:30px;backdrop-filter:blur(10px);}
    header h1 {margin:0 0 10px 0;font-size:2em;}
    header p {margin:0;opacity:0.9;font-size:1.1em;}
    .container {max-width:1200px;margin:0 auto;}
    .breadcrumb {margin-bottom:20px;text-align:center;}
    .breadcrumb a {color:white;text-decoration:none;font-weight:500;background:rgba(255,255,255,0.2);padding:10px 20px;border-radius:8px;display:inline-block;backdrop-filter:blur(10px);}
    .calculator-container {max-width:420px;margin:0 auto 30px;background:white;padding:30px;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.3);}
    .calc-display {background:#1a1a2e;color:#00ff88;padding:30px 20px;border-radius:15px;margin-bottom:25px;box-shadow:inset 0 4px 8px rgba(0,0,0,0.3);min-height:140px;display:flex;flex-direction:column;justify-content:space-between;}
    .calc-expression {font-size:1.1em;opacity:0.7;min-height:30px;margin-bottom:10px;text-align:right;font-family:'Courier New',monospace;word-wrap:break-word;color:#888;}
    .calc-result {font-size:2.8em;font-weight:bold;text-align:right;font-family:'Courier New',monospace;word-wrap:break-word;color:#00ff88;}
    .calc-buttons {display:grid;grid-template-columns:repeat(4,1fr);gap:12px;}
    .calc-btn {padding:25px 10px;border:none;border-radius:12px;font-size:1.4em;font-weight:600;cursor:pointer;transition:all 0.2s ease;background:#f5f5f5;color:#333;box-shadow:0 4px 8px rgba(0,0,0,0.1);user-select:none;}
    .calc-btn:hover {transform:translateY(-2px);box-shadow:0 6px 15px rgba(0,0,0,0.2);}
    .calc-btn:active {transform:translateY(0);box-shadow:0 2px 5px rgba(0,0,0,0.1);}
    .calc-btn.number {background:white;color:#333;}
    .calc-btn.operator {background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:white;}
    .calc-btn.equals {background:linear-gradient(135deg,#00ff88 0%,#00d4ff 100%);color:white;grid-column:span 2;}
    .calc-btn.clear {background:linear-gradient(135deg,#ff6b6b 0%,#ee5a6f 100%);color:white;}
    .calc-btn.special {background:#ffd93d;color:#333;}
    .calc-btn.zero {grid-column:span 2;}
    .memory-display {text-align:center;padding:12px;background:linear-gradient(135deg,#f0f0f0 0%,#e0e0e0 100%);border-radius:10px;margin-bottom:20px;font-size:1em;color:#666;font-weight:500;}
    .memory-value {font-weight:bold;color:#667eea;font-size:1.1em;}
    .history-section {background:white;padding:25px;border-radius:20px;box-shadow:0 10px 40px rgba(0,0,0,0.2);max-width:420px;margin:0 auto 30px;}
    .history-item {padding:15px;background:#f9f9f9;border-radius:10px;margin-bottom:12px;box-shadow:0 2px 8px rgba(0,0,0,0.05);cursor:pointer;transition:all 0.3s;border-left:4px solid #667eea;}
    .history-item:hover {transform:translateX(5px);box-shadow:0 4px 12px rgba(102,126,234,0.3);background:#fff;}
    .history-expr {color:#666;font-size:1em;font-family:'Courier New',monospace;margin-bottom:5px;}
    .history-result {color:#667eea;font-weight:bold;font-size:1.3em;font-family:'Courier New',monospace;}
    .info-box {background:white;padding:25px;border-radius:15px;line-height:1.8;max-width:420px;margin:0 auto 30px;box-shadow:0 10px 40px rgba(0,0,0,0.2);}
    .info-box h3 {color:#667eea;margin-bottom:15px;}
    .info-box p {margin-bottom:10px;color:#555;}
    .btn {background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:white;border:none;padding:12px 24px;border-radius:8px;cursor:pointer;font-weight:600;transition:all 0.3s;font-size:1em;}
    .btn:hover {transform:translateY(-2px);box-shadow:0 5px 15px rgba(102,126,234,0.4);}
    @media (max-width:500px){.calculator-container{padding:20px;}.calc-buttons{gap:8px;}.calc-btn{padding:18px 8px;font-size:1.2em;}.calc-result{font-size:2em;}}
</style>
</head>
<body>
<header>
    <h1>🔢 Basic Calculator</h1>
    <p>Simple and easy-to-use calculator</p>
</header>

<div class="container">
    <div class="breadcrumb">
        <a href="../index.php">← Back to Calculators</a>
    </div>

    <div class="calculator-container">
        <div class="memory-display">
            <span>Memory: </span>
            <span class="memory-value" id="memoryDisplay">0</span>
        </div>

        <div class="calc-display">
            <div class="calc-expression" id="expression"></div>
            <div class="calc-result" id="result">0</div>
        </div>

        <div class="calc-buttons">
            <button class="calc-btn clear" onclick="clearAll()">AC</button>
            <button class="calc-btn special" onclick="backspace()">⌫</button>
            <button class="calc-btn special" onclick="calculatePercentage()">%</button>
            <button class="calc-btn operator" onclick="appendOperator('/')">÷</button>

            <button class="calc-btn number" onclick="appendNumber('7')">7</button>
            <button class="calc-btn number" onclick="appendNumber('8')">8</button>
            <button class="calc-btn number" onclick="appendNumber('9')">9</button>
            <button class="calc-btn operator" onclick="appendOperator('*')">×</button>

            <button class="calc-btn number" onclick="appendNumber('4')">4</button>
            <button class="calc-btn number" onclick="appendNumber('5')">5</button>
            <button class="calc-btn number" onclick="appendNumber('6')">6</button>
            <button class="calc-btn operator" onclick="appendOperator('-')">−</button>

            <button class="calc-btn number" onclick="appendNumber('1')">1</button>
            <button class="calc-btn number" onclick="appendNumber('2')">2</button>
            <button class="calc-btn number" onclick="appendNumber('3')">3</button>
            <button class="calc-btn operator" onclick="appendOperator('+')">+</button>

            <button class="calc-btn number zero" onclick="appendNumber('0')">0</button>
            <button class="calc-btn special" onclick="appendNumber('.')">.</button>
            <button class="calc-btn equals" onclick="calculate()">=</button>
        </div>

        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-top:15px;">
            <button class="calc-btn special" onclick="memoryAdd()">M+</button>
            <button class="calc-btn special" onclick="memorySubtract()">M−</button>
            <button class="calc-btn special" onclick="memoryRecall()">MR</button>
            <button class="calc-btn special" onclick="memoryClear()">MC</button>
        </div>
    </div>

    <div class="history-section">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
            <h3 style="margin:0;color:#667eea;">📊 History</h3>
            <button class="btn" style="padding:8px 16px;font-size:0.9em;" onclick="clearHistory()">Clear</button>
        </div>
        <div id="history">
            <p style="color:#999;text-align:center;padding:20px;">No calculations yet</p>
        </div>
    </div>

    <div class="info-box">
        <h3>📖 How to Use</h3>
        <p><strong>Numbers:</strong> Click number buttons (0-9) or use keyboard</p>
        <p><strong>Operators:</strong> +, −, ×, ÷ for basic math operations</p>
        <p><strong>AC:</strong> Clear all and start fresh</p>
        <p><strong>⌫:</strong> Delete last digit (backspace)</p>
        <p><strong>%:</strong> Calculate percentage (e.g., 50 + 10%)</p>
        <p><strong>Memory:</strong> M+ (add), M− (subtract), MR (recall), MC (clear)</p>
        <p><strong>Keyboard:</strong> Use 0-9, +, -, *, /, Enter (=), Esc (AC)</p>
    </div>
</div>

<script>
let currentExpression = "";
let currentResult = "0";
let memoryValue = 0;
let history = [];
let waitingForNewNumber = false;

function updateDisplay() {
    document.getElementById("expression").textContent = currentExpression;
    document.getElementById("result").textContent = currentResult;
    document.getElementById("memoryDisplay").textContent = memoryValue.toFixed(2);
}

function appendNumber(num) {
    if (waitingForNewNumber) {
        currentExpression = "";
        waitingForNewNumber = false;
    }
    currentExpression += num;
    currentResult = currentExpression;
    updateDisplay();
}

function appendOperator(op) {
    if (currentExpression === "" && currentResult !== "0") currentExpression = currentResult;
    const lastChar = currentExpression.slice(-1);
    if ("+-*/".includes(lastChar)) currentExpression = currentExpression.slice(0, -1);
    currentExpression += op;
    waitingForNewNumber = false;
    updateDisplay();
}

function calculate() {
    if (!currentExpression) return;
    try {
        const expr = currentExpression.replace(/×/g, "*").replace(/÷/g, "/").replace(/−/g, "-");
        const result = Function('"use strict";return (' + expr + ")")();
        if (!isFinite(result)) throw new Error();
        currentResult = Number(result.toFixed(10)).toString();
        history.unshift({ expr: currentExpression, res: currentResult });
        if (history.length > 15) history.pop();
        currentExpression = "";
        waitingForNewNumber = true;
        renderHistory();
    } catch {
        currentResult = "Error";
    }
    updateDisplay();
}

function backspace() {
    if (currentExpression.length > 0) {
        currentExpression = currentExpression.slice(0, -1);
        currentResult = currentExpression || "0";
        updateDisplay();
    }
}

function clearAll() {
    currentExpression = "";
    currentResult = "0";
    waitingForNewNumber = false;
    updateDisplay();
}

function calculatePercentage() {
    if (currentExpression === "") return;
    try {
        const result = Function('"use strict";return (' + currentExpression + "/100)")();
        currentResult = Number(result.toFixed(10)).toString();
        updateDisplay();
    } catch {
        currentResult = "Error";
        updateDisplay();
    }
}

// Memory Functions
function memoryAdd(){const v=parseFloat(currentResult);if(!isNaN(v)){memoryValue+=v;updateDisplay();}}
function memorySubtract(){const v=parseFloat(currentResult);if(!isNaN(v)){memoryValue-=v;updateDisplay();}}
function memoryRecall(){currentExpression="";currentResult=memoryValue.toString();updateDisplay();}
function memoryClear(){memoryValue=0;updateDisplay();}

function renderHistory() {
    const div = document.getElementById("history");
    if (history.length === 0) {
        div.innerHTML = '<p style="color:#999;text-align:center;padding:20px;">No calculations yet</p>';
        return;
    }
    div.innerHTML = history.map(h=>`
        <div class="history-item" onclick="useResult('${h.res}')">
            <div class="history-expr">${h.expr}</div>
            <div class="history-result">= ${h.res}</div>
        </div>`).join("");
}

function useResult(v){currentExpression="";currentResult=v;waitingForNewNumber=false;updateDisplay();}
function clearHistory(){if(confirm("Clear all history?")){history=[];renderHistory();}}

// Keyboard support
document.addEventListener("keydown",e=>{
    if(e.key>="0"&&e.key<="9"){appendNumber(e.key);}
    else if(["+","-","*","/"].includes(e.key)){appendOperator(e.key);}
    else if(e.key==="."){appendNumber(".");}
    else if(e.key==="Enter"||e.key==="="){calculate();}
    else if(e.key==="Escape"){clearAll();}
    else if(e.key==="Backspace"){backspace();}
    else if(e.key==="%"){calculatePercentage();}
});
updateDisplay();
</script>
</body>
</html>