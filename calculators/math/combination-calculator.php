<?php
/**
 * Combination & Permutation Calculator
 * File: combination-calculator.php
 * Description: Calculate combinations, permutations, and factorials
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Combination & Permutation Calculator - nCr, nPr Online</title>
    <meta name="description" content="Calculate combinations (nCr), permutations (nPr), factorial, and binomial coefficients online with step-by-step solutions.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 12px; }
        header { background: rgba(255,255,255,0.1); color: white; padding: 20px 16px; text-align: center; border-radius: 12px; margin-bottom: 16px; backdrop-filter: blur(10px); }
        header h1 { font-size: 1.5rem; margin-bottom: 8px; font-weight: 700; }
        header p { font-size: 0.875rem; opacity: 0.9; }
        .container { max-width: 100%; margin: 0 auto; }
        .breadcrumb { margin-bottom: 16px; text-align: center; }
        .breadcrumb a { color: white; text-decoration: none; font-weight: 500; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 8px; display: inline-block; backdrop-filter: blur(10px); font-size: 0.875rem; transition: all 0.3s; }
        .calculator-body { background: white; padding: 16px; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); margin-bottom: 16px; }
        .calc-tabs { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; margin-bottom: 16px; }
        .tab-btn { padding: 12px 8px; background: #f0f0f0; border: none; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; font-size: 0.8rem; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .input-section { margin-bottom: 16px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 0.9rem; }
        .input-section input { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; }
        .input-section input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.3rem; }
        .result-box { background: white; padding: 16px; border-radius: 10px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; }
        .result-label { font-size: 0.8rem; color: #666; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .result-value { font-size: 1.4rem; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; word-break: break-word; line-height: 1.4; }
        .formula-box { background: #f9f9f9; padding: 14px; border-radius: 8px; border-left: 4px solid #667eea; margin: 14px 0; font-size: 0.85rem; line-height: 1.7; }
        .formula-box strong { color: #667eea; display: block; margin-bottom: 6px; }
        .info-box { background: white; padding: 20px; border-radius: 12px; line-height: 1.8; box-shadow: 0 8px 30px rgba(0,0,0,0.15); margin-top: 16px; }
        .info-box h3 { color: #667eea; margin-bottom: 14px; font-size: 1.2rem; }
        .info-box p { margin-bottom: 10px; color: #555; font-size: 0.85rem; }
        .steps-box { background: #fff3cd; padding: 14px; border-radius: 8px; border-left: 4px solid #ffc107; margin: 14px 0; }
        .steps-box strong { color: #f57c00; display: block; margin-bottom: 8px; }
        .step { padding: 8px 0; border-bottom: 1px solid #ffe082; }
        .step:last-child { border-bottom: none; }
        
        @media (min-width: 480px) { .calc-tabs { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 768px) { 
            body { padding: 24px; }
            .container { max-width: 720px; margin: 0 auto; }
            header h1 { font-size: 2rem; }
            .calculator-body { padding: 24px; }
            .calc-tabs { grid-template-columns: repeat(4, 1fr); }
        }
        @media (min-width: 1024px) { .container { max-width: 960px; } }
        @media (min-width: 1280px) { .container { max-width: 1100px; } }
        @media (max-width: 479px) { 
            .tab-btn { font-size: 0.75rem; padding: 10px 6px; }
            .result-value { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    <header>
        <h1>🔢 Combination & Permutation Calculator</h1>
        <p>Calculate nCr, nPr, Factorial & More</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Combination</button>
                <button class="tab-btn" onclick="switchTab(1)">Permutation</button>
                <button class="tab-btn" onclick="switchTab(2)">Factorial</button>
                <button class="tab-btn" onclick="switchTab(3)">Binomial</button>
            </div>

            <!-- Tab 1: Combination -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">🔢 Combination (nCr)</h3>
                <p style="margin-bottom: 16px; color: #666; font-size: 0.9rem;">Calculate number of ways to choose r items from n items (order doesn't matter)</p>
                <div class="input-section">
                    <label>Total items (n)</label>
                    <input type="number" id="comb_n" value="10" min="0" step="1">
                </div>
                <div class="input-section">
                    <label>Items to choose (r)</label>
                    <input type="number" id="comb_r" value="3" min="0" step="1">
                </div>
                <button class="btn" onclick="calcCombination()">Calculate Combination</button>
            </div>

            <!-- Tab 2: Permutation -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">🔄 Permutation (nPr)</h3>
                <p style="margin-bottom: 16px; color: #666; font-size: 0.9rem;">Calculate number of ways to arrange r items from n items (order matters)</p>
                <div class="input-section">
                    <label>Total items (n)</label>
                    <input type="number" id="perm_n" value="10" min="0" step="1">
                </div>
                <div class="input-section">
                    <label>Items to arrange (r)</label>
                    <input type="number" id="perm_r" value="3" min="0" step="1">
                </div>
                <button class="btn" onclick="calcPermutation()">Calculate Permutation</button>
            </div>

            <!-- Tab 3: Factorial -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">❗ Factorial (n!)</h3>
                <p style="margin-bottom: 16px; color: #666; font-size: 0.9rem;">Calculate factorial of a number (n! = n × (n-1) × ... × 2 × 1)</p>
                <div class="input-section">
                    <label>Number (n)</label>
                    <input type="number" id="fact_n" value="5" min="0" step="1">
                </div>
                <button class="btn" onclick="calcFactorial()">Calculate Factorial</button>
            </div>

            <!-- Tab 4: Binomial Coefficient -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📊 Binomial Coefficient</h3>
                <p style="margin-bottom: 16px; color: #666; font-size: 0.9rem;">Calculate binomial coefficient for (a+b)^n expansion</p>
                <div class="input-section">
                    <label>Power (n)</label>
                    <input type="number" id="binom_n" value="5" min="0" step="1">
                </div>
                <div class="input-section">
                    <label>Term position (k)</label>
                    <input type="number" id="binom_k" value="2" min="0" step="1">
                </div>
                <button class="btn" onclick="calcBinomial()">Calculate Coefficient</button>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Formulas & Concepts</h3>
            <div class="formula-box">
                <strong>Combination (nCr):</strong>
                C(n,r) = n! / (r! × (n-r)!)<br>
                Used when order doesn't matter (e.g., choosing team members)
            </div>
            <div class="formula-box">
                <strong>Permutation (nPr):</strong>
                P(n,r) = n! / (n-r)!<br>
                Used when order matters (e.g., arranging books)
            </div>
            <div class="formula-box">
                <strong>Factorial (n!):</strong>
                n! = n × (n-1) × (n-2) × ... × 2 × 1<br>
                0! = 1 (by definition)
            </div>
            <div class="formula-box">
                <strong>Relationship:</strong>
                P(n,r) = C(n,r) × r!<br>
                Permutation = Combination × Arrangements
            </div>
        </div>
    </div>

    <script>
        function switchTab(i) {
            document.querySelectorAll('.tab-btn').forEach((b,j)=>b.className=j===i?'tab-btn active':'tab-btn');
            document.querySelectorAll('.tab-content').forEach((c,j)=>c.className=j===i?'tab-content active':'tab-content');
            document.getElementById('result').classList.remove('show');
        }
        
        function factorial(n) {
            if(n<0) return NaN;
            if(n===0||n===1) return 1;
            if(n>170) return Infinity; // JavaScript limit
            let result = 1;
            for(let i=2; i<=n; i++) result *= i;
            return result;
        }
        
        function combination(n, r) {
            if(r>n||r<0||n<0) return 0;
            if(r===0||r===n) return 1;
            // Optimize: C(n,r) = C(n,n-r)
            r = Math.min(r, n-r);
            let result = 1;
            for(let i=0; i<r; i++) {
                result *= (n-i);
                result /= (i+1);
            }
            return Math.round(result);
        }
        
        function permutation(n, r) {
            if(r>n||r<0||n<0) return 0;
            if(r===0) return 1;
            let result = 1;
            for(let i=0; i<r; i++) {
                result *= (n-i);
            }
            return result;
        }
        
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
        }
        
        function formatNumber(n) {
            if(n===Infinity) return '∞ (Too large)';
            if(isNaN(n)) return 'Invalid';
            if(n > 1e15) return n.toExponential(4);
            return n.toLocaleString('en-US');
        }
        
        function calcCombination() {
            const n = parseInt(document.getElementById('comb_n').value);
            const r = parseInt(document.getElementById('comb_r').value);
            
            if(isNaN(n)||isNaN(r)||n<0||r<0) {
                alert('⚠️ Please enter valid non-negative integers');
                return;
            }
            
            if(r>n) {
                alert('⚠️ r cannot be greater than n');
                return;
            }
            
            const result = combination(n, r);
            const nFact = factorial(n);
            const rFact = factorial(r);
            const nrFact = factorial(n-r);
            
            let html = `<div class="result-box">
                <div class="result-label">Combination C(${n},${r})</div>
                <div class="result-value">${formatNumber(result)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula:</strong>
                C(n,r) = n! / (r! × (n-r)!)<br>
                C(${n},${r}) = ${n}! / (${r}! × ${n-r}!)<br>
                = ${formatNumber(nFact)} / (${formatNumber(rFact)} × ${formatNumber(nrFact)})<br>
                = ${formatNumber(result)}
            </div>`;
            
            html += `<div class="steps-box">
                <strong>📝 Step-by-Step:</strong>
                <div class="step">Step 1: Calculate ${n}! = ${formatNumber(nFact)}</div>
                <div class="step">Step 2: Calculate ${r}! = ${formatNumber(rFact)}</div>
                <div class="step">Step 3: Calculate (${n}-${r})! = ${n-r}! = ${formatNumber(nrFact)}</div>
                <div class="step">Step 4: Apply formula: ${formatNumber(nFact)} ÷ (${formatNumber(rFact)} × ${formatNumber(nrFact)}) = ${formatNumber(result)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e3f2fd;border-left-color:#2196F3;">
                <strong style="color:#1976d2;">💡 Interpretation:</strong>
                There are ${formatNumber(result)} ways to choose ${r} items from ${n} items where order doesn't matter.
            </div>`;
            
            show(html);
        }
        
        function calcPermutation() {
            const n = parseInt(document.getElementById('perm_n').value);
            const r = parseInt(document.getElementById('perm_r').value);
            
            if(isNaN(n)||isNaN(r)||n<0||r<0) {
                alert('⚠️ Please enter valid non-negative integers');
                return;
            }
            
            if(r>n) {
                alert('⚠️ r cannot be greater than n');
                return;
            }
            
            const result = permutation(n, r);
            const nFact = factorial(n);
            const nrFact = factorial(n-r);
            
            let html = `<div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Permutation P(${n},${r})</div>
                <div class="result-value" style="color:#2196F3;">${formatNumber(result)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula:</strong>
                P(n,r) = n! / (n-r)!<br>
                P(${n},${r}) = ${n}! / (${n}-${r})!<br>
                = ${formatNumber(nFact)} / ${formatNumber(nrFact)}<br>
                = ${formatNumber(result)}
            </div>`;
            
            html += `<div class="steps-box">
                <strong>📝 Step-by-Step:</strong>
                <div class="step">Step 1: Calculate ${n}! = ${formatNumber(nFact)}</div>
                <div class="step">Step 2: Calculate (${n}-${r})! = ${n-r}! = ${formatNumber(nrFact)}</div>
                <div class="step">Step 3: Apply formula: ${formatNumber(nFact)} ÷ ${formatNumber(nrFact)} = ${formatNumber(result)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e3f2fd;border-left-color:#2196F3;">
                <strong style="color:#1976d2;">💡 Interpretation:</strong>
                There are ${formatNumber(result)} ways to arrange ${r} items from ${n} items where order matters.
            </div>`;
            
            const combResult = combination(n, r);
            html += `<div class="formula-box" style="background:#fff3cd;border-left-color:#ffc107;">
                <strong style="color:#f57c00;">🔗 Relationship:</strong>
                P(${n},${r}) = C(${n},${r}) × ${r}!<br>
                ${formatNumber(result)} = ${formatNumber(combResult)} × ${formatNumber(factorial(r))}
            </div>`;
            
            show(html);
        }
        
        function calcFactorial() {
            const n = parseInt(document.getElementById('fact_n').value);
            
            if(isNaN(n)||n<0) {
                alert('⚠️ Please enter a valid non-negative integer');
                return;
            }
            
            if(n>170) {
                alert('⚠️ Number too large (max 170)');
                return;
            }
            
            const result = factorial(n);
            
            let html = `<div class="result-box" style="border-left-color:#FF9800;">
                <div class="result-label">Factorial ${n}!</div>
                <div class="result-value" style="color:#FF9800;">${formatNumber(result)}</div>
            </div>`;
            
            if(n<=10) {
                let calculation = '';
                for(let i=n; i>=1; i--) {
                    calculation += i;
                    if(i>1) calculation += ' × ';
                }
                html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                    <strong style="color:#4CAF50;">Calculation:</strong>
                    ${n}! = ${calculation} = ${formatNumber(result)}
                </div>`;
            }
            
            html += `<div class="steps-box">
                <strong>📝 Factorial Definition:</strong>
                <div class="step">${n}! = ${n} × ${n-1} × ${n-2} × ... × 2 × 1</div>
                <div class="step">Result: ${formatNumber(result)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e3f2fd;border-left-color:#2196F3;">
                <strong style="color:#1976d2;">💡 Applications:</strong>
                • Number of ways to arrange ${n} items: ${formatNumber(result)}<br>
                • Used in combinations and permutations<br>
                • Important in probability and statistics
            </div>`;
            
            show(html);
        }
        
        function calcBinomial() {
            const n = parseInt(document.getElementById('binom_n').value);
            const k = parseInt(document.getElementById('binom_k').value);
            
            if(isNaN(n)||isNaN(k)||n<0||k<0) {
                alert('⚠️ Please enter valid non-negative integers');
                return;
            }
            
            if(k>n) {
                alert('⚠️ k cannot be greater than n');
                return;
            }
            
            const coeff = combination(n, k);
            
            let html = `<div class="result-box" style="border-left-color:#9C27B0;">
                <div class="result-label">Binomial Coefficient (${n} choose ${k})</div>
                <div class="result-value" style="color:#9C27B0;">${formatNumber(coeff)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula:</strong>
                Binomial Coefficient = C(n,k) = (n choose k)<br>
                = n! / (k! × (n-k)!)<br>
                = ${formatNumber(coeff)}
            </div>`;
            
            html += `<div class="formula-box" style="background:#f3e5f5;border-left-color:#9C27B0;">
                <strong style="color:#7B1FA2;">📊 In Binomial Expansion:</strong>
                (a+b)^${n} = ... + ${formatNumber(coeff)} × a^${n-k} × b^${k} + ...<br><br>
                The coefficient of the term a^${n-k}b^${k} is ${formatNumber(coeff)}
            </div>`;
            
            // Pascal's Triangle relation
            if(k>0 && k<n) {
                const prev1 = combination(n-1, k-1);
                const prev2 = combination(n-1, k);
                html += `<div class="formula-box" style="background:#fff3cd;border-left-color:#ffc107;">
                    <strong style="color:#f57c00;">🔺 Pascal's Triangle Property:</strong>
                    C(${n},${k}) = C(${n-1},${k-1}) + C(${n-1},${k})<br>
                    ${formatNumber(coeff)} = ${formatNumber(prev1)} + ${formatNumber(prev2)}
                </div>`;
            }
            
            show(html);
        }
    </script>
</body>
</html>