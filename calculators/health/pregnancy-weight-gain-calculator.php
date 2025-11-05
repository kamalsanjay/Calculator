<?php
/**
 * Pregnancy Weight Gain Calculator
 * File: pregnancy-weight-gain-calculator.php
 * Description: Calculate healthy pregnancy weight gain based on pre-pregnancy BMI
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregnancy Weight Gain Calculator - Healthy Weight Gain During Pregnancy</title>
    <meta name="description" content="Free pregnancy weight gain calculator. Calculate healthy weight gain range based on pre-pregnancy BMI. Track weekly and trimester weight goals.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🤰 Pregnancy Weight Gain Calculator</h1>
        <p>Calculate healthy weight gain range</p>
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
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="imperial">Imperial (lbs/inches)</option>
                            <option value="metric">Metric (kg/cm)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Pre-Pregnancy Information</h3>
                    
                    <div class="form-group" id="heightImperialGroup">
                        <label for="heightFeet">Height</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="heightFeet" value="5" min="3" max="8" step="1" style="flex: 1;" placeholder="Feet">
                            <input type="number" id="heightInches" value="5" min="0" max="11" step="1" style="flex: 1;" placeholder="Inches">
                        </div>
                    </div>

                    <div class="form-group" id="heightMetricGroup" style="display: none;">
                        <label for="heightCm">Height (cm)</label>
                        <input type="number" id="heightCm" value="165" min="100" max="250" step="0.1">
                    </div>
                    
                    <div class="form-group" id="weightImperialGroup">
                        <label for="preWeightLbs">Pre-Pregnancy Weight (lbs)</label>
                        <input type="number" id="preWeightLbs" value="140" min="70" max="400" step="0.1" required>
                        <small>Weight before pregnancy</small>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="preWeightKg">Pre-Pregnancy Weight (kg)</label>
                        <input type="number" id="preWeightKg" value="64" min="30" max="200" step="0.1">
                        <small>Weight before pregnancy</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Current Pregnancy</h3>
                    
                    <div class="form-group">
                        <label for="pregnancyType">Pregnancy Type</label>
                        <select id="pregnancyType">
                            <option value="single">Single Baby (Singleton)</option>
                            <option value="twins">Twins</option>
                            <option value="triplets">Triplets or More</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentWeek">Current Week of Pregnancy</label>
                        <input type="number" id="currentWeek" value="20" min="0" max="42" step="1">
                        <small>How many weeks pregnant are you?</small>
                    </div>
                    
                    <div class="form-group" id="currentWeightImperialGroup">
                        <label for="currentWeightLbs">Current Weight (lbs) - Optional</label>
                        <input type="number" id="currentWeightLbs" value="" min="70" max="400" step="0.1">
                        <small>Your current weight (leave blank if unknown)</small>
                    </div>

                    <div class="form-group" id="currentWeightMetricGroup" style="display: none;">
                        <label for="currentWeightKg">Current Weight (kg) - Optional</label>
                        <input type="number" id="currentWeightKg" value="" min="30" max="200" step="0.1">
                        <small>Your current weight (leave blank if unknown)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Weight Gain</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Weight Gain Results</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Recommended Total Gain</h3>
                    <div class="amount" id="weightGainResult">25 - 35 lbs</div>
                    <div style="margin-top: 10px; font-size: 1em;" id="bmiCategory">Normal Weight (BMI 21.5)</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Range</h4>
                        <div class="value" id="totalRangeDisplay">25-35 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Gained So Far</h4>
                        <div class="value" id="gainedDisplay">10 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Still to Gain</h4>
                        <div class="value" id="remainingDisplay">15-25 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Weekly Rate</h4>
                        <div class="value" id="weeklyRateDisplay">1 lb/wk</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Information</h3>
                    <div class="breakdown-item">
                        <span>Pre-Pregnancy Weight</span>
                        <strong id="preWeightDisplay">140 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Height</span>
                        <strong id="heightDisplay">5'5"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pre-Pregnancy BMI</span>
                        <strong id="bmiDisplay" style="color: #667eea;">23.3</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI Category</span>
                        <strong id="bmiCat" style="color: #4CAF50;">Normal Weight</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pregnancy Type</span>
                        <strong id="pregnancyTypeDisplay">Single Baby</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Week</span>
                        <strong id="weekDisplay">Week 20</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Recommended Weight Gain</h3>
                    <div class="breakdown-item">
                        <span>Total Gain (Full Pregnancy)</span>
                        <strong id="totalGain" style="color: #E91E63; font-size: 1.1em;">25 - 35 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>First Trimester (0-13 weeks)</span>
                        <strong id="trim1Gain">2 - 4 lbs total</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Second Trimester (14-27 weeks)</span>
                        <strong id="trim2Gain">12 - 14 lbs (1 lb/week)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Third Trimester (28-40 weeks)</span>
                        <strong id="trim3Gain">11 - 17 lbs (1 lb/week)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekly Rate (2nd/3rd Trimester)</span>
                        <strong id="weeklyRate" style="color: #FF9800;">1.0 lb/week</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Your Current Progress</h3>
                    <div class="breakdown-item">
                        <span>Current Weight</span>
                        <strong id="currentWeightDisplay">150 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight Gained So Far</span>
                        <strong id="gainedSoFar" style="color: #4CAF50;">10 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>On Track?</span>
                        <strong id="onTrack" style="color: #4CAF50;">Yes - Within Range</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Expected at This Week</span>
                        <strong id="expectedNow">11 - 16 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Still to Gain (Min)</span>
                        <strong id="remainingMin">15 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Still to Gain (Max)</span>
                        <strong id="remainingMax">25 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Weight Gain by BMI Category</h3>
                    <div class="breakdown-item">
                        <span>Underweight (BMI &lt;18.5)</span>
                        <strong style="color: #2196F3;">28 - 40 lbs (Singles) | 50-62 lbs (Twins)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Normal Weight (BMI 18.5-24.9)</span>
                        <strong style="color: #4CAF50;">25 - 35 lbs (Singles) | 37-54 lbs (Twins)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Overweight (BMI 25-29.9)</span>
                        <strong style="color: #FF9800;">15 - 25 lbs (Singles) | 31-50 lbs (Twins)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Obese (BMI ≥30)</span>
                        <strong style="color: #f44336;">11 - 20 lbs (Singles) | 25-42 lbs (Twins)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Where Does the Weight Go?</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Average 30 lb Weight Gain Breakdown:</strong></p>
                        <p>• Baby: 7-8 lbs</p>
                        <p>• Placenta: 1-2 lbs</p>
                        <p>• Amniotic fluid: 2 lbs</p>
                        <p>• Uterus growth: 2 lbs</p>
                        <p>• Breast tissue: 2 lbs</p>
                        <p>• Blood volume: 4 lbs</p>
                        <p>• Body fluids: 4 lbs</p>
                        <p>• Maternal fat stores: 7-8 lbs</p>
                        <p><strong>Total:</strong> ~30 lbs of necessary pregnancy changes. Most is baby, fluids, and temporary tissues - not just "extra weight."</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Pregnancy Weight Gain</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Why Gain Weight?</strong> Essential for healthy baby development. Supports baby, placenta, amniotic fluid, maternal tissues. Prepares body for breastfeeding.</p>
                        <p><strong>First Trimester (1-13 weeks):</strong> Minimal gain - 2-4 lbs total. Morning sickness may cause weight loss (normal if &lt;5 lbs). Slow, gradual gain.</p>
                        <p><strong>Second Trimester (14-27 weeks):</strong> Steady gain - ~1 lb/week. Energy returns, appetite increases. Baby growing rapidly. Most women gain 12-14 lbs this trimester.</p>
                        <p><strong>Third Trimester (28-40 weeks):</strong> Continued gain - ~1 lb/week. Baby gaining weight. Some women gain less toward end. 11-17 lbs typical this trimester.</p>
                        <p><strong>Guidelines Based on BMI:</strong> Underweight women need more weight gain for healthy baby. Overweight/obese women need less but still must gain. Individual variation normal.</p>
                        <p><strong>Twins/Multiples:</strong> Higher weight gain needed. 37-54 lbs for normal BMI with twins. More calories, more growth, more fluid.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Healthy Weight Gain Tips</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Eat Nutrient-Dense Foods:</strong> Focus on quality over quantity. Lean proteins, whole grains, fruits, vegetables, dairy, healthy fats.</p>
                        <p>&#10003; <strong>Extra Calories (2nd/3rd Trimester):</strong> Need only 300-500 extra calories/day. Not "eating for two" - more like "eating for 1.2." Quality matters.</p>
                        <p>&#10003; <strong>Balanced Meals:</strong> Protein, complex carbs, healthy fats each meal. Prevents blood sugar spikes. Keeps you satisfied longer.</p>
                        <p>&#10003; <strong>Frequent Small Meals:</strong> 5-6 small meals vs 3 large. Reduces nausea, heartburn. Maintains stable energy.</p>
                        <p>&#10003; <strong>Stay Hydrated:</strong> 8-12 glasses water daily. Reduces swelling, constipation. Supports increased blood volume.</p>
                        <p>&#10003; <strong>Regular Exercise:</strong> 30 min moderate activity most days. Walking, swimming, prenatal yoga. Maintains fitness, controls weight gain.</p>
                        <p>&#10003; <strong>Avoid Empty Calories:</strong> Limit sweets, sodas, fast food. Provide little nutrition. Easy to over-consume.</p>
                        <p>&#10003; <strong>Don't Diet:</strong> Never restrict calories while pregnant. Can harm baby development. Talk to doctor if concerned about gain.</p>
                        <p>&#10003; <strong>Track Weekly:</strong> Weigh yourself same time/day each week. Provides trends. Don't obsess over daily fluctuations.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Too Much or Too Little Weight Gain</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Gaining Too Much Weight (Above Range):</strong></p>
                        <p>• Risks: Gestational diabetes, high blood pressure, large baby, C-section, harder postpartum weight loss</p>
                        <p>• What to Do: Don't diet. Focus on healthy foods, portion control, regular activity. Consult doctor/nutritionist.</p>
                        <p>• Avoid: Skipping meals, drastic cuts, fad diets. Never safe during pregnancy.</p>
                        <p><strong>Gaining Too Little Weight (Below Range):</strong></p>
                        <p>• Risks: Low birth weight baby, preterm birth, developmental delays, nutrient deficiencies</p>
                        <p>• What to Do: Eat more frequently, calorie-dense healthy foods (nuts, avocados, whole milk), nutritional shakes. See doctor.</p>
                        <p>• Avoid: Continuing to restrict. Baby needs adequate nutrition for development.</p>
                        <p><strong>Sudden Changes:</strong> Rapid gain (5+ lbs/week) or weight loss - contact doctor immediately. May indicate preeclampsia, gestational diabetes, or other complications.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Postpartum Weight Loss</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Immediate Loss (Birth):</strong> 12-15 lbs lost instantly (baby, placenta, amniotic fluid). Rapid initial weight loss.</p>
                        <p><strong>First Week:</strong> Additional 5-10 lbs lost (excess fluids, blood volume). Water weight reduction.</p>
                        <p><strong>6 Weeks Postpartum:</strong> Most women lost 15-20 lbs total. Still have 5-15 lbs from fat stores.</p>
                        <p><strong>6 Months - 1 Year:</strong> Gradual return to pre-pregnancy weight. Breastfeeding helps (burns 500 cal/day). Exercise safe after clearance.</p>
                        <p><strong>Be Patient:</strong> Took 9 months to gain, takes 9-12 months to lose. Body needs recovery time. Hormones readjusting.</p>
                        <p><strong>Breastfeeding Benefit:</strong> Burns extra 300-500 cal/day. Helps uterus contract. May accelerate loss but still need time.</p>
                        <p><strong>Realistic Expectations:</strong> Body may look different. Belly skin stretched. Hip/rib cage widened. All normal. Focus on health, not just numbers.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Pregnancy Weight Tips:</strong> Gain based on pre-pregnancy BMI. Normal BMI: 25-35 lbs. Underweight: 28-40 lbs. Overweight: 15-25 lbs. Obese: 11-20 lbs. Twins: add 12-20 lbs more. First trimester: 2-4 lbs total. 2nd/3rd: 1 lb/week. Need only 300 extra cal/day. Don't "eat for two." Focus on nutrient-dense foods. Exercise 30 min/day. Drink 8-12 glasses water. Track weekly, not daily. Never diet while pregnant. Too much gain = GD, high BP risk. Too little = low birth weight. Sudden changes - call doctor. Postpartum: lose 15-20 lbs first 6 weeks. Rest gradually over year. Breastfeeding helps (burns 500 cal/day). Be patient with your body!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('weightForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateWeightGain();
        });

        function toggleUnitFields() {
            const unitSystem = unitSystemSelect.value;
            const isImperial = unitSystem === 'imperial';
            
            document.getElementById('heightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('heightMetricGroup').style.display = isImperial ? 'none' : 'block';
            document.getElementById('weightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('weightMetricGroup').style.display = isImperial ? 'none' : 'block';
            document.getElementById('currentWeightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('currentWeightMetricGroup').style.display = isImperial ? 'none' : 'block';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateWeightGain();
        });

        function calculateWeightGain() {
            const unitSystem = unitSystemSelect.value;
            const pregnancyType = document.getElementById('pregnancyType').value;
            const currentWeek = parseInt(document.getElementById('currentWeek').value) || 20;
            
            // Get measurements
            let heightCm, preWeightKg, currentWeightKg;
            
            if (unitSystem === 'imperial') {
                const feet = parseFloat(document.getElementById('heightFeet').value) || 0;
                const inches = parseFloat(document.getElementById('heightInches').value) || 0;
                const heightInches = (feet * 12) + inches;
                heightCm = heightInches * 2.54;
                
                const preWeightLbs = parseFloat(document.getElementById('preWeightLbs').value) || 140;
                preWeightKg = preWeightLbs / 2.20462;
                
                const currentWeightLbs = parseFloat(document.getElementById('currentWeightLbs').value);
                currentWeightKg = currentWeightLbs ? currentWeightLbs / 2.20462 : null;
            } else {
                heightCm = parseFloat(document.getElementById('heightCm').value) || 165;
                preWeightKg = parseFloat(document.getElementById('preWeightKg').value) || 64;
                currentWeightKg = parseFloat(document.getElementById('currentWeightKg').value) || null;
            }

            // Calculate BMI
            const heightM = heightCm / 100;
            const bmi = preWeightKg / (heightM * heightM);

            // Determine BMI category and weight gain recommendations
            let bmiCategory = '';
            let bmiColor = '';
            let cardClass = 'success';
            let minGain, maxGain, weeklyRate;
            
            if (pregnancyType === 'single') {
                if (bmi < 18.5) {
                    bmiCategory = 'Underweight';
                    bmiColor = '#2196F3';
                    minGain = 28;
                    maxGain = 40;
                    weeklyRate = 1.0;
                } else if (bmi < 25) {
                    bmiCategory = 'Normal Weight';
                    bmiColor = '#4CAF50';
                    minGain = 25;
                    maxGain = 35;
                    weeklyRate = 1.0;
                } else if (bmi < 30) {
                    bmiCategory = 'Overweight';
                    bmiColor = '#FF9800';
                    cardClass = 'info';
                    minGain = 15;
                    maxGain = 25;
                    weeklyRate = 0.6;
                } else {
                    bmiCategory = 'Obese';
                    bmiColor = '#f44336';
                    cardClass = 'warning';
                    minGain = 11;
                    maxGain = 20;
                    weeklyRate = 0.5;
                }
            } else if (pregnancyType === 'twins') {
                if (bmi < 18.5) {
                    bmiCategory = 'Underweight';
                    bmiColor = '#2196F3';
                    minGain = 50;
                    maxGain = 62;
                    weeklyRate = 1.5;
                } else if (bmi < 25) {
                    bmiCategory = 'Normal Weight';
                    bmiColor = '#4CAF50';
                    minGain = 37;
                    maxGain = 54;
                    weeklyRate = 1.5;
                } else if (bmi < 30) {
                    bmiCategory = 'Overweight';
                    bmiColor = '#FF9800';
                    cardClass = 'info';
                    minGain = 31;
                    maxGain = 50;
                    weeklyRate = 1.2;
                } else {
                    bmiCategory = 'Obese';
                    bmiColor = '#f44336';
                    cardClass = 'warning';
                    minGain = 25;
                    maxGain = 42;
                    weeklyRate = 1.0;
                }
            } else {
                // Triplets
                bmiCategory = bmi < 25 ? 'Normal Weight' : bmi < 30 ? 'Overweight' : 'Obese';
                bmiColor = bmi < 25 ? '#4CAF50' : bmi < 30 ? '#FF9800' : '#f44336';
                cardClass = bmi < 30 ? 'info' : 'warning';
                minGain = 50;
                maxGain = 60;
                weeklyRate = 1.5;
            }

            // Convert to display units
            const unitLabel = unitSystem === 'imperial' ? 'lbs' : 'kg';
            const toDisplay = (lbs) => {
                const value = unitSystem === 'imperial' ? lbs : lbs / 2.20462;
                return value.toFixed(1);
            };

            const minGainDisplay = toDisplay(minGain);
            const maxGainDisplay = toDisplay(maxGain);
            const weeklyRateDisplay = toDisplay(weeklyRate);

            // Trimester breakdown
            const trim1Min = toDisplay(bmi < 30 ? 2 : 1);
            const trim1Max = toDisplay(bmi < 30 ? 4 : 3);
            
            // Calculate expected gain at current week
            let expectedMin, expectedMax;
            if (currentWeek <= 13) {
                expectedMin = parseFloat(trim1Min);
                expectedMax = parseFloat(trim1Max);
            } else {
                const weeksAfterFirst = currentWeek - 13;
                expectedMin = parseFloat(trim1Min) + (weeksAfterFirst * weeklyRate / 2.20462 * (unitSystem === 'imperial' ? 2.20462 : 1));
                expectedMax = parseFloat(trim1Max) + (weeksAfterFirst * weeklyRate * 1.2 / 2.20462 * (unitSystem === 'imperial' ? 2.20462 : 1));
            }

            // Current progress
            let gainedSoFar = 0;
            let currentWeight = 0;
            let onTrack = 'Enter current weight to track';
            let onTrackColor = '#999';
            
            if (currentWeightKg) {
                currentWeight = currentWeightKg;
                gainedSoFar = currentWeightKg - preWeightKg;
                const gainedDisplay = gainedSoFar * (unitSystem === 'imperial' ? 2.20462 : 1);
                
                if (gainedDisplay >= expectedMin && gainedDisplay <= expectedMax) {
                    onTrack = 'Yes - Within Range ✓';
                    onTrackColor = '#4CAF50';
                } else if (gainedDisplay < expectedMin) {
                    onTrack = 'Below Range - Gaining Too Slowly';
                    onTrackColor = '#FF9800';
                } else {
                    onTrack = 'Above Range - Gaining Too Quickly';
                    onTrackColor = '#f44336';
                }
            } else {
                currentWeight = preWeightKg;
            }

            // Remaining to gain
            const minGainKg = minGain / 2.20462;
            const maxGainKg = maxGain / 2.20462;
            const remainingMin = Math.max(0, minGainKg - gainedSoFar);
            const remainingMax = Math.max(0, maxGainKg - gainedSoFar);

            // Display measurements
            const heightDisplay = unitSystem === 'imperial' ? 
                `${Math.floor((heightCm / 2.54) / 12)}'${((heightCm / 2.54) % 12).toFixed(0)}"` : 
                `${heightCm.toFixed(1)} cm`;
            const preWeightDisplay = toDisplay(preWeightKg * 2.20462);
            const currentWeightDisplay = toDisplay(currentWeight * 2.20462);
            const gainedDisplay = toDisplay(gainedSoFar * 2.20462);

            // Pregnancy type name
            const pregnancyTypeName = pregnancyType === 'single' ? 'Single Baby' : 
                                      pregnancyType === 'twins' ? 'Twins' : 'Triplets or More';

            // Analysis
            let analysis = `Based on your pre-pregnancy BMI of ${bmi.toFixed(1)} (${bmiCategory}), `;
            analysis += `your recommended total weight gain for a ${pregnancyTypeName.toLowerCase()} pregnancy is ${minGainDisplay}-${maxGainDisplay} ${unitLabel}. `;
            
            analysis += `You are currently at week ${currentWeek} of your pregnancy. `;
            
            if (currentWeek <= 13) {
                analysis += `During the first trimester (weeks 1-13), aim to gain ${trim1Min}-${trim1Max} ${unitLabel} total. Weight gain is typically minimal during this time due to morning sickness and the baby's small size. `;
            } else if (currentWeek <= 27) {
                analysis += `During the second trimester (weeks 14-27), aim to gain approximately ${weeklyRateDisplay} ${unitLabel} per week. This is when steady weight gain begins as your baby grows rapidly and your appetite typically improves. `;
            } else {
                analysis += `During the third trimester (weeks 28-40), continue gaining approximately ${weeklyRateDisplay} ${unitLabel} per week. Some women's weight gain slows near the end of pregnancy, which is normal. `;
            }
            
            if (currentWeightKg) {
                analysis += `You have gained ${gainedDisplay} ${unitLabel} so far, and your current weight is ${currentWeightDisplay} ${unitLabel}. `;
                analysis += `At ${currentWeek} weeks, expected weight gain is ${expectedMin.toFixed(1)}-${expectedMax.toFixed(1)} ${unitLabel}. `;
                
                if (onTrack.includes('Within Range')) {
                    analysis += `Your weight gain is on track! Continue with your current healthy eating and exercise habits. `;
                } else if (onTrack.includes('Below')) {
                    analysis += `You're gaining below the recommended range. Ensure you're eating enough nutrient-dense foods and discuss with your healthcare provider. Baby needs adequate nutrition. `;
                } else if (onTrack.includes('Above')) {
                    analysis += `You're gaining above the recommended range. Focus on healthy foods, watch portion sizes, and stay active. Don't diet, but be mindful. Consult your provider. `;
                }
                
                analysis += `You still need to gain ${toDisplay(remainingMin * 2.20462)}-${toDisplay(remainingMax * 2.20462)} ${unitLabel} to reach the recommended range. `;
            } else {
                analysis += `Track your weight weekly to monitor progress. At week ${currentWeek}, you should have gained approximately ${expectedMin.toFixed(1)}-${expectedMax.toFixed(1)} ${unitLabel}. `;
            }
            
            analysis += `Focus on eating nutrient-dense foods, staying hydrated, exercising regularly (30 minutes most days), and attending all prenatal appointments. `;
            analysis += `Remember, these are guidelines, not rules. Individual variation is normal. Your healthcare provider may recommend different targets based on your specific situation.`;

            // Update UI
            const card = document.getElementById('resultCard');
            card.className = 'result-card ' + cardClass;

            document.getElementById('weightGainResult').textContent = `${minGainDisplay} - ${maxGainDisplay} ${unitLabel}`;
            document.getElementById('bmiCategory').textContent = `${bmiCategory} (BMI ${bmi.toFixed(1)})`;
            document.getElementById('totalRangeDisplay').textContent = `${minGainDisplay}-${maxGainDisplay} ${unitLabel}`;
            document.getElementById('gainedDisplay').textContent = currentWeightKg ? `${gainedDisplay} ${unitLabel}` : 'N/A';
            document.getElementById('remainingDisplay').textContent = currentWeightKg ? 
                `${toDisplay(remainingMin * 2.20462)}-${toDisplay(remainingMax * 2.20462)} ${unitLabel}` : 
                `${minGainDisplay}-${maxGainDisplay} ${unitLabel}`;
            document.getElementById('weeklyRateDisplay').textContent = `${weeklyRateDisplay} ${unitLabel}/wk`;

            document.getElementById('preWeightDisplay').textContent = `${preWeightDisplay} ${unitLabel}`;
            document.getElementById('heightDisplay').textContent = heightDisplay;
            document.getElementById('bmiDisplay').textContent = bmi.toFixed(1);
            document.getElementById('bmiCat').textContent = bmiCategory;
            document.getElementById('bmiCat').style.color = bmiColor;
            document.getElementById('pregnancyTypeDisplay').textContent = pregnancyTypeName;
            document.getElementById('weekDisplay').textContent = `Week ${currentWeek}`;

            document.getElementById('totalGain').textContent = `${minGainDisplay} - ${maxGainDisplay} ${unitLabel}`;
            document.getElementById('trim1Gain').textContent = `${trim1Min} - ${trim1Max} ${unitLabel} total`;
            document.getElementById('trim2Gain').textContent = `12 - 14 ${unitLabel} (${weeklyRateDisplay} ${unitLabel}/week)`;
            document.getElementById('trim3Gain').textContent = `11 - 17 ${unitLabel} (${weeklyRateDisplay} ${unitLabel}/week)`;
            document.getElementById('weeklyRate').textContent = `${weeklyRateDisplay} ${unitLabel}/week`;

            document.getElementById('currentWeightDisplay').textContent = currentWeightKg ? `${currentWeightDisplay} ${unitLabel}` : 'Not entered';
            document.getElementById('gainedSoFar').textContent = currentWeightKg ? `${gainedDisplay} ${unitLabel}` : 'N/A';
            document.getElementById('onTrack').textContent = onTrack;
            document.getElementById('onTrack').style.color = onTrackColor;
            document.getElementById('expectedNow').textContent = `${expectedMin.toFixed(1)} - ${expectedMax.toFixed(1)} ${unitLabel}`;
            document.getElementById('remainingMin').textContent = currentWeightKg ? `${toDisplay(remainingMin * 2.20462)} ${unitLabel}` : `${minGainDisplay} ${unitLabel}`;
            document.getElementById('remainingMax').textContent = currentWeightKg ? `${toDisplay(remainingMax * 2.20462)} ${unitLabel}` : `${maxGainDisplay} ${unitLabel}`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateWeightGain();
        });
    </script>
</body>
</html>