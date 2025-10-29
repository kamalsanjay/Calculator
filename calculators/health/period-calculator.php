<?php
/**
 * Period Calculator
 * File: period-calculator.php
 * Description: Track menstrual cycle, predict next period, and monitor cycle health
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Period Calculator - Menstrual Cycle Calendar & Period Tracker</title>
    <meta name="description" content="Free period calculator. Track your menstrual cycle, predict next period dates, and monitor period health. Plan ahead with accurate predictions.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>📅 Period Calculator</h1>
        <p>Track & predict your menstrual cycle</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Cycle Information</h2>
                <form id="periodForm">
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Last Period</h3>
                    
                    <div class="form-group">
                        <label for="lmpDate">First Day of Last Period</label>
                        <input type="date" id="lmpDate" required>
                        <small>Start date of your most recent period</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Cycle Details</h3>
                    
                    <div class="form-group">
                        <label for="cycleLength">Average Cycle Length (days)</label>
                        <input type="number" id="cycleLength" value="28" min="21" max="45" step="1" required>
                        <small>Days from first day of period to first day of next period</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="periodLength">Period Duration (days)</label>
                        <input type="number" id="periodLength" value="5" min="2" max="10" step="1" required>
                        <small>Number of days you bleed each cycle</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Period</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Period Tracking Results</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Next Period Expected</h3>
                    <div class="amount" id="periodResult">Nov 26, 2025</div>
                    <div style="margin-top: 10px; font-size: 1em;" id="daysUntil">28 days from now</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Next Period</h4>
                        <div class="value" id="nextPeriodDisplay">Nov 26</div>
                    </div>
                    <div class="metric-card">
                        <h4>Days Until</h4>
                        <div class="value" id="daysUntilDisplay">28</div>
                    </div>
                    <div class="metric-card">
                        <h4>Period Ends</h4>
                        <div class="value" id="periodEndsDisplay">Nov 30</div>
                    </div>
                    <div class="metric-card">
                        <h4>Cycle Length</h4>
                        <div class="value" id="cycleLengthDisplay">28</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Cycle Information</h3>
                    <div class="breakdown-item">
                        <span>Last Period Started</span>
                        <strong id="lmpDisplay">Oct 29, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Last Period Ended</span>
                        <strong id="lmpEndDisplay">Nov 2, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cycle Length</span>
                        <strong id="cycleLengthInfo">28 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Period Duration</span>
                        <strong id="periodLengthInfo">5 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cycle Type</span>
                        <strong id="cycleType" style="color: #4CAF50;">Regular (Normal)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Next Period Details</h3>
                    <div class="breakdown-item">
                        <span>Next Period Starts</span>
                        <strong id="nextPeriodDate" style="color: #E91E63; font-size: 1.1em;">Nov 26, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Next Period Ends</span>
                        <strong id="nextPeriodEnd">Nov 30, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Days Until Period</span>
                        <strong id="daysRemaining" style="color: #667eea;">28 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Cycle Day</span>
                        <strong id="currentDay">Day 1 of 28</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cycle Phase</span>
                        <strong id="cyclePhase" style="color: #f44336;">Menstrual Phase</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Next 6 Periods Calendar</h3>
                    <div class="breakdown-item">
                        <span>Period 1</span>
                        <strong id="period1" style="color: #E91E63;">Nov 26 - Nov 30, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Period 2</span>
                        <strong id="period2">Dec 24 - Dec 28, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Period 3</span>
                        <strong id="period3">Jan 21 - Jan 25, 2026</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Period 4</span>
                        <strong id="period4">Feb 18 - Feb 22, 2026</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Period 5</span>
                        <strong id="period5">Mar 18 - Mar 22, 2026</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Period 6</span>
                        <strong id="period6">Apr 15 - Apr 19, 2026</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Your Cycle</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Normal Cycle Length:</strong> 21-35 days (28 average). Varies between women. Consistency more important than exact length.</p>
                        <p><strong>Normal Period:</strong> 3-7 days bleeding (5 average). 2-3 tablespoons blood loss total. Heavier first 2 days.</p>
                        <p><strong>Menstrual Phase (Days 1-5):</strong> Period bleeding. Uterine lining sheds. Hormones at lowest. May experience cramps, fatigue.</p>
                        <p><strong>Follicular Phase (Days 1-14):</strong> After period. Estrogen rises. Uterine lining rebuilds. Egg follicles develop. Energy increases.</p>
                        <p><strong>Ovulation (Day 14):</strong> Egg released from ovary. Most fertile time. May have mild cramps, increased libido.</p>
                        <p><strong>Luteal Phase (Days 15-28):</strong> After ovulation. Progesterone rises. PMS symptoms possible. Prepares for period or pregnancy.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Cycle Regularity</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Regular Cycle:</strong> Varies by ≤7 days month-to-month. Predictable. Healthy sign. Easy to track.</p>
                        <p><strong>Irregular Cycle:</strong> Varies by &gt;7 days. Unpredictable. May indicate hormonal imbalance or stress.</p>
                        <p><strong>Short Cycle (&lt;21 days):</strong> Polymenorrhea. May indicate hormonal issues. See doctor if consistent.</p>
                        <p><strong>Long Cycle (&gt;35 days):</strong> Oligomenorrhea. Could be PCOS, stress, or perimenopause. Consult doctor.</p>
                        <p><strong>Missed Periods:</strong> Amenorrhea. Pregnancy, stress, excessive exercise, low body weight, or medical condition.</p>
                        <p><strong>Factors Affecting Regularity:</strong> Stress, weight changes, exercise, diet, medications, hormonal birth control, PCOS, thyroid issues.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Period Symptoms & Management</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Common Symptoms:</strong></p>
                        <p>• Cramps (dysmenorrhea) - uterine muscle contractions</p>
                        <p>• Bloating, water retention</p>
                        <p>• Breast tenderness</p>
                        <p>• Mood changes, irritability</p>
                        <p>• Fatigue, low energy</p>
                        <p>• Headaches</p>
                        <p>• Lower back pain</p>
                        <p>• Acne breakouts</p>
                        <p><strong>Symptom Relief:</strong></p>
                        <p>• Heat therapy (heating pad, hot bath) for cramps</p>
                        <p>• Ibuprofen or naproxen for pain (start before period)</p>
                        <p>• Light exercise (walking, yoga) releases endorphins</p>
                        <p>• Stay hydrated - reduces bloating</p>
                        <p>• Limit caffeine, salt, sugar</p>
                        <p>• Magnesium supplements (400mg) reduce cramps</p>
                        <p>• Adequate sleep (7-9 hours)</p>
                        <p>• Stress management (meditation, breathing)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>PMS (Premenstrual Syndrome)</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>What is PMS?</strong> Physical and emotional symptoms 1-2 weeks before period. Affects 75% of women. Caused by hormone fluctuations.</p>
                        <p><strong>Physical Symptoms:</strong> Bloating, breast tenderness, headaches, fatigue, constipation, acne, food cravings.</p>
                        <p><strong>Emotional Symptoms:</strong> Mood swings, irritability, anxiety, depression, crying spells, difficulty concentrating.</p>
                        <p><strong>PMDD (Severe PMS):</strong> 3-8% of women. Severe mood symptoms interfere with life. May need medication.</p>
                        <p><strong>Managing PMS:</strong></p>
                        <p>• Regular exercise (30 min most days) - reduces symptoms by 50%</p>
                        <p>• Balanced diet - complex carbs, lean protein, fruits, vegetables</p>
                        <p>• Limit salt, caffeine, alcohol, sugar</p>
                        <p>• Calcium (1200mg) and Vitamin D supplements</p>
                        <p>• Adequate sleep, stress management</p>
                        <p>• Birth control pills (if severe) - stabilizes hormones</p>
                        <p>• Antidepressants (SSRIs) for PMDD</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>When to See a Doctor</h3>
                    <div style="padding: 15px; background: #fff3e0; border-radius: 5px; line-height: 1.8; border-left: 4px solid #FF9800;">
                        <p><strong>⚠️ Consult Healthcare Provider If:</strong></p>
                        <p>• Periods suddenly stop (not pregnant) - amenorrhea</p>
                        <p>• Bleeding &gt;7 days or very heavy (soak pad/hour) - menorrhagia</p>
                        <p>• Cycles &lt;21 days or &gt;35 days consistently</p>
                        <p>• Severe pain interfering with daily activities</p>
                        <p>• Bleeding between periods - spotting</p>
                        <p>• Periods after menopause</p>
                        <p>• Severe PMS/PMDD affecting quality of life</p>
                        <p>• Symptoms of anemia: extreme fatigue, dizziness, pale skin</p>
                        <p>• Large blood clots (bigger than quarter)</p>
                        <p>• Sudden changes in cycle pattern</p>
                        <p>• Trying to conceive for 6-12 months without success</p>
                        <p><strong>Possible Conditions:</strong> PCOS, endometriosis, fibroids, thyroid disorders, hormonal imbalances, polyps, infections.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Period Tracking Benefits</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Why Track Your Period?</strong></p>
                        <p>• Predict when period will start - plan events, trips, activities</p>
                        <p>• Identify patterns and cycle regularity</p>
                        <p>• Detect changes that may indicate health issues</p>
                        <p>• Plan or avoid pregnancy - know fertile window</p>
                        <p>• Manage PMS - anticipate and prepare for symptoms</p>
                        <p>• Better communicate with doctor about concerns</p>
                        <p>• Track medications, symptoms, moods</p>
                        <p><strong>What to Track:</strong></p>
                        <p>• Start and end date of period</p>
                        <p>• Flow heaviness (light, moderate, heavy)</p>
                        <p>• Symptoms (cramps, headaches, mood, etc.)</p>
                        <p>• Spotting between periods</p>
                        <p>• Sexual activity (if tracking fertility)</p>
                        <p>• Medications taken</p>
                        <p><strong>Tracking Methods:</strong> Apps (Flo, Clue, Period Tracker), calendar, journal, fertility monitors.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Period Tips:</strong> Normal cycle = 21-35 days (28 average). Period = 3-7 days (5 average). Track 3+ months for pattern. Irregular = varies &gt;7 days. Stress, weight changes, exercise affect cycles. Cramps normal - heat + ibuprofen help. PMS affects 75% women. Stay hydrated, reduce salt/caffeine. Light exercise reduces symptoms. Magnesium helps cramps. See doctor if: very heavy bleeding, severe pain, cycles &lt;21 or &gt;35 days, missed 3+ periods. PCOS, endometriosis, thyroid issues affect periods. Birth control regulates cycles. Track: start date, flow, symptoms. Apps: Flo, Clue. Consistent tracking = better predictions. Plan ahead for trips/events!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('periodForm');
        
        // Set default date to today
        document.getElementById('lmpDate').valueAsDate = new Date();

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculatePeriod();
        });

        function calculatePeriod() {
            const lmpDate = new Date(document.getElementById('lmpDate').value);
            const cycleLength = parseInt(document.getElementById('cycleLength').value) || 28;
            const periodLength = parseInt(document.getElementById('periodLength').value) || 5;

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            // Calculate when last period ended
            const lmpEndDate = new Date(lmpDate);
            lmpEndDate.setDate(lmpDate.getDate() + periodLength - 1);

            // Calculate next period
            const nextPeriod = new Date(lmpDate);
            nextPeriod.setDate(lmpDate.getDate() + cycleLength);

            // Calculate when next period ends
            const nextPeriodEnd = new Date(nextPeriod);
            nextPeriodEnd.setDate(nextPeriod.getDate() + periodLength - 1);

            // Days until next period
            const daysUntil = Math.ceil((nextPeriod - today) / (1000 * 60 * 60 * 24));

            // Current cycle day
            const daysSinceLMP = Math.ceil((today - lmpDate) / (1000 * 60 * 60 * 24)) + 1;
            const currentCycleDay = daysSinceLMP > cycleLength ? 1 : daysSinceLMP;

            // Determine cycle phase
            let cyclePhase = '';
            let phaseColor = '';
            if (currentCycleDay <= periodLength) {
                cyclePhase = 'Menstrual Phase (Period)';
                phaseColor = '#f44336';
            } else if (currentCycleDay <= cycleLength / 2) {
                cyclePhase = 'Follicular Phase';
                phaseColor = '#FF9800';
            } else if (currentCycleDay >= (cycleLength / 2) - 1 && currentCycleDay <= (cycleLength / 2) + 1) {
                cyclePhase = 'Ovulation Phase';
                phaseColor = '#4CAF50';
            } else {
                cyclePhase = 'Luteal Phase';
                phaseColor = '#667eea';
            }

            // Determine cycle type
            let cycleType = '';
            let cycleColor = '';
            if (cycleLength < 21) {
                cycleType = 'Short Cycle (See doctor if consistent)';
                cycleColor = '#FF9800';
            } else if (cycleLength > 35) {
                cycleType = 'Long Cycle (May be irregular)';
                cycleColor = '#FF9800';
            } else {
                cycleType = 'Regular (Normal)';
                cycleColor = '#4CAF50';
            }

            // Calculate next 6 periods
            const periods = [];
            for (let i = 0; i < 6; i++) {
                const periodStart = new Date(nextPeriod);
                periodStart.setDate(nextPeriod.getDate() + (cycleLength * i));
                
                const periodEnd = new Date(periodStart);
                periodEnd.setDate(periodStart.getDate() + periodLength - 1);
                
                periods.push({ start: periodStart, end: periodEnd });
            }

            // Format dates
            const formatDate = (date) => {
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            };

            const formatDateShort = (date) => {
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            };

            // Determine result card color
            const card = document.getElementById('resultCard');
            if (daysUntil <= 3) {
                card.className = 'result-card warning';
            } else if (daysUntil <= 7) {
                card.className = 'result-card info';
            } else {
                card.className = 'result-card success';
            }

            // Analysis
            let analysis = `Based on your last period starting ${formatDate(lmpDate)} and a ${cycleLength}-day cycle, `;
            analysis += `your next period is expected to start on ${formatDate(nextPeriod)}, which is ${daysUntil} days from today. `;
            
            analysis += `Your period typically lasts ${periodLength} days, so it should end around ${formatDate(nextPeriodEnd)}. `;
            
            analysis += `You are currently on day ${currentCycleDay} of your ${cycleLength}-day cycle, in the ${cyclePhase.toLowerCase()}. `;
            
            if (cycleLength >= 21 && cycleLength <= 35) {
                analysis += `Your cycle length of ${cycleLength} days is within the normal range (21-35 days), indicating a regular menstrual cycle. `;
            } else if (cycleLength < 21) {
                analysis += `Your cycle length of ${cycleLength} days is shorter than average. If this is consistent, consider consulting your doctor to rule out hormonal imbalances. `;
            } else {
                analysis += `Your cycle length of ${cycleLength} days is longer than average. This could be normal for you, but if irregular or new, consult your doctor. `;
            }
            
            if (periodLength >= 3 && periodLength <= 7) {
                analysis += `Your period duration of ${periodLength} days is normal. `;
            } else if (periodLength < 3) {
                analysis += `Your period duration of ${periodLength} days is shorter than typical. If accompanied by light flow, mention to your doctor. `;
            } else {
                analysis += `Your period duration of ${periodLength} days is longer than typical. If flow is heavy, consult your doctor to rule out menorrhagia. `;
            }
            
            analysis += `Track your cycle for at least 3 months to identify patterns and regularity. `;
            analysis += `Use this information to plan events, manage PMS symptoms, and monitor your reproductive health.`;

            // Update UI
            document.getElementById('periodResult').textContent = formatDate(nextPeriod);
            document.getElementById('daysUntil').textContent = `${daysUntil} days from now`;
            document.getElementById('nextPeriodDisplay').textContent = formatDateShort(nextPeriod);
            document.getElementById('daysUntilDisplay').textContent = daysUntil;
            document.getElementById('periodEndsDisplay').textContent = formatDateShort(nextPeriodEnd);
            document.getElementById('cycleLengthDisplay').textContent = cycleLength;

            document.getElementById('lmpDisplay').textContent = formatDate(lmpDate);
            document.getElementById('lmpEndDisplay').textContent = formatDate(lmpEndDate);
            document.getElementById('cycleLengthInfo').textContent = `${cycleLength} days`;
            document.getElementById('periodLengthInfo').textContent = `${periodLength} days`;
            document.getElementById('cycleType').textContent = cycleType;
            document.getElementById('cycleType').style.color = cycleColor;

            document.getElementById('nextPeriodDate').textContent = formatDate(nextPeriod);
            document.getElementById('nextPeriodEnd').textContent = formatDate(nextPeriodEnd);
            document.getElementById('daysRemaining').textContent = `${daysUntil} days`;
            document.getElementById('currentDay').textContent = `Day ${currentCycleDay} of ${cycleLength}`;
            document.getElementById('cyclePhase').textContent = cyclePhase;
            document.getElementById('cyclePhase').style.color = phaseColor;

            document.getElementById('period1').textContent = `${formatDateShort(periods[0].start)} - ${formatDateShort(periods[0].end)}, ${periods[0].start.getFullYear()}`;
            document.getElementById('period2').textContent = `${formatDateShort(periods[1].start)} - ${formatDateShort(periods[1].end)}, ${periods[1].start.getFullYear()}`;
            document.getElementById('period3').textContent = `${formatDateShort(periods[2].start)} - ${formatDateShort(periods[2].end)}, ${periods[2].start.getFullYear()}`;
            document.getElementById('period4').textContent = `${formatDateShort(periods[3].start)} - ${formatDateShort(periods[3].end)}, ${periods[3].start.getFullYear()}`;
            document.getElementById('period5').textContent = `${formatDateShort(periods[4].start)} - ${formatDateShort(periods[4].end)}, ${periods[4].start.getFullYear()}`;
            document.getElementById('period6').textContent = `${formatDateShort(periods[5].start)} - ${formatDateShort(periods[5].end)}, ${periods[5].start.getFullYear()}`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            calculatePeriod();
        });
    </script>
</body>
</html>