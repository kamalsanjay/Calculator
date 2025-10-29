<?php
/**
 * IV Drip Rate Calculator
 * File: iv-drip-rate-calculator.php
 * Description: Calculate IV infusion rates (mL/hr and drops/min) for healthcare professionals
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IV Drip Rate Calculator - Infusion Rate Calculator (mL/hr & gtt/min)</title>
    <meta name="description" content="Free IV drip rate calculator. Calculate IV infusion rates in mL/hr and drops per minute (gtt/min). For healthcare professionals - nurses, doctors, paramedics.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>💉 IV Drip Rate Calculator</h1>
        <p>Calculate IV infusion rates</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>IV Infusion Details</h2>
                <form id="ivForm">
                    <div class="form-group">
                        <label for="calculationType">Calculate</label>
                        <select id="calculationType">
                            <option value="rate">Flow Rate (from volume & time)</option>
                            <option value="time">Infusion Time (from volume & rate)</option>
                            <option value="volume">Volume (from rate & time)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Infusion Parameters</h3>
                    
                    <div class="form-group" id="volumeGroup">
                        <label for="volume">Total Volume (mL)</label>
                        <input type="number" id="volume" value="1000" min="1" max="10000" step="1" required>
                        <small>Total amount of IV fluid to infuse</small>
                    </div>
                    
                    <div class="form-group" id="timeGroup">
                        <label for="time">Infusion Time (hours)</label>
                        <input type="number" id="time" value="8" min="0.1" max="24" step="0.1" required>
                        <small>Duration of infusion</small>
                    </div>
                    
                    <div class="form-group" id="rateGroup" style="display: none;">
                        <label for="rate">Flow Rate (mL/hr)</label>
                        <input type="number" id="rate" value="125" min="1" max="999" step="0.1">
                        <small>IV pump rate setting</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Drop Factor</h3>
                    
                    <div class="form-group">
                        <label for="dropFactor">Drop Factor (gtt/mL)</label>
                        <select id="dropFactor">
                            <option value="10">10 gtt/mL (Blood set)</option>
                            <option value="15" selected>15 gtt/mL (Standard macrodrip)</option>
                            <option value="20">20 gtt/mL (Macrodrip)</option>
                            <option value="60">60 gtt/mL (Microdrip/Pediatric)</option>
                            <option value="custom">Custom drop factor</option>
                        </select>
                        <small>Type of IV administration set</small>
                    </div>
                    
                    <div class="form-group" id="customDropGroup" style="display: none;">
                        <label for="customDrop">Custom Drop Factor (gtt/mL)</label>
                        <input type="number" id="customDrop" value="15" min="1" max="100" step="1">
                    </div>
                    
                    <button type="submit" class="btn">Calculate IV Rate</button>
                </form>
            </div>

            <div class="results-section">
                <h2>IV Rate Results</h2>
                
                <div class="result-card success">
                    <h3>Flow Rate (IV Pump)</h3>
                    <div class="amount" id="flowRateResult">125 mL/hr</div>
                    <div style="margin-top: 10px; font-size: 1em;">Set IV pump to this rate</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Flow Rate</h4>
                        <div class="value" id="flowDisplay">125 mL/hr</div>
                    </div>
                    <div class="metric-card">
                        <h4>Drop Rate</h4>
                        <div class="value" id="dropDisplay">31 gtt/min</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Volume</h4>
                        <div class="value" id="volumeDisplay">1000 mL</div>
                    </div>
                    <div class="metric-card">
                        <h4>Duration</h4>
                        <div class="value" id="durationDisplay">8 hrs</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Infusion Summary</h3>
                    <div class="breakdown-item">
                        <span>Total Volume to Infuse</span>
                        <strong id="totalVolume">1,000 mL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Infusion Duration</span>
                        <strong id="infusionTime">8 hours 0 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Flow Rate (IV Pump Setting)</span>
                        <strong id="pumpRate" style="color: #667eea; font-size: 1.1em;">125 mL/hr</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Drop Factor</span>
                        <strong id="dropFactorDisplay">15 gtt/mL (Standard)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Drop Rate (Manual Count)</span>
                        <strong id="dropRate" style="color: #4CAF50; font-size: 1.1em;">31 gtt/min</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Alternative Drop Factors</h3>
                    <div class="breakdown-item">
                        <span>10 gtt/mL (Blood set)</span>
                        <strong id="drop10">21 gtt/min</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>15 gtt/mL (Standard macrodrip)</span>
                        <strong id="drop15" style="color: #4CAF50;">31 gtt/min</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>20 gtt/mL (Macrodrip)</span>
                        <strong id="drop20">42 gtt/min</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>60 gtt/mL (Microdrip)</span>
                        <strong id="drop60">125 gtt/min</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Infusion Schedule</h3>
                    <div class="breakdown-item">
                        <span>Volume per Hour</span>
                        <strong id="volPerHour">125 mL/hr</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Volume per 30 Minutes</span>
                        <strong id="vol30Min">62.5 mL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Volume per 15 Minutes</span>
                        <strong id="vol15Min">31.3 mL</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Start Time</span>
                        <strong id="startTime">Now</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated Finish Time</span>
                        <strong id="finishTime">+8 hours</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>IV Rate Formulas</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Flow Rate (mL/hr):</strong></p>
                        <p>Flow Rate = Total Volume (mL) ÷ Time (hours)</p>
                        <p>Example: 1000 mL ÷ 8 hrs = 125 mL/hr</p>
                        <p><strong>Drop Rate (gtt/min):</strong></p>
                        <p>Drop Rate = (Volume × Drop Factor) ÷ (Time × 60)</p>
                        <p>Drop Rate = (mL/hr × Drop Factor) ÷ 60</p>
                        <p>Example: (125 × 15) ÷ 60 = 31.25 gtt/min</p>
                        <p><strong>Infusion Time:</strong></p>
                        <p>Time = Volume ÷ Flow Rate</p>
                        <p>Example: 1000 mL ÷ 125 mL/hr = 8 hours</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Drop Factor Types</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Macrodrip Sets (10-20 gtt/mL):</strong></p>
                        <p>• 10 gtt/mL: Blood transfusions, rapid infusions</p>
                        <p>• 15 gtt/mL: Most common for adults, standard IV tubing</p>
                        <p>• 20 gtt/mL: Alternative adult macrodrip set</p>
                        <p>• Use: Adult patients, faster infusion rates (&gt;100 mL/hr)</p>
                        <p><strong>Microdrip Sets (60 gtt/mL):</strong></p>
                        <p>• 60 gtt/mL: Pediatric, neonatal, precise medication administration</p>
                        <p>• Use: Children, infants, slow/precise infusions (&lt;100 mL/hr)</p>
                        <p>• Advantage: More accurate control at low rates</p>
                        <p><strong>Special Sets:</strong></p>
                        <p>• Blood sets: 10-15 gtt/mL with filter</p>
                        <p>• Burette sets: 60 gtt/mL with chamber for pediatric dosing</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Manual Drop Counting Method</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Steps to Count Drops:</strong></p>
                        <p>1. Calculate drops per minute using formula</p>
                        <p>2. Use watch with second hand or stopwatch</p>
                        <p>3. Count drops falling into drip chamber for 1 full minute</p>
                        <p>4. Adjust roller clamp until correct rate achieved</p>
                        <p>5. Recount to verify accuracy</p>
                        <p><strong>Shortcuts:</strong></p>
                        <p>• Count for 15 seconds, multiply by 4</p>
                        <p>• Count for 30 seconds, multiply by 2</p>
                        <p>• For microdrip (60 gtt/mL): drops/min = mL/hr (no math!)</p>
                        <p><strong>Tips:</strong></p>
                        <p>• Position eyes level with drip chamber</p>
                        <p>• Ensure drops are distinct (not streaming)</p>
                        <p>• Recheck rate hourly - gravity can change rate</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>IV Pump vs Gravity Drip</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>IV Pump (Electronic):</strong></p>
                        <p>• Set rate in mL/hr (no drop counting needed)</p>
                        <p>• Precise and consistent rate delivery</p>
                        <p>• Alarms for air, occlusion, completion</p>
                        <p>• Required for: critical medications, pediatrics, precise rates</p>
                        <p>• Most common in hospitals</p>
                        <p><strong>Gravity Drip (Manual):</strong></p>
                        <p>• Uses gravity - hang bag above patient</p>
                        <p>• Adjust roller clamp to control drops/min</p>
                        <p>• Less precise - affected by patient position, bag height</p>
                        <p>• Requires frequent monitoring and adjustment</p>
                        <p>• Use when: pumps unavailable, non-critical fluids, field settings</p>
                        <p><strong>Best Practice:</strong> Use IV pump whenever available for safety and accuracy</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Common IV Infusion Rates</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Maintenance Fluids (Adults):</strong></p>
                        <p>• Normal maintenance: 75-125 mL/hr (1.5-2 L over 24 hrs)</p>
                        <p>• To Keep Vein Open (TKVO): 10-30 mL/hr</p>
                        <p><strong>Bolus/Rapid Infusion:</strong></p>
                        <p>• Fluid resuscitation: 500-1000 mL over 15-60 min (500-1000+ mL/hr)</p>
                        <p>• Blood transfusion: Start 50 mL/hr × 15 min, then increase to 125-200 mL/hr</p>
                        <p><strong>Pediatric Maintenance:</strong></p>
                        <p>• 4-2-1 rule: 4 mL/kg/hr (first 10 kg) + 2 mL/kg/hr (next 10 kg) + 1 mL/kg/hr (remaining kg)</p>
                        <p>• Example: 25 kg child = (4×10) + (2×10) + (1×5) = 65 mL/hr</p>
                        <p><strong>Medication Infusions:</strong></p>
                        <p>• Usually 50-100 mL over 30-60 minutes</p>
                        <p>• Always check drug-specific guidelines</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>IV Safety Checks</h3>
                    <div style="padding: 15px; background: #fff3e0; border-radius: 5px; line-height: 1.8; border-left: 4px solid #FF9800;">
                        <p><strong>⚠️ Before Starting IV:</strong></p>
                        <p>• Verify correct patient (2 identifiers)</p>
                        <p>• Check IV order: fluid type, volume, rate, additives</p>
                        <p>• Inspect fluid bag: expiration, clarity, leaks</p>
                        <p>• Check IV site: patent, no infiltration/phlebitis</p>
                        <p>• Prime tubing completely (no air bubbles)</p>
                        <p>• Set correct rate on pump or count drops</p>
                        <p><strong>During Infusion (Hourly Checks):</strong></p>
                        <p>• IV site: redness, swelling, pain, coolness</p>
                        <p>• Rate accuracy (gravity drips slow down over time)</p>
                        <p>• Volume infused vs expected</p>
                        <p>• Patient symptoms: shortness of breath, chest pain</p>
                        <p><strong>Red Flags (Stop Immediately):</strong></p>
                        <p>• Infiltration: swelling, coolness, blanching at site</p>
                        <p>• Phlebitis: redness, warmth, pain along vein</p>
                        <p>• Air in tubing</p>
                        <p>• Patient respiratory distress (fluid overload)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Complications of IV Therapy</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Infiltration:</strong> IV fluid leaks into surrounding tissue. Signs: swelling, cool, pale, pain. Action: Stop IV, remove, elevate limb.</p>
                        <p><strong>Phlebitis:</strong> Vein inflammation. Signs: red, warm, tender along vein. Action: Remove IV, warm compress, document.</p>
                        <p><strong>Fluid Overload:</strong> Too much/too fast. Signs: crackles in lungs, shortness of breath, edema. Action: Slow/stop IV, notify physician.</p>
                        <p><strong>Air Embolism:</strong> Air in vein (rare but serious). Signs: sudden dyspnea, chest pain, decreased consciousness. Action: Clamp line, left side/Trendelenburg position, 100% O2, emergency response.</p>
                        <p><strong>Infection:</strong> Bacteria enter bloodstream. Signs: fever, chills, redness at site. Action: Blood cultures, remove IV, antibiotics.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>IV Rate Tips:</strong> Flow rate (mL/hr) = Volume ÷ Time. Drop rate = (mL/hr × Drop factor) ÷ 60. Macrodrip = 10-20 gtt/mL (adults). Microdrip = 60 gtt/mL (pediatrics). For 60 gtt/mL: drops/min = mL/hr. IV pump more accurate than gravity. Count drops for 1 full minute. Recheck hourly. TKVO = 10-30 mL/hr. Maintenance = 75-125 mL/hr. Check IV site hourly. Stop if infiltration/phlebitis. Prime tubing (no air). 2 patient identifiers. Follow 5 rights. Document rate changes. Fluid overload = serious. Air in line = emergency. For healthcare professionals only!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('ivForm');
        const typeSelect = document.getElementById('calculationType');
        const dropFactorSelect = document.getElementById('dropFactor');

        typeSelect.addEventListener('change', function() {
            toggleCalculationFields();
            calculateIVRate();
        });

        dropFactorSelect.addEventListener('change', function() {
            toggleCustomDrop();
            calculateIVRate();
        });

        function toggleCalculationFields() {
            const type = typeSelect.value;
            
            document.getElementById('volumeGroup').style.display = type !== 'volume' ? 'block' : 'none';
            document.getElementById('timeGroup').style.display = type !== 'time' ? 'block' : 'none';
            document.getElementById('rateGroup').style.display = type === 'rate' ? 'none' : 'block';
        }

        function toggleCustomDrop() {
            const dropFactor = dropFactorSelect.value;
            document.getElementById('customDropGroup').style.display = dropFactor === 'custom' ? 'block' : 'none';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateIVRate();
        });

        function calculateIVRate() {
            const type = typeSelect.value;
            let volume = parseFloat(document.getElementById('volume').value) || 1000;
            let time = parseFloat(document.getElementById('time').value) || 8;
            let rate = parseFloat(document.getElementById('rate').value) || 125;
            
            // Calculate based on type
            let flowRate, infusionTime, totalVolume;
            
            if (type === 'rate') {
                totalVolume = volume;
                infusionTime = time;
                flowRate = volume / time;
            } else if (type === 'time') {
                totalVolume = volume;
                flowRate = rate;
                infusionTime = volume / rate;
            } else {
                flowRate = rate;
                infusionTime = time;
                totalVolume = rate * time;
            }

            // Get drop factor
            let dropFactor;
            const dropFactorValue = dropFactorSelect.value;
            if (dropFactorValue === 'custom') {
                dropFactor = parseFloat(document.getElementById('customDrop').value) || 15;
            } else {
                dropFactor = parseFloat(dropFactorValue);
            }

            // Calculate drop rate
            const dropRate = (flowRate * dropFactor) / 60;

            // Calculate alternative drop rates
            const drop10 = (flowRate * 10) / 60;
            const drop15 = (flowRate * 15) / 60;
            const drop20 = (flowRate * 20) / 60;
            const drop60 = (flowRate * 60) / 60;

            // Volume per time intervals
            const volPerHour = flowRate;
            const vol30Min = flowRate / 2;
            const vol15Min = flowRate / 4;

            // Format time
            const formatTime = (hours) => {
                const h = Math.floor(hours);
                const m = Math.round((hours - h) * 60);
                if (h === 0) return `${m} minutes`;
                if (m === 0) return `${h} hour${h > 1 ? 's' : ''}`;
                return `${h} hour${h > 1 ? 's' : ''} ${m} minute${m > 1 ? 's' : ''}`;
            };

            // Drop factor names
            const dropFactorNames = {
                '10': '10 gtt/mL (Blood set)',
                '15': '15 gtt/mL (Standard)',
                '20': '20 gtt/mL (Macrodrip)',
                '60': '60 gtt/mL (Microdrip)',
                'custom': `${dropFactor} gtt/mL (Custom)`
            };

            // Analysis
            let analysis = `To infuse ${totalVolume.toFixed(0)} mL over ${formatTime(infusionTime)}, `;
            analysis += `set your IV pump to ${flowRate.toFixed(1)} mL/hr. `;
            
            if (dropFactor === 60) {
                analysis += `With a ${dropFactor} gtt/mL microdrip set, the drop rate is ${dropRate.toFixed(0)} drops per minute. `;
                analysis += `Convenient tip: With 60 gtt/mL tubing, the drop rate in gtt/min equals the flow rate in mL/hr (no math needed!). `;
            } else {
                analysis += `If using gravity drip with ${dropFactor} gtt/mL tubing, adjust the roller clamp to ${dropRate.toFixed(0)} drops per minute. `;
            }
            
            analysis += `Count drops falling into the drip chamber for one full minute using a watch. `;
            analysis += `The patient will receive ${volPerHour.toFixed(1)} mL every hour, ${vol30Min.toFixed(1)} mL every 30 minutes, and ${vol15Min.toFixed(1)} mL every 15 minutes. `;
            
            if (flowRate > 200) {
                analysis += `⚠️ This is a relatively fast infusion rate (>${200} mL/hr). Monitor patient closely for fluid overload symptoms. `;
            } else if (flowRate < 30) {
                analysis += `This is a slow infusion rate. Consider using microdrip tubing (60 gtt/mL) for more precise control. `;
            }
            
            analysis += `Remember to check the IV site hourly for infiltration or phlebitis. `;
            analysis += `Verify the correct patient, fluid type, and rate before starting the infusion. `;
            analysis += `This calculator is for healthcare professionals only - always follow your facility's protocols and physician orders.`;

            // Update UI
            document.getElementById('flowRateResult').textContent = `${flowRate.toFixed(1)} mL/hr`;
            document.getElementById('flowDisplay').textContent = `${flowRate.toFixed(0)} mL/hr`;
            document.getElementById('dropDisplay').textContent = `${dropRate.toFixed(0)} gtt/min`;
            document.getElementById('volumeDisplay').textContent = `${totalVolume.toFixed(0)} mL`;
            document.getElementById('durationDisplay').textContent = formatTime(infusionTime).replace('hours', 'hrs').replace('hour', 'hr').replace('minutes', 'min');

            document.getElementById('totalVolume').textContent = `${totalVolume.toLocaleString()} mL`;
            document.getElementById('infusionTime').textContent = formatTime(infusionTime);
            document.getElementById('pumpRate').textContent = `${flowRate.toFixed(1)} mL/hr`;
            document.getElementById('dropFactorDisplay').textContent = dropFactorNames[dropFactorValue] || `${dropFactor} gtt/mL`;
            document.getElementById('dropRate').textContent = `${dropRate.toFixed(0)} gtt/min`;

            document.getElementById('drop10').textContent = `${drop10.toFixed(0)} gtt/min`;
            document.getElementById('drop15').textContent = `${drop15.toFixed(0)} gtt/min`;
            document.getElementById('drop20').textContent = `${drop20.toFixed(0)} gtt/min`;
            document.getElementById('drop60').textContent = `${drop60.toFixed(0)} gtt/min`;

            document.getElementById('volPerHour').textContent = `${volPerHour.toFixed(1)} mL/hr`;
            document.getElementById('vol30Min').textContent = `${vol30Min.toFixed(1)} mL`;
            document.getElementById('vol15Min').textContent = `${vol15Min.toFixed(1)} mL`;
            document.getElementById('startTime').textContent = 'Now';
            document.getElementById('finishTime').textContent = `+${formatTime(infusionTime)}`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleCalculationFields();
            toggleCustomDrop();
            calculateIVRate();
        });
    </script>
</body>
</html>