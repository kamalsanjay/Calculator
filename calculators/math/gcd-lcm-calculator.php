<?php
/**
 * GCD & LCM Calculator
 * File: gcd-lcm-calculator.php
 * Description: Calculate GCD, LCM with prime factorization and multiple methods
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>GCD LCM Calculator - Greatest Common Divisor & Least Common Multiple</title>
    <meta name="description" content="Calculate GCD and LCM with Euclidean algorithm, prime factorization, and step-by-step solutions.">
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
        .calc-tabs { display: grid; grid-template-columns: repeat(auto-fit, minmax(80px, 1fr)); gap: 8px; margin-bottom: 16px; }
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
        .examples { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; margin: 16px 0; }
        .example-btn { padding: 10px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
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
        .prime-box { background: #e3f2fd; padding: 14px; border-radius: 8px; border-left: 4px solid #2196F3; margin: 14px 0; }
        .prime-box strong { color: #1976d2; display: block; margin-bottom: 8px; }
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
            .examples { grid-template-columns: repeat(2, 1fr); }
            .result-value { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    <header>
        <h1>🔢 GCD & LCM Calculator</h1>
        <p>Greatest Common Divisor & Least Common Multiple</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">GCD</button>
                <button class="tab-btn" onclick="switchTab(1)">LCM</button>
                <button class="tab-btn" onclick="switchTab(2)">Both</button>
                <button class="tab-btn" onclick="switchTab(3)">Prime</button>
            </div>

            <!-- Tab 1: GCD -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">🔍 Greatest Common Divisor (GCD)</h3>
                <div class="input-section">
                    <label>First Number</label>
                    <input type="number" id="gcd_a" value="48" min="1" step="1">
                </div>
                <div class="input-section">
                    <label>Second Number</label>
                    <input type="number" id="gcd_b" value="18" min="1" step="1">
                    <div class="input-hint">Also called HCF (Highest Common Factor)</div>
                </div>
                <button class="btn" onclick="calcGCD()">Calculate GCD</button>
                <div class="examples">
                    <button class="example-btn" onclick="setGCD(48,18)">48, 18</button>
                    <button class="example-btn" onclick="setGCD(24,36)">24, 36</button>
                    <button class="example-btn" onclick="setGCD(100,75)">100, 75</button>
                </div>
            </div>

            <!-- Tab 2: LCM -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">🔢 Least Common Multiple (LCM)</h3>
                <div class="input-section">
                    <label>First Number</label>
                    <input type="number" id="lcm_a" value="12" min="1" step="1">
                </div>
                <div class="input-section">
                    <label>Second Number</label>
                    <input type="number" id="lcm_b" value="18" min="1" step="1">
                    <div class="input-hint">Smallest number divisible by both</div>
                </div>
                <button class="btn" onclick="calcLCM()">Calculate LCM</button>
                <div class="examples">
                    <button class="example-btn" onclick="setLCM(12,18)">12, 18</button>
                    <button class="example-btn" onclick="setLCM(15,20)">15, 20</button>
                    <button class="example-btn" onclick="setLCM(8,12)">8, 12</button>
                </div>
            </div>

            <!-- Tab 3: Both GCD & LCM -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📊 Calculate Both GCD & LCM</h3>
                <div class="input-section">
                    <label>First Number</label>
                    <input type="number" id="both_a" value="24" min="1" step="1">
                </div>
                <div class="input-section">
                    <label>Second Number</label>
                    <input type="number" id="both_b" value="36" min="1" step="1">
                </div>
                <button class="btn" onclick="calcBoth()">Calculate Both</button>
            </div>

            <!-- Tab 4: Prime Factorization -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">🔬 Prime Factorization</h3>
                <div class="input-section">
                    <label>Enter Number</label>
                    <input type="number" id="prime_n" value="60" min="2" step="1">
                    <div class="input-hint">Break down into prime factors</div>
                </div>
                <button class="btn" onclick="calcPrime()">Find Prime Factors</button>
                <div class="examples">
                    <button class="example-btn" onclick="setPrime(60)">60</button>
                    <button class="example-btn" onclick="setPrime(84)">84</button>
                    <button class="example-btn" onclick="setPrime(120)">120</button>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Methods & Formulas</h3>
            <div class="formula-box">
                <strong>GCD (Greatest Common Divisor):</strong>
                • Euclidean Algorithm: Repeatedly divide and take remainder<br>
                • Formula: GCD(a, b) = GCD(b, a mod b) until b = 0<br>
                • Also called HCF (Highest Common Factor)
            </div>
            <div class="formula-box">
                <strong>LCM (Least Common Multiple):</strong>
                • Formula: LCM(a, b) = (a × b) / GCD(a, b)<br>
                • Smallest positive integer divisible by both numbers<br>
                • Used in fraction operations
            </div>
            <div class="formula-box">
                <strong>Prime Factorization:</strong>
                • Express number as product of prime numbers<br>
                • Example: 60 = 2² × 3 × 5<br>
                • Useful for GCD/LCM calculations
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
        
        function setGCD(a,b) {
            document.getElementById('gcd_a').value = a;
            document.getElementById('gcd_b').value = b;
        }
        
        function setLCM(a,b) {
            document.getElementById('lcm_a').value = a;
            document.getElementById('lcm_b').value = b;
        }
        
        function setPrime(n) {
            document.getElementById('prime_n').value = n;
        }
        
        function gcd(a, b) {
            const steps = [];
            const origA = a, origB = b;
            
            while(b !== 0) {
                const q = Math.floor(a / b);
                const r = a % b;
                steps.push({a, b, q, r});
                a = b;
                b = r;
            }
            
            return {result: a, steps, origA, origB};
        }
        
        function primeFactorize(n) {
            const factors = [];
            const steps = [];
            let d = 2;
            
            while(n > 1) {
                while(n % d === 0) {
                    factors.push(d);
                    steps.push(`${n} ÷ ${d} = ${n/d}`);
                    n /= d;
                }
                d++;
                if(d * d > n && n > 1) {
                    factors.push(n);
                    steps.push(`${n} is prime`);
                    break;
                }
            }
            
            return {factors, steps};
        }
        
        function formatFactors(factors) {
            const counts = {};
            factors.forEach(f => counts[f] = (counts[f] || 0) + 1);
            
            return Object.entries(counts)
                .map(([p, c]) => c > 1 ? `${p}^${c}` : p)
                .join(' × ');
        }
        
        function calcGCD() {
            const a = parseInt(document.getElementById('gcd_a').value);
            const b = parseInt(document.getElementById('gcd_b').value);
            
            if(isNaN(a) || isNaN(b) || a < 1 || b < 1) {
                return alert('⚠️ Please enter positive integers');
            }
            
            const result = gcd(a, b);
            
            let html = `<div class="result-box">
                <div class="result-label">Numbers</div>
                <div class="result-value">${a} and ${b}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">GCD (Greatest Common Divisor)</div>
                <div class="result-value" style="color:#2196F3;">${result.result}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Euclidean Algorithm Steps:</strong>`;
            
            result.steps.forEach(s => {
                html += `<div class="step">${s.a} = ${s.b} × ${s.q} + ${s.r}</div>`;
            });
            
            html += `</div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">💡 Explanation:</strong>
                GCD(${a}, ${b}) = ${result.result}<br>
                This is the largest number that divides both ${a} and ${b} evenly.
            </div>`;
            
            show(html);
        }
        
        function calcLCM() {
            const a = parseInt(document.getElementById('lcm_a').value);
            const b = parseInt(document.getElementById('lcm_b').value);
            
            if(isNaN(a) || isNaN(b) || a < 1 || b < 1) {
                return alert('⚠️ Please enter positive integers');
            }
            
            const gcdVal = gcd(a, b).result;
            const lcmVal = (a * b) / gcdVal;
            
            let html = `<div class="result-box">
                <div class="result-label">Numbers</div>
                <div class="result-value">${a} and ${b}</div>
            </div>
            <div class="result-box" style="border-left-color:#9C27B0;">
                <div class="result-label">LCM (Least Common Multiple)</div>
                <div class="result-value" style="color:#9C27B0;">${lcmVal}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculation Steps:</strong>
                <div class="step">Step 1: Find GCD(${a}, ${b}) = ${gcdVal}</div>
                <div class="step">Step 2: LCM = (${a} × ${b}) / GCD</div>
                <div class="step">Step 3: LCM = ${a * b} / ${gcdVal}</div>
                <div class="step">Step 4: LCM = ${lcmVal}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">💡 Explanation:</strong>
                LCM(${a}, ${b}) = ${lcmVal}<br>
                This is the smallest number that is divisible by both ${a} and ${b}.
            </div>`;
            
            show(html);
        }
        
        function calcBoth() {
            const a = parseInt(document.getElementById('both_a').value);
            const b = parseInt(document.getElementById('both_b').value);
            
            if(isNaN(a) || isNaN(b) || a < 1 || b < 1) {
                return alert('⚠️ Please enter positive integers');
            }
            
            const gcdResult = gcd(a, b);
            const gcdVal = gcdResult.result;
            const lcmVal = (a * b) / gcdVal;
            
            let html = `<div class="result-box">
                <div class="result-label">Numbers</div>
                <div class="result-value">${a} and ${b}</div>
            </div>
            <div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">GCD</div>
                <div class="result-value" style="color:#2196F3;">${gcdVal}</div>
            </div>
            <div class="result-box" style="border-left-color:#9C27B0;">
                <div class="result-label">LCM</div>
                <div class="result-value" style="color:#9C27B0;">${lcmVal}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 GCD (Euclidean Algorithm):</strong>`;
            gcdResult.steps.forEach(s => {
                html += `<div class="step">${s.a} = ${s.b} × ${s.q} + ${s.r}</div>`;
            });
            html += `</div>`;
            
            html += `<div class="step-box">
                <strong>📝 LCM Calculation:</strong>
                <div class="step">LCM = (${a} × ${b}) / GCD(${a}, ${b})</div>
                <div class="step">LCM = ${a * b} / ${gcdVal} = ${lcmVal}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e3f2fd;border-left-color:#2196F3;">
                <strong style="color:#1976d2;">🔗 Relationship:</strong>
                GCD(${a}, ${b}) × LCM(${a}, ${b}) = ${a} × ${b}<br>
                ${gcdVal} × ${lcmVal} = ${a * b}
            </div>`;
            
            show(html);
        }
        
        function calcPrime() {
            const n = parseInt(document.getElementById('prime_n').value);
            
            if(isNaN(n) || n < 2) {
                return alert('⚠️ Please enter a number ≥ 2');
            }
            
            if(n > 100000) {
                return alert('⚠️ Number too large (max 100,000)');
            }
            
            const result = primeFactorize(n);
            const formatted = formatFactors(result.factors);
            
            let html = `<div class="result-box">
                <div class="result-label">Number</div>
                <div class="result-value">${n}</div>
            </div>
            <div class="result-box" style="border-left-color:#FF9800;">
                <div class="result-label">Prime Factorization</div>
                <div class="result-value" style="color:#FF9800;">${formatted}</div>
            </div>`;
            
            html += `<div class="prime-box">
                <strong>🔬 Prime Factors:</strong>
                <div style="padding:8px 0;font-family:'Courier New',monospace;">${result.factors.join(' × ')} = ${n}</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Factorization Steps:</strong>`;
            result.steps.forEach(s => {
                html += `<div class="step">${s}</div>`;
            });
            html += `</div>`;
            
            // Check if prime
            if(result.factors.length === 1) {
                html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                    <strong style="color:#4CAF50;">✨ ${n} is a Prime Number!</strong>
                    It can only be divided by 1 and itself.
                </div>`;
            }
            
            show(html);
        }
    </script>
</body>
</html>