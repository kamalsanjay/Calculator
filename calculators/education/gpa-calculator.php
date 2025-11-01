<?php
/**
 * GPA Calculator
 * File: education/gpa-calculator.php
 * Description: Advanced calculator for GPA calculation, grade analysis, and academic performance tracking
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPA Calculator - Grade Point Average Analysis & Academic Performance</title>
    <meta name="description" content="Advanced GPA calculator. Calculate cumulative GPA, predict future grades, and analyze academic performance.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
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
        
        .input-group { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; align-items: end; }
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border: none; border-radius: 8px; font-size: 18px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); }
        .btn-secondary { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); margin-top: 10px; }
        
        .result-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); position: relative; overflow: hidden; }
        .result-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 3s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 0.8; } }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; position: relative; z-index: 1; }
        .result-card .amount { font-size: 3rem; font-weight: bold; position: relative; z-index: 1; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #667eea; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #667eea; font-size: 1.8rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #667eea; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .progress-bar { background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); width: 0%; transition: width 1s ease-out; }
        
        .info-box { background: #e8ecff; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #667eea; }
        
        .course-list { max-height: 400px; overflow-y: auto; border: 2px solid #e0e0e0; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
        .course-item { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 10px; align-items: center; padding: 12px; border-bottom: 1px solid #e0e0e0; }
        .course-item:last-child { border-bottom: none; }
        .course-item-header { font-weight: 600; color: #667eea; padding-bottom: 10px; border-bottom: 2px solid #667eea; }
        .course-input { padding: 8px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 14px; }
        .remove-course { background: #ff6b6b; color: white; border: none; border-radius: 4px; padding: 6px 10px; cursor: pointer; font-size: 12px; }
        
        .gpa-scale-preset { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 8px; margin-top: 10px; }
        .scale-btn { padding: 8px 12px; background: #f0f0f0; border: 2px solid #e0e0e0; border-radius: 6px; cursor: pointer; text-align: center; font-size: 0.85rem; transition: all 0.3s; }
        .scale-btn:hover { background: #667eea; color: white; border-color: #667eea; }
        .scale-btn.active { background: #667eea; color: white; border-color: #667eea; }
        
        .gpa-visual { display: flex; flex-direction: column; align-items: center; margin: 20px 0; }
        .gpa-dial { width: 200px; height: 200px; border: 10px solid #e0e0e0; border-radius: 50%; position: relative; margin-bottom: 15px; }
        .gpa-fill { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: conic-gradient(#667eea 0%, #764ba2 100%); border-radius: 50%; clip-path: polygon(50% 50%, 50% 0%, 100% 0%, 100% 100%, 0% 100%, 0% 0%, 50% 0%); transform: rotate(0deg); transition: transform 2s ease-out; }
        .gpa-center { position: absolute; top: 20px; left: 20px; right: 20px; bottom: 20px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; color: #667eea; }
        .gpa-level { font-size: 1.2rem; font-weight: bold; color: #667eea; }
        
        .performance-chart { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .chart-container { height: 200px; position: relative; margin: 20px 0; display: flex; align-items: end; gap: 8px; }
        .chart-bar { flex: 1; background: linear-gradient(to top, #667eea, #764ba2); border-radius: 4px 4px 0 0; transition: height 1s ease-out; position: relative; }
        .chart-label { position: absolute; bottom: -25px; text-align: center; font-size: 0.8rem; color: #666; width: 100%; }
        .chart-value { position: absolute; top: -25px; text-align: center; font-size: 0.9rem; font-weight: 600; color: #333; width: 100%; }
        
        .goal-comparison { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
        .comparison-card { background: white; padding: 15px; border-radius: 8px; border: 2px solid #e0e0e0; text-align: center; }
        .comparison-card h4 { color: #666; margin-bottom: 10px; font-size: 0.9rem; }
        .comparison-value { font-size: 1.5rem; font-weight: bold; color: #667eea; }
        
        .improvement-calculator { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .improvement-item { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e0e0e0; }
        .improvement-item:last-child { border-bottom: none; margin-bottom: 0; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
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
            .gpa-scale-preset { grid-template-columns: repeat(2, 1fr); }
            .chart-container { height: 150px; }
            .course-item { grid-template-columns: 1fr; text-align: center; }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
            .chart-container { height: 120px; }
            .gpa-dial { width: 150px; height: 150px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎓 GPA Calculator</h1>
            <p>Calculate Cumulative GPA, Predict Future Grades, and Analyze Academic Performance</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Course Information</h2>
                
                <div class="form-group">
                    <label for="gpaScale">GPA Scale System</label>
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
                    <label>Quick Scale Presets</label>
                    <div class="gpa-scale-preset">
                        <div class="scale-btn" onclick="setGPAScale('4.0')">4.0 Standard</div>
                        <div class="scale-btn" onclick="setGPAScale('5.0')">5.0 Weighted</div>
                        <div class="scale-btn" onclick="setGPAScale('4.3')">4.3 Scale</div>
                        <div class="scale-btn" onclick="setGPAScale('100')">Percentage</div>
                    </div>
                </div>

                <div class="course-list">
                    <div class="course-item course-item-header">
                        <div>Course Name</div>
                        <div>Credits</div>
                        <div>Grade</div>
                        <div>Grade Points</div>
                        <div>Action</div>
                    </div>
                    <div id="courseContainer">
                        <!-- Course items will be generated here -->
                    </div>
                </div>

                <button class="btn btn-secondary" onclick="addCourse()">+ Add Course</button>

                <div class="form-group">
                    <label for="currentGPA">Current Cumulative GPA (Optional)</label>
                    <input type="number" id="currentGPA" min="0" max="5" step="0.01" placeholder="e.g., 3.45">
                    <small>Your existing GPA before adding these courses</small>
                </div>
                
                <div class="form-group">
                    <label for="totalCredits">Total Completed Credits (Optional)</label>
                    <input type="number" id="totalCredits" min="0" step="1" placeholder="e.g., 45">
                    <small>Total credit hours completed so far</small>
                </div>

                <h2 style="margin-top: 30px;">Future Semester Planning</h2>
                
                <div class="form-group">
                    <label for="targetGPA">Target GPA Goal</label>
                    <input type="number" id="targetGPA" min="0" max="5" step="0.01" value="3.5">
                    <small>Your desired cumulative GPA</small>
                </div>
                
                <div class="form-group">
                    <label for="futureCredits">Future Credits to Complete</label>
                    <input type="number" id="futureCredits" min="0" step="1" value="15">
                    <small>Credit hours you plan to take in future semesters</small>
                </div>

                <button type="button" class="btn" onclick="calculateGPA()">Calculate GPA</button>
            </div>

            <div class="results-section">
                <h2>GPA Analysis</h2>
                
                <div class="result-card">
                    <h3>Current Semester GPA</h3>
                    <div class="amount" id="semesterGPA">3.75</div>
                </div>

                <div class="gpa-visual">
                    <div class="gpa-dial">
                        <div class="gpa-fill" id="gpaFill"></div>
                        <div class="gpa-center" id="gpaCenter">3.75</div>
                    </div>
                    <div class="gpa-level" id="gpaLevel">Excellent</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Cumulative GPA</h4>
                        <div class="value" id="cumulativeGPA">3.68</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Credits</h4>
                        <div class="value" id="totalCreditsDisplay">15</div>
                    </div>
                    <div class="metric-card">
                        <h4>Quality Points</h4>
                        <div class="value" id="qualityPoints">55.2</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Semester Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Total Course Credits</span>
                        <strong id="courseCredits">15</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Quality Points</span>
                        <strong id="totalQualityPoints">55.2</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Average Grade</span>
                        <strong id="averageGrade">A-</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Highest Grade</span>
                        <strong id="highestGrade">A (4.0)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lowest Grade</span>
                        <strong id="lowestGrade">B+ (3.3)</strong>
                    </div>
                </div>

                <div class="performance-chart">
                    <h3>Grade Distribution</h3>
                    <div class="chart-container" id="gradeDistributionChart">
                        <!-- Chart bars will be generated dynamically -->
                    </div>
                </div>

                <div class="goal-comparison">
                    <div class="comparison-card">
                        <h4>Target GPA Required</h4>
                        <div class="comparison-value" id="targetRequired">3.82</div>
                        <small>For future semesters</small>
                    </div>
                    <div class="comparison-card">
                        <h4>Improvement Needed</h4>
                        <div class="comparison-value" id="improvementNeeded">+0.14</div>
                        <small>From current average</small>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Academic Standing</h3>
                    <div class="breakdown-item">
                        <span>Current Status</span>
                        <strong id="academicStatus">Good Standing</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Dean's List Eligibility</span>
                        <strong id="deansList">Eligible</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Honors Consideration</span>
                        <strong id="honorsStatus">Cum Laude</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GPA Trend</span>
                        <strong id="gpaTrend">Improving</strong>
                    </div>
                </div>

                <div class="improvement-calculator">
                    <h3>GPA Improvement Plan</h3>
                    <div class="improvement-item">
                        <span>Raise one B+ to A-</span>
                        <strong id="improvement1">+0.05 GPA</strong>
                    </div>
                    <div class="improvement-item">
                        <span>Raise all B's to B+</span>
                        <strong id="improvement2">+0.12 GPA</strong>
                    </div>
                    <div class="improvement-item">
                        <span>Add one A course (3 credits)</span>
                        <strong id="improvement3">+0.08 GPA</strong>
                    </div>
                    <div class="improvement-item">
                        <span>Target 3.8 next semester</span>
                        <strong id="improvement4">+0.15 cumulative</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Academic Performance</h3>
                    <div class="breakdown-item" style="flex-direction: column; align-items: flex-start;">
                        <div style="display: flex; justify-content: space-between; width: 100%; margin-bottom: 5px;">
                            <span>Overall Performance Score</span>
                            <strong id="performanceScore">88%</strong>
                        </div>
                        <div class="progress-bar" style="width: 100%;">
                            <div class="progress-fill" id="performanceBar"></div>
                        </div>
                        <small style="margin-top: 5px;">Based on GPA, credit load, and grade consistency</small>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Academic Tip:</strong> Maintaining consistent performance across all courses is key to a strong GPA. Focus on improving your lowest grades first, as they have the most significant impact on your cumulative average. Consider taking challenging courses during lighter semesters.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🎓 GPA Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced academic performance analysis and GPA planning</p>
        </div>
    </div>

    <script>
        let courses = [
            { name: 'Mathematics', credits: 3, grade: 'A', points: 4.0 },
            { name: 'Science', credits: 4, grade: 'A-', points: 3.7 },
            { name: 'English', credits: 3, grade: 'B+', points: 3.3 },
            { name: 'History', credits: 3, grade: 'A', points: 4.0 },
            { name: 'Elective', credits: 2, grade: 'B', points: 3.0 }
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

        function initializeCourses() {
            const container = document.getElementById('courseContainer');
            container.innerHTML = '';
            
            courses.forEach((course, index) => {
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
                points: 3.0
            });
            initializeCourses();
            calculateGPA();
        }

        function removeCourse(index) {
            courses.splice(index, 1);
            initializeCourses();
            calculateGPA();
        }

        function updateCourse(index, field, value) {
            courses[index][field] = value;
            
            // Update grade points if grade changed
            if (field === 'grade') {
                const scale = document.getElementById('gpaScale').value;
                courses[index].points = gradeScales[scale][value] || 0;
            }
            
            initializeCourses();
            calculateGPA();
        }

        function setGPAScale(scale) {
            document.getElementById('gpaScale').value = scale;
            
            // Update all course points based on new scale
            courses.forEach(course => {
                course.points = gradeScales[scale][course.grade] || 0;
            });
            
            // Visual feedback
            document.querySelectorAll('.scale-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            initializeCourses();
            calculateGPA();
        }

        function calculateGPA() {
            const gpaScale = document.getElementById('gpaScale').value;
            const currentGPA = parseFloat(document.getElementById('currentGPA').value) || 0;
            const totalCredits = parseFloat(document.getElementById('totalCredits').value) || 0;
            const targetGPA = parseFloat(document.getElementById('targetGPA').value);
            const futureCredits = parseFloat(document.getElementById('futureCredits').value);

            // Calculate semester totals
            let semesterCredits = 0;
            let semesterQualityPoints = 0;
            let gradeCounts = {};
            let highestGrade = { points: 0, grade: '' };
            let lowestGrade = { points: 5.0, grade: '' };

            courses.forEach(course => {
                const credits = parseFloat(course.credits);
                const points = parseFloat(course.points);
                
                semesterCredits += credits;
                semesterQualityPoints += credits * points;
                
                // Track grade distribution
                gradeCounts[course.grade] = (gradeCounts[course.grade] || 0) + 1;
                
                // Track highest and lowest grades
                if (points > highestGrade.points) {
                    highestGrade = { points, grade: course.grade };
                }
                if (points < lowestGrade.points) {
                    lowestGrade = { points, grade: course.grade };
                }
            });

            // Calculate GPAs
            const semesterGPA = semesterCredits > 0 ? semesterQualityPoints / semesterCredits : 0;
            
            // Calculate cumulative GPA if previous data provided
            let cumulativeGPA = semesterGPA;
            let totalCompletedCredits = semesterCredits;
            
            if (totalCredits > 0) {
                const previousQualityPoints = currentGPA * totalCredits;
                cumulativeGPA = (previousQualityPoints + semesterQualityPoints) / (totalCredits + semesterCredits);
                totalCompletedCredits = totalCredits + semesterCredits;
            }

            // Calculate target requirements
            const futureQualityPointsNeeded = targetGPA * (totalCompletedCredits + futureCredits) - (cumulativeGPA * totalCompletedCredits);
            const targetRequiredGPA = futureCredits > 0 ? Math.max(0, futureQualityPointsNeeded / futureCredits) : 0;
            const improvementNeeded = Math.max(0, targetRequiredGPA - semesterGPA);

            // Calculate average grade
            const averageGradeValue = semesterGPA;
            let averageGradeLetter = 'F';
            for (const [grade, points] of Object.entries(gradeScales[gpaScale])) {
                if (averageGradeValue >= points - 0.15) {
                    averageGradeLetter = grade;
                    break;
                }
            }

            // Determine academic standing
            const academicStatus = cumulativeGPA >= 2.0 ? 'Good Standing' : cumulativeGPA >= 1.5 ? 'Academic Warning' : 'Academic Probation';
            const deansList = semesterGPA >= 3.5 ? 'Eligible' : 'Not Eligible';
            
            let honorsStatus = 'No Honors';
            if (cumulativeGPA >= 3.9) honorsStatus = 'Summa Cum Laude';
            else if (cumulativeGPA >= 3.7) honorsStatus = 'Magna Cum Laude';
            else if (cumulativeGPA >= 3.5) honorsStatus = 'Cum Laude';

            const gpaTrend = semesterGPA > currentGPA ? 'Improving' : semesterGPA < currentGPA ? 'Declining' : 'Stable';

            // Calculate improvement scenarios
            const improvement1 = calculateImprovement(courses, 3.3, 3.7, semesterCredits);
            const improvement2 = calculateImprovement(courses, 3.0, 3.3, semesterCredits);
            const improvement3 = (4.0 * 3) / (semesterCredits + 3) - semesterGPA;
            const improvement4 = (3.8 * futureCredits) / (totalCompletedCredits + futureCredits);

            // Calculate performance score (0-100%)
            const performanceScore = Math.min(100, (cumulativeGPA / (gpaScale === '5.0' ? 5 : 4)) * 100 * 1.1);

            // Update UI
            document.getElementById('semesterGPA').textContent = semesterGPA.toFixed(2);
            document.getElementById('cumulativeGPA').textContent = cumulativeGPA.toFixed(2);
            document.getElementById('totalCreditsDisplay').textContent = totalCompletedCredits;
            document.getElementById('qualityPoints').textContent = semesterQualityPoints.toFixed(1);

            document.getElementById('courseCredits').textContent = semesterCredits;
            document.getElementById('totalQualityPoints').textContent = semesterQualityPoints.toFixed(1);
            document.getElementById('averageGrade').textContent = `${averageGradeLetter} (${averageGradeValue.toFixed(1)})`;
            document.getElementById('highestGrade').textContent = `${highestGrade.grade} (${highestGrade.points.toFixed(1)})`;
            document.getElementById('lowestGrade').textContent = `${lowestGrade.grade} (${lowestGrade.points.toFixed(1)})`;

            document.getElementById('targetRequired').textContent = targetRequiredGPA.toFixed(2);
            document.getElementById('improvementNeeded').textContent = `+${improvementNeeded.toFixed(2)}`;

            document.getElementById('academicStatus').textContent = academicStatus;
            document.getElementById('deansList').textContent = deansList;
            document.getElementById('honorsStatus').textContent = honorsStatus;
            document.getElementById('gpaTrend').textContent = gpaTrend;

            document.getElementById('improvement1').textContent = `+${improvement1.toFixed(2)} GPA`;
            document.getElementById('improvement2').textContent = `+${improvement2.toFixed(2)} GPA`;
            document.getElementById('improvement3').textContent = `+${improvement3.toFixed(2)} GPA`;
            document.getElementById('improvement4').textContent = `+${improvement4.toFixed(2)} cumulative`;

            // Update visual elements
            updateGPADial(semesterGPA, gpaScale);
            updatePerformanceLevel(semesterGPA);
            updatePerformanceScore(performanceScore);
            generateGradeDistributionChart(gradeCounts);
        }

        function calculateImprovement(courses, fromGrade, toGrade, totalCredits) {
            let improvement = 0;
            courses.forEach(course => {
                if (Math.abs(course.points - fromGrade) < 0.1) {
                    improvement += (toGrade - fromGrade) * course.credits;
                }
            });
            return improvement / totalCredits;
        }

        function updateGPADial(gpa, scale) {
            const gpaFill = document.getElementById('gpaFill');
            const gpaCenter = document.getElementById('gpaCenter');
            const maxGPA = scale === '5.0' ? 5.0 : scale === '4.3' ? 4.3 : scale === '4.5' ? 4.5 : 4.0;
            
            const percentage = (gpa / maxGPA) * 100;
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

        function updatePerformanceLevel(gpa) {
            const levelElement = document.getElementById('gpaLevel');
            let level = '';
            
            if (gpa >= 3.9) level = 'Outstanding';
            else if (gpa >= 3.7) level = 'Excellent';
            else if (gpa >= 3.3) level = 'Very Good';
            else if (gpa >= 3.0) level = 'Good';
            else if (gpa >= 2.7) level = 'Satisfactory';
            else if (gpa >= 2.0) level = 'Passing';
            else level = 'Needs Improvement';
            
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

        function updatePerformanceScore(score) {
            const performanceBar = document.getElementById('performanceBar');
            const performanceText = document.getElementById('performanceScore');
            
            performanceBar.style.width = '0%';
            performanceText.textContent = '0%';
            
            setTimeout(() => {
                performanceBar.style.width = score + '%';
                performanceText.textContent = Math.round(score) + '%';
                
                // Change color based on score
                if (score >= 85) {
                    performanceBar.style.background = 'linear-gradient(90deg, #27ae60 0%, #2ecc71 100%)';
                } else if (score >= 70) {
                    performanceBar.style.background = 'linear-gradient(90deg, #f39c12 0%, #f1c40f 100%)';
                } else {
                    performanceBar.style.background = 'linear-gradient(90deg, #e74c3c 0%, #c0392b 100%)';
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

        // Initialize
        window.addEventListener('load', function() {
            initializeCourses();
            calculateGPA();
        });
    </script>
</body>
</html>
