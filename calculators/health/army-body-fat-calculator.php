<?php
/**
 * Army Body Fat Calculator
 * File: army-body-fat-calculator.php
 * Description: Calculate body fat percentage using US Army method
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Army Body Fat Calculator - Military Body Composition (Imperial/Metric)</title>
    <meta name="description" content="Free Army body fat calculator. Calculate body fat percentage using US Army method with circumference measurements. Supports imperial and metric units.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#129310; Army Body Fat Calculator</h1>
        <p>Calculate body fat using US Army method</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Body Measurements</h2>
                <form id="armyBodyFatForm">
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
                            <option value="imperial">Imperial (inches/pounds)</option>
                            <option value="metric">Metric (cm/kg)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Height & Weight</h3>
                    
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
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Circumference Measurements</h3>
                    
                    <div class="form-group">
                        <label for="neck">Neck Circumference (<span id="neckUnit">inches</span>)</label>
                        <input type="number" id="neck" value="15" min="5" max="30" step="0.1" required>
                        <small>Measure at the narrowest point below Adam's apple</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="waist">Waist Circumference (<span id="waistUnit">inches</span>)</label>
                        <input type="number" id="waist" value="32" min="15" max="80" step="0.1" required>
                        <small>Measure at the navel (belly button) level</small>
                    </div>
                    
                    <div class="form-group" id="hipGroup" style="display: none;">
                        <label for="hip">Hip Circumference (<span id="hipUnit">inches</span>)</label>
                        <input type="number" id="hip" value="38" min="20" max="80" step="0.1">
                        <small>Measure at the widest point of hips/buttocks</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Body Fat</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Body Fat Results</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Body Fat Percentage</h3>
                    <div class="amount" id="bodyFatPercent">0%</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Body Fat Category</h4>
                        <div class="value" id="bodyFatCategory">Normal</div>
                    </div>
                    <div class="metric-card">
                        <h4>Fat Mass</h4>
                        <div class="value" id="fatMass">0 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Lean Mass</h4>
                        <div class="value" id="leanMass">0 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Army Standard</h4>
                        <div class="value" id="armyStandard">Pass</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Measurements</h3>
                    <div class="breakdown-item">
                        <span>Gender</span>
                        <strong id="genderDisplay">Male</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Height</span>
                        <strong id="heightDisplay">5'10"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight</span>
                        <strong id="weightDisplay">180 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Neck</span>
                        <strong id="neckDisplay">15 in</strong>
                    </div>
                    <div class="breakdown-item">
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
                        <strong id="bfPercent" style="color: #667eea; font-size: 1.1em;">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fat Mass</span>
                        <strong id="fatMassCalc" style="color: #f44336;">0 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lean Body Mass</span>
                        <strong id="leanMassCalc" style="color: #4CAF50;">0 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Weight</span>
                        <strong id="totalWeight">0 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Army Body Fat Standards</h3>
                    <div class="breakdown-item">
                        <span>Your Body Fat</span>
                        <strong id="yourBF">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Army Maximum (Age 17-20)</span>
                        <strong id="armyMax1720">20% (M) / 30% (F)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Army Maximum (Age 21-27)</span>
                        <strong id="armyMax2127">22% (M) / 32% (F)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Army Maximum (Age 28-39)</span>
                        <strong id="armyMax2839">24% (M) / 34% (F)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Army Maximum (Age 40+)</span>
                        <strong id="armyMax40">26% (M) / 36% (F)</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Status</strong></span>
                        <strong id="armyStatus" style="font-size: 1.1em;">Pass</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Body Fat Categories</h3>
                    <div class="breakdown-item">
                        <span>Essential Fat</span>
                        <strong>2-5% (M) / 10-13% (F)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Athletes</span>
                        <strong>6-13% (M) / 14-20% (F)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fitness</span>
                        <strong>14-17% (M) / 21-24% (F)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average</span>
                        <strong>18-24% (M) / 25-31% (F)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Obese</span>
                        <strong>25%+ (M) / 32%+ (F)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>To Achieve Different Body Fat %</h3>
                    <div class="breakdown-item">
                        <span>For 15% Body Fat</span>
                        <strong id="target15">Lose 0 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>For 20% Body Fat</span>
                        <strong id="target20">Lose 0 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>For 10% Body Fat</span>
                        <strong id="target10">Lose 0 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Measurement Tips</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Neck:</strong> Measure at the narrowest point, just below the Adam's apple. Keep tape horizontal and snug but not tight.</p>
                        <p><strong>Waist (Men):</strong> Measure at the level of the navel (belly button). Stand naturally, don't suck in.</p>
                        <p><strong>Waist (Women):</strong> Measure at the narrowest point of the natural waistline.</p>
                        <p><strong>Hip (Women only):</strong> Measure at the widest point of the hips and buttocks.</p>
                        <p><strong>General:</strong> Measure on bare skin or tight-fitting clothing. Take measurements in the morning for consistency.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Army Body Fat Tips:</strong> US Army uses circumference method (AR 600-9). Men: neck + waist measurements. Women: neck + waist + hip. Formula based on height. Different from Navy method. Standards vary by age and gender. Tape must be positioned correctly. Measure 3 times, use average. Body fat ≠ fitness level. Muscle weighs more than fat. Hydration affects measurements. Take before eating/drinking. Monthly tracking recommended. Army max: 26% (men 40+), 36% (women 40+). Below standards = pass. Exceeds standards = ABCP program. Body fat more accurate than BMI.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('armyBodyFatForm');
        const genderSelect = document.getElementById('gender');
        const unitSystemSelect = document.getElementById('unitSystem');

        genderSelect.addEventListener('change', function() {
            toggleHipField();
            calculateBodyFat();
        });

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateBodyFat();
        });

        function toggleHipField() {
            const gender = genderSelect.value;
            const hipGroup = document.getElementById('hipGroup');
            const hipDisplayItem = document.getElementById('hipDisplayItem');
            
            if (gender === 'female') {
                hipGroup.style.display = 'block';
                hipDisplayItem.style.display = 'flex';
            } else {
                hipGroup.style.display = 'none';
                hipDisplayItem.style.display = 'none';
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
            const unitSystem = unitSystemSelect.value;
            
            // Get measurements based on unit system
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

            // Calculate body fat percentage using Army formula
            let bodyFatPercent;
            
            if (gender === 'male') {
                // Male formula: 86.010 × log10(waist - neck) - 70.041 × log10(height) + 36.76
                bodyFatPercent = (86.010 * Math.log10(waist - neck)) - (70.041 * Math.log10(heightInches)) + 36.76;
            } else {
                // Female formula: 163.205 × log10(waist + hip - neck) - 97.684 × log10(height) - 78.387
                bodyFatPercent = (163.205 * Math.log10(waist + hip - neck)) - (97.684 * Math.log10(heightInches)) - 78.387;
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

            // Army standards (example for ages 21-27)
            const armyMax = gender === 'male' ? 22 : 32;
            const armyPass = bodyFatPercent <= armyMax;

            // Target weights
            const target15Weight = leanMass / (1 - 0.15);
            const target20Weight = leanMass / (1 - 0.20);
            const target10Weight = leanMass / (1 - 0.10);

            const loseFor15 = weightLbs - target15Weight;
            const loseFor20 = weightLbs - target20Weight;
            const loseFor10 = weightLbs - target10Weight;

            // Update card color
            const card = document.getElementById('resultCard');
            if (bodyFatPercent < 18 || (gender === 'female' && bodyFatPercent < 25)) {
                card.className = 'result-card success';
            } else if (bodyFatPercent < 25 || (gender === 'female' && bodyFatPercent < 32)) {
                card.className = 'result-card info';
            } else {
                card.className = 'result-card warning';
            }

            // Analysis
            let analysis = `Your body fat percentage is ${bodyFatPercent.toFixed(1)}%, which falls in the "${category}" category. `;
            analysis += `Of your ${weightLbs.toFixed(1)} lbs total weight, ${fatMass.toFixed(1)} lbs is fat mass and ${leanMass.toFixed(1)} lbs is lean body mass. `;
            
            if (armyPass) {
                analysis += `You meet US Army body composition standards (maximum ${armyMax}% for ${gender === 'male' ? 'males' : 'females'} age 21-27). `;
            } else {
                analysis += `You exceed US Army body composition standards (maximum ${armyMax}% for ${gender === 'male' ? 'males' : 'females'} age 21-27). `;
            }
            
            analysis += `The Army method uses circumference measurements and is a reliable field method for estimating body composition.`;

            // Display units
            const displayUnit = unitSystem === 'imperial' ? 'lbs' : 'kg';
            const displayLength = unitSystem === 'imperial' ? 'in' : 'cm';
            const displayHeight = unitSystem === 'imperial' ? 
                `${Math.floor(heightInches / 12)}'${(heightInches % 12).toFixed(0)}"` : 
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

            // Update UI
            document.getElementById('bodyFatPercent').textContent = bodyFatPercent.toFixed(1) + '%';
            document.getElementById('bodyFatCategory').textContent = category;
            document.getElementById('bodyFatCategory').style.color = categoryColor;
            document.getElementById('fatMass').textContent = unitSystem === 'imperial' ? 
                `${fatMass.toFixed(1)} lbs` : 
                `${(fatMass / 2.20462).toFixed(1)} kg`;
            document.getElementById('leanMass').textContent = unitSystem === 'imperial' ? 
                `${leanMass.toFixed(1)} lbs` : 
                `${(leanMass / 2.20462).toFixed(1)} kg`;
            document.getElementById('armyStandard').textContent = armyPass ? 'PASS' : 'FAIL';
            document.getElementById('armyStandard').style.color = armyPass ? '#4CAF50' : '#f44336';

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
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

            document.getElementById('yourBF').textContent = bodyFatPercent.toFixed(1) + '%';
            document.getElementById('armyStatus').textContent = armyPass ? 'PASS ✓' : 'FAIL ✗';
            document.getElementById('armyStatus').style.color = armyPass ? '#4CAF50' : '#f44336';

            const weightUnit = unitSystem === 'imperial' ? 'lbs' : 'kg';
            const convertWeight = (lbs) => unitSystem === 'imperial' ? lbs : lbs / 2.20462;
            
            document.getElementById('target15').textContent = loseFor15 > 0 ? 
                `Lose ${convertWeight(loseFor15).toFixed(1)} ${weightUnit}` : 
                `Gain ${convertWeight(Math.abs(loseFor15)).toFixed(1)} ${weightUnit}`;
            document.getElementById('target20').textContent = loseFor20 > 0 ? 
                `Lose ${convertWeight(loseFor20).toFixed(1)} ${weightUnit}` : 
                `Gain ${convertWeight(Math.abs(loseFor20)).toFixed(1)} ${weightUnit}`;
            document.getElementById('target10').textContent = loseFor10 > 0 ? 
                `Lose ${convertWeight(loseFor10).toFixed(1)} ${weightUnit}` : 
                `Gain ${convertWeight(Math.abs(loseFor10)).toFixed(1)} ${weightUnit}`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleHipField();
            toggleUnitFields();
            calculateBodyFat();
        });
    </script>
</body>
</html>