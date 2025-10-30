<?php
/**
 * Advanced Permutation Calculator
 * File: permutation-calculator.php
 * Description: Complete permutation calculator with multiple calculation types and step-by-step solutions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Permutation Calculator - All Calculation Types</title>
    <meta name="description" content="Calculate permutations, combinations, factorial, arrangements with repetition and step-by-step solutions.">
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
        
        .calc-tabs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
            margin-bottom: 25px;
        }
        
        .tab-btn {
            padding: 16px 12px;
            background: #f0f0f0;
            border: none;
            border-radius: 12px;
            color: #333;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            text-align: center;
            font-size: 0.9rem;
            line-height: 1.3;
        }
        
        .tab-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
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
        
        .input-field {
            flex: 1;
            min-width: 200px;
        }
        
        .input-field input, .input-field select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1.1rem;
            outline: none;
            transition: all 0.3s;
        }
        
        .input-field input:focus, .input-field select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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
        
        .result-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .result-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            text-align: center;
        }
        
        .result-label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .result-value {
            font-size: 1.5rem;
            color: #4CAF50;
            font-weight: bold;
            font-family: 'Courier New', monospace;
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
        
        .permutation-display {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 4px solid #4CAF50;
        }
        
        .permutation-item {
            display: inline-block;
            background: white;
            padding: 8px 12px;
            margin: 5px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            font-family: 'Courier New', monospace;
            font-weight: 500;
        }
        
        .factorial-display {
            font-family: 'Courier New', monospace;
            font-size: 1.1rem;
            background: #e3f2fd;
            padding: 10px 15px;
            border-radius: 8px;
            margin: 10px 0;
            border-left: 4px solid #2196F3;
        }
        
        @media (max-width: 768px) {
            .input-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .input-field {
                width: 100%;
            }
            
            .calc-tabs {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .example-buttons {
                grid-template-columns: 1fr;
            }
        }
        
        .calculation-type {
            font-size: 1.1rem;
            color: #667eea;
            margin-bottom: 15px;
            font-weight: 600;
            text-align: center;
            padding: 10px;
            background: #f0f7ff;
            border-radius: 8px;
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
        
        .success-box {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #4CAF50;
            margin: 15px 0;
            color: #2e7d32;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>P(n,r) Advanced Permutation Calculator</h1>
            <p>Calculate permutations, combinations, factorial, arrangements with step-by-step solutions</p>
        </header>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Permutations<br>P(n,r)</button>
                <button class="tab-btn" onclick="switchTab(1)">Combinations<br>C(n,r)</button>
                <button class="tab-btn" onclick="switchTab(2)">Factorial<br>n!</button>
                <button class="tab-btn" onclick="switchTab(3)">Permutations<br>with Repetition</button>
                <button class="tab-btn" onclick="switchTab(4)">Circular<br>Permutations</button>
                <button class="tab-btn" onclick="switchTab(5)">Multiple<br>Groups</button>
            </div>

            <!-- Tab 1: Basic Permutations -->
            <div id="tab0" class="tab-content active">
                <div class="calculation-type">Permutations P(n,r) - Arrangements without repetition</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Total Items (n)</label>
                        <div class="input-field">
                            <input type="number" id="perm_n" value="5" step="1" min="1" max="100">
                            <div class="input-hint">Number of distinct items available</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Items Selected (r)</label>
                        <div class="input-field">
                            <input type="number" id="perm_r" value="3" step="1" min="1" max="100">
                            <div class="input-hint">Number of items to arrange (r ≤ n)</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculatePermutation()">Calculate Permutations</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setPermExample(5, 3)">P(5,3)</button>
                        <button class="example-btn" onclick="setPermExample(8, 2)">P(8,2)</button>
                        <button class="example-btn" onclick="setPermExample(10, 4)">P(10,4)</button>
                        <button class="example-btn" onclick="setPermExample(7, 7)">P(7,7)</button>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Combinations -->
            <div id="tab1" class="tab-content">
                <div class="calculation-type">Combinations C(n,r) - Selections without repetition</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Total Items (n)</label>
                        <div class="input-field">
                            <input type="number" id="comb_n" value="6" step="1" min="1" max="100">
                            <div class="input-hint">Number of distinct items available</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Items Selected (r)</label>
                        <div class="input-field">
                            <input type="number" id="comb_r" value="2" step="1" min="1" max="100">
                            <div class="input-hint">Number of items to select (r ≤ n)</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateCombination()">Calculate Combinations</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setCombExample(6, 2)">C(6,2)</button>
                        <button class="example-btn" onclick="setCombExample(10, 3)">C(10,3)</button>
                        <button class="example-btn" onclick="setCombExample(8, 5)">C(8,5)</button>
                        <button class="example-btn" onclick="setCombExample(12, 4)">C(12,4)</button>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Factorial -->
            <div id="tab2" class="tab-content">
                <div class="calculation-type">Factorial n! - Arrangements of all items</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Number (n)</label>
                        <div class="input-field">
                            <input type="number" id="factorial_n" value="5" step="1" min="0" max="50">
                            <div class="input-hint">Calculate n! = n × (n-1) × ... × 1</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateFactorial()">Calculate Factorial</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setFactorialExample(5)">5!</button>
                        <button class="example-btn" onclick="setFactorialExample(6)">6!</button>
                        <button class="example-btn" onclick="setFactorialExample(8)">8!</button>
                        <button class="example-btn" onclick="setFactorialExample(10)">10!</button>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Permutations with Repetition -->
            <div id="tab3" class="tab-content">
                <div class="calculation-type">Permutations with Repetition</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Total Items (n)</label>
                        <div class="input-field">
                            <input type="number" id="rep_n" value="3" step="1" min="1" max="100">
                            <div class="input-hint">Number of distinct items available</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Items Selected (r)</label>
                        <div class="input-field">
                            <input type="number" id="rep_r" value="2" step="1" min="1" max="100">
                            <div class="input-hint">Number of items to arrange (can repeat)</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateRepetition()">Calculate with Repetition</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setRepExample(3, 2)">n=3, r=2</button>
                        <button class="example-btn" onclick="setRepExample(4, 3)">n=4, r=3</button>
                        <button class="example-btn" onclick="setRepExample(5, 2)">n=5, r=2</button>
                        <button class="example-btn" onclick="setRepExample(2, 4)">n=2, r=4</button>
                    </div>
                </div>
            </div>

            <!-- Tab 5: Circular Permutations -->
            <div id="tab4" class="tab-content">
                <div class="calculation-type">Circular Permutations</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Number of Items (n)</label>
                        <div class="input-field">
                            <input type="number" id="circular_n" value="4" step="1" min="1" max="50">
                            <div class="input-hint">Items arranged in a circle</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateCircular()">Calculate Circular Permutations</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setCircularExample(4)">4 items</button>
                        <button class="example-btn" onclick="setCircularExample(5)">5 items</button>
                        <button class="example-btn" onclick="setCircularExample(6)">6 items</button>
                        <button class="example-btn" onclick="setCircularExample(8)">8 items</button>
                    </div>
                </div>
            </div>

            <!-- Tab 6: Multiple Groups -->
            <div id="tab5" class="tab-content">
                <div class="calculation-type">Permutations with Multiple Groups</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Total Items (n)</label>
                        <div class="input-field">
                            <input type="number" id="multi_n" value="8" step="1" min="1" max="100">
                            <div class="input-hint">Total number of items</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Group Sizes (comma separated)</label>
                        <div class="input-field">
                            <input type="text" id="multi_groups" value="3,3,2" placeholder="e.g., 3,3,2">
                            <div class="input-hint">Sizes of identical groups (sum must equal n)</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateMultipleGroups()">Calculate Multi-Group Permutations</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setMultiExample(8, '3,3,2')">8 items: 3,3,2</button>
                        <button class="example-btn" onclick="setMultiExample(6, '2,2,2')">6 items: 2,2,2</button>
                        <button class="example-btn" onclick="setMultiExample(10, '4,3,3')">10 items: 4,3,3</button>
                        <button class="example-btn" onclick="setMultiExample(7, '3,2,2')">7 items: 3,2,2</button>
                    </div>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Calculation Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Permutation & Combination Formulas</h3>
            
            <div class="info-grid">
                <div class="info-card">
                    <h4>Permutations P(n,r)</h4>
                    <p>P(n,r) = n! / (n-r)!</p>
                    <p>Arrangements where order matters, no repetition</p>
                </div>
                
                <div class="info-card">
                    <h4>Combinations C(n,r)</h4>
                    <p>C(n,r) = n! / [r! × (n-r)!]</p>
                    <p>Selections where order doesn't matter</p>
                </div>
                
                <div class="info-card">
                    <h4>Factorial n!</h4>
                    <p>n! = n × (n-1) × ... × 1</p>
                    <p>Arrangements of all n items</p>
                </div>
                
                <div class="info-card">
                    <h4>Permutations with Repetition</h4>
                    <p>nʳ</p>
                    <p>Arrangements where items can repeat</p>
                </div>
                
                <div class="info-card">
                    <h4>Circular Permutations</h4>
                    <p>(n-1)!</p>
                    <p>Arrangements in a circle (rotations considered same)</p>
                </div>
                
                <div class="info-card">
                    <h4>Multiple Groups</h4>
                    <p>n! / (g₁! × g₂! × ... × gₖ!)</p>
                    <p>Items divided into identical groups</p>
                </div>
            </div>
            
            <div class="formula-box">
                <strong>Key Concepts:</strong>
                • <strong>Permutation</strong>: Ordered arrangement of objects<br>
                • <strong>Combination</strong>: Selection of objects where order doesn't matter<br>
                • <strong>Factorial</strong>: Product of all positive integers up to n<br>
                • <strong>nPr</strong>: Permutations of n items taken r at a time<br>
                • <strong>nCr</strong>: Combinations of n items taken r at a time<br>
                • <strong>0!</strong>: Defined as 1 (by convention)
            </div>
        </div>
    </div>

    <script>
        let currentTab = 0;
        
        function switchTab(i) {
            currentTab = i;
            document.querySelectorAll('.tab-btn').forEach((btn, j) => {
                btn.className = j === i ? 'tab-btn active' : 'tab-btn';
            });
            document.querySelectorAll('.tab-content').forEach((content, j) => {
                content.className = j === i ? 'tab-content active' : 'tab-content';
            });
            document.getElementById('result').classList.remove('show');
        }
        
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
            document.getElementById('result').scrollIntoView({behavior: 'smooth', block: 'nearest'});
        }
        
        // Factorial function with memoization for performance
        const factorialCache = {};
        function factorial(n) {
            if (n < 0) return NaN;
            if (n === 0 || n === 1) return 1;
            if (factorialCache[n]) return factorialCache[n];
            
            let result = 1;
            for (let i = 2; i <= n; i++) {
                result *= i;
            }
            factorialCache[n] = result;
            return result;
        }
        
        // Example setters
        function setPermExample(n, r) {
            document.getElementById('perm_n').value = n;
            document.getElementById('perm_r').value = r;
        }
        
        function setCombExample(n, r) {
            document.getElementById('comb_n').value = n;
            document.getElementById('comb_r').value = r;
        }
        
        function setFactorialExample(n) {
            document.getElementById('factorial_n').value = n;
        }
        
        function setRepExample(n, r) {
            document.getElementById('rep_n').value = n;
            document.getElementById('rep_r').value = r;
        }
        
        function setCircularExample(n) {
            document.getElementById('circular_n').value = n;
        }
        
        function setMultiExample(n, groups) {
            document.getElementById('multi_n').value = n;
            document.getElementById('multi_groups').value = groups;
        }
        
        // Calculation functions
        function calculatePermutation() {
            const n = parseInt(document.getElementById('perm_n').value);
            const r = parseInt(document.getElementById('perm_r').value);
            
            if (isNaN(n) || isNaN(r) || n < 1 || r < 1) {
                show('<div class="error-box">⚠️ Please enter valid positive numbers</div>');
                return;
            }
            
            if (r > n) {
                show('<div class="error-box">⚠️ r cannot be greater than n</div>');
                return;
            }
            
            const result = factorial(n) / factorial(n - r);
            const nFactorial = factorial(n);
            const nMinusRFactorial = factorial(n - r);
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Permutations</div>
                    <div class="result-value">P(${n},${r}) = ${result.toLocaleString()}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Formula</div>
                    <div class="result-value" style="color:#2196F3;">n!/(n-r)!</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Calculation</div>
                    <div class="result-value" style="color:#4CAF50;">${n}!/(${n}-${r})!</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Calculate n! = ${n}! = ${nFactorial.toLocaleString()}</div>
                <div class="step">2. Calculate (n-r)! = (${n}-${r})! = ${nMinusRFactorial.toLocaleString()}</div>
                <div class="step">3. Apply formula: P(n,r) = n! / (n-r)!</div>
                <div class="step">4. P(${n},${r}) = ${nFactorial.toLocaleString()} / ${nMinusRFactorial.toLocaleString()} = ${result.toLocaleString()}</div>
            </div>`;
            
            html += `<div class="factorial-display">${n}! = ${getFactorialDisplay(n)}</div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                There are ${result.toLocaleString()} ways to arrange ${r} items from ${n} distinct items when order matters.
            </div>`;
            
            show(html);
        }
        
        function calculateCombination() {
            const n = parseInt(document.getElementById('comb_n').value);
            const r = parseInt(document.getElementById('comb_r').value);
            
            if (isNaN(n) || isNaN(r) || n < 1 || r < 1) {
                show('<div class="error-box">⚠️ Please enter valid positive numbers</div>');
                return;
            }
            
            if (r > n) {
                show('<div class="error-box">⚠️ r cannot be greater than n</div>');
                return;
            }
            
            const result = factorial(n) / (factorial(r) * factorial(n - r));
            const nFactorial = factorial(n);
            const rFactorial = factorial(r);
            const nMinusRFactorial = factorial(n - r);
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Combinations</div>
                    <div class="result-value">C(${n},${r}) = ${result.toLocaleString()}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Formula</div>
                    <div class="result-value" style="color:#2196F3;">n!/(r!(n-r)!)</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Calculation</div>
                    <div class="result-value" style="color:#4CAF50;">${n}!/(${r}!×${n-r}!)</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Calculate n! = ${n}! = ${nFactorial.toLocaleString()}</div>
                <div class="step">2. Calculate r! = ${r}! = ${rFactorial.toLocaleString()}</div>
                <div class="step">3. Calculate (n-r)! = ${n-r}! = ${nMinusRFactorial.toLocaleString()}</div>
                <div class="step">4. Apply formula: C(n,r) = n! / (r! × (n-r)!)</div>
                <div class="step">5. C(${n},${r}) = ${nFactorial.toLocaleString()} / (${rFactorial.toLocaleString()} × ${nMinusRFactorial.toLocaleString()}) = ${result.toLocaleString()}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                There are ${result.toLocaleString()} ways to select ${r} items from ${n} distinct items when order doesn't matter.
            </div>`;
            
            show(html);
        }
        
        function calculateFactorial() {
            const n = parseInt(document.getElementById('factorial_n').value);
            
            if (isNaN(n) || n < 0) {
                show('<div class="error-box">⚠️ Please enter a valid non-negative number</div>');
                return;
            }
            
            if (n > 50) {
                show('<div class="error-box">⚠️ Number too large! Please enter n ≤ 50</div>');
                return;
            }
            
            const result = factorial(n);
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Factorial</div>
                    <div class="result-value">${n}! = ${result.toLocaleString()}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Calculation</div>
                    <div class="result-value" style="color:#2196F3;">${getFactorialExpression(n)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">${getFactorialSteps(n)}</div>
            </div>`;
            
            html += `<div class="factorial-display">${n}! = ${getFactorialDisplay(n)}</div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                There are ${result.toLocaleString()} ways to arrange ${n} distinct items in sequence.
            </div>`;
            
            show(html);
        }
        
        function calculateRepetition() {
            const n = parseInt(document.getElementById('rep_n').value);
            const r = parseInt(document.getElementById('rep_r').value);
            
            if (isNaN(n) || isNaN(r) || n < 1 || r < 1) {
                show('<div class="error-box">⚠️ Please enter valid positive numbers</div>');
                return;
            }
            
            const result = Math.pow(n, r);
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Permutations</div>
                    <div class="result-value">${n}ʳ = ${result.toLocaleString()}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Formula</div>
                    <div class="result-value" style="color:#2196F3;">nʳ</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Calculation</div>
                    <div class="result-value" style="color:#4CAF50;">${n} × ${n} × ... (${r} times)</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Formula: nʳ (n to the power of r)</div>
                <div class="step">2. ${n}ʳ = ${n}${getExponentDisplay(n, r)}</div>
                <div class="step">3. Result = ${result.toLocaleString()}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                There are ${result.toLocaleString()} ways to arrange ${r} items from ${n} types when repetition is allowed.
            </div>`;
            
            show(html);
        }
        
        function calculateCircular() {
            const n = parseInt(document.getElementById('circular_n').value);
            
            if (isNaN(n) || n < 1) {
                show('<div class="error-box">⚠️ Please enter a valid positive number</div>');
                return;
            }
            
            const result = factorial(n - 1);
            const linearArrangements = factorial(n);
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Circular Permutations</div>
                    <div class="result-value">(${n}-1)! = ${result.toLocaleString()}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Linear Arrangements</div>
                    <div class="result-value" style="color:#2196F3;">${n}! = ${linearArrangements.toLocaleString()}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Reduction Factor</div>
                    <div class="result-value" style="color:#4CAF50;">÷ ${n}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Linear arrangements: ${n}! = ${linearArrangements.toLocaleString()}</div>
                <div class="step">2. In circular arrangements, rotations are considered the same</div>
                <div class="step">3. Each arrangement has ${n} equivalent rotations</div>
                <div class="step">4. Circular permutations = ${n}! / ${n} = ${linearArrangements.toLocaleString()} / ${n}</div>
                <div class="step">5. Result = (${n}-1)! = ${result.toLocaleString()}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                There are ${result.toLocaleString()} distinct ways to arrange ${n} items around a circle (rotations considered identical).
            </div>`;
            
            show(html);
        }
        
        function calculateMultipleGroups() {
            const n = parseInt(document.getElementById('multi_n').value);
            const groupsInput = document.getElementById('multi_groups').value;
            
            if (isNaN(n) || n < 1) {
                show('<div class="error-box">⚠️ Please enter a valid positive number for n</div>');
                return;
            }
            
            const groups = groupsInput.split(',').map(g => parseInt(g.trim())).filter(g => !isNaN(g) && g > 0);
            
            if (groups.length === 0) {
                show('<div class="error-box">⚠️ Please enter valid group sizes</div>');
                return;
            }
            
            const sum = groups.reduce((a, b) => a + b, 0);
            if (sum !== n) {
                show(`<div class="error-box">⚠️ Group sizes sum to ${sum}, but n = ${n}. They must be equal.</div>`);
                return;
            }
            
            const numerator = factorial(n);
            const denominator = groups.reduce((prod, g) => prod * factorial(g), 1);
            const result = numerator / denominator;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Multi-Group Permutations</div>
                    <div class="result-value">${result.toLocaleString()}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Formula</div>
                    <div class="result-value" style="color:#2196F3;">n!/(g₁!×g₂!×...)</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Groups</div>
                    <div class="result-value" style="color:#4CAF50;">${groups.join(', ')}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Total arrangements without considering identical groups: ${n}! = ${numerator.toLocaleString()}</div>
                <div class="step">2. Account for identical items in each group:</div>`;
            
            groups.forEach((g, i) => {
                html += `<div class="step">   Group ${i+1} (size ${g}): ÷ ${g}! = ÷ ${factorial(g).toLocaleString()}</div>`;
            });
            
            html += `<div class="step">3. Final calculation: ${numerator.toLocaleString()} / (${groups.map(g => factorial(g).toLocaleString()).join(' × ')})</div>
                <div class="step">4. Result = ${result.toLocaleString()}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                There are ${result.toLocaleString()} distinct arrangements of ${n} items divided into groups of sizes ${groups.join(', ')} where items within each group are identical.
            </div>`;
            
            show(html);
        }
        
        // Helper functions
        function getFactorialDisplay(n) {
            if (n === 0) return '1';
            let display = '';
            for (let i = n; i >= 1; i--) {
                display += i;
                if (i > 1) display += ' × ';
            }
            return display;
        }
        
        function getFactorialExpression(n) {
            if (n === 0) return '1';
            let expression = '';
            for (let i = n; i >= 1; i--) {
                expression += i;
                if (i > 1) expression += ' × ';
            }
            return expression;
        }
        
        function getFactorialSteps(n) {
            if (n === 0) return '0! = 1 (by definition)';
            let steps = '';
            let result = 1;
            for (let i = 1; i <= n; i++) {
                result *= i;
                steps += `${i} = ${result.toLocaleString()}<br>`;
            }
            return steps;
        }
        
        function getExponentDisplay(n, r) {
            let display = '';
            for (let i = 1; i < r; i++) {
                display += ` × ${n}`;
            }
            return display;
        }
        
        // Initialize with default example
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial active tab
            switchTab(0);
        });
    </script>
</body>
</html>