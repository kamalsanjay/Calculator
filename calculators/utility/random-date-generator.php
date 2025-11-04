<?php
/**
 * Random Date Generator
 * File: utility/random-date-generator.php
 * Description: Advanced random date generator with multiple formats, ranges, and customization options
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Date Generator - Advanced Date Creation Tool</title>
    <meta name="description" content="Generate random dates with custom ranges, formats, and advanced options for testing, scheduling, and data generation.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .generator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; background: white; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #a8edea; box-shadow: 0 0 0 3px rgba(168, 237, 234, 0.1); }
        
        .date-range { display: grid; grid-template-columns: 1fr auto 1fr; gap: 15px; align-items: end; }
        .range-separator { text-align: center; padding-bottom: 14px; color: #7f8c8d; font-weight: 600; }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .checkbox-group input { width: auto; }
        
        .action-buttons { display: flex; gap: 15px; margin-top: 25px; }
        .btn { padding: 14px 24px; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; font-weight: 600; }
        .btn-primary { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(168, 237, 234, 0.3); }
        .btn-secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .btn-secondary:hover { background: #e9ecef; }
        
        .results-section { margin-top: 30px; }
        .results-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 15px; margin-top: 20px; }
        .date-card { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); padding: 18px; border-radius: 10px; text-align: center; border-left: 4px solid #a8edea; transition: all 0.3s; cursor: pointer; }
        .date-card:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .date-value { font-size: 1.1rem; font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .date-info { font-size: 0.85rem; color: #7f8c8d; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .date-formats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 20px 0; }
        .format-card { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #a8edea; }
        .format-name { font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .format-example { font-size: 0.85rem; color: #7f8c8d; }
        
        .calendar-types { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin: 20px 0; }
        .calendar-card { background: #f0f8ff; padding: 15px; border-radius: 8px; border-left: 4px solid #a8edea; }
        .calendar-name { font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .calendar-desc { font-size: 0.85rem; color: #7f8c8d; }
        
        .formula-box { background: #f0f8ff; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #a8edea; }
        .formula-box strong { color: #a8edea; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #f0f8ff; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .date-range { grid-template-columns: 1fr; }
            .range-separator { display: none; }
            .action-buttons { flex-direction: column; }
            .results-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📅 Advanced Random Date Generator</h1>
            <p>Generate random dates with custom ranges, formats, and advanced options for testing, scheduling, and data generation</p>
        </div>

        <div class="generator-card">
            <div class="control-panel">
                <div class="control-group">
                    <label for="dateRange">Date Range</label>
                    <div class="date-range">
                        <div>
                            <label for="startDate" style="font-size: 0.85rem; color: #7f8c8d;">From</label>
                            <input type="date" id="startDate" value="2000-01-01">
                        </div>
                        <div class="range-separator">→</div>
                        <div>
                            <label for="endDate" style="font-size: 0.85rem; color: #7f8c8d;">To</label>
                            <input type="date" id="endDate" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                </div>
                
                <div class="control-group">
                    <label for="dateFormat">Date Format</label>
                    <select id="dateFormat" class="control-select">
                        <option value="Y-m-d">YYYY-MM-DD (2023-12-25)</option>
                        <option value="m/d/Y">MM/DD/YYYY (12/25/2023)</option>
                        <option value="d/m/Y">DD/MM/YYYY (25/12/2023)</option>
                        <option value="F j, Y">Month Day, Year (December 25, 2023)</option>
                        <option value="D, M j, Y">Day, Month Day, Year (Mon, Dec 25, 2023)</option>
                        <option value="Y-m-d H:i:s">Full DateTime (2023-12-25 14:30:00)</option>
                        <option value="timestamp">Unix Timestamp</option>
                        <option value="relative">Relative Date (2 days ago)</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label for="dateCount">Number of Dates</label>
                    <input type="number" id="dateCount" min="1" max="100" value="12">
                </div>
            </div>
            
            <div class="control-panel">
                <div class="control-group">
                    <label for="dayPreference">Day Preference</label>
                    <select id="dayPreference" class="control-select">
                        <option value="any">Any Day</option>
                        <option value="weekdays">Weekdays Only</option>
                        <option value="weekends">Weekends Only</option>
                        <option value="monday">Mondays</option>
                        <option value="friday">Fridays</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label for="timeRange">Include Time</label>
                    <select id="timeRange" class="control-select">
                        <option value="none">No Time</option>
                        <option value="business">Business Hours (9AM-5PM)</option>
                        <option value="any">Any Time</option>
                        <option value="custom">Custom Range</option>
                    </select>
                    <div id="customTimeRange" style="display: none; margin-top: 10px;">
                        <input type="time" id="startTime" value="09:00">
                        <span style="margin: 0 10px;">to</span>
                        <input type="time" id="endTime" value="17:00">
                    </div>
                </div>
                
                <div class="control-group">
                    <label>Additional Options</label>
                    <div class="checkbox-group">
                        <input type="checkbox" id="uniqueDates" checked>
                        <label for="uniqueDates">Ensure unique dates</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="sortDates">
                        <label for="sortDates">Sort dates chronologically</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="includeInfo">
                        <label for="includeInfo">Include day info</label>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="generateDates()">🎲 Generate Dates</button>
                <button class="btn btn-secondary" onclick="saveDates()">💾 Save to File</button>
                <button class="btn btn-secondary" onclick="clearResults()">🗑️ Clear Results</button>
            </div>
            
            <div class="results-section">
                <h3>Generated Dates</h3>
                <div class="results-grid" id="resultsGrid">
                    <!-- Dates will appear here -->
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>📅 Advanced Date Generation</h2>
            
            <p>Create random dates for testing applications, scheduling simulations, data analysis, or any scenario requiring date randomization with precise control over parameters.</p>

            <h3>🌍 Date Formats & Standards</h3>
            <div class="date-formats">
                <div class="format-card">
                    <div class="format-name">ISO 8601</div>
                    <div class="format-example">YYYY-MM-DD (2023-12-25)</div>
                </div>
                <div class="format-card">
                    <div class="format-name">US Format</div>
                    <div class="format-example">MM/DD/YYYY (12/25/2023)</div>
                </div>
                <div class="format-card">
                    <div class="format-name">European Format</div>
                    <div class="format-example">DD/MM/YYYY (25/12/2023)</div>
                </div>
                <div class="format-card">
                    <div class="format-name">Written Format</div>
                    <div class="format-example">December 25, 2023</div>
                </div>
                <div class="format-card">
                    <div class="format-name">Unix Timestamp</div>
                    <div class="format-example">1703462400 (seconds since 1970)</div>
                </div>
                <div class="format-card">
                    <div class="format-name">RFC 2822</div>
                    <div class="format-example">Mon, 25 Dec 2023 14:30:00 +0000</div>
                </div>
            </div>

            <h3>📊 Common Date Ranges</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Range Type</th>
                        <th>Description</th>
                        <th>Typical Use</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Recent Dates</td><td>Past 30-90 days</td><td>Testing recent activities</td></tr>
                    <tr><td>Future Dates</td><td>Next 30-365 days</td><td>Scheduling, planning</td></tr>
                    <tr><td>Historical</td><td>Past 1-100 years</td><td>Historical data analysis</td></tr>
                    <tr><td>Birth Dates</td><td>Age 0-100 years</td><td>Demographic testing</td></tr>
                    <tr><td>Business Range</td><td>Workdays, business hours</td><td>Enterprise applications</td></tr>
                    <tr><td>Seasonal</td><td>Specific seasons</td><td>Seasonal analysis</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Date Generation Algorithms:</strong><br>
                • <strong>Uniform Distribution:</strong> Equal probability across entire range<br>
                • <strong>Weighted Distribution:</strong> Higher probability for certain periods<br>
                • <strong>Business Logic:</strong> Excludes weekends/holidays<br>
                • <strong>Seasonal Patterns:</strong> Follows seasonal trends<br>
                • <strong>Time-aware:</strong> Includes time components with logic
            </div>

            <h3>📅 Calendar Systems</h3>
            <div class="calendar-types">
                <div class="calendar-card">
                    <div class="calendar-name">Gregorian Calendar</div>
                    <div class="calendar-desc">International standard, solar-based (365.2425 days/year)</div>
                </div>
                <div class="calendar-card">
                    <div class="calendar-name">Julian Calendar</div>
                    <div class="calendar-desc">Predecessor to Gregorian (365.25 days/year)</div>
                </div>
                <div class="calendar-card">
                    <div class="calendar-name">Islamic Calendar</div>
                    <div class="calendar-desc">Lunar-based (354-355 days/year)</div>
                </div>
                <div class="calendar-card">
                    <div class="calendar-name">Hebrew Calendar</div>
                    <div class="calendar-desc">Lunisolar with leap months</div>
                </div>
            </div>

            <h3>🎯 Use Cases & Applications</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Typical Requirements</th>
                        <th>Example Parameters</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Software Testing</td><td>Edge cases, leap years, time zones</td><td>Feb 29, Dec 31, time boundaries</td></tr>
                    <tr><td>Data Analysis</td><td>Realistic distributions, trends</td><td>Seasonal patterns, business days</td></tr>
                    <tr><td>Scheduling Systems</td><td>Business logic, constraints</td><td>Work hours, exclude holidays</td></tr>
                    <tr><td>Database Seeding</td><td>Realistic test data</td><td>Birth dates, transaction dates</td></tr>
                    <tr><td>Academic Research</td><td>Statistical significance</td><td>Random sampling, control groups</td></tr>
                    <tr><td>Game Development</td><td>Event timing, progression</td><td>Random events, spawn times</td></tr>
                </tbody>
            </table>

            <h3>⏰ Time Component Generation</h3>
            <ul>
                <li><strong>Business Hours:</strong> 9:00 AM - 5:00 PM, Monday-Friday</li>
                <li><strong>Evening Hours:</strong> 6:00 PM - 11:00 PM</li>
                <li><strong>Weekend Patterns:</strong> Different time distributions</li>
                <li><strong>Peak Hours:</strong> Higher probability during busy periods</li>
                <li><strong>Second Precision:</strong> Include seconds for precise timing</li>
            </ul>

            <h3>📈 Statistical Distributions</h3>
            <div class="formula-box">
                <strong>Date Distribution Methods:</strong><br>
                • <strong>Uniform:</strong> Equal chance for every date in range<br>
                • <strong>Normal/Gaussian:</strong> Clustered around mean date<br>
                • <strong>Exponential:</strong> More recent dates more likely<br>
                • <strong>Seasonal:</strong> Higher probability in specific seasons<br>
                • <strong>Custom Weighting:</strong> User-defined probability curves
            </div>

            <h3>🌐 Time Zone Considerations</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Scenario</th>
                        <th>Consideration</th>
                        <th>Solution</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Global Applications</td><td>Different time zones</td><td>Store as UTC, convert to local</td></tr>
                    <tr><td>Daylight Saving</td><td>Time shifts twice yearly</td><td>Handle ambiguous times</td></tr>
                    <tr><td>International Business</td><td>Overlapping work hours</td><td>Generate within business windows</td></tr>
                    <tr><td>Historical Dates</td><td>Timezone changes over time</td><td>Use historical timezone data</td></tr>
                </tbody>
            </table>

            <h3>📆 Special Date Cases</h3>
            <ul>
                <li><strong>Leap Years:</strong> 29 days in February every 4 years (mostly)</li>
                <li><strong>Month End:</strong> Variable days (28-31) depending on month</li>
                <li><strong>Week Numbering:</strong> ISO week dates (Monday-based weeks)</li>
                <li><strong>Holidays:</strong> Fixed and moving holidays across cultures</li>
                <li><strong>Fiscal Years:</strong> Different start/end than calendar year</li>
            </ul>

            <h3>🔢 Date Mathematics</h3>
            <div class="formula-box">
                <strong>Common Date Calculations:</strong><br>
                • <strong>Date Difference:</strong> endDate - startDate = days between<br>
                • <strong>Date Addition:</strong> startDate + n days = future date<br>
                • <strong>Weekday Calculation:</strong> Zeller's congruence or similar algorithms<br>
                • <strong>Leap Year Check:</strong> year % 4 == 0 && (year % 100 != 0 || year % 400 == 0)<br>
                • <strong>Business Days:</strong> Exclude weekends and holidays
            </div>

            <h3>📱 Formatting Standards</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Standard</th>
                        <th>Format</th>
                        <th>Usage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>ISO 8601</td><td>YYYY-MM-DDTHH:MM:SSZ</td><td>International, unambiguous</td></tr>
                    <tr><td>RFC 2822</td><td>DD MMM YYYY HH:MM:SS +ZZZZ</td><td>Email headers</td></tr>
                    <tr><td>Unix Timestamp</td><td>Seconds since 1970-01-01</td><td>Programming, databases</td></tr>
                    <tr><td>SQL DateTime</td><td>YYYY-MM-DD HH:MM:SS</td><td>Database storage</td></tr>
                    <tr><td>Display Format</td><td>Locale-specific</td><td>User interfaces</td></tr>
                </tbody>
            </table>

            <h3>🎲 Randomization Techniques</h3>
            <ul>
                <li><strong>Cryptographic Random:</strong> High security, unpredictable</li>
                <li><strong>Pseudo-random:</strong> Repeatable with same seed</li>
                <li><strong>Weighted Random:</strong> Bias toward certain periods</li>
                <li><strong>Stratified Sampling:</strong> Ensure representation across ranges</li>
                <li><strong>Monte Carlo Methods:</strong> Statistical sampling techniques</li>
            </ul>

            <h3>🚀 Performance Considerations</h3>
            <div class="formula-box">
                <strong>Optimization Strategies:</strong><br>
                • <strong>Batch Generation:</strong> Generate multiple dates at once<br>
                • <strong>Efficient Algorithms:</strong> Optimized date calculations<br>
                • <strong>Memory Management:</strong> Stream processing for large datasets<br>
                • <strong>Caching:</strong> Store frequently used date calculations<br>
                • <strong>Parallel Processing:</strong> Generate dates concurrently when possible
            </div>
        </div>

        <div class="footer">
            <p>📅 Advanced Random Date Generator | Custom Ranges & Formats</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Generate dates for testing, scheduling, data analysis, and simulation purposes</p>
        </div>
    </div>

    <script>
        // Show/hide custom time range
        document.getElementById('timeRange').addEventListener('change', function() {
            const customTimeDiv = document.getElementById('customTimeRange');
            customTimeDiv.style.display = this.value === 'custom' ? 'block' : 'none';
        });

        function generateDates() {
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);
            const dateFormat = document.getElementById('dateFormat').value;
            const dateCount = parseInt(document.getElementById('dateCount').value);
            const dayPreference = document.getElementById('dayPreference').value;
            const timeRange = document.getElementById('timeRange').value;
            const uniqueDates = document.getElementById('uniqueDates').checked;
            const sortDates = document.getElementById('sortDates').checked;
            const includeInfo = document.getElementById('includeInfo').checked;
            
            const startTime = document.getElementById('startTime').value;
            const endTime = document.getElementById('endTime').value;
            
            const resultsGrid = document.getElementById('resultsGrid');
            resultsGrid.innerHTML = '';
            
            const generatedDates = [];
            const timeRangeMs = endDate.getTime() - startDate.getTime();
            
            for (let i = 0; i < dateCount; i++) {
                let randomDate;
                let attempts = 0;
                const maxAttempts = 1000; // Prevent infinite loops
                
                do {
                    // Generate random date within range
                    const randomTime = startDate.getTime() + Math.random() * timeRangeMs;
                    randomDate = new Date(randomTime);
                    
                    // Apply day preferences
                    if (dayPreference !== 'any') {
                        const dayOfWeek = randomDate.getDay(); // 0=Sunday, 6=Saturday
                        
                        switch (dayPreference) {
                            case 'weekdays':
                                if (dayOfWeek === 0 || dayOfWeek === 6) {
                                    randomDate = adjustToWeekday(randomDate);
                                }
                                break;
                            case 'weekends':
                                if (dayOfWeek !== 0 && dayOfWeek !== 6) {
                                    randomDate = adjustToWeekend(randomDate);
                                }
                                break;
                            case 'monday':
                                randomDate = adjustToSpecificDay(randomDate, 1);
                                break;
                            case 'friday':
                                randomDate = adjustToSpecificDay(randomDate, 5);
                                break;
                        }
                    }
                    
                    // Apply time preferences
                    if (timeRange !== 'none') {
                        randomDate = applyTimePreference(randomDate, timeRange, startTime, endTime);
                    }
                    
                    attempts++;
                } while (uniqueDates && isDateAlreadyGenerated(generatedDates, randomDate) && attempts < maxAttempts);
                
                if (attempts >= maxAttempts) {
                    alert('Could not generate enough unique dates with current settings. Try increasing the date range or reducing the count.');
                    break;
                }
                
                generatedDates.push(randomDate);
            }
            
            // Sort if requested
            if (sortDates) {
                generatedDates.sort((a, b) => a.getTime() - b.getTime());
            }
            
            // Display results
            generatedDates.forEach(date => {
                const dateCard = document.createElement('div');
                dateCard.className = 'date-card';
                
                const formattedDate = formatDate(date, dateFormat);
                const dayInfo = includeInfo ? getDayInfo(date) : '';
                
                dateCard.innerHTML = `
                    <div class="date-value">${formattedDate}</div>
                    <div class="date-info">${dayInfo}</div>
                `;
                dateCard.onclick = function() {
                    copyToClipboard(formattedDate);
                };
                
                resultsGrid.appendChild(dateCard);
            });
        }
        
        function adjustToWeekday(date) {
            const dayOfWeek = date.getDay();
            if (dayOfWeek === 0) { // Sunday
                date.setDate(date.getDate() + 1);
            } else if (dayOfWeek === 6) { // Saturday
                date.setDate(date.getDate() - 1);
            }
            return date;
        }
        
        function adjustToWeekend(date) {
            const dayOfWeek = date.getDay();
            if (dayOfWeek >= 1 && dayOfWeek <= 5) { // Weekday
                // Move to nearest weekend (prefer Saturday)
                const daysToSaturday = 6 - dayOfWeek;
                date.setDate(date.getDate() + daysToSaturday);
            }
            return date;
        }
        
        function adjustToSpecificDay(date, targetDay) {
            const currentDay = date.getDay();
            const diff = targetDay - currentDay;
            date.setDate(date.getDate() + diff);
            return date;
        }
        
        function applyTimePreference(date, timeRange, startTime, endTime) {
            switch (timeRange) {
                case 'business':
                    // Set random time between 9 AM and 5 PM
                    date.setHours(9 + Math.floor(Math.random() * 8));
                    date.setMinutes(Math.floor(Math.random() * 60));
                    date.setSeconds(Math.floor(Math.random() * 60));
                    break;
                case 'any':
                    // Already random time from Date constructor
                    break;
                case 'custom':
                    if (startTime && endTime) {
                        const start = parseTime(startTime);
                        const end = parseTime(endTime);
                        const totalMinutes = (end.hours - start.hours) * 60 + (end.minutes - start.minutes);
                        const randomMinutes = Math.floor(Math.random() * totalMinutes);
                        
                        date.setHours(start.hours + Math.floor(randomMinutes / 60));
                        date.setMinutes(start.minutes + (randomMinutes % 60));
                        date.setSeconds(Math.floor(Math.random() * 60));
                    }
                    break;
            }
            return date;
        }
        
        function parseTime(timeString) {
            const [hours, minutes] = timeString.split(':').map(Number);
            return { hours, minutes };
        }
        
        function isDateAlreadyGenerated(generatedDates, newDate) {
            return generatedDates.some(date => 
                date.getTime() === newDate.getTime()
            );
        }
        
        function formatDate(date, format) {
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const shortMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const shortDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            
            switch (format) {
                case 'Y-m-d':
                    return date.toISOString().split('T')[0];
                case 'm/d/Y':
                    return `${(date.getMonth() + 1).toString().padStart(2, '0')}/${date.getDate().toString().padStart(2, '0')}/${date.getFullYear()}`;
                case 'd/m/Y':
                    return `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth() + 1).toString().padStart(2, '0')}/${date.getFullYear()}`;
                case 'F j, Y':
                    return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
                case 'D, M j, Y':
                    return `${shortDays[date.getDay()]}, ${shortMonths[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
                case 'Y-m-d H:i:s':
                    return date.toISOString().replace('T', ' ').split('.')[0];
                case 'timestamp':
                    return Math.floor(date.getTime() / 1000).toString();
                case 'relative':
                    return getRelativeTime(date);
                default:
                    return date.toISOString();
            }
        }
        
        function getRelativeTime(date) {
            const now = new Date();
            const diffMs = now.getTime() - date.getTime();
            const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
            
            if (diffDays === 0) return 'Today';
            if (diffDays === 1) return 'Yesterday';
            if (diffDays === -1) return 'Tomorrow';
            if (diffDays > 0) return `${diffDays} days ago`;
            if (diffDays < 0) return `In ${Math.abs(diffDays)} days`;
            
            return 'Today';
        }
        
        function getDayInfo(date) {
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const dayOfWeek = days[date.getDay()];
            const isWeekend = date.getDay() === 0 || date.getDay() === 6;
            
            return `${dayOfWeek} ${isWeekend ? '🏖️' : '💼'}`;
        }
        
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Show a subtle notification (could be enhanced with a toast)
                console.log(`Copied: ${text}`);
            });
        }
        
        function saveDates() {
            const dateCards = document.querySelectorAll('.date-value');
            let dates = '';
            
            dateCards.forEach(card => {
                dates += card.textContent + '\n';
            });
            
            const blob = new Blob([dates], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'generated-dates.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
        
        function clearResults() {
            document.getElementById('resultsGrid').innerHTML = '';
        }

        // Set default end date to today
        document.getElementById('endDate').value = new Date().toISOString().split('T')[0];
        
        // Initial generation on page load
        window.onload = generateDates;
    </script>
</body>
</html>
