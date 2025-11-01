<?php
/**
 * Working Hours Calculator
 * File: date-time/working-hours-calculator.php
 * Description: Calculate total working hours, weekly summaries, and overtime for multiple days
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Working Hours Calculator - Track Weekly Hours & Overtime</title>
    <meta name="description" content="Free working hours calculator. Calculate total work hours, weekly summaries, overtime, and earnings for multiple days.">
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
        
        .currency-rate-group {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 10px;
            align-items: end;
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
        
        .days-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border: 2px solid #e0e0e0;
        }
        
        .day-row {
            display: grid;
            grid-template-columns: 100px 1fr 1fr auto;
            gap: 10px;
            align-items: center;
            margin-bottom: 12px;
            padding: 10px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .day-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .day-checkbox input {
            transform: scale(1.2);
        }
        
        .day-checkbox label {
            font-weight: 600;
            color: #555;
            margin: 0;
        }
        
        .remove-day {
            background: #ff6b6b;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .add-day-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            margin-top: 10px;
            width: 100%;
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
        
        .weekly-summary {
            margin: 20px 0;
        }
        
        .day-summary {
            display: grid;
            grid-template-columns: 100px 1fr 1fr 1fr;
            gap: 10px;
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
            align-items: center;
        }
        
        .day-summary:last-child {
            border-bottom: none;
        }
        
        .day-summary-header {
            font-weight: bold;
            background: #f0f0f0;
            border-radius: 5px;
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
        
        .currency-symbol {
            font-size: 0.8em;
            opacity: 0.9;
            margin-right: 2px;
        }
        
        .money-amount {
            display: flex;
            align-items: center;
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
        input[type="time"], input[type="number"], input[type="text"], select {
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
            
            .time-input-group {
                grid-template-columns: 1fr;
                gap: 5px;
            }
            
            .time-separator {
                display: none;
            }
            
            .currency-rate-group {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .day-row {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            
            .day-summary {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 5px;
            }
            
            .day-summary-header {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📅 Working Hours Calculator</h1>
            <p>Calculate total work hours, weekly summaries, and overtime for multiple days</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Work Schedule</h2>
                <form id="workingHoursForm">
                    <div class="form-group">
                        <label>Currency & Rate</label>
                        <div class="currency-rate-group">
                            <div>
                                <label for="currency">Currency</label>
                                <select id="currency">
                                    <option value="USD">USD ($)</option>
                                    <option value="EUR">EUR (€)</option>
                                    <option value="GBP">GBP (£)</option>
                                    <option value="JPY">JPY (¥)</option>
                                    <option value="CAD">CAD (C$)</option>
                                    <option value="AUD">AUD (A$)</option>
                                    <option value="INR">INR (₹)</option>
                                    <option value="CNY">CNY (¥)</option>
                                    <option value="BRL">BRL (R$)</option>
                                    <option value="RUB">RUB (₽)</option>
                                </select>
                            </div>
                            <div>
                                <label for="hourlyRate">Hourly Rate</label>
                                <input type="number" id="hourlyRate" min="0" step="0.01" value="25.00" required>
                            </div>
                        </div>
                        <small>Select currency and enter your hourly wage rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Work Week Settings</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="overtimeEnabled" checked>
                            <label for="overtimeEnabled">Include overtime calculation</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="breaksEnabled" checked>
                            <label for="breaksEnabled">Include break deductions</label>
                        </div>
                    </div>
                    
                    <div class="form-group" id="overtimeSettings">
                        <label for="weeklyThreshold">Weekly Overtime Threshold (hours)</label>
                        <input type="number" id="weeklyThreshold" min="0" max="80" value="40" step="0.5">
                        <small>Hours worked per week before overtime applies</small>
                        
                        <label for="overtimeRate" style="margin-top: 15px;">Overtime Rate Multiplier</label>
                        <input type="number" id="overtimeRate" min="1" max="3" step="0.1" value="1.5">
                        <small>Typically 1.5x normal rate</small>
                    </div>
                    
                    <div class="form-group" id="breakSettings">
                        <label for="breakDuration">Default Break Duration (minutes)</label>
                        <input type="number" id="breakDuration" min="0" max="180" value="30">
                        <small>Standard break time to deduct from each shift</small>
                    </div>

                    <div class="days-container">
                        <h4 style="margin-bottom: 15px; color: #667eea;">Work Days</h4>
                        <div id="daysContainer">
                            <!-- Days will be generated here -->
                        </div>
                        <button type="button" class="add-day-btn" onclick="addDay()">+ Add Another Day</button>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Working Hours</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Weekly Summary</h2>
                
                <div class="result-card">
                    <h3>Total Weekly Earnings</h3>
                    <div class="amount">
                        <span class="money-amount">
                            <span class="currency-symbol" id="totalCurrencySymbol">$</span>
                            <span id="totalEarnings">1,000.00</span>
                        </span>
                    </div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Hours</h4>
                        <div class="value" id="totalHours">40.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Regular Hours</h4>
                        <div class="value" id="regularHours">40.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Overtime Hours</h4>
                        <div class="value" id="overtimeHours">0.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Break Time</h4>
                        <div class="value" id="breakTime">2.5</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Weekly Breakdown</h3>
                    <div class="progress-container">
                        <div class="progress-bar" id="weeklyProgress" style="width: 50%">50% Complete</div>
                    </div>
                    <div class="breakdown-item">
                        <span>Work Days</span>
                        <strong id="workDays">5 days</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Paid Hours</span>
                        <strong id="totalPaidHours">37.5 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Overtime Threshold</span>
                        <strong id="overtimeThresholdDisplay">40.0 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Daily Hours</span>
                        <strong id="averageDailyHours">7.5 hours/day</strong>
                    </div>
                    <div class="breakdown-item highlight">
                        <span>Weekly Efficiency</span>
                        <strong id="weeklyEfficiency">93.8%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Daily Summary</h3>
                    <div class="weekly-summary">
                        <div class="day-summary day-summary-header">
                            <div>Day</div>
                            <div>Hours</div>
                            <div>Break</div>
                            <div>Earnings</div>
                        </div>
                        <div id="dailySummary">
                            <!-- Daily summaries will be generated here -->
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Earnings Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Regular Pay</span>
                        <strong class="money-amount">
                            <span class="currency-symbol" id="regularPaySymbol">$</span>
                            <span id="regularPay">1,000.00</span>
                        </strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Overtime Pay</span>
                        <strong class="money-amount">
                            <span class="currency-symbol" id="overtimePaySymbol">$</span>
                            <span id="overtimePay">0.00</span>
                        </strong>
                    </div>
                    <div class="breakdown-item highlight">
                        <span>Total Weekly Earnings</span>
                        <strong class="money-amount">
                            <span class="currency-symbol" id="totalWeeklySymbol">$</span>
                            <span id="totalWeeklyEarnings">1,000.00</span>
                        </strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated Monthly (4 weeks)</span>
                        <strong class="money-amount">
                            <span class="currency-symbol" id="monthlySymbol">$</span>
                            <span id="monthlyEarnings">4,000.00</span>
                        </strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated Annual (52 weeks)</span>
                        <strong class="money-amount">
                            <span class="currency-symbol" id="annualSymbol">$</span>
                            <span id="annualEarnings">52,000.00</span>
                        </strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Work Schedule Summary</h3>
                    <div class="breakdown-item">
                        <span>Currency</span>
                        <strong id="currencyDisplay">USD ($)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Hourly Rate</span>
                        <strong class="money-amount">
                            <span class="currency-symbol" id="hourlyRateSymbol">$</span>
                            <span id="hourlyRateValue">25.00</span>/hour
                        </strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Overtime Rate</span>
                        <strong class="money-amount">
                            <span class="currency-symbol" id="overtimeRateSymbol">$</span>
                            <span id="overtimeRateValue">37.50</span>/hour (1.5x)
                        </strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Standard Break</span>
                        <strong id="standardBreakDisplay">30 minutes</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Working Hours Tip:</strong> Tracking your weekly hours helps identify patterns and optimize your schedule. Regular breaks improve productivity and prevent burnout.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📅 Working Hours Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Track and optimize your weekly work schedule</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('workingHoursForm');
        const overtimeEnabled = document.getElementById('overtimeEnabled');
        const breaksEnabled = document.getElementById('breaksEnabled');
        const overtimeSettings = document.getElementById('overtimeSettings');
        const breakSettings = document.getElementById('breakSettings');
        const daysContainer = document.getElementById('daysContainer');
        const currencySelect = document.getElementById('currency');

        // Currency data with symbols
        const currencyData = {
            USD: { symbol: '$', name: 'US Dollar' },
            EUR: { symbol: '€', name: 'Euro' },
            GBP: { symbol: '£', name: 'British Pound' },
            JPY: { symbol: '¥', name: 'Japanese Yen' },
            CAD: { symbol: 'C$', name: 'Canadian Dollar' },
            AUD: { symbol: 'A$', name: 'Australian Dollar' },
            INR: { symbol: '₹', name: 'Indian Rupee' },
            CNY: { symbol: '¥', name: 'Chinese Yuan' },
            BRL: { symbol: 'R$', name: 'Brazilian Real' },
            RUB: { symbol: '₽', name: 'Russian Ruble' }
        };

        // Days of the week
        const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Initialize with default days
        function initializeDays() {
            // Add first 5 weekdays by default
            for (let i = 0; i < 5; i++) {
                addDay(daysOfWeek[i]);
            }
        }

        // Get current currency symbol
        function getCurrencySymbol() {
            const currency = currencySelect.value;
            return currencyData[currency]?.symbol || '$';
        }

        // Get current currency name
        function getCurrencyName() {
            const currency = currencySelect.value;
            return currencyData[currency]?.name || 'US Dollar';
        }

        // Format money with currency symbol
        function formatMoney(amount) {
            const symbol = getCurrencySymbol();
            return `${symbol}${amount.toFixed(2)}`;
        }

        // Update all currency symbols in the UI
        function updateCurrencySymbols() {
            const symbol = getCurrencySymbol();
            
            // Update all currency symbol elements
            document.querySelectorAll('.currency-symbol').forEach(element => {
                element.textContent = symbol;
            });
            
            // Update currency display
            const currencyName = getCurrencyName();
            document.getElementById('currencyDisplay').textContent = `${currencySelect.value} (${currencyName})`;
            
            // Recalculate to update all money values
            calculateWorkingHours();
        }

        // Event listeners
        overtimeEnabled.addEventListener('change', function() {
            overtimeSettings.style.display = this.checked ? 'block' : 'none';
        });

        breaksEnabled.addEventListener('change', function() {
            breakSettings.style.display = this.checked ? 'block' : 'none';
        });

        // Update currency symbols when currency changes
        currencySelect.addEventListener('change', function() {
            updateCurrencySymbols();
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateWorkingHours();
        });

        // Day management functions
        function addDay(dayName = '') {
            const dayId = 'day_' + Date.now() + Math.random().toString(36).substr(2, 9);
            const availableDays = daysOfWeek.filter(day => 
                !Array.from(daysContainer.querySelectorAll('.day-name')).some(select => select.value === day)
            );
            
            const dayRow = document.createElement('div');
            dayRow.className = 'day-row';
            dayRow.innerHTML = `
                <div class="day-checkbox">
                    <input type="checkbox" class="day-enabled" checked onchange="toggleDay(this)">
                    <select class="day-name">
                        ${availableDays.map(day => `<option value="${day}" ${day === dayName ? 'selected' : ''}>${day}</option>`).join('')}
                        ${!dayName && availableDays.length === 0 ? '<option value="Extra">Extra</option>' : ''}
                    </select>
                </div>
                <div class="time-input-group">
                    <input type="time" class="day-start" value="09:00">
                    <div class="time-separator">to</div>
                    <input type="time" class="day-end" value="17:00">
                </div>
                <div>
                    <input type="number" class="day-break" min="0" max="180" value="30" placeholder="Break (min)">
                </div>
                <button type="button" class="remove-day" onclick="removeDay(this)">×</button>
            `;
            daysContainer.appendChild(dayRow);
        }

        function removeDay(button) {
            if (daysContainer.children.length > 1) {
                button.parentElement.remove();
                calculateWorkingHours();
            }
        }

        function toggleDay(checkbox) {
            const dayRow = checkbox.closest('.day-row');
            const inputs = dayRow.querySelectorAll('input, select');
            inputs.forEach(input => {
                if (input !== checkbox) {
                    input.disabled = !checkbox.checked;
                }
            });
            calculateWorkingHours();
        }

        function calculateWorkingHours() {
            const hourlyRate = parseFloat(document.getElementById('hourlyRate').value);
            const weeklyThreshold = parseFloat(document.getElementById('weeklyThreshold').value);
            const overtimeRateMultiplier = parseFloat(document.getElementById('overtimeRate').value);
            const defaultBreakDuration = parseInt(document.getElementById('breakDuration').value);
            const includeOvertime = document.getElementById('overtimeEnabled').checked;
            const includeBreaks = document.getElementById('breaksEnabled').checked;
            const currency = currencySelect.value;

            let totalHours = 0;
            let totalBreakMinutes = 0;
            let workDays = 0;
            const dailySummaries = [];

            // Calculate hours for each day
            const dayRows = daysContainer.getElementsByClassName('day-row');
            for (let row of dayRows) {
                const enabled = row.querySelector('.day-enabled').checked;
                if (!enabled) continue;

                const dayName = row.querySelector('.day-name').value;
                const startTime = row.querySelector('.day-start').value;
                const endTime = row.querySelector('.day-end').value;
                const breakMinutes = includeBreaks ? 
                    parseInt(row.querySelector('.day-break').value) || defaultBreakDuration : 
                    0;

                // Calculate day hours
                const dayHours = calculateDayHours(startTime, endTime, breakMinutes);
                
                if (dayHours > 0) {
                    totalHours += dayHours;
                    totalBreakMinutes += breakMinutes;
                    workDays++;
                    
                    dailySummaries.push({
                        day: dayName,
                        hours: dayHours,
                        breakMinutes: breakMinutes,
                        earnings: dayHours * hourlyRate
                    });
                }
            }

            // Calculate overtime
            let regularHours = totalHours;
            let overtimeHours = 0;

            if (includeOvertime && totalHours > weeklyThreshold) {
                regularHours = weeklyThreshold;
                overtimeHours = totalHours - weeklyThreshold;
            }

            // Calculate earnings
            const regularPay = regularHours * hourlyRate;
            const overtimePay = overtimeHours * hourlyRate * overtimeRateMultiplier;
            const totalEarnings = regularPay + overtimePay;
            const monthlyEarnings = totalEarnings * 4;
            const annualEarnings = totalEarnings * 52;

            // Update UI
            updateWorkingHoursResults(
                totalHours,
                totalBreakMinutes,
                workDays,
                regularHours,
                overtimeHours,
                hourlyRate,
                weeklyThreshold,
                overtimeRateMultiplier,
                regularPay,
                overtimePay,
                totalEarnings,
                monthlyEarnings,
                annualEarnings,
                currency,
                dailySummaries
            );
        }

        function calculateDayHours(startTime, endTime, breakMinutes) {
            const [startHours, startMinutes] = startTime.split(':').map(Number);
            const [endHours, endMinutes] = endTime.split(':').map(Number);
            
            let startTotalMinutes = startHours * 60 + startMinutes;
            let endTotalMinutes = endHours * 60 + endMinutes;
            
            // Handle overnight shifts
            if (endTotalMinutes < startTotalMinutes) {
                endTotalMinutes += 24 * 60;
            }

            const totalMinutes = endTotalMinutes - startTotalMinutes;
            const netMinutes = Math.max(0, totalMinutes - breakMinutes);
            
            return netMinutes / 60;
        }

        function updateWorkingHoursResults(
            totalHours, totalBreakMinutes, workDays, regularHours, overtimeHours,
            hourlyRate, weeklyThreshold, overtimeRateMultiplier, regularPay,
            overtimePay, totalEarnings, monthlyEarnings, annualEarnings, currency, dailySummaries
        ) {
            const totalBreakHours = totalBreakMinutes / 60;
            const totalPaidHours = totalHours;
            const averageDailyHours = workDays > 0 ? totalHours / workDays : 0;
            const weeklyEfficiency = weeklyThreshold > 0 ? Math.min(100, (totalHours / weeklyThreshold) * 100) : 0;
            const weeklyProgress = Math.min(100, (totalHours / weeklyThreshold) * 100);

            // Update main results
            document.getElementById('totalEarnings').textContent = totalEarnings.toFixed(2);
            document.getElementById('totalHours').textContent = totalHours.toFixed(1);
            document.getElementById('regularHours').textContent = regularHours.toFixed(1);
            document.getElementById('overtimeHours').textContent = overtimeHours.toFixed(1);
            document.getElementById('breakTime').textContent = totalBreakHours.toFixed(1);

            // Update breakdown
            document.getElementById('workDays').textContent = `${workDays} day${workDays !== 1 ? 's' : ''}`;
            document.getElementById('totalPaidHours').textContent = `${totalPaidHours.toFixed(1)} hours`;
            document.getElementById('overtimeThresholdDisplay').textContent = `${weeklyThreshold.toFixed(1)} hours`;
            document.getElementById('averageDailyHours').textContent = `${averageDailyHours.toFixed(1)} hours/day`;
            document.getElementById('weeklyEfficiency').textContent = `${weeklyEfficiency.toFixed(1)}%`;
            
            // Update progress bar
            const progressBar = document.getElementById('weeklyProgress');
            progressBar.style.width = `${weeklyProgress}%`;
            progressBar.textContent = `${weeklyProgress.toFixed(1)}% Complete`;

            // Update earnings
            document.getElementById('regularPay').textContent = regularPay.toFixed(2);
            document.getElementById('overtimePay').textContent = overtimePay.toFixed(2);
            document.getElementById('totalWeeklyEarnings').textContent = totalEarnings.toFixed(2);
            document.getElementById('monthlyEarnings').textContent = monthlyEarnings.toFixed(2);
            document.getElementById('annualEarnings').textContent = annualEarnings.toFixed(2);

            // Update summary
            document.getElementById('hourlyRateValue').textContent = hourlyRate.toFixed(2);
            document.getElementById('overtimeRateValue').textContent = (hourlyRate * overtimeRateMultiplier).toFixed(2);
            document.getElementById('standardBreakDisplay').textContent = `${document.getElementById('breakDuration').value} minutes`;

            // Update daily summary
            updateDailySummary(dailySummaries);
        }

        function updateDailySummary(dailySummaries) {
            const dailySummaryContainer = document.getElementById('dailySummary');
            dailySummaryContainer.innerHTML = '';

            dailySummaries.forEach(day => {
                const dayElement = document.createElement('div');
                dayElement.className = 'day-summary';
                dayElement.innerHTML = `
                    <div>${day.day}</div>
                    <div>${day.hours.toFixed(1)}h</div>
                    <div>${day.breakMinutes}m</div>
                    <div class="money-amount">
                        <span class="currency-symbol">${getCurrencySymbol()}</span>
                        <span>${day.earnings.toFixed(2)}</span>
                    </div>
                `;
                dailySummaryContainer.appendChild(dayElement);
            });
        }

        // Initialize form
        window.addEventListener('load', function() {
            // Set initial visibility
            overtimeSettings.style.display = overtimeEnabled.checked ? 'block' : 'none';
            breakSettings.style.display = breaksEnabled.checked ? 'block' : 'none';
            
            // Initialize days
            initializeDays();
            
            // Set initial currency symbols
            updateCurrencySymbols();
            
            // Calculate initial working hours
            calculateWorkingHours();
        });
    </script>
</body>
</html>