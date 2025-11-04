<?php
/**
 * Random Number Generator
 * File: utility/random-number-generator.php
 * Description: Advanced random number generator with multiple methods and professional features
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Random Number Generator - Multiple Methods & Statistics</title>
    <meta name="description" content="Generate random numbers with multiple methods: uniform, normal distribution, custom ranges, sequences, and advanced statistical analysis.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .generator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-bottom: 30px; }
        
        .panel-section { background: #f8f9fa; padding: 20px; border-radius: 12px; border-left: 4px solid #ff9a9e; }
        .panel-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }
        
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input, .input-wrapper select { width: 100%; padding: 12px 14px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus { outline: none; border-color: #ff9a9e; box-shadow: 0 0 0 3px rgba(255, 154, 158, 0.1); }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .checkbox-group input[type="checkbox"] { width: 18px; height: 18px; }
        
        .generate-btn { background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%); color: white; border: none; padding: 15px 25px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin-top: 10px; }
        .generate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 154, 158, 0.3); }
        
        .results-section { margin-top: 30px; }
        .results-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.2rem; }
        
        .results-display { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; max-height: 300px; overflow-y: auto; }
        .result-item { padding: 10px; border-bottom: 1px solid #e0e0e0; font-family: monospace; }
        .result-item:last-child { border-bottom: none; }
        
        .statistics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 20px; }
        .stat-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #ff9a9e; text-align: center; }
        .stat-label { color: #4527a0; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .stat-value { font-size: 1.15rem; font-weight: bold; color: #5e35b1; }
        
        .visualization { background: white; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .visualization h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.2rem; }
        .chart-container { height: 300px; width: 100%; background: #f8f9fa; border-radius: 8px; display: flex; align-items: flex-end; padding: 15px; gap: 2px; }
        .chart-bar { background: linear-gradient(to top, #ff9a9e, #fad0c4); border-radius: 2px 2px 0 0; flex: 1; position: relative; }
        .chart-bar-label { position: absolute; bottom: -25px; left: 0; right: 0; text-align: center; font-size: 0.7rem; color: #7f8c8d; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .method-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .method-table th, .method-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .method-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .method-table tr:hover { background: #f5f5f5; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff9a9e; }
        .formula-box strong { color: #ff9a9e; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .statistics-grid { grid-template-columns: repeat(2, 1fr); }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎲 Advanced Random Number Generator</h1>
            <p>Generate random numbers with multiple methods, custom distributions, and statistical analysis</p>
        </div>

        <div class="generator-card">
            <div class="control-panel">
                <div class="panel-section">
                    <h3>🔢 Basic Settings</h3>
                    <div class="input-group">
                        <label for="method">Generation Method</label>
                        <div class="input-wrapper">
                            <select id="method">
                                <option value="uniform">Uniform Distribution</option>
                                <option value="normal">Normal (Gaussian) Distribution</option>
                                <option value="exponential">Exponential Distribution</option>
                                <option value="poisson">Poisson Distribution</option>
                                <option value="custom">Custom Range</option>
                                <option value="sequence">Sequential with Gaps</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="count">Number of Values</label>
                        <div class="input-wrapper">
                            <input type="number" id="count" min="1" max="10000" value="100">
                        </div>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="unique" checked>
                        <label for="unique">Generate unique values only</label>
                    </div>
                </div>
                
                <div class="panel-section" id="rangeSection">
                    <h3>📊 Range & Parameters</h3>
                    <div class="input-group">
                        <label for="minValue">Minimum Value</label>
                        <div class="input-wrapper">
                            <input type="number" id="minValue" value="1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="maxValue">Maximum Value</label>
                        <div class="input-wrapper">
                            <input type="number" id="maxValue" value="100">
                        </div>
                    </div>
                    
                    <div class="input-group" id="meanGroup" style="display: none;">
                        <label for="mean">Mean (μ)</label>
                        <div class="input-wrapper">
                            <input type="number" id="mean" value="50" step="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group" id="stdDevGroup" style="display: none;">
                        <label for="stdDev">Standard Deviation (σ)</label>
                        <div class="input-wrapper">
                            <input type="number" id="stdDev" value="15" step="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group" id="lambdaGroup" style="display: none;">
                        <label for="lambda">Lambda (λ) Rate</label>
                        <div class="input-wrapper">
                            <input type="number" id="lambda" value="1" step="0.1" min="0.1">
                        </div>
                    </div>
                </div>
                
                <div class="panel-section">
                    <h3>⚙️ Advanced Options</h3>
                    <div class="input-group">
                        <label for="precision">Decimal Precision</label>
                        <div class="input-wrapper">
                            <select id="precision">
                                <option value="0">Integer (0 decimals)</option>
                                <option value="1" selected>1 decimal place</option>
                                <option value="2">2 decimal places</option>
                                <option value="3">3 decimal places</option>
                                <option value="4">4 decimal places</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="sort">Sort Results</label>
                        <div class="input-wrapper">
                            <select id="sort">
                                <option value="none">No sorting</option>
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="histogram">
                        <label for="histogram">Show histogram visualization</label>
                    </div>
                </div>
            </div>
            
            <button class="generate-btn" onclick="generateNumbers()">🎲 Generate Random Numbers</button>
            
            <div class="results-section">
                <h3>📋 Generated Numbers</h3>
                <div class="results-display" id="resultsDisplay">
                    <div class="result-item">Results will appear here...</div>
                </div>
                
                <div class="statistics-grid" id="statisticsGrid">
                    <!-- Statistics will be populated here -->
                </div>
                
                <div class="visualization" id="visualization" style="display: none;">
                    <h3>📊 Distribution Visualization</h3>
                    <div class="chart-container" id="chartContainer">
                        <!-- Chart bars will be populated here -->
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🎲 Advanced Random Number Generation</h2>
            
            <p>Generate high-quality random numbers using multiple statistical distributions and methods suitable for various applications.</p>

            <h3>📊 Generation Methods</h3>
            <table class="method-table">
                <thead>
                    <tr>
                        <th>Method</th>
                        <th>Description</th>
                        <th>Use Cases</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Uniform Distribution</strong></td>
                        <td>All numbers in the range have equal probability</td>
                        <td>Lotteries, simple randomization, games</td>
                    </tr>
                    <tr>
                        <td><strong>Normal Distribution</strong></td>
                        <td>Bell curve distribution with mean and standard deviation</td>
                        <td>Natural phenomena, measurement errors, test scores</td>
                    </tr>
                    <tr>
                        <td><strong>Exponential Distribution</strong></td>
                        <td>Models time between events in a Poisson process</td>
                        <td>Wait times, radioactive decay, service times</td>
                    </tr>
                    <tr>
                        <td><strong>Poisson Distribution</strong></td>
                        <td>Models number of events in fixed interval</td>
                        <td>Traffic flow, call center arrivals, defect counts</td>
                    </tr>
                    <tr>
                        <td><strong>Custom Range</strong></td>
                        <td>User-defined minimum and maximum values</td>
                        <td>Custom applications, specific constraints</td>
                    </tr>
                    <tr>
                        <td><strong>Sequential with Gaps</strong></td>
                        <td>Sequential numbers with random gaps</td>
                        <td>ID generation, test data with patterns</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Formulas:</strong><br>
                • <strong>Uniform:</strong> X = min + (max - min) × U(0,1)<br>
                • <strong>Normal:</strong> Box-Muller transform or Ziggurat algorithm<br>
                • <strong>Exponential:</strong> X = -ln(U(0,1)) / λ<br>
                • <strong>Poisson:</strong> Count events in exponential intervals
            </div>

            <h3>🔢 Statistical Properties</h3>
            <ul>
                <li><strong>Mean (Average):</strong> Sum of all values divided by count</li>
                <li><strong>Median:</strong> Middle value when sorted</li>
                <li><strong>Standard Deviation:</strong> Measure of data dispersion</li>
                <li><strong>Variance:</strong> Square of standard deviation</li>
                <li><strong>Range:</strong> Difference between maximum and minimum</li>
                <li><strong>Mode:</strong> Most frequently occurring value</li>
            </ul>

            <h3>🎯 Applications</h3>
            <table class="method-table">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Use Case</th>
                        <th>Preferred Distribution</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Cryptography</strong></td>
                        <td>Key generation, nonces</td>
                        <td>Uniform (cryptographically secure)</td>
                    </tr>
                    <tr>
                        <td><strong>Simulations</strong></td>
                        <td>Monte Carlo methods, modeling</td>
                        <td>Various depending on process</td>
                    </tr>
                    <tr>
                        <td><strong>Statistics</strong></td>
                        <td>Sampling, bootstrap methods</td>
                        <td>Uniform, Normal</td>
                    </tr>
                    <tr>
                        <td><strong>Gaming</strong></td>
                        <td>Dice rolls, loot drops</td>
                        <td>Uniform, weighted distributions</td>
                    </tr>
                    <tr>
                        <td><strong>Quality Control</strong></td>
                        <td>Defect simulation, process variation</td>
                        <td>Normal, Poisson</td>
                    </tr>
                    <tr>
                        <td><strong>Finance</strong></td>
                        <td>Risk analysis, option pricing</td>
                        <td>Normal, Log-normal</td>
                    </tr>
                </tbody>
            </table>

            <h3>⚙️ Algorithm Details</h3>
            <div class="formula-box">
                <strong>Pseudorandom Number Generation:</strong><br>
                Modern generators use algorithms like:<br>
                • Mersenne Twister (period 2^19937-1)<br>
                • Xorshift variants (fast, good quality)<br>
                • Cryptographic generators (for security)<br><br>
                <strong>True Random Sources:</strong><br>
                • Atmospheric noise<br>
                • Radioactive decay<br>
                • Quantum phenomena
            </div>

            <h3>📈 Distribution Characteristics</h3>
            <ul>
                <li><strong>Uniform:</strong> Flat, constant probability across range</li>
                <li><strong>Normal:</strong> Symmetric, bell-shaped, 68% within 1σ</li>
                <li><strong>Exponential:</strong> Memoryless, decreasing probability</li>
                <li><strong>Poisson:</strong> Discrete, models rare events</li>
                <li><strong>Binomial:</strong> Success/failure experiments</li>
                <li><strong>Gamma:</strong> Generalization of exponential</li>
            </ul>

            <h3>🔍 Quality Assessment</h3>
            <table class="method-table">
                <thead>
                    <tr>
                        <th>Test</th>
                        <th>Purpose</th>
                        <th>Ideal Result</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Chi-squared</strong></td>
                        <td>Distribution goodness-of-fit</td>
                        <td>p-value > 0.05</td>
                    </tr>
                    <tr>
                        <td><strong>Kolmogorov-Smirnov</strong></td>
                        <td>Compare to theoretical distribution</td>
                        <td>D-statistic close to 0</td>
                    </tr>
                    <tr>
                        <td><strong>Autocorrelation</strong></td>
                        <td>Detect patterns in sequence</td>
                        <td>Correlation ≈ 0</td>
                    </tr>
                    <tr>
                        <td><strong>Runs test</strong></td>
                        <td>Test for randomness in sequence</td>
                        <td>Z-score within ±1.96</td>
                    </tr>
                </tbody>
            </table>

            <h3>🌐 Real-World Examples</h3>
            <div class="formula-box">
                <strong>Natural Phenomena:</strong><br>
                • Human height: Normal distribution (μ=170cm, σ=10cm)<br>
                • Earthquake intervals: Exponential distribution<br>
                • Radioactive decay: Poisson process<br><br>
                <strong>Human Activities:</strong><br>
                • Call center arrivals: Poisson distribution<br>
                • Service times: Exponential distribution<br>
                • Test scores: Normal distribution
            </div>

            <h3>💡 Best Practices</h3>
            <ul>
                <li>Use appropriate distribution for your application</li>
                <li>Ensure sufficient sample size for accurate representation</li>
                <li>Validate randomness with statistical tests when critical</li>
                <li>Use cryptographically secure generators for security applications</li>
                <li>Consider using seeds for reproducible results in testing</li>
                <li>Be aware of limitations of pseudorandom generators</li>
            </ul>

            <h3>🔬 Advanced Techniques</h3>
            <ul>
                <li><strong>Inverse Transform Sampling:</strong> Generate from any distribution using uniform random numbers</li>
                <li><strong>Acceptance-Rejection Method:</strong> Generate from complex distributions</li>
                <li><strong>Markov Chain Monte Carlo:</strong> Sample from complex multidimensional distributions</li>
                <li><strong>Quasirandom Sequences:</strong> Low-discrepancy sequences for faster convergence</li>
            </ul>
        </div>

        <div class="footer">
            <p>🎲 Advanced Random Number Generator | Multiple Methods & Statistical Analysis</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Uniform, Normal, Exponential, Poisson distributions with comprehensive statistics</p>
        </div>
    </div>

    <script>
        // DOM elements
        const methodSelect = document.getElementById('method');
        const countInput = document.getElementById('count');
        const minValueInput = document.getElementById('minValue');
        const maxValueInput = document.getElementById('maxValue');
        const meanGroup = document.getElementById('meanGroup');
        const stdDevGroup = document.getElementById('stdDevGroup');
        const lambdaGroup = document.getElementById('lambdaGroup');
        const precisionSelect = document.getElementById('precision');
        const sortSelect = document.getElementById('sort');
        const uniqueCheckbox = document.getElementById('unique');
        const histogramCheckbox = document.getElementById('histogram');
        const resultsDisplay = document.getElementById('resultsDisplay');
        const statisticsGrid = document.getElementById('statisticsGrid');
        const visualization = document.getElementById('visualization');
        const chartContainer = document.getElementById('chartContainer');

        // Update UI based on selected method
        methodSelect.addEventListener('change', updateMethodUI);
        
        function updateMethodUI() {
            const method = methodSelect.value;
            
            // Hide all parameter groups first
            meanGroup.style.display = 'none';
            stdDevGroup.style.display = 'none';
            lambdaGroup.style.display = 'none';
            
            // Show relevant parameter groups
            if (method === 'normal') {
                meanGroup.style.display = 'block';
                stdDevGroup.style.display = 'block';
            } else if (method === 'exponential') {
                lambdaGroup.style.display = 'block';
            } else if (method === 'poisson') {
                lambdaGroup.style.display = 'block';
            }
        }

        // Initialize UI
        updateMethodUI();

        // Generate random numbers based on selected method
        function generateNumbers() {
            const method = methodSelect.value;
            const count = parseInt(countInput.value);
            const min = parseFloat(minValueInput.value);
            const max = parseFloat(maxValueInput.value);
            const precision = parseInt(precisionSelect.value);
            const unique = uniqueCheckbox.checked;
            const sort = sortSelect.value;
            const showHistogram = histogramCheckbox.checked;
            
            let numbers = [];
            
            switch(method) {
                case 'uniform':
                    numbers = generateUniform(count, min, max, unique);
                    break;
                case 'normal':
                    const mean = parseFloat(document.getElementById('mean').value);
                    const stdDev = parseFloat(document.getElementById('stdDev').value);
                    numbers = generateNormal(count, mean, stdDev, min, max, unique);
                    break;
                case 'exponential':
                    const lambda = parseFloat(document.getElementById('lambda').value);
                    numbers = generateExponential(count, lambda, min, max, unique);
                    break;
                case 'poisson':
                    const poissonLambda = parseFloat(document.getElementById('lambda').value);
                    numbers = generatePoisson(count, poissonLambda, min, max, unique);
                    break;
                case 'custom':
                    numbers = generateCustom(count, min, max, unique);
                    break;
                case 'sequence':
                    numbers = generateSequence(count, min, max, unique);
                    break;
            }
            
            // Apply precision
            numbers = numbers.map(num => {
                return precision === 0 ? Math.round(num) : parseFloat(num.toFixed(precision));
            });
            
            // Apply sorting if requested
            if (sort !== 'none') {
                numbers.sort((a, b) => sort === 'asc' ? a - b : b - a);
            }
            
            // Display results
            displayResults(numbers);
            
            // Calculate and display statistics
            displayStatistics(numbers);
            
            // Show histogram if requested
            if (showHistogram) {
                displayHistogram(numbers);
                visualization.style.display = 'block';
            } else {
                visualization.style.display = 'none';
            }
        }

        // Generation methods
        function generateUniform(count, min, max, unique) {
            const numbers = [];
            const generated = new Set();
            
            while (numbers.length < count) {
                const num = min + Math.random() * (max - min);
                
                if (!unique || !generated.has(num)) {
                    numbers.push(num);
                    if (unique) generated.add(num);
                }
                
                // Safety check to prevent infinite loops
                if (unique && generated.size >= (max - min) * 100) {
                    break;
                }
            }
            
            return numbers;
        }

        function generateNormal(count, mean, stdDev, min, max, unique) {
            const numbers = [];
            const generated = new Set();
            
            // Box-Muller transform for normal distribution
            while (numbers.length < count) {
                let u1, u2;
                do {
                    u1 = Math.random();
                    u2 = Math.random();
                } while (u1 <= Number.EPSILON);
                
                const z0 = Math.sqrt(-2.0 * Math.log(u1)) * Math.cos(2.0 * Math.PI * u2);
                const num = mean + z0 * stdDev;
                
                // Apply bounds if specified
                const boundedNum = (min !== undefined && max !== undefined) ? 
                    Math.max(min, Math.min(max, num)) : num;
                
                if (!unique || !generated.has(boundedNum)) {
                    numbers.push(boundedNum);
                    if (unique) generated.add(boundedNum);
                }
                
                // Safety check
                if (unique && generated.size >= count * 10) {
                    break;
                }
            }
            
            return numbers;
        }

        function generateExponential(count, lambda, min, max, unique) {
            const numbers = [];
            const generated = new Set();
            
            while (numbers.length < count) {
                const u = Math.random();
                const num = -Math.log(1 - u) / lambda;
                
                // Apply bounds if specified
                const boundedNum = (min !== undefined && max !== undefined) ? 
                    Math.max(min, Math.min(max, num)) : num;
                
                if (!unique || !generated.has(boundedNum)) {
                    numbers.push(boundedNum);
                    if (unique) generated.add(boundedNum);
                }
                
                // Safety check
                if (unique && generated.size >= count * 10) {
                    break;
                }
            }
            
            return numbers;
        }

        function generatePoisson(count, lambda, min, max, unique) {
            const numbers = [];
            const generated = new Set();
            
            while (numbers.length < count) {
                let L = Math.exp(-lambda);
                let k = 0;
                let p = 1;
                
                do {
                    k++;
                    p *= Math.random();
                } while (p > L);
                
                const num = k - 1;
                
                // Apply bounds if specified
                const boundedNum = (min !== undefined && max !== undefined) ? 
                    Math.max(min, Math.min(max, num)) : num;
                
                if (!unique || !generated.has(boundedNum)) {
                    numbers.push(boundedNum);
                    if (unique) generated.add(boundedNum);
                }
                
                // Safety check
                if (unique && generated.size >= count * 10) {
                    break;
                }
            }
            
            return numbers;
        }

        function generateCustom(count, min, max, unique) {
            // For custom, we'll use uniform as base but allow for future extensions
            return generateUniform(count, min, max, unique);
        }

        function generateSequence(count, min, max, unique) {
            const numbers = [];
            const range = max - min;
            const step = range / count;
            
            for (let i = 0; i < count; i++) {
                // Start from min and add some randomness to the step
                const base = min + i * step;
                const randomOffset = (Math.random() - 0.5) * step * 0.5; // ±25% of step
                numbers.push(base + randomOffset);
            }
            
            return numbers;
        }

        // Display results in the results area
        function displayResults(numbers) {
            resultsDisplay.innerHTML = '';
            
            if (numbers.length === 0) {
                resultsDisplay.innerHTML = '<div class="result-item">No numbers generated</div>';
                return;
            }
            
            numbers.forEach((num, index) => {
                const item = document.createElement('div');
                item.className = 'result-item';
                item.textContent = `${index + 1}. ${num}`;
                resultsDisplay.appendChild(item);
            });
        }

        // Calculate and display statistics
        function displayStatistics(numbers) {
            if (numbers.length === 0) {
                statisticsGrid.innerHTML = '<div class="stat-card"><div class="stat-label">No data</div><div class="stat-value">-</div></div>';
                return;
            }
            
            // Calculate statistics
            const sorted = [...numbers].sort((a, b) => a - b);
            const sum = numbers.reduce((a, b) => a + b, 0);
            const mean = sum / numbers.length;
            const median = sorted[Math.floor(sorted.length / 2)];
            const min = Math.min(...numbers);
            const max = Math.max(...numbers);
            const range = max - min;
            
            // Variance and standard deviation
            const variance = numbers.reduce((acc, val) => acc + Math.pow(val - mean, 2), 0) / numbers.length;
            const stdDev = Math.sqrt(variance);
            
            // Mode (most frequent value)
            const frequency = {};
            let maxFreq = 0;
            let mode = numbers[0];
            
            numbers.forEach(num => {
                frequency[num] = (frequency[num] || 0) + 1;
                if (frequency[num] > maxFreq) {
                    maxFreq = frequency[num];
                    mode = num;
                }
            });
            
            // Update statistics grid
            statisticsGrid.innerHTML = `
                <div class="stat-card">
                    <div class="stat-label">Count</div>
                    <div class="stat-value">${numbers.length}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Mean</div>
                    <div class="stat-value">${mean.toFixed(4)}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Median</div>
                    <div class="stat-value">${median.toFixed(4)}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Std Dev</div>
                    <div class="stat-value">${stdDev.toFixed(4)}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Min</div>
                    <div class="stat-value">${min.toFixed(4)}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Max</div>
                    <div class="stat-value">${max.toFixed(4)}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Range</div>
                    <div class="stat-value">${range.toFixed(4)}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Variance</div>
                    <div class="stat-value">${variance.toFixed(4)}</div>
                </div>
            `;
        }

        // Display histogram visualization
        function displayHistogram(numbers) {
            if (numbers.length === 0) return;
            
            const min = Math.min(...numbers);
            const max = Math.max(...numbers);
            const range = max - min;
            const binCount = Math.min(20, Math.ceil(Math.sqrt(numbers.length)));
            const binSize = range / binCount;
            
            // Initialize bins
            const bins = Array(binCount).fill(0);
            const binLabels = [];
            
            // Count values in each bin
            numbers.forEach(num => {
                const binIndex = Math.min(Math.floor((num - min) / binSize), binCount - 1);
                bins[binIndex]++;
            });
            
            // Generate bin labels
            for (let i = 0; i < binCount; i++) {
                const binStart = min + i * binSize;
                const binEnd = min + (i + 1) * binSize;
                binLabels.push(`${binStart.toFixed(2)}-${binEnd.toFixed(2)}`);
            }
            
            // Find max frequency for scaling
            const maxFreq = Math.max(...bins);
            
            // Create chart bars
            chartContainer.innerHTML = '';
            bins.forEach((freq, index) => {
                const bar = document.createElement('div');
                bar.className = 'chart-bar';
                bar.style.height = `${(freq / maxFreq) * 100}%`;
                
                const label = document.createElement('div');
                label.className = 'chart-bar-label';
                label.textContent = binLabels[index];
                
                bar.appendChild(label);
                chartContainer.appendChild(bar);
            });
        }

        // Initial generation on page load
        generateNumbers();
    </script>
</body>
</html>
