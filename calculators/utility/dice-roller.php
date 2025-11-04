<?php
/**
 * Dice Roller
 * File: utility/dice-roller.php
 * Description: Advanced dice roller with multiple dice types, statistics, and customization options
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dice Roller - Advanced Dice Rolling Simulator</title>
    <meta name="description" content="Roll virtual dice with multiple types, custom combinations, statistics, and advanced options for games and probability testing.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .roller-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; background: white; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #ff6b6b; box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1); }
        
        .dice-combination { display: grid; grid-template-columns: auto 1fr auto; gap: 10px; align-items: center; margin-bottom: 15px; }
        .dice-count { width: 80px; text-align: center; }
        .dice-type { flex: 1; }
        .remove-dice { background: #ff6b6b; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .checkbox-group input { width: auto; }
        
        .action-buttons { display: flex; gap: 15px; margin-top: 25px; flex-wrap: wrap; }
        .btn { padding: 14px 24px; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; font-weight: 600; }
        .btn-primary { background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3); }
        .btn-secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .btn-secondary:hover { background: #e9ecef; }
        .btn-danger { background: #e74c3c; color: white; }
        
        .quick-dice { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-dice h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #ff6b6b; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255, 107, 107, 0.15); }
        .quick-value { font-weight: bold; color: #ff6b6b; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .results-section { margin-top: 30px; }
        .dice-results { display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 15px; margin-top: 20px; }
        .dice-face { 
            width: 70px; 
            height: 70px; 
            background: white; 
            border: 2px solid #ff6b6b; 
            border-radius: 12px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 1.5rem; 
            font-weight: bold; 
            color: #2c3e50;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        .dice-face.rolling {
            animation: rollDice 0.5s ease-in-out;
        }
        @keyframes rollDice {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.1); }
            100% { transform: rotate(360deg) scale(1); }
        }
        
        .result-summary { 
            background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%); 
            padding: 20px; 
            border-radius: 10px; 
            margin-top: 20px; 
            text-align: center;
        }
        .total-value { 
            font-size: 2.5rem; 
            font-weight: bold; 
            color: #2c3e50; 
            margin-bottom: 10px;
        }
        .result-details { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
            gap: 15px; 
            margin-top: 15px;
        }
        .detail-card { 
            background: rgba(255,255,255,0.8); 
            padding: 15px; 
            border-radius: 8px; 
        }
        .detail-label { 
            font-size: 0.85rem; 
            color: #7f8c8d; 
            margin-bottom: 5px; 
        }
        .detail-value { 
            font-size: 1.2rem; 
            font-weight: bold; 
            color: #2c3e50; 
        }
        
        .history-section { margin-top: 30px; }
        .history-list { 
            max-height: 200px; 
            overflow-y: auto; 
            border: 1px solid #e0e0e0; 
            border-radius: 8px; 
            padding: 15px;
            background: #f8f9fa;
        }
        .history-item { 
            padding: 10px; 
            border-bottom: 1px solid #e0e0e0; 
            display: flex; 
            justify-content: space-between;
        }
        .history-item:last-child { border-bottom: none; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .dice-types { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 20px 0; }
        .dice-card { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #ff6b6b; }
        .dice-name { font-weight: bold; color: #2c3e50; margin-bottom: 5px; display: flex; align-items: center; gap: 8px; }
        .dice-desc { font-size: 0.85rem; color: #7f8c8d; }
        
        .probability-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; margin: 15px 0; }
        .probability-item { background: #f8f9fa; padding: 10px; border-radius: 6px; text-align: center; }
        .prob-value { font-weight: bold; color: #ff6b6b; }
        .prob-label { font-size: 0.8rem; color: #7f8c8d; }
        
        .formula-box { background: #fff9f9; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff6b6b; }
        .formula-box strong { color: #ff6b6b; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #fff9f9; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .action-buttons { flex-direction: column; }
            .dice-results { grid-template-columns: repeat(auto-fill, minmax(60px, 1fr)); }
            .dice-face { width: 55px; height: 55px; font-size: 1.2rem; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎲 Advanced Dice Roller</h1>
            <p>Roll virtual dice with multiple types, custom combinations, statistics, and advanced options for games and probability testing</p>
        </div>

        <div class="roller-card">
            <div class="control-panel">
                <div class="control-group">
                    <label for="diceType">Dice Type</label>
                    <select id="diceType" class="control-select">
                        <option value="d4">d4 (4-sided)</option>
                        <option value="d6" selected>d6 (6-sided)</option>
                        <option value="d8">d8 (8-sided)</option>
                        <option value="d10">d10 (10-sided)</option>
                        <option value="d12">d12 (12-sided)</option>
                        <option value="d20">d20 (20-sided)</option>
                        <option value="d100">d100 (100-sided)</option>
                        <option value="custom">Custom Dice</option>
                    </select>
                    <div id="customDiceSection" style="display: none; margin-top: 10px;">
                        <input type="number" id="customSides" placeholder="Number of sides" min="2" max="1000">
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="diceCount">Number of Dice</label>
                    <input type="number" id="diceCount" min="1" max="100" value="2">
                </div>
                
                <div class="control-group">
                    <label for="rollCount">Rolls per Click</label>
                    <input type="number" id="rollCount" min="1" max="10" value="1">
                </div>
            </div>
            
            <div class="control-panel">
                <div class="control-group">
                    <label>Modifiers</label>
                    <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 10px; align-items: center;">
                        <select id="modifierType">
                            <option value="none">No Modifier</option>
                            <option value="add">Add (+)</option>
                            <option value="subtract">Subtract (-)</option>
                            <option value="multiply">Multiply (×)</option>
                        </select>
                        <input type="number" id="modifierValue" min="0" max="1000" value="0" style="text-align: center;">
                    </div>
                </div>
                
                <div class="control-group">
                    <label>Advanced Options</label>
                    <div class="checkbox-group">
                        <input type="checkbox" id="showHistory" checked>
                        <label for="showHistory">Keep roll history</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="animateRolls" checked>
                        <label for="animateRolls">Animate dice rolls</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="sumResults">
                        <label for="sumResults">Show sum of rolls</label>
                    </div>
                </div>
            </div>
            
            <div class="quick-dice">
                <h3>⚡ Quick Dice</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="quickRoll('d6', 1)">
                        <div class="quick-value">1d6</div>
                        <div class="quick-label">Standard</div>
                    </div>
                    <div class="quick-btn" onclick="quickRoll('d20', 1)">
                        <div class="quick-value">1d20</div>
                        <div class="quick-label">D&D Attack</div>
                    </div>
                    <div class="quick-btn" onclick="quickRoll('d6', 2)">
                        <div class="quick-value">2d6</div>
                        <div class="quick-label">Board Games</div>
                    </div>
                    <div class="quick-btn" onclick="quickRoll('d100', 1)">
                        <div class="quick-value">1d100</div>
                        <div class="quick-label">Percentage</div>
                    </div>
                    <div class="quick-btn" onclick="quickRoll('d4', 3)">
                        <div class="quick-value">3d4</div>
                        <div class="quick-label">Small Weapon</div>
                    </div>
                    <div class="quick-btn" onclick="quickRoll('d8', 2)">
                        <div class="quick-value">2d8</div>
                        <div class="quick-label">Medium Weapon</div>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="rollDice()">🎲 Roll Dice</button>
                <button class="btn btn-secondary" onclick="clearResults()">🗑️ Clear Results</button>
                <button class="btn btn-secondary" onclick="saveResults()">💾 Save Rolls</button>
                <button class="btn btn-danger" onclick="clearHistory()">📊 Clear History</button>
            </div>
            
            <div class="results-section">
                <h3>🎯 Roll Results</h3>
                <div class="dice-results" id="diceResults">
                    <!-- Dice faces will appear here -->
                </div>
                
                <div class="result-summary" id="resultSummary" style="display: none;">
                    <div class="total-value" id="totalValue">0</div>
                    <div class="result-details">
                        <div class="detail-card">
                            <div class="detail-label">Total Rolls</div>
                            <div class="detail-value" id="totalRolls">0</div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-label">Average</div>
                            <div class="detail-value" id="averageValue">0</div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-label">Highest</div>
                            <div class="detail-value" id="highestValue">0</div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-label">Lowest</div>
                            <div class="detail-value" id="lowestValue">0</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="history-section" id="historySection">
                <h3>📜 Roll History</h3>
                <div class="history-list" id="historyList">
                    <!-- History items will appear here -->
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🎲 Advanced Dice Rolling</h2>
            
            <p>Experience realistic dice rolling with multiple dice types, custom combinations, statistical analysis, and professional gaming features for tabletop games, RPGs, and probability testing.</p>

            <h3>🎯 Dice Types & Characteristics</h3>
            <div class="dice-types">
                <div class="dice-card">
                    <div class="dice-name">🎲 d4 (Tetrahedron)</div>
                    <div class="dice-desc">4-sided pyramid dice, common in RPGs for small weapons</div>
                </div>
                <div class="dice-card">
                    <div class="dice-name">🎲 d6 (Cube)</div>
                    <div class="dice-desc">Standard 6-sided dice, most common in board games</div>
                </div>
                <div class="dice-card">
                    <div class="dice-name">🎲 d8 (Octahedron)</div>
                    <div class="dice-desc">8-sided dice, used for medium weapons in RPGs</div>
                </div>
                <div class="dice-card">
                    <div class="dice-name">🎲 d10 (Pentagonal Trapezohedron)</div>
                    <div class="dice-desc">10-sided dice, often used for percentages (0-9)</div>
                </div>
                <div class="dice-card">
                    <div class="dice-name">🎲 d12 (Dodecahedron)</div>
                    <div class="dice-desc">12-sided dice, used for large weapons in RPGs</div>
                </div>
                <div class="dice-card">
                    <div class="dice-name">🎲 d20 (Icosahedron)</div>
                    <div class="dice-desc">20-sided dice, standard for D&D attack rolls</div>
                </div>
                <div class="dice-card">
                    <div class="dice-name">🎲 d100 (Percentile)</div>
                    <div class="dice-desc">100-sided dice or two d10s for 0-99 range</div>
                </div>
                <div class="dice-card">
                    <div class="dice-name">🎲 Custom Dice</div>
                    <div class="dice-desc">Create dice with any number of sides (2-1000)</div>
                </div>
            </div>

            <h3>📊 Probability Mathematics</h3>
            <div class="formula-box">
                <strong>Probability Calculations:</strong><br>
                • <strong>Single Die:</strong> P(specific number) = 1/n (where n = number of sides)<br>
                • <strong>Multiple Dice:</strong> Probability distributions follow binomial patterns<br>
                • <strong>Expected Value:</strong> E = (n + 1) / 2 for a fair n-sided die<br>
                • <strong>Variance:</strong> Var = (n² - 1) / 12 for a fair n-sided die<br>
                • <strong>Standard Deviation:</strong> σ = √Var
            </div>

            <h3>🎮 Common Gaming Notations</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Notation</th>
                        <th>Meaning</th>
                        <th>Example</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1d6</td><td>Roll one 6-sided die</td><td>1-6</td></tr>
                    <tr><td>2d6</td><td>Roll two 6-sided dice and sum</td><td>2-12</td></tr>
                    <tr><td>3d6+2</td><td>Roll three d6, sum, then add 2</td><td>5-20</td></tr>
                    <tr><td>1d20</td><td>Roll one 20-sided die</td><td>1-20</td></tr>
                    <tr><td>2d10</td><td>Roll two 10-sided dice for 0-99</td><td>0-99</td></tr>
                    <tr><td>4d6dl1</td><td>Roll 4d6, drop lowest 1</td><td>3-18</td></tr>
                </tbody>
            </table>

            <h3>📈 Statistical Properties</h3>
            <div class="probability-grid">
                <div class="probability-item">
                    <div class="prob-value">2.5%</div>
                    <div class="prob-label">Roll 20 on d20</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">16.67%</div>
                    <div class="prob-label">Roll 6 on d6</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">8.33%</div>
                    <div class="prob-label">Roll 1 on d12</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">2.78%</div>
                    <div class="prob-label">Double 6 on 2d6</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">0.10%</div>
                    <div class="prob-label">Roll 100 on d100</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">50%</div>
                    <div class="prob-label">Roll 11+ on d20</div>
                </div>
            </div>

            <h3>🎲 Dice in Different Games</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Game System</th>
                        <th>Primary Dice</th>
                        <th>Typical Rolls</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Dungeons & Dragons</td><td>d20, d6, d8, d10</td><td>1d20+modifiers for attacks</td></tr>
                    <tr><td>Pathfinder</td><td>d20, various</td><td>Similar to D&D with d20 system</td></tr>
                    <tr><td>Warhammer</td><td>d6</td><td>Multiple d6 for combat</td></tr>
                    <tr><td>Monopoly</td><td>2d6</td><td>2d6 for movement</td></tr>
                    <tr><td>Yahtzee</td><td>5d6</td><td>5d6 with rerolls</td></tr>
                    <tr><td>Craps</td><td>2d6</td><td>2d6 for most bets</td></tr>
                </tbody>
            </table>

            <h3>⚡ Modifiers & Combinations</h3>
            <div class="formula-box">
                <strong>Common Modifier Types:</strong><br>
                • <strong>Addition/Subtraction:</strong> Add or subtract fixed values<br>
                • <strong>Multiplication:</strong> Multiply results by a factor<br>
                • <strong>Advantage/Disadvantage:</strong> Roll twice, take higher/lower<br>
                • <strong>Drop Highest/Lowest:</strong> Remove extremes from multiple dice<br>
                • <strong>Exploding Dice:</strong> Reroll when hitting maximum value<br>
                • <strong>Target Numbers:</strong> Count successes above threshold
            </div>

            <h3>📊 Statistical Analysis</h3>
            <ul>
                <li><strong>Mean/Average:</strong> Sum of all rolls divided by count</li>
                <li><strong>Median:</strong> Middle value when sorted</li>
                <li><strong>Mode:</strong> Most frequently occurring value</li>
                <li><strong>Range:</strong> Difference between highest and lowest</li>
                <li><strong>Standard Deviation:</strong> Measure of result dispersion</li>
                <li><strong>Probability Distribution:</strong> Frequency of each possible outcome</li>
            </ul>

            <h3>🎯 Special Rolling Techniques</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Technique</th>
                        <th>Description</th>
                        <th>Use Case</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Advantage</td><td>Roll twice, take higher result</td><td>D&D 5e favorable conditions</td></tr>
                    <tr><td>Disadvantage</td><td>Roll twice, take lower result</td><td>D&D 5e unfavorable conditions</td></tr>
                    <tr><td>Exploding Dice</td><td>Reroll when max value rolled</td><td>Some RPG systems</td></tr>
                    <tr><td>Pool System</td><td>Count successes above target</td><td>World of Darkness games</td></tr>
                    <tr><td>Step System</td><td>Increase die size for skill</td><td>Savage Worlds</td></tr>
                </tbody>
            </table>

            <h3>🔢 Expected Values</h3>
            <div class="probability-grid">
                <div class="probability-item">
                    <div class="prob-value">3.5</div>
                    <div class="prob-label">1d6 Average</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">7</div>
                    <div class="prob-label">2d6 Average</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">10.5</div>
                    <div class="prob-label">3d6 Average</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">10.5</div>
                    <div class="prob-label">1d20 Average</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">50.5</div>
                    <div class="prob-label">1d100 Average</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">12.25</div>
                    <div class="prob-label">4d6 drop lowest</div>
                </div>
            </div>

            <h3>🎲 Historical Context</h3>
            <p>Dice have been used for gaming and divination for over 5,000 years. The oldest known dice were found in archaeological sites in Iran and Egypt dating back to 2800-2500 BCE. Modern polyhedral dice used in RPGs were popularized by Dungeons & Dragons in the 1970s.</p>

            <h3>📱 Digital vs Physical Dice</h3>
            <div class="formula-box">
                <strong>Digital Dice Advantages:</strong><br>
                • <strong>True Randomness:</strong> Better randomization algorithms<br>
                • <strong>Speed:</strong> Instant results without physical rolling<br>
                • <strong>Statistics:</strong> Automatic tracking and analysis<br>
                • <strong>Accessibility:</strong> Available anywhere, no physical dice needed<br>
                • <strong>Complex Rolls:</strong> Handle complicated combinations easily<br>
                • <strong>History:</strong> Maintain complete roll history
            </div>
        </div>

        <div class="footer">
            <p>🎲 Advanced Dice Roller | Multiple Dice Types & Statistics</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for tabletop RPGs, board games, probability testing, and educational purposes</p>
        </div>
    </div>

    <script>
        let rollHistory = [];
        
        // Show/hide custom dice section
        document.getElementById('diceType').addEventListener('change', function() {
            const customSection = document.getElementById('customDiceSection');
            customSection.style.display = this.value === 'custom' ? 'block' : 'none';
        });

        function rollDice() {
            const diceType = document.getElementById('diceType').value;
            const diceCount = parseInt(document.getElementById('diceCount').value);
            const rollCount = parseInt(document.getElementById('rollCount').value);
            const modifierType = document.getElementById('modifierType').value;
            const modifierValue = parseInt(document.getElementById('modifierValue').value);
            const animate = document.getElementById('animateRolls').checked;
            const showSum = document.getElementById('sumResults').checked;
            
            let sides;
            if (diceType === 'custom') {
                sides = parseInt(document.getElementById('customSides').value) || 6;
            } else {
                sides = parseInt(diceType.substring(1)); // Extract number from "d6", "d20", etc.
            }
            
            const resultsContainer = document.getElementById('diceResults');
            resultsContainer.innerHTML = '';
            
            let allRolls = [];
            let totalSum = 0;
            
            // Perform multiple rolls
            for (let r = 0; r < rollCount; r++) {
                const rolls = [];
                let rollSum = 0;
                
                // Roll all dice
                for (let i = 0; i < diceCount; i++) {
                    const roll = Math.floor(Math.random() * sides) + 1;
                    rolls.push(roll);
                    rollSum += roll;
                    allRolls.push(roll);
                }
                
                // Apply modifier
                let modifiedSum = rollSum;
                switch (modifierType) {
                    case 'add':
                        modifiedSum += modifierValue;
                        break;
                    case 'subtract':
                        modifiedSum -= modifierValue;
                        break;
                    case 'multiply':
                        modifiedSum *= modifierValue;
                        break;
                }
                
                totalSum += modifiedSum;
                
                // Display dice faces
                rolls.forEach((roll, index) => {
                    const diceFace = document.createElement('div');
                    diceFace.className = 'dice-face';
                    diceFace.textContent = roll;
                    
                    if (animate) {
                        diceFace.classList.add('rolling');
                        setTimeout(() => {
                            diceFace.classList.remove('rolling');
                        }, 500);
                    }
                    
                    resultsContainer.appendChild(diceFace);
                });
                
                // Add to history
                if (document.getElementById('showHistory').checked) {
                    const timestamp = new Date().toLocaleTimeString();
                    const rollDescription = `${diceCount}${diceType === 'custom' ? 'd' + sides : diceType} = [${rolls.join(', ')}]`;
                    const modifierText = modifierType !== 'none' ? ` ${getModifierSymbol(modifierType)} ${modifierValue} = ${modifiedSum}` : '';
                    
                    rollHistory.unshift({
                        timestamp,
                        description: rollDescription + modifierText,
                        total: modifiedSum,
                        rolls: rolls
                    });
                    
                    updateHistory();
                }
            }
            
            // Show summary if requested
            if (showSum || rollCount > 1) {
                const summary = document.getElementById('resultSummary');
                const totalRolls = allRolls.length;
                const average = totalSum / rollCount;
                const highest = Math.max(...allRolls);
                const lowest = Math.min(...allRolls);
                
                document.getElementById('totalValue').textContent = totalSum;
                document.getElementById('totalRolls').textContent = totalRolls;
                document.getElementById('averageValue').textContent = average.toFixed(2);
                document.getElementById('highestValue').textContent = highest;
                document.getElementById('lowestValue').textContent = lowest;
                
                summary.style.display = 'block';
            } else {
                document.getElementById('resultSummary').style.display = 'none';
            }
        }
        
        function getModifierSymbol(type) {
            switch (type) {
                case 'add': return '+';
                case 'subtract': return '-';
                case 'multiply': return '×';
                default: return '';
            }
        }
        
        function updateHistory() {
            const historyList = document.getElementById('historyList');
            historyList.innerHTML = '';
            
            // Keep only last 20 rolls
            if (rollHistory.length > 20) {
                rollHistory = rollHistory.slice(0, 20);
            }
            
            rollHistory.forEach(roll => {
                const historyItem = document.createElement('div');
                historyItem.className = 'history-item';
                historyItem.innerHTML = `
                    <span>${roll.timestamp}</span>
                    <span><strong>${roll.description}</strong></span>
                    <span>Total: ${roll.total}</span>
                `;
                historyList.appendChild(historyItem);
            });
            
            // Show/hide history section
            document.getElementById('historySection').style.display = 
                rollHistory.length > 0 ? 'block' : 'none';
        }
        
        function quickRoll(diceType, count) {
            document.getElementById('diceType').value = diceType;
            document.getElementById('diceCount').value = count;
            rollDice();
        }
        
        function clearResults() {
            document.getElementById('diceResults').innerHTML = '';
            document.getElementById('resultSummary').style.display = 'none';
        }
        
        function clearHistory() {
            rollHistory = [];
            updateHistory();
            document.getElementById('historySection').style.display = 'none';
        }
        
        function saveResults() {
            let results = 'Dice Roll Results\n';
            results += 'Generated: ' + new Date().toLocaleString() + '\n\n';
            
            rollHistory.forEach(roll => {
                results += `${roll.timestamp}: ${roll.description}\n`;
            });
            
            const blob = new Blob([results], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'dice-rolls.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        // Initialize
        updateHistory();
    </script>
</body>
</html>
