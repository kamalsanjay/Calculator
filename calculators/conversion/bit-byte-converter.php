<?php
/**
 * Bit and Byte Converter
 * File: conversion/bit-byte-converter.php
 * Description: Convert between bits, bytes, and all data storage units
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bit Byte Converter - Data Storage Unit Calculator</title>
    <meta name="description" content="Convert between bits, bytes, kilobytes, megabytes, gigabytes, and all data storage units. Free bit byte converter calculator.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .tabs { display: flex; gap: 10px; margin-bottom: 25px; border-bottom: 2px solid #e0e0e0; }
        .tab { padding: 12px 24px; background: transparent; border: none; cursor: pointer; font-size: 1rem; font-weight: 600; color: #7f8c8d; border-bottom: 3px solid transparent; transition: all 0.3s; }
        .tab.active { color: #3498db; border-bottom-color: #3498db; }
        .tab:hover { color: #3498db; }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .converter-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #3498db; box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; }
        .unit-select:focus { outline: none; border-color: #3498db; box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1); }
        
        .swap-btn { background: #3498db; color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); background: #2980b9; }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #3498db; }
        .result-unit { color: #7f8c8d; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #2c3e50; word-wrap: break-word; }
        
        .info-box { background: #f0f8ff; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #3498db; }
        .info-box strong { color: #2c3e50; }
        
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
        
        .formula-box { background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #3498db; font-family: 'Courier New', monospace; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .converter-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .result-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .tabs { overflow-x: auto; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚙️ Bit & Byte Converter</h1>
            <p>Convert between bits, bytes, and all data storage units with decimal (SI) and binary (IEC) standards</p>
        </div>

        <div class="converter-card">
            <div class="tabs">
                <button class="tab active" onclick="switchTab('decimal')">Decimal (SI)</button>
                <button class="tab" onclick="switchTab('binary')">Binary (IEC)</button>
            </div>

            <!-- Decimal (SI) Tab -->
            <div id="decimal" class="tab-content active">
                <div class="info-box">
                    <strong>Decimal (SI) Standard:</strong> Uses powers of 1000 (KB = 1,000 bytes)
                </div>

                <div class="converter-row">
                    <div class="input-group">
                        <label for="decimalInput">From</label>
                        <div class="input-wrapper">
                            <input type="number" id="decimalInput" placeholder="Enter value" step="any" value="1">
                        </div>
                        <select id="decimalFromUnit" class="unit-select" style="margin-top: 10px;">
                            <option value="bit">Bit (b)</option>
                            <option value="byte" selected>Byte (B)</option>
                            <option value="kb">Kilobyte (KB)</option>
                            <option value="mb">Megabyte (MB)</option>
                            <option value="gb">Gigabyte (GB)</option>
                            <option value="tb">Terabyte (TB)</option>
                            <option value="pb">Petabyte (PB)</option>
                        </select>
                    </div>

                    <button class="swap-btn" onclick="swapUnits('decimal')" title="Swap units">⇄</button>

                    <div class="input-group">
                        <label for="decimalToUnit">To</label>
                        <select id="decimalToUnit" class="unit-select">
                            <option value="bit" selected>Bit (b)</option>
                            <option value="byte">Byte (B)</option>
                            <option value="kb">Kilobyte (KB)</option>
                            <option value="mb">Megabyte (MB)</option>
                            <option value="gb">Gigabyte (GB)</option>
                            <option value="tb">Terabyte (TB)</option>
                            <option value="pb">Petabyte (PB)</option>
                        </select>
                        <div class="input-wrapper" style="margin-top: 10px;">
                            <input type="text" id="decimalOutput" placeholder="Result" readonly style="background: #f8f9fa; font-weight: 600; color: #2c3e50;">
                        </div>
                    </div>
                </div>

                <div class="result-grid" id="decimalResults"></div>
            </div>

            <!-- Binary (IEC) Tab -->
            <div id="binary" class="tab-content">
                <div class="info-box">
                    <strong>Binary (IEC) Standard:</strong> Uses powers of 1024 (KiB = 1,024 bytes)
                </div>

                <div class="converter-row">
                    <div class="input-group">
                        <label for="binaryInput">From</label>
                        <div class="input-wrapper">
                            <input type="number" id="binaryInput" placeholder="Enter value" step="any" value="1">
                        </div>
                        <select id="binaryFromUnit" class="unit-select" style="margin-top: 10px;">
                            <option value="bit">Bit (b)</option>
                            <option value="byte" selected>Byte (B)</option>
                            <option value="kib">Kibibyte (KiB)</option>
                            <option value="mib">Mebibyte (MiB)</option>
                            <option value="gib">Gibibyte (GiB)</option>
                            <option value="tib">Tebibyte (TiB)</option>
                            <option value="pib">Pebibyte (PiB)</option>
                        </select>
                    </div>

                    <button class="swap-btn" onclick="swapUnits('binary')" title="Swap units">⇄</button>

                    <div class="input-group">
                        <label for="binaryToUnit">To</label>
                        <select id="binaryToUnit" class="unit-select">
                            <option value="bit" selected>Bit (b)</option>
                            <option value="byte">Byte (B)</option>
                            <option value="kib">Kibibyte (KiB)</option>
                            <option value="mib">Mebibyte (MiB)</option>
                            <option value="gib">Gibibyte (GiB)</option>
                            <option value="tib">Tebibyte (TiB)</option>
                            <option value="pib">Pebibyte (PiB)</option>
                        </select>
                        <div class="input-wrapper" style="margin-top: 10px;">
                            <input type="text" id="binaryOutput" placeholder="Result" readonly style="background: #f8f9fa; font-weight: 600; color: #2c3e50;">
                        </div>
                    </div>
                </div>

                <div class="result-grid" id="binaryResults"></div>
            </div>
        </div>

        <div class="info-section">
            <h2>💾 Understanding Bits and Bytes</h2>
            
            <p>Digital data is measured in <strong>bits</strong> and <strong>bytes</strong>. A bit is the smallest unit (0 or 1), while a byte consists of 8 bits. There are two standards for larger units: Decimal (SI) and Binary (IEC).</p>

            <h3>🔢 Decimal (SI) vs Binary (IEC) Standards</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Decimal (SI)</th>
                        <th>Value</th>
                        <th>Binary (IEC)</th>
                        <th>Value</th>
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
                        <td>1,000 KB</td>
                        <td>1 Mebibyte (MiB)</td>
                        <td>1,024 KiB</td>
                    </tr>
                    <tr>
                        <td>1 Gigabyte (GB)</td>
                        <td>1,000 MB</td>
                        <td>1 Gibibyte (GiB)</td>
                        <td>1,024 MiB</td>
                    </tr>
                    <tr>
                        <td>1 Terabyte (TB)</td>
                        <td>1,000 GB</td>
                        <td>1 Tebibyte (TiB)</td>
                        <td>1,024 GiB</td>
                    </tr>
                    <tr>
                        <td>1 Petabyte (PB)</td>
                        <td>1,000 TB</td>
                        <td>1 Pebibyte (PiB)</td>
                        <td>1,024 TiB</td>
                    </tr>
                </tbody>
            </table>

            <h3>📊 Conversion Formulas</h3>
            <div class="formula-box">
                <strong>Basic Conversions:</strong><br>
                1 Byte = 8 Bits<br>
                1 Bit = 0.125 Bytes<br><br>
                
                <strong>Decimal (SI) - Base 1000:</strong><br>
                1 KB = 1,000 Bytes = 1,000 B<br>
                1 MB = 1,000 KB = 1,000,000 B<br>
                1 GB = 1,000 MB = 1,000,000,000 B<br>
                1 TB = 1,000 GB = 1,000,000,000,000 B<br><br>
                
                <strong>Binary (IEC) - Base 1024:</strong><br>
                1 KiB = 1,024 Bytes = 1,024 B<br>
                1 MiB = 1,024 KiB = 1,048,576 B<br>
                1 GiB = 1,024 MiB = 1,073,741,824 B<br>
                1 TiB = 1,024 GiB = 1,099,511,627,776 B
            </div>

            <h3>🎯 Which Standard to Use?</h3>
            <ul>
                <li><strong>Decimal (SI):</strong> Used by storage manufacturers (hard drives, SSDs, USB drives)</li>
                <li><strong>Binary (IEC):</strong> Used by operating systems (Windows, macOS, Linux) and RAM</li>
                <li><strong>Why the difference?</strong> Marketing (1000 makes drives appear larger) vs technical accuracy (computers use binary)</li>
                <li><strong>Real example:</strong> A "1 TB" hard drive shows as ~931 GiB in Windows</li>
            </ul>

            <h3>💡 Common File Sizes</h3>
            <ul>
                <li><strong>Text file (1 page):</strong> ~2-5 KB</li>
                <li><strong>High-quality photo:</strong> ~3-10 MB</li>
                <li><strong>MP3 song (3 min):</strong> ~3-5 MB</li>
                <li><strong>HD movie (2 hours):</strong> ~3-5 GB</li>
                <li><strong>4K movie (2 hours):</strong> ~25-50 GB</li>
                <li><strong>AAA video game:</strong> ~50-150 GB</li>
            </ul>

            <h3>🌐 Internet Speed vs Storage</h3>
            <div class="formula-box">
                <strong>Important Note:</strong><br>
                Internet speeds use <strong>bits per second</strong> (Mbps, Gbps)<br>
                File sizes use <strong>bytes</strong> (MB, GB)<br><br>
                
                <strong>Example:</strong><br>
                100 Mbps internet = 12.5 MB/s download speed<br>
                (100 Mbps ÷ 8 bits per byte = 12.5 MB/s)
            </div>

            <h3>📱 Real-World Examples</h3>
            <ul>
                <li><strong>32 GB iPhone:</strong> ~29.8 GiB usable (after OS)</li>
                <li><strong>1 TB SSD:</strong> Shows as 931 GiB in Windows</li>
                <li><strong>16 GB RAM:</strong> Actually 16 GiB (17.18 GB in decimal)</li>
                <li><strong>Gigabit Ethernet:</strong> 1,000 Mbps = 125 MB/s max speed</li>
            </ul>

            <h3>🔤 Unit Abbreviations</h3>
            <ul>
                <li><strong>Lowercase 'b' = bit:</strong> Mb (megabit), Gb (gigabit)</li>
                <li><strong>Uppercase 'B' = byte:</strong> MB (megabyte), GB (gigabyte)</li>
                <li><strong>IEC suffix 'i':</strong> KiB (kibibyte), MiB (mebibyte), GiB (gibibyte)</li>
            </ul>

            <h3>💻 Technical Notes</h3>
            <ul>
                <li>1 nibble = 4 bits (half a byte)</li>
                <li>1 word = 2 bytes (16 bits) on most systems</li>
                <li>ASCII character = 1 byte (8 bits)</li>
                <li>Unicode character = 1-4 bytes depending on encoding</li>
                <li>IPv4 address = 4 bytes (32 bits)</li>
                <li>IPv6 address = 16 bytes (128 bits)</li>
            </ul>
        </div>

        <div class="footer">
            <p>⚙️ Accurate Bit & Byte Conversion | Both SI and IEC Standards</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for data storage, networking, and computing calculations</p>
        </div>
    </div>

    <script>
        // Decimal (SI) conversion factors to bytes
        const decimalFactors = {
            bit: 0.125,
            byte: 1,
            kb: 1000,
            mb: 1000000,
            gb: 1000000000,
            tb: 1000000000000,
            pb: 1000000000000000
        };

        // Binary (IEC) conversion factors to bytes
        const binaryFactors = {
            bit: 0.125,
            byte: 1,
            kib: 1024,
            mib: 1048576,
            gib: 1073741824,
            tib: 1099511627776,
            pib: 1125899906842624
        };

        const decimalNames = {
            bit: 'Bit (b)',
            byte: 'Byte (B)',
            kb: 'Kilobyte (KB)',
            mb: 'Megabyte (MB)',
            gb: 'Gigabyte (GB)',
            tb: 'Terabyte (TB)',
            pb: 'Petabyte (PB)'
        };

        const binaryNames = {
            bit: 'Bit (b)',
            byte: 'Byte (B)',
            kib: 'Kibibyte (KiB)',
            mib: 'Mebibyte (MiB)',
            gib: 'Gibibyte (GiB)',
            tib: 'Tebibyte (TiB)',
            pib: 'Pebibyte (PiB)'
        };

        function switchTab(tab) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            
            event.target.classList.add('active');
            document.getElementById(tab).classList.add('active');
            
            if (tab === 'decimal') convertDecimal();
            else convertBinary();
        }

        function convertDecimal() {
            const value = parseFloat(document.getElementById('decimalInput').value);
            const fromUnit = document.getElementById('decimalFromUnit').value;
            const toUnit = document.getElementById('decimalToUnit').value;

            if (isNaN(value)) {
                document.getElementById('decimalOutput').value = '';
                document.getElementById('decimalResults').innerHTML = '';
                return;
            }

            const valueInBytes = value * decimalFactors[fromUnit];
            const result = valueInBytes / decimalFactors[toUnit];

            document.getElementById('decimalOutput').value = formatNumber(result);
            displayResults(valueInBytes, 'decimal', 'decimalResults');
        }

        function convertBinary() {
            const value = parseFloat(document.getElementById('binaryInput').value);
            const fromUnit = document.getElementById('binaryFromUnit').value;
            const toUnit = document.getElementById('binaryToUnit').value;

            if (isNaN(value)) {
                document.getElementById('binaryOutput').value = '';
                document.getElementById('binaryResults').innerHTML = '';
                return;
            }

            const valueInBytes = value * binaryFactors[fromUnit];
            const result = valueInBytes / binaryFactors[toUnit];

            document.getElementById('binaryOutput').value = formatNumber(result);
            displayResults(valueInBytes, 'binary', 'binaryResults');
        }

        function displayResults(valueInBytes, type, containerId) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';

            const factors = type === 'decimal' ? decimalFactors : binaryFactors;
            const names = type === 'decimal' ? decimalNames : binaryNames;

            for (const [unit, name] of Object.entries(names)) {
                const converted = valueInBytes / factors[unit];
                
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div class="result-unit">${name}</div>
                    <div class="result-value">${formatNumber(converted)}</div>
                `;
                container.appendChild(card);
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

        function swapUnits(type) {
            const fromSelect = document.getElementById(type + 'FromUnit');
            const toSelect = document.getElementById(type + 'ToUnit');
            
            const temp = fromSelect.value;
            fromSelect.value = toSelect.value;
            toSelect.value = temp;
            
            if (type === 'decimal') convertDecimal();
            else convertBinary();
        }

        // Auto-convert on input
        document.getElementById('decimalInput').addEventListener('input', convertDecimal);
        document.getElementById('decimalFromUnit').addEventListener('change', convertDecimal);
        document.getElementById('decimalToUnit').addEventListener('change', convertDecimal);

        document.getElementById('binaryInput').addEventListener('input', convertBinary);
        document.getElementById('binaryFromUnit').addEventListener('change', convertBinary);
        document.getElementById('binaryToUnit').addEventListener('change', convertBinary);

        // Initial conversion
        convertDecimal();
    </script>
</body>
</html>