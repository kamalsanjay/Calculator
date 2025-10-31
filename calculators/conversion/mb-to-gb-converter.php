<?php
/**
 * MB to GB Converter
 * File: conversion/mb-to-gb-converter.php
 * Description: Convert between all data storage units (bytes to terabytes)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MB to GB Converter - Data Storage Unit Calculator</title>
    <meta name="description" content="Convert between MB, GB, TB, KB and all data storage units. Universal digital storage converter.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { position: relative; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #8E2DE2; box-shadow: 0 0 0 3px rgba(142, 45, 226, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; margin-top: 10px; }
        .unit-select:focus { outline: none; border-color: #8E2DE2; box-shadow: 0 0 0 3px rgba(142, 45, 226, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #f3e7f9 0%, #e1d4f3 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #8E2DE2; }
        .result-unit { color: #5e35b1; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #6a1b9a; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #8E2DE2; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(142, 45, 226, 0.15); }
        .quick-value { font-weight: bold; color: #8E2DE2; font-size: 1rem; }
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
        .conversion-table tr:hover { background: #f3e7f9; }
        
        .formula-box { background: #f3e7f9; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #8E2DE2; }
        .formula-box strong { color: #8E2DE2; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .converter-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .result-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💾 Data Storage Converter</h1>
            <p>Convert between MB, GB, TB, KB and all digital storage units</p>
        </div>

        <div class="converter-card">
            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1024">
                    </div>
                    <select id="fromUnit" class="unit-select">
                        <option value="B">Byte (B)</option>
                        <option value="KB">Kilobyte (KB)</option>
                        <option value="MB" selected>Megabyte (MB)</option>
                        <option value="GB">Gigabyte (GB)</option>
                        <option value="TB">Terabyte (TB)</option>
                        <option value="PB">Petabyte (PB)</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="B">Byte (B)</option>
                        <option value="KB">Kilobyte (KB)</option>
                        <option value="MB">Megabyte (MB)</option>
                        <option value="GB" selected>Gigabyte (GB)</option>
                        <option value="TB">Terabyte (TB)</option>
                        <option value="PB">Petabyte (PB)</option>
                    </select>
                    <div class="input-wrapper" style="margin-top: 10px;">
                        <input type="text" id="outputValue" placeholder="Result" readonly style="background: #f8f9fa; font-weight: 600; color: #2c3e50;">
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid"></div>

            <div class="quick-convert">
                <h3>💾 Common Sizes</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setInput(1)">
                        <div class="quick-value">1</div>
                        <div class="quick-label">Unit</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(512)">
                        <div class="quick-value">512</div>
                        <div class="quick-label">Common</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(1024)">
                        <div class="quick-value">1024</div>
                        <div class="quick-label">1 Higher Unit</div>
                    </div>
                    <div class="quick-btn" onclick="setInput(2048)">
                        <div class="quick-value">2048</div>
                        <div class="quick-label">2 Higher Units</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>💾 Data Storage Conversion</h2>
            
            <p>Understanding data storage units is essential for managing files, storage devices, and internet data usage.</p>

            <div class="formula-box">
                <strong>Binary System (Powers of 1024):</strong><br>
                • 1 Kilobyte (KB) = 1,024 Bytes<br>
                • 1 Megabyte (MB) = 1,024 KB = 1,048,576 Bytes<br>
                • 1 Gigabyte (GB) = 1,024 MB = 1,073,741,824 Bytes<br>
                • 1 Terabyte (TB) = 1,024 GB<br>
                • 1 Petabyte (PB) = 1,024 TB<br><br>
                <strong>Note:</strong> Computers use binary (base-2) system, so 1 KB = 1,024 bytes, not 1,000
            </div>

            <h3>📊 Storage Unit Hierarchy</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Symbol</th>
                        <th>Bytes</th>
                        <th>Previous Unit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Byte</td><td>B</td><td>1</td><td>8 bits</td></tr>
                    <tr><td>Kilobyte</td><td>KB</td><td>1,024</td><td>1,024 B</td></tr>
                    <tr><td>Megabyte</td><td>MB</td><td>1,048,576</td><td>1,024 KB</td></tr>
                    <tr><td>Gigabyte</td><td>GB</td><td>1,073,741,824</td><td>1,024 MB</td></tr>
                    <tr><td>Terabyte</td><td>TB</td><td>1,099,511,627,776</td><td>1,024 GB</td></tr>
                    <tr><td>Petabyte</td><td>PB</td><td>1,125,899,906,842,624</td><td>1,024 TB</td></tr>
                </tbody>
            </table>

            <h3>📱 File Sizes</h3>
            <ul>
                <li><strong>Text document:</strong> 50-500 KB</li>
                <li><strong>Photo (compressed):</strong> 1-5 MB</li>
                <li><strong>Photo (RAW):</strong> 20-50 MB</li>
                <li><strong>MP3 song:</strong> 3-10 MB (3-5 minutes)</li>
                <li><strong>HD video (1 minute):</strong> 100-200 MB</li>
                <li><strong>4K video (1 minute):</strong> 300-500 MB</li>
                <li><strong>HD movie:</strong> 4-8 GB</li>
                <li><strong>4K movie:</strong> 15-30 GB</li>
            </ul>

            <h3>💿 Storage Devices</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Device</th>
                        <th>Typical Capacity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>CD</td><td>700 MB</td></tr>
                    <tr><td>DVD</td><td>4.7 GB (single layer)</td></tr>
                    <tr><td>Blu-ray</td><td>25-50 GB</td></tr>
                    <tr><td>USB Flash Drive</td><td>8-256 GB</td></tr>
                    <tr><td>SSD (laptop)</td><td>256 GB - 2 TB</td></tr>
                    <tr><td>HDD (desktop)</td><td>500 GB - 8 TB</td></tr>
                    <tr><td>External HDD</td><td>1-16 TB</td></tr>
                    <tr><td>Enterprise Server</td><td>10-100+ TB</td></tr>
                </tbody>
            </table>

            <h3>📲 Mobile & Computer Storage</h3>
            <div class="formula-box">
                <strong>Smartphones:</strong><br>
                • Budget: 32-64 GB<br>
                • Mid-range: 128-256 GB<br>
                • Premium: 256 GB - 1 TB<br><br>
                <strong>Computers:</strong><br>
                • Budget laptop: 128-256 GB SSD<br>
                • Standard laptop: 512 GB - 1 TB<br>
                • High-end laptop: 1-2 TB<br>
                • Desktop PC: 1-4 TB HDD + SSD
            </div>

            <h3>🌐 Internet Data Usage</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Data Used</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Email (text only)</td><td>10-50 KB</td></tr>
                    <tr><td>Web page</td><td>1-5 MB</td></tr>
                    <tr><td>Social media scroll (10 min)</td><td>50-100 MB</td></tr>
                    <tr><td>Music streaming (1 hour)</td><td>50-150 MB</td></tr>
                    <tr><td>SD video (1 hour)</td><td>500 MB - 1 GB</td></tr>
                    <tr><td>HD video (1 hour)</td><td>2-3 GB</td></tr>
                    <tr><td>4K video (1 hour)</td><td>7-10 GB</td></tr>
                    <tr><td>Video call (1 hour)</td><td>500 MB - 1.5 GB</td></tr>
                </tbody>
            </table>

            <h3>🎮 Gaming</h3>
            <ul>
                <li><strong>Mobile game:</strong> 50 MB - 5 GB</li>
                <li><strong>Indie PC game:</strong> 1-10 GB</li>
                <li><strong>AA game:</strong> 20-50 GB</li>
                <li><strong>AAA game:</strong> 50-150 GB</li>
                <li><strong>Online gaming (1 hour):</strong> 40-100 MB</li>
            </ul>

            <h3>📷 Photography & Video</h3>
            <div class="formula-box">
                <strong>Photo Storage:</strong><br>
                • JPEG (high quality): 3-5 MB<br>
                • JPEG (max quality): 8-12 MB<br>
                • RAW file: 25-50 MB<br>
                • 1,000 photos: ~15-20 GB<br><br>
                <strong>Video Storage:</strong><br>
                • 1080p (30fps): ~130 MB/min<br>
                • 1080p (60fps): ~200 MB/min<br>
                • 4K (30fps): ~400 MB/min<br>
                • 4K (60fps): ~650 MB/min
            </div>

            <h3>💻 Operating Systems</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>OS</th>
                        <th>Installation Size</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Windows 11</td><td>20-30 GB</td></tr>
                    <tr><td>macOS</td><td>12-15 GB</td></tr>
                    <tr><td>Linux (Ubuntu)</td><td>5-10 GB</td></tr>
                    <tr><td>Android</td><td>8-12 GB</td></tr>
                    <tr><td>iOS</td><td>3-5 GB</td></tr>
                </tbody>
            </table>

            <h3>☁️ Cloud Storage Plans</h3>
            <ul>
                <li><strong>Free tier:</strong> 5-15 GB (Google Drive, Dropbox, iCloud)</li>
                <li><strong>Basic plan:</strong> 50-100 GB</li>
                <li><strong>Standard plan:</strong> 200 GB - 1 TB</li>
                <li><strong>Premium plan:</strong> 2-10 TB</li>
            </ul>

            <h3>💡 Quick Conversions</h3>
            <div class="formula-box">
                <strong>Common Conversions:</strong><br>
                • 1 GB = 1,024 MB<br>
                • 1 TB = 1,024 GB = 1,048,576 MB<br>
                • 1 MB = 1,024 KB = 1,048,576 Bytes<br>
                • 500 GB ≈ 0.5 TB<br>
                • 2,048 MB = 2 GB<br>
                • 512 GB ≈ 0.5 TB
            </div>

            <h3>📊 Real-World Examples</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Storage Required</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1,000 songs (MP3)</td><td>~4-5 GB</td></tr>
                    <tr><td>10,000 photos</td><td>~30-50 GB</td></tr>
                    <tr><td>100 HD movies</td><td>~500-800 GB</td></tr>
                    <tr><td>Entire music library</td><td>50-200 GB</td></tr>
                    <tr><td>Personal documents</td><td>1-10 GB</td></tr>
                    <tr><td>Work files & backups</td><td>50-500 GB</td></tr>
                </tbody>
            </table>

            <h3>🔄 Binary vs Decimal</h3>
            <p>There's often confusion between binary (1024) and decimal (1000) systems:</p>
            <ul>
                <li><strong>Binary (IEC):</strong> KiB, MiB, GiB, TiB (powers of 1024)</li>
                <li><strong>Decimal (SI):</strong> KB, MB, GB, TB (powers of 1000)</li>
                <li><strong>Computers use binary:</strong> 1 KB = 1,024 bytes</li>
                <li><strong>Storage manufacturers:</strong> Sometimes use decimal for marketing</li>
                <li><strong>Result:</strong> 1 TB drive may show as ~931 GB in OS</li>
            </ul>

            <h3>💾 SSD vs HDD</h3>
            <div class="formula-box">
                <strong>SSD (Solid State Drive):</strong><br>
                • Faster read/write speeds<br>
                • More expensive per GB<br>
                • Typical: 256 GB - 2 TB<br>
                • Best for: OS, applications, active files<br><br>
                <strong>HDD (Hard Disk Drive):</strong><br>
                • Slower but cheaper<br>
                • Higher capacity available<br>
                • Typical: 1-16 TB<br>
                • Best for: Mass storage, backups
            </div>

            <h3>📈 Data Growth Trends</h3>
            <ul>
                <li><strong>2000s:</strong> MB to GB era</li>
                <li><strong>2010s:</strong> GB to TB transition</li>
                <li><strong>2020s:</strong> TB becoming standard</li>
                <li><strong>Future:</strong> PB for consumers approaching</li>
            </ul>

            <h3>🎯 Practical Guidelines</h3>
            <div class="formula-box">
                <strong>How Much Storage Do You Need?</strong><br>
                • Basic use: 256-512 GB<br>
                • Casual user: 512 GB - 1 TB<br>
                • Content creator: 1-4 TB<br>
                • Professional: 4+ TB + external<br>
                • Gamer: 1-2 TB SSD minimum
            </div>

            <h3>🏛️ Historical Context</h3>
            <p>The <strong>byte</strong> (8 bits) became the standard unit of computer storage in the 1960s. The term "mega" comes from Greek meaning "great," and "giga" means "giant." The binary system (1024 = 2^10) is used because computers work in binary (base-2), not decimal (base-10).</p>

            <h3>🔑 Key Points</h3>
            <ul>
                <li><strong>1 KB = 1,024 Bytes</strong> (not 1,000)</li>
                <li><strong>1 MB = 1,024 KB</strong> = 1,048,576 bytes</li>
                <li><strong>1 GB = 1,024 MB</strong> ≈ 1 billion bytes</li>
                <li><strong>1 TB = 1,024 GB</strong> ≈ 1 trillion bytes</li>
                <li><strong>Always check:</strong> Binary vs decimal in specifications</li>
            </ul>
        </div>

        <div class="footer">
            <p>💾 Accurate Data Storage Conversion | All Digital Units</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for file management, storage planning, and data calculations</p>
        </div>
    </div>

    <script>
        // Conversion factors to bytes (binary: 1024)
        const toBytes = {
            B: 1,
            KB: 1024,
            MB: 1024 * 1024,
            GB: 1024 * 1024 * 1024,
            TB: 1024 * 1024 * 1024 * 1024,
            PB: 1024 * 1024 * 1024 * 1024 * 1024
        };

        const unitNames = {
            B: 'Byte (B)',
            KB: 'Kilobyte (KB)',
            MB: 'Megabyte (MB)',
            GB: 'Gigabyte (GB)',
            TB: 'Terabyte (TB)',
            PB: 'Petabyte (PB)'
        };

        function convert() {
            const inputValue = parseFloat(document.getElementById('inputValue').value);
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;

            if (isNaN(inputValue)) {
                document.getElementById('outputValue').value = '';
                document.getElementById('resultGrid').innerHTML = '';
                return;
            }

            const valueInBytes = inputValue * toBytes[fromUnit];
            const result = valueInBytes / toBytes[toUnit];
            
            document.getElementById('outputValue').value = formatNumber(result);
            displayAllConversions(valueInBytes);
        }

        function displayAllConversions(valueInBytes) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInBytes / toBytes[unit];
                
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div class="result-unit">${name}</div>
                    <div class="result-value">${formatNumber(converted)}</div>
                `;
                resultGrid.appendChild(card);
            }
        }

        function formatNumber(num) {
            if (Math.abs(num) < 0.000001) {
                return num.toExponential(6);
            }
            if (Math.abs(num) > 1e15) {
                return num.toExponential(6);
            }
            return num.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 6
            });
        }

        function swapUnits() {
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;
            
            document.getElementById('fromUnit').value = toUnit;
            document.getElementById('toUnit').value = fromUnit;
            
            convert();
        }

        function setInput(value) {
            document.getElementById('inputValue').value = value;
            convert();
        }

        // Auto-convert on input
        document.getElementById('inputValue').addEventListener('input', convert);
        document.getElementById('fromUnit').addEventListener('change', convert);
        document.getElementById('toUnit').addEventListener('change', convert);

        // Initial conversion
        convert();
    </script>
</body>
</html>