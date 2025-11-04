<?php
/**
 * Fortnite Stats Calculator
 * File: gaming/fortnite-stats-calculator.php
 * Description: Calculate Fortnite statistics, track performance, and analyze gaming metrics
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fortnite Stats Calculator - Performance Tracking & Analysis</title>
    <meta name="description" content="Calculate Fortnite statistics, track performance metrics, analyze K/D ratios, and improve your gaming skills.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: clamp(20px, 5vw, 30px); border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: clamp(1.5rem, 4vw, 2rem); margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: clamp(0.9rem, 2.5vw, 1.05rem); line-height: 1.6; }
        
        .calculator-card { background: white; padding: clamp(20px, 5vw, 35px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .player-setup { margin-bottom: 30px; }
        .setup-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: clamp(15px, 4vw, 25px); margin-bottom: 25px; }
        
        .input-group { background: #f8f9fa; padding: clamp(15px, 4vw, 25px); border-radius: 12px; }
        .input-group h3 { color: #2c3e50; margin-bottom: 15px; font-size: clamp(1rem, 3vw, 1.2rem); display: flex; align-items: center; gap: 8px; }
        
        .input-row { display: flex; gap: 15px; align-items: end; margin-bottom: 15px; }
        .input-wrapper { flex: 1; }
        .input-wrapper label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.9rem; }
        .input-field { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-field:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .mode-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; }
        .mode-select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .calculate-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 16px 30px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin: 20px 0; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        
        .results-section { margin-top: 30px; }
        
        .stats-overview { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .overview-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; text-align: center; border-left: 4px solid #667eea; }
        .stat-value { font-size: 1.4rem; font-weight: bold; color: #5e35b1; margin-bottom: 5px; }
        .stat-label { color: #7f8c8d; font-size: 0.9rem; }
        
        .performance-metrics { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .metrics-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .metrics-header h3 { color: #2c3e50; font-size: 1.1rem; }
        
        .metrics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .metric-card { background: white; padding: 20px; border-radius: 10px; text-align: center; }
        .metric-icon { font-size: 2rem; margin-bottom: 10px; }
        .metric-value { font-size: 1.3rem; font-weight: bold; color: #667eea; margin-bottom: 5px; }
        .metric-label { color: #7f8c8d; font-size: 0.9rem; }
        
        .skill-assessment { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .assessment-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .assessment-header h3 { color: #2c3e50; font-size: 1.1rem; }
        
        .skill-level { display: flex; align-items: center; gap: 15px; padding: 20px; background: white; border-radius: 10px; margin-bottom: 20px; }
        .skill-icon { font-size: 2.5rem; }
        .skill-text { flex: 1; }
        .skill-title { font-weight: 600; color: #2c3e50; margin-bottom: 5px; font-size: 1.2rem; }
        .skill-desc { color: #7f8c8d; font-size: 0.9rem; line-height: 1.5; }
        
        .progress-bar { height: 10px; background: #e0e0e0; border-radius: 5px; overflow: hidden; margin-top: 10px; }
        .progress-fill { height: 100%; transition: all 0.3s; }
        
        .improvement-tips { background: white; padding: 20px; border-radius: 10px; border-left: 4px solid #e74c3c; }
        .tips-header { color: #c0392b; margin-bottom: 15px; }
        .tips-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 10px; }
        .tip-item { display: flex; align-items: start; gap: 10px; margin-bottom: 10px; }
        .tip-bullet { color: #e74c3c; font-weight: bold; min-width: 20px; }
        
        .comparison-tools { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .comparison-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .comparison-header h3 { color: #2c3e50; font-size: 1.1rem; }
        
        .comparison-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .comparison-card { background: white; padding: 20px; border-radius: 10px; }
        .comparison-title { color: #2c3e50; font-weight: 600; margin-bottom: 15px; }
        .comparison-stats { display: flex; flex-direction: column; gap: 10px; }
        .stat-row { display: flex; justify-content: between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f8f9fa; }
        .stat-name { color: #7f8c8d; }
        .stat-comparison { color: #667eea; font-weight: 600; }
        
        .quick-presets { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
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
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin: 20px 0; }
        .stats-card { background: #ede7f6; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; }
        .stats-card h4 { color: #4527a0; margin-bottom: 10px; }
        
        .rankings-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: clamp(0.8rem, 2vw, 0.9rem); }
        .rankings-table th, .rankings-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .rankings-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .rankings-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; font-size: clamp(0.9rem, 2.5vw, 1rem); }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-row { flex-direction: column; }
            .overview-grid { grid-template-columns: repeat(2, 1fr); }
            .metrics-grid { grid-template-columns: repeat(2, 1fr); }
            .skill-level { flex-direction: column; text-align: center; }
            .tips-list { grid-template-columns: 1fr; }
            .comparison-grid { grid-template-columns: 1fr; }
            .presets-grid { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (max-width: 480px) {
            .overview-grid { grid-template-columns: 1fr; }
            .metrics-grid { grid-template-columns: 1fr; }
            .presets-grid { grid-template-columns: 1fr; }
            .setup-grid { grid-template-columns: 1fr; }
            .calculator-card { padding: 15px; }
            .header { padding: 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎮 Fortnite Stats Calculator</h1>
            <p>Calculate your Fortnite statistics, track performance metrics, and analyze your gaming progress</p>
        </div>

        <div class="calculator-card">
            <div class="player-setup">
                <div class="setup-grid">
                    <div class="input-group">
                        <h3>👤 Player Information</h3>
                        <div class="input-wrapper">
                            <label for="playerName">Player Name</label>
                            <input type="text" id="playerName" class="input-field" placeholder="Enter your username" value="ProPlayer123">
                        </div>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="gameMode">Game Mode</label>
                                <select id="gameMode" class="mode-select">
                                    <option value="solo">Solo</option>
                                    <option value="duos">Duos</option>
                                    <option value="squads" selected>Squads</option>
                                    <option value="arena">Arena</option>
                                    <option value="tournament">Tournament</option>
                                </select>
                            </div>
                            <div class="input-wrapper">
                                <label for="platform">Platform</label>
                                <select id="platform" class="mode-select">
                                    <option value="pc">PC</option>
                                    <option value="ps" selected>PlayStation</option>
                                    <option value="xbox">Xbox</option>
                                    <option value="switch">Switch</option>
                                    <option value="mobile">Mobile</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <h3>📊 Match Statistics</h3>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="matchesPlayed">Matches Played</label>
                                <input type="number" id="matchesPlayed" class="input-field" placeholder="100" value="100" min="1" step="1">
                            </div>
                            <div class="input-wrapper">
                                <label for="wins">Victory Royales</label>
                                <input type="number" id="wins" class="input-field" placeholder="15" value="15" min="0" step="1">
                            </div>
                        </div>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="kills">Total Kills</label>
                                <input type="number" id="kills" class="input-field" placeholder="500" value="500" min="0" step="1">
                            </div>
                            <div class="input-wrapper">
                                <label for="deaths">Total Deaths</label>
                                <input type="number" id="deaths" class="input-field" placeholder="400" value="400" min="0" step="1">
                            </div>
                        </div>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="damage">Total Damage</label>
                                <input type="number" id="damage" class="input-field" placeholder="75000" value="75000" min="0" step="100">
                            </div>
                            <div class="input-wrapper">
                                <label for="survivalTime">Avg Survival (min)</label>
                                <input type="number" id="survivalTime" class="input-field" placeholder="12.5" value="12.5" min="0" step="0.1">
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <h3>🎯 Advanced Metrics</h3>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="headshotRate">Headshot %</label>
                                <input type="number" id="headshotRate" class="input-field" placeholder="25" value="25" min="0" max="100" step="0.1">
                            </div>
                            <div class="input-wrapper">
                                <label for="accuracy">Accuracy %</label>
                                <input type="number" id="accuracy" class="input-field" placeholder="45" value="45" min="0" max="100" step="0.1">
                            </div>
                        </div>
                        <div class="input-row">
                            <div class="input-wrapper">
                                <label for="buildsPlaced">Builds Placed</label>
                                <input type="number" id="buildsPlaced" class="input-field" placeholder="5000" value="5000" min="0" step="100">
                            </div>
                            <div class="input-wrapper">
                                <label for="materialsUsed">Materials Used</label>
                                <input type="number" id="materialsUsed" class="input-field" placeholder="15000" value="15000" min="0" step="100">
                            </div>
                        </div>
                    </div>
                </div>

                <button class="calculate-btn" id="calculateButton">Calculate Stats</button>
            </div>

            <div class="results-section">
                <div class="stats-overview">
                    <div class="overview-grid">
                        <div class="stat-card">
                            <div class="stat-value" id="kdRatio">1.25</div>
                            <div class="stat-label">K/D Ratio</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="winRate">15%</div>
                            <div class="stat-label">Win Rate</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="avgKills">5.0</div>
                            <div class="stat-label">Avg Kills/Match</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="avgDamage">750</div>
                            <div class="stat-label">Avg Damage/Match</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="survivalScore">7.8</div>
                            <div class="stat-label">Survival Score</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="skillRating">82</div>
                            <div class="stat-label">Skill Rating</div>
                        </div>
                    </div>
                </div>

                <div class="performance-metrics">
                    <div class="metrics-header">
                        <h3>📈 Performance Metrics</h3>
                    </div>
                    <div class="metrics-grid">
                        <div class="metric-card">
                            <div class="metric-icon">🎯</div>
                            <div class="metric-value" id="killsPerMinute">0.42</div>
                            <div class="metric-label">Kills per Minute</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon">💥</div>
                            <div class="metric-value" id="damagePerKill">150.0</div>
                            <div class="metric-label">Damage per Kill</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon">🏆</div>
                            <div class="metric-value" id="top10Rate">32%</div>
                            <div class="metric-label">Top 10 Rate</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon">⚡</div>
                            <div class="metric-value" id="buildRate">8.3</div>
                            <div class="metric-label">Builds per Minute</div>
                        </div>
                    </div>
                </div>

                <div class="skill-assessment">
                    <div class="assessment-header">
                        <h3>⭐ Skill Level Assessment</h3>
                    </div>
                    <div class="skill-level">
                        <div class="skill-icon" id="skillIcon">⭐</div>
                        <div class="skill-text">
                            <div class="skill-title" id="skillTitle">Advanced Player</div>
                            <div class="skill-desc" id="skillDesc">Strong performance with consistent results. Good game sense and mechanical skills.</div>
                            <div class="progress-bar">
                                <div class="progress-fill" id="skillProgress" style="width: 75%; background: #f39c12;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="improvement-tips">
                        <h4 class="tips-header">💡 Improvement Tips</h4>
                        <div class="tips-list" id="improvementTips">
                            <div class="tip-item">
                                <span class="tip-bullet">•</span>
                                <span>Practice building techniques in Creative mode</span>
                            </div>
                            <div class="tip-item">
                                <span class="tip-bullet">•</span>
                                <span>Focus on positioning and rotation strategies</span>
                            </div>
                            <div class="tip-item">
                                <span class="tip-bullet">•</span>
                                <span>Work on editing speed and accuracy</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="comparison-tools">
                    <div class="comparison-header">
                        <h3>📊 Performance Comparison</h3>
                    </div>
                    <div class="comparison-grid">
                        <div class="comparison-card">
                            <div class="comparison-title">vs Average Players</div>
                            <div class="comparison-stats">
                                <div class="stat-row">
                                    <span class="stat-name">K/D Ratio</span>
                                    <span class="stat-comparison" id="vsAvgKD">+42%</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-name">Win Rate</span>
                                    <span class="stat-comparison" id="vsAvgWin">+87%</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-name">Accuracy</span>
                                    <span class="stat-comparison" id="vsAvgAccuracy">+12%</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-name">Survival Time</span>
                                    <span class="stat-comparison" id="vsAvgSurvival">+25%</span>
                                </div>
                            </div>
                        </div>
                        <div class="comparison-card">
                            <div class="comparison-title">vs Pro Players</div>
                            <div class="comparison-stats">
                                <div class="stat-row">
                                    <span class="stat-name">K/D Ratio</span>
                                    <span class="stat-comparison" id="vsProKD">-35%</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-name">Win Rate</span>
                                    <span class="stat-comparison" id="vsProWin">-60%</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-name">Build Rate</span>
                                    <span class="stat-comparison" id="vsProBuild">-45%</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-name">Headshot %</span>
                                    <span class="stat-comparison" id="vsProHeadshot">-18%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="quick-presets">
                <div class="presets-header">
                    <h3>🚀 Quick Player Presets</h3>
                </div>
                <div class="presets-grid">
                    <div class="preset-card" onclick="applyPreset('beginner')">
                        <div class="preset-icon">👶</div>
                        <div class="preset-name">Beginner</div>
                        <div class="preset-desc">New player stats</div>
                    </div>
                    <div class="preset-card" onclick="applyPreset('casual')">
                        <div class="preset-icon">😊</div>
                        <div class="preset-name">Casual</div>
                        <div class="preset-desc">Regular player</div>
                    </div>
                    <div class="preset-card" onclick="applyPreset('advanced')">
                        <div class="preset-icon">⭐</div>
                        <div class="preset-name">Advanced</div>
                        <div class="preset-desc">Skilled player</div>
                    </div>
                    <div class="preset-card" onclick="applyPreset('pro')">
                        <div class="preset-icon">🔥</div>
                        <div class="preset-name">Pro Level</div>
                        <div class="preset-desc">Competitive stats</div>
                    </div>
                    <div class="preset-card" onclick="applyPreset('streamer')">
                        <div class="preset-icon">🎥</div>
                        <div class="preset-name">Streamer</div>
                        <div class="preset-desc">Content creator level</div>
                    </div>
                    <div class="preset-card" onclick="applyPreset('tournament')">
                        <div class="preset-icon">🏆</div>
                        <div class="preset-name">Tournament</div>
                        <div class="preset-desc">Competitive pro</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🎮 Fortnite Statistics Guide</h2>
            
            <p>Understanding your Fortnite statistics is crucial for improving your gameplay, tracking progress, and competing at higher levels.</p>

            <div class="stats-grid">
                <div class="stats-card">
                    <h4>🎯 K/D Ratio (Kill/Death)</h4>
                    <p>Measures your killing efficiency. A ratio above 1.0 means you get more kills than deaths. Professional players typically maintain 3.0+ K/D ratios.</p>
                </div>
                <div class="stats-card">
                    <h4>🏆 Win Rate</h4>
                    <p>The percentage of matches you win. Even top players rarely exceed 25% win rates in public matches due to the battle royale format.</p>
                </div>
                <div class="stats-card">
                    <h4>💥 Damage per Match</h4>
                    <p>Total damage dealt divided by matches played. This indicates your combat effectiveness and ability to pressure opponents.</p>
                </div>
            </div>

            <h3>📊 Skill Level Rankings</h3>
            <table class="rankings-table">
                <thead>
                    <tr>
                        <th>Skill Level</th>
                        <th>K/D Ratio</th>
                        <th>Win Rate</th>
                        <th>Avg Kills</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Beginner</strong></td>
                        <td>0.3 - 0.7</td>
                        <td>1% - 3%</td>
                        <td>0.5 - 1.5</td>
                        <td>Learning mechanics and basics</td>
                    </tr>
                    <tr>
                        <td><strong>Casual</strong></td>
                        <td>0.8 - 1.2</td>
                        <td>4% - 8%</td>
                        <td>1.6 - 2.5</td>
                        <td>Regular player, understands game flow</td>
                    </tr>
                    <tr>
                        <td><strong>Intermediate</strong></td>
                        <td>1.3 - 2.0</td>
                        <td>9% - 15%</td>
                        <td>2.6 - 4.0</td>
                        <td>Good mechanics and game sense</td>
                    </tr>
                    <tr>
                        <td><strong>Advanced</strong></td>
                        <td>2.1 - 3.5</td>
                        <td>16% - 25%</td>
                        <td>4.1 - 6.0</td>
                        <td>Strong player, consistent performance</td>
                    </tr>
                    <tr>
                        <td><strong>Expert</strong></td>
                        <td>3.6 - 6.0</td>
                        <td>26% - 40%</td>
                        <td>6.1 - 10.0</td>
                        <td>Top-tier player, tournament level</td>
                    </tr>
                    <tr>
                        <td><strong>Professional</strong></td>
                        <td>6.0+</td>
                        <td>40%+</td>
                        <td>10.0+</td>
                        <td>Competitive pro, content creator level</td>
                    </tr>
                </tbody>
            </table>

            <h3>🔬 Key Performance Metrics</h3>
            <div class="formula-box">
                <strong>K/D Ratio:</strong> Total Kills ÷ Total Deaths<br>
                <strong>Win Rate:</strong> (Wins ÷ Matches Played) × 100<br>
                <strong>Average Kills:</strong> Total Kills ÷ Matches Played<br>
                <strong>Average Damage:</strong> Total Damage ÷ Matches Played<br>
                <strong>Kills per Minute:</strong> Total Kills ÷ Total Playtime (minutes)<br>
                <strong>Damage per Kill:</strong> Total Damage ÷ Total Kills<br>
                <strong>Survival Score:</strong> (Average Survival Time ÷ 20) × 10
            </div>

            <h3>🎯 Accuracy & Combat Metrics</h3>
            <div class="stats-grid">
                <div class="stats-card">
                    <h4>🎯 Accuracy Percentage</h4>
                    <p>Measures how many shots hit their target. Good players maintain 40-60% accuracy, while pros can reach 60-80% in optimal conditions.</p>
                </div>
                <div class="stats-card">
                    <h4>💥 Headshot Rate</h4>
                    <p>The percentage of shots that hit headshots. Headshots deal double damage, making this crucial for quick eliminations.</p>
                </div>
                <div class="stats-card">
                    <h4>⚡ Build Rate</h4>
                    <p>Builds placed per minute. High-level players typically build 10-20 structures per minute during engagements.</p>
                </div>
            </div>

            <h3>🏆 Competitive Benchmarks</h3>
            <table class="rankings-table">
                <thead>
                    <tr>
                        <th>Metric</th>
                        <th>Casual</th>
                        <th>Advanced</th>
                        <th>Professional</th>
                        <th>Elite</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>K/D Ratio</strong></td>
                        <td>0.8 - 1.2</td>
                        <td>2.0 - 3.0</td>
                        <td>4.0 - 6.0</td>
                        <td>7.0+</td>
                    </tr>
                    <tr>
                        <td><strong>Win Rate</strong></td>
                        <td>5% - 10%</td>
                        <td>15% - 25%</td>
                        <td>30% - 45%</td>
                        <td>50%+</td>
                    </tr>
                    <tr>
                        <td><strong>Avg Kills/Match</strong></td>
                        <td>1.5 - 2.5</td>
                        <td>4.0 - 6.0</td>
                        <td>7.0 - 10.0</td>
                        <td>12.0+</td>
                    </tr>
                    <tr>
                        <td><strong>Accuracy %</strong></td>
                        <td>30% - 40%</td>
                        <td>45% - 55%</td>
                        <td>60% - 70%</td>
                        <td>75%+</td>
                    </tr>
                    <tr>
                        <td><strong>Headshot %</strong></td>
                        <td>15% - 25%</td>
                        <td>30% - 40%</td>
                        <td>45% - 55%</td>
                        <td>60%+</td>
                    </tr>
                </tbody>
            </table>

            <h3>⚡ Improvement Strategies</h3>
            <div class="formula-box">
                <strong>Mechanical Skills:</strong> Practice building and editing in Creative maps daily<br>
                <strong>Aim Training:</strong> Use aim trainers or Creative aim courses regularly<br>
                <strong>Game Sense:</strong> Watch professional players and analyze their decision-making<br>
                <strong>VOD Review:</strong> Record and review your gameplay to identify mistakes<br>
                <strong>Warm-up Routine:</strong> Develop a consistent pre-game warm-up routine<br>
                <strong>Meta Awareness:</strong> Stay updated on weapon balances and strategy changes
            </div>

            <h3>🎮 Platform-Specific Considerations</h3>
            <ul>
                <li><strong>PC:</strong> Highest skill ceiling with mouse & keyboard precision</li>
                <li><strong>Console:</strong> Controller gameplay with aim assist advantages</li>
                <li><strong>Mobile:</strong> Touch controls with different gameplay dynamics</li>
                <li><strong>Cross-platform:</strong> Consider platform advantages when comparing stats</li>
                <li><strong>Input Method:</strong> Controller vs Mouse & Keyboard have different stat expectations</li>
            </ul>

            <h3>📈 Tracking Progress Over Time</h3>
            <div class="stats-grid">
                <div class="stats-card">
                    <h4>📅 Weekly Goals</h4>
                    <p>Set achievable weekly targets for K/D ratio, win rate, or specific mechanics improvement.</p>
                </div>
                <div class="stats-card">
                    <h4>📊 Seasonal Tracking</h4>
                    <p>Compare performance across seasons to measure long-term improvement and adaptation to meta changes.</p>
                </div>
                <div class="stats-card">
                    <h4>🎯 Specific Metrics</h4>
                    <p>Focus on one or two metrics at a time (e.g., building speed, editing accuracy) for targeted improvement.</p>
                </div>
            </div>

            <h3>🏅 Arena & Tournament Play</h3>
            <ul>
                <li><strong>Hype Points:</strong> Track your progression through Arena divisions</li>
                <li><strong>Cash Cups:</strong> Participate in weekly tournaments to test skills</li>
                <li><strong>FNCS:</strong> Fortnite Champion Series for competitive players</li>
                <li><strong>Custom Matches:</strong> Practice in scrims and custom lobbies</li>
                <li><strong>Leaderboards:</strong> Compare stats with top players in your region</li>
            </ul>

            <h3>⚠️ Common Statistical Pitfalls</h3>
            <div class="stats-grid">
                <div class="stats-card">
                    <h4>📊 Sample Size</h4>
                    <p>Don't judge performance on small sample sizes. Look at trends over hundreds of matches.</p>
                </div>
                <div class="stats-card">
                    <h4>🎮 Playstyle Bias</h4>
                    <p>Aggressive players have higher kills but lower survival. Defensive players have better survival but fewer kills.</p>
                </div>
                <div class="stats-card">
                    <h4>🕹️ Mode Variation</h4>
                    <p>Stats vary significantly between Solo, Duos, and Squads modes. Compare within the same mode type.</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🎮 Fortnite Stats Calculator - Performance Tracking & Analysis</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate statistics, track performance metrics, and improve your Fortnite gameplay</p>
        </div>
    </div>

    <script>
        // DOM elements
        const playerNameInput = document.getElementById('playerName');
        const gameModeSelect = document.getElementById('gameMode');
        const platformSelect = document.getElementById('platform');
        const matchesPlayedInput = document.getElementById('matchesPlayed');
        const winsInput = document.getElementById('wins');
        const killsInput = document.getElementById('kills');
        const deathsInput = document.getElementById('deaths');
        const damageInput = document.getElementById('damage');
        const survivalTimeInput = document.getElementById('survivalTime');
        const headshotRateInput = document.getElementById('headshotRate');
        const accuracyInput = document.getElementById('accuracy');
        const buildsPlacedInput = document.getElementById('buildsPlaced');
        const materialsUsedInput = document.getElementById('materialsUsed');
        const calculateButton = document.getElementById('calculateButton');

        // Results elements
        const kdRatioElement = document.getElementById('kdRatio');
        const winRateElement = document.getElementById('winRate');
        const avgKillsElement = document.getElementById('avgKills');
        const avgDamageElement = document.getElementById('avgDamage');
        const survivalScoreElement = document.getElementById('survivalScore');
        const skillRatingElement = document.getElementById('skillRating');
        
        const killsPerMinuteElement = document.getElementById('killsPerMinute');
        const damagePerKillElement = document.getElementById('damagePerKill');
        const top10RateElement = document.getElementById('top10Rate');
        const buildRateElement = document.getElementById('buildRate');
        
        const skillIconElement = document.getElementById('skillIcon');
        const skillTitleElement = document.getElementById('skillTitle');
        const skillDescElement = document.getElementById('skillDesc');
        const skillProgressElement = document.getElementById('skillProgress');
        const improvementTipsElement = document.getElementById('improvementTips');
        
        const vsAvgKDElement = document.getElementById('vsAvgKD');
        const vsAvgWinElement = document.getElementById('vsAvgWin');
        const vsAvgAccuracyElement = document.getElementById('vsAvgAccuracy');
        const vsAvgSurvivalElement = document.getElementById('vsAvgSurvival');
        const vsProKDElement = document.getElementById('vsProKD');
        const vsProWinElement = document.getElementById('vsProWin');
        const vsProBuildElement = document.getElementById('vsProBuild');
        const vsProHeadshotElement = document.getElementById('vsProHeadshot');

        // Event listeners
        calculateButton.addEventListener('click', calculateStats);
        
        // Initial calculation
        calculateStats();

        // Player presets data
        const playerPresets = {
            beginner: {
                matchesPlayed: 50,
                wins: 1,
                kills: 40,
                deaths: 49,
                damage: 6000,
                survivalTime: 5.2,
                headshotRate: 15,
                accuracy: 25,
                buildsPlaced: 800,
                materialsUsed: 2400
            },
            casual: {
                matchesPlayed: 200,
                wins: 12,
                kills: 350,
                deaths: 380,
                damage: 52500,
                survivalTime: 8.7,
                headshotRate: 22,
                accuracy: 38,
                buildsPlaced: 2500,
                materialsUsed: 7500
            },
            advanced: {
                matchesPlayed: 500,
                wins: 75,
                kills: 2500,
                deaths: 2000,
                damage: 375000,
                survivalTime: 12.5,
                headshotRate: 28,
                accuracy: 48,
                buildsPlaced: 12500,
                materialsUsed: 37500
            },
            pro: {
                matchesPlayed: 1000,
                wins: 250,
                kills: 7500,
                deaths: 2500,
                damage: 1125000,
                survivalTime: 15.8,
                headshotRate: 35,
                accuracy: 62,
                buildsPlaced: 30000,
                materialsUsed: 90000
            },
            streamer: {
                matchesPlayed: 2000,
                wins: 600,
                kills: 18000,
                deaths: 6000,
                damage: 2700000,
                survivalTime: 16.5,
                headshotRate: 38,
                accuracy: 65,
                buildsPlaced: 50000,
                materialsUsed: 150000
            },
            tournament: {
                matchesPlayed: 500,
                wins: 100,
                kills: 3000,
                deaths: 1000,
                damage: 450000,
                survivalTime: 14.2,
                headshotRate: 42,
                accuracy: 68,
                buildsPlaced: 20000,
                materialsUsed: 60000
            }
        };

        function calculateStats() {
            // Get input values
            const matchesPlayed = parseInt(matchesPlayedInput.value);
            const wins = parseInt(winsInput.value);
            const kills = parseInt(killsInput.value);
            const deaths = parseInt(deathsInput.value);
            const damage = parseInt(damageInput.value);
            const survivalTime = parseFloat(survivalTimeInput.value);
            const headshotRate = parseFloat(headshotRateInput.value);
            const accuracy = parseFloat(accuracyInput.value);
            const buildsPlaced = parseInt(buildsPlacedInput.value);
            const materialsUsed = parseInt(materialsUsedInput.value);

            // Calculate basic stats
            const kdRatio = deaths > 0 ? (kills / deaths).toFixed(2) : kills.toFixed(2);
            const winRate = ((wins / matchesPlayed) * 100).toFixed(1);
            const avgKills = (kills / matchesPlayed).toFixed(1);
            const avgDamage = (damage / matchesPlayed).toFixed(0);
            const survivalScore = ((survivalTime / 20) * 10).toFixed(1);
            
            // Calculate advanced metrics
            const totalPlaytime = matchesPlayed * survivalTime;
            const killsPerMinute = totalPlaytime > 0 ? (kills / totalPlaytime).toFixed(2) : '0.00';
            const damagePerKill = kills > 0 ? (damage / kills).toFixed(1) : '0.0';
            const top10Rate = calculateTop10Rate(winRate, matchesPlayed);
            const buildRate = totalPlaytime > 0 ? (buildsPlaced / totalPlaytime).toFixed(1) : '0.0';
            
            // Calculate skill rating (0-100)
            const skillRating = calculateSkillRating(kdRatio, winRate, avgKills, accuracy, headshotRate);
            
            // Update overview stats
            updateOverviewStats(kdRatio, winRate, avgKills, avgDamage, survivalScore, skillRating);
            
            // Update performance metrics
            updatePerformanceMetrics(killsPerMinute, damagePerKill, top10Rate, buildRate);
            
            // Update skill assessment
            updateSkillAssessment(skillRating, kdRatio, winRate, accuracy);
            
            // Update comparisons
            updateComparisons(kdRatio, winRate, accuracy, survivalTime, headshotRate, buildRate);
        }

        function calculateTop10Rate(winRate, matchesPlayed) {
            // Estimate top 10 rate based on win rate and matches played
            const baseRate = parseFloat(winRate) * 3.5;
            return Math.min(baseRate, 65).toFixed(0) + '%';
        }

        function calculateSkillRating(kdRatio, winRate, avgKills, accuracy, headshotRate) {
            const kdScore = Math.min(parseFloat(kdRatio) * 15, 30);
            const winScore = Math.min(parseFloat(winRate) * 1.5, 25);
            const killScore = Math.min(parseFloat(avgKills) * 4, 20);
            const accuracyScore = Math.min(parseFloat(accuracy) * 0.5, 15);
            const headshotScore = Math.min(parseFloat(headshotRate) * 0.4, 10);
            
            return Math.round(kdScore + winScore + killScore + accuracyScore + headshotScore);
        }

        function updateOverviewStats(kdRatio, winRate, avgKills, avgDamage, survivalScore, skillRating) {
            kdRatioElement.textContent = kdRatio;
            winRateElement.textContent = winRate + '%';
            avgKillsElement.textContent = avgKills;
            avgDamageElement.textContent = avgDamage;
            survivalScoreElement.textContent = survivalScore;
            skillRatingElement.textContent = skillRating;
        }

        function updatePerformanceMetrics(killsPerMinute, damagePerKill, top10Rate, buildRate) {
            killsPerMinuteElement.textContent = killsPerMinute;
            damagePerKillElement.textContent = damagePerKill;
            top10RateElement.textContent = top10Rate;
            buildRateElement.textContent = buildRate;
        }

        function updateSkillAssessment(skillRating, kdRatio, winRate, accuracy) {
            let icon, title, description, progress, color, tips;
            
            if (skillRating >= 90) {
                icon = '🏆';
                title = 'Elite Player';
                description = 'Exceptional performance across all metrics. Tournament-ready skills and consistency.';
                progress = 95;
                color = '#e74c3c';
                tips = [
                    'Compete in tournaments and cash cups',
                    'Stream or create content to share knowledge',
                    'Mentor other players and build a community',
                    'Stay updated on meta changes and strategies'
                ];
            } else if (skillRating >= 75) {
                icon = '⭐';
                title = 'Expert Player';
                description = 'High-level performance with strong mechanics and game sense. Ready for competitive play.';
                progress = 82;
                color = '#f39c12';
                tips = [
                    'Participate in Arena mode regularly',
                    'Practice advanced building techniques',
                    'Review tournament VODs for strategy',
                    'Focus on end-game scenarios'
                ];
            } else if (skillRating >= 60) {
                icon = '🔥';
                title = 'Advanced Player';
                description = 'Strong performance with consistent results. Good game sense and mechanical skills.';
                progress = 70;
                color = '#2ecc71';
                tips = [
                    'Practice building techniques in Creative',
                    'Focus on positioning and rotation strategies',
                    'Work on editing speed and accuracy',
                    'Analyze your gameplay for mistakes'
                ];
            } else if (skillRating >= 45) {
                icon = '👍';
                title = 'Intermediate Player';
                description = 'Solid foundation with room for improvement. Understanding core mechanics and strategies.';
                progress = 55;
                color = '#3498db';
                tips = [
                    'Practice aim in Creative courses',
                    'Learn basic building techniques',
                    'Study zone rotations and positioning',
                    'Focus on survival and smart engagements'
                ];
            } else if (skillRating >= 30) {
                icon = '😊';
                title = 'Casual Player';
                description = 'Regular player with basic understanding. Working on improving core skills.';
                progress = 40;
                color = '#9b59b6';
                tips = [
                    'Learn weapon stats and effective ranges',
                    'Practice basic building for defense',
                    'Focus on landing shots consistently',
                    'Play regularly to build experience'
                ];
            } else {
                icon = '👶';
                title = 'Beginner';
                description = 'Learning the basics and developing fundamental skills. Focus on core mechanics.';
                progress = 25;
                color = '#95a5a6';
                tips = [
                    'Complete tutorial and practice modes',
                    'Learn the map and popular locations',
                    'Focus on surviving longer in matches',
                    'Practice basic shooting and movement'
                ];
            }
            
            skillIconElement.textContent = icon;
            skillTitleElement.textContent = title;
            skillDescElement.textContent = description;
            skillProgressElement.style.width = progress + '%';
            skillProgressElement.style.background = color;
            
            // Update improvement tips
            improvementTipsElement.innerHTML = '';
            tips.forEach(tip => {
                const tipElement = document.createElement('div');
                tipElement.className = 'tip-item';
                tipElement.innerHTML = `
                    <span class="tip-bullet">•</span>
                    <span>${tip}</span>
                `;
                improvementTipsElement.appendChild(tipElement);
            });
        }

        function updateComparisons(kdRatio, winRate, accuracy, survivalTime, headshotRate, buildRate) {
            // Average player benchmarks
            const avgKD = 0.8;
            const avgWinRate = 5;
            const avgAccuracy = 35;
            const avgSurvival = 8.5;
            const avgHeadshot = 20;
            const avgBuildRate = 4.0;
            
            // Pro player benchmarks
            const proKD = 4.0;
            const proWinRate = 25;
            const proAccuracy = 60;
            const proSurvival = 14.0;
            const proHeadshot = 35;
            const proBuildRate = 12.0;
            
            // Calculate comparisons
            vsAvgKDElement.textContent = formatComparison(parseFloat(kdRatio) / avgKD);
            vsAvgWinElement.textContent = formatComparison(parseFloat(winRate) / avgWinRate);
            vsAvgAccuracyElement.textContent = formatComparison(parseFloat(accuracy) / avgAccuracy);
            vsAvgSurvivalElement.textContent = formatComparison(parseFloat(survivalTime) / avgSurvival);
            
            vsProKDElement.textContent = formatComparison(parseFloat(kdRatio) / proKD);
            vsProWinElement.textContent = formatComparison(parseFloat(winRate) / proWinRate);
            vsProBuildElement.textContent = formatComparison(parseFloat(buildRate) / proBuildRate);
            vsProHeadshotElement.textContent = formatComparison(parseFloat(headshotRate) / proHeadshot);
        }

        function formatComparison(ratio) {
            const percentage = ((ratio - 1) * 100).toFixed(0);
            if (percentage > 0) {
                return '+' + percentage + '%';
            } else {
                return percentage + '%';
            }
        }

        function applyPreset(preset) {
            const data = playerPresets[preset];
            
            matchesPlayedInput.value = data.matchesPlayed;
            winsInput.value = data.wins;
            killsInput.value = data.kills;
            deathsInput.value = data.deaths;
            damageInput.value = data.damage;
            survivalTimeInput.value = data.survivalTime;
            headshotRateInput.value = data.headshotRate;
            accuracyInput.value = data.accuracy;
            buildsPlacedInput.value = data.buildsPlaced;
            materialsUsedInput.value = data.materialsUsed;
            
            calculateStats();
        }

        // Make functions available globally
        window.applyPreset = applyPreset;
    </script>
</body>
</html>
