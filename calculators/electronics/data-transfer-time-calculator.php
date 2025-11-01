<?php
/**
 * Data Transfer Time Calculator
 * File: electronics/data-transfer-time-calculator.php
 * Description: Advanced calculator for file transfer time estimation with network speeds
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transfer Time Calculator - File Transfer Speed & Duration</title>
    <meta name="description" content="Advanced data transfer time calculator. Calculate file transfer duration, speed conversions, bandwidth requirements, and network performance metrics.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #667eea; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); position: relative; overflow: hidden; }
        .result-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 0.8; } }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; position: relative; z-index: 1; }
        .result-card .amount { font-size: 3rem; font-weight: bold; position: relative; z-index: 1; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #667eea; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #667eea; font-size: 1.8rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #667eea; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .progress-bar { background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); width: 0%; transition: width 1s ease-out; }
        
        .info-box { background: #e8f2ff; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #667eea; }
        
        .speed-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 8px; margin-top: 10px; }
        .speed-btn { padding: 8px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .speed-btn:hover { background: #667eea; color: white; border-color: #667eea; }
        .speed-btn.active { background: #667eea; color: white; border-color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .speed-preset { grid-template-columns: repeat(2, 1fr); }
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
            <h1>⏱️ Data Transfer Time Calculator</h1>
            <p>Calculate file transfer duration and network performance metrics</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Transfer Parameters</h2>
                <form id="transferForm">
                    <div class="form-group">
                        <label for="fileSize">File Size</label>
                        <div class="input-group">
                            <input type="number" id="fileSize" value="10" min="0.001" step="0.001" required>
                            <select id="fileSizeUnit" style="padding: 12px;">
                                <option value="B">Bytes</option>
                                <option value="KB">KB</option>
                                <option value="MB">MB</option>
                                <option value="GB" selected>GB</option>
                                <option value="TB">TB</option>
                            </select>
                        </div>
                        <small>Enter the size of file to transfer</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="transferSpeed">Transfer Speed</label>
                        <div class="input-group">
                            <input type="number" id="transferSpeed" value="100" min="0.001" step="0.001" required>
                            <select id="speedUnit" style="padding: 12px;">
                                <option value="bps">bps</option>
                                <option value="Kbps">Kbps</option>
                                <option value="Mbps" selected>Mbps</option>
                                <option value="Gbps">Gbps</option>
                            </select>
                        </div>
                        <small>Network or connection speed</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Speed Presets</label>
                        <div class="speed-preset">
                            <div class="speed-btn" onclick="setSpeed(10, 'Mbps')">10 Mbps</div>
                            <div class="speed-btn" onclick="setSpeed(50, 'Mbps')">50 Mbps</div>
                            <div class="speed-btn" onclick="setSpeed(100, 'Mbps')">100 Mbps</div>
                            <div class="speed-btn" onclick="setSpeed(250, 'Mbps')">250 Mbps</div>
                            <div class="speed-btn" onclick="setSpeed(500, 'Mbps')">500 Mbps</div>
                            <div class="speed-btn" onclick="setSpeed(1, 'Gbps')">1 Gbps</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="efficiency">Network Efficiency (%)</label>
                        <input type="number" id="efficiency" value="80" min="1" max="100" step="1">
                        <small>Account for overhead (70-95% typical)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="simultaneousFiles">Simultaneous Transfers</label>
                        <input type="number" id="simultaneousFiles" value="1" min="1" max="100" step="1">
                        <small>Number of files transferring at once</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Transfer Time</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Transfer Analysis</h2>
                
                <div class="result-card">
                    <h3>Transfer Time</h3>
                    <div class="amount" id="transferTime">13.3 min</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Seconds</h4>
                        <div class="value" id="seconds">800</div>
                    </div>
                    <div class="metric-card">
                        <h4>Minutes</h4>
                        <div class="value" id="minutes">13.3</div>
                    </div>
                    <div class="metric-card">
                        <h4>Hours</h4>
                        <div class="value" id="hours">0.22</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Transfer Details</h3>
                    <div class="breakdown-item">
                        <span>File Size</span>
                        <strong id="fileSizeDisplay">10 GB</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Transfer Speed</span>
                        <strong id="speedDisplay">100 Mbps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Effective Speed</span>
                        <strong id="effectiveSpeed">80 Mbps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Network Efficiency</span>
                        <strong id="efficiencyDisplay">80%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Simultaneous Files</span>
                        <strong id="simFilesDisplay">1 file</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Time Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Total Seconds</span>
                        <strong id="totalSeconds">800 seconds</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Minutes:Seconds</span>
                        <strong id="minSec">13:20</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hours:Minutes:Seconds</span>
                        <strong id="hms">0:13:20</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated Completion</span>
                        <strong id="completion">3:08 PM</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Speed Conversions</h3>
                    <div class="breakdown-item">
                        <span>Bits per Second</span>
                        <strong id="bps">100,000,000 bps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Bytes per Second</span>
                        <strong id="Bps">12.5 MB/s</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Megabits per Second</span>
                        <strong id="mbps">100 Mbps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Megabytes per Second</span>
                        <strong id="MBps">12.5 MB/s</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Bandwidth Usage</h3>
                    <div class="breakdown-item">
                        <span>Required Bandwidth</span>
                        <strong id="bandwidth">100 Mbps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Per File (if multiple)</span>
                        <strong id="perFile">100 Mbps</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Data Transferred per Hour</span>
                        <strong id="perHour">45 GB/hr</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Data Transferred per Day</span>
                        <strong id="perDay">1,080 GB/day</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Transfer Progress</h3>
                    <div class="breakdown-item" style="flex-direction: column; align-items: flex-start;">
                        <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 5px;">
                            <span>Progress</span>
                            <strong id="progress">0%</strong>
                        </div>
                        <div class="progress-bar" style="width: 100%;">
                            <div class="progress-fill" id="progressBar"></div>
                        </div>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> Actual transfer times may vary due to network congestion, protocol overhead, hardware limitations, and other factors. Network efficiency typically ranges from 70-95% of theoretical maximum speed.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⏱️ Data Transfer Time Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced file transfer duration and network performance calculations</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('transferForm');
        let progressInterval;

        // Unit conversion factors to bytes
        const sizeUnits = {
            B: 1,
            KB: 1024,
            MB: 1024 * 1024,
            GB: 1024 * 1024 * 1024,
            TB: 1024 * 1024 * 1024 * 1024
        };

        // Speed conversion factors to bps
        const speedUnits = {
            bps: 1,
            Kbps: 1000,
            Mbps: 1000000,
            Gbps: 1000000000
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateTransferTime();
        });

        function setSpeed(value, unit) {
            document.getElementById('transferSpeed').value = value;
            document.getElementById('speedUnit').value = unit;
            
            // Visual feedback
            document.querySelectorAll('.speed-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateTransferTime();
        }

        function calculateTransferTime() {
            // Get inputs
            const fileSize = parseFloat(document.getElementById('fileSize').value);
            const fileSizeUnit = document.getElementById('fileSizeUnit').value;
            const transferSpeed = parseFloat(document.getElementById('transferSpeed').value);
            const speedUnit = document.getElementById('speedUnit').value;
            const efficiency = parseFloat(document.getElementById('efficiency').value) / 100;
            const simultaneousFiles = parseInt(document.getElementById('simultaneousFiles').value);

            // Convert to base units
            const fileSizeBytes = fileSize * sizeUnits[fileSizeUnit];
            const speedBps = transferSpeed * speedUnits[speedUnit];
            
            // Calculate effective speed
            const effectiveSpeedBps = speedBps * efficiency;
            const speedPerFileBps = effectiveSpeedBps / simultaneousFiles;
            
            // Calculate transfer time in seconds
            const transferTimeSeconds = fileSizeBytes * 8 / effectiveSpeedBps;
            
            // Time conversions
            const minutes = transferTimeSeconds / 60;
            const hours = minutes / 60;
            const days = hours / 24;
            
            // Format time display
            const totalMinutes = Math.floor(transferTimeSeconds / 60);
            const remainingSeconds = Math.floor(transferTimeSeconds % 60);
            const totalHours = Math.floor(minutes / 60);
            const remainingMinutes = Math.floor(minutes % 60);
            
            // Calculate completion time
            const now = new Date();
            const completionTime = new Date(now.getTime() + transferTimeSeconds * 1000);
            const completionStr = completionTime.toLocaleTimeString('en-US', { 
                hour: 'numeric', 
                minute: '2-digit',
                hour12: true 
            });
            
            // Speed conversions
            const bytesPerSecond = effectiveSpeedBps / 8;
            const MBps = bytesPerSecond / (1024 * 1024);
            const mbps = effectiveSpeedBps / 1000000;
            
            // Bandwidth usage
            const dataPerHour = (bytesPerSecond * 3600) / sizeUnits.GB;
            const dataPerDay = dataPerHour * 24;
            
            // Display best time format
            let timeDisplay;
            if (transferTimeSeconds < 60) {
                timeDisplay = transferTimeSeconds.toFixed(1) + ' sec';
            } else if (minutes < 60) {
                timeDisplay = minutes.toFixed(1) + ' min';
            } else if (hours < 24) {
                timeDisplay = hours.toFixed(2) + ' hrs';
            } else {
                timeDisplay = days.toFixed(2) + ' days';
            }
            
            // Update UI
            document.getElementById('transferTime').textContent = timeDisplay;
            document.getElementById('seconds').textContent = transferTimeSeconds.toFixed(1);
            document.getElementById('minutes').textContent = minutes.toFixed(2);
            document.getElementById('hours').textContent = hours.toFixed(2);
            
            document.getElementById('fileSizeDisplay').textContent = fileSize + ' ' + fileSizeUnit;
            document.getElementById('speedDisplay').textContent = transferSpeed + ' ' + speedUnit;
            document.getElementById('effectiveSpeed').textContent = (effectiveSpeedBps / speedUnits[speedUnit]).toFixed(2) + ' ' + speedUnit;
            document.getElementById('efficiencyDisplay').textContent = (efficiency * 100).toFixed(0) + '%';
            document.getElementById('simFilesDisplay').textContent = simultaneousFiles + ' file' + (simultaneousFiles > 1 ? 's' : '');
            
            document.getElementById('totalSeconds').textContent = transferTimeSeconds.toFixed(0) + ' seconds';
            document.getElementById('minSec').textContent = totalMinutes + ':' + String(remainingSeconds).padStart(2, '0');
            document.getElementById('hms').textContent = totalHours + ':' + String(remainingMinutes).padStart(2, '0') + ':' + String(remainingSeconds).padStart(2, '0');
            document.getElementById('completion').textContent = completionStr;
            
            document.getElementById('bps').textContent = effectiveSpeedBps.toLocaleString() + ' bps';
            document.getElementById('Bps').textContent = MBps.toFixed(2) + ' MB/s';
            document.getElementById('mbps').textContent = mbps.toFixed(2) + ' Mbps';
            document.getElementById('MBps').textContent = MBps.toFixed(2) + ' MB/s';
            
            document.getElementById('bandwidth').textContent = transferSpeed + ' ' + speedUnit;
            document.getElementById('perFile').textContent = (transferSpeed / simultaneousFiles).toFixed(2) + ' ' + speedUnit;
            document.getElementById('perHour').textContent = dataPerHour.toFixed(2) + ' GB/hr';
            document.getElementById('perDay').textContent = dataPerDay.toFixed(2) + ' GB/day';
            
            // Animate progress bar
            animateProgress();
        }

        function animateProgress() {
            clearInterval(progressInterval);
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progress');
            let progress = 0;
            
            progressBar.style.width = '0%';
            
            progressInterval = setInterval(() => {
                progress += 2;
                if (progress > 100) {
                    progress = 0;
                }
                progressBar.style.width = progress + '%';
                progressText.textContent = progress + '%';
            }, 100);
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateTransferTime();
        });

        // Stop animation on page unload
        window.addEventListener('beforeunload', function() {
            clearInterval(progressInterval);
        });
    </script>
</body>
</html>