<?php
/**
 * Anniversary Calculator
 * File: date-time/anniversary-calculator.php
 * Description: Track anniversaries and calculate milestone dates for special occasions
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anniversary Calculator - Track Milestone Dates & Celebrations</title>
    <meta name="description" content="Free anniversary calculator. Track anniversaries, calculate milestone dates, count days together, and plan special celebrations.">
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
            <h1>💝 Anniversary Calculator</h1>
            <p>Track anniversaries and calculate milestone dates for special occasions</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Anniversary Details</h2>
                <form id="anniversaryForm">
                    <div class="form-group">
                        <label for="occasionType">Occasion Type</label>
                        <select id="occasionType">
                            <option value="Wedding">Wedding Anniversary</option>
                            <option value="Relationship">Relationship Anniversary</option>
                            <option value="Dating">Dating Anniversary</option>
                            <option value="Engagement">Engagement Anniversary</option>
                            <option value="Business">Business Anniversary</option>
                            <option value="Other">Other</option>
                        </select>
                        <small>Select the type of anniversary</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" id="startDate" value="2015-01-15" required>
                        <small>Enter the date when it all began</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="calculateDate">Calculate As Of</label>
                        <input type="date" id="calculateDate" required>
                        <small>Usually today's date (default)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Anniversary</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Anniversary Results</h2>
                
                <div class="result-card">
                    <h3 id="occasionTypeDisplay">Wedding Anniversary</h3>
                    <div class="amount" id="yearsDisplay">10 Years</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Years</h4>
                        <div class="value" id="years">10</div>
                    </div>
                    <div class="metric-card">
                        <h4>Months</h4>
                        <div class="value" id="months">9</div>
                    </div>
                    <div class="metric-card">
                        <h4>Days</h4>
                        <div class="value" id="days">17</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Time Together</h3>
                    <div class="breakdown-item">
                        <span>Full Duration</span>
                        <strong id="fullDuration">10 years, 9 months, 17 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Months</span>
                        <strong id="totalMonths">129 months</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Weeks</span>
                        <strong id="totalWeeks">564 weeks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Days</span>
                        <strong id="totalDays">3,947 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Hours</span>
                        <strong id="totalHours">94,728 hours</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Important Dates</h3>
                    <div class="breakdown-item">
                        <span>Start Date</span>
                        <strong id="startDateDisplay">January 15, 2015</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Day of Week Started</span>
                        <strong id="dayOfWeek">Thursday</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Next Anniversary</span>
                        <strong id="nextAnniversary">January 15, 2026</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Days Until Next</span>
                        <strong id="daysUntilNext">75 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Traditional Gift</span>
                        <strong id="traditionalGift">Tin/Aluminum</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Modern Gift</span>
                        <strong id="modernGift">Diamond Jewelry</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Milestone Anniversaries</h3>
                    <div class="breakdown-item">
                        <span>5th Anniversary</span>
                        <strong id="milestone5">January 15, 2020 (Passed)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>10th Anniversary</span>
                        <strong id="milestone10">January 15, 2025 (Passed)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>15th Anniversary</span>
                        <strong id="milestone15">January 15, 2030</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>20th Anniversary</span>
                        <strong id="milestone20">January 15, 2035</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>25th Anniversary</span>
                        <strong id="milestone25">January 15, 2040 (Silver)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>50th Anniversary</span>
                        <strong id="milestone50">January 15, 2065 (Golden)</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Anniversary Traditions:</strong> Different anniversaries have traditional and modern gift themes. Major milestones like 25th (Silver) and 50th (Golden) are celebrated with special significance.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>💝 Anniversary Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Track and celebrate your special moments together</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('anniversaryForm');
        const calculateDateInput = document.getElementById('calculateDate');

        // Set today's date as default
        const today = new Date();
        calculateDateInput.value = today.toISOString().split('T')[0];

        // Anniversary gift themes
        const anniversaryGifts = {
            1: { traditional: 'Paper', modern: 'Clock' },
            2: { traditional: 'Cotton', modern: 'China' },
            3: { traditional: 'Leather', modern: 'Crystal/Glass' },
            4: { traditional: 'Fruit/Flowers', modern: 'Appliances' },
            5: { traditional: 'Wood', modern: 'Silverware' },
            6: { traditional: 'Candy/Iron', modern: 'Wood' },
            7: { traditional: 'Wool/Copper', modern: 'Desk Sets' },
            8: { traditional: 'Bronze/Pottery', modern: 'Linens/Lace' },
            9: { traditional: 'Pottery/Willow', modern: 'Leather' },
            10: { traditional: 'Tin/Aluminum', modern: 'Diamond Jewelry' },
            11: { traditional: 'Steel', modern: 'Fashion Jewelry' },
            12: { traditional: 'Silk/Linen', modern: 'Pearls' },
            13: { traditional: 'Lace', modern: 'Textiles/Furs' },
            14: { traditional: 'Ivory', modern: 'Gold Jewelry' },
            15: { traditional: 'Crystal', modern: 'Watches' },
            20: { traditional: 'China', modern: 'Platinum' },
            25: { traditional: 'Silver', modern: 'Silver' },
            30: { traditional: 'Pearl', modern: 'Diamond' },
            35: { traditional: 'Coral', modern: 'Jade' },
            40: { traditional: 'Ruby', modern: 'Ruby' },
            45: { traditional: 'Sapphire', modern: 'Sapphire' },
            50: { traditional: 'Gold', modern: 'Gold' },
            55: { traditional: 'Emerald', modern: 'Emerald' },
            60: { traditional: 'Diamond', modern: 'Diamond' }
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateAnniversary();
        });

        function calculateAnniversary() {
            const occasionType = document.getElementById('occasionType').value;
            const startDate = new Date(document.getElementById('startDate').value);
            const calculateDate = new Date(document.getElementById('calculateDate').value);

            if (startDate > calculateDate) {
                alert('Start date cannot be in the future!');
                return;
            }

            // Calculate duration
            let years = calculateDate.getFullYear() - startDate.getFullYear();
            let months = calculateDate.getMonth() - startDate.getMonth();
            let days = calculateDate.getDate() - startDate.getDate();

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
            const totalDaysValue = Math.floor((calculateDate - startDate) / (1000 * 60 * 60 * 24));
            const totalWeeksValue = Math.floor(totalDaysValue / 7);
            const totalMonthsValue = years * 12 + months;
            const totalHoursValue = totalDaysValue * 24;

            // Day of week started
            const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const dayStarted = daysOfWeek[startDate.getDay()];

            // Next anniversary
            let nextAnniversary = new Date(calculateDate.getFullYear(), startDate.getMonth(), startDate.getDate());
            if (nextAnniversary < calculateDate) {
                nextAnniversary.setFullYear(calculateDate.getFullYear() + 1);
            }
            const daysUntilNextValue = Math.floor((nextAnniversary - calculateDate) / (1000 * 60 * 60 * 24));

            // Get gift themes
            const giftTheme = anniversaryGifts[years] || { traditional: 'Unique', modern: 'Custom' };

            // Milestones
            const milestone5Date = new Date(startDate);
            milestone5Date.setFullYear(startDate.getFullYear() + 5);
            
            const milestone10Date = new Date(startDate);
            milestone10Date.setFullYear(startDate.getFullYear() + 10);
            
            const milestone15Date = new Date(startDate);
            milestone15Date.setFullYear(startDate.getFullYear() + 15);
            
            const milestone20Date = new Date(startDate);
            milestone20Date.setFullYear(startDate.getFullYear() + 20);
            
            const milestone25Date = new Date(startDate);
            milestone25Date.setFullYear(startDate.getFullYear() + 25);
            
            const milestone50Date = new Date(startDate);
            milestone50Date.setFullYear(startDate.getFullYear() + 50);

            // Update UI
            document.getElementById('occasionTypeDisplay').textContent = occasionType + ' Anniversary';
            document.getElementById('yearsDisplay').textContent = years + ' Year' + (years !== 1 ? 's' : '');
            document.getElementById('years').textContent = years;
            document.getElementById('months').textContent = months;
            document.getElementById('days').textContent = days;

            document.getElementById('fullDuration').textContent = `${years} years, ${months} months, ${days} days`;
            document.getElementById('totalMonths').textContent = totalMonthsValue.toLocaleString() + ' months';
            document.getElementById('totalWeeks').textContent = totalWeeksValue.toLocaleString() + ' weeks';
            document.getElementById('totalDays').textContent = totalDaysValue.toLocaleString() + ' days';
            document.getElementById('totalHours').textContent = totalHoursValue.toLocaleString() + ' hours';

            document.getElementById('startDateDisplay').textContent = formatDate(startDate);
            document.getElementById('dayOfWeek').textContent = dayStarted;
            document.getElementById('nextAnniversary').textContent = formatDate(nextAnniversary);
            document.getElementById('daysUntilNext').textContent = daysUntilNextValue + ' days';
            document.getElementById('traditionalGift').textContent = giftTheme.traditional;
            document.getElementById('modernGift').textContent = giftTheme.modern;

            document.getElementById('milestone5').textContent = formatDate(milestone5Date) + (calculateDate >= milestone5Date ? ' (Passed)' : '');
            document.getElementById('milestone10').textContent = formatDate(milestone10Date) + (calculateDate >= milestone10Date ? ' (Passed)' : '');
            document.getElementById('milestone15').textContent = formatDate(milestone15Date) + (calculateDate >= milestone15Date ? '' : '');
            document.getElementById('milestone20').textContent = formatDate(milestone20Date) + (calculateDate >= milestone20Date ? '' : '');
            document.getElementById('milestone25').textContent = formatDate(milestone25Date) + ' (Silver)';
            document.getElementById('milestone50').textContent = formatDate(milestone50Date) + ' (Golden)';
        }

        function formatDate(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        window.addEventListener('load', function() {
            calculateAnniversary();
        });
    </script>
</body>
</html>