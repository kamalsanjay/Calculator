<?php
/**
 * Word Counter
 * File: utility/word-counter.php
 * Description: Advanced word counter with character analysis, reading time, and text statistics
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word Counter - Advanced Text Analysis Tool</title>
    <meta name="description" content="Count words, characters, sentences, and paragraphs with advanced text analysis, reading time estimates, and comprehensive writing statistics.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .counter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-section { margin-bottom: 30px; }
        .text-input { 
            width: 100%; 
            min-height: 200px; 
            padding: 20px; 
            border: 2px solid #e0e0e0; 
            border-radius: 12px; 
            font-size: 1rem; 
            line-height: 1.6;
            resize: vertical;
            transition: all 0.3s;
            font-family: inherit;
        }
        .text-input:focus { 
            outline: none; 
            border-color: #74b9ff; 
            box-shadow: 0 0 0 3px rgba(116, 185, 255, 0.1); 
        }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; background: white; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #74b9ff; box-shadow: 0 0 0 3px rgba(116, 185, 255, 0.1); }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .checkbox-group input { width: auto; }
        
        .action-buttons { display: flex; gap: 15px; margin-top: 25px; flex-wrap: wrap; }
        .btn { padding: 14px 24px; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; font-weight: 600; }
        .btn-primary { background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(116, 185, 255, 0.3); }
        .btn-secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .btn-secondary:hover { background: #e9ecef; }
        .btn-danger { background: #e74c3c; color: white; }
        
        .quick-text { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-text h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #74b9ff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(116, 185, 255, 0.15); }
        .quick-value { font-weight: bold; color: #0984e3; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .results-section { margin-top: 30px; }
        
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px;
        }
        .stat-card { 
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); 
            padding: 25px; 
            border-radius: 12px; 
            text-align: center;
            border-left: 4px solid #74b9ff;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }
        .stat-value { 
            font-size: 2.5rem; 
            font-weight: bold; 
            color: #0984e3; 
            margin-bottom: 8px;
            line-height: 1;
        }
        .stat-label { 
            font-size: 0.95rem; 
            color: #2c3e50; 
            font-weight: 600;
            margin-bottom: 5px;
        }
        .stat-detail {
            font-size: 0.85rem;
            color: #7f8c8d;
        }
        
        .reading-time { 
            background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%); 
            padding: 25px; 
            border-radius: 15px; 
            margin: 25px 0;
            text-align: center;
        }
        .reading-title { 
            font-size: 1.3rem; 
            font-weight: bold; 
            color: #2c3e50; 
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .time-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); 
            gap: 20px; 
        }
        .time-card { 
            background: rgba(255,255,255,0.9); 
            padding: 20px; 
            border-radius: 10px; 
        }
        .time-value { 
            font-size: 1.8rem; 
            font-weight: bold; 
            color: #e17055; 
            margin-bottom: 5px;
        }
        .time-label { 
            font-size: 0.9rem; 
            color: #7f8c8d; 
            font-weight: 600;
        }
        
        .analysis-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }
        .analysis-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
        }
        .analysis-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .analysis-list {
            list-style: none;
        }
        .analysis-item {
            padding: 10px 0;
            border-bottom: 1px solid #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .analysis-item:last-child {
            border-bottom: none;
        }
        .item-label {
            color: #34495e;
            font-weight: 500;
        }
        .item-value {
            color: #0984e3;
            font-weight: bold;
        }
        
        .density-chart {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        .chart-bar {
            display: flex;
            align-items: center;
            margin: 12px 0;
            gap: 15px;
        }
        .chart-label {
            width: 100px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
        }
        .chart-bar-inner {
            flex: 1;
            height: 25px;
            background: #ecf0f1;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }
        .chart-bar-fill {
            height: 100%;
            border-radius: 12px;
            transition: width 0.5s ease-in-out;
            background: linear-gradient(90deg, #74b9ff, #0984e3);
        }
        .chart-percentage {
            width: 60px;
            text-align: right;
            font-weight: bold;
            color: #2c3e50;
            font-size: 0.9rem;
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
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .writing-standards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin: 20px 0; }
        .standard-card { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #74b9ff; }
        .standard-name { font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .standard-desc { font-size: 0.85rem; color: #7f8c8d; }
        
        .formula-box { background: #f0f8ff; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #74b9ff; }
        .formula-box strong { color: #0984e3; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #f0f8ff; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .action-buttons { flex-direction: column; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .time-grid { grid-template-columns: 1fr; }
            .analysis-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📝 Advanced Word Counter</h1>
            <p>Count words, characters, sentences, and paragraphs with advanced text analysis, reading time estimates, and comprehensive writing statistics</p>
        </div>

        <div class="counter-card">
            <div class="input-section">
                <textarea 
                    id="textInput" 
                    class="text-input" 
                    placeholder="Paste or type your text here to analyze it..."
                    oninput="analyzeText()"
                >The quick brown fox jumps over the lazy dog. This sentence contains every letter in the English alphabet. Word counting is essential for writers, students, and professionals who need to meet specific length requirements for their documents.</textarea>
            </div>
            
            <div class="control-panel">
                <div class="control-group">
                    <label for="language">Language</label>
                    <select id="language" class="control-select">
                        <option value="english">English</option>
                        <option value="spanish">Spanish</option>
                        <option value="french">French</option>
                        <option value="german">German</option>
                        <option value="chinese">Chinese</option>
                        <option value="japanese">Japanese</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label for="contentType">Content Type</label>
                    <select id="contentType" class="control-select">
                        <option value="general">General Writing</option>
                        <option value="academic">Academic Paper</option>
                        <option value="technical">Technical Document</option>
                        <option value="creative">Creative Writing</option>
                        <option value="business">Business Document</option>
                        <option value="web">Web Content</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label>Analysis Options</label>
                    <div class="checkbox-group">
                        <input type="checkbox" id="countSpaces" checked>
                        <label for="countSpaces">Include spaces in character count</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="countPunctuation" checked>
                        <label for="countPunctuation">Include punctuation in word count</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="showDensity" checked>
                        <label for="showDensity">Show word density analysis</label>
                    </div>
                </div>
            </div>
            
            <div class="quick-text">
                <h3>📋 Sample Texts</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="loadSample('lorem')">
                        <div class="quick-value">Lorem Ipsum</div>
                        <div class="quick-label">Classic placeholder</div>
                    </div>
                    <div class="quick-btn" onclick="loadSample('short')">
                        <div class="quick-value">Short Story</div>
                        <div class="quick-label">Brief narrative</div>
                    </div>
                    <div class="quick-btn" onclick="loadSample('academic')">
                        <div class="quick-value">Academic</div>
                        <div class="quick-label">Research excerpt</div>
                    </div>
                    <div class="quick-btn" onclick="loadSample('business')">
                        <div class="quick-value">Business</div>
                        <div class="quick-label">Professional text</div>
                    </div>
                    <div class="quick-btn" onclick="loadSample('technical')">
                        <div class="quick-value">Technical</div>
                        <div class="quick-label">Documentation</div>
                    </div>
                    <div class="quick-btn" onclick="loadSample('empty')">
                        <div class="quick-value">Clear Text</div>
                        <div class="quick-label">Start fresh</div>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="analyzeText()">📊 Analyze Text</button>
                <button class="btn btn-secondary" onclick="clearText()">🗑️ Clear Text</button>
                <button class="btn btn-secondary" onclick="copyText()">📋 Copy Text</button>
                <button class="btn btn-secondary" onclick="saveResults()">💾 Save Analysis</button>
            </div>
            
            <div class="results-section">
                <h3>📈 Text Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value" id="wordCount">0</div>
                        <div class="stat-label">Words</div>
                        <div class="stat-detail" id="wordDetail">Standard count</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="charCount">0</div>
                        <div class="stat-label">Characters</div>
                        <div class="stat-detail" id="charDetail">Including spaces</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="sentenceCount">0</div>
                        <div class="stat-label">Sentences</div>
                        <div class="stat-detail" id="sentenceDetail">Based on punctuation</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="paragraphCount">0</div>
                        <div class="stat-label">Paragraphs</div>
                        <div class="stat-detail" id="paragraphDetail">Line breaks</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="readingLevel">0</div>
                        <div class="stat-label">Reading Level</div>
                        <div class="stat-detail" id="readingDetail">Grade level</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="wordLength">0.0</div>
                        <div class="stat-label">Avg Word Length</div>
                        <div class="stat-detail" id="lengthDetail">Characters per word</div>
                    </div>
                </div>
                
                <div class="reading-time">
                    <div class="reading-title">⏱️ Reading Time Estimates</div>
                    <div class="time-grid">
                        <div class="time-card">
                            <div class="time-value" id="slowTime">0 min</div>
                            <div class="time-label">Slow Reading (150 wpm)</div>
                        </div>
                        <div class="time-card">
                            <div class="time-value" id="averageTime">0 min</div>
                            <div class="time-label">Average Reading (200 wpm)</div>
                        </div>
                        <div class="time-card">
                            <div class="time-value" id="fastTime">0 min</div>
                            <div class="time-label">Fast Reading (300 wpm)</div>
                        </div>
                        <div class="time-card">
                            <div class="time-value" id="speakingTime">0 min</div>
                            <div class="time-label">Speaking Time (130 wpm)</div>
                        </div>
                    </div>
                </div>
                
                <div class="analysis-grid">
                    <div class="analysis-card">
                        <div class="analysis-title">📊 Character Analysis</div>
                        <div class="analysis-list">
                            <div class="analysis-item">
                                <span class="item-label">Total Characters</span>
                                <span class="item-value" id="totalChars">0</span>
                            </div>
                            <div class="analysis-item">
                                <span class="item-label">Characters (no spaces)</span>
                                <span class="item-value" id="charsNoSpaces">0</span>
                            </div>
                            <div class="analysis-item">
                                <span class="item-label">Letters</span>
                                <span class="item-value" id="letterCount">0</span>
                            </div>
                            <div class="analysis-item">
                                <span class="item-label">Digits</span>
                                <span class="item-value" id="digitCount">0</span>
                            </div>
                            <div class="analysis-item">
                                <span class="item-label">Spaces</span>
                                <span class="item-value" id="spaceCount">0</span>
                            </div>
                            <div class="analysis-item">
                                <span class="item-label">Punctuation</span>
                                <span class="item-value" id="punctuationCount">0</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="analysis-card">
                        <div class="analysis-title">📝 Sentence Analysis</div>
                        <div class="analysis-list">
                            <div class="analysis-item">
                                <span class="item-label">Avg Sentence Length</span>
                                <span class="item-value" id="avgSentenceWords">0.0</span>
                            </div>
                            <div class="analysis-item">
                                <span class="item-label">Avg Sentence Chars</span>
                                <span class="item-value" id="avgSentenceChars">0.0</span>
                            </div>
                            <div class="analysis-item">
                                <span class="item-label">Short Sentences</span>
                                <span class="item-value" id="shortSentences">0</span>
                            </div>
                            <div class="analysis-item">
                                <span class="item-label">Long Sentences</span>
                                <span class="item-value" id="longSentences">0</span>
                            </div>
                            <div class="analysis-item">
                                <span class="item-label">Questions</span>
                                <span class="item-value" id="questionCount">0</span>
                            </div>
                            <div class="analysis-item">
                                <span class="item-label">Exclamations</span>
                                <span class="item-value" id="exclamationCount">0</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="density-chart" id="densityChart">
                    <div class="analysis-title">📈 Word Frequency</div>
                    <div id="wordFrequencyList">
                        <!-- Word frequency bars will appear here -->
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>📝 Advanced Word Counting</h2>
            
            <p>Professional text analysis tool that goes beyond simple word counting to provide comprehensive writing statistics, readability scores, and content optimization insights.</p>

            <h3>🎯 Writing Standards & Guidelines</h3>
            <div class="writing-standards">
                <div class="standard-card">
                    <div class="standard-name">Academic Papers</div>
                    <div class="standard-desc">Typically 1500-5000 words for essays, 8000+ for theses</div>
                </div>
                <div class="standard-card">
                    <div class="standard-name">Blog Posts</div>
                    <div class="standard-desc">Optimal length: 1000-2500 words for SEO</div>
                </div>
                <div class="standard-card">
                    <div class="standard-name">Business Reports</div>
                    <div class="standard-desc">Executive summaries: 250-500 words, full reports: 2000+</div>
                </div>
                <div class="standard-card">
                    <div class="standard-name">Social Media</div>
                    <div class="standard-desc">Twitter: 280 chars, Facebook: 80-150 chars optimal</div>
                </div>
                <div class="standard-card">
                    <div class="standard-name">Email Marketing</div>
                    <div class="standard-desc">Subject lines: 30-50 chars, body: 50-125 words</div>
                </div>
                <div class="standard-card">
                    <div class="standard-name">Resumes</div>
                    <div class="standard-desc">Typically 300-500 words, one page preferred</div>
                </div>
            </div>

            <h3>📊 Reading Level Formulas</h3>
            <div class="formula-box">
                <strong>Flesch-Kincaid Grade Level:</strong><br>
                • 0.39 × (total words / total sentences) + 11.8 × (total syllables / total words) - 15.59<br><br>
                <strong>Flesch Reading Ease:</strong><br>
                • 206.835 - 1.015 × (total words / total sentences) - 84.6 × (total syllables / total words)<br><br>
                <strong>Gunning Fog Index:</strong><br>
                • 0.4 × [(words / sentences) + 100 × (complex words / words)]
            </div>

            <h3>📈 Optimal Text Lengths</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Content Type</th>
                        <th>Ideal Word Count</th>
                        <th>Character Limit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Twitter Tweet</td><td>25-30 words</td><td>280 characters</td></tr>
                    <tr><td>Facebook Post</td><td>40-80 words</td><td>No strict limit</td></tr>
                    <tr><td>Email Subject</td><td>3-7 words</td><td>30-50 characters</td></tr>
                    <tr><td>Meta Description</td><td>20-25 words</td><td>155-160 characters</td></tr>
                    <tr><td>Blog Post Title</td><td>6-8 words</td><td>50-60 characters</td></tr>
                    <tr><td>Academic Abstract</td><td>150-250 words</td><td>800-1200 characters</td></tr>
                </tbody>
            </table>

            <h3>⏱️ Reading Speed Standards</h3>
            <div class="probability-grid">
                <div class="probability-item">
                    <div class="prob-value">150 wpm</div>
                    <div class="prob-label">Slow Reader</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">200 wpm</div>
                    <div class="prob-label">Average Reader</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">300 wpm</div>
                    <div class="prob-label">Fast Reader</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">450 wpm</div>
                    <div class="prob-label">Speed Reader</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">130 wpm</div>
                    <div class="prob-label">Speaking Pace</div>
                </div>
                <div class="probability-item">
                    <div class="prob-value">1000 wpm</div>
                    <div class="prob-label">World Record</div>
                </div>
            </div>

            <h3>📝 Word Count Variations</h3>
            <div class="formula-box">
                <strong>Different Counting Methods:</strong><br>
                • <strong>Standard Count:</strong> Words separated by spaces/punctuation<br>
                • <strong>Microsoft Word:</strong> Similar to standard but may differ with hyphenation<br>
                • <strong>Google Docs:</strong> Generally matches standard word count<br>
                • <strong>Character Count:</strong> Includes/excludes spaces based on preference<br>
                • <strong>Asian Languages:</strong> Character-based rather than word-based counting
            </div>

            <h3>🎓 Readability Scores</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Score Range</th>
                        <th>Reading Level</th>
                        <th>Typical Audience</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>90-100</td><td>5th Grade</td><td>Very easy to read</td></tr>
                    <tr><td>80-90</td><td>6th Grade</td><td>Easy to read</td></tr>
                    <tr><td>70-80</td><td>7th Grade</td><td>Fairly easy to read</td></tr>
                    <tr><td>60-70</td><td>8th-9th Grade</td><td>Plain English</td></tr>
                    <tr><td>50-60</td><td>10th-12th Grade</td><td>Fairly difficult</td></tr>
                    <tr><td>30-50</td><td>College Level</td><td>Difficult to read</td></tr>
                    <tr><td>0-30</td><td>College Graduate</td><td>Very difficult to read</td></tr>
                </tbody>
            </table>

            <h3>🔤 Character Analysis</h3>
            <ul>
                <li><strong>Letters:</strong> A-Z, a-z (case insensitive for analysis)</li>
                <li><strong>Digits:</strong> 0-9 numerical characters</li>
                <li><strong>Spaces:</strong> Regular spaces, tabs, newlines</li>
                <li><strong>Punctuation:</strong> . , ! ? ; : ' " ( ) [ ] { } - —</li>
                <li><strong>Special Characters:</strong> @ # $ % ^ & * _ + = | \ / < ></li>
                <li><strong>Whitespace:</strong> Various space characters and line breaks</li>
            </ul>

            <h3>📱 Digital Content Optimization</h3>
            <div class="formula-box">
                <strong>SEO Best Practices:</strong><br>
                • <strong>Title Tags:</strong> 50-60 characters for full visibility<br>
                • <strong>Meta Descriptions:</strong> 150-160 characters optimal<br>
                • <strong>Header Tags:</strong> H1: 20-70 chars, H2: 30-80 chars<br>
                • <strong>Blog Posts:</strong> 1000-2500 words for comprehensive coverage<br>
                • <strong>Image Alt Text:</strong> 125 characters or fewer<br>
                • <strong>URL Slugs:</strong> 3-5 words, 50-60 characters
            </div>

            <h3>🌍 Multilingual Considerations</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Language</th>
                        <th>Word Definition</th>
                        <th>Counting Method</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>English</td><td>Space-separated units</td><td>Word count</td></tr>
                    <tr><td>Chinese</td><td>Characters represent words</td><td>Character count</td></tr>
                    <tr><td>Japanese</td><td>Mix of characters and syllables</td><td>Character count</td></tr>
                    <tr><td>Korean</td><td>Space-separated syllabic blocks</td><td>Word count</td></tr>
                    <tr><td>Arabic</td><td>Right-to-left, connected letters</td><td>Word count</td></tr>
                    <tr><td>Hindi</td><td>Space-separated Devanagari words</td><td>Word count</td></tr>
                </tbody>
            </table>

            <h3>📊 Statistical Significance</h3>
            <ul>
                <li><strong>Sample Size:</strong> Larger texts provide more accurate readability scores</li>
                <li><strong>Sentence Variety:</strong> Mix of short and long sentences improves readability</li>
                <li><strong>Word Length:</strong> Shorter words generally increase comprehension</li>
                <li><strong>Paragraph Length:</strong> 3-5 sentences optimal for online reading</li>
                <li><strong>Active Voice:</strong> Increases engagement and readability scores</li>
            </ul>
        </div>

        <div class="footer">
            <p>📝 Advanced Word Counter | Comprehensive Text Analysis Tool</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for writers, students, editors, SEO specialists, and content creators</p>
        </div>
    </div>

    <script>
        let analysisHistory = [];
        
        // Sample texts
        const sampleTexts = {
            lorem: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
            short: "The old man walked slowly down the dusty road. His shadow stretched long behind him in the evening sun. Somewhere in the distance, a dog barked. He continued walking, one step at a time, toward the horizon.",
            academic: "The empirical analysis conducted in this study reveals significant correlations between socioeconomic factors and educational outcomes. Previous research has established foundational principles, yet this investigation provides novel insights through multivariate regression analysis of longitudinal data.",
            business: "Our quarterly performance metrics indicate a 15% growth in market share, exceeding projections by 3%. Strategic initiatives implemented in Q2 have yielded positive ROI, with customer acquisition costs decreasing by 22% while maintaining quality standards.",
            technical: "The algorithm implements a modified Dijkstra's approach with time complexity O(E + V log V). Memory allocation follows the RAII pattern, ensuring exception safety. The API exposes endpoints for CRUD operations with JSON serialization.",
            empty: ""
        };

        function analyzeText() {
            const text = document.getElementById('textInput').value;
            const countSpaces = document.getElementById('countSpaces').checked;
            const countPunctuation = document.getElementById('countPunctuation').checked;
            const showDensity = document.getElementById('showDensity').checked;
            
            // Basic counts
            const words = countWords(text, countPunctuation);
            const characters = countCharacters(text, countSpaces);
            const sentences = countSentences(text);
            const paragraphs = countParagraphs(text);
            
            // Advanced analysis
            const charAnalysis = analyzeCharacters(text);
            const sentenceAnalysis = analyzeSentences(text, words);
            const readingLevel = calculateReadingLevel(text, words, sentences);
            const readingTimes = calculateReadingTime(words);
            const wordFrequency = showDensity ? analyzeWordFrequency(text) : [];
            
            // Update display
            updateBasicStats(words, characters, sentences, paragraphs, readingLevel);
            updateReadingTimes(readingTimes);
            updateCharAnalysis(charAnalysis);
            updateSentenceAnalysis(sentenceAnalysis);
            if (showDensity) {
                updateWordFrequency(wordFrequency);
            }
            
            // Add to history
            addToHistory(words, characters);
        }
        
        function countWords(text, includePunctuation) {
            if (!text.trim()) return 0;
            
            let cleanText = text.replace(/\s+/g, ' ').trim();
            if (!includePunctuation) {
                cleanText = cleanText.replace(/[^\w\s]/g, '');
            }
            
            const words = cleanText.split(/\s+/);
            return words.filter(word => word.length > 0).length;
        }
        
        function countCharacters(text, includeSpaces) {
            if (includeSpaces) {
                return text.length;
            } else {
                return text.replace(/\s/g, '').length;
            }
        }
        
        function countSentences(text) {
            if (!text.trim()) return 0;
            const sentences = text.split(/[.!?]+/).filter(s => s.trim().length > 0);
            return sentences.length;
        }
        
        function countParagraphs(text) {
            if (!text.trim()) return 0;
            const paragraphs = text.split(/\n+/).filter(p => p.trim().length > 0);
            return paragraphs.length;
        }
        
        function analyzeCharacters(text) {
            const letters = (text.match(/[a-zA-Z]/g) || []).length;
            const digits = (text.match(/[0-9]/g) || []).length;
            const spaces = (text.match(/\s/g) || []).length;
            const punctuation = (text.match(/[.,!?;:'"()\[\]{}—\-]/g) || []).length;
            const totalChars = text.length;
            
            return {
                totalChars,
                letters,
                digits,
                spaces,
                punctuation,
                charsNoSpaces: totalChars - spaces
            };
        }
        
        function analyzeSentences(text, wordCount) {
            const sentences = text.split(/[.!?]+/).filter(s => s.trim().length > 0);
            const totalSentences = sentences.length;
            
            if (totalSentences === 0) {
                return {
                    avgWords: 0,
                    avgChars: 0,
                    short: 0,
                    long: 0,
                    questions: 0,
                    exclamations: 0
                };
            }
            
            const sentenceLengths = sentences.map(s => s.trim().split(/\s+/).length);
            const sentenceChars = sentences.map(s => s.trim().length);
            
            const avgWords = wordCount / totalSentences;
            const avgChars = sentenceChars.reduce((a, b) => a + b, 0) / totalSentences;
            const short = sentenceLengths.filter(len => len < 8).length;
            const long = sentenceLengths.filter(len => len > 20).length;
            const questions = (text.match(/\?/g) || []).length;
            const exclamations = (text.match(/!/g) || []).length;
            
            return {
                avgWords: avgWords.toFixed(1),
                avgChars: avgChars.toFixed(1),
                short,
                long,
                questions,
                exclamations
            };
        }
        
        function calculateReadingLevel(text, wordCount, sentenceCount) {
            if (sentenceCount === 0 || wordCount === 0) return 0;
            
            // Simple approximation of Flesch-Kincaid Grade Level
            const avgWordsPerSentence = wordCount / sentenceCount;
            const avgSyllablesPerWord = estimateSyllables(text) / wordCount;
            
            const gradeLevel = 0.39 * avgWordsPerSentence + 11.8 * avgSyllablesPerWord - 15.59;
            return Math.max(0, Math.round(gradeLevel * 10) / 10);
        }
        
        function estimateSyllables(text) {
            // Simple syllable estimation for common words
            const words = text.toLowerCase().split(/\s+/);
            let totalSyllables = 0;
            
            words.forEach(word => {
                word = word.replace(/[^\w]/g, '');
                if (word.length <= 3) {
                    totalSyllables += 1;
                } else {
                    // Simple vowel counting (approximate)
                    const vowels = word.match(/[aeiouy]/g);
                    totalSyllables += vowels ? vowels.length : 1;
                }
            });
            
            return totalSyllables;
        }
        
        function calculateReadingTime(wordCount) {
            return {
                slow: Math.ceil(wordCount / 150),
                average: Math.ceil(wordCount / 200),
                fast: Math.ceil(wordCount / 300),
                speaking: Math.ceil(wordCount / 130)
            };
        }
        
        function analyzeWordFrequency(text) {
            const words = text.toLowerCase()
                .replace(/[^\w\s]/g, '')
                .split(/\s+/)
                .filter(word => word.length > 3); // Ignore short words
            
            const frequency = {};
            words.forEach(word => {
                frequency[word] = (frequency[word] || 0) + 1;
            });
            
            // Convert to array and sort by frequency
            return Object.entries(frequency)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 10); // Top 10 words
        }
        
        function updateBasicStats(words, characters, sentences, paragraphs, readingLevel) {
            document.getElementById('wordCount').textContent = words.toLocaleString();
            document.getElementById('charCount').textContent = characters.toLocaleString();
            document.getElementById('sentenceCount').textContent = sentences.toLocaleString();
            document.getElementById('paragraphCount').textContent = paragraphs.toLocaleString();
            document.getElementById('readingLevel').textContent = readingLevel;
            
            document.getElementById('wordDetail').textContent = getWordCountDetail(words);
            document.getElementById('charDetail').textContent = getCharCountDetail(characters);
            document.getElementById('sentenceDetail').textContent = getSentenceDetail(sentences);
            document.getElementById('paragraphDetail').textContent = getParagraphDetail(paragraphs);
            document.getElementById('readingDetail').textContent = getReadingLevelDetail(readingLevel);
            
            // Calculate average word length
            const avgWordLength = words > 0 ? (characters / words).toFixed(1) : '0.0';
            document.getElementById('wordLength').textContent = avgWordLength;
            document.getElementById('lengthDetail').textContent = `${avgWordLength} chars per word`;
        }
        
        function updateReadingTimes(times) {
            document.getElementById('slowTime').textContent = formatTime(times.slow);
            document.getElementById('averageTime').textContent = formatTime(times.average);
            document.getElementById('fastTime').textContent = formatTime(times.fast);
            document.getElementById('speakingTime').textContent = formatTime(times.speaking);
        }
        
        function updateCharAnalysis(analysis) {
            document.getElementById('totalChars').textContent = analysis.totalChars.toLocaleString();
            document.getElementById('charsNoSpaces').textContent = analysis.charsNoSpaces.toLocaleString();
            document.getElementById('letterCount').textContent = analysis.letters.toLocaleString();
            document.getElementById('digitCount').textContent = analysis.digits.toLocaleString();
            document.getElementById('spaceCount').textContent = analysis.spaces.toLocaleString();
            document.getElementById('punctuationCount').textContent = analysis.punctuation.toLocaleString();
        }
        
        function updateSentenceAnalysis(analysis) {
            document.getElementById('avgSentenceWords').textContent = analysis.avgWords;
            document.getElementById('avgSentenceChars').textContent = analysis.avgChars;
            document.getElementById('shortSentences').textContent = analysis.short;
            document.getElementById('longSentences').textContent = analysis.long;
            document.getElementById('questionCount').textContent = analysis.questions;
            document.getElementById('exclamationCount').textContent = analysis.exclamations;
        }
        
        function updateWordFrequency(wordFrequency) {
            const container = document.getElementById('wordFrequencyList');
            container.innerHTML = '';
            
            if (wordFrequency.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: #7f8c8d;">Not enough words for frequency analysis</p>';
                return;
            }
            
            const maxFrequency = wordFrequency[0][1];
            
            wordFrequency.forEach(([word, count]) => {
                const percentage = (count / maxFrequency) * 100;
                const bar = document.createElement('div');
                bar.className = 'chart-bar';
                bar.innerHTML = `
                    <div class="chart-label">${word}</div>
                    <div class="chart-bar-inner">
                        <div class="chart-bar-fill" style="width: ${percentage}%"></div>
                    </div>
                    <div class="chart-percentage">${count}</div>
                `;
                container.appendChild(bar);
            });
        }
        
        function formatTime(minutes) {
            if (minutes === 0) return '0 min';
            if (minutes < 1) return '<1 min';
            return `${minutes} min`;
        }
        
        function getWordCountDetail(count) {
            if (count === 0) return 'No words';
            if (count < 50) return 'Very short';
            if (count < 200) return 'Short';
            if (count < 500) return 'Medium';
            if (count < 1000) return 'Long';
            return 'Very long';
        }
        
        function getCharCountDetail(count) {
            if (count === 0) return 'No characters';
            if (count < 140) return 'Tweet length';
            if (count < 300) return 'Short paragraph';
            if (count < 1000) return 'Medium length';
            return 'Long text';
        }
        
        function getSentenceDetail(count) {
            if (count === 0) return 'No sentences';
            if (count === 1) return 'Single sentence';
            return `${count} sentences`;
        }
        
        function getParagraphDetail(count) {
            if (count === 0) return 'No paragraphs';
            if (count === 1) return 'Single paragraph';
            return `${count} paragraphs`;
        }
        
        function getReadingLevelDetail(level) {
            if (level === 0) return 'No text';
            if (level < 6) return 'Elementary';
            if (level < 9) return 'Middle school';
            if (level < 13) return 'High school';
            return 'College level';
        }
        
        function loadSample(type) {
            document.getElementById('textInput').value = sampleTexts[type];
            analyzeText();
        }
        
        function clearText() {
            document.getElementById('textInput').value = '';
            analyzeText();
        }
        
        function copyText() {
            const textarea = document.getElementById('textInput');
            textarea.select();
            document.execCommand('copy');
            // Show some feedback
            alert('Text copied to clipboard!');
        }
        
        function addToHistory(words, chars) {
            const timestamp = new Date().toLocaleTimeString();
            analysisHistory.unshift({
                timestamp,
                words,
                chars
            });
            
            // Keep only last 10 analyses
            if (analysisHistory.length > 10) {
                analysisHistory = analysisHistory.slice(0, 10);
            }
        }
        
        function saveResults() {
            const text = document.getElementById('textInput').value;
            const words = document.getElementById('wordCount').textContent;
            const chars = document.getElementById('charCount').textContent;
            
            let results = 'Text Analysis Results\n';
            results += 'Generated: ' + new Date().toLocaleString() + '\n\n';
            results += `Word Count: ${words}\n`;
            results += `Character Count: ${chars}\n\n`;
            results += 'Text Content:\n';
            results += text + '\n';
            
            const blob = new Blob([results], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'text-analysis.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        // Initialize analysis on page load
        window.onload = analyzeText;
    </script>
</body>
</html>
