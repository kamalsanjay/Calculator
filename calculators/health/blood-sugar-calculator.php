<?php
/**
 * Blood Sugar Calculator
 * File: blood-sugar-calculator.php
 * Description: Advanced blood sugar analysis with diabetes risk assessment
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Sugar Calculator - Advanced Diabetes Risk Assessment</title>
    <meta name="description" content="Advanced Blood Sugar Calculator. Analyze glucose levels, track patterns, assess diabetes risk with HbA1c conversion and personalized recommendations.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🩸 Blood Sugar Calculator</h1>
        <p>Advanced glucose analysis & diabetes risk assessment</p>
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
            background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
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
            color: #9C27B0;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #7B1FA2;
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
            color: #9C27B0;
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
            border-color: #9C27B0;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #888;
            font-size: 0.9em;
        }
        
        .btn {
            background: #9C27B0;
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
            background: #7B1FA2;
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
        
        .normal {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .prediabetes {
            background: linear-gradient(135deg, #FFC107 0%, #FFA000 100%);
        }
        
        .diabetes {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        }
        
        .hypoglycemia {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }
        
        .critical {
            background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
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
            color: #9C27B0;
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
            color: #9C27B0;
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
            background: #f3e5f5;
            border-left: 4px solid #9C27B0;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box strong {
            color: #7B1FA2;
        }
        
        .glucose-chart {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        
        .glucose-chart th, .glucose-chart td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .glucose-chart th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #555;
        }
        
        .glucose-chart tr:hover {
            background-color: #f5f5f5;
        }
        
        .glucose-chart .current-category {
            background-color: #f3e5f5;
            font-weight: bold;
        }
        
        .time-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .time-option {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .time-option.active {
            background: #9C27B0;
            color: white;
            border-color: #7B1FA2;
        }
        
        .pattern-analysis {
            background: #e8f5e9;
            border-left: 4px solid #4CAF50;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .risk-meter {
            height: 20px;
            background: #e0e0e0;
            border-radius: 10px;
            margin: 15px 0;
            overflow: hidden;
        }
        
        .risk-level {
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s ease;
        }
        
        .risk-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 0.9em;
            color: #666;
        }
        
        .trend-indicator {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: 600;
            margin-left: 8px;
        }
        
        .trend-up {
            background: #ffebee;
            color: #d32f2f;
        }
        
        .trend-down {
            background: #e8f5e9;
            color: #388e3c;
        }
        
        .trend-stable {
            background: #e3f2fd;
            color: #1976d2;
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
            
            .time-options {
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
                <h2>Blood Glucose Readings</h2>
                <form id="bloodSugarForm">
                    <div class="form-group">
                        <label for="glucoseLevel">Blood Glucose Level</label>
                        <input type="number" id="glucoseLevel" value="100" min="20" max="600" step="1" required>
                        <small>Enter your blood sugar reading</small>
                    </div>

                    <div class="form-group">
                        <label>Measurement Time</label>
                        <div class="time-options">
                            <div class="time-option active" data-time="fasting">Fasting</div>
                            <div class="time-option" data-time="postprandial">After Meal</div>
                            <div class="time-option" data-time="random">Random</div>
                        </div>
                        <input type="hidden" id="measurementTime" value="fasting">
                    </div>
                    
                    <div class="form-group">
                        <label for="unitSystem">Measurement Unit</label>
                        <select id="unitSystem">
                            <option value="mgdl">mg/dL (US Standard)</option>
                            <option value="mmol">mmol/L (International)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" value="45" min="1" max="120" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="weight">Weight (kg)</label>
                        <input type="number" id="weight" value="70" min="20" max="300" step="0.1">
                    </div>
                    
                    <div class="form-group">
                        <label for="height">Height (cm)</label>
                        <input type="number" id="height" value="170" min="100" max="250" step="1">
                    </div>
                    
                    <div class="form-group">
                        <label for="familyHistory">Family History of Diabetes</label>
                        <select id="familyHistory">
                            <option value="none">None</option>
                            <option value="one">One Parent</option>
                            <option value="both">Both Parents</option>
                            <option value="sibling">Sibling</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="activityLevel">Activity Level</label>
                        <select id="activityLevel">
                            <option value="sedentary">Sedentary</option>
                            <option value="light">Light Activity</option>
                            <option value="moderate">Moderate Activity</option>
                            <option value="active">Very Active</option>
                            <option value="athlete">Athlete</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="previousReading">Previous Reading (Optional)</label>
                        <input type="number" id="previousReading" placeholder="Enter previous glucose level">
                        <small>For trend analysis</small>
                    </div>
                    
                    <button type="submit" class="btn">Analyze Blood Sugar</button>
                </form>
                
                <div class="breakdown" style="margin-top: 30px;">
                    <h3>Glucose Measurement Guide</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Fasting:</strong> Measure after 8+ hours of fasting (typically morning before breakfast)</p>
                        <p><strong>Postprandial:</strong> Measure 2 hours after start of a meal</p>
                        <p><strong>Random:</strong> Any time regardless of meal timing</p>
                        <p><strong>Normal Ranges:</strong> Fasting: 70-99 mg/dL, Postprandial: <140 mg/dL</p>
                        <p><strong>Unit Conversion:</strong> 1 mmol/L = 18 mg/dL</p>
                    </div>
                </div>
            </div>

            <div class="results-section">
                <h2>Blood Sugar Analysis</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Glucose Status</h3>
                    <div class="amount" id="glucoseStatus">Normal</div>
                    <div class="category" id="glucoseReadings">100 mg/dL</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Current Reading</h4>
                        <div class="value" id="currentGlucose">100</div>
                    </div>
                    <div class="metric-card">
                        <h4>HbA1c Estimate</h4>
                        <div class="value" id="hba1cEstimate">5.0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Diabetes Risk</h4>
                        <div class="value" id="diabetesRisk">Low</div>
                    </div>
                    <div class="metric-card">
                        <h4>Trend</h4>
                        <div class="value" id="glucoseTrend">Stable</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Readings</h3>
                    <div class="breakdown-item">
                        <span>Glucose Level</span>
                        <strong id="glucoseDisplay">100 mg/dL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Measurement Time</span>
                        <strong id="timeDisplay">Fasting</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>HbA1c Estimate</span>
                        <strong id="hba1cDisplay">5.0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI</span>
                        <strong id="bmiDisplay">24.2</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Risk Factors</span>
                        <strong id="riskFactorsDisplay">2</strong>
                    </div>
                </div>

                <div class="pattern-analysis" id="patternAnalysis" style="display: none;">
                    <h3>📈 Pattern Analysis</h3>
                    <p id="patternText">Your glucose levels show a stable pattern within normal ranges.</p>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Blood Glucose Categories</h3>
                    <table class="glucose-chart">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Fasting (mg/dL)</th>
                                <th>Postprandial (mg/dL)</th>
                                <th>HbA1c</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="hypoglycemiaRow">
                                <td>Hypoglycemia</td>
                                <td>&lt; 70</td>
                                <td>&lt; 70</td>
                                <td>-</td>
                            </tr>
                            <tr id="normalRow">
                                <td>Normal</td>
                                <td>70-99</td>
                                <td>&lt; 140</td>
                                <td>&lt; 5.7%</td>
                            </tr>
                            <tr id="prediabetesRow">
                                <td>Prediabetes</td>
                                <td>100-125</td>
                                <td>140-199</td>
                                <td>5.7-6.4%</td>
                            </tr>
                            <tr id="diabetesRow">
                                <td>Diabetes</td>
                                <td>≥ 126</td>
                                <td>≥ 200</td>
                                <td>≥ 6.5%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Diabetes Risk Assessment</h3>
                    <div class="breakdown-item">
                        <span>Current Risk Level</span>
                        <strong id="currentRisk">Low</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>10-Year Risk Probability</span>
                        <strong id="tenYearRisk">5%</strong>
                    </div>
                    <div class="risk-meter">
                        <div class="risk-level" id="riskMeter" style="width: 20%; background: #4CAF50;"></div>
                    </div>
                    <div class="risk-labels">
                        <span>Low</span>
                        <span>Moderate</span>
                        <span>High</span>
                        <span>Very High</span>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Personalized Recommendations</h3>
                    <div id="recommendations" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="recommendationsText" style="margin: 0;">Your blood sugar levels are within normal range. Continue maintaining a healthy lifestyle with balanced nutrition and regular physical activity.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Advanced Metrics</h3>
                    <div class="breakdown-item">
                        <span>Estimated Average Glucose (eAG)</span>
                        <strong id="eagValue">101 mg/dL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Glucose Variability</span>
                        <strong id="variabilityValue">Low</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Time in Range Estimate</span>
                        <strong id="timeInRange">85%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Insulin Sensitivity</span>
                        <strong id="insulinSensitivity">Normal</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Blood Sugar Management Tips:</strong> Monitor regularly at consistent times. Fasting glucose best measured after 8+ hours fasting. Postprandial measured 2 hours after meals. HbA1c reflects 3-month average. Target ranges: Normal fasting 70-99 mg/dL, Prediabetes 100-125 mg/dL, Diabetes ≥126 mg/dL. Lifestyle factors: balanced diet (low glycemic index), regular exercise, weight management, stress reduction, adequate sleep. Warning signs: excessive thirst, frequent urination, fatigue, blurred vision. Emergency: hypoglycemia (<70 mg/dL) needs immediate treatment with fast-acting carbs. Chronic high glucose damages blood vessels, nerves, organs.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('bloodSugarForm');
        const timeOptions = document.querySelectorAll('.time-option');
        
        // Time option selection
        timeOptions.forEach(option => {
            option.addEventListener('click', function() {
                timeOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('measurementTime').value = this.dataset.time;
                analyzeBloodSugar();
            });
        });
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            analyzeBloodSugar();
        });

        function analyzeBloodSugar() {
            const glucoseLevel = parseFloat(document.getElementById('glucoseLevel').value) || 0;
            const measurementTime = document.getElementById('measurementTime').value;
            const unitSystem = document.getElementById('unitSystem').value;
            const age = parseInt(document.getElementById('age').value) || 0;
            const gender = document.getElementById('gender').value;
            const weight = parseFloat(document.getElementById('weight').value) || 0;
            const height = parseFloat(document.getElementById('height').value) || 0;
            const familyHistory = document.getElementById('familyHistory').value;
            const activityLevel = document.getElementById('activityLevel').value;
            const previousReading = parseFloat(document.getElementById('previousReading').value) || null;
            
            // Convert to mg/dL if needed
            let glucoseMgdl = glucoseLevel;
            if (unitSystem === 'mmol') {
                glucoseMgdl = glucoseLevel * 18;
            }
            
            // Calculate BMI
            const heightM = height / 100;
            const bmi = weight / (heightM * heightM);
            
            // Calculate HbA1c estimate
            const hba1c = (glucoseMgdl + 46.7) / 28.7;
            
            // Determine glucose status based on measurement time
            let status = '';
            let statusClass = '';
            let riskLevel = '';
            let riskPercentage = 0;
            let recommendations = '';
            let patternAnalysis = '';
            let showPattern = false;
            
            // Risk factor calculation
            let riskFactors = 0;
            if (bmi >= 25) riskFactors++;
            if (age >= 45) riskFactors++;
            if (familyHistory !== 'none') riskFactors++;
            if (activityLevel === 'sedentary') riskFactors++;
            
            if (measurementTime === 'fasting') {
                if (glucoseMgdl < 70) {
                    status = 'Hypoglycemia';
                    statusClass = 'hypoglycemia';
                    riskLevel = 'Emergency';
                    riskPercentage = 90;
                    recommendations = 'This reading indicates hypoglycemia. Consume 15-20g of fast-acting carbohydrates immediately (juice, glucose tablets). Recheck in 15 minutes. If unconscious or unable to swallow, seek emergency medical help immediately.';
                    patternAnalysis = '⚠️ Hypoglycemic pattern detected. Review medication timing, meal composition, and physical activity levels.';
                    showPattern = true;
                } else if (glucoseMgdl >= 70 && glucoseMgdl <= 99) {
                    status = 'Normal';
                    statusClass = 'normal';
                    riskLevel = 'Low';
                    riskPercentage = 5 + riskFactors * 5;
                    recommendations = 'Your fasting blood sugar is within normal range. Continue maintaining healthy habits: balanced diet, regular exercise, and routine monitoring.';
                } else if (glucoseMgdl >= 100 && glucoseMgdl <= 125) {
                    status = 'Prediabetes';
                    statusClass = 'prediabetes';
                    riskLevel = 'Moderate';
                    riskPercentage = 25 + riskFactors * 10;
                    recommendations = 'Your reading indicates prediabetes. Focus on lifestyle modifications: weight loss (5-7% of body weight), 150+ minutes weekly exercise, reduce refined carbs, increase fiber. Consider consulting healthcare provider.';
                    patternAnalysis = '🔄 Prediabetes pattern. Early intervention can prevent progression to diabetes. Focus on lifestyle changes.';
                    showPattern = true;
                } else {
                    status = 'Diabetes';
                    statusClass = 'diabetes';
                    riskLevel = 'High';
                    riskPercentage = 60 + riskFactors * 10;
                    recommendations = 'This reading suggests diabetes. Please consult with a healthcare provider for proper diagnosis and management plan. Monitor regularly, follow medical advice, and maintain detailed glucose logs.';
                    patternAnalysis = '📊 Diabetes pattern confirmed. Consistent monitoring and medical management are essential for preventing complications.';
                    showPattern = true;
                }
            } else if (measurementTime === 'postprandial') {
                if (glucoseMgdl < 140) {
                    status = 'Normal';
                    statusClass = 'normal';
                    riskLevel = 'Low';
                    riskPercentage = 5 + riskFactors * 5;
                    recommendations = 'Your post-meal glucose is well controlled. Continue with current meal planning and timing.';
                } else if (glucoseMgdl >= 140 && glucoseMgdl <= 199) {
                    status = 'Prediabetes';
                    statusClass = 'prediabetes';
                    riskLevel = 'Moderate';
                    riskPercentage = 30 + riskFactors * 10;
                    recommendations = 'Post-meal glucose elevated. Consider smaller, more frequent meals. Focus on low glycemic index foods. Monitor carbohydrate intake and timing.';
                    patternAnalysis = '⏰ Postprandial hyperglycemia pattern. Review meal composition and portion sizes.';
                    showPattern = true;
                } else {
                    status = 'Diabetes';
                    statusClass = 'diabetes';
                    riskLevel = 'High';
                    riskPercentage = 70 + riskFactors * 10;
                    recommendations = 'Post-meal glucose significantly elevated. Consult healthcare provider. Consider medication adjustment, dietary changes, and increased physical activity after meals.';
                    patternAnalysis = '🚨 Significant postprandial hyperglycemia. Requires medical evaluation and possible treatment adjustment.';
                    showPattern = true;
                }
            } else { // random
                if (glucoseMgdl < 140) {
                    status = 'Normal';
                    statusClass = 'normal';
                    riskLevel = 'Low';
                    riskPercentage = 8 + riskFactors * 5;
                    recommendations = 'Random glucose within normal range. Continue healthy lifestyle habits.';
                } else if (glucoseMgdl >= 140 && glucoseMgdl <= 199) {
                    status = 'Prediabetes';
                    statusClass = 'prediabetes';
                    riskLevel = 'Moderate';
                    riskPercentage = 35 + riskFactors * 10;
                    recommendations = 'Random glucose elevated. Further testing recommended (fasting glucose, HbA1c). Focus on lifestyle modifications.';
                    patternAnalysis = '🔍 Elevated random glucose pattern. Further diagnostic testing recommended.';
                    showPattern = true;
                } else {
                    status = 'Diabetes';
                    statusClass = 'diabetes';
                    riskLevel = 'High';
                    riskPercentage = 75 + riskFactors * 10;
                    recommendations = 'Random glucose suggestive of diabetes. Urgent medical consultation recommended for proper diagnosis and management.';
                    patternAnalysis = '🎯 Diabetes-suggestive pattern on random testing. Confirm with fasting glucose and HbA1c tests.';
                    showPattern = true;
                }
            }
            
            // Calculate trend
            let trend = 'stable';
            let trendClass = 'trend-stable';
            let trendText = 'Stable';
            
            if (previousReading) {
                const previousMgdl = unitSystem === 'mmol' ? previousReading * 18 : previousReading;
                const difference = glucoseMgdl - previousMgdl;
                
                if (difference > 20) {
                    trend = 'up';
                    trendClass = 'trend-up';
                    trendText = 'Increasing ↑';
                } else if (difference < -20) {
                    trend = 'down';
                    trendClass = 'trend-down';
                    trendText = 'Decreasing ↓';
                }
            }
            
            // Calculate advanced metrics
            const eag = (hba1c * 28.7) - 46.7;
            const variability = glucoseMgdl > 180 || glucoseMgdl < 70 ? 'High' : glucoseMgdl > 140 || glucoseMgdl < 80 ? 'Moderate' : 'Low';
            const timeInRange = glucoseMgdl >= 70 && glucoseMgdl <= 180 ? 85 : glucoseMgdl < 70 ? 60 : 70;
            const insulinSensitivity = bmi < 25 && activityLevel !== 'sedentary' ? 'High' : bmi < 30 ? 'Normal' : 'Low';
            
            // Update UI
            const card = document.getElementById('resultCard');
            card.className = `result-card ${statusClass}`;
            
            document.getElementById('glucoseStatus').textContent = status;
            document.getElementById('glucoseReadings').textContent = `${glucoseLevel} ${unitSystem === 'mgdl' ? 'mg/dL' : 'mmol/L'}`;
            
            document.getElementById('currentGlucose').textContent = glucoseLevel;
            document.getElementById('hba1cEstimate').textContent = hba1c.toFixed(1) + '%';
            document.getElementById('diabetesRisk').textContent = riskLevel;
            document.getElementById('glucoseTrend').innerHTML = `${trendText} <span class="trend-indicator ${trendClass}">${trend === 'up' ? '↑' : trend === 'down' ? '↓' : '→'}</span>`;
            
            document.getElementById('glucoseDisplay').textContent = `${glucoseLevel} ${unitSystem === 'mgdl' ? 'mg/dL' : 'mmol/L'}`;
            document.getElementById('timeDisplay').textContent = measurementTime.charAt(0).toUpperCase() + measurementTime.slice(1);
            document.getElementById('hba1cDisplay').textContent = hba1c.toFixed(1) + '%';
            document.getElementById('bmiDisplay').textContent = bmi.toFixed(1);
            document.getElementById('riskFactorsDisplay').textContent = riskFactors;
            
            document.getElementById('currentRisk').textContent = riskLevel;
            document.getElementById('tenYearRisk').textContent = Math.min(riskPercentage, 95) + '%';
            document.getElementById('riskMeter').style.width = Math.min(riskPercentage, 95) + '%';
            document.getElementById('riskMeter').style.background = 
                riskPercentage < 25 ? '#4CAF50' : 
                riskPercentage < 50 ? '#FFC107' : 
                riskPercentage < 75 ? '#FF9800' : '#f44336';
            
            document.getElementById('recommendationsText').textContent = recommendations;
            
            // Pattern analysis
            const patternElement = document.getElementById('patternAnalysis');
            if (showPattern) {
                patternElement.style.display = 'block';
                document.getElementById('patternText').textContent = patternAnalysis;
            } else {
                patternElement.style.display = 'none';
            }
            
            // Advanced metrics
            document.getElementById('eagValue').textContent = eag.toFixed(0) + ' mg/dL';
            document.getElementById('variabilityValue').textContent = variability;
            document.getElementById('timeInRange').textContent = timeInRange + '%';
            document.getElementById('insulinSensitivity').textContent = insulinSensitivity;
            
            // Highlight current category in chart
            document.querySelectorAll('.glucose-chart tr').forEach(row => {
                row.classList.remove('current-category');
            });
            
            if (status === 'Hypoglycemia') {
                document.getElementById('hypoglycemiaRow').classList.add('current-category');
            } else if (status === 'Normal') {
                document.getElementById('normalRow').classList.add('current-category');
            } else if (status === 'Prediabetes') {
                document.getElementById('prediabetesRow').classList.add('current-category');
            } else if (status === 'Diabetes') {
                document.getElementById('diabetesRow').classlist.add('current-category');
            }
        }

        window.addEventListener('load', function() {
            analyzeBloodSugar();
        });
    </script>
</body>
</html>