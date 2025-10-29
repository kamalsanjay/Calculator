<?php
/**
 * GFR Calculator (Glomerular Filtration Rate)
 * File: gfr-calculator.php
 * Description: Calculate kidney function using eGFR formulas (CKD-EPI, MDRD, Cockcroft-Gault)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFR Calculator - eGFR & Kidney Function Calculator (CKD-EPI, MDRD)</title>
    <meta name="description" content="Free GFR calculator. Calculate estimated glomerular filtration rate (eGFR) to assess kidney function. Uses CKD-EPI, MDRD, and Cockcroft-Gault formulas.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🫘 GFR Calculator</h1>
        <p>Calculate kidney function (eGFR)</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Patient Information</h2>
                <form id="gfrForm">
                    <div class="form-group">
                        <label for="formula">Formula</label>
                        <select id="formula">
                            <option value="ckd-epi" selected>CKD-EPI (Recommended)</option>
                            <option value="mdrd">MDRD</option>
                            <option value="cockcroft">Cockcroft-Gault</option>
                        </select>
                        <small>CKD-EPI is most accurate for GFR ≥60</small>
                    </div>

                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="standard">Standard (mg/dL)</option>
                            <option value="si">SI Units (μmol/L)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Basic Information</h3>
                    
                    <div class="form-group">
                        <label for="age">Age (years)</label>
                        <input type="number" id="age" value="45" min="18" max="120" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="race">Race</label>
                        <select id="race">
                            <option value="other">Other/Not Specified</option>
                            <option value="black">Black/African American</option>
                        </select>
                        <small>Used in some formulas for accuracy</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Lab Results & Weight</h3>
                    
                    <div class="form-group" id="creatinineStandardGroup">
                        <label for="creatinineStandard">Serum Creatinine (mg/dL)</label>
                        <input type="number" id="creatinineStandard" value="1.2" min="0.1" max="20" step="0.01" required>
                        <small>Normal: 0.6-1.2 mg/dL (men), 0.5-1.1 mg/dL (women)</small>
                    </div>

                    <div class="form-group" id="creatinineSIGroup" style="display: none;">
                        <label for="creatinineSI">Serum Creatinine (μmol/L)</label>
                        <input type="number" id="creatinineSI" value="106" min="9" max="1768" step="1">
                        <small>Normal: 53-106 μmol/L (men), 44-97 μmol/L (women)</small>
                    </div>
                    
                    <div class="form-group" id="weightGroup">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="75" min="30" max="300" step="0.1">
                        <small>Required for Cockcroft-Gault formula</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate GFR</button>
                </form>
            </div>

            <div class="results-section">
                <h2>GFR Results</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Estimated GFR (eGFR)</h3>
                    <div class="amount" id="gfrResult">90 mL/min/1.73m²</div>
                    <div style="margin-top: 10px; font-size: 1.3em;" id="stageDisplay">Stage 1 - Normal</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>eGFR</h4>
                        <div class="value" id="gfrDisplay">90</div>
                    </div>
                    <div class="metric-card">
                        <h4>CKD Stage</h4>
                        <div class="value" id="stageNum">1</div>
                    </div>
                    <div class="metric-card">
                        <h4>Kidney Function</h4>
                        <div class="value" id="functionPercent">90%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Status</h4>
                        <div class="value" id="statusDisplay">Normal</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Patient Information</h3>
                    <div class="breakdown-item">
                        <span>Age</span>
                        <strong id="ageDisplay">45 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gender</span>
                        <strong id="genderDisplay">Male</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Race</span>
                        <strong id="raceDisplay">Other</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Serum Creatinine</span>
                        <strong id="creatinineDisplay">1.2 mg/dL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Formula Used</span>
                        <strong id="formulaDisplay">CKD-EPI</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Kidney Function Assessment</h3>
                    <div class="breakdown-item">
                        <span>eGFR Value</span>
                        <strong id="gfrValue" style="color: #667eea; font-size: 1.1em;">90 mL/min/1.73m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CKD Stage</span>
                        <strong id="ckdStage">Stage 1</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Kidney Function</span>
                        <strong id="kidneyFunction">Normal or High (≥90%)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Clinical Interpretation</span>
                        <strong id="interpretation">Normal kidney function</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Multiple Formula Comparison</h3>
                    <div class="breakdown-item">
                        <span>CKD-EPI Formula</span>
                        <strong id="ckdEpiResult" style="color: #4CAF50;">90 mL/min/1.73m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>MDRD Formula</span>
                        <strong id="mdrdResult">88 mL/min/1.73m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cockcroft-Gault</span>
                        <strong id="cockcroftResult">95 mL/min</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>CKD Stages (Chronic Kidney Disease)</h3>
                    <div class="breakdown-item">
                        <span>Stage 1 (Normal/High)</span>
                        <strong style="color: #4CAF50;">≥90 mL/min/1.73m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Stage 2 (Mild Decrease)</span>
                        <strong style="color: #8BC34A;">60-89 mL/min/1.73m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Stage 3a (Mild-Moderate)</span>
                        <strong style="color: #FF9800;">45-59 mL/min/1.73m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Stage 3b (Moderate-Severe)</span>
                        <strong style="color: #FF9800;">30-44 mL/min/1.73m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Stage 4 (Severe Decrease)</span>
                        <strong style="color: #f44336;">15-29 mL/min/1.73m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Stage 5 (Kidney Failure)</span>
                        <strong style="color: #d32f2f;">&lt;15 mL/min/1.73m² or dialysis</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding GFR</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>GFR (Glomerular Filtration Rate):</strong> Measures how well kidneys filter blood. Best overall indicator of kidney function.</p>
                        <p><strong>eGFR (Estimated GFR):</strong> Calculated from creatinine, age, gender, and race. More accurate than creatinine alone.</p>
                        <p><strong>Normal GFR:</strong> 90-120 mL/min/1.73m². Declines naturally with age (~1 mL/min/year after 40).</p>
                        <p><strong>Units:</strong> mL/min/1.73m² = milliliters per minute per 1.73 square meters of body surface area</p>
                        <p><strong>Creatinine:</strong> Waste product from muscle. High creatinine = low kidney function.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>GFR Formulas Explained</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>CKD-EPI (2021):</strong> Most accurate for GFR ≥60. Recommended by KDIGO. Race-free version available. Best for general population.</p>
                        <p><strong>MDRD:</strong> Older formula. More accurate for GFR &lt;60. Overestimates kidney disease in healthy people. Less used now.</p>
                        <p><strong>Cockcroft-Gault:</strong> Oldest formula. Includes body weight. Used for drug dosing. Not standardized to body surface area.</p>
                        <p><strong>Which to Use?</strong> CKD-EPI is standard for diagnosis. Cockcroft-Gault for medication dosing. Multiple formulas for confirmation.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What Each Stage Means</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Stage 1 (≥90):</strong> Normal kidney function. May have kidney damage detected by other tests. No symptoms. No treatment needed if no other issues.</p>
                        <p><strong>Stage 2 (60-89):</strong> Mild decrease. Usually no symptoms. Control blood pressure, diabetes. Regular monitoring.</p>
                        <p><strong>Stage 3a (45-59):</strong> Mild-moderate decrease. May have fatigue, fluid retention. Medication adjustments needed. See nephrologist.</p>
                        <p><strong>Stage 3b (30-44):</strong> Moderate-severe decrease. Increased risk of complications. Anemia, bone disease possible. Regular specialist care.</p>
                        <p><strong>Stage 4 (15-29):</strong> Severe decrease. Symptoms common (fatigue, swelling, nausea). Prepare for dialysis or transplant. Frequent monitoring.</p>
                        <p><strong>Stage 5 (&lt;15):</strong> Kidney failure/ESRD. Dialysis or transplant needed to survive. Severe symptoms. Specialized kidney care essential.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Causes of Low GFR (Kidney Disease)</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>• <strong>Diabetes:</strong> #1 cause (35-40% of cases). High blood sugar damages kidney filters.</p>
                        <p>• <strong>High Blood Pressure:</strong> #2 cause (25-30%). Damages blood vessels in kidneys.</p>
                        <p>• <strong>Glomerulonephritis:</strong> Inflammation of kidney filters (autoimmune, infection)</p>
                        <p>• <strong>Polycystic Kidney Disease:</strong> Genetic condition with kidney cysts</p>
                        <p>• <strong>Prolonged Obstruction:</strong> Kidney stones, enlarged prostate, tumors</p>
                        <p>• <strong>Recurrent Infections:</strong> Repeated kidney infections (pyelonephritis)</p>
                        <p>• <strong>Medications:</strong> NSAIDs, antibiotics, contrast dye (overuse or toxicity)</p>
                        <p>• <strong>Autoimmune Diseases:</strong> Lupus, vasculitis</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How to Protect Your Kidneys</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Control Blood Sugar:</strong> Keep A1C &lt;7% if diabetic. Prevents kidney damage.</p>
                        <p>&#10003; <strong>Control Blood Pressure:</strong> Target &lt;130/80 mmHg. Use ACE inhibitors/ARBs if prescribed.</p>
                        <p>&#10003; <strong>Healthy Diet:</strong> Low sodium (&lt;2,300 mg/day), limit protein if CKD, lots of vegetables</p>
                        <p>&#10003; <strong>Stay Hydrated:</strong> 6-8 glasses water daily unless restricted</p>
                        <p>&#10003; <strong>Avoid NSAIDs:</strong> Ibuprofen, naproxen can damage kidneys. Use acetaminophen instead.</p>
                        <p>&#10003; <strong>Don't Smoke:</strong> Smoking accelerates kidney disease progression</p>
                        <p>&#10003; <strong>Exercise Regularly:</strong> 30 minutes daily improves kidney health</p>
                        <p>&#10003; <strong>Maintain Healthy Weight:</strong> Obesity increases kidney disease risk</p>
                        <p>&#10003; <strong>Limit Alcohol:</strong> Excessive drinking harms kidneys</p>
                        <p>&#10003; <strong>Regular Check-ups:</strong> Annual kidney tests if at risk</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Symptoms of Kidney Disease</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Early Stages (1-3a):</strong> Usually NO symptoms. This is why testing is important!</p>
                        <p><strong>Later Stages (3b-5):</strong></p>
                        <p>• Fatigue and weakness</p>
                        <p>• Difficulty concentrating (brain fog)</p>
                        <p>• Swelling in ankles, feet, hands, face (edema)</p>
                        <p>• Shortness of breath (fluid in lungs)</p>
                        <p>• Frequent urination, especially at night</p>
                        <p>• Foamy or bubbly urine (protein)</p>
                        <p>• Blood in urine</p>
                        <p>• Decreased urine output</p>
                        <p>• Nausea and vomiting</p>
                        <p>• Loss of appetite</p>
                        <p>• Sleep problems</p>
                        <p>• Muscle cramps</p>
                        <p>• Itchy, dry skin</p>
                        <p>• High blood pressure (hard to control)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Other Kidney Tests</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Serum Creatinine:</strong> Blood test. High creatinine = low kidney function.</p>
                        <p><strong>BUN (Blood Urea Nitrogen):</strong> Waste product. High BUN = kidney problems.</p>
                        <p><strong>BUN/Creatinine Ratio:</strong> Normal 10:1 to 20:1. Helps identify cause.</p>
                        <p><strong>Urinalysis:</strong> Check for protein, blood, infection in urine.</p>
                        <p><strong>Urine Albumin-to-Creatinine Ratio (ACR):</strong> Detects early kidney damage (microalbuminuria).</p>
                        <p><strong>Kidney Ultrasound:</strong> Imaging to check kidney size, structure, blockages.</p>
                        <p><strong>Kidney Biopsy:</strong> Sample of kidney tissue to diagnose specific diseases.</p>
                        <p><strong>Cystatin C:</strong> Alternative to creatinine. Not affected by muscle mass.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>When to See a Nephrologist</h3>
                    <div style="padding: 15px; background: #ffebee; border-radius: 5px; line-height: 1.8; border-left: 4px solid #f44336;">
                        <p><strong>⚠️ See Kidney Specialist (Nephrologist) If:</strong></p>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>eGFR &lt;60 (Stage 3 or worse)</li>
                            <li>eGFR declining rapidly (&gt;5 mL/min/year)</li>
                            <li>Protein in urine (proteinuria or albuminuria)</li>
                            <li>Blood in urine (hematuria) without infection</li>
                            <li>High blood pressure difficult to control</li>
                            <li>Diabetes with kidney involvement</li>
                            <li>Swelling that won't go away</li>
                            <li>Severe fatigue or other symptoms</li>
                            <li>Family history of kidney disease (especially polycystic kidney disease)</li>
                            <li>Kidney stones (recurrent)</li>
                        </ul>
                        <p><strong>Emergency (Go to ER):</strong> Sudden decrease in urination, severe swelling, confusion, chest pain, severe nausea/vomiting</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>GFR Tips:</strong> GFR = best kidney function test. Normal = 90-120 mL/min. eGFR calculated from creatinine + age + gender. CKD-EPI = most accurate formula. Stage 1-2 = normal/mild. Stage 3+ = see nephrologist. Stage 5 = dialysis needed. GFR declines ~1/year after age 40. Diabetes & hypertension = top causes. No symptoms until stage 3-4. Control blood sugar & BP = #1 prevention. Avoid NSAIDs. Stay hydrated. Low sodium diet. Check annually if diabetic/hypertensive. Creatinine 0.6-1.2 normal (men), 0.5-1.1 (women). High creatinine = low GFR. Protein in urine = early warning. Dialysis when GFR &lt;15!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('gfrForm');
        const unitSelect = document.getElementById('unitSystem');
        const formulaSelect = document.getElementById('formula');

        unitSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateGFR();
        });

        formulaSelect.addEventListener('change', function() {
            toggleWeightField();
            calculateGFR();
        });

        function toggleUnitFields() {
            const unit = unitSelect.value;
            document.getElementById('creatinineStandardGroup').style.display = unit === 'standard' ? 'block' : 'none';
            document.getElementById('creatinineSIGroup').style.display = unit === 'si' ? 'block' : 'none';
        }

        function toggleWeightField() {
            const formula = formulaSelect.value;
            document.getElementById('weightGroup').style.display = formula === 'cockcroft' ? 'block' : 'none';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateGFR();
        });

        function calculateGFR() {
            const age = parseInt(document.getElementById('age').value) || 45;
            const gender = document.getElementById('gender').value;
            const race = document.getElementById('race').value;
            const formula = formulaSelect.value;
            const unit = unitSelect.value;
            const weightKg = parseFloat(document.getElementById('weightKg').value) || 75;
            
            // Get creatinine in mg/dL
            let creatinine;
            if (unit === 'standard') {
                creatinine = parseFloat(document.getElementById('creatinineStandard').value) || 1.2;
            } else {
                const creatinineSI = parseFloat(document.getElementById('creatinineSI').value) || 106;
                creatinine = creatinineSI / 88.4; // Convert μmol/L to mg/dL
            }

            // Calculate eGFR using different formulas
            let gfr = 0;
            let ckdEpiGFR = 0;
            let mdrdGFR = 0;
            let cockcroftGFR = 0;

            // CKD-EPI Formula (2021)
            const kappa = gender === 'female' ? 0.7 : 0.9;
            const alpha = gender === 'female' ? -0.241 : -0.302;
            const genderFactor = gender === 'female' ? 1.012 : 1;
            const raceFactor = race === 'black' ? 1.159 : 1;
            
            const creatinineRatio = creatinine / kappa;
            const minValue = Math.min(creatinineRatio, 1);
            const maxValue = Math.max(creatinineRatio, 1);
            
            ckdEpiGFR = 142 * Math.pow(minValue, alpha) * Math.pow(maxValue, -1.200) * Math.pow(0.9938, age) * genderFactor * raceFactor;

            // MDRD Formula
            const mdrdGenderFactor = gender === 'female' ? 0.742 : 1;
            const mdrdRaceFactor = race === 'black' ? 1.212 : 1;
            mdrdGFR = 175 * Math.pow(creatinine, -1.154) * Math.pow(age, -0.203) * mdrdGenderFactor * mdrdRaceFactor;

            // Cockcroft-Gault Formula
            const cockcroftGenderFactor = gender === 'female' ? 0.85 : 1;
            cockcroftGFR = ((140 - age) * weightKg * cockcroftGenderFactor) / (72 * creatinine);

            // Use selected formula
            if (formula === 'ckd-epi') {
                gfr = ckdEpiGFR;
            } else if (formula === 'mdrd') {
                gfr = mdrdGFR;
            } else {
                gfr = cockcroftGFR;
            }

            // Determine CKD stage and status
            let stage = 0;
            let stageName = '';
            let stageColor = '';
            let cardClass = '';
            let statusName = '';
            let interpretation = '';
            
            if (gfr >= 90) {
                stage = 1;
                stageName = 'Stage 1 - Normal or High';
                statusName = 'Normal';
                stageColor = '#4CAF50';
                cardClass = 'success';
                interpretation = 'Normal kidney function';
            } else if (gfr >= 60) {
                stage = 2;
                stageName = 'Stage 2 - Mild Decrease';
                statusName = 'Mild';
                stageColor = '#8BC34A';
                cardClass = 'success';
                interpretation = 'Mildly decreased kidney function';
            } else if (gfr >= 45) {
                stage = '3a';
                stageName = 'Stage 3a - Mild-Moderate Decrease';
                statusName = 'Moderate';
                stageColor = '#FF9800';
                cardClass = 'warning';
                interpretation = 'Mild to moderately decreased kidney function';
            } else if (gfr >= 30) {
                stage = '3b';
                stageName = 'Stage 3b - Moderate-Severe Decrease';
                statusName = 'Moderate';
                stageColor = '#FF9800';
                cardClass = 'warning';
                interpretation = 'Moderately to severely decreased kidney function';
            } else if (gfr >= 15) {
                stage = 4;
                stageName = 'Stage 4 - Severe Decrease';
                statusName = 'Severe';
                stageColor = '#f44336';
                cardClass = 'warning';
                interpretation = 'Severely decreased kidney function';
            } else {
                stage = 5;
                stageName = 'Stage 5 - Kidney Failure';
                statusName = 'Failure';
                stageColor = '#d32f2f';
                cardClass = 'warning';
                interpretation = 'Kidney failure (dialysis or transplant needed)';
            }

            // Formula names
            const formulaNames = {
                'ckd-epi': 'CKD-EPI',
                'mdrd': 'MDRD',
                'cockcroft': 'Cockcroft-Gault'
            };

            // Display creatinine
            const displayCreatinine = unit === 'standard' ? 
                `${creatinine.toFixed(2)} mg/dL` : 
                `${(creatinine * 88.4).toFixed(0)} μmol/L`;

            // Analysis
            let analysis = `Your estimated GFR (eGFR) is ${gfr.toFixed(1)} mL/min/1.73m² using the ${formulaNames[formula]} formula. `;
            analysis += `This indicates ${interpretation.toLowerCase()}. `;
            analysis += `You are classified as CKD ${stageName}. `;
            
            if (stage === 1 || stage === 2) {
                analysis += `This is good news! Your kidney function is ${stage === 1 ? 'normal' : 'near normal'}. `;
                analysis += `If you have diabetes or high blood pressure, continue to control these conditions to protect your kidneys. `;
                analysis += `Have your kidney function checked annually. `;
            } else if (stage === '3a' || stage === '3b') {
                analysis += `You have chronic kidney disease (CKD) and should see a nephrologist (kidney specialist). `;
                analysis += `Focus on controlling blood pressure (&lt;130/80) and blood sugar if diabetic. `;
                analysis += `Avoid NSAIDs like ibuprofen. Follow a kidney-friendly diet low in sodium. `;
                analysis += `Monitor your kidney function every 3-6 months. `;
            } else if (stage === 4) {
                analysis += `⚠️ You have severe kidney disease and need regular care from a nephrologist. `;
                analysis += `Begin preparing for dialysis or kidney transplant. `;
                analysis += `Follow strict dietary restrictions and medication adjustments. `;
                analysis += `Check kidney function monthly. `;
            } else {
                analysis += `⚠️ URGENT: You have kidney failure (ESRD) and need dialysis or a kidney transplant to survive. `;
                analysis += `If not already under kidney specialist care, seek immediate medical attention. `;
                analysis += `You need frequent monitoring and specialized treatment. `;
            }
            
            analysis += `Your serum creatinine is ${displayCreatinine}. `;
            analysis += `Remember that GFR naturally declines with age (about 1 mL/min per year after age 40). `;
            analysis += `This calculator provides an estimate - always consult your healthcare provider for medical interpretation and treatment decisions.`;

            // Update UI
            const card = document.getElementById('resultCard');
            card.className = 'result-card ' + cardClass;
            
            document.getElementById('gfrResult').textContent = `${gfr.toFixed(1)} mL/min/1.73m²`;
            document.getElementById('stageDisplay').textContent = stageName;
            document.getElementById('gfrDisplay').textContent = gfr.toFixed(0);
            document.getElementById('stageNum').textContent = stage;
            document.getElementById('functionPercent').textContent = `${Math.round((gfr / 120) * 100)}%`;
            document.getElementById('statusDisplay').textContent = statusName;

            document.getElementById('ageDisplay').textContent = `${age} years`;
            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('raceDisplay').textContent = race === 'black' ? 'Black/African American' : 'Other';
            document.getElementById('creatinineDisplay').textContent = displayCreatinine;
            document.getElementById('formulaDisplay').textContent = formulaNames[formula];

            document.getElementById('gfrValue').textContent = `${gfr.toFixed(1)} mL/min/1.73m²`;
            document.getElementById('gfrValue').style.color = stageColor;
            document.getElementById('ckdStage').textContent = stageName;
            document.getElementById('ckdStage').style.color = stageColor;
            document.getElementById('kidneyFunction').textContent = interpretation;
            document.getElementById('interpretation').textContent = interpretation;

            document.getElementById('ckdEpiResult').textContent = `${ckdEpiGFR.toFixed(1)} mL/min/1.73m²`;
            document.getElementById('mdrdResult').textContent = `${mdrdGFR.toFixed(1)} mL/min/1.73m²`;
            document.getElementById('cockcroftResult').textContent = `${cockcroftGFR.toFixed(1)} mL/min`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            toggleWeightField();
            calculateGFR();
        });
    </script>
</body>
</html>