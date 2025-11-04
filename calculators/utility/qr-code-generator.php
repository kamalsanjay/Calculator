<?php
/**
 * QR Code Generator
 * File: utility/qr-code-generator.php
 * Description: Advanced QR code generator with multiple content types and customization
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator - Professional QR Code Creation Tool</title>
    <meta name="description" content="Generate customizable QR codes for URLs, text, contacts, WiFi, and more with advanced styling options.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .generator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .controls-row { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input, .control-group textarea { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .control-group select:focus, .control-group input:focus, .control-group textarea:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .control-group textarea { min-height: 120px; resize: vertical; }
        
        .color-controls { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .color-picker { display: flex; align-items: center; gap: 10px; }
        .color-picker input[type="color"] { width: 50px; height: 50px; border: none; border-radius: 8px; cursor: pointer; }
        .color-picker span { font-size: 0.9rem; color: #555; }
        
        .qr-display-container { display: flex; flex-direction: column; align-items: center; gap: 20px; margin-bottom: 25px; }
        .qr-display { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; flex-direction: column; align-items: center; }
        #qrCode { max-width: 300px; max-height: 300px; border: 1px solid #e0e0e0; border-radius: 8px; }
        .qr-placeholder { width: 300px; height: 300px; background: #f8f9fa; border: 2px dashed #e0e0e0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #7f8c8d; font-size: 1.1rem; }
        
        .action-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .action-btn { padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3); }
        .action-btn.secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .action-btn.secondary:hover { border-color: #667eea; }
        .action-btn:disabled { background: #bdc3c7; cursor: not-allowed; transform: none; box-shadow: none; }
        
        .preview-section { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .preview-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .preview-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
        .preview-item { background: white; padding: 15px; border-radius: 8px; text-align: center; cursor: pointer; transition: all 0.3s; border: 2px solid transparent; }
        .preview-item:hover { border-color: #667eea; transform: translateY(-2px); }
        .preview-item.active { border-color: #667eea; background: #ede7f6; }
        .preview-icon { font-size: 2rem; margin-bottom: 8px; }
        .preview-label { font-size: 0.85rem; color: #2c3e50; font-weight: 600; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .qr-types { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin: 20px 0; }
        .qr-type-card { background: #f8f9fa; padding: 20px; border-radius: 10px; border-left: 4px solid #667eea; }
        .qr-type-card h4 { color: #2c3e50; margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .toast { position: fixed; bottom: 20px; right: 20px; background: #2c3e50; color: white; padding: 12px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transform: translateY(100px); opacity: 0; transition: all 0.3s; z-index: 1000; }
        .toast.show { transform: translateY(0); opacity: 1; }
        
        @media (max-width: 768px) {
            .controls-row { grid-template-columns: 1fr; gap: 15px; }
            .color-controls { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔳 Advanced QR Code Generator</h1>
            <p>Create customizable QR codes for URLs, text, contacts, WiFi, and more with professional styling options</p>
        </div>

        <div class="generator-card">
            <div class="controls-row">
                <div class="control-group">
                    <label for="contentType">Content Type</label>
                    <select id="contentType">
                        <option value="url">Website URL</option>
                        <option value="text">Plain Text</option>
                        <option value="email">Email</option>
                        <option value="phone">Phone Number</option>
                        <option value="sms">SMS</option>
                        <option value="wifi">WiFi Network</option>
                        <option value="vcard">Contact (vCard)</option>
                        <option value="event">Calendar Event</option>
                        <option value="crypto">Cryptocurrency</option>
                        <option value="social">Social Media</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label for="qrSize">QR Code Size</label>
                    <select id="qrSize">
                        <option value="200">Small (200×200)</option>
                        <option value="300" selected>Medium (300×300)</option>
                        <option value="400">Large (400×400)</option>
                        <option value="500">Extra Large (500×500)</option>
                    </select>
                </div>
            </div>
            
            <!-- Dynamic content area based on selected type -->
            <div id="contentArea">
                <div class="control-group">
                    <label for="urlInput">Website URL</label>
                    <input type="url" id="urlInput" placeholder="https://example.com" value="https://example.com">
                </div>
            </div>
            
            <div class="controls-row">
                <div class="control-group">
                    <label for="errorCorrection">Error Correction Level</label>
                    <select id="errorCorrection">
                        <option value="L">Low (7%) - Smallest</option>
                        <option value="M" selected>Medium (15%) - Balanced</option>
                        <option value="Q">Quartile (25%) - Better</option>
                        <option value="H">High (30%) - Best</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label for="margin">Margin Size</label>
                    <select id="margin">
                        <option value="0">No margin</option>
                        <option value="1">Small (1 module)</option>
                        <option value="2">Medium (2 modules)</option>
                        <option value="4" selected>Large (4 modules)</option>
                    </select>
                </div>
            </div>
            
            <div class="controls-row">
                <div class="control-group">
                    <label>Colors</label>
                    <div class="color-controls">
                        <div class="color-picker">
                            <input type="color" id="foregroundColor" value="#000000">
                            <span>Foreground</span>
                        </div>
                        <div class="color-picker">
                            <input type="color" id="backgroundColor" value="#FFFFFF">
                            <span>Background</span>
                        </div>
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="qrStyle">QR Code Style</label>
                    <select id="qrStyle">
                        <option value="squares" selected>Standard Squares</option>
                        <option value="dots">Dots</option>
                        <option value="rounded">Rounded</option>
                        <option value="classy">Classy</option>
                        <option value="circle">Circles</option>
                    </select>
                </div>
            </div>
            
            <div class="qr-display-container">
                <div class="qr-display">
                    <div id="qrCode" class="qr-placeholder">
                        Your QR code will appear here
                    </div>
                </div>
                
                <div class="action-buttons">
                    <button class="action-btn" id="generateBtn">
                        <span>⚡</span> Generate QR Code
                    </button>
                    <button class="action-btn secondary" id="downloadBtn" disabled>
                        <span>💾</span> Download QR Code
                    </button>
                    <button class="action-btn secondary" id="shareBtn" disabled>
                        <span>📤</span> Share QR Code
                    </button>
                </div>
            </div>
            
            <div class="preview-section">
                <h3>🚀 Quick Templates</h3>
                <div class="preview-grid">
                    <div class="preview-item active" data-type="url">
                        <div class="preview-icon">🌐</div>
                        <div class="preview-label">Website</div>
                    </div>
                    <div class="preview-item" data-type="wifi">
                        <div class="preview-icon">📶</div>
                        <div class="preview-label">WiFi</div>
                    </div>
                    <div class="preview-item" data-type="vcard">
                        <div class="preview-icon">👤</div>
                        <div class="preview-label">Contact</div>
                    </div>
                    <div class="preview-item" data-type="email">
                        <div class="preview-icon">📧</div>
                        <div class="preview-label">Email</div>
                    </div>
                    <div class="preview-item" data-type="social">
                        <div class="preview-icon">📱</div>
                        <div class="preview-label">Social Media</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🔳 QR Code Technology & Applications</h2>
            
            <p>QR (Quick Response) codes are two-dimensional barcodes that can store various types of data and be scanned by smartphones and dedicated readers.</p>

            <h3>📊 QR Code Specifications</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Version</th>
                        <th>Modules</th>
                        <th>Max Data Capacity</th>
                        <th>Use Cases</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>21×21</td><td>25 alphanumeric</td><td>Simple URLs</td></tr>
                    <tr><td>10</td><td>57×57</td><td>174 alphanumeric</td><td>Standard URLs</td></tr>
                    <tr><td>20</td><td>97×97</td><td>429 alphanumeric</td><td>Long text</td></tr>
                    <tr><td>40</td><td>177×177</td><td>1,817 numeric</td><td>Complex data</td></tr>
                </tbody>
            </table>

            <h3>🛡️ Error Correction Levels</h3>
            <div class="qr-types">
                <div class="qr-type-card">
                    <h4>🔴 Level L (Low)</h4>
                    <p>7% of codewords can be restored. Best for simple QR codes with high contrast.</p>
                </div>
                <div class="qr-type-card">
                    <h4>🟡 Level M (Medium)</h4>
                    <p>15% of codewords can be restored. Balanced option for most use cases.</p>
                </div>
                <div class="qr-type-card">
                    <h4>🟢 Level Q (Quartile)</h4>
                    <p>25% of codewords can be restored. Good for complex or damaged codes.</p>
                </div>
                <div class="qr-type-card">
                    <h4>🔵 Level H (High)</h4>
                    <p>30% of codewords can be restored. Maximum reliability for critical applications.</p>
                </div>
            </div>

            <div class="formula-box">
                <strong>QR Code Data Capacity by Type:</strong><br>
                • Numeric only: Up to 7,089 characters<br>
                • Alphanumeric: Up to 4,296 characters<br>
                • Binary/Byte: Up to 2,953 characters<br>
                • Kanji: Up to 1,817 characters
            </div>

            <h3>🌐 Common QR Code Types</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Format</th>
                        <th>Example</th>
                        <th>Use Case</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>URL</td><td>https://example.com</td><td>Website links</td><td>Marketing</td></tr>
                    <tr><td>vCard</td><td>BEGIN:VCARD...</td><td>Contact information</td><td>Business cards</td></tr>
                    <tr><td>WiFi</td><td>WIFI:S:SSID;T:WPA;P:pass;;</td><td>Network credentials</td><td>Guest access</td></tr>
                    <tr><td>Email</td><td>mailto:user@example.com</td><td>Email addresses</td><td>Contact forms</td></tr>
                    <tr><td>SMS</td><td>smsto:123456789:Message</td><td>Text messages</td><td>Marketing</td></tr>
                    <tr><td>Phone</td><td>tel:+1234567890</td><td>Phone numbers</td><td>Call to action</td></tr>
                </tbody>
            </table>

            <h3>🎨 QR Code Design Best Practices</h3>
            <ul>
                <li><strong>Contrast:</strong> Ensure high contrast between foreground and background colors</li>
                <li><strong>Size:</strong> Minimum 2×2 cm (0.8×0.8 in) for reliable scanning</li>
                <li><strong>Quiet Zone:</strong> Maintain adequate margin (4 modules recommended)</li>
                <li><strong>Error Correction:</strong> Use higher levels for complex designs or printing</li>
                <li><strong>Testing:</strong> Always test QR codes with multiple devices and apps</li>
            </ul>

            <h3>🏢 Business Applications</h3>
            <div class="qr-types">
                <div class="qr-type-card">
                    <h4>📱 Marketing & Advertising</h4>
                    <p>Product information, promotional offers, landing pages, app downloads</p>
                </div>
                <div class="qr-type-card">
                    <h4>🏪 Retail & E-commerce</h4>
                    <p>Product details, payment processing, loyalty programs, inventory tracking</p>
                </div>
                <div class="qr-type-card">
                    <h4>🏥 Healthcare</h4>
                    <p>Patient records, medication information, appointment scheduling</p>
                </div>
                <div class="qr-type-card">
                    <h4>🎫 Events & Ticketing</h4>
                    <p>Event registration, digital tickets, venue navigation, session information</p>
                </div>
            </div>

            <h3>🔧 Technical Implementation</h3>
            <ul>
                <li><strong>Encoding:</strong> Reed-Solomon error correction with mask patterns</li>
                <li><strong>Structure:</strong> Finder patterns, alignment patterns, timing patterns</li>
                <li><strong>Data Encoding:</strong> Mode indicator, character count indicator, data bitstream</li>
                <li><strong>Standards:</strong> ISO/IEC 18004:2015 (current standard)</li>
            </ul>

            <h3>📈 QR Code Usage Statistics</h3>
            <div class="formula-box">
                <strong>Global QR Code Usage:</strong><br>
                • 89% of smartphone users have scanned a QR code<br>
                • QR code usage grew 43% in 2023<br>
                • 65% of users prefer QR codes over typing URLs<br>
                • Top industries: Retail (32%), Food Service (28%), Healthcare (15%)
            </div>

            <h3>🔐 Security Considerations</h3>
            <ul>
                <li><strong>URL Inspection:</strong> Always check the destination before scanning</li>
                <li><strong>Dynamic QR Codes:</strong> Use for tracking and updating content</li>
                <li><strong>Authentication:</strong> Consider signed QR codes for sensitive data</li>
                <li><strong>Phishing Protection:</strong> Educate users about malicious QR codes</li>
            </ul>

            <h3>🚀 Advanced Features</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th>Description</th>
                        <th>Implementation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Dynamic QR</td><td>Editable destination URL</td><td>URL redirection service</td></tr>
                    <tr><td>Logo Insertion</td><td>Branding with company logo</td><td>Central image placement</td></tr>
                    <tr><td>Color Customization</td><td>Brand-specific colors</td><td>Custom foreground/background</td></tr>
                    <tr><td>Pattern Styles</td><td>Dots, rounded, circular</td><td>Alternative module shapes</td></tr>
                    <tr><td>Tracking</td><td>Scan analytics and metrics</td><td>Dynamic URLs with tracking</td></tr>
                </tbody>
            </table>

            <h3>📱 Mobile Optimization</h3>
            <ul>
                <li><strong>Size Requirements:</strong> Minimum 2×2 cm for reliable scanning</li>
                <li><strong>Placement:</strong> Eye-level positioning for better user experience</li>
                <li><strong>Lighting:</strong> Avoid glare and ensure adequate illumination</li>
                <li><strong>Testing:</strong> Test on iOS, Android, and various QR scanner apps</li>
            </ul>

            <h3>🌍 Global Standards</h3>
            <div class="formula-box">
                <strong>QR Code Standards:</strong><br>
                • ISO/IEC 18004:2015 - International standard<br>
                • JIS X 0510:2018 - Japanese industrial standard<br>
                • AIM International - Automatic identification standards<br>
                • GS1 QR Code - Retail and supply chain standard
            </div>

            <h3>💡 Future Trends</h3>
            <ul>
                <li><strong>AR Integration:</strong> QR codes triggering augmented reality experiences</li>
                <li><strong>Payment Systems:</strong> Increasing use in mobile payments and banking</li>
                <li><strong>Smart Packaging:</strong> Interactive product packaging with QR codes</li>
                <li><strong>Healthcare:</strong> Medical records and prescription tracking</li>
                <li><strong>IoT:</strong> Device configuration and smart home controls</li>
            </ul>
        </div>

        <div class="footer">
            <p>🔳 Professional QR Code Generator | Multiple Formats & Customization</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Generate URLs, contacts, WiFi, and more with advanced styling options</p>
        </div>
    </div>

    <div class="toast" id="toast">QR Code generated successfully!</div>

    <!-- QR Code Generation Library -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    
    <script>
        // DOM elements
        const contentType = document.getElementById('contentType');
        const contentArea = document.getElementById('contentArea');
        const qrSize = document.getElementById('qrSize');
        const errorCorrection = document.getElementById('errorCorrection');
        const margin = document.getElementById('margin');
        const foregroundColor = document.getElementById('foregroundColor');
        const backgroundColor = document.getElementById('backgroundColor');
        const qrStyle = document.getElementById('qrStyle');
        const generateBtn = document.getElementById('generateBtn');
        const downloadBtn = document.getElementById('downloadBtn');
        const shareBtn = document.getElementById('shareBtn');
        const qrCode = document.getElementById('qrCode');
        const toast = document.getElementById('toast');
        
        // Current QR code data
        let currentQRCode = null;
        let currentQRData = null;

        // Initialize
        updateContentArea();
        generateQRCode();

        // Event listeners
        contentType.addEventListener('change', updateContentArea);
        generateBtn.addEventListener('click', generateQRCode);
        downloadBtn.addEventListener('click', downloadQRCode);
        shareBtn.addEventListener('click', shareQRCode);
        
        // Preview template clicks
        document.querySelectorAll('.preview-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.preview-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                
                const type = this.dataset.type;
                contentType.value = type;
                updateContentArea();
            });
        });

        function updateContentArea() {
            const type = contentType.value;
            let html = '';
            
            switch(type) {
                case 'url':
                    html = `
                        <div class="control-group">
                            <label for="urlInput">Website URL</label>
                            <input type="url" id="urlInput" placeholder="https://example.com" value="https://example.com">
                        </div>
                    `;
                    break;
                    
                case 'text':
                    html = `
                        <div class="control-group">
                            <label for="textInput">Text Content</label>
                            <textarea id="textInput" placeholder="Enter your text here...">Hello World! This is a QR code.</textarea>
                        </div>
                    `;
                    break;
                    
                case 'email':
                    html = `
                        <div class="control-group">
                            <label for="emailInput">Email Address</label>
                            <input type="email" id="emailInput" placeholder="user@example.com" value="user@example.com">
                        </div>
                        <div class="control-group">
                            <label for="emailSubject">Subject (Optional)</label>
                            <input type="text" id="emailSubject" placeholder="Email subject">
                        </div>
                        <div class="control-group">
                            <label for="emailBody">Body (Optional)</label>
                            <textarea id="emailBody" placeholder="Email body content"></textarea>
                        </div>
                    `;
                    break;
                    
                case 'phone':
                    html = `
                        <div class="control-group">
                            <label for="phoneInput">Phone Number</label>
                            <input type="tel" id="phoneInput" placeholder="+1234567890" value="+1234567890">
                        </div>
                    `;
                    break;
                    
                case 'sms':
                    html = `
                        <div class="control-group">
                            <label for="smsNumber">Phone Number</label>
                            <input type="tel" id="smsNumber" placeholder="+1234567890" value="+1234567890">
                        </div>
                        <div class="control-group">
                            <label for="smsMessage">Message</label>
                            <textarea id="smsMessage" placeholder="Your SMS message">Hello, this is a test message!</textarea>
                        </div>
                    `;
                    break;
                    
                case 'wifi':
                    html = `
                        <div class="control-group">
                            <label for="wifiSSID">Network Name (SSID)</label>
                            <input type="text" id="wifiSSID" placeholder="MyWiFi" value="MyWiFi">
                        </div>
                        <div class="control-group">
                            <label for="wifiPassword">Password</label>
                            <input type="text" id="wifiPassword" placeholder="Password" value="MyPassword123">
                        </div>
                        <div class="control-group">
                            <label for="wifiEncryption">Encryption Type</label>
                            <select id="wifiEncryption">
                                <option value="WPA">WPA/WPA2</option>
                                <option value="WEP">WEP</option>
                                <option value="nopass">No Encryption</option>
                            </select>
                        </div>
                    `;
                    break;
                    
                case 'vcard':
                    html = `
                        <div class="control-group">
                            <label for="vcardName">Full Name</label>
                            <input type="text" id="vcardName" placeholder="John Doe" value="John Doe">
                        </div>
                        <div class="control-group">
                            <label for="vcardPhone">Phone Number</label>
                            <input type="tel" id="vcardPhone" placeholder="+1234567890" value="+1234567890">
                        </div>
                        <div class="control-group">
                            <label for="vcardEmail">Email</label>
                            <input type="email" id="vcardEmail" placeholder="john@example.com" value="john@example.com">
                        </div>
                        <div class="control-group">
                            <label for="vcardCompany">Company (Optional)</label>
                            <input type="text" id="vcardCompany" placeholder="Company Name">
                        </div>
                        <div class="control-group">
                            <label for="vcardWebsite">Website (Optional)</label>
                            <input type="url" id="vcardWebsite" placeholder="https://example.com">
                        </div>
                    `;
                    break;
                    
                case 'event':
                    html = `
                        <div class="control-group">
                            <label for="eventTitle">Event Title</label>
                            <input type="text" id="eventTitle" placeholder="Meeting" value="Business Meeting">
                        </div>
                        <div class="control-group">
                            <label for="eventStart">Start Date & Time</label>
                            <input type="datetime-local" id="eventStart" value="${getDefaultDateTime()}">
                        </div>
                        <div class="control-group">
                            <label for="eventEnd">End Date & Time</label>
                            <input type="datetime-local" id="eventEnd" value="${getDefaultDateTime(2)}">
                        </div>
                        <div class="control-group">
                            <label for="eventLocation">Location (Optional)</label>
                            <input type="text" id="eventLocation" placeholder="Conference Room A">
                        </div>
                        <div class="control-group">
                            <label for="eventDescription">Description (Optional)</label>
                            <textarea id="eventDescription" placeholder="Event details"></textarea>
                        </div>
                    `;
                    break;
                    
                case 'crypto':
                    html = `
                        <div class="control-group">
                            <label for="cryptoType">Cryptocurrency</label>
                            <select id="cryptoType">
                                <option value="bitcoin">Bitcoin (BTC)</option>
                                <option value="ethereum">Ethereum (ETH)</option>
                                <option value="litecoin">Litecoin (LTC)</option>
                                <option value="bitcoincash">Bitcoin Cash (BCH)</option>
                            </select>
                        </div>
                        <div class="control-group">
                            <label for="cryptoAddress">Wallet Address</label>
                            <input type="text" id="cryptoAddress" placeholder="1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa" value="1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa">
                        </div>
                        <div class="control-group">
                            <label for="cryptoAmount">Amount (Optional)</label>
                            <input type="number" id="cryptoAmount" placeholder="0.001" step="0.001">
                        </div>
                    `;
                    break;
                    
                case 'social':
                    html = `
                        <div class="control-group">
                            <label for="socialPlatform">Platform</label>
                            <select id="socialPlatform">
                                <option value="facebook">Facebook</option>
                                <option value="twitter">Twitter/X</option>
                                <option value="instagram">Instagram</option>
                                <option value="linkedin">LinkedIn</option>
                                <option value="youtube">YouTube</option>
                            </select>
                        </div>
                        <div class="control-group">
                            <label for="socialUsername">Username/Profile URL</label>
                            <input type="text" id="socialUsername" placeholder="@username or profile URL" value="@username">
                        </div>
                    `;
                    break;
            }
            
            contentArea.innerHTML = html;
        }

        function generateQRCode() {
            const type = contentType.value;
            let data = '';
            
            // Generate data based on type
            switch(type) {
                case 'url':
                    data = document.getElementById('urlInput').value;
                    if (!data.startsWith('http')) {
                        data = 'https://' + data;
                    }
                    break;
                    
                case 'text':
                    data = document.getElementById('textInput').value;
                    break;
                    
                case 'email':
                    const email = document.getElementById('emailInput').value;
                    const subject = document.getElementById('emailSubject').value;
                    const body = document.getElementById('emailBody').value;
                    data = `mailto:${email}`;
                    if (subject || body) {
                        data += '?';
                        if (subject) data += `subject=${encodeURIComponent(subject)}`;
                        if (body) data += `${subject ? '&' : ''}body=${encodeURIComponent(body)}`;
                    }
                    break;
                    
                case 'phone':
                    data = `tel:${document.getElementById('phoneInput').value}`;
                    break;
                    
                case 'sms':
                    const number = document.getElementById('smsNumber').value;
                    const message = document.getElementById('smsMessage').value;
                    data = `smsto:${number}:${message}`;
                    break;
                    
                case 'wifi':
                    const ssid = document.getElementById('wifiSSID').value;
                    const password = document.getElementById('wifiPassword').value;
                    const encryption = document.getElementById('wifiEncryption').value;
                    data = `WIFI:S:${ssid};T:${encryption};P:${password};;`;
                    break;
                    
                case 'vcard':
                    const name = document.getElementById('vcardName').value;
                    const phone = document.getElementById('vcardPhone').value;
                    const email = document.getElementById('vcardEmail').value;
                    const company = document.getElementById('vcardCompany').value;
                    const website = document.getElementById('vcardWebsite').value;
                    
                    data = `BEGIN:VCARD\nVERSION:3.0\nFN:${name}\nTEL:${phone}\nEMAIL:${email}`;
                    if (company) data += `\nORG:${company}`;
                    if (website) data += `\nURL:${website}`;
                    data += '\nEND:VCARD';
                    break;
                    
                case 'event':
                    const title = document.getElementById('eventTitle').value;
                    const start = document.getElementById('eventStart').value;
                    const end = document.getElementById('eventEnd').value;
                    const location = document.getElementById('eventLocation').value;
                    const description = document.getElementById('eventDescription').value;
                    
                    data = `BEGIN:VEVENT\nSUMMARY:${title}\nDTSTART:${formatCalendarDate(start)}\nDTEND:${formatCalendarDate(end)}`;
                    if (location) data += `\nLOCATION:${location}`;
                    if (description) data += `\nDESCRIPTION:${description}`;
                    data += '\nEND:VEVENT';
                    break;
                    
                case 'crypto':
                    const cryptoType = document.getElementById('cryptoType').value;
                    const address = document.getElementById('cryptoAddress').value;
                    const amount = document.getElementById('cryptoAmount').value;
                    
                    data = `${cryptoType}:${address}`;
                    if (amount) data += `?amount=${amount}`;
                    break;
                    
                case 'social':
                    const platform = document.getElementById('socialPlatform').value;
                    const username = document.getElementById('socialUsername').value;
                    
                    if (username.startsWith('http')) {
                        data = username;
                    } else {
                        const platforms = {
                            facebook: 'https://facebook.com/',
                            twitter: 'https://twitter.com/',
                            instagram: 'https://instagram.com/',
                            linkedin: 'https://linkedin.com/in/',
                            youtube: 'https://youtube.com/'
                        };
                        data = platforms[platform] + username.replace('@', '');
                    }
                    break;
            }
            
            if (!data) {
                showToast('Please enter valid data for the QR code');
                return;
            }
            
            currentQRData = data;
            
            // QR Code options
            const options = {
                width: parseInt(qrSize.value),
                height: parseInt(qrSize.value),
                colorDark: foregroundColor.value,
                colorLight: backgroundColor.value,
                correctLevel: QRCode.CorrectLevel[errorCorrection.value],
                margin: parseInt(margin.value)
            };
            
            // Clear previous QR code
            qrCode.innerHTML = '';
            
            // Generate new QR code
            QRCode.toCanvas(qrCode, data, options, function(error) {
                if (error) {
                    console.error(error);
                    showToast('Error generating QR code');
                    return;
                }
                
                // Apply styling
                applyQRStyle();
                
                // Enable download and share buttons
                downloadBtn.disabled = false;
                shareBtn.disabled = false;
                
                showToast('QR Code generated successfully!');
            });
        }

        function applyQRStyle() {
            const style = qrStyle.value;
            const canvas = qrCode.querySelector('canvas');
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const data = imageData.data;
            
            // Apply different styles by modifying the image data
            switch(style) {
                case 'dots':
                    // Convert squares to circles
                    for (let y = 0; y < canvas.height; y++) {
                        for (let x = 0; x < canvas.width; x++) {
                            const index = (y * canvas.width + x) * 4;
                            if (data[index] === 0) { // Black pixel
                                // Check if this is part of a larger square
                                if (isModuleCenter(x, y, canvas.width, canvas.height, data)) {
                                    // Draw circle
                                    drawCircle(ctx, x, y, 2, foregroundColor.value);
                                }
                            }
                        }
                    }
                    break;
                    
                case 'rounded':
                    // Round the corners of squares
                    for (let y = 0; y < canvas.height; y++) {
                        for (let x = 0; x < canvas.width; x++) {
                            const index = (y * canvas.width + x) * 4;
                            if (data[index] === 0) { // Black pixel
                                // Check corner positions and round accordingly
                                roundModuleCorners(ctx, x, y, canvas.width, canvas.height, data, foregroundColor.value);
                            }
                        }
                    }
                    break;
            }
        }

        function isModuleCenter(x, y, width, height, data) {
            // Simple check - if all surrounding pixels are also black, this is likely a center
            const neighbors = [
                [x-1, y-1], [x, y-1], [x+1, y-1],
                [x-1, y],             [x+1, y],
                [x-1, y+1], [x, y+1], [x+1, y+1]
            ];
            
            let blackNeighbors = 0;
            for (const [nx, ny] of neighbors) {
                if (nx >= 0 && nx < width && ny >= 0 && ny < height) {
                    const nIndex = (ny * width + nx) * 4;
                    if (data[nIndex] === 0) blackNeighbors++;
                }
            }
            
            return blackNeighbors >= 5; // Most neighbors are black
        }

        function drawCircle(ctx, x, y, radius, color) {
            ctx.fillStyle = color;
            ctx.beginPath();
            ctx.arc(x, y, radius, 0, 2 * Math.PI);
            ctx.fill();
        }

        function roundModuleCorners(ctx, x, y, width, height, data, color) {
            // This is a simplified implementation
            // In a real application, you'd need more sophisticated corner detection
            ctx.fillStyle = color;
            ctx.beginPath();
            ctx.roundRect(x - 0.5, y - 0.5, 1, 1, 2);
            ctx.fill();
        }

        function downloadQRCode() {
            if (!currentQRData) {
                showToast('Please generate a QR code first');
                return;
            }
            
            const canvas = qrCode.querySelector('canvas');
            if (!canvas) {
                showToast('No QR code available to download');
                return;
            }
            
            const link = document.createElement('a');
            link.download = `qrcode-${new Date().getTime()}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
            
            showToast('QR Code downloaded!');
        }

        function shareQRCode() {
            if (!currentQRData) {
                showToast('Please generate a QR code first');
                return;
            }
            
            const canvas = qrCode.querySelector('canvas');
            if (!canvas) {
                showToast('No QR code available to share');
                return;
            }
            
            canvas.toBlob(function(blob) {
                if (navigator.share && navigator.canShare({ files: [blob] })) {
                    navigator.share({
                        files: [new File([blob], 'qrcode.png', { type: 'image/png' })],
                        title: 'QR Code',
                        text: 'Check out this QR code I generated!'
                    }).then(() => {
                        showToast('QR Code shared successfully!');
                    }).catch(error => {
                        console.error('Error sharing:', error);
                        showToast('Sharing failed. Please download instead.');
                    });
                } else {
                    showToast('Sharing not supported. Please download instead.');
                }
            });
        }

        // Utility functions
        function getDefaultDateTime(hoursToAdd = 0) {
            const now = new Date();
            now.setHours(now.getHours() + hoursToAdd);
            return now.toISOString().slice(0, 16);
        }

        function formatCalendarDate(dateTimeString) {
            return dateTimeString.replace(/[-:]/g, '').replace('T', 'T') + '00Z';
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
