<?php
/**
 * Final Grade Calculator
 * File: education/final-grade-calculator.php
 * Description: Advanced final grade calculator with multiple calculation methods and performance analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Grade Calculator - Calculate Required Final Exam Scores</title>
    <meta name="description" content="Advanced final grade calculator. Calculate required final exam scores, analyze grade scenarios, and plan your study strategy.">
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
        
        .input-group { 
            display: grid; 
            grid-template-columns: 2fr 1fr; 
            gap: 10px; 
            align-items: end; 
        }
        
        .assignment-row { 
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
        
        .scenario-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 15px; 
            margin-top: 15px; 
        }
        .scenario-card { 
            background: white; 
            padding: 15px; 
            border-radius: 8px; 
            border: 2px solid #e0e0e0; 
            text-align: center; 
            transition: all 0.3s; 
        }
        .scenario-card:hover { 
            transform: translateY(-2px); 
            border-color: #667eea; 
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.2); 
        }
        .scenario-card h4 { 
            color: #667eea; 
            margin-bottom: 10px; 
        }
        .scenario-card .score { 
            font-size: 1.5rem; 
            font-weight: bold; 
            color: #333; 
        }
        .scenario-card .result { 
            color: #666; 
            font-size: 0.9rem; 
        }
        
        .difficulty-indicator { 
            height: 10px; 
            background: #e0e0e0; 
            border-radius: 5px; 
            overflow: hidden; 
            margin: 10px 0; 
            position: relative; 
        }
        .difficulty-fill { 
            height: 100%; 
            background: linear-gradient(90deg, #28a745, #ffc107, #dc3545); 
            width: 0%; 
            transition: width 1s ease-out; 
        }
        .difficulty-labels { 
            display: flex; 
            justify-content: space-between; 
            margin-top: 5px; 
            font-size: 0.8rem; 
            color: #666; 
        }
        
        .study-plan { 
            background: #e8f5e8; 
            padding: 15px; 
            border-radius: 8px; 
            border-left: 4px solid #28a745; 
            margin: 15px 0; 
        }
        .study-plan h4 { 
            color: #2c3e50; 
            margin-bottom: 10px; 
        }
        .study-plan p { 
            color: #666; 
            margin-bottom: 8px; 
        }
        
        .final-preset { 
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
        
        .letter-grade { 
            font-size: 2rem; 
            font-weight: bold; 
            text-align: center; 
            margin: 10px 0; 
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
            .input-group { 
                grid-template-columns: 1fr; 
            }
            .final-preset { 
                grid-template-columns: repeat(2, 1fr); 
            }
            .scenario-grid { 
                grid-template-columns: 1fr; 
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
            <h1>🎯 Final Grade Calculator</h1>
            <p>Calculate required final exam scores and plan your study strategy</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Course Information</h2>
                <form id="finalGradeForm">
                    
                    <div class="form-group">
                        <label for="calculationMethod">Calculation Method</label>
                        <select id="calculationMethod" style="padding: 12px;">
                            <option value="desired" selected>Desired Final Grade</option>
                            <option value="minimum">Minimum Passing Grade</option>
                            <option value="maintain">Maintain Current Grade</option>
                            <option value="specific">Specific Final Exam Score</option>
                        </select>
                        <small>Choose how you want to calculate your final grade</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentAverage">Current Course Average</label>
                        <div class="input-group">
                            <input type="number" id="currentAverage" value="85" min="0" max="100" step="0.1" required>
                            <select style="padding: 12px;" disabled>
                                <option>%</option>
                            </select>
                        </div>
                        <small>Your current grade in the course</small>
                    </div>
                    
                    <div class="form-group" id="desiredGradeGroup">
                        <label for="desiredGrade">Desired Final Grade</label>
                        <div class="input-group">
                            <input type="number" id="desiredGrade" value="90" min="0" max="100" step="0.1" required>
                            <select style="padding: 12px;" disabled>
                                <option>%</option>
                            </select>
                        </div>
                        <small>The final grade you want to achieve</small>
                    </div>
                    
                    <div class="form-group" id="finalWeightGroup">
                        <label for="finalWeight">Final Exam Weight</label>
                        <div class="input-group">
                            <input type="number" id="finalWeight" value="30" min="0" max="100" step="1" required>
                            <select style="padding: 12px;" disabled>
                                <option>%</option>
                            </select>
                        </div>
                        <small>How much the final exam counts toward your final grade</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Course Presets</label>
                        <div class="final-preset">
                            <div class="preset-btn" onclick="setPreset('Standard', '85', '90', '30')">Standard Course</div>
                            <div class="preset-btn" onclick="setPreset('Heavy Final', '80', '85', '50')">Heavy Final</div>
                            <div class="preset-btn" onclick="setPreset('Light Final', '88', '92', '15')">Light Final</div>
                            <div class="preset-btn" onclick="setPreset('Passing', '72', '70', '25')">Just Passing</div>
                            <div class="preset-btn" onclick="setPreset('Honors', '92', '95', '35')">Honors Course</div>
                            <div class="preset-btn" onclick="setPreset('Graduate', '88', '90', '40')">Graduate Level</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="gradeScale">Grading Scale</label>
                        <select id="gradeScale" style="padding: 12px;">
                            <option value="standard" selected>Standard (A=90+, B=80+, etc.)</option>
                            <option value="college">College (A=93+, B=85+, etc.)</option>
                            <option value="strict">Strict (A=95+, B=87+, etc.)</option>
                        </select>
                        <small>Your institution's grading scale</small>
                    </div>
                    
                    <div class="form-group">
                        <h4 style="color: #667eea; margin-bottom: 15px;">Assignment Categories (Optional)</h4>
                        <div id="categoriesContainer">
                            <div class="assignment-row">
                                <input type="text" placeholder="Category Name" value="Exams">
                                <input type="number" placeholder="Average" value="82" min="0" max="100" step="0.1">
                                <input type="number" placeholder="Weight %" value="40" min="0" max="100" step="1">
                                <button type="button" class="btn-danger" onclick="removeCategory(this)">×</button>
                            </div>
                            <div class="assignment-row">
                                <input type="text" placeholder="Category Name" value="Homework">
                                <input type="number" placeholder="Average" value="92" min="0" max="100" step="0.1">
                                <input type="number" placeholder="Weight %" value="20" min="0" max="100" step="1">
                                <button type="button" class="btn-danger" onclick="removeCategory(this)">×</button>
                            </div>
                            <div class="assignment-row">
                                <input type="text" placeholder="Category Name" value="Projects">
                                <input type="number" placeholder="Average" value="88" min="0" max="100" step="0.1">
                                <input type="number" placeholder="Weight %" value="10" min="0" max="100" step="1">
                                <button type="button" class="btn-danger" onclick="removeCategory(this)">×</button>
                            </div>
                        </div>
                        <button type="button" class="btn-success" onclick="addCategory()" style="margin-top: 10px;">+ Add Category</button>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Final Requirements</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Final Exam Analysis</h2>
                
                <div class="result-card">
                    <h3>Required Final Exam Score</h3>
                    <div class="amount" id="requiredScore">78.6%</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Current Grade</h4>
                        <div class="value" id="currentGradeDisplay">85.0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Target Grade</h4>
                        <div class="value" id="targetGradeDisplay">90.0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Difficulty Level</h4>
                        <div class="value" id="difficultyLevel">Moderate</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Grade Calculation</h3>
                    <div class="breakdown-item">
                        <span>Current Course Average</span>
                        <strong id="currentCourseAverage">85.0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Final Exam Weight</span>
                        <strong id="finalExamWeight">30%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weight of Current Work</span>
                        <strong id="currentWorkWeight">70%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Points from Current Work</span>
                        <strong id="pointsFromCurrent">59.5</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Points Needed from Final</span>
                        <strong id="pointsNeeded">27.0</strong>
                    </div>
                    
                    <div class="difficulty-indicator">
                        <div class="difficulty-fill" id="difficultyFill"></div>
                    </div>
                    <div class="difficulty-labels">
                        <span>Easy</span>
                        <span>Moderate</span>
                        <span>Challenging</span>
                        <span>Very Difficult</span>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Grade Scenarios</h3>
                    <div class="scenario-grid">
                        <div class="scenario-card">
                            <h4>If Final = 100%</h4>
                            <div class="score" id="scenario100">89.5%</div>
                            <div class="result" id="result100">B+</div>
                        </div>
                        <div class="scenario-card">
                            <h4>If Final = 80%</h4>
                            <div class="score" id="scenario80">87.5%</div>
                            <div class="result" id="result80">B+</div>
                        </div>
                        <div class="scenario-card">
                            <h4>If Final = 60%</h4>
                            <div class="score" id="scenario60">85.5%</div>
                            <div class="result" id="result60">B</div>
                        </div>
                        <div class="scenario-card">
                            <h4>If Final = 40%</h4>
                            <div class="score" id="scenario40">83.5%</div>
                            <div class="result" id="result40">B</div>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Performance Analysis</h3>
                    <div class="performance-grid">
                        <div class="performance-card">
                            <h4>Study Hours Needed</h4>
                            <div class="value" id="studyHours">15 hours</div>
                            <div class="change">Estimated time</div>
                        </div>
                        <div class="performance-card">
                            <h4>Success Probability</h4>
                            <div class="value" id="successProbability">65%</div>
                            <div class="change">Based on history</div>
                        </div>
                        <div class="performance-card">
                            <h4>Grade Improvement</h4>
                            <div class="value" id="gradeImprovement">+5.0%</div>
                            <div class="change">From current</div>
                        </div>
                        <div class="performance-card">
                            <h4>Risk Level</h4>
                            <div class="value" id="riskLevel">Medium</div>
                            <div class="change">Chance of missing target</div>
                        </div>
                    </div>
                </div>

                <div class="study-plan">
                    <h4>📚 Recommended Study Plan</h4>
                    <p id="studyFocus">Focus on chapters 5-8 and review key concepts from midterms</p>
                    <p id="studySchedule">Study 2 hours daily for the next 7 days</p>
                    <p id="studyResources">Utilize practice exams and textbook exercises</p>
                </div>

                <div class="breakdown">
                    <h3>Letter Grade Analysis</h3>
                    <div class="breakdown-item">
                        <span>Current Letter Grade</span>
                        <strong id="currentLetterGrade">B</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Target Letter Grade</span>
                        <strong id="targetLetterGrade">A-</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Minimum for A</span>
                        <strong id="minForA">95.0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Minimum for B</span>
                        <strong id="minForB">80.0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Passing Grade (D)</span>
                        <strong id="passingGrade">60.0%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Category Breakdown</h3>
                    <div id="categoryBreakdown">
                        <!-- Category items will be populated by JavaScript -->
                    </div>
                    <div class="breakdown-item">
                        <span>Current Weighted Average</span>
                        <strong id="weightedAverage">85.0%</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> These calculations are estimates based on the provided data. Actual grading policies may vary by instructor and institution. Always verify with your course syllabus and communicate with your instructor about specific grading requirements.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>🎯 Final Grade Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced final exam planning and grade analysis</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('finalGradeForm');
        let currentPreset = '';

        // Grade scale definitions
        const gradeScales = {
            standard: { A: 90, B: 80, C: 70, D: 60, F: 0 },
            college: { A: 93, B: 85, C: 77, D: 70, F: 0 },
            strict: { A: 95, B: 87, C: 80, D: 73, F: 0 }
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateFinalGrade();
        });

        function setPreset(name, current, desired, weight) {
            document.getElementById('currentAverage').value = current;
            document.getElementById('desiredGrade').value = desired;
            document.getElementById('finalWeight').value = weight;
            currentPreset = name;
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateFinalGrade();
        }

        function addCategory() {
            const container = document.getElementById('categoriesContainer');
            const newRow = document.createElement('div');
            newRow.className = 'assignment-row';
            newRow.innerHTML = `
                <input type="text" placeholder="Category Name" value="New Category">
                <input type="number" placeholder="Average" value="0" min="0" max="100" step="0.1">
                <input type="number" placeholder="Weight %" value="10" min="0" max="100" step="1">
                <button type="button" class="btn-danger" onclick="removeCategory(this)">×</button>
            `;
            container.appendChild(newRow);
        }

        function removeCategory(button) {
            const row = button.parentElement;
            if (document.querySelectorAll('.assignment-row').length > 1) {
                row.remove();
            }
        }

        function calculateFinalGrade() {
            // Get inputs
            const calculationMethod = document.getElementById('calculationMethod').value;
            let currentAverage = parseFloat(document.getElementById('currentAverage').value);
            const desiredGrade = parseFloat(document.getElementById('desiredGrade').value);
            const finalWeight = parseFloat(document.getElementById('finalWeight').value);
            const gradeScaleType = document.getElementById('gradeScale').value;

            // Get category data and calculate weighted average if provided
            const categories = [];
            let totalCategoryWeight = 0;
            let weightedSum = 0;
            
            document.querySelectorAll('#categoriesContainer .assignment-row').forEach(row => {
                const inputs = row.querySelectorAll('input');
                const name = inputs[0].value || 'Category';
                const average = parseFloat(inputs[1].value) || 0;
                const weight = parseFloat(inputs[2].value) || 0;
                
                if (weight > 0) {
                    categories.push({ name, average, weight });
                    totalCategoryWeight += weight;
                    weightedSum += (average * weight) / 100;
                }
            });

            // Use weighted average if categories are provided and weights add up to 100-finalWeight
            if (categories.length > 0 && Math.abs(totalCategoryWeight - (100 - finalWeight)) < 5) {
                currentAverage = weightedSum;
            }

            const currentWorkWeight = 100 - finalWeight;

            // Calculate required final exam score
            let requiredScore;
            if (calculationMethod === 'desired') {
                requiredScore = (desiredGrade - (currentAverage * currentWorkWeight / 100)) / (finalWeight / 100);
            } else if (calculationMethod === 'minimum') {
                const passingGrade = gradeScales[gradeScaleType].D;
                requiredScore = (passingGrade - (currentAverage * currentWorkWeight / 100)) / (finalWeight / 100);
            } else if (calculationMethod === 'maintain') {
                requiredScore = (currentAverage - (currentAverage * currentWorkWeight / 100)) / (finalWeight / 100);
            } else { // specific
                const specificScore = desiredGrade; // In this mode, desiredGrade is the final exam score
                requiredScore = specificScore;
            }

            // Ensure required score is within valid range
            requiredScore = Math.max(0, Math.min(100, requiredScore));

            // Calculate points
            const pointsFromCurrent = (currentAverage * currentWorkWeight) / 100;
            const totalPointsNeeded = calculationMethod === 'desired' ? desiredGrade : 
                                   calculationMethod === 'minimum' ? gradeScales[gradeScaleType].D : currentAverage;
            const pointsNeeded = totalPointsNeeded - pointsFromCurrent;

            // Calculate scenarios
            const scenario100 = (currentAverage * currentWorkWeight / 100) + (100 * finalWeight / 100);
            const scenario80 = (currentAverage * currentWorkWeight / 100) + (80 * finalWeight / 100);
            const scenario60 = (currentAverage * currentWorkWeight / 100) + (60 * finalWeight / 100);
            const scenario40 = (currentAverage * currentWorkWeight / 100) + (40 * finalWeight / 100);

            // Calculate performance metrics
            const difficulty = calculateDifficulty(requiredScore, currentAverage);
            const studyHours = calculateStudyHours(requiredScore, currentAverage);
            const successProbability = calculateSuccessProbability(requiredScore, currentAverage);
            const gradeImprovement = calculationMethod === 'desired' ? (desiredGrade - currentAverage) : 0;
            const riskLevel = calculateRiskLevel(requiredScore, currentAverage);

            // Generate study plan
            const studyPlan = generateStudyPlan(requiredScore, currentAverage, difficulty);

            // Get letter grades
            const currentLetterGrade = getLetterGrade(currentAverage, gradeScaleType);
            const targetLetterGrade = getLetterGrade(desiredGrade, gradeScaleType);
            const scale = gradeScales[gradeScaleType];

            // Update UI
            document.getElementById('requiredScore').textContent = requiredScore.toFixed(1) + '%';
            document.getElementById('currentGradeDisplay').textContent = currentAverage.toFixed(1) + '%';
            document.getElementById('targetGradeDisplay').textContent = desiredGrade.toFixed(1) + '%';
            document.getElementById('difficultyLevel').textContent = difficulty.level;

            document.getElementById('currentCourseAverage').textContent = currentAverage.toFixed(1) + '%';
            document.getElementById('finalExamWeight').textContent = finalWeight + '%';
            document.getElementById('currentWorkWeight').textContent = currentWorkWeight + '%';
            document.getElementById('pointsFromCurrent').textContent = pointsFromCurrent.toFixed(1);
            document.getElementById('pointsNeeded').textContent = pointsNeeded.toFixed(1);

            document.getElementById('scenario100').textContent = scenario100.toFixed(1) + '%';
            document.getElementById('scenario80').textContent = scenario80.toFixed(1) + '%';
            document.getElementById('scenario60').textContent = scenario60.toFixed(1) + '%';
            document.getElementById('scenario40').textContent = scenario40.toFixed(1) + '%';

            document.getElementById('result100').textContent = getLetterGrade(scenario100, gradeScaleType);
            document.getElementById('result80').textContent = getLetterGrade(scenario80, gradeScaleType);
            document.getElementById('result60').textContent = getLetterGrade(scenario60, gradeScaleType);
            document.getElementById('result40').textContent = getLetterGrade(scenario40, gradeScaleType);

            document.getElementById('studyHours').textContent = studyHours + ' hours';
            document.getElementById('successProbability').textContent = successProbability + '%';
            document.getElementById('gradeImprovement').textContent = (gradeImprovement > 0 ? '+' : '') + gradeImprovement.toFixed(1) + '%';
            document.getElementById('riskLevel').textContent = riskLevel;

            document.getElementById('studyFocus').textContent = studyPlan.focus;
            document.getElementById('studySchedule').textContent = studyPlan.schedule;
            document.getElementById('studyResources').textContent = studyPlan.resources;

            document.getElementById('currentLetterGrade').textContent = currentLetterGrade;
            document.getElementById('targetLetterGrade').textContent = targetLetterGrade;
            document.getElementById('minForA').textContent = scale.A + '%';
            document.getElementById('minForB').textContent = scale.B + '%';
            document.getElementById('passingGrade').textContent = scale.D + '%';

            document.getElementById('weightedAverage').textContent = currentAverage.toFixed(1) + '%';

            // Update visual indicators
            document.getElementById('difficultyFill').style.width = difficulty.percentage + '%';

            // Update category breakdown
            updateCategoryBreakdown(categories);
        }

        function calculateDifficulty(requiredScore, currentAverage) {
            const difference = requiredScore - currentAverage;
            
            if (requiredScore <= 60) return { level: 'Easy', percentage: 25 };
            if (requiredScore <= 70) return { level: 'Moderate', percentage: 50 };
            if (requiredScore <= 80) return { level: 'Challenging', percentage: 75 };
            if (requiredScore <= 90) return { level: 'Difficult', percentage: 90 };
            return { level: 'Very Difficult', percentage: 100 };
        }

        function calculateStudyHours(requiredScore, currentAverage) {
            const difficulty = Math.max(0, requiredScore - currentAverage);
            return Math.max(5, Math.ceil(difficulty * 2)); // At least 5 hours, more for bigger gaps
        }

        function calculateSuccessProbability(requiredScore, currentAverage) {
            const difference = requiredScore - currentAverage;
            
            if (difference <= 0) return 95;
            if (difference <= 5) return 80;
            if (difference <= 10) return 65;
            if (difference <= 15) return 45;
            if (difference <= 20) return 25;
            return 10;
        }

        function calculateRiskLevel(requiredScore, currentAverage) {
            const probability = calculateSuccessProbability(requiredScore, currentAverage);
            
            if (probability >= 80) return 'Low';
            if (probability >= 60) return 'Medium';
            if (probability >= 40) return 'High';
            return 'Very High';
        }

        function generateStudyPlan(requiredScore, currentAverage, difficulty) {
            let focus, schedule, resources;
            
            if (difficulty.level === 'Easy') {
                focus = 'Review key concepts and practice with sample questions';
                schedule = 'Study 1 hour daily for the next 3-4 days';
                resources = 'Review notes and textbook examples';
            } else if (difficulty.level === 'Moderate') {
                focus = 'Focus on weaker areas and complete practice problems';
                schedule = 'Study 1-2 hours daily for the next 5-6 days';
                resources = 'Practice exams and textbook exercises';
            } else if (difficulty.level === 'Challenging') {
                focus = 'Comprehensive review of all topics, emphasis on difficult concepts';
                schedule = 'Study 2-3 hours daily for the next 7-8 days';
                resources = 'Practice exams, study groups, and instructor office hours';
            } else {
                focus = 'Intensive review of all material, focus on high-yield topics';
                schedule = 'Study 3-4 hours daily for the next 10+ days';
                resources = 'All available resources: practice exams, tutoring, study groups, office hours';
            }
            
            return { focus, schedule, resources };
        }

        function getLetterGrade(percentage, scaleType) {
            const scale = gradeScales[scaleType];
            if (percentage >= scale.A) return 'A';
            if (percentage >= scale.B) return 'B';
            if (percentage >= scale.C) return 'C';
            if (percentage >= scale.D) return 'D';
            return 'F';
        }

        function updateCategoryBreakdown(categories) {
            const breakdown = document.getElementById('categoryBreakdown');
            breakdown.innerHTML = '';

            categories.forEach(category => {
                const item = document.createElement('div');
                item.className = 'breakdown-item';
                item.innerHTML = `
                    <span>${category.name}</span>
                    <strong>${category.average.toFixed(1)}% (${category.weight}%)</strong>
                `;
                breakdown.appendChild(item);
            });

            if (categories.length === 0) {
                const item = document.createElement('div');
                item.className = 'breakdown-item';
                item.innerHTML = `<span>No categories provided</span><strong>Using current average</strong>`;
                breakdown.appendChild(item);
            }
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateFinalGrade();
        });
    </script>
</body>
</html>
