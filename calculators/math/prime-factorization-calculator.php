<?php
/**
 * Advanced Prime Factorization Calculator
 * File: prime-factorization-calculator.php
 * Description: Multiple methods for prime factorization with detailed analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Advanced Prime Factorization Calculator - All Methods</title>
    <meta name="description" content="Prime factorization with trial division, factor tree, prime checker, GCD/LCM finder, and divisibility analysis.">
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
        .calc-tabs { display: grid; grid-template-columns: repeat(auto-fit, minmax(95px, 1fr)); gap: 8px; margin-bottom: 16px; }
        .tab-btn { padding: 12px 8px; background: #f0f0f0; border: none; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; font-size: 0.75rem; line-height: 1.3; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .input-section { margin-bottom: 16px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 0.9rem; }
        .input-section input, .input-section textarea { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; font-family: 'Courier New', monospace; }
        .input-section textarea { min-height: 80px; resize: vertical; }
        .input-section input:focus, .input-section textarea:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .input-hint { font-size: 0.8rem; color: #666; margin-top: 6px; font-style: italic; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .examples { display: grid; grid-template-columns: repeat(auto-fit, minmax(90px, 1fr)); gap: 8px; margin: 16px 0; }
        .example-btn { padding: 10px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; font-family: 'Courier New', monospace; }
        .example-btn:hover { background: #667eea; color: white; transform: translateY(-2px); }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.3rem; }
        .result-box { background: white; padding: 16px; border-radius: 10px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; }
        .result-label { font-size: 0.75rem; color: #666; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .result-value { font-size: 1.3rem; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; word-break: break-word; line-height: 1.4; }
        .formula-box { background: #f9f9f9; padding: 14px; border-radius: 8px; border-left: 4px solid #667eea; margin: 14px 0; font-size: 0.85rem; line-height: 1.7; }
        .formula-box strong { color: #667eea; display: block; margin-bottom: 6px; }
        .step-box { background: #fff3cd; padding: 14px; border-radius: 8px; border-left: 4px solid #ffc107; margin: 14px 0; }
        .step-box strong { color: #f57c00; display: block; margin-bottom: 8px; }
        .step { padding: 6px 0; border-bottom: 1px solid #ffe082; font-family: 'Courier New', monospace; font-size: 0.85rem; }
        .step:last-child { border-bottom: none; }
        .tree-box { background: #e8f5e9; padding: 14px; border-radius: 8px; border-left: 4px solid #4CAF50; margin: 14px 0; font-family: 'Courier New', monospace; font-size: 0.85rem; line-height: 1.8; }
        .info-box { background: white; padding: 20px; border-radius: 12px; line-height: 1.8; box-shadow: 0 8px 30px rgba(0,0,0,0.15); margin-top: 16px; }
        .info-box h3 { color: #667eea; margin-bottom: 14px; font-size: 1.2rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px; margin-bottom: 16px; }
        
        @media (min-width: 768px) { 
            body { padding: 24px; }
            .container { max-width: 720px; margin: 0 auto; }
            header h1 { font-size: 2rem; }
            .calculator-body { padding: 24px; }
        }
        @media (min-width: 1024px) { .container { max-width: 960px; } }
        @media (min-width: 1280px) { .container { max-width: 1100px; } }
        @media (max-width: 479px) {
            .result-value { font-size: 1.1rem; }
            .calc-tabs { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <header>
        <h1>🔢 Prime Factorization Calculator</h1>
        <p>Advanced Methods & Complete Analysis</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Prime<br>Factorization</button>
                <button class="tab-btn" onclick="switchTab(1)">Prime<br>Checker</button>
                <button class="tab-btn" onclick="switchTab(2)">GCD<br>& LCM</button>
                <button class="tab-btn" onclick="switchTab(3)">Divisibility<br>Test</button>
                <button class="tab-btn" onclick="switchTab(4)">Prime<br>Range</button>
            </div>

            <!-- Tab 1: Prime Factorization -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">🔬 Prime Factorization</h3>
                <div class="input-section">
                    <label>Enter Number</label>
                    <input type="number" id="factor_num" value="60" min="2" step="1">
                    <div class="input-hint">Break down into prime factors</div>
                </div>
                <button class="btn" onclick="calcFactorization()">Calculate Prime Factors</button>
                <div class="examples">
                    <button class="example-btn" onclick="setNum('factor_num',60)">60</button>
                    <button class="example-btn" onclick="setNum('factor_num',84)">84</button>
                    <button class="example-btn" onclick="setNum('factor_num',144)">144</button>
                    <button class="example-btn" onclick="setNum('factor_num',360)">360</button>
                </div>
            </div>

            <!-- Tab 2: Prime Checker -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">✓ Prime Number Checker</h3>
                <div class="input-section">
                    <label>Enter Number</label>
                    <input type="number" id="prime_check" value="97" min="2" step="1">
                    <div class="input-hint">Check if number is prime</div>
                </div>
                <button class="btn" onclick="checkPrime()">Check Prime</button>
                <div class="examples">
                    <button class="example-btn" onclick="setNum('prime_check',97)">97</button>
                    <button class="example-btn" onclick="setNum('prime_check',100)">100</button>
                    <button class="example-btn" onclick="setNum('prime_check',127)">127</button>
                </div>
            </div>

            <!-- Tab 3: GCD & LCM -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📊 GCD & LCM Calculator</h3>
                <div class="input-section">
                    <label>Enter Numbers (comma-separated)</label>
                    <textarea id="gcd_nums" placeholder="Example: 12, 18, 24">12, 18, 24</textarea>
                    <div class="input-hint">Calculate GCD and LCM of multiple numbers</div>
                </div>
                <button class="btn" onclick="calcGCDLCM()">Calculate GCD & LCM</button>
            </div>

            <!-- Tab 4: Divisibility Test -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">➗ Divisibility Tests</h3>
                <div class="input-section">
                    <label>Enter Number</label>
                    <input type="number" id="div_num" value="120" min="1" step="1">
                    <div class="input-hint">Test divisibility by 2, 3, 4, 5, 6, 8, 9, 10, 11</div>
                </div>
                <button class="btn" onclick="testDivisibility()">Run Tests</button>
                <div class="examples">
                    <button class="example-btn" onclick="setNum('div_num',120)">120</button>
                    <button class="example-btn" onclick="setNum('div_num',999)">999</button>
                </div>
            </div>

            <!-- Tab 5: Prime Range -->
            <div id="tab4" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📈 Primes in Range</h3>
                <div class="input-section">
                    <label>Start Number</label>
                    <input type="number" id="range_start" value="1" min="1" step="1">
                </div>
                <div class="input-section">
                    <label>End Number</label>
                    <input type="number" id="range_end" value="100" min="2" step="1">
                    <div class="input-hint">Maximum range: 10,000 numbers</div>
                </div>
                <button class="btn" onclick="findPrimesInRange()">Find Primes</button>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Methods & Concepts</h3>
            <div class="formula-box">
                <strong>Prime Factorization:</strong>
                Express a number as product of prime numbers<br>
                Methods: Trial Division, Factor Tree, Fermat's Method
            </div>
            <div class="formula-box">
                <strong>Trial Division:</strong>
                Divide by primes starting from 2 until quotient is 1<br>
                Most efficient for small to medium numbers
            </div>
            <div class="formula-box">
                <strong>Fundamental Theorem:</strong>
                Every integer > 1 has unique prime factorization<br>
                Order doesn't matter: 12 = 2² × 3 = 3 × 2²
            </div>
            <div class="formula-box">
                <strong>GCD (Greatest Common Divisor):</strong>
                Largest number dividing all given numbers<br>
                Using Euclidean algorithm
            </div>
            <div class="formula-box">
                <strong>LCM (Least Common Multiple):</strong>
                Smallest number divisible by all given numbers<br>
                Formula: LCM(a,b) = (a × b) / GCD(a,b)
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
        
        function setNum(id, val) {
            document.getElementById(id).value = val;
        }
        
        function primeFactorize(n) {
            const factors = [];
            const steps = [];
            let original = n;
            
            // Check for 2s
            while(n % 2 === 0) {
                factors.push(2);
                steps.push(`${n} ÷ 2 = ${n/2}`);
                n /= 2;
            }
            
            // Check odd numbers from 3
            for(let i = 3; i * i <= n; i += 2) {
                while(n % i === 0) {
                    factors.push(i);
                    steps.push(`${n} ÷ ${i} = ${n/i}`);
                    n /= i;
                }
            }
            
            // If n is still > 1, it's prime
            if(n > 1) {
                factors.push(n);
                steps.push(`${n} is prime`);
            }
            
            return {factors, steps, original};
        }
        
        function formatFactors(factors) {
            const counts = {};
            factors.forEach(f => counts[f] = (counts[f] || 0) + 1);
            
            return Object.entries(counts)
                .map(([p, c]) => c > 1 ? `${p}^${c}` : p)
                .join(' × ');
        }
        
        function buildFactorTree(n) {
            let tree = `${n}
`;
            let level = 0;
            
            function addLevel(num, indent) {
                if(isPrime(num)) return;
                
                for(let i = 2; i <= num; i++) {
                    if(num % i === 0) {
                        const other = num / i;
                        tree += `${'  '.repeat(indent)}├─ ${i}
`;
                        tree += `${'  '.repeat(indent)}└─ ${other}
`;
                        
                        if(!isPrime(i)) addLevel(i, indent + 1);
                        if(!isPrime(other)) addLevel(other, indent + 1);
                        break;
                    }
                }
            }
            
            addLevel(n, 1);
            return tree;
        }
        
        function isPrime(n) {
            if(n < 2) return false;
            if(n === 2) return true;
            if(n % 2 === 0) return false;
            
            for(let i = 3; i * i <= n; i += 2) {
                if(n % i === 0) return false;
            }
            return true;
        }
        
        function gcd(a, b) {
            while(b !== 0) {
                let temp = b;
                b = a % b;
                a = temp;
            }
            return a;
        }
        
        function lcm(a, b) {
            return (a * b) / gcd(a, b);
        }
        
        function calcFactorization() {
            const n = parseInt(document.getElementById('factor_num').value);
            
            if(isNaN(n) || n < 2) {
                return alert('⚠️ Enter a number ≥ 2');
            }
            
            const result = primeFactorize(n);
            const formatted = formatFactors(result.factors);
            
            // Count unique primes
            const uniquePrimes = [...new Set(result.factors)];
            const factorCounts = {};
            result.factors.forEach(f => factorCounts[f] = (factorCounts[f] || 0) + 1);
            
            let html = `<div class="result-box">
                <div class="result-label">Number</div>
                <div class="result-value">${n}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Prime Factorization</div>
                <div class="result-value" style="color:#2196F3;">${formatted}</div>
            </div>`;
            
            html += `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Prime Factors</div>
                    <div class="result-value" style="color:#4CAF50;font-size:1rem;">${result.factors.join(', ')}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Unique Primes</div>
                    <div class="result-value" style="color:#FF9800;">${uniquePrimes.length}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Trial Division Steps:</strong>`;
            result.steps.forEach(step => {
                html += `<div class="step">${step}</div>`;
            });
            html += `</div>`;
            
            html += `<div class="tree-box">
                <strong style="color:#4CAF50;">🌳 Factor Tree:</strong><br>
                <pre style="margin-top:8px;">${buildFactorTree(n)}</pre>
            </div>`;
            
            // Analysis
            const numFactors = Object.values(factorCounts).reduce((a,b) => a*(b+1), 1);
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">📊 Analysis:</strong>
                • Original number: ${n}<br>
                • Prime factorization: ${formatted}<br>
                • Number of prime factors: ${result.factors.length}<br>
                • Unique prime factors: ${uniquePrimes.join(', ')}<br>
                • Total divisors: ${numFactors}
            </div>`;
            
            show(html);
        }
        
        function checkPrime() {
            const n = parseInt(document.getElementById('prime_check').value);
            
            if(isNaN(n) || n < 2) {
                return alert('⚠️ Enter a number ≥ 2');
            }
            
            const prime = isPrime(n);
            
            let html = `<div class="result-box" style="border-left-color:${prime?'#4CAF50':'#F44336'};">
                <div class="result-label">Number</div>
                <div class="result-value">${n}</div>
            </div>
            <div class="result-box" style="border-left-color:${prime?'#4CAF50':'#F44336'};">
                <div class="result-label">Result</div>
                <div class="result-value" style="color:${prime?'#4CAF50':'#F44336'};">
                    ${prime ? '✓ PRIME' : '✗ COMPOSITE'}
                </div>
            </div>`;
            
            if(!prime) {
                const factors = primeFactorize(n);
                html += `<div class="step-box">
                    <strong>Prime Factorization:</strong>
                    <div class="step">${formatFactors(factors.factors)}</div>
                </div>`;
            } else {
                html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                    <strong style="color:#4CAF50;">✓ ${n} is Prime!</strong>
                    Only divisible by 1 and ${n}
                </div>`;
            }
            
            show(html);
        }
        
        function calcGCDLCM() {
            const input = document.getElementById('gcd_nums').value;
            const nums = input.split(/[s,]+/).map(v => parseInt(v.trim())).filter(v => !isNaN(v) && v > 0);
            
            if(nums.length < 2) {
                return alert('⚠️ Enter at least 2 numbers');
            }
            
            // Calculate GCD
            let gcdResult = nums[0];
            for(let i = 1; i < nums.length; i++) {
                gcdResult = gcd(gcdResult, nums[i]);
            }
            
            // Calculate LCM
            let lcmResult = nums[0];
            for(let i = 1; i < nums.length; i++) {
                lcmResult = lcm(lcmResult, nums[i]);
            }
            
            let html = `<div class="result-box">
                <div class="result-label">Numbers</div>
                <div class="result-value" style="font-size:1.1rem;">${nums.join(', ')}</div>
            </div>`;
            
            html += `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">GCD</div>
                    <div class="result-value" style="color:#2196F3;">${gcdResult}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">LCM</div>
                    <div class="result-value" style="color:#4CAF50;">${lcmResult}</div>
                </div>
            </div>`;
            
            // Show prime factorizations
            html += `<div class="step-box">
                <strong>📝 Prime Factorizations:</strong>`;
            nums.forEach(num => {
                const factors = primeFactorize(num);
                html += `<div class="step">${num} = ${formatFactors(factors.factors)}</div>`;
            });
            html += `</div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">📊 Results:</strong>
                • GCD (Greatest Common Divisor): ${gcdResult}<br>
                • LCM (Least Common Multiple): ${lcmResult}<br>
                • Product of GCD × LCM = ${gcdResult * lcmResult}
            </div>`;
            
            show(html);
        }
        
        function testDivisibility() {
            const n = parseInt(document.getElementById('div_num').value);
            
            if(isNaN(n) || n < 1) {
                return alert('⚠️ Enter a positive number');
            }
            
            const tests = [
                {d: 2, rule: 'Last digit is even (0,2,4,6,8)', result: n % 2 === 0},
                {d: 3, rule: 'Sum of digits divisible by 3', result: n % 3 === 0},
                {d: 4, rule: 'Last 2 digits divisible by 4', result: n % 4 === 0},
                {d: 5, rule: 'Last digit is 0 or 5', result: n % 5 === 0},
                {d: 6, rule: 'Divisible by both 2 and 3', result: n % 6 === 0},
                {d: 8, rule: 'Last 3 digits divisible by 8', result: n % 8 === 0},
                {d: 9, rule: 'Sum of digits divisible by 9', result: n % 9 === 0},
                {d: 10, rule: 'Last digit is 0', result: n % 10 === 0},
                {d: 11, rule: 'Alternating sum divisible by 11', result: n % 11 === 0}
            ];
            
            let html = `<div class="result-box">
                <div class="result-label">Number</div>
                <div class="result-value">${n}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>➗ Divisibility Tests:</strong>`;
            
            tests.forEach(test => {
                const icon = test.result ? '✓' : '✗';
                const color = test.result ? '#4CAF50' : '#F44336';
                html += `<div class="step" style="color:${color};">
                    ${icon} Divisible by ${test.d}: ${test.rule}
                </div>`;
            });
            html += `</div>`;
            
            const divisibleBy = tests.filter(t => t.result).map(t => t.d);
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">📊 Summary:</strong>
                ${n} is divisible by: ${divisibleBy.length > 0 ? divisibleBy.join(', ') : 'None of the tested numbers'}
            </div>`;
            
            show(html);
        }
        
        function findPrimesInRange() {
            const start = parseInt(document.getElementById('range_start').value);
            const end = parseInt(document.getElementById('range_end').value);
            
            if(isNaN(start) || isNaN(end) || start < 1 || end < start) {
                return alert('⚠️ Enter valid range');
            }
            
            if(end - start > 10000) {
                return alert('⚠️ Maximum range is 10,000 numbers');
            }
            
            const primes = [];
            for(let i = Math.max(2, start); i <= end; i++) {
                if(isPrime(i)) primes.push(i);
            }
            
            let html = `<div class="result-box">
                <div class="result-label">Range</div>
                <div class="result-value" style="font-size:1.1rem;">${start} to ${end}</div>
            </div>
            <div class="result-box" style="border-left-color:#4CAF50;">
                <div class="result-label">Prime Count</div>
                <div class="result-value" style="color:#4CAF50;">${primes.length}</div>
            </div>`;
            
            html += `<div class="tree-box">
                <strong style="color:#4CAF50;">Prime Numbers Found:</strong><br>
                <div style="margin-top:8px;line-height:1.6;">
                    ${primes.join(', ')}
                </div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">📊 Statistics:</strong>
                • Range: ${start} to ${end} (${end-start+1} numbers)<br>
                • Primes found: ${primes.length}<br>
                • Prime density: ${((primes.length/(end-start+1))*100).toFixed(2)}%
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>