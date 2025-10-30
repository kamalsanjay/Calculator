<?php
/**
 * Factorial Calculator
 * File: factorial-calculator.php
 * Description: Calculate factorials and related operations
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Factorial Calculator - n!, Double Factorial, Subfactorial</title>
    <meta name="description" content="Calculate factorial, double factorial, subfactorial, and factorial-based operations with step-by-step solutions.">
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
        .input-section input { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; font-family: 'Courier New', monospace; }
        .input-section input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .input-hint { font-size: 0.8rem; color: #666; margin-top: 6px; font-style: italic; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .examples { display: grid; grid-template-columns: repeat(auto-fit, minmax(80px, 1fr)); gap: 8px; margin: 16px 0; }
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
        
        @media (min-width: 768px) { 
            body { padding: 24px; }
            .container { max-width: 720px; margin: 0 auto; }
            header h1 { font-size: 2rem; }
            .calculator-body { padding: 24px; }
        }
        @media (min-width: 1024px) { .container { max-width: 960px; } }
        @media (min-width: 1280px) { .container { max-width: 1100px; } }
        @media (max-width: 479px) {
            .examples { grid-template-columns: repeat(3, 1fr); }
            .result-value { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    <header>
        <h1>❗ Factorial Calculator</h1>
        <p>n!, Double Factorial, Subfactorial & More</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Factorial</button>
                <button class="tab-btn" onclick="switchTab(1)">Double</button>
                <button class="tab-btn" onclick="switchTab(2)">Subfactorial</button>
                <button class="tab-btn" onclick="switchTab(3)">Sum</button>
            </div>

            <!-- Tab 1: Factorial -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">❗ Factorial (n!)</h3>
                <div class="input-section">
                    <label>Enter Number (n)</label>
                    <input type="number" id="fact_n" value="5" min="0" step="1">
                    <div class="input-hint">Non-negative integer (0 to 170)</div>
                </div>
                <button class="btn" onclick="calcFactorial()">Calculate Factorial</button>
                <div class="examples">
                    <button class="example-btn" onclick="setVal('fact',0)">0!</button>
                    <button class="example-btn" onclick="setVal('fact',5)">5!</button>
                    <button class="example-btn" onclick="setVal('fact',10)">10!</button>
                    <button class="example-btn" onclick="setVal('fact',15)">15!</button>
                    <button class="example-btn" onclick="setVal('fact',20)">20!</button>
                </div>
            </div>

            <!-- Tab 2: Double Factorial -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">‼️ Double Factorial (n!!)</h3>
                <div class="input-section">
                    <label>Enter Number (n)</label>
                    <input type="number" id="dfact_n" value="6" min="0" step="1">
                    <div class="input-hint">Product of every other number</div>
                </div>
                <button class="btn" onclick="calcDoubleFactorial()">Calculate Double Factorial</button>
                <div class="examples">
                    <button class="example-btn" onclick="setVal('dfact',5)">5!!</button>
                    <button class="example-btn" onclick="setVal('dfact',6)">6!!</button>
                    <button class="example-btn" onclick="setVal('dfact',7)">7!!</button>
                    <button class="example-btn" onclick="setVal('dfact',8)">8!!</button>
                </div>
            </div>

            <!-- Tab 3: Subfactorial -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">⁉️ Subfactorial (!n)</h3>
                <div class="input-section">
                    <label>Enter Number (n)</label>
                    <input type="number" id="subfact_n" value="4" min="0" step="1">
                    <div class="input-hint">Derangements count</div>
                </div>
                <button class="btn" onclick="calcSubfactorial()">Calculate Subfactorial</button>
                <div class="examples">
                    <button class="example-btn" onclick="setVal('subfact',3)">!3</button>
                    <button class="example-btn" onclick="setVal('subfact',4)">!4</button>
                    <button class="example-btn" onclick="setVal('subfact',5)">!5</button>
                    <button class="example-btn" onclick="setVal('subfact',10)">!10</button>
                </div>
            </div>

            <!-- Tab 4: Factorial Sum -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">∑ Factorial Sum (1! + 2! + ... + n!)</h3>
                <div class="input-section">
                    <label>Enter Number (n)</label>
                    <input type="number" id="sum_n" value="5" min="1" step="1">
                    <div class="input-hint">Sum of factorials from 1 to n</div>
                </div>
                <button class="btn" onclick="calcFactorialSum()">Calculate Sum</button>
                <div class="examples">
                    <button class="example-btn" onclick="setVal('sum',5)">∑ to 5</button>
                    <button class="example-btn" onclick="setVal('sum',10)">∑ to 10</button>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Factorial Types</h3>
            <div class="formula-box">
                <strong>Factorial (n!):</strong>
                n! = n × (n-1) × (n-2) × ... × 2 × 1<br>
                0! = 1 (by definition)<br>
                Example: 5! = 5 × 4 × 3 × 2 × 1 = 120
            </div>
            <div class="formula-box">
                <strong>Double Factorial (n!!):</strong>
                • Even: n!! = n × (n-2) × (n-4) × ... × 2<br>
                • Odd: n!! = n × (n-2) × (n-4) × ... × 1<br>
                Example: 6!! = 6 × 4 × 2 = 48<br>
                Example: 5!! = 5 × 3 × 1 = 15
            </div>
            <div class="formula-box">
                <strong>Subfactorial (!n):</strong>
                !n = n! × Σ((-1)^k / k!) for k=0 to n<br>
                Counts derangements (permutations with no fixed points)<br>
                Example: !4 = 9
            </div>
            <div class="formula-box">
                <strong>Applications:</strong>
                • Permutations and combinations<br>
                • Probability calculations<br>
                • Series expansions<br>
                • Counting problems
            </div>
        </div>
    </div>

    <script>
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
        
        function setVal(type, n) {
            document.getElementById(type + '_n').value = n;
        }
        
        function factorial(n) {
            if(n < 0) return NaN;
            if(n === 0 || n === 1) return 1;
            if(n > 170) return Infinity;
            let result = 1;
            for(let i = 2; i <= n; i++) result *= i;
            return result;
        }
        
        function formatNumber(n) {
            if(n === Infinity) return '∞ (Too large)';
            if(isNaN(n)) return 'Invalid';
            if(n > 1e15) return n.toExponential(4);
            return n.toLocaleString('en-US');
        }
        
        function calcFactorial() {
            const n = parseInt(document.getElementById('fact_n').value);
            
            if(isNaN(n) || n < 0) {
                return alert('⚠️ Please enter a non-negative integer');
            }
            
            if(n > 170) {
                return alert('⚠️ Number too large (max 170)');
            }
            
            const result = factorial(n);
            
            let html = `<div class="result-box">
                <div class="result-label">Expression</div>
                <div class="result-value">${n}!</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Result</div>
                <div class="result-value" style="color:#2196F3;">${formatNumber(result)}</div>
            </div>`;
            
            if(n === 0) {
                html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                    <strong style="color:#4CAF50;">Special Case:</strong>
                    0! = 1 (by definition)
                </div>`;
            } else if(n <= 10) {
                let calculation = [];
                for(let i = n; i >= 1; i--) calculation.push(i);
                
                html += `<div class="step-box">
                    <strong>📝 Calculation:</strong>
                    <div class="step">${n}! = ${calculation.join(' × ')}</div>
                    <div class="step">= ${formatNumber(result)}</div>
                </div>`;
            } else {
                let partial = [];
                for(let i = n; i >= Math.max(n-3, 1); i--) partial.push(i);
                
                html += `<div class="step-box">
                    <strong>📝 Calculation:</strong>
                    <div class="step">${n}! = ${partial.join(' × ')} × ... × 2 × 1</div>
                    <div class="step">= ${formatNumber(result)}</div>
                </div>`;
            }
            
            // Show some factorial properties
            html += `<div class="formula-box" style="background:#e3f2fd;border-left-color:#2196F3;">
                <strong style="color:#1976d2;">💡 Properties:</strong>
                • ${n}! has ${n === 0 ? 0 : String(result).length} digits<br>
                • ${n}! = ${n} × ${n-1}! = ${n} × ${formatNumber(factorial(n-1))}<br>
                ${n > 1 ? `• Trailing zeros: ${countTrailingZeros(n)}` : ''}
            </div>`;
            
            show(html);
        }
        
        function countTrailingZeros(n) {
            let count = 0;
            for(let i = 5; i <= n; i *= 5) {
                count += Math.floor(n / i);
            }
            return count;
        }
        
        function calcDoubleFactorial() {
            const n = parseInt(document.getElementById('dfact_n').value);
            
            if(isNaN(n) || n < 0) {
                return alert('⚠️ Please enter a non-negative integer');
            }
            
            let result = 1;
            let steps = [];
            
            if(n === 0 || n === 1) {
                result = 1;
                steps.push(`${n}!! = 1`);
            } else {
                for(let i = n; i >= 2; i -= 2) {
                    result *= i;
                    steps.push(i);
                }
            }
            
            let html = `<div class="result-box">
                <div class="result-label">Expression</div>
                <div class="result-value">${n}!!</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Result</div>
                <div class="result-value" style="color:#2196F3;">${formatNumber(result)}</div>
            </div>`;
            
            if(n > 1) {
                html += `<div class="step-box">
                    <strong>📝 Calculation:</strong>
                    <div class="step">${n}!! = ${steps.join(' × ')}</div>
                    <div class="step">= ${formatNumber(result)}</div>
                </div>`;
            }
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula:</strong>
                ${n % 2 === 0 ? 
                    `Even: ${n}!! = ${n} × ${n-2} × ${n-4} × ... × 2` : 
                    `Odd: ${n}!! = ${n} × ${n-2} × ${n-4} × ... × 1`}
            </div>`;
            
            show(html);
        }
        
        function calcSubfactorial() {
            const n = parseInt(document.getElementById('subfact_n').value);
            
            if(isNaN(n) || n < 0) {
                return alert('⚠️ Please enter a non-negative integer');
            }
            
            if(n > 20) {
                return alert('⚠️ Number too large (max 20)');
            }
            
            // Calculate subfactorial using formula
            let result;
            if(n === 0) result = 1;
            else if(n === 1) result = 0;
            else {
                const nFact = factorial(n);
                let sum = 0;
                for(let k = 0; k <= n; k++) {
                    sum += Math.pow(-1, k) / factorial(k);
                }
                result = Math.round(nFact * sum);
            }
            
            let html = `<div class="result-box">
                <div class="result-label">Expression</div>
                <div class="result-value">!${n}</div>
            </div>
            <div class="result-box" style="border-left-color:#9C27B0;">
                <div class="result-label">Subfactorial (Derangements)</div>
                <div class="result-value" style="color:#9C27B0;">${formatNumber(result)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculation:</strong>
                <div class="step">!${n} = ${n}! × Σ((-1)^k / k!)</div>
                <div class="step">= ${formatNumber(result)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">💡 Meaning:</strong>
                There are ${formatNumber(result)} ways to arrange ${n} items such that no item is in its original position (derangements).
            </div>`;
            
            if(n <= 5) {
                html += `<div class="formula-box" style="background:#fff3cd;border-left-color:#ffc107;">
                    <strong style="color:#f57c00;">Example:</strong>
                    ${n === 3 ? 'For 3 items [1,2,3], derangements are: [2,3,1] and [3,1,2]' : ''}
                    ${n === 4 ? 'For 4 items, there are 9 arrangements where no item is in its original position' : ''}
                </div>`;
            }
            
            show(html);
        }
        
        function calcFactorialSum() {
            const n = parseInt(document.getElementById('sum_n').value);
            
            if(isNaN(n) || n < 1) {
                return alert('⚠️ Please enter a positive integer');
            }
            
            if(n > 20) {
                return alert('⚠️ Number too large (max 20)');
            }
            
            let sum = 0;
            let terms = [];
            
            for(let i = 1; i <= n; i++) {
                const fact = factorial(i);
                sum += fact;
                terms.push(`${i}! = ${formatNumber(fact)}`);
            }
            
            let html = `<div class="result-box">
                <div class="result-label">Expression</div>
                <div class="result-value">1! + 2! + ... + ${n}!</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Sum</div>
                <div class="result-value" style="color:#2196F3;">${formatNumber(sum)}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Terms:</strong>
                ${terms.map(t => '<div class="step">' + t + '</div>').join('')}
                <div class="step" style="border-top:2px solid #ffc107; margin-top:8px; padding-top:8px;">Sum = ${formatNumber(sum)}</div>
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>