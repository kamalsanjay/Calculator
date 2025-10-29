<?php
/**
 * One Rep Max Calculator
 * File: one-rep-max-calculator.php
 * Description: Calculate one-rep max (1RM) and training percentages using multiple formulas
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One Rep Max Calculator - 1RM Calculator (Brzycki, Epley, Lombardi)</title>
    <meta name="description" content="Free one rep max calculator. Calculate 1RM using Brzycki, Epley, and Lombardi formulas. Get training percentages and rep ranges for strength programs.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>🏋️ One Rep Max Calculator</h1>
        <p>Calculate 1RM & training percentages</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Training Information</h2>
                <form id="ormForm">
                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="lbs">Pounds (lbs)</option>
                            <option value="kg">Kilograms (kg)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exercise">Exercise (Optional)</label>
                        <select id="exercise">
                            <option value="custom">Custom Exercise</option>
                            <option value="squat">Squat</option>
                            <option value="bench">Bench Press</option>
                            <option value="deadlift">Deadlift</option>
                            <option value="overhead">Overhead Press</option>
                            <option value="row">Barbell Row</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Your Lift</h3>
                    
                    <div class="form-group">
                        <label for="weight">Weight Lifted</label>
                        <input type="number" id="weight" value="225" min="1" max="2000" step="0.5" required>
                        <small>Weight you successfully lifted</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="reps">Reps Performed</label>
                        <input type="number" id="reps" value="5" min="1" max="20" step="1" required>
                        <small>Number of reps completed (1-20)</small>
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Formula Selection</h3>
                    
                    <div class="form-group">
                        <label for="formula">Formula</label>
                        <select id="formula">
                            <option value="brzycki" selected>Brzycki (Most Popular)</option>
                            <option value="epley">Epley</option>
                            <option value="lombardi">Lombardi</option>
                            <option value="mayhew">Mayhew</option>
                            <option value="oconner">O'Conner</option>
                            <option value="wathan">Wathan</option>
                            <option value="average">Average (All Formulas)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate 1RM</button>
                </form>
            </div>

            <div class="results-section">
                <h2>One Rep Max Results</h2>
                
                <div class="result-card success">
                    <h3>Estimated 1RM</h3>
                    <div class="amount" id="ormResult">255 lbs</div>
                    <div style="margin-top: 10px; font-size: 1em;" id="exerciseName">Brzycki formula</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>1RM</h4>
                        <div class="value" id="ormDisplay">255 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>90% (3-4 reps)</h4>
                        <div class="value" id="percent90">230 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>80% (5-6 reps)</h4>
                        <div class="value" id="percent80">204 lbs</div>
                    </div>
                    <div class="metric-card">
                        <h4>70% (8-10 reps)</h4>
                        <div class="value" id="percent70">179 lbs</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Lift</h3>
                    <div class="breakdown-item">
                        <span>Exercise</span>
                        <strong id="exerciseDisplay">Custom Exercise</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight Lifted</span>
                        <strong id="weightDisplay">225 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Reps Performed</span>
                        <strong id="repsDisplay">5 reps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Formula Used</span>
                        <strong id="formulaDisplay">Brzycki</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated 1RM</span>
                        <strong id="orm1RM" style="color: #667eea; font-size: 1.1em;">255 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>1RM by Formula</h3>
                    <div class="breakdown-item">
                        <span>Brzycki Formula</span>
                        <strong id="brzyckiORM" style="color: #667eea;">255 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Epley Formula</span>
                        <strong id="epleyORM">253 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lombardi Formula</span>
                        <strong id="lombardiORM">258 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mayhew Formula</span>
                        <strong id="mayhewORM">256 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>O'Conner Formula</span>
                        <strong id="oconnerORM">254 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Wathan Formula</span>
                        <strong id="wathanORM">257 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average (All Formulas)</span>
                        <strong id="averageORM" style="color: #4CAF50; font-size: 1.1em;">255 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Training Percentages</h3>
                    <div class="breakdown-item">
                        <span>100% (1RM - Max Effort)</span>
                        <strong id="p100" style="color: #f44336;">255 lbs × 1 rep</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>95% (Peak Strength)</span>
                        <strong id="p95">242 lbs × 2 reps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>90% (Heavy Strength)</span>
                        <strong id="p90">230 lbs × 3-4 reps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>85% (Strength Building)</span>
                        <strong id="p85">217 lbs × 4-6 reps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>80% (Power/Strength)</span>
                        <strong id="p80" style="color: #667eea;">204 lbs × 5-7 reps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>75% (Strength Endurance)</span>
                        <strong id="p75">191 lbs × 7-10 reps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>70% (Hypertrophy)</span>
                        <strong id="p70">179 lbs × 8-12 reps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>65% (Muscle Building)</span>
                        <strong id="p65">166 lbs × 10-15 reps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>60% (Endurance)</span>
                        <strong id="p60">153 lbs × 12-20 reps</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Rep Max Chart</h3>
                    <div class="breakdown-item">
                        <span>1 Rep Max (100%)</span>
                        <strong id="rep1">255 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>2 Rep Max (95%)</span>
                        <strong id="rep2">242 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>3 Rep Max (90%)</span>
                        <strong id="rep3">230 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>4 Rep Max (87%)</span>
                        <strong id="rep4">222 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>5 Rep Max (85%)</span>
                        <strong id="rep5">217 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>6 Rep Max (83%)</span>
                        <strong id="rep6">212 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>8 Rep Max (80%)</span>
                        <strong id="rep8">204 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>10 Rep Max (75%)</span>
                        <strong id="rep10">191 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>12 Rep Max (70%)</span>
                        <strong id="rep12">179 lbs</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding 1RM Formulas</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>What is 1RM?</strong> One-rep max is the maximum weight you can lift for one repetition with proper form. Used for program design and tracking strength progress.</p>
                        <p><strong>Brzycki (1993):</strong> 1RM = weight / (1.0278 - 0.0278 × reps). Most popular formula. Best for 1-10 reps.</p>
                        <p><strong>Epley (1985):</strong> 1RM = weight × (1 + 0.0333 × reps). Simple, widely used. Good for all rep ranges.</p>
                        <p><strong>Lombardi (1989):</strong> 1RM = weight × reps^0.10. Good for higher reps (5-10).</p>
                        <p><strong>Accuracy:</strong> Most accurate with 1-5 reps. Less accurate as reps increase (10+). Direct testing most accurate but risky.</p>
                        <p><strong>Safety:</strong> Estimating 1RM safer than actually attempting max lift. Reduces injury risk.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Training Zones Explained</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>90-100% (Max Strength):</strong> 1-3 reps. Builds absolute strength. High CNS demand. Use for powerlifting peaking. 3+ min rest.</p>
                        <p><strong>85-90% (Heavy Strength):</strong> 3-6 reps. Best for strength gains. Moderate volume. 2-4 sets. 2-3 min rest.</p>
                        <p><strong>75-85% (Strength/Hypertrophy):</strong> 6-10 reps. Builds muscle and strength. Sweet spot for most lifters. 3-5 sets. 1.5-3 min rest.</p>
                        <p><strong>67-75% (Hypertrophy):</strong> 8-12 reps. Optimal for muscle growth. Higher volume. 3-6 sets. 60-90 sec rest.</p>
                        <p><strong>60-67% (Muscular Endurance):</strong> 12-20 reps. Muscle endurance, definition. High volume. 2-4 sets. 30-60 sec rest.</p>
                        <p><strong>&lt;60% (Active Recovery):</strong> 20+ reps. Technique work, warm-up, rehab. Light weight, high reps.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>How to Use Your 1RM</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Program Design:</strong> Most programs prescribe training percentages (e.g., "3×5 @ 85%"). Use 1RM to calculate working weights.</p>
                        <p><strong>Progressive Overload:</strong> Track 1RM over time. Aim to increase 1RM monthly (beginners) or quarterly (advanced).</p>
                        <p><strong>Periodization:</strong> Vary intensity (% of 1RM) across training cycles. High % for strength, moderate % for hypertrophy.</p>
                        <p><strong>Testing Frequency:</strong> Beginners: every 8-12 weeks. Intermediate: every 4-8 weeks. Advanced: every 2-4 weeks.</p>
                        <p><strong>Don't Max Out Often:</strong> Testing true 1RM is taxing. Use calculator estimates for training. Save max attempts for competitions or PR days.</p>
                        <p><strong>Leave Room in Tank:</strong> Most sets should stop 1-2 reps before failure (RPE 7-9). Only max out occasionally.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Testing Your 1RM Safely</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Warm-Up Protocol:</strong></p>
                        <p>• 5-10 reps @ 40-50% (light)</p>
                        <p>• 3-5 reps @ 60-70% (moderate)</p>
                        <p>• 2-3 reps @ 75-80% (heavy)</p>
                        <p>• 1 rep @ 85-90% (very heavy)</p>
                        <p>• 1 rep @ 95-100% (max attempt)</p>
                        <p><strong>Rest Between Sets:</strong> 3-5 minutes before max attempt. Stay warm but recovered.</p>
                        <p><strong>Safety Tips:</strong></p>
                        <p>• Use spotter for bench press, squat</p>
                        <p>• Use safety bars/rack pins</p>
                        <p>• Don't test when fatigued or injured</p>
                        <p>• Perfect form required - no grinding reps</p>
                        <p>• Stop if something feels wrong</p>
                        <p><strong>When NOT to Test:</strong> First 3-6 months lifting, during injury recovery, when extremely tired, without supervision.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Realistic Strength Standards</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Bodyweight Ratios (for 200lb male):</strong></p>
                        <p><strong>Squat:</strong> Beginner 1.0×BW (200 lbs), Intermediate 1.5×BW (300 lbs), Advanced 2.0×BW (400 lbs), Elite 2.5×BW+ (500 lbs+)</p>
                        <p><strong>Bench Press:</strong> Beginner 0.75×BW (150 lbs), Intermediate 1.0×BW (200 lbs), Advanced 1.5×BW (300 lbs), Elite 2.0×BW+ (400 lbs+)</p>
                        <p><strong>Deadlift:</strong> Beginner 1.25×BW (250 lbs), Intermediate 1.75×BW (350 lbs), Advanced 2.25×BW (450 lbs), Elite 2.75×BW+ (550 lbs+)</p>
                        <p><strong>Overhead Press:</strong> Beginner 0.5×BW (100 lbs), Intermediate 0.75×BW (150 lbs), Advanced 1.0×BW (200 lbs), Elite 1.25×BW+ (250 lbs+)</p>
                        <p><strong>Note:</strong> Standards vary by bodyweight, age, and training experience. Women's standards typically 60-75% of men's.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>1RM Tips:</strong> 1RM = max weight for 1 rep. Most accurate with 1-5 reps test. Brzycki most popular formula. Don't test true 1RM often (injury risk). 90-100% = strength (1-3 reps). 75-85% = hypertrophy (6-10 reps). 60-70% = endurance (12+ reps). Use percentages for program design. Test every 4-12 weeks. Progressive overload = key. Warm up properly before max. Use spotter + safety equipment. Perfect form required. Stop if pain occurs. Track 1RM progress monthly. Beginners gain 5-10 lbs/month. Advanced 1-2 lbs/month. Realistic goals: 1.5×BW squat, 1×BW bench (intermediate). Don't ego lift!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('ormForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateORM();
        });

        function calculateORM() {
            const unitSystem = document.getElementById('unitSystem').value;
            const exercise = document.getElementById('exercise').value;
            const weight = parseFloat(document.getElementById('weight').value) || 225;
            const reps = parseInt(document.getElementById('reps').value) || 5;
            const formulaType = document.getElementById('formula').value;

            // Calculate 1RM using different formulas
            const brzyckiORM = weight / (1.0278 - 0.0278 * reps);
            const epleyORM = weight * (1 + 0.0333 * reps);
            const lombardiORM = weight * Math.pow(reps, 0.10);
            const mayhewORM = (100 * weight) / (52.2 + 41.9 * Math.exp(-0.055 * reps));
            const oconnerORM = weight * (1 + 0.025 * reps);
            const wathanORM = (100 * weight) / (48.8 + 53.8 * Math.exp(-0.075 * reps));

            // Average of all formulas
            const averageORM = (brzyckiORM + epleyORM + lombardiORM + mayhewORM + oconnerORM + wathanORM) / 6;

            // Select primary 1RM based on formula
            let orm;
            let formulaName;
            
            switch(formulaType) {
                case 'brzycki':
                    orm = brzyckiORM;
                    formulaName = 'Brzycki';
                    break;
                case 'epley':
                    orm = epleyORM;
                    formulaName = 'Epley';
                    break;
                case 'lombardi':
                    orm = lombardiORM;
                    formulaName = 'Lombardi';
                    break;
                case 'mayhew':
                    orm = mayhewORM;
                    formulaName = 'Mayhew';
                    break;
                case 'oconner':
                    orm = oconnerORM;
                    formulaName = "O'Conner";
                    break;
                case 'wathan':
                    orm = wathanORM;
                    formulaName = 'Wathan';
                    break;
                case 'average':
                    orm = averageORM;
                    formulaName = 'Average';
                    break;
            }

            // Calculate training percentages
            const p100 = orm;
            const p95 = orm * 0.95;
            const p90 = orm * 0.90;
            const p85 = orm * 0.85;
            const p80 = orm * 0.80;
            const p75 = orm * 0.75;
            const p70 = orm * 0.70;
            const p65 = orm * 0.65;
            const p60 = orm * 0.60;

            // Rep maxes
            const rep1 = orm;
            const rep2 = orm * 0.95;
            const rep3 = orm * 0.90;
            const rep4 = orm * 0.87;
            const rep5 = orm * 0.85;
            const rep6 = orm * 0.83;
            const rep8 = orm * 0.80;
            const rep10 = orm * 0.75;
            const rep12 = orm * 0.70;

            // Exercise names
            const exerciseNames = {
                'custom': 'Custom Exercise',
                'squat': 'Squat',
                'bench': 'Bench Press',
                'deadlift': 'Deadlift',
                'overhead': 'Overhead Press',
                'row': 'Barbell Row'
            };

            // Format weights
            const unit = unitSystem;
            const formatWeight = (w) => Math.round(w * 2) / 2; // Round to nearest 0.5

            // Analysis
            let analysis = `Based on your lift of ${weight} ${unit} for ${reps} rep${reps > 1 ? 's' : ''}, `;
            analysis += `your estimated one-rep max (1RM) using the ${formulaName} formula is ${formatWeight(orm)} ${unit}. `;
            
            analysis += `This calculation is most accurate when using 1-5 reps. `;
            if (reps > 10) {
                analysis += `Note: With ${reps} reps, accuracy decreases. Consider testing with fewer reps (3-5) for better estimates. `;
            }
            
            analysis += `Use your 1RM to design training programs with appropriate percentages. `;
            analysis += `For maximum strength development, train in the 85-95% range (3-6 reps). `;
            analysis += `For muscle growth (hypertrophy), train in the 67-85% range (6-12 reps). `;
            analysis += `For muscular endurance, train in the 60-67% range (12-20+ reps). `;
            
            analysis += `Your training weights should be: ${formatWeight(p90)} ${unit} for heavy strength work (3-4 reps), `;
            analysis += `${formatWeight(p80)} ${unit} for power/strength (5-7 reps), `;
            analysis += `and ${formatWeight(p70)} ${unit} for hypertrophy (8-12 reps). `;
            
            analysis += `Remember: these are estimates. Always use proper form, warm up adequately, and have a spotter when working with heavy weights. `;
            analysis += `Test your 1RM every 4-12 weeks depending on training level. Progressive overload is key to strength gains.`;

            // Update UI
            document.getElementById('ormResult').textContent = `${formatWeight(orm)} ${unit}`;
            document.getElementById('exerciseName').textContent = `${formulaName} formula`;
            document.getElementById('ormDisplay').textContent = `${formatWeight(orm)} ${unit}`;
            document.getElementById('percent90').textContent = `${formatWeight(p90)} ${unit}`;
            document.getElementById('percent80').textContent = `${formatWeight(p80)} ${unit}`;
            document.getElementById('percent70').textContent = `${formatWeight(p70)} ${unit}`;

            document.getElementById('exerciseDisplay').textContent = exerciseNames[exercise];
            document.getElementById('weightDisplay').textContent = `${weight} ${unit}`;
            document.getElementById('repsDisplay').textContent = `${reps} rep${reps > 1 ? 's' : ''}`;
            document.getElementById('formulaDisplay').textContent = formulaName;
            document.getElementById('orm1RM').textContent = `${formatWeight(orm)} ${unit}`;

            document.getElementById('brzyckiORM').textContent = `${formatWeight(brzyckiORM)} ${unit}`;
            document.getElementById('epleyORM').textContent = `${formatWeight(epleyORM)} ${unit}`;
            document.getElementById('lombardiORM').textContent = `${formatWeight(lombardiORM)} ${unit}`;
            document.getElementById('mayhewORM').textContent = `${formatWeight(mayhewORM)} ${unit}`;
            document.getElementById('oconnerORM').textContent = `${formatWeight(oconnerORM)} ${unit}`;
            document.getElementById('wathanORM').textContent = `${formatWeight(wathanORM)} ${unit}`;
            document.getElementById('averageORM').textContent = `${formatWeight(averageORM)} ${unit}`;

            document.getElementById('p100').textContent = `${formatWeight(p100)} ${unit} × 1 rep`;
            document.getElementById('p95').textContent = `${formatWeight(p95)} ${unit} × 2 reps`;
            document.getElementById('p90').textContent = `${formatWeight(p90)} ${unit} × 3-4 reps`;
            document.getElementById('p85').textContent = `${formatWeight(p85)} ${unit} × 4-6 reps`;
            document.getElementById('p80').textContent = `${formatWeight(p80)} ${unit} × 5-7 reps`;
            document.getElementById('p75').textContent = `${formatWeight(p75)} ${unit} × 7-10 reps`;
            document.getElementById('p70').textContent = `${formatWeight(p70)} ${unit} × 8-12 reps`;
            document.getElementById('p65').textContent = `${formatWeight(p65)} ${unit} × 10-15 reps`;
            document.getElementById('p60').textContent = `${formatWeight(p60)} ${unit} × 12-20 reps`;

            document.getElementById('rep1').textContent = `${formatWeight(rep1)} ${unit}`;
            document.getElementById('rep2').textContent = `${formatWeight(rep2)} ${unit}`;
            document.getElementById('rep3').textContent = `${formatWeight(rep3)} ${unit}`;
            document.getElementById('rep4').textContent = `${formatWeight(rep4)} ${unit}`;
            document.getElementById('rep5').textContent = `${formatWeight(rep5)} ${unit}`;
            document.getElementById('rep6').textContent = `${formatWeight(rep6)} ${unit}`;
            document.getElementById('rep8').textContent = `${formatWeight(rep8)} ${unit}`;
            document.getElementById('rep10').textContent = `${formatWeight(rep10)} ${unit}`;
            document.getElementById('rep12').textContent = `${formatWeight(rep12)} ${unit}`;

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            calculateORM();
        });
    </script>
</body>
</html>