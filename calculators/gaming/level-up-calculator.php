<?php
/**
 * Level Up Calculator
 * File: gaming/level-up-calculator.php
 * Description: Advanced level progression calculator for RPGs and games with XP systems, stat growth, and progression analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level Up Calculator - Advanced Gaming Progression & XP Analysis</title>
    <meta name="description" content="Professional level progression calculator for RPGs and games with XP systems, stat growth analysis, and progression optimization.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-tabs { display: flex; gap: 10px; margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; flex-wrap: wrap; }
        .tab { padding: 12px 24px; background: #f8f9fa; border: none; border-radius: 8px 8px 0 0; cursor: pointer; transition: all 0.3s; font-weight: 600; color: #7f8c8d; }
        .tab.active { background: #ff9a9e; color: white; }
        
        .input-section { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-bottom: 30px; }
        
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input, .input-wrapper select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus { outline: none; border-color: #ff9a9e; box-shadow: 0 0 0 3px rgba(255, 154, 158, 0.1); }
        
        .character-card { background: #f8f9fa; padding: 25px; border-radius: 15px; border: 3px solid #e9ecef; }
        .character-header { display: flex; justify-content: between; align-items: center; margin-bottom: 20px; }
        .character-title { font-size: 1.3rem; font-weight: bold; color: #2c3e50; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .stat-group { text-align: center; padding: 15px; background: white; border-radius: 10px; border: 2px solid #e0e0e0; }
        .stat-value { font-size: 1.4rem; font-weight: bold; color: #ff9a9e; }
        .stat-label { font-size: 0.8rem; color: #7f8c8d; font-weight: 600; }
        .stat-growth { font-size: 0.7rem; color: #27ae60; margin-top: 5px; }
        
        .calculate-btn { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); color: white; border: none; padding: 16px 32px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin: 20px 0; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 154, 158, 0.3); }
        
        .results-section { margin-top: 30px; }
        .results-section h3 { color: #2c3e50; margin-bottom: 20px; font-size: 1.3rem; }
        
        .level-progress { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); color: white; padding: 30px; border-radius: 15px; text-align: center; margin-bottom: 30px; }
        .progress-title { font-size: 1.8rem; font-weight: bold; margin-bottom: 10px; }
        .progress-subtitle { font-size: 1.1rem; opacity: 0.9; }
        
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .result-card { background: white; padding: 20px; border-radius: 12px; border-left: 4px solid #ff9a9e; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-value { font-size: 1.4rem; font-weight: bold; color: #2c3e50; }
        
        .progression-chart { background: white; border: 2px solid #e0e0e0; border-radius: 12px; padding: 25px; margin: 25px 0; }
        .chart-container { width: 100%; height: 300px; position: relative; }
        
        .stat-evolution { background: #f8f9fa; padding: 25px; border-radius: 12px; margin: 25px 0; }
        .evolution-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        
        .action-buttons { display: flex; gap: 12px; margin-top: 20px; flex-wrap: wrap; }
        .action-btn { padding: 12px 20px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; }
        .action-btn:hover { border-color: #ff9a9e; background: #fff5f5; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .formula-box { background: #fff5f5; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff9a9e; }
        .formula-box strong { color: #ff9a9e; }
        
        .comparison-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .comparison-table th, .comparison-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .comparison-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .comparison-table tr:hover { background: #f5f5f5; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        /* Progress bars */
        .progress-bar { width: 100%; height: 20px; background: #e0e0e0; border-radius: 10px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #ff9a9e, #fecfef); transition: width 0.5s ease; }
        .progress-text { text-align: center; font-size: 0.8rem; color: #7f8c8d; margin-top: 5px; }
        
        /* Level badges */
        .level-badge { display: inline-block; padding: 8px 16px; background: #ff9a9e; color: white; border-radius: 20px; font-weight: bold; margin: 5px; }
        
        @media (max-width: 768px) {
            .input-section { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .calculator-tabs { flex-direction: column; }
            .tab { border-radius: 8px; margin-bottom: 5px; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { flex-direction: column; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        
        /* XP visualization */
        .xp-visualization { width: 100%; height: 120px; background: #f8f9fa; border-radius: 8px; margin: 20px 0; padding: 20px; display: flex; align-items: end; gap: 2px; }
        .xp-bar { background: linear-gradient(to top, #ff9a9e, #fecfef); border-radius: 4px 4px 0 0; position: relative; flex: 1; }
        .bar-label { position: absolute; top: -25px; left: 0; right: 0; text-align: center; font-size: 0.8rem; color: #7f8c8d; }
        
        /* Growth indicators */
        .growth-up { color: #27ae60; }
        .growth-down { color: #e74c3c; }
        .growth-neutral { color: #7f8c8d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📈 Level Up Calculator</h1>
            <p>Advanced level progression calculator for RPGs and games with XP systems, stat growth analysis, and progression optimization</p>
        </div>

        <div class="calculator-card">
            <div class="calculator-tabs">
                <button class="tab active" onclick="switchTab('progression')">Level Progression</button>
                <button class="tab" onclick="switchTab('stats')">Stat Growth</button>
                <button class="tab" onclick="switchTab('optimization')">Optimization</button>
                <button class="tab" onclick="switchTab('comparison')">Class Comparison</button>
            </div>

            <div id="progressionTab" class="tab-content">
                <div class="input-section">
                    <div class="character-card">
                        <div class="character-header">
                            <div class="character-title">🎮 Character Setup</div>
                        </div>
                        
                        <div class="input-grid">
                            <div class="input-group">
                                <label for="currentLevel">Current Level</label>
                                <div class="input-wrapper">
                                    <input type="number" id="currentLevel" value="25" min="1" max="100">
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <label for="currentXP">Current XP</label>
                                <div class="input-wrapper">
                                    <input type="number" id="currentXP" value="12500" min="0">
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <label for="targetLevel">Target Level</label>
                                <div class="input-wrapper">
                                    <input type="number" id="targetLevel" value="50" min="1" max="100">
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <label for="xpRate">XP Gain Rate (/hour)</label>
                                <div class="input-wrapper">
                                    <input type="number" id="xpRate" value="1000" min="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="character-card">
                        <div class="character-header">
                            <div class="character-title">⚡ Game System</div>
                        </div>
                        
                        <div class="input-grid">
                            <div class="input-group">
                                <label for="gameSystem">XP System Type</label>
                                <div class="input-wrapper">
                                    <select id="gameSystem">
                                        <option value="linear">Linear</option>
                                        <option value="exponential" selected>Exponential</option>
                                        <option value="polynomial">Polynomial</option>
                                        <option value="fibonacci">Fibonacci-based</option>
                                        <option value="custom">Custom Formula</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <label for="classType">Character Class</label>
                                <div class="input-wrapper">
                                    <select id="classType">
                                        <option value="warrior">Warrior</option>
                                        <option value="mage">Mage</option>
                                        <option value="rogue">Rogue</option>
                                        <option value="cleric">Cleric</option>
                                        <option value="archer">Archer</option>
                                        <option value="berserker">Berserker</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <label for="difficulty">Game Difficulty</label>
                                <div class="input-wrapper">
                                    <select id="difficulty">
                                        <option value="easy">Easy</option>
                                        <option value="normal" selected>Normal</option>
                                        <option value="hard">Hard</option>
                                        <option value="expert">Expert</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <label for="playStyle">Play Style</label>
                                <div class="input-wrapper">
                                    <select id="playStyle">
                                        <option value="casual">Casual</option>
                                        <option value="balanced" selected>Balanced</option>
                                        <option value="grinding">Grinding</option>
                                        <option value="speedrun">Speed Running</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="statsTab" class="tab-content" style="display: none;">
                <div class="input-section">
                    <div class="character-card">
                        <div class="character-header">
                            <div class="character-title">💪 Base Stats</div>
                        </div>
                        
                        <div class="stats-grid">
                            <div class="stat-group">
                                <div class="stat-value" id="baseHP">150</div>
                                <div class="stat-label">Health</div>
                                <div class="stat-growth" id="hpGrowth">+5/level</div>
                            </div>
                            
                            <div class="stat-group">
                                <div class="stat-value" id="baseMP">80</div>
                                <div class="stat-label">Mana</div>
                                <div class="stat-growth" id="mpGrowth">+3/level</div>
                            </div>
                            
                            <div class="stat-group">
                                <div class="stat-value" id="baseSTR">12</div>
                                <div class="stat-label">Strength</div>
                                <div class="stat-growth" id="strGrowth">+0.8/level</div>
                            </div>
                            
                            <div class="stat-group">
                                <div class="stat-value" id="baseDEX">10</div>
                                <div class="stat-label">Dexterity</div>
                                <div class="stat-growth" id="dexGrowth">+1.2/level</div>
                            </div>
                            
                            <div class="stat-group">
                                <div class="stat-value" id="baseINT">8</div>
                                <div class="stat-label">Intelligence</div>
                                <div class="stat-growth" id="intGrowth">+1.5/level</div>
                            </div>
                            
                            <div class="stat-group">
                                <div class="stat-value" id="baseDEF">15</div>
                                <div class="stat-label">Defense</div>
                                <div class="stat-growth" id="defGrowth">+1.0/level</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="character-card">
                        <div class="character-header">
                            <div class="character-title">📊 Growth Settings</div>
                        </div>
                        
                        <div class="input-grid">
                            <div class="input-group">
                                <label for="growthPattern">Growth Pattern</label>
                                <div class="input-wrapper">
                                    <select id="growthPattern">
                                        <option value="steady">Steady Growth</option>
                                        <option value="accelerating" selected>Accelerating</option>
                                        <option value="decelerating">Decelerating</option>
                                        <option value="sporadic">Sporadic</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <label for="statFocus">Stat Focus</label>
                                <div class="input-wrapper">
                                    <select id="statFocus">
                                        <option value="balanced">Balanced</option>
                                        <option value="offense">Offense</option>
                                        <option value="defense">Defense</option>
                                        <option value="hybrid">Hybrid</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <label for="bonusPoints">Bonus Points/Level</label>
                                <div class="input-wrapper">
                                    <input type="number" id="bonusPoints" value="5" min="0" max="20">
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <label for="prestigeLevel">Prestige Level</label>
                                <div class="input-wrapper">
                                    <input type="number" id="prestigeLevel" value="0" min="0" max="10">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="calculate-btn" onclick="calculateProgression()">📈 Calculate Progression</button>

            <div class="results-section" id="resultsSection" style="display: none;">
                <div class="level-progress">
                    <div class="progress-title" id="progressTitle">Level 25 → 50 Progression</div>
                    <div class="progress-subtitle" id="progressSubtitle">Complete analysis of your leveling journey</div>
                </div>
                
                <div class="results-grid">
                    <div class="result-card">
                        <div class="result-label">Total XP Required</div>
                        <div class="result-value" id="totalXP">0</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">XP Remaining</div>
                        <div class="result-value" id="xpRemaining">0</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Estimated Time</div>
                        <div class="result-value" id="estimatedTime">0h</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Levels to Go</div>
                        <div class="result-value" id="levelsToGo">0</div>
                    </div>
                </div>

                <div class="progression-chart">
                    <h4>📊 XP Progression Chart</h4>
                    <div class="chart-container" id="xpChart">
                        <!-- XP chart will be rendered here -->
                    </div>
                    <div class="progress-text" id="xpProgressText">Current Progress: 0%</div>
                </div>

                <div class="stat-evolution">
                    <h4>💪 Stat Evolution</h4>
                    <div class="evolution-grid" id="statEvolution">
                        <!-- Stat evolution cards will be populated here -->
                    </div>
                </div>

                <div class="progression-chart">
                    <h4>🎯 Level Milestones</h4>
                    <div class="xp-visualization" id="milestoneChart">
                        <!-- Milestone visualization will be populated here -->
                    </div>
                    
                    <table class="comparison-table">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>XP Required</th>
                                <th>Cumulative XP</th>
                                <th>Stat Bonus</th>
                                <th>Unlocks</th>
                            </tr>
                        </thead>
                        <tbody id="milestoneTable">
                            <!-- Milestone data will be populated here -->
                        </tbody>
                    </table>
                </div>

                <div class="action-buttons">
                    <button class="action-btn" onclick="saveProgression()">
                        💾 Save Analysis
                    </button>
                    <button class="action-btn" onclick="exportResults()">
                        📤 Export Data
                    </button>
                    <button class="action-btn" onclick="shareProgression()">
                        🔗 Share Plan
                    </button>
                    <button class="action-btn" onclick="resetCalculator()">
                        🔄 New Calculation
                    </button>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>📈 Advanced Level Progression Systems</h2>
            
            <p>Professional level progression analysis for RPGs and games with comprehensive XP systems, stat growth modeling, and optimization strategies.</p>

            <h3>🎯 XP System Formulas</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>System Type</th>
                        <th>Formula</th>
                        <th>Progression</th>
                        <th>Games Using</th>
                        <th>Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Linear</strong></td>
                        <td>XP = Base × Level</td>
                        <td>Constant growth</td>
                        <td>Classic RPGs</td>
                        <td>Beginner-friendly</td>
                    </tr>
                    <tr>
                        <td><strong>Exponential</strong></td>
                        <td>XP = Base × Level²</td>
                        <td>Rapid scaling</td>
                        <td>Modern RPGs</td>
                        <td>Long-term play</td>
                    </tr>
                    <tr>
                        <td><strong>Polynomial</strong></td>
                        <td>XP = Base × Level¹.⁵</td>
                        <td>Balanced growth</td>
                        <td>MMORPGs</td>
                        <td>Massive scaling</td>
                    </tr>
                    <tr>
                        <td><strong>Fibonacci</strong></td>
                        <td>XP = Fib(Level) × Base</td>
                        <td>Natural progression</td>
                        <td>Indie games</td>
                        <td>Organic feel</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Standard Exponential Formula:</strong><br>
                XP Required for Level N = Base × (Level)^Exponent<br>
                Where Base = 100, Exponent = 2.0 for standard progression<br>
                Cumulative XP = Σ(Base × i^Exponent) from i=1 to N
            </div>

            <h3>⚔️ Class Growth Patterns</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>HP Growth</th>
                        <th>MP Growth</th>
                        <th>Primary Stat</th>
                        <th>Growth Speed</th>
                        <th>Peak Level</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Warrior</strong></td>
                        <td>High (+6/lvl)</td>
                        <td>Low (+2/lvl)</td>
                        <td>Strength</td>
                        <td>Medium</td>
                        <td>60-80</td>
                    </tr>
                    <tr>
                        <td><strong>Mage</strong></td>
                        <td>Low (+3/lvl)</td>
                        <td>Very High (+8/lvl)</td>
                        <td>Intelligence</td>
                        <td>Fast Early</td>
                        <td>40-60</td>
                    </tr>
                    <tr>
                        <td><strong>Rogue</strong></td>
                        <td>Medium (+4/lvl)</td>
                        <td>Medium (+4/lvl)</td>
                        <td>Dexterity</td>
                        <td>Fast</td>
                        <td>50-70</td>
                    </tr>
                    <tr>
                        <td><strong>Cleric</strong></td>
                        <td>Medium (+5/lvl)</td>
                        <td>High (+6/lvl)</td>
                        <td>Wisdom</td>
                        <td>Slow</td>
                        <td>70-90</td>
                    </tr>
                    <tr>
                        <td><strong>Archer</strong></td>
                        <td>Medium (+4/lvl)</td>
                        <td>Low (+3/lvl)</td>
                        <td>Dexterity</td>
                        <td>Very Fast</td>
                        <td>30-50</td>
                    </tr>
                    <tr>
                        <td><strong>Berserker</strong></td>
                        <td>Very High (+8/lvl)</td>
                        <td>Very Low (+1/lvl)</td>
                        <td>Strength</td>
                        <td>Slow Early</td>
                        <td>80-100</td>
                    </tr>
                </tbody>
            </table>

            <h3>📊 Growth Pattern Analysis</h3>
            <div class="formula-box">
                <strong>Growth Pattern Formulas:</strong><br>
                • <strong>Steady:</strong> Stat = Base + (Growth × Level)<br>
                • <strong>Accelerating:</strong> Stat = Base + (Growth × Level^1.2)<br>
                • <strong>Decelerating:</strong> Stat = Base + (Growth × Level^0.8)<br>
                • <strong>Sporadic:</strong> Stat = Base + (Growth × Level) + Random(Level/10)
            </div>

            <h3>🎮 Difficulty Modifiers</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Difficulty</th>
                        <th>XP Multiplier</th>
                        <th>Stat Bonus</th>
                        <th>Enemy Scaling</th>
                        <th>Recommended For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Easy</strong></td>
                        <td>1.5×</td>
                        <td>+10%</td>
                        <td>80%</td>
                        <td>Casual players</td>
                    </tr>
                    <tr>
                        <td><strong>Normal</strong></td>
                        <td>1.0×</td>
                        <td>Base</td>
                        <td>100%</td>
                        <td>Average players</td>
                    </tr>
                    <tr>
                        <td><strong>Hard</strong></td>
                        <td>0.8×</td>
                        <td>-10%</td>
                        <td>120%</td>
                        <td>Experienced players</td>
                    </tr>
                    <tr>
                        <td><strong>Expert</strong></td>
                        <td>0.6×</td>
                        <td>-20%</td>
                        <td>150%</td>
                        <td>Veterans</td>
                    </tr>
                </tbody>
            </table>

            <h3>⏰ Time Investment Analysis</h3>
            <ul>
                <li><strong>Casual Play:</strong> 2-3 hours daily, focuses on story and exploration</li>
                <li><strong>Balanced Play:</strong> 3-5 hours daily, mixes content types</li>
                <li><strong>Grinding Focus:</strong> 5-8 hours daily, optimized XP routes</li>
                <li><strong>Speed Running:</strong> 8+ hours daily, min-max strategies only</li>
            </ul>

            <h3>🔧 Optimization Strategies</h3>
            <div class="formula-box">
                <strong>Efficient Leveling Techniques:</strong><br>
                • <strong>Quest Stacking:</strong> Complete multiple objectives in same area<br>
                • <strong>Rest Bonus:</strong> Rested XP provides 2× gain for limited time<br>
                • <strong>Group Bonus:</strong> Party play provides 10-25% XP bonus<br>
                • <strong>Zone Optimization:</strong> Farm enemies 2-3 levels above for max XP<br>
                • <strong>Event Timing:</strong> Plan play during double XP events
            </div>

            <h3>📈 Prestige & Endgame Systems</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Prestige Level</th>
                        <th>XP Requirement</th>
                        <th>Stat Bonus</th>
                        <th>Unlockables</th>
                        <th>Time Investment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>1</strong></td>
                        <td>Base × 2</td>
                        <td>+5% All Stats</td>
                        <td>Prestige Skills</td>
                        <td>20-30 hours</td>
                    </tr>
                    <tr>
                        <td><strong>2</strong></td>
                        <td>Base × 4</td>
                        <td>+10% All Stats</td>
                        <td>Enhanced Abilities</td>
                        <td>40-60 hours</td>
                    </tr>
                    <tr>
                        <td><strong>3</strong></td>
                        <td>Base × 8</td>
                        <td>+15% All Stats</td>
                        <td>Master Skills</td>
                        <td>80-120 hours</td>
                    </tr>
                    <tr>
                        <td><strong>5+</strong></td>
                        <td>Base × 32+</td>
                        <td>+25% All Stats</td>
                        <td>Legendary Items</td>
                        <td>200+ hours</td>
                    </tr>
                </tbody>
            </table>

            <h3>⚠️ Common Progression Mistakes</h3>
            <ul>
                <li><strong>Over-farming low-level areas:</strong> Diminishing returns on XP</li>
                <li><strong>Ignoring quest chains:</strong> Miss out on bonus XP and rewards</li>
                <li><strong>Poor stat distribution:</strong> Can create unbalanced characters</li>
                <li><strong>Rushing content:</strong> Missing exploration XP and hidden rewards</li>
                <li><strong>Not using rest systems:</strong> Wasting potential XP bonuses</li>
                <li><strong>Skipping tutorials:</strong> Missing fundamental mechanics</li>
            </ul>

            <h3>🎯 Advanced Tips</h3>
            <div class="formula-box">
                <strong>Pro-Level Strategies:</strong><br>
                • <strong>Power Leveling:</strong> Have high-level player carry through content<br>
                • <strong>Zone Knowledge:</strong> Memorize enemy spawns and patrol routes<br>
                • <strong>Gear Optimization:</strong+> Always use best available XP-boosting gear<br>
                • <strong>Daily Routines:</strong> Establish efficient farming routes<br>
                • <strong>Market Playing:</strong> Use in-game economy to buy XP items<br>
                • <strong>Meta Knowledge:</strong> Stay updated on patch changes and new methods
            </div>
        </div>

        <div class="footer">
            <p>📈 Advanced Level Up Calculator | RPG Progression Analysis & Optimization</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">XP systems, stat growth, progression planning, and optimization strategies</p>
        </div>
    </div>

    <script>
        // DOM elements
        const tabs = document.querySelectorAll('.tab');
        const resultsSection = document.getElementById('resultsSection');

        // Class templates with growth patterns
        const classTemplates = {
            'warrior': {
                hp: 150, hpGrowth: 6,
                mp: 80, mpGrowth: 2,
                str: 12, strGrowth: 1.2,
                dex: 10, dexGrowth: 0.8,
                int: 8, intGrowth: 0.5,
                def: 15, defGrowth: 1.0,
                growthSpeed: 'medium',
                peakLevel: 75
            },
            'mage': {
                hp: 90, hpGrowth: 3,
                mp: 120, mpGrowth: 8,
                str: 6, strGrowth: 0.3,
                dex: 8, dexGrowth: 0.6,
                int: 15, intGrowth: 2.0,
                def: 8, defGrowth: 0.5,
                growthSpeed: 'fast_early',
                peakLevel: 50
            },
            'rogue': {
                hp: 110, hpGrowth: 4,
                mp: 90, mpGrowth: 4,
                str: 9, strGrowth: 0.7,
                dex: 14, dexGrowth: 1.5,
                int: 10, intGrowth: 0.8,
                def: 10, defGrowth: 0.7,
                growthSpeed: 'fast',
                peakLevel: 60
            },
            'cleric': {
                hp: 130, hpGrowth: 5,
                mp: 100, mpGrowth: 6,
                str: 10, strGrowth: 0.9,
                dex: 9, dexGrowth: 0.7,
                int: 12, intGrowth: 1.2,
                def: 12, defGrowth: 0.9,
                growthSpeed: 'slow',
                peakLevel: 80
            },
            'archer': {
                hp: 100, hpGrowth: 4,
                mp: 70, mpGrowth: 3,
                str: 8, strGrowth: 0.6,
                dex: 16, dexGrowth: 1.8,
                int: 9, intGrowth: 0.7,
                def: 9, defGrowth: 0.6,
                growthSpeed: 'very_fast',
                peakLevel: 40
            },
            'berserker': {
                hp: 180, hpGrowth: 8,
                mp: 50, mpGrowth: 1,
                str: 16, strGrowth: 1.5,
                dex: 7, dexGrowth: 0.4,
                int: 5, intGrowth: 0.2,
                def: 14, defGrowth: 1.1,
                growthSpeed: 'slow_early',
                peakLevel: 90
            }
        };

        // XP system formulas
        const xpFormulas = {
            'linear': (level, base = 100) => base * level,
            'exponential': (level, base = 100) => base * Math.pow(level, 2),
            'polynomial': (level, base = 100) => base * Math.pow(level, 1.5),
            'fibonacci': (level, base = 100) => {
                let a = 1, b = 1;
                for (let i = 3; i <= level; i++) {
                    [a, b] = [b, a + b];
                }
                return base * (level === 1 ? 1 : b);
            },
            'custom': (level, base = 100) => base * Math.pow(level, 1.8) + 50
        };

        // Difficulty modifiers
        const difficultyModifiers = {
            'easy': { xp: 1.5, stats: 1.1, enemies: 0.8 },
            'normal': { xp: 1.0, stats: 1.0, enemies: 1.0 },
            'hard': { xp: 0.8, stats: 0.9, enemies: 1.2 },
            'expert': { xp: 0.6, stats: 0.8, enemies: 1.5 }
        };

        // Play style modifiers
        const playStyleModifiers = {
            'casual': { efficiency: 0.7, timeMultiplier: 1.3 },
            'balanced': { efficiency: 1.0, timeMultiplier: 1.0 },
            'grinding': { efficiency: 1.3, timeMultiplier: 0.8 },
            'speedrun': { efficiency: 1.6, timeMultiplier: 0.6 }
        };

        // Switch between tabs
        function switchTab(tabName) {
            // Update tab buttons
            tabs.forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');
            
            // Show selected tab content
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.style.display = 'none');
            document.getElementById(tabName + 'Tab').style.display = 'block';
            
            // Update stats if switching to stats tab
            if (tabName === 'stats') {
                updateClassStats();
            }
        }

        // Update class stats when class changes
        function updateClassStats() {
            const classType = document.getElementById('classType').value;
            const template = classTemplates[classType];
            
            if (template) {
                // Update base stats
                document.getElementById('baseHP').textContent = template.hp;
                document.getElementById('baseMP').textContent = template.mp;
                document.getElementById('baseSTR').textContent = template.str;
                document.getElementById('baseDEX').textContent = template.dex;
                document.getElementById('baseINT').textContent = template.int;
                document.getElementById('baseDEF').textContent = template.def;
                
                // Update growth rates
                document.getElementById('hpGrowth').textContent = `+${template.hpGrowth}/level`;
                document.getElementById('mpGrowth').textContent = `+${template.mpGrowth}/level`;
                document.getElementById('strGrowth').textContent = `+${template.strGrowth}/level`;
                document.getElementById('dexGrowth').textContent = `+${template.dexGrowth}/level`;
                document.getElementById('intGrowth').textContent = `+${template.intGrowth}/level`;
                document.getElementById('defGrowth').textContent = `+${template.defGrowth}/level`;
            }
        }

        // Main calculation function
        function calculateProgression() {
            // Get input values
            const currentLevel = parseInt(document.getElementById('currentLevel').value);
            const currentXP = parseInt(document.getElementById('currentXP').value);
            const targetLevel = parseInt(document.getElementById('targetLevel').value);
            const xpRate = parseInt(document.getElementById('xpRate').value);
            const gameSystem = document.getElementById('gameSystem').value;
            const classType = document.getElementById('classType').value;
            const difficulty = document.getElementById('difficulty').value;
            const playStyle = document.getElementById('playStyle').value;
            
            // Validate inputs
            if (currentLevel >= targetLevel) {
                alert('Target level must be higher than current level!');
                return;
            }
            
            // Calculate XP requirements
            const xpRequirements = calculateXPRequirements(currentLevel, targetLevel, gameSystem);
            const totalXPRequired = xpRequirements.total;
            const xpRemaining = Math.max(0, totalXPRequired - currentXP);
            
            // Calculate time requirements
            const timeEstimate = calculateTimeEstimate(xpRemaining, xpRate, playStyle, difficulty);
            
            // Calculate stat progression
            const statProgression = calculateStatProgression(classType, currentLevel, targetLevel);
            
            // Display results
            displayResults({
                currentLevel,
                targetLevel,
                totalXPRequired,
                xpRemaining,
                timeEstimate,
                levelsToGo: targetLevel - currentLevel,
                xpRequirements,
                statProgression,
                classType,
                gameSystem
            });
            
            // Show results section
            resultsSection.style.display = 'block';
            resultsSection.scrollIntoView({ behavior: 'smooth' });
        }

        // Calculate XP requirements
        function calculateXPRequirements(fromLevel, toLevel, system) {
            const formula = xpFormulas[system];
            let total = 0;
            const requirements = [];
            const cumulative = [];
            
            for (let level = fromLevel + 1; level <= toLevel; level++) {
                const xpForLevel = formula(level);
                total += xpForLevel;
                requirements.push({ level, xp: xpForLevel });
                cumulative.push({ level, xp: total });
            }
            
            return {
                total,
                requirements,
                cumulative
            };
        }

        // Calculate time estimate
        function calculateTimeEstimate(xpRemaining, xpRate, playStyle, difficulty) {
            const styleMod = playStyleModifiers[playStyle];
            const diffMod = difficultyModifiers[difficulty];
            
            const effectiveXPRate = xpRate * styleMod.efficiency * diffMod.xp;
            const hours = xpRemaining / effectiveXPRate;
            const days = hours / (24 * styleMod.timeMultiplier);
            
            return {
                hours: Math.ceil(hours),
                days: Math.ceil(days),
                weeks: Math.ceil(days / 7),
                effectiveRate: Math.round(effectiveXPRate)
            };
        }

        // Calculate stat progression
        function calculateStatProgression(classType, fromLevel, toLevel) {
            const template = classTemplates[classType];
            const growthPattern = document.getElementById('growthPattern').value;
            const statFocus = document.getElementById('statFocus').value;
            const bonusPoints = parseInt(document.getElementById('bonusPoints').value);
            const prestigeLevel = parseInt(document.getElementById('prestigeLevel').value);
            
            const progression = {};
            const stats = ['hp', 'mp', 'str', 'dex', 'int', 'def'];
            
            stats.forEach(stat => {
                const base = template[stat];
                const growth = template[stat + 'Growth'];
                const levels = toLevel - fromLevel;
                
                let finalValue;
                switch (growthPattern) {
                    case 'steady':
                        finalValue = base + (growth * levels);
                        break;
                    case 'accelerating':
                        finalValue = base + (growth * Math.pow(levels, 1.2));
                        break;
                    case 'decelerating':
                        finalValue = base + (growth * Math.pow(levels, 0.8));
                        break;
                    case 'sporadic':
                        finalValue = base + (growth * levels) + (Math.random() * levels / 10);
                        break;
                    default:
                        finalValue = base + (growth * levels);
                }
                
                // Apply stat focus bonus
                if (statFocus === 'offense' && (stat === 'str' || stat === 'dex' || stat === 'int')) {
                    finalValue *= 1.2;
                } else if (statFocus === 'defense' && (stat === 'def' || stat === 'hp')) {
                    finalValue *= 1.2;
                } else if (statFocus === 'hybrid') {
                    finalValue *= 1.1;
                }
                
                // Apply bonus points
                if (stat !== 'hp' && stat !== 'mp') {
                    finalValue += bonusPoints * levels * 0.1;
                }
                
                // Apply prestige bonus
                finalValue *= (1 + (prestigeLevel * 0.05));
                
                progression[stat] = {
                    base: base,
                    final: Math.round(finalValue),
                    growth: Math.round(finalValue - base),
                    percent: Math.round(((finalValue - base) / base) * 100)
                };
            });
            
            return progression;
        }

        // Display results
        function displayResults(results) {
            // Update progress header
            document.getElementById('progressTitle').textContent = 
                `Level ${results.currentLevel} → ${results.targetLevel} Progression`;
            document.getElementById('progressSubtitle').textContent = 
                `${results.levelsToGo} levels | ${results.timeEstimate.hours} hours estimated`;
            
            // Update quick stats
            document.getElementById('totalXP').textContent = results.totalXPRequired.toLocaleString();
            document.getElementById('xpRemaining').textContent = results.xpRemaining.toLocaleString();
            document.getElementById('estimatedTime').textContent = formatTimeEstimate(results.timeEstimate);
            document.getElementById('levelsToGo').textContent = results.levelsToGo;
            
            // Update XP progress
            updateXPProgress(results);
            
            // Update stat evolution
            updateStatEvolution(results.statProgression);
            
            // Update milestone table
            updateMilestoneTable(results.xpRequirements, results.currentLevel, results.targetLevel);
        }

        // Format time estimate
        function formatTimeEstimate(timeEstimate) {
            if (timeEstimate.hours < 24) {
                return `${timeEstimate.hours}h`;
            } else if (timeEstimate.days < 7) {
                return `${timeEstimate.days}d`;
            } else {
                return `${timeEstimate.weeks}w`;
            }
        }

        // Update XP progress visualization
        function updateXPProgress(results) {
            const xpChart = document.getElementById('xpChart');
            const xpProgressText = document.getElementById('xpProgressText');
            
            // Simple text-based progress for now
            const progressPercent = Math.round((1 - (results.xpRemaining / results.totalXPRequired)) * 100);
            xpProgressText.textContent = `Current Progress: ${progressPercent}% | Effective XP Rate: ${results.timeEstimate.effectiveRate}/hour`;
            
            // Create simple bar visualization
            xpChart.innerHTML = `
                <div style="width: 100%; height: 200px; background: #f8f9fa; border-radius: 10px; position: relative;">
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; height: ${progressPercent}%; background: linear-gradient(to top, #ff9a9e, #fecfef); border-radius: 10px 10px 0 0;"></div>
                    <div style="position: absolute; top: 50%; left: 0; right: 0; text-align: center; transform: translateY(-50%); color: #2c3e50; font-weight: bold; font-size: 1.2rem;">
                        ${progressPercent}% Complete
                    </div>
                </div>
            `;
        }

        // Update stat evolution display
        function updateStatEvolution(progression) {
            const evolutionGrid = document.getElementById('statEvolution');
            evolutionGrid.innerHTML = '';
            
            const stats = [
                { key: 'hp', name: 'Health', icon: '❤️' },
                { key: 'mp', name: 'Mana', icon: '🔮' },
                { key: 'str', name: 'Strength', icon: '💪' },
                { key: 'dex', name: 'Dexterity', icon: '🎯' },
                { key: 'int', name: 'Intelligence', icon: '🧠' },
                { key: 'def', name: 'Defense', icon: '🛡️' }
            ];
            
            stats.forEach(stat => {
                const data = progression[stat.key];
                const card = document.createElement('div');
                card.className = 'stat-group';
                card.innerHTML = `
                    <div style="font-size: 0.8rem; color: #7f8c8d; margin-bottom: 5px;">${stat.icon} ${stat.name}</div>
                    <div class="stat-value">${data.final}</div>
                    <div class="stat-growth ${data.growth > 0 ? 'growth-up' : 'growth-neutral'}">
                        +${data.growth} (${data.percent}%)
                    </div>
                    <div style="font-size: 0.7rem; color: #95a5a6; margin-top: 5px;">
                        Base: ${data.base}
                    </div>
                `;
                evolutionGrid.appendChild(card);
            });
        }

        // Update milestone table
        function updateMilestoneTable(xpRequirements, currentLevel, targetLevel) {
            const milestoneTable = document.getElementById('milestoneTable');
            const milestoneChart = document.getElementById('milestoneChart');
            
            milestoneTable.innerHTML = '';
            milestoneChart.innerHTML = '';
            
            // Show key milestones (every 5 levels or important thresholds)
            const milestones = xpRequirements.requirements.filter((req, index) => 
                req.level % 5 === 0 || req.level === currentLevel + 1 || req.level === targetLevel
            );
            
            // Find max XP for chart scaling
            const maxXP = Math.max(...milestones.map(m => m.xp));
            
            milestones.forEach(milestone => {
                // Add to table
                const row = document.createElement('tr');
                
                const levelTd = document.createElement('td');
                levelTd.innerHTML = `<span class="level-badge">${milestone.level}</span>`;
                row.appendChild(levelTd);
                
                const xpTd = document.createElement('td');
                xpTd.textContent = milestone.xp.toLocaleString();
                row.appendChild(xpTd);
                
                const cumulativeTd = document.createElement('td');
                const cumulativeXP = xpRequirements.cumulative.find(c => c.level === milestone.level).xp;
                cumulativeTd.textContent = cumulativeXP.toLocaleString();
                row.appendChild(cumulativeTd);
                
                const bonusTd = document.createElement('td');
                bonusTd.textContent = getLevelBonus(milestone.level);
                row.appendChild(bonusTd);
                
                const unlocksTd = document.createElement('td');
                unlocksTd.textContent = getLevelUnlocks(milestone.level);
                row.appendChild(unlocksTd);
                
                milestoneTable.appendChild(row);
                
                // Add to chart
                const barHeight = (milestone.xp / maxXP) * 100;
                const bar = document.createElement('div');
                bar.className = 'xp-bar';
                bar.style.height = barHeight + '%';
                bar.style.flex = '1';
                
                const label = document.createElement('div');
                label.className = 'bar-label';
                label.textContent = `L${milestone.level}`;
                
                bar.appendChild(label);
                milestoneChart.appendChild(bar);
            });
        }

        // Get level bonus description
        function getLevelBonus(level) {
            if (level % 10 === 0) return 'Major Stat Boost';
            if (level % 5 === 0) return 'Stat Boost';
            if (level % 3 === 0) return 'Minor Boost';
            return 'Standard';
        }

        // Get level unlock description
        function getLevelUnlocks(level) {
            const unlocks = {
                10: 'Advanced Skills',
                20: 'Class Specialization',
                30: 'Ultimate Ability',
                40: 'Prestige Unlock',
                50: 'Master Skills',
                60: 'Legendary Quest',
                70: 'Transcendence',
                80: 'Divine Skills',
                90: 'Mythic Quest',
                100: 'Max Power'
            };
            
            return unlocks[level] || 'New Abilities';
        }

        // Action functions
        function saveProgression() {
            const progress = document.getElementById('progressTitle').textContent;
            const data = {
                progress: progress,
                timestamp: new Date().toLocaleString(),
                totalXP: document.getElementById('totalXP').textContent
            };
            
            localStorage.setItem('levelProgression', JSON.stringify(data));
            alert('Progression analysis saved successfully!');
        }

        function exportResults() {
            const results = document.getElementById('resultsSection').innerText;
            const blob = new Blob([results], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'level-progression-analysis.txt';
            a.click();
            URL.revokeObjectURL(url);
        }

        function shareProgression() {
            const progress = document.getElementById('progressTitle').textContent;
            const totalXP = document.getElementById('totalXP').textContent;
            const time = document.getElementById('estimatedTime').textContent;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Level Progression Analysis',
                    text: `${progress} - ${totalXP} XP - ${time} estimated`,
                    url: window.location.href
                });
            } else {
                alert('Share functionality not available. Results copied to clipboard.');
                navigator.clipboard.writeText(`Level Progression: ${progress} - ${totalXP} XP - ${time} estimated`);
            }
        }

        function resetCalculator() {
            // Reset form to default values
            document.getElementById('currentLevel').value = '25';
            document.getElementById('currentXP').value = '12500';
            document.getElementById('targetLevel').value = '50';
            document.getElementById('xpRate').value = '1000';
            document.getElementById('gameSystem').value = 'exponential';
            document.getElementById('classType').value = 'warrior';
            document.getElementById('difficulty').value = 'normal';
            document.getElementById('playStyle').value = 'balanced';
            
            // Update stats
            updateClassStats();
            
            // Hide results
            resultsSection.style.display = 'none';
        }

        // Initialize calculator
        document.addEventListener('DOMContentLoaded', function() {
            // Set up event listeners
            document.getElementById('classType').addEventListener('change', updateClassStats);
            
            // Initialize stats
            updateClassStats();
        });
    </script>
</body>
</html>
