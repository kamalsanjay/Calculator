<?php
/**
 * XP Calculator
 * File: gaming/xp-calculator.php
 * Description: Calculate experience points, level progression, and gaming milestones
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XP Calculator - Experience Points & Level Progression Tool</title>
    <meta name="description" content="Calculate experience points, level progression, gaming milestones, and track your journey to max level.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: clamp(20px, 5vw, 30px); border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: clamp(1.5rem, 4vw, 2rem); margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: clamp(0.9rem, 2.5vw, 1.05rem); line-height: 1.6; }
        
        .calculator-card { background: white; padding: clamp(20px, 5vw, 35px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-tabs { display: flex; gap: 10px; margin-bottom: 25px; border-bottom: 2px solid #f8f9fa; flex-wrap: wrap; }
        .tab-btn { background: none; border: none; padding: 12px 20px; font-size: 1rem; cursor: pointer; transition: all 0.3s; border-bottom: 3px solid transparent; white-space: nowrap; }
        .tab-btn.active { color: #667eea; border-bottom-color: #667eea; font-weight: 600; }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .input-sections { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: clamp(15px, 4vw, 25px); margin-bottom: 25px; }
        
        .input-group { background: #f8f9fa; padding: clamp(15px, 4vw, 25px); border-radius: 12px; }
        .input-group h3 { color: #2c3e50; margin-bottom: 15px; font-size: clamp(1rem, 3vw, 1.2rem); display: flex; align-items: center; gap: 8px; }
        
        .input-row { display: flex; gap: 15px; align-items: end; margin-bottom: 15px; }
        .input-wrapper { flex: 1; }
        .input-wrapper label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.9rem; }
        .input-field { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-field:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .game-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; }
        .game-select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .slider-container { margin-bottom: 20px; }
        .slider-label { display: flex; justify-content: between; margin-bottom: 8px; }
        .slider-label span { color: #34495e; font-weight: 600; }
        .slider-value { color: #667eea; font-weight: bold; }
        .custom-slider { width: 100%; height: 8px; border-radius: 5px; background: #e0e0e0; outline: none; margin: 10px 0; }
        
        .calculate-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 16px 30px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin: 20px 0; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        
        .results-section { margin-top: 30px; }
        
        .xp-overview { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .overview-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; text-align: center; border-left: 4px solid #667eea; }
        .stat-value { font-size: 1.4rem; font-weight: bold; color: #5e35b1; margin-bottom: 5px; }
        .stat-label { color: #7f8c8d; font-size: 0.9rem; }
        
        .progression-timeline { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .timeline-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .timeline-header h3 { color: #2c3e50; font-size: 1.1rem; }
        
        .timeline-visual { position: relative; height: 60px; background: #e0e0e0; border-radius: 30px; margin: 20px 0; overflow: hidden; }
        .timeline-progress { height: 100%; background: linear-gradient(90deg, #27ae60, #2ecc71); transition: all 0.3s; position: relative; }
        .timeline-marker { position: absolute; top: -25px; transform: translateX(-50%); font-size: 0.8rem; color: #7f8c8d; }
        .current-level-marker { position: absolute; top: -40px; transform: translateX(-50%); background: #e74c3c; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold; }
        
        .milestone-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 20px; }
        .milestone-card { background: white; padding: 20px; border-radius: 10px; text-align: center; }
        .milestone-icon { font-size: 2rem; margin-bottom: 10px; }
        .milestone-value { font-size: 1.3rem; font-weight: bold; color: #667eea; margin-bottom: 5px; }
        .milestone-label { color: #7f8c8d; font-size: 0.9rem; }
        
        .detailed-breakdown { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .breakdown-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .breakdown-header h3 { color: #2c3e50; font-size: 1.1rem; }
        
        .level-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        .level-table th, .level-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .level-table th { background: #667eea; color: white; font-weight: 600; }
        .level-table tr:hover { background: rgba(102, 126, 234, 0.05); }
        
        .efficiency-calculator { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .efficiency-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .efficiency-header h3 { color: #2c3e50; font-size: 1.1rem; }
        
        .efficiency-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; }
        .efficiency-card { background: white; padding: 20px; border-radius: 10px; }
        .efficiency-title { color: #2c3e50; font-weight: 600; margin-bottom: 10px; }
        .efficiency-value { font-size: 1.2rem; font-weight: bold; color: #667eea; margin-bottom: 5px; }
        .efficiency-desc { color: #7f8c8d; font-size: 0.9rem; }
        
        .game-presets { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .presets-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .presets-header h3 { color: #2c3e50; font-size: 1.1rem; }
        
        .presets-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .preset-card { background: white; padding: 20px; border-radius: 10px; text-align: center; cursor: pointer; transition: all 0.3s; border: 2px solid #e0e0e0; }
        .preset-card:hover { border-color: #667eea; transform: translateY(-2px); }
        .preset-icon { font-size: 2rem; margin-bottom: 10px; }
        .preset-name { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .preset-desc { color: #7f8c8d; font-size: 0.8rem; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: clamp(1.2rem, 4vw, 1.4rem); }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: clamp(1rem, 3vw, 1.1rem); }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        
        .xp-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin: 20px 0; }
        .xp-card { background: #ede7f6; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; }
        .xp-card h4 { color: #4527a0; margin-bottom: 10px; }
        
        .formula-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: clamp(0.8rem, 2vw, 0.9rem); }
        .formula-table th, .formula-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .formula-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .formula-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-row { flex-direction: column; }
            .overview-grid { grid-template-columns: repeat(2, 1fr); }
            .milestone-grid { grid-template-columns: repeat(2, 1fr); }
            .efficiency-grid { grid-template-columns: 1fr; }
            .presets-grid { grid-template-columns: repeat(2, 1fr); }
            .calculator-tabs { overflow-x: auto; }
        }
        
        @media (max-width: 480px) {
            .overview-grid { grid-template-columns: 1fr; }
            .milestone-grid { grid-template-columns: 1fr; }
            .presets-grid { grid-template-columns: 1fr; }
            .input-sections { grid-template-columns: 1fr; }
            .calculator-card { padding: 15px; }
            .header { padding: 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚡ XP Calculator</h1>
            <p>Calculate experience points, track level progression, and plan your gaming journey to max level</p>
        </div>

        <div class="calculator-card">
            <div class="calculator-tabs">
                <button class="tab-btn active" data-tab="level-progression">Level Progression</button>
                <button class="tab-btn" data-tab="xp-calculator">XP Calculator</button>
                <button class="tab-btn" data-tab="time-estimation">Time Estimation</button>
                <button class="tab-btn" data-tab="efficiency-analysis">Efficiency Analysis</button>
            </div>

            <!-- Level Progression Tab -->
            <div class="tab-content active" id="level-progression">
                <div class="input-sections">
                    <div class="input-group">
                        <h3>🎮 Game System</h3>
                        <div class="input-wrapper">
                            <label for="gameSystem">Game/System</label>
                            <select id="gameSystem" class="game-select">
                                <option value="custom">Custom System</option>
                                <option value="wow">World of Warcraft</option>
                                <option value="ffxiv">Final Fantasy XIV</option>
                                <option value="eso">Elder Scrolls Online</option>
                                <option value="diablo">Diablo Series</option>
                                <option value="pokemon">Pokémon Series</option>
                                <option value="minecraft">Minecraft</option>
                                <option value="rpg">Generic RPG</option>
                                <option value="mobile">Mobile Game</option>
                            </select>
                        </div>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="maxLevel">Max Level</label>
                                <input type="number" id="maxLevel" class="input-field" placeholder="100" value="100" min="1" max="1000" step="1">
                            </div>
                            <div class="input-wrapper">
                                <label for="xpCurve">XP Curve</label>
                                <select id="xpCurve" class="game-select">
                                    <option value="linear">Linear</option>
                                    <option value="exponential" selected>Exponential</option>
                                    <option value="quadratic">Quadratic</option>
                                    <option value="logarithmic">Logarithmic</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <h3>👤 Player Status</h3>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="currentLevel">Current Level</label>
                                <input type="number" id="currentLevel" class="input-field" placeholder="1" value="1" min="1" max="1000" step="1">
                            </div>
                            <div class="input-wrapper">
                                <label for="currentXP">Current XP</label>
                                <input type="number" id="currentXP" class="input-field" placeholder="0" value="0" min="0" step="1">
                            </div>
                        </div>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="targetLevel">Target Level</label>
                                <input type="number" id="targetLevel" class="input-field" placeholder="100" value="100" min="1" max="1000" step="1">
                            </div>
                            <div class="input-wrapper">
                                <label for="xpPerHour">XP per Hour</label>
                                <input type="number" id="xpPerHour" class="input-field" placeholder="1000" value="1000" min="1" step="1">
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <h3>⚡ XP Parameters</h3>
                        <div class="input-wrapper">
                            <label for="baseXP">Base XP (Level 1)</label>
                            <input type="number" id="baseXP" class="input-field" placeholder="100" value="100" min="1" step="1">
                        </div>
                        <div class="slider-container">
                            <div class="slider-label">
                                <span>XP Growth Factor</span>
                                <span class="slider-value" id="growthFactorValue">1.1</span>
                            </div>
                            <input type="range" id="growthFactor" class="custom-slider" min="1.0" max="2.0" value="1.1" step="0.05">
                        </div>
                        <div class="checkbox-group" style="display: flex; flex-direction: column; gap: 10px; margin-top: 15px;">
                            <label style="display: flex; align-items: center; gap: 8px;">
                                <input type="checkbox" id="xpBoost" checked>
                                <span>Include XP Boost (50%)</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px;">
                                <input type="checkbox" id="restedXP">
                                <span>Include Rested XP</span>
                            </label>
                        </div>
                    </div>
                </div>

                <button class="calculate-btn" onclick="calculateProgression()">Calculate Progression</button>

                <div class="results-section">
                    <div class="xp-overview">
                        <div class="overview-grid">
                            <div class="stat-card">
                                <div class="stat-value" id="totalXPNeeded">0</div>
                                <div class="stat-label">Total XP Needed</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value" id="xpRemaining">0</div>
                                <div class="stat-label">XP Remaining</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value" id="completionPercent">0%</div>
                                <div class="stat-label">Completion</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value" id="timeRequired">0h</div>
                                <div class="stat-label">Time Required</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value" id="avgXPPerLevel">0</div>
                                <div class="stat-label">Avg XP/Level</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value" id="levelsPerHour">0</div>
                                <div class="stat-label">Levels/Hour</div>
                            </div>
                        </div>
                    </div>

                    <div class="progression-timeline">
                        <div class="timeline-header">
                            <h3>📊 Progression Timeline</h3>
                        </div>
                        <div class="timeline-visual">
                            <div class="timeline-progress" id="timelineProgress" style="width: 0%;"></div>
                            <div class="current-level-marker" id="currentLevelMarker" style="left: 0%;">Level 1</div>
                            <div class="timeline-marker" style="left: 25%;">25%</div>
                            <div class="timeline-marker" style="left: 50%;">50%</div>
                            <div class="timeline-marker" style="left: 75%;">75%</div>
                            <div class="timeline-marker" style="left: 100%;">100%</div>
                        </div>
                        
                        <div class="milestone-grid">
                            <div class="milestone-card">
                                <div class="milestone-icon">🎯</div>
                                <div class="milestone-value" id="milestone25">Level 25</div>
                                <div class="milestone-label" id="milestone25XP">0 XP</div>
                            </div>
                            <div class="milestone-card">
                                <div class="milestone-icon">⭐</div>
                                <div class="milestone-value" id="milestone50">Level 50</div>
                                <div class="milestone-label" id="milestone50XP">0 XP</div>
                            </div>
                            <div class="milestone-card">
                                <div class="milestone-icon">🏆</div>
                                <div class="milestone-value" id="milestone75">Level 75</div>
                                <div class="milestone-label" id="milestone75XP">0 XP</div>
                            </div>
                            <div class="milestone-card">
                                <div class="milestone-icon">👑</div>
                                <div class="milestone-value" id="milestoneMax">Level 100</div>
                                <div class="milestone-label" id="milestoneMaxXP">0 XP</div>
                            </div>
                        </div>
                    </div>

                    <div class="detailed-breakdown">
                        <div class="breakdown-header">
                            <h3>📈 Level Breakdown</h3>
                        </div>
                        <div style="overflow-x: auto;">
                            <table class="level-table">
                                <thead>
                                    <tr>
                                        <th>Level</th>
                                        <th>XP Required</th>
                                        <th>Cumulative XP</th>
                                        <th>Progress</th>
                                        <th>Time to Level</th>
                                    </tr>
                                </thead>
                                <tbody id="levelBreakdown">
                                    <!-- Filled by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- XP Calculator Tab -->
            <div class="tab-content" id="xp-calculator">
                <div class="input-sections">
                    <div class="input-group">
                        <h3>🎯 Activity Calculator</h3>
                        <div class="input-wrapper">
                            <label for="activityType">Activity Type</label>
                            <select id="activityType" class="game-select">
                                <option value="quest">Quest Completion</option>
                                <option value="monster">Monster Kill</option>
                                <option value="dungeon">Dungeon Run</option>
                                <option value="raid">Raid Completion</option>
                                <option value="pvp">PvP Match</option>
                                <option value="crafting">Crafting</option>
                                <option value="gathering">Gathering</option>
                            </select>
                        </div>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="activityXP">Base XP per Activity</label>
                                <input type="number" id="activityXP" class="input-field" placeholder="100" value="100" min="1" step="1">
                            </div>
                            <div class="input-wrapper">
                                <label for="activitiesPerHour">Activities per Hour</label>
                                <input type="number" id="activitiesPerHour" class="input-field" placeholder="10" value="10" min="1" step="1">
                            </div>
                        </div>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="sessionHours">Session Hours</label>
                                <input type="number" id="sessionHours" class="input-field" placeholder="2" value="2" min="0.5" max="24" step="0.5">
                            </div>
                            <div class="input-wrapper">
                                <label for="daysPerWeek">Days per Week</label>
                                <input type="number" id="daysPerWeek" class="input-field" placeholder="5" value="5" min="1" max="7" step="1">
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <h3>📊 Session Results</h3>
                        <div class="results-grid" style="display: grid; gap: 15px;">
                            <div style="background: white; padding: 15px; border-radius: 8px;">
                                <div style="font-size: 0.9rem; color: #7f8c8d;">Session XP</div>
                                <div style="font-size: 1.5rem; font-weight: bold; color: #667eea;" id="sessionXP">0</div>
                            </div>
                            <div style="background: white; padding: 15px; border-radius: 8px;">
                                <div style="font-size: 0.9rem; color: #7f8c8d;">Weekly XP</div>
                                <div style="font-size: 1.5rem; font-weight: bold; color: #667eea;" id="weeklyXP">0</div>
                            </div>
                            <div style="background: white; padding: 15px; border-radius: 8px;">
                                <div style="font-size: 0.9rem; color: #7f8c8d;">Levels per Week</div>
                                <div style="font-size: 1.5rem; font-weight: bold; color: #667eea;" id="levelsPerWeek">0</div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="calculate-btn" onclick="calculateXPSession()">Calculate Session</button>
            </div>

            <!-- Game Presets Section -->
            <div class="game-presets">
                <div class="presets-header">
                    <h3>🎮 Popular Game Presets</h3>
                </div>
                <div class="presets-grid">
                    <div class="preset-card" onclick="applyGamePreset('wow')">
                        <div class="preset-icon">🌍</div>
                        <div class="preset-name">World of Warcraft</div>
                        <div class="preset-desc">Max: 70, Exponential</div>
                    </div>
                    <div class="preset-card" onclick="applyGamePreset('ffxiv')">
                        <div class="preset-icon">⚔️</div>
                        <div class="preset-name">FFXIV</div>
                        <div class="preset-desc">Max: 90, Linear</div>
                    </div>
                    <div class="preset-card" onclick="applyGamePreset('eso')">
                        <div class="preset-icon">🐉</div>
                        <div class="preset-name">Elder Scrolls Online</div>
                        <div class="preset-desc">Max: 50 + CP</div>
                    </div>
                    <div class="preset-card" onclick="applyGamePreset('diablo')">
                        <div class="preset-icon">😈</div>
                        <div class="preset-name">Diablo Series</div>
                        <div class="preset-desc">Max: Varies</div>
                    </div>
                    <div class="preset-card" onclick="applyGamePreset('pokemon')">
                        <div class="preset-icon">⚡</div>
                        <div class="preset-name">Pokémon</div>
                        <div class="preset-desc">Max: 100</div>
                    </div>
                    <div class="preset-card" onclick="applyGamePreset('minecraft')">
                        <div class="preset-icon">⛏️</div>
                        <div class="preset-name">Minecraft</div>
                        <div class="preset-desc">Infinite Levels</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⚡ Experience Points (XP) Guide</h2>
            
            <p>Experience points (XP) are a fundamental game mechanic that measures character progression, skill development, and achievement in role-playing games and many other game genres.</p>

            <div class="xp-grid">
                <div class="xp-card">
                    <h4>🎯 What are XP Systems?</h4>
                    <p>XP systems track player progress through numerical values that accumulate as players complete activities, with milestones reached at certain thresholds (levels).</p>
                </div>
                <div class="xp-card">
                    <h4>📈 Common XP Curves</h4>
                    <p>Different games use various XP progression curves to balance early-game accessibility with late-game challenge and longevity.</p>
                </div>
                <div class="xp-card">
                    <h4>⚡ Optimization Strategies</h4>
                    <p>Efficient XP farming involves understanding game mechanics, identifying optimal activities, and leveraging bonuses and multipliers.</p>
                </div>
            </div>

            <h3>📊 Common XP Progression Formulas</h3>
            <table class="formula-table">
                <thead>
                    <tr>
                        <th>Curve Type</th>
                        <th>Formula</th>
                        <th>Description</th>
                        <th>Games Using</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Linear</strong></td>
                        <td>XP = Base × Level</td>
                        <td>Constant XP increase per level</td>
                        <td>Early RPGs, FFXIV</td>
                    </tr>
                    <tr>
                        <td><strong>Exponential</strong></td>
                        <td>XP = Base × Growth<sup>Level</sup></td>
                        <td>XP required grows exponentially</td>
                        <td>WoW, Diablo, Pokémon</td>
                    </tr>
                    <tr>
                        <td><strong>Quadratic</strong></td>
                        <td>XP = Base × Level<sup>2</sup></td>
                        <td>XP grows with level squared</td>
                        <td>D&D, Pathfinder</td>
                    </tr>
                    <tr>
                        <td><strong>Logarithmic</strong></td>
                        <td>XP = Base × log(Level)</td>
                        <td>Fast early, slow late progression</td>
                        <td>Some mobile games</td>
                    </tr>
                </tbody>
            </table>

            <h3>🎮 Game-Specific XP Systems</h3>
            <div class="formula-box">
                <strong>World of Warcraft:</strong> Exponential curve with expansion resets<br>
                <strong>Final Fantasy XIV:</strong> Mostly linear with main story emphasis<br>
                <strong>Elder Scrolls Online:</strong> Level 1-50 then Champion Points system<br>
                <strong>Diablo Series:</strong> Paragon levels after max level<br>
                <strong>Pokémon:</strong> Exponential with different growth rates per species<br>
                <strong>Minecraft:</strong> Levels for enchanting, no hard cap
            </div>

            <h3>⚡ XP Optimization Strategies</h3>
            <div class="xp-grid">
                <div class="xp-card">
                    <h4>🎯 Activity Selection</h4>
                    <p>Identify activities with the best XP/time ratio. Dungeons, raids, and specific quests often provide optimal returns.</p>
                </div>
                <div class="xp-card">
                    <h4>🕒 Time Management</h4>
                    <p>Schedule play sessions during XP bonus events and leverage rested XP mechanics when available.</p>
                </div>
                <div class="xp-card">
                    <h4>🔧 Gear & Consumables</h4>
                    <p>Use XP-boosting gear, potions, and food to maximize gains during grinding sessions.</p>
                </div>
            </div>

            <h3>📈 Efficiency Benchmarks</h3>
            <table class="formula-table">
                <thead>
                    <tr>
                        <th>Game Type</th>
                        <th>Good XP/Hour</th>
                        <th>Excellent XP/Hour</th>
                        <th>Optimal Activities</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>MMORPG</strong></td>
                        <td>50,000-100,000</td>
                        <td>200,000+</td>
                        <td>Dungeon spam, raid farming</td>
                    </tr>
                    <tr>
                        <td><strong>ARPG</strong></td>
                        <td>1-5 million</td>
                        <td>10 million+</td>
                        <td>Greater rifts, bounty runs</td>
                    </tr>
                    <tr>
                        <td><strong>Mobile RPG</strong></td>
                        <td>10,000-50,000</td>
                        <td>100,000+</td>
                        <td>Auto-battle, event stages</td>
                    </tr>
                    <tr>
                        <td><strong>Classic RPG</strong></td>
                        <td>1,000-5,000</td>
                        <td>10,000+</td>
                        <td>Boss farming, quest chains</td>
                    </tr>
                </tbody>
            </table>

            <h3>🎯 Leveling Psychology & Design</h3>
            <div class="formula-box">
                <strong>Early Game (Levels 1-20):</strong> Fast progression to hook players<br>
                <strong>Mid Game (Levels 21-70):</strong> Steady progression with meaningful rewards<br>
                <strong>Late Game (Levels 71+):</strong> Slower progression for longevity<br>
                <strong>End Game:</strong> Horizontal progression or infinite systems<br>
                <strong>Milestone Levels:</strong> Significant rewards at key levels (10, 20, 50, etc.)
            </div>

            <h3>🕒 Time Investment Analysis</h3>
            <ul>
                <li><strong>Casual Player:</strong> 5-10 hours/week, focuses on story and exploration</li>
                <li><strong>Regular Player:</strong> 15-25 hours/week, completes most content</li>
                <li><strong>Hardcore Player:</strong> 40+ hours/week, min-maxes efficiency</li>
                <li><strong>Speedrunner:</strong> Focuses on fastest possible leveling routes</li>
                <li><strong>Completionist:</strong> Values 100% completion over speed</li>
            </ul>

            <h3>⚡ Advanced XP Concepts</h3>
            <div class="xp-grid">
                <div class="xp-card">
                    <h4>📊 Diminishing Returns</h4>
                    <p>Many games implement systems where repeating the same activity provides reduced XP over time to encourage variety.</p>
                </div>
                <div class="xp-card">
                    <h4>🎁 Catch-up Mechanics</h4>
                    <p>Systems designed to help new or returning players reach current content quickly through XP bonuses.</p>
                </div>
                <div class="xp-card">
                    <h4>🔁 Prestige Systems</h4>
                    <p>After reaching max level, players can reset progress for special rewards in games like Call of Duty or Diablo 3.</p>
                </div>
            </div>

            <h3>🎮 Popular Leveling Strategies</h3>
            <ul>
                <li><strong>Questing:</strong> Following main story and side quests</li>
                <li><strong>Grinding:</strong> Repeatedly killing monsters in optimal locations</li>
                <li><strong>Dungeon Crawling:</strong> Running instances with groups</li>
                <li><strong>Crafting/Gathering:</strong> Alternative progression paths</li>
                <li><strong>PvP:</strong> Gaining XP through player versus player content</li>
                <li><strong>Daily/Weekly Tasks:</strong> Time-gated high-value activities</li>
            </ul>

            <h3>⚠️ Common Leveling Mistakes</h3>
            <div class="xp-grid">
                <div class="xp-card">
                    <h4>🚫 Inefficient Routing</h4>
                    <p>Wasting time traveling between low-value activities instead of optimizing routes.</p>
                </div>
                <div class="xp-card">
                    <h4>📊 Ignoring Bonuses</h4>
                    <p>Not using available XP boosts, rested XP, or event bonuses when available.</p>
                </div>
                <div class="xp-card">
                    <h4>🕒 Poor Time Management</h4>
                    <p>Spending too much time on low-XP activities or unnecessary perfectionism.</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⚡ XP Calculator - Experience Points & Level Progression Tool</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate experience points, track level progression, and optimize your gaming journey</p>
        </div>
    </div>

    <script>
        // DOM elements
        const gameSystemSelect = document.getElementById('gameSystem');
        const maxLevelInput = document.getElementById('maxLevel');
        const xpCurveSelect = document.getElementById('xpCurve');
        const currentLevelInput = document.getElementById('currentLevel');
        const currentXPInput = document.getElementById('currentXP');
        const targetLevelInput = document.getElementById('targetLevel');
        const xpPerHourInput = document.getElementById('xpPerHour');
        const baseXPInput = document.getElementById('baseXP');
        const growthFactorSlider = document.getElementById('growthFactor');
        const growthFactorValue = document.getElementById('growthFactorValue');
        const xpBoostCheck = document.getElementById('xpBoost');
        const restedXPCheck = document.getElementById('restedXP');

        // Results elements
        const totalXPNeededElement = document.getElementById('totalXPNeeded');
        const xpRemainingElement = document.getElementById('xpRemaining');
        const completionPercentElement = document.getElementById('completionPercent');
        const timeRequiredElement = document.getElementById('timeRequired');
        const avgXPPerLevelElement = document.getElementById('avgXPPerLevel');
        const levelsPerHourElement = document.getElementById('levelsPerHour');
        
        const timelineProgressElement = document.getElementById('timelineProgress');
        const currentLevelMarkerElement = document.getElementById('currentLevelMarker');
        
        const milestone25Element = document.getElementById('milestone25');
        const milestone25XPElement = document.getElementById('milestone25XP');
        const milestone50Element = document.getElementById('milestone50');
        const milestone50XPElement = document.getElementById('milestone50XP');
        const milestone75Element = document.getElementById('milestone75');
        const milestone75XPElement = document.getElementById('milestone75XP');
        const milestoneMaxElement = document.getElementById('milestoneMax');
        const milestoneMaxXPElement = document.getElementById('milestoneMaxXP');
        
        const levelBreakdownElement = document.getElementById('levelBreakdown');

        // Tab functionality
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                button.classList.add('active');
                document.getElementById(button.dataset.tab).classList.add('active');
            });
        });

        // Slider functionality
        growthFactorSlider.addEventListener('input', function() {
            growthFactorValue.textContent = this.value;
        });

        // Game presets data
        const gamePresets = {
            wow: {
                maxLevel: 70,
                xpCurve: 'exponential',
                baseXP: 400,
                growthFactor: 1.1,
                xpPerHour: 500000
            },
            ffxiv: {
                maxLevel: 90,
                xpCurve: 'linear',
                baseXP: 300,
                growthFactor: 1.05,
                xpPerHour: 300000
            },
            eso: {
                maxLevel: 50,
                xpCurve: 'quadratic',
                baseXP: 1000,
                growthFactor: 1.15,
                xpPerHour: 200000
            },
            diablo: {
                maxLevel: 70,
                xpCurve: 'exponential',
                baseXP: 100,
                growthFactor: 1.2,
                xpPerHour: 5000000
            },
            pokemon: {
                maxLevel: 100,
                xpCurve: 'exponential',
                baseXP: 50,
                growthFactor: 1.08,
                xpPerHour: 5000
            },
            minecraft: {
                maxLevel: 100,
                xpCurve: 'exponential',
                baseXP: 7,
                growthFactor: 1.12,
                xpPerHour: 1000
            }
        };

        // Initial calculation
        calculateProgression();

        function calculateProgression() {
            // Get input values
            const maxLevel = parseInt(maxLevelInput.value);
            const currentLevel = parseInt(currentLevelInput.value);
            const currentXP = parseInt(currentXPInput.value);
            const targetLevel = Math.min(parseInt(targetLevelInput.value), maxLevel);
            const xpPerHour = parseInt(xpPerHourInput.value);
            const baseXP = parseInt(baseXPInput.value);
            const growthFactor = parseFloat(growthFactorSlider.value);
            const xpCurve = xpCurveSelect.value;
            const hasXPBoost = xpBoostCheck.checked;
            const hasRestedXP = restedXPCheck.checked;

            // Calculate XP requirements
            const xpRequirements = calculateXPRequirements(maxLevel, baseXP, growthFactor, xpCurve);
            const totalXPNeeded = calculateTotalXP(currentLevel, targetLevel, xpRequirements);
            const xpRemaining = totalXPNeeded - currentXP;
            
            // Apply modifiers
            let effectiveXPPerHour = xpPerHour;
            if (hasXPBoost) effectiveXPPerHour *= 1.5;
            if (hasRestedXP) effectiveXPPerHour *= 1.2;

            // Calculate metrics
            const completionPercent = Math.min(((currentXP / totalXPNeeded) * 100), 100).toFixed(1);
            const timeRequired = xpRemaining > 0 ? (xpRemaining / effectiveXPPerHour).toFixed(1) : 0;
            const avgXPPerLevel = Math.round(totalXPNeeded / (targetLevel - currentLevel));
            const levelsPerHour = (effectiveXPPerHour / avgXPPerLevel).toFixed(2);

            // Update overview
            updateOverview(totalXPNeeded, xpRemaining, completionPercent, timeRequired, avgXPPerLevel, levelsPerHour);
            
            // Update timeline
            updateTimeline(currentLevel, targetLevel, completionPercent);
            
            // Update milestones
            updateMilestones(maxLevel, xpRequirements);
            
            // Update level breakdown
            updateLevelBreakdown(currentLevel, targetLevel, xpRequirements, effectiveXPPerHour);
        }

        function calculateXPRequirements(maxLevel, baseXP, growthFactor, curveType) {
            const requirements = [];
            let cumulativeXP = 0;
            
            for (let level = 1; level <= maxLevel; level++) {
                let xpRequired;
                
                switch (curveType) {
                    case 'linear':
                        xpRequired = baseXP * level;
                        break;
                    case 'exponential':
                        xpRequired = baseXP * Math.pow(growthFactor, level - 1);
                        break;
                    case 'quadratic':
                        xpRequired = baseXP * Math.pow(level, 2);
                        break;
                    case 'logarithmic':
                        xpRequired = baseXP * Math.log(level + 1);
                        break;
                    default:
                        xpRequired = baseXP * Math.pow(growthFactor, level - 1);
                }
                
                cumulativeXP += Math.round(xpRequired);
                requirements.push({
                    level: level,
                    xpRequired: Math.round(xpRequired),
                    cumulativeXP: cumulativeXP
                });
            }
            
            return requirements;
        }

        function calculateTotalXP(fromLevel, toLevel, requirements) {
            if (fromLevel >= toLevel) return 0;
            
            const fromCumulative = fromLevel > 1 ? requirements[fromLevel - 2].cumulativeXP : 0;
            const toCumulative = requirements[toLevel - 1].cumulativeXP;
            
            return toCumulative - fromCumulative;
        }

        function updateOverview(totalXPNeeded, xpRemaining, completionPercent, timeRequired, avgXPPerLevel, levelsPerHour) {
            totalXPNeededElement.textContent = formatNumber(totalXPNeeded);
            xpRemainingElement.textContent = formatNumber(xpRemaining);
            completionPercentElement.textContent = completionPercent + '%';
            timeRequiredElement.textContent = timeRequired + 'h';
            avgXPPerLevelElement.textContent = formatNumber(avgXPPerLevel);
            levelsPerHourElement.textContent = levelsPerHour;
        }

        function updateTimeline(currentLevel, targetLevel, completionPercent) {
            timelineProgressElement.style.width = completionPercent + '%';
            currentLevelMarkerElement.textContent = 'Level ' + currentLevel;
            currentLevelMarkerElement.style.left = completionPercent + '%';
        }

        function updateMilestones(maxLevel, requirements) {
            const milestones = [25, 50, 75, maxLevel];
            const milestoneElements = [
                { level: milestone25Element, xp: milestone25XPElement },
                { level: milestone50Element, xp: milestone50XPElement },
                { level: milestone75Element, xp: milestone75XPElement },
                { level: milestoneMaxElement, xp: milestoneMaxXPElement }
            ];
            
            milestones.forEach((milestone, index) => {
                const actualMilestone = Math.min(milestone, maxLevel);
                const xpInfo = requirements[actualMilestone - 1];
                
                milestoneElements[index].level.textContent = 'Level ' + actualMilestone;
                milestoneElements[index].xp.textContent = formatNumber(xpInfo.cumulativeXP) + ' XP';
            });
        }

        function updateLevelBreakdown(currentLevel, targetLevel, requirements, xpPerHour) {
            levelBreakdownElement.innerHTML = '';
            
            for (let level = currentLevel; level <= targetLevel; level++) {
                const xpInfo = requirements[level - 1];
                const timeToLevel = (xpInfo.xpRequired / xpPerHour).toFixed(1);
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${level}</td>
                    <td>${formatNumber(xpInfo.xpRequired)}</td>
                    <td>${formatNumber(xpInfo.cumulativeXP)}</td>
                    <td>${level === currentLevel ? 'Current' : 'Pending'}</td>
                    <td>${timeToLevel}h</td>
                `;
                levelBreakdownElement.appendChild(row);
            }
        }

        function calculateXPSession() {
            const activityXP = parseInt(document.getElementById('activityXP').value);
            const activitiesPerHour = parseInt(document.getElementById('activitiesPerHour').value);
            const sessionHours = parseFloat(document.getElementById('sessionHours').value);
            const daysPerWeek = parseInt(document.getElementById('daysPerWeek').value);
            
            const sessionXP = activityXP * activitiesPerHour * sessionHours;
            const weeklyXP = sessionXP * daysPerWeek;
            const levelsPerWeek = (weeklyXP / 10000).toFixed(1); // Simplified calculation
            
            document.getElementById('sessionXP').textContent = formatNumber(sessionXP);
            document.getElementById('weeklyXP').textContent = formatNumber(weeklyXP);
            document.getElementById('levelsPerWeek').textContent = levelsPerWeek;
        }

        function applyGamePreset(preset) {
            const data = gamePresets[preset];
            
            gameSystemSelect.value = preset;
            maxLevelInput.value = data.maxLevel;
            xpCurveSelect.value = data.xpCurve;
            baseXPInput.value = data.baseXP;
            growthFactorSlider.value = data.growthFactor;
            growthFactorValue.textContent = data.growthFactor;
            xpPerHourInput.value = data.xpPerHour;
            targetLevelInput.value = data.maxLevel;
            
            calculateProgression();
        }

        function formatNumber(num) {
            if (num >= 1000000) {
                return (num / 1000000).toFixed(1) + 'M';
            } else if (num >= 1000) {
                return (num / 1000).toFixed(1) + 'K';
            }
            return num.toString();
        }

        // Make functions available globally
        window.calculateProgression = calculateProgression;
        window.calculateXPSession = calculateXPSession;
        window.applyGamePreset = applyGamePreset;
    </script>
</body>
</html>
