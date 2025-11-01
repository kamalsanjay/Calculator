<?php
/**
 * Construction Calculators Collection
 * File: construction/index.php
 * Description: Landing page for 18 construction and building material calculation tools
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Construction Calculators - 18 Free Tools | Building Materials & Cost Estimation</title>
    <meta name="description" content="Complete collection of construction calculators: concrete, roofing, flooring, paint, tile, brick, deck, fence, and more. Essential tools for contractors and DIY projects.">
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
        <h1>🏗️ Construction Calculators</h1>
        <p>Professional construction and material estimation tools for contractors, builders, and DIY projects. Calculate quantities, costs, and materials for any building project.</p>
    </header>

    <div class="container">
        <div class="breadcrumb fade-in">
            <a href="../index.php">🏠 Home</a>
            <span>›</span>
            <span>Construction Calculators</span>
        </div>

        <div class="stats fade-in">
            <div class="stat-card scale-in">
                <div class="stat-number">18</div>
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
            <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search construction calculators..." onkeyup="filterCalculators()">
        </div>

        <!-- Concrete & Masonry -->
        <div class="category fade-in" data-category="masonry">
            <div class="category-header">
                <span class="category-icon">🧱</span>
                <h2 class="category-title">Concrete & Masonry</h2>
                <span class="category-count">3 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="concrete-calculator.php" class="calc-card slide-in-left" data-name="Concrete Calculator">
                    <div class="calc-icon">🏗️</div>
                    <div class="calc-title">Concrete Calculator</div>
                    <div class="calc-desc">Calculate concrete volume, bags needed, and cost for slabs, footings, and columns.</div>
                    <span class="calc-badge">Popular</span>
                </a>
                <a href="brick-calculator.php" class="calc-card slide-in-left" data-name="Brick Calculator">
                    <div class="calc-icon">🧱</div>
                    <div class="calc-title">Brick Calculator</div>
                    <div class="calc-desc">Estimate bricks needed for walls, patios, and structures with mortar requirements.</div>
                </a>
                <a href="gravel-calculator.php" class="calc-card slide-in-left" data-name="Gravel Calculator">
                    <div class="calc-icon">🪨</div>
                    <div class="calc-title">Gravel Calculator</div>
                    <div class="calc-desc">Calculate gravel, stone, or aggregate for driveways, paths, and landscaping.</div>
                </a>
            </div>
        </div>

        <!-- Roofing & Exterior -->
        <div class="category fade-in" data-category="roofing">
            <div class="category-header">
                <span class="category-icon">🏠</span>
                <h2 class="category-title">Roofing & Exterior</h2>
                <span class="category-count">4 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="roofing-calculator.php" class="calc-card slide-in-right" data-name="Roofing Calculator">
                    <div class="calc-icon">🏠</div>
                    <div class="calc-title">Roofing Calculator</div>
                    <div class="calc-desc">Calculate shingles, underlayment, and materials for roof projects with pitch.</div>
                    <span class="calc-badge">Essential</span>
                </a>
                <a href="rafter-calculator.php" class="calc-card slide-in-right" data-name="Rafter Calculator">
                    <div class="calc-icon">📐</div>
                    <div class="calc-title">Rafter Calculator</div>
                    <div class="calc-desc">Calculate rafter length, angles, and cuts for roof framing with rise and run.</div>
                </a>
                <a href="fence-calculator.php" class="calc-card slide-in-right" data-name="Fence Calculator">
                    <div class="calc-icon">🚧</div>
                    <div class="calc-title">Fence Calculator</div>
                    <div class="calc-desc">Estimate posts, panels, rails, and materials for fence installation projects.</div>
                </a>
                <a href="deck-calculator.php" class="calc-card slide-in-right" data-name="Deck Calculator">
                    <div class="calc-icon">🏡</div>
                    <div class="calc-title">Deck Calculator</div>
                    <div class="calc-desc">Calculate decking boards, joists, posts, and fasteners for deck construction.</div>
                </a>
            </div>
        </div>

        <!-- Flooring & Interior -->
        <div class="category fade-in" data-category="flooring">
            <div class="category-header">
                <span class="category-icon">📦</span>
                <h2 class="category-title">Flooring & Interior</h2>
                <span class="category-count">7 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="flooring-calculator.php" class="calc-card slide-in-left" data-name="Flooring Calculator">
                    <div class="calc-icon">📦</div>
                    <div class="calc-title">Flooring Calculator</div>
                    <div class="calc-desc">Calculate hardwood, laminate, or vinyl flooring needed for any room size.</div>
                </a>
                <a href="tile-calculator.php" class="calc-card slide-in-left" data-name="Tile Calculator">
                    <div class="calc-icon">⬛</div>
                    <div class="calc-title">Tile Calculator</div>
                    <div class="calc-desc">Estimate tiles for floors, walls, backsplashes with grout and adhesive amounts.</div>
                </a>
                <a href="carpet-calculator.php" class="calc-card slide-in-left" data-name="Carpet Calculator">
                    <div class="calc-icon">🟫</div>
                    <div class="calc-title">Carpet Calculator</div>
                    <div class="calc-desc">Calculate carpet area, rolls needed, padding, and installation costs.</div>
                </a>
                <a href="drywall-calculator.php" class="calc-card slide-in-left" data-name="Drywall Calculator">
                    <div class="calc-icon">🔲</div>
                    <div class="calc-title">Drywall Calculator</div>
                    <div class="calc-desc">Calculate drywall sheets, joint compound, tape, and screws for walls.</div>
                </a>
                <a href="paint-calculator.php" class="calc-card slide-in-left" data-name="Paint Calculator">
                    <div class="calc-icon">🎨</div>
                    <div class="calc-title">Paint Calculator</div>
                    <div class="calc-desc">Calculate paint gallons for walls, ceilings, trim with coverage rates.</div>
                    <span class="calc-badge">Popular</span>
                </a>
                <a href="insulation-calculator.php" class="calc-card slide-in-left" data-name="Insulation Calculator">
                    <div class="calc-icon">🏠</div>
                    <div class="calc-title">Insulation Calculator</div>
                    <div class="calc-desc">Calculate insulation batts, rolls, or blown-in material for walls and attics.</div>
                </a>
                <a href="stair-calculator.php" class="calc-card slide-in-left" data-name="Stair Calculator">
                    <div class="calc-icon">🪜</div>
                    <div class="calc-title">Stair Calculator</div>
                    <div class="calc-desc">Calculate stair dimensions, rise, run, and stringers for safe construction.</div>
                </a>
            </div>
        </div>

        <!-- Landscaping & Outdoor -->
        <div class="category fade-in" data-category="landscaping">
            <div class="category-header">
                <span class="category-icon">🌳</span>
                <h2 class="category-title">Landscaping & Outdoor</h2>
                <span class="category-count">2 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="mulch-calculator.php" class="calc-card slide-in-right" data-name="Mulch Calculator">
                    <div class="calc-icon">🌳</div>
                    <div class="calc-title">Mulch Calculator</div>
                    <div class="calc-desc">Calculate mulch, wood chips, or bark needed for garden beds and landscaping.</div>
                </a>
                <a href="sod-calculator.php" class="calc-card slide-in-right" data-name="Sod Calculator">
                    <div class="calc-icon">🌱</div>
                    <div class="calc-title">Sod Calculator</div>
                    <div class="calc-desc">Calculate sod pallets or rolls needed for lawn installation with soil prep.</div>
                </a>
            </div>
        </div>

        <!-- Measurement & Estimation -->
        <div class="category fade-in" data-category="measurement">
            <div class="category-header">
                <span class="category-icon">📏</span>
                <h2 class="category-title">Measurement & Estimation</h2>
                <span class="category-count">2 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="square-footage-calculator.php" class="calc-card slide-in-left" data-name="Square Footage Calculator">
                    <div class="calc-icon">📏</div>
                    <div class="calc-title">Square Footage Calculator</div>
                    <div class="calc-desc">Calculate square footage for rectangular, triangular, and circular areas.</div>
                </a>
                <a href="board-feet-calculator.php" class="calc-card slide-in-left" data-name="Board Feet Calculator">
                    <div class="calc-icon">🪵</div>
                    <div class="calc-title">Board Feet Calculator</div>
                    <div class="calc-desc">Calculate board feet for lumber purchasing and pricing for woodworking.</div>
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
        <p>🏗️ Construction Calculators | 18 Free Tools</p>
        <p style="margin-top: 8px; font-size: 0.875rem;">Professional building materials and cost estimation</p>
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