<?php
/**
 * Healthy Weight Calculator
 * File: healthy-weight-calculator.php
 * Description: Calculate ideal body weight range and healthy weight goals
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthy Weight Calculator - Ideal Body Weight & BMI Range Calculator</title>
    <meta name="description" content="Free healthy weight calculator. Calculate your ideal body weight range based on height, age, and frame size. Find healthy BMI range and weight goals.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>⚖️ Healthy Weight Calculator</h1>
        <p>Calculate ideal body weight range</p>
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
                <h2>Your Information</h2>
                <form id="weightForm">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="imperial">Imperial (lbs/inches)</option>
                            <option value="metric">Metric (kg/cm)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Measurements</h3>
                    
                    <div class="form-group">
                        <label for="age">Age (years)</label>
                        <input type="number" id="age" value="30" min="15" max="100" step="1" required>
                    </div>
                    
                    <div class="form-group" id="heightImperialGroup">
                        <label for="heightFeet">Height</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="heightFeet" value="5" min="3" max="8" step="1" style="flex: 1;" placeholder="Feet">
                            <input type="number" id="heightInches" value="10" min="0" max="11" step="1" style="flex: 1;" placeholder="Inches">
                        </div>
                    </div>

                    <div class="form-group" id="heightMetricGroup" style="display: none;">
                        <label for="heightCm">Height (cm)</label>
                        <input type="number" id="heightCm" value="178" min="100" max="250" step="0.1">
                    </div>
                    
                    <div class="form-group" id="weightImperialGroup">
                        <label for="weightLbs">Current Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="180" min="50" max="500" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Current Weight (kg)</label>
                        <input type="number" id="weightKg" value="82" min="20" max="250" step="0.1">
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Optional Information</h3>
                    
                    <div class="form-group">
                        <label for="frameSize">Frame Size</label>
                        <select id="frameSize">
                            <option value="small">Small Frame</option>
                            <option value="medium" selected>Medium Frame</option>
                            <option value="large">Large Frame</option>
                        </select>
                        <small>Affects ideal weight range</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Healthy Weight</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Healthy Weight Results</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Healthy Weight Range</h3>
                    <div class="amount" id="weightResult">145-175 lbs</div>
                    <div style="margin-top: 10px; font-size: 1em;">Ideal weight range for your height</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Ideal Weight</h4>
                        <div class="value" id="idealDisplay">160 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Current BMI</h4>
                        <div class="value" id="bmiDisplay">24.5</div>
                    </div>
                    <div class="metric-card">
                        <h4>Status</h4>
                        <div class="value" id="statusDisplay">Normal</div>
                    </div>
                    <div class="metric-card">
                        <h4>To Lose/Gain</h4>
                        <div class="value" id="changeDisplay">0 lbs</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Information</h3>
                    <div class="breakdown-item">
                        <span>Gender</span>
                        <strong id="genderDisplay">Male</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Age</span>
                        <strong id="ageDisplay">30 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Height</span>
                        <strong id="heightDisplay">5'10"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Weight</span>
                        <strong id="currentWeightDisplay">180 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Frame Size</span>
                        <strong id="frameDisplay">Medium</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current BMI</span>
                        <strong id="currentBMI" style="color: #667eea;">24.5</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Healthy Weight Ranges</h3>
                    <div class="breakdown-item">
                        <span>Minimum Healthy Weight</span>
                        <strong id="minWeight" style="color: #4CAF50;">145 lbs (BMI 18.5)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ideal Weight (Medium Frame)</span>
                        <strong id="idealWeight" style="color: #667eea; font-size: 1.1em;">160 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Maximum Healthy Weight</span>
                        <strong id="maxWeight" style="color: #4CAF50;">175 lbs (BMI 24.9)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Your Healthy Range</span>
                        <strong id="rangeWeight" style="color: #2196F3;">145-175 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Weight Status Assessment</h3>
                    <div class="breakdown-item">
                        <span>Current Status</span>
                        <strong id="weightStatus" style="color: #667eea; font-size: 1.1em;">Normal Weight</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight to Lose/Gain</span>
                        <strong id="weightChange">5 lbs to reach ideal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Body Fat Goal (Men)</span>
                        <strong id="bodyFatMale">10-20% (athletic to fit)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Body Fat Goal (Women)</span>
                        <strong id="bodyFatFemale">18-28% (athletic to fit)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Ideal Weight by Formula</h3>
                    <div class="breakdown-item">
                        <span>Hamwi Formula</span>
                        <strong id="hamwiWeight">166 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Devine Formula</span>
                        <strong id="devineWeight">160 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Robinson Formula</span>
                        <strong id="robinsonWeight">162 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Miller Formula</span>
                        <strong id="millerWeight">164 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Weight by Frame Size</h3>
                    <div class="breakdown-item">
                        <span>Small Frame</span>
                        <strong id="smallFrame">145-160 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Medium Frame</span>
                        <strong id="mediumFrame" style="color: #4CAF50;">155-170 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Large Frame</span>
                        <strong id="largeFrame">165-180 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>BMI Categories</h3>
                    <div class="breakdown-item">
                        <span>Underweight</span>
                        <strong style="color: #2196F3;">BMI &lt;18.5</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Normal Weight</span>
                        <strong style="color: #4CAF50;">BMI 18.5-24.9</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Overweight</span>
                        <strong style="color: #FF9800;">BMI 25.0-29.9</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Obese Class I</span>
                        <strong style="color: #f44336;">BMI 30.0-34.9</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Obese Class II</span>
                        <strong style="color: #f44336;">BMI 35.0-39.9</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Obese Class III</span>
                        <strong style="color: #d32f2f;">BMI ≥40</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Ideal Weight Formulas</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Hamwi Formula (1964):</strong> Men: 106 lbs for 5' + 6 lbs/inch. Women: 100 lbs for 5' + 5 lbs/inch. Simple and widely used.</p>
                        <p><strong>Devine Formula (1974):</strong> Men: 110 lbs for 5' + 5 lbs/inch. Women: 100.3 lbs for 5' + 5.1 lbs/inch. Used for drug dosing.</p>
                        <p><strong>Robinson Formula (1983):</strong> Men: 114 lbs for 5' + 4 lbs/inch. Women: 108 lbs for 5' + 3.5 lbs/inch. More modern.</p>
                        <p><strong>Miller Formula (1983):</strong> Men: 117 lbs for 5' + 4.2 lbs/inch. Women: 111.6 lbs for 5' + 3.7 lbs/inch. Similar to Robinson.</p>
                        <p><strong>BMI Method:</strong> Healthy weight = height² × BMI (18.5-24.9). Most commonly used in medicine.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Frame Size Determination</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Wrist Method (Most Common):</strong></p>
                        <p><strong>Men:</strong> Wrist &lt;6.5" = Small, 6.5-7.5" = Medium, &gt;7.5" = Large</p>
                        <p><strong>Women:</strong> Wrist &lt;6" = Small, 6-6.25" = Medium, &gt;6.25" = Large</p>
                        <p><strong>Elbow Breadth Method:</strong> Measure elbow width. Compare to height-specific tables.</p>
                        <p><strong>Why It Matters:</strong> Larger frames naturally weigh more with same height. Adds ±10% to ideal weight.</p>
                        <p><strong>Small Frame:</strong> -10% from ideal weight</p>
                        <p><strong>Medium Frame:</strong> Ideal weight as calculated</p>
                        <p><strong>Large Frame:</strong> +10% to ideal weight</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Factors Affecting Ideal Weight</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>• <strong>Muscle Mass:</strong> Athletes/bodybuilders weigh more but are healthy (muscle heavier than fat)</p>
                        <p>• <strong>Age:</strong> Metabolism slows, acceptable BMI may increase slightly with age</p>
                        <p>• <strong>Gender:</strong> Men typically have more muscle mass, higher ideal weight</p>
                        <p>• <strong>Bone Density:</strong> Affects weight without changing health status</p>
                        <p>• <strong>Body Composition:</strong> Body fat % more important than weight alone</p>
                        <p>• <strong>Height:</strong> Taller people weigh more proportionally</p>
                        <p>• <strong>Ethnicity:</strong> Different populations have different healthy BMI ranges</p>
                        <p>• <strong>Medical Conditions:</strong> Some conditions affect ideal weight</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Health Risks by Weight Status</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Underweight (BMI &lt;18.5):</strong></p>
                        <p>• Weakened immune system, malnutrition, anemia, osteoporosis, fertility issues</p>
                        <p><strong>Normal Weight (BMI 18.5-24.9):</strong></p>
                        <p>• Lowest health risks, optimal metabolic function, best longevity</p>
                        <p><strong>Overweight (BMI 25-29.9):</strong></p>
                        <p>• Increased risk: high blood pressure, high cholesterol, prediabetes, sleep apnea</p>
                        <p><strong>Obese (BMI ≥30):</strong></p>
                        <p>• High risk: type 2 diabetes, heart disease, stroke, certain cancers, joint problems, reduced lifespan</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How to Reach Your Healthy Weight</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>For Weight Loss:</strong></p>
                        <p>• Create calorie deficit of 500-750 cal/day (lose 1-1.5 lbs/week)</p>
                        <p>• Eat whole foods, lots of vegetables, lean protein</p>
                        <p>• Reduce added sugars, processed foods, large portions</p>
                        <p>• Exercise 150+ min/week (cardio + strength training)</p>
                        <p>• Track food intake, get adequate sleep (7-9 hours)</p>
                        <p><strong>For Weight Gain:</strong></p>
                        <p>• Create calorie surplus of 300-500 cal/day (gain 0.5-1 lb/week)</p>
                        <p>• Eat nutrient-dense foods: nuts, avocados, whole grains</p>
                        <p>• Add protein shakes, eat more frequent meals</p>
                        <p>• Strength train to build muscle, not just fat</p>
                        <p>• Be patient - healthy gain is slow</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Beyond the Scale: Other Measurements</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Body Fat Percentage:</strong> More accurate than weight. Use calipers, DEXA scan, or BIA scale.</p>
                        <p>• Men: &lt;6% essential, 6-13% athletic, 14-17% fit, 18-24% average, &gt;25% obese</p>
                        <p>• Women: &lt;14% essential, 14-20% athletic, 21-24% fit, 25-31% average, &gt;32% obese</p>
                        <p><strong>Waist Circumference:</strong> Measures abdominal fat (most dangerous type).</p>
                        <p>• Men: &lt;40 inches healthy, ≥40 inches increased risk</p>
                        <p>• Women: &lt;35 inches healthy, ≥35 inches increased risk</p>
                        <p><strong>Waist-to-Hip Ratio:</strong> Waist ÷ Hip. &lt;0.90 (men) or &lt;0.85 (women) is healthy.</p>
                        <p><strong>Waist-to-Height Ratio:</strong> Keep waist &lt;50% of your height.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Realistic Weight Loss Timeline</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Safe Rate:</strong> 1-2 lbs per week (0.5-1 kg/week)</p>
                        <p><strong>10 lbs to Lose:</strong> 5-10 weeks</p>
                        <p><strong>20 lbs to Lose:</strong> 10-20 weeks (2.5-5 months)</p>
                        <p><strong>50 lbs to Lose:</strong> 25-50 weeks (6-12 months)</p>
                        <p><strong>100 lbs to Lose:</strong> 50-100 weeks (1-2 years)</p>
                        <p><strong>Faster Loss:</strong> First few weeks often show 3-5 lbs (water weight). Then slows to 1-2 lbs/week.</p>
                        <p><strong>Plateaus:</strong> Normal! Body adapts. Change routine, be patient, don't give up.</p>
                        <p><strong>Maintenance:</strong> Hardest part. Requires permanent lifestyle changes, not temporary diets.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Healthy Weight Tips:</strong> Healthy weight = BMI 18.5-24.9. Ideal weight formulas: Hamwi, Devine, Robinson, Miller. Frame size matters (±10%). BMI doesn't account for muscle mass. Body fat % more accurate than weight. Waist &lt;40" (men), &lt;35" (women) = healthy. Safe weight loss = 1-2 lbs/week. 3,500 cal deficit = 1 lb fat loss. Muscle weighs more than fat. Focus on body composition, not just weight. Waist-to-height ratio &lt;0.5. Weight fluctuates daily (water, food). Measure progress multiple ways. Healthy weight reduces disease risk. Extreme diets don't work long-term. Sustainable lifestyle changes = key to success!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('weightForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateHealthyWeight();
        });

        function toggleUnitFields() {
            const unitSystem = unitSystemSelect.value;
            const isImperial = unitSystem === 'imperial';
            
            document.getElementById('heightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('heightMetricGroup').style.display = isImperial ? 'none' : 'block';
            document.getElementById('weightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('weightMetricGroup').style.display = isImperial ? 'none' : 'block';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateHealthyWeight();
        });

        function calculateHealthyWeight() {
            const gender = document.getElementById('gender').value;
            const age = parseInt(document.getElementById('age').value) || 30;
            const frameSize = document.getElementById('frameSize').value;
            const unitSystem = unitSystemSelect.value;
            
            // Get measurements
            let heightCm, weightKg;
            
            if (unitSystem === 'imperial') {
                const feet = parseFloat(document.getElementById('heightFeet').value) || 0;
                const inches = parseFloat(document.getElementById('heightInches').value) || 0;
                const heightInches = (feet * 12) + inches;
                heightCm = heightInches * 2.54;
                const weightLbs = parseFloat(document.getElementById('weightLbs').value) || 0;
                weightKg = weightLbs / 2.20462;
            } else {
                heightCm = parseFloat(document.getElementById('heightCm').value) || 0;
                weightKg = parseFloat(document.getElementById('weightKg').value) || 0;
            }

            const heightM = heightCm / 100;
            const heightInches = heightCm / 2.54;

            // Calculate current BMI
            const currentBMI = weightKg / (heightM * heightM);

            // Calculate healthy weight range (BMI 18.5-24.9)
            const minHealthyWeight = 18.5 * heightM * heightM;
            const maxHealthyWeight = 24.9 * heightM * heightM;

            // Calculate ideal weight using multiple formulas
            let hamwi, devine, robinson, miller;
            
            if (gender === 'male') {
                // Men's formulas
                hamwi = 48 + 2.7 * ((heightInches - 60)); // 106 lbs + 6 lbs/inch
                devine = 50 + 2.3 * ((heightInches - 60)); // 110 lbs + 5 lbs/inch
                robinson = 52 + 1.9 * ((heightInches - 60)); // 114 lbs + 4 lbs/inch
                miller = 53.1 + 1.9 * ((heightInches - 60)); // 117 lbs + 4.2 lbs/inch
            } else {
                // Women's formulas
                hamwi = 45.5 + 2.2 * ((heightInches - 60)); // 100 lbs + 5 lbs/inch
                devine = 45.5 + 2.3 * ((heightInches - 60)); // 100.3 lbs + 5.1 lbs/inch
                robinson = 49 + 1.7 * ((heightInches - 60)); // 108 lbs + 3.5 lbs/inch
                miller = 50.6 + 1.7 * ((heightInches - 60)); // 111.6 lbs + 3.7 lbs/inch
            }

            // Average of formulas for ideal weight
            const idealWeightKg = (hamwi + devine + robinson + miller) / 4;

            // Adjust for frame size
            let frameAdjustment = 1.0;
            if (frameSize === 'small') frameAdjustment = 0.9;
            else if (frameSize === 'large') frameAdjustment = 1.1;
            
            const adjustedIdealWeight = idealWeightKg * frameAdjustment;

            // Weight ranges by frame
            const smallFrameMin = minHealthyWeight;
            const smallFrameMax = adjustedIdealWeight * 1.05;
            const mediumFrameMin = adjustedIdealWeight * 0.95;
            const mediumFrameMax = adjustedIdealWeight * 1.05;
            const largeFrameMin = adjustedIdealWeight * 0.95;
            const largeFrameMax = maxHealthyWeight;

            // Weight change needed
            const weightChange = weightKg - adjustedIdealWeight;

            // Determine status
            let status = '';
            let statusColor = '';
            let cardClass = '';
            
            if (currentBMI < 18.5) {
                status = 'Underweight';
                statusColor = '#2196F3';
                cardClass = 'info';
            } else if (currentBMI < 25) {
                status = 'Normal Weight';
                statusColor = '#4CAF50';
                cardClass = 'success';
            } else if (currentBMI < 30) {
                status = 'Overweight';
                statusColor = '#FF9800';
                cardClass = 'warning';
            } else {
                status = 'Obese';
                statusColor = '#f44336';
                cardClass = 'warning';
            }

            // Convert to display units
            const unitLabel = unitSystem === 'imperial' ? 'lbs' : 'kg';
            const toDisplay = (kg) => unitSystem === 'imperial' ? (kg * 2.20462).toFixed(0) : kg.toFixed(1);
            const currentWeight = unitSystem === 'imperial' ? (weightKg * 2.20462).toFixed(1) : weightKg.toFixed(1);

            // Display measurements
            const heightDisplay = unitSystem === 'imperial' ? 
                `${Math.floor(heightInches / 12)}'${(heightInches % 12).toFixed(0)}"` : 
                `${heightCm.toFixed(1)} cm`;

            // Analysis
            let analysis = `Based on your height of ${heightDisplay}, your healthy weight range is ${toDisplay(minHealthyWeight)}-${toDisplay(maxHealthyWeight)} ${unitLabel} (BMI 18.5-24.9). `;
            analysis += `Your current weight is ${currentWeight} ${unitLabel} with a BMI of ${currentBMI.toFixed(1)}, which is classified as ${status.toLowerCase()}. `;
            
            if (status === 'Normal Weight') {
                if (Math.abs(weightChange) < 2) {
                    analysis += `Excellent! You're at your ideal weight. `;
                } else if (weightChange > 0) {
                    analysis += `You're ${Math.abs(toDisplay(weightChange))} ${unitLabel} above your ideal weight of ${toDisplay(adjustedIdealWeight)} ${unitLabel}, but still within the healthy range. `;
                } else {
                    analysis += `You're ${Math.abs(toDisplay(weightChange))} ${unitLabel} below your ideal weight of ${toDisplay(adjustedIdealWeight)} ${unitLabel}, but still within the healthy range. `;
                }
                analysis += `Focus on maintaining your weight through balanced diet and regular exercise. `;
            } else if (status === 'Underweight') {
                analysis += `You need to gain ${Math.abs(toDisplay(weightChange))} ${unitLabel} to reach your ideal weight of ${toDisplay(adjustedIdealWeight)} ${unitLabel}. `;
                analysis += `Aim for a healthy gain of 0.5-1 lb/week by eating nutrient-dense foods and strength training. `;
            } else if (status === 'Overweight' || status === 'Obese') {
                analysis += `You need to lose ${toDisplay(weightChange)} ${unitLabel} to reach your ideal weight of ${toDisplay(adjustedIdealWeight)} ${unitLabel}. `;
                analysis += `A safe rate is 1-2 lbs/week. This would take approximately ${Math.ceil(Math.abs(weightChange * 2.20462) / 1.5)} weeks. `;
                analysis += `Focus on creating a calorie deficit through diet and exercise. `;
            }
            
            analysis += `Your ideal weight is calculated using multiple formulas (Hamwi, Devine, Robinson, Miller) adjusted for your ${frameSize} frame size. `;
            analysis += `Remember that muscle weighs more than fat, so if you're athletic, you may weigh more while still being healthy. `;
            analysis += `Consider tracking body fat percentage and waist circumference in addition to weight.`;

            // Update UI
            const card = document.getElementById('resultCard');
            card.className = 'result-card ' + cardClass;

            document.getElementById('weightResult').textContent = `${toDisplay(minHealthyWeight)}-${toDisplay(maxHealthyWeight)} ${unitLabel}`;
            document.getElementById('idealDisplay').textContent = `${toDisplay(adjustedIdealWeight)} ${unitLabel}`;
            document.getElementById('bmiDisplay').textContent = currentBMI.toFixed(1);
            document.getElementById('statusDisplay').textContent = status;
            
            const changeText = Math.abs(weightChange) < 0.5 ? '0' : 
                (weightChange > 0 ? `-${toDisplay(Math.abs(weightChange))}` : `+${toDisplay(Math.abs(weightChange))}`);
            document.getElementById('changeDisplay').textContent = `${changeText} ${unitLabel}`;

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('ageDisplay').textContent = `${age} years`;
            document.getElementById('heightDisplay').textContent = heightDisplay;
            document.getElementById('currentWeightDisplay').textContent = `${currentWeight} ${unitLabel}`;
            document.getElementById('frameDisplay').textContent = `${frameSize.charAt(0).toUpperCase() + frameSize.slice(1)} Frame`;
            document.getElementById('currentBMI').textContent = currentBMI.toFixed(1);

            document.getElementById('minWeight').textContent = `${toDisplay(minHealthyWeight)} ${unitLabel} (BMI 18.5)`;
            document.getElementById('idealWeight').textContent = `${toDisplay(adjustedIdealWeight)} ${unitLabel}`;
            document.getElementById('maxWeight').textContent = `${toDisplay(maxHealthyWeight)} ${unitLabel} (BMI 24.9)`;
            document.getElementById('rangeWeight').textContent = `${toDisplay(minHealthyWeight)}-${toDisplay(maxHealthyWeight)} ${unitLabel}`;

            document.getElementById('weightStatus').textContent = status;
            document.getElementById('weightStatus').style.color = statusColor;
            
            let changeMessage = '';
            if (Math.abs(weightChange) < 0.5) {
                changeMessage = 'At ideal weight!';
            } else if (weightChange > 0) {
                changeMessage = `${toDisplay(Math.abs(weightChange))} ${unitLabel} to lose`;
            } else {
                changeMessage = `${toDisplay(Math.abs(weightChange))} ${unitLabel} to gain`;
            }
            document.getElementById('weightChange').textContent = changeMessage;

            document.getElementById('hamwiWeight').textContent = `${toDisplay(hamwi)} ${unitLabel}`;
            document.getElementById('devineWeight').textContent = `${toDisplay(devine)} ${unitLabel}`;
            document.getElementById('robinsonWeight').textContent = `${toDisplay(robinson)} ${unitLabel}`;
            document.getElementById('millerWeight').textContent = `${toDisplay(miller)} ${unitLabel}`;

            document.getElementById('smallFrame').textContent = `${toDisplay(smallFrameMin)}-${toDisplay(smallFrameMax)} ${unitLabel}`;
            document.getElementById('mediumFrame').textContent = `${toDisplay(mediumFrameMin)}-${toDisplay(mediumFrameMax)} ${unitLabel}`;
            document.getElementById('largeFrame').textContent = `${toDisplay(largeFrameMin)}-${toDisplay(largeFrameMax)} ${unitLabel}`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateHealthyWeight();
        });
    </script>
</body>
</html>