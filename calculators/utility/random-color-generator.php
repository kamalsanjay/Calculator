<?php
/**
 * Random Color Generator
 * File: utility/random-color-generator.php
 * Description: Advanced color generator with multiple methods and formats
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Color Generator - Advanced Color Palette Tool</title>
    <meta name="description" content="Generate random colors with multiple methods: HEX, RGB, HSL, CMYK, and create beautiful color palettes.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .generator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .controls-row { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .color-display { height: 180px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .color-display::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(45deg, rgba(255,255,255,0.2) 0%, rgba(0,0,0,0.1) 100%); }
        
        .color-values { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .color-value-card { background: #f8f9fa; padding: 18px; border-radius: 10px; border-left: 4px solid #667eea; }
        .color-value-label { color: #4527a0; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .color-value { font-size: 1.15rem; font-weight: bold; color: #5e35b1; word-wrap: break-word; cursor: pointer; transition: all 0.3s; padding: 5px; border-radius: 5px; }
        .color-value:hover { background: rgba(102, 126, 234, 0.1); }
        
        .color-palette { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; margin-bottom: 25px; }
        .palette-color { height: 80px; border-radius: 8px; position: relative; cursor: pointer; transition: transform 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .palette-color:hover { transform: translateY(-5px); }
        .palette-color-value { position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); color: white; padding: 5px; font-size: 0.75rem; text-align: center; border-radius: 0 0 8px 8px; }
        
        .action-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .action-btn { padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3); }
        .action-btn.secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .action-btn.secondary:hover { border-color: #667eea; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .color-systems { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 20px 0; }
        .color-system-card { background: #f8f9fa; padding: 20px; border-radius: 10px; }
        .color-system-card h4 { color: #2c3e50; margin-bottom: 10px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #ede7f6; }
        
        .formula-box { background: #ede7f6; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #667eea; }
        .formula-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .toast { position: fixed; bottom: 20px; right: 20px; background: #2c3e50; color: white; padding: 12px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transform: translateY(100px); opacity: 0; transition: all 0.3s; z-index: 1000; }
        .toast.show { transform: translateY(0); opacity: 1; }
        
        @media (max-width: 768px) {
            .controls-row { grid-template-columns: 1fr; gap: 15px; }
            .color-palette { grid-template-columns: repeat(3, 1fr); }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎨 Advanced Random Color Generator</h1>
            <p>Generate beautiful random colors with multiple methods, formats, and create harmonious color palettes</p>
        </div>

        <div class="generator-card">
            <div class="controls-row">
                <div class="control-group">
                    <label for="generationMethod">Color Generation Method</label>
                    <select id="generationMethod">
                        <option value="random">Completely Random</option>
                        <option value="hue">Specific Hue Range</option>
                        <option value="saturation">High Saturation</option>
                        <option value="brightness">High Brightness</option>
                        <option value="pastel">Pastel Colors</option>
                        <option value="dark">Dark Colors</option>
                        <option value="warm">Warm Colors</option>
                        <option value="cool">Cool Colors</option>
                        <option value="monochromatic">Monochromatic</option>
                        <option value="analogous">Analogous</option>
                        <option value="complementary">Complementary</option>
                        <option value="triadic">Triadic</option>
                        <option value="tetradic">Tetradic</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label for="colorFormat">Output Format</label>
                    <select id="colorFormat">
                        <option value="hex">HEX (#RRGGBB)</option>
                        <option value="rgb">RGB (rgb(r,g,b))</option>
                        <option value="rgba">RGBA (rgba(r,g,b,a))</option>
                        <option value="hsl">HSL (hsl(h,s%,l%))</option>
                        <option value="hsla">HSLA (hsla(h,s%,l%,a))</option>
                        <option value="cmyk">CMYK (cmyk(c,m,y,k))</option>
                    </select>
                </div>
            </div>
            
            <div class="controls-row">
                <div class="control-group">
                    <label for="hueRange">Hue Range (0-360)</label>
                    <input type="range" id="hueRange" min="0" max="360" value="180">
                    <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                        <span>0°</span>
                        <span id="hueValue">180°</span>
                        <span>360°</span>
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="paletteSize">Palette Size</label>
                    <select id="paletteSize">
                        <option value="1">Single Color</option>
                        <option value="5" selected>5 Colors</option>
                        <option value="10">10 Colors</option>
                        <option value="15">15 Colors</option>
                    </select>
                </div>
            </div>
            
            <div class="color-display" id="colorDisplay">
                <div style="background: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; font-size: 1.2rem;" id="currentColorText">
                    #FFFFFF
                </div>
            </div>
            
            <div class="color-values">
                <div class="color-value-card">
                    <div class="color-value-label">HEX</div>
                    <div class="color-value" id="hexValue" data-format="hex">#FFFFFF</div>
                </div>
                <div class="color-value-card">
                    <div class="color-value-label">RGB</div>
                    <div class="color-value" id="rgbValue" data-format="rgb">rgb(255, 255, 255)</div>
                </div>
                <div class="color-value-card">
                    <div class="color-value-label">HSL</div>
                    <div class="color-value" id="hslValue" data-format="hsl">hsl(0, 0%, 100%)</div>
                </div>
                <div class="color-value-card">
                    <div class="color-value-label">CMYK</div>
                    <div class="color-value" id="cmykValue" data-format="cmyk">cmyk(0%, 0%, 0%, 0%)</div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="action-btn" id="generateBtn">
                    <span>🎲</span> Generate New Color
                </button>
                <button class="action-btn secondary" id="generatePaletteBtn">
                    <span>🌈</span> Generate Palette
                </button>
                <button class="action-btn secondary" id="copyColorBtn">
                    <span>📋</span> Copy Current Color
                </button>
                <button class="action-btn secondary" id="savePaletteBtn">
                    <span>💾</span> Save Palette
                </button>
            </div>
            
            <div id="paletteContainer">
                <h3 style="color: #2c3e50; margin-bottom: 15px;">Color Palette</h3>
                <div class="color-palette" id="colorPalette">
                    <!-- Palette will be generated here -->
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🎨 Color Theory & Applications</h2>
            
            <p>Understanding color theory helps create visually appealing designs. Colors can evoke emotions, create hierarchy, and improve user experience.</p>

            <h3>🌈 Color Models</h3>
            <div class="color-systems">
                <div class="color-system-card">
                    <h4>RGB (Red, Green, Blue)</h4>
                    <p>Additive color model used for digital displays. Each component ranges from 0-255.</p>
                </div>
                <div class="color-system-card">
                    <h4>HEX (Hexadecimal)</h4>
                    <p>Web representation of RGB values using hexadecimal notation (#RRGGBB).</p>
                </div>
                <div class="color-system-card">
                    <h4>HSL (Hue, Saturation, Lightness)</h4>
                    <p>More intuitive color model based on human perception of color.</p>
                </div>
                <div class="color-system-card">
                    <h4>CMYK (Cyan, Magenta, Yellow, Key/Black)</h4>
                    <p>Subtractive color model used in printing.</p>
                </div>
            </div>

            <h3>🎯 Color Harmony Methods</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Method</th>
                        <th>Description</th>
                        <th>Angle Difference</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Monochromatic</td><td>Variations of a single hue</td><td>0°</td></tr>
                    <tr><td>Analogous</td><td>Colors adjacent to each other</td><td>30°</td></tr>
                    <tr><td>Complementary</td><td>Colors opposite each other</td><td>180°</td></tr>
                    <tr><td>Split Complementary</td><td>Base color plus two adjacent to its complement</td><td>150°, 210°</td></tr>
                    <tr><td>Triadic</td><td>Three colors evenly spaced</td><td>120°</td></tr>
                    <tr><td>Tetradic</td><td>Four colors forming two complementary pairs</td><td>90°, 180°, 270°</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>HSL to RGB Conversion:</strong><br>
                • First, convert HSL to normalized values (0-1)<br>
                • Then apply conversion formulas based on hue sector<br>
                • Finally, scale to 0-255 range for RGB
            </div>

            <h3>🎨 Color Psychology</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Color</th>
                        <th>Common Associations</th>
                        <th>Use Cases</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td style="color: #FF3B30;">Red</td><td>Energy, passion, danger</td><td>Call-to-action, alerts</td></tr>
                    <tr><td style="color: #FF9500;">Orange</td><td>Creativity, enthusiasm</td><td>CTAs, highlights</td></tr>
                    <tr><td style="color: #FFCC00;">Yellow</td><td>Happiness, attention</td><td>Warnings, highlights</td></tr>
                    <tr><td style="color: #4CD964;">Green</td><td>Growth, success, nature</td><td>Success messages, eco</td></tr>
                    <tr><td style="color: #5AC8FA;">Blue</td><td>Trust, calm, professional</td><td>Corporate, tech</td></tr>
                    <tr><td style="color: #007AFF;">Dark Blue</td><td>Security, authority</td><td>Finance, government</td></tr>
                    <tr><td style="color: #5856D6;">Purple</td><td>Luxury, creativity</td><td>Beauty, creative</td></tr>
                    <tr><td style="color: #FF2D55;">Pink</td><td>Feminine, playful</td><td>Beauty, youth</td></tr>
                </tbody>
            </table>

            <h3>📱 Web Color Standards</h3>
            <ul>
                <li><strong>Web-safe colors:</strong> 216 colors that display consistently across all browsers</li>
                <li><strong>Material Design:</strong> Google's design system with specific color palettes</li>
                <li><strong>Accessibility:</strong> WCAG guidelines for color contrast ratios</li>
                <li><strong>CSS Color Module Level 4:</strong> New color spaces like lab(), lch()</li>
            </ul>

            <h3>🎓 Professional Color Tools</h3>
            <div class="formula-box">
                <strong>Popular Color Tools:</strong><br>
                • Adobe Color - Color wheel and harmony rules<br>
                • Coolors - Quick color palette generation<br>
                • Paletton - Color scheme designer<br>
                • Color Hunt - Curated color palettes<br>
                • Material Color Tool - Material Design colors
            </div>

            <h3>🔧 Technical Implementation</h3>
            <ul>
                <li><strong>CSS Variables:</strong> Use custom properties for theming</li>
                <li><strong>Color Functions:</strong> CSS color-mod() function (future)</li>
                <li><strong>Gradients:</strong> Linear, radial, and conic gradients</li>
                <li><strong>Filters:</strong> CSS filter property for color effects</li>
                <li><strong>Blend Modes:</strong> CSS blend modes for color mixing</li>
            </ul>

            <h3>📊 Color in Data Visualization</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Purpose</th>
                        <th>Color Scheme</th>
                        <th>Examples</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Categorical</td><td>Qualitative</td><td>Different categories</td></tr>
                    <tr><td>Sequential</td><td>Single hue progression</td><td>Temperature, income</td></tr>
                    <tr><td>Diverging</td><td>Two hues with neutral midpoint</td><td>Deviation from average</td></tr>
                </tbody>
            </table>

            <h3>🎨 Color Naming Systems</h3>
            <ul>
                <li><strong>Traditional names:</strong> Red, blue, green, etc.</li>
                <li><strong>CSS color names:</strong> 140+ predefined color names</li>
                <li><strong>Commercial systems:</strong> Pantone, RAL color matching</li>
                <li><strong>Scientific systems:</strong> Munsell, NCS (Natural Color System)</li>
            </ul>

            <h3>🌐 Cultural Color Meanings</h3>
            <div class="formula-box">
                <strong>Color Symbolism Varies by Culture:</strong><br>
                • White: Purity (Western) vs. Mourning (Eastern)<br>
                • Red: Danger (Western) vs. Luck (China)<br>
                • Yellow: Happiness (Western) vs. Royalty (China)<br>
                • Purple: Royalty (Western) vs. Death (Brazil)
            </div>

            <h3>💡 Color Generation Algorithms</h3>
            <ul>
                <li><strong>Random generation:</strong> Math.random() for each component</li>
                <li><strong>HSL-based:</strong> Fixed saturation/lightness, random hue</li>
                <li><strong>Golden ratio:</strong> Using φ (phi) for harmonious colors</li>
                <li><strong>Perlin noise:</strong> Smooth, natural color transitions</li>
                <li><strong>Machine learning:</strong> AI-generated color palettes</li>
            </ul>
        </div>

        <div class="footer">
            <p>🎨 Advanced Random Color Generator | Multiple Formats & Methods</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Generate HEX, RGB, HSL, CMYK colors and create beautiful palettes</p>
        </div>
    </div>

    <div class="toast" id="toast">Color copied to clipboard!</div>

    <script>
        // DOM elements
        const colorDisplay = document.getElementById('colorDisplay');
        const currentColorText = document.getElementById('currentColorText');
        const hexValue = document.getElementById('hexValue');
        const rgbValue = document.getElementById('rgbValue');
        const hslValue = document.getElementById('hslValue');
        const cmykValue = document.getElementById('cmykValue');
        const generateBtn = document.getElementById('generateBtn');
        const generatePaletteBtn = document.getElementById('generatePaletteBtn');
        const copyColorBtn = document.getElementById('copyColorBtn');
        const savePaletteBtn = document.getElementById('savePaletteBtn');
        const colorPalette = document.getElementById('colorPalette');
        const hueRange = document.getElementById('hueRange');
        const hueValue = document.getElementById('hueValue');
        const generationMethod = document.getElementById('generationMethod');
        const colorFormat = document.getElementById('colorFormat');
        const paletteSize = document.getElementById('paletteSize');
        const toast = document.getElementById('toast');

        // Current color state
        let currentColor = { r: 255, g: 255, b: 255 };
        let currentPalette = [];

        // Initialize
        updateHueValue();
        generateColor();

        // Event listeners
        generateBtn.addEventListener('click', generateColor);
        generatePaletteBtn.addEventListener('click', generatePalette);
        copyColorBtn.addEventListener('click', copyCurrentColor);
        savePaletteBtn.addEventListener('click', savePalette);
        hueRange.addEventListener('input', updateHueValue);
        
        // Color value click to copy
        [hexValue, rgbValue, hslValue, cmykValue].forEach(element => {
            element.addEventListener('click', () => {
                copyToClipboard(element.textContent);
                showToast(`${element.dataset.format.toUpperCase()} value copied!`);
            });
        });

        function updateHueValue() {
            hueValue.textContent = `${hueRange.value}°`;
        }

        function generateColor() {
            const method = generationMethod.value;
            const baseHue = parseInt(hueRange.value);
            
            switch(method) {
                case 'random':
                    currentColor = generateRandomRGB();
                    break;
                case 'hue':
                    currentColor = generateHueBasedRGB(baseHue);
                    break;
                case 'saturation':
                    currentColor = generateHighSaturationRGB(baseHue);
                    break;
                case 'brightness':
                    currentColor = generateHighBrightnessRGB(baseHue);
                    break;
                case 'pastel':
                    currentColor = generatePastelRGB(baseHue);
                    break;
                case 'dark':
                    currentColor = generateDarkRGB(baseHue);
                    break;
                case 'warm':
                    currentColor = generateWarmRGB();
                    break;
                case 'cool':
                    currentColor = generateCoolRGB();
                    break;
                case 'monochromatic':
                    currentColor = generateMonochromatic(baseHue);
                    break;
                default:
                    currentColor = generateRandomRGB();
            }
            
            updateColorDisplay();
        }

        function generatePalette() {
            const method = generationMethod.value;
            const size = parseInt(paletteSize.value);
            const baseHue = parseInt(hueRange.value);
            
            currentPalette = [];
            
            switch(method) {
                case 'analogous':
                    currentPalette = generateAnalogousPalette(baseHue, size);
                    break;
                case 'complementary':
                    currentPalette = generateComplementaryPalette(baseHue, size);
                    break;
                case 'triadic':
                    currentPalette = generateTriadicPalette(baseHue, size);
                    break;
                case 'tetradic':
                    currentPalette = generateTetradicPalette(baseHue, size);
                    break;
                default:
                    // For other methods, generate multiple random colors
                    for (let i = 0; i < size; i++) {
                        generateColor();
                        currentPalette.push({...currentColor});
                    }
            }
            
            displayPalette();
        }

        function displayPalette() {
            colorPalette.innerHTML = '';
            
            currentPalette.forEach(color => {
                const hex = rgbToHex(color.r, color.g, color.b);
                const colorElement = document.createElement('div');
                colorElement.className = 'palette-color';
                colorElement.style.backgroundColor = hex;
                colorElement.innerHTML = `<div class="palette-color-value">${hex}</div>`;
                
                colorElement.addEventListener('click', () => {
                    currentColor = color;
                    updateColorDisplay();
                });
                
                colorPalette.appendChild(colorElement);
            });
        }

        function updateColorDisplay() {
            const hex = rgbToHex(currentColor.r, currentColor.g, currentColor.b);
            const rgb = `rgb(${currentColor.r}, ${currentColor.g}, ${currentColor.b})`;
            const hsl = rgbToHsl(currentColor.r, currentColor.g, currentColor.b);
            const cmyk = rgbToCmyk(currentColor.r, currentColor.g, currentColor.b);
            
            // Update display
            colorDisplay.style.backgroundColor = hex;
            currentColorText.textContent = hex;
            currentColorText.style.color = getContrastColor(hex);
            
            // Update values based on selected format
            const format = colorFormat.value;
            switch(format) {
                case 'hex':
                    hexValue.textContent = hex;
                    rgbValue.textContent = rgb;
                    hslValue.textContent = hsl;
                    cmykValue.textContent = cmyk;
                    break;
                case 'rgb':
                    hexValue.textContent = hex;
                    rgbValue.textContent = rgb;
                    hslValue.textContent = hsl;
                    cmykValue.textContent = cmyk;
                    break;
                case 'rgba':
                    const rgba = `rgba(${currentColor.r}, ${currentColor.g}, ${currentColor.b}, 1)`;
                    hexValue.textContent = hex;
                    rgbValue.textContent = rgba;
                    hslValue.textContent = `hsla(${hslToValues(hsl).h}, ${hslToValues(hsl).s}%, ${hslToValues(hsl).l}%, 1)`;
                    cmykValue.textContent = cmyk;
                    break;
                case 'hsl':
                    hexValue.textContent = hex;
                    rgbValue.textContent = rgb;
                    hslValue.textContent = hsl;
                    cmykValue.textContent = cmyk;
                    break;
                case 'hsla':
                    const hsla = `hsla(${hslToValues(hsl).h}, ${hslToValues(hsl).s}%, ${hslToValues(hsl).l}%, 1)`;
                    hexValue.textContent = hex;
                    rgbValue.textContent = rgb;
                    hslValue.textContent = hsla;
                    cmykValue.textContent = cmyk;
                    break;
                case 'cmyk':
                    hexValue.textContent = hex;
                    rgbValue.textContent = rgb;
                    hslValue.textContent = hsl;
                    cmykValue.textContent = cmyk;
                    break;
            }
        }

        function copyCurrentColor() {
            const format = colorFormat.value;
            let textToCopy = '';
            
            switch(format) {
                case 'hex':
                    textToCopy = rgbToHex(currentColor.r, currentColor.g, currentColor.b);
                    break;
                case 'rgb':
                    textToCopy = `rgb(${currentColor.r}, ${currentColor.g}, ${currentColor.b})`;
                    break;
                case 'rgba':
                    textToCopy = `rgba(${currentColor.r}, ${currentColor.g}, ${currentColor.b}, 1)`;
                    break;
                case 'hsl':
                    textToCopy = rgbToHsl(currentColor.r, currentColor.g, currentColor.b);
                    break;
                case 'hsla':
                    const hsl = rgbToHsl(currentColor.r, currentColor.g, currentColor.b);
                    const hslValues = hslToValues(hsl);
                    textToCopy = `hsla(${hslValues.h}, ${hslValues.s}%, ${hslValues.l}%, 1)`;
                    break;
                case 'cmyk':
                    textToCopy = rgbToCmyk(currentColor.r, currentColor.g, currentColor.b);
                    break;
            }
            
            copyToClipboard(textToCopy);
            showToast('Color copied to clipboard!');
        }

        function savePalette() {
            if (currentPalette.length === 0) {
                showToast('Generate a palette first!');
                return;
            }
            
            let paletteText = 'Color Palette:\n\n';
            currentPalette.forEach(color => {
                const hex = rgbToHex(color.r, color.g, color.b);
                paletteText += `${hex} - RGB(${color.r}, ${color.g}, ${color.b})\n`;
            });
            
            // Create a blob and download
            const blob = new Blob([paletteText], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'color-palette.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            
            showToast('Palette saved!');
        }

        // Color generation functions
        function generateRandomRGB() {
            return {
                r: Math.floor(Math.random() * 256),
                g: Math.floor(Math.random() * 256),
                b: Math.floor(Math.random() * 256)
            };
        }

        function generateHueBasedRGB(hue) {
            return hslToRgb(hue, 70 + Math.random() * 30, 50 + Math.random() * 30);
        }

        function generateHighSaturationRGB(hue) {
            return hslToRgb(hue, 80 + Math.random() * 20, 40 + Math.random() * 30);
        }

        function generateHighBrightnessRGB(hue) {
            return hslToRgb(hue, 60 + Math.random() * 30, 70 + Math.random() * 20);
        }

        function generatePastelRGB(hue) {
            return hslToRgb(hue, 40 + Math.random() * 30, 80 + Math.random() * 15);
        }

        function generateDarkRGB(hue) {
            return hslToRgb(hue, 50 + Math.random() * 30, 20 + Math.random() * 20);
        }

        function generateWarmRGB() {
            const hue = 10 + Math.random() * 50; // Red to yellow range
            return hslToRgb(hue, 70 + Math.random() * 20, 50 + Math.random() * 30);
        }

        function generateCoolRGB() {
            const hue = 180 + Math.random() * 120; // Green to blue range
            return hslToRgb(hue, 70 + Math.random() * 20, 50 + Math.random() * 30);
        }

        function generateMonochromatic(baseHue) {
            const saturation = 50 + Math.random() * 40;
            const lightness = 30 + Math.random() * 40;
            return hslToRgb(baseHue, saturation, lightness);
        }

        function generateAnalogousPalette(baseHue, size) {
            const palette = [];
            const hueStep = 30;
            const startHue = baseHue - Math.floor(size / 2) * hueStep;
            
            for (let i = 0; i < size; i++) {
                const hue = (startHue + i * hueStep) % 360;
                palette.push(hslToRgb(hue, 70 + Math.random() * 20, 50 + Math.random() * 30));
            }
            
            return palette;
        }

        function generateComplementaryPalette(baseHue, size) {
            const palette = [];
            const compHue = (baseHue + 180) % 360;
            
            // Generate variations of base and complementary colors
            for (let i = 0; i < size; i++) {
                const hue = i % 2 === 0 ? baseHue : compHue;
                const saturation = 60 + Math.random() * 30;
                const lightness = 40 + Math.random() * 40;
                palette.push(hslToRgb(hue, saturation, lightness));
            }
            
            return palette;
        }

        function generateTriadicPalette(baseHue, size) {
            const palette = [];
            const hues = [baseHue, (baseHue + 120) % 360, (baseHue + 240) % 360];
            
            for (let i = 0; i < size; i++) {
                const hue = hues[i % 3];
                const saturation = 60 + Math.random() * 30;
                const lightness = 40 + Math.random() * 40;
                palette.push(hslToRgb(hue, saturation, lightness));
            }
            
            return palette;
        }

        function generateTetradicPalette(baseHue, size) {
            const palette = [];
            const hues = [baseHue, (baseHue + 90) % 360, (baseHue + 180) % 360, (baseHue + 270) % 360];
            
            for (let i = 0; i < size; i++) {
                const hue = hues[i % 4];
                const saturation = 60 + Math.random() * 30;
                const lightness = 40 + Math.random() * 40;
                palette.push(hslToRgb(hue, saturation, lightness));
            }
            
            return palette;
        }

        // Color conversion functions
        function rgbToHex(r, g, b) {
            return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1).toUpperCase();
        }

        function rgbToHsl(r, g, b) {
            r /= 255;
            g /= 255;
            b /= 255;
            
            const max = Math.max(r, g, b);
            const min = Math.min(r, g, b);
            let h, s, l = (max + min) / 2;
            
            if (max === min) {
                h = s = 0; // achromatic
            } else {
                const d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                
                switch (max) {
                    case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                    case g: h = (b - r) / d + 2; break;
                    case b: h = (r - g) / d + 4; break;
                }
                
                h /= 6;
            }
            
            return `hsl(${Math.round(h * 360)}, ${Math.round(s * 100)}%, ${Math.round(l * 100)}%)`;
        }

        function hslToValues(hslString) {
            const matches = hslString.match(/hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)/);
            return {
                h: parseInt(matches[1]),
                s: parseInt(matches[2]),
                l: parseInt(matches[3])
            };
        }

        function hslToRgb(h, s, l) {
            h /= 360;
            s /= 100;
            l /= 100;
            
            let r, g, b;
            
            if (s === 0) {
                r = g = b = l; // achromatic
            } else {
                const hue2rgb = (p, q, t) => {
                    if (t < 0) t += 1;
                    if (t > 1) t -= 1;
                    if (t < 1/6) return p + (q - p) * 6 * t;
                    if (t < 1/2) return q;
                    if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
                    return p;
                };
                
                const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
                const p = 2 * l - q;
                
                r = hue2rgb(p, q, h + 1/3);
                g = hue2rgb(p, q, h);
                b = hue2rgb(p, q, h - 1/3);
            }
            
            return {
                r: Math.round(r * 255),
                g: Math.round(g * 255),
                b: Math.round(b * 255)
            };
        }

        function rgbToCmyk(r, g, b) {
            if (r === 0 && g === 0 && b === 0) {
                return 'cmyk(0%, 0%, 0%, 100%)';
            }
            
            r /= 255;
            g /= 255;
            b /= 255;
            
            const k = 1 - Math.max(r, g, b);
            const c = (1 - r - k) / (1 - k);
            const m = (1 - g - k) / (1 - k);
            const y = (1 - b - k) / (1 - k);
            
            return `cmyk(${Math.round(c * 100)}%, ${Math.round(m * 100)}%, ${Math.round(y * 100)}%, ${Math.round(k * 100)}%)`;
        }

        function getContrastColor(hexColor) {
            // Convert hex to RGB
            const r = parseInt(hexColor.substr(1, 2), 16);
            const g = parseInt(hexColor.substr(3, 2), 16);
            const b = parseInt(hexColor.substr(5, 2), 16);
            
            // Calculate relative luminance
            const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
            
            return luminance > 0.5 ? '#000000' : '#FFFFFF';
        }

        // Utility functions
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }

        function showToast(message) {
            toast.textContent = message;
            toast.classList.add('show');
            
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>
