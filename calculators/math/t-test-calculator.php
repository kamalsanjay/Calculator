<?php
/**
 * Advanced T-Test Calculator
 * File: t-test-calculator.php
 * Description: Complete T-Test calculator with multiple test types and step-by-step solutions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced T-Test Calculator - All Test Types</title>
    <meta name="description" content="Calculate T-Tests, p-values, confidence intervals, effect sizes, and more with step-by-step solutions.">
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
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
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
        
        .significance-levels {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
            margin: 15px 0;
        }
        
        .sig-level-btn {
            padding: 10px;
            background: #e3f2fd;
            border: 1px solid #90caf9;
            border-radius: 6px;
            cursor: pointer;
            text-align: center;
            font-size: 0.85rem;
            transition: all 0.3s;
        }
        
        .sig-level-btn:hover {
            background: #bbdefb;
        }
        
        .sig-level-btn.active {
            background: #2196F3;
            color: white;
        }
        
        .data-input-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
        }
        
        .data-group {
            margin-bottom: 15px;
        }
        
        .data-group:last-child {
            margin-bottom: 0;
        }
        
        .data-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }
        
        .data-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
        }
        
        .hypothesis-test {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #4CAF50;
        }
        
        .test-interpretation {
            background: #fff3e0;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #ff9800;
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
        
        .t-distribution-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .t-distribution-table th,
        .t-distribution-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .t-distribution-table th {
            background: #667eea;
            color: white;
            font-weight: 600;
        }
        
        .t-distribution-table tr:hover {
            background: #f5f5f5;
        }
        
        .critical-value {
            background: #ffeb3b;
            font-weight: bold;
        }
        
        .statistical-significance {
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            text-align: center;
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .significant {
            background: #e8f5e9;
            border-left: 4px solid #4CAF50;
            color: #2e7d32;
        }
        
        .not-significant {
            background: #ffebee;
            border-left: 4px solid #f44336;
            color: #c62828;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>t Advanced T-Test Calculator</h1>
            <p>Calculate T-Tests, p-values, confidence intervals, effect sizes, and more</p>
        </header>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">One Sample<br>T-Test</button>
                <button class="tab-btn" onclick="switchTab(1)">Independent<br>Samples T-Test</button>
                <button class="tab-btn" onclick="switchTab(2)">Paired Samples<br>T-Test</button>
                <button class="tab-btn" onclick="switchTab(3)">T-Score from<br>Data</button>
                <button class="tab-btn" onclick="switchTab(4)">P-Value from<br>T-Score</button>
                <button class="tab-btn" onclick="switchTab(5)">Effect Size<br>Calculator</button>
                <button class="tab-btn" onclick="switchTab(6)">Power<br>Analysis</button>
            </div>

            <!-- Tab 1: One Sample T-Test -->
            <div id="tab0" class="tab-content active">
                <div class="calculation-type">One Sample T-Test: Compare sample mean to population mean</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Sample Data</label>
                        <div class="input-field">
                            <textarea id="one_sample_data" placeholder="Enter sample data separated by commas&#10;Example: 85, 90, 78, 92, 88">85, 90, 78, 92, 88</textarea>
                            <div class="input-hint">Enter your sample measurements</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Population Mean (μ₀)</label>
                        <div class="input-field">
                            <input type="number" id="one_sample_mu" value="80" step="0.1">
                            <div class="input-hint">Hypothesized population mean to test against</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Significance Level (α)</label>
                        <div class="significance-levels">
                            <button class="sig-level-btn active" onclick="setSignificanceLevel(0.05)">0.05</button>
                            <button class="sig-level-btn" onclick="setSignificanceLevel(0.01)">0.01</button>
                            <button class="sig-level-btn" onclick="setSignificanceLevel(0.10)">0.10</button>
                            <button class="sig-level-btn" onclick="setCustomSignificanceLevel()">Custom</button>
                        </div>
                        <input type="hidden" id="one_sample_alpha" value="0.05">
                        <div id="custom_alpha_container" style="display: none; margin-top: 10px;">
                            <input type="number" id="custom_alpha" value="0.05" step="0.001" min="0.001" max="0.2" placeholder="Enter custom alpha">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Alternative Hypothesis</label>
                        <div class="input-field">
                            <select id="one_sample_tail">
                                <option value="two-tailed">Two-tailed (μ ≠ μ₀)</option>
                                <option value="greater">One-tailed: Greater than (μ > μ₀)</option>
                                <option value="less">One-tailed: Less than (μ < μ₀)</option>
                            </select>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateOneSampleTTest()">Calculate T-Test</button>
                </div>
                
                <div class="examples">
                    <h3>Example Scenarios:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setOneSampleExample('85,90,78,92,88', 80, 'two-tailed')">Test Scores vs 80</button>
                        <button class="example-btn" onclick="setOneSampleExample('68,72,70,71,69', 70, 'two-tailed')">Heights vs 70in</button>
                        <button class="example-btn" onclick="setOneSampleExample('25,30,28,32,27', 20, 'greater')">Response Times > 20ms</button>
                        <button class="example-btn" onclick="setOneSampleExample('150,160,155,165,158', 170, 'less')">Weights < 170lb</button>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Independent Samples T-Test -->
            <div id="tab1" class="tab-content">
                <div class="calculation-type">Independent Samples T-Test: Compare two independent groups</div>
                
                <div class="input-section">
                    <div class="data-input-section">
                        <div class="data-group">
                            <label>Group 1 Data</label>
                            <textarea class="data-input" id="indep_data1" placeholder="Enter Group 1 data separated by commas&#10;Example: 85, 90, 78, 92, 88">85, 90, 78, 92, 88</textarea>
                        </div>
                        
                        <div class="data-group">
                            <label>Group 2 Data</label>
                            <textarea class="data-input" id="indep_data2" placeholder="Enter Group 2 data separated by commas&#10;Example: 75, 82, 79, 85, 80">75, 82, 79, 85, 80</textarea>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Assume Equal Variances?</label>
                        <div class="input-field">
                            <select id="equal_variances">
                                <option value="yes">Yes (use pooled variance)</option>
                                <option value="no">No (use Welch's t-test)</option>
                            </select>
                            <div class="input-hint">Use Welch's test if you're unsure about variance equality</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Significance Level (α)</label>
                        <div class="significance-levels">
                            <button class="sig-level-btn active" onclick="setSignificanceLevel(0.05, 'indep')">0.05</button>
                            <button class="sig-level-btn" onclick="setSignificanceLevel(0.01, 'indep')">0.01</button>
                            <button class="sig-level-btn" onclick="setSignificanceLevel(0.10, 'indep')">0.10</button>
                        </div>
                        <input type="hidden" id="indep_alpha" value="0.05">
                    </div>
                    
                    <div class="input-group">
                        <label>Alternative Hypothesis</label>
                        <div class="input-field">
                            <select id="indep_tail">
                                <option value="two-tailed">Two-tailed (μ₁ ≠ μ₂)</option>
                                <option value="greater">One-tailed: Group 1 > Group 2</option>
                                <option value="less">One-tailed: Group 1 < Group 2</option>
                            </select>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateIndependentTTest()">Calculate T-Test</button>
                </div>
                
                <div class="examples">
                    <h3>Example Scenarios:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setIndependentExample('85,90,78,92,88', '75,82,79,85,80', 'two-tailed')">Treatment vs Control</button>
                        <button class="example-btn" onclick="setIndependentExample('68,72,70,71,69', '65,67,66,68,64', 'two-tailed')">Male vs Female Height</button>
                        <button class="example-btn" onclick="setIndependentExample('25,30,28,32,27', '30,35,32,38,33', 'less')">Method A < Method B</button>
                        <button class="example-btn" onclick="setIndependentExample('150,160,155,165,158', '140,145,142,148,143', 'greater')">Group X > Group Y</button>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Paired Samples T-Test -->
            <div id="tab2" class="tab-content">
                <div class="calculation-type">Paired Samples T-Test: Compare paired measurements</div>
                
                <div class="input-section">
                    <div class="data-input-section">
                        <div class="data-group">
                            <label>Before/Time 1 Data</label>
                            <textarea class="data-input" id="paired_data1" placeholder="Enter measurements before treatment or at time 1&#10;Example: 85, 90, 78, 92, 88">85, 90, 78, 92, 88</textarea>
                        </div>
                        
                        <div class="data-group">
                            <label>After/Time 2 Data</label>
                            <textarea class="data-input" id="paired_data2" placeholder="Enter measurements after treatment or at time 2&#10;Example: 88, 92, 82, 95, 90">88, 92, 82, 95, 90</textarea>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Significance Level (α)</label>
                        <div class="significance-levels">
                            <button class="sig-level-btn active" onclick="setSignificanceLevel(0.05, 'paired')">0.05</button>
                            <button class="sig-level-btn" onclick="setSignificanceLevel(0.01, 'paired')">0.01</button>
                            <button class="sig-level-btn" onclick="setSignificanceLevel(0.10, 'paired')">0.10</button>
                        </div>
                        <input type="hidden" id="paired_alpha" value="0.05">
                    </div>
                    
                    <div class="input-group">
                        <label>Alternative Hypothesis</label>
                        <div class="input-field">
                            <select id="paired_tail">
                                <option value="two-tailed">Two-tailed (μ₁ ≠ μ₂)</option>
                                <option value="greater">One-tailed: After > Before</option>
                                <option value="less">One-tailed: After < Before</option>
                            </select>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculatePairedTTest()">Calculate T-Test</button>
                </div>
                
                <div class="examples">
                    <h3>Example Scenarios:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setPairedExample('85,90,78,92,88', '88,92,82,95,90', 'greater')">Test Scores Improvement</button>
                        <button class="example-btn" onclick="setPairedExample('180,175,178,182,177', '175,172,175,178,174', 'less')">Weight Loss Program</button>
                        <button class="example-btn" onclick="setPairedExample('25,30,28,32,27', '22,28,25,30,24', 'less')">Response Time Reduction</button>
                        <button class="example-btn" onclick="setPairedExample('70,72,71,73,69', '72,74,73,75,71', 'greater')">Training Program Effect</button>
                    </div>
                </div>
            </div>

            <!-- Tab 4: T-Score from Data -->
            <div id="tab3" class="tab-content">
                <div class="calculation-type">Calculate T-Score from Sample Statistics</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Sample Mean (x̄)</label>
                        <div class="input-field">
                            <input type="number" id="t_score_mean" value="85" step="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Population Mean (μ)</label>
                        <div class="input-field">
                            <input type="number" id="t_score_mu" value="80" step="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Sample Standard Deviation (s)</label>
                        <div class="input-field">
                            <input type="number" id="t_score_std" value="5" step="0.1" min="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Sample Size (n)</label>
                        <div class="input-field">
                            <input type="number" id="t_score_n" value="25" step="1" min="2">
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateTScore()">Calculate T-Score</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setTScoreExample(85, 80, 5, 25)">Test Scores</button>
                        <button class="example-btn" onclick="setTScoreExample(72, 70, 3, 30)">Heights</button>
                        <button class="example-btn" onclick="setTScoreExample(50, 45, 8, 20)">Performance</button>
                        <button class="example-btn" onclick="setTScoreExample(120, 115, 10, 15)">Blood Pressure</button>
                    </div>
                </div>
            </div>

            <!-- Tab 5: P-Value from T-Score -->
            <div id="tab4" class="tab-content">
                <div class="calculation-type">Calculate P-Value from T-Score</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>T-Score</label>
                        <div class="input-field">
                            <input type="number" id="p_value_t" value="2.5" step="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Degrees of Freedom (df)</label>
                        <div class="input-field">
                            <input type="number" id="p_value_df" value="24" step="1" min="1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Alternative Hypothesis</label>
                        <div class="input-field">
                            <select id="p_value_tail">
                                <option value="two-tailed">Two-tailed</option>
                                <option value="greater">One-tailed: Greater than</option>
                                <option value="less">One-tailed: Less than</option>
                            </select>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculatePValue()">Calculate P-Value</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setPValueExample(2.5, 24, 'two-tailed')">t=2.5, df=24</button>
                        <button class="example-btn" onclick="setPValueExample(1.96, 30, 'two-tailed')">t=1.96, df=30</button>
                        <button class="example-btn" onclick="setPValueExample(3.0, 10, 'greater')">t=3.0, df=10</button>
                        <button class="example-btn" onclick="setPValueExample(-2.1, 15, 'less')">t=-2.1, df=15</button>
                    </div>
                </div>
            </div>

            <!-- Tab 6: Effect Size Calculator -->
            <div id="tab5" class="tab-content">
                <div class="calculation-type">Effect Size Calculator (Cohen's d)</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Mean 1 (x̄₁)</label>
                        <div class="input-field">
                            <input type="number" id="effect_mean1" value="85" step="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Mean 2 (x̄₂)</label>
                        <div class="input-field">
                            <input type="number" id="effect_mean2" value="80" step="0.1">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Standard Deviation</label>
                        <div class="input-field">
                            <input type="number" id="effect_std" value="5" step="0.1" min="0.1">
                            <div class="input-hint">Use pooled standard deviation for independent samples</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateEffectSize()">Calculate Effect Size</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setEffectSizeExample(85, 80, 5)">Small Effect</button>
                        <button class="example-btn" onclick="setEffectSizeExample(90, 80, 5)">Medium Effect</button>
                        <button class="example-btn" onclick="setEffectSizeExample(95, 80, 5)">Large Effect</button>
                        <button class="example-btn" onclick="setEffectSizeExample(75, 80, 5)">Negative Effect</button>
                    </div>
                </div>
            </div>

            <!-- Tab 7: Power Analysis -->
            <div id="tab6" class="tab-content">
                <div class="calculation-type">Statistical Power Analysis</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Effect Size (Cohen's d)</label>
                        <div class="input-field">
                            <input type="number" id="power_effect" value="0.5" step="0.1">
                            <div class="input-hint">Small: 0.2, Medium: 0.5, Large: 0.8</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Sample Size (n)</label>
                        <div class="input-field">
                            <input type="number" id="power_n" value="25" step="1" min="2">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Significance Level (α)</label>
                        <div class="input-field">
                            <input type="number" id="power_alpha" value="0.05" step="0.01" min="0.001" max="0.2">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Test Type</label>
                        <div class="input-field">
                            <select id="power_test_type">
                                <option value="one-tailed">One-tailed test</option>
                                <option value="two-tailed">Two-tailed test</option>
                            </select>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculatePower()">Calculate Power</button>
                </div>
                
                <div class="examples">
                    <h3>Example Scenarios:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setPowerExample(0.5, 25, 0.05, 'two-tailed')">Medium Effect</button>
                        <button class="example-btn" onclick="setPowerExample(0.8, 25, 0.05, 'two-tailed')">Large Effect</button>
                        <button class="example-btn" onclick="setPowerExample(0.3, 50, 0.05, 'two-tailed')">Small Effect, Larger N</button>
                        <button class="example-btn" onclick="setPowerExample(0.5, 25, 0.01, 'two-tailed')">Stricter Alpha</button>
                    </div>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 T-Test Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 T-Test Formulas & Statistical Concepts</h3>
            
            <div class="info-grid">
                <div class="info-card">
                    <h4>One Sample T-Test</h4>
                    <p>t = (x̄ - μ₀) / (s/√n)</p>
                    <p>Tests if sample mean differs from population mean</p>
                </div>
                
                <div class="info-card">
                    <h4>Independent Samples T-Test</h4>
                    <p>t = (x̄₁ - x̄₂) / √(s²ₚ(1/n₁ + 1/n₂))</p>
                    <p>Compares means of two independent groups</p>
                </div>
                
                <div class="info-card">
                    <h4>Paired Samples T-Test</h4>
                    <p>t = (x̄<sub>d</sub>) / (s<sub>d</sub>/√n)</p>
                    <p>Compares paired measurements</p>
                </div>
                
                <div class="info-card">
                    <h4>Cohen's d (Effect Size)</h4>
                    <p>d = (x̄₁ - x̄₂) / s</p>
                    <p>Standardized difference between means</p>
                </div>
                
                <div class="info-card">
                    <h4>Degrees of Freedom</h4>
                    <p>One sample: df = n - 1</p>
                    <p>Independent: df = n₁ + n₂ - 2</p>
                    <p>Paired: df = n - 1</p>
                </div>
                
                <div class="info-card">
                    <h4>Statistical Power</h4>
                    <p>Probability of detecting true effect</p>
                    <p>Power = 1 - β (where β is Type II error)</p>
                </div>
            </div>
            
            <div class="formula-box">
                <strong>Interpretation Guidelines:</strong>
                • <strong>p-value < 0.05</strong>: Statistically significant (reject null hypothesis)<br>
                • <strong>Cohen's d = 0.2</strong>: Small effect size<br>
                • <strong>Cohen's d = 0.5</strong>: Medium effect size<br>
                • <strong>Cohen's d = 0.8</strong>: Large effect size<br>
                • <strong>Power > 0.8</strong>: Adequate statistical power<br>
                • <strong>Degrees of Freedom</strong>: Number of independent pieces of information
            </div>
            
            <div class="t-distribution-table">
                <table>
                    <thead>
                        <tr>
                            <th>df</th>
                            <th>t₀.₀₅ (one-tailed)</th>
                            <th>t₀.₀₂₅ (two-tailed)</th>
                            <th>t₀.₀₁ (one-tailed)</th>
                            <th>t₀.₀₀₅ (two-tailed)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>5</td>
                            <td>2.015</td>
                            <td>2.571</td>
                            <td>3.365</td>
                            <td>4.032</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>1.812</td>
                            <td>2.228</td>
                            <td>2.764</td>
                            <td>3.169</td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>1.753</td>
                            <td>2.131</td>
                            <td>2.602</td>
                            <td>2.947</td>
                        </tr>
                        <tr>
                            <td>20</td>
                            <td>1.725</td>
                            <td>2.086</td>
                            <td>2.528</td>
                            <td>2.845</td>
                        </tr>
                        <tr>
                            <td>30</td>
                            <td>1.697</td>
                            <td>2.042</td>
                            <td>2.457</td>
                            <td>2.750</td>
                        </tr>
                        <tr>
                            <td>60</td>
                            <td>1.671</td>
                            <td>2.000</td>
                            <td>2.390</td>
                            <td>2.660</td>
                        </tr>
                        <tr>
                            <td>120</td>
                            <td>1.658</td>
                            <td>1.980</td>
                            <td>2.358</td>
                            <td>2.617</td>
                        </tr>
                        <tr>
                            <td>∞</td>
                            <td>1.645</td>
                            <td>1.960</td>
                            <td>2.326</td>
                            <td>2.576</td>
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
        }
        
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
            document.getElementById('result').scrollIntoView({behavior: 'smooth', block: 'nearest'});
        }
        
        // T-distribution functions
        function studentTCDF(t, df) {
            // Approximation of Student's t CDF using incomplete beta function
            if (df <= 0) return NaN;
            
            const x = (t + Math.sqrt(t * t + df)) / (2 * Math.sqrt(t * t + df));
            return incompleteBeta(x, df / 2, df / 2);
        }
        
        function incompleteBeta(x, a, b) {
            // Continued fraction approximation for incomplete beta function
            if (x < 0 || x > 1) return NaN;
            
            const EPS = 1e-10;
            const FPMIN = 1e-30;
            
            if (x === 0 || x === 1) {
                return x;
            }
            
            let bt = Math.exp(
                Math.lgamma(a + b) - Math.lgamma(a) - Math.lgamma(b) + 
                a * Math.log(x) + b * Math.log(1 - x)
            );
            
            if (x < (a + 1) / (a + b + 2)) {
                return bt * betaCF(x, a, b) / a;
            } else {
                return 1 - bt * betaCF(1 - x, b, a) / b;
            }
        }
        
        function betaCF(x, a, b) {
            const MAXIT = 100;
            const EPS = 1e-10;
            const FPMIN = 1e-30;
            
            let qab = a + b;
            let qap = a + 1;
            let qam = a - 1;
            let c = 1;
            let d = 1 - qab * x / qap;
            
            if (Math.abs(d) < FPMIN) d = FPMIN;
            d = 1 / d;
            let h = d;
            
            for (let m = 1; m <= MAXIT; m++) {
                let m2 = 2 * m;
                let aa = m * (b - m) * x / ((qam + m2) * (a + m2));
                d = 1 + aa * d;
                if (Math.abs(d) < FPMIN) d = FPMIN;
                c = 1 + aa / c;
                if (Math.abs(c) < FPMIN) c = FPMIN;
                d = 1 / d;
                h *= d * c;
                aa = -(a + m) * (qab + m) * x / ((a + m2) * (qap + m2));
                d = 1 + aa * d;
                if (Math.abs(d) < FPMIN) d = FPMIN;
                c = 1 + aa / c;
                if (Math.abs(c) < FPMIN) c = FPMIN;
                d = 1 / d;
                let del = d * c;
                h *= del;
                if (Math.abs(del - 1) < EPS) break;
            }
            
            return h;
        }
        
        // Gamma function approximation
        Math.lgamma = function(z) {
            // Lanczos approximation for log gamma
            const g = 7;
            const p = [
                0.99999999999980993, 676.5203681218851, -1259.1392167224028,
                771.32342877765313, -176.61502916214059, 12.507343278686905,
                -0.13857109526572012, 9.9843695780195716e-6, 1.5056327351493116e-7
            ];
            
            if (z < 0.5) {
                return Math.log(Math.PI) - Math.log(Math.sin(Math.PI * z)) - Math.lgamma(1 - z);
            }
            
            z -= 1;
            let x = p[0];
            for (let i = 1; i < g + 2; i++) {
                x += p[i] / (z + i);
            }
            const t = z + g + 0.5;
            
            return 0.5 * Math.log(2 * Math.PI) + (z + 0.5) * Math.log(t) - t + Math.log(x);
        };
        
        // Statistical functions
        function calculateMean(data) {
            return data.reduce((a, b) => a + b, 0) / data.length;
        }
        
        function calculateVariance(data, mean) {
            return data.reduce((a, b) => a + Math.pow(b - mean, 2), 0) / (data.length - 1);
        }
        
        function calculateStandardDeviation(data, mean) {
            return Math.sqrt(calculateVariance(data, mean));
        }
        
        function parseData(dataText) {
            return dataText.split(/[,\s]+/).map(num => parseFloat(num.trim())).filter(num => !isNaN(num));
        }
        
        // Example setters
        function setOneSampleExample(data, mu, tail) {
            document.getElementById('one_sample_data').value = data;
            document.getElementById('one_sample_mu').value = mu;
            document.getElementById('one_sample_tail').value = tail;
        }
        
        function setIndependentExample(data1, data2, tail) {
            document.getElementById('indep_data1').value = data1;
            document.getElementById('indep_data2').value = data2;
            document.getElementById('indep_tail').value = tail;
        }
        
        function setPairedExample(data1, data2, tail) {
            document.getElementById('paired_data1').value = data1;
            document.getElementById('paired_data2').value = data2;
            document.getElementById('paired_tail').value = tail;
        }
        
        function setTScoreExample(mean, mu, std, n) {
            document.getElementById('t_score_mean').value = mean;
            document.getElementById('t_score_mu').value = mu;
            document.getElementById('t_score_std').value = std;
            document.getElementById('t_score_n').value = n;
        }
        
        function setPValueExample(t, df, tail) {
            document.getElementById('p_value_t').value = t;
            document.getElementById('p_value_df').value = df;
            document.getElementById('p_value_tail').value = tail;
        }
        
        function setEffectSizeExample(mean1, mean2, std) {
            document.getElementById('effect_mean1').value = mean1;
            document.getElementById('effect_mean2').value = mean2;
            document.getElementById('effect_std').value = std;
        }
        
        function setPowerExample(effect, n, alpha, testType) {
            document.getElementById('power_effect').value = effect;
            document.getElementById('power_n').value = n;
            document.getElementById('power_alpha').value = alpha;
            document.getElementById('power_test_type').value = testType;
        }
        
        function setSignificanceLevel(alpha, type = 'one_sample') {
            document.getElementById(type + '_alpha').value = alpha;
            document.querySelectorAll('.sig-level-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }
        
        function setCustomSignificanceLevel() {
            document.getElementById('custom_alpha_container').style.display = 'block';
            document.getElementById('custom_alpha').addEventListener('input', function() {
                document.getElementById('one_sample_alpha').value = this.value;
            });
        }
        
        // Calculation functions
        function calculateOneSampleTTest() {
            const dataText = document.getElementById('one_sample_data').value;
            const mu0 = parseFloat(document.getElementById('one_sample_mu').value);
            const alpha = parseFloat(document.getElementById('one_sample_alpha').value);
            const tail = document.getElementById('one_sample_tail').value;
            
            const data = parseData(dataText);
            if (data.length < 2) {
                show('<div class="error-box">⚠️ Please enter at least 2 valid data points</div>');
                return;
            }
            
            const n = data.length;
            const mean = calculateMean(data);
            const std = calculateStandardDeviation(data, mean);
            const sem = std / Math.sqrt(n);
            const t = (mean - mu0) / sem;
            const df = n - 1;
            
            let pValue;
            if (tail === 'two-tailed') {
                pValue = 2 * (1 - studentTCDF(Math.abs(t), df));
            } else if (tail === 'greater') {
                pValue = 1 - studentTCDF(t, df);
            } else { // less
                pValue = studentTCDF(t, df);
            }
            
            // Critical value
            let criticalValue;
            if (tail === 'two-tailed') {
                criticalValue = inverseStudentT(1 - alpha/2, df);
            } else {
                criticalValue = inverseStudentT(1 - alpha, df);
            }
            
            const isSignificant = pValue < alpha;
            const cohensD = (mean - mu0) / std;
            
            displayTTestResults({
                testType: 'One Sample T-Test',
                t: t,
                df: df,
                pValue: pValue,
                alpha: alpha,
                tail: tail,
                criticalValue: criticalValue,
                isSignificant: isSignificant,
                effectSize: cohensD,
                statistics: {
                    n: n,
                    mean: mean,
                    std: std,
                    sem: sem,
                    mu0: mu0
                },
                steps: [
                    `Sample mean (x̄) = ${mean.toFixed(4)}`,
                    `Sample standard deviation (s) = ${std.toFixed(4)}`,
                    `Standard error = s/√n = ${std.toFixed(4)}/√${n} = ${sem.toFixed(4)}`,
                    `t = (x̄ - μ₀) / (s/√n) = (${mean.toFixed(4)} - ${mu0}) / ${sem.toFixed(4)} = ${t.toFixed(4)}`,
                    `Degrees of freedom = n - 1 = ${n} - 1 = ${df}`,
                    `p-value = ${pValue.toFixed(6)}`
                ]
            });
        }
        
        function calculateIndependentTTest() {
            const data1Text = document.getElementById('indep_data1').value;
            const data2Text = document.getElementById('indep_data2').value;
            const equalVariances = document.getElementById('equal_variances').value;
            const alpha = parseFloat(document.getElementById('indep_alpha').value);
            const tail = document.getElementById('indep_tail').value;
            
            const data1 = parseData(data1Text);
            const data2 = parseData(data2Text);
            
            if (data1.length < 2 || data2.length < 2) {
                show('<div class="error-box">⚠️ Please enter at least 2 valid data points for each group</div>');
                return;
            }
            
            const n1 = data1.length;
            const n2 = data2.length;
            const mean1 = calculateMean(data1);
            const mean2 = calculateMean(data2);
            const std1 = calculateStandardDeviation(data1, mean1);
            const std2 = calculateStandardDeviation(data2, mean2);
            
            let t, df;
            
            if (equalVariances === 'yes') {
                // Pooled variance t-test
                const pooledVariance = ((n1 - 1) * std1 * std1 + (n2 - 1) * std2 * std2) / (n1 + n2 - 2);
                const pooledStd = Math.sqrt(pooledVariance);
                const sem = pooledStd * Math.sqrt(1/n1 + 1/n2);
                t = (mean1 - mean2) / sem;
                df = n1 + n2 - 2;
            } else {
                // Welch's t-test
                const sem = Math.sqrt(std1*std1/n1 + std2*std2/n2);
                t = (mean1 - mean2) / sem;
                const dfNumerator = Math.pow(std1*std1/n1 + std2*std2/n2, 2);
                const dfDenominator = Math.pow(std1*std1/n1, 2)/(n1-1) + Math.pow(std2*std2/n2, 2)/(n2-1);
                df = dfNumerator / dfDenominator;
            }
            
            let pValue;
            if (tail === 'two-tailed') {
                pValue = 2 * (1 - studentTCDF(Math.abs(t), df));
            } else if (tail === 'greater') {
                pValue = 1 - studentTCDF(t, df);
            } else { // less
                pValue = studentTCDF(t, df);
            }
            
            // Critical value
            let criticalValue;
            if (tail === 'two-tailed') {
                criticalValue = inverseStudentT(1 - alpha/2, df);
            } else {
                criticalValue = inverseStudentT(1 - alpha, df);
            }
            
            const isSignificant = pValue < alpha;
            const pooledStd = Math.sqrt(((n1 - 1) * std1 * std1 + (n2 - 1) * std2 * std2) / (n1 + n2 - 2));
            const cohensD = (mean1 - mean2) / pooledStd;
            
            displayTTestResults({
                testType: 'Independent Samples T-Test',
                t: t,
                df: df,
                pValue: pValue,
                alpha: alpha,
                tail: tail,
                criticalValue: criticalValue,
                isSignificant: isSignificant,
                effectSize: cohensD,
                statistics: {
                    n1: n1,
                    n2: n2,
                    mean1: mean1,
                    mean2: mean2,
                    std1: std1,
                    std2: std2,
                    method: equalVariances === 'yes' ? 'Pooled variance' : "Welch's"
                },
                steps: [
                    `Group 1: n = ${n1}, mean = ${mean1.toFixed(4)}, std = ${std1.toFixed(4)}`,
                    `Group 2: n = ${n2}, mean = ${mean2.toFixed(4)}, std = ${std2.toFixed(4)}`,
                    `Mean difference = ${mean1.toFixed(4)} - ${mean2.toFixed(4)} = ${(mean1 - mean2).toFixed(4)}`,
                    equalVariances === 'yes' ? 
                        `Pooled variance = [(${n1}-1)×${std1.toFixed(4)}² + (${n2}-1)×${std2.toFixed(4)}²] / (${n1}+${n2}-2)` :
                        "Using Welch's correction for unequal variances",
                    `t = ${t.toFixed(4)}, df = ${df.toFixed(2)}`,
                    `p-value = ${pValue.toFixed(6)}`
                ]
            });
        }
        
        function calculatePairedTTest() {
            const data1Text = document.getElementById('paired_data1').value;
            const data2Text = document.getElementById('paired_data2').value;
            const alpha = parseFloat(document.getElementById('paired_alpha').value);
            const tail = document.getElementById('paired_tail').value;
            
            const data1 = parseData(data1Text);
            const data2 = parseData(data2Text);
            
            if (data1.length < 2 || data2.length < 2 || data1.length !== data2.length) {
                show('<div class="error-box">⚠️ Please enter equal number of paired measurements (at least 2 pairs)</div>');
                return;
            }
            
            const n = data1.length;
            const differences = data1.map((val, i) => val - data2[i]);
            const meanDiff = calculateMean(differences);
            const stdDiff = calculateStandardDeviation(differences, meanDiff);
            const semDiff = stdDiff / Math.sqrt(n);
            const t = meanDiff / semDiff;
            const df = n - 1;
            
            let pValue;
            if (tail === 'two-tailed') {
                pValue = 2 * (1 - studentTCDF(Math.abs(t), df));
            } else if (tail === 'greater') {
                pValue = 1 - studentTCDF(t, df);
            } else { // less
                pValue = studentTCDF(t, df);
            }
            
            // Critical value
            let criticalValue;
            if (tail === 'two-tailed') {
                criticalValue = inverseStudentT(1 - alpha/2, df);
            } else {
                criticalValue = inverseStudentT(1 - alpha, df);
            }
            
            const isSignificant = pValue < alpha;
            const cohensD = meanDiff / stdDiff;
            
            displayTTestResults({
                testType: 'Paired Samples T-Test',
                t: t,
                df: df,
                pValue: pValue,
                alpha: alpha,
                tail: tail,
                criticalValue: criticalValue,
                isSignificant: isSignificant,
                effectSize: cohensD,
                statistics: {
                    n: n,
                    meanDiff: meanDiff,
                    stdDiff: stdDiff,
                    semDiff: semDiff
                },
                steps: [
                    `Number of pairs: ${n}`,
                    `Mean difference = ${meanDiff.toFixed(4)}`,
                    `Standard deviation of differences = ${stdDiff.toFixed(4)}`,
                    `Standard error = ${stdDiff.toFixed(4)}/√${n} = ${semDiff.toFixed(4)}`,
                    `t = mean difference / standard error = ${meanDiff.toFixed(4)} / ${semDiff.toFixed(4)} = ${t.toFixed(4)}`,
                    `Degrees of freedom = n - 1 = ${n} - 1 = ${df}`,
                    `p-value = ${pValue.toFixed(6)}`
                ]
            });
        }
        
        function calculateTScore() {
            const mean = parseFloat(document.getElementById('t_score_mean').value);
            const mu = parseFloat(document.getElementById('t_score_mu').value);
            const std = parseFloat(document.getElementById('t_score_std').value);
            const n = parseInt(document.getElementById('t_score_n').value);
            
            if (isNaN(mean) || isNaN(mu) || isNaN(std) || isNaN(n) || std <= 0 || n < 2) {
                show('<div class="error-box">⚠️ Please enter valid values (σ > 0, n ≥ 2)</div>');
                return;
            }
            
            const sem = std / Math.sqrt(n);
            const t = (mean - mu) / sem;
            const df = n - 1;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">T-Score</div>
                    <div class="result-value">${t.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Degrees of Freedom</div>
                    <div class="result-value" style="color:#2196F3;">${df}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Standard Error</div>
                    <div class="result-value" style="color:#4CAF50;">${sem.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Standard error = s/√n = ${std}/√${n} = ${sem.toFixed(4)}</div>
                <div class="step">2. T-score = (x̄ - μ) / (s/√n) = (${mean} - ${mu}) / ${sem.toFixed(4)}</div>
                <div class="step">3. T-score = ${t.toFixed(4)}</div>
                <div class="step">4. Degrees of freedom = n - 1 = ${n} - 1 = ${df}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                A T-score of ${t.toFixed(4)} with ${df} degrees of freedom indicates how many standard errors the sample mean is from the population mean.
                ${Math.abs(t) > 2 ? 'This is a relatively large T-score, suggesting a potentially significant difference.' : 'This T-score suggests the sample mean is close to the population mean.'}
            </div>`;
            
            show(html);
        }
        
        function calculatePValue() {
            const t = parseFloat(document.getElementById('p_value_t').value);
            const df = parseFloat(document.getElementById('p_value_df').value);
            const tail = document.getElementById('p_value_tail').value;
            
            if (isNaN(t) || isNaN(df) || df < 1) {
                show('<div class="error-box">⚠️ Please enter valid values (df ≥ 1)</div>');
                return;
            }
            
            let pValue;
            if (tail === 'two-tailed') {
                pValue = 2 * (1 - studentTCDF(Math.abs(t), df));
            } else if (tail === 'greater') {
                pValue = 1 - studentTCDF(t, df);
            } else { // less
                pValue = studentTCDF(t, df);
            }
            
            // Common significance levels
            let significance = '';
            if (pValue < 0.001) significance = '*** (p < 0.001)';
            else if (pValue < 0.01) significance = '** (p < 0.01)';
            else if (pValue < 0.05) significance = '* (p < 0.05)';
            else if (pValue < 0.1) significance = '† (p < 0.1)';
            else significance = 'Not significant';
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">P-Value</div>
                    <div class="result-value">${pValue.toFixed(6)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Significance</div>
                    <div class="result-value" style="color:#2196F3;">${significance}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">T-Score</div>
                    <div class="result-value" style="color:#4CAF50;">${t.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. T-score = ${t.toFixed(4)}, Degrees of freedom = ${df}</div>
                <div class="step">2. Test type: ${tail === 'two-tailed' ? 'Two-tailed' : 'One-tailed'} test</div>
                <div class="step">3. Using T-distribution with ${df} degrees of freedom</div>
                <div class="step">4. P-value = ${pValue.toFixed(6)}</div>
            </div>`;
            
            const interpretation = pValue < 0.05 ? 
                'This result is statistically significant at the 0.05 level.' : 
                'This result is not statistically significant at the 0.05 level.';
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                ${interpretation}<br>
                The p-value represents the probability of obtaining a test statistic at least as extreme as the observed value, assuming the null hypothesis is true.
            </div>`;
            
            show(html);
        }
        
        function calculateEffectSize() {
            const mean1 = parseFloat(document.getElementById('effect_mean1').value);
            const mean2 = parseFloat(document.getElementById('effect_mean2').value);
            const std = parseFloat(document.getElementById('effect_std').value);
            
            if (isNaN(mean1) || isNaN(mean2) || isNaN(std) || std <= 0) {
                show('<div class="error-box">⚠️ Please enter valid values (σ > 0)</div>');
                return;
            }
            
            const cohensD = (mean1 - mean2) / std;
            const absD = Math.abs(cohensD);
            
            let magnitude = '';
            if (absD < 0.2) magnitude = 'Very Small';
            else if (absD < 0.5) magnitude = 'Small';
            else if (absD < 0.8) magnitude = 'Medium';
            else magnitude = 'Large';
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Cohen's d</div>
                    <div class="result-value">${cohensD.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Effect Size</div>
                    <div class="result-value" style="color:#2196F3;">${magnitude}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Standardized</div>
                    <div class="result-value" style="color:#4CAF50;">${absD.toFixed(4)} SD</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Mean difference = ${mean1} - ${mean2} = ${(mean1 - mean2).toFixed(4)}</div>
                <div class="step">2. Standard deviation = ${std}</div>
                <div class="step">3. Cohen's d = (mean₁ - mean₂) / σ = ${(mean1 - mean2).toFixed(4)} / ${std}</div>
                <div class="step">4. Cohen's d = ${cohensD.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Effect Size Interpretation (Cohen's d):</strong>
                • <strong>0.01-0.19</strong>: Very Small effect<br>
                • <strong>0.20-0.49</strong>: Small effect<br>
                • <strong>0.50-0.79</strong>: Medium effect<br>
                • <strong>0.80+</strong>: Large effect<br><br>
                <strong>This effect is ${magnitude.toLowerCase()}.</strong> ${cohensD > 0 ? 'Group 1 is higher than Group 2.' : 'Group 2 is higher than Group 1.'}
            </div>`;
            
            show(html);
        }
        
        function calculatePower() {
            const effect = parseFloat(document.getElementById('power_effect').value);
            const n = parseInt(document.getElementById('power_n').value);
            const alpha = parseFloat(document.getElementById('power_alpha').value);
            const testType = document.getElementById('power_test_type').value;
            
            if (isNaN(effect) || isNaN(n) || isNaN(alpha) || n < 2 || alpha <= 0 || alpha >= 1) {
                show('<div class="error-box">⚠️ Please enter valid values (n ≥ 2, 0 < α < 1)</div>');
                return;
            }
            
            // Simplified power calculation using non-central t-distribution approximation
            const df = n - 1;
            const noncentrality = effect * Math.sqrt(n);
            
            let criticalValue;
            if (testType === 'two-tailed') {
                criticalValue = inverseStudentT(1 - alpha/2, df);
            } else {
                criticalValue = inverseStudentT(1 - alpha, df);
            }
            
            // Approximation of power
            const zPower = noncentrality - criticalValue;
            const power = studentTCDF(zPower, df);
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Statistical Power</div>
                    <div class="result-value">${power.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Power Percentage</div>
                    <div class="result-value" style="color:#2196F3;">${(power * 100).toFixed(2)}%</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Effect Size</div>
                    <div class="result-value" style="color:#4CAF50;">${effect.toFixed(3)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Effect size (Cohen's d) = ${effect}</div>
                <div class="step">2. Sample size = ${n}</div>
                <div class="step">3. Significance level = ${alpha}</div>
                <div class="step">4. Test type: ${testType === 'two-tailed' ? 'Two-tailed' : 'One-tailed'}</div>
                <div class="step">5. Non-centrality parameter = effect × √n = ${effect} × √${n} = ${noncentrality.toFixed(4)}</div>
                <div class="step">6. Statistical power = ${power.toFixed(4)} (${(power * 100).toFixed(2)}%)</div>
            </div>`;
            
            const interpretation = power >= 0.8 ? 
                'Adequate statistical power (≥ 0.8). The study is well-powered to detect the specified effect size.' :
                'Insufficient statistical power (< 0.8). Consider increasing sample size or effect size.';
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Power Analysis Interpretation:</strong>
                ${interpretation}<br><br>
                <strong>Recommended minimum power: 0.8 (80%)</strong><br>
                This means there's an ${(power * 100).toFixed(1)}% chance of detecting a true effect of size ${effect} with ${n} participants at α = ${alpha}.
            </div>`;
            
            show(html);
        }
        
        function displayTTestResults(results) {
            const sigClass = results.isSignificant ? 'significant' : 'not-significant';
            const sigText = results.isSignificant ? 'STATISTICALLY SIGNIFICANT' : 'NOT STATISTICALLY SIGNIFICANT';
            const sigDescription = results.isSignificant ? 
                `Reject the null hypothesis (p < ${results.alpha})` : 
                `Fail to reject the null hypothesis (p ≥ ${results.alpha})`;
            
            let html = `<div class="statistical-significance ${sigClass}">
                ${sigText}<br>
                <small>${sigDescription}</small>
            </div>`;
            
            html += `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">T-Score</div>
                    <div class="result-value">${results.t.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">P-Value</div>
                    <div class="result-value" style="color:#2196F3;">${results.pValue.toFixed(6)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Degrees of Freedom</div>
                    <div class="result-value" style="color:#4CAF50;">${results.df.toFixed(2)}</div>
                </div>
            </div>`;
            
            html += `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Effect Size (Cohen's d)</div>
                    <div class="result-value">${results.effectSize.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Critical Value</div>
                    <div class="result-value" style="color:#2196F3;">${results.criticalValue.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Alpha Level</div>
                    <div class="result-value" style="color:#4CAF50;">${results.alpha}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                ${results.steps.map(step => `<div class="step">${step}</div>`).join('')}
            </div>`;
            
            // Add hypothesis test information
            html += `<div class="hypothesis-test">
                <strong>Hypothesis Test:</strong><br>
                • Null Hypothesis (H₀): ${getNullHypothesis(results.testType, results.statistics)}<br>
                • Alternative Hypothesis (H₁): ${getAlternativeHypothesis(results.testType, results.tail, results.statistics)}<br>
                • Significance Level: α = ${results.alpha}<br>
                • Decision: ${results.isSignificant ? 'Reject H₀' : 'Fail to reject H₀'}
            </div>`;
            
            // Add effect size interpretation
            const absEffect = Math.abs(results.effectSize);
            let effectMagnitude = '';
            if (absEffect < 0.2) effectMagnitude = 'Very Small';
            else if (absEffect < 0.5) effectMagnitude = 'Small';
            else if (absEffect < 0.8) effectMagnitude = 'Medium';
            else effectMagnitude = 'Large';
            
            html += `<div class="test-interpretation">
                <strong>Interpretation:</strong><br>
                • Statistical Significance: ${results.isSignificant ? 'Significant' : 'Not significant'} (p = ${results.pValue.toFixed(4)})<br>
                • Effect Size: ${effectMagnitude} (Cohen's d = ${results.effectSize.toFixed(3)})<br>
                • Practical Significance: ${getPracticalSignificance(results.effectSize)}<br>
                • Test Power: ${getPowerEstimation(results.effectSize, results.statistics.n || Math.min(results.statistics.n1, results.statistics.n2))}
            </div>`;
            
            show(html);
        }
        
        // Helper functions for hypothesis testing
        function getNullHypothesis(testType, stats) {
            switch(testType) {
                case 'One Sample T-Test':
                    return `μ = ${stats.mu0}`;
                case 'Independent Samples T-Test':
                    return `μ₁ = μ₂`;
                case 'Paired Samples T-Test':
                    return `μ_d = 0`;
                default:
                    return 'No difference';
            }
        }
        
        function getAlternativeHypothesis(testType, tail, stats) {
            switch(testType) {
                case 'One Sample T-Test':
                    if (tail === 'two-tailed') return `μ ≠ ${stats.mu0}`;
                    if (tail === 'greater') return `μ > ${stats.mu0}`;
                    return `μ < ${stats.mu0}`;
                case 'Independent Samples T-Test':
                    if (tail === 'two-tailed') return `μ₁ ≠ μ₂`;
                    if (tail === 'greater') return `μ₁ > μ₂`;
                    return `μ₁ < μ₂`;
                case 'Paired Samples T-Test':
                    if (tail === 'two-tailed') return `μ_d ≠ 0`;
                    if (tail === 'greater') return `μ_d > 0`;
                    return `μ_d < 0`;
                default:
                    return 'Difference exists';
            }
        }
        
        function getPracticalSignificance(effectSize) {
            const absEffect = Math.abs(effectSize);
            if (absEffect < 0.2) return 'Very small practical effect';
            if (absEffect < 0.5) return 'Small practical effect';
            if (absEffect < 0.8) return 'Medium practical effect';
            return 'Large practical effect';
        }
        
        function getPowerEstimation(effectSize, n) {
            const absEffect = Math.abs(effectSize);
            if (absEffect >= 0.8 && n >= 30) return 'High power';
            if (absEffect >= 0.5 && n >= 50) return 'Moderate power';
            if (absEffect >= 0.3 && n >= 100) return 'Adequate power';
            return 'Low power - consider larger sample';
        }
        
        // Inverse T-distribution approximation
        function inverseStudentT(p, df) {
            // Simple approximation for common values
            if (df >= 30) {
                // Use normal approximation for large df
                return inverseNormalCDF(p);
            }
            
            // For smaller df, use approximation
            const x = inverseNormalCDF(p);
            const g1 = (x * x * x + x) / (4 * df);
            const g2 = (5 * x * x * x * x * x + 16 * x * x * x + 3 * x) / (96 * df * df);
            const g3 = (3 * x * x * x * x * x * x * x + 19 * x * x * x * x * x + 17 * x * x * x - 15 * x) / (384 * df * df * df);
            
            return x + g1 + g2 + g3;
        }
        
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
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            switchTab(0);
        });
    </script>
</body>
</html>