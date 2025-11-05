<?php
/**
 * Pregnancy Calculator
 * File: pregnancy-calculator.php
 * Description: Calculate due date, pregnancy week, trimester, and baby development milestones
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregnancy Calculator - Due Date Calculator & Pregnancy Week Calculator</title>
    <meta name="description" content="Free pregnancy calculator. Calculate due date, find out how many weeks pregnant, track trimesters, and learn about baby development milestones.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>👶 Pregnancy Calculator</h1>
        <p>Calculate due date & pregnancy progress</p>
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
                <h2>Pregnancy Information</h2>
                <form id="pregnancyForm">
                    <div class="form-group">
                        <label for="calculationMethod">Calculation Method</label>
                        <select id="calculationMethod">
                            <option value="lmp">Last Menstrual Period (LMP)</option>
                            <option value="conception">Conception/Ovulation Date</option>
                            <option value="duedate">Known Due Date</option>
                            <option value="ultrasound">Ultrasound Date</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Date Information</h3>
                    
                    <div class="form-group" id="lmpGroup">
                        <label for="lmpDate">First Day of Last Period (LMP)</label>
                        <input type="date" id="lmpDate" required>
                        <small>First day of your last menstrual period</small>
                    </div>
                    
                    <div class="form-group" id="conceptionGroup" style="display: none;">
                        <label for="conceptionDate">Conception/Ovulation Date</label>
                        <input type="date" id="conceptionDate">
                        <small>Date of conception or ovulation</small>
                    </div>
                    
                    <div class="form-group" id="duedateGroup" style="display: none;">
                        <label for="duedateInput">Known Due Date</label>
                        <input type="date" id="duedateInput">
                        <small>Due date provided by healthcare provider</small>
                    </div>
                    
                    <div class="form-group" id="ultrasoundGroup" style="display: none;">
                        <label for="ultrasoundDate">Ultrasound Date</label>
                        <input type="date" id="ultrasoundDate">
                        <small>Date of ultrasound scan</small>
                    </div>
                    
                    <div class="form-group" id="ultrasoundWeeksGroup" style="display: none;">
                        <label>Gestational Age at Ultrasound</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="ultrasoundWeeks" value="12" min="4" max="42" step="1" style="flex: 1;" placeholder="Weeks">
                            <input type="number" id="ultrasoundDays" value="0" min="0" max="6" step="1" style="flex: 1;" placeholder="Days">
                        </div>
                        <small>Gestational age shown on ultrasound (weeks + days)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Pregnancy</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Pregnancy Results</h2>
                
                <div class="result-card success">
                    <h3>Due Date</h3>
                    <div class="amount" id="dueDateResult">Aug 5, 2026</div>
                    <div style="margin-top: 10px; font-size: 1em;" id="weeksPregnant">You are 0 weeks pregnant</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Due Date</h4>
                        <div class="value" id="dueDateDisplay">Aug 5</div>
                    </div>
                    <div class="metric-card">
                        <h4>Weeks</h4>
                        <div class="value" id="weeksDisplay">0w 0d</div>
                    </div>
                    <div class="metric-card">
                        <h4>Trimester</h4>
                        <div class="value" id="trimesterDisplay">1st</div>
                    </div>
                    <div class="metric-card">
                        <h4>Days Left</h4>
                        <div class="value" id="daysLeftDisplay">280</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Pregnancy Overview</h3>
                    <div class="breakdown-item">
                        <span>Due Date (EDD)</span>
                        <strong id="dueDate" style="color: #E91E63; font-size: 1.1em;">Aug 5, 2026</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Last Menstrual Period (LMP)</span>
                        <strong id="lmpDisplay">Oct 29, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Conception Date (Estimated)</span>
                        <strong id="conceptionDisplay">Nov 12, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Gestational Age</span>
                        <strong id="gestationalAge" style="color: #667eea;">0 weeks, 0 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Days Pregnant</span>
                        <strong id="daysPregnant">0 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Days Until Due Date</span>
                        <strong id="daysRemaining">280 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Trimester</span>
                        <strong id="trimester" style="color: #4CAF50;">First Trimester</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pregnancy Progress</span>
                        <strong id="progress">0% Complete</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Trimester Dates</h3>
                    <div class="breakdown-item">
                        <span>First Trimester</span>
                        <strong id="trimester1" style="color: #4CAF50;">Weeks 1-13 (Oct 29 - Jan 27)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Second Trimester</span>
                        <strong id="trimester2">Weeks 14-27 (Jan 28 - May 5)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Third Trimester</span>
                        <strong id="trimester3">Weeks 28-40 (May 6 - Aug 5)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Important Milestones</h3>
                    <div class="breakdown-item">
                        <span>Heartbeat Visible (6 weeks)</span>
                        <strong id="milestone6w">Dec 10, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>First Trimester Ends (13 weeks)</span>
                        <strong id="milestone13w">Jan 27, 2026</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Anatomy Scan (18-22 weeks)</span>
                        <strong id="milestoneScan">Mar 3 - Mar 31, 2026</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Viability (24 weeks)</span>
                        <strong id="milestone24w">Apr 14, 2026</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Third Trimester (28 weeks)</span>
                        <strong id="milestone28w">May 6, 2026</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Full Term (37 weeks)</span>
                        <strong id="milestone37w">Jul 1, 2026</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Due Date (40 weeks)</span>
                        <strong id="milestone40w" style="color: #E91E63;">Aug 5, 2026</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Current Week Development</h3>
                    <div id="weekDevelopment" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="developmentText">Loading development information...</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Pregnancy Dating</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Gestational Age:</strong> Pregnancy dated from first day of last period (LMP), not conception. Standard medical practice.</p>
                        <p><strong>Why LMP?</strong> Most women know LMP date. Ovulation/conception harder to pinpoint. Adds ~2 weeks before actual conception.</p>
                        <p><strong>40 Weeks = 280 Days:</strong> Full-term pregnancy. Counted from LMP. Baby conceived ~2 weeks after LMP (at ovulation).</p>
                        <p><strong>Due Date Accuracy:</strong> Only 5% of babies born on exact due date. 90% born between 37-42 weeks. Due date is estimate, not guarantee.</p>
                        <p><strong>Naegele's Rule:</strong> Standard calculation: LMP + 280 days (or LMP + 7 days - 3 months). Assumes 28-day cycle with ovulation day 14.</p>
                        <p><strong>Ultrasound Dating:</strong> Most accurate in first trimester (8-13 weeks). Measures baby size. Later ultrasounds less accurate for dating.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Pregnancy Trimesters</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>First Trimester (Weeks 1-13):</strong></p>
                        <p>• Major organ development (heart, brain, spinal cord)</p>
                        <p>• Morning sickness, fatigue, breast tenderness common</p>
                        <p>• Highest miscarriage risk (10-20% of known pregnancies)</p>
                        <p>• First prenatal visit, confirm pregnancy, ultrasound</p>
                        <p>• Take prenatal vitamins with folic acid (prevent birth defects)</p>
                        <p>• Avoid alcohol, smoking, certain medications</p>
                        <p><strong>Second Trimester (Weeks 14-27):</strong></p>
                        <p>• "Honeymoon phase" - energy returns, nausea subsides</p>
                        <p>• Feel baby movements (quickening) around 16-25 weeks</p>
                        <p>• Baby grows rapidly, organs mature</p>
                        <p>• Anatomy scan (18-22 weeks) - check development, learn gender</p>
                        <p>• Glucose screening test (24-28 weeks) for gestational diabetes</p>
                        <p>• Belly grows noticeably, pregnancy shows</p>
                        <p><strong>Third Trimester (Weeks 28-40):</strong></p>
                        <p>• Baby gains weight (½ lb per week), lungs mature</p>
                        <p>• Increased discomfort - back pain, heartburn, frequent urination</p>
                        <p>• Braxton Hicks contractions (practice contractions)</p>
                        <p>• Prenatal visits more frequent (weekly after 36 weeks)</p>
                        <p>• Prepare for labor - hospital bag, birth plan, pediatrician</p>
                        <p>• Baby drops into pelvis (lightening) - easier breathing</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Prenatal Care Schedule</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>First Trimester:</strong></p>
                        <p>• 6-8 weeks: Confirm pregnancy, dating ultrasound, blood tests, medical history</p>
                        <p>• 10-13 weeks: Nuchal translucency ultrasound (screen chromosomal abnormalities), optional NIPT blood test</p>
                        <p><strong>Second Trimester:</strong></p>
                        <p>• Every 4 weeks: Check weight, blood pressure, urine, fetal heartbeat</p>
                        <p>• 16-18 weeks: Quad screen blood test (neural tube defects, Down syndrome)</p>
                        <p>• 18-22 weeks: Anatomy scan ultrasound (detailed organ check, gender reveal)</p>
                        <p>• 24-28 weeks: Glucose tolerance test (gestational diabetes screening)</p>
                        <p><strong>Third Trimester:</strong></p>
                        <p>• Every 2 weeks (28-36 weeks): Monitor baby position, growth, blood pressure</p>
                        <p>• 35-37 weeks: Group B Strep (GBS) test, discuss labor/delivery plan</p>
                        <p>• Weekly (36-40 weeks): Check cervix dilation, baby position, monitor closely</p>
                        <p>• 41+ weeks: Non-stress tests, biophysical profile. Discuss induction if overdue.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Pregnancy Health Tips</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Prenatal Vitamins:</strong> Daily with 400-800 mcg folic acid. Start before conception if possible. Prevents neural tube defects.</p>
                        <p>&#10003; <strong>Nutrition:</strong> Balanced diet. 300 extra calories/day (2nd/3rd trimester). Protein, fruits, vegetables, whole grains, dairy.</p>
                        <p>&#10003; <strong>Hydration:</strong> 8-12 glasses water daily. Prevents constipation, swelling, UTIs, preterm labor.</p>
                        <p>&#10003; <strong>Exercise:</strong> 30 min moderate activity most days. Walking, swimming, prenatal yoga safe. Avoid contact sports, hot yoga.</p>
                        <p>&#10003; <strong>Avoid:</strong> Alcohol (any amount), smoking, recreational drugs, raw fish/meat, unpasteurized dairy, excess caffeine (&lt;200mg/day).</p>
                        <p>&#10003; <strong>Weight Gain:</strong> 25-35 lbs normal BMI. 15-25 lbs overweight. 11-20 lbs obese. 28-40 lbs underweight.</p>
                        <p>&#10003; <strong>Sleep:</strong> 7-9 hours. Sleep on left side (improves circulation). Use pregnancy pillow for support.</p>
                        <p>&#10003; <strong>Dental Care:</strong> Safe to see dentist. Pregnancy gingivitis common. Good oral hygiene important.</p>
                        <p>&#10003; <strong>Sex:</strong> Safe unless complications (placenta previa, preterm labor risk). Discuss concerns with provider.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Warning Signs - Call Doctor Immediately</h3>
                    <div style="padding: 15px; background: #fff3e0; border-radius: 5px; line-height: 1.8; border-left: 4px solid #FF9800;">
                        <p><strong>⚠️ Emergency Symptoms (Call 911 or Go to ER):</strong></p>
                        <p>• Severe abdominal or chest pain</p>
                        <p>• Severe headache with vision changes, swelling (preeclampsia)</p>
                        <p>• Heavy vaginal bleeding (more than spotting)</p>
                        <p>• Sudden gush of fluid (water breaking before 37 weeks)</p>
                        <p>• Severe dizziness, fainting</p>
                        <p>• High fever (&gt;101°F / 38.3°C)</p>
                        <p>• Difficulty breathing, rapid heartbeat</p>
                        <p><strong>⚠️ Call Doctor Same Day:</strong></p>
                        <p>• Decreased fetal movement (after 28 weeks - &lt;10 movements in 2 hours)</p>
                        <p>• Painful urination, burning (UTI)</p>
                        <p>• Persistent vomiting, can't keep food/water down</p>
                        <p>• Regular contractions before 37 weeks (preterm labor)</p>
                        <p>• Severe swelling (hands, face, sudden weight gain)</p>
                        <p>• Persistent cramping or back pain</p>
                        <p>• Signs of infection (fever, chills, body aches)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Pregnancy Tips:</strong> Pregnancy = 40 weeks from LMP. Due date = LMP + 280 days. Only 5% born on exact date. 37-42 weeks = normal. First trimester (1-13 weeks) = organ development. Second (14-27) = honeymoon phase. Third (28-40) = rapid growth. Prenatal vitamins daily (400-800 mcg folic acid). Avoid alcohol, smoking, raw fish. 300 extra cal/day (2nd/3rd trimester). Gain 25-35 lbs (normal BMI). Exercise 30 min/day. Sleep on left side. Drink 8-12 glasses water. Call doctor: heavy bleeding, severe pain, decreased movement, high fever. Ultrasound most accurate 8-13 weeks. Anatomy scan 18-22 weeks. GBS test 35-37 weeks. Weekly visits after 36 weeks. Trust your body!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('pregnancyForm');
        const methodSelect = document.getElementById('calculationMethod');
        
        // Set default date to today
        document.getElementById('lmpDate').valueAsDate = new Date();

        methodSelect.addEventListener('change', function() {
            toggleDateFields();
        });

        function toggleDateFields() {
            const method = methodSelect.value;
            
            document.getElementById('lmpGroup').style.display = method === 'lmp' ? 'block' : 'none';
            document.getElementById('conceptionGroup').style.display = method === 'conception' ? 'block' : 'none';
            document.getElementById('duedateGroup').style.display = method === 'duedate' ? 'block' : 'none';
            document.getElementById('ultrasoundGroup').style.display = method === 'ultrasound' ? 'block' : 'none';
            document.getElementById('ultrasoundWeeksGroup').style.display = method === 'ultrasound' ? 'block' : 'none';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculatePregnancy();
        });

        function getWeekDevelopment(weeks) {
            const developments = {
                4: "🌱 <strong>Week 4:</strong> Implantation occurs. Embryo is size of poppy seed. Neural tube forming (becomes brain & spinal cord). Pregnancy hormone (hCG) detectable.",
                5: "🌱 <strong>Week 5:</strong> Heart begins to beat. Baby is size of sesame seed. Circulatory system forming. Many women miss period and take pregnancy test now.",
                6: "❤️ <strong>Week 6:</strong> Heartbeat visible on ultrasound (100-160 bpm). Baby is size of lentil. Facial features beginning. Arms and legs budding.",
                7: "👶 <strong>Week 7:</strong> Baby is size of blueberry. Brain developing rapidly. Hands and feet forming like paddles. Umbilical cord established.",
                8: "🤏 <strong>Week 8:</strong> All major organs present. Baby is size of kidney bean. Fingers and toes webbed. Baby starts moving (can't feel yet).",
                9: "🫶 <strong>Week 9:</strong> Baby is size of grape. No longer embryo - now fetus. Reproductive organs developing. Tail disappeared.",
                10: "👍 <strong>Week 10:</strong> Vital organs functioning. Baby is size of strawberry. Fingers and toes separated. Bones and cartilage forming.",
                11: "🤰 <strong>Week 11:</strong> Baby is size of lime. Nasal passages open. Hair follicles forming. Can yawn and stretch.",
                12: "✨ <strong>Week 12:</strong> Risk of miscarriage drops significantly. Baby is size of plum. Reflexes developing. Vocal cords forming.",
                13: "🎉 <strong>Week 13:</strong> End of first trimester! Baby is size of lemon. Intestines moving into abdomen. Fingerprints forming.",
                20: "🌟 <strong>Week 20:</strong> Halfway there! Baby is size of banana. Can hear sounds. Vernix (protective coating) covers skin. Anatomy scan week.",
                24: "💪 <strong>Week 24:</strong> Viability milestone - baby could survive with medical help if born. Size of ear of corn. Lungs developing rapidly. Brain growing fast.",
                28: "🎊 <strong>Week 28:</strong> Third trimester begins! Baby is size of eggplant. Can blink eyes. Weighs ~2.5 lbs. Brain very active.",
                37: "🍼 <strong>Week 37:</strong> Full term! Baby is size of winter melon. Lungs mature. Weighs ~6.5 lbs. Ready to be born anytime.",
                40: "🎈 <strong>Week 40:</strong> Due date! Baby is size of watermelon. Average 7-8 lbs. Waiting for labor to start. Could be any day now!"
            };
            
            if (developments[weeks]) {
                return developments[weeks];
            } else if (weeks < 4) {
                return "🌸 <strong>Early Pregnancy:</strong> Conception has occurred. Fertilized egg traveling to uterus. Implantation will happen soon. Too early for symptoms.";
            } else if (weeks >= 14 && weeks <= 19) {
                return `🤰 <strong>Week ${weeks}:</strong> Second trimester - baby growing rapidly. Organs maturing. May start feeling movements (quickening). Energy levels improving. Morning sickness usually gone.`;
            } else if (weeks >= 21 && weeks <= 27) {
                return `👶 <strong>Week ${weeks}:</strong> Mid-pregnancy. Baby very active. Developing sleep/wake cycles. Can hear your voice. Gaining weight steadily. Movements felt regularly.`;
            } else if (weeks >= 29 && weeks <= 36) {
                return `🤱 <strong>Week ${weeks}:</strong> Third trimester. Baby gaining ½ lb per week. Lungs maturing. Getting cramped in there! Practicing breathing movements. Preparing for birth.`;
            } else if (weeks > 40) {
                return `⏰ <strong>Week ${weeks}:</strong> Past due date. Baby fully developed. Doctor monitoring closely. May discuss induction. Labor could start anytime. Stay patient!`;
            }
            return "Loading development information...";
        }

        function calculatePregnancy() {
            const method = methodSelect.value;
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            let lmpDate;
            
            // Calculate LMP based on method
            if (method === 'lmp') {
                lmpDate = new Date(document.getElementById('lmpDate').value);
            } else if (method === 'conception') {
                const conceptionDate = new Date(document.getElementById('conceptionDate').value);
                lmpDate = new Date(conceptionDate);
                lmpDate.setDate(conceptionDate.getDate() - 14); // Subtract 2 weeks
            } else if (method === 'duedate') {
                const dueDate = new Date(document.getElementById('duedateInput').value);
                lmpDate = new Date(dueDate);
                lmpDate.setDate(dueDate.getDate() - 280); // Subtract 40 weeks
            } else if (method === 'ultrasound') {
                const ultrasoundDate = new Date(document.getElementById('ultrasoundDate').value);
                const usWeeks = parseInt(document.getElementById('ultrasoundWeeks').value) || 12;
                const usDays = parseInt(document.getElementById('ultrasoundDays').value) || 0;
                const totalDays = (usWeeks * 7) + usDays;
                
                lmpDate = new Date(ultrasoundDate);
                lmpDate.setDate(ultrasoundDate.getDate() - totalDays);
            }

            // Calculate due date (LMP + 280 days)
            const dueDate = new Date(lmpDate);
            dueDate.setDate(lmpDate.getDate() + 280);

            // Calculate conception date (LMP + 14 days)
            const conceptionDate = new Date(lmpDate);
            conceptionDate.setDate(lmpDate.getDate() + 14);

            // Calculate current gestational age
            const daysSinceLMP = Math.floor((today - lmpDate) / (1000 * 60 * 60 * 24));
            const weeks = Math.floor(daysSinceLMP / 7);
            const days = daysSinceLMP % 7;

            // Calculate days remaining
            const daysRemaining = Math.ceil((dueDate - today) / (1000 * 60 * 60 * 24));

            // Calculate progress
            const progress = Math.min(100, Math.max(0, (daysSinceLMP / 280) * 100));

            // Determine trimester
            let trimester = '';
            let trimesterNum = 1;
            if (weeks < 14) {
                trimester = 'First Trimester';
                trimesterNum = 1;
            } else if (weeks < 28) {
                trimester = 'Second Trimester';
                trimesterNum = 2;
            } else {
                trimester = 'Third Trimester';
                trimesterNum = 3;
            }

            // Calculate trimester dates
            const trim1End = new Date(lmpDate);
            trim1End.setDate(lmpDate.getDate() + (13 * 7));
            
            const trim2Start = new Date(trim1End);
            trim2Start.setDate(trim1End.getDate() + 1);
            const trim2End = new Date(lmpDate);
            trim2End.setDate(lmpDate.getDate() + (27 * 7));
            
            const trim3Start = new Date(trim2End);
            trim3Start.setDate(trim2End.getDate() + 1);

            // Calculate milestones
            const milestone6w = new Date(lmpDate);
            milestone6w.setDate(lmpDate.getDate() + (6 * 7));
            
            const milestone13w = new Date(lmpDate);
            milestone13w.setDate(lmpDate.getDate() + (13 * 7));
            
            const scanStart = new Date(lmpDate);
            scanStart.setDate(lmpDate.getDate() + (18 * 7));
            const scanEnd = new Date(lmpDate);
            scanEnd.setDate(lmpDate.getDate() + (22 * 7));
            
            const milestone24w = new Date(lmpDate);
            milestone24w.setDate(lmpDate.getDate() + (24 * 7));
            
            const milestone28w = new Date(lmpDate);
            milestone28w.setDate(lmpDate.getDate() + (28 * 7));
            
            const milestone37w = new Date(lmpDate);
            milestone37w.setDate(lmpDate.getDate() + (37 * 7));

            // Format dates
            const formatDate = (date) => {
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            };

            const formatDateShort = (date) => {
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            };

            // Get development info
            const developmentText = getWeekDevelopment(weeks);

            // Analysis
            let analysis = `Based on your last menstrual period on ${formatDate(lmpDate)}, your estimated due date is ${formatDate(dueDate)}. `;
            
            if (daysSinceLMP >= 0) {
                analysis += `You are currently ${weeks} weeks and ${days} days pregnant (${daysSinceLMP} days total). `;
                analysis += `You are in your ${trimester.toLowerCase()}, which spans weeks ${trimesterNum === 1 ? '1-13' : trimesterNum === 2 ? '14-27' : '28-40'}. `;
                
                if (daysRemaining > 0) {
                    analysis += `You have approximately ${daysRemaining} days (${Math.floor(daysRemaining / 7)} weeks) until your due date. `;
                } else {
                    analysis += `You are ${Math.abs(daysRemaining)} days past your due date. Contact your healthcare provider for monitoring and discuss possible induction. `;
                }
                
                analysis += `Your pregnancy is ${progress.toFixed(1)}% complete. `;
                
                if (weeks < 13) {
                    analysis += `During the first trimester, focus on taking prenatal vitamins (with folic acid), avoiding harmful substances, and attending your first prenatal appointments. Morning sickness and fatigue are common. `;
                } else if (weeks < 28) {
                    analysis += `The second trimester is often called the "honeymoon phase" - energy typically returns and nausea subsides. You should feel baby movements soon if you haven't already. Don't miss your anatomy scan around 18-22 weeks. `;
                } else if (weeks < 37) {
                    analysis += `You're in the third trimester, the home stretch! Baby is gaining weight rapidly and lungs are maturing. Prepare your hospital bag, finalize birth plan, and attend all prenatal visits. `;
                } else {
                    analysis += `You're full term! Baby could arrive any day. Watch for signs of labor: regular contractions, water breaking, bloody show. Rest, stay hydrated, and stay close to hospital. `;
                }
            } else {
                analysis += `Based on your input, your pregnancy will begin on ${formatDate(lmpDate)}. Your estimated due date will be ${formatDate(dueDate)}. `;
                analysis += `Start taking prenatal vitamins now (400-800 mcg folic acid), maintain a healthy lifestyle, and schedule your first prenatal appointment for 6-8 weeks after your LMP. `;
            }
            
            analysis += `Remember, only 5% of babies are born on their exact due date. Most babies arrive between 37-42 weeks, so your due date is an estimate. `;
            analysis += `Attend all prenatal appointments, follow your healthcare provider's guidance, and call immediately if you experience warning signs like heavy bleeding, severe pain, or decreased fetal movement.`;

            // Update UI
            document.getElementById('dueDateResult').textContent = formatDate(dueDate);
            document.getElementById('weeksPregnant').textContent = daysSinceLMP >= 0 ? 
                `You are ${weeks} weeks, ${days} days pregnant` : 
                `Pregnancy starts ${formatDate(lmpDate)}`;
            
            document.getElementById('dueDateDisplay').textContent = formatDateShort(dueDate);
            document.getElementById('weeksDisplay').textContent = `${weeks}w ${days}d`;
            document.getElementById('trimesterDisplay').textContent = `${trimesterNum}${trimesterNum === 1 ? 'st' : trimesterNum === 2 ? 'nd' : 'rd'}`;
            document.getElementById('daysLeftDisplay').textContent = Math.max(0, daysRemaining);

            document.getElementById('dueDate').textContent = formatDate(dueDate);
            document.getElementById('lmpDisplay').textContent = formatDate(lmpDate);
            document.getElementById('conceptionDisplay').textContent = formatDate(conceptionDate);
            document.getElementById('gestationalAge').textContent = `${weeks} weeks, ${days} days`;
            document.getElementById('daysPregnant').textContent = `${Math.max(0, daysSinceLMP)} days`;
            document.getElementById('daysRemaining').textContent = `${Math.max(0, daysRemaining)} days`;
            document.getElementById('trimester').textContent = trimester;
            document.getElementById('progress').textContent = `${progress.toFixed(1)}% Complete`;

            document.getElementById('trimester1').textContent = `Weeks 1-13 (${formatDateShort(lmpDate)} - ${formatDateShort(trim1End)})`;
            document.getElementById('trimester2').textContent = `Weeks 14-27 (${formatDateShort(trim2Start)} - ${formatDateShort(trim2End)})`;
            document.getElementById('trimester3').textContent = `Weeks 28-40 (${formatDateShort(trim3Start)} - ${formatDateShort(dueDate)})`;

            document.getElementById('milestone6w').textContent = formatDate(milestone6w);
            document.getElementById('milestone13w').textContent = formatDate(milestone13w);
            document.getElementById('milestoneScan').textContent = `${formatDateShort(scanStart)} - ${formatDateShort(scanEnd)}, ${scanStart.getFullYear()}`;
            document.getElementById('milestone24w').textContent = formatDate(milestone24w);
            document.getElementById('milestone28w').textContent = formatDate(milestone28w);
            document.getElementById('milestone37w').textContent = formatDate(milestone37w);
            document.getElementById('milestone40w').textContent = formatDate(dueDate);

            document.getElementById('developmentText').innerHTML = developmentText;
            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleDateFields();
            calculatePregnancy();
        });
    </script>
</body>
</html>