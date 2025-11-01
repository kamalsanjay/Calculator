<?php
/**
 * Subnet Calculator
 * File: electronics/subnet-calculator.php
 * Description: Advanced subnet calculator for network planning and IP address management
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subnet Calculator - Network IP Address & Subnet Mask Calculator</title>
    <meta name="description" content="Advanced subnet calculator for IP address planning, subnet masking, CIDR notation, and network analysis.">
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh; 
            padding: 20px; 
        }
        
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
        }
        
        .header { 
            background: rgba(255,255,255,0.95); 
            padding: 25px; 
            border-radius: 15px 15px 0 0; 
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1); 
            text-align: center; 
            margin-bottom: 0;
        }
        
        .header h1 { 
            color: #2c3e50; 
            font-size: 2.2rem; 
            margin-bottom: 10px; 
        }
        
        .header p { 
            color: #7f8c8d; 
            font-size: 1.1rem; 
            opacity: 0.9; 
        }
        
        .calculator-wrapper { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 25px; 
            background: white; 
            padding: 30px; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.12); 
            border-radius: 0 0 15px 15px;
        }
        
        .calculator-section h2, .results-section h2 { 
            color: #667eea; 
            margin-bottom: 20px; 
            font-size: 1.6rem; 
        }
        
        .form-group { 
            margin-bottom: 18px; 
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
            font-size: 0.85em; 
        }
        
        .btn { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 14px 25px; 
            border: none; 
            border-radius: 8px; 
            font-size: 16px; 
            font-weight: 600; 
            cursor: pointer; 
            width: 100%; 
            transition: all 0.3s; 
            margin-top: 10px;
        }
        
        .btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); 
        }
        
        .result-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 20px; 
            border-radius: 10px; 
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
            font-size: 1.1rem; 
            opacity: 0.9; 
            margin-bottom: 10px; 
            font-weight: 400; 
            position: relative; 
            z-index: 1; 
        }
        
        .result-card .amount { 
            font-size: 2.2rem; 
            font-weight: bold; 
            position: relative; 
            z-index: 1; 
        }
        
        .metric-grid { 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            gap: 12px; 
            margin-bottom: 20px; 
        }
        
        .metric-card { 
            background: #f8f9fa; 
            padding: 15px; 
            border-radius: 10px; 
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
            font-size: 0.85rem; 
            margin-bottom: 8px; 
            font-weight: 400; 
        }
        
        .metric-card .value { 
            color: #667eea; 
            font-size: 1.4rem; 
            font-weight: bold; 
        }
        
        .breakdown { 
            background: #f8f9fa; 
            padding: 18px; 
            border-radius: 10px; 
            margin-bottom: 20px; 
        }
        
        .breakdown h3 { 
            color: #667eea; 
            margin-bottom: 15px; 
            font-size: 1.2rem; 
        }
        
        .breakdown-item { 
            display: flex; 
            justify-content: space-between; 
            padding: 10px 0; 
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
        
        .preset-buttons { 
            display: grid; 
            grid-template-columns: repeat(3, 1fr); 
            gap: 8px; 
            margin-top: 10px; 
        }
        
        .preset-btn { 
            padding: 10px 8px; 
            background: #f0f0f0; 
            border: 2px solid #e0e0e0; 
            border-radius: 6px; 
            cursor: pointer; 
            text-align: center; 
            font-size: 0.8rem; 
            transition: all 0.3s; 
        }
        
        .preset-btn:hover { 
            background: #667eea; 
            color: white; 
            border-color: #667eea; 
        }
        
        .preset-btn.active { 
            background: #667eea; 
            color: white; 
            border-color: #667eea; 
        }
        
        .info-box { 
            background: #e8f2ff; 
            border-left: 4px solid #667eea; 
            padding: 15px; 
            margin: 20px 0; 
            border-radius: 5px; 
            font-size: 0.9rem;
        }
        
        .info-box strong { 
            color: #667eea; 
        }
        
        .footer { 
            background: rgba(255,255,255,0.95); 
            padding: 20px; 
            border-radius: 0 0 15px 15px; 
            text-align: center; 
            color: #7f8c8d; 
            margin-top: 0;
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .calculator-wrapper { 
                grid-template-columns: 1fr; 
                padding: 25px; 
                gap: 20px;
            }
            
            .result-card .amount { 
                font-size: 2rem; 
            }
            
            .metric-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .header h1 { 
                font-size: 1.8rem; 
            }
            
            .header p {
                font-size: 1rem;
            }
            
            .calculator-wrapper {
                padding: 20px;
            }
            
            .metric-grid { 
                grid-template-columns: repeat(2, 1fr); 
            }
            
            .preset-buttons { 
                grid-template-columns: repeat(2, 1fr); 
            }
            
            .calculator-section h2, .results-section h2 {
                font-size: 1.4rem;
            }
        }
        
        @media (max-width: 480px) {
            .header h1 { 
                font-size: 1.5rem; 
            }
            
            .header p { 
                font-size: 0.9rem; 
            }
            
            .result-card .amount { 
                font-size: 1.8rem; 
            }
            
            body { 
                padding: 10px; 
            }
            
            .calculator-wrapper {
                padding: 15px;
            }
            
            .metric-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .metric-card .value {
                font-size: 1.2rem;
            }
            
            .preset-buttons {
                grid-template-columns: 1fr;
            }
            
            .breakdown {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌐 Subnet Calculator</h1>
            <p>Advanced IP address subnet calculator for network planning and management</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Network Parameters</h2>
                <form id="subnetForm">
                    <div class="form-group">
                        <label for="ipAddress">IP Address</label>
                        <input type="text" id="ipAddress" value="192.168.1.0" required pattern="^(\d{1,3}\.){3}\d{1,3}$">
                        <small>Enter the IP address (e.g., 192.168.1.0)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="subnetMethod">Subnet Specification Method</label>
                        <select id="subnetMethod" style="padding: 12px;">
                            <option value="cidr">CIDR Notation</option>
                            <option value="mask">Subnet Mask</option>
                            <option value="hosts">Number of Hosts</option>
                            <option value="subnets">Number of Subnets</option>
                        </select>
                        <small>Choose how to specify the subnet</small>
                    </div>
                    
                    <div class="form-group" id="cidrGroup">
                        <label for="cidr">CIDR Notation</label>
                        <input type="number" id="cidr" value="24" min="1" max="32" step="1" required>
                        <small>Slash notation (e.g., /24 for 255.255.255.0)</small>
                    </div>
                    
                    <div class="form-group" id="maskGroup" style="display: none;">
                        <label for="subnetMask">Subnet Mask</label>
                        <input type="text" id="subnetMask" value="255.255.255.0" pattern="^(\d{1,3}\.){3}\d{1,3}$">
                        <small>Enter subnet mask (e.g., 255.255.255.0)</small>
                    </div>
                    
                    <div class="form-group" id="hostsGroup" style="display: none;">
                        <label for="requiredHosts">Required Hosts per Subnet</label>
                        <input type="number" id="requiredHosts" value="254" min="2" step="1">
                        <small>Number of hosts needed (including network and broadcast)</small>
                    </div>
                    
                    <div class="form-group" id="subnetsGroup" style="display: none;">
                        <label for="requiredSubnets">Required Number of Subnets</label>
                        <input type="number" id="requiredSubnets" value="4" min="2" step="1">
                        <small>Number of subnets to create</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Presets</label>
                        <div class="preset-buttons">
                            <div class="preset-btn" onclick="setPreset('classC')">Class C</div>
                            <div class="preset-btn" onclick="setPreset('classB')">Class B</div>
                            <div class="preset-btn" onclick="setPreset('classA')">Class A</div>
                            <div class="preset-btn" onclick="setPreset('home')">Home Network</div>
                            <div class="preset-btn" onclick="setPreset('small')">Small Business</div>
                            <div class="preset-btn" onclick="setPreset('enterprise')">Enterprise</div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Subnet</button>
                </form>
                
                <div class="info-box">
                    <strong>CIDR Notation:</strong> Classless Inter-Domain Routing (CIDR) is a method for allocating IP addresses and IP routing. The notation is a slash at the end of the address followed by the number of bits representing the network portion.
                </div>
            </div>

            <div class="results-section">
                <h2>Subnet Analysis</h2>
                
                <div class="result-card">
                    <h3>Usable Hosts per Subnet</h3>
                    <div class="amount" id="usableHosts">254</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total IPs</h4>
                        <div class="value" id="totalIPs">256</div>
                    </div>
                    <div class="metric-card">
                        <h4>Network IP</h4>
                        <div class="value" id="networkIP">192.168.1.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Broadcast IP</h4>
                        <div class="value" id="broadcastIP">192.168.1.255</div>
                    </div>
                    <div class="metric-card">
                        <h4>Subnet Mask</h4>
                        <div class="value" id="subnetMaskResult">255.255.255.0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Network Information</h3>
                    <div class="breakdown-item">
                        <span>IP Address</span>
                        <strong id="ipAddressDisplay">192.168.1.0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CIDR Notation</span>
                        <strong id="cidrDisplay">/24</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>IP Class</span>
                        <strong id="ipClass">Class C</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Network Address</span>
                        <strong id="networkAddress">192.168.1.0</strong>
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
                        <span>Broadcast Address</span>
                        <strong id="broadcastAddress">192.168.1.255</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> The first IP in each subnet is the network address, and the last IP is the broadcast address. These cannot be assigned to hosts.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🌐 Subnet Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced IP subnet calculation and network planning tool</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('subnetForm');
        const subnetMethod = document.getElementById('subnetMethod');

        // Preset configurations
        const presets = {
            classC: {
                ipAddress: '192.168.1.0',
                cidr: 24,
                subnetMask: '255.255.255.0'
            },
            classB: {
                ipAddress: '172.16.0.0',
                cidr: 16,
                subnetMask: '255.255.0.0'
            },
            classA: {
                ipAddress: '10.0.0.0',
                cidr: 8,
                subnetMask: '255.0.0.0'
            },
            home: {
                ipAddress: '192.168.0.0',
                cidr: 24,
                subnetMask: '255.255.255.0'
            },
            small: {
                ipAddress: '192.168.0.0',
                cidr: 23,
                subnetMask: '255.255.254.0'
            },
            enterprise: {
                ipAddress: '10.0.0.0',
                cidr: 16,
                subnetMask: '255.255.0.0'
            }
        };

        // Update form based on subnet method
        subnetMethod.addEventListener('change', function() {
            updateFormVisibility();
        });

        function updateFormVisibility() {
            const method = subnetMethod.value;
            
            // Hide all input groups first
            document.getElementById('cidrGroup').style.display = 'none';
            document.getElementById('maskGroup').style.display = 'none';
            document.getElementById('hostsGroup').style.display = 'none';
            document.getElementById('subnetsGroup').style.display = 'none';
            
            // Show selected group
            document.getElementById(method + 'Group').style.display = 'block';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateSubnet();
        });

        function setPreset(presetName) {
            const preset = presets[presetName];
            
            document.getElementById('ipAddress').value = preset.ipAddress;
            document.getElementById('cidr').value = preset.cidr;
            document.getElementById('subnetMask').value = preset.subnetMask;
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateSubnet();
        }

        function calculateSubnet() {
            // Get inputs
            const ipAddress = document.getElementById('ipAddress').value;
            const method = subnetMethod.value;
            let cidr, subnetMask;

            // Determine CIDR based on method
            switch(method) {
                case 'cidr':
                    cidr = parseInt(document.getElementById('cidr').value);
                    subnetMask = cidrToMask(cidr);
                    break;
                case 'mask':
                    subnetMask = document.getElementById('subnetMask').value;
                    cidr = maskToCidr(subnetMask);
                    break;
                case 'hosts':
                    const requiredHosts = parseInt(document.getElementById('requiredHosts').value);
                    cidr = 32 - Math.ceil(Math.log2(requiredHosts + 2));
                    subnetMask = cidrToMask(cidr);
                    break;
                case 'subnets':
                    const requiredSubnets = parseInt(document.getElementById('requiredSubnets').value);
                    const ipClass = getIPClass(ipAddress);
                    const baseCidr = ipClass === 'A' ? 8 : ipClass === 'B' ? 16 : 24;
                    cidr = baseCidr + Math.ceil(Math.log2(requiredSubnets));
                    subnetMask = cidrToMask(cidr);
                    break;
            }

            // Validate inputs
            if (!isValidIP(ipAddress) || !isValidIP(subnetMask)) {
                alert('Please enter valid IP addresses');
                return;
            }

            // Calculate network information
            const networkIP = calculateNetworkIP(ipAddress, subnetMask);
            const broadcastIP = calculateBroadcastIP(ipAddress, subnetMask);
            const totalIPs = Math.pow(2, 32 - cidr);
            const usableHosts = totalIPs - 2;
            const ipClass = getIPClass(ipAddress);

            // Calculate first and last usable IPs
            const firstUsable = incrementIP(networkIP, 1);
            const lastUsable = incrementIP(broadcastIP, -1);

            // Update UI
            document.getElementById('usableHosts').textContent = usableHosts.toLocaleString();
            document.getElementById('totalIPs').textContent = totalIPs.toLocaleString();
            document.getElementById('networkIP').textContent = networkIP;
            document.getElementById('broadcastIP').textContent = broadcastIP;
            document.getElementById('subnetMaskResult').textContent = subnetMask;

            document.getElementById('ipAddressDisplay').textContent = ipAddress;
            document.getElementById('cidrDisplay').textContent = '/' + cidr;
            document.getElementById('ipClass').textContent = 'Class ' + ipClass;
            document.getElementById('networkAddress').textContent = networkIP;
            document.getElementById('firstUsable').textContent = firstUsable;
            document.getElementById('lastUsable').textContent = lastUsable;
            document.getElementById('broadcastAddress').textContent = broadcastIP;
        }

        function cidrToMask(cidr) {
            const mask = [];
            for (let i = 0; i < 4; i++) {
                const bits = Math.min(8, Math.max(0, cidr - i * 8));
                mask.push(256 - Math.pow(2, 8 - bits));
            }
            return mask.join('.');
        }

        function maskToCidr(mask) {
            const octets = mask.split('.').map(Number);
            let cidr = 0;
            for (const octet of octets) {
                if (octet === 255) {
                    cidr += 8;
                } else {
                    let bits = 0;
                    let value = octet;
                    while (value > 0) {
                        bits++;
                        value = value << 1 & 255;
                    }
                    cidr += bits;
                    break;
                }
            }
            return cidr;
        }

        function isValidIP(ip) {
            const octets = ip.split('.').map(Number);
            return octets.length === 4 && octets.every(octet => octet >= 0 && octet <= 255);
        }

        function getIPClass(ip) {
            const firstOctet = parseInt(ip.split('.')[0]);
            if (firstOctet <= 127) return 'A';
            if (firstOctet <= 191) return 'B';
            if (firstOctet <= 223) return 'C';
            if (firstOctet <= 239) return 'D';
            return 'E';
        }

        function calculateNetworkIP(ip, mask) {
            const ipOctets = ip.split('.').map(Number);
            const maskOctets = mask.split('.').map(Number);
            const networkOctets = ipOctets.map((octet, i) => octet & maskOctets[i]);
            return networkOctets.join('.');
        }

        function calculateBroadcastIP(ip, mask) {
            const ipOctets = ip.split('.').map(Number);
            const maskOctets = mask.split('.').map(Number);
            const wildcardOctets = maskOctets.map(octet => 255 - octet);
            const broadcastOctets = ipOctets.map((octet, i) => octet | wildcardOctets[i]);
            return broadcastOctets.join('.');
        }

        function incrementIP(ip, increment) {
            const octets = ip.split('.').map(Number);
            let value = (octets[0] << 24) + (octets[1] << 16) + (octets[2] << 8) + octets[3];
            value += increment;
            return [
                (value >>> 24) & 255,
                (value >>> 16) & 255,
                (value >>> 8) & 255,
                value & 255
            ].join('.');
        }

        // Initialize
        window.addEventListener('load', function() {
            updateFormVisibility();
            calculateSubnet();
        });
    </script>
</body>
</html>