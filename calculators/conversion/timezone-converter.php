<?php
/**
 * Timezone Converter
 * File: conversion/timezone-converter.php
 * Description: Convert time between different timezones worldwide
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timezone Converter - World Time Zone Calculator</title>
    <meta name="description" content="Convert time between different timezones worldwide. Find time differences and schedule meetings across time zones.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .converter-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .time-input-section { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input, .input-wrapper select { width: 100%; padding: 12px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus { outline: none; border-color: #2193b0; box-shadow: 0 0 0 3px rgba(33, 147, 176, 0.1); }
        
        .timezone-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        .swap-btn { background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #e0f2f7 0%, #b2ebf2 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #2193b0; }
        .result-city { color: #00838f; font-size: 0.9rem; margin-bottom: 8px; font-weight: 600; }
        .result-time { font-size: 1.6rem; font-weight: bold; color: #006064; }
        .result-date { font-size: 0.85rem; color: #00838f; margin-top: 5px; }
        
        .quick-zones { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-zones h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .zone-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; }
        .zone-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .zone-btn:hover { border-color: #2193b0; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(33, 147, 176, 0.15); }
        .zone-name { font-weight: bold; color: #2193b0; font-size: 0.95rem; }
        .zone-offset { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .current-time { background: linear-gradient(135deg, #e0f2f7 0%, #b2ebf2 100%); padding: 20px; border-radius: 12px; margin-bottom: 25px; text-align: center; }
        .current-time h3 { color: #006064; margin-bottom: 10px; }
        .current-time .time-display { font-size: 2rem; font-weight: bold; color: #00838f; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #e0f2f7; }
        
        .formula-box { background: #e0f2f7; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #2193b0; }
        .formula-box strong { color: #2193b0; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .time-input-section { grid-template-columns: 1fr; }
            .timezone-row { grid-template-columns: 1fr; }
            .swap-btn { margin: 10px auto; }
            .result-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌍 Timezone Converter</h1>
            <p>Convert time between different timezones worldwide</p>
        </div>

        <div class="converter-card">
            <div class="current-time">
                <h3>Current Time</h3>
                <div class="time-display" id="currentTime">Loading...</div>
            </div>

            <div class="time-input-section">
                <div class="input-group">
                    <label for="timeInput">Time</label>
                    <div class="input-wrapper">
                        <input type="time" id="timeInput" value="12:00">
                    </div>
                </div>
                <div class="input-group">
                    <label for="dateInput">Date</label>
                    <div class="input-wrapper">
                        <input type="date" id="dateInput">
                    </div>
                </div>
            </div>

            <div class="timezone-row">
                <div class="input-group">
                    <label for="fromZone">From Timezone</label>
                    <div class="input-wrapper">
                        <select id="fromZone">
                            <option value="-12">UTC-12:00 (Baker Island)</option>
                            <option value="-11">UTC-11:00 (American Samoa)</option>
                            <option value="-10">UTC-10:00 (Hawaii)</option>
                            <option value="-9">UTC-09:00 (Alaska)</option>
                            <option value="-8">UTC-08:00 (PST - Los Angeles)</option>
                            <option value="-7">UTC-07:00 (MST - Denver)</option>
                            <option value="-6">UTC-06:00 (CST - Chicago)</option>
                            <option value="-5">UTC-05:00 (EST - New York)</option>
                            <option value="-4">UTC-04:00 (AST - Halifax)</option>
                            <option value="-3">UTC-03:00 (São Paulo)</option>
                            <option value="-2">UTC-02:00 (Mid-Atlantic)</option>
                            <option value="-1">UTC-01:00 (Azores)</option>
                            <option value="0" selected>UTC+00:00 (London, GMT)</option>
                            <option value="1">UTC+01:00 (Paris, Berlin)</option>
                            <option value="2">UTC+02:00 (Cairo, Athens)</option>
                            <option value="3">UTC+03:00 (Moscow)</option>
                            <option value="4">UTC+04:00 (Dubai)</option>
                            <option value="5">UTC+05:00 (Karachi)</option>
                            <option value="5.5">UTC+05:30 (India, Sri Lanka)</option>
                            <option value="6">UTC+06:00 (Dhaka)</option>
                            <option value="7">UTC+07:00 (Bangkok)</option>
                            <option value="8">UTC+08:00 (Beijing, Singapore)</option>
                            <option value="9">UTC+09:00 (Tokyo, Seoul)</option>
                            <option value="9.5">UTC+09:30 (Adelaide)</option>
                            <option value="10">UTC+10:00 (Sydney)</option>
                            <option value="11">UTC+11:00 (Solomon Islands)</option>
                            <option value="12">UTC+12:00 (Fiji, Auckland)</option>
                        </select>
                    </div>
                </div>

                <button class="swap-btn" onclick="swapTimezones()" title="Swap timezones">⇄</button>

                <div class="input-group">
                    <label for="toZone">To Timezone</label>
                    <div class="input-wrapper">
                        <select id="toZone">
                            <option value="-12">UTC-12:00 (Baker Island)</option>
                            <option value="-11">UTC-11:00 (American Samoa)</option>
                            <option value="-10">UTC-10:00 (Hawaii)</option>
                            <option value="-9">UTC-09:00 (Alaska)</option>
                            <option value="-8">UTC-08:00 (PST - Los Angeles)</option>
                            <option value="-7">UTC-07:00 (MST - Denver)</option>
                            <option value="-6">UTC-06:00 (CST - Chicago)</option>
                            <option value="-5" selected>UTC-05:00 (EST - New York)</option>
                            <option value="-4">UTC-04:00 (AST - Halifax)</option>
                            <option value="-3">UTC-03:00 (São Paulo)</option>
                            <option value="-2">UTC-02:00 (Mid-Atlantic)</option>
                            <option value="-1">UTC-01:00 (Azores)</option>
                            <option value="0">UTC+00:00 (London, GMT)</option>
                            <option value="1">UTC+01:00 (Paris, Berlin)</option>
                            <option value="2">UTC+02:00 (Cairo, Athens)</option>
                            <option value="3">UTC+03:00 (Moscow)</option>
                            <option value="4">UTC+04:00 (Dubai)</option>
                            <option value="5">UTC+05:00 (Karachi)</option>
                            <option value="5.5">UTC+05:30 (India, Sri Lanka)</option>
                            <option value="6">UTC+06:00 (Dhaka)</option>
                            <option value="7">UTC+07:00 (Bangkok)</option>
                            <option value="8">UTC+08:00 (Beijing, Singapore)</option>
                            <option value="9">UTC+09:00 (Tokyo, Seoul)</option>
                            <option value="9.5">UTC+09:30 (Adelaide)</option>
                            <option value="10">UTC+10:00 (Sydney)</option>
                            <option value="11">UTC+11:00 (Solomon Islands)</option>
                            <option value="12">UTC+12:00 (Fiji, Auckland)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="result-grid" id="resultGrid"></div>

            <div class="quick-zones">
                <h3>🌐 Popular Timezones</h3>
                <div class="zone-grid">
                    <div class="zone-btn" onclick="setFromZone('-8')">
                        <div class="zone-name">Los Angeles</div>
                        <div class="zone-offset">UTC-8</div>
                    </div>
                    <div class="zone-btn" onclick="setFromZone('-5')">
                        <div class="zone-name">New York</div>
                        <div class="zone-offset">UTC-5</div>
                    </div>
                    <div class="zone-btn" onclick="setFromZone('0')">
                        <div class="zone-name">London</div>
                        <div class="zone-offset">UTC+0</div>
                    </div>
                    <div class="zone-btn" onclick="setFromZone('1')">
                        <div class="zone-name">Paris</div>
                        <div class="zone-offset">UTC+1</div>
                    </div>
                    <div class="zone-btn" onclick="setFromZone('5.5')">
                        <div class="zone-name">India</div>
                        <div class="zone-offset">UTC+5:30</div>
                    </div>
                    <div class="zone-btn" onclick="setFromZone('8')">
                        <div class="zone-name">Singapore</div>
                        <div class="zone-offset">UTC+8</div>
                    </div>
                    <div class="zone-btn" onclick="setFromZone('9')">
                        <div class="zone-name">Tokyo</div>
                        <div class="zone-offset">UTC+9</div>
                    </div>
                    <div class="zone-btn" onclick="setFromZone('10')">
                        <div class="zone-name">Sydney</div>
                        <div class="zone-offset">UTC+10</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>🌍 Understanding Timezones</h2>
            
            <p>Timezones are regions of Earth that have the same standard time. The world is divided into 24 main time zones, based on the <strong>Coordinated Universal Time (UTC)</strong> standard.</p>

            <div class="formula-box">
                <strong>How Timezones Work:</strong><br>
                • Earth rotates 360° in 24 hours = 15° per hour<br>
                • Each timezone is approximately 15° of longitude<br>
                • UTC (Coordinated Universal Time) is the reference<br>
                • Times are expressed as UTC+/-N hours<br>
                • Example: UTC+5:30 means 5 hours 30 minutes ahead of UTC
            </div>

            <h3>🕐 Major Timezones</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Timezone</th>
                        <th>UTC Offset</th>
                        <th>Major Cities</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>PST (Pacific)</td><td>UTC-8</td><td>Los Angeles, San Francisco, Seattle</td></tr>
                    <tr><td>MST (Mountain)</td><td>UTC-7</td><td>Denver, Phoenix</td></tr>
                    <tr><td>CST (Central)</td><td>UTC-6</td><td>Chicago, Dallas, Mexico City</td></tr>
                    <tr><td>EST (Eastern)</td><td>UTC-5</td><td>New York, Miami, Toronto</td></tr>
                    <tr><td>GMT/UTC</td><td>UTC+0</td><td>London, Dublin, Lisbon</td></tr>
                    <tr><td>CET (Central Europe)</td><td>UTC+1</td><td>Paris, Berlin, Rome</td></tr>
                    <tr><td>IST (India)</td><td>UTC+5:30</td><td>Mumbai, Delhi, Bangalore</td></tr>
                    <tr><td>CST (China)</td><td>UTC+8</td><td>Beijing, Shanghai, Hong Kong</td></tr>
                    <tr><td>JST (Japan)</td><td>UTC+9</td><td>Tokyo, Osaka</td></tr>
                    <tr><td>AEST (Australia)</td><td>UTC+10</td><td>Sydney, Melbourne</td></tr>
                </tbody>
            </table>

            <h3>⏰ Daylight Saving Time (DST)</h3>
            <ul>
                <li><strong>DST:</strong> Clocks move forward 1 hour in spring, back in fall</li>
                <li><strong>US/Canada:</strong> 2nd Sunday March to 1st Sunday November</li>
                <li><strong>EU:</strong> Last Sunday March to last Sunday October</li>
                <li><strong>Not observed:</strong> Arizona, Hawaii, most of Asia, Africa</li>
                <li><strong>Southern Hemisphere:</strong> Opposite schedule (Oct-Mar)</li>
            </ul>

            <h3>🔑 Key Concepts</h3>
            <ul>
                <li><strong>UTC:</strong> Coordinated Universal Time (reference point)</li>
                <li><strong>GMT:</strong> Greenwich Mean Time (equivalent to UTC)</li>
                <li><strong>Offset:</strong> Difference from UTC (e.g., UTC+5:30)</li>
                <li><strong>DST:</strong> Daylight Saving Time (seasonal adjustment)</li>
                <li><strong>Solar noon:</strong> When sun is highest (varies by timezone)</li>
            </ul>
        </div>

        <div class="footer">
            <p>🌍 Accurate Timezone Conversion | World Time Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Perfect for international meetings, travel planning, and global communication</p>
        </div>
    </div>

    <script>
        function updateCurrentTime() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                hour12: true 
            });
            const dateStr = now.toLocaleDateString('en-US', { 
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            document.getElementById('currentTime').textContent = `${timeStr} - ${dateStr}`;
        }

        function convertTime() {
            const timeInput = document.getElementById('timeInput').value;
            const dateInput = document.getElementById('dateInput').value;
            const fromOffset = parseFloat(document.getElementById('fromZone').value);
            const toOffset = parseFloat(document.getElementById('toZone').value);

            if (!timeInput || !dateInput) return;

            const [hours, minutes] = timeInput.split(':').map(Number);
            const baseDate = new Date(dateInput);
            baseDate.setHours(hours, minutes, 0, 0);

            // Convert to UTC
            const utcTime = new Date(baseDate.getTime() - (fromOffset * 60 * 60 * 1000));
            
            // Popular cities with their offsets
            const cities = [
                { name: 'Los Angeles', offset: -8 },
                { name: 'New York', offset: -5 },
                { name: 'London', offset: 0 },
                { name: 'Paris', offset: 1 },
                { name: 'Dubai', offset: 4 },
                { name: 'India', offset: 5.5 },
                { name: 'Singapore', offset: 8 },
                { name: 'Tokyo', offset: 9 },
                { name: 'Sydney', offset: 10 }
            ];

            const resultGrid = document.getElementById('resultGrid');
            resultGrid.innerHTML = '';

            cities.forEach(city => {
                const cityTime = new Date(utcTime.getTime() + (city.offset * 60 * 60 * 1000));
                
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div class="result-city">${city.name}</div>
                    <div class="result-time">${cityTime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true })}</div>
                    <div class="result-date">${cityTime.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })}</div>
                `;
                resultGrid.appendChild(card);
            });
        }

        function swapTimezones() {
            const fromZone = document.getElementById('fromZone').value;
            const toZone = document.getElementById('toZone').value;
            
            document.getElementById('fromZone').value = toZone;
            document.getElementById('toZone').value = fromZone;
            
            convertTime();
        }

        function setFromZone(offset) {
            document.getElementById('fromZone').value = offset;
            convertTime();
        }

        // Set today's date
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('dateInput').value = today;

        // Event listeners
        document.getElementById('timeInput').addEventListener('change', convertTime);
        document.getElementById('dateInput').addEventListener('change', convertTime);
        document.getElementById('fromZone').addEventListener('change', convertTime);
        document.getElementById('toZone').addEventListener('change', convertTime);

        // Update current time every second
        updateCurrentTime();
        setInterval(updateCurrentTime, 1000);

        // Initial conversion
        convertTime();
    </script>
</body>
</html>