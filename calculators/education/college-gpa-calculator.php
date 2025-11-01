<?php
/**
 * College GPA Calculator
 * File: education/college-gpa-calculator.php
 * Description: Advanced calculator for college GPA calculation, major requirements, and academic planning
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College GPA Calculator - University Grade Point Average & Major Planning</title>
    <meta name="description" content="Advanced college GPA calculator. Calculate cumulative GPA, track major requirements, and plan for graduation.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #8e44ad 0%, #3498db 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #8e44ad; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #8e44ad; box-shadow: 0 0 0 3px rgba(142, 68, 173, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #8e44ad 0%, #3498db 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(142, 68, 173, 0.3); }
        .btn-secondary { background: linear-gradient(135deg, #9b59b6 0%, #2980b9 100%); margin-top: 10px; }
        .btn-major { background: linear-gradient(135deg, #e74c3c 0%, #e67e22 100%); }
        
        .result-card { background: linear-gradient(135deg, #8e44ad 0%, #3498db 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(142, 68, 173, 0.3); position: relative; overflow: hidden; }
        .result-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 0.8; } }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; position: relative; z-index: 1; }
        .result-card .amount { font-size: 3rem; font-weight: bold; position: relative; z-index: 1; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #8e44ad; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #8e44ad; font-size: 1.8rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #8e44ad; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .progress-bar { background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #8e44ad 0%, #3498db 100%); width: 0%; transition: width 1s ease-out; }
        
        .info-box { background: #f4ecf7; border-left: 4px solid #8e44ad; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #8e44ad; }
        
        .semester-tabs { display: flex; gap: 5px; margin-bottom: 20px; flex-wrap: wrap; }
        .semester-tab { padding: 10px 15px; background: #f0f0f0; border: none; border-radius: 6px; cursor: pointer; transition: all 0.3s; }
        .semester-tab.active { background: #8e44ad; color: white; }
        .semester-tab:hover { background: #9b59b6; color: white; }
        
        .course-list { max-height: 400px; overflow-y: auto; border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
        .course-item { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr auto; gap: 8px; align-items: center; padding: 10px; border-bottom: 1px solid #e0e0e0; }
        .course-item:last-child { border-bottom: none; }
        .course-item-header { font-weight: 600; color: #8e44ad; padding-bottom: 10px; border-bottom: 2px solid #8e44ad; }
        .course-input { padding: 6px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 14px; }
        .remove-course { background: #ff6b6b; color: white; border: none; border-radius: 4px; padding: 4px 8px; cursor: pointer; font-size: 12px; }
        
        .major-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 8px; margin-top: 10px; }
        .major-btn { padding: 8px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .major-btn:hover { background: #8e44ad; color: white; border-color: #8e44ad; }
        .major-btn.active { background: #8e44ad; color: white; border-color: #8e44ad; }
        
        .college-visual { display: flex; flex-direction: column; align-items: center; margin: 20px 0; }
        .diploma { width: 220px; height: 160px; background: #f8f9fa; border: 3px solid #8e44ad; border-radius: 8px; position: relative; padding: 20px; text-align: center; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .diploma::before { content: ''; position: absolute; top: -10px; left: -10px; right: -10px; bottom: -10px; border: 2px solid #3498db; border-radius: 12px; opacity: 0.3; }
        .diploma-university { font-size: 0.9rem; color: #8e44ad; font-weight: 600; margin-bottom: 5px; }
        .diploma-gpa { font-size: 2rem; font-weight: bold; color: #8e44ad; margin: 10px 0; }
        .diploma-honors { font-size: 0.8rem; color: #666; }
        .graduation-level { font-size: 1.2rem; font-weight: bold; color: #8e44ad; }
        
        .requirements-chart { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .chart-container { height: 200px; position: relative; margin: 20px 0; }
        .chart-section { position: absolute; bottom: 0; background: linear-gradient(to top, #8e44ad, #3498db); border-radius: 4px 4px 0 0; transition: height 1s ease-out; }
        .chart-label { position: absolute; bottom: -25px; text-align: center; font-size: 0.8rem; color: #666; width: 100%; }
        
        .graduation-plan { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
        .plan-card { background: white; padding: 15px; border-radius: 8px; border: 2px solid #e0e0e0; text-align: center; }
        .plan-card h4 { color: #666; margin-bottom: 10px; font-size: 0.9rem; }
        .plan-value { font-size: 1.5rem; font-weight: bold; color: #8e44ad; }
        
        .scholarship-calculator { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .scholarship-item { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0; }
        .scholarship-item:last-child { border-bottom: none; margin-bottom: 0; }
        
        .major-breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .major-item { display: flex; justify-content: space-between; margin-bottom: 8px; padding: 8px; background: white; border-radius: 4px; border-left: 4px solid #8e44ad; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
            .graduation-plan { grid-template-columns: 1fr; }
            .course-item { grid-template-columns: 1fr 1fr; gap: 5px; }
            .course-item-header { display: none; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .major-preset { grid-template-columns: repeat(2, 1fr); }
            .semester-tabs { justify-content: center; }
            .course-item { grid-template-columns: 1fr; text-align: center; }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
            .diploma { width: 180px; height: 140px; padding: 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎓 College GPA Calculator</h1>
            <p>University Grade Tracking, Major Requirements & Graduation Planning</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Academic Information</h2>
                
                <div class="form-group">
                    <label for="collegeType">College/University Type</label>
                    <select id="collegeType" style="padding: 12px;">
                        <option value="semester">Semester System</option>
                        <option value="quarter">Quarter System</option>
                        <option value="trimester">Trimester System</option>
                    </select>
                    <small>Your institution's academic calendar system</small>
                </div>
                
                <div class="form-group">
                    <label for="gradingScale">Grading Scale</label>
                    <select id="gradingScale" style="padding: 12px;">
                        <option value="4.0" selected>4.0 Scale (Standard)</option>
                        <option value="4.3">4.3 Scale</option>
                        <option value="4.5">4.5 Scale</option>
                        <option value="5.0">5.0 Scale (Weighted)</option>
                        <option value="100">Percentage Scale</option>
                    </select>
                    <small>Select your institution's grading system</small>
                </div>

                <div class="form-group">
                    <label>Academic Major</label>
                    <div class="major-preset">
                        <div class="major-btn" onclick="setMajor('engineering')">Engineering</div>
                        <div class="major-btn" onclick="setMajor('business')">Business</div>
                        <div class="major-btn" onclick="setMajor('sciences')">Sciences</div>
                        <div class="major-btn" onclick="setMajor('arts')">Arts & Humanities</div>
                        <div class="major-btn" onclick="setMajor('premed')">Pre-Med</div>
                        <div class="major-btn" onclick="setMajor('custom')">Custom</div>
                    </div>
                    <small>Select your academic major for requirement tracking</small>
                </div>

                <div class="form-group">
                    <label for="currentStanding">Current Academic Standing</label>
                    <select id="currentStanding" style="padding: 12px;">
                        <option value="freshman">Freshman (0-29 credits)</option>
                        <option value="sophomore">Sophomore (30-59 credits)</option>
                        <option value="junior" selected>Junior (60-89 credits)</option>
                        <option value="senior">Senior (90+ credits)</option>
                        <option value="grad">Graduate Student</option>
                    </select>
                    <small>Your current year in college</small>
                </div>

                <h3>Semester Management</h3>
                <div class="semester-tabs" id="semesterTabs">
                    <!-- Semester tabs will be generated here -->
                </div>

                <div class="course-list">
                    <div class="course-item course-item-header">
                        <div>Course Name</div>
                        <div>Credits</div>
                        <div>Grade</div>
                        <div>Type</div>
                        <div>Grade Points</div>
                        <div>Action</div>
                    </div>
                    <div id="courseContainer">
                        <!-- Course items will be generated here -->
                    </div>
                </div>

                <button class="btn btn-secondary" onclick="addCourse()">+ Add Course</button>
                <button class="btn btn-major" onclick="addSemester()" style="margin-top: 10px;">+ Add Semester</button>

                <div class="form-group">
                    <label for="currentCumulativeGPA">Current Cumulative GPA</label>
                    <input type="number" id="currentCumulativeGPA" min="0" max="5" step="0.01" placeholder="e.g., 3.45">
                    <small>Your overall GPA before current semester</small>
                </div>
                
                <div class="form-group">
                    <label for="totalCompletedCredits">Total Completed Credits</label>
                    <input type="number" id="totalCompletedCredits" min="0" step="1" placeholder="e.g., 75">
                    <small>Total credit hours completed so far</small>
                </div>

                <h2 style="margin-top: 30px;">Graduation Goals</h2>
                
                <div class="form-group">
                    <label for="targetGPA">Target Graduation GPA</label>
                    <input type="number" id="targetGPA" min="0" max="5" step="0.01" value="3.5">
                    <small>Your desired cumulative GPA at graduation</small>
                </div>
                
                <div class="form-group">
                    <label for="remainingCredits">Remaining Credits to Graduate</label>
                    <input type="number" id="remainingCredits" min="0" step="1" value="45">
                    <small>Credit hours needed to complete your degree</small>
                </div>

                <button type="button" class="btn" onclick="calculateCollegeGPA()">Calculate College GPA</button>
            </div>

            <div class="results-section">
                <h2>College GPA Analysis</h2>
                
                <div class="result-card">
                    <h3>Current Semester GPA</h3>
                    <div class="amount" id="semesterGPA">3.75</div>
                </div>

                <div class="college-visual">
                    <div class="diploma">
                        <div class="diploma-university" id="universityName">UNIVERSITY OF EXCELLENCE</div>
                        <div style="font-size: 0.7rem; color: #666; margin-bottom: 10px;">CUMULATIVE GPA</div>
                        <div class="diploma-gpa" id="diplomaGPA">3.68</div>
                        <div class="diploma-honors" id="diplomaHonors">CUM LAUDE HONORS</div>
                    </div>
                    <div class="graduation-level" id="graduationLevel">On Track for Honors</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Cumulative GPA</h4>
                        <div class="value" id="cumulativeGPA">3.68</div>
                    </div>
                    <div class="metric-card">
                        <h4>Major GPA</h4>
                        <div class="value" id="majorGPA">3.82</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Credits</h4>
                        <div class="value" id="totalCredits">90</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Academic Progress</h3>
                    <div class="breakdown-item">
                        <span>Credits Completed</span>
                        <strong id="creditsCompleted">90/120</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Progress to Degree</span>
                        <strong id="degreeProgress">75%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Estimated Graduation</span>
                        <strong id="estimatedGraduation">1.5 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Academic Standing</span>
                        <strong id="academicStanding">Good Standing</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Dean's List Status</span>
                        <strong id="deansListStatus">Eligible</strong>
                    </div>
                </div>

                <div class="requirements-chart">
                    <h3>Degree Requirements Progress</h3>
                    <div class="chart-container" id="requirementsChart">
                        <!-- Chart sections will be generated dynamically -->
                    </div>
                </div>

                <div class="graduation-plan">
                    <div class="plan-card">
                        <h4>GPA Needed to Reach Target</h4>
                        <div class="plan-value" id="gpaNeeded">3.82</div>
                        <small>For remaining courses</small>
                    </div>
                    <div class="plan-card">
                        <h4>Improvement Required</h4>
                        <div class="plan-value" id="improvementRequired">+0.14</div>
                        <small>From current average</small>
                    </div>
                </div>

                <div class="major-breakdown">
                    <h3>Major Requirements Status</h3>
                    <div id="majorRequirements">
                        <!-- Major requirements will be generated dynamically -->
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Honors & Awards Projection</h3>
                    <div class="breakdown-item">
                        <span>Current Honors Level</span>
                        <strong id="currentHonors">Cum Laude</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Projected Honors</span>
                        <strong id="projectedHonors">Magna Cum Laude</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Honors GPA Requirement</span>
                        <strong id="honorsRequirement">3.70</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Scholarship Eligibility</span>
                        <strong id="scholarshipEligibility">Maintained</strong>
                    </div>
                </div>

                <div class="scholarship-calculator">
                    <h3>Scholarship Impact Analysis</h3>
                    <div class="scholarship-item">
                        <span>Current Scholarship Status</span>
                        <strong id="currentScholarship">Full Tuition</strong>
                    </div>
                    <div class="scholarship-item">
                        <span>Minimum GPA Required</span>
                        <strong id="scholarshipRequirement">3.20</strong>
                    </div>
                    <div class="scholarship-item">
                        <span>Renewal Probability</span>
                        <strong id="renewalProbability">98%</strong>
                    </div>
                    <div class="scholarship-item">
                        <span>Potential Scholarship Loss</span>
                        <strong id="scholarshipLoss">$0</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Academic Performance</h3>
                    <div class="breakdown-item" style="flex-direction: column; align-items: flex-start;">
                        <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 5px;">
                            <span>Overall Academic Health</span>
                            <strong id="academicHealth">92%</strong>
                        </div>
                        <div class="progress-bar" style="width: 100%;">
                            <div class="progress-fill" id="academicHealthBar"></div>
                        </div>
                        <small style="margin-top: 5px;">Based on GPA progression, credit completion, and major requirements</small>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>College Success Tip:</strong> Maintain at least a 3.0 GPA for most graduate programs and competitive jobs. Balance your course load between challenging major requirements and manageable electives. Meet with your academic advisor each semester to ensure you're on track for graduation.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🎓 College GPA Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced university academic planning and performance analysis</p>
        </div>
    </div>

    <script>
        let semesters = [
            {
                name: 'Fall 2024',
                courses: [
                    { name: 'Calculus III', credits: 4, grade: 'A', type: 'major', points: 4.0 },
                    { name: 'Physics II', credits: 4, grade: 'A-', type: 'major', points: 3.7 },
                    { name: 'Computer Science', credits: 3, grade: 'B+', type: 'major', points: 3.3 },
                    { name: 'History Elective', credits: 3, grade: 'A', type: 'general', points: 4.0 },
                    { name: 'Research Methods', credits: 2, grade: 'B', type: 'major', points: 3.0 }
                ]
            }
        ];

        let currentSemesterIndex = 0;

        // Grade scale mappings
        const gradeScales = {
            '4.0': {
                'A+': 4.0, 'A': 4.0, 'A-': 3.7,
                'B+': 3.3, 'B': 3.0, 'B-': 2.7,
                'C+': 2.3, 'C': 2.0, 'C-': 1.7,
                'D+': 1.3, 'D': 1.0, 'D-': 0.7,
                'F': 0.0
            },
            '4.3': {
                'A+': 4.3, 'A': 4.0, 'A-': 3.7,
                'B+': 3.3, 'B': 3.0, 'B-': 2.7,
                'C+': 2.3, 'C': 2.0, 'C-': 1.7,
                'D+': 1.3, 'D': 1.0, 'D-': 0.7,
                'F': 0.0
            },
            '4.5': {
                'A+': 4.5, 'A': 4.0, 'A-': 3.7,
                'B+': 3.3, 'B': 3.0, 'B-': 2.7,
                'C+': 2.3, 'C': 2.0, 'C-': 1.7,
                'D+': 1.3, 'D': 1.0, 'D-': 0.7,
                'F': 0.0
            },
            '5.0': {
                'A+': 5.0, 'A': 5.0, 'A-': 4.7,
                'B+': 4.3, 'B': 4.0, 'B-': 3.7,
                'C+': 3.3, 'C': 3.0, 'C-': 2.7,
                'D+': 2.3, 'D': 2.0, 'D-': 1.7,
                'F': 0.0
            },
            '100': {
                'A+': 4.0, 'A': 4.0, 'A-': 3.7,
                'B+': 3.3, 'B': 3.0, 'B-': 2.7,
                'C+': 2.3, 'C': 2.0, 'C-': 1.7,
                'D+': 1.3, 'D': 1.0, 'D-': 0.7,
                'F': 0.0
            }
        };

        // Major requirements
        const majorRequirements = {
            'engineering': {
                totalCredits: 120,
                majorCredits: 60,
                mathCredits: 16,
                scienceCredits: 16,
                electiveCredits: 28
            },
            'business': {
                totalCredits: 120,
                majorCredits: 45,
                mathCredits: 12,
                scienceCredits: 8,
                electiveCredits: 55
            },
            'sciences': {
                totalCredits: 120,
                majorCredits: 50,
                mathCredits: 12,
                scienceCredits: 20,
                electiveCredits: 38
            },
            'arts': {
                totalCredits: 120,
                majorCredits: 40,
                mathCredits: 6,
                scienceCredits: 8,
                electiveCredits: 66
            },
            'premed': {
                totalCredits: 120,
                majorCredits: 35,
                mathCredits: 8,
                scienceCredits: 32,
                electiveCredits: 45
            },
            'custom': {
                totalCredits: 120,
                majorCredits: 45,
                mathCredits: 12,
                scienceCredits: 12,
                electiveCredits: 51
            }
        };

        // Letter grade options
        const gradeOptions = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'F'];
        const courseTypes = ['major', 'general', 'math', 'science', 'elective'];

        function initializeSemesterTabs() {
            const tabsContainer = document.getElementById('semesterTabs');
            tabsContainer.innerHTML = '';
            
            semesters.forEach((semester, index) => {
                const tab = document.createElement('button');
                tab.className = `semester-tab ${index === currentSemesterIndex ? 'active' : ''}`;
                tab.textContent = semester.name;
                tab.onclick = () => switchSemester(index);
                tabsContainer.appendChild(tab);
            });
        }

        function initializeCourses() {
            const container = document.getElementById('courseContainer');
            container.innerHTML = '';
            
            const currentSemester = semesters[currentSemesterIndex];
            
            currentSemester.courses.forEach((course, index) => {
                const courseItem = document.createElement('div');
                courseItem.className = 'course-item';
                courseItem.innerHTML = `
                    <input type="text" class="course-input" value="${course.name}" placeholder="Course Name" onchange="updateCourse(${index}, 'name', this.value)">
                    <input type="number" class="course-input" value="${course.credits}" min="0.5" max="10" step="0.5" onchange="updateCourse(${index}, 'credits', parseFloat(this.value))">
                    <select class="course-input" onchange="updateCourse(${index}, 'grade', this.value)">
                        ${gradeOptions.map(grade => 
                            `<option value="${grade}" ${grade === course.grade ? 'selected' : ''}>${grade}</option>`
                        ).join('')}
                    </select>
                    <select class="course-input" onchange="updateCourse(${index}, 'type', this.value)">
                        ${courseTypes.map(type => 
                            `<option value="${type}" ${type === course.type ? 'selected' : ''}>${type.charAt(0).toUpperCase() + type.slice(1)}</option>`
                        ).join('')}
                    </select>
                    <input type="number" class="course-input" value="${course.points.toFixed(1)}" step="0.1" readonly>
                    <button class="remove-course" onclick="removeCourse(${index})">Remove</button>
                `;
                container.appendChild(courseItem);
            });
        }

        function switchSemester(index) {
            currentSemesterIndex = index;
            initializeSemesterTabs();
            initializeCourses();
            calculateCollegeGPA();
        }

        function addSemester() {
            const semesterCount = semesters.length;
            const nextSemester = {
                name: `Semester ${semesterCount + 1}`,
                courses: [
                    { name: 'New Course', credits: 3, grade: 'B', type: 'general', points: 3.0 }
                ]
            };
            semesters.push(nextSemester);
            currentSemesterIndex = semesters.length - 1;
            initializeSemesterTabs();
            initializeCourses();
            calculateCollegeGPA();
        }

        function addCourse() {
            semesters[currentSemesterIndex].courses.push({
                name: 'New Course',
                credits: 3,
                grade: 'B',
                type: 'general',
                points: 3.0
            });
            initializeCourses();
            calculateCollegeGPA();
        }

        function removeCourse(index) {
            semesters[currentSemesterIndex].courses.splice(index, 1);
            initializeCourses();
            calculateCollegeGPA();
        }

        function updateCourse(index, field, value) {
            const course = semesters[currentSemesterIndex].courses[index];
            course[field] = value;
            
            // Update grade points if grade changed
            if (field === 'grade') {
                const scale = document.getElementById('gradingScale').value;
                course.points = gradeScales[scale][value] || 0;
            }
            
            initializeCourses();
            calculateCollegeGPA();
        }

        function setMajor(major) {
            // Visual feedback
            document.querySelectorAll('.major-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            calculateCollegeGPA();
        }

        function calculateCollegeGPA() {
            const gradingScale = document.getElementById('gradingScale').value;
            const currentCumulativeGPA = parseFloat(document.getElementById('currentCumulativeGPA').value) || 0;
            const totalCompletedCredits = parseFloat(document.getElementById('totalCompletedCredits').value) || 0;
            const targetGPA = parseFloat(document.getElementById('targetGPA').value);
            const remainingCredits = parseFloat(document.getElementById('remainingCredits').value);
            const currentStanding = document.getElementById('currentStanding').value;
            const selectedMajor = document.querySelector('.major-btn.active')?.textContent.toLowerCase() || 'engineering';

            // Calculate current semester totals
            let semesterCredits = 0;
            let semesterQualityPoints = 0;
            let majorCredits = 0;
            let majorQualityPoints = 0;

            semesters[currentSemesterIndex].courses.forEach(course => {
                const credits = parseFloat(course.credits);
                const points = parseFloat(course.points);
                
                semesterCredits += credits;
                semesterQualityPoints += credits * points;
                
                if (course.type === 'major') {
                    majorCredits += credits;
                    majorQualityPoints += credits * points;
                }
            });

            // Calculate GPAs
            const semesterGPA = semesterCredits > 0 ? semesterQualityPoints / semesterCredits : 0;
            const majorGPA = majorCredits > 0 ? majorQualityPoints / majorCredits : 0;
            
            // Calculate cumulative GPA including previous credits
            let cumulativeGPA = semesterGPA;
            let totalCreditsCompleted = semesterCredits;
            
            if (totalCompletedCredits > 0) {
                const previousQualityPoints = currentCumulativeGPA * totalCompletedCredits;
                cumulativeGPA = (previousQualityPoints + semesterQualityPoints) / (totalCompletedCredits + semesterCredits);
                totalCreditsCompleted = totalCompletedCredits + semesterCredits;
            }

            // Calculate graduation requirements
            const requirements = majorRequirements[selectedMajor];
            const creditsRemaining = Math.max(0, requirements.totalCredits - totalCreditsCompleted);
            const degreeProgress = (totalCreditsCompleted / requirements.totalCredits) * 100;
            const estimatedGraduation = (creditsRemaining / 15).toFixed(1); // Assuming 15 credits per semester

            // Calculate target requirements
            const futureQualityPointsNeeded = targetGPA * (totalCreditsCompleted + remainingCredits) - (cumulativeGPA * totalCreditsCompleted);
            const gpaNeeded = remainingCredits > 0 ? Math.max(0, futureQualityPointsNeeded / remainingCredits) : 0;
            const improvementRequired = Math.max(0, gpaNeeded - cumulativeGPA);

            // Determine academic standing and honors
            const academicStanding = cumulativeGPA >= 2.0 ? 'Good Standing' : cumulativeGPA >= 1.5 ? 'Academic Warning' : 'Academic Probation';
            const deansListStatus = semesterGPA >= 3.5 ? 'Eligible' : 'Not Eligible';
            
            let currentHonors = 'No Honors';
            let projectedHonors = 'No Honors';
            if (cumulativeGPA >= 3.9) currentHonors = 'Summa Cum Laude';
            else if (cumulativeGPA >= 3.7) currentHonors = 'Magna Cum Laude';
            else if (cumulativeGPA >= 3.5) currentHonors = 'Cum Laude';

            if (targetGPA >= 3.9) projectedHonors = 'Summa Cum Laude';
            else if (targetGPA >= 3.7) projectedHonors = 'Magna Cum Laude';
            else if (targetGPA >= 3.5) projectedHonors = 'Cum Laude';

            // Scholarship analysis
            const scholarshipRequirement = 3.2;
            const renewalProbability = cumulativeGPA >= scholarshipRequirement ? 98 : Math.max(0, (cumulativeGPA / scholarshipRequirement) * 100);
            const scholarshipLoss = cumulativeGPA >= scholarshipRequirement ? '$0' : '$15,000 per year';

            // Calculate academic health score (0-100%)
            const gpaScore = (cumulativeGPA / 4.0) * 40;
            const progressScore = (degreeProgress / 100) * 30;
            const consistencyScore = (majorGPA / cumulativeGPA) * 30;
            const academicHealth = Math.min(100, gpaScore + progressScore + consistencyScore);

            // Update UI
            document.getElementById('semesterGPA').textContent = semesterGPA.toFixed(2);
            document.getElementById('cumulativeGPA').textContent = cumulativeGPA.toFixed(2);
            document.getElementById('majorGPA').textContent = majorGPA.toFixed(2);
            document.getElementById('totalCredits').textContent = totalCreditsCompleted;

            document.getElementById('diplomaGPA').textContent = cumulativeGPA.toFixed(2);
            document.getElementById('diplomaHonors').textContent = currentHonors.toUpperCase();

            document.getElementById('creditsCompleted').textContent = `${totalCreditsCompleted}/${requirements.totalCredits}`;
            document.getElementById('degreeProgress').textContent = `${degreeProgress.toFixed(0)}%`;
            document.getElementById('estimatedGraduation').textContent = `${estimatedGraduation} years`;
            document.getElementById('academicStanding').textContent = academicStanding;
            document.getElementById('deansListStatus').textContent = deansListStatus;

            document.getElementById('gpaNeeded').textContent = gpaNeeded.toFixed(2);
            document.getElementById('improvementRequired').textContent = `+${improvementRequired.toFixed(2)}`;

            document.getElementById('currentHonors').textContent = currentHonors;
            document.getElementById('projectedHonors').textContent = projectedHonors;
            document.getElementById('honorsRequirement').textContent = '3.70';

            document.getElementById('currentScholarship').textContent = 'Full Tuition';
            document.getElementById('scholarshipRequirement').textContent = scholarshipRequirement.toFixed(2);
            document.getElementById('renewalProbability').textContent = `${renewalProbability.toFixed(0)}%`;
            document.getElementById('scholarshipLoss').textContent = scholarshipLoss;

            // Update visual elements
            updateGraduationLevel(cumulativeGPA);
            updateAcademicHealth(academicHealth);
            generateRequirementsChart(requirements, totalCreditsCompleted);
            updateMajorRequirements(requirements, totalCreditsCompleted);
        }

        function updateGraduationLevel(gpa) {
            const levelElement = document.getElementById('graduationLevel');
            let level = '';
            
            if (gpa >= 3.7) level = 'On Track for High Honors';
            else if (gpa >= 3.3) level = 'On Track for Honors';
            else if (gpa >= 3.0) level = 'On Track for Graduation';
            else if (gpa >= 2.0) level = 'At Risk - Improve GPA';
            else level = 'Academic Warning - Seek Advisor';
            
            levelElement.textContent = level;
            
            // Change color based on status
            if (gpa >= 3.3) {
                levelElement.style.color = '#27ae60';
            } else if (gpa >= 2.0) {
                levelElement.style.color = '#f39c12';
            } else {
                levelElement.style.color = '#e74c3c';
            }
        }

        function updateAcademicHealth(score) {
            const healthBar = document.getElementById('academicHealthBar');
            const healthText = document.getElementById('academicHealth');
            
            healthBar.style.width = '0%';
            healthText.textContent = '0%';
            
            setTimeout(() => {
                healthBar.style.width = score + '%';
                healthText.textContent = Math.round(score) + '%';
                
                // Change color based on score
                if (score >= 85) {
                    healthBar.style.background = 'linear-gradient(90deg, #27ae60 0%, #2ecc71 100%)';
                } else if (score >= 70) {
                    healthBar.style.background = 'linear-gradient(90deg, #f39c12 0%, #f1c40f 100%)';
                } else {
                    healthBar.style.background = 'linear-gradient(90deg, #e74c3c 0%, #c0392b 100%)';
                }
            }, 100);
        }

        function generateRequirementsChart(requirements, completedCredits) {
            const chartContainer = document.getElementById('requirementsChart');
            chartContainer.innerHTML = '';
            
            const categories = [
                { name: 'Major Courses', required: requirements.majorCredits, completed: Math.min(completedCredits * 0.5, requirements.majorCredits) },
                { name: 'Math/Science', required: requirements.mathCredits + requirements.scienceCredits, completed: Math.min(completedCredits * 0.2, requirements.mathCredits + requirements.scienceCredits) },
                { name: 'Electives', required: requirements.electiveCredits, completed: Math.min(completedCredits * 0.3, requirements.electiveCredits) }
            ];
            
            const maxRequired = Math.max(...categories.map(cat => cat.required));
            const barWidth = 30;
            
            categories.forEach((category, index) => {
                const completedHeight = (category.completed / category.required) * 100;
                const requiredHeight = 100;
                
                const section = document.createElement('div');
                section.className = 'chart-section';
                section.style.left = `${index * (barWidth + 10) + 10}%`;
                section.style.width = `${barWidth}%`;
                section.style.height = '0%';
                section.style.background = `linear-gradient(to top, #8e44ad, #3498db)`;
                
                const label = document.createElement('div');
                label.className = 'chart-label';
                label.textContent = category.name;
                label.style.left = `${index * (barWidth + 10) + 10}%`;
                label.style.width = `${barWidth}%`;
                
                chartContainer.appendChild(section);
                chartContainer.appendChild(label);
                
                // Animate bar growth
                setTimeout(() => {
                    section.style.height = `${completedHeight}%`;
                }, index * 300);
            });
        }

        function updateMajorRequirements(requirements, completedCredits) {
            const container = document.getElementById('majorRequirements');
            container.innerHTML = '';
            
            const requirementItems = [
                { name: 'Total Degree Credits', completed: completedCredits, required: requirements.totalCredits },
                { name: 'Major Course Credits', completed: Math.min(completedCredits * 0.5, requirements.majorCredits), required: requirements.majorCredits },
                { name: 'Math & Science Credits', completed: Math.min(completedCredits * 0.2, requirements.mathCredits + requirements.scienceCredits), required: requirements.mathCredits + requirements.scienceCredits },
                { name: 'Elective Credits', completed: Math.min(completedCredits * 0.3, requirements.electiveCredits), required: requirements.electiveCredits }
            ];
            
            requirementItems.forEach(item => {
                const progress = (item.completed / item.required) * 100;
                const majorItem = document.createElement('div');
                majorItem.className = 'major-item';
                majorItem.innerHTML = `
                    <span>${item.name}</span>
                    <strong>${item.completed.toFixed(0)}/${item.required} (${progress.toFixed(0)}%)</strong>
                `;
                container.appendChild(majorItem);
            });
        }

        // Initialize
        window.addEventListener('load', function() {
            initializeSemesterTabs();
            initializeCourses();
            calculateCollegeGPA();
        });
    </script>
</body>
</html>
