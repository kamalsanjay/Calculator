<?php
/**
 * GB to TB Converter
 * File: conversion/gb-to-tb-converter.php
 * Description: Convert gigabytes to terabytes and vice versa
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GB to TB Converter - Gigabytes to Terabytes Calculator</title>
    <meta name="description" content="Convert gigabytes (GB) to terabytes (TB) and TB to GB instantly. Bidirectional storage converter with decimal and binary standards.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 950px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .standard-selector { display: flex; gap: 10px; margin-bottom: 25px; padding: 15px; background: #f8f9fa; border-radius: 10px; }
        .standard-btn { flex: 1; padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; font-weight: 600; }
        .standard-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-color: #764ba2; }
        .standard-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(118, 75, 162, 0.2); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 70px 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .unit-label { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #667eea; font-weight: 600; font-size: 0.95rem; }
        
        .swap-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-box { background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%); padding: 25px; border-radius: 12px; border-left: 5px solid #667eea; margin-bottom: 25px; }
        .result-label { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 8px; }
        .result-value { font-size: 2.5rem; font-weight: bold; color: #667eea; margin-bottom: 10px; }
        .result-formula { background: white; padding: 15px; border-radius: 8px; font-family: 'Courier New', monospace; color: #555; font-size: 0.9rem; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #667eea; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15); }
        .quick-value { font-weight: bold; color: #667eea; font-size: 1.1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .converter-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .header h1 { font-size: 1.5rem; }
            .result-value { font-size: 2rem; }
            .standard-selector { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💾 GB ⇄ TB Converter</h1>
            <p>Convert between gigabytes and terabytes with decimal (SI) and binary (IEC) standards</p>
        </div>

        <div class="converter-card">
            <div class="standard-selector">
                <button class="standard-btn active" onclick="selectStandard('decimal', this)">
                    Decimal (SI)<br><span style="font-size: 0.8rem; font-weight: 400;">Base 1000 - GB, TB</span>
                </button>
                <button class="standard-btn" onclick="selectStandard('binary', this)">
                    Binary (IEC)<br><span style="font-size: 0.8rem; font-weight: 400;">Base 1024 - GiB, TiB</span>
                </button>
            </div>

            <div class="converter-row">
                <div class="input-group">
                    <label for="gbInput">Gigabytes</label>
                    <div class="input-wrapper">
                        <input type="number" id="gbInput" placeholder="Enter GB" step="0.001" min="0" value="1000">
                        <span class="unit-label">GB</span>
                    </div>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="tbInput">Terabytes</label>
                    <div class="input-wrapper">
                        <input type="number" id="tbInput" placeholder="Enter TB" step="0.001" min="0">
                        <span class="unit-label">TB</span>
                    </div>
                </div>
            </div>

            <div class="result-box">
                <div class="result-label">Result</div>
                <div class="result-value" id="resultValue">1000 GB = 1 TB</div>
                <div class="result-formula" id="resultFormula">1000 GB ÷ 1000 = 1 TB (Decimal)</div>
            </div>

            <div class="quick-convert">
                <h3>⚡ Common Storage Sizes</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setGB(128)">
                        <div class="quick-value">128 GB</div>
                        <div class="quick-label">Phone Storage</div>
                    </div>
                    <div class="quick-btn" onclick="setGB(256)">
                        <div class="quick-value">256 GB</div>
                        <div class="quick-label">SSD Small</div>
                    </div>
                    <div class="quick-btn" onclick="setGB(512)">
                        <div class="quick-value">512 GB</div>
                        <div class="quick-label">SSD Medium</div>
                    </div>
                    <div class="quick-btn" onclick="setGB(1000)">
                        <div class="quick-value">1000 GB</div>
                        <div class="quick-label">1 TB</div>
                    </div>
                    <div class="quick-btn" onclick="setGB(2000)">
                        <div class="quick-value">2000 GB</div>
                        <div class="quick-label">2 TB</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>💾 GB to TB Conversion Guide</h2>
            
            <p><strong>Gigabytes (GB)</strong> and <strong>Terabytes (TB)</strong> are units of digital storage. There are two standards: Decimal (SI) used by manufacturers, and Binary (IEC) used by operating systems.</p>

            <h3>📊 Decimal (SI) vs Binary (IEC)</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Standard</th>
                        <th>Conversion</th>
                        <th>Used By</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Decimal (SI)</strong></td>
                        <td>1 TB = 1,000 GB</td>
                        <td>Hard drive manufacturers, marketing</td>
                    </tr>
                    <tr>
                        <td><strong>Binary (IEC)</strong></td>
                        <td>1 TiB = 1,024 GiB</td>
                        <td>Operating systems (Windows, macOS)</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Conversion Formulas:</strong><br>
                <strong>Decimal (SI):</strong><br>
                • GB to TB: TB = GB ÷ 1,000<br>
                • TB to GB: GB = TB × 1,000<br><br>
                <strong>Binary (IEC):</strong><br>
                • GiB to TiB: TiB = GiB ÷ 1,024<br>
                • TiB to GiB: GiB = TiB × 1,024
            </div>

            <h3>📏 GB to TB Conversion Chart</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Gigabytes (GB)</th>
                        <th>Terabytes (TB) - Decimal</th>
                        <th>Tebibytes (TiB) - Binary</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>100 GB</td><td>0.1 TB</td><td>0.091 TiB</td></tr>
                    <tr><td>250 GB</td><td>0.25 TB</td><td>0.227 TiB</td></tr>
                    <tr><td>500 GB</td><td>0.5 TB</td><td>0.455 TiB</td></tr>
                    <tr><td>1,000 GB (1 TB)</td><td>1 TB</td><td>0.909 TiB</td></tr>
                    <tr><td>2,000 GB (2 TB)</td><td>2 TB</td><td>1.819 TiB</td></tr>
                    <tr><td>4,000 GB (4 TB)</td><td>4 TB</td><td>3.638 TiB</td></tr>
                    <tr><td>8,000 GB (8 TB)</td><td>8 TB</td><td>7.276 TiB</td></tr>
                    <tr><td>16,000 GB (16 TB)</td><td>16 TB</td><td>14.552 TiB</td></tr>
                </tbody>
            </table>

            <h3>💻 Storage Device Capacities</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Device</th>
                        <th>Typical Size (GB)</th>
                        <th>Typical Size (TB)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Smartphone</td><td>64-512 GB</td><td>0.064-0.512 TB</td></tr>
                    <tr><td>USB Flash Drive</td><td>16-256 GB</td><td>0.016-0.256 TB</td></tr>
                    <tr><td>SD Card</td><td>32-1024 GB</td><td>0.032-1 TB</td></tr>
                    <tr><td>SSD (Laptop)</td><td>256-2000 GB</td><td>0.256-2 TB</td></tr>
                    <tr><td>SSD (Desktop)</td><td>500-4000 GB</td><td>0.5-4 TB</td></tr>
                    <tr><td>HDD (Desktop)</td><td>1000-18000 GB</td><td>1-18 TB</td></tr>
                    <tr><td>External HDD</td><td>1000-18000 GB</td><td>1-18 TB</td></tr>
                    <tr><td>NAS Drive</td><td>4000-100000+ GB</td><td>4-100+ TB</td></tr>
                </tbody>
            </table>

            <h3>🎮 Gaming & Media Storage</h3>
            <ul>
                <li><strong>AAA game (modern):</strong> 50-150 GB (0.05-0.15 TB)</li>
                <li><strong>4K movie (2 hours):</strong> 50-100 GB (0.05-0.1 TB)</li>
                <li><strong>HD movie (2 hours):</strong> 4-8 GB (0.004-0.008 TB)</li>
                <li><strong>Music album (FLAC):</strong> 200-500 MB (0.0002-0.0005 TB)</li>
                <li><strong>1 hour 4K video:</strong> 25-50 GB (0.025-0.05 TB)</li>
                <li><strong>PS5 game storage:</strong> Typically 50-100 GB each</li>
            </ul>

            <h3>📱 Phone & Tablet Storage</h3>
            <div class="formula-box">
                <strong>Common Capacities:</strong><br>
                • 64 GB = 0.064 TB<br>
                • 128 GB = 0.128 TB<br>
                • 256 GB = 0.256 TB<br>
                • 512 GB = 0.512 TB<br>
                • 1 TB (1024 GB) = 1 TB<br><br>
                <strong>Note:</strong> Formatted capacity is usually 5-10% less
            </div>

            <h3>💾 Hard Drive Capacities</h3>
            <ul>
                <li><strong>500 GB HDD:</strong> 0.5 TB (shows as ~465 GB in Windows)</li>
                <li><strong>1 TB HDD:</strong> 1 TB (shows as ~931 GB in Windows)</li>
                <li><strong>2 TB HDD:</strong> 2 TB (shows as ~1.81 TB in Windows)</li>
                <li><strong>4 TB HDD:</strong> 4 TB (shows as ~3.63 TB in Windows)</li>
                <li><strong>8 TB HDD:</strong> 8 TB (shows as ~7.27 TB in Windows)</li>
                <li><strong>16 TB HDD:</strong> 16 TB (shows as ~14.55 TB in Windows)</li>
            </ul>

            <h3>🖥️ SSD Storage Options</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>SSD Size</th>
                        <th>GB</th>
                        <th>TB</th>
                        <th>Best For</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>128 GB SSD</td><td>128 GB</td><td>0.128 TB</td><td>OS only</td></tr>
                    <tr><td>256 GB SSD</td><td>256 GB</td><td>0.256 TB</td><td>OS + basic apps</td></tr>
                    <tr><td>512 GB SSD</td><td>512 GB</td><td>0.512 TB</td><td>General use</td></tr>
                    <tr><td>1 TB SSD</td><td>1000 GB</td><td>1 TB</td><td>Gaming/productivity</td></tr>
                    <tr><td>2 TB SSD</td><td>2000 GB</td><td>2 TB</td><td>Content creation</td></tr>
                    <tr><td>4 TB SSD</td><td>4000 GB</td><td>4 TB</td><td>Professional work</td></tr>
                </tbody>
            </table>

            <h3>☁️ Cloud Storage Plans</h3>
            <ul>
                <li><strong>Google Drive free:</strong> 15 GB (0.015 TB)</li>
                <li><strong>iCloud free:</strong> 5 GB (0.005 TB)</li>
                <li><strong>Dropbox free:</strong> 2 GB (0.002 TB)</li>
                <li><strong>Cloud paid plans:</strong> Usually 100 GB, 200 GB, 2 TB, 5 TB</li>
            </ul>

            <h3>🎬 Video Production Storage</h3>
            <div class="formula-box">
                <strong>Raw Footage Storage Needs:</strong><br>
                • 1 hour 1080p (100 Mbps): ~45 GB<br>
                • 1 hour 4K (400 Mbps): ~180 GB (0.18 TB)<br>
                • 1 hour 8K (800 Mbps): ~360 GB (0.36 TB)<br>
                • Professional 4K RAW: 1-2 TB per hour<br><br>
                <strong>Edited Projects:</strong><br>
                • Feature film project: 5-20 TB<br>
                • YouTube video project: 50-200 GB
            </div>

            <h3>💡 Why Your Drive Shows Less</h3>
            <ul>
                <li><strong>1 TB drive shows 931 GB:</strong> Decimal vs binary difference (~7%)</li>
                <li><strong>Manufacturer uses:</strong> 1 TB = 1,000 GB (decimal)</li>
                <li><strong>Windows shows:</strong> 1 TB = 1,024 GiB (binary)</li>
                <li><strong>1,000 GB ÷ 1.024:</strong> = ~977 GiB ≈ 931 GB (in Windows)</li>
                <li><strong>Your drive is full capacity:</strong> Just measured differently!</li>
            </ul>

            <h3>📊 Data Center Storage</h3>
            <ul>
                <li><strong>Enterprise HDD:</strong> 10-20 TB typical</li>
                <li><strong>Server rack:</strong> 100-500 TB common</li>
                <li><strong>Data center:</strong> Petabytes (1 PB = 1,000 TB)</li>
                <li><strong>Google/Facebook:</strong> Exabytes (1 EB = 1,000 PB)</li>
            </ul>

            <h3>🎯 Quick Mental Conversion</h3>
            <div class="formula-box">
                <strong>Simple Method:</strong><br>
                • Divide GB by 1,000 for TB (decimal)<br>
                • Example: 5,000 GB ÷ 1,000 = 5 TB<br><br>
                <strong>For binary (more accurate):</strong><br>
                • Divide GB by 1,024 for TiB<br>
                • Example: 5,000 GB ÷ 1,024 = 4.88 TiB
            </div>

            <h3>💻 Operating System Differences</h3>
            <ul>
                <li><strong>Windows:</strong> Shows GiB/TiB but labels as GB/TB</li>
                <li><strong>macOS:</strong> Shows true GB/TB (decimal) since Snow Leopard</li>
                <li><strong>Linux:</strong> Varies by distribution, usually binary</li>
                <li><strong>Android/iOS:</strong> Usually shows decimal GB</li>
            </ul>

            <h3>📐 Storage Hierarchy</h3>
            <div class="formula-box">
                <strong>Decimal (SI):</strong><br>
                1 KB = 1,000 Bytes<br>
                1 MB = 1,000 KB<br>
                1 GB = 1,000 MB<br>
                1 TB = 1,000 GB<br>
                1 PB = 1,000 TB<br><br>
                <strong>Binary (IEC):</strong><br>
                1 KiB = 1,024 Bytes<br>
                1 MiB = 1,024 KiB<br>
                1 GiB = 1,024 MiB<br>
                1 TiB = 1,024 GiB<br>
                1 PiB = 1,024 TiB
            </div>

            <h3>🔧 Practical Tips</h3>
            <ul>
                <li><strong>Buying storage:</strong> Manufacturer specs use decimal GB/TB</li>
                <li><strong>OS shows less:</strong> Due to binary calculation + formatting</li>
                <li><strong>Buffer space:</strong> Keep 10-20% free for best performance</li>
                <li><strong>SSD vs HDD:</strong> SSD faster but more expensive per TB</li>
                <li><strong>Backup strategy:</strong> 3-2-1 rule (3 copies, 2 media types, 1 offsite)</li>
            </ul>

            <h3>💾 Storage Cost Comparison (2025)</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Storage Type</th>
                        <th>Typical Cost per TB</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>HDD (Consumer)</td><td>$15-25 per TB</td></tr>
                    <tr><td>HDD (Enterprise)</td><td>$20-40 per TB</td></tr>
                    <tr><td>SATA SSD</td><td>$50-80 per TB</td></tr>
                    <tr><td>NVMe SSD</td><td>$70-120 per TB</td></tr>
                    <tr><td>Cloud Storage</td><td>$2-10 per TB/month</td></tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>💾 Accurate GB ⇄ TB Conversion | Bidirectional Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for understanding storage devices, planning purchases, and data management</p>
        </div>
    </div>

    <script>
        let currentStandard = 'decimal';
        
        function selectStandard(standard, btn) {
            currentStandard = standard;
            document.querySelectorAll('.standard-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            convertGB();
        }

        function convertGB() {
            const gb = parseFloat(document.getElementById('gbInput').value);
            
            if (isNaN(gb) || gb < 0) {
                return;
            }

            const divisor = currentStandard === 'decimal' ? 1000 : 1024;
            const tb = gb / divisor;
            
            document.getElementById('tbInput').value = tb.toFixed(6);
            
            const standardName = currentStandard === 'decimal' ? 'Decimal (SI)' : 'Binary (IEC)';
            const gbUnit = currentStandard === 'decimal' ? 'GB' : 'GiB';
            const tbUnit = currentStandard === 'decimal' ? 'TB' : 'TiB';
            
            document.getElementById('resultValue').textContent = 
                `${gb.toFixed(3)} ${gbUnit} = ${tb.toFixed(6)} ${tbUnit}`;
            
            document.getElementById('resultFormula').textContent = 
                `${gb.toFixed(3)} ${gbUnit} ÷ ${divisor} = ${tb.toFixed(6)} ${tbUnit} (${standardName})`;
        }

        function convertTB() {
            const tb = parseFloat(document.getElementById('tbInput').value);
            
            if (isNaN(tb) || tb < 0) {
                return;
            }

            const multiplier = currentStandard === 'decimal' ? 1000 : 1024;
            const gb = tb * multiplier;
            
            document.getElementById('gbInput').value = gb.toFixed(3);
            
            const standardName = currentStandard === 'decimal' ? 'Decimal (SI)' : 'Binary (IEC)';
            const gbUnit = currentStandard === 'decimal' ? 'GB' : 'GiB';
            const tbUnit = currentStandard === 'decimal' ? 'TB' : 'TiB';
            
            document.getElementById('resultValue').textContent = 
                `${tb.toFixed(6)} ${tbUnit} = ${gb.toFixed(3)} ${gbUnit}`;
            
            document.getElementById('resultFormula').textContent = 
                `${tb.toFixed(6)} ${tbUnit} × ${multiplier} = ${gb.toFixed(3)} ${gbUnit} (${standardName})`;
        }

        function swapUnits() {
            const gbValue = document.getElementById('gbInput').value;
            const tbValue = document.getElementById('tbInput').value;
            
            document.getElementById('gbInput').value = tbValue;
            document.getElementById('tbInput').value = gbValue;
            
            if (gbValue) convertGB();
        }

        function setGB(value) {
            document.getElementById('gbInput').value = value;
            convertGB();
        }

        // Auto-convert on input
        document.getElementById('gbInput').addEventListener('input', convertGB);
        document.getElementById('tbInput').addEventListener('input', convertTB);

        // Initial conversion
        convertGB();
    </script>
</body>
</html>