<?php
/**
 * Cholesterol Calculator
 * File: cholesterol-calculator.php
 * Description: Calculate cholesterol ratios and assess cardiovascular risk
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cholesterol Calculator - Lipid Panel & Heart Health Risk Assessment</title>
    <meta name="description" content="Free cholesterol calculator. Calculate total cholesterol, LDL, HDL ratios, and cardiovascular risk. Understand your lipid panel results and heart health.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>❤️ Cholesterol Calculator</h1>
        <p>Assess cholesterol levels & heart health</p>
    </header>
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
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
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
        
        .result-card .category {
            font-size: 1.3em;
            margin-top: 10px;
            opacity: 0.95;
        }
        
        .underweight {
            background: linear-gradient(135deg, #42a5f5 0%, #1976d2 100%);
        }
        
        .normal {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .overweight {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
        }
        
        .obese {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
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
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Lipid Panel Information</h2>
                <form id="cholesterolForm">
                    <div class="form-group">
                        <label for="unit">Unit System</label>
                        <select id="unit">
                            <option value="mgdl">mg/dL (US standard)</option>
                            <option value="mmol">mmol/L (International)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Cholesterol Levels</h3>
                    
                    <div class="form-group">
                        <label for="totalCholesterol">Total Cholesterol (<span id="totalUnit">mg/dL</span>)</label>
                        <input type="number" id="totalCholesterol" value="200" min="100" max="400" step="1" required>
                        <small>Normal: &lt;200 mg/dL</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="hdl">HDL (Good Cholesterol) (<span id="hdlUnit">mg/dL</span>)</label>
                        <input type="number" id="hdl" value="50" min="20" max="100" step="1" required>
                        <small>Higher is better: &gt;60 mg/dL</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="ldl">LDL (Bad Cholesterol) (<span id="ldlUnit">mg/dL</span>)</label>
                        <input type="number" id="ldl" value="130" min="40" max="300" step="1" required>
                        <small>Lower is better: &lt;100 mg/dL</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="triglycerides">Triglycerides (<span id="trigUnit">mg/dL</span>)</label>
                        <input type="number" id="triglycerides" value="150" min="30" max="500" step="1" required>
                        <small>Normal: &lt;150 mg/dL</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Additional Information</h3>
                    
                    <div class="form-group">
                        <label for="age">Age (years)</label>
                        <input type="number" id="age" value="45" min="18" max="100" step="1">
                    </div>
                    
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Analyze Cholesterol</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Cholesterol Analysis</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Overall Risk</h3>
                    <div class="amount" id="riskLevel">Moderate Risk</div>
                    <div style="margin-top: 10px; font-size: 1.3em;" id="riskCategory">Borderline High</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Cholesterol</h4>
                        <div class="value" id="totalDisplay">200</div>
                    </div>
                    <div class="metric-card">
                        <h4>LDL (Bad)</h4>
                        <div class="value" id="ldlDisplay">130</div>
                    </div>
                    <div class="metric-card">
                        <h4>HDL (Good)</h4>
                        <div class="value" id="hdlDisplay">50</div>
                    </div>
                    <div class="metric-card">
                        <h4>Triglycerides</h4>
                        <div class="value" id="trigDisplay">150</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Lipid Panel</h3>
                    <div class="breakdown-item">
                        <span>Total Cholesterol</span>
                        <strong id="totalCalc" style="color: #667eea;">200 mg/dL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>LDL (Bad Cholesterol)</span>
                        <strong id="ldlCalc">130 mg/dL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>HDL (Good Cholesterol)</span>
                        <strong id="hdlCalc">50 mg/dL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Triglycerides</span>
                        <strong id="trigCalc">150 mg/dL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>VLDL (Calculated)</span>
                        <strong id="vldlCalc">30 mg/dL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Non-HDL Cholesterol</span>
                        <strong id="nonHdlCalc">150 mg/dL</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Important Ratios</h3>
                    <div class="breakdown-item">
                        <span>Total/HDL Ratio</span>
                        <strong id="totalHdlRatio" style="color: #667eea; font-size: 1.1em;">4.0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>LDL/HDL Ratio</span>
                        <strong id="ldlHdlRatio">2.6</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Triglyceride/HDL Ratio</span>
                        <strong id="trigHdlRatio">3.0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Total Cholesterol Categories</h3>
                    <div class="breakdown-item">
                        <span>Desirable</span>
                        <strong style="color: #4CAF50;">&lt;200 mg/dL (&lt;5.2 mmol/L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Borderline High</span>
                        <strong style="color: #FF9800;">200-239 mg/dL (5.2-6.2 mmol/L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>High</span>
                        <strong style="color: #f44336;">≥240 mg/dL (≥6.2 mmol/L)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>LDL Cholesterol Categories</h3>
                    <div class="breakdown-item">
                        <span>Optimal</span>
                        <strong style="color: #4CAF50;">&lt;100 mg/dL (&lt;2.6 mmol/L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Near Optimal</span>
                        <strong style="color: #4CAF50;">100-129 mg/dL (2.6-3.3 mmol/L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Borderline High</span>
                        <strong style="color: #FF9800;">130-159 mg/dL (3.4-4.1 mmol/L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>High</span>
                        <strong style="color: #f44336;">160-189 mg/dL (4.1-4.9 mmol/L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Very High</span>
                        <strong style="color: #f44336;">≥190 mg/dL (≥4.9 mmol/L)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>HDL Cholesterol Categories</h3>
                    <div class="breakdown-item">
                        <span>Low (Major Risk)</span>
                        <strong style="color: #f44336;">&lt;40 mg/dL (&lt;1.0 mmol/L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average</span>
                        <strong style="color: #FF9800;">40-59 mg/dL (1.0-1.5 mmol/L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Optimal (Protective)</span>
                        <strong style="color: #4CAF50;">≥60 mg/dL (≥1.6 mmol/L)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Triglyceride Categories</h3>
                    <div class="breakdown-item">
                        <span>Normal</span>
                        <strong style="color: #4CAF50;">&lt;150 mg/dL (&lt;1.7 mmol/L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Borderline High</span>
                        <strong style="color: #FF9800;">150-199 mg/dL (1.7-2.2 mmol/L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>High</span>
                        <strong style="color: #f44336;">200-499 mg/dL (2.3-5.6 mmol/L)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Very High</span>
                        <strong style="color: #f44336;">≥500 mg/dL (≥5.7 mmol/L)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Cholesterol</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Total Cholesterol:</strong> Sum of all cholesterol types in blood. Target: &lt;200 mg/dL.</p>
                        <p><strong>LDL (Low-Density Lipoprotein):</strong> "Bad" cholesterol. Builds up in arteries, increases heart disease risk. Target: &lt;100 mg/dL.</p>
                        <p><strong>HDL (High-Density Lipoprotein):</strong> "Good" cholesterol. Removes LDL from arteries, protects heart. Target: &gt;60 mg/dL.</p>
                        <p><strong>Triglycerides:</strong> Most common fat in blood. High levels increase heart disease risk. Target: &lt;150 mg/dL.</p>
                        <p><strong>VLDL (Very Low-Density Lipoprotein):</strong> Carrier of triglycerides. Calculated as Triglycerides ÷ 5.</p>
                        <p><strong>Non-HDL Cholesterol:</strong> Total minus HDL. Includes all "bad" cholesterol. Target: &lt;130 mg/dL.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Cholesterol Ratios Explained</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Total/HDL Ratio:</strong> Most important ratio. Lower is better.</p>
                        <p>• Optimal: &lt;3.5 (men), &lt;3.0 (women)</p>
                        <p>• Average Risk: 4.0-5.0</p>
                        <p>• High Risk: &gt;5.0</p>
                        <p><strong>LDL/HDL Ratio:</strong> Measures bad vs good cholesterol.</p>
                        <p>• Optimal: &lt;2.0</p>
                        <p>• Average: 2.0-3.5</p>
                        <p>• High Risk: &gt;3.5</p>
                        <p><strong>Triglyceride/HDL Ratio:</strong> Indicator of insulin resistance.</p>
                        <p>• Optimal: &lt;2.0</p>
                        <p>• Borderline: 2.0-4.0</p>
                        <p>• High Risk: &gt;4.0</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Risk Factors for High Cholesterol</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>• <strong>Diet:</strong> Saturated fats, trans fats, high cholesterol foods</p>
                        <p>• <strong>Obesity:</strong> Excess weight increases LDL, lowers HDL</p>
                        <p>• <strong>Lack of Exercise:</strong> Physical activity raises HDL</p>
                        <p>• <strong>Smoking:</strong> Damages blood vessels, lowers HDL</p>
                        <p>• <strong>Age:</strong> Risk increases with age (45+ men, 55+ women)</p>
                        <p>• <strong>Diabetes:</strong> High blood sugar damages arteries</p>
                        <p>• <strong>Family History:</strong> Genetics play significant role</p>
                        <p>• <strong>Medications:</strong> Some drugs affect cholesterol levels</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How to Lower Cholesterol</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Diet Changes:</strong> Reduce saturated fats, eliminate trans fats, eat more fiber</p>
                        <p>&#10003; <strong>Exercise:</strong> 30 minutes daily, 5 days/week. Raises HDL, lowers LDL</p>
                        <p>&#10003; <strong>Weight Loss:</strong> Losing 5-10% body weight significantly improves cholesterol</p>
                        <p>&#10003; <strong>Quit Smoking:</strong> HDL increases within weeks of quitting</p>
                        <p>&#10003; <strong>Limit Alcohol:</strong> Moderate consumption only (if any)</p>
                        <p>&#10003; <strong>Medications:</strong> Statins, fibrates, niacin (as prescribed by doctor)</p>
                        <p>&#10003; <strong>Omega-3 Fatty Acids:</strong> Fish oil, fatty fish (salmon, mackerel)</p>
                        <p>&#10003; <strong>Soluble Fiber:</strong> Oats, beans, apples, reduce LDL absorption</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Foods That Lower Cholesterol</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong style="color: #4CAF50;">Eat More:</strong></p>
                        <p>• Oats, barley, whole grains (soluble fiber)</p>
                        <p>• Nuts (almonds, walnuts) - 1 handful daily</p>
                        <p>• Fatty fish (salmon, mackerel, sardines) - omega-3s</p>
                        <p>• Beans, lentils, chickpeas (fiber + protein)</p>
                        <p>• Fruits (apples, berries, citrus) - pectin fiber</p>
                        <p>• Vegetables (especially green leafy ones)</p>
                        <p>• Olive oil, avocado oil (healthy fats)</p>
                        <p>• Plant sterols/stanols (fortified foods)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Foods to Avoid</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong style="color: #f44336;">Limit or Avoid:</strong></p>
                        <p>• Red meat, organ meats (high saturated fat)</p>
                        <p>• Full-fat dairy (butter, cheese, whole milk)</p>
                        <p>• Trans fats (partially hydrogenated oils, fried foods)</p>
                        <p>• Processed meats (bacon, sausage, hot dogs)</p>
                        <p>• Baked goods (cookies, cakes, pastries)</p>
                        <p>• Fast food, fried foods</p>
                        <p>• Tropical oils (coconut oil, palm oil)</p>
                        <p>• Egg yolks (limit to 3-4 per week if high cholesterol)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>When to See a Doctor</h3>
                    <div style="padding: 15px; background: #ffebee; border-radius: 5px; line-height: 1.8; border-left: 4px solid #f44336;">
                        <p><strong>⚠️ Consult Doctor If:</strong></p>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Total cholesterol &gt;240 mg/dL</li>
                            <li>LDL &gt;160 mg/dL (or &gt;130 with risk factors)</li>
                            <li>HDL &lt;40 mg/dL</li>
                            <li>Triglycerides &gt;200 mg/dL</li>
                            <li>Family history of early heart disease</li>
                            <li>Chest pain, shortness of breath</li>
                            <li>Diabetes, high blood pressure</li>
                            <li>Lifestyle changes don't improve levels after 3 months</li>
                        </ul>
                        <p><strong>Regular Testing:</strong> Adults 20+ should check cholesterol every 4-6 years. More often if abnormal or risk factors present.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Cholesterol Tips:</strong> Total cholesterol &lt;200 = desirable. LDL &lt;100 = optimal. HDL &gt;60 = protective. Triglycerides &lt;150 = normal. Total/HDL ratio &lt;3.5 = best. VLDL = Trig÷5. Non-HDL = Total-HDL. Diet + exercise = first line treatment. Statins most effective medication. Lose weight to improve levels. Quit smoking raises HDL. Omega-3s lower triglycerides. Fiber reduces LDL. Check every 4-6 years. Family history matters. Age increases risk. Diabetes worsens cholesterol. Test after fasting 9-12 hours. HDL "good" = cleans arteries. LDL "bad" = clogs arteries. Cholesterol ≠ dietary cholesterol!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('cholesterolForm');
        const unitSelect = document.getElementById('unit');

        unitSelect.addEventListener('change', function() {
            updateUnitLabels();
            analyzeCholesterol();
        });

        function updateUnitLabels() {
            const unit = unitSelect.value;
            const label = unit === 'mgdl' ? 'mg/dL' : 'mmol/L';
            document.getElementById('totalUnit').textContent = label;
            document.getElementById('hdlUnit').textContent = label;
            document.getElementById('ldlUnit').textContent = label;
            document.getElementById('trigUnit').textContent = label;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            analyzeCholesterol();
        });

        function analyzeCholesterol() {
            const unit = unitSelect.value;
            const age = parseInt(document.getElementById('age').value) || 45;
            const gender = document.getElementById('gender').value;
            
            // Get values and convert to mg/dL if needed
            let total = parseFloat(document.getElementById('totalCholesterol').value) || 200;
            let hdl = parseFloat(document.getElementById('hdl').value) || 50;
            let ldl = parseFloat(document.getElementById('ldl').value) || 130;
            let trig = parseFloat(document.getElementById('triglycerides').value) || 150;
            
            if (unit === 'mmol') {
                total = total * 38.67;
                hdl = hdl * 38.67;
                ldl = ldl * 38.67;
                trig = trig * 88.57;
            }

            // Calculate additional values
            const vldl = trig / 5;
            const nonHdl = total - hdl;
            
            // Calculate ratios
            const totalHdlRatio = total / hdl;
            const ldlHdlRatio = ldl / hdl;
            const trigHdlRatio = trig / hdl;

            // Assess total cholesterol
            let totalCategory = '';
            let totalColor = '';
            if (total < 200) {
                totalCategory = 'Desirable';
                totalColor = '#4CAF50';
            } else if (total < 240) {
                totalCategory = 'Borderline High';
                totalColor = '#FF9800';
            } else {
                totalCategory = 'High';
                totalColor = '#f44336';
            }

            // Assess LDL
            let ldlCategory = '';
            let ldlColor = '';
            if (ldl < 100) {
                ldlCategory = 'Optimal';
                ldlColor = '#4CAF50';
            } else if (ldl < 130) {
                ldlCategory = 'Near Optimal';
                ldlColor = '#4CAF50';
            } else if (ldl < 160) {
                ldlCategory = 'Borderline High';
                ldlColor = '#FF9800';
            } else if (ldl < 190) {
                ldlCategory = 'High';
                ldlColor = '#f44336';
            } else {
                ldlCategory = 'Very High';
                ldlColor = '#d32f2f';
            }

            // Assess HDL
            let hdlCategory = '';
            let hdlColor = '';
            if (hdl < 40) {
                hdlCategory = 'Low (Major Risk)';
                hdlColor = '#f44336';
            } else if (hdl < 60) {
                hdlCategory = 'Average';
                hdlColor = '#FF9800';
            } else {
                hdlCategory = 'Optimal';
                hdlColor = '#4CAF50';
            }

            // Assess triglycerides
            let trigCategory = '';
            let trigColor = '';
            if (trig < 150) {
                trigCategory = 'Normal';
                trigColor = '#4CAF50';
            } else if (trig < 200) {
                trigCategory = 'Borderline High';
                trigColor = '#FF9800';
            } else if (trig < 500) {
                trigCategory = 'High';
                trigColor = '#f44336';
            } else {
                trigCategory = 'Very High';
                trigColor = '#d32f2f';
            }

            // Assess ratios
            let ratioAssessment = '';
            const optimalRatio = gender === 'male' ? 3.5 : 3.0;
            
            if (totalHdlRatio < optimalRatio) {
                ratioAssessment = 'Optimal';
            } else if (totalHdlRatio < 5.0) {
                ratioAssessment = 'Average Risk';
            } else {
                ratioAssessment = 'High Risk';
            }

            // Overall risk assessment
            let overallRisk = '';
            let riskColor = '';
            let cardClass = '';
            
            const riskScore = (total > 240 ? 2 : total > 200 ? 1 : 0) +
                            (ldl > 160 ? 2 : ldl > 130 ? 1 : 0) +
                            (hdl < 40 ? 2 : hdl < 60 ? 1 : 0) +
                            (trig > 200 ? 2 : trig > 150 ? 1 : 0);
            
            if (riskScore === 0) {
                overallRisk = 'Low Risk';
                riskColor = '#4CAF50';
                cardClass = 'success';
            } else if (riskScore <= 2) {
                overallRisk = 'Moderate Risk';
                riskColor = '#FF9800';
                cardClass = 'info';
            } else if (riskScore <= 4) {
                overallRisk = 'High Risk';
                riskColor = '#f44336';
                cardClass = 'warning';
            } else {
                overallRisk = 'Very High Risk';
                riskColor = '#d32f2f';
                cardClass = 'warning';
            }

            // Convert back for display if mmol
            const displayUnit = unit === 'mgdl' ? ' mg/dL' : ' mmol/L';
            const displayTotal = unit === 'mgdl' ? total.toFixed(0) : (total / 38.67).toFixed(1);
            const displayHdl = unit === 'mgdl' ? hdl.toFixed(0) : (hdl / 38.67).toFixed(1);
            const displayLdl = unit === 'mgdl' ? ldl.toFixed(0) : (ldl / 38.67).toFixed(1);
            const displayTrig = unit === 'mgdl' ? trig.toFixed(0) : (trig / 88.57).toFixed(1);
            const displayVldl = unit === 'mgdl' ? vldl.toFixed(0) : (vldl / 38.67).toFixed(1);
            const displayNonHdl = unit === 'mgdl' ? nonHdl.toFixed(0) : (nonHdl / 38.67).toFixed(1);

            // Analysis
            let analysis = `Your total cholesterol is ${displayTotal}${displayUnit}, which is in the "${totalCategory}" category. `;
            analysis += `Your LDL (bad cholesterol) is ${displayLdl}${displayUnit} (${ldlCategory}), `;
            analysis += `and HDL (good cholesterol) is ${displayHdl}${displayUnit} (${hdlCategory}). `;
            analysis += `Your triglycerides are ${displayTrig}${displayUnit} (${trigCategory}). `;
            analysis += `Your Total/HDL ratio is ${totalHdlRatio.toFixed(1)}, which is ${ratioAssessment.toLowerCase()}. `;
            analysis += `Overall cardiovascular risk assessment: ${overallRisk}. `;
            
            if (overallRisk.includes('High')) {
                analysis += `Consider consulting your doctor about lifestyle changes and possibly medication. `;
            } else if (overallRisk === 'Moderate Risk') {
                analysis += `Focus on diet, exercise, and lifestyle modifications to improve your levels. `;
            } else {
                analysis += `Your cholesterol levels are in a healthy range. Maintain healthy lifestyle habits. `;
            }
            
            if (hdl < 40) {
                analysis += `⚠️ Your HDL is low - this is a major risk factor. Exercise and weight loss can raise HDL. `;
            }
            if (ldl > 160) {
                analysis += `⚠️ Your LDL is high - consider medication consultation with your doctor. `;
            }
            if (trig > 200) {
                analysis += `⚠️ High triglycerides - reduce sugar, alcohol, and refined carbs. `;
            }

            // Update UI
            const card = document.getElementById('resultCard');
            card.className = 'result-card ' + cardClass;
            
            document.getElementById('riskLevel').textContent = overallRisk;
            document.getElementById('riskLevel').style.color = overallRisk.includes('Low') ? 'inherit' : 'white';
            document.getElementById('riskCategory').textContent = ratioAssessment;
            document.getElementById('riskCategory').style.color = overallRisk.includes('Low') ? 'inherit' : 'white';

            document.getElementById('totalDisplay').textContent = displayTotal;
            document.getElementById('ldlDisplay').textContent = displayLdl;
            document.getElementById('hdlDisplay').textContent = displayHdl;
            document.getElementById('trigDisplay').textContent = displayTrig;

            document.getElementById('totalCalc').textContent = `${displayTotal}${displayUnit}`;
            document.getElementById('totalCalc').style.color = totalColor;
            document.getElementById('ldlCalc').textContent = `${displayLdl}${displayUnit}`;
            document.getElementById('ldlCalc').style.color = ldlColor;
            document.getElementById('hdlCalc').textContent = `${displayHdl}${displayUnit}`;
            document.getElementById('hdlCalc').style.color = hdlColor;
            document.getElementById('trigCalc').textContent = `${displayTrig}${displayUnit}`;
            document.getElementById('trigCalc').style.color = trigColor;
            document.getElementById('vldlCalc').textContent = `${displayVldl}${displayUnit}`;
            document.getElementById('nonHdlCalc').textContent = `${displayNonHdl}${displayUnit}`;

            document.getElementById('totalHdlRatio').textContent = totalHdlRatio.toFixed(1);
            document.getElementById('ldlHdlRatio').textContent = ldlHdlRatio.toFixed(1);
            document.getElementById('trigHdlRatio').textContent = trigHdlRatio.toFixed(1);

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            updateUnitLabels();
            analyzeCholesterol();
        });
    </script>
</body>
</html>