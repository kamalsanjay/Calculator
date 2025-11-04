<?php
/**
 * Random Letter Generator
 * File: utility/random-letter-generator.php
 * Description: Advanced random letter generator with multiple alphabets, patterns, and statistical analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Random Letter Generator - Multiple Alphabets & Patterns</title>
    <meta name="description" content="Generate random letters from multiple alphabets, create patterns, words, and analyze letter frequency distributions.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .generator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-bottom: 30px; }
        
        .panel-section { background: #f8f9fa; padding: 20px; border-radius: 12px; border-left: 4px solid #a8edea; }
        .panel-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }
        
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input, .input-wrapper select, .input-wrapper textarea { width: 100%; padding: 12px 14px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus, .input-wrapper textarea:focus { outline: none; border-color: #a8edea; box-shadow: 0 0 0 3px rgba(168, 237, 234, 0.1); }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .checkbox-group input[type="checkbox"] { width: 18px; height: 18px; }
        
        .alphabet-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(40px, 1fr)); gap: 8px; margin-top: 10px; }
        .letter-option { padding: 10px; text-align: center; background: white; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; transition: all 0.2s; }
        .letter-option.selected { background: #a8edea; border-color: #26a69a; color: #00695c; font-weight: bold; }
        
        .generate-btn { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #2c3e50; border: none; padding: 15px 25px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin-top: 10px; }
        .generate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(168, 237, 234, 0.3); }
        
        .results-section { margin-top: 30px; }
        .results-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.2rem; }
        
        .results-display { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; max-height: 300px; overflow-y: auto; font-family: monospace; line-height: 1.8; }
        
        .statistics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 20px; }
        .stat-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #a8edea; text-align: center; }
        .stat-label { color: #4527a0; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .stat-value { font-size: 1.15rem; font-weight: bold; color: #5e35b1; }
        
        .frequency-chart { background: white; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .frequency-chart h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.2rem; }
        .chart-container { height: 300px; width: 100%; background: #f8f9fa; border-radius: 8px; display: flex; align-items: flex-end; padding: 15px; gap: 2px; }
        .chart-bar { background: linear-gradient(to top, #a8edea, #fed6e3); border-radius: 2px 2px 0 0; flex: 1; position: relative; min-width: 20px; }
        .chart-bar-label { position: absolute; bottom: -25px; left: 0; right: 0; text-align: center; font-size: 0.7rem; color: #7f8c8d; }
        
        .quick-actions { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-top: 20px; }
        .action-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .action-btn:hover { border-color: #a8edea; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(168, 237, 234, 0.15); }
        .action-value { font-weight: bold; color: #a8edea; font-size: 1rem; }
        .action-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .alphabet-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .alphabet-table th, .alphabet-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .alphabet-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .alphabet-table tr:hover { background: #f5f5f5; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #a8edea; }
        .formula-box strong { color: #a8edea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .statistics-grid { grid-template-columns: repeat(2, 1fr); }
            .header h1 { font-size: 1.5rem; }
            .alphabet-grid { grid-template-columns: repeat(auto-fill, minmax(35px, 1fr)); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔤 Advanced Random Letter Generator</h1>
            <p>Generate random letters from multiple alphabets, create patterns, words, and analyze frequency distributions</p>
        </div>

        <div class="generator-card">
            <div class="control-panel">
                <div class="panel-section">
                    <h3>🔤 Basic Settings</h3>
                    <div class="input-group">
                        <label for="method">Generation Method</label>
                        <div class="input-wrapper">
                            <select id="method">
                                <option value="random">Random Letters</option>
                                <option value="pattern">Pattern-based</option>
                                <option value="words">Random Words</option>
                                <option value="sentences">Random Sentences</option>
                                <option value="custom">Custom Character Set</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="count">Number of Items</label>
                        <div class="input-wrapper">
                            <input type="number" id="count" min="1" max="1000" value="50">
                        </div>
                    </div>
                    
                    <div class="input-group" id="patternGroup" style="display: none;">
                        <label for="pattern">Pattern (use ? for random letters)</label>
                        <div class="input-wrapper">
                            <input type="text" id="pattern" placeholder="A??B??C??" value="A??B??C??">
                        </div>
                    </div>
                    
                    <div class="input-group" id="customGroup" style="display: none;">
                        <label for="customChars">Custom Characters</label>
                        <div class="input-wrapper">
                            <input type="text" id="customChars" placeholder="ABC123!@#" value="ABC123!@#">
                        </div>
                    </div>
                </div>
                
                <div class="panel-section">
                    <h3>🌍 Alphabet Selection</h3>
                    <div class="input-group">
                        <label for="alphabetType">Alphabet Type</label>
                        <div class="input-wrapper">
                            <select id="alphabetType">
                                <option value="english_upper">English Uppercase (A-Z)</option>
                                <option value="english_lower">English Lowercase (a-z)</option>
                                <option value="english_both">English Both Cases</option>
                                <option value="custom">Custom Selection</option>
                                <option value="greek">Greek Alphabet</option>
                                <option value="cyrillic">Cyrillic Alphabet</option>
                                <option value="international">International Characters</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group" id="customAlphabetGroup" style="display: none;">
                        <label>Select Custom Letters</label>
                        <div class="alphabet-grid" id="customAlphabetGrid">
                            <!-- Letters will be populated by JavaScript -->
                        </div>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="includeNumbers" checked>
                        <label for="includeNumbers">Include numbers (0-9)</label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="includeSymbols">
                        <label for="includeSymbols">Include symbols (!@#$% etc.)</label>
                    </div>
                </div>
                
                <div class="panel-section">
                    <h3>⚙️ Advanced Options</h3>
                    <div class="input-group">
                        <label for="outputFormat">Output Format</label>
                        <div class="input-wrapper">
                            <select id="outputFormat">
                                <option value="continuous">Continuous Text</option>
                                <option value="spaces">With Spaces</option>
                                <option value="lines">One Per Line</option>
                                <option value="csv">CSV Format</option>
                                <option value="json">JSON Array</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="sort">Sort Results</label>
                        <div class="input-wrapper">
                            <select id="sort">
                                <option value="none">No sorting</option>
                                <option value="asc">Alphabetical A-Z</option>
                                <option value="desc">Alphabetical Z-A</option>
                                <option value="random">Random Order</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="unique" checked>
                        <label for="unique">Unique characters only</label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="frequencyChart">
                        <label for="frequencyChart">Show frequency chart</label>
                    </div>
                </div>
            </div>
            
            <button class="generate-btn" onclick="generateLetters()">🔤 Generate Random Letters</button>
            
            <div class="quick-actions">
                <div class="action-btn" onclick="setQuickAction('password')">
                    <div class="action-value">Password</div>
                    <div class="action-label">12 chars, mixed</div>
                </div>
                <div class="action-btn" onclick="setQuickAction('code')">
                    <div class="action-value">Code</div>
                    <div class="action-label">8 chars, uppercase</div>
                </div>
                <div class="action-btn" onclick="setQuickAction('name')">
                    <div class="action-value">Name</div>
                    <div class="action-label">Random words</div>
                </div>
                <div class="action-btn" onclick="setQuickAction('lorem')">
                    <div class="action-value">Lorem Ipsum</div>
                    <div class="action-label">Random text</div>
                </div>
            </div>
            
            <div class="results-section">
                <h3>📋 Generated Output</h3>
                <div class="results-display" id="resultsDisplay">
                    <div class="result-item">Results will appear here...</div>
                </div>
                
                <div class="statistics-grid" id="statisticsGrid">
                    <!-- Statistics will be populated here -->
                </div>
                
                <div class="frequency-chart" id="frequencyChart" style="display: none;">
                    <h3>📊 Letter Frequency Distribution</h3>
                    <div class="chart-container" id="chartContainer">
                        <!-- Chart bars will be populated here -->
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🔤 Advanced Random Letter Generation</h2>
            
            <p>Generate random letters and text using multiple alphabets, patterns, and statistical distributions for various applications.</p>

            <h3>🌍 Alphabet Systems</h3>
            <table class="alphabet-table">
                <thead>
                    <tr>
                        <th>Alphabet</th>
                        <th>Characters</th>
                        <th>Usage</th>
                        <th>Letter Count</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>English (Latin)</strong></td>
                        <td>A-Z, a-z</td>
                        <td>Global, most languages</td>
                        <td>26 letters</td>
                    </tr>
                    <tr>
                        <td><strong>Greek</strong></td>
                        <td>Α-Ω, α-ω</td>
                        <td>Greece, mathematics, science</td>
                        <td>24 letters</td>
                    </tr>
                    <tr>
                        <td><strong>Cyrillic</strong></td>
                        <td>А-Я, а-я</td>
                        <td>Russian, Slavic languages</td>
                        <td>33 letters (Russian)</td>
                    </tr>
                    <tr>
                        <td><strong>International</strong></td>
                        <td>À-ÿ, accented letters</td>
                        <td>European languages</td>
                        <td>Varies</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Letter Frequency in English:</strong><br>
                E (12.7%), T (9.1%), A (8.2%), O (7.5%), I (7.0%), N (6.7%), S (6.3%), H (6.1%), R (6.0%)<br>
                Least common: Z (0.07%), Q (0.10%), J (0.15%), X (0.15%)
            </div>

            <h3>🎯 Applications</h3>
            <table class="alphabet-table">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Typical Use</th>
                        <th>Recommended Settings</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Password Generation</strong></td>
                        <td>Security, authentication</td>
                        <td>Mixed case, numbers, symbols, 12+ characters</td>
                    </tr>
                    <tr>
                        <td><strong>Code Generation</strong></td>
                        <td>Verification codes, coupons</td>
                        <td>Uppercase only, numbers, 6-8 characters</td>
                    </tr>
                    <tr>
                        <td><strong>Test Data</strong></td>
                        <td>Software testing, databases</td>
                        <td>Realistic names, addresses, mixed content</td>
                    </tr>
                    <tr>
                        <td><strong>Cryptography</strong></td>
                        <td>Encryption, ciphers</td>
                        <td>True random, uniform distribution</td>
                    </tr>
                    <tr>
                        <td><strong>Language Learning</strong></td>
                        <td>Vocabulary practice, exercises</td>
                        <td>Target language alphabet, word patterns</td>
                    </tr>
                    <tr>
                        <td><strong>Creative Writing</strong></td>
                        <td>Name generation, inspiration</td>
                        <td>Pattern-based, pronounceable combinations</td>
                    </tr>
                </tbody>
            </table>

            <h3>📊 Statistical Properties</h3>
            <ul>
                <li><strong>Uniform Distribution:</strong> All letters have equal probability</li>
                <li><strong>Weighted Distribution:</strong> Letters appear according to natural frequency</li>
                <li><strong>Markov Chain:</strong> Letters follow probabilistic sequences based on previous characters</li>
                <li><strong>Pattern-based:</strong> Follow specific patterns or templates</li>
            </ul>

            <h3>🔢 Character Categories</h3>
            <div class="formula-box">
                <strong>Uppercase Letters:</strong> A-Z (26 characters)<br>
                <strong>Lowercase Letters:</strong> a-z (26 characters)<br>
                <strong>Numbers:</strong> 0-9 (10 characters)<br>
                <strong>Common Symbols:</strong> !@#$%^&*()_-+=[]{}|;:,.<>?/~` (30+ characters)<br>
                <strong>Total Basic Set:</strong> 26 + 26 + 10 + 32 = 94 characters
            </div>

            <h3>🌐 International Alphabets</h3>
            <table class="alphabet-table">
                <thead>
                    <tr>
                        <th>Language</th>
                        <th>Alphabet</th>
                        <th>Notable Features</th>
                        <th>Letter Count</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>English</strong></td>
                        <td>Latin</td>
                        <td>No diacritics</td>
                        <td>26</td>
                    </tr>
                    <tr>
                        <td><strong>Spanish</strong></td>
                        <td>Latin + ñ</td>
                        <td>Ñ, accented vowels</td>
                        <td>27</td>
                    </tr>
                    <tr>
                        <td><strong>French</strong></td>
                        <td>Latin</td>
                        <td>Many accented letters: é, è, ê, etc.</td>
                        <td>26 + diacritics</td>
                    </tr>
                    <tr>
                        <td><strong>German</strong></td>
                        <td>Latin</td>
                        <td>Umlauts: ä, ö, ü, ß</td>
                        <td>26 + 4 special</td>
                    </tr>
                    <tr>
                        <td><strong>Russian</strong></td>
                        <td>Cyrillic</td>
                        <td>Different script, 33 letters</td>
                        <td>33</td>
                    </tr>
                    <tr>
                        <td><strong>Greek</strong></td>
                        <td>Greek</td>
                        <td>Ancient and modern usage</td>
                        <td>24</td>
                    </tr>
                </tbody>
            </table>

            <h3>💡 Generation Techniques</h3>
            <ul>
                <li><strong>Random Sampling:</strong> Pure random selection from character set</li>
                <li><strong>Pattern Filling:</strong> Replace placeholders in templates</li>
                <li><strong>Markov Chains:</strong> Generate realistic text based on probability matrices</li>
                <li><strong>Dictionary-based:</strong> Select from word lists or dictionaries</li>
                <li><strong>Rule-based:</strong> Apply linguistic rules for pronounceability</li>
            </ul>

            <h3>🔐 Security Considerations</h3>
            <div class="formula-box">
                <strong>For Cryptographic Use:</strong><br>
                • Use cryptographically secure random number generators<br>
                • Avoid patterns or predictable sequences<br>
                • Include sufficient entropy (character variety)<br>
                • Consider character set size: 26 letters = 4.7 bits/char, 94 chars = 6.6 bits/char
            </div>

            <h3>📈 Entropy and Combinations</h3>
            <table class="alphabet-table">
                <thead>
                    <tr>
                        <th>Character Set</th>
                        <th>Size</th>
                        <th>Bits per Character</th>
                        <th>8-char Combinations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Lowercase only</td>
                        <td>26</td>
                        <td>4.7</td>
                        <td>2.1 × 10¹¹</td>
                    </tr>
                    <tr>
                        <td>Mixed Case</td>
                        <td>52</td>
                        <td>5.7</td>
                        <td>5.3 × 10¹³</td>
                    </tr>
                    <tr>
                        <td>Alphanumeric</td>
                        <td>62</td>
                        <td>6.0</td>
                        <td>2.2 × 10¹⁴</td>
                    </tr>
                    <tr>
                        <td>Full Set</td>
                        <td>94</td>
                        <td>6.6</td>
                        <td>6.1 × 10¹⁵</td>
                    </tr>
                </tbody>
            </table>

            <h3>🎲 Pattern Examples</h3>
            <ul>
                <li><strong>License Plates:</strong> ABC-123, 1A2B3C</li>
                <li><strong>Product Codes:</strong> XXX-999-XXX, AA##BB##</li>
                <li><strong>Name Patterns:</strong> Cvcvc (Consonant-vowel pattern)</li>
                <li><strong>Word Templates:</strong> ????ing, re????, un????</li>
            </ul>

            <h3>🔧 Technical Implementation</h3>
            <div class="formula-box">
                <strong>Character Code Ranges:</strong><br>
                • A-Z: 65-90 (Unicode)<br>
                • a-z: 97-122<br>
                • 0-9: 48-57<br>
                • Greek: 913-937 (upper), 945-969 (lower)<br>
                • Cyrillic: 1040-1071 (upper), 1072-1103 (lower)
            </div>

            <h3>🌍 Cultural Considerations</h3>
            <ul>
                <li>Some letter combinations may be offensive in certain languages</li>
                <li>Consider local naming conventions for realistic data</li>
                <li>Be aware of script direction (LTR vs RTL)</li>
                <li>Respect cultural sensitivities in character selection</li>
            </ul>
        </div>

        <div class="footer">
            <p>🔤 Advanced Random Letter Generator | Multiple Alphabets & Patterns</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">English, Greek, Cyrillic alphabets with pattern generation and statistical analysis</p>
        </div>
    </div>

    <script>
        // DOM elements
        const methodSelect = document.getElementById('method');
        const countInput = document.getElementById('count');
        const patternGroup = document.getElementById('patternGroup');
        const patternInput = document.getElementById('pattern');
        const customGroup = document.getElementById('customGroup');
        const customCharsInput = document.getElementById('customChars');
        const alphabetTypeSelect = document.getElementById('alphabetType');
        const customAlphabetGroup = document.getElementById('customAlphabetGroup');
        const customAlphabetGrid = document.getElementById('customAlphabetGrid');
        const includeNumbersCheckbox = document.getElementById('includeNumbers');
        const includeSymbolsCheckbox = document.getElementById('includeSymbols');
        const outputFormatSelect = document.getElementById('outputFormat');
        const sortSelect = document.getElementById('sort');
        const uniqueCheckbox = document.getElementById('unique');
        const frequencyChartCheckbox = document.getElementById('frequencyChart');
        const resultsDisplay = document.getElementById('resultsDisplay');
        const statisticsGrid = document.getElementById('statisticsGrid');
        const frequencyChartDiv = document.getElementById('frequencyChart');
        const chartContainer = document.getElementById('chartContainer');

        // Character sets
        const characterSets = {
            english_upper: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            english_lower: 'abcdefghijklmnopqrstuvwxyz',
            english_both: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',
            numbers: '0123456789',
            symbols: '!@#$%^&*()_-+=[]{}|;:,.<>?/~`',
            greek: 'ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩαβγδεζηθικλμνξοπρστυφχψω',
            cyrillic: 'АБВГДЕЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдежзийклмнопрстуфхцчшщъыьэюя',
            international: 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ'
        };

        // Word lists for random word generation
        const wordLists = {
            short: ['the', 'and', 'for', 'are', 'but', 'not', 'you', 'all', 'can', 'had', 'her', 'was', 'one', 'our', 'out', 'get', 'has', 'him', 'his', 'how', 'man', 'new', 'now', 'old', 'see', 'two', 'way', 'who', 'boy', 'did', 'its', 'let', 'put', 'say', 'she', 'too', 'use'],
            medium: ['about', 'after', 'again', 'below', 'could', 'every', 'first', 'found', 'great', 'house', 'large', 'learn', 'never', 'other', 'place', 'plant', 'point', 'right', 'small', 'sound', 'spell', 'still', 'study', 'their', 'there', 'these', 'thing', 'think', 'three', 'water', 'where', 'which', 'world', 'would', 'write'],
            long: ['another', 'because', 'between', 'country', 'example', 'following', 'different', 'important', 'american', 'everything', 'sometimes', 'mountain', 'question', 'anything', 'without', 'thought', 'school', 'system', 'program', 'however', 'business', 'problem', 'company', 'number', 'government', 'although', 'something', 'together']
        };

        // Update UI based on selected method
        methodSelect.addEventListener('change', updateMethodUI);
        alphabetTypeSelect.addEventListener('change', updateAlphabetUI);
        
        function updateMethodUI() {
            const method = methodSelect.value;
            
            // Hide all method-specific groups first
            patternGroup.style.display = 'none';
            customGroup.style.display = 'none';
            
            // Show relevant groups
            if (method === 'pattern') {
                patternGroup.style.display = 'block';
            } else if (method === 'custom') {
                customGroup.style.display = 'block';
            }
        }

        function updateAlphabetUI() {
            const alphabetType = alphabetTypeSelect.value;
            
            // Show/hide custom alphabet grid
            if (alphabetType === 'custom') {
                customAlphabetGroup.style.display = 'block';
                populateCustomAlphabetGrid();
            } else {
                customAlphabetGroup.style.display = 'none';
            }
        }

        function populateCustomAlphabetGrid() {
            customAlphabetGrid.innerHTML = '';
            
            // Create options for A-Z
            for (let i = 65; i <= 90; i++) {
                const letter = String.fromCharCode(i);
                const option = document.createElement('div');
                option.className = 'letter-option';
                option.textContent = letter;
                option.dataset.letter = letter;
                option.addEventListener('click', function() {
                    this.classList.toggle('selected');
                });
                customAlphabetGrid.appendChild(option);
            }
            
            // Create options for a-z
            for (let i = 97; i <= 122; i++) {
                const letter = String.fromCharCode(i);
                const option = document.createElement('div');
                option.className = 'letter-option';
                option.textContent = letter;
                option.dataset.letter = letter;
                option.addEventListener('click', function() {
                    this.classList.toggle('selected');
                });
                customAlphabetGrid.appendChild(option);
            }
        }

        // Initialize UI
        updateMethodUI();
        updateAlphabetUI();

        // Generate letters based on selected method
        function generateLetters() {
            const method = methodSelect.value;
            const count = parseInt(countInput.value);
            const alphabetType = alphabetTypeSelect.value;
            const includeNumbers = includeNumbersCheckbox.checked;
            const includeSymbols = includeSymbolsCheckbox.checked;
            const outputFormat = outputFormatSelect.value;
            const sort = sortSelect.value;
            const unique = uniqueCheckbox.checked;
            const showFrequencyChart = frequencyChartCheckbox.checked;
            
            let result = [];
            
            switch(method) {
                case 'random':
                    result = generateRandom(count, alphabetType, includeNumbers, includeSymbols, unique);
                    break;
                case 'pattern':
                    const pattern = patternInput.value;
                    result = generatePattern(count, pattern, alphabetType, includeNumbers, includeSymbols);
                    break;
                case 'words':
                    result = generateWords(count);
                    break;
                case 'sentences':
                    result = generateSentences(count);
                    break;
                case 'custom':
                    const customChars = customCharsInput.value;
                    result = generateCustom(count, customChars, unique);
                    break;
            }
            
            // Apply sorting if requested
            if (sort !== 'none' && method !== 'words' && method !== 'sentences') {
                result.sort((a, b) => sort === 'asc' ? a.localeCompare(b) : b.localeCompare(a));
            }
            
            // Format output
            const formattedResult = formatOutput(result, outputFormat);
            
            // Display results
            displayResults(formattedResult, outputFormat);
            
            // Calculate and display statistics
            const allChars = result.join('');
            displayStatistics(allChars, result.length);
            
            // Show frequency chart if requested
            if (showFrequencyChart) {
                displayFrequencyChart(allChars);
                frequencyChartDiv.style.display = 'block';
            } else {
                frequencyChartDiv.style.display = 'none';
            }
        }

        // Generation methods
        function generateRandom(count, alphabetType, includeNumbers, includeSymbols, unique) {
            let charset = '';
            
            // Add selected alphabet
            if (alphabetType === 'custom') {
                const selectedLetters = Array.from(customAlphabetGrid.querySelectorAll('.letter-option.selected'))
                    .map(el => el.dataset.letter)
                    .join('');
                charset += selectedLetters;
            } else {
                charset += characterSets[alphabetType];
            }
            
            // Add numbers if requested
            if (includeNumbers) {
                charset += characterSets.numbers;
            }
            
            // Add symbols if requested
            if (includeSymbols) {
                charset += characterSets.symbols;
            }
            
            // If charset is empty, use English uppercase as fallback
            if (charset.length === 0) {
                charset = characterSets.english_upper;
            }
            
            const result = [];
            const used = new Set();
            
            for (let i = 0; i < count; i++) {
                let char;
                do {
                    const randomIndex = Math.floor(Math.random() * charset.length);
                    char = charset[randomIndex];
                } while (unique && used.has(char) && used.size < charset.length);
                
                if (unique) used.add(char);
                result.push(char);
                
                // Safety check to prevent infinite loops
                if (unique && used.size >= charset.length) {
                    break;
                }
            }
            
            return result;
        }

        function generatePattern(count, pattern, alphabetType, includeNumbers, includeSymbols) {
            const result = [];
            let charset = characterSets[alphabetType];
            
            if (includeNumbers) charset += characterSets.numbers;
            if (includeSymbols) charset += characterSets.symbols;
            
            for (let i = 0; i < count; i++) {
                let generated = '';
                for (const char of pattern) {
                    if (char === '?') {
                        const randomIndex = Math.floor(Math.random() * charset.length);
                        generated += charset[randomIndex];
                    } else {
                        generated += char;
                    }
                }
                result.push(generated);
            }
            
            return result;
        }

        function generateWords(count) {
            const result = [];
            const allWords = [...wordLists.short, ...wordLists.medium, ...wordLists.long];
            
            for (let i = 0; i < count; i++) {
                const randomIndex = Math.floor(Math.random() * allWords.length);
                result.push(allWords[randomIndex]);
            }
            
            return result;
        }

        function generateSentences(count) {
            const result = [];
            const allWords = [...wordLists.short, ...wordLists.medium, ...wordLists.long];
            
            for (let i = 0; i < count; i++) {
                const wordCount = 5 + Math.floor(Math.random() * 10); // 5-14 words
                let sentence = '';
                
                for (let j = 0; j < wordCount; j++) {
                    const randomIndex = Math.floor(Math.random() * allWords.length);
                    if (j === 0) {
                        // Capitalize first word
                        sentence += allWords[randomIndex].charAt(0).toUpperCase() + allWords[randomIndex].slice(1);
                    } else {
                        sentence += allWords[randomIndex];
                    }
                    
                    if (j < wordCount - 1) {
                        sentence += ' ';
                    }
                }
                
                sentence += '.';
                result.push(sentence);
            }
            
            return result;
        }

        function generateCustom(count, customChars, unique) {
            const result = [];
            const used = new Set();
            
            for (let i = 0; i < count; i++) {
                let char;
                do {
                    const randomIndex = Math.floor(Math.random() * customChars.length);
                    char = customChars[randomIndex];
                } while (unique && used.has(char) && used.size < customChars.length);
                
                if (unique) used.add(char);
                result.push(char);
                
                // Safety check
                if (unique && used.size >= customChars.length) {
                    break;
                }
            }
            
            return result;
        }

        // Format output based on selected format
        function formatOutput(result, format) {
            switch(format) {
                case 'continuous':
                    return result.join('');
                case 'spaces':
                    return result.join(' ');
                case 'lines':
                    return result.join('\n');
                case 'csv':
                    return result.join(',');
                case 'json':
                    return JSON.stringify(result, null, 2);
                default:
                    return result.join('');
            }
        }

        // Display results in the results area
        function displayResults(formattedResult, format) {
            resultsDisplay.innerHTML = '';
            
            if (format === 'lines') {
                const lines = formattedResult.split('\n');
                lines.forEach(line => {
                    const item = document.createElement('div');
                    item.className = 'result-item';
                    item.textContent = line;
                    resultsDisplay.appendChild(item);
                });
            } else {
                const item = document.createElement('div');
                item.className = 'result-item';
                item.textContent = formattedResult;
                resultsDisplay.appendChild(item);
            }
        }

        // Calculate and display statistics
        function displayStatistics(allChars, itemCount) {
            if (allChars.length === 0) {
                statisticsGrid.innerHTML = '<div class="stat-card"><div class="stat-label">No data</div><div class="stat-value">-</div></div>';
                return;
            }
            
            // Character statistics
            const charCount = allChars.length;
            const uniqueChars = new Set(allChars).size;
            
            // Letter frequency (uppercase and lowercase considered same for counting)
            const upperChars = allChars.toUpperCase();
            const letterCount = (upperChars.match(/[A-Z]/g) || []).length;
            const numberCount = (allChars.match(/[0-9]/g) || []).length;
            const symbolCount = (allChars.match(/[^A-Za-z0-9\s]/g) || []).length;
            
            // Update statistics grid
            statisticsGrid.innerHTML = `
                <div class="stat-card">
                    <div class="stat-label">Total Characters</div>
                    <div class="stat-value">${charCount}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Unique Characters</div>
                    <div class="stat-value">${uniqueChars}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Items Generated</div>
                    <div class="stat-value">${itemCount}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Letters</div>
                    <div class="stat-value">${letterCount}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Numbers</div>
                    <div class="stat-value">${numberCount}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Symbols</div>
                    <div class="stat-value">${symbolCount}</div>
                </div>
            `;
        }

        // Display frequency chart
        function displayFrequencyChart(allChars) {
            // Count frequency of each letter (case insensitive)
            const frequency = {};
            const upperChars = allChars.toUpperCase();
            
            for (const char of upperChars) {
                if (/[A-Z]/.test(char)) {
                    frequency[char] = (frequency[char] || 0) + 1;
                }
            }
            
            // Find max frequency for scaling
            const maxFreq = Math.max(...Object.values(frequency));
            
            // Create chart bars for A-Z
            chartContainer.innerHTML = '';
            for (let i = 65; i <= 90; i++) {
                const letter = String.fromCharCode(i);
                const freq = frequency[letter] || 0;
                const percentage = maxFreq > 0 ? (freq / maxFreq) * 100 : 0;
                
                const bar = document.createElement('div');
                bar.className = 'chart-bar';
                bar.style.height = `${percentage}%`;
                
                const label = document.createElement('div');
                label.className = 'chart-bar-label';
                label.textContent = `${letter} (${freq})`;
                
                bar.appendChild(label);
                chartContainer.appendChild(bar);
            }
        }

        // Quick action presets
        function setQuickAction(action) {
            switch(action) {
                case 'password':
                    alphabetTypeSelect.value = 'english_both';
                    includeNumbersCheckbox.checked = true;
                    includeSymbolsCheckbox.checked = true;
                    countInput.value = 12;
                    methodSelect.value = 'random';
                    uniqueCheckbox.checked = false;
                    break;
                case 'code':
                    alphabetTypeSelect.value = 'english_upper';
                    includeNumbersCheckbox.checked = true;
                    includeSymbolsCheckbox.checked = false;
                    countInput.value = 8;
                    methodSelect.value = 'random';
                    uniqueCheckbox.checked = false;
                    break;
                case 'name':
                    countInput.value = 5;
                    methodSelect.value = 'words';
                    break;
                case 'lorem':
                    countInput.value = 3;
                    methodSelect.value = 'sentences';
                    break;
            }
            
            updateMethodUI();
            updateAlphabetUI();
            generateLetters();
        }

        // Initial generation on page load
        generateLetters();
    </script>
</body>
</html>
