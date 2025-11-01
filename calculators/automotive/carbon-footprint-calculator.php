<?php
/**
 * Carbon Footprint Calculator
 * File: automotive/carbon-footprint-calculator.php
 * Description: Advanced carbon footprint calculator with lifestyle analysis and reduction strategies
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carbon Footprint Calculator - CO2 Emissions & Environmental Impact Analysis</title>
    <meta name="description" content="Advanced carbon footprint calculator. Calculate your CO2 emissions from transportation, home energy, food, and lifestyle choices.">
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
            grid-template-columns: 2fr 1fr; 
            gap: 10px; 
            align-items: end; 
        }
        
        .section-title { 
            background: #f8f9fa; 
            padding: 15px; 
            border-radius: 8px; 
            margin: 25px 0 15px 0; 
            border-left: 4px solid #4CAF50; 
        }
        .section-title h3 { 
            color: #2c3e50; 
            margin: 0; 
            font-size: 1.3rem; 
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
        
        .impact-gauge { 
            height: 20px; 
            background: #e0e0e0; 
            border-radius: 10px; 
            overflow: hidden; 
            margin: 15px 0; 
            position: relative; 
        }
        .impact-fill { 
            height: 100%; 
            background: linear-gradient(90deg, #4CAF50, #FFC107, #F44336); 
            width: 0%; 
            transition: width 1s ease-out; 
        }
        .impact-labels { 
            display: flex; 
            justify-content: space-between; 
            margin-top: 5px; 
            font-size: 0.8rem; 
            color: #666; 
        }
        
        .comparison-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 15px; 
            margin-top: 15px; 
        }
        .comparison-card { 
            background: white; 
            padding: 15px; 
            border-radius: 8px; 
            border: 2px solid #e0e0e0; 
            text-align: center; 
            transition: all 0.3s; 
        }
        .comparison-card:hover { 
            transform: translateY(-2px); 
            border-color: #667eea; 
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.2); 
        }
        .comparison-card h4 { 
            color: #667eea; 
            margin-bottom: 10px; 
        }
        .comparison-card .co2 { 
            font-size: 1.5rem; 
            font-weight: bold; 
            color: #333; 
        }
        .comparison-card .description { 
            color: #666; 
            font-size: 0.9rem; 
        }
        
        .recommendation-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 15px; 
            margin-top: 15px; 
        }
        .recommendation-card { 
            background: #e8f5e8; 
            padding: 15px; 
            border-radius: 8px; 
            border-left: 4px solid #4CAF50; 
        }
        .recommendation-card h4 { 
            color: #2c3e50; 
            margin-bottom: 8px; 
        }
        .recommendation-card p { 
            color: #666; 
            font-size: 0.9rem; 
            margin-bottom: 8px; 
        }
        .recommendation-card .savings { 
            color: #4CAF50; 
            font-weight: bold; 
        }
        
        .lifestyle-preset { 
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
        
        .progress-ring { 
            width: 120px; 
            height: 120px; 
            margin: 0 auto 20px; 
        }
        .progress-circle { 
            transform: rotate(-90deg); 
        }
        .progress-bg { 
            fill: none; 
            stroke: #e0e0e0; 
            stroke-width: 8; 
        }
        .progress-fill { 
            fill: none; 
            stroke: #4CAF50; 
            stroke-width: 8; 
            stroke-linecap: round; 
            stroke-dasharray: 283; 
            stroke-dashoffset: 283; 
            transition: stroke-dashoffset 1s ease-out; 
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
            .lifestyle-preset { 
                grid-template-columns: repeat(2, 1fr); 
            }
            .comparison-grid, .recommendation-grid { 
                grid-template-columns: 1fr; 
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
            <h1>🌍 Carbon Footprint Calculator</h1>
            <p>Calculate your CO2 emissions and discover ways to reduce your environmental impact</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Lifestyle Assessment</h2>
                <form id="footprintForm">
                    
                    <div class="section-title">
                        <h3>🚗 Transportation</h3>
                    </div>
                    
                    <div class="form-group">
                        <label for="carMileage">Annual Car Mileage</label>
                        <div class="input-group">
                            <input type="number" id="carMileage" value="12000" min="0" max="100000" step="1000" required>
                            <select id="mileageUnit" style="padding: 12px;">
                                <option value="miles" selected>Miles</option>
                                <option value="km">Kilometers</option>
                            </select>
                        </div>
                        <small>Total miles/kilometers driven per year</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="carEfficiency">Vehicle Fuel Efficiency</label>
                        <div class="input-group">
                            <input type="number" id="carEfficiency" value="25" min="5" max="100" step="1" required>
                            <select id="efficiencyUnit" style="padding: 12px;">
                                <option value="mpg" selected>MPG</option>
                                <option value="l100km">L/100km</option>
                            </select>
                        </div>
                        <small>Your vehicle's fuel efficiency</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="publicTransport">Public Transport Usage</label>
                        <select id="publicTransport" style="padding: 12px;">
                            <option value="none">Never</option>
                            <option value="rare">Rarely (1-2 times/month)</option>
                            <option value="occasional" selected>Occasionally (1-2 times/week)</option>
                            <option value="frequent">Frequently (3-5 times/week)</option>
                            <option value="daily">Daily</option>
                        </select>
                        <small>How often you use buses, trains, or subways</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="flights">Flights per Year</label>
                        <select id="flights" style="padding: 12px;">
                            <option value="0">None</option>
                            <option value="1" selected>1-2 short flights</option>
                            <option value="2">3-5 short flights</option>
                            <option value="3">1 long international flight</option>
                            <option value="4">2+ long international flights</option>
                        </select>
                        <small>Approximate air travel frequency</small>
                    </div>
                    
                    <div class="section-title">
                        <h3>🏠 Home Energy</h3>
                    </div>
                    
                    <div class="form-group">
                        <label for="electricityUsage">Monthly Electricity Usage</label>
                        <div class="input-group">
                            <input type="number" id="electricityUsage" value="900" min="0" max="5000" step="50" required>
                            <select id="electricityUnit" style="padding: 12px;">
                                <option value="kwh" selected>kWh</option>
                            </select>
                        </div>
                        <small>Average monthly electricity consumption</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="energySource">Primary Energy Source</label>
                        <select id="energySource" style="padding: 12px;">
                            <option value="mixed">Mixed Grid (Average)</option>
                            <option value="coal">Coal Dominant</option>
                            <option value="naturalGas">Natural Gas</option>
                            <option value="renewable">Renewable Energy</option>
                            <option value="solar">Solar/Wind</option>
                        </select>
                        <small>Your local electricity generation mix</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="heatingType">Home Heating Type</label>
                        <select id="heatingType" style="padding: 12px;">
                            <option value="naturalGas" selected>Natural Gas</option>
                            <option value="electric">Electric</option>
                            <option value="oil">Heating Oil</option>
                            <option value="propane">Propane</option>
                            <option value="wood">Wood</option>
                        </select>
                        <small>Primary heating fuel for your home</small>
                    </div>
                    
                    <div class="section-title">
                        <h3>🍽️ Food & Diet</h3>
                    </div>
                    
                    <div class="form-group">
                        <label for="dietType">Diet Type</label>
                        <select id="dietType" style="padding: 12px;">
                            <option value="heavyMeat">Heavy Meat Eater</option>
                            <option value="average" selected>Average Meat Eater</option>
                            <option value="lightMeat">Light Meat Eater</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="vegan">Vegan</option>
                        </select>
                        <small>Your typical dietary pattern</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="foodWaste">Food Waste Level</label>
                        <select id="foodWaste" style="padding: 12px;">
                            <option value="high">High (30%+ wasted)</option>
                            <option value="average" selected>Average (15-30% wasted)</option>
                            <option value="low">Low (5-15% wasted)</option>
                            <option value="minimal">Minimal (<5% wasted)</option>
                        </select>
                        <small>How much food you typically waste</small>
                    </div>
                    
                    <div class="section-title">
                        <h3>🛍️ Shopping & Lifestyle</h3>
                    </div>
                    
                    <div class="form-group">
                        <label for="shoppingHabits">Shopping Habits</label>
                        <select id="shoppingHabits" style="padding: 12px;">
                            <option value="minimal">Minimalist</option>
                            <option value="average" selected>Average Consumer</option>
                            <option value="frequent">Frequent Shopper</option>
                            <option value="heavy">Heavy Consumer</option>
                        </select>
                        <small>Your general consumption patterns</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="recycling">Recycling Efforts</label>
                        <select id="recycling" style="padding: 12px;">
                            <option value="none">No Recycling</option>
                            <option value="basic">Basic Recycling</option>
                            <option value="good" selected>Good Recycling</option>
                            <option value="excellent">Comprehensive Recycling</option>
                        </select>
                        <small>How much you recycle and compost</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Lifestyle Presets</label>
                        <div class="lifestyle-preset">
                            <div class="preset-btn" onclick="setPreset('EcoWarrior', '5000', '45', 'daily', '0', '600', 'renewable', 'vegetarian', 'minimal', 'excellent')">Eco Warrior</div>
                            <div class="preset-btn" onclick="setPreset('Average', '12000', '25', 'occasional', '1', '900', 'mixed', 'average', 'average', 'good')">Average</div>
                            <div class="preset-btn" onclick="setPreset('Urban', '8000', '30', 'daily', '2', '700', 'mixed', 'lightMeat', 'average', 'good')">Urban Dweller</div>
                            <div class="preset-btn" onclick="setPreset('Suburban', '15000', '20', 'rare', '3', '1200', 'naturalGas', 'heavyMeat', 'frequent', 'basic')">Suburban</div>
                            <div class="preset-btn" onclick="setPreset('Rural', '20000', '18', 'none', '1', '1500', 'coal', 'average', 'average', 'none')">Rural</div>
                            <div class="preset-btn" onclick="setPreset('FrequentFlyer', '10000', '28', 'occasional', '4', '1100', 'mixed', 'average', 'heavy', 'basic')">Frequent Flyer</div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Carbon Footprint</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Environmental Impact</h2>
                
                <div class="result-card">
                    <h3>Annual Carbon Footprint</h3>
                    <div class="amount" id="totalFootprint">14.2 tons</div>
                    <div style="position: relative; z-index: 1;">CO₂ equivalent per year</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Daily Footprint</h4>
                        <div class="value" id="dailyFootprint">38.9 kg</div>
                    </div>
                    <div class="metric-card">
                        <h4>vs. National Avg</h4>
                        <div class="value" id="vsAverage">-12%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Planetary Budget</h4>
                        <div class="value" id="planetaryBudget">245%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Emission Sources</h3>
                    <div class="breakdown-item">
                        <span>🚗 Transportation</span>
                        <strong id="transportEmissions">5.4 tons (38%)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>🏠 Home Energy</span>
                        <strong id="homeEmissions">4.8 tons (34%)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>🍽️ Food & Diet</span>
                        <strong id="foodEmissions">2.7 tons (19%)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>🛍️ Goods & Services</span>
                        <strong id="goodsEmissions">1.3 tons (9%)</strong>
                    </div>
                    
                    <div class="progress-ring">
                        <svg class="progress-circle" width="120" height="120" viewBox="0 0 120 120">
                            <circle class="progress-bg" cx="60" cy="60" r="54"></circle>
                            <circle class="progress-fill" cx="60" cy="60" r="54" id="transportRing"></circle>
                        </svg>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Environmental Impact</h3>
                    <div class="breakdown-item">
                        <span>Equivalent to Driving</span>
                        <strong id="carEquivalence">32,456 miles</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Trees Needed to Offset</span>
                        <strong id="treesNeeded">217 trees</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>CO₂ per Capita Goal</span>
                        <strong id="capitaGoal">2.0 tons/year</strong>
                    </div>
                    
                    <div class="impact-gauge">
                        <div class="impact-fill" id="impactFill"></div>
                    </div>
                    <div class="impact-labels">
                        <span>Low Impact</span>
                        <span>Moderate</span>
                        <span>High Impact</span>
                        <span>Very High</span>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Comparison with Others</h3>
                    <div class="comparison-grid">
                        <div class="comparison-card">
                            <h4>Your Footprint</h4>
                            <div class="co2" id="yourComparison">14.2 tons</div>
                            <div class="description">Annual CO₂ emissions</div>
                        </div>
                        <div class="comparison-card">
                            <h4>US Average</h4>
                            <div class="co2">16.0 tons</div>
                            <div class="description">Per person annually</div>
                        </div>
                        <div class="comparison-card">
                            <h4>EU Average</h4>
                            <div class="co2">6.4 tons</div>
                            <div class="description">Per person annually</div>
                        </div>
                        <div class="comparison-card">
                            <h4>Sustainable Goal</h4>
                            <div class="co2">2.0 tons</div>
                            <div class="description">Target for 2050</div>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Reduction Recommendations</h3>
                    <div class="recommendation-grid" id="recommendations">
                        <!-- Recommendations will be populated by JavaScript -->
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Offset Options</h3>
                    <div class="breakdown-item">
                        <span>Carbon Offset Cost</span>
                        <strong id="offsetCost">$284/year</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Renewable Energy</span>
                        <strong id="renewableImpact">-2.1 tons</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Public Transport</span>
                        <strong id="transportImpact">-1.8 tons</span>
                    </div>
                    <div class="breakdown-item">
                        <span>Plant-based Diet</span>
                        <strong id="dietImpact">-1.2 tons</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> This calculator provides estimates based on average emission factors. Actual emissions may vary based on specific circumstances, local infrastructure, and individual habits. Regular assessment helps track progress toward sustainability goals.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🌍 Carbon Footprint Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Environmental impact assessment and reduction strategies</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('footprintForm');
        let currentPreset = '';

        // Emission factors (kg CO2e per unit)
        const emissionFactors = {
            // Transportation
            gasoline: 8.91, // kg CO2 per gallon
            diesel: 10.16, // kg CO2 per gallon
            electricityGrid: 0.5, // kg CO2 per kWh (US average)
            naturalGas: 5.3, // kg CO2 per therm
            flightShort: 90, // kg CO2 per hour
            flightLong: 150, // kg CO2 per hour
            
            // Food (kg CO2e per year)
            diet: {
                heavyMeat: 3000,
                average: 2300,
                lightMeat: 1800,
                vegetarian: 1500,
                vegan: 1200
            },
            
            // Shopping (kg CO2e per year)
            shopping: {
                minimal: 500,
                average: 1200,
                frequent: 2000,
                heavy: 3000
            }
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateFootprint();
        });

        function setPreset(name, mileage, efficiency, transport, flights, electricity, energy, diet, shopping, recycling) {
            document.getElementById('carMileage').value = mileage;
            document.getElementById('carEfficiency').value = efficiency;
            document.getElementById('publicTransport').value = transport;
            document.getElementById('flights').value = flights;
            document.getElementById('electricityUsage').value = electricity;
            document.getElementById('energySource').value = energy;
            document.getElementById('dietType').value = diet;
            document.getElementById('shoppingHabits').value = shopping;
            document.getElementById('recycling').value = recycling;
            currentPreset = name;
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateFootprint();
        }

        function calculateFootprint() {
            // Get inputs
            let carMileage = parseFloat(document.getElementById('carMileage').value);
            const mileageUnit = document.getElementById('mileageUnit').value;
            let carEfficiency = parseFloat(document.getElementById('carEfficiency').value);
            const efficiencyUnit = document.getElementById('efficiencyUnit').value;
            const publicTransport = document.getElementById('publicTransport').value;
            const flights = parseInt(document.getElementById('flights').value);
            const electricityUsage = parseFloat(document.getElementById('electricityUsage').value);
            const energySource = document.getElementById('energySource').value;
            const dietType = document.getElementById('dietType').value;
            const foodWaste = document.getElementById('foodWaste').value;
            const shoppingHabits = document.getElementById('shoppingHabits').value;
            const recycling = document.getElementById('recycling').value;
            const heatingType = document.getElementById('heatingType').value;
            
            // Convert units if needed
            if (mileageUnit === 'km') {
                carMileage = carMileage * 0.621371; // Convert km to miles
            }
            
            if (efficiencyUnit === 'l100km') {
                carEfficiency = 235.214 / carEfficiency; // Convert L/100km to MPG
            }
            
            // Calculate transportation emissions
            const gallonsUsed = carMileage / carEfficiency;
            const carEmissions = gallonsUsed * emissionFactors.gasoline;
            
            // Calculate public transport emissions
            const transportFactors = {
                none: 0,
                rare: 100,
                occasional: 300,
                frequent: 600,
                daily: 1200
            };
            const transportEmissions = transportFactors[publicTransport];
            
            // Calculate flight emissions
            const flightFactors = [0, 180, 450, 600, 1200]; // kg CO2 per year
            const flightEmissions = flightFactors[flights];
            
            // Calculate home energy emissions
            const energyFactors = {
                mixed: 0.5,
                coal: 1.0,
                naturalGas: 0.45,
                renewable: 0.1,
                solar: 0.05
            };
            const electricityEmissions = electricityUsage * 12 * energyFactors[energySource];
            
            // Calculate heating emissions (simplified)
            const heatingFactors = {
                naturalGas: 5000,
                electric: 3000,
                oil: 6000,
                propane: 4500,
                wood: 1000
            };
            const heatingEmissions = heatingFactors[heatingType];
            
            // Calculate food emissions
            let foodEmissions = emissionFactors.diet[dietType];
            
            // Adjust for food waste
            const wasteFactors = {
                high: 1.3,
                average: 1.15,
                low: 1.05,
                minimal: 1.0
            };
            foodEmissions *= wasteFactors[foodWaste];
            
            // Calculate shopping emissions
            const shoppingEmissions = emissionFactors.shopping[shoppingHabits];
            
            // Apply recycling reduction
            const recyclingFactors = {
                none: 1.0,
                basic: 0.95,
                good: 0.9,
                excellent: 0.85
            };
            const shoppingReduction = recyclingFactors[recycling];
            
            // Calculate total emissions
            const transportTotal = (carEmissions + transportEmissions + flightEmissions) / 1000; // Convert to tons
            const homeTotal = (electricityEmissions + heatingEmissions) / 1000;
            const foodTotal = foodEmissions / 1000;
            const goodsTotal = (shoppingEmissions * shoppingReduction) / 1000;
            
            const totalFootprint = transportTotal + homeTotal + foodTotal + goodsTotal;
            const dailyFootprint = (totalFootprint * 1000) / 365; // kg per day
            
            // Calculate comparisons
            const usAverage = 16.0;
            const euAverage = 6.4;
            const sustainableGoal = 2.0;
            
            const vsAverage = ((totalFootprint - usAverage) / usAverage * 100).toFixed(0);
            const planetaryBudget = (totalFootprint / sustainableGoal * 100).toFixed(0);
            
            // Calculate environmental equivalents
            const carEquivalence = (totalFootprint * 1000 / emissionFactors.gasoline * carEfficiency).toFixed(0);
            const treesNeeded = Math.ceil(totalFootprint * 1000 / 50); // Rough estimate: 50kg CO2 per tree per year
            
            // Calculate reduction potentials
            const renewableImpact = homeTotal * 0.4; // 40% reduction with renewables
            const transportImpact = transportTotal * 0.3; // 30% reduction with public transport
            const dietImpact = foodTotal * 0.4; // 40% reduction with plant-based diet
            
            // Calculate offset cost ($20 per ton is common)
            const offsetCost = totalFootprint * 20;
            
            // Update UI
            document.getElementById('totalFootprint').textContent = totalFootprint.toFixed(1) + ' tons';
            document.getElementById('dailyFootprint').textContent = dailyFootprint.toFixed(1) + ' kg';
            document.getElementById('vsAverage').textContent = (vsAverage > 0 ? '+' : '') + vsAverage + '%';
            document.getElementById('planetaryBudget').textContent = planetaryBudget + '%';
            
            document.getElementById('transportEmissions').textContent = transportTotal.toFixed(1) + ' tons (' + Math.round(transportTotal/totalFootprint*100) + '%)';
            document.getElementById('homeEmissions').textContent = homeTotal.toFixed(1) + ' tons (' + Math.round(homeTotal/totalFootprint*100) + '%)';
            document.getElementById('foodEmissions').textContent = foodTotal.toFixed(1) + ' tons (' + Math.round(foodTotal/totalFootprint*100) + '%)';
            document.getElementById('goodsEmissions').textContent = goodsTotal.toFixed(1) + ' tons (' + Math.round(goodsTotal/totalFootprint*100) + '%)';
            
            document.getElementById('carEquivalence').textContent = carEquivalence + ' miles';
            document.getElementById('treesNeeded').textContent = treesNeeded + ' trees';
            document.getElementById('capitaGoal').textContent = sustainableGoal + ' tons/year';
            
            document.getElementById('yourComparison').textContent = totalFootprint.toFixed(1) + ' tons';
            document.getElementById('offsetCost').textContent = '$' + Math.round(offsetCost) + '/year';
            document.getElementById('renewableImpact').textContent = '-' + renewableImpact.toFixed(1) + ' tons';
            document.getElementById('transportImpact').textContent = '-' + transportImpact.toFixed(1) + ' tons';
            document.getElementById('dietImpact').textContent = '-' + dietImpact.toFixed(1) + ' tons';
            
            // Update visual indicators
            updateVisualIndicators(totalFootprint, transportTotal, homeTotal, foodTotal, goodsTotal);
            
            // Generate recommendations
            generateRecommendations(transportTotal, homeTotal, foodTotal, goodsTotal, totalFootprint);
        }
        
        function updateVisualIndicators(totalFootprint, transport, home, food, goods) {
            // Update impact gauge
            const impactPercentage = Math.min(100, (totalFootprint / 20) * 100); // Scale to 20 tons max
            document.getElementById('impactFill').style.width = impactPercentage + '%';
            
            // Update progress rings for each category
            const total = transport + home + food + goods;
            const transportPercent = (transport / total) * 283;
            document.getElementById('transportRing').style.strokeDashoffset = 283 - transportPercent;
        }
        
        function generateRecommendations(transport, home, food, goods, total) {
            const recommendations = document.getElementById('recommendations');
            recommendations.innerHTML = '';
            
            const recs = [];
            
            // Transportation recommendations
            if (transport > 3) {
                recs.push({
                    title: '🚗 Reduce Car Usage',
                    description: 'Consider carpooling, public transport, or switching to an electric vehicle.',
                    savings: 'Save up to 2 tons CO₂/year'
                });
            }
            
            if (transport > 2) {
                recs.push({
                    title: '✈️ Limit Air Travel',
                    description: 'Reduce flights and choose direct routes when possible. Consider video conferencing.',
                    savings: 'Save 0.5-2 tons CO₂/year'
                });
            }
            
            // Home energy recommendations
            if (home > 3) {
                recs.push({
                    title: '🏠 Improve Home Efficiency',
                    description: 'Upgrade insulation, use smart thermostat, and switch to LED lighting.',
                    savings: 'Save 1-3 tons CO₂/year'
                });
            }
            
            if (home > 2) {
                recs.push({
                    title: '⚡ Switch to Renewable Energy',
                    description: 'Install solar panels or choose a green energy provider.',
                    savings: 'Save 2-4 tons CO₂/year'
                });
            }
            
            // Food recommendations
            if (food > 2) {
                recs.push({
                    title: '🍽️ Reduce Meat Consumption',
                    description: 'Try meat-free days and choose plant-based proteins.',
                    savings: 'Save 0.5-1.5 tons CO₂/year'
                });
            }
            
            if (food > 1.5) {
                recs.push({
                    title: '🗑️ Reduce Food Waste',
                    description: 'Plan meals, store food properly, and compost organic waste.',
                    savings: 'Save 0.3-0.8 tons CO₂/year'
                });
            }
            
            // Shopping recommendations
            if (goods > 1) {
                recs.push({
                    title: '🛍️ Conscious Consumption',
                    description: 'Buy less, choose quality over quantity, and support sustainable brands.',
                    savings: 'Save 0.5-1 ton CO₂/year'
                });
            }
            
            recs.push({
                title: '🌳 Carbon Offsetting',
                description: 'Support verified carbon offset projects to neutralize remaining emissions.',
                savings: 'Become carbon neutral'
            });
            
            // Add recommendations to DOM
            recs.forEach(rec => {
                const card = document.createElement('div');
                card.className = 'recommendation-card';
                card.innerHTML = `
                    <h4>${rec.title}</h4>
                    <p>${rec.description}</p>
                    <div class="savings">${rec.savings}</div>
                `;
                recommendations.appendChild(card);
            });
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateFootprint();
        });
    </script>
</body>
</html>
