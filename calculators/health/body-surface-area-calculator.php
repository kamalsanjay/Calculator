<?php
/**
 * Body Surface Area Calculator
 * File: body-surface-area-calculator.php
 * Description: Calculate BSA using multiple formulas (Imperial/Metric)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Body Surface Area Calculator - BSA Using Multiple Formulas (Imperial/Metric)</title>
    <meta name="description" content="Free BSA calculator. Calculate body surface area using Mosteller, Du Bois, Haycock, and Gehan-George formulas. Used for medical dosing. Imperial and metric units.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#129656; Body Surface Area Calculator</h1>
        <p>Calculate BSA (m²) for medical dosing</p>
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
                <form id="bsaForm">
                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="imperial">Imperial (lbs/inches)</option>
                            <option value="metric">Metric (kg/cm)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Measurements</h3>
                    
                    <div class="form-group" id="heightImperialGroup">
                        <label for="heightFeet">Height</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="heightFeet" value="5" min="2" max="8" step="1" style="flex: 1;" placeholder="Feet">
                            <input type="number" id="heightInches" value="10" min="0" max="11" step="0.5" style="flex: 1;" placeholder="Inches">
                        </div>
                    </div>

                    <div class="form-group" id="heightMetricGroup" style="display: none;">
                        <label for="heightCm">Height (cm)</label>
                        <input type="number" id="heightCm" value="178" min="50" max="250" step="0.1">
                    </div>
                    
                    <div class="form-group" id="weightImperialGroup">
                        <label for="weightLbs">Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="180" min="10" max="500" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="82" min="5" max="250" step="0.1">
                    </div>
                    
                    <div class="form-group">
                        <label for="formula">Preferred Formula</label>
                        <select id="formula">
                            <option value="mosteller">Mosteller (Recommended)</option>
                            <option value="dubois">Du Bois & Du Bois</option>
                            <option value="haycock">Haycock</option>
                            <option value="gehan">Gehan & George</option>
                            <option value="all">All Formulas</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate BSA</button>
                </form>
            </div>

            <div class="results-section">
                <h2>BSA Results</h2>
                
                <div class="result-card success">
                    <h3>Body Surface Area</h3>
                    <div class="amount" id="bsaResult">1.98 m²</div>
                    <div style="margin-top: 10px; font-size: 1em;">Mosteller Formula</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>BSA (m²)</h4>
                        <div class="value" id="bsaDisplay">1.98</div>
                    </div>
                    <div class="metric-card">
                        <h4>Height</h4>
                        <div class="value" id="heightDisplay">5'10"</div>
                    </div>
                    <div class="metric-card">
                        <h4>Weight</h4>
                        <div class="value" id="weightDisplay">180 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>Category</h4>
                        <div class="value" id="categoryDisplay">Average</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Measurements</h3>
                    <div class="breakdown-item">
                        <span>Height</span>
                        <strong id="heightCalc">5'10"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight</span>
                        <strong id="weightCalc">180 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Height (cm)</span>
                        <strong id="heightCmCalc">178 cm</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight (kg)</span>
                        <strong id="weightKgCalc">82 kg</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>BSA Calculations (Different Formulas)</h3>
                    <div class="breakdown-item">
                        <span>Mosteller (Recommended)</span>
                        <strong id="mostellerBSA" style="color: #667eea; font-size: 1.1em;">1.98 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Du Bois & Du Bois (Classic)</span>
                        <strong id="duboisBSA">1.98 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Haycock</span>
                        <strong id="haycockBSA">1.98 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gehan & George</span>
                        <strong id="gehanBSA">1.98 m²</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Average BSA</strong></span>
                        <strong id="averageBSA" style="color: #667eea; font-size: 1.1em;">1.98 m²</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>BSA Categories</h3>
                    <div class="breakdown-item">
                        <span>Small Adult</span>
                        <strong>&lt; 1.6 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Adult</span>
                        <strong style="color: #4CAF50;">1.6 - 2.0 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Large Adult</span>
                        <strong>&gt; 2.0 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Man</span>
                        <strong>~1.9 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Woman</span>
                        <strong>~1.6 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Newborn</span>
                        <strong>~0.25 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Child (10 years)</span>
                        <strong>~1.14 m²</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Medical Applications</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Chemotherapy Dosing:</strong> Most chemo drugs dosed based on BSA (mg/m²) to normalize for body size.</p>
                        <p><strong>Cardiac Index:</strong> Cardiac output normalized by BSA. Normal: 2.5-4.0 L/min/m².</p>
                        <p><strong>Renal Function:</strong> GFR (kidney function) often normalized to BSA.</p>
                        <p><strong>Metabolic Rate:</strong> Basal metabolic rate correlates closely with BSA.</p>
                        <p><strong>Burn Assessment:</strong> Burn severity calculated as % BSA affected.</p>
                        <p><strong>Drug Dosing:</strong> Many medications dosed per BSA, especially in pediatrics and oncology.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Formula Comparison</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Mosteller (1987):</strong> Simplest and most widely used. Easy to calculate. Recommended by FDA. Formula: √(height(cm) × weight(kg) / 3600)</p>
                        <p><strong>Du Bois & Du Bois (1916):</strong> Original BSA formula. Complex but accurate. Widely validated. Formula: 0.007184 × height(cm)^0.725 × weight(kg)^0.425</p>
                        <p><strong>Haycock (1978):</strong> Accurate for children and small adults. Formula: 0.024265 × height(cm)^0.3964 × weight(kg)^0.5378</p>
                        <p><strong>Gehan & George (1970):</strong> Good for wide range of sizes. Formula: 0.0235 × height(cm)^0.42246 × weight(kg)^0.51456</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Why BSA Matters</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Normalizes for Body Size:</strong> BSA adjusts drug doses and physiological parameters for different body sizes.</p>
                        <p><strong>More Accurate Than Weight:</strong> Two people with same weight but different heights have different BSA.</p>
                        <p><strong>Correlates with Metabolism:</strong> Metabolic rate proportional to body surface area, not weight.</p>
                        <p><strong>Heat Loss:</strong> Heat dissipation through skin surface correlates with BSA.</p>
                        <p><strong>Fluid Requirements:</strong> Daily fluid needs often calculated based on BSA in critically ill patients.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Medical Dosing Examples</h3>
                    <div class="breakdown-item">
                        <span>Chemotherapy</span>
                        <strong id="chemoExample">Dose = 100 mg/m² = 198 mg</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cardiac Index (Normal)</span>
                        <strong id="cardiacExample">2.5-4.0 L/min/m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Daily Fluid Requirements</span>
                        <strong id="fluidExample">~1500 mL/m² = 2970 mL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Basal Metabolic Rate</span>
                        <strong id="bmrExample">~1000 kcal/m² = 1980 kcal</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>BSA by Age (Average)</h3>
                    <div class="breakdown-item">
                        <span>Newborn</span>
                        <strong>0.25 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>2 years</span>
                        <strong>0.5 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>5 years</span>
                        <strong>0.8 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>10 years</span>
                        <strong>1.14 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Adult Female</span>
                        <strong>1.6 m²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Adult Male</span>
                        <strong>1.9 m²</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Rule of 9s (Burns)</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Head & Neck:</strong> 9% of BSA</p>
                        <p><strong>Each Arm:</strong> 9% of BSA (total arms = 18%)</p>
                        <p><strong>Front Torso:</strong> 18% of BSA</p>
                        <p><strong>Back Torso:</strong> 18% of BSA</p>
                        <p><strong>Each Leg:</strong> 18% of BSA (total legs = 36%)</p>
                        <p><strong>Groin:</strong> 1% of BSA</p>
                        <p><strong>Total:</strong> 100% of BSA</p>
                        <p><em>Used to assess burn severity and fluid resuscitation needs.</em></p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Important Notes</h3>
                    <div style="padding: 15px; background: #fff3cd; border-radius: 5px; line-height: 1.8; border-left: 4px solid #FF9800;">
                        <p><strong>⚠️ Medical Use Only:</strong></p>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>BSA calculations used for medical dosing must be done by healthcare professionals</li>
                            <li>Small errors in BSA can lead to significant dosing errors</li>
                            <li>Always verify calculations, especially for chemotherapy</li>
                            <li>Children and obese patients may need adjusted formulas</li>
                            <li>This calculator is for educational purposes - not medical advice</li>
                            <li>Consult physician/pharmacist for actual medication dosing</li>
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
                    <strong>BSA Tips:</strong> BSA = Body Surface Area in square meters (m²). Used for medical dosing. Mosteller formula = most common. Du Bois = original (1916). Average adult = 1.6-2.0 m². Men ~1.9 m², women ~1.6 m². Newborn ~0.25 m². Chemotherapy dosed by BSA. Cardiac index = CO/BSA. GFR normalized to BSA. Burns assessed as % BSA. Metabolic rate proportional to BSA. More accurate than weight alone. Height + weight both matter. Measure accurately. Used in ICU, oncology, pediatrics. FDA recommends Mosteller. BSA ≠ body fat. Medical calculations only by professionals!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('bsaForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateBSA();
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
            calculateBSA();
        });

        function calculateBSA() {
            const unitSystem = unitSystemSelect.value;
            const formulaType = document.getElementById('formula').value;
            
            // Get measurements in metric
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

            // Calculate BSA using different formulas
            
            // Mosteller (1987) - Most widely used
            const mostellerBSA = Math.sqrt((heightCm * weightKg) / 3600);
            
            // Du Bois & Du Bois (1916) - Original formula
            const duboisBSA = 0.007184 * Math.pow(heightCm, 0.725) * Math.pow(weightKg, 0.425);
            
            // Haycock (1978)
            const haycockBSA = 0.024265 * Math.pow(heightCm, 0.3964) * Math.pow(weightKg, 0.5378);
            
            // Gehan & George (1970)
            const gehanBSA = 0.0235 * Math.pow(heightCm, 0.42246) * Math.pow(weightKg, 0.51456);

            // Average of all formulas
            const averageBSA = (mostellerBSA + duboisBSA + haycockBSA + gehanBSA) / 4;

            // Determine which BSA to display
            let displayBSA;
            let formulaName;
            
            if (formulaType === 'mosteller') {
                displayBSA = mostellerBSA;
                formulaName = 'Mosteller';
            } else if (formulaType === 'dubois') {
                displayBSA = duboisBSA;
                formulaName = 'Du Bois';
            } else if (formulaType === 'haycock') {
                displayBSA = haycockBSA;
                formulaName = 'Haycock';
            } else if (formulaType === 'gehan') {
                displayBSA = gehanBSA;
                formulaName = 'Gehan & George';
            } else {
                displayBSA = averageBSA;
                formulaName = 'Average of All';
            }

            // Determine category
            let category = '';
            let categoryColor = '';
            
            if (displayBSA < 1.6) {
                category = 'Small Adult';
                categoryColor = '#FF9800';
            } else if (displayBSA <= 2.0) {
                category = 'Average Adult';
                categoryColor = '#4CAF50';
            } else {
                category = 'Large Adult';
                categoryColor = '#2196F3';
            }

            // Medical examples
            const chemoExample = `Dose = 100 mg/m² = ${(displayBSA * 100).toFixed(0)} mg`;
            const fluidExample = `~1500 mL/m² = ${(displayBSA * 1500).toFixed(0)} mL`;
            const bmrExample = `~1000 kcal/m² = ${(displayBSA * 1000).toFixed(0)} kcal`;

            // Display measurements
            const heightInches = heightCm / 2.54;
            const weightLbs = weightKg * 2.20462;
            const displayHeight = unitSystem === 'imperial' ? 
                `${Math.floor(heightInches / 12)}'${(heightInches % 12).toFixed(0)}"` : 
                `${heightCm.toFixed(1)} cm`;
            const displayWeight = unitSystem === 'imperial' ? 
                `${weightLbs.toFixed(1)} lbs` : 
                `${weightKg.toFixed(1)} kg`;

            // Analysis
            let analysis = `Your Body Surface Area (BSA) is ${displayBSA.toFixed(2)} m² using the ${formulaName} formula. `;
            analysis += `With a height of ${displayHeight} and weight of ${displayWeight}, this falls in the "${category}" category. `;
            
            if (formulaType === 'all') {
                const diff = Math.max(mostellerBSA, duboisBSA, haycockBSA, gehanBSA) - Math.min(mostellerBSA, duboisBSA, haycockBSA, gehanBSA);
                analysis += `The different formulas show a variation of ${diff.toFixed(3)} m² (${(diff / displayBSA * 100).toFixed(1)}%). `;
            }
            
            analysis += `BSA is used in medical settings to calculate drug dosages (especially chemotherapy), cardiac index, glomerular filtration rate, and burn assessment. `;
            analysis += `For example, if a medication is dosed at 100 mg/m², your dose would be ${(displayBSA * 100).toFixed(0)} mg. `;
            analysis += `The Mosteller formula is most commonly used due to its simplicity and FDA recommendation.`;

            // Update UI
            document.getElementById('bsaResult').textContent = displayBSA.toFixed(2) + ' m²';
            document.getElementById('bsaDisplay').textContent = displayBSA.toFixed(2);
            document.getElementById('heightDisplay').textContent = displayHeight;
            document.getElementById('weightDisplay').textContent = displayWeight;
            document.getElementById('categoryDisplay').textContent = category;
            document.getElementById('categoryDisplay').style.color = categoryColor;

            document.getElementById('heightCalc').textContent = displayHeight;
            document.getElementById('weightCalc').textContent = displayWeight;
            document.getElementById('heightCmCalc').textContent = `${heightCm.toFixed(1)} cm`;
            document.getElementById('weightKgCalc').textContent = `${weightKg.toFixed(1)} kg`;

            document.getElementById('mostellerBSA').textContent = `${mostellerBSA.toFixed(2)} m²`;
            document.getElementById('duboisBSA').textContent = `${duboisBSA.toFixed(2)} m²`;
            document.getElementById('haycockBSA').textContent = `${haycockBSA.toFixed(2)} m²`;
            document.getElementById('gehanBSA').textContent = `${gehanBSA.toFixed(2)} m²`;
            document.getElementById('averageBSA').textContent = `${averageBSA.toFixed(2)} m²`;

            document.getElementById('chemoExample').textContent = chemoExample;
            document.getElementById('fluidExample').textContent = fluidExample;
            document.getElementById('bmrExample').textContent = bmrExample;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateBSA();
        });
    </script>
</body>
</html>