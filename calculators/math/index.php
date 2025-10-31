<?php
/**
 * Math Calculators Collection
 * File: math/index.php
 * Description: Complete landing page for 42+ mathematical calculators
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Math Calculators - 42+ Advanced Mathematical Tools</title>
    <meta name="description" content="Complete collection of math calculators: algebra, calculus, statistics, geometry, and more. Solve equations, calculate areas, and analyze data.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 16px; overflow-x: hidden; }
        
        /* Scroll animations */
        .fade-in { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }
        .slide-in-left { opacity: 0; transform: translateX(-50px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
        .slide-in-left.visible { opacity: 1; transform: translateX(0); }
        .slide-in-right { opacity: 0; transform: translateX(50px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
        .slide-in-right.visible { opacity: 1; transform: translateX(0); }
        .scale-in { opacity: 0; transform: scale(0.9); transition: opacity 0.5s ease-out, transform 0.5s ease-out; }
        .scale-in.visible { opacity: 1; transform: scale(1); }
        
        header { background: rgba(255,255,255,0.15); color: white; padding: 32px 20px; text-align: center; border-radius: 16px; margin-bottom: 24px; backdrop-filter: blur(10px); box-shadow: 0 8px 32px rgba(0,0,0,0.1); }
        header h1 { font-size: 2rem; margin-bottom: 12px; font-weight: 700; letter-spacing: -0.5px; }
        header p { font-size: 1rem; opacity: 0.95; line-height: 1.6; max-width: 700px; margin: 0 auto; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .breadcrumb { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; }
        .breadcrumb a { color: white; text-decoration: none; font-weight: 500; transition: opacity 0.3s; }
        .breadcrumb a:hover { opacity: 0.8; }
        .breadcrumb span { color: rgba(255,255,255,0.7); margin: 0 8px; }
        
        .search-box { background: white; padding: 16px; border-radius: 12px; margin-bottom: 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.1); }
        .search-input { width: 100%; padding: 14px 20px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; }
        .search-input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; margin-bottom: 24px; }
        .stat-card { background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); padding: 20px; border-radius: 12px; text-align: center; color: white; border: 2px solid rgba(255,255,255,0.3); }
        .stat-number { font-size: 2.5rem; font-weight: bold; margin-bottom: 4px; text-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stat-label { font-size: 0.9rem; opacity: 0.95; font-weight: 500; }
        
        .category { background: white; padding: 24px; border-radius: 16px; margin-bottom: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .category-header { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 3px solid #f0f0f0; flex-wrap: wrap; }
        .category-icon { font-size: 2rem; }
        .category-title { font-size: 1.4rem; font-weight: 700; color: #667eea; flex: 1; }
        .category-count { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }
        
        .calc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; }
        
        .calc-card { background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); padding: 18px; border-radius: 12px; border: 2px solid #e8e8e8; cursor: pointer; transition: all 0.3s; text-decoration: none; display: block; position: relative; overflow: hidden; }
        .calc-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); transition: width 0.3s; }
        .calc-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15); border-color: #667eea; }
        .calc-card:hover::before { width: 100%; opacity: 0.05; }
        
        .calc-icon { font-size: 2rem; margin-bottom: 10px; }
        .calc-title { font-size: 1rem; font-weight: 600; color: #333; margin-bottom: 6px; line-height: 1.3; }
        .calc-desc { font-size: 0.825rem; color: #666; line-height: 1.4; }
        .calc-badge { display: inline-block; background: rgba(102, 126, 234, 0.1); color: #667eea; padding: 3px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; margin-top: 8px; text-transform: uppercase; }
        
        .no-results { text-align: center; padding: 60px 20px; color: #666; }
        .no-results-icon { font-size: 4rem; margin-bottom: 16px; opacity: 0.4; }
        
        footer { text-align: center; color: white; padding: 24px; margin-top: 32px; opacity: 0.95; }
        
        html { scroll-behavior: smooth; }
        
        @media (max-width: 768px) {
            header h1 { font-size: 1.6rem; }
            .calc-grid { grid-template-columns: 1fr; }
            .category-title { font-size: 1.2rem; }
            .stat-number { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <header class="fade-in">
        <h1>🧮 Math Calculators</h1>
        <p>Comprehensive collection of 42+ mathematical calculators covering algebra, calculus, statistics, geometry, and advanced mathematics</p>
    </header>

    <div class="container">
        <div class="breadcrumb fade-in">
            <a href="../index.php">🏠 Home</a>
            <span>›</span>
            <span>Math Calculators</span>
        </div>

        <div class="stats fade-in">
            <div class="stat-card scale-in">
                <div class="stat-number">42+</div>
                <div class="stat-label">Calculators</div>
            </div>
            <div class="stat-card scale-in">
                <div class="stat-number">7</div>
                <div class="stat-label">Categories</div>
            </div>
            <div class="stat-card scale-in">
                <div class="stat-number">100%</div>
                <div class="stat-label">Accurate</div>
            </div>
            <div class="stat-card scale-in">
                <div class="stat-number">Free</div>
                <div class="stat-label">Always</div>
            </div>
        </div>

        <div class="search-box fade-in">
            <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search math calculators..." onkeyup="filterCalculators()">
        </div>

        <!-- Basic Calculations -->
        <div class="category fade-in" data-category="basic">
            <div class="category-header">
                <span class="category-icon">🔢</span>
                <h2 class="category-title">Basic Calculations</h2>
                <span class="category-count">8 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="scientific-calculator.php" class="calc-card slide-in-left" data-name="Scientific Calculator">
                    <div class="calc-icon">🔬</div>
                    <div class="calc-title">Scientific Calculator</div>
                    <div class="calc-desc">Advanced calculator with trigonometry, logarithms, and exponentials.</div>
                    <span class="calc-badge">Popular</span>
                </a>
                <a href="basic-calculator.php" class="calc-card slide-in-left" data-name="Basic Calculator">
                    <div class="calc-icon">🖩</div>
                    <div class="calc-title">Basic Calculator</div>
                    <div class="calc-desc">Simple arithmetic operations: add, subtract, multiply, divide.</div>
                </a>
                <a href="fraction-calculator.php" class="calc-card slide-in-left" data-name="Fraction Calculator">
                    <div class="calc-icon">¼</div>
                    <div class="calc-title">Fraction Calculator</div>
                    <div class="calc-desc">Add, subtract, multiply, divide fractions with simplification.</div>
                </a>
                <a href="percentage-calculator.php" class="calc-card slide-in-left" data-name="Percentage Calculator">
                    <div class="calc-icon">%</div>
                    <div class="calc-title">Percentage Calculator</div>
                    <div class="calc-desc">Calculate percentages, increases, decreases, and ratios.</div>
                </a>
                <a href="ratio-calculator.php" class="calc-card slide-in-left" data-name="Ratio Calculator">
                    <div class="calc-icon">⚖️</div>
                    <div class="calc-title">Ratio Calculator</div>
                    <div class="calc-desc">Simplify ratios and solve proportions with step-by-step.</div>
                </a>
                <a href="proportion-calculator.php" class="calc-card slide-in-left" data-name="Proportion Calculator">
                    <div class="calc-icon">🔗</div>
                    <div class="calc-title">Proportion Calculator</div>
                    <div class="calc-desc">Solve proportional relationships and cross-multiplication.</div>
                </a>
                <a href="exponent-calculator.php" class="calc-card slide-in-left" data-name="Exponent Calculator">
                    <div class="calc-icon">²</div>
                    <div class="calc-title">Exponent Calculator</div>
                    <div class="calc-desc">Calculate powers, exponentials, and scientific notation.</div>
                </a>
                <a href="square-root-calculator.php" class="calc-card slide-in-left" data-name="Square Root Calculator">
                    <div class="calc-icon">√</div>
                    <div class="calc-title">Square Root Calculator</div>
                    <div class="calc-desc">Calculate square roots, cube roots, and nth roots.</div>
                </a>
            </div>
        </div>

        <!-- Algebra -->
        <div class="category fade-in" data-category="algebra">
            <div class="category-header">
                <span class="category-icon">📐</span>
                <h2 class="category-title">Algebra & Equations</h2>
                <span class="category-count">3 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="logarithm-calculator.php" class="calc-card slide-in-right" data-name="Logarithm Calculator">
                    <div class="calc-icon">log</div>
                    <div class="calc-title">Logarithm Calculator</div>
                    <div class="calc-desc">Calculate natural log, common log, and logarithms of any base.</div>
                </a>
                <a href="algebra-calculator.php" class="calc-card slide-in-right" data-name="Algebra Calculator">
                    <div class="calc-icon">🔤</div>
                    <div class="calc-title">Algebra Calculator</div>
                    <div class="calc-desc">Solve algebraic expressions and simplify equations.</div>
                </a>
                <a href="equation-solver.php" class="calc-card slide-in-right" data-name="Equation Solver">
                    <div class="calc-icon">🎯</div>
                    <div class="calc-title">Equation Solver</div>
                    <div class="calc-desc">Solve linear, quadratic, and polynomial equations.</div>
                    <span class="calc-badge">Essential</span>
                </a>
            </div>
        </div>

        <!-- Statistics -->
        <div class="category fade-in" data-category="statistics">
            <div class="category-header">
                <span class="category-icon">📊</span>
                <h2 class="category-title">Statistics & Probability</h2>
                <span class="category-count">10 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="standard-deviation-calculator.php" class="calc-card slide-in-left" data-name="Standard Deviation">
                    <div class="calc-icon">σ</div>
                    <div class="calc-title">Standard Deviation</div>
                    <div class="calc-desc">Calculate population and sample standard deviation.</div>
                </a>
                <a href="mean-median-mode-calculator.php" class="calc-card slide-in-left" data-name="Mean Median Mode">
                    <div class="calc-icon">📈</div>
                    <div class="calc-title">Mean, Median, Mode</div>
                    <div class="calc-desc">Calculate central tendency measures for datasets.</div>
                </a>
                <a href="variance-calculator.php" class="calc-card slide-in-left" data-name="Variance Calculator">
                    <div class="calc-icon">📉</div>
                    <div class="calc-title">Variance Calculator</div>
                    <div class="calc-desc">Calculate variance and measure data spread.</div>
                </a>
                <a href="probability-calculator.php" class="calc-card slide-in-left" data-name="Probability Calculator">
                    <div class="calc-icon">🎲</div>
                    <div class="calc-title">Probability Calculator</div>
                    <div class="calc-desc">Calculate probability of events and outcomes.</div>
                </a>
                <a href="sample-size-calculator.php" class="calc-card slide-in-left" data-name="Sample Size Calculator">
                    <div class="calc-icon">📋</div>
                    <div class="calc-title">Sample Size Calculator</div>
                    <div class="calc-desc">Determine required sample size for statistical tests.</div>
                </a>
                <a href="confidence-interval-calculator.php" class="calc-card slide-in-left" data-name="Confidence Interval">
                    <div class="calc-icon">📍</div>
                    <div class="calc-title">Confidence Interval</div>
                    <div class="calc-desc">Calculate confidence intervals for population parameters.</div>
                </a>
                <a href="z-score-calculator.php" class="calc-card slide-in-left" data-name="Z Score Calculator">
                    <div class="calc-icon">Z</div>
                    <div class="calc-title">Z Score Calculator</div>
                    <div class="calc-desc">Calculate Z-scores and standard normal distribution.</div>
                </a>
                <a href="t-test-calculator.php" class="calc-card slide-in-left" data-name="T Test Calculator">
                    <div class="calc-icon">T</div>
                    <div class="calc-title">T-Test Calculator</div>
                    <div class="calc-desc">Perform t-tests for comparing means and hypothesis testing.</div>
                </a>
                <a href="chi-square-calculator.php" class="calc-card slide-in-left" data-name="Chi Square">
                    <div class="calc-icon">χ²</div>
                    <div class="calc-title">Chi-Square Calculator</div>
                    <div class="calc-desc">Test independence and goodness of fit.</div>
                </a>
                <a href="correlation-calculator.php" class="calc-card slide-in-left" data-name="Correlation Calculator">
                    <div class="calc-icon">📊</div>
                    <div class="calc-title">Correlation Calculator</div>
                    <div class="calc-desc">Calculate Pearson correlation coefficient.</div>
                </a>
            </div>
        </div>

        <!-- Geometry -->
        <div class="category fade-in" data-category="geometry">
            <div class="category-header">
                <span class="category-icon">📏</span>
                <h2 class="category-title">Geometry & Shapes</h2>
                <span class="category-count">10 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="area-calculator.php" class="calc-card slide-in-right" data-name="Area Calculator">
                    <div class="calc-icon">▢</div>
                    <div class="calc-title">Area Calculator</div>
                    <div class="calc-desc">Calculate area of various 2D shapes.</div>
                </a>
                <a href="volume-calculator.php" class="calc-card slide-in-right" data-name="Volume Calculator">
                    <div class="calc-icon">🧊</div>
                    <div class="calc-title">Volume Calculator</div>
                    <div class="calc-desc">Calculate volume of 3D solids and shapes.</div>
                </a>
                <a href="perimeter-calculator.php" class="calc-card slide-in-right" data-name="Perimeter Calculator">
                    <div class="calc-icon">⬡</div>
                    <div class="calc-title">Perimeter Calculator</div>
                    <div class="calc-desc">Calculate perimeter of polygons and shapes.</div>
                </a>
                <a href="triangle-calculator.php" class="calc-card slide-in-right" data-name="Triangle Calculator">
                    <div class="calc-icon">△</div>
                    <div class="calc-title">Triangle Calculator</div>
                    <div class="calc-desc">Solve triangles using sides, angles, and trigonometry.</div>
                </a>
                <a href="circle-calculator.php" class="calc-card slide-in-right" data-name="Circle Calculator">
                    <div class="calc-icon">⭕</div>
                    <div class="calc-title">Circle Calculator</div>
                    <div class="calc-desc">Calculate area, circumference, radius, and diameter.</div>
                </a>
                <a href="rectangle-calculator.php" class="calc-card slide-in-right" data-name="Rectangle Calculator">
                    <div class="calc-icon">▭</div>
                    <div class="calc-title">Rectangle Calculator</div>
                    <div class="calc-desc">Calculate area, perimeter, and diagonal of rectangles.</div>
                </a>
                <a href="square-calculator.php" class="calc-card slide-in-right" data-name="Square Calculator">
                    <div class="calc-icon">▢</div>
                    <div class="calc-title">Square Calculator</div>
                    <div class="calc-desc">Calculate area, perimeter, and diagonal of squares.</div>
                </a>
                <a href="pythagorean-theorem-calculator.php" class="calc-card slide-in-right" data-name="Pythagorean Theorem">
                    <div class="calc-icon">📐</div>
                    <div class="calc-title">Pythagorean Theorem</div>
                    <div class="calc-desc">Calculate right triangle sides using a² + b² = c².</div>
                </a>
                <a href="angle-calculator.php" class="calc-card slide-in-right" data-name="Angle Calculator">
                    <div class="calc-icon">∠</div>
                    <div class="calc-title">Angle Calculator</div>
                    <div class="calc-desc">Calculate angles in polygons and convert units.</div>
                </a>
                <a href="polygon-calculator.php" class="calc-card slide-in-right" data-name="Polygon Calculator">
                    <div class="calc-icon">⬡</div>
                    <div class="calc-title">Polygon Calculator</div>
                    <div class="calc-desc">Calculate properties of regular polygons.</div>
                </a>
            </div>
        </div>

        <!-- Advanced Math -->
        <div class="category fade-in" data-category="advanced">
            <div class="category-header">
                <span class="category-icon">∫</span>
                <h2 class="category-title">Calculus & Advanced</h2>
                <span class="category-count">4 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="matrix-calculator.php" class="calc-card slide-in-left" data-name="Matrix Calculator">
                    <div class="calc-icon">⊞</div>
                    <div class="calc-title">Matrix Calculator</div>
                    <div class="calc-desc">Perform matrix operations, determinants, and inverses.</div>
                </a>
                <a href="derivative-calculator.php" class="calc-card slide-in-left" data-name="Derivative Calculator">
                    <div class="calc-icon">d/dx</div>
                    <div class="calc-title">Derivative Calculator</div>
                    <div class="calc-desc">Calculate derivatives with step-by-step solutions.</div>
                </a>
                <a href="integral-calculator.php" class="calc-card slide-in-left" data-name="Integral Calculator">
                    <div class="calc-icon">∫</div>
                    <div class="calc-title">Integral Calculator</div>
                    <div class="calc-desc">Calculate definite and indefinite integrals.</div>
                </a>
                <a href="limit-calculator.php" class="calc-card slide-in-left" data-name="Limit Calculator">
                    <div class="calc-icon">lim</div>
                    <div class="calc-title">Limit Calculator</div>
                    <div class="calc-desc">Calculate limits of functions at specific points.</div>
                </a>
            </div>
        </div>

        <!-- Combinatorics -->
        <div class="category fade-in" data-category="combinatorics">
            <div class="category-header">
                <span class="category-icon">🎲</span>
                <h2 class="category-title">Combinatorics & Number Theory</h2>
                <span class="category-count">7 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="factorial-calculator.php" class="calc-card slide-in-right" data-name="Factorial Calculator">
                    <div class="calc-icon">n!</div>
                    <div class="calc-title">Factorial Calculator</div>
                    <div class="calc-desc">Calculate factorials and large number products.</div>
                </a>
                <a href="permutation-calculator.php" class="calc-card slide-in-right" data-name="Permutation Calculator">
                    <div class="calc-icon">ⁿPᵣ</div>
                    <div class="calc-title">Permutation Calculator</div>
                    <div class="calc-desc">Calculate permutations for ordered arrangements.</div>
                </a>
                <a href="combination-calculator.php" class="calc-card slide-in-right" data-name="Combination Calculator">
                    <div class="calc-icon">ⁿCᵣ</div>
                    <div class="calc-title">Combination Calculator</div>
                    <div class="calc-desc">Calculate combinations for unordered selections.</div>
                </a>
                <a href="sequence-calculator.php" class="calc-card slide-in-right" data-name="Sequence Calculator">
                    <div class="calc-icon">…</div>
                    <div class="calc-title">Sequence Calculator</div>
                    <div class="calc-desc">Find terms in arithmetic and geometric sequences.</div>
                </a>
                <a href="series-calculator.php" class="calc-card slide-in-right" data-name="Series Calculator">
                    <div class="calc-icon">∑</div>
                    <div class="calc-title">Series Calculator</div>
                    <div class="calc-desc">Calculate sum of series and convergence tests.</div>
                </a>
                <a href="prime-factorization-calculator.php" class="calc-card slide-in-right" data-name="Prime Factorization">
                    <div class="calc-icon">🔢</div>
                    <div class="calc-title">Prime Factorization</div>
                    <div class="calc-desc">Find prime factors of any number.</div>
                </a>
                <a href="gcd-lcm-calculator.php" class="calc-card slide-in-right" data-name="GCD LCM Calculator">
                    <div class="calc-icon">⊕</div>
                    <div class="calc-title">GCD & LCM Calculator</div>
                    <div class="calc-desc">Calculate greatest common divisor and least common multiple.</div>
                </a>
            </div>
        </div>

        <div class="no-results" id="noResults" style="display: none;">
            <div class="no-results-icon">🔍</div>
            <h3>No calculators found</h3>
            <p>Try a different search term or browse categories above</p>
        </div>
    </div>

    <footer class="fade-in">
        <p>🧮 Math Calculators | 42+ Free Tools</p>
        <p style="margin-top: 8px; font-size: 0.875rem;">Accurate mathematical calculations for students, teachers, and professionals</p>
    </footer>

    <script>
        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.addEventListener('DOMContentLoaded', () => {
            const animatedElements = document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right, .scale-in');
            animatedElements.forEach(el => observer.observe(el));
        });

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

        // Add loading animation
        document.querySelectorAll('.calc-card').forEach(card => {
            card.addEventListener('click', function(e) {
                this.style.opacity = '0.6';
            });
        });
    </script>
</body>
</html>