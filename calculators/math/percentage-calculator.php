<?php
/**
 * Percentage Calculator
 * File: percentage-calculator.php
 * Description: Calculate percentages, percentage increase/decrease, and percentage of numbers
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Percentage Calculator - Calculate Percent, Increase & Decrease</title>
    <meta name="description" content="Free percentage calculator. Calculate percentage of a number, percentage increase/decrease, and what percent one number is of another. Multiple calculation modes.">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        header p {
            font-size: 1.2em;
            opacity: 0.9;
        }
        
        .breadcrumb {
            margin: 20px 0;
        }
        
        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #5568d3;
        }
        
        .calculator-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }
        
        .calculator-section,
        .results-section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .calculator-section h2,
        .results-section h2 {
            color: #667eea;
            margin-bottom: 25px;
            font-size: 1.8em;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #888;
            font-size: 0.9em;
        }
        
        .btn {
            background: #667eea;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #5568d3;
        }
        
        .result-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .result-card h3 {
            font-size: 1.2em;
            opacity: 0.9;
            margin-bottom: 10px;
            font-weight: 400;
        }
        
        .result-card .amount {
            font-size: 3em;
            font-weight: bold;
        }
        
        .metric-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .metric-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #e0e0e0;
        }
        
        .metric-card h4 {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
            font-weight: 400;
        }
        
        .metric-card .value {
            color: #667eea;
            font-size: 2em;
            font-weight: bold;
        }
        
        .breakdown {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .breakdown h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .breakdown-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .breakdown-item:last-child {
            border-bottom: none;
        }
        
        .breakdown-item span {
            color: #666;
        }
        
        .breakdown-item strong {
            color: #333;
            font-weight: 600;
        }
        
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box strong {
            color: #1976D2;
        }
        
        @media (max-width: 768px) {
            .calculator-wrapper {
                grid-template-columns: 1fr;
            }
            
            header h1 {
                font-size: 2em;
            }
            
            .result-card .amount {
                font-size: 2.5em;
            }
            
            .metric-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>% Percentage Calculator</h1>
        <p>Calculate percentages, increases, decreases, and more</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Percentage Calculation</h2>
                <form id="percentForm">
                    <div class="form-group">
                        <label for="calculationType">Calculation Type</label>
                        <select id="calculationType">
                            <option value="percentOf">What is X% of Y?</option>
                            <option value="isWhatPercent">X is what % of Y?</option>
                            <option value="percentIncrease">Percentage Increase</option>
                            <option value="percentDecrease">Percentage Decrease</option>
                        </select>
                    </div>
                    
                    <div id="percentOfInputs">
                        <div class="form-group">
                            <label for="percentValue">Percentage (%)</label>
                            <input type="number" id="percentValue" value="20" min="0" step="0.01" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="baseNumber">Of Number</label>
                            <input type="number" id="baseNumber" value="100" min="0" step="0.01" required>
                        </div>
                    </div>
                    
                    <div id="isWhatPercentInputs" style="display:none;">
                        <div class="form-group">
                            <label for="partNumber">Part (X)</label>
                            <input type="number" id="partNumber" value="25" min="0" step="0.01">
                        </div>
                        
                        <div class="form-group">
                            <label for="wholeNumber">Whole (Y)</label>
                            <input type="number" id="wholeNumber" value="100" min="0" step="0.01">
                        </div>
                    </div>
                    
                    <div id="changeInputs" style="display:none;">
                        <div class="form-group">
                            <label for="originalValue">Original Value</label>
                            <input type="number" id="originalValue" value="100" min="0" step="0.01">
                        </div>
                        
                        <div class="form-group">
                            <label for="newValue">New Value</label>
                            <input type="number" id="newValue" value="120" min="0" step="0.01">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Calculate</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Results</h2>
                
                <div class="result-card">
                    <h3 id="resultLabel">Result</h3>
                    <div class="amount" id="resultValue">20</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Percentage</h4>
                        <div class="value" id="percentDisplay">20%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Decimal</h4>
                        <div class="value" id="decimalDisplay">0.20</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Calculation Details</h3>
                    <div id="calculationSteps"></div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Common Percentages</h3>
                    <div class="breakdown-item">
                        <span>10%</span>
                        <strong id="common10">10</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>20%</span>
                        <strong id="common20">20</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>25%</span>
                        <strong id="common25">25</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>50%</span>
                        <strong id="common50">50</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>75%</span>
                        <strong id="common75">75</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Percentage Formula:</strong> To find X% of Y: (X/100) × Y. To find what % X is of Y: (X/Y) × 100. Percentage increase: ((New - Old)/Old) × 100.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('percentForm');
        const calculationType = document.getElementById('calculationType');
        const percentOfInputs = document.getElementById('percentOfInputs');
        const isWhatPercentInputs = document.getElementById('isWhatPercentInputs');
        const changeInputs = document.getElementById('changeInputs');

        calculationType.addEventListener('change', function() {
            // Hide all input groups
            percentOfInputs.style.display = 'none';
            isWhatPercentInputs.style.display = 'none';
            changeInputs.style.display = 'none';
            
            // Show relevant input group
            if (this.value === 'percentOf') {
                percentOfInputs.style.display = 'block';
            } else if (this.value === 'isWhatPercent') {
                isWhatPercentInputs.style.display = 'block';
            } else {
                changeInputs.style.display = 'block';
            }
            
            calculatePercentage();
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculatePercentage();
        });

        function calculatePercentage() {
            const type = calculationType.value;
            let result, percentage, stepsHTML;
            
            if (type === 'percentOf') {
                const percent = parseFloat(document.getElementById('percentValue').value) || 0;
                const base = parseFloat(document.getElementById('baseNumber').value) || 0;
                result = (percent / 100) * base;
                percentage = percent;
                
                document.getElementById('resultLabel').textContent = percent + '% of ' + base + ' is';
                document.getElementById('resultValue').textContent = result.toFixed(2);
                
                stepsHTML = `
                    <div class="breakdown-item"><span>Formula</span><strong>(${percent}/100) × ${base}</strong></div>
                    <div class="breakdown-item"><span>Step 1</span><strong>${percent}/100 = ${(percent/100).toFixed(4)}</strong></div>
                    <div class="breakdown-item"><span>Step 2</span><strong>${(percent/100).toFixed(4)} × ${base} = ${result.toFixed(2)}</strong></div>
                `;
                
                // Common percentages
                document.getElementById('common10').textContent = ((10/100) * base).toFixed(2);
                document.getElementById('common20').textContent = ((20/100) * base).toFixed(2);
                document.getElementById('common25').textContent = ((25/100) * base).toFixed(2);
                document.getElementById('common50').textContent = ((50/100) * base).toFixed(2);
                document.getElementById('common75').textContent = ((75/100) * base).toFixed(2);
                
            } else if (type === 'isWhatPercent') {
                const part = parseFloat(document.getElementById('partNumber').value) || 0;
                const whole = parseFloat(document.getElementById('wholeNumber').value) || 0;
                percentage = whole > 0 ? (part / whole) * 100 : 0;
                result = percentage;
                
                document.getElementById('resultLabel').textContent = part + ' is what % of ' + whole + '?';
                document.getElementById('resultValue').textContent = percentage.toFixed(2) + '%';
                
                stepsHTML = `
                    <div class="breakdown-item"><span>Formula</span><strong>(${part}/${whole}) × 100</strong></div>
                    <div class="breakdown-item"><span>Step 1</span><strong>${part}/${whole} = ${(part/whole).toFixed(4)}</strong></div>
                    <div class="breakdown-item"><span>Step 2</span><strong>${(part/whole).toFixed(4)} × 100 = ${percentage.toFixed(2)}%</strong></div>
                `;
                
                // Common percentages of whole
                document.getElementById('common10').textContent = ((10/100) * whole).toFixed(2);
                document.getElementById('common20').textContent = ((20/100) * whole).toFixed(2);
                document.getElementById('common25').textContent = ((25/100) * whole).toFixed(2);
                document.getElementById('common50').textContent = ((50/100) * whole).toFixed(2);
                document.getElementById('common75').textContent = ((75/100) * whole).toFixed(2);
                
            } else if (type === 'percentIncrease') {
                const original = parseFloat(document.getElementById('originalValue').value) || 0;
                const newVal = parseFloat(document.getElementById('newValue').value) || 0;
                const change = newVal - original;
                percentage = original > 0 ? (change / original) * 100 : 0;
                result = percentage;
                
                document.getElementById('resultLabel').textContent = 'Percentage Increase';
                document.getElementById('resultValue').textContent = percentage.toFixed(2) + '%';
                
                stepsHTML = `
                    <div class="breakdown-item"><span>Original Value</span><strong>${original}</strong></div>
                    <div class="breakdown-item"><span>New Value</span><strong>${newVal}</strong></div>
                    <div class="breakdown-item"><span>Increase</span><strong>${change.toFixed(2)}</strong></div>
                    <div class="breakdown-item"><span>Formula</span><strong>((${newVal} - ${original})/${original}) × 100</strong></div>
                    <div class="breakdown-item"><span>Result</span><strong>${percentage.toFixed(2)}%</strong></div>
                `;
                
                // Common percentages
                document.getElementById('common10').textContent = (original * 1.10).toFixed(2);
                document.getElementById('common20').textContent = (original * 1.20).toFixed(2);
                document.getElementById('common25').textContent = (original * 1.25).toFixed(2);
                document.getElementById('common50').textContent = (original * 1.50).toFixed(2);
                document.getElementById('common75').textContent = (original * 1.75).toFixed(2);
                
            } else { // percentDecrease
                const original = parseFloat(document.getElementById('originalValue').value) || 0;
                const newVal = parseFloat(document.getElementById('newValue').value) || 0;
                const change = original - newVal;
                percentage = original > 0 ? (change / original) * 100 : 0;
                result = percentage;
                
                document.getElementById('resultLabel').textContent = 'Percentage Decrease';
                document.getElementById('resultValue').textContent = percentage.toFixed(2) + '%';
                
                stepsHTML = `
                    <div class="breakdown-item"><span>Original Value</span><strong>${original}</strong></div>
                    <div class="breakdown-item"><span>New Value</span><strong>${newVal}</strong></div>
                    <div class="breakdown-item"><span>Decrease</span><strong>${change.toFixed(2)}</strong></div>
                    <div class="breakdown-item"><span>Formula</span><strong>((${original} - ${newVal})/${original}) × 100</strong></div>
                    <div class="breakdown-item"><span>Result</span><strong>${percentage.toFixed(2)}%</strong></div>
                `;
                
                // Common percentages
                document.getElementById('common10').textContent = (original * 0.90).toFixed(2);
                document.getElementById('common20').textContent = (original * 0.80).toFixed(2);
                document.getElementById('common25').textContent = (original * 0.75).toFixed(2);
                document.getElementById('common50').textContent = (original * 0.50).toFixed(2);
                document.getElementById('common75').textContent = (original * 0.25).toFixed(2);
            }
            
            document.getElementById('percentDisplay').textContent = percentage.toFixed(2) + '%';
            document.getElementById('decimalDisplay').textContent = (percentage / 100).toFixed(4);
            document.getElementById('calculationSteps').innerHTML = stepsHTML;
        }

        window.addEventListener('load', function() {
            calculatePercentage();
        });
    </script>
</body>
</html>