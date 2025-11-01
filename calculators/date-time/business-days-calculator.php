<?php
/**
 * Business Days Calculator
 * File: date-time/business-days-calculator.php
 * Description: Calculate business days between dates, excluding weekends and holidays
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Days Calculator - Calculate Working Days Excluding Weekends & Holidays</title>
    <meta name="description" content="Free business days calculator. Calculate working days between dates, exclude weekends and holidays, add business days to dates.">
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
            grid-template-columns: repeat(3, 1fr); 
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
            font-size: clamp(1.5rem, 4vw, 2rem); 
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
        
        /* Enhanced Calendar Styles */
        .calendar-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .calendar-nav-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.3s;
        }
        
        .calendar-nav-btn:hover {
            background: #5a6fd8;
        }
        
        .calendar-nav-btn:disabled {
            background: #cccccc;
            cursor: not-allowed;
        }
        
        .calendar-month-year {
            font-weight: bold;
            color: #667eea;
            font-size: 1.1rem;
            text-align: center;
            flex-grow: 1;
        }
        
        .calendar-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-top: 15px;
        }
        
        @media (min-width: 992px) {
            .calendar-container {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        .month-calendar {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .month-calendar h4 {
            text-align: center;
            margin-bottom: 15px;
            color: #667eea;
            font-size: 1.1rem;
        }
        
        .calendar-grid { 
            display: grid; 
            grid-template-columns: repeat(7, 1fr); 
            gap: 4px; 
        }
        .calendar-day { 
            padding: 8px 2px; 
            text-align: center; 
            border-radius: 4px; 
            font-size: 0.75rem; 
            min-height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            position: relative;
        }
        @media (min-width: 480px) {
            .calendar-day {
                padding: 8px 4px;
                font-size: 0.8rem;
                min-height: 40px;
            }
        }
        .calendar-day.weekend { 
            background: #ffe6e6; 
            color: #cc0000; 
        }
        .calendar-day.business { 
            background: #e6ffe6; 
            color: #006600; 
        }
        .calendar-day.holiday { 
            background: #fff0e6; 
            color: #cc6600; 
            position: relative;
        }
        .calendar-day.holiday::after {
            content: '🎉';
            position: absolute;
            top: 2px;
            right: 2px;
            font-size: 0.6rem;
        }
        .calendar-day.today { 
            border: 2px solid #667eea;
            font-weight: bold;
        }
        .calendar-day.outside-range {
            background: #f8f8f8;
            color: #ccc;
        }
        .calendar-day.header { 
            font-weight: bold; 
            background: #f0f0f0; 
            font-size: 0.7rem;
            min-height: auto;
        }
        @media (min-width: 480px) {
            .calendar-day.header {
                font-size: 0.8rem;
            }
        }
        
        .legend {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.8rem;
        }
        
        .legend-color {
            width: 15px;
            height: 15px;
            border-radius: 3px;
        }
        
        .legend-business {
            background: #e6ffe6;
            border: 1px solid #006600;
        }
        
        .legend-weekend {
            background: #ffe6e6;
            border: 1px solid #cc0000;
        }
        
        .legend-holiday {
            background: #fff0e6;
            border: 1px solid #cc6600;
        }
        
        .calendar-summary {
            margin-top: 10px;
            font-size: 0.85rem;
            color: #666;
            text-align: center;
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
            min-height: 44px; /* Better touch targets on mobile */
        }
        
        /* Ensure no horizontal overflow */
        .calculator-section, .results-section {
            width: 100%;
            overflow: hidden;
        }
        
        /* Better spacing for mobile */
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
            
            .calendar-navigation {
                flex-direction: column;
                align-items: stretch;
            }
            
            .calendar-nav-btn {
                width: 100%;
                margin-bottom: 5px;
            }
        }
        
        /* Fix for very small screens */
        @media (max-width: 360px) {
            .calendar-grid {
                grid-template-columns: repeat(7, minmax(0, 1fr));
            }
            
            .calendar-day {
                padding: 4px 1px;
                font-size: 0.7rem;
                min-height: 30px;
            }
            
            .header h1 {
                font-size: 1.6rem;
            }
            
            .legend {
                flex-direction: column;
                align-items: center;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Business Days Calculator</h1>
            <p>Calculate working days between dates, excluding weekends and holidays</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Date Range</h2>
                <form id="businessDaysForm">
                    <div class="form-group">
                        <label for="calculationType">Calculation Type</label>
                        <select id="calculationType">
                            <option value="between">Calculate Business Days Between Dates</option>
                            <option value="add">Add Business Days to Date</option>
                        </select>
                        <small>Choose what you want to calculate</small>
                    </div>
                    
                    <div class="form-group" id="startDateGroup">
                        <label for="startDate">Start Date</label>
                        <input type="date" id="startDate" value="2024-01-01" required>
                        <small>Project or period start date</small>
                    </div>
                    
                    <div class="form-group" id="endDateGroup">
                        <label for="endDate">End Date</label>
                        <input type="date" id="endDate" value="2024-01-31" required>
                        <small>Project or period end date</small>
                    </div>
                    
                    <div class="form-group" id="daysToAddGroup" style="display: none;">
                        <label for="daysToAdd">Business Days to Add</label>
                        <input type="number" id="daysToAdd" min="1" max="365" value="10">
                        <small>Number of business days to add</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Weekends</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="saturday" checked>
                            <label for="saturday">Exclude Saturdays</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="sunday" checked>
                            <label for="sunday">Exclude Sundays</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="country">Country for Holidays (Optional)</label>
                        <select id="country">
                            <option value="">No holidays</option>
                            <option value="us">United States</option>
                            <option value="uk">United Kingdom</option>
                            <option value="ca">Canada</option>
                            <option value="au">Australia</option>
                            <option value="in">India</option>
                        </select>
                        <small>Select country to exclude public holidays</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="customHolidays">Custom Holidays (Optional)</label>
                        <input type="text" id="customHolidays" placeholder="2024-12-25, 2024-01-01">
                        <small>Add custom holiday dates (comma separated, YYYY-MM-DD)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Business Days</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Business Days Results</h2>
                
                <div class="result-card">
                    <h3 id="resultTitle">Business Days Between Dates</h3>
                    <div class="amount" id="businessDaysDisplay">21 Days</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Business Days</h4>
                        <div class="value" id="businessDays">21</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Days</h4>
                        <div class="value" id="totalDays">31</div>
                    </div>
                    <div class="metric-card">
                        <h4>Weekends</h4>
                        <div class="value" id="weekendDays">10</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Date Range Analysis</h3>
                    <div class="breakdown-item">
                        <span>Start Date</span>
                        <strong id="startDateDisplay">January 1, 2024</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>End Date</span>
                        <strong id="endDateDisplay">January 31, 2024</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Calendar Days</span>
                        <strong id="totalCalendarDays">31 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weekend Days</span>
                        <strong id="weekendDaysBreakdown">10 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Holidays</span>
                        <strong id="holidayDays">0 days</strong>
                    </div>
                    <div class="breakdown-item highlight">
                        <span>Net Business Days</span>
                        <strong id="netBusinessDays">21 days</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Calendar Preview</h3>
                    <div class="calendar-navigation">
                        <button class="calendar-nav-btn" id="prevMonth">← Previous Month</button>
                        <div class="calendar-month-year" id="currentMonthYear">January 2024</div>
                        <button class="calendar-nav-btn" id="nextMonth">Next Month →</button>
                    </div>
                    <div class="calendar-container" id="calendarContainer">
                        <!-- Calendar will be generated here -->
                    </div>
                    <div class="legend">
                        <div class="legend-item">
                            <div class="legend-color legend-business"></div>
                            <span>Business Day</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color legend-weekend"></div>
                            <span>Weekend</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color legend-holiday"></div>
                            <span>Holiday</span>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Key Business Dates</h3>
                    <div class="breakdown-item">
                        <span>First Business Day</span>
                        <strong id="firstBusinessDay">January 2, 2024</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Last Business Day</span>
                        <strong id="lastBusinessDay">January 31, 2024</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Business Weeks</span>
                        <strong id="businessWeeks">4.2 weeks</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Business Hours (8hr/day)</span>
                        <strong id="businessHours">168 hours</strong>
                    </div>
                </div>

                <div class="breakdown" id="addDaysResults" style="display: none;">
                    <h3>Date After Adding Business Days</h3>
                    <div class="breakdown-item">
                        <span>Original Date</span>
                        <strong id="originalDate">January 1, 2024</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Business Days Added</span>
                        <strong id="daysAdded">10 days</strong>
                    </div>
                    <div class="breakdown-item highlight">
                        <span>Result Date</span>
                        <strong id="resultDate">January 15, 2024</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Business Days Note:</strong> Business days typically exclude weekends (Saturday and Sunday) and public holidays. This calculator helps project planning, delivery estimates, and deadline calculations.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📊 Business Days Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate working days for project planning and deadlines</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('businessDaysForm');
        const calculationType = document.getElementById('calculationType');
        const startDateGroup = document.getElementById('startDateGroup');
        const endDateGroup = document.getElementById('endDateGroup');
        const daysToAddGroup = document.getElementById('daysToAddGroup');
        const addDaysResults = document.getElementById('addDaysResults');
        const calendarContainer = document.getElementById('calendarContainer');
        const currentMonthYear = document.getElementById('currentMonthYear');
        const prevMonthBtn = document.getElementById('prevMonth');
        const nextMonthBtn = document.getElementById('nextMonth');

        // Calendar navigation state
        let currentDisplayDate = new Date();
        let currentStartDate = new Date();
        let currentEndDate = new Date();
        let currentHolidays = [];
        let currentExcludeSaturday = true;
        let currentExcludeSunday = true;

        // Set default dates
        const today = new Date();
        document.getElementById('startDate').value = '2024-01-01';
        document.getElementById('endDate').value = today.toISOString().split('T')[0];

        // Holiday data for different countries
        const holidays = {
            us: [
                '2024-01-01', '2024-01-15', '2024-02-19', '2024-05-27', '2024-06-19', 
                '2024-07-04', '2024-09-02', '2024-10-14', '2024-11-11', '2024-11-28', '2024-12-25'
            ],
            uk: [
                '2024-01-01', '2024-03-29', '2024-04-01', '2024-05-06', '2024-05-27', 
                '2024-08-26', '2024-12-25', '2024-12-26'
            ],
            ca: [
                '2024-01-01', '2024-02-19', '2024-03-29', '2024-04-01', '2024-05-20', 
                '2024-07-01', '2024-08-05', '2024-09-02', '2024-10-14', '2024-11-11', '2024-12-25', '2024-12-26'
            ],
            au: [
                '2024-01-01', '2024-01-26', '2024-03-29', '2024-04-01', '2024-04-25', 
                '2024-05-06', '2024-06-10', '2024-12-25', '2024-12-26'
            ],
            in: [
                '2024-01-26', '2024-03-25', '2024-03-29', '2024-04-09', '2024-04-10', 
                '2024-04-14', '2024-05-01', '2024-06-17', '2024-08-15', '2024-09-07', 
                '2024-10-02', '2024-10-12', '2024-10-31', '2024-11-15', '2024-12-25'
            ]
        };

        // Toggle form fields based on calculation type
        calculationType.addEventListener('change', function() {
            if (this.value === 'add') {
                startDateGroup.style.display = 'block';
                endDateGroup.style.display = 'none';
                daysToAddGroup.style.display = 'block';
                addDaysResults.style.display = 'block';
                document.getElementById('resultTitle').textContent = 'Date After Adding Business Days';
            } else {
                startDateGroup.style.display = 'block';
                endDateGroup.style.display = 'block';
                daysToAddGroup.style.display = 'none';
                addDaysResults.style.display = 'none';
                document.getElementById('resultTitle').textContent = 'Business Days Between Dates';
            }
        });

        // Calendar navigation
        prevMonthBtn.addEventListener('click', function() {
            currentDisplayDate.setMonth(currentDisplayDate.getMonth() - 1);
            generateCalendarPreview(currentStartDate, currentEndDate, currentHolidays, currentExcludeSaturday, currentExcludeSunday);
        });

        nextMonthBtn.addEventListener('click', function() {
            currentDisplayDate.setMonth(currentDisplayDate.getMonth() + 1);
            generateCalendarPreview(currentStartDate, currentEndDate, currentHolidays, currentExcludeSaturday, currentExcludeSunday);
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBusinessDays();
        });

        function calculateBusinessDays() {
            const calcType = calculationType.value;
            const startDate = new Date(document.getElementById('startDate').value);
            const excludeSaturday = document.getElementById('saturday').checked;
            const excludeSunday = document.getElementById('sunday').checked;
            const country = document.getElementById('country').value;
            const customHolidaysInput = document.getElementById('customHolidays').value;
            
            // Store current settings for calendar
            currentStartDate = new Date(startDate);
            currentExcludeSaturday = excludeSaturday;
            currentExcludeSunday = excludeSunday;
            
            let businessDaysCount = 0;
            let weekendDaysCount = 0;
            let holidayDaysCount = 0;
            
            if (calcType === 'between') {
                const endDate = new Date(document.getElementById('endDate').value);
                currentEndDate = new Date(endDate);
                
                if (startDate > endDate) {
                    alert('Start date cannot be after end date!');
                    return;
                }
                
                // Get all holidays for the selected country and custom holidays
                const allHolidays = getAllHolidays(startDate, endDate, country, customHolidaysInput);
                currentHolidays = allHolidays;
                holidayDaysCount = allHolidays.length;
                
                // Calculate business days
                const result = calculateBusinessDaysBetween(startDate, endDate, excludeSaturday, excludeSunday, allHolidays);
                businessDaysCount = result.businessDays;
                weekendDaysCount = result.weekendDays;
                
                // Update UI for between dates calculation
                updateBetweenDatesUI(startDate, endDate, businessDaysCount, weekendDaysCount, holidayDaysCount, allHolidays);
                
                // Set current display date to start date
                currentDisplayDate = new Date(startDate);
                generateCalendarPreview(startDate, endDate, allHolidays, excludeSaturday, excludeSunday);
            } else {
                const daysToAdd = parseInt(document.getElementById('daysToAdd').value);
                const resultDate = addBusinessDays(startDate, daysToAdd, excludeSaturday, excludeSunday, country, customHolidaysInput);
                currentEndDate = new Date(resultDate);
                
                // Update UI for add days calculation
                updateAddDaysUI(startDate, daysToAdd, resultDate);
                
                // Set current display date to start date
                currentDisplayDate = new Date(startDate);
                generateCalendarPreview(startDate, resultDate, getAllHolidays(startDate, resultDate, country, customHolidaysInput), excludeSaturday, excludeSunday);
            }
        }

        function getAllHolidays(startDate, endDate, country, customHolidaysInput) {
            let allHolidays = [];
            
            // Add country holidays
            if (country && holidays[country]) {
                allHolidays = [...holidays[country]];
            }
            
            // Add custom holidays
            if (customHolidaysInput) {
                const customHolidays = customHolidaysInput.split(',').map(date => date.trim()).filter(date => date);
                allHolidays = [...allHolidays, ...customHolidays];
            }
            
            // Filter holidays within date range and normalize dates
            return allHolidays.filter(holiday => {
                try {
                    // Create date in local timezone to avoid timezone issues
                    const holidayDate = createLocalDate(holiday);
                    const normalizedHoliday = formatDateForComparison(holidayDate);
                    const normalizedStart = formatDateForComparison(startDate);
                    const normalizedEnd = formatDateForComparison(endDate);
                    
                    return normalizedHoliday >= normalizedStart && normalizedHoliday <= normalizedEnd;
                } catch (e) {
                    console.error('Invalid holiday date:', holiday);
                    return false;
                }
            });
        }

        function createLocalDate(dateString) {
            const parts = dateString.split('-');
            if (parts.length !== 3) {
                throw new Error('Invalid date format');
            }
            // Create date in local timezone (no timezone offset issues)
            return new Date(parts[0], parts[1] - 1, parts[2]);
        }

        function formatDateForComparison(date) {
            // Format date as YYYY-MM-DD for consistent comparison
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function calculateBusinessDaysBetween(startDate, endDate, excludeSaturday, excludeSunday, holidays) {
            let businessDays = 0;
            let weekendDays = 0;
            const currentDate = new Date(startDate);
            
            while (currentDate <= endDate) {
                const dayOfWeek = currentDate.getDay();
                const dateString = formatDateForComparison(currentDate);
                
                // Check if it's a weekend
                const isSaturday = dayOfWeek === 6;
                const isSunday = dayOfWeek === 0;
                
                if ((isSaturday && excludeSaturday) || (isSunday && excludeSunday)) {
                    weekendDays++;
                } else if (holidays.includes(dateString)) {
                    // It's a holiday
                    weekendDays++;
                } else {
                    businessDays++;
                }
                
                currentDate.setDate(currentDate.getDate() + 1);
            }
            
            return { businessDays, weekendDays };
        }

        function addBusinessDays(startDate, daysToAdd, excludeSaturday, excludeSunday, country, customHolidaysInput) {
            let currentDate = new Date(startDate);
            let businessDaysAdded = 0;
            
            while (businessDaysAdded < daysToAdd) {
                currentDate.setDate(currentDate.getDate() + 1);
                const dayOfWeek = currentDate.getDay();
                const dateString = formatDateForComparison(currentDate);
                
                // Check if it's a business day
                const isSaturday = dayOfWeek === 6;
                const isSunday = dayOfWeek === 0;
                let isHoliday = false;
                
                // Check if it's a holiday using consistent date comparison
                const allHolidays = getAllHolidays(startDate, currentDate, country, customHolidaysInput);
                if (allHolidays.includes(dateString)) {
                    isHoliday = true;
                }
                
                if (!((isSaturday && excludeSaturday) || (isSunday && excludeSunday) || isHoliday)) {
                    businessDaysAdded++;
                }
            }
            
            return currentDate;
        }

        function updateBetweenDatesUI(startDate, endDate, businessDays, weekendDays, holidayDays, holidaysList) {
            const totalDays = Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
            
            document.getElementById('businessDaysDisplay').textContent = businessDays + ' Days';
            document.getElementById('businessDays').textContent = businessDays;
            document.getElementById('totalDays').textContent = totalDays;
            document.getElementById('weekendDays').textContent = weekendDays;
            
            document.getElementById('startDateDisplay').textContent = formatDateDisplay(startDate);
            document.getElementById('endDateDisplay').textContent = formatDateDisplay(endDate);
            document.getElementById('totalCalendarDays').textContent = totalDays + ' days';
            document.getElementById('weekendDaysBreakdown').textContent = weekendDays + ' days';
            document.getElementById('holidayDays').textContent = holidayDays + ' days';
            document.getElementById('netBusinessDays').textContent = businessDays + ' days';
            
            document.getElementById('firstBusinessDay').textContent = formatDateDisplay(startDate);
            document.getElementById('lastBusinessDay').textContent = formatDateDisplay(endDate);
            document.getElementById('businessWeeks').textContent = (businessDays / 5).toFixed(1) + ' weeks';
            document.getElementById('businessHours').textContent = (businessDays * 8) + ' hours';
        }

        function updateAddDaysUI(startDate, daysToAdd, resultDate) {
            document.getElementById('businessDaysDisplay').textContent = formatDateDisplay(resultDate);
            document.getElementById('originalDate').textContent = formatDateDisplay(startDate);
            document.getElementById('daysAdded').textContent = daysToAdd + ' days';
            document.getElementById('resultDate').textContent = formatDateDisplay(resultDate);
        }

        function generateCalendarPreview(startDate, endDate, holidaysList, excludeSaturday, excludeSunday) {
            const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            const today = new Date();
            
            // Update current month year display
            currentMonthYear.textContent = currentDisplayDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            
            // Calculate which months to display
            const displayMonths = [];
            const startMonth = new Date(currentDisplayDate.getFullYear(), currentDisplayDate.getMonth(), 1);
            const endMonth = new Date(currentDisplayDate.getFullYear(), currentDisplayDate.getMonth() + 1, 0);
            
            displayMonths.push({
                date: new Date(startMonth),
                start: startMonth,
                end: endMonth
            });
            
            // Add next month if we have space
            const nextMonth = new Date(currentDisplayDate.getFullYear(), currentDisplayDate.getMonth() + 1, 1);
            const nextMonthEnd = new Date(currentDisplayDate.getFullYear(), currentDisplayDate.getMonth() + 2, 0);
            
            if (nextMonth <= endDate) {
                displayMonths.push({
                    date: new Date(nextMonth),
                    start: nextMonth,
                    end: nextMonthEnd
                });
            }
            
            let calendarHTML = '';
            
            displayMonths.forEach(month => {
                calendarHTML += `<div class="month-calendar">`;
                calendarHTML += `<h4>${month.date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}</h4>`;
                
                // Add day headers
                calendarHTML += `<div class="calendar-grid">`;
                daysOfWeek.forEach(day => {
                    calendarHTML += `<div class="calendar-day header">${day}</div>`;
                });
                
                const firstDayOfMonth = new Date(month.date.getFullYear(), month.date.getMonth(), 1);
                const lastDayOfMonth = new Date(month.date.getFullYear(), month.date.getMonth() + 1, 0);
                const startingDayOfWeek = firstDayOfMonth.getDay();
                
                // Add empty cells for days before the start of the month
                for (let i = 0; i < startingDayOfWeek; i++) {
                    calendarHTML += '<div class="calendar-day outside-range"></div>';
                }
                
                // Add days of the month
                for (let day = 1; day <= lastDayOfMonth.getDate(); day++) {
                    const currentDate = new Date(month.date.getFullYear(), month.date.getMonth(), day);
                    const dateString = formatDateForComparison(currentDate);
                    const dayOfWeek = currentDate.getDay();
                    
                    let dayClass = 'calendar-day';
                    let isInRange = currentDate >= startDate && currentDate <= endDate;
                    let isToday = formatDateForComparison(currentDate) === formatDateForComparison(today);
                    
                    if (isToday) {
                        dayClass += ' today';
                    }
                    
                    if (!isInRange) {
                        dayClass += ' outside-range';
                    } else {
                        const isSaturday = dayOfWeek === 6;
                        const isSunday = dayOfWeek === 0;
                        const isHoliday = holidaysList.includes(dateString);
                        
                        if ((isSaturday && excludeSaturday) || (isSunday && excludeSunday)) {
                            dayClass += ' weekend';
                        } else if (isHoliday) {
                            dayClass += ' holiday';
                        } else {
                            dayClass += ' business';
                        }
                    }
                    
                    calendarHTML += `<div class="${dayClass}">${day}</div>`;
                }
                
                calendarHTML += `</div></div>`;
            });
            
            calendarContainer.innerHTML = calendarHTML;
            
            // Update navigation buttons state
            prevMonthBtn.disabled = false;
            nextMonthBtn.disabled = false;
            
            // Check if we can navigate to previous month
            const prevMonth = new Date(currentDisplayDate.getFullYear(), currentDisplayDate.getMonth() - 1, 1);
            if (prevMonth < new Date(startDate.getFullYear(), startDate.getMonth(), 1)) {
                prevMonthBtn.disabled = true;
            }
            
            // Check if we can navigate to next month
            const nextNextMonth = new Date(currentDisplayDate.getFullYear(), currentDisplayDate.getMonth() + 2, 1);
            if (nextNextMonth > new Date(endDate.getFullYear(), endDate.getMonth() + 1, 1)) {
                nextMonthBtn.disabled = true;
            }
        }

        function formatDateDisplay(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        window.addEventListener('load', function() {
            calculateBusinessDays();
        });
    </script>
</body>
</html>