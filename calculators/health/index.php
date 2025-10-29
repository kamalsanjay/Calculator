<?php
/**
 * Health Calculators Hub - Main Index
 * File: index.php
 * Description: Landing page with all health and fitness calculators
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Calculators - BMI, BMR, TDEE, Calorie & Fitness Calculators</title>
    <meta name="description" content="Free health and fitness calculators. Calculate BMI, BMR, TDEE, body fat, calories burned, macros, protein, sleep cycles, heart rate zones, and more.">
    <meta name="keywords" content="health calculator, BMI calculator, BMR calculator, TDEE calculator, calorie calculator, fitness calculator">
    <link rel="stylesheet" href="assets/css/calculator.css">
    <style>
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
        }
        .hero h1 {
            font-size: 2.5em;
            margin: 0 0 15px 0;
        }
        .hero p {
            font-size: 1.2em;
            opacity: 0.9;
        }
        .calculator-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .calculator-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .calculator-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        .calculator-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }
        .calculator-card h3 {
            margin: 0 0 10px 0;
            color: #667eea;
            font-size: 1.3em;
        }
        .calculator-card p {
            margin: 0;
            color: #666;
            line-height: 1.6;
        }
        .category-header {
            text-align: center;
            margin: 40px 0 20px 0;
            color: #333;
            font-size: 1.8em;
        }
        .footer {
            background: #f5f5f5;
            padding: 30px 20px;
            text-align: center;
            color: #666;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="hero">
        <h1>🏥 Health & Fitness Calculators</h1>
        <p>Comprehensive tools for your health, fitness, and wellness journey</p>
    </div>

    <div class="container">
        <h2 class="category-header">💪 Body Composition</h2>
        <div class="calculator-grid">
            <a href="bmi-calculator.php" class="calculator-card">
                <div class="calculator-icon">📊</div>
                <h3>BMI Calculator</h3>
                <p>Calculate Body Mass Index and determine your weight category (underweight, normal, overweight, obese).</p>
            </a>

            <a href="body-fat-calculator.php" class="calculator-card">
                <div class="calculator-icon">📏</div>
                <h3>Body Fat Calculator</h3>
                <p>Estimate body fat percentage using multiple methods including Navy, Army, and skinfold measurements.</p>
            </a>

            <a href="ideal-weight-calculator.php" class="calculator-card">
                <div class="calculator-icon">⚖️</div>
                <h3>Ideal Weight Calculator</h3>
                <p>Find your ideal weight range based on multiple formulas (Devine, Robinson, Miller, Hamwi).</p>
            </a>

            <a href="lean-body-mass-calculator.php" class="calculator-card">
                <div class="calculator-icon">💪</div>
                <h3>Lean Body Mass Calculator</h3>
                <p>Calculate lean body mass (muscle, bone, organs) and track muscle gain progress.</p>
            </a>
        </div>

        <h2 class="category-header">🔥 Calorie & Metabolism</h2>
        <div class="calculator-grid">
            <a href="bmr-calculator.php" class="calculator-card">
                <div class="calculator-icon">🔥</div>
                <h3>BMR Calculator</h3>
                <p>Calculate Basal Metabolic Rate - calories your body burns at rest using multiple formulas.</p>
            </a>

            <a href="tdee-calculator.php" class="calculator-card">
                <div class="calculator-icon">⚡</div>
                <h3>TDEE Calculator</h3>
                <p>Calculate Total Daily Energy Expenditure and calorie needs for weight loss, maintenance, or gain.</p>
            </a>

            <a href="calorie-calculator.php" class="calculator-card">
                <div class="calculator-icon">🍽️</div>
                <h3>Calorie Calculator</h3>
                <p>Comprehensive calorie calculator with macro breakdown and meal planning guidance.</p>
            </a>

            <a href="macro-calculator.php" class="calculator-card">
                <div class="calculator-icon">🥗</div>
                <h3>Macro Calculator</h3>
                <p>Calculate optimal protein, carbs, and fat intake for your fitness goals and diet type.</p>
            </a>

            <a href="protein-calculator.php" class="calculator-card">
                <div class="calculator-icon">🥩</div>
                <h3>Protein Calculator</h3>
                <p>Calculate daily protein needs based on weight, activity level, and fitness goals.</p>
            </a>
        </div>

        <h2 class="category-header">🏃 Exercise & Activity</h2>
        <div class="calculator-grid">
            <a href="calories-burned-calculator.php" class="calculator-card">
                <div class="calculator-icon">🔥</div>
                <h3>Calories Burned Calculator</h3>
                <p>Calculate calories burned for 600+ activities including exercise, sports, and daily tasks.</p>
            </a>

            <a href="walking-calorie-calculator.php" class="calculator-card">
                <div class="calculator-icon">🚶</div>
                <h3>Walking Calorie Calculator</h3>
                <p>Calculate calories burned while walking based on distance, time, speed, and terrain.</p>
            </a>

            <a href="running-calculator.php" class="calculator-card">
                <div class="calculator-icon">🏃</div>
                <h3>Running Calculator</h3>
                <p>Calculate pace, race times, splits, and training zones for running and racing.</p>
            </a>

            <a href="target-heart-rate-calculator.php" class="calculator-card">
                <div class="calculator-icon">❤️</div>
                <h3>Heart Rate Calculator</h3>
                <p>Calculate target heart rate zones for optimal training across different intensities.</p>
            </a>

            <a href="one-rep-max-calculator.php" class="calculator-card">
                <div class="calculator-icon">🏋️</div>
                <h3>One Rep Max Calculator</h3>
                <p>Calculate maximum strength potential and create progressive training programs.</p>
            </a>
        </div>

        <h2 class="category-header">😴 Sleep & Recovery</h2>
        <div class="calculator-grid">
            <a href="sleep-time-calculator.php" class="calculator-card">
                <div class="calculator-icon">😴</div>
                <h3>Sleep Time Calculator</h3>
                <p>Calculate optimal bedtime and wake time based on 90-minute sleep cycles with timer.</p>
            </a>
        </div>

        <h2 class="category-header">💧 Hydration</h2>
        <div class="calculator-grid">
            <a href="water-intake-calculator.php" class="calculator-card">
                <div class="calculator-icon">💧</div>
                <h3>Water Intake Calculator</h3>
                <p>Calculate daily water needs based on weight, activity, climate, and exercise.</p>
            </a>
        </div>

        <h2 class="category-header">🎯 Body Measurements</h2>
        <div class="calculator-grid">
            <a href="waist-to-hip-ratio-calculator.php" class="calculator-card">
                <div class="calculator-icon">📐</div>
                <h3>Waist-to-Hip Ratio</h3>
                <p>Assess body fat distribution and health risks based on waist and hip measurements.</p>
            </a>

            <a href="body-type-calculator.php" class="calculator-card">
                <div class="calculator-icon">👤</div>
                <h3>Body Type Calculator</h3>
                <p>Determine your body type (ectomorph, mesomorph, endomorph) for personalized training.</p>
            </a>
        </div>

        <div style="margin: 60px 0; padding: 40px 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px; text-align: center;">
            <h2 style="margin: 0 0 20px 0; font-size: 2em;">🎯 Start Your Health Journey Today</h2>
            <p style="font-size: 1.1em; margin: 0 0 30px 0; opacity: 0.9;">Use our free calculators to track progress, set goals, and optimize your fitness routine. All tools are scientifically validated and easy to use.</p>
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="#" onclick="window.scrollTo(0,0); return false;" style="background: white; color: #667eea; padding: 15px 30px; border-radius: 5px; text-decoration: none; font-weight: bold;">Explore Calculators</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <h3 style="margin: 0 0 15px 0; color: #333;">🏥 Health & Fitness Calculators</h3>
        <p style="margin: 0 0 10px 0;">Comprehensive tools for health, fitness, nutrition, and wellness</p>
        <p style="margin: 0; font-size: 0.9em;">
            <strong>Calculators:</strong> BMI | BMR | TDEE | Body Fat | Calories | Macros | Protein | Sleep | Heart Rate | Running | Walking | Water Intake | One Rep Max | Ideal Weight | Lean Body Mass | Waist-to-Hip Ratio
        </p>
        <p style="margin: 15px 0 0 0; font-size: 0.85em; opacity: 0.7;">
            All calculators provide estimates. Consult healthcare professionals for personalized advice.
        </p>
        <p style="margin: 10px 0 0 0; font-size: 0.85em;">
            © 2025 Health Calculators Hub. All rights reserved.
        </p>
    </div>

    <script>
        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.calculator-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s, transform 0.5s';
            observer.observe(card);
        });
    </script>
</body>
</html>