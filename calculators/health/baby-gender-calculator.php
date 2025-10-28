<?php
/**
 * Baby Gender Calculator
 * File: baby-gender-calculator.php
 * Description: Predict baby gender using Chinese calendar and other methods
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Gender Calculator - Predict Baby Boy or Girl</title>
    <meta name="description" content="Free baby gender calculator. Predict baby gender using Chinese gender chart, Ramzi method, and other prediction methods. Just for fun!">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#128118; Baby Gender Calculator</h1>
        <p>Predict baby gender (Just for fun!)</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Prediction Methods</h2>
                <form id="genderForm">
                    <div class="form-group">
                        <label for="predictionMethod">Prediction Method</label>
                        <select id="predictionMethod">
                            <option value="chinese">Chinese Gender Chart</option>
                            <option value="ramzi">Ramzi Theory (6-8 weeks)</option>
                            <option value="heartrate">Heart Rate Method</option>
                            <option value="multiple">All Methods Combined</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Mother's Information</h3>
                    
                    <div class="form-group" id="ageGroup">
                        <label for="motherAge">Mother's Age at Conception</label>
                        <input type="number" id="motherAge" value="28" min="15" max="50" step="1" required>
                        <small>Lunar age (add 1 to actual age for Chinese method)</small>
                    </div>
                    
                    <div class="form-group" id="conceptionMonthGroup">
                        <label for="conceptionMonth">Month of Conception</label>
                        <select id="conceptionMonth">
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5" selected>May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="conceptionDateGroup" style="display: none;">
                        <label for="conceptionDate">Conception Date (Estimated)</label>
                        <input type="date" id="conceptionDate">
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;" id="additionalInfoTitle">Additional Information</h3>
                    
                    <div class="form-group" id="placentaGroup" style="display: none;">
                        <label for="placentaSide">Placenta Side (Ramzi Theory)</label>
                        <select id="placentaSide">
                            <option value="left">Left Side</option>
                            <option value="right">Right Side</option>
                            <option value="unknown">Unknown</option>
                        </select>
                        <small>Based on 6-8 week ultrasound</small>
                    </div>
                    
                    <div class="form-group" id="heartRateGroup" style="display: none;">
                        <label for="heartRate">Fetal Heart Rate (BPM)</label>
                        <input type="number" id="heartRate" value="140" min="110" max="180" step="1">
                        <small>Normal range: 110-180 BPM</small>
                    </div>
                    
                    <div class="form-group" id="morningGroup" style="display: none;">
                        <label for="morningSickness">Morning Sickness</label>
                        <select id="morningSickness">
                            <option value="none">None/Mild</option>
                            <option value="moderate">Moderate</option>
                            <option value="severe">Severe</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="cravingsGroup" style="display: none;">
                        <label for="cravings">Food Cravings</label>
                        <select id="cravings">
                            <option value="sweet">Sweet Foods</option>
                            <option value="salty">Salty/Savory Foods</option>
                            <option value="both">Both</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Predict Gender</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Gender Prediction</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Predicted Gender</h3>
                    <div class="amount" id="predictedGender" style="font-size: 3em;">&#128118;</div>
                    <div style="font-size: 1.5em; margin-top: 10px; color: #667eea;" id="genderText">Baby</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Chinese Chart</h4>
                        <div class="value" id="chineseResult">-</div>
                    </div>
                    <div class="metric-card">
                        <h4>Ramzi Theory</h4>
                        <div class="value" id="ramziResult">-</div>
                    </div>
                    <div class="metric-card">
                        <h4>Heart Rate</h4>
                        <div class="value" id="heartRateResult">-</div>
                    </div>
                    <div class="metric-card">
                        <h4>Confidence</h4>
                        <div class="value" id="confidence">50%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Information</h3>
                    <div class="breakdown-item">
                        <span>Mother's Age at Conception</span>
                        <strong id="ageDisplay">28 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Month of Conception</span>
                        <strong id="monthDisplay">May</strong>
                    </div>
                    <div class="breakdown-item" id="placentaDisplayItem" style="display: none;">
                        <span>Placenta Side</span>
                        <strong id="placentaDisplay">Right</strong>
                    </div>
                    <div class="breakdown-item" id="heartRateDisplayItem" style="display: none;">
                        <span>Fetal Heart Rate</span>
                        <strong id="heartRateDisplay">140 BPM</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Prediction Methods Used</h3>
                    <div class="breakdown-item">
                        <span>Chinese Gender Chart</span>
                        <strong id="chinesePrediction" style="color: #667eea;">Boy/Girl</strong>
                    </div>
                    <div class="breakdown-item" id="ramziItem" style="display: none;">
                        <span>Ramzi Theory</span>
                        <strong id="ramziPrediction">Boy/Girl</strong>
                    </div>
                    <div class="breakdown-item" id="heartRateItem" style="display: none;">
                        <span>Heart Rate Method</span>
                        <strong id="heartRatePrediction">Boy/Girl</strong>
                    </div>
                    <div class="breakdown-item" id="sicknessItem" style="display: none;">
                        <span>Morning Sickness</span>
                        <strong id="sicknessPrediction">Boy/Girl</strong>
                    </div>
                    <div class="breakdown-item" id="cravingsItem" style="display: none;">
                        <span>Food Cravings</span>
                        <strong id="cravingsPrediction">Boy/Girl</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Chinese Gender Chart Explained</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>The Chinese Gender Chart is based on the mother's lunar age at conception and the lunar month of conception. Legend says it was found in a royal tomb near Beijing over 700 years ago.</p>
                        <p><strong>How to use:</strong> Find the intersection of your lunar age (actual age + 1) and the lunar month of conception on the chart.</p>
                        <p><strong>Note:</strong> This is for entertainment purposes only. Actual accuracy is approximately 50% (same as guessing!).</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Other Prediction Methods</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Ramzi Theory:</strong> Based on placenta position at 6-8 weeks. Right side = boy, left side = girl. Some studies suggest 97% accuracy, but not scientifically proven.</p>
                        <p><strong>Heart Rate:</strong> Old wives' tale says >140 BPM = girl, <140 BPM = boy. Studies show no correlation.</p>
                        <p><strong>Morning Sickness:</strong> Severe sickness supposedly indicates girl. Not scientifically proven.</p>
                        <p><strong>Cravings:</strong> Sweet = girl, salty/savory = boy. Pure folklore with no scientific basis.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Accurate Gender Determination Methods</h3>
                    <div class="breakdown-item">
                        <span>Ultrasound (18-20 weeks)</span>
                        <strong style="color: #4CAF50;">~95% accurate</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>NIPT Blood Test (10+ weeks)</span>
                        <strong style="color: #4CAF50;">~99% accurate</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Amniocentesis</span>
                        <strong style="color: #4CAF50;">~100% accurate</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CVS (Chorionic Villus Sampling)</span>
                        <strong style="color: #4CAF50;">~100% accurate</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Fun Baby Gender Myths</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#128102; <strong>Carrying high = girl, low = boy</strong> - Actually depends on muscle tone and baby position</p>
                        <p>&#127828; <strong>Sweet cravings = girl, salty = boy</strong> - Cravings are hormonal, not gender-related</p>
                        <p>&#128150; <strong>Heart rate >140 = girl</strong> - Heart rate varies throughout pregnancy</p>
                        <p>&#128129; <strong>Acne = girl (stealing mom's beauty)</strong> - Just pregnancy hormones!</p>
                        <p>&#9875; <strong>Ring on string test</strong> - Circular = girl, back and forth = boy (pure entertainment)</p>
                        <p>&#127752; <strong>Chinese calendar</strong> - 50/50 accuracy (same as chance)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>When Will You Know for Sure?</h3>
                    <div class="breakdown-item">
                        <span>NIPT Blood Test</span>
                        <strong>10 weeks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ultrasound (Anatomy Scan)</span>
                        <strong>18-20 weeks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>3D/4D Ultrasound</span>
                        <strong>16-20 weeks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At Birth</span>
                        <strong style="color: #4CAF50;">100% sure! &#128118;</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Important Disclaimer</h3>
                    <div style="padding: 15px; background: #fff3cd; border-radius: 5px; line-height: 1.8; border-left: 4px solid #FF9800;">
                        <p><strong>&#9888; For Entertainment Only!</strong></p>
                        <p>This calculator is for fun and should NOT be used for medical decisions or planning. The predictions are based on folklore, old wives' tales, and non-scientific methods.</p>
                        <p>The only accurate ways to determine baby gender are:</p>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>NIPT blood test (10+ weeks)</li>
                            <li>Ultrasound (18-20 weeks)</li>
                            <li>Amniocentesis or CVS</li>
                            <li>At birth!</li>
                        </ul>
                        <p>Consult your healthcare provider for accurate gender determination.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Baby Gender Fun Facts:</strong> Gender determined at conception by sperm (X or Y chromosome). Chinese chart = 700+ years old. Ramzi theory = 6-8 weeks ultrasound. Heart rate myth = no scientific basis. Skull theory = shape prediction. NIPT = 99% accurate at 10 weeks. Ultrasound = 95% at 18-20 weeks. Old wives' tales = 50% accurate (same as guessing!). Gender disappointment is normal. Some parents wait until birth. Gender reveal parties popular. Most cultures have gender myths. Only medical tests are reliable. Have fun with predictions but don't take seriously. The joy is in the surprise!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('genderForm');
        const methodSelect = document.getElementById('predictionMethod');

        methodSelect.addEventListener('change', function() {
            updateFormFields();
            predictGender();
        });

        function updateFormFields() {
            const method = methodSelect.value;
            
            // Hide all optional fields first
            document.getElementById('placentaGroup').style.display = 'none';
            document.getElementById('heartRateGroup').style.display = 'none';
            document.getElementById('morningGroup').style.display = 'none';
            document.getElementById('cravingsGroup').style.display = 'none';
            
            // Show relevant fields
            if (method === 'ramzi') {
                document.getElementById('placentaGroup').style.display = 'block';
            } else if (method === 'heartrate') {
                document.getElementById('heartRateGroup').style.display = 'block';
            } else if (method === 'multiple') {
                document.getElementById('placentaGroup').style.display = 'block';
                document.getElementById('heartRateGroup').style.display = 'block';
                document.getElementById('morningGroup').style.display = 'block';
                document.getElementById('cravingsGroup').style.display = 'block';
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            predictGender();
        });

        function predictGender() {
            const method = methodSelect.value;
            const motherAge = parseInt(document.getElementById('motherAge').value) || 28;
            const conceptionMonth = parseInt(document.getElementById('conceptionMonth').value) || 5;
            const placentaSide = document.getElementById('placentaSide').value;
            const heartRate = parseInt(document.getElementById('heartRate').value) || 140;
            const morningSickness = document.getElementById('morningSickness').value;
            const cravings = document.getElementById('cravings').value;

            // Chinese Gender Chart prediction
            const chineseChart = [
                [1,0,1,0,1,0,1,0,1,0,1,0], // Age 18
                [0,1,0,1,0,1,0,1,0,1,0,1], // Age 19
                [1,0,1,0,1,0,1,0,1,0,1,0], // Age 20
                [0,1,0,1,0,1,0,1,0,1,0,1], // Age 21
                [1,0,1,0,1,0,1,0,1,0,1,0], // Age 22
                [0,1,0,1,0,1,0,1,0,1,0,1], // Age 23
                [1,0,1,0,1,0,1,0,1,0,1,0], // Age 24
                [0,1,0,1,0,1,0,1,0,1,0,1], // Age 25
                [1,0,1,0,1,0,1,0,1,0,1,0], // Age 26
                [0,1,0,1,0,1,0,1,0,1,0,1], // Age 27
                [1,0,1,0,1,0,1,0,1,0,1,0], // Age 28
                [0,1,0,1,0,1,0,1,0,1,0,1], // Age 29
                [1,0,1,0,1,0,1,0,1,0,1,0], // Age 30
            ];
            
            const ageIndex = Math.max(0, Math.min(motherAge - 18, 12));
            const monthIndex = conceptionMonth - 1;
            const chineseGender = chineseChart[ageIndex][monthIndex] === 1 ? 'Boy' : 'Girl';

            // Ramzi Theory prediction
            const ramziGender = placentaSide === 'right' ? 'Boy' : placentaSide === 'left' ? 'Girl' : 'Unknown';

            // Heart Rate prediction
            const heartRateGender = heartRate < 140 ? 'Boy' : 'Girl';

            // Morning Sickness prediction
            const sicknessGender = morningSickness === 'severe' ? 'Girl' : 'Boy';

            // Cravings prediction
            const cravingsGender = cravings === 'sweet' ? 'Girl' : 'Boy';

            // Determine final prediction based on method
            let finalGender = '';
            let confidence = 50;
            let boyVotes = 0;
            let girlVotes = 0;

            if (method === 'chinese') {
                finalGender = chineseGender;
                confidence = 50;
            } else if (method === 'ramzi') {
                finalGender = ramziGender;
                confidence = ramziGender === 'Unknown' ? 50 : 70;
            } else if (method === 'heartrate') {
                finalGender = heartRateGender;
                confidence = 50;
            } else {
                // Multiple methods - voting system
                const predictions = [chineseGender, ramziGender, heartRateGender, sicknessGender, cravingsGender];
                predictions.forEach(pred => {
                    if (pred === 'Boy') boyVotes++;
                    else if (pred === 'Girl') girlVotes++;
                });
                
                finalGender = boyVotes > girlVotes ? 'Boy' : 'Girl';
                const totalVotes = boyVotes + girlVotes;
                confidence = Math.round((Math.max(boyVotes, girlVotes) / totalVotes) * 100);
            }

            // Update UI
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 
                          'July', 'August', 'September', 'October', 'November', 'December'];

            const isBoy = finalGender === 'Boy';
            const emoji = isBoy ? '&#128102;' : '&#128103;';
            const color = isBoy ? '#64B5F6' : '#F48FB1';

            const card = document.getElementById('resultCard');
            card.style.background = `linear-gradient(135deg, ${color} 0%, ${isBoy ? '#2196F3' : '#E91E63'} 100%)`;
            card.style.color = 'white';

            document.getElementById('predictedGender').innerHTML = emoji;
            document.getElementById('genderText').textContent = finalGender;
            document.getElementById('genderText').style.color = 'white';

            document.getElementById('chineseResult').textContent = chineseGender;
            document.getElementById('ramziResult').textContent = ramziGender;
            document.getElementById('heartRateResult').textContent = heartRateGender;
            document.getElementById('confidence').textContent = confidence + '%';

            document.getElementById('ageDisplay').textContent = motherAge + ' years';
            document.getElementById('monthDisplay').textContent = months[conceptionMonth - 1];

            if (method === 'ramzi' || method === 'multiple') {
                document.getElementById('placentaDisplayItem').style.display = 'flex';
                document.getElementById('placentaDisplay').textContent = placentaSide.charAt(0).toUpperCase() + placentaSide.slice(1);
            }

            if (method === 'heartrate' || method === 'multiple') {
                document.getElementById('heartRateDisplayItem').style.display = 'flex';
                document.getElementById('heartRateDisplay').textContent = heartRate + ' BPM';
            }

            document.getElementById('chinesePrediction').textContent = chineseGender;
            document.getElementById('chinesePrediction').style.color = chineseGender === 'Boy' ? '#64B5F6' : '#F48FB1';

            if (method === 'ramzi' || method === 'multiple') {
                document.getElementById('ramziItem').style.display = 'flex';
                document.getElementById('ramziPrediction').textContent = ramziGender;
                document.getElementById('ramziPrediction').style.color = ramziGender === 'Boy' ? '#64B5F6' : ramziGender === 'Girl' ? '#F48FB1' : '#666';
            }

            if (method === 'heartrate' || method === 'multiple') {
                document.getElementById('heartRateItem').style.display = 'flex';
                document.getElementById('heartRatePrediction').textContent = heartRateGender;
                document.getElementById('heartRatePrediction').style.color = heartRateGender === 'Boy' ? '#64B5F6' : '#F48FB1';
            }

            if (method === 'multiple') {
                document.getElementById('sicknessItem').style.display = 'flex';
                document.getElementById('sicknessPrediction').textContent = sicknessGender;
                document.getElementById('sicknessPrediction').style.color = sicknessGender === 'Boy' ? '#64B5F6' : '#F48FB1';

                document.getElementById('cravingsItem').style.display = 'flex';
                document.getElementById('cravingsPrediction').textContent = cravingsGender;
                document.getElementById('cravingsPrediction').style.color = cravingsGender === 'Boy' ? '#64B5F6' : '#F48FB1';
            }

            // Analysis
            let analysis = `Based on the ${method === 'multiple' ? 'combined prediction methods' : method === 'chinese' ? 'Chinese Gender Chart' : method === 'ramzi' ? 'Ramzi Theory' : 'heart rate method'}, `;
            analysis += `the prediction is ${finalGender}${emoji}. `;
            
            if (method === 'chinese') {
                analysis += `According to the ancient Chinese calendar, a mother aged ${motherAge} conceiving in ${months[conceptionMonth - 1]} predicts a ${chineseGender}. `;
            } else if (method === 'ramzi') {
                analysis += `The Ramzi theory suggests placenta on the ${placentaSide} side indicates ${ramziGender}. `;
            } else if (method === 'multiple') {
                analysis += `Out of ${boyVotes + girlVotes} prediction methods, ${boyVotes} predict boy and ${girlVotes} predict girl. `;
            }
            
            analysis += `Remember, this is just for fun! Only medical tests like NIPT (10+ weeks) or ultrasound (18-20 weeks) can accurately determine your baby's gender. The most exciting reveal is at birth! &#128118;&#128150;`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            updateFormFields();
            predictGender();
        });
    </script>
</body>
</html>