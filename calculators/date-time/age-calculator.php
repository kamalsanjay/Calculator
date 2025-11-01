<?php
/**
 * Age Calculator
 * File: date-time/age-calculator.php
 * Description: Calculate exact age in years, months, days and determine life milestones
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Age Calculator - Calculate Exact Age & Life Milestones</title>
    <meta name="description" content="Free age calculator. Calculate exact age in years, months, days. Determine life milestones, next birthday, and time until special ages.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
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
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); }
        
        .result-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; }
        .result-card .amount { font-size: 3rem; font-weight: bold; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #667eea; font-size: 2rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #667eea; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        .breakdown-item.highlight { background: rgba(102, 126, 234, 0.05); padding: 12px; border-radius: 8px; margin-bottom: 8px; }
        
        .info-box { background: #e8f2ff; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .header h1 { font-size: 2rem; }
            .result-card .amount { font-size: 2.5rem; }
            .metric-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎂 Age Calculator</h1>
            <p>Calculate exact age in years, months, days and determine life milestones</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Birth Details</h2>
                <form id="ageForm">
                    <div class="form-group">
                        <label for="birthDate">Date of Birth</label>
                        <input type="date" id="birthDate" value="1990-05-15" required>
                        <small>Enter your birth date</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="calculateDate">Calculate As Of</label>
                        <input type="date" id="calculateDate" required>
                        <small>Usually today's date (default)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="gender">Gender (Optional)</label>
                        <select id="gender">
                            <option value="">Not specified</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <small>Used for life expectancy calculations</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Age</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Age Results</h2>
                
                <div class="result-card">
                    <h3>Current Age</h3>
                    <div class="amount" id="ageDisplay">34 Years</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Years</h4>
                        <div class="value" id="years">34</div>
                    </div>
                    <div class="metric-card">
                        <h4>Months</h4>
                        <div class="value" id="months">7</div>
                    </div>
                    <div class="metric-card">
                        <h4>Days</h4>
                        <div class="value" id="days">12</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Age Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Exact Age</span>
                        <strong id="exactAge">34 years, 7 months, 12 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Months</span>
                        <strong id="totalMonths">415 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Weeks</span>
                        <strong id="totalWeeks">1,805 weeks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Days</span>
                        <strong id="totalDays">12,635 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Hours</span>
                        <strong id="totalHours">303,240 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Minutes</span>
                        <strong id="totalMinutes">18,194,400 minutes</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Birth Information</h3>
                    <div class="breakdown-item">
                        <span>Date of Birth</span>
                        <strong id="birthDateDisplay">May 15, 1990</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Day of Birth</span>
                        <strong id="dayOfBirth">Tuesday</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Zodiac Sign</span>
                        <strong id="zodiacSign">Taurus</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Chinese Zodiac</span>
                        <strong id="chineseZodiac">Horse</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Birthstone</span>
                        <strong id="birthstone">Emerald</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Birthday Information</h3>
                    <div class="breakdown-item">
                        <span>Next Birthday</span>
                        <strong id="nextBirthday">May 15, 2025</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Days Until Next Birthday</span>
                        <strong id="daysUntilBirthday">247 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Day of Week for Next Birthday</span>
                        <strong id="nextBirthdayDay">Thursday</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Age at Next Birthday</span>
                        <strong id="ageNextBirthday">35 years</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Life Milestones</h3>
                    <div class="breakdown-item">
                        <span>18th Birthday</span>
                        <strong id="milestone18">May 15, 2008 (Passed)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>21st Birthday</span>
                        <strong id="milestone21">May 15, 2011 (Passed)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>30th Birthday</span>
                        <strong id="milestone30">May 15, 2020 (Passed)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>40th Birthday</span>
                        <strong id="milestone40">May 15, 2030</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>50th Birthday</span>
                        <strong id="milestone50">May 15, 2040</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>65th Birthday (Retirement)</span>
                        <strong id="milestone65">May 15, 2055</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Life Expectancy:</strong> Based on current averages, you have approximately <strong id="lifeExpectancy">45.3 years</strong> remaining (approx. <strong id="remainingYears">45 years</strong>, <strong id="remainingMonths">4 months</strong>).
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🎂 Age Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate your exact age and important life milestones</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('ageForm');
        const calculateDateInput = document.getElementById('calculateDate');

        // Set today's date as default
        const today = new Date();
        calculateDateInput.value = today.toISOString().split('T')[0];

        // Zodiac signs
        const zodiacSigns = [
            { name: "Capricorn", start: [12, 22], end: [1, 19] },
            { name: "Aquarius", start: [1, 20], end: [2, 18] },
            { name: "Pisces", start: [2, 19], end: [3, 20] },
            { name: "Aries", start: [3, 21], end: [4, 19] },
            { name: "Taurus", start: [4, 20], end: [5, 20] },
            { name: "Gemini", start: [5, 21], end: [6, 20] },
            { name: "Cancer", start: [6, 21], end: [7, 22] },
            { name: "Leo", start: [7, 23], end: [8, 22] },
            { name: "Virgo", start: [8, 23], end: [9, 22] },
            { name: "Libra", start: [9, 23], end: [10, 22] },
            { name: "Scorpio", start: [10, 23], end: [11, 21] },
            { name: "Sagittarius", start: [11, 22], end: [12, 21] }
        ];

        // Chinese Zodiac
        const chineseZodiacs = ["Rat", "Ox", "Tiger", "Rabbit", "Dragon", "Snake", "Horse", "Goat", "Monkey", "Rooster", "Dog", "Pig"];

        // Birthstones
        const birthstones = [
            "Garnet", "Amethyst", "Aquamarine", "Diamond", "Emerald", 
            "Pearl", "Ruby", "Peridot", "Sapphire", "Opal", "Topaz", "Turquoise"
        ];

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateAge();
        });

        function calculateAge() {
            const birthDate = new Date(document.getElementById('birthDate').value);
            const calculateDate = new Date(document.getElementById('calculateDate').value);
            const gender = document.getElementById('gender').value;

            if (birthDate > calculateDate) {
                alert('Birth date cannot be in the future!');
                return;
            }

            // Calculate age
            let years = calculateDate.getFullYear() - birthDate.getFullYear();
            let months = calculateDate.getMonth() - birthDate.getMonth();
            let days = calculateDate.getDate() - birthDate.getDate();

            // Adjust for negative days
            if (days < 0) {
                months--;
                const prevMonth = new Date(calculateDate.getFullYear(), calculateDate.getMonth(), 0);
                days += prevMonth.getDate();
            }

            // Adjust for negative months
            if (months < 0) {
                years--;
                months += 12;
            }

            // Total calculations
            const totalDaysValue = Math.floor((calculateDate - birthDate) / (1000 * 60 * 60 * 24));
            const totalWeeksValue = Math.floor(totalDaysValue / 7);
            const totalMonthsValue = years * 12 + months;
            const totalHoursValue = totalDaysValue * 24;
            const totalMinutesValue = totalHoursValue * 60;

            // Day of birth
            const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const dayOfBirth = daysOfWeek[birthDate.getDay()];

            // Zodiac sign
            const zodiacSign = getZodiacSign(birthDate.getMonth(), birthDate.getDate());
            
            // Chinese zodiac
            const chineseZodiac = chineseZodiacs[(birthDate.getFullYear() - 4) % 12];
            
            // Birthstone
            const birthstone = birthstones[birthDate.getMonth()];

            // Next birthday
            let nextBirthday = new Date(calculateDate.getFullYear(), birthDate.getMonth(), birthDate.getDate());
            if (nextBirthday < calculateDate) {
                nextBirthday.setFullYear(calculateDate.getFullYear() + 1);
            }
            const daysUntilBirthday = Math.floor((nextBirthday - calculateDate) / (1000 * 60 * 60 * 24));
            const nextBirthdayDay = daysOfWeek[nextBirthday.getDay()];
            const ageNextBirthday = nextBirthday.getFullYear() - birthDate.getFullYear();

            // Milestones
            const milestone18Date = new Date(birthDate);
            milestone18Date.setFullYear(birthDate.getFullYear() + 18);
            
            const milestone21Date = new Date(birthDate);
            milestone21Date.setFullYear(birthDate.getFullYear() + 21);
            
            const milestone30Date = new Date(birthDate);
            milestone30Date.setFullYear(birthDate.getFullYear() + 30);
            
            const milestone40Date = new Date(birthDate);
            milestone40Date.setFullYear(birthDate.getFullYear() + 40);
            
            const milestone50Date = new Date(birthDate);
            milestone50Date.setFullYear(birthDate.getFullYear() + 50);
            
            const milestone65Date = new Date(birthDate);
            milestone65Date.setFullYear(birthDate.getFullYear() + 65);

            // Life expectancy calculation (simplified)
            let lifeExpectancyYears = 80; // Base average
            if (gender === 'male') lifeExpectancyYears = 76;
            if (gender === 'female') lifeExpectancyYears = 81;
            
            const remainingYears = lifeExpectancyYears - years;
            const remainingMonths = Math.floor((lifeExpectancyYears - years - (months/12)) * 12) % 12;
            const lifeExpectancyDecimal = (remainingYears + (remainingMonths/12)).toFixed(1);

            // Update UI
            document.getElementById('ageDisplay').textContent = years + ' Year' + (years !== 1 ? 's' : '');
            document.getElementById('years').textContent = years;
            document.getElementById('months').textContent = months;
            document.getElementById('days').textContent = days;

            document.getElementById('exactAge').textContent = `${years} years, ${months} months, ${days} days`;
            document.getElementById('totalMonths').textContent = totalMonthsValue.toLocaleString() + ' months';
            document.getElementById('totalWeeks').textContent = totalWeeksValue.toLocaleString() + ' weeks';
            document.getElementById('totalDays').textContent = totalDaysValue.toLocaleString() + ' days';
            document.getElementById('totalHours').textContent = totalHoursValue.toLocaleString() + ' hours';
            document.getElementById('totalMinutes').textContent = totalMinutesValue.toLocaleString() + ' minutes';

            document.getElementById('birthDateDisplay').textContent = formatDate(birthDate);
            document.getElementById('dayOfBirth').textContent = dayOfBirth;
            document.getElementById('zodiacSign').textContent = zodiacSign;
            document.getElementById('chineseZodiac').textContent = chineseZodiac;
            document.getElementById('birthstone').textContent = birthstone;

            document.getElementById('nextBirthday').textContent = formatDate(nextBirthday);
            document.getElementById('daysUntilBirthday').textContent = daysUntilBirthday + ' days';
            document.getElementById('nextBirthdayDay').textContent = nextBirthdayDay;
            document.getElementById('ageNextBirthday').textContent = ageNextBirthday + ' years';

            document.getElementById('milestone18').textContent = formatDate(milestone18Date) + (calculateDate >= milestone18Date ? ' (Passed)' : '');
            document.getElementById('milestone21').textContent = formatDate(milestone21Date) + (calculateDate >= milestone21Date ? ' (Passed)' : '');
            document.getElementById('milestone30').textContent = formatDate(milestone30Date) + (calculateDate >= milestone30Date ? ' (Passed)' : '');
            document.getElementById('milestone40').textContent = formatDate(milestone40Date) + (calculateDate >= milestone40Date ? '' : '');
            document.getElementById('milestone50').textContent = formatDate(milestone50Date) + (calculateDate >= milestone50Date ? '' : '');
            document.getElementById('milestone65').textContent = formatDate(milestone65Date) + (calculateDate >= milestone65Date ? '' : '');

            document.getElementById('lifeExpectancy').textContent = lifeExpectancyDecimal + ' years';
            document.getElementById('remainingYears').textContent = remainingYears;
            document.getElementById('remainingMonths').textContent = remainingMonths;
        }

        function getZodiacSign(month, day) {
            for (const sign of zodiacSigns) {
                const [startMonth, startDay] = sign.start;
                const [endMonth, endDay] = sign.end;
                
                if (
                    (month === startMonth - 1 && day >= startDay) ||
                    (month === endMonth - 1 && day <= endDay) ||
                    (startMonth > endMonth && (
                        (month === startMonth - 1 && day >= startDay) ||
                        (month === endMonth - 1 && day <= endDay)
                    ))
                ) {
                    return sign.name;
                }
            }
            return "Unknown";
        }

        function formatDate(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        window.addEventListener('load', function() {
            calculateAge();
        });
    </script>
</body>
</html>