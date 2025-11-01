<?php
/**
 * Weighted Grade Calculator
 * File: education/weighted-grade-calculator.php
 * Description: Advanced weighted grade calculator with multiple categories, assignment management, and performance analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weighted Grade Calculator - Category-Based Grade Calculation & Analysis</title>
    <meta name="description" content="Advanced weighted grade calculator with multiple categories, assignment management, and comprehensive performance analysis.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh; 
            padding: 20px; 
        }
        
        .container { 
            max-width: 1400px; 
            margin: 0 auto; 
        }
        
        .header { 
            background: rgba(255,255,255,0.95); 
            padding: 30px; 
            border-radius: 20px 20px 0 0; 
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1); 
            text-align: center; 
        }
        .header h1 { 
            color: #2c3e50; 
            font-size: 2.5rem; 
            margin-bottom: 10px; 
        }
        .header p { 
            color: #7f8c8d; 
            font-size: 1.2rem; 
            opacity: 0.9; 
        }
        
        .calculator-wrapper { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 30px; 
            background: white; 
            padding: 35px; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.12); 
        }
        
        .calculator-section h2, .results-section h2 { 
            color: #667eea; 
            margin-bottom: 25px; 
            font-size: 1.8rem; 
        }
        
        .form-group { 
            margin-bottom: 20px; 
        }
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            color: #555; 
        }
        .form-group input, .form-group select { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #e0e0e0; 
            border-radius: 8px; 
            font-size: 16px; 
            transition: border-color 0.3s; 
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
            font-size: 0.9em; 
        }
        
        .category-section { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 12px; 
            margin-bottom: 20px; 
            border-left: 4px solid #667eea; 
        }
        .category-section h3 { 
            color: #667eea; 
            margin-bottom: 15px; 
            font-size: 1.3rem; 
        }
        
        .assignment-row { 
            display: grid; 
            grid-template-columns: 2fr 1fr 1fr auto; 
            gap: 10px; 
            align-items: center; 
            margin-bottom: 10px; 
            padding: 10px; 
            background: white; 
            border-radius: 8px; 
            border: 1px solid #e0e0e0; 
        }
        
        .btn { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 15px 30px; 
            border: none; 
            border-radius: 8px; 
            font-size: 18px; 
            font-weight: 600; 
            cursor: pointer; 
            width: 100%; 
            transition: all 0.3s; 
        }
        .btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); 
        }
        
        .btn-secondary { 
            background: #6c757d; 
            padding: 8px 15px; 
            font-size: 14px; 
            width: auto; 
        }
        .btn-secondary:hover { 
            background: #5a6268; 
            transform: translateY(-1px); 
        }
        
        .btn-success { 
            background: #28a745; 
            padding: 8px 15px; 
            font-size: 14px; 
            width: auto; 
        }
        .btn-success:hover { 
            background: #218838; 
        }
        
        .btn-danger { 
            background: #dc3545; 
            padding: 8px 15px; 
            font-size: 14px; 
            width: auto; 
        }
        .btn-danger:hover { 
            background: #c82333; 
        }
        
        .btn-warning { 
            background: #ffc107; 
            color: #212529; 
            padding: 8px 15px; 
            font-size: 14px; 
            width: auto; 
        }
        .btn-warning:hover { 
            background: #e0a800; 
        }
        
        .result-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            padding: 25px; 
            border-radius: 12px; 
            margin-bottom: 20px; 
            text-align: center; 
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); 
            position: relative; 
            overflow: hidden; 
        }
        .result-card::before { 
            content: ''; 
            position: absolute; 
            top: -50%; 
            right: -50%; 
            width: 200%; 
            height: 200%; 
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); 
            animation: pulse 3s ease-in-out infinite; 
        }
        @keyframes pulse { 
            0%, 100% { transform: scale(1); opacity: 0.5; } 
            50% { transform: scale(1.1); opacity: 0.8; } 
        }
        .result-card h3 { 
            font-size: 1.2rem; 
            opacity: 0.9; 
            margin-bottom: 10px; 
            font-weight: 400; 
            position: relative; 
            z-index: 1; 
        }
        .result-card .amount { 
            font-size: 3rem; 
            font-weight: bold; 
            position: relative; 
            z-index: 1; 
        }
        
        .metric-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-bottom: 20px; 
        }
        .metric-card { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 12px; 
            text-align: center; 
            border: 2px solid #e0e0e0; 
            transition: all 0.3s; 
        }
        .metric-card:hover { 
            transform: translateY(-2px); 
            border-color: #667eea; 
        }
        .metric-card h4 { 
            color: #666; 
            font-size: 0.9rem; 
            margin-bottom: 10px; 
            font-weight: 400; 
        }
        .metric-card .value { 
            color: #667eea; 
            font-size: 1.8rem; 
            font-weight: bold; 
        }
        
        .breakdown { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 12px; 
            margin-bottom: 20px; 
        }
        .breakdown h3 { 
            color: #667eea; 
            margin-bottom: 15px; 
            font-size: 1.3rem; 
        }
        .breakdown-item { 
            display: flex; 
            justify-content: space-between; 
            padding: 12px 0; 
            border-bottom: 1px solid #e0e0e0; 
        }
        .breakdown-item:last-child { 
            border-bottom: none; 
        }
        .breakdown-item span { 
            color: #666; 
        }
        .breakdown-item strong { 
            color: #333; 
            font-weight: 600; 
        }
        
        .category-list { 
            max-height: 400px; 
            overflow-y: auto; 
            margin: 15px 0; 
            border: 1px solid #e0e0e0; 
            border-radius: 8px; 
            padding: 10px; 
        }
        
        .category-item { 
            display: grid; 
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr; 
            gap: 10px; 
            padding: 12px; 
            border-bottom: 1px solid #e0e0e0; 
            align-items: center; 
        }
        .category-item:last-child { 
            border-bottom: none; 
        }
        .category-item.header { 
            font-weight: bold; 
            background: #f8f9fa; 
            border-radius: 4px; 
        }
        
        .grade-visual { 
            height: 20px; 
            background: #e0e0e0; 
            border-radius: 10px; 
            overflow: hidden; 
            margin: 15px 0; 
            position: relative; 
        }
        .grade-fill { 
            height: 100%; 
            background: linear-gradient(90deg, #dc3545, #ffc107, #28a745); 
            width: 0%; 
            transition: width 1s ease-out; 
        }
        .grade-labels { 
            display: flex; 
            justify-content: space-between; 
            margin-top: 5px; 
            font-size: 0.8rem; 
            color: #666; 
        }
        
        .performance-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 15px; 
            margin-top: 15px; 
        }
        .performance-card { 
            background: white; 
            padding: 15px; 
            border-radius: 8px; 
            border: 2px solid #e0e0e0; 
            text-align: center; 
        }
        .performance-card h4 { 
            color: #667eea; 
            margin-bottom: 8px; 
            font-size: 0.9rem; 
        }
        .performance-card .value { 
            font-size: 1.2rem; 
            font-weight: bold; 
            color: #333; 
        }
        .performance-card .change { 
            font-size: 0.8rem; 
            color: #666; 
        }
        
        .category-chart { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); 
            gap: 15px; 
            margin: 20px 0; 
        }
        .category-bar { 
            background: #f8f9fa; 
            padding: 15px; 
            border-radius: 8px; 
            text-align: center; 
            position: relative; 
        }
        .category-bar .bar-container { 
            height: 120px; 
            background: #e0e0e0; 
            border-radius: 4px; 
            position: relative; 
            overflow: hidden; 
            margin-bottom: 10px; 
        }
        .category-bar .bar-fill { 
            position: absolute; 
            bottom: 0; 
            left: 0; 
            right: 0; 
            background: linear-gradient(to top, #667eea, #764ba2); 
            border-radius: 4px; 
            transition: height 1s ease-out; 
        }
        .category-bar .name { 
            font-size: 0.9rem; 
            font-weight: bold; 
            margin-bottom: 5px; 
            color: #333; 
        }
        .category-bar .grade { 
            font-size: 1rem; 
            color: #667eea; 
            font-weight: bold; 
        }
        .category-bar .weight { 
            font-size: 0.8rem; 
            color: #666; 
        }
        
        .weight-preset { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
            gap: 8px; 
            margin-top: 10px; 
        }
        .preset-btn { 
            padding: 10px 12px; 
            background: #f0f0f0; 
            border: 2px solid #e0e0e0; 
            border-radius: 6px; 
            cursor: pointer; 
            text-align: center; 
            font-size: 0.85rem; 
            transition: all 0.3s; 
        }
        .preset-btn:hover { 
            background: #667eea; 
            color: white; 
            border-color: #667eea; 
        }
        .preset-btn.active { 
            background: #667eea; 
            color: white; 
            border-color: #667eea; 
        }
        
        .improvement-tips { 
            background: #e8f5e8; 
            padding: 15px; 
            border-radius: 8px; 
            border-left: 4px solid #28a745; 
            margin: 15px 0; 
        }
        .improvement-tips h4 { 
            color: #2c3e50; 
            margin-bottom: 10px; 
        }
        .improvement-tips ul { 
            color: #666; 
            padding-left: 20px; 
        }
        .improvement-tips li { 
            margin-bottom: 5px; 
        }
        
        .letter-grade { 
            font-size: 1.5rem; 
            font-weight: bold; 
            text-align: center; 
            margin: 5px 0; 
        }
        .grade-A { color: #28a745; }
        .grade-B { color: #007bff; }
        .grade-C { color: #ffc107; }
        .grade-D { color: #fd7e14; }
        .grade-F { color: #dc3545; }
        
        .info-box { 
            background: #e8f2ff; 
            border-left: 4px solid #667eea; 
            padding: 15px; 
            margin: 20px 0; 
            border-radius: 5px; 
        }
        .info-box strong { 
            color: #667eea; 
        }
        
        .footer { 
            background: rgba(255,255,255,0.95); 
            padding: 25px; 
            border-radius: 0 0 20px 20px; 
            text-align: center; 
            color: #7f8c8d; 
        }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { 
                grid-template-columns: 1fr; 
                padding: 25px; 
            }
            .result-card .amount { 
                font-size: 2.5rem; 
            }
        }
        
        @media (max-width: 768px) {
            .header h1 { 
                font-size: 2rem; 
            }
            .metric-grid { 
                grid-template-columns: 1fr; 
            }
            .assignment-row { 
                grid-template-columns: 1fr; 
                gap: 5px; 
            }
            .category-item { 
                grid-template-columns: 1fr; 
                text-align: center; 
            }
            .weight-preset { 
                grid-template-columns: repeat(2, 1fr); 
            }
            .category-chart { 
                grid-template-columns: repeat(2, 1fr); 
            }
            .performance-grid { 
                grid-template-columns: 1fr; 
            }
        }
        
        @media (max-width: 480px) {
            .header h1 { 
                font-size: 1.5rem; 
            }
            .header p { 
                font-size: 1rem; 
            }
            .result-card .amount { 
                font-size: 2rem; 
            }
            body { 
                padding: 10px; 
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚖️ Weighted Grade Calculator</h1>
            <p>Calculate grades with multiple weighted categories and comprehensive performance analysis</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Course Setup</h2>
                <form id="weightedGradeForm">
                    
                    <div class="form-group">
                        <label for="courseName">Course Name</label>
                        <input type="text" id="courseName" value="Mathematics 101" placeholder="Enter course name">
                        <small>Name of the course for reference</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="gradingScale">Grading Scale</label>
                        <select id="gradingScale" style="padding: 12px;">
                            <option value="standard" selected>Standard (A=90+, B=80+, etc.)</option>
                            <option value="college">College (A=93+, B=85+, etc.)</option>
                            <option value="strict">Strict (A=95+, B=87+, etc.)</option>
                            <option value="custom">Custom Scale</option>
                        </select>
                        <small>Select your institution's grading scale</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Weight Presets</label>
                        <div class="weight-preset">
                            <div class="preset-btn" onclick="setPreset('Standard College', 'standard')">Standard College</div>
                            <div class="preset-btn" onclick="setPreset('STEM Course', 'stem')">STEM Course</div>
                            <div class="preset-btn" onclick="setPreset('Humanities', 'humanities')">Humanities</div>
                            <div class="preset-btn" onclick="setPreset('Lab Science', 'lab')">Lab Science</div>
                            <div class="preset-btn" onclick="setPreset('Project Based', 'project')">Project Based</div>
                            <div class="preset-btn" onclick="setPreset('Custom', 'custom')">Custom Weights</div>
                        </div>
                    </div>
                    
                    <div id="categoriesContainer">
                        <!-- Categories will be dynamically added here -->
                    </div>
                    
                    <button type="button" class="btn-success" onclick="addCategory()" style="margin-bottom: 20px;">
                        + Add Category
                    </button>
                    
                    <div class="form-group">
                        <label for="desiredGrade">Desired Final Grade</label>
                        <div class="input-group">
                            <input type="number" id="desiredGrade" value="90" min="0" max="100" step="0.1" required>
                            <select style="padding: 12px;" disabled>
                                <option>%</option>
                            </select>
                        </div>
                        <small>The final grade you want to achieve in the course</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Weighted Grade</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Grade Analysis</h2>
                
                <div class="result-card">
                    <h3>Current Weighted Grade</h3>
                    <div class="amount" id="weightedGrade">87.5%</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Letter Grade</h4>
                        <div class="value" id="letterGrade">B+</div>
                    </div>
                    <div class="metric-card">
                        <h4>GPA Points</h4>
                        <div class="value" id="gpaPoints">3.3</div>
                    </div>
                    <div class="metric-card">
                        <h4>Completion</h4>
                        <div class="value" id="completion">65%</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Category Performance</h3>
                    <div class="category-list">
                        <div class="category-item header">
                            <span>Category</span>
                            <span>Weight</span>
                            <span>Grade</span>
                            <span>Contribution</span>
                            <span>Status</span>
                        </div>
                        <div id="categoryPerformance">
                            <!-- Category items will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Weighted Grade</span>
                        <strong id="totalWeightedGrade">87.5%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Category Comparison</h3>
                    <div class="category-chart" id="categoryChart">
                        <!-- Category bars will be populated by JavaScript -->
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Grade Distribution</h3>
                    <div class="breakdown-item">
                        <span>Highest Category</span>
                        <strong id="highestCategory">Homework (95%)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lowest Category</span>
                        <strong id="lowestCategory">Exams (82%)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Most Impactful</span>
                        <strong id="mostImpactful">Exams (40% weight)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Grade Range</span>
                        <strong id="gradeRange">13.0%</strong>
                    </div>
                    
                    <div class="grade-visual">
                        <div class="grade-fill" id="gradeFill"></div>
                    </div>
                    <div class="grade-labels">
                        <span>F (0-59%)</span>
                        <span>D (60-69%)</span>
                        <span>C (70-79%)</span>
                        <span>B (80-89%)</span>
                        <span>A (90-100%)</span>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Performance Analysis</h3>
                    <div class="performance-grid">
                        <div class="performance-card">
                            <h4>Academic Standing</h4>
                            <div class="value" id="academicStanding">Good</div>
                            <div class="change">Current performance</div>
                        </div>
                        <div class="performance-card">
                            <h4>Target Gap</h4>
                            <div class="value" id="targetGap">-2.5%</div>
                            <div class="change">From desired grade</div>
                        </div>
                        <div class="performance-card">
                            <h4>Strong Categories</h4>
                            <div class="value" id="strongCategories">2</div>
                            <div class="change">A grades</div>
                        </div>
                        <div class="performance-card">
                            <h4>Improvement Areas</h4>
                            <div class="value" id="improvementAreas">1</div>
                            <div class="change">Below 85%</div>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Grade Projection</h3>
                    <div class="breakdown-item">
                        <span>Current Grade</span>
                        <strong id="currentGradeProjection">87.5%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>If All Remaining = 100%</span>
                        <strong id="bestCaseGrade">92.8%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>If All Remaining = 80%</span>
                        <strong id="averageCaseGrade">85.2%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Minimum to Pass (70%)</span>
                        <strong id="minimumPassGrade">78.5%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Grade Needed for Target</span>
                        <strong id="neededForTarget">93.2%</strong>
                    </div>
                </div>

                <div class="improvement-tips" id="improvementTips">
                    <h4>📈 Improvement Strategy</h4>
                    <ul id="tipsList">
                        <!-- Tips will be populated by JavaScript -->
                    </ul>
                </div>

                <div class="breakdown">
                    <h3>Weight Analysis</h3>
                    <div class="breakdown-item">
                        <span>Total Assigned Weight</span>
                        <strong id="totalAssignedWeight">100%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight Distribution</span>
                        <strong id="weightDistribution">Balanced</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Most Critical Category</span>
                        <strong id="mostCriticalCategory">Exams</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Optimization Potential</span>
                        <strong id="optimizationPotential">High</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> Weighted grade calculations assume accurate category weights and assignment scores. Actual course grading policies may vary. Always verify category weights and grading scales with your course syllabus and instructor.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>⚖️ Weighted Grade Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced category-based grade calculation and analysis</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('weightedGradeForm');
        let currentPreset = '';
        let categoryCounter = 0;

        // Grade scale definitions
        const gradeScales = {
            standard: { A: 90, B: 80, C: 70, D: 60, F: 0 },
            college: { A: 93, B: 85, C: 77, D: 70, F: 0 },
            strict: { A: 95, B: 87, C: 80, D: 73, F: 0 }
        };

        // Preset configurations
        const weightPresets = {
            'standard': [
                { name: 'Exams', weight: 40, grade: 82, assignments: [] },
                { name: 'Homework', weight: 20, grade: 95, assignments: [] },
                { name: 'Projects', weight: 25, grade: 88, assignments: [] },
                { name: 'Participation', weight: 15, grade: 90, assignments: [] }
            ],
            'stem': [
                { name: 'Exams', weight: 50, grade: 85, assignments: [] },
                { name: 'Labs', weight: 30, grade: 92, assignments: [] },
                { name: 'Homework', weight: 15, grade: 88, assignments: [] },
                { name: 'Quizzes', weight: 5, grade: 90, assignments: [] }
            ],
            'humanities': [
                { name: 'Papers', weight: 40, grade: 87, assignments: [] },
                { name: 'Exams', weight: 30, grade: 83, assignments: [] },
                { name: 'Discussion', weight: 20, grade: 95, assignments: [] },
                { name: 'Reading Responses', weight: 10, grade: 88, assignments: [] }
            ],
            'lab': [
                { name: 'Lab Reports', weight: 40, grade: 85, assignments: [] },
                { name: 'Exams', weight: 35, grade: 82, assignments: [] },
                { name: 'Lab Practical', weight: 15, grade: 90, assignments: [] },
                { name: 'Homework', weight: 10, grade: 88, assignments: [] }
            ],
            'project': [
                { name: 'Final Project', weight: 45, grade: 0, assignments: [] },
                { name: 'Milestones', weight: 25, grade: 92, assignments: [] },
                { name: 'Exams', weight: 20, grade: 85, assignments: [] },
                { name: 'Participation', weight: 10, grade: 95, assignments: [] }
            ],
            'custom': [
                { name: 'Category 1', weight: 25, grade: 0, assignments: [] },
                { name: 'Category 2', weight: 25, grade: 0, assignments: [] },
                { name: 'Category 3', weight: 25, grade: 0, assignments: [] },
                { name: 'Category 4', weight: 25, grade: 0, assignments: [] }
            ]
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateWeightedGrade();
        });

        // Initialize with default categories
        window.addEventListener('load', function() {
            setPreset('Standard College', 'standard');
            calculateWeightedGrade();
        });

        function setPreset(name, presetKey) {
            currentPreset = name;
            const categoriesContainer = document.getElementById('categoriesContainer');
            categoriesContainer.innerHTML = '';
            
            const preset = weightPresets[presetKey];
            preset.forEach((category, index) => {
                addCategoryFromPreset(category, index);
            });
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateWeightedGrade();
        }

        function addCategoryFromPreset(category, index) {
            const categoriesContainer = document.getElementById('categoriesContainer');
            const categoryId = `category-${categoryCounter++}`;
            
            const categorySection = document.createElement('div');
            categorySection.className = 'category-section';
            categorySection.innerHTML = `
                <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 15px;">
                    <h3>${category.name}</h3>
                    <button type="button" class="btn-danger" onclick="removeCategory('${categoryId}')">Remove</button>
                </div>
                <div class="assignment-row">
                    <input type="text" value="${category.name}" class="category-name" placeholder="Category Name">
                    <input type="number" value="${category.weight}" class="category-weight" placeholder="Weight %" min="0" max="100" step="1">
                    <input type="number" value="${category.grade}" class="category-grade" placeholder="Grade %" min="0" max="100" step="0.1">
                    <button type="button" class="btn-warning" onclick="addAssignment('${categoryId}')">+ Assignment</button>
                </div>
                <div class="assignments-container" id="${categoryId}">
                    <!-- Assignments will be added here -->
                </div>
            `;
            
            categoriesContainer.appendChild(categorySection);
        }

        function addCategory() {
            const categoriesContainer = document.getElementById('categoriesContainer');
            const categoryId = `category-${categoryCounter++}`;
            
            const categorySection = document.createElement('div');
            categorySection.className = 'category-section';
            categorySection.innerHTML = `
                <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 15px;">
                    <h3>New Category</h3>
                    <button type="button" class="btn-danger" onclick="removeCategory('${categoryId}')">Remove</button>
                </div>
                <div class="assignment-row">
                    <input type="text" value="New Category" class="category-name" placeholder="Category Name">
                    <input type="number" value="25" class="category-weight" placeholder="Weight %" min="0" max="100" step="1">
                    <input type="number" value="0" class="category-grade" placeholder="Grade %" min="0" max="100" step="0.1">
                    <button type="button" class="btn-warning" onclick="addAssignment('${categoryId}')">+ Assignment</button>
                </div>
                <div class="assignments-container" id="${categoryId}">
                    <!-- Assignments will be added here -->
                </div>
            `;
            
            categoriesContainer.appendChild(categorySection);
        }

        function removeCategory(categoryId) {
            const categorySection = document.getElementById(categoryId).closest('.category-section');
            if (document.querySelectorAll('.category-section').length > 1) {
                categorySection.remove();
            }
            calculateWeightedGrade();
        }

        function addAssignment(categoryId) {
            const assignmentsContainer = document.getElementById(categoryId);
            const assignmentRow = document.createElement('div');
            assignmentRow.className = 'assignment-row';
            assignmentRow.innerHTML = `
                <input type="text" placeholder="Assignment Name" value="New Assignment">
                <input type="number" placeholder="Points" value="10" min="0" max="1000" step="1">
                <input type="number" placeholder="Earned" value="8" min="0" max="1000" step="0.1">
                <button type="button" class="btn-danger" onclick="removeAssignment(this)">×</button>
            `;
            assignmentsContainer.appendChild(assignmentRow);
        }

        function removeAssignment(button) {
            const row = button.parentElement;
            row.remove();
            calculateWeightedGrade();
        }

        function calculateWeightedGrade() {
            // Get all categories
            const categories = [];
            let totalWeight = 0;
            
            document.querySelectorAll('.category-section').forEach(section => {
                const nameInput = section.querySelector('.category-name');
                const weightInput = section.querySelector('.category-weight');
                const gradeInput = section.querySelector('.category-grade');
                const assignmentsContainer = section.querySelector('.assignments-container');
                
                const name = nameInput.value || 'Unnamed Category';
                const weight = parseFloat(weightInput.value) || 0;
                let grade = parseFloat(gradeInput.value) || 0;
                
                // Calculate grade from assignments if provided
                const assignments = [];
                let assignmentPoints = 0;
                let assignmentEarned = 0;
                
                assignmentsContainer.querySelectorAll('.assignment-row').forEach(row => {
                    const inputs = row.querySelectorAll('input');
                    const assignmentName = inputs[0].value || 'Assignment';
                    const points = parseFloat(inputs[1].value) || 0;
                    const earned = parseFloat(inputs[2].value) || 0;
                    
                    if (points > 0) {
                        assignments.push({ name: assignmentName, points, earned });
                        assignmentPoints += points;
                        assignmentEarned += earned;
                    }
                });
                
                // Use assignment-based grade if assignments are provided
                if (assignmentPoints > 0) {
                    grade = (assignmentEarned / assignmentPoints) * 100;
                    gradeInput.value = grade.toFixed(1);
                }
                
                if (weight > 0) {
                    categories.push({
                        name,
                        weight,
                        grade,
                        assignments,
                        assignmentPoints,
                        assignmentEarned
                    });
                    totalWeight += weight;
                }
            });

            // Calculate weighted grade
            let weightedSum = 0;
            categories.forEach(category => {
                weightedSum += (category.grade * category.weight) / 100;
            });

            const weightedGrade = totalWeight > 0 ? weightedSum : 0;
            const desiredGrade = parseFloat(document.getElementById('desiredGrade').value) || 0;
            const gradeScaleType = document.getElementById('gradingScale').value;

            // Calculate performance metrics
            const letterGrade = getLetterGrade(weightedGrade, gradeScaleType);
            const gpaPoints = getGPAPoints(weightedGrade, gradeScaleType);
            const completion = calculateCompletion(categories);
            const targetGap = desiredGrade - weightedGrade;

            // Calculate category analysis
            const highestCategory = findHighestCategory(categories);
            const lowestCategory = findLowestCategory(categories);
            const mostImpactful = findMostImpactful(categories);
            const gradeRange = highestCategory.grade - lowestCategory.grade;
            const strongCategories = categories.filter(c => c.grade >= 90).length;
            const improvementAreas = categories.filter(c => c.grade < 85).length;

            // Calculate grade projections
            const projections = calculateGradeProjections(categories, weightedGrade, desiredGrade);
            const improvementTips = generateImprovementTips(categories, weightedGrade, desiredGrade);
            const weightAnalysis = analyzeWeights(categories);

            // Update UI
            document.getElementById('weightedGrade').textContent = weightedGrade.toFixed(1) + '%';
            document.getElementById('letterGrade').textContent = letterGrade;
            document.getElementById('gpaPoints').textContent = gpaPoints.toFixed(1);
            document.getElementById('completion').textContent = completion + '%';

            document.getElementById('totalWeightedGrade').textContent = weightedGrade.toFixed(1) + '%';
            document.getElementById('highestCategory').textContent = `${highestCategory.name} (${highestCategory.grade.toFixed(1)}%)`;
            document.getElementById('lowestCategory').textContent = `${lowestCategory.name} (${lowestCategory.grade.toFixed(1)}%)`;
            document.getElementById('mostImpactful').textContent = `${mostImpactful.name} (${mostImpactful.weight}% weight)`;
            document.getElementById('gradeRange').textContent = gradeRange.toFixed(1) + '%';

            document.getElementById('academicStanding').textContent = getAcademicStanding(weightedGrade);
            document.getElementById('targetGap').textContent = (targetGap > 0 ? '+' : '') + targetGap.toFixed(1) + '%';
            document.getElementById('strongCategories').textContent = strongCategories;
            document.getElementById('improvementAreas').textContent = improvementAreas;

            document.getElementById('currentGradeProjection').textContent = weightedGrade.toFixed(1) + '%';
            document.getElementById('bestCaseGrade').textContent = projections.bestCase.toFixed(1) + '%';
            document.getElementById('averageCaseGrade').textContent = projections.averageCase.toFixed(1) + '%';
            document.getElementById('minimumPassGrade').textContent = projections.minimumPass.toFixed(1) + '%';
            document.getElementById('neededForTarget').textContent = projections.neededForTarget.toFixed(1) + '%';

            document.getElementById('totalAssignedWeight').textContent = totalWeight + '%';
            document.getElementById('weightDistribution').textContent = weightAnalysis.distribution;
            document.getElementById('mostCriticalCategory').textContent = weightAnalysis.mostCritical;
            document.getElementById('optimizationPotential').textContent = weightAnalysis.optimizationPotential;

            // Update visual indicators
            document.getElementById('gradeFill').style.width = weightedGrade + '%';

            // Update category performance and chart
            updateCategoryPerformance(categories);
            updateCategoryChart(categories);

            // Update improvement tips
            updateImprovementTips(improvementTips);
        }

        function getLetterGrade(percentage, scaleType) {
            const scale = gradeScales[scaleType];
            
            if (percentage >= scale.A) return 'A';
            if (percentage >= scale.B + 7) return 'A-';
            if (percentage >= scale.B + 3) return 'B+';
            if (percentage >= scale.B) return 'B';
            if (percentage >= scale.C + 7) return 'B-';
            if (percentage >= scale.C + 3) return 'C+';
            if (percentage >= scale.C) return 'C';
            if (percentage >= scale.D + 7) return 'C-';
            if (percentage >= scale.D + 3) return 'D+';
            if (percentage >= scale.D) return 'D';
            return 'F';
        }

        function getGPAPoints(percentage, scaleType) {
            const scale = gradeScales[scaleType];
            
            if (percentage >= scale.A) return 4.0;
            if (percentage >= scale.B + 7) return 3.7;
            if (percentage >= scale.B + 3) return 3.3;
            if (percentage >= scale.B) return 3.0;
            if (percentage >= scale.C + 7) return 2.7;
            if (percentage >= scale.C + 3) return 2.3;
            if (percentage >= scale.C) return 2.0;
            if (percentage >= scale.D + 7) return 1.7;
            if (percentage >= scale.D + 3) return 1.3;
            if (percentage >= scale.D) return 1.0;
            return 0.0;
        }

        function calculateCompletion(categories) {
            let totalCompleted = 0;
            let totalWeight = 0;
            
            categories.forEach(category => {
                if (category.grade > 0) {
                    totalCompleted += category.weight;
                }
                totalWeight += category.weight;
            });
            
            return totalWeight > 0 ? Math.round((totalCompleted / totalWeight) * 100) : 0;
        }

        function findHighestCategory(categories) {
            return categories.reduce((highest, current) => 
                current.grade > highest.grade ? current : highest, categories[0]);
        }

        function findLowestCategory(categories) {
            return categories.reduce((lowest, current) => 
                current.grade < lowest.grade ? current : lowest, categories[0]);
        }

        function findMostImpactful(categories) {
            return categories.reduce((most, current) => 
                current.weight > most.weight ? current : most, categories[0]);
        }

        function getAcademicStanding(grade) {
            if (grade >= 90) return 'Excellent';
            if (grade >= 85) return 'Very Good';
            if (grade >= 80) return 'Good';
            if (grade >= 75) return 'Satisfactory';
            if (grade >= 70) return 'Needs Improvement';
            return 'Academic Concern';
        }

        function calculateGradeProjections(categories, currentGrade, desiredGrade) {
            const incompleteCategories = categories.filter(c => c.grade === 0);
            const completedWeight = categories.filter(c => c.grade > 0).reduce((sum, c) => sum + c.weight, 0);
            const remainingWeight = 100 - completedWeight;
            
            const bestCase = currentGrade + remainingWeight;
            const averageCase = currentGrade + (remainingWeight * 0.8);
            const minimumPass = currentGrade + (remainingWeight * 0.7);
            
            const neededForTarget = remainingWeight > 0 ? 
                (desiredGrade - currentGrade) / (remainingWeight / 100) : 0;
            
            return {
                bestCase: Math.min(100, bestCase),
                averageCase: Math.min(100, averageCase),
                minimumPass: Math.min(100, minimumPass),
                neededForTarget: Math.min(100, neededForTarget)
            };
        }

        function analyzeWeights(categories) {
            const weights = categories.map(c => c.weight);
            const maxWeight = Math.max(...weights);
            const minWeight = Math.min(...weights);
            const weightRange = maxWeight - minWeight;
            
            let distribution = 'Balanced';
            if (weightRange > 30) distribution = 'Heavy Focus';
            if (weightRange > 50) distribution = 'Extreme Focus';
            
            const mostCritical = categories.reduce((most, current) => 
                current.weight > most.weight ? current : most).name;
            
            const lowGrades = categories.filter(c => c.grade < 80 && c.weight > 20);
            const optimizationPotential = lowGrades.length > 0 ? 'High' : 'Moderate';
            
            return { distribution, mostCritical, optimizationPotential };
        }

        function generateImprovementTips(categories, currentGrade, desiredGrade) {
            const tips = [];
            const lowCategories = categories.filter(c => c.grade < 85 && c.weight >= 10);
            
            if (currentGrade < desiredGrade) {
                tips.push(`Focus on improving your overall grade by ${(desiredGrade - currentGrade).toFixed(1)}%`);
            }
            
            lowCategories.forEach(category => {
                const improvementNeeded = 85 - category.grade;
                if (improvementNeeded > 0) {
                    tips.push(`Improve ${category.name} by ${improvementNeeded.toFixed(1)}% - it carries ${category.weight}% weight`);
                }
            });
            
            const highWeightCategories = categories.filter(c => c.weight >= 25 && c.grade < 90);
            highWeightCategories.forEach(category => {
                tips.push(`Prioritize ${category.name} - high weight category (${category.weight}%) with room for improvement`);
            });
            
            if (tips.length === 0) {
                tips.push('Maintain your current performance across all categories');
                tips.push('Consider excelling in remaining assignments to maximize your grade');
            }
            
            return tips.slice(0, 4);
        }

        function updateCategoryPerformance(categories) {
            const performance = document.getElementById('categoryPerformance');
            performance.innerHTML = '';

            categories.forEach(category => {
                const contribution = (category.grade * category.weight) / 100;
                const status = category.grade >= 90 ? 'Excellent' :
                             category.grade >= 85 ? 'Good' :
                             category.grade >= 80 ? 'Satisfactory' :
                             category.grade >= 70 ? 'Needs Work' : 'Concern';
                
                const item = document.createElement('div');
                item.className = 'category-item';
                item.innerHTML = `
                    <span>${category.name}</span>
                    <span>${category.weight}%</span>
                    <span>${category.grade.toFixed(1)}%</span>
                    <span>${contribution.toFixed(1)}%</span>
                    <span>${status}</span>
                `;
                performance.appendChild(item);
            });
        }

        function updateCategoryChart(categories) {
            const chart = document.getElementById('categoryChart');
            chart.innerHTML = '';

            categories.forEach(category => {
                const bar = document.createElement('div');
                bar.className = 'category-bar';
                bar.innerHTML = `
                    <div class="name">${category.name}</div>
                    <div class="bar-container">
                        <div class="bar-fill" style="height: ${category.grade}%"></div>
                    </div>
                    <div class="grade">${category.grade.toFixed(1)}%</div>
                    <div class="weight">${category.weight}% weight</div>
                `;
                chart.appendChild(bar);
            });
        }

        function updateImprovementTips(tips) {
            const tipsList = document.getElementById('tipsList');
            tipsList.innerHTML = '';

            tips.forEach(tip => {
                const li = document.createElement('li');
                li.textContent = tip;
                tipsList.appendChild(li);
            });
        }
    </script>
</body>
</html>
