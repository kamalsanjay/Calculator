<?php
/**
 * Lean Body Mass Calculator
 * File: lean-body-mass-calculator.php
 * Description: Calculate lean body mass, body fat mass, and body composition
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lean Body Mass Calculator - LBM & Body Composition Calculator</title>
    <meta name="description" content="Free lean body mass calculator. Calculate LBM, fat mass, body fat percentage, and body composition using Boer, James, and Hume formulas.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>💪 Lean Body Mass Calculator</h1>
        <p>Calculate lean mass & body composition</p>
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
                <form id="lbmForm">
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
                        <label for="weightLbs">Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="180" min="50" max="500" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="82" min="20" max="250" step="0.1">
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Body Fat (Optional)</h3>
                    
                    <div class="form-group">
                        <label for="bodyFat">Body Fat Percentage (%)</label>
                        <input type="number" id="bodyFat" value="" min="3" max="60" step="0.1" placeholder="Optional">
                        <small>If known, enter for more accurate calculations</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Lean Body Mass</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Lean Body Mass Results</h2>
                
                <div class="result-card success">
                    <h3>Lean Body Mass (LBM)</h3>
                    <div class="amount" id="lbmResult">150 lbs</div>
                    <div style="margin-top: 10px; font-size: 1em;">Muscle, bone, organs, water</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Lean Mass</h4>
                        <div class="value" id="lbmDisplay">150 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Fat Mass</h4>
                        <div class="value" id="fatMassDisplay">30 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Body Fat %</h4>
                        <div class="value" id="bodyFatDisplay">16.7%</div>
                    </div>
                    <div class="metric-card">
                        <h4>FFM Index</h4>
                        <div class="value" id="ffmiDisplay">20.5</div>
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
                        <span>Total Body Weight</span>
                        <strong id="weightDisplay">180 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI</span>
                        <strong id="bmiDisplay">25.8</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Body Composition Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Total Weight</span>
                        <strong id="totalWeight">180 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lean Body Mass (LBM)</span>
                        <strong id="lbmValue" style="color: #4CAF50; font-size: 1.1em;">150 lbs (83.3%)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fat Mass</span>
                        <strong id="fatMassValue" style="color: #FF9800;">30 lbs (16.7%)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Body Fat Percentage</span>
                        <strong id="bodyFatPercent" style="color: #667eea; font-size: 1.1em;">16.7%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>LBM by Formula</h3>
                    <div class="breakdown-item">
                        <span>Boer Formula</span>
                        <strong id="boerLBM" style="color: #667eea;">152 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>James Formula</span>
                        <strong id="jamesLBM" style="color: #667eea;">149 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hume Formula</span>
                        <strong id="humeLBM" style="color: #667eea;">151 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average (All Formulas)</span>
                        <strong id="avgLBM" style="color: #4CAF50; font-size: 1.1em;">150.7 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Fat-Free Mass Index (FFMI)</h3>
                    <div class="breakdown-item">
                        <span>FFMI</span>
                        <strong id="ffmi" style="color: #667eea; font-size: 1.1em;">20.5</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Normalized FFMI (at 5'10")</span>
                        <strong id="normalizedFFMI">20.5</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>FFMI Category</span>
                        <strong id="ffmiCategory" style="color: #4CAF50;">Above Average</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Natural Limit Estimate</span>
                        <strong id="naturalLimit">25-26 FFMI</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Body Fat Categories</h3>
                    <div class="breakdown-item">
                        <span>Men - Essential Fat</span>
                        <strong style="color: #2196F3;">2-5%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Men - Athletes</span>
                        <strong style="color: #4CAF50;">6-13%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Men - Fitness</span>
                        <strong style="color: #4CAF50;">14-17%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Men - Average</span>
                        <strong style="color: #FF9800;">18-24%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Men - Obese</span>
                        <strong style="color: #f44336;">25%+</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Women - Essential Fat</span>
                        <strong style="color: #2196F3;">10-13%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Women - Athletes</span>
                        <strong style="color: #4CAF50;">14-20%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Women - Fitness</span>
                        <strong style="color: #4CAF50;">21-24%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Women - Average</span>
                        <strong style="color: #FF9800;">25-31%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Women - Obese</span>
                        <strong style="color: #f44336;">32%+</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Lean Body Mass</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Lean Body Mass (LBM):</strong> Total body weight minus fat mass. Includes muscle, bone, organs, water, connective tissue.</p>
                        <p><strong>Fat-Free Mass (FFM):</strong> Essentially same as LBM. Sometimes excludes essential fat, but terms often used interchangeably.</p>
                        <p><strong>Body Fat Mass:</strong> Total weight of fat in body. Includes essential fat (needed for life) and storage fat.</p>
                        <p><strong>Why LBM Matters:</strong> Better predictor of metabolic rate than total weight. Higher LBM = higher metabolism, more calories burned at rest.</p>
                        <p><strong>LBM vs Muscle:</strong> LBM ≠ pure muscle. Muscle is ~50-60% of LBM. Rest is bone, organs, water.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>LBM Calculation Formulas</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Boer Formula (1984):</strong> Most widely used, based on anthropometric measurements.</p>
                        <p>• Men: LBM = 0.407 × weight + 0.267 × height - 19.2</p>
                        <p>• Women: LBM = 0.252 × weight + 0.473 × height - 48.3</p>
                        <p><strong>James Formula (1976):</strong> Earlier formula, still commonly referenced.</p>
                        <p>• Men: LBM = 1.1 × weight - 128 × (weight²/(height²))</p>
                        <p>• Women: LBM = 1.07 × weight - 148 × (weight²/(height²))</p>
                        <p><strong>Hume Formula (1966):</strong> Original LBM formula, medical applications.</p>
                        <p>• Men: LBM = 0.32810 × weight + 0.33929 × height - 29.5336</p>
                        <p>• Women: LBM = 0.29569 × weight + 0.41813 × height - 43.2933</p>
                        <p><strong>If Body Fat % Known:</strong> LBM = Weight × (1 - Body Fat %/100) [Most Accurate]</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Fat-Free Mass Index (FFMI)</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>What is FFMI?</strong> Like BMI but for lean mass. Adjusts LBM for height. Better indicator of muscularity than weight or BMI.</p>
                        <p><strong>Formula:</strong> FFMI = LBM (kg) / Height² (m)</p>
                        <p><strong>FFMI Categories:</strong></p>
                        <p>• 16-17: Below Average (untrained)</p>
                        <p>• 18-19: Average (recreationally active)</p>
                        <p>• 20-21: Above Average (regular training)</p>
                        <p>• 22-23: Excellent (serious lifter)</p>
                        <p>• 24-25: Superior (elite natural bodybuilder)</p>
                        <p>• 26+: Likely enhanced (steroids suspected)</p>
                        <p><strong>Natural Limit:</strong> ~25-26 FFMI for men, ~22-23 for women (without PEDs). Genetics play role.</p>
                        <p><strong>Normalized FFMI:</strong> Adjusted to 5'10" height for fair comparison across heights.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How to Measure Body Fat %</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>DEXA Scan (Gold Standard):</strong> ±1-2% accuracy. X-ray technology. Shows exact fat/muscle/bone. $50-150.</p>
                        <p><strong>Hydrostatic Weighing:</strong> ±2-3% accuracy. Underwater weighing. Very accurate. $50-100. Less common.</p>
                        <p><strong>Bod Pod:</strong> ±2-3% accuracy. Air displacement. Quick, accurate. $40-75. Available at universities/clinics.</p>
                        <p><strong>Skinfold Calipers:</strong> ±3-5% accuracy (if done correctly). Cheap ($10-30). Requires skill. 3, 7, or 9-site measurements.</p>
                        <p><strong>BIA Scale:</strong> ±3-8% accuracy. Electrical impedance. Convenient ($30-200). Affected by hydration. Home option.</p>
                        <p><strong>Visual Estimate:</strong> ±5-10% accuracy. Compare photos. Free but subjective.</p>
                        <p><strong>Best Option:</strong> DEXA scan once, then track progress with calipers/photos/measurements.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Building Lean Mass</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Progressive Overload:</strong> Gradually increase weight, reps, or volume. Muscle grows in response to stress.</p>
                        <p><strong>Protein Intake:</strong> 0.8-1g per lb bodyweight (1.6-2.2g per kg). Essential for muscle growth and preservation.</p>
                        <p><strong>Calorie Surplus:</strong> +300-500 cal/day above maintenance. Can't build significant muscle in deficit.</p>
                        <p><strong>Strength Training:</strong> 3-5x/week. Compound movements: squats, deadlifts, bench, rows. 8-12 reps per set.</p>
                        <p><strong>Rest & Recovery:</strong> 7-9 hours sleep. Muscle grows during rest, not in gym. Rest days crucial.</p>
                        <p><strong>Consistency:</strong> Build 0.5-2 lbs muscle/month (beginners gain faster). Takes years to maximize potential.</p>
                        <p><strong>Track Progress:</strong> Measurements, photos, strength gains, not just scale weight.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Preserving Lean Mass During Fat Loss</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Moderate Deficit:</strong> -500 cal/day max. Larger deficit = more muscle loss. Aim 1-2 lbs/week loss.</p>
                        <p><strong>High Protein:</strong> 1-1.2g per lb bodyweight (even higher than bulking). Protects muscle during cut.</p>
                        <p><strong>Keep Lifting:</strong> Maintain strength training volume/intensity. Don't just do cardio. Signals body to keep muscle.</p>
                        <p><strong>Don't Rush:</strong> Slow fat loss preserves more muscle. 0.5-1% bodyweight per week.</p>
                        <p><strong>Refeed Days:</strong> Higher carb days 1-2x/week. Helps hormones, metabolism, training performance.</p>
                        <p><strong>Adequate Carbs:</strong> Need fuel for workouts. Too low carb = strength/muscle loss.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>LBM vs Total Weight</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Why LBM > Weight:</strong> Two people, same weight, different body composition = very different health/appearance.</p>
                        <p><strong>Example:</strong></p>
                        <p>• Person A: 180 lbs, 25% body fat, 135 lbs LBM</p>
                        <p>• Person B: 180 lbs, 15% body fat, 153 lbs LBM</p>
                        <p>Same weight, but Person B has 18 lbs more muscle, higher metabolism, better physique, healthier.</p>
                        <p><strong>Focus on Composition:</strong> Track body fat %, measurements, photos - not just scale weight.</p>
                        <p><strong>Muscle vs Fat:</strong> Muscle denser than fat (1 lb muscle = smaller volume than 1 lb fat). Can weigh more, look leaner.</p>
                        <p><strong>Recomp Possible:</strong> Beginners can gain muscle + lose fat simultaneously (body recomposition).</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>LBM Tips:</strong> LBM = weight - fat mass. Includes muscle, bone, organs, water. Higher LBM = higher metabolism. FFMI better than BMI for athletes. Natural FFMI limit ~25-26 (men), ~22-23 (women). Body fat %: Men 10-20% = athletic. Women 18-28% = athletic. DEXA scan most accurate. Protein = 0.8-1g per lb for muscle. Strength train 3-5x/week. Progressive overload = key. Muscle grows during rest. Sleep 7-9 hours. Calorie surplus to build (+300-500 cal). Moderate deficit to cut (-500 cal). Track composition, not just weight. Muscle weighs more than fat. Focus on LBM + low body fat = best physique!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('lbmForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateLBM();
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
            calculateLBM();
        });

        function calculateLBM() {
            const gender = document.getElementById('gender').value;
            const age = parseInt(document.getElementById('age').value) || 30;
            const unitSystem = unitSystemSelect.value;
            const bodyFatInput = parseFloat(document.getElementById('bodyFat').value) || 0;
            
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

            // Calculate LBM using different formulas
            let boerLBM, jamesLBM, humeLBM;
            
            if (gender === 'male') {
                // Men's formulas
                boerLBM = (0.407 * weightKg) + (0.267 * heightCm) - 19.2;
                jamesLBM = 1.1 * weightKg - 128 * (weightKg * weightKg) / (heightCm * heightCm);
                humeLBM = (0.32810 * weightKg) + (0.33929 * heightCm) - 29.5336;
            } else {
                // Women's formulas
                boerLBM = (0.252 * weightKg) + (0.473 * heightCm) - 48.3;
                jamesLBM = 1.07 * weightKg - 148 * (weightKg * weightKg) / (heightCm * heightCm);
                humeLBM = (0.29569 * weightKg) + (0.41813 * heightCm) - 43.2933;
            }

            // Average LBM
            let avgLBM = (boerLBM + jamesLBM + humeLBM) / 3;

            // If body fat % is provided, use it for more accurate calculation
            let lbm, fatMass, bodyFatPercent;
            if (bodyFatInput > 0) {
                bodyFatPercent = bodyFatInput;
                lbm = weightKg * (1 - bodyFatPercent / 100);
                fatMass = weightKg - lbm;
            } else {
                lbm = avgLBM;
                fatMass = weightKg - lbm;
                bodyFatPercent = (fatMass / weightKg) * 100;
            }

            // Calculate BMI
            const bmi = weightKg / (heightM * heightM);

            // Calculate FFMI
            const ffmi = lbm / (heightM * heightM);
            
            // Normalized FFMI (adjusted to 178cm / 5'10")
            const normalizedFFMI = ffmi + (6.1 * (1.8 - heightM));

            // FFMI Category
            let ffmiCategory = '';
            let ffmiColor = '';
            if (ffmi < 17) {
                ffmiCategory = 'Below Average';
                ffmiColor = '#2196F3';
            } else if (ffmi < 19) {
                ffmiCategory = 'Average';
                ffmiColor = '#4CAF50';
            } else if (ffmi < 21) {
                ffmiCategory = 'Above Average';
                ffmiColor = '#4CAF50';
            } else if (ffmi < 23) {
                ffmiCategory = 'Excellent';
                ffmiColor = '#667eea';
            } else if (ffmi < 26) {
                ffmiCategory = 'Superior';
                ffmiColor = '#667eea';
            } else {
                ffmiCategory = 'Likely Enhanced';
                ffmiColor = '#f44336';
            }

            // Body fat category
            let fatCategory = '';
            let fatColor = '';
            if (gender === 'male') {
                if (bodyFatPercent < 6) {
                    fatCategory = 'Essential Fat';
                    fatColor = '#2196F3';
                } else if (bodyFatPercent < 14) {
                    fatCategory = 'Athletes';
                    fatColor = '#4CAF50';
                } else if (bodyFatPercent < 18) {
                    fatCategory = 'Fitness';
                    fatColor = '#4CAF50';
                } else if (bodyFatPercent < 25) {
                    fatCategory = 'Average';
                    fatColor = '#FF9800';
                } else {
                    fatCategory = 'Obese';
                    fatColor = '#f44336';
                }
            } else {
                if (bodyFatPercent < 14) {
                    fatCategory = 'Essential Fat';
                    fatColor = '#2196F3';
                } else if (bodyFatPercent < 21) {
                    fatCategory = 'Athletes';
                    fatColor = '#4CAF50';
                } else if (bodyFatPercent < 25) {
                    fatCategory = 'Fitness';
                    fatColor = '#4CAF50';
                } else if (bodyFatPercent < 32) {
                    fatCategory = 'Average';
                    fatColor = '#FF9800';
                } else {
                    fatCategory = 'Obese';
                    fatColor = '#f44336';
                }
            }

            // Convert to display units
            const unitLabel = unitSystem === 'imperial' ? 'lbs' : 'kg';
            const toDisplay = (kg) => unitSystem === 'imperial' ? (kg * 2.20462).toFixed(1) : kg.toFixed(1);

            const heightDisplay = unitSystem === 'imperial' ? 
                `${Math.floor((heightCm / 2.54) / 12)}'${((heightCm / 2.54) % 12).toFixed(0)}"` : 
                `${heightCm.toFixed(1)} cm`;
            const weightDisplay = toDisplay(weightKg);

            // Analysis
            let analysis = `Your lean body mass (LBM) is estimated at ${toDisplay(lbm)} ${unitLabel}, which represents ${(100 - bodyFatPercent).toFixed(1)}% of your total body weight of ${weightDisplay} ${unitLabel}. `;
            analysis += `This means you have ${toDisplay(fatMass)} ${unitLabel} of fat mass, giving you a body fat percentage of ${bodyFatPercent.toFixed(1)}%. `;
            
            analysis += `Your body fat percentage falls in the "${fatCategory}" category${gender === 'male' ? ' for men' : ' for women'}. `;
            
            analysis += `Your Fat-Free Mass Index (FFMI) is ${ffmi.toFixed(1)}, which is classified as "${ffmiCategory}". `;
            
            if (ffmi >= 26) {
                analysis += `An FFMI above 25-26 is rare naturally and may indicate performance-enhancing drug use. `;
            } else if (ffmi >= 23) {
                analysis += `This indicates excellent muscular development from consistent, serious training. `;
            } else if (ffmi >= 20) {
                analysis += `This shows good muscle development from regular strength training. `;
            } else {
                analysis += `There's potential to increase lean mass through progressive resistance training. `;
            }
            
            if (bodyFatInput > 0) {
                analysis += `Since you provided your body fat percentage, this calculation is more accurate than using estimation formulas alone. `;
            } else {
                analysis += `For more accurate results, consider measuring your body fat percentage using DEXA scan, calipers, or other methods, then recalculate. `;
            }
            
            analysis += `To build lean mass, focus on progressive strength training 3-5x per week, consume 0.8-1g protein per lb of bodyweight, and maintain a slight calorie surplus (+300-500 cal/day). `;
            analysis += `Remember: lean body mass includes muscle, bone, organs, and water - not just muscle alone.`;

            // Update UI
            document.getElementById('lbmResult').textContent = `${toDisplay(lbm)} ${unitLabel}`;
            document.getElementById('lbmDisplay').textContent = `${toDisplay(lbm)} ${unitLabel}`;
            document.getElementById('fatMassDisplay').textContent = `${toDisplay(fatMass)} ${unitLabel}`;
            document.getElementById('bodyFatDisplay').textContent = `${bodyFatPercent.toFixed(1)}%`;
            document.getElementById('ffmiDisplay').textContent = ffmi.toFixed(1);

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('ageDisplay').textContent = `${age} years`;
            document.getElementById('heightDisplay').textContent = heightDisplay;
            document.getElementById('weightDisplay').textContent = `${weightDisplay} ${unitLabel}`;
            document.getElementById('bmiDisplay').textContent = bmi.toFixed(1);

            document.getElementById('totalWeight').textContent = `${weightDisplay} ${unitLabel}`;
            document.getElementById('lbmValue').textContent = `${toDisplay(lbm)} ${unitLabel} (${(100 - bodyFatPercent).toFixed(1)}%)`;
            document.getElementById('fatMassValue').textContent = `${toDisplay(fatMass)} ${unitLabel} (${bodyFatPercent.toFixed(1)}%)`;
            document.getElementById('bodyFatPercent').textContent = `${bodyFatPercent.toFixed(1)}%`;

            document.getElementById('boerLBM').textContent = `${toDisplay(boerLBM)} ${unitLabel}`;
            document.getElementById('jamesLBM').textContent = `${toDisplay(jamesLBM)} ${unitLabel}`;
            document.getElementById('humeLBM').textContent = `${toDisplay(humeLBM)} ${unitLabel}`;
            document.getElementById('avgLBM').textContent = `${toDisplay(avgLBM)} ${unitLabel}`;

            document.getElementById('ffmi').textContent = ffmi.toFixed(1);
            document.getElementById('normalizedFFMI').textContent = normalizedFFMI.toFixed(1);
            document.getElementById('ffmiCategory').textContent = ffmiCategory;
            document.getElementById('ffmiCategory').style.color = ffmiColor;
            document.getElementById('naturalLimit').textContent = gender === 'male' ? '25-26 FFMI' : '22-23 FFMI';

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateLBM();
        });
    </script>
</body>
</html>