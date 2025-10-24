<?php
/**
 * BMI Calculator
 * File: bmi-calculator.php
 * Description: Calculate Body Mass Index with metric and imperial units
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator - Body Mass Index Calculator (Metric & Imperial)</title>
    <meta name="description" content="Free BMI calculator. Calculate your body mass index using metric (kg/cm) or imperial (lbs/inches) units. Check if your weight is healthy for your height.">
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
</head>
<body>
    <header>
        <h1>⚖️ BMI Calculator</h1>
        <p>Calculate your Body Mass Index to check if you're at a healthy weight</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Your Measurements</h2>
                <form id="bmiForm">
                    <div class="form-group">
                        <label for="unitSystem">Unit System</label>
                        <select id="unitSystem">
                            <option value="metric">Metric (kg, cm)</option>
                            <option value="imperial">Imperial (lbs, inches)</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="metricWeight">
                        <label for="weightKg">Weight (kg)</label>
                        <input type="number" id="weightKg" value="70" min="1" step="0.1" required>
                    </div>
                    
                    <div class="form-group" id="imperialWeight" style="display:none;">
                        <label for="weightLbs">Weight (lbs)</label>
                        <input type="number" id="weightLbs" value="154" min="1" step="0.1">
                    </div>
                    
                    <div class="form-group" id="metricHeight">
                        <label for="heightCm">Height (cm)</label>
                        <input type="number" id="heightCm" value="175" min="1" step="0.1" required>
                    </div>
                    
                    <div class="form-group" id="imperialHeight" style="display:none;">
                        <label for="heightFeet">Height (feet)</label>
                        <input type="number" id="heightFeet" value="5" min="1" max="8" step="1">
                    </div>
                    
                    <div class="form-group" id="imperialHeightInches" style="display:none;">
                        <label for="heightInches">Height (inches)</label>
                        <input type="number" id="heightInches" value="9" min="0" max="11" step="1">
                    </div>
                    
                    <div class="form-group">
                        <label for="age">Age (years)</label>
                        <input type="number" id="age" value="30" min="18" max="120" step="1">
                        <small>For adults 18 and over</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate BMI</button>
                </form>
            </div>

            <div class="results-section">
                <h2>BMI Results</h2>
                
                <div class="result-card normal" id="bmiCard">
                    <h3>Your BMI</h3>
                    <div class="amount" id="bmiValue">22.9</div>
                    <div class="category" id="bmiCategory">Normal Weight</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>BMI Value</h4>
                        <div class="value" id="bmiDisplay">22.9</div>
                    </div>
                    <div class="metric-card">
                        <h4>BMI Prime</h4>
                        <div class="value" id="bmiPrime">0.92</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Your Details</h3>
                    <div class="breakdown-item">
                        <span>Weight</span>
                        <strong id="weightDisplay">70 kg</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Height</span>
                        <strong id="heightDisplay">175 cm</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Age</span>
                        <strong id="ageDisplay">30 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Gender</span>
                        <strong id="genderDisplay">Male</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>BMI Category</span>
                        <strong id="categoryDisplay">Normal Weight</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Healthy Weight Range</h3>
                    <div class="breakdown-item">
                        <span>Minimum Healthy Weight</span>
                        <strong id="minWeight">56.7 kg</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Maximum Healthy Weight</span>
                        <strong id="maxWeight">76.6 kg</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Ideal Weight Range</span>
                        <strong id="idealRange">56.7 - 76.6 kg</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>BMI Categories</h3>
                    <div class="breakdown-item">
                        <span>Underweight</span>
                        <strong>BMI < 18.5</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Normal Weight</span>
                        <strong>BMI 18.5 - 24.9</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Overweight</span>
                        <strong>BMI 25.0 - 29.9</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Obese</span>
                        <strong>BMI ≥ 30.0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>About BMI:</strong> BMI = weight(kg) / height(m)². BMI is a screening tool but doesn't measure body fat directly. Athletes with high muscle mass may have high BMI despite low body fat. Consult healthcare providers for personalized health advice.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('bmiForm');
        const unitSystem = document.getElementById('unitSystem');
        const metricWeight = document.getElementById('metricWeight');
        const imperialWeight = document.getElementById('imperialWeight');
        const metricHeight = document.getElementById('metricHeight');
        const imperialHeight = document.getElementById('imperialHeight');
        const imperialHeightInches = document.getElementById('imperialHeightInches');

        unitSystem.addEventListener('change', function() {
            if (this.value === 'metric') {
                metricWeight.style.display = 'block';
                imperialWeight.style.display = 'none';
                metricHeight.style.display = 'block';
                imperialHeight.style.display = 'none';
                imperialHeightInches.style.display = 'none';
            } else {
                metricWeight.style.display = 'none';
                imperialWeight.style.display = 'block';
                metricHeight.style.display = 'none';
                imperialHeight.style.display = 'block';
                imperialHeightInches.style.display = 'block';
            }
            calculateBMI();
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBMI();
        });

        function calculateBMI() {
            const system = unitSystem.value;
            const age = parseInt(document.getElementById('age').value) || 30;
            const gender = document.getElementById('gender').value;
            
            let weightKg, heightM;
            
            if (system === 'metric') {
                weightKg = parseFloat(document.getElementById('weightKg').value) || 70;
                const heightCm = parseFloat(document.getElementById('heightCm').value) || 175;
                heightM = heightCm / 100;
            } else {
                const weightLbs = parseFloat(document.getElementById('weightLbs').value) || 154;
                const heightFeet = parseInt(document.getElementById('heightFeet').value) || 5;
                const heightInches = parseInt(document.getElementById('heightInches').value) || 9;
                const totalInches = (heightFeet * 12) + heightInches;
                
                weightKg = weightLbs * 0.453592;
                heightM = totalInches * 0.0254;
            }
            
            // Calculate BMI
            const bmi = weightKg / (heightM * heightM);
            const bmiPrimeValue = bmi / 25; // 25 is the upper limit of normal BMI
            
            // Determine category and color
            let category, categoryClass;
            if (bmi < 18.5) {
                category = 'Underweight';
                categoryClass = 'underweight';
            } else if (bmi >= 18.5 && bmi < 25) {
                category = 'Normal Weight';
                categoryClass = 'normal';
            } else if (bmi >= 25 && bmi < 30) {
                category = 'Overweight';
                categoryClass = 'overweight';
            } else {
                category = 'Obese';
                categoryClass = 'obese';
            }
            
            // Calculate healthy weight range
            const minHealthyWeight = 18.5 * (heightM * heightM);
            const maxHealthyWeight = 24.9 * (heightM * heightM);
            
            // Update UI
            document.getElementById('bmiValue').textContent = bmi.toFixed(1);
            document.getElementById('bmiCategory').textContent = category;
            document.getElementById('bmiCard').className = 'result-card ' + categoryClass;
            
            document.getElementById('bmiDisplay').textContent = bmi.toFixed(1);
            document.getElementById('bmiPrime').textContent = bmiPrimeValue.toFixed(2);
            
            if (system === 'metric') {
                document.getElementById('weightDisplay').textContent = weightKg.toFixed(1) + ' kg';
                document.getElementById('heightDisplay').textContent = (heightM * 100).toFixed(1) + ' cm';
                document.getElementById('minWeight').textContent = minHealthyWeight.toFixed(1) + ' kg';
                document.getElementById('maxWeight').textContent = maxHealthyWeight.toFixed(1) + ' kg';
                document.getElementById('idealRange').textContent = minHealthyWeight.toFixed(1) + ' - ' + maxHealthyWeight.toFixed(1) + ' kg';
            } else {
                const weightLbs = weightKg / 0.453592;
                const heightInches = heightM / 0.0254;
                const minWeightLbs = minHealthyWeight / 0.453592;
                const maxWeightLbs = maxHealthyWeight / 0.453592;
                
                document.getElementById('weightDisplay').textContent = weightLbs.toFixed(1) + ' lbs';
                document.getElementById('heightDisplay').textContent = Math.floor(heightInches / 12) + "'" + Math.round(heightInches % 12) + '"';
                document.getElementById('minWeight').textContent = minWeightLbs.toFixed(1) + ' lbs';
                document.getElementById('maxWeight').textContent = maxWeightLbs.toFixed(1) + ' lbs';
                document.getElementById('idealRange').textContent = minWeightLbs.toFixed(1) + ' - ' + maxWeightLbs.toFixed(1) + ' lbs';
            }
            
            document.getElementById('ageDisplay').textContent = age + ' years';
            document.getElementById('genderDisplay').textContent = gender.charAt(0).toUpperCase() + gender.slice(1);
            document.getElementById('categoryDisplay').textContent = category;
        }

        window.addEventListener('load', function() {
            calculateBMI();
        });
    </script>
</body>
</html>