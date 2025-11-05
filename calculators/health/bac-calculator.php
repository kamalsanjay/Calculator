<?php
/**
 * BAC Calculator
 * File: bac-calculator.php
 * Description: Calculate Blood Alcohol Content (BAC) and time to sober (Imperial/Metric)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAC Calculator - Blood Alcohol Content (Imperial/Metric)</title>
    <meta name="description" content="Free BAC calculator. Calculate blood alcohol content based on drinks consumed, weight, gender, and time. Estimate time to sober. Imperial and metric units.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#127866; BAC Calculator</h1>
        <p>Calculate Blood Alcohol Content</p>
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
                <form id="bacForm">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <small>Affects body water percentage</small>
                    </div>

                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="imperial">Imperial (lbs)</option>
                            <option value="metric">Metric (kg)</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="weightImperialGroup">
                        <label for="weightLbs">Body Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="180" min="50" max="500" step="1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Body Weight (kg)</label>
                        <input type="number" id="weightKg" value="82" min="20" max="250" step="0.1">
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Alcohol Consumed</h3>
                    
                    <div class="form-group">
                        <label for="drinkType">Drink Type</label>
                        <select id="drinkType">
                            <option value="beer">Beer (12 oz, 5% ABV)</option>
                            <option value="wine">Wine (5 oz, 12% ABV)</option>
                            <option value="shot">Liquor/Shot (1.5 oz, 40% ABV)</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="numDrinks">Number of Drinks</label>
                        <input type="number" id="numDrinks" value="3" min="0" max="30" step="0.5" required>
                    </div>
                    
                    <div id="customDrinkGroup" style="display: none;">
                        <div class="form-group">
                            <label for="drinkVolume">Drink Volume (oz)</label>
                            <input type="number" id="drinkVolume" value="12" min="0.5" max="50" step="0.5">
                        </div>
                        
                        <div class="form-group">
                            <label for="alcoholPercent">Alcohol % (ABV)</label>
                            <input type="number" id="alcoholPercent" value="5" min="0" max="100" step="0.1">
                        </div>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Time Elapsed</h3>
                    
                    <div class="form-group">
                        <label for="hoursElapsed">Hours Since First Drink</label>
                        <input type="number" id="hoursElapsed" value="2" min="0" max="24" step="0.25" required>
                        <small>Time from first drink to now</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate BAC</button>
                </form>
            </div>

            <div class="results-section">
                <h2>BAC Results</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Blood Alcohol Content</h3>
                    <div class="amount" id="bacResult">0.00%</div>
                    <div style="margin-top: 10px; font-size: 1.1em;" id="bacStatus">Sober</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Impairment Level</h4>
                        <div class="value" id="impairmentLevel">None</div>
                    </div>
                    <div class="metric-card">
                        <h4>Legal to Drive?</h4>
                        <div class="value" id="legalStatus">Yes</div>
                    </div>
                    <div class="metric-card">
                        <h4>Time to Sober</h4>
                        <div class="value" id="timeToSober">0 hours</div>
                    </div>
                    <div class="metric-card">
                        <h4>Sober At</h4>
                        <div class="value" id="soberTime">Now</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Information</h3>
                    <div class="breakdown-item">
                        <span>Gender</span>
                        <strong id="genderDisplay">Male</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight</span>
                        <strong id="weightDisplay">180 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Drinks Consumed</span>
                        <strong id="drinksDisplay">3 beers</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Time Elapsed</span>
                        <strong id="timeDisplay">2 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Alcohol</span>
                        <strong id="alcoholDisplay">0 oz</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>BAC Calculation</h3>
                    <div class="breakdown-item">
                        <span>Alcohol Consumed (grams)</span>
                        <strong id="alcoholGrams">0 g</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Body Water %</span>
                        <strong id="bodyWater">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Peak BAC (at start)</span>
                        <strong id="peakBac">0.00%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Alcohol Metabolized</span>
                        <strong id="alcoholMetabolized">0 g</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Current BAC</strong></span>
                        <strong id="currentBac" style="color: #667eea; font-size: 1.1em;">0.00%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>BAC Levels & Effects</h3>
                    <div class="breakdown-item">
                        <span>0.00% - Sober</span>
                        <strong style="color: #4CAF50;">No impairment</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>0.01-0.05% - Slight</span>
                        <strong style="color: #4CAF50;">Relaxation, warmth</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>0.05-0.08% - Mild</span>
                        <strong style="color: #FF9800;">Reduced coordination</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>0.08-0.15% - Illegal</span>
                        <strong style="color: #f44336;">Impaired driving, balance</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>0.15-0.30% - High</span>
                        <strong style="color: #f44336;">Severe impairment</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>0.30-0.40% - Dangerous</span>
                        <strong style="color: #f44336;">Unconsciousness</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>0.40%+ - Fatal</span>
                        <strong style="color: #f44336;">Life-threatening</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Legal Limits by Country</h3>
                    <div class="breakdown-item">
                        <span>United States</span>
                        <strong>0.08%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>United Kingdom</span>
                        <strong>0.08% (England/Wales), 0.05% (Scotland)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Canada</span>
                        <strong>0.08%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Australia</span>
                        <strong>0.05%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>India</span>
                        <strong>0.03%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Most of Europe</span>
                        <strong>0.05%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Japan</span>
                        <strong>0.03%</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Standard Drink Equivalents</h3>
                    <div class="breakdown-item">
                        <span>Beer (12 oz, 5% ABV)</span>
                        <strong>1 standard drink (0.6 oz alcohol)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Wine (5 oz, 12% ABV)</span>
                        <strong>1 standard drink (0.6 oz alcohol)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Liquor (1.5 oz, 40% ABV)</span>
                        <strong>1 standard drink (0.6 oz alcohol)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Malt Liquor (8 oz, 7% ABV)</span>
                        <strong>1 standard drink (0.6 oz alcohol)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Metabolism Facts</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Elimination Rate:</strong> Average 0.015% BAC per hour (roughly 1 drink per hour).</p>
                        <p><strong>Gender Difference:</strong> Women have less body water (~55% vs 68% for men), resulting in higher BAC.</p>
                        <p><strong>Cannot Speed Up:</strong> Coffee, cold showers, exercise don't lower BAC. Only time works.</p>
                        <p><strong>Empty Stomach:</strong> Alcohol absorbs faster on empty stomach, higher peak BAC.</p>
                        <p><strong>Carbonation:</strong> Carbonated drinks (champagne, mixers) increase absorption rate.</p>
                        <p><strong>Individual Variation:</strong> Age, liver health, medications, tolerance affect BAC.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Impairment Effects</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>0.02-0.05%:</strong> Relaxation, slight body warmth, altered mood, decreased inhibition.</p>
                        <p><strong>0.05-0.08%:</strong> Reduced coordination, impaired judgment, exaggerated behavior, reduced ability to track moving objects.</p>
                        <p><strong>0.08-0.15%:</strong> Poor muscle control, slurred speech, impaired balance, memory problems, slower reaction time.</p>
                        <p><strong>0.15-0.30%:</strong> Severe impairment, vomiting, loss of balance, difficulty walking, blurred vision.</p>
                        <p><strong>0.30-0.40%:</strong> Loss of consciousness, dangerous depression of central nervous system, possible death.</p>
                        <p><strong>0.40%+:</strong> Coma, respiratory failure, death highly likely.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Important Safety Information</h3>
                    <div style="padding: 15px; background: #ffebee; border-radius: 5px; line-height: 1.8; border-left: 4px solid #f44336;">
                        <p><strong>⚠️ WARNING:</strong></p>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li><strong>NEVER drink and drive</strong> - Even below legal limit impairs driving</li>
                            <li>This calculator is an estimate only - actual BAC varies</li>
                            <li>Only reliable BAC = breathalyzer or blood test</li>
                            <li>If in doubt, don't drive - call taxi/rideshare</li>
                            <li>Alcohol poisoning (BAC 0.30%+) is medical emergency - call 911</li>
                            <li>Mixing alcohol with medications can be dangerous</li>
                            <li>Pregnant women should not drink alcohol</li>
                            <li>Legal drinking age: 21 in US, varies by country</li>
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
                    <strong>BAC Tips:</strong> BAC = Blood Alcohol Content. Widmark formula used for calculation. Average elimination = 0.015%/hour. 1 standard drink = 0.6 oz pure alcohol. Women metabolize slower than men. Food slows absorption. Peak BAC = 30-90 min after drinking. Cannot speed up metabolism. Coffee doesn't sober you up. Legal limit US = 0.08%. Zero tolerance for under 21. DUI penalties severe. Breathalyzer = most accurate. Never drink and drive. Plan ahead - designated driver or rideshare. Alcohol poisoning = medical emergency. Know your limits. Drink responsibly. When in doubt, don't drive!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('bacForm');
        const unitSystemSelect = document.getElementById('unitSystem');
        const drinkTypeSelect = document.getElementById('drinkType');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateBAC();
        });

        drinkTypeSelect.addEventListener('change', function() {
            toggleCustomDrink();
            calculateBAC();
        });

        function toggleUnitFields() {
            const unitSystem = unitSystemSelect.value;
            const isImperial = unitSystem === 'imperial';
            
            document.getElementById('weightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('weightMetricGroup').style.display = isImperial ? 'none' : 'block';
        }

        function toggleCustomDrink() {
            const drinkType = drinkTypeSelect.value;
            document.getElementById('customDrinkGroup').style.display = drinkType === 'custom' ? 'block' : 'none';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBAC();
        });

        function calculateBAC() {
            const gender = document.getElementById('gender').value;
            const unitSystem = unitSystemSelect.value;
            const drinkType = drinkTypeSelect.value;
            const numDrinks = parseFloat(document.getElementById('numDrinks').value) || 0;
            const hoursElapsed = parseFloat(document.getElementById('hoursElapsed').value) || 0;
            
            // Get weight in pounds
            let weightLbs;
            if (unitSystem === 'imperial') {
                weightLbs = parseFloat(document.getElementById('weightLbs').value) || 180;
            } else {
                const weightKg = parseFloat(document.getElementById('weightKg').value) || 82;
                weightLbs = weightKg * 2.20462;
            }

            // Get alcohol content per drink
            let alcoholOzPerDrink;
            let drinkName;
            
            if (drinkType === 'beer') {
                alcoholOzPerDrink = 12 * 0.05; // 12 oz * 5% ABV
                drinkName = 'beer';
            } else if (drinkType === 'wine') {
                alcoholOzPerDrink = 5 * 0.12; // 5 oz * 12% ABV
                drinkName = 'wine';
            } else if (drinkType === 'shot') {
                alcoholOzPerDrink = 1.5 * 0.40; // 1.5 oz * 40% ABV
                drinkName = 'shot';
            } else {
                const volume = parseFloat(document.getElementById('drinkVolume').value) || 12;
                const percent = parseFloat(document.getElementById('alcoholPercent').value) / 100 || 0.05;
                alcoholOzPerDrink = volume * percent;
                drinkName = 'drink';
            }

            // Total alcohol in ounces
            const totalAlcoholOz = alcoholOzPerDrink * numDrinks;
            
            // Convert to grams (1 oz alcohol = 28.35 grams, but alcohol density = 0.789)
            const alcoholGrams = totalAlcoholOz * 23.36;

            // Widmark formula constants
            const r = gender === 'male' ? 0.68 : 0.55; // Body water percentage
            const metabolismRate = 0.015; // BAC decrease per hour

            // Calculate peak BAC (at start of drinking)
            const weightGrams = weightLbs * 453.592;
            const peakBAC = (alcoholGrams / (weightGrams * r)) * 100;

            // Calculate current BAC (after time elapsed)
            const metabolized = metabolismRate * hoursElapsed * 100;
            let currentBAC = Math.max(0, peakBAC - metabolized);

            // Determine impairment level
            let impairment = '';
            let bacStatus = '';
            let statusColor = '';
            let cardClass = '';
            let legalToDrive = '';
            
            if (currentBAC === 0) {
                impairment = 'Sober';
                bacStatus = 'Sober';
                statusColor = '#4CAF50';
                cardClass = 'success';
                legalToDrive = 'Yes';
            } else if (currentBAC < 0.05) {
                impairment = 'Slight';
                bacStatus = 'Slight Impairment';
                statusColor = '#4CAF50';
                cardClass = 'success';
                legalToDrive = 'Yes (but impaired)';
            } else if (currentBAC < 0.08) {
                impairment = 'Mild';
                bacStatus = 'Mildly Impaired';
                statusColor = '#FF9800';
                cardClass = 'warning';
                legalToDrive = 'Borderline';
            } else if (currentBAC < 0.15) {
                impairment = 'Moderate';
                bacStatus = 'Legally Drunk';
                statusColor = '#f44336';
                cardClass = 'warning';
                legalToDrive = 'NO - Illegal';
            } else if (currentBAC < 0.30) {
                impairment = 'Severe';
                bacStatus = 'Severely Impaired';
                statusColor = '#f44336';
                cardClass = 'warning';
                legalToDrive = 'NO - Dangerous';
            } else {
                impairment = 'Critical';
                bacStatus = 'Medical Emergency';
                statusColor = '#f44336';
                cardClass = 'warning';
                legalToDrive = 'NO - Call 911';
            }

            // Time to reach 0.00 BAC
            const hoursToSober = currentBAC > 0 ? currentBAC / metabolismRate : 0;
            const soberTime = new Date();
            soberTime.setHours(soberTime.getHours() + hoursToSober);

            // Alcohol metabolized
            const alcoholMetabolized = Math.min(alcoholGrams, alcoholGrams * (metabolized / peakBAC));

            // Update card
            const card = document.getElementById('resultCard');
            card.className = 'result-card ' + cardClass;
            card.style.background = currentBAC >= 0.08 ? 
                'linear-gradient(135deg, #f44336 0%, #d32f2f 100%)' : 
                '';
            if (currentBAC >= 0.08) {
                card.style.color = 'white';
                document.getElementById('bacStatus').style.color = 'white';
            } else {
                card.style.color = '';
                document.getElementById('bacStatus').style.color = statusColor;
            }

            // Analysis
            let analysis = `Based on ${numDrinks.toFixed(1)} ${drinkName}${numDrinks !== 1 ? 's' : ''} consumed over ${hoursElapsed.toFixed(1)} hours, `;
            analysis += `your estimated BAC is ${currentBAC.toFixed(3)}%. `;
            
            if (currentBAC === 0) {
                analysis += `You are completely sober. `;
            } else if (currentBAC < 0.08) {
                analysis += `This is below the legal limit (0.08%), but you are still impaired. `;
            } else if (currentBAC < 0.15) {
                analysis += `This exceeds the legal driving limit of 0.08%. DO NOT DRIVE. `;
            } else if (currentBAC < 0.30) {
                analysis += `This is a dangerous level of intoxication. Seek safe transportation and supervision. `;
            } else {
                analysis += `This is a critical BAC level. SEEK MEDICAL ATTENTION IMMEDIATELY. `;
            }
            
            if (hoursToSober > 0) {
                analysis += `You will reach 0.00% BAC in approximately ${hoursToSober.toFixed(1)} hours. `;
            }
            
            analysis += `Remember: this is an estimate. Only time eliminates alcohol. Never drink and drive.`;

            // Update UI
            document.getElementById('bacResult').textContent = currentBAC.toFixed(3) + '%';
            document.getElementById('bacStatus').textContent = bacStatus;
            document.getElementById('impairmentLevel').textContent = impairment;
            document.getElementById('impairmentLevel').style.color = statusColor;
            document.getElementById('legalStatus').textContent = legalToDrive;
            document.getElementById('legalStatus').style.color = legalToDrive.includes('NO') ? '#f44336' : '#4CAF50';
            document.getElementById('timeToSober').textContent = hoursToSober > 0 ? 
                `${Math.floor(hoursToSober)} hrs ${Math.round((hoursToSober % 1) * 60)} min` : 
                'Now';
            document.getElementById('soberTime').textContent = hoursToSober > 0 ? 
                soberTime.toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit', hour12: true}) : 
                'Now';

            document.getElementById('genderDisplay').textContent = gender === 'male' ? 'Male' : 'Female';
            document.getElementById('weightDisplay').textContent = unitSystem === 'imperial' ? 
                `${weightLbs.toFixed(0)} lbs` : 
                `${(weightLbs / 2.20462).toFixed(1)} kg`;
            document.getElementById('drinksDisplay').textContent = `${numDrinks} ${drinkName}${numDrinks !== 1 ? 's' : ''}`;
            document.getElementById('timeDisplay').textContent = `${hoursElapsed} hours`;
            document.getElementById('alcoholDisplay').textContent = `${totalAlcoholOz.toFixed(2)} oz pure alcohol`;

            document.getElementById('alcoholGrams').textContent = `${alcoholGrams.toFixed(1)} g`;
            document.getElementById('bodyWater').textContent = `${(r * 100).toFixed(0)}%`;
            document.getElementById('peakBac').textContent = peakBAC.toFixed(3) + '%';
            document.getElementById('alcoholMetabolized').textContent = `${alcoholMetabolized.toFixed(1)} g`;
            document.getElementById('currentBac').textContent = currentBAC.toFixed(3) + '%';

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            toggleCustomDrink();
            calculateBAC();
        });
    </script>
</body>
</html>