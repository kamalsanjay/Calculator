<?php
/**
 * Conversion Calculators Collection
 * File: conversion/index.php
 * Description: Landing page for 40+ unit conversion calculators
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Conversion Calculators - 40+ Unit Converter Tools</title>
    <meta name="description" content="Complete collection of unit converters: length, weight, temperature, volume, area, speed, data, energy, pressure, and time conversions.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); min-height: 100vh; padding: 16px; overflow-x: hidden; }
        
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
        .search-input:focus { border-color: #3498db; box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1); }
        
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; margin-bottom: 24px; }
        .stat-card { background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); padding: 20px; border-radius: 12px; text-align: center; color: white; border: 2px solid rgba(255,255,255,0.3); }
        .stat-number { font-size: 2.5rem; font-weight: bold; margin-bottom: 4px; text-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stat-label { font-size: 0.9rem; opacity: 0.95; font-weight: 500; }
        
        .category { background: white; padding: 24px; border-radius: 16px; margin-bottom: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .category-header { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 3px solid #f0f0f0; flex-wrap: wrap; }
        .category-icon { font-size: 2rem; }
        .category-title { font-size: 1.4rem; font-weight: 700; color: #2980b9; flex: 1; }
        .category-count { background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }
        
        .calc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; }
        
        .calc-card { background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); padding: 18px; border-radius: 12px; border: 2px solid #e8e8e8; cursor: pointer; transition: all 0.3s; text-decoration: none; display: block; position: relative; overflow: hidden; }
        .calc-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); transition: width 0.3s; }
        .calc-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(52, 152, 219, 0.15); border-color: #3498db; }
        .calc-card:hover::before { width: 100%; opacity: 0.05; }
        
        .calc-icon { font-size: 2rem; margin-bottom: 10px; }
        .calc-title { font-size: 1rem; font-weight: 600; color: #333; margin-bottom: 6px; line-height: 1.3; }
        .calc-desc { font-size: 0.825rem; color: #666; line-height: 1.4; }
        .calc-badge { display: inline-block; background: rgba(52, 152, 219, 0.1); color: #2980b9; padding: 3px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; margin-top: 8px; text-transform: uppercase; }
        
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
        <h1>🔄 Conversion Calculators</h1>
        <p>Comprehensive collection of 40+ unit converters for length, weight, temperature, volume, speed, data, and more</p>
    </header>

    <div class="container">
        <div class="breadcrumb fade-in">
            <a href="../index.php">🏠 Home</a>
            <span>›</span>
            <span>Conversion Calculators</span>
        </div>

        <div class="stats fade-in">
            <div class="stat-card scale-in">
                <div class="stat-number">40+</div>
                <div class="stat-label">Converters</div>
            </div>
            <div class="stat-card scale-in">
                <div class="stat-number">10</div>
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
            <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search unit converters..." onkeyup="filterCalculators()">
        </div>

        <!-- Length & Distance -->
        <div class="category fade-in" data-category="length">
            <div class="category-header">
                <span class="category-icon">📏</span>
                <h2 class="category-title">Length & Distance</h2>
                <span class="category-count">6 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="length-converter.php" class="calc-card slide-in-left" data-name="Length Converter">
                    <div class="calc-icon">📐</div>
                    <div class="calc-title">Length Converter</div>
                    <div class="calc-desc">Convert between mm, cm, m, km, inch, feet, yard, mile.</div>
                    <span class="calc-badge">Popular</span>
                </a>
                <a href="distance-converter.php" class="calc-card slide-in-left" data-name="Distance Converter">
                    <div class="calc-icon">🗺️</div>
                    <div class="calc-title">Distance Converter</div>
                    <div class="calc-desc">Convert distances between metric and imperial units.</div>
                </a>
                <a href="height-converter.php" class="calc-card slide-in-left" data-name="Height Converter">
                    <div class="calc-icon">📊</div>
                    <div class="calc-title">Height Converter</div>
                    <div class="calc-desc">Convert height between feet/inches and centimeters.</div>
                </a>
                <a href="inch-to-cm-converter.php" class="calc-card slide-in-left" data-name="Inch to CM">
                    <div class="calc-icon">↔️</div>
                    <div class="calc-title">Inch to CM Converter</div>
                    <div class="calc-desc">Quick inch to centimeter conversion calculator.</div>
                </a>
                <a href="feet-to-meter-converter.php" class="calc-card slide-in-left" data-name="Feet to Meter">
                    <div class="calc-icon">🦶</div>
                    <div class="calc-title">Feet to Meter</div>
                    <div class="calc-desc">Convert feet and inches to meters and centimeters.</div>
                </a>
                <a href="mile-to-km-converter.php" class="calc-card slide-in-left" data-name="Mile to KM">
                    <div class="calc-icon">🛣️</div>
                    <div class="calc-title">Mile to KM Converter</div>
                    <div class="calc-desc">Convert miles to kilometers and vice versa.</div>
                </a>
            </div>
        </div>

        <!-- Weight & Mass -->
        <div class="category fade-in" data-category="weight">
            <div class="category-header">
                <span class="category-icon">⚖️</span>
                <h2 class="category-title">Weight & Mass</h2>
                <span class="category-count">4 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="weight-converter.php" class="calc-card slide-in-right" data-name="Weight Converter">
                    <div class="calc-icon">🏋️</div>
                    <div class="calc-title">Weight Converter</div>
                    <div class="calc-desc">Convert between kg, g, lbs, oz, ton, and more.</div>
                    <span class="calc-badge">Essential</span>
                </a>
                <a href="kg-to-lbs-converter.php" class="calc-card slide-in-right" data-name="Kg to Lbs">
                    <div class="calc-icon">⚖️</div>
                    <div class="calc-title">Kg to Lbs Converter</div>
                    <div class="calc-desc">Convert kilograms to pounds quickly and accurately.</div>
                </a>
                <a href="pounds-to-kg-converter.php" class="calc-card slide-in-right" data-name="Pounds to Kg">
                    <div class="calc-icon">💪</div>
                    <div class="calc-title">Pounds to Kg</div>
                    <div class="calc-desc">Convert pounds to kilograms with precision.</div>
                </a>
                <a href="grams-to-ounces-converter.php" class="calc-card slide-in-right" data-name="Grams to Ounces">
                    <div class="calc-icon">🔬</div>
                    <div class="calc-title">Grams to Ounces</div>
                    <div class="calc-desc">Convert grams to ounces for cooking and science.</div>
                </a>
            </div>
        </div>

        <!-- Temperature -->
        <div class="category fade-in" data-category="temperature">
            <div class="category-header">
                <span class="category-icon">🌡️</span>
                <h2 class="category-title">Temperature</h2>
                <span class="category-count">4 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="temperature-converter.php" class="calc-card slide-in-left" data-name="Temperature Converter">
                    <div class="calc-icon">🌡️</div>
                    <div class="calc-title">Temperature Converter</div>
                    <div class="calc-desc">Convert between Celsius, Fahrenheit, and Kelvin.</div>
                </a>
                <a href="celsius-to-fahrenheit.php" class="calc-card slide-in-left" data-name="Celsius to Fahrenheit">
                    <div class="calc-icon">🔥</div>
                    <div class="calc-title">Celsius to Fahrenheit</div>
                    <div class="calc-desc">Quick °C to °F conversion with formula.</div>
                </a>
                <a href="fahrenheit-to-celsius.php" class="calc-card slide-in-left" data-name="Fahrenheit to Celsius">
                    <div class="calc-icon">❄️</div>
                    <div class="calc-title">Fahrenheit to Celsius</div>
                    <div class="calc-desc">Convert °F to °C instantly with steps.</div>
                </a>
                <a href="kelvin-converter.php" class="calc-card slide-in-left" data-name="Kelvin Converter">
                    <div class="calc-icon">🔬</div>
                    <div class="calc-title">Kelvin Converter</div>
                    <div class="calc-desc">Scientific temperature conversion to/from Kelvin.</div>
                </a>
            </div>
        </div>

        <!-- Volume -->
        <div class="category fade-in" data-category="volume">
            <div class="category-header">
                <span class="category-icon">🧪</span>
                <h2 class="category-title">Volume & Capacity</h2>
                <span class="category-count">5 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="volume-converter.php" class="calc-card slide-in-right" data-name="Volume Converter">
                    <div class="calc-icon">📦</div>
                    <div class="calc-title">Volume Converter</div>
                    <div class="calc-desc">Convert ml, L, gallon, cup, pint, quart, and more.</div>
                </a>
                <a href="gallons-to-liters.php" class="calc-card slide-in-right" data-name="Gallons to Liters">
                    <div class="calc-icon">⛽</div>
                    <div class="calc-title">Gallons to Liters</div>
                    <div class="calc-desc">Convert US/UK gallons to liters instantly.</div>
                </a>
                <a href="liters-to-gallons.php" class="calc-card slide-in-right" data-name="Liters to Gallons">
                    <div class="calc-icon">🚰</div>
                    <div class="calc-title">Liters to Gallons</div>
                    <div class="calc-desc">Convert liters to gallons for fuel and liquids.</div>
                </a>
                <a href="cup-to-ml-converter.php" class="calc-card slide-in-right" data-name="Cup to ML">
                    <div class="calc-icon">☕</div>
                    <div class="calc-title">Cup to ML Converter</div>
                    <div class="calc-desc">Convert cooking cups to milliliters accurately.</div>
                </a>
                <a href="tablespoon-converter.php" class="calc-card slide-in-right" data-name="Tablespoon Converter">
                    <div class="calc-icon">🥄</div>
                    <div class="calc-title">Tablespoon Converter</div>
                    <div class="calc-desc">Convert tbsp, tsp, ml for cooking recipes.</div>
                </a>
            </div>
        </div>

        <!-- Area -->
        <div class="category fade-in" data-category="area">
            <div class="category-header">
                <span class="category-icon">◼️</span>
                <h2 class="category-title">Area & Land</h2>
                <span class="category-count">4 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="area-converter.php" class="calc-card slide-in-left" data-name="Area Converter">
                    <div class="calc-icon">🗺️</div>
                    <div class="calc-title">Area Converter</div>
                    <div class="calc-desc">Convert sq ft, sq m, acre, hectare, and more.</div>
                </a>
                <a href="square-feet-to-square-meter.php" class="calc-card slide-in-left" data-name="Sq Ft to Sq M">
                    <div class="calc-icon">📐</div>
                    <div class="calc-title">Sq Ft to Sq M</div>
                    <div class="calc-desc">Convert square feet to square meters for real estate.</div>
                </a>
                <a href="acre-to-square-feet.php" class="calc-card slide-in-left" data-name="Acre to Sq Ft">
                    <div class="calc-icon">🌾</div>
                    <div class="calc-title">Acre to Square Feet</div>
                    <div class="calc-desc">Convert acres to square feet for land measurement.</div>
                </a>
                <a href="hectare-converter.php" class="calc-card slide-in-left" data-name="Hectare Converter">
                    <div class="calc-icon">🏞️</div>
                    <div class="calc-title">Hectare Converter</div>
                    <div class="calc-desc">Convert hectares to acres, sq m, and sq km.</div>
                </a>
            </div>
        </div>

        <!-- Speed -->
        <div class="category fade-in" data-category="speed">
            <div class="category-header">
                <span class="category-icon">🚀</span>
                <h2 class="category-title">Speed & Velocity</h2>
                <span class="category-count">4 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="speed-converter.php" class="calc-card slide-in-right" data-name="Speed Converter">
                    <div class="calc-icon">⚡</div>
                    <div class="calc-title">Speed Converter</div>
                    <div class="calc-desc">Convert mph, kph, m/s, knots, and more.</div>
                </a>
                <a href="mph-to-kph.php" class="calc-card slide-in-right" data-name="MPH to KPH">
                    <div class="calc-icon">🚗</div>
                    <div class="calc-title">MPH to KPH Converter</div>
                    <div class="calc-desc">Convert miles per hour to kilometers per hour.</div>
                </a>
                <a href="kph-to-mph.php" class="calc-card slide-in-right" data-name="KPH to MPH">
                    <div class="calc-icon">🏎️</div>
                    <div class="calc-title">KPH to MPH Converter</div>
                    <div class="calc-desc">Convert km/h to mph for speedometer readings.</div>
                </a>
                <a href="knots-converter.php" class="calc-card slide-in-right" data-name="Knots Converter">
                    <div class="calc-icon">⛵</div>
                    <div class="calc-title">Knots Converter</div>
                    <div class="calc-desc">Convert nautical speed knots to mph and km/h.</div>
                </a>
            </div>
        </div>

        <!-- Data Storage -->
        <div class="category fade-in" data-category="data">
            <div class="category-header">
                <span class="category-icon">💾</span>
                <h2 class="category-title">Data Storage</h2>
                <span class="category-count">4 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="data-storage-converter.php" class="calc-card slide-in-left" data-name="Data Storage Converter">
                    <div class="calc-icon">💽</div>
                    <div class="calc-title">Data Storage Converter</div>
                    <div class="calc-desc">Convert bytes, KB, MB, GB, TB, and PB.</div>
                </a>
                <a href="mb-to-gb-converter.php" class="calc-card slide-in-left" data-name="MB to GB">
                    <div class="calc-icon">📀</div>
                    <div class="calc-title">MB to GB Converter</div>
                    <div class="calc-desc">Convert megabytes to gigabytes for storage.</div>
                </a>
                <a href="gb-to-tb-converter.php" class="calc-card slide-in-left" data-name="GB to TB">
                    <div class="calc-icon">🗄️</div>
                    <div class="calc-title">GB to TB Converter</div>
                    <div class="calc-desc">Convert gigabytes to terabytes for large files.</div>
                </a>
                <a href="bit-byte-converter.php" class="calc-card slide-in-left" data-name="Bit Byte Converter">
                    <div class="calc-icon">⚙️</div>
                    <div class="calc-title">Bit Byte Converter</div>
                    <div class="calc-desc">Convert bits to bytes and vice versa.</div>
                </a>
            </div>
        </div>

        <!-- Energy & Power -->
        <div class="category fade-in" data-category="energy">
            <div class="category-header">
                <span class="category-icon">⚡</span>
                <h2 class="category-title">Energy & Power</h2>
                <span class="category-count">4 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="energy-converter.php" class="calc-card slide-in-right" data-name="Energy Converter">
                    <div class="calc-icon">🔋</div>
                    <div class="calc-title">Energy Converter</div>
                    <div class="calc-desc">Convert joules, calories, kWh, BTU, and more.</div>
                </a>
                <a href="power-converter.php" class="calc-card slide-in-right" data-name="Power Converter">
                    <div class="calc-icon">💡</div>
                    <div class="calc-title">Power Converter</div>
                    <div class="calc-desc">Convert watts, kilowatts, horsepower, and BTU/h.</div>
                </a>
                <a href="watts-to-amps.php" class="calc-card slide-in-right" data-name="Watts to Amps">
                    <div class="calc-icon">🔌</div>
                    <div class="calc-title">Watts to Amps</div>
                    <div class="calc-desc">Convert electrical power watts to current amps.</div>
                </a>
                <a href="voltage-converter.php" class="calc-card slide-in-right" data-name="Voltage Converter">
                    <div class="calc-icon">⚡</div>
                    <div class="calc-title">Voltage Converter</div>
                    <div class="calc-desc">Convert volts between AC and DC systems.</div>
                </a>
            </div>
        </div>

        <!-- Pressure -->
        <div class="category fade-in" data-category="pressure">
            <div class="category-header">
                <span class="category-icon">🌪️</span>
                <h2 class="category-title">Pressure</h2>
                <span class="category-count">3 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="pressure-converter.php" class="calc-card slide-in-left" data-name="Pressure Converter">
                    <div class="calc-icon">🔬</div>
                    <div class="calc-title">Pressure Converter</div>
                    <div class="calc-desc">Convert PSI, bar, pascal, atm, and torr.</div>
                </a>
                <a href="psi-to-bar.php" class="calc-card slide-in-left" data-name="PSI to Bar">
                    <div class="calc-icon">🛞</div>
                    <div class="calc-title">PSI to Bar Converter</div>
                    <div class="calc-desc">Convert tire pressure from PSI to bar.</div>
                </a>
                <a href="pascal-converter.php" class="calc-card slide-in-left" data-name="Pascal Converter">
                    <div class="calc-icon">📊</div>
                    <div class="calc-title">Pascal Converter</div>
                    <div class="calc-desc">Convert pascals to other pressure units.</div>
                </a>
            </div>
        </div>

        <!-- Time -->
        <div class="category fade-in" data-category="time">
            <div class="category-header">
                <span class="category-icon">⏰</span>
                <h2 class="category-title">Time</h2>
                <span class="category-count">2 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="time-converter.php" class="calc-card slide-in-right" data-name="Time Converter">
                    <div class="calc-icon">⏱️</div>
                    <div class="calc-title">Time Converter</div>
                    <div class="calc-desc">Convert seconds, minutes, hours, days, weeks, years.</div>
                </a>
                <a href="timezone-converter.php" class="calc-card slide-in-right" data-name="Timezone Converter">
                    <div class="calc-icon">🌍</div>
                    <div class="calc-title">Timezone Converter</div>
                    <div class="calc-desc">Convert time between different time zones worldwide.</div>
                </a>
            </div>
        </div>

        <div class="no-results" id="noResults" style="display: none;">
            <div class="no-results-icon">🔍</div>
            <h3>No converters found</h3>
            <p>Try a different search term or browse categories above</p>
        </div>
    </div>

    <footer class="fade-in">
        <p>🔄 Conversion Calculators | 40+ Free Tools</p>
        <p style="margin-top: 8px; font-size: 0.875rem;">Fast, accurate unit conversions for everyday use</p>
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