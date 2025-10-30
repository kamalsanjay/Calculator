<?php
/**
 * Matrix Calculator
 * File: matrix-calculator.php
 * Description: Perform matrix operations including addition, multiplication, determinant, inverse, and more
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrix Calculator - Advanced Matrix Operations</title>
    <meta name="description" content="Perform matrix operations including addition, multiplication, determinant, inverse, transpose, and more with step-by-step solutions.">
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh; 
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header { 
            background: rgba(255,255,255,0.1); 
            color: white; 
            padding: 25px 20px; 
            text-align: center; 
            border-radius: 15px; 
            margin-bottom: 20px; 
            backdrop-filter: blur(10px); 
        }
        
        header h1 { 
            font-size: 2rem; 
            margin-bottom: 10px; 
            font-weight: 700; 
        }
        
        header p { 
            font-size: 1rem; 
            opacity: 0.9; 
        }
        
        .calculator-body { 
            background: white; 
            padding: 25px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
            margin-bottom: 20px; 
        }
        
        .calc-tabs { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); 
            gap: 10px; 
            margin-bottom: 20px; 
        }
        
        .tab-btn { 
            padding: 12px 10px; 
            background: #f0f0f0; 
            border: none; 
            border-radius: 8px; 
            color: #333; 
            cursor: pointer; 
            transition: all 0.3s; 
            font-weight: 600; 
            text-align: center; 
            font-size: 0.9rem; 
        }
        
        .tab-btn.active { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            transform: translateY(-2px); 
            box-shadow: 0 4px 8px rgba(0,0,0,0.15); 
        }
        
        .tab-content { 
            display: none; 
        }
        
        .tab-content.active { 
            display: block; 
            animation: fadeIn 0.3s; 
        }
        
        @keyframes fadeIn { 
            from { opacity: 0; transform: translateY(10px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        
        .input-section { 
            margin-bottom: 20px; 
        }
        
        .input-section label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            color: #333; 
            font-size: 1rem; 
        }
        
        .input-section input, .input-section select { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #e0e0e0; 
            border-radius: 8px; 
            font-size: 1rem; 
            outline: none; 
            transition: all 0.3s; 
            font-family: 'Courier New', monospace; 
        }
        
        .input-section input:focus, .input-section select:focus { 
            border-color: #667eea; 
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); 
        }
        
        .input-hint { 
            font-size: 0.85rem; 
            color: #666; 
            margin-top: 6px; 
            font-style: italic; 
        }
        
        .matrix-controls {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .matrix-control-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .matrix-size-input {
            width: 80px;
            padding: 8px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            text-align: center;
        }
        
        .matrix-container {
            display: flex;
            gap: 30px;
            margin: 20px 0;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .matrix-wrapper {
            text-align: center;
        }
        
        .matrix-label {
            font-weight: 600;
            margin-bottom: 10px;
            color: #667eea;
        }
        
        .matrix {
            display: inline-block;
            border: 2px solid #667eea;
            border-radius: 8px;
            padding: 15px;
            background: #f8f9fa;
        }
        
        .matrix-row {
            display: flex;
            gap: 8px;
            margin-bottom: 8px;
        }
        
        .matrix-row:last-child {
            margin-bottom: 0;
        }
        
        .matrix-cell {
            width: 60px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
            font-family: 'Courier New', monospace;
            background: white;
        }
        
        .matrix-cell:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
        }
        
        .operator-select { 
            background: #e3f2fd;
            border: 2px solid #2196F3;
            border-radius: 8px;
            padding: 12px;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            outline: none;
            min-width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 40px;
        }
        
        .btn { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            border: none; 
            padding: 14px 24px; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: 600; 
            width: 100%; 
            font-size: 1.1rem; 
            transition: all 0.3s; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.15); 
            margin-top: 10px;
        }
        
        .btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 4px 12px rgba(0,0,0,0.2); 
        }
        
        .btn:active { 
            transform: translateY(0); 
        }
        
        .examples { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); 
            gap: 10px; 
            margin: 20px 0; 
        }
        
        .example-btn { 
            padding: 10px; 
            background: #f0f0f0; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            cursor: pointer; 
            text-align: center; 
            font-size: 0.9rem; 
            transition: all 0.3s; 
            font-family: 'Courier New', monospace;
        }
        
        .example-btn:hover { 
            background: #667eea; 
            color: white; 
            transform: translateY(-2px); 
        }
        
        .result-section { 
            background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); 
            padding: 25px; 
            border-radius: 12px; 
            border-left: 5px solid #667eea; 
            margin-top: 25px; 
            display: none; 
        }
        
        .result-section.show { 
            display: block; 
            animation: slideIn 0.3s; 
        }
        
        @keyframes slideIn { 
            from { opacity: 0; transform: translateY(20px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        
        .result-section h3 { 
            color: #667eea; 
            margin-bottom: 20px; 
            font-size: 1.5rem; 
        }
        
        .result-box { 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
            margin-bottom: 15px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
            border-left: 4px solid #4CAF50; 
        }
        
        .result-label { 
            font-size: 0.9rem; 
            color: #666; 
            margin-bottom: 8px; 
            font-weight: 600; 
            text-transform: uppercase; 
        }
        
        .result-value { 
            font-size: 1.1rem; 
            color: #4CAF50; 
            font-weight: bold; 
            font-family: 'Courier New', monospace; 
            word-break: break-word; 
            line-height: 1.5; 
            text-align: center;
        }
        
        .result-matrix {
            display: inline-block;
            margin: 10px 0;
        }
        
        .formula-box { 
            background: #f9f9f9; 
            padding: 16px; 
            border-radius: 8px; 
            border-left: 4px solid #667eea; 
            margin: 16px 0; 
            font-size: 0.9rem; 
            line-height: 1.7; 
        }
        
        .formula-box strong { 
            color: #667eea; 
            display: block; 
            margin-bottom: 8px; 
        }
        
        .step-box { 
            background: #fff3cd; 
            padding: 16px; 
            border-radius: 8px; 
            border-left: 4px solid #ffc107; 
            margin: 16px 0; 
        }
        
        .step-box strong { 
            color: #f57c00; 
            display: block; 
            margin-bottom: 10px; 
        }
        
        .step { 
            padding: 8px 0; 
            border-bottom: 1px solid #ffe082; 
            font-family: 'Courier New', monospace; 
            font-size: 0.95rem; 
        }
        
        .step:last-child { 
            border-bottom: none; 
        }
        
        .info-box { 
            background: white; 
            padding: 25px; 
            border-radius: 12px; 
            line-height: 1.8; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.15); 
            margin-top: 20px; 
        }
        
        .info-box h3 { 
            color: #667eea; 
            margin-bottom: 16px; 
            font-size: 1.3rem; 
        }
        
        .rule-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
            gap: 15px; 
            margin: 20px 0; 
        }
        
        .rule-card { 
            background: #f5f5f5; 
            padding: 15px; 
            border-radius: 8px; 
            border-left: 3px solid #667eea; 
        }
        
        .rule-card strong { 
            color: #667eea; 
            display: block; 
            margin-bottom: 6px; 
            font-size: 0.95rem; 
        }
        
        .rule-card code { 
            font-family: 'Courier New', monospace; 
            font-size: 0.85rem; 
            color: #333; 
            display: block; 
        }
        
        @media (max-width: 768px) {
            .examples { 
                grid-template-columns: 1fr; 
            }
            .matrix-container {
                flex-direction: column;
                align-items: center;
            }
            .operator-select {
                margin: 20px 0;
                transform: rotate(90deg);
            }
            .matrix-controls {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🧮 Matrix Calculator</h1>
            <p>Advanced Matrix Operations with Step-by-Step Solutions</p>
        </header>

        <div class="calculator-body">
            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Addition</button>
                <button class="tab-btn" onclick="switchTab(1)">Multiplication</button>
                <button class="tab-btn" onclick="switchTab(2)">Determinant</button>
                <button class="tab-btn" onclick="switchTab(3)">Inverse</button>
                <button class="tab-btn" onclick="switchTab(4)">Transpose</button>
                <button class="tab-btn" onclick="switchTab(5)">Scalar Mult</button>
            </div>

            <!-- Tab 1: Matrix Addition -->
            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 15px;">➕ Matrix Addition</h3>
                
                <div class="matrix-controls">
                    <div class="matrix-control-group">
                        <label>Rows:</label>
                        <input type="number" id="add_rows" class="matrix-size-input" value="2" min="1" max="6" onchange="createAdditionMatrices()">
                    </div>
                    <div class="matrix-control-group">
                        <label>Columns:</label>
                        <input type="number" id="add_cols" class="matrix-size-input" value="2" min="1" max="6" onchange="createAdditionMatrices()">
                    </div>
                </div>
                
                <div class="matrix-container">
                    <div class="matrix-wrapper">
                        <div class="matrix-label">Matrix A</div>
                        <div class="matrix" id="matrixA"></div>
                    </div>
                    
                    <select class="operator-select" id="add_operator">
                        <option value="+">+</option>
                    </select>
                    
                    <div class="matrix-wrapper">
                        <div class="matrix-label">Matrix B</div>
                        <div class="matrix" id="matrixB"></div>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateAddition()">Calculate Addition</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="loadAdditionExample(1)">2×2 Identity + Ones</button>
                    <button class="example-btn" onclick="loadAdditionExample(2)">3×3 Random</button>
                    <button class="example-btn" onclick="loadAdditionExample(3)">2×3 Matrices</button>
                </div>
            </div>

            <!-- Tab 2: Matrix Multiplication -->
            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">✖️ Matrix Multiplication</h3>
                
                <div class="matrix-controls">
                    <div class="matrix-control-group">
                        <label>Matrix A:</label>
                        <input type="number" id="mulA_rows" class="matrix-size-input" value="2" min="1" max="6" onchange="createMultiplicationMatrices()">
                        <span>×</span>
                        <input type="number" id="mulA_cols" class="matrix-size-input" value="2" min="1" max="6" onchange="createMultiplicationMatrices()">
                    </div>
                    <div class="matrix-control-group">
                        <label>Matrix B:</label>
                        <input type="number" id="mulB_rows" class="matrix-size-input" value="2" min="1" max="6" onchange="createMultiplicationMatrices()">
                        <span>×</span>
                        <input type="number" id="mulB_cols" class="matrix-size-input" value="2" min="1" max="6" onchange="createMultiplicationMatrices()">
                    </div>
                </div>
                
                <div class="matrix-container">
                    <div class="matrix-wrapper">
                        <div class="matrix-label">Matrix A</div>
                        <div class="matrix" id="matrixMulA"></div>
                    </div>
                    
                    <select class="operator-select" id="mul_operator">
                        <option value="×">×</option>
                    </select>
                    
                    <div class="matrix-wrapper">
                        <div class="matrix-label">Matrix B</div>
                        <div class="matrix" id="matrixMulB"></div>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateMultiplication()">Calculate Multiplication</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="loadMultiplicationExample(1)">2×2 × 2×2</button>
                    <button class="example-btn" onclick="loadMultiplicationExample(2)">2×3 × 3×2</button>
                    <button class="example-btn" onclick="loadMultiplicationExample(3)">3×3 Identity</button>
                </div>
            </div>

            <!-- Tab 3: Determinant -->
            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">📐 Matrix Determinant</h3>
                
                <div class="matrix-controls">
                    <div class="matrix-control-group">
                        <label>Size:</label>
                        <input type="number" id="det_size" class="matrix-size-input" value="2" min="1" max="4" onchange="createDeterminantMatrix()">
                        <span>×</span>
                        <input type="number" id="det_size2" class="matrix-size-input" value="2" min="1" max="4" onchange="createDeterminantMatrix()" disabled>
                    </div>
                </div>
                
                <div class="matrix-container">
                    <div class="matrix-wrapper">
                        <div class="matrix-label">Matrix</div>
                        <div class="matrix" id="matrixDet"></div>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateDeterminant()">Calculate Determinant</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="loadDeterminantExample(1)">2×2 Matrix</button>
                    <button class="example-btn" onclick="loadDeterminantExample(2)">3×3 Matrix</button>
                    <button class="example-btn" onclick="loadDeterminantExample(3)">Identity Matrix</button>
                </div>
            </div>

            <!-- Tab 4: Matrix Inverse -->
            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">🔄 Matrix Inverse</h3>
                
                <div class="matrix-controls">
                    <div class="matrix-control-group">
                        <label>Size:</label>
                        <input type="number" id="inv_size" class="matrix-size-input" value="2" min="1" max="3" onchange="createInverseMatrix()">
                        <span>×</span>
                        <input type="number" id="inv_size2" class="matrix-size-input" value="2" min="1" max="3" onchange="createInverseMatrix()" disabled>
                    </div>
                </div>
                
                <div class="matrix-container">
                    <div class="matrix-wrapper">
                        <div class="matrix-label">Matrix</div>
                        <div class="matrix" id="matrixInv"></div>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateInverse()">Calculate Inverse</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="loadInverseExample(1)">2×2 Invertible</button>
                    <button class="example-btn" onclick="loadInverseExample(2)">3×3 Matrix</button>
                    <button class="example-btn" onclick="loadInverseExample(3)">Singular Matrix</button>
                </div>
            </div>

            <!-- Tab 5: Matrix Transpose -->
            <div id="tab4" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">📋 Matrix Transpose</h3>
                
                <div class="matrix-controls">
                    <div class="matrix-control-group">
                        <label>Rows:</label>
                        <input type="number" id="trans_rows" class="matrix-size-input" value="2" min="1" max="6" onchange="createTransposeMatrix()">
                    </div>
                    <div class="matrix-control-group">
                        <label>Columns:</label>
                        <input type="number" id="trans_cols" class="matrix-size-input" value="3" min="1" max="6" onchange="createTransposeMatrix()">
                    </div>
                </div>
                
                <div class="matrix-container">
                    <div class="matrix-wrapper">
                        <div class="matrix-label">Original Matrix</div>
                        <div class="matrix" id="matrixTrans"></div>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateTranspose()">Calculate Transpose</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="loadTransposeExample(1)">2×3 Matrix</button>
                    <button class="example-btn" onclick="loadTransposeExample(2)">3×2 Matrix</button>
                    <button class="example-btn" onclick="loadTransposeExample(3)">Square Matrix</button>
                </div>
            </div>

            <!-- Tab 6: Scalar Multiplication -->
            <div id="tab5" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 15px;">🔢 Scalar Multiplication</h3>
                
                <div class="matrix-controls">
                    <div class="matrix-control-group">
                        <label>Rows:</label>
                        <input type="number" id="scalar_rows" class="matrix-size-input" value="2" min="1" max="6" onchange="createScalarMatrix()">
                    </div>
                    <div class="matrix-control-group">
                        <label>Columns:</label>
                        <input type="number" id="scalar_cols" class="matrix-size-input" value="2" min="1" max="6" onchange="createScalarMatrix()">
                    </div>
                </div>
                
                <div class="input-section">
                    <label>Scalar Value</label>
                    <input type="number" id="scalar_value" value="2" step="any">
                </div>
                
                <div class="matrix-container">
                    <div class="matrix-wrapper">
                        <div class="matrix-label">Matrix</div>
                        <div class="matrix" id="matrixScalar"></div>
                    </div>
                </div>
                
                <button class="btn" onclick="calculateScalarMultiplication()">Calculate Scalar Multiplication</button>
                
                <div class="examples">
                    <button class="example-btn" onclick="loadScalarExample(1)">Multiply by 2</button>
                    <button class="example-btn" onclick="loadScalarExample(2)">Multiply by -1</button>
                    <button class="example-btn" onclick="loadScalarExample(3)">Multiply by 0.5</button>
                </div>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Solution</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Matrix Operations Guide</h3>
            <div class="rule-grid">
                <div class="rule-card">
                    <strong>Matrix Addition</strong>
                    <code>A + B = [aᵢⱼ + bᵢⱼ]<br>Matrices must have same dimensions</code>
                </div>
                <div class="rule-card">
                    <strong>Matrix Multiplication</strong>
                    <code>(AB)ᵢⱼ = Σ aᵢₖ × bₖⱼ<br>Columns of A = Rows of B</code>
                </div>
                <div class="rule-card">
                    <strong>Determinant</strong>
                    <code>2×2: ad - bc<br>3×3: a(ei−fh)−b(di−fg)+c(dh−eg)</code>
                </div>
                <div class="rule-card">
                    <strong>Matrix Inverse</strong>
                    <code>A⁻¹ = (1/det(A)) × adj(A)<br>Only for square, non-singular matrices</code>
                </div>
                <div class="rule-card">
                    <strong>Transpose</strong>
                    <code>(Aᵀ)ᵢⱼ = Aⱼᵢ<br>Rows become columns</code>
                </div>
                <div class="rule-card">
                    <strong>Scalar Multiplication</strong>
                    <code>k × A = [k × aᵢⱼ]<br>Multiply each element by scalar</code>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize matrices on page load
        document.addEventListener('DOMContentLoaded', function() {
            createAdditionMatrices();
            createMultiplicationMatrices();
            createDeterminantMatrix();
            createInverseMatrix();
            createTransposeMatrix();
            createScalarMatrix();
        });

        function switchTab(i) {
            document.querySelectorAll('.tab-btn').forEach((btn, index) => {
                btn.classList.toggle('active', index === i);
            });
            
            document.querySelectorAll('.tab-content').forEach((content, index) => {
                content.classList.toggle('active', index === i);
            });
            
            document.getElementById('result').classList.remove('show');
        }
        
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
            document.getElementById('result').scrollIntoView({behavior: 'smooth', block: 'nearest'});
        }
        
        // Matrix creation functions
        function createMatrix(containerId, rows, cols, values = null) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';
            
            for (let i = 0; i < rows; i++) {
                const rowDiv = document.createElement('div');
                rowDiv.className = 'matrix-row';
                
                for (let j = 0; j < cols; j++) {
                    const input = document.createElement('input');
                    input.type = 'number';
                    input.className = 'matrix-cell';
                    input.value = values ? values[i][j] : (i === j ? '1' : '0');
                    input.dataset.row = i;
                    input.dataset.col = j;
                    rowDiv.appendChild(input);
                }
                
                container.appendChild(rowDiv);
            }
        }
        
        function getMatrixValues(containerId) {
            const container = document.getElementById(containerId);
            const inputs = container.getElementsByClassName('matrix-cell');
            const rows = container.getElementsByClassName('matrix-row').length;
            const cols = rows > 0 ? container.getElementsByClassName('matrix-row')[0].children.length : 0;
            
            const matrix = [];
            for (let i = 0; i < rows; i++) {
                matrix[i] = [];
                for (let j = 0; j < cols; j++) {
                    const input = container.querySelector(`.matrix-cell[data-row="${i}"][data-col="${j}"]`);
                    matrix[i][j] = parseFloat(input.value) || 0;
                }
            }
            return matrix;
        }
        
        function formatMatrix(matrix) {
            if (!matrix || matrix.length === 0) return '';
            
            let html = '<div class="result-matrix">';
            for (let i = 0; i < matrix.length; i++) {
                html += '<div class="matrix-row">';
                for (let j = 0; j < matrix[i].length; j++) {
                    html += `<span class="matrix-cell">${matrix[i][j].toFixed(2)}</span>`;
                }
                html += '</div>';
            }
            html += '</div>';
            return html;
        }
        
        // Matrix operations
        function matrixAddition(A, B) {
            if (A.length !== B.length || A[0].length !== B[0].length) {
                throw new Error('Matrices must have the same dimensions for addition');
            }
            
            const result = [];
            for (let i = 0; i < A.length; i++) {
                result[i] = [];
                for (let j = 0; j < A[i].length; j++) {
                    result[i][j] = A[i][j] + B[i][j];
                }
            }
            return result;
        }
        
        function matrixMultiplication(A, B) {
            if (A[0].length !== B.length) {
                throw new Error('Number of columns in A must equal number of rows in B');
            }
            
            const result = [];
            for (let i = 0; i < A.length; i++) {
                result[i] = [];
                for (let j = 0; j < B[0].length; j++) {
                    let sum = 0;
                    for (let k = 0; k < A[0].length; k++) {
                        sum += A[i][k] * B[k][j];
                    }
                    result[i][j] = sum;
                }
            }
            return result;
        }
        
        function matrixDeterminant(matrix) {
            if (matrix.length !== matrix[0].length) {
                throw new Error('Matrix must be square');
            }
            
            const n = matrix.length;
            
            if (n === 1) return matrix[0][0];
            if (n === 2) {
                return matrix[0][0] * matrix[1][1] - matrix[0][1] * matrix[1][0];
            }
            if (n === 3) {
                return matrix[0][0] * (matrix[1][1]*matrix[2][2] - matrix[1][2]*matrix[2][1]) -
                       matrix[0][1] * (matrix[1][0]*matrix[2][2] - matrix[1][2]*matrix[2][0]) +
                       matrix[0][2] * (matrix[1][0]*matrix[2][1] - matrix[1][1]*matrix[2][0]);
            }
            
            throw new Error('Determinant calculation only supported for matrices up to 3×3');
        }
        
        function matrixTranspose(matrix) {
            const result = [];
            for (let j = 0; j < matrix[0].length; j++) {
                result[j] = [];
                for (let i = 0; i < matrix.length; i++) {
                    result[j][i] = matrix[i][j];
                }
            }
            return result;
        }
        
        function scalarMultiplication(matrix, scalar) {
            const result = [];
            for (let i = 0; i < matrix.length; i++) {
                result[i] = [];
                for (let j = 0; j < matrix[i].length; j++) {
                    result[i][j] = matrix[i][j] * scalar;
                }
            }
            return result;
        }
        
        // Matrix creation for each tab
        function createAdditionMatrices() {
            const rows = parseInt(document.getElementById('add_rows').value);
            const cols = parseInt(document.getElementById('add_cols').value);
            createMatrix('matrixA', rows, cols);
            createMatrix('matrixB', rows, cols);
        }
        
        function createMultiplicationMatrices() {
            const rowsA = parseInt(document.getElementById('mulA_rows').value);
            const colsA = parseInt(document.getElementById('mulA_cols').value);
            const rowsB = parseInt(document.getElementById('mulB_rows').value);
            const colsB = parseInt(document.getElementById('mulB_cols').value);
            
            createMatrix('matrixMulA', rowsA, colsA);
            createMatrix('matrixMulB', rowsB, colsB);
        }
        
        function createDeterminantMatrix() {
            const size = parseInt(document.getElementById('det_size').value);
            createMatrix('matrixDet', size, size);
        }
        
        function createInverseMatrix() {
            const size = parseInt(document.getElementById('inv_size').value);
            createMatrix('matrixInv', size, size);
        }
        
        function createTransposeMatrix() {
            const rows = parseInt(document.getElementById('trans_rows').value);
            const cols = parseInt(document.getElementById('trans_cols').value);
            createMatrix('matrixTrans', rows, cols);
        }
        
        function createScalarMatrix() {
            const rows = parseInt(document.getElementById('scalar_rows').value);
            const cols = parseInt(document.getElementById('scalar_cols').value);
            createMatrix('matrixScalar', rows, cols);
        }
        
        // Calculation functions
        function calculateAddition() {
            try {
                const A = getMatrixValues('matrixA');
                const B = getMatrixValues('matrixB');
                const result = matrixAddition(A, B);
                
                let html = `<div class="result-box">
                    <div class="result-label">Matrix A</div>
                    <div class="result-value">${formatMatrix(A)}</div>
                </div>
                <div class="result-box">
                    <div class="result-label">Matrix B</div>
                    <div class="result-value">${formatMatrix(B)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Result: A + B</div>
                    <div class="result-value" style="color:#2196F3;">${formatMatrix(result)}</div>
                </div>
                <div class="step-box">
                    <strong>📝 Step-by-Step Calculation:</strong>
                    <div class="step">Matrix addition is performed element-wise</div>
                    <div class="step">Each element in the result is the sum of corresponding elements from A and B</div>
                    <div class="step">Formula: (A + B)ᵢⱼ = Aᵢⱼ + Bᵢⱼ</div>
                </div>`;
                
                show(html);
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }
        
        function calculateMultiplication() {
            try {
                const A = getMatrixValues('matrixMulA');
                const B = getMatrixValues('matrixMulB');
                const result = matrixMultiplication(A, B);
                
                let steps = '<strong>📝 Step-by-Step Calculation:</strong>';
                steps += '<div class="step">Matrix multiplication: (AB)ᵢⱼ = Σ Aᵢₖ × Bₖⱼ</div>';
                
                // Show detailed calculation for smaller matrices
                if (A.length <= 3 && B[0].length <= 3) {
                    for (let i = 0; i < A.length; i++) {
                        for (let j = 0; j < B[0].length; j++) {
                            let step = `Element (${i+1},${j+1}): `;
                            let calculation = [];
                            for (let k = 0; k < A[0].length; k++) {
                                calculation.push(`${A[i][k]} × ${B[k][j]}`);
                            }
                            step += calculation.join(' + ') + ` = ${result[i][j].toFixed(2)}`;
                            steps += `<div class="step">${step}</div>`;
                        }
                    }
                }
                
                let html = `<div class="result-box">
                    <div class="result-label">Matrix A</div>
                    <div class="result-value">${formatMatrix(A)}</div>
                </div>
                <div class="result-box">
                    <div class="result-label">Matrix B</div>
                    <div class="result-value">${formatMatrix(B)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Result: A × B</div>
                    <div class="result-value" style="color:#2196F3;">${formatMatrix(result)}</div>
                </div>
                <div class="step-box">${steps}</div>`;
                
                show(html);
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }
        
        function calculateDeterminant() {
            try {
                const matrix = getMatrixValues('matrixDet');
                const det = matrixDeterminant(matrix);
                
                let steps = '<strong>📝 Step-by-Step Calculation:</strong>';
                
                if (matrix.length === 2) {
                    steps += `<div class="step">For 2×2 matrix: det = (a×d) - (b×c)</div>`;
                    steps += `<div class="step">det = (${matrix[0][0]} × ${matrix[1][1]}) - (${matrix[0][1]} × ${matrix[1][0]})</div>`;
                    steps += `<div class="step">det = ${(matrix[0][0] * matrix[1][1]).toFixed(2)} - ${(matrix[0][1] * matrix[1][0]).toFixed(2)}</div>`;
                } else if (matrix.length === 3) {
                    steps += `<div class="step">For 3×3 matrix: det = a(ei−fh) − b(di−fg) + c(dh−eg)</div>`;
                    // Add detailed 3x3 calculation steps
                }
                
                steps += `<div class="step">Determinant = ${det.toFixed(6)}</div>`;
                
                let html = `<div class="result-box">
                    <div class="result-label">Matrix</div>
                    <div class="result-value">${formatMatrix(matrix)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Determinant</div>
                    <div class="result-value" style="color:#2196F3; font-size: 1.8rem;">${det.toFixed(6)}</div>
                </div>
                <div class="step-box">${steps}</div>`;
                
                show(html);
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }
        
        function calculateTranspose() {
            try {
                const matrix = getMatrixValues('matrixTrans');
                const result = matrixTranspose(matrix);
                
                let html = `<div class="result-box">
                    <div class="result-label">Original Matrix</div>
                    <div class="result-value">${formatMatrix(matrix)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Transpose</div>
                    <div class="result-value" style="color:#2196F3;">${formatMatrix(result)}</div>
                </div>
                <div class="step-box">
                    <strong>📝 Step-by-Step Calculation:</strong>
                    <div class="step">Transpose operation swaps rows and columns</div>
                    <div class="step">Element at position (i,j) becomes element at position (j,i)</div>
                    <div class="step">Formula: (Aᵀ)ᵢⱼ = Aⱼᵢ</div>
                </div>`;
                
                show(html);
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }
        
        function calculateScalarMultiplication() {
            try {
                const matrix = getMatrixValues('matrixScalar');
                const scalar = parseFloat(document.getElementById('scalar_value').value);
                const result = scalarMultiplication(matrix, scalar);
                
                let html = `<div class="result-box">
                    <div class="result-label">Original Matrix</div>
                    <div class="result-value">${formatMatrix(matrix)}</div>
                </div>
                <div class="result-box">
                    <div class="result-label">Scalar</div>
                    <div class="result-value">${scalar}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Result</div>
                    <div class="result-value" style="color:#2196F3;">${formatMatrix(result)}</div>
                </div>
                <div class="step-box">
                    <strong>📝 Step-by-Step Calculation:</strong>
                    <div class="step">Scalar multiplication multiplies every element by the scalar value</div>
                    <div class="step">Formula: (kA)ᵢⱼ = k × Aᵢⱼ</div>
                    <div class="step">Each element is multiplied by ${scalar}</div>
                </div>`;
                
                show(html);
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }
        
        function calculateInverse() {
            try {
                const matrix = getMatrixValues('matrixInv');
                const det = matrixDeterminant(matrix);
                
                if (Math.abs(det) < 1e-10) {
                    throw new Error('Matrix is singular (determinant = 0), no inverse exists');
                }
                
                let result;
                let steps = '<strong>📝 Step-by-Step Calculation:</strong>';
                
                if (matrix.length === 2) {
                    // For 2x2 matrix: inverse = (1/det) * [[d, -b], [-c, a]]
                    const a = matrix[0][0], b = matrix[0][1], c = matrix[1][0], d = matrix[1][1];
                    result = [
                        [d/det, -b/det],
                        [-c/det, a/det]
                    ];
                    
                    steps += `<div class="step">For 2×2 matrix: A⁻¹ = (1/det(A)) × [[d, -b], [-c, a]]</div>`;
                    steps += `<div class="step">det(A) = ${det.toFixed(6)}</div>`;
                    steps += `<div class="step">A⁻¹ = (1/${det.toFixed(6)}) × [[${d}, ${-b}], [${-c}, ${a}]]</div>`;
                } else {
                    throw new Error('Inverse calculation only supported for 2×2 matrices in this version');
                }
                
                steps += `<div class="step">Verification: A × A⁻¹ should equal identity matrix</div>`;
                
                let html = `<div class="result-box">
                    <div class="result-label">Original Matrix</div>
                    <div class="result-value">${formatMatrix(matrix)}</div>
                </div>
                <div class="result-box">
                    <div class="result-label">Determinant</div>
                    <div class="result-value">${det.toFixed(6)}</div>
                </div>
                <div class="result-box" style="border-left-color:#2196F3;">
                    <div class="result-label">Inverse Matrix</div>
                    <div class="result-value" style="color:#2196F3;">${formatMatrix(result)}</div>
                </div>
                <div class="step-box">${steps}</div>`;
                
                show(html);
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }
        
        // Example loaders
        function loadAdditionExample(type) {
            let A, B;
            switch(type) {
                case 1: // 2x2 Identity + Ones
                    A = [[1, 0], [0, 1]];
                    B = [[1, 1], [1, 1]];
                    break;
                case 2: // 3x3 Random
                    A = [[1, 2, 3], [4, 5, 6], [7, 8, 9]];
                    B = [[9, 8, 7], [6, 5, 4], [3, 2, 1]];
                    break;
                case 3: // 2x3 Matrices
                    A = [[1, 2, 3], [4, 5, 6]];
                    B = [[2, 3, 4], [5, 6, 7]];
                    break;
            }
            
            document.getElementById('add_rows').value = A.length;
            document.getElementById('add_cols').value = A[0].length;
            createMatrix('matrixA', A.length, A[0].length, A);
            createMatrix('matrixB', B.length, B[0].length, B);
        }
        
        function loadMultiplicationExample(type) {
            let A, B;
            switch(type) {
                case 1: // 2x2 × 2x2
                    A = [[1, 2], [3, 4]];
                    B = [[2, 0], [1, 2]];
                    document.getElementById('mulA_rows').value = 2;
                    document.getElementById('mulA_cols').value = 2;
                    document.getElementById('mulB_rows').value = 2;
                    document.getElementById('mulB_cols').value = 2;
                    break;
                case 2: // 2x3 × 3x2
                    A = [[1, 2, 3], [4, 5, 6]];
                    B = [[7, 8], [9, 10], [11, 12]];
                    document.getElementById('mulA_rows').value = 2;
                    document.getElementById('mulA_cols').value = 3;
                    document.getElementById('mulB_rows').value = 3;
                    document.getElementById('mulB_cols').value = 2;
                    break;
                case 3: // 3x3 Identity
                    A = [[1, 0, 0], [0, 1, 0], [0, 0, 1]];
                    B = [[2, 3, 1], [4, 5, 2], [1, 2, 3]];
                    document.getElementById('mulA_rows').value = 3;
                    document.getElementById('mulA_cols').value = 3;
                    document.getElementById('mulB_rows').value = 3;
                    document.getElementById('mulB_cols').value = 3;
                    break;
            }
            
            createMatrix('matrixMulA', A.length, A[0].length, A);
            createMatrix('matrixMulB', B.length, B[0].length, B);
        }
        
        function loadDeterminantExample(type) {
            let matrix;
            switch(type) {
                case 1: // 2x2
                    matrix = [[3, 1], [2, 4]];
                    document.getElementById('det_size').value = 2;
                    break;
                case 2: // 3x3
                    matrix = [[1, 2, 3], [0, 1, 4], [5, 6, 0]];
                    document.getElementById('det_size').value = 3;
                    break;
                case 3: // Identity
                    matrix = [[1, 0, 0], [0, 1, 0], [0, 0, 1]];
                    document.getElementById('det_size').value = 3;
                    break;
            }
            createMatrix('matrixDet', matrix.length, matrix.length, matrix);
        }
        
        function loadInverseExample(type) {
            let matrix;
            switch(type) {
                case 1: // 2x2 Invertible
                    matrix = [[4, 7], [2, 6]];
                    break;
                case 2: // 3x3 Matrix
                    matrix = [[1, 2, 3], [0, 1, 4], [5, 6, 0]];
                    break;
                case 3: // Singular Matrix
                    matrix = [[1, 2], [2, 4]];
                    break;
            }
            document.getElementById('inv_size').value = matrix.length;
            createMatrix('matrixInv', matrix.length, matrix.length, matrix);
        }
        
        function loadTransposeExample(type) {
            let matrix;
            switch(type) {
                case 1: // 2x3
                    matrix = [[1, 2, 3], [4, 5, 6]];
                    document.getElementById('trans_rows').value = 2;
                    document.getElementById('trans_cols').value = 3;
                    break;
                case 2: // 3x2
                    matrix = [[1, 2], [3, 4], [5, 6]];
                    document.getElementById('trans_rows').value = 3;
                    document.getElementById('trans_cols').value = 2;
                    break;
                case 3: // Square
                    matrix = [[1, 2, 3], [4, 5, 6], [7, 8, 9]];
                    document.getElementById('trans_rows').value = 3;
                    document.getElementById('trans_cols').value = 3;
                    break;
            }
            createMatrix('matrixTrans', matrix.length, matrix[0].length, matrix);
        }
        
        function loadScalarExample(type) {
            let matrix, scalar;
            switch(type) {
                case 1: // Multiply by 2
                    matrix = [[1, 2], [3, 4]];
                    scalar = 2;
                    break;
                case 2: // Multiply by -1
                    matrix = [[1, 2], [3, 4]];
                    scalar = -1;
                    break;
                case 3: // Multiply by 0.5
                    matrix = [[2, 4], [6, 8]];
                    scalar = 0.5;
                    break;
            }
            document.getElementById('scalar_rows').value = matrix.length;
            document.getElementById('scalar_cols').value = matrix[0].length;
            document.getElementById('scalar_value').value = scalar;
            createMatrix('matrixScalar', matrix.length, matrix[0].length, matrix);
        }
    </script>
</body>
</html>