<?php
/**
 * Automotive Calculators Collection
 * File: automotive/index.php
 * Description: Landing page for 11 automotive and vehicle calculation tools
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Automotive Calculators - 11 Free Tools | Fuel, Finance & Performance</title>
    <meta name="description" content="Complete collection of automotive calculators: gas mileage, fuel cost, car lease, car payment, tire size, 0-60, horsepower, and more. Essential tools for car owners and enthusiasts.">
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
        .category-title { font-size: 1.4rem; font-weight: 700; color: #764ba2; flex: 1; }
        .category-count { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }
        
        .calc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; }
        
        .calc-card { background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); padding: 18px; border-radius: 12px; border: 2px solid #e8e8e8; cursor: pointer; transition: all 0.3s; text-decoration: none; display: block; position: relative; overflow: hidden; }
        .calc-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); transition: width 0.3s; }
        .calc-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15); border-color: #667eea; }
        .calc-card:hover::before { width: 100%; opacity: 0.05; }
        
        .calc-icon { font-size: 2rem; margin-bottom: 10px; }
        .calc-title { font-size: 1rem; font-weight: 600; color: #333; margin-bottom: 6px; line-height: 1.3; }
        .calc-desc { font-size: 0.825rem; color: #666; line-height: 1.4; }
        .calc-badge { display: inline-block; background: rgba(102, 126, 234, 0.1); color: #764ba2; padding: 3px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; margin-top: 8px; text-transform: uppercase; }
        
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
        <h1>🚗 Automotive Calculators</h1>
        <p>Professional automotive calculation tools for fuel economy, financing, performance metrics, and vehicle maintenance. Essential for car owners, buyers, and enthusiasts.</p>
    </header>

    <div class="container">
        <div class="breadcrumb fade-in">
            <a href="../index.php">🏠 Home</a>
            <span>›</span>
            <span>Automotive Calculators</span>
        </div>

        <div class="stats fade-in">
            <div class="stat-card scale-in">
                <div class="stat-number">11</div>
                <div class="stat-label">Calculators</div>
            </div>
            <div class="stat-card scale-in">
                <div class="stat-number">100%</div>
                <div class="stat-label">Accurate</div>
            </div>
            <div class="stat-card scale-in">
                <div class="stat-number">Fast</div>
                <div class="stat-label">Results</div>
            </div>
            <div class="stat-card scale-in">
                <div class="stat-number">Free</div>
                <div class="stat-label">Always</div>
            </div>
        </div>

        <div class="search-box fade-in">
            <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search automotive calculators..." onkeyup="filterCalculators()">
        </div>

        <!-- Fuel & Economy -->
        <div class="category fade-in" data-category="fuel">
            <div class="category-header">
                <span class="category-icon">⛽</span>
                <h2 class="category-title">Fuel & Economy</h2>
                <span class="category-count">3 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="gas-mileage-calculator.php" class="calc-card slide-in-left" data-name="Gas Mileage Calculator">
                    <div class="calc-icon">⛽</div>
                    <div class="calc-title">Gas Mileage Calculator</div>
                    <div class="calc-desc">Calculate MPG (miles per gallon) and fuel efficiency for your vehicle trips.</div>
                    <span class="calc-badge">Popular</span>
                </a>
                <a href="fuel-cost-calculator.php" class="calc-card slide-in-left" data-name="Fuel Cost Calculator">
                    <div class="calc-icon">💰</div>
                    <div class="calc-title">Fuel Cost Calculator</div>
                    <div class="calc-desc">Calculate total fuel costs for trips based on distance, MPG, and gas prices.</div>
                </a>
                <a href="carbon-footprint-calculator.php" class="calc-card slide-in-left" data-name="Carbon Footprint Calculator">
                    <div class="calc-icon">🌱</div>
                    <div class="calc-title">Carbon Footprint Calculator</div>
                    <div class="calc-desc">Calculate CO2 emissions from your vehicle based on fuel consumption.</div>
                </a>
            </div>
        </div>

        <!-- Finance & Ownership -->
        <div class="category fade-in" data-category="finance">
            <div class="category-header">
                <span class="category-icon">💳</span>
                <h2 class="category-title">Finance & Ownership</h2>
                <span class="category-count">3 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="car-payment-calculator.php" class="calc-card slide-in-right" data-name="Car Payment Calculator">
                    <div class="calc-icon">💳</div>
                    <div class="calc-title">Car Payment Calculator</div>
                    <div class="calc-desc">Calculate monthly car loan payments with interest, down payment, and term.</div>
                    <span class="calc-badge">Essential</span>
                </a>
                <a href="car-lease-calculator.php" class="calc-card slide-in-right" data-name="Car Lease Calculator">
                    <div class="calc-icon">📋</div>
                    <div class="calc-title">Car Lease Calculator</div>
                    <div class="calc-desc">Calculate monthly lease payments, total costs, and end-of-lease options.</div>
                </a>
                <a href="car-depreciation-calculator.php" class="calc-card slide-in-right" data-name="Car Depreciation Calculator">
                    <div class="calc-icon">📉</div>
                    <div class="calc-title">Car Depreciation Calculator</div>
                    <div class="calc-desc">Calculate vehicle depreciation over time and estimate resale value.</div>
                </a>
            </div>
        </div>

        <!-- Performance & Specs -->
        <div class="category fade-in" data-category="performance">
            <div class="category-header">
                <span class="category-icon">🏎️</span>
                <h2 class="category-title">Performance & Specs</h2>
                <span class="category-count">5 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="0-60-calculator.php" class="calc-card slide-in-left" data-name="0-60 Calculator">
                    <div class="calc-icon">🏎️</div>
                    <div class="calc-title">0-60 Calculator</div>
                    <div class="calc-desc">Calculate 0-60 mph acceleration time based on horsepower and weight.</div>
                </a>
                <a href="quarter-mile-calculator.php" class="calc-card slide-in-left" data-name="Quarter Mile Calculator">
                    <div class="calc-icon">🏁</div>
                    <div class="calc-title">Quarter Mile Calculator</div>
                    <div class="calc-desc">Calculate quarter mile time and trap speed for drag racing performance.</div>
                </a>
                <a href="horsepower-calculator.php" class="calc-card slide-in-left" data-name="Horsepower Calculator">
                    <div class="calc-icon">⚙️</div>
                    <div class="calc-title">Horsepower Calculator</div>
                    <div class="calc-desc">Calculate engine horsepower from torque, RPM, and other metrics.</div>
                </a>
                <a href="gear-ratio-calculator.php" class="calc-card slide-in-left" data-name="Gear Ratio Calculator">
                    <div class="calc-icon">🔧</div>
                    <div class="calc-title">Gear Ratio Calculator</div>
                    <div class="calc-desc">Calculate gear ratios, final drive ratios, and transmission specifications.</div>
                </a>
                <a href="tire-size-calculator.php" class="calc-card slide-in-left" data-name="Tire Size Calculator">
                    <div class="calc-icon">⭕</div>
                    <div class="calc-title">Tire Size Calculator</div>
                    <div class="calc-desc">Compare tire sizes, calculate diameter, and determine speedometer error.</div>
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
        <p>🚗 Automotive Calculators | 11 Free Tools</p>
        <p style="margin-top: 8px; font-size: 0.875rem;">Professional automotive and vehicle calculations</p>
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