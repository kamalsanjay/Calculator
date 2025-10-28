<?php
/**
 * Dosage Calculator
 * File: dosage-calculator.php
 * Description: Calculate medication dosages for adults and children (weight-based, BSA-based)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosage Calculator - Medical Medication Dose Calculator (Weight & BSA Based)</title>
    <meta name="description" content="Free medical dosage calculator. Calculate medication doses by weight (mg/kg), body surface area (BSA), or concentration. For healthcare professionals.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>💊 Dosage Calculator</h1>
        <p>Calculate medication dosages</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Dosage Information</h2>
                <form id="dosageForm">
                    <div class="form-group">
                        <label for="calculationType">Calculation Type</label>
                        <select id="calculationType">
                            <option value="weight">Weight-Based Dosing (mg/kg)</option>
                            <option value="bsa">BSA-Based Dosing (mg/m²)</option>
                            <option value="concentration">Liquid Medication (Volume from Concentration)</option>
                            <option value="iv">IV Drip Rate</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="metric">Metric (kg/cm)</option>
                            <option value="imperial">Imperial (lbs/inches)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Patient Information</h3>
                    
                    <div class="form-group">
                        <label for="patientType">Patient Type</label>
                        <select id="patientType">
                            <option value="adult">Adult</option>
                            <option value="child">Child/Pediatric</option>
                            <option value="infant">Infant</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="weightMetricGroup">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="70" min="0.5" max="300" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightImperialGroup" style="display: none;">
                        <label for="weightLbs">Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="154" min="1" max="660" step="0.1">
                    </div>
                    
                    <div class="form-group" id="heightGroup">
                        <label for="heightCm">Height (cm)</label>
                        <input type="number" id="heightCm" value="170" min="40" max="250" step="0.1">
                        <small>Required for BSA-based dosing</small>
                    </div>

                    <div class="form-group" id="heightImperialGroup" style="display: none;">
                        <label for="heightFeet">Height</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="heightFeet" value="5" min="1" max="8" step="1" style="flex: 1;" placeholder="Feet">
                            <input type="number" id="heightInches" value="7" min="0" max="11" step="1" style="flex: 1;" placeholder="Inches">
                        </div>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Medication Details</h3>
                    
                    <div class="form-group" id="dosePerWeightGroup">
                        <label for="dosePerWeight">Prescribed Dose (mg/kg)</label>
                        <input type="number" id="dosePerWeight" value="10" min="0.001" max="1000" step="0.001">
                        <small>Dose per kilogram of body weight</small>
                    </div>
                    
                    <div class="form-group" id="dosePerBSAGroup" style="display: none;">
                        <label for="dosePerBSA">Prescribed Dose (mg/m²)</label>
                        <input type="number" id="dosePerBSA" value="100" min="0.1" max="10000" step="0.1">
                        <small>Dose per square meter of body surface area</small>
                    </div>
                    
                    <div class="form-group" id="totalDoseGroup" style="display: none;">
                        <label for="totalDose">Total Dose Needed (mg)</label>
                        <input type="number" id="totalDose" value="500" min="0.1" max="10000" step="0.1">
                    </div>
                    
                    <div class="form-group" id="concentrationGroup" style="display: none;">
                        <label for="concentration">Medication Concentration (mg/mL)</label>
                        <input type="number" id="concentration" value="250" min="0.1" max="10000" step="0.1">
                        <small>Strength of liquid medication</small>
                    </div>
                    
                    <div class="form-group" id="ivVolumeGroup" style="display: none;">
                        <label for="ivVolume">Total IV Volume (mL)</label>
                        <input type="number" id="ivVolume" value="1000" min="1" max="10000" step="1">
                    </div>
                    
                    <div class="form-group" id="ivTimeGroup" style="display: none;">
                        <label for="ivTime">Infusion Time (hours)</label>
                        <input type="number" id="ivTime" value="8" min="0.1" max="24" step="0.1">
                    </div>
                    
                    <div class="form-group">
                        <label for="frequency">Dosing Frequency</label>
                        <select id="frequency">
                            <option value="1">Once daily (QD)</option>
                            <option value="2">Twice daily (BID)</option>
                            <option value="3">Three times daily (TID)</option>
                            <option value="4">Four times daily (QID)</option>
                            <option value="6">Every 4 hours (Q4H)</option>
                            <option value="8">Every 3 hours (Q3H)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Dosage</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Dosage Results</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Single Dose</h3>
                    <div class="amount" id="dosageResult">700 mg</div>
                    <div style="margin-top: 10px; font-size: 1em;">per dose</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Single Dose</h4>
                        <div class="value" id="singleDoseDisplay">700 mg</div>
                    </div>
                    <div class="metric-card">
                        <h4>Daily Total</h4>
                        <div class="value" id="dailyDoseDisplay">700 mg</div>
                    </div>
                    <div class="metric-card">
                        <h4>Frequency</h4>
                        <div class="value" id="frequencyDisplay">Once</div>
                    </div>
                    <div class="metric-card">
                        <h4>Volume</h4>
                        <div class="value" id="volumeDisplay">N/A</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Patient Information</h3>
                    <div class="breakdown-item">
                        <span>Patient Type</span>
                        <strong id="patientDisplay">Adult</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight</span>
                        <strong id="weightDisplay">70 kg</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Height</span>
                        <strong id="heightDisplay">170 cm</strong>
                    </div>
                    <div class="breakdown-item" id="bsaDisplayItem">
                        <span>Body Surface Area (BSA)</span>
                        <strong id="bsaDisplay">1.80 m²</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Dosage Calculation</h3>
                    <div class="breakdown-item">
                        <span>Prescribed Dose</span>
                        <strong id="prescribedDose" style="color: #667eea;">10 mg/kg</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Single Dose Amount</span>
                        <strong id="singleDoseCalc" style="color: #667eea; font-size: 1.1em;">700 mg</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Dosing Frequency</span>
                        <strong id="frequencyCalc">Once daily (QD)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Daily Dose</span>
                        <strong id="dailyDoseCalc" style="color: #4CAF50;">700 mg/day</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;" id="liquidDoseSection" style="display: none;">
                    <h3>Liquid Medication Volume</h3>
                    <div class="breakdown-item">
                        <span>Dose Needed</span>
                        <strong id="liquidDose">500 mg</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Concentration</span>
                        <strong id="liquidConc">250 mg/mL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Volume to Administer</span>
                        <strong id="liquidVolume" style="color: #667eea; font-size: 1.1em;">2.0 mL</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;" id="ivDripSection" style="display: none;">
                    <h3>IV Drip Rate</h3>
                    <div class="breakdown-item">
                        <span>Total Volume</span>
                        <strong id="ivVolumeDisplay">1000 mL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Infusion Time</span>
                        <strong id="ivTimeDisplay">8 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Flow Rate</span>
                        <strong id="ivFlowRate" style="color: #667eea; font-size: 1.1em;">125 mL/hr</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Drops per Minute (15 gtt/mL)</span>
                        <strong id="ivDropRate">31 gtt/min</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Weekly & Monthly Totals</h3>
                    <div class="breakdown-item">
                        <span>Weekly Total</span>
                        <strong id="weeklyTotal">4,900 mg/week</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Total (30 days)</span>
                        <strong id="monthlyTotal">21,000 mg/month</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Pediatric Weight-Based Dosing Examples</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Acetaminophen (Tylenol):</strong> 10-15 mg/kg every 4-6 hours (max 75 mg/kg/day)</p>
                        <p><strong>Ibuprofen (Advil/Motrin):</strong> 5-10 mg/kg every 6-8 hours (max 40 mg/kg/day)</p>
                        <p><strong>Amoxicillin:</strong> 20-40 mg/kg/day divided into 3 doses</p>
                        <p><strong>Azithromycin (Z-pack):</strong> 10 mg/kg once daily (max 500 mg)</p>
                        <p><strong>Ondansetron (Zofran):</strong> 0.15 mg/kg every 8 hours</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Common Adult Medications</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Acetaminophen:</strong> 325-650 mg every 4-6 hours (max 3000 mg/day)</p>
                        <p><strong>Ibuprofen:</strong> 200-400 mg every 4-6 hours (max 3200 mg/day)</p>
                        <p><strong>Aspirin:</strong> 325-650 mg every 4 hours (max 4000 mg/day)</p>
                        <p><strong>Diphenhydramine (Benadryl):</strong> 25-50 mg every 4-6 hours</p>
                        <p><strong>Amoxicillin:</strong> 250-500 mg every 8 hours or 500-875 mg twice daily</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>BSA-Based Dosing (Chemotherapy)</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Body Surface Area (BSA):</strong> Used primarily for chemotherapy and some antibiotics</p>
                        <p><strong>Mosteller Formula:</strong> BSA (m²) = √[(height(cm) × weight(kg)) / 3600]</p>
                        <p><strong>Average Adult BSA:</strong> 1.6-2.0 m² (men ~1.9, women ~1.6)</p>
                        <p><strong>Why BSA?</strong> Normalizes dosing across different body sizes, especially for toxic drugs</p>
                        <p><strong>Examples:</strong> Most chemotherapy agents dosed as mg/m² BSA</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Medical Abbreviations</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>QD:</strong> Once daily (quaque die)</p>
                        <p><strong>BID:</strong> Twice daily (bis in die)</p>
                        <p><strong>TID:</strong> Three times daily (ter in die)</p>
                        <p><strong>QID:</strong> Four times daily (quater in die)</p>
                        <p><strong>Q4H:</strong> Every 4 hours</p>
                        <p><strong>Q6H:</strong> Every 6 hours</p>
                        <p><strong>PRN:</strong> As needed (pro re nata)</p>
                        <p><strong>PO:</strong> By mouth (per os)</p>
                        <p><strong>IV:</strong> Intravenous</p>
                        <p><strong>IM:</strong> Intramuscular</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Dosage Forms & Conversions</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Weight:</strong> 1 kg = 2.2 lbs, 1 lb = 0.45 kg</p>
                        <p><strong>Volume:</strong> 1 mL = 1 cc, 1 tsp = 5 mL, 1 tbsp = 15 mL</p>
                        <p><strong>Mass:</strong> 1 g = 1000 mg, 1 mg = 1000 mcg (μg)</p>
                        <p><strong>IV Drop Factor:</strong> Standard = 15 gtt/mL, Micro = 60 gtt/mL</p>
                        <p><strong>Tablet:</strong> Solid oral dose form</p>
                        <p><strong>Capsule:</strong> Powder/liquid enclosed in gelatin shell</p>
                        <p><strong>Suspension:</strong> Solid particles in liquid (shake well)</p>
                        <p><strong>Solution:</strong> Drug dissolved in liquid (clear)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Pediatric Dosing Considerations</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>• <strong>Always Weight-Based:</strong> Children are not small adults - must use kg-based dosing</p>
                        <p>• <strong>Maximum Doses:</strong> Pediatric dose never exceeds adult dose</p>
                        <p>• <strong>Age Considerations:</strong> Newborns and infants have different metabolism</p>
                        <p>• <strong>Liquid Preferred:</strong> Easier to adjust doses and administer</p>
                        <p>• <strong>Recheck Weight:</strong> Kids grow fast - update weight frequently</p>
                        <p>• <strong>Avoid Aspirin:</strong> Risk of Reye's syndrome in children &lt;18 with viral illness</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Safety Warnings</h3>
                    <div style="padding: 15px; background: #ffebee; border-radius: 5px; line-height: 1.8; border-left: 4px solid #f44336;">
                        <p><strong>⚠️ IMPORTANT SAFETY INFORMATION:</strong></p>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>This calculator is for educational purposes only</li>
                            <li>NOT a substitute for professional medical advice</li>
                            <li>Always verify calculations independently</li>
                            <li>Follow your healthcare provider's prescription exactly</li>
                            <li>Double-check all calculations before administering medication</li>
                            <li>Dosing errors can cause serious harm or death</li>
                            <li>For healthcare professionals: Use clinical judgment</li>
                            <li>Adjust for renal/hepatic impairment as indicated</li>
                            <li>Consider drug interactions and contraindications</li>
                            <li>When in doubt, consult pharmacist or physician</li>
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
                    <strong>Dosage Tips:</strong> Weight-based = mg/kg. BSA-based = mg/m². Always double-check calculations. 1 kg = 2.2 lbs. 1 tsp = 5 mL. QD = once daily. BID = twice daily. TID = 3x daily. QID = 4x daily. Pediatric doses always by weight. Max dose never exceeds adult dose. Liquid meds for kids. BSA used for chemo. Mosteller formula most common. Renal/hepatic adjustment may be needed. Always verify independently. NOT medical advice. For healthcare professionals. Medication errors can be fatal. When in doubt, ask pharmacist!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('dosageForm');
        const typeSelect = document.getElementById('calculationType');
        const unitSelect = document.getElementById('unitSystem');

        typeSelect.addEventListener('change', function() {
            toggleCalculationFields();
            calculate();
        });

        unitSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculate();
        });

        function toggleCalculationFields() {
            const type = typeSelect.value;
            
            document.getElementById('dosePerWeightGroup').style.display = type === 'weight' ? 'block' : 'none';
            document.getElementById('dosePerBSAGroup').style.display = type === 'bsa' ? 'block' : 'none';
            document.getElementById('totalDoseGroup').style.display = type === 'concentration' ? 'block' : 'none';
            document.getElementById('concentrationGroup').style.display = type === 'concentration' ? 'block' : 'none';
            document.getElementById('ivVolumeGroup').style.display = type === 'iv' ? 'block' : 'none';
            document.getElementById('ivTimeGroup').style.display = type === 'iv' ? 'block' : 'none';
            document.getElementById('heightGroup').style.display = type === 'bsa' ? 'block' : 'none';
            document.getElementById('heightImperialGroup').style.display = type === 'bsa' && unitSelect.value === 'imperial' ? 'block' : 'none';
        }

        function toggleUnitFields() {
            const unit = unitSelect.value;
            const isMetric = unit === 'metric';
            
            document.getElementById('weightMetricGroup').style.display = isMetric ? 'block' : 'none';
            document.getElementById('weightImperialGroup').style.display = isMetric ? 'none' : 'block';
            
            if (typeSelect.value === 'bsa') {
                document.getElementById('heightGroup').style.display = isMetric ? 'block' : 'none';
                document.getElementById('heightImperialGroup').style.display = isMetric ? 'none' : 'block';
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculate();
        });

        function calculate() {
            const type = typeSelect.value;
            const unit = unitSelect.value;
            const patientType = document.getElementById('patientType').value;
            const frequency = parseInt(document.getElementById('frequency').value) || 1;
            
            // Get weight in kg
            let weightKg;
            if (unit === 'metric') {
                weightKg = parseFloat(document.getElementById('weightKg').value) || 70;
            } else {
                const weightLbs = parseFloat(document.getElementById('weightLbs').value) || 154;
                weightKg = weightLbs / 2.20462;
            }

            // Get height in cm for BSA calculation
            let heightCm;
            if (type === 'bsa') {
                if (unit === 'metric') {
                    heightCm = parseFloat(document.getElementById('heightCm').value) || 170;
                } else {
                    const feet = parseFloat(document.getElementById('heightFeet').value) || 5;
                    const inches = parseFloat(document.getElementById('heightInches').value) || 7;
                    const totalInches = (feet * 12) + inches;
                    heightCm = totalInches * 2.54;
                }
            } else {
                heightCm = 170; // default for display
            }

            let singleDose = 0;
            let volumeToGive = null;
            let ivFlowRate = null;
            let ivDropRate = null;
            let bsa = 0;

            // Calculate BSA using Mosteller formula
            bsa = Math.sqrt((heightCm * weightKg) / 3600);

            // Calculate dose based on type
            if (type === 'weight') {
                const dosePerKg = parseFloat(document.getElementById('dosePerWeight').value) || 10;
                singleDose = dosePerKg * weightKg;
            } else if (type === 'bsa') {
                const dosePerBSA = parseFloat(document.getElementById('dosePerBSA').value) || 100;
                singleDose = dosePerBSA * bsa;
            } else if (type === 'concentration') {
                const totalDose = parseFloat(document.getElementById('totalDose').value) || 500;
                const concentration = parseFloat(document.getElementById('concentration').value) || 250;
                singleDose = totalDose;
                volumeToGive = totalDose / concentration;
            } else if (type === 'iv') {
                const ivVolume = parseFloat(document.getElementById('ivVolume').value) || 1000;
                const ivTime = parseFloat(document.getElementById('ivTime').value) || 8;
                ivFlowRate = ivVolume / ivTime;
                ivDropRate = (ivFlowRate * 15) / 60; // 15 gtt/mL drop factor
                singleDose = 0; // N/A for IV drip
            }

            const dailyDose = singleDose * frequency;
            const weeklyDose = dailyDose * 7;
            const monthlyDose = dailyDose * 30;

            // Frequency names
            const freqNames = {
                1: 'Once daily (QD)',
                2: 'Twice daily (BID)',
                3: 'Three times daily (TID)',
                4: 'Four times daily (QID)',
                6: 'Every 4 hours (Q4H)',
                8: 'Every 3 hours (Q3H)'
            };

            const freqShort = {
                1: 'Once',
                2: 'Twice',
                3: '3 times',
                4: '4 times',
                6: '6 times',
                8: '8 times'
            };

            // Display weight and height
            const weightLbs = weightKg * 2.20462;
            const displayWeight = unit === 'metric' ? 
                `${weightKg.toFixed(1)} kg` : 
                `${weightLbs.toFixed(1)} lbs`;
            
            const heightInches = heightCm / 2.54;
            const displayHeight = unit === 'metric' ? 
                `${heightCm.toFixed(1)} cm` : 
                `${Math.floor(heightInches / 12)}'${(heightInches % 12).toFixed(0)}"`;

            // Patient type names
            const patientNames = {
                'adult': 'Adult',
                'child': 'Child/Pediatric',
                'infant': 'Infant'
            };

            // Card class
            let cardClass = 'success';
            if (patientType === 'infant') cardClass = 'warning';
            else if (patientType === 'child') cardClass = 'info';

            // Analysis
            let analysis = '';
            if (type === 'weight') {
                const dosePerKg = parseFloat(document.getElementById('dosePerWeight').value) || 10;
                analysis = `For a ${patientNames[patientType].toLowerCase()} weighing ${displayWeight}, `;
                analysis += `at a prescribed dose of ${dosePerKg} mg/kg, the single dose is ${singleDose.toFixed(1)} mg. `;
                analysis += `With ${freqNames[frequency].toLowerCase()}, the total daily dose is ${dailyDose.toFixed(1)} mg/day. `;
                analysis += `This equals ${weeklyDose.toFixed(0)} mg/week or ${monthlyDose.toFixed(0)} mg/month. `;
            } else if (type === 'bsa') {
                const dosePerBSA = parseFloat(document.getElementById('dosePerBSA').value) || 100;
                analysis = `For a ${patientNames[patientType].toLowerCase()} with BSA of ${bsa.toFixed(2)} m² `;
                analysis += `(weight: ${displayWeight}, height: ${displayHeight}), `;
                analysis += `at a prescribed dose of ${dosePerBSA} mg/m², the single dose is ${singleDose.toFixed(1)} mg. `;
                analysis += `BSA-based dosing is commonly used for chemotherapy and some antibiotics to normalize for body size. `;
            } else if (type === 'concentration') {
                const totalDose = parseFloat(document.getElementById('totalDose').value) || 500;
                const concentration = parseFloat(document.getElementById('concentration').value) || 250;
                analysis = `To administer ${totalDose} mg of medication from a concentration of ${concentration} mg/mL, `;
                analysis += `you need to give ${volumeToGive.toFixed(2)} mL. `;
                analysis += `Always use an oral syringe or measuring cup for accuracy - household spoons are not accurate. `;
            } else if (type === 'iv') {
                const ivVolume = parseFloat(document.getElementById('ivVolume').value) || 1000;
                const ivTime = parseFloat(document.getElementById('ivTime').value) || 8;
                analysis = `To infuse ${ivVolume} mL over ${ivTime} hours, `;
                analysis += `set the IV pump to ${ivFlowRate.toFixed(1)} mL/hr. `;
                analysis += `If using a gravity drip with 15 gtt/mL drop factor, adjust to ${ivDropRate.toFixed(0)} drops per minute. `;
            }
            
            analysis += `⚠️ IMPORTANT: Always verify dosage calculations independently. This calculator is for educational purposes only and should not replace professional medical judgment.`;

            // Update UI
            const card = document.getElementById('resultCard');
            card.className = 'result-card ' + cardClass;

            if (type === 'iv') {
                document.getElementById('dosageResult').textContent = `${ivFlowRate.toFixed(1)} mL/hr`;
                document.getElementById('singleDoseDisplay').textContent = `${ivFlowRate.toFixed(1)} mL/hr`;
            } else {
                document.getElementById('dosageResult').textContent = `${singleDose.toFixed(1)} mg`;
                document.getElementById('singleDoseDisplay').textContent = `${singleDose.toFixed(1)} mg`;
            }
            
            document.getElementById('dailyDoseDisplay').textContent = type === 'iv' ? 'N/A' : `${dailyDose.toFixed(0)} mg`;
            document.getElementById('frequencyDisplay').textContent = freqShort[frequency];
            document.getElementById('volumeDisplay').textContent = volumeToGive ? `${volumeToGive.toFixed(2)} mL` : 'N/A';

            document.getElementById('patientDisplay').textContent = patientNames[patientType];
            document.getElementById('weightDisplay').textContent = displayWeight;
            document.getElementById('heightDisplay').textContent = displayHeight;
            document.getElementById('bsaDisplay').textContent = `${bsa.toFixed(2)} m²`;

            if (type === 'weight') {
                const dosePerKg = parseFloat(document.getElementById('dosePerWeight').value) || 10;
                document.getElementById('prescribedDose').textContent = `${dosePerKg} mg/kg`;
            } else if (type === 'bsa') {
                const dosePerBSA = parseFloat(document.getElementById('dosePerBSA').value) || 100;
                document.getElementById('prescribedDose').textContent = `${dosePerBSA} mg/m²`;
            }
            
            document.getElementById('singleDoseCalc').textContent = `${singleDose.toFixed(1)} mg`;
            document.getElementById('frequencyCalc').textContent = freqNames[frequency];
            document.getElementById('dailyDoseCalc').textContent = `${dailyDose.toFixed(1)} mg/day`;

            document.getElementById('weeklyTotal').textContent = `${weeklyDose.toFixed(0)} mg/week`;
            document.getElementById('monthlyTotal').textContent = `${monthlyDose.toFixed(0)} mg/month`;

            // Show/hide sections
            document.getElementById('liquidDoseSection').style.display = type === 'concentration' ? 'block' : 'none';
            document.getElementById('ivDripSection').style.display = type === 'iv' ? 'block' : 'none';
            document.getElementById('bsaDisplayItem').style.display = type === 'bsa' ? 'flex' : 'none';

            if (type === 'concentration') {
                const totalDose = parseFloat(document.getElementById('totalDose').value) || 500;
                const concentration = parseFloat(document.getElementById('concentration').value) || 250;
                document.getElementById('liquidDose').textContent = `${totalDose} mg`;
                document.getElementById('liquidConc').textContent = `${concentration} mg/mL`;
                document.getElementById('liquidVolume').textContent = `${volumeToGive.toFixed(2)} mL`;
            }

            if (type === 'iv') {
                const ivVolume = parseFloat(document.getElementById('ivVolume').value) || 1000;
                const ivTime = parseFloat(document.getElementById('ivTime').value) || 8;
                document.getElementById('ivVolumeDisplay').textContent = `${ivVolume} mL`;
                document.getElementById('ivTimeDisplay').textContent = `${ivTime} hours`;
                document.getElementById('ivFlowRate').textContent = `${ivFlowRate.toFixed(1)} mL/hr`;
                document.getElementById('ivDropRate').textContent = `${ivDropRate.toFixed(0)} gtt/min`;
            }

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleCalculationFields();
            toggleUnitFields();
            calculate();
        });
    </script>
</body>
</html>