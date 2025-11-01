<?php
/**
 * Semester GPA Calculator
 * File: education/semester-gpa-calculator.php
 * Description: Advanced calculator for semester GPA calculation, course planning, and academic performance tracking
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semester GPA Calculator - Course Planning & Academic Performance</title>
    <meta name="description" content="Advanced semester GPA calculator. Calculate semester GPA, plan courses, and track academic performance.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #6a11cb; margin-bottom: 25px; font-size: 1.8rem; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #6a11cb; box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.9em; }
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(106, 17, 203, 0.3); }
        .btn-secondary { background: linear-gradient(135deg, #8e2de2 0%, #4a00e0 100%); margin-top: 10px; }
        .btn-warning { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); }
        
        .result-card { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(106, 17, 203, 0.3); position: relative; overflow: hidden; }
        .result-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 0.8; } }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; position: relative; z-index: 1; }
        .result-card .amount { font-size: 3rem; font-weight: bold; position: relative; z-index: 1; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #6a11cb; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #6a11cb; font-size: 1.8rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #6a11cb; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .progress-bar { background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%); width: 0%; transition: width 1s ease-out; }
        
        .info-box { background: #f0e6ff; border-left: 4px solid #6a11cb; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #6a11cb; }
        
        .course-list { max-height: 400px; overflow-y: auto; border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
        .course-item { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr auto; gap: 8px; align-items: center; padding: 10px; border-bottom: 1px solid #e0e0e0; }
        .course-item:last-child { border-bottom: none; }
        .course-item-header { font-weight: 600; color: #6a11cb; padding-bottom: 10px; border-bottom: 2px solid #6a11cb; }
        .course-input { padding: 6px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 14px; }
        .remove-course { background: #ff6b6b; color: white; border: none; border-radius: 4px; padding: 4px 8px; cursor: pointer; font-size: 12px; }
        
        .semester-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 8px; margin-top: 10px; }
        .semester-btn { padding: 8px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .semester-btn:hover { background: #6a11cb; color: white; border-color: #6a11cb; }
        .semester-btn.active { background: #6a11cb; color: white; border-color: #6a11cb; }
        
        .gpa-visual { display: flex; flex-direction: column; align-items: center; margin: 20px 0; }
        .gpa-dial { width: 200px; height: 200px; border: 10px solid #e0e0e0; border-radius: 50%; position: relative; margin-bottom: 15px; }
        .gpa-fill { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: conic-gradient(#6a11cb 0%, #2575fc 100%); border-radius: 50%; clip-path: polygon(50% 50%, 50% 0%, 100% 0%, 100% 100%, 0% 100%, 0% 0%, 50% 0%); transform: rotate(0deg); transition: transform 2s ease-out; }
        .gpa-center { position: absolute; top: 20px; left: 20px; right: 20px; bottom: 20px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; color: #6a11cb; }
        .gpa-level { font-size: 1.2rem; font-weight: bold; color: #6a11cb; }
        
        .performance-chart { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .chart-container { height: 200px; position: relative; margin: 20px 0; display: flex; align-items: end; gap: 10px; }
        .chart-bar { flex: 1; background: linear-gradient(to top, #6a11cb, #2575fc); border-radius: 4px 4px 0 0; transition: height 1s ease-out; position: relative; }
        .chart-label { position: absolute; bottom: -25px; text-align: center; font-size: 0.8rem; color: #666; width: 100%; }
        .chart-value { position: absolute; top: -25px; text-align: center; font-size: 0.9rem; font-weight: 600; color: #333; width: 100%; }
        
        .goal-comparison { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
        .goal-card { background: white; padding: 15px; border-radius: 8px; border: 2px solid #e0e0e0; text-align: center; }
        .goal-card h4 { color: #666; margin-bottom: 10px; font-size: 0.9rem; }
        .goal-value { font-size: 1.5rem; font-weight: bold; color: #6a11cb; }
        
        .improvement-calculator { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .improvement-item { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0; }
        .improvement-item:last-child { border-bottom: none; margin-bottom: 0; }
        
        .academic-warnings { background: #fff5f5; border-left: 4px solid #ff6b6b; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .warning-item { display: flex; align-items: center; margin-bottom: 8px; }
        .warning-item:last-child { margin-bottom: 0; }
        .warning-icon { color: #ff6b6b; margin-right: 10px; font-size: 1.2rem; }
        
        .course-recommendations { background: #f0f9ff; border-left: 4px solid #2575fc; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .recommendation-item { display: flex; align-items: center; margin-bottom: 8px; }
        .recommendation-item:last-child { margin-bottom: 0; }
        .recommendation-icon { color: #2575fc; margin-right: 10px; font-size: 1.2rem; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        .course-difficulty { display: flex; align-items: center; gap: 10px; margin-top: 5px; }
        .difficulty-btn { padding: 4px 8px; background: #f0f0f0; border: 1px solid #e0e0e0; border-radius: 4px; cursor: pointer; font-size: 0.75rem; transition: all 0.3s; }
        .difficulty-btn.active { background: #6a11cb; color: white; border-color: #6a11cb; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
            .goal-comparison { grid-template-columns: 1fr; }
            .course-item { grid-template-columns: 1fr 1fr; gap: 5px; }
            .course-item-header { display: none; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: 1fr; }
            .input-group { grid-template-columns: 1fr; }
            .semester-preset { grid-template-columns: repeat(2, 1fr); }
            .course-item { grid-template-columns: 1fr; text-align: center; }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
            .gpa-dial { width: 150px; height: 150px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 Semester GPA Calculator</h1>
            <p>Calculate Semester GPA, Plan Course Load, and Track Academic Performance</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Semester Information</h2>
                
                <div class="form-group">
                    <label for="semesterName">Semester Name</label>
                    <input type="text" id="semesterName" value="Fall 2024" placeholder="e.g., Fall 2024, Spring 2025">
                    <small>Name your semester for easy reference</small>
                </div>
                
                <div class="form-group">
                    <label for="gpaScale">GPA Scale</label>
                    <select id="gpaScale" style="padding: 12px;">
                        <option value="4.0" selected>4.0 Scale (Standard)</option>
                        <option value="4.3">4.3 Scale</option>
                        <option value="4.5">4.5 Scale</option>
                        <option value="5.0">5.0 Scale (Weighted)</option>
                        <option value="100">Percentage Scale</option>
                    </select>
                    <small>Select your institution's grading scale</small>
                </div>

                <div class="form-group">
                    <label>Quick Semester Presets</label>
                    <div class="semester-preset">
                        <div class="semester-btn" onclick="setSemesterPreset('standard')">Standard Load</div>
                        <div class="semester-btn" onclick="setSemesterPreset('light')">Light Load</div>
                        <div class="semester-btn" onclick="setSemesterPreset('heavy')">Heavy Load</div>
                        <div class="semester-btn active" onclick="setSemesterPreset('balanced')">Balanced</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="currentCumulativeGPA">Current Cumulative GPA</label>
                    <input type="number" id="currentCumulativeGPA" min="0" max="5" step="0.01" placeholder="e.g., 3.45">
                    <small>Your overall GPA before this semester</small>
                </div>
                
                <div class="form-group">
                    <label for="totalCompletedCredits">Total Completed Credits</label>
                    <input type="number" id="totalCompletedCredits" min="0" step="1" placeholder="e.g., 45">
                    <small>Total credit hours completed so far</small>
                </div>

                <h3>Course Management</h3>
                <div class="course-list">
                    <div class="course-item course-item-header">
                        <div>Course Name</div>
                        <div>Credits</div>
                        <div>Grade</div>
                        <div>Type</div>
                        <div>Difficulty</div>
                        <div>Grade Points</div>
                        <div>Action</div>
                    </div>
                    <div id="courseContainer">
                        <!-- Course items will be generated here -->
                    </div>
                </div>

                <button class="btn btn-secondary" onclick="addCourse()">+ Add Course</button>

                <h2 style="margin-top: 30px;">Academic Goals</h2>
                
                <div class="form-group">
                    <label for="targetSemesterGPA">Target Semester GPA</label>
                    <input type="number" id="targetSemesterGPA" min="0" max="5" step="0.01" value="3.7">
                    <small>Your desired GPA for this semester</small>
                </div>
                
                <div class="form-group">
                    <label for="targetCumulativeGPA">Target Cumulative GPA</label>
                    <input type="number" id="targetCumulativeGPA" min="0" max="5" step="0.01" value="3.5">
                    <small>Your desired overall GPA after this semester</small>
                </div>

                <div class="form-group">
                    <label for="academicStandingGoal">Academic Standing Goal</label>
                    <select id="academicStandingGoal" style="padding: 12px;">
                        <option value="good">Good Standing (2.0+)</option>
                        <option value="dean">Dean's List (3.5+)</option>
                        <option value="honors" selected>Honors (3.7+)</option>
                        <option value="high_honors">High Honors (3.9+)</option>
                    </select>
                    <small>Your target academic standing</small>
                </div>

                <button type="button" class="btn" onclick="calculateSemesterGPA()">Calculate Semester GPA</button>
                <button class="btn btn-warning" onclick="resetCalculator()" style="margin-top: 10px;">Reset Calculator</button>
            </div>

            <div class="results-section">
                <h2>Semester GPA Analysis</h2>
                
                <div class="result-card">
                    <h3>Semester GPA</h3>
                    <div class="amount" id="semesterGPA">3.75</div>
                </div>

                <div class="gpa-visual">
                    <div class="gpa-dial">
                        <div class="gpa-fill" id="gpaFill"></div>
                        <div class="gpa-center" id="gpaCenter">3.75</div>
                    </div>
                    <div class="gpa-level" id="gpaLevel">Excellent Performance</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Projected Cumulative GPA</h4>
                        <div class="value" id="projectedCumulativeGPA">3.68</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Semester Credits</h4>
                        <div class="value" id="totalSemesterCredits">15</div>
                    </div>
                    <div class="metric-card">
                        <h4>Quality Points</h4>
                        <div class="value" id="qualityPoints">56.25</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Semester Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Total Course Credits</span>
                        <strong id="totalCourseCredits">15</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Quality Points</span>
                        <strong id="totalQualityPoints">56.25</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Grade</span>
                        <strong id="averageGrade">A-</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Course Load Difficulty</span>
                        <strong id="courseLoadDifficulty">Moderate</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Academic Standing</span>
                        <strong id="academicStanding">Dean's List</strong>
                    </div>
                </div>

                <div class="performance-chart">
                    <h3>Grade Distribution</h3>
                    <div class="chart-container" id="gradeDistributionChart">
                        <!-- Chart bars will be generated dynamically -->
                    </div>
                </div>

                <div class="goal-comparison">
                    <div class="goal-card">
                        <h4>Target GPA Needed</h4>
                        <div class="goal-value" id="targetGPANeeded">3.82</div>
                        <small>For remaining courses</small>
                    </div>
                    <div class="goal-card">
                        <h4>Improvement Required</h4>
                        <div class="goal-value" id="improvementRequired">+0.07</div>
                        <small>From current average</small>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Academic Progress</h3>
                    <div class="breakdown-item">
                        <span>Current Cumulative GPA</span>
                        <strong id="currentCumulativeDisplay">3.45</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Projected Cumulative GPA</span>
                        <strong id="projectedCumulativeDisplay">3.68</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GPA Improvement</span>
                        <strong id="gpaImprovement">+0.23</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Academic Standing Change</span>
                        <strong id="standingChange">Improved ↗</strong>
                    </div>
                </div>

                <div class="improvement-calculator">
                    <h3>GPA Improvement Strategies</h3>
                    <div class="improvement-item">
                        <span>Improve one B to B+</span>
                        <strong id="improvement1">+0.05 GPA</strong>
                    </div>
                    <div class="improvement-item">
                        <span>Improve one B+ to A-</span>
                        <strong id="improvement2">+0.08 GPA</strong>
                    </div>
                    <div class="improvement-item">
                        <span>Improve all B's to B+</span>
                        <strong id="improvement3">+0.15 GPA</strong>
                    </div>
                    <div class="improvement-item">
                        <span>Add extra credit course (A grade)</span>
                        <strong id="improvement4">+0.12 GPA</strong>
                    </div>
                </div>

                <div class="academic-warnings" id="academicWarnings" style="display: none;">
                    <h3>⚠️ Academic Warnings</h3>
                    <div id="warningList">
                        <!-- Warnings will be generated here -->
                    </div>
                </div>

                <div class="course-recommendations" id="courseRecommendations" style="display: none;">
                    <h3>💡 Course Recommendations</h3>
                    <div id="recommendationList">
                        <!-- Recommendations will be generated here -->
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Semester Performance</h3>
                    <div class="breakdown-item" style="flex-direction: column; align-items: flex-start;">
                        <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 5px;">
                            <span>Overall Semester Score</span>
                            <strong id="semesterScore">85%</strong>
                        </div>
                        <div class="progress-bar" style="width: 100%;">
                            <div class="progress-fill" id="semesterScoreBar"></div>
                        </div>
                        <small style="margin-top: 5px;">Based on GPA, course load balance, and academic goals</small>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Semester Planning Tip:</strong> Balance your course load between challenging major requirements and manageable electives. Consider taking 1-2 difficult courses per semester and fill the rest with moderate or easy courses to maintain a strong GPA while making progress toward your degree.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📚 Semester GPA Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced semester planning and academic performance analysis</p>
        </div>
    </div>

    <script>
        let courses = [
            { name: 'Advanced Calculus', credits: 4, grade: 'A', type: 'major', difficulty: 'high', points: 4.0 },
            { name: 'Data Structures', credits: 3, grade: 'A-', type: 'major', difficulty: 'high', points: 3.7 },
            { name: 'Physics II', credits: 4, grade: 'B+', type: 'major', difficulty: 'medium', points: 3.3 },
            { name: 'Academic Writing', credits: 3, grade: 'A', type: 'general', difficulty: 'low', points: 4.0 },
            { name: 'Introduction to Psychology', credits: 3, grade: 'B+', type: 'elective', difficulty: 'low', points: 3.3 }
        ];

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

        // Letter grade options
        const gradeOptions = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'F'];
        const courseTypes = ['major', 'general', 'elective'];
        const difficultyLevels = ['low', 'medium', 'high'];

        // Semester presets
        const semesterPresets = {
            'light': [
                { name: 'Course 1', credits: 3, grade: 'B+', type: 'major', difficulty: 'medium', points: 3.3 },
                { name: 'Course 2', credits: 3, grade: 'A-', type: 'general', difficulty: 'low', points: 3.7 },
                { name: 'Course 3', credits: 3, grade: 'B+', type: 'elective', difficulty: 'low', points: 3.3 }
            ],
            'balanced': [
                { name: 'Advanced Calculus', credits: 4, grade: 'A', type: 'major', difficulty: 'high', points: 4.0 },
                { name: 'Data Structures', credits: 3, grade: 'A-', type: 'major', difficulty: 'high', points: 3.7 },
                { name: 'Physics II', credits: 4, grade: 'B+', type: 'major', difficulty: 'medium', points: 3.3 },
                { name: 'Academic Writing', credits: 3, grade: 'A', type: 'general', difficulty: 'low', points: 4.0 },
                { name: 'Introduction to Psychology', credits: 3, grade: 'B+', type: 'elective', difficulty: 'low', points: 3.3 }
            ],
            'heavy': [
                { name: 'Advanced Calculus', credits: 4, grade: 'A-', type: 'major', difficulty: 'high', points: 3.7 },
                { name: 'Data Structures', credits: 3, grade: 'B+', type: 'major', difficulty: 'high', points: 3.3 },
                { name: 'Organic Chemistry', credits: 4, grade: 'B', type: 'major', difficulty: 'high', points: 3.0 },
                { name: 'Physics II', credits: 4, grade: 'B+', type: 'major', difficulty: 'medium', points: 3.3 },
                { name: 'Technical Writing', credits: 3, grade: 'A-', type: 'general', difficulty: 'medium', points: 3.7 },
                { name: 'Research Methods', credits: 3, grade: 'B+', type: 'elective', difficulty: 'medium', points: 3.3 }
            ],
            'standard': [
                { name: 'Course 1', credits: 4, grade: 'B+', type: 'major', difficulty: 'high', points: 3.3 },
                { name: 'Course 2', credits: 3, grade: 'A-', type: 'major', difficulty: 'medium', points: 3.7 },
                { name: 'Course 3', credits: 3, grade: 'B+', type: 'general', difficulty: 'medium', points: 3.3 },
                { name: 'Course 4', credits: 3, grade: 'A', type: 'elective', difficulty: 'low', points: 4.0 }
            ]
        };

        function initializeCourses() {
            const container = document.getElementById('courseContainer');
            container.innerHTML = '';
            
            courses.forEach((course, index) => {
                const courseItem = document.createElement('div');
                courseItem.className = 'course-item';
                courseItem.innerHTML = `
                    <input type="text" class="course-input" value="${course.name}" placeholder="Course Name" onchange="updateCourse(${index}, 'name', this.value)">
                    <input type="number" class="course-input" value="${course.credits}" min="1" max="10" step="0.5" onchange="updateCourse(${index}, 'credits', parseFloat(this.value))">
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
                    <select class="course-input" onchange="updateCourse(${index}, 'difficulty', this.value)">
                        ${difficultyLevels.map(difficulty => 
                            `<option value="${difficulty}" ${difficulty === course.difficulty ? 'selected' : ''}>${difficulty.charAt(0).toUpperCase() + difficulty.slice(1)}</option>`
                        ).join('')}
                    </select>
                    <input type="number" class="course-input" value="${course.points.toFixed(1)}" step="0.1" readonly>
                    <button class="remove-course" onclick="removeCourse(${index})">Remove</button>
                `;
                container.appendChild(courseItem);
            });
        }

        function addCourse() {
            courses.push({
                name: 'New Course',
                credits: 3,
                grade: 'B',
                type: 'general',
                difficulty: 'medium',
                points: 3.0
            });
            initializeCourses();
            calculateSemesterGPA();
        }

        function removeCourse(index) {
            courses.splice(index, 1);
            initializeCourses();
            calculateSemesterGPA();
        }

        function updateCourse(index, field, value) {
            courses[index][field] = value;
            
            // Update grade points if grade changed
            if (field === 'grade') {
                const scale = document.getElementById('gpaScale').value;
                courses[index].points = gradeScales[scale][value] || 0;
            }
            
            initializeCourses();
            calculateSemesterGPA();
        }

        function setSemesterPreset(preset) {
            courses = JSON.parse(JSON.stringify(semesterPresets[preset]));
            
            // Visual feedback
            document.querySelectorAll('.semester-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            initializeCourses();
            calculateSemesterGPA();
        }

        function resetCalculator() {
            courses = [
                { name: 'New Course', credits: 3, grade: 'B', type: 'general', difficulty: 'medium', points: 3.0 }
            ];
            document.getElementById('currentCumulativeGPA').value = '';
            document.getElementById('totalCompletedCredits').value = '';
            document.getElementById('targetSemesterGPA').value = '3.7';
            document.getElementById('targetCumulativeGPA').value = '3.5';
            
            initializeCourses();
            calculateSemesterGPA();
        }

        function calculateSemesterGPA() {
            const gpaScale = document.getElementById('gpaScale').value;
            const currentCumulativeGPA = parseFloat(document.getElementById('currentCumulativeGPA').value) || 0;
            const totalCompletedCredits = parseFloat(document.getElementById('totalCompletedCredits').value) || 0;
            const targetSemesterGPA = parseFloat(document.getElementById('targetSemesterGPA').value);
            const targetCumulativeGPA = parseFloat(document.getElementById('targetCumulativeGPA').value);
            const academicStandingGoal = document.getElementById('academicStandingGoal').value;

            // Calculate semester totals
            let semesterCredits = 0;
            let semesterQualityPoints = 0;
            let gradeCounts = {};
            let difficultyScore = 0;
            let highDifficultyCount = 0;

            courses.forEach(course => {
                const credits = parseFloat(course.credits);
                const points = parseFloat(course.points);
                
                semesterCredits += credits;
                semesterQualityPoints += credits * points;
                
                // Track grade distribution
                gradeCounts[course.grade] = (gradeCounts[course.grade] || 0) + 1;
                
                // Track course difficulty
                if (course.difficulty === 'high') {
                    highDifficultyCount++;
                    difficultyScore += 3;
                } else if (course.difficulty === 'medium') {
                    difficultyScore += 2;
                } else {
                    difficultyScore += 1;
                }
            });

            // Calculate GPAs
            const semesterGPA = semesterCredits > 0 ? semesterQualityPoints / semesterCredits : 0;
            
            // Calculate projected cumulative GPA
            let projectedCumulativeGPA = semesterGPA;
            if (totalCompletedCredits > 0) {
                const previousQualityPoints = currentCumulativeGPA * totalCompletedCredits;
                projectedCumulativeGPA = (previousQualityPoints + semesterQualityPoints) / (totalCompletedCredits + semesterCredits);
            }

            // Calculate average grade
            const averageGradeValue = semesterGPA;
            let averageGradeLetter = 'F';
            for (const [grade, points] of Object.entries(gradeScales[gpaScale])) {
                if (averageGradeValue >= points - 0.15) {
                    averageGradeLetter = grade;
                    break;
                }
            }

            // Determine course load difficulty
            let courseLoadDifficulty = 'Light';
            const averageDifficulty = difficultyScore / courses.length;
            if (averageDifficulty >= 2.5) courseLoadDifficulty = 'Heavy';
            else if (averageDifficulty >= 1.8) courseLoadDifficulty = 'Moderate';
            else courseLoadDifficulty = 'Light';

            // Determine academic standing
            let academicStanding = 'Probation';
            if (semesterGPA >= 3.7) academicStanding = 'High Honors';
            else if (semesterGPA >= 3.5) academicStanding = 'Dean\'s List';
            else if (semesterGPA >= 3.0) academicStanding = 'Honors';
            else if (semesterGPA >= 2.0) academicStanding = 'Good Standing';
            else academicStanding = 'Academic Probation';

            // Calculate target requirements
            const remainingQualityPointsNeeded = targetSemesterGPA * semesterCredits - semesterQualityPoints;
            const averagePointsNeeded = remainingQualityPointsNeeded / Math.max(1, courses.length);
            const targetGPANeeded = targetSemesterGPA + (averagePointsNeeded / 4);
            const improvementRequired = Math.max(0, targetGPANeeded - semesterGPA);

            // Calculate GPA improvement
            const gpaImprovement = projectedCumulativeGPA - currentCumulativeGPA;
            const standingChange = gpaImprovement > 0 ? 'Improved ↗' : gpaImprovement < 0 ? 'Declined ↘' : 'No Change';

            // Calculate improvement scenarios
            const improvement1 = calculateImprovement(courses, 3.0, 3.3, semesterCredits);
            const improvement2 = calculateImprovement(courses, 3.3, 3.7, semesterCredits);
            const improvement3 = calculateImprovementAll(courses, 3.0, 3.3, semesterCredits);
            const improvement4 = (4.0 * 3) / (semesterCredits + 3) - semesterGPA;

            // Generate warnings and recommendations
            const warnings = generateWarnings(semesterGPA, semesterCredits, highDifficultyCount, courses);
            const recommendations = generateRecommendations(semesterGPA, targetSemesterGPA, courses);

            // Calculate semester score (0-100%)
            const gpaScore = (semesterGPA / 4.0) * 40;
            const loadBalanceScore = Math.max(0, 30 - (highDifficultyCount * 5));
            const goalAchievementScore = (semesterGPA / targetSemesterGPA) * 30;
            const semesterScore = Math.min(100, gpaScore + loadBalanceScore + goalAchievementScore);

            // Update UI
            document.getElementById('semesterGPA').textContent = semesterGPA.toFixed(2);
            document.getElementById('projectedCumulativeGPA').textContent = projectedCumulativeGPA.toFixed(2);
            document.getElementById('totalSemesterCredits').textContent = semesterCredits;
            document.getElementById('qualityPoints').textContent = semesterQualityPoints.toFixed(1);

            document.getElementById('totalCourseCredits').textContent = semesterCredits;
            document.getElementById('totalQualityPoints').textContent = semesterQualityPoints.toFixed(1);
            document.getElementById('averageGrade').textContent = averageGradeLetter;
            document.getElementById('courseLoadDifficulty').textContent = courseLoadDifficulty;
            document.getElementById('academicStanding').textContent = academicStanding;

            document.getElementById('currentCumulativeDisplay').textContent = currentCumulativeGPA.toFixed(2);
            document.getElementById('projectedCumulativeDisplay').textContent = projectedCumulativeGPA.toFixed(2);
            document.getElementById('gpaImprovement').textContent = (gpaImprovement >= 0 ? '+' : '') + gpaImprovement.toFixed(2);
            document.getElementById('standingChange').textContent = standingChange;

            document.getElementById('targetGPANeeded').textContent = targetGPANeeded.toFixed(2);
            document.getElementById('improvementRequired').textContent = '+' + improvementRequired.toFixed(2);

            document.getElementById('improvement1').textContent = '+' + improvement1.toFixed(2) + ' GPA';
            document.getElementById('improvement2').textContent = '+' + improvement2.toFixed(2) + ' GPA';
            document.getElementById('improvement3').textContent = '+' + improvement3.toFixed(2) + ' GPA';
            document.getElementById('improvement4').textContent = '+' + improvement4.toFixed(2) + ' GPA';

            // Update visual elements
            updateGPADial(semesterGPA);
            updateGpaLevel(semesterGPA);
            updateSemesterScore(semesterScore);
            generateGradeDistributionChart(gradeCounts);
            updateWarnings(warnings);
            updateRecommendations(recommendations);
        }

        function calculateImprovement(courses, fromGrade, toGrade, totalCredits) {
            let improvement = 0;
            let count = 0;
            courses.forEach(course => {
                if (Math.abs(course.points - fromGrade) < 0.1) {
                    improvement += (toGrade - fromGrade) * course.credits;
                    count++;
                }
            });
            return count > 0 ? improvement / totalCredits : 0;
        }

        function calculateImprovementAll(courses, fromGrade, toGrade, totalCredits) {
            let improvement = 0;
            courses.forEach(course => {
                if (Math.abs(course.points - fromGrade) < 0.1) {
                    improvement += (toGrade - fromGrade) * course.credits;
                }
            });
            return improvement / totalCredits;
        }

        function generateWarnings(semesterGPA, semesterCredits, highDifficultyCount, courses) {
            const warnings = [];
            
            if (semesterCredits > 18) {
                warnings.push('High credit load may impact performance');
            }
            
            if (highDifficultyCount >= 3) {
                warnings.push('Multiple high-difficulty courses detected');
            }
            
            if (semesterGPA < 2.0) {
                warnings.push('Semester GPA below good standing threshold');
            }
            
            let lowGradeCount = 0;
            courses.forEach(course => {
                if (course.points < 2.0) {
                    lowGradeCount++;
                }
            });
            
            if (lowGradeCount >= 2) {
                warnings.push('Multiple courses with grades below C');
            }
            
            return warnings;
        }

        function generateRecommendations(semesterGPA, targetGPA, courses) {
            const recommendations = [];
            
            if (semesterGPA < targetGPA) {
                recommendations.push('Focus on improving lowest-graded courses first');
            }
            
            let highDifficultyWithLowGrade = false;
            courses.forEach(course => {
                if (course.difficulty === 'high' && course.points < 3.0) {
                    highDifficultyWithLowGrade = true;
                }
            });
            
            if (highDifficultyWithLowGrade) {
                recommendations.push('Consider tutoring for high-difficulty courses');
            }
            
            if (courses.length > 5) {
                recommendations.push('Consider reducing course load next semester');
            } else if (courses.length < 4 && semesterGPA > 3.5) {
                recommendations.push('You may be able to handle additional courses');
            }
            
            recommendations.push('Balance major requirements with electives');
            recommendations.push('Meet with academic advisor for course planning');
            
            return recommendations;
        }

        function updateGPADial(gpa) {
            const gpaFill = document.getElementById('gpaFill');
            const gpaCenter = document.getElementById('gpaCenter');
            
            const percentage = (gpa / 4.0) * 100;
            const rotation = (percentage / 100) * 360;
            
            gpaFill.style.transform = `rotate(${rotation}deg)`;
            gpaCenter.textContent = gpa.toFixed(2);
            
            // Change color based on GPA
            if (gpa >= 3.7) {
                gpaFill.style.background = 'conic-gradient(#27ae60 0%, #2ecc71 100%)';
            } else if (gpa >= 3.0) {
                gpaFill.style.background = 'conic-gradient(#f39c12 0%, #f1c40f 100%)';
            } else {
                gpaFill.style.background = 'conic-gradient(#e74c3c 0%, #c0392b 100%)';
            }
        }

        function updateGpaLevel(gpa) {
            const levelElement = document.getElementById('gpaLevel');
            let level = '';
            
            if (gpa >= 3.9) level = 'Exceptional Performance 🏆';
            else if (gpa >= 3.7) level = 'Excellent Performance ⭐';
            else if (gpa >= 3.3) level = 'Very Good Performance 👍';
            else if (gpa >= 3.0) level = 'Good Performance ✅';
            else if (gpa >= 2.0) level = 'Satisfactory Performance 📚';
            else level = 'Needs Improvement 💪';
            
            levelElement.textContent = level;
            
            // Change color based on performance
            if (gpa >= 3.7) {
                levelElement.style.color = '#27ae60';
            } else if (gpa >= 3.0) {
                levelElement.style.color = '#f39c12';
            } else {
                levelElement.style.color = '#e74c3c';
            }
        }

        function updateSemesterScore(score) {
            const scoreBar = document.getElementById('semesterScoreBar');
            const scoreText = document.getElementById('semesterScore');
            
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

        function generateGradeDistributionChart(gradeCounts) {
            const chartContainer = document.getElementById('gradeDistributionChart');
            chartContainer.innerHTML = '';
            
            const grades = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'F'];
            const maxCount = Math.max(...Object.values(gradeCounts), 1);
            
            grades.forEach(grade => {
                const count = gradeCounts[grade] || 0;
                const height = (count / maxCount) * 100;
                
                const bar = document.createElement('div');
                bar.className = 'chart-bar';
                bar.style.height = '0%';
                
                const valueLabel = document.createElement('div');
                valueLabel.className = 'chart-value';
                valueLabel.textContent = count;
                
                const gradeLabel = document.createElement('div');
                gradeLabel.className = 'chart-label';
                gradeLabel.textContent = grade;
                
                chartContainer.appendChild(bar);
                chartContainer.appendChild(valueLabel);
                chartContainer.appendChild(gradeLabel);
                
                // Animate bar growth
                setTimeout(() => {
                    bar.style.height = height + '%';
                }, grades.indexOf(grade) * 100);
            });
        }

        function updateWarnings(warnings) {
            const warningsContainer = document.getElementById('academicWarnings');
            const warningList = document.getElementById('warningList');
            
            warningList.innerHTML = '';
            
            if (warnings.length > 0) {
                warningsContainer.style.display = 'block';
                warnings.forEach(warning => {
                    const warningItem = document.createElement('div');
                    warningItem.className = 'warning-item';
                    warningItem.innerHTML = `
                        <div class="warning-icon">⚠️</div>
                        <span>${warning}</span>
                    `;
                    warningList.appendChild(warningItem);
                });
            } else {
                warningsContainer.style.display = 'none';
            }
        }

        function updateRecommendations(recommendations) {
            const recommendationsContainer = document.getElementById('courseRecommendations');
            const recommendationList = document.getElementById('recommendationList');
            
            recommendationList.innerHTML = '';
            
            if (recommendations.length > 0) {
                recommendationsContainer.style.display = 'block';
                recommendations.forEach(recommendation => {
                    const recommendationItem = document.createElement('div');
                    recommendationItem.className = 'recommendation-item';
                    recommendationItem.innerHTML = `
                        <div class="recommendation-icon">💡</div>
                        <span>${recommendation}</span>
                    `;
                    recommendationList.appendChild(recommendationItem);
                });
            } else {
                recommendationsContainer.style.display = 'none';
            }
        }

        // Initialize
        window.addEventListener('load', function() {
            initializeCourses();
            calculateSemesterGPA();
        });
    </script>
</body>
</html>
