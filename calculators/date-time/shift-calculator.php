<?php
/**
 * Shift Calculator
 * File: date-time/shift-calculator.php
 * Description: Calculate shift hours, overtime, and earnings for different work schedules
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shift Calculator - Calculate Work Hours, Overtime & Earnings</title>
    <meta name="description" content="Free shift calculator. Calculate work hours, overtime pay, break times, and total earnings for different shift schedules.">
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
        
        .break-settings {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #667eea;
        }
        
        .break-row {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 10px;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .add-break-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            margin-top: 10px;
        }
        
        .remove-break {
            background: #ff6b6b;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            font-size: 0.8rem;
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
        
        .shift-timeline {
            margin: 15px 0;
            padding: 15px;
            background: white;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }
        
        .timeline-bar {
            height: 40px;
            background: #f0f0f0;
            border-radius: 20px;
            position: relative;
            margin: 20px 0;
            overflow: hidden;
        }
        
        .timeline-segment {
            position: absolute;
            height: 100%;
            border-radius: 20px;
        }
        
        .segment-work { background: #4CAF50; }
        .segment-break { background: #FF9800; }
        .segment-overtime { background: #F44336; }
        
        .timeline-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #666;
            margin-top: 5px;
        }
        
        .earnings-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin: 15px 0;
        }
        
        @media (max-width: 768px) {
            .earnings-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .earning-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 2px solid #e0e0e0;
        }
        
        .earning-card h4 {
            color: #666;
            font-size: 0.8rem;
            margin-bottom: 8px;
        }
        
        .earning-card .amount {
            color: #667eea;
            font-size: 1.2rem;
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
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⏰ Shift Calculator</h1>
            <p>Calculate work hours, overtime pay, break times, and total earnings</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Shift Details</h2>
                <form id="shiftForm">
                    <div class="form-group">
                        <label for="shiftDate">Shift Date</label>
                        <input type="date" id="shiftDate" required>
                        <small>Date of the shift</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="shiftType">Shift Type</label>
                        <select id="shiftType">
                            <option value="day">Day Shift (7AM - 3PM)</option>
                            <option value="evening">Evening Shift (3PM - 11PM)</option>
                            <option value="night">Night Shift (11PM - 7AM)</option>
                            <option value="custom">Custom Shift</option>
                        </select>
                        <small>Select your shift pattern</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Shift Times</label>
                        <div class="time-input-group">
                            <input type="time" id="startTime" value="09:00" required>
                            <div class="time-separator">to</div>
                            <input type="time" id="endTime" value="17:00" required>
                        </div>
                        <small>Start and end time of your shift</small>
                    </div>
                    
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
                        <label>Overtime Settings</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="overtimeEnabled" checked>
                            <label for="overtimeEnabled">Include overtime calculation</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="doubleTimeEnabled">
                            <label for="doubleTimeEnabled">Include double time (2x rate)</label>
                        </div>
                    </div>
                    
                    <div class="form-group" id="overtimeSettings">
                        <label for="overtimeThreshold">Overtime Starts After (hours)</label>
                        <input type="number" id="overtimeThreshold" min="0" max="24" value="8" step="0.5">
                        <small>Hours worked before overtime applies</small>
                        
                        <label for="overtimeRate" style="margin-top: 15px;">Overtime Rate Multiplier</label>
                        <input type="number" id="overtimeRate" min="1" max="3" step="0.1" value="1.5">
                        <small>Typically 1.5x normal rate</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Break Settings</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="breaksEnabled" checked>
                            <label for="breaksEnabled">Include break deductions</label>
                        </div>
                    </div>
                    
                    <div class="break-settings" id="breakSettings">
                        <h4 style="margin-bottom: 15px; color: #667eea;">Break Times</h4>
                        <div id="breakContainer">
                            <div class="break-row">
                                <input type="time" class="break-start" value="12:00">
                                <input type="time" class="break-end" value="12:30">
                                <button type="button" class="remove-break" onclick="removeBreak(this)">×</button>
                            </div>
                        </div>
                        <button type="button" class="add-break-btn" onclick="addBreak()">+ Add Another Break</button>
                        <small>Add all break periods during your shift</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Shift</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Shift Results</h2>
                
                <div class="result-card">
                    <h3>Total Shift Earnings</h3>
                    <div class="amount">
                        <span class="money-amount">
                            <span class="currency-symbol" id="totalCurrencySymbol">$</span>
                            <span id="totalEarnings">200.00</span>
                        </span>
                    </div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Total Hours</h4>
                        <div class="value" id="totalHours">8.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Regular Hours</h4>
                        <div class="value" id="regularHours">8.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Overtime Hours</h4>
                        <div class="value" id="overtimeHours">0.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Break Time</h4>
                        <div class="value" id="breakTime">0.5</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Time Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Shift Duration</span>
                        <strong id="shiftDuration">8 hours 0 minutes</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Paid Hours</span>
                        <strong id="paidHours">7.5 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Break Duration</span>
                        <strong id="totalBreakDuration">0.5 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Overtime Threshold</span>
                        <strong id="overtimeThresholdDisplay">8.0 hours</strong>
                    </div>
                    <div class="breakdown-item highlight">
                        <span>Net Working Time</span>
                        <strong id="netWorkingTime">7.5 hours</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Shift Timeline</h3>
                    <div class="shift-timeline">
                        <div class="timeline-bar" id="timelineBar">
                            <!-- Timeline segments will be generated here -->
                        </div>
                        <div class="timeline-labels">
                            <span id="timelineStart">9:00 AM</span>
                            <span id="timelineEnd">5:00 PM</span>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Earnings Breakdown</h3>
                    <div class="earnings-grid">
                        <div class="earning-card">
                            <h4>Regular Pay</h4>
                            <div class="amount money-amount">
                                <span class="currency-symbol" id="regularPaySymbol">$</span>
                                <span id="regularPay">200.00</span>
                            </div>
                        </div>
                        <div class="earning-card">
                            <h4>Overtime Pay</h4>
                            <div class="amount money-amount">
                                <span class="currency-symbol" id="overtimePaySymbol">$</span>
                                <span id="overtimePay">0.00</span>
                            </div>
                        </div>
                        <div class="earning-card">
                            <h4>Double Time Pay</h4>
                            <div class="amount money-amount">
                                <span class="currency-symbol" id="doubleTimePaySymbol">$</span>
                                <span id="doubleTimePay">0.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="breakdown-item highlight">
                        <span>Total Earnings</span>
                        <strong class="money-amount">
                            <span class="currency-symbol" id="totalEarningsSymbol">$</span>
                            <span id="totalEarningsBreakdown">200.00</span>
                        </strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Shift Summary</h3>
                    <div class="breakdown-item">
                        <span>Shift Date</span>
                        <strong id="shiftDateDisplay">Monday, January 15, 2024</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Shift Type</span>
                        <strong id="shiftTypeDisplay">Day Shift</strong>
                    </div>
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
                </div>
                
                <div class="info-box">
                    <strong>Shift Calculation Note:</strong> Regular hours are paid at normal rate, overtime hours at 1.5x rate (after threshold), and double time at 2x rate. Break times are deducted from total paid hours.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⏰ Shift Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate your work hours and earnings accurately</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('shiftForm');
        const shiftType = document.getElementById('shiftType');
        const overtimeEnabled = document.getElementById('overtimeEnabled');
        const breaksEnabled = document.getElementById('breaksEnabled');
        const overtimeSettings = document.getElementById('overtimeSettings');
        const breakSettings = document.getElementById('breakSettings');
        const breakContainer = document.getElementById('breakContainer');
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

        // Shift type presets
        const shiftPresets = {
            day: { start: '07:00', end: '15:00' },
            evening: { start: '15:00', end: '23:00' },
            night: { start: '23:00', end: '07:00' },
            custom: { start: '09:00', end: '17:00' }
        };

        // Set default date to today
        const today = new Date();
        document.getElementById('shiftDate').value = today.toISOString().split('T')[0];

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
            calculateShift();
        }

        // Event listeners
        shiftType.addEventListener('change', function() {
            const preset = shiftPresets[this.value];
            document.getElementById('startTime').value = preset.start;
            document.getElementById('endTime').value = preset.end;
        });

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
            calculateShift();
        });

        // Break management functions
        function addBreak() {
            const breakRow = document.createElement('div');
            breakRow.className = 'break-row';
            breakRow.innerHTML = `
                <input type="time" class="break-start" value="12:00">
                <input type="time" class="break-end" value="12:30">
                <button type="button" class="remove-break" onclick="removeBreak(this)">×</button>
            `;
            breakContainer.appendChild(breakRow);
        }

        function removeBreak(button) {
            if (breakContainer.children.length > 1) {
                button.parentElement.remove();
            }
        }

        function calculateShift() {
            // Get input values
            const shiftDate = new Date(document.getElementById('shiftDate').value);
            const startTime = document.getElementById('startTime').value;
            const endTime = document.getElementById('endTime').value;
            const hourlyRate = parseFloat(document.getElementById('hourlyRate').value);
            const overtimeThreshold = parseFloat(document.getElementById('overtimeThreshold').value);
            const overtimeRateMultiplier = parseFloat(document.getElementById('overtimeRate').value);
            const includeOvertime = document.getElementById('overtimeEnabled').checked;
            const includeDoubleTime = document.getElementById('doubleTimeEnabled').checked;
            const includeBreaks = document.getElementById('breaksEnabled').checked;
            const currency = currencySelect.value;

            // Calculate time values
            const startDateTime = new Date(shiftDate);
            const [startHours, startMinutes] = startTime.split(':').map(Number);
            startDateTime.setHours(startHours, startMinutes, 0, 0);

            const endDateTime = new Date(shiftDate);
            const [endHours, endMinutes] = endTime.split(':').map(Number);
            endDateTime.setHours(endHours, endMinutes, 0, 0);

            // Handle overnight shifts
            if (endDateTime < startDateTime) {
                endDateTime.setDate(endDateTime.getDate() + 1);
            }

            // Calculate total shift duration in hours
            const totalShiftMs = endDateTime - startDateTime;
            const totalShiftHours = totalShiftMs / (1000 * 60 * 60);

            // Calculate break time
            let totalBreakHours = 0;
            if (includeBreaks) {
                const breakRows = breakContainer.getElementsByClassName('break-row');
                for (let row of breakRows) {
                    const breakStart = row.querySelector('.break-start').value;
                    const breakEnd = row.querySelector('.break-end').value;
                    
                    if (breakStart && breakEnd) {
                        const [breakStartHours, breakStartMinutes] = breakStart.split(':').map(Number);
                        const [breakEndHours, breakEndMinutes] = breakEnd.split(':').map(Number);
                        
                        const breakStartTime = new Date(shiftDate);
                        breakStartTime.setHours(breakStartHours, breakStartMinutes, 0, 0);
                        
                        const breakEndTime = new Date(shiftDate);
                        breakEndTime.setHours(breakEndHours, breakEndMinutes, 0, 0);
                        
                        // Handle breaks that cross midnight
                        if (breakEndTime < breakStartTime) {
                            breakEndTime.setDate(breakEndTime.getDate() + 1);
                        }
                        
                        const breakDurationMs = breakEndTime - breakStartTime;
                        totalBreakHours += breakDurationMs / (1000 * 60 * 60);
                    }
                }
            }

            // Calculate paid hours
            const paidHours = Math.max(0, totalShiftHours - totalBreakHours);

            // Calculate overtime and double time
            let regularHours = paidHours;
            let overtimeHours = 0;
            let doubleTimeHours = 0;

            if (includeOvertime && paidHours > overtimeThreshold) {
                regularHours = overtimeThreshold;
                overtimeHours = paidHours - overtimeThreshold;
                
                // For very long shifts with double time enabled
                if (includeDoubleTime && paidHours > 12) {
                    doubleTimeHours = paidHours - 12;
                    overtimeHours = 12 - overtimeThreshold;
                }
            }

            // Calculate earnings
            const regularPay = regularHours * hourlyRate;
            const overtimePay = overtimeHours * hourlyRate * overtimeRateMultiplier;
            const doubleTimePay = doubleTimeHours * hourlyRate * 2;
            const totalEarnings = regularPay + overtimePay + doubleTimePay;

            // Update UI
            updateShiftResults(
                shiftDate,
                startTime,
                endTime,
                totalShiftHours,
                paidHours,
                totalBreakHours,
                regularHours,
                overtimeHours,
                doubleTimeHours,
                hourlyRate,
                overtimeThreshold,
                overtimeRateMultiplier,
                regularPay,
                overtimePay,
                doubleTimePay,
                totalEarnings,
                currency
            );

            // Generate timeline
            generateTimeline(startTime, endTime, totalBreakHours);
        }

        function updateShiftResults(
            shiftDate, startTime, endTime, totalShiftHours, paidHours, totalBreakHours,
            regularHours, overtimeHours, doubleTimeHours, hourlyRate, overtimeThreshold,
            overtimeRateMultiplier, regularPay, overtimePay, doubleTimePay, totalEarnings, currency
        ) {
            // Format times for display
            const startTimeDisplay = formatTimeDisplay(startTime);
            const endTimeDisplay = formatTimeDisplay(endTime);
            const shiftDateDisplay = formatDateDisplay(shiftDate);
            const shiftTypeText = document.getElementById('shiftType').options[document.getElementById('shiftType').selectedIndex].text;

            // Update main results
            document.getElementById('totalEarnings').textContent = totalEarnings.toFixed(2);
            document.getElementById('totalHours').textContent = totalShiftHours.toFixed(1);
            document.getElementById('regularHours').textContent = regularHours.toFixed(1);
            document.getElementById('overtimeHours').textContent = overtimeHours.toFixed(1);
            document.getElementById('breakTime').textContent = totalBreakHours.toFixed(1);

            // Update breakdown
            document.getElementById('shiftDuration').textContent = formatDuration(totalShiftHours);
            document.getElementById('paidHours').textContent = `${paidHours.toFixed(1)} hours`;
            document.getElementById('totalBreakDuration').textContent = `${totalBreakHours.toFixed(1)} hours`;
            document.getElementById('overtimeThresholdDisplay').textContent = `${overtimeThreshold.toFixed(1)} hours`;
            document.getElementById('netWorkingTime').textContent = `${paidHours.toFixed(1)} hours`;

            // Update earnings
            document.getElementById('regularPay').textContent = regularPay.toFixed(2);
            document.getElementById('overtimePay').textContent = overtimePay.toFixed(2);
            document.getElementById('doubleTimePay').textContent = doubleTimePay.toFixed(2);
            document.getElementById('totalEarningsBreakdown').textContent = totalEarnings.toFixed(2);

            // Update summary
            document.getElementById('shiftDateDisplay').textContent = shiftDateDisplay;
            document.getElementById('shiftTypeDisplay').textContent = shiftTypeText.split(' (')[0];
            document.getElementById('hourlyRateValue').textContent = hourlyRate.toFixed(2);
            document.getElementById('overtimeRateValue').textContent = (hourlyRate * overtimeRateMultiplier).toFixed(2);

            // Update timeline labels
            document.getElementById('timelineStart').textContent = startTimeDisplay;
            document.getElementById('timelineEnd').textContent = endTimeDisplay;
        }

        function generateTimeline(startTime, endTime, totalBreakHours) {
            const timelineBar = document.getElementById('timelineBar');
            timelineBar.innerHTML = '';

            // Convert times to minutes since midnight
            const [startHours, startMinutes] = startTime.split(':').map(Number);
            const [endHours, endMinutes] = endTime.split(':').map(Number);
            
            let startTotalMinutes = startHours * 60 + startMinutes;
            let endTotalMinutes = endHours * 60 + endMinutes;
            
            // Handle overnight shifts
            if (endTotalMinutes < startTotalMinutes) {
                endTotalMinutes += 24 * 60;
            }

            const totalMinutes = endTotalMinutes - startTotalMinutes;
            const breakMinutes = totalBreakHours * 60;
            const workMinutes = totalMinutes - breakMinutes;

            // Calculate percentages for timeline
            const workPercentage = (workMinutes / totalMinutes) * 100;
            const breakPercentage = (breakMinutes / totalMinutes) * 100;

            // Create timeline segments
            if (workPercentage > 0) {
                const workSegment = document.createElement('div');
                workSegment.className = 'timeline-segment segment-work';
                workSegment.style.width = `${workPercentage}%`;
                workSegment.style.left = '0%';
                workSegment.title = `Work: ${formatDuration(workMinutes / 60)}`;
                timelineBar.appendChild(workSegment);
            }

            if (breakPercentage > 0) {
                const breakSegment = document.createElement('div');
                breakSegment.className = 'timeline-segment segment-break';
                breakSegment.style.width = `${breakPercentage}%`;
                breakSegment.style.left = `${workPercentage}%`;
                breakSegment.title = `Break: ${formatDuration(breakMinutes / 60)}`;
                timelineBar.appendChild(breakSegment);
            }
        }

        function formatTimeDisplay(timeString) {
            const [hours, minutes] = timeString.split(':').map(Number);
            const period = hours >= 12 ? 'PM' : 'AM';
            const displayHours = hours % 12 || 12;
            return `${displayHours}:${minutes.toString().padStart(2, '0')} ${period}`;
        }

        function formatDateDisplay(date) {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        function formatDuration(hours) {
            const totalMinutes = Math.round(hours * 60);
            const hoursPart = Math.floor(totalMinutes / 60);
            const minutesPart = totalMinutes % 60;
            
            if (hoursPart === 0) {
                return `${minutesPart} minutes`;
            } else if (minutesPart === 0) {
                return `${hoursPart} hour${hoursPart !== 1 ? 's' : ''}`;
            } else {
                return `${hoursPart} hour${hoursPart !== 1 ? 's' : ''} ${minutesPart} minutes`;
            }
        }

        // Initialize form
        window.addEventListener('load', function() {
            // Set initial visibility
            overtimeSettings.style.display = overtimeEnabled.checked ? 'block' : 'none';
            breakSettings.style.display = breaksEnabled.checked ? 'block' : 'none';
            
            // Set initial currency symbols
            updateCurrencySymbols();
            
            // Calculate initial shift
            calculateShift();
        });
    </script>
</body>
</html>