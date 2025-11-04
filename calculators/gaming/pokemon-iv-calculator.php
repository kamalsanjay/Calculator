<?php
/**
 * Pokemon IV Calculator
 * File: gaming/pokemon-iv-calculator.php
 * Description: Calculate Individual Values (IVs) for Pokemon to determine hidden potential stats
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon IV Calculator - Determine Hidden Potential</title>
    <meta name="description" content="Calculate Individual Values (IVs) for Pokémon to determine hidden potential stats and breeding quality.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .pokemon-selector { margin-bottom: 25px; }
        .pokemon-search { display: grid; grid-template-columns: 1fr auto; gap: 15px; margin-bottom: 20px; }
        .pokemon-search input { padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; }
        .pokemon-search input:focus { outline: none; border-color: #667eea; }
        
        .pokemon-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px; max-height: 300px; overflow-y: auto; padding: 10px; border: 2px solid #e0e0e0; border-radius: 10px; }
        .pokemon-item { text-align: center; padding: 10px; border-radius: 8px; cursor: pointer; transition: all 0.3s; }
        .pokemon-item:hover { background: #f0f0f0; }
        .pokemon-item.active { background: #667eea; color: white; }
        .pokemon-sprite { width: 64px; height: 64px; object-fit: contain; }
        .pokemon-name { font-size: 0.8rem; margin-top: 5px; }
        
        .stats-section { margin-bottom: 25px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .stat-group { background: #f8f9fa; padding: 20px; border-radius: 10px; }
        .stat-group h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1rem; display: flex; align-items: center; gap: 8px; }
        .stat-input { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .stat-label { min-width: 80px; font-weight: 600; color: #34495e; }
        .stat-input input { flex: 1; padding: 10px; border: 1px solid #e0e0e0; border-radius: 5px; }
        
        .level-section { background: #e3f2fd; padding: 20px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #2196f3; }
        .level-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .level-controls { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
        
        .nature-section { margin-bottom: 25px; }
        .nature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; }
        .nature-item { padding: 12px; background: #f8f9fa; border-radius: 8px; cursor: pointer; text-align: center; transition: all 0.3s; }
        .nature-item:hover { border-color: #667eea; }
        .nature-item.active { background: #667eea; color: white; }
        
        .results-section { margin-bottom: 25px; }
        .iv-results { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .iv-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; text-align: center; }
        .iv-card.perfect { background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); border-left-color: #4caf50; }
        .iv-card.good { background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); border-left-color: #ff9800; }
        .iv-card.poor { background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); border-left-color: #f44336; }
        .iv-value { font-size: 1.5rem; font-weight: bold; color: #5e35b1; margin-bottom: 5px; }
        .iv-card.perfect .iv-value { color: #2e7d32; }
        .iv-card.good .iv-value { color: #ef6c00; }
        .iv-card.poor .iv-value { color: #c62828; }
        .iv-label { font-size: 0.85rem; color: #4527a0; font-weight: 600; }
        .iv-card.perfect .iv-label { color: #1b5e20; }
        .iv-card.good .iv-label { color: #e65100; }
        .iv-card.poor .iv-label { color: #b71c1c; }
        .iv-percentage { font-size: 0.75rem; color: #7f8c8d; margin-top: 5px; }
        
        .iv-visual { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .iv-visual h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .iv-bars { display: flex; flex-direction: column; gap: 15px; }
        .iv-bar { display: flex; align-items: center; gap: 15px; }
        .iv-bar-label { min-width: 80px; font-weight: 600; color: #34495e; }
        .iv-bar-container { flex: 1; height: 20px; background: #e0e0e0; border-radius: 10px; overflow: hidden; }
        .iv-bar-fill { height: 100%; background: linear-gradient(90deg, #f44336, #ff9800, #4caf50); border-radius: 10px; transition: width 0.5s ease; }
        .iv-bar-value { min-width: 40px; text-align: right; font-weight: 600; }
        
        .potential-rating { background: #e8f5e8; padding: 25px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #4caf50; }
        .potential-rating h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .rating-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .rating-card { background: white; padding: 20px; border-radius: 8px; text-align: center; }
        .rating-value { font-size: 2rem; font-weight: bold; color: #2c3e50; margin-bottom: 10px; }
        .rating-label { font-size: 0.9rem; color: #7f8c8d; }
        .rating-description { font-size: 0.8rem; color: #555; margin-top: 10px; }
        
        .breeding-info { background: #fff3e0; padding: 25px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #ff9800; }
        .breeding-info h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .breeding-tips { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; }
        .breeding-tip { background: white; padding: 15px; border-radius: 8px; }
        .breeding-tip h4 { color: #2c3e50; margin-bottom: 8px; font-size: 0.9rem; }
        .breeding-tip p { font-size: 0.8rem; color: #555; }
        
        .action-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .action-btn { padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3); }
        .action-btn.secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .action-btn.secondary:hover { border-color: #667eea; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .iv-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .iv-table th, .iv-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .iv-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .iv-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .pokemon-search { grid-template-columns: 1fr; }
            .pokemon-grid { grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); }
            .stats-grid { grid-template-columns: 1fr; }
            .iv-results { grid-template-columns: repeat(2, 1fr); }
            .rating-grid { grid-template-columns: 1fr; }
            .breeding-tips { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { grid-template-columns: 1fr; }
            .nature-grid { grid-template-columns: repeat(3, 1fr); }
        }
        
        @media (max-width: 480px) {
            .iv-results { grid-template-columns: 1fr; }
            .calculator-card { padding: 20px; }
            .header { padding: 20px; }
            .pokemon-grid { grid-template-columns: repeat(3, 1fr); }
            .nature-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚡ Pokémon IV Calculator</h1>
            <p>Calculate Individual Values (IVs) to determine your Pokémon's hidden potential and breeding quality</p>
        </div>

        <div class="calculator-card">
            <div class="pokemon-selector">
                <div class="pokemon-search">
                    <input type="text" id="pokemonSearch" placeholder="Search Pokémon...">
                    <button class="action-btn secondary" id="clearSearch">
                        <span>🗑️</span> Clear
                    </button>
                </div>
                
                <div class="pokemon-grid" id="pokemonGrid">
                    <!-- Pokémon will be populated here -->
                </div>
            </div>
            
            <div class="stats-section">
                <div class="stats-grid">
                    <div class="stat-group">
                        <h3>📊 Base Stats</h3>
                        <div class="stat-input">
                            <span class="stat-label">HP</span>
                            <input type="number" id="baseHP" value="45" min="1" max="255">
                        </div>
                        <div class="stat-input">
                            <span class="stat-label">Attack</span>
                            <input type="number" id="baseAtk" value="49" min="1" max="255">
                        </div>
                        <div class="stat-input">
                            <span class="stat-label">Defense</span>
                            <input type="number" id="baseDef" value="49" min="1" max="255">
                        </div>
                        <div class="stat-input">
                            <span class="stat-label">Sp. Atk</span>
                            <input type="number" id="baseSpA" value="65" min="1" max="255">
                        </div>
                        <div class="stat-input">
                            <span class="stat-label">Sp. Def</span>
                            <input type="number" id="baseSpD" value="65" min="1" max="255">
                        </div>
                        <div class="stat-input">
                            <span class="stat-label">Speed</span>
                            <input type="number" id="baseSpe" value="45" min="1" max="255">
                        </div>
                    </div>
                    
                    <div class="stat-group">
                        <h3>🎯 Current Stats</h3>
                        <div class="stat-input">
                            <span class="stat-label">HP</span>
                            <input type="number" id="currentHP" value="20" min="1" max="999">
                        </div>
                        <div class="stat-input">
                            <span class="stat-label">Attack</span>
                            <input type="number" id="currentAtk" value="12" min="1" max="999">
                        </div>
                        <div class="stat-input">
                            <span class="stat-label">Defense</span>
                            <input type="number" id="currentDef" value="12" min="1" max="999">
                        </div>
                        <div class="stat-input">
                            <span class="stat-label">Sp. Atk</span>
                            <input type="number" id="currentSpA" value="16" min="1" max="999">
                        </div>
                        <div class="stat-input">
                            <span class="stat-label">Sp. Def</span>
                            <input type="number" id="currentSpD" value="16" min="1" max="999">
                        </div>
                        <div class="stat-input">
                            <span class="stat-label">Speed</span>
                            <input type="number" id="currentSpe" value="11" min="1" max="999">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="level-section">
                <h3>📈 Level & EVs</h3>
                <div class="level-controls">
                    <div class="stat-input">
                        <span class="stat-label">Level</span>
                        <input type="number" id="pokemonLevel" value="5" min="1" max="100">
                    </div>
                    <div class="stat-input">
                        <span class="stat-label">HP EVs</span>
                        <input type="number" id="evHP" value="0" min="0" max="252">
                    </div>
                    <div class="stat-input">
                        <span class="stat-label">Atk EVs</span>
                        <input type="number" id="evAtk" value="0" min="0" max="252">
                    </div>
                    <div class="stat-input">
                        <span class="stat-label">Def EVs</span>
                        <input type="number" id="evDef" value="0" min="0" max="252">
                    </div>
                </div>
            </div>
            
            <div class="nature-section">
                <h3>🌿 Nature</h3>
                <div class="nature-grid" id="natureGrid">
                    <!-- Natures will be populated here -->
                </div>
            </div>
            
            <div class="results-section">
                <div class="iv-results">
                    <div class="iv-card" id="ivHP">
                        <div class="iv-value">15</div>
                        <div class="iv-label">HP IV</div>
                        <div class="iv-percentage">62.5%</div>
                    </div>
                    <div class="iv-card" id="ivAtk">
                        <div class="iv-value">20</div>
                        <div class="iv-label">ATTACK IV</div>
                        <div class="iv-percentage">83.3%</div>
                    </div>
                    <div class="iv-card" id="ivDef">
                        <div class="iv-value">18</div>
                        <div class="iv-label">DEFENSE IV</div>
                        <div class="iv-percentage">75.0%</div>
                    </div>
                    <div class="iv-card" id="ivSpA">
                        <div class="iv-value">25</div>
                        <div class="iv-label">SP. ATK IV</div>
                        <div class="iv-percentage">100%</div>
                    </div>
                    <div class="iv-card" id="ivSpD">
                        <div class="iv-value">22</div>
                        <div class="iv-label">SP. DEF IV</div>
                        <div class="iv-percentage">91.7%</div>
                    </div>
                    <div class="iv-card" id="ivSpe">
                        <div class="iv-value">12</div>
                        <div class="iv-label">SPEED IV</div>
                        <div class="iv-percentage">50.0%</div>
                    </div>
                </div>
                
                <div class="iv-visual">
                    <h3>📊 IV Distribution</h3>
                    <div class="iv-bars">
                        <div class="iv-bar">
                            <span class="iv-bar-label">HP</span>
                            <div class="iv-bar-container">
                                <div class="iv-bar-fill" id="ivBarHP" style="width: 62.5%;"></div>
                            </div>
                            <span class="iv-bar-value" id="ivValueHP">15</span>
                        </div>
                        <div class="iv-bar">
                            <span class="iv-bar-label">Attack</span>
                            <div class="iv-bar-container">
                                <div class="iv-bar-fill" id="ivBarAtk" style="width: 83.3%;"></div>
                            </div>
                            <span class="iv-bar-value" id="ivValueAtk">20</span>
                        </div>
                        <div class="iv-bar">
                            <span class="iv-bar-label">Defense</span>
                            <div class="iv-bar-container">
                                <div class="iv-bar-fill" id="ivBarDef" style="width: 75%;"></div>
                            </div>
                            <span class="iv-bar-value" id="ivValueDef">18</span>
                        </div>
                        <div class="iv-bar">
                            <span class="iv-bar-label">Sp. Atk</span>
                            <div class="iv-bar-container">
                                <div class="iv-bar-fill" id="ivBarSpA" style="width: 100%;"></div>
                            </div>
                            <span class="iv-bar-value" id="ivValueSpA">25</span>
                        </div>
                        <div class="iv-bar">
                            <span class="iv-bar-label">Sp. Def</span>
                            <div class="iv-bar-container">
                                <div class="iv-bar-fill" id="ivBarSpD" style="width: 91.7%;"></div>
                            </div>
                            <span class="iv-bar-value" id="ivValueSpD">22</span>
                        </div>
                        <div class="iv-bar">
                            <span class="iv-bar-label">Speed</span>
                            <div class="iv-bar-container">
                                <div class="iv-bar-fill" id="ivBarSpe" style="width: 50%;"></div>
                            </div>
                            <span class="iv-bar-value" id="ivValueSpe">12</span>
                        </div>
                    </div>
                </div>
                
                <div class="potential-rating">
                    <h3>⭐ Overall Potential</h3>
                    <div class="rating-grid">
                        <div class="rating-card">
                            <div class="rating-value" id="totalIV">112</div>
                            <div class="rating-label">TOTAL IVs</div>
                            <div class="rating-description">Out of 186 maximum</div>
                        </div>
                        <div class="rating-card">
                            <div class="rating-value" id="ivPercentage">74.7%</div>
                            <div class="rating-label">OVERALL PERCENTAGE</div>
                            <div class="rating-description">Average IV quality</div>
                        </div>
                        <div class="rating-card">
                            <div class="rating-value" id="perfectIVs">1</div>
                            <div class="rating-label">PERFECT IVs</div>
                            <div class="rating-description">31 IV stats</div>
                        </div>
                        <div class="rating-card">
                            <div class="rating-value" id="rating">B+</div>
                            <div class="rating-label">RATING</div>
                            <div class="rating-description">Competitive potential</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="breeding-info">
                <h3>🐣 Breeding Recommendations</h3>
                <div class="breeding-tips" id="breedingTips">
                    <!-- Breeding tips will be generated here -->
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="action-btn" id="calculateBtn">
                    <span>🧮</span> Calculate IVs
                </button>
                <button class="action-btn secondary" id="resetBtn">
                    <span>🔄</span> Reset
                </button>
                <button class="action-btn secondary" id="perfectIVBtn">
                    <span>⭐</span> Perfect IV Mode
                </button>
            </div>
        </div>

        <div class="info-section">
            <h2>⚡ Pokémon IV Science</h2>
            
            <p>Individual Values (IVs) are hidden stats that determine a Pokémon's potential. Each Pokémon has unique IVs ranging from 0-31 for each stat, making them truly individual.</p>

            <h3>📊 Stat Calculation Formula</h3>
            <div class="formula-box">
                <strong>HP Formula:</strong><br>
                HP = floor(0.01 × (2 × Base + IV + floor(0.25 × EV)) × Level) + Level + 10<br><br>
                
                <strong>Other Stats Formula:</strong><br>
                Stat = floor(0.01 × (2 × Base + IV + floor(0.25 × EV)) × Level) + 5<br>
                Then multiply by Nature modifier if applicable<br><br>
                
                <strong>Nature Modifiers:</strong><br>
                • Beneficial: ×1.1<br>
                • Hindering: ×0.9<br>
                • Neutral: ×1.0
            </div>

            <h3>🎯 IV Ranges & Quality</h3>
            <table class="iv-table">
                <thead>
                    <tr>
                        <th>IV Range</th>
                        <th>Percentage</th>
                        <th>Quality</th>
                        <th>Competitive Use</th>
                        <th>Breeding Priority</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>0-5</td><td>0-16%</td><td>Very Poor</td><td>Not viable</td><td>Release</td></tr>
                    <tr><td>6-15</td><td>19-48%</td><td>Poor</td><td>Casual only</td><td>Breeding fodder</td></tr>
                    <tr><td>16-25</td><td>52-81%</td><td>Good</td><td>Viable</td><td>Good parent</td></tr>
                    <tr><td>26-29</td><td>84-94%</td><td>Excellent</td><td>Competitive</td><td>Great parent</td></tr>
                    <tr><td>30</td><td>97%</td><td>Near Perfect</td><td>Optimal</td><td>Ideal parent</td></tr>
                    <tr><td>31</td><td>100%</td><td>Perfect</td><td>Perfect</td><td>Best parent</td></tr>
                </tbody>
            </table>

            <h3>🌿 Nature Effects</h3>
            <table class="iv-table">
                <thead>
                    <tr>
                        <th>Nature</th>
                        <th>Increases</th>
                        <th>Decreases</th>
                        <th>Common Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Adamant</td><td>Attack</td><td>Sp. Attack</td><td>Physical attackers</td></tr>
                    <tr><td>Modest</td><td>Sp. Attack</td><td>Attack</td><td>Special attackers</td></tr>
                    <tr><td>Jolly</td><td>Speed</td><td>Sp. Attack</td><td>Fast physical</td></tr>
                    <tr><td>Timid</td><td>Speed</td><td>Attack</td><td>Fast special</td></tr>
                    <tr><td>Bold</td><td>Defense</td><td>Attack</td><td>Defensive walls</td></tr>
                    <tr><td>Calm</td><td>Sp. Defense</td><td>Attack</td><td>Special walls</td></tr>
                    <tr><td>Impish</td><td>Defense</td><td>Sp. Attack</td><td>Physical walls</td></tr>
                    <tr><td>Careful</td><td>Sp. Defense</td><td>Sp. Attack</td><td>Special walls</td></tr>
                </tbody>
            </table>

            <h3>🐣 Breeding Mechanics</h3>
            <ul>
                <li><strong>Destiny Knot:</strong> Passes 5 IVs from parents (randomly selected)</li>
                <li><strong>Everstone:</strong> Passes Nature from holding parent</li>
                <li><strong>Power Items:</strong> Guarantee specific IV inheritance</li>
                <li><strong>IV Inheritance:</strong> 3-5 IVs passed from parents when using Destiny Knot</li>
                <li><strong>Masuda Method:</strong> Increased shiny odds with different language parents</li>
            </ul>

            <h3>⚡ Competitive IV Spreads</h3>
            <div class="formula-box">
                <strong>Common Competitive Spreads:</strong><br>
                • Physical Sweeper: 31/31/31/x/31/31 (x = irrelevant)<br>
                • Special Sweeper: 31/x/31/31/31/31<br>
                • Mixed Attacker: 31/31/31/31/31/31 (6IV)<br>
                • Trick Room: 31/31/31/31/31/0 (0 Speed)<br>
                • Special Wall: 31/x/31/31/31/31<br>
                • Physical Wall: 31/31/31/x/31/31<br><br>
                
                <strong>Hidden Power Types:</strong><br>
                Specific IV combinations determine Hidden Power type
            </div>

            <h3>🔧 Advanced IV Techniques</h3>
            <table class="iv-table">
                <thead>
                    <tr>
                        <th>Technique</th>
                        <th>Purpose</th>
                        <th>Tools Needed</th>
                        <th>Time Required</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Chain Breeding</td><td>Move inheritance</td><td>Compatible parents</td><td>Medium</td></tr>
                    <tr><td>IV Breeding</td><td>Perfect stats</td><td>Destiny Knot, good parents</td><td>Long</td></tr>
                    <tr><td>Hyper Training</td><td>Max IVs at Lv 100</td><td>Bottle Caps</td><td>Quick</td></tr>
                    <tr><td>SOS Chaining</td><td>Wild high IVs</td><td>Adrenaline Orbs</td><td>Medium</td></tr>
                    <tr><td>Raid Battles</td><td>Guaranteed IVs</td><td>Nintendo Online</td><td>Quick</td></tr>
                </tbody>
            </table>

            <h3>🎮 Generation Differences</h3>
            <ul>
                <li><strong>Gen 1-2:</strong> IVs 0-15, determine Hidden Power and shininess</li>
                <li><strong>Gen 3-5:</strong> IVs 0-31, introduced Natures and modern system</li>
                <li><strong>Gen 6+:</strong> Super Training, Destiny Knot improvement</li>
                <li><strong>Gen 7+:</strong> Hyper Training, Bottle Caps</li>
                <li><strong>Gen 8+:</strong> Max Raids with guaranteed IVs</li>
            </ul>

            <h3>⚠️ Common Mistakes</h3>
            <div class="formula-box">
                <strong>Avoid These Breeding Errors:</strong><br>
                • Breeding without Destiny Knot (only 3 IVs inherited)<br>
                • Forgetting Everstone for Nature inheritance<br>
                • Not checking IVs before breeding<br>
                • Releasing good parent Pokémon<br>
                • Ignoring egg move compatibility<br>
                • Breeding wrong Nature for intended role
            </div>

            <h3>📈 Perfect IV Probability</h3>
            <table class="iv-table">
                <thead>
                    <tr>
                        <th>Parents' IVs</th>
                        <th>Chance of 6IV Offspring</th>
                        <th>Average Eggs Needed</th>
                        <th>With Destiny Knot</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Two 6IV parents</td><td>1/32</td><td>32 eggs</td><td>1/6</td></tr>
                    <tr><td>Two 5IV parents</td><td>1/192</td><td>192 eggs</td><td>1/32</td></tr>
                    <tr><td>Two 4IV parents</td><td>1/1024</td><td>1024 eggs</td><td>1/96</td></tr>
                    <tr><td>One 6IV, one 5IV</td><td>1/96</td><td>96 eggs</td><td>1/12</td></tr>
                    <tr><td>One 6IV, one 4IV</td><td>1/384</td><td>384 eggs</td><td>1/24</td></tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>⚡ Professional Pokémon IV Calculator | Determine Hidden Potential</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate Individual Values for competitive breeding and training</p>
        </div>
    </div>

    <script>
        // DOM elements
        const pokemonSearch = document.getElementById('pokemonSearch');
        const clearSearch = document.getElementById('clearSearch');
        const pokemonGrid = document.getElementById('pokemonGrid');
        const calculateBtn = document.getElementById('calculateBtn');
        const resetBtn = document.getElementById('resetBtn');
        const perfectIVBtn = document.getElementById('perfectIVBtn');
        const natureGrid = document.getElementById('natureGrid');

        // Pokémon database (simplified)
        const pokemonDatabase = [
            { id: 1, name: 'Bulbasaur', sprite: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png', stats: [45, 49, 49, 65, 65, 45] },
            { id: 4, name: 'Charmander', sprite: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/4.png', stats: [39, 52, 43, 60, 50, 65] },
            { id: 7, name: 'Squirtle', sprite: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/7.png', stats: [44, 48, 65, 50, 64, 43] },
            { id: 25, name: 'Pikachu', sprite: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png', stats: [35, 55, 40, 50, 50, 90] },
            { id: 133, name: 'Eevee', sprite: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/133.png', stats: [55, 55, 50, 45, 65, 55] },
            { id: 448, name: 'Lucario', sprite: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/448.png', stats: [70, 110, 70, 115, 70, 90] },
            { id: 149, name: 'Dragonite', sprite: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/149.png', stats: [91, 134, 95, 100, 100, 80] },
            { id: 382, name: 'Kyogre', sprite: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/382.png', stats: [100, 100, 90, 150, 140, 90] },
            { id: 383, name: 'Groudon', sprite: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/383.png', stats: [100, 150, 140, 100, 90, 90] },
            { id: 384, name: 'Rayquaza', sprite: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/384.png', stats: [105, 150, 90, 150, 90, 95] }
        ];

        // Nature database
        const natures = [
            { name: 'Hardy', plus: null, minus: null },
            { name: 'Lonely', plus: 'atk', minus: 'def' },
            { name: 'Brave', plus: 'atk', minus: 'spe' },
            { name: 'Adamant', plus: 'atk', minus: 'spa' },
            { name: 'Naughty', plus: 'atk', minus: 'spd' },
            { name: 'Bold', plus: 'def', minus: 'atk' },
            { name: 'Docile', plus: null, minus: null },
            { name: 'Relaxed', plus: 'def', minus: 'spe' },
            { name: 'Impish', plus: 'def', minus: 'spa' },
            { name: 'Lax', plus: 'def', minus: 'spd' },
            { name: 'Timid', plus: 'spe', minus: 'atk' },
            { name: 'Hasty', plus: 'spe', minus: 'def' },
            { name: 'Serious', plus: null, minus: null },
            { name: 'Jolly', plus: 'spe', minus: 'spa' },
            { name: 'Naive', plus: 'spe', minus: 'spd' },
            { name: 'Modest', plus: 'spa', minus: 'atk' },
            { name: 'Mild', plus: 'spa', minus: 'def' },
            { name: 'Quiet', plus: 'spa', minus: 'spe' },
            { name: 'Bashful', plus: null, minus: null },
            { name: 'Rash', plus: 'spa', minus: 'spd' },
            { name: 'Calm', plus: 'spd', minus: 'atk' },
            { name: 'Gentle', plus: 'spd', minus: 'def' },
            { name: 'Sassy', plus: 'spd', minus: 'spe' },
            { name: 'Careful', plus: 'spd', minus: 'spa' },
            { name: 'Quirky', plus: null, minus: null }
        ];

        // Initialize
        loadPokemonGrid();
        loadNatures();
        setupEventListeners();
        calculateIVs();

        function loadPokemonGrid() {
            pokemonGrid.innerHTML = '';
            pokemonDatabase.forEach(pokemon => {
                const item = document.createElement('div');
                item.className = 'pokemon-item';
                item.innerHTML = `
                    <img src="${pokemon.sprite}" alt="${pokemon.name}" class="pokemon-sprite">
                    <div class="pokemon-name">${pokemon.name}</div>
                `;
                item.addEventListener('click', () => selectPokemon(pokemon));
                pokemonGrid.appendChild(item);
            });
            
            // Select first Pokémon by default
            if (pokemonDatabase.length > 0) {
                selectPokemon(pokemonDatabase[0]);
            }
        }

        function loadNatures() {
            natureGrid.innerHTML = '';
            natures.forEach(nature => {
                const item = document.createElement('div');
                item.className = 'nature-item';
                item.textContent = nature.name;
                item.addEventListener('click', () => selectNature(nature));
                natureGrid.appendChild(item);
            });
            
            // Select Hardy (neutral) by default
            selectNature(natures[0]);
        }

        function setupEventListeners() {
            // Search functionality
            pokemonSearch.addEventListener('input', filterPokemon);
            clearSearch.addEventListener('click', () => {
                pokemonSearch.value = '';
                filterPokemon();
            });
            
            // Calculate button
            calculateBtn.addEventListener('click', calculateIVs);
            
            // Reset button
            resetBtn.addEventListener('click', resetCalculator);
            
            // Perfect IV button
            perfectIVBtn.addEventListener('click', setPerfectIVs);
            
            // Input listeners for real-time calculation
            const inputs = [
                'baseHP', 'baseAtk', 'baseDef', 'baseSpA', 'baseSpD', 'baseSpe',
                'currentHP', 'currentAtk', 'currentDef', 'currentSpA', 'currentSpD', 'currentSpe',
                'pokemonLevel', 'evHP', 'evAtk', 'evDef'
            ];
            
            inputs.forEach(id => {
                document.getElementById(id).addEventListener('input', calculateIVs);
            });
        }

        function filterPokemon() {
            const searchTerm = pokemonSearch.value.toLowerCase();
            const items = pokemonGrid.querySelectorAll('.pokemon-item');
            
            items.forEach(item => {
                const name = item.querySelector('.pokemon-name').textContent.toLowerCase();
                if (name.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function selectPokemon(pokemon) {
            // Update active state
            const items = pokemonGrid.querySelectorAll('.pokemon-item');
            items.forEach(item => item.classList.remove('active'));
            event.target.closest('.pokemon-item').classList.add('active');
            
            // Update base stats
            document.getElementById('baseHP').value = pokemon.stats[0];
            document.getElementById('baseAtk').value = pokemon.stats[1];
            document.getElementById('baseDef').value = pokemon.stats[2];
            document.getElementById('baseSpA').value = pokemon.stats[3];
            document.getElementById('baseSpD').value = pokemon.stats[4];
            document.getElementById('baseSpe').value = pokemon.stats[5];
            
            calculateIVs();
        }

        function selectNature(nature) {
            // Update active state
            const items = natureGrid.querySelectorAll('.nature-item');
            items.forEach(item => item.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateIVs();
        }

        function calculateIVs() {
            // Get current values
            const level = parseInt(document.getElementById('pokemonLevel').value);
            const baseStats = {
                hp: parseInt(document.getElementById('baseHP').value),
                atk: parseInt(document.getElementById('baseAtk').value),
                def: parseInt(document.getElementById('baseDef').value),
                spa: parseInt(document.getElementById('baseSpA').value),
                spd: parseInt(document.getElementById('baseSpD').value),
                spe: parseInt(document.getElementById('baseSpe').value)
            };
            
            const currentStats = {
                hp: parseInt(document.getElementById('currentHP').value),
                atk: parseInt(document.getElementById('currentAtk').value),
                def: parseInt(document.getElementById('currentDef').value),
                spa: parseInt(document.getElementById('currentSpA').value),
                spd: parseInt(document.getElementById('currentSpD').value),
                spe: parseInt(document.getElementById('currentSpe').value)
            };
            
            const evs = {
                hp: parseInt(document.getElementById('evHP').value),
                atk: parseInt(document.getElementById('evAtk').value),
                def: parseInt(document.getElementById('evDef').value)
            };
            
            // Calculate IVs for each stat
            const ivs = {
                hp: calculateSingleIV('hp', baseStats.hp, currentStats.hp, level, evs.hp),
                atk: calculateSingleIV('atk', baseStats.atk, currentStats.atk, level, evs.atk),
                def: calculateSingleIV('def', baseStats.def, currentStats.def, level, evs.def),
                spa: calculateSingleIV('spa', baseStats.spa, currentStats.spa, level, 0),
                spd: calculateSingleIV('spd', baseStats.spd, currentStats.spd, level, 0),
                spe: calculateSingleIV('spe', baseStats.spe, currentStats.spe, level, 0)
            };
            
            // Update display
            updateIVDisplay(ivs);
            updatePotentialRating(ivs);
            updateBreedingTips(ivs);
        }

        function calculateSingleIV(stat, base, current, level, ev) {
            // Pokémon stat formula
            let iv = 0;
            
            if (stat === 'hp') {
                // HP formula
                iv = Math.floor(((current - level - 10) * 100 / level) - (2 * base) - Math.floor(ev / 4));
            } else {
                // Other stats formula
                iv = Math.floor(((current - 5) * 100 / level) - (2 * base) - Math.floor(ev / 4));
            }
            
            // Apply nature modifier
            const activeNature = document.querySelector('.nature-item.active');
            if (activeNature) {
                const natureName = activeNature.textContent;
                const nature = natures.find(n => n.name === natureName);
                
                if (nature && nature.plus === stat) {
                    iv = Math.floor(iv / 1.1);
                } else if (nature && nature.minus === stat) {
                    iv = Math.floor(iv / 0.9);
                }
            }
            
            // Clamp between 0-31
            return Math.max(0, Math.min(31, iv));
        }

        function updateIVDisplay(ivs) {
            const stats = ['hp', 'atk', 'def', 'spa', 'spd', 'spe'];
            
            stats.forEach(stat => {
                const iv = ivs[stat];
                const percentage = (iv / 31 * 100).toFixed(1);
                
                // Update card
                const card = document.getElementById(`iv${stat.charAt(0).toUpperCase() + stat.slice(1)}`);
                card.querySelector('.iv-value').textContent = iv;
                card.querySelector('.iv-percentage').textContent = percentage + '%';
                
                // Update card styling
                card.className = 'iv-card';
                if (iv === 31) card.classList.add('perfect');
                else if (iv >= 26) card.classList.add('good');
                else if (iv <= 15) card.classList.add('poor');
                
                // Update bar
                document.getElementById(`ivBar${stat.charAt(0).toUpperCase() + stat.slice(1)}`).style.width = percentage + '%';
                document.getElementById(`ivValue${stat.charAt(0).toUpperCase() + stat.slice(1)}`).textContent = iv;
            });
        }

        function updatePotentialRating(ivs) {
            const totalIV = Object.values(ivs).reduce((sum, iv) => sum + iv, 0);
            const percentage = (totalIV / 186 * 100).toFixed(1);
            const perfectIVs = Object.values(ivs).filter(iv => iv === 31).length;
            
            // Determine rating
            let rating = 'F';
            let ratingText = 'Poor';
            
            if (totalIV >= 150) {
                rating = 'A+';
                ratingText = 'Excellent';
            } else if (totalIV >= 130) {
                rating = 'A';
                ratingText = 'Very Good';
            } else if (totalIV >= 110) {
                rating = 'B+';
                ratingText = 'Good';
            } else if (totalIV >= 90) {
                rating = 'B';
                ratingText = 'Above Average';
            } else if (totalIV >= 70) {
                rating = 'C+';
                ratingText = 'Average';
            } else if (totalIV >= 50) {
                rating = 'C';
                ratingText = 'Below Average';
            } else if (totalIV >= 30) {
                rating = 'D';
                ratingText = 'Poor';
            }
            
            // Update display
            document.getElementById('totalIV').textContent = totalIV;
            document.getElementById('ivPercentage').textContent = percentage + '%';
            document.getElementById('perfectIVs').textContent = perfectIVs;
            document.getElementById('rating').textContent = rating;
        }

        function updateBreedingTips(ivs) {
            const tips = [];
            const perfectIVs = Object.values(ivs).filter(iv => iv === 31).length;
            const totalIV = Object.values(ivs).reduce((sum, iv) => sum + iv, 0);
            
            if (perfectIVs >= 4) {
                tips.push({
                    title: 'Excellent Breeding Candidate',
                    text: 'This Pokémon has multiple perfect IVs. Use it as a parent with Destiny Knot to breed competitive offspring.'
                });
            } else if (perfectIVs >= 2) {
                tips.push({
                    title: 'Good Breeding Potential',
                    text: 'Use this Pokémon in breeding chains. Pair with better IV parents to improve offspring quality.'
                });
            } else {
                tips.push({
                    title: 'Needs Improvement',
                    text: 'Consider catching or breeding for better IVs before using this Pokémon for competitive breeding.'
                });
            }
            
            if (ivs.hp === 31) {
                tips.push({
                    title: 'Perfect HP IV',
                    text: 'Excellent for defensive Pokémon. HP is crucial for overall bulk and survivability.'
                });
            }
            
            if (ivs.atk === 31 || ivs.spa === 31) {
                tips.push({
                    title: 'Perfect Attack IV',
                    text: 'Great for offensive Pokémon. Ensure you breed the correct attacking stat for your intended moveset.'
                });
            }
            
            if (ivs.spe === 31) {
                tips.push({
                    title: 'Perfect Speed IV',
                    text: 'Essential for fast sweepers. Speed ties can determine battle outcomes in competitive play.'
                });
            }
            
            // Update breeding tips display
            const breedingTips = document.getElementById('breedingTips');
            breedingTips.innerHTML = tips.map(tip => `
                <div class="breeding-tip">
                    <h4>${tip.title}</h4>
                    <p>${tip.text}</p>
                </div>
            `).join('');
        }

        function resetCalculator() {
            // Reset to first Pokémon
            const firstPokemon = pokemonGrid.querySelector('.pokemon-item');
            if (firstPokemon) {
                firstPokemon.click();
            }
            
            // Reset level and EVs
            document.getElementById('pokemonLevel').value = 5;
            document.getElementById('evHP').value = 0;
            document.getElementById('evAtk').value = 0;
            document.getElementById('evDef').value = 0;
            
            // Reset to Hardy nature
            const hardyNature = natureGrid.querySelector('.nature-item');
            if (hardyNature) {
                hardyNature.click();
            }
            
            calculateIVs();
        }

        function setPerfectIVs() {
            // Set all current stats to what they would be with perfect IVs
            const level = parseInt(document.getElementById('pokemonLevel').value);
            const baseStats = {
                hp: parseInt(document.getElementById('baseHP').value),
                atk: parseInt(document.getElementById('baseAtk').value),
                def: parseInt(document.getElementById('baseDef').value),
                spa: parseInt(document.getElementById('baseSpA').value),
                spd: parseInt(document.getElementById('baseSpD').value),
                spe: parseInt(document.getElementById('baseSpe').value)
            };
            
            const evs = {
                hp: parseInt(document.getElementById('evHP').value),
                atk: parseInt(document.getElementById('evAtk').value),
                def: parseInt(document.getElementById('evDef').value)
            };
            
            // Calculate perfect stats
            document.getElementById('currentHP').value = calculatePerfectStat('hp', baseStats.hp, level, evs.hp);
            document.getElementById('currentAtk').value = calculatePerfectStat('atk', baseStats.atk, level, evs.atk);
            document.getElementById('currentDef').value = calculatePerfectStat('def', baseStats.def, level, evs.def);
            document.getElementById('currentSpA').value = calculatePerfectStat('spa', baseStats.spa, level, 0);
            document.getElementById('currentSpD').value = calculatePerfectStat('spd', baseStats.spd, level, 0);
            document.getElementById('currentSpe').value = calculatePerfectStat('spe', baseStats.spe, level, 0);
            
            calculateIVs();
        }

        function calculatePerfectStat(stat, base, level, ev) {
            const iv = 31; // Perfect IV
            
            if (stat === 'hp') {
                return Math.floor(0.01 * (2 * base + iv + Math.floor(ev / 4)) * level) + level + 10;
            } else {
                let statValue = Math.floor(0.01 * (2 * base + iv + Math.floor(ev / 4)) * level) + 5;
                
                // Apply nature modifier
                const activeNature = document.querySelector('.nature-item.active');
                if (activeNature) {
                    const natureName = activeNature.textContent;
                    const nature = natures.find(n => n.name === natureName);
                    
                    if (nature && nature.plus === stat) {
                        statValue = Math.floor(statValue * 1.1);
                    } else if (nature && nature.minus === stat) {
                        statValue = Math.floor(statValue * 0.9);
                    }
                }
                
                return statValue;
            }
        }

        // Initialize calculation
        calculateIVs();
    </script>
</body>
</html>
