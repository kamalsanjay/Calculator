<?php
/**
 * D&D Dice Roller
 * File: gaming/dnd-dice-roller.php
 * Description: Advanced Dungeons & Dragons dice roller with character sheets, modifiers, and campaign tracking
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D&D Dice Roller - Advanced Tabletop Gaming Assistant</title>
    <meta name="description" content="Roll D&D dice with modifiers, track character stats, manage campaigns, and simulate combat encounters with advanced tabletop gaming tools.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #8B4513 0%, #2F4F4F 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .roller-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .tab-navigation { display: flex; gap: 10px; margin-bottom: 25px; flex-wrap: wrap; }
        .tab-btn { 
            padding: 12px 24px; 
            background: #f8f9fa; 
            border: 2px solid #e0e0e0; 
            border-radius: 8px; 
            cursor: pointer; 
            transition: all 0.3s;
            font-weight: 600;
            color: #2c3e50;
        }
        .tab-btn.active { 
            background: linear-gradient(135deg, #8B4513 0%, #2F4F4F 100%); 
            color: white; 
            border-color: #8B4513;
        }
        .tab-btn:hover:not(.active) {
            border-color: #8B4513;
            transform: translateY(-2px);
        }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; background: white; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #8B4513; box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1); }
        
        .input-with-unit { position: relative; }
        .input-with-unit input { padding-right: 60px; }
        .unit-display { 
            position: absolute; 
            right: 16px; 
            top: 50%; 
            transform: translateY(-50%); 
            color: #7f8c8d; 
            font-weight: 600;
        }
        
        .dice-selector { display: grid; grid-template-columns: repeat(auto-fit, minmax(80px, 1fr)); gap: 10px; margin-bottom: 20px; }
        .dice-btn { 
            padding: 15px; 
            background: #f8f9fa; 
            border: 2px solid #e0e0e0; 
            border-radius: 10px; 
            cursor: pointer; 
            transition: all 0.3s;
            text-align: center;
            font-weight: 600;
        }
        .dice-btn:hover {
            border-color: #8B4513;
            transform: translateY(-2px);
        }
        .dice-btn.active {
            background: #8B4513;
            color: white;
            border-color: #8B4513;
        }
        
        .modifier-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .checkbox-group input { width: auto; }
        
        .character-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 20px; }
        .stat-card { 
            background: #f8f9fa; 
            padding: 15px; 
            border-radius: 8px; 
            border-left: 4px solid #8B4513;
            text-align: center;
        }
        .stat-name { font-weight: bold; color: #2c3e50; margin-bottom: 5px; font-size: 0.9rem; }
        .stat-value { font-size: 1.5rem; font-weight: bold; color: #8B4513; }
        .stat-modifier { font-size: 0.85rem; color: #7f8c8d; }
        
        .action-buttons { display: flex; gap: 15px; margin-top: 25px; flex-wrap: wrap; }
        .btn { padding: 14px 24px; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; font-weight: 600; }
        .btn-primary { background: linear-gradient(135deg, #8B4513 0%, #2F4F4F 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3); }
        .btn-secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .btn-secondary:hover { background: #e9ecef; }
        
        .quick-roll { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-roll h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #8B4513; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(139, 69, 19, 0.15); }
        .quick-value { font-weight: bold; color: #8B4513; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .results-section { margin-top: 30px; }
        
        .roll-summary { 
            background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%); 
            padding: 30px; 
            border-radius: 15px; 
            margin-bottom: 25px;
            text-align: center;
            color: #2c3e50;
        }
        .summary-title { 
            font-size: 1.4rem; 
            font-weight: bold; 
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .roll-total { 
            font-size: 4rem; 
            font-weight: bold; 
            margin-bottom: 10px;
            line-height: 1;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .roll-label { 
            font-size: 1.1rem; 
            font-weight: 600;
            margin-bottom: 15px;
        }
        .roll-details { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-top: 20px;
        }
        .detail-item { 
            background: rgba(255,255,255,0.9); 
            padding: 15px; 
            border-radius: 10px; 
        }
        .detail-value { 
            font-size: 1.3rem; 
            font-weight: bold; 
            color: #8B4513; 
            margin-bottom: 5px;
        }
        .detail-label { 
            font-size: 0.9rem; 
            color: #7f8c8d; 
        }
        
        .dice-results { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px;
        }
        .results-card { 
            background: white; 
            padding: 25px; 
            border-radius: 12px; 
            border-left: 4px solid #8B4513;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        .results-title { 
            font-size: 1.1rem; 
            font-weight: bold; 
            color: #2c3e50; 
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dice-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(60px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }
        .dice-face { 
            width: 50px; 
            height: 50px; 
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); 
            border: 2px solid #8B4513; 
            border-radius: 8px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 1.2rem; 
            font-weight: bold; 
            color: #2c3e50;
            margin: 0 auto;
        }
        .dice-face.critical {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            animation: pulse 0.5s ease-in-out;
        }
        .dice-face.fumble {
            background: linear-gradient(135deg, #2F4F4F 0%, #1e3a3a 100%);
            color: white;
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .roll-history {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            margin-top: 25px;
        }
        .history-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .history-list { 
            max-height: 400px; 
            overflow-y: auto; 
            border: 1px solid #e0e0e0; 
            border-radius: 8px; 
            padding: 15px;
            background: white;
        }
        .history-item { 
            padding: 12px 15px; 
            border-bottom: 1px solid #f8f9fa; 
            display: flex; 
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s;
        }
        .history-item:hover { background: #f8f9fa; }
        .history-item:last-child { border-bottom: none; }
        .history-roll { font-weight: 600; color: #2c3e50; }
        .history-details { font-size: 0.85rem; color: #7f8c8d; }
        .history-total { font-weight: bold; color: #8B4513; font-size: 1.1rem; }
        
        .combat-tracker {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-top: 25px;
        }
        .combat-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .initiative-list {
            list-style: none;
        }
        .initiative-item {
            padding: 15px;
            border-bottom: 1px solid #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s;
        }
        .initiative-item.active {
            background: #fffaf0;
            border-left: 4px solid #d4af37;
        }
        .initiative-item:hover {
            background: #f8f9fa;
        }
        .character-name {
            font-weight: 600;
            color: #2c3e50;
        }
        .initiative-score {
            font-weight: bold;
            color: #8B4513;
            font-size: 1.1rem;
        }
        .character-type {
            font-size: 0.85rem;
            color: #7f8c8d;
        }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .dice-types { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin: 20px 0; }
        .dice-card { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #8B4513; }
        .dice-name { font-weight: bold; color: #2c3e50; margin-bottom: 5px; display: flex; align-items: center; gap: 8px; }
        .dice-desc { font-size: 0.85rem; color: #7f8c8d; }
        
        .formula-box { background: #fffaf0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #8B4513; }
        .formula-box strong { color: #8B4513; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #fffaf0; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .tab-navigation { flex-direction: column; }
            .action-buttons { flex-direction: column; }
            .dice-results { grid-template-columns: 1fr; }
            .roll-details { grid-template-columns: 1fr; }
            .dice-selector { grid-template-columns: repeat(4, 1fr); }
            .character-stats { grid-template-columns: repeat(2, 1fr); }
            .roll-total { font-size: 3rem; }
            .header h1 { font-size: 1.5rem; }
        }
        
        @media (max-width: 480px) {
            .roller-card { padding: 20px; }
            .header { padding: 20px; }
            .roll-summary { padding: 20px; }
            .results-card { padding: 20px; }
            .dice-selector { grid-template-columns: repeat(3, 1fr); }
            .dice-grid { grid-template-columns: repeat(4, 1fr); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎲 D&D Dice Roller</h1>
            <p>Roll D&D dice with modifiers, track character stats, manage campaigns, and simulate combat encounters with advanced tabletop gaming tools</p>
        </div>

        <div class="roller-card">
            <div class="tab-navigation">
                <button class="tab-btn active" onclick="switchTab('basic')">🎲 Basic Roll</button>
                <button class="tab-btn" onclick="switchTab('character')">⚔️ Character</button>
                <button class="tab-btn" onclick="switchTab('combat')">🛡️ Combat</button>
                <button class="tab-btn" onclick="switchTab('results')">📊 Results</button>
            </div>

            <!-- Basic Roll Tab -->
            <div class="tab-content active" id="basic-tab">
                <h3>🎲 Dice Selection & Modifiers</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label>Dice Type</label>
                        <div class="dice-selector">
                            <div class="dice-btn active" data-dice="4">d4</div>
                            <div class="dice-btn" data-dice="6">d6</div>
                            <div class="dice-btn" data-dice="8">d8</div>
                            <div class="dice-btn" data-dice="10">d10</div>
                            <div class="dice-btn" data-dice="12">d12</div>
                            <div class="dice-btn" data-dice="20">d20</div>
                            <div class="dice-btn" data-dice="100">d100</div>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="diceCount">Number of Dice</label>
                        <div class="input-with-unit">
                            <input type="number" id="diceCount" min="1" max="20" value="1">
                            <span class="unit-display">dice</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="modifier">Modifier</label>
                        <div class="input-with-unit">
                            <input type="number" id="modifier" value="0" step="1">
                            <span class="unit-display">+/-</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label>Roll Options</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="advantage">
                            <label for="advantage">Advantage (roll twice, take higher)</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="disadvantage">
                            <label for="disadvantage">Disadvantage (roll twice, take lower)</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="critical">
                            <label for="critical">Critical Hit (double dice)</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Character Tab -->
            <div class="tab-content" id="character-tab">
                <h3>⚔️ Character Stats & Abilities</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="characterClass">Character Class</label>
                        <select id="characterClass" class="control-select">
                            <option value="fighter">Fighter</option>
                            <option value="wizard">Wizard</option>
                            <option value="rogue">Rogue</option>
                            <option value="cleric">Cleric</option>
                            <option value="ranger">Ranger</option>
                            <option value="bard">Bard</option>
                            <option value="paladin">Paladin</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="characterLevel">Character Level</label>
                        <div class="input-with-unit">
                            <input type="number" id="characterLevel" min="1" max="20" value="1">
                            <span class="unit-display">level</span>
                        </div>
                    </div>
                    
                    <div class="character-stats">
                        <div class="stat-card">
                            <div class="stat-name">Strength</div>
                            <div class="stat-value" id="strScore">10</div>
                            <div class="stat-modifier" id="strMod">+0</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-name">Dexterity</div>
                            <div class="stat-value" id="dexScore">10</div>
                            <div class="stat-modifier" id="dexMod">+0</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-name">Constitution</div>
                            <div class="stat-value" id="conScore">10</div>
                            <div class="stat-modifier" id="conMod">+0</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-name">Intelligence</div>
                            <div class="stat-value" id="intScore">10</div>
                            <div class="stat-modifier" id="intMod">+0</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-name">Wisdom</div>
                            <div class="stat-value" id="wisScore">10</div>
                            <div class="stat-modifier" id="wisMod">+0</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-name">Charisma</div>
                            <div class="stat-value" id="chaScore">10</div>
                            <div class="stat-modifier" id="chaMod">+0</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Combat Tab -->
            <div class="tab-content" id="combat-tab">
                <h3>🛡️ Combat & Initiative</h3>
                <div class="control-panel">
                    <div class="control-group">
                        <label for="enemyCount">Number of Enemies</label>
                        <div class="input-with-unit">
                            <input type="number" id="enemyCount" min="1" max="10" value="3">
                            <span class="unit-display">enemies</span>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="enemyType">Enemy Type</label>
                        <select id="enemyType" class="control-select">
                            <option value="goblin">Goblin</option>
                            <option value="orc">Orc</option>
                            <option value="dragon">Dragon</option>
                            <option value="undead">Undead</option>
                            <option value="beast">Beast</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label>Combat Actions</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="surpriseRound">
                            <label for="surpriseRound">Surprise Round</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="flanking">
                            <label for="flanking">Flanking Advantage</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="cover">
                            <label for="cover">Half/Three-Quarters Cover</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Tab -->
            <div class="tab-content" id="results-tab">
                <h3>📊 Roll Results & History</h3>
                <div class="results-section">
                    <div class="roll-summary">
                        <div class="summary-title">🎯 Roll Results</div>
                        <div class="roll-total" id="rollTotal">0</div>
                        <div class="roll-label" id="rollDescription">Standard roll</div>
                        
                        <div class="roll-details">
                            <div class="detail-item">
                                <div class="detail-value" id="diceUsed">d20</div>
                                <div class="detail-label">Dice Type</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-value" id="modifierUsed">+0</div>
                                <div class="detail-label">Modifier</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-value" id="rollType">Normal</div>
                                <div class="detail-label">Roll Type</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-value" id="successCheck">-</div>
                                <div class="detail-label">Success Check</div>
                            </div>
                        </div>
                    </div>

                    <div class="dice-results">
                        <div class="results-card">
                            <div class="results-title">🎲 Individual Dice</div>
                            <div class="dice-grid" id="diceResults">
                                <!-- Dice faces will appear here -->
                            </div>
                        </div>
                        
                        <div class="results-card">
                            <div class="results-title">📈 Roll Analysis</div>
                            <div class="results-list" id="rollAnalysis">
                                <!-- Roll analysis will appear here -->
                            </div>
                        </div>
                    </div>

                    <div class="combat-tracker">
                        <div class="combat-title">⚔️ Initiative Order</div>
                        <div class="initiative-list" id="initiativeList">
                            <!-- Initiative order will appear here -->
                        </div>
                    </div>

                    <div class="roll-history">
                        <div class="history-title">📜 Roll History</div>
                        <div class="history-list" id="historyList">
                            <!-- History items will appear here -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="quick-roll">
                <h3>⚡ Common Rolls</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="quickRoll('attack')">
                        <div class="quick-value">Attack Roll</div>
                        <div class="quick-label">d20 + modifier</div>
                    </div>
                    <div class="quick-btn" onclick="quickRoll('ability')">
                        <div class="quick-value">Ability Check</div>
                        <div class="quick-label">d20 + ability</div>
                    </div>
                    <div class="quick-btn" onclick="quickRoll('saving')">
                        <div class="quick-value">Saving Throw</div>
                        <div class="quick-label">d20 + save</div>
                    </div>
                    <div class="quick-btn" onclick="quickRoll('damage')">
                        <div class="quick-value">Damage Roll</div>
                        <div class="quick-label">Weapon dice</div>
                    </div>
                    <div class="quick-btn" onclick="quickRoll('initiative')">
                        <div class="quick-value">Initiative</div>
                        <div class="quick-label">d20 + dex</div>
                    </div>
                    <div class="quick-btn" onclick="quickRoll('healing')">
                        <div class="quick-value">Healing</div>
                        <div class="quick-label">Spell dice</div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button class="btn btn-primary" onclick="rollDice()">🎲 Roll Dice</button>
                <button class="btn btn-secondary" onclick="clearRolls()">🗑️ Clear</button>
                <button class="btn btn-secondary" onclick="rollInitiative()">⚔️ Initiative</button>
                <button class="btn btn-secondary" onclick="saveSession()">💾 Save</button>
            </div>
        </div>

        <div class="info-section">
            <h2>🎲 Dungeons & Dragons Dice Rolling</h2>
            
            <p>Comprehensive D&D dice roller with advanced features for tabletop gaming, including character stat tracking, combat simulation, and campaign management tools.</p>

            <h3>🎯 D&D Dice Types</h3>
            <div class="dice-types">
                <div class="dice-card">
                    <div class="dice-name">🎲 d4 (Four-sided)</div>
                    <div class="dice-desc">Used for small weapon damage, healing spells, and minor effects. Pyramid-shaped with triangular faces.</div>
                </div>
                <div class="dice-card">
                    <div class="dice-name">🎲 d6 (Six-sided)</div>
                    <div class="dice-desc">Standard cube die. Used for medium weapon damage, skill checks, and many spell effects.</div>
                </div>
                <div class="dice-card">
                    <div class="dice-name">🎲 d8 (Eight-sided)</div>
                    <div class="dice-desc">Used for larger weapon damage, hit dice for some classes, and moderate spell effects.</div>
                </div>
                <div class="dice-card">
                    <div class="dice-name">🎲 d10 (Ten-sided)</div>
                    <div class="dice-desc">Used for heavy weapon damage, percentile rolls (with d100), and powerful spell effects.</div>
                </div>
                <div class="dice-card">
                    <div class="dice-name">🎲 d12 (Twelve-sided)</div>
                    <div class="dice-desc">Used for the largest weapons, barbarian hit dice, and massive damage effects.</div>
                </div>
                <div class="dice-card">
                    <div class="dice-name">🎲 d20 (Twenty-sided)</div>
                    <div class="dice-desc">The most important die in D&D. Used for attack rolls, ability checks, and saving throws.</div>
                </div>
            </div>

            <h3>📊 Core Game Mechanics</h3>
            <div class="formula-box">
                <strong>Basic Roll Formulas:</strong><br>
                • <strong>Attack Roll:</strong> d20 + Ability Modifier + Proficiency Bonus<br>
                • <strong>Damage Roll:</strong> Weapon Dice + Ability Modifier<br>
                • <strong>Ability Check:</strong> d20 + Ability Modifier + Proficiency (if applicable)<br>
                • <strong>Saving Throw:</strong> d20 + Ability Modifier + Proficiency (if proficient)<br>
                • <strong>Initiative:</strong> d20 + Dexterity Modifier<br>
                • <strong>Skill Check:</strong> d20 + Ability Modifier + Proficiency Bonus
            </div>

            <h3>⚔️ Combat Rules</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Combat Action</th>
                        <th>Dice Required</th>
                        <th>Typical Modifiers</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Melee Attack</td><td>d20 + damage dice</td><td>Strength + Proficiency</td></tr>
                    <tr><td>Ranged Attack</td><td>d20 + damage dice</td><td>Dexterity + Proficiency</td></tr>
                    <tr><td>Spell Attack</td><td>d20 + damage dice</td><td>Spellcasting + Proficiency</td></tr>
                    <tr><td>Saving Throw</td><td>d20</td><td>Ability + Proficiency</td></tr>
                    <tr><td>Healing Spell</td><td>Healing dice</td><td>Caster level bonus</td></tr>
                    <tr><td>Critical Hit</td><td>Double damage dice</td><td>Normal modifiers</td></tr>
                </tbody>
            </table>

            <h3>📈 Ability Score Modifiers</h3>
            <div class="probability-grid">
                <div class="probability-item">
                    <div class="prob-value">1</div>
                    <div class="prob-label">-5 modifier</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">10-11</div>
                    <div class="prob-label">+0 modifier</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">12-13</div>
                    <div class="prob-label">+1 modifier</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">14-15</div>
                    <div class="prob-label">+2 modifier</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">16-17</div>
                    <div class="prob-label">+3 modifier</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">18-19</div>
                    <div class="prob-label">+4 modifier</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">20</div>
                    <div class="prob-label">+5 modifier</div>
                </div>
            </div>

            <h3>🎯 Advantage & Disadvantage</h3>
            <ul>
                <li><strong>Advantage:</strong> Roll two d20s, take the higher result. Significantly increases success probability.</li>
                <li><strong>Disadvantage:</strong> Roll two d20s, take the lower result. Significantly decreases success probability.</li>
                <li><strong>Multiple Sources:</strong> Advantage and disadvantage cancel each other out, regardless of how many sources.</li>
                <li><strong>Critical Rules:</strong> Natural 20 always hits (attack) or succeeds (saving throw), natural 1 always fails.</li>
                <li><strong>Probability:</strong> Advantage increases critical chance from 5% to 9.75%, disadvantage reduces it to 0.25%.</li>
            </ul>

            <h3>🛡️ Character Progression</h3>
            <div class="formula-box">
                <strong>Level-Based Bonuses:</strong><br>
                • <strong>Proficiency Bonus:</strong> +2 at level 1, increases to +6 by level 20<br>
                • <strong>Ability Score Improvements:</strong> +2 to ability scores at levels 4, 8, 12, 16, 19<br>
                • <strong>Hit Points:</strong> Class hit die + Constitution modifier per level<br>
                • <strong>Spell Slots:</strong> Increase with caster level and class features<br>
                • <strong>Class Features:</strong> Unique abilities gained at specific levels<br>
                • <strong>Feats:</strong> Optional special abilities that can replace ability score improvements
            </div>

            <h3>🎲 Probability & Statistics</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Target Number</th>
                        <th>Standard Roll</th>
                        <th>With Advantage</th>
                        <th>With Disadvantage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>5</td><td>80%</td><td>96%</td><td>64%</td></tr>
                    <tr><td>10</td><td>55%</td><td>80%</td><td>30%</td></tr>
                    <tr><td>15</td><td>30%</td><td>51%</td><td>9%</td></tr>
                    <tr><td>20</td><td>5%</td><td>10%</td><td>0.25%</td></tr>
                    <tr><td>Natural 20</td><td>5%</td><td>9.75%</td><td>0.25%</td></tr>
                    <tr><td>Natural 1</td><td>5%</td><td>0.25%</td><td>9.75%</td></tr>
                </tbody>
            </table>

            <h3>🏹 Common House Rules</h3>
            <ul>
                <li><strong>Critical Hits:</strong> Max damage + rolled damage instead of double dice</li>
                <li><strong>Death Saves:</strong> Natural 20 instantly stabilizes and regains 1 HP</li>
                <li><strong>Skill Checks:</strong> Natural 20 isn't automatic success, natural 1 isn't automatic failure</li>
                <li><strong>Inspiration:</strong> Can be used after seeing the roll result</li>
                <li><strong>Flanking:</strong> Provides +2 bonus instead of advantage to avoid stacking</li>
                <li><strong>Spell Points:</strong> Alternative to spell slots for more flexible casting</li>
            </ul>
        </div>

        <div class="footer">
            <p>🎲 D&D Dice Roller | Advanced Tabletop Gaming Assistant</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for Dungeon Masters and players seeking comprehensive dice rolling and campaign management tools</p>
        </div>
    </div>

    <script>
        let rollHistory = [];
        let currentCharacter = {
            class: 'fighter',
            level: 1,
            stats: {
                str: 10, dex: 10, con: 10, int: 10, wis: 10, cha: 10
            }
        };
        
        // Initialize dice selector
        document.querySelectorAll('.dice-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.dice-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Update character stats when class changes
        document.getElementById('characterClass').addEventListener('change', function() {
            updateCharacterStats(this.value);
        });
        
        document.getElementById('characterLevel').addEventListener('input', function() {
            updateCharacterStats(document.getElementById('characterClass').value);
        });

        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Activate selected button
            event.target.classList.add('active');
        }

        function updateCharacterStats(characterClass) {
            const level = parseInt(document.getElementById('characterLevel').value) || 1;
            const baseStats = {
                'fighter': { str: 16, dex: 14, con: 15, int: 10, wis: 12, cha: 8 },
                'wizard': { str: 8, dex: 14, con: 13, int: 16, wis: 12, cha: 10 },
                'rogue': { str: 12, dex: 16, con: 14, int: 10, wis: 12, cha: 14 },
                'cleric': { str: 14, dex: 10, con: 15, int: 10, wis: 16, cha: 12 },
                'ranger': { str: 14, dex: 16, con: 14, int: 10, wis: 14, cha: 10 },
                'bard': { str: 10, dex: 14, con: 13, int: 12, wis: 10, cha: 16 },
                'paladin': { str: 16, dex: 10, con: 15, int: 8, wis: 12, cha: 14 },
                'custom': { str: 10, dex: 10, con: 10, int: 10, wis: 10, cha: 10 }
            };
            
            const stats = baseStats[characterClass];
            const abilityImprovements = Math.floor((level - 1) / 4);
            
            // Apply ability score improvements
            Object.keys(stats).forEach(stat => {
                stats[stat] += abilityImprovements;
                updateStatDisplay(stat, stats[stat]);
            });
            
            currentCharacter.stats = stats;
            currentCharacter.class = characterClass;
            currentCharacter.level = level;
        }
        
        function updateStatDisplay(stat, value) {
            const modifier = Math.floor((value - 10) / 2);
            const modifierDisplay = modifier >= 0 ? `+${modifier}` : `${modifier}`;
            
            document.getElementById(stat + 'Score').textContent = value;
            document.getElementById(stat + 'Mod').textContent = modifierDisplay;
        }

        function rollDice() {
            const selectedDice = document.querySelector('.dice-btn.active').dataset.dice;
            const diceCount = parseInt(document.getElementById('diceCount').value) || 1;
            const modifier = parseInt(document.getElementById('modifier').value) || 0;
            const advantage = document.getElementById('advantage').checked;
            const disadvantage = document.getElementById('disadvantage').checked;
            const critical = document.getElementById('critical').checked;
            
            let rolls = [];
            let total = 0;
            let rollType = 'Normal';
            
            // Handle advantage/disadvantage
            if (advantage && !disadvantage) {
                rollType = 'Advantage';
                const roll1 = rollSingleDie(selectedDice, diceCount, critical);
                const roll2 = rollSingleDie(selectedDice, diceCount, critical);
                rolls = roll1.total > roll2.total ? roll1.rolls : roll2.rolls;
                total = Math.max(roll1.total, roll2.total) + modifier;
            } else if (disadvantage && !advantage) {
                rollType = 'Disadvantage';
                const roll1 = rollSingleDie(selectedDice, diceCount, critical);
                const roll2 = rollSingleDie(selectedDice, diceCount, critical);
                rolls = roll1.total < roll2.total ? roll1.rolls : roll2.rolls;
                total = Math.min(roll1.total, roll2.total) + modifier;
            } else {
                const result = rollSingleDie(selectedDice, diceCount, critical);
                rolls = result.rolls;
                total = result.total + modifier;
                if (critical) rollType = 'Critical Hit';
            }
            
            // Check for natural 20 or 1 on d20 rolls
            let successCheck = '-';
            if (selectedDice === '20' && diceCount === 1) {
                if (rolls[0] === 20) {
                    successCheck = 'Natural 20!';
                    rollType = 'Critical Success';
                } else if (rolls[0] === 1) {
                    successCheck = 'Natural 1!';
                    rollType = 'Critical Failure';
                }
            }
            
            // Update display
            updateRollDisplay(selectedDice, diceCount, modifier, total, rolls, rollType, successCheck);
            
            // Add to history
            addToHistory(selectedDice, diceCount, modifier, total, rollType);
            
            // Switch to results tab
            switchTab('results');
        }
        
        function rollSingleDie(dieType, count, critical) {
            const sides = parseInt(dieType);
            const actualCount = critical && dieType !== '100' ? count * 2 : count;
            let rolls = [];
            let total = 0;
            
            for (let i = 0; i < actualCount; i++) {
                const roll = Math.floor(Math.random() * sides) + 1;
                rolls.push(roll);
                total += roll;
            }
            
            return { rolls, total };
        }
        
        function updateRollDisplay(dieType, count, modifier, total, rolls, rollType, successCheck) {
            // Update summary
            document.getElementById('rollTotal').textContent = total;
            document.getElementById('rollDescription').textContent = `${count}d${dieType} ${modifier >= 0 ? '+' : ''}${modifier}`;
            
            document.getElementById('diceUsed').textContent = `${count}d${dieType}`;
            document.getElementById('modifierUsed').textContent = modifier >= 0 ? `+${modifier}` : `${modifier}`;
            document.getElementById('rollType').textContent = rollType;
            document.getElementById('successCheck').textContent = successCheck;
            
            // Update dice results
            const diceContainer = document.getElementById('diceResults');
            diceContainer.innerHTML = '';
            
            rolls.forEach((roll, index) => {
                const diceFace = document.createElement('div');
                diceFace.className = 'dice-face';
                if (roll === 20 && dieType === '20') diceFace.classList.add('critical');
                if (roll === 1 && dieType === '20') diceFace.classList.add('fumble');
                diceFace.textContent = roll;
                diceContainer.appendChild(diceFace);
            });
            
            // Update roll analysis
            updateRollAnalysis(rolls, total, modifier, dieType);
        }
        
        function updateRollAnalysis(rolls, total, modifier, dieType) {
            const analysisContainer = document.getElementById('rollAnalysis');
            analysisContainer.innerHTML = '';
            
            const analysisItems = [
                { label: 'Total Rolls', value: rolls.length },
                { label: 'Average Roll', value: (rolls.reduce((a, b) => a + b, 0) / rolls.length).toFixed(1) },
                { label: 'Highest Roll', value: Math.max(...rolls) },
                { label: 'Lowest Roll', value: Math.min(...rolls) },
                { label: 'Base Total', value: total - modifier },
                { label: 'Modifier Applied', value: modifier }
            ];
            
            analysisItems.forEach(item => {
                const div = document.createElement('div');
                div.className = 'nutrition-item';
                div.innerHTML = `
                    <span class="nutrient-name">${item.label}</span>
                    <span class="nutrient-amount">${item.value}</span>
                `;
                analysisContainer.appendChild(div);
            });
        }
        
        function rollInitiative() {
            const enemyCount = parseInt(document.getElementById('enemyCount').value) || 3;
            const enemyType = document.getElementById('enemyType').value;
            const initiativeList = document.getElementById('initiativeList');
            initiativeList.innerHTML = '';
            
            // Player initiative
            const playerInitiative = Math.floor(Math.random() * 20) + 1 + getAbilityModifier('dex');
            addInitiativeItem('Player Character', playerInitiative, 'player', true);
            
            // Enemy initiatives
            const enemyNames = {
                'goblin': 'Goblin',
                'orc': 'Orc Warrior',
                'dragon': 'Young Dragon',
                'undead': 'Skeleton',
                'beast': 'Wolf',
                'custom': 'Custom Enemy'
            };
            
            for (let i = 1; i <= enemyCount; i++) {
                const enemyInitiative = Math.floor(Math.random() * 20) + 1 + 
                    (enemyType === 'goblin' ? 2 : enemyType === 'orc' ? 0 : enemyType === 'dragon' ? 4 : 1);
                addInitiativeItem(`${enemyNames[enemyType]} ${i}`, enemyInitiative, 'enemy', false);
            }
            
            // Sort initiative list
            sortInitiativeList();
        }
        
        function addInitiativeItem(name, score, type, isPlayer) {
            const initiativeList = document.getElementById('initiativeList');
            const item = document.createElement('div');
            item.className = 'initiative-item';
            item.innerHTML = `
                <div>
                    <div class="character-name">${name}</div>
                    <div class="character-type">${isPlayer ? 'Player' : 'Enemy'}</div>
                </div>
                <div class="initiative-score">${score}</div>
            `;
            initiativeList.appendChild(item);
        }
        
        function sortInitiativeList() {
            const container = document.getElementById('initiativeList');
            const items = Array.from(container.children);
            
            items.sort((a, b) => {
                const scoreA = parseInt(a.querySelector('.initiative-score').textContent);
                const scoreB = parseInt(b.querySelector('.initiative-score').textContent);
                return scoreB - scoreA; // Descending order
            });
            
            // Clear and re-add sorted items
            container.innerHTML = '';
            items.forEach((item, index) => {
                if (index === 0) item.classList.add('active');
                container.appendChild(item);
            });
        }
        
        function getAbilityModifier(ability) {
            const score = currentCharacter.stats[ability];
            return Math.floor((score - 10) / 2);
        }
        
        function addToHistory(dieType, count, modifier, total, rollType) {
            const timestamp = new Date().toLocaleTimeString();
            const description = `${count}d${dieType} ${modifier >= 0 ? '+' : ''}${modifier} (${rollType})`;
            
            rollHistory.unshift({
                timestamp,
                description,
                total,
                type: rollType
            });
            
            // Keep only last 20 rolls
            if (rollHistory.length > 20) {
                rollHistory = rollHistory.slice(0, 20);
            }
            
            updateHistoryDisplay();
        }
        
        function updateHistoryDisplay() {
            const container = document.getElementById('historyList');
            container.innerHTML = '';
            
            rollHistory.forEach(roll => {
                const item = document.createElement('div');
                item.className = 'history-item';
                item.innerHTML = `
                    <div>
                        <div class="history-roll">${roll.description}</div>
                        <div class="history-details">${roll.timestamp}</div>
                    </div>
                    <div class="history-total">${roll.total}</div>
                `;
                container.appendChild(item);
            });
        }
        
        function quickRoll(type) {
            switch(type) {
                case 'attack':
                    document.querySelector('.dice-btn[data-dice="20"]').click();
                    document.getElementById('diceCount').value = 1;
                    document.getElementById('modifier').value = getAbilityModifier('str') + Math.min(2 + Math.floor((currentCharacter.level - 1) / 4), 6);
                    break;
                case 'ability':
                    document.querySelector('.dice-btn[data-dice="20"]').click();
                    document.getElementById('diceCount').value = 1;
                    document.getElementById('modifier').value = getAbilityModifier('str');
                    break;
                case 'saving':
                    document.querySelector('.dice-btn[data-dice="20"]').click();
                    document.getElementById('diceCount').value = 1;
                    document.getElementById('modifier').value = getAbilityModifier('dex') + Math.min(2 + Math.floor((currentCharacter.level - 1) / 4), 6);
                    break;
                case 'damage':
                    document.querySelector('.dice-btn[data-dice="8"]').click();
                    document.getElementById('diceCount').value = 1;
                    document.getElementById('modifier').value = getAbilityModifier('str');
                    break;
                case 'initiative':
                    document.querySelector('.dice-btn[data-dice="20"]').click();
                    document.getElementById('diceCount').value = 1;
                    document.getElementById('modifier').value = getAbilityModifier('dex');
                    rollInitiative();
                    break;
                case 'healing':
                    document.querySelector('.dice-btn[data-dice="8"]').click();
                    document.getElementById('diceCount').value = 2;
                    document.getElementById('modifier').value = 0;
                    break;
            }
            
            rollDice();
        }
        
        function clearRolls() {
            rollHistory = [];
            updateHistoryDisplay();
            document.getElementById('diceResults').innerHTML = '';
            document.getElementById('rollAnalysis').innerHTML = '';
            document.getElementById('initiativeList').innerHTML = '';
            document.getElementById('rollTotal').textContent = '0';
        }
        
        function saveSession() {
            const sessionData = {
                character: currentCharacter,
                history: rollHistory,
                timestamp: new Date().toLocaleString()
            };
            
            let data = 'D&D Session Data\n';
            data += 'Saved: ' + sessionData.timestamp + '\n\n';
            data += `Character: ${sessionData.character.class} Level ${sessionData.character.level}\n`;
            data += `Roll History: ${sessionData.history.length} rolls\n\n`;
            
            sessionData.history.forEach(roll => {
                data += `${roll.timestamp}: ${roll.description} = ${roll.total}\n`;
            });
            
            const blob = new Blob([data], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'dnd-session.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        // Initialize calculator
        window.onload = function() {
            updateCharacterStats('fighter');
            updateHistoryDisplay();
        };
    </script>
</body>
</html>
