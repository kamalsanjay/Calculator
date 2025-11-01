<?php
/**
 * Grade Calculator
 * File: education/grade-calculator.php
 * Description: Advanced grade calculator with multiple grading systems, weighted categories, and performance analysis
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Calculator - Advanced Grade Calculation & Performance Analysis</title>
    <meta name="description" content="Advanced grade calculator with multiple grading systems, weighted categories, and comprehensive performance analysis.">
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
        
        .assignment-list { 
            max-height: 300px; 
            overflow-y: auto; 
            margin: 15px 0; 
            border: 1px solid #e0e0e0; 
            border-radius: 8px; 
            padding: 10px; 
        }
        
        .assignment-item { 
            display: grid; 
            grid-template-columns: 2fr 1fr 1fr 1fr; 
            gap: 10px; 
            padding: 8px; 
            border-bottom: 1px solid #e0e0e0; 
            align-items: center; 
        }
        .assignment-item:last-child { 
            border-bottom: none; 
        }
        .assignment-item.header { 
            font-weight: bold; 
            background: #f8f9fa; 
            border-radius: 4px; 
        }
        
        .grade-preset { 
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
            .assignment-item { 
                grid-template-columns: 1fr; 
                text-align: center; 
            }
            .input-group { 
                grid-template-columns: 1fr; 
            }
            .grade-preset { 
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
            <h1>📚 Grade Calculator</h1>
            <p>Calculate your grades with multiple grading systems, weighted categories, and performance analysis</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Grade Configuration</h2>
                <form id="gradeForm">
                    
                    <div class="form-group">
                        <label for="gradingSystem">Grading System</label>
                        <select id="gradingSystem" style="padding: 12px;">
                            <option value="percentage" selected>Percentage (0-100%)</option>
                            <option value="points">Points Based</option>
                            <option value="weighted">Weighted Categories</option>
                            <option value="gpa">4.0 Scale (GPA)</option>
                        </select>
                        <small>Select your preferred grading system</small>
                    </div>
                    
                    <div class="form-group" id="pointsTotalGroup">
                        <label for="totalPoints">Total Possible Points</label>
                        <input type="number" id="totalPoints" value="100" min="1" max="10000" step="1">
                        <small>Total points possible in the course</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Quick Grade Presets</label>
                        <div class="grade-preset">
                            <div class="preset-btn" onclick="setPreset('High School', 'percentage', '100', '85')">High School</div>
                            <div class="preset-btn" onclick="setPreset('College', 'percentage', '100', '87')">College</div>
                            <div class="preset-btn" onclick="setPreset('Graduate', 'gpa', '100', '3.7')">Graduate</div>
                            <div class="preset-btn" onclick="setPreset('Weighted', 'weighted', '100', '0')">Weighted</div>
                            <div class="preset-btn" onclick="setPreset('Points', 'points', '500', '425')">Points Based</div>
                            <div class="preset-btn" onclick="setPreset('Strict', 'percentage', '100', '90')">Strict Scale</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="currentGrade">Current Grade/Points</label>
                        <input type="number" id="currentGrade" value="85" min="0" max="1000" step="0.1" required>
                        <small>Your current grade or points earned</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="desiredGrade">Desired Final Grade</label>
                        <input type="number" id="desiredGrade" value="90" min="0" max="1000" step="0.1" required>
                        <small>The grade you want to achieve</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="finalWeight">Final Exam Weight (%)</label>
                        <input type="number" id="finalWeight" value="20" min="0" max="100" step="1">
                        <small>How much the final exam counts toward your grade</small>
                    </div>
                    
                    <div class="form-group">
                        <h4 style="color: #667eea; margin-bottom: 15px;">Assignment Grades</h4>
                        <div id="assignmentsContainer">
                            <div class="assignment-row">
                                <input type="text" placeholder="Assignment Name" value="Midterm Exam">
                                <input type="number" placeholder="Score" value="88" min="0" max="1000" step="0.1">
                                <input type="number" placeholder="Weight %" value="30" min="0" max="100" step="1">
                                <button type="button" class="btn-danger" onclick="removeAssignment(this)">×</button>
                            </div>
                            <div class="assignment-row">
                                <input type="text" placeholder="Assignment Name" value="Homework">
                                <input type="number" placeholder="Score" value="92" min="0" max="1000" step="0.1">
                                <input type="number" placeholder="Weight %" value="20" min="0" max="100" step="1">
                                <button type="button" class="btn-danger" onclick="removeAssignment(this)">×</button>
                            </div>
                        </div>
                        <button type="button" class="btn-success" onclick="addAssignment()" style="margin-top: 10px;">+ Add Assignment</button>
                    </div>
                    
                    <div class="form-group">
                        <label for="gradeScale">Grade Scale</label>
                        <select id="gradeScale" style="padding: 12px;">
                            <option value="standard" selected>Standard (A=90+, B=80+, etc.)</option>
                            <option value="college">College (A=93+, B=85+, etc.)</option>
                            <option value="strict">Strict (A=95+, B=87+, etc.)</option>
                            <option value="custom">Custom Scale</option>
                        </select>
                        <small>Grading scale for letter grades</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Grades</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Grade Analysis</h2>
                
                <div class="result-card">
                    <h3>Current Grade</h3>
                    <div class="amount" id="currentGradeDisplay">85.0%</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Letter Grade</h4>
                        <div class="value" id="letterGrade">B</div>
                    </div>
                    <div class="metric-card">
                        <h4>GPA Equivalent</h4>
                        <div class="value" id="gpaEquivalent">3.0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Class Rank</h4>
                        <div class="value" id="classRank">75th %</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Grade Distribution</h3>
                    <div class="breakdown-item">
                        <span>Current Percentage</span>
                        <strong id="currentPercentage">85.0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Points Earned</span>
                        <strong id="pointsEarned">85/100</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Weighted Average</span>
                        <strong id="weightedAverage">86.4%</strong>
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
                    <h3>Assignment Summary</h3>
                    <div class="assignment-list">
                        <div class="assignment-item header">
                            <span>Assignment</span>
                            <span>Score</span>
                            <span>Weight</span>
                            <span>Contribution</span>
                        </div>
                        <div id="assignmentSummary">
                            <!-- Assignment items will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Weighted</span>
                        <strong id="totalWeighted">86.4%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Final Exam Requirements</h3>
                    <div class="breakdown-item">
                        <span>Current Grade Before Final</span>
                        <strong id="gradeBeforeFinal">85.0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Final Exam Weight</span>
                        <strong id="finalExamWeight">20%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Score Needed for Desired Grade</span>
                        <strong id="scoreNeeded">95.0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Minimum to Pass (70%)</span>
                        <strong id="minToPass">45.0%</strong>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Performance Analysis</h3>
                    <div class="performance-grid">
                        <div class="performance-card">
                            <h4>Grade Trend</h4>
                            <div class="value" id="gradeTrend">+2.1%</div>
                            <div class="change">Improving</div>
                        </div>
                        <div class="performance-card">
                            <h4>Study Hours Needed</h4>
                            <div class="value" id="studyHours">12 hours</div>
                            <div class="change">For target grade</div>
                        </div>
                        <div class="performance-card">
                            <h4>Risk Level</h4>
                            <div class="value" id="riskLevel">Low</div>
                            <div class="change">Chance of failure</div>
                        </div>
                        <div class="performance-card">
                            <h4>Recommendation</h4>
                            <div class="value" id="recommendation">Good</div>
                            <div class="change">Current standing</div>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Grade Scenarios</h3>
                    <div class="breakdown-item">
                        <span>If Final = 100%</span>
                        <strong id="scenario100">89.2% B+</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>If Final = 80%</span>
                        <strong id="scenario80">85.6% B</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>If Final = 60%</span>
                        <strong id="scenario60">82.0% B-</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>If Final = 0%</span>
                        <strong id="scenario0">72.0% C-</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Note:</strong> Grade calculations are estimates based on provided data. Actual grading policies may vary by institution and instructor. Always verify with official course materials and communicate with your instructor about grading policies.
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📚 Grade Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Advanced grade calculation and performance analysis</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('gradeForm');
        let currentPreset = '';

        // Grade scale definitions
        const gradeScales = {
            standard: { A: 90, B: 80, C: 70, D: 60, F: 0 },
            college: { A: 93, B: 85, C: 77, D: 70, F: 0 },
            strict: { A: 95, B: 87, C: 80, D: 73, F: 0 }
        };

        // GPA conversion
        const gpaScale = {
            A: 4.0, A_minus: 3.7,
            B_plus: 3.3, B: 3.0, B_minus: 2.7,
            C_plus: 2.3, C: 2.0, C_minus: 1.7,
            D_plus: 1.3, D: 1.0, F: 0.0
        };

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateGrades();
        });

        function setPreset(name, system, points, grade) {
            document.getElementById('gradingSystem').value = system;
            document.getElementById('totalPoints').value = points;
            document.getElementById('currentGrade').value = grade;
            currentPreset = name;
            
            // Visual feedback
            document.querySelectorAll('.preset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            calculateGrades();
        }

        function addAssignment() {
            const container = document.getElementById('assignmentsContainer');
            const newRow = document.createElement('div');
            newRow.className = 'assignment-row';
            newRow.innerHTML = `
                <input type="text" placeholder="Assignment Name" value="New Assignment">
                <input type="number" placeholder="Score" value="0" min="0" max="1000" step="0.1">
                <input type="number" placeholder="Weight %" value="10" min="0" max="100" step="1">
                <button type="button" class="btn-danger" onclick="removeAssignment(this)">×</button>
            `;
            container.appendChild(newRow);
        }

        function removeAssignment(button) {
            const row = button.parentElement;
            if (document.querySelectorAll('.assignment-row').length > 1) {
                row.remove();
            }
        }

        function calculateGrades() {
            // Get inputs
            const gradingSystem = document.getElementById('gradingSystem').value;
            const totalPoints = parseFloat(document.getElementById('totalPoints').value) || 100;
            const currentGrade = parseFloat(document.getElementById('currentGrade').value);
            const desiredGrade = parseFloat(document.getElementById('desiredGrade').value);
            const finalWeight = parseFloat(document.getElementById('finalWeight').value) || 0;
            const gradeScaleType = document.getElementById('gradeScale').value;

            // Get assignment data
            const assignments = [];
            let totalWeight = 0;
            document.querySelectorAll('.assignment-row').forEach(row => {
                const inputs = row.querySelectorAll('input');
                const name = inputs[0].value || 'Assignment';
                const score = parseFloat(inputs[1].value) || 0;
                const weight = parseFloat(inputs[2].value) || 0;
                
                if (weight > 0) {
                    assignments.push({ name, score, weight });
                    totalWeight += weight;
                }
            });

            // Calculate current grade based on system
            let currentPercentage, pointsEarned, weightedAverage;

            if (gradingSystem === 'percentage') {
                currentPercentage = currentGrade;
                pointsEarned = (currentGrade / 100) * totalPoints;
            } else if (gradingSystem === 'points') {
                currentPercentage = (currentGrade / totalPoints) * 100;
                pointsEarned = currentGrade;
            } else if (gradingSystem === 'gpa') {
                currentPercentage = gpaToPercentage(currentGrade);
                pointsEarned = (currentPercentage / 100) * totalPoints;
            } else { // weighted
                // Calculate weighted average from assignments
                let weightedSum = 0;
                assignments.forEach(assignment => {
                    weightedSum += (assignment.score * assignment.weight) / 100;
                });
                weightedAverage = weightedSum;
                currentPercentage = weightedAverage;
                pointsEarned = (weightedAverage / 100) * totalPoints;
            }

            // Calculate letter grade and GPA
            const letterGrade = getLetterGrade(currentPercentage, gradeScaleType);
            const gpaEquivalent = getGPAEquivalent(currentPercentage, gradeScaleType);

            // Calculate final exam requirements
            const gradeBeforeFinal = (currentPercentage * (100 - finalWeight)) / 100;
            const scoreNeeded = finalWeight > 0 ? 
                ((desiredGrade - gradeBeforeFinal) / finalWeight) * 100 : 0;
            const minToPass = finalWeight > 0 ? 
                ((70 - gradeBeforeFinal) / finalWeight) * 100 : 0;

            // Calculate scenarios
            const scenario100 = finalWeight > 0 ? 
                (gradeBeforeFinal + (100 * finalWeight / 100)) : currentPercentage;
            const scenario80 = finalWeight > 0 ? 
                (gradeBeforeFinal + (80 * finalWeight / 100)) : currentPercentage;
            const scenario60 = finalWeight > 0 ? 
                (gradeBeforeFinal + (60 * finalWeight / 100)) : currentPercentage;
            const scenario0 = finalWeight > 0 ? 
                (gradeBeforeFinal + (0 * finalWeight / 100)) : currentPercentage;

            // Calculate performance metrics
            const gradeTrend = calculateGradeTrend(assignments);
            const studyHours = calculateStudyHours(scoreNeeded, currentPercentage);
            const riskLevel = calculateRiskLevel(currentPercentage, scoreNeeded);
            const recommendation = getRecommendation(currentPercentage, desiredGrade);
            const classRank = calculateClassRank(currentPercentage);

            // Update UI
            document.getElementById('currentGradeDisplay').textContent = currentPercentage.toFixed(1) + '%';
            document.getElementById('letterGrade').textContent = letterGrade;
            document.getElementById('gpaEquivalent').textContent = gpaEquivalent.toFixed(1);
            document.getElementById('classRank').textContent = classRank;

            document.getElementById('currentPercentage').textContent = currentPercentage.toFixed(1) + '%';
            document.getElementById('pointsEarned').textContent = pointsEarned.toFixed(0) + '/' + totalPoints;
            document.getElementById('weightedAverage').textContent = weightedAverage ? weightedAverage.toFixed(1) + '%' : 'N/A';

            document.getElementById('gradeBeforeFinal').textContent = gradeBeforeFinal.toFixed(1) + '%';
            document.getElementById('finalExamWeight').textContent = finalWeight + '%';
            document.getElementById('scoreNeeded').textContent = scoreNeeded > 0 ? scoreNeeded.toFixed(1) + '%' : 'N/A';
            document.getElementById('minToPass').textContent = minToPass > 0 ? minToPass.toFixed(1) + '%' : 'N/A';

            document.getElementById('gradeTrend').textContent = (gradeTrend > 0 ? '+' : '') + gradeTrend.toFixed(1) + '%';
            document.getElementById('studyHours').textContent = studyHours + ' hours';
            document.getElementById('riskLevel').textContent = riskLevel;
            document.getElementById('recommendation').textContent = recommendation;

            document.getElementById('scenario100').textContent = scenario100.toFixed(1) + '% ' + getLetterGrade(scenario100, gradeScaleType);
            document.getElementById('scenario80').textContent = scenario80.toFixed(1) + '% ' + getLetterGrade(scenario80, gradeScaleType);
            document.getElementById('scenario60').textContent = scenario60.toFixed(1) + '% ' + getLetterGrade(scenario60, gradeScaleType);
            document.getElementById('scenario0').textContent = scenario0.toFixed(1) + '% ' + getLetterGrade(scenario0, gradeScaleType);

            // Update visual indicators
            document.getElementById('gradeFill').style.width = currentPercentage + '%';

            // Update assignment summary
            updateAssignmentSummary(assignments);
        }

        function gpaToPercentage(gpa) {
            // Simple conversion - can be customized
            if (gpa >= 4.0) return 97;
            if (gpa >= 3.7) return 93;
            if (gpa >= 3.3) return 90;
            if (gpa >= 3.0) return 87;
            if (gpa >= 2.7) return 83;
            if (gpa >= 2.3) return 80;
            if (gpa >= 2.0) return 77;
            if (gpa >= 1.7) return 73;
            if (gpa >= 1.3) return 70;
            if (gpa >= 1.0) return 67;
            return 65;
        }

        function getLetterGrade(percentage, scaleType) {
            const scale = gradeScales[scaleType];
            if (percentage >= scale.A) return 'A';
            if (percentage >= scale.B) return 'B';
            if (percentage >= scale.C) return 'C';
            if (percentage >= scale.D) return 'D';
            return 'F';
        }

        function getGPAEquivalent(percentage, scaleType) {
            const scale = gradeScales[scaleType];
            if (percentage >= scale.A) return 4.0;
            if (percentage >= scale.B + 3) return 3.7; // A-
            if (percentage >= scale.B + 5) return 3.3; // B+
            if (percentage >= scale.B) return 3.0;
            if (percentage >= scale.C + 3) return 2.7; // B-
            if (percentage >= scale.C + 5) return 2.3; // C+
            if (percentage >= scale.C) return 2.0;
            if (percentage >= scale.D + 3) return 1.7; // C-
            if (percentage >= scale.D + 5) return 1.3; // D+
            if (percentage >= scale.D) return 1.0;
            return 0.0;
        }

        function calculateGradeTrend(assignments) {
            if (assignments.length < 2) return 0;
            
            // Simple trend calculation based on last 3 assignments
            const recent = assignments.slice(-3);
            let sum = 0;
            recent.forEach((assignment, index) => {
                sum += assignment.score * (index + 1); // Weight recent assignments more
            });
            const weightedAverage = sum / 6; // Sum of weights 1+2+3=6
            
            const first = recent[0].score;
            return weightedAverage - first;
        }

        function calculateStudyHours(scoreNeeded, currentGrade) {
            const difficulty = Math.max(0, scoreNeeded - currentGrade);
            return Math.ceil(difficulty / 5); // 5% improvement per hour (rough estimate)
        }

        function calculateRiskLevel(currentGrade, scoreNeeded) {
            if (currentGrade >= 90) return 'Very Low';
            if (currentGrade >= 80 && scoreNeeded <= 80) return 'Low';
            if (currentGrade >= 70 && scoreNeeded <= 85) return 'Medium';
            if (currentGrade >= 60 && scoreNeeded <= 90) return 'High';
            return 'Very High';
        }

        function getRecommendation(currentGrade, desiredGrade) {
            const difference = desiredGrade - currentGrade;
            if (difference <= 2) return 'Excellent';
            if (difference <= 5) return 'Good';
            if (difference <= 10) return 'Needs Work';
            return 'Significant Improvement Needed';
        }

        function calculateClassRank(currentGrade) {
            // Simplified class rank calculation
            if (currentGrade >= 95) return 'Top 5%';
            if (currentGrade >= 90) return 'Top 15%';
            if (currentGrade >= 85) return 'Top 30%';
            if (currentGrade >= 80) return 'Top 50%';
            if (currentGrade >= 70) return 'Top 75%';
            return 'Bottom 25%';
        }

        function updateAssignmentSummary(assignments) {
            const summary = document.getElementById('assignmentSummary');
            summary.innerHTML = '';

            assignments.forEach(assignment => {
                const contribution = (assignment.score * assignment.weight) / 100;
                const item = document.createElement('div');
                item.className = 'assignment-item';
                item.innerHTML = `
                    <span>${assignment.name}</span>
                    <span>${assignment.score.toFixed(1)}%</span>
                    <span>${assignment.weight}%</span>
                    <span>${contribution.toFixed(1)}%</span>
                `;
                summary.appendChild(item);
            });
        }

        // Initialize
        window.addEventListener('load', function() {
            calculateGrades();
        });
    </script>
</body>
</html>
