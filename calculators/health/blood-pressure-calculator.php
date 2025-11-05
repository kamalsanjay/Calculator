<?php
/**
 * Blood Pressure Calculator
 * File: blood-pressure-calculator.php
 * Description: Calculate blood pressure category and risk assessment
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Pressure Calculator - Check Your BP Category & Risk Assessment</title>
    <meta name="description" content="Free Blood Pressure Calculator. Check your BP category, understand risks, and get personalized recommendations based on systolic and diastolic readings.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>❤️ Blood Pressure Calculator</h1>
        <p>Check your BP category and understand your cardiovascular health</p>
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
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
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
            color: #e74c3c;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #c0392b;
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
            color: #e74c3c;
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
            border-color: #e74c3c;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #888;
            font-size: 0.9em;
        }
        
        .btn {
            background: #e74c3c;
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
            background: #c0392b;
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
        
        .elevated {
            background: linear-gradient(135deg, #FFC107 0%, #FFA000 100%);
        }
        
        .hypertension-stage1 {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
        }
        
        .hypertension-stage2 {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        }
        
        .hypertensive-crisis {
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
            color: #e74c3c;
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
            color: #e74c3c;
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
            background: #ffebee;
            border-left: 4px solid #e74c3c;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box strong {
            color: #c0392b;
        }
        
        .bp-chart {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        
        .bp-chart th, .bp-chart td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .bp-chart th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #555;
        }
        
        .bp-chart tr:hover {
            background-color: #f5f5f5;
        }
        
        .bp-chart .current-category {
            background-color: #ffebee;
            font-weight: bold;
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
                <h2>Blood Pressure Readings</h2>
                <form id="bloodPressureForm">
                    <div class="form-group">
                        <label for="systolic">Systolic Pressure (mm Hg)</label>
                        <input type="number" id="systolic" value="120" min="50" max="250" step="1" required>
                        <small>Top number - pressure when heart beats</small>
                    </div>

                    <div class="form-group">
                        <label for="diastolic">Diastolic Pressure (mm Hg)</label>
                        <input type="number" id="diastolic" value="80" min="30" max="150" step="1" required>
                        <small>Bottom number - pressure when heart rests</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" value="35" min="1" max="120" step="1" required>
                        <small>Age affects blood pressure interpretation</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="medication">Taking Blood Pressure Medication?</label>
                        <select id="medication">
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Analyze Blood Pressure</button>
                </form>
                
                <div class="breakdown" style="margin-top: 30px;">
                    <h3>How to Measure Blood Pressure</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>1. Preparation:</strong> Avoid caffeine, exercise, and smoking for 30 minutes before measurement. Rest for 5 minutes.</p>
                        <p><strong>2. Position:</strong> Sit with back supported, feet flat on floor, arm supported at heart level.</p>
                        <p><strong>3. Cuff Placement:</strong> Place cuff on bare upper arm, 1-2 inches above elbow.</p>
                        <p><strong>4. Measurement:</strong> Remain still and quiet during measurement. Take 2-3 readings, 1 minute apart.</p>
                        <p><strong>5. Record:</strong> Note both systolic (first sound) and diastolic (disappearance of sound) values.</p>
                    </div>
                </div>
            </div>

            <div class="results-section">
                <h2>Blood Pressure Analysis</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Blood Pressure Category</h3>
                    <div class="amount" id="bpCategory">Normal</div>
                    <div class="category" id="bpReadings">120/80 mm Hg</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Systolic</h4>
                        <div class="value" id="systolicValue">120</div>
                    </div>
                    <div class="metric-card">
                        <h4>Diastolic</h4>
                        <div class="value" id="diastolicValue">80</div>
                    </div>
                    <div class="metric-card">
                        <h4>Pulse Pressure</h4>
                        <div class="value" id="pulsePressure">40</div>
                    </div>
                    <div class="metric-card">
                        <h4>Mean Arterial Pressure</h4>
                        <div class="value" id="mapValue">93</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Readings</h3>
                    <div class="breakdown-item">
                        <span>Systolic Pressure</span>
                        <strong id="systolicDisplay">120 mm Hg</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Diastolic Pressure</span>
                        <strong id="diastolicDisplay">80 mm Hg</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Blood Pressure</span>
                        <strong id="bpDisplay">120/80 mm Hg</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Age</span>
                        <strong id="ageDisplay">35 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gender</span>
                        <strong id="genderDisplay">Male</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Medication</span>
                        <strong id="medicationDisplay">No</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Blood Pressure Categories</h3>
                    <table class="bp-chart">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Systolic (mm Hg)</th>
                                <th>Diastolic (mm Hg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="normalRow">
                                <td>Normal</td>
                                <td>&lt; 120</td>
                                <td>&lt; 80</td>
                            </tr>
                            <tr id="elevatedRow">
                                <td>Elevated</td>
                                <td>120-129</td>
                                <td>&lt; 80</td>
                            </tr>
                            <tr id="hypertension1Row">
                                <td>Hypertension Stage 1</td>
                                <td>130-139</td>
                                <td>80-89</td>
                            </tr>
                            <tr id="hypertension2Row">
                                <td>Hypertension Stage 2</td>
                                <td>≥ 140</td>
                                <td>≥ 90</td>
                            </tr>
                            <tr id="crisisRow">
                                <td>Hypertensive Crisis</td>
                                <td>≥ 180</td>
                                <td>≥ 120</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Risk Assessment</h3>
                    <div class="breakdown-item">
                        <span>Cardiovascular Risk</span>
                        <strong id="cvRisk">Low</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Recommended Action</span>
                        <strong id="recommendedAction">Maintain healthy lifestyle</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Follow-up</span>
                        <strong id="followUp">Recheck in 2 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Medical Consultation</span>
                        <strong id="medicalConsultation">Not urgently needed</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Health Recommendations</h3>
                    <div id="recommendations" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="recommendationsText" style="margin: 0;">Your blood pressure is in the normal range. Continue maintaining a healthy lifestyle with regular exercise, balanced diet, and stress management.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;">Your blood pressure reading of 120/80 mm Hg falls within the normal range according to American Heart Association guidelines. This indicates healthy cardiovascular function with low risk of hypertension-related complications.</p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Blood Pressure Tips:</strong> Normal BP is below 120/80 mm Hg. Elevated BP (120-129/<80) requires lifestyle changes. Hypertension Stage 1 (130-139/80-89) may need medication. Hypertension Stage 2 (≥140/≥90) requires treatment. Hypertensive crisis (≥180/≥120) needs immediate medical attention. Regular monitoring helps detect trends. Home readings often lower than clinical readings (white coat effect). Lifestyle factors: reduce sodium, increase potassium, maintain healthy weight, exercise regularly, limit alcohol, manage stress, quit smoking. BP fluctuates throughout day - lowest at night, peaks in morning.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('bloodPressureForm');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            analyzeBloodPressure();
        });

        function analyzeBloodPressure() {
            const systolic = parseInt(document.getElementById('systolic').value) || 0;
            const diastolic = parseInt(document.getElementById('diastolic').value) || 0;
            const age = parseInt(document.getElementById('age').value) || 0;
            const gender = document.getElementById('gender').value;
            const medication = document.getElementById('medication').value;
            
            // Calculate additional metrics
            const pulsePressure = systolic - diastolic;
            const mapValue = Math.round(diastolic + (pulsePressure / 3));
            
            // Determine BP category
            let category = '';
            let categoryClass = '';
            let riskLevel = '';
            let recommendedAction = '';
            let followUp = '';
            let medicalConsultation = '';
            let recommendations = '';
            let analysis = '';
            
            if (systolic < 120 && diastolic < 80) {
                category = 'Normal';
                categoryClass = 'normal';
                riskLevel = 'Low';
                recommendedAction = 'Maintain healthy lifestyle';
                followUp = 'Recheck in 2 years';
                medicalConsultation = 'Not urgently needed';
                recommendations = 'Continue maintaining a healthy lifestyle with regular exercise, balanced diet rich in fruits and vegetables, limited sodium intake, stress management, and adequate sleep.';
                analysis = `Your blood pressure reading of ${systolic}/${diastolic} mm Hg falls within the normal range according to American Heart Association guidelines. This indicates healthy cardiovascular function with low risk of hypertension-related complications.`;
            } else if (systolic >= 120 && systolic <= 129 && diastolic < 80) {
                category = 'Elevated';
                categoryClass = 'elevated';
                riskLevel = 'Moderate';
                recommendedAction = 'Lifestyle modifications';
                followUp = 'Recheck in 6 months';
                medicalConsultation = 'Consider discussing with doctor';
                recommendations = 'Focus on lifestyle changes: reduce sodium intake, increase physical activity (150 minutes moderate exercise weekly), maintain healthy weight, limit alcohol, and manage stress through techniques like meditation or yoga.';
                analysis = `Your blood pressure reading of ${systolic}/${diastolic} mm Hg is considered elevated. While not yet hypertensive, this indicates increased risk of developing hypertension. Lifestyle modifications can help return your blood pressure to normal levels.`;
            } else if ((systolic >= 130 && systolic <= 139) || (diastolic >= 80 && diastolic <= 89)) {
                category = 'Hypertension Stage 1';
                categoryClass = 'hypertension-stage1';
                riskLevel = 'High';
                recommendedAction = 'Lifestyle changes + possible medication';
                followUp = 'Recheck in 3-6 months';
                medicalConsultation = 'Schedule doctor appointment';
                recommendations = 'Implement significant lifestyle changes and consult with a healthcare provider about potential medication. Reduce sodium to <1500mg daily, increase potassium-rich foods, achieve and maintain healthy weight, and engage in regular aerobic exercise.';
                analysis = `Your blood pressure reading of ${systolic}/${diastolic} mm Hg indicates Stage 1 Hypertension. This requires attention through lifestyle modifications and possibly medication under medical supervision to prevent progression to more severe hypertension.`;
            } else if (systolic >= 140 || diastolic >= 90) {
                if (systolic >= 180 || diastolic >= 120) {
                    category = 'Hypertensive Crisis';
                    categoryClass = 'hypertensive-crisis';
                    riskLevel = 'Very High';
                    recommendedAction = 'Seek immediate medical care';
                    followUp = 'Immediate evaluation needed';
                    medicalConsultation = 'Emergency medical attention required';
                    recommendations = 'THIS IS A MEDICAL EMERGENCY. Seek immediate medical attention. Do not wait to see if your blood pressure comes down on its own. Hypertensive crisis can lead to stroke, heart attack, or other life-threatening complications.';
                    analysis = `Your blood pressure reading of ${systolic}/${diastolic} mm Hg indicates a HYPERTENSIVE CRISIS. This is a medical emergency that requires immediate treatment to prevent organ damage. Go to the nearest emergency room or call emergency services.`;
                } else {
                    category = 'Hypertension Stage 2';
                    categoryClass = 'hypertension-stage2';
                    riskLevel = 'Very High';
                    recommendedAction = 'Lifestyle changes + medication';
                    followUp = 'Recheck in 1 month';
                    medicalConsultation = 'Schedule doctor appointment soon';
                    recommendations = 'Requires medical treatment with antihypertensive medications in addition to lifestyle modifications. Strict sodium restriction, regular monitoring, medication adherence, and frequent follow-up with healthcare provider are essential.';
                    analysis = `Your blood pressure reading of ${systolic}/${diastolic} mm Hg indicates Stage 2 Hypertension. This requires prompt medical intervention with medication and lifestyle changes to reduce the risk of heart attack, stroke, kidney disease, and other complications.`;
                }
            }
            
            // Adjust for age
            if (age > 60 && category === 'Normal') {
                recommendations += ' For your age group, maintaining systolic pressure below 150 mm Hg is generally acceptable, though lower is better if well tolerated.';
            }
            
            // Adjust for medication
            if (medication === 'yes') {
                recommendations += ' Since you are taking blood pressure medication, ensure you are taking it as prescribed and discuss any concerns with your healthcare provider.';
                analysis += ' Your current reading should be interpreted in the context of your medication regimen.';
            }
            
            // Update UI
            const card = document.getElementById('resultCard');
            card.className = `result-card ${categoryClass}`;
            
            document.getElementById('bpCategory').textContent = category;
            document.getElementById('bpReadings').textContent = `${systolic}/${diastolic} mm Hg`;
            
            document.getElementById('systolicValue').textContent = systolic;
            document.getElementById('diastolicValue').textContent = diastolic;
            document.getElementById('pulsePressure').textContent = pulsePressure;
            document.getElementById('mapValue').textContent = mapValue;
            
            document.getElementById('systolicDisplay').textContent = `${systolic} mm Hg`;
            document.getElementById('diastolicDisplay').textContent = `${diastolic} mm Hg`;
            document.getElementById('bpDisplay').textContent = `${systolic}/${diastolic} mm Hg`;
            document.getElementById('ageDisplay').textContent = `${age} years`;
            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('medicationDisplay').textContent = medication === 'yes' ? 'Yes' : 'No';
            
            document.getElementById('cvRisk').textContent = riskLevel;
            document.getElementById('recommendedAction').textContent = recommendedAction;
            document.getElementById('followUp').textContent = followUp;
            document.getElementById('medicalConsultation').textContent = medicalConsultation;
            
            document.getElementById('recommendationsText').textContent = recommendations;
            document.getElementById('analysisText').textContent = analysis;
            
            // Highlight current category in chart
            document.querySelectorAll('.bp-chart tr').forEach(row => {
                row.classList.remove('current-category');
            });
            
            if (category === 'Normal') {
                document.getElementById('normalRow').classList.add('current-category');
            } else if (category === 'Elevated') {
                document.getElementById('elevatedRow').classList.add('current-category');
            } else if (category === 'Hypertension Stage 1') {
                document.getElementById('hypertension1Row').classList.add('current-category');
            } else if (category === 'Hypertension Stage 2') {
                document.getElementById('hypertension2Row').classList.add('current-category');
            } else if (category === 'Hypertensive Crisis') {
                document.getElementById('crisisRow').classList.add('current-category');
            }
        }

        window.addEventListener('load', function() {
            analyzeBloodPressure();
        });
    </script>
</body>
</html>