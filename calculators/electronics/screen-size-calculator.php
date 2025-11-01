<?php
/**
 * Screen Size Calculator
 * File: electronics/screen-size-calculator.php
 * Description: Advanced calculator for screen dimensions, aspect ratios, and viewing distances
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screen Size Calculator - Display Dimensions & Aspect Ratio</title>
    <meta name="description" content="Advanced screen size calculator. Calculate screen dimensions, aspect ratios, pixel density, viewing distances, and compare display sizes.">
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
        .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; }
        .result-card .amount { font-size: 3rem; font-weight: bold; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #667eea; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #667eea; font-size: 1.6rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #667eea; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .screen-visual { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; text-align: center; }
        .screen-box { display: inline-block; border: 3px solid #667eea; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); position: relative; margin: 20px auto; }
        .screen-diagonal { position: absolute; top: -2px; left: -2px; right: -2px; bottom: -2px; }
        .diagonal-line { stroke: #764ba2; stroke-width: 2; stroke-dasharray: 5,5; }
        
        .aspect-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; margin-top: 10px; }
        .aspect-btn { padding: 8px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .aspect-btn:hover { background: #667eea; color: white; border-color: #667eea; }
        
        .info-box { background: #e8f2ff; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: repeat(2, 1fr); }
            .input-group { grid-template-columns: 1fr; }
            .input-row { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
            .metric-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🖥️ Screen Size Calculator</h1>
            <p>Calculate screen dimensions, aspect ratios, and viewing distances</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Screen Parameters</h2>
                <form id="screenForm">
                    <div class="form-group">
                        <label for="calcMode">Calculation Mode</label>
                        <select id="calcMode">
                            <option value="diagonal">From Diagonal Size</option>
                            <option value="dimensions">From Width & Height</option>
                        </select>
                        <small>Choose input method</small>
                    </div>
                    
                    <div class="form-group" id="diagonalGroup">
                        <label for="diagonal">Diagonal Size</label>
                        <div class="input-group">
                            <input type="number" id="diagonal" value="27" min="1" max="200" step="0.1" required>
                            <select id="diagonalUnit" style="padding: 12px;">
                                <option value="inches" selected>Inches</option>
                                <option value="cm">cm</option>
                            </select>
                        </div>
                        <small>Screen diagonal measurement</small>
                    </div>
                    
                    <div class="form-group" id="dimensionsGroup" style="display: none;">
                        <label>Screen Dimensions</label>
                        <div class="input-row">
                            <div>
                                <input type="number" id="width" value="23.5" min="1" step="0.1">
                                <small>Width (inches)</small>
                            </div>
                            <div>
                                <input type="number" id="height" value="13.2" min="1" step="0.1">
                                <small>Height (inches)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="aspectRatio">Aspect Ratio</label>
                        <select id="aspectRatio">
                            <option value="16:9" selected>16:9 (Widescreen)</option>
                            <option value="16:10">16:10 (WUXGA)</option>
                            <option value="21:9">21:9 (Ultrawide)</option>
                            <option value="32:9">32:9 (Super Ultrawide)</option>
                            <option value="4:3">4:3 (Standard)</option>
                            <option value="5:4">5:4 (SXGA)</option>
                            <option value="3:2">3:2 (Surface)</option>
                            <option value="1:1">1:1 (Square)</option>
                            <option value="custom">Custom Ratio</option>
                        </select>
                        <small>Display aspect ratio</small>
                    </div>
                    
                    <div class="form-group" id="customRatioGroup" style="display: none;">
                        <label>Custom Aspect Ratio</label>
                        <div class="input-row">
                            <div>
                                <input type="number" id="customWidth" value="16" min="1" step="1">
                                <small>Width ratio</small>
                            </div>
                            <div>
                                <input type="number" id="customHeight" value="9" min="1" step="1">
                                <small>Height ratio</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Aspect Presets</label>
                        <div class="aspect-preset">
                            <div class="aspect-btn" onclick="setAspect('16:9')">16:9</div>
                            <div class="aspect-btn" onclick="setAspect('21:9')">21:9</div>
                            <div class="aspect-btn" onclick="setAspect('4:3')">4:3</div>
                            <div class="aspect-btn" onclick="setAspect('1:1')">1:1</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Resolution (Optional)</label>
                        <div class="input-row">
                            <div>
                                <input type="number" id="resWidth" value="1920" min="1" step="1">
                                <small>Width (pixels)</small>
                            </div>
                            <div>
                                <input type="number" id="resHeight" value="1080" min="1" step="1">
                                <small>Height (pixels)</small>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Screen Size</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Screen Analysis</h2>
                
                <div class="result-card">
                    <h3>Screen Diagonal</h3>
                    <div class="amount" id="resultDiagonal">27"</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Width</h4>
                        <div class="value" id="resultWidth">23.5"</div>
                    </div>
                    <div class="metric-card">
                        <h4>Height</h4>
                        <div class="value" id="resultHeight">13.2"</div>
                    </div>
                    <div class="metric-card">
                        <h4>Area</h4>
                        <div class="value" id="resultArea">310 in²</div>
                    </div>
                    <div class="metric-card">
                        <h4>PPI</h4>
                        <div class="value" id="resultPPI">82</div>
                    </div>
                </div>

                <div class="screen-visual">
                    <h3 style="color: #667eea; margin-bottom: 15px;">Screen Visualization</h3>
                    <div class="screen-box" id="screenBox" style="width: 200px; height: 113px;">
                        <svg width="100%" height="100%" style="position: absolute; top: 0; left: 0;">
                            <line x1="0" y1="0" x2="100%" y2="100%" class="diagonal-line"/>
                        </svg>
                        <div style="position: relative; z-index: 1; padding: 10px; font-size: 0.9rem; color: #667eea; font-weight: bold;">
                            16:9
                        </div>
                    </div>
                    <div style="margin-top: 10px; font-size: 0.85rem; color: #666;">
                        Relative size representation
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Dimensions</h3>
                    <div class="breakdown-item">
                        <span>Diagonal (inches)</span>
                        <strong id="diagInches">27.0"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Diagonal (cm)</span>
                        <strong id="diagCm">68.6 cm</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Width (inches)</span>
                        <strong id="widthInches">23.5"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Width (cm)</span>
                        <strong id="widthCm">59.7 cm</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Height (inches)</span>
                        <strong id="heightInches">13.2"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Height (cm)</span>
                        <strong id="heightCm">33.5 cm</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Display Properties</h3>
                    <div class="breakdown-item">
                        <span>Aspect Ratio</span>
                        <strong id="aspectDisplay">16:9</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Screen Area</span>
                        <strong id="areaDisplay">310.2 in²</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Resolution</span>
                        <strong id="resDisplay">1920 × 1080</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Pixel Density (PPI)</span>
                        <strong id="ppiDisplay">81.6 PPI</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Pixels</span>
                        <strong id="totalPixels">2,073,600</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Viewing Distance</h3>
                    <div class="breakdown-item">
                        <span>Optimal Distance (TV)</span>
                        <strong id="tvDistance">3.4 - 5.6 ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Optimal Distance (Monitor)</span>
                        <strong id="monitorDistance">27 - 35 inches</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Min Distance (1080p)</span>
                        <strong id="minDistance">2.8 ft</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Max Distance (1080p)</span>
                        <strong id="maxDistance">6.7 ft</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Screen Comparison</h3>
                    <div class="breakdown-item">
                        <span>Compare to 24" (16:9)</span>
                        <strong>26% larger</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Compare to 32" (16:9)</span>
                        <strong>28% smaller</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Same height as</span>
                        <strong>~15" (4:3) display</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Viewing Distance Guidelines:</strong><br>
                    • TV: 1.5-2.5× diagonal for comfortable viewing<br>
                    • Monitor: 1-1.3× diagonal (arm's length typical)<br>
                    • Mobile: 10-16 inches from eyes
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🖥️ Screen Size Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Professional screen dimension and aspect ratio calculations</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('screenForm');
        const calcModeSelect = document.getElementById('calcMode');
        const aspectRatioSelect = document.getElementById('aspectRatio');
        const diagonalGroup = document.getElementById('diagonalGroup');
        const dimensionsGroup = document.getElementById('dimensionsGroup');
        const customRatioGroup = document.getElementById('customRatioGroup');

        calcModeSelect.addEventListener('change', function() {
            if (this.value === 'diagonal') {
                diagonalGroup.style.display = 'block';
                dimensionsGroup.style.display = 'none';
            } else {
                diagonalGroup.style.display = 'none';
                dimensionsGroup.style.display = 'block';
            }
            calculateScreen();
        });

        aspectRatioSelect.addEventListener('change', function() {
            customRatioGroup.style.display = this.value === 'custom' ? 'block' : 'none';
            calculateScreen();
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateScreen();
        });

        function setAspect(ratio) {
            document.getElementById('aspectRatio').value = ratio;
            customRatioGroup.style.display = 'none';
            calculateScreen();
        }

        function calculateScreen() {
            const calcMode = document.getElementById('calcMode').value;
            const aspectRatioValue = document.getElementById('aspectRatio').value;
            
            let aspectW, aspectH;
            if (aspectRatioValue === 'custom') {
                aspectW = parseFloat(document.getElementById('customWidth').value);
                aspectH = parseFloat(document.getElementById('customHeight').value);
            } else {
                [aspectW, aspectH] = aspectRatioValue.split(':').map(Number);
            }
            
            const aspectRatio = aspectW / aspectH;
            
            let diagonal, width, height;
            
            if (calcMode === 'diagonal') {
                diagonal = parseFloat(document.getElementById('diagonal').value);
                const unit = document.getElementById('diagonalUnit').value;
                if (unit === 'cm') diagonal = diagonal / 2.54;
                
                // Calculate width and height from diagonal
                width = diagonal * Math.sqrt(aspectRatio * aspectRatio / (aspectRatio * aspectRatio + 1));
                height = width / aspectRatio;
            } else {
                width = parseFloat(document.getElementById('width').value);
                height = parseFloat(document.getElementById('height').value);
                diagonal = Math.sqrt(width * width + height * height);
            }
            
            // Resolution
            const resWidth = parseInt(document.getElementById('resWidth').value);
            const resHeight = parseInt(document.getElementById('resHeight').value);
            const totalPixels = resWidth * resHeight;
            
            // Calculate PPI
            const ppi = Math.sqrt(resWidth * resWidth + resHeight * resHeight) / diagonal;
            
            // Screen area
            const area = width * height;
            
            // Viewing distances
            const tvDistanceMin = (diagonal * 1.5) / 12; // feet
            const tvDistanceMax = (diagonal * 2.5) / 12; // feet
            const monitorDistanceMin = diagonal * 1.0;
            const monitorDistanceMax = diagonal * 1.3;
            
            // For 1080p
            const minDistance1080 = (diagonal / 1.6) / 12; // feet
            const maxDistance1080 = (diagonal / 0.67) / 12; // feet
            
            // Update UI
            document.getElementById('resultDiagonal').textContent = diagonal.toFixed(1) + '"';
            document.getElementById('resultWidth').textContent = width.toFixed(1) + '"';
            document.getElementById('resultHeight').textContent = height.toFixed(1) + '"';
            document.getElementById('resultArea').textContent = Math.round(area) + ' in²';
            document.getElementById('resultPPI').textContent = Math.round(ppi);
            
            // Dimensions
            document.getElementById('diagInches').textContent = diagonal.toFixed(1) + '"';
            document.getElementById('diagCm').textContent = (diagonal * 2.54).toFixed(1) + ' cm';
            document.getElementById('widthInches').textContent = width.toFixed(1) + '"';
            document.getElementById('widthCm').textContent = (width * 2.54).toFixed(1) + ' cm';
            document.getElementById('heightInches').textContent = height.toFixed(1) + '"';
            document.getElementById('heightCm').textContent = (height * 2.54).toFixed(1) + ' cm';
            
            // Display properties
            document.getElementById('aspectDisplay').textContent = aspectW + ':' + aspectH;
            document.getElementById('areaDisplay').textContent = area.toFixed(1) + ' in²';
            document.getElementById('resDisplay').textContent = resWidth + ' × ' + resHeight;
            document.getElementById('ppiDisplay').textContent = ppi.toFixed(1) + ' PPI';
            document.getElementById('totalPixels').textContent = totalPixels.toLocaleString();
            
            // Viewing distances
            document.getElementById('tvDistance').textContent = tvDistanceMin.toFixed(1) + ' - ' + tvDistanceMax.toFixed(1) + ' ft';
            document.getElementById('monitorDistance').textContent = monitorDistanceMin.toFixed(0) + ' - ' + monitorDistanceMax.toFixed(0) + ' inches';
            document.getElementById('minDistance').textContent = minDistance1080.toFixed(1) + ' ft';
            document.getElementById('maxDistance').textContent = maxDistance1080.toFixed(1) + ' ft';
            
            // Update visual
            const screenBox = document.getElementById('screenBox');
            const maxSize = 300;
            const scale = Math.min(maxSize / width, maxSize / height, 1.5);
            const visualWidth = width * scale;
            const visualHeight = height * scale;
            
            screenBox.style.width = visualWidth + 'px';
            screenBox.style.height = visualHeight + 'px';
            screenBox.querySelector('div').textContent = aspectW + ':' + aspectH;
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateScreen();
        });
    </script>
</body>
</html>