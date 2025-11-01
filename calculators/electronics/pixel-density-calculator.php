<?php
/**
 * Pixel Density Calculator
 * File: electronics/pixel-density-calculator.php
 * Description: Advanced pixel density calculator with PPI, visual comparison, and device presets
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel Density Calculator - PPI, DPI & Screen Clarity Analysis</title>
    <meta name="description" content="Advanced pixel density calculator. Calculate PPI, compare screen clarity, and analyze display quality across different devices.">
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
            grid-template-columns: 1fr 1fr; 
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
        
        .quality-indicator { 
            height: 10px; 
            background: #e0e0e0; 
            border-radius: 5px; 
            overflow: hidden; 
            margin: 10px 0; 
            position: relative; 
        }
        .quality-fill { 
            height: 100%; 
            background: linear-gradient(90deg, #4CAF50, #FFC107, #F44336); 
            width: 0%; 
            transition: width 1s ease-out; 
        }
        .quality-labels { 
            display: flex; 
            justify-content: space-between; 
            margin-top: 5px; 
            font-size: 0.8rem; 
            color: #666; 
        }
        
        .device-comparison { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 15px; 
            margin-top: 15px; 
        }
        .device-card { 
            background: white; 
            padding: 15px; 
            border-radius: 8px; 
            border: 2px solid #e0e0e0; 
            text-align: center; 
            transition: all 0.3s; 
        }
        .device-card:hover { 
            transform: translateY(-2px); 
            border-color: #667eea; 
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.2); 
        }
        .device-card h4 { 
            color: #667eea; 
            margin-bottom: 10px; 
        }
        .device-card .ppi { 
            font-size: 1.5rem; 
            font-weight: bold; 
            color: #333; 
        }
        .device-card .resolution { 
            color: #666; 
            font-size: 0.9rem; 
        }
        
        .visual-comparison { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 12px; 
            margin-bottom: 20px; 
            text-align: center; 
        }
        .screen-visual { 
            display: flex; 
            justify-content: space-around; 
            align-items: center; 
            margin: 20px 0; 
            flex-wrap: wrap; 
        }
        .screen-box { 
            width: 150px; 
            height: 100px; 
            background: white; 
            border: 2px solid #333; 
            position: relative; 
            overflow: hidden; 
            margin: 10px; 
        }
        .pixel-grid { 
            position: absolute; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background-image: 
                linear-gradient(rgba(0,0,0,0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,0,0,0.1) 1px, transparent 1px);
            background-size: 10px 10px;
        }
        .high-ppi .pixel-grid { 
            background-size: 5px 5px; 
        }
        .screen-label { 
            margin-top: 10px; 
            font-weight: 600; 
            color: #333; 
        }
        
        .preset-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
            gap: 8px; 
            margin-top: 10px; 
        }
        .preset-btn { 
            padding: 10px 12px; 
            background: #f0f0f0; 
            border: 2px solid #e0e0e0; 
            border-radius: 6px; 
            cursor: pointer; 
            text-align: center; 
            font-size: 0.85rem; 
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
            .preset-grid { 
                grid-template-columns: repeat(2, 1fr); 
            }
            .screen-visual { 
                flex-direction: column; 
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
            <h1>📱 Pixel Density Calculator</h1>
            <p>Calculate PPI, compare screen clarity, and analyze display quality</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Display Parameters</h2>
                <form id="densityForm">
                    <div class="form-group">
                        <label for="resolutionX">Horizontal Resolution (Width)</label>
                        <input type="number" id="resolutionX" value="1920" min="1" max="16384" step="1" required>
                        <small>Number of pixels horizontally (e.g., 1920 for Full HD)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="resolutionY">Vertical Resolution (Height)</label>
                        <input type="number" id="resolutionY" value="1080" min="1" max="16384" step="1" required>
                        <small>Number of pixels vertically (e.g., 1080 for Full HD)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="screenSize">Screen Size (Diagonal)</label>
                        <div class="input-group">
                            <input type="number" id="screenSize" value="24" min="0.1" max="200" step="0.1" required>
                            <select id="sizeUnit" style="padding: 12px;">
                                <option value="inches" selected>Inches</option>
                                <option value="cm">Centimeters</option>
                            </select>
                        </div>
                        <small>Diagonal screen size in inches or centimeters</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Device Presets</label>
                        <div class="preset-grid">
                            <div class="preset-btn" onclick="setPreset('iPhone 15 Pro', '2556', '1179', '6.1')">iPhone 15 Pro</div>
                            <div class="preset-btn" onclick="setPreset('Samsung S23', '2340', '1080', '6.1')">Samsung S23</div>
                            <div class="preset-btn" onclick="setPreset('iPad Pro', '2732', '2048', '12.9')">iPad Pro</div>
                            <div class="preset-btn" onclick="setPreset('MacBook Pro', '3024', '1964', '14.2')">MacBook Pro</div>
                            <div class="preset-btn" onclick="setPreset('4K Monitor', '3840', '2160', '27')">4K Monitor</div>
                            <div class="preset-btn" onclick="setPreset('1080p Monitor', '1920', '1080', '24')">1080p Monitor</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="viewingDistance">Viewing Distance</label>
                        <div class="input-group">
                            <input type="number" id="viewingDistance" value="20" min="5" max="500" step="1">
                            <select id="distanceUnit" style="padding: 12px;">
                                <option value="inches" selected>Inches</option>
                                <option value="cm">Centimeters</option>
                            </select>
                        </div>
                        <small>Typical viewing distance from screen</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="visualAcuity">Visual Acuity</label>
                        <select id="visualAcuity" style="padding: 12px;">
                            <option value="20/10">Excellent (20/10)</option>
                            <option value="20/15">Very Good (20/15)</option>
                            <option value="20/20" selected>Average (20/20)</option>
                            <option value="20/30">Below Average (20/30)</option>
                            <option value="20/40">Poor (20/40)</option>
                        </select>
                        <small>Your visual acuity affects perceived sharpness</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Pixel Density</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Density Analysis</h2>
                
                <div class="result-card">
                    <h3>Pixel Density (PPI)</h3>
                    <div class="amount" id="ppiValue">91.79</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Pixels</h4>
                        <div class="value" id="totalPixels">2.07M</div>
                    </div>
                    <div class="metric-card">
                        <h4>Pixel Pitch</h4>
                        <div class="value" id="pixelPitch">0.277mm</div>
                    </div>
                    <div class="metric-card">
                        <h4>Aspect Ratio</h4>
                        <div class="value" id="aspectRatio">16:9</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Display Quality</h3>
                    <div class="breakdown-item">
                        <span>PPI Category</span>
                        <strong id="ppiCategory">Standard</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Retina Equivalent</span>
                        <strong id="retinaEquivalent">No</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Perceived Sharpness</span>
                        <strong id="perceivedSharpness">Good</strong>
                    </div>
                    
                    <div class="quality-indicator">
                        <div class="quality-fill" id="qualityFill"></div>
                    </div>
                    <div class="quality-labels">
                        <span>Low</span>
                        <span>Medium</span>
                        <span>High</span>
                        <span>Retina</span>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Display Details</h3>
                    <div class="breakdown-item">
                        <span>Resolution</span>
                        <strong id="resolutionDisplay">1920 × 1080</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Screen Size</span>
                        <strong id="screenSizeDisplay">24 inches</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Screen Area</span>
                        <strong id="screenArea">258.06 in²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pixel Count</span>
                        <strong id="pixelCount">2,073,600 pixels</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Megapixels</span>
                        <strong id="megapixels">2.07 MP</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Human Vision Analysis</h3>
                    <div class="breakdown-item">
                        <span>Viewing Distance</span>
                        <strong id="viewingDistanceDisplay">20 inches</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Visual Acuity</span>
                        <strong id="visualAcuityDisplay">20/20 (Average)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Retina Threshold</span>
                        <strong id="retinaThreshold">286.1 PPI</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Can Resolve Individual Pixels?</span>
                        <strong id="resolvePixels">Yes</strong>
                    </div>
                </div>

                <div class="visual-comparison">
                    <h3>Visual Comparison</h3>
                    <p>How your display compares to different PPI levels</p>
                    <div class="screen-visual">
                        <div class="screen-box low-ppi">
                            <div class="pixel-grid"></div>
                            <div class="screen-label" id="lowPpiLabel">72 PPI</div>
                        </div>
                        <div class="screen-box" id="currentPpiVisual">
                            <div class="pixel-grid"></div>
                            <div class="screen-label" id="currentPpiLabel">92 PPI</div>
                        </div>
                        <div class="screen-box high-ppi">
                            <div class="pixel-grid"></div>
                            <div class="screen-label" id="highPpiLabel">326 PPI</div>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Common Device Comparison</h3>
                    <div class="device-comparison">
                        <div class="device-card">
                            <h4>iPhone 15 Pro</h4>
                            <div class="ppi">460 PPI</div>
                            <div class="resolution">2556 × 1179</div>
                        </div>
                        <div class="device-card">
                            <h4>4K Monitor</h4>
                            <div class="ppi">163 PPI</div>
                            <div class="resolution">3840 × 2160</div>
                        </div>
                        <div class="device-card">
                            <h4>Your Display</h4>
                            <div class="ppi" id="yourPpi">92 PPI</div>
                            <div class="resolution" id="yourResolution">1920 × 1080</div>
                        </div>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> PPI (Pixels Per Inch) measures display sharpness. Higher PPI means sharper images. The "Retina" threshold is when individual pixels become indistinguishable to the human eye at normal viewing distances.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📱 Pixel Density Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced display quality and PPI calculations</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('densityForm');
        let currentPreset = '';

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculatePixelDensity();
        });

        function setPreset(name, resX, resY, size) {
            document.getElementById('resolutionX').value = resX;
            document.getElementById('resolutionY').value = resY;
            document.getElementById('screenSize').value = size;
            document.getElementById('sizeUnit').value = 'inches';
            currentPreset = name;
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculatePixelDensity();
        }

        function calculatePixelDensity() {
            // Get inputs
            const resolutionX = parseInt(document.getElementById('resolutionX').value);
            const resolutionY = parseInt(document.getElementById('resolutionY').value);
            let screenSize = parseFloat(document.getElementById('screenSize').value);
            const sizeUnit = document.getElementById('sizeUnit').value;
            let viewingDistance = parseFloat(document.getElementById('viewingDistance').value);
            const distanceUnit = document.getElementById('distanceUnit').value;
            const visualAcuity = document.getElementById('visualAcuity').value;
            
            // Convert to inches if needed
            if (sizeUnit === 'cm') {
                screenSize = screenSize / 2.54; // Convert cm to inches
            }
            
            if (distanceUnit === 'cm') {
                viewingDistance = viewingDistance / 2.54; // Convert cm to inches
            }
            
            // Calculate PPI
            const diagonalPixels = Math.sqrt(Math.pow(resolutionX, 2) + Math.pow(resolutionY, 2));
            const ppi = diagonalPixels / screenSize;
            
            // Calculate pixel pitch (distance between pixels in mm)
            const pixelPitchMm = (25.4 / ppi).toFixed(3);
            
            // Calculate screen area
            const aspectRatio = simplifyRatio(resolutionX, resolutionY);
            const screenArea = calculateScreenArea(screenSize, resolutionX, resolutionY);
            
            // Calculate total pixels and megapixels
            const totalPixels = resolutionX * resolutionY;
            const megapixels = (totalPixels / 1000000).toFixed(2);
            
            // Calculate retina threshold
            const retinaThreshold = calculateRetinaThreshold(viewingDistance, visualAcuity);
            const isRetina = ppi >= retinaThreshold;
            
            // Determine if individual pixels can be resolved
            const minResolvableAngle = parseFloat(visualAcuity.split('/')[1]) / 60; // Convert to degrees
            const pixelSize = 1 / ppi; // Size of one pixel in inches
            const angularSize = (pixelSize / viewingDistance) * (180 / Math.PI); // Angular size in degrees
            const canResolvePixels = angularSize >= minResolvableAngle;
            
            // Determine PPI category and quality
            const ppiCategory = getPpiCategory(ppi);
            const perceivedSharpness = getPerceivedSharpness(ppi, viewingDistance);
            const qualityPercentage = Math.min(100, (ppi / 500) * 100); // Scale to 500 PPI max
            
            // Update UI
            document.getElementById('ppiValue').textContent = ppi.toFixed(2);
            document.getElementById('totalPixels').textContent = formatNumber(totalPixels);
            document.getElementById('pixelPitch').textContent = pixelPitchMm + ' mm';
            document.getElementById('aspectRatio').textContent = aspectRatio;
            
            document.getElementById('ppiCategory').textContent = ppiCategory;
            document.getElementById('retinaEquivalent').textContent = isRetina ? 'Yes' : 'No';
            document.getElementById('perceivedSharpness').textContent = perceivedSharpness;
            
            document.getElementById('resolutionDisplay').textContent = `${resolutionX} × ${resolutionY}`;
            document.getElementById('screenSizeDisplay').textContent = `${screenSize.toFixed(1)} inches`;
            document.getElementById('screenArea').textContent = `${screenArea.toFixed(2)} in²`;
            document.getElementById('pixelCount').textContent = formatNumber(totalPixels) + ' pixels';
            document.getElementById('megapixels').textContent = megapixels + ' MP';
            
            document.getElementById('viewingDistanceDisplay').textContent = `${viewingDistance} inches`;
            document.getElementById('visualAcuityDisplay').textContent = `${visualAcuity} (${getAcuityDescription(visualAcuity)})`;
            document.getElementById('retinaThreshold').textContent = retinaThreshold.toFixed(1) + ' PPI';
            document.getElementById('resolvePixels').textContent = canResolvePixels ? 'Yes' : 'No';
            
            document.getElementById('yourPpi').textContent = ppi.toFixed(0) + ' PPI';
            document.getElementById('yourResolution').textContent = `${resolutionX} × ${resolutionY}`;
            
            // Update quality indicator
            document.getElementById('qualityFill').style.width = qualityPercentage + '%';
            
            // Update visual comparison
            updateVisualComparison(ppi);
        }
        
        function calculateScreenArea(diagonal, width, height) {
            const aspectRatio = width / height;
            const heightInches = diagonal / Math.sqrt(1 + Math.pow(aspectRatio, 2));
            const widthInches = heightInches * aspectRatio;
            return widthInches * heightInches;
        }
        
        function simplifyRatio(width, height) {
            // Find greatest common divisor
            const gcd = (a, b) => b === 0 ? a : gcd(b, a % b);
            const divisor = gcd(width, height);
            return `${width / divisor}:${height / divisor}`;
        }
        
        function calculateRetinaThreshold(distance, acuity) {
            // Standard calculation: PPI = 2 * distance * tan(0.000290888/2)
            // Where 0.000290888 radians ≈ 1 arcminute (typical human visual acuity)
            const arcMinutes = parseFloat(acuity.split('/')[1]);
            const radiansPerPixel = (arcMinutes / 60) * (Math.PI / 180);
            const ppi = 1 / (2 * distance * Math.tan(radiansPerPixel / 2));
            return ppi;
        }
        
        function getPpiCategory(ppi) {
            if (ppi < 100) return 'Low';
            if (ppi < 200) return 'Standard';
            if (ppi < 300) return 'High';
            if (ppi < 400) return 'Very High';
            return 'Retina/4K+';
        }
        
        function getPerceivedSharpness(ppi, distance) {
            const retinaThreshold = calculateRetinaThreshold(distance, '20/20');
            const ratio = ppi / retinaThreshold;
            
            if (ratio < 0.5) return 'Poor';
            if (ratio < 0.8) return 'Fair';
            if (ratio < 1) return 'Good';
            if (ratio < 1.5) return 'Very Good';
            return 'Excellent';
        }
        
        function getAcuityDescription(acuity) {
            switch(acuity) {
                case '20/10': return 'Excellent';
                case '20/15': return 'Very Good';
                case '20/20': return 'Average';
                case '20/30': return 'Below Average';
                case '20/40': return 'Poor';
                default: return 'Unknown';
            }
        }
        
        function formatNumber(num) {
            if (num >= 1000000) {
                return (num / 1000000).toFixed(2) + 'M';
            } else if (num >= 1000) {
                return (num / 1000).toFixed(1) + 'K';
            }
            return num.toString();
        }
        
        function updateVisualComparison(ppi) {
            // Set comparison values
            const lowPpi = Math.max(50, Math.floor(ppi * 0.5));
            const highPpi = Math.min(600, Math.ceil(ppi * 2.5));
            
            document.getElementById('lowPpiLabel').textContent = lowPpi + ' PPI';
            document.getElementById('currentPpiLabel').textContent = Math.round(ppi) + ' PPI';
            document.getElementById('highPpiLabel').textContent = highPpi + ' PPI';
            
            // Update pixel grid density based on PPI
            const currentVisual = document.getElementById('currentPpiVisual');
            const pixelSize = Math.max(2, Math.min(10, 100 / (ppi / 10)));
            currentVisual.style.backgroundSize = `${pixelSize}px ${pixelSize}px`;
            
            // Add/remove high-ppi class based on PPI
            if (ppi > 300) {
                currentVisual.classList.add('high-ppi');
            } else {
                currentVisual.classList.remove('high-ppi');
            }
        }

        // Initialize
        window.addEventListener('load', function() {
            calculatePixelDensity();
        });
    </script>
</body>
</html>
