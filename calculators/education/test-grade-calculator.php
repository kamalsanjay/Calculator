<?php
/**
 * Test Grade Calculator
 * File: education/test-grade-calculator.php
 * Description: Advanced test grade calculator with multiple grading methods, curve calculations, and performance analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Grade Calculator - Score Calculation & Performance Analysis</title>
    <meta name="description" content="Advanced test grade calculator with multiple grading methods, curve calculations, and detailed performance analysis.">
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
        
        .question-row { 
            display: grid; 
            grid-template-columns: 1fr 1fr auto; 
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
        
        .question-list { 
            max-height: 300px; 
            overflow-y: auto; 
            margin: 15px 0; 
            border: 1px solid #e0e0e0; 
            border-radius: 8px; 
            padding: 10px; 
        }
        
        .question-item { 
            display: grid; 
            grid-template-columns: 1fr 1fr 1fr 1fr; 
            gap: 10px; 
            padding: 8px; 
            border-bottom: 1px solid #e0e0e0; 
            align-items: center; 
        }
        .question-item:last-child { 
            border-bottom: none; 
        }
        .question-item.header { 
            font-weight: bold; 
            background: #f8f9fa; 
            border-radius: 4px; 
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
        
        .curve-options { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 10px; 
            margin: 15px 0; 
        }
        .curve-card { 
            background: white; 
            padding: 15px; 
            border-radius: 8px; 
            border: 2px solid #e0e0e0; 
            text-align: center; 
            cursor: pointer; 
            transition: all 0.3s; 
        }
        .curve-card:hover { 
            transform: translateY(-2px); 
            border-color: #667eea; 
        }
        .curve-card.active { 
            border-color: #667eea; 
            background: #f0f4ff; 
        }
        .curve-card h4 { 
            color: #667eea; 
            margin-bottom: 8px; 
        }
        .curve-card .score { 
            font-size: 1.2rem; 
            font-weight: bold; 
            color: #333; 
        }
        
        .test-preset { 
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
            .question-row { 
                grid-template-columns: 1fr; 
                gap: 5px; 
            }
            .question-item { 
                grid-template-columns: 1fr; 
                text-align: center; 
            }
            .input-group { 
                grid-template-columns: 1fr; 
            }
            .test-preset { 
                grid-template-columns: repeat(2, 1fr); 
            }
            .curve-options { 
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
            <h1>📝 Test Grade Calculator</h1>
            <p>Calculate test scores, apply grading curves, and analyze performance</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Test Information</h2>
                <form id="testGradeForm">
                    
                    <div class="form-group">
                        <label for="gradingMethod">Grading Method</label>
                        <select id="gradingMethod" style="padding: 12px;">
                            <option value="points" selected>Points Based</option>
                            <option value="percentage">Percentage Based</option>
                            <option value="weighted">Weighted Questions</option>
                            <option value="curve">Curved Grading</option>
                        </select>
                        <small>Select how your test is graded</small>
                    </div>
                    
                    <div class="form-group" id="totalPointsGroup">
                        <label for="totalPoints">Total Possible Points</label>
                        <input type="number" id="totalPoints" value="100" min="1" max="1000" step="1" required>
                        <small>Total points available on the test</small>
                    </div>
                    
                    <div class="form-group" id="earnedPointsGroup">
                        <label for="earnedPoints">Points Earned</label>
                        <input type="number" id="earnedPoints" value="85" min="0" max="1000" step="0.5" required>
                        <small>Points you earned on the test</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Test Presets</label>
                        <div class="test-preset">
                            <div class="preset-btn" onclick="setPreset('Standard', '100', '85')">Standard Test</div>
                            <div class="preset-btn" onclick="setPreset('Midterm', '150', '120')">Midterm Exam</div>
                            <div class="preset-btn" onclick="setPreset('Final', '200', '165')">Final Exam</div>
                            <div class="preset-btn" onclick="setPreset('Quiz', '50', '42')">Quiz</div>
                            <div class="preset-btn" onclick="setPreset('AP Exam', '100', '75')">AP Exam</div>
                            <div class="preset-btn" onclick="setPreset('Perfect', '100', '100')">Perfect Score</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="gradeScale">Grading Scale</label>
                        <select id="gradeScale" style="padding: 12px;">
                            <option value="standard" selected>Standard (A=90+, B=80+, etc.)</option>
                            <option value="college">College (A=93+, B=85+, etc.)</option>
                            <option value="strict">Strict (A=95+, B=87+, etc.)</option>
                            <option value="passfail">Pass/Fail (70+ to pass)</option>
                        </select>
                        <small>Your institution's grading scale</small>
                    </div>
                    
                    <div class="form-group">
                        <h4 style="color: #667eea; margin-bottom: 15px;">Question Breakdown (Optional)</h4>
                        <div id="questionsContainer">
                            <div class="question-row">
                                <input type="text" placeholder="Question Type" value="Multiple Choice">
                                <input type="number" placeholder="Points" value="60" min="0" max="1000" step="1">
                                <input type="number" placeholder="Earned" value="52" min="0" max="1000" step="0.5">
                                <button type="button" class="btn-danger" onclick="removeQuestion(this)">×</button>
                            </div>
                            <div class="question-row">
                                <input type="text" placeholder="Question Type" value="Short Answer">
                                <input type="number" placeholder="Points" value="25" min="0" max="1000" step="1">
                                <input type="number" placeholder="Earned" value="20" min="0" max="1000" step="0.5">
                                <button type="button" class="btn-danger" onclick="removeQuestion(this)">×</button>
                            </div>
                            <div class="question-row">
                                <input type="text" placeholder="Question Type" value="Essay">
                                <input type="number" placeholder="Points" value="15" min="0" max="1000" step="1">
                                <input type="number" placeholder="Earned" value="13" min="0" max="1000" step="0.5">
                                <button type="button" class="btn-danger" onclick="removeQuestion(this)">×</button>
                            </div>
                        </div>
                        <button type="button" class="btn-success" onclick="addQuestion()" style="margin-top: 10px;">+ Add Question Type</button>
                    </div>
                    
                    <div class="form-group">
                        <label for="classAverage">Class Average (Optional)</label>
                        <input type="number" id="classAverage" value="78" min="0" max="100" step="0.1">
                        <small>Average score of the entire class for curve calculations</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="testWeight">Test Weight in Course</label>
                        <div class="input-group">
                            <input type="number" id="testWeight" value="20" min="0" max="100" step="1">
                            <select style="padding: 12px;" disabled>
                                <option>%</option>
                            </select>
                        </div>
                        <small>How much this test counts toward your final grade</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Test Grade</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Test Analysis</h2>
                
                <div class="result-card">
                    <h3>Test Score</h3>
                    <div class="amount" id="testScore">85.0%</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Letter Grade</h4>
                        <div class="value" id="letterGrade">B</div>
                    </div>
                    <div class="metric-card">
                        <h4>GPA Points</h4>
                        <div class="value" id="gpaPoints">3.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Percentile</h4>
                        <div class="value" id="percentile">75th</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Score Calculation</h3>
                    <div class="breakdown-item">
                        <span>Points Earned</span>
                        <strong id="pointsEarnedDisplay">85</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Points</span>
                        <strong id="totalPointsDisplay">100</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Raw Percentage</span>
                        <strong id="rawPercentage">85.0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Curved Score</span>
                        <strong id="curvedScore">85.0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Final Score</span>
                        <strong id="finalScore">85.0%</strong>
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
                    <h3>Grading Curve Options</h3>
                    <div class="curve-options">
                        <div class="curve-card" onclick="applyCurve('none')">
                            <h4>No Curve</h4>
                            <div class="score" id="curveNone">85.0%</div>
                            <div class="change">Raw Score</div>
                        </div>
                        <div class="curve-card" onclick="applyCurve('linear')">
                            <h4>Linear Curve</h4>
                            <div class="score" id="curveLinear">87.0%</div>
                            <div class="change">+2.0%</div>
                        </div>
                        <div class="curve-card" onclick="applyCurve('squareRoot')">
                            <h4>Square Root</h4>
                            <div class="score" id="curveSquareRoot">92.2%</div>
                            <div class="change">+7.2%</div>
                        </div>
                        <div class="curve-card" onclick="applyCurve('classAverage')">
                            <h4>Class Average</h4>
                            <div class="score" id="curveClassAverage">89.0%</div>
                            <div class="change">+4.0%</div>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Question Performance</h3>
                    <div class="question-list">
                        <div class="question-item header">
                            <span>Question Type</span>
                            <span>Possible</span>
                            <span>Earned</span>
                            <span>Percentage</span>
                        </div>
                        <div id="questionPerformance">
                            <!-- Question items will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="breakdown-item">
                        <span>Overall Accuracy</span>
                        <strong id="overallAccuracy">85.0%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Performance Analysis</h3>
                    <div class="performance-grid">
                        <div class="performance-card">
                            <h4>Strength Areas</h4>
                            <div class="value" id="strengthAreas">Essay</div>
                            <div class="change">Highest scoring</div>
                        </div>
                        <div class="performance-card">
                            <h4>Improvement Areas</h4>
                            <div class="value" id="improvementAreas">Short Answer</div>
                            <div class="change">Lowest scoring</div>
                        </div>
                        <div class="performance-card">
                            <h4>Time Efficiency</h4>
                            <div class="value" id="timeEfficiency">Good</div>
                            <div class="change">Points per minute</div>
                        </div>
                        <div class="performance-card">
                            <h4>Error Rate</h4>
                            <div class="value" id="errorRate">15.0%</div>
                            <div class="change">Points lost</div>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Course Impact</h3>
                    <div class="breakdown-item">
                        <span>Test Weight</span>
                        <strong id="testWeightDisplay">20%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Current Course Grade</span>
                        <strong id="currentCourseGrade">88.0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>New Course Grade</span>
                        <strong id="newCourseGrade">87.4%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Grade Change</span>
                        <strong id="gradeChange">-0.6%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Letter Grade Impact</span>
                        <strong id="letterGradeImpact">None</strong>
                    </div>
                </div>

                <div class="improvement-tips" id="improvementTips">
                    <h4>📈 Test Improvement Tips</h4>
                    <ul id="tipsList">
                        <!-- Tips will be populated by JavaScript -->
                    </ul>
                </div>

                <div class="breakdown">
                    <h3>Study Recommendations</h3>
                    <div class="breakdown-item">
                        <span>Recommended Study Time</span>
                        <strong id="studyTime">5 hours</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Focus Areas</span>
                        <strong id="focusAreas">Short Answer questions</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Study Methods</span>
                        <strong id="studyMethods">Practice tests, flashcards</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Next Test Goal</span>
                        <strong id="nextTestGoal">90% (A-)</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> Test score calculations are estimates based on the provided data. Actual grading policies, curves, and weighting may vary by instructor and institution. Always verify with your course syllabus and instructor.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📝 Test Grade Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Comprehensive test score analysis and improvement planning</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('testGradeForm');
        let currentPreset = '';
        let currentCurve = 'none';

        // Grade scale definitions
        const gradeScales = {
            standard: { A: 90, B: 80, C: 70, D: 60, F: 0 },
            college: { A: 93, B: 85, C: 77, D: 70, F: 0 },
            strict: { A: 95, B: 87, C: 80, D: 73, F: 0 },
            passfail: { Pass: 70, Fail: 0 }
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateTestGrade();
        });

        function setPreset(name, total, earned) {
            document.getElementById('totalPoints').value = total;
            document.getElementById('earnedPoints').value = earned;
            currentPreset = name;
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateTestGrade();
        }

        function addQuestion() {
            const container = document.getElementById('questionsContainer');
            const newRow = document.createElement('div');
            newRow.className = 'question-row';
            newRow.innerHTML = `
                <input type="text" placeholder="Question Type" value="New Question Type">
                <input type="number" placeholder="Points" value="10" min="0" max="1000" step="1">
                <input type="number" placeholder="Earned" value="8" min="0" max="1000" step="0.5">
                <button type="button" class="btn-danger" onclick="removeQuestion(this)">×</button>
            `;
            container.appendChild(newRow);
        }

        function removeQuestion(button) {
            const row = button.parentElement;
            if (document.querySelectorAll('.question-row').length > 1) {
                row.remove();
            }
        }

        function applyCurve(curveType) {
            currentCurve = curveType;
            
            // Visual feedback
            document.querySelectorAll('.curve-card').forEach(card => card.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateTestGrade();
        }

        function calculateTestGrade() {
            // Get inputs
            const gradingMethod = document.getElementById('gradingMethod').value;
            const totalPoints = parseFloat(document.getElementById('totalPoints').value);
            const earnedPoints = parseFloat(document.getElementById('earnedPoints').value);
            const gradeScaleType = document.getElementById('gradeScale').value;
            const classAverage = parseFloat(document.getElementById('classAverage').value) || 0;
            const testWeight = parseFloat(document.getElementById('testWeight').value) || 0;
            const currentCourseGrade = 88.0; // Default value for demonstration

            // Calculate raw percentage
            const rawPercentage = (earnedPoints / totalPoints) * 100;

            // Apply curve if selected
            let curvedPercentage = rawPercentage;
            if (currentCurve === 'linear') {
                curvedPercentage = Math.min(100, rawPercentage + 2); // Simple linear curve
            } else if (currentCurve === 'squareRoot') {
                curvedPercentage = Math.min(100, Math.sqrt(rawPercentage) * 10); // Square root curve
            } else if (currentCurve === 'classAverage' && classAverage > 0) {
                const curveAmount = Math.max(0, 85 - classAverage); // Curve to 85% if class average is lower
                curvedPercentage = Math.min(100, rawPercentage + curveAmount);
            }

            const finalScore = curvedPercentage;

            // Get question data and calculate breakdown
            const questions = [];
            let totalQuestionPoints = 0;
            let totalQuestionEarned = 0;
            
            document.querySelectorAll('.question-row').forEach(row => {
                const inputs = row.querySelectorAll('input');
                const type = inputs[0].value || 'Question Type';
                const points = parseFloat(inputs[1].value) || 0;
                const earned = parseFloat(inputs[2].value) || 0;
                
                if (points > 0) {
                    questions.push({ type, points, earned });
                    totalQuestionPoints += points;
                    totalQuestionEarned += earned;
                }
            });

            // Use question breakdown if provided and points match
            let calculatedPercentage = finalScore;
            if (questions.length > 0 && Math.abs(totalQuestionPoints - totalPoints) < 5) {
                calculatedPercentage = (totalQuestionEarned / totalQuestionPoints) * 100;
            }

            // Calculate letter grade and GPA
            const letterGrade = getLetterGrade(calculatedPercentage, gradeScaleType);
            const gpaPoints = getGPAPoints(calculatedPercentage, gradeScaleType);

            // Calculate performance metrics
            const percentile = calculatePercentile(calculatedPercentage, classAverage);
            const strengthAreas = findStrengthAreas(questions);
            const improvementAreas = findImprovementAreas(questions);
            const timeEfficiency = calculateTimeEfficiency(calculatedPercentage);
            const errorRate = ((totalPoints - earnedPoints) / totalPoints * 100).toFixed(1);

            // Calculate course impact
            const courseImpact = calculateCourseImpact(currentCourseGrade, calculatedPercentage, testWeight);
            const improvementTips = generateImprovementTips(calculatedPercentage, improvementAreas);
            const studyRecommendations = generateStudyRecommendations(calculatedPercentage, improvementAreas);

            // Update curve options with calculated values
            updateCurveOptions(rawPercentage, classAverage);

            // Update UI
            document.getElementById('testScore').textContent = calculatedPercentage.toFixed(1) + '%';
            document.getElementById('letterGrade').textContent = letterGrade;
            document.getElementById('gpaPoints').textContent = gpaPoints.toFixed(1);
            document.getElementById('percentile').textContent = percentile;

            document.getElementById('pointsEarnedDisplay').textContent = earnedPoints;
            document.getElementById('totalPointsDisplay').textContent = totalPoints;
            document.getElementById('rawPercentage').textContent = rawPercentage.toFixed(1) + '%';
            document.getElementById('curvedScore').textContent = curvedPercentage.toFixed(1) + '%';
            document.getElementById('finalScore').textContent = calculatedPercentage.toFixed(1) + '%';

            document.getElementById('strengthAreas').textContent = strengthAreas;
            document.getElementById('improvementAreas').textContent = improvementAreas;
            document.getElementById('timeEfficiency').textContent = timeEfficiency;
            document.getElementById('errorRate').textContent = errorRate + '%';

            document.getElementById('testWeightDisplay').textContent = testWeight + '%';
            document.getElementById('currentCourseGrade').textContent = currentCourseGrade.toFixed(1) + '%';
            document.getElementById('newCourseGrade').textContent = courseImpact.newGrade.toFixed(1) + '%';
            document.getElementById('gradeChange').textContent = (courseImpact.change > 0 ? '+' : '') + courseImpact.change.toFixed(1) + '%';
            document.getElementById('letterGradeImpact').textContent = courseImpact.letterImpact;

            document.getElementById('studyTime').textContent = studyRecommendations.studyTime;
            document.getElementById('focusAreas').textContent = studyRecommendations.focusAreas;
            document.getElementById('studyMethods').textContent = studyRecommendations.studyMethods;
            document.getElementById('nextTestGoal').textContent = studyRecommendations.nextGoal;

            document.getElementById('overallAccuracy').textContent = calculatedPercentage.toFixed(1) + '%';

            // Update visual indicators
            document.getElementById('gradeFill').style.width = calculatedPercentage + '%';

            // Update question performance
            updateQuestionPerformance(questions);

            // Update improvement tips
            updateImprovementTips(improvementTips);
        }

        function getLetterGrade(percentage, scaleType) {
            const scale = gradeScales[scaleType];
            
            if (scaleType === 'passfail') {
                return percentage >= scale.Pass ? 'Pass' : 'Fail';
            }
            
            if (percentage >= scale.A) return 'A';
            if (percentage >= scale.B) return 'B';
            if (percentage >= scale.C) return 'C';
            if (percentage >= scale.D) return 'D';
            return 'F';
        }

        function getGPAPoints(percentage, scaleType) {
            if (scaleType === 'passfail') return percentage >= gradeScales.passfail.Pass ? 4.0 : 0.0;
            
            const scale = gradeScales[scaleType];
            
            if (percentage >= scale.A) return 4.0;
            if (percentage >= scale.B) return 3.0;
            if (percentage >= scale.C) return 2.0;
            if (percentage >= scale.D) return 1.0;
            return 0.0;
        }

        function calculatePercentile(score, classAverage) {
            if (classAverage === 0) {
                // Estimate based on score alone
                if (score >= 95) return 'Top 5%';
                if (score >= 90) return 'Top 15%';
                if (score >= 85) return 'Top 30%';
                if (score >= 80) return 'Top 50%';
                if (score >= 70) return 'Top 75%';
                return 'Bottom 25%';
            }
            
            // Calculate relative to class average
            const difference = score - classAverage;
            if (difference >= 15) return 'Top 10%';
            if (difference >= 10) return 'Top 25%';
            if (difference >= 5) return 'Top 40%';
            if (difference >= 0) return 'Top 60%';
            if (difference >= -5) return 'Top 75%';
            return 'Bottom 25%';
        }

        function findStrengthAreas(questions) {
            if (questions.length === 0) return 'All areas';
            
            const strengths = questions.filter(q => (q.earned / q.points) >= 0.9);
            return strengths.length > 0 ? strengths.map(s => s.type).join(', ') : 'None identified';
        }

        function findImprovementAreas(questions) {
            if (questions.length === 0) return 'None identified';
            
            const improvements = questions.filter(q => (q.earned / q.points) < 0.8);
            return improvements.length > 0 ? improvements.map(i => i.type).join(', ') : 'All areas strong';
        }

        function calculateTimeEfficiency(score) {
            if (score >= 90) return 'Excellent';
            if (score >= 80) return 'Good';
            if (score >= 70) return 'Average';
            return 'Needs Improvement';
        }

        function calculateCourseImpact(currentGrade, testScore, testWeight) {
            const currentWeighted = currentGrade * (100 - testWeight) / 100;
            const testWeighted = testScore * testWeight / 100;
            const newGrade = currentWeighted + testWeighted;
            const change = newGrade - currentGrade;
            
            const currentLetter = getLetterGrade(currentGrade, 'standard');
            const newLetter = getLetterGrade(newGrade, 'standard');
            const letterImpact = currentLetter === newLetter ? 'None' : `${currentLetter} → ${newLetter}`;
            
            return { newGrade, change, letterImpact };
        }

        function generateImprovementTips(score, improvementAreas) {
            const tips = [];
            
            if (score < 70) {
                tips.push('Focus on fundamental concepts and basic problem-solving skills');
                tips.push('Consider seeking tutoring or additional help from your instructor');
            }
            
            if (score < 80) {
                tips.push('Practice with similar test questions and review missed concepts');
                tips.push('Create a study schedule with dedicated time for each topic');
            }
            
            if (score >= 80 && score < 90) {
                tips.push('Work on time management and test-taking strategies');
                tips.push('Review advanced concepts and challenging problems');
            }
            
            if (improvementAreas !== 'All areas strong') {
                tips.push(`Pay special attention to: ${improvementAreas}`);
            }
            
            if (tips.length === 0) {
                tips.push('Maintain your current study habits - they are working well!');
                tips.push('Challenge yourself with more difficult material');
            }
            
            return tips.slice(0, 3);
        }

        function generateStudyRecommendations(score, improvementAreas) {
            let studyTime, focusAreas, studyMethods, nextGoal;
            
            if (score < 70) {
                studyTime = '10-15 hours';
                focusAreas = 'Fundamental concepts and basic skills';
                studyMethods = 'Tutoring, practice problems, concept review';
                nextGoal = '75% (C)';
            } else if (score < 80) {
                studyTime = '7-10 hours';
                focusAreas = improvementAreas;
                studyMethods = 'Practice tests, study groups, concept maps';
                nextGoal = '85% (B)';
            } else if (score < 90) {
                studyTime = '5-7 hours';
                focusAreas = improvementAreas;
                studyMethods = 'Advanced problems, timed practice, error analysis';
                nextGoal = '92% (A-)';
            } else {
                studyTime = '3-5 hours';
                focusAreas = 'Advanced topics and applications';
                studyMethods = 'Challenge problems, teaching others, research';
                nextGoal = '95% (A)';
            }
            
            return { studyTime, focusAreas, studyMethods, nextGoal };
        }

        function updateCurveOptions(rawPercentage, classAverage) {
            // Linear curve
            const linearCurve = Math.min(100, rawPercentage + 2);
            document.getElementById('curveLinear').textContent = linearCurve.toFixed(1) + '%';
            document.getElementById('curveLinear').nextElementSibling.textContent = `+${(linearCurve - rawPercentage).toFixed(1)}%`;
            
            // Square root curve
            const sqrtCurve = Math.min(100, Math.sqrt(rawPercentage) * 10);
            document.getElementById('curveSquareRoot').textContent = sqrtCurve.toFixed(1) + '%';
            document.getElementById('curveSquareRoot').nextElementSibling.textContent = `+${(sqrtCurve - rawPercentage).toFixed(1)}%`;
            
            // Class average curve
            let classCurve = rawPercentage;
            if (classAverage > 0) {
                const curveAmount = Math.max(0, 85 - classAverage);
                classCurve = Math.min(100, rawPercentage + curveAmount);
            }
            document.getElementById('curveClassAverage').textContent = classCurve.toFixed(1) + '%';
            document.getElementById('curveClassAverage').nextElementSibling.textContent = `+${(classCurve - rawPercentage).toFixed(1)}%`;
            
            // No curve
            document.getElementById('curveNone').textContent = rawPercentage.toFixed(1) + '%';
        }

        function updateQuestionPerformance(questions) {
            const performance = document.getElementById('questionPerformance');
            performance.innerHTML = '';

            questions.forEach(question => {
                const percentage = (question.earned / question.points * 100).toFixed(1);
                
                const item = document.createElement('div');
                item.className = 'question-item';
                item.innerHTML = `
                    <span>${question.type}</span>
                    <span>${question.points}</span>
                    <span>${question.earned}</span>
                    <span>${percentage}%</span>
                `;
                performance.appendChild(item);
            });

            if (questions.length === 0) {
                const item = document.createElement('div');
                item.className = 'question-item';
                item.innerHTML = `<span colspan="4" style="text-align: center;">No question breakdown provided</span>`;
                performance.appendChild(item);
            }
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
            calculateTestGrade();
        });
    </script>
</body>
</html>
