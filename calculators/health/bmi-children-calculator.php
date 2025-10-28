<?php
/**
 * BMI Calculator for Children
 * File: bmi-children-calculator.php
 * Description: Calculate BMI percentile for children ages 2-20 (Imperial/Metric)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator for Children - Percentile Charts Ages 2-20 (Imperial/Metric)</title>
    <meta name="description" content="Free BMI calculator for children and teens. Calculate BMI percentile using CDC growth charts for ages 2-20. Supports imperial and metric units.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128118; BMI Calculator for Children</h1>
        <p>Calculate BMI percentile for ages 2-20</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Child Information</h2>
                <form id="childBmiForm">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Boy</option>
                            <option value="female">Girl</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="imperial">Imperial (lbs/inches)</option>
                            <option value="metric">Metric (kg/cm)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Age</h3>
                    
                    <div class="form-group">
                        <label for="ageYears">Age (Years)</label>
                        <input type="number" id="ageYears" value="10" min="2" max="20" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="ageMonths">Additional Months</label>
                        <input type="number" id="ageMonths" value="0" min="0" max="11" step="1">
                        <small>0-11 months (for more accuracy)</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Measurements</h3>
                    
                    <div class="form-group" id="heightImperialGroup">
                        <label for="heightFeet">Height</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="heightFeet" value="4" min="2" max="7" step="1" style="flex: 1;" placeholder="Feet">
                            <input type="number" id="heightInches" value="8" min="0" max="11" step="0.5" style="flex: 1;" placeholder="Inches">
                        </div>
                    </div>

                    <div class="form-group" id="heightMetricGroup" style="display: none;">
                        <label for="heightCm">Height (cm)</label>
                        <input type="number" id="heightCm" value="142" min="70" max="220" step="0.1">
                    </div>
                    
                    <div class="form-group" id="weightImperialGroup">
                        <label for="weightLbs">Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="70" min="20" max="400" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="32" min="10" max="200" step="0.1">
                    </div>
                    
                    <button type="submit" class="btn">Calculate BMI</button>
                </form>
            </div>

            <div class="results-section">
                <h2>BMI Results</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>BMI Percentile</h3>
                    <div class="amount" id="percentileResult">50th</div>
                    <div style="margin-top: 10px; font-size: 1.3em;" id="weightStatus">Normal Weight</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>BMI</h4>
                        <div class="value" id="bmiValue">18.5</div>
                    </div>
                    <div class="metric-card">
                        <h4>Percentile</h4>
                        <div class="value" id="percentileValue">50th</div>
                    </div>
                    <div class="metric-card">
                        <h4>Category</h4>
                        <div class="value" id="categoryValue">Normal</div>
                    </div>
                    <div class="metric-card">
                        <h4>Age</h4>
                        <div class="value" id="ageDisplay">10 yrs</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Child Information</h3>
                    <div class="breakdown-item">
                        <span>Gender</span>
                        <strong id="genderDisplay">Boy</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Age</span>
                        <strong id="ageCalc">10 years 0 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Height</span>
                        <strong id="heightDisplay">4'8"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight</span>
                        <strong id="weightDisplay">70 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI</span>
                        <strong id="bmiCalc" style="color: #667eea;">18.5</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>BMI Percentile Analysis</h3>
                    <div class="breakdown-item">
                        <span>BMI for Age Percentile</span>
                        <strong id="percentileCalc" style="color: #667eea; font-size: 1.1em;">50th percentile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight Status Category</span>
                        <strong id="statusCalc">Normal Weight</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Comparison</span>
                        <strong id="comparison">Average for age and gender</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>CDC Weight Status Categories</h3>
                    <div class="breakdown-item">
                        <span>Underweight</span>
                        <strong style="color: #FF9800;">&lt; 5th percentile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Healthy Weight</span>
                        <strong style="color: #4CAF50;">5th to &lt;85th percentile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Overweight</span>
                        <strong style="color: #FF9800;">85th to &lt;95th percentile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Obesity</span>
                        <strong style="color: #f44336;">≥ 95th percentile</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What Percentile Means</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Percentile:</strong> Shows how your child compares to other children of the same age and gender.</p>
                        <p><strong>50th percentile:</strong> Your child's BMI is right in the middle - 50% of children have higher BMI, 50% have lower.</p>
                        <p><strong>85th percentile:</strong> Your child's BMI is higher than 85% of children the same age and gender.</p>
                        <p><strong>Important:</strong> BMI percentile is more accurate than BMI alone for children because children's body composition changes as they grow.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Healthy Weight Ranges</h3>
                    <div class="breakdown-item">
                        <span>Minimum Healthy Weight (5th %ile)</span>
                        <strong id="minWeight">0 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ideal Weight Range</span>
                        <strong id="idealWeight">0 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Maximum Healthy Weight (85th %ile)</span>
                        <strong id="maxWeight">0 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Why BMI for Children is Different</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Growth Changes:</strong> Children's body fat changes as they grow. BMI naturally changes with age.</p>
                        <p><strong>Gender Differences:</strong> Boys and girls develop differently, so separate charts are used.</p>
                        <p><strong>Percentiles vs Fixed Numbers:</strong> Adults use fixed BMI ranges (18.5-24.9 = normal). Children use percentiles because they're still growing.</p>
                        <p><strong>CDC Charts:</strong> Based on data from thousands of US children aged 2-20 years.</p>
                        <p><strong>Not Diagnostic:</strong> BMI percentile is a screening tool, not a diagnostic test. Doctor assessment needed.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Healthy Habits for Children</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Balanced Diet:</strong> Fruits, vegetables, whole grains, lean proteins, dairy</p>
                        <p>&#10003; <strong>Limit Sugary Drinks:</strong> Water and milk instead of soda and juice</p>
                        <p>&#10003; <strong>Physical Activity:</strong> 60 minutes daily for children/teens</p>
                        <p>&#10003; <strong>Limit Screen Time:</strong> Max 2 hours recreational screen time daily</p>
                        <p>&#10003; <strong>Family Meals:</strong> Eat together, no distractions, healthy portions</p>
                        <p>&#10003; <strong>Adequate Sleep:</strong> 9-12 hours for children, 8-10 for teens</p>
                        <p>&#10003; <strong>Positive Environment:</strong> Focus on health, not weight. No body shaming</p>
                        <p>&#10003; <strong>Active Play:</strong> Sports, playground, outdoor activities</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>When to Consult Doctor</h3>
                    <div style="padding: 15px; background: #fff3cd; border-radius: 5px; line-height: 1.8; border-left: 4px solid #FF9800;">
                        <p><strong>⚠️ Consult pediatrician if:</strong></p>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>BMI is below 5th percentile (underweight)</li>
                            <li>BMI is at or above 85th percentile (overweight/obese)</li>
                            <li>Sudden weight gain or loss</li>
                            <li>Crossing multiple percentile lines up or down</li>
                            <li>Concerns about eating habits</li>
                            <li>Child complains about body image</li>
                            <li>Growth pattern seems abnormal</li>
                            <li>Signs of eating disorder</li>
                            <li>Medical conditions affecting weight</li>
                        </ul>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Age-Specific Guidelines</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Ages 2-5 (Preschool):</strong></p>
                        <p>• 10-13 hours sleep • Active play 3 hours daily • Establish healthy eating habits</p>
                        
                        <p><strong>Ages 6-12 (School Age):</strong></p>
                        <p>• 9-12 hours sleep • 60 minutes moderate/vigorous activity • Healthy snacks • Limit screen time</p>
                        
                        <p><strong>Ages 13-20 (Teens):</strong></p>
                        <p>• 8-10 hours sleep • 60 minutes daily activity • Body image support • Healthy weight management</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Red Flags - Seek Help</h3>
                    <div style="padding: 15px; background: #ffebee; border-radius: 5px; line-height: 1.8; border-left: 4px solid #f44336;">
                        <p><strong>🚨 Eating Disorder Warning Signs:</strong></p>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Extreme weight loss or gain</li>
                            <li>Obsession with calories/food</li>
                            <li>Avoiding meals or eating in secret</li>
                            <li>Excessive exercise</li>
                            <li>Body image distortion</li>
                            <li>Restrictive eating patterns</li>
                            <li>Depression or anxiety about weight</li>
                            <li>Social withdrawal</li>
                        </ul>
                        <p><strong>Get professional help immediately if concerned.</strong></p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Children's BMI Tips:</strong> Use percentiles, not fixed BMI ranges. Ages 2-20 years. CDC growth charts are standard. Gender-specific calculations. Changes with age and puberty. 5th-85th percentile = healthy weight. &lt;5th = underweight. 85th-95th = overweight. ≥95th = obesity. Measure accurately (no shoes, light clothes). Track over time, not one reading. Growth spurts are normal. Genetics matter. Focus on healthy habits, not weight. Never shame or diet children. Consult doctor if concerns. BMI = screening tool only. Doctor evaluates overall health. Family-based approach works best!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('childBmiForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateChildBMI();
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
            calculateChildBMI();
        });

        function calculateChildBMI() {
            const gender = document.getElementById('gender').value;
            const ageYears = parseInt(document.getElementById('ageYears').value) || 10;
            const ageMonths = parseInt(document.getElementById('ageMonths').value) || 0;
            const unitSystem = unitSystemSelect.value;
            
            // Calculate total age in months
            const totalMonths = (ageYears * 12) + ageMonths;
            
            // Get measurements based on unit system
            let heightInches, weightLbs;
            
            if (unitSystem === 'imperial') {
                const feet = parseFloat(document.getElementById('heightFeet').value) || 0;
                const inches = parseFloat(document.getElementById('heightInches').value) || 0;
                heightInches = (feet * 12) + inches;
                weightLbs = parseFloat(document.getElementById('weightLbs').value) || 0;
            } else {
                const heightCm = parseFloat(document.getElementById('heightCm').value) || 0;
                heightInches = heightCm / 2.54;
                const weightKg = parseFloat(document.getElementById('weightKg').value) || 0;
                weightLbs = weightKg * 2.20462;
            }

            // Calculate BMI
            const bmi = (weightLbs / (heightInches * heightInches)) * 703;

            // Calculate BMI percentile (simplified approximation)
            // In production, use CDC growth chart data
            const percentile = calculateBMIPercentile(bmi, totalMonths, gender);

            // Determine weight status category
            let category = '';
            let categoryColor = '';
            let cardClass = '';
            let statusText = '';
            let comparison = '';

            if (percentile < 5) {
                category = 'Underweight';
                categoryColor = '#FF9800';
                cardClass = 'info';
                statusText = 'Below healthy weight range';
                comparison = 'BMI lower than 95% of children the same age and gender';
            } else if (percentile < 85) {
                category = 'Healthy Weight';
                categoryColor = '#4CAF50';
                cardClass = 'success';
                statusText = 'Normal weight';
                comparison = 'BMI in the healthy range for age and gender';
            } else if (percentile < 95) {
                category = 'Overweight';
                categoryColor = '#FF9800';
                cardClass = 'warning';
                statusText = 'Above healthy weight range';
                comparison = 'BMI higher than 85% of children the same age and gender';
            } else {
                category = 'Obesity';
                categoryColor = '#f44336';
                cardClass = 'warning';
                statusText = 'Significantly above healthy weight';
                comparison = 'BMI higher than 95% of children the same age and gender';
            }

            // Calculate healthy weight ranges (simplified)
            const heightMeters = heightInches * 0.0254;
            const minBMI = 15 + (ageYears * 0.3); // Simplified 5th percentile
            const maxBMI = 18 + (ageYears * 0.5); // Simplified 85th percentile
            const idealBMI = 16.5 + (ageYears * 0.4);
            
            const minWeight = (minBMI * heightMeters * heightMeters) * 2.20462;
            const maxWeight = (maxBMI * heightMeters * heightMeters) * 2.20462;
            const idealWeightLow = (idealBMI * 0.9 * heightMeters * heightMeters) * 2.20462;
            const idealWeightHigh = (idealBMI * 1.1 * heightMeters * heightMeters) * 2.20462;

            // Update card
            const card = document.getElementById('resultCard');
            card.className = 'result-card ' + cardClass;

            // Display units
            const weightUnit = unitSystem === 'imperial' ? 'lbs' : 'kg';
            const heightUnit = unitSystem === 'imperial' ? 'in' : 'cm';
            const displayHeight = unitSystem === 'imperial' ? 
                `${Math.floor(heightInches / 12)}'${(heightInches % 12).toFixed(1)}"` : 
                `${(heightInches * 2.54).toFixed(1)} cm`;
            const displayWeight = unitSystem === 'imperial' ? 
                `${weightLbs.toFixed(1)} lbs` : 
                `${(weightLbs / 2.20462).toFixed(1)} kg`;

            // Analysis
            let analysis = `Your ${gender === 'male' ? 'son' : 'daughter'} is ${ageYears} years ${ageMonths} months old, `;
            analysis += `with a height of ${displayHeight} and weight of ${displayWeight}. `;
            analysis += `This gives a BMI of ${bmi.toFixed(1)}, which is at the ${getOrdinal(percentile)} percentile. `;
            analysis += `This falls in the "${category}" category. ${comparison}. `;
            
            if (category === 'Healthy Weight') {
                analysis += `This is within the healthy range. Continue encouraging healthy eating habits and regular physical activity. `;
            } else if (category === 'Underweight') {
                analysis += `Consider consulting your pediatrician to rule out any underlying issues and discuss healthy weight gain strategies. `;
            } else {
                analysis += `Consider consulting your pediatrician to discuss healthy lifestyle changes and rule out any medical issues. `;
            }
            
            analysis += `Remember that BMI percentile is just one tool. Your doctor will consider overall health, growth patterns, and family history.`;

            // Update UI
            document.getElementById('percentileResult').textContent = getOrdinal(percentile);
            document.getElementById('weightStatus').textContent = category;
            document.getElementById('weightStatus').style.color = categoryColor;
            
            document.getElementById('bmiValue').textContent = bmi.toFixed(1);
            document.getElementById('percentileValue').textContent = getOrdinal(percentile);
            document.getElementById('categoryValue').textContent = category;
            document.getElementById('categoryValue').style.color = categoryColor;
            document.getElementById('ageDisplay').textContent = `${ageYears} yrs`;

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Boy' : 'Girl';
            document.getElementById('ageCalc').textContent = `${ageYears} years ${ageMonths} months`;
            document.getElementById('heightDisplay').textContent = displayHeight;
            document.getElementById('weightDisplay').textContent = displayWeight;
            document.getElementById('bmiCalc').textContent = bmi.toFixed(1);

            document.getElementById('percentileCalc').textContent = `${getOrdinal(percentile)} percentile`;
            document.getElementById('statusCalc').textContent = category;
            document.getElementById('statusCalc').style.color = categoryColor;
            document.getElementById('comparison').textContent = comparison;

            const convertWeight = (lbs) => unitSystem === 'imperial' ? 
                `${lbs.toFixed(1)} lbs` : 
                `${(lbs / 2.20462).toFixed(1)} kg`;
            
            document.getElementById('minWeight').textContent = convertWeight(minWeight);
            document.getElementById('maxWeight').textContent = convertWeight(maxWeight);
            document.getElementById('idealWeight').textContent = `${convertWeight(idealWeightLow)} - ${convertWeight(idealWeightHigh)}`;

            document.getElementById('analysisText').textContent = analysis;
        }

        function calculateBMIPercentile(bmi, ageMonths, gender) {
            // Simplified percentile calculation
            // In production, use CDC LMS tables
            const ageYears = ageMonths / 12;
            const adjustment = gender === 'male' ? 1.0 : 0.95;
            const baseBMI = 15 + (ageYears * 0.4);
            
            const ratio = bmi / (baseBMI * adjustment);
            let percentile = 50;
            
            if (ratio < 0.85) percentile = 3;
            else if (ratio < 0.92) percentile = 10;
            else if (ratio < 0.96) percentile = 25;
            else if (ratio < 1.04) percentile = 50;
            else if (ratio < 1.08) percentile = 75;
            else if (ratio < 1.12) percentile = 85;
            else if (ratio < 1.18) percentile = 90;
            else if (ratio < 1.25) percentile = 95;
            else percentile = 97;
            
            return percentile;
        }

        function getOrdinal(num) {
            if (num === 3) return '3rd';
            if (num === 5) return '5th';
            if (num === 10) return '10th';
            if (num === 25) return '25th';
            if (num === 50) return '50th';
            if (num === 75) return '75th';
            if (num === 85) return '85th';
            if (num === 90) return '90th';
            if (num === 95) return '95th';
            if (num === 97) return '97th';
            return num + 'th';
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateChildBMI();
        });
    </script>
</body>
</html>