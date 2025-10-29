<?php
/**
 * Sleep Time Calculator
 * File: sleep-time-calculator.php
 * Description: Calculate optimal sleep and wake times based on sleep cycles
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sleep Time Calculator - Sleep Cycle Calculator (Wake Up Time & Bedtime)</title>
    <meta name="description" content="Free sleep time calculator. Calculate optimal bedtime and wake-up time based on 90-minute sleep cycles. Wake up refreshed, not groggy.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>😴 Sleep Time Calculator</h1>
        <p>Calculate optimal sleep & wake times</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Sleep Information</h2>
                <form id="sleepForm">
                    <div class="form-group">
                        <label for="calculationType">I want to calculate</label>
                        <select id="calculationType">
                            <option value="bedtime">Bedtime (I know when to wake up)</option>
                            <option value="waketime">Wake Time (I know when I'll sleep)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Time Details</h3>
                    
                    <div class="form-group" id="wakeTimeGroup">
                        <label for="wakeTime">Wake Up Time</label>
                        <input type="time" id="wakeTime" value="07:00" required>
                        <small>What time do you need to wake up?</small>
                    </div>
                    
                    <div class="form-group" id="bedTimeGroup" style="display: none;">
                        <label for="bedTime">Bedtime</label>
                        <input type="time" id="bedTime" value="23:00">
                        <small>What time will you go to bed?</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="fallAsleepTime">Time to Fall Asleep (minutes)</label>
                        <input type="number" id="fallAsleepTime" value="15" min="5" max="60" step="5">
                        <small>Average time to fall asleep (10-20 min typical)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Sleep Times</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Sleep Results</h2>
                
                <div class="result-card success">
                    <h3 id="resultTitle">Recommended Bedtime</h3>
                    <div class="amount" id="primaryTime">11:15 PM</div>
                    <div style="margin-top: 10px; font-size: 1em;" id="cyclesInfo">6 sleep cycles (9 hours)</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Sleep Cycles</h4>
                        <div class="value" id="cyclesDisplay">6</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Sleep</h4>
                        <div class="value" id="totalSleepDisplay">9h</div>
                    </div>
                    <div class="metric-card">
                        <h4>Bedtime</h4>
                        <div class="value" id="bedtimeDisplay">11:15 PM</div>
                    </div>
                    <div class="metric-card">
                        <h4>Wake Time</h4>
                        <div class="value" id="waketimeDisplay">7:00 AM</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Sleep Schedule</h3>
                    <div class="breakdown-item">
                        <span>Wake Up Time</span>
                        <strong id="wakeDisplay">7:00 AM</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Time to Fall Asleep</span>
                        <strong id="fallAsleepDisplay">15 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Sleep Cycle Length</span>
                        <strong>90 minutes each</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Recommended Cycles</span>
                        <strong id="recommendedCycles">5-6 cycles (7.5-9 hours)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Optimal Bedtimes (Wake at <span id="wakeTimeText">7:00 AM</span>)</h3>
                    <div class="breakdown-item">
                        <span>6 Cycles (9 hours sleep)</span>
                        <strong id="option6" style="color: #4CAF50; font-size: 1.05em;">11:15 PM - Ideal ⭐</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>5 Cycles (7.5 hours sleep)</span>
                        <strong id="option5" style="color: #4CAF50;">12:45 AM - Good</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>4 Cycles (6 hours sleep)</span>
                        <strong id="option4" style="color: #FF9800;">2:15 AM - Minimum</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>3 Cycles (4.5 hours sleep)</span>
                        <strong id="option3" style="color: #f44336;">3:45 AM - Not Enough</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Optimal Wake Times (Sleep at <span id="bedTimeText">11:00 PM</span>)</h3>
                    <div class="breakdown-item">
                        <span>6 Cycles (9 hours sleep)</span>
                        <strong id="wake6" style="color: #4CAF50; font-size: 1.05em;">8:00 AM - Ideal ⭐</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>5 Cycles (7.5 hours sleep)</span>
                        <strong id="wake5" style="color: #4CAF50;">6:30 AM - Good</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>4 Cycles (6 hours sleep)</span>
                        <strong id="wake4" style="color: #FF9800;">5:00 AM - Minimum</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>3 Cycles (4.5 hours sleep)</span>
                        <strong id="wake3" style="color: #f44336;">3:30 AM - Not Enough</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Sleep Duration by Age</h3>
                    <div class="breakdown-item">
                        <span>Newborns (0-3 months)</span>
                        <strong>14-17 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Infants (4-11 months)</span>
                        <strong>12-15 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Toddlers (1-2 years)</span>
                        <strong>11-14 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Preschool (3-5 years)</span>
                        <strong>10-13 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>School Age (6-13 years)</span>
                        <strong>9-11 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Teens (14-17 years)</span>
                        <strong>8-10 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Young Adults (18-25 years)</span>
                        <strong style="color: #4CAF50;">7-9 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Adults (26-64 years)</span>
                        <strong style="color: #4CAF50;">7-9 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Older Adults (65+ years)</span>
                        <strong>7-8 hours</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Understanding Sleep Cycles</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>What is a Sleep Cycle?</strong> Complete progression through all sleep stages. Averages 90 minutes. Repeats 4-6 times per night.</p>
                        <p><strong>Sleep Stages in Each Cycle:</strong></p>
                        <p>• <strong>Stage 1 (NREM 1):</strong> Light sleep, transition. 5-10 minutes. Easy to wake, may feel like falling.</p>
                        <p>• <strong>Stage 2 (NREM 2):</strong> True sleep begins. 10-25 minutes. Body temperature drops, heart rate slows. Most of night spent here.</p>
                        <p>• <strong>Stage 3 (NREM 3 - Deep Sleep):</strong> Slow-wave sleep. 20-40 minutes. Hard to wake. Body repairs tissues, strengthens immune system. Most restorative stage.</p>
                        <p>• <strong>REM Sleep:</strong> Rapid eye movement. 10-60 minutes (longer in later cycles). Vivid dreams. Brain consolidates memories, processes emotions. Muscles paralyzed.</p>
                        <p><strong>Why 90 Minutes?</strong> Average cycle length. Waking at end of cycle = feel refreshed. Waking mid-cycle = groggy, sleep inertia.</p>
                        <p><strong>Complete Cycles Matter:</strong> Better to sleep 4.5 hours (3 cycles) than 5 hours (incomplete cycle). Quality over quantity.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Why You Wake Up Groggy</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Sleep Inertia:</strong> Grogginess when waking during deep sleep (Stage 3) or mid-cycle. Brain still in sleep mode. Can last 5-30 minutes.</p>
                        <p><strong>Wrong Timing:</strong> Waking during deep sleep vs light sleep makes huge difference. Even 15-20 minutes can matter.</p>
                        <p><strong>Sleep Debt:</strong> Chronic insufficient sleep. Accumulates over days/weeks. Can't be fully repaid with one good night.</p>
                        <p><strong>Inconsistent Schedule:</strong> Different sleep/wake times daily. Disrupts circadian rhythm. Body doesn't know when to be alert.</p>
                        <p><strong>Poor Sleep Quality:</strong> Frequent wake-ups, alcohol, sleep apnea, poor environment. Prevents reaching deep sleep stages.</p>
                        <p><strong>Solution:</strong> Use this calculator to time sleep cycles. Wake during light sleep (end of cycle). Set consistent schedule. Allow time to fully wake before driving/working.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Sleep Hygiene Best Practices</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p>&#10003; <strong>Consistent Schedule:</strong> Same bedtime/wake time every day, including weekends. Regulates circadian rhythm. Most important factor.</p>
                        <p>&#10003; <strong>Dark Environment:</strong> Blackout curtains, eye mask. Darkness triggers melatonin. Even small light disrupts sleep.</p>
                        <p>&#10003; <strong>Cool Temperature:</strong> 60-67°F (15-19°C) ideal. Body temperature drops during sleep. Hot room prevents this.</p>
                        <p>&#10003; <strong>No Screens 1 Hour Before Bed:</strong> Blue light suppresses melatonin. Use night mode/blue light filters if must use. Read physical books instead.</p>
                        <p>&#10003; <strong>No Caffeine After 2 PM:</strong> Half-life 5-6 hours. Even if you "tolerate it well," affects sleep quality. Includes coffee, tea, soda, chocolate.</p>
                        <p>&#10003; <strong>Exercise Regularly:</strong> 30 min daily. Not within 3 hours of bedtime. Improves deep sleep. Reduces time to fall asleep.</p>
                        <p>&#10003; <strong>No Alcohol Before Bed:</strong> Disrupts REM sleep. Causes frequent wake-ups. Dehydration. "Nightcap" is myth - worsens sleep.</p>
                        <p>&#10003; <strong>Wind-Down Routine:</strong> 30-60 min before bed. Reading, meditation, gentle stretching. Signals body it's sleep time.</p>
                        <p>&#10003; <strong>Comfortable Bed:</strong> Replace mattress every 7-10 years. Good pillows. Quality bedding. Worth investment - spend ⅓ life sleeping.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Effects of Sleep Deprivation</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Short-Term Effects (&lt;1 week):</strong></p>
                        <p>• Impaired cognitive function, memory, decision-making</p>
                        <p>• Increased irritability, mood swings, anxiety</p>
                        <p>• Reduced reaction time (equivalent to drunk driving)</p>
                        <p>• Weakened immune system, more likely to get sick</p>
                        <p>• Increased appetite, cravings for junk food</p>
                        <p>• Microsleeps - brief 1-2 second sleep episodes while awake</p>
                        <p><strong>Long-Term Effects (Chronic):</strong></p>
                        <p>• Increased risk of heart disease, high blood pressure, stroke</p>
                        <p>• Type 2 diabetes risk - insulin resistance increases</p>
                        <p>• Weight gain, obesity - disrupted hunger hormones (leptin, ghrelin)</p>
                        <p>• Depression, anxiety disorders</p>
                        <p>• Weakened immune system, frequent illness</p>
                        <p>• Reduced life expectancy</p>
                        <p>• Alzheimer's risk - brain doesn't clear waste properly</p>
                        <p><strong>Performance Impact:</strong> Less than 6 hours for 2 weeks = cognitive impairment equivalent to 48 hours no sleep.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Common Sleep Disorders</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>Insomnia:</strong> Difficulty falling/staying asleep. Most common disorder. Affects 30% adults. Treat with CBT-I (cognitive behavioral therapy), sleep hygiene.</p>
                        <p><strong>Sleep Apnea:</strong> Breathing repeatedly stops during sleep. Loud snoring, gasping. Daytime fatigue. Risk: obesity, age, neck size. Treat with CPAP machine.</p>
                        <p><strong>Restless Leg Syndrome (RLS):</strong> Uncomfortable sensations in legs, urge to move. Worsens at night. Prevents falling asleep. May need medication, iron supplements.</p>
                        <p><strong>Narcolepsy:</strong> Sudden sleep attacks during day. Excessive daytime sleepiness. Cataplexy (sudden muscle weakness). Neurological disorder. Requires medication.</p>
                        <p><strong>Circadian Rhythm Disorders:</strong> Delayed/advanced sleep phase. Jet lag. Shift work disorder. Body clock misaligned. Light therapy, melatonin supplements help.</p>
                        <p><strong>When to See Doctor:</strong> Chronic difficulty sleeping (3+ nights/week for 3+ months), loud snoring with pauses, extreme daytime sleepiness, falling asleep at inappropriate times.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Sleep Tips:</strong> Sleep cycle = 90 minutes. Complete 4-6 cycles nightly. Adults need 7-9 hours (5-6 cycles). Wake at cycle end = refreshed. Wake mid-cycle = groggy. Calculate backwards from wake time. Add 15 min to fall asleep. Consistent schedule most important. Same bedtime/wake time daily. Dark room (blackout curtains). Cool temp 60-67°F. No screens 1 hour before bed (blue light). No caffeine after 2 PM. Exercise daily but not near bedtime. Wind-down routine 30-60 min before. Sleep deprivation = impaired driving, weight gain, health risks. Quality matters over quantity. Can't catch up on weekends. Sleep debt accumulates. See doctor if chronic insomnia, loud snoring, extreme fatigue. Prioritize sleep - affects everything!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('sleepForm');
        const calculationType = document.getElementById('calculationType');

        calculationType.addEventListener('change', function() {
            toggleTimeFields();
            calculateSleep();
        });

        function toggleTimeFields() {
            const type = calculationType.value;
            document.getElementById('wakeTimeGroup').style.display = type === 'bedtime' ? 'block' : 'none';
            document.getElementById('bedTimeGroup').style.display = type === 'waketime' ? 'block' : 'none';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateSleep();
        });

        function formatTime(date) {
            let hours = date.getHours();
            const minutes = date.getMinutes();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            const minutesStr = minutes < 10 ? '0' + minutes : minutes;
            return hours + ':' + minutesStr + ' ' + ampm;
        }

        function formatTime24(date) {
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return hours + ':' + minutes;
        }

        function addMinutes(date, minutes) {
            return new Date(date.getTime() + minutes * 60000);
        }

        function calculateSleep() {
            const type = calculationType.value;
            const fallAsleepMinutes = parseInt(document.getElementById('fallAsleepTime').value) || 15;
            const cycleLength = 90; // minutes per cycle

            let times = [];
            let referenceTime;
            let referenceLabel;

            if (type === 'bedtime') {
                // Calculate bedtime options based on wake time
                const wakeTimeStr = document.getElementById('wakeTime').value;
                const [wakeHours, wakeMinutes] = wakeTimeStr.split(':').map(Number);
                
                const wakeTime = new Date();
                wakeTime.setHours(wakeHours, wakeMinutes, 0, 0);
                
                referenceTime = formatTime(wakeTime);
                referenceLabel = 'Wake Up Time';

                // Calculate bedtimes for different cycle counts
                for (let cycles = 6; cycles >= 3; cycles--) {
                    const totalSleepMinutes = cycles * cycleLength;
                    const totalMinutes = totalSleepMinutes + fallAsleepMinutes;
                    
                    const bedtime = new Date(wakeTime.getTime() - totalMinutes * 60000);
                    
                    times.push({
                        cycles: cycles,
                        hours: totalSleepMinutes / 60,
                        bedtime: bedtime,
                        waketime: wakeTime
                    });
                }

                document.getElementById('resultTitle').textContent = 'Recommended Bedtime';
                document.getElementById('wakeTimeText').textContent = formatTime(wakeTime);
                
            } else {
                // Calculate wake time options based on bedtime
                const bedTimeStr = document.getElementById('bedTime').value;
                const [bedHours, bedMinutes] = bedTimeStr.split(':').map(Number);
                
                const bedTime = new Date();
                bedTime.setHours(bedHours, bedMinutes, 0, 0);
                
                // Add fall asleep time
                const sleepTime = addMinutes(bedTime, fallAsleepMinutes);
                
                referenceTime = formatTime(bedTime);
                referenceLabel = 'Bedtime';

                // Calculate wake times for different cycle counts
                for (let cycles = 6; cycles >= 3; cycles--) {
                    const totalSleepMinutes = cycles * cycleLength;
                    const waketime = addMinutes(sleepTime, totalSleepMinutes);
                    
                    times.push({
                        cycles: cycles,
                        hours: totalSleepMinutes / 60,
                        bedtime: bedTime,
                        waketime: waketime
                    });
                }

                document.getElementById('resultTitle').textContent = 'Recommended Wake Time';
                document.getElementById('bedTimeText').textContent = formatTime(bedTime);
            }

            // Get optimal time (6 cycles or 5 cycles)
            const optimal = times[0]; // 6 cycles
            const primaryTime = type === 'bedtime' ? optimal.bedtime : optimal.waketime;

            // Analysis
            let analysis = '';
            if (type === 'bedtime') {
                analysis = `To wake up at ${formatTime(optimal.waketime)} feeling refreshed, `;
                analysis += `you should go to bed at ${formatTime(optimal.bedtime)}. `;
                analysis += `This allows for ${optimal.cycles} complete sleep cycles (${optimal.hours} hours of sleep) `;
                analysis += `plus ${fallAsleepMinutes} minutes to fall asleep. `;
                
                analysis += `Each sleep cycle is approximately 90 minutes and includes light sleep, deep sleep, and REM sleep stages. `;
                analysis += `Waking at the end of a complete cycle (rather than in the middle) helps you feel more refreshed and alert. `;
                
                analysis += `If ${formatTime(optimal.bedtime)} is too early, try ${formatTime(times[1].bedtime)} for 5 cycles (${times[1].hours} hours), `;
                analysis += `but aim for at least 7-9 hours of sleep for optimal health. `;
                
                analysis += `Avoid waking during deep sleep stages - this causes grogginess (sleep inertia) that can last 30+ minutes. `;
            } else {
                analysis = `If you go to bed at ${formatTime(optimal.bedtime)}, `;
                analysis += `you should set your alarm for ${formatTime(optimal.waketime)} to wake after ${optimal.cycles} complete sleep cycles (${optimal.hours} hours). `;
                analysis += `This timing accounts for ${fallAsleepMinutes} minutes to fall asleep. `;
                
                analysis += `Alternative wake times: ${formatTime(times[1].waketime)} (5 cycles, ${times[1].hours} hours) `;
                analysis += `or ${formatTime(times[2].waketime)} (4 cycles, ${times[2].hours} hours). `;
                
                analysis += `Waking at these specific times aligns with the end of a complete sleep cycle, `;
                analysis += `when you're in light sleep rather than deep sleep, making it easier to wake up feeling refreshed. `;
            }
            
            analysis += `Remember: consistency is key. Try to maintain the same sleep/wake schedule every day, including weekends. `;
            analysis += `Create a dark, cool (60-67°F) sleep environment, avoid screens 1 hour before bed, and establish a relaxing wind-down routine. `;
            analysis += `If you consistently feel tired despite following these recommendations, consult a healthcare provider about possible sleep disorders.`;

            // Update UI
            document.getElementById('primaryTime').textContent = formatTime(primaryTime);
            document.getElementById('cyclesInfo').textContent = `${optimal.cycles} sleep cycles (${optimal.hours} hours)`;
            document.getElementById('cyclesDisplay').textContent = optimal.cycles;
            document.getElementById('totalSleepDisplay').textContent = `${optimal.hours}h`;
            document.getElementById('bedtimeDisplay').textContent = formatTime(optimal.bedtime);
            document.getElementById('waketimeDisplay').textContent = formatTime(optimal.waketime);

            document.getElementById('wakeDisplay').textContent = formatTime(optimal.waketime);
            document.getElementById('fallAsleepDisplay').textContent = `${fallAsleepMinutes} minutes`;
            document.getElementById('recommendedCycles').textContent = '5-6 cycles (7.5-9 hours)';

            if (type === 'bedtime') {
                document.getElementById('option6').textContent = `${formatTime(times[0].bedtime)} - Ideal ⭐`;
                document.getElementById('option5').textContent = `${formatTime(times[1].bedtime)} - Good`;
                document.getElementById('option4').textContent = `${formatTime(times[2].bedtime)} - Minimum`;
                document.getElementById('option3').textContent = `${formatTime(times[3].bedtime)} - Not Enough`;
            } else {
                document.getElementById('wake6').textContent = `${formatTime(times[0].waketime)} - Ideal ⭐`;
                document.getElementById('wake5').textContent = `${formatTime(times[1].waketime)} - Good`;
                document.getElementById('wake4').textContent = `${formatTime(times[2].waketime)} - Minimum`;
                document.getElementById('wake3').textContent = `${formatTime(times[3].waketime)} - Not Enough`;
            }

            document.getElementById('analysisText').textContent = analysis;
        }

        window.addEventListener('load', function() {
            toggleTimeFields();
            calculateSleep();
        });
    </script>
</body>
</html>