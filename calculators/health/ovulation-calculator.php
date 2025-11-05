<?php
/**
 * Ovulation Calculator
 * File: ovulation-calculator.php
 * Description: Calculate ovulation date, fertile window, and best days to conceive
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ovulation Calculator - Fertile Window & Ovulation Calendar</title>
    <meta name="description" content="Free ovulation calculator. Calculate ovulation date, fertile window, and best days to conceive. Track your menstrual cycle for pregnancy planning.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🌸 Ovulation Calculator</h1>
        <p>Calculate fertile window & ovulation</p>
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
                <h2>Cycle Information</h2>
                <form id="ovulationForm">
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Last Menstrual Period</h3>
                    
                    <div class="form-group">
                        <label for="lmpDate">First Day of Last Period (LMP)</label>
                        <input type="date" id="lmpDate" required>
                        <small>First day of your last menstrual period</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Cycle Details</h3>
                    
                    <div class="form-group">
                        <label for="cycleLength">Average Cycle Length (days)</label>
                        <input type="number" id="cycleLength" value="28" min="21" max="45" step="1" required>
                        <small>Days from first day of period to first day of next period</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="lutealPhase">Luteal Phase Length (days)</label>
                        <input type="number" id="lutealPhase" value="14" min="10" max="16" step="1">
                        <small>Usually 12-14 days (14 is average)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Ovulation</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Ovulation Results</h2>
                
                <div class="result-card success">
                    <h3>Ovulation Date</h3>
                    <div class="amount" id="ovulationResult">Nov 12, 2025</div>
                    <div style="margin-top: 10px; font-size: 1em;">Most fertile day</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Ovulation</h4>
                        <div class="value" id="ovulationDisplay">Nov 12</div>
                    </div>
                    <div class="metric-card">
                        <h4>Fertile Start</h4>
                        <div class="value" id="fertileStartDisplay">Nov 7</div>
                    </div>
                    <div class="metric-card">
                        <h4>Fertile End</h4>
                        <div class="value" id="fertileEndDisplay">Nov 13</div>
                    </div>
                    <div class="metric-card">
                        <h4>Next Period</h4>
                        <div class="value" id="nextPeriodDisplay">Nov 26</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Cycle Information</h3>
                    <div class="breakdown-item">
                        <span>Last Period Started</span>
                        <strong id="lmpDisplay">Oct 29, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cycle Length</span>
                        <strong id="cycleLengthDisplay">28 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Luteal Phase</span>
                        <strong id="lutealDisplay">14 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Follicular Phase</span>
                        <strong id="follicularDisplay">14 days</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Ovulation & Fertility Dates</h3>
                    <div class="breakdown-item">
                        <span>Ovulation Date</span>
                        <strong id="ovulationDate" style="color: #E91E63; font-size: 1.1em;">Nov 12, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fertile Window</span>
                        <strong id="fertileWindow" style="color: #4CAF50;">Nov 7 - Nov 13</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Best Days to Conceive</span>
                        <strong id="bestDays" style="color: #667eea;">Nov 10, 11, 12</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fertile Window Duration</span>
                        <strong id="fertileDuration">7 days</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Upcoming Dates</h3>
                    <div class="breakdown-item">
                        <span>Next Period Expected</span>
                        <strong id="nextPeriod" style="color: #f44336;">Nov 26, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Period Due In</span>
                        <strong id="periodDueIn">28 days from LMP</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pregnancy Test Date</span>
                        <strong id="testDate">Nov 26, 2025 or later</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Due Date (if conceiving)</span>
                        <strong id="dueDate">Aug 5, 2026</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Fertility Calendar (Next 3 Months)</h3>
                    <div class="breakdown-item">
                        <span>Cycle 1 Ovulation</span>
                        <strong id="ovulation1" style="color: #E91E63;">Nov 12, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cycle 1 Fertile Window</span>
                        <strong id="fertile1">Nov 7-13</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cycle 2 Ovulation</span>
                        <strong id="ovulation2" style="color: #E91E63;">Dec 10, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cycle 2 Fertile Window</span>
                        <strong id="fertile2">Dec 5-11</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cycle 3 Ovulation</span>
                        <strong id="ovulation3" style="color: #E91E63;">Jan 7, 2026</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cycle 3 Fertile Window</span>
                        <strong id="fertile3">Jan 2-8</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Ovulation</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>What is Ovulation?</strong> Release of mature egg from ovary. Occurs once per cycle, usually mid-cycle. Egg survives 12-24 hours after release.</p>
                        <p><strong>When Does It Happen?</strong> Typically 14 days before next period. For 28-day cycle: day 14. For 30-day cycle: day 16. Varies by individual.</p>
                        <p><strong>Fertile Window:</strong> 5 days before ovulation + ovulation day + 1 day after = 7 days total. Sperm can survive 3-5 days in fertile cervical mucus.</p>
                        <p><strong>Best Days to Conceive:</strong> 2-3 days before ovulation through ovulation day. Sperm waiting for egg = highest pregnancy chances (30% per cycle).</p>
                        <p><strong>Pregnancy Probability:</strong> Ovulation day 20-30%, Day before ovulation 25-30%, 2 days before 15-20%, Outside fertile window &lt;5%.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Ovulation Signs & Symptoms</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Cervical Mucus Changes:</strong> Most reliable sign. Becomes clear, stretchy, slippery (like raw egg white). Indicates peak fertility. Dries up after ovulation.</p>
                        <p><strong>Basal Body Temperature (BBT):</strong> Slight rise (0.5-1°F) after ovulation. Track with BBT thermometer. Confirms ovulation occurred, doesn't predict it.</p>
                        <p><strong>LH Surge:</strong> Luteinizing hormone spikes 24-36 hours before ovulation. Detected by ovulation predictor kits (OPKs). Most accurate prediction method.</p>
                        <p><strong>Ovulation Pain (Mittelschmerz):</strong> 20% of women feel mild cramping on one side. Lasts minutes to hours. May indicate ovulation occurring.</p>
                        <p><strong>Other Signs:</strong> Increased sex drive, breast tenderness, light spotting, bloating, heightened senses (smell, taste, vision).</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How to Track Ovulation</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Calendar Method:</strong> Track cycle length for 3+ months. Estimate ovulation (cycle length - 14 days). Least accurate but free and easy.</p>
                        <p><strong>Ovulation Predictor Kits (OPKs):</strong> Test urine for LH surge. Test daily starting 3-4 days before expected ovulation. Positive = ovulation in 24-36 hrs. Accuracy 90%+.</p>
                        <p><strong>Basal Body Temperature (BBT):</strong> Take temperature every morning before getting up. Chart daily. Temperature rises 0.5-1°F after ovulation. Confirms ovulation occurred.</p>
                        <p><strong>Cervical Mucus Monitoring:</strong> Check daily. Fertile mucus = clear, stretchy, slippery. Peak fertility when most abundant. Free and effective with practice.</p>
                        <p><strong>Fertility Apps:</strong> Track periods, symptoms, temperatures. Predict ovulation using algorithms. Convenient but accuracy varies. Best combined with other methods.</p>
                        <p><strong>Fertility Monitors:</strong> Advanced devices (e.g., Clearblue). Track multiple hormones. Expensive ($100-300) but very accurate.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tips for Getting Pregnant</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Time Intercourse:</strong> Have sex every 1-2 days during fertile window. Focus on 2-3 days before ovulation through ovulation day.</p>
                        <p>&#10003; <strong>Don't Overdo It:</strong> Daily sex can reduce sperm count. Every other day during fertile window is optimal.</p>
                        <p>&#10003; <strong>Healthy Lifestyle:</strong> Maintain healthy weight (BMI 18.5-24.9). Obesity and underweight reduce fertility.</p>
                        <p>&#10003; <strong>Take Prenatal Vitamins:</strong> Start 3 months before trying. Folic acid (400-800 mcg) prevents birth defects.</p>
                        <p>&#10003; <strong>Avoid Harmful Substances:</strong> No smoking, limit alcohol (&lt;2 drinks/week), no recreational drugs.</p>
                        <p>&#10003; <strong>Reduce Stress:</strong> High stress can delay ovulation. Practice relaxation techniques, adequate sleep (7-9 hours).</p>
                        <p>&#10003; <strong>Limit Caffeine:</strong> &lt;200mg/day (1-2 cups coffee). Excessive caffeine may reduce fertility.</p>
                        <p>&#10003; <strong>Stay Hydrated:</strong> Water improves cervical mucus quality. Aim 8-10 glasses daily.</p>
                        <p>&#10003; <strong>Exercise Moderately:</strong> 30 min most days. Excessive intense exercise can disrupt cycles.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>When to See a Doctor</h3>
                    <div style="padding: 15px; background: #fff3e0; border-radius: 5px; line-height: 1.8; border-left: 4px solid #FF9800;">
                        <p><strong>⚠️ Seek Medical Evaluation If:</strong></p>
                        <p>• <strong>Under 35:</strong> Not pregnant after 12 months of regular, unprotected intercourse</p>
                        <p>• <strong>Over 35:</strong> Not pregnant after 6 months of trying</p>
                        <p>• <strong>Over 40:</strong> Consult before trying (fertility declines significantly)</p>
                        <p>• <strong>Irregular Cycles:</strong> Cycles shorter than 21 days or longer than 35 days</p>
                        <p>• <strong>Absent Periods:</strong> Amenorrhea (no period for 3+ months)</p>
                        <p>• <strong>Very Heavy/Painful Periods:</strong> May indicate endometriosis or fibroids</p>
                        <p>• <strong>Known Fertility Issues:</strong> PCOS, endometriosis, blocked tubes, male factor</p>
                        <p>• <strong>Previous Pregnancy Loss:</strong> 2+ miscarriages</p>
                        <p>• <strong>Medical Conditions:</strong> Diabetes, thyroid disorders, autoimmune diseases</p>
                        <p><strong>Fertility Testing May Include:</strong> Hormone blood tests, ultrasound, HSG (tube dye test), semen analysis (partner)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Your Menstrual Cycle</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Menstrual Phase (Days 1-5):</strong> Period bleeding. Uterine lining sheds. Estrogen and progesterone at lowest levels.</p>
                        <p><strong>Follicular Phase (Days 1-14):</strong> Overlaps with period. Follicles mature in ovaries. Estrogen rises. Uterine lining rebuilds.</p>
                        <p><strong>Ovulation (Day 14):</strong> LH surge triggers egg release. Fertile window peak. Best time for conception. Lasts 12-24 hours.</p>
                        <p><strong>Luteal Phase (Days 15-28):</strong> Corpus luteum produces progesterone. Prepares uterus for pregnancy. If no pregnancy, progesterone drops and period starts.</p>
                        <p><strong>Normal Cycle Length:</strong> 21-35 days (28 average). Varies between women and month-to-month. Consistency more important than exact length.</p>
                        <p><strong>Normal Period:</strong> 3-7 days bleeding. 2-3 tbsp blood loss total. Heavier first 2 days normal.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Ovulation Tips:</strong> Ovulation = egg release from ovary. Occurs ~14 days before next period. Fertile window = 5 days before + day of + 1 day after ovulation. Best conception days: 2-3 days BEFORE ovulation (sperm waiting). Egg lives 12-24 hrs. Sperm lives 3-5 days. Pregnancy chance 20-30% per cycle. Track with: calendar, OPKs (LH surge), BBT (temperature), cervical mucus (egg white texture). Have sex every 1-2 days during fertile window. Start prenatal vitamins 3 months before. Healthy weight boosts fertility. See doctor if not pregnant after 1 year (&lt;35) or 6 months (35+). Irregular cycles? See doctor. PCOS, endometriosis affect fertility. Stay positive - average couple takes 6 months!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('ovulationForm');
        
        // Set default date to today
        document.getElementById('lmpDate').valueAsDate = new Date();

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateOvulation();
        });

        function calculateOvulation() {
            const lmpDate = new Date(document.getElementById('lmpDate').value);
            const cycleLength = parseInt(document.getElementById('cycleLength').value) || 28;
            const lutealPhase = parseInt(document.getElementById('lutealPhase').value) || 14;

            // Calculate follicular phase
            const follicularPhase = cycleLength - lutealPhase;

            // Calculate ovulation date (cycle length - luteal phase days)
            const ovulationDate = new Date(lmpDate);
            ovulationDate.setDate(lmpDate.getDate() + follicularPhase);

            // Calculate fertile window (5 days before ovulation + ovulation day + 1 day after)
            const fertileStart = new Date(ovulationDate);
            fertileStart.setDate(ovulationDate.getDate() - 5);
            
            const fertileEnd = new Date(ovulationDate);
            fertileEnd.setDate(ovulationDate.getDate() + 1);

            // Best days to conceive (2 days before ovulation through ovulation day)
            const bestDay1 = new Date(ovulationDate);
            bestDay1.setDate(ovulationDate.getDate() - 2);
            
            const bestDay2 = new Date(ovulationDate);
            bestDay2.setDate(ovulationDate.getDate() - 1);
            
            const bestDay3 = new Date(ovulationDate);

            // Next period date
            const nextPeriod = new Date(lmpDate);
            nextPeriod.setDate(lmpDate.getDate() + cycleLength);

            // Pregnancy test date (same as next period expected)
            const testDate = new Date(nextPeriod);

            // Due date if conceiving (280 days / 40 weeks from LMP)
            const dueDate = new Date(lmpDate);
            dueDate.setDate(lmpDate.getDate() + 280);

            // Next 3 cycles
            const cycle2Ovulation = new Date(ovulationDate);
            cycle2Ovulation.setDate(ovulationDate.getDate() + cycleLength);
            const cycle2FertileStart = new Date(cycle2Ovulation);
            cycle2FertileStart.setDate(cycle2Ovulation.getDate() - 5);
            const cycle2FertileEnd = new Date(cycle2Ovulation);
            cycle2FertileEnd.setDate(cycle2Ovulation.getDate() + 1);

            const cycle3Ovulation = new Date(ovulationDate);
            cycle3Ovulation.setDate(ovulationDate.getDate() + (cycleLength * 2));
            const cycle3FertileStart = new Date(cycle3Ovulation);
            cycle3FertileStart.setDate(cycle3Ovulation.getDate() - 5);
            const cycle3FertileEnd = new Date(cycle3Ovulation);
            cycle3FertileEnd.setDate(cycle3Ovulation.getDate() + 1);

            // Format dates
            const formatDate = (date) => {
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            };

            const formatDateShort = (date) => {
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            };

            // Calculate days until next period
            const today = new Date();
            const daysUntilPeriod = Math.ceil((nextPeriod - today) / (1000 * 60 * 60 * 24));

            // Analysis
            let analysis = `Based on your last menstrual period starting ${formatDate(lmpDate)} and a ${cycleLength}-day cycle, `;
            analysis += `your estimated ovulation date is ${formatDate(ovulationDate)}. `;
            
            analysis += `Your fertile window spans 7 days, from ${formatDate(fertileStart)} to ${formatDate(fertileEnd)}. `;
            analysis += `During this time, you have the highest chance of conceiving. `;
            
            analysis += `The best days for intercourse to maximize pregnancy chances are ${formatDateShort(bestDay1)}, ${formatDateShort(bestDay2)}, and ${formatDateShort(bestDay3)} (2-3 days before ovulation through ovulation day). `;
            analysis += `This timing allows sperm to be waiting when the egg is released, resulting in 20-30% pregnancy probability per cycle. `;
            
            analysis += `Your next period is expected around ${formatDate(nextPeriod)}, approximately ${daysUntilPeriod} days from today. `;
            analysis += `If your period doesn't arrive by that date and you've been trying to conceive, take a home pregnancy test on or after ${formatDate(testDate)}. `;
            
            analysis += `If you do conceive during this cycle, your estimated due date would be ${formatDate(dueDate)}. `;
            
            analysis += `For the most accurate tracking, consider using ovulation predictor kits (OPKs) to detect your LH surge 24-36 hours before ovulation. `;
            analysis += `Monitor your cervical mucus daily - when it becomes clear, stretchy, and slippery (like raw egg white), you're at peak fertility. `;
            analysis += `Remember that these are estimates based on average cycles. Individual variation is normal, and ovulation timing can shift due to stress, illness, or other factors.`;

            // Update UI
            document.getElementById('ovulationResult').textContent = formatDate(ovulationDate);
            document.getElementById('ovulationDisplay').textContent = formatDateShort(ovulationDate);
            document.getElementById('fertileStartDisplay').textContent = formatDateShort(fertileStart);
            document.getElementById('fertileEndDisplay').textContent = formatDateShort(fertileEnd);
            document.getElementById('nextPeriodDisplay').textContent = formatDateShort(nextPeriod);

            document.getElementById('lmpDisplay').textContent = formatDate(lmpDate);
            document.getElementById('cycleLengthDisplay').textContent = `${cycleLength} days`;
            document.getElementById('lutealDisplay').textContent = `${lutealPhase} days`;
            document.getElementById('follicularDisplay').textContent = `${follicularPhase} days`;

            document.getElementById('ovulationDate').textContent = formatDate(ovulationDate);
            document.getElementById('fertileWindow').textContent = `${formatDateShort(fertileStart)} - ${formatDateShort(fertileEnd)}`;
            document.getElementById('bestDays').textContent = `${formatDateShort(bestDay1)}, ${formatDateShort(bestDay2)}, ${formatDateShort(bestDay3)}`;
            document.getElementById('fertileDuration').textContent = '7 days';

            document.getElementById('nextPeriod').textContent = formatDate(nextPeriod);
            document.getElementById('periodDueIn').textContent = `${cycleLength} days from LMP`;
            document.getElementById('testDate').textContent = `${formatDate(testDate)} or later`;
            document.getElementById('dueDate').textContent = formatDate(dueDate);

            document.getElementById('ovulation1').textContent = formatDate(ovulationDate);
            document.getElementById('fertile1').textContent = `${formatDateShort(fertileStart)}-${formatDateShort(fertileEnd).split(' ')[1]}`;
            document.getElementById('ovulation2').textContent = formatDate(cycle2Ovulation);
            document.getElementById('fertile2').textContent = `${formatDateShort(cycle2FertileStart)}-${formatDateShort(cycle2FertileEnd).split(' ')[1]}`;
            document.getElementById('ovulation3').textContent = formatDate(cycle3Ovulation);
            document.getElementById('fertile3').textContent = `${formatDateShort(cycle3FertileStart)}-${formatDateShort(cycle3FertileEnd).split(' ')[1]}`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            calculateOvulation();
        });
    </script>
</body>
</html>