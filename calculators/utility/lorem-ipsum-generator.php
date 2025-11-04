<?php
/**
 * Lorem Ipsum Generator
 * File: utility/lorem-ipsum-generator.php
 * Description: Advanced Lorem Ipsum text generator with multiple formats, customization, and styling options
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Lorem Ipsum Generator - Multiple Formats & Customization</title>
    <meta name="description" content="Generate professional Lorem Ipsum text in paragraphs, lists, HTML format, and custom styles for all your design needs.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .generator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-bottom: 30px; }
        
        .panel-section { background: #f8f9fa; padding: 20px; border-radius: 12px; border-left: 4px solid #96e6a1; }
        .panel-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }
        
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input, .input-wrapper select, .input-wrapper textarea { width: 100%; padding: 12px 14px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus, .input-wrapper textarea:focus { outline: none; border-color: #96e6a1; box-shadow: 0 0 0 3px rgba(150, 230, 161, 0.1); }
        
        .range-group { display: flex; align-items: center; gap: 15px; }
        .range-value { min-width: 40px; text-align: center; font-weight: 600; color: #2c3e50; }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .checkbox-group input[type="checkbox"] { width: 18px; height: 18px; }
        
        .format-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px; margin-top: 10px; }
        .format-option { padding: 12px; text-align: center; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.2s; }
        .format-option.selected { background: #96e6a1; border-color: #4caf50; color: #1b5e20; font-weight: bold; }
        
        .generate-btn { background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%); color: #2c3e50; border: none; padding: 15px 25px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin-top: 10px; }
        .generate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(150, 230, 161, 0.3); }
        
        .quick-presets { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-top: 20px; }
        .preset-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .preset-btn:hover { border-color: #96e6a1; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(150, 230, 161, 0.15); }
        .preset-value { font-weight: bold; color: #96e6a1; font-size: 1rem; }
        .preset-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .results-section { margin-top: 30px; }
        .results-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.2rem; }
        
        .results-display { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 20px; max-height: 500px; overflow-y: auto; line-height: 1.6; }
        .results-display.paragraphs p { margin-bottom: 1.2em; }
        .results-display.lists ul, .results-display.lists ol { margin-left: 20px; margin-bottom: 1.2em; }
        .results-display.lists li { margin-bottom: 0.5em; }
        
        .action-buttons { display: flex; gap: 10px; margin-top: 15px; }
        .action-btn { padding: 10px 20px; background: white; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; transition: all 0.3s; font-size: 0.9rem; }
        .action-btn:hover { border-color: #96e6a1; background: #f1f8e9; }
        
        .statistics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 20px; }
        .stat-card { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #96e6a1; text-align: center; }
        .stat-label { color: #4527a0; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .stat-value { font-size: 1.15rem; font-weight: bold; color: #5e35b1; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .format-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .format-table th, .format-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .format-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .format-table tr:hover { background: #f5f5f5; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #96e6a1; }
        .formula-box strong { color: #96e6a1; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .statistics-grid { grid-template-columns: repeat(2, 1fr); }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { flex-direction: column; }
        }
        
        /* Custom styles for different formats */
        .html-heading { font-size: 1.5em; font-weight: bold; margin: 1em 0 0.5em 0; color: #2c3e50; }
        .html-subheading { font-size: 1.2em; font-weight: bold; margin: 0.8em 0 0.4em 0; color: #34495e; }
        .html-bold { font-weight: bold; }
        .html-italic { font-style: italic; }
        .html-highlight { background: #fff9c4; padding: 2px 4px; border-radius: 3px; }
        .html-code { font-family: monospace; background: #f5f5f5; padding: 2px 4px; border-radius: 3px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📝 Advanced Lorem Ipsum Generator</h1>
            <p>Generate professional placeholder text in multiple formats with custom styling options</p>
        </div>

        <div class="generator-card">
            <div class="control-panel">
                <div class="panel-section">
                    <h3>📊 Content Settings</h3>
                    <div class="input-group">
                        <label for="format">Output Format</label>
                        <div class="format-grid">
                            <div class="format-option selected" data-format="paragraphs">Paragraphs</div>
                            <div class="format-option" data-format="lists">Lists</div>
                            <div class="format-option" data-format="html">HTML</div>
                            <div class="format-option" data-format="words">Words Only</div>
                            <div class="format-option" data-format="title">Titles</div>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="amount">Amount</label>
                        <div class="range-group">
                            <input type="range" id="amount" min="1" max="20" value="5" class="input-wrapper">
                            <span class="range-value" id="amountValue">5</span>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="length">Length Variation</label>
                        <div class="range-group">
                            <input type="range" id="length" min="1" max="10" value="5" class="input-wrapper">
                            <span class="range-value" id="lengthValue">5</span>
                        </div>
                    </div>
                </div>
                
                <div class="panel-section">
                    <h3>🎨 Styling Options</h3>
                    <div class="checkbox-group">
                        <input type="checkbox" id="startWithLorem" checked>
                        <label for="startWithLorem">Start with "Lorem ipsum"</label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="includeLinks">
                        <label for="includeLinks">Include links in HTML format</label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="includeFormatting">
                        <label for="includeFormatting">Include text formatting</label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="includeHeaders">
                        <label for="includeHeaders">Include headers in HTML</label>
                    </div>
                    
                    <div class="input-group">
                        <label for="language">Language Style</label>
                        <div class="input-wrapper">
                            <select id="language">
                                <option value="classic">Classic Latin</option>
                                <option value="modern">Modern English Mix</option>
                                <option value="cicero">Cicero Style</option>
                                <option value="corporate">Corporate Jargon</option>
                                <option value="tech">Tech Terminology</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="panel-section">
                    <h3>⚙️ Advanced Options</h3>
                    <div class="input-group">
                        <label for="paragraphSize">Paragraph Size</label>
                        <div class="input-wrapper">
                            <select id="paragraphSize">
                                <option value="short">Short (2-4 sentences)</option>
                                <option value="medium" selected>Medium (4-6 sentences)</option>
                                <option value="long">Long (6-8 sentences)</option>
                                <option value="varying">Varying Lengths</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="listType">List Type (for list format)</label>
                        <div class="input-wrapper">
                            <select id="listType">
                                <option value="unordered">Unordered (bullet points)</option>
                                <option value="ordered">Ordered (numbered)</option>
                                <option value="mixed">Mixed</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="autoCopy">
                        <label for="autoCopy">Auto-copy to clipboard</label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="wordCount">
                        <label for="wordCount">Show word count statistics</label>
                    </div>
                </div>
            </div>
            
            <button class="generate-btn" onclick="generateLoremIpsum()">📝 Generate Lorem Ipsum</button>
            
            <div class="quick-presets">
                <div class="preset-btn" onclick="setQuickPreset('webpage')">
                    <div class="preset-value">Webpage</div>
                    <div class="preset-label">Headers + paragraphs</div>
                </div>
                <div class="preset-btn" onclick="setQuickPreset('article')">
                    <div class="preset-value">Article</div>
                    <div class="preset-label">Long form content</div>
                </div>
                <div class="preset-btn" onclick="setQuickPreset('product')">
                    <div class="preset-value">Product Page</div>
                    <div class="preset-label">Features + benefits</div>
                </div>
                <div class="preset-btn" onclick="setQuickPreset('blog')">
                    <div class="preset-value">Blog Post</div>
                    <div class="preset-label">Engaging content</div>
                </div>
            </div>
            
            <div class="results-section">
                <h3>📋 Generated Content</h3>
                <div class="results-display paragraphs" id="resultsDisplay">
                    <div class="result-item">Generated content will appear here...</div>
                </div>
                
                <div class="action-buttons">
                    <button class="action-btn" onclick="copyToClipboard()">📋 Copy to Clipboard</button>
                    <button class="action-btn" onclick="clearContent()">🗑️ Clear</button>
                    <button class="action-btn" onclick="downloadAsText()">📥 Download as Text</button>
                    <button class="action-btn" onclick="downloadAsHTML()">🌐 Download as HTML</button>
                </div>
                
                <div class="statistics-grid" id="statisticsGrid" style="display: none;">
                    <!-- Statistics will be populated here -->
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>📝 Professional Lorem Ipsum Generation</h2>
            
            <p>Generate high-quality placeholder text for all your design, development, and content creation needs with advanced customization options.</p>

            <h3>📊 Output Formats</h3>
            <table class="format-table">
                <thead>
                    <tr>
                        <th>Format</th>
                        <th>Description</th>
                        <th>Best For</th>
                        <th>Example Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Paragraphs</strong></td>
                        <td>Traditional paragraph structure</td>
                        <td>Articles, blogs, general content</td>
                        <td>Website body content</td>
                    </tr>
                    <tr>
                        <td><strong>Lists</strong></td>
                        <td>Ordered or unordered lists</td>
                        <td>Features, steps, navigation</td>
                        <td>Product feature lists</td>
                    </tr>
                    <tr>
                        <td><strong>HTML</strong></td>
                        <td>Formatted HTML with tags</td>
                        <td>Web development, CMS testing</td>
                        <td>Template development</td>
                    </tr>
                    <tr>
                        <td><strong>Words Only</strong></td>
                        <td>Individual words or short phrases</td>
                        <td>Labels, tags, metadata</td>
                        <td>Category names, tags</td>
                    </tr>
                    <tr>
                        <td><strong>Titles</strong></td>
                        <td>Heading-style text</td>
                        <td>Page titles, section headers</td>
                        <td>Navigation menus</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Classic Lorem Ipsum Origin:</strong><br>
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit..." is derived from Cicero's 45 BC text "de Finibus Bonorum et Malorum" (On the Ends of Good and Evil), specifically sections 1.10.32 and 1.10.33.
            </div>

            <h3>🎯 Applications</h3>
            <table class="format-table">
                <thead>
                    <tr>
                        <th>Industry</th>
                        <th>Use Case</th>
                        <th>Recommended Format</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Web Design</strong></td>
                        <td>Layout testing, template development</td>
                        <td>HTML with headers and paragraphs</td>
                    </tr>
                    <tr>
                        <td><strong>Print Design</strong></td>
                        <td>Brochures, magazines, books</td>
                        <td>Paragraphs with varying lengths</td>
                    </tr>
                    <tr>
                        <td><strong>App Development</strong></td>
                        <td>UI/UX testing, content placeholders</td>
                        <td>Words, short paragraphs, lists</td>
                    </tr>
                    <tr>
                        <td><strong>Content Strategy</strong></td>
                        <td>Content structure planning</td>
                        <td>Mixed formats with headers</td>
                    </tr>
                    <tr>
                        <td><strong>Marketing</strong></td>
                        <td>Campaign mockups, ad layouts</td>
                        <td>Titles, short compelling text</td>
                    </tr>
                    <tr>
                        <td><strong>Publishing</strong></td>
                        <td>Book layouts, article formatting</td>
                        <td>Long paragraphs, chapter styles</td>
                    </tr>
                </tbody>
            </table>

            <h3>📈 Content Statistics</h3>
            <ul>
                <li><strong>Average English word length:</strong> 4.7 characters</li>
                <li><strong>Average sentence length:</strong> 15-20 words</li>
                <li><strong>Optimal paragraph length:</strong> 3-5 sentences</li>
                <li><strong>Reading level:</strong> Adjustable from simple to complex</li>
                <li><strong>Character distribution:</strong> Mimics natural language patterns</li>
            </ul>

            <h3>🌍 Language Variations</h3>
            <div class="formula-box">
                <strong>Classic Latin:</strong> Traditional Lorem Ipsum from Cicero's works<br>
                <strong>Modern English Mix:</strong> Blends Latin with common English words<br>
                <strong>Cicero Style:</strong> Pure classical Latin phrasing<br>
                <strong>Corporate Jargon:</strong> Business and management terminology<br>
                <strong>Tech Terminology:</strong> Technology and computing terms
            </div>

            <h3>📐 Typography & Layout</h3>
            <table class="format-table">
                <thead>
                    <tr>
                        <th>Element</th>
                        <th>Standard Size</th>
                        <th>Best Practices</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Heading 1</strong></td>
                        <td>2em (32px)</td>
                        <td>Main title, one per page</td>
                    </tr>
                    <tr>
                        <td><strong>Heading 2</strong></td>
                        <td>1.5em (24px)</td>
                        <td>Section headings</td>
                    </tr>
                    <tr>
                        <td><strong>Heading 3</strong></td>
                        <td>1.25em (20px)</td>
                        <td>Sub-section headings</td>
                    </tr>
                    <tr>
                        <td><strong>Paragraph</strong></td>
                        <td>1em (16px)</td>
                        <td>Body text, line height 1.6</td>
                    </tr>
                    <tr>
                        <td><strong>List Items</strong></td>
                        <td>1em (16px)</td>
                        <td>Indented, with bullets/numbers</td>
                    </tr>
                </tbody>
            </table>

            <h3>💡 Best Practices</h3>
            <ul>
                <li>Use appropriate format for your specific use case</li>
                <li>Consider reading level and audience</li>
                <li>Maintain consistent paragraph lengths</li>
                <li>Include proper heading hierarchy in HTML format</li>
                <li>Test with real content as soon as possible</li>
                <li>Consider accessibility in your placeholder text</li>
            </ul>

            <h3>🔧 Technical Implementation</h3>
            <div class="formula-box">
                <strong>Content Generation Algorithm:</strong><br>
                • Markov chain-based text generation<br>
                • Customizable word pools and dictionaries<br>
                • Sentence structure randomization<br>
                • Paragraph length normalization<br>
                • HTML tag insertion and validation
            </div>

            <h3>📊 Readability Metrics</h3>
            <ul>
                <li><strong>Flesch Reading Ease:</strong> 60-70 (Standard)</li>
                <li><strong>Flesch-Kincaid Grade Level:</strong> 7-8</li>
                <li><strong>Gunning Fog Index:</strong> 10-12</li>
                <li><strong>SMOG Index:</strong> 8-10</li>
                <li><strong>Coleman-Liau Index:</strong> 9-11</li>
            </ul>

            <h3>🎨 Design Integration</h3>
            <table class="format-table">
                <thead>
                    <tr>
                        <th>Design Element</th>
                        <th>Lorem Ipsum Usage</th>
                        <th>Benefits</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Wireframes</strong></td>
                        <td>Content block representation</td>
                        <td>Focus on layout without content distraction</td>
                    </tr>
                    <tr>
                        <td><strong>Mockups</strong></td>
                        <td>Realistic text rendering</td>
                        <td>Accurate typography testing</td>
                    </tr>
                    <tr>
                        <td><strong>Prototypes</strong></td>
                        <td>Interactive content simulation</td>
                        <td>User experience testing</td>
                    </tr>
                    <tr>
                        <td><strong>Style Guides</strong></td>
                        <td>Typography examples</td>
                        <td>Consistent text styling demonstration</td>
                    </tr>
                </tbody>
            </table>

            <h3>🚀 Performance Considerations</h3>
            <ul>
                <li>Generate only needed amount of text</li>
                <li>Use appropriate format for your framework</li>
                <li>Consider SEO implications in production</li>
                <li>Optimize for mobile reading experience</li>
                <li>Test loading times with generated content</li>
            </ul>
        </div>

        <div class="footer">
            <p>📝 Advanced Lorem Ipsum Generator | Multiple Formats & Customization</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Paragraphs, lists, HTML format with styling options and statistics</p>
        </div>
    </div>

    <script>
        // DOM elements
        const formatOptions = document.querySelectorAll('.format-option');
        const amountSlider = document.getElementById('amount');
        const amountValue = document.getElementById('amountValue');
        const lengthSlider = document.getElementById('length');
        const lengthValue = document.getElementById('lengthValue');
        const startWithLoremCheckbox = document.getElementById('startWithLorem');
        const includeLinksCheckbox = document.getElementById('includeLinks');
        const includeFormattingCheckbox = document.getElementById('includeFormatting');
        const includeHeadersCheckbox = document.getElementById('includeHeaders');
        const languageSelect = document.getElementById('language');
        const paragraphSizeSelect = document.getElementById('paragraphSize');
        const listTypeSelect = document.getElementById('listType');
        const autoCopyCheckbox = document.getElementById('autoCopy');
        const wordCountCheckbox = document.getElementById('wordCount');
        const resultsDisplay = document.getElementById('resultsDisplay');
        const statisticsGrid = document.getElementById('statisticsGrid');

        // Word dictionaries for different styles
        const wordDictionaries = {
            classic: [
                'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit', 
                'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore', 'et', 'dolore', 
                'magna', 'aliqua', 'enim', 'ad', 'minim', 'veniam', 'quis', 'nostrud', 
                'exercitation', 'ullamco', 'laboris', 'nisi', 'aliquip', 'ex', 'ea', 'commodo', 
                'consequat', 'duis', 'aute', 'irure', 'reprehenderit', 'voluptate', 'velit', 
                'esse', 'cillum', 'eu', 'fugiat', 'nulla', 'pariatur', 'excepteur', 'sint', 
                'occaecat', 'cupidatat', 'non', 'proident', 'sunt', 'culpa', 'qui', 'officia', 
                'deserunt', 'mollit', 'anim', 'id', 'est', 'laborum'
            ],
            modern: [
                'digital', 'platform', 'solution', 'innovation', 'technology', 'business', 
                'strategy', 'development', 'management', 'system', 'service', 'product', 
                'company', 'team', 'project', 'process', 'data', 'information', 'experience', 
                'design', 'user', 'client', 'customer', 'market', 'industry', 'global', 
                'local', 'network', 'cloud', 'mobile', 'web', 'application', 'software', 
                'hardware', 'interface', 'framework', 'architecture', 'integration', 
                'automation', 'optimization', 'transformation', 'collaboration', 'communication'
            ],
            cicero: [
                'at', 'vero', 'eos', 'et', 'accusamus', 'et', 'iusto', 'odio', 'dignissimos', 
                'ducimus', 'qui', 'blanditiis', 'praesentium', 'voluptatum', 'deleniti', 
                'atque', 'corrupti', 'quos', 'dolores', 'et', 'quas', 'molestias', 'excepturi', 
                'sint', 'occaecati', 'cupiditate', 'non', 'provident', 'similique', 'sunt', 
                'in', 'culpa', 'qui', 'officia', 'deserunt', 'mollitia', 'animi', 'id', 
                'est', 'laborum', 'et', 'dolorum', 'fuga', 'et', 'harum', 'quidem', 'rerum', 
                'facilis', 'est', 'et', 'expedita', 'distinctio'
            ],
            corporate: [
                'leverage', 'synergy', 'paradigm', 'streamline', 'value-added', 'proactive', 
                'robust', 'scalable', 'innovative', 'strategic', 'holistic', 'client-focused', 
                'best-practice', 'cutting-edge', 'mission-critical', 'turnkey', 'end-to-end', 
                'next-generation', 'user-centric', 'quality-driven', 'results-oriented', 
                'cost-effective', 'time-efficient', 'market-leading', 'industry-standard', 
                'performance-based', 'quality-assured', 'risk-mitigated', 'compliance-ready'
            ],
            tech: [
                'algorithm', 'blockchain', 'cryptocurrency', 'database', 'encryption', 
                'firewall', 'gateway', 'hypertext', 'interface', 'javascript', 'kernel', 
                'latency', 'metadata', 'network', 'opensource', 'protocol', 'query', 
                'repository', 'server', 'token', 'upload', 'virtual', 'workstation', 
                'xml', 'yaml', 'zip', 'api', 'css', 'devops', 'endpoint', 'framework', 
                'git', 'html', 'iot', 'json', 'kubernetes', 'linux', 'microservice'
            ]
        };

        // Sentence templates
        const sentenceTemplates = [
            "The {adjective} {noun} {verb} {adverb} through the {adjective} {noun}.",
            "{ProperNoun} {verb} the {adjective} {noun} with {adjective} precision.",
            "When the {noun} {verb}, the {noun} becomes {adjective} and {adjective}.",
            "Every {noun} has a {adjective} {noun} that {verb} {adverb}.",
            "The {adjective} {noun} of the {noun} {verb} {adverb} in the {noun}.",
            "{ProperNoun} discovered that {noun} could {verb} {adverb} without {noun}.",
            "In the {adjective} {noun}, the {noun} {verb} with {adjective} {noun}.",
            "The {noun} {verb} {adverb} when the {adjective} {noun} {verb}.",
            "{ProperNoun} {verb} that {noun} was more {adjective} than {noun}.",
            "Without {adjective} {noun}, the {noun} cannot {verb} {adverb}."
        ];

        // Update slider values
        amountSlider.addEventListener('input', function() {
            amountValue.textContent = this.value;
        });

        lengthSlider.addEventListener('input', function() {
            lengthValue.textContent = this.value;
        });

        // Format selection
        formatOptions.forEach(option => {
            option.addEventListener('click', function() {
                formatOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // Get selected format
        function getSelectedFormat() {
            return document.querySelector('.format-option.selected').dataset.format;
        }

        // Generate Lorem Ipsum content
        function generateLoremIpsum() {
            const format = getSelectedFormat();
            const amount = parseInt(amountSlider.value);
            const lengthVariation = parseInt(lengthSlider.value);
            const startWithLorem = startWithLoremCheckbox.checked;
            const includeLinks = includeLinksCheckbox.checked;
            const includeFormatting = includeFormattingCheckbox.checked;
            const includeHeaders = includeHeadersCheckbox.checked;
            const language = languageSelect.value;
            const paragraphSize = paragraphSizeSelect.value;
            const listType = listTypeSelect.value;
            const showWordCount = wordCountCheckbox.checked;
            
            let content = '';
            
            switch(format) {
                case 'paragraphs':
                    content = generateParagraphs(amount, lengthVariation, startWithLorem, language, paragraphSize);
                    break;
                case 'lists':
                    content = generateLists(amount, lengthVariation, language, listType);
                    break;
                case 'html':
                    content = generateHTML(amount, lengthVariation, startWithLorem, language, paragraphSize, includeLinks, includeFormatting, includeHeaders);
                    break;
                case 'words':
                    content = generateWords(amount, language);
                    break;
                case 'title':
                    content = generateTitles(amount, language);
                    break;
            }
            
            // Display results
            displayResults(content, format);
            
            // Show statistics if requested
            if (showWordCount) {
                displayStatistics(content);
                statisticsGrid.style.display = 'grid';
            } else {
                statisticsGrid.style.display = 'none';
            }
            
            // Auto-copy if enabled
            if (autoCopyCheckbox.checked) {
                copyToClipboard();
            }
        }

        // Generation methods
        function generateParagraphs(count, variation, startWithLorem, language, size) {
            let paragraphs = [];
            const words = wordDictionaries[language];
            
            for (let i = 0; i < count; i++) {
                let sentenceCount;
                switch(size) {
                    case 'short': sentenceCount = 2 + Math.floor(Math.random() * 2); break;
                    case 'medium': sentenceCount = 4 + Math.floor(Math.random() * 2); break;
                    case 'long': sentenceCount = 6 + Math.floor(Math.random() * 2); break;
                    case 'varying': sentenceCount = 2 + Math.floor(Math.random() * 6); break;
                }
                
                let paragraph = '';
                for (let j = 0; j < sentenceCount; j++) {
                    if (i === 0 && j === 0 && startWithLorem) {
                        paragraph += 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ';
                    } else {
                        paragraph += generateSentence(words, variation) + ' ';
                    }
                }
                paragraphs.push(`<p>${paragraph.trim()}</p>`);
            }
            
            return paragraphs.join('\n\n');
        }

        function generateLists(count, variation, language, listType) {
            let lists = [];
            const words = wordDictionaries[language];
            
            for (let i = 0; i < count; i++) {
                const itemCount = 3 + Math.floor(Math.random() * 5);
                let listItems = [];
                
                for (let j = 0; j < itemCount; j++) {
                    const sentence = generateSentence(words, variation);
                    listItems.push(`<li>${sentence}</li>`);
                }
                
                const listTag = listType === 'ordered' ? 'ol' : 'ul';
                if (listType === 'mixed') {
                    const randomListType = Math.random() > 0.5 ? 'ol' : 'ul';
                    lists.push(`<${randomListType}>\n${listItems.join('\n')}\n</${randomListType}>`);
                } else {
                    lists.push(`<${listTag}>\n${listItems.join('\n')}\n</${listTag}>`);
                }
            }
            
            return lists.join('\n\n');
        }

        function generateHTML(count, variation, startWithLorem, language, size, includeLinks, includeFormatting, includeHeaders) {
            let html = '';
            const words = wordDictionaries[language];
            
            if (includeHeaders) {
                html += `<h1 class="html-heading">${generateTitle(words)}</h1>\n\n`;
                
                if (count > 2) {
                    html += `<h2 class="html-subheading">${generateTitle(words)}</h2>\n\n`;
                }
            }
            
            for (let i = 0; i < count; i++) {
                if (includeHeaders && i % 3 === 0 && i > 0) {
                    html += `<h2 class="html-subheading">${generateTitle(words)}</h2>\n\n`;
                }
                
                let sentenceCount;
                switch(size) {
                    case 'short': sentenceCount = 2 + Math.floor(Math.random() * 2); break;
                    case 'medium': sentenceCount = 4 + Math.floor(Math.random() * 2); break;
                    case 'long': sentenceCount = 6 + Math.floor(Math.random() * 2); break;
                    case 'varying': sentenceCount = 2 + Math.floor(Math.random() * 6); break;
                }
                
                let paragraph = '';
                for (let j = 0; j < sentenceCount; j++) {
                    let sentence = '';
                    if (i === 0 && j === 0 && startWithLorem) {
                        sentence = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
                    } else {
                        sentence = generateSentence(words, variation);
                    }
                    
                    // Apply formatting if enabled
                    if (includeFormatting && Math.random() > 0.7) {
                        if (Math.random() > 0.5) {
                            sentence = `<strong class="html-bold">${sentence}</strong>`;
                        } else {
                            sentence = `<em class="html-italic">${sentence}</em>`;
                        }
                    }
                    
                    // Add links if enabled
                    if (includeLinks && Math.random() > 0.8) {
                        const linkText = generateSentence(words, 1).split(' ').slice(0, 2).join(' ');
                        sentence = sentence.replace(linkText, `<a href="#" class="html-link">${linkText}</a>`);
                    }
                    
                    paragraph += sentence + ' ';
                }
                
                html += `<p>${paragraph.trim()}</p>\n\n`;
            }
            
            return html;
        }

        function generateWords(count, language) {
            const words = wordDictionaries[language];
            const result = [];
            
            for (let i = 0; i < count; i++) {
                const wordCount = 1 + Math.floor(Math.random() * 3);
                let phrase = '';
                for (let j = 0; j < wordCount; j++) {
                    const randomIndex = Math.floor(Math.random() * words.length);
                    phrase += (j === 0 ? '' : ' ') + words[randomIndex];
                }
                result.push(phrase);
            }
            
            return result.join(', ');
        }

        function generateTitles(count, language) {
            const words = wordDictionaries[language];
            const result = [];
            
            for (let i = 0; i < count; i++) {
                result.push(generateTitle(words));
            }
            
            return result.join('\n');
        }

        // Helper functions
        function generateSentence(words, variation) {
            const wordCount = 5 + Math.floor(Math.random() * 5) + variation;
            let sentence = '';
            
            for (let i = 0; i < wordCount; i++) {
                const randomIndex = Math.floor(Math.random() * words.length);
                let word = words[randomIndex];
                
                // Capitalize first word
                if (i === 0) {
                    word = word.charAt(0).toUpperCase() + word.slice(1);
                }
                
                sentence += (i === 0 ? '' : ' ') + word;
            }
            
            return sentence + '.';
        }

        function generateTitle(words) {
            const wordCount = 2 + Math.floor(Math.random() * 4);
            let title = '';
            
            for (let i = 0; i < wordCount; i++) {
                const randomIndex = Math.floor(Math.random() * words.length);
                let word = words[randomIndex];
                
                // Capitalize all words in title
                word = word.charAt(0).toUpperCase() + word.slice(1);
                title += (i === 0 ? '' : ' ') + word;
            }
            
            return title;
        }

        // Display results
        function displayResults(content, format) {
            resultsDisplay.className = `results-display ${format}`;
            resultsDisplay.innerHTML = content;
        }

        // Display statistics
        function displayStatistics(content) {
            // Remove HTML tags for accurate counting
            const textOnly = content.replace(/<[^>]*>/g, ' ');
            const words = textOnly.split(/\s+/).filter(word => word.length > 0);
            const characters = textOnly.replace(/\s/g, '').length;
            const sentences = textOnly.split(/[.!?]+/).filter(s => s.trim().length > 0);
            const paragraphs = content.split(/<\/p>|<\/li>/).filter(p => p.trim().length > 0);
            
            const wordCount = words.length;
            const charCount = characters;
            const sentenceCount = sentences.length;
            const paragraphCount = paragraphs.length;
            const avgWordsPerSentence = wordCount / sentenceCount;
            const avgCharsPerWord = charCount / wordCount;
            
            statisticsGrid.innerHTML = `
                <div class="stat-card">
                    <div class="stat-label">Words</div>
                    <div class="stat-value">${wordCount}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Characters</div>
                    <div class="stat-value">${charCount}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Sentences</div>
                    <div class="stat-value">${sentenceCount}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Paragraphs</div>
                    <div class="stat-value">${paragraphCount}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Words/Sentence</div>
                    <div class="stat-value">${avgWordsPerSentence.toFixed(1)}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Chars/Word</div>
                    <div class="stat-value">${avgCharsPerWord.toFixed(1)}</div>
                </div>
            `;
        }

        // Action functions
        function copyToClipboard() {
            const text = resultsDisplay.innerText || resultsDisplay.textContent;
            navigator.clipboard.writeText(text).then(() => {
                alert('Content copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }

        function clearContent() {
            resultsDisplay.innerHTML = '<div class="result-item">Content cleared</div>';
            statisticsGrid.style.display = 'none';
        }

        function downloadAsText() {
            const text = resultsDisplay.innerText || resultsDisplay.textContent;
            const blob = new Blob([text], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'lorem-ipsum.txt';
            a.click();
            URL.revokeObjectURL(url);
        }

        function downloadAsHTML() {
            const html = resultsDisplay.innerHTML;
            const blob = new Blob([`<!DOCTYPE html><html><head><title>Lorem Ipsum</title></head><body>${html}</body></html>`], { type: 'text/html' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'lorem-ipsum.html';
            a.click();
            URL.revokeObjectURL(url);
        }

        // Quick presets
        function setQuickPreset(preset) {
            switch(preset) {
                case 'webpage':
                    document.querySelector('[data-format="html"]').click();
                    includeHeadersCheckbox.checked = true;
                    includeLinksCheckbox.checked = true;
                    includeFormattingCheckbox.checked = true;
                    amountSlider.value = 6;
                    amountValue.textContent = '6';
                    languageSelect.value = 'modern';
                    break;
                case 'article':
                    document.querySelector('[data-format="paragraphs"]').click();
                    paragraphSizeSelect.value = 'long';
                    amountSlider.value = 8;
                    amountValue.textContent = '8';
                    languageSelect.value = 'classic';
                    break;
                case 'product':
                    document.querySelector('[data-format="lists"]').click();
                    listTypeSelect.value = 'unordered';
                    amountSlider.value = 4;
                    amountValue.textContent = '4';
                    languageSelect.value = 'corporate';
                    break;
                case 'blog':
                    document.querySelector('[data-format="html"]').click();
                    includeHeadersCheckbox.checked = true;
                    amountSlider.value = 5;
                    amountValue.textContent = '5';
                    languageSelect.value = 'modern';
                    break;
            }
            
            generateLoremIpsum();
        }

        // Initial generation
        generateLoremIpsum();
    </script>
</body>
</html>
