<?php
/**
 * Advanced Z-Score Calculator
 * File: z-score-calculator.php
 * Description: Complete Z-Score calculator with multiple calculation types and step-by-step solutions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Z-Score Calculator - All Calculation Types</title>
    <meta name="description" content="Calculate Z-Scores, probabilities, percentiles, confidence intervals, and more with step-by-step solutions.">
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
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
        
        .input-field input, .input-field select, .input-field textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1.1rem;
            outline: none;
            transition: all 0.3s;
        }
        
        .input-field input:focus, .input-field select:focus, .input-field textarea:focus {
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
        
        .normal-curve {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .curve-svg {
            max-width: 100%;
            height: auto;
        }
        
        .z-score-display {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 4px solid #2196F3;
            text-align: center;
            font-size: 1.3rem;
            font-weight: bold;
            font-family: 'Courier New', monospace;
        }
        
        .probability-bar {
            height: 40px;
            background: #e0e0e0;
            border-radius: 20px;
            margin: 15px 0;
            overflow: hidden;
            position: relative;
        }
        
        .probability-fill {
            height: 100%;
            background: linear-gradient(90deg, #4CAF50, #45a049);
            transition: width 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .probability-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 0.8rem;
            color: #666;
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
        
        .confidence-levels {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
            margin: 15px 0;
        }
        
        .confidence-btn {
            padding: 10px;
            background: #e3f2fd;
            border: 1px solid #90caf9;
            border-radius: 6px;
            cursor: pointer;
            text-align: center;
            font-size: 0.85rem;
            transition: all 0.3s;
        }
        
        .confidence-btn:hover {
            background: #bbdefb;
        }
        
        .confidence-btn.active {
            background: #2196F3;
            color: white;
        }
        
        .distribution-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .distribution-table th,
        .distribution-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .distribution-table th {
            background: #667eea;
            color: white;
            font-weight: 600;
        }
        
        .distribution-table tr:hover {
            background: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Z Advanced Z-Score Calculator</h1>
            <p>Calculate Z-Scores, probabilities, percentiles, confidence intervals, and more</p>
        </header>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Basic<br>Z-Score</button>
                <button class="tab-btn" onclick="switchTab(1)">Probability<br>from Z</button>
                <button class="tab-btn" onclick="switchTab(2)">Z from<br>Probability</button>
                <button class="tab-btn" onclick="switchTab(3)">Percentile<br>Rank</button>
                <button class="tab-btn" onclick="switchTab(4)">Confidence<br>Intervals</button>
                <button class="tab-btn" onclick="switchTab(5)">Two Z-Scores<br>Comparison</button>
                <button class="tab-btn" onclick="switchTab(6)">Sample<br>Statistics</button>
            </div>

            <!-- Tab 1: Basic Z-Score -->
            <div id="tab0" class="tab-content active">
                <div class="calculation-type">Basic Z-Score Calculation: Z = (X - μ) / σ</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Data Value (X)</label>
                        <div class="input-field">
                            <input type="number" id="basic_x" value="85" step="0.1">
                            <div class="input-hint">The value you want to standardize</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Mean (μ)</label>
                        <div class="input-field">
                            <input type="number" id="basic_mean" value="75" step="0.1">
                            <div class="input-hint">Population mean</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Standard Deviation (σ)</label>
                        <div class="input-field">
                            <input type="number" id="basic_std" value="10" step="0.1" min="0.1">
                            <div class="input-hint">Population standard deviation</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateBasicZScore()">Calculate Z-Score</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setBasicExample(85, 75, 10)">Test Score: 85</button>
                        <button class="example-btn" onclick="setBasicExample(115, 100, 15)">IQ Score: 115</button>
                        <button class="example-btn" onclick="setBasicExample(72, 70, 2)">Height: 72in</button>
                        <button class="example-btn" onclick="setBasicExample(180, 170, 15)">Weight: 180lb</button>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Probability from Z -->
            <div id="tab1" class="tab-content">
                <div class="calculation-type">Probability from Z-Score</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Z-Score</label>
                        <div class="input-field">
                            <input type="number" id="prob_z" value="1.5" step="0.1">
                            <div class="input-hint">Enter the Z-score value</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Probability Type</label>
                        <div class="input-field">
                            <select id="prob_type">
                                <option value="less">P(Z ≤ z) - Less than or equal</option>
                                <option value="greater">P(Z ≥ z) - Greater than or equal</option>
                                <option value="between">P(-z ≤ Z ≤ z) - Between</option>
                                <option value="outside">P(|Z| ≥ z) - Outside</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group" id="between_group" style="display: none;">
                        <label>Second Z-Score (for between probability)</label>
                        <div class="input-field">
                            <input type="number" id="prob_z2" value="-1.5" step="0.1">
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateProbabilityFromZ()">Calculate Probability</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setProbExample(1.96, 'less')">P(Z ≤ 1.96)</button>
                        <button class="example-btn" onclick="setProbExample(2.5, 'greater')">P(Z ≥ 2.5)</button>
                        <button class="example-btn" onclick="setProbExample(1.0, 'between')">P(-1 ≤ Z ≤ 1)</button>
                        <button class="example-btn" onclick="setProbExample(1.645, 'outside')">P(|Z| ≥ 1.645)</button>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Z from Probability -->
            <div id="tab2" class="tab-content">
                <div class="calculation-type">Z-Score from Probability</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Probability</label>
                        <div class="input-field">
                            <input type="number" id="z_prob" value="0.95" step="0.01" min="0.001" max="0.999">
                            <div class="input-hint">Enter probability (0.001 to 0.999)</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Probability Type</label>
                        <div class="input-field">
                            <select id="z_prob_type">
                                <option value="left">Left-tailed (P(Z ≤ z) = p)</option>
                                <option value="right">Right-tailed (P(Z ≥ z) = p)</option>
                                <option value="two">Two-tailed (P(|Z| ≤ z) = p)</option>
                            </select>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateZFromProbability()">Find Z-Score</button>
                </div>
                
                <div class="examples">
                    <h3>Common Z-Scores:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setZFromProbExample(0.95, 'two')">95% Confidence</button>
                        <button class="example-btn" onclick="setZFromProbExample(0.99, 'two')">99% Confidence</button>
                        <button class="example-btn" onclick="setZFromProbExample(0.05, 'right')">5% Significance</button>
                        <button class="example-btn" onclick="setZFromProbExample(0.01, 'right')">1% Significance</button>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Percentile Rank -->
            <div id="tab3" class="tab-content">
                <div class="calculation-type">Percentile Rank from Z-Score</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Z-Score</label>
                        <div class="input-field">
                            <input type="number" id="percentile_z" value="1.0" step="0.1">
                            <div class="input-hint">Enter the Z-score</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculatePercentile()">Calculate Percentile</button>
                </div>
                
                <div class="examples">
                    <h3>Example Z-Scores:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setPercentileExample(0)">Z = 0 (50th %ile)</button>
                        <button class="example-btn" onclick="setPercentileExample(1)">Z = 1 (84th %ile)</button>
                        <button class="example-btn" onclick="setPercentileExample(1.96)">Z = 1.96 (97.5th %ile)</button>
                        <button class="example-btn" onclick="setPercentileExample(-1)">Z = -1 (16th %ile)</button>
                    </div>
                </div>
            </div>

            <!-- Tab 5: Confidence Intervals -->
            <div id="tab4" class="tab-content">
                <div class="calculation-type">Confidence Intervals</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Sample Mean (x̄)</label>
                        <div class="input-field">
                            <input type="number" id="ci_mean" value="100" step="0.1">
                            <div class="input-hint">Sample mean</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Standard Deviation (σ or s)</label>
                        <div class="input-field">
                            <input type="number" id="ci_std" value="15" step="0.1" min="0.1">
                            <div class="input-hint">Population or sample standard deviation</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Sample Size (n)</label>
                        <div class="input-field">
                            <input type="number" id="ci_n" value="30" step="1" min="2">
                            <div class="input-hint">Number of observations</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Confidence Level</label>
                        <div class="confidence-levels">
                            <button class="confidence-btn active" onclick="setConfidenceLevel(0.90)">90%</button>
                            <button class="confidence-btn" onclick="setConfidenceLevel(0.95)">95%</button>
                            <button class="confidence-btn" onclick="setConfidenceLevel(0.99)">99%</button>
                            <button class="confidence-btn" onclick="setConfidenceLevel(0.999)">99.9%</button>
                        </div>
                        <input type="hidden" id="ci_level" value="0.95">
                    </div>
                    
                    <div class="input-group">
                        <label>
                            <input type="checkbox" id="population_std" checked> Population standard deviation known
                        </label>
                        <div class="input-hint">Uncheck to use t-distribution</div>
                    </div>
                    
                    <button class="btn" onclick="calculateConfidenceInterval()">Calculate Confidence Interval</button>
                </div>
                
                <div class="examples">
                    <h3>Example Scenarios:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setCIExample(100, 15, 30, 0.95, true)">IQ Scores</button>
                        <button class="example-btn" onclick="setCIExample(70, 3, 25, 0.95, false)">Heights</button>
                        <button class="example-btn" onclick="setCIExample(50, 10, 100, 0.99, true)">Test Scores</button>
                        <button class="example-btn" onclick="setCIExample(25, 5, 50, 0.90, false)">Response Times</button>
                    </div>
                </div>
            </div>

            <!-- Tab 6: Two Z-Scores Comparison -->
            <div id="tab5" class="tab-content">
                <div class="calculation-type">Compare Two Z-Scores</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>First Z-Score (Z₁)</label>
                        <div class="input-field">
                            <input type="number" id="compare_z1" value="1.5" step="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Second Z-Score (Z₂)</label>
                        <div class="input-field">
                            <input type="number" id="compare_z2" value="2.0" step="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Comparison Type</label>
                        <div class="input-field">
                            <select id="compare_type">
                                <option value="difference">Probability between Z₁ and Z₂</option>
                                <option value="relative">Relative standing comparison</option>
                                <option value="both">Both comparisons</option>
                            </select>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="compareZScores()">Compare Z-Scores</button>
                </div>
                
                <div class="examples">
                    <h3>Example Comparisons:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setCompareExample(1, 2, 'difference')">Z=1 vs Z=2</button>
                        <button class="example-btn" onclick="setCompareExample(-1, 1, 'difference')">Z=-1 vs Z=1</button>
                        <button class="example-btn" onclick="setCompareExample(0.5, 1.5, 'relative')">Moderate vs High</button>
                        <button class="example-btn" onclick="setCompareExample(-2, 2, 'both')">Extreme Ends</button>
                    </div>
                </div>
            </div>

            <!-- Tab 7: Sample Statistics -->
            <div id="tab6" class="tab-content">
                <div class="calculation-type">Z-Score from Sample Statistics</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Sample Data</label>
                        <div class="input-field">
                            <textarea id="sample_data" placeholder="Enter numbers separated by commas or spaces&#10;Example: 85, 90, 78, 92, 88">85, 90, 78, 92, 88</textarea>
                            <div class="input-hint">Enter your sample data points</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Target Value</label>
                        <div class="input-field">
                            <input type="number" id="target_value" value="95" step="0.1">
                            <div class="input-hint">Value to calculate Z-score for</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateSampleZScore()">Calculate Z-Score</button>
                </div>
                
                <div class="examples">
                    <h3>Example Datasets:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setSampleExample('85,90,78,92,88', 95)">Test Scores</button>
                        <button class="example-btn" onclick="setSampleExample('68,72,70,71,69', 75)">Heights</button>
                        <button class="example-btn" onclick="setSampleExample('25,30,28,32,27', 35)">Response Times</button>
                        <button class="example-btn" onclick="setSampleExample('150,160,155,165,158', 170)">Weights</button>
                    </div>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Z-Score Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Z-Score Formulas & Concepts</h3>
            
            <div class="info-grid">
                <div class="info-card">
                    <h4>Basic Z-Score Formula</h4>
                    <p>Z = (X - μ) / σ</p>
                    <p>Measures how many standard deviations a value is from the mean</p>
                </div>
                
                <div class="info-card">
                    <h4>Sample Z-Score</h4>
                    <p>Z = (X - x̄) / s</p>
                    <p>When using sample mean and standard deviation</p>
                </div>
                
                <div class="info-card">
                    <h4>Confidence Interval</h4>
                    <p>CI = x̄ ± Z × (σ/√n)</p>
                    <p>Range containing population mean with specified confidence</p>
                </div>
                
                <div class="info-card">
                    <h4>Standard Normal Distribution</h4>
                    <p>μ = 0, σ = 1</p>
                    <p>All Z-scores reference this distribution</p>
                </div>
                
                <div class="info-card">
                    <h4>Probability Interpretation</h4>
                    <p>P(Z ≤ z) = Area under curve</p>
                    <p>Represents cumulative probability</p>
                </div>
                
                <div class="info-card">
                    <h4>Percentile Rank</h4>
                    <p>Percentile = P(Z ≤ z) × 100</p>
                    <p>Percentage of values below given Z-score</p>
                </div>
            </div>
            
            <div class="formula-box">
                <strong>Common Z-Score Values:</strong>
                • Z = 0: 50th percentile (Mean)<br>
                • Z = ±1: 68% of data within ±1σ (34.1% each side)<br>
                • Z = ±1.96: 95% confidence interval (2.5% in each tail)<br>
                • Z = ±2.58: 99% confidence interval (0.5% in each tail)<br>
                • Z = ±3: 99.7% of data within ±3σ (0.15% in each tail)
            </div>
            
            <div class="distribution-table">
                <table>
                    <thead>
                        <tr>
                            <th>Z-Score</th>
                            <th>Percentile</th>
                            <th>Probability</th>
                            <th>Confidence Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>0.00</td>
                            <td>50.00%</td>
                            <td>0.5000</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>1.00</td>
                            <td>84.13%</td>
                            <td>0.8413</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>1.645</td>
                            <td>95.00%</td>
                            <td>0.9500</td>
                            <td>90%</td>
                        </tr>
                        <tr>
                            <td>1.96</td>
                            <td>97.50%</td>
                            <td>0.9750</td>
                            <td>95%</td>
                        </tr>
                        <tr>
                            <td>2.33</td>
                            <td>99.00%</td>
                            <td>0.9900</td>
                            <td>98%</td>
                        </tr>
                        <tr>
                            <td>2.58</td>
                            <td>99.50%</td>
                            <td>0.9950</td>
                            <td>99%</td>
                        </tr>
                        <tr>
                            <td>3.00</td>
                            <td>99.87%</td>
                            <td>0.9987</td>
                            <td>99.7%</td>
                        </tr>
                    </tbody>
                </table>
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
            
            // Update visibility for probability type
            updateProbabilityType();
        }
        
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
            document.getElementById('result').scrollIntoView({behavior: 'smooth', block: 'nearest'});
        }
        
        // Error function approximation for normal distribution
        function erf(x) {
            // Abramowitz and Stegun approximation
            const a1 =  0.254829592;
            const a2 = -0.284496736;
            const a3 =  1.421413741;
            const a4 = -1.453152027;
            const a5 =  1.061405429;
            const p  =  0.3275911;
            
            const sign = (x >= 0) ? 1 : -1;
            x = Math.abs(x);
            
            const t = 1.0 / (1.0 + p * x);
            const y = 1.0 - (((((a5 * t + a4) * t) + a3) * t + a2) * t + a1) * t * Math.exp(-x * x);
            
            return sign * y;
        }
        
        // Standard normal cumulative distribution function
        function normalCDF(z) {
            return 0.5 * (1 + erf(z / Math.sqrt(2)));
        }
        
        // Inverse normal CDF approximation
        function inverseNormalCDF(p) {
            // Approximation from Peter John Acklam
            if (p <= 0 || p >= 1) return NaN;
            
            const a1 = -39.6968302866538, a2 = 220.946098424521, a3 = -275.928510446969;
            const a4 = 138.357751867269, a5 = -30.6647980661472, a6 = 2.50662827745924;
            const b1 = -54.4760987982241, b2 = 161.585836858041, b3 = -155.698979859887;
            const b4 = 66.8013118877197, b5 = -13.2806815528857;
            const c1 = -0.00778489400243029, c2 = -0.322396458041136, c3 = -2.40075827716184;
            const c4 = -2.54973253934373, c5 = 4.37466414146497, c6 = 2.93816398269878;
            const d1 = 0.00778469570904146, d2 = 0.32246712907004, d3 = 2.445134137143;
            const d4 = 3.75440866190742;
            
            const p_low = 0.02425;
            const p_high = 1 - p_low;
            
            let q, r;
            
            if (p < p_low) {
                q = Math.sqrt(-2 * Math.log(p));
                return (((((c1 * q + c2) * q + c3) * q + c4) * q + c5) * q + c6) / 
                       ((((d1 * q + d2) * q + d3) * q + d4) * q + 1);
            } else if (p <= p_high) {
                q = p - 0.5;
                r = q * q;
                return (((((a1 * r + a2) * r + a3) * r + a4) * r + a5) * r + a6) * q / 
                       (((((b1 * r + b2) * r + b3) * r + b4) * r + b5) * r + 1);
            } else {
                q = Math.sqrt(-2 * Math.log(1 - p));
                return -(((((c1 * q + c2) * q + c3) * q + c4) * q + c5) * q + c6) / 
                        ((((d1 * q + d2) * q + d3) * q + d4) * q + 1);
            }
        }
        
        // Example setters
        function setBasicExample(x, mean, std) {
            document.getElementById('basic_x').value = x;
            document.getElementById('basic_mean').value = mean;
            document.getElementById('basic_std').value = std;
        }
        
        function setProbExample(z, type) {
            document.getElementById('prob_z').value = z;
            document.getElementById('prob_type').value = type;
            updateProbabilityType();
        }
        
        function setZFromProbExample(prob, type) {
            document.getElementById('z_prob').value = prob;
            document.getElementById('z_prob_type').value = type;
        }
        
        function setPercentileExample(z) {
            document.getElementById('percentile_z').value = z;
        }
        
        function setCIExample(mean, std, n, level, population) {
            document.getElementById('ci_mean').value = mean;
            document.getElementById('ci_std').value = std;
            document.getElementById('ci_n').value = n;
            document.getElementById('ci_level').value = level;
            document.getElementById('population_std').checked = population;
            setConfidenceLevel(level);
        }
        
        function setCompareExample(z1, z2, type) {
            document.getElementById('compare_z1').value = z1;
            document.getElementById('compare_z2').value = z2;
            document.getElementById('compare_type').value = type;
        }
        
        function setSampleExample(data, target) {
            document.getElementById('sample_data').value = data;
            document.getElementById('target_value').value = target;
        }
        
        function setConfidenceLevel(level) {
            document.getElementById('ci_level').value = level;
            document.querySelectorAll('.confidence-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }
        
        function updateProbabilityType() {
            const type = document.getElementById('prob_type').value;
            document.getElementById('between_group').style.display = type === 'between' ? 'block' : 'none';
        }
        
        // Calculation functions
        function calculateBasicZScore() {
            const x = parseFloat(document.getElementById('basic_x').value);
            const mean = parseFloat(document.getElementById('basic_mean').value);
            const std = parseFloat(document.getElementById('basic_std').value);
            
            if (isNaN(x) || isNaN(mean) || isNaN(std) || std <= 0) {
                show('<div class="error-box">⚠️ Please enter valid numbers (σ > 0)</div>');
                return;
            }
            
            const z = (x - mean) / std;
            const probability = normalCDF(z);
            const percentile = probability * 100;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Z-Score</div>
                    <div class="result-value">${z.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Probability</div>
                    <div class="result-value" style="color:#2196F3;">${probability.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Percentile</div>
                    <div class="result-value" style="color:#4CAF50;">${percentile.toFixed(2)}%</div>
                </div>
            </div>`;
            
            html += `<div class="z-score-display">
                Z = (${x} - ${mean}) / ${std} = ${z.toFixed(4)}
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Subtract mean from value: ${x} - ${mean} = ${(x - mean).toFixed(2)}</div>
                <div class="step">2. Divide by standard deviation: ${(x - mean).toFixed(2)} / ${std} = ${z.toFixed(4)}</div>
                <div class="step">3. Z-score = ${z.toFixed(4)}</div>
                <div class="step">4. This means the value is ${Math.abs(z).toFixed(2)} standard deviation${Math.abs(z) !== 1 ? 's' : ''} ${z >= 0 ? 'above' : 'below'} the mean</div>
            </div>`;
            
            html += `<div class="probability-bar">
                <div class="probability-fill" style="width: ${percentile}%">${percentile.toFixed(1)}%</div>
            </div>
            <div class="probability-labels">
                <span>0%</span>
                <span>${percentile.toFixed(1)}%</span>
                <span>100%</span>
            </div>`;
            
            let interpretation = "";
            if (Math.abs(z) <= 1) {
                interpretation = "This is within 1 standard deviation of the mean - a typical value.";
            } else if (Math.abs(z) <= 2) {
                interpretation = "This is between 1 and 2 standard deviations from the mean - a somewhat unusual value.";
            } else if (Math.abs(z) <= 3) {
                interpretation = "This is between 2 and 3 standard deviations from the mean - a very unusual value.";
            } else {
                interpretation = "This is more than 3 standard deviations from the mean - an extreme outlier.";
            }
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                ${interpretation}<br>
                The value is at the ${percentile.toFixed(1)}th percentile, meaning it's higher than ${percentile.toFixed(1)}% of values in the distribution.
            </div>`;
            
            show(html);
        }
        
        function calculateProbabilityFromZ() {
            const z = parseFloat(document.getElementById('prob_z').value);
            const type = document.getElementById('prob_type').value;
            const z2 = type === 'between' ? parseFloat(document.getElementById('prob_z2').value) : 0;
            
            if (isNaN(z) || (type === 'between' && isNaN(z2))) {
                show('<div class="error-box">⚠️ Please enter valid Z-scores</div>');
                return;
            }
            
            let probability, formula, steps;
            const probZ = normalCDF(z);
            
            switch(type) {
                case 'less':
                    probability = probZ;
                    formula = `P(Z ≤ ${z})`;
                    steps = `Using standard normal distribution table: P(Z ≤ ${z}) = ${probability.toFixed(6)}`;
                    break;
                    
                case 'greater':
                    probability = 1 - probZ;
                    formula = `P(Z ≥ ${z}) = 1 - P(Z ≤ ${z})`;
                    steps = `P(Z ≥ ${z}) = 1 - ${probZ.toFixed(6)} = ${probability.toFixed(6)}`;
                    break;
                    
                case 'between':
                    if (z2 >= z) {
                        show('<div class="error-box">⚠️ For between probability, first Z should be less than second Z</div>');
                        return;
                    }
                    const probZ2 = normalCDF(z2);
                    probability = probZ - probZ2;
                    formula = `P(${z2} ≤ Z ≤ ${z}) = P(Z ≤ ${z}) - P(Z ≤ ${z2})`;
                    steps = `P(${z2} ≤ Z ≤ ${z}) = ${probZ.toFixed(6)} - ${probZ2.toFixed(6)} = ${probability.toFixed(6)}`;
                    break;
                    
                case 'outside':
                    probability = 2 * (1 - probZ);
                    formula = `P(|Z| ≥ ${z}) = 2 × P(Z ≥ ${z})`;
                    steps = `P(|Z| ≥ ${z}) = 2 × (1 - ${probZ.toFixed(6)}) = ${probability.toFixed(6)}`;
                    break;
            }
            
            const percentage = probability * 100;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Probability</div>
                    <div class="result-value">${probability.toFixed(6)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Percentage</div>
                    <div class="result-value" style="color:#2196F3;">${percentage.toFixed(4)}%</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Formula</div>
                    <div class="result-value" style="color:#4CAF50;">${type.toUpperCase()}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. ${formula}</div>
                <div class="step">2. ${steps}</div>
                <div class="step">3. Result = ${probability.toFixed(6)} (${percentage.toFixed(4)}%)</div>
            </div>`;
            
            html += `<div class="probability-bar">
                <div class="probability-fill" style="width: ${percentage}%">${percentage.toFixed(2)}%</div>
            </div>`;
            
            show(html);
        }
        
        function calculateZFromProbability() {
            const p = parseFloat(document.getElementById('z_prob').value);
            const type = document.getElementById('z_prob_type').value;
            
            if (isNaN(p) || p <= 0 || p >= 1) {
                show('<div class="error-box">⚠️ Please enter a valid probability between 0 and 1</div>');
                return;
            }
            
            let z, formula, steps;
            
            switch(type) {
                case 'left':
                    z = inverseNormalCDF(p);
                    formula = `P(Z ≤ z) = ${p}`;
                    steps = `Find z such that P(Z ≤ z) = ${p}`;
                    break;
                    
                case 'right':
                    z = inverseNormalCDF(1 - p);
                    formula = `P(Z ≥ z) = ${p}`;
                    steps = `Find z such that P(Z ≥ z) = ${p}, which is equivalent to P(Z ≤ z) = ${(1-p).toFixed(4)}`;
                    break;
                    
                case 'two':
                    z = inverseNormalCDF(1 - (1 - p) / 2);
                    formula = `P(|Z| ≤ z) = ${p}`;
                    steps = `Find z such that P(-z ≤ Z ≤ z) = ${p}, which means P(Z ≤ z) = ${(1 - (1-p)/2).toFixed(4)}`;
                    break;
            }
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Z-Score</div>
                    <div class="result-value">${z.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Probability</div>
                    <div class="result-value" style="color:#2196F3;">${p}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Type</div>
                    <div class="result-value" style="color:#4CAF50;">${type.toUpperCase()}</div>
                </div>
            </div>`;
            
            html += `<div class="z-score-display">
                For ${formula}, Z = ${z.toFixed(4)}
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. ${steps}</div>
                <div class="step">2. Using inverse normal distribution function</div>
                <div class="step">3. Z-score = ${z.toFixed(4)}</div>
            </div>`;
            
            // Common confidence levels reference
            const commonLevels = {
                '0.90': {z: 1.645, type: 'two'},
                '0.95': {z: 1.960, type: 'two'}, 
                '0.99': {z: 2.576, type: 'two'},
                '0.999': {z: 3.291, type: 'two'}
            };
            
            let reference = "<strong>Common Confidence Levels:</strong><br>";
            for (const [level, info] of Object.entries(commonLevels)) {
                reference += `• ${(parseFloat(level)*100).toFixed(1)}% confidence: Z = ${info.z}<br>`;
            }
            
            html += `<div class="formula-box">
                ${reference}
            </div>`;
            
            show(html);
        }
        
        function calculatePercentile() {
            const z = parseFloat(document.getElementById('percentile_z').value);
            
            if (isNaN(z)) {
                show('<div class="error-box">⚠️ Please enter a valid Z-score</div>');
                return;
            }
            
            const probability = normalCDF(z);
            const percentile = probability * 100;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Percentile</div>
                    <div class="result-value">${percentile.toFixed(2)}%</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Probability</div>
                    <div class="result-value" style="color:#2196F3;">${probability.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Z-Score</div>
                    <div class="result-value" style="color:#4CAF50;">${z.toFixed(2)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Calculate P(Z ≤ ${z}) using standard normal distribution</div>
                <div class="step">2. P(Z ≤ ${z}) = ${probability.toFixed(6)}</div>
                <div class="step">3. Convert to percentile: ${probability.toFixed(6)} × 100 = ${percentile.toFixed(2)}%</div>
            </div>`;
            
            html += `<div class="probability-bar">
                <div class="probability-fill" style="width: ${percentile}%">${percentile.toFixed(1)}%</div>
            </div>
            <div class="probability-labels">
                <span>0%</span>
                <span>${percentile.toFixed(1)}%</span>
                <span>100%</span>
            </div>`;
            
            let interpretation = "";
            if (percentile < 5) {
                interpretation = "This is in the bottom 5% - a very low value.";
            } else if (percentile < 25) {
                interpretation = "This is in the bottom quartile - a below average value.";
            } else if (percentile < 75) {
                interpretation = "This is in the middle 50% - an average value.";
            } else if (percentile < 95) {
                interpretation = "This is in the top quartile - an above average value.";
            } else {
                interpretation = "This is in the top 5% - a very high value.";
            }
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                ${interpretation}<br>
                A Z-score of ${z.toFixed(2)} corresponds to the ${percentile.toFixed(1)}th percentile, meaning ${percentile.toFixed(1)}% of values are below this point in a normal distribution.
            </div>`;
            
            show(html);
        }
        
        function calculateConfidenceInterval() {
            const mean = parseFloat(document.getElementById('ci_mean').value);
            const std = parseFloat(document.getElementById('ci_std').value);
            const n = parseInt(document.getElementById('ci_n').value);
            const level = parseFloat(document.getElementById('ci_level').value);
            const populationKnown = document.getElementById('population_std').checked;
            
            if (isNaN(mean) || isNaN(std) || isNaN(n) || std <= 0 || n < 2) {
                show('<div class="error-box">⚠️ Please enter valid numbers (σ > 0, n ≥ 2)</div>');
                return;
            }
            
            let z, criticalValue, marginOfError;
            const alpha = 1 - level;
            
            if (populationKnown) {
                // Use Z-distribution
                z = inverseNormalCDF(1 - alpha/2);
                criticalValue = z;
                marginOfError = z * (std / Math.sqrt(n));
            } else {
                // Use t-distribution (simplified - for large n it approximates normal)
                // For simplicity, we'll use normal approximation for n > 30
                if (n > 30) {
                    z = inverseNormalCDF(1 - alpha/2);
                    criticalValue = z;
                    marginOfError = z * (std / Math.sqrt(n));
                } else {
                    // Simplified t-distribution - in practice, you'd use proper t-table
                    z = inverseNormalCDF(1 - alpha/2);
                    criticalValue = z * (1 + 0.5/n); // Approximation
                    marginOfError = criticalValue * (std / Math.sqrt(n));
                }
            }
            
            const lower = mean - marginOfError;
            const upper = mean + marginOfError;
            const percentage = level * 100;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Confidence Interval</div>
                    <div class="result-value">[${lower.toFixed(2)}, ${upper.toFixed(2)}]</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Margin of Error</div>
                    <div class="result-value" style="color:#2196F3;">±${marginOfError.toFixed(2)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Critical Value</div>
                    <div class="result-value" style="color:#4CAF50;">${criticalValue.toFixed(3)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Confidence level: ${percentage}%</div>
                <div class="step">2. Critical value: ${criticalValue.toFixed(4)}</div>
                <div class="step">3. Standard error: ${std} / √${n} = ${(std/Math.sqrt(n)).toFixed(4)}</div>
                <div class="step">4. Margin of error: ${criticalValue.toFixed(4)} × ${(std/Math.sqrt(n)).toFixed(4)} = ${marginOfError.toFixed(4)}</div>
                <div class="step">5. Lower bound: ${mean} - ${marginOfError.toFixed(4)} = ${lower.toFixed(4)}</div>
                <div class="step">6. Upper bound: ${mean} + ${marginOfError.toFixed(4)} = ${upper.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                We are ${percentage}% confident that the true population mean lies between ${lower.toFixed(2)} and ${upper.toFixed(2)}.<br>
                This interval was calculated using ${populationKnown ? 'Z-distribution (σ known)' : 't-distribution approximation (σ unknown)'}.
            </div>`;
            
            show(html);
        }
        
        function compareZScores() {
            const z1 = parseFloat(document.getElementById('compare_z1').value);
            const z2 = parseFloat(document.getElementById('compare_z2').value);
            const type = document.getElementById('compare_type').value;
            
            if (isNaN(z1) || isNaN(z2)) {
                show('<div class="error-box">⚠️ Please enter valid Z-scores</div>');
                return;
            }
            
            const prob1 = normalCDF(z1);
            const prob2 = normalCDF(z2);
            let html = '';
            
            if (type === 'difference' || type === 'both') {
                const probBetween = Math.abs(prob2 - prob1);
                const percentageBetween = probBetween * 100;
                
                html += `<div class="result-grid">
                    <div class="result-box">
                        <div class="result-label">Probability Between</div>
                        <div class="result-value">${probBetween.toFixed(4)}</div>
                    </div>
                    <div class="result-box" style="border-left-color:#2196F3;">
                        <div class="result-label">Percentage</div>
                        <div class="result-value" style="color:#2196F3;">${percentageBetween.toFixed(2)}%</div>
                    </div>
                    <div class="result-box" style="border-left-color:#4CAF50;">
                        <div class="result-label">Z-Scores</div>
                        <div class="result-value" style="color:#4CAF50;">${z1} to ${z2}</div>
                    </div>
                </div>`;
                
                html += `<div class="step-box">
                    <strong>📝 Probability Between Z-Scores:</strong>
                    <div class="step">P(Z ≤ ${z2}) = ${prob2.toFixed(6)}</div>
                    <div class="step">P(Z ≤ ${z1}) = ${prob1.toFixed(6)}</div>
                    <div class="step">P(${z1} ≤ Z ≤ ${z2}) = |${prob2.toFixed(6)} - ${prob1.toFixed(6)}| = ${probBetween.toFixed(6)}</div>
                </div>`;
            }
            
            if (type === 'relative' || type === 'both') {
                const ratio = prob2 / prob1;
                const difference = (prob2 - prob1) * 100;
                
                html += `<div class="result-grid">
                    <div class="result-box">
                        <div class="result-label">Percentile 1</div>
                        <div class="result-value">${(prob1 * 100).toFixed(2)}%</div>
                    </div>
                    <div class="result-box" style="border-left-color:#2196F3;">
                        <div class="result-label">Percentile 2</div>
                        <div class="result-value" style="color:#2196F3;">${(prob2 * 100).toFixed(2)}%</div>
                    </div>
                    <div class="result-box" style="border-left-color:#4CAF50;">
                        <div class="result-label">Difference</div>
                        <div class="result-value" style="color:#4CAF50;">${difference.toFixed(2)}%</div>
                    </div>
                </div>`;
                
                html += `<div class="step-box">
                    <strong>📝 Relative Standing Comparison:</strong>
                    <div class="step">Z₁ = ${z1} → ${(prob1 * 100).toFixed(2)}th percentile</div>
                    <div class="step">Z₂ = ${z2} → ${(prob2 * 100).toFixed(2)}th percentile</div>
                    <div class="step">Difference: ${(prob2 * 100).toFixed(2)}% - ${(prob1 * 100).toFixed(2)}% = ${difference.toFixed(2)}%</div>
                    <div class="step">Ratio: ${(prob2 * 100).toFixed(2)}% / ${(prob1 * 100).toFixed(2)}% = ${ratio.toFixed(2)}</div>
                </div>`;
            }
            
            let interpretation = "";
            if (Math.abs(z1 - z2) <= 0.5) {
                interpretation = "These Z-scores are quite close together, indicating similar positions in the distribution.";
            } else if (Math.abs(z1 - z2) <= 1) {
                interpretation = "These Z-scores are moderately different, showing noticeable but not extreme separation.";
            } else {
                interpretation = "These Z-scores are quite different, indicating substantial separation in their positions within the distribution.";
            }
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                ${interpretation}
            </div>`;
            
            show(html);
        }
        
        function calculateSampleZScore() {
            const dataText = document.getElementById('sample_data').value;
            const target = parseFloat(document.getElementById('target_value').value);
            
            if (!dataText || isNaN(target)) {
                show('<div class="error-box">⚠️ Please enter valid sample data and target value</div>');
                return;
            }
            
            // Parse sample data
            const numbers = dataText.split(/[,\s]+/).map(num => parseFloat(num.trim())).filter(num => !isNaN(num));
            
            if (numbers.length < 2) {
                show('<div class="error-box">⚠️ Please enter at least 2 valid numbers</div>');
                return;
            }
            
            // Calculate sample statistics
            const mean = numbers.reduce((a, b) => a + b, 0) / numbers.length;
            const variance = numbers.reduce((a, b) => a + Math.pow(b - mean, 2), 0) / (numbers.length - 1);
            const std = Math.sqrt(variance);
            const z = (target - mean) / std;
            const probability = normalCDF(z);
            const percentile = probability * 100;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Z-Score</div>
                    <div class="result-value">${z.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Sample Mean</div>
                    <div class="result-value" style="color:#2196F3;">${mean.toFixed(2)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Sample Std Dev</div>
                    <div class="result-value" style="color:#4CAF50;">${std.toFixed(2)}</div>
                </div>
            </div>`;
            
            html += `<div class="z-score-display">
                Z = (${target} - ${mean.toFixed(2)}) / ${std.toFixed(2)} = ${z.toFixed(4)}
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Sample data: [${numbers.join(', ')}]</div>
                <div class="step">2. Sample mean: ${mean.toFixed(4)}</div>
                <div class="step">3. Sample standard deviation: ${std.toFixed(4)}</div>
                <div class="step">4. Z-score: (${target} - ${mean.toFixed(4)}) / ${std.toFixed(4)} = ${z.toFixed(4)}</div>
                <div class="step">5. Percentile: ${percentile.toFixed(2)}%</div>
            </div>`;
            
            html += `<div class="probability-bar">
                <div class="probability-fill" style="width: ${percentile}%">${percentile.toFixed(1)}%</div>
            </div>
            <div class="probability-labels">
                <span>0%</span>
                <span>${percentile.toFixed(1)}%</span>
                <span>100%</span>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Sample Statistics:</strong>
                • Sample size: n = ${numbers.length}<br>
                • Data range: ${Math.min(...numbers).toFixed(2)} to ${Math.max(...numbers).toFixed(2)}<br>
                • Target value: ${target}<br>
                • Relative to sample: ${z >= 0 ? 'above' : 'below'} mean by ${Math.abs(z).toFixed(2)} standard deviations
            </div>`;
            
            show(html);
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            switchTab(0);
            document.getElementById('prob_type').addEventListener('change', updateProbabilityType);
        });
    </script>
</body>
</html>