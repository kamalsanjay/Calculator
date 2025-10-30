<?php
/**
 * Confidence Interval Calculator
 * File: confidence-interval-calculator.php
 * Description: Calculate confidence intervals for mean, proportion, and differences
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Confidence Interval Calculator - Mean, Proportion CI Online</title>
    <meta name="description" content="Calculate confidence intervals for population mean, proportion, and differences with step-by-step solutions.">
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
        .input-section input, .input-section select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; }
        .input-section input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.3rem; }
        .result-box { background: white; padding: 16px; border-radius: 10px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; }
        .result-label { font-size: 0.8rem; color: #666; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; }
        .result-value { font-size: 1.4rem; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; word-break: break-word; }
        .formula-box { background: #f9f9f9; padding: 14px; border-radius: 8px; border-left: 4px solid #667eea; margin: 14px 0; font-size: 0.85rem; line-height: 1.7; }
        .formula-box strong { color: #667eea; display: block; margin-bottom: 6px; }
        .info-box { background: white; padding: 20px; border-radius: 12px; line-height: 1.8; box-shadow: 0 8px 30px rgba(0,0,0,0.15); margin-top: 16px; }
        .info-box h3 { color: #667eea; margin-bottom: 14px; font-size: 1.2rem; }
        .ci-visual { background: white; padding: 16px; border-radius: 10px; margin: 16px 0; text-align: center; border: 2px solid #e0e0e0; }
        .ci-bar { height: 40px; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); border-radius: 20px; position: relative; margin: 20px 0; }
        .ci-marker { position: absolute; top: -10px; width: 2px; height: 60px; background: #f44336; }
        .ci-label { font-size: 0.75rem; color: #666; margin-top: 8px; }
        
        @media (min-width: 768px) { 
            body { padding: 24px; }
            .container { max-width: 720px; margin: 0 auto; }
            header h1 { font-size: 2rem; }
            .calculator-body { padding: 24px; }
        }
        @media (min-width: 1024px) { .container { max-width: 960px; } }
        @media (min-width: 1280px) { .container { max-width: 1100px; } }
    </style>
</head>
<body>
    <header>
        <h1>📊 Confidence Interval Calculator</h1>
        <p>Calculate CI for Mean, Proportion & Differences</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Mean (μ)</button>
                <button class="tab-btn" onclick="switchTab(1)">Proportion (p)</button>
                <button class="tab-btn" onclick="switchTab(2)">Difference</button>
            </div>

            <!-- Tab 1: Mean CI -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📊 Confidence Interval for Mean</h3>
                <div class="input-section">
                    <label>Sample Mean (x̄)</label>
                    <input type="number" id="mean_xbar" value="50" step="any">
                </div>
                <div class="input-section">
                    <label>Sample Size (n)</label>
                    <input type="number" id="mean_n" value="100" min="2" step="1">
                </div>
                <div class="input-section">
                    <label>Standard Deviation (σ or s)</label>
                    <input type="number" id="mean_sd" value="10" step="any">
                </div>
                <div class="input-section">
                    <label>Confidence Level</label>
                    <select id="mean_conf">
                        <option value="0.90">90% (α = 0.10)</option>
                        <option value="0.95" selected>95% (α = 0.05)</option>
                        <option value="0.98">98% (α = 0.02)</option>
                        <option value="0.99">99% (α = 0.01)</option>
                    </select>
                </div>
                <button class="btn" onclick="calcMeanCI()">Calculate CI for Mean</button>
            </div>

            <!-- Tab 2: Proportion CI -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📈 Confidence Interval for Proportion</h3>
                <div class="input-section">
                    <label>Number of Successes (x)</label>
                    <input type="number" id="prop_x" value="60" min="0" step="1">
                </div>
                <div class="input-section">
                    <label>Sample Size (n)</label>
                    <input type="number" id="prop_n" value="100" min="1" step="1">
                </div>
                <div class="input-section">
                    <label>Confidence Level</label>
                    <select id="prop_conf">
                        <option value="0.90">90% (α = 0.10)</option>
                        <option value="0.95" selected>95% (α = 0.05)</option>
                        <option value="0.98">98% (α = 0.02)</option>
                        <option value="0.99">99% (α = 0.01)</option>
                    </select>
                </div>
                <button class="btn" onclick="calcPropCI()">Calculate CI for Proportion</button>
            </div>

            <!-- Tab 3: Difference CI -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">🔄 Confidence Interval for Difference</h3>
                <p style="margin-bottom: 16px; color: #666; font-size: 0.9rem;">Two independent samples</p>
                <h4 style="color: #555; margin: 16px 0 12px; font-size: 0.95rem;">Sample 1:</h4>
                <div class="input-section">
                    <label>Mean (x̄₁)</label>
                    <input type="number" id="diff_x1" value="50" step="any">
                </div>
                <div class="input-section">
                    <label>Sample Size (n₁)</label>
                    <input type="number" id="diff_n1" value="100" min="2" step="1">
                </div>
                <div class="input-section">
                    <label>Std Dev (s₁)</label>
                    <input type="number" id="diff_s1" value="10" step="any">
                </div>
                <h4 style="color: #555; margin: 16px 0 12px; font-size: 0.95rem;">Sample 2:</h4>
                <div class="input-section">
                    <label>Mean (x̄₂)</label>
                    <input type="number" id="diff_x2" value="45" step="any">
                </div>
                <div class="input-section">
                    <label>Sample Size (n₂)</label>
                    <input type="number" id="diff_n2" value="100" min="2" step="1">
                </div>
                <div class="input-section">
                    <label>Std Dev (s₂)</label>
                    <input type="number" id="diff_s2" value="12" step="any">
                </div>
                <div class="input-section">
                    <label>Confidence Level</label>
                    <select id="diff_conf">
                        <option value="0.90">90%</option>
                        <option value="0.95" selected>95%</option>
                        <option value="0.99">99%</option>
                    </select>
                </div>
                <button class="btn" onclick="calcDiffCI()">Calculate CI for Difference</button>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Confidence Interval Formulas</h3>
            <div class="formula-box">
                <strong>Mean (large n ≥ 30):</strong>
                CI = x̄ ± z × (σ/√n)<br>
                z-values: 90%→1.645, 95%→1.96, 99%→2.576
            </div>
            <div class="formula-box">
                <strong>Proportion:</strong>
                CI = p̂ ± z × √[p̂(1-p̂)/n]<br>
                where p̂ = x/n (sample proportion)
            </div>
            <div class="formula-box">
                <strong>Difference of Means:</strong>
                CI = (x̄₁ - x̄₂) ± z × √(s₁²/n₁ + s₂²/n₂)
            </div>
            <div class="formula-box">
                <strong>Interpretation:</strong>
                We are X% confident that the true population parameter lies within the calculated interval.
            </div>
        </div>
    </div>

    <script>
        function switchTab(i) {
            document.querySelectorAll('.tab-btn').forEach((b,j)=>b.className=j===i?'tab-btn active':'tab-btn');
            document.querySelectorAll('.tab-content').forEach((c,j)=>c.className=j===i?'tab-content active':'tab-content');
            document.getElementById('result').classList.remove('show');
        }
        
        function getZValue(conf) {
            const zTable = {
                0.90: 1.645,
                0.95: 1.96,
                0.98: 2.326,
                0.99: 2.576
            };
            return zTable[conf] || 1.96;
        }
        
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
        }
        
        function calcMeanCI() {
            const xbar = parseFloat(document.getElementById('mean_xbar').value);
            const n = parseInt(document.getElementById('mean_n').value);
            const sd = parseFloat(document.getElementById('mean_sd').value);
            const conf = parseFloat(document.getElementById('mean_conf').value);
            
            if(isNaN(xbar)||isNaN(n)||isNaN(sd)||n<2||sd<=0) {
                alert('⚠️ Please enter valid values (n≥2, σ>0)');
                return;
            }
            
            const z = getZValue(conf);
            const se = sd / Math.sqrt(n);
            const me = z * se;
            const lower = xbar - me;
            const upper = xbar + me;
            
            let html = `<div class="result-box">
                <div class="result-label">Point Estimate (x̄)</div>
                <div class="result-value">${xbar.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">${(conf*100).toFixed(0)}% Confidence Interval</div>
                <div class="result-value" style="color:#2196F3;">(${lower.toFixed(4)}, ${upper.toFixed(4)})</div>
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#FF9800;">
                <div class="result-label">Margin of Error (ME)</div>
                <div class="result-value" style="color:#FF9800;">± ${me.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Calculation Steps:</strong>
                1. Standard Error: SE = σ/√n = ${sd}/${Math.sqrt(n).toFixed(4)} = ${se.toFixed(4)}<br>
                2. z-value for ${(conf*100).toFixed(0)}% confidence: z = ${z}<br>
                3. Margin of Error: ME = z × SE = ${z} × ${se.toFixed(4)} = ${me.toFixed(4)}<br>
                4. Lower Bound: x̄ - ME = ${xbar} - ${me.toFixed(4)} = ${lower.toFixed(4)}<br>
                5. Upper Bound: x̄ + ME = ${xbar} + ${me.toFixed(4)} = ${upper.toFixed(4)}
            </div>`;
            
            html += `<div class="formula-box" style="background:#e3f2fd;border-left-color:#2196F3;">
                <strong style="color:#1976d2;">📊 Interpretation:</strong>
                We are ${(conf*100).toFixed(0)}% confident that the true population mean (μ) lies between ${lower.toFixed(4)} and ${upper.toFixed(4)}.
            </div>`;
            
            show(html);
        }
        
        function calcPropCI() {
            const x = parseInt(document.getElementById('prop_x').value);
            const n = parseInt(document.getElementById('prop_n').value);
            const conf = parseFloat(document.getElementById('prop_conf').value);
            
            if(isNaN(x)||isNaN(n)||x<0||x>n||n<1) {
                alert('⚠️ Please enter valid values (0 ≤ x ≤ n)');
                return;
            }
            
            const phat = x / n;
            const z = getZValue(conf);
            const se = Math.sqrt((phat * (1 - phat)) / n);
            const me = z * se;
            const lower = Math.max(0, phat - me);
            const upper = Math.min(1, phat + me);
            
            let html = `<div class="result-box">
                <div class="result-label">Sample Proportion (p̂)</div>
                <div class="result-value">${phat.toFixed(4)} (${(phat*100).toFixed(2)}%)</div>
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">${(conf*100).toFixed(0)}% Confidence Interval</div>
                <div class="result-value" style="color:#2196F3;">(${lower.toFixed(4)}, ${upper.toFixed(4)})</div>
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#9C27B0;">
                <div class="result-label">As Percentage</div>
                <div class="result-value" style="color:#9C27B0;">(${(lower*100).toFixed(2)}%, ${(upper*100).toFixed(2)}%)</div>
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#FF9800;">
                <div class="result-label">Margin of Error</div>
                <div class="result-value" style="color:#FF9800;">± ${me.toFixed(4)} (± ${(me*100).toFixed(2)}%)</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Calculation:</strong>
                1. Sample Proportion: p̂ = x/n = ${x}/${n} = ${phat.toFixed(4)}<br>
                2. Standard Error: SE = √[p̂(1-p̂)/n] = √[${phat.toFixed(4)}×${(1-phat).toFixed(4)}/${n}] = ${se.toFixed(4)}<br>
                3. z-value: ${z}<br>
                4. Margin of Error: ME = ${z} × ${se.toFixed(4)} = ${me.toFixed(4)}<br>
                5. CI: (${lower.toFixed(4)}, ${upper.toFixed(4)})
            </div>`;
            
            html += `<div class="formula-box" style="background:#e3f2fd;border-left-color:#2196F3;">
                <strong style="color:#1976d2;">📊 Interpretation:</strong>
                We are ${(conf*100).toFixed(0)}% confident that the true population proportion (p) is between ${(lower*100).toFixed(2)}% and ${(upper*100).toFixed(2)}%.
            </div>`;
            
            show(html);
        }
        
        function calcDiffCI() {
            const x1 = parseFloat(document.getElementById('diff_x1').value);
            const n1 = parseInt(document.getElementById('diff_n1').value);
            const s1 = parseFloat(document.getElementById('diff_s1').value);
            const x2 = parseFloat(document.getElementById('diff_x2').value);
            const n2 = parseInt(document.getElementById('diff_n2').value);
            const s2 = parseFloat(document.getElementById('diff_s2').value);
            const conf = parseFloat(document.getElementById('diff_conf').value);
            
            if(isNaN(x1)||isNaN(n1)||isNaN(s1)||isNaN(x2)||isNaN(n2)||isNaN(s2)||n1<2||n2<2||s1<=0||s2<=0) {
                alert('⚠️ Please enter valid values');
                return;
            }
            
            const diff = x1 - x2;
            const z = getZValue(conf);
            const se = Math.sqrt((s1*s1)/n1 + (s2*s2)/n2);
            const me = z * se;
            const lower = diff - me;
            const upper = diff + me;
            
            let html = `<div class="result-box">
                <div class="result-label">Difference (x̄₁ - x̄₂)</div>
                <div class="result-value">${diff.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">${(conf*100).toFixed(0)}% Confidence Interval</div>
                <div class="result-value" style="color:#2196F3;">(${lower.toFixed(4)}, ${upper.toFixed(4)})</div>
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#FF9800;">
                <div class="result-label">Margin of Error</div>
                <div class="result-value" style="color:#FF9800;">± ${me.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Calculation:</strong>
                1. Difference: x̄₁ - x̄₂ = ${x1} - ${x2} = ${diff.toFixed(4)}<br>
                2. Standard Error: SE = √(s₁²/n₁ + s₂²/n₂)<br>
                   = √(${s1}²/${n1} + ${s2}²/${n2}) = ${se.toFixed(4)}<br>
                3. Margin of Error: ME = ${z} × ${se.toFixed(4)} = ${me.toFixed(4)}<br>
                4. CI: (${lower.toFixed(4)}, ${upper.toFixed(4)})
            </div>`;
            
            let interpretation = '';
            if(lower > 0) {
                interpretation = `Sample 1 mean is significantly higher than Sample 2 mean (at ${(conf*100).toFixed(0)}% confidence).`;
            } else if(upper < 0) {
                interpretation = `Sample 1 mean is significantly lower than Sample 2 mean (at ${(conf*100).toFixed(0)}% confidence).`;
            } else {
                interpretation = `No significant difference between means (interval contains 0).`;
            }
            
            html += `<div class="formula-box" style="background:#e3f2fd;border-left-color:#2196F3;">
                <strong style="color:#1976d2;">📊 Interpretation:</strong>
                ${interpretation}<br><br>
                We are ${(conf*100).toFixed(0)}% confident that the true difference (μ₁ - μ₂) is between ${lower.toFixed(4)} and ${upper.toFixed(4)}.
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>