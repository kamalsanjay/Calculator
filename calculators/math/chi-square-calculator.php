<?php
/**
 * Chi-Square Calculator
 * File: chi-square-calculator.php
 * Description: Calculate chi-square statistics for goodness of fit and independence tests
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi-Square Calculator - Statistical Analysis Online</title>
    <meta name="description" content="Free chi-square calculator. Perform chi-square goodness of fit test and test of independence with automatic calculation of p-values and critical values.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 15px; }
        header { background: rgba(255,255,255,0.1); color: white; padding: 25px 15px; text-align: center; border-radius: 15px; margin-bottom: 20px; backdrop-filter: blur(10px); }
        header h1 { margin: 0 0 8px 0; font-size: 1.8em; }
        header p { margin: 0; opacity: 0.9; font-size: 1em; }
        .container { max-width: 1100px; margin: 0 auto; }
        .breadcrumb { margin-bottom: 15px; text-align: center; }
        .breadcrumb a { color: white; text-decoration: none; font-weight: 500; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 8px; display: inline-block; backdrop-filter: blur(10px); }
        
        .calculator-body { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); margin-bottom: 20px; }
        
        .calc-tabs { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .tab-btn { flex: 1; min-width: 150px; padding: 12px; background: #f0f0f0; border: none; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .input-section { margin-bottom: 20px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .input-section input, .input-section select, .input-section textarea { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1em; outline: none; font-family: 'Courier New', monospace; }
        .input-section input:focus, .input-section textarea:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .data-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .data-table th, .data-table td { padding: 10px; border: 2px solid #e0e0e0; text-align: center; }
        .data-table th { background: #f5f5f5; font-weight: 600; }
        .data-table input { width: 80px; padding: 8px; border: 1px solid #ddd; border-radius: 4px; text-align: center; }
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 28px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1em; transition: all 0.3s; margin-top: 10px; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        
        .btn-secondary { background: #4CAF50; margin-top: 10px; }
        .btn-secondary:hover { background: #45a049; }
        
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; }
        .result-section.show { display: block; }
        .result-section h3 { color: #667eea; margin-bottom: 20px; font-size: 1.4em; }
        
        .result-box { background: white; padding: 20px; border-radius: 10px; margin-bottom: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; }
        .result-label { font-size: 0.9em; color: #666; margin-bottom: 5px; font-weight: 600; text-transform: uppercase; }
        .result-value { font-size: 1.6em; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; }
        
        .formula-box { background: #f9f9f9; padding: 15px; border-radius: 8px; border-left: 4px solid #667eea; margin: 15px 0; }
        .formula-box strong { color: #667eea; }
        
        .conclusion-box { background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #4CAF50; margin-top: 15px; }
        .conclusion-box.reject { background: linear-gradient(135deg, #ffebee 0%, #fce4ec 100%); border-left-color: #f44336; }
        
        .info-box { background: white; padding: 25px; border-radius: 15px; line-height: 1.8; box-shadow: 0 10px 40px rgba(0,0,0,0.2); margin-top: 20px; }
        .info-box h3 { color: #667eea; margin-bottom: 15px; }
        .info-box p { margin-bottom: 12px; color: #555; }
        
        table.result-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table.result-table th, table.result-table td { padding: 10px; border: 1px solid #e0e0e0; text-align: center; }
        table.result-table th { background: #f5f5f5; font-weight: 600; }
        
        @media (max-width: 768px) {
            .calc-tabs { flex-direction: column; }
            .data-table input { width: 60px; font-size: 0.9em; }
        }
    </style>
</head>
<body>
    <header>
        <h1>📊 Chi-Square Calculator</h1>
        <p>Statistical hypothesis testing made easy</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Goodness of Fit</button>
                <button class="tab-btn" onclick="switchTab(1)">Test of Independence</button>
                <button class="tab-btn" onclick="switchTab(2)">Critical Values</button>
            </div>

            <!-- Tab 1: Goodness of Fit -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 15px;">Chi-Square Goodness of Fit Test</h3>
                <p style="margin-bottom: 15px; color: #666;">Tests whether observed frequencies match expected frequencies</p>
                
                <div class="input-section">
                    <label>Number of Categories</label>
                    <select id="gof_categories" onchange="generateGoFTable()">
                        <option value="3">3 categories</option>
                        <option value="4">4 categories</option>
                        <option value="5" selected>5 categories</option>
                        <option value="6">6 categories</option>
                        <option value="7">7 categories</option>
                        <option value="8">8 categories</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>Significance Level (α)</label>
                    <select id="gof_alpha">
                        <option value="0.01">0.01 (99% confidence)</option>
                        <option value="0.05" selected>0.05 (95% confidence)</option>
                        <option value="0.10">0.10 (90% confidence)</option>
                    </select>
                </div>
                
                <div id="gof_table_container"></div>
                
                <button class="btn" onclick="calculateGoF()">Calculate Chi-Square</button>
            </div>

            <!-- Tab 2: Test of Independence -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">Chi-Square Test of Independence</h3>
                <p style="margin-bottom: 15px; color: #666;">Tests whether two categorical variables are independent</p>
                
                <div class="input-section">
                    <label>Table Size</label>
                    <select id="indep_size" onchange="generateIndepTable()">
                        <option value="2x2" selected>2 × 2</option>
                        <option value="2x3">2 × 3</option>
                        <option value="3x2">3 × 2</option>
                        <option value="3x3">3 × 3</option>
                        <option value="4x4">4 × 4</option>
                    </select>
                </div>
                
                <div class="input-section">
                    <label>Significance Level (α)</label>
                    <select id="indep_alpha">
                        <option value="0.01">0.01 (99% confidence)</option>
                        <option value="0.05" selected>0.05 (95% confidence)</option>
                        <option value="0.10">0.10 (90% confidence)</option>
                    </select>
                </div>
                
                <div id="indep_table_container"></div>
                
                <button class="btn" onclick="calculateIndependence()">Calculate Chi-Square</button>
            </div>

            <!-- Tab 3: Critical Values -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">Chi-Square Critical Values</h3>
                <p style="margin-bottom: 15px; color: #666;">Find critical values for chi-square distribution</p>
                
                <div class="input-section">
                    <label>Degrees of Freedom (df)</label>
                    <input type="number" id="crit_df" value="4" min="1" max="100" step="1">
                </div>
                
                <div class="input-section">
                    <label>Significance Level (α)</label>
                    <select id="crit_alpha">
                        <option value="0.01">0.01</option>
                        <option value="0.025">0.025</option>
                        <option value="0.05" selected>0.05</option>
                        <option value="0.10">0.10</option>
                    </select>
                </div>
                
                <button class="btn" onclick="calculateCritical()">Find Critical Value</button>
            </div>

            <!-- Results -->
            <div class="result-section" id="resultSection">
                <h3>📊 Results</h3>
                <div id="resultContent"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Chi-Square Test Guide</h3>
            
            <div class="formula-box">
                <strong>Chi-Square Formula:</strong><br>
                χ² = Σ [(Observed - Expected)² / Expected]
            </div>
            
            <div class="formula-box">
                <strong>Goodness of Fit Test:</strong><br>
                • Tests if sample data fits a specified distribution<br>
                • df = number of categories - 1<br>
                • H₀: Data follows the expected distribution<br>
                • H₁: Data does not follow the expected distribution
            </div>
            
            <div class="formula-box">
                <strong>Test of Independence:</strong><br>
                • Tests if two variables are independent<br>
                • df = (rows - 1) × (columns - 1)<br>
                • H₀: Variables are independent<br>
                • H₁: Variables are not independent (associated)
            </div>
            
            <div class="formula-box">
                <strong>Decision Rule:</strong><br>
                • If χ² > critical value: Reject H₀<br>
                • If χ² ≤ critical value: Fail to reject H₀<br>
                • Common significance levels: 0.05 (95% confidence), 0.01 (99% confidence)
            </div>
        </div>
    </div>

    <script>
        var currentTab = 0;

        function switchTab(index) {
            currentTab = index;
            document.querySelectorAll('.tab-btn').forEach((btn, i) => {
                btn.className = i === index ? 'tab-btn active' : 'tab-btn';
            });
            document.querySelectorAll('.tab-content').forEach((content, i) => {
                content.className = i === index ? 'tab-content active' : 'tab-content';
            });
            document.getElementById('resultSection').classList.remove('show');
        }

        function generateGoFTable() {
            var n = parseInt(document.getElementById('gof_categories').value);
            var html = '<table class="data-table">';
            html += '<tr><th>Category</th><th>Observed Frequency</th><th>Expected Frequency</th></tr>';
            
            for (var i = 1; i <= n; i++) {
                html += '<tr>';
                html += '<td>Category ' + i + '</td>';
                html += '<td><input type="number" id="gof_obs_' + i + '" value="' + (20 + i * 5) + '" step="any"></td>';
                html += '<td><input type="number" id="gof_exp_' + i + '" value="25" step="any"></td>';
                html += '</tr>';
            }
            
            html += '</table>';
            document.getElementById('gof_table_container').innerHTML = html;
        }

        function generateIndepTable() {
            var size = document.getElementById('indep_size').value;
            var dims = size.split('x');
            var rows = parseInt(dims[0]);
            var cols = parseInt(dims[1]);
            
            var html = '<p style="margin: 10px 0; color: #666;"><strong>Contingency Table (Observed Frequencies)</strong></p>';
            html += '<table class="data-table">';
            html += '<tr><th></th>';
            for (var j = 1; j <= cols; j++) {
                html += '<th>Column ' + j + '</th>';
            }
            html += '</tr>';
            
            for (var i = 1; i <= rows; i++) {
                html += '<tr><th>Row ' + i + '</th>';
                for (var j = 1; j <= cols; j++) {
                    html += '<td><input type="number" id="indep_' + i + '_' + j + '" value="' + (10 + i * j) + '" step="any"></td>';
                }
                html += '</tr>';
            }
            
            html += '</table>';
            document.getElementById('indep_table_container').innerHTML = html;
        }

        // Chi-square critical values approximation
        function chiSquareCritical(df, alpha) {
            // Approximate critical values using lookup table
            var criticalValues = {
                0.10: [2.706, 4.605, 6.251, 7.779, 9.236, 10.645, 12.017, 13.362, 14.684, 15.987],
                0.05: [3.841, 5.991, 7.815, 9.488, 11.070, 12.592, 14.067, 15.507, 16.919, 18.307],
                0.025: [5.024, 7.378, 9.348, 11.143, 12.833, 14.449, 16.013, 17.535, 19.023, 20.483],
                0.01: [6.635, 9.210, 11.345, 13.277, 15.086, 16.812, 18.475, 20.090, 21.666, 23.209]
            };
            
            if (df >= 1 && df <= 10 && criticalValues[alpha]) {
                return criticalValues[alpha][df - 1];
            }
            
            // Approximation for larger df
            return df * Math.pow(1 - 2/(9*df) + Math.sqrt(2/(9*df)) * getZScore(1 - alpha), 3);
        }

        function getZScore(p) {
            // Approximate z-scores for common probabilities
            var zScores = {
                0.90: 1.282,
                0.95: 1.645,
                0.975: 1.96,
                0.99: 2.326
            };
            return zScores[p] || 1.96;
        }

        function calculateGoF() {
            var n = parseInt(document.getElementById('gof_categories').value);
            var alpha = parseFloat(document.getElementById('gof_alpha').value);
            
            var observed = [];
            var expected = [];
            
            for (var i = 1; i <= n; i++) {
                var obs = parseFloat(document.getElementById('gof_obs_' + i).value);
                var exp = parseFloat(document.getElementById('gof_exp_' + i).value);
                
                if (isNaN(obs) || isNaN(exp) || exp <= 0) {
                    alert('⚠️ Please enter valid positive numbers');
                    return;
                }
                
                observed.push(obs);
                expected.push(exp);
            }
            
            // Calculate chi-square
            var chiSquare = 0;
            for (var i = 0; i < n; i++) {
                chiSquare += Math.pow(observed[i] - expected[i], 2) / expected[i];
            }
            
            var df = n - 1;
            var criticalValue = chiSquareCritical(df, alpha);
            
            var html = '';
            
            // Calculation table
            html += '<table class="result-table">';
            html += '<tr><th>Category</th><th>Observed</th><th>Expected</th><th>(O-E)²/E</th></tr>';
            for (var i = 0; i < n; i++) {
                var contrib = Math.pow(observed[i] - expected[i], 2) / expected[i];
                html += '<tr>';
                html += '<td>Category ' + (i + 1) + '</td>';
                html += '<td>' + observed[i] + '</td>';
                html += '<td>' + expected[i] + '</td>';
                html += '<td>' + contrib.toFixed(4) + '</td>';
                html += '</tr>';
            }
            html += '</table>';
            
            html += '<div class="result-box">';
            html += '<div class="result-label">Chi-Square Statistic (χ²)</div>';
            html += '<div class="result-value">' + chiSquare.toFixed(4) + '</div>';
            html += '</div>';
            
            html += '<div class="result-box">';
            html += '<div class="result-label">Degrees of Freedom</div>';
            html += '<div class="result-value" style="color: #2196F3;">' + df + '</div>';
            html += '</div>';
            
            html += '<div class="result-box">';
            html += '<div class="result-label">Critical Value (α = ' + alpha + ')</div>';
            html += '<div class="result-value" style="color: #FF9800;">' + criticalValue.toFixed(4) + '</div>';
            html += '</div>';
            
            var reject = chiSquare > criticalValue;
            
            html += '<div class="conclusion-box' + (reject ? ' reject' : '') + '">';
            html += '<h4 style="margin-bottom: 10px; color: ' + (reject ? '#f44336' : '#4CAF50') + ';">Decision:</h4>';
            if (reject) {
                html += '<p style="font-weight: 600;">Reject the null hypothesis (H₀)</p>';
                html += '<p>The observed frequencies significantly differ from expected frequencies at α = ' + alpha + ' level.</p>';
            } else {
                html += '<p style="font-weight: 600;">Fail to reject the null hypothesis (H₀)</p>';
                html += '<p>The observed frequencies do not significantly differ from expected frequencies at α = ' + alpha + ' level.</p>';
            }
            html += '</div>';
            
            html += '<div class="formula-box">';
            html += '<strong>Hypothesis Test:</strong><br>';
            html += '• H₀: Data follows the expected distribution<br>';
            html += '• H₁: Data does not follow the expected distribution<br>';
            html += '• Test Statistic: χ² = ' + chiSquare.toFixed(4) + '<br>';
            html += '• Critical Value: ' + criticalValue.toFixed(4) + '<br>';
            html += '• Since χ² ' + (reject ? '>' : '≤') + ' critical value, we ' + (reject ? 'reject' : 'fail to reject') + ' H₀';
            html += '</div>';
            
            document.getElementById('resultContent').innerHTML = html;
            document.getElementById('resultSection').classList.add('show');
        }

        function calculateIndependence() {
            var size = document.getElementById('indep_size').value;
            var dims = size.split('x');
            var rows = parseInt(dims[0]);
            var cols = parseInt(dims[1]);
            var alpha = parseFloat(document.getElementById('indep_alpha').value);
            
            // Get observed frequencies
            var observed = [];
            for (var i = 1; i <= rows; i++) {
                var row = [];
                for (var j = 1; j <= cols; j++) {
                    var val = parseFloat(document.getElementById('indep_' + i + '_' + j).value);
                    if (isNaN(val) || val < 0) {
                        alert('⚠️ Please enter valid non-negative numbers');
                        return;
                    }
                    row.push(val);
                }
                observed.push(row);
            }
            
            // Calculate row and column totals
            var rowTotals = [];
            var colTotals = [];
            var grandTotal = 0;
            
            for (var i = 0; i < rows; i++) {
                var rowSum = observed[i].reduce((a, b) => a + b, 0);
                rowTotals.push(rowSum);
                grandTotal += rowSum;
            }
            
            for (var j = 0; j < cols; j++) {
                var colSum = 0;
                for (var i = 0; i < rows; i++) {
                    colSum += observed[i][j];
                }
                colTotals.push(colSum);
            }
            
            // Calculate expected frequencies
            var expected = [];
            for (var i = 0; i < rows; i++) {
                var row = [];
                for (var j = 0; j < cols; j++) {
                    var exp = (rowTotals[i] * colTotals[j]) / grandTotal;
                    row.push(exp);
                }
                expected.push(row);
            }
            
            // Calculate chi-square
            var chiSquare = 0;
            for (var i = 0; i < rows; i++) {
                for (var j = 0; j < cols; j++) {
                    if (expected[i][j] > 0) {
                        chiSquare += Math.pow(observed[i][j] - expected[i][j], 2) / expected[i][j];
                    }
                }
            }
            
            var df = (rows - 1) * (cols - 1);
            var criticalValue = chiSquareCritical(df, alpha);
            
            var html = '';
            
            // Observed table
            html += '<h4 style="color: #667eea; margin: 20px 0 10px;">Observed Frequencies:</h4>';
            html += '<table class="result-table">';
            html += '<tr><th></th>';
            for (var j = 0; j < cols; j++) html += '<th>Col ' + (j + 1) + '</th>';
            html += '<th>Total</th></tr>';
            for (var i = 0; i < rows; i++) {
                html += '<tr><th>Row ' + (i + 1) + '</th>';
                for (var j = 0; j < cols; j++) {
                    html += '<td>' + observed[i][j] + '</td>';
                }
                html += '<td><strong>' + rowTotals[i] + '</strong></td></tr>';
            }
            html += '<tr><th>Total</th>';
            for (var j = 0; j < cols; j++) {
                html += '<td><strong>' + colTotals[j] + '</strong></td>';
            }
            html += '<td><strong>' + grandTotal + '</strong></td></tr>';
            html += '</table>';
            
            // Expected table
            html += '<h4 style="color: #667eea; margin: 20px 0 10px;">Expected Frequencies:</h4>';
            html += '<table class="result-table">';
            html += '<tr><th></th>';
            for (var j = 0; j < cols; j++) html += '<th>Col ' + (j + 1) + '</th>';
            html += '</tr>';
            for (var i = 0; i < rows; i++) {
                html += '<tr><th>Row ' + (i + 1) + '</th>';
                for (var j = 0; j < cols; j++) {
                    html += '<td>' + expected[i][j].toFixed(2) + '</td>';
                }
                html += '</tr>';
            }
            html += '</table>';
            
            html += '<div class="result-box">';
            html += '<div class="result-label">Chi-Square Statistic (χ²)</div>';
            html += '<div class="result-value">' + chiSquare.toFixed(4) + '</div>';
            html += '</div>';
            
            html += '<div class="result-box">';
            html += '<div class="result-label">Degrees of Freedom</div>';
            html += '<div class="result-value" style="color: #2196F3;">' + df + '</div>';
            html += '</div>';
            
            html += '<div class="result-box">';
            html += '<div class="result-label">Critical Value (α = ' + alpha + ')</div>';
            html += '<div class="result-value" style="color: #FF9800;">' + criticalValue.toFixed(4) + '</div>';
            html += '</div>';
            
            var reject = chiSquare > criticalValue;
            
            html += '<div class="conclusion-box' + (reject ? ' reject' : '') + '">';
            html += '<h4 style="margin-bottom: 10px; color: ' + (reject ? '#f44336' : '#4CAF50') + ';">Decision:</h4>';
            if (reject) {
                html += '<p style="font-weight: 600;">Reject the null hypothesis (H₀)</p>';
                html += '<p>The two variables are not independent (they are associated) at α = ' + alpha + ' level.</p>';
            } else {
                html += '<p style="font-weight: 600;">Fail to reject the null hypothesis (H₀)</p>';
                html += '<p>There is insufficient evidence to conclude the variables are associated at α = ' + alpha + ' level.</p>';
            }
            html += '</div>';
            
            document.getElementById('resultContent').innerHTML = html;
            document.getElementById('resultSection').classList.add('show');
        }

        function calculateCritical() {
            var df = parseInt(document.getElementById('crit_df').value);
            var alpha = parseFloat(document.getElementById('crit_alpha').value);
            
            if (isNaN(df) || df < 1) {
                alert('⚠️ Please enter a valid degrees of freedom (≥ 1)');
                return;
            }
            
            var criticalValue = chiSquareCritical(df, alpha);
            
            var html = '';
            html += '<div class="result-box">';
            html += '<div class="result-label">Critical Value</div>';
            html += '<div class="result-value">' + criticalValue.toFixed(4) + '</div>';
            html += '</div>';
            
            html += '<div class="formula-box">';
            html += '<strong>Parameters:</strong><br>';
            html += '• Degrees of Freedom (df): ' + df + '<br>';
            html += '• Significance Level (α): ' + alpha + '<br>';
            html += '• Critical Value: χ²(' + df + ', ' + alpha + ') = ' + criticalValue.toFixed(4);
            html += '</div>';
            
            html += '<div class="formula-box" style="background: #e3f2fd; border-left-color: #2196F3;">';
            html += '<strong style="color: #1976d2;">Interpretation:</strong><br>';
            html += 'If your calculated χ² statistic is greater than ' + criticalValue.toFixed(4) + ', reject the null hypothesis at α = ' + alpha + ' significance level.';
            html += '</div>';
            
            document.getElementById('resultContent').innerHTML = html;
            document.getElementById('resultSection').classList.add('show');
        }

        window.onload = function() {
            generateGoFTable();
            generateIndepTable();
        };
    </script>
</body>
</html>