<?php
/**
 * Time Duration Calculator
 * File: date-time/time-duration-calculator.php
 * Description: Calculate duration between two times or dates with detailed breakdown
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Duration Calculator - Calculate Time Between Two Dates or Times</title>
    <meta name="description" content="Free time duration calculator. Calculate exact duration between two times or dates with detailed breakdown in multiple units.">
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
        
        .time-input-group {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 10px;
            align-items: center;
        }
        
        .time-separator {
            text-align: center;
            font-weight: bold;
            color: #667eea;
            font-size: 1.2rem;
        }
        
        .datetime-input-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            align-items: center;
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
            grid-template-columns: repeat(3, 1fr); 
            gap: 12px; 
            margin-bottom: 18px; 
        }
        @media (max-width: 768px) {
            .metric-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 480px) {
            .metric-grid {
                grid-template-columns: 1fr;
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
        
        .time-visualization {
            margin: 20px 0;
            padding: 20px;
            background: white;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
        }
        
        .timeline {
            position: relative;
            height: 60px;
            background: #f0f0f0;
            border-radius: 30px;
            margin: 20px 0;
            overflow: hidden;
        }
        
        .timeline-segment {
            position: absolute;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 30px;
        }
        
        .timeline-marker {
            position: absolute;
            top: -5px;
            width: 3px;
            height: 70px;
            background: #333;
        }
        
        .timeline-marker.start::after {
            content: 'Start';
            position: absolute;
            top: -25px;
            left: -15px;
            font-size: 0.8rem;
            color: #666;
            white-space: nowrap;
        }
        
        .timeline-marker.end::after {
            content: 'End';
            position: absolute;
            top: -25px;
            right: -15px;
            font-size: 0.8rem;
            color: #666;
            white-space: nowrap;
        }
        
        .timeline-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 0.9rem;
            color: #666;
        }
        
        .comparison-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 20px 0;
        }
        
        @media (max-width: 768px) {
            .comparison-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .comparison-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            text-align: center;
        }
        
        .comparison-card h4 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
        
        .comparison-card .value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
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
        input[type="datetime-local"], input[type="time"], input[type="date"], input[type="number"], select {
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
            
            .time-input-group,
            .datetime-input-group {
                grid-template-columns: 1fr;
                gap: 5px;
            }
            
            .time-separator {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⏱️ Time Duration Calculator</h1>
            <p>Calculate exact duration between two times or dates with detailed breakdown</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Time Range</h2>
                <form id="durationForm">
                    <div class="form-group">
                        <label for="calculationType">Calculation Type</label>
                        <select id="calculationType">
                            <option value="time">Time Only (Same Day)</option>
                            <option value="datetime">Date & Time</option>
                            <option value="dates">Dates Only</option>
                        </select>
                        <small>Choose what type of duration to calculate</small>
                    </div>
                    
                    <div class="form-group" id="dateTimeGroup">
                        <label>Start Date & Time</label>
                        <div class="datetime-input-group">
                            <input type="date" id="startDate" value="2024-01-15" required>
                            <input type="time" id="startTime" value="09:00" required>
                        </div>
                        <small>Beginning of the time period</small>
                    </div>
                    
                    <div class="form-group" id="endDateTimeGroup">
                        <label>End Date & Time</label>
                        <div class="datetime-input-group">
                            <input type="date" id="endDate" value="2024-01-15" required>
                            <input type="time" id="endTime" value="17:00" required>
                        </div>
                        <small>End of the time period</small>
                    </div>
                    
                    <div class="form-group" id="timeOnlyGroup" style="display: none;">
                        <label>Time Range</label>
                        <div class="time-input-group">
                            <input type="time" id="timeOnlyStart" value="09:00" required>
                            <div class="time-separator">to</div>
                            <input type="time" id="timeOnlyEnd" value="17:00" required>
                        </div>
                        <small>Start and end time on the same day</small>
                    </div>
                    
                    <div class="form-group" id="datesOnlyGroup" style="display: none;">
                        <label>Date Range</label>
                        <div class="time-input-group">
                            <input type="date" id="dateOnlyStart" value="2024-01-15" required>
                            <div class="time-separator">to</div>
                            <input type="date" id="dateOnlyEnd" value="2024-01-16" required>
                        </div>
                        <small>Start and end dates only</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Calculation Options</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="excludeWeekends" checked>
                            <label for="excludeWeekends">Exclude weekends from calculation</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="businessHours">
                            <label for="businessHours">Calculate business hours only (9AM-5PM)</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="includeSeconds">
                            <label for="includeSeconds">Include seconds in breakdown</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="timezone">Timezone</label>
                        <select id="timezone">
                            <option value="local">Local Time</option>
                            <option value="utc">UTC</option>
                            <option value="est">EST (Eastern)</option>
                            <option value="pst">PST (Pacific)</option>
                            <option value="cst">CST (Central)</option>
                            <option value="mst">MST (Mountain)</option>
                            <option value="gmt">GMT</option>
                            <option value="cet">CET (Central European)</option>
                            <option value="aest">AEST (Australian Eastern)</option>
                        </select>
                        <small>Timezone for time calculations</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Duration</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Duration Results</h2>
                
                <div class="result-card">
                    <h3>Total Duration</h3>
                    <div class="amount" id="totalDuration">8 hours</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Days</h4>
                        <div class="value" id="daysValue">0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Hours</h4>
                        <div class="value" id="hoursValue">8</div>
                    </div>
                    <div class="metric-card">
                        <h4>Minutes</h4>
                        <div class="value" id="minutesValue">0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Seconds</h4>
                        <div class="value" id="secondsValue">0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Weeks</h4>
                        <div class="value" id="weeksValue">0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Months</h4>
                        <div class="value" id="monthsValue">0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Detailed Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Total Duration</span>
                        <strong id="detailedDuration">8 hours 0 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>In Seconds</span>
                        <strong id="totalSeconds">28,800 seconds</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>In Minutes</span>
                        <strong id="totalMinutes">480 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>In Hours</span>
                        <strong id="totalHours">8.00 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>In Days</span>
                        <strong id="totalDays">0.33 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>In Weeks</span>
                        <strong id="totalWeeks">0.05 weeks</strong>
                    </div>
                    <div class="breakdown-item highlight">
                        <span>Business Days</span>
                        <strong id="businessDays">1 day</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Time Visualization</h3>
                    <div class="time-visualization">
                        <div class="timeline" id="timeline">
                            <div class="timeline-marker start" style="left: 0%;"></div>
                            <div class="timeline-marker end" style="left: 100%;"></div>
                            <div class="timeline-segment" style="width: 100%; left: 0%;"></div>
                        </div>
                        <div class="timeline-labels">
                            <span id="timelineStartLabel">9:00 AM</span>
                            <span id="timelineEndLabel">5:00 PM</span>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Date Information</h3>
                    <div class="breakdown-item">
                        <span>Start Date & Time</span>
                        <strong id="startDateTimeDisplay">Jan 15, 2024 9:00 AM</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>End Date & Time</span>
                        <strong id="endDateTimeDisplay">Jan 15, 2024 5:00 PM</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Day of Week Started</span>
                        <strong id="startDayOfWeek">Monday</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Day of Week Ended</span>
                        <strong id="endDayOfWeek">Monday</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Timezone</span>
                        <strong id="timezoneDisplay">Local Time</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Comparison</h3>
                    <div class="comparison-grid">
                        <div class="comparison-card">
                            <h4>Percentage of Day</h4>
                            <div class="value" id="dayPercentage">33%</div>
                        </div>
                        <div class="comparison-card">
                            <h4>Percentage of Week</h4>
                            <div class="value" id="weekPercentage">5%</div>
                        </div>
                        <div class="comparison-card">
                            <h4>Equivalent Work Days</h4>
                            <div class="value" id="workDaysEquivalent">1.0</div>
                        </div>
                        <div class="comparison-card">
                            <h4>Sleep Time Equivalent</h4>
                            <div class="value" id="sleepEquivalent">1.0 night</div>
                        </div>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Duration Calculation Tip:</strong> This calculator accounts for timezone differences, daylight saving time, and can exclude weekends for business-day calculations. Use it for project planning, work hours tracking, or any time-based measurement needs.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⏱️ Time Duration Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Accurate time calculations for any purpose</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('durationForm');
        const calculationType = document.getElementById('calculationType');
        const dateTimeGroup = document.getElementById('dateTimeGroup');
        const endDateTimeGroup = document.getElementById('endDateTimeGroup');
        const timeOnlyGroup = document.getElementById('timeOnlyGroup');
        const datesOnlyGroup = document.getElementById('datesOnlyGroup');

        // Set default dates to today
        const today = new Date();
        const todayStr = today.toISOString().split('T')[0];
        document.getElementById('startDate').value = todayStr;
        document.getElementById('endDate').value = todayStr;
        document.getElementById('dateOnlyStart').value = todayStr;
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        document.getElementById('dateOnlyEnd').value = tomorrow.toISOString().split('T')[0];

        // Timezone offsets in hours
        const timezoneOffsets = {
            local: 0,
            utc: 0,
            est: -5,
            pst: -8,
            cst: -6,
            mst: -7,
            gmt: 0,
            cet: 1,
            aest: 10
        };

        // Event listeners
        calculationType.addEventListener('change', function() {
            const type = this.value;
            
            // Hide all groups first
            dateTimeGroup.style.display = 'none';
            endDateTimeGroup.style.display = 'none';
            timeOnlyGroup.style.display = 'none';
            datesOnlyGroup.style.display = 'none';
            
            // Show relevant groups
            if (type === 'time') {
                timeOnlyGroup.style.display = 'block';
            } else if (type === 'datetime') {
                dateTimeGroup.style.display = 'block';
                endDateTimeGroup.style.display = 'block';
            } else if (type === 'dates') {
                datesOnlyGroup.style.display = 'block';
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateDuration();
        });

        function calculateDuration() {
            const type = calculationType.value;
            const excludeWeekends = document.getElementById('excludeWeekends').checked;
            const businessHours = document.getElementById('businessHours').checked;
            const includeSeconds = document.getElementById('includeSeconds').checked;
            const timezone = document.getElementById('timezone').value;
            
            let startDateTime, endDateTime;

            // Get dates/times based on calculation type
            if (type === 'time') {
                const startTime = document.getElementById('timeOnlyStart').value;
                const endTime = document.getElementById('timeOnlyEnd').value;
                startDateTime = new Date(`${todayStr}T${startTime}`);
                endDateTime = new Date(`${todayStr}T${endTime}`);
                
                // Handle overnight time ranges
                if (endDateTime < startDateTime) {
                    endDateTime.setDate(endDateTime.getDate() + 1);
                }
            } else if (type === 'datetime') {
                const startDate = document.getElementById('startDate').value;
                const startTime = document.getElementById('startTime').value;
                const endDate = document.getElementById('endDate').value;
                const endTime = document.getElementById('endTime').value;
                startDateTime = new Date(`${startDate}T${startTime}`);
                endDateTime = new Date(`${endDate}T${endTime}`);
            } else if (type === 'dates') {
                const startDate = document.getElementById('dateOnlyStart').value;
                const endDate = document.getElementById('dateOnlyEnd').value;
                startDateTime = new Date(`${startDate}T00:00:00`);
                endDateTime = new Date(`${endDate}T23:59:59`);
            }

            // Apply timezone offset
            const offset = timezoneOffsets[timezone] * 60 * 60 * 1000;
            startDateTime = new Date(startDateTime.getTime() + offset);
            endDateTime = new Date(endDateTime.getTime() + offset);

            // Calculate total duration in milliseconds
            let totalMs = endDateTime - startDateTime;

            // Adjust for business hours if enabled
            if (businessHours) {
                totalMs = calculateBusinessHours(startDateTime, endDateTime, excludeWeekends);
            } else if (excludeWeekends) {
                totalMs = excludeWeekendTime(startDateTime, endDateTime);
            }

            // Calculate various time units
            const totalSeconds = Math.floor(totalMs / 1000);
            const totalMinutes = Math.floor(totalSeconds / 60);
            const totalHours = totalMinutes / 60;
            const totalDays = totalHours / 24;
            const totalWeeks = totalDays / 7;

            const days = Math.floor(totalDays);
            const hours = Math.floor(totalHours % 24);
            const minutes = Math.floor(totalMinutes % 60);
            const seconds = totalSeconds % 60;
            const weeks = Math.floor(totalWeeks);
            const months = totalDays / 30.44; // Average month length

            // Calculate business days
            const businessDaysCount = calculateBusinessDays(startDateTime, endDateTime, excludeWeekends);

            // Update UI
            updateDurationResults(
                startDateTime,
                endDateTime,
                days,
                hours,
                minutes,
                seconds,
                weeks,
                months,
                totalSeconds,
                totalMinutes,
                totalHours,
                totalDays,
                totalWeeks,
                businessDaysCount,
                timezone,
                includeSeconds
            );

            // Update timeline
            updateTimeline(startDateTime, endDateTime);
        }

        function calculateBusinessHours(start, end, excludeWeekends) {
            let businessMs = 0;
            const current = new Date(start);
            const businessStart = 9; // 9 AM
            const businessEnd = 17; // 5 PM

            while (current < end) {
                const dayOfWeek = current.getDay();
                const isWeekend = excludeWeekends && (dayOfWeek === 0 || dayOfWeek === 6);
                
                if (!isWeekend) {
                    const dayStart = new Date(current);
                    dayStart.setHours(businessStart, 0, 0, 0);
                    const dayEnd = new Date(current);
                    dayEnd.setHours(businessEnd, 0, 0, 0);

                    const segmentStart = current > dayStart ? current : dayStart;
                    const segmentEnd = end < dayEnd ? end : dayEnd;

                    if (segmentStart < segmentEnd) {
                        businessMs += segmentEnd - segmentStart;
                    }
                }

                // Move to next day
                current.setDate(current.getDate() + 1);
                current.setHours(businessStart, 0, 0, 0);
            }

            return businessMs;
        }

        function excludeWeekendTime(start, end) {
            let totalMs = end - start;
            const current = new Date(start);
            
            while (current < end) {
                const dayOfWeek = current.getDay();
                if (dayOfWeek === 0 || dayOfWeek === 6) { // Sunday or Saturday
                    const dayStart = new Date(current);
                    dayStart.setHours(0, 0, 0, 0);
                    const dayEnd = new Date(current);
                    dayEnd.setHours(23, 59, 59, 999);
                    
                    const removeStart = start > dayStart ? start : dayStart;
                    const removeEnd = end < dayEnd ? end : dayEnd;
                    
                    totalMs -= (removeEnd - removeStart);
                }
                current.setDate(current.getDate() + 1);
            }
            
            return totalMs;
        }

        function calculateBusinessDays(start, end, excludeWeekends) {
            let businessDays = 0;
            const current = new Date(start);
            current.setHours(0, 0, 0, 0);
            const endDate = new Date(end);
            endDate.setHours(0, 0, 0, 0);

            while (current <= endDate) {
                const dayOfWeek = current.getDay();
                if (!excludeWeekends || (dayOfWeek !== 0 && dayOfWeek !== 6)) {
                    businessDays++;
                }
                current.setDate(current.getDate() + 1);
            }

            return businessDays;
        }

        function updateDurationResults(
            start, end, days, hours, minutes, seconds, weeks, months,
            totalSeconds, totalMinutes, totalHours, totalDays, totalWeeks,
            businessDays, timezone, includeSeconds
        ) {
            // Format main duration
            let durationText = '';
            if (days > 0) durationText += `${days} day${days !== 1 ? 's' : ''} `;
            if (hours > 0) durationText += `${hours} hour${hours !== 1 ? 's' : ''} `;
            if (minutes > 0) durationText += `${minutes} minute${minutes !== 1 ? 's' : ''}`;
            if (durationText === '') durationText = 'Less than 1 minute';

            document.getElementById('totalDuration').textContent = durationText.trim();

            // Update metric cards
            document.getElementById('daysValue').textContent = days;
            document.getElementById('hoursValue').textContent = hours;
            document.getElementById('minutesValue').textContent = minutes;
            document.getElementById('secondsValue').textContent = seconds;
            document.getElementById('weeksValue').textContent = weeks;
            document.getElementById('monthsValue').textContent = months.toFixed(1);

            // Update detailed breakdown
            let detailedText = '';
            if (days > 0) detailedText += `${days} day${days !== 1 ? 's' : ''} `;
            detailedText += `${hours} hour${hours !== 1 ? 's' : ''} ${minutes} minute${minutes !== 1 ? 's' : ''}`;
            if (includeSeconds) detailedText += ` ${seconds} second${seconds !== 1 ? 's' : ''}`;

            document.getElementById('detailedDuration').textContent = detailedText.trim();
            document.getElementById('totalSeconds').textContent = totalSeconds.toLocaleString() + ' seconds';
            document.getElementById('totalMinutes').textContent = totalMinutes.toLocaleString() + ' minutes';
            document.getElementById('totalHours').textContent = totalHours.toFixed(2) + ' hours';
            document.getElementById('totalDays').textContent = totalDays.toFixed(2) + ' days';
            document.getElementById('totalWeeks').textContent = totalWeeks.toFixed(2) + ' weeks';
            document.getElementById('businessDays').textContent = businessDays + ' day' + (businessDays !== 1 ? 's' : '');

            // Update date information
            document.getElementById('startDateTimeDisplay').textContent = formatDateTime(start);
            document.getElementById('endDateTimeDisplay').textContent = formatDateTime(end);
            document.getElementById('startDayOfWeek').textContent = getDayOfWeek(start);
            document.getElementById('endDayOfWeek').textContent = getDayOfWeek(end);
            document.getElementById('timezoneDisplay').textContent = document.getElementById('timezone').options[document.getElementById('timezone').selectedIndex].text;

            // Update comparisons
            const dayPercentage = (totalHours / 24) * 100;
            const weekPercentage = (totalHours / (24 * 7)) * 100;
            const workDaysEquivalent = totalHours / 8; // 8-hour work day
            const sleepEquivalent = totalHours / 8; // 8-hour sleep

            document.getElementById('dayPercentage').textContent = dayPercentage.toFixed(0) + '%';
            document.getElementById('weekPercentage').textContent = weekPercentage.toFixed(0) + '%';
            document.getElementById('workDaysEquivalent').textContent = workDaysEquivalent.toFixed(1);
            document.getElementById('sleepEquivalent').textContent = sleepEquivalent.toFixed(1) + ' night' + (sleepEquivalent !== 1 ? 's' : '');
        }

        function updateTimeline(start, end) {
            const timeline = document.getElementById('timeline');
            const startLabel = document.getElementById('timelineStartLabel');
            const endLabel = document.getElementById('timelineEndLabel');

            // Clear existing segments
            timeline.innerHTML = '';

            // Add markers
            const startMarker = document.createElement('div');
            startMarker.className = 'timeline-marker start';
            startMarker.style.left = '0%';
            timeline.appendChild(startMarker);

            const endMarker = document.createElement('div');
            endMarker.className = 'timeline-marker end';
            endMarker.style.left = '100%';
            timeline.appendChild(endMarker);

            // Add main segment
            const segment = document.createElement('div');
            segment.className = 'timeline-segment';
            segment.style.width = '100%';
            segment.style.left = '0%';
            timeline.appendChild(segment);

            // Update labels
            startLabel.textContent = formatTime(start);
            endLabel.textContent = formatTime(end);
        }

        function formatDateTime(date) {
            const options = { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric',
                hour: '2-digit', 
                minute: '2-digit'
            };
            return date.toLocaleDateString('en-US', options);
        }

        function formatTime(date) {
            const options = { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: true 
            };
            return date.toLocaleTimeString('en-US', options);
        }

        function getDayOfWeek(date) {
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            return days[date.getDay()];
        }

        // Initialize form
        window.addEventListener('load', function() {
            // Trigger the change event to set initial visibility
            calculationType.dispatchEvent(new Event('change'));
            calculateDuration();
        });
    </script>
</body>
</html>