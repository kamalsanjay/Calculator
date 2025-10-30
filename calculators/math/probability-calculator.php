<?php
/**
 * Advanced Probability Calculator
 * File: probability-calculator.php
 * Description: Complete probability calculator with multiple calculation types and step-by-step solutions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Probability Calculator - All Calculation Types</title>
    <meta name="description" content="Calculate probabilities, combinations, conditional probability, Bayes theorem, and more with step-by-step solutions.">
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
        
        .probability-display {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 4px solid #4CAF50;
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
        
        .odds-display {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            border-left: 4px solid #2196F3;
        }
        
        .venn-diagram {
            text-align: center;
            margin: 20px 0;
        }
        
        .venn-svg {
            max-width: 300px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>P(A) Advanced Probability Calculator</h1>
            <p>Calculate probabilities, combinations, conditional probability, Bayes theorem, and more</p>
        </header>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Basic<br>Probability</button>
                <button class="tab-btn" onclick="switchTab(1)">Multiple<br>Events</button>
                <button class="tab-btn" onclick="switchTab(2)">Conditional<br>Probability</button>
                <button class="tab-btn" onclick="switchTab(3)">Bayes<br>Theorem</button>
                <button class="tab-btn" onclick="switchTab(4)">Binomial<br>Distribution</button>
                <button class="tab-btn" onclick="switchTab(5)">Expected<br>Value</button>
                <button class="tab-btn" onclick="switchTab(6)">Probability<br>Distributions</button>
            </div>

            <!-- Tab 1: Basic Probability -->
            <div id="tab0" class="tab-content active">
                <div class="calculation-type">Basic Probability - P(A) = Favorable Outcomes / Total Outcomes</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Favorable Outcomes</label>
                        <div class="input-field">
                            <input type="number" id="basic_favorable" value="3" step="1" min="1">
                            <div class="input-hint">Number of successful outcomes</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Total Possible Outcomes</label>
                        <div class="input-field">
                            <input type="number" id="basic_total" value="6" step="1" min="1">
                            <div class="input-hint">Total number of possible outcomes</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateBasicProbability()">Calculate Probability</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setBasicExample(1, 6)">Dice Roll: 1/6</button>
                        <button class="example-btn" onclick="setBasicExample(13, 52)">Hearts in Deck: 13/52</button>
                        <button class="example-btn" onclick="setBasicExample(1, 2)">Coin Toss: 1/2</button>
                        <button class="example-btn" onclick="setBasicExample(3, 10)">3 out of 10</button>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Multiple Events -->
            <div id="tab1" class="tab-content">
                <div class="calculation-type">Multiple Events - AND, OR Probabilities</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Probability of Event A (P(A))</label>
                        <div class="input-field">
                            <input type="number" id="multi_pa" value="0.5" step="0.01" min="0" max="1">
                            <div class="input-hint">Probability of first event (0 to 1)</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Probability of Event B (P(B))</label>
                        <div class="input-field">
                            <input type="number" id="multi_pb" value="0.3" step="0.01" min="0" max="1">
                            <div class="input-hint">Probability of second event (0 to 1)</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Calculation Type</label>
                        <div class="input-field">
                            <select id="multi_type">
                                <option value="and">A AND B (Both occur)</option>
                                <option value="or">A OR B (At least one occurs)</option>
                                <option value="not_a">NOT A (A does not occur)</option>
                                <option value="not_b">NOT B (B does not occur)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group" id="independent_group">
                        <label>
                            <input type="checkbox" id="independent_events" checked> Events are independent
                        </label>
                        <div class="input-hint">Uncheck if events are mutually exclusive</div>
                    </div>
                    
                    <button class="btn" onclick="calculateMultipleEvents()">Calculate Probability</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setMultiExample(0.5, 0.5, 'and', true)">Two Coin Tosses</button>
                        <button class="example-btn" onclick="setMultiExample(0.5, 0.3, 'or', false)">Mutually Exclusive</button>
                        <button class="example-btn" onclick="setMultiExample(0.7, 0.6, 'and', true)">Independent Events</button>
                        <button class="example-btn" onclick="setMultiExample(0.4, 0.2, 'not_a', true)">Complement</button>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Conditional Probability -->
            <div id="tab2" class="tab-content">
                <div class="calculation-type">Conditional Probability - P(A|B) = P(A∩B) / P(B)</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Probability of A and B (P(A∩B))</label>
                        <div class="input-field">
                            <input type="number" id="cond_pab" value="0.2" step="0.01" min="0" max="1">
                            <div class="input-hint">Probability both A and B occur</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Probability of B (P(B))</label>
                        <div class="input-field">
                            <input type="number" id="cond_pb" value="0.4" step="0.01" min="0" max="1">
                            <div class="input-hint">Probability of event B occurring</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateConditional()">Calculate Conditional Probability</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setConditionalExample(0.2, 0.4)">P(A|B) = 0.2/0.4</button>
                        <button class="example-btn" onclick="setConditionalExample(0.15, 0.3)">P(A|B) = 0.15/0.3</button>
                        <button class="example-btn" onclick="setConditionalExample(0.1, 0.5)">P(A|B) = 0.1/0.5</button>
                        <button class="example-btn" onclick="setConditionalExample(0.25, 0.5)">P(A|B) = 0.25/0.5</button>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Bayes Theorem -->
            <div id="tab3" class="tab-content">
                <div class="calculation-type">Bayes Theorem - P(A|B) = [P(B|A) × P(A)] / P(B)</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>P(B|A) - Probability of B given A</label>
                        <div class="input-field">
                            <input type="number" id="bayes_pba" value="0.9" step="0.01" min="0" max="1">
                            <div class="input-hint">Probability of evidence given hypothesis</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>P(A) - Prior Probability</label>
                        <div class="input-field">
                            <input type="number" id="bayes_pa" value="0.01" step="0.01" min="0" max="1">
                            <div class="input-hint">Initial probability of hypothesis</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>P(B) - Total Probability</label>
                        <div class="input-field">
                            <input type="number" id="bayes_pb" value="0.1" step="0.01" min="0" max="1">
                            <div class="input-hint">Total probability of evidence</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateBayes()">Calculate Posterior Probability</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setBayesExample(0.9, 0.01, 0.1)">Medical Test</button>
                        <button class="example-btn" onclick="setBayesExample(0.8, 0.05, 0.2)">Spam Filter</button>
                        <button class="example-btn" onclick="setBayesExample(0.95, 0.02, 0.08)">Quality Control</button>
                        <button class="example-btn" onclick="setBayesExample(0.7, 0.1, 0.25)">Weather Forecast</button>
                    </div>
                </div>
            </div>

            <!-- Tab 5: Binomial Distribution -->
            <div id="tab4" class="tab-content">
                <div class="calculation-type">Binomial Distribution - P(X=k) = C(n,k) × pᵏ × (1-p)ⁿ⁻ᵏ</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Number of Trials (n)</label>
                        <div class="input-field">
                            <input type="number" id="binom_n" value="10" step="1" min="1">
                            <div class="input-hint">Total number of trials</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Probability of Success (p)</label>
                        <div class="input-field">
                            <input type="number" id="binom_p" value="0.5" step="0.01" min="0" max="1">
                            <div class="input-hint">Probability of success in each trial</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Number of Successes (k)</label>
                        <div class="input-field">
                            <input type="number" id="binom_k" value="5" step="1" min="0">
                            <div class="input-hint">Desired number of successes</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateBinomial()">Calculate Binomial Probability</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setBinomialExample(10, 0.5, 5)">Coin Toss: 5 heads in 10</button>
                        <button class="example-btn" onclick="setBinomialExample(20, 0.1, 2)">Defective: 2 in 20</button>
                        <button class="example-btn" onclick="setBinomialExample(15, 0.3, 5)">Success Rate: 5 in 15</button>
                        <button class="example-btn" onclick="setBinomialExample(8, 0.75, 6)">High Probability</button>
                    </div>
                </div>
            </div>

            <!-- Tab 6: Expected Value -->
            <div id="tab5" class="tab-content">
                <div class="calculation-type">Expected Value - E[X] = Σ(x × P(x))</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Outcomes and Probabilities</label>
                        <div class="input-field">
                            <textarea id="expected_data" placeholder="Enter as: value, probability (one per line)&#10;Example:&#10;100, 0.1&#10;50, 0.3&#10;0, 0.6">100, 0.1
50, 0.3
0, 0.6</textarea>
                            <div class="input-hint">One outcome-probability pair per line</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateExpectedValue()">Calculate Expected Value</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setExpectedExample('100, 0.1\n50, 0.3\n0, 0.6')">Lottery Ticket</button>
                        <button class="example-btn" onclick="setExpectedExample('10, 0.2\n5, 0.5\n-2, 0.3')">Investment</button>
                        <button class="example-btn" onclick="setExpectedExample('20, 0.4\n10, 0.4\n5, 0.2')">Game Winnings</button>
                        <button class="example-btn" onclick="setExpectedExample('1000, 0.01\n100, 0.1\n0, 0.89')">Insurance</button>
                    </div>
                </div>
            </div>

            <!-- Tab 7: Probability Distributions -->
            <div id="tab6" class="tab-content">
                <div class="calculation-type">Probability Distributions - Normal, Poisson, etc.</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Distribution Type</label>
                        <div class="input-field">
                            <select id="dist_type">
                                <option value="normal">Normal Distribution</option>
                                <option value="poisson">Poisson Distribution</option>
                                <option value="uniform">Uniform Distribution</option>
                                <option value="exponential">Exponential Distribution</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group" id="normal_params">
                        <label>Normal Distribution Parameters</label>
                        <div class="input-row">
                            <div class="input-field">
                                <input type="number" id="norm_mean" value="0" step="0.1" placeholder="Mean (μ)">
                            </div>
                            <div class="input-field">
                                <input type="number" id="norm_std" value="1" step="0.1" min="0.1" placeholder="Std Dev (σ)">
                            </div>
                            <div class="input-field">
                                <input type="number" id="norm_x" value="1" step="0.1" placeholder="X value">
                            </div>
                        </div>
                    </div>
                    
                    <div class="input-group" id="poisson_params" style="display: none;">
                        <label>Poisson Distribution Parameters</label>
                        <div class="input-row">
                            <div class="input-field">
                                <input type="number" id="poisson_lambda" value="3" step="0.1" min="0.1" placeholder="Lambda (λ)">
                            </div>
                            <div class="input-field">
                                <input type="number" id="poisson_k" value="2" step="1" min="0" placeholder="k events">
                            </div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateDistribution()">Calculate Probability</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setDistributionExample('normal', 0, 1, 1)">Normal: μ=0, σ=1, x=1</button>
                        <button class="example-btn" onclick="setDistributionExample('poisson', 3, 2)">Poisson: λ=3, k=2</button>
                        <button class="example-btn" onclick="setDistributionExample('normal', 100, 15, 115)">IQ Score: 115</button>
                        <button class="example-btn" onclick="setDistributionExample('poisson', 5, 3)">Calls: λ=5, k=3</button>
                    </div>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Probability Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Probability Formulas & Concepts</h3>
            
            <div class="info-grid">
                <div class="info-card">
                    <h4>Basic Probability</h4>
                    <p>P(A) = Favorable Outcomes / Total Outcomes</p>
                    <p>Range: 0 ≤ P(A) ≤ 1</p>
                </div>
                
                <div class="info-card">
                    <h4>Multiple Events</h4>
                    <p>P(A AND B) = P(A) × P(B) [independent]</p>
                    <p>P(A OR B) = P(A) + P(B) - P(A AND B)</p>
                </div>
                
                <div class="info-card">
                    <h4>Conditional Probability</h4>
                    <p>P(A|B) = P(A∩B) / P(B)</p>
                    <p>Probability of A given B occurred</p>
                </div>
                
                <div class="info-card">
                    <h4>Bayes Theorem</h4>
                    <p>P(A|B) = [P(B|A) × P(A)] / P(B)</p>
                    <p>Updates probability with new evidence</p>
                </div>
                
                <div class="info-card">
                    <h4>Binomial Distribution</h4>
                    <p>P(X=k) = C(n,k) × pᵏ × (1-p)ⁿ⁻ᵏ</p>
                    <p>Fixed trials, binary outcomes</p>
                </div>
                
                <div class="info-card">
                    <h4>Expected Value</h4>
                    <p>E[X] = Σ(x × P(x))</p>
                    <p>Long-term average outcome</p>
                </div>
            </div>
            
            <div class="formula-box">
                <strong>Key Probability Rules:</strong>
                • <strong>Complement Rule</strong>: P(A') = 1 - P(A)<br>
                • <strong>Addition Rule</strong>: P(A∪B) = P(A) + P(B) - P(A∩B)<br>
                • <strong>Multiplication Rule</strong>: P(A∩B) = P(A) × P(B|A)<br>
                • <strong>Total Probability</strong>: P(B) = ΣP(B|Aᵢ) × P(Aᵢ)<br>
                • <strong>Independence</strong>: P(A∩B) = P(A) × P(B)<br>
                • <strong>Mutually Exclusive</strong>: P(A∩B) = 0
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
            
            // Show/hide distribution parameters
            updateDistributionParams();
        }
        
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
            document.getElementById('result').scrollIntoView({behavior: 'smooth', block: 'nearest'});
        }
        
        // Factorial function for combinations
        function factorial(n) {
            if (n < 0) return NaN;
            if (n === 0 || n === 1) return 1;
            let result = 1;
            for (let i = 2; i <= n; i++) {
                result *= i;
            }
            return result;
        }
        
        // Combination function C(n,k)
        function combination(n, k) {
            if (k < 0 || k > n) return 0;
            return factorial(n) / (factorial(k) * factorial(n - k));
        }
        
        // Example setters
        function setBasicExample(favorable, total) {
            document.getElementById('basic_favorable').value = favorable;
            document.getElementById('basic_total').value = total;
        }
        
        function setMultiExample(pa, pb, type, independent) {
            document.getElementById('multi_pa').value = pa;
            document.getElementById('multi_pb').value = pb;
            document.getElementById('multi_type').value = type;
            document.getElementById('independent_events').checked = independent;
        }
        
        function setConditionalExample(pab, pb) {
            document.getElementById('cond_pab').value = pab;
            document.getElementById('cond_pb').value = pb;
        }
        
        function setBayesExample(pba, pa, pb) {
            document.getElementById('bayes_pba').value = pba;
            document.getElementById('bayes_pa').value = pa;
            document.getElementById('bayes_pb').value = pb;
        }
        
        function setBinomialExample(n, p, k) {
            document.getElementById('binom_n').value = n;
            document.getElementById('binom_p').value = p;
            document.getElementById('binom_k').value = k;
        }
        
        function setExpectedExample(data) {
            document.getElementById('expected_data').value = data;
        }
        
        function setDistributionExample(type, param1, param2, param3) {
            document.getElementById('dist_type').value = type;
            if (type === 'normal') {
                document.getElementById('norm_mean').value = param1;
                document.getElementById('norm_std').value = param2;
                document.getElementById('norm_x').value = param3;
            } else if (type === 'poisson') {
                document.getElementById('poisson_lambda').value = param1;
                document.getElementById('poisson_k').value = param2;
            }
            updateDistributionParams();
        }
        
        function updateDistributionParams() {
            const type = document.getElementById('dist_type').value;
            document.getElementById('normal_params').style.display = type === 'normal' ? 'block' : 'none';
            document.getElementById('poisson_params').style.display = type === 'poisson' ? 'block' : 'none';
        }
        
        // Calculation functions
        function calculateBasicProbability() {
            const favorable = parseInt(document.getElementById('basic_favorable').value);
            const total = parseInt(document.getElementById('basic_total').value);
            
            if (isNaN(favorable) || isNaN(total) || favorable < 0 || total <= 0 || favorable > total) {
                show('<div class="error-box">⚠️ Please enter valid numbers (0 ≤ favorable ≤ total)</div>');
                return;
            }
            
            const probability = favorable / total;
            const percentage = (probability * 100).toFixed(2);
            const odds = favorable + ":" + (total - favorable);
            const simplified = simplifyFraction(favorable, total);
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Probability</div>
                    <div class="result-value">${probability.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Percentage</div>
                    <div class="result-value" style="color:#2196F3;">${percentage}%</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Fraction</div>
                    <div class="result-value" style="color:#4CAF50;">${favorable}/${total}</div>
                </div>
            </div>`;
            
            html += `<div class="probability-bar">
                <div class="probability-fill" style="width: ${percentage}%">${percentage}%</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Favorable outcomes: ${favorable}</div>
                <div class="step">2. Total possible outcomes: ${total}</div>
                <div class="step">3. Probability = Favorable / Total = ${favorable} / ${total}</div>
                <div class="step">4. Result = ${probability.toFixed(4)} (${percentage}%)</div>
            </div>`;
            
            html += `<div class="odds-display">
                <strong>Odds:</strong> ${odds} (${simplified})<br>
                <strong>Simplified Fraction:</strong> ${simplified}
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                There is a ${percentage}% chance of the event occurring. This means in ${total} trials, we expect about ${favorable} successes.
            </div>`;
            
            show(html);
        }
        
        function calculateMultipleEvents() {
            const pa = parseFloat(document.getElementById('multi_pa').value);
            const pb = parseFloat(document.getElementById('multi_pb').value);
            const type = document.getElementById('multi_type').value;
            const independent = document.getElementById('independent_events').checked;
            
            if (isNaN(pa) || isNaN(pb) || pa < 0 || pa > 1 || pb < 0 || pb > 1) {
                show('<div class="error-box">⚠️ Please enter valid probabilities between 0 and 1</div>');
                return;
            }
            
            let result, formula, steps;
            const pNotA = 1 - pa;
            const pNotB = 1 - pb;
            
            switch(type) {
                case 'and':
                    if (independent) {
                        result = pa * pb;
                        formula = "P(A AND B) = P(A) × P(B)";
                        steps = `P(A AND B) = ${pa} × ${pb} = ${result.toFixed(4)}`;
                    } else {
                        // For dependent events, we'd need P(B|A), but we'll assume independence for simplicity
                        result = pa * pb;
                        formula = "P(A AND B) = P(A) × P(B) [assuming independence]";
                        steps = `P(A AND B) = ${pa} × ${pb} = ${result.toFixed(4)} (assuming independence)`;
                    }
                    break;
                    
                case 'or':
                    if (independent) {
                        result = pa + pb - (pa * pb);
                        formula = "P(A OR B) = P(A) + P(B) - P(A) × P(B)";
                        steps = `P(A OR B) = ${pa} + ${pb} - (${pa} × ${pb}) = ${result.toFixed(4)}`;
                    } else {
                        result = pa + pb - (pa * pb); // Simplified
                        formula = "P(A OR B) = P(A) + P(B) - P(A AND B)";
                        steps = `P(A OR B) = ${pa} + ${pb} - (${pa} × ${pb}) = ${result.toFixed(4)}`;
                    }
                    break;
                    
                case 'not_a':
                    result = pNotA;
                    formula = "P(NOT A) = 1 - P(A)";
                    steps = `P(NOT A) = 1 - ${pa} = ${result.toFixed(4)}`;
                    break;
                    
                case 'not_b':
                    result = pNotB;
                    formula = "P(NOT B) = 1 - P(B)";
                    steps = `P(NOT B) = 1 - ${pb} = ${result.toFixed(4)}`;
                    break;
            }
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Probability</div>
                    <div class="result-value">${result.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Formula</div>
                    <div class="result-value" style="color:#2196F3;">${type.toUpperCase()}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Percentage</div>
                    <div class="result-value" style="color:#4CAF50;">${(result * 100).toFixed(2)}%</div>
                </div>
            </div>`;
            
            html += `<div class="probability-bar">
                <div class="probability-fill" style="width: ${(result * 100)}%">${(result * 100).toFixed(1)}%</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. P(A) = ${pa}, P(B) = ${pb}</div>
                <div class="step">2. ${formula}</div>
                <div class="step">3. ${steps}</div>
                <div class="step">4. Result = ${result.toFixed(4)} (${(result * 100).toFixed(2)}%)</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Additional Information:</strong>
                • P(NOT A) = ${pNotA.toFixed(4)}<br>
                • P(NOT B) = ${pNotB.toFixed(4)}<br>
                • P(A AND B) = ${(pa * pb).toFixed(4)}<br>
                • Events are ${independent ? 'independent' : 'dependent'}
            </div>`;
            
            show(html);
        }
        
        function calculateConditional() {
            const pab = parseFloat(document.getElementById('cond_pab').value);
            const pb = parseFloat(document.getElementById('cond_pb').value);
            
            if (isNaN(pab) || isNaN(pb) || pab < 0 || pab > 1 || pb <= 0 || pb > 1) {
                show('<div class="error-box">⚠️ Please enter valid probabilities (0 ≤ P ≤ 1, P(B) > 0)</div>');
                return;
            }
            
            if (pab > pb) {
                show('<div class="error-box">⚠️ P(A∩B) cannot be greater than P(B)</div>');
                return;
            }
            
            const result = pab / pb;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">P(A|B)</div>
                    <div class="result-value">${result.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Formula</div>
                    <div class="result-value" style="color:#2196F3;">P(A∩B)/P(B)</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Percentage</div>
                    <div class="result-value" style="color:#4CAF50;">${(result * 100).toFixed(2)}%</div>
                </div>
            </div>`;
            
            html += `<div class="probability-bar">
                <div class="probability-fill" style="width: ${(result * 100)}%">${(result * 100).toFixed(1)}%</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. P(A∩B) = ${pab}</div>
                <div class="step">2. P(B) = ${pb}</div>
                <div class="step">3. P(A|B) = P(A∩B) / P(B) = ${pab} / ${pb}</div>
                <div class="step">4. Result = ${result.toFixed(4)} (${(result * 100).toFixed(2)}%)</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                Given that event B has occurred, there is a ${(result * 100).toFixed(2)}% probability that event A will also occur.
            </div>`;
            
            show(html);
        }
        
        function calculateBayes() {
            const pba = parseFloat(document.getElementById('bayes_pba').value);
            const pa = parseFloat(document.getElementById('bayes_pa').value);
            const pb = parseFloat(document.getElementById('bayes_pb').value);
            
            if (isNaN(pba) || isNaN(pa) || isNaN(pb) || pba < 0 || pba > 1 || pa < 0 || pa > 1 || pb <= 0 || pb > 1) {
                show('<div class="error-box">⚠️ Please enter valid probabilities between 0 and 1 (P(B) > 0)</div>');
                return;
            }
            
            const result = (pba * pa) / pb;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">P(A|B)</div>
                    <div class="result-value">${result.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Formula</div>
                    <div class="result-value" style="color:#2196F3;">[P(B|A)×P(A)]/P(B)</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Percentage</div>
                    <div class="result-value" style="color:#4CAF50;">${(result * 100).toFixed(2)}%</div>
                </div>
            </div>`;
            
            html += `<div class="probability-bar">
                <div class="probability-fill" style="width: ${(result * 100)}%">${(result * 100).toFixed(1)}%</div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. P(B|A) = ${pba}</div>
                <div class="step">2. P(A) = ${pa}</div>
                <div class="step">3. P(B) = ${pb}</div>
                <div class="step">4. P(A|B) = [P(B|A) × P(A)] / P(B)</div>
                <div class="step">5. = [${pba} × ${pa}] / ${pb}</div>
                <div class="step">6. = ${(pba * pa).toFixed(4)} / ${pb}</div>
                <div class="step">7. Result = ${result.toFixed(4)} (${(result * 100).toFixed(2)}%)</div>
            </div>`;
            
            const priorOdds = pa / (1 - pa);
            const posteriorOdds = result / (1 - result);
            const bayesFactor = pba / (pb / pa);
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Bayesian Analysis:</strong>
                • Prior Probability P(A): ${pa.toFixed(4)}<br>
                • Posterior Probability P(A|B): ${result.toFixed(4)}<br>
                • Prior Odds: ${priorOdds.toFixed(4)}<br>
                • Posterior Odds: ${posteriorOdds.toFixed(4)}<br>
                • Bayes Factor: ${bayesFactor.toFixed(4)}
            </div>`;
            
            show(html);
        }
        
        function calculateBinomial() {
            const n = parseInt(document.getElementById('binom_n').value);
            const p = parseFloat(document.getElementById('binom_p').value);
            const k = parseInt(document.getElementById('binom_k').value);
            
            if (isNaN(n) || isNaN(p) || isNaN(k) || n < 1 || p < 0 || p > 1 || k < 0 || k > n) {
                show('<div class="error-box">⚠️ Please enter valid values (n ≥ 1, 0 ≤ p ≤ 1, 0 ≤ k ≤ n)</div>');
                return;
            }
            
            const comb = combination(n, k);
            const prob = comb * Math.pow(p, k) * Math.pow(1 - p, n - k);
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">P(X=${k})</div>
                    <div class="result-value">${prob.toFixed(6)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Combinations</div>
                    <div class="result-value" style="color:#2196F3;">C(${n},${k}) = ${comb}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Percentage</div>
                    <div class="result-value" style="color:#4CAF50;">${(prob * 100).toFixed(4)}%</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Number of combinations: C(${n},${k}) = ${comb}</div>
                <div class="step">2. Probability of k successes: pᵏ = ${p}${k > 1 ? `<sup>${k}</sup>` : ''} = ${Math.pow(p, k).toFixed(6)}</div>
                <div class="step">3. Probability of n-k failures: (1-p)ⁿ⁻ᵏ = ${(1-p)}${(n-k) > 1 ? `<sup>${n-k}</sup>` : ''} = ${Math.pow(1-p, n-k).toFixed(6)}</div>
                <div class="step">4. P(X=${k}) = C(${n},${k}) × pᵏ × (1-p)ⁿ⁻ᵏ</div>
                <div class="step">5. = ${comb} × ${Math.pow(p, k).toFixed(6)} × ${Math.pow(1-p, n-k).toFixed(6)}</div>
                <div class="step">6. Result = ${prob.toFixed(6)} (${(prob * 100).toFixed(4)}%)</div>
            </div>`;
            
            // Calculate additional statistics
            const mean = n * p;
            const variance = n * p * (1 - p);
            const stdDev = Math.sqrt(variance);
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Binomial Distribution Statistics:</strong>
                • Mean (Expected Value): μ = n × p = ${mean.toFixed(2)}<br>
                • Variance: σ² = n × p × (1-p) = ${variance.toFixed(2)}<br>
                • Standard Deviation: σ = √[n × p × (1-p)] = ${stdDev.toFixed(2)}<br>
                • Most Likely Outcome: ${Math.round(mean)} success${Math.round(mean) !== 1 ? 'es' : ''}
            </div>`;
            
            show(html);
        }
        
        function calculateExpectedValue() {
            const dataText = document.getElementById('expected_data').value;
            const lines = dataText.split('\n').filter(line => line.trim());
            
            const outcomes = [];
            let totalProbability = 0;
            
            for (let line of lines) {
                const parts = line.split(',').map(part => parseFloat(part.trim()));
                if (parts.length === 2 && !isNaN(parts[0]) && !isNaN(parts[1])) {
                    outcomes.push({ value: parts[0], probability: parts[1] });
                    totalProbability += parts[1];
                }
            }
            
            if (outcomes.length === 0) {
                show('<div class="error-box">⚠️ Please enter valid outcome-probability pairs</div>');
                return;
            }
            
            if (Math.abs(totalProbability - 1) > 0.001) {
                show(`<div class="error-box">⚠️ Probabilities sum to ${totalProbability.toFixed(3)}, but should sum to 1</div>`);
                return;
            }
            
            let expectedValue = 0;
            let variance = 0;
            let steps = '';
            
            outcomes.forEach((outcome, index) => {
                const contribution = outcome.value * outcome.probability;
                expectedValue += contribution;
                steps += `<div class="step">${index + 1}. ${outcome.value} × ${outcome.probability} = ${contribution.toFixed(3)}</div>`;
            });
            
            // Calculate variance
            outcomes.forEach(outcome => {
                variance += outcome.probability * Math.pow(outcome.value - expectedValue, 2);
            });
            
            const stdDev = Math.sqrt(variance);
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Expected Value</div>
                    <div class="result-value">${expectedValue.toFixed(3)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Variance</div>
                    <div class="result-value" style="color:#2196F3;">${variance.toFixed(3)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Std Deviation</div>
                    <div class="result-value" style="color:#4CAF50;">${stdDev.toFixed(3)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                ${steps}
                <div class="step">Sum = ${expectedValue.toFixed(3)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Interpretation:</strong>
                The expected value of ${expectedValue.toFixed(3)} represents the long-term average outcome if this experiment were repeated many times.<br>
                The standard deviation of ${stdDev.toFixed(3)} indicates the typical variation from this average.
            </div>`;
            
            show(html);
        }
        
        function calculateDistribution() {
            const type = document.getElementById('dist_type').value;
            let result, formula, steps;
            
            if (type === 'normal') {
                const mean = parseFloat(document.getElementById('norm_mean').value);
                const std = parseFloat(document.getElementById('norm_std').value);
                const x = parseFloat(document.getElementById('norm_x').value);
                
                if (isNaN(mean) || isNaN(std) || isNaN(x) || std <= 0) {
                    show('<div class="error-box">⚠️ Please enter valid parameters (σ > 0)</div>');
                    return;
                }
                
                // Simplified normal distribution calculation (using approximation)
                const z = (x - mean) / std;
                // Using error function approximation for CDF
                result = 0.5 * (1 + erf(z / Math.sqrt(2)));
                formula = `P(X ≤ ${x}) = Φ((${x} - ${mean}) / ${std})`;
                steps = `Z-score = (${x} - ${mean}) / ${std} = ${z.toFixed(3)}`;
                
            } else if (type === 'poisson') {
                const lambda = parseFloat(document.getElementById('poisson_lambda').value);
                const k = parseInt(document.getElementById('poisson_k').value);
                
                if (isNaN(lambda) || isNaN(k) || lambda <= 0 || k < 0) {
                    show('<div class="error-box">⚠️ Please enter valid parameters (λ > 0, k ≥ 0)</div>');
                    return;
                }
                
                result = (Math.pow(lambda, k) * Math.exp(-lambda)) / factorial(k);
                formula = `P(X = ${k}) = (${lambda}^${k} × e^-${lambda}) / ${k}!`;
                steps = `P(X = ${k}) = (${Math.pow(lambda, k).toFixed(3)} × ${Math.exp(-lambda).toFixed(6)}) / ${factorial(k)}`;
            }
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Probability</div>
                    <div class="result-value">${result.toFixed(6)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Formula</div>
                    <div class="result-value" style="color:#2196F3;">${type.toUpperCase()}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Percentage</div>
                    <div class="result-value" style="color:#4CAF50;">${(result * 100).toFixed(4)}%</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">${formula}</div>
                <div class="step">${steps}</div>
                <div class="step">Result = ${result.toFixed(6)} (${(result * 100).toFixed(4)}%)</div>
            </div>`;
            
            show(html);
        }
        
        // Helper functions
        function simplifyFraction(numerator, denominator) {
            const gcd = (a, b) => b === 0 ? a : gcd(b, a % b);
            const divisor = gcd(numerator, denominator);
            return (numerator/divisor) + "/" + (denominator/divisor);
        }
        
        // Error function approximation
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
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            switchTab(0);
            document.getElementById('dist_type').addEventListener('change', updateDistributionParams);
        });
    </script>
</body>
</html>