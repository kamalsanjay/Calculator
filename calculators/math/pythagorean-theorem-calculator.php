<?php
/**
 * Pythagorean Theorem Calculator
 * File: calculators/pythagorean-theorem-calculator.php
 * Description: Calculate missing sides of right triangles using Pythagorean theorem with step-by-step solutions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pythagorean Theorem Calculator - Find Missing Triangle Sides</title>
    <meta name="description" content="Calculate missing sides of right triangles using Pythagorean theorem. Step-by-step solutions with diagrams and explanations.">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #7209b7;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --danger: #e63946;
            --dark: #2b2d42;
            --light: #f8f9fa;
            --gray: #6c757d;
            --border-radius: 12px;
            --box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }

        .dark-mode {
            --bg-primary: #1a1a2e;
            --bg-secondary: #16213e;
            --bg-card: #0f3460;
            --text-primary: #ffffff;
            --text-secondary: #b0b0b0;
            --border-color: #2d3748;
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            transition: background-color 0.3s, color 0.3s;
        }
        
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); 
            min-height: 100vh; 
            padding: 20px;
            color: var(--dark);
            line-height: 1.6;
        }
        
        body.dark-mode {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: var(--text-primary);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header { 
            background: rgba(255,255,255,0.15); 
            color: white; 
            padding: 25px 30px; 
            text-align: center; 
            border-radius: var(--border-radius); 
            margin-bottom: 25px; 
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .dark-mode header {
            background: rgba(0,0,0,0.25);
        }
        
        header h1 { 
            font-size: 2.2rem; 
            margin-bottom: 10px; 
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        
        header p { 
            font-size: 1.1rem; 
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .controls-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .breadcrumb a { 
            color: white; 
            text-decoration: none; 
            font-weight: 500; 
            background: rgba(255,255,255,0.2); 
            padding: 12px 20px; 
            border-radius: 8px; 
            display: inline-flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px); 
            font-size: 0.95rem;
            transition: var(--transition);
        }
        
        .breadcrumb a:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        
        .theme-toggle {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            backdrop-filter: blur(10px);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }
        
        .theme-toggle:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 1024px) {
            .main-content {
                grid-template-columns: 1fr;
            }
        }
        
        .calculator-card, .results-card {
            background: white; 
            padding: 30px; 
            border-radius: var(--border-radius); 
            box-shadow: var(--box-shadow);
            height: fit-content;
        }
        
        .dark-mode .calculator-card,
        .dark-mode .results-card {
            background: var(--bg-card);
            color: var(--text-primary);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .dark-mode .card-header {
            border-bottom-color: var(--border-color);
        }
        
        .card-header h2 {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .input-section { 
            margin-bottom: 25px; 
        }
        
        .input-section label { 
            display: block; 
            margin-bottom: 12px; 
            font-weight: 600; 
            color: var(--dark);
            font-size: 1rem; 
        }
        
        .dark-mode .input-section label {
            color: var(--text-primary);
        }
        
        .input-section input,
        .input-section select { 
            width: 100%; 
            padding: 15px; 
            border: 2px solid #e0e0e0; 
            border-radius: 8px; 
            font-size: 1rem; 
            outline: none; 
            transition: var(--transition); 
            font-family: 'JetBrains Mono', 'Courier New', monospace; 
            background: white;
            color: var(--dark);
        }
        
        .dark-mode .input-section input,
        .dark-mode .input-section select {
            background: var(--bg-secondary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .input-section input:focus,
        .input-section select:focus { 
            border-color: var(--primary); 
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15); 
        }
        
        .input-hint { 
            font-size: 0.85rem; 
            color: var(--gray); 
            margin-top: 8px; 
            font-style: italic; 
        }
        
        .dark-mode .input-hint {
            color: var(--text-secondary);
        }
        
        .btn { 
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); 
            color: white; 
            border: none; 
            padding: 16px 28px; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: 600; 
            width: 100%; 
            font-size: 1.1rem; 
            transition: var(--transition); 
            box-shadow: 0 4px 12px rgba(0,0,0,0.15); 
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        
        .btn:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 6px 18px rgba(0,0,0,0.2); 
        }
        
        .btn:active { 
            transform: translateY(-1px); 
        }
        
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .btn-secondary {
            background: var(--gray);
        }
        
        .btn-success {
            background: var(--success);
        }
        
        .btn-danger {
            background: var(--danger);
        }
        
        .examples { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); 
            gap: 12px; 
            margin: 20px 0; 
        }
        
        .example-btn { 
            padding: 12px 15px; 
            background: #f0f0f0; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            cursor: pointer; 
            text-align: center; 
            font-size: 0.9rem; 
            transition: var(--transition); 
            font-family: 'JetBrains Mono', 'Courier New', monospace; 
        }
        
        .dark-mode .example-btn {
            background: var(--bg-secondary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .example-btn:hover { 
            background: var(--primary); 
            color: white; 
            transform: translateY(-2px); 
        }
        
        .results-section { 
            display: none;
        }
        
        .results-section.show { 
            display: block; 
            animation: slideIn 0.4s ease-out; 
        }
        
        @keyframes slideIn { 
            from { 
                opacity: 0; 
                transform: translateY(25px); 
            } 
            to { 
                opacity: 1; 
                transform: translateY(0); 
            } 
        }
        
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); 
            gap: 15px; 
            margin-bottom: 25px; 
        }
        
        .result-box { 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 3px 12px rgba(0,0,0,0.08); 
            border-left: 4px solid var(--success);
            transition: var(--transition);
        }
        
        .result-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.12);
        }
        
        .dark-mode .result-box {
            background: var(--bg-secondary);
        }
        
        .result-label { 
            font-size: 0.8rem; 
            color: var(--gray); 
            margin-bottom: 8px; 
            font-weight: 600; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
        }
        
        .dark-mode .result-label {
            color: var(--text-secondary);
        }
        
        .result-value { 
            font-size: 1.4rem; 
            color: var(--success); 
            font-weight: bold; 
            font-family: 'JetBrains Mono', 'Courier New', monospace; 
            word-break: break-word; 
            line-height: 1.4; 
        }
        
        .formula-box { 
            background: #f8f9fa; 
            padding: 18px; 
            border-radius: 10px; 
            border-left: 4px solid var(--primary); 
            margin: 18px 0; 
            font-size: 0.9rem; 
            line-height: 1.7; 
        }
        
        .dark-mode .formula-box {
            background: var(--bg-secondary);
        }
        
        .formula-box strong { 
            color: var(--primary); 
            display: block; 
            margin-bottom: 8px; 
            font-size: 1rem;
        }
        
        .step-box { 
            background: #fff3cd; 
            padding: 18px; 
            border-radius: 10px; 
            border-left: 4px solid var(--warning); 
            margin: 18px 0; 
        }
        
        .dark-mode .step-box {
            background: #3a2e0f;
        }
        
        .step-box strong { 
            color: var(--warning); 
            display: block; 
            margin-bottom: 10px; 
            font-size: 1rem;
        }
        
        .step { 
            padding: 8px 0; 
            border-bottom: 1px solid #ffe082; 
            font-family: 'JetBrains Mono', 'Courier New', monospace; 
            font-size: 0.9rem; 
        }
        
        .dark-mode .step {
            border-bottom-color: #5c4a1a;
        }
        
        .step:last-child { 
            border-bottom: none; 
        }
        
        .data-display { 
            background: #e3f2fd; 
            padding: 18px; 
            border-radius: 10px; 
            border-left: 4px solid var(--info); 
            margin: 18px 0; 
        }
        
        .dark-mode .data-display {
            background: #1a3a5f;
        }
        
        .data-display strong { 
            color: var(--info); 
            display: block; 
            margin-bottom: 10px; 
            font-size: 1rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .action-buttons .btn {
            width: auto;
            flex: 1;
            min-width: 140px;
            font-size: 0.95rem;
            padding: 12px 18px;
        }
        
        .diagram-container {
            margin: 25px 0;
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            height: 300px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .dark-mode .diagram-container {
            background: var(--bg-secondary);
        }
        
        .triangle-diagram {
            width: 200px;
            height: 200px;
            position: relative;
        }
        
        .triangle {
            width: 0;
            height: 0;
            border-left: 100px solid transparent;
            border-right: 100px solid transparent;
            border-bottom: 173px solid #4361ee;
            opacity: 0.3;
            position: absolute;
            top: 10px;
            left: 0;
        }
        
        .triangle-side {
            position: absolute;
            font-weight: bold;
            color: var(--primary);
            font-family: 'JetBrains Mono', monospace;
        }
        
        .side-a {
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .side-b {
            top: 50%;
            right: -40px;
            transform: translateY(-50%);
        }
        
        .side-c {
            top: 20px;
            left: 50%;
            transform: translateX(-50%) rotate(-60deg);
        }
        
        .right-angle {
            position: absolute;
            bottom: 10px;
            right: 60px;
            width: 20px;
            height: 20px;
            background: var(--warning);
            opacity: 0.7;
        }
        
        .advanced-options {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
        
        .dark-mode .advanced-options {
            border-top-color: var(--border-color);
        }
        
        .options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .option-group {
            margin-bottom: 15px;
        }
        
        .option-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-weight: 500;
            cursor: pointer;
        }
        
        .tabs {
            display: flex;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .dark-mode .tabs {
            border-bottom-color: var(--border-color);
        }
        
        .tab {
            padding: 12px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .tab.active {
            border-bottom-color: var(--primary);
            color: var(--primary);
        }
        
        .tab:hover:not(.active) {
            background: rgba(0,0,0,0.03);
        }
        
        .dark-mode .tab:hover:not(.active) {
            background: rgba(255,255,255,0.05);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .loading {
            display: inline-block;
            width: 22px;
            height: 22px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid var(--danger);
        }
        
        .dark-mode .error-message {
            background: #3c1a1d;
            color: #f8a5a5;
        }
        
        .success-message {
            background: #d1edff;
            color: #0c5460;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid var(--info);
        }
        
        .dark-mode .success-message {
            background: #1a3a5f;
            color: #a5d8f8;
        }
        
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 0.9rem;
        }
        
        .comparison-table th,
        .comparison-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .dark-mode .comparison-table th,
        .dark-mode .comparison-table td {
            border-bottom-color: var(--border-color);
        }
        
        .comparison-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: var(--dark);
        }
        
        .dark-mode .comparison-table th {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }
        
        .comparison-table tr:hover {
            background: #f8f9fa;
        }
        
        .dark-mode .comparison-table tr:hover {
            background: rgba(255,255,255,0.05);
        }
        
        .interpretation {
            background: #e8f5e9;
            padding: 18px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #4caf50;
        }
        
        .dark-mode .interpretation {
            background: #1b3a1f;
        }
        
        .calculation-type {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .type-option {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: var(--transition);
            text-align: center;
        }

        .dark-mode .type-option {
            background: var(--bg-secondary);
        }

        .type-option.active {
            border-color: var(--primary);
            background: rgba(67, 97, 238, 0.1);
        }

        .type-option h3 {
            margin-bottom: 8px;
            color: var(--primary);
        }

        .type-option p {
            font-size: 0.85rem;
            color: var(--gray);
        }

        .dark-mode .type-option p {
            color: var(--text-secondary);
        }

        .side-inputs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .real-world-app {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid var(--info);
        }

        .dark-mode .real-world-app {
            background: linear-gradient(135deg, #1a3a5f 0%, #2d1b4e 100%);
        }
        
        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .controls-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .breadcrumb a, .theme-toggle {
                justify-content: center;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .action-buttons .btn {
                width: 100%;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .result-value {
                font-size: 1.2rem;
            }
            
            .tabs {
                overflow-x: auto;
                white-space: nowrap;
            }
            
            header h1 {
                font-size: 1.8rem;
            }
            
            header p {
                font-size: 1rem;
            }
            
            .diagram-container {
                height: 250px;
            }
            
            .triangle-diagram {
                transform: scale(0.8);
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 15px;
            }
            
            .calculator-card, .results-card {
                padding: 20px;
            }
            
            .stats-grid { 
                grid-template-columns: 1fr; 
            }
            
            .examples {
                grid-template-columns: 1fr 1fr;
            }
            
            .btn {
                padding: 14px 20px;
            }
            
            .calculation-type {
                grid-template-columns: 1fr;
            }
            
            .side-inputs {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📐 Pythagorean Theorem Calculator</h1>
            <p>Calculate missing sides of right triangles with step-by-step solutions and visual diagrams</p>
        </header>

        <div class="controls-bar">
            <div class="breadcrumb">
                <a href="../index.php" aria-label="Back to calculators">← Back to Calculators</a>
            </div>
            <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">
                <span id="themeIcon">🌙</span> <span id="themeText">Dark Mode</span>
            </button>
        </div>

        <div class="main-content">
            <div class="calculator-card">
                <div class="card-header">
                    <span>📐</span>
                    <h2>Triangle Configuration</h2>
                </div>
                
                <div class="input-section">
                    <label>Calculation Type</label>
                    <div class="calculation-type">
                        <div class="type-option active" data-type="find-hypotenuse">
                            <h3>Find Hypotenuse (c)</h3>
                            <p>Calculate hypotenuse from legs a and b</p>
                        </div>
                        <div class="type-option" data-type="find-leg">
                            <h3>Find Leg (a or b)</h3>
                            <p>Calculate leg from hypotenuse and other leg</p>
                        </div>
                        <div class="type-option" data-type="all-sides">
                            <h3>All Sides Known</h3>
                            <p>Verify Pythagorean theorem</p>
                        </div>
                    </div>
                </div>
                
                <div class="input-section" id="hypotenuseParams">
                    <label>Enter Known Leg Lengths</label>
                    <div class="side-inputs">
                        <div class="input-group">
                            <label for="legA">Leg A (a)</label>
                            <input type="number" id="legA" value="3" step="any" min="0.1" placeholder="Enter length">
                        </div>
                        <div class="input-group">
                            <label for="legB">Leg B (b)</label>
                            <input type="number" id="legB" value="4" step="any" min="0.1" placeholder="Enter length">
                        </div>
                    </div>
                    <div class="input-hint">Enter the lengths of both legs to calculate the hypotenuse</div>
                </div>
                
                <div class="input-section" id="legParams" style="display: none;">
                    <label>Enter Known Values</label>
                    <div class="side-inputs">
                        <div class="input-group">
                            <label for="knownLeg">Known Leg</label>
                            <input type="number" id="knownLeg" value="3" step="any" min="0.1" placeholder="Enter length">
                        </div>
                        <div class="input-group">
                            <label for="hypotenuse">Hypotenuse (c)</label>
                            <input type="number" id="hypotenuse" value="5" step="any" min="0.1" placeholder="Enter length">
                        </div>
                    </div>
                    <div class="input-hint">Enter one leg and the hypotenuse to find the other leg</div>
                </div>
                
                <div class="input-section" id="allSidesParams" style="display: none;">
                    <label>Enter All Three Sides</label>
                    <div class="side-inputs">
                        <div class="input-group">
                            <label for="sideA">Leg A (a)</label>
                            <input type="number" id="sideA" value="3" step="any" min="0.1" placeholder="Enter length">
                        </div>
                        <div class="input-group">
                            <label for="sideB">Leg B (b)</label>
                            <input type="number" id="sideB" value="4" step="any" min="0.1" placeholder="Enter length">
                        </div>
                        <div class="input-group">
                            <label for="sideC">Hypotenuse (c)</label>
                            <input type="number" id="sideC" value="5" step="any" min="0.1" placeholder="Enter length">
                        </div>
                    </div>
                    <div class="input-hint">Enter all three sides to verify the Pythagorean theorem</div>
                </div>
                
                <div class="advanced-options">
                    <h3>⚙️ Advanced Options</h3>
                    <div class="options-grid">
                        <div class="option-group">
                            <label for="showSteps">Show Step-by-Step Solution</label>
                            <input type="checkbox" id="showSteps" checked>
                        </div>
                        <div class="option-group">
                            <label for="showDiagram">Show Triangle Diagram</label>
                            <input type="checkbox" id="showDiagram" checked>
                        </div>
                        <div class="option-group">
                            <label for="decimalPlaces">Decimal Places</label>
                            <select id="decimalPlaces">
                                <option value="2">2</option>
                                <option value="4" selected>4</option>
                                <option value="6">6</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <button class="btn" id="calculateBtn" onclick="calculatePythagorean()" aria-label="Calculate Pythagorean theorem">
                    <span>Calculate</span>
                </button>
                
                <div class="examples">
                    <button class="example-btn" onclick="loadExample('3-4-5')">3-4-5 Triangle</button>
                    <button class="example-btn" onclick="loadExample('5-12-13')">5-12-13 Triangle</button>
                    <button class="example-btn" onclick="loadExample('8-15-17')">8-15-17 Triangle</button>
                    <button class="example-btn" onclick="loadExample('7-24-25')">7-24-25 Triangle</button>
                </div>
            </div>

            <div class="results-card">
                <div class="card-header">
                    <span>📊</span>
                    <h2>Calculation Results</h2>
                </div>
                
                <div class="results-section" id="result" aria-live="polite">
                    <div id="output"></div>
                </div>
                
                <div class="action-buttons">
                    <button class="btn btn-secondary" onclick="exportResults()" aria-label="Export results to CSV">
                        📥 Export Results
                    </button>
                    <button class="btn btn-success" onclick="generateReport()" aria-label="Generate detailed report">
                        📄 Generate Report
                    </button>
                    <button class="btn btn-danger" onclick="clearAll()" aria-label="Clear all data and results">
                        🗑️ Clear All
                    </button>
                </div>
            </div>
        </div>

        <div class="calculator-card">
            <div class="tabs" role="tablist">
                <div class="tab active" onclick="switchTab('formula')" role="tab" aria-selected="true" aria-controls="formulaTab">Pythagorean Formula</div>
                <div class="tab" onclick="switchTab('applications')" role="tab" aria-selected="false" aria-controls="applicationsTab">Real-World Applications</div>
                <div class="tab" onclick="switchTab('history')" role="tab" aria-selected="false" aria-controls="historyTab">Historical Context</div>
                <div class="tab" onclick="switchTab('examples')" role="tab" aria-selected="false" aria-controls="examplesTab">Common Triangles</div>
            </div>
            
            <div class="tab-content active" id="formulaTab" role="tabpanel">
                <div class="formula-box">
                    <strong>Pythagorean Theorem Formula</strong>
                    \[ a^2 + b^2 = c^2 \]<br>
                    Where:<br>
                    • a, b = lengths of the legs (shorter sides)<br>
                    • c = length of the hypotenuse (longest side)<br>
                    • The triangle must be a right triangle (90° angle)
                </div>
                
                <div class="step-box">
                    <strong>🔍 How to Use the Theorem</strong>
                    <div class="step">1. Identify the right angle in the triangle</div>
                    <div class="step">2. Label the sides: legs (a, b) and hypotenuse (c)</div>
                    <div class="step">3. Apply the formula: a² + b² = c²</div>
                    <div class="step">4. Solve for the unknown side</div>
                    <div class="step">5. Take square root if solving for a side length</div>
                </div>
                
                <div class="comparison-table">
                    <table>
                        <thead>
                            <tr>
                                <th>To Find</th>
                                <th>Formula</th>
                                <th>Example</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hypotenuse (c)</td>
                                <td>\( c = \sqrt{a^2 + b^2} \)</td>
                                <td>a=3, b=4 → c=5</td>
                            </tr>
                            <tr>
                                <td>Leg (a)</td>
                                <td>\( a = \sqrt{c^2 - b^2} \)</td>
                                <td>c=5, b=4 → a=3</td>
                            </tr>
                            <tr>
                                <td>Leg (b)</td>
                                <td>\( b = \sqrt{c^2 - a^2} \)</td>
                                <td>c=5, a=3 → b=4</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="tab-content" id="applicationsTab" role="tabpanel" hidden>
                <div class="real-world-app">
                    <strong>🏗️ Construction & Architecture</strong>
                    Used to ensure right angles in building foundations, checking square corners, and calculating roof pitches.
                </div>
                
                <div class="real-world-app">
                    <strong>📐 Navigation & Surveying</strong>
                    Helps calculate shortest distances between points and is fundamental in GPS technology and map-making.
                </div>
                
                <div class="real-world-app">
                    <strong>💻 Computer Graphics</strong>
                    Essential for calculating distances between points, collision detection, and 3D rendering.
                </div>
                
                <div class="real-world-app">
                    <strong>📱 Technology & Engineering</strong>
                    Used in antenna placement, satellite positioning, and wireless signal strength calculations.
                </div>
            </div>
            
            <div class="tab-content" id="historyTab" role="tabpanel" hidden>
                <div class="formula-box">
                    <strong>Historical Background</strong>
                    The Pythagorean theorem is named after the ancient Greek mathematician Pythagoras (c. 570–495 BCE), 
                    although evidence suggests it was known to Babylonian mathematicians over 1000 years earlier.
                </div>
                
                <div class="step-box">
                    <strong>📜 Historical Timeline</strong>
                    <div class="step">• 1800 BCE: Babylonian tablets show understanding of the relationship</div>
                    <div class="step">• 600 BCE: Used in ancient Indian mathematics</div>
                    <div class="step">• 500 BCE: Pythagoras and his school formalize the theorem</div>
                    <div class="step">• 300 BCE: Euclid provides geometric proof in "Elements"</div>
                    <div class="step">• Modern: Over 350 different proofs documented</div>
                </div>
                
                <div class="interpretation">
                    <strong>Interesting Facts</strong>
                    <ul style="margin-left: 20px; margin-top: 10px;">
                        <li>The theorem only applies to right triangles</li>
                        <li>It's one of the most proven theorems in mathematics</li>
                        <li>Used in the construction of the Great Pyramids</li>
                        <li>Fundamental to trigonometry and calculus</li>
                    </ul>
                </div>
            </div>
            
            <div class="tab-content" id="examplesTab" role="tabpanel" hidden>
                <div class="formula-box">
                    <strong>Common Pythagorean Triples</strong>
                    These are sets of three positive integers that satisfy the Pythagorean theorem and represent the side lengths of right triangles.
                </div>
                
                <div class="comparison-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Triple</th>
                                <th>Sides (a, b, c)</th>
                                <th>Verification</th>
                                <th>Properties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>3-4-5</td>
                                <td>3, 4, 5</td>
                                <td>3² + 4² = 9 + 16 = 25 = 5²</td>
                                <td>Most famous triple</td>
                            </tr>
                            <tr>
                                <td>5-12-13</td>
                                <td>5, 12, 13</td>
                                <td>5² + 12² = 25 + 144 = 169 = 13²</td>
                                <td>Common in surveying</td>
                            </tr>
                            <tr>
                                <td>8-15-17</td>
                                <td>8, 15, 17</td>
                                <td>8² + 15² = 64 + 225 = 289 = 17²</td>
                                <td>Less common but useful</td>
                            </tr>
                            <tr>
                                <td>7-24-25</td>
                                <td>7, 24, 25</td>
                                <td>7² + 24² = 49 + 576 = 625 = 25²</td>
                                <td>Large number triple</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="step-box">
                    <strong>🔢 Generating More Triples</strong>
                    <div class="step">For any integers m > n > 0:</div>
                    <div class="step">• a = m² - n²</div>
                    <div class="step">• b = 2mn</div>
                    <div class="step">• c = m² + n²</div>
                    <div class="step">Example: m=2, n=1 → 3-4-5 triangle</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentCalculation = {};
        let currentResults = {};
        
        // Initialize the app
        document.addEventListener('DOMContentLoaded', function() {
            // Load saved theme preference
            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-mode');
                document.getElementById('themeIcon').textContent = '☀️';
                document.getElementById('themeText').textContent = 'Light Mode';
            }
            
            // Initialize calculation type selector
            initializeCalculationType();
            
            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    calculatePythagorean();
                }
            });
        });
        
        // Initialize calculation type selector
        function initializeCalculationType() {
            const typeOptions = document.querySelectorAll('.type-option');
            typeOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active class from all options
                    typeOptions.forEach(opt => opt.classList.remove('active'));
                    
                    // Add active class to clicked option
                    this.classList.add('active');
                    
                    // Show relevant parameters
                    const calcType = this.getAttribute('data-type');
                    showCalculationParameters(calcType);
                });
            });
        }
        
        // Show relevant parameters based on calculation type
        function showCalculationParameters(calcType) {
            // Hide all parameter sections
            document.getElementById('hypotenuseParams').style.display = 'none';
            document.getElementById('legParams').style.display = 'none';
            document.getElementById('allSidesParams').style.display = 'none';
            
            // Show relevant section
            document.getElementById(calcType + 'Params').style.display = 'block';
        }
        
        // Theme toggle
        document.getElementById('themeToggle').addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            const isDarkMode = document.body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDarkMode);
            
            if (isDarkMode) {
                document.getElementById('themeIcon').textContent = '☀️';
                document.getElementById('themeText').textContent = 'Light Mode';
            } else {
                document.getElementById('themeIcon').textContent = '🌙';
                document.getElementById('themeText').textContent = 'Dark Mode';
            }
        });
        
        // Tab switching
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
                tab.setAttribute('hidden', 'true');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
                tab.setAttribute('aria-selected', 'false');
            });
            
            // Show selected tab
            const activeTab = document.getElementById(tabName + 'Tab');
            if (activeTab) {
                activeTab.classList.add('active');
                activeTab.removeAttribute('hidden');
            }
            
            // Activate selected tab button
            if (event && event.target) {
                event.target.classList.add('active');
                event.target.setAttribute('aria-selected', 'true');
            }
        }
        
        // Load example triangles
        function loadExample(type) {
            const activeOption = document.querySelector('.type-option.active');
            const currentType = activeOption ? activeOption.getAttribute('data-type') : 'find-hypotenuse';
            
            switch(type) {
                case '3-4-5':
                    if (currentType === 'find-hypotenuse') {
                        document.getElementById('legA').value = 3;
                        document.getElementById('legB').value = 4;
                    } else if (currentType === 'find-leg') {
                        document.getElementById('knownLeg').value = 3;
                        document.getElementById('hypotenuse').value = 5;
                    } else {
                        document.getElementById('sideA').value = 3;
                        document.getElementById('sideB').value = 4;
                        document.getElementById('sideC').value = 5;
                    }
                    break;
                case '5-12-13':
                    if (currentType === 'find-hypotenuse') {
                        document.getElementById('legA').value = 5;
                        document.getElementById('legB').value = 12;
                    } else if (currentType === 'find-leg') {
                        document.getElementById('knownLeg').value = 5;
                        document.getElementById('hypotenuse').value = 13;
                    } else {
                        document.getElementById('sideA').value = 5;
                        document.getElementById('sideB').value = 12;
                        document.getElementById('sideC').value = 13;
                    }
                    break;
                case '8-15-17':
                    if (currentType === 'find-hypotenuse') {
                        document.getElementById('legA').value = 8;
                        document.getElementById('legB').value = 15;
                    } else if (currentType === 'find-leg') {
                        document.getElementById('knownLeg').value = 8;
                        document.getElementById('hypotenuse').value = 17;
                    } else {
                        document.getElementById('sideA').value = 8;
                        document.getElementById('sideB').value = 15;
                        document.getElementById('sideC').value = 17;
                    }
                    break;
                case '7-24-25':
                    if (currentType === 'find-hypotenuse') {
                        document.getElementById('legA').value = 7;
                        document.getElementById('legB').value = 24;
                    } else if (currentType === 'find-leg') {
                        document.getElementById('knownLeg').value = 7;
                        document.getElementById('hypotenuse').value = 25;
                    } else {
                        document.getElementById('sideA').value = 7;
                        document.getElementById('sideB').value = 24;
                        document.getElementById('sideC').value = 25;
                    }
                    break;
            }
            
            calculatePythagorean();
        }
        
        // Show temporary message
        function showTemporaryMessage(message, type = 'info') {
            const messageDiv = document.createElement('div');
            messageDiv.className = type === 'error' ? 'error-message' : 'success-message';
            messageDiv.textContent = message;
            messageDiv.style.margin = '10px 0';
            
            const output = document.getElementById('output');
            if (output) {
                output.prepend(messageDiv);
                
                // Remove message after 3 seconds
                setTimeout(() => {
                    if (messageDiv.parentNode) {
                        messageDiv.parentNode.removeChild(messageDiv);
                    }
                }, 3000);
            }
        }
        
        function showResults() {
            const result = document.getElementById('result');
            if (result) {
                result.classList.add('show');
                result.scrollIntoView({behavior: 'smooth', block: 'start'});
            }
        }
        
        // Calculate hypotenuse
        function calculateHypotenuse(a, b) {
            return Math.sqrt(a * a + b * b);
        }
        
        // Calculate leg
        function calculateLeg(knownLeg, hypotenuse) {
            return Math.sqrt(hypotenuse * hypotenuse - knownLeg * knownLeg);
        }
        
        // Verify Pythagorean triple
        function verifyPythagorean(a, b, c) {
            const leftSide = a * a + b * b;
            const rightSide = c * c;
            const difference = Math.abs(leftSide - rightSide);
            const tolerance = 1e-10; // Allow for floating point precision issues
            
            return {
                isValid: difference <= tolerance,
                leftSide: leftSide,
                rightSide: rightSide,
                difference: difference
            };
        }
        
        // Generate step-by-step solution
        function generateStepByStep(calculationType, values, result) {
            const steps = [];
            const decimals = parseInt(document.getElementById('decimalPlaces').value);
            
            switch(calculationType) {
                case 'find-hypotenuse':
                    const a = values.a;
                    const b = values.b;
                    const c = result.hypotenuse;
                    
                    steps.push(`<strong>Step 1: Identify the formula</strong>`);
                    steps.push(`For a right triangle: a² + b² = c²`);
                    
                    steps.push(`<strong>Step 2: Substitute known values</strong>`);
                    steps.push(`(${a})² + (${b})² = c²`);
                    
                    steps.push(`<strong>Step 3: Calculate squares</strong>`);
                    steps.push(`${a*a} + ${b*b} = c²`);
                    
                    steps.push(`<strong>Step 4: Add the squares</strong>`);
                    steps.push(`${a*a + b*b} = c²`);
                    
                    steps.push(`<strong>Step 5: Take square root</strong>`);
                    steps.push(`c = √${a*a + b*b} = ${c.toFixed(decimals)}`);
                    break;
                    
                case 'find-leg':
                    const knownLeg = values.knownLeg;
                    const hyp = values.hypotenuse;
                    const missingLeg = result.missingLeg;
                    
                    steps.push(`<strong>Step 1: Identify the formula</strong>`);
                    steps.push(`For a right triangle: a² + b² = c²`);
                    
                    steps.push(`<strong>Step 2: Rearrange for missing leg</strong>`);
                    steps.push(`a² = c² - b²`);
                    
                    steps.push(`<strong>Step 3: Substitute known values</strong>`);
                    steps.push(`a² = (${hyp})² - (${knownLeg})²`);
                    
                    steps.push(`<strong>Step 4: Calculate squares</strong>`);
                    steps.push(`a² = ${hyp*hyp} - ${knownLeg*knownLeg}`);
                    
                    steps.push(`<strong>Step 5: Subtract</strong>`);
                    steps.push(`a² = ${hyp*hyp - knownLeg*knownLeg}`);
                    
                    steps.push(`<strong>Step 6: Take square root</strong>`);
                    steps.push(`a = √${hyp*hyp - knownLeg*knownLeg} = ${missingLeg.toFixed(decimals)}`);
                    break;
                    
                case 'all-sides':
                    const sideA = values.a;
                    const sideB = values.b;
                    const sideC = values.c;
                    const verification = result.verification;
                    
                    steps.push(`<strong>Step 1: Check Pythagorean theorem</strong>`);
                    steps.push(`a² + b² = c²`);
                    
                    steps.push(`<strong>Step 2: Substitute values</strong>`);
                    steps.push(`(${sideA})² + (${sideB})² = (${sideC})²`);
                    
                    steps.push(`<strong>Step 3: Calculate squares</strong>`);
                    steps.push(`${sideA*sideA} + ${sideB*sideB} = ${sideC*sideC}`);
                    
                    steps.push(`<strong>Step 4: Add left side</strong>`);
                    steps.push(`${sideA*sideA + sideB*sideB} = ${sideC*sideC}`);
                    
                    steps.push(`<strong>Step 5: Compare both sides</strong>`);
                    if (verification.isValid) {
                        steps.push(`✅ ${sideA*sideA + sideB*sideB} = ${sideC*sideC} - The triangle satisfies the Pythagorean theorem!`);
                    } else {
                        steps.push(`❌ ${sideA*sideA + sideB*sideB} ≠ ${sideC*sideC} - The triangle does NOT satisfy the Pythagorean theorem`);
                        steps.push(`Difference: ${verification.difference.toFixed(decimals)}`);
                    }
                    break;
            }
            
            return steps;
        }
        
        // Create triangle diagram
        function createTriangleDiagram(values, result, calculationType) {
            let a, b, c;
            
            switch(calculationType) {
                case 'find-hypotenuse':
                    a = values.a;
                    b = values.b;
                    c = result.hypotenuse;
                    break;
                case 'find-leg':
                    a = values.knownLeg;
                    b = result.missingLeg;
                    c = values.hypotenuse;
                    break;
                case 'all-sides':
                    a = values.a;
                    b = values.b;
                    c = values.c;
                    break;
            }
            
            // Scale the triangle for better visualization
            const scale = 150 / Math.max(a, b, c);
            const scaledA = a * scale;
            const scaledB = b * scale;
            const scaledC = c * scale;
            
            return `
                <div class="triangle-diagram">
                    <div class="triangle" style="
                        border-left: ${scaledA}px solid transparent;
                        border-right: ${scaledB}px solid transparent;
                        border-bottom: ${scaledC}px solid #4361ee;
                    "></div>
                    <div class="right-angle"></div>
                    <div class="triangle-side side-a">a = ${a.toFixed(2)}</div>
                    <div class="triangle-side side-b">b = ${b.toFixed(2)}</div>
                    <div class="triangle-side side-c">c = ${c.toFixed(2)}</div>
                </div>
            `;
        }
        
        // Main calculation function
        function calculatePythagorean() {
            try {
                const calculateBtn = document.getElementById('calculateBtn');
                const activeOption = document.querySelector('.type-option.active');
                const calculationType = activeOption ? activeOption.getAttribute('data-type') : 'find-hypotenuse';
                const showSteps = document.getElementById('showSteps').checked;
                const showDiagram = document.getElementById('showDiagram').checked;
                const decimals = parseInt(document.getElementById('decimalPlaces').value);
                
                // Show loading state
                if (calculateBtn) {
                    calculateBtn.innerHTML = '<div class="loading"></div> Calculating...';
                    calculateBtn.disabled = true;
                }
                
                // Use setTimeout to allow UI to update
                setTimeout(() => {
                    try {
                        let values = {};
                        let result = {};
                        
                        // Get values based on calculation type
                        switch(calculationType) {
                            case 'find-hypotenuse':
                                const legA = parseFloat(document.getElementById('legA').value);
                                const legB = parseFloat(document.getElementById('legB').value);
                                
                                if (isNaN(legA) || isNaN(legB) || legA <= 0 || legB <= 0) {
                                    throw new Error('Please enter valid positive numbers for both legs');
                                }
                                
                                values = { a: legA, b: legB };
                                result.hypotenuse = calculateHypotenuse(legA, legB);
                                break;
                                
                            case 'find-leg':
                                const knownLeg = parseFloat(document.getElementById('knownLeg').value);
                                const hypotenuse = parseFloat(document.getElementById('hypotenuse').value);
                                
                                if (isNaN(knownLeg) || isNaN(hypotenuse) || knownLeg <= 0 || hypotenuse <= 0) {
                                    throw new Error('Please enter valid positive numbers');
                                }
                                
                                if (knownLeg >= hypotenuse) {
                                    throw new Error('Leg must be shorter than hypotenuse');
                                }
                                
                                values = { knownLeg: knownLeg, hypotenuse: hypotenuse };
                                result.missingLeg = calculateLeg(knownLeg, hypotenuse);
                                break;
                                
                            case 'all-sides':
                                const sideA = parseFloat(document.getElementById('sideA').value);
                                const sideB = parseFloat(document.getElementById('sideB').value);
                                const sideC = parseFloat(document.getElementById('sideC').value);
                                
                                if (isNaN(sideA) || isNaN(sideB) || isNaN(sideC) || sideA <= 0 || sideB <= 0 || sideC <= 0) {
                                    throw new Error('Please enter valid positive numbers for all sides');
                                }
                                
                                if (sideC < sideA || sideC < sideB) {
                                    throw new Error('Hypotenuse must be the longest side');
                                }
                                
                                values = { a: sideA, b: sideB, c: sideC };
                                result.verification = verifyPythagorean(sideA, sideB, sideC);
                                break;
                        }
                        
                        currentCalculation = {
                            type: calculationType,
                            values: values,
                            result: result
                        };
                        
                        // Build and display results
                        displayResults();
                        showResults();
                        
                    } catch (error) {
                        const output = document.getElementById('output');
                        if (output) {
                            output.innerHTML = `<div class="error-message">❌ ${error.message}</div>`;
                        }
                        showResults();
                    } finally {
                        // Reset button
                        if (calculateBtn) {
                            calculateBtn.innerHTML = '<span>Calculate</span>';
                            calculateBtn.disabled = false;
                        }
                    }
                }, 100);
            } catch (error) {
                console.error('Error in calculatePythagorean:', error);
                showTemporaryMessage('An error occurred during calculation', 'error');
            }
        }
        
        function displayResults() {
            try {
                const {
                    type,
                    values,
                    result
                } = currentCalculation;
                
                const showSteps = document.getElementById('showSteps').checked;
                const showDiagram = document.getElementById('showDiagram').checked;
                const decimals = parseInt(document.getElementById('decimalPlaces').value);
                
                let html = '';
                
                // Results overview
                html += `<div class="data-display">
                    <strong>📋 Calculation Summary</strong>
                    <div style="margin-top:12px;">
                        <div class="step">Calculation Type: ${type.replace('-', ' ').toUpperCase()}</div>
                        ${type === 'find-hypotenuse' ? 
                            `<div class="step">Leg A (a): ${values.a.toFixed(decimals)}</div>
                             <div class="step">Leg B (b): ${values.b.toFixed(decimals)}</div>
                             <div class="step">Hypotenuse (c): <strong>${result.hypotenuse.toFixed(decimals)}</strong></div>` :
                         type === 'find-leg' ?
                            `<div class="step">Known Leg: ${values.knownLeg.toFixed(decimals)}</div>
                             <div class="step">Hypotenuse (c): ${values.hypotenuse.toFixed(decimals)}</div>
                             <div class="step">Missing Leg: <strong>${result.missingLeg.toFixed(decimals)}</strong></div>` :
                            `<div class="step">Leg A (a): ${values.a.toFixed(decimals)}</div>
                             <div class="step">Leg B (b): ${values.b.toFixed(decimals)}</div>
                             <div class="step">Hypotenuse (c): ${values.c.toFixed(decimals)}</div>
                             <div class="step">Verification: <strong>${result.verification.isValid ? '✅ VALID' : '❌ INVALID'}</strong></div>`
                        }
                    </div>
                </div>`;
                
                // Main results grid
                html += `<div class="stats-grid">`;
                
                if (type === 'find-hypotenuse') {
                    html += `
                        <div class="result-box">
                            <div class="result-label">Leg A (a)</div>
                            <div class="result-value">${values.a.toFixed(decimals)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:var(--primary);">
                            <div class="result-label">Leg B (b)</div>
                            <div class="result-value" style="color:var(--primary);">${values.b.toFixed(decimals)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:var(--success);">
                            <div class="result-label">Hypotenuse (c)</div>
                            <div class="result-value" style="color:var(--success);">${result.hypotenuse.toFixed(decimals)}</div>
                        </div>
                    `;
                } else if (type === 'find-leg') {
                    html += `
                        <div class="result-box">
                            <div class="result-label">Known Leg</div>
                            <div class="result-value">${values.knownLeg.toFixed(decimals)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:var(--primary);">
                            <div class="result-label">Hypotenuse (c)</div>
                            <div class="result-value" style="color:var(--primary);">${values.hypotenuse.toFixed(decimals)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:var(--success);">
                            <div class="result-label">Missing Leg</div>
                            <div class="result-value" style="color:var(--success);">${result.missingLeg.toFixed(decimals)}</div>
                        </div>
                    `;
                } else {
                    html += `
                        <div class="result-box">
                            <div class="result-label">Leg A (a)</div>
                            <div class="result-value">${values.a.toFixed(decimals)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:var(--primary);">
                            <div class="result-label">Leg B (b)</div>
                            <div class="result-value" style="color:var(--primary);">${values.b.toFixed(decimals)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:var(--info);">
                            <div class="result-label">Hypotenuse (c)</div>
                            <div class="result-value" style="color:var(--info);">${values.c.toFixed(decimals)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:${result.verification.isValid ? 'var(--success)' : 'var(--danger)'};">
                            <div class="result-label">Verification</div>
                            <div class="result-value" style="color:${result.verification.isValid ? 'var(--success)' : 'var(--danger)'};">${result.verification.isValid ? 'VALID' : 'INVALID'}</div>
                        </div>
                    `;
                }
                
                html += `</div>`;
                
                // Triangle diagram
                if (showDiagram) {
                    html += `<div class="diagram-container">
                        ${createTriangleDiagram(values, result, type)}
                    </div>`;
                }
                
                // Step-by-step solution
                if (showSteps) {
                    const steps = generateStepByStep(type, values, result);
                    html += `<div class="step-box">
                        <strong>🧮 Step-by-Step Solution</strong>
                        <div style="margin-top:12px;">`;
                    
                    steps.forEach(step => {
                        html += `<div class="step">${step}</div>`;
                    });
                    
                    html += `</div></div>`;
                }
                
                // Interpretation
                html += `<div class="interpretation">
                    <strong>💡 Result Interpretation</strong>
                    <div style="margin-top:10px;">`;
                
                if (type === 'find-hypotenuse') {
                    html += `<div class="step">• The hypotenuse is approximately ${result.hypotenuse.toFixed(decimals)} units long</div>`;
                    html += `<div class="step">• This means the triangle's longest side measures ${result.hypotenuse.toFixed(decimals)} units</div>`;
                    html += `<div class="step">• The relationship ${values.a}² + ${values.b}² = ${result.hypotenuse.toFixed(decimals)}² holds true</div>`;
                } else if (type === 'find-leg') {
                    html += `<div class="step">• The missing leg is approximately ${result.missingLeg.toFixed(decimals)} units long</div>`;
                    html += `<div class="step">• This completes the right triangle with sides ${values.knownLeg}, ${result.missingLeg.toFixed(decimals)}, and ${values.hypotenuse}</div>`;
                    html += `<div class="step">• The relationship ${values.knownLeg}² + ${result.missingLeg.toFixed(decimals)}² = ${values.hypotenuse}² is satisfied</div>`;
                } else {
                    if (result.verification.isValid) {
                        html += `<div class="step">• ✅ These side lengths form a valid right triangle</div>`;
                        html += `<div class="step">• The Pythagorean theorem is satisfied: ${values.a}² + ${values.b}² = ${values.c}²</div>`;
                        html += `<div class="step">• This is a perfect right triangle</div>`;
                    } else {
                        html += `<div class="step">• ❌ These side lengths do NOT form a right triangle</div>`;
                        html += `<div class="step">• The Pythagorean theorem is not satisfied: ${values.a}² + ${values.b}² ≠ ${values.c}²</div>`;
                        html += `<div class="step">• The difference is approximately ${result.verification.difference.toFixed(decimals)}</div>`;
                    }
                }
                
                html += `</div></div>`;
                
                const output = document.getElementById('output');
                if (output) {
                    output.innerHTML = html;
                }
            } catch (error) {
                console.error('Error displaying results:', error);
                const output = document.getElementById('output');
                if (output) {
                    output.innerHTML = `<div class="error-message">❌ Error displaying results: ${error.message}</div>`;
                }
            }
        }
        
        function exportResults() {
            try {
                if (!currentCalculation.values) {
                    showTemporaryMessage('No data to export', 'error');
                    return;
                }
                
                const { type, values, result } = currentCalculation;
                const decimals = parseInt(document.getElementById('decimalPlaces').value);
                
                let csvContent = "Pythagorean Theorem Calculation Results\n\n";
                csvContent += "Calculation Type," + type + "\n";
                
                if (type === 'find-hypotenuse') {
                    csvContent += "Leg A (a)," + values.a.toFixed(decimals) + "\n";
                    csvContent += "Leg B (b)," + values.b.toFixed(decimals) + "\n";
                    csvContent += "Hypotenuse (c)," + result.hypotenuse.toFixed(decimals) + "\n";
                    csvContent += "Verification," + (Math.abs(values.a*values.a + values.b*values.b - result.hypotenuse*result.hypotenuse) < 1e-10 ? "Valid" : "Invalid") + "\n";
                } else if (type === 'find-leg') {
                    csvContent += "Known Leg," + values.knownLeg.toFixed(decimals) + "\n";
                    csvContent += "Hypotenuse (c)," + values.hypotenuse.toFixed(decimals) + "\n";
                    csvContent += "Missing Leg," + result.missingLeg.toFixed(decimals) + "\n";
                    csvContent += "Verification," + (Math.abs(values.knownLeg*values.knownLeg + result.missingLeg*result.missingLeg - values.hypotenuse*values.hypotenuse) < 1e-10 ? "Valid" : "Invalid") + "\n";
                } else {
                    csvContent += "Leg A (a)," + values.a.toFixed(decimals) + "\n";
                    csvContent += "Leg B (b)," + values.b.toFixed(decimals) + "\n";
                    csvContent += "Hypotenuse (c)," + values.c.toFixed(decimals) + "\n";
                    csvContent += "Verification," + (result.verification.isValid ? "Valid" : "Invalid") + "\n";
                    csvContent += "Difference," + result.verification.difference.toFixed(decimals) + "\n";
                }
                
                csvContent += "\nPythagorean Theorem: a² + b² = c²\n";
                csvContent += "Calculation performed on: " + new Date().toLocaleString();
                
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.setAttribute("href", url);
                link.setAttribute("download", "pythagorean_theorem_results.csv");
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                showTemporaryMessage('Results exported successfully!', 'success');
            } catch (error) {
                console.error('Error exporting results:', error);
                showTemporaryMessage('Error exporting results', 'error');
            }
        }
        
        function generateReport() {
            try {
                if (!currentCalculation.values) {
                    showTemporaryMessage('No data to generate report', 'error');
                    return;
                }
                
                const reportWindow = window.open('', '_blank');
                if (!reportWindow) {
                    showTemporaryMessage('Please allow pop-ups to generate report', 'error');
                    return;
                }
                
                const { type, values, result } = currentCalculation;
                const decimals = parseInt(document.getElementById('decimalPlaces').value);
                
                reportWindow.document.write(`
                    <html>
                        <head>
                            <title>Pythagorean Theorem Calculation Report</title>
                            <style>
                                body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
                                h1 { color: #4361ee; border-bottom: 2px solid #4361ee; padding-bottom: 10px; }
                                .result-box { background: #f8f9fa; padding: 15px; margin: 15px 0; border-radius: 8px; }
                                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                                th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
                                th { background: #4361ee; color: white; }
                                .valid { color: green; font-weight: bold; }
                                .invalid { color: red; font-weight: bold; }
                            </style>
                        </head>
                        <body>
                            <h1>Pythagorean Theorem Calculation Report</h1>
                            
                            <div class="result-box">
                                <h2>Calculation Summary</h2>
                                <p><strong>Calculation Type:</strong> ${type.replace('-', ' ').toUpperCase()}</p>
                                <p><strong>Date:</strong> ${new Date().toLocaleString()}</p>
                            </div>
                            
                            <div class="result-box">
                                <h2>Input Values</h2>
                                <table>
                                    <tr><th>Parameter</th><th>Value</th></tr>
                                    ${type === 'find-hypotenuse' ? 
                                        `<tr><td>Leg A (a)</td><td>${values.a.toFixed(decimals)}</td></tr>
                                         <tr><td>Leg B (b)</td><td>${values.b.toFixed(decimals)}</td></tr>` :
                                     type === 'find-leg' ?
                                        `<tr><td>Known Leg</td><td>${values.knownLeg.toFixed(decimals)}</td></tr>
                                         <tr><td>Hypotenuse (c)</td><td>${values.hypotenuse.toFixed(decimals)}</td></tr>` :
                                        `<tr><td>Leg A (a)</td><td>${values.a.toFixed(decimals)}</td></tr>
                                         <tr><td>Leg B (b)</td><td>${values.b.toFixed(decimals)}</td></tr>
                                         <tr><td>Hypotenuse (c)</td><td>${values.c.toFixed(decimals)}</td></tr>`
                                    }
                                </table>
                            </div>
                            
                            <div class="result-box">
                                <h2>Results</h2>
                                <table>
                                    <tr><th>Result</th><th>Value</th></tr>
                                    ${type === 'find-hypotenuse' ? 
                                        `<tr><td>Hypotenuse (c)</td><td>${result.hypotenuse.toFixed(decimals)}</td></tr>` :
                                     type === 'find-leg' ?
                                        `<tr><td>Missing Leg</td><td>${result.missingLeg.toFixed(decimals)}</td></tr>` :
                                        `<tr><td>Verification</td><td class="${result.verification.isValid ? 'valid' : 'invalid'}">${result.verification.isValid ? 'VALID' : 'INVALID'}</td></tr>
                                         <tr><td>Difference</td><td>${result.verification.difference.toFixed(decimals)}</td></tr>`
                                    }
                                </table>
                            </div>
                            
                            <div class="result-box">
                                <h2>Pythagorean Theorem Verification</h2>
                                <p><strong>Formula:</strong> a² + b² = c²</p>
                                ${type === 'find-hypotenuse' ? 
                                    `<p><strong>Calculation:</strong> ${values.a}² + ${values.b}² = ${result.hypotenuse.toFixed(decimals)}²</p>
                                     <p><strong>Verification:</strong> ${values.a*values.a} + ${values.b*values.b} = ${(result.hypotenuse*result.hypotenuse).toFixed(decimals)}</p>` :
                                 type === 'find-leg' ?
                                    `<p><strong>Calculation:</strong> ${values.knownLeg}² + ${result.missingLeg.toFixed(decimals)}² = ${values.hypotenuse}²</p>
                                     <p><strong>Verification:</strong> ${values.knownLeg*values.knownLeg} + ${(result.missingLeg*result.missingLeg).toFixed(decimals)} = ${values.hypotenuse*values.hypotenuse}</p>` :
                                    `<p><strong>Calculation:</strong> ${values.a}² + ${values.b}² = ${values.c}²</p>
                                     <p><strong>Verification:</strong> ${values.a*values.a} + ${values.b*values.b} = ${values.c*values.c}</p>
                                     <p><strong>Actual:</strong> ${values.a*values.a + values.b*values.b}</p>
                                     <p><strong>Expected:</strong> ${values.c*values.c}</p>`
                                }
                            </div>
                            
                            <p><em>Report generated by Pythagorean Theorem Calculator</em></p>
                        </body>
                    </html>
                `);
                reportWindow.document.close();
                
                showTemporaryMessage('Report generated successfully!', 'success');
            } catch (error) {
                console.error('Error generating report:', error);
                showTemporaryMessage('Error generating report', 'error');
            }
        }
        
        function clearAll() {
            try {
                // Reset form values
                document.getElementById('legA').value = 3;
                document.getElementById('legB').value = 4;
                document.getElementById('knownLeg').value = 3;
                document.getElementById('hypotenuse').value = 5;
                document.getElementById('sideA').value = 3;
                document.getElementById('sideB').value = 4;
                document.getElementById('sideC').value = 5;
                
                const result = document.getElementById('result');
                if (result) {
                    result.classList.remove('show');
                }
                
                currentCalculation = {};
                
                showTemporaryMessage('All data cleared successfully!', 'success');
            } catch (error) {
                console.error('Error clearing data:', error);
                showTemporaryMessage('Error clearing data', 'error');
            }
        }
    </script>
</body>
</html>