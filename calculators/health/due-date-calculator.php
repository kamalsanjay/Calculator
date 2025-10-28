<?php
/**
 * Due Date Calculator
 * File: due-date-calculator.php
 * Description: Calculate pregnancy due date and track pregnancy timeline
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Due Date Calculator - Pregnancy Due Date & Timeline Calculator</title>
    <meta name="description" content="Free pregnancy due date calculator. Calculate baby's due date from last period, conception date, or ultrasound. Track pregnancy week by week with trimester milestones.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🤰 Due Date Calculator</h1>
        <p>Calculate pregnancy due date & timeline</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Pregnancy Information</h2>
                <form id="dueDateForm">
                    <div class="form-group">
                        <label for="calculationMethod">Calculate Based On</label>
                        <select id="calculationMethod">
                            <option value="lmp">Last Menstrual Period (LMP)</option>
                            <option value="conception">Conception/Ovulation Date</option>
                            <option value="ultrasound">Ultrasound Dating</option>
                            <option value="ivf">IVF Transfer Date</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Date Information</h3>
                    
                    <div class="form-group" id="lmpGroup">
                        <label for="lmpDate">First Day of Last Period (LMP)</label>
                        <input type="date" id="lmpDate" required>
                        <small>Enter the first day of your last menstrual period</small>
                    </div>
                    
                    <div class="form-group" id="conceptionGroup" style="display: none;">
                        <label for="conceptionDate">Conception/Ovulation Date</label>
                        <input type="date" id="conceptionDate">
                        <small>Estimated date of conception or ovulation</small>
                    </div>
                    
                    <div class="form-group" id="ultrasoundGroup" style="display: none;">
                        <label for="ultrasoundDate">Ultrasound Date</label>
                        <input type="date" id="ultrasoundDate">
                        <small>Date when ultrasound was performed</small>
                    </div>
                    
                    <div class="form-group" id="gestationalAgeGroup" style="display: none;">
                        <label for="gestationalWeeks">Gestational Age at Ultrasound</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="gestationalWeeks" value="12" min="4" max="42" step="1" style="flex: 1;" placeholder="Weeks">
                            <input type="number" id="gestationalDays" value="0" min="0" max="6" step="1" style="flex: 1;" placeholder="Days">
                        </div>
                        <small>Gestational age from ultrasound report</small>
                    </div>
                    
                    <div class="form-group" id="ivfGroup" style="display: none;">
                        <label for="ivfDate">IVF Transfer Date</label>
                        <input type="date" id="ivfDate">
                        <small>Date of embryo transfer</small>
                    </div>
                    
                    <div class="form-group" id="embryoGroup" style="display: none;">
                        <label for="embryoAge">Embryo Age at Transfer</label>
                        <select id="embryoAge">
                            <option value="3">Day 3 Embryo</option>
                            <option value="5" selected>Day 5 Blastocyst</option>
                            <option value="6">Day 6 Blastocyst</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Optional Information</h3>
                    
                    <div class="form-group">
                        <label for="cycleLength">Average Cycle Length (days)</label>
                        <input type="number" id="cycleLength" value="28" min="21" max="35" step="1">
                        <small>Your typical menstrual cycle length (21-35 days)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Due Date</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Due Date Results</h2>
                
                <div class="result-card success">
                    <h3>Estimated Due Date</h3>
                    <div class="amount" id="dueDateResult" style="font-size: 2em;">Oct 8, 2025</div>
                    <div style="margin-top: 10px; font-size: 1em;">Expected delivery date</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Due Date</h4>
                        <div class="value" id="dueDateDisplay">Oct 8</div>
                    </div>
                    <div class="metric-card">
                        <h4>Current Week</h4>
                        <div class="value" id="currentWeek">12w 6d</div>
                    </div>
                    <div class="metric-card">
                        <h4>Trimester</h4>
                        <div class="value" id="trimester">2nd</div>
                    </div>
                    <div class="metric-card">
                        <h4>Days Until Due</h4>
                        <div class="value" id="daysUntilDue">190</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Pregnancy Timeline</h3>
                    <div class="breakdown-item">
                        <span>Last Menstrual Period (LMP)</span>
                        <strong id="lmpDisplay">January 1, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated Conception Date</span>
                        <strong id="conceptionDisplay" style="color: #E91E63;">January 15, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated Due Date</span>
                        <strong id="dueDateCalc" style="color: #4CAF50; font-size: 1.1em;">October 8, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Gestational Age</span>
                        <strong id="gestationalAge" style="color: #667eea;">12 weeks 6 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Days Pregnant</span>
                        <strong id="daysPregnant">90 days</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Trimester Dates</h3>
                    <div class="breakdown-item">
                        <span>1st Trimester (Weeks 1-13)</span>
                        <strong id="firstTrimester">Jan 1 - Mar 26, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>2nd Trimester (Weeks 14-27)</span>
                        <strong id="secondTrimester" style="color: #4CAF50;">Mar 27 - Jul 2, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>3rd Trimester (Weeks 28-40)</span>
                        <strong id="thirdTrimester">Jul 3 - Oct 8, 2025</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Important Milestones</h3>
                    <div class="breakdown-item">
                        <span>Heartbeat Detectable (Week 6)</span>
                        <strong id="heartbeat">February 12, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>First Prenatal Visit (Week 8-10)</span>
                        <strong id="firstVisit">Feb 26 - Mar 12, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>End of 1st Trimester (Week 13)</span>
                        <strong id="endFirst">March 26, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gender Reveal (Week 16-20)</span>
                        <strong id="genderReveal">May 7 - Jun 4, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Anatomy Scan (Week 20)</span>
                        <strong id="anatomyScan">June 4, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Viability (Week 24)</span>
                        <strong id="viability">June 18, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Glucose Test (Week 24-28)</span>
                        <strong id="glucoseTest">Jun 18 - Jul 16, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Full Term (Week 37)</span>
                        <strong id="fullTerm">September 17, 2025</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Delivery Window</h3>
                    <div class="breakdown-item">
                        <span>Early Term (37-38 weeks)</span>
                        <strong>Sep 17 - Oct 1, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Full Term (39-40 weeks)</span>
                        <strong style="color: #4CAF50;">Oct 2 - Oct 15, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Late Term (41 weeks)</span>
                        <strong>Oct 16 - Oct 22, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Post Term (42+ weeks)</span>
                        <strong style="color: #FF9800;">After Oct 22, 2025</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Pregnancy Progress</h3>
                    <div class="breakdown-item">
                        <span>Percentage Complete</span>
                        <strong id="percentComplete" style="color: #667eea; font-size: 1.1em;">32%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Days Until Due Date</span>
                        <strong id="daysRemaining">190 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weeks Until Due Date</span>
                        <strong id="weeksRemaining">27 weeks</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Baby Development This Week</h3>
                    <div id="babyDevelopment" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="developmentText"></p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How Due Date is Calculated</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Naegele's Rule (from LMP):</strong> Add 280 days (40 weeks) to first day of last menstrual period.</p>
                        <p><strong>From Conception:</strong> Add 266 days (38 weeks) to conception/ovulation date.</p>
                        <p><strong>From Ultrasound:</strong> Most accurate in first trimester (± 5-7 days). Measures gestational age.</p>
                        <p><strong>From IVF:</strong> Day 3 transfer: Add 263 days. Day 5 transfer: Add 261 days.</p>
                        <p><strong>Standard Pregnancy:</strong> 40 weeks (280 days) from LMP, 38 weeks from conception.</p>
                        <p><strong>Accuracy:</strong> Only 5% of babies arrive on exact due date. Most come within 2 weeks before or after.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Pregnancy Trimesters Explained</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>1st Trimester (Weeks 1-13):</strong> Organ formation. Highest miscarriage risk. Morning sickness common. First ultrasound typically week 8-10.</p>
                        <p><strong>2nd Trimester (Weeks 14-27):</strong> "Honeymoon phase." Energy returns. Baby movements felt (quickening). Anatomy scan at week 20. Gender determination possible.</p>
                        <p><strong>3rd Trimester (Weeks 28-40):</strong> Rapid growth. Discomfort increases. Prepare for labor. Weekly visits after week 36. Baby drops into pelvis before labor.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Prenatal Care Schedule</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>First Visit (Week 8-10):</strong> Confirm pregnancy, estimate due date, medical history, initial labs</p>
                        <p><strong>Weeks 8-28:</strong> Monthly visits (every 4 weeks)</p>
                        <p><strong>Weeks 28-36:</strong> Bi-weekly visits (every 2 weeks)</p>
                        <p><strong>Weeks 36-40:</strong> Weekly visits until delivery</p>
                        <p><strong>NT Scan (Week 11-14):</strong> Nuchal translucency screening</p>
                        <p><strong>Anatomy Scan (Week 18-22):</strong> Detailed ultrasound</p>
                        <p><strong>Glucose Test (Week 24-28):</strong> Gestational diabetes screening</p>
                        <p><strong>Group B Strep (Week 36-37):</strong> GBS test</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Signs of Labor</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Early Signs (Days-Weeks Before):</strong></p>
                        <p>• Lightening (baby drops)</p>
                        <p>• Cervical changes</p>
                        <p>• Braxton Hicks contractions increase</p>
                        <p>• Weight loss (1-3 lbs)</p>
                        <p>• Nesting instinct</p>
                        <p><strong>Active Labor Signs:</strong></p>
                        <p>• Regular contractions (5-10 min apart)</p>
                        <p>• Water breaks (clear or pink fluid)</p>
                        <p>• Bloody show (mucus plug)</p>
                        <p>• Severe back pain</p>
                        <p>• Diarrhea</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>When to Call Doctor</h3>
                    <div style="padding: 15px; background: #ffebee; border-radius: 5px; line-height: 1.8; border-left: 4px solid #f44336;">
                        <p><strong>⚠️ Call Doctor Immediately If:</strong></p>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Vaginal bleeding or fluid leakage</li>
                            <li>Severe abdominal pain or cramping</li>
                            <li>Fever over 100.4°F (38°C)</li>
                            <li>Sudden severe headache</li>
                            <li>Vision changes or spots</li>
                            <li>Sudden severe swelling (face, hands, feet)</li>
                            <li>Decreased fetal movement</li>
                            <li>Contractions before 37 weeks</li>
                            <li>Signs of preeclampsia</li>
                        </ul>
                        <p><strong>Go to Labor & Delivery If:</strong></p>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Contractions 5 minutes apart for 1 hour</li>
                            <li>Water breaks (any amount or color)</li>
                            <li>Heavy bleeding (like period or more)</li>
                            <li>Severe pain that won't go away</li>
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
                    <strong>Due Date Tips:</strong> Due date = LMP + 280 days. Only 5% deliver on exact date. Full term = 37-42 weeks. Best delivery = 39-40 weeks. Conception = LMP + 14 days. Ultrasound most accurate before 13 weeks. 1st trimester = weeks 1-13. 2nd trimester = weeks 14-27. 3rd trimester = weeks 28-40. Prenatal visits: monthly until week 28, bi-weekly until 36, then weekly. Anatomy scan = week 20. Glucose test = week 24-28. GBS test = week 36-37. Labor signs: regular contractions, water breaks, bloody show. Count fetal kicks after week 28. Call doctor if decreased movement. Only 4% go past 42 weeks!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('dueDateForm');
        const methodSelect = document.getElementById('calculationMethod');

        methodSelect.addEventListener('change', function() {
            toggleMethodFields();
            calculateDueDate();
        });

        function toggleMethodFields() {
            const method = methodSelect.value;
            
            document.getElementById('lmpGroup').style.display = method === 'lmp' ? 'block' : 'none';
            document.getElementById('conceptionGroup').style.display = method === 'conception' ? 'block' : 'none';
            document.getElementById('ultrasoundGroup').style.display = method === 'ultrasound' ? 'block' : 'none';
            document.getElementById('gestationalAgeGroup').style.display = method === 'ultrasound' ? 'block' : 'none';
            document.getElementById('ivfGroup').style.display = method === 'ivf' ? 'block' : 'none';
            document.getElementById('embryoGroup').style.display = method === 'ivf' ? 'block' : 'none';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateDueDate();
        });

        function getBabyDevelopment(weeks) {
            const developments = {
                4: "Your baby is the size of a poppy seed. The embryo is just forming.",
                5: "Your baby is the size of an apple seed. Neural tube is forming.",
                6: "Your baby is the size of a lentil. Heart begins to beat!",
                7: "Your baby is the size of a blueberry. Arms and legs are developing.",
                8: "Your baby is the size of a raspberry. All major organs are forming.",
                9: "Your baby is the size of a cherry. Baby is officially a fetus now!",
                10: "Your baby is the size of a strawberry. Vital organs are functioning.",
                11: "Your baby is the size of a lime. Baby can hiccup!",
                12: "Your baby is the size of a plum. Reflexes are developing.",
                13: "Your baby is the size of a lemon. Vocal cords are forming.",
                14: "Your baby is the size of a peach. Face muscles are developing.",
                15: "Your baby is the size of an apple. Can sense light!",
                16: "Your baby is the size of an avocado. You may feel first kicks!",
                17: "Your baby is the size of a pear. Skeleton is hardening.",
                18: "Your baby is the size of a sweet potato. Can yawn and hiccup!",
                19: "Your baby is the size of a mango. Sensory development is huge.",
                20: "Your baby is the size of a banana. Halfway there! Anatomy scan time.",
                24: "Your baby is the size of a cantaloupe. Viable! Can hear sounds.",
                28: "Your baby is the size of an eggplant. Eyes can open.",
                32: "Your baby is the size of a squash. Practicing breathing movements.",
                36: "Your baby is the size of a honeydew melon. Almost ready!",
                37: "Your baby is full term! Could arrive any day now.",
                38: "Baby weighs about 6.8 lbs. Getting ready for birth.",
                39: "Optimal delivery time. Baby is fully developed.",
                40: "Due date! Baby is ready to meet you."
            };
            
            const week = Math.floor(weeks);
            return developments[week] || `Your baby continues to grow and prepare for birth.`;
        }

        function calculateDueDate() {
            const method = methodSelect.value;
            const cycleLength = parseInt(document.getElementById('cycleLength').value) || 28;
            const today = new Date();
            
            let lmpDate, dueDate, conceptionDate;
            
            if (method === 'lmp') {
                const lmpInput = document.getElementById('lmpDate').value;
                if (!lmpInput) {
                    lmpDate = new Date(today);
                    lmpDate.setDate(lmpDate.getDate() - 90);
                    document.getElementById('lmpDate').value = lmpDate.toISOString().split('T')[0];
                } else {
                    lmpDate = new Date(lmpInput);
                }
                
                dueDate = new Date(lmpDate);
                dueDate.setDate(dueDate.getDate() + 280);
                
                const ovulationDay = cycleLength - 14;
                conceptionDate = new Date(lmpDate);
                conceptionDate.setDate(conceptionDate.getDate() + ovulationDay);
                
            } else if (method === 'conception') {
                const concepInput = document.getElementById('conceptionDate').value;
                if (!concepInput) {
                    conceptionDate = new Date(today);
                    conceptionDate.setDate(conceptionDate.getDate() - 76);
                    document.getElementById('conceptionDate').value = conceptionDate.toISOString().split('T')[0];
                } else {
                    conceptionDate = new Date(concepInput);
                }
                
                dueDate = new Date(conceptionDate);
                dueDate.setDate(dueDate.getDate() + 266);
                
                lmpDate = new Date(conceptionDate);
                lmpDate.setDate(lmpDate.getDate() - 14);
                
            } else if (method === 'ultrasound') {
                const ultrasoundInput = document.getElementById('ultrasoundDate').value;
                const weeks = parseInt(document.getElementById('gestationalWeeks').value) || 12;
                const days = parseInt(document.getElementById('gestationalDays').value) || 0;
                
                if (!ultrasoundInput) {
                    const defaultDate = new Date(today);
                    defaultDate.setDate(defaultDate.getDate() - 7);
                    document.getElementById('ultrasoundDate').value = defaultDate.toISOString().split('T')[0];
                }
                
                const ultrasoundDate = new Date(document.getElementById('ultrasoundDate').value);
                const totalDays = (weeks * 7) + days;
                
                lmpDate = new Date(ultrasoundDate);
                lmpDate.setDate(lmpDate.getDate() - totalDays);
                
                dueDate = new Date(lmpDate);
                dueDate.setDate(dueDate.getDate() + 280);
                
                conceptionDate = new Date(lmpDate);
                conceptionDate.setDate(conceptionDate.getDate() + 14);
                
            } else if (method === 'ivf') {
                const ivfInput = document.getElementById('ivfDate').value;
                const embryoAge = parseInt(document.getElementById('embryoAge').value) || 5;
                
                if (!ivfInput) {
                    const defaultDate = new Date(today);
                    defaultDate.setDate(defaultDate.getDate() - 80);
                    document.getElementById('ivfDate').value = defaultDate.toISOString().split('T')[0];
                }
                
                const ivfDate = new Date(document.getElementById('ivfDate').value);
                
                if (embryoAge === 3) {
                    dueDate = new Date(ivfDate);
                    dueDate.setDate(dueDate.getDate() + 263);
                    conceptionDate = new Date(ivfDate);
                    conceptionDate.setDate(conceptionDate.getDate() - 3);
                } else if (embryoAge === 5) {
                    dueDate = new Date(ivfDate);
                    dueDate.setDate(dueDate.getDate() + 261);
                    conceptionDate = new Date(ivfDate);
                    conceptionDate.setDate(conceptionDate.getDate() - 5);
                } else {
                    dueDate = new Date(ivfDate);
                    dueDate.setDate(dueDate.getDate() + 260);
                    conceptionDate = new Date(ivfDate);
                    conceptionDate.setDate(conceptionDate.getDate() - 6);
                }
                
                lmpDate = new Date(conceptionDate);
                lmpDate.setDate(lmpDate.getDate() - 14);
            }

            // Calculate current pregnancy status
            const daysSinceLMP = Math.floor((today - lmpDate) / (1000 * 60 * 60 * 24));
            const weeksSinceLMP = Math.floor(daysSinceLMP / 7);
            const daysMod = daysSinceLMP % 7;
            
            const daysUntilDue = Math.floor((dueDate - today) / (1000 * 60 * 60 * 24));
            const weeksUntilDue = Math.floor(daysUntilDue / 7);
            const progressPercent = ((daysSinceLMP / 280) * 100).toFixed(1);

            // Determine trimester
            let trimester = '';
            if (weeksSinceLMP < 13) {
                trimester = '1st';
            } else if (weeksSinceLMP < 28) {
                trimester = '2nd';
            } else {
                trimester = '3rd';
            }

            // Calculate milestones
            const firstTrimesterEnd = new Date(lmpDate);
            firstTrimesterEnd.setDate(firstTrimesterEnd.getDate() + (13 * 7));
            
            const secondTrimesterStart = new Date(lmpDate);
            secondTrimesterStart.setDate(secondTrimesterStart.getDate() + (14 * 7));
            
            const secondTrimesterEnd = new Date(lmpDate);
            secondTrimesterEnd.setDate(secondTrimesterEnd.getDate() + (27 * 7));
            
            const thirdTrimesterStart = new Date(lmpDate);
            thirdTrimesterStart.setDate(thirdTrimesterStart.getDate() + (28 * 7));
            
            const heartbeat = new Date(lmpDate);
            heartbeat.setDate(heartbeat.getDate() + (6 * 7));
            
            const firstVisitStart = new Date(lmpDate);
            firstVisitStart.setDate(firstVisitStart.getDate() + (8 * 7));
            
            const firstVisitEnd = new Date(lmpDate);
            firstVisitEnd.setDate(firstVisitEnd.getDate() + (10 * 7));
            
            const genderRevealStart = new Date(lmpDate);
            genderRevealStart.setDate(genderRevealStart.getDate() + (16 * 7));
            
            const genderRevealEnd = new Date(lmpDate);
            genderRevealEnd.setDate(genderRevealEnd.getDate() + (20 * 7));
            
            const anatomyScan = new Date(lmpDate);
            anatomyScan.setDate(anatomyScan.getDate() + (20 * 7));
            
            const viability = new Date(lmpDate);
            viability.setDate(viability.getDate() + (24 * 7));
            
            const glucoseTestStart = new Date(lmpDate);
            glucoseTestStart.setDate(glucoseTestStart.getDate() + (24 * 7));
            
            const glucoseTestEnd = new Date(lmpDate);
            glucoseTestEnd.setDate(glucoseTestEnd.getDate() + (28 * 7));
            
            const fullTerm = new Date(lmpDate);
            fullTerm.setDate(fullTerm.getDate() + (37 * 7));

            // Format dates
            const formatDate = (date) => {
                return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            };
            
            const formatDateShort = (date) => {
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            };

            // Baby development
            const developmentText = getBabyDevelopment(weeksSinceLMP);

            // Analysis
            let analysis = `Based on your ${method === 'lmp' ? 'last menstrual period' : method === 'conception' ? 'conception date' : method === 'ultrasound' ? 'ultrasound' : 'IVF transfer date'}, `;
            analysis += `your estimated due date is ${formatDate(dueDate)}. `;
            analysis += `You are currently ${weeksSinceLMP} weeks and ${daysMod} days pregnant (${trimester} trimester). `;
            analysis += `This means you have ${daysUntilDue} days (approximately ${weeksUntilDue} weeks) until your due date. `;
            analysis += `Your pregnancy is ${progressPercent}% complete. `;
            analysis += `Remember that only about 5% of babies arrive on their exact due date - most are born within 2 weeks before or after. `;
            analysis += `Full term is considered 37-42 weeks, with 39-40 weeks being the optimal time for delivery. `;
            analysis += `Continue your prenatal care schedule and monitor your baby's movements. `;
            analysis += `${developmentText}`;

            // Update UI
            document.getElementById('dueDateResult').textContent = formatDateShort(dueDate) + ', ' + dueDate.getFullYear();
            document.getElementById('dueDateDisplay').textContent = formatDateShort(dueDate);
            document.getElementById('currentWeek').textContent = `${weeksSinceLMP}w ${daysMod}d`;
            document.getElementById('trimester').textContent = trimester;
            document.getElementById('daysUntilDue').textContent = daysUntilDue;

            document.getElementById('lmpDisplay').textContent = formatDate(lmpDate);
            document.getElementById('conceptionDisplay').textContent = formatDate(conceptionDate);
            document.getElementById('dueDateCalc').textContent = formatDate(dueDate);
            document.getElementById('gestationalAge').textContent = `${weeksSinceLMP} weeks ${daysMod} days`;
            document.getElementById('daysPregnant').textContent = `${daysSinceLMP} days`;

            document.getElementById('firstTrimester').textContent = `${formatDateShort(lmpDate)} - ${formatDateShort(firstTrimesterEnd)}, ${firstTrimesterEnd.getFullYear()}`;
            document.getElementById('secondTrimester').textContent = `${formatDateShort(secondTrimesterStart)} - ${formatDateShort(secondTrimesterEnd)}, ${secondTrimesterEnd.getFullYear()}`;
            document.getElementById('thirdTrimester').textContent = `${formatDateShort(thirdTrimesterStart)} - ${formatDateShort(dueDate)}, ${dueDate.getFullYear()}`;

            document.getElementById('heartbeat').textContent = formatDate(heartbeat);
            document.getElementById('firstVisit').textContent = `${formatDateShort(firstVisitStart)} - ${formatDateShort(firstVisitEnd)}, ${firstVisitStart.getFullYear()}`;
            document.getElementById('endFirst').textContent = formatDate(firstTrimesterEnd);
            document.getElementById('genderReveal').textContent = `${formatDateShort(genderRevealStart)} - ${formatDateShort(genderRevealEnd)}, ${genderRevealStart.getFullYear()}`;
            document.getElementById('anatomyScan').textContent = formatDate(anatomyScan);
            document.getElementById('viability').textContent = formatDate(viability);
            document.getElementById('glucoseTest').textContent = `${formatDateShort(glucoseTestStart)} - ${formatDateShort(glucoseTestEnd)}, ${glucoseTestStart.getFullYear()}`;
            document.getElementById('fullTerm').textContent = formatDate(fullTerm);

            document.getElementById('percentComplete').textContent = `${progressPercent}%`;
            document.getElementById('daysRemaining').textContent = `${daysUntilDue} days`;
            document.getElementById('weeksRemaining').textContent = `${weeksUntilDue} weeks`;

            document.getElementById('developmentText').textContent = developmentText;
            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleMethodFields();
            calculateDueDate();
        });
    </script>
</body>
</html>