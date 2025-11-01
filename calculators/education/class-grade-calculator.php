<?php
/**
 * Class Grade Calculator
 * File: education/class-grade-calculator.php
 * Description: Calculate overall class grade from multiple graded assignments and categories
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Grade Calculator - Calculate Your Course Grade</title>
    <meta name="description" content="Advanced class grade calculator. Calculate your overall course grade from assignments, tests, homework, and projects with custom weights.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); text-align: center; }
        .header h1 { color: #2c3e50; font-size: 2.5rem; margin-bottom: 10px; }
        .header p { color: #7f8c8d; font-size: 1.2rem; opacity: 0.9; }
        
        .calculator-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .calculator-section h2, .results-section h2 { color: #667eea; margin-bottom: 25px; font-size: 1.8rem; }
        
        .category-section { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; border: 2px solid #e0e0e0; }
        .category-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .category-header h3 { color: #667eea; font-size: 1.1rem; }
        .remove-category { background: #ff6b6b; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 0.9rem; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 16px; transition: border-color 0.3s; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .form-group small { display: block; margin-top: 5px; color: #888; font-size: 0.85em; }
        
        .input-row { display: grid; grid-template-columns: 2fr 1fr; gap: 10px; }
        
        .assignment-item { background: white; padding: 12px; border-radius: 8px; margin-bottom: 10px; border: 1px solid #e0e0e0; display: flex; gap: 10px; align-items: center; }
        .assignment-item input { flex: 2; padding: 8px; border: 1px solid #e0e0e0; border-radius: 6px; }
        .assignment-item input:nth-child(2) { flex: 1; }
        .assignment-item input:nth-child(3) { flex: 1; }
        .remove-assignment { background: #ff6b6b; color: white; border: none; padding: 6px 10px; border-radius: 6px; cursor: pointer; font-size: 0.8rem; }
        
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 20px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3); }
        .btn-secondary { background: #6c757d; margin-top: 10px; }
        
        .result-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
        .result-card h3 { font-size: 1.2rem; opacity: 0.9; margin-bottom: 10px; font-weight: 400; }
        .result-card .amount { font-size: 3rem; font-weight: bold; }
        .result-card .letter { font-size: 1.5rem; opacity: 0.9; margin-top: 5px; }
        
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .metric-card { background: #f8f9fa; padding: 20px; border-radius: 12px; text-align: center; border: 2px solid #e0e0e0; transition: all 0.3s; }
        .metric-card:hover { transform: translateY(-2px); border-color: #667eea; }
        .metric-card h4 { color: #666; font-size: 0.9rem; margin-bottom: 10px; font-weight: 400; }
        .metric-card .value { color: #667eea; font-size: 1.6rem; font-weight: bold; }
        
        .breakdown { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .breakdown h3 { color: #667eea; margin-bottom: 15px; font-size: 1.3rem; }
        .breakdown-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #e0e0e0; }
        .breakdown-item:last-child { border-bottom: none; }
        .breakdown-item span { color: #666; }
        .breakdown-item strong { color: #333; font-weight: 600; }
        
        .grade-scale { width: 100%; margin: 15px 0; }
        .grade-bar { height: 30px; display: flex; border-radius: 8px; overflow: hidden; }
        .grade-segment { display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.9rem; }
        
        .info-box { background: #e8f2ff; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info-box strong { color: #667eea; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 1024px) {
            .calculator-wrapper { grid-template-columns: 1fr; padding: 25px; }
            .result-card .amount { font-size: 2.5rem; }
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 2rem; }
            .metric-grid { grid-template-columns: repeat(2, 1fr); }
            .input-row { grid-template-columns: 1fr; }
            .assignment-item { flex-direction: column; }
        }
        
        @media (max-width: 480px) {
            .header h1 { font-size: 1.5rem; }
            .header p { font-size: 1rem; }
            .result-card .amount { font-size: 2rem; }
            body { padding: 10px; }
            .metric-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 Class Grade Calculator</h1>
            <p>Calculate your overall course grade from multiple assignments and categories</p>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Add Categories & Assignments</h2>
                
                <div id="categories-container">
                    <div class="category-section" data-category="1">
                        <div class="category-header">
                            <h3>Category 1: Tests</h3>
                            <button class="remove-category" onclick="removeCategory(1)">Remove</button>
                        </div>
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="category-name" value="Tests" placeholder="Category name">
                        </div>
                        <div class="form-group">
                            <label>Weight (%)</label>
                            <input type="number" class="category-weight" value="40" min="0" max="100" step="1">
                            <small>Percentage of final grade</small>
                        </div>
                        <div class="form-group">
                            <label>Assignments</label>
                            <div class="assignments-list" id="assignments-1">
                                <div class="assignment-item">
                                    <input type="text" placeholder="Assignment name" class="assignment-name">
                                    <input type="number" placeholder="Score" class="assignment-score" min="0" step="0.1">
                                    <input type="number" placeholder="Max" class="assignment-max" min="0" step="0.1">
                                    <button class="remove-assignment" onclick="removeAssignment(this)">×</button>
                                </div>
                            </div>
                            <button class="btn btn-secondary" onclick="addAssignment(1)">+ Add Assignment</button>
                        </div>
                    </div>
                </div>
                
                <button class="btn btn-secondary" onclick="addCategory()">+ Add Category</button>
                <button class="btn" onclick="calculateGrade()">Calculate Grade</button>
            </div>

            <div class="results-section">
                <h2>Grade Results</h2>
                
                <div class="result-card">
                    <h3>Overall Grade</h3>
                    <div class="amount" id="overallGrade">95.0%</div>
                    <div class="letter" id="letterGrade">A</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Points Earned</h4>
                        <div class="value" id="pointsEarned">190</div>
                    </div>
                    <div class="metric-card">
                        <h4>Points Possible</h4>
                        <div class="value" id="pointsPossible">200</div>
                    </div>
                    <div class="metric-card">
                        <h4>GPA</h4>
                        <div class="value" id="gpaValue">4.0</div>
                    </div>
                </div>

                <div class="grade-scale">
                    <div class="grade-bar">
                        <div class="grade-segment" style="width: 20%; background: #00C853;">A (90-100)</div>
                        <div class="grade-segment" style="width: 20%; background: #64DD17;">B (80-89)</div>
                        <div class="grade-segment" style="width: 20%; background: #FBC02D;">C (70-79)</div>
                        <div class="grade-segment" style="width: 20%; background: #FF6F00;">D (60-69)</div>
                        <div class="grade-segment" style="width: 20%; background: #D32F2F;">F (0-59)</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Category Breakdown</h3>
                    <div id="categoryBreakdown">
                        <div class="breakdown-item">
                            <span>Tests (40%)</span>
                            <strong>95.0%</strong>
                        </div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Grade Scale</h3>
                    <div class="breakdown-item">
                        <span>A</span>
                        <strong>90 - 100%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>B</span>
                        <strong>80 - 89%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>C</span>
                        <strong>70 - 79%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>D</span>
                        <strong>60 - 69%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>F</span>
                        <strong>0 - 59%</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>How it works:</strong><br>
                    • Add categories with weights (must total 100%)<br>
                    • Add assignments with scores earned and max points<br>
                    • Each category is weighted according to its percentage<br>
                    • Overall grade = Sum of (Category Grade × Weight)
                </div>
            </div>
        </div>

        <div class="footer">
            <p>📚 Class Grade Calculator</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate your overall course grade accurately</p>
        </div>
    </div>

    <script>
        let categoryCount = 1;

        function addCategory() {
            categoryCount++;
            const container = document.getElementById('categories-container');
            const categoryHTML = `
                <div class="category-section" data-category="${categoryCount}">
                    <div class="category-header">
                        <h3>Category ${categoryCount}</h3>
                        <button class="remove-category" onclick="removeCategory(${categoryCount})">Remove</button>
                    </div>
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="category-name" value="Category ${categoryCount}" placeholder="Category name">
                    </div>
                    <div class="form-group">
                        <label>Weight (%)</label>
                        <input type="number" class="category-weight" value="0" min="0" max="100" step="1">
                        <small>Percentage of final grade</small>
                    </div>
                    <div class="form-group">
                        <label>Assignments</label>
                        <div class="assignments-list" id="assignments-${categoryCount}">
                            <div class="assignment-item">
                                <input type="text" placeholder="Assignment name" class="assignment-name">
                                <input type="number" placeholder="Score" class="assignment-score" min="0" step="0.1">
                                <input type="number" placeholder="Max" class="assignment-max" min="0" step="0.1">
                                <button class="remove-assignment" onclick="removeAssignment(this)">×</button>
                            </div>
                        </div>
                        <button class="btn btn-secondary" onclick="addAssignment(${categoryCount})">+ Add Assignment</button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', categoryHTML);
        }

        function removeCategory(id) {
            const category = document.querySelector(`[data-category="${id}"]`);
            if (document.querySelectorAll('.category-section').length > 1) {
                category.remove();
            } else {
                alert('You must have at least one category');
            }
        }

        function addAssignment(categoryId) {
            const container = document.getElementById(`assignments-${categoryId}`);
            const assignmentHTML = `
                <div class="assignment-item">
                    <input type="text" placeholder="Assignment name" class="assignment-name">
                    <input type="number" placeholder="Score" class="assignment-score" min="0" step="0.1">
                    <input type="number" placeholder="Max" class="assignment-max" min="0" step="0.1">
                    <button class="remove-assignment" onclick="removeAssignment(this)">×</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', assignmentHTML);
        }

        function removeAssignment(button) {
            const assignmentsList = button.closest('.assignments-list');
            if (assignmentsList.querySelectorAll('.assignment-item').length > 1) {
                button.closest('.assignment-item').remove();
            } else {
                alert('Each category must have at least one assignment');
            }
        }

        function calculateGrade() {
            const categories = document.querySelectorAll('.category-section');
            let totalWeightedScore = 0;
            let totalWeight = 0;
            let totalPointsEarned = 0;
            let totalPointsPossible = 0;
            const categoryBreakdownHTML = [];

            categories.forEach(category => {
                const name = category.querySelector('.category-name').value;
                const weight = parseFloat(category.querySelector('.category-weight').value) || 0;
                const assignments = category.querySelectorAll('.assignment-item');
                
                let categoryScore = 0;
                let categoryMax = 0;

                assignments.forEach(assignment => {
                    const score = parseFloat(assignment.querySelector('.assignment-score').value) || 0;
                    const max = parseFloat(assignment.querySelector('.assignment-max').value) || 0;
                    
                    categoryScore += score;
                    categoryMax += max;
                    totalPointsEarned += score;
                    totalPointsPossible += max;
                });

                const categoryPercentage = categoryMax > 0 ? (categoryScore / categoryMax) * 100 : 0;
                const weightedScore = (categoryPercentage * weight) / 100;
                
                totalWeightedScore += weightedScore;
                totalWeight += weight;

                categoryBreakdownHTML.push(`
                    <div class="breakdown-item">
                        <span>${name} (${weight}%)</span>
                        <strong>${categoryPercentage.toFixed(1)}%</strong>
                    </div>
                `);
            });

            // Calculate overall grade
            const overallGrade = totalWeight > 0 ? totalWeightedScore : 0;
            
            // Determine letter grade
            let letterGrade, gpa;
            if (overallGrade >= 90) {
                letterGrade = 'A';
                gpa = 4.0;
            } else if (overallGrade >= 80) {
                letterGrade = 'B';
                gpa = 3.0;
            } else if (overallGrade >= 70) {
                letterGrade = 'C';
                gpa = 2.0;
            } else if (overallGrade >= 60) {
                letterGrade = 'D';
                gpa = 1.0;
            } else {
                letterGrade = 'F';
                gpa = 0.0;
            }

            // Update UI
            document.getElementById('overallGrade').textContent = overallGrade.toFixed(1) + '%';
            document.getElementById('letterGrade').textContent = letterGrade;
            document.getElementById('pointsEarned').textContent = totalPointsEarned.toFixed(1);
            document.getElementById('pointsPossible').textContent = totalPointsPossible.toFixed(1);
            document.getElementById('gpaValue').textContent = gpa.toFixed(1);
            document.getElementById('categoryBreakdown').innerHTML = categoryBreakdownHTML.join('');

            // Warn if weights don't total 100%
            if (Math.abs(totalWeight - 100) > 0.1) {
                alert(`Warning: Category weights total ${totalWeight.toFixed(1)}%. They should total 100% for accurate results.`);
            }
        }

        // Initialize with calculation
        window.addEventListener('load', function() {
            // Add default assignment values
            document.querySelector('.assignment-score').value = '95';
            document.querySelector('.assignment-max').value = '100';
            calculateGrade();
        });
    </script>
</body>
</html>