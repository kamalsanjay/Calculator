<?php
/**
 * Conception Calculator
 * File: conception-calculator.php
 * Description: Calculate conception date based on due date or last menstrual period
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conception Calculator - Calculate Conception Date & Fertile Window</title>
    <meta name="description" content="Free conception calculator. Calculate conception date based on due date or last period. Estimate fertile window, ovulation date, and baby's conception period.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>👶 Conception Calculator</h1>
        <p>Calculate conception date & fertile window</p>
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
                <h2>Calculation Method</h2>
                <form id="conceptionForm">
                    <div class="form-group">
                        <label for="calculationMethod">Calculate Based On</label>
                        <select id="calculationMethod">
                            <option value="lmp">Last Menstrual Period (LMP)</option>
                            <option value="duedate">Due Date</option>
                            <option value="ultrasound">Ultrasound Date</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Date Information</h3>
                    
                    <div class="form-group" id="lmpGroup">
                        <label for="lmpDate">First Day of Last Period (LMP)</label>
                        <input type="date" id="lmpDate" required>
                        <small>Enter the first day of your last menstrual period</small>
                    </div>
                    
                    <div class="form-group" id="duedateGroup" style="display: none;">
                        <label for="dueDate">Due Date / Expected Delivery Date</label>
                        <input type="date" id="dueDate">
                        <small>Enter your estimated due date</small>
                    </div>
                    
                    <div class="form-group" id="ultrasoundGroup" style="display: none;">
                        <label for="ultrasoundDate">Ultrasound Date</label>
                        <input type="date" id="ultrasoundDate">
                        <small>Date of ultrasound scan</small>
                    </div>
                    
                    <div class="form-group" id="gestationalAgeGroup" style="display: none;">
                        <label for="gestationalWeeks">Gestational Age at Ultrasound</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="gestationalWeeks" value="12" min="4" max="42" step="1" style="flex: 1;" placeholder="Weeks">
                            <input type="number" id="gestationalDays" value="0" min="0" max="6" step="1" style="flex: 1;" placeholder="Days">
                        </div>
                        <small>Gestational age shown on ultrasound</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Optional Information</h3>
                    
                    <div class="form-group">
                        <label for="cycleLength">Average Cycle Length (days)</label>
                        <input type="number" id="cycleLength" value="28" min="21" max="35" step="1">
                        <small>Typical cycle length (21-35 days, average 28)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Conception Date</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Conception Results</h2>
                
                <div class="result-card success">
                    <h3>Estimated Conception Date</h3>
                    <div class="amount" id="conceptionResult" style="font-size: 2em;">Jan 15, 2025</div>
                    <div style="margin-top: 10px; font-size: 1em;">Most likely conception date</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Conception Date</h4>
                        <div class="value" id="conceptionDisplay">Jan 15</div>
                    </div>
                    <div class="metric-card">
                        <h4>Due Date</h4>
                        <div class="value" id="dueDateDisplay">Oct 10</div>
                    </div>
                    <div class="metric-card">
                        <h4>Days Pregnant</h4>
                        <div class="value" id="daysPregnant">90</div>
                    </div>
                    <div class="metric-card">
                        <h4>Trimester</h4>
                        <div class="value" id="trimester">2nd</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Key Dates</h3>
                    <div class="breakdown-item">
                        <span>Last Menstrual Period (LMP)</span>
                        <strong id="lmpDisplay">January 1, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated Ovulation Date</span>
                        <strong id="ovulationDisplay" style="color: #667eea;">January 15, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated Conception Date</span>
                        <strong id="conceptionCalc" style="color: #E91E63;">January 15, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Implantation Date Range</span>
                        <strong id="implantationRange">January 21-27, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Expected Due Date</span>
                        <strong id="dueDateCalc" style="color: #4CAF50;">October 8, 2025</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Fertile Window (Conception Period)</h3>
                    <div class="breakdown-item">
                        <span>Fertile Window Start</span>
                        <strong id="fertileStart">January 10, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Peak Fertility Days</span>
                        <strong id="peakFertility" style="color: #E91E63;">January 13-15, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Fertile Window End</span>
                        <strong id="fertileEnd">January 16, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Fertile Days</span>
                        <strong id="fertileDays">7 days</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Current Pregnancy Status</h3>
                    <div class="breakdown-item">
                        <span>Weeks Pregnant</span>
                        <strong id="weeksPregnant" style="color: #667eea; font-size: 1.1em;">12 weeks 6 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Trimester</span>
                        <strong id="trimesterCalc">2nd Trimester</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Days Until Due Date</span>
                        <strong id="daysUntilDue">190 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pregnancy Progress</span>
                        <strong id="progressPercent">32% complete</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Pregnancy Timeline</h3>
                    <div class="breakdown-item">
                        <span>1st Trimester Ends</span>
                        <strong>Week 13 (March 26, 2025)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>2nd Trimester</span>
                        <strong>Weeks 14-27 (March 27 - July 2, 2025)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>3rd Trimester Begins</span>
                        <strong>Week 28 (July 3, 2025)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Full Term (37 weeks)</span>
                        <strong>September 17, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Due Date (40 weeks)</span>
                        <strong style="color: #4CAF50;">October 8, 2025</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Important Milestones</h3>
                    <div class="breakdown-item">
                        <span>Heartbeat Detectable</span>
                        <strong>Week 6 (February 12, 2025)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>First Ultrasound (typical)</span>
                        <strong>Week 8-10 (February 26 - March 12)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gender Reveal Possible</span>
                        <strong>Week 16-20 (May 7 - June 4)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Quickening (Feel Movement)</span>
                        <strong>Week 18-22 (May 21 - June 18)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Viability (24 weeks)</span>
                        <strong>June 18, 2025</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Conception</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Conception:</strong> When sperm fertilizes the egg, typically occurring during ovulation (about 14 days after LMP).</p>
                        <p><strong>Ovulation:</strong> Release of egg from ovary. Usually occurs 14 days before next period (day 14 of 28-day cycle).</p>
                        <p><strong>Fertile Window:</strong> 5 days before ovulation + ovulation day + 1 day after (6-7 days total). Sperm can survive 5 days.</p>
                        <p><strong>Implantation:</strong> Fertilized egg attaches to uterus lining, 6-12 days after conception. Pregnancy hormone (hCG) begins.</p>
                        <p><strong>Gestational Age:</strong> Pregnancy calculated from LMP (not conception). 40 weeks = 280 days from LMP.</p>
                        <p><strong>Actual Pregnancy:</strong> Starts at conception, about 2 weeks after LMP. Baby is actually 2 weeks younger than gestational age.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How Conception Date is Calculated</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>From LMP:</strong> Add 14 days to first day of last period (assumes 28-day cycle, ovulation day 14).</p>
                        <p><strong>From Due Date:</strong> Subtract 266 days (38 weeks) from due date to estimate conception.</p>
                        <p><strong>From Ultrasound:</strong> Subtract gestational age from ultrasound date, then subtract 2 weeks for conception.</p>
                        <p><strong>Cycle Length Adjustment:</strong> For cycles ≠28 days, ovulation occurs 14 days before next period, not day 14.</p>
                        <p><strong>Accuracy:</strong> Conception is estimated within a window of several days, not an exact date.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Factors Affecting Conception Timing</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>• <strong>Cycle Irregularity:</strong> Irregular cycles make ovulation harder to predict</p>
                        <p>• <strong>Cycle Length:</strong> Shorter/longer cycles shift ovulation date</p>
                        <p>• <strong>Sperm Survival:</strong> Can live 3-5 days in female reproductive tract</p>
                        <p>• <strong>Egg Viability:</strong> Egg survives 12-24 hours after release</p>
                        <p>• <strong>Multiple Intercourse:</strong> Conception could be from any encounter in fertile window</p>
                        <p>• <strong>Early/Late Ovulation:</strong> Ovulation doesn't always occur on day 14</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Conception Date Range</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Most Likely Date:</strong> <span id="mostLikely">January 15, 2025</span> (ovulation day)</p>
                        <p><strong>Possible Range:</strong> <span id="possibleRange">January 13-17, 2025</span> (5-day window)</p>
                        <p><strong>Why a Range?</strong> Exact conception moment is unknown. Sperm can survive several days, and ovulation timing varies.</p>
                        <p><strong>Ultrasound Dating:</strong> First trimester ultrasound (before 13 weeks) is most accurate for dating pregnancy, accurate within 5-7 days.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Pregnancy Testing Timeline</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Implantation:</strong> 6-12 days after conception (most common: 8-10 days)</p>
                        <p><strong>hCG Detectable (Blood Test):</strong> 9-10 days after conception</p>
                        <p><strong>hCG Detectable (Home Test):</strong> 12-14 days after conception (first day of missed period)</p>
                        <p><strong>Best Testing Time:</strong> First morning urine, 1-2 days after missed period for accuracy</p>
                        <p><strong>Early Detection Tests:</strong> May detect 5-6 days before missed period (less reliable)</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Conception Tips:</strong> Conception = fertilization of egg by sperm. Occurs during ovulation (~day 14 of 28-day cycle). Fertile window = 5 days before + ovulation day. Sperm survives 5 days. Egg survives 12-24 hours. Implantation = 6-12 days after conception. Pregnancy age = from LMP (not conception). Baby actually 2 weeks younger than gestational age. Ultrasound most accurate in first trimester. Conception date is estimated range, not exact. Irregular cycles affect accuracy. Test 12-14 days after conception. First morning urine best. Due date = LMP + 280 days. Only 5% deliver on exact due date!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('conceptionForm');
        const methodSelect = document.getElementById('calculationMethod');

        methodSelect.addEventListener('change', function() {
            toggleMethodFields();
            calculateConception();
        });

        function toggleMethodFields() {
            const method = methodSelect.value;
            
            document.getElementById('lmpGroup').style.display = method === 'lmp' ? 'block' : 'none';
            document.getElementById('duedateGroup').style.display = method === 'duedate' ? 'block' : 'none';
            document.getElementById('ultrasoundGroup').style.display = method === 'ultrasound' ? 'block' : 'none';
            document.getElementById('gestationalAgeGroup').style.display = method === 'ultrasound' ? 'block' : 'none';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateConception();
        });

        function calculateConception() {
            const method = methodSelect.value;
            const cycleLength = parseInt(document.getElementById('cycleLength').value) || 28;
            const today = new Date();
            
            let lmpDate, conceptionDate, dueDate, ovulationDate;
            
            if (method === 'lmp') {
                const lmpInput = document.getElementById('lmpDate').value;
                if (!lmpInput) {
                    // Set default to 90 days ago
                    lmpDate = new Date(today);
                    lmpDate.setDate(lmpDate.getDate() - 90);
                    document.getElementById('lmpDate').value = lmpDate.toISOString().split('T')[0];
                } else {
                    lmpDate = new Date(lmpInput);
                }
                
                // Calculate ovulation (cycle length - 14 days)
                const ovulationDay = cycleLength - 14;
                ovulationDate = new Date(lmpDate);
                ovulationDate.setDate(ovulationDate.getDate() + ovulationDay);
                conceptionDate = new Date(ovulationDate);
                
                // Calculate due date (LMP + 280 days)
                dueDate = new Date(lmpDate);
                dueDate.setDate(dueDate.getDate() + 280);
                
            } else if (method === 'duedate') {
                const dueDateInput = document.getElementById('dueDate').value;
                if (!dueDateInput) {
                    // Set default due date to 190 days from now
                    dueDate = new Date(today);
                    dueDate.setDate(dueDate.getDate() + 190);
                    document.getElementById('dueDate').value = dueDate.toISOString().split('T')[0];
                } else {
                    dueDate = new Date(dueDateInput);
                }
                
                // Calculate LMP (due date - 280 days)
                lmpDate = new Date(dueDate);
                lmpDate.setDate(lmpDate.getDate() - 280);
                
                // Calculate conception (due date - 266 days)
                conceptionDate = new Date(dueDate);
                conceptionDate.setDate(conceptionDate.getDate() - 266);
                ovulationDate = new Date(conceptionDate);
                
            } else {
                // Ultrasound method
                const ultrasoundInput = document.getElementById('ultrasoundDate').value;
                const weeks = parseInt(document.getElementById('gestationalWeeks').value) || 12;
                const days = parseInt(document.getElementById('gestationalDays').value) || 0;
                
                if (!ultrasoundInput) {
                    const defaultDate = new Date(today);
                    defaultDate.setDate(defaultDate.getDate() - 7);
                    document.getElementById('ultrasoundDate').value = defaultDate.toISOString().split('T')[0];
                }
                
                const ultrasoundDate = new Date(document.getElementById('ultrasoundDate').value || defaultDate);
                const totalDays = (weeks * 7) + days;
                
                // Calculate LMP (ultrasound date - gestational age)
                lmpDate = new Date(ultrasoundDate);
                lmpDate.setDate(lmpDate.getDate() - totalDays);
                
                // Calculate conception (LMP + 14 days)
                conceptionDate = new Date(lmpDate);
                conceptionDate.setDate(conceptionDate.getDate() + 14);
                ovulationDate = new Date(conceptionDate);
                
                // Calculate due date
                dueDate = new Date(lmpDate);
                dueDate.setDate(dueDate.getDate() + 280);
            }

            // Calculate fertile window
            const fertileStart = new Date(ovulationDate);
            fertileStart.setDate(fertileStart.getDate() - 5);
            
            const fertileEnd = new Date(ovulationDate);
            fertileEnd.setDate(fertileEnd.getDate() + 1);
            
            const peakStart = new Date(ovulationDate);
            peakStart.setDate(peakStart.getDate() - 2);
            
            const peakEnd = new Date(ovulationDate);

            // Calculate implantation window
            const implantStart = new Date(conceptionDate);
            implantStart.setDate(implantStart.getDate() + 6);
            
            const implantEnd = new Date(conceptionDate);
            implantEnd.setDate(implantEnd.getDate() + 12);

            // Calculate current pregnancy status
            const daysSinceLMP = Math.floor((today - lmpDate) / (1000 * 60 * 60 * 24));
            const weeksSinceLMP = Math.floor(daysSinceLMP / 7);
            const daysMod = daysSinceLMP % 7;
            
            const daysUntilDue = Math.floor((dueDate - today) / (1000 * 60 * 60 * 24));
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

            // Calculate trimester milestones
            const firstTrimesterEnd = new Date(lmpDate);
            firstTrimesterEnd.setDate(firstTrimesterEnd.getDate() + (13 * 7));
            
            const secondTrimesterStart = new Date(lmpDate);
            secondTrimesterStart.setDate(secondTrimesterStart.getDate() + (14 * 7));
            
            const secondTrimesterEnd = new Date(lmpDate);
            secondTrimesterEnd.setDate(secondTrimesterEnd.getDate() + (27 * 7));
            
            const thirdTrimesterStart = new Date(lmpDate);
            thirdTrimesterStart.setDate(thirdTrimesterStart.getDate() + (28 * 7));
            
            const fullTerm = new Date(lmpDate);
            fullTerm.setDate(fullTerm.getDate() + (37 * 7));

            // Conception range
            const conceptionRangeStart = new Date(conceptionDate);
            conceptionRangeStart.setDate(conceptionRangeStart.getDate() - 2);
            
            const conceptionRangeEnd = new Date(conceptionDate);
            conceptionRangeEnd.setDate(conceptionRangeEnd.getDate() + 2);

            // Format dates
            const formatDate = (date) => {
                return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            };
            
            const formatDateShort = (date) => {
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            };

            // Analysis
            let analysis = `Based on your ${method === 'lmp' ? 'last menstrual period' : method === 'duedate' ? 'due date' : 'ultrasound'}, `;
            analysis += `your estimated conception date is ${formatDate(conceptionDate)}. `;
            analysis += `This is the most likely date when the egg was fertilized by sperm, typically occurring during ovulation. `;
            analysis += `Your fertile window was ${formatDate(fertileStart)} through ${formatDate(fertileEnd)}, `;
            analysis += `with peak fertility on ${formatDateShort(peakStart)} - ${formatDateShort(peakEnd)}. `;
            analysis += `You are currently ${weeksSinceLMP} weeks and ${daysMod} days pregnant (${trimester} trimester). `;
            analysis += `Your expected due date is ${formatDate(dueDate)}, which is ${daysUntilDue} days away. `;
            analysis += `Remember that only about 5% of babies are born on their exact due date - most arrive within 2 weeks before or after. `;
            analysis += `The conception date is an estimate based on average cycle timing and may vary by several days.`;

            // Update UI
            document.getElementById('conceptionResult').textContent = formatDateShort(conceptionDate) + ', ' + conceptionDate.getFullYear();
            document.getElementById('conceptionDisplay').textContent = formatDateShort(conceptionDate);
            document.getElementById('dueDateDisplay').textContent = formatDateShort(dueDate);
            document.getElementById('daysPregnant').textContent = daysSinceLMP;
            document.getElementById('trimester').textContent = trimester;

            document.getElementById('lmpDisplay').textContent = formatDate(lmpDate);
            document.getElementById('ovulationDisplay').textContent = formatDate(ovulationDate);
            document.getElementById('conceptionCalc').textContent = formatDate(conceptionDate);
            document.getElementById('implantationRange').textContent = `${formatDateShort(implantStart)} - ${formatDateShort(implantEnd)}, ${implantStart.getFullYear()}`;
            document.getElementById('dueDateCalc').textContent = formatDate(dueDate);

            document.getElementById('fertileStart').textContent = formatDate(fertileStart);
            document.getElementById('peakFertility').textContent = `${formatDateShort(peakStart)} - ${formatDateShort(peakEnd)}, ${peakStart.getFullYear()}`;
            document.getElementById('fertileEnd').textContent = formatDate(fertileEnd);
            document.getElementById('fertileDays').textContent = '7 days';

            document.getElementById('weeksPregnant').textContent = `${weeksSinceLMP} weeks ${daysMod} days`;
            document.getElementById('trimesterCalc').textContent = `${trimester} Trimester`;
            document.getElementById('daysUntilDue').textContent = `${daysUntilDue} days`;
            document.getElementById('progressPercent').textContent = `${progressPercent}% complete`;

            document.getElementById('mostLikely').textContent = formatDate(conceptionDate);
            document.getElementById('possibleRange').textContent = `${formatDateShort(conceptionRangeStart)} - ${formatDateShort(conceptionRangeEnd)}, ${conceptionRangeStart.getFullYear()}`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleMethodFields();
            calculateConception();
        });
    </script>
</body>
</html>