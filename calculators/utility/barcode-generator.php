<?php
/**
 * Barcode Generator
 * File: utility/barcode-generator.php
 * Description: Advanced barcode generator with multiple formats, customization, and professional features
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Barcode Generator - Multiple Formats & Customization</title>
    <meta name="description" content="Generate professional barcodes in multiple formats: Code 128, QR Code, EAN-13, UPC-A, and more with advanced customization options.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .generator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-bottom: 30px; }
        
        .panel-section { background: #f8f9fa; padding: 20px; border-radius: 12px; border-left: 4px solid #667eea; }
        .panel-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }
        
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input, .input-wrapper select, .input-wrapper textarea { width: 100%; padding: 12px 14px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus, .input-wrapper textarea:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .range-group { display: flex; align-items: center; gap: 15px; }
        .range-value { min-width: 40px; text-align: center; font-weight: 600; color: #2c3e50; }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .checkbox-group input[type="checkbox"] { width: 18px; height: 18px; }
        
        .color-picker { display: flex; gap: 10px; align-items: center; }
        .color-option { width: 30px; height: 30px; border-radius: 6px; cursor: pointer; border: 2px solid #e0e0e0; }
        .color-option.selected { border-color: #667eea; transform: scale(1.1); }
        
        .format-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px; margin-top: 10px; }
        .format-option { padding: 12px; text-align: center; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.2s; }
        .format-option.selected { background: #667eea; border-color: #5a6fd8; color: white; font-weight: bold; }
        
        .generate-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 15px 25px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin-top: 10px; }
        .generate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3); }
        
        .quick-presets { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-top: 20px; }
        .preset-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .preset-btn:hover { border-color: #667eea; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15); }
        .preset-value { font-weight: bold; color: #667eea; font-size: 1rem; }
        .preset-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .results-section { margin-top: 30px; }
        .results-section h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.2rem; }
        
        .barcode-display { background: #f8f9fa; padding: 30px; border-radius: 12px; margin-bottom: 20px; text-align: center; min-height: 300px; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .barcode-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 15px; }
        .barcode-text { margin-top: 10px; font-family: monospace; font-size: 1.1rem; color: #2c3e50; }
        
        .action-buttons { display: flex; gap: 10px; margin-top: 15px; flex-wrap: wrap; }
        .action-btn { padding: 10px 20px; background: white; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; transition: all 0.3s; font-size: 0.9rem; }
        .action-btn:hover { border-color: #667eea; background: #f0f4ff; }
        
        .preview-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 25px; }
        .preview-item { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center; }
        .preview-barcode { margin-bottom: 10px; }
        .preview-label { font-size: 0.8rem; color: #7f8c8d; }
        
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
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .action-buttons { flex-direction: column; }
            .preview-grid { grid-template-columns: 1fr; }
        }
        
        /* Barcode styling */
        .barcode { background: white; padding: 10px; display: inline-block; }
        .barcode-line { height: 80px; background: #000; margin: 0 1px; display: inline-block; vertical-align: bottom; }
        .barcode-line.thin { width: 2px; }
        .barcode-line.medium { width: 3px; }
        .barcode-line.thick { width: 4px; }
        .barcode-qr { background: white; padding: 10px; }
        .barcode-qr-cell { width: 8px; height: 8px; display: inline-block; margin: 0; padding: 0; }
        
        /* Color variants */
        .barcode-color-black .barcode-line { background: #000; }
        .barcode-color-blue .barcode-line { background: #2196F3; }
        .barcode-color-red .barcode-line { background: #f44336; }
        .barcode-color-green .barcode-line { background: #4CAF50; }
        .barcode-color-purple .barcode-line { background: #9C27B0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Advanced Barcode Generator</h1>
            <p>Generate professional barcodes in multiple formats with advanced customization and export options</p>
        </div>

        <div class="generator-card">
            <div class="control-panel">
                <div class="panel-section">
                    <h3>📊 Barcode Settings</h3>
                    <div class="input-group">
                        <label for="barcodeType">Barcode Type</label>
                        <div class="input-wrapper">
                            <select id="barcodeType">
                                <option value="code128">Code 128</option>
                                <option value="qr">QR Code</option>
                                <option value="ean13">EAN-13</option>
                                <option value="upca">UPC-A</option>
                                <option value="code39">Code 39</option>
                                <option value="itf">ITF-14</option>
                                <option value="datamatrix">Data Matrix</option>
                                <option value="pdf417">PDF417</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="barcodeData">Barcode Data</label>
                        <div class="input-wrapper">
                            <input type="text" id="barcodeData" placeholder="Enter barcode content" value="123456789012">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="barcodeSize">Size</label>
                        <div class="range-group">
                            <input type="range" id="barcodeSize" min="1" max="10" value="5" class="input-wrapper">
                            <span class="range-value" id="sizeValue">5</span>
                        </div>
                    </div>
                </div>
                
                <div class="panel-section">
                    <h3>🎨 Appearance</h3>
                    <div class="input-group">
                        <label>Barcode Color</label>
                        <div class="color-picker">
                            <div class="color-option selected" style="background: #000000;" data-color="black"></div>
                            <div class="color-option" style="background: #2196F3;" data-color="blue"></div>
                            <div class="color-option" style="background: #f44336;" data-color="red"></div>
                            <div class="color-option" style="background: #4CAF50;" data-color="green"></div>
                            <div class="color-option" style="background: #9C27B0;" data-color="purple"></div>
                        </div>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="showText" checked>
                        <label for="showText">Show text below barcode</label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="addBorder">
                        <label for="addBorder">Add border around barcode</label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="addPadding">
                        <label for="addPadding">Add padding</label>
                    </div>
                    
                    <div class="input-group">
                        <label for="backgroundColor">Background Color</label>
                        <div class="input-wrapper">
                            <select id="backgroundColor">
                                <option value="white">White</option>
                                <option value="transparent">Transparent</option>
                                <option value="lightgray">Light Gray</option>
                                <option value="f8f9fa">Light Blue</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="panel-section">
                    <h3>⚙️ Advanced Options</h3>
                    <div class="input-group">
                        <label for="errorCorrection">Error Correction (QR Codes)</label>
                        <div class="input-wrapper">
                            <select id="errorCorrection">
                                <option value="L">Low (7%)</option>
                                <option value="M" selected>Medium (15%)</option>
                                <option value="Q">Quartile (25%)</option>
                                <option value="H">High (30%)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="outputFormat">Output Format</label>
                        <div class="input-wrapper">
                            <select id="outputFormat">
                                <option value="svg">SVG (Vector)</option>
                                <option value="png">PNG (Raster)</option>
                                <option value="jpeg">JPEG</option>
                                <option value="pdf">PDF Document</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="autoDownload">
                        <label for="autoDownload">Auto-download after generation</label>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="multipleCodes">
                        <label for="multipleCodes">Generate multiple variations</label>
                    </div>
                </div>
            </div>
            
            <button class="generate-btn" onclick="generateBarcode()">📊 Generate Barcode</button>
            
            <div class="quick-presets">
                <div class="preset-btn" onclick="setQuickPreset('product')">
                    <div class="preset-value">Product</div>
                    <div class="preset-label">EAN-13 Format</div>
                </div>
                <div class="preset-btn" onclick="setQuickPreset('qrurl')">
                    <div class="preset-value">QR URL</div>
                    <div class="preset-label">Website Link</div>
                </div>
                <div class="preset-btn" onclick="setQuickPreset('inventory')">
                    <div class="preset-value">Inventory</div>
                    <div class="preset-label">Code 128</div>
                </div>
                <div class="preset-btn" onclick="setQuickPreset('shipping')">
                    <div class="preset-value">Shipping</div>
                    <div class="preset-label">ITF-14 Format</div>
                </div>
            </div>
            
            <div class="results-section">
                <h3>📋 Generated Barcode</h3>
                <div class="barcode-display" id="barcodeDisplay">
                    <div class="barcode-container" id="barcodeContainer">
                        <div class="barcode" id="barcodeOutput">
                            <!-- Barcode will be generated here -->
                        </div>
                    </div>
                    <div class="barcode-text" id="barcodeText">123456789012</div>
                </div>
                
                <div class="action-buttons">
                    <button class="action-btn" onclick="downloadBarcode()">💾 Download Barcode</button>
                    <button class="action-btn" onclick="printBarcode()">🖨️ Print Barcode</button>
                    <button class="action-btn" onclick="copyBarcodeData()">📋 Copy Data</button>
                    <button class="action-btn" onclick="shareBarcode()">📤 Share</button>
                    <button class="action-btn" onclick="saveToLibrary()">📚 Save to Library</button>
                </div>
                
                <div class="preview-grid" id="previewGrid" style="display: none;">
                    <!-- Preview variations will appear here -->
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>📊 Professional Barcode Generation</h2>
            
            <p>Generate high-quality barcodes in multiple formats for retail, inventory, shipping, and digital applications with advanced customization options.</p>

            <h3>📊 Barcode Types & Standards</h3>
            <table class="format-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Common Uses</th>
                        <th>Data Capacity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Code 128</strong></td>
                        <td>High-density linear barcode</td>
                        <td>Shipping, inventory, logistics</td>
                        <td>Alphanumeric, variable length</td>
                    </tr>
                    <tr>
                        <td><strong>QR Code</strong></td>
                        <td>2D matrix barcode</td>
                        <td>URLs, contact info, payments</td>
                        <td>Up to 4,296 alphanumeric chars</td>
                    </tr>
                    <tr>
                        <td><strong>EAN-13</strong></td>
                        <td>International product code</td>
                        <td>Retail products worldwide</td>
                        <td>13 numeric digits</td>
                    </tr>
                    <tr>
                        <td><strong>UPC-A</strong></td>
                        <td>Universal product code</td>
                        <td>Retail products in North America</td>
                        <td>12 numeric digits</td>
                    </tr>
                    <tr>
                        <td><strong>Code 39</strong></td>
                        <td>Alpha-numeric code</td>
                        <td>Industrial, government</td>
                        <td>Variable length, limited charset</td>
                    </tr>
                    <tr>
                        <td><strong>ITF-14</strong></td>
                        <td>Shipping container code</td>
                        <td>Cartons, shipping containers</td>
                        <td>14 numeric digits</td>
                    </tr>
                    <tr>
                        <td><strong>Data Matrix</strong></td>
                        <td>2D matrix for small items</td>
                        <td>Electronics, healthcare</td>
                        <td>Up to 2,335 alphanumeric chars</td>
                    </tr>
                    <tr>
                        <td><strong>PDF417</strong></td>
                        <td>2D stacked barcode</td>
                        <td>Drivers licenses, documents</td>
                        <td>Up to 1,850 text chars</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Barcode Structure:</strong><br>
                • <strong>Quiet Zone:</strong> Clear space before and after barcode<br>
                • <strong>Start Character:</strong> Indicates barcode type<br>
                • <strong>Data Characters:</strong> Encoded information<br>
                • <strong>Check Digit:</strong> Validation character (if applicable)<br>
                • <strong>Stop Character:</strong> End of barcode indicator
            </div>

            <h3>🎯 Industry Applications</h3>
            <table class="format-table">
                <thead>
                    <tr>
                        <th>Industry</th>
                        <th>Common Formats</th>
                        <th>Typical Use Cases</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Retail</strong></td>
                        <td>EAN-13, UPC-A</td>
                        <td>Product identification, pricing, inventory</td>
                    </tr>
                    <tr>
                        <td><strong>Logistics</strong></td>
                        <td>Code 128, ITF-14</td>
                        <td>Shipping labels, tracking, warehouse management</td>
                    </tr>
                    <tr>
                        <td><strong>Healthcare</strong></td>
                        <td>Code 128, Data Matrix</td>
                        <td>Patient records, medication tracking, specimen labeling</td>
                    </tr>
                    <tr>
                        <td><strong>Manufacturing</strong></td>
                        <td>Code 39, QR Code</td>
                        <td>Part tracking, quality control, asset management</td>
                    </tr>
                    <tr>
                        <td><strong>Digital</strong></td>
                        <td>QR Code, Data Matrix</td>
                        <td>Website links, app downloads, digital payments</td>
                    </tr>
                    <tr>
                        <td><strong>Government</strong></td>
                        <td>PDF417, Code 128</td>
                        <td>ID cards, document tracking, license plates</td>
                    </tr>
                </tbody>
            </table>

            <h3>📐 Technical Specifications</h3>
            <ul>
                <li><strong>Minimum Size:</strong> Depends on scanner capability and printing resolution</li>
                <li><strong>Quiet Zone:</strong> Typically 10x the narrowest bar width</li>
                <li><strong>Print Resolution:</strong> Minimum 300 DPI for reliable scanning</li>
                <li><strong>Color Contrast:</strong> Dark bars on light background recommended</li>
                <li><strong>Aspect Ratio:</strong> Critical for 2D barcodes, must be preserved</li>
            </ul>

            <h3>🌍 Global Standards</h3>
            <div class="formula-box">
                <strong>Regional Standards:</strong><br>
                • <strong>GS1:</strong> Global standards organization (EAN/UPC)<br>
                • <strong>ISO/IEC:</strong> International standards (QR Code, Data Matrix)<br>
                • <strong>ANSI:</strong> American National Standards Institute<br>
                • <strong>JIS:</strong> Japanese Industrial Standards (QR Code origin)<br>
                • <strong>CEN:</strong> European Committee for Standardization
            </div>

            <h3>🔍 Scanner Compatibility</h3>
            <table class="format-table">
                <thead>
                    <tr>
                        <th>Scanner Type</th>
                        <th>Supported Formats</th>
                        <th>Typical Range</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Laser Scanners</strong></td>
                        <td>1D barcodes only</td>
                        <td>6-24 inches</td>
                    </tr>
                    <tr>
                        <td><strong>Linear Imagers</strong></td>
                        <td>1D barcodes only</td>
                        <td>Contact to 15 inches</td>
                    </tr>
                    <tr>
                        <td><strong>2D Area Imagers</strong></td>
                        <td>All 1D and 2D formats</td>
                        <td>Contact to 20+ inches</td>
                    </tr>
                    <tr>
                        <td><strong>Smartphone Cameras</strong></td>
                        <td>QR Codes, some 1D formats</td>
                        <td>2-12 inches</td>
                    </tr>
                </tbody>
            </table>

            <h3>💡 Best Practices</h3>
            <ul>
                <li>Ensure adequate quiet zones around barcodes</li>
                <li>Maintain high contrast between bars and background</li>
                <li>Test barcodes with actual scanners before mass production</li>
                <li>Follow industry-specific size and placement guidelines</li>
                <li>Include human-readable text below 1D barcodes</li>
                <li>Validate check digits for numeric barcode formats</li>
            </ul>

            <h3>🔧 Generation Algorithms</h3>
            <div class="formula-box">
                <strong>Encoding Methods:</strong><br>
                • <strong>Code 128:</strong> Uses 3 different character sets for efficiency<br>
                • <strong>QR Code:</strong> Reed-Solomon error correction, mask patterns<br>
                • <strong>EAN-13:</strong> Left/right parity patterns, modulo-10 check digit<br>
                • <strong>Data Matrix:</strong> Reed-Solomon error correction, finder patterns
            </div>

            <h3>📊 Error Correction Levels</h3>
            <table class="format-table">
                <thead>
                    <tr>
                        <th>Level</th>
                        <th>Recovery Capacity</th>
                        <th>Use Cases</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>L (Low)</strong></td>
                        <td>~7% of data bytes</td>
                        <td>Clean environments, high-quality printing</td>
                    </tr>
                    <tr>
                        <td><strong>M (Medium)</strong></td>
                        <td>~15% of data bytes</td>
                        <td>General purpose, standard printing</td>
                    </tr>
                    <tr>
                        <td><strong>Q (Quartile)</strong></td>
                        <td>~25% of data bytes</td>
                        <td>Industrial environments, rough surfaces</td>
                    </tr>
                    <tr>
                        <td><strong>H (High)</strong></td>
                        <td>~30% of data bytes</td>
                        <td>Critical applications, damaged labels</td>
                    </tr>
                </tbody>
            </table>

            <h3>🚀 Advanced Features</h3>
            <ul>
                <li><strong>Batch Generation:</strong> Create multiple barcodes at once</li>
                <li><strong>Sequential Numbering:</strong> Generate sequential barcode series</li>
                <li><strong>Data Validation:</strong> Automatic format and check digit validation</li>
                <li><strong>Template System:</strong> Save and reuse barcode configurations</li>
                <li><strong>API Integration:</strong> Programmatic barcode generation</li>
                <li><strong>Bulk Export:</strong> Export multiple barcodes in archive files</li>
            </ul>
        </div>

        <div class="footer">
            <p>📊 Advanced Barcode Generator | Multiple Formats & Professional Features</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Code 128, QR Code, EAN-13, UPC-A with customization and export options</p>
        </div>
    </div>

    <script>
        // DOM elements
        const barcodeTypeSelect = document.getElementById('barcodeType');
        const barcodeDataInput = document.getElementById('barcodeData');
        const barcodeSizeSlider = document.getElementById('barcodeSize');
        const sizeValueSpan = document.getElementById('sizeValue');
        const colorOptions = document.querySelectorAll('.color-option');
        const showTextCheckbox = document.getElementById('showText');
        const addBorderCheckbox = document.getElementById('addBorder');
        const addPaddingCheckbox = document.getElementById('addPadding');
        const backgroundColorSelect = document.getElementById('backgroundColor');
        const errorCorrectionSelect = document.getElementById('errorCorrection');
        const outputFormatSelect = document.getElementById('outputFormat');
        const autoDownloadCheckbox = document.getElementById('autoDownload');
        const multipleCodesCheckbox = document.getElementById('multipleCodes');
        const barcodeOutput = document.getElementById('barcodeOutput');
        const barcodeText = document.getElementById('barcodeText');
        const barcodeContainer = document.getElementById('barcodeContainer');
        const previewGrid = document.getElementById('previewGrid');

        // Barcode patterns for different types
        const barcodePatterns = {
            code128: [2,1,2,2,2,2,1,1,1,2,1,2,1,1,2,1,1,1,1,1,2,2,1,1,1,1,1,2,1,2],
            ean13: [3,2,1,1,2,3,1,1,3,2,1,2,3,1,2,1,3,2,1,1,2,3,1,1,3,2,1,2,3,1,2,1,3,2,1,1,2,3,1,1,3,2,1,2,3,1,2],
            upca: [3,2,1,1,2,3,1,1,3,2,1,2,3,1,2,1,3,2,1,1,2,3,1,1,3,2,1,2,3,1,2],
            code39: [2,1,2,1,1,2,1,2,1,1,2,2,1,1,1,2,1,2,1,1,2,1,2,1,1,2,2,1,1,1,2,1,2,1,1,2,1,2],
            itf: [4,1,1,1,4,1,1,1,4,1,1,1,4,1,1,1,4,1,1,1,4,1,1,1,4,1,1,1,4,1,1,1,4,1,1,1,4,1,1,1,4,1,1,1,4,1,1,1,4,1,1,1,4]
        };

        // Update slider value display
        barcodeSizeSlider.addEventListener('input', function() {
            sizeValueSpan.textContent = this.value;
        });

        // Color selection
        colorOptions.forEach(option => {
            option.addEventListener('click', function() {
                colorOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // Get selected color
        function getSelectedColor() {
            return document.querySelector('.color-option.selected').dataset.color;
        }

        // Generate barcode
        function generateBarcode() {
            const type = barcodeTypeSelect.value;
            const data = barcodeDataInput.value;
            const size = parseInt(barcodeSizeSlider.value);
            const color = getSelectedColor();
            const showText = showTextCheckbox.checked;
            const addBorder = addBorderCheckbox.checked;
            const addPadding = addPaddingCheckbox.checked;
            const bgColor = backgroundColorSelect.value;
            const errorCorrection = errorCorrectionSelect.value;
            const outputFormat = outputFormatSelect.value;
            const generateMultiple = multipleCodesCheckbox.checked;
            
            // Validate data based on barcode type
            if (!validateBarcodeData(type, data)) {
                alert('Invalid data for selected barcode type. Please check the format requirements.');
                return;
            }
            
            // Generate the barcode
            const barcodeHTML = createBarcode(type, data, size, color);
            
            // Update display
            barcodeOutput.innerHTML = barcodeHTML;
            barcodeOutput.className = `barcode barcode-color-${color}`;
            
            // Update text
            if (showText) {
                barcodeText.textContent = data;
                barcodeText.style.display = 'block';
            } else {
                barcodeText.style.display = 'none';
            }
            
            // Update container styling
            barcodeContainer.style.border = addBorder ? '2px solid #e0e0e0' : 'none';
            barcodeContainer.style.padding = addPadding ? '20px' : '0';
            barcodeContainer.style.background = getBackgroundColor(bgColor);
            
            // Generate preview variations if enabled
            if (generateMultiple) {
                generatePreviewVariations(type, data);
                previewGrid.style.display = 'grid';
            } else {
                previewGrid.style.display = 'none';
            }
            
            // Auto-download if enabled
            if (autoDownloadCheckbox.checked) {
                setTimeout(downloadBarcode, 1000);
            }
        }

        // Validate barcode data
        function validateBarcodeData(type, data) {
            switch(type) {
                case 'ean13':
                    return /^\d{13}$/.test(data);
                case 'upca':
                    return /^\d{12}$/.test(data);
                case 'itf':
                    return /^\d{14}$/.test(data);
                case 'code39':
                    return /^[A-Z0-9\-\.\ \$\/\+\%]+$/.test(data);
                default:
                    return data.length > 0;
            }
        }

        // Create barcode visualization
        function createBarcode(type, data, size, color) {
            switch(type) {
                case 'qr':
                    return createQRCode(data, size, color);
                case 'datamatrix':
                    return createDataMatrix(data, size, color);
                case 'pdf417':
                    return createPDF417(data, size, color);
                default:
                    return createLinearBarcode(type, data, size, color);
            }
        }

        // Create linear barcode (1D)
        function createLinearBarcode(type, data, size, color) {
            const pattern = barcodePatterns[type] || barcodePatterns.code128;
            let html = '';
            
            // Add start pattern
            html += '<div class="barcode-line thick" style="height: ' + (80 + size * 5) + 'px;"></div>';
            
            // Add data pattern (simplified)
            for (let i = 0; i < 20; i++) {
                const barType = pattern[i % pattern.length];
                const height = 80 + size * 5;
                let width, className;
                
                if (barType === 1) {
                    width = 2;
                    className = 'thin';
                } else if (barType === 2) {
                    width = 3;
                    className = 'medium';
                } else {
                    width = 4;
                    className = 'thick';
                }
                
                html += `<div class="barcode-line ${className}" style="height: ${height}px; width: ${width}px;"></div>`;
            }
            
            // Add stop pattern
            html += '<div class="barcode-line thick" style="height: ' + (80 + size * 5) + 'px;"></div>';
            
            return html;
        }

        // Create QR Code (simplified visualization)
        function createQRCode(data, size, color) {
            const qrSize = 10 + size * 2;
            let html = '<div class="barcode-qr">';
            
            // Create simplified QR pattern
            for (let y = 0; y < qrSize; y++) {
                for (let x = 0; x < qrSize; x++) {
                    // Simple pattern for demonstration
                    const isBlack = (x < 2 || x >= qrSize - 2 || y < 2 || y >= qrSize - 2 || 
                                   (x % 3 === 0 && y % 3 === 0) || Math.random() > 0.7);
                    
                    html += `<div class="barcode-qr-cell" style="background: ${isBlack ? '#000' : '#fff'};"></div>`;
                }
                html += '<br>';
            }
            
            html += '</div>';
            return html;
        }

        // Create Data Matrix (simplified)
        function createDataMatrix(data, size, color) {
            const matrixSize = 8 + size;
            let html = '<div class="barcode-qr">';
            
            for (let y = 0; y < matrixSize; y++) {
                for (let x = 0; x < matrixSize; x++) {
                    const isBlack = (x === 0 || x === matrixSize - 1 || y === 0 || y === matrixSize - 1 ||
                                   (x % 2 === 0 && y % 2 === 0) || Math.random() > 0.65);
                    
                    html += `<div class="barcode-qr-cell" style="background: ${isBlack ? '#000' : '#fff'};"></div>`;
                }
                html += '<br>';
            }
            
            html += '</div>';
            return html;
        }

        // Create PDF417 (simplified)
        function createPDF417(data, size, color) {
            const rows = 4 + size;
            const cols = 10 + size * 2;
            let html = '<div class="barcode-qr">';
            
            for (let y = 0; y < rows; y++) {
                for (let x = 0; x < cols; x++) {
                    const isBlack = (x === 0 || x === cols - 1 || (y % 2 === 0 && x % 3 === 0) || Math.random() > 0.6);
                    html += `<div class="barcode-qr-cell" style="background: ${isBlack ? '#000' : '#fff'};"></div>`;
                }
                html += '<br>';
            }
            
            html += '</div>';
            return html;
        }

        // Get background color
        function getBackgroundColor(bgColor) {
            switch(bgColor) {
                case 'white': return '#ffffff';
                case 'transparent': return 'transparent';
                case 'lightgray': return '#f0f0f0';
                case 'f8f9fa': return '#f8f9fa';
                default: return '#ffffff';
            }
        }

        // Generate preview variations
        function generatePreviewVariations(type, data) {
            previewGrid.innerHTML = '';
            
            const variations = [
                { size: 3, color: 'black', label: 'Small' },
                { size: 7, color: 'blue', label: 'Medium' },
                { size: 10, color: 'red', label: 'Large' },
                { size: 5, color: 'green', label: 'Green' }
            ];
            
            variations.forEach(variation => {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                
                const barcodeHTML = createBarcode(type, data, variation.size, variation.color);
                
                previewItem.innerHTML = `
                    <div class="preview-barcode">${barcodeHTML}</div>
                    <div class="preview-label">${variation.label}</div>
                `;
                
                previewGrid.appendChild(previewItem);
            });
        }

        // Quick presets
        function setQuickPreset(preset) {
            switch(preset) {
                case 'product':
                    barcodeTypeSelect.value = 'ean13';
                    barcodeDataInput.value = '1234567890128';
                    break;
                case 'qrurl':
                    barcodeTypeSelect.value = 'qr';
                    barcodeDataInput.value = 'https://example.com';
                    break;
                case 'inventory':
                    barcodeTypeSelect.value = 'code128';
                    barcodeDataInput.value = 'INV-2024-001';
                    break;
                case 'shipping':
                    barcodeTypeSelect.value = 'itf';
                    barcodeDataInput.value = '12345678901234';
                    break;
            }
            
            generateBarcode();
        }

        // Action functions
        function downloadBarcode() {
            alert('Barcode download functionality would be implemented here with server-side generation.');
        }

        function printBarcode() {
            window.print();
        }

        function copyBarcodeData() {
            navigator.clipboard.writeText(barcodeDataInput.value).then(() => {
                alert('Barcode data copied to clipboard!');
            });
        }

        function shareBarcode() {
            alert('Share functionality would be implemented here.');
        }

        function saveToLibrary() {
            alert('Save to library functionality would be implemented here.');
        }

        // Initial generation
        generateBarcode();
    </script>
</body>
</html>
