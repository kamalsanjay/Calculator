<?php
/**
 * Body Fat Calculator
 * File: body-fat-calculator.php
 * Description: Calculate body fat percentage using multiple methods (Imperial/Metric)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Body Fat Calculator - Calculate Body Fat Percentage (Imperial/Metric)</title>
    <meta name="description" content="Free body fat calculator. Calculate body fat percentage using US Navy, BMI, and other methods. Supports imperial and metric units. Get fat mass and lean mass.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#129310; Body Fat Calculator</h1>
        <p>Calculate body fat percentage</p>
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
                <form id="bodyFatForm">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="method">Calculation Method</label>
                        <select id="method">
                            <option value="navy">US Navy Method (Recommended)</option>
                            <option value="bmi">BMI Method</option>
                            <option value="both">Both Methods</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="imperial">Imperial (lbs/inches)</option>
                            <option value="metric">Metric (kg/cm)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Basic Measurements</h3>
                    
                    <div class="form-group">
                        <label for="age">Age (years)</label>
                        <input type="number" id="age" value="30" min="15" max="100" step="1" required>
                    </div>
                    
                    <div class="form-group" id="heightImperialGroup">
                        <label for="heightFeet">Height</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="heightFeet" value="5" min="3" max="8" step="1" style="flex: 1;" placeholder="Feet">
                            <input type="number" id="heightInches" value="10" min="0" max="11" step="0.5" style="flex: 1;" placeholder="Inches">
                        </div>
                    </div>

                    <div class="form-group" id="heightMetricGroup" style="display: none;">
                        <label for="heightCm">Height (cm)</label>
                        <input type="number" id="heightCm" value="178" min="100" max="250" step="0.1">
                    </div>
                    
                    <div class="form-group" id="weightImperialGroup">
                        <label for="weightLbs">Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="180" min="50" max="500" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="82" min="20" max="250" step="0.1">
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;" id="circumferenceTitle">Circumference Measurements (Navy Method)</h3>
                    
                    <div id="navyMeasurements">
                        <div class="form-group">
                            <label for="neck">Neck Circumference (<span id="neckUnit">inches</span>)</label>
                            <input type="number" id="neck" value="15" min="5" max="30" step="0.1">
                            <small>Measure at narrowest point below Adam's apple</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="waist">Waist Circumference (<span id="waistUnit">inches</span>)</label>
                            <input type="number" id="waist" value="32" min="15" max="80" step="0.1">
                            <small>Measure at navel level (belly button)</small>
                        </div>
                        
                        <div class="form-group" id="hipGroup">
                            <label for="hip">Hip Circumference (<span id="hipUnit">inches</span>)</label>
                            <input type="number" id="hip" value="38" min="20" max="80" step="0.1">
                            <small>Measure at widest point of hips/buttocks (women only)</small>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Body Fat</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Body Fat Results</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Body Fat Percentage</h3>
                    <div class="amount" id="bodyFatPercent">18%</div>
                    <div style="margin-top: 10px; font-size: 1.3em;" id="bodyFatCategory">Fitness</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Body Fat %</h4>
                        <div class="value" id="bfDisplay">18%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Category</h4>
                        <div class="value" id="categoryDisplay">Fitness</div>
                    </div>
                    <div class="metric-card">
                        <h4>Fat Mass</h4>
                        <div class="value" id="fatMass">32 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Lean Mass</h4>
                        <div class="value" id="leanMass">148 lbs</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Measurements</h3>
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
                        <span>Weight</span>
                        <strong id="weightDisplay">180 lbs</strong>
                    </div>
                    <div class="breakdown-item" id="neckDisplayItem">
                        <span>Neck</span>
                        <strong id="neckDisplay">15 in</strong>
                    </div>
                    <div class="breakdown-item" id="waistDisplayItem">
                        <span>Waist</span>
                        <strong id="waistDisplay">32 in</strong>
                    </div>
                    <div class="breakdown-item" id="hipDisplayItem" style="display: none;">
                        <span>Hip</span>
                        <strong id="hipDisplay">38 in</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Body Composition</h3>
                    <div class="breakdown-item">
                        <span>Body Fat Percentage</span>
                        <strong id="bfPercent" style="color: #667eea; font-size: 1.1em;">18%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fat Mass</span>
                        <strong id="fatMassCalc" style="color: #f44336;">32 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lean Body Mass</span>
                        <strong id="leanMassCalc" style="color: #4CAF50;">148 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Weight</span>
                        <strong id="totalWeight">180 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI</span>
                        <strong id="bmiDisplay">25.8</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;" id="methodComparison">
                    <h3>Method Comparison</h3>
                    <div class="breakdown-item">
                        <span>US Navy Method</span>
                        <strong id="navyResult" style="color: #667eea;">18%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI Method</span>
                        <strong id="bmiResult">18%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average</span>
                        <strong id="averageResult">18%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Body Fat Categories (Men)</h3>
                    <div class="breakdown-item">
                        <span>Essential Fat</span>
                        <strong style="color: #FF9800;">2-5%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Athletes</span>
                        <strong style="color: #4CAF50;">6-13%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fitness</span>
                        <strong style="color: #4CAF50;">14-17%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average</span>
                        <strong style="color: #667eea;">18-24%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Obese</span>
                        <strong style="color: #f44336;">25%+</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Body Fat Categories (Women)</h3>
                    <div class="breakdown-item">
                        <span>Essential Fat</span>
                        <strong style="color: #FF9800;">10-13%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Athletes</span>
                        <strong style="color: #4CAF50;">14-20%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fitness</span>
                        <strong style="color: #4CAF50;">21-24%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average</span>
                        <strong style="color: #667eea;">25-31%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Obese</span>
                        <strong style="color: #f44336;">32%+</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>To Achieve Different Body Fat %</h3>
                    <div class="breakdown-item">
                        <span>For 10% Body Fat</span>
                        <strong id="target10">Lose 0 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>For 15% Body Fat</span>
                        <strong id="target15">Lose 0 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>For 20% Body Fat</span>
                        <strong id="target20">Lose 0 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>For 25% Body Fat</span>
                        <strong id="target25">Lose 0 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Body Fat Measurement Methods</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>US Navy Method:</strong> Uses circumference measurements. Accurate within 3-4%. Free and easy. Most reliable field method.</p>
                        <p><strong>BMI Method:</strong> Uses height and weight. Less accurate (doesn't account for muscle). Good for quick estimates.</p>
                        <p><strong>DEXA Scan:</strong> Most accurate (±1%). Expensive. Medical/research grade.</p>
                        <p><strong>Hydrostatic Weighing:</strong> Very accurate (±2%). Underwater weighing. Not widely available.</p>
                        <p><strong>Skinfold Calipers:</strong> Accurate if done correctly (±3%). Requires skill and consistency.</p>
                        <p><strong>Bioelectrical Impedance (BIA):</strong> Convenient but less accurate (±5%). Affected by hydration.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Why Body Fat % Matters</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>More Accurate Than Weight:</strong> Two people same weight can have very different body composition.</p>
                        <p><strong>Health Indicator:</strong> Excess body fat increases risk of diabetes, heart disease, certain cancers.</p>
                        <p><strong>Fitness Goals:</strong> Track fat loss while preserving/building muscle.</p>
                        <p><strong>BMI Limitations:</strong> BMI can classify muscular people as overweight. Body fat % is more accurate.</p>
                        <p><strong>Essential Fat:</strong> Minimum fat needed for basic functions. Going below dangerous.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How to Reduce Body Fat</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Calorie Deficit:</strong> Burn more than you consume (500 cal/day = 1 lb/week)</p>
                        <p>&#10003; <strong>Strength Training:</strong> Build/preserve muscle while losing fat</p>
                        <p>&#10003; <strong>Protein Intake:</strong> 0.8-1g per lb body weight to preserve muscle</p>
                        <p>&#10003; <strong>Cardio:</strong> Increases calorie burn and cardiovascular health</p>
                        <p>&#10003; <strong>Sleep:</strong> 7-9 hours. Poor sleep increases cortisol and fat storage</p>
                        <p>&#10003; <strong>Manage Stress:</strong> Chronic stress (cortisol) promotes fat storage</p>
                        <p>&#10003; <strong>Stay Hydrated:</strong> Water aids fat metabolism</p>
                        <p>&#10003; <strong>Patience:</strong> Healthy fat loss = 0.5-1% body fat per month</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Measurement Tips (Navy Method)</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Neck:</strong> Measure at narrowest point, just below Adam's apple. Keep tape horizontal.</p>
                        <p><strong>Waist (Men):</strong> Measure at level of navel (belly button). Stand naturally, don't suck in.</p>
                        <p><strong>Waist (Women):</strong> Measure at narrowest point of natural waistline.</p>
                        <p><strong>Hip (Women):</strong> Measure at widest point of hips and buttocks.</p>
                        <p><strong>General:</strong> Measure on bare skin or tight clothing. Same time of day. Take 3 measurements, use average.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Body Fat Tips:</strong> Navy method = most accurate field method. BMI ≠ body fat. Muscle weighs more than fat. Essential fat = 2-5% (men), 10-13% (women). Athletes = 6-13% (men), 14-20% (women). Fitness = 14-17% (men), 21-24% (women). Obese = 25%+ (men), 32%+ (women). DEXA scan = most accurate. Measure consistently same time/day. Track trends, not single readings. Body fat % > weight on scale. Can't spot reduce fat. Abs visible ~10-12% (men), ~16-19% (women). Healthy fat loss = 0.5-1% per month. Preserve muscle while losing fat. Protein + strength training essential!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('bodyFatForm');
        const genderSelect = document.getElementById('gender');
        const methodSelect = document.getElementById('method');
        const unitSystemSelect = document.getElementById('unitSystem');

        genderSelect.addEventListener('change', function() {
            toggleHipField();
            calculateBodyFat();
        });

        methodSelect.addEventListener('change', function() {
            toggleMethodFields();
            calculateBodyFat();
        });

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateBodyFat();
        });

        function toggleHipField() {
            const gender = genderSelect.value;
            document.getElementById('hipGroup').style.display = gender === 'female' ? 'block' : 'none';
            document.getElementById('hipDisplayItem').style.display = gender === 'female' ? 'flex' : 'none';
        }

        function toggleMethodFields() {
            const method = methodSelect.value;
            const navyMeasurements = document.getElementById('navyMeasurements');
            const methodComparison = document.getElementById('methodComparison');
            
            if (method === 'bmi') {
                navyMeasurements.style.display = 'none';
                methodComparison.style.display = 'none';
                document.getElementById('circumferenceTitle').style.display = 'none';
                document.getElementById('neckDisplayItem').style.display = 'none';
                document.getElementById('waistDisplayItem').style.display = 'none';
            } else {
                navyMeasurements.style.display = 'block';
                document.getElementById('circumferenceTitle').style.display = 'block';
                document.getElementById('neckDisplayItem').style.display = 'flex';
                document.getElementById('waistDisplayItem').style.display = 'flex';
                methodComparison.style.display = method === 'both' ? 'block' : 'none';
            }
        }

        function toggleUnitFields() {
            const unitSystem = unitSystemSelect.value;
            const isImperial = unitSystem === 'imperial';
            
            document.getElementById('heightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('heightMetricGroup').style.display = isImperial ? 'none' : 'block';
            document.getElementById('weightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('weightMetricGroup').style.display = isImperial ? 'none' : 'block';
            
            document.getElementById('neckUnit').textContent = isImperial ? 'inches' : 'cm';
            document.getElementById('waistUnit').textContent = isImperial ? 'inches' : 'cm';
            document.getElementById('hipUnit').textContent = isImperial ? 'inches' : 'cm';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBodyFat();
        });

        function calculateBodyFat() {
            const gender = genderSelect.value;
            const method = methodSelect.value;
            const age = parseInt(document.getElementById('age').value) || 30;
            const unitSystem = unitSystemSelect.value;
            
            // Get measurements
            let heightInches, weightLbs, neck, waist, hip;
            
            if (unitSystem === 'imperial') {
                const feet = parseFloat(document.getElementById('heightFeet').value) || 0;
                const inches = parseFloat(document.getElementById('heightInches').value) || 0;
                heightInches = (feet * 12) + inches;
                weightLbs = parseFloat(document.getElementById('weightLbs').value) || 0;
                neck = parseFloat(document.getElementById('neck').value) || 0;
                waist = parseFloat(document.getElementById('waist').value) || 0;
                hip = parseFloat(document.getElementById('hip').value) || 0;
            } else {
                const heightCm = parseFloat(document.getElementById('heightCm').value) || 0;
                heightInches = heightCm / 2.54;
                const weightKg = parseFloat(document.getElementById('weightKg').value) || 0;
                weightLbs = weightKg * 2.20462;
                const neckCm = parseFloat(document.getElementById('neck').value) || 0;
                const waistCm = parseFloat(document.getElementById('waist').value) || 0;
                const hipCm = parseFloat(document.getElementById('hip').value) || 0;
                neck = neckCm / 2.54;
                waist = waistCm / 2.54;
                hip = hipCm / 2.54;
            }

            // Calculate BMI
            const bmi = (weightLbs / (heightInches * heightInches)) * 703;

            let bodyFatPercent, navyBF = 0, bmiBF = 0;

            // US Navy Method
            if (method === 'navy' || method === 'both') {
                if (gender === 'male') {
                    navyBF = (86.010 * Math.log10(waist - neck)) - (70.041 * Math.log10(heightInches)) + 36.76;
                } else {
                    navyBF = (163.205 * Math.log10(waist + hip - neck)) - (97.684 * Math.log10(heightInches)) - 78.387;
                }
            }

            // BMI Method (less accurate)
            if (method === 'bmi' || method === 'both') {
                if (gender === 'male') {
                    bmiBF = (1.20 * bmi) + (0.23 * age) - 16.2;
                } else {
                    bmiBF = (1.20 * bmi) + (0.23 * age) - 5.4;
                }
            }

            // Determine final body fat percentage
            if (method === 'navy') {
                bodyFatPercent = navyBF;
            } else if (method === 'bmi') {
                bodyFatPercent = bmiBF;
            } else {
                bodyFatPercent = (navyBF + bmiBF) / 2;
            }

            // Calculate fat mass and lean mass
            const fatMass = (bodyFatPercent / 100) * weightLbs;
            const leanMass = weightLbs - fatMass;

            // Determine category
            let category = '';
            let categoryColor = '';
            
            if (gender === 'male') {
                if (bodyFatPercent < 6) {
                    category = 'Essential Fat';
                    categoryColor = '#FF9800';
                } else if (bodyFatPercent < 14) {
                    category = 'Athletes';
                    categoryColor = '#4CAF50';
                } else if (bodyFatPercent < 18) {
                    category = 'Fitness';
                    categoryColor = '#4CAF50';
                } else if (bodyFatPercent < 25) {
                    category = 'Average';
                    categoryColor = '#667eea';
                } else {
                    category = 'Obese';
                    categoryColor = '#f44336';
                }
            } else {
                if (bodyFatPercent < 14) {
                    category = 'Essential Fat';
                    categoryColor = '#FF9800';
                } else if (bodyFatPercent < 21) {
                    category = 'Athletes';
                    categoryColor = '#4CAF50';
                } else if (bodyFatPercent < 25) {
                    category = 'Fitness';
                    categoryColor = '#4CAF50';
                } else if (bodyFatPercent < 32) {
                    category = 'Average';
                    categoryColor = '#667eea';
                } else {
                    category = 'Obese';
                    categoryColor = '#f44336';
                }
            }

            // Target weights
            const target10 = leanMass / (1 - 0.10);
            const target15 = leanMass / (1 - 0.15);
            const target20 = leanMass / (1 - 0.20);
            const target25 = leanMass / (1 - 0.25);

            // Update card
            const card = document.getElementById('resultCard');
            if (category === 'Athletes' || category === 'Fitness') {
                card.className = 'result-card success';
            } else if (category === 'Average') {
                card.className = 'result-card info';
            } else {
                card.className = 'result-card warning';
            }

            // Display measurements
            const displayHeight = unitSystem === 'imperial' ? 
                `${Math.floor(heightInches / 12)}'${(heightInches % 12).toFixed(1)}"` : 
                `${(heightInches * 2.54).toFixed(1)} cm`;
            const displayWeight = unitSystem === 'imperial' ? 
                `${weightLbs.toFixed(1)} lbs` : 
                `${(weightLbs / 2.20462).toFixed(1)} kg`;
            const displayNeck = unitSystem === 'imperial' ? 
                `${neck.toFixed(1)} in` : 
                `${(neck * 2.54).toFixed(1)} cm`;
            const displayWaist = unitSystem === 'imperial' ? 
                `${waist.toFixed(1)} in` : 
                `${(waist * 2.54).toFixed(1)} cm`;
            const displayHip = unitSystem === 'imperial' ? 
                `${hip.toFixed(1)} in` : 
                `${(hip * 2.54).toFixed(1)} cm`;

            // Analysis
            let analysis = `Your body fat percentage is estimated at ${bodyFatPercent.toFixed(1)}%, which falls in the "${category}" category. `;
            analysis += `Of your ${displayWeight} total weight, ${unitSystem === 'imperial' ? fatMass.toFixed(1) + ' lbs' : (fatMass / 2.20462).toFixed(1) + ' kg'} is fat mass and `;
            analysis += `${unitSystem === 'imperial' ? leanMass.toFixed(1) + ' lbs' : (leanMass / 2.20462).toFixed(1) + ' kg'} is lean body mass (muscle, bone, water, organs). `;
            
            if (method === 'both') {
                analysis += `The US Navy method calculated ${navyBF.toFixed(1)}% and the BMI method calculated ${bmiBF.toFixed(1)}%. `;
            }
            
            if (category === 'Obese') {
                analysis += `Consider consulting a healthcare provider about healthy weight loss strategies. `;
            } else if (category === 'Essential Fat') {
                analysis += `This is at the minimum level of body fat needed for basic physiological functions. `;
            }
            
            analysis += `The US Navy method is generally the most accurate non-clinical method available.`;

            // Update UI
            document.getElementById('bodyFatPercent').textContent = bodyFatPercent.toFixed(1) + '%';
            document.getElementById('bodyFatCategory').textContent = category;
            document.getElementById('bodyFatCategory').style.color = categoryColor;

            document.getElementById('bfDisplay').textContent = bodyFatPercent.toFixed(1) + '%';
            document.getElementById('categoryDisplay').textContent = category;
            document.getElementById('categoryDisplay').style.color = categoryColor;
            document.getElementById('fatMass').textContent = unitSystem === 'imperial' ? 
                `${fatMass.toFixed(1)} lbs` : 
                `${(fatMass / 2.20462).toFixed(1)} kg`;
            document.getElementById('leanMass').textContent = unitSystem === 'imperial' ? 
                `${leanMass.toFixed(1)} lbs` : 
                `${(leanMass / 2.20462).toFixed(1)} kg`;

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('ageDisplay').textContent = `${age} years`;
            document.getElementById('heightDisplay').textContent = displayHeight;
            document.getElementById('weightDisplay').textContent = displayWeight;
            document.getElementById('neckDisplay').textContent = displayNeck;
            document.getElementById('waistDisplay').textContent = displayWaist;
            if (gender === 'female') {
                document.getElementById('hipDisplay').textContent = displayHip;
            }

            document.getElementById('bfPercent').textContent = bodyFatPercent.toFixed(1) + '%';
            document.getElementById('fatMassCalc').textContent = unitSystem === 'imperial' ? 
                `${fatMass.toFixed(1)} lbs` : 
                `${(fatMass / 2.20462).toFixed(1)} kg`;
            document.getElementById('leanMassCalc').textContent = unitSystem === 'imperial' ? 
                `${leanMass.toFixed(1)} lbs` : 
                `${(leanMass / 2.20462).toFixed(1)} kg`;
            document.getElementById('totalWeight').textContent = displayWeight;
            document.getElementById('bmiDisplay').textContent = bmi.toFixed(1);

            if (method === 'both') {
                document.getElementById('navyResult').textContent = navyBF.toFixed(1) + '%';
                document.getElementById('bmiResult').textContent = bmiBF.toFixed(1) + '%';
                document.getElementById('averageResult').textContent = bodyFatPercent.toFixed(1) + '%';
            }

            const weightUnit = unitSystem === 'imperial' ? 'lbs' : 'kg';
            const convertWeight = (lbs) => unitSystem === 'imperial' ? lbs : lbs / 2.20462;
            
            const change10 = weightLbs - target10;
            const change15 = weightLbs - target15;
            const change20 = weightLbs - target20;
            const change25 = weightLbs - target25;
            
            document.getElementById('target10').textContent = change10 > 0 ? 
                `Lose ${convertWeight(change10).toFixed(1)} ${weightUnit}` : 
                `Gain ${convertWeight(Math.abs(change10)).toFixed(1)} ${weightUnit}`;
            document.getElementById('target15').textContent = change15 > 0 ? 
                `Lose ${convertWeight(change15).toFixed(1)} ${weightUnit}` : 
                `Gain ${convertWeight(Math.abs(change15)).toFixed(1)} ${weightUnit}`;
            document.getElementById('target20').textContent = change20 > 0 ? 
                `Lose ${convertWeight(change20).toFixed(1)} ${weightUnit}` : 
                `Gain ${convertWeight(Math.abs(change20)).toFixed(1)} ${weightUnit}`;
            document.getElementById('target25').textContent = change25 > 0 ? 
                `Lose ${convertWeight(change25).toFixed(1)} ${weightUnit}` : 
                `Gain ${convertWeight(Math.abs(change25)).toFixed(1)} ${weightUnit}`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleHipField();
            toggleMethodFields();
            toggleUnitFields();
            calculateBodyFat();
        });
    </script>
</body>
</html>