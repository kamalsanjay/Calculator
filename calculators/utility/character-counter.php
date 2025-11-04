<?php
/**
 * Character Counter
 * File: utility/character-counter.php
 * Description: Advanced text analysis tool with character, word, and sentence counting
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Character Counter - Advanced Text Analysis Tool</title>
    <meta name="description" content="Count characters, words, sentences, paragraphs and analyze text with advanced metrics and readability scores.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .counter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .text-input-container { margin-bottom: 25px; }
        .text-input-container label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .text-input-wrapper { position: relative; }
        textarea { width: 100%; min-height: 200px; padding: 20px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; line-height: 1.6; resize: vertical; transition: all 0.3s; font-family: inherit; }
        textarea:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .text-length { position: absolute; bottom: 10px; right: 15px; background: rgba(255,255,255,0.9); padding: 5px 10px; border-radius: 15px; font-size: 0.8rem; color: #7f8c8d; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .stat-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; text-align: center; }
        .stat-value { font-size: 2rem; font-weight: bold; color: #5e35b1; margin-bottom: 5px; }
        .stat-label { font-size: 0.85rem; color: #4527a0; font-weight: 600; }
        .stat-card.highlight { background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); border-left-color: #4caf50; }
        .stat-card.highlight .stat-value { color: #2e7d32; }
        .stat-card.highlight .stat-label { color: #1b5e20; }
        
        .analysis-section { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .analysis-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .analysis-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; }
        .analysis-item { background: white; padding: 15px; border-radius: 8px; }
        .analysis-label { font-size: 0.85rem; color: #7f8c8d; margin-bottom: 5px; }
        .analysis-value { font-size: 1.1rem; font-weight: 600; color: #2c3e50; }
        .analysis-bar { height: 6px; background: #e0e0e0; border-radius: 3px; margin-top: 8px; overflow: hidden; }
        .analysis-bar-fill { height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 3px; transition: width 0.3s ease; }
        
        .readability-section { background: white; padding: 25px; border-radius: 12px; margin-bottom: 25px; border: 2px solid #e0e0e0; }
        .readability-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .readability-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .readability-card { background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; border-left: 4px solid; }
        .readability-card.easy { border-left-color: #4caf50; }
        .readability-card.medium { border-left-color: #ff9800; }
        .readability-card.hard { border-left-color: #f44336; }
        .readability-score { font-size: 1.5rem; font-weight: bold; margin-bottom: 5px; }
        .readability-label { font-size: 0.9rem; font-weight: 600; margin-bottom: 5px; }
        .readability-desc { font-size: 0.8rem; color: #7f8c8d; }
        
        .action-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .action-btn { padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3); }
        .action-btn.secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .action-btn.secondary:hover { border-color: #667eea; }
        
        .text-tools { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .tool-card { background: white; padding: 20px; border-radius: 10px; border: 2px solid #e0e0e0; cursor: pointer; transition: all 0.3s; }
        .tool-card:hover { border-color: #667eea; transform: translateY(-2px); }
        .tool-icon { font-size: 2rem; margin-bottom: 10px; }
        .tool-title { font-size: 1rem; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .tool-desc { font-size: 0.85rem; color: #7f8c8d; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .limits-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .limits-table th, .limits-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .limits-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .limits-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .toast { position: fixed; bottom: 20px; right: 20px; background: #2c3e50; color: white; padding: 12px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transform: translateY(100px); opacity: 0; transition: all 0.3s; z-index: 1000; }
        .toast.show { transform: translateY(0); opacity: 1; }
        
        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .analysis-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Advanced Character Counter</h1>
            <p>Comprehensive text analysis with character counting, word statistics, readability scores, and writing insights</p>
        </div>

        <div class="counter-card">
            <div class="text-input-container">
                <label for="textInput">Enter your text to analyze:</label>
                <div class="text-input-wrapper">
                    <textarea id="textInput" placeholder="Start typing or paste your text here...">Welcome to the Advanced Character Counter! This professional tool provides comprehensive text analysis including character counting, word statistics, readability scores, and writing insights. Perfect for writers, students, marketers, and professionals who need detailed text metrics.

Simply type or paste your content above, and watch as real-time statistics update instantly. Track your progress against common limits like Twitter's 280 characters, SMS limits, or academic requirements.

This tool goes beyond basic counting to provide meaningful insights about your writing style, readability, and content structure.</textarea>
                    <div class="text-length" id="textLength">0 characters</div>
                </div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card highlight">
                    <div class="stat-value" id="charCount">0</div>
                    <div class="stat-label">CHARACTERS</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="wordCount">0</div>
                    <div class="stat-label">WORDS</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="sentenceCount">0</div>
                    <div class="stat-label">SENTENCES</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="paragraphCount">0</div>
                    <div class="stat-label">PARAGRAPHS</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="readingTime">0</div>
                    <div class="stat-label">READING TIME</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="speakingTime">0</div>
                    <div class="stat-label">SPEAKING TIME</div>
                </div>
            </div>
            
            <div class="analysis-section">
                <h3>📈 Text Analysis</h3>
                <div class="analysis-grid">
                    <div class="analysis-item">
                        <div class="analysis-label">Average Word Length</div>
                        <div class="analysis-value" id="avgWordLength">0</div>
                        <div class="analysis-bar">
                            <div class="analysis-bar-fill" id="avgWordLengthBar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="analysis-item">
                        <div class="analysis-label">Average Sentence Length</div>
                        <div class="analysis-value" id="avgSentenceLength">0</div>
                        <div class="analysis-bar">
                            <div class="analysis-bar-fill" id="avgSentenceLengthBar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="analysis-item">
                        <div class="analysis-label">Character Distribution</div>
                        <div class="analysis-value">
                            <span id="lettersCount">0</span> letters • 
                            <span id="digitsCount">0</span> digits • 
                            <span id="spacesCount">0</span> spaces
                        </div>
                        <div class="analysis-bar">
                            <div class="analysis-bar-fill" id="charDistributionBar" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="analysis-item">
                        <div class="analysis-label">Longest Word</div>
                        <div class="analysis-value" id="longestWord">-</div>
                        <div class="analysis-bar">
                            <div class="analysis-bar-fill" id="longestWordBar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="readability-section">
                <h3>🎓 Readability Scores</h3>
                <div class="readability-cards">
                    <div class="readability-card easy">
                        <div class="readability-score" id="fleschScore">0</div>
                        <div class="readability-label">Flesch Reading Ease</div>
                        <div class="readability-desc" id="fleschDesc">Very Easy</div>
                    </div>
                    <div class="readability-card medium">
                        <div class="readability-score" id="fleschKincaidScore">0</div>
                        <div class="readability-label">Flesch-Kincaid Grade</div>
                        <div class="readability-desc" id="fleschKincaidDesc">5th grade</div>
                    </div>
                    <div class="readability-card hard">
                        <div class="readability-score" id="gunningFogScore">0</div>
                        <div class="readability-label">Gunning Fog Index</div>
                        <div class="readability-desc" id="gunningFogDesc">Easy to read</div>
                    </div>
                    <div class="readability-card">
                        <div class="readability-score" id="colemanLiauScore">0</div>
                        <div class="readability-label">Coleman-Liau Index</div>
                        <div class="readability-desc" id="colemanLiauDesc">Grade level</div>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="action-btn" id="clearBtn">
                    <span>🗑️</span> Clear Text
                </button>
                <button class="action-btn secondary" id="pasteBtn">
                    <span>📋</span> Paste Text
                </button>
                <button class="action-btn secondary" id="sampleBtn">
                    <span>📝</span> Load Sample
                </button>
                <button class="action-btn secondary" id="copyBtn">
                    <span>📤</span> Copy Results
                </button>
            </div>
            
            <div class="text-tools">
                <div class="tool-card" onclick="transformText('uppercase')">
                    <div class="tool-icon">🔠</div>
                    <div class="tool-title">UPPERCASE</div>
                    <div class="tool-desc">Convert text to uppercase</div>
                </div>
                <div class="tool-card" onclick="transformText('lowercase')">
                    <div class="tool-icon">🔡</div>
                    <div class="tool-title">lowercase</div>
                    <div class="tool-desc">Convert text to lowercase</div>
                </div>
                <div class="tool-card" onclick="transformText('titlecase')">
                    <div class="tool-icon">🏷️</div>
                    <div class="tool-title">Title Case</div>
                    <div class="tool-desc">Capitalize each word</div>
                </div>
                <div class="tool-card" onclick="transformText('sentencecase')">
                    <div class="tool-icon">📝</div>
                    <div class="tool-title">Sentence Case</div>
                    <div class="tool-desc">Capitalize sentences</div>
                </div>
                <div class="tool-card" onclick="removeExtraSpaces()">
                    <div class="tool-icon">✂️</div>
                    <div class="tool-title">Trim Spaces</div>
                    <div class="tool-desc">Remove extra whitespace</div>
                </div>
                <div class="tool-card" onclick="reverseText()">
                    <div class="tool-icon">🔄</div>
                    <div class="tool-title">Reverse Text</div>
                    <div class="tool-desc">Reverse character order</div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>📊 Understanding Text Analysis Metrics</h2>
            
            <p>Professional text analysis goes beyond simple character counting to provide insights about writing style, readability, and content structure.</p>

            <h3>📈 Key Metrics Explained</h3>
            <table class="limits-table">
                <thead>
                    <tr>
                        <th>Metric</th>
                        <th>Description</th>
                        <th>Ideal Range</th>
                        <th>Purpose</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Character Count</td><td>Total characters including spaces</td><td>Varies by platform</td><td>Platform limits</td></tr>
                    <tr><td>Word Count</td><td>Total words in text</td><td>150-800 (articles)</td><td>Content planning</td></tr>
                    <tr><td>Sentence Length</td><td>Average words per sentence</td><td>15-20 words</td><td>Readability</td></tr>
                    <tr><td>Paragraph Length</td><td>Average sentences per paragraph</td><td>3-5 sentences</td><td>Structure</td></tr>
                    <tr><td>Reading Time</td><td>Time to read at 200 WPM</td><td>1-7 minutes</td><td>User engagement</td></tr>
                </tbody>
            </table>

            <h3>🎓 Readability Formulas</h3>
            <div class="formula-box">
                <strong>Flesch Reading Ease:</strong><br>
                Score = 206.835 - (1.015 × ASL) - (84.6 × ASW)<br>
                • ASL = Average Sentence Length<br>
                • ASW = Average Syllables per Word<br><br>
                
                <strong>Flesch-Kincaid Grade Level:</strong><br>
                Score = (0.39 × ASL) + (11.8 × ASW) - 15.59<br><br>
                
                <strong>Gunning Fog Index:</strong><br>
                Score = 0.4 × (ASL + Percentage of Complex Words)
            </div>

            <h3>📱 Platform Character Limits</h3>
            <table class="limits-table">
                <thead>
                    <tr>
                        <th>Platform</th>
                        <th>Limit Type</th>
                        <th>Character Limit</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Twitter/X</td><td>Post</td><td>280</td><td>Includes spaces</td></tr>
                    <tr><td>Facebook</td><td>Post</td><td>63,206</td><td>Practical limit</td></tr>
                    <tr><td>Instagram</td><td>Caption</td><td>2,200</td><td>Optimal: 125-150</td></tr>
                    <tr><td>LinkedIn</td><td>Post</td><td>3,000</td><td>Optimal: 150-300</td></tr>
                    <tr><td>SMS</td><td>Message</td><td>160</td><td>Single message</td></tr>
                    <tr><td>Meta Description</td><td>SEO</td><td>155-160</td><td>Search results</td></tr>
                    <tr><td>Email Subject</td><td>Marketing</td><td>40-50</td><td>Mobile display</td></tr>
                </tbody>
            </table>

            <h3>✍️ Writing Best Practices</h3>
            <ul>
                <li><strong>Academic Writing:</strong> 15-25 words per sentence, formal tone</li>
                <li><strong>Blog Posts:</strong> 20-25 words per sentence, conversational</li>
                <li><strong>Marketing Copy:</strong> 10-15 words per sentence, persuasive</li>
                <li><strong>Technical Writing:</strong> 15-20 words per sentence, precise</li>
                <li><strong>Social Media:</strong> 5-10 words per sentence, engaging</li>
            </ul>

            <h3>📊 Character Distribution Analysis</h3>
            <div class="formula-box">
                <strong>Typical Distribution in English Text:</strong><br>
                • Letters: 70-80% of total characters<br>
                • Spaces: 15-20% of total characters<br>
                • Punctuation: 5-10% of total characters<br>
                • Digits: 0-5% of total characters<br>
                • Unusual distribution may indicate technical content or poor formatting
            </div>

            <h3>⏱️ Reading & Speaking Time Calculations</h3>
            <ul>
                <li><strong>Average Reading Speed:</strong> 200-250 words per minute (adults)</li>
                <li><strong>Slow Reading Speed:</strong> 150-200 words per minute</li>
                <li><strong>Fast Reading Speed:</strong> 250-300 words per minute</li>
                <li><strong>Speaking Speed:</strong> 130-150 words per minute (presentations)</li>
                <li><strong>Audiobook Speed:</strong> 150-160 words per minute (standard)</li>
            </ul>

            <h3>🎯 Professional Applications</h3>
            <table class="limits-table">
                <thead>
                    <tr>
                        <th>Industry</th>
                        <th>Key Metrics</th>
                        <th>Tools Used</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Content Marketing</td><td>Readability, Word Count, SEO</td><td>Yoast, Hemingway</td></tr>
                    <tr><td>Academic Research</td><td>Citation density, Complexity</td><td>Turnitin, Grammarly</td></tr>
                    <tr><td>Technical Writing</td><td>Clarity, Terminology consistency</td><td>Acrolinx, MadCap</td></tr>
                    <tr><td>Social Media</td><td>Character limits, Engagement</td><td>Buffer, Hootsuite</td></tr>
                    <tr><td>Legal Documents</td><td>Precision, Clause length</td><td>Legal-specific tools</td></tr>
                </tbody>
            </table>

            <h3>🔍 Advanced Text Analysis</h3>
            <ul>
                <li><strong>Lexical Density:</strong> Percentage of unique words vs total words</li>
                <li><strong>Keyword Density:</strong> Frequency of specific words or phrases</li>
                <li><strong>Sentiment Analysis:</strong> Positive/negative tone detection</li>
                <li><strong>Complexity Metrics:</strong> Syllables per word, complex word ratio</li>
                <li><strong>Readability Patterns:</strong> Sentence variety, paragraph structure</li>
            </ul>

            <h3>🌍 Multilingual Considerations</h3>
            <div class="formula-box">
                <strong>Language Variations:</strong><br>
                • English: Average 5 letters per word<br>
                • German: Average 6-7 letters per word (longer compounds)<br>
                • Spanish: Average 5-6 letters per word<br>
                • Chinese: Character-based counting (no spaces)<br>
                • Japanese: Mixed character systems (Kanji, Hiragana, Katakana)
            </div>

            <h3>📈 Historical Context</h3>
            <ul>
                <li><strong>Typewriter Era:</strong> Standard 65-70 characters per line</li>
                <li><strong>Print Journalism:</strong> Inverted pyramid structure</li>
                <li><strong>Digital Age:</strong> Scannable content, chunking information</li>
                <li><strong>Mobile Revolution:</strong> Shorter paragraphs, concise writing</li>
                <li><strong>AI Assistance:</strong> Real-time analysis and suggestions</li>
            </ul>

            <h3>💡 Optimization Tips</h3>
            <ul>
                <li><strong>For SEO:</strong> Use primary keywords in first 100 characters</li>
                <li><strong>For Engagement:</strong> Start with questions or surprising facts</li>
                <li><strong>For Clarity:</strong> Use active voice and concrete nouns</li>
                <li><strong>For Accessibility:</strong> Maintain 60-70 characters per line</li>
                <li><strong>For Mobile:</strong> Keep paragraphs under 3-4 lines</li>
            </ul>
        </div>

        <div class="footer">
            <p>📊 Advanced Character Counter | Comprehensive Text Analysis</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Count characters, words, sentences, analyze readability, and optimize your writing</p>
        </div>
    </div>

    <div class="toast" id="toast">Text cleared!</div>

    <script>
        // DOM elements
        const textInput = document.getElementById('textInput');
        const textLength = document.getElementById('textLength');
        const charCount = document.getElementById('charCount');
        const wordCount = document.getElementById('wordCount');
        const sentenceCount = document.getElementById('sentenceCount');
        const paragraphCount = document.getElementById('paragraphCount');
        const readingTime = document.getElementById('readingTime');
        const speakingTime = document.getElementById('speakingTime');
        const avgWordLength = document.getElementById('avgWordLength');
        const avgSentenceLength = document.getElementById('avgSentenceLength');
        const lettersCount = document.getElementById('lettersCount');
        const digitsCount = document.getElementById('digitsCount');
        const spacesCount = document.getElementById('spacesCount');
        const longestWord = document.getElementById('longestWord');
        const fleschScore = document.getElementById('fleschScore');
        const fleschDesc = document.getElementById('fleschDesc');
        const fleschKincaidScore = document.getElementById('fleschKincaidScore');
        const fleschKincaidDesc = document.getElementById('fleschKincaidDesc');
        const gunningFogScore = document.getElementById('gunningFogScore');
        const gunningFogDesc = document.getElementById('gunningFogDesc');
        const colemanLiauScore = document.getElementById('colemanLiauScore');
        const colemanLiauDesc = document.getElementById('colemanLiauDesc');
        const clearBtn = document.getElementById('clearBtn');
        const pasteBtn = document.getElementById('pasteBtn');
        const sampleBtn = document.getElementById('sampleBtn');
        const copyBtn = document.getElementById('copyBtn');
        const toast = document.getElementById('toast');

        // Initial analysis
        analyzeText();

        // Event listeners
        textInput.addEventListener('input', analyzeText);
        clearBtn.addEventListener('click', clearText);
        pasteBtn.addEventListener('click', pasteText);
        sampleBtn.addEventListener('click', loadSampleText);
        copyBtn.addEventListener('click', copyResults);

        function analyzeText() {
            const text = textInput.value;
            const stats = calculateTextStats(text);
            
            updateBasicStats(stats);
            updateAnalysisStats(stats);
            updateReadabilityScores(stats);
            updateProgressBars(stats);
        }

        function calculateTextStats(text) {
            // Basic counts
            const characters = text.length;
            const charactersNoSpaces = text.replace(/\s/g, '').length;
            const words = text.trim() ? text.trim().split(/\s+/).length : 0;
            const sentences = text.trim() ? text.split(/[.!?]+/).filter(s => s.trim()).length : 0;
            const paragraphs = text.trim() ? text.split(/\n+/).filter(p => p.trim()).length : 0;
            
            // Character analysis
            const letters = (text.match(/[a-zA-Z]/g) || []).length;
            const digits = (text.match(/\d/g) || []).length;
            const spaces = (text.match(/\s/g) || []).length;
            const punctuation = (text.match(/[^\w\s]/g) || []).length;
            
            // Word analysis
            const wordList = text.trim() ? text.trim().split(/\s+/) : [];
            const totalWordLength = wordList.reduce((sum, word) => sum + word.length, 0);
            const avgWordLen = words > 0 ? (totalWordLength / words).toFixed(1) : 0;
            const longest = wordList.reduce((longest, word) => 
                word.length > longest.length ? word.replace(/[^\w]/g, '') : longest, '');
            
            // Sentence analysis
            const sentenceList = text.trim() ? text.split(/[.!?]+/).filter(s => s.trim()) : [];
            const totalSentenceWords = sentenceList.reduce((sum, sentence) => 
                sum + sentence.trim().split(/\s+/).length, 0);
            const avgSentenceLen = sentences > 0 ? (totalSentenceWords / sentences).toFixed(1) : 0;
            
            // Time calculations
            const readingTimeMin = Math.ceil(words / 200);
            const speakingTimeMin = Math.ceil(words / 150);
            
            return {
                characters,
                charactersNoSpaces,
                words,
                sentences,
                paragraphs,
                letters,
                digits,
                spaces,
                punctuation,
                avgWordLen,
                longestWord: longest,
                avgSentenceLen,
                readingTime: readingTimeMin,
                speakingTime: speakingTimeMin,
                wordList,
                sentenceList
            };
        }

        function updateBasicStats(stats) {
            textLength.textContent = `${stats.characters} characters`;
            charCount.textContent = stats.characters.toLocaleString();
            wordCount.textContent = stats.words.toLocaleString();
            sentenceCount.textContent = stats.sentences.toLocaleString();
            paragraphCount.textContent = stats.paragraphs.toLocaleString();
            readingTime.textContent = `${stats.readingTime}m`;
            speakingTime.textContent = `${stats.speakingTime}m`;
        }

        function updateAnalysisStats(stats) {
            avgWordLength.textContent = stats.avgWordLen;
            avgSentenceLength.textContent = stats.avgSentenceLen;
            lettersCount.textContent = stats.letters.toLocaleString();
            digitsCount.textContent = stats.digits.toLocaleString();
            spacesCount.textContent = stats.spaces.toLocaleString();
            longestWord.textContent = stats.longestWord || '-';
        }

        function updateProgressBars(stats) {
            // Average word length (scale: 0-10 characters)
            const wordLengthPercent = Math.min((stats.avgWordLen / 10) * 100, 100);
            document.getElementById('avgWordLengthBar').style.width = `${wordLengthPercent}%`;
            
            // Average sentence length (scale: 0-30 words)
            const sentenceLengthPercent = Math.min((stats.avgSentenceLen / 30) * 100, 100);
            document.getElementById('avgSentenceLengthBar').style.width = `${sentenceLengthPercent}%`;
            
            // Character distribution (letters percentage)
            const lettersPercent = stats.characters > 0 ? (stats.letters / stats.characters) * 100 : 0;
            document.getElementById('charDistributionBar').style.width = `${lettersPercent}%`;
            
            // Longest word (scale: 0-20 characters)
            const longestWordPercent = Math.min((stats.longestWord.length / 20) * 100, 100);
            document.getElementById('longestWordBar').style.width = `${longestWordPercent}%`;
        }

        function updateReadabilityScores(stats) {
            if (stats.words === 0 || stats.sentences === 0) {
                resetReadabilityScores();
                return;
            }
            
            // Calculate syllables (simplified)
            const totalSyllables = stats.wordList.reduce((sum, word) => 
                sum + countSyllables(word), 0);
            const avgSyllablesPerWord = totalSyllables / stats.words;
            
            // Flesch Reading Ease
            const flesch = 206.835 - (1.015 * stats.avgSentenceLen) - (84.6 * avgSyllablesPerWord);
            fleschScore.textContent = Math.round(flesch);
            fleschDesc.textContent = getFleschDescription(flesch);
            
            // Flesch-Kincaid Grade Level
            const fleschKincaid = (0.39 * stats.avgSentenceLen) + (11.8 * avgSyllablesPerWord) - 15.59;
            fleschKincaidScore.textContent = fleschKincaid.toFixed(1);
            fleschKincaidDesc.textContent = getGradeLevelDescription(fleschKincaid);
            
            // Gunning Fog Index
            const complexWords = stats.wordList.filter(word => countSyllables(word) >= 3).length;
            const percentComplex = (complexWords / stats.words) * 100;
            const gunningFog = 0.4 * (stats.avgSentenceLen + percentComplex);
            gunningFogScore.textContent = gunningFog.toFixed(1);
            gunningFogDesc.textContent = getGunningFogDescription(gunningFog);
            
            // Coleman-Liau Index
            const avgLettersPer100 = (stats.letters / stats.words) * 100;
            const avgSentencesPer100 = (stats.sentences / stats.words) * 100;
            const colemanLiau = (0.0588 * avgLettersPer100) - (0.296 * avgSentencesPer100) - 15.8;
            colemanLiauScore.textContent = colemanLiau.toFixed(1);
            colemanLiauDesc.textContent = getGradeLevelDescription(colemanLiau);
        }

        function countSyllables(word) {
            word = word.toLowerCase().replace(/[^a-z]/g, '');
            if (word.length <= 3) return 1;
            
            let count = 0;
            const vowels = 'aeiouy';
            let prevIsVowel = false;
            
            for (let i = 0; i < word.length; i++) {
                const isVowel = vowels.includes(word[i]);
                if (isVowel && !prevIsVowel) {
                    count++;
                }
                prevIsVowel = isVowel;
            }
            
            // Adjust for common exceptions
            if (word.endsWith('e')) count--;
            if (word.endsWith('le') && word.length > 2 && !vowels.includes(word[word.length - 3])) count++;
            if (count === 0) count = 1;
            
            return count;
        }

        function getFleschDescription(score) {
            if (score >= 90) return 'Very Easy';
            if (score >= 80) return 'Easy';
            if (score >= 70) return 'Fairly Easy';
            if (score >= 60) return 'Standard';
            if (score >= 50) return 'Fairly Difficult';
            if (score >= 30) return 'Difficult';
            return 'Very Difficult';
        }

        function getGradeLevelDescription(grade) {
            const level = Math.round(grade);
            if (level <= 6) return `${level}th grade`;
            if (level <= 8) return `${level}th-8th grade`;
            if (level <= 12) return 'High school';
            if (level <= 16) return 'College';
            return 'Graduate';
        }

        function getGunningFogDescription(score) {
            if (score < 6) return 'Very Easy';
            if (score < 8) return 'Easy';
            if (score < 12) return 'Ideal';
            if (score < 15) return 'Difficult';
            return 'Very Difficult';
        }

        function resetReadabilityScores() {
            fleschScore.textContent = '0';
            fleschDesc.textContent = 'Very Easy';
            fleschKincaidScore.textContent = '0';
            fleschKincaidDesc.textContent = '5th grade';
            gunningFogScore.textContent = '0';
            gunningFogDesc.textContent = 'Easy to read';
            colemanLiauScore.textContent = '0';
            colemanLiauDesc.textContent = 'Grade level';
        }

        // Text transformation functions
        function transformText(type) {
            const text = textInput.value;
            let transformed = text;
            
            switch(type) {
                case 'uppercase':
                    transformed = text.toUpperCase();
                    break;
                case 'lowercase':
                    transformed = text.toLowerCase();
                    break;
                case 'titlecase':
                    transformed = text.replace(/\w\S*/g, txt => 
                        txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase());
                    break;
                case 'sentencecase':
                    transformed = text.toLowerCase().replace(/(^\s*|[.!?]\s+)(\w)/g, 
                        (match, p1, p2) => p1 + p2.toUpperCase());
                    break;
            }
            
            textInput.value = transformed;
            analyzeText();
            showToast('Text transformed!');
        }

        function removeExtraSpaces() {
            const text = textInput.value;
            const transformed = text.replace(/\s+/g, ' ').trim();
            textInput.value = transformed;
            analyzeText();
            showToast('Extra spaces removed!');
        }

        function reverseText() {
            const text = textInput.value;
            const transformed = text.split('').reverse().join('');
            textInput.value = transformed;
            analyzeText();
            showToast('Text reversed!');
        }

        // Action functions
        function clearText() {
            textInput.value = '';
            analyzeText();
            showToast('Text cleared!');
        }

        async function pasteText() {
            try {
                const text = await navigator.clipboard.readText();
                textInput.value = text;
                analyzeText();
                showToast('Text pasted!');
            } catch (err) {
                showToast('Failed to paste text');
            }
        }

        function loadSampleText() {
            const sample = `The Advanced Character Counter provides comprehensive text analysis beyond simple counting. This professional tool calculates readability scores, analyzes writing style, and offers insights to improve your content.

Key features include:
• Real-time character, word, and sentence counting
• Readability analysis using multiple formulas
• Writing time estimates for reading and speaking
• Text transformation tools for editing
• Platform-specific limit tracking

Use this tool to optimize your writing for different audiences and platforms, from social media posts to academic papers.`;
            
            textInput.value = sample;
            analyzeText();
            showToast('Sample text loaded!');
        }

        function copyResults() {
            const stats = calculateTextStats(textInput.value);
            const results = `
Character Count: ${stats.characters}
Word Count: ${stats.words}
Sentence Count: ${stats.sentences}
Paragraph Count: ${stats.paragraphs}
Reading Time: ${stats.readingTime} minutes
Speaking Time: ${stats.speakingTime} minutes
Average Word Length: ${stats.avgWordLen}
Average Sentence Length: ${stats.avgSentenceLen}
Longest Word: ${stats.longestWord}
Readability Scores:
- Flesch Reading Ease: ${fleschScore.textContent} (${fleschDesc.textContent})
- Flesch-Kincaid Grade: ${fleschKincaidScore.textContent} (${fleschKincaidDesc.textContent})
- Gunning Fog Index: ${gunningFogScore.textContent} (${gunningFogDesc.textContent})
            `.trim();
            
            navigator.clipboard.writeText(results).then(() => {
                showToast('Results copied to clipboard!');
            }).catch(() => {
                showToast('Failed to copy results');
            });
        }

        function showToast(message) {
            toast.textContent = message;
            toast.classList.add('show');
            
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>
