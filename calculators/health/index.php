<?php
/**
 * Health & Fitness Calculators
 * File: health/index.php
 * Description: Landing page with smooth scroll animations
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Health & Fitness Calculators - 40+ Medical & Wellness Tools</title>
    <meta name="description" content="Complete collection of health, fitness, pregnancy, and medical calculators. Calculate BMI, BMR, calories, body fat, and more.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); min-height: 100vh; padding: 16px; overflow-x: hidden; }
        
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
        header p { font-size: 1rem; opacity: 0.95; line-height: 1.6; max-width: 600px; margin: 0 auto; }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .breadcrumb { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; }
        .breadcrumb a { color: white; text-decoration: none; font-weight: 500; transition: opacity 0.3s; }
        .breadcrumb a:hover { opacity: 0.8; }
        .breadcrumb span { color: rgba(255,255,255,0.7); margin: 0 8px; }
        
        .search-box { background: white; padding: 16px; border-radius: 12px; margin-bottom: 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.1); }
        .search-input { width: 100%; padding: 14px 20px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; }
        .search-input:focus { border-color: #11998e; box-shadow: 0 0 0 3px rgba(17, 153, 142, 0.1); }
        
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; margin-bottom: 24px; }
        .stat-card { background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); padding: 20px; border-radius: 12px; text-align: center; color: white; border: 2px solid rgba(255,255,255,0.3); }
        .stat-number { font-size: 2.5rem; font-weight: bold; margin-bottom: 4px; text-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stat-label { font-size: 0.9rem; opacity: 0.95; font-weight: 500; }
        
        .category { background: white; padding: 24px; border-radius: 16px; margin-bottom: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .category-header { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 3px solid #f0f0f0; }
        .category-icon { font-size: 2rem; }
        .category-title { font-size: 1.4rem; font-weight: 700; color: #11998e; }
        .category-count { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }
        
        .calc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; }
        
        .calc-card { background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); padding: 20px; border-radius: 12px; border: 2px solid #e8e8e8; cursor: pointer; transition: all 0.3s; text-decoration: none; display: block; position: relative; overflow: hidden; }
        .calc-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); transition: width 0.3s; }
        .calc-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(17, 153, 142, 0.15); border-color: #11998e; }
        .calc-card:hover::before { width: 100%; opacity: 0.05; }
        
        .calc-icon { font-size: 2.2rem; margin-bottom: 12px; }
        .calc-title { font-size: 1.05rem; font-weight: 600; color: #333; margin-bottom: 8px; line-height: 1.3; }
        .calc-desc { font-size: 0.875rem; color: #666; line-height: 1.5; }
        .calc-badge { display: inline-block; background: rgba(17, 153, 142, 0.1); color: #11998e; padding: 3px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; margin-top: 8px; text-transform: uppercase; }
        
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
        <h1>💚 Health & Fitness Calculators</h1>
        <p>Comprehensive collection of 40+ health, fitness, pregnancy, and medical calculators for your wellness journey</p>
    </header>

    <div class="container">
        <div class="breadcrumb fade-in">
            <a href="../index.php">🏠 Home</a>
            <span>›</span>
            <span>Health & Fitness</span>
        </div>

        <div class="stats fade-in">
            <div class="stat-card scale-in">
                <div class="stat-number">40+</div>
                <div class="stat-label">Health Tools</div>
            </div>
            <div class="stat-card scale-in">
                <div class="stat-number">5</div>
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
            <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search health calculators..." onkeyup="filterCalculators()">
        </div>

        <!-- Body Composition & Weight -->
        <div class="category fade-in" data-category="body">
            <div class="category-header">
                <span class="category-icon">⚖️</span>
                <h2 class="category-title">Body Composition & Weight</h2>
                <span class="category-count">12 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="bmi-calculator.php" class="calc-card slide-in-left" data-name="BMI Calculator">
                    <div class="calc-icon">📊</div>
                    <div class="calc-title">BMI Calculator</div>
                    <div class="calc-desc">Calculate Body Mass Index and health category based on height and weight.</div>
                    <span class="calc-badge">Popular</span>
                </a>
                <a href="bmr-calculator.php" class="calc-card slide-in-left" data-name="BMR Calculator">
                    <div class="calc-icon">🔥</div>
                    <div class="calc-title">BMR Calculator</div>
                    <div class="calc-desc">Calculate Basal Metabolic Rate - calories burned at rest.</div>
                </a>
                <a href="body-fat-calculator.php" class="calc-card slide-in-left" data-name="Body Fat Calculator">
                    <div class="calc-icon">📏</div>
                    <div class="calc-title">Body Fat Calculator</div>
                    <div class="calc-desc">Estimate body fat percentage using multiple methods.</div>
                </a>
                <a href="ideal-weight-calculator.php" class="calc-card slide-in-left" data-name="Ideal Weight">
                    <div class="calc-icon">🎯</div>
                    <div class="calc-title">Ideal Weight Calculator</div>
                    <div class="calc-desc">Find your ideal body weight range based on height and frame.</div>
                </a>
                <a href="lean-body-mass-calculator.php" class="calc-card slide-in-left" data-name="Lean Body Mass">
                    <div class="calc-icon">💪</div>
                    <div class="calc-title">Lean Body Mass</div>
                    <div class="calc-desc">Calculate lean muscle mass excluding body fat.</div>
                </a>
                <a href="body-type-calculator.php" class="calc-card slide-in-left" data-name="Body Type">
                    <div class="calc-icon">👤</div>
                    <div class="calc-title">Body Type Calculator</div>
                    <div class="calc-desc">Determine your body type: ectomorph, mesomorph, or endomorph.</div>
                </a>
                <a href="body-surface-area-calculator.php" class="calc-card slide-in-left" data-name="Body Surface Area">
                    <div class="calc-icon">📐</div>
                    <div class="calc-title">Body Surface Area</div>
                    <div class="calc-desc">Calculate BSA for medical dosing and health assessments.</div>
                </a>
                <a href="army-body-fat-calculator.php" class="calc-card slide-in-left" data-name="Army Body Fat">
                    <div class="calc-icon">🪖</div>
                    <div class="calc-title">Army Body Fat</div>
                    <div class="calc-desc">Calculate body fat using US Army standards and methods.</div>
                </a>
                <a href="navy-body-fat-calculator.php" class="calc-card slide-in-left" data-name="Navy Body Fat">
                    <div class="calc-icon">⚓</div>
                    <div class="calc-title">Navy Body Fat</div>
                    <div class="calc-desc">Calculate body fat using US Navy circumference method.</div>
                </a>
                <a href="healthy-weight-calculator.php" class="calc-card slide-in-left" data-name="Healthy Weight">
                    <div class="calc-icon">✅</div>
                    <div class="calc-title">Healthy Weight Range</div>
                    <div class="calc-desc">Find your healthy weight range based on BMI standards.</div>
                </a>
                <a href="bmi-children-calculator.php" class="calc-card slide-in-left" data-name="BMI for Children">
                    <div class="calc-icon">👶</div>
                    <div class="calc-title">BMI for Children</div>
                    <div class="calc-desc">Calculate BMI percentiles for children and teens.</div>
                </a>
            </div>
        </div>

        <!-- Calories & Nutrition -->
        <div class="category fade-in" data-category="nutrition">
            <div class="category-header">
                <span class="category-icon">🍎</span>
                <h2 class="category-title">Calories & Nutrition</h2>
                <span class="category-count">9 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="calorie-calculator.php" class="calc-card slide-in-right" data-name="Calorie Calculator">
                    <div class="calc-icon">🔢</div>
                    <div class="calc-title">Calorie Calculator</div>
                    <div class="calc-desc">Calculate daily calorie needs for weight goals.</div>
                    <span class="calc-badge">Essential</span>
                </a>
                <a href="calories-burned-calculator.php" class="calc-card slide-in-right" data-name="Calories Burned">
                    <div class="calc-icon">🏃</div>
                    <div class="calc-title">Calories Burned</div>
                    <div class="calc-desc">Calculate calories burned during various activities.</div>
                </a>
                <a href="tdee-calculator.php" class="calc-card slide-in-right" data-name="TDEE Calculator">
                    <div class="calc-icon">⚡</div>
                    <div class="calc-title">TDEE Calculator</div>
                    <div class="calc-desc">Total Daily Energy Expenditure including activity levels.</div>
                </a>
                <a href="macro-calculator.php" class="calc-card slide-in-right" data-name="Macro Calculator">
                    <div class="calc-icon">🥑</div>
                    <div class="calc-title">Macro Calculator</div>
                    <div class="calc-desc">Calculate protein, carbs, and fat macronutrient needs.</div>
                </a>
                <a href="protein-calculator.php" class="calc-card slide-in-right" data-name="Protein Calculator">
                    <div class="calc-icon">🥩</div>
                    <div class="calc-title">Protein Calculator</div>
                    <div class="calc-desc">Calculate daily protein requirements for your goals.</div>
                </a>
                <a href="carbohydrate-calculator.php" class="calc-card slide-in-right" data-name="Carbohydrate">
                    <div class="calc-icon">🍞</div>
                    <div class="calc-title">Carbohydrate Calculator</div>
                    <div class="calc-desc">Determine optimal carb intake for energy and performance.</div>
                </a>
                <a href="fat-intake-calculator.php" class="calc-card slide-in-right" data-name="Fat Intake">
                    <div class="calc-icon">🧈</div>
                    <div class="calc-title">Fat Intake Calculator</div>
                    <div class="calc-desc">Calculate healthy fat intake for hormonal balance.</div>
                </a>
                <a href="water-intake-calculator.php" class="calc-card slide-in-right" data-name="Water Intake">
                    <div class="calc-icon">💧</div>
                    <div class="calc-title">Water Intake</div>
                    <div class="calc-desc">Calculate daily water needs based on weight and activity.</div>
                </a>
            </div>
        </div>

        <!-- Fitness & Exercise -->
        <div class="category fade-in" data-category="fitness">
            <div class="category-header">
                <span class="category-icon">🏋️</span>
                <h2 class="category-title">Fitness & Exercise</h2>
                <span class="category-count">6 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="target-heart-rate-calculator.php" class="calc-card slide-in-left" data-name="Target Heart Rate">
                    <div class="calc-icon">❤️</div>
                    <div class="calc-title">Target Heart Rate</div>
                    <div class="calc-desc">Calculate heart rate zones for optimal cardio training.</div>
                </a>
                <a href="one-rep-max-calculator.php" class="calc-card slide-in-left" data-name="One Rep Max">
                    <div class="calc-icon">🏋️‍♂️</div>
                    <div class="calc-title">One Rep Max (1RM)</div>
                    <div class="calc-desc">Calculate maximum lift capacity for strength training.</div>
                </a>
                <a href="pace-calculator.php" class="calc-card slide-in-left" data-name="Pace Calculator">
                    <div class="calc-icon">⏱️</div>
                    <div class="calc-title">Pace Calculator</div>
                    <div class="calc-desc">Calculate running, walking, or cycling pace and splits.</div>
                </a>
                <a href="walking-calorie-calculator.php" class="calc-card slide-in-left" data-name="Walking Calorie">
                    <div class="calc-icon">🚶</div>
                    <div class="calc-title">Walking Calorie</div>
                    <div class="calc-desc">Calculate calories burned while walking at various speeds.</div>
                </a>
                <a href="running-calculator.php" class="calc-card slide-in-left" data-name="Running Calculator">
                    <div class="calc-icon">🏃‍♀️</div>
                    <div class="calc-title">Running Calculator</div>
                    <div class="calc-desc">Calculate pace, time, distance, and calories for running.</div>
                </a>
                <a href="cycling-calculator.php" class="calc-card slide-in-left" data-name="Cycling Calculator">
                    <div class="calc-icon">🚴</div>
                    <div class="calc-title">Cycling Calculator</div>
                    <div class="calc-desc">Calculate cycling metrics, power, and calories burned.</div>
                </a>
            </div>
        </div>

        <!-- Pregnancy & Fertility -->
        <div class="category fade-in" data-category="pregnancy">
            <div class="category-header">
                <span class="category-icon">🤰</span>
                <h2 class="category-title">Pregnancy & Fertility</h2>
                <span class="category-count">9 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="pregnancy-calculator.php" class="calc-card slide-in-right" data-name="Pregnancy Calculator">
                    <div class="calc-icon">📅</div>
                    <div class="calc-title">Pregnancy Calculator</div>
                    <div class="calc-desc">Calculate pregnancy timeline, trimester dates, and milestones.</div>
                </a>
                <a href="due-date-calculator.php" class="calc-card slide-in-right" data-name="Due Date">
                    <div class="calc-icon">🍼</div>
                    <div class="calc-title">Due Date Calculator</div>
                    <div class="calc-desc">Calculate estimated delivery date based on conception or LMP.</div>
                </a>
                <a href="ovulation-calculator.php" class="calc-card slide-in-right" data-name="Ovulation">
                    <div class="calc-icon">🥚</div>
                    <div class="calc-title">Ovulation Calculator</div>
                    <div class="calc-desc">Predict fertile window and ovulation dates.</div>
                </a>
                <a href="conception-calculator.php" class="calc-card slide-in-right" data-name="Conception">
                    <div class="calc-icon">💕</div>
                    <div class="calc-title">Conception Calculator</div>
                    <div class="calc-desc">Calculate conception date and fertility window.</div>
                </a>
                <a href="pregnancy-weight-gain-calculator.php" class="calc-card slide-in-right" data-name="Pregnancy Weight Gain">
                    <div class="calc-icon">📈</div>
                    <div class="calc-title">Pregnancy Weight Gain</div>
                    <div class="calc-desc">Calculate healthy weight gain during pregnancy by trimester.</div>
                </a>
                <a href="period-calculator.php" class="calc-card slide-in-right" data-name="Period Calculator">
                    <div class="calc-icon">📆</div>
                    <div class="calc-title">Period Calculator</div>
                    <div class="calc-desc">Track menstrual cycle and predict next period dates.</div>
                </a>
                <a href="fertility-calculator.php" class="calc-card slide-in-right" data-name="Fertility">
                    <div class="calc-icon">🌸</div>
                    <div class="calc-title">Fertility Calculator</div>
                    <div class="calc-desc">Calculate fertile days and best conception timing.</div>
                </a>
                <a href="baby-gender-calculator.php" class="calc-card slide-in-right" data-name="Baby Gender">
                    <div class="calc-icon">👶</div>
                    <div class="calc-title">Baby Gender Predictor</div>
                    <div class="calc-desc">Fun predictor based on various traditional methods.</div>
                </a>
                <a href="baby-growth-calculator.php" class="calc-card slide-in-right" data-name="Baby Growth">
                    <div class="calc-icon">📊</div>
                    <div class="calc-title">Baby Growth Calculator</div>
                    <div class="calc-desc">Track fetal development and baby growth percentiles.</div>
                </a>
            </div>
        </div>

        <!-- Medical & Health -->
        <div class="category fade-in" data-category="medical">
            <div class="category-header">
                <span class="category-icon">🏥</span>
                <h2 class="category-title">Medical & Health Tests</h2>
                <span class="category-count">8 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="gfr-calculator.php" class="calc-card slide-in-left" data-name="GFR Calculator">
                    <div class="calc-icon">🫘</div>
                    <div class="calc-title">GFR Calculator</div>
                    <div class="calc-desc">Calculate Glomerular Filtration Rate for kidney function.</div>
                </a>
                <a href="bac-calculator.php" class="calc-card slide-in-left" data-name="BAC Calculator">
                    <div class="calc-icon">🍺</div>
                    <div class="calc-title">BAC Calculator</div>
                    <div class="calc-desc">Calculate Blood Alcohol Concentration and impairment level.</div>
                </a>
                <a href="blood-pressure-calculator.php" class="calc-card slide-in-left" data-name="Blood Pressure">
                    <div class="calc-icon">🩺</div>
                    <div class="calc-title">Blood Pressure</div>
                    <div class="calc-desc">Analyze blood pressure readings and health categories.</div>
                </a>
                <a href="blood-sugar-calculator.php" class="calc-card slide-in-left" data-name="Blood Sugar">
                    <div class="calc-icon">🩸</div>
                    <div class="calc-title">Blood Sugar Calculator</div>
                    <div class="calc-desc">Convert and analyze blood glucose levels (mg/dL ↔ mmol/L).</div>
                </a>
                <a href="cholesterol-calculator.php" class="calc-card slide-in-left" data-name="Cholesterol">
                    <div class="calc-icon">💊</div>
                    <div class="calc-title">Cholesterol Calculator</div>
                    <div class="calc-desc">Calculate cholesterol ratios and cardiovascular risk.</div>
                </a>
                <a href="dosage-calculator.php" class="calc-card slide-in-left" data-name="Dosage Calculator">
                    <div class="calc-icon">💉</div>
                    <div class="calc-title">Dosage Calculator</div>
                    <div class="calc-desc">Calculate medication dosages based on weight and age.</div>
                </a>
                <a href="iv-drip-rate-calculator.php" class="calc-card slide-in-left" data-name="IV Drip Rate">
                    <div class="calc-icon">🩹</div>
                    <div class="calc-title">IV Drip Rate</div>
                    <div class="calc-desc">Calculate intravenous drip rates and flow rates.</div>
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
        <p>💚 Health & Fitness Calculators | 40+ Free Tools</p>
        <p style="margin-top: 8px; font-size: 0.875rem;">Medical calculators are for informational purposes. Consult healthcare professionals for medical advice.</p>
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