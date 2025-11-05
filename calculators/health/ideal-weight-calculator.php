<?php
/**
 * Ideal Weight Calculator
 * File: ideal-weight-calculator.php
 * Description: Calculate ideal body weight using multiple formulas (Hamwi, Devine, Robinson, Miller)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ideal Weight Calculator - IBW Calculator (Hamwi, Devine, Robinson, Miller)</title>
    <meta name="description" content="Free ideal weight calculator. Calculate ideal body weight (IBW) using Hamwi, Devine, Robinson, and Miller formulas. Find your target weight goal.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🎯 Ideal Weight Calculator</h1>
        <p>Calculate ideal body weight (IBW)</p>
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
                <form id="idealWeightForm">
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
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Height</h3>
                    
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
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Optional</h3>
                    
                    <div class="form-group" id="currentWeightImperialGroup">
                        <label for="currentWeightLbs">Current Weight (lbs)</label>
                        <input type="number" id="currentWeightLbs" value="180" min="50" max="500" step="0.1">
                        <small>Optional - to see difference from ideal</small>
                    </div>

                    <div class="form-group" id="currentWeightMetricGroup" style="display: none;">
                        <label for="currentWeightKg">Current Weight (kg)</label>
                        <input type="number" id="currentWeightKg" value="82" min="20" max="250" step="0.1">
                        <small>Optional - to see difference from ideal</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Ideal Weight</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Ideal Weight Results</h2>
                
                <div class="result-card success">
                    <h3>Average Ideal Weight</h3>
                    <div class="amount" id="idealWeightResult">160 lbs</div>
                    <div style="margin-top: 10px; font-size: 1em;">Based on 4 formulas</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Hamwi</h4>
                        <div class="value" id="hamwiDisplay">166 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Devine</h4>
                        <div class="value" id="devineDisplay">160 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Robinson</h4>
                        <div class="value" id="robinsonDisplay">162 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Miller</h4>
                        <div class="value" id="millerDisplay">164 lbs</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Information</h3>
                    <div class="breakdown-item">
                        <span>Gender</span>
                        <strong id="genderDisplay">Male</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Height</span>
                        <strong id="heightDisplay">5'10"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Weight</span>
                        <strong id="currentWeightDisplay">180 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Ideal Body Weight (IBW) by Formula</h3>
                    <div class="breakdown-item">
                        <span>Hamwi Formula (1964)</span>
                        <strong id="hamwiWeight" style="color: #667eea;">166 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Devine Formula (1974)</span>
                        <strong id="devineWeight" style="color: #667eea;">160 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Robinson Formula (1983)</span>
                        <strong id="robinsonWeight" style="color: #667eea;">162 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Miller Formula (1983)</span>
                        <strong id="millerWeight" style="color: #667eea;">164 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average (All Formulas)</span>
                        <strong id="averageWeight" style="color: #4CAF50; font-size: 1.1em;">163 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Weight Status</h3>
                    <div class="breakdown-item">
                        <span>Current Weight</span>
                        <strong id="currentStatus">180 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ideal Weight (Average)</span>
                        <strong id="idealStatus" style="color: #4CAF50;">163 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Difference</span>
                        <strong id="weightDifference" style="color: #FF9800;">17 lbs over ideal</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Percentage from Ideal</span>
                        <strong id="percentDiff">+10.4%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Ideal Weight Range</h3>
                    <div class="breakdown-item">
                        <span>Minimum IBW (Devine)</span>
                        <strong id="minIBW">160 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average IBW</span>
                        <strong id="avgIBW" style="color: #4CAF50;">163 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Maximum IBW (Hamwi)</span>
                        <strong id="maxIBW">166 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ideal Weight Range</span>
                        <strong id="ibwRange" style="color: #667eea; font-size: 1.1em;">160-166 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>BMI at Ideal Weight</h3>
                    <div class="breakdown-item">
                        <span>BMI at Hamwi Weight</span>
                        <strong id="hamwiBMI">23.8</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI at Devine Weight</span>
                        <strong id="devineBMI">22.9</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI at Robinson Weight</span>
                        <strong id="robinsonBMI">23.2</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI at Miller Weight</span>
                        <strong id="millerBMI">23.5</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI at Average IBW</span>
                        <strong id="avgBMI" style="color: #4CAF50;">23.4 (Normal)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding IBW Formulas</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Hamwi Formula (1964):</strong> Originally created for calculating drug dosages. Simple and widely used in healthcare.</p>
                        <p>• Men: 106 lbs for first 5 feet + 6 lbs for each additional inch</p>
                        <p>• Women: 100 lbs for first 5 feet + 5 lbs for each additional inch</p>
                        <p><strong>Devine Formula (1974):</strong> Most commonly used in medicine, especially for medication dosing and ventilator settings.</p>
                        <p>• Men: 110 lbs for first 5 feet + 5 lbs for each additional inch</p>
                        <p>• Women: 100.3 lbs for first 5 feet + 5.1 lbs for each additional inch</p>
                        <p><strong>Robinson Formula (1983):</strong> More modern update. Similar to Devine but with updated coefficients.</p>
                        <p>• Men: 114 lbs for first 5 feet + 4 lbs for each additional inch</p>
                        <p>• Women: 108 lbs for first 5 feet + 3.5 lbs for each additional inch</p>
                        <p><strong>Miller Formula (1983):</strong> Another modern formula with slightly different calculations.</p>
                        <p>• Men: 117 lbs for first 5 feet + 4.2 lbs for each additional inch</p>
                        <p>• Women: 111.6 lbs for first 5 feet + 3.7 lbs for each additional inch</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Which Formula is Best?</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>For Medical Use:</strong> Devine formula is standard for medication dosing and clinical calculations.</p>
                        <p><strong>For General Health:</strong> Average of all formulas gives best estimate. All formulas are estimates within ±10%.</p>
                        <p><strong>For Athletes:</strong> IBW formulas don't account for muscle mass. Use body composition instead.</p>
                        <p><strong>Most Accurate:</strong> Combine IBW with BMI (18.5-24.9), body fat percentage, and waist circumference.</p>
                        <p><strong>Historical Context:</strong> All formulas were developed for Caucasian populations. May need adjustment for other ethnicities.</p>
                        <p><strong>Limitations:</strong> Don't account for frame size, muscle mass, age, or ethnicity. Use as starting point, not absolute goal.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Adjusting for Frame Size</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Frame Size Adjustment:</strong> IBW formulas assume medium frame. Adjust ±10% for small/large frames.</p>
                        <p><strong>Small Frame:</strong> IBW - 10% (subtract 16 lbs from 160 lbs = 144 lbs)</p>
                        <p><strong>Medium Frame:</strong> IBW as calculated (160 lbs)</p>
                        <p><strong>Large Frame:</strong> IBW + 10% (add 16 lbs to 160 lbs = 176 lbs)</p>
                        <p><strong>Determine Frame Size (Wrist Method):</strong></p>
                        <p>• Men: Wrist &lt;6.5" = Small, 6.5-7.5" = Medium, &gt;7.5" = Large</p>
                        <p>• Women: Wrist &lt;6" = Small, 6-6.25" = Medium, &gt;6.25" = Large</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Comparison: IBW vs BMI vs Body Fat</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Ideal Body Weight (IBW):</strong></p>
                        <p>• Pros: Quick calculation, used in medicine, gender-specific</p>
                        <p>• Cons: Doesn't account for frame size, muscle mass, age</p>
                        <p><strong>Body Mass Index (BMI):</strong></p>
                        <p>• Pros: Standardized, includes height, easy to calculate</p>
                        <p>• Cons: Doesn't distinguish muscle from fat, same for all ages</p>
                        <p><strong>Body Fat Percentage:</strong></p>
                        <p>• Pros: Most accurate health indicator, distinguishes fat from muscle</p>
                        <p>• Cons: Harder to measure accurately, requires special equipment</p>
                        <p><strong>Best Approach:</strong> Use all three! IBW for target, BMI for tracking, body fat % for health.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>When IBW Doesn't Apply</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Athletes & Bodybuilders:</strong> Muscle weighs more than fat. Can be 20-30 lbs over IBW and still healthy.</p>
                        <p><strong>Elderly:</strong> Some extra weight protective. BMI 23-28 may be healthier than 18.5-24.9.</p>
                        <p><strong>Very Short (&lt;5'0"):</strong> Formulas overestimate. Use BMI or adjust downward.</p>
                        <p><strong>Very Tall (&gt;6'5"):</strong> Formulas may underestimate. Use BMI or adjust upward.</p>
                        <p><strong>Children:</strong> IBW formulas are for adults only. Use pediatric growth charts instead.</p>
                        <p><strong>Pregnant Women:</strong> Weight gain is healthy and necessary. Don't use IBW during pregnancy.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Ideal Weight by Height</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Men (Medium Frame):</strong></p>
                        <p>• 5'0": 106-130 lbs | 5'4": 130-150 lbs | 5'8": 145-170 lbs</p>
                        <p>• 5'10": 160-180 lbs | 6'0": 170-195 lbs | 6'2": 180-205 lbs</p>
                        <p><strong>Women (Medium Frame):</strong></p>
                        <p>• 4'10": 91-115 lbs | 5'0": 100-120 lbs | 5'4": 115-140 lbs</p>
                        <p>• 5'6": 125-150 lbs | 5'8": 135-160 lbs | 5'10": 145-170 lbs</p>
                        <p><strong>Note:</strong> These are estimates based on average of IBW formulas. Individual ideal weight varies by frame size, muscle mass, and body composition.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How to Reach Your Ideal Weight</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>If You Need to Lose Weight:</strong></p>
                        <p>• Safe rate: 1-2 lbs/week (500-1000 cal deficit/day)</p>
                        <p>• Focus on whole foods, portion control, regular exercise</p>
                        <p>• Combine cardio (for calorie burn) + strength training (preserve muscle)</p>
                        <p><strong>If You Need to Gain Weight:</strong></p>
                        <p>• Safe rate: 0.5-1 lb/week (300-500 cal surplus/day)</p>
                        <p>• Eat nutrient-dense foods: nuts, avocados, lean proteins</p>
                        <p>• Strength train to build muscle, not just gain fat</p>
                        <p><strong>If You're Already at Ideal Weight:</strong></p>
                        <p>• Maintain through balanced diet and regular activity</p>
                        <p>• Focus on body composition (muscle vs fat ratio)</p>
                        <p>• Monitor waist circumference and body fat percentage</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>IBW Tips:</strong> IBW = Ideal Body Weight. 4 main formulas: Hamwi, Devine, Robinson, Miller. All give similar results (±5%). Devine most used in medicine. Average all 4 = best estimate. Add ±10% for frame size. Small frame = -10%, Large frame = +10%. IBW doesn't account for muscle mass. Athletes can be 20+ lbs over IBW. Combine IBW + BMI + body fat % for complete picture. Safe weight loss = 1-2 lbs/week. Safe gain = 0.5-1 lb/week. IBW formulas for adults only (18+). Not for pregnant women. Very tall/short may need adjustment. Focus on health, not just hitting exact number!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('idealWeightForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateIdealWeight();
        });

        function toggleUnitFields() {
            const unitSystem = unitSystemSelect.value;
            const isImperial = unitSystem === 'imperial';
            
            document.getElementById('heightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('heightMetricGroup').style.display = isImperial ? 'none' : 'block';
            document.getElementById('currentWeightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('currentWeightMetricGroup').style.display = isImperial ? 'none' : 'block';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateIdealWeight();
        });

        function calculateIdealWeight() {
            const gender = document.getElementById('gender').value;
            const unitSystem = unitSystemSelect.value;
            
            // Get height
            let heightCm;
            if (unitSystem === 'imperial') {
                const feet = parseFloat(document.getElementById('heightFeet').value) || 0;
                const inches = parseFloat(document.getElementById('heightInches').value) || 0;
                const heightInches = (feet * 12) + inches;
                heightCm = heightInches * 2.54;
            } else {
                heightCm = parseFloat(document.getElementById('heightCm').value) || 0;
            }

            const heightInches = heightCm / 2.54;
            const heightM = heightCm / 100;

            // Get current weight
            let currentWeightKg = 0;
            if (unitSystem === 'imperial') {
                const weightLbs = parseFloat(document.getElementById('currentWeightLbs').value) || 0;
                currentWeightKg = weightLbs / 2.20462;
            } else {
                currentWeightKg = parseFloat(document.getElementById('currentWeightKg').value) || 0;
            }

            // Calculate ideal weight using all formulas (in kg)
            let hamwi, devine, robinson, miller;
            
            if (gender === 'male') {
                hamwi = 48 + 2.7 * (heightInches - 60);
                devine = 50 + 2.3 * (heightInches - 60);
                robinson = 52 + 1.9 * (heightInches - 60);
                miller = 53.1 + 1.9 * (heightInches - 60);
            } else {
                hamwi = 45.5 + 2.2 * (heightInches - 60);
                devine = 45.5 + 2.3 * (heightInches - 60);
                robinson = 49 + 1.7 * (heightInches - 60);
                miller = 50.6 + 1.7 * (heightInches - 60);
            }

            // Average of all formulas
            const averageIBW = (hamwi + devine + robinson + miller) / 4;

            // Find min and max
            const allWeights = [hamwi, devine, robinson, miller];
            const minIBW = Math.min(...allWeights);
            const maxIBW = Math.max(...allWeights);

            // Calculate BMI at each IBW
            const hamwiBMI = hamwi / (heightM * heightM);
            const devineBMI = devine / (heightM * heightM);
            const robinsonBMI = robinson / (heightM * heightM);
            const millerBMI = miller / (heightM * heightM);
            const avgBMI = averageIBW / (heightM * heightM);

            // Weight difference
            const weightDiff = currentWeightKg - averageIBW;
            const percentDiff = (weightDiff / averageIBW) * 100;

            // Convert to display units
            const unitLabel = unitSystem === 'imperial' ? 'lbs' : 'kg';
            const toDisplay = (kg) => unitSystem === 'imperial' ? (kg * 2.20462).toFixed(0) : kg.toFixed(1);

            // Display height
            const heightDisplay = unitSystem === 'imperial' ? 
                `${Math.floor(heightInches / 12)}'${(heightInches % 12).toFixed(0)}"` : 
                `${heightCm.toFixed(1)} cm`;

            // Current weight display
            const currentDisplay = currentWeightKg > 0 ? 
                (unitSystem === 'imperial' ? (currentWeightKg * 2.20462).toFixed(1) : currentWeightKg.toFixed(1)) + ` ${unitLabel}` : 
                'Not provided';

            // Analysis
            let analysis = `Based on your height of ${heightDisplay}, your ideal body weight (IBW) ranges from ${toDisplay(minIBW)} to ${toDisplay(maxIBW)} ${unitLabel}. `;
            analysis += `The average of all four formulas (Hamwi, Devine, Robinson, Miller) is ${toDisplay(averageIBW)} ${unitLabel}. `;
            
            if (currentWeightKg > 0) {
                if (Math.abs(weightDiff) < 2) {
                    analysis += `Excellent! Your current weight of ${currentDisplay} is right at your ideal weight. `;
                } else if (weightDiff > 0) {
                    analysis += `Your current weight is ${toDisplay(Math.abs(weightDiff))} ${unitLabel} (${Math.abs(percentDiff).toFixed(1)}%) above your average ideal weight. `;
                    analysis += `To reach your ideal weight, you would need to lose approximately ${toDisplay(Math.abs(weightDiff))} ${unitLabel}. `;
                    analysis += `At a healthy rate of 1-2 lbs per week, this would take about ${Math.ceil(Math.abs(weightDiff * 2.20462) / 1.5)} weeks. `;
                } else {
                    analysis += `Your current weight is ${toDisplay(Math.abs(weightDiff))} ${unitLabel} (${Math.abs(percentDiff).toFixed(1)}%) below your average ideal weight. `;
                    analysis += `To reach your ideal weight, you would need to gain approximately ${toDisplay(Math.abs(weightDiff))} ${unitLabel}. `;
                    analysis += `At a healthy rate of 0.5-1 lb per week, this would take about ${Math.ceil(Math.abs(weightDiff * 2.20462) / 0.75)} weeks. `;
                }
            }
            
            analysis += `At your ideal weight, your BMI would be ${avgBMI.toFixed(1)}, which falls in the healthy range (18.5-24.9). `;
            analysis += `The Devine formula (${toDisplay(devine)} ${unitLabel}) is most commonly used in medical settings for medication dosing. `;
            analysis += `Remember that these formulas provide estimates and don't account for muscle mass, frame size, or body composition. `;
            analysis += `Consider adjusting ±10% for small or large frame size. Athletes may weigh more due to muscle mass while remaining healthy.`;

            // Update UI
            document.getElementById('idealWeightResult').textContent = `${toDisplay(averageIBW)} ${unitLabel}`;
            document.getElementById('hamwiDisplay').textContent = `${toDisplay(hamwi)} ${unitLabel}`;
            document.getElementById('devineDisplay').textContent = `${toDisplay(devine)} ${unitLabel}`;
            document.getElementById('robinsonDisplay').textContent = `${toDisplay(robinson)} ${unitLabel}`;
            document.getElementById('millerDisplay').textContent = `${toDisplay(miller)} ${unitLabel}`;

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('heightDisplay').textContent = heightDisplay;
            document.getElementById('currentWeightDisplay').textContent = currentDisplay;

            document.getElementById('hamwiWeight').textContent = `${toDisplay(hamwi)} ${unitLabel}`;
            document.getElementById('devineWeight').textContent = `${toDisplay(devine)} ${unitLabel}`;
            document.getElementById('robinsonWeight').textContent = `${toDisplay(robinson)} ${unitLabel}`;
            document.getElementById('millerWeight').textContent = `${toDisplay(miller)} ${unitLabel}`;
            document.getElementById('averageWeight').textContent = `${toDisplay(averageIBW)} ${unitLabel}`;

            document.getElementById('currentStatus').textContent = currentDisplay;
            document.getElementById('idealStatus').textContent = `${toDisplay(averageIBW)} ${unitLabel}`;
            
            if (currentWeightKg > 0) {
                let diffText = '';
                let diffColor = '';
                if (Math.abs(weightDiff) < 2) {
                    diffText = 'At ideal weight!';
                    diffColor = '#4CAF50';
                } else if (weightDiff > 0) {
                    diffText = `${toDisplay(Math.abs(weightDiff))} ${unitLabel} over ideal`;
                    diffColor = '#FF9800';
                } else {
                    diffText = `${toDisplay(Math.abs(weightDiff))} ${unitLabel} under ideal`;
                    diffColor = '#2196F3';
                }
                document.getElementById('weightDifference').textContent = diffText;
                document.getElementById('weightDifference').style.color = diffColor;
                document.getElementById('percentDiff').textContent = (weightDiff >= 0 ? '+' : '') + percentDiff.toFixed(1) + '%';
            } else {
                document.getElementById('weightDifference').textContent = 'Enter current weight';
                document.getElementById('percentDiff').textContent = 'N/A';
            }

            document.getElementById('minIBW').textContent = `${toDisplay(minIBW)} ${unitLabel}`;
            document.getElementById('avgIBW').textContent = `${toDisplay(averageIBW)} ${unitLabel}`;
            document.getElementById('maxIBW').textContent = `${toDisplay(maxIBW)} ${unitLabel}`;
            document.getElementById('ibwRange').textContent = `${toDisplay(minIBW)}-${toDisplay(maxIBW)} ${unitLabel}`;

            document.getElementById('hamwiBMI').textContent = hamwiBMI.toFixed(1);
            document.getElementById('devineBMI').textContent = devineBMI.toFixed(1);
            document.getElementById('robinsonBMI').textContent = robinsonBMI.toFixed(1);
            document.getElementById('millerBMI').textContent = millerBMI.toFixed(1);
            document.getElementById('avgBMI').textContent = `${avgBMI.toFixed(1)} (Normal)`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateIdealWeight();
        });
    </script>
</body>
</html>