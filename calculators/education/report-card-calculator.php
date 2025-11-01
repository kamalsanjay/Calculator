<?php
/**
 * Report Card Calculator
 * File: education/report-card-calculator.php
 * Description: Advanced report card calculator with multiple subjects, grading scales, and performance analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card Calculator - Multi-Subject Grade Calculation & Analysis</title>
    <meta name="description" content="Advanced report card calculator. Calculate overall grades, GPA, and analyze performance across multiple subjects.">
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
        
        .subject-row { 
            display: grid; 
            grid-template-columns: 2fr 1fr 1fr auto; 
            gap: 10px; 
            align-items: center; 
            margin-bottom: 10px; 
            padding: 10px; 
            background: #f8f9fa; 
            border-radius: 8px; 
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
        
        .subject-list { 
            max-height: 300px; 
            overflow-y: auto; 
            margin: 15px 0; 
            border: 1px solid #e0e0e0; 
            border-radius: 8px; 
            padding: 10px; 
        }
        
        .subject-item { 
            display: grid; 
            grid-template-columns: 2fr 1fr 1fr 1fr; 
            gap: 10px; 
            padding: 8px; 
            border-bottom: 1px solid #e0e0e0; 
            align-items: center; 
        }
        .subject-item:last-child { 
            border-bottom: none; 
        }
        .subject-item.header { 
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
        
        .subject-chart { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
            gap: 10px; 
            margin: 15px 0; 
        }
        .subject-bar { 
            background: #f8f9fa; 
            padding: 10px; 
            border-radius: 8px; 
            text-align: center; 
            position: relative; 
        }
        .subject-bar .bar { 
            height: 100px; 
            background: #e0e0e0; 
            border-radius: 4px; 
            position: relative; 
            overflow: hidden; 
            margin-bottom: 5px; 
        }
        .subject-bar .fill { 
            position: absolute; 
            bottom: 0; 
            left: 0; 
            right: 0; 
            background: linear-gradient(to top, #667eea, #764ba2); 
            border-radius: 4px; 
            transition: height 1s ease-out; 
        }
        .subject-bar .name { 
            font-size: 0.8rem; 
            font-weight: bold; 
            margin-bottom: 5px; 
        }
        .subject-bar .grade { 
            font-size: 0.9rem; 
            color: #666; 
        }
        
        .report-preset { 
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
        
        .honor-roll { 
            background: linear-gradient(135deg, #ffd700, #ffed4e); 
            padding: 15px; 
            border-radius: 8px; 
            text-align: center; 
            margin: 15px 0; 
            border: 2px solid #ffc107; 
        }
        .honor-roll h4 { 
            color: #856404; 
            margin-bottom: 5px; 
        }
        .honor-roll p { 
            color: #856404; 
            font-weight: bold; 
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
            .subject-row { 
                grid-template-columns: 1fr; 
                gap: 5px; 
            }
            .subject-item { 
                grid-template-columns: 1fr; 
                text-align: center; 
            }
            .report-preset { 
                grid-template-columns: repeat(2, 1fr); 
            }
            .subject-chart { 
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
            <h1>📊 Report Card Calculator</h1>
            <p>Calculate overall grades, GPA, and analyze performance across multiple subjects</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Academic Information</h2>
                <form id="reportCardForm">
                    
                    <div class="form-group">
                        <label for="gradingSystem">Grading System</label>
                        <select id="gradingSystem" style="padding: 12px;">
                            <option value="percentage" selected>Percentage (0-100%)</option>
                            <option value="letter">Letter Grades</option>
                            <option value="gpa">4.0 GPA Scale</option>
                            <option value="weighted">Weighted GPA</option>
                        </select>
                        <small>Select your institution's grading system</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="gradeLevel">Grade Level</label>
                        <select id="gradeLevel" style="padding: 12px;">
                            <option value="elementary">Elementary School</option>
                            <option value="middle">Middle School</option>
                            <option value="highschool" selected>High School</option>
                            <option value="college">College/University</option>
                        </select>
                        <small>Your current educational level</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Report Presets</label>
                        <div class="report-preset">
                            <div class="preset-btn" onclick="setPreset('Honor Roll', 'percentage', 'highschool')">Honor Roll</div>
                            <div class="preset-btn" onclick="setPreset('Average', 'percentage', 'highschool')">Average</div>
                            <div class="preset-btn" onclick="setPreset('College Prep', 'gpa', 'highschool')">College Prep</div>
                            <div class="preset-btn" onclick="setPreset('Graduate', 'gpa', 'college')">Graduate</div>
                            <div class="preset-btn" onclick="setPreset('Elementary', 'percentage', 'elementary')">Elementary</div>
                            <div class="preset-btn" onclick="setPreset('AP Student', 'weighted', 'highschool')">AP Student</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <h4 style="color: #667eea; margin-bottom: 15px;">Subject Grades</h4>
                        <div id="subjectsContainer">
                            <div class="subject-row">
                                <input type="text" placeholder="Subject Name" value="Mathematics" class="subject-name">
                                <input type="number" placeholder="Grade" value="92" min="0" max="100" step="0.1" class="subject-grade">
                                <input type="number" placeholder="Credits" value="1" min="0" max="5" step="0.5" class="subject-credits">
                                <button type="button" class="btn-danger" onclick="removeSubject(this)">×</button>
                            </div>
                            <div class="subject-row">
                                <input type="text" placeholder="Subject Name" value="English" class="subject-name">
                                <input type="number" placeholder="Grade" value="88" min="0" max="100" step="0.1" class="subject-grade">
                                <input type="number" placeholder="Credits" value="1" min="0" max="5" step="0.5" class="subject-credits">
                                <button type="button" class="btn-danger" onclick="removeSubject(this)">×</button>
                            </div>
                            <div class="subject-row">
                                <input type="text" placeholder="Subject Name" value="Science" class="subject-name">
                                <input type="number" placeholder="Grade" value="85" min="0" max="100" step="0.1" class="subject-grade">
                                <input type="number" placeholder="Credits" value="1" min="0" max="5" step="0.5" class="subject-credits">
                                <button type="button" class="btn-danger" onclick="removeSubject(this)">×</button>
                            </div>
                            <div class="subject-row">
                                <input type="text" placeholder="Subject Name" value="History" class="subject-name">
                                <input type="number" placeholder="Grade" value="90" min="0" max="100" step="0.1" class="subject-grade">
                                <input type="number" placeholder="Credits" value="1" min="0" max="5" step="0.5" class="subject-credits">
                                <button type="button" class="btn-danger" onclick="removeSubject(this)">×</button>
                            </div>
                        </div>
                        <button type="button" class="btn-success" onclick="addSubject()" style="margin-top: 10px;">+ Add Subject</button>
                    </div>
                    
                    <div class="form-group">
                        <label for="previousGPA">Previous GPA (Optional)</label>
                        <input type="number" id="previousGPA" value="3.5" min="0" max="4.0" step="0.01">
                        <small>Your GPA from previous semester for trend analysis</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="attendance">Attendance Rate</label>
                        <div class="input-group">
                            <input type="number" id="attendance" value="95" min="0" max="100" step="0.1">
                            <select style="padding: 12px;" disabled>
                                <option>%</option>
                            </select>
                        </div>
                        <small>Overall attendance percentage</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Report Card</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Academic Report</h2>
                
                <div class="result-card">
                    <h3>Overall Average</h3>
                    <div class="amount" id="overallAverage">88.8%</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Cumulative GPA</h4>
                        <div class="value" id="cumulativeGPA">3.4</div>
                    </div>
                    <div class="metric-card">
                        <h4>Class Rank</h4>
                        <div class="value" id="classRank">Top 25%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Credits Earned</h4>
                        <div class="value" id="creditsEarned">4.0</div>
                    </div>
                </div>

                <div id="honorRollSection" class="honor-roll" style="display: none;">
                    <h4>🏆 Honor Roll Achievement</h4>
                    <p id="honorRollType">Honor Roll</p>
                </div>

                <div class="breakdown">
                    <h3>Subject Performance</h3>
                    <div class="subject-list">
                        <div class="subject-item header">
                            <span>Subject</span>
                            <span>Grade</span>
                            <span>Letter</span>
                            <span>GPA Points</span>
                        </div>
                        <div id="subjectPerformance">
                            <!-- Subject items will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="breakdown-item">
                        <span>Weighted Average</span>
                        <strong id="weightedAverage">88.8%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Subject Comparison</h3>
                    <div class="subject-chart" id="subjectChart">
                        <!-- Subject bars will be populated by JavaScript -->
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Academic Summary</h3>
                    <div class="breakdown-item">
                        <span>Total Subjects</span>
                        <strong id="totalSubjects">4</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Highest Grade</span>
                        <strong id="highestGrade">92% (Mathematics)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Lowest Grade</span>
                        <strong id="lowestGrade">85% (Science)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Grade Range</span>
                        <strong id="gradeRange">7.0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Attendance Impact</span>
                        <strong id="attendanceImpact">+1.2%</strong>
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
                            <div class="change">Overall performance</div>
                        </div>
                        <div class="performance-card">
                            <h4>GPA Trend</h4>
                            <div class="value" id="gpaTrend">+0.1</div>
                            <div class="change">From previous</div>
                        </div>
                        <div class="performance-card">
                            <h4>Strengths</h4>
                            <div class="value" id="strengthsCount">2</div>
                            <div class="change">A grades</div>
                        </div>
                        <div class="performance-card">
                            <h4>Improvement Areas</h4>
                            <div class="value" id="improvementCount">1</div>
                            <div class="change">Below 85%</div>
                        </div>
                    </div>
                </div>

                <div class="improvement-tips" id="improvementTips">
                    <h4>📈 Improvement Recommendations</h4>
                    <ul id="tipsList">
                        <!-- Tips will be populated by JavaScript -->
                    </ul>
                </div>

                <div class="breakdown">
                    <h3>College Readiness</h3>
                    <div class="breakdown-item">
                        <span>GPA Requirement Met</span>
                        <strong id="gpaRequirement">Yes (3.0+)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Core Subject Average</span>
                        <strong id="coreSubjectAverage">87.5%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>College Eligibility</span>
                        <strong id="collegeEligibility">Highly Qualified</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Scholarship Potential</span>
                        <strong id="scholarshipPotential">Good</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> This report card analysis is based on the provided data and standard grading scales. Actual academic standing, honor roll eligibility, and college readiness may vary by institution and specific program requirements.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📊 Report Card Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Comprehensive academic performance analysis</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('reportCardForm');
        let currentPreset = '';

        // GPA conversion scales
        const gpaScales = {
            percentage: {
                A: { min: 90, points: 4.0 },
                B: { min: 80, points: 3.0 },
                C: { min: 70, points: 2.0 },
                D: { min: 60, points: 1.0 },
                F: { min: 0, points: 0.0 }
            },
            weighted: {
                A: { min: 90, points: 5.0 },
                B: { min: 80, points: 4.0 },
                C: { min: 70, points: 3.0 },
                D: { min: 60, points: 2.0 },
                F: { min: 0, points: 0.0 }
            }
        };

        // Honor roll thresholds
        const honorRollThresholds = {
            elementary: { honor: 90, highHonor: 95 },
            middle: { honor: 85, highHonor: 90 },
            highschool: { honor: 85, highHonor: 90 },
            college: { honor: 3.5, highHonor: 3.8 }
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateReportCard();
        });

        function setPreset(name, system, level) {
            document.getElementById('gradingSystem').value = system;
            document.getElementById('gradeLevel').value = level;
            currentPreset = name;
            
            // Set example grades based on preset
            const subjects = document.querySelectorAll('.subject-row');
            if (name === 'Honor Roll') {
                subjects[0].querySelector('.subject-grade').value = 95;
                subjects[1].querySelector('.subject-grade').value = 92;
                subjects[2].querySelector('.subject-grade').value = 94;
                subjects[3].querySelector('.subject-grade').value = 91;
            } else if (name === 'Average') {
                subjects[0].querySelector('.subject-grade').value = 85;
                subjects[1].querySelector('.subject-grade').value = 82;
                subjects[2].querySelector('.subject-grade').value = 88;
                subjects[3].querySelector('.subject-grade').value = 84;
            } else if (name === 'College Prep') {
                subjects[0].querySelector('.subject-grade').value = 92;
                subjects[1].querySelector('.subject-grade').value = 89;
                subjects[2].querySelector('.subject-grade').value = 94;
                subjects[3].querySelector('.subject-grade').value = 91;
            }
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateReportCard();
        }

        function addSubject() {
            const container = document.getElementById('subjectsContainer');
            const newRow = document.createElement('div');
            newRow.className = 'subject-row';
            newRow.innerHTML = `
                <input type="text" placeholder="Subject Name" value="New Subject" class="subject-name">
                <input type="number" placeholder="Grade" value="0" min="0" max="100" step="0.1" class="subject-grade">
                <input type="number" placeholder="Credits" value="1" min="0" max="5" step="0.5" class="subject-credits">
                <button type="button" class="btn-danger" onclick="removeSubject(this)">×</button>
            `;
            container.appendChild(newRow);
        }

        function removeSubject(button) {
            const row = button.parentElement;
            if (document.querySelectorAll('.subject-row').length > 1) {
                row.remove();
            }
        }

        function calculateReportCard() {
            // Get inputs
            const gradingSystem = document.getElementById('gradingSystem').value;
            const gradeLevel = document.getElementById('gradeLevel').value;
            const previousGPA = parseFloat(document.getElementById('previousGPA').value) || 0;
            const attendance = parseFloat(document.getElementById('attendance').value) || 100;

            // Get subject data
            const subjects = [];
            let totalCredits = 0;
            let totalWeightedGrade = 0;
            
            document.querySelectorAll('.subject-row').forEach(row => {
                const name = row.querySelector('.subject-name').value || 'Subject';
                const grade = parseFloat(row.querySelector('.subject-grade').value) || 0;
                const credits = parseFloat(row.querySelector('.subject-credits').value) || 0;
                
                if (grade > 0) {
                    subjects.push({ name, grade, credits });
                    totalCredits += credits;
                    totalWeightedGrade += grade * credits;
                }
            });

            // Calculate overall average
            const overallAverage = totalCredits > 0 ? totalWeightedGrade / totalCredits : 0;

            // Calculate GPA
            const gpaScale = gradingSystem === 'weighted' ? gpaScales.weighted : gpaScales.percentage;
            let totalGPApoints = 0;
            let totalGPACredits = 0;

            subjects.forEach(subject => {
                let points = 0;
                if (subject.grade >= gpaScale.A.min) points = gpaScale.A.points;
                else if (subject.grade >= gpaScale.B.min) points = gpaScale.B.points;
                else if (subject.grade >= gpaScale.C.min) points = gpaScale.C.points;
                else if (subject.grade >= gpaScale.D.min) points = gpaScale.D.points;
                
                totalGPApoints += points * subject.credits;
                totalGPACredits += subject.credits;
            });

            const cumulativeGPA = totalGPACredits > 0 ? totalGPApoints / totalGPACredits : 0;

            // Calculate performance metrics
            const highestGrade = Math.max(...subjects.map(s => s.grade));
            const lowestGrade = Math.min(...subjects.map(s => s.grade));
            const gradeRange = highestGrade - lowestGrade;
            const strengthsCount = subjects.filter(s => s.grade >= 90).length;
            const improvementCount = subjects.filter(s => s.grade < 85).length;
            const gpaTrend = previousGPA > 0 ? (cumulativeGPA - previousGPA).toFixed(1) : 0;

            // Calculate class rank (simplified)
            const classRank = calculateClassRank(overallAverage, gradeLevel);

            // Calculate honor roll status
            const honorRoll = calculateHonorRoll(overallAverage, cumulativeGPA, gradeLevel, gradingSystem);

            // Calculate attendance impact
            const attendanceImpact = calculateAttendanceImpact(attendance, overallAverage);

            // Calculate college readiness
            const collegeReadiness = calculateCollegeReadiness(cumulativeGPA, subjects);

            // Generate improvement tips
            const improvementTips = generateImprovementTips(subjects, overallAverage);

            // Update UI
            document.getElementById('overallAverage').textContent = overallAverage.toFixed(1) + '%';
            document.getElementById('cumulativeGPA').textContent = cumulativeGPA.toFixed(2);
            document.getElementById('classRank').textContent = classRank;
            document.getElementById('creditsEarned').textContent = totalCredits.toFixed(1);

            document.getElementById('weightedAverage').textContent = overallAverage.toFixed(1) + '%';
            document.getElementById('totalSubjects').textContent = subjects.length;
            document.getElementById('highestGrade').textContent = highestGrade.toFixed(1) + '% (' + 
                subjects.find(s => s.grade === highestGrade).name + ')';
            document.getElementById('lowestGrade').textContent = lowestGrade.toFixed(1) + '% (' + 
                subjects.find(s => s.grade === lowestGrade).name + ')';
            document.getElementById('gradeRange').textContent = gradeRange.toFixed(1) + '%';
            document.getElementById('attendanceImpact').textContent = (attendanceImpact > 0 ? '+' : '') + attendanceImpact.toFixed(1) + '%';

            document.getElementById('academicStanding').textContent = getAcademicStanding(overallAverage);
            document.getElementById('gpaTrend').textContent = (gpaTrend > 0 ? '+' : '') + gpaTrend;
            document.getElementById('strengthsCount').textContent = strengthsCount;
            document.getElementById('improvementCount').textContent = improvementCount;

            document.getElementById('gpaRequirement').textContent = cumulativeGPA >= 3.0 ? 'Yes (3.0+)' : 'No';
            document.getElementById('coreSubjectAverage').textContent = calculateCoreSubjectAverage(subjects).toFixed(1) + '%';
            document.getElementById('collegeEligibility').textContent = collegeReadiness.eligibility;
            document.getElementById('scholarshipPotential').textContent = collegeReadiness.scholarship;

            // Update honor roll section
            const honorRollSection = document.getElementById('honorRollSection');
            const honorRollType = document.getElementById('honorRollType');
            if (honorRoll.achieved) {
                honorRollSection.style.display = 'block';
                honorRollType.textContent = honorRoll.type;
            } else {
                honorRollSection.style.display = 'none';
            }

            // Update visual indicators
            document.getElementById('gradeFill').style.width = overallAverage + '%';

            // Update subject performance and chart
            updateSubjectPerformance(subjects, gpaScale);
            updateSubjectChart(subjects);

            // Update improvement tips
            updateImprovementTips(improvementTips);
        }

        function calculateClassRank(average, level) {
            if (average >= 95) return 'Top 5%';
            if (average >= 90) return 'Top 15%';
            if (average >= 85) return 'Top 30%';
            if (average >= 80) return 'Top 50%';
            if (average >= 70) return 'Top 75%';
            return 'Bottom 25%';
        }

        function calculateHonorRoll(average, gpa, level, system) {
            const thresholds = honorRollThresholds[level];
            
            if (system === 'gpa' || system === 'weighted') {
                if (gpa >= thresholds.highHonor) return { achieved: true, type: 'High Honor Roll' };
                if (gpa >= thresholds.honor) return { achieved: true, type: 'Honor Roll' };
            } else {
                if (average >= thresholds.highHonor) return { achieved: true, type: 'High Honor Roll' };
                if (average >= thresholds.honor) return { achieved: true, type: 'Honor Roll' };
            }
            
            return { achieved: false, type: '' };
        }

        function calculateAttendanceImpact(attendance, average) {
            if (attendance >= 98) return 2.0;
            if (attendance >= 95) return 1.5;
            if (attendance >= 90) return 1.0;
            if (attendance >= 85) return 0.5;
            if (attendance >= 80) return 0;
            return -2.0; // Negative impact for poor attendance
        }

        function calculateCollegeReadiness(gpa, subjects) {
            const coreAverage = calculateCoreSubjectAverage(subjects);
            
            let eligibility = 'Highly Qualified';
            let scholarship = 'Excellent';
            
            if (gpa < 2.5 || coreAverage < 80) {
                eligibility = 'Conditional';
                scholarship = 'Limited';
            } else if (gpa < 3.0 || coreAverage < 85) {
                eligibility = 'Qualified';
                scholarship = 'Good';
            } else if (gpa < 3.5 || coreAverage < 90) {
                eligibility = 'Well Qualified';
                scholarship = 'Very Good';
            }
            
            return { eligibility, scholarship };
        }

        function calculateCoreSubjectAverage(subjects) {
            const coreSubjects = ['Mathematics', 'English', 'Science', 'History', 'Social Studies'];
            const coreGrades = subjects.filter(s => 
                coreSubjects.some(core => s.name.toLowerCase().includes(core.toLowerCase()))
            );
            
            if (coreGrades.length === 0) return 0;
            
            const total = coreGrades.reduce((sum, subject) => sum + subject.grade, 0);
            return total / coreGrades.length;
        }

        function getAcademicStanding(average) {
            if (average >= 90) return 'Excellent';
            if (average >= 85) return 'Very Good';
            if (average >= 80) return 'Good';
            if (average >= 75) return 'Satisfactory';
            if (average >= 70) return 'Needs Improvement';
            return 'Academic Concern';
        }

        function generateImprovementTips(subjects, overallAverage) {
            const tips = [];
            
            if (overallAverage < 85) {
                tips.push('Focus on improving your overall study habits and time management');
            }
            
            const lowSubjects = subjects.filter(s => s.grade < 80);
            lowSubjects.forEach(subject => {
                tips.push(`Seek extra help in ${subject.name} - consider tutoring or study groups`);
            });
            
            if (subjects.some(s => s.grade >= 90)) {
                const strongSubject = subjects.find(s => s.grade >= 90);
                tips.push(`Use your success in ${strongSubject.name} as a model for other subjects`);
            }
            
            if (tips.length === 0) {
                tips.push('Maintain your current study habits and continue excelling in all subjects');
                tips.push('Consider challenging yourself with advanced or honors courses');
            }
            
            return tips.slice(0, 3); // Return top 3 tips
        }

        function getLetterGrade(percentage) {
            if (percentage >= 90) return 'A';
            if (percentage >= 80) return 'B';
            if (percentage >= 70) return 'C';
            if (percentage >= 60) return 'D';
            return 'F';
        }

        function getGPAPoints(percentage, scale) {
            if (percentage >= scale.A.min) return scale.A.points;
            if (percentage >= scale.B.min) return scale.B.points;
            if (percentage >= scale.C.min) return scale.C.points;
            if (percentage >= scale.D.min) return scale.D.points;
            return scale.F.points;
        }

        function updateSubjectPerformance(subjects, gpaScale) {
            const performance = document.getElementById('subjectPerformance');
            performance.innerHTML = '';

            subjects.forEach(subject => {
                const letterGrade = getLetterGrade(subject.grade);
                const gpaPoints = getGPAPoints(subject.grade, gpaScale);
                
                const item = document.createElement('div');
                item.className = 'subject-item';
                item.innerHTML = `
                    <span>${subject.name}</span>
                    <span>${subject.grade.toFixed(1)}%</span>
                    <span class="letter-grade grade-${letterGrade}">${letterGrade}</span>
                    <span>${gpaPoints.toFixed(1)}</span>
                `;
                performance.appendChild(item);
            });
        }

        function updateSubjectChart(subjects) {
            const chart = document.getElementById('subjectChart');
            chart.innerHTML = '';

            subjects.forEach(subject => {
                const bar = document.createElement('div');
                bar.className = 'subject-bar';
                bar.innerHTML = `
                    <div class="name">${subject.name}</div>
                    <div class="bar">
                        <div class="fill" style="height: ${subject.grade}%"></div>
                    </div>
                    <div class="grade">${subject.grade.toFixed(1)}%</div>
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

        // Initialize
        window.addEventListener('load', function() {
            calculateReportCard();
        });
    </script>
</body>
</html>
