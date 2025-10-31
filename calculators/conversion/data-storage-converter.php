<?php
/**
 * Data Storage Converter
 * File: conversion/data-storage-converter.php
 * Description: Convert between all data storage units
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Storage Converter - Byte, KB, MB, GB, TB Calculator</title>
    <meta name="description" content="Convert between bytes, KB, MB, GB, TB, and PB. Supports both decimal (SI) and binary (IEC) standards for accurate data storage conversion.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
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
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; }
        .unit-select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #667eea; }
        .result-unit { color: #7f8c8d; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #2c3e50; word-wrap: break-word; }
        
        .quick-convert { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-convert h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(110px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #667eea; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15); }
        .quick-value { font-weight: bold; color: #667eea; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .comparison-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .comparison-table th, .comparison-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .comparison-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .comparison-table tr:hover { background: #f8f9fa; }
        
        .formula-box { background: #f0f4ff; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .converter-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .result-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .standard-selector { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💽 Data Storage Converter</h1>
            <p>Convert between bytes, KB, MB, GB, TB, and all data storage units with decimal (SI) and binary (IEC) standards</p>
        </div>

        <div class="converter-card">
            <div class="standard-selector">
                <button class="standard-btn active" onclick="selectStandard('decimal', this)">
                    Decimal (SI)<br><span style="font-size: 0.8rem; font-weight: 400;">Base 1000 - KB, MB, GB</span>
                </button>
                <button class="standard-btn" onclick="selectStandard('binary', this)">
                    Binary (IEC)<br><span style="font-size: 0.8rem; font-weight: 400;">Base 1024 - KiB, MiB, GiB</span>
                </button>
            </div>

            <div class="converter-row">
                <div class="input-group">
                    <label for="inputValue">From</label>
                    <div class="input-wrapper">
                        <input type="number" id="inputValue" placeholder="Enter value" step="any" value="1">
                    </div>
                    <select id="fromUnit" class="unit-select" style="margin-top: 10px;">
                        <option value="bit">Bit (b)</option>
                        <option value="byte">Byte (B)</option>
                        <option value="kb" selected>Kilobyte (KB)</option>
                        <option value="mb">Megabyte (MB)</option>
                        <option value="gb">Gigabyte (GB)</option>
                        <option value="tb">Terabyte (TB)</option>
                        <option value="pb">Petabyte (PB)</option>
                    </select>
                </div>

                <button class="swap-btn" onclick="swapUnits()" title="Swap units">⇄</button>

                <div class="input-group">
                    <label for="toUnit">To</label>
                    <select id="toUnit" class="unit-select">
                        <option value="bit">Bit (b)</option>
                        <option value="byte">Byte (B)</option>
                        <option value="kb">Kilobyte (KB)</option>
                        <option value="mb" selected>Megabyte (MB)</option>
                        <option value="gb">Gigabyte (GB)</option>
                        <option value="tb">Terabyte (TB)</option>
                        <option value="pb">Petabyte (PB)</option>
                    </select>
                    <div class="input-wrapper" style="margin-top: 10px;">
                        <input type="text" id="outputValue" placeholder="Result" readonly style="background: #f8f9fa; font-weight: 600; color: #2c3e50;">
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid"></div>

            <div class="quick-convert">
                <h3>⚡ Common Sizes</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setInputValue(1)">
                        <div class="quick-value">1</div>
                        <div class="quick-label">Unit</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(100)">
                        <div class="quick-value">100</div>
                        <div class="quick-label">Units</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(500)">
                        <div class="quick-value">500</div>
                        <div class="quick-label">Units</div>
                    </div>
                    <div class="quick-btn" onclick="setInputValue(1000)">
                        <div class="quick-value">1,000</div>
                        <div class="quick-label">Units</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>💾 Data Storage Conversion Guide</h2>
            
            <p><strong>Data storage</strong> is measured in various units from bits to petabytes. There are two standards: <strong>Decimal (SI)</strong> used by storage manufacturers, and <strong>Binary (IEC)</strong> used by operating systems.</p>

            <h3>📊 Decimal (SI) vs Binary (IEC)</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Decimal (SI)</th>
                        <th>Value in Bytes</th>
                        <th>Binary (IEC)</th>
                        <th>Value in Bytes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1 Kilobyte (KB)</td>
                        <td>1,000 B</td>
                        <td>1 Kibibyte (KiB)</td>
                        <td>1,024 B</td>
                    </tr>
                    <tr>
                        <td>1 Megabyte (MB)</td>
                        <td>1,000,000 B</td>
                        <td>1 Mebibyte (MiB)</td>
                        <td>1,048,576 B</td>
                    </tr>
                    <tr>
                        <td>1 Gigabyte (GB)</td>
                        <td>1,000,000,000 B</td>
                        <td>1 Gibibyte (GiB)</td>
                        <td>1,073,741,824 B</td>
                    </tr>
                    <tr>
                        <td>1 Terabyte (TB)</td>
                        <td>1,000,000,000,000 B</td>
                        <td>1 Tebibyte (TiB)</td>
                        <td>1,099,511,627,776 B</td>
                    </tr>
                    <tr>
                        <td>1 Petabyte (PB)</td>
                        <td>1,000⁵ B</td>
                        <td>1 Pebibyte (PiB)</td>
                        <td>1,125,899,906,842,624 B</td>
                    </tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Conversion Factors:</strong><br>
                <strong>Decimal (SI):</strong> Each step × 1,000 (KB, MB, GB, TB, PB)<br>
                <strong>Binary (IEC):</strong> Each step × 1,024 (KiB, MiB, GiB, TiB, PiB)<br>
                <strong>Fundamental:</strong> 1 Byte = 8 Bits
            </div>

            <h3>💽 Common File Sizes</h3>
            <ul>
                <li><strong>Plain text file:</strong> 1-100 KB</li>
                <li><strong>Word document:</strong> 50-500 KB</li>
                <li><strong>High-quality photo (JPEG):</strong> 2-10 MB</li>
                <li><strong>MP3 song (3-4 min):</strong> 3-5 MB</li>
                <li><strong>HD video (1 hour):</strong> 3-5 GB</li>
                <li><strong>4K video (1 hour):</strong> 25-50 GB</li>
                <li><strong>AAA video game:</strong> 50-150 GB</li>
                <li><strong>Operating system:</strong> 20-50 GB</li>
            </ul>

            <h3>📱 Storage Device Capacities</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Device</th>
                        <th>Typical Size</th>
                        <th>Use Case</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>USB Flash Drive</td><td>8-256 GB</td><td>File transfer, backups</td></tr>
                    <tr><td>SD Card</td><td>16-1,024 GB</td><td>Cameras, phones</td></tr>
                    <tr><td>SSD (Computer)</td><td>256-4,000 GB</td><td>Fast OS & program storage</td></tr>
                    <tr><td>HDD (Computer)</td><td>500-16,000 GB</td><td>Mass data storage</td></tr>
                    <tr><td>Smartphone</td><td>64-1,024 GB</td><td>Apps, photos, videos</td></tr>
                    <tr><td>External HDD</td><td>1-18 TB</td><td>Backups, archives</td></tr>
                    <tr><td>Enterprise Server</td><td>10-100+ TB</td><td>Data centers, cloud</td></tr>
                </tbody>
            </table>

            <h3>🔢 Why Two Standards?</h3>
            <ul>
                <li><strong>Decimal (SI):</strong> Marketing standard (1000-based makes drives look larger)</li>
                <li><strong>Binary (IEC):</strong> Technical standard (computers use binary, 1024-based)</li>
                <li><strong>The gap:</strong> 1 TB = 931 GiB (about 7% difference)</li>
                <li><strong>Windows shows:</strong> Binary sizes (GiB) but labels as GB</li>
                <li><strong>macOS shows:</strong> Decimal sizes (GB) correctly labeled</li>
            </ul>

            <h3>💾 Storage Types Explained</h3>
            <ul>
                <li><strong>HDD (Hard Disk Drive):</strong> Mechanical, slower, cheaper per GB</li>
                <li><strong>SSD (Solid State Drive):</strong> No moving parts, much faster, more expensive</li>
                <li><strong>NVMe SSD:</strong> Fastest type, uses PCIe interface</li>
                <li><strong>RAM:</strong> Volatile memory, extremely fast, loses data when powered off</li>
                <li><strong>Cloud Storage:</strong> Remote servers, accessible anywhere</li>
            </ul>

            <h3>🌐 Internet Data Usage</h3>
            <div class="formula-box">
                <strong>Monthly Data Consumption:</strong><br>
                • Streaming HD video (1 hour): ~3 GB<br>
                • Streaming 4K video (1 hour): ~7-25 GB<br>
                • Video call (1 hour): ~500 MB - 1.5 GB<br>
                • Music streaming (1 hour): ~40-150 MB<br>
                • Web browsing (1 hour): ~60-150 MB<br>
                • Social media (1 hour): ~100-300 MB
            </div>

            <h3>📏 Prefix Names Explanation</h3>
            <ul>
                <li><strong>Kilo / Kibi:</strong> Thousand / 1,024 (K / Ki)</li>
                <li><strong>Mega / Mebi:</strong> Million / 1,048,576 (M / Mi)</li>
                <li><strong>Giga / Gibi:</strong> Billion / 1,073,741,824 (G / Gi)</li>
                <li><strong>Tera / Tebi:</strong> Trillion / 1,099,511,627,776 (T / Ti)</li>
                <li><strong>Peta / Pebi:</strong> Quadrillion / 1,125,899,906,842,624 (P / Pi)</li>
            </ul>

            <h3>💡 Quick Tips</h3>
            <ul>
                <li>When buying storage, manufacturers use decimal (larger numbers)</li>
                <li>Your OS shows binary sizes (smaller numbers)</li>
                <li>A "1 TB" drive shows as about 931 GB in Windows</li>
                <li>RAM always uses binary measurements (true GiB)</li>
                <li>Internet speeds use bits (Mbps), storage uses bytes (MB)</li>
                <li>Divide internet speed by 8 to get download speed in MB/s</li>
            </ul>

            <h3>🎯 Real-World Example</h3>
            <div class="formula-box">
                <strong>Why your 1 TB drive shows as 931 GB:</strong><br>
                • Manufacturer: 1 TB = 1,000,000,000,000 bytes (decimal)<br>
                • Windows: Converts to binary GiB<br>
                • 1,000,000,000,000 ÷ 1,073,741,824 = 931.32 GiB<br>
                • Windows labels it "931 GB" (technically wrong, but common)<br>
                • Your drive has full capacity, just measured differently!
            </div>

            <h3>📊 Data Growth Over Time</h3>
            <ul>
                <li><strong>1980s:</strong> Floppy disks - 360 KB to 1.44 MB</li>
                <li><strong>1990s:</strong> CDs - 700 MB, First GB hard drives</li>
                <li><strong>2000s:</strong> DVDs - 4.7-9 GB, 100+ GB HDDs common</li>
                <li><strong>2010s:</strong> Blu-ray - 25-50 GB, Multi-TB HDDs</li>
                <li><strong>2020s:</strong> 100 TB SSDs, Petabyte servers standard</li>
            </ul>
        </div>

        <div class="footer">
            <p>💽 Accurate Data Storage Conversion | All Units Supported</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for understanding storage devices, file sizes, and data usage</p>
        </div>
    </div>

    <script>
        let currentStandard = 'decimal';
        
        // Conversion factors to bytes
        const decimalFactors = {
            bit: 0.125,
            byte: 1,
            kb: 1000,
            mb: 1000000,
            gb: 1000000000,
            tb: 1000000000000,
            pb: 1000000000000000
        };

        const binaryFactors = {
            bit: 0.125,
            byte: 1,
            kb: 1024,        // KiB
            mb: 1048576,     // MiB
            gb: 1073741824,  // GiB
            tb: 1099511627776, // TiB
            pb: 1125899906842624 // PiB
        };

        const unitNames = {
            bit: 'Bit (b)',
            byte: 'Byte (B)',
            kb: 'Kilobyte',
            mb: 'Megabyte',
            gb: 'Gigabyte',
            tb: 'Terabyte',
            pb: 'Petabyte'
        };

        function selectStandard(standard, btn) {
            currentStandard = standard;
            document.querySelectorAll('.standard-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            // Update unit names
            updateUnitNames();
            convertStorage();
        }

        function updateUnitNames() {
            const suffix = currentStandard === 'binary' ? ' (IEC)' : ' (SI)';
            const options = document.querySelectorAll('.unit-select option');
            
            options.forEach(opt => {
                if (opt.value !== 'bit' && opt.value !== 'byte') {
                    const baseName = unitNames[opt.value];
                    opt.textContent = baseName + suffix;
                }
            });
        }

        function convertStorage() {
            const inputValue = parseFloat(document.getElementById('inputValue').value);
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;

            if (isNaN(inputValue)) {
                document.getElementById('outputValue').value = '';
                document.getElementById('resultGrid').innerHTML = '';
                return;
            }

            const factors = currentStandard === 'decimal' ? decimalFactors : binaryFactors;
            
            const valueInBytes = inputValue * factors[fromUnit];
            const result = valueInBytes / factors[toUnit];

            document.getElementById('outputValue').value = formatNumber(result);
            displayAllConversions(valueInBytes);
        }

        function displayAllConversions(valueInBytes) {
            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            const factors = currentStandard === 'decimal' ? decimalFactors : binaryFactors;
            const standard = currentStandard === 'decimal' ? 'SI' : 'IEC';

            for (const [unit, name] of Object.entries(unitNames)) {
                const converted = valueInBytes / factors[unit];
                const suffix = (unit !== 'bit' && unit !== 'byte') ? ` (${standard})` : '';
                
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div class="result-unit">${name}${suffix}</div>
                    <div class="result-value">${formatNumber(converted)}</div>
                `;
                resultGrid.appendChild(card);
            }
        }

        function formatNumber(num) {
            if (Math.abs(num) < 0.000001 || Math.abs(num) > 1e15) {
                return num.toExponential(6);
            }
            return num.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 8
            });
        }

        function swapUnits() {
            const fromUnit = document.getElementById('fromUnit').value;
            const toUnit = document.getElementById('toUnit').value;
            
            document.getElementById('fromUnit').value = toUnit;
            document.getElementById('toUnit').value = fromUnit;
            
            convertStorage();
        }

        function setInputValue(value) {
            document.getElementById('inputValue').value = value;
            convertStorage();
        }

        // Auto-convert on input
        document.getElementById('inputValue').addEventListener('input', convertStorage);
        document.getElementById('fromUnit').addEventListener('change', convertStorage);
        document.getElementById('toUnit').addEventListener('change', convertStorage);

        // Initial setup
        updateUnitNames();
        convertStorage();
    </script>
</body>
</html>