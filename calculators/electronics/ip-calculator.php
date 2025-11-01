<?php
/**
 * IP Calculator
 * File: electronics/ip-calculator.php
 * Description: Advanced IP address calculator with subnetting, CIDR, and network analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Calculator - Advanced IP Address & Subnet Calculator</title>
    <meta name="description" content="Advanced IP calculator with subnetting, CIDR notation, network analysis, and IP address calculations.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh; 
            padding: 20px; 
        }
        
        .container { 
            max-width: 1400px; 
            margin: 0 auto; 
        }
        
        .header { 
            background: rgba(255,255,255,0.95); 
            padding: 30px; 
            border-radius: 20px 20px 0 0; 
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1); 
            text-align: center; 
        }
        .header h1 { 
            color: #2c3e50; 
            font-size: 2.5rem; 
            margin-bottom: 10px; 
        }
        .header p { 
            color: #7f8c8d; 
            font-size: 1.2rem; 
            opacity: 0.9; 
        }
        
        .calculator-wrapper { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 30px; 
            background: white; 
            padding: 35px; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.12); 
        }
        
        .calculator-section h2, .results-section h2 { 
            color: #667eea; 
            margin-bottom: 25px; 
            font-size: 1.8rem; 
        }
        
        .form-group { 
            margin-bottom: 20px; 
        }
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            color: #555; 
        }
        .form-group input, .form-group select { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #e0e0e0; 
            border-radius: 8px; 
            font-size: 16px; 
            transition: border-color 0.3s; 
        }
        .form-group input:focus, .form-group select:focus { 
            outline: none; 
            border-color: #667eea; 
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); 
        }
        .form-group small { 
            display: block; 
            margin-top: 5px; 
            color: #888; 
            font-size: 0.9em; 
        }
        
        .input-group { 
            display: grid; 
            grid-template-columns: 2fr 1fr; 
            gap: 10px; 
            align-items: end; 
        }
        
        .btn { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 15px 30px; 
            border: none; 
            border-radius: 8px; 
            font-size: 18px; 
            font-weight: 600; 
            cursor: pointer; 
            width: 100%; 
            transition: all 0.3s; 
        }
        .btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); 
        }
        
        .result-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 25px; 
            border-radius: 12px; 
            margin-bottom: 20px; 
            text-align: center; 
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); 
            position: relative; 
            overflow: hidden; 
        }
        .result-card::before { 
            content: ''; 
            position: absolute; 
            top: -50%; 
            right: -50%; 
            width: 200%; 
            height: 200%; 
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); 
            animation: pulse 3s ease-in-out infinite; 
        }
        @keyframes pulse { 
            0%, 100% { transform: scale(1); opacity: 0.5; } 
            50% { transform: scale(1.1); opacity: 0.8; } 
        }
        .result-card h3 { 
            font-size: 1.2rem; 
            opacity: 0.9; 
            margin-bottom: 10px; 
            font-weight: 400; 
            position: relative; 
            z-index: 1; 
        }
        .result-card .amount { 
            font-size: 3rem; 
            font-weight: bold; 
            position: relative; 
            z-index: 1; 
        }
        
        .metric-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-bottom: 20px; 
        }
        .metric-card { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 12px; 
            text-align: center; 
            border: 2px solid #e0e0e0; 
            transition: all 0.3s; 
        }
        .metric-card:hover { 
            transform: translateY(-2px); 
            border-color: #667eea; 
        }
        .metric-card h4 { 
            color: #666; 
            font-size: 0.9rem; 
            margin-bottom: 10px; 
            font-weight: 400; 
        }
        .metric-card .value { 
            color: #667eea; 
            font-size: 1.8rem; 
            font-weight: bold; 
        }
        
        .breakdown { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 12px; 
            margin-bottom: 20px; 
        }
        .breakdown h3 { 
            color: #667eea; 
            margin-bottom: 15px; 
            font-size: 1.3rem; 
        }
        .breakdown-item { 
            display: flex; 
            justify-content: space-between; 
            padding: 12px 0; 
            border-bottom: 1px solid #e0e0e0; 
        }
        .breakdown-item:last-child { 
            border-bottom: none; 
        }
        .breakdown-item span { 
            color: #666; 
        }
        .breakdown-item strong { 
            color: #333; 
            font-weight: 600; 
        }
        
        .binary-grid { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            gap: 5px; 
            margin-top: 10px; 
        }
        .binary-item { 
            background: #e0e0e0; 
            padding: 8px; 
            text-align: center; 
            border-radius: 4px; 
            font-family: monospace; 
            font-weight: bold; 
        }
        .binary-item.network { 
            background: #667eea; 
            color: white; 
        }
        .binary-item.host { 
            background: #764ba2; 
            color: white; 
        }
        
        .subnet-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
            gap: 15px; 
            margin-top: 15px; 
        }
        .subnet-card { 
            background: #f0f2f5; 
            padding: 15px; 
            border-radius: 8px; 
            border-left: 4px solid #667eea; 
        }
        .subnet-card h4 { 
            color: #667eea; 
            margin-bottom: 10px; 
        }
        
        .info-box { 
            background: #e8f2ff; 
            border-left: 4px solid #667eea; 
            padding: 15px; 
            margin: 20px 0; 
            border-radius: 5px; 
        }
        .info-box strong { 
            color: #667eea; 
        }
        
        .footer { 
            background: rgba(255,255,255,0.95); 
            padding: 25px; 
            border-radius: 0 0 20px 20px; 
            text-align: center; 
            color: #7f8c8d; 
        }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { 
                grid-template-columns: 1fr; 
                padding: 25px; 
            }
            .result-card .amount { 
                font-size: 2.5rem; 
            }
        }
        
        @media (max-width: 768px) {
            .header h1 { 
                font-size: 2rem; 
            }
            .metric-grid { 
                grid-template-columns: 1fr; 
            }
            .input-group { 
                grid-template-columns: 1fr; 
            }
            .binary-grid { 
                grid-template-columns: repeat(2, 1fr); 
            }
            .subnet-grid { 
                grid-template-columns: 1fr; 
            }
        }
        
        @media (max-width: 480px) {
            .header h1 { 
                font-size: 1.5rem; 
            }
            .header p { 
                font-size: 1rem; 
            }
            .result-card .amount { 
                font-size: 2rem; 
            }
            body { 
                padding: 10px; 
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌐 IP Calculator</h1>
            <p>Advanced IP address calculator with subnetting, CIDR, and network analysis</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>IP Address Information</h2>
                <form id="ipForm">
                    <div class="form-group">
                        <label for="ipAddress">IP Address</label>
                        <input type="text" id="ipAddress" value="192.168.1.1" required>
                        <small>Enter IPv4 address (e.g., 192.168.1.1)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="subnetMask">Subnet Mask / CIDR</label>
                        <div class="input-group">
                            <input type="text" id="subnetMask" value="24" required>
                            <select id="maskType" style="padding: 12px;">
                                <option value="cidr">CIDR</option>
                                <option value="mask">Subnet Mask</option>
                            </select>
                        </div>
                        <small>Enter CIDR notation (e.g., 24) or subnet mask (e.g., 255.255.255.0)</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Presets</label>
                        <div class="speed-preset">
                            <div class="speed-btn" onclick="setPreset('192.168.1.1', '24')">/24 (Home)</div>
                            <div class="speed-btn" onclick="setPreset('10.0.0.1', '8')">/8 (Class A)</div>
                            <div class="speed-btn" onclick="setPreset('172.16.0.1', '16')">/16 (Class B)</div>
                            <div class="speed-btn" onclick="setPreset('192.168.0.1', '24')">/24 (Class C)</div>
                            <div class="speed-btn" onclick="setPreset('192.168.1.1', '30')">/30 (Point-to-Point)</div>
                            <div class="speed-btn" onclick="setPreset('192.168.1.1', '26')">/26 (Small Business)</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="calculateSubnets">Calculate Subnets</label>
                        <input type="number" id="calculateSubnets" value="1" min="1" max="256" step="1">
                        <small>Number of subnets to calculate (1-256)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="hostsPerSubnet">Hosts per Subnet</label>
                        <input type="number" id="hostsPerSubnet" value="254" min="2" max="16777214" step="1">
                        <small>Required hosts per subnet (2-16,777,214)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate IP Information</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Network Analysis</h2>
                
                <div class="result-card">
                    <h3>Network Address</h3>
                    <div class="amount" id="networkAddress">192.168.1.0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Usable Hosts</h4>
                        <div class="value" id="usableHosts">254</div>
                    </div>
                    <div class="metric-card">
                        <h4>Subnet Mask</h4>
                        <div class="value" id="subnetMaskDisplay">255.255.255.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>CIDR Notation</h4>
                        <div class="value" id="cidrNotation">/24</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>IP Address Information</h3>
                    <div class="breakdown-item">
                        <span>IP Address</span>
                        <strong id="ipAddressDisplay">192.168.1.1</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Network Address</span>
                        <strong id="networkAddressDisplay">192.168.1.0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Broadcast Address</span>
                        <strong id="broadcastAddress">192.168.1.255</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>First Usable IP</span>
                        <strong id="firstUsable">192.168.1.1</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Last Usable IP</span>
                        <strong id="lastUsable">192.168.1.254</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>IP Class</span>
                        <strong id="ipClass">Class C (Private)</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Subnet Information</h3>
                    <div class="breakdown-item">
                        <span>Total IP Addresses</span>
                        <strong id="totalIPs">256</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Usable Hosts</span>
                        <strong id="usableHostsDetailed">254</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Wildcard Mask</span>
                        <strong id="wildcardMask">0.0.0.255</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Binary Subnet Mask</span>
                        <strong id="binarySubnet">11111111.11111111.11111111.00000000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>IP Address in Binary</span>
                        <strong id="binaryIP">11000000.10101000.00000001.00000001</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Network/Host Breakdown</h3>
                    <div class="breakdown-item" style="flex-direction: column; align-items: flex-start;">
                        <span>Network Bits: <strong id="networkBits">24</strong> | Host Bits: <strong id="hostBits">8</strong></span>
                        <div class="binary-grid" id="binaryVisualization">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Subnet Calculations</h3>
                    <div class="breakdown-item">
                        <span>Required Subnets</span>
                        <strong id="requiredSubnets">1</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Required Hosts per Subnet</span>
                        <strong id="requiredHosts">254</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Subnet Bits</span>
                        <strong id="subnetBits">0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Host Bits per Subnet</span>
                        <strong id="hostBitsPerSubnet">8</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>New Subnet Mask</span>
                        <strong id="newSubnetMask">255.255.255.0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Subnets Possible</span>
                        <strong id="subnetsPossible">1</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Generated Subnets</h3>
                    <div class="subnet-grid" id="subnetList">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> This calculator provides theoretical network information. Actual network configuration may vary based on routing protocols, network policies, and specific implementation details.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🌐 IP Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced IP address and subnet calculations</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('ipForm');
        
        // IP address validation regex
        const ipRegex = /^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
        
        // CIDR to subnet mask mapping
        const cidrToMask = {
            0: "0.0.0.0",
            1: "128.0.0.0",
            2: "192.0.0.0",
            3: "224.0.0.0",
            4: "240.0.0.0",
            5: "248.0.0.0",
            6: "252.0.0.0",
            7: "254.0.0.0",
            8: "255.0.0.0",
            9: "255.128.0.0",
            10: "255.192.0.0",
            11: "255.224.0.0",
            12: "255.240.0.0",
            13: "255.248.0.0",
            14: "255.252.0.0",
            15: "255.254.0.0",
            16: "255.255.0.0",
            17: "255.255.128.0",
            18: "255.255.192.0",
            19: "255.255.224.0",
            20: "255.255.240.0",
            21: "255.255.248.0",
            22: "255.255.252.0",
            23: "255.255.254.0",
            24: "255.255.255.0",
            25: "255.255.255.128",
            26: "255.255.255.192",
            27: "255.255.255.224",
            28: "255.255.255.240",
            29: "255.255.255.248",
            30: "255.255.255.252",
            31: "255.255.255.254",
            32: "255.255.255.255"
        };
        
        // Subnet mask to CIDR mapping
        const maskToCidr = {
            "0.0.0.0": 0,
            "128.0.0.0": 1,
            "192.0.0.0": 2,
            "224.0.0.0": 3,
            "240.0.0.0": 4,
            "248.0.0.0": 5,
            "252.0.0.0": 6,
            "254.0.0.0": 7,
            "255.0.0.0": 8,
            "255.128.0.0": 9,
            "255.192.0.0": 10,
            "255.224.0.0": 11,
            "255.240.0.0": 12,
            "255.248.0.0": 13,
            "255.252.0.0": 14,
            "255.254.0.0": 15,
            "255.255.0.0": 16,
            "255.255.128.0": 17,
            "255.255.192.0": 18,
            "255.255.224.0": 19,
            "255.255.240.0": 20,
            "255.255.248.0": 21,
            "255.255.252.0": 22,
            "255.255.254.0": 23,
            "255.255.255.0": 24,
            "255.255.255.128": 25,
            "255.255.255.192": 26,
            "255.255.255.224": 27,
            "255.255.255.240": 28,
            "255.255.255.248": 29,
            "255.255.255.252": 30,
            "255.255.255.254": 31,
            "255.255.255.255": 32
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateIPInfo();
        });

        function setPreset(ip, cidr) {
            document.getElementById('ipAddress').value = ip;
            document.getElementById('subnetMask').value = cidr;
            document.getElementById('maskType').value = 'cidr';
            
            // Visual feedback
            document.querySelectorAll('.speed-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateIPInfo();
        }

        function calculateIPInfo() {
            // Get inputs
            const ipAddress = document.getElementById('ipAddress').value.trim();
            const subnetMaskInput = document.getElementById('subnetMask').value.trim();
            const maskType = document.getElementById('maskType').value;
            const calculateSubnets = parseInt(document.getElementById('calculateSubnets').value);
            const hostsPerSubnet = parseInt(document.getElementById('hostsPerSubnet').value);
            
            // Validate IP address
            if (!ipRegex.test(ipAddress)) {
                alert('Please enter a valid IP address');
                return;
            }
            
            let cidr, subnetMask;
            
            // Parse subnet mask input
            if (maskType === 'cidr') {
                cidr = parseInt(subnetMaskInput);
                if (isNaN(cidr) || cidr < 0 || cidr > 32) {
                    alert('Please enter a valid CIDR notation (0-32)');
                    return;
                }
                subnetMask = cidrToMask[cidr];
            } else {
                // Subnet mask
                if (!ipRegex.test(subnetMaskInput)) {
                    alert('Please enter a valid subnet mask');
                    return;
                }
                subnetMask = subnetMaskInput;
                cidr = maskToCidr[subnetMask];
                if (cidr === undefined) {
                    alert('Please enter a valid subnet mask');
                    return;
                }
            }
            
            // Convert IP and subnet mask to arrays
            const ipParts = ipAddress.split('.').map(Number);
            const maskParts = subnetMask.split('.').map(Number);
            
            // Calculate network address
            const networkParts = ipParts.map((part, i) => part & maskParts[i]);
            const networkAddress = networkParts.join('.');
            
            // Calculate broadcast address
            const wildcardParts = maskParts.map(part => 255 - part);
            const broadcastParts = networkParts.map((part, i) => part | wildcardParts[i]);
            const broadcastAddress = broadcastParts.join('.');
            
            // Calculate first and last usable IPs
            const firstUsableParts = [...networkParts];
            firstUsableParts[3] += 1;
            const firstUsable = firstUsableParts.join('.');
            
            const lastUsableParts = [...broadcastParts];
            lastUsableParts[3] -= 1;
            const lastUsable = lastUsableParts.join('.');
            
            // Calculate total IPs and usable hosts
            const totalIPs = Math.pow(2, 32 - cidr);
            const usableHosts = totalIPs - 2;
            
            // Determine IP class
            const firstOctet = ipParts[0];
            let ipClass, ipType;
            
            if (firstOctet >= 1 && firstOctet <= 126) {
                ipClass = "Class A";
            } else if (firstOctet >= 128 && firstOctet <= 191) {
                ipClass = "Class B";
            } else if (firstOctet >= 192 && firstOctet <= 223) {
                ipClass = "Class C";
            } else if (firstOctet >= 224 && firstOctet <= 239) {
                ipClass = "Class D (Multicast)";
            } else {
                ipClass = "Class E (Experimental)";
            }
            
            // Determine if private or public
            if (
                (firstOctet === 10) ||
                (firstOctet === 172 && ipParts[1] >= 16 && ipParts[1] <= 31) ||
                (firstOctet === 192 && ipParts[1] === 168)
            ) {
                ipType = "Private";
            } else if (
                (firstOctet === 127) ||
                (firstOctet === 169 && ipParts[1] === 254)
            ) {
                ipType = "Special";
            } else {
                ipType = "Public";
            }
            
            // Calculate binary representations
            const binaryIP = ipParts.map(part => part.toString(2).padStart(8, '0')).join('.');
            const binarySubnet = maskParts.map(part => part.toString(2).padStart(8, '0')).join('.');
            
            // Calculate wildcard mask
            const wildcardMask = wildcardParts.join('.');
            
            // Calculate subnet information
            const hostBits = 32 - cidr;
            
            // Calculate subnetting information
            const requiredSubnets = calculateSubnets;
            const requiredHosts = hostsPerSubnet;
            
            // Calculate subnet bits needed
            const subnetBits = Math.ceil(Math.log2(requiredSubnets));
            const hostBitsPerSubnet = Math.floor(Math.log2(requiredHosts + 2));
            
            const newCidr = cidr + subnetBits;
            const newSubnetMask = cidrToMask[newCidr];
            const subnetsPossible = Math.pow(2, subnetBits);
            
            // Generate subnet list
            const subnetList = generateSubnets(networkAddress, cidr, subnetBits);
            
            // Update UI
            document.getElementById('networkAddress').textContent = networkAddress;
            document.getElementById('usableHosts').textContent = usableHosts;
            document.getElementById('subnetMaskDisplay').textContent = subnetMask;
            document.getElementById('cidrNotation').textContent = '/' + cidr;
            
            document.getElementById('ipAddressDisplay').textContent = ipAddress;
            document.getElementById('networkAddressDisplay').textContent = networkAddress;
            document.getElementById('broadcastAddress').textContent = broadcastAddress;
            document.getElementById('firstUsable').textContent = firstUsable;
            document.getElementById('lastUsable').textContent = lastUsable;
            document.getElementById('ipClass').textContent = `${ipClass} (${ipType})`;
            
            document.getElementById('totalIPs').textContent = totalIPs;
            document.getElementById('usableHostsDetailed').textContent = usableHosts;
            document.getElementById('wildcardMask').textContent = wildcardMask;
            document.getElementById('binarySubnet').textContent = binarySubnet;
            document.getElementById('binaryIP').textContent = binaryIP;
            
            document.getElementById('networkBits').textContent = cidr;
            document.getElementById('hostBits').textContent = hostBits;
            
            document.getElementById('requiredSubnets').textContent = requiredSubnets;
            document.getElementById('requiredHosts').textContent = requiredHosts;
            document.getElementById('subnetBits').textContent = subnetBits;
            document.getElementById('hostBitsPerSubnet').textContent = hostBitsPerSubnet;
            document.getElementById('newSubnetMask').textContent = newSubnetMask;
            document.getElementById('subnetsPossible').textContent = subnetsPossible;
            
            // Update binary visualization
            updateBinaryVisualization(cidr);
            
            // Update subnet list
            updateSubnetList(subnetList);
        }
        
        function generateSubnets(networkAddress, cidr, subnetBits) {
            const subnets = [];
            const networkParts = networkAddress.split('.').map(Number);
            const subnetSize = Math.pow(2, 32 - cidr - subnetBits);
            
            for (let i = 0; i < Math.pow(2, subnetBits); i++) {
                const subnetNumber = i * subnetSize;
                const subnetIP = calculateIPFromNumber(networkParts, subnetNumber);
                const broadcastIP = calculateIPFromNumber(networkParts, subnetNumber + subnetSize - 1);
                
                const firstUsable = calculateIPFromNumber(networkParts, subnetNumber + 1);
                const lastUsable = calculateIPFromNumber(networkParts, subnetNumber + subnetSize - 2);
                
                subnets.push({
                    network: subnetIP,
                    broadcast: broadcastIP,
                    firstUsable: firstUsable,
                    lastUsable: lastUsable,
                    size: subnetSize
                });
            }
            
            return subnets;
        }
        
        function calculateIPFromNumber(ipParts, number) {
            const result = [...ipParts];
            let remaining = number;
            
            for (let i = 3; i >= 0; i--) {
                result[i] += remaining % 256;
                remaining = Math.floor(remaining / 256);
                if (result[i] > 255) {
                    result[i] %= 256;
                    remaining += 1;
                }
            }
            
            return result.join('.');
        }
        
        function updateBinaryVisualization(cidr) {
            const binaryGrid = document.getElementById('binaryVisualization');
            binaryGrid.innerHTML = '';
            
            for (let i = 0; i < 32; i++) {
                const binaryItem = document.createElement('div');
                binaryItem.className = 'binary-item';
                
                if (i < cidr) {
                    binaryItem.classList.add('network');
                    binaryItem.textContent = '1';
                } else {
                    binaryItem.classList.add('host');
                    binaryItem.textContent = '0';
                }
                
                // Add dots after every 8 bits
                if (i > 0 && i % 8 === 0) {
                    const dot = document.createElement('div');
                    dot.style.gridColumn = 'span 4';
                    dot.textContent = '.';
                    dot.style.textAlign = 'center';
                    binaryGrid.appendChild(dot);
                }
                
                binaryGrid.appendChild(binaryItem);
            }
        }
        
        function updateSubnetList(subnets) {
            const subnetList = document.getElementById('subnetList');
            subnetList.innerHTML = '';
            
            // Limit to first 10 subnets for performance
            const displaySubnets = subnets.slice(0, 10);
            
            displaySubnets.forEach((subnet, index) => {
                const subnetCard = document.createElement('div');
                subnetCard.className = 'subnet-card';
                
                subnetCard.innerHTML = `
                    <h4>Subnet ${index + 1}</h4>
                    <div><strong>Network:</strong> ${subnet.network}</div>
                    <div><strong>Broadcast:</strong> ${subnet.broadcast}</div>
                    <div><strong>First Usable:</strong> ${subnet.firstUsable}</div>
                    <div><strong>Last Usable:</strong> ${subnet.lastUsable}</div>
                    <div><strong>Size:</strong> ${subnet.size} IPs</div>
                `;
                
                subnetList.appendChild(subnetCard);
            });
            
            if (subnets.length > 10) {
                const moreCard = document.createElement('div');
                moreCard.className = 'subnet-card';
                moreCard.innerHTML = `<h4>And ${subnets.length - 10} more subnets...</h4>`;
                subnetList.appendChild(moreCard);
            }
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateIPInfo();
        });
    </script>
</body>
</html>
