<?php
/**
 * Game Odds Calculator
 * File: gaming/game-odds-calculator.php
 * Description: Calculate probabilities and odds for various game scenarios including dice, cards, loot boxes, and more
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Odds Calculator - Probability Analysis for Gaming</title>
    <meta name="description" content="Calculate probabilities and odds for dice rolls, card draws, loot boxes, gacha systems, and other game mechanics.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .game-type-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .game-type-card { background: #f8f9fa; padding: 20px; border-radius: 10px; cursor: pointer; transition: all 0.3s; border: 2px solid transparent; text-align: center; }
        .game-type-card:hover { transform: translateY(-2px); }
        .game-type-card.active { background: #ede7f6; border-color: #667eea; }
        .game-type-icon { font-size: 2rem; margin-bottom: 10px; }
        .game-type-name { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .game-type-desc { font-size: 0.8rem; color: #7f8c8d; }
        
        .controls-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .probability-section { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .probability-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        
        .results-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .result-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; text-align: center; }
        .result-card.highlight { background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); border-left-color: #4caf50; }
        .result-card.warning { background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); border-left-color: #ff9800; }
        .result-card.danger { background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); border-left-color: #f44336; }
        .result-value { font-size: 1.5rem; font-weight: bold; color: #5e35b1; margin-bottom: 5px; }
        .result-card.highlight .result-value { color: #2e7d32; }
        .result-card.warning .result-value { color: #ef6c00; }
        .result-card.danger .result-value { color: #c62828; }
        .result-label { font-size: 0.85rem; color: #4527a0; font-weight: 600; }
        .result-card.highlight .result-label { color: #1b5e20; }
        .result-card.warning .result-label { color: #e65100; }
        .result-card.danger .result-label { color: #b71c1c; }
        .result-note { font-size: 0.75rem; color: #7f8c8d; margin-top: 5px; }
        
        .probability-visual { background: white; padding: 25px; border-radius: 12px; margin-bottom: 25px; border: 2px solid #e0e0e0; }
        .probability-visual h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .probability-bar { height: 30px; background: #f0f0f0; border-radius: 15px; margin: 15px 0; overflow: hidden; position: relative; }
        .probability-fill { height: 100%; background: linear-gradient(90deg, #4caf50, #2196f3); border-radius: 15px; transition: width 0.5s ease; }
        .probability-labels { display: flex; justify-content: space-between; font-size: 0.8rem; color: #7f8c8d; }
        .probability-markers { position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: flex; justify-content: space-between; padding: 0 10px; }
        .probability-marker { width: 2px; height: 100%; background: rgba(0,0,0,0.1); }
        
        .odds-comparison { background: #e3f2fd; padding: 25px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #2196f3; }
        .odds-comparison h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .comparison-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .comparison-item { background: white; padding: 15px; border-radius: 8px; text-align: center; }
        .comparison-value { font-size: 1.2rem; font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .comparison-label { font-size: 0.8rem; color: #7f8c8d; }
        
        .distribution-chart { background: #fff3e0; padding: 25px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #ff9800; }
        .distribution-chart h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .chart-container { height: 200px; display: flex; align-items: end; gap: 5px; padding: 20px 0; }
        .chart-bar { flex: 1; background: linear-gradient(to top, #667eea, #764ba2); border-radius: 5px 5px 0 0; position: relative; transition: height 0.5s ease; }
        .chart-label { position: absolute; bottom: -25px; left: 0; right: 0; text-align: center; font-size: 0.7rem; color: #7f8c8d; }
        
        .action-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .action-btn { padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3); }
        .action-btn.secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .action-btn.secondary:hover { border-color: #667eea; }
        
        .scenario-builder { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .scenario-builder h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .scenario-controls { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 15px; }
        .scenario-item { background: white; padding: 15px; border-radius: 8px; border: 1px solid #e0e0e0; }
        
        .tips-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .tip-card { background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #2196f3; }
        .tip-icon { font-size: 1.5rem; margin-bottom: 10px; }
        .tip-title { font-weight: 600; color: #2c3e50; margin-bottom: 8px; }
        .tip-desc { font-size: 0.85rem; color: #555; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .probability-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .probability-table th, .probability-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .probability-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .probability-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .controls-row { grid-template-columns: 1fr; }
            .game-type-grid { grid-template-columns: repeat(2, 1fr); }
            .results-grid { grid-template-columns: repeat(2, 1fr); }
            .comparison-grid { grid-template-columns: repeat(2, 1fr); }
            .chart-container { height: 150px; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { grid-template-columns: 1fr; }
            .scenario-controls { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 480px) {
            .game-type-grid { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .comparison-grid { grid-template-columns: 1fr; }
            .calculator-card { padding: 20px; }
            .header { padding: 20px; }
            .tips-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎲 Game Odds Calculator</h1>
            <p>Calculate probabilities and odds for dice rolls, card draws, loot boxes, gacha systems, and other game mechanics</p>
        </div>

        <div class="calculator-card">
            <div class="game-type-grid">
                <div class="game-type-card active" data-type="dice">
                    <div class="game-type-icon">🎲</div>
                    <div class="game-type-name">Dice Rolls</div>
                    <div class="game-type-desc">Single or multiple dice probabilities</div>
                </div>
                <div class="game-type-card" data-type="cards">
                    <div class="game-type-icon">🃏</div>
                    <div class="game-type-name">Card Draws</div>
                    <div class="game-type-desc">Deck probabilities and combinations</div>
                </div>
                <div class="game-type-card" data-type="lootbox">
                    <div class="game-type-icon">📦</div>
                    <div class="game-type-name">Loot Boxes</div>
                    <div class="game-type-desc">Gacha and loot box probabilities</div>
                </div>
                <div class="game-type-card" data-type="rng">
                    <div class="game-type-icon">🎯</div>
                    <div class="game-type-name">RNG Systems</div>
                    <div class="game-type-desc">Random number generation</div>
                </div>
                <div class="game-type-card" data-type="battle">
                    <div class="game-type-icon">⚔️</div>
                    <div class="game-type-name">Battle Odds</div>
                    <div class="game-type-desc">Combat and success probabilities</div>
                </div>
                <div class="game-type-card" data-type="custom">
                    <div class="game-type-icon">🔧</div>
                    <div class="game-type-name">Custom Scenario</div>
                    <div class="game-type-desc">Build your own probability scenario</div>
                </div>
            </div>
            
            <div class="probability-section" id="diceControls">
                <h3>🎲 Dice Roll Probability</h3>
                <div class="controls-row">
                    <div class="control-group">
                        <label for="diceType">Dice Type</label>
                        <select id="diceType">
                            <option value="d4">d4 (4-sided)</option>
                            <option value="d6" selected>d6 (6-sided)</option>
                            <option value="d8">d8 (8-sided)</option>
                            <option value="d10">d10 (10-sided)</option>
                            <option value="d12">d12 (12-sided)</option>
                            <option value="d20">d20 (20-sided)</option>
                            <option value="d100">d100 (100-sided)</option>
                            <option value="custom">Custom Sides</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="diceCount">Number of Dice</label>
                        <input type="number" id="diceCount" value="1" min="1" max="10" step="1">
                    </div>
                    
                    <div class="control-group">
                        <label for="targetValue">Target Value</label>
                        <input type="number" id="targetValue" value="4" min="1" max="100" step="1">
                    </div>
                </div>
                
                <div class="controls-row">
                    <div class="control-group">
                        <label for="comparisonType">Comparison Type</label>
                        <select id="comparisonType">
                            <option value="equal">Exactly equal to target</option>
                            <option value="greater" selected>Greater than or equal to target</option>
                            <option value="less">Less than or equal to target</option>
                            <option value="between">Between two values</option>
                        </select>
                    </div>
                    
                    <div class="control-group" id="secondValueGroup" style="display: none;">
                        <label for="secondValue">Second Target Value</label>
                        <input type="number" id="secondValue" value="6" min="1" max="100" step="1">
                    </div>
                </div>
            </div>
            
            <div class="probability-section" id="cardControls" style="display: none;">
                <h3>🃏 Card Draw Probability</h3>
                <div class="controls-row">
                    <div class="control-group">
                        <label for="deckType">Deck Type</label>
                        <select id="deckType">
                            <option value="standard" selected>Standard 52-card</option>
                            <option value="poker">Poker (no jokers)</option>
                            <option value="hearts">Hearts (no clubs/diamonds)</option>
                            <option value="spades">Spades only</option>
                            <option value="custom">Custom Deck</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="handSize">Hand Size</label>
                        <input type="number" id="handSize" value="5" min="1" max="52" step="1">
                    </div>
                    
                    <div class="control-group">
                        <label for="targetCards">Target Cards</label>
                        <input type="number" id="targetCards" value="1" min="1" max="52" step="1">
                    </div>
                </div>
                
                <div class="controls-row">
                    <div class="control-group">
                        <label for="cardCondition">Card Condition</label>
                        <select id="cardCondition">
                            <option value="specific">Specific card(s)</option>
                            <option value="suit" selected>Specific suit</option>
                            <option value="rank">Specific rank</option>
                            <option value="face">Face cards</option>
                            <option value="number">Number cards</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="suitType">Suit Type</label>
                        <select id="suitType">
                            <option value="hearts">Hearts ♥</option>
                            <option value="diamonds">Diamonds ♦</option>
                            <option value="clubs">Clubs ♣</option>
                            <option value="spades">Spades ♠</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="results-grid">
                <div class="result-card highlight">
                    <div class="result-value" id="probability">16.67%</div>
                    <div class="result-label">PROBABILITY</div>
                    <div class="result-note">Chance of success</div>
                </div>
                <div class="result-card">
                    <div class="result-value" id="oddsFraction">1 in 6</div>
                    <div class="result-label">ODDS</div>
                    <div class="result-note">Fractional odds</div>
                </div>
                <div class="result-card">
                    <div class="result-value" id="oddsDecimal">6.00</div>
                    <div class="result-label">DECIMAL ODDS</div>
                    <div class="result-note">European format</div>
                </div>
                <div class="result-card">
                    <div class="result-value" id="expectedValue">0.17</div>
                    <div class="result-label">EXPECTED VALUE</div>
                    <div class="result-note">Average successes per try</div>
                </div>
            </div>
            
            <div class="probability-visual">
                <h3>📊 Probability Visualization</h3>
                <div class="probability-bar">
                    <div class="probability-fill" id="probabilityFill" style="width: 16.67%;"></div>
                    <div class="probability-markers">
                        <div class="probability-marker" style="left: 0%;"></div>
                        <div class="probability-marker" style="left: 25%;"></div>
                        <div class="probability-marker" style="left: 50%;"></div>
                        <div class="probability-marker" style="left: 75%;"></div>
                        <div class="probability-marker" style="left: 100%;"></div>
                    </div>
                </div>
                <div class="probability-labels">
                    <span>0%</span>
                    <span>25%</span>
                    <span>50%</span>
                    <span>75%</span>
                    <span>100%</span>
                </div>
            </div>
            
            <div class="odds-comparison">
                <h3>📈 Odds Comparison</h3>
                <div class="comparison-grid">
                    <div class="comparison-item">
                        <div class="comparison-value" id="comparisonCoin">Coin Flip</div>
                        <div class="comparison-label">50% probability</div>
                    </div>
                    <div class="comparison-item">
                        <div class="comparison-value" id="comparisonRoulette">Roulette</div>
                        <div class="comparison-label">2.7% (single number)</div>
                    </div>
                    <div class="comparison-item">
                        <div class="comparison-value" id="comparisonLottery">Lottery</div>
                        <div class="comparison-label">0.000007% (Powerball)</div>
                    </div>
                    <div class="comparison-item">
                        <div class="comparison-value" id="comparisonLightning">Lightning</div>
                        <div class="comparison-label">0.00014% (annual risk)</div>
                    </div>
                </div>
            </div>
            
            <div class="distribution-chart">
                <h3>📈 Outcome Distribution</h3>
                <div class="chart-container" id="distributionChart">
                    <!-- Chart bars will be generated here -->
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="action-btn" id="calculateBtn">
                    <span>🧮</span> Calculate Odds
                </button>
                <button class="action-btn secondary" id="resetBtn">
                    <span>🔄</span> Reset
                </button>
                <button class="action-btn secondary" id="simulateBtn">
                    <span>🎯</span> Run Simulation
                </button>
            </div>
            
            <div class="tips-grid" id="probabilityTips">
                <!-- Probability tips will be generated here -->
            </div>
        </div>

        <div class="info-section">
            <h2>🎲 Game Probability Science</h2>
            
            <p>Understanding probability and odds is essential for game design, strategy optimization, and making informed decisions in games of chance.</p>

            <h3>📊 Basic Probability Formulas</h3>
            <table class="probability-table">
                <thead>
                    <tr>
                        <th>Scenario</th>
                        <th>Formula</th>
                        <th>Example</th>
                        <th>Application</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Single Event</td><td>P(A) = Successful / Total</td><td>Rolling 6 on d6: 1/6</td><td>Basic dice rolls</td></tr>
                    <tr><td>Multiple Events (AND)</td><td>P(A and B) = P(A) × P(B)</td><td>Two 6s: (1/6) × (1/6)</td><td>Independent events</td></tr>
                    <tr><td>Either Event (OR)</td><td>P(A or B) = P(A) + P(B)</td><td>6 or 1: 1/6 + 1/6</td><td>Mutually exclusive</td></tr>
                    <tr><td>Combinations</td><td>C(n,k) = n!/(k!(n-k)!)</td><td>5 cards from 52</td><td>Card games</td></tr>
                    <tr><td>Expected Value</td><td>E = Σ(P(x) × V(x))</td><td>Dice average: 3.5</td><td>Game balancing</td></tr>
                </tbody>
            </table>

            <h3>🎯 Dice Probability Mathematics</h3>
            <div class="formula-box">
                <strong>Single Die Probability:</strong><br>
                P(specific number) = 1 / number of sides<br>
                P(at least X) = (sides - X + 1) / sides<br>
                P(at most X) = X / sides<br><br>
                
                <strong>Multiple Dice Probability:</strong><br>
                For n dice with s sides each:<br>
                Total outcomes = sⁿ<br>
                P(specific sum) = favorable outcomes / total outcomes<br>
                Average roll = n × (s + 1) / 2
            </div>

            <h3>🃏 Card Probability Systems</h3>
            <table class="probability-table">
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>Scenario</th>
                        <th>Probability</th>
                        <th>Odds</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Poker</td><td>Royal Flush</td><td>0.000154%</td><td>649,739 to 1</td></tr>
                    <tr><td>Poker</td><td>Straight Flush</td><td>0.00139%</td><td>72,192 to 1</td></tr>
                    <tr><td>Poker</td><td>Four of a Kind</td><td>0.0240%</td><td>4,164 to 1</td></tr>
                    <tr><td>Poker</td><td>Full House</td><td>0.1441%</td><td>693 to 1</td></tr>
                    <tr><td>Poker</td><td>Flush</td><td>0.1965%</td><td>508 to 1</td></tr>
                    <tr><td>Blackjack</td><td>Natural Blackjack</td><td>4.83%</td><td>20 to 1</td></tr>
                    <tr><td>Blackjack</td><td>Dealer Bust (6 showing)</td><td>42%</td><td>1.38 to 1</td></tr>
                </tbody>
            </table>

            <h3>📦 Loot Box & Gacha Economics</h3>
            <ul>
                <li><strong>Pity System:</strong> Guaranteed rare item after certain number of pulls</li>
                <li><strong>Probability Stacking:</strong> Increased rates after failed attempts</li>
                <li><strong>Expected Cost:</strong> Average cost to obtain specific item</li>
                <li><strong>Whale Economics:</strong> Top 1% of players generate 50%+ of revenue</li>
                <li><strong>Sunken Cost Fallacy:</strong> Players continue spending to justify past expenses</li>
            </ul>

            <h3>⚔️ Battle & Combat Probabilities</h3>
            <div class="formula-box">
                <strong>Hit Probability:</strong><br>
                P(hit) = (Attack - Defense) / (Attack + Defense)<br>
                Critical Hit: Usually 5% base chance<br><br>
                
                <strong>Damage Expectation:</strong><br>
                E[damage] = P(hit) × average damage + P(crit) × crit damage<br><br>
                
                <strong>Survival Probability:</strong><br>
                P(survive n hits) = (1 - P(hit))ⁿ
            </div>

            <h3>🎰 Casino Game Odds</h3>
            <table class="probability-table">
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>House Edge</th>
                        <th>Best Bet</th>
                        <th>Player Win Probability</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Blackjack (basic strategy)</td><td>0.5%</td><td>Any</td><td>49.75%</td></tr>
                    <tr><td>Baccarat (Banker)</td><td>1.06%</td><td>Banker</td><td>49.32%</td></tr>
                    <tr><td>Craps (Pass Line)</td><td>1.41%</td><td>Pass Line</td><td>49.29%</td></tr>
                    <tr><td>Roulette (European)</td><td>2.70%</td><td>Even money</td><td>48.65%</td></tr>
                    <tr><td>Roulette (American)</td><td>5.26%</td><td>Even money</td><td>47.37%</td></tr>
                    <tr><td>Slot Machines</td><td>2-15%</td><td>Varies</td><td>40-49%</td></tr>
                </tbody>
            </table>

            <h3>📈 Probability Distributions in Gaming</h3>
            <ul>
                <li><strong>Uniform Distribution:</strong> Dice rolls, card draws (equal probability)</li>
                <li><strong>Binomial Distribution:</strong> Success/failure in multiple attempts</li>
                <li><strong>Poisson Distribution:</strong> Rare events over large numbers</li>
                <li><strong>Normal Distribution:</strong> Sum of multiple dice rolls</li>
                <li><strong>Geometric Distribution:</strong> Number of attempts until first success</li>
            </ul>

            <h3>🎮 Game Design Applications</h3>
            <div class="formula-box">
                <strong>Balancing Formulas:</strong><br>
                • Challenge Rating = (Enemy Power × Probability) / Player Power<br>
                • Reward Value = (Time Investment × Difficulty) / Drop Probability<br>
                • Progression Curve: Experience required = Base × Level^Exponent<br>
                • Luck Mitigation: Bad luck protection systems<br>
                • Skill vs Luck Ratio: (Player Impact) / (Random Impact)
            </div>

            <h3>⚠️ Common Probability Fallacies</h3>
            <table class="probability-table">
                <thead>
                    <tr>
                        <th>Fallacy</th>
                        <th>Description</th>
                        <th>Example</th>
                        <th>Reality</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Gambler's Fallacy</td><td>Past events affect future probability</td><td>"Red is due after 5 blacks"</td><td>Each spin independent</td></tr>
                    <tr><td>Hot Hand Fallacy</td><td>Success breeds more success</td><td>"I'm on a winning streak"</td><td>Random clusters occur</td></tr>
                    <tr><td>Monte Carlo Fallacy</td><td>Small sample represents population</td><td>"This slot is hot today"</td><td>Need large sample size</td></tr>
                    <tr><td>Base Rate Neglect</td><td>Ignore prior probabilities</td><td>Overestimate rare events</td><td>Consider base rates</td></tr>
                </tbody>
            </table>

            <h3>🔢 Advanced Probability Concepts</h3>
            <ul>
                <li><strong>Bayesian Probability:</strong> Updating beliefs with new evidence</li>
                <li><strong>Markov Chains:</strong> State-based probability systems</li>
                <li><strong>Monte Carlo Simulations:</strong> Random sampling for complex systems</li>
                <li><strong>Expected Utility Theory:</strong> Decision making under uncertainty</li>
                <li><strong>Kelly Criterion:</strong> Optimal betting strategy</li>
            </ul>
        </div>

        <div class="footer">
            <p>🎲 Professional Game Odds Calculator | Probability Analysis for Gaming</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate probabilities for dice, cards, loot boxes, and other game mechanics</p>
        </div>
    </div>

    <script>
        // DOM elements
        const gameTypeCards = document.querySelectorAll('.game-type-card');
        const diceControls = document.getElementById('diceControls');
        const cardControls = document.getElementById('cardControls');
        const diceType = document.getElementById('diceType');
        const diceCount = document.getElementById('diceCount');
        const targetValue = document.getElementById('targetValue');
        const comparisonType = document.getElementById('comparisonType');
        const secondValueGroup = document.getElementById('secondValueGroup');
        const secondValue = document.getElementById('secondValue');
        const calculateBtn = document.getElementById('calculateBtn');
        const resetBtn = document.getElementById('resetBtn');
        const simulateBtn = document.getElementById('simulateBtn');
        const probability = document.getElementById('probability');
        const oddsFraction = document.getElementById('oddsFraction');
        const oddsDecimal = document.getElementById('oddsDecimal');
        const expectedValue = document.getElementById('expectedValue');
        const probabilityFill = document.getElementById('probabilityFill');
        const distributionChart = document.getElementById('distributionChart');
        const probabilityTips = document.getElementById('probabilityTips');

        // Current state
        let currentGameType = 'dice';

        // Initialize
        setupEventListeners();
        calculateProbability();

        function setupEventListeners() {
            // Game type cards
            gameTypeCards.forEach(card => {
                card.addEventListener('click', function() {
                    gameTypeCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    currentGameType = this.dataset.type;
                    updateGameType();
                });
            });

            // Calculate button
            calculateBtn.addEventListener('click', calculateProbability);
            
            // Reset button
            resetBtn.addEventListener('click', resetCalculator);
            
            // Simulate button
            simulateBtn.addEventListener('click', runSimulation);
            
            // Input listeners
            diceType.addEventListener('change', updateDiceSettings);
            comparisonType.addEventListener('change', updateComparisonType);
            diceCount.addEventListener('input', calculateProbability);
            targetValue.addEventListener('input', calculateProbability);
            secondValue.addEventListener('input', calculateProbability);
            
            // Initialize dice settings
            updateDiceSettings();
            updateComparisonType();
        }

        function updateGameType() {
            // Show/hide appropriate controls
            diceControls.style.display = currentGameType === 'dice' ? 'block' : 'none';
            cardControls.style.display = currentGameType === 'cards' ? 'block' : 'none';
            
            calculateProbability();
        }

        function updateDiceSettings() {
            const selectedDice = diceType.value;
            let maxSides = 6;
            
            switch(selectedDice) {
                case 'd4': maxSides = 4; break;
                case 'd6': maxSides = 6; break;
                case 'd8': maxSides = 8; break;
                case 'd10': maxSides = 10; break;
                case 'd12': maxSides = 12; break;
                case 'd20': maxSides = 20; break;
                case 'd100': maxSides = 100; break;
                case 'custom': maxSides = 100; break;
            }
            
            targetValue.max = maxSides * parseInt(diceCount.value);
            if (targetValue.value > maxSides * parseInt(diceCount.value)) {
                targetValue.value = maxSides * parseInt(diceCount.value);
            }
            
            calculateProbability();
        }

        function updateComparisonType() {
            if (comparisonType.value === 'between') {
                secondValueGroup.style.display = 'block';
            } else {
                secondValueGroup.style.display = 'none';
            }
            calculateProbability();
        }

        function calculateProbability() {
            let prob = 0;
            let description = '';
            
            switch(currentGameType) {
                case 'dice':
                    prob = calculateDiceProbability();
                    description = getDiceDescription();
                    break;
                case 'cards':
                    prob = calculateCardProbability();
                    description = getCardDescription();
                    break;
                case 'lootbox':
                    prob = calculateLootboxProbability();
                    description = getLootboxDescription();
                    break;
                default:
                    prob = 0.5;
                    description = 'Custom scenario';
            }
            
            // Update results
            probability.textContent = (prob * 100).toFixed(2) + '%';
            probabilityFill.style.width = (prob * 100) + '%';
            
            // Update odds
            updateOddsDisplay(prob);
            
            // Update distribution chart
            updateDistributionChart();
            
            // Update tips
            generateProbabilityTips(prob);
            
            // Update result card styling based on probability
            updateResultCardStyle(prob);
        }

        function calculateDiceProbability() {
            const sides = getDiceSides();
            const count = parseInt(diceCount.value);
            const target = parseInt(targetValue.value);
            const compType = comparisonType.value;
            const secondVal = parseInt(secondValue.value);
            
            let favorable = 0;
            const total = Math.pow(sides, count);
            
            // Calculate favorable outcomes based on comparison type
            if (compType === 'equal') {
                // Only exactly the target value
                favorable = countWaysToSum(sides, count, target);
            } else if (compType === 'greater') {
                // Greater than or equal to target
                for (let i = target; i <= count * sides; i++) {
                    favorable += countWaysToSum(sides, count, i);
                }
            } else if (compType === 'less') {
                // Less than or equal to target
                for (let i = count; i <= target; i++) {
                    favorable += countWaysToSum(sides, count, i);
                }
            } else if (compType === 'between') {
                // Between target and second value
                for (let i = target; i <= secondVal; i++) {
                    favorable += countWaysToSum(sides, count, i);
                }
            }
            
            return favorable / total;
        }

        function getDiceSides() {
            switch(diceType.value) {
                case 'd4': return 4;
                case 'd6': return 6;
                case 'd8': return 8;
                case 'd10': return 10;
                case 'd12': return 12;
                case 'd20': return 20;
                case 'd100': return 100;
                case 'custom': return 6; // Default for custom
                default: return 6;
            }
        }

        function countWaysToSum(sides, dice, target) {
            // Dynamic programming approach to count ways to get target sum
            if (dice === 0) return target === 0 ? 1 : 0;
            if (target < dice || target > dice * sides) return 0;
            
            let dp = new Array(dice + 1).fill(0).map(() => new Array(target + 1).fill(0));
            dp[0][0] = 1;
            
            for (let d = 1; d <= dice; d++) {
                for (let s = d; s <= d * sides; s++) {
                    for (let face = 1; face <= sides; face++) {
                        if (s >= face) {
                            dp[d][s] += dp[d - 1][s - face];
                        }
                    }
                }
            }
            
            return dp[dice][target];
        }

        function calculateCardProbability() {
            // Simplified card probability calculation
            const handSize = parseInt(document.getElementById('handSize').value) || 5;
            const targetCards = parseInt(document.getElementById('targetCards').value) || 1;
            const condition = document.getElementById('cardCondition').value;
            
            let successCards = 0;
            const totalCards = 52;
            
            switch(condition) {
                case 'suit':
                    successCards = 13; // 13 cards per suit
                    break;
                case 'face':
                    successCards = 12; // 12 face cards
                    break;
                case 'number':
                    successCards = 36; // 36 number cards (2-10)
                    break;
                default:
                    successCards = 4; // Default to specific cards
            }
            
            // Hypergeometric distribution approximation
            const prob = hypergeometricProbability(totalCards, successCards, handSize, targetCards);
            return prob;
        }

        function hypergeometricProbability(N, K, n, k) {
            // P(X = k) = [C(K, k) × C(N-K, n-k)] / C(N, n)
            return combination(K, k) * combination(N - K, n - k) / combination(N, n);
        }

        function combination(n, k) {
            if (k < 0 || k > n) return 0;
            if (k === 0 || k === n) return 1;
            
            k = Math.min(k, n - k);
            let result = 1;
            for (let i = 1; i <= k; i++) {
                result = result * (n - k + i) / i;
            }
            return result;
        }

        function calculateLootboxProbability() {
            // Simplified loot box probability
            return 0.01; // 1% chance for demonstration
        }

        function getDiceDescription() {
            const sides = getDiceSides();
            const count = parseInt(diceCount.value);
            const target = parseInt(targetValue.value);
            const compType = comparisonType.value;
            const secondVal = parseInt(secondValue.value);
            
            let desc = `${count}d${sides} `;
            
            switch(compType) {
                case 'equal':
                    desc += `= ${target}`;
                    break;
                case 'greater':
                    desc += `≥ ${target}`;
                    break;
                case 'less':
                    desc += `≤ ${target}`;
                    break;
                case 'between':
                    desc += `between ${target} and ${secondVal}`;
                    break;
            }
            
            return desc;
        }

        function getCardDescription() {
            return "Card draw probability";
        }

        function getLootboxDescription() {
            return "Loot box probability";
        }

        function updateOddsDisplay(probability) {
            // Fractional odds
            if (probability > 0) {
                const odds = 1 / probability;
                oddsFraction.textContent = `1 in ${odds.toFixed(2)}`;
                oddsDecimal.textContent = odds.toFixed(2);
            } else {
                oddsFraction.textContent = 'Impossible';
                oddsDecimal.textContent = '∞';
            }
            
            // Expected value (for dice, average success per try)
            expectedValue.textContent = probability.toFixed(3);
        }

        function updateDistributionChart() {
            const sides = getDiceSides();
            const count = parseInt(diceCount.value);
            const minSum = count;
            const maxSum = count * sides;
            
            distributionChart.innerHTML = '';
            
            // Calculate distribution
            for (let sum = minSum; sum <= maxSum; sum++) {
                const probability = countWaysToSum(sides, count, sum) / Math.pow(sides, count);
                const barHeight = (probability * 1000).toFixed(0); // Scale for visibility
                
                const bar = document.createElement('div');
                bar.className = 'chart-bar';
                bar.style.height = barHeight + 'px';
                bar.title = `Sum ${sum}: ${(probability * 100).toFixed(1)}%`;
                
                const label = document.createElement('div');
                label.className = 'chart-label';
                label.textContent = sum;
                
                bar.appendChild(label);
                distributionChart.appendChild(bar);
            }
        }

        function updateResultCardStyle(probability) {
            const resultCard = probability.parentElement.parentElement;
            resultCard.className = 'result-card';
            
            if (probability >= 0.7) {
                resultCard.classList.add('highlight');
            } else if (probability >= 0.3) {
                resultCard.classList.add('warning');
            } else if (probability > 0) {
                resultCard.classList.add('danger');
            }
        }

        function generateProbabilityTips(probability) {
            const tips = [
                {
                    icon: '📊',
                    title: 'Understand the Math',
                    desc: 'Probability = Favorable Outcomes / Total Possible Outcomes'
                },
                {
                    icon: '⚡',
                    title: 'Independent Events',
                    desc: 'Each dice roll or card draw is independent of previous ones'
                }
            ];
            
            if (probability < 0.01) {
                tips.push({
                    icon: '🎯',
                    title: 'Very Low Probability',
                    desc: 'Consider if the reward justifies the low chance of success'
                });
            } else if (probability > 0.5) {
                tips.push({
                    icon: '✅',
                    title: 'Favorable Odds',
                    desc: 'You have better than even chance of success'
                });
            }
            
            if (currentGameType === 'lootbox') {
                tips.push({
                    icon: '💰',
                    title: 'Loot Box Economics',
                    desc: 'Calculate expected cost: Cost per try ÷ Probability'
                });
            }
            
            probabilityTips.innerHTML = tips.map(tip => `
                <div class="tip-card">
                    <div class="tip-icon">${tip.icon}</div>
                    <div class="tip-title">${tip.title}</div>
                    <div class="tip-desc">${tip.desc}</div>
                </div>
            `).join('');
        }

        function resetCalculator() {
            diceType.value = 'd6';
            diceCount.value = 1;
            targetValue.value = 4;
            comparisonType.value = 'greater';
            secondValue.value = 6;
            
            // Reset to first game type
            gameTypeCards[0].click();
            
            calculateProbability();
        }

        function runSimulation() {
            const trials = 10000;
            let successes = 0;
            
            // Run Monte Carlo simulation
            for (let i = 0; i < trials; i++) {
                if (simulateTrial()) {
                    successes++;
                }
            }
            
            const simulatedProbability = successes / trials;
            const actualProbability = parseFloat(probability.textContent) / 100;
            
            alert(`Simulation Results (${trials.toLocaleString()} trials):\n\n` +
                  `Simulated: ${(simulatedProbability * 100).toFixed(2)}%\n` +
                  `Theoretical: ${(actualProbability * 100).toFixed(2)}%\n` +
                  `Difference: ${Math.abs(simulatedProbability - actualProbability) * 100}%`);
        }

        function simulateTrial() {
            switch(currentGameType) {
                case 'dice':
                    return simulateDiceRoll();
                case 'cards':
                    return simulateCardDraw();
                default:
                    return Math.random() < 0.5;
            }
        }

        function simulateDiceRoll() {
            const sides = getDiceSides();
            const count = parseInt(diceCount.value);
            const target = parseInt(targetValue.value);
            const compType = comparisonType.value;
            const secondVal = parseInt(secondValue.value);
            
            let sum = 0;
            for (let i = 0; i < count; i++) {
                sum += Math.floor(Math.random() * sides) + 1;
            }
            
            switch(compType) {
                case 'equal': return sum === target;
                case 'greater': return sum >= target;
                case 'less': return sum <= target;
                case 'between': return sum >= target && sum <= secondVal;
                default: return false;
            }
        }

        function simulateCardDraw() {
            // Simplified card simulation
            return Math.random() < 0.2; // 20% chance for demo
        }

        // Initialize calculation
        calculateProbability();
    </script>
</body>
</html>
