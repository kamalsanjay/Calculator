<?php
/**
 * Bandwidth Calculator
 * File: electronics/bandwidth-calculator.php
 * Description: Advanced bandwidth calculator for network planning and capacity analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandwidth Calculator - Network Capacity & Speed Analysis</title>
    <meta name="description" content="Advanced bandwidth calculator for network planning, capacity analysis, speed requirements, and bandwidth optimization.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #4facfe; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #4facfe; box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3); position: relative; overflow: hidden; }
        .result-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 0.8; } }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; position: relative; z-index: 1; }
        .result-card .amount { font-size: 3rem; font-weight: bold; position: relative; z-index: 1; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #4facfe; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #4facfe; font-size: 1.8rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #4facfe; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .progress-bar { background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%); width: 0%; transition: width 1s ease-out; }
        
        .info-box { background: #e8f2ff; border-left: 4px solid #4facfe; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #4facfe; }
        
        .speed-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 8px; margin-top: 10px; }
        .speed-btn { padding: 8px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .speed-btn:hover { background: #4facfe; color: white; border-color: #4facfe; }
        .speed-btn.active { background: #4facfe; color: white; border-color: #4facfe; }
        
        .usage-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 8px; margin-top: 10px; }
        .usage-btn { padding: 10px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .usage-btn:hover { background: #4facfe; color: white; border-color: #4facfe; }
        .usage-btn.active { background: #4facfe; color: white; border-color: #4facfe; }
        
        .scenario-section { margin-top: 25px; padding-top: 25px; border-top: 2px solid #e0e0e0; }
        
        .scenario-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .scenario-item:last-child { border-bottom: none; }
        .scenario-details { flex: 1; }
        .scenario-bandwidth { font-weight: bold; color: #4facfe; }
        
        .chart-container { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .chart { height: 200px; position: relative; display: flex; align-items: flex-end; justify-content: space-between; padding: 0 10px; }
        .chart-bar { width: 30px; background: linear-gradient(to top, #4facfe, #00f2fe); border-radius: 4px 4px 0 0; position: relative; transition: height 0.5s ease; }
        .chart-label { position: absolute; bottom: -25px; left: 0; right: 0; text-align: center; font-size: 0.8rem; color: #666; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .speed-preset, .usage-preset { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Bandwidth Calculator</h1>
            <p>Calculate network bandwidth requirements, capacity planning, and speed analysis</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Bandwidth Parameters</h2>
                <form id="bandwidthForm">
                    <div class="form-group">
                        <label for="bandwidth">Available Bandwidth</label>
                        <div class="input-group">
                            <input type="number" id="bandwidth" value="100" min="0.001" step="0.001" required>
                            <select id="bandwidthUnit" style="padding: 12px;">
                                <option value="bps">bps</option>
                                <option value="Kbps">Kbps</option>
                                <option value="Mbps" selected>Mbps</option>
                                <option value="Gbps">Gbps</option>
                            </select>
                        </div>
                        <small>Your total available bandwidth</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Bandwidth Presets</label>
                        <div class="speed-preset">
                            <div class="speed-btn" onclick="setBandwidth(10, 'Mbps')">10 Mbps</div>
                            <div class="speed-btn" onclick="setBandwidth(50, 'Mbps')">50 Mbps</div>
                            <div class="speed-btn" onclick="setBandwidth(100, 'Mbps')">100 Mbps</div>
                            <div class="speed-btn" onclick="setBandwidth(250, 'Mbps')">250 Mbps</div>
                            <div class="speed-btn" onclick="setBandwidth(500, 'Mbps')">500 Mbps</div>
                            <div class="speed-btn" onclick="setBandwidth(1, 'Gbps')">1 Gbps</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="concurrentUsers">Concurrent Users</label>
                        <input type="number" id="concurrentUsers" value="10" min="1" max="1000" step="1">
                        <small>Number of simultaneous users</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="peakUsage">Peak Usage Factor (%)</label>
                        <input type="number" id="peakUsage" value="80" min="1" max="100" step="1">
                        <small>Expected peak usage percentage (50-90% typical)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="overhead">Protocol Overhead (%)</label>
                        <input type="number" id="overhead" value="15" min="0" max="50" step="1">
                        <small>Network protocol overhead (10-20% typical)</small>
                    </div>
                    
                    <div class="scenario-section">
                        <h3>Usage Scenarios</h3>
                        <div class="form-group">
                            <label>Quick Usage Presets</label>
                            <div class="usage-preset">
                                <div class="usage-btn" onclick="setUsageScenario('basic')">Basic Browsing</div>
                                <div class="usage-btn" onclick="setUsageScenario('office')">Office Work</div>
                                <div class="usage-btn" onclick="setUsageScenario('streaming')">Video Streaming</div>
                                <div class="usage-btn" onclick="setUsageScenario('gaming')">Online Gaming</div>
                                <div class="usage-btn" onclick="setUsageScenario('heavy')">Heavy Usage</div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="scenarios">Custom Scenarios (JSON)</label>
                            <textarea id="scenarios" rows="6" placeholder='[{"name": "Web Browsing", "bandwidth": 1, "users": 5}, {"name": "Video Streaming", "bandwidth": 5, "users": 3}]'>[{"name": "Web Browsing", "bandwidth": 1, "users": 5}, {"name": "Video Streaming", "bandwidth": 5, "users": 3}, {"name": "File Download", "bandwidth": 10, "users": 2}, {"name": "Video Conferencing", "bandwidth": 2, "users": 4}]</textarea>
                            <small>Define custom usage scenarios in JSON format</small>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Bandwidth Analysis</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Bandwidth Analysis</h2>
                
                <div class="result-card">
                    <h3>Available Bandwidth per User</h3>
                    <div class="amount" id="bandwidthPerUser">10 Mbps</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Bandwidth</h4>
                        <div class="value" id="totalBandwidth">100 Mbps</div>
                    </div>
                    <div class="metric-card">
                        <h4>Effective Bandwidth</h4>
                        <div class="value" id="effectiveBandwidth">68 Mbps</div>
                    </div>
                    <div class="metric-card">
                        <h4>Utilization</h4>
                        <div class="value" id="utilization">80%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Bandwidth Details</h3>
                    <div class="breakdown-item">
                        <span>Available Bandwidth</span>
                        <strong id="availableBandwidthDisplay">100 Mbps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Concurrent Users</span>
                        <strong id="usersDisplay">10 users</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Peak Usage Factor</span>
                        <strong id="peakDisplay">80%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Protocol Overhead</span>
                        <strong id="overheadDisplay">15%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Effective Bandwidth</span>
                        <strong id="effectiveDisplay">68 Mbps</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Bandwidth Conversions</h3>
                    <div class="breakdown-item">
                        <span>Bits per Second</span>
                        <strong id="bps">100,000,000 bps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Kilobits per Second</span>
                        <strong id="kbps">100,000 Kbps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Megabits per Second</span>
                        <strong id="mbps">100 Mbps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gigabits per Second</span>
                        <strong id="gbps">0.1 Gbps</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Data Capacity</h3>
                    <div class="breakdown-item">
                        <span>Per Second</span>
                        <strong id="perSecond">12.5 MB</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Per Minute</span>
                        <strong id="perMinute">750 MB</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Per Hour</span>
                        <strong id="perHour">45 GB</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Per Day</span>
                        <strong id="perDay">1,080 GB</strong>
                    </div>
                </div>

                <div class="chart-container">
                    <h3>Bandwidth Utilization</h3>
                    <div class="chart" id="bandwidthChart">
                        <div class="chart-bar" style="height: 80%">
                            <div class="chart-label">Peak</div>
                        </div>
                        <div class="chart-bar" style="height: 60%">
                            <div class="chart-label">Average</div>
                        </div>
                        <div class="chart-bar" style="height: 40%">
                            <div class="chart-label">Idle</div>
                        </div>
                        <div class="chart-bar" style="height: 90%">
                            <div class="chart-label">Max</div>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Usage Scenarios</h3>
                    <div id="scenarioResults">
                        <!-- Scenario results will be populated here -->
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> Actual bandwidth requirements may vary based on application behavior, network conditions, and user behavior patterns. Consider implementing Quality of Service (QoS) for critical applications.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📊 Bandwidth Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced network bandwidth analysis and capacity planning</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('bandwidthForm');
        let chartInterval;

        // Bandwidth conversion factors to bps
        const bandwidthUnits = {
            bps: 1,
            Kbps: 1000,
            Mbps: 1000000,
            Gbps: 1000000000
        };

        // Usage scenarios presets
        const usageScenarios = {
            basic: [
                {name: "Web Browsing", bandwidth: 1, users: 8},
                {name: "Email", bandwidth: 0.5, users: 2}
            ],
            office: [
                {name: "Web Browsing", bandwidth: 1, users: 6},
                {name: "Email", bandwidth: 0.5, users: 3},
                {name: "Video Conferencing", bandwidth: 2, users: 3},
                {name: "File Sharing", bandwidth: 3, users: 2}
            ],
            streaming: [
                {name: "HD Video Streaming", bandwidth: 5, users: 4},
                {name: "4K Video Streaming", bandwidth: 25, users: 2},
                {name: "Music Streaming", bandwidth: 0.32, users: 4}
            ],
            gaming: [
                {name: "Online Gaming", bandwidth: 3, users: 4},
                {name: "Game Downloads", bandwidth: 10, users: 2},
                {name: "Voice Chat", bandwidth: 0.1, users: 4}
            ],
            heavy: [
                {name: "4K Video Streaming", bandwidth: 25, users: 3},
                {name: "Large File Downloads", bandwidth: 15, users: 3},
                {name: "Video Conferencing", bandwidth: 4, users: 3},
                {name: "Online Backup", bandwidth: 10, users: 1}
            ]
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBandwidth();
        });

        function setBandwidth(value, unit) {
            document.getElementById('bandwidth').value = value;
            document.getElementById('bandwidthUnit').value = unit;
            
            // Visual feedback
            document.querySelectorAll('.speed-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateBandwidth();
        }

        function setUsageScenario(scenario) {
            const scenarios = usageScenarios[scenario];
            document.getElementById('scenarios').value = JSON.stringify(scenarios, null, 2);
            
            // Visual feedback
            document.querySelectorAll('.usage-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateBandwidth();
        }

        function calculateBandwidth() {
            // Get inputs
            const bandwidth = parseFloat(document.getElementById('bandwidth').value);
            const bandwidthUnit = document.getElementById('bandwidthUnit').value;
            const concurrentUsers = parseInt(document.getElementById('concurrentUsers').value);
            const peakUsage = parseFloat(document.getElementById('peakUsage').value) / 100;
            const overhead = parseFloat(document.getElementById('overhead').value) / 100;
            
            // Parse scenarios
            let scenarios = [];
            try {
                scenarios = JSON.parse(document.getElementById('scenarios').value);
            } catch (e) {
                console.error("Invalid scenarios JSON");
                scenarios = [];
            }
            
            // Convert to base units
            const bandwidthBps = bandwidth * bandwidthUnits[bandwidthUnit];
            
            // Calculate effective bandwidth
            const effectiveBandwidthBps = bandwidthBps * (1 - overhead);
            const bandwidthPerUserBps = effectiveBandwidthBps / concurrentUsers;
            
            // Calculate bandwidth per user in original units
            const bandwidthPerUser = bandwidthPerUserBps / bandwidthUnits[bandwidthUnit];
            
            // Bandwidth conversions
            const kbps = bandwidthBps / 1000;
            const mbps = bandwidthBps / 1000000;
            const gbps = bandwidthBps / 1000000000;
            
            // Data capacity calculations
            const bytesPerSecond = bandwidthBps / 8;
            const MBps = bytesPerSecond / (1024 * 1024);
            const dataPerMinute = MBps * 60;
            const dataPerHour = dataPerMinute * 60;
            const dataPerDay = dataPerHour * 24;
            
            // Calculate scenario usage
            let totalScenarioUsage = 0;
            let scenarioResultsHTML = '';
            
            if (scenarios && scenarios.length > 0) {
                scenarios.forEach(scenario => {
                    const scenarioUsage = scenario.bandwidth * scenario.users;
                    totalScenarioUsage += scenarioUsage;
                    
                    const usagePercentage = (scenarioUsage / bandwidth) * 100;
                    const status = usagePercentage > 10 ? (usagePercentage > 30 ? 'high' : 'medium') : 'low';
                    
                    scenarioResultsHTML += `
                        <div class="scenario-item">
                            <div class="scenario-details">
                                <strong>${scenario.name}</strong>
                                <div style="font-size: 0.85rem; color: #666;">${scenario.users} users × ${scenario.bandwidth} Mbps</div>
                            </div>
                            <div class="scenario-bandwidth">${scenarioUsage.toFixed(1)} Mbps</div>
                            <div style="color: ${status === 'high' ? '#e74c3c' : status === 'medium' ? '#f39c12' : '#27ae60'}; font-weight: bold;">
                                ${usagePercentage.toFixed(1)}%
                            </div>
                        </div>
                    `;
                });
                
                const totalUsagePercentage = (totalScenarioUsage / bandwidth) * 100;
                scenarioResultsHTML += `
                    <div class="scenario-item" style="border-top: 2px solid #4facfe; margin-top: 10px; padding-top: 15px;">
                        <div class="scenario-details">
                            <strong>Total Scenario Usage</strong>
                        </div>
                        <div class="scenario-bandwidth">${totalScenarioUsage.toFixed(1)} Mbps</div>
                        <div style="color: ${totalUsagePercentage > 80 ? '#e74c3c' : totalUsagePercentage > 50 ? '#f39c12' : '#27ae60'}; font-weight: bold;">
                            ${totalUsagePercentage.toFixed(1)}%
                        </div>
                    </div>
                `;
            } else {
                scenarioResultsHTML = '<div class="scenario-item">No valid scenarios defined</div>';
            }
            
            // Display best bandwidth per user format
            let bandwidthDisplay;
            if (bandwidthPerUserBps < 1000) {
                bandwidthDisplay = bandwidthPerUserBps.toFixed(1) + ' bps';
            } else if (bandwidthPerUserBps < 1000000) {
                bandwidthDisplay = (bandwidthPerUserBps / 1000).toFixed(1) + ' Kbps';
            } else if (bandwidthPerUserBps < 1000000000) {
                bandwidthDisplay = (bandwidthPerUserBps / 1000000).toFixed(1) + ' Mbps';
            } else {
                bandwidthDisplay = (bandwidthPerUserBps / 1000000000).toFixed(2) + ' Gbps';
            }
            
            // Update UI
            document.getElementById('bandwidthPerUser').textContent = bandwidthDisplay;
            document.getElementById('totalBandwidth').textContent = bandwidth + ' ' + bandwidthUnit;
            document.getElementById('effectiveBandwidth').textContent = (effectiveBandwidthBps / bandwidthUnits[bandwidthUnit]).toFixed(1) + ' ' + bandwidthUnit;
            document.getElementById('utilization').textContent = (peakUsage * 100).toFixed(0) + '%';
            
            document.getElementById('availableBandwidthDisplay').textContent = bandwidth + ' ' + bandwidthUnit;
            document.getElementById('usersDisplay').textContent = concurrentUsers + ' user' + (concurrentUsers > 1 ? 's' : '');
            document.getElementById('peakDisplay').textContent = (peakUsage * 100).toFixed(0) + '%';
            document.getElementById('overheadDisplay').textContent = (overhead * 100).toFixed(0) + '%';
            document.getElementById('effectiveDisplay').textContent = (effectiveBandwidthBps / bandwidthUnits[bandwidthUnit]).toFixed(1) + ' ' + bandwidthUnit;
            
            document.getElementById('bps').textContent = bandwidthBps.toLocaleString() + ' bps';
            document.getElementById('kbps').textContent = kbps.toLocaleString() + ' Kbps';
            document.getElementById('mbps').textContent = mbps.toFixed(1) + ' Mbps';
            document.getElementById('gbps').textContent = gbps.toFixed(3) + ' Gbps';
            
            document.getElementById('perSecond').textContent = MBps.toFixed(1) + ' MB';
            document.getElementById('perMinute').textContent = dataPerMinute.toFixed(0) + ' MB';
            document.getElementById('perHour').textContent = (dataPerHour / 1024).toFixed(1) + ' GB';
            document.getElementById('perDay').textContent = (dataPerDay / 1024).toFixed(0) + ' GB';
            
            // Update scenario results
            document.getElementById('scenarioResults').innerHTML = scenarioResultsHTML;
            
            // Animate chart
            animateChart();
        }

        function animateChart() {
            clearInterval(chartInterval);
            const chart = document.getElementById('bandwidthChart');
            const bars = chart.querySelectorAll('.chart-bar');
            
            // Reset heights
            bars.forEach(bar => {
                bar.style.height = '0%';
            });
            
            // Animate to target heights
            let delays = [0, 200, 400, 600];
            bars.forEach((bar, index) => {
                setTimeout(() => {
                    const targetHeights = [80, 60, 40, 90];
                    bar.style.height = targetHeights[index] + '%';
                }, delays[index]);
            });
            
            // Add pulsing animation
            chartInterval = setInterval(() => {
                bars.forEach((bar, index) => {
                    const currentHeight = parseInt(bar.style.height);
                    const targetHeights = [80, 60, 40, 90];
                    const variation = Math.sin(Date.now() / 1000 + index) * 5;
                    bar.style.height = (targetHeights[index] + variation) + '%';
                });
            }, 100);
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateBandwidth();
        });

        // Stop animation on page unload
        window.addEventListener('beforeunload', function() {
            clearInterval(chartInterval);
        });
    </script>
</body>
</html>