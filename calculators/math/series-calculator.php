<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Series Calculator</title>
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

        .series-type-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .series-option {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: var(--transition);
        }

        .dark-mode .series-option {
            background: var(--bg-secondary);
        }

        .series-option.active {
            border-color: var(--primary);
            background: rgba(67, 97, 238, 0.1);
        }

        .series-option h3 {
            margin-bottom: 8px;
            color: var(--primary);
        }

        .series-option p {
            font-size: 0.85rem;
            color: var(--gray);
        }

        .dark-mode .series-option p {
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

        .convergence-test {
            background: linear-gradient(135deg, #e8f5e9 0%, #f3e5f5 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #4caf50;
        }

        .dark-mode .convergence-test {
            background: linear-gradient(135deg, #1b3a1f 0%, #2d1b4e 100%);
        }

        .partial-sums {
            max-height: 300px;
            overflow-y: auto;
            margin: 15px 0;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
        }

        .dark-mode .partial-sums {
            background: var(--bg-secondary);
        }

        .term-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
            font-family: 'JetBrains Mono', monospace;
        }

        .dark-mode .term-item {
            border-bottom-color: var(--border-color);
        }

        .term-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>∑ Advanced Series Calculator</h1>
            <p>Calculate arithmetic, geometric, harmonic series with convergence tests, partial sums, and advanced analysis</p>
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
                    <span>∑</span>
                    <h2>Series Configuration</h2>
                </div>
                
                <div class="input-section">
                    <label for="seriesType">Select Series Type</label>
                    <div class="series-type-selector">
                        <div class="series-option active" data-type="arithmetic">
                            <h3>Arithmetic Series</h3>
                            <p>a, a+d, a+2d, a+3d, ...</p>
                        </div>
                        <div class="series-option" data-type="geometric">
                            <h3>Geometric Series</h3>
                            <p>a, ar, ar², ar³, ...</p>
                        </div>
                        <div class="series-option" data-type="harmonic">
                            <h3>Harmonic Series</h3>
                            <p>1, 1/2, 1/3, 1/4, ...</p>
                        </div>
                        <div class="series-option" data-type="custom">
                            <h3>Custom Series</h3>
                            <p>Define your own sequence</p>
                        </div>
                    </div>
                </div>
                
                <div class="input-section" id="arithmeticParams">
                    <label>Arithmetic Series Parameters</label>
                    <div class="param-inputs">
                        <div class="param-group">
                            <label for="firstTerm">First Term (a)</label>
                            <input type="number" id="firstTerm" value="2" step="any">
                        </div>
                        <div class="param-group">
                            <label for="commonDiff">Common Difference (d)</label>
                            <input type="number" id="commonDiff" value="3" step="any">
                        </div>
                        <div class="param-group">
                            <label for="numTerms">Number of Terms (n)</label>
                            <input type="number" id="numTerms" value="10" min="2" max="1000">
                        </div>
                    </div>
                </div>
                
                <div class="input-section" id="geometricParams" style="display: none;">
                    <label>Geometric Series Parameters</label>
                    <div class="param-inputs">
                        <div class="param-group">
                            <label for="geoFirstTerm">First Term (a)</label>
                            <input type="number" id="geoFirstTerm" value="2" step="any">
                        </div>
                        <div class="param-group">
                            <label for="commonRatio">Common Ratio (r)</label>
                            <input type="number" id="commonRatio" value="0.5" step="any">
                        </div>
                        <div class="param-group">
                            <label for="geoNumTerms">Number of Terms (n)</label>
                            <input type="number" id="geoNumTerms" value="10" min="2" max="1000">
                        </div>
                    </div>
                </div>
                
                <div class="input-section" id="harmonicParams" style="display: none;">
                    <label>Harmonic Series Parameters</label>
                    <div class="param-inputs">
                        <div class="param-group">
                            <label for="harmonicType">Harmonic Type</label>
                            <select id="harmonicType">
                                <option value="standard">Standard (1/n)</option>
                                <option value="alternating">Alternating (-1)^(n+1)/n</option>
                                <option value="p-series">p-Series (1/n^p)</option>
                            </select>
                        </div>
                        <div class="param-group">
                            <label for="pValue">p Value (for p-Series)</label>
                            <input type="number" id="pValue" value="1" step="0.1" min="0.1">
                        </div>
                        <div class="param-group">
                            <label for="harmonicNumTerms">Number of Terms (n)</label>
                            <input type="number" id="harmonicNumTerms" value="10" min="2" max="1000">
                        </div>
                    </div>
                </div>
                
                <div class="input-section" id="customParams" style="display: none;">
                    <label for="customSequence">Custom Sequence Definition</label>
                    <textarea id="customSequence" rows="4" placeholder="Enter terms separated by commas or define a function f(n) = ...">1, 4, 9, 16, 25, 36</textarea>
                    <div class="input-hint">Enter terms separated by commas OR define a function like: f(n) = n^2</div>
                </div>
                
                <div class="advanced-options">
                    <h3>⚙️ Advanced Options</h3>
                    <div class="options-grid">
                        <div class="option-group">
                            <label for="convergenceTests">Perform Convergence Tests</label>
                            <input type="checkbox" id="convergenceTests" checked>
                        </div>
                        <div class="option-group">
                            <label for="showPartialSums">Show Partial Sums</label>
                            <input type="checkbox" id="showPartialSums" checked>
                        </div>
                        <div class="option-group">
                            <label for="maxIterations">Max Iterations (for infinite series)</label>
                            <input type="number" id="maxIterations" value="1000" min="10" max="10000">
                        </div>
                    </div>
                </div>
                
                <button class="btn" id="calculateBtn" onclick="calculateSeries()" aria-label="Calculate series">
                    <span>Calculate Series</span>
                </button>
                
                <div class="examples">
                    <button class="example-btn" onclick="loadExample('arithmetic')">1 + 2 + 3 + ...</button>
                    <button class="example-btn" onclick="loadExample('geometric')">1 + 1/2 + 1/4 + ...</button>
                    <button class="example-btn" onclick="loadExample('harmonic')">1 + 1/2 + 1/3 + ...</button>
                    <button class="example-btn" onclick="loadExample('alternating')">1 - 1/2 + 1/3 - ...</button>
                </div>
            </div>

            <div class="results-card">
                <div class="card-header">
                    <span>📈</span>
                    <h2>Series Analysis</h2>
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
                    <strong>Understanding Series Convergence</strong>
                    A series converges if the sequence of its partial sums approaches a finite limit. Divergent series either approach infinity or oscillate without settling on a finite value.
                </div>
                
                <div class="interpretation">
                    <strong>How to Interpret Results:</strong>
                    <ul style="margin-left: 20px; margin-top: 10px;">
                        <li><strong>Convergent Series:</strong> The sum approaches a finite value as more terms are added</li>
                        <li><strong>Divergent Series:</strong> The sum grows without bound or oscillates indefinitely</li>
                        <li><strong>Absolute Convergence:</strong> The series converges when all terms are made positive</li>
                        <li><strong>Conditional Convergence:</strong> The series converges but not absolutely</li>
                    </ul>
                </div>
                
                <div class="comparison-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Series Type</th>
                                <th>Convergence Condition</th>
                                <th>Sum Formula</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Arithmetic</td>
                                <td>Always diverges (unless a=d=0)</td>
                                <td>S = n/2 × (2a + (n-1)d)</td>
                            </tr>
                            <tr>
                                <td>Geometric</td>
                                <td>|r| &lt; 1</td>
                                <td>S = a(1-rⁿ)/(1-r)</td>
                            </tr>
                            <tr>
                                <td>Harmonic</td>
                                <td>Diverges</td>
                                <td>No closed form</td>
                            </tr>
                            <tr>
                                <td>p-Series</td>
                                <td>p &gt; 1</td>
                                <td>ζ(p) for infinite series</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="tab-content" id="formulasTab" role="tabpanel" hidden>
                <div class="formula-box">
                    <strong>Arithmetic Series</strong>
                    Terms: a, a+d, a+2d, a+3d, ...<br>
                    Sum of first n terms: Sₙ = n/2 × [2a + (n-1)d]<br>
                    General term: aₙ = a + (n-1)d
                </div>
                
                <div class="formula-box">
                    <strong>Geometric Series</strong>
                    Terms: a, ar, ar², ar³, ...<br>
                    Sum of first n terms: Sₙ = a(1-rⁿ)/(1-r) for r≠1<br>
                    Infinite sum: S = a/(1-r) when |r| &lt; 1<br>
                    General term: aₙ = arⁿ⁻¹
                </div>
                
                <div class="formula-box">
                    <strong>Harmonic Series</strong>
                    Terms: 1, 1/2, 1/3, 1/4, ...<br>
                    Partial sum: Hₙ = 1 + 1/2 + 1/3 + ... + 1/n<br>
                    Diverges slowly: Hₙ ≈ ln(n) + γ (Euler-Mascheroni constant)
                </div>
                
                <div class="formula-box">
                    <strong>Convergence Tests</strong>
                    Ratio Test: lim|aₙ₊₁/aₙ| &lt; 1 → converges<br>
                    Root Test: lim√[n](|aₙ|) &lt; 1 → converges<br>
                    Integral Test: ∫f(x)dx converges → series converges<br>
                    Comparison Test: Compare with known convergent/divergent series
                </div>
            </div>
            
            <div class="tab-content" id="applicationsTab" role="tabpanel" hidden>
                <div class="formula-box">
                    <strong>Financial Mathematics</strong>
                    Geometric series are used to calculate compound interest, annuities, and loan amortization schedules.
                </div>
                
                <div class="formula-box">
                    <strong>Physics and Engineering</strong>
                    Series approximations are used in signal processing, electrical circuits, and solving differential equations.
                </div>
                
                <div class="formula-box">
                    <strong>Computer Science</strong>
                    Series analysis helps in algorithm complexity analysis, especially for recursive algorithms and series summations.
                </div>
                
                <div class="formula-box">
                    <strong>Probability and Statistics</strong>
                    Geometric series appear in probability calculations, especially in scenarios involving repeated trials until success.
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentSeries = [];
        let currentResults = {};
        let charts = {
            terms: null,
            partialSums: null
        };
        
        // Initialize the app
        document.addEventListener('DOMContentLoaded', function() {
            // Load saved theme preference
            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-mode');
                document.getElementById('themeIcon').textContent = '☀️';
                document.getElementById('themeText').textContent = 'Light Mode';
            }
            
            // Initialize series type selection
            initializeSeriesTypeSelector();
            
            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    calculateSeries();
                }
            });
        });
        
        // Initialize series type selector
        function initializeSeriesTypeSelector() {
            const seriesOptions = document.querySelectorAll('.series-option');
            seriesOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active class from all options
                    seriesOptions.forEach(opt => opt.classList.remove('active'));
                    
                    // Add active class to clicked option
                    this.classList.add('active');
                    
                    // Show relevant parameters
                    const seriesType = this.getAttribute('data-type');
                    showSeriesParameters(seriesType);
                });
            });
        }
        
        // Show relevant parameters based on series type
        function showSeriesParameters(seriesType) {
            // Hide all parameter sections
            document.getElementById('arithmeticParams').style.display = 'none';
            document.getElementById('geometricParams').style.display = 'none';
            document.getElementById('harmonicParams').style.display = 'none';
            document.getElementById('customParams').style.display = 'none';
            
            // Show relevant section
            document.getElementById(seriesType + 'Params').style.display = 'block';
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
        
        // Load example series
        function loadExample(type) {
            const activeOption = document.querySelector('.series-option.active');
            const currentType = activeOption ? activeOption.getAttribute('data-type') : 'arithmetic';
            
            switch(type) {
                case 'arithmetic':
                    if (currentType === 'arithmetic') {
                        document.getElementById('firstTerm').value = 1;
                        document.getElementById('commonDiff').value = 1;
                        document.getElementById('numTerms').value = 10;
                    }
                    break;
                case 'geometric':
                    if (currentType === 'geometric') {
                        document.getElementById('geoFirstTerm').value = 1;
                        document.getElementById('commonRatio').value = 0.5;
                        document.getElementById('geoNumTerms').value = 10;
                    }
                    break;
                case 'harmonic':
                    if (currentType === 'harmonic') {
                        document.getElementById('harmonicType').value = 'standard';
                        document.getElementById('pValue').value = 1;
                        document.getElementById('harmonicNumTerms').value = 10;
                    }
                    break;
                case 'alternating':
                    if (currentType === 'harmonic') {
                        document.getElementById('harmonicType').value = 'alternating';
                        document.getElementById('pValue').value = 1;
                        document.getElementById('harmonicNumTerms').value = 10;
                    }
                    break;
            }
            
            calculateSeries();
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
        
        // Generate arithmetic series
        function generateArithmeticSeries(a, d, n) {
            const series = [];
            for (let i = 0; i < n; i++) {
                series.push(a + i * d);
            }
            return series;
        }
        
        // Generate geometric series
        function generateGeometricSeries(a, r, n) {
            const series = [];
            for (let i = 0; i < n; i++) {
                series.push(a * Math.pow(r, i));
            }
            return series;
        }
        
        // Generate harmonic series
        function generateHarmonicSeries(type, p, n) {
            const series = [];
            for (let i = 1; i <= n; i++) {
                let term;
                switch(type) {
                    case 'standard':
                        term = 1 / i;
                        break;
                    case 'alternating':
                        term = Math.pow(-1, i + 1) / i;
                        break;
                    case 'p-series':
                        term = 1 / Math.pow(i, p);
                        break;
                    default:
                        term = 1 / i;
                }
                series.push(term);
            }
            return series;
        }
        
        // Parse custom series
        function parseCustomSeries(input, n) {
            // Try to parse as comma-separated values first
            if (input.includes(',')) {
                const terms = input.split(',').map(term => {
                    const trimmed = term.trim();
                    // Try to evaluate mathematical expressions
                    try {
                        return eval(trimmed);
                    } catch (e) {
                        return parseFloat(trimmed);
                    }
                }).filter(term => !isNaN(term));
                
                if (terms.length >= n) {
                    return terms.slice(0, n);
                } else if (terms.length > 0) {
                    // If we have fewer terms than requested, try to detect pattern
                    return detectPatternAndExtend(terms, n);
                }
            }
            
            // Try to parse as function definition
            const functionMatch = input.match(/f\(n\)\s*=\s*(.+)/i);
            if (functionMatch) {
                const expression = functionMatch[1];
                const series = [];
                for (let i = 1; i <= n; i++) {
                    try {
                        // Replace n with current index in expression
                        const termExpression = expression.replace(/n/g, i);
                        series.push(eval(termExpression));
                    } catch (e) {
                        series.push(NaN);
                    }
                }
                return series;
            }
            
            // Default: try to evaluate as expression for each n
            const series = [];
            for (let i = 1; i <= n; i++) {
                try {
                    const termExpression = input.replace(/n/g, i);
                    series.push(eval(termExpression));
                } catch (e) {
                    series.push(NaN);
                }
            }
            return series;
        }
        
        // Detect pattern in custom series and extend it
        function detectPatternAndExtend(terms, n) {
            // Simple pattern detection for common sequences
            if (terms.length < 2) return terms;
            
            // Check for arithmetic progression
            const diff = terms[1] - terms[0];
            let isArithmetic = true;
            for (let i = 2; i < terms.length; i++) {
                if (Math.abs(terms[i] - terms[i-1] - diff) > 1e-10) {
                    isArithmetic = false;
                    break;
                }
            }
            
            if (isArithmetic) {
                const extended = [...terms];
                for (let i = terms.length; i < n; i++) {
                    extended.push(terms[0] + i * diff);
                }
                return extended;
            }
            
            // Check for geometric progression
            if (terms[0] !== 0) {
                const ratio = terms[1] / terms[0];
                let isGeometric = true;
                for (let i = 2; i < terms.length; i++) {
                    if (Math.abs(terms[i] / terms[i-1] - ratio) > 1e-10) {
                        isGeometric = false;
                        break;
                    }
                }
                
                if (isGeometric) {
                    const extended = [...terms];
                    for (let i = terms.length; i < n; i++) {
                        extended.push(terms[0] * Math.pow(ratio, i));
                    }
                    return extended;
                }
            }
            
            // If no pattern detected, pad with zeros
            return [...terms, ...Array(n - terms.length).fill(0)];
        }
        
        // Calculate partial sums
        function calculatePartialSums(series) {
            const partialSums = [];
            let sum = 0;
            for (let i = 0; i < series.length; i++) {
                sum += series[i];
                partialSums.push(sum);
            }
            return partialSums;
        }
        
        // Perform convergence tests
        function performConvergenceTests(series) {
            const tests = {};
            
            // Ratio Test
            if (series.length > 1) {
                let ratioSum = 0;
                let validRatios = 0;
                for (let i = 1; i < series.length; i++) {
                    if (Math.abs(series[i-1]) > 1e-10) {
                        const ratio = Math.abs(series[i] / series[i-1]);
                        ratioSum += ratio;
                        validRatios++;
                    }
                }
                tests.ratioTest = validRatios > 0 ? ratioSum / validRatios : 0;
            }
            
            // Root Test (approximate)
            if (series.length > 0) {
                let rootSum = 0;
                for (let i = 0; i < Math.min(series.length, 100); i++) {
                    if (Math.abs(series[i]) > 1e-10) {
                        rootSum += Math.pow(Math.abs(series[i]), 1/(i+1));
                    }
                }
                tests.rootTest = rootSum / Math.min(series.length, 100);
            }
            
            // Determine convergence based on tests
            tests.converges = tests.ratioTest < 1 || tests.rootTest < 1;
            
            return tests;
        }
        
        // Calculate series statistics
        function calculateSeriesStatistics(series, partialSums) {
            const stats = {};
            
            stats.sum = partialSums[partialSums.length - 1];
            stats.mean = stats.sum / series.length;
            
            // Calculate variance and standard deviation
            let variance = 0;
            for (let i = 0; i < series.length; i++) {
                variance += Math.pow(series[i] - stats.mean, 2);
            }
            stats.variance = variance / series.length;
            stats.stdDev = Math.sqrt(stats.variance);
            
            // Find min and max
            stats.min = Math.min(...series);
            stats.max = Math.max(...series);
            stats.range = stats.max - stats.min;
            
            return stats;
        }
        
        // Main calculation function
        function calculateSeries() {
            try {
                const calculateBtn = document.getElementById('calculateBtn');
                const activeOption = document.querySelector('.series-option.active');
                const seriesType = activeOption ? activeOption.getAttribute('data-type') : 'arithmetic';
                const performTests = document.getElementById('convergenceTests').checked;
                const showSums = document.getElementById('showPartialSums').checked;
                
                // Show loading state
                if (calculateBtn) {
                    calculateBtn.innerHTML = '<div class="loading"></div> Calculating...';
                    calculateBtn.disabled = true;
                }
                
                // Use setTimeout to allow UI to update before heavy calculation
                setTimeout(() => {
                    try {
                        let series = [];
                        let n = 10;
                        
                        // Generate series based on type
                        switch(seriesType) {
                            case 'arithmetic':
                                const a = parseFloat(document.getElementById('firstTerm').value) || 0;
                                const d = parseFloat(document.getElementById('commonDiff').value) || 0;
                                n = parseInt(document.getElementById('numTerms').value) || 10;
                                series = generateArithmeticSeries(a, d, n);
                                break;
                                
                            case 'geometric':
                                const geoA = parseFloat(document.getElementById('geoFirstTerm').value) || 0;
                                const r = parseFloat(document.getElementById('commonRatio').value) || 0;
                                n = parseInt(document.getElementById('geoNumTerms').value) || 10;
                                series = generateGeometricSeries(geoA, r, n);
                                break;
                                
                            case 'harmonic':
                                const harmonicType = document.getElementById('harmonicType').value;
                                const p = parseFloat(document.getElementById('pValue').value) || 1;
                                n = parseInt(document.getElementById('harmonicNumTerms').value) || 10;
                                series = generateHarmonicSeries(harmonicType, p, n);
                                break;
                                
                            case 'custom':
                                const customInput = document.getElementById('customSequence').value;
                                n = 10; // Default for custom series
                                series = parseCustomSeries(customInput, n);
                                break;
                        }
                        
                        // Validate series
                        if (series.length === 0 || series.some(isNaN)) {
                            throw new Error('Invalid series data. Please check your inputs.');
                        }
                        
                        currentSeries = series;
                        
                        // Calculate partial sums
                        const partialSums = calculatePartialSums(series);
                        
                        // Perform convergence tests if requested
                        const convergenceTests = performTests ? performConvergenceTests(series) : null;
                        
                        // Calculate statistics
                        const stats = calculateSeriesStatistics(series, partialSums);
                        
                        // Store results
                        currentResults = {
                            series: series,
                            partialSums: partialSums,
                            convergenceTests: convergenceTests,
                            stats: stats,
                            type: seriesType,
                            n: n
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
                            calculateBtn.innerHTML = '<span>Calculate Series</span>';
                            calculateBtn.disabled = false;
                        }
                    }
                }, 100);
            } catch (error) {
                console.error('Error in calculateSeries:', error);
                showTemporaryMessage('An error occurred during calculation', 'error');
            }
        }
        
        function displayResults() {
            try {
                const {
                    series,
                    partialSums,
                    convergenceTests,
                    stats,
                    type,
                    n
                } = currentResults;
                
                let html = '';
                
                // Series overview
                html += `<div class="data-display">
                    <strong>📋 Series Overview</strong>
                    <div style="font-family:'JetBrains Mono',monospace;font-size:0.9rem;margin-top:10px;line-height:1.6;">
                        ${series.slice(0, 10).join(', ')}${series.length > 10 ? ', ...' : ''}
                    </div>
                    <div style="margin-top:10px;font-size:0.85rem;color:var(--gray);">
                        Type: ${type} | Terms: ${n} | Sum: ${stats.sum.toFixed(6)}
                    </div>
                </div>`;
                
                // Main statistics grid
                html += `<div class="stats-grid">
                    <div class="result-box">
                        <div class="result-label">Series Sum</div>
                        <div class="result-value">${stats.sum.toFixed(6)}</div>
                    </div>
                    <div class="result-box" style="border-left-color:var(--primary);">
                        <div class="result-label">Mean</div>
                        <div class="result-value" style="color:var(--primary);">${stats.mean.toFixed(6)}</div>
                    </div>
                    <div class="result-box" style="border-left-color:var(--info);">
                        <div class="result-label">Standard Deviation</div>
                        <div class="result-value" style="color:var(--info);">${stats.stdDev.toFixed(6)}</div>
                    </div>
                    <div class="result-box" style="border-left-color:var(--success);">
                        <div class="result-label">Range</div>
                        <div class="result-value" style="color:var(--success);">${stats.range.toFixed(6)}</div>
                    </div>
                </div>`;
                
                // Charts
                html += `<div class="chart-container">
                    <canvas id="termsChart"></canvas>
                </div>`;
                
                html += `<div class="chart-container">
                    <canvas id="partialSumsChart"></canvas>
                </div>`;
                
                // Convergence tests
                if (convergenceTests) {
                    html += `<div class="convergence-test">
                        <strong>🔍 Convergence Analysis</strong>
                        <div style="margin-top:12px;">
                            <div class="step">Ratio Test (average): ${convergenceTests.ratioTest ? convergenceTests.ratioTest.toFixed(6) : 'N/A'}</div>
                            <div class="step">Root Test (average): ${convergenceTests.rootTest ? convergenceTests.rootTest.toFixed(6) : 'N/A'}</div>
                            <div class="step" style="font-weight:600;color:${convergenceTests.converges ? 'var(--success)' : 'var(--warning)'};margin-top:8px;">
                                Convergence: ${convergenceTests.converges ? 'Likely Convergent' : 'Likely Divergent'}
                            </div>
                        </div>
                    </div>`;
                }
                
                // Partial sums
                if (document.getElementById('showPartialSums').checked) {
                    html += `<div class="step-box">
                        <strong>📊 Partial Sums</strong>
                        <div class="partial-sums">`;
                    
                    for (let i = 0; i < Math.min(partialSums.length, 20); i++) {
                        html += `<div class="term-item">
                            <span>S<sub>${i+1}</sub> = ${partialSums[i].toFixed(6)}</span>
                            <span>Term ${i+1}: ${series[i].toFixed(6)}</span>
                        </div>`;
                    }
                    
                    if (partialSums.length > 20) {
                        html += `<div class="term-item" style="justify-content: center; color: var(--gray);">
                            ... and ${partialSums.length - 20} more partial sums
                        </div>`;
                    }
                    
                    html += `</div></div>`;
                }
                
                // Step-by-step calculation for arithmetic and geometric series
                if (type === 'arithmetic' || type === 'geometric') {
                    html += `<div class="step-box">
                        <strong>🧮 Step-by-Step Calculation</strong>`;
                    
                    if (type === 'arithmetic') {
                        const a = parseFloat(document.getElementById('firstTerm').value) || 0;
                        const d = parseFloat(document.getElementById('commonDiff').value) || 0;
                        html += `<div class="step">1. First term: a = ${a}</div>
                            <div class="step">2. Common difference: d = ${d}</div>
                            <div class="step">3. Number of terms: n = ${n}</div>
                            <div class="step">4. Sum formula: Sₙ = n/2 × [2a + (n-1)d]</div>
                            <div class="step">5. Calculation: Sₙ = ${n}/2 × [2×${a} + (${n}-1)×${d}] = ${stats.sum.toFixed(6)}</div>`;
                    } else if (type === 'geometric') {
                        const a = parseFloat(document.getElementById('geoFirstTerm').value) || 0;
                        const r = parseFloat(document.getElementById('commonRatio').value) || 0;
                        html += `<div class="step">1. First term: a = ${a}</div>
                            <div class="step">2. Common ratio: r = ${r}</div>
                            <div class="step">3. Number of terms: n = ${n}</div>
                            <div class="step">4. Sum formula: Sₙ = a(1-rⁿ)/(1-r)</div>
                            <div class="step">5. Calculation: Sₙ = ${a}(1-${r}⁽${n}⁾)/(1-${r}) = ${stats.sum.toFixed(6)}</div>`;
                    }
                    
                    html += `</div>`;
                }
                
                // Interpretation
                html += `<div class="interpretation">
                    <strong>💡 Series Interpretation</strong>
                    <div style="margin-top:10px;">
                        <div class="step">• The series ${convergenceTests && convergenceTests.converges ? 'appears to converge' : 'appears to diverge'} based on the tests performed.</div>
                        <div class="step">• The average term value is ${stats.mean.toFixed(6)} with standard deviation ${stats.stdDev.toFixed(6)}.</div>
                        <div class="step">• Terms range from ${stats.min.toFixed(6)} to ${stats.max.toFixed(6)}.</div>
                        <div class="step">• The partial sums show ${partialSums[partialSums.length-1] > partialSums[0] ? 'an increasing' : 'a decreasing'} trend.</div>
                    </div>
                </div>`;
                
                const output = document.getElementById('output');
                if (output) {
                    output.innerHTML = html;
                }
                
                // Create charts
                createCharts(series, partialSums);
            } catch (error) {
                console.error('Error displaying results:', error);
                const output = document.getElementById('output');
                if (output) {
                    output.innerHTML = `<div class="error-message">❌ Error displaying results: ${error.message}</div>`;
                }
            }
        }
        
        function createCharts(series, partialSums) {
            createTermsChart(series);
            createPartialSumsChart(partialSums);
        }
        
        function createTermsChart(series) {
            try {
                // Destroy existing chart if it exists
                if (charts.terms) {
                    charts.terms.destroy();
                }
                
                const ctx = document.getElementById('termsChart');
                if (!ctx) {
                    console.error('Terms chart canvas not found');
                    return;
                }
                
                const chartContext = ctx.getContext('2d');
                
                // Get theme colors
                const isDark = document.body.classList.contains('dark-mode');
                const backgroundColor = isDark ? 'rgba(67, 97, 238, 0.7)' : 'rgba(67, 97, 238, 0.7)';
                const borderColor = isDark ? 'rgba(67, 97, 238, 1)' : 'rgba(67, 97, 238, 1)';
                const textColor = isDark ? '#ffffff' : '#666666';
                
                // Prepare data for chart (limit to first 50 terms for performance)
                const displaySeries = series.slice(0, 50);
                const labels = displaySeries.map((_, i) => `n=${i+1}`);
                
                charts.terms = new Chart(chartContext, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Series Terms',
                            data: displaySeries,
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
                                text: 'Series Terms',
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
                                    text: 'Term Index (n)',
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
                                    text: 'Term Value',
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
                console.error('Error creating terms chart:', error);
            }
        }
        
        function createPartialSumsChart(partialSums) {
            try {
                // Destroy existing chart if it exists
                if (charts.partialSums) {
                    charts.partialSums.destroy();
                }
                
                const ctx = document.getElementById('partialSumsChart');
                if (!ctx) {
                    console.error('Partial sums chart canvas not found');
                    return;
                }
                
                const chartContext = ctx.getContext('2d');
                
                // Get theme colors
                const isDark = document.body.classList.contains('dark-mode');
                const lineColor = isDark ? 'rgba(255, 99, 132, 1)' : 'rgba(255, 99, 132, 1)';
                const textColor = isDark ? '#ffffff' : '#666666';
                
                // Prepare data for chart (limit to first 50 partial sums for performance)
                const displaySums = partialSums.slice(0, 50);
                const labels = displaySums.map((_, i) => `n=${i+1}`);
                
                charts.partialSums = new Chart(chartContext, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Partial Sums',
                            data: displaySums,
                            borderColor: lineColor,
                            backgroundColor: 'rgba(255, 99, 132, 0.1)',
                            borderWidth: 2,
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
                                text: 'Partial Sums Convergence',
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
                                    text: 'Number of Terms (n)',
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
                                    text: 'Partial Sum',
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
                console.error('Error creating partial sums chart:', error);
            }
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
                if (!currentResults.series || currentResults.series.length === 0) {
                    showTemporaryMessage('No data to export', 'error');
                    return;
                }
                
                let csvContent = "Series Analysis Results\n\n";
                csvContent += "Term Index,Term Value,Partial Sum\n";
                
                for (let i = 0; i < currentResults.series.length; i++) {
                    csvContent += `${i+1},${currentResults.series[i]},${currentResults.partialSums[i]}\n`;
                }
                
                csvContent += "\nSummary Statistics\n";
                csvContent += `Series Type,${currentResults.type}\n`;
                csvContent += `Number of Terms,${currentResults.n}\n`;
                csvContent += `Total Sum,${currentResults.stats.sum}\n`;
                csvContent += `Mean,${currentResults.stats.mean}\n`;
                csvContent += `Standard Deviation,${currentResults.stats.stdDev}\n`;
                csvContent += `Minimum,${currentResults.stats.min}\n`;
                csvContent += `Maximum,${currentResults.stats.max}\n`;
                csvContent += `Range,${currentResults.stats.range}\n`;
                
                if (currentResults.convergenceTests) {
                    csvContent += `Ratio Test,${currentResults.convergenceTests.ratioTest || 'N/A'}\n`;
                    csvContent += `Root Test,${currentResults.convergenceTests.rootTest || 'N/A'}\n`;
                    csvContent += `Convergence,${currentResults.convergenceTests.converges ? 'Likely Convergent' : 'Likely Divergent'}\n`;
                }
                
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.setAttribute("href", url);
                link.setAttribute("download", "series_analysis.csv");
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
                if (!currentResults.series || currentResults.series.length === 0) {
                    showTemporaryMessage('No data to generate report', 'error');
                    return;
                }
                
                const reportWindow = window.open('', '_blank');
                if (!reportWindow) {
                    showTemporaryMessage('Please allow pop-ups to generate report', 'error');
                    return;
                }
                
                reportWindow.document.write(`
                    <html>
                        <head>
                            <title>Series Analysis Report</title>
                            <style>
                                body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
                                h1 { color: #4361ee; border-bottom: 2px solid #4361ee; padding-bottom: 10px; }
                                .stat-box { background: #f8f9fa; padding: 15px; margin: 15px 0; border-radius: 8px; }
                                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                                th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
                                th { background: #4361ee; color: white; }
                                .series-preview { font-family: 'Courier New', monospace; background: #f8f9fa; padding: 15px; border-radius: 5px; }
                            </style>
                        </head>
                        <body>
                            <h1>Series Analysis Report</h1>
                            
                            <div class="stat-box">
                                <h2>Series Summary</h2>
                                <p><strong>Type:</strong> ${currentResults.type}</p>
                                <p><strong>Number of Terms:</strong> ${currentResults.n}</p>
                                <p><strong>Series Preview:</strong> <span class="series-preview">${currentResults.series.slice(0, 10).join(', ')}${currentResults.series.length > 10 ? ', ...' : ''}</span></p>
                            </div>
                            
                            <div class="stat-box">
                                <h2>Key Statistics</h2>
                                <table>
                                    <tr><th>Statistic</th><th>Value</th></tr>
                                    <tr><td>Total Sum</td><td>${currentResults.stats.sum.toFixed(6)}</td></tr>
                                    <tr><td>Mean</td><td>${currentResults.stats.mean.toFixed(6)}</td></tr>
                                    <tr><td>Standard Deviation</td><td>${currentResults.stats.stdDev.toFixed(6)}</td></tr>
                                    <tr><td>Minimum Term</td><td>${currentResults.stats.min.toFixed(6)}</td></tr>
                                    <tr><td>Maximum Term</td><td>${currentResults.stats.max.toFixed(6)}</td></tr>
                                    <tr><td>Range</td><td>${currentResults.stats.range.toFixed(6)}</td></tr>
                                </table>
                            </div>
                            
                            ${currentResults.convergenceTests ? `
                            <div class="stat-box">
                                <h2>Convergence Analysis</h2>
                                <table>
                                    <tr><th>Test</th><th>Value</th><th>Interpretation</th></tr>
                                    <tr><td>Ratio Test</td><td>${currentResults.convergenceTests.ratioTest ? currentResults.convergenceTests.ratioTest.toFixed(6) : 'N/A'}</td><td>${currentResults.convergenceTests.ratioTest < 1 ? 'Suggests convergence' : 'Suggests divergence'}</td></tr>
                                    <tr><td>Root Test</td><td>${currentResults.convergenceTests.rootTest ? currentResults.convergenceTests.rootTest.toFixed(6) : 'N/A'}</td><td>${currentResults.convergenceTests.rootTest < 1 ? 'Suggests convergence' : 'Suggests divergence'}</td></tr>
                                    <tr><td>Overall</td><td>-</td><td>${currentResults.convergenceTests.converges ? 'Likely convergent' : 'Likely divergent'}</td></tr>
                                </table>
                            </div>
                            ` : ''}
                            
                            <div class="stat-box">
                                <h2>Interpretation</h2>
                                <p>The ${currentResults.type} series with ${currentResults.n} terms has a total sum of ${currentResults.stats.sum.toFixed(6)}. 
                                ${currentResults.convergenceTests && currentResults.convergenceTests.converges ? 
                                    'The series appears to converge based on the performed tests.' : 
                                    'The series appears to diverge based on the performed tests.'}
                                The terms show ${currentResults.stats.stdDev < 0.1 ? 'low' : currentResults.stats.stdDev < 1 ? 'moderate' : 'high'} variability around the mean value of ${currentResults.stats.mean.toFixed(6)}.</p>
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
                // Reset form values based on active series type
                const activeOption = document.querySelector('.series-option.active');
                const seriesType = activeOption ? activeOption.getAttribute('data-type') : 'arithmetic';
                
                switch(seriesType) {
                    case 'arithmetic':
                        document.getElementById('firstTerm').value = 2;
                        document.getElementById('commonDiff').value = 3;
                        document.getElementById('numTerms').value = 10;
                        break;
                    case 'geometric':
                        document.getElementById('geoFirstTerm').value = 2;
                        document.getElementById('commonRatio').value = 0.5;
                        document.getElementById('geoNumTerms').value = 10;
                        break;
                    case 'harmonic':
                        document.getElementById('harmonicType').value = 'standard';
                        document.getElementById('pValue').value = 1;
                        document.getElementById('harmonicNumTerms').value = 10;
                        break;
                    case 'custom':
                        document.getElementById('customSequence').value = '1, 4, 9, 16, 25, 36';
                        break;
                }
                
                const result = document.getElementById('result');
                if (result) {
                    result.classList.remove('show');
                }
                
                currentSeries = [];
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
                    terms: null,
                    partialSums: null
                };
                
                showTemporaryMessage('All data cleared successfully!', 'success');
            } catch (error) {
                console.error('Error clearing data:', error);
                showTemporaryMessage('Error clearing data', 'error');
            }
        }
    </script>
</body>
</html>