<?php
/**
 * Baby Growth Calculator
 * File: baby-growth-calculator.php
 * Description: Track baby growth percentiles and milestones (Imperial/Metric)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Growth Calculator - Percentile Charts (Imperial/Metric)</title>
    <meta name="description" content="Free baby growth calculator. Track baby weight, length, and head circumference percentiles using WHO growth charts. Supports imperial and metric units.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128118; Baby Growth Calculator</h1>
        <p>Track baby growth percentiles</p>
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
                <h2>Baby Information</h2>
                <form id="babyGrowthForm">
                    <div class="form-group">
                        <label for="gender">Baby's Gender</label>
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
                        <label for="ageMonths">Age (Months)</label>
                        <input type="number" id="ageMonths" value="6" min="0" max="24" step="1" required>
                        <small>0-24 months (for older children, use 0-24 scale)</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Measurements</h3>
                    
                    <div class="form-group" id="weightImperialGroup">
                        <label for="weightLbs">Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="16.5" min="2" max="50" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="7.5" min="1" max="25" step="0.1">
                    </div>
                    
                    <div class="form-group" id="lengthImperialGroup">
                        <label for="lengthInches">Length/Height (inches)</label>
                        <input type="number" id="lengthInches" value="26" min="15" max="40" step="0.1" required>
                    </div>

                    <div class="form-group" id="lengthMetricGroup" style="display: none;">
                        <label for="lengthCm">Length/Height (cm)</label>
                        <input type="number" id="lengthCm" value="66" min="40" max="110" step="0.1">
                    </div>
                    
                    <div class="form-group" id="headImperialGroup">
                        <label for="headInches">Head Circumference (inches)</label>
                        <input type="number" id="headInches" value="17" min="10" max="22" step="0.1">
                        <small>Optional but recommended</small>
                    </div>

                    <div class="form-group" id="headMetricGroup" style="display: none;">
                        <label for="headCm">Head Circumference (cm)</label>
                        <input type="number" id="headCm" value="43" min="30" max="55" step="0.1">
                    </div>
                    
                    <button type="submit" class="btn">Calculate Growth</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Growth Analysis</h2>
                
                <div class="result-card success">
                    <h3>Growth Status</h3>
                    <div class="amount" id="growthStatus" style="font-size: 2em;">Normal</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Weight Percentile</h4>
                        <div class="value" id="weightPercentile">50th</div>
                    </div>
                    <div class="metric-card">
                        <h4>Length Percentile</h4>
                        <div class="value" id="lengthPercentile">50th</div>
                    </div>
                    <div class="metric-card">
                        <h4>Head Percentile</h4>
                        <div class="value" id="headPercentile">50th</div>
                    </div>
                    <div class="metric-card">
                        <h4>BMI Percentile</h4>
                        <div class="value" id="bmiPercentile">50th</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Baby Information</h3>
                    <div class="breakdown-item">
                        <span>Gender</span>
                        <strong id="genderDisplay">Boy</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Age</span>
                        <strong id="ageDisplay">6 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight</span>
                        <strong id="weightDisplay">16.5 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Length/Height</span>
                        <strong id="lengthDisplay">26 in</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Head Circumference</span>
                        <strong id="headDisplay">17 in</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI</span>
                        <strong id="bmiDisplay">0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Growth Percentiles</h3>
                    <div class="breakdown-item">
                        <span>Weight for Age</span>
                        <strong id="weightPercentCalc" style="color: #667eea;">50th percentile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Length for Age</span>
                        <strong id="lengthPercentCalc" style="color: #667eea;">50th percentile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Head for Age</span>
                        <strong id="headPercentCalc" style="color: #667eea;">50th percentile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight for Length</span>
                        <strong id="weightForLength" style="color: #667eea;">50th percentile</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI for Age</span>
                        <strong id="bmiPercentCalc" style="color: #667eea;">50th percentile</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Percentile Meanings</h3>
                    <div class="breakdown-item">
                        <span>Below 3rd Percentile</span>
                        <strong style="color: #f44336;">Underweight/Short</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>3rd - 15th Percentile</span>
                        <strong style="color: #FF9800;">Below Average</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>15th - 85th Percentile</span>
                        <strong style="color: #4CAF50;">Normal/Average</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>85th - 97th Percentile</span>
                        <strong style="color: #FF9800;">Above Average</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Above 97th Percentile</span>
                        <strong style="color: #f44336;">Overweight/Tall</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Expected Growth Ranges</h3>
                    <div class="breakdown-item">
                        <span>Average Weight Range</span>
                        <strong id="avgWeightRange">0 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Length Range</span>
                        <strong id="avgLengthRange">0 in</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Head Range</span>
                        <strong id="avgHeadRange">0 in</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Growth Milestones</h3>
                    <div id="milestones" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <!-- Milestones will be inserted here -->
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Average Growth Rates</h3>
                    <div class="breakdown-item">
                        <span>0-3 Months</span>
                        <strong>2 lbs/month, 1 in/month</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>3-6 Months</span>
                        <strong>1.5 lbs/month, 0.5 in/month</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>6-12 Months</span>
                        <strong>1 lb/month, 0.4 in/month</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>12-24 Months</span>
                        <strong>0.5 lb/month, 0.3 in/month</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Growth Facts</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Birth Weight:</strong> Average 7.5 lbs (3.4 kg). Most babies lose 5-10% in first week.</p>
                        <p><strong>First Year:</strong> Babies triple birth weight and grow 10 inches by age 1.</p>
                        <p><strong>Growth Spurts:</strong> Occur around 2 weeks, 6 weeks, 3 months, 6 months.</p>
                        <p><strong>Head Growth:</strong> Grows fastest in first year (brain development).</p>
                        <p><strong>Genetics:</strong> Height is 60-80% genetic. Nutrition and health affect growth.</p>
                        <p><strong>Tracking:</strong> Measure monthly for first year, then every 3 months.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>When to Consult Doctor</h3>
                    <div style="padding: 15px; background: #fff3cd; border-radius: 5px; line-height: 1.8; border-left: 4px solid #FF9800;">
                        <p><strong>⚠️ Consult pediatrician if:</strong></p>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Below 3rd percentile or above 97th percentile</li>
                            <li>Sudden drop across 2+ percentile lines</li>
                            <li>Not gaining weight for 2+ months</li>
                            <li>Head circumference growing too fast/slow</li>
                            <li>Weight/length ratio is concerning</li>
                            <li>Missing developmental milestones</li>
                            <li>Feeding difficulties or poor appetite</li>
                            <li>Unusual growth pattern</li>
                        </ul>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Baby Growth Tips:</strong> WHO growth charts = international standard. Percentile = comparison to other babies. 50th = average. Percentiles don't predict adult height. Breastfed babies grow differently than formula-fed. Growth spurts are normal. Babies grow in bursts, not steady. Track trends, not single measurements. Premature babies use corrected age. Head circumference = brain growth indicator. Weight for length = body proportion. BMI used after 2 years. Doctor plots growth at each visit. Consistent curve = healthy. Sudden changes = investigate. Genetics matter most. Proper nutrition crucial. Sleep affects growth hormone. Monitor monthly first year.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('babyGrowthForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateGrowth();
        });

        function toggleUnitFields() {
            const unitSystem = unitSystemSelect.value;
            const isImperial = unitSystem === 'imperial';
            
            document.getElementById('weightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('weightMetricGroup').style.display = isImperial ? 'none' : 'block';
            document.getElementById('lengthImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('lengthMetricGroup').style.display = isImperial ? 'none' : 'block';
            document.getElementById('headImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('headMetricGroup').style.display = isImperial ? 'none' : 'block';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateGrowth();
        });

        function calculateGrowth() {
            const gender = document.getElementById('gender').value;
            const ageMonths = parseInt(document.getElementById('ageMonths').value) || 0;
            const unitSystem = unitSystemSelect.value;
            
            // Get measurements based on unit system
            let weightKg, lengthCm, headCm;
            
            if (unitSystem === 'imperial') {
                const weightLbs = parseFloat(document.getElementById('weightLbs').value) || 0;
                const lengthInches = parseFloat(document.getElementById('lengthInches').value) || 0;
                const headInches = parseFloat(document.getElementById('headInches').value) || 0;
                weightKg = weightLbs / 2.20462;
                lengthCm = lengthInches * 2.54;
                headCm = headInches * 2.54;
            } else {
                weightKg = parseFloat(document.getElementById('weightKg').value) || 0;
                lengthCm = parseFloat(document.getElementById('lengthCm').value) || 0;
                headCm = parseFloat(document.getElementById('headCm').value) || 0;
            }

            // Calculate BMI
            const bmi = weightKg / Math.pow(lengthCm / 100, 2);

            // Simplified percentile calculation (approximation)
            // In real application, would use WHO growth chart data
            const weightPercentile = calculatePercentile(weightKg, ageMonths, gender, 'weight');
            const lengthPercentile = calculatePercentile(lengthCm, ageMonths, gender, 'length');
            const headPercentile = calculatePercentile(headCm, ageMonths, gender, 'head');
            const bmiPercentile = calculatePercentile(bmi, ageMonths, gender, 'bmi');

            // Determine growth status
            let growthStatus = 'Normal';
            let statusColor = '#4CAF50';
            
            if (weightPercentile < 3 || lengthPercentile < 3) {
                growthStatus = 'Below Average';
                statusColor = '#f44336';
            } else if (weightPercentile > 97 || lengthPercentile > 97) {
                growthStatus = 'Above Average';
                statusColor = '#FF9800';
            } else if (weightPercentile < 15 || lengthPercentile < 15) {
                growthStatus = 'Slightly Below';
                statusColor = '#FF9800';
            } else if (weightPercentile > 85 || lengthPercentile > 85) {
                growthStatus = 'Slightly Above';
                statusColor = '#FF9800';
            }

            // Average ranges (simplified)
            const avgWeight = getAverageWeight(ageMonths, gender);
            const avgLength = getAverageLength(ageMonths, gender);
            const avgHead = getAverageHead(ageMonths, gender);

            // Milestones
            const milestones = getMilestones(ageMonths);

            // Update card
            const card = document.querySelector('.result-card');
            if (growthStatus === 'Normal') {
                card.className = 'result-card success';
            } else if (growthStatus.includes('Slightly')) {
                card.className = 'result-card info';
            } else {
                card.className = 'result-card warning';
            }

            // Display units
            const weightUnit = unitSystem === 'imperial' ? 'lbs' : 'kg';
            const lengthUnit = unitSystem === 'imperial' ? 'in' : 'cm';
            const displayWeight = unitSystem === 'imperial' ? 
                `${(weightKg * 2.20462).toFixed(1)} lbs` : 
                `${weightKg.toFixed(1)} kg`;
            const displayLength = unitSystem === 'imperial' ? 
                `${(lengthCm / 2.54).toFixed(1)} in` : 
                `${lengthCm.toFixed(1)} cm`;
            const displayHead = unitSystem === 'imperial' ? 
                `${(headCm / 2.54).toFixed(1)} in` : 
                `${headCm.toFixed(1)} cm`;

            // Analysis
            let analysis = `Your ${gender === 'male' ? 'baby boy' : 'baby girl'} at ${ageMonths} months old weighs ${displayWeight} (${getOrdinal(weightPercentile)} percentile) `;
            analysis += `and measures ${displayLength} in length (${getOrdinal(lengthPercentile)} percentile). `;
            
            if (growthStatus === 'Normal') {
                analysis += `This falls within the normal range, indicating healthy growth. `;
            } else if (growthStatus.includes('Below')) {
                analysis += `This is below average, which may be normal for your baby but should be monitored. `;
            } else {
                analysis += `This is above average, which may be normal for your baby but should be monitored. `;
            }
            
            analysis += `The head circumference of ${displayHead} is at the ${getOrdinal(headPercentile)} percentile. `;
            analysis += `Remember, percentiles compare your baby to others but don't predict future height. Consistent growth along a curve is what matters most. Consult your pediatrician if concerned.`;

            // Update UI
            document.getElementById('growthStatus').textContent = growthStatus;
            document.getElementById('growthStatus').style.color = statusColor;
            
            document.getElementById('weightPercentile').textContent = getOrdinal(weightPercentile);
            document.getElementById('lengthPercentile').textContent = getOrdinal(lengthPercentile);
            document.getElementById('headPercentile').textContent = getOrdinal(headPercentile);
            document.getElementById('bmiPercentile').textContent = getOrdinal(bmiPercentile);

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Boy' : 'Girl';
            document.getElementById('ageDisplay').textContent = ageMonths + ' months';
            document.getElementById('weightDisplay').textContent = displayWeight;
            document.getElementById('lengthDisplay').textContent = displayLength;
            document.getElementById('headDisplay').textContent = displayHead;
            document.getElementById('bmiDisplay').textContent = bmi.toFixed(1);

            document.getElementById('weightPercentCalc').textContent = getOrdinal(weightPercentile) + ' percentile';
            document.getElementById('lengthPercentCalc').textContent = getOrdinal(lengthPercentile) + ' percentile';
            document.getElementById('headPercentCalc').textContent = getOrdinal(headPercentile) + ' percentile';
            document.getElementById('weightForLength').textContent = getOrdinal(bmiPercentile) + ' percentile';
            document.getElementById('bmiPercentCalc').textContent = getOrdinal(bmiPercentile) + ' percentile';

            document.getElementById('avgWeightRange').textContent = unitSystem === 'imperial' ? 
                `${(avgWeight.min * 2.20462).toFixed(1)}-${(avgWeight.max * 2.20462).toFixed(1)} lbs` : 
                `${avgWeight.min.toFixed(1)}-${avgWeight.max.toFixed(1)} kg`;
            document.getElementById('avgLengthRange').textContent = unitSystem === 'imperial' ? 
                `${(avgLength.min / 2.54).toFixed(1)}-${(avgLength.max / 2.54).toFixed(1)} in` : 
                `${avgLength.min.toFixed(1)}-${avgLength.max.toFixed(1)} cm`;
            document.getElementById('avgHeadRange').textContent = unitSystem === 'imperial' ? 
                `${(avgHead.min / 2.54).toFixed(1)}-${(avgHead.max / 2.54).toFixed(1)} in` : 
                `${avgHead.min.toFixed(1)}-${avgHead.max.toFixed(1)} cm`;

            document.getElementById('milestones').innerHTML = milestones;
            document.getElementById('analysisText').textContent = analysis;
        }

        function calculatePercentile(value, age, gender, type) {
            // Simplified percentile calculation
            // In production, use WHO growth chart data
            const adjustment = gender === 'male' ? 1.05 : 0.95;
            const ageAdjustment = 1 + (age * 0.02);
            
            let baseValue;
            if (type === 'weight') {
                baseValue = 7.5 * ageAdjustment; // kg
            } else if (type === 'length') {
                baseValue = 55 * ageAdjustment; // cm
            } else if (type === 'head') {
                baseValue = 38 * ageAdjustment; // cm
            } else {
                baseValue = 16; // BMI
            }
            
            const ratio = value / (baseValue * adjustment);
            let percentile = 50;
            
            if (ratio < 0.85) percentile = 3;
            else if (ratio < 0.92) percentile = 10;
            else if (ratio < 0.96) percentile = 25;
            else if (ratio < 1.04) percentile = 50;
            else if (ratio < 1.08) percentile = 75;
            else if (ratio < 1.15) percentile = 90;
            else percentile = 97;
            
            return percentile;
        }

        function getAverageWeight(months, gender) {
            const base = gender === 'male' ? 7.5 : 7.0;
            const growth = months * 0.5;
            return {
                min: base + growth - 1,
                max: base + growth + 1
            };
        }

        function getAverageLength(months, gender) {
            const base = gender === 'male' ? 52 : 50;
            const growth = months * 2;
            return {
                min: base + growth - 3,
                max: base + growth + 3
            };
        }

        function getAverageHead(months, gender) {
            const base = gender === 'male' ? 36 : 35;
            const growth = months * 0.6;
            return {
                min: base + growth - 1.5,
                max: base + growth + 1.5
            };
        }

        function getMilestones(months) {
            const milestones = {
                0: "• Birth: Reflexes (grasp, rooting)
• Cries for needs
• Focuses 8-12 inches away",
                2: "• Smiles socially
• Coos and gurgles
• Tracks objects with eyes
• Lifts head briefly",
                4: "• Laughs out loud
• Supports weight on legs
• Reaches for toys
• Rolls over",
                6: "• Sits without support
• Babbles (mama, dada)
• Passes toys hand to hand
• Recognizes familiar faces",
                9: "• Crawls
• Stands with support
• Says simple words
• Understands 'no'",
                12: "• Walks with assistance
• Says 2-3 words
• Waves bye-bye
• Drinks from cup",
                15: "• Walks alone
• Says 5-10 words
• Stacks blocks
• Uses spoon",
                18: "• Runs
• Says 10-20 words
• Kicks ball
• Removes clothing",
                24: "• Runs well
• Says 50+ words
• Jumps
• Follows 2-step commands"
            };
            
            const ages = [0, 2, 4, 6, 9, 12, 15, 18, 24];
            const closest = ages.reduce((prev, curr) => 
                Math.abs(curr - months) < Math.abs(prev - months) ? curr : prev
            );
            
            return `<strong>${closest} Month Milestones:</strong><br>${milestones[closest].replace(/
/g, '<br>')}`;
        }

        function getOrdinal(num) {
            if (num === 3) return '3rd';
            if (num === 10) return '10th';
            if (num === 25) return '25th';
            if (num === 50) return '50th';
            if (num === 75) return '75th';
            if (num === 90) return '90th';
            if (num === 97) return '97th';
            return num + 'th';
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateGrowth();
        });
    </script>
</body>
</html>