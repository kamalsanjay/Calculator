<?php
/**
 * Advanced Variance Calculator
 * File: variance-calculator.php
 * Description: Complete variance calculator with multiple calculation types and step-by-step solutions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Variance Calculator - All Calculation Types</title>
    <meta name="description" content="Calculate variance, standard deviation, covariance, ANOVA, and more with step-by-step solutions.">
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
        
        .variance-type-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin: 15px 0;
        }
        
        .variance-type-btn {
            padding: 12px;
            background: #e3f2fd;
            border: 1px solid #90caf9;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .variance-type-btn:hover {
            background: #bbdefb;
        }
        
        .variance-type-btn.active {
            background: #2196F3;
            color: white;
        }
        
        .distribution-chart {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .chart-container {
            max-width: 100%;
            height: 200px;
            position: relative;
            margin: 20px 0;
        }
        
        .chart-bar {
            display: inline-block;
            background: linear-gradient(to top, #4CAF50, #45a049);
            margin: 0 2px;
            vertical-align: bottom;
            position: relative;
        }
        
        .chart-label {
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
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
        
        .stat-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .stat-table th,
        .stat-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .stat-table th {
            background: #667eea;
            color: white;
            font-weight: 600;
        }
        
        .stat-table tr:hover {
            background: #f5f5f5;
        }
        
        .highlight {
            background: #fff3cd !important;
            font-weight: bold;
        }
        
        .comparison-results {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 4px solid #2196F3;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>σ² Advanced Variance Calculator</h1>
            <p>Calculate variance, standard deviation, covariance, ANOVA, and more with step-by-step solutions</p>
        </header>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Basic<br>Variance</button>
                <button class="tab-btn" onclick="switchTab(1)">Population vs<br>Sample</button>
                <button class="tab-btn" onclick="switchTab(2)">Standard<br>Deviation</button>
                <button class="tab-btn" onclick="switchTab(3)">Covariance &<br>Correlation</button>
                <button class="tab-btn" onclick="switchTab(4)">Variance of<br>Combined Data</button>
                <button class="tab-btn" onclick="switchTab(5)">ANOVA<br>Calculator</button>
                <button class="tab-btn" onclick="switchTab(6)">Variance<br>Properties</button>
            </div>

            <!-- Tab 1: Basic Variance -->
            <div id="tab0" class="tab-content active">
                <div class="calculation-type">Basic Variance Calculation</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Data Set</label>
                        <div class="input-field">
                            <textarea id="basic_data" placeholder="Enter numbers separated by commas&#10;Example: 85, 90, 78, 92, 88">85, 90, 78, 92, 88</textarea>
                            <div class="input-hint">Enter your data points separated by commas</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Variance Type</label>
                        <div class="variance-type-selector">
                            <button class="variance-type-btn active" onclick="setVarianceType('sample')">Sample Variance</button>
                            <button class="variance-type-btn" onclick="setVarianceType('population')">Population Variance</button>
                        </div>
                        <input type="hidden" id="variance_type" value="sample">
                    </div>
                    
                    <button class="btn" onclick="calculateBasicVariance()">Calculate Variance</button>
                </div>
                
                <div class="examples">
                    <h3>Example Data Sets:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setBasicExample('85,90,78,92,88')">Test Scores</button>
                        <button class="example-btn" onclick="setBasicExample('68,72,70,71,69')">Heights (in)</button>
                        <button class="example-btn" onclick="setBasicExample('25,30,28,32,27')">Response Times</button>
                        <button class="example-btn" onclick="setBasicExample('150,160,155,165,158')">Weights (lb)</button>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Population vs Sample -->
            <div id="tab1" class="tab-content">
                <div class="calculation-type">Population vs Sample Variance Comparison</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Data Set</label>
                        <div class="input-field">
                            <textarea id="compare_data" placeholder="Enter numbers separated by commas&#10;Example: 85, 90, 78, 92, 88">85, 90, 78, 92, 88</textarea>
                            <div class="input-hint">Enter your complete data set</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="compareVarianceTypes()">Compare Variance Types</button>
                </div>
                
                <div class="examples">
                    <h3>Example Comparisons:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setCompareExample('85,90,78,92,88')">Small Sample</button>
                        <button class="example-btn" onclick="setCompareExample('68,72,70,71,69,73,67,74,66,75')">Medium Sample</button>
                        <button class="example-btn" onclick="setCompareExample('25,30,28,32,27,29,31,26,33,24,34,23')">Large Sample</button>
                        <button class="example-btn" onclick="setCompareExample('10,10,10,10,10')">No Variance</button>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Standard Deviation -->
            <div id="tab2" class="tab-content">
                <div class="calculation-type">Standard Deviation Calculator</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Data Set</label>
                        <div class="input-field">
                            <textarea id="std_data" placeholder="Enter numbers separated by commas&#10;Example: 85, 90, 78, 92, 88">85, 90, 78, 92, 88</textarea>
                            <div class="input-hint">Enter your data points</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Calculation Type</label>
                        <div class="input-field">
                            <select id="std_type">
                                <option value="both">Both Sample & Population</option>
                                <option value="sample">Sample Standard Deviation</option>
                                <option value="population">Population Standard Deviation</option>
                            </select>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateStandardDeviation()">Calculate Standard Deviation</button>
                </div>
                
                <div class="examples">
                    <h3>Example Data Sets:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setStdExample('85,90,78,92,88')">Variable Data</button>
                        <button class="example-btn" onclick="setStdExample('100,100,100,100,100')">No Variation</button>
                        <button class="example-btn" onclick="setStdExample('50,60,70,80,90')">Linear Increase</button>
                        <button class="example-btn" onclick="setStdExample('10,10,10,100,100')">Bimodal</button>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Covariance & Correlation -->
            <div id="tab3" class="tab-content">
                <div class="calculation-type">Covariance and Correlation Calculator</div>
                
                <div class="input-section">
                    <div class="data-input-section">
                        <div class="data-group">
                            <label>X Values</label>
                            <textarea class="data-input" id="cov_x" placeholder="Enter X values separated by commas&#10;Example: 1, 2, 3, 4, 5">1, 2, 3, 4, 5</textarea>
                        </div>
                        
                        <div class="data-group">
                            <label>Y Values</label>
                            <textarea class="data-input" id="cov_y" placeholder="Enter Y values separated by commas&#10;Example: 2, 4, 6, 8, 10">2, 4, 6, 8, 10</textarea>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Calculation Type</label>
                        <div class="input-field">
                            <select id="cov_type">
                                <option value="both">Both Covariance & Correlation</option>
                                <option value="covariance">Covariance Only</option>
                                <option value="correlation">Correlation Only</option>
                            </select>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateCovarianceCorrelation()">Calculate Relationship</button>
                </div>
                
                <div class="examples">
                    <h3>Example Relationships:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setCovExample('1,2,3,4,5', '2,4,6,8,10')">Perfect Positive</button>
                        <button class="example-btn" onclick="setCovExample('1,2,3,4,5', '10,8,6,4,2')">Perfect Negative</button>
                        <button class="example-btn" onclick="setCovExample('1,2,3,4,5', '3,1,4,2,5')">No Correlation</button>
                        <button class="example-btn" onclick="setCovExample('1,2,3,4,5', '1,4,9,16,25')">Non-linear</button>
                    </div>
                </div>
            </div>

            <!-- Tab 5: Variance of Combined Data -->
            <div id="tab4" class="tab-content">
                <div class="calculation-type">Variance of Combined Data Sets</div>
                
                <div class="input-section">
                    <div class="data-input-section">
                        <div class="data-group">
                            <label>Data Set 1</label>
                            <textarea class="data-input" id="comb_data1" placeholder="Enter first data set&#10;Example: 85, 90, 78, 92, 88">85, 90, 78, 92, 88</textarea>
                        </div>
                        
                        <div class="data-group">
                            <label>Data Set 2</label>
                            <textarea class="data-input" id="comb_data2" placeholder="Enter second data set&#10;Example: 75, 82, 79, 85, 80">75, 82, 79, 85, 80</textarea>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Combination Type</label>
                        <div class="input-field">
                            <select id="comb_type">
                                <option value="pooled">Pooled Variance</option>
                                <option value="combined">Combined Data Set</option>
                                <option value="both">Both Methods</option>
                            </select>
                            <div class="input-hint">Pooled variance assumes equal means, combined treats as one large set</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateCombinedVariance()">Calculate Combined Variance</button>
                </div>
                
                <div class="examples">
                    <h3>Example Combinations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setCombinedExample('85,90,78,92,88', '75,82,79,85,80')">Similar Groups</button>
                        <button class="example-btn" onclick="setCombinedExample('95,98,92,96,94', '65,68,62,66,64')">Different Groups</button>
                        <button class="example-btn" onclick="setCombinedExample('100,100,100,100', '50,50,50,50')">Extreme Difference</button>
                        <button class="example-btn" onclick="setCombinedExample('10,20,30,40,50', '15,25,35,45,55')">Parallel Groups</button>
                    </div>
                </div>
            </div>

            <!-- Tab 6: ANOVA Calculator -->
            <div id="tab5" class="tab-content">
                <div class="calculation-type">ANOVA (Analysis of Variance) Calculator</div>
                
                <div class="input-section">
                    <div class="data-input-section">
                        <div class="data-group">
                            <label>Group 1 Data</label>
                            <textarea class="data-input" id="anova_data1" placeholder="Enter Group 1 data&#10;Example: 85, 90, 78, 92, 88">85, 90, 78, 92, 88</textarea>
                        </div>
                        
                        <div class="data-group">
                            <label>Group 2 Data</label>
                            <textarea class="data-input" id="anova_data2" placeholder="Enter Group 2 data&#10;Example: 75, 82, 79, 85, 80">75, 82, 79, 85, 80</textarea>
                        </div>
                        
                        <div class="data-group">
                            <label>Group 3 Data (Optional)</label>
                            <textarea class="data-input" id="anova_data3" placeholder="Enter Group 3 data&#10;Example: 95, 98, 92, 96, 94">95, 98, 92, 96, 94</textarea>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Significance Level (α)</label>
                        <div class="input-field">
                            <input type="number" id="anova_alpha" value="0.05" step="0.01" min="0.001" max="0.2">
                            <div class="input-hint">Typically 0.05 for 95% confidence</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateANOVA()">Perform ANOVA</button>
                </div>
                
                <div class="examples">
                    <h3>Example ANOVA Scenarios:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setANOVAExample('85,90,78,92,88', '75,82,79,85,80', '95,98,92,96,94')">Three Groups</button>
                        <button class="example-btn" onclick="setANOVAExample('70,72,71,73,69', '85,87,86,88,84', '65,67,66,68,64')">Distinct Groups</button>
                        <button class="example-btn" onclick="setANOVAExample('80,82,81,83,79', '81,83,82,84,80', '82,84,83,85,81')">Similar Groups</button>
                        <button class="example-btn" onclick="setANOVAExample('50,55,60,65,70', '70,75,80,85,90', '90,95,100,105,110')">Linear Progression</button>
                    </div>
                </div>
            </div>

            <!-- Tab 7: Variance Properties -->
            <div id="tab6" class="tab-content">
                <div class="calculation-type">Variance Properties and Transformations</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Original Data Set</label>
                        <div class="input-field">
                            <textarea id="prop_data" placeholder="Enter numbers separated by commas&#10;Example: 85, 90, 78, 92, 88">85, 90, 78, 92, 88</textarea>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Transformation Type</label>
                        <div class="input-field">
                            <select id="transform_type">
                                <option value="add_constant">Add Constant: X + c</option>
                                <option value="multiply_constant">Multiply by Constant: c × X</option>
                                <option value="linear">Linear Transformation: aX + b</option>
                                <option value="square">Square Transformation: X²</option>
                                <option value="all">All Transformations</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group" id="constant_inputs">
                        <label>Transformation Parameters</label>
                        <div class="input-row">
                            <div class="input-field">
                                <input type="number" id="transform_a" value="2" step="0.1" placeholder="Multiplier (a)">
                            </div>
                            <div class="input-field">
                                <input type="number" id="transform_b" value="10" step="0.1" placeholder="Constant (b)">
                            </div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateVarianceProperties()">Analyze Properties</button>
                </div>
                
                <div class="examples">
                    <h3>Example Transformations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setPropertiesExample('85,90,78,92,88', 'add_constant', 10, 0)">Add 10</button>
                        <button class="example-btn" onclick="setPropertiesExample('85,90,78,92,88', 'multiply_constant', 2, 0)">Multiply by 2</button>
                        <button class="example-btn" onclick="setPropertiesExample('85,90,78,92,88', 'linear', 2, 10)">2X + 10</button>
                        <button class="example-btn" onclick="setPropertiesExample('1,2,3,4,5', 'square', 1, 0)">Squares</button>
                    </div>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Variance Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Variance Formulas & Statistical Concepts</h3>
            
            <div class="info-grid">
                <div class="info-card">
                    <h4>Sample Variance</h4>
                    <p>s² = Σ(xᵢ - x̄)² / (n - 1)</p>
                    <p>Unbiased estimator of population variance</p>
                </div>
                
                <div class="info-card">
                    <h4>Population Variance</h4>
                    <p>σ² = Σ(xᵢ - μ)² / N</p>
                    <p>True variance of entire population</p>
                </div>
                
                <div class="info-card">
                    <h4>Standard Deviation</h4>
                    <p>s = √s² (sample)<br>σ = √σ² (population)</p>
                    <p>Square root of variance</p>
                </div>
                
                <div class="info-card">
                    <h4>Covariance</h4>
                    <p>cov(X,Y) = Σ(xᵢ - x̄)(yᵢ - ȳ) / (n-1)</p>
                    <p>Measures joint variability</p>
                </div>
                
                <div class="info-card">
                    <h4>Correlation</h4>
                    <p>r = cov(X,Y) / (sₓsᵧ)</p>
                    <p>Standardized covariance (-1 to 1)</p>
                </div>
                
                <div class="info-card">
                    <h4>Pooled Variance</h4>
                    <p>sₚ² = [(n₁-1)s₁² + (n₂-1)s₂²] / (n₁+n₂-2)</p>
                    <p>Combined variance for equal means</p>
                </div>
            </div>
            
            <div class="formula-box">
                <strong>Variance Properties:</strong>
                • <strong>Non-negative</strong>: Variance ≥ 0<br>
                • <strong>Translation Invariance</strong>: Var(X + c) = Var(X)<br>
                • <strong>Scaling</strong>: Var(cX) = c²Var(X)<br>
                • <strong>Linear Transformation</strong>: Var(aX + b) = a²Var(X)<br>
                • <strong>Additivity</strong>: Var(X + Y) = Var(X) + Var(Y) + 2Cov(X,Y)<br>
                • <strong>Independent Variables</strong>: If X and Y independent, Var(X + Y) = Var(X) + Var(Y)
            </div>
            
            <div class="stat-table">
                <table>
                    <thead>
                        <tr>
                            <th>Data Characteristic</th>
                            <th>Variance</th>
                            <th>Standard Deviation</th>
                            <th>Interpretation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>No variability</td>
                            <td>0</td>
                            <td>0</td>
                            <td>All values identical</td>
                        </tr>
                        <tr>
                            <td>Low variability</td>
                            <td>Small</td>
                            <td>Small</td>
                            <td>Values clustered near mean</td>
                        </tr>
                        <tr>
                            <td>Moderate variability</td>
                            <td>Medium</td>
                            <td>Medium</td>
                            <td>Values moderately spread</td>
                        </tr>
                        <tr>
                            <td>High variability</td>
                            <td>Large</td>
                            <td>Large</td>
                            <td>Values widely dispersed</td>
                        </tr>
                        <tr>
                            <td>Extreme variability</td>
                            <td>Very large</td>
                            <td>Very large</td>
                            <td>Values extremely spread out</td>
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
        
        // Statistical functions
        function calculateMean(data) {
            return data.reduce((a, b) => a + b, 0) / data.length;
        }
        
        function calculateVariance(data, isSample = true) {
            const mean = calculateMean(data);
            const sumSquaredDifferences = data.reduce((sum, value) => sum + Math.pow(value - mean, 2), 0);
            const divisor = isSample ? data.length - 1 : data.length;
            return sumSquaredDifferences / divisor;
        }
        
        function calculateStandardDeviation(data, isSample = true) {
            return Math.sqrt(calculateVariance(data, isSample));
        }
        
        function calculateCovariance(xData, yData, isSample = true) {
            if (xData.length !== yData.length) {
                throw new Error('X and Y datasets must have the same length');
            }
            
            const xMean = calculateMean(xData);
            const yMean = calculateMean(yData);
            let sumProduct = 0;
            
            for (let i = 0; i < xData.length; i++) {
                sumProduct += (xData[i] - xMean) * (yData[i] - yMean);
            }
            
            const divisor = isSample ? xData.length - 1 : xData.length;
            return sumProduct / divisor;
        }
        
        function calculateCorrelation(xData, yData) {
            const covariance = calculateCovariance(xData, yData, true);
            const xStd = calculateStandardDeviation(xData, true);
            const yStd = calculateStandardDeviation(yData, true);
            return covariance / (xStd * yStd);
        }
        
        function parseData(dataText) {
            return dataText.split(/[,\s]+/).map(num => parseFloat(num.trim())).filter(num => !isNaN(num));
        }
        
        // Example setters
        function setBasicExample(data) {
            document.getElementById('basic_data').value = data;
        }
        
        function setCompareExample(data) {
            document.getElementById('compare_data').value = data;
        }
        
        function setStdExample(data) {
            document.getElementById('std_data').value = data;
        }
        
        function setCovExample(xData, yData) {
            document.getElementById('cov_x').value = xData;
            document.getElementById('cov_y').value = yData;
        }
        
        function setCombinedExample(data1, data2) {
            document.getElementById('comb_data1').value = data1;
            document.getElementById('comb_data2').value = data2;
        }
        
        function setANOVAExample(data1, data2, data3 = '') {
            document.getElementById('anova_data1').value = data1;
            document.getElementById('anova_data2').value = data2;
            document.getElementById('anova_data3').value = data3;
        }
        
        function setPropertiesExample(data, type, a, b) {
            document.getElementById('prop_data').value = data;
            document.getElementById('transform_type').value = type;
            document.getElementById('transform_a').value = a;
            document.getElementById('transform_b').value = b;
        }
        
        function setVarianceType(type) {
            document.getElementById('variance_type').value = type;
            document.querySelectorAll('.variance-type-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }
        
        // Calculation functions
        function calculateBasicVariance() {
            const dataText = document.getElementById('basic_data').value;
            const isSample = document.getElementById('variance_type').value === 'sample';
            
            const data = parseData(dataText);
            if (data.length < 2) {
                show('<div class="error-box">⚠️ Please enter at least 2 valid data points</div>');
                return;
            }
            
            const mean = calculateMean(data);
            const variance = calculateVariance(data, isSample);
            const stdDev = Math.sqrt(variance);
            const n = data.length;
            
            // Calculate sum of squares and steps
            const squaredDifferences = data.map(x => Math.pow(x - mean, 2));
            const sumSquares = squaredDifferences.reduce((a, b) => a + b, 0);
            const divisor = isSample ? n - 1 : n;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">${isSample ? 'Sample' : 'Population'} Variance</div>
                    <div class="result-value">${variance.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Standard Deviation</div>
                    <div class="result-value" style="color:#2196F3;">${stdDev.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Mean</div>
                    <div class="result-value" style="color:#4CAF50;">${mean.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Calculate mean: (${data.join(' + ')}) / ${n} = ${mean.toFixed(4)}</div>
                <div class="step">2. Calculate squared differences from mean:</div>`;
            
            squaredDifferences.forEach((diff, i) => {
                html += `<div class="step">   (${data[i].toFixed(2)} - ${mean.toFixed(2)})² = ${diff.toFixed(4)}</div>`;
            });
            
            html += `<div class="step">3. Sum of squared differences: ${sumSquares.toFixed(4)}</div>
                <div class="step">4. Divide by ${isSample ? 'n-1 = ' + (n-1) : 'N = ' + n}: ${sumSquares.toFixed(4)} / ${divisor} = ${variance.toFixed(4)}</div>
                <div class="step">5. ${isSample ? 'Sample' : 'Population'} variance = ${variance.toFixed(4)}</div>
            </div>`;
            
            // Create simple distribution chart
            html += createDistributionChart(data, mean, stdDev);
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                The ${isSample ? 'sample' : 'population'} variance of ${variance.toFixed(4)} indicates 
                ${getVariabilityDescription(variance, data)}<br>
                Approximately ${calculatePercentageWithinStdDev(data, mean, stdDev, 1).toFixed(1)}% of values fall within 1 standard deviation of the mean.
            </div>`;
            
            show(html);
        }
        
        function compareVarianceTypes() {
            const dataText = document.getElementById('compare_data').value;
            const data = parseData(dataText);
            
            if (data.length < 2) {
                show('<div class="error-box">⚠️ Please enter at least 2 valid data points</div>');
                return;
            }
            
            const sampleVariance = calculateVariance(data, true);
            const populationVariance = calculateVariance(data, false);
            const sampleStd = Math.sqrt(sampleVariance);
            const populationStd = Math.sqrt(populationVariance);
            const mean = calculateMean(data);
            const n = data.length;
            
            const ratio = sampleVariance / populationVariance;
            const biasCorrection = (n - 1) / n;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Sample Variance</div>
                    <div class="result-value">${sampleVariance.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Population Variance</div>
                    <div class="result-value" style="color:#2196F3;">${populationVariance.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Ratio (s²/σ²)</div>
                    <div class="result-value" style="color:#4CAF50;">${ratio.toFixed(4)}</div>
                </div>
            </div>`;
            
            html += `<div class="comparison-results">
                <strong>Key Differences:</strong><br>
                • <strong>Sample Variance</strong> uses denominator n-1 = ${n-1} (Bessel's correction)<br>
                • <strong>Population Variance</strong> uses denominator N = ${n}<br>
                • <strong>Bias Correction Factor</strong>: (n-1)/n = ${biasCorrection.toFixed(4)}<br>
                • <strong>Relationship</strong>: s² = [n/(n-1)] × σ² = ${(n/(n-1)).toFixed(4)} × σ²
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 When to Use Each:</strong>
                <div class="step"><strong>Sample Variance (s²):</strong> Use when data represents a sample from larger population</div>
                <div class="step"><strong>Population Variance (σ²):</strong> Use when data represents entire population</div>
                <div class="step"><strong>Key Insight:</strong> Sample variance is an unbiased estimator of population variance</div>
                <div class="step"><strong>Mathematical Relationship:</strong> s² = σ² × [n/(n-1)]</div>
            </div>`;
            
            html += `<div class="formula-box">
                <strong>Standard Deviations:</strong><br>
                • Sample Standard Deviation: ${sampleStd.toFixed(4)}<br>
                • Population Standard Deviation: ${populationStd.toFixed(4)}<br>
                • Note: Sample standard deviation is <em>not</em> an unbiased estimator of population standard deviation
            </div>`;
            
            show(html);
        }
        
        function calculateStandardDeviation() {
            const dataText = document.getElementById('std_data').value;
            const calcType = document.getElementById('std_type').value;
            const data = parseData(dataText);
            
            if (data.length < 2) {
                show('<div class="error-box">⚠️ Please enter at least 2 valid data points</div>');
                return;
            }
            
            const mean = calculateMean(data);
            let results = [];
            
            if (calcType === 'both' || calcType === 'sample') {
                const sampleVar = calculateVariance(data, true);
                const sampleStd = Math.sqrt(sampleVar);
                results.push({ type: 'Sample', variance: sampleVar, std: sampleStd });
            }
            
            if (calcType === 'both' || calcType === 'population') {
                const populationVar = calculateVariance(data, false);
                const populationStd = Math.sqrt(populationVar);
                results.push({ type: 'Population', variance: populationVar, std: populationStd });
            }
            
            let html = '<div class="result-grid">';
            results.forEach(result => {
                html += `
                    <div class="result-box">
                        <div class="result-label">${result.type} Std Dev</div>
                        <div class="result-value">${result.std.toFixed(4)}</div>
                    </div>
                    <div class="result-box" style="border-left-color:#2196F3;">
                        <div class="result-label">${result.type} Variance</div>
                        <div class="result-value" style="color:#2196F3;">${result.variance.toFixed(4)}</div>
                    </div>
                `;
            });
            html += '</div>';
            
            html += `<div class="step-box">
                <strong>📝 Standard Deviation Calculation:</strong>
                <div class="step">1. Calculate variance (see previous steps)</div>
                <div class="step">2. Take square root of variance: √variance</div>`;
            
            results.forEach(result => {
                html += `<div class="step">3. ${result.type}: √${result.variance.toFixed(4)} = ${result.std.toFixed(4)}</div>`;
            });
            
            html += `</div>`;
            
            // Empirical rule demonstration
            const sampleStd = Math.sqrt(calculateVariance(data, true));
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Empirical Rule (68-95-99.7 Rule):</strong>
                For normally distributed data:<br>
                • ${calculatePercentageWithinStdDev(data, mean, sampleStd, 1).toFixed(1)}% within 1 std dev (${(mean - sampleStd).toFixed(2)} to ${(mean + sampleStd).toFixed(2)})<br>
                • ${calculatePercentageWithinStdDev(data, mean, sampleStd, 2).toFixed(1)}% within 2 std dev (${(mean - 2*sampleStd).toFixed(2)} to ${(mean + 2*sampleStd).toFixed(2)})<br>
                • ${calculatePercentageWithinStdDev(data, mean, sampleStd, 3).toFixed(1)}% within 3 std dev (${(mean - 3*sampleStd).toFixed(2)} to ${(mean + 3*sampleStd).toFixed(2)})
            </div>`;
            
            show(html);
        }
        
        function calculateCovarianceCorrelation() {
            const xText = document.getElementById('cov_x').value;
            const yText = document.getElementById('cov_y').value;
            const calcType = document.getElementById('cov_type').value;
            
            const xData = parseData(xText);
            const yData = parseData(yText);
            
            if (xData.length < 2 || yData.length < 2) {
                show('<div class="error-box">⚠️ Please enter at least 2 valid data points for each variable</div>');
                return;
            }
            
            if (xData.length !== yData.length) {
                show('<div class="error-box">⚠️ X and Y datasets must have the same number of values</div>');
                return;
            }
            
            let html = '';
            const n = xData.length;
            const xMean = calculateMean(xData);
            const yMean = calculateMean(yData);
            
            if (calcType === 'both' || calcType === 'covariance') {
                const covariance = calculateCovariance(xData, yData, true);
                html += `<div class="result-grid">
                    <div class="result-box">
                        <div class="result-label">Sample Covariance</div>
                        <div class="result-value">${covariance.toFixed(4)}</div>
                    </div>`;
                
                // Interpretation
                let covInterpretation = '';
                if (covariance > 0) covInterpretation = 'Positive relationship (X and Y tend to increase together)';
                else if (covariance < 0) covInterpretation = 'Negative relationship (X increases as Y decreases)';
                else covInterpretation = 'No linear relationship';
                
                html += `<div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Relationship</div>
                    <div class="result-value" style="color:#2196F3;">${covInterpretation}</div>
                </div></div>`;
                
                html += `<div class="step-box">
                    <strong>📝 Covariance Calculation:</strong>
                    <div class="step">1. Mean of X: ${xMean.toFixed(4)}, Mean of Y: ${yMean.toFixed(4)}</div>
                    <div class="step">2. Calculate products of deviations:</div>`;
                
                let products = [];
                for (let i = 0; i < n; i++) {
                    const product = (xData[i] - xMean) * (yData[i] - yMean);
                    products.push(product);
                    html += `<div class="step">   (${xData[i].toFixed(2)} - ${xMean.toFixed(2)}) × (${yData[i].toFixed(2)} - ${yMean.toFixed(2)}) = ${product.toFixed(4)}</div>`;
                }
                
                const sumProducts = products.reduce((a, b) => a + b, 0);
                html += `<div class="step">3. Sum of products: ${sumProducts.toFixed(4)}</div>
                    <div class="step">4. Divide by n-1: ${sumProducts.toFixed(4)} / ${n-1} = ${covariance.toFixed(4)}</div>
                </div>`;
            }
            
            if (calcType === 'both' || calcType === 'correlation') {
                const correlation = calculateCorrelation(xData, yData);
                const xStd = calculateStandardDeviation(xData, true);
                const yStd = calculateStandardDeviation(yData, true);
                
                html += `<div class="result-grid">
                    <div class="result-box">
                        <div class="result-label">Correlation (r)</div>
                        <div class="result-value">${correlation.toFixed(4)}</div>
                    </div>`;
                
                // Interpretation
                let corrInterpretation = '';
                const absCorr = Math.abs(correlation);
                if (absCorr >= 0.8) corrInterpretation = 'Very strong relationship';
                else if (absCorr >= 0.6) corrInterpretation = 'Strong relationship';
                else if (absCorr >= 0.4) corrInterpretation = 'Moderate relationship';
                else if (absCorr >= 0.2) corrInterpretation = 'Weak relationship';
                else corrInterpretation = 'Very weak or no relationship';
                
                html += `<div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Strength</div>
                    <div class="result-value" style="color:#4CAF50;">${corrInterpretation}</div>
                </div></div>`;
                
                html += `<div class="step-box">
                    <strong>📝 Correlation Calculation:</strong>
                    <div class="step">1. Covariance: ${calculateCovariance(xData, yData, true).toFixed(4)}</div>
                    <div class="step">2. Standard deviation of X: ${xStd.toFixed(4)}</div>
                    <div class="step">3. Standard deviation of Y: ${yStd.toFixed(4)}</div>
                    <div class="step">4. Correlation = covariance / (std_x × std_y)</div>
                    <div class="step">5. r = ${calculateCovariance(xData, yData, true).toFixed(4)} / (${xStd.toFixed(4)} × ${yStd.toFixed(4)}) = ${correlation.toFixed(4)}</div>
                </div>`;
            }
            
            show(html);
        }
        
        function calculateCombinedVariance() {
            const data1Text = document.getElementById('comb_data1').value;
            const data2Text = document.getElementById('comb_data2').value;
            const combType = document.getElementById('comb_type').value;
            
            const data1 = parseData(data1Text);
            const data2 = parseData(data2Text);
            
            if (data1.length < 2 || data2.length < 2) {
                show('<div class="error-box">⚠️ Please enter at least 2 valid data points for each data set</div>');
                return;
            }
            
            const n1 = data1.length;
            const n2 = data2.length;
            const mean1 = calculateMean(data1);
            const mean2 = calculateMean(data2);
            const var1 = calculateVariance(data1, true);
            const var2 = calculateVariance(data2, true);
            const std1 = Math.sqrt(var1);
            const std2 = Math.sqrt(var2);
            
            let html = '';
            
            if (combType === 'both' || combType === 'pooled') {
                // Pooled variance
                const pooledVariance = ((n1 - 1) * var1 + (n2 - 1) * var2) / (n1 + n2 - 2);
                const pooledStd = Math.sqrt(pooledVariance);
                
                html += `<div class="result-grid">
                    <div class="result-box">
                        <div class="result-label">Pooled Variance</div>
                        <div class="result-value">${pooledVariance.toFixed(4)}</div>
                    </div>
                    <div class="result-box" style="border-left-color:#2196F3;">
                        <div class="result-label">Pooled Std Dev</div>
                        <div class="result-value" style="color:#2196F3;">${pooledStd.toFixed(4)}</div>
                    </div>
                </div>`;
                
                html += `<div class="step-box">
                    <strong>📝 Pooled Variance Calculation:</strong>
                    <div class="step">Pooled variance = [(n₁-1)s₁² + (n₂-1)s₂²] / (n₁ + n₂ - 2)</div>
                    <div class="step">= [(${n1}-1)×${var1.toFixed(4)} + (${n2}-1)×${var2.toFixed(4)}] / (${n1} + ${n2} - 2)</div>
                    <div class="step">= [${((n1-1)*var1).toFixed(4)} + ${((n2-1)*var2).toFixed(4)}] / ${(n1+n2-2)}</div>
                    <div class="step">= ${pooledVariance.toFixed(4)}</div>
                </div>`;
            }
            
            if (combType === 'both' || combType === 'combined') {
                // Combined data set
                const combinedData = [...data1, ...data2];
                const combinedVar = calculateVariance(combinedData, true);
                const combinedStd = Math.sqrt(combinedVar);
                const combinedMean = calculateMean(combinedData);
                
                html += `<div class="result-grid">
                    <div class="result-box">
                        <div class="result-label">Combined Variance</div>
                        <div class="result-value">${combinedVar.toFixed(4)}</div>
                    </div>
                    <div class="result-box" style="border-left-color:#4CAF50;">
                        <div class="result-label">Combined Std Dev</div>
                        <div class="result-value" style="color:#4CAF50;">${combinedStd.toFixed(4)}</div>
                    </div>
                </div>`;
                
                html += `<div class="step-box">
                    <strong>📝 Combined Data Set Analysis:</strong>
                    <div class="step">Total observations: ${n1 + n2}</div>
                    <div class="step">Combined mean: ${combinedMean.toFixed(4)}</div>
                    <div class="step">Combined variance calculated from ${n1 + n2} data points</div>
                </div>`;
            }
            
            // Comparison
            html += `<div class="comparison-results">
                <strong>Individual Group Statistics:</strong><br>
                • <strong>Group 1</strong>: n = ${n1}, mean = ${mean1.toFixed(4)}, variance = ${var1.toFixed(4)}, std = ${std1.toFixed(4)}<br>
                • <strong>Group 2</strong>: n = ${n2}, mean = ${mean2.toFixed(4)}, variance = ${var2.toFixed(4)}, std = ${std2.toFixed(4)}<br>
                • <strong>Mean Difference</strong>: ${Math.abs(mean1 - mean2).toFixed(4)}
            </div>`;
            
            show(html);
        }
        
        function calculateANOVA() {
            const data1Text = document.getElementById('anova_data1').value;
            const data2Text = document.getElementById('anova_data2').value;
            const data3Text = document.getElementById('anova_data3').value;
            const alpha = parseFloat(document.getElementById('anova_alpha').value);
            
            const groups = [];
            if (data1Text) groups.push(parseData(data1Text));
            if (data2Text) groups.push(parseData(data2Text));
            if (data3Text) groups.push(parseData(data3Text));
            
            // Validate groups
            for (let i = 0; i < groups.length; i++) {
                if (groups[i].length < 2) {
                    show(`<div class="error-box">⚠️ Group ${i+1} must have at least 2 valid data points</div>`);
                    return;
                }
            }
            
            if (groups.length < 2) {
                show('<div class="error-box">⚠️ Please enter at least 2 groups for ANOVA</div>');
                return;
            }
            
            // Calculate ANOVA statistics
            const k = groups.length;
            const n = groups.map(g => g.length);
            const N = n.reduce((a, b) => a + b, 0);
            const means = groups.map(g => calculateMean(g));
            const variances = groups.map(g => calculateVariance(g, true));
            
            // Overall mean
            const overallMean = groups.flat().reduce((a, b) => a + b, 0) / N;
            
            // Sum of Squares
            let SSB = 0; // Between groups
            let SSW = 0; // Within groups
            
            for (let i = 0; i < k; i++) {
                SSB += n[i] * Math.pow(means[i] - overallMean, 2);
                SSW += (n[i] - 1) * variances[i];
            }
            
            const SST = SSB + SSW; // Total
            
            // Degrees of freedom
            const dfB = k - 1;
            const dfW = N - k;
            const dfT = N - 1;
            
            // Mean squares
            const MSB = SSB / dfB;
            const MSW = SSW / dfW;
            
            // F-statistic
            const F = MSB / MSW;
            
            // P-value (simplified approximation)
            const pValue = 1 - fCDF(F, dfB, dfW);
            
            // Critical value (simplified)
            const criticalValue = fCriticalValue(alpha, dfB, dfW);
            
            const isSignificant = pValue < alpha;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">F-Statistic</div>
                    <div class="result-value">${F.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">P-Value</div>
                    <div class="result-value" style="color:#2196F3;">${pValue.toFixed(6)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Significant</div>
                    <div class="result-value" style="color:#4CAF50;">${isSignificant ? 'Yes' : 'No'}</div>
                </div>
            </div>`;
            
            // ANOVA table
            html += `<div class="stat-table">
                <table>
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>SS</th>
                            <th>df</th>
                            <th>MS</th>
                            <th>F</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Between Groups</td>
                            <td>${SSB.toFixed(4)}</td>
                            <td>${dfB}</td>
                            <td>${MSB.toFixed(4)}</td>
                            <td>${F.toFixed(4)}</td>
                        </tr>
                        <tr>
                            <td>Within Groups</td>
                            <td>${SSW.toFixed(4)}</td>
                            <td>${dfW}</td>
                            <td>${MSW.toFixed(4)}</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>${SST.toFixed(4)}</td>
                            <td>${dfT}</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 ANOVA Calculation Steps:</strong>
                <div class="step">1. Overall mean: ${overallMean.toFixed(4)}</div>
                <div class="step">2. Between-group sum of squares (SSB): ${SSB.toFixed(4)}</div>
                <div class="step">3. Within-group sum of squares (SSW): ${SSW.toFixed(4)}</div>
                <div class="step">4. Mean square between (MSB): SSB/dfB = ${SSB.toFixed(4)}/${dfB} = ${MSB.toFixed(4)}</div>
                <div class="step">5. Mean square within (MSW): SSW/dfW = ${SSW.toFixed(4)}/${dfW} = ${MSW.toFixed(4)}</div>
                <div class="step">6. F-statistic: MSB/MSW = ${MSB.toFixed(4)}/${MSW.toFixed(4)} = ${F.toFixed(4)}</div>
            </div>`;
            
            html += `<div class="${isSignificant ? 'significant' : 'not-significant'}" style="padding: 15px; border-radius: 8px; margin: 15px 0; text-align: center; font-weight: bold;">
                ${isSignificant ? 'STATISTICALLY SIGNIFICANT' : 'NOT STATISTICALLY SIGNIFICANT'}<br>
                <small>${isSignificant ? 'Reject null hypothesis: Group means are significantly different' : 'Fail to reject null hypothesis: No significant difference between group means'}</small>
            </div>`;
            
            show(html);
        }
        
        function calculateVarianceProperties() {
            const dataText = document.getElementById('prop_data').value;
            const transformType = document.getElementById('transform_type').value;
            const a = parseFloat(document.getElementById('transform_a').value);
            const b = parseFloat(document.getElementById('transform_b').value);
            
            const originalData = parseData(dataText);
            if (originalData.length < 2) {
                show('<div class="error-box">⚠️ Please enter at least 2 valid data points</div>');
                return;
            }
            
            const originalMean = calculateMean(originalData);
            const originalVar = calculateVariance(originalData, true);
            const originalStd = Math.sqrt(originalVar);
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Original Variance</div>
                    <div class="result-value">${originalVar.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Original Std Dev</div>
                    <div class="result-value" style="color:#2196F3;">${originalStd.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Original Mean</div>
                    <div class="result-value" style="color:#4CAF50;">${originalMean.toFixed(4)}</div>
                </div>
            </div>`;
            
            let transformations = [];
            
            if (transformType === 'all' || transformType === 'add_constant') {
                const transformedData = originalData.map(x => x + b);
                const newVar = calculateVariance(transformedData, true);
                transformations.push({
                    type: `Add Constant (X + ${b})`,
                    expectedVar: originalVar,
                    actualVar: newVar,
                    property: 'Var(X + c) = Var(X)',
                    verified: Math.abs(newVar - originalVar) < 0.001
                });
            }
            
            if (transformType === 'all' || transformType === 'multiply_constant') {
                const transformedData = originalData.map(x => a * x);
                const newVar = calculateVariance(transformedData, true);
                const expectedVar = a * a * originalVar;
                transformations.push({
                    type: `Multiply by Constant (${a} × X)`,
                    expectedVar: expectedVar,
                    actualVar: newVar,
                    property: `Var(${a}X) = ${a}²Var(X) = ${expectedVar.toFixed(4)}`,
                    verified: Math.abs(newVar - expectedVar) < 0.001
                });
            }
            
            if (transformType === 'all' || transformType === 'linear') {
                const transformedData = originalData.map(x => a * x + b);
                const newVar = calculateVariance(transformedData, true);
                const expectedVar = a * a * originalVar;
                transformations.push({
                    type: `Linear (${a}X + ${b})`,
                    expectedVar: expectedVar,
                    actualVar: newVar,
                    property: `Var(${a}X + ${b}) = ${a}²Var(X) = ${expectedVar.toFixed(4)}`,
                    verified: Math.abs(newVar - expectedVar) < 0.001
                });
            }
            
            if (transformType === 'all' || transformType === 'square') {
                const transformedData = originalData.map(x => x * x);
                const newVar = calculateVariance(transformedData, true);
                // For squares, we can't easily predict the variance
                transformations.push({
                    type: 'Square (X²)',
                    expectedVar: 'Not predictable',
                    actualVar: newVar,
                    property: 'Var(X²) depends on distribution',
                    verified: null
                });
            }
            
            html += `<div class="stat-table">
                <table>
                    <thead>
                        <tr>
                            <th>Transformation</th>
                            <th>Expected Variance</th>
                            <th>Actual Variance</th>
                            <th>Property Verified</th>
                        </tr>
                    </thead>
                    <tbody>`;
            
            transformations.forEach(trans => {
                html += `<tr>
                    <td>${trans.type}</td>
                    <td>${typeof trans.expectedVar === 'number' ? trans.expectedVar.toFixed(4) : trans.expectedVar}</td>
                    <td>${trans.actualVar.toFixed(4)}</td>
                    <td>${trans.verified === null ? 'N/A' : (trans.verified ? '✓ Yes' : '✗ No')}</td>
                </tr>`;
            });
            
            html += `</tbody></table></div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Variance Properties Demonstrated:</strong>
                • <strong>Translation Invariance</strong>: Var(X + c) = Var(X) - Adding constant doesn't change variance<br>
                • <strong>Scaling Property</strong>: Var(cX) = c²Var(X) - Multiplying by constant scales variance by c²<br>
                • <strong>Linear Transformation</strong>: Var(aX + b) = a²Var(X) - Combination of scaling and translation<br>
                • <strong>Non-linear Transformations</strong>: Variance changes unpredictably (e.g., X²)
            </div>`;
            
            show(html);
        }
        
        // Helper functions
        function createDistributionChart(data, mean, stdDev) {
            if (data.length === 0) return '';
            
            const min = Math.min(...data);
            const max = Math.max(...data);
            const range = max - min;
            const binCount = Math.min(10, Math.ceil(Math.sqrt(data.length)));
            const binSize = range / binCount;
            
            // Create bins
            const bins = Array(binCount).fill(0);
            data.forEach(value => {
                const binIndex = Math.min(binCount - 1, Math.floor((value - min) / binSize));
                bins[binIndex]++;
            });
            
            const maxFrequency = Math.max(...bins);
            const chartHeight = 150;
            
            let chartHTML = `<div class="distribution-chart">
                <strong>Data Distribution:</strong>
                <div class="chart-container">`;
            
            bins.forEach((frequency, i) => {
                const binStart = min + i * binSize;
                const binEnd = binStart + binSize;
                const height = (frequency / maxFrequency) * chartHeight;
                const label = `${binStart.toFixed(1)}-${binEnd.toFixed(1)}`;
                
                chartHTML += `
                    <div class="chart-bar" style="width: ${90/binCount}%; height: ${height}px;" title="${label}: ${frequency} values">
                        <div class="chart-label">${label}</div>
                    </div>
                `;
            });
            
            chartHTML += `</div>
                <div style="margin-top: 30px; font-size: 0.9rem; color: #666;">
                    Mean: ${mean.toFixed(2)} | Std Dev: ${stdDev.toFixed(2)} | Range: ${min.toFixed(1)} to ${max.toFixed(1)}
                </div>
            </div>`;
            
            return chartHTML;
        }
        
        function getVariabilityDescription(variance, data) {
            const range = Math.max(...data) - Math.min(...data);
            const cv = (Math.sqrt(variance) / calculateMean(data)) * 100; // Coefficient of variation
            
            if (variance === 0) return 'no variability (all values are identical)';
            if (cv < 10) return 'very low variability';
            if (cv < 25) return 'low variability';
            if (cv < 50) return 'moderate variability';
            if (cv < 100) return 'high variability';
            return 'very high variability';
        }
        
        function calculatePercentageWithinStdDev(data, mean, stdDev, numStdDev) {
            const lower = mean - numStdDev * stdDev;
            const upper = mean + numStdDev * stdDev;
            const withinRange = data.filter(x => x >= lower && x <= upper).length;
            return (withinRange / data.length) * 100;
        }
        
        // Simplified F-distribution functions for ANOVA
        function fCDF(F, df1, df2) {
            // Simplified approximation of F-distribution CDF
            if (F <= 0) return 0;
            if (df2 > 100) {
                // For large df2, approximate with chi-square
                const chiSquare = F * df1;
                return chiSquareCDF(chiSquare, df1);
            }
            // Simple approximation
            const x = df1 * F / (df1 * F + df2);
            return incompleteBeta(x, df1/2, df2/2);
        }
        
        function fCriticalValue(alpha, df1, df2) {
            // Simplified critical value approximation
            if (df1 === 1 && df2 >= 1) {
                const t = studentTCriticalValue(alpha/2, df2);
                return t * t;
            }
            // Simple approximation for common cases
            if (df1 === 2 && df2 >= 1) {
                return 3 + (10 - 3) * (1 - alpha/0.05);
            }
            return 4.0; // Conservative estimate
        }
        
        function studentTCriticalValue(alpha, df) {
            // Simplified t-critical values
            const commonValues = {
                1: 12.71, 2: 4.303, 3: 3.182, 4: 2.776, 5: 2.571,
                10: 2.228, 20: 2.086, 30: 2.042, 60: 2.000, 120: 1.980
            };
            
            if (df in commonValues) return commonValues[df];
            if (df >= 1000) return 1.96;
            
            // Linear interpolation for other values
            const keys = Object.keys(commonValues).map(Number).sort((a, b) => a - b);
            for (let i = 0; i < keys.length - 1; i++) {
                if (df >= keys[i] && df <= keys[i+1]) {
                    const t1 = commonValues[keys[i]];
                    const t2 = commonValues[keys[i+1]];
                    return t1 + (t2 - t1) * (df - keys[i]) / (keys[i+1] - keys[i]);
                }
            }
            
            return 2.0; // Default
        }
        
        function chiSquareCDF(x, df) {
            // Simplified chi-square CDF approximation
            if (x <= 0) return 0;
            const z = (Math.pow(x/df, 1/3) - (1 - 2/(9*df))) / Math.sqrt(2/(9*df));
            return normalCDF(z);
        }
        
        function normalCDF(z) {
            // Approximation of standard normal CDF
            return 0.5 * (1 + erf(z / Math.sqrt(2)));
        }
        
        function erf(x) {
            // Error function approximation
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
        
        function incompleteBeta(x, a, b) {
            // Continued fraction approximation for incomplete beta function
            const EPS = 1e-10;
            const FPMIN = 1e-30;
            
            if (x < 0 || x > 1) return NaN;
            if (x === 0 || x === 1) return x;
            
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
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            switchTab(0);
        });
    </script>
</body>
</html>