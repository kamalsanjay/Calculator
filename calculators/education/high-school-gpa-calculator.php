<?php
/**
 * High School GPA Calculator - Indian Education System
 * File: education/high-school-gpa-calculator.php
 * Description: Advanced calculator for Indian high school GPA calculation with currency support
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>High School GPA Calculator - Indian Education System & Currency Support</title>
    <meta name="description" content="Advanced high school GPA calculator for Indian education system with multiple currency support.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Noto Sans', sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #ff6b6b; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #ff6b6b; box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3); }
        .btn-secondary { background: linear-gradient(135deg, #ff9ff3 0%, #f368e0 100%); margin-top: 10px; }
        .btn-indian { background: linear-gradient(135deg, #10ac84 0%, #1dd1a1 100%); }
        
        .result-card { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3); position: relative; overflow: hidden; }
        .result-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 0.8; } }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; position: relative; z-index: 1; }
        .result-card .amount { font-size: 3rem; font-weight: bold; position: relative; z-index: 1; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #ff6b6b; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #ff6b6b; font-size: 1.8rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #ff6b6b; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .progress-bar { background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #ff6b6b 0%, #ee5a24 100%); width: 0%; transition: width 1s ease-out; }
        
        .info-box { background: #ffeaea; border-left: 4px solid #ff6b6b; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #ff6b6b; }
        
        .year-tabs { display: flex; gap: 5px; margin-bottom: 20px; flex-wrap: wrap; }
        .year-tab { padding: 10px 15px; background: #f0f0f0; border: none; border-radius: 6px; cursor: pointer; transition: all 0.3s; }
        .year-tab.active { background: #ff6b6b; color: white; }
        .year-tab:hover { background: #ff9f9f; color: white; }
        
        .course-list { max-height: 400px; overflow-y: auto; border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
        .course-item { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr auto; gap: 8px; align-items: center; padding: 10px; border-bottom: 1px solid #e0e0e0; }
        .course-item:last-child { border-bottom: none; }
        .course-item-header { font-weight: 600; color: #ff6b6b; padding-bottom: 10px; border-bottom: 2px solid #ff6b6b; }
        .course-input { padding: 6px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 14px; }
        .remove-course { background: #ff6b6b; color: white; border: none; border-radius: 4px; padding: 4px 8px; cursor: pointer; font-size: 12px; }
        
        .board-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 8px; margin-top: 10px; }
        .board-btn { padding: 8px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .board-btn:hover { background: #ff6b6b; color: white; border-color: #ff6b6b; }
        .board-btn.active { background: #ff6b6b; color: white; border-color: #ff6b6b; }
        
        .currency-selector { display: flex; gap: 10px; margin-bottom: 20px; }
        .currency-btn { padding: 10px 20px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; font-weight: 600; }
        .currency-btn.active { background: #10ac84; color: white; border-color: #10ac84; }
        .currency-btn:hover { background: #1dd1a1; color: white; border-color: #1dd1a1; }
        
        .indian-visual { display: flex; flex-direction: column; align-items: center; margin: 20px 0; }
        .marksheet { width: 260px; height: 200px; background: #f8f9fa; border: 3px solid #ff6b6b; border-radius: 8px; position: relative; padding: 20px; text-align: center; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .marksheet::before { content: ''; position: absolute; top: -10px; left: -10px; right: -10px; bottom: -10px; border: 2px solid #ee5a24; border-radius: 12px; opacity: 0.3; }
        .marksheet-board { font-size: 1rem; color: #ff6b6b; font-weight: 600; margin-bottom: 5px; }
        .marksheet-percentage { font-size: 2.5rem; font-weight: bold; color: #ff6b6b; margin: 15px 0; }
        .marksheet-division { font-size: 0.9rem; color: #666; }
        .academic-level { font-size: 1.2rem; font-weight: bold; color: #ff6b6b; }
        
        .indian-education-chart { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .chart-container { height: 200px; position: relative; margin: 20px 0; display: flex; align-items: end; gap: 12px; }
        .chart-bar { flex: 1; background: linear-gradient(to top, #ff6b6b, #ee5a24); border-radius: 4px 4px 0 0; transition: height 1s ease-out; position: relative; }
        .chart-label { position: absolute; bottom: -25px; text-align: center; font-size: 0.8rem; color: #666; width: 100%; }
        .chart-value { position: absolute; top: -25px; text-align: center; font-size: 0.9rem; font-weight: 600; color: #333; width: 100%; }
        
        .indian-exam-plan { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
        .exam-card { background: white; padding: 15px; border-radius: 8px; border: 2px solid #e0e0e0; text-align: center; }
        .exam-card h4 { color: #666; margin-bottom: 10px; font-size: 0.9rem; }
        .exam-value { font-size: 1.5rem; font-weight: bold; color: #ff6b6b; }
        
        .indian-scholarship-calculator { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .scholarship-item { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0; }
        .scholarship-item:last-child { border-bottom: none; margin-bottom: 0; }
        
        .indian-college-analysis { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .college-item { display: flex; justify-content: space-between; margin-bottom: 8px; padding: 8px; background: white; border-radius: 4px; border-left: 4px solid #ff6b6b; }
        
        .indian-competitive-exams { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .exam-item { display: flex; justify-content: space-between; margin-bottom: 8px; padding: 8px; background: white; border-radius: 4px; border-left: 4px solid #10ac84; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .indian-grading-system { background: #e8f6f3; padding: 15px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #10ac84; }
        .grading-item { display: flex; justify-content: space-between; padding: 5px 0; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
            .indian-exam-plan { grid-template-columns: 1fr; }
            .course-item { grid-template-columns: 1fr 1fr; gap: 5px; }
            .course-item-header { display: none; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .board-preset { grid-template-columns: repeat(2, 1fr); }
            .year-tabs { justify-content: center; }
            .course-item { grid-template-columns: 1fr; text-align: center; }
            .currency-selector { flex-wrap: wrap; justify-content: center; }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
            .marksheet { width: 220px; height: 180px; padding: 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏫 Indian High School GPA Calculator</h1>
            <p>Calculate Percentage, CGPA, and Academic Performance for Indian Education Boards</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Academic Information</h2>
                
                <div class="currency-selector">
                    <div class="currency-btn active" onclick="setCurrency('INR')">🇮🇳 Indian Rupee (₹)</div>
                    <div class="currency-btn" onclick="setCurrency('USD')">🇺🇸 US Dollar ($)</div>
                    <div class="currency-btn" onclick="setCurrency('EUR')">🇪🇺 Euro (€)</div>
                </div>
                
                <div class="form-group">
                    <label for="educationBoard">Education Board</label>
                    <select id="educationBoard" style="padding: 12px;">
                        <option value="cbse" selected>CBSE (Central Board)</option>
                        <option value="icse">ICSE (CISCE)</option>
                        <option value="state">State Board</option>
                        <option value="igcse">IGCSE</option>
                        <option value="ib">International Baccalaureate</option>
                        <option value="ncert">NCERT</option>
                    </select>
                    <small>Select your education board for accurate grading</small>
                </div>
                
                <div class="form-group">
                    <label>Quick Board Presets</label>
                    <div class="board-preset">
                        <div class="board-btn active" onclick="setEducationBoard('cbse')">CBSE</div>
                        <div class="board-btn" onclick="setEducationBoard('icse')">ICSE</div>
                        <div class="board-btn" onclick="setEducationBoard('state')">State Board</div>
                        <div class="board-btn" onclick="setEducationBoard('igcse')">IGCSE</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="gradingSystem">Grading System</label>
                    <select id="gradingSystem" style="padding: 12px;">
                        <option value="percentage" selected>Percentage System</option>
                        <option value="cgpa">CGPA (10-point)</option>
                        <option value="grades">Letter Grades</option>
                        <option value="gpa">GPA (4.0 Scale)</option>
                    </select>
                    <small>Select your preferred grading system</small>
                </div>

                <div class="form-group">
                    <label for="currentClass">Current Class</label>
                    <select id="currentClass" style="padding: 12px;">
                        <option value="9">Class 9</option>
                        <option value="10">Class 10</option>
                        <option value="11" selected>Class 11</option>
                        <option value="12">Class 12</option>
                    </select>
                    <small>Your current class/grade level</small>
                </div>

                <h3>Academic Year Management</h3>
                <div class="year-tabs" id="yearTabs">
                    <!-- Year tabs will be generated here -->
                </div>

                <div class="course-list">
                    <div class="course-item course-item-header">
                        <div>Subject Name</div>
                        <div>Max Marks</div>
                        <div>Marks Obtained</div>
                        <div>Percentage</div>
                        <div>Grade</div>
                        <div>Action</div>
                    </div>
                    <div id="courseContainer">
                        <!-- Course items will be generated here -->
                    </div>
                </div>

                <button class="btn btn-secondary" onclick="addSubject()">+ Add Subject</button>
                <button class="btn btn-indian" onclick="addAcademicYear()" style="margin-top: 10px;">+ Add Academic Year</button>

                <div class="form-group">
                    <label for="previousPercentage">Previous Year Percentage/CGPA</label>
                    <input type="number" id="previousPercentage" min="0" max="100" step="0.1" placeholder="e.g., 85.5">
                    <small>Your overall percentage from previous year</small>
                </div>
                
                <div class="form-group">
                    <label for="stream">Stream (Class 11-12)</label>
                    <select id="stream" style="padding: 12px;">
                        <option value="science">Science (PCM/PCB)</option>
                        <option value="commerce">Commerce</option>
                        <option value="arts">Arts/Humanities</option>
                        <option value="diploma">Diploma</option>
                    </select>
                    <small>Select your stream for specialized analysis</small>
                </div>

                <h2 style="margin-top: 30px;">Career & College Goals</h2>
                
                <div class="form-group">
                    <label for="targetPercentage">Target Percentage/CGPA</label>
                    <input type="number" id="targetPercentage" min="0" max="100" step="0.1" value="90.0">
                    <small>Your desired overall percentage</small>
                </div>
                
                <div class="form-group">
                    <label for="competitiveExam">Target Competitive Exam</label>
                    <select id="competitiveExam" style="padding: 12px;">
                        <option value="jee">JEE Main/Advanced</option>
                        <option value="neet">NEET</option>
                        <option value="cuet">CUET</option>
                        <option value="clat">CLAT</option>
                        <option value="ca">CA Foundation</option>
                        <option value="none">None</option>
                    </select>
                    <small>Select your target competitive examination</small>
                </div>

                <button type="button" class="btn" onclick="calculateIndianGPA()">Calculate Academic Performance</button>
            </div>

            <div class="results-section">
                <h2>Indian Education Analysis</h2>
                
                <div class="result-card">
                    <h3>Current Year Percentage</h3>
                    <div class="amount" id="currentYearPercentage">85.5%</div>
                </div>

                <div class="indian-visual">
                    <div class="marksheet">
                        <div class="marksheet-board" id="boardName">CBSE BOARD</div>
                        <div style="font-size: 0.7rem; color: #666; margin-bottom: 10px;">OVERALL PERCENTAGE</div>
                        <div class="marksheet-percentage" id="marksheetPercentage">85.5%</div>
                        <div class="marksheet-division" id="marksheetDivision">FIRST DIVISION</div>
                    </div>
                    <div class="academic-level" id="academicLevel">Excellent Performance</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>CGPA (10-point)</h4>
                        <div class="value" id="cgpaValue">9.2</div>
                    </div>
                    <div class="metric-card">
                        <h4>Percentage</h4>
                        <div class="value" id="overallPercentage">85.5%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Grade</h4>
                        <div class="value" id="overallGrade">A1</div>
                    </div>
                </div>

                <div class="indian-grading-system">
                    <h4 style="color: #10ac84; margin-bottom: 10px;">Indian Grading System (CBSE)</h4>
                    <div class="grading-item">
                        <span>91-100%</span>
                        <strong>A1 (10 GPA)</strong>
                    </div>
                    <div class="grading-item">
                        <span>81-90%</span>
                        <strong>A2 (9 GPA)</strong>
                    </div>
                    <div class="grading-item">
                        <span>71-80%</span>
                        <strong>B1 (8 GPA)</strong>
                    </div>
                    <div class="grading-item">
                        <span>61-70%</span>
                        <strong>B2 (7 GPA)</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Academic Performance</h3>
                    <div class="breakdown-item">
                        <span>Total Marks Obtained</span>
                        <strong id="totalMarks">427/500</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Overall Percentage</span>
                        <strong id="displayPercentage">85.5%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Division</span>
                        <strong id="division">First Division</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Highest Subject</span>
                        <strong id="highestSubject">Mathematics (95%)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Performance Trend</span>
                        <strong id="performanceTrend">Improving ↗</strong>
                    </div>
                </div>

                <div class="indian-education-chart">
                    <h3>Subject-wise Performance</h3>
                    <div class="chart-container" id="subjectPerformanceChart">
                        <!-- Chart bars will be generated dynamically -->
                    </div>
                </div>

                <div class="indian-exam-plan">
                    <div class="exam-card">
                        <h4>Target Percentage Needed</h4>
                        <div class="exam-value" id="targetPercentageNeeded">92.5%</div>
                        <small>For next year</small>
                    </div>
                    <div class="exam-card">
                        <h4>Improvement Required</h4>
                        <div class="exam-value" id="improvementRequired">+7.0%</div>
                        <small>From current average</small>
                    </div>
                </div>

                <div class="indian-competitive-exams">
                    <h3>Competitive Exam Readiness</h3>
                    <div id="competitiveExamAnalysis">
                        <!-- Competitive exam analysis will be generated here -->
                    </div>
                </div>

                <div class="breakdown">
                    <h3>College Admission Chances</h3>
                    <div class="breakdown-item">
                        <span>DU Cutoff Eligibility</span>
                        <strong id="duEligibility">Top Colleges</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>IIT/JEE Preparation</span>
                        <strong id="jeePreparation">Good Foundation</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Medical (NEET) Readiness</span>
                        <strong id="neetReadiness">Strong Candidate</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Recommended Colleges</span>
                        <strong id="recommendedColleges">Tier 1 Universities</strong>
                    </div>
                </div>

                <div class="indian-scholarship-calculator">
                    <h3>Scholarship Opportunities (<span id="currencySymbol">₹</span>)</h3>
                    <div class="scholarship-item">
                        <span>National Scholarship</span>
                        <strong id="nationalScholarship">₹25,000/year</strong>
                    </div>
                    <div class="scholarship-item">
                        <span>State Government Scholarship</span>
                        <strong id="stateScholarship">₹15,000/year</strong>
                    </div>
                    <div class="scholarship-item">
                        <span>Private Institution Scholarship</span>
                        <strong id="privateScholarship">₹50,000+</strong>
                    </div>
                    <div class="scholarship-item">
                        <span>Total Scholarship Potential</span>
                        <strong id="totalScholarship">₹90,000+</strong>
                    </div>
                </div>

                <div class="indian-college-analysis">
                    <h3>College Fee Analysis (<span id="feeCurrencySymbol">₹</span>)</h3>
                    <div id="collegeFeeAnalysis">
                        <!-- College fee analysis will be generated here -->
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Academic Performance</h3>
                    <div class="breakdown-item" style="flex-direction: column; align-items: flex-start;">
                        <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 5px;">
                            <span>Overall Academic Score</span>
                            <strong id="academicScore">88%</strong>
                        </div>
                        <div class="progress-bar" style="width: 100%;">
                            <div class="progress-fill" id="academicScoreBar"></div>
                        </div>
                        <small style="margin-top: 5px;">Based on percentage, consistency, and subject balance</small>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Indian Education Tip:</strong> Focus on maintaining consistency across all subjects. For competitive exams like JEE/NEET, strong fundamentals in Class 11-12 are crucial. Balance board exam preparation with competitive exam coaching for optimal results.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🏫 Indian High School GPA Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced academic analysis for Indian education system with multi-currency support</p>
        </div>
    </div>

    <script>
        let academicYears = [
            {
                name: 'Class 11',
                subjects: [
                    { name: 'Physics', maxMarks: 100, marksObtained: 85, percentage: 85, grade: 'A2' },
                    { name: 'Chemistry', maxMarks: 100, marksObtained: 82, percentage: 82, grade: 'A2' },
                    { name: 'Mathematics', maxMarks: 100, marksObtained: 92, percentage: 92, grade: 'A1' },
                    { name: 'English', maxMarks: 100, marksObtained: 78, percentage: 78, grade: 'B1' },
                    { name: 'Computer Science', maxMarks: 100, marksObtained: 88, percentage: 88, grade: 'A2' }
                ]
            }
        ];

        let currentYearIndex = 0;
        let currentCurrency = 'INR';

        // Currency conversion rates (simplified)
        const currencyRates = {
            'INR': { symbol: '₹', rate: 1, name: 'Indian Rupee' },
            'USD': { symbol: '$', rate: 0.012, name: 'US Dollar' },
            'EUR': { symbol: '€', rate: 0.011, name: 'Euro' }
        };

        // Indian education board grading systems
        const gradingSystems = {
            'cbse': {
                name: 'CBSE',
                grades: {
                    'A1': { min: 91, max: 100, points: 10, description: 'Outstanding' },
                    'A2': { min: 81, max: 90, points: 9, description: 'Excellent' },
                    'B1': { min: 71, max: 80, points: 8, description: 'Very Good' },
                    'B2': { min: 61, max: 70, points: 7, description: 'Good' },
                    'C1': { min: 51, max: 60, points: 6, description: 'Fair' },
                    'C2': { min: 41, max: 50, points: 5, description: 'Average' },
                    'D': { min: 33, max: 40, points: 4, description: 'Below Average' },
                    'E1': { min: 21, max: 32, points: 0, description: 'Needs Improvement' },
                    'E2': { min: 0, max: 20, points: 0, description: 'Unsatisfactory' }
                }
            },
            'icse': {
                name: 'ICSE',
                grades: {
                    '1': { min: 90, max: 100, points: 10, description: 'Very Good' },
                    '2': { min: 80, max: 89, points: 9, description: 'Good' },
                    '3': { min: 70, max: 79, points: 8, description: 'Satisfactory' },
                    '4': { min: 60, max: 69, points: 7, description: 'Average' },
                    '5': { min: 50, max: 59, points: 6, description: 'Below Average' },
                    '6': { min: 40, max: 49, points: 5, description: 'Marginal' },
                    '7': { min: 0, max: 39, points: 4, description: 'Needs Improvement' }
                }
            }
        };

        // Common Indian subjects by stream
        const streamSubjects = {
            'science': ['Physics', 'Chemistry', 'Mathematics', 'Biology', 'Computer Science', 'English'],
            'commerce': ['Accountancy', 'Business Studies', 'Economics', 'Mathematics', 'English', 'Informatics Practices'],
            'arts': ['History', 'Political Science', 'Geography', 'Economics', 'Psychology', 'English']
        };

        function setCurrency(currency) {
            currentCurrency = currency;
            
            // Update visual feedback
            document.querySelectorAll('.currency-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Update currency symbols in the UI
            document.getElementById('currencySymbol').textContent = currencyRates[currency].symbol;
            document.getElementById('feeCurrencySymbol').textContent = currencyRates[currency].symbol;
            
            calculateIndianGPA();
        }

        function setEducationBoard(board) {
            document.getElementById('educationBoard').value = board;
            
            // Visual feedback
            document.querySelectorAll('.board-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateIndianGPA();
        }

        function initializeYearTabs() {
            const tabsContainer = document.getElementById('yearTabs');
            tabsContainer.innerHTML = '';
            
            academicYears.forEach((year, index) => {
                const tab = document.createElement('button');
                tab.className = `year-tab ${index === currentYearIndex ? 'active' : ''}`;
                tab.textContent = year.name;
                tab.onclick = () => switchAcademicYear(index);
                tabsContainer.appendChild(tab);
            });
        }

        function initializeSubjects() {
            const container = document.getElementById('courseContainer');
            container.innerHTML = '';
            
            const currentYear = academicYears[currentYearIndex];
            
            currentYear.subjects.forEach((subject, index) => {
                const percentage = ((subject.marksObtained / subject.maxMarks) * 100).toFixed(1);
                const grade = calculateGrade(percentage);
                
                const subjectItem = document.createElement('div');
                subjectItem.className = 'subject-item';
                subjectItem.innerHTML = `
                    <input type="text" class="course-input" value="${subject.name}" placeholder="Subject Name" onchange="updateSubject(${index}, 'name', this.value)">
                    <input type="number" class="course-input" value="${subject.maxMarks}" min="1" max="200" step="1" onchange="updateSubject(${index}, 'maxMarks', parseInt(this.value))">
                    <input type="number" class="course-input" value="${subject.marksObtained}" min="0" max="${subject.maxMarks}" step="1" onchange="updateSubject(${index}, 'marksObtained', parseInt(this.value))">
                    <input type="number" class="course-input" value="${percentage}" step="0.1" readonly>
                    <input type="text" class="course-input" value="${grade}" readonly>
                    <button class="remove-course" onclick="removeSubject(${index})">Remove</button>
                `;
                container.appendChild(subjectItem);
            });
        }

        function calculateGrade(percentage) {
            const board = document.getElementById('educationBoard').value;
            const gradingSystem = gradingSystems[board] || gradingSystems.cbse;
            
            for (const [grade, range] of Object.entries(gradingSystem.grades)) {
                if (percentage >= range.min && percentage <= range.max) {
                    return grade;
                }
            }
            return 'E2';
        }

        function switchAcademicYear(index) {
            currentYearIndex = index;
            initializeYearTabs();
            initializeSubjects();
            calculateIndianGPA();
        }

        function addAcademicYear() {
            const yearCount = academicYears.length;
            const classes = ['Class 9', 'Class 10', 'Class 11', 'Class 12'];
            const nextYear = {
                name: classes[Math.min(yearCount, 3)],
                subjects: [
                    { name: 'New Subject', maxMarks: 100, marksObtained: 75, percentage: 75, grade: 'B1' }
                ]
            };
            academicYears.push(nextYear);
            currentYearIndex = academicYears.length - 1;
            initializeYearTabs();
            initializeSubjects();
            calculateIndianGPA();
        }

        function addSubject() {
            academicYears[currentYearIndex].subjects.push({
                name: 'New Subject',
                maxMarks: 100,
                marksObtained: 75,
                percentage: 75,
                grade: 'B1'
            });
            initializeSubjects();
            calculateIndianGPA();
        }

        function removeSubject(index) {
            academicYears[currentYearIndex].subjects.splice(index, 1);
            initializeSubjects();
            calculateIndianGPA();
        }

        function updateSubject(index, field, value) {
            const subject = academicYears[currentYearIndex].subjects[index];
            subject[field] = value;
            
            // Recalculate percentage and grade
            if (field === 'marksObtained' || field === 'maxMarks') {
                subject.percentage = ((subject.marksObtained / subject.maxMarks) * 100).toFixed(1);
                subject.grade = calculateGrade(subject.percentage);
            }
            
            initializeSubjects();
            calculateIndianGPA();
        }

        function formatCurrency(amount) {
            const convertedAmount = amount * currencyRates[currentCurrency].rate;
            if (currentCurrency === 'INR') {
                return `${currencyRates[currentCurrency].symbol}${convertedAmount.toLocaleString('en-IN')}`;
            } else {
                return `${currencyRates[currentCurrency].symbol}${convertedAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            }
        }

        function calculateIndianGPA() {
            const board = document.getElementById('educationBoard').value;
            const previousPercentage = parseFloat(document.getElementById('previousPercentage').value) || 0;
            const targetPercentage = parseFloat(document.getElementById('targetPercentage').value);
            const currentClass = parseInt(document.getElementById('currentClass').value);
            const stream = document.getElementById('stream').value;
            const competitiveExam = document.getElementById('competitiveExam').value;

            // Calculate current year totals
            let totalMaxMarks = 0;
            let totalMarksObtained = 0;
            let totalGradePoints = 0;
            let subjectCount = 0;
            let highestSubject = { name: '', percentage: 0 };

            academicYears[currentYearIndex].subjects.forEach(subject => {
                totalMaxMarks += parseInt(subject.maxMarks);
                totalMarksObtained += parseInt(subject.marksObtained);
                totalGradePoints += gradingSystems[board].grades[subject.grade].points;
                subjectCount++;
                
                if (parseFloat(subject.percentage) > highestSubject.percentage) {
                    highestSubject = { name: subject.name, percentage: parseFloat(subject.percentage) };
                }
            });

            // Calculate percentages and CGPA
            const currentYearPercentage = (totalMarksObtained / totalMaxMarks) * 100;
            const cgpa = totalGradePoints / subjectCount;
            
            // Calculate cumulative percentage
            let overallPercentage = currentYearPercentage;
            if (previousPercentage > 0) {
                // Weighted average based on class progression
                const previousWeight = (currentClass - 9) / 4; // Classes 9-12
                const currentWeight = 1 - previousWeight;
                overallPercentage = (previousPercentage * previousWeight + currentYearPercentage * currentWeight);
            }

            // Determine division and performance
            let division = 'First Division';
            if (overallPercentage >= 60) division = 'First Division';
            else if (overallPercentage >= 45) division = 'Second Division';
            else if (overallPercentage >= 33) division = 'Third Division';
            else division = 'Fail';

            const performanceTrend = currentYearPercentage > previousPercentage ? 'Improving ↗' : 
                                   currentYearPercentage < previousPercentage ? 'Declining ↘' : 'Stable →';

            // Calculate target requirements
            const improvementRequired = Math.max(0, targetPercentage - overallPercentage);
            const targetPercentageNeeded = targetPercentage + improvementRequired * 0.5;

            // Competitive exam analysis
            let jeePreparation = 'Needs Focus';
            let neetReadiness = 'Needs Focus';
            let duEligibility = 'Limited Options';
            
            if (overallPercentage >= 95) {
                jeePreparation = 'Excellent Candidate';
                neetReadiness = 'Top Rank Potential';
                duEligibility = 'All Colleges Open';
            } else if (overallPercentage >= 85) {
                jeePreparation = 'Good Foundation';
                neetReadiness = 'Strong Candidate';
                duEligibility = 'Top Colleges';
            } else if (overallPercentage >= 75) {
                jeePreparation = 'Average Preparation';
                neetReadiness = 'Good Candidate';
                duEligibility = 'Good Colleges';
            }

            // Scholarship calculations in INR (converted later)
            const scholarshipAmounts = {
                national: 25000,
                state: 15000,
                private: 50000
            };

            // College fee analysis (annual fees in INR)
            const collegeFees = {
                'IITs': 200000,
                'NITs': 150000,
                'DU Colleges': 50000,
                'Private Universities': 300000,
                'State Universities': 25000
            };

            // Calculate academic score (0-100%)
            const percentageScore = (overallPercentage / 100) * 60;
            const consistencyScore = (currentYearPercentage / overallPercentage) * 20;
            const subjectBalanceScore = (highestSubject.percentage - (overallPercentage - 20)) * 1;
            const academicScore = Math.min(100, percentageScore + consistencyScore + Math.max(0, subjectBalanceScore));

            // Update UI with currency conversion
            document.getElementById('currentYearPercentage').textContent = currentYearPercentage.toFixed(1) + '%';
            document.getElementById('overallPercentage').textContent = overallPercentage.toFixed(1) + '%';
            document.getElementById('cgpaValue').textContent = cgpa.toFixed(1);
            document.getElementById('overallGrade').textContent = calculateGrade(overallPercentage);

            document.getElementById('marksheetPercentage').textContent = overallPercentage.toFixed(1) + '%';
            document.getElementById('marksheetDivision').textContent = division.toUpperCase();
            document.getElementById('boardName').textContent = board.toUpperCase() + ' BOARD';

            document.getElementById('totalMarks').textContent = `${totalMarksObtained}/${totalMaxMarks}`;
            document.getElementById('displayPercentage').textContent = overallPercentage.toFixed(1) + '%';
            document.getElementById('division').textContent = division;
            document.getElementById('highestSubject').textContent = `${highestSubject.name} (${highestSubject.percentage}%)`;
            document.getElementById('performanceTrend').textContent = performanceTrend;

            document.getElementById('targetPercentageNeeded').textContent = targetPercentageNeeded.toFixed(1) + '%';
            document.getElementById('improvementRequired').textContent = `+${improvementRequired.toFixed(1)}%`;

            document.getElementById('jeePreparation').textContent = jeePreparation;
            document.getElementById('neetReadiness').textContent = neetReadiness;
            document.getElementById('duEligibility').textContent = duEligibility;
            document.getElementById('recommendedColleges').textContent = overallPercentage >= 85 ? 'Tier 1 Universities' : 'Tier 2 Universities';

            document.getElementById('nationalScholarship').textContent = formatCurrency(scholarshipAmounts.national) + '/year';
            document.getElementById('stateScholarship').textContent = formatCurrency(scholarshipAmounts.state) + '/year';
            document.getElementById('privateScholarship').textContent = formatCurrency(scholarshipAmounts.private) + '+';
            document.getElementById('totalScholarship').textContent = formatCurrency(scholarshipAmounts.national + scholarshipAmounts.state + scholarshipAmounts.private) + '+';

            // Update visual elements
            updateAcademicLevel(overallPercentage);
            updateAcademicScore(academicScore);
            generateSubjectPerformanceChart();
            updateCompetitiveExamAnalysis(competitiveExam, overallPercentage);
            updateCollegeFeeAnalysis(collegeFees);
        }

        function updateAcademicLevel(percentage) {
            const levelElement = document.getElementById('academicLevel');
            let level = '';
            
            if (percentage >= 90) level = 'Outstanding Performance 🏆';
            else if (percentage >= 80) level = 'Excellent Performance ⭐';
            else if (percentage >= 70) level = 'Very Good Performance 👍';
            else if (percentage >= 60) level = 'Good Performance ✅';
            else if (percentage >= 33) level = 'Passing Performance 📚';
            else level = 'Needs Improvement 💪';
            
            levelElement.textContent = level;
            
            // Change color based on performance
            if (percentage >= 80) {
                levelElement.style.color = '#27ae60';
            } else if (percentage >= 60) {
                levelElement.style.color = '#f39c12';
            } else {
                levelElement.style.color = '#e74c3c';
            }
        }

        function updateAcademicScore(score) {
            const scoreBar = document.getElementById('academicScoreBar');
            const scoreText = document.getElementById('academicScore');
            
            scoreBar.style.width = '0%';
            scoreText.textContent = '0%';
            
            setTimeout(() => {
                scoreBar.style.width = score + '%';
                scoreText.textContent = Math.round(score) + '%';
                
                // Change color based on score
                if (score >= 85) {
                    scoreBar.style.background = 'linear-gradient(90deg, #27ae60 0%, #2ecc71 100%)';
                } else if (score >= 70) {
                    scoreBar.style.background = 'linear-gradient(90deg, #f39c12 0%, #f1c40f 100%)';
                } else {
                    scoreBar.style.background = 'linear-gradient(90deg, #e74c3c 0%, #c0392b 100%)';
                }
            }, 100);
        }

        function generateSubjectPerformanceChart() {
            const chartContainer = document.getElementById('subjectPerformanceChart');
            chartContainer.innerHTML = '';
            
            const currentYear = academicYears[currentYearIndex];
            const maxPercentage = Math.max(...currentYear.subjects.map(s => parseFloat(s.percentage)), 100);
            
            currentYear.subjects.forEach((subject, index) => {
                const percentage = parseFloat(subject.percentage);
                const height = (percentage / maxPercentage) * 100;
                
                const bar = document.createElement('div');
                bar.className = 'chart-bar';
                bar.style.height = '0%';
                
                const valueLabel = document.createElement('div');
                valueLabel.className = 'chart-value';
                valueLabel.textContent = `${percentage}%`;
                
                const subjectLabel = document.createElement('div');
                subjectLabel.className = 'chart-label';
                subjectLabel.textContent = subject.name.split(' ')[0]; // Shorten name
                
                chartContainer.appendChild(bar);
                chartContainer.appendChild(valueLabel);
                chartContainer.appendChild(subjectLabel);
                
                // Animate bar growth
                setTimeout(() => {
                    bar.style.height = `${height}%`;
                }, index * 200);
            });
        }

        function updateCompetitiveExamAnalysis(exam, percentage) {
            const container = document.getElementById('competitiveExamAnalysis');
            container.innerHTML = '';
            
            const examRequirements = {
                'jee': { minPercentage: 75, recommended: 85, preparation: 'Focus on Mathematics and Physics' },
                'neet': { minPercentage: 50, recommended: 80, preparation: 'Strong Biology and Chemistry needed' },
                'cuet': { minPercentage: 60, recommended: 75, preparation: 'Well-rounded preparation required' },
                'clat': { minPercentage: 45, recommended: 70, preparation: 'Focus on Legal Aptitude and English' },
                'ca': { minPercentage: 50, recommended: 65, preparation: 'Strong Accounting fundamentals needed' }
            };
            
            const requirement = examRequirements[exam] || { minPercentage: 0, recommended: 0, preparation: 'General preparation recommended' };
            
            const analysisItems = [
                { name: 'Minimum Percentage Required', value: `${requirement.minPercentage}%`, met: percentage >= requirement.minPercentage },
                { name: 'Recommended Percentage', value: `${requirement.recommended}%`, met: percentage >= requirement.recommended },
                { name: 'Current Status', value: percentage >= requirement.recommended ? 'Well Prepared' : 'Needs Improvement', met: percentage >= requirement.recommended },
                { name: 'Preparation Focus', value: requirement.preparation, met: true }
            ];
            
            analysisItems.forEach(item => {
                const examItem = document.createElement('div');
                examItem.className = 'exam-item';
                examItem.innerHTML = `
                    <span>${item.name}</span>
                    <strong style="color: ${item.met ? '#27ae60' : '#e74c3c'}">${item.value}</strong>
                `;
                container.appendChild(examItem);
            });
        }

        function updateCollegeFeeAnalysis(fees) {
            const container = document.getElementById('collegeFeeAnalysis');
            container.innerHTML = '';
            
            Object.entries(fees).forEach(([college, fee]) => {
                const feeItem = document.createElement('div');
                feeItem.className = 'college-item';
                feeItem.innerHTML = `
                    <span>${college}</span>
                    <strong>${formatCurrency(fee)}/year</strong>
                `;
                container.appendChild(feeItem);
            });
        }

        // Initialize
        window.addEventListener('load', function() {
            initializeYearTabs();
            initializeSubjects();
            calculateIndianGPA();
        });
    </script>
</body>
</html>
