<?php
/**
 * Navy Body Fat Calculator
 * File: navy-body-fat-calculator.php
 * Description: Calculate body fat percentage using US Navy circumference method
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navy Body Fat Calculator - US Navy Method Body Fat % Calculator</title>
    <meta name="description" content="Free Navy body fat calculator. Calculate body fat percentage using US Navy circumference method. Requires neck, waist, hip measurements.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>⚓ Navy Body Fat Calculator</h1>
        <p>US Navy circumference method</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Your Measurements</h2>
                <form id="navyForm">
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
                            <option value="imperial">Imperial (inches/lbs)</option>
                            <option value="metric">Metric (cm/kg)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Basic Information</h3>
                    
                    <div class="form-group">
                        <label for="age">Age (years)</label>
                        <input type="number" id="age" value="30" min="17" max="100" step="1" required>
                    </div>
                    
                    <div class="form-group" id="heightImperialGroup">
                        <label for="heightInches">Height (inches)</label>
                        <input type="number" id="heightInches" value="70" min="48" max="96" step="0.1" required>
                        <small>Example: 5'10" = 70 inches</small>
                    </div>

                    <div class="form-group" id="heightMetricGroup" style="display: none;">
                        <label for="heightCm">Height (cm)</label>
                        <input type="number" id="heightCm" value="178" min="120" max="250" step="0.1">
                    </div>
                    
                    <div class="form-group" id="weightImperialGroup">
                        <label for="weightLbs">Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="180" min="50" max="500" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="82" min="20" max="250" step="0.1">
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Circumference Measurements</h3>
                    
                    <div class="form-group" id="neckImperialGroup">
                        <label for="neckInches">Neck Circumference (inches)</label>
                        <input type="number" id="neckInches" value="15" min="8" max="30" step="0.1" required>
                        <small>Measure below Adam's apple, at smallest point</small>
                    </div>

                    <div class="form-group" id="neckMetricGroup" style="display: none;">
                        <label for="neckCm">Neck Circumference (cm)</label>
                        <input type="number" id="neckCm" value="38" min="20" max="76" step="0.1">
                        <small>Measure below Adam's apple, at smallest point</small>
                    </div>
                    
                    <div class="form-group" id="waistImperialGroup">
                        <label for="waistInches">Waist Circumference (inches)</label>
                        <input type="number" id="waistInches" value="32" min="18" max="80" step="0.1" required>
                        <small>Measure at navel, horizontal around abdomen</small>
                    </div>

                    <div class="form-group" id="waistMetricGroup" style="display: none;">
                        <label for="waistCm">Waist Circumference (cm)</label>
                        <input type="number" id="waistCm" value="81" min="45" max="200" step="0.1">
                        <small>Measure at navel, horizontal around abdomen</small>
                    </div>
                    
                    <div class="form-group" id="hipImperialGroup">
                        <label for="hipInches">Hip Circumference (inches)</label>
                        <input type="number" id="hipInches" value="38" min="20" max="80" step="0.1">
                        <small>Women only: Measure at widest point of hips/buttocks</small>
                    </div>

                    <div class="form-group" id="hipMetricGroup" style="display: none;">
                        <label for="hipCm">Hip Circumference (cm)</label>
                        <input type="number" id="hipCm" value="97" min="50" max="200" step="0.1">
                        <small>Women only: Measure at widest point of hips/buttocks</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Body Fat</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Body Fat Results</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Body Fat Percentage</h3>
                    <div class="amount" id="bodyFatResult">15.5%</div>
                    <div style="margin-top: 10px; font-size: 1.3em;" id="categoryDisplay">Fitness</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Body Fat %</h4>
                        <div class="value" id="bfDisplay">15.5%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Fat Mass</h4>
                        <div class="value" id="fatMassDisplay">28 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Lean Mass</h4>
                        <div class="value" id="leanMassDisplay">152 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Category</h4>
                        <div class="value" id="categoryShort">Fitness</div>
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
                        <strong id="heightDisplay">70 inches (5'10")</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight</span>
                        <strong id="weightDisplay">180 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Neck</span>
                        <strong id="neckDisplay">15 inches</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waist</span>
                        <strong id="waistDisplay">32 inches</strong>
                    </div>
                    <div class="breakdown-item" id="hipRow">
                        <span>Hip</span>
                        <strong id="hipDisplay">38 inches</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Body Composition</h3>
                    <div class="breakdown-item">
                        <span>Body Fat Percentage</span>
                        <strong id="bodyFatPercent" style="color: #667eea; font-size: 1.1em;">15.5%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fat Mass</span>
                        <strong id="fatMass" style="color: #f44336;">28 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lean Body Mass</span>
                        <strong id="leanMass" style="color: #4CAF50;">152 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI</span>
                        <strong id="bmiDisplay">25.8</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Category</span>
                        <strong id="category" style="color: #4CAF50;">Fitness</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>US Navy Standards</h3>
                    <div class="breakdown-item">
                        <span>Navy Maximum (Men)</span>
                        <strong style="color: #f44336;">22% (age 17-39)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Navy Maximum (Women)</span>
                        <strong style="color: #f44336;">33% (age 17-39)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Your Status</span>
                        <strong id="navyStatus" style="color: #4CAF50;">Within Standards</strong>
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
                    <h3>Understanding Navy Method</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>US Navy Method:</strong> Uses circumference measurements to estimate body fat. Developed by US Navy for military fitness assessments. No calipers or expensive equipment needed.</p>
                        <p><strong>Men's Formula:</strong> Uses neck, waist, and height. Formula: %BF = 495 / (1.0324 - 0.19077 × log(waist - neck) + 0.15456 × log(height)) - 450</p>
                        <p><strong>Women's Formula:</strong> Uses neck, waist, hip, and height. Formula: %BF = 495 / (1.29579 - 0.35004 × log(waist + hip - neck) + 0.22100 × log(height)) - 450</p>
                        <p><strong>Accuracy:</strong> ±3-4% accuracy when done correctly. Less accurate than DEXA or hydrostatic weighing, but convenient and free.</p>
                        <p><strong>Used By:</strong> US Military (Navy, Army, Marines, Air Force) for fitness standards and body composition assessments.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How to Measure Correctly</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Neck Measurement (Both Genders):</strong></p>
                        <p>• Stand upright, look straight ahead</p>
                        <p>• Measure below Adam's apple (laryngeal prominence)</p>
                        <p>• At smallest circumference of neck</p>
                        <p>• Tape perpendicular to long axis of neck</p>
                        <p>• Don't compress soft tissue - firm but not tight</p>
                        <p><strong>Waist Measurement (Both Genders):</strong></p>
                        <p>• Stand with feet together, relax abdomen</p>
                        <p>• Measure at navel level, horizontal around abdomen</p>
                        <p>• At end of normal exhalation (breathe normally, don't suck in)</p>
                        <p>• Tape parallel to floor, snug but not compressing skin</p>
                        <p><strong>Hip Measurement (Women Only):</strong></p>
                        <p>• Stand with feet together</p>
                        <p>• Measure at widest point of buttocks/hips</p>
                        <p>• Tape horizontal and parallel to floor</p>
                        <p>• Take measurement where buttocks protrude most</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Navy Body Fat Standards</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>US Navy Maximum Body Fat (Men):</strong></p>
                        <p>• Age 17-39: 22% maximum</p>
                        <p>• Age 40+: 23% maximum</p>
                        <p><strong>US Navy Maximum Body Fat (Women):</strong></p>
                        <p>• Age 17-39: 33% maximum</p>
                        <p>• Age 40+: 34% maximum</p>
                        <p><strong>Army Standards:</strong> Similar to Navy (20-26% men, 30-36% women depending on age)</p>
                        <p><strong>Marine Corps:</strong> 18% men (age 17-26), 26% women (age 17-26). Increases with age.</p>
                        <p><strong>Air Force:</strong> Uses BMI and waist measurements instead of body fat %</p>
                        <p><strong>Consequences:</strong> Exceeding standards may result in: counseling, physical training program, administrative separation if not improved.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Accuracy & Limitations</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Accuracy:</strong> ±3-4% margin of error. Good for population estimates, less accurate for individuals.</p>
                        <p><strong>Pros:</strong></p>
                        <p>• Quick and easy - just need tape measure</p>
                        <p>• Free - no equipment needed</p>
                        <p>• Validated by military research</p>
                        <p>• Reasonable accuracy for most people</p>
                        <p><strong>Cons/Limitations:</strong></p>
                        <p>• Less accurate than DEXA, hydrostatic weighing, Bod Pod</p>
                        <p>• Measurement technique affects results significantly</p>
                        <p>• Doesn't account for muscle mass - may overestimate BF in muscular people</p>
                        <p>• Less accurate for extreme body types (very lean or obese)</p>
                        <p>• Ethnicity differences not accounted for</p>
                        <p><strong>More Accurate Methods:</strong> DEXA scan (±1-2%), hydrostatic weighing (±2-3%), Bod Pod (±2-3%)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Reducing Body Fat</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Calorie Deficit:</strong> Lose 1-2 lbs per week (500-1000 cal deficit daily). Can't spot reduce fat.</p>
                        <p><strong>Strength Training:</strong> 3-5x per week. Preserves muscle mass during fat loss. Increases metabolism.</p>
                        <p><strong>Cardio:</strong> 150+ min per week. HIIT or steady-state. Burns calories, improves cardiovascular health.</p>
                        <p><strong>High Protein:</strong> 0.8-1.2g per lb bodyweight. Preserves muscle, increases satiety, higher thermic effect.</p>
                        <p><strong>Whole Foods:</strong> Lean proteins, vegetables, fruits, whole grains, healthy fats. Avoid processed foods, sugar, alcohol excess.</p>
                        <p><strong>Sleep:</strong> 7-9 hours nightly. Poor sleep increases cortisol, hunger, fat storage.</p>
                        <p><strong>Hydration:</strong> 0.5-1 oz per lb bodyweight daily. Water boosts metabolism, reduces hunger.</p>
                        <p><strong>Consistency:</strong> Takes 3-6 months for significant fat loss. Be patient, track progress weekly.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Navy BF Tips:</strong> Navy method = circumference measurements. Men: neck + waist + height. Women: neck + waist + hip + height. Accuracy ±3-4%. Measure at navel (waist), below Adam's apple (neck), widest point (hips). Don't suck in stomach. Tape firm but not compressing. Navy max: 22% (men 17-39), 33% (women 17-39). Essential fat: 2-5% (men), 10-13% (women). Athletes: 6-13% (men), 14-20% (women). DEXA more accurate but expensive. Track measurements monthly. Fat loss = calorie deficit + strength training. High protein preserves muscle. Can't spot reduce. Sleep 7-9 hours. Hydrate well. Be consistent!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('navyForm');
        const unitSystemSelect = document.getElementById('unitSystem');
        const genderSelect = document.getElementById('gender');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateBodyFat();
        });

        genderSelect.addEventListener('change', function() {
            toggleHipFields();
            calculateBodyFat();
        });

        function toggleUnitFields() {
            const unitSystem = unitSystemSelect.value;
            const isImperial = unitSystem === 'imperial';
            
            document.getElementById('heightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('heightMetricGroup').style.display = isImperial ? 'none' : 'block';
            document.getElementById('weightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('weightMetricGroup').style.display = isImperial ? 'none' : 'block';
            document.getElementById('neckImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('neckMetricGroup').style.display = isImperial ? 'none' : 'block';
            document.getElementById('waistImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('waistMetricGroup').style.display = isImperial ? 'none' : 'block';
            document.getElementById('hipImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('hipMetricGroup').style.display = isImperial ? 'none' : 'block';
        }

        function toggleHipFields() {
            const gender = genderSelect.value;
            const showHip = gender === 'female';
            const unitSystem = unitSystemSelect.value;
            const isImperial = unitSystem === 'imperial';
            
            if (showHip) {
                document.getElementById('hipImperialGroup').style.display = isImperial ? 'block' : 'none';
                document.getElementById('hipMetricGroup').style.display = isImperial ? 'none' : 'block';
            } else {
                document.getElementById('hipImperialGroup').style.display = 'none';
                document.getElementById('hipMetricGroup').style.display = 'none';
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBodyFat();
        });

        function calculateBodyFat() {
            const gender = genderSelect.value;
            const age = parseInt(document.getElementById('age').value) || 30;
            const unitSystem = unitSystemSelect.value;
            
            // Get measurements in inches
            let heightInches, weightLbs, neckInches, waistInches, hipInches;
            
            if (unitSystem === 'imperial') {
                heightInches = parseFloat(document.getElementById('heightInches').value) || 70;
                weightLbs = parseFloat(document.getElementById('weightLbs').value) || 180;
                neckInches = parseFloat(document.getElementById('neckInches').value) || 15;
                waistInches = parseFloat(document.getElementById('waistInches').value) || 32;
                hipInches = parseFloat(document.getElementById('hipInches').value) || 38;
            } else {
                const heightCm = parseFloat(document.getElementById('heightCm').value) || 178;
                const weightKg = parseFloat(document.getElementById('weightKg').value) || 82;
                const neckCm = parseFloat(document.getElementById('neckCm').value) || 38;
                const waistCm = parseFloat(document.getElementById('waistCm').value) || 81;
                const hipCm = parseFloat(document.getElementById('hipCm').value) || 97;
                
                heightInches = heightCm / 2.54;
                weightLbs = weightKg * 2.20462;
                neckInches = neckCm / 2.54;
                waistInches = waistCm / 2.54;
                hipInches = hipCm / 2.54;
            }

            // Calculate body fat percentage using Navy formula
            let bodyFat;
            
            if (gender === 'male') {
                // Men's formula
                const factor = 1.0324 - 0.19077 * Math.log10(waistInches - neckInches) + 0.15456 * Math.log10(heightInches);
                bodyFat = (495 / factor) - 450;
            } else {
                // Women's formula
                const factor = 1.29579 - 0.35004 * Math.log10(waistInches + hipInches - neckInches) + 0.22100 * Math.log10(heightInches);
                bodyFat = (495 / factor) - 450;
            }

            // Calculate body composition
            const weightKg = weightLbs / 2.20462;
            const fatMassLbs = (bodyFat / 100) * weightLbs;
            const leanMassLbs = weightLbs - fatMassLbs;
            const fatMassKg = fatMassLbs / 2.20462;
            const leanMassKg = leanMassLbs / 2.20462;

            // Calculate BMI
            const heightM = (heightInches * 2.54) / 100;
            const bmi = weightKg / (heightM * heightM);

            // Determine category
            let category = '';
            let categoryColor = '';
            let cardClass = '';
            
            if (gender === 'male') {
                if (bodyFat < 6) {
                    category = 'Essential Fat';
                    categoryColor = '#2196F3';
                    cardClass = 'info';
                } else if (bodyFat < 14) {
                    category = 'Athletes';
                    categoryColor = '#4CAF50';
                    cardClass = 'success';
                } else if (bodyFat < 18) {
                    category = 'Fitness';
                    categoryColor = '#4CAF50';
                    cardClass = 'success';
                } else if (bodyFat < 25) {
                    category = 'Average';
                    categoryColor = '#FF9800';
                    cardClass = 'warning';
                } else {
                    category = 'Obese';
                    categoryColor = '#f44336';
                    cardClass = 'warning';
                }
            } else {
                if (bodyFat < 14) {
                    category = 'Essential Fat';
                    categoryColor = '#2196F3';
                    cardClass = 'info';
                } else if (bodyFat < 21) {
                    category = 'Athletes';
                    categoryColor = '#4CAF50';
                    cardClass = 'success';
                } else if (bodyFat < 25) {
                    category = 'Fitness';
                    categoryColor = '#4CAF50';
                    cardClass = 'success';
                } else if (bodyFat < 32) {
                    category = 'Average';
                    categoryColor = '#FF9800';
                    cardClass = 'warning';
                } else {
                    category = 'Obese';
                    categoryColor = '#f44336';
                    cardClass = 'warning';
                }
            }

            // Navy standards
            let navyMax;
            if (gender === 'male') {
                navyMax = age < 40 ? 22 : 23;
            } else {
                navyMax = age < 40 ? 33 : 34;
            }
            
            const meetsNavyStandards = bodyFat <= navyMax;
            const navyStatus = meetsNavyStandards ? 'Within Standards' : 'Exceeds Standards';
            const navyStatusColor = meetsNavyStandards ? '#4CAF50' : '#f44336';

            // Display format
            const unitLabel = unitSystem === 'imperial' ? 'lbs' : 'kg';
            const heightLabel = unitSystem === 'imperial' ? 'inches' : 'cm';
            const circLabel = unitSystem === 'imperial' ? 'inches' : 'cm';
            
            const displayWeight = unitSystem === 'imperial' ? weightLbs.toFixed(1) : weightKg.toFixed(1);
            const displayHeight = unitSystem === 'imperial' ? heightInches.toFixed(1) : (heightInches * 2.54).toFixed(1);
            const displayNeck = unitSystem === 'imperial' ? neckInches.toFixed(1) : (neckInches * 2.54).toFixed(1);
            const displayWaist = unitSystem === 'imperial' ? waistInches.toFixed(1) : (waistInches * 2.54).toFixed(1);
            const displayHip = unitSystem === 'imperial' ? hipInches.toFixed(1) : (hipInches * 2.54).toFixed(1);
            const displayFatMass = unitSystem === 'imperial' ? fatMassLbs.toFixed(1) : fatMassKg.toFixed(1);
            const displayLeanMass = unitSystem === 'imperial' ? leanMassLbs.toFixed(1) : leanMassKg.toFixed(1);

            // Height in feet/inches for imperial
            const heightFtIn = `(${Math.floor(heightInches / 12)}'${(heightInches % 12).toFixed(0)}")`;

            // Analysis
            let analysis = `Your body fat percentage using the US Navy circumference method is ${bodyFat.toFixed(1)}%. `;
            analysis += `This falls in the "${category}" category${gender === 'male' ? ' for men' : ' for women'}. `;
            
            analysis += `Your body composition consists of ${displayFatMass} ${unitLabel} of fat mass and ${displayLeanMass} ${unitLabel} of lean body mass. `;
            
            if (meetsNavyStandards) {
                analysis += `You are within US Navy body fat standards (maximum ${navyMax}% for ${gender === 'male' ? 'men' : 'women'} aged ${age < 40 ? '17-39' : '40+'}). `;
            } else {
                analysis += `⚠️ You exceed US Navy body fat standards (maximum ${navyMax}% for ${gender === 'male' ? 'men' : 'women'} aged ${age < 40 ? '17-39' : '40+'}). `;
            }
            
            if (gender === 'male') {
                if (bodyFat < 14) {
                    analysis += `Your body fat percentage indicates excellent fitness and athleticism. Maintain this with regular exercise and proper nutrition. `;
                } else if (bodyFat < 18) {
                    analysis += `You have a healthy body fat percentage typical of fit individuals. Continue strength training and cardiovascular exercise. `;
                } else if (bodyFat < 25) {
                    analysis += `Your body fat is in the average range. Consider increasing physical activity and improving diet to reach fitness levels. `;
                } else {
                    analysis += `Your body fat percentage is elevated. Focus on creating a calorie deficit through diet and exercise to reduce body fat. `;
                }
            } else {
                if (bodyFat < 21) {
                    analysis += `Your body fat percentage indicates excellent fitness and athleticism. Maintain this with regular exercise and proper nutrition. `;
                } else if (bodyFat < 25) {
                    analysis += `You have a healthy body fat percentage typical of fit individuals. Continue strength training and cardiovascular exercise. `;
                } else if (bodyFat < 32) {
                    analysis += `Your body fat is in the average range. Consider increasing physical activity and improving diet to reach fitness levels. `;
                } else {
                    analysis += `Your body fat percentage is elevated. Focus on creating a calorie deficit through diet and exercise to reduce body fat. `;
                }
            }
            
            analysis += `The Navy method has ±3-4% accuracy. For more precise measurements, consider DEXA scan or hydrostatic weighing. `;
            analysis += `Remember to measure consistently and track progress over time rather than focusing on a single measurement.`;

            // Update UI
            const card = document.getElementById('resultCard');
            card.className = 'result-card ' + cardClass;

            document.getElementById('bodyFatResult').textContent = `${bodyFat.toFixed(1)}%`;
            document.getElementById('categoryDisplay').textContent = category;
            document.getElementById('bfDisplay').textContent = `${bodyFat.toFixed(1)}%`;
            document.getElementById('fatMassDisplay').textContent = `${displayFatMass} ${unitLabel}`;
            document.getElementById('leanMassDisplay').textContent = `${displayLeanMass} ${unitLabel}`;
            document.getElementById('categoryShort').textContent = category;

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('ageDisplay').textContent = `${age} years`;
            document.getElementById('heightDisplay').textContent = unitSystem === 'imperial' ? 
                `${displayHeight} ${heightLabel} ${heightFtIn}` : 
                `${displayHeight} ${heightLabel}`;
            document.getElementById('weightDisplay').textContent = `${displayWeight} ${unitLabel}`;
            document.getElementById('neckDisplay').textContent = `${displayNeck} ${circLabel}`;
            document.getElementById('waistDisplay').textContent = `${displayWaist} ${circLabel}`;
            document.getElementById('hipDisplay').textContent = `${displayHip} ${circLabel}`;
            
            const hipRow = document.getElementById('hipRow');
            hipRow.style.display = gender === 'female' ? 'flex' : 'none';

            document.getElementById('bodyFatPercent').textContent = `${bodyFat.toFixed(1)}%`;
            document.getElementById('fatMass').textContent = `${displayFatMass} ${unitLabel}`;
            document.getElementById('leanMass').textContent = `${displayLeanMass} ${unitLabel}`;
            document.getElementById('bmiDisplay').textContent = bmi.toFixed(1);
            document.getElementById('category').textContent = category;
            document.getElementById('category').style.color = categoryColor;

            document.getElementById('navyStatus').textContent = navyStatus;
            document.getElementById('navyStatus').style.color = navyStatusColor;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            toggleHipFields();
            calculateBodyFat();
        });
    </script>
</body>
</html>