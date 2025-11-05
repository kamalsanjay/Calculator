<?php
/**
 * Fertility Calculator
 * File: fertility-calculator.php
 * Description: Calculate fertile window, ovulation date, and best days to conceive
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fertility Calculator - Ovulation & Fertile Window Calculator</title>
    <meta name="description" content="Free fertility calculator. Calculate ovulation date, fertile window, and best days to conceive. Track your menstrual cycle for pregnancy planning.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🌸 Fertility Calculator</h1>
        <p>Calculate ovulation & fertile window</p>
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
                <form id="fertilityForm">
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Menstrual Cycle Details</h3>
                    
                    <div class="form-group">
                        <label for="lmpDate">First Day of Last Period (LMP)</label>
                        <input type="date" id="lmpDate" required>
                        <small>Enter the first day of your last menstrual period</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="cycleLength">Average Cycle Length (days)</label>
                        <input type="number" id="cycleLength" value="28" min="21" max="35" step="1" required>
                        <small>Number of days from first day of period to first day of next period</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="periodLength">Period Length (days)</label>
                        <input type="number" id="periodLength" value="5" min="2" max="10" step="1">
                        <small>How many days your period typically lasts</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Optional Information</h3>
                    
                    <div class="form-group">
                        <label for="cycleRegularity">Cycle Regularity</label>
                        <select id="cycleRegularity">
                            <option value="regular" selected>Regular (varies ±2 days)</option>
                            <option value="somewhat">Somewhat Regular (varies ±3-4 days)</option>
                            <option value="irregular">Irregular (varies ±5+ days)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="calculateFor">Calculate For</label>
                        <select id="calculateFor">
                            <option value="current">Current Cycle</option>
                            <option value="next">Next Cycle</option>
                            <option value="both" selected>Current & Next 3 Cycles</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Fertility Window</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Fertility Results</h2>
                
                <div class="result-card success">
                    <h3>Next Ovulation Date</h3>
                    <div class="amount" id="ovulationResult" style="font-size: 2em;">Jan 15, 2025</div>
                    <div style="margin-top: 10px; font-size: 1em;">Peak fertility day</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Ovulation</h4>
                        <div class="value" id="ovulationDisplay">Jan 15</div>
                    </div>
                    <div class="metric-card">
                        <h4>Fertile Days</h4>
                        <div class="value" id="fertileDays">6</div>
                    </div>
                    <div class="metric-card">
                        <h4>Next Period</h4>
                        <div class="value" id="nextPeriod">Jan 29</div>
                    </div>
                    <div class="metric-card">
                        <h4>Cycle Day</h4>
                        <div class="value" id="cycleDay">14</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Cycle Information</h3>
                    <div class="breakdown-item">
                        <span>Last Period Started</span>
                        <strong id="lmpDisplay">January 1, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Cycle Length</span>
                        <strong id="cycleLengthDisplay">28 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Period Length</span>
                        <strong id="periodLengthDisplay">5 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cycle Regularity</span>
                        <strong id="regularityDisplay">Regular</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Current Cycle - Fertile Window</h3>
                    <div class="breakdown-item">
                        <span>Fertile Window Starts</span>
                        <strong id="fertileStart" style="color: #4CAF50;">January 10, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Peak Fertility Days</span>
                        <strong id="peakFertility" style="color: #E91E63; font-size: 1.1em;">January 13-15, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ovulation Day (Best Day)</span>
                        <strong id="ovulationDate" style="color: #667eea; font-size: 1.1em;">January 15, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fertile Window Ends</span>
                        <strong id="fertileEnd" style="color: #4CAF50;">January 16, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Fertile Days</span>
                        <strong id="totalFertileDays">7 days</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Best Days to Try to Conceive</h3>
                    <div class="breakdown-item">
                        <span>High Chance (Ovulation Day)</span>
                        <strong id="highChance" style="color: #E91E63;">January 15, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>High Chance (Day Before Ovulation)</span>
                        <strong id="dayBefore" style="color: #E91E63;">January 14, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Good Chance (2-3 Days Before)</span>
                        <strong id="twoDaysBefore" style="color: #FF9800;">January 12-13, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lower Chance (Early Fertile Window)</span>
                        <strong id="earlyWindow" style="color: #4CAF50;">January 10-11, 2025</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Upcoming Cycle Dates</h3>
                    <div class="breakdown-item">
                        <span>Next Period Expected</span>
                        <strong id="nextPeriodDate">January 29, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Period After That</span>
                        <strong id="periodAfter">February 26, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Next Ovulation (Cycle 2)</span>
                        <strong id="nextOvulation">February 12, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ovulation After That (Cycle 3)</span>
                        <strong id="ovulationAfter">March 12, 2025</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Next 3 Fertile Windows</h3>
                    <div class="breakdown-item">
                        <span>Cycle 1 Fertile Window</span>
                        <strong id="fertile1" style="color: #E91E63;">Jan 10-16, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cycle 2 Fertile Window</span>
                        <strong id="fertile2">Feb 7-13, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cycle 3 Fertile Window</span>
                        <strong id="fertile3">Mar 7-13, 2025</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Your Fertile Window</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Fertile Window:</strong> The 6-7 days each cycle when pregnancy is possible. Includes 5 days before ovulation + ovulation day + 1 day after.</p>
                        <p><strong>Why 6-7 Days?</strong> Sperm can survive 3-5 days inside female reproductive tract. Egg survives 12-24 hours after ovulation.</p>
                        <p><strong>Ovulation:</strong> Release of mature egg from ovary. Occurs ~14 days before next period (not necessarily day 14 of cycle).</p>
                        <p><strong>Best Days:</strong> Highest pregnancy chance is 1-2 days before ovulation and ovulation day itself.</p>
                        <p><strong>Peak Fertility:</strong> 3 days before ovulation through ovulation day = ~30% chance per cycle.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How Ovulation is Calculated</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Standard Method:</strong> Ovulation occurs 14 days before next period starts (luteal phase = constant 14 days).</p>
                        <p><strong>For 28-Day Cycle:</strong> Ovulation = Day 14 (28 - 14 = 14)</p>
                        <p><strong>For 30-Day Cycle:</strong> Ovulation = Day 16 (30 - 14 = 16)</p>
                        <p><strong>For 26-Day Cycle:</strong> Ovulation = Day 12 (26 - 14 = 12)</p>
                        <p><strong>Fertile Window:</strong> 5 days before ovulation + ovulation day + 1 day after</p>
                        <p><strong>Note:</strong> This is an estimate. Actual ovulation can vary by ±2 days even in regular cycles.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Signs of Ovulation</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Cervical Mucus Changes:</strong> Clear, stretchy, egg-white consistency (most fertile). Slippery and wet.</p>
                        <p><strong>Basal Body Temperature (BBT):</strong> Slight rise (0.5-1°F) after ovulation. Track daily with BBT thermometer.</p>
                        <p><strong>Ovulation Pain (Mittelschmerz):</strong> Mild cramping or pain on one side of lower abdomen.</p>
                        <p><strong>Increased Sex Drive:</strong> Natural libido boost during fertile window.</p>
                        <p><strong>Breast Tenderness:</strong> Some women experience sore breasts.</p>
                        <p><strong>Bloating:</strong> Slight abdominal bloating or water retention.</p>
                        <p><strong>Light Spotting:</strong> Very light pink/brown spotting (not common).</p>
                        <p><strong>Heightened Senses:</strong> Enhanced sense of smell, taste, or vision.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tracking Ovulation Methods</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Calendar Method:</strong> Track cycles for 6+ months to predict ovulation. Works best for regular cycles.</p>
                        <p><strong>BBT Charting:</strong> Take temperature daily before getting out of bed. Look for sustained rise indicating ovulation occurred.</p>
                        <p><strong>Cervical Mucus Monitoring:</strong> Check daily. Most fertile = clear, stretchy, egg-white consistency.</p>
                        <p><strong>Ovulation Predictor Kits (OPKs):</strong> Test LH surge 24-48 hours before ovulation. Start testing 3-4 days before expected ovulation.</p>
                        <p><strong>Fertility Apps:</strong> Digital tracking with calendar, symptoms, and predictions.</p>
                        <p><strong>Fertility Monitors:</strong> Electronic devices measuring hormone levels in urine or saliva.</p>
                        <p><strong>Ultrasound:</strong> Doctor can visualize follicle development and confirm ovulation.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tips to Increase Fertility</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Time Intercourse:</strong> Every 1-2 days during fertile window, especially 2 days before ovulation</p>
                        <p>&#10003; <strong>Maintain Healthy Weight:</strong> BMI 18.5-24.9 optimal for fertility</p>
                        <p>&#10003; <strong>Eat Balanced Diet:</strong> Plenty of fruits, vegetables, whole grains, lean protein</p>
                        <p>&#10003; <strong>Take Prenatal Vitamins:</strong> Start folic acid (400-800 mcg) before conceiving</p>
                        <p>&#10003; <strong>Limit Caffeine:</strong> Less than 200mg daily (1-2 cups coffee)</p>
                        <p>&#10003; <strong>Avoid Alcohol & Smoking:</strong> Both reduce fertility significantly</p>
                        <p>&#10003; <strong>Reduce Stress:</strong> High stress can disrupt ovulation</p>
                        <p>&#10003; <strong>Exercise Moderately:</strong> Regular activity improves fertility, but not excessive</p>
                        <p>&#10003; <strong>Sleep Well:</strong> 7-9 hours nightly supports hormone balance</p>
                        <p>&#10003; <strong>Avoid Lubricants:</strong> Most reduce sperm motility. Use fertility-friendly if needed</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Male Fertility Tips</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Keep Testicles Cool:</strong> Avoid hot tubs, saunas, tight underwear</p>
                        <p>&#10003; <strong>Healthy Lifestyle:</strong> Exercise, balanced diet, maintain healthy weight</p>
                        <p>&#10003; <strong>Avoid Smoking & Excessive Alcohol:</strong> Damages sperm quality</p>
                        <p>&#10003; <strong>Limit Environmental Toxins:</strong> Pesticides, heavy metals, chemicals</p>
                        <p>&#10003; <strong>Manage Stress:</strong> Affects testosterone and sperm production</p>
                        <p>&#10003; <strong>Take Antioxidants:</strong> Vitamin C, E, zinc, selenium support sperm health</p>
                        <p>&#10003; <strong>Regular Ejaculation:</strong> Every 2-3 days maintains fresh sperm</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Pregnancy Probability by Day</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>5 Days Before Ovulation:</strong> ~10% chance</p>
                        <p><strong>4 Days Before Ovulation:</strong> ~16% chance</p>
                        <p><strong>3 Days Before Ovulation:</strong> ~14% chance</p>
                        <p><strong>2 Days Before Ovulation:</strong> ~27% chance (peak!)</p>
                        <p><strong>1 Day Before Ovulation:</strong> ~31% chance (highest!)</p>
                        <p><strong>Ovulation Day:</strong> ~33% chance</p>
                        <p><strong>1 Day After Ovulation:</strong> ~5% chance</p>
                        <p><strong>Overall Per Cycle:</strong> ~20-25% for healthy couples under 35</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>When to See a Doctor</h3>
                    <div style="padding: 15px; background: #ffebee; border-radius: 5px; line-height: 1.8; border-left: 4px solid #f44336;">
                        <p><strong>⚠️ Seek Medical Advice If:</strong></p>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li><strong>Under 35:</strong> Trying for 12+ months without success</li>
                            <li><strong>Age 35-40:</strong> Trying for 6+ months without success</li>
                            <li><strong>Over 40:</strong> Consult doctor before trying or after 3 months</li>
                            <li>Irregular periods or no periods (amenorrhea)</li>
                            <li>Very painful periods (possible endometriosis)</li>
                            <li>History of pelvic inflammatory disease (PID)</li>
                            <li>Multiple miscarriages (2+)</li>
                            <li>Known fertility issues (PCOS, fibroids, etc.)</li>
                            <li>Male partner has known fertility issues</li>
                            <li>History of cancer treatment or pelvic surgery</li>
                        </ul>
                        <p><strong>Fertility Tests:</strong> Hormone testing, ultrasound, semen analysis, HSG (fallopian tube test)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Fertility Tips:</strong> Fertile window = 6-7 days. Ovulation = 14 days before next period. Best days = 1-2 days before ovulation. Sperm lives 3-5 days. Egg lives 12-24 hours. Peak chance = 30% per cycle. Track with OPKs, BBT, cervical mucus. Every 1-2 days during fertile window. Healthy weight = better fertility. Folic acid = 400mcg daily. Avoid smoking & excess alcohol. Reduce stress. Sleep 7-9 hours. Keep testicles cool (men). See doctor if trying 12+ months (under 35) or 6+ months (over 35). Average time to conceive = 6 months. 85% conceive within 1 year. Age matters - fertility declines after 35!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('fertilityForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateFertility();
        });

        function calculateFertility() {
            const lmpInput = document.getElementById('lmpDate').value;
            const cycleLength = parseInt(document.getElementById('cycleLength').value) || 28;
            const periodLength = parseInt(document.getElementById('periodLength').value) || 5;
            const regularity = document.getElementById('cycleRegularity').value;
            const today = new Date();
            
            let lmpDate;
            if (!lmpInput) {
                lmpDate = new Date(today);
                lmpDate.setDate(lmpDate.getDate() - 14);
                document.getElementById('lmpDate').value = lmpDate.toISOString().split('T')[0];
            } else {
                lmpDate = new Date(lmpInput);
            }

            // Calculate ovulation (cycle length - 14 days)
            const ovulationDay = cycleLength - 14;
            const ovulationDate = new Date(lmpDate);
            ovulationDate.setDate(ovulationDate.getDate() + ovulationDay);

            // Calculate fertile window (5 days before to 1 day after ovulation)
            const fertileStart = new Date(ovulationDate);
            fertileStart.setDate(fertileStart.getDate() - 5);
            
            const fertileEnd = new Date(ovulationDate);
            fertileEnd.setDate(fertileEnd.getDate() + 1);

            // Peak fertility (2 days before to ovulation day)
            const peakStart = new Date(ovulationDate);
            peakStart.setDate(peakStart.getDate() - 2);
            
            const peakEnd = new Date(ovulationDate);

            // Best days
            const dayBefore = new Date(ovulationDate);
            dayBefore.setDate(dayBefore.getDate() - 1);
            
            const twoDaysBeforeStart = new Date(ovulationDate);
            twoDaysBeforeStart.setDate(twoDaysBeforeStart.getDate() - 3);
            
            const twoDaysBeforeEnd = new Date(ovulationDate);
            twoDaysBeforeEnd.setDate(twoDaysBeforeEnd.getDate() - 2);
            
            const earlyWindowStart = new Date(fertileStart);
            const earlyWindowEnd = new Date(ovulationDate);
            earlyWindowEnd.setDate(earlyWindowEnd.getDate() - 4);

            // Next periods
            const nextPeriod = new Date(lmpDate);
            nextPeriod.setDate(nextPeriod.getDate() + cycleLength);
            
            const periodAfter = new Date(nextPeriod);
            periodAfter.setDate(periodAfter.getDate() + cycleLength);

            // Next ovulations
            const nextOvulation = new Date(nextPeriod);
            nextOvulation.setDate(nextOvulation.getDate() + ovulationDay);
            
            const ovulationAfter = new Date(periodAfter);
            ovulationAfter.setDate(ovulationAfter.getDate() + ovulationDay);

            // Next fertile windows
            const fertile2Start = new Date(nextOvulation);
            fertile2Start.setDate(fertile2Start.getDate() - 5);
            const fertile2End = new Date(nextOvulation);
            fertile2End.setDate(fertile2End.getDate() + 1);
            
            const fertile3Start = new Date(ovulationAfter);
            fertile3Start.setDate(fertile3Start.getDate() - 5);
            const fertile3End = new Date(ovulationAfter);
            fertile3End.setDate(fertile3End.getDate() + 1);

            // Current cycle day
            const daysSinceLMP = Math.floor((today - lmpDate) / (1000 * 60 * 60 * 24));
            const currentCycleDay = (daysSinceLMP % cycleLength) + 1;

            // Format dates
            const formatDate = (date) => {
                return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            };
            
            const formatDateShort = (date) => {
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            };

            // Regularity names
            const regularityNames = {
                'regular': 'Regular (±2 days)',
                'somewhat': 'Somewhat Regular (±3-4 days)',
                'irregular': 'Irregular (±5+ days)'
            };

            // Analysis
            let analysis = `Based on your last period starting ${formatDate(lmpDate)} and a ${cycleLength}-day cycle, `;
            analysis += `your next ovulation is expected on ${formatDate(ovulationDate)}. `;
            analysis += `Your fertile window is ${formatDate(fertileStart)} through ${formatDate(fertileEnd)}, `;
            analysis += `with peak fertility days from ${formatDateShort(peakStart)} to ${formatDateShort(peakEnd)}. `;
            analysis += `For the best chance of conception, try to have intercourse every 1-2 days during your fertile window, `;
            analysis += `especially on ${formatDate(dayBefore)} and ${formatDate(ovulationDate)}. `;
            analysis += `These are your highest probability days with approximately 30-33% chance per cycle. `;
            
            if (regularity !== 'regular') {
                analysis += `Since your cycles are ${regularity === 'somewhat' ? 'somewhat irregular' : 'irregular'}, `;
                analysis += `consider using ovulation predictor kits (OPKs) or tracking basal body temperature (BBT) for more accuracy. `;
            }
            
            analysis += `Your next period is expected around ${formatDate(nextPeriod)}. `;
            analysis += `If you don't conceive this cycle, your next fertile window will be ${formatDateShort(fertile2Start)} to ${formatDateShort(fertile2End)}. `;
            analysis += `Remember, even healthy couples under 35 have only about 20-25% chance per cycle, so it may take several months. `;
            analysis += `Stay positive and keep trying!`;

            // Update UI
            document.getElementById('ovulationResult').textContent = formatDateShort(ovulationDate) + ', ' + ovulationDate.getFullYear();
            document.getElementById('ovulationDisplay').textContent = formatDateShort(ovulationDate);
            document.getElementById('fertileDays').textContent = '7';
            document.getElementById('nextPeriod').textContent = formatDateShort(nextPeriod);
            document.getElementById('cycleDay').textContent = currentCycleDay;

            document.getElementById('lmpDisplay').textContent = formatDate(lmpDate);
            document.getElementById('cycleLengthDisplay').textContent = `${cycleLength} days`;
            document.getElementById('periodLengthDisplay').textContent = `${periodLength} days`;
            document.getElementById('regularityDisplay').textContent = regularityNames[regularity];

            document.getElementById('fertileStart').textContent = formatDate(fertileStart);
            document.getElementById('peakFertility').textContent = `${formatDateShort(peakStart)} - ${formatDateShort(peakEnd)}, ${peakStart.getFullYear()}`;
            document.getElementById('ovulationDate').textContent = formatDate(ovulationDate);
            document.getElementById('fertileEnd').textContent = formatDate(fertileEnd);
            document.getElementById('totalFertileDays').textContent = '7 days';

            document.getElementById('highChance').textContent = formatDate(ovulationDate);
            document.getElementById('dayBefore').textContent = formatDate(dayBefore);
            document.getElementById('twoDaysBefore').textContent = `${formatDateShort(twoDaysBeforeStart)} - ${formatDateShort(twoDaysBeforeEnd)}, ${twoDaysBeforeStart.getFullYear()}`;
            document.getElementById('earlyWindow').textContent = `${formatDateShort(earlyWindowStart)} - ${formatDateShort(earlyWindowEnd)}, ${earlyWindowStart.getFullYear()}`;

            document.getElementById('nextPeriodDate').textContent = formatDate(nextPeriod);
            document.getElementById('periodAfter').textContent = formatDate(periodAfter);
            document.getElementById('nextOvulation').textContent = formatDate(nextOvulation);
            document.getElementById('ovulationAfter').textContent = formatDate(ovulationAfter);

            document.getElementById('fertile1').textContent = `${formatDateShort(fertileStart)} - ${formatDateShort(fertileEnd)}, ${fertileStart.getFullYear()}`;
            document.getElementById('fertile2').textContent = `${formatDateShort(fertile2Start)} - ${formatDateShort(fertile2End)}, ${fertile2Start.getFullYear()}`;
            document.getElementById('fertile3').textContent = `${formatDateShort(fertile3Start)} - ${formatDateShort(fertile3End)}, ${fertile3Start.getFullYear()}`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            calculateFertility();
        });
    </script>
</body>
</html>