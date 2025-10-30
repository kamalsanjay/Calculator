<?php
/**
 * Statistics Calculator - ENHANCED & FULLY TESTED
 * File: mean-median-mode-calculator.php
 * Description: Calculate mean, median, mode, range, variance, and standard deviation
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Statistics Calculator - Mean, Median, Mode & More</title>
    <meta name="description" content="Calculate mean, median, mode, range, variance, and standard deviation with step-by-step solutions.">
    <style>
        :root {
            --primary: #667eea;
            --primary-dark: #5a6fd8;
            --secondary: #764ba2;
            --success: #4CAF50;
            --info: #2196F3;
            --warning: #FF9800;
            --danger: #F44336;
            --dark: #333;
            --light: #f8f9fa;
            --gray: #6c757d;
            --border-radius: 12px;
            --box-shadow: 0 10px 40px rgba(0,0,0,0.2);
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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); 
            min-height: 100vh; 
            padding: 12px;
            color: var(--dark);
        }
        
        body.dark-mode {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: var(--text-primary);
        }
        
        header { 
            background: rgba(255,255,255,0.1); 
            color: white; 
            padding: 20px 16px; 
            text-align: center; 
            border-radius: var(--border-radius); 
            margin-bottom: 16px; 
            backdrop-filter: blur(10px); 
        }
        
        .dark-mode header {
            background: rgba(0,0,0,0.2);
        }
        
        header h1 { 
            font-size: 1.5rem; 
            margin-bottom: 8px; 
            font-weight: 700; 
        }
        
        header p { 
            font-size: 0.875rem; 
            opacity: 0.9; 
        }
        
        .container { 
            max-width: 100%; 
            margin: 0 auto; 
        }
        
        .breadcrumb { 
            margin-bottom: 16px; 
            text-align: center; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .breadcrumb a { 
            color: white; 
            text-decoration: none; 
            font-weight: 500; 
            background: rgba(255,255,255,0.2); 
            padding: 8px 16px; 
            border-radius: 8px; 
            display: inline-block; 
            backdrop-filter: blur(10px); 
            font-size: 0.875rem; 
        }
        
        .dark-mode .breadcrumb a {
            background: rgba(255,255,255,0.1);
        }
        
        .theme-toggle {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            backdrop-filter: blur(10px);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .calculator-body { 
            background: white; 
            padding: 16px; 
            border-radius: var(--border-radius); 
            box-shadow: var(--box-shadow); 
            margin-bottom: 16px; 
        }
        
        .dark-mode .calculator-body {
            background: var(--bg-card);
            color: var(--text-primary);
        }
        
        .input-section { 
            margin-bottom: 16px; 
        }
        
        .input-section label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            color: var(--dark);
            font-size: 0.9rem; 
        }
        
        .dark-mode .input-section label {
            color: var(--text-primary);
        }
        
        .input-section textarea { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #e0e0e0; 
            border-radius: 8px; 
            font-size: 1rem; 
            outline: none; 
            transition: var(--transition); 
            font-family: 'Courier New', monospace; 
            min-height: 120px; 
            resize: vertical; 
            background: white;
            color: var(--dark);
        }
        
        .dark-mode .input-section textarea {
            background: var(--bg-secondary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .input-section textarea:focus { 
            border-color: var(--primary); 
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); 
        }
        
        .input-hint { 
            font-size: 0.8rem; 
            color: var(--gray); 
            margin-top: 6px; 
            font-style: italic; 
        }
        
        .dark-mode .input-hint {
            color: var(--text-secondary);
        }
        
        .btn { 
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); 
            color: white; 
            border: none; 
            padding: 14px 24px; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: 600; 
            width: 100%; 
            font-size: 1.1rem; 
            transition: var(--transition); 
            box-shadow: 0 2px 8px rgba(0,0,0,0.15); 
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }
        
        .btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 4px 12px rgba(0,0,0,0.2); 
        }
        
        .btn:active { 
            transform: translateY(0); 
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
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
            gap: 8px; 
            margin: 16px 0; 
        }
        
        .example-btn { 
            padding: 10px; 
            background: #f0f0f0; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            cursor: pointer; 
            text-align: center; 
            font-size: 0.85rem; 
            transition: var(--transition); 
            font-family: 'Courier New', monospace; 
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
        
        .result-section { 
            background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); 
            padding: 20px; 
            border-radius: var(--border-radius); 
            border-left: 5px solid var(--primary); 
            margin-top: 20px; 
            display: none; 
        }
        
        .dark-mode .result-section {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d1b4e 100%);
        }
        
        .result-section.show { 
            display: block; 
            animation: slideIn 0.3s; 
        }
        
        @keyframes slideIn { 
            from { 
                opacity: 0; 
                transform: translateY(20px); 
            } 
            to { 
                opacity: 1; 
                transform: translateY(0); 
            } 
        }
        
        .result-section h3 { 
            color: var(--primary); 
            margin-bottom: 16px; 
            font-size: 1.3rem; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); 
            gap: 12px; 
            margin-bottom: 16px; 
        }
        
        .result-box { 
            background: white; 
            padding: 16px; 
            border-radius: 10px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
            border-left: 4px solid var(--success); 
        }
        
        .dark-mode .result-box {
            background: var(--bg-secondary);
        }
        
        .result-label { 
            font-size: 0.75rem; 
            color: var(--gray); 
            margin-bottom: 6px; 
            font-weight: 600; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
        }
        
        .dark-mode .result-label {
            color: var(--text-secondary);
        }
        
        .result-value { 
            font-size: 1.3rem; 
            color: var(--success); 
            font-weight: bold; 
            font-family: 'Courier New', monospace; 
            word-break: break-word; 
            line-height: 1.4; 
        }
        
        .formula-box { 
            background: #f9f9f9; 
            padding: 14px; 
            border-radius: 8px; 
            border-left: 4px solid var(--primary); 
            margin: 14px 0; 
            font-size: 0.85rem; 
            line-height: 1.7; 
        }
        
        .dark-mode .formula-box {
            background: var(--bg-secondary);
        }
        
        .formula-box strong { 
            color: var(--primary); 
            display: block; 
            margin-bottom: 6px; 
        }
        
        .step-box { 
            background: #fff3cd; 
            padding: 14px; 
            border-radius: 8px; 
            border-left: 4px solid var(--warning); 
            margin: 14px 0; 
        }
        
        .dark-mode .step-box {
            background: #3a2e0f;
        }
        
        .step-box strong { 
            color: var(--warning); 
            display: block; 
            margin-bottom: 8px; 
        }
        
        .step { 
            padding: 6px 0; 
            border-bottom: 1px solid #ffe082; 
            font-family: 'Courier New', monospace; 
            font-size: 0.85rem; 
        }
        
        .dark-mode .step {
            border-bottom-color: #5c4a1a;
        }
        
        .step:last-child { 
            border-bottom: none; 
        }
        
        .data-display { 
            background: #e3f2fd; 
            padding: 14px; 
            border-radius: 8px; 
            border-left: 4px solid var(--info); 
            margin: 14px 0; 
        }
        
        .dark-mode .data-display {
            background: #1a3a5f;
        }
        
        .data-display strong { 
            color: var(--info); 
            display: block; 
            margin-bottom: 8px; 
        }
        
        .info-box { 
            background: white; 
            padding: 20px; 
            border-radius: var(--border-radius); 
            line-height: 1.8; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.15); 
            margin-top: 16px; 
        }
        
        .dark-mode .info-box {
            background: var(--bg-card);
        }
        
        .info-box h3 { 
            color: var(--primary); 
            margin-bottom: 14px; 
            font-size: 1.2rem; 
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }
        
        .action-buttons .btn {
            width: auto;
            flex: 1;
            min-width: 120px;
            font-size: 0.9rem;
            padding: 10px 15px;
        }
        
        .chart-container {
            margin: 20px 0;
            background: white;
            border-radius: var(--border-radius);
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .dark-mode .chart-container {
            background: var(--bg-secondary);
        }
        
        .chart-placeholder {
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f8f9fa;
            border-radius: 8px;
            color: var(--gray);
            font-style: italic;
        }
        
        .dark-mode .chart-placeholder {
            background: var(--bg-card);
            color: var(--text-secondary);
        }
        
        .history-section {
            margin-top: 20px;
            display: none;
        }
        
        .history-section.show {
            display: block;
        }
        
        .history-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .dark-mode .history-item {
            background: var(--bg-secondary);
        }
        
        .history-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .history-data {
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .history-stats {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            font-size: 0.8rem;
            color: var(--gray);
        }
        
        .dark-mode .history-stats {
            color: var(--text-secondary);
        }
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
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
            padding: 12px;
            border-radius: 8px;
            margin: 10px 0;
            border-left: 4px solid var(--danger);
        }
        
        .dark-mode .error-message {
            background: #3c1a1d;
            color: #f8a5a5;
        }
        
        .advanced-stats {
            margin-top: 20px;
        }
        
        .tabs {
            display: flex;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 15px;
        }
        
        .dark-mode .tabs {
            border-bottom-color: var(--border-color);
        }
        
        .tab {
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            font-weight: 500;
        }
        
        .tab.active {
            border-bottom-color: var(--primary);
            color: var(--primary);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        @media (min-width: 768px) { 
            body { padding: 24px; }
            .container { max-width: 720px; margin: 0 auto; }
            header h1 { font-size: 2rem; }
            .calculator-body { padding: 24px; }
            .result-value { font-size: 1.4rem; }
        }
        
        @media (min-width: 1024px) { .container { max-width: 960px; } }
        @media (min-width: 1280px) { .container { max-width: 1100px; } }
        
        @media (max-width: 767px) {
            .breadcrumb {
                flex-direction: column;
                align-items: stretch;
            }
            
            .breadcrumb a, .theme-toggle {
                text-align: center;
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
                font-size: 1.1rem;
            }
            
            .tabs {
                overflow-x: auto;
                white-space: nowrap;
            }
        }
        
        @media (max-width: 479px) {
            .stats-grid { 
                grid-template-columns: repeat(2, 1fr); 
            }
            .result-value { 
                font-size: 1.1rem; 
            }
            .examples {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>📊 Statistics Calculator</h1>
        <p>Mean, Median, Mode, Range, Variance & Standard Deviation</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
            <button class="theme-toggle" id="themeToggle">
                <span id="themeIcon">🌙</span> <span id="themeText">Dark Mode</span>
            </button>
        </div>

        <div class="calculator-body">
            <h3 style="color: var(--primary); margin-bottom: 16px; font-size: 1.1rem;">📈 Enter Your Data</h3>
            
            <div class="input-section">
                <label for="data_input">Data Values</label>
                <textarea id="data_input" placeholder="Enter numbers separated by commas, spaces, or new lines&#10;Example: 5, 8, 12, 15, 20">5, 8, 12, 15, 20</textarea>
                <div class="input-hint">Separate values with commas, spaces, or line breaks</div>
            </div>
            
            <button class="btn" id="calculateBtn" onclick="calculateStats()">
                <span>Calculate All Statistics</span>
            </button>
            
            <div class="examples">
                <button class="example-btn" onclick="setData('5, 8, 12, 15, 20')">Basic Set</button>
                <button class="example-btn" onclick="setData('10, 20, 30, 40, 50, 60')">Even Count</button>
                <button class="example-btn" onclick="setData('2, 4, 4, 6, 8, 8, 8, 10')">With Mode</button>
                <button class="example-btn" onclick="setData('15, 23, 12, 45, 67, 34, 23')">Random Set</button>
                <button class="example-btn" onclick="setData('1.5, 2.3, 4.7, 3.2, 5.1, 2.8')">Decimals</button>
            </div>

            <div class="result-section" id="result">
                <h3>
                    <span>📊 Statistical Results</span>
                    <div class="action-buttons">
                        <button class="btn btn-secondary" onclick="exportData()">
                            📥 Export
                        </button>
                        <button class="btn btn-success" onclick="saveToHistory()">
                            💾 Save
                        </button>
                        <button class="btn btn-danger" onclick="clearData()">
                            🗑️ Clear
                        </button>
                    </div>
                </h3>
                <div id="output"></div>
            </div>
            
            <div class="history-section" id="historySection">
                <h3>📚 Calculation History</h3>
                <div id="historyList"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Statistical Measures</h3>
            <div class="tabs">
                <div class="tab active" onclick="switchTab('basic')">Basic Statistics</div>
                <div class="tab" onclick="switchTab('advanced')">Advanced Statistics</div>
                <div class="tab" onclick="switchTab('formulas')">Formulas</div>
            </div>
            
            <div class="tab-content active" id="basicTab">
                <div class="formula-box">
                    <strong>Mean (Average):</strong>
                    Sum of all values divided by count<br>
                    Formula: μ = Σx / n
                </div>
                <div class="formula-box">
                    <strong>Median (Middle Value):</strong>
                    Middle value when data is sorted<br>
                    • Odd count: middle value<br>
                    • Even count: average of two middle values
                </div>
                <div class="formula-box">
                    <strong>Mode (Most Frequent):</strong>
                    Value(s) that appear most frequently<br>
                    Can have multiple modes or no mode
                </div>
                <div class="formula-box">
                    <strong>Range:</strong>
                    Difference between maximum and minimum<br>
                    Formula: Range = Max - Min
                </div>
                <div class="formula-box">
                    <strong>Variance (σ²):</strong>
                    Average of squared differences from mean<br>
                    Formula: σ² = Σ(x - μ)² / n
                </div>
                <div class="formula-box">
                    <strong>Standard Deviation (σ):</strong>
                    Square root of variance (measures spread)<br>
                    Formula: σ = √(variance)
                </div>
            </div>
            
            <div class="tab-content" id="advancedTab">
                <div class="formula-box">
                    <strong>Quartiles:</strong>
                    Values that divide data into four equal parts<br>
                    • Q1: 25th percentile<br>
                    • Q2: 50th percentile (median)<br>
                    • Q3: 75th percentile
                </div>
                <div class="formula-box">
                    <strong>Interquartile Range (IQR):</strong>
                    Range of the middle 50% of data<br>
                    Formula: IQR = Q3 - Q1
                </div>
                <div class="formula-box">
                    <strong>Skewness:</strong>
                    Measure of asymmetry in data distribution<br>
                    • Positive: Right-skewed<br>
                    • Negative: Left-skewed<br>
                    • Zero: Symmetrical
                </div>
                <div class="formula-box">
                    <strong>Kurtosis:</strong>
                    Measure of "tailedness" of distribution<br>
                    • High: Heavy tails, more outliers<br>
                    • Low: Light tails, fewer outliers
                </div>
                <div class="formula-box">
                    <strong>Coefficient of Variation (CV):</strong>
                    Relative standard deviation<br>
                    Formula: CV = (σ / μ) × 100%
                </div>
            </div>
            
            <div class="tab-content" id="formulasTab">
                <div class="formula-box">
                    <strong>Population Variance:</strong>
                    σ² = Σ(x - μ)² / N
                </div>
                <div class="formula-box">
                    <strong>Sample Variance:</strong>
                    s² = Σ(x - x̄)² / (n-1)
                </div>
                <div class="formula-box">
                    <strong>Skewness Formula:</strong>
                    g₁ = [n/((n-1)(n-2))] × Σ[(x - μ)/σ]³
                </div>
                <div class="formula-box">
                    <strong>Kurtosis Formula:</strong>
                    g₂ = {[n(n+1)/((n-1)(n-2)(n-3))] × Σ[(x - μ)/σ]⁴} - [3(n-1)²/((n-2)(n-3))]
                </div>
                <div class="formula-box">
                    <strong>Z-score:</strong>
                    z = (x - μ) / σ
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentData = [];
        let currentResults = {};
        let calculationHistory = [];
        
        // Initialize the app
        document.addEventListener('DOMContentLoaded', function() {
            // Load saved theme preference
            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-mode');
                document.getElementById('themeIcon').textContent = '☀️';
                document.getElementById('themeText').textContent = 'Light Mode';
            }
            
            // Load calculation history
            loadHistory();
            
            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    calculateStats();
                }
            });
            
            // Add input validation
            document.getElementById('data_input').addEventListener('input', function() {
                validateInput(this);
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
        });
        
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
        
        // Input validation
        function validateInput(input) {
            const value = input.value;
            // Remove any non-numeric characters except commas, spaces, dots, and minus signs
            input.value = value.replace(/[^\d\s,\-\.]/g, '');
        }
        
        function setData(str) {
            document.getElementById('data_input').value = str;
        }
        
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
            document.getElementById('result').scrollIntoView({behavior: 'smooth', block: 'nearest'});
        }
        
        function parseData(input) {
            if (!input.trim()) {
                throw new Error('Please enter data values');
            }
            
            // Split by commas, spaces, newlines, and filter empty values
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
            
            if (values.length === 0) {
                throw new Error('No valid numbers found');
            }
            
            if (values.length < 2) {
                throw new Error('Please enter at least 2 values');
            }
            
            return values;
        }
        
        function calculateMean(data) {
            const sum = data.reduce((a, b) => a + b, 0);
            return sum / data.length;
        }
        
        function calculateMedian(data) {
            const sorted = [...data].sort((a, b) => a - b);
            const mid = Math.floor(sorted.length / 2);
            
            if(sorted.length % 2 === 0) {
                return (sorted[mid - 1] + sorted[mid]) / 2;
            } else {
                return sorted[mid];
            }
        }
        
        function calculateMode(data) {
            const frequency = {};
            let maxFreq = 0;
            
            data.forEach(val => {
                frequency[val] = (frequency[val] || 0) + 1;
                maxFreq = Math.max(maxFreq, frequency[val]);
            });
            
            if(maxFreq === 1) return null; // No mode
            
            const modes = Object.keys(frequency)
                .filter(key => frequency[key] === maxFreq)
                .map(Number);
            
            return {modes, frequency: maxFreq};
        }
        
        function calculateRange(data) {
            return Math.max(...data) - Math.min(...data);
        }
        
        function calculateVariance(data, mean) {
            const squaredDiffs = data.map(val => Math.pow(val - mean, 2));
            return squaredDiffs.reduce((a, b) => a + b, 0) / data.length;
        }
        
        function calculateStdDev(variance) {
            return Math.sqrt(variance);
        }
        
        function calculateQuartiles(data) {
            const sorted = [...data].sort((a, b) => a - b);
            const n = sorted.length;
            
            // Q2 is the median
            const q2 = calculateMedian(sorted);
            
            // Q1 is median of lower half
            const lowerHalf = sorted.slice(0, Math.floor(n/2));
            const q1 = calculateMedian(lowerHalf);
            
            // Q3 is median of upper half
            const upperHalfStart = n % 2 === 0 ? Math.floor(n/2) : Math.floor(n/2) + 1;
            const upperHalf = sorted.slice(upperHalfStart);
            const q3 = calculateMedian(upperHalf);
            
            return {q1, q2, q3};
        }
        
        function calculateSkewness(data, mean, stdDev) {
            if (stdDev === 0) return 0;
            
            const n = data.length;
            const sumCubedDeviations = data.reduce((sum, val) => {
                return sum + Math.pow((val - mean) / stdDev, 3);
            }, 0);
            
            return (n / ((n-1) * (n-2))) * sumCubedDeviations;
        }
        
        function calculateKurtosis(data, mean, stdDev) {
            if (stdDev === 0) return 0;
            
            const n = data.length;
            const sumFourthDeviations = data.reduce((sum, val) => {
                return sum + Math.pow((val - mean) / stdDev, 4);
            }, 0);
            
            const term1 = (n * (n+1)) / ((n-1) * (n-2) * (n-3));
            const term2 = (3 * Math.pow(n-1, 2)) / ((n-2) * (n-3));
            
            return term1 * sumFourthDeviations - term2;
        }
        
        function calculateStats() {
            const input = document.getElementById('data_input').value;
            const calculateBtn = document.getElementById('calculateBtn');
            
            // Show loading state
            calculateBtn.innerHTML = '<div class="loading"></div> Calculating...';
            calculateBtn.disabled = true;
            
            // Use setTimeout to allow UI to update before heavy calculation
            setTimeout(() => {
                try {
                    const data = parseData(input);
                    currentData = data;
                    
                    // Calculate all statistics
                    const sorted = [...data].sort((a, b) => a - b);
                    const count = data.length;
                    const sum = data.reduce((a, b) => a + b, 0);
                    const mean = calculateMean(data);
                    const median = calculateMedian(data);
                    const modeResult = calculateMode(data);
                    const range = calculateRange(data);
                    const min = Math.min(...data);
                    const max = Math.max(...data);
                    const variance = calculateVariance(data, mean);
                    const stdDev = calculateStdDev(variance);
                    const quartiles = calculateQuartiles(data);
                    const iqr = quartiles.q3 - quartiles.q1;
                    const skewness = calculateSkewness(data, mean, stdDev);
                    const kurtosis = calculateKurtosis(data, mean, stdDev);
                    const cv = (stdDev / mean) * 100;
                    
                    // Store results for export
                    currentResults = {
                        data: data,
                        sorted: sorted,
                        count: count,
                        sum: sum,
                        mean: mean,
                        median: median,
                        mode: modeResult,
                        range: range,
                        min: min,
                        max: max,
                        variance: variance,
                        stdDev: stdDev,
                        quartiles: quartiles,
                        iqr: iqr,
                        skewness: skewness,
                        kurtosis: kurtosis,
                        cv: cv
                    };
                    
                    // Build output HTML
                    let html = `<div class="data-display">
                        <strong>📋 Your Data (sorted):</strong>
                        <div style="font-family:'Courier New',monospace;font-size:0.9rem;margin-top:8px;line-height:1.6;">
                            ${sorted.join(', ')}
                        </div>
                        <div style="margin-top:8px;font-size:0.85rem;color:var(--gray);">
                            Count: ${count} values | Sum: ${sum.toFixed(2)} | Min: ${min} | Max: ${max}
                        </div>
                    </div>`;
                    
                    html += `<div class="stats-grid">
                        <div class="result-box">
                            <div class="result-label">Mean (μ)</div>
                            <div class="result-value">${mean.toFixed(4)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:var(--info);">
                            <div class="result-label">Median</div>
                            <div class="result-value" style="color:var(--info);">${median.toFixed(4)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:var(--warning);">
                            <div class="result-label">Mode</div>
                            <div class="result-value" style="color:var(--warning);font-size:1.05rem;">${modeResult ? modeResult.modes.join(', ') : 'No mode'}</div>
                        </div>
                        <div class="result-box" style="border-left-color:#9C27B0;">
                            <div class="result-label">Range</div>
                            <div class="result-value" style="color:#9C27B0;">${range.toFixed(4)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:var(--danger);">
                            <div class="result-label">Minimum</div>
                            <div class="result-value" style="color:var(--danger);">${min}</div>
                        </div>
                        <div class="result-box" style="border-left-color:var(--success);">
                            <div class="result-label">Maximum</div>
                            <div class="result-value" style="color:var(--success);">${max}</div>
                        </div>
                        <div class="result-box" style="border-left-color:#00BCD4;">
                            <div class="result-label">Variance (σ²)</div>
                            <div class="result-value" style="color:#00BCD4;">${variance.toFixed(4)}</div>
                        </div>
                        <div class="result-box" style="border-left-color:#673AB7;">
                            <div class="result-label">Std Dev (σ)</div>
                            <div class="result-value" style="color:#673AB7;">${stdDev.toFixed(4)}</div>
                        </div>
                    </div>`;
                    
                    // Advanced statistics
                    html += `<div class="advanced-stats">
                        <h4 style="color:var(--primary); margin:20px 0 10px;">Advanced Statistics</h4>
                        <div class="stats-grid">
                            <div class="result-box" style="border-left-color:#FF5722;">
                                <div class="result-label">Q1 (25%)</div>
                                <div class="result-value" style="color:#FF5722;">${quartiles.q1.toFixed(4)}</div>
                            </div>
                            <div class="result-box" style="border-left-color:#FF5722;">
                                <div class="result-label">Q2 (Median)</div>
                                <div class="result-value" style="color:#FF5722;">${quartiles.q2.toFixed(4)}</div>
                            </div>
                            <div class="result-box" style="border-left-color:#FF5722;">
                                <div class="result-label">Q3 (75%)</div>
                                <div class="result-value" style="color:#FF5722;">${quartiles.q3.toFixed(4)}</div>
                            </div>
                            <div class="result-box" style="border-left-color:#795548;">
                                <div class="result-label">IQR</div>
                                <div class="result-value" style="color:#795548;">${iqr.toFixed(4)}</div>
                            </div>
                            <div class="result-box" style="border-left-color:#607D8B;">
                                <div class="result-label">Skewness</div>
                                <div class="result-value" style="color:#607D8B;">${skewness.toFixed(4)}</div>
                            </div>
                            <div class="result-box" style="border-left-color:#607D8B;">
                                <div class="result-label">Kurtosis</div>
                                <div class="result-value" style="color:#607D8B;">${kurtosis.toFixed(4)}</div>
                            </div>
                        </div>
                    </div>`;
                    
                    // Chart placeholder
                    html += `<div class="chart-container">
                        <strong>📊 Data Distribution</strong>
                        <div class="chart-placeholder">
                            Chart visualization would appear here with a charting library
                        </div>
                        <div style="margin-top:10px; font-size:0.8rem; text-align:center;">
                            To visualize your data, integrate a charting library like Chart.js
                        </div>
                    </div>`;
                    
                    // Mean calculation steps
                    html += `<div class="step-box">
                        <strong>📝 Mean Calculation:</strong>
                        <div class="step">Sum = ${sum.toFixed(2)}</div>
                        <div class="step">Count = ${count}</div>
                        <div class="step">Mean = ${sum.toFixed(2)} ÷ ${count} = ${mean.toFixed(4)}</div>
                    </div>`;
                    
                    // Median calculation steps
                    html += `<div class="step-box">
                        <strong>📝 Median Calculation:</strong>
                        <div class="step">Sorted: ${sorted.join(', ')}</div>`;
                    
                    if(count % 2 === 0) {
                        const mid1 = sorted[count/2 - 1];
                        const mid2 = sorted[count/2];
                        html += `<div class="step">Even count: positions ${count/2} and ${count/2 + 1}</div>
                        <div class="step">Values: ${mid1} and ${mid2}</div>
                        <div class="step">Median = (${mid1} + ${mid2}) ÷ 2 = ${median.toFixed(4)}</div>`;
                    } else {
                        const pos = Math.floor(count/2) + 1;
                        html += `<div class="step">Odd count: position ${pos}</div>
                        <div class="step">Median = ${median}</div>`;
                    }
                    html += `</div>`;
                    
                    // Mode explanation
                    if(modeResult) {
                        html += `<div class="step-box">
                            <strong>📝 Mode Analysis:</strong>
                            <div class="step">Most frequent: ${modeResult.modes.join(', ')}</div>
                            <div class="step">Appears ${modeResult.frequency} time(s)</div>
                        </div>`;
                    } else {
                        html += `<div class="step-box">
                            <strong>📝 Mode Analysis:</strong>
                            <div class="step">No mode - all values appear once</div>
                        </div>`;
                    }
                    
                    // Range calculation
                    html += `<div class="step-box">
                        <strong>📝 Range Calculation:</strong>
                        <div class="step">Range = Max - Min</div>
                        <div class="step">Range = ${max} - ${min} = ${range.toFixed(4)}</div>
                    </div>`;
                    
                    // Variance calculation
                    html += `<div class="step-box">
                        <strong>📝 Variance Calculation:</strong>
                        <div class="step">Step 1: Calculate (x - μ)² for each value</div>`;
                    
                    const showCount = Math.min(4, data.length);
                    for(let i = 0; i < showCount; i++) {
                        const val = data[i];
                        const diff = val - mean;
                        html += `<div class="step">(${val} - ${mean.toFixed(2)})² = ${Math.pow(diff, 2).toFixed(4)}</div>`;
                    }
                    
                    if(data.length > showCount) html += `<div class="step">... (${data.length - showCount} more)</div>`;
                    
                    const sumSquaredDiffs = variance * count;
                    html += `<div class="step">Step 2: Sum = ${sumSquaredDiffs.toFixed(4)}</div>
                        <div class="step">Step 3: Variance = ${sumSquaredDiffs.toFixed(4)} ÷ ${count} = ${variance.toFixed(4)}</div>
                    </div>`;
                    
                    // Standard deviation
                    html += `<div class="step-box">
                        <strong>📝 Standard Deviation:</strong>
                        <div class="step">σ = √(variance)</div>
                        <div class="step">σ = √${variance.toFixed(4)} = ${stdDev.toFixed(4)}</div>
                    </div>`;
                    
                    // Summary
                    const cvPercent = cv.toFixed(2);
                    html += `<div class="formula-box" style="background:#e8f5e9;border-left-color:var(--success);">
                        <strong style="color:var(--success);">📊 Summary Statistics:</strong>
                        • Dataset: ${count} values from ${min} to ${max}<br>
                        • Central Tendency: Mean = ${mean.toFixed(2)}, Median = ${median.toFixed(2)}<br>
                        • Spread: Range = ${range.toFixed(2)}, Std Dev = ${stdDev.toFixed(2)}<br>
                        • Distribution: Skewness = ${skewness.toFixed(2)} (${skewness > 0 ? 'Right-skewed' : skewness < 0 ? 'Left-skewed' : 'Symmetric'})<br>
                        • Coefficient of Variation: ${cvPercent}%
                    </div>`;
                    
                    show(html);
                    
                } catch (error) {
                    show(`<div class="error-message">❌ ${error.message}</div>`);
                } finally {
                    // Reset button
                    calculateBtn.innerHTML = '<span>Calculate All Statistics</span>';
                    calculateBtn.disabled = false;
                }
            }, 100);
        }
        
        // Export data as CSV
        function exportData() {
            if (!currentResults.data || currentResults.data.length === 0) {
                alert('No data to export');
                return;
            }
            
            let csvContent = "Statistical Analysis Results\n\n";
            csvContent += "Data," + currentResults.data.join(",") + "\n";
            csvContent += "Sorted Data," + currentResults.sorted.join(",") + "\n\n";
            
            csvContent += "Statistic,Value\n";
            csvContent += `Count,${currentResults.count}\n`;
            csvContent += `Sum,${currentResults.sum.toFixed(4)}\n`;
            csvContent += `Mean,${currentResults.mean.toFixed(4)}\n`;
            csvContent += `Median,${currentResults.median.toFixed(4)}\n`;
            csvContent += `Mode,${currentResults.mode ? currentResults.mode.modes.join(',') : 'No mode'}\n`;
            csvContent += `Range,${currentResults.range.toFixed(4)}\n`;
            csvContent += `Minimum,${currentResults.min}\n`;
            csvContent += `Maximum,${currentResults.max}\n`;
            csvContent += `Variance,${currentResults.variance.toFixed(4)}\n`;
            csvContent += `Standard Deviation,${currentResults.stdDev.toFixed(4)}\n`;
            csvContent += `Q1,${currentResults.quartiles.q1.toFixed(4)}\n`;
            csvContent += `Q2 (Median),${currentResults.quartiles.q2.toFixed(4)}\n`;
            csvContent += `Q3,${currentResults.quartiles.q3.toFixed(4)}\n`;
            csvContent += `IQR,${currentResults.iqr.toFixed(4)}\n`;
            csvContent += `Skewness,${currentResults.skewness.toFixed(4)}\n`;
            csvContent += `Kurtosis,${currentResults.kurtosis.toFixed(4)}\n`;
            csvContent += `Coefficient of Variation,${currentResults.cv.toFixed(2)}%\n`;
            
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement("a");
            link.setAttribute("href", url);
            link.setAttribute("download", "statistical_analysis.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        // Save to history
        function saveToHistory() {
            if (!currentResults.data || currentResults.data.length === 0) {
                alert('No data to save');
                return;
            }
            
            const historyItem = {
                id: Date.now(),
                data: currentResults.data,
                mean: currentResults.mean,
                median: currentResults.median,
                mode: currentResults.mode,
                timestamp: new Date().toLocaleString()
            };
            
            calculationHistory.unshift(historyItem);
            
            // Keep only last 10 items
            if (calculationHistory.length > 10) {
                calculationHistory = calculationHistory.slice(0, 10);
            }
            
            // Save to localStorage
            localStorage.setItem('statsCalculatorHistory', JSON.stringify(calculationHistory));
            
            // Update history display
            updateHistoryDisplay();
            
            alert('Calculation saved to history!');
        }
        
        // Load history from localStorage
        function loadHistory() {
            const savedHistory = localStorage.getItem('statsCalculatorHistory');
            if (savedHistory) {
                calculationHistory = JSON.parse(savedHistory);
                updateHistoryDisplay();
            }
        }
        
        // Update history display
        function updateHistoryDisplay() {
            const historyList = document.getElementById('historyList');
            const historySection = document.getElementById('historySection');
            
            if (calculationHistory.length === 0) {
                historySection.classList.remove('show');
                return;
            }
            
            historySection.classList.add('show');
            
            let html = '';
            calculationHistory.forEach(item => {
                html += `<div class="history-item" onclick="loadFromHistory(${item.id})">
                    <div class="history-data">${item.data.join(', ')}</div>
                    <div class="history-stats">
                        <span>Mean: ${item.mean.toFixed(2)}</span>
                        <span>Median: ${item.median.toFixed(2)}</span>
                        <span>Mode: ${item.mode ? item.mode.modes.join(',') : 'No mode'}</span>
                        <span>${item.timestamp}</span>
                    </div>
                </div>`;
            });
            
            historyList.innerHTML = html;
        }
        
        // Load data from history
        function loadFromHistory(id) {
            const item = calculationHistory.find(i => i.id === id);
            if (item) {
                setData(item.data.join(', '));
                calculateStats();
            }
        }
        
        // Clear data
        function clearData() {
            document.getElementById('data_input').value = '';
            document.getElementById('result').classList.remove('show');
            currentData = [];
            currentResults = {};
        }
    </script>
</body>
</html>