<?php
/**
 * Advanced Sample Size Calculator
 * File: sample-size-calculator.php
 * Description: Statistical sample size calculator for surveys, experiments, and research
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Advanced Sample Size Calculator - Statistical Analysis</title>
    <meta name="description" content="Calculate sample size for surveys, experiments with confidence intervals, power analysis, and statistical tests.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 12px; overflow-x: hidden; }
        header { background: rgba(255,255,255,0.1); color: white; padding: 20px 16px; text-align: center; border-radius: 12px; margin-bottom: 16px; backdrop-filter: blur(10px); }
        header h1 { font-size: 1.5rem; margin-bottom: 8px; font-weight: 700; }
        header p { font-size: 0.875rem; opacity: 0.9; }
        .container { max-width: 100%; margin: 0 auto; overflow-x: hidden; }
        .breadcrumb { margin-bottom: 16px; text-align: center; }
        .breadcrumb a { color: white; text-decoration: none; font-weight: 500; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 8px; display: inline-block; backdrop-filter: blur(10px); font-size: 0.875rem; }
        .calculator-body { background: white; padding: 16px; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); margin-bottom: 16px; overflow: hidden; }
        .calc-tabs { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-bottom: 16px; }
        .tab-btn { padding: 10px 6px; background: #f0f0f0; border: none; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; font-size: 0.7rem; line-height: 1.3; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .input-section { margin-bottom: 16px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 0.9rem; }
        .input-section input, .input-section select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; font-family: 'Courier New', monospace; }
        .input-section input:focus, .input-section select:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .input-hint { font-size: 0.75rem; color: #666; margin-top: 6px; font-style: italic; line-height: 1.4; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.05rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 16px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; overflow: hidden; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.2rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 16px; }
        .result-box { background: white; padding: 14px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; overflow: hidden; }
        .result-label { font-size: 0.7rem; color: #666; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .result-value { font-size: 1.3rem; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; word-break: break-word; line-height: 1.4; }
        .formula-box { background: #f9f9f9; padding: 12px; border-radius: 8px; border-left: 4px solid #667eea; margin: 14px 0; font-size: 0.8rem; line-height: 1.6; overflow-wrap: break-word; }
        .formula-box strong { color: #667eea; display: block; margin-bottom: 6px; }
        .step-box { background: #fff3cd; padding: 12px; border-radius: 8px; border-left: 4px solid #ffc107; margin: 14px 0; overflow: hidden; }
        .step-box strong { color: #f57c00; display: block; margin-bottom: 8px; font-size: 0.85rem; }
        .step { padding: 5px 0; border-bottom: 1px solid #ffe082; font-family: 'Courier New', monospace; font-size: 0.75rem; word-break: break-word; }
        .step:last-child { border-bottom: none; }
        .info-box { background: white; padding: 16px; border-radius: 12px; line-height: 1.7; box-shadow: 0 8px 30px rgba(0,0,0,0.15); margin-top: 16px; overflow: hidden; }
        .info-box h3 { color: #667eea; margin-bottom: 14px; font-size: 1.1rem; }
        
        @media (max-width: 479px) {
            .result-value { font-size: 1.1rem; }
            .calc-tabs { grid-template-columns: 1fr; }
        }
        @media (min-width: 768px) { 
            body { padding: 20px; }
            .container { max-width: 700px; margin: 0 auto; }
            header h1 { font-size: 1.8rem; }
            .calculator-body { padding: 24px; }
            .calc-tabs { grid-template-columns: repeat(4, 1fr); }
        }
        @media (min-width: 1024px) { .container { max-width: 900px; } }
    </style>
</head>
<body>
    <header>
        <h1>📊 Sample Size Calculator</h1>
        <p>Statistical Analysis & Research Tools</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Survey<br>Sample</button>
                <button class="tab-btn" onclick="switchTab(1)">Proportion<br>Test</button>
                <button class="tab-btn" onclick="switchTab(2)">Mean<br>Test</button>
                <button class="tab-btn" onclick="switchTab(3)">Power<br>Analysis</button>
            </div>

            <!-- Tab 1: Survey Sample Size -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">📋 Survey Sample Size</h3>
                <div class="input-section">
                    <label>Population Size</label>
                    <input type="number" id="survey_pop" value="10000" step="1" min="1">
                    <div class="input-hint">Total population (use large number for infinite)</div>
                </div>
                <div class="input-section">
                    <label>Confidence Level</label>
                    <select id="survey_conf">
                        <option value="90">90% (Z = 1.645)</option>
                        <option value="95" selected>95% (Z = 1.96)</option>
                        <option value="99">99% (Z = 2.576)</option>
                    </select>
                </div>
                <div class="input-section">
                    <label>Margin of Error (%)</label>
                    <input type="number" id="survey_moe" value="5" step="0.1" min="0.1" max="50">
                    <div class="input-hint">Acceptable error range (typically 3-5%)</div>
                </div>
                <div class="input-section">
                    <label>Expected Proportion (%)</label>
                    <input type="number" id="survey_prop" value="50" step="1" min="1" max="99">
                    <div class="input-hint">Use 50% for maximum sample size</div>
                </div>
                <button class="btn" onclick="calcSurvey()">Calculate Sample Size</button>
            </div>

            <!-- Tab 2: Proportion Test -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">📈 Proportion Test Sample</h3>
                <div class="input-section">
                    <label>Confidence Level</label>
                    <select id="prop_conf">
                        <option value="90">90% (Z = 1.645)</option>
                        <option value="95" selected>95% (Z = 1.96)</option>
                        <option value="99">99% (Z = 2.576)</option>
                    </select>
                </div>
                <div class="input-section">
                    <label>Statistical Power (%)</label>
                    <input type="number" id="prop_power" value="80" step="1" min="50" max="99">
                    <div class="input-hint">Typically 80% or 90%</div>
                </div>
                <div class="input-section">
                    <label>Baseline Proportion (p1) %</label>
                    <input type="number" id="prop_p1" value="30" step="0.1" min="0.1" max="99.9">
                </div>
                <div class="input-section">
                    <label>Alternative Proportion (p2) %</label>
                    <input type="number" id="prop_p2" value="40" step="0.1" min="0.1" max="99.9">
                    <div class="input-hint">Expected difference to detect</div>
                </div>
                <button class="btn" onclick="calcProportion()">Calculate Sample Size</button>
            </div>

            <!-- Tab 3: Mean Test -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">📊 Mean Comparison Sample</h3>
                <div class="input-section">
                    <label>Confidence Level</label>
                    <select id="mean_conf">
                        <option value="90">90% (Z = 1.645)</option>
                        <option value="95" selected>95% (Z = 1.96)</option>
                        <option value="99">99% (Z = 2.576)</option>
                    </select>
                </div>
                <div class="input-section">
                    <label>Statistical Power (%)</label>
                    <input type="number" id="mean_power" value="80" step="1" min="50" max="99">
                </div>
                <div class="input-section">
                    <label>Standard Deviation (σ)</label>
                    <input type="number" id="mean_sd" value="10" step="0.1" min="0.1">
                    <div class="input-hint">Population standard deviation</div>
                </div>
                <div class="input-section">
                    <label>Effect Size (δ)</label>
                    <input type="number" id="mean_effect" value="3" step="0.1" min="0.1">
                    <div class="input-hint">Minimum detectable difference</div>
                </div>
                <button class="btn" onclick="calcMean()">Calculate Sample Size</button>
            </div>

            <!-- Tab 4: Power Analysis -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1rem;">⚡ Statistical Power Analysis</h3>
                <div class="input-section">
                    <label>Sample Size</label>
                    <input type="number" id="power_n" value="100" step="1" min="2">
                </div>
                <div class="input-section">
                    <label>Confidence Level</label>
                    <select id="power_conf">
                        <option value="90">90% (α = 0.10)</option>
                        <option value="95" selected>95% (α = 0.05)</option>
                        <option value="99">99% (α = 0.01)</option>
                    </select>
                </div>
                <div class="input-section">
                    <label>Effect Size</label>
                    <select id="power_effect">
                        <option value="0.2">Small (0.2)</option>
                        <option value="0.5" selected>Medium (0.5)</option>
                        <option value="0.8">Large (0.8)</option>
                    </select>
                    <div class="input-hint">Cohen's d: standardized effect size</div>
                </div>
                <button class="btn" onclick="calcPower()">Calculate Power</button>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Statistical Concepts</h3>
            <div class="formula-box">
                <strong>Confidence Level:</strong>
                Probability that the true value lies within the margin of error<br>
                • 90% → Z = 1.645<br>
                • 95% → Z = 1.96<br>
                • 99% → Z = 2.576
            </div>
            <div class="formula-box">
                <strong>Margin of Error:</strong>
                Maximum expected difference between sample and population<br>
                Lower margin = larger sample needed
            </div>
            <div class="formula-box">
                <strong>Statistical Power:</strong>
                Probability of detecting an effect when it exists<br>
                Typically 80% or 90%
            </div>
            <div class="formula-box">
                <strong>Effect Size:</strong>
                Standardized measure of difference magnitude<br>
                • Small: 0.2<br>
                • Medium: 0.5<br>
                • Large: 0.8
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
        
        function getZScore(conf) {
            const z = {90: 1.645, 95: 1.96, 99: 2.576};
            return z[conf] || 1.96;
        }
        
        function getAlpha(conf) {
            return (100 - conf) / 100;
        }
        
        function normalCDF(x) {
            const t = 1 / (1 + 0.2316419 * Math.abs(x));
            const d = 0.3989423 * Math.exp(-x * x / 2);
            const p = d * t * (0.3193815 + t * (-0.3565638 + t * (1.781478 + t * (-1.821256 + t * 1.330274))));
            return x > 0 ? 1 - p : p;
        }
        
        function inverseNormalCDF(p) {
            if(p <= 0 || p >= 1) return NaN;
            
            const a = [0, -3.969683028665376e+01, 2.209460984245205e+02, -2.759285104469687e+02, 1.383577518672690e+02, -3.066479806614716e+01, 2.506628277459239e+00];
            const b = [0, -5.447609879822406e+01, 1.615858368580409e+02, -1.556989798598866e+02, 6.680131188771972e+01, -1.328068155288572e+01];
            const c = [0, -7.784894002430293e-03, -3.223964580411365e-01, -2.400758277161838e+00, -2.549732539343734e+00, 4.374664141464968e+00, 2.938163982698783e+00];
            const d = [0, 7.784695709041462e-03, 3.224671290700398e-01, 2.445134137142996e+00, 3.754408661907416e+00];
            
            let q = p - 0.5;
            let r, x;
            
            if(Math.abs(q) <= 0.425) {
                r = 0.180625 - q * q;
                x = q * (((((((a[7] * r + a[6]) * r + a[5]) * r + a[4]) * r + a[3]) * r + a[2]) * r + a[1]) * r + a[0]) /
                    (((((((b[7] * r + b[6]) * r + b[5]) * r + b[4]) * r + b[3]) * r + b[2]) * r + b[1]) * r + 1);
            } else {
                r = q < 0 ? p : 1 - p;
                r = Math.sqrt(-Math.log(r));
                
                x = (((((((c[7] * r + c[6]) * r + c[5]) * r + c[4]) * r + c[3]) * r + c[2]) * r + c[1]) * r + c[0]) /
                    ((((((d[6] * r + d[5]) * r + d[4]) * r + d[3]) * r + d[2]) * r + d[1]) * r + 1);
                
                if(q < 0) x = -x;
            }
            
            return x;
        }
        
        function calcSurvey() {
            const N = parseFloat(document.getElementById('survey_pop').value);
            const conf = parseInt(document.getElementById('survey_conf').value);
            const e = parseFloat(document.getElementById('survey_moe').value) / 100;
            const p = parseFloat(document.getElementById('survey_prop').value) / 100;
            
            if(isNaN(N) || isNaN(e) || isNaN(p) || N < 1 || e <= 0 || p <= 0 || p >= 1) {
                return alert('⚠️ Enter valid parameters');
            }
            
            const z = getZScore(conf);
            const q = 1 - p;
            
            // Cochran's formula for infinite population
            const n0 = (z * z * p * q) / (e * e);
            
            // Finite population correction
            const n = N / (1 + (n0 - 1) / N);
            
            const nRounded = Math.ceil(n);
            const responseRate = 0.3; // Assume 30% response rate
            const nAdjusted = Math.ceil(nRounded / responseRate);
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Required Sample</div>
                    <div class="result-value" style="color:#4CAF50;">${nRounded}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">With 30% Response</div>
                    <div class="result-value" style="color:#2196F3;">${nAdjusted}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Sampling Fraction</div>
                    <div class="result-value" style="color:#FF9800;">${((n/N)*100).toFixed(2)}%</div>
                </div>
                <div class="result-box" style="border-left-color:#9C27B0;">
                    <div class="result-label">Confidence Level</div>
                    <div class="result-value" style="color:#9C27B0;">${conf}%</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Calculation Steps:</strong>
                <div class="step">1. Infinite sample: n₀ = (Z²×p×q) / e²</div>
                <div class="step">n₀ = (${z}² × ${p.toFixed(2)} × ${q.toFixed(2)}) / ${e.toFixed(3)}²</div>
                <div class="step">n₀ = ${n0.toFixed(2)}</div>
                <div class="step">2. Finite correction: n = N / (1 + (n₀-1)/N)</div>
                <div class="step">n = ${N} / (1 + ${(n0-1).toFixed(2)}/${N})</div>
                <div class="step">n = ${n.toFixed(2)} ≈ ${nRounded}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;">
                <strong style="color:#4CAF50;">📊 Survey Details:</strong>
                • Population: ${N.toLocaleString()}<br>
                • Confidence: ${conf}% (Z = ${z})<br>
                • Margin of Error: ±${(e*100).toFixed(1)}%<br>
                • Expected Proportion: ${(p*100).toFixed(0)}%<br>
                • Required Sample: ${nRounded.toLocaleString()}<br>
                • Recommended (30% response): ${nAdjusted.toLocaleString()}
            </div>`;
            
            show(html);
        }
        
        function calcProportion() {
            const conf = parseInt(document.getElementById('prop_conf').value);
            const power = parseFloat(document.getElementById('prop_power').value) / 100;
            const p1 = parseFloat(document.getElementById('prop_p1').value) / 100;
            const p2 = parseFloat(document.getElementById('prop_p2').value) / 100;
            
            if(isNaN(p1) || isNaN(p2) || isNaN(power) || p1 <= 0 || p2 <= 0 || p1 >= 1 || p2 >= 1) {
                return alert('⚠️ Enter valid proportions');
            }
            
            const za = getZScore(conf);
            const zb = inverseNormalCDF(power);
            
            const pbar = (p1 + p2) / 2;
            const delta = Math.abs(p2 - p1);
            
            const n = 2 * Math.pow((za * Math.sqrt(2 * pbar * (1 - pbar)) + zb * Math.sqrt(p1 * (1 - p1) + p2 * (1 - p2))) / delta, 2);
            
            const nRounded = Math.ceil(n);
            const nPerGroup = Math.ceil(nRounded / 2);
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Total Sample</div>
                    <div class="result-value" style="color:#4CAF50;">${nRounded}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Per Group</div>
                    <div class="result-value" style="color:#2196F3;">${nPerGroup}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Effect Size</div>
                    <div class="result-value" style="color:#FF9800;">${(delta*100).toFixed(1)}%</div>
                </div>
                <div class="result-box" style="border-left-color:#9C27B0;">
                    <div class="result-label">Power</div>
                    <div class="result-value" style="color:#9C27B0;">${(power*100).toFixed(0)}%</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Two-Proportion Z-Test:</strong>
                <div class="step">Baseline (p₁): ${(p1*100).toFixed(1)}%</div>
                <div class="step">Alternative (p₂): ${(p2*100).toFixed(1)}%</div>
                <div class="step">Difference (δ): ${(delta*100).toFixed(1)}%</div>
                <div class="step">Z(α): ${za.toFixed(3)}, Z(β): ${zb.toFixed(3)}</div>
                <div class="step">Sample needed: ${nRounded} (${nPerGroup} per group)</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;">
                <strong style="color:#4CAF50;">📊 Test Parameters:</strong>
                • Confidence: ${conf}% (α = ${(getAlpha(conf)).toFixed(3)})<br>
                • Power: ${(power*100).toFixed(0)}% (β = ${(1-power).toFixed(3)})<br>
                • Total sample: ${nRounded}<br>
                • Per group: ${nPerGroup}
            </div>`;
            
            show(html);
        }
        
        function calcMean() {
            const conf = parseInt(document.getElementById('mean_conf').value);
            const power = parseFloat(document.getElementById('mean_power').value) / 100;
            const sd = parseFloat(document.getElementById('mean_sd').value);
            const effect = parseFloat(document.getElementById('mean_effect').value);
            
            if(isNaN(sd) || isNaN(effect) || sd <= 0 || effect <= 0) {
                return alert('⚠️ Enter valid parameters');
            }
            
            const za = getZScore(conf);
            const zb = inverseNormalCDF(power);
            
            const n = 2 * Math.pow((za + zb) * sd / effect, 2);
            const nRounded = Math.ceil(n);
            const nPerGroup = Math.ceil(nRounded / 2);
            
            const cohensD = effect / sd;
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Total Sample</div>
                    <div class="result-value" style="color:#4CAF50;">${nRounded}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Per Group</div>
                    <div class="result-value" style="color:#2196F3;">${nPerGroup}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Cohen's d</div>
                    <div class="result-value" style="color:#FF9800;">${cohensD.toFixed(3)}</div>
                </div>
                <div class="result-box" style="border-left-color:#9C27B0;">
                    <div class="result-label">Power</div>
                    <div class="result-value" style="color:#9C27B0;">${(power*100).toFixed(0)}%</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Two-Sample T-Test:</strong>
                <div class="step">Standard Deviation (σ): ${sd}</div>
                <div class="step">Effect Size (δ): ${effect}</div>
                <div class="step">Cohen's d: ${cohensD.toFixed(3)}</div>
                <div class="step">Sample: ${nRounded} (${nPerGroup} per group)</div>
            </div>`;
            
            let effectCategory = 'Small';
            if(cohensD >= 0.8) effectCategory = 'Large';
            else if(cohensD >= 0.5) effectCategory = 'Medium';
            
            html += `<div class="formula-box" style="background:#e8f5e9;">
                <strong style="color:#4CAF50;">📊 Analysis:</strong>
                • Effect category: ${effectCategory}<br>
                • Confidence: ${conf}%<br>
                • Power: ${(power*100).toFixed(0)}%<br>
                • Total: ${nRounded}, Per group: ${nPerGroup}
            </div>`;
            
            show(html);
        }
        
        function calcPower() {
            const n = parseFloat(document.getElementById('power_n').value);
            const conf = parseInt(document.getElementById('power_conf').value);
            const d = parseFloat(document.getElementById('power_effect').value);
            
            if(isNaN(n) || n < 2) {
                return alert('⚠️ Enter valid sample size (≥2)');
            }
            
            const za = getZScore(conf);
            const ncp = d * Math.sqrt(n / 2);
            const zb = ncp - za;
            const power = normalCDF(zb);
            
            let html = `<div class="stats-grid">
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Statistical Power</div>
                    <div class="result-value" style="color:#4CAF50;">${(power*100).toFixed(2)}%</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Type II Error (β)</div>
                    <div class="result-value" style="color:#2196F3;">${((1-power)*100).toFixed(2)}%</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Sample Size</div>
                    <div class="result-value" style="color:#FF9800;">${n}</div>
                </div>
                <div class="result-box" style="border-left-color:#9C27B0;">
                    <div class="result-label">Effect Size</div>
                    <div class="result-value" style="color:#9C27B0;">${d}</div>
                </div>
            </div>`;
            
            let powerCategory = 'Underpowered';
            if(power >= 0.9) powerCategory = 'Excellent';
            else if(power >= 0.8) powerCategory = 'Adequate';
            else if(power >= 0.7) powerCategory = 'Fair';
            
            html += `<div class="formula-box" style="background:${power >= 0.8 ? '#e8f5e9' : '#fff3cd'};">
                <strong style="color:${power >= 0.8 ? '#4CAF50' : '#f57c00'};">📊 Power Assessment: ${powerCategory}</strong>
                • Power: ${(power*100).toFixed(1)}%<br>
                • Confidence: ${conf}%<br>
                • Effect size: ${d} (Cohen's d)<br>
                • Sample: ${n}<br>
                ${power < 0.8 ? '⚠️ Consider increasing sample size' : '✓ Adequate power for detection'}
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>