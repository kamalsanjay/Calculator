<?php
/**
 * Case Converter
 * File: utility/case-converter.php
 * Description: Advanced text case conversion tool with multiple formatting options
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Converter - Advanced Text Case Transformation Tool</title>
    <meta name="description" content="Convert text between different cases: uppercase, lowercase, title case, sentence case, camel case, pascal case, snake case, kebab case, and more.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-section { margin-bottom: 25px; }
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .text-input { width: 100%; padding: 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; font-family: inherit; resize: vertical; min-height: 120px; transition: all 0.3s; }
        .text-input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .case-options { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .case-option { background: #f8f9fa; padding: 20px; border-radius: 10px; cursor: pointer; transition: all 0.3s; border: 2px solid transparent; }
        .case-option:hover { border-color: #667eea; transform: translateY(-2px); }
        .case-option.active { border-color: #667eea; background: #ede7f6; }
        .case-icon { font-size: 1.5rem; margin-bottom: 10px; }
        .case-name { font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .case-desc { font-size: 0.85rem; color: #7f8c8d; }
        
        .buttons-row { display: flex; gap: 15px; margin-top: 25px; }
        .convert-btn { flex: 1; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; }
        .convert-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .reset-btn { background: #95a5a6; color: white; border: none; padding: 14px 20px; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; }
        .reset-btn:hover { background: #7f8c8d; }
        
        .output-section { margin-top: 30px; }
        .output-header { display: flex; justify-content: between; align-items: center; margin-bottom: 10px; }
        .output-header h3 { color: #2c3e50; font-size: 1.1rem; }
        .copy-btn { background: #667eea; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 0.9rem; cursor: pointer; transition: all 0.3s; }
        .copy-btn:hover { background: #5a6fd8; }
        
        .output-display { background: #f8f9fa; padding: 20px; border-radius: 10px; border: 2px solid #e0e0e0; min-height: 120px; font-family: monospace; white-space: pre-wrap; word-wrap: break-word; }
        
        .quick-actions { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-actions h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #667eea; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15); }
        .quick-value { font-weight: bold; color: #667eea; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .history-section { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .history-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .history-list { display: flex; flex-direction: column; gap: 10px; max-height: 200px; overflow-y: auto; }
        .history-item { display: flex; justify-content: between; align-items: center; padding: 12px; background: white; border-radius: 8px; border-left: 4px solid #667eea; }
        .history-text { font-family: monospace; font-size: 0.9rem; flex: 1; margin-right: 15px; }
        .history-type { font-size: 0.8rem; color: #7f8c8d; margin-right: 15px; }
        .history-copy { background: #667eea; color: white; border: none; border-radius: 4px; padding: 5px 10px; font-size: 0.8rem; cursor: pointer; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .case-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin: 20px 0; }
        .case-card { background: #ede7f6; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; }
        .case-card h4 { color: #4527a0; margin-bottom: 10px; }
        .case-card code { background: white; padding: 2px 6px; border-radius: 4px; font-family: monospace; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .toast { position: fixed; bottom: 20px; right: 20px; background: #2c3e50; color: white; padding: 12px 20px; border-radius: 5px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transform: translateY(100px); opacity: 0; transition: all 0.3s; z-index: 1000; }
        .toast.show { transform: translateY(0); opacity: 1; }
        
        @media (max-width: 768px) {
            .case-options { grid-template-columns: 1fr; }
            .buttons-row { flex-direction: column; }
            .quick-grid { grid-template-columns: repeat(2, 1fr); }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔠 Advanced Case Converter</h1>
            <p>Transform text between different cases: uppercase, lowercase, title case, camel case, snake case, and more</p>
        </div>

        <div class="converter-card">
            <div class="input-section">
                <div class="input-group">
                    <label for="inputText">Input Text</label>
                    <textarea id="inputText" class="text-input" placeholder="Enter your text here...">Hello world! This is a sample text for case conversion.</textarea>
                </div>
            </div>

            <div class="case-options" id="caseOptions">
                <!-- Case options will be populated by JavaScript -->
            </div>

            <div class="buttons-row">
                <button class="convert-btn" id="convertButton">Convert Text</button>
                <button class="reset-btn" id="resetButton">Reset</button>
            </div>

            <div class="output-section">
                <div class="output-header">
                    <h3>Converted Text</h3>
                    <button class="copy-btn" id="copyButton">Copy Result</button>
                </div>
                <div class="output-display" id="outputText">Your converted text will appear here...</div>
            </div>

            <div class="quick-actions">
                <h3>⚡ Quick Actions</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setSampleText('programming')">
                        <div class="quick-value">Code</div>
                        <div class="quick-label">Variable names</div>
                    </div>
                    <div class="quick-btn" onclick="setSampleText('title')">
                        <div class="quick-value">Title</div>
                        <div class="quick-label">Article titles</div>
                    </div>
                    <div class="quick-btn" onclick="setSampleText('sentence')">
                        <div class="quick-value">Sentence</div>
                        <div class="quick-label">Proper sentences</div>
                    </div>
                    <div class="quick-btn" onclick="setSampleText('database')">
                        <div class="quick-value">Database</div>
                        <div class="quick-label">Column names</div>
                    </div>
                </div>
            </div>

            <div class="history-section">
                <h3>📋 Conversion History</h3>
                <div class="history-list" id="conversionHistory"></div>
            </div>
        </div>

        <div class="info-section">
            <h2>🔠 Text Case Conversion Guide</h2>
            
            <p>Case conversion is essential for programming, writing, data processing, and maintaining consistency across documents and codebases.</p>

            <h3>📊 Common Case Types</h3>
            <div class="case-grid">
                <div class="case-card">
                    <h4>UPPERCASE</h4>
                    <p>All letters capitalized. Used for headings, acronyms, and emphasis.</p>
                    <p><strong>Example:</strong> <code>HELLO WORLD</code></p>
                </div>
                <div class="case-card">
                    <h4>lowercase</h4>
                    <p>All letters in lower case. Common in programming and informal writing.</p>
                    <p><strong>Example:</strong> <code>hello world</code></p>
                </div>
                <div class="case-card">
                    <h4>Title Case</h4>
                    <p>First letter of each word capitalized. Used for titles and headings.</p>
                    <p><strong>Example:</strong> <code>Hello World</code></p>
                </div>
                <div class="case-card">
                    <h4>Sentence case</h4>
                    <p>Only the first letter of the sentence capitalized. Standard for prose.</p>
                    <p><strong>Example:</strong> <code>Hello world</code></p>
                </div>
            </div>

            <h3>💻 Programming Cases</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Case Type</th>
                        <th>Format</th>
                        <th>Common Uses</th>
                        <th>Example</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>camelCase</strong></td>
                        <td>firstWordCapitalized</td>
                        <td>JavaScript variables, Java methods</td>
                        <td><code>helloWorld</code></td>
                    </tr>
                    <tr>
                        <td><strong>PascalCase</strong></td>
                        <td>EveryWordCapitalized</td>
                        <td>Class names, C#/Java types</td>
                        <td><code>HelloWorld</code></td>
                    </tr>
                    <tr>
                        <td><strong>snake_case</strong></td>
                        <td>words_with_underscores</td>
                        <td>Python variables, database columns</td>
                        <td><code>hello_world</code></td>
                    </tr>
                    <tr>
                        <td><strong>kebab-case</strong></td>
                        <td>words-with-hyphens</td>
                        <td>CSS classes, URLs, file names</td>
                        <td><code>hello-world</code></td>
                    </tr>
                    <tr>
                        <td><strong>CONSTANT_CASE</strong></td>
                        <td>UPPER_WITH_UNDERSCORES</td>
                        <td>Constants, environment variables</td>
                        <td><code>HELLO_WORLD</code></td>
                    </tr>
                </tbody>
            </table>

            <h3>🔤 Specialized Cases</h3>
            <div class="case-grid">
                <div class="case-card">
                    <h4>dot.case</h4>
                    <p>Words separated by dots. Used in domain names and some configurations.</p>
                    <p><strong>Example:</strong> <code>hello.world</code></p>
                </div>
                <div class="case-card">
                    <h4>path/case</h4>
                    <p>Words separated by slashes. Used in file paths and URLs.</p>
                    <p><strong>Example:</strong> <code>hello/world</code></p>
                </div>
                <div class="case-card">
                    <h4>Train-Case</h4>
                    <p>Similar to kebab-case but capitalized. Used in some naming conventions.</p>
                    <p><strong>Example:</strong> <code>Hello-World</code></p>
                </div>
                <div class="case-card">
                    <h4>cobol case</h4>
                    <p>Words separated by hyphens, all uppercase. Used in COBOL programming.</p>
                    <p><strong>Example:</strong> <code>HELLO-WORLD</code></p>
                </div>
            </div>

            <h3>🌐 Language-Specific Considerations</h3>
            <div class="formula-box">
                <strong>English:</strong> Standard case rules apply<br>
                <strong>German:</strong> All nouns are capitalized in sentence case<br>
                <strong>Turkish:</strong> Special handling for dotted and dotless i (İ, ı)<br>
                <strong>Greek:</strong> No case distinction in ancient Greek<br>
                <strong>Arabic/Hebrew:</strong> Typically no case distinction
            </div>

            <h3>💡 Best Practices</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Context</th>
                        <th>Recommended Case</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>JavaScript variables</td>
                        <td>camelCase</td>
                        <td>Convention, readability</td>
                    </tr>
                    <tr>
                        <td>Python variables</td>
                        <td>snake_case</td>
                        <td>PEP 8 standard</td>
                    </tr>
                    <tr>
                        <td>CSS classes</td>
                        <td>kebab-case</td>
                        <td>HTML standard, URL-friendly</td>
                    </tr>
                    <tr>
                        <td>Database columns</td>
                        <td>snake_case</td>
                        <td>SQL convention, case-insensitive</td>
                    </tr>
                    <tr>
                        <td>Constants</td>
                        <td>CONSTANT_CASE</td>
                        <td>Visual distinction</td>
                    </tr>
                    <tr>
                        <td>File names</td>
                        <td>kebab-case</td>
                        <td>Cross-platform compatibility</td>
                    </tr>
                </tbody>
            </table>

            <h3>⚙️ Programming Language Standards</h3>
            <ul>
                <li><strong>JavaScript:</strong> camelCase for variables/functions, PascalCase for classes</li>
                <li><strong>Python:</strong> snake_case for variables/functions, PascalCase for classes</li>
                <li><strong>Java:</strong> camelCase for methods/variables, PascalCase for classes</li>
                <li><strong>C#:</strong> PascalCase for methods/classes, camelCase for parameters</li>
                <li><strong>Ruby:</strong> snake_case for variables/methods, PascalCase for classes</li>
                <li><strong>PHP:</strong> camelCase or snake_case (varies by framework)</li>
                <li><strong>Go:</strong> camelCase for exported identifiers, mixedCase for unexported</li>
            </ul>

            <h3>📝 Writing Conventions</h3>
            <div class="formula-box">
                <strong>Title Case Rules:</strong><br>
                • Capitalize all nouns, pronouns, verbs, adjectives, adverbs<br>
                • Lowercase articles (a, an, the), coordinating conjunctions, prepositions<br>
                • Always capitalize first and last word<br><br>
                <strong>Sentence Case Rules:</strong><br>
                • Capitalize only the first word and proper nouns<br>
                • Use for normal sentences and paragraphs
            </div>

            <h3>🔧 Technical Implementation</h3>
            <p>Case conversion involves several technical considerations:</p>
            <ul>
                <li><strong>Unicode support:</strong> Handling international characters</li>
                <li><strong>Locale awareness:</strong> Language-specific case rules</li>
                <li><strong>Performance:</strong> Efficient string processing</li>
                <li><strong>Edge cases:</strong> Acronyms, numbers, special characters</li>
            </ul>

            <h3>🚀 Advanced Conversion Scenarios</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Scenario</th>
                        <th>Challenge</th>
                        <th>Solution</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mixed case input</td>
                        <td>Preserving intended capitalization</td>
                        <td>Smart detection algorithms</td>
                    </tr>
                    <tr>
                        <td>Acronyms in text</td>
                        <td>Maintaining uppercase for acronyms</td>
                        <td>Acronym dictionaries</td>
                    </tr>
                    <tr>
                        <td>Multiple languages</td>
                        <td>Different case rules per language</td>
                        <td>Locale detection</td>
                    </tr>
                    <tr>
                        <td>Code conversion</td>
                        <td>Handling existing naming conventions</td>
                        <td>Pattern recognition</td>
                    </tr>
                </tbody>
            </table>

            <h3>📚 Historical Context</h3>
            <p>Case sensitivity in computing dates back to early programming languages and systems. The distinction between uppercase and lowercase letters became important with the development of text-based interfaces and programming languages that used case to differentiate identifiers.</p>

            <h3>🔍 Quality Assurance</h3>
            <ul>
                <li>Always test case conversions with sample data</li>
                <li>Verify consistency across your codebase</li>
                <li>Use linters and style checkers to enforce conventions</li>
                <li>Consider automated conversion tools for large codebases</li>
            </ul>
        </div>

        <div class="footer">
            <p>🔠 Advanced Case Converter | Transform Text Between Different Cases</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Convert between uppercase, lowercase, title case, camel case, snake case, kebab case, and more</p>
        </div>
    </div>

    <div class="toast" id="toast">Text copied to clipboard!</div>

    <script>
        // Case conversion functions
        const caseConverters = {
            uppercase: (text) => text.toUpperCase(),
            lowercase: (text) => text.toLowerCase(),
            titlecase: (text) => text.replace(/\w\S*/g, (txt) => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()),
            sentencecase: (text) => text.charAt(0).toUpperCase() + text.slice(1).toLowerCase(),
            camelcase: (text) => text.toLowerCase().replace(/[^a-zA-Z0-9]+(.)/g, (m, chr) => chr.toUpperCase()),
            pascalcase: (text) => text.toLowerCase().replace(/(^\w|\s\w)/g, (m) => m.toUpperCase()).replace(/[^a-zA-Z0-9]/g, ''),
            snakecase: (text) => text.toLowerCase().replace(/[^a-zA-Z0-9]/g, '_'),
            kebabcase: (text) => text.toLowerCase().replace(/[^a-zA-Z0-9]/g, '-'),
            constantcase: (text) => text.toUpperCase().replace(/[^a-zA-Z0-9]/g, '_'),
            dotcase: (text) => text.toLowerCase().replace(/[^a-zA-Z0-9]/g, '.'),
            pathcase: (text) => text.toLowerCase().replace(/[^a-zA-Z0-9]/g, '/'),
            traincase: (text) => text.toLowerCase().replace(/(^\w|\s\w)/g, (m) => m.toUpperCase()).replace(/[^a-zA-Z0-9]/g, '-'),
            cobolcase: (text) => text.toUpperCase().replace(/[^a-zA-Z0-9]/g, '-'),
            alternating: (text) => text.split('').map((char, i) => i % 2 === 0 ? char.toLowerCase() : char.toUpperCase()).join(''),
            inverse: (text) => text.split('').map(char => char === char.toUpperCase() ? char.toLowerCase() : char.toUpperCase()).join('')
        };

        // Case options configuration
        const caseOptions = [
            { id: 'uppercase', name: 'UPPERCASE', desc: 'ALL LETTERS CAPITALIZED', icon: '🔠' },
            { id: 'lowercase', name: 'lowercase', desc: 'all letters lowercase', icon: '🔡' },
            { id: 'titlecase', name: 'Title Case', desc: 'First Letter Of Each Word Capitalized', icon: '🏷️' },
            { id: 'sentencecase', name: 'Sentence case', desc: 'First letter of sentence capitalized', icon: '📝' },
            { id: 'camelcase', name: 'camelCase', desc: 'firstWordCapitalized', icon: '🐫' },
            { id: 'pascalcase', name: 'PascalCase', desc: 'EveryWordCapitalized', icon: '🧩' },
            { id: 'snakecase', name: 'snake_case', desc: 'words_with_underscores', icon: '🐍' },
            { id: 'kebabcase', name: 'kebab-case', desc: 'words-with-hyphens', icon: '🍢' },
            { id: 'constantcase', name: 'CONSTANT_CASE', desc: 'UPPER_WITH_UNDERSCORES', icon: '⚡' },
            { id: 'dotcase', name: 'dot.case', desc: 'words.separated.by.dots', icon: '⏺️' },
            { id: 'pathcase', name: 'path/case', desc: 'words/separated/by/slashes', icon: '📁' },
            { id: 'traincase', name: 'Train-Case', desc: 'Words-With-Hyphens-Capitalized', icon: '🚂' },
            { id: 'cobolcase', name: 'COBOL-CASE', desc: 'WORDS-WITH-HYPHENS-UPPERCASE', icon: '💾' },
            { id: 'alternating', name: 'aLtErNaTiNg', desc: 'alternating upper and lower case', icon: '🔄' },
            { id: 'inverse', name: 'iNVERSE', desc: 'Swap upper and lower case', icon: '🔄' }
        ];

        // DOM elements
        const inputText = document.getElementById('inputText');
        const outputText = document.getElementById('outputText');
        const copyButton = document.getElementById('copyButton');
        const convertButton = document.getElementById('convertButton');
        const resetButton = document.getElementById('resetButton');
        const caseOptionsContainer = document.getElementById('caseOptions');
        const conversionHistory = document.getElementById('conversionHistory');
        const toast = document.getElementById('toast');

        // Initialize
        let selectedCase = 'uppercase';
        let history = JSON.parse(localStorage.getItem('caseConversionHistory')) || [];
        renderCaseOptions();
        updateHistoryDisplay();
        convertText();

        // Event listeners
        convertButton.addEventListener('click', convertText);
        copyButton.addEventListener('click', copyOutput);
        resetButton.addEventListener('click', resetConverter);
        inputText.addEventListener('input', convertText);

        function renderCaseOptions() {
            caseOptionsContainer.innerHTML = '';
            
            caseOptions.forEach(option => {
                const optionElement = document.createElement('div');
                optionElement.className = `case-option ${option.id === selectedCase ? 'active' : ''}`;
                optionElement.innerHTML = `
                    <div class="case-icon">${option.icon}</div>
                    <div class="case-name">${option.name}</div>
                    <div class="case-desc">${option.desc}</div>
                `;
                optionElement.addEventListener('click', () => {
                    selectedCase = option.id;
                    renderCaseOptions();
                    convertText();
                });
                caseOptionsContainer.appendChild(optionElement);
            });
        }

        function convertText() {
            const text = inputText.value.trim();
            if (!text) {
                outputText.textContent = 'Your converted text will appear here...';
                return;
            }

            const converter = caseConverters[selectedCase];
            if (converter) {
                const result = converter(text);
                outputText.textContent = result;
                addToHistory(text, result, selectedCase);
            }
        }

        function copyOutput() {
            if (!outputText.textContent || outputText.textContent.includes('Your converted text')) return;
            
            navigator.clipboard.writeText(outputText.textContent).then(() => {
                showToast('Text copied to clipboard!');
            }).catch(err => {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = outputText.textContent;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showToast('Text copied to clipboard!');
            });
        }

        function resetConverter() {
            inputText.value = '';
            outputText.textContent = 'Your converted text will appear here...';
            selectedCase = 'uppercase';
            renderCaseOptions();
        }

        function addToHistory(original, converted, caseType) {
            // Add to beginning of history
            history.unshift({
                original: original,
                converted: converted,
                caseType: caseType,
                timestamp: new Date().toLocaleString()
            });
            
            // Keep only last 10 conversions
            if (history.length > 10) {
                history = history.slice(0, 10);
            }
            
            // Save to localStorage
            localStorage.setItem('caseConversionHistory', JSON.stringify(history));
            
            // Update display
            updateHistoryDisplay();
        }

        function updateHistoryDisplay() {
            conversionHistory.innerHTML = '';
            
            if (history.length === 0) {
                conversionHistory.innerHTML = '<div style="text-align: center; color: #7f8c8d; padding: 20px;">No conversion history yet</div>';
                return;
            }
            
            history.forEach(item => {
                const caseOption = caseOptions.find(opt => opt.id === item.caseType);
                const historyItem = document.createElement('div');
                historyItem.className = 'history-item';
                historyItem.innerHTML = `
                    <div style="flex: 1;">
                        <div class="history-text">${item.converted}</div>
                        <div class="history-type">${caseOption ? caseOption.name : item.caseType}</div>
                    </div>
                    <button class="history-copy" onclick="copyFromHistory('${item.converted.replace(/'/g, "\\'")}')">Copy</button>
                `;
                conversionHistory.appendChild(historyItem);
            });
        }

        function setSampleText(type) {
            const samples = {
                programming: 'userAuthenticationService validateUserCredentials',
                title: 'the quick brown fox jumps over the lazy dog',
                sentence: 'this is a sample sentence for case conversion. it demonstrates different text transformations.',
                database: 'customer_first_name order_total_amount product_category_id'
            };
            
            inputText.value = samples[type] || samples.sentence;
            convertText();
        }

        function copyFromHistory(text) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('Text copied to clipboard!');
            }).catch(err => {
                // Fallback
                const tempInput = document.createElement('textarea');
                tempInput.value = text;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                showToast('Text copied to clipboard!');
            });
        }

        function showToast(message) {
            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Make functions available globally
        window.setSampleText = setSampleText;
        window.copyFromHistory = copyFromHistory;
    </script>
</body>
</html>
