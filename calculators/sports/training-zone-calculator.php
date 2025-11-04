<?php
/**
 * Training Zone Calculator
 * File: sports/training-zone-calculator.php
 * Description: Calculate heart rate training zones for optimal workout intensity
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Zone Calculator - Heart Rate Zones & Workout Intensity</title>
    <meta name="description" content="Calculate your heart rate training zones based on maximum heart rate, lactate threshold, or VO2 max. Optimize your workout intensity for better results.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .input-section { margin-bottom: 30px; }
        .section-title { color: #2c3e50; font-size: 1.3rem; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0; }
        
        .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
        
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper { display: flex; align-items: center; }
        .input-wrapper input { flex: 1; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus { outline: none; border-color: #4facfe; box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1); }
        
        .unit-select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; background: white; }
        .unit-select:focus { outline: none; border-color: #4facfe; box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1); }
        
        .calculate-btn { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border: none; border-radius: 10px; padding: 14px 25px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; margin-top: 10px; }
        .calculate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4); }
        
        .zones-section { margin-top: 30px; }
        .zones-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px; }
        
        .zone-card { border-radius: 12px; padding: 0; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .zone-card:hover { transform: translateY(-5px); }
        
        .zone-header { padding: 20px; color: white; text-align: center; }
        .zone-number { font-size: 1.5rem; font-weight: bold; margin-bottom: 5px; }
        .zone-name { font-size: 1.1rem; font-weight: 600; }
        
        .zone-content { padding: 20px; background: white; }
        .zone-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
        .zone-stat { text-align: center; }
        .zone-value { font-size: 1.2rem; font-weight: bold; color: #4facfe; }
        .zone-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 5px; }
        
        .zone-description { font-size: 0.9rem; color: #555; line-height: 1.5; margin-bottom: 15px; }
        .zone-benefits { font-size: 0.85rem; color: #7f8c8d; }
        .zone-benefits ul { margin-left: 15px; }
        .zone-benefits li { margin-bottom: 5px; }
        
        .intensity-meter { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .intensity-visual { height: 30px; background: linear-gradient(90deg, #a8e6cf, #dcedc1, #ffd3b6, #ffaaa5, #ff8b94); border-radius: 15px; margin: 15px 0; position: relative; }
        .intensity-markers { display: flex; justify-content: space-between; margin-top: 10px; font-size: 0.8rem; color: #7f8c8d; }
        
        .method-tabs { display: flex; margin-bottom: 20px; border-bottom: 2px solid #f0f0f0; }
        .method-tab { padding: 12px 20px; cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.3s; font-weight: 600; color: #7f8c8d; }
        .method-tab.active { color: #4facfe; border-bottom-color: #4facfe; }
        
        .method-content { display: none; }
        .method-content.active { display: block; }
        
        .quick-profiles { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-profiles h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; }
        .quick-btn { padding: 15px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #4facfe; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(79, 172, 254, 0.15); }
        .quick-value { font-weight: bold; color: #4facfe; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .training-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .training-table th, .training-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .training-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .training-table tr:hover { background: #e3f2fd; }
        
        .formula-box { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #4facfe; }
        .formula-box strong { color: #4facfe; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .input-row { grid-template-columns: 1fr; gap: 15px; }
            .zones-grid { grid-template-columns: 1fr; }
            .zone-stats { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .method-tabs { flex-wrap: wrap; }
            .method-tab { flex: 1; min-width: 120px; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>❤️ Training Zone Calculator</h1>
            <p>Calculate your heart rate training zones for optimal workout intensity and performance improvement</p>
        </div>

        <div class="calculator-card">
            <div class="method-tabs">
                <div class="method-tab active" data-method="maxhr">Max Heart Rate</div>
                <div class="method-tab" data-method="lthr">Lactate Threshold</div>
                <div class="method-tab" data-method="reserve">Heart Rate Reserve</div>
                <div class="method-tab" data-method="vo2">VO2 Max</div>
            </div>

            <!-- Max Heart Rate Method -->
            <div class="method-content active" id="maxhr-method">
                <div class="input-section">
                    <h3 class="section-title">Calculate by Maximum Heart Rate</h3>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="maxHR">Maximum Heart Rate (bpm)</label>
                            <input type="number" id="maxHR" placeholder="Enter max HR" min="100" max="220" value="185">
                        </div>
                        <div class="input-group">
                            <label for="age">Age (for estimation)</label>
                            <input type="number" id="age" placeholder="Enter age" min="15" max="100" value="35">
                        </div>
                    </div>
                    <button class="calculate-btn" onclick="calculateByMaxHR()">Calculate Training Zones</button>
                </div>
            </div>

            <!-- Lactate Threshold Method -->
            <div class="method-content" id="lthr-method">
                <div class="input-section">
                    <h3 class="section-title">Calculate by Lactate Threshold</h3>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="lthr">Lactate Threshold HR (bpm)</label>
                            <input type="number" id="lthr" placeholder="Enter LTHR" min="120" max="200" value="165">
                        </div>
                        <div class="input-group">
                            <label for="restingHR">Resting Heart Rate (bpm)</label>
                            <input type="number" id="restingHR" placeholder="Enter resting HR" min="40" max="100" value="60">
                        </div>
                    </div>
                    <button class="calculate-btn" onclick="calculateByLTHR()">Calculate Training Zones</button>
                </div>
            </div>

            <!-- Heart Rate Reserve Method -->
            <div class="method-content" id="reserve-method">
                <div class="input-section">
                    <h3 class="section-title">Calculate by Heart Rate Reserve (Karvonen)</h3>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="reserveMaxHR">Maximum Heart Rate (bpm)</label>
                            <input type="number" id="reserveMaxHR" placeholder="Enter max HR" min="100" max="220" value="185">
                        </div>
                        <div class="input-group">
                            <label for="reserveRestingHR">Resting Heart Rate (bpm)</label>
                            <input type="number" id="reserveRestingHR" placeholder="Enter resting HR" min="40" max="100" value="60">
                        </div>
                    </div>
                    <button class="calculate-btn" onclick="calculateByReserve()">Calculate Training Zones</button>
                </div>
            </div>

            <!-- VO2 Max Method -->
            <div class="method-content" id="vo2-method">
                <div class="input-section">
                    <h3 class="section-title">Calculate by VO2 Max</h3>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="vo2max">VO2 Max (ml/kg/min)</label>
                            <input type="number" id="vo2max" placeholder="Enter VO2 max" min="20" max="80" value="45">
                        </div>
                        <div class="input-group">
                            <label for="vo2RestingHR">Resting Heart Rate (bpm)</label>
                            <input type="number" id="vo2RestingHR" placeholder="Enter resting HR" min="40" max="100" value="60">
                        </div>
                    </div>
                    <button class="calculate-btn" onclick="calculateByVO2()">Calculate Training Zones</button>
                </div>
            </div>

            <div class="zones-section">
                <h3 class="section-title">Your Training Zones</h3>
                <div class="zones-grid" id="zonesGrid">
                    <!-- Zone cards will be generated here -->
                </div>

                <div class="intensity-meter">
                    <h3>📊 Intensity Spectrum</h3>
                    <div class="intensity-visual" id="intensityVisual">
                        <!-- Intensity markers will be added here -->
                    </div>
                    <div class="intensity-markers">
                        <span>Very Light</span>
                        <span>Light</span>
                        <span>Moderate</span>
                        <span>Hard</span>
                        <span>Maximum</span>
                    </div>
                </div>
            </div>

            <div class="quick-profiles">
                <h3>👥 Quick Athlete Profiles</h3>
                <div class="quick-grid">
                    <div class="quick-btn" onclick="setAthleteProfile('beginner')">
                        <div class="quick-value">Beginner</div>
                        <div class="quick-label">Age 30, Resting HR 70</div>
                    </div>
                    <div class="quick-btn" onclick="setAthleteProfile('intermediate')">
                        <div class="quick-value">Intermediate</div>
                        <div class="quick-label">Age 35, Resting HR 60</div>
                    </div>
                    <div class="quick-btn" onclick="setAthleteProfile('advanced')">
                        <div class="quick-value">Advanced</div>
                        <div class="quick-label">Age 40, Resting HR 50</div>
                    </div>
                    <div class="quick-btn" onclick="setAthleteProfile('elite')">
                        <div class="quick-value">Elite</div>
                        <div class="quick-label">Age 25, Resting HR 40</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>❤️ Understanding Training Zones</h2>
            
            <p>Training zones help you exercise at the right intensity to achieve specific fitness goals, from fat burning to peak performance improvement.</p>

            <h3>📊 5-Zone Training System</h3>
            <table class="training-table">
                <thead>
                    <tr>
                        <th>Zone</th>
                        <th>Intensity</th>
                        <th>% of Max HR</th>
                        <th>Perceived Exertion</th>
                        <th>Primary Benefit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Zone 1</td><td>Very Light</td><td>50-60%</td><td>1-2/10</td><td>Recovery, base building</td></tr>
                    <tr><td>Zone 2</td><td>Light</td><td>60-70%</td><td>3-4/10</td><td>Aerobic endurance, fat burning</td></tr>
                    <tr><td>Zone 3</td><td>Moderate</td><td>70-80%</td><td>5-6/10</td><td>Aerobic capacity</td></tr>
                    <tr><td>Zone 4</td><td>Hard</td><td>80-90%</td><td>7-8/10</td><td>Anaerobic threshold</td></tr>
                    <tr><td>Zone 5</td><td>Maximum</td><td>90-100%</td><td>9-10/10</td><td>VO2 max, peak performance</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Key Formulas:</strong><br>
                • <strong>Max HR Estimation:</strong> 220 - Age (common but less accurate)<br>
                • <strong>Heart Rate Reserve (HRR):</strong> Max HR - Resting HR<br>
                • <strong>Karvonen Formula:</strong> Target HR = (HRR × %Intensity) + Resting HR<br>
                • <strong>Lactate Threshold:</strong> Typically 80-90% of Max HR<br>
                • <strong>VO2 Max Correlation:</strong> Higher VO2 max = higher training intensities
            </div>

            <h3>🎯 Zone 1: Recovery & Very Light</h3>
            <ul>
                <li><strong>Intensity:</strong> 50-60% of Max HR</li>
                <li><strong>Perceived Exertion:</strong> 1-2/10 (Very Easy)</li>
                <li><strong>Breathing:</strong> Easy, can hold full conversation</li>
                <li><strong>Duration:</strong> 20-60 minutes</li>
                <li><strong>Benefits:</strong> Active recovery, improves circulation, aids muscle repair</li>
                <li><strong>Frequency:</strong> 1-2 times weekly, especially after hard workouts</li>
            </ul>

            <h3>🔥 Zone 2: Aerobic & Fat Burning</h3>
            <ul>
                <li><strong>Intensity:</strong> 60-70% of Max HR</li>
                <li><strong>Perceived Exertion:</strong> 3-4/10 (Comfortable)</li>
                <li><strong>Breathing:</strong> Steady, can speak in full sentences</li>
                <li><strong>Duration:</strong> 30 minutes to several hours</li>
                <li><strong>Benefits:</strong> Builds aerobic base, improves fat metabolism, enhances endurance</li>
                <li><strong>Frequency:</strong> Majority of training time (50-70%)</li>
            </ul>

            <h3>⚡ Zone 3: Tempo & Aerobic Capacity</h3>
            <ul>
                <li><strong>Intensity:</strong> 70-80% of Max HR</li>
                <li><strong>Perceived Exertion:</strong> 5-6/10 (Moderately Hard)</li>
                <li><strong>Breathing:</strong> Deep, can speak in short phrases</li>
                <li><strong>Duration:</strong> 20-60 minutes continuously</li>
                <li><strong>Benefits:</strong> Increases lactate threshold, improves aerobic power</li>
                <li><strong>Frequency:</strong> 1-2 times weekly</li>
            </ul>

            <h3>💥 Zone 4: Threshold & Hard</h3>
            <ul>
                <li><strong>Intensity:</strong> 80-90% of Max HR</li>
                <li><strong>Perceived Exertion:</strong> 7-8/10 (Hard)</li>
                <li><strong>Breathing:</strong> Heavy, can speak only a few words</li>
                <li><strong>Duration:</strong> 10-30 minutes in intervals</li>
                <li><strong>Benefits:</strong> Raises anaerobic threshold, improves race pace</li>
                <li><strong>Frequency:</strong> 1 time weekly (10-15% of total volume)</li>
            </ul>

            <h3>🚀 Zone 5: VO2 Max & Maximum</h3>
            <ul>
                <li><strong>Intensity:</strong> 90-100% of Max HR</li>
                <li><strong>Perceived Exertion:</strong> 9-10/10 (Maximum Effort)</li>
                <li><strong>Breathing:</strong> Very heavy, cannot speak</li>
                <li><strong>Duration:</strong> 30 seconds to 5 minutes in intervals</li>
                <li><strong>Benefits:</strong> Increases VO2 max, improves speed and power</li>
                <li><strong>Frequency:</strong> Occasionally (5-10% of total volume)</li>
            </ul>

            <h3>📈 Training Zone Distribution</h3>
            <table class="training-table">
                <thead>
                    <tr>
                        <th>Athlete Level</th>
                        <th>Zone 1-2</th>
                        <th>Zone 3</th>
                        <th>Zone 4-5</th>
                        <th>Total Weekly Hours</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Beginner</td><td>80%</td><td>15%</td><td>5%</td><td>3-5 hours</td></tr>
                    <tr><td>Intermediate</td><td>75%</td><td>15%</td><td>10%</td><td>5-8 hours</td></tr>
                    <tr><td>Advanced</td><td>70%</td><td>15%</td><td>15%</td><td>8-12 hours</td></tr>
                    <tr><td>Elite</td><td>80%</td><td>10%</td><td>10%</td><td>12-20 hours</td></tr>
                </tbody>
            </table>

            <h3>🔬 Calculation Methods</h3>
            <div class="formula-box">
                <strong>Maximum Heart Rate Method:</strong><br>
                • Simple formula: 220 - Age<br>
                • More accurate: 208 - (0.7 × Age)<br>
                • <strong>Pros:</strong> Easy to calculate<br>
                • <strong>Cons:</strong> Less accurate for individuals<br><br>
                
                <strong>Heart Rate Reserve (Karvonen):</strong><br>
                • HRR = Max HR - Resting HR<br>
                • Target HR = (HRR × Intensity) + Resting HR<br>
                • <strong>Pros:</strong> More personalized<br>
                • <strong>Cons:</strong> Requires knowing resting HR<br><br>
                
                <strong>Lactate Threshold Method:</strong><br>
                • Based on actual lactate threshold heart rate<br>
                • <strong>Pros:</strong> Most accurate for endurance training<br>
                • <strong>Cons:</strong> Requires testing
            </div>

            <h3>🎯 Sport-Specific Considerations</h3>
            <table class="training-table">
                <thead>
                    <tr>
                        <th>Sport</th>
                        <th>Primary Zones</th>
                        <th>Key Focus</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Running</td><td>2, 4, 5</td><td>Lactate threshold, VO2 max</td></tr>
                    <tr><td>Cycling</td><td>2, 3, 4</td><td>Aerobic endurance, power</td></tr>
                    <tr><td>Swimming</td><td>2, 3</td><td>Technique, aerobic capacity</td></tr>
                    <tr><td>Triathlon</td><td>2, 3</td><td>Fat metabolism, endurance</td></tr>
                    <tr><td>Weight Training</td><td>3, 4</td><td>Strength, power development</td></tr>
                </tbody>
            </table>

            <h3>📱 Measuring Your Heart Rate</h3>
            <ul>
                <li><strong>Chest Strap:</strong> Most accurate for training</li>
                <li><strong>Wrist-based Optical:</strong> Convenient but less accurate during intense exercise</li>
                <li><strong>Manual Pulse:</strong> Count beats for 15 seconds × 4</li>
                <li><strong>Smartwatch:</strong> Good for continuous monitoring</li>
            </ul>

            <h3>🌡️ Factors Affecting Heart Rate</h3>
            <ul>
                <li><strong>Temperature:</strong> HR increases in heat</li>
                <li><strong>Altitude:</strong> HR increases at higher elevations</li>
                <li><strong>Hydration:</strong> Dehydration increases HR</li>
                <li><strong>Caffeine:</strong> Can elevate resting HR</li>
                <li><strong>Stress:</strong> Mental stress increases HR</li>
                <li><strong>Time of Day:</strong> HR is typically lower in morning</li>
            </ul>

            <h3>💡 Training Zone Tips</h3>
            <div class="formula-box">
                <strong>For Beginners:</strong><br>
                • Focus on Zones 1-2 for first 2-3 months<br>
                • Gradually introduce Zone 3 workouts<br>
                • Listen to your body - perceived exertion matters<br><br>
                
                <strong>For Weight Loss:</strong><br>
                • Zones 2-3 are most effective for fat burning<br>
                • Longer duration in lower zones burns more calories<br>
                • High-intensity intervals boost metabolism<br><br>
                
                <strong>For Performance:</strong><br>
                • Periodize your training across all zones<br>
                • Include specific zone work for your sport<br>
                • Monitor progress with regular testing
            </div>

            <h3>⚠️ Safety Considerations</h3>
            <ul>
                <li>Consult doctor before starting intense exercise program</li>
                <li>Stop immediately if you experience chest pain, dizziness, or severe shortness of breath</li>
                <li>Build intensity gradually over weeks and months</li>
                <li>Stay hydrated and maintain proper nutrition</li>
                <li>Listen to your body - zones are guidelines, not absolute rules</li>
            </ul>

            <h3>📊 Tracking Progress</h3>
            <ul>
                <li><strong>Resting HR:</strong> Should decrease with improved fitness</li>
                <li><strong>Recovery HR:</strong> Faster drop after exercise indicates better fitness</li>
                <li><strong>Zone HR at Same Pace:</strong> Lower HR at same pace shows improvement</li>
                <li><strong>Perceived Exertion:</strong> Same effort feels easier as fitness improves</li>
            </ul>
        </div>

        <div class="footer">
            <p>❤️ Training Zone Calculator | Optimize Your Workout Intensity</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate heart rate zones using Max HR, Karvonen, Lactate Threshold, or VO2 Max methods</p>
        </div>
    </div>

    <script>
        // Method tabs functionality
        document.querySelectorAll('.method-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.method-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.method-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                tab.classList.add('active');
                const method = tab.getAttribute('data-method');
                document.getElementById(`${method}-method`).classList.add('active');
            });
        });

        // Zone definitions with colors and descriptions
        const zoneDefinitions = [
            {
                number: 1,
                name: "Recovery",
                color: "#a8e6cf",
                minPercent: 50,
                maxPercent: 60,
                description: "Very light activity for recovery and warm-up",
                benefits: ["Active recovery", "Improves circulation", "Aids muscle repair"],
                rpe: "1-2/10",
                breathing: "Easy, can hold full conversation",
                duration: "20-60 min"
            },
            {
                number: 2,
                name: "Aerobic",
                color: "#dcedc1",
                minPercent: 60,
                maxPercent: 70,
                description: "Light intensity for building aerobic base and fat burning",
                benefits: ["Builds aerobic endurance", "Improves fat metabolism", "Enhances recovery"],
                rpe: "3-4/10",
                breathing: "Steady, can speak in full sentences",
                duration: "30 min - several hours"
            },
            {
                number: 3,
                name: "Tempo",
                color: "#ffd3b6",
                minPercent: 70,
                maxPercent: 80,
                description: "Moderate intensity for improving aerobic capacity",
                benefits: ["Increases lactate threshold", "Builds mental toughness", "Improves aerobic power"],
                rpe: "5-6/10",
                breathing: "Deep, can speak in short phrases",
                duration: "20-60 min"
            },
            {
                number: 4,
                name: "Threshold",
                color: "#ffaaa5",
                minPercent: 80,
                maxPercent: 90,
                description: "Hard intensity for raising lactate threshold",
                benefits: ["Raises anaerobic threshold", "Improves race pace", "Builds power"],
                rpe: "7-8/10",
                breathing: "Heavy, can speak only a few words",
                duration: "10-30 min (intervals)"
            },
            {
                number: 5,
                name: "VO2 Max",
                color: "#ff8b94",
                minPercent: 90,
                maxPercent: 100,
                description: "Maximum intensity for improving VO2 max and speed",
                benefits: ["Increases VO2 max", "Develops speed", "Improves anaerobic capacity"],
                rpe: "9-10/10",
                breathing: "Very heavy, cannot speak",
                duration: "30 sec - 5 min (intervals)"
            }
        ];

        function calculateByMaxHR() {
            let maxHR = parseInt(document.getElementById('maxHR').value);
            const age = parseInt(document.getElementById('age').value);
            
            // If maxHR not provided, estimate from age
            if (!maxHR || maxHR < 100) {
                maxHR = 220 - age;
                document.getElementById('maxHR').value = maxHR;
            }
            
            calculateZones(maxHR, maxHR);
        }

        function calculateByLTHR() {
            const lthr = parseInt(document.getElementById('lthr').value);
            const restingHR = parseInt(document.getElementById('restingHR').value);
            
            // Estimate max HR from LTHR (LTHR is typically 80-90% of max)
            const estimatedMaxHR = lthr / 0.85;
            
            calculateZones(estimatedMaxHR, restingHR);
        }

        function calculateByReserve() {
            const maxHR = parseInt(document.getElementById('reserveMaxHR').value);
            const restingHR = parseInt(document.getElementById('reserveRestingHR').value);
            
            calculateZones(maxHR, restingHR);
        }

        function calculateByVO2() {
            const vo2max = parseInt(document.getElementById('vo2max').value);
            const restingHR = parseInt(document.getElementById('vo2RestingHR').value);
            
            // Estimate max HR from VO2 max (rough correlation)
            const estimatedMaxHR = 200 - (50 - vo2max);
            
            calculateZones(estimatedMaxHR, restingHR);
        }

        function calculateZones(maxHR, restingHR) {
            const zonesGrid = document.getElementById('zonesGrid');
            zonesGrid.innerHTML = '';
            
            const hrReserve = maxHR - restingHR;
            
            zoneDefinitions.forEach(zone => {
                // Calculate zone boundaries using Karvonen method
                const minHR = Math.round((hrReserve * (zone.minPercent / 100)) + restingHR);
                const maxHRZone = Math.round((hrReserve * (zone.maxPercent / 100)) + restingHR);
                
                // Simple percentage method for comparison
                const minSimple = Math.round(maxHR * (zone.minPercent / 100));
                const maxSimple = Math.round(maxHR * (zone.maxPercent / 100));
                
                const card = document.createElement('div');
                card.className = 'zone-card';
                card.innerHTML = `
                    <div class="zone-header" style="background: ${zone.color}">
                        <div class="zone-number">Zone ${zone.number}</div>
                        <div class="zone-name">${zone.name}</div>
                    </div>
                    <div class="zone-content">
                        <div class="zone-stats">
                            <div class="zone-stat">
                                <div class="zone-value">${minHR}-${maxHRZone}</div>
                                <div class="zone-label">HR Reserve (bpm)</div>
                            </div>
                            <div class="zone-stat">
                                <div class="zone-value">${minSimple}-${maxSimple}</div>
                                <div class="zone-label">Max HR % (bpm)</div>
                            </div>
                        </div>
                        <div class="zone-description">${zone.description}</div>
                        <div class="zone-benefits">
                            <strong>Benefits:</strong>
                            <ul>
                                ${zone.benefits.map(benefit => `<li>${benefit}</li>`).join('')}
                            </ul>
                            <div style="margin-top: 10px;">
                                <strong>RPE:</strong> ${zone.rpe} | 
                                <strong>Breathing:</strong> ${zone.breathing}
                            </div>
                        </div>
                    </div>
                `;
                zonesGrid.appendChild(card);
            });
            
            updateIntensityVisual();
        }

        function updateIntensityVisual() {
            const visual = document.getElementById('intensityVisual');
            visual.innerHTML = '';
            
            zoneDefinitions.forEach(zone => {
                const marker = document.createElement('div');
                marker.style.position = 'absolute';
                marker.style.left = `${zone.minPercent}%`;
                marker.style.top = '0';
                marker.style.width = '2px';
                marker.style.height = '100%';
                marker.style.backgroundColor = '#2c3e50';
                visual.appendChild(marker);
            });
        }

        function setAthleteProfile(level) {
            const profiles = {
                beginner: { age: 30, restingHR: 70, maxHR: 190 },
                intermediate: { age: 35, restingHR: 60, maxHR: 185 },
                advanced: { age: 40, restingHR: 50, maxHR: 180 },
                elite: { age: 25, restingHR: 40, maxHR: 195 }
            };
            
            const profile = profiles[level];
            
            // Update all method inputs
            document.getElementById('maxHR').value = profile.maxHR;
            document.getElementById('age').value = profile.age;
            document.getElementById('lthr').value = Math.round(profile.maxHR * 0.85);
            document.getElementById('restingHR').value = profile.restingHR;
            document.getElementById('reserveMaxHR').value = profile.maxHR;
            document.getElementById('reserveRestingHR').value = profile.restingHR;
            document.getElementById('vo2max').value = level === 'beginner' ? 35 : level === 'intermediate' ? 45 : level === 'advanced' ? 55 : 65;
            document.getElementById('vo2RestingHR').value = profile.restingHR;
            
            // Calculate with updated values
            calculateByMaxHR();
        }

        // Initialize with default calculation
        calculateByMaxHR();
    </script>
</body>
</html>
