<?php
/**
 * Water Intake Calculator
 * File: water-intake-calculator.php
 * Description: Calculate daily water requirements based on personal factors and activity level
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Intake Calculator - Daily Hydration Requirements</title>
    <meta name="description" content="Advanced Water Intake Calculator. Calculate daily water requirements based on weight, activity level, climate, and personal factors with hydration tracking.">
    <link rel="stylesheet" href="assets/css/calculator.css">
</head>
<body>
    <header>
        <h1>💧 Water Intake Calculator</h1>
        <p>Calculate your daily hydration needs and track your water consumption</p>
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
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
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
            color: #2196F3;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #1976D2;
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
            color: #2196F3;
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
            border-color: #2196F3;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #888;
            font-size: 0.9em;
        }
        
        .btn {
            background: #2196F3;
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
            background: #1976D2;
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
        
        .optimal {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .moderate {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }
        
        .low {
            background: linear-gradient(135deg, #FFC107 0%, #FFA000 100%);
        }
        
        .critical {
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
            color: #2196F3;
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
            color: #2196F3;
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
        
        .unit-toggle {
            display: flex;
            background: #f8f9fa;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 15px;
        }
        
        .unit-option {
            flex: 1;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            border-radius: 3px;
            transition: all 0.3s;
        }
        
        .unit-option.active {
            background: #2196F3;
            color: white;
        }
        
        .activity-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .activity-option {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .activity-option.active {
            background: #2196F3;
            color: white;
            border-color: #1976D2;
        }
        
        .climate-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .climate-option {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .climate-option.active {
            background: #2196F3;
            color: white;
            border-color: #1976D2;
        }
        
        .hydration-tracker {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .tracker-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .water-cups {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 8px;
            margin-bottom: 15px;
        }
        
        .water-cup {
            width: 40px;
            height: 60px;
            background: #e0e0e0;
            border-radius: 0 0 10px 10px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            border: 2px solid #bdbdbd;
        }
        
        .water-cup.filled {
            background: linear-gradient(to top, #2196F3, #64b5f6);
            border-color: #1976D2;
        }
        
        .water-cup::after {
            content: '';
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 8px;
            background: #e0e0e0;
            border-radius: 10px 10px 0 0;
        }
        
        .water-cup.filled::after {
            background: #1976D2;
        }
        
        .progress-meter {
            height: 20px;
            background: #e0e0e0;
            border-radius: 10px;
            margin: 15px 0;
            overflow: hidden;
        }
        
        .progress-level {
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s ease;
            background: linear-gradient(90deg, #4CAF50, #2196F3);
        }
        
        .intake-schedule {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 15px;
        }
        
        .schedule-item {
            background: white;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e0e0e0;
            font-size: 0.9em;
        }
        
        .hydration-tips {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 15px;
        }
        
        .tip-item {
            background: white;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            font-size: 0.85em;
            line-height: 1.4;
        }
        
        .container-equivalents {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 15px;
        }
        
        .container-item {
            background: white;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e0e0e0;
            font-size: 0.9em;
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
            
            .activity-options,
            .climate-options {
                grid-template-columns: 1fr;
            }
            
            .water-cups {
                grid-template-columns: repeat(4, 1fr);
            }
            
            .intake-schedule,
            .hydration-tips,
            .container-equivalents {
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
                <h2>Personal Information</h2>
                <form id="waterIntakeForm">
                    <div class="form-group">
                        <label>Unit System</label>
                        <div class="unit-toggle">
                            <div class="unit-option active" data-unit="metric">Metric</div>
                            <div class="unit-option" data-unit="imperial">Imperial</div>
                        </div>
                        <input type="hidden" id="unitSystem" value="metric">
                    </div>
                    
                    <div class="form-group">
                        <label for="weight">Your Weight</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="number" id="weightKg" value="70" min="30" max="200" step="0.1" placeholder="kg" style="flex: 1;">
                            <input type="number" id="weightLbs" value="154" min="66" max="440" step="0.1" placeholder="lbs" style="flex: 1; display: none;">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" value="35" min="1" max="120" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Activity Level</label>
                        <div class="activity-options">
                            <div class="activity-option active" data-activity="sedentary">
                                <strong>Sedentary</strong>
                                <div>Little to no exercise</div>
                            </div>
                            <div class="activity-option" data-activity="light">
                                <strong>Lightly Active</strong>
                                <div>Light exercise 1-3 days/week</div>
                            </div>
                            <div class="activity-option" data-activity="moderate">
                                <strong>Moderately Active</strong>
                                <div>Moderate exercise 3-5 days/week</div>
                            </div>
                            <div class="activity-option" data-activity="very">
                                <strong>Very Active</strong>
                                <div>Hard exercise 6-7 days/week</div>
                            </div>
                        </div>
                        <input type="hidden" id="activityLevel" value="sedentary">
                    </div>
                    
                    <div class="form-group">
                        <label>Climate & Environment</label>
                        <div class="climate-options">
                            <div class="climate-option active" data-climate="temperate">
                                <strong>Temperate</strong>
                                <div>Moderate climate</div>
                            </div>
                            <div class="climate-option" data-climate="hot">
                                <strong>Hot/Dry</strong>
                                <div>High temperature</div>
                            </div>
                            <div class="climate-option" data-climate="humid">
                                <strong>Humid</strong>
                                <div>High humidity</div>
                            </div>
                        </div>
                        <input type="hidden" id="climateType" value="temperate">
                    </div>
                    
                    <div class="form-group">
                        <label for="pregnancy">Pregnancy/Breastfeeding</label>
                        <select id="pregnancy">
                            <option value="none">Not pregnant/breastfeeding</option>
                            <option value="pregnant">Pregnant</option>
                            <option value="breastfeeding">Breastfeeding</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="healthConditions">Special Health Conditions</label>
                        <select id="healthConditions">
                            <option value="none">None</option>
                            <option value="kidney">Kidney issues</option>
                            <option value="heart">Heart conditions</option>
                            <option value="diabetes">Diabetes</option>
                            <option value="athlete">Competitive athlete</option>
                        </select>
                        <small>Consult doctor for specific medical conditions</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Water Needs</button>
                </form>
                
                <div class="hydration-tracker">
                    <h3 style="color: #2196F3; margin-bottom: 15px;">Daily Water Tracker</h3>
                    <div class="tracker-header">
                        <span>Today's Intake: <strong id="currentIntake">0</strong> cups</span>
                        <span>Goal: <strong id="dailyGoal">8</strong> cups</span>
                    </div>
                    <div class="water-cups" id="waterCups">
                        <!-- Cups will be generated by JavaScript -->
                    </div>
                    <div class="progress-meter">
                        <div class="progress-level" id="hydrationProgress" style="width: 0%;"></div>
                    </div>
                    <div style="text-align: center;">
                        <button onclick="resetTracker()" style="background: #f44336; color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer;">Reset Tracker</button>
                    </div>
                </div>
                
                <div class="breakdown" style="margin-top: 30px;">
                    <h3>Hydration Guidelines</h3>
                    <div style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p><strong>General Rule:</strong> 30-35 ml per kg of body weight daily</p>
                        <p><strong>Standard Recommendation:</strong> 8 glasses (2 liters) per day</p>
                        <p><strong>Activity Adjustment:</strong> Add 500 ml per hour of exercise</p>
                        <p><strong>Climate Adjustment:</strong> Hot/dry climate: +500 ml, Humid: +250 ml</p>
                        <p><strong>Special Needs:</strong> Pregnancy: +300 ml, Breastfeeding: +700 ml</p>
                    </div>
                </div>
            </div>

            <div class="results-section">
                <h2>Hydration Analysis</h2>
                
                <div class="result-card" id="resultCard">
                    <h3>Daily Water Requirement</h3>
                    <div class="amount" id="waterRequirement">2.5</div>
                    <div class="category" id="requirementUnit">Liters</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>In Ounces</h4>
                        <div class="value" id="ouncesValue">84.5</div>
                    </div>
                    <div class="metric-card">
                        <h4>In Cups</h4>
                        <div class="value" id="cupsValue">10.6</div>
                    </div>
                    <div class="metric-card">
                        <h4>In Milliliters</h4>
                        <div class="value" id="mlValue">2500</div>
                    </div>
                    <div class="metric-card">
                        <h4>Hydration Status</h4>
                        <div class="value" id="hydrationStatus">Optimal</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Water Requirement Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Base Requirement</span>
                        <strong id="baseRequirement">1.8 L</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Activity Adjustment</span>
                        <strong id="activityAdjustment">+0.2 L</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Climate Adjustment</span>
                        <strong id="climateAdjustment">+0.0 L</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Special Needs</span>
                        <strong id="specialAdjustment">+0.0 L</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #2196F3; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Daily Need</strong></span>
                        <strong id="totalRequirement" style="font-size: 1.1em;">2.0 L</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Recommended Intake Schedule</h3>
                    <div class="intake-schedule">
                        <div class="schedule-item">
                            <strong>Morning</strong><br>
                            <span id="morningIntake">500 ml</span>
                        </div>
                        <div class="schedule-item">
                            <strong>Before Lunch</strong><br>
                            <span id="preLunchIntake">500 ml</span>
                        </div>
                        <div class="schedule-item">
                            <strong>Afternoon</strong><br>
                            <span id="afternoonIntake">500 ml</span>
                        </div>
                        <div class="schedule-item">
                            <strong>Evening</strong><br>
                            <span id="eveningIntake">500 ml</span>
                        </div>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Container Equivalents</h3>
                    <div class="container-equivalents">
                        <div class="container-item">
                            <strong>Water Bottles</strong><br>
                            <span id="bottleEquiv">1.7 bottles</span>
                        </div>
                        <div class="container-item">
                            <strong>Standard Glasses</strong><br>
                            <span id="glassEquiv">8.5 glasses</span>
                        </div>
                        <div class="container-item">
                            <strong>Sports Bottles</strong><br>
                            <span id="sportsEquiv">2.1 bottles</span>
                        </div>
                        <div class="container-item">
                            <strong>Large Bottles</strong><br>
                            <span id="largeEquiv">0.8 bottles</span>
                        </div>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Hydration Tips</h3>
                    <div class="hydration-tips">
                        <div class="tip-item">
                            <strong>Start Your Day</strong><br>
                            Drink 1-2 glasses upon waking
                        </div>
                        <div class="tip-item">
                            <strong>Before Meals</strong><br>
                            Drink 30 minutes before eating
                        </div>
                        <div class="tip-item">
                            <strong>During Exercise</strong><br>
                            500ml per hour of activity
                        </div>
                        <div class="tip-item">
                            <strong>Monitor Urine</strong><br>
                            Pale yellow = well hydrated
                        </div>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Health Benefits Analysis</h3>
                    <div id="healthBenefits" style="padding: 15px; background: white; border-radius: 5px; line-height: 1.8;">
                        <p id="benefitsText" style="margin: 0;">Meeting your daily water requirement supports optimal brain function, maintains healthy skin, aids digestion, regulates body temperature, and helps flush out toxins. Proper hydration also improves physical performance and supports kidney function.</p>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Dehydration Warning Signs</h3>
                    <div style="padding: 15px; background: #ffebee; border-radius: 5px; line-height: 1.8;">
                        <ul style="margin: 0; padding-left: 20px;">
                            <li>Dark yellow urine</li>
                            <li>Dry mouth and lips</li>
                            <li>Headaches and dizziness</li>
                            <li>Fatigue and confusion</li>
                            <li>Reduced urine output</li>
                        </ul>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Hydration Tips:</strong> Drink consistently throughout the day rather than large amounts at once. Carry a reusable water bottle. Set hourly reminders if needed. Eat water-rich foods (cucumber, watermelon, oranges). Monitor urine color - pale yellow indicates good hydration. Increase intake during exercise, hot weather, or illness. Limit diuretics like caffeine and alcohol. Listen to thirst cues but don't wait until you're thirsty. Morning hydration kickstarts metabolism. Evening hydration should be moderate to avoid sleep disruption. Electrolytes are important for prolonged exercise. Water temperature affects absorption rate - cool water absorbs faster.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('waterIntakeForm');
        const unitOptions = document.querySelectorAll('.unit-option');
        const activityOptions = document.querySelectorAll('.activity-option');
        const climateOptions = document.querySelectorAll('.climate-option');
        
        // Initialize water cups tracker
        function initializeWaterTracker() {
            const waterCupsContainer = document.getElementById('waterCups');
            waterCupsContainer.innerHTML = '';
            
            for (let i = 0; i < 8; i++) {
                const cup = document.createElement('div');
                cup.className = 'water-cup';
                cup.addEventListener('click', function() {
                    this.classList.toggle('filled');
                    updateWaterTracker();
                });
                waterCupsContainer.appendChild(cup);
            }
        }
        
        // Update water tracker
        function updateWaterTracker() {
            const filledCups = document.querySelectorAll('.water-cup.filled').length;
            const goal = 8; // Standard 8 cups goal
            const progress = (filledCups / goal) * 100;
            
            document.getElementById('currentIntake').textContent = filledCups;
            document.getElementById('dailyGoal').textContent = goal;
            document.getElementById('hydrationProgress').style.width = `${progress}%`;
        }
        
        // Reset tracker
        function resetTracker() {
            document.querySelectorAll('.water-cup').forEach(cup => {
                cup.classList.remove('filled');
            });
            updateWaterTracker();
        }
        
        // Unit system toggle
        unitOptions.forEach(option => {
            option.addEventListener('click', function() {
                unitOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                const unitSystem = this.dataset.unit;
                document.getElementById('unitSystem').value = unitSystem;
                
                // Toggle weight inputs
                document.getElementById('weightKg').style.display = unitSystem === 'metric' ? 'block' : 'none';
                document.getElementById('weightLbs').style.display = unitSystem === 'imperial' ? 'block' : 'none';
                
                calculateWaterNeeds();
            });
        });
        
        // Activity option selection
        activityOptions.forEach(option => {
            option.addEventListener('click', function() {
                activityOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('activityLevel').value = this.dataset.activity;
                calculateWaterNeeds();
            });
        });
        
        // Climate option selection
        climateOptions.forEach(option => {
            option.addEventListener('click', function() {
                climateOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('climateType').value = this.dataset.climate;
                calculateWaterNeeds();
            });
        });
        
        // Sync weight inputs
        document.getElementById('weightKg').addEventListener('input', function() {
            const kg = parseFloat(this.value) || 0;
            document.getElementById('weightLbs').value = (kg * 2.20462).toFixed(1);
            calculateWaterNeeds();
        });
        
        document.getElementById('weightLbs').addEventListener('input', function() {
            const lbs = parseFloat(this.value) || 0;
            document.getElementById('weightKg').value = (lbs / 2.20462).toFixed(1);
            calculateWaterNeeds();
        });
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateWaterNeeds();
        });

        function calculateWaterNeeds() {
            const unitSystem = document.getElementById('unitSystem').value;
            const weight = unitSystem === 'metric' ?
                parseFloat(document.getElementById('weightKg').value) || 0 :
                parseFloat(document.getElementById('weightLbs').value) || 0;
            const age = parseInt(document.getElementById('age').value) || 0;
            const gender = document.getElementById('gender').value;
            const activityLevel = document.getElementById('activityLevel').value;
            const climateType = document.getElementById('climateType').value;
            const pregnancy = document.getElementById('pregnancy').value;
            const healthConditions = document.getElementById('healthConditions').value;
            
            // Convert to metric for calculations
            const weightKg = unitSystem === 'metric' ? weight : weight / 2.20462;
            
            // Base calculation: 30-35 ml per kg of body weight
            let baseWaterMl = weightKg * 32.5; // Average of 30-35 ml
            
            // Adjust for gender (men typically need more)
            if (gender === 'male') {
                baseWaterMl *= 1.05;
            }
            
            // Adjust for age (older adults may need slightly less, children more)
            if (age < 18) {
                baseWaterMl *= 1.1; // Children need more per kg
            } else if (age > 65) {
                baseWaterMl *= 0.95; // Elderly may need slightly less
            }
            
            // Activity level adjustments
            let activityAdjustmentMl = 0;
            switch(activityLevel) {
                case 'sedentary':
                    activityAdjustmentMl = 0;
                    break;
                case 'light':
                    activityAdjustmentMl = 250;
                    break;
                case 'moderate':
                    activityAdjustmentMl = 500;
                    break;
                case 'very':
                    activityAdjustmentMl = 750;
                    break;
            }
            
            // Climate adjustments
            let climateAdjustmentMl = 0;
            switch(climateType) {
                case 'temperate':
                    climateAdjustmentMl = 0;
                    break;
                case 'hot':
                    climateAdjustmentMl = 500;
                    break;
                case 'humid':
                    climateAdjustmentMl = 250;
                    break;
            }
            
            // Special conditions adjustments
            let specialAdjustmentMl = 0;
            switch(pregnancy) {
                case 'pregnant':
                    specialAdjustmentMl = 300;
                    break;
                case 'breastfeeding':
                    specialAdjustmentMl = 700;
                    break;
            }
            
            // Health conditions adjustments
            switch(healthConditions) {
                case 'kidney':
                    // Kidney issues may require fluid restriction - consult doctor
                    specialAdjustmentMl = -200;
                    break;
                case 'athlete':
                    specialAdjustmentMl += 500;
                    break;
            }
            
            // Calculate total water needs
            const totalWaterMl = baseWaterMl + activityAdjustmentMl + climateAdjustmentMl + specialAdjustmentMl;
            
            // Convert to different units
            const liters = totalWaterMl / 1000;
            const ounces = totalWaterMl / 29.5735;
            const cups = ounces / 8;
            
            // Determine hydration status
            let status = '';
            let statusClass = '';
            const standardRequirement = 2000; // Standard 2L recommendation
            
            if (totalWaterMl >= standardRequirement * 1.1) {
                status = 'Optimal';
                statusClass = 'optimal';
            } else if (totalWaterMl >= standardRequirement * 0.9) {
                status = 'Good';
                statusClass = 'moderate';
            } else if (totalWaterMl >= standardRequirement * 0.7) {
                status = 'Adequate';
                statusClass = 'low';
            } else {
                status = 'Insufficient';
                statusClass = 'critical';
            }
            
            // Update UI
            const card = document.getElementById('resultCard');
            card.className = `result-card ${statusClass}`;
            
            document.getElementById('waterRequirement').textContent = liters.toFixed(1);
            document.getElementById('requirementUnit').textContent = unitSystem === 'metric' ? 'Liters' : 'Quarts';
            
            document.getElementById('ouncesValue').textContent = ounces.toFixed(1);
            document.getElementById('cupsValue').textContent = cups.toFixed(1);
            document.getElementById('mlValue').textContent = Math.round(totalWaterMl);
            document.getElementById('hydrationStatus').textContent = status;
            
            // Breakdown
            document.getElementById('baseRequirement').textContent = `${(baseWaterMl / 1000).toFixed(1)} L`;
            document.getElementById('activityAdjustment').textContent = `${activityAdjustmentMl >= 0 ? '+' : ''}${(activityAdjustmentMl / 1000).toFixed(1)} L`;
            document.getElementById('climateAdjustment').textContent = `${climateAdjustmentMl >= 0 ? '+' : ''}${(climateAdjustmentMl / 1000).toFixed(1)} L`;
            document.getElementById('specialAdjustment').textContent = `${specialAdjustmentMl >= 0 ? '+' : ''}${(specialAdjustmentMl / 1000).toFixed(1)} L`;
            document.getElementById('totalRequirement').textContent = `${liters.toFixed(1)} L`;
            
            // Intake schedule (divide total by 4 for even distribution)
            const quarterIntake = totalWaterMl / 4;
            document.getElementById('morningIntake').textContent = `${Math.round(quarterIntake)} ml`;
            document.getElementById('preLunchIntake').textContent = `${Math.round(quarterIntake)} ml`;
            document.getElementById('afternoonIntake').textContent = `${Math.round(quarterIntake)} ml`;
            document.getElementById('eveningIntake').textContent = `${Math.round(quarterIntake)} ml`;
            
            // Container equivalents
            const bottle500ml = totalWaterMl / 500;
            const glass250ml = totalWaterMl / 250;
            const sportsBottle750ml = totalWaterMl / 750;
            const largeBottle1500ml = totalWaterMl / 1500;
            
            document.getElementById('bottleEquiv').textContent = `${bottle500ml.toFixed(1)} bottles`;
            document.getElementById('glassEquiv').textContent = `${glass250ml.toFixed(1)} glasses`;
            document.getElementById('sportsEquiv').textContent = `${sportsBottle750ml.toFixed(1)} bottles`;
            document.getElementById('largeEquiv').textContent = `${largeBottle1500ml.toFixed(1)} bottles`;
            
            // Update daily goal for tracker
            document.getElementById('dailyGoal').textContent = Math.round(cups);
            
            // Health benefits text
            let benefitsText = '';
            if (status === 'Optimal') {
                benefitsText = 'Your calculated water intake supports optimal hydration. This helps maintain cognitive function, physical performance, healthy skin, proper digestion, and efficient toxin removal.';
            } else if (status === 'Good') {
                benefitsText = 'Your water intake is good and should support basic hydration needs. Consider increasing slightly for optimal health benefits, especially if active or in warm climates.';
            } else {
                benefitsText = 'Your calculated water intake may be insufficient for optimal health. Increasing hydration can improve energy levels, cognitive function, and overall wellbeing.';
            }
            
            document.getElementById('benefitsText').textContent = benefitsText;
        }

        window.addEventListener('load', function() {
            initializeWaterTracker();
            calculateWaterNeeds();
        });
    </script>
</body>
</html>