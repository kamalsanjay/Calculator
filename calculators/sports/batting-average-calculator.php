<?php
/**
 * Batting Average Calculator
 * File: sports/batting-average-calculator.php
 * Description: Calculate baseball/softball batting statistics
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batting Average Calculator - Professional Baseball Statistics</title>
    <meta name="description" content="Calculate batting average, on-base percentage, slugging percentage, and other key baseball statistics.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #8B4513; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-section { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-bottom: 30px; }
        
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { display: flex; }
        .input-wrapper input { flex: 1; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #8B4513; box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1); }
        
        .calculate-btn { background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%); color: white; border: none; border-radius: 10px; padding: 16px 30px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin-top: 10px; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(139, 69, 19, 0.3); }
        
        .results-section { display: none; margin-top: 30px; }
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .result-card { background: linear-gradient(135deg, #F5F5DC 0%, #DEB887 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #8B4513; text-align: center; }
        .result-label { color: #8B4513; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.3rem; font-weight: bold; color: #A0522D; }
        
        .advanced-stats { margin-top: 25px; }
        .stats-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .stats-table th, .stats-table td { padding: 12px; text-align: center; border-bottom: 1px solid #e0e0e0; }
        .stats-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .stats-table tr:nth-child(even) { background: #f8f9fa; }
        .stats-table tr:hover { background: #F5F5DC; }
        
        .performance-levels { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .performance-levels h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .levels-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .level-card { background: white; padding: 15px; border-radius: 8px; border-left: 4px solid #8B4513; }
        .level-name { font-weight: bold; color: #A0522D; margin-bottom: 5px; }
        .level-range { color: #8B4513; font-size: 0.9rem; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .formula-box { background: #F5F5DC; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #8B4513; }
        .formula-box strong { color: #8B4513; }
        
        .comparison-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .comparison-table th, .comparison-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .comparison-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .comparison-table tr:hover { background: #F5F5DC; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-section { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .stats-table { font-size: 0.8rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚾ Batting Average Calculator</h1>
            <p>Calculate batting statistics including average, on-base percentage, slugging, and OPS</p>
        </div>

        <div class="calculator-card">
            <div class="input-section">
                <div class="input-group">
                    <label for="atBats">At Bats (AB)</label>
                    <input type="number" id="atBats" placeholder="Enter at bats" value="100" min="0">
                </div>
                
                <div class="input-group">
                    <label for="hits">Hits (H)</label>
                    <input type="number" id="hits" placeholder="Enter hits" value="30" min="0">
                </div>
                
                <div class="input-group">
                    <label for="walks">Walks (BB)</label>
                    <input type="number" id="walks" placeholder="Enter walks" value="10" min="0">
                </div>
            </div>
            
            <div class="input-section">
                <div class="input-group">
                    <label for="singles">Singles (1B)</label>
                    <input type="number" id="singles" placeholder="Enter singles" value="20" min="0">
                </div>
                
                <div class="input-group">
                    <label for="doubles">Doubles (2B)</label>
                    <input type="number" id="doubles" placeholder="Enter doubles" value="5" min="0">
                </div>
                
                <div class="input-group">
                    <label for="triples">Triples (3B)</label>
                    <input type="number" id="triples" placeholder="Enter triples" value="2" min="0">
                </div>
            </div>
            
            <div class="input-section">
                <div class="input-group">
                    <label for="homeruns">Home Runs (HR)</label>
                    <input type="number" id="homeruns" placeholder="Enter home runs" value="3" min="0">
                </div>
                
                <div class="input-group">
                    <label for="sacrifices">Sacrifice Flies (SF)</label>
                    <input type="number" id="sacrifices" placeholder="Enter sacrifice flies" value="2" min="0">
                </div>
                
                <div class="input-group">
                    <label for="hitByPitch">Hit By Pitch (HBP)</label>
                    <input type="number" id="hitByPitch" placeholder="Enter HBP" value="1" min="0">
                </div>
            </div>
            
            <button class="calculate-btn" onclick="calculateStats()">Calculate Batting Statistics</button>
            
            <div class="results-section" id="resultsSection">
                <div class="results-grid">
                    <div class="result-card">
                        <div class="result-label">Batting Average (AVG)</div>
                        <div class="result-value" id="battingAvg">.---</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">On-Base % (OBP)</div>
                        <div class="result-value" id="onBasePct">.---</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">Slugging % (SLG)</div>
                        <div class="result-value" id="sluggingPct">.---</div>
                    </div>
                    <div class="result-card">
                        <div class="result-label">On-Base + Slugging (OPS)</div>
                        <div class="result-value" id="ops">.---</div>
                    </div>
                </div>
                
                <div class="advanced-stats">
                    <h3>📊 Advanced Statistics</h3>
                    <table class="stats-table" id="statsTable">
                        <thead>
                            <tr>
                                <th>Statistic</th>
                                <th>Value</th>
                                <th>Formula</th>
                                <th>Interpretation</th>
                            </tr>
                        </thead>
                        <tbody id="statsBody">
                            <!-- Stats will be populated here -->
                        </tbody>
                    </table>
                </div>
                
                <div class="performance-levels">
                    <h3>🎯 Performance Levels</h3>
                    <div class="levels-grid">
                        <div class="level-card">
                            <div class="level-name">Elite Hitter</div>
                            <div class="level-range">.300+ AVG</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">All-Star caliber</div>
                        </div>
                        <div class="level-card">
                            <div class="level-name">Above Average</div>
                            <div class="level-range">.275 - .299</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">Solid contributor</div>
                        </div>
                        <div class="level-card">
                            <div class="level-name">Average</div>
                            <div class="level-range">.250 - .274</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">MLB regular</div>
                        </div>
                        <div class="level-card">
                            <div class="level-name">Below Average</div>
                            <div class="level-range">.225 - .249</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">Bench player</div>
                        </div>
                        <div class="level-card">
                            <div class="level-name">Poor Hitter</div>
                            <div class="level-range">.200 - .224</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">Defensive specialist</div>
                        </div>
                        <div class="level-card">
                            <div class="level-name">Mendoza Line</div>
                            <div class="level-range">Below .200</div>
                            <div style="font-size: 0.8rem; color: #7f8c8d;">At risk of demotion</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⚾ Understanding Batting Statistics</h2>
            
            <p>Batting statistics are essential for evaluating a baseball or softball player's offensive performance. Modern analytics use multiple metrics to provide a comprehensive picture of a hitter's abilities.</p>

            <h3>📊 Key Batting Statistics Explained</h3>
            <div class="formula-box">
                <strong>Batting Average (AVG) = Hits ÷ At Bats</strong><br>
                The traditional measure of hitting success<br><br>
                
                <strong>On-Base Percentage (OBP) = (Hits + Walks + HBP) ÷ (At Bats + Walks + HBP + SF)</strong><br>
                Measures how often a player reaches base<br><br>
                
                <strong>Slugging Percentage (SLG) = Total Bases ÷ At Bats</strong><br>
                Measures power hitting (1B=1, 2B=2, 3B=3, HR=4)<br><br>
                
                <strong>OPS = OBP + SLG</strong><br>
                Combined measure of getting on base and power
            </div>

            <h3>🏆 Historical Batting Average Standards</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Level</th>
                        <th>Elite</th>
                        <th>Excellent</th>
                        <th>Average</th>
                        <th>Poor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>MLB</td><td>.330+</td><td>.300-.329</td><td>.250-.299</td><td>.240 or less</td></tr>
                    <tr><td>AAA</td><td>.320+</td><td>.290-.319</td><td>.260-.289</td><td>.250 or less</td></tr>
                    <tr><td>AA</td><td>.310+</td><td>.280-.309</td><td>.250-.279</td><td>.240 or less</td></tr>
                    <tr><td>College</td><td>.380+</td><td>.340-.379</td><td>.300-.339</td><td>.290 or less</td></tr>
                    <tr><td>High School</td><td>.450+</td><td>.400-.449</td><td>.350-.399</td><td>.340 or less</td></tr>
                </tbody>
            </table>

            <h3>🎯 Modern Baseball Analytics</h3>
            <div class="formula-box">
                <strong>wOBA (Weighted On-Base Average):</strong> More accurate than OBP as it weights different types of hits appropriately<br><br>
                <strong>BABIP (Batting Average on Balls In Play):</strong> Measures batting average excluding strikeouts and home runs<br><br>
                <strong>ISO (Isolated Power):</strong> SLG minus AVG - measures pure power<br><br>
                <strong>wRC+ (Weighted Runs Created Plus):</strong> Overall offensive value compared to league average (100 is average)
            </div>

            <h3>📈 All-Time Great Batting Averages</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Player</th>
                        <th>Career AVG</th>
                        <th>Best Season</th>
                        <th>Years Active</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Ty Cobb</td><td>.366</td><td>.420 (1911)</td><td>1905-1928</td></tr>
                    <tr><td>Rogers Hornsby</td><td>.358</td><td>.424 (1924)</td><td>1915-1937</td></tr>
                    <tr><td>Joe Jackson</td><td>.356</td><td>.408 (1911)</td><td>1908-1920</td></tr>
                    <tr><td>Ted Williams</td><td>.344</td><td>.406 (1941)</td><td>1939-1960</td></tr>
                    <tr><td>Tony Gwynn</td><td>.338</td><td>.394 (1994)</td><td>1982-2001</td></tr>
                </tbody>
            </table>

            <h3>⚾ The Mendoza Line</h3>
            <p>The "Mendoza Line" refers to a .200 batting average, named after Mario Mendoza, a shortstop who typically batted around this mark. It's considered the threshold below which a position player's batting performance is unacceptable at the major league level.</p>

            <h3>📊 OPS Interpretation Guide</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>OPS Range</th>
                        <th>Classification</th>
                        <th>MLB Examples</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1.000+</td><td>MVP Caliber</td><td>Mike Trout, Barry Bonds</td></tr>
                    <tr><td>.900-.999</td><td>All-Star</td><td>Mookie Betts, Freddie Freeman</td></tr>
                    <tr><td>.800-.899</td><td>Above Average</td><td>Jose Altuve, Nolan Arenado</td></tr>
                    <tr><td>.700-.799</td><td>Average</td><td>Most MLB regulars</td></tr>
                    <tr><td>.600-.699</td><td>Below Average</td><td>Defensive specialists</td></tr>
                    <tr><td>Below .600</td><td>Poor</td><td>Pitchers, emergency players</td></tr>
                </tbody>
            </table>

            <h3>🔢 Total Bases Calculation</h3>
            <div class="formula-box">
                <strong>Total Bases = Singles + (2 × Doubles) + (3 × Triples) + (4 × Home Runs)</strong><br><br>
                <strong>Example:</strong> 15 singles + 5 doubles + 2 triples + 3 home runs<br>
                Total Bases = 15 + (2×5) + (3×2) + (4×3) = 15 + 10 + 6 + 12 = 43
            </div>

            <h3>🎓 Statistical Milestones</h3>
            <ul>
                <li><strong>.400 Season:</strong> Last achieved by Ted Williams in 1941</li>
                <li><strong>.300 Career:</strong> Hall of Fame consideration threshold</li>
                <li><strong>3,000 Hits:</strong> Automatic Hall of Fame candidate</li>
                <li><strong>500 Home Runs:</strong> Power hitter milestone</li>
                <li><strong>.300/.400/.500:</strong> The "triple slash" of an elite hitter</li>
            </ul>

            <h3>🏅 League Average Statistics (MLB 2023)</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Statistic</th>
                        <th>MLB Average</th>
                        <th>American League</th>
                        <th>National League</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Batting Average</td><td>.248</td><td>.247</td><td>.250</td></tr>
                    <tr><td>On-Base Percentage</td><td>.320</td><td>.319</td><td>.321</td></tr>
                    <tr><td>Slugging Percentage</td><td>.414</td><td>.412</td><td>.416</td></tr>
                    <tr><td>OPS</td><td>.734</td><td>.731</td><td>.737</td></tr>
                    <tr><td>Home Runs per Game</td><td>1.17</td><td>1.16</td><td>1.18</td></tr>
                </tbody>
            </table>

            <h3>💡 Improving Your Batting Average</h3>
            <div class="formula-box">
                <strong>Plate Discipline:</strong> Swing at good pitches, take close ones<br>
                <strong>Contact Skills:</strong> Make consistent contact, foul off tough pitches<br>
                <strong>Spray Hitting:</strong> Use all fields instead of pulling everything<br>
                <strong>Two-Strike Approach:</strong> Shorten swing, protect the plate<br>
                <strong>Video Analysis:</strong> Study your swing mechanics regularly<br>
                <strong>Quality Practice:</strong> Face live pitching, use batting tees
            </div>

            <h3>📱 Modern Statistical Tools</h3>
            <p>Today's players and coaches use advanced technology including high-speed cameras, bat sensors, and launch angle monitors to analyze and improve hitting performance. These tools provide data on swing path, exit velocity, and launch angle to optimize hitting mechanics.</p>

            <h3>🎯 Context Matters</h3>
            <p>Remember that batting statistics should be considered in context. A .250 average with 40 home runs is more valuable than a .300 average with 5 home runs. Similarly, a .280 hitter with excellent defense may be more valuable than a .300 hitter with poor defense.</p>
        </div>

        <div class="footer">
            <p>⚾ Batting Average Calculator | Professional Baseball Statistics</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate AVG, OBP, SLG, OPS and other key hitting metrics</p>
        </div>
    </div>

    <script>
        function calculateStats() {
            // Get input values
            const atBats = parseInt(document.getElementById('atBats').value) || 0;
            const hits = parseInt(document.getElementById('hits').value) || 0;
            const walks = parseInt(document.getElementById('walks').value) || 0;
            const singles = parseInt(document.getElementById('singles').value) || 0;
            const doubles = parseInt(document.getElementById('doubles').value) || 0;
            const triples = parseInt(document.getElementById('triples').value) || 0;
            const homeruns = parseInt(document.getElementById('homeruns').value) || 0;
            const sacrifices = parseInt(document.getElementById('sacrifices').value) || 0;
            const hitByPitch = parseInt(document.getElementById('hitByPitch').value) || 0;
            
            // Validate inputs
            if (atBats <= 0) {
                alert('Please enter a valid number of at bats');
                return;
            }
            
            if (hits > atBats) {
                alert('Hits cannot exceed at bats');
                return;
            }
            
            const calculatedHits = singles + doubles + triples + homeruns;
            if (calculatedHits !== hits && hits > 0) {
                if (!confirm(`The sum of your hits (${calculatedHits}) doesn't match the total hits entered (${hits}). Use the calculated sum?`)) {
                    return;
                }
            }
            
            const totalHits = hits > 0 ? hits : calculatedHits;
            
            // Calculate plate appearances
            const plateAppearances = atBats + walks + hitByPitch + sacrifices;
            
            // Calculate batting average
            const battingAvg = atBats > 0 ? totalHits / atBats : 0;
            
            // Calculate on-base percentage
            const onBasePct = plateAppearances > 0 ? (totalHits + walks + hitByPitch) / plateAppearances : 0;
            
            // Calculate total bases
            const totalBases = singles + (doubles * 2) + (triples * 3) + (homeruns * 4);
            
            // Calculate slugging percentage
            const sluggingPct = atBats > 0 ? totalBases / atBats : 0;
            
            // Calculate OPS
            const ops = onBasePct + sluggingPct;
            
            // Display results
            document.getElementById('battingAvg').textContent = formatAverage(battingAvg);
            document.getElementById('onBasePct').textContent = formatAverage(onBasePct);
            document.getElementById('sluggingPct').textContent = formatAverage(sluggingPct);
            document.getElementById('ops').textContent = formatAverage(ops);
            
            // Display advanced stats
            displayAdvancedStats(totalHits, atBats, plateAppearances, totalBases, walks, hitByPitch, sacrifices);
            
            // Show results section
            document.getElementById('resultsSection').style.display = 'block';
        }
        
        function formatAverage(value) {
            if (value === 0) return '.000';
            return '.' + Math.round(value * 1000).toString().padStart(3, '0');
        }
        
        function displayAdvancedStats(hits, atBats, plateAppearances, totalBases, walks, hbp, sacrifices) {
            const statsBody = document.getElementById('statsBody');
            statsBody.innerHTML = '';
            
            // Batting Average
            addStatRow(statsBody, 'Batting Average (AVG)', 
                formatAverage(hits / atBats), 
                'Hits ÷ At Bats', 
                'Measures hitting success rate');
            
            // On-Base Percentage
            addStatRow(statsBody, 'On-Base Percentage (OBP)', 
                formatAverage((hits + walks + hbp) / plateAppearances), 
                '(H + BB + HBP) ÷ PA', 
                'Measures how often player reaches base');
            
            // Slugging Percentage
            addStatRow(statsBody, 'Slugging Percentage (SLG)', 
                formatAverage(totalBases / atBats), 
                'Total Bases ÷ At Bats', 
                'Measures power hitting ability');
            
            // OPS
            addStatRow(statsBody, 'On-Base + Slugging (OPS)', 
                formatAverage((hits + walks + hbp) / plateAppearances + totalBases / atBats), 
                'OBP + SLG', 
                'Combined on-base and power metric');
            
            // Isolated Power
            const iso = (totalBases / atBats) - (hits / atBats);
            addStatRow(statsBody, 'Isolated Power (ISO)', 
                formatAverage(iso), 
                'SLG - AVG', 
                'Measures raw power');
            
            // Walk Rate
            addStatRow(statsBody, 'Walk Rate (BB%)', 
                ((walks / plateAppearances) * 100).toFixed(1) + '%', 
                'BB ÷ PA × 100', 
                'Plate discipline indicator');
            
            // Strikeout Rate (estimated)
            const strikeouts = Math.max(0, atBats - hits);
            addStatRow(statsBody, 'Strikeout Rate (K%)', 
                ((strikeouts / plateAppearances) * 100).toFixed(1) + '%', 
                'K ÷ PA × 100', 
                'Contact ability indicator');
            
            // Batting Average on Balls in Play
            const babip = (hits - homeruns) / (atBats - strikeouts - homeruns + sacrifices);
            addStatRow(statsBody, 'BABIP', 
                !isNaN(babip) ? formatAverage(babip) : 'N/A', 
                '(H - HR) ÷ (AB - K - HR + SF)', 
                'Measures luck/skill on balls in play');
        }
        
        function addStatRow(tbody, name, value, formula, interpretation) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><strong>${name}</strong></td>
                <td>${value}</td>
                <td>${formula}</td>
                <td>${interpretation}</td>
            `;
            tbody.appendChild(row);
        }
        
        // Auto-calculate when inputs change
        const inputs = ['atBats', 'hits', 'walks', 'singles', 'doubles', 'triples', 'homeruns', 'sacrifices', 'hitByPitch'];
        inputs.forEach(id => {
            document.getElementById(id).addEventListener('input', calculateStats);
        });
        
        // Initial calculation if values are present
        window.addEventListener('load', function() {
            if (document.getElementById('atBats').value) {
                calculateStats();
            }
        });
    </script>
</body>
</html>
