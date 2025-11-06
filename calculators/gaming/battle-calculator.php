<?php
/**
 * Battle Calculator
 * File: gaming/battle-calculator.php
 * Description: Advanced battle calculator for RPGs, strategy games, and combat simulation with detailed analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Battle Calculator - Advanced Combat Analysis & Strategy Simulator</title>
    <meta name="description" content="Professional battle calculator for RPGs, strategy games, and combat simulation with damage calculation, probability analysis, and tactical recommendations.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .battle-setup { display: grid; grid-template-columns: 1fr auto 1fr; gap: 30px; align-items: start; margin-bottom: 40px; }
        
        .combatant-card { background: #f8f9fa; padding: 25px; border-radius: 15px; border: 3px solid #e9ecef; transition: all 0.3s; }
        .combatant-card.active { border-color: #667eea; background: #f0f4ff; }
        .combatant-header { display: flex; justify-content: between; align-items: center; margin-bottom: 20px; }
        .combatant-title { font-size: 1.3rem; font-weight: bold; color: #2c3e50; }
        .combatant-type { padding: 6px 12px; background: #667eea; color: white; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .stat-group { text-align: center; }
        .stat-value { font-size: 1.4rem; font-weight: bold; color: #667eea; }
        .stat-label { font-size: 0.8rem; color: #7f8c8d; font-weight: 600; }
        
        .input-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.9rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input, .input-wrapper select { width: 100%; padding: 12px 14px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 0.95rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .vs-section { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px; }
        .vs-badge { background: #e74c3c; color: white; padding: 15px 25px; border-radius: 50%; font-size: 1.2rem; font-weight: bold; }
        
        .calculate-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 16px 32px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin: 30px 0; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3); }
        
        .results-section { margin-top: 30px; }
        .results-section h3 { color: #2c3e50; margin-bottom: 20px; font-size: 1.3rem; }
        
        .battle-outcome { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 15px; text-align: center; margin-bottom: 30px; }
        .outcome-title { font-size: 1.8rem; font-weight: bold; margin-bottom: 10px; }
        .outcome-subtitle { font-size: 1.1rem; opacity: 0.9; }
        
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .result-card { background: white; padding: 20px; border-radius: 12px; border-left: 4px solid #667eea; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-value { font-size: 1.4rem; font-weight: bold; color: #2c3e50; }
        
        .battle-timeline { background: #f8f9fa; padding: 25px; border-radius: 12px; margin: 25px 0; }
        .timeline-title { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .timeline-steps { display: flex; flex-direction: column; gap: 10px; }
        .timeline-step { display: flex; align-items: center; gap: 15px; padding: 12px; background: white; border-radius: 8px; border-left: 4px solid #667eea; }
        .step-number { background: #667eea; color: white; padding: 8px 12px; border-radius: 50%; font-weight: bold; }
        .step-content { flex: 1; }
        
        .damage-breakdown { background: white; border: 2px solid #e0e0e0; border-radius: 12px; padding: 25px; margin-top: 25px; }
        .damage-breakdown h4 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        
        .probability-chart { width: 100%; height: 200px; background: #f8f9fa; border-radius: 8px; margin: 20px 0; padding: 20px; display: flex; align-items: end; gap: 2px; }
        .probability-bar { background: linear-gradient(to top, #667eea, #764ba2); border-radius: 4px 4px 0 0; transition: all 0.5s ease; position: relative; }
        .bar-label { position: absolute; top: -25px; left: 0; right: 0; text-align: center; font-size: 0.8rem; color: #7f8c8d; }
        
        .action-buttons { display: flex; gap: 12px; margin-top: 20px; flex-wrap: wrap; }
        .action-btn { padding: 12px 20px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; }
        .action-btn:hover { border-color: #667eea; background: #f0f4ff; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .formula-box { background: #f0f4ff; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .comparison-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .comparison-table th, .comparison-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .comparison-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .comparison-table tr:hover { background: #f5f5f5; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        /* Health bars */
        .health-bar { width: 100%; height: 20px; background: #e0e0e0; border-radius: 10px; overflow: hidden; margin: 10px 0; }
        .health-fill { height: 100%; background: linear-gradient(90deg, #4caf50, #8bc34a); transition: width 0.5s ease; }
        .health-text { text-align: center; font-size: 0.8rem; color: #7f8c8d; margin-top: 5px; }
        
        /* Combat animations */
        @keyframes attackGlow {
            0% { box-shadow: 0 0 0 rgba(102, 126, 234, 0); }
            50% { box-shadow: 0 0 20px rgba(102, 126, 234, 0.6); }
            100% { box-shadow: 0 0 0 rgba(102, 126, 234, 0); }
        }
        .attacking { animation: attackGlow 0.5s ease; }
        
        @media (max-width: 1024px) {
            .battle-setup { grid-template-columns: 1fr; }
            .vs-section { order: -1; flex-direction: row; }
            .stats-grid { grid-template-columns: repeat(4, 1fr); }
        }
        
        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .input-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { flex-direction: column; }
        }
        
        /* Strategy recommendations */
        .strategy-box { background: #fff3e0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff9800; }
        .strategy-box h4 { color: #ef6c00; margin-bottom: 10px; }
        .strategy-tips { list-style: none; }
        .strategy-tips li { padding: 8px 0; color: #555; position: relative; padding-left: 25px; }
        .strategy-tips li:before { content: "⚔️"; position: absolute; left: 0; }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="header">
            <h1>⚔️ Battle Calculator</h1>
            <p>Advanced combat analysis for RPGs, strategy games, and tactical simulations with damage calculation and probability analysis</p>
        </div>

        <div class="calculator-card">
             <!-- <div class="breadcrumb">
                <a href="index.php">← Back to Financial Calculators</a>
            </div> -->
            <div class="battle-setup">
                <!-- Attacker Section -->
                <div class="combatant-card active" id="attackerCard">
                    <div class="combatant-header">
                        <div class="combatant-title">🛡️ Attacker</div>
                        <div class="combatant-type">Aggressive</div>
                    </div>
                    
                    <div class="stats-grid">
                        <div class="stat-group">
                            <div class="stat-value" id="attackerHP">100</div>
                            <div class="stat-label">HP</div>
                        </div>
                        <div class="stat-group">
                            <div class="stat-value" id="attackerATK">50</div>
                            <div class="stat-label">Attack</div>
                        </div>
                        <div class="stat-group">
                            <div class="stat-value" id="attackerDEF">30</div>
                            <div class="stat-label">Defense</div>
                        </div>
                        <div class="stat-group">
                            <div class="stat-value" id="attackerSPD">40</div>
                            <div class="stat-label">Speed</div>
                        </div>
                    </div>
                    
                    <div class="health-bar">
                        <div class="health-fill" id="attackerHealthFill" style="width: 100%;"></div>
                    </div>
                    <div class="health-text" id="attackerHealthText">100/100 HP</div>
                    
                    <div class="input-grid">
                        <div class="input-group">
                            <label for="attackerType">Combatant Type</label>
                            <div class="input-wrapper">
                                <select id="attackerType">
                                    <option value="warrior">Warrior</option>
                                    <option value="mage">Mage</option>
                                    <option value="archer">Archer</option>
                                    <option value="rogue">Rogue</option>
                                    <option value="tank">Tank</option>
                                    <option value="berserker">Berserker</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label for="attackerWeapon">Weapon Type</label>
                            <div class="input-wrapper">
                                <select id="attackerWeapon">
                                    <option value="sword">Sword</option>
                                    <option value="axe">Axe</option>
                                    <option value="staff">Staff</option>
                                    <option value="bow">Bow</option>
                                    <option value="dagger">Dagger</option>
                                    <option value="greatsword">Greatsword</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label for="attackerLevel">Level</label>
                            <div class="input-wrapper">
                                <input type="number" id="attackerLevel" value="10" min="1" max="100">
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label for="attackerCrit">Critical Chance %</label>
                            <div class="input-wrapper">
                                <input type="number" id="attackerCrit" value="15" min="0" max="100" step="1">
                            </div>
                        </div>
                    </div>
                    
                    <div class="input-grid">
                        <div class="input-group">
                            <label for="attackerElement">Element</label>
                            <div class="input-wrapper">
                                <select id="attackerElement">
                                    <option value="none">None</option>
                                    <option value="fire">Fire</option>
                                    <option value="ice">Ice</option>
                                    <option value="lightning">Lightning</option>
                                    <option value="holy">Holy</option>
                                    <option value="dark">Dark</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label for="attackerBuff">Active Buffs</label>
                            <div class="input-wrapper">
                                <select id="attackerBuff">
                                    <option value="none">None</option>
                                    <option value="strength">Strength Boost</option>
                                    <option value="haste">Haste</option>
                                    <option value="protection">Protection</option>
                                    <option value="blessing">Divine Blessing</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label for="attackerStrategy">Battle Strategy</label>
                            <div class="input-wrapper">
                                <select id="attackerStrategy">
                                    <option value="aggressive">Aggressive</option>
                                    <option value="balanced">Balanced</option>
                                    <option value="defensive">Defensive</option>
                                    <option value="tactical">Tactical</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- VS Section -->
                <div class="vs-section">
                    <div class="vs-badge">VS</div>
                    <div style="text-align: center;">
                        <div style="font-weight: bold; color: #2c3e50; margin-bottom: 10px;">Battle Conditions</div>
                        <div class="input-group">
                            <div class="input-wrapper">
                                <select id="battleEnvironment">
                                    <option value="plains">Plains</option>
                                    <option value="forest">Forest</option>
                                    <option value="mountains">Mountains</option>
                                    <option value="dungeon">Dungeon</option>
                                    <option value="arena">Arena</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-group">
                            <div class="input-wrapper">
                                <select id="battleRounds">
                                    <option value="1">1 Round</option>
                                    <option value="3" selected>3 Rounds</option>
                                    <option value="5">5 Rounds</option>
                                    <option value="10">10 Rounds</option>
                                    <option value="unlimited">Until Victory</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Defender Section -->
                <div class="combatant-card" id="defenderCard">
                    <div class="combatant-header">
                        <div class="combatant-title">🛡️ Defender</div>
                        <div class="combatant-type">Defensive</div>
                    </div>
                    
                    <div class="stats-grid">
                        <div class="stat-group">
                            <div class="stat-value" id="defenderHP">120</div>
                            <div class="stat-label">HP</div>
                        </div>
                        <div class="stat-group">
                            <div class="stat-value" id="defenderATK">35</div>
                            <div class="stat-label">Attack</div>
                        </div>
                        <div class="stat-group">
                            <div class="stat-value" id="defenderDEF">45</div>
                            <div class="stat-label">Defense</div>
                        </div>
                        <div class="stat-group">
                            <div class="stat-value" id="defenderSPD">30</div>
                            <div class="stat-label">Speed</div>
                        </div>
                    </div>
                    
                    <div class="health-bar">
                        <div class="health-fill" id="defenderHealthFill" style="width: 100%;"></div>
                    </div>
                    <div class="health-text" id="defenderHealthText">120/120 HP</div>
                    
                    <div class="input-grid">
                        <div class="input-group">
                            <label for="defenderType">Combatant Type</label>
                            <div class="input-wrapper">
                                <select id="defenderType">
                                    <option value="warrior">Warrior</option>
                                    <option value="mage">Mage</option>
                                    <option value="archer">Archer</option>
                                    <option value="rogue">Rogue</option>
                                    <option value="tank" selected>Tank</option>
                                    <option value="berserker">Berserker</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label for="defenderWeapon">Weapon Type</label>
                            <div class="input-wrapper">
                                <select id="defenderWeapon">
                                    <option value="sword">Sword</option>
                                    <option value="axe">Axe</option>
                                    <option value="staff">Staff</option>
                                    <option value="bow">Bow</option>
                                    <option value="dagger">Dagger</option>
                                    <option value="shield">Shield</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label for="defenderLevel">Level</label>
                            <div class="input-wrapper">
                                <input type="number" id="defenderLevel" value="10" min="1" max="100">
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label for="defenderCrit">Critical Chance %</label>
                            <div class="input-wrapper">
                                <input type="number" id="defenderCrit" value="10" min="0" max="100" step="1">
                            </div>
                        </div>
                    </div>
                    
                    <div class="input-grid">
                        <div class="input-group">
                            <label for="defenderElement">Element</label>
                            <div class="input-wrapper">
                                <select id="defenderElement">
                                    <option value="none">None</option>
                                    <option value="fire">Fire</option>
                                    <option value="ice">Ice</option>
                                    <option value="lightning">Lightning</option>
                                    <option value="holy">Holy</option>
                                    <option value="dark">Dark</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label for="defenderBuff">Active Buffs</label>
                            <div class="input-wrapper">
                                <select id="defenderBuff">
                                    <option value="none">None</option>
                                    <option value="strength">Strength Boost</option>
                                    <option value="haste">Haste</option>
                                    <option value="protection" selected>Protection</option>
                                    <option value="blessing">Divine Blessing</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label for="defenderStrategy">Battle Strategy</label>
                            <div class="input-wrapper">
                                <select id="defenderStrategy">
                                    <option value="aggressive">Aggressive</option>
                                    <option value="balanced">Balanced</option>
                                    <option value="defensive" selected>Defensive</option>
                                    <option value="tactical">Tactical</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="calculate-btn" onclick="simulateBattle()">⚔️ Simulate Battle</button>

            <div class="results-section" id="resultsSection" style="display: none;">
                <div class="battle-outcome">
                    <div class="outcome-title" id="outcomeTitle">Battle Analysis Complete</div>
                    <div class="outcome-subtitle" id="outcomeSubtitle">Detailed combat results and strategic recommendations</div>
                </div>
                
                <div class="results-grid">
                    <div class="result-card">
                        <div class="result-label">Victory Probability</div>
                        <div class="result-value" id="victoryProbability">65%</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Average Damage per Round</div>
                        <div class="result-value" id="avgDamage">42</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Battle Duration</div>
                        <div class="result-value" id="battleDuration">4 Rounds</div>
                    </div>
                    
                    <div class="result-card">
                        <div class="result-label">Critical Hit Rate</div>
                        <div class="result-value" id="criticalRate">18%</div>
                    </div>
                </div>

                <div class="battle-timeline">
                    <div class="timeline-title">🔄 Battle Timeline</div>
                    <div class="timeline-steps" id="battleTimeline">
                        <!-- Timeline steps will be populated here -->
                    </div>
                </div>

                <div class="damage-breakdown">
                    <h4>📊 Damage Analysis</h4>
                    <div class="probability-chart" id="damageChart">
                        <!-- Damage probability bars will be populated here -->
                    </div>
                    
                    <table class="comparison-table">
                        <thead>
                            <tr>
                                <th>Damage Type</th>
                                <th>Min Damage</th>
                                <th>Avg Damage</th>
                                <th>Max Damage</th>
                                <th>Frequency</th>
                            </tr>
                        </thead>
                        <tbody id="damageTable">
                            <!-- Damage data will be populated here -->
                        </tbody>
                    </table>
                </div>

                <div class="strategy-box">
                    <h4>🎯 Strategic Recommendations</h4>
                    <ul class="strategy-tips" id="strategyTips">
                        <!-- Strategy tips will be populated here -->
                    </ul>
                </div>

                <div class="action-buttons">
                    <button class="action-btn" onclick="saveBattle()">
                        💾 Save Battle
                    </button>
                    <button class="action-btn" onclick="exportResults()">
                        📤 Export Results
                    </button>
                    <button class="action-btn" onclick="shareBattle()">
                        🔗 Share Analysis
                    </button>
                    <button class="action-btn" onclick="resetCalculator()">
                        🔄 New Battle
                    </button>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⚔️ Advanced Battle Mechanics</h2>
            
            <p>Professional battle calculation system for RPGs, strategy games, and tactical simulations with comprehensive damage modeling, probability analysis, and strategic recommendations.</p>

            <h3>🎯 Core Combat Formulas</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Formula Type</th>
                        <th>Calculation</th>
                        <th>Variables</th>
                        <th>Application</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Basic Damage</strong></td>
                        <td>ATK - DEF × 0.7</td>
                        <td>ATK = Attack, DEF = Defense</td>
                        <td>Standard physical attacks</td>
                    </tr>
                    <tr>
                        <td><strong>Critical Hit</strong></td>
                        <td>Damage × (1.5 + CRIT/100)</td>
                        <td>CRIT = Critical bonus</td>
                        <td>Critical strike calculations</td>
                    </tr>
                    <tr>
                        <td><strong>Elemental Bonus</strong></td>
                        <td>Damage × (1 + ElementBonus)</td>
                        <td>ElementBonus = 0.1-0.3</td>
                        <td>Elemental advantage</td>
                    </tr>
                    <tr>
                        <td><strong>Level Advantage</strong></td>
                        <td>Damage × (1 + (ΔLevel × 0.02))</td>
                        <td>ΔLevel = Level difference</td>
                        <td>Level-based scaling</td>
                    </tr>
                    <tr>
                        <td><strong>Strategy Multiplier</strong></td>
                        <td>Damage × StrategyMod</td>
                        <td>StrategyMod = 0.8-1.2</td>
                        <td>Tactical adjustments</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Complete Damage Formula:</strong><br>
                Final Damage = (BaseATK × WeaponMod - TargetDEF × DefenseMod) × (1 + ElementBonus) × (1 + LevelBonus) × StrategyMod × (Random 0.9-1.1)
            </div>

            <h3>🛡️ Combatant Archetypes</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>HP Range</th>
                        <th>ATK/DEF Ratio</th>
                        <th>Specialty</th>
                        <th>Weakness</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Warrior</strong></td>
                        <td>90-110</td>
                        <td>Balanced</td>
                        <td>Versatile combat</td>
                        <td>No specialties</td>
                    </tr>
                    <tr>
                        <td><strong>Mage</strong></td>
                        <td>70-90</td>
                        <td>High ATK, Low DEF</td>
                        <td>Elemental damage</td>
                        <td>Physical defense</td>
                    </tr>
                    <tr>
                        <td><strong>Archer</strong></td>
                        <td>80-100</td>
                        <td>High ATK, Med DEF</td>
                        <td>Ranged attacks</td>
                        <td>Close combat</td>
                    </tr>
                    <tr>
                        <td><strong>Rogue</strong></td>
                        <td>75-95</td>
                        <td>High SPD, Low DEF</td>
                        <td>Critical strikes</td>
                        <td>Sustained damage</td>
                    </tr>
                    <tr>
                        <td><strong>Tank</strong></td>
                        <td>120-150</td>
                        <td>Low ATK, High DEF</td>
                        <td>Damage soaking</td>
                        <td>Low damage output</td>
                    </tr>
                    <tr>
                        <td><strong>Berserker</strong></td>
                        <td>100-130</td>
                        <td>Very High ATK, Low DEF</td>
                        <td>Burst damage</td>
                        <td>Defense</td>
                    </tr>
                </tbody>
            </table>

            <h3>⚡ Elemental System</h3>
            <div class="formula-box">
                <strong>Elemental Advantages:</strong><br>
                • <strong>Fire</strong> → Ice (+30%), Nature (+20%)<br>
                • <strong>Ice</strong> → Fire (+30%), Earth (+20%)<br>
                • <strong>Lightning</strong> → Water (+30%), Metal (+20%)<br>
                • <strong>Holy</strong> → Dark (+50%), Undead (+50%)<br>
                • <strong>Dark</strong> → Holy (+30%), Light (+20%)
            </div>

            <h3>🎲 Probability & Randomness</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Factor</th>
                        <th>Base Chance</th>
                        <th>Maximum</th>
                        <th>Influenced By</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Critical Hit</strong></td>
                        <td>5%</td>
                        <td>50%</td>
                        <td>Dexterity, Luck, Skills</td>
                    </tr>
                    <tr>
                        <td><strong>Dodge</strong></td>
                        <td>10%</td>
                        <td>40%</td>
                        <td>Agility, Evasion, Skills</td>
                    </tr>
                    <tr>
                        <td><strong>Status Effect</strong></td>
                        <td>15%</td>
                        <td>75%</td>
                        <td>Intelligence, Element, Skills</td>
                    </tr>
                    <tr>
                        <td><strong>Double Attack</strong></td>
                        <td>8%</td>
                        <td>30%</td>
                        <td>Speed, Haste effects</td>
                    </tr>
                </tbody>
            </table>

            <h3>🔄 Turn Order & Initiative</h3>
            <ul>
                <li><strong>Base Initiative:</strong> Determined by Speed stat</li>
                <li><strong>Haste Effects:</strong> +25% initiative chance</li>
                <li><strong>Surprise Attacks:</strong> Automatic first strike in certain conditions</li>
                <li><strong>Initiative Tie:</strong> Higher Speed wins, then random</li>
                <li><strong>Consecutive Turns:</strong> Possible with very high Speed advantage</li>
            </ul>

            <h3>🏹 Weapon Specializations</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Weapon</th>
                        <th>Damage Range</th>
                        <th>Critical Bonus</th>
                        <th>Special Effects</th>
                        <th>Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Sword</strong></td>
                        <td>Medium</td>
                        <td>+5%</td>
                        <td>Balanced, reliable</td>
                        <td>Warriors, Knights</td>
                    </tr>
                    <tr>
                        <td><strong>Axe</strong></td>
                        <td>High</td>
                        <td>+10%</td>
                        <td>High variance</td>
                        <td>Berserkers</td>
                    </tr>
                    <tr>
                        <td><strong>Staff</strong></td>
                        <td>Low-Medium</td>
                        <td>+0%</td>
                        <td>Magic amplification</td>
                        <td>Mages, Healers</td>
                    </tr>
                    <tr>
                        <td><strong>Bow</strong></td>
                        <td>Medium</td>
                        <td>+15%</td>
                        <td>Ranged, high crit</td>
                        <td>Archers, Rangers</td>
                    </tr>
                    <tr>
                        <td><strong>Dagger</strong></td>
                        <td>Low</td>
                        <td>+20%</td>
                        <td>Fast attacks</td>
                        <td>Rogues, Assassins</td>
                    </tr>
                    <tr>
                        <td><strong>Greatsword</strong></td>
                        <td>Very High</td>
                        <td>+5%</td>
                        <td>Slow but powerful</td>
                        <td>Warriors, Tanks</td>
                    </tr>
                </tbody>
            </table>

            <h3>🎯 Advanced Tactics</h3>
            <div class="formula-box">
                <strong>Strategic Approaches:</strong><br>
                • <strong>Aggressive:</strong> +20% damage, -15% defense<br>
                • <strong>Defensive:</strong> -15% damage, +25% defense<br>
                • <strong>Balanced:</strong> No modifications<br>
                • <strong>Tactical:</strong> +10% critical, +10% accuracy
            </div>

            <h3>⚠️ Common Battle Mistakes</h3>
            <ul>
                <li><strong>Ignoring elemental advantages:</strong> Can provide up to 50% damage bonus</li>
                <li><strong>Underestimating speed:</strong> Multiple turns can decide battles</li>
                <li><strong>Over-reliance on criticals:</strong> Unreliable without proper investment</li>
                <li><strong>Poor stat distribution:</strong> Balanced builds often outperform min-maxing</li>
                <li><strong>Ignoring environmental factors:</strong> Terrain can provide significant advantages</li>
                <li><strong>Failing to adapt strategy:</strong> Different opponents require different approaches</li>
            </ul>
        </div>

        <div class="footer">
            <p>⚔️ Advanced Battle Calculator | RPG Combat Analysis & Strategy Simulation</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Damage calculation, probability analysis, tactical recommendations, and comprehensive battle simulation</p>
        </div>
    </div>

    <script>
        // DOM elements
        const resultsSection = document.getElementById('resultsSection');
        const attackerCard = document.getElementById('attackerCard');
        const defenderCard = document.getElementById('defenderCard');

        // Combatant type templates
        const combatantTemplates = {
            'warrior': { hp: 100, atk: 50, def: 30, spd: 40, crit: 10 },
            'mage': { hp: 80, atk: 65, def: 20, spd: 35, crit: 15 },
            'archer': { hp: 85, atk: 55, def: 25, spd: 50, crit: 20 },
            'rogue': { hp: 75, atk: 45, def: 20, spd: 60, crit: 25 },
            'tank': { hp: 140, atk: 35, def: 50, spd: 25, crit: 5 },
            'berserker': { hp: 110, atk: 70, def: 15, spd: 45, crit: 15 }
        };

        // Weapon modifiers
        const weaponModifiers = {
            'sword': { damage: 1.0, crit: 5, speed: 0 },
            'axe': { damage: 1.2, crit: 10, speed: -5 },
            'staff': { damage: 0.9, crit: 0, speed: 0 },
            'bow': { damage: 1.0, crit: 15, speed: 5 },
            'dagger': { damage: 0.8, crit: 20, speed: 10 },
            'greatsword': { damage: 1.4, crit: 5, speed: -10 },
            'shield': { damage: 0.7, crit: 0, speed: -5 }
        };

        // Elemental advantages
        const elementalAdvantages = {
            'fire': { ice: 1.3, nature: 1.2 },
            'ice': { fire: 1.3, earth: 1.2 },
            'lightning': { water: 1.3, metal: 1.2 },
            'holy': { dark: 1.5, undead: 1.5 },
            'dark': { holy: 1.3, light: 1.2 }
        };

        // Initialize calculator
        document.addEventListener('DOMContentLoaded', function() {
            // Set up event listeners for combatant type changes
            document.getElementById('attackerType').addEventListener('change', updateCombatantStats);
            document.getElementById('defenderType').addEventListener('change', updateCombatantStats);
            
            // Set up event listeners for weapon changes
            document.getElementById('attackerWeapon').addEventListener('change', updateWeaponStats);
            document.getElementById('defenderWeapon').addEventListener('change', updateWeaponStats);
            
            // Initialize stats
            updateCombatantStats();
        });

        // Update combatant stats based on type
        function updateCombatantStats() {
            updateSingleCombatant('attacker');
            updateSingleCombatant('defender');
        }

        // Update single combatant stats
        function updateSingleCombatant(role) {
            const type = document.getElementById(role + 'Type').value;
            const template = combatantTemplates[type];
            
            if (template) {
                document.getElementById(role + 'HP').textContent = template.hp;
                document.getElementById(role + 'ATK').textContent = template.atk;
                document.getElementById(role + 'DEF').textContent = template.def;
                document.getElementById(role + 'SPD').textContent = template.spd;
                document.getElementById(role + 'Crit').value = template.crit;
                
                // Update health bar
                document.getElementById(role + 'HealthFill').style.width = '100%';
                document.getElementById(role + 'HealthText').textContent = template.hp + '/' + template.hp + ' HP';
            }
        }

        // Update weapon-based stats
        function updateWeaponStats() {
            updateWeaponForCombatant('attacker');
            updateWeaponForCombatant('defender');
        }

        // Update weapon stats for single combatant
        function updateWeaponForCombatant(role) {
            const weapon = document.getElementById(role + 'Weapon').value;
            const modifier = weaponModifiers[weapon];
            
            if (modifier) {
                const baseATK = parseInt(document.getElementById(role + 'ATK').textContent);
                const baseSPD = parseInt(document.getElementById(role + 'SPD').textContent);
                
                const adjustedATK = Math.round(baseATK * modifier.damage);
                const adjustedSPD = Math.max(1, baseSPD + modifier.speed);
                
                document.getElementById(role + 'ATK').textContent = adjustedATK;
                document.getElementById(role + 'SPD').textContent = adjustedSPD;
            }
        }

        // Main battle simulation function
        function simulateBattle() {
            // Get combatant data
            const attacker = getCombatantData('attacker');
            const defender = getCombatantData('defender');
            
            // Get battle conditions
            const environment = document.getElementById('battleEnvironment').value;
            const maxRounds = document.getElementById('battleRounds').value === 'unlimited' ? 100 : parseInt(document.getElementById('battleRounds').value);
            
            // Run battle simulation
            const battleResult = runBattleSimulation(attacker, defender, maxRounds, environment);
            
            // Display results
            displayBattleResults(battleResult, attacker, defender);
            
            // Show results section
            resultsSection.style.display = 'block';
            resultsSection.scrollIntoView({ behavior: 'smooth' });
            
            // Add attack animation
            attackerCard.classList.add('attacking');
            setTimeout(() => attackerCard.classList.remove('attacking'), 500);
        }

        // Get comprehensive combatant data
        function getCombatantData(role) {
            return {
                type: document.getElementById(role + 'Type').value,
                hp: parseInt(document.getElementById(role + 'HP').textContent),
                maxHp: parseInt(document.getElementById(role + 'HP').textContent),
                atk: parseInt(document.getElementById(role + 'ATK').textContent),
                def: parseInt(document.getElementById(role + 'DEF').textContent),
                spd: parseInt(document.getElementById(role + 'SPD').textContent),
                level: parseInt(document.getElementById(role + 'Level').value),
                critChance: parseInt(document.getElementById(role + 'Crit').value),
                weapon: document.getElementById(role + 'Weapon').value,
                element: document.getElementById(role + 'Element').value,
                buff: document.getElementById(role + 'Buff').value,
                strategy: document.getElementById(role + 'Strategy').value
            };
        }

        // Run battle simulation
        function runBattleSimulation(attacker, defender, maxRounds, environment) {
            const rounds = [];
            let currentRound = 1;
            let attackerHP = attacker.hp;
            let defenderHP = defender.hp;
            
            // Determine initiative
            const attackerInitiative = calculateInitiative(attacker, defender);
            const defenderInitiative = calculateInitiative(defender, attacker);
            
            while (currentRound <= maxRounds && attackerHP > 0 && defenderHP > 0) {
                const round = {
                    number: currentRound,
                    events: []
                };
                
                // Determine turn order based on initiative
                if (attackerInitiative >= defenderInitiative) {
                    // Attacker goes first
                    const attackResult = performAttack(attacker, defender, attackerHP, defenderHP);
                    defenderHP = attackResult.defenderHP;
                    round.events.push(attackResult.event);
                    
                    if (defenderHP > 0) {
                        const counterResult = performAttack(defender, attacker, defenderHP, attackerHP);
                        attackerHP = counterResult.defenderHP; // Note: defender becomes attacker in counter
                        round.events.push(counterResult.event);
                    }
                } else {
                    // Defender goes first
                    const defenseResult = performAttack(defender, attacker, defenderHP, attackerHP);
                    attackerHP = defenseResult.defenderHP; // Note: defender becomes attacker in this context
                    round.events.push(defenseResult.event);
                    
                    if (attackerHP > 0) {
                        const counterResult = performAttack(attacker, defender, attackerHP, defenderHP);
                        defenderHP = counterResult.defenderHP;
                        round.events.push(counterResult.event);
                    }
                }
                
                rounds.push(round);
                currentRound++;
            }
            
            // Determine winner
            let winner = null;
            if (attackerHP <= 0 && defenderHP <= 0) {
                winner = 'draw';
            } else if (attackerHP <= 0) {
                winner = 'defender';
            } else if (defenderHP <= 0) {
                winner = 'attacker';
            } else {
                winner = 'timeout';
            }
            
            return {
                rounds: rounds,
                winner: winner,
                finalAttackerHP: Math.max(0, attackerHP),
                finalDefenderHP: Math.max(0, defenderHP),
                totalRounds: rounds.length
            };
        }

        // Calculate initiative
        function calculateInitiative(combatant, opponent) {
            let initiative = combatant.spd;
            
            // Strategy modifiers
            if (combatant.strategy === 'aggressive') initiative += 10;
            if (combatant.strategy === 'defensive') initiative -= 5;
            
            // Buff modifiers
            if (combatant.buff === 'haste') initiative += 15;
            
            // Random factor
            initiative += Math.random() * 20 - 10;
            
            return Math.max(1, initiative);
        }

        // Perform a single attack
        function performAttack(attacker, defender, attackerHP, defenderHP) {
            const damage = calculateDamage(attacker, defender);
            const isCritical = Math.random() * 100 < attacker.critChance;
            const finalDamage = isCritical ? Math.round(damage * (1.5 + attacker.critChance / 100)) : damage;
            
            const newDefenderHP = Math.max(0, defenderHP - finalDamage);
            
            const event = {
                attacker: attacker.type,
                defender: defender.type,
                damage: finalDamage,
                isCritical: isCritical,
                defenderHP: newDefenderHP,
                attackerHP: attackerHP
            };
            
            return {
                event: event,
                defenderHP: newDefenderHP
            };
        }

        // Calculate damage for an attack
        function calculateDamage(attacker, defender) {
            // Base damage calculation
            let damage = attacker.atk - (defender.def * 0.7);
            damage = Math.max(1, damage);
            
            // Weapon modifier
            const weaponMod = weaponModifiers[attacker.weapon].damage;
            damage *= weaponMod;
            
            // Elemental advantage
            const elementBonus = calculateElementalBonus(attacker.element, defender.element);
            damage *= elementBonus;
            
            // Level advantage
            const levelDiff = attacker.level - defender.level;
            const levelBonus = 1 + (levelDiff * 0.02);
            damage *= levelBonus;
            
            // Strategy modifier
            const strategyMod = getStrategyModifier(attacker.strategy);
            damage *= strategyMod;
            
            // Buff effects
            if (attacker.buff === 'strength') damage *= 1.2;
            if (defender.buff === 'protection') damage *= 0.8;
            
            // Random variance (90-110%)
            damage *= 0.9 + (Math.random() * 0.2);
            
            return Math.round(damage);
        }

        // Calculate elemental bonus
        function calculateElementalBonus(attackerElement, defenderElement) {
            if (attackerElement === 'none' || defenderElement === 'none') return 1.0;
            
            const advantages = elementalAdvantages[attackerElement];
            if (advantages && advantages[defenderElement]) {
                return advantages[defenderElement];
            }
            
            return 1.0;
        }

        // Get strategy modifier
        function getStrategyModifier(strategy) {
            const modifiers = {
                'aggressive': 1.2,
                'defensive': 0.85,
                'balanced': 1.0,
                'tactical': 1.1
            };
            return modifiers[strategy] || 1.0;
        }

        // Display battle results
        function displayBattleResults(result, attacker, defender) {
            // Update outcome
            document.getElementById('outcomeTitle').textContent = getOutcomeTitle(result.winner);
            document.getElementById('outcomeSubtitle').textContent = getOutcomeSubtitle(result, attacker, defender);
            
            // Update quick stats
            document.getElementById('victoryProbability').textContent = calculateVictoryProbability(result) + '%';
            document.getElementById('avgDamage').textContent = calculateAverageDamage(result) + ' HP';
            document.getElementById('battleDuration').textContent = result.totalRounds + ' Rounds';
            document.getElementById('criticalRate').textContent = calculateCriticalRate(result) + '%';
            
            // Update battle timeline
            updateBattleTimeline(result.rounds);
            
            // Update damage analysis
            updateDamageAnalysis(result.rounds);
            
            // Update strategy recommendations
            updateStrategyRecommendations(result, attacker, defender);
            
            // Update health bars
            updateHealthBars(result.finalAttackerHP, attacker.maxHp, result.finalDefenderHP, defender.maxHp);
        }

        // Helper functions for display
        function getOutcomeTitle(winner) {
            const titles = {
                'attacker': '🏆 Attacker Victory!',
                'defender': '🏆 Defender Victory!',
                'draw': '⚖️ Battle Draw!',
                'timeout': '⏰ Time Limit Reached'
            };
            return titles[winner] || 'Battle Complete';
        }

        function getOutcomeSubtitle(result, attacker, defender) {
            if (result.winner === 'attacker') {
                return `Attacker survived with ${result.finalAttackerHP} HP remaining`;
            } else if (result.winner === 'defender') {
                return `Defender survived with ${result.finalDefenderHP} HP remaining`;
            } else if (result.winner === 'draw') {
                return 'Both combatants fell in battle';
            } else {
                return `Battle ended after ${result.totalRounds} rounds`;
            }
        }

        function calculateVictoryProbability(result) {
            // Simple probability calculation based on battle results
            if (result.winner === 'attacker') return 65;
            if (result.winner === 'defender') return 30;
            if (result.winner === 'draw') return 5;
            return 50;
        }

        function calculateAverageDamage(rounds) {
            let totalDamage = 0;
            let totalAttacks = 0;
            
            rounds.forEach(round => {
                round.events.forEach(event => {
                    totalDamage += event.damage;
                    totalAttacks++;
                });
            });
            
            return totalAttacks > 0 ? Math.round(totalDamage / totalAttacks) : 0;
        }

        function calculateCriticalRate(rounds) {
            let totalAttacks = 0;
            let criticalHits = 0;
            
            rounds.forEach(round => {
                round.events.forEach(event => {
                    totalAttacks++;
                    if (event.isCritical) criticalHits++;
                });
            });
            
            return totalAttacks > 0 ? Math.round((criticalHits / totalAttacks) * 100) : 0;
        }

        // Update battle timeline
        function updateBattleTimeline(rounds) {
            const timeline = document.getElementById('battleTimeline');
            timeline.innerHTML = '';
            
            rounds.forEach((round, index) => {
                round.events.forEach((event, eventIndex) => {
                    const step = document.createElement('div');
                    step.className = 'timeline-step';
                    
                    const stepNumber = document.createElement('div');
                    stepNumber.className = 'step-number';
                    stepNumber.textContent = index + 1;
                    
                    const stepContent = document.createElement('div');
                    stepContent.className = 'step-content';
                    
                    const criticalText = event.isCritical ? ' 💥 CRITICAL!' : '';
                    stepContent.innerHTML = `
                        <strong>${event.attacker}</strong> attacks <strong>${event.defender}</strong> for 
                        <span style="color: #e74c3c; font-weight: bold;">${event.damage} damage</span>${criticalText}
                        <div style="font-size: 0.8rem; color: #7f8c8d; margin-top: 5px;">
                            ${event.defender} HP: ${event.defenderHP}/${event.defender === 'attacker' ? '100' : '120'}
                        </div>
                    `;
                    
                    step.appendChild(stepNumber);
                    step.appendChild(stepContent);
                    timeline.appendChild(step);
                });
            });
        }

        // Update damage analysis
        function updateDamageAnalysis(rounds) {
            const damageChart = document.getElementById('damageChart');
            const damageTable = document.getElementById('damageTable');
            
            // Clear previous content
            damageChart.innerHTML = '';
            damageTable.innerHTML = '';
            
            // Collect damage data
            const damageValues = [];
            let minDamage = Infinity;
            let maxDamage = 0;
            let totalDamage = 0;
            let criticalCount = 0;
            
            rounds.forEach(round => {
                round.events.forEach(event => {
                    damageValues.push(event.damage);
                    minDamage = Math.min(minDamage, event.damage);
                    maxDamage = Math.max(maxDamage, event.damage);
                    totalDamage += event.damage;
                    if (event.isCritical) criticalCount++;
                });
            });
            
            // Create damage frequency chart
            if (damageValues.length > 0) {
                const damageRanges = createDamageRanges(minDamage, maxDamage);
                const frequencyData = calculateDamageFrequency(damageValues, damageRanges);
                const maxFrequency = Math.max(...frequencyData.map(d => d.count));
                
                damageRanges.forEach((range, index) => {
                    const frequency = frequencyData[index].count;
                    const percentage = (frequency / damageValues.length) * 100;
                    const barHeight = (frequency / maxFrequency) * 100;
                    
                    const bar = document.createElement('div');
                    bar.className = 'probability-bar';
                    bar.style.height = barHeight + '%';
                    bar.style.flex = '1';
                    
                    const label = document.createElement('div');
                    label.className = 'bar-label';
                    label.textContent = range.min + '-' + range.max;
                    
                    bar.appendChild(label);
                    damageChart.appendChild(bar);
                });
                
                // Update damage table
                const avgDamage = Math.round(totalDamage / damageValues.length);
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>Physical</td>
                    <td>${minDamage}</td>
                    <td>${avgDamage}</td>
                    <td>${maxDamage}</td>
                    <td>${damageValues.length} attacks</td>
                `;
                damageTable.appendChild(row);
                
                if (criticalCount > 0) {
                    const criticalRow = document.createElement('tr');
                    const avgCritical = Math.round(damageValues.filter((_, i) => {
                        let eventIndex = 0;
                        for (const round of rounds) {
                            for (const event of round.events) {
                                if (eventIndex === i) return event.isCritical;
                                eventIndex++;
                            }
                        }
                        return false;
                    }).reduce((a, b) => a + b, 0) / criticalCount);
                    
                    criticalRow.innerHTML = `
                        <td>Critical Hits</td>
                        <td>${Math.round(minDamage * 1.5)}</td>
                        <td>${avgCritical}</td>
                        <td>${Math.round(maxDamage * 1.5)}</td>
                        <td>${criticalCount} (${Math.round((criticalCount / damageValues.length) * 100)}%)</td>
                    `;
                    damageTable.appendChild(criticalRow);
                }
            }
        }

        // Create damage ranges for chart
        function createDamageRanges(min, max) {
            const rangeSize = Math.ceil((max - min) / 5);
            const ranges = [];
            
            for (let i = 0; i < 5; i++) {
                const rangeMin = min + (i * rangeSize);
                const rangeMax = rangeMin + rangeSize - 1;
                ranges.push({ min: rangeMin, max: rangeMax });
            }
            
            return ranges;
        }

        // Calculate damage frequency
        function calculateDamageFrequency(damageValues, ranges) {
            return ranges.map(range => {
                const count = damageValues.filter(dmg => dmg >= range.min && dmg <= range.max).length;
                return { range: range, count: count };
            });
        }

        // Update strategy recommendations
        function updateStrategyRecommendations(result, attacker, defender) {
            const strategyTips = document.getElementById('strategyTips');
            strategyTips.innerHTML = '';
            
            const tips = [];
            
            // Analyze battle results for recommendations
            if (result.winner === 'attacker') {
                tips.push("Your current strategy is effective against this opponent");
                tips.push("Consider maintaining aggressive pressure in future battles");
            } else if (result.winner === 'defender') {
                tips.push("Adjust your strategy - the defender's defensive approach was successful");
                tips.push("Consider using elemental advantages or different weapon types");
            }
            
            // Elemental recommendations
            if (attacker.element !== 'none' && defender.element !== 'none') {
                const advantage = calculateElementalBonus(attacker.element, defender.element);
                if (advantage > 1.0) {
                    tips.push(`Elemental advantage is working well (+${Math.round((advantage - 1) * 100)}% damage)`);
                } else {
                    tips.push("Consider changing your element for better advantage");
                }
            }
            
            // Critical hit analysis
            const criticalRate = calculateCriticalRate(result.rounds);
            if (criticalRate < 10) {
                tips.push("Low critical rate - consider equipment or skills that boost critical chance");
            } else if (criticalRate > 25) {
                tips.push("Excellent critical rate - your build is optimized for critical strikes");
            }
            
            // Add general tips
            tips.push("Monitor your HP and use healing items when below 30%");
            tips.push("Consider environmental factors that might affect battle outcomes");
            tips.push("Experiment with different strategies against tough opponents");
            
            // Add tips to list
            tips.forEach(tip => {
                const li = document.createElement('li');
                li.textContent = tip;
                strategyTips.appendChild(li);
            });
        }

        // Update health bars
        function updateHealthBars(attackerHP, attackerMaxHP, defenderHP, defenderMaxHP) {
            const attackerPercent = (attackerHP / attackerMaxHP) * 100;
            const defenderPercent = (defenderHP / defenderMaxHP) * 100;
            
            document.getElementById('attackerHealthFill').style.width = attackerPercent + '%';
            document.getElementById('defenderHealthFill').style.width = defenderPercent + '%';
            
            document.getElementById('attackerHealthText').textContent = attackerHP + '/' + attackerMaxHP + ' HP';
            document.getElementById('defenderHealthText').textContent = defenderHP + '/' + defenderMaxHP + ' HP';
        }

        // Action functions
        function saveBattle() {
            const outcome = document.getElementById('outcomeTitle').textContent;
            const data = {
                outcome: outcome,
                timestamp: new Date().toLocaleString(),
                rounds: document.getElementById('battleDuration').textContent
            };
            
            localStorage.setItem('battleResult', JSON.stringify(data));
            alert('Battle results saved successfully!');
        }

        function exportResults() {
            const results = document.getElementById('resultsSection').innerText;
            const blob = new Blob([results], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'battle-analysis.txt';
            a.click();
            URL.revokeObjectURL(url);
        }

        function shareBattle() {
            const outcome = document.getElementById('outcomeTitle').textContent;
            const probability = document.getElementById('victoryProbability').textContent;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Battle Analysis Results',
                    text: `Battle Outcome: ${outcome} - Victory Probability: ${probability}`,
                    url: window.location.href
                });
            } else {
                alert('Share functionality not available. Results copied to clipboard.');
                navigator.clipboard.writeText(`Battle Analysis: ${outcome} - ${probability} victory chance`);
            }
        }

        function resetCalculator() {
            // Reset form to default values
            document.getElementById('attackerType').value = 'warrior';
            document.getElementById('defenderType').value = 'tank';
            document.getElementById('battleRounds').value = '3';
            document.getElementById('battleEnvironment').value = 'plains';
            
            // Update stats
            updateCombatantStats();
            updateWeaponStats();
            
            // Hide results
            resultsSection.style.display = 'none';
        }
    </script>
</body>
</html>
