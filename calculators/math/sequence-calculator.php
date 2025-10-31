<?php
/**
 * Advanced Sequence Calculator
 * File: sequence-calculator.php
 * Description: Calculate arithmetic, geometric, Fibonacci sequences with advanced analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Sequence Calculator</title>
    <meta name="description" content="Calculate arithmetic, geometric, Fibonacci sequences with pattern recognition and advanced analysis">
    
    <!-- Chart.js for visualizations -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@2.2.1/dist/chartjs-plugin-annotation.min.js"></script>
    <!-- MathJax for mathematical notation -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    
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
            max-width: 1400px;
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
        
        .input-section textarea, 
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
        
        .dark-mode .input-section textarea,
        .dark-mode .input-section input,
        .dark-mode .input-section select {
            background: var(--bg-secondary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .input-section textarea:focus,
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
        
        .btn-warning {
            background: var(--warning);
        }
        
        .sequence-types {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        
        .sequence-type-btn {
            padding: 15px;
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            transition: var(--transition);
            font-weight: 500;
        }
        
        .dark-mode .sequence-type-btn {
            background: var(--bg-secondary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .sequence-type-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }
        
        .sequence-type-btn:hover:not(.active) {
            background: #e9ecef;
            transform: translateY(-2px);
        }
        
        .dark-mode .sequence-type-btn:hover:not(.active) {
            background: rgba(255,255,255,0.1);
        }
        
        .sequence-params {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid var(--info);
        }
        
        .dark-mode .sequence-params {
            background: var(--bg-secondary);
        }
        
        .param-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .param-item {
            display: flex;
            flex-direction: column;
        }
        
        .param-item label {
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
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
        
        .sequence-output {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid var(--info);
        }
        
        .dark-mode .sequence-output {
            background: #1a3a5f;
        }
        
        .sequence-output strong {
            color: var(--info);
            display: block;
            margin-bottom: 10px;
            font-size: 1rem;
        }
        
        .sequence-items {
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            font-size: 0.95rem;
            line-height: 1.6;
            padding: 15px;
            background: rgba(255,255,255,0.7);
            border-radius: 8px;
            max-height: 200px;
            overflow-y: auto;
        }
        
        .dark-mode .sequence-items {
            background: rgba(0,0,0,0.3);
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
        
        .chart-container {
            margin: 25px 0;
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            height: 350px;
        }
        
        .dark-mode .chart-container {
            background: var(--bg-secondary);
        }
        
        .pattern-analysis {
            background: linear-gradient(135deg, #e8f5e9 0%, #f3e5f5 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #4caf50;
        }
        
        .dark-mode .pattern-analysis {
            background: linear-gradient(135deg, #1b3a1f 0%, #2d1b4e 100%);
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
        
        .math-formula {
            font-family: 'Times New Roman', serif;
            font-style: italic;
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
        }
        
        .dark-mode .math-formula {
            background: var(--bg-secondary);
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
            
            .sequence-types {
                grid-template-columns: 1fr;
            }
            
            .param-group {
                grid-template-columns: 1fr;
            }
            
            header h1 {
                font-size: 1.8rem;
            }
            
            header p {
                font-size: 1rem;
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
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🔢 Advanced Sequence Calculator</h1>
            <p>Calculate arithmetic, geometric, Fibonacci sequences with pattern recognition and advanced analysis</p>
        </header>

        <div class="controls-bar">
            <div class="breadcrumb">
                <a href="../index.php">← Back to Calculators</a>
            </div>
            <button class="theme-toggle" id="themeToggle">
                <span id="themeIcon">🌙</span> <span id="themeText">Dark Mode</span>
            </button>
        </div>

        <div class="main-content">
            <div class="calculator-card">
                <div class="card-header">
                    <span>🧮</span>
                    <h2>Sequence Configuration</h2>
                </div>
                
                <div class="sequence-types">
                    <div class="sequence-type-btn active" data-type="arithmetic">Arithmetic Sequence</div>
                    <div class="sequence-type-btn" data-type="geometric">Geometric Sequence</div>
                    <div class="sequence-type-btn" data-type="fibonacci">Fibonacci Sequence</div>
                    <div class="sequence-type-btn" data-type="custom">Custom Sequence</div>
                </div>
                
                <!-- Arithmetic Sequence Parameters -->
                <div class="sequence-params" id="arithmetic-params">
                    <h3>Arithmetic Sequence Parameters</h3>
                    <div class="param-group">
                        <div class="param-item">
                            <label for="arithmetic-first-term">First Term (a₁)</label>
                            <input type="number" id="arithmetic-first-term" value="2" step="any">
                        </div>
                        <div class="param-item">
                            <label for="arithmetic-difference">Common Difference (d)</label>
                            <input type="number" id="arithmetic-difference" value="3" step="any">
                        </div>
                    </div>
                    <div class="param-group">
                        <div class="param-item">
                            <label for="arithmetic-terms">Number of Terms (n)</label>
                            <input type="number" id="arithmetic-terms" value="10" min="2" max="100">
                        </div>
                        <div class="param-item">
                            <label for="arithmetic-nth">Find Specific Term (optional)</label>
                            <input type="number" id="arithmetic-nth" placeholder="e.g., 15" min="1">
                        </div>
                    </div>
                </div>
                
                <!-- Geometric Sequence Parameters -->
                <div class="sequence-params" id="geometric-params" style="display: none;">
                    <h3>Geometric Sequence Parameters</h3>
                    <div class="param-group">
                        <div class="param-item">
                            <label for="geometric-first-term">First Term (a₁)</label>
                            <input type="number" id="geometric-first-term" value="2" step="any">
                        </div>
                        <div class="param-item">
                            <label for="geometric-ratio">Common Ratio (r)</label>
                            <input type="number" id="geometric-ratio" value="2" step="any">
                        </div>
                    </div>
                    <div class="param-group">
                        <div class="param-item">
                            <label for="geometric-terms">Number of Terms (n)</label>
                            <input type="number" id="geometric-terms" value="10" min="2" max="100">
                        </div>
                        <div class="param-item">
                            <label for="geometric-nth">Find Specific Term (optional)</label>
                            <input type="number" id="geometric-nth" placeholder="e.g., 8" min="1">
                        </div>
                    </div>
                </div>
                
                <!-- Fibonacci Sequence Parameters -->
                <div class="sequence-params" id="fibonacci-params" style="display: none;">
                    <h3>Fibonacci Sequence Parameters</h3>
                    <div class="param-group">
                        <div class="param-item">
                            <label for="fibonacci-first">First Number</label>
                            <input type="number" id="fibonacci-first" value="0">
                        </div>
                        <div class="param-item">
                            <label for="fibonacci-second">Second Number</label>
                            <input type="number" id="fibonacci-second" value="1">
                        </div>
                    </div>
                    <div class="param-group">
                        <div class="param-item">
                            <label for="fibonacci-terms">Number of Terms</label>
                            <input type="number" id="fibonacci-terms" value="10" min="2" max="50">
                        </div>
                        <div class="param-item">
                            <label for="fibonacci-nth">Find Specific Term (optional)</label>
                            <input type="number" id="fibonacci-nth" placeholder="e.g., 20" min="1">
                        </div>
                    </div>
                </div>
                
                <!-- Custom Sequence Parameters -->
                <div class="sequence-params" id="custom-params" style="display: none;">
                    <h3>Custom Sequence Analysis</h3>
                    <div class="input-section">
                        <label for="custom-sequence">Enter Your Sequence</label>
                        <textarea id="custom-sequence" placeholder="Enter numbers separated by commas&#10;Example: 2, 4, 8, 16, 32, 64" rows="4">2, 4, 8, 16, 32, 64</textarea>
                        <div class="input-hint">Separate values with commas. Minimum 3 values required for pattern analysis.</div>
                    </div>
                </div>
                
                <button class="btn" id="calculateBtn" onclick="calculateSequence()">
                    <span>Calculate Sequence</span>
                </button>
                
                <div class="examples">
                    <button class="example-btn" onclick="loadExample('arithmetic1')">2, 5, 8, 11...</button>
                    <button class="example-btn" onclick="loadExample('geometric1')">3, 6, 12, 24...</button>
                    <button class="example-btn" onclick="loadExample('fibonacci1')">0, 1, 1, 2, 3...</button>
                    <button class="example-btn" onclick="loadExample('custom1')">1, 4, 9, 16, 25...</button>
                </div>
            </div>

            <div class="results-card">
                <div class="card-header">
                    <span>📊</span>
                    <h2>Sequence Analysis</h2>
                </div>
                
                <div class="results-section" id="result">
                    <div id="output"></div>
                </div>
                
                <div class="action-buttons">
                    <button class="btn btn-secondary" onclick="exportSequence()">
                        📥 Export Sequence
                    </button>
                    <button class="btn btn-success" onclick="generateSequenceReport()">
                        📄 Generate Report
                    </button>
                    <button class="btn btn-danger" onclick="clearAll()">
                        🗑️ Clear All
                    </button>
                </div>
            </div>
        </div>

        <div class="calculator-card">
            <div class="tabs">
                <div class="tab active" onclick="switchTab('formulas')">Sequence Formulas</div>
                <div class="tab" onclick="switchTab('properties')">Sequence Properties</div>
                <div class="tab" onclick="switchTab('applications')">Real Applications</div>
            </div>
            
            <div class="tab-content active" id="formulasTab">
                <div class="formula-box">
                    <strong>Arithmetic Sequence Formulas</strong>
                    <div class="math-formula">n-th term: aₙ = a₁ + (n-1)d</div>
                    <div class="math-formula">Sum of first n terms: Sₙ = n/2 × [2a₁ + (n-1)d]</div>
                    <div class="math-formula">Sum of first n terms (alternative): Sₙ = n/2 × (a₁ + aₙ)</div>
                </div>
                
                <div class="formula-box">
                    <strong>Geometric Sequence Formulas</strong>
                    <div class="math-formula">n-th term: aₙ = a₁ × rⁿ⁻¹</div>
                    <div class="math-formula">Sum of first n terms: Sₙ = a₁ × (1 - rⁿ) / (1 - r), r ≠ 1</div>
                    <div class="math-formula">Sum of infinite series: S = a₁ / (1 - r), |r| < 1</div>
                </div>
                
                <div class="formula-box">
                    <strong>Fibonacci Sequence Formulas</strong>
                    <div class="math-formula">Recursive definition: Fₙ = Fₙ₋₁ + Fₙ₋₂</div>
                    <div class="math-formula">Binet's formula: Fₙ = (φⁿ - ψⁿ) / √5</div>
                    <div class="math-formula">where φ = (1+√5)/2 ≈ 1.618, ψ = (1-√5)/2 ≈ -0.618</div>
                </div>
            </div>
            
            <div class="tab-content" id="propertiesTab">
                <div class="formula-box">
                    <strong>Arithmetic Sequence Properties</strong>
                    • Constant difference between consecutive terms<br>
                    • Linear growth pattern<br>
                    • Can be increasing, decreasing, or constant<br>
                    • Graph forms a straight line when terms are plotted
                </div>
                
                <div class="formula-box">
                    <strong>Geometric Sequence Properties</strong>
                    • Constant ratio between consecutive terms<br>
                    • Exponential growth or decay pattern<br>
                    • Can be increasing, decreasing, or alternating<br>
                    • Graph forms an exponential curve when terms are plotted
                </div>
                
                <div class="formula-box">
                    <strong>Fibonacci Sequence Properties</strong>
                    • Each term is sum of two preceding terms<br>
                    • Ratio of consecutive terms approaches golden ratio φ<br>
                    • Appears in nature, art, and mathematics<br>
                    • Many interesting mathematical properties and identities
                </div>
            </div>
            
            <div class="tab-content" id="applicationsTab">
                <div class="formula-box">
                    <strong>Financial Applications</strong>
                    • Arithmetic sequences: Simple interest, linear depreciation<br>
                    • Geometric sequences: Compound interest, exponential growth<br>
                    • Amortization schedules, investment planning
                </div>
                
                <div class="formula-box">
                    <strong>Scientific Applications</strong>
                    • Population growth models (geometric)<br>
                    • Radioactive decay (geometric)<br>
                    • Harmonic motion, wave patterns<br>
                    • Computer algorithms and data structures
                </div>
                
                <div class="formula-box">
                    <strong>Real-World Applications</strong>
                    • Architecture and design (Fibonacci, golden ratio)<br>
                    • Music theory and composition<br>
                    • Computer graphics and animation<br>
                    • Cryptography and coding theory
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentSequence = [];
        let currentResults = {};
        let charts = [];
        let currentSequenceType = 'arithmetic';
        
        // Initialize the app
        document.addEventListener('DOMContentLoaded', function() {
            // Load saved theme preference
            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-mode');
                document.getElementById('themeIcon').textContent = '☀️';
                document.getElementById('themeText').textContent = 'Light Mode';
            }
            
            // Initialize sequence type buttons
            initializeSequenceTypes();
            
            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    calculateSequence();
                }
            });
        });
        
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
            
            // Update charts if they exist
            updateChartsTheme();
        });
        
        // Initialize sequence type selection
        function initializeSequenceTypes() {
            const sequenceButtons = document.querySelectorAll('.sequence-type-btn');
            sequenceButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    sequenceButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Get sequence type
                    currentSequenceType = this.getAttribute('data-type');
                    
                    // Show appropriate parameters
                    document.querySelectorAll('.sequence-params').forEach(params => {
                        params.style.display = 'none';
                    });
                    document.getElementById(currentSequenceType + '-params').style.display = 'block';
                });
            });
        }
        
        // Tab switching
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName + 'Tab').classList.add('active');
            
            // Activate selected tab button
            event.target.classList.add('active');
        }
        
        // Load example sequences
        function loadExample(exampleType) {
            switch(exampleType) {
                case 'arithmetic1':
                    document.querySelector('.sequence-type-btn[data-type="arithmetic"]').click();
                    document.getElementById('arithmetic-first-term').value = 2;
                    document.getElementById('arithmetic-difference').value = 3;
                    document.getElementById('arithmetic-terms').value = 10;
                    break;
                case 'geometric1':
                    document.querySelector('.sequence-type-btn[data-type="geometric"]').click();
                    document.getElementById('geometric-first-term').value = 3;
                    document.getElementById('geometric-ratio').value = 2;
                    document.getElementById('geometric-terms').value = 8;
                    break;
                case 'fibonacci1':
                    document.querySelector('.sequence-type-btn[data-type="fibonacci"]').click();
                    document.getElementById('fibonacci-first').value = 0;
                    document.getElementById('fibonacci-second').value = 1;
                    document.getElementById('fibonacci-terms').value = 15;
                    break;
                case 'custom1':
                    document.querySelector('.sequence-type-btn[data-type="custom"]').click();
                    document.getElementById('custom-sequence').value = '1, 4, 9, 16, 25, 36, 49, 64';
                    break;
            }
        }
        
        // Sequence calculation functions
        function generateArithmeticSequence(firstTerm, commonDiff, numTerms) {
            const sequence = [firstTerm];
            for (let i = 1; i < numTerms; i++) {
                sequence.push(firstTerm + i * commonDiff);
            }
            return sequence;
        }
        
        function generateGeometricSequence(firstTerm, commonRatio, numTerms) {
            const sequence = [firstTerm];
            for (let i = 1; i < numTerms; i++) {
                sequence.push(firstTerm * Math.pow(commonRatio, i));
            }
            return sequence;
        }
        
        function generateFibonacciSequence(firstTerm, secondTerm, numTerms) {
            const sequence = [firstTerm, secondTerm];
            for (let i = 2; i < numTerms; i++) {
                sequence.push(sequence[i-1] + sequence[i-2]);
            }
            return sequence;
        }
        
        function parseCustomSequence(input) {
            if (!input.trim()) {
                throw new Error('Please enter sequence values');
            }
            
            const values = input
                .split(/[\s,]+/)
                .filter(v => v.trim() !== '')
                .map(v => {
                    const num = parseFloat(v.trim());
                    if (isNaN(num)) {
                        throw new Error(`"${v}" is not a valid number`);
                    }
                    return num;
                });
            
            if (values.length < 3) {
                throw new Error('Please enter at least 3 values for pattern analysis');
            }
            
            return values;
        }
        
        // Pattern analysis functions
        function analyzeSequencePattern(sequence) {
            const differences = [];
            const ratios = [];
            
            // Calculate differences and ratios
            for (let i = 1; i < sequence.length; i++) {
                differences.push(sequence[i] - sequence[i-1]);
                if (sequence[i-1] !== 0) {
                    ratios.push(sequence[i] / sequence[i-1]);
                }
            }
            
            // Check if arithmetic (constant differences)
            const isArithmetic = differences.every((val, i, arr) => 
                i === 0 || Math.abs(val - arr[0]) < 1e-10
            );
            
            // Check if geometric (constant ratios)
            const isGeometric = ratios.length > 0 && ratios.every((val, i, arr) => 
                i === 0 || Math.abs(val - arr[0]) < 1e-10
            );
            
            // Check if quadratic (constant second differences)
            let isQuadratic = false;
            if (differences.length > 1) {
                const secondDifferences = [];
                for (let i = 1; i < differences.length; i++) {
                    secondDifferences.push(differences[i] - differences[i-1]);
                }
                isQuadratic = secondDifferences.every((val, i, arr) => 
                    i === 0 || Math.abs(val - arr[0]) < 1e-10
                );
            }
            
            return {
                differences: differences,
                ratios: ratios,
                isArithmetic: isArithmetic,
                isGeometric: isGeometric,
                isQuadratic: isQuadratic,
                commonDifference: isArithmetic ? differences[0] : null,
                commonRatio: isGeometric ? ratios[0] : null
            };
        }
        
        function predictNextTerms(sequence, pattern, count = 3) {
            const nextTerms = [];
            const lastTerm = sequence[sequence.length - 1];
            
            if (pattern.isArithmetic) {
                for (let i = 1; i <= count; i++) {
                    nextTerms.push(lastTerm + i * pattern.commonDifference);
                }
            } else if (pattern.isGeometric) {
                for (let i = 1; i <= count; i++) {
                    nextTerms.push(lastTerm * Math.pow(pattern.commonRatio, i));
                }
            } else if (pattern.isQuadratic) {
                // For quadratic sequences, use second differences to predict
                const n = sequence.length;
                const a = pattern.differences[1] - pattern.differences[0]; // Second difference / 2
                const b = pattern.differences[0] - 3 * a / 2;
                const c = sequence[0] - a - b;
                
                for (let i = 1; i <= count; i++) {
                    const nextTerm = a * Math.pow(n + i, 2) + b * (n + i) + c;
                    nextTerms.push(nextTerm);
                }
            } else {
                // For other patterns, use linear extrapolation
                const slope = (sequence[sequence.length - 1] - sequence[sequence.length - 2]) / 
                             (sequence.length - 1 - (sequence.length - 2));
                for (let i = 1; i <= count; i++) {
                    nextTerms.push(lastTerm + i * slope);
                }
            }
            
            return nextTerms;
        }
        
        function calculateSequenceStatistics(sequence) {
            const mean = sequence.reduce((a, b) => a + b, 0) / sequence.length;
            const variance = sequence.reduce((sum, val) => sum + Math.pow(val - mean, 2), 0) / sequence.length;
            const stdDev = Math.sqrt(variance);
            const min = Math.min(...sequence);
            const max = Math.max(...sequence);
            const range = max - min;
            
            // Calculate growth rate
            const growthRates = [];
            for (let i = 1; i < sequence.length; i++) {
                if (sequence[i-1] !== 0) {
                    growthRates.push((sequence[i] - sequence[i-1]) / sequence[i-1] * 100);
                }
            }
            const avgGrowthRate = growthRates.length > 0 ? 
                growthRates.reduce((a, b) => a + b, 0) / growthRates.length : 0;
            
            return {
                mean: mean,
                variance: variance,
                stdDev: stdDev,
                min: min,
                max: max,
                range: range,
                sum: sequence.reduce((a, b) => a + b, 0),
                avgGrowthRate: avgGrowthRate
            };
        }
        
        function calculateSequence() {
            const calculateBtn = document.getElementById('calculateBtn');
            
            // Show loading state
            calculateBtn.innerHTML = '<div class="loading"></div> Calculating...';
            calculateBtn.disabled = true;
            
            // Use setTimeout to allow UI to update before heavy calculation
            setTimeout(() => {
                try {
                    let sequence = [];
                    let specificTerm = null;
                    
                    switch(currentSequenceType) {
                        case 'arithmetic':
                            const a1 = parseFloat(document.getElementById('arithmetic-first-term').value);
                            const d = parseFloat(document.getElementById('arithmetic-difference').value);
                            const nArithmetic = parseInt(document.getElementById('arithmetic-terms').value);
                            specificTerm = document.getElementById('arithmetic-nth').value ? 
                                parseInt(document.getElementById('arithmetic-nth').value) : null;
                            
                            if (isNaN(a1) || isNaN(d) || isNaN(nArithmetic)) {
                                throw new Error('Please enter valid arithmetic sequence parameters');
                            }
                            if (nArithmetic < 2 || nArithmetic > 100) {
                                throw new Error('Number of terms must be between 2 and 100');
                            }
                            
                            sequence = generateArithmeticSequence(a1, d, nArithmetic);
                            break;
                            
                        case 'geometric':
                            const g1 = parseFloat(document.getElementById('geometric-first-term').value);
                            const r = parseFloat(document.getElementById('geometric-ratio').value);
                            const nGeometric = parseInt(document.getElementById('geometric-terms').value);
                            specificTerm = document.getElementById('geometric-nth').value ? 
                                parseInt(document.getElementById('geometric-nth').value) : null;
                            
                            if (isNaN(g1) || isNaN(r) || isNaN(nGeometric)) {
                                throw new Error('Please enter valid geometric sequence parameters');
                            }
                            if (nGeometric < 2 || nGeometric > 100) {
                                throw new Error('Number of terms must be between 2 and 100');
                            }
                            
                            sequence = generateGeometricSequence(g1, r, nGeometric);
                            break;
                            
                        case 'fibonacci':
                            const f1 = parseFloat(document.getElementById('fibonacci-first').value);
                            const f2 = parseFloat(document.getElementById('fibonacci-second').value);
                            const nFibonacci = parseInt(document.getElementById('fibonacci-terms').value);
                            specificTerm = document.getElementById('fibonacci-nth').value ? 
                                parseInt(document.getElementById('fibonacci-nth').value) : null;
                            
                            if (isNaN(f1) || isNaN(f2) || isNaN(nFibonacci)) {
                                throw new Error('Please enter valid Fibonacci sequence parameters');
                            }
                            if (nFibonacci < 2 || nFibonacci > 50) {
                                throw new Error('Number of terms must be between 2 and 50');
                            }
                            
                            sequence = generateFibonacciSequence(f1, f2, nFibonacci);
                            break;
                            
                        case 'custom':
                            const customInput = document.getElementById('custom-sequence').value;
                            sequence = parseCustomSequence(customInput);
                            break;
                    }
                    
                    currentSequence = sequence;
                    
                    // Analyze sequence pattern
                    const patternAnalysis = analyzeSequencePattern(sequence);
                    
                    // Calculate statistics
                    const statistics = calculateSequenceStatistics(sequence);
                    
                    // Predict next terms
                    const nextTerms = predictNextTerms(sequence, patternAnalysis);
                    
                    // Calculate specific term if requested
                    let specificTermValue = null;
                    if (specificTerm) {
                        switch(currentSequenceType) {
                            case 'arithmetic':
                                const a1 = parseFloat(document.getElementById('arithmetic-first-term').value);
                                const d = parseFloat(document.getElementById('arithmetic-difference').value);
                                specificTermValue = a1 + (specificTerm - 1) * d;
                                break;
                            case 'geometric':
                                const g1 = parseFloat(document.getElementById('geometric-first-term').value);
                                const r = parseFloat(document.getElementById('geometric-ratio').value);
                                specificTermValue = g1 * Math.pow(r, specificTerm - 1);
                                break;
                            case 'fibonacci':
                                // For Fibonacci, we already have the sequence up to the requested term
                                if (specificTerm <= sequence.length) {
                                    specificTermValue = sequence[specificTerm - 1];
                                } else {
                                    // Extend Fibonacci sequence if needed
                                    const extendedSequence = generateFibonacciSequence(
                                        parseFloat(document.getElementById('fibonacci-first').value),
                                        parseFloat(document.getElementById('fibonacci-second').value),
                                        specificTerm
                                    );
                                    specificTermValue = extendedSequence[specificTerm - 1];
                                }
                                break;
                        }
                    }
                    
                    // Store results
                    currentResults = {
                        sequence: sequence,
                        pattern: patternAnalysis,
                        statistics: statistics,
                        nextTerms: nextTerms,
                        specificTerm: specificTermValue,
                        sequenceType: currentSequenceType
                    };
                    
                    // Build and display results
                    displayResults();
                    showResults();
                    
                } catch (error) {
                    document.getElementById('output').innerHTML = `<div class="error-message">❌ ${error.message}</div>`;
                    showResults();
                } finally {
                    // Reset button
                    calculateBtn.innerHTML = '<span>Calculate Sequence</span>';
                    calculateBtn.disabled = false;
                }
            }, 100);
        }
        
        function displayResults() {
            const { sequence, pattern, statistics, nextTerms, specificTerm, sequenceType } = currentResults;
            
            let html = '';
            
            // Sequence output
            html += `<div class="sequence-output">
                <strong>🔢 Generated Sequence</strong>
                <div class="sequence-items">${sequence.join(', ')}</div>
                <div style="margin-top:10px;font-size:0.85rem;color:var(--gray);">
                    Length: ${sequence.length} terms | Sum: ${statistics.sum.toFixed(4)}
                </div>
            </div>`;
            
            // Specific term result
            if (specificTerm !== null) {
                const termNumber = document.getElementById(sequenceType + '-nth').value;
                html += `<div class="step-box">
                    <strong>🎯 Specific Term Calculation</strong>
                    <div class="step">Term a₍${termNumber}₎ = ${specificTerm.toFixed(4)}</div>
                </div>`;
            }
            
            // Main statistics grid
            html += `<div class="stats-grid">
                <div class="result-box">
                    <div class="result-label">Sequence Type</div>
                    <div class="result-value" style="text-transform: capitalize;">${sequenceType}</div>
                </div>
                <div class="result-box" style="border-left-color:var(--primary);">
                    <div class="result-label">Mean</div>
                    <div class="result-value" style="color:var(--primary);">${statistics.mean.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:var(--info);">
                    <div class="result-label">Standard Deviation</div>
                    <div class="result-value" style="color:var(--info);">${statistics.stdDev.toFixed(4)}</div>
                </div>
                <div class="result-box" style="border-left-color:var(--success);">
                    <div class="result-label">Range</div>
                    <div class="result-value" style="color:var(--success);">${statistics.range.toFixed(4)}</div>
                </div>
            </div>`;
            
            // Pattern analysis
            html += `<div class="pattern-analysis">
                <strong>🔍 Pattern Analysis</strong>
                <div style="margin-top:12px;">
                    <div class="step">Arithmetic Pattern: ${pattern.isArithmetic ? '✅ Yes' : '❌ No'} 
                    ${pattern.isArithmetic ? `(d = ${pattern.commonDifference})` : ''}</div>
                    <div class="step">Geometric Pattern: ${pattern.isGeometric ? '✅ Yes' : '❌ No'} 
                    ${pattern.isGeometric ? `(r = ${pattern.commonRatio.toFixed(4)})` : ''}</div>
                    <div class="step">Quadratic Pattern: ${pattern.isQuadratic ? '✅ Yes' : '❌ No'}</div>
                    <div class="step">Average Growth Rate: ${statistics.avgGrowthRate.toFixed(2)}%</div>
                </div>
            </div>`;
            
            // Next terms prediction
            html += `<div class="step-box">
                <strong>🔮 Predicted Next Terms</strong>
                <div class="step">${nextTerms.map((term, index) => `Term ${sequence.length + index + 1}: ${term.toFixed(4)}`).join(' | ')}</div>
            </div>`;
            
            // Charts
            html += `<div class="chart-container">
                <canvas id="sequenceChart"></canvas>
            </div>`;
            
            // Formula and calculation steps
            html += `<div class="formula-box">
                <strong>📝 Calculation Details</strong>`;
            
            switch(sequenceType) {
                case 'arithmetic':
                    const a1 = parseFloat(document.getElementById('arithmetic-first-term').value);
                    const d = parseFloat(document.getElementById('arithmetic-difference').value);
                    html += `<div class="step">Formula: aₙ = a₁ + (n-1)d</div>
                    <div class="step">Where: a₁ = ${a1}, d = ${d}</div>
                    <div class="step">Example: a₃ = ${a1} + (3-1)×${d} = ${a1 + 2*d}</div>`;
                    break;
                case 'geometric':
                    const g1 = parseFloat(document.getElementById('geometric-first-term').value);
                    const r = parseFloat(document.getElementById('geometric-ratio').value);
                    html += `<div class="step">Formula: aₙ = a₁ × rⁿ⁻¹</div>
                    <div class="step">Where: a₁ = ${g1}, r = ${r}</div>
                    <div class="step">Example: a₃ = ${g1} × ${r}² = ${g1 * Math.pow(r, 2)}</div>`;
                    break;
                case 'fibonacci':
                    const f1 = parseFloat(document.getElementById('fibonacci-first').value);
                    const f2 = parseFloat(document.getElementById('fibonacci-second').value);
                    html += `<div class="step">Formula: Fₙ = Fₙ₋₁ + Fₙ₋₂</div>
                    <div class="step">Where: F₁ = ${f1}, F₂ = ${f2}</div>
                    <div class="step">Example: F₃ = ${f2} + ${f1} = ${f1 + f2}</div>`;
                    break;
                case 'custom':
                    html += `<div class="step">Custom sequence analysis based on pattern recognition</div>
                    <div class="step">First differences: ${pattern.differences.map(d => d.toFixed(2)).join(', ')}</div>`;
                    if (pattern.ratios.length > 0) {
                        html += `<div class="step">Ratios: ${pattern.ratios.map(r => r.toFixed(2)).join(', ')}</div>`;
                    }
                    break;
            }
            
            html += `</div>`;
            
            document.getElementById('output').innerHTML = html;
            
            // Create sequence chart
            createSequenceChart(sequence);
        }
        
        function createSequenceChart(sequence) {
            // Destroy existing chart if it exists
            if (charts.sequence) {
                charts.sequence.destroy();
            }
            
            const ctx = document.getElementById('sequenceChart').getContext('2d');
            const labels = sequence.map((_, index) => `Term ${index + 1}`);
            
            charts.sequence = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sequence Values',
                        data: sequence,
                        borderColor: 'rgb(67, 97, 238)',
                        backgroundColor: 'rgba(67, 97, 238, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Sequence Progression',
                            font: {
                                size: 16
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Term Position'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Value'
                            }
                        }
                    }
                }
            });
        }
        
        function updateChartsTheme() {
            // This would update chart colors based on theme
            // Implementation depends on the charting library
        }
        
        function showResults() {
            document.getElementById('result').classList.add('show');
            document.getElementById('result').scrollIntoView({behavior: 'smooth', block: 'start'});
        }
        
        function exportSequence() {
            if (!currentSequence || currentSequence.length === 0) {
                alert('No sequence to export');
                return;
            }
            
            let csvContent = "Sequence Analysis Results\n\n";
            csvContent += "Term Position,Value\n";
            currentSequence.forEach((value, index) => {
                csvContent += `${index + 1},${value}\n`;
            });
            
            csvContent += "\nSequence Statistics\n";
            csvContent += `Type,${currentResults.sequenceType}\n`;
            csvContent += `Length,${currentSequence.length}\n`;
            csvContent += `Sum,${currentResults.statistics.sum.toFixed(4)}\n`;
            csvContent += `Mean,${currentResults.statistics.mean.toFixed(4)}\n`;
            csvContent += `Standard Deviation,${currentResults.statistics.stdDev.toFixed(4)}\n`;
            csvContent += `Minimum,${currentResults.statistics.min}\n`;
            csvContent += `Maximum,${currentResults.statistics.max}\n`;
            csvContent += `Range,${currentResults.statistics.range.toFixed(4)}\n`;
            
            if (currentResults.pattern.isArithmetic) {
                csvContent += `Common Difference,${currentResults.pattern.commonDifference}\n`;
            }
            if (currentResults.pattern.isGeometric) {
                csvContent += `Common Ratio,${currentResults.pattern.commonRatio.toFixed(4)}\n`;
            }
            
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement("a");
            link.setAttribute("href", url);
            link.setAttribute("download", "sequence_analysis.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        function generateSequenceReport() {
            if (!currentSequence || currentSequence.length === 0) {
                alert('No sequence to generate report');
                return;
            }
            
            const reportWindow = window.open('', '_blank');
            const sequenceTypeNames = {
                'arithmetic': 'Arithmetic Sequence',
                'geometric': 'Geometric Sequence',
                'fibonacci': 'Fibonacci Sequence',
                'custom': 'Custom Sequence'
            };
            
            reportWindow.document.write(`
                <html>
                    <head>
                        <title>Sequence Analysis Report</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
                            h1 { color: #4361ee; border-bottom: 2px solid #4361ee; padding-bottom: 10px; }
                            .stat-box { background: #f8f9fa; padding: 15px; margin: 15px 0; border-radius: 8px; }
                            table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                            th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
                            th { background: #4361ee; color: white; }
                            .sequence-values { font-family: 'Courier New', monospace; background: #f8f9fa; padding: 15px; border-radius: 5px; }
                        </style>
                    </head>
                    <body>
                        <h1>Sequence Analysis Report</h1>
                        
                        <div class="stat-box">
                            <h2>Sequence Overview</h2>
                            <p><strong>Type:</strong> ${sequenceTypeNames[currentResults.sequenceType]}</p>
                            <p><strong>Length:</strong> ${currentSequence.length} terms</p>
                            <p><strong>Sequence Values:</strong></p>
                            <div class="sequence-values">${currentSequence.join(', ')}</div>
                        </div>
                        
                        <div class="stat-box">
                            <h2>Statistical Summary</h2>
                            <table>
                                <tr><th>Statistic</th><th>Value</th></tr>
                                <tr><td>Sum</td><td>${currentResults.statistics.sum.toFixed(4)}</td></tr>
                                <tr><td>Mean</td><td>${currentResults.statistics.mean.toFixed(4)}</td></tr>
                                <tr><td>Standard Deviation</td><td>${currentResults.statistics.stdDev.toFixed(4)}</td></tr>
                                <tr><td>Minimum</td><td>${currentResults.statistics.min}</td></tr>
                                <tr><td>Maximum</td><td>${currentResults.statistics.max}</td></tr>
                                <tr><td>Range</td><td>${currentResults.statistics.range.toFixed(4)}</td></tr>
                            </table>
                        </div>
                        
                        <div class="stat-box">
                            <h2>Pattern Analysis</h2>
                            <table>
                                <tr><th>Pattern Type</th><th>Detected</th><th>Value</th></tr>
                                <tr><td>Arithmetic</td><td>${currentResults.pattern.isArithmetic ? 'Yes' : 'No'}</td><td>${currentResults.pattern.isArithmetic ? currentResults.pattern.commonDifference : 'N/A'}</td></tr>
                                <tr><td>Geometric</td><td>${currentResults.pattern.isGeometric ? 'Yes' : 'No'}</td><td>${currentResults.pattern.isGeometric ? currentResults.pattern.commonRatio.toFixed(4) : 'N/A'}</td></tr>
                                <tr><td>Quadratic</td><td>${currentResults.pattern.isQuadratic ? 'Yes' : 'No'}</td><td>N/A</td></tr>
                            </table>
                        </div>
                        
                        <div class="stat-box">
                            <h2>Predicted Next Terms</h2>
                            <p>${currentResults.nextTerms.map((term, index) => `Term ${currentSequence.length + index + 1}: ${term.toFixed(4)}`).join(' | ')}</p>
                        </div>
                        
                        <p><em>Report generated on ${new Date().toLocaleString()}</em></p>
                    </body>
                </html>
            `);
            reportWindow.document.close();
        }
        
        function clearAll() {
            // Reset all input fields
            document.getElementById('arithmetic-first-term').value = '2';
            document.getElementById('arithmetic-difference').value = '3';
            document.getElementById('arithmetic-terms').value = '10';
            document.getElementById('arithmetic-nth').value = '';
            
            document.getElementById('geometric-first-term').value = '2';
            document.getElementById('geometric-ratio').value = '2';
            document.getElementById('geometric-terms').value = '10';
            document.getElementById('geometric-nth').value = '';
            
            document.getElementById('fibonacci-first').value = '0';
            document.getElementById('fibonacci-second').value = '1';
            document.getElementById('fibonacci-terms').value = '10';
            document.getElementById('fibonacci-nth').value = '';
            
            document.getElementById('custom-sequence').value = '2, 4, 8, 16, 32, 64';
            
            // Reset to arithmetic sequence
            document.querySelector('.sequence-type-btn[data-type="arithmetic"]').click();
            
            // Clear results
            document.getElementById('result').classList.remove('show');
            currentSequence = [];
            currentResults = {};
            
            // Clear charts
            Object.values(charts).forEach(chart => {
                if (chart) chart.destroy();
            });
            charts = [];
        }
    </script>
</body>
</html>