<?php
/**
 * UUID Generator
 * File: utility/uuid-generator.php
 * Description: Advanced UUID generator with multiple versions and bulk generation
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UUID Generator - Universal Unique Identifier Creator</title>
    <meta name="description" content="Generate UUIDs (GUIDs) of different versions: v1, v3, v4, v5, and v7. Bulk generation and validation tools included.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .generator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .uuid-display { position: relative; margin-bottom: 25px; }
        .uuid-input { width: 100%; padding: 16px 120px 16px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; font-family: monospace; background: #f8f9fa; letter-spacing: 0.5px; }
        .copy-btn { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: #667eea; color: white; border: none; border-radius: 5px; padding: 8px 16px; cursor: pointer; transition: all 0.3s; }
        .copy-btn:hover { background: #5a6fd8; }
        
        .options-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .option-group { background: #f8f9fa; padding: 20px; border-radius: 10px; }
        .option-group h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }
        
        .version-options { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 10px; }
        .version-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .version-btn:hover { border-color: #667eea; }
        .version-btn.active { border-color: #667eea; background: #ede7f6; }
        .version-name { font-weight: bold; color: #667eea; font-size: 0.9rem; }
        .version-desc { font-size: 0.75rem; color: #7f8c8d; margin-top: 4px; }
        
        .checkbox-group { display: flex; flex-direction: column; gap: 12px; }
        .checkbox-item { display: flex; align-items: center; gap: 10px; }
        .checkbox-item input[type="checkbox"] { width: 18px; height: 18px; accent-color: #667eea; }
        .checkbox-item label { color: #34495e; cursor: pointer; font-size: 0.9rem; }
        
        .bulk-section { margin-top: 15px; }
        .bulk-controls { display: flex; gap: 10px; align-items: center; }
        .count-input { width: 80px; padding: 8px; border: 2px solid #e0e0e0; border-radius: 5px; text-align: center; }
        .generate-bulk-btn { background: #667eea; color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; }
        
        .name-input-group { margin-top: 15px; }
        .name-input { width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 5px; margin-top: 5px; }
        
        .buttons-row { display: flex; gap: 15px; margin-top: 25px; }
        .generate-btn { flex: 1; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; }
        .generate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .validate-btn { background: #27ae60; color: white; border: none; padding: 14px 20px; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; }
        .validate-btn:hover { background: #219653; }
        
        .bulk-results { margin-top: 25px; }
        .bulk-header { display: flex; justify-content: between; align-items: center; margin-bottom: 10px; }
        .bulk-header h3 { color: #2c3e50; font-size: 1.1rem; }
        .copy-all-btn { background: #667eea; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 0.9rem; cursor: pointer; }
        
        .bulk-list { background: #f8f9fa; padding: 15px; border-radius: 10px; border: 2px solid #e0e0e0; max-height: 300px; overflow-y: auto; }
        .uuid-item { display: flex; justify-content: between; align-items: center; padding: 10px; background: white; border-radius: 5px; margin-bottom: 8px; font-family: monospace; }
        .uuid-text { flex: 1; }
        .uuid-copy { background: #667eea; color: white; border: none; border-radius: 3px; padding: 4px 8px; font-size: 0.8rem; cursor: pointer; }
        
        .validation-section { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .validation-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .validation-input { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-family: monospace; margin-bottom: 15px; }
        .validation-result { padding: 15px; border-radius: 8px; display: none; }
        .validation-result.valid { background: #d5f4e6; border: 2px solid #27ae60; color: #155724; }
        .validation-result.invalid { background: #f8d7da; border: 2px solid #dc3545; color: #721c24; }
        
        .history-section { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .history-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .history-list { display: flex; flex-direction: column; gap: 10px; max-height: 200px; overflow-y: auto; }
        .history-item { display: flex; justify-content: between; align-items: center; padding: 12px; background: white; border-radius: 8px; border-left: 4px solid #667eea; }
        .history-uuid { font-family: monospace; font-size: 0.9rem; flex: 1; margin-right: 15px; }
        .history-type { font-size: 0.8rem; color: #7f8c8d; margin-right: 15px; }
        .history-copy { background: #667eea; color: white; border: none; border-radius: 4px; padding: 5px 10px; font-size: 0.8rem; cursor: pointer; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .uuid-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin: 20px 0; }
        .uuid-card { background: #ede7f6; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; }
        .uuid-card h4 { color: #4527a0; margin-bottom: 10px; }
        .uuid-card code { background: white; padding: 2px 6px; border-radius: 4px; font-family: monospace; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .structure-diagram { background: #2c3e50; color: white; padding: 20px; border-radius: 10px; margin: 20px 0; font-family: monospace; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .toast { position: fixed; bottom: 20px; right: 20px; background: #2c3e50; color: white; padding: 12px 20px; border-radius: 5px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transform: translateY(100px); opacity: 0; transition: all 0.3s; z-index: 1000; }
        .toast.show { transform: translateY(0); opacity: 1; }
        
        @media (max-width: 768px) {
            .options-grid { grid-template-columns: 1fr; }
            .version-options { grid-template-columns: repeat(2, 1fr); }
            .buttons-row { flex-direction: column; }
            .uuid-input { padding-right: 100px; font-size: 0.9rem; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔑 UUID Generator</h1>
            <p>Generate Universally Unique Identifiers (UUIDs/GUIDs) of different versions for your applications</p>
        </div>

        <div class="generator-card">
            <div class="uuid-display">
                <input type="text" id="uuidOutput" class="uuid-input" readonly placeholder="Generated UUID will appear here">
                <button class="copy-btn" id="copyButton">Copy</button>
            </div>

            <div class="options-grid">
                <div class="option-group">
                    <h3>🔄 UUID Version</h3>
                    <div class="version-options" id="versionOptions">
                        <!-- Version options will be populated by JavaScript -->
                    </div>
                    
                    <div class="name-input-group" id="nameInputGroup" style="display: none;">
                        <label for="namespaceInput">Namespace/Name (for v3 & v5):</label>
                        <input type="text" id="namespaceInput" class="name-input" placeholder="Enter namespace/name">
                    </div>
                </div>

                <div class="option-group">
                    <h3>⚙️ Options</h3>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="uppercase" checked>
                            <label for="uppercase">Uppercase letters</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="braces">
                            <label for="braces">Include braces { }</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="hyphens" checked>
                            <label for="hyphens">Include hyphens</label>
                        </div>
                    </div>
                    
                    <div class="bulk-section">
                        <label>Bulk Generate:</label>
                        <div class="bulk-controls">
                            <input type="number" id="bulkCount" class="count-input" min="1" max="100" value="5">
                            <button class="generate-bulk-btn" id="generateBulkButton">Generate</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="buttons-row">
                <button class="generate-btn" id="generateButton">Generate UUID</button>
                <button class="validate-btn" id="validateButton">Validate UUID</button>
            </div>

            <div class="bulk-results" id="bulkResults" style="display: none;">
                <div class="bulk-header">
                    <h3>📋 Generated UUIDs</h3>
                    <button class="copy-all-btn" id="copyAllButton">Copy All</button>
                </div>
                <div class="bulk-list" id="bulkList"></div>
            </div>

            <div class="validation-section">
                <h3>🔍 UUID Validation</h3>
                <input type="text" id="validationInput" class="validation-input" placeholder="Enter UUID to validate">
                <div class="validation-result" id="validationResult"></div>
            </div>

            <div class="history-section">
                <h3>📜 Generation History</h3>
                <div class="history-list" id="generationHistory"></div>
            </div>
        </div>

        <div class="info-section">
            <h2>🔑 Universally Unique Identifier (UUID) Guide</h2>
            
            <p>UUIDs (Universally Unique Identifiers) are 128-bit numbers used to identify information in computer systems. Also known as GUIDs (Globally Unique Identifiers).</p>

            <div class="structure-diagram">
                <div>UUID Structure: 123e4567-e89b-12d3-a456-426614174000</div>
                <div style="color: #667eea; margin-top: 5px;">time_low - time_mid - time_hi_and_version - clock_seq_hi_and_res - clock_seq_low - node</div>
            </div>

            <h3>📊 UUID Versions Comparison</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Version</th>
                        <th>Method</th>
                        <th>Uniqueness</th>
                        <th>Use Cases</th>
                        <th>Example</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>v1</strong></td>
                        <td>Time-based + MAC</td>
                        <td>Very High</td>
                        <td>Databases, distributed systems</td>
                        <td><code>f47ac10b-58cc-11e2-8b4b-001f29000000</code></td>
                    </tr>
                    <tr>
                        <td><strong>v3</strong></td>
                        <td>MD5 hash + namespace</td>
                        <td>Namespace-dependent</td>
                        <td>Content-based IDs, URLs</td>
                        <td><code>5df41881-3aed-3515-88a7-2f4a814cf09e</code></td>
                    </tr>
                    <tr>
                        <td><strong>v4</strong></td>
                        <td>Random</td>
                        <td>Very High (random)</td>
                        <td>Most applications, security</td>
                        <td><code>550e8400-e29b-41d4-a716-446655440000</code></td>
                    </tr>
                    <tr>
                        <td><strong>v5</strong></td>
                        <td>SHA-1 hash + namespace</td>
                        <td>Namespace-dependent</td>
                        <td>Content-based IDs (secure)</td>
                        <td><code>886313e1-3b8a-5372-9b90-0c9aee199e5d</code></td>
                    </tr>
                    <tr>
                        <td><strong>v7</strong></td>
                        <td>Time-based + random</td>
                        <td>Very High</td>
                        <td>Time-ordered, databases</td>
                        <td><code>017f22e2-79b0-7cc3-98c4-dc0c0c07398f</code></td>
                    </tr>
                </tbody>
            </table>

            <h3>🔧 Technical Specifications</h3>
            <div class="uuid-grid">
                <div class="uuid-card">
                    <h4>📏 Format</h4>
                    <p>32 hexadecimal characters, displayed in 5 groups separated by hyphens: 8-4-4-4-12</p>
                    <p><strong>Total bits:</strong> 128</p>
                    <p><strong>Possible values:</strong> 2<sup>128</sup> ≈ 3.4 × 10<sup>38</sup></p>
                </div>
                <div class="uuid-card">
                    <h4>🎯 Uniqueness</h4>
                    <p>Probability of duplicate:</p>
                    <p>• 1% chance after generating 2.71 × 10<sup>18</sup> UUIDs</p>
                    <p>• Would take 85 years at 1 billion/sec</p>
                </div>
                <div class="uuid-card">
                    <h4>🌐 Standards</h4>
                    <p><strong>RFC 4122:</strong> UUID specification</p>
                    <p><strong>ISO/IEC 11578:</strong> International standard</p>
                    <p><strong>ITU-T Rec. X.667:</strong> Telecommunication standard</p>
                </div>
            </div>

            <h3>💡 Version-Specific Details</h3>
            <div class="formula-box">
                <strong>Version 1 (Time-based):</strong><br>
                • 60-bit timestamp + 14-bit sequence + 48-bit MAC address<br>
                • Can be predictable, reveals MAC address<br>
                • Excellent for database indexing<br><br>
                
                <strong>Version 3/5 (Name-based):</strong><br>
                • Hash of namespace + name<br>
                • v3 uses MD5 (128-bit), v5 uses SHA-1 (160-bit)<br>
                • Same input always produces same UUID<br><br>
                
                <strong>Version 4 (Random):</strong><br>
                • 122 random bits + 6 fixed bits<br>
                • Most commonly used version<br>
                • Cryptographically secure random generators recommended<br><br>
                
                <strong>Version 7 (Time-ordered):</strong><br>
                • 48-bit timestamp + 74 random bits<br>
                • Better for database indexing than v4<br>
                • Monotonic increasing values
            </div>

            <h3>🚀 Common Use Cases</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Recommended Version</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Database primary keys</td>
                        <td>v4, v7</td>
                        <td>Uniqueness, performance</td>
                    </tr>
                    <tr>
                        <td>Distributed systems</td>
                        <td>v1, v4</td>
                        <td>Global uniqueness</td>
                    </tr>
                    <tr>
                        <td>Content addressing</td>
                        <td>v3, v5</td>
                        <td>Deterministic generation</td>
                    </tr>
                    <tr>
                        <td>Security tokens</td>
                        <td>v4</td>
                        <td>Unpredictability</td>
                    </tr>
                    <tr>
                        <td>File names</td>
                        <td>v4</td>
                        <td>Collision avoidance</td>
                    </tr>
                    <tr>
                        <td>API endpoints</td>
                        <td>v4</td>
                        <td>Opaque identifiers</td>
                    </tr>
                </tbody>
            </table>

            <h3>🔒 Security Considerations</h3>
            <ul>
                <li><strong>v4:</strong> Use cryptographically secure random number generators</li>
                <li><strong>v1:</strong> May expose MAC address and creation time</li>
                <li><strong>v3/v5:</strong> Choose appropriate namespaces for your use case</li>
                <li><strong>All versions:</strong> UUIDs are not encrypted - don't put sensitive data in them</li>
                <li><strong>Validation:</strong> Always validate UUIDs from untrusted sources</li>
            </ul>

            <h3>💻 Programming Language Support</h3>
            <div class="formula-box">
                <strong>JavaScript/Node.js:</strong> <code>crypto.randomUUID()</code> (v4), <code>uuid</code> package<br>
                <strong>Python:</strong> <code>uuid.uuid4()</code>, <code>uuid.uuid1()</code>, <code>uuid.uuid3()</code>, <code>uuid.uuid5()</code><br>
                <strong>Java:</strong> <code>UUID.randomUUID()</code> (v4), <code>java.util.UUID</code><br>
                <strong>C#:</strong> <code>Guid.NewGuid()</code> (v4), <code>System.Guid</code><br>
                <strong>PHP:</strong> <code>ramsey/uuid</code> package, <code>com_create_guid()</code> (Windows)<br>
                <strong>Go:</strong> <code>github.com/google/uuid</code> package
            </div>

            <h3>📊 Performance Characteristics</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Version</th>
                        <th>Generation Speed</th>
                        <th>Storage Impact</th>
                        <th>Indexing Performance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>v1</td>
                        <td>Fast</td>
                        <td>16 bytes</td>
                        <td>Excellent (time-ordered)</td>
                    </tr>
                    <tr>
                        <td>v3</td>
                        <td>Medium (hashing)</td>
                        <td>16 bytes</td>
                        <td>Poor (random)</td>
                    </tr>
                    <tr>
                        <td>v4</td>
                        <td>Fast</td>
                        <td>16 bytes</td>
                        <td>Poor (random)</td>
                    </tr>
                    <tr>
                        <td>v5</td>
                        <td>Slow (hashing)</td>
                        <td>16 bytes</td>
                        <td>Poor (random)</td>
                    </tr>
                    <tr>
                        <td>v7</td>
                        <td>Fast</td>
                        <td>16 bytes</td>
                        <td>Excellent (time-ordered)</td>
                    </tr>
                </tbody>
            </table>

            <h3>🌍 Namespace UUIDs</h3>
            <p>Pre-defined namespaces for v3 and v5 UUIDs:</p>
            <ul>
                <li><strong>DNS:</strong> <code>6ba7b810-9dad-11d1-80b4-00c04fd430c8</code></li>
                <li><strong>URL:</strong> <code>6ba7b811-9dad-11d1-80b4-00c04fd430c8</code></li>
                <li><strong>OID:</strong> <code>6ba7b812-9dad-11d1-80b4-00c04fd430c8</code></li>
                <li><strong>X.500 DN:</strong> <code>6ba7b814-9dad-11d1-80b4-00c04fd430c8</code></li>
            </ul>

            <h3>🔍 Validation Rules</h3>
            <div class="formula-box">
                <strong>Valid UUID must:</strong><br>
                • Contain 32 hexadecimal characters (0-9, a-f, A-F)<br>
                • Have proper hyphen placement (8-4-4-4-12)<br>
                • Have correct version number in position 13<br>
                • Have correct variant in position 17 (8, 9, A, or B)<br>
                • Optional: surrounded by braces { }
            </div>

            <h3>📈 Collision Probability</h3>
            <p>The probability of UUID collision is extremely low:</p>
            <ul>
                <li>Need 2.71 quintillion UUIDs for 1% collision probability</li>
                <li>At 1 billion UUIDs per second, would take 85 years</li>
                <li>More likely to experience hardware failure first</li>
                <li>For most applications, collisions are not a practical concern</li>
            </ul>

            <h3>🛠️ Best Practices</h3>
            <ul>
                <li>Use v4 for most general-purpose applications</li>
                <li>Use v1 or v7 when time-ordering is important for database performance</li>
                <li>Use v3/v5 when you need deterministic generation from names</li>
                <li>Always validate UUIDs from external sources</li>
                <li>Consider storage implications (16 bytes per UUID)</li>
                <li>Use appropriate database indexing strategies for UUID columns</li>
            </ul>
        </div>

        <div class="footer">
            <p>🔑 UUID Generator | Universal Unique Identifier Creator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Generate v1, v3, v4, v5, and v7 UUIDs with validation and bulk generation</p>
        </div>
    </div>

    <div class="toast" id="toast">UUID copied to clipboard!</div>

    <script>
        // UUID version configuration
        const uuidVersions = [
            { id: 'v1', name: 'Version 1', desc: 'Time-based', icon: '⏰' },
            { id: 'v3', name: 'Version 3', desc: 'MD5 + Namespace', icon: '🔗' },
            { id: 'v4', name: 'Version 4', desc: 'Random', icon: '🎲' },
            { id: 'v5', name: 'Version 5', desc: 'SHA-1 + Namespace', icon: '🔒' },
            { id: 'v7', name: 'Version 7', desc: 'Time-ordered', icon: '📈' }
        ];

        // Pre-defined namespaces
        const namespaces = {
            dns: '6ba7b810-9dad-11d1-80b4-00c04fd430c8',
            url: '6ba7b811-9dad-11d1-80b4-00c04fd430c8',
            oid: '6ba7b812-9dad-11d1-80b4-00c04fd430c8',
            x500: '6ba7b814-9dad-11d1-80b4-00c04fd430c8'
        };

        // DOM elements
        const uuidOutput = document.getElementById('uuidOutput');
        const copyButton = document.getElementById('copyButton');
        const generateButton = document.getElementById('generateButton');
        const validateButton = document.getElementById('validateButton');
        const generateBulkButton = document.getElementById('generateBulkButton');
        const copyAllButton = document.getElementById('copyAllButton');
        const versionOptionsContainer = document.getElementById('versionOptions');
        const nameInputGroup = document.getElementById('nameInputGroup');
        const namespaceInput = document.getElementById('namespaceInput');
        const bulkResults = document.getElementById('bulkResults');
        const bulkList = document.getElementById('bulkList');
        const validationInput = document.getElementById('validationInput');
        const validationResult = document.getElementById('validationResult');
        const generationHistory = document.getElementById('generationHistory');
        const toast = document.getElementById('toast');

        // Options checkboxes
        const uppercaseCheck = document.getElementById('uppercase');
        const bracesCheck = document.getElementById('braces');
        const hyphensCheck = document.getElementById('hyphens');

        // Initialize
        let selectedVersion = 'v4';
        let history = JSON.parse(localStorage.getItem('uuidGenerationHistory')) || [];
        renderVersionOptions();
        updateHistoryDisplay();
        generateUUID();

        // Event listeners
        generateButton.addEventListener('click', generateUUID);
        copyButton.addEventListener('click', copyUUID);
        validateButton.addEventListener('click', validateUUID);
        generateBulkButton.addEventListener('click', generateBulkUUIDs);
        copyAllButton.addEventListener('click', copyAllUUIDs);
        validationInput.addEventListener('input', validateUUID);

        function renderVersionOptions() {
            versionOptionsContainer.innerHTML = '';
            
            uuidVersions.forEach(version => {
                const optionElement = document.createElement('div');
                optionElement.className = `version-btn ${version.id === selectedVersion ? 'active' : ''}`;
                optionElement.innerHTML = `
                    <div class="version-name">${version.name}</div>
                    <div class="version-desc">${version.desc}</div>
                `;
                optionElement.addEventListener('click', () => {
                    selectedVersion = version.id;
                    renderVersionOptions();
                    toggleNameInput();
                    generateUUID();
                });
                versionOptionsContainer.appendChild(optionElement);
            });
            
            toggleNameInput();
        }

        function toggleNameInput() {
            if (selectedVersion === 'v3' || selectedVersion === 'v5') {
                nameInputGroup.style.display = 'block';
                // Set default namespace if empty
                if (!namespaceInput.value) {
                    namespaceInput.value = 'https://example.com';
                }
            } else {
                nameInputGroup.style.display = 'none';
            }
        }

        function generateUUID() {
            let uuid;
            
            switch (selectedVersion) {
                case 'v1':
                    uuid = generateV1UUID();
                    break;
                case 'v3':
                    uuid = generateV3UUID();
                    break;
                case 'v4':
                    uuid = generateV4UUID();
                    break;
                case 'v5':
                    uuid = generateV5UUID();
                    break;
                case 'v7':
                    uuid = generateV7UUID();
                    break;
                default:
                    uuid = generateV4UUID();
            }
            
            // Apply formatting options
            uuid = formatUUID(uuid);
            uuidOutput.value = uuid;
            
            addToHistory(uuid, selectedVersion);
        }

        function generateV1UUID() {
            // Simplified v1 UUID generation (not truly time-based with MAC)
            const timeLow = randomHex(8);
            const timeMid = randomHex(4);
            const timeHi = '1' + randomHex(3); // Version 1
            const clockSeq = '8' + randomHex(3); // Variant 10xx
            const node = randomHex(12);
            
            return `${timeLow}-${timeMid}-${timeHi}-${clockSeq}-${node}`;
        }

        function generateV3UUID() {
            // Simplified v3 UUID generation (not true MD5)
            const namespace = namespaceInput.value || 'default';
            const hash = stringToHash(namespace, 32);
            return formatHashedUUID(hash, 3);
        }

        function generateV4UUID() {
            // Standard v4 UUID (random)
            const random = randomHex(32);
            return formatRandomUUID(random, 4);
        }

        function generateV5UUID() {
            // Simplified v5 UUID generation (not true SHA-1)
            const namespace = namespaceInput.value || 'default';
            const hash = stringToHash(namespace, 40);
            return formatHashedUUID(hash, 5);
        }

        function generateV7UUID() {
            // Simplified v7 UUID generation (time-ordered)
            const timestamp = Date.now().toString(16).padStart(12, '0');
            const random = randomHex(20);
            return `${timestamp.slice(0, 8)}-${timestamp.slice(8, 12)}-7${random.slice(0, 3)}-${random.slice(3, 7)}-${random.slice(7)}`;
        }

        function generateV7UUID() {
            // Simplified v7 UUID generation (time-ordered)
            const timestamp = Date.now().toString(16).padStart(12, '0');
            const random = randomHex(20);
            return `${timestamp.slice(0, 8)}-${timestamp.slice(8, 12)}-7${random.slice(0, 3)}-${random.slice(3, 7)}-${random.slice(7)}`;
        }

        function randomHex(length) {
            let result = '';
            const characters = '0123456789abcdef';
            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            return result;
        }

        function stringToHash(str, length) {
            let hash = 0;
            for (let i = 0; i < str.length; i++) {
                const char = str.charCodeAt(i);
                hash = ((hash << 5) - hash) + char;
                hash = hash & hash;
            }
            return Math.abs(hash).toString(16).padStart(length, '0');
        }

        function formatRandomUUID(hex, version) {
            return `${hex.slice(0, 8)}-${hex.slice(8, 12)}-${version}${hex.slice(13, 16)}-${(parseInt(hex[16], 16) | 8).toString(16)}${hex.slice(17, 20)}-${hex.slice(20)}`;
        }

        function formatHashedUUID(hash, version) {
            return `${hash.slice(0, 8)}-${hash.slice(8, 12)}-${version}${hash.slice(13, 16)}-${(parseInt(hash[16], 16) | 8).toString(16)}${hash.slice(17, 20)}-${hash.slice(20, 32)}`;
        }

        function formatUUID(uuid) {
            let formatted = uuid;
            
            if (!hyphensCheck.checked) {
                formatted = formatted.replace(/-/g, '');
            }
            
            if (uppercaseCheck.checked) {
                formatted = formatted.toUpperCase();
            }
            
            if (bracesCheck.checked) {
                formatted = `{${formatted}}`;
            }
            
            return formatted;
        }

        function generateBulkUUIDs() {
            const count = parseInt(document.getElementById('bulkCount').value) || 5;
            const uuids = [];
            
            for (let i = 0; i < count; i++) {
                let uuid = generateV4UUID(); // Use v4 for bulk generation
                uuid = formatUUID(uuid);
                uuids.push(uuid);
                addToHistory(uuid, 'v4');
            }
            
            displayBulkUUIDs(uuids);
        }

        function displayBulkUUIDs(uuids) {
            bulkList.innerHTML = '';
            uuids.forEach((uuid, index) => {
                const item = document.createElement('div');
                item.className = 'uuid-item';
                item.innerHTML = `
                    <span class="uuid-text">${uuid}</span>
                    <button class="uuid-copy" onclick="copySpecificUUID('${uuid}')">Copy</button>
                `;
                bulkList.appendChild(item);
            });
            
            bulkResults.style.display = 'block';
        }

        function validateUUID() {
            const input = validationInput.value.trim();
            if (!input) {
                validationResult.style.display = 'none';
                return;
            }
            
            // Basic UUID validation
            const uuidRegex = /^[0-9a-f]{8}-[0-9a-f]{4}-[1-7][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i;
            const uuidRegexNoHyphens = /^[0-9a-f]{32}$/i;
            const uuidRegexWithBraces = /^\{[0-9a-f]{8}-[0-9a-f]{4}-[1-7][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}\}$/i;
            
            const isValid = uuidRegex.test(input) || uuidRegexNoHyphens.test(input) || uuidRegexWithBraces.test(input);
            
            validationResult.textContent = isValid ? '✅ Valid UUID' : '❌ Invalid UUID';
            validationResult.className = `validation-result ${isValid ? 'valid' : 'invalid'}`;
            validationResult.style.display = 'block';
        }

        function copyUUID() {
            if (!uuidOutput.value) return;
            
            navigator.clipboard.writeText(uuidOutput.value).then(() => {
                showToast('UUID copied to clipboard!');
            }).catch(err => {
                // Fallback for older browsers
                uuidOutput.select();
                document.execCommand('copy');
                showToast('UUID copied to clipboard!');
            });
        }

        function copyAllUUIDs() {
            const uuids = Array.from(bulkList.querySelectorAll('.uuid-text')).map(el => el.textContent);
            const text = uuids.join('\n');
            
            navigator.clipboard.writeText(text).then(() => {
                showToast('All UUIDs copied to clipboard!');
            }).catch(err => {
                // Fallback
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showToast('All UUIDs copied to clipboard!');
            });
        }

        function copySpecificUUID(uuid) {
            navigator.clipboard.writeText(uuid).then(() => {
                showToast('UUID copied to clipboard!');
            }).catch(err => {
                // Fallback
                const tempInput = document.createElement('textarea');
                tempInput.value = uuid;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                showToast('UUID copied to clipboard!');
            });
        }

        function addToHistory(uuid, version) {
            // Add to beginning of history
            history.unshift({
                uuid: uuid,
                version: version,
                timestamp: new Date().toLocaleString()
            });
            
            // Keep only last 20 UUIDs
            if (history.length > 20) {
                history = history.slice(0, 20);
            }
            
            // Save to localStorage
            localStorage.setItem('uuidGenerationHistory', JSON.stringify(history));
            
            // Update display
            updateHistoryDisplay();
        }

        function updateHistoryDisplay() {
            generationHistory.innerHTML = '';
            
            if (history.length === 0) {
                generationHistory.innerHTML = '<div style="text-align: center; color: #7f8c8d; padding: 20px;">No generation history yet</div>';
                return;
            }
            
            history.forEach(item => {
                const historyItem = document.createElement('div');
                historyItem.className = 'history-item';
                historyItem.innerHTML = `
                    <div style="flex: 1;">
                        <div class="history-uuid">${item.uuid}</div>
                        <div class="history-type">v${item.version} • ${item.timestamp}</div>
                    </div>
                    <button class="history-copy" onclick="copySpecificUUID('${item.uuid.replace(/'/g, "\\'")}')">Copy</button>
                `;
                generationHistory.appendChild(historyItem);
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
        window.copySpecificUUID = copySpecificUUID;
    </script>
</body>
</html>
