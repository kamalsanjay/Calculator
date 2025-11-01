<?php
/**
 * WiFi Speed Calculator
 * File: electronics/wifi-speed-calculator.php
 * Description: Advanced calculator for WiFi speed estimation, network performance, and signal analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WiFi Speed Calculator - Network Performance & Signal Analysis</title>
    <meta name="description" content="Advanced WiFi speed calculator with live animations. Calculate network performance, signal strength, and throughput metrics.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #9c27b0 0%, #673ab7 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #9c27b0; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #9c27b0; box-shadow: 0 0 0 3px rgba(156, 39, 176, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #9c27b0 0%, #673ab7 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(156, 39, 176, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #9c27b0 0%, #673ab7 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(156, 39, 176, 0.3); position: relative; overflow: hidden; }
        .result-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 0.8; } }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; position: relative; z-index: 1; }
        .result-card .amount { font-size: 3rem; font-weight: bold; position: relative; z-index: 1; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #9c27b0; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #9c27b0; font-size: 1.8rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #9c27b0; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .progress-bar { background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #9c27b0 0%, #673ab7 100%); width: 0%; transition: width 1s ease-out; }
        
        .info-box { background: #f3e5f5; border-left: 4px solid #9c27b0; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #9c27b0; }
        
        .wifi-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 8px; margin-top: 10px; }
        .wifi-btn { padding: 8px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .wifi-btn:hover { background: #9c27b0; color: white; border-color: #9c27b0; }
        .wifi-btn.active { background: #9c27b0; color: white; border-color: #9c27b0; }
        
        .signal-slider { display: flex; align-items: center; gap: 15px; margin-top: 10px; }
        .signal-slider input { flex: 1; }
        .signal-value { min-width: 50px; text-align: center; font-weight: 600; color: #9c27b0; }
        
        .wifi-visual { display: flex; flex-direction: column; align-items: center; margin: 20px 0; }
        .wifi-icon { width: 120px; height: 120px; position: relative; margin-bottom: 15px; }
        .wifi-wave { position: absolute; border: 3px solid #e0e0e0; border-radius: 50%; animation: wifiPulse 2s infinite; }
        .wifi-wave-1 { width: 120px; height: 120px; top: 0; left: 0; animation-delay: 0s; }
        .wifi-wave-2 { width: 90px; height: 90px; top: 15px; left: 15px; animation-delay: 0.3s; }
        .wifi-wave-3 { width: 60px; height: 60px; top: 30px; left: 30px; animation-delay: 0.6s; }
        .wifi-wave-4 { width: 30px; height: 30px; top: 45px; left: 45px; animation-delay: 0.9s; background: #9c27b0; border: none; }
        @keyframes wifiPulse { 0% { transform: scale(0.8); opacity: 0.8; } 50% { transform: scale(1); opacity: 0.4; } 100% { transform: scale(0.8); opacity: 0.8; } }
        .signal-level { font-size: 1.2rem; font-weight: bold; color: #9c27b0; }
        
        .speed-test { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; text-align: center; }
        .speed-test h3 { color: #9c27b0; margin-bottom: 15px; }
        .speed-gauge { width: 200px; height: 100px; position: relative; margin: 0 auto 20px; }
        .gauge-background { width: 200px; height: 100px; border: 10px solid #e0e0e0; border-top: none; border-radius: 0 0 100px 100px; position: absolute; overflow: hidden; }
        .gauge-fill { width: 200px; height: 100px; background: linear-gradient(90deg, #9c27b0 0%, #673ab7 100%); border-radius: 0 0 100px 100px; position: absolute; top: 100%; transition: transform 2s ease-out; transform-origin: top center; }
        .gauge-needle { width: 2px; height: 90px; background: #333; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%) rotate(0deg); transform-origin: bottom center; transition: transform 2s ease-out; }
        .gauge-labels { display: flex; justify-content: space-between; width: 200px; margin: 0 auto; }
        .gauge-label { font-size: 0.8rem; color: #666; }
        
        .live-speed { font-size: 2rem; font-weight: bold; color: #9c27b0; margin: 10px 0; }
        .speed-unit { font-size: 1rem; color: #666; }
        
        .device-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; margin-top: 10px; }
        .device-item { background: #f0f0f0; padding: 10px; border-radius: 8px; text-align: center; cursor: pointer; transition: all 0.3s; border: 2px solid transparent; }
        .device-item:hover { background: #e0e0e0; }
        .device-item.active { background: #9c27b0; color: white; border-color: #9c27b0; }
        .device-icon { font-size: 1.5rem; margin-bottom: 5px; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .wifi-preset { grid-template-columns: repeat(2, 1fr); }
            .device-grid { grid-template-columns: repeat(3, 1fr); }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
            .speed-gauge { width: 150px; height: 75px; }
            .gauge-background, .gauge-fill { width: 150px; height: 75px; }
            .gauge-needle { height: 65px; }
            .gauge-labels { width: 150px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📡 WiFi Speed Calculator</h1>
            <p>Live network performance analysis with dynamic animations</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Network Configuration</h2>
                <form id="wifiForm">
                    <div class="form-group">
                        <label for="wifiStandard">WiFi Standard</label>
                        <select id="wifiStandard" style="padding: 12px;">
                            <option value="802.11n">WiFi 4 (802.11n)</option>
                            <option value="802.11ac" selected>WiFi 5 (802.11ac)</option>
                            <option value="802.11ax">WiFi 6 (802.11ax)</option>
                            <option value="802.11be">WiFi 7 (802.11be)</option>
                        </select>
                        <small>Wireless networking standard</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="frequencyBand">Frequency Band</label>
                        <select id="frequencyBand" style="padding: 12px;">
                            <option value="2.4">2.4 GHz</option>
                            <option value="5" selected>5 GHz</option>
                            <option value="6">6 GHz</option>
                        </select>
                        <small>Radio frequency band</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="channelWidth">Channel Width</label>
                        <select id="channelWidth" style="padding: 12px;">
                            <option value="20">20 MHz</option>
                            <option value="40">40 MHz</option>
                            <option value="80" selected>80 MHz</option>
                            <option value="160">160 MHz</option>
                            <option value="320">320 MHz</option>
                        </select>
                        <small>Bandwidth of the wireless channel</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="spatialStreams">Spatial Streams</label>
                        <select id="spatialStreams" style="padding: 12px;">
                            <option value="1">1 Stream</option>
                            <option value="2" selected>2 Streams</option>
                            <option value="3">3 Streams</option>
                            <option value="4">4 Streams</option>
                            <option value="8">8 Streams</option>
                        </select>
                        <small>MIMO spatial streams</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick WiFi Presets</label>
                        <div class="wifi-preset">
                            <div class="wifi-btn" onclick="setWiFiPreset('basic')">Basic WiFi</div>
                            <div class="wifi-btn" onclick="setWiFiPreset('standard')">Standard</div>
                            <div class="wifi-btn" onclick="setWiFiPreset('performance')">Performance</div>
                            <div class="wifi-btn" onclick="setWiFiPreset('gaming')">Gaming</div>
                            <div class="wifi-btn" onclick="setWiFiPreset('enterprise')">Enterprise</div>
                            <div class="wifi-btn" onclick="setWiFiPreset('future')">Future Tech</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="signalStrength">Signal Strength</label>
                        <div class="signal-slider">
                            <span>Weak</span>
                            <input type="range" id="signalStrength" min="1" max="5" value="4" step="1">
                            <span>Excellent</span>
                            <div class="signal-value" id="signalValue">Strong</div>
                        </div>
                        <small>Quality of WiFi signal reception</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="distance">Distance from Router (meters)</label>
                        <input type="number" id="distance" value="10" min="1" max="100" step="1">
                        <small>Physical distance between device and router</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="obstacles">Obstacles & Interference</label>
                        <select id="obstacles" style="padding: 12px;">
                            <option value="1.0">None (Open Space)</option>
                            <option value="1.2" selected>Low (1-2 Walls)</option>
                            <option value="1.5">Medium (3-4 Walls)</option>
                            <option value="2.0">High (Multiple Floors)</option>
                            <option value="2.5">Extreme (Dense Materials)</option>
                        </select>
                        <small>Physical barriers and interference sources</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="connectedDevices">Connected Devices</label>
                        <input type="number" id="connectedDevices" value="5" min="1" max="50" step="1">
                        <small>Number of devices sharing the network</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Device Types</label>
                        <div class="device-grid">
                            <div class="device-item" onclick="toggleDevice(this)">
                                <div class="device-icon">📱</div>
                                <div>Smartphone</div>
                            </div>
                            <div class="device-item" onclick="toggleDevice(this)">
                                <div class="device-icon">💻</div>
                                <div>Laptop</div>
                            </div>
                            <div class="device-item active" onclick="toggleDevice(this)">
                                <div class="device-icon">🖥️</div>
                                <div>Desktop</div>
                            </div>
                            <div class="device-item" onclick="toggleDevice(this)">
                                <div class="device-icon">📺</div>
                                <div>Smart TV</div>
                            </div>
                            <div class="device-item" onclick="toggleDevice(this)">
                                <div class="device-icon">🎮</div>
                                <div>Gaming Console</div>
                            </div>
                            <div class="device-item" onclick="toggleDevice(this)">
                                <div class="device-icon">🔗</div>
                                <div>IoT Device</div>
                            </div>
                        </div>
                        <small>Types of devices affecting network load</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate WiFi Performance</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Live Performance Analysis</h2>
                
                <div class="result-card">
                    <h3>Estimated Maximum Speed</h3>
                    <div class="amount" id="maxSpeed">867 Mbps</div>
                </div>

                <div class="wifi-visual">
                    <div class="wifi-icon">
                        <div class="wifi-wave wifi-wave-1"></div>
                        <div class="wifi-wave wifi-wave-2"></div>
                        <div class="wifi-wave wifi-wave-3"></div>
                        <div class="wifi-wave wifi-wave-4"></div>
                    </div>
                    <div class="signal-level" id="signalLevel">Strong Signal</div>
                </div>

                <div class="speed-test">
                    <h3>Live Speed Simulation</h3>
                    <div class="speed-gauge">
                        <div class="gauge-background"></div>
                        <div class="gauge-fill" id="gaugeFill"></div>
                        <div class="gauge-needle" id="gaugeNeedle"></div>
                    </div>
                    <div class="gauge-labels">
                        <div class="gauge-label">0 Mbps</div>
                        <div class="gauge-label" id="maxGaugeLabel">867 Mbps</div>
                    </div>
                    <div class="live-speed" id="liveSpeed">0</div>
                    <div class="speed-unit" id="speedUnit">Mbps</div>
                    <button class="btn" onclick="startSpeedTest()" style="margin-top: 15px; padding: 10px 20px;">Start Speed Test</button>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Download Speed</h4>
                        <div class="value" id="downloadSpeed">693 Mbps</div>
                    </div>
                    <div class="metric-card">
                        <h4>Upload Speed</h4>
                        <div class="value" id="uploadSpeed">347 Mbps</div>
                    </div>
                    <div class="metric-card">
                        <h4>Latency</h4>
                        <div class="value" id="latency">12 ms</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Network Specifications</h3>
                    <div class="breakdown-item">
                        <span>WiFi Standard</span>
                        <strong id="standardDisplay">WiFi 5 (802.11ac)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Theoretical Maximum</span>
                        <strong id="theoreticalMax">1300 Mbps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Channel Utilization</span>
                        <strong id="channelUtilization">67%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Signal Quality</span>
                        <strong id="signalQuality">-55 dBm</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Network Efficiency</span>
                        <strong id="networkEfficiency">85%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Performance Factors</h3>
                    <div class="breakdown-item">
                        <span>Distance Impact</span>
                        <strong id="distanceImpact">-5%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Obstacle Loss</span>
                        <strong id="obstacleLoss">-12%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Device Sharing</span>
                        <strong id="deviceSharing">-18%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interference</span>
                        <strong id="interference">-8%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Real-World Factor</span>
                        <strong id="realWorld">-40%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Usage Scenarios</h3>
                    <div class="breakdown-item">
                        <span>4K Video Streaming</span>
                        <strong id="videoStreaming">Excellent</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Online Gaming</span>
                        <strong id="onlineGaming">Good</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Video Conferencing</span>
                        <strong id="videoConferencing">Excellent</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Large File Downloads</span>
                        <strong id="fileDownloads">Good</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Smart Home Devices</span>
                        <strong id="smartHome">Excellent</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Network Health</h3>
                    <div class="breakdown-item" style="flex-direction: column; align-items: flex-start;">
                        <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 5px;">
                            <span>Overall Network Quality</span>
                            <strong id="networkQuality">85%</strong>
                        </div>
                        <div class="progress-bar" style="width: 100%;">
                            <div class="progress-fill" id="qualityBar"></div>
                        </div>
                        <small style="margin-top: 5px;">Based on signal strength, interference, and congestion</small>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Tip:</strong> For best performance, use 5GHz band with wider channels, position your router centrally, and minimize physical obstructions. WiFi 6 and newer standards provide better performance in congested environments.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📡 WiFi Speed Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Live network performance analysis with dynamic animations</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('wifiForm');
        const signalSlider = document.getElementById('signalStrength');
        const signalValue = document.getElementById('signalValue');
        let speedTestInterval;
        let currentSpeed = 0;
        let targetSpeed = 0;

        // WiFi standards data (theoretical max speeds in Mbps)
        const wifiStandards = {
            '802.11n': { name: 'WiFi 4', maxSpeed: 600, efficiency: 0.6 },
            '802.11ac': { name: 'WiFi 5', maxSpeed: 1300, efficiency: 0.7 },
            '802.11ax': { name: 'WiFi 6', maxSpeed: 2400, efficiency: 0.8 },
            '802.11be': { name: 'WiFi 7', maxSpeed: 46000, efficiency: 0.85 }
        };

        // Frequency band multipliers
        const frequencyBands = {
            '2.4': { range: 'Good', interference: 0.7 },
            '5': { range: 'Very Good', interference: 0.9 },
            '6': { range: 'Excellent', interference: 0.95 }
        };

        // Channel width multipliers
        const channelWidths = {
            '20': 1.0,
            '40': 2.0,
            '80': 4.0,
            '160': 8.0,
            '320': 16.0
        };

        // Signal strength levels
        const signalLevels = {
            1: { label: 'Very Weak', quality: 0.3, dBm: -85 },
            2: { label: 'Weak', quality: 0.5, dBm: -75 },
            3: { label: 'Fair', quality: 0.7, dBm: -65 },
            4: { label: 'Strong', quality: 0.85, dBm: -55 },
            5: { label: 'Excellent', quality: 0.95, dBm: -45 }
        };

        // WiFi presets
        const wifiPresets = {
            'basic': { standard: '802.11n', frequency: '2.4', width: '20', streams: '1' },
            'standard': { standard: '802.11ac', frequency: '5', width: '40', streams: '2' },
            'performance': { standard: '802.11ac', frequency: '5', width: '80', streams: '3' },
            'gaming': { standard: '802.11ax', frequency: '5', width: '160', streams: '4' },
            'enterprise': { standard: '802.11ax', frequency: '6', width: '160', streams: '8' },
            'future': { standard: '802.11be', frequency: '6', width: '320', streams: '8' }
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateWiFiPerformance();
        });

        signalSlider.addEventListener('input', function() {
            const value = parseInt(this.value);
            signalValue.textContent = signalLevels[value].label;
            updateSignalVisual(value);
            calculateWiFiPerformance();
        });

        function setWiFiPreset(preset) {
            const config = wifiPresets[preset];
            document.getElementById('wifiStandard').value = config.standard;
            document.getElementById('frequencyBand').value = config.frequency;
            document.getElementById('channelWidth').value = config.width;
            document.getElementById('spatialStreams').value = config.streams;
            
            // Visual feedback
            document.querySelectorAll('.wifi-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateWiFiPerformance();
        }

        function toggleDevice(deviceElement) {
            deviceElement.classList.toggle('active');
            calculateWiFiPerformance();
        }

        function updateSignalVisual(signalLevel) {
            const wifiWaves = document.querySelectorAll('.wifi-wave');
            const signalLevelText = document.getElementById('signalLevel');
            
            // Reset all waves
            wifiWaves.forEach(wave => {
                wave.style.borderColor = '#e0e0e0';
                wave.style.animationPlayState = 'running';
            });
            
            // Disable waves based on signal strength
            for (let i = 4; i > signalLevel; i--) {
                wifiWaves[i-1].style.borderColor = 'transparent';
                wifiWaves[i-1].style.animationPlayState = 'paused';
            }
            
            signalLevelText.textContent = signalLevels[signalLevel].label;
            
            // Change color based on signal strength
            if (signalLevel <= 2) {
                signalLevelText.style.color = '#f44336';
            } else if (signalLevel <= 3) {
                signalLevelText.style.color = '#ff9800';
            } else {
                signalLevelText.style.color = '#9c27b0';
            }
        }

        function calculateWiFiPerformance() {
            // Get inputs
            const wifiStandard = document.getElementById('wifiStandard').value;
            const frequencyBand = document.getElementById('frequencyBand').value;
            const channelWidth = document.getElementById('channelWidth').value;
            const spatialStreams = parseInt(document.getElementById('spatialStreams').value);
            const signalStrength = parseInt(document.getElementById('signalStrength').value);
            const distance = parseInt(document.getElementById('distance').value);
            const obstacles = parseFloat(document.getElementById('obstacles').value);
            const connectedDevices = parseInt(document.getElementById('connectedDevices').value);
            
            // Get standard data
            const standard = wifiStandards[wifiStandard];
            
            // Calculate theoretical maximum
            const theoreticalMax = standard.maxSpeed * channelWidths[channelWidth] * spatialStreams;
            
            // Apply signal strength factor
            const signalFactor = signalLevels[signalStrength].quality;
            
            // Apply frequency band factor
            const frequencyFactor = frequencyBands[frequencyBand].interference;
            
            // Apply distance factor (exponential decay)
            const distanceFactor = Math.exp(-distance / 50);
            
            // Apply obstacle factor
            const obstacleFactor = 1 / obstacles;
            
            // Apply device sharing factor (logarithmic decay)
            const deviceFactor = 1 / Math.log(connectedDevices + 1);
            
            // Calculate real-world maximum speed
            const realWorldMax = theoreticalMax * signalFactor * frequencyFactor * 
                               distanceFactor * obstacleFactor * deviceFactor * standard.efficiency;
            
            // Calculate download/upload speeds (typically 80/40 split)
            const downloadSpeed = realWorldMax * 0.8;
            const uploadSpeed = realWorldMax * 0.4;
            
            // Calculate latency based on factors
            const baseLatency = 5;
            const latency = baseLatency + (1 - signalFactor) * 20 + (1 - frequencyFactor) * 10 + 
                           (1 - distanceFactor) * 15 + (obstacles - 1) * 5 + Math.log(connectedDevices) * 2;
            
            // Calculate performance factors for display
            const distanceImpact = ((distanceFactor - 1) * 100).toFixed(0);
            const obstacleLoss = ((1 - obstacleFactor) * 100).toFixed(0);
            const deviceSharing = ((1 - deviceFactor) * 100).toFixed(0);
            const interference = ((1 - frequencyFactor) * 100).toFixed(0);
            const realWorld = ((1 - standard.efficiency) * 100).toFixed(0);
            
            // Calculate network quality score
            const networkQuality = (signalFactor * 0.3 + frequencyFactor * 0.2 + 
                                  distanceFactor * 0.2 + obstacleFactor * 0.15 + deviceFactor * 0.15) * 100;
            
            // Update UI
            document.getElementById('maxSpeed').textContent = Math.round(realWorldMax) + ' Mbps';
            document.getElementById('downloadSpeed').textContent = Math.round(downloadSpeed) + ' Mbps';
            document.getElementById('uploadSpeed').textContent = Math.round(uploadSpeed) + ' Mbps';
            document.getElementById('latency').textContent = Math.round(latency) + ' ms';
            
            document.getElementById('standardDisplay').textContent = standard.name + ' (' + wifiStandard + ')';
            document.getElementById('theoreticalMax').textContent = Math.round(theoreticalMax) + ' Mbps';
            document.getElementById('channelUtilization').textContent = Math.round((realWorldMax / theoreticalMax) * 100) + '%';
            document.getElementById('signalQuality').textContent = signalLevels[signalStrength].dBm + ' dBm';
            document.getElementById('networkEfficiency').textContent = Math.round(standard.efficiency * 100) + '%';
            
            document.getElementById('distanceImpact').textContent = distanceImpact + '%';
            document.getElementById('obstacleLoss').textContent = obstacleLoss + '%';
            document.getElementById('deviceSharing').textContent = deviceSharing + '%';
            document.getElementById('interference').textContent = interference + '%';
            document.getElementById('realWorld').textContent = realWorld + '%';
            
            // Update usage scenarios
            updateUsageScenarios(downloadSpeed, uploadSpeed, latency);
            
            // Update network quality
            updateNetworkQuality(networkQuality);
            
            // Update speed test target
            targetSpeed = downloadSpeed;
            document.getElementById('maxGaugeLabel').textContent = Math.round(realWorldMax) + ' Mbps';
        }

        function updateUsageScenarios(download, upload, latency) {
            // 4K Video Streaming (25 Mbps required)
            const videoRating = download >= 50 ? 'Excellent' : download >= 25 ? 'Good' : download >= 15 ? 'Fair' : 'Poor';
            document.getElementById('videoStreaming').textContent = videoRating;
            
            // Online Gaming (low latency, 15 Mbps required)
            const gamingRating = latency <= 20 && download >= 25 ? 'Excellent' : 
                               latency <= 40 && download >= 15 ? 'Good' : 
                               latency <= 60 && download >= 10 ? 'Fair' : 'Poor';
            document.getElementById('onlineGaming').textContent = gamingRating;
            
            // Video Conferencing (upload speed important)
            const conferencingRating = upload >= 10 && latency <= 50 ? 'Excellent' : 
                                     upload >= 5 && latency <= 80 ? 'Good' : 
                                     upload >= 3 && latency <= 100 ? 'Fair' : 'Poor';
            document.getElementById('videoConferencing').textContent = conferencingRating;
            
            // File Downloads
            const downloadRating = download >= 100 ? 'Excellent' : 
                                  download >= 50 ? 'Good' : 
                                  download >= 25 ? 'Fair' : 'Poor';
            document.getElementById('fileDownloads').textContent = downloadRating;
            
            // Smart Home (low bandwidth required)
            const smartHomeRating = download >= 10 && latency <= 100 ? 'Excellent' : 'Good';
            document.getElementById('smartHome').textContent = smartHomeRating;
        }

        function updateNetworkQuality(quality) {
            const qualityBar = document.getElementById('qualityBar');
            const qualityText = document.getElementById('networkQuality');
            
            qualityBar.style.width = '0%';
            
            setTimeout(() => {
                qualityBar.style.width = quality + '%';
                qualityText.textContent = Math.round(quality) + '%';
                
                // Change color based on quality
                if (quality >= 80) {
                    qualityBar.style.background = 'linear-gradient(90deg, #4CAF50 0%, #8BC34A 100%)';
                } else if (quality >= 60) {
                    qualityBar.style.background = 'linear-gradient(90deg, #ff9800 0%, #ffc107 100%)';
                } else {
                    qualityBar.style.background = 'linear-gradient(90deg, #f44336 0%, #ff5722 100%)';
                }
            }, 100);
        }

        function startSpeedTest() {
            clearInterval(speedTestInterval);
            currentSpeed = 0;
            
            const gaugeFill = document.getElementById('gaugeFill');
            const gaugeNeedle = document.getElementById('gaugeNeedle');
            const liveSpeed = document.getElementById('liveSpeed');
            const speedUnit = document.getElementById('speedUnit');
            
            // Reset gauge
            gaugeFill.style.transform = 'rotate(0deg)';
            gaugeNeedle.style.transform = 'translateX(-50%) rotate(0deg)';
            liveSpeed.textContent = '0';
            
            // Calculate animation parameters
            const duration = 3000; // 3 seconds
            const steps = 60;
            const stepDuration = duration / steps;
            const speedIncrement = targetSpeed / steps;
            
            let step = 0;
            
            speedTestInterval = setInterval(() => {
                step++;
                currentSpeed += speedIncrement;
                
                if (step >= steps) {
                    currentSpeed = targetSpeed;
                    clearInterval(speedTestInterval);
                }
                
                // Update display
                const displaySpeed = Math.round(currentSpeed);
                liveSpeed.textContent = displaySpeed;
                
                // Update gauge (180deg = 100% of max speed)
                const gaugeRotation = (currentSpeed / targetSpeed) * 180;
                gaugeFill.style.transform = `rotate(${gaugeRotation}deg)`;
                gaugeNeedle.style.transform = `translateX(-50%) rotate(${gaugeRotation}deg)`;
                
                // Change unit if needed
                if (currentSpeed >= 1000) {
                    liveSpeed.textContent = (currentSpeed / 1000).toFixed(1);
                    speedUnit.textContent = 'Gbps';
                } else {
                    speedUnit.textContent = 'Mbps';
                }
                
                // Add random fluctuation for realism
                if (step > steps * 0.3 && step < steps * 0.9) {
                    const fluctuation = (Math.random() - 0.5) * targetSpeed * 0.1;
                    const fluctuatedSpeed = Math.max(0, currentSpeed + fluctuation);
                    liveSpeed.textContent = Math.round(fluctuatedSpeed);
                }
                
            }, stepDuration);
        }

        // Initialize
        window.addEventListener('load', function() {
            updateSignalVisual(4);
            calculateWiFiPerformance();
        });

        // Stop animation on page unload
        window.addEventListener('beforeunload', function() {
            clearInterval(speedTestInterval);
        });
    </script>
</body>
</html>
