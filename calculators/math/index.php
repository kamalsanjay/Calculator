<?php
/**
 * Symbolab Calculator Collection
 * File: index.php
 * Description: Main landing page with all calculators
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Calculator Collection - Math & Statistical Tools</title>
    <meta name="description" content="Complete collection of mathematical and statistical calculators. Solve equations, calculate ratios, analyze data, and more.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 16px; overflow-x: hidden; }
        
        header { background: rgba(255,255,255,0.1); color: white; padding: 32px 20px; text-align: center; border-radius: 16px; margin-bottom: 24px; backdrop-filter: blur(10px); box-shadow: 0 8px 32px rgba(0,0,0,0.1); }
        header h1 { font-size: 2rem; margin-bottom: 12px; font-weight: 700; letter-spacing: -0.5px; }
        header p { font-size: 1rem; opacity: 0.9; line-height: 1.6; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .search-box { background: white; padding: 16px; border-radius: 12px; margin-bottom: 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.1); }
        .search-input { width: 100%; padding: 14px 20px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; }
        .search-input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .category { background: white; padding: 20px; border-radius: 16px; margin-bottom: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .category-header { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid #f0f0f0; }
        .category-icon { font-size: 1.8rem; }
        .category-title { font-size: 1.3rem; font-weight: 700; color: #333; }
        
        .calc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; }
        
        .calc-card { background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); padding: 20px; border-radius: 12px; border: 2px solid #e0e0e0; cursor: pointer; transition: all 0.3s; text-decoration: none; display: block; position: relative; overflow: hidden; }
        .calc-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); transition: width 0.3s; }
        .calc-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.12); border-color: #667eea; }
        .calc-card:hover::before { width: 100%; opacity: 0.05; }
        
        .calc-icon { font-size: 2rem; margin-bottom: 12px; }
        .calc-title { font-size: 1.1rem; font-weight: 600; color: #333; margin-bottom: 8px; }
        .calc-desc { font-size: 0.875rem; color: #666; line-height: 1.5; }
        
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px; margin-bottom: 24px; }
        .stat-card { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); padding: 16px; border-radius: 12px; text-align: center; color: white; }
        .stat-number { font-size: 2rem; font-weight: bold; margin-bottom: 4px; }
        .stat-label { font-size: 0.875rem; opacity: 0.9; }
        
        footer { text-align: center; color: white; padding: 24px; margin-top: 32px; opacity: 0.9; }
        
        .no-results { text-align: center; padding: 48px 20px; color: #666; }
        .no-results-icon { font-size: 4rem; margin-bottom: 16px; opacity: 0.5; }
        
        @media (max-width: 768px) {
            header h1 { font-size: 1.5rem; }
            .calc-grid { grid-template-columns: 1fr; }
            .category-title { font-size: 1.1rem; }
        }
    </style>
</head>
<body>
    <header>
        <h1>🧮 Calculator Collection</h1>
        <p>Complete toolkit for mathematical, statistical, and financial calculations</p>
    </header>

    <div class="container">
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number">10+</div>
                <div class="stat-label">Calculators</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">50+</div>
                <div class="stat-label">Functions</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">100%</div>
                <div class="stat-label">Accurate</div>
            </div>
        </div>

        <div class="search-box">
            <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search calculators..." onkeyup="filterCalculators()">
        </div>

        <!-- Algebra & Equations -->
        <div class="category" data-category="algebra">
            <div class="category-header">
                <span class="category-icon">📐</span>
                <h2 class="category-title">Algebra & Equations</h2>
            </div>
            <div class="calc-grid">
                <a href="calculators/linear-equation-solver.php" class="calc-card" data-name="Linear Equation Solver">
                    <div class="calc-icon">🔢</div>
                    <div class="calc-title">Linear Equation Solver</div>
                    <div class="calc-desc">Solve linear equations with step-by-step solutions. Supports fractions and decimals.</div>
                </a>
                <a href="calculators/quadratic-calculator.php" class="calc-card" data-name="Quadratic Calculator">
                    <div class="calc-icon">📊</div>
                    <div class="calc-title">Quadratic Calculator</div>
                    <div class="calc-desc">Solve quadratic equations using multiple methods. Find roots and vertex.</div>
                </a>
                <a href="calculators/system-of-equations.php" class="calc-card" data-name="System of Equations">
                    <div class="calc-icon">🎯</div>
                    <div class="calc-title">System of Equations</div>
                    <div class="calc-desc">Solve systems with 2-3 variables using elimination and substitution.</div>
                </a>
            </div>
        </div>

        <!-- Geometry & Trigonometry -->
        <div class="category" data-category="geometry">
            <div class="category-header">
                <span class="category-icon">📏</span>
                <h2 class="category-title">Geometry & Trigonometry</h2>
            </div>
            <div class="calc-grid">
                <a href="calculators/pythagorean-theorem-calculator.php" class="calc-card" data-name="Pythagorean Theorem">
                    <div class="calc-icon">△</div>
                    <div class="calc-title">Pythagorean Theorem</div>
                    <div class="calc-desc">Calculate right triangle sides, angles, and area using a² + b² = c².</div>
                </a>
                <a href="calculators/triangle-calculator.php" class="calc-card" data-name="Triangle Calculator">
                    <div class="calc-icon">▲</div>
                    <div class="calc-title">Triangle Calculator</div>
                    <div class="calc-desc">Solve any triangle using sides, angles, and trigonometry.</div>
                </a>
                <a href="calculators/circle-calculator.php" class="calc-card" data-name="Circle Calculator">
                    <div class="calc-icon">⭕</div>
                    <div class="calc-title">Circle Calculator</div>
                    <div class="calc-desc">Calculate area, circumference, diameter, and radius of circles.</div>
                </a>
            </div>
        </div>

        <!-- Numbers & Operations -->
        <div class="category" data-category="numbers">
            <div class="category-header">
                <span class="category-icon">🔢</span>
                <h2 class="category-title">Numbers & Operations</h2>
            </div>
            <div class="calc-grid">
                <a href="calculators/ratio-calculator.php" class="calc-card" data-name="Ratio Calculator">
                    <div class="calc-icon">⚖️</div>
                    <div class="calc-title">Ratio Calculator</div>
                    <div class="calc-desc">Simplify, scale, and solve proportions. 3-way ratio division included.</div>
                </a>
                <a href="calculators/percentage-calculator.php" class="calc-card" data-name="Percentage Calculator">
                    <div class="calc-icon">%</div>
                    <div class="calc-title">Percentage Calculator</div>
                    <div class="calc-desc">Calculate percentages, increase/decrease, and find what percent.</div>
                </a>
                <a href="calculators/fraction-calculator.php" class="calc-card" data-name="Fraction Calculator">
                    <div class="calc-icon">¼</div>
                    <div class="calc-title">Fraction Calculator</div>
                    <div class="calc-desc">Add, subtract, multiply, and divide fractions with simplification.</div>
                </a>
                <a href="calculators/square-root-calculator.php" class="calc-card" data-name="Square Root Calculator">
                    <div class="calc-icon">√</div>
                    <div class="calc-title">Square Root Calculator</div>
                    <div class="calc-desc">Calculate square roots, cube roots, and nth roots with simplification.</div>
                </a>
            </div>
        </div>

        <!-- Statistics & Data -->
        <div class="category" data-category="statistics">
            <div class="category-header">
                <span class="category-icon">📊</span>
                <h2 class="category-title">Statistics & Data Analysis</h2>
            </div>
            <div class="calc-grid">
                <a href="calculators/sample-size-calculator.php" class="calc-card" data-name="Sample Size Calculator">
                    <div class="calc-icon">📈</div>
                    <div class="calc-title">Sample Size Calculator</div>
                    <div class="calc-desc">Calculate sample sizes for surveys and experiments with power analysis.</div>
                </a>
                <a href="calculators/mean-median-mode.php" class="calc-card" data-name="Mean Median Mode">
                    <div class="calc-icon">📉</div>
                    <div class="calc-title">Mean, Median, Mode</div>
                    <div class="calc-desc">Calculate central tendency measures and data distribution statistics.</div>
                </a>
                <a href="calculators/standard-deviation.php" class="calc-card" data-name="Standard Deviation">
                    <div class="calc-icon">σ</div>
                    <div class="calc-title">Standard Deviation</div>
                    <div class="calc-desc">Calculate variance, standard deviation, and z-scores.</div>
                </a>
            </div>
        </div>

        <!-- Financial -->
        <div class="category" data-category="financial">
            <div class="category-header">
                <span class="category-icon">💰</span>
                <h2 class="category-title">Financial Calculators</h2>
            </div>
            <div class="calc-grid">
                <a href="calculators/compound-interest.php" class="calc-card" data-name="Compound Interest">
                    <div class="calc-icon">💸</div>
                    <div class="calc-title">Compound Interest</div>
                    <div class="calc-desc">Calculate investment growth with compound interest formulas.</div>
                </a>
                <a href="calculators/loan-calculator.php" class="calc-card" data-name="Loan Calculator">
                    <div class="calc-icon">🏦</div>
                    <div class="calc-title">Loan Calculator</div>
                    <div class="calc-desc">Calculate loan payments, interest, and amortization schedules.</div>
                </a>
            </div>
        </div>

        <div class="no-results" id="noResults" style="display: none;">
            <div class="no-results-icon">🔍</div>
            <h3>No calculators found</h3>
            <p>Try a different search term</p>
        </div>
    </div>

    <footer>
        <p>© 2025 Calculator Collection | All calculators are free to use</p>
        <p style="margin-top: 8px; font-size: 0.875rem;">Built with ❤️ for students, professionals, and math enthusiasts</p>
    </footer>

    <script>
        function filterCalculators() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.calc-card');
            const categories = document.querySelectorAll('.category');
            let visibleCount = 0;

            categories.forEach(category => {
                let categoryHasVisible = false;
                const categoryCards = category.querySelectorAll('.calc-card');
                
                categoryCards.forEach(card => {
                    const name = card.getAttribute('data-name').toLowerCase();
                    const desc = card.querySelector('.calc-desc').textContent.toLowerCase();
                    
                    if(name.includes(searchTerm) || desc.includes(searchTerm)) {
                        card.style.display = 'block';
                        categoryHasVisible = true;
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                category.style.display = categoryHasVisible ? 'block' : 'none';
            });

            document.getElementById('noResults').style.display = visibleCount === 0 ? 'block' : 'none';
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Add loading animation to cards
        document.querySelectorAll('.calc-card').forEach(card => {
            card.addEventListener('click', function(e) {
                this.style.opacity = '0.5';
            });
        });
    </script>
</body>
</html>