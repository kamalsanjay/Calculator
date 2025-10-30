<?php
/**
 * Advanced Percentage Calculator
 * File: percentage-calculator.php
 * Description: Complete percentage calculator with multiple calculation types and step-by-step solutions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Percentage Calculator - All Calculation Types</title>
    <meta name="description" content="Calculate percentages, percentage change, markup/markdown, tips, discounts, and more with step-by-step solutions.">
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
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
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
        
        .input-field input, .input-field select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1.1rem;
            outline: none;
            transition: all 0.3s;
        }
        
        .input-field input:focus, .input-field select:focus {
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
        
        .percentage-visual {
            display: flex;
            height: 40px;
            background: #e0e0e0;
            border-radius: 20px;
            overflow: hidden;
            margin: 15px 0;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .percentage-fill {
            background: linear-gradient(90deg, #4CAF50, #45a049);
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            transition: width 0.5s ease;
        }
        
        .percentage-labels {
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
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>% Advanced Percentage Calculator</h1>
            <p>Calculate percentages, discounts, tips, markup, and more with step-by-step solutions</p>
        </header>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Basic<br>Percentage</button>
                <button class="tab-btn" onclick="switchTab(1)">Percentage<br>Change</button>
                <button class="tab-btn" onclick="switchTab(2)">Percentage<br>of Number</button>
                <button class="tab-btn" onclick="switchTab(3)">Find<br>Percentage</button>
                <button class="tab-btn" onclick="switchTab(4)">Increase/<br>Decrease</button>
                <button class="tab-btn" onclick="switchTab(5)">Discount &<br>Sale Price</button>
                <button class="tab-btn" onclick="switchTab(6)">Tip<br>Calculator</button>
                <button class="tab-btn" onclick="switchTab(7)">Markup &<br>Margin</button>
            </div>

            <!-- Tab 1: Basic Percentage -->
            <div id="tab0" class="tab-content active">
                <div class="calculation-type">What is X% of Y?</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Percentage (X%)</label>
                        <div class="input-field">
                            <input type="number" id="basic_percent" value="15" step="any" min="0">
                            <div class="input-hint">Enter the percentage value</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Number (Y)</label>
                        <div class="input-field">
                            <input type="number" id="basic_number" value="200" step="any" min="0">
                            <div class="input-hint">Enter the base number</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateBasicPercentage()">Calculate</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setBasicExample(20, 150)">20% of 150</button>
                        <button class="example-btn" onclick="setBasicExample(15, 300)">15% of 300</button>
                        <button class="example-btn" onclick="setBasicExample(7.5, 80)">7.5% of 80</button>
                        <button class="example-btn" onclick="setBasicExample(33.33, 120)">33.33% of 120</button>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Percentage Change -->
            <div id="tab1" class="tab-content">
                <div class="calculation-type">Percentage Change (From Old to New Value)</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Old Value</label>
                        <div class="input-field">
                            <input type="number" id="change_old" value="80" step="any" min="0">
                            <div class="input-hint">Original value before change</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>New Value</label>
                        <div class="input-field">
                            <input type="number" id="change_new" value="100" step="any" min="0">
                            <div class="input-hint">Value after change</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculatePercentageChange()">Calculate Change</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setChangeExample(50, 75)">50 to 75</button>
                        <button class="example-btn" onclick="setChangeExample(100, 80)">100 to 80</button>
                        <button class="example-btn" onclick="setChangeExample(200, 250)">200 to 250</button>
                        <button class="example-btn" onclick="setChangeExample(150, 120)">150 to 120</button>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Percentage of Number -->
            <div id="tab2" class="tab-content">
                <div class="calculation-type">X is what percentage of Y?</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Part (X)</label>
                        <div class="input-field">
                            <input type="number" id="part_value" value="25" step="any" min="0">
                            <div class="input-hint">The part value</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Whole (Y)</label>
                        <div class="input-field">
                            <input type="number" id="whole_value" value="200" step="any" min="0">
                            <div class="input-hint">The whole value</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculatePercentageOf()">Calculate Percentage</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setPartWholeExample(30, 150)">30 of 150</button>
                        <button class="example-btn" onclick="setPartWholeExample(75, 300)">75 of 300</button>
                        <button class="example-btn" onclick="setPartWholeExample(15, 60)">15 of 60</button>
                        <button class="example-btn" onclick="setPartWholeExample(40, 80)">40 of 80</button>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Increase/Decrease -->
            <div id="tab3" class="tab-content">
                <div class="calculation-type">Increase or Decrease a Number by Percentage</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Original Number</label>
                        <div class="input-field">
                            <input type="number" id="incdec_number" value="100" step="any" min="0">
                            <div class="input-hint">The original value</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Percentage</label>
                        <div class="input-field">
                            <input type="number" id="incdec_percent" value="20" step="any">
                            <div class="input-hint">Positive for increase, negative for decrease</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateIncreaseDecrease()">Calculate</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setIncDecExample(80, 25)">Increase 80 by 25%</button>
                        <button class="example-btn" onclick="setIncDecExample(120, -15)">Decrease 120 by 15%</button>
                        <button class="example-btn" onclick="setIncDecExample(200, 10)">Increase 200 by 10%</button>
                        <button class="example-btn" onclick="setIncDecExample(150, -20)">Decrease 150 by 20%</button>
                    </div>
                </div>
            </div>

            <!-- Tab 5: Discount & Sale Price -->
            <div id="tab4" class="tab-content">
                <div class="calculation-type">Calculate Discount and Sale Price</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Original Price ($)</label>
                        <div class="input-field">
                            <input type="number" id="discount_original" value="100" step="0.01" min="0">
                            <div class="input-hint">Price before discount</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Discount Percentage</label>
                        <div class="input-field">
                            <input type="number" id="discount_percent" value="15" step="any" min="0" max="100">
                            <div class="input-hint">Discount percentage (0-100%)</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateDiscount()">Calculate Sale Price</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setDiscountExample(80, 20)">$80 with 20% off</button>
                        <button class="example-btn" onclick="setDiscountExample(120, 15)">$120 with 15% off</button>
                        <button class="example-btn" onclick="setDiscountExample(200, 30)">$200 with 30% off</button>
                        <button class="example-btn" onclick="setDiscountExample(50, 10)">$50 with 10% off</button>
                    </div>
                </div>
            </div>

            <!-- Tab 6: Tip Calculator -->
            <div id="tab5" class="tab-content">
                <div class="calculation-type">Calculate Tip Amount</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Bill Amount ($)</label>
                        <div class="input-field">
                            <input type="number" id="tip_bill" value="75" step="0.01" min="0">
                            <div class="input-hint">Total bill amount</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Tip Percentage</label>
                        <div class="input-field">
                            <input type="number" id="tip_percent" value="15" step="any" min="0">
                            <div class="input-hint">Tip percentage (typically 15-20%)</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Number of People</label>
                        <div class="input-field">
                            <input type="number" id="tip_people" value="2" step="1" min="1">
                            <div class="input-hint">Split the bill among people</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateTip()">Calculate Tip</button>
                </div>
                
                <div class="examples">
                    <h3>Common Tip Percentages:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setTipExample(60, 15, 2)">15% on $60</button>
                        <button class="example-btn" onclick="setTipExample(80, 18, 4)">18% on $80</button>
                        <button class="example-btn" onclick="setTipExample(100, 20, 1)">20% on $100</button>
                        <button class="example-btn" onclick="setTipExample(45, 15, 3)">15% on $45</button>
                    </div>
                </div>
            </div>

            <!-- Tab 7: Markup & Margin -->
            <div id="tab6" class="tab-content">
                <div class="calculation-type">Calculate Markup and Profit Margin</div>
                
                <div class="input-section">
                    <div class="input-group">
                        <label>Cost Price ($)</label>
                        <div class="input-field">
                            <input type="number" id="markup_cost" value="50" step="0.01" min="0">
                            <div class="input-hint">Cost to produce/buy the item</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Selling Price ($)</label>
                        <div class="input-field">
                            <input type="number" id="markup_selling" value="75" step="0.01" min="0">
                            <div class="input-hint">Price you sell the item for</div>
                        </div>
                    </div>
                    
                    <button class="btn" onclick="calculateMarkup()">Calculate Markup & Margin</button>
                </div>
                
                <div class="examples">
                    <h3>Example Calculations:</h3>
                    <div class="example-buttons">
                        <button class="example-btn" onclick="setMarkupExample(40, 60)">Cost $40, Sell $60</button>
                        <button class="example-btn" onclick="setMarkupExample(25, 35)">Cost $25, Sell $35</button>
                        <button class="example-btn" onclick="setMarkupExample(80, 120)">Cost $80, Sell $120</button>
                        <button class="example-btn" onclick="setMarkupExample(15, 25)">Cost $15, Sell $25</button>
                    </div>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Calculation Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Percentage Formulas & Methods</h3>
            
            <div class="info-grid">
                <div class="info-card">
                    <h4>Basic Percentage</h4>
                    <p>X% of Y = (X/100) × Y</p>
                    <p>Used to find a portion of a whole number.</p>
                </div>
                
                <div class="info-card">
                    <h4>Percentage Change</h4>
                    <p>% Change = [(New - Old) / Old] × 100</p>
                    <p>Measures increase or decrease between two values.</p>
                </div>
                
                <div class="info-card">
                    <h4>Percentage Of</h4>
                    <p>X is what % of Y = (X/Y) × 100</p>
                    <p>Finds what percentage one number is of another.</p>
                </div>
                
                <div class="info-card">
                    <h4>Increase/Decrease</h4>
                    <p>New Value = Old × (1 ± Percentage/100)</p>
                    <p>Apply percentage increase or decrease to a value.</p>
                </div>
                
                <div class="info-card">
                    <h4>Discount</h4>
                    <p>Discount = Original × (Percentage/100)</p>
                    <p>Sale Price = Original - Discount</p>
                </div>
                
                <div class="info-card">
                    <h4>Markup & Margin</h4>
                    <p>Markup % = [(Selling - Cost)/Cost] × 100</p>
                    <p>Margin % = [(Selling - Cost)/Selling] × 100</p>
                </div>
            </div>
            
            <div class="formula-box">
                <strong>Key Percentage Concepts:</strong>
                • <strong>Percentage</strong>: A ratio expressed as a fraction of 100<br>
                • <strong>Base</strong>: The whole amount or original value<br>
                • <strong>Rate</strong>: The percentage value itself<br>
                • <strong>Percentage Point</strong>: Difference between two percentages<br>
                • <strong>Markup</strong>: Percentage increase from cost to selling price<br>
                • <strong>Margin</strong>: Percentage of selling price that is profit
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
        
        // Example setters for each tab
        function setBasicExample(percent, number) {
            document.getElementById('basic_percent').value = percent;
            document.getElementById('basic_number').value = number;
        }
        
        function setChangeExample(oldVal, newVal) {
            document.getElementById('change_old').value = oldVal;
            document.getElementById('change_new').value = newVal;
        }
        
        function setPartWholeExample(part, whole) {
            document.getElementById('part_value').value = part;
            document.getElementById('whole_value').value = whole;
        }
        
        function setIncDecExample(number, percent) {
            document.getElementById('incdec_number').value = number;
            document.getElementById('incdec_percent').value = percent;
        }
        
        function setDiscountExample(price, discount) {
            document.getElementById('discount_original').value = price;
            document.getElementById('discount_percent').value = discount;
        }
        
        function setTipExample(bill, tip, people) {
            document.getElementById('tip_bill').value = bill;
            document.getElementById('tip_percent').value = tip;
            document.getElementById('tip_people').value = people;
        }
        
        function setMarkupExample(cost, selling) {
            document.getElementById('markup_cost').value = cost;
            document.getElementById('markup_selling').value = selling;
        }
        
        // Calculation functions for each tab
        function calculateBasicPercentage() {
            const percent = parseFloat(document.getElementById('basic_percent').value);
            const number = parseFloat(document.getElementById('basic_number').value);
            
            if (isNaN(percent) || isNaN(number)) {
                alert('Please enter valid numbers');
                return;
            }
            
            const result = (percent / 100) * number;
            const decimalResult = percent * number / 100;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Result</div>
                    <div class="result-value">${result.toFixed(2)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Percentage</div>
                    <div class="result-value" style="color:#2196F3;">${percent}%</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Base Number</div>
                    <div class="result-value" style="color:#4CAF50;">${number}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Convert percentage to decimal: ${percent}% = ${percent} ÷ 100 = ${(percent/100).toFixed(4)}</div>
                <div class="step">2. Multiply by the base number: ${(percent/100).toFixed(4)} × ${number} = ${decimalResult.toFixed(4)}</div>
                <div class="step">3. Final result: ${percent}% of ${number} = ${result.toFixed(2)}</div>
            </div>`;
            
            html += `<div class="percentage-visual">
                <div class="percentage-fill" style="width: ${percent > 100 ? 100 : percent}%">${percent > 100 ? '100%' : percent + '%'}</div>
            </div>
            <div class="percentage-labels">
                <span>0%</span>
                <span>${percent > 100 ? '100%' : percent + '%'}</span>
                <span>100%</span>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula:</strong>
                Percentage of a number = (Percentage ÷ 100) × Number<br>
                ${percent}% of ${number} = (${percent} ÷ 100) × ${number} = ${result.toFixed(2)}
            </div>`;
            
            show(html);
        }
        
        function calculatePercentageChange() {
            const oldVal = parseFloat(document.getElementById('change_old').value);
            const newVal = parseFloat(document.getElementById('change_new').value);
            
            if (isNaN(oldVal) || isNaN(newVal)) {
                alert('Please enter valid numbers');
                return;
            }
            
            const change = newVal - oldVal;
            const percentChange = (change / oldVal) * 100;
            const changeType = change >= 0 ? 'increase' : 'decrease';
            const absPercentChange = Math.abs(percentChange);
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Percentage Change</div>
                    <div class="result-value" style="color:${percentChange >= 0 ? '#4CAF50' : '#F44336'};">${percentChange.toFixed(2)}%</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Absolute Change</div>
                    <div class="result-value" style="color:#2196F3;">${change.toFixed(2)}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Change Type</div>
                    <div class="result-value" style="color:#FF9800;">${changeType}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Calculate absolute change: New - Old = ${newVal} - ${oldVal} = ${change.toFixed(2)}</div>
                <div class="step">2. Divide by original value: ${change.toFixed(2)} ÷ ${oldVal} = ${(change/oldVal).toFixed(4)}</div>
                <div class="step">3. Multiply by 100: ${(change/oldVal).toFixed(4)} × 100 = ${percentChange.toFixed(2)}%</div>
                <div class="step">4. This represents a ${changeType} of ${absPercentChange.toFixed(2)}%</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula:</strong>
                Percentage Change = [(New Value - Old Value) ÷ Old Value] × 100<br>
                = [(${newVal} - ${oldVal}) ÷ ${oldVal}] × 100 = ${percentChange.toFixed(2)}%
            </div>`;
            
            show(html);
        }
        
        function calculatePercentageOf() {
            const part = parseFloat(document.getElementById('part_value').value);
            const whole = parseFloat(document.getElementById('whole_value').value);
            
            if (isNaN(part) || isNaN(whole) || whole === 0) {
                alert('Please enter valid numbers (whole cannot be zero)');
                return;
            }
            
            const percentage = (part / whole) * 100;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Percentage</div>
                    <div class="result-value">${percentage.toFixed(2)}%</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Part Value</div>
                    <div class="result-value" style="color:#2196F3;">${part}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Whole Value</div>
                    <div class="result-value" style="color:#4CAF50;">${whole}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Divide part by whole: ${part} ÷ ${whole} = ${(part/whole).toFixed(4)}</div>
                <div class="step">2. Multiply by 100: ${(part/whole).toFixed(4)} × 100 = ${percentage.toFixed(2)}%</div>
                <div class="step">3. Therefore, ${part} is ${percentage.toFixed(2)}% of ${whole}</div>
            </div>`;
            
            html += `<div class="percentage-visual">
                <div class="percentage-fill" style="width: ${percentage > 100 ? 100 : percentage}%">${percentage > 100 ? '100%' : percentage.toFixed(1) + '%'}</div>
            </div>
            <div class="percentage-labels">
                <span>0</span>
                <span>${part}</span>
                <span>${whole}</span>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula:</strong>
                Percentage = (Part ÷ Whole) × 100<br>
                = (${part} ÷ ${whole}) × 100 = ${percentage.toFixed(2)}%
            </div>`;
            
            show(html);
        }
        
        function calculateIncreaseDecrease() {
            const number = parseFloat(document.getElementById('incdec_number').value);
            const percent = parseFloat(document.getElementById('incdec_percent').value);
            
            if (isNaN(number) || isNaN(percent)) {
                alert('Please enter valid numbers');
                return;
            }
            
            const change = number * (percent / 100);
            const result = number + change;
            const operation = percent >= 0 ? 'increase' : 'decrease';
            const absPercent = Math.abs(percent);
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">New Value</div>
                    <div class="result-value">${result.toFixed(2)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Change Amount</div>
                    <div class="result-value" style="color:#2196F3;">${change.toFixed(2)}</div>
                </div>
                <div class="result-box" style="border-left-color:#FF9800;">
                    <div class="result-label">Operation</div>
                    <div class="result-value" style="color:#FF9800;">${percent >= 0 ? 'Increase' : 'Decrease'}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Calculate ${operation} amount: ${number} × (${absPercent} ÷ 100) = ${number} × ${(absPercent/100).toFixed(4)} = ${Math.abs(change).toFixed(2)}</div>
                <div class="step">2. ${percent >= 0 ? 'Add' : 'Subtract'} the change: ${number} ${percent >= 0 ? '+' : '-'} ${Math.abs(change).toFixed(2)}</div>
                <div class="step">3. Final result: ${result.toFixed(2)}</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formula:</strong>
                New Value = Original × (1 ${percent >= 0 ? '+' : '-'} |Percentage| ÷ 100)<br>
                = ${number} × (1 ${percent >= 0 ? '+' : '-'} ${(absPercent/100).toFixed(4)}) = ${result.toFixed(2)}
            </div>`;
            
            show(html);
        }
        
        function calculateDiscount() {
            const original = parseFloat(document.getElementById('discount_original').value);
            const discountPercent = parseFloat(document.getElementById('discount_percent').value);
            
            if (isNaN(original) || isNaN(discountPercent)) {
                alert('Please enter valid numbers');
                return;
            }
            
            const discountAmount = original * (discountPercent / 100);
            const salePrice = original - discountAmount;
            const savingsPercent = (discountAmount / original) * 100;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Sale Price</div>
                    <div class="result-value">$${salePrice.toFixed(2)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">You Save</div>
                    <div class="result-value" style="color:#4CAF50;">$${discountAmount.toFixed(2)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Discount</div>
                    <div class="result-value" style="color:#2196F3;">${discountPercent}%</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Calculate discount amount: $${original} × (${discountPercent} ÷ 100) = $${original} × ${(discountPercent/100).toFixed(4)} = $${discountAmount.toFixed(2)}</div>
                <div class="step">2. Subtract discount from original: $${original} - $${discountAmount.toFixed(2)} = $${salePrice.toFixed(2)}</div>
                <div class="step">3. You save $${discountAmount.toFixed(2)} (${savingsPercent.toFixed(1)}% of original price)</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formulas:</strong>
                Discount Amount = Original Price × (Discount % ÷ 100)<br>
                Sale Price = Original Price - Discount Amount<br>
                = $${original} - $${discountAmount.toFixed(2)} = $${salePrice.toFixed(2)}
            </div>`;
            
            show(html);
        }
        
        function calculateTip() {
            const bill = parseFloat(document.getElementById('tip_bill').value);
            const tipPercent = parseFloat(document.getElementById('tip_percent').value);
            const people = parseInt(document.getElementById('tip_people').value);
            
            if (isNaN(bill) || isNaN(tipPercent) || isNaN(people)) {
                alert('Please enter valid numbers');
                return;
            }
            
            const tipAmount = bill * (tipPercent / 100);
            const totalAmount = bill + tipAmount;
            const perPerson = totalAmount / people;
            const tipPerPerson = tipAmount / people;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Total Bill</div>
                    <div class="result-value">$${totalAmount.toFixed(2)}</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Tip Amount</div>
                    <div class="result-value" style="color:#4CAF50;">$${tipAmount.toFixed(2)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Per Person</div>
                    <div class="result-value" style="color:#2196F3;">$${perPerson.toFixed(2)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Calculate tip: $${bill} × (${tipPercent} ÷ 100) = $${bill} × ${(tipPercent/100).toFixed(4)} = $${tipAmount.toFixed(2)}</div>
                <div class="step">2. Add tip to bill: $${bill} + $${tipAmount.toFixed(2)} = $${totalAmount.toFixed(2)}</div>
                <div class="step">3. Split among ${people} people: $${totalAmount.toFixed(2)} ÷ ${people} = $${perPerson.toFixed(2)} per person</div>
                <div class="step">4. Each person pays $${perPerson.toFixed(2)} (including $${tipPerPerson.toFixed(2)} tip)</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formulas:</strong>
                Tip Amount = Bill × (Tip % ÷ 100)<br>
                Total Amount = Bill + Tip Amount<br>
                Amount Per Person = Total Amount ÷ Number of People<br>
                = $${totalAmount.toFixed(2)} ÷ ${people} = $${perPerson.toFixed(2)}
            </div>`;
            
            show(html);
        }
        
        function calculateMarkup() {
            const cost = parseFloat(document.getElementById('markup_cost').value);
            const selling = parseFloat(document.getElementById('markup_selling').value);
            
            if (isNaN(cost) || isNaN(selling) || cost === 0) {
                alert('Please enter valid numbers (cost cannot be zero)');
                return;
            }
            
            const profit = selling - cost;
            const markupPercent = (profit / cost) * 100;
            const marginPercent = (profit / selling) * 100;
            
            let html = `<div class="result-grid">
                <div class="result-box">
                    <div class="result-label">Markup %</div>
                    <div class="result-value">${markupPercent.toFixed(2)}%</div>
                </div>
                <div class="result-box" style="border-left-color:#4CAF50;">
                    <div class="result-label">Profit Margin %</div>
                    <div class="result-value" style="color:#4CAF50;">${marginPercent.toFixed(2)}%</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Profit Amount</div>
                    <div class="result-value" style="color:#2196F3;">$${profit.toFixed(2)}</div>
                </div>
            </div>`;
            
            html += `<div class="step-box">
                <strong>📝 Step-by-Step Calculation:</strong>
                <div class="step">1. Calculate profit: Selling - Cost = $${selling} - $${cost} = $${profit.toFixed(2)}</div>
                <div class="step">2. Markup % = (Profit ÷ Cost) × 100 = ($${profit.toFixed(2)} ÷ $${cost}) × 100 = ${markupPercent.toFixed(2)}%</div>
                <div class="step">3. Margin % = (Profit ÷ Selling) × 100 = ($${profit.toFixed(2)} ÷ $${selling}) × 100 = ${marginPercent.toFixed(2)}%</div>
                <div class="step">4. Markup is based on cost, margin is based on selling price</div>
            </div>`;
            
            html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;">
                <strong style="color:#4CAF50;">Formulas:</strong>
                Profit = Selling Price - Cost Price = $${selling} - $${cost} = $${profit.toFixed(2)}<br>
                Markup % = (Profit ÷ Cost Price) × 100 = ($${profit.toFixed(2)} ÷ $${cost}) × 100 = ${markupPercent.toFixed(2)}%<br>
                Margin % = (Profit ÷ Selling Price) × 100 = ($${profit.toFixed(2)} ÷ $${selling}) × 100 = ${marginPercent.toFixed(2)}%
            </div>`;
            
            show(html);
        }
    </script>
</body>
</html>