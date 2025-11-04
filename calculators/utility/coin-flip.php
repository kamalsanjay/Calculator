<?php
/**
 * Coin Flip Simulator
 * File: utility/coin-flip.php
 * Description: Advanced coin flip simulator with statistics, multiple coins, and probability analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coin Flip Simulator - Advanced Probability Testing Tool</title>
    <meta name="description" content="Flip virtual coins with advanced statistics, multiple coins, custom probabilities, and comprehensive analysis for probability testing and decision making.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .flipper-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; background: white; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #ffd89b; box-shadow: 0 0 0 3px rgba(255, 216, 155, 0.1); }
        
        .probability-slider { margin-top: 10px; }
        .slider-value { text-align: center; font-weight: bold; color: #19547b; margin-top: 5px; }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .checkbox-group input { width: auto; }
        
        .action-buttons { display: flex; gap: 15px; margin-top: 25px; flex-wrap: wrap; }
        .btn { padding: 14px 24px; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; font-weight: 600; }
        .btn-primary { background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255, 216, 155, 0.3); }
        .btn-secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .btn-secondary:hover { background: #e9ecef; }
        .btn-danger { background: #e74c3c; color: white; }
        
        .quick-flip { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-flip h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #ffd89b; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255, 216, 155, 0.15); }
        .quick-value { font-weight: bold; color: #19547b; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .results-section { margin-top: 30px; }
        .coin-results { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 15px; margin-top: 20px; }
        .coin-face { 
            width: 80px; 
            height: 80px; 
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); 
            border: 3px solid #19547b; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 2rem; 
            font-weight: bold; 
            color: #2c3e50;
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            transition: all 0.5s ease-in-out;
            position: relative;
            overflow: hidden;
        }
        .coin-face::before {
            content: '';
            position: absolute;
            top: 10%;
            left: 10%;
            right: 10%;
            bottom: 10%;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
        }
        .coin-face.heads { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
        .coin-face.tails { background: linear-gradient(135deg, #19547b 0%, #2c3e50 100%); color: white; }
        .coin-face.flipping {
            animation: flipCoin 0.6s ease-in-out;
        }
        @keyframes flipCoin {
            0% { transform: rotateY(0deg) scale(1); }
            50% { transform: rotateY(180deg) scale(1.1); }
            100% { transform: rotateY(360deg) scale(1); }
        }
        
        .result-summary { 
            background: linear-gradient(135deg, #ffeaa7 0%, #a29bfe 100%); 
            padding: 25px; 
            border-radius: 15px; 
            margin-top: 25px; 
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .summary-title { 
            font-size: 1.3rem; 
            font-weight: bold; 
            color: #2c3e50; 
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
            gap: 20px; 
            margin-top: 15px;
        }
        .stat-card { 
            background: rgba(255,255,255,0.9); 
            padding: 20px; 
            border-radius: 12px; 
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        .stat-value { 
            font-size: 2rem; 
            font-weight: bold; 
            color: #19547b; 
            margin-bottom: 5px;
        }
        .stat-label { 
            font-size: 0.9rem; 
            color: #7f8c8d; 
            font-weight: 600;
        }
        .stat-detail {
            font-size: 0.8rem;
            color: #95a5a6;
            margin-top: 5px;
        }
        
        .probability-chart {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        .chart-bar {
            display: flex;
            align-items: center;
            margin: 15px 0;
            gap: 15px;
        }
        .chart-label {
            width: 80px;
            font-weight: 600;
            color: #2c3e50;
        }
        .chart-bar-inner {
            flex: 1;
            height: 30px;
            background: #ecf0f1;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }
        .chart-bar-fill {
            height: 100%;
            border-radius: 15px;
            transition: width 0.5s ease-in-out;
        }
        .heads-fill { background: linear-gradient(90deg, #f6d365, #fda085); }
        .tails-fill { background: linear-gradient(90deg, #19547b, #2c3e50); }
        .chart-percentage {
            width: 60px;
            text-align: right;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .history-section { margin-top: 30px; }
        .history-list { 
            max-height: 300px; 
            overflow-y: auto; 
            border: 1px solid #e0e0e0; 
            border-radius: 12px; 
            padding: 15px;
            background: #f8f9fa;
        }
        .history-item { 
            padding: 12px 15px; 
            border-bottom: 1px solid #e0e0e0; 
            display: flex; 
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s;
        }
        .history-item:hover { background: white; }
        .history-item:last-child { border-bottom: none; }
        .history-result { 
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .result-icon { 
            width: 24px; 
            height: 24px; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
        }
        .heads-icon { background: #f6d365; color: #2c3e50; }
        .tails-icon { background: #19547b; color: white; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .coin-types { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 20px 0; }
        .coin-card { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #ffd89b; }
        .coin-name { font-weight: bold; color: #2c3e50; margin-bottom: 5px; display: flex; align-items: center; gap: 8px; }
        .coin-desc { font-size: 0.85rem; color: #7f8c8d; }
        
        .probability-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; margin: 15px 0; }
        .probability-item { background: #f8f9fa; padding: 10px; border-radius: 6px; text-align: center; }
        .prob-value { font-weight: bold; color: #19547b; }
        .prob-label { font-size: 0.8rem; color: #7f8c8d; }
        
        .formula-box { background: #fffaf0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ffd89b; }
        .formula-box strong { color: #19547b; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #fffaf0; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .action-buttons { flex-direction: column; }
            .coin-results { grid-template-columns: repeat(auto-fill, minmax(70px, 1fr)); }
            .coin-face { width: 65px; height: 65px; font-size: 1.5rem; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🪙 Advanced Coin Flip Simulator</h1>
            <p>Flip virtual coins with advanced statistics, multiple coins, custom probabilities, and comprehensive analysis for probability testing</p>
        </div>

        <div class="flipper-card">
            <div class="control-panel">
                <div class="control-group">
                    <label for="coinCount">Number of Coins</label>
                    <input type="number" id="coinCount" min="1" max="50" value="1">
                </div>
                
                <div class="control-group">
                    <label for="flipCount">Flips per Click</label>
                    <input type="number" id="flipCount" min="1" max="100" value="1">
                </div>
                
                <div class="control-group">
                    <label for="probability">Heads Probability</label>
                    <input type="range" id="probability" min="0" max="100" value="50" class="probability-slider">
                    <div class="slider-value" id="probabilityValue">50%</div>
                </div>
            </div>
            
            <div class="control-panel">
                <div class="control-group">
                    <label for="coinType">Coin Type</label>
                    <select id="coinType" class="control-select">
                        <option value="fair">Fair Coin (50/50)</option>
                        <option value="us_quarter">US Quarter</option>
                        <option value="us_penny">US Penny</option>
                        <option value="euro">Euro Coin</option>
                        <option value="ancient">Ancient Roman</option>
                        <option value="custom">Custom Coin</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label>Display Options</label>
                    <div class="checkbox-group">
                        <input type="checkbox" id="showHistory" checked>
                        <label for="showHistory">Keep flip history</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="animateFlips" checked>
                        <label for="animateFlips">Animate coin flips</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="showStats">
                        <label for="showStats">Show detailed statistics</label>
                    </div>
                </div>
            </div>
            
            <div class="quick-flip">
                <h3>⚡ Quick Flips</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="quickFlip(1, 1)">
                        <div class="quick-value">1 Flip</div>
                        <div class="quick-label">Single Coin</div>
                    </div>
                    <div class="quick-btn" onclick="quickFlip(3, 1)">
                        <div class="quick-value">3 Flips</div>
                        <div class="quick-label">Best of Three</div>
                    </div>
                    <div class="quick-btn" onclick="quickFlip(1, 10)">
                        <div class="quick-value">10 Flips</div>
                        <div class="quick-label">Quick Sample</div>
                    </div>
                    <div class="quick-btn" onclick="quickFlip(5, 1)">
                        <div class="quick-value">5 Coins</div>
                        <div class="quick-label">Multiple Coins</div>
                    </div>
                    <div class="quick-btn" onclick="quickFlip(1, 100)">
                        <div class="quick-value">100 Flips</div>
                        <div class="quick-label">Large Sample</div>
                    </div>
                    <div class="quick-btn" onclick="setBiasedCoin()">
                        <div class="quick-value">70/30</div>
                        <div class="quick-label">Biased Coin</div>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="flipCoins()">🪙 Flip Coins</button>
                <button class="btn btn-secondary" onclick="clearResults()">🗑️ Clear Results</button>
                <button class="btn btn-secondary" onclick="saveResults()">💾 Save Data</button>
                <button class="btn btn-danger" onclick="clearHistory()">📊 Clear History</button>
            </div>
            
            <div class="results-section">
                <h3>🎯 Flip Results</h3>
                <div class="coin-results" id="coinResults">
                    <!-- Coin faces will appear here -->
                </div>
                
                <div class="result-summary" id="resultSummary" style="display: none;">
                    <div class="summary-title">📊 Flip Statistics</div>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-value" id="totalFlips">0</div>
                            <div class="stat-label">Total Flips</div>
                            <div class="stat-detail" id="flipDetail">0 heads, 0 tails</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="headsCount">0%</div>
                            <div class="stat-label">Heads Rate</div>
                            <div class="stat-detail" id="headsDetail">0 out of 0</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="tailsCount">0%</div>
                            <div class="stat-label">Tails Rate</div>
                            <div class="stat-detail" id="tailsDetail">0 out of 0</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value" id="difference">0%</div>
                            <div class="stat-label">Difference</div>
                            <div class="stat-detail" id="differenceDetail">Perfect balance</div>
                        </div>
                    </div>
                    
                    <div class="probability-chart" id="probabilityChart">
                        <div class="chart-bar">
                            <div class="chart-label">Heads</div>
                            <div class="chart-bar-inner">
                                <div class="chart-bar-fill heads-fill" id="headsBar" style="width: 0%"></div>
                            </div>
                            <div class="chart-percentage" id="headsPercentage">0%</div>
                        </div>
                        <div class="chart-bar">
                            <div class="chart-label">Tails</div>
                            <div class="chart-bar-inner">
                                <div class="chart-bar-fill tails-fill" id="tailsBar" style="width: 0%"></div>
                            </div>
                            <div class="chart-percentage" id="tailsPercentage">0%</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="history-section" id="historySection">
                <h3>📜 Flip History</h3>
                <div class="history-list" id="historyList">
                    <!-- History items will appear here -->
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🪙 Advanced Coin Flipping</h2>
            
            <p>Experience realistic coin flipping with advanced statistics, probability analysis, and comprehensive testing tools for educational, gaming, and decision-making purposes.</p>

            <h3>🎯 Coin Types & Characteristics</h3>
            <div class="coin-types">
                <div class="coin-card">
                    <div class="coin-name">🪙 Fair Coin</div>
                    <div class="coin-desc">Theoretical perfect coin with exactly 50/50 probability</div>
                </div>
                <div class="coin-card">
                    <div class="coin-name">🇺🇸 US Quarter</div>
                    <div class="coin-desc">Actual US quarter with slight bias (≈50.8% heads)</div>
                </div>
                <div class="coin-card">
                    <div class="coin-name">🇺🇸 US Penny</div>
                    <div class="coin-desc">Lincoln penny with unique weight distribution</div>
                </div>
                <div class="coin-card">
                    <div class="coin-name">🇪🇺 Euro Coin</div>
                    <div class="coin-desc">European currency with balanced design</div>
                </div>
                <div class="coin-card">
                    <div class="coin-name">🏛️ Ancient Roman</div>
                    <div class="coin-desc">Historical coins used in ancient decision making</div>
                </div>
                <div class="coin-card">
                    <div class="coin-name">⚙️ Custom Coin</div>
                    <div class="coin-desc">User-defined probability distribution</div>
                </div>
            </div>

            <h3>📊 Probability Mathematics</h3>
            <div class="formula-box">
                <strong>Probability Calculations:</strong><br>
                • <strong>Single Flip:</strong> P(Heads) = p, P(Tails) = 1-p<br>
                • <strong>Multiple Flips:</strong> Follows binomial distribution B(n,p)<br>
                • <strong>Expected Value:</strong> E[Heads] = n × p<br>
                • <strong>Variance:</strong> Var = n × p × (1-p)<br>
                • <strong>Standard Deviation:</strong> σ = √(n × p × (1-p))<br>
                • <strong>Law of Large Numbers:</strong> As n → ∞, observed frequency → p
            </div>

            <h3>🎮 Common Applications</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Description</th>
                        <th>Typical Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Decision Making</td><td>Random choice between two options</td><td>Personal decisions, game starts</td></tr>
                    <tr><td>Probability Education</td><td>Teaching basic probability concepts</td><td>Math classes, statistics courses</td></tr>
                    <tr><td>Game Mechanics</td><td>Random events in games</td><td>Board games, video games</td></tr>
                    <tr><td>Statistical Testing</td><td>Testing random number generators</td><td>Quality assurance, research</td></tr>
                    <tr><td>Sports</td><td>Determining initial possession</td><td>Football, basketball coin toss</td></tr>
                    <tr><td>Cryptography</td><td>Generating random bits</td><td>Encryption, key generation</td></tr>
                </tbody>
            </table>

            <h3>📈 Statistical Properties</h3>
            <div class="probability-grid">
                <div class="probability-item">
                    <div class="prob-value">50%</div>
                    <div class="prob-label">Fair Coin Heads</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">25%</div>
                    <div class="prob-label">Two Heads in a Row</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">12.5%</div>
                    <div class="prob-label">Three Heads in a Row</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">6.25%</div>
                    <div class="prob-label">Four Heads in a Row</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">50.8%</div>
                    <div class="prob-label">US Quarter Heads</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">≈47-53%</div>
                    <div class="prob-label">Real Coin Range</div>
                </div>
            </div>

            <h3>🎲 Famous Probability Problems</h3>
            <div class="formula-box">
                <strong>Classical Probability Problems:</strong><br>
                • <strong>Gambler's Fallacy:</strong> Believing past flips affect future outcomes<br>
                • <strong>Monty Hall Problem:</strong> Conditional probability puzzle<br>
                • <strong>Birthday Paradox:</strong> Probability of shared birthdays<br>
                • <strong>St. Petersburg Paradox:</strong> Infinite expected value game<br>
                • <strong>Benford's Law:</strong> Distribution of leading digits
            </div>

            <h3>🔢 Expected Patterns</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Number of Flips</th>
                        <th>Expected Heads</th>
                        <th>Standard Deviation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>10</td><td>5</td><td>1.58</td></tr>
                    <tr><td>100</td><td>50</td><td>5</td></tr>
                    <tr><td>1,000</td><td>500</td><td>15.81</td></tr>
                    <tr><td>10,000</td><td>5,000</td><td>50</td></tr>
                    <tr><td>100,000</td><td>50,000</td><td>158.11</td></tr>
                    <tr><td>1,000,000</td><td>500,000</td><td>500</td></tr>
                </tbody>
            </table>

            <h3>⚖️ Bias and Fairness</h3>
            <ul>
                <li><strong>Physical Coins:</strong> Most real coins have slight bias (50.1%-50.8%)</li>
                <li><strong>Weight Distribution:</strong> Heavier side tends to land down</li>
                <li><strong>Design Factors:</strong> Raised edges, surface patterns affect outcomes</li>
                <li><strong>Flipping Technique:</strong> Human flippers introduce additional bias</li>
                <li><strong>Statistical Significance:</strong> Detecting bias requires large samples</li>
            </ul>

            <h3>📱 Digital vs Physical Coins</h3>
            <div class="formula-box">
                <strong>Digital Coin Advantages:</strong><br>
                • <strong>True Randomness:</strong> Cryptographic random number generation<br>
                • <strong>Precise Control:</strong> Exact probability settings<br>
                • <strong>Instant Results:</strong> No physical flipping required<br>
                • <strong>Statistical Tracking:</strong> Automatic history and analysis<br>
                • <strong>No Wear:</strong> Consistent behavior over time<br>
                • <strong>Customization:</strong> Adjustable parameters and biases
            </div>

            <h3>🎯 Decision Making Strategies</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Strategy</th>
                        <th>Description</th>
                        <th>When to Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Single Flip</td><td>One flip decides between two options</td><td>Simple either/or choices</td></tr>
                    <tr><td>Best of Three</td><td>Majority of three flips wins</td><td>Important decisions</td></tr>
                    <tr><td>Sequential Flips</td><td>Continue flipping until pattern emerges</td><td>Complex multi-option choices</td></tr>
                    <tr><td>Weighted Flips</td><td>Adjust probability based on preference</td><td>When options aren't equal</td></tr>
                    <tr><td>Multiple Coins</td><td>Flip several coins simultaneously</td><td>Group decisions, games</td></tr>
                </tbody>
            </table>

            <h3>🔬 Scientific Research</h3>
            <ul>
                <li><strong>Persi Diaconis:</strong> Stanford mathematician who proved coin flipping is not 50/50</li>
                <li><strong>Research Findings:</strong> Same-side bias of about 1% for typical flips</li>
                <li><strong>Physics Studies:</strong> Coin dynamics, air resistance, landing surface effects</li>
                <li><strong>Psychology:</strong> How humans perceive and use randomness</li>
                <li><strong>Cryptography:</strong> Using coin flips for secure random bit generation</li>
            </ul>

            <h3>🌍 Historical Significance</h3>
            <p>Coin flipping dates back to ancient Roman times where it was known as "navia aut caput" (ship or head). Roman coins featured ships on one side and the emperor's head on the other. The practice has been used for centuries in decision making, games, and divination across cultures worldwide.</p>
        </div>

        <div class="footer">
            <p>🪙 Advanced Coin Flip Simulator | Probability Testing & Decision Making</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for education, gaming, statistical analysis, and random decision assistance</p>
        </div>
    </div>

    <script>
        let flipHistory = [];
        let totalHeads = 0;
        let totalTails = 0;
        let totalFlips = 0;
        
        // Update probability slider value display
        document.getElementById('probability').addEventListener('input', function() {
            document.getElementById('probabilityValue').textContent = this.value + '%';
        });

        // Set coin type and adjust probability
        document.getElementById('coinType').addEventListener('change', function() {
            switch (this.value) {
                case 'fair':
                    document.getElementById('probability').value = 50;
                    break;
                case 'us_quarter':
                    document.getElementById('probability').value = 50.8;
                    break;
                case 'us_penny':
                    document.getElementById('probability').value = 50.2;
                    break;
                case 'euro':
                    document.getElementById('probability').value = 50.1;
                    break;
                case 'ancient':
                    document.getElementById('probability').value = 49.5;
                    break;
                case 'custom':
                    // Keep current value
                    break;
            }
            document.getElementById('probabilityValue').textContent = document.getElementById('probability').value + '%';
        });

        function flipCoins() {
            const coinCount = parseInt(document.getElementById('coinCount').value);
            const flipCount = parseInt(document.getElementById('flipCount').value);
            const probability = parseInt(document.getElementById('probability').value) / 100;
            const animate = document.getElementById('animateFlips').checked;
            const showStats = document.getElementById('showStats').checked;
            
            const resultsContainer = document.getElementById('coinResults');
            resultsContainer.innerHTML = '';
            
            let currentHeads = 0;
            let currentTails = 0;
            
            // Perform all flips
            for (let f = 0; f < flipCount; f++) {
                const flipResults = [];
                
                // Flip all coins
                for (let c = 0; c < coinCount; c++) {
                    const isHeads = Math.random() < probability;
                    flipResults.push(isHeads);
                    
                    if (isHeads) {
                        currentHeads++;
                        totalHeads++;
                    } else {
                        currentTails++;
                        totalTails++;
                    }
                    
                    totalFlips++;
                    
                    // Create coin face
                    const coinFace = document.createElement('div');
                    coinFace.className = `coin-face ${isHeads ? 'heads' : 'tails'}`;
                    coinFace.textContent = isHeads ? 'H' : 'T';
                    
                    if (animate) {
                        coinFace.classList.add('flipping');
                        setTimeout(() => {
                            coinFace.classList.remove('flipping');
                        }, 600);
                    }
                    
                    resultsContainer.appendChild(coinFace);
                }
                
                // Add to history
                if (document.getElementById('showHistory').checked) {
                    const timestamp = new Date().toLocaleTimeString();
                    const headsCount = flipResults.filter(r => r).length;
                    const resultText = `${coinCount} coin${coinCount > 1 ? 's' : ''}: ${headsCount} heads, ${coinCount - headsCount} tails`;
                    
                    flipHistory.unshift({
                        timestamp,
                        result: resultText,
                        heads: headsCount,
                        tails: coinCount - headsCount,
                        details: flipResults
                    });
                    
                    updateHistory();
                }
            }
            
            // Update statistics
            updateStatistics(currentHeads, currentTails);
            
            // Show summary if requested
            if (showStats || flipCount > 1 || coinCount > 1) {
                document.getElementById('resultSummary').style.display = 'block';
            }
        }
        
        function updateStatistics(currentHeads, currentTails) {
            const totalCurrent = currentHeads + currentTails;
            const headsPercentage = totalCurrent > 0 ? (currentHeads / totalCurrent * 100).toFixed(1) : 0;
            const tailsPercentage = totalCurrent > 0 ? (currentTails / totalCurrent * 100).toFixed(1) : 0;
            
            // Update main stats
            document.getElementById('totalFlips').textContent = totalFlips.toLocaleString();
            document.getElementById('flipDetail').textContent = `${totalHeads.toLocaleString()} heads, ${totalTails.toLocaleString()} tails`;
            
            document.getElementById('headsCount').textContent = headsPercentage + '%';
            document.getElementById('headsDetail').textContent = `${currentHeads} out of ${totalCurrent}`;
            
            document.getElementById('tailsCount').textContent = tailsPercentage + '%';
            document.getElementById('tailsDetail').textContent = `${currentTails} out of ${totalCurrent}`;
            
            const difference = Math.abs(headsPercentage - tailsPercentage);
            document.getElementById('difference').textContent = difference.toFixed(1) + '%';
            document.getElementById('differenceDetail').textContent = 
                difference < 1 ? 'Perfect balance' : 
                difference < 5 ? 'Slight imbalance' : 
                difference < 10 ? 'Moderate imbalance' : 'Significant imbalance';
            
            // Update chart
            document.getElementById('headsBar').style.width = headsPercentage + '%';
            document.getElementById('tailsBar').style.width = tailsPercentage + '%';
            document.getElementById('headsPercentage').textContent = headsPercentage + '%';
            document.getElementById('tailsPercentage').textContent = tailsPercentage + '%';
        }
        
        function updateHistory() {
            const historyList = document.getElementById('historyList');
            historyList.innerHTML = '';
            
            // Keep only last 50 flips
            if (flipHistory.length > 50) {
                flipHistory = flipHistory.slice(0, 50);
            }
            
            flipHistory.forEach(flip => {
                const historyItem = document.createElement('div');
                historyItem.className = 'history-item';
                
                const resultIcons = flip.details.map((isHeads, index) => 
                    `<div class="result-icon ${isHeads ? 'heads-icon' : 'tails-icon'}">${isHeads ? 'H' : 'T'}</div>`
                ).join('');
                
                historyItem.innerHTML = `
                    <span style="color: #7f8c8d; font-size: 0.9rem;">${flip.timestamp}</span>
                    <div class="history-result">
                        ${resultIcons}
                    </div>
                    <span><strong>${flip.result}</strong></span>
                `;
                historyList.appendChild(historyItem);
            });
            
            // Show/hide history section
            document.getElementById('historySection').style.display = 
                flipHistory.length > 0 ? 'block' : 'none';
        }
        
        function quickFlip(coins, flips) {
            document.getElementById('coinCount').value = coins;
            document.getElementById('flipCount').value = flips;
            flipCoins();
        }
        
        function setBiasedCoin() {
            document.getElementById('probability').value = 70;
            document.getElementById('probabilityValue').textContent = '70%';
            document.getElementById('coinType').value = 'custom';
        }
        
        function clearResults() {
            document.getElementById('coinResults').innerHTML = '';
            document.getElementById('resultSummary').style.display = 'none';
        }
        
        function clearHistory() {
            flipHistory = [];
            totalHeads = 0;
            totalTails = 0;
            totalFlips = 0;
            updateHistory();
            updateStatistics(0, 0);
            document.getElementById('historySection').style.display = 'none';
            document.getElementById('resultSummary').style.display = 'none';
        }
        
        function saveResults() {
            let results = 'Coin Flip Results\n';
            results += 'Generated: ' + new Date().toLocaleString() + '\n';
            results += `Total Flips: ${totalFlips}\n`;
            results += `Heads: ${totalHeads} (${(totalHeads/totalFlips*100).toFixed(2)}%)\n`;
            results += `Tails: ${totalTails} (${(totalTails/totalFlips*100).toFixed(2)}%)\n\n`;
            results += 'Flip History:\n';
            
            flipHistory.forEach(flip => {
                results += `${flip.timestamp}: ${flip.result}\n`;
            });
            
            const blob = new Blob([results], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'coin-flips.txt';
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
