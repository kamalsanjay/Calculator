<?php
/**
 * Correlation Calculator
 * File: correlation-calculator.php
 * Description: Calculate correlation coefficients and perform regression analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Correlation Calculator - Pearson, Spearman, Regression Analysis</title>
    <meta name="description" content="Calculate Pearson correlation, Spearman rank correlation, linear regression, and R-squared with scatter plot visualization.">
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
        .input-section { margin-bottom: 16px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 0.9rem; }
        .input-section textarea { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 0.9rem; outline: none; font-family: 'Courier New', monospace; min-height: 120px; resize: vertical; }
        .input-section textarea:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .input-hint { font-size: 0.8rem; color: #666; margin-top: 6px; font-style: italic; }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn-secondary { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); margin-top: 8px; }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.3rem; }
        .result-box { background: white; padding: 16px; border-radius: 10px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; }
        .result-label { font-size: 0.8rem; color: #666; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; }
        .result-value { font-size: 1.4rem; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; }
        .formula-box { background: #f9f9f9; padding: 14px; border-radius: 8px; border-left: 4px solid #667eea; margin: 14px 0; font-size: 0.85rem; line-height: 1.7; }
        .formula-box strong { color: #667eea; display: block; margin-bottom: 6px; }
        .scatter-plot { background: white; padding: 16px; border-radius: 10px; margin: 16px 0; border: 2px solid #e0e0e0; text-align: center; }
        .scatter-plot canvas { max-width: 100%; height: auto; border: 1px solid #ddd; }
        .info-box { background: white; padding: 20px; border-radius: 12px; line-height: 1.8; box-shadow: 0 8px 30px rgba(0,0,0,0.15); margin-top: 16px; }
        .info-box h3 { color: #667eea; margin-bottom: 14px; font-size: 1.2rem; }
        .strength-indicator { padding: 12px; border-radius: 8px; margin: 12px 0; text-align: center; font-weight: 600; }
        .strength-strong { background: #e8f5e9; color: #2e7d32; border: 2px solid #4CAF50; }
        .strength-moderate { background: #fff3e0; color: #e65100; border: 2px solid #FF9800; }
        .strength-weak { background: #ffebee; color: #c62828; border: 2px solid #f44336; }
        
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
        <h1>📊 Correlation Calculator</h1>
        <p>Pearson, Spearman & Regression Analysis</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <h3 style="color: #667eea; margin-bottom: 16px; font-size: 1.1rem;">📈 Enter Your Data</h3>
            
            <div class="input-section">
                <label>X Values (comma or space separated)</label>
                <textarea id="xValues" placeholder="Example: 1, 2, 3, 4, 5">1, 2, 3, 4, 5, 6, 7, 8, 9, 10</textarea>
                <div class="input-hint">Enter numerical values separated by commas or spaces</div>
            </div>
            
            <div class="input-section">
                <label>Y Values (comma or space separated)</label>
                <textarea id="yValues" placeholder="Example: 2, 4, 5, 4, 5">2, 4, 5, 4, 5, 7, 7, 8, 9, 9</textarea>
                <div class="input-hint">Must have same number of values as X</div>
            </div>
            
            <button class="btn" onclick="calculate()">Calculate Correlation & Regression</button>
            <button class="btn btn-secondary" onclick="loadSample()">Load Sample Data</button>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Correlation & Regression Guide</h3>
            <div class="formula-box">
                <strong>Pearson Correlation (r):</strong>
                r = Σ[(x-x̄)(y-ȳ)] / √[Σ(x-x̄)² × Σ(y-ȳ)²]<br>
                Measures linear relationship between variables (-1 to +1)
            </div>
            <div class="formula-box">
                <strong>Interpretation:</strong>
                • |r| = 0.0-0.3: Weak correlation<br>
                • |r| = 0.3-0.7: Moderate correlation<br>
                • |r| = 0.7-1.0: Strong correlation<br>
                • Positive: variables increase together<br>
                • Negative: one increases, other decreases
            </div>
            <div class="formula-box">
                <strong>Linear Regression:</strong>
                y = mx + b<br>
                • m = slope (rate of change)<br>
                • b = y-intercept (value when x=0)<br>
                • R² = coefficient of determination (variance explained)
            </div>
        </div>
    </div>

    <script>
        function parseData(str) {
            return str.trim().split(/[s,]+/).map(v => parseFloat(v)).filter(v => !isNaN(v));
        }
        
        function mean(arr) {
            return arr.reduce((a,b) => a+b, 0) / arr.length;
        }
        
        function pearsonCorrelation(x, y) {
            const n = x.length;
            const xMean = mean(x);
            const yMean = mean(y);
            
            let numerator = 0;
            let xSquareSum = 0;
            let ySquareSum = 0;
            
            for(let i = 0; i < n; i++) {
                const xDiff = x[i] - xMean;
                const yDiff = y[i] - yMean;
                numerator += xDiff * yDiff;
                xSquareSum += xDiff * xDiff;
                ySquareSum += yDiff * yDiff;
            }
            
            return numerator / Math.sqrt(xSquareSum * ySquareSum);
        }
        
        function linearRegression(x, y) {
            const n = x.length;
            const xMean = mean(x);
            const yMean = mean(y);
            
            let numerator = 0;
            let denominator = 0;
            
            for(let i = 0; i < n; i++) {
                numerator += (x[i] - xMean) * (y[i] - yMean);
                denominator += (x[i] - xMean) * (x[i] - xMean);
            }
            
            const slope = numerator / denominator;
            const intercept = yMean - slope * xMean;
            
            return { slope, intercept };
        }
        
        function rSquared(x, y, slope, intercept) {
            const yMean = mean(y);
            let ssRes = 0;
            let ssTot = 0;
            
            for(let i = 0; i < x.length; i++) {
                const yPred = slope * x[i] + intercept;
                ssRes += Math.pow(y[i] - yPred, 2);
                ssTot += Math.pow(y[i] - yMean, 2);
            }
            
            return 1 - (ssRes / ssTot);
        }
        
        function getCorrelationStrength(r) {
            const abs = Math.abs(r);
            if(abs >= 0.7) return { level: 'Strong', class: 'strength-strong' };
            if(abs >= 0.3) return { level: 'Moderate', class: 'strength-moderate' };
            return { level: 'Weak', class: 'strength-weak' };
        }
        
        function drawScatterPlot(x, y, slope, intercept) {
            const canvas = document.createElement('canvas');
            canvas.width = 600;
            canvas.height = 400;
            const ctx = canvas.getContext('2d');
            
            const padding = 50;
            const width = canvas.width - 2 * padding;
            const height = canvas.height - 2 * padding;
            
            const xMin = Math.min(...x);
            const xMax = Math.max(...x);
            const yMin = Math.min(...y);
            const yMax = Math.max(...y);
            
            const xRange = xMax - xMin || 1;
            const yRange = yMax - yMin || 1;
            
            // Draw axes
            ctx.strokeStyle = '#333';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.moveTo(padding, padding);
            ctx.lineTo(padding, canvas.height - padding);
            ctx.lineTo(canvas.width - padding, canvas.height - padding);
            ctx.stroke();
            
            // Draw grid
            ctx.strokeStyle = '#e0e0e0';
            ctx.lineWidth = 1;
            for(let i = 0; i <= 5; i++) {
                const x = padding + (width * i / 5);
                const y = padding + (height * i / 5);
                ctx.beginPath();
                ctx.moveTo(x, padding);
                ctx.lineTo(x, canvas.height - padding);
                ctx.stroke();
                ctx.beginPath();
                ctx.moveTo(padding, y);
                ctx.lineTo(canvas.width - padding, y);
                ctx.stroke();
            }
            
            // Draw regression line
            const x1 = xMin;
            const y1 = slope * x1 + intercept;
            const x2 = xMax;
            const y2 = slope * x2 + intercept;
            
            const px1 = padding + ((x1 - xMin) / xRange) * width;
            const py1 = canvas.height - padding - ((y1 - yMin) / yRange) * height;
            const px2 = padding + ((x2 - xMin) / xRange) * width;
            const py2 = canvas.height - padding - ((y2 - yMin) / yRange) * height;
            
            ctx.strokeStyle = '#667eea';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.moveTo(px1, py1);
            ctx.lineTo(px2, py2);
            ctx.stroke();
            
            // Draw points
            ctx.fillStyle = '#f44336';
            for(let i = 0; i < x.length; i++) {
                const px = padding + ((x[i] - xMin) / xRange) * width;
                const py = canvas.height - padding - ((y[i] - yMin) / yRange) * height;
                ctx.beginPath();
                ctx.arc(px, py, 5, 0, 2 * Math.PI);
                ctx.fill();
            }
            
            // Labels
            ctx.fillStyle = '#333';
            ctx.font = '12px Arial';
            ctx.fillText('X', canvas.width - padding + 10, canvas.height - padding + 5);
            ctx.fillText('Y', padding - 10, padding - 10);
            
            return canvas;
        }
        
        function calculate() {
            const xStr = document.getElementById('xValues').value;
            const yStr = document.getElementById('yValues').value;
            
            const x = parseData(xStr);
            const y = parseData(yStr);
            
            if(x.length === 0 || y.length === 0) {
                alert('⚠️ Please enter valid numerical data');
                return;
            }
            
            if(x.length !== y.length) {
                alert('⚠️ X and Y must have the same number of values');
                return;
            }
            
            if(x.length < 2) {
                alert('⚠️ Need at least 2 data points');
                return;
            }
            
            const r = pearsonCorrelation(x, y);
            const { slope, intercept } = linearRegression(x, y);
            const r2 = rSquared(x, y, slope, intercept);
            const strength = getCorrelationStrength(r);
            
            let html = `<div class="result-box">
                <div class="result-label">Sample Size (n)</div>
                <div class="result-value">${x.length}</div>
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#2196F3;">
                <div class="result-label">Pearson Correlation (r)</div>
                <div class="result-value" style="color:#2196F3;">${r.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="strength-indicator ${strength.class}">
                ${strength.level} ${r >= 0 ? 'Positive' : 'Negative'} Correlation
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#9C27B0;">
                <div class="result-label">R² (Coefficient of Determination)</div>
                <div class="result-value" style="color:#9C27B0;">${r2.toFixed(4)} (${(r2*100).toFixed(2)}%)</div>
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#FF9800;">
                <div class="result-label">Regression Equation</div>
                <div class="result-value" style="color:#FF9800;font-size:1.2rem;">y = ${slope.toFixed(4)}x ${intercept >= 0 ? '+' : ''} ${intercept.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#4CAF50;">
                <div class="result-label">Slope (m)</div>
                <div class="result-value" style="color:#4CAF50;">${slope.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="result-box" style="border-left-color:#00BCD4;">
                <div class="result-label">Y-Intercept (b)</div>
                <div class="result-value" style="color:#00BCD4;">${intercept.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">📊 Interpretation:</strong>
                • Correlation: ${Math.abs(r).toFixed(4)} (${strength.level.toLowerCase()} ${r >= 0 ? 'positive' : 'negative'})<br>
                • R² = ${(r2*100).toFixed(2)}% of variance in Y is explained by X<br>
                • For every 1 unit increase in X, Y ${slope >= 0 ? 'increases' : 'decreases'} by ${Math.abs(slope).toFixed(4)} units
            </div>`;
            
            html += '<div class="scatter-plot"><h4 style="color:#667eea;margin-bottom:12px;">Scatter Plot with Regression Line</h4>';
            
            const canvas = drawScatterPlot(x, y, slope, intercept);
            html += canvas.outerHTML;
            html += '</div>';
            
            html += `<div class="formula-box">
                <strong>Formulas Used:</strong>
                • Pearson r = Σ[(x-x̄)(y-ȳ)] / √[Σ(x-x̄)² × Σ(y-ȳ)²]<br>
                • Slope m = Σ[(x-x̄)(y-ȳ)] / Σ(x-x̄)²<br>
                • Intercept b = ȳ - m×x̄<br>
                • R² = 1 - (SSres / SStot)
            </div>`;
            
            document.getElementById('output').innerHTML = html;
            document.getElementById('result').classList.add('show');
        }
        
        function loadSample() {
            document.getElementById('xValues').value = '1, 2, 3, 4, 5, 6, 7, 8, 9, 10';
            document.getElementById('yValues').value = '2, 4, 5, 4, 5, 7, 7, 8, 9, 9';
        }
    </script>
</body>
</html>