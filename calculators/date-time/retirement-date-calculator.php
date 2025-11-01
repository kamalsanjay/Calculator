<?php
/**
 * Retirement Date Calculator
 * File: date-time/retirement-date-calculator.php
 * Description: Calculate your retirement date based on age, years of service, or specific criteria
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retirement Date Calculator - Plan Your Retirement Date & Timeline</title>
    <meta name="description" content="Free retirement date calculator. Calculate when you can retire based on age, years of service, or specific retirement criteria.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh; 
            padding: 15px;
        }
        
        .container { 
            max-width: 1200px; 
            margin: 0 auto;
            width: 100%;
        }
        
        .header { 
            background: rgba(255,255,255,0.95); 
            padding: 25px 20px; 
            border-radius: 15px 15px 0 0; 
            box-shadow: 0 -3px 15px rgba(0,0,0,0.1); 
            text-align: center; 
        }
        .header h1 { 
            color: #2c3e50; 
            font-size: clamp(1.8rem, 4vw, 2.5rem); 
            margin-bottom: 8px; 
            word-wrap: break-word;
        }
        .header p { 
            color: #7f8c8d; 
            font-size: clamp(1rem, 2.5vw, 1.2rem); 
            opacity: 0.9; 
            line-height: 1.4;
        }
        
        .calculator-wrapper { 
            display: grid; 
            grid-template-columns: 1fr; 
            gap: 25px; 
            background: white; 
            padding: 25px 20px; 
            box-shadow: 0 5px 25px rgba(0,0,0,0.1); 
        }
        
        @media (min-width: 768px) {
            .calculator-wrapper {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
                padding: 35px;
            }
        }
        
        .calculator-section h2, .results-section h2 { 
            color: #667eea; 
            margin-bottom: 20px; 
            font-size: clamp(1.5rem, 3vw, 1.8rem);
            word-wrap: break-word;
        }
        
        .form-group { 
            margin-bottom: 18px; 
            width: 100%;
        }
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            color: #555; 
            font-size: clamp(0.9rem, 2vw, 1rem);
        }
        .form-group input, .form-group select { 
            width: 100%; 
            padding: 12px 10px; 
            border: 2px solid #e0e0e0; 
            border-radius: 8px; 
            font-size: 16px; 
            transition: border-color 0.3s; 
            max-width: 100%;
            box-sizing: border-box;
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
            font-size: 0.85em;
            line-height: 1.3;
        }
        
        .radio-group { 
            display: flex; 
            flex-direction: column;
            gap: 10px;
            margin-bottom: 15px;
        }
        .radio-option { 
            display: flex; 
            align-items: center; 
            margin-bottom: 8px; 
        }
        .radio-option input { 
            width: auto; 
            margin-right: 10px; 
            transform: scale(1.2);
        }
        .radio-option label { 
            margin-bottom: 0; 
            font-weight: normal; 
            font-size: clamp(0.9rem, 2vw, 1rem);
        }
        
        .checkbox-group { 
            display: flex; 
            align-items: center; 
            margin-bottom: 12px; 
            flex-wrap: wrap;
        }
        .checkbox-group input { 
            width: auto; 
            margin-right: 10px; 
            transform: scale(1.2);
        }
        .checkbox-group label { 
            margin-bottom: 0; 
            font-weight: normal; 
            font-size: clamp(0.9rem, 2vw, 1rem);
        }
        
        .btn { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 14px 20px; 
            border: none; 
            border-radius: 8px; 
            font-size: clamp(1rem, 2.5vw, 1.1rem); 
            font-weight: 600; 
            cursor: pointer; 
            width: 100%; 
            transition: all 0.3s; 
            margin-top: 10px;
        }
        .btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 6px 15px rgba(102, 126, 234, 0.3); 
        }
        
        .result-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 20px 15px; 
            border-radius: 10px; 
            margin-bottom: 18px; 
            text-align: center; 
            box-shadow: 0 3px 12px rgba(102, 126, 234, 0.3); 
            width: 100%;
        }
        .result-card h3 { 
            font-size: clamp(1rem, 2.5vw, 1.2rem); 
            opacity: 0.9; 
            margin-bottom: 8px; 
            font-weight: 400; 
        }
        .result-card .amount { 
            font-size: clamp(2rem, 6vw, 3rem); 
            font-weight: bold; 
            word-wrap: break-word;
        }
        
        .metric-grid { 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            gap: 12px; 
            margin-bottom: 18px; 
        }
        @media (max-width: 480px) {
            .metric-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }
        .metric-card { 
            background: #f8f9fa; 
            padding: 15px 10px; 
            border-radius: 10px; 
            text-align: center; 
            border: 2px solid #e0e0e0; 
            min-width: 0;
        }
        .metric-card h4 { 
            color: #666; 
            font-size: 0.85rem; 
            margin-bottom: 8px; 
            font-weight: 400; 
        }
        .metric-card .value { 
            color: #667eea; 
            font-size: clamp(1.3rem, 4vw, 1.8rem); 
            font-weight: bold; 
        }
        
        .breakdown { 
            background: #f8f9fa; 
            padding: 18px 15px; 
            border-radius: 10px; 
            margin-bottom: 18px; 
            width: 100%;
            overflow: hidden;
        }
        .breakdown h3 { 
            color: #667eea; 
            margin-bottom: 12px; 
            font-size: clamp(1.2rem, 3vw, 1.3rem);
        }
        .breakdown-item { 
            display: flex; 
            justify-content: space-between; 
            padding: 10px 0; 
            border-bottom: 1px solid #e0e0e0; 
            flex-wrap: wrap;
            gap: 5px;
        }
        .breakdown-item:last-child { 
            border-bottom: none; 
        }
        .breakdown-item span { 
            color: #666; 
            font-size: clamp(0.85rem, 2vw, 0.9rem);
        }
        .breakdown-item strong { 
            color: #333; 
            font-weight: 600; 
            font-size: clamp(0.85rem, 2vw, 0.9rem);
            text-align: right;
            min-width: min-content;
        }
        .breakdown-item.highlight { 
            background: rgba(102, 126, 234, 0.05); 
            padding: 10px; 
            border-radius: 6px; 
            margin-bottom: 6px; 
        }
        
        .timeline { 
            margin: 20px 0;
            position: relative;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #667eea;
            border-radius: 2px;
        }
        .timeline-item { 
            position: relative;
            padding-left: 25px;
            margin-bottom: 20px;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 5px;
            width: 15px;
            height: 15px;
            background: #667eea;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 0 2px #667eea;
        }
        .timeline-date { 
            font-weight: bold; 
            color: #667eea;
            margin-bottom: 5px;
        }
        .timeline-content { 
            color: #666;
            font-size: 0.9rem;
        }
        
        .progress-container {
            background: #f0f0f0;
            border-radius: 10px;
            height: 20px;
            margin: 15px 0;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            transition: width 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .info-box { 
            background: #e8f2ff; 
            border-left: 4px solid #667eea; 
            padding: 12px 15px; 
            margin: 18px 0; 
            border-radius: 5px; 
            font-size: clamp(0.85rem, 2vw, 0.9rem);
            line-height: 1.4;
        }
        .info-box strong { 
            color: #667eea; 
        }
        
        .footer { 
            background: rgba(255,255,255,0.95); 
            padding: 20px 15px; 
            border-radius: 0 0 15px 15px; 
            text-align: center; 
            color: #7f8c8d; 
            font-size: clamp(0.85rem, 2vw, 0.9rem);
        }
        
        /* Additional responsive fixes */
        input[type="date"], input[type="number"], input[type="text"], select {
            min-height: 44px;
        }
        
        .calculator-section, .results-section {
            width: 100%;
            overflow: hidden;
        }
        
        @media (max-width: 767px) {
            body {
                padding: 10px;
            }
            
            .header {
                padding: 20px 15px;
            }
            
            .calculator-wrapper {
                padding: 20px 15px;
                gap: 20px;
            }
            
            .breakdown-item {
                flex-direction: column;
            }
            
            .breakdown-item span,
            .breakdown-item strong {
                width: 100%;
                text-align: left;
            }
            
            .breakdown-item strong {
                margin-top: 2px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏖️ Retirement Date Calculator</h1>
            <p>Calculate your retirement date based on age, years of service, or specific criteria</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Retirement Information</h2>
                <form id="retirementForm">
                    <div class="form-group">
                        <label for="birthDate">Date of Birth</label>
                        <input type="date" id="birthDate" value="1980-05-15" required>
                        <small>Your birth date</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="calculationMethod">Retirement Calculation Method</label>
                        <select id="calculationMethod">
                            <option value="age">By Target Retirement Age</option>
                            <option value="service">By Years of Service</option>
                            <option value="date">By Specific Retirement Date</option>
                        </select>
                        <small>Choose how you want to calculate retirement</small>
                    </div>
                    
                    <div class="form-group" id="retirementAgeGroup">
                        <label for="retirementAge">Target Retirement Age</label>
                        <input type="number" id="retirementAge" min="55" max="75" value="65">
                        <small>Age at which you plan to retire</small>
                    </div>
                    
                    <div class="form-group" id="serviceYearsGroup" style="display: none;">
                        <label for="serviceYears">Years of Service Required</label>
                        <input type="number" id="serviceYears" min="10" max="50" value="30">
                        <small>Total years of service needed for retirement</small>
                    </div>
                    
                    <div class="form-group" id="startDateGroup">
                        <label for="startDate">Employment Start Date</label>
                        <input type="date" id="startDate" value="2000-09-01">
                        <small>When you started working</small>
                    </div>
                    
                    <div class="form-group" id="specificDateGroup" style="display: none;">
                        <label for="specificDate">Planned Retirement Date</label>
                        <input type="date" id="specificDate" value="2045-05-15">
                        <small>Your target retirement date</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select id="country">
                            <option value="us">United States</option>
                            <option value="uk">United Kingdom</option>
                            <option value="ca">Canada</option>
                            <option value="au">Australia</option>
                            <option value="in">India</option>
                            <option value="other">Other</option>
                        </select>
                        <small>For retirement age reference</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Retirement Options</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="earlyRetirement">
                            <label for="earlyRetirement">Consider early retirement options</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="extendedWork">
                            <label for="extendedWork">Plan for extended work life</label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Retirement Date</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Retirement Results</h2>
                
                <div class="result-card">
                    <h3>Your Retirement Date</h3>
                    <div class="amount" id="retirementDateDisplay">May 15, 2045</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Current Age</h4>
                        <div class="value" id="currentAge">44</div>
                    </div>
                    <div class="metric-card">
                        <h4>Years Until Retirement</h4>
                        <div class="value" id="yearsUntil">21</div>
                    </div>
                    <div class="metric-card">
                        <h4>Retirement Age</h4>
                        <div class="value" id="retirementAgeDisplay">65</div>
                    </div>
                    <div class="metric-card">
                        <h4>Service Years</h4>
                        <div class="value" id="serviceYearsDisplay">45</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Retirement Timeline</h3>
                    <div class="progress-container">
                        <div class="progress-bar" id="retirementProgress" style="width: 45%">45% Complete</div>
                    </div>
                    <div class="breakdown-item">
                        <span>Work Life Completed</span>
                        <strong id="workCompleted">45%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Work Life Remaining</span>
                        <strong id="workRemaining">55%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Working Years</span>
                        <strong id="totalWorkingYears">45 years</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Key Milestones</h3>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-date" id="earlyRetirementDate">2035 (Age 55)</div>
                            <div class="timeline-content">Earliest possible retirement with penalties</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-date" id="fullRetirementDate">2045 (Age 65)</div>
                            <div class="timeline-content">Full retirement benefits available</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-date" id="delayedRetirementDate">2050 (Age 70)</div>
                            <div class="timeline-content">Maximum retirement benefits</div>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Retirement Planning</h3>
                    <div class="breakdown-item">
                        <span>Years to Save</span>
                        <strong id="yearsToSave">21 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Months to Save</span>
                        <strong id="monthsToSave">252 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weeks to Save</span>
                        <strong id="weeksToSave">1,092 weeks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Working Days Remaining</span>
                        <strong id="workingDaysRemaining">5,460 days</strong>
                    </div>
                    <div class="breakdown-item highlight">
                        <span>Estimated Retirement Duration</span>
                        <strong id="retirementDuration">20+ years</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Country Reference</h3>
                    <div class="breakdown-item">
                        <span>Standard Retirement Age</span>
                        <strong id="standardRetirementAge">65-67 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Early Retirement Age</span>
                        <strong id="earlyRetirementAge">62 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Life Expectancy</span>
                        <strong id="lifeExpectancy">78-82 years</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Retirement Planning Tip:</strong> Most financial advisors recommend saving 10-15% of your income for retirement. The earlier you start saving, the more time your money has to grow through compound interest.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🏖️ Retirement Date Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Plan your retirement timeline and financial future</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('retirementForm');
        const calculationMethod = document.getElementById('calculationMethod');
        const retirementAgeGroup = document.getElementById('retirementAgeGroup');
        const serviceYearsGroup = document.getElementById('serviceYearsGroup');
        const startDateGroup = document.getElementById('startDateGroup');
        const specificDateGroup = document.getElementById('specificDateGroup');

        // Set default dates
        const today = new Date();
        document.getElementById('birthDate').value = '1980-05-15';
        document.getElementById('startDate').value = '2000-09-01';
        document.getElementById('specificDate').value = '2045-05-15';

        // Country retirement data
        const retirementData = {
            us: {
                standard: "65-67 years",
                early: "62 years",
                lifeExpectancy: "78-82 years",
                fullAge: 67,
                earlyAge: 62
            },
            uk: {
                standard: "66-68 years",
                early: "63 years",
                lifeExpectancy: "81-83 years",
                fullAge: 68,
                earlyAge: 63
            },
            ca: {
                standard: "65-67 years",
                early: "60 years",
                lifeExpectancy: "82-84 years",
                fullAge: 67,
                earlyAge: 60
            },
            au: {
                standard: "66-67 years",
                early: "60 years",
                lifeExpectancy: "83-85 years",
                fullAge: 67,
                earlyAge: 60
            },
            in: {
                standard: "58-60 years",
                early: "50 years",
                lifeExpectancy: "70-72 years",
                fullAge: 60,
                earlyAge: 50
            },
            other: {
                standard: "65-67 years",
                early: "60-62 years",
                lifeExpectancy: "75-80 years",
                fullAge: 65,
                earlyAge: 60
            }
        };

        // Toggle form fields based on calculation method
        calculationMethod.addEventListener('change', function() {
            const method = this.value;
            
            // Hide all groups first
            retirementAgeGroup.style.display = 'none';
            serviceYearsGroup.style.display = 'none';
            startDateGroup.style.display = 'none';
            specificDateGroup.style.display = 'none';
            
            // Show relevant groups
            if (method === 'age') {
                retirementAgeGroup.style.display = 'block';
                startDateGroup.style.display = 'block';
            } else if (method === 'service') {
                serviceYearsGroup.style.display = 'block';
                startDateGroup.style.display = 'block';
            } else if (method === 'date') {
                specificDateGroup.style.display = 'block';
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateRetirement();
        });

        function calculateRetirement() {
            const birthDate = new Date(document.getElementById('birthDate').value);
            const method = document.getElementById('calculationMethod').value;
            const country = document.getElementById('country').value;
            const today = new Date();
            
            let retirementDate;
            let retirementAge;
            let serviceYears;
            
            if (method === 'age') {
                retirementAge = parseInt(document.getElementById('retirementAge').value);
                retirementDate = calculateByAge(birthDate, retirementAge);
                serviceYears = calculateServiceYears(new Date(document.getElementById('startDate').value), retirementDate);
            } else if (method === 'service') {
                serviceYears = parseInt(document.getElementById('serviceYears').value);
                const startDate = new Date(document.getElementById('startDate').value);
                retirementDate = calculateByServiceYears(startDate, serviceYears);
                retirementAge = calculateAge(birthDate, retirementDate);
            } else if (method === 'date') {
                retirementDate = new Date(document.getElementById('specificDate').value);
                retirementAge = calculateAge(birthDate, retirementDate);
                serviceYears = calculateServiceYears(new Date(document.getElementById('startDate').value), retirementDate);
            }
            
            // Calculate additional metrics
            const currentAge = calculateAge(birthDate, today);
            const yearsUntilRetirement = Math.floor((retirementDate - today) / (365.25 * 24 * 60 * 60 * 1000));
            const totalWorkingYears = calculateServiceYears(new Date(document.getElementById('startDate').value), retirementDate);
            const workCompleted = calculateServiceYears(new Date(document.getElementById('startDate').value), today);
            const workCompletedPercent = Math.round((workCompleted / totalWorkingYears) * 100);
            
            // Get country-specific data
            const countryData = retirementData[country] || retirementData.other;
            
            // Update UI
            updateRetirementUI(birthDate, retirementDate, retirementAge, serviceYears, currentAge, 
                            yearsUntilRetirement, workCompletedPercent, totalWorkingYears, countryData);
        }

        function calculateByAge(birthDate, retirementAge) {
            const retirementDate = new Date(birthDate);
            retirementDate.setFullYear(birthDate.getFullYear() + retirementAge);
            return retirementDate;
        }

        function calculateByServiceYears(startDate, serviceYears) {
            const retirementDate = new Date(startDate);
            retirementDate.setFullYear(startDate.getFullYear() + serviceYears);
            return retirementDate;
        }

        function calculateAge(birthDate, targetDate) {
            const age = targetDate.getFullYear() - birthDate.getFullYear();
            const monthDiff = targetDate.getMonth() - birthDate.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && targetDate.getDate() < birthDate.getDate())) {
                return age - 1;
            }
            return age;
        }

        function calculateServiceYears(startDate, endDate) {
            const years = endDate.getFullYear() - startDate.getFullYear();
            const monthDiff = endDate.getMonth() - startDate.getMonth();
            
            let serviceYears = years;
            if (monthDiff < 0 || (monthDiff === 0 && endDate.getDate() < startDate.getDate())) {
                serviceYears = years - 1;
            }
            
            return Math.max(0, serviceYears);
        }

        function updateRetirementUI(birthDate, retirementDate, retirementAge, serviceYears, currentAge, 
                                  yearsUntil, workCompletedPercent, totalWorkingYears, countryData) {
            
            // Main results
            document.getElementById('retirementDateDisplay').textContent = formatDate(retirementDate);
            document.getElementById('currentAge').textContent = currentAge;
            document.getElementById('yearsUntil').textContent = yearsUntil;
            document.getElementById('retirementAgeDisplay').textContent = retirementAge;
            document.getElementById('serviceYearsDisplay').textContent = serviceYears;
            
            // Progress and timeline
            document.getElementById('retirementProgress').style.width = workCompletedPercent + '%';
            document.getElementById('retirementProgress').textContent = workCompletedPercent + '% Complete';
            document.getElementById('workCompleted').textContent = workCompletedPercent + '%';
            document.getElementById('workRemaining').textContent = (100 - workCompletedPercent) + '%';
            document.getElementById('totalWorkingYears').textContent = totalWorkingYears + ' years';
            
            // Timeline dates
            const earlyRetirementDate = new Date(birthDate);
            earlyRetirementDate.setFullYear(birthDate.getFullYear() + countryData.earlyAge);
            
            const fullRetirementDate = new Date(birthDate);
            fullRetirementDate.setFullYear(birthDate.getFullYear() + countryData.fullAge);
            
            const delayedRetirementDate = new Date(birthDate);
            delayedRetirementDate.setFullYear(birthDate.getFullYear() + 70);
            
            document.getElementById('earlyRetirementDate').textContent = 
                `${earlyRetirementDate.getFullYear()} (Age ${countryData.earlyAge})`;
            document.getElementById('fullRetirementDate').textContent = 
                `${fullRetirementDate.getFullYear()} (Age ${countryData.fullAge})`;
            document.getElementById('delayedRetirementDate').textContent = 
                `${delayedRetirementDate.getFullYear()} (Age 70)`;
            
            // Planning metrics
            document.getElementById('yearsToSave').textContent = yearsUntil + ' years';
            document.getElementById('monthsToSave').textContent = (yearsUntil * 12) + ' months';
            document.getElementById('weeksToSave').textContent = (yearsUntil * 52) + ' weeks';
            document.getElementById('workingDaysRemaining').textContent = (yearsUntil * 260) + ' days';
            
            // Estimate retirement duration based on life expectancy
            const lifeExpectancyAvg = 80; // Conservative estimate
            const retirementDuration = Math.max(0, lifeExpectancyAvg - retirementAge);
            document.getElementById('retirementDuration').textContent = retirementDuration + '+ years';
            
            // Country reference
            document.getElementById('standardRetirementAge').textContent = countryData.standard;
            document.getElementById('earlyRetirementAge').textContent = countryData.early;
            document.getElementById('lifeExpectancy').textContent = countryData.lifeExpectancy;
        }

        function formatDate(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        // Initialize form
        window.addEventListener('load', function() {
            // Trigger the change event to set initial visibility
            calculationMethod.dispatchEvent(new Event('change'));
            calculateRetirement();
        });
    </script>
</body>
</html>