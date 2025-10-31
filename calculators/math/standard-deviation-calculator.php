<?php
/**
 * Advanced Standard Deviation Calculator
 * File: calculators/standard-deviation-calculator.php
 * Description: Calculate standard deviation, variance, mean, and perform statistical analysis with confidence intervals and hypothesis testing
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Standard Deviation Calculator - Statistical Analysis Tool</title>
    <meta name="description" content="Calculate standard deviation, variance, mean, and perform statistical analysis with confidence intervals and hypothesis testing. Free online statistics calculator.">
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
        
        .chart-container {
            margin: 25px 0;
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            height: 350px;
            position: relative;
        }
        
        .dark-mode .chart-container {
            background: var(--bg-secondary);
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
        
        .confidence-interval {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid var(--info);
        }
        
        .dark-mode .confidence-interval {
            background: linear-gradient(135deg, #1a3a5f 0%, #2d1b4e 100%);
        }
        
        .hypothesis-test {
            background: linear-gradient(135deg, #fff3cd 0%, #ffebee 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid var(--warning);
        }
        
        .dark-mode .hypothesis-test {
            background: linear-gradient(135deg, #3a2e0f 0%, #3c1a1d 100%);
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
        
        .z-score-table {
            max-height: 300px;
            overflow-y: auto;
            margin: 15px 0;
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
        
        .data-points-info {
            background: #fff3e0;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #ff9800;
        }
        
        .dark-mode .data-points-info {
            background: #3a2e0f;
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

        .data-type-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .data-option {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: var(--transition);
        }

        .dark-mode .data-option {
            background: var(--bg-secondary);
        }

        .data-option.active {
            border-color: var(--primary);
            background: rgba(67, 97, 238, 0.1);
        }

        .data-option h3 {
            margin-bottom: 8px;
            color: var(--primary);
        }

        .data-option p {
            font-size: 0.85rem;
            color: var(--gray);
        }

        .dark-mode .data-option p {
            color: var(--text-secondary);
        }

        .param-inputs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .param-group {
            margin-bottom: 15px;
        }

        .param-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .z-score-display {
            max-height: 300px;
            overflow-y: auto;
            margin: 15px 0;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
        }

        .dark-mode .z-score-display {
            background: var(--bg-secondary);
        }

        .z-score-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
            font-family: 'JetBrains Mono', monospace;
        }

        .dark-mode .z-score-item {
            border-bottom-color: var(--border-color);
        }

        .z-score-item:last-child {
            border-bottom: none;
        }

        .outlier-detection {
            background: linear-gradient(135deg, #ffebee 0%, #fff3cd 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid var(--warning);
        }

        .dark-mode .outlier-detection {
            background: linear-gradient(135deg, #3c1a1d 0%, #3a2e0f 100%);
        }

        .distribution-analysis {
            background: linear-gradient(135deg, #e8f5e9 0%, #e3f2fd 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #4caf50;
        }

        .dark-mode .distribution-analysis {
            background: linear-gradient(135deg, #1b3a1f 0%, #1a3a5f 100%);
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>σ Advanced Standard Deviation Calculator</h1>
            <p>Calculate standard deviation, variance, mean, and perform statistical analysis with confidence intervals and hypothesis testing</p>
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
                    <span>σ</span>
                    <h2>Data Input</h2>
                </div>
                
                <div class="input-section">
                    <label for="dataType">Select Data Input Method</label>
                    <div class="data-type-selector">
                        <div class="data-option active" data-type="manual">
                            <h3>Manual Input</h3>
                            <p>Enter data values separated by commas</p>
                        </div>
                        <div class="data-option" data-type="population">
                            <h3>Population Data</h3>
                            <p>Enter population parameters</p>
                        </div>
                        <div class="data-option" data-type="sample">
                            <h3>Sample Data</h3>
                            <p>Enter sample statistics</p>
                        </div>
                    </div>
                </div>
                
                <div class="input-section" id="manualParams">
                    <label for="dataInput">Enter Data Values</label>
                    <textarea id="dataInput" rows="4" placeholder="Enter numbers separated by commas: 12, 15, 18, 22, 25, 28, 30">12, 15, 18, 22, 25, 28, 30</textarea>
                    <div class="input-hint">Separate values with commas. You can also paste data from Excel or other sources.</div>
                </div>
                
                <div class="input-section" id="populationParams" style="display: none;">
                    <label>Population Parameters</label>
                    <div class="param-inputs">
                        <div class="param-group">
                            <label for="popMean">Population Mean (μ)</label>
                            <input type="number" id="popMean" value="100" step="any">
                        </div>
                        <div class="param-group">
                            <label for="popStdDev">Population Standard Deviation (σ)</label>
                            <input type="number" id="popStdDev" value="15" step="any" min="0">
                        </div>
                        <div class="param-group">
                            <label for="popSize">Population Size (N)</label>
                            <input type="number" id="popSize" value="1000" min="1">
                        </div>
                    </div>
                </div>
                
                <div class="input-section" id="sampleParams" style="display: none;">
                    <label>Sample Statistics</label>
                    <div class="param-inputs">
                        <div class="param-group">
                            <label for="sampleMean">Sample Mean (x̄)</label>
                            <input type="number" id="sampleMean" value="105" step="any">
                        </div>
                        <div class="param-group">
                            <label for="sampleStdDev">Sample Standard Deviation (s)</label>
                            <input type="number" id="sampleStdDev" value="12" step="any" min="0">
                        </div>
                        <div class="param-group">
                            <label for="sampleSize">Sample Size (n)</label>
                            <input type="number" id="sampleSize" value="50" min="2">
                        </div>
                    </div>
                </div>
                
                <div class="advanced-options">
                    <h3>⚙️ Advanced Statistical Analysis</h3>
                    <div class="options-grid">
                        <div class="option-group">
                            <label for="calcZScore">Calculate Z-Scores</label>
                            <input type="checkbox" id="calcZScore" checked>
                        </div>
                        <div class="option-group">
                            <label for="detectOutliers">Detect Outliers</label>
                            <input type="checkbox" id="detectOutliers" checked>
                        </div>
                        <div class="option-group">
                            <label for="confidenceInterval">Calculate Confidence Interval</label>
                            <input type="checkbox" id="confidenceInterval" checked>
                        </div>
                        <div class="option-group">
                            <label for="hypothesisTest">Perform Hypothesis Test</label>
                            <input type="checkbox" id="hypothesisTest">
                        </div>
                    </div>
                    
                    <div class="param-inputs" id="confidenceOptions" style="margin-top: 15px;">
                        <div class="param-group">
                            <label for="confidenceLevel">Confidence Level</label>
                            <select id="confidenceLevel">
                                <option value="0.90">90%</option>
                                <option value="0.95" selected>95%</option>
                                <option value="0.99">99%</option>
                                <option value="0.999">99.9%</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="param-inputs" id="hypothesisOptions" style="margin-top: 15px; display: none;">
                        <div class="param-group">
                            <label for="testMean">Test Mean (μ₀)</label>
                            <input type="number" id="testMean" value="100" step="any">
                        </div>
                        <div class="param-group">
                            <label for="testType">Test Type</label>
                            <select id="testType">
                                <option value="two-tailed">Two-Tailed</option>
                                <option value="left-tailed">Left-Tailed</option>
                                <option value="right-tailed">Right-Tailed</option>
                            </select>
                        </div>
                        <div class="param-group">
                            <label for="significanceLevel">Significance Level (α)</label>
                            <select id="significanceLevel">
                                <option value="0.10">10%</option>
                                <option value="0.05" selected>5%</option>
                                <option value="0.01">1%</option>
                                <option value="0.001">0.1%</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <button class="btn" id="calculateBtn" onclick="calculateStatistics()" aria-label="Calculate statistics">
                    <span>Calculate Statistics</span>
                </button>
                
                <div class="examples">
                    <button class="example-btn" onclick="loadExample('testScores')">Test Scores</button>
                    <button class="example-btn" onclick="loadExample('heights')">Heights</button>
                    <button class="example-btn" onclick="loadExample('prices')">Stock Prices</button>
                    <button class="example-btn" onclick="loadExample('normalDist')">Normal Distribution</button>
                </div>
            </div>

            <div class="results-card">
                <div class="card-header">
                    <span>📊</span>
                    <h2>Statistical Analysis</h2>
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
                <div class="tab active" onclick="switchTab('interpretation')" role="tab" aria-selected="true" aria-controls="interpretationTab">Interpretation Guide</div>
                <div class="tab" onclick="switchTab('formulas')" role="tab" aria-selected="false" aria-controls="formulasTab">Formulas & Methods</div>
                <div class="tab" onclick="switchTab('applications')" role="tab" aria-selected="false" aria-controls="applicationsTab">Real-World Applications</div>
            </div>
            
            <div class="tab-content active" id="interpretationTab" role="tabpanel">
                <div class="formula-box">
                    <strong>Understanding Standard Deviation</strong>
                    Standard deviation measures the amount of variation or dispersion in a set of values. A low standard deviation indicates that values tend to be close to the mean, while a high standard deviation indicates that values are spread out over a wider range.
                </div>
                
                <div class="interpretation">
                    <strong>How to Interpret Results:</strong>
                    <ul style="margin-left: 20px; margin-top: 10px;">
                        <li><strong>Mean:</strong> The average value of your dataset</li>
                        <li><strong>Standard Deviation:</strong> How spread out your data is from the mean</li>
                        <li><strong>Variance:</strong> The square of the standard deviation</li>
                        <li><strong>Z-Scores:</strong> How many standard deviations a value is from the mean</li>
                        <li><strong>Confidence Interval:</strong> Range where the true population mean likely falls</li>
                    </ul>
                </div>
                
                <div class="comparison-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Standard Deviation</th>
                                <th>Interpretation</th>
                                <th>Example Context</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Very Low (σ &lt; 0.5×mean)</td>
                                <td>Data points are very close to mean</td>
                                <td>Precision manufacturing</td>
                            </tr>
                            <tr>
                                <td>Low (0.5×mean ≤ σ &lt; mean)</td>
                                <td>Data points are close to mean</td>
                                <td>Consistent test scores</td>
                            </tr>
                            <tr>
                                <td>Moderate (mean ≤ σ &lt; 2×mean)</td>
                                <td>Moderate spread around mean</td>
                                <td>Typical height distribution</td>
                            </tr>
                            <tr>
                                <td>High (σ ≥ 2×mean)</td>
                                <td>Data points are widely dispersed</td>
                                <td>Stock price volatility</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="tab-content" id="formulasTab" role="tabpanel" hidden>
                <div class="formula-box">
                    <strong>Population Standard Deviation</strong>
                    \[ \sigma = \sqrt{\frac{\sum_{i=1}^{N}(x_i - \mu)^2}{N}} \]<br>
                    Where:<br>
                    • σ = population standard deviation<br>
                    • xᵢ = individual data points<br>
                    • μ = population mean<br>
                    • N = population size
                </div>
                
                <div class="formula-box">
                    <strong>Sample Standard Deviation</strong>
                    \[ s = \sqrt{\frac{\sum_{i=1}^{n}(x_i - \bar{x})^2}{n-1}} \]<br>
                    Where:<br>
                    • s = sample standard deviation<br>
                    • xᵢ = individual data points<br>
                    • x̄ = sample mean<br>
                    • n = sample size<br>
                    • n-1 = Bessel's correction for unbiased estimation
                </div>
                
                <div class="formula-box">
                    <strong>Z-Score Formula</strong>
                    \[ z = \frac{x - \mu}{\sigma} \]<br>
                    Where:<br>
                    • z = z-score<br>
                    • x = individual data point<br>
                    • μ = population mean<br>
                    • σ = population standard deviation
                </div>
                
                <div class="formula-box">
                    <strong>Confidence Interval</strong>
                    \[ \text{CI} = \bar{x} \pm z_{\alpha/2} \times \frac{\sigma}{\sqrt{n}} \]<br>
                    Where:<br>
                    • x̄ = sample mean<br>
                    • z = z-score for confidence level<br>
                    • σ = population standard deviation<br>
                    • n = sample size
                </div>
            </div>
            
            <div class="tab-content" id="applicationsTab" role="tabpanel" hidden>
                <div class="formula-box">
                    <strong>Quality Control</strong>
                    Standard deviation is used in manufacturing to monitor product quality and consistency. Processes with low standard deviation produce more consistent results.
                </div>
                
                <div class="formula-box">
                    <strong>Finance and Investing</strong>
                    In finance, standard deviation measures investment risk and volatility. Higher standard deviation indicates higher risk and potential for larger price swings.
                </div>
                
                <div class="formula-box">
                    <strong>Academic Research</strong>
                    Researchers use standard deviation to understand the variability in their data and to determine if results are statistically significant.
                </div>
                
                <div class="formula-box">
                    <strong>Weather Forecasting</strong>
                    Meteorologists use standard deviation to express forecast uncertainty and the range of possible weather outcomes.
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentData = [];
        let currentResults = {};
        let charts = {
            distribution: null,
            boxPlot: null
        };
        
        // Initialize the app
        document.addEventListener('DOMContentLoaded', function() {
            // Load saved theme preference
            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-mode');
                document.getElementById('themeIcon').textContent = '☀️';
                document.getElementById('themeText').textContent = 'Light Mode';
            }
            
            // Initialize data type selection
            initializeDataTypeSelector();
            
            // Initialize advanced options
            initializeAdvancedOptions();
            
            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    calculateStatistics();
                }
            });
        });
        
        // Initialize data type selector
        function initializeDataTypeSelector() {
            const dataOptions = document.querySelectorAll('.data-option');
            dataOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active class from all options
                    dataOptions.forEach(opt => opt.classList.remove('active'));
                    
                    // Add active class to clicked option
                    this.classList.add('active');
                    
                    // Show relevant parameters
                    const dataType = this.getAttribute('data-type');
                    showDataTypeParameters(dataType);
                });
            });
        }
        
        // Show relevant parameters based on data type
        function showDataTypeParameters(dataType) {
            // Hide all parameter sections
            document.getElementById('manualParams').style.display = 'none';
            document.getElementById('populationParams').style.display = 'none';
            document.getElementById('sampleParams').style.display = 'none';
            
            // Show relevant section
            document.getElementById(dataType + 'Params').style.display = 'block';
        }
        
        // Initialize advanced options
        function initializeAdvancedOptions() {
            // Toggle hypothesis test options
            document.getElementById('hypothesisTest').addEventListener('change', function() {
                document.getElementById('hypothesisOptions').style.display = this.checked ? 'grid' : 'none';
            });
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
            
            // Update charts if they exist
            updateChartsTheme();
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
        
        // Load example data
        function loadExample(type) {
            const activeOption = document.querySelector('.data-option.active');
            const currentType = activeOption ? activeOption.getAttribute('data-type') : 'manual';
            
            if (currentType === 'manual') {
                switch(type) {
                    case 'testScores':
                        document.getElementById('dataInput').value = '85, 92, 78, 96, 88, 75, 82, 90, 87, 79, 94, 81, 89, 76, 83';
                        break;
                    case 'heights':
                        document.getElementById('dataInput').value = '165, 172, 168, 175, 162, 178, 170, 169, 174, 167, 171, 173, 166, 176, 164';
                        break;
                    case 'prices':
                        document.getElementById('dataInput').value = '45.2, 47.8, 46.5, 48.1, 44.9, 49.3, 47.1, 46.8, 48.5, 45.7, 49.8, 47.5, 46.2, 48.9, 45.5';
                        break;
                    case 'normalDist':
                        document.getElementById('dataInput').value = '12, 15, 18, 22, 25, 28, 30, 32, 35, 38, 40, 42, 45, 48, 50, 52, 55, 58, 60';
                        break;
                }
            }
            
            calculateStatistics();
        }
        
        // Show temporary message
        function showTemporaryMessage(message, type = 'info') {
            const messageDiv = document.createElement('div');
            messageDiv.className = type === 'error' ? 'error-message' : 
                                 type === 'success' ? 'success-message' : 'data-points-info';
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
        
        // Parse input data
        function parseInputData(input) {
            // Remove any non-numeric characters except commas, dots, and minus signs
            const cleanedInput = input.replace(/[^\d.,\-\s]/g, '');
            
            // Split by commas or whitespace
            const values = cleanedInput.split(/[\s,]+/).filter(val => val.trim() !== '');
            
            // Convert to numbers
            const numbers = values.map(val => {
                const num = parseFloat(val.replace(',', '.'));
                return isNaN(num) ? null : num;
            }).filter(val => val !== null);
            
            return numbers;
        }
        
        // Calculate basic statistics
        function calculateBasicStatistics(data) {
            const stats = {};
            
            // Basic calculations
            stats.count = data.length;
            stats.sum = data.reduce((a, b) => a + b, 0);
            stats.mean = stats.sum / stats.count;
            
            // Calculate variance and standard deviation
            const squaredDiffs = data.map(x => Math.pow(x - stats.mean, 2));
            const variance = squaredDiffs.reduce((a, b) => a + b, 0) / stats.count;
            const sampleVariance = squaredDiffs.reduce((a, b) => a + b, 0) / (stats.count - 1);
            
            stats.variance = variance;
            stats.sampleVariance = sampleVariance;
            stats.stdDev = Math.sqrt(variance);
            stats.sampleStdDev = Math.sqrt(sampleVariance);
            
            // Find min, max, range
            stats.min = Math.min(...data);
            stats.max = Math.max(...data);
            stats.range = stats.max - stats.min;
            
            // Calculate median
            const sorted = [...data].sort((a, b) => a - b);
            const mid = Math.floor(sorted.length / 2);
            stats.median = sorted.length % 2 !== 0 ? sorted[mid] : (sorted[mid - 1] + sorted[mid]) / 2;
            
            // Calculate quartiles
            stats.q1 = calculatePercentile(sorted, 25);
            stats.q3 = calculatePercentile(sorted, 75);
            stats.iqr = stats.q3 - stats.q1;
            
            return stats;
        }
        
        // Calculate percentile
        function calculatePercentile(sortedData, percentile) {
            const index = (percentile / 100) * (sortedData.length - 1);
            const lower = Math.floor(index);
            const upper = Math.ceil(index);
            
            if (lower === upper) {
                return sortedData[lower];
            }
            
            // Linear interpolation
            return sortedData[lower] + (sortedData[upper] - sortedData[lower]) * (index - lower);
        }
        
        // Calculate Z-scores
        function calculateZScores(data, mean, stdDev) {
            return data.map(x => (x - mean) / stdDev);
        }
        
        // Detect outliers
        function detectOutliers(data, q1, q3, iqr) {
            const lowerBound = q1 - 1.5 * iqr;
            const upperBound = q3 + 1.5 * iqr;
            
            return data.map((value, index) => ({
                value: value,
                index: index,
                isOutlier: value < lowerBound || value > upperBound
            })).filter(item => item.isOutlier);
        }
        
        // Calculate confidence interval
        function calculateConfidenceInterval(mean, stdDev, sampleSize, confidenceLevel) {
            // Z-scores for common confidence levels
            const zScores = {
                0.90: 1.645,
                0.95: 1.96,
                0.99: 2.576,
                0.999: 3.291
            };
            
            const z = zScores[confidenceLevel] || 1.96;
            const marginOfError = z * (stdDev / Math.sqrt(sampleSize));
            
            return {
                lower: mean - marginOfError,
                upper: mean + marginOfError,
                marginOfError: marginOfError,
                zScore: z
            };
        }
        
        // Perform hypothesis test
        function performHypothesisTest(sampleMean, populationMean, stdDev, sampleSize, testType, alpha) {
            // Calculate test statistic (Z-test)
            const zStatistic = (sampleMean - populationMean) / (stdDev / Math.sqrt(sampleSize));
            
            // Determine critical values based on test type
            let criticalValue, pValue;
            
            switch(testType) {
                case 'two-tailed':
                    criticalValue = jStat.normal.inv(1 - alpha/2, 0, 1);
                    pValue = 2 * (1 - jStat.normal.cdf(Math.abs(zStatistic), 0, 1));
                    break;
                case 'left-tailed':
                    criticalValue = jStat.normal.inv(alpha, 0, 1);
                    pValue = jStat.normal.cdf(zStatistic, 0, 1);
                    break;
                case 'right-tailed':
                    criticalValue = jStat.normal.inv(1 - alpha, 0, 1);
                    pValue = 1 - jStat.normal.cdf(zStatistic, 0, 1);
                    break;
            }
            
            // Determine if we reject the null hypothesis
            let rejectNull = false;
            switch(testType) {
                case 'two-tailed':
                    rejectNull = Math.abs(zStatistic) > criticalValue;
                    break;
                case 'left-tailed':
                    rejectNull = zStatistic < criticalValue;
                    break;
                case 'right-tailed':
                    rejectNull = zStatistic > criticalValue;
                    break;
            }
            
            return {
                zStatistic: zStatistic,
                criticalValue: criticalValue,
                pValue: pValue,
                rejectNull: rejectNull,
                testType: testType,
                alpha: alpha
            };
        }
        
        // Main calculation function
        function calculateStatistics() {
            try {
                const calculateBtn = document.getElementById('calculateBtn');
                const activeOption = document.querySelector('.data-option.active');
                const dataType = activeOption ? activeOption.getAttribute('data-type') : 'manual';
                
                // Show loading state
                if (calculateBtn) {
                    calculateBtn.innerHTML = '<div class="loading"></div> Calculating...';
                    calculateBtn.disabled = true;
                }
                
                // Use setTimeout to allow UI to update before heavy calculation
                setTimeout(() => {
                    try {
                        let data = [];
                        let stats = {};
                        
                        // Process data based on type
                        switch(dataType) {
                            case 'manual':
                                const input = document.getElementById('dataInput').value;
                                data = parseInputData(input);
                                if (data.length < 2) {
                                    throw new Error('Please enter at least 2 data points');
                                }
                                stats = calculateBasicStatistics(data);
                                break;
                                
                            case 'population':
                                const popMean = parseFloat(document.getElementById('popMean').value) || 0;
                                const popStdDev = parseFloat(document.getElementById('popStdDev').value) || 0;
                                const popSize = parseInt(document.getElementById('popSize').value) || 0;
                                
                                if (popStdDev < 0) {
                                    throw new Error('Standard deviation cannot be negative');
                                }
                                if (popSize < 1) {
                                    throw new Error('Population size must be at least 1');
                                }
                                
                                // Generate sample data for visualization (not used for calculations)
                                data = generateNormalData(popMean, popStdDev, 100);
                                stats = {
                                    mean: popMean,
                                    stdDev: popStdDev,
                                    variance: Math.pow(popStdDev, 2),
                                    count: popSize,
                                    min: popMean - 3 * popStdDev,
                                    max: popMean + 3 * popStdDev,
                                    range: 6 * popStdDev
                                };
                                break;
                                
                            case 'sample':
                                const sampleMean = parseFloat(document.getElementById('sampleMean').value) || 0;
                                const sampleStdDev = parseFloat(document.getElementById('sampleStdDev').value) || 0;
                                const sampleSize = parseInt(document.getElementById('sampleSize').value) || 0;
                                
                                if (sampleStdDev < 0) {
                                    throw new Error('Standard deviation cannot be negative');
                                }
                                if (sampleSize < 2) {
                                    throw new Error('Sample size must be at least 2');
                                }
                                
                                // Generate sample data for visualization
                                data = generateNormalData(sampleMean, sampleStdDev, 100);
                                stats = {
                                    mean: sampleMean,
                                    sampleStdDev: sampleStdDev,
                                    sampleVariance: Math.pow(sampleStdDev, 2),
                                    count: sampleSize,
                                    min: sampleMean - 3 * sampleStdDev,
                                    max: sampleMean + 3 * sampleStdDev,
                                    range: 6 * sampleStdDev
                                };
                                break;
                        }
                        
                        currentData = data;
                        
                        // Calculate additional statistics if we have actual data
                        if (dataType === 'manual') {
                            // Calculate Z-scores if requested
                            const zScores = document.getElementById('calcZScore').checked ? 
                                calculateZScores(data, stats.mean, stats.stdDev) : null;
                            
                            // Detect outliers if requested
                            const outliers = document.getElementById('detectOutliers').checked ? 
                                detectOutliers(data, stats.q1, stats.q3, stats.iqr) : null;
                            
                            // Calculate confidence interval if requested
                            let confidenceInterval = null;
                            if (document.getElementById('confidenceInterval').checked) {
                                const confidenceLevel = document.getElementById('confidenceLevel').value;
                                confidenceInterval = calculateConfidenceInterval(
                                    stats.mean, 
                                    stats.stdDev, 
                                    stats.count, 
                                    confidenceLevel
                                );
                            }
                            
                            // Perform hypothesis test if requested
                            let hypothesisTest = null;
                            if (document.getElementById('hypothesisTest').checked) {
                                const testMean = parseFloat(document.getElementById('testMean').value) || 0;
                                const testType = document.getElementById('testType').value;
                                const alpha = parseFloat(document.getElementById('significanceLevel').value);
                                
                                hypothesisTest = performHypothesisTest(
                                    stats.mean,
                                    testMean,
                                    stats.stdDev,
                                    stats.count,
                                    testType,
                                    alpha
                                );
                            }
                            
                            // Store results
                            currentResults = {
                                data: data,
                                stats: stats,
                                zScores: zScores,
                                outliers: outliers,
                                confidenceInterval: confidenceInterval,
                                hypothesisTest: hypothesisTest,
                                type: dataType
                            };
                        } else {
                            // For population/sample input, we only have summary statistics
                            currentResults = {
                                data: data,
                                stats: stats,
                                type: dataType
                            };
                        }
                        
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
                            calculateBtn.innerHTML = '<span>Calculate Statistics</span>';
                            calculateBtn.disabled = false;
                        }
                    }
                }, 100);
            } catch (error) {
                console.error('Error in calculateStatistics:', error);
                showTemporaryMessage('An error occurred during calculation', 'error');
            }
        }
        
        // Generate normal distribution data for visualization
        function generateNormalData(mean, stdDev, count) {
            const data = [];
            for (let i = 0; i < count; i++) {
                // Box-Muller transform for normal distribution
                let u = 0, v = 0;
                while(u === 0) u = Math.random();
                while(v === 0) v = Math.random();
                const normal = Math.sqrt(-2.0 * Math.log(u)) * Math.cos(2.0 * Math.PI * v);
                data.push(mean + normal * stdDev);
            }
            return data;
        }
        
        function displayResults() {
            try {
                const {
                    data,
                    stats,
                    zScores,
                    outliers,
                    confidenceInterval,
                    hypothesisTest,
                    type
                } = currentResults;
                
                let html = '';
                
                // Data overview
                html += `<div class="data-display">
                    <strong>📋 Data Overview</strong>
                    <div style="font-family:'JetBrains Mono',monospace;font-size:0.9rem;margin-top:10px;line-height:1.6;">
                        ${type === 'manual' ? 
                            `Data points: ${data.slice(0, 10).map(v => v.toFixed(2)).join(', ')}${data.length > 10 ? ', ...' : ''}` :
                            `Summary statistics provided (${type} data)`
                        }
                    </div>
                    <div style="margin-top:10px;font-size:0.85rem;color:var(--gray);">
                        ${type === 'manual' ? `Total values: ${data.length}` : 'Using provided parameters'}
                    </div>
                </div>`;
                
                // Main statistics grid
                html += `<div class="stats-grid">
                    <div class="result-box">
                        <div class="result-label">${type === 'manual' ? 'Mean' : (type === 'population' ? 'Population Mean (μ)' : 'Sample Mean (x̄)')}</div>
                        <div class="result-value">${stats.mean.toFixed(6)}</div>
                    </div>
                    <div class="result-box" style="border-left-color:var(--primary);">
                        <div class="result-label">${type === 'manual' ? 'Standard Deviation' : (type === 'population' ? 'Population Std Dev (σ)' : 'Sample Std Dev (s)')}</div>
                        <div class="result-value" style="color:var(--primary);">${(type === 'sample' ? stats.sampleStdDev : stats.stdDev).toFixed(6)}</div>
                    </div>
                    <div class="result-box" style="border-left-color:var(--info);">
                        <div class="result-label">${type === 'manual' ? 'Variance' : (type === 'population' ? 'Population Variance' : 'Sample Variance')}</div>
                        <div class="result-value" style="color:var(--info);">${(type === 'sample' ? stats.sampleVariance : stats.variance).toFixed(6)}</div>
                    </div>
                    <div class="result-box" style="border-left-color:var(--success);">
                        <div class="result-label">Data Points</div>
                        <div class="result-value" style="color:var(--success);">${stats.count}</div>
                    </div>
                </div>`;
                
                // Additional statistics for manual data
                if (type === 'manual') {
                    html += `<div class="stats-grid">
                        <div class="result-box">
                            <div class="result-label">Minimum</div>
                            <div class="result-value">${stats.min.toFixed(6)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:var(--warning);">
                            <div class="result-label">Maximum</div>
                            <div class="result-value" style="color:var(--warning);">${stats.max.toFixed(6)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:var(--secondary);">
                            <div class="result-label">Range</div>
                            <div class="result-value" style="color:var(--secondary);">${stats.range.toFixed(6)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:var(--danger);">
                            <div class="result-label">Median</div>
                            <div class="result-value" style="color:var(--danger);">${stats.median.toFixed(6)}</div>
                        </div>
                    </div>`;
                }
                
                // Charts
                html += `<div class="chart-container">
                    <canvas id="distributionChart"></canvas>
                </div>`;
                
                if (type === 'manual') {
                    html += `<div class="chart-container">
                        <canvas id="boxPlotChart"></canvas>
                    </div>`;
                }
                
                // Z-scores display
                if (zScores && zScores.length > 0) {
                    html += `<div class="step-box">
                        <strong>📈 Z-Scores Analysis</strong>
                        <div class="z-score-display">`;
                    
                    for (let i = 0; i < Math.min(zScores.length, 15); i++) {
                        html += `<div class="z-score-item">
                            <span>Value ${i+1}: ${data[i].toFixed(2)}</span>
                            <span>Z-score: ${zScores[i].toFixed(4)}</span>
                        </div>`;
                    }
                    
                    if (zScores.length > 15) {
                        html += `<div class="z-score-item" style="justify-content: center; color: var(--gray);">
                            ... and ${zScores.length - 15} more z-scores
                        </div>`;
                    }
                    
                    html += `</div></div>`;
                }
                
                // Outlier detection
                if (outliers && outliers.length > 0) {
                    html += `<div class="outlier-detection">
                        <strong>⚠️ Outlier Detection</strong>
                        <div style="margin-top:12px;">
                            <div class="step">Lower bound: ${(stats.q1 - 1.5 * stats.iqr).toFixed(4)}</div>
                            <div class="step">Upper bound: ${(stats.q3 + 1.5 * stats.iqr).toFixed(4)}</div>
                            <div class="step" style="font-weight:600;color:var(--warning);margin-top:8px;">
                                Found ${outliers.length} potential outliers
                            </div>
                        </div>`;
                    
                    if (outliers.length > 0) {
                        html += `<div class="z-score-display" style="margin-top:12px;">`;
                        outliers.forEach(outlier => {
                            html += `<div class="z-score-item">
                                <span>Index ${outlier.index + 1}: ${outlier.value.toFixed(2)}</span>
                                <span style="color:var(--warning);">Outlier</span>
                            </div>`;
                        });
                        html += `</div>`;
                    }
                    
                    html += `</div>`;
                } else if (outliers && outliers.length === 0) {
                    html += `<div class="interpretation">
                        <strong>✅ No Outliers Detected</strong>
                        <div style="margin-top:8px;">All data points fall within the expected range based on the interquartile range method.</div>
                    </div>`;
                }
                
                // Confidence interval
                if (confidenceInterval) {
                    const confidencePercent = (parseFloat(confidenceLevel) * 100).toFixed(1);
                    html += `<div class="confidence-interval">
                        <strong>📊 Confidence Interval</strong>
                        <div style="margin-top:12px;">
                            <div class="step">Confidence Level: ${confidencePercent}%</div>
                            <div class="step">Z-score: ${confidenceInterval.zScore.toFixed(4)}</div>
                            <div class="step">Margin of Error: ±${confidenceInterval.marginOfError.toFixed(4)}</div>
                            <div class="step" style="font-weight:600;color:var(--info);margin-top:8px;">
                                ${confidenceInterval.lower.toFixed(4)} ≤ μ ≤ ${confidenceInterval.upper.toFixed(4)}
                            </div>
                        </div>
                    </div>`;
                }
                
                // Hypothesis test
                if (hypothesisTest) {
                    html += `<div class="hypothesis-test">
                        <strong>🔍 Hypothesis Test Results</strong>
                        <div style="margin-top:12px;">
                            <div class="step">Test Type: ${hypothesisTest.testType}</div>
                            <div class="step">Significance Level: α = ${hypothesisTest.alpha}</div>
                            <div class="step">Z-statistic: ${hypothesisTest.zStatistic.toFixed(4)}</div>
                            <div class="step">Critical Value: ${hypothesisTest.criticalValue.toFixed(4)}</div>
                            <div class="step">P-value: ${hypothesisTest.pValue.toFixed(6)}</div>
                            <div class="step" style="font-weight:600;color:${hypothesisTest.rejectNull ? 'var(--danger)' : 'var(--success)'};margin-top:8px;">
                                ${hypothesisTest.rejectNull ? 'Reject the null hypothesis' : 'Fail to reject the null hypothesis'}
                            </div>
                        </div>
                    </div>`;
                }
                
                // Distribution analysis
                if (type === 'manual') {
                    html += `<div class="distribution-analysis">
                        <strong>📐 Distribution Analysis</strong>
                        <div style="margin-top:12px;">
                            <div class="step">Q1 (25th percentile): ${stats.q1.toFixed(4)}</div>
                            <div class="step">Q3 (75th percentile): ${stats.q3.toFixed(4)}</div>
                            <div class="step">Interquartile Range (IQR): ${stats.iqr.toFixed(4)}</div>
                            <div class="step">Coefficient of Variation: ${(stats.stdDev / stats.mean * 100).toFixed(2)}%</div>
                        </div>
                    </div>`;
                }
                
                // Interpretation
                html += `<div class="interpretation">
                    <strong>💡 Statistical Interpretation</strong>
                    <div style="margin-top:10px;">
                        <div class="step">• The data ${stats.stdDev/stats.mean < 0.1 ? 'shows low variability' : stats.stdDev/stats.mean < 0.3 ? 'shows moderate variability' : 'shows high variability'} around the mean.</div>
                        <div class="step">• Approximately 68% of values fall within ${(stats.mean - stats.stdDev).toFixed(2)} and ${(stats.mean + stats.stdDev).toFixed(2)} (mean ± 1σ)</div>
                        <div class="step">• Approximately 95% of values fall within ${(stats.mean - 2*stats.stdDev).toFixed(2)} and ${(stats.mean + 2*stats.stdDev).toFixed(2)} (mean ± 2σ)</div>
                        <div class="step">• Approximately 99.7% of values fall within ${(stats.mean - 3*stats.stdDev).toFixed(2)} and ${(stats.mean + 3*stats.stdDev).toFixed(2)} (mean ± 3σ)</div>
                    </div>
                </div>`;
                
                const output = document.getElementById('output');
                if (output) {
                    output.innerHTML = html;
                }
                
                // Create charts
                createCharts(data, stats);
            } catch (error) {
                console.error('Error displaying results:', error);
                const output = document.getElementById('output');
                if (output) {
                    output.innerHTML = `<div class="error-message">❌ Error displaying results: ${error.message}</div>`;
                }
            }
        }
        
        function createCharts(data, stats) {
            createDistributionChart(data, stats);
            if (currentResults.type === 'manual') {
                createBoxPlotChart(data, stats);
            }
        }
        
        function createDistributionChart(data, stats) {
            try {
                // Destroy existing chart if it exists
                if (charts.distribution) {
                    charts.distribution.destroy();
                }
                
                const ctx = document.getElementById('distributionChart');
                if (!ctx) {
                    console.error('Distribution chart canvas not found');
                    return;
                }
                
                const chartContext = ctx.getContext('2d');
                
                // Get theme colors
                const isDark = document.body.classList.contains('dark-mode');
                const backgroundColor = isDark ? 'rgba(67, 97, 238, 0.7)' : 'rgba(67, 97, 238, 0.7)';
                const borderColor = isDark ? 'rgba(67, 97, 238, 1)' : 'rgba(67, 97, 238, 1)';
                const textColor = isDark ? '#ffffff' : '#666666';
                
                // Create histogram data
                const histogram = createHistogram(data, 10);
                
                charts.distribution = new Chart(chartContext, {
                    type: 'bar',
                    data: {
                        labels: histogram.labels,
                        datasets: [{
                            label: 'Frequency',
                            data: histogram.values,
                            backgroundColor: backgroundColor,
                            borderColor: borderColor,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Data Distribution',
                                font: {
                                    size: 16
                                },
                                color: textColor
                            },
                            legend: {
                                labels: {
                                    color: textColor
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Value Range',
                                    color: textColor
                                },
                                ticks: {
                                    color: textColor
                                },
                                grid: {
                                    color: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Frequency',
                                    color: textColor
                                },
                                ticks: {
                                    color: textColor
                                },
                                grid: {
                                    color: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating distribution chart:', error);
            }
        }
        
        function createBoxPlotChart(data, stats) {
            try {
                // Destroy existing chart if it exists
                if (charts.boxPlot) {
                    charts.boxPlot.destroy();
                }
                
                const ctx = document.getElementById('boxPlotChart');
                if (!ctx) {
                    console.error('Box plot chart canvas not found');
                    return;
                }
                
                const chartContext = ctx.getContext('2d');
                
                // Get theme colors
                const isDark = document.body.classList.contains('dark-mode');
                const boxColor = isDark ? 'rgba(255, 99, 132, 0.7)' : 'rgba(255, 99, 132, 0.7)';
                const lineColor = isDark ? 'rgba(255, 99, 132, 1)' : 'rgba(255, 99, 132, 1)';
                const textColor = isDark ? '#ffffff' : '#666666';
                
                // Prepare box plot data
                const boxPlotData = {
                    min: stats.min,
                    q1: stats.q1,
                    median: stats.median,
                    q3: stats.q3,
                    max: stats.max
                };
                
                // For simplicity, we'll create a custom box plot using a bar chart with error bars
                // In a real implementation, you might want to use a specialized box plot library
                charts.boxPlot = new Chart(chartContext, {
                    type: 'bar',
                    data: {
                        labels: ['Box Plot'],
                        datasets: [{
                            label: 'Data Distribution',
                            data: [stats.median],
                            backgroundColor: boxColor,
                            borderColor: lineColor,
                            borderWidth: 2,
                            // We'll use error bars to show the range
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Box Plot (Q1, Median, Q3)',
                                font: {
                                    size: 16
                                },
                                color: textColor
                            },
                            legend: {
                                labels: {
                                    color: textColor
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return [
                                            `Min: ${boxPlotData.min.toFixed(2)}`,
                                            `Q1: ${boxPlotData.q1.toFixed(2)}`,
                                            `Median: ${boxPlotData.median.toFixed(2)}`,
                                            `Q3: ${boxPlotData.q3.toFixed(2)}`,
                                            `Max: ${boxPlotData.max.toFixed(2)}`
                                        ];
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: textColor
                                },
                                grid: {
                                    color: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Values',
                                    color: textColor
                                },
                                ticks: {
                                    color: textColor
                                },
                                grid: {
                                    color: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating box plot chart:', error);
            }
        }
        
        // Create histogram data
        function createHistogram(data, bins) {
            const min = Math.min(...data);
            const max = Math.max(...data);
            const range = max - min;
            const binSize = range / bins;
            
            const histogram = Array(bins).fill(0);
            const labels = [];
            
            for (let i = 0; i < bins; i++) {
                const binStart = min + i * binSize;
                const binEnd = binStart + binSize;
                labels.push(`${binStart.toFixed(1)}-${binEnd.toFixed(1)}`);
                
                histogram[i] = data.filter(value => 
                    value >= binStart && (i === bins - 1 ? value <= binEnd : value < binEnd)
                ).length;
            }
            
            return {
                values: histogram,
                labels: labels
            };
        }
        
        function updateChartsTheme() {
            // Update existing charts with new theme
            Object.values(charts).forEach(chart => {
                if (chart) {
                    try {
                        chart.update('none'); // Update without animation
                    } catch (error) {
                        console.error('Error updating chart theme:', error);
                    }
                }
            });
        }
        
        function exportResults() {
            try {
                if (!currentResults.data || currentResults.data.length === 0) {
                    showTemporaryMessage('No data to export', 'error');
                    return;
                }
                
                let csvContent = "Statistical Analysis Results\n\n";
                
                if (currentResults.type === 'manual') {
                    csvContent += "Data Point,Value,Z-Score\n";
                    
                    for (let i = 0; i < currentResults.data.length; i++) {
                        const zScore = currentResults.zScores ? currentResults.zScores[i].toFixed(4) : 'N/A';
                        csvContent += `${i+1},${currentResults.data[i]},${zScore}\n`;
                    }
                    
                    csvContent += "\nSummary Statistics\n";
                    csvContent += `Data Points,${currentResults.stats.count}\n`;
                    csvContent += `Mean,${currentResults.stats.mean}\n`;
                    csvContent += `Standard Deviation,${currentResults.stats.stdDev}\n`;
                    csvContent += `Variance,${currentResults.stats.variance}\n`;
                    csvContent += `Minimum,${currentResults.stats.min}\n`;
                    csvContent += `Maximum,${currentResults.stats.max}\n`;
                    csvContent += `Range,${currentResults.stats.range}\n`;
                    csvContent += `Median,${currentResults.stats.median}\n`;
                    csvContent += `Q1,${currentResults.stats.q1}\n`;
                    csvContent += `Q3,${currentResults.stats.q3}\n`;
                    csvContent += `IQR,${currentResults.stats.iqr}\n`;
                    
                    if (currentResults.outliers && currentResults.outliers.length > 0) {
                        csvContent += `Outliers Found,${currentResults.outliers.length}\n`;
                    }
                    
                    if (currentResults.confidenceInterval) {
                        csvContent += `Confidence Lower,${currentResults.confidenceInterval.lower}\n`;
                        csvContent += `Confidence Upper,${currentResults.confidenceInterval.upper}\n`;
                        csvContent += `Margin of Error,${currentResults.confidenceInterval.marginOfError}\n`;
                    }
                } else {
                    csvContent += "Parameter,Value\n";
                    csvContent += `Data Type,${currentResults.type}\n`;
                    csvContent += `Mean,${currentResults.stats.mean}\n`;
                    csvContent += `Standard Deviation,${currentResults.stats.stdDev}\n`;
                    csvContent += `Variance,${currentResults.stats.variance}\n`;
                    csvContent += `Data Points,${currentResults.stats.count}\n`;
                }
                
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.setAttribute("href", url);
                link.setAttribute("download", "statistical_analysis.csv");
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
                if (!currentResults.data || currentResults.data.length === 0) {
                    showTemporaryMessage('No data to generate report', 'error');
                    return;
                }
                
                const reportWindow = window.open('', '_blank');
                if (!reportWindow) {
                    showTemporaryMessage('Please allow pop-ups to generate report', 'error');
                    return;
                }
                
                const { stats, type } = currentResults;
                
                reportWindow.document.write(`
                    <html>
                        <head>
                            <title>Statistical Analysis Report</title>
                            <style>
                                body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
                                h1 { color: #4361ee; border-bottom: 2px solid #4361ee; padding-bottom: 10px; }
                                .stat-box { background: #f8f9fa; padding: 15px; margin: 15px 0; border-radius: 8px; }
                                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                                th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
                                th { background: #4361ee; color: white; }
                                .data-preview { font-family: 'Courier New', monospace; background: #f8f9fa; padding: 15px; border-radius: 5px; }
                            </style>
                        </head>
                        <body>
                            <h1>Statistical Analysis Report</h1>
                            
                            <div class="stat-box">
                                <h2>Data Summary</h2>
                                <p><strong>Data Type:</strong> ${type}</p>
                                <p><strong>Number of Data Points:</strong> ${stats.count}</p>
                                ${type === 'manual' ? 
                                    `<p><strong>Data Preview:</strong> <span class="data-preview">${currentResults.data.slice(0, 10).map(v => v.toFixed(2)).join(', ')}${currentResults.data.length > 10 ? ', ...' : ''}</span></p>` :
                                    ''
                                }
                            </div>
                            
                            <div class="stat-box">
                                <h2>Descriptive Statistics</h2>
                                <table>
                                    <tr><th>Statistic</th><th>Value</th></tr>
                                    <tr><td>Mean</td><td>${stats.mean.toFixed(6)}</td></tr>
                                    <tr><td>Standard Deviation</td><td>${stats.stdDev.toFixed(6)}</td></tr>
                                    <tr><td>Variance</td><td>${stats.variance.toFixed(6)}</td></tr>
                                    ${type === 'manual' ? `
                                        <tr><td>Minimum</td><td>${stats.min.toFixed(6)}</td></tr>
                                        <tr><td>Maximum</td><td>${stats.max.toFixed(6)}</td></tr>
                                        <tr><td>Range</td><td>${stats.range.toFixed(6)}</td></tr>
                                        <tr><td>Median</td><td>${stats.median.toFixed(6)}</td></tr>
                                        <tr><td>Q1 (25th percentile)</td><td>${stats.q1.toFixed(6)}</td></tr>
                                        <tr><td>Q3 (75th percentile)</td><td>${stats.q3.toFixed(6)}</td></tr>
                                        <tr><td>Interquartile Range</td><td>${stats.iqr.toFixed(6)}</td></tr>
                                    ` : ''}
                                </table>
                            </div>
                            
                            ${currentResults.confidenceInterval ? `
                            <div class="stat-box">
                                <h2>Confidence Interval</h2>
                                <table>
                                    <tr><th>Parameter</th><th>Value</th></tr>
                                    <tr><td>Confidence Level</td><td>${(parseFloat(document.getElementById('confidenceLevel').value) * 100).toFixed(1)}%</td></tr>
                                    <tr><td>Lower Bound</td><td>${currentResults.confidenceInterval.lower.toFixed(6)}</td></tr>
                                    <tr><td>Upper Bound</td><td>${currentResults.confidenceInterval.upper.toFixed(6)}</td></tr>
                                    <tr><td>Margin of Error</td><td>${currentResults.confidenceInterval.marginOfError.toFixed(6)}</td></tr>
                                </table>
                            </div>
                            ` : ''}
                            
                            ${currentResults.hypothesisTest ? `
                            <div class="stat-box">
                                <h2>Hypothesis Test</h2>
                                <table>
                                    <tr><th>Parameter</th><th>Value</th></tr>
                                    <tr><td>Test Type</td><td>${currentResults.hypothesisTest.testType}</td></tr>
                                    <tr><td>Significance Level</td><td>α = ${currentResults.hypothesisTest.alpha}</td></tr>
                                    <tr><td>Z-statistic</td><td>${currentResults.hypothesisTest.zStatistic.toFixed(6)}</td></tr>
                                    <tr><td>P-value</td><td>${currentResults.hypothesisTest.pValue.toFixed(6)}</td></tr>
                                    <tr><td>Conclusion</td><td>${currentResults.hypothesisTest.rejectNull ? 'Reject the null hypothesis' : 'Fail to reject the null hypothesis'}</td></tr>
                                </table>
                            </div>
                            ` : ''}
                            
                            <div class="stat-box">
                                <h2>Interpretation</h2>
                                <p>The data shows ${stats.stdDev/stats.mean < 0.1 ? 'low variability' : stats.stdDev/stats.mean < 0.3 ? 'moderate variability' : 'high variability'} 
                                with a standard deviation of ${stats.stdDev.toFixed(4)}. This indicates that the data points are 
                                ${stats.stdDev/stats.mean < 0.1 ? 'very close to the mean value' : stats.stdDev/stats.mean < 0.3 ? 'moderately spread around the mean' : 'widely dispersed around the mean'}.</p>
                            </div>
                            
                            <p><em>Report generated on ${new Date().toLocaleString()}</em></p>
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
                // Reset form values based on active data type
                const activeOption = document.querySelector('.data-option.active');
                const dataType = activeOption ? activeOption.getAttribute('data-type') : 'manual';
                
                switch(dataType) {
                    case 'manual':
                        document.getElementById('dataInput').value = '12, 15, 18, 22, 25, 28, 30';
                        break;
                    case 'population':
                        document.getElementById('popMean').value = '100';
                        document.getElementById('popStdDev').value = '15';
                        document.getElementById('popSize').value = '1000';
                        break;
                    case 'sample':
                        document.getElementById('sampleMean').value = '105';
                        document.getElementById('sampleStdDev').value = '12';
                        document.getElementById('sampleSize').value = '50';
                        break;
                }
                
                // Reset advanced options
                document.getElementById('hypothesisTest').checked = false;
                document.getElementById('hypothesisOptions').style.display = 'none';
                
                const result = document.getElementById('result');
                if (result) {
                    result.classList.remove('show');
                }
                
                currentData = [];
                currentResults = {};
                
                // Clear charts
                Object.values(charts).forEach(chart => {
                    if (chart) {
                        try {
                            chart.destroy();
                        } catch (error) {
                            console.error('Error destroying chart:', error);
                        }
                    }
                });
                charts = {
                    distribution: null,
                    boxPlot: null
                };
                
                showTemporaryMessage('All data cleared successfully!', 'success');
            } catch (error) {
                console.error('Error clearing data:', error);
                showTemporaryMessage('Error clearing data', 'error');
            }
        }
        
        // Simple jStat implementation for statistical functions
        const jStat = {
            normal: {
                cdf: function(x, mean, std) {
                    mean = mean || 0;
                    std = std || 1;
                    return 0.5 * (1 + this.erf((x - mean) / (std * Math.sqrt(2))));
                },
                inv: function(p, mean, std) {
                    mean = mean || 0;
                    std = std || 1;
                    return mean - std * Math.sqrt(2) * this.erfcinv(2 * p);
                },
                erf: function(x) {
                    // Abramowitz and Stegun approximation
                    const a1 =  0.254829592;
                    const a2 = -0.284496736;
                    const a3 =  1.421413741;
                    const a4 = -1.453152027;
                    const a5 =  1.061405429;
                    const p  =  0.3275911;
                    
                    const sign = (x < 0) ? -1 : 1;
                    x = Math.abs(x);
                    
                    const t = 1.0 / (1.0 + p * x);
                    const y = 1.0 - (((((a5 * t + a4) * t) + a3) * t + a2) * t + a1) * t * Math.exp(-x * x);
                    
                    return sign * y;
                },
                erfcinv: function(p) {
                    // Approximation for inverse complementary error function
                    if (p >= 2) return -100;
                    if (p <= 0) return 100;
                    
                    const pp = (p < 1) ? p : 2 - p;
                    const t = Math.sqrt(-2 * Math.log(pp / 2));
                    
                    let x = -0.70711 * ((2.30753 + t * 0.27061) / (1 + t * (0.99229 + t * 0.04481)) - t);
                    
                    for (let i = 0; i < 2; i++) {
                        const err = this.erfc(x) - pp;
                        x += err / (1.12837916709551257 * Math.exp(-x * x) - x * err);
                    }
                    
                    return (p < 1) ? x : -x;
                },
                erfc: function(x) {
                    return 1 - this.erf(x);
                }
            }
        };
    </script>
</body>
</html>