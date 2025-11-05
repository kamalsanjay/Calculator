<?php
/**
 * Body Type Calculator
 * File: body-type-calculator.php
 * Description: Determine body shape/type (somatotype) and measurements (Imperial/Metric)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Body Type Calculator - Somatotype & Body Shape (Imperial/Metric)</title>
    <meta name="description" content="Free body type calculator. Determine your somatotype (ectomorph, mesomorph, endomorph) and body shape (pear, apple, hourglass, rectangle). Imperial and metric units.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>&#129489; Body Type Calculator</h1>
        <p>Discover your body shape & somatotype</p>
    </header>
<style>
    * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        header p {
            font-size: 1.2em;
            opacity: 0.9;
        }
        
        .breadcrumb {
            margin: 20px 0;
        }
        
        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #5568d3;
        }
        
        .calculator-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }
        
        .calculator-section,
        .results-section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .calculator-section h2,
        .results-section h2 {
            color: #667eea;
            margin-bottom: 25px;
            font-size: 1.8em;
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
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #888;
            font-size: 0.9em;
        }
        
        .btn {
            background: #667eea;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #5568d3;
        }
        
        .result-card {
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        
        .result-card h3 {
            font-size: 1.2em;
            opacity: 0.9;
            margin-bottom: 10px;
            font-weight: 400;
        }
        
        .result-card .amount {
            font-size: 3em;
            font-weight: bold;
        }
        
        .result-card .category {
            font-size: 1.3em;
            margin-top: 10px;
            opacity: 0.95;
        }
        
        .underweight {
            background: linear-gradient(135deg, #42a5f5 0%, #1976d2 100%);
        }
        
        .normal {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .overweight {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
        }
        
        .obese {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        }
        
        .metric-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .metric-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #e0e0e0;
        }
        
        .metric-card h4 {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
            font-weight: 400;
        }
        
        .metric-card .value {
            color: #667eea;
            font-size: 2em;
            font-weight: bold;
        }
        
        .breakdown {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .breakdown h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.3em;
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
        
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .info-box strong {
            color: #1976D2;
        }
        
        @media (max-width: 768px) {
            .calculator-wrapper {
                grid-template-columns: 1fr;
            }
            
            header h1 {
                font-size: 2em;
            }
            
            .result-card .amount {
                font-size: 2.5em;
            }
            
            .metric-grid {
                grid-template-columns: 1fr;
            }
        }
</style>
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">&larr; Back to Health Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Your Information</h2>
                <form id="bodyTypeForm">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="imperial">Imperial (lbs/inches)</option>
                            <option value="metric">Metric (kg/cm)</option>
                        </select>
                    </div>
                    
                    <h3 style="color: #667eea; margin: 25px 0 15px;">Height & Weight</h3>
                    
                    <div class="form-group" id="heightImperialGroup">
                        <label for="heightFeet">Height</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="heightFeet" value="5" min="3" max="8" step="1" style="flex: 1;" placeholder="Feet">
                            <input type="number" id="heightInches" value="6" min="0" max="11" step="0.5" style="flex: 1;" placeholder="Inches">
                        </div>
                    </div>

                    <div class="form-group" id="heightMetricGroup" style="display: none;">
                        <label for="heightCm">Height (cm)</label>
                        <input type="number" id="heightCm" value="168" min="100" max="250" step="0.1">
                    </div>
                    
                    <div class="form-group" id="weightImperialGroup">
                        <label for="weightLbs">Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="150" min="50" max="500" step="0.1" required>
                    </div>

                    <div class="form-group" id="weightMetricGroup" style="display: none;">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="68" min="20" max="250" step="0.1">
                    </div>
                    
                    <h3 style="color: #FF9800; margin: 25px 0 15px;">Body Measurements</h3>
                    
                    <div class="form-group">
                        <label for="shoulders">Shoulder Width (<span id="shoulderUnit">inches</span>)</label>
                        <input type="number" id="shoulders" value="16" min="10" max="30" step="0.1">
                        <small>Measure across widest point of shoulders</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="bust">Bust/Chest (<span id="bustUnit">inches</span>)</label>
                        <input type="number" id="bust" value="36" min="20" max="60" step="0.1" required>
                        <small>Measure around fullest part</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="waist">Waist (<span id="waistUnit">inches</span>)</label>
                        <input type="number" id="waist" value="28" min="15" max="60" step="0.1" required>
                        <small>Measure at narrowest point</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="hips">Hips (<span id="hipsUnit">inches</span>)</label>
                        <input type="number" id="hips" value="38" min="20" max="70" step="0.1" required>
                        <small>Measure at widest point</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="wrist">Wrist (<span id="wristUnit">inches</span>)</label>
                        <input type="number" id="wrist" value="6" min="4" max="10" step="0.1">
                        <small>Measure around smallest part of wrist</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Body Type</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Body Type Results</h2>
                
                <div class="result-card success" id="resultCard">
                    <h3>Your Body Shape</h3>
                    <div class="amount" id="bodyShapeResult" style="font-size: 2.5em;">⌛</div>
                    <div style="margin-top: 10px; font-size: 1.5em;" id="bodyShapeName">Hourglass</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Body Shape</h4>
                        <div class="value" id="shapeDisplay">Hourglass</div>
                    </div>
                    <div class="metric-card">
                        <h4>Somatotype</h4>
                        <div class="value" id="somatotypeDisplay">Mesomorph</div>
                    </div>
                    <div class="metric-card">
                        <h4>WHR</h4>
                        <div class="value" id="whrDisplay">0.74</div>
                    </div>
                    <div class="metric-card">
                        <h4>Frame Size</h4>
                        <div class="value" id="frameDisplay">Medium</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Measurements</h3>
                    <div class="breakdown-item">
                        <span>Height</span>
                        <strong id="heightDisplay">5'6"</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight</span>
                        <strong id="weightDisplay">150 lbs</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Shoulders</span>
                        <strong id="shouldersDisplay">16 in</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Bust/Chest</span>
                        <strong id="bustDisplay">36 in</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waist</span>
                        <strong id="waistDisplay">28 in</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hips</span>
                        <strong id="hipsDisplay">38 in</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Wrist</span>
                        <strong id="wristDisplay">6 in</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Body Shape Analysis</h3>
                    <div class="breakdown-item">
                        <span>Body Shape</span>
                        <strong id="shapeCalc" style="color: #667eea; font-size: 1.1em;">Hourglass</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waist-to-Hip Ratio (WHR)</span>
                        <strong id="whrCalc">0.74</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Bust-to-Hip Ratio</span>
                        <strong id="bustHipRatio">0.95</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Waist-to-Bust Ratio</span>
                        <strong id="waistBustRatio">0.78</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Somatotype (Body Frame)</h3>
                    <div class="breakdown-item">
                        <span>Classification</span>
                        <strong id="somatotypeCalc" style="color: #667eea;">Mesomorph</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Frame Size</span>
                        <strong id="frameSizeCalc">Medium</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Height-Wrist Ratio</span>
                        <strong id="wristRatio">11.0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Female Body Shapes</h3>
                    <div class="breakdown-item">
                        <span>⌛ Hourglass</span>
                        <strong style="color: #667eea;">Balanced bust & hips, defined waist</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>🍐 Pear (Triangle)</span>
                        <strong>Hips wider than bust, defined waist</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>🍎 Apple (Round)</span>
                        <strong>Weight around midsection, wider waist</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>📏 Rectangle (Banana)</span>
                        <strong>Bust, waist, hips similar size</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>🔺 Inverted Triangle</span>
                        <strong>Broader shoulders, narrower hips</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Male Body Shapes</h3>
                    <div class="breakdown-item">
                        <span>🔺 Inverted Triangle</span>
                        <strong style="color: #667eea;">Broad shoulders, narrow waist (V-shape)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>📏 Rectangle</span>
                        <strong>Shoulders, waist, hips similar width</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>🔻 Triangle</span>
                        <strong>Narrow shoulders, wider hips</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>🍎 Oval (Apple)</span>
                        <strong>Weight around midsection</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>💪 Trapezoid</span>
                        <strong>Athletic build, defined muscles</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Somatotypes Explained</h3>
                    <div class="breakdown-item">
                        <span>Ectomorph</span>
                        <strong style="color: #2196F3;">Lean, long, small frame, fast metabolism</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Mesomorph</span>
                        <strong style="color: #4CAF50;">Athletic, muscular, medium frame</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Endomorph</span>
                        <strong style="color: #FF9800;">Larger build, stores fat easily, slower metabolism</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Waist-to-Hip Ratio (WHR)</h3>
                    <div class="breakdown-item">
                        <span>Your WHR</span>
                        <strong id="yourWHR" style="color: #667eea;">0.74</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Health Status</span>
                        <strong id="whrHealth">Low Risk</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Women - Low Risk</span>
                        <strong style="color: #4CAF50;">&lt; 0.80</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Women - Moderate Risk</span>
                        <strong style="color: #FF9800;">0.81 - 0.85</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Women - High Risk</span>
                        <strong style="color: #f44336;">&gt; 0.85</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Men - Low Risk</span>
                        <strong style="color: #4CAF50;">&lt; 0.90</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Men - Moderate Risk</span>
                        <strong style="color: #FF9800;">0.90 - 1.0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Men - High Risk</span>
                        <strong style="color: #f44336;">&gt; 1.0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Your Body Shape Description</h3>
                    <div id="shapeDescription" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="descriptionText"></p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Style Tips for Your Shape</h3>
                    <div id="styleTips" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="styleTipsText"></p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Fitness Tips for Your Somatotype</h3>
                    <div id="fitnessTips" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="fitnessTipsText"></p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>What This Means</h3>
                    <div id="analysis" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="analysisText" style="margin: 0;"></p>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Body Type Tips:</strong> Body shape = genetic distribution of weight/fat. Somatotype = body frame/build. Hourglass = balanced, defined waist. Pear = fuller hips. Apple = weight at middle. Rectangle = straight up/down. Inverted triangle = broad shoulders. Ectomorph = lean/fast metabolism. Mesomorph = athletic/muscular. Endomorph = stores fat easily. WHR = waist÷hips. Frame size = height÷wrist ratio. Body type ≠ body fat %. All shapes can be healthy. Genetics determine shape. Can't change basic shape. Can change body composition. Everyone is unique. Embrace your natural shape!
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('bodyTypeForm');
        const unitSystemSelect = document.getElementById('unitSystem');

        unitSystemSelect.addEventListener('change', function() {
            toggleUnitFields();
            calculateBodyType();
        });

        function toggleUnitFields() {
            const unitSystem = unitSystemSelect.value;
            const isImperial = unitSystem === 'imperial';
            
            document.getElementById('heightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('heightMetricGroup').style.display = isImperial ? 'none' : 'block';
            document.getElementById('weightImperialGroup').style.display = isImperial ? 'block' : 'none';
            document.getElementById('weightMetricGroup').style.display = isImperial ? 'none' : 'block';
            
            document.getElementById('shoulderUnit').textContent = isImperial ? 'inches' : 'cm';
            document.getElementById('bustUnit').textContent = isImperial ? 'inches' : 'cm';
            document.getElementById('waistUnit').textContent = isImperial ? 'inches' : 'cm';
            document.getElementById('hipsUnit').textContent = isImperial ? 'inches' : 'cm';
            document.getElementById('wristUnit').textContent = isImperial ? 'inches' : 'cm';
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBodyType();
        });

        function calculateBodyType() {
            const gender = document.getElementById('gender').value;
            const unitSystem = unitSystemSelect.value;
            
            // Get measurements
            let heightInches, weightLbs, shoulders, bust, waist, hips, wrist;
            
            if (unitSystem === 'imperial') {
                const feet = parseFloat(document.getElementById('heightFeet').value) || 0;
                const inches = parseFloat(document.getElementById('heightInches').value) || 0;
                heightInches = (feet * 12) + inches;
                weightLbs = parseFloat(document.getElementById('weightLbs').value) || 0;
                shoulders = parseFloat(document.getElementById('shoulders').value) || 0;
                bust = parseFloat(document.getElementById('bust').value) || 0;
                waist = parseFloat(document.getElementById('waist').value) || 0;
                hips = parseFloat(document.getElementById('hips').value) || 0;
                wrist = parseFloat(document.getElementById('wrist').value) || 0;
            } else {
                const heightCm = parseFloat(document.getElementById('heightCm').value) || 0;
                heightInches = heightCm / 2.54;
                const weightKg = parseFloat(document.getElementById('weightKg').value) || 0;
                weightLbs = weightKg * 2.20462;
                shoulders = parseFloat(document.getElementById('shoulders').value) / 2.54;
                bust = parseFloat(document.getElementById('bust').value) / 2.54;
                waist = parseFloat(document.getElementById('waist').value) / 2.54;
                hips = parseFloat(document.getElementById('hips').value) / 2.54;
                wrist = parseFloat(document.getElementById('wrist').value) / 2.54;
            }

            // Calculate ratios
            const whr = waist / hips;
            const bustHipRatio = bust / hips;
            const waistBustRatio = waist / bust;
            const wristRatio = heightInches / wrist;

            // Determine body shape
            let bodyShape = '';
            let shapeEmoji = '';
            let shapeColor = '';
            
            if (gender === 'female') {
                if (Math.abs(bust - hips) <= 2 && waist < bust * 0.75 && waist < hips * 0.75) {
                    bodyShape = 'Hourglass';
                    shapeEmoji = '⌛';
                    shapeColor = '#E91E63';
                } else if (hips > bust + 2 && waist < hips * 0.75) {
                    bodyShape = 'Pear (Triangle)';
                    shapeEmoji = '🍐';
                    shapeColor = '#4CAF50';
                } else if (waist >= bust * 0.85 || waist >= hips * 0.85) {
                    bodyShape = 'Apple (Round)';
                    shapeEmoji = '🍎';
                    shapeColor = '#FF5722';
                } else if (Math.abs(bust - waist) <= 4 && Math.abs(waist - hips) <= 4) {
                    bodyShape = 'Rectangle (Banana)';
                    shapeEmoji = '📏';
                    shapeColor = '#FF9800';
                } else if (shoulders > hips + 2 || bust > hips + 2) {
                    bodyShape = 'Inverted Triangle';
                    shapeEmoji = '🔺';
                    shapeColor = '#2196F3';
                } else {
                    bodyShape = 'Hourglass';
                    shapeEmoji = '⌛';
                    shapeColor = '#E91E63';
                }
            } else {
                if (shoulders > hips + 3 && waist < bust * 0.85) {
                    bodyShape = 'Inverted Triangle';
                    shapeEmoji = '🔺';
                    shapeColor = '#2196F3';
                } else if (Math.abs(shoulders - waist) <= 3 && Math.abs(waist - hips) <= 3) {
                    bodyShape = 'Rectangle';
                    shapeEmoji = '📏';
                    shapeColor = '#FF9800';
                } else if (hips > shoulders) {
                    bodyShape = 'Triangle';
                    shapeEmoji = '🔻';
                    shapeColor = '#4CAF50';
                } else if (waist >= bust * 0.9) {
                    bodyShape = 'Oval (Apple)';
                    shapeEmoji = '🍎';
                    shapeColor = '#FF5722';
                } else {
                    bodyShape = 'Trapezoid';
                    shapeEmoji = '💪';
                    shapeColor = '#9C27B0';
                }
            }

            // Determine somatotype
            let somatotype = '';
            let somatoColor = '';
            
            if (wristRatio > 10.4) {
                somatotype = 'Ectomorph';
                somatoColor = '#2196F3';
            } else if (wristRatio >= 9.6) {
                somatotype = 'Mesomorph';
                somatoColor = '#4CAF50';
            } else {
                somatotype = 'Endomorph';
                somatoColor = '#FF9800';
            }

            // Determine frame size
            let frameSize = '';
            if (wristRatio > 10.4) {
                frameSize = 'Small';
            } else if (wristRatio >= 9.6) {
                frameSize = 'Medium';
            } else {
                frameSize = 'Large';
            }

            // WHR health assessment
            let whrHealth = '';
            let whrColor = '';
            
            if (gender === 'female') {
                if (whr < 0.80) {
                    whrHealth = 'Low Risk';
                    whrColor = '#4CAF50';
                } else if (whr <= 0.85) {
                    whrHealth = 'Moderate Risk';
                    whrColor = '#FF9800';
                } else {
                    whrHealth = 'High Risk';
                    whrColor = '#f44336';
                }
            } else {
                if (whr < 0.90) {
                    whrHealth = 'Low Risk';
                    whrColor = '#4CAF50';
                } else if (whr <= 1.0) {
                    whrHealth = 'Moderate Risk';
                    whrColor = '#FF9800';
                } else {
                    whrHealth = 'High Risk';
                    whrColor = '#f44336';
                }
            }

            // Descriptions and tips
            const descriptions = getShapeDescription(bodyShape, gender);
            const styleTips = getStyleTips(bodyShape, gender);
            const fitnessTips = getFitnessTips(somatotype);

            // Display measurements
            const displayHeight = unitSystem === 'imperial' ? 
                `${Math.floor(heightInches / 12)}'${(heightInches % 12).toFixed(0)}"` : 
                `${(heightInches * 2.54).toFixed(1)} cm`;
            const displayWeight = unitSystem === 'imperial' ? 
                `${weightLbs.toFixed(1)} lbs` : 
                `${(weightLbs / 2.20462).toFixed(1)} kg`;
            const displayUnit = unitSystem === 'imperial' ? 'in' : 'cm';
            const convertMeasure = (inches) => unitSystem === 'imperial' ? 
                `${inches.toFixed(1)} in` : 
                `${(inches * 2.54).toFixed(1)} cm`;

            // Analysis
            let analysis = `You have a ${bodyShape} body shape with a ${somatotype} body frame (${frameSize.toLowerCase()} frame). `;
            analysis += `Your waist-to-hip ratio is ${whr.toFixed(2)}, indicating ${whrHealth.toLowerCase()} for health conditions related to body fat distribution. `;
            analysis += `${descriptions} Remember that body type is largely genetic and all body types can be healthy and beautiful!`;

            // Update UI
            document.getElementById('bodyShapeResult').textContent = shapeEmoji;
            document.getElementById('bodyShapeName').textContent = bodyShape;
            
            document.getElementById('shapeDisplay').textContent = bodyShape;
            document.getElementById('shapeDisplay').style.color = shapeColor;
            document.getElementById('somatotypeDisplay').textContent = somatotype;
            document.getElementById('somatotypeDisplay').style.color = somatoColor;
            document.getElementById('whrDisplay').textContent = whr.toFixed(2);
            document.getElementById('frameDisplay').textContent = frameSize;

            document.getElementById('heightDisplay').textContent = displayHeight;
            document.getElementById('weightDisplay').textContent = displayWeight;
            document.getElementById('shouldersDisplay').textContent = convertMeasure(shoulders);
            document.getElementById('bustDisplay').textContent = convertMeasure(bust);
            document.getElementById('waistDisplay').textContent = convertMeasure(waist);
            document.getElementById('hipsDisplay').textContent = convertMeasure(hips);
            document.getElementById('wristDisplay').textContent = convertMeasure(wrist);

            document.getElementById('shapeCalc').textContent = bodyShape;
            document.getElementById('shapeCalc').style.color = shapeColor;
            document.getElementById('whrCalc').textContent = whr.toFixed(2);
            document.getElementById('bustHipRatio').textContent = bustHipRatio.toFixed(2);
            document.getElementById('waistBustRatio').textContent = waistBustRatio.toFixed(2);

            document.getElementById('somatotypeCalc').textContent = somatotype;
            document.getElementById('somatotypeCalc').style.color = somatoColor;
            document.getElementById('frameSizeCalc').textContent = frameSize;
            document.getElementById('wristRatio').textContent = wristRatio.toFixed(1);

            document.getElementById('yourWHR').textContent = whr.toFixed(2);
            document.getElementById('whrHealth').textContent = whrHealth;
            document.getElementById('whrHealth').style.color = whrColor;

            document.getElementById('descriptionText').textContent = descriptions;
            document.getElementById('styleTipsText').innerHTML = styleTips;
            document.getElementById('fitnessTipsText').innerHTML = fitnessTips;
            document.getElementById('analysisText').textContent = analysis;
        }

        function getShapeDescription(shape, gender) {
            const descriptions = {
                'Hourglass': 'Your bust and hips are nearly equal in size with a well-defined waist. This is considered the most balanced body shape.',
                'Pear (Triangle)': 'Your hips are wider than your bust with a defined waist. This is one of the most common female body shapes.',
                'Apple (Round)': 'You carry weight around your midsection with a less defined waist. Focus on maintaining healthy body composition.',
                'Rectangle (Banana)': 'Your bust, waist, and hips are similar in measurement. You have an athletic, straight up-and-down silhouette.',
                'Inverted Triangle': gender === 'female' ? 
                    'Your shoulders and bust are broader than your hips. Many athletes have this strong, powerful shape.' :
                    'Your shoulders are broader than your waist and hips, creating a V-shaped torso. This is considered the ideal male shape.',
                'Triangle': 'Your hips are wider than your shoulders, creating a triangle silhouette.',
                'Oval (Apple)': 'You carry weight around your midsection. Focus on core strength and cardiovascular health.',
                'Trapezoid': 'You have an athletic build with developed shoulders and narrow waist. This is a strong, muscular shape.'
            };
            return descriptions[shape] || 'You have a unique body shape.';
        }

        function getStyleTips(shape, gender) {
            const tips = {
                'Hourglass': '<p>• Fitted clothes that follow your curves</p><p>• Belts to emphasize waist</p><p>• Wrap dresses and tailored pieces</p><p>• Avoid boxy, oversized clothing</p>',
                'Pear (Triangle)': '<p>• Draw attention to upper body with details, colors</p><p>• A-line skirts and bootcut pants</p><p>• Structured shoulders and interesting necklines</p><p>• Dark bottoms, bright tops</p>',
                'Apple (Round)': '<p>• Empire waist dresses</p><p>• V-necks to elongate torso</p><p>• Avoid tight waistbands</p><p>• Structured jackets</p>',
                'Rectangle (Banana)': '<p>• Create curves with peplums, ruffles</p><p>• Belts and defined waistlines</p><p>• Layering to add dimension</p><p>• Textured fabrics</p>',
                'Inverted Triangle': gender === 'female' ?
                    '<p>• Balance with A-line skirts</p><p>• V-necks to soften shoulders</p><p>• Add volume to lower body</p><p>• Avoid shoulder pads</p>' :
                    '<p>• Fitted shirts to show shape</p><p>• Avoid baggy clothing</p><p>• Straight or slim pants</p><p>• Structured jackets</p>',
                'Triangle': '<p>• Emphasize upper body</p><p>• Structured shoulders</p><p>• Dark bottoms</p><p>• Interesting necklines</p>',
                'Oval (Apple)': '<p>• Empire waists</p><p>• V-necks</p><p>• Avoid tight midsection</p><p>• Elongate with monochrome</p>',
                'Trapezoid': '<p>• Fitted clothing to show muscles</p><p>• Athletic wear</p><p>• Structured pieces</p><p>• Avoid too-tight clothing</p>'
            };
            return tips[shape] || '<p>Wear what makes you feel confident!</p>';
        }

        function getFitnessTips(somatotype) {
            const tips = {
                'Ectomorph': '<p><strong>Naturally lean, fast metabolism:</strong></p><p>• Focus on strength training with heavy weights</p><p>• Eat calorie surplus to gain muscle</p><p>• Limit cardio</p><p>• Higher carb diet</p><p>• Be patient - gains take time</p>',
                'Mesomorph': '<p><strong>Athletic, builds muscle easily:</strong></p><p>• Balance of strength and cardio</p><p>• Moderate calorie intake</p><p>• Variety in workouts</p><p>• Balanced macros</p><p>• Responds well to most training</p>',
                'Endomorph': '<p><strong>Stores fat easily, slower metabolism:</strong></p><p>• Focus on cardio and HIIT</p><p>• Strength training to build muscle</p><p>• Careful calorie control</p><p>• Lower carb, higher protein</p><p>• Consistent exercise routine</p>'
            };
            return tips[somatotype];
        }

        window.addEventListener('load', function() {
            toggleUnitFields();
            calculateBodyType();
        });
    </script>
</body>
</html>