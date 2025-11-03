<?php
/**
 * Populate Calculators Database
 * Run this file once to add all 296 calculators to the database
 */

require_once 'config.php';

$db = Database::getInstance();

// All calculators data
$calculators = [
    // Financial (58 calculators)
    ['name' => 'Mortgage Calculator', 'slug' => 'mortgage-calculator', 'category' => 'financial', 'description' => 'Calculate monthly mortgage payments'],
    ['name' => 'Home Affordability Calculator', 'slug' => 'home-affordability-calculator', 'category' => 'financial', 'description' => 'Calculate how much house you can afford'],
    ['name' => 'Rent vs Buy Calculator', 'slug' => 'rent-vs-buy-calculator', 'category' => 'financial', 'description' => 'Compare renting vs buying a home'],
    ['name' => 'Mortgage Payoff Calculator', 'slug' => 'mortgage-payoff-calculator', 'category' => 'financial', 'description' => 'Calculate when you will pay off your mortgage'],
    ['name' => 'Refinance Calculator', 'slug' => 'refinance-calculator', 'category' => 'financial', 'description' => 'Calculate refinancing savings'],
    ['name' => 'FHA Loan Calculator', 'slug' => 'fha-loan-calculator', 'category' => 'financial', 'description' => 'Calculate FHA loan payments'],
    ['name' => 'VA Mortgage Calculator', 'slug' => 'va-mortgage-calculator', 'category' => 'financial', 'description' => 'Calculate VA loan payments'],
    ['name' => 'Down Payment Calculator', 'slug' => 'down-payment-calculator', 'category' => 'financial', 'description' => 'Calculate required down payment'],
    ['name' => 'Rental Property Calculator', 'slug' => 'rental-property-calculator', 'category' => 'financial', 'description' => 'Calculate rental property returns'],
    ['name' => 'Property Tax Calculator', 'slug' => 'property-tax-calculator', 'category' => 'financial', 'description' => 'Calculate property taxes'],
    ['name' => 'Home Equity Calculator', 'slug' => 'home-equity-calculator', 'category' => 'financial', 'description' => 'Calculate home equity'],
    ['name' => 'Real Estate Investment Calculator', 'slug' => 'real-estate-investment-calculator', 'category' => 'financial', 'description' => 'Calculate real estate ROI'],
    ['name' => 'Loan Calculator', 'slug' => 'loan-calculator', 'category' => 'financial', 'description' => 'Calculate loan payments'],
    ['name' => 'Auto Loan Calculator', 'slug' => 'auto-loan-calculator', 'category' => 'financial', 'description' => 'Calculate car loan payments'],
    ['name' => 'Personal Loan Calculator', 'slug' => 'personal-loan-calculator', 'category' => 'financial', 'description' => 'Calculate personal loan payments'],
    ['name' => 'Student Loan Calculator', 'slug' => 'student-loan-calculator', 'category' => 'financial', 'description' => 'Calculate student loan payments'],
    ['name' => 'Business Loan Calculator', 'slug' => 'business-loan-calculator', 'category' => 'financial', 'description' => 'Calculate business loan payments'],
    ['name' => 'Debt Consolidation Calculator', 'slug' => 'debt-consolidation-calculator', 'category' => 'financial', 'description' => 'Calculate debt consolidation savings'],
    ['name' => 'Loan Comparison Calculator', 'slug' => 'loan-comparison-calculator', 'category' => 'financial', 'description' => 'Compare different loans'],
    ['name' => 'Amortization Calculator', 'slug' => 'amortization-calculator', 'category' => 'financial', 'description' => 'Calculate loan amortization schedule'],
    ['name' => 'APR Calculator', 'slug' => 'apr-calculator', 'category' => 'financial', 'description' => 'Calculate annual percentage rate'],
    ['name' => 'Bi-weekly Payment Calculator', 'slug' => 'bi-weekly-payment-calculator', 'category' => 'financial', 'description' => 'Calculate bi-weekly payments'],
    ['name' => 'Investment Calculator', 'slug' => 'investment-calculator', 'category' => 'financial', 'description' => 'Calculate investment returns'],
    ['name' => 'Compound Interest Calculator', 'slug' => 'compound-interest-calculator', 'category' => 'financial', 'description' => 'Calculate compound interest'],
    ['name' => 'ROI Calculator', 'slug' => 'roi-calculator', 'category' => 'financial', 'description' => 'Calculate return on investment'],
    ['name' => 'Stock Return Calculator', 'slug' => 'stock-return-calculator', 'category' => 'financial', 'description' => 'Calculate stock returns'],
    ['name' => 'Dividend Calculator', 'slug' => 'dividend-calculator', 'category' => 'financial', 'description' => 'Calculate dividend income'],
    ['name' => 'Retirement Calculator', 'slug' => 'retirement-calculator', 'category' => 'financial', 'description' => 'Calculate retirement savings'],
    ['name' => '401k Calculator', 'slug' => '401k-calculator', 'category' => 'financial', 'description' => 'Calculate 401k savings'],
    ['name' => 'IRA Calculator', 'slug' => 'ira-calculator', 'category' => 'financial', 'description' => 'Calculate IRA savings'],
    ['name' => 'Roth IRA Calculator', 'slug' => 'roth-ira-calculator', 'category' => 'financial', 'description' => 'Calculate Roth IRA savings'],
    ['name' => 'Annuity Calculator', 'slug' => 'annuity-calculator', 'category' => 'financial', 'description' => 'Calculate annuity payments'],
    ['name' => 'Bond Calculator', 'slug' => 'bond-calculator', 'category' => 'financial', 'description' => 'Calculate bond returns'],
    ['name' => 'Mutual Fund Calculator', 'slug' => 'mutual-fund-calculator', 'category' => 'financial', 'description' => 'Calculate mutual fund returns'],
    ['name' => 'Income Tax Calculator', 'slug' => 'income-tax-calculator', 'category' => 'financial', 'description' => 'Calculate income tax'],
    ['name' => 'Sales Tax Calculator', 'slug' => 'sales-tax-calculator', 'category' => 'financial', 'description' => 'Calculate sales tax'],
    ['name' => 'Salary Calculator', 'slug' => 'salary-calculator', 'category' => 'financial', 'description' => 'Calculate salary after taxes'],
    ['name' => 'Paycheck Calculator', 'slug' => 'paycheck-calculator', 'category' => 'financial', 'description' => 'Calculate paycheck amount'],
    ['name' => 'Tax Return Calculator', 'slug' => 'tax-return-calculator', 'category' => 'financial', 'description' => 'Calculate tax return'],
    ['name' => 'Capital Gains Tax Calculator', 'slug' => 'capital-gains-tax-calculator', 'category' => 'financial', 'description' => 'Calculate capital gains tax'],
    ['name' => 'GST Calculator', 'slug' => 'gst-calculator', 'category' => 'financial', 'description' => 'Calculate GST'],
    ['name' => 'VAT Calculator', 'slug' => 'vat-calculator', 'category' => 'financial', 'description' => 'Calculate VAT'],
    ['name' => 'Self Employment Tax Calculator', 'slug' => 'self-employment-tax-calculator', 'category' => 'financial', 'description' => 'Calculate self-employment tax'],
    ['name' => 'Bonus Tax Calculator', 'slug' => 'bonus-tax-calculator', 'category' => 'financial', 'description' => 'Calculate bonus tax'],
    ['name' => 'Interest Calculator', 'slug' => 'interest-calculator', 'category' => 'financial', 'description' => 'Calculate interest'],
    ['name' => 'Interest Rate Calculator', 'slug' => 'interest-rate-calculator', 'category' => 'financial', 'description' => 'Calculate interest rate'],
    ['name' => 'Payment Calculator', 'slug' => 'payment-calculator', 'category' => 'financial', 'description' => 'Calculate payment amount'],
    ['name' => 'Inflation Calculator', 'slug' => 'inflation-calculator', 'category' => 'financial', 'description' => 'Calculate inflation impact'],
    ['name' => 'Currency Converter', 'slug' => 'currency-converter', 'category' => 'financial', 'description' => 'Convert currencies'],
    ['name' => 'Finance Calculator', 'slug' => 'finance-calculator', 'category' => 'financial', 'description' => 'General finance calculator'],
    ['name' => 'Budget Calculator', 'slug' => 'budget-calculator', 'category' => 'financial', 'description' => 'Calculate budget'],
    ['name' => 'Savings Calculator', 'slug' => 'savings-calculator', 'category' => 'financial', 'description' => 'Calculate savings'],
    ['name' => 'Emergency Fund Calculator', 'slug' => 'emergency-fund-calculator', 'category' => 'financial', 'description' => 'Calculate emergency fund needed'],
    ['name' => 'Tip Calculator', 'slug' => 'tip-calculator', 'category' => 'financial', 'description' => 'Calculate tip amount'],
    ['name' => 'Discount Calculator', 'slug' => 'discount-calculator', 'category' => 'financial', 'description' => 'Calculate discount'],
    ['name' => 'Profit Margin Calculator', 'slug' => 'profit-margin-calculator', 'category' => 'financial', 'description' => 'Calculate profit margin'],
    ['name' => 'Break Even Calculator', 'slug' => 'break-even-calculator', 'category' => 'financial', 'description' => 'Calculate break even point'],
    ['name' => 'Net Worth Calculator', 'slug' => 'net-worth-calculator', 'category' => 'financial', 'description' => 'Calculate net worth'],

    // Health (40 calculators)
    ['name' => 'BMI Calculator', 'slug' => 'bmi-calculator', 'category' => 'health', 'description' => 'Calculate body mass index'],
    ['name' => 'BMR Calculator', 'slug' => 'bmr-calculator', 'category' => 'health', 'description' => 'Calculate basal metabolic rate'],
    ['name' => 'Calorie Calculator', 'slug' => 'calorie-calculator', 'category' => 'health', 'description' => 'Calculate daily calorie needs'],
    ['name' => 'Calories Burned Calculator', 'slug' => 'calories-burned-calculator', 'category' => 'health', 'description' => 'Calculate calories burned'],
    ['name' => 'Body Fat Calculator', 'slug' => 'body-fat-calculator', 'category' => 'health', 'description' => 'Calculate body fat percentage'],
    ['name' => 'Ideal Weight Calculator', 'slug' => 'ideal-weight-calculator', 'category' => 'health', 'description' => 'Calculate ideal weight'],
    ['name' => 'Lean Body Mass Calculator', 'slug' => 'lean-body-mass-calculator', 'category' => 'health', 'description' => 'Calculate lean body mass'],
    ['name' => 'Body Type Calculator', 'slug' => 'body-type-calculator', 'category' => 'health', 'description' => 'Determine body type'],
    ['name' => 'Target Heart Rate Calculator', 'slug' => 'target-heart-rate-calculator', 'category' => 'health', 'description' => 'Calculate target heart rate'],
    ['name' => 'One Rep Max Calculator', 'slug' => 'one-rep-max-calculator', 'category' => 'health', 'description' => 'Calculate one rep max'],
    ['name' => 'Pace Calculator', 'slug' => 'pace-calculator', 'category' => 'health', 'description' => 'Calculate running pace'],
    ['name' => 'TDEE Calculator', 'slug' => 'tdee-calculator', 'category' => 'health', 'description' => 'Calculate total daily energy expenditure'],
    ['name' => 'Macro Calculator', 'slug' => 'macro-calculator', 'category' => 'health', 'description' => 'Calculate macronutrients'],
    ['name' => 'Protein Calculator', 'slug' => 'protein-calculator', 'category' => 'health', 'description' => 'Calculate protein needs'],
    ['name' => 'Carbohydrate Calculator', 'slug' => 'carbohydrate-calculator', 'category' => 'health', 'description' => 'Calculate carb needs'],
    ['name' => 'Fat Intake Calculator', 'slug' => 'fat-intake-calculator', 'category' => 'health', 'description' => 'Calculate fat intake'],
    ['name' => 'Water Intake Calculator', 'slug' => 'water-intake-calculator', 'category' => 'health', 'description' => 'Calculate water intake'],
    ['name' => 'Body Surface Area Calculator', 'slug' => 'body-surface-area-calculator', 'category' => 'health', 'description' => 'Calculate body surface area'],
    ['name' => 'Army Body Fat Calculator', 'slug' => 'army-body-fat-calculator', 'category' => 'health', 'description' => 'Calculate Army body fat'],
    ['name' => 'Navy Body Fat Calculator', 'slug' => 'navy-body-fat-calculator', 'category' => 'health', 'description' => 'Calculate Navy body fat'],
    ['name' => 'Healthy Weight Calculator', 'slug' => 'healthy-weight-calculator', 'category' => 'health', 'description' => 'Calculate healthy weight range'],
    ['name' => 'Walking Calorie Calculator', 'slug' => 'walking-calorie-calculator', 'category' => 'health', 'description' => 'Calculate walking calories'],
    ['name' => 'Running Calculator', 'slug' => 'running-calculator', 'category' => 'health', 'description' => 'Calculate running metrics'],
    ['name' => 'Cycling Calculator', 'slug' => 'cycling-calculator', 'category' => 'health', 'description' => 'Calculate cycling metrics'],
    ['name' => 'Pregnancy Calculator', 'slug' => 'pregnancy-calculator', 'category' => 'health', 'description' => 'Calculate pregnancy dates'],
    ['name' => 'Due Date Calculator', 'slug' => 'due-date-calculator', 'category' => 'health', 'description' => 'Calculate due date'],
    ['name' => 'Ovulation Calculator', 'slug' => 'ovulation-calculator', 'category' => 'health', 'description' => 'Calculate ovulation date'],
    ['name' => 'Conception Calculator', 'slug' => 'conception-calculator', 'category' => 'health', 'description' => 'Calculate conception date'],
    ['name' => 'Pregnancy Weight Gain Calculator', 'slug' => 'pregnancy-weight-gain-calculator', 'category' => 'health', 'description' => 'Calculate pregnancy weight gain'],
    ['name' => 'Period Calculator', 'slug' => 'period-calculator', 'category' => 'health', 'description' => 'Calculate period dates'],
    ['name' => 'Fertility Calculator', 'slug' => 'fertility-calculator', 'category' => 'health', 'description' => 'Calculate fertility window'],
    ['name' => 'Baby Gender Calculator', 'slug' => 'baby-gender-calculator', 'category' => 'health', 'description' => 'Predict baby gender'],
    ['name' => 'Baby Growth Calculator', 'slug' => 'baby-growth-calculator', 'category' => 'health', 'description' => 'Calculate baby growth'],
    ['name' => 'GFR Calculator', 'slug' => 'gfr-calculator', 'category' => 'health', 'description' => 'Calculate glomerular filtration rate'],
    ['name' => 'BAC Calculator', 'slug' => 'bac-calculator', 'category' => 'health', 'description' => 'Calculate blood alcohol content'],
    ['name' => 'Blood Pressure Calculator', 'slug' => 'blood-pressure-calculator', 'category' => 'health', 'description' => 'Calculate blood pressure'],
    ['name' => 'Blood Sugar Calculator', 'slug' => 'blood-sugar-calculator', 'category' => 'health', 'description' => 'Calculate blood sugar levels'],
    ['name' => 'Cholesterol Calculator', 'slug' => 'cholesterol-calculator', 'category' => 'health', 'description' => 'Calculate cholesterol levels'],
    ['name' => 'BMI for Children Calculator', 'slug' => 'bmi-children-calculator', 'category' => 'health', 'description' => 'Calculate BMI for children'],
    ['name' => 'Dosage Calculator', 'slug' => 'dosage-calculator', 'category' => 'health', 'description' => 'Calculate medication dosage'],

    // Math (42 calculators)
    ['name' => 'Scientific Calculator', 'slug' => 'scientific-calculator', 'category' => 'math', 'description' => 'Advanced scientific calculator'],
    ['name' => 'Basic Calculator', 'slug' => 'basic-calculator', 'category' => 'math', 'description' => 'Basic math calculator'],
    ['name' => 'Fraction Calculator', 'slug' => 'fraction-calculator', 'category' => 'math', 'description' => 'Calculate with fractions'],
    ['name' => 'Percentage Calculator', 'slug' => 'percentage-calculator', 'category' => 'math', 'description' => 'Calculate percentages'],
    ['name' => 'Ratio Calculator', 'slug' => 'ratio-calculator', 'category' => 'math', 'description' => 'Calculate ratios'],
    ['name' => 'Proportion Calculator', 'slug' => 'proportion-calculator', 'category' => 'math', 'description' => 'Calculate proportions'],
    ['name' => 'Exponent Calculator', 'slug' => 'exponent-calculator', 'category' => 'math', 'description' => 'Calculate exponents'],
    ['name' => 'Square Root Calculator', 'slug' => 'square-root-calculator', 'category' => 'math', 'description' => 'Calculate square roots'],
    ['name' => 'Logarithm Calculator', 'slug' => 'logarithm-calculator', 'category' => 'math', 'description' => 'Calculate logarithms'],
    ['name' => 'Algebra Calculator', 'slug' => 'algebra-calculator', 'category' => 'math', 'description' => 'Solve algebra problems'],
    ['name' => 'Equation Solver', 'slug' => 'equation-solver', 'category' => 'math', 'description' => 'Solve equations'],
    ['name' => 'Standard Deviation Calculator', 'slug' => 'standard-deviation-calculator', 'category' => 'math', 'description' => 'Calculate standard deviation'],
    ['name' => 'Mean Median Mode Calculator', 'slug' => 'mean-median-mode-calculator', 'category' => 'math', 'description' => 'Calculate mean, median, mode'],
    ['name' => 'Variance Calculator', 'slug' => 'variance-calculator', 'category' => 'math', 'description' => 'Calculate variance'],
    ['name' => 'Probability Calculator', 'slug' => 'probability-calculator', 'category' => 'math', 'description' => 'Calculate probability'],
    ['name' => 'Sample Size Calculator', 'slug' => 'sample-size-calculator', 'category' => 'math', 'description' => 'Calculate sample size'],
    ['name' => 'Confidence Interval Calculator', 'slug' => 'confidence-interval-calculator', 'category' => 'math', 'description' => 'Calculate confidence intervals'],
    ['name' => 'Z Score Calculator', 'slug' => 'z-score-calculator', 'category' => 'math', 'description' => 'Calculate z-score'],
    ['name' => 'T Test Calculator', 'slug' => 't-test-calculator', 'category' => 'math', 'description' => 'Perform t-test'],
    ['name' => 'Chi Square Calculator', 'slug' => 'chi-square-calculator', 'category' => 'math', 'description' => 'Calculate chi-square'],
    ['name' => 'Correlation Calculator', 'slug' => 'correlation-calculator', 'category' => 'math', 'description' => 'Calculate correlation'],
    ['name' => 'Area Calculator', 'slug' => 'area-calculator', 'category' => 'math', 'description' => 'Calculate area'],
    ['name' => 'Volume Calculator', 'slug' => 'volume-calculator', 'category' => 'math', 'description' => 'Calculate volume'],
    ['name' => 'Perimeter Calculator', 'slug' => 'perimeter-calculator', 'category' => 'math', 'description' => 'Calculate perimeter'],
    ['name' => 'Triangle Calculator', 'slug' => 'triangle-calculator', 'category' => 'math', 'description' => 'Calculate triangle properties'],
    ['name' => 'Circle Calculator', 'slug' => 'circle-calculator', 'category' => 'math', 'description' => 'Calculate circle properties'],
    ['name' => 'Rectangle Calculator', 'slug' => 'rectangle-calculator', 'category' => 'math', 'description' => 'Calculate rectangle properties'],
    ['name' => 'Square Calculator', 'slug' => 'square-calculator', 'category' => 'math', 'description' => 'Calculate square properties'],
    ['name' => 'Pythagorean Theorem Calculator', 'slug' => 'pythagorean-theorem-calculator', 'category' => 'math', 'description' => 'Use Pythagorean theorem'],
    ['name' => 'Angle Calculator', 'slug' => 'angle-calculator', 'category' => 'math', 'description' => 'Calculate angles'],
    ['name' => 'Polygon Calculator', 'slug' => 'polygon-calculator', 'category' => 'math', 'description' => 'Calculate polygon properties'],
    ['name' => 'Matrix Calculator', 'slug' => 'matrix-calculator', 'category' => 'math', 'description' => 'Calculate matrix operations'],
    ['name' => 'Derivative Calculator', 'slug' => 'derivative-calculator', 'category' => 'math', 'description' => 'Calculate derivatives'],
    ['name' => 'Integral Calculator', 'slug' => 'integral-calculator', 'category' => 'math', 'description' => 'Calculate integrals'],
    ['name' => 'Limit Calculator', 'slug' => 'limit-calculator', 'category' => 'math', 'description' => 'Calculate limits'],
    ['name' => 'Factorial Calculator', 'slug' => 'factorial-calculator', 'category' => 'math', 'description' => 'Calculate factorials'],
    ['name' => 'Permutation Calculator', 'slug' => 'permutation-calculator', 'category' => 'math', 'description' => 'Calculate permutations'],
    ['name' => 'Combination Calculator', 'slug' => 'combination-calculator', 'category' => 'math', 'description' => 'Calculate combinations'],
    ['name' => 'Sequence Calculator', 'slug' => 'sequence-calculator', 'category' => 'math', 'description' => 'Calculate sequences'],
    ['name' => 'Series Calculator', 'slug' => 'series-calculator', 'category' => 'math', 'description' => 'Calculate series'],
    ['name' => 'Prime Factorization Calculator', 'slug' => 'prime-factorization-calculator', 'category' => 'math', 'description' => 'Find prime factors'],
    ['name' => 'GCD LCM Calculator', 'slug' => 'gcd-lcm-calculator', 'category' => 'math', 'description' => 'Calculate GCD and LCM'],

    // Conversion (40 calculators)
    ['name' => 'Length Converter', 'slug' => 'length-converter', 'category' => 'conversion', 'description' => 'Convert length units'],
    ['name' => 'Distance Converter', 'slug' => 'distance-converter', 'category' => 'conversion', 'description' => 'Convert distance units'],
    ['name' => 'Height Converter', 'slug' => 'height-converter', 'category' => 'conversion', 'description' => 'Convert height units'],
    ['name' => 'Inch to CM Converter', 'slug' => 'inch-to-cm-converter', 'category' => 'conversion', 'description' => 'Convert inches to centimeters'],
    ['name' => 'Feet to Meter Converter', 'slug' => 'feet-to-meter-converter', 'category' => 'conversion', 'description' => 'Convert feet to meters'],
    ['name' => 'Mile to KM Converter', 'slug' => 'mile-to-km-converter', 'category' => 'conversion', 'description' => 'Convert miles to kilometers'],
    ['name' => 'Weight Converter', 'slug' => 'weight-converter', 'category' => 'conversion', 'description' => 'Convert weight units'],
    ['name' => 'Kg to Lbs Converter', 'slug' => 'kg-to-lbs-converter', 'category' => 'conversion', 'description' => 'Convert kilograms to pounds'],
    ['name' => 'Pounds to Kg Converter', 'slug' => 'pounds-to-kg-converter', 'category' => 'conversion', 'description' => 'Convert pounds to kilograms'],
    ['name' => 'Grams to Ounces Converter', 'slug' => 'grams-to-ounces-converter', 'category' => 'conversion', 'description' => 'Convert grams to ounces'],
    ['name' => 'Temperature Converter', 'slug' => 'temperature-converter', 'category' => 'conversion', 'description' => 'Convert temperature units'],
    ['name' => 'Celsius to Fahrenheit', 'slug' => 'celsius-to-fahrenheit', 'category' => 'conversion', 'description' => 'Convert Celsius to Fahrenheit'],
    ['name' => 'Fahrenheit to Celsius', 'slug' => 'fahrenheit-to-celsius', 'category' => 'conversion', 'description' => 'Convert Fahrenheit to Celsius'],
    ['name' => 'Kelvin Converter', 'slug' => 'kelvin-converter', 'category' => 'conversion', 'description' => 'Convert Kelvin units'],
    ['name' => 'Volume Converter', 'slug' => 'volume-converter', 'category' => 'conversion', 'description' => 'Convert volume units'],
    ['name' => 'Gallons to Liters', 'slug' => 'gallons-to-liters', 'category' => 'conversion', 'description' => 'Convert gallons to liters'],
    ['name' => 'Liters to Gallons', 'slug' => 'liters-to-gallons', 'category' => 'conversion', 'description' => 'Convert liters to gallons'],
    ['name' => 'Cup to ML Converter', 'slug' => 'cup-to-ml-converter', 'category' => 'conversion', 'description' => 'Convert cups to milliliters'],
    ['name' => 'Tablespoon Converter', 'slug' => 'tablespoon-converter', 'category' => 'conversion', 'description' => 'Convert tablespoons'],
    ['name' => 'Area Converter', 'slug' => 'area-converter', 'category' => 'conversion', 'description' => 'Convert area units'],
    ['name' => 'Square Feet to Square Meter', 'slug' => 'square-feet-to-square-meter', 'category' => 'conversion', 'description' => 'Convert square feet to meters'],
    ['name' => 'Acre to Square Feet', 'slug' => 'acre-to-square-feet', 'category' => 'conversion', 'description' => 'Convert acres to square feet'],
    ['name' => 'Hectare Converter', 'slug' => 'hectare-converter', 'category' => 'conversion', 'description' => 'Convert hectares'],
    ['name' => 'Speed Converter', 'slug' => 'speed-converter', 'category' => 'conversion', 'description' => 'Convert speed units'],
    ['name' => 'MPH to KPH', 'slug' => 'mph-to-kph', 'category' => 'conversion', 'description' => 'Convert MPH to KPH'],
    ['name' => 'KPH to MPH', 'slug' => 'kph-to-mph', 'category' => 'conversion', 'description' => 'Convert KPH to MPH'],
    ['name' => 'Knots Converter', 'slug' => 'knots-converter', 'category' => 'conversion', 'description' => 'Convert knots'],
    ['name' => 'Data Storage Converter', 'slug' => 'data-storage-converter', 'category' => 'conversion', 'description' => 'Convert data storage units'],
    ['name' => 'MB to GB Converter', 'slug' => 'mb-to-gb-converter', 'category' => 'conversion', 'description' => 'Convert megabytes to gigabytes'],
    ['name' => 'GB to TB Converter', 'slug' => 'gb-to-tb-converter', 'category' => 'conversion', 'description' => 'Convert gigabytes to terabytes'],
    ['name' => 'Bit Byte Converter', 'slug' => 'bit-byte-converter', 'category' => 'conversion', 'description' => 'Convert bits to bytes'],
    ['name' => 'Energy Converter', 'slug' => 'energy-converter', 'category' => 'conversion', 'description' => 'Convert energy units'],
    ['name' => 'Power Converter', 'slug' => 'power-converter', 'category' => 'conversion', 'description' => 'Convert power units'],
    ['name' => 'Watts to Amps', 'slug' => 'watts-to-amps', 'category' => 'conversion', 'description' => 'Convert watts to amps'],
    ['name' => 'Voltage Converter', 'slug' => 'voltage-converter', 'category' => 'conversion', 'description' => 'Convert voltage units'],
    ['name' => 'Pressure Converter', 'slug' => 'pressure-converter', 'category' => 'conversion', 'description' => 'Convert pressure units'],
    ['name' => 'PSI to Bar', 'slug' => 'psi-to-bar', 'category' => 'conversion', 'description' => 'Convert PSI to Bar'],
    ['name' => 'Pascal Converter', 'slug' => 'pascal-converter', 'category' => 'conversion', 'description' => 'Convert Pascal units'],
    ['name' => 'Time Converter', 'slug' => 'time-converter', 'category' => 'conversion', 'description' => 'Convert time units'],
    ['name' => 'Timezone Converter', 'slug' => 'timezone-converter', 'category' => 'conversion', 'description' => 'Convert timezones'],

    // Date & Time (16 calculators)
    ['name' => 'Date Calculator', 'slug' => 'date-calculator', 'category' => 'date-time', 'description' => 'Calculate dates'],
    ['name' => 'Time Calculator', 'slug' => 'time-calculator', 'category' => 'date-time', 'description' => 'Calculate time'],
    ['name' => 'Age Calculator', 'slug' => 'age-calculator', 'category' => 'date-time', 'description' => 'Calculate age'],
    ['name' => 'Hours Calculator', 'slug' => 'hours-calculator', 'category' => 'date-time', 'description' => 'Calculate hours'],
    ['name' => 'Days Calculator', 'slug' => 'days-calculator', 'category' => 'date-time', 'description' => 'Calculate days'],
    ['name' => 'Business Days Calculator', 'slug' => 'business-days-calculator', 'category' => 'date-time', 'description' => 'Calculate business days'],
    ['name' => 'Time Duration Calculator', 'slug' => 'time-duration-calculator', 'category' => 'date-time', 'description' => 'Calculate time duration'],
    ['name' => 'Time Difference Calculator', 'slug' => 'time-difference-calculator', 'category' => 'date-time', 'description' => 'Calculate time difference'],
    ['name' => 'Date Difference Calculator', 'slug' => 'date-difference-calculator', 'category' => 'date-time', 'description' => 'Calculate date difference'],
    ['name' => 'Days Until Calculator', 'slug' => 'days-until-calculator', 'category' => 'date-time', 'description' => 'Calculate days until event'],
    ['name' => 'Weeks Calculator', 'slug' => 'weeks-calculator', 'category' => 'date-time', 'description' => 'Calculate weeks'],
    ['name' => 'Months Calculator', 'slug' => 'months-calculator', 'category' => 'date-time', 'description' => 'Calculate months'],
    ['name' => 'Working Hours Calculator', 'slug' => 'working-hours-calculator', 'category' => 'date-time', 'description' => 'Calculate working hours'],
    ['name' => 'Shift Calculator', 'slug' => 'shift-calculator', 'category' => 'date-time', 'description' => 'Calculate shift hours'],
    ['name' => 'Retirement Date Calculator', 'slug' => 'retirement-date-calculator', 'category' => 'date-time', 'description' => 'Calculate retirement date'],
    ['name' => 'Anniversary Calculator', 'slug' => 'anniversary-calculator', 'category' => 'date-time', 'description' => 'Calculate anniversary dates'],

    // Construction (18 calculators)
    ['name' => 'Concrete Calculator', 'slug' => 'concrete-calculator', 'category' => 'construction', 'description' => 'Calculate concrete needed'],
    ['name' => 'Roofing Calculator', 'slug' => 'roofing-calculator', 'category' => 'construction', 'description' => 'Calculate roofing materials'],
    ['name' => 'Paint Calculator', 'slug' => 'paint-calculator', 'category' => 'construction', 'description' => 'Calculate paint needed'],
    ['name' => 'Flooring Calculator', 'slug' => 'flooring-calculator', 'category' => 'construction', 'description' => 'Calculate flooring materials'],
    ['name' => 'Tile Calculator', 'slug' => 'tile-calculator', 'category' => 'construction', 'description' => 'Calculate tiles needed'],
    ['name' => 'Carpet Calculator', 'slug' => 'carpet-calculator', 'category' => 'construction', 'description' => 'Calculate carpet needed'],
    ['name' => 'Brick Calculator', 'slug' => 'brick-calculator', 'category' => 'construction', 'description' => 'Calculate bricks needed'],
    ['name' => 'Deck Calculator', 'slug' => 'deck-calculator', 'category' => 'construction', 'description' => 'Calculate deck materials'],
    ['name' => 'Fence Calculator', 'slug' => 'fence-calculator', 'category' => 'construction', 'description' => 'Calculate fence materials'],
    ['name' => 'Drywall Calculator', 'slug' => 'drywall-calculator', 'category' => 'construction', 'description' => 'Calculate drywall needed'],
    ['name' => 'Insulation Calculator', 'slug' => 'insulation-calculator', 'category' => 'construction', 'description' => 'Calculate insulation needed'],
    ['name' => 'Mulch Calculator', 'slug' => 'mulch-calculator', 'category' => 'construction', 'description' => 'Calculate mulch needed'],
    ['name' => 'Gravel Calculator', 'slug' => 'gravel-calculator', 'category' => 'construction', 'description' => 'Calculate gravel needed'],
    ['name' => 'Sod Calculator', 'slug' => 'sod-calculator', 'category' => 'construction', 'description' => 'Calculate sod needed'],
    ['name' => 'Stair Calculator', 'slug' => 'stair-calculator', 'category' => 'construction', 'description' => 'Calculate stair dimensions'],
    ['name' => 'Square Footage Calculator', 'slug' => 'square-footage-calculator', 'category' => 'construction', 'description' => 'Calculate square footage'],
    ['name' => 'Board Feet Calculator', 'slug' => 'board-feet-calculator', 'category' => 'construction', 'description' => 'Calculate board feet'],
    ['name' => 'Rafter Calculator', 'slug' => 'rafter-calculator', 'category' => 'construction', 'description' => 'Calculate rafter dimensions'],

    // Electronics (12 calculators)
    ['name' => 'Subnet Calculator', 'slug' => 'subnet-calculator', 'category' => 'electronics', 'description' => 'Calculate subnet masks'],
    ['name' => 'IP Calculator', 'slug' => 'ip-calculator', 'category' => 'electronics', 'description' => 'Calculate IP addresses'],
    ['name' => 'Ohms Law Calculator', 'slug' => 'ohms-law-calculator', 'category' => 'electronics', 'description' => 'Calculate using Ohms Law'],
    ['name' => 'Battery Life Calculator', 'slug' => 'battery-life-calculator', 'category' => 'electronics', 'description' => 'Calculate battery life'],
    ['name' => 'LED Resistor Calculator', 'slug' => 'led-resistor-calculator', 'category' => 'electronics', 'description' => 'Calculate LED resistors'],
    ['name' => 'Power Supply Calculator', 'slug' => 'power-supply-calculator', 'category' => 'electronics', 'description' => 'Calculate power supply'],
    ['name' => 'Speaker Wire Calculator', 'slug' => 'speaker-wire-calculator', 'category' => 'electronics', 'description' => 'Calculate speaker wire gauge'],
    ['name' => 'Screen Size Calculator', 'slug' => 'screen-size-calculator', 'category' => 'electronics', 'description' => 'Calculate screen size'],
    ['name' => 'Pixel Density Calculator', 'slug' => 'pixel-density-calculator', 'category' => 'electronics', 'description' => 'Calculate pixel density'],
    ['name' => 'Bandwidth Calculator', 'slug' => 'bandwidth-calculator', 'category' => 'electronics', 'description' => 'Calculate bandwidth'],
    ['name' => 'Data Transfer Time Calculator', 'slug' => 'data-transfer-time-calculator', 'category' => 'electronics', 'description' => 'Calculate transfer time'],
    ['name' => 'WiFi Speed Calculator', 'slug' => 'wifi-speed-calculator', 'category' => 'electronics', 'description' => 'Calculate WiFi speed'],

    // Automotive (11 calculators)
    ['name' => 'Gas Mileage Calculator', 'slug' => 'gas-mileage-calculator', 'category' => 'automotive', 'description' => 'Calculate gas mileage'],
    ['name' => 'Fuel Cost Calculator', 'slug' => 'fuel-cost-calculator', 'category' => 'automotive', 'description' => 'Calculate fuel cost'],
    ['name' => 'Car Lease Calculator', 'slug' => 'car-lease-calculator', 'category' => 'automotive', 'description' => 'Calculate car lease payments'],
    ['name' => 'Car Payment Calculator', 'slug' => 'car-payment-calculator', 'category' => 'automotive', 'description' => 'Calculate car payments'],
    ['name' => 'Tire Size Calculator', 'slug' => 'tire-size-calculator', 'category' => 'automotive', 'description' => 'Calculate tire size'],
    ['name' => '0-60 Calculator', 'slug' => '0-60-calculator', 'category' => 'automotive', 'description' => 'Calculate 0-60 time'],
    ['name' => 'Quarter Mile Calculator', 'slug' => 'quarter-mile-calculator', 'category' => 'automotive', 'description' => 'Calculate quarter mile time'],
    ['name' => 'Horsepower Calculator', 'slug' => 'horsepower-calculator', 'category' => 'automotive', 'description' => 'Calculate horsepower'],
    ['name' => 'Gear Ratio Calculator', 'slug' => 'gear-ratio-calculator', 'category' => 'automotive', 'description' => 'Calculate gear ratios'],
    ['name' => 'Car Depreciation Calculator', 'slug' => 'car-depreciation-calculator', 'category' => 'automotive', 'description' => 'Calculate car depreciation'],
    ['name' => 'Carbon Footprint Calculator', 'slug' => 'carbon-footprint-calculator', 'category' => 'automotive', 'description' => 'Calculate carbon footprint'],

    // Education (10 calculators)
    ['name' => 'GPA Calculator', 'slug' => 'gpa-calculator', 'category' => 'education', 'description' => 'Calculate GPA'],
    ['name' => 'Grade Calculator', 'slug' => 'grade-calculator', 'category' => 'education', 'description' => 'Calculate grades'],
    ['name' => 'Final Grade Calculator', 'slug' => 'final-grade-calculator', 'category' => 'education', 'description' => 'Calculate final grade'],
    ['name' => 'Weighted Grade Calculator', 'slug' => 'weighted-grade-calculator', 'category' => 'education', 'description' => 'Calculate weighted grades'],
    ['name' => 'Test Grade Calculator', 'slug' => 'test-grade-calculator', 'category' => 'education', 'description' => 'Calculate test grades'],
    ['name' => 'Class Grade Calculator', 'slug' => 'class-grade-calculator', 'category' => 'education', 'description' => 'Calculate class grade'],
    ['name' => 'College GPA Calculator', 'slug' => 'college-gpa-calculator', 'category' => 'education', 'description' => 'Calculate college GPA'],
    ['name' => 'High School GPA Calculator', 'slug' => 'high-school-gpa-calculator', 'category' => 'education', 'description' => 'Calculate high school GPA'],
    ['name' => 'Semester GPA Calculator', 'slug' => 'semester-gpa-calculator', 'category' => 'education', 'description' => 'Calculate semester GPA'],
    ['name' => 'Report Card Calculator', 'slug' => 'report-card-calculator', 'category' => 'education', 'description' => 'Calculate report card grades'],

    // Utility (15 calculators)
    ['name' => 'Random Number Generator', 'slug' => 'random-number-generator', 'category' => 'utility', 'description' => 'Generate random numbers'],
    ['name' => 'Password Generator', 'slug' => 'password-generator', 'category' => 'utility', 'description' => 'Generate secure passwords'],
    ['name' => 'Random Name Generator', 'slug' => 'random-name-generator', 'category' => 'utility', 'description' => 'Generate random names'],
    ['name' => 'Random Color Generator', 'slug' => 'random-color-generator', 'category' => 'utility', 'description' => 'Generate random colors'],
    ['name' => 'Dice Roller', 'slug' => 'dice-roller', 'category' => 'utility', 'description' => 'Roll virtual dice'],
    ['name' => 'Coin Flip', 'slug' => 'coin-flip', 'category' => 'utility', 'description' => 'Flip a virtual coin'],
    ['name' => 'Random Date Generator', 'slug' => 'random-date-generator', 'category' => 'utility', 'description' => 'Generate random dates'],
    ['name' => 'Random Letter Generator', 'slug' => 'random-letter-generator', 'category' => 'utility', 'description' => 'Generate random letters'],
    ['name' => 'UUID Generator', 'slug' => 'uuid-generator', 'category' => 'utility', 'description' => 'Generate UUIDs'],
    ['name' => 'QR Code Generator', 'slug' => 'qr-code-generator', 'category' => 'utility', 'description' => 'Generate QR codes'],
    ['name' => 'Barcode Generator', 'slug' => 'barcode-generator', 'category' => 'utility', 'description' => 'Generate barcodes'],
    ['name' => 'Word Counter', 'slug' => 'word-counter', 'category' => 'utility', 'description' => 'Count words'],
    ['name' => 'Character Counter', 'slug' => 'character-counter', 'category' => 'utility', 'description' => 'Count characters'],
    ['name' => 'Case Converter', 'slug' => 'case-converter', 'category' => 'utility', 'description' => 'Convert text case'],
    ['name' => 'Lorem Ipsum Generator', 'slug' => 'lorem-ipsum-generator', 'category' => 'utility', 'description' => 'Generate Lorem Ipsum text'],

    // Weather (9 calculators)
    ['name' => 'BTU Calculator', 'slug' => 'btu-calculator', 'category' => 'weather', 'description' => 'Calculate BTU requirements'],
    ['name' => 'Wind Chill Calculator', 'slug' => 'wind-chill-calculator', 'category' => 'weather', 'description' => 'Calculate wind chill'],
    ['name' => 'Heat Index Calculator', 'slug' => 'heat-index-calculator', 'category' => 'weather', 'description' => 'Calculate heat index'],
    ['name' => 'Dew Point Calculator', 'slug' => 'dew-point-calculator', 'category' => 'weather', 'description' => 'Calculate dew point'],
    ['name' => 'Rainfall Calculator', 'slug' => 'rainfall-calculator', 'category' => 'weather', 'description' => 'Calculate rainfall'],
    ['name' => 'Snow to Water Calculator', 'slug' => 'snow-to-water-calculator', 'category' => 'weather', 'description' => 'Convert snow to water'],
    ['name' => 'Solar Panel Calculator', 'slug' => 'solar-panel-calculator', 'category' => 'weather', 'description' => 'Calculate solar panel needs'],
    ['name' => 'Carbon Offset Calculator', 'slug' => 'carbon-offset-calculator', 'category' => 'weather', 'description' => 'Calculate carbon offset'],
    ['name' => 'Compost Calculator', 'slug' => 'compost-calculator', 'category' => 'weather', 'description' => 'Calculate compost needs'],

    // Cooking (9 calculators)
    ['name' => 'Recipe Converter', 'slug' => 'recipe-converter', 'category' => 'cooking', 'description' => 'Convert recipe measurements'],
    ['name' => 'Recipe Scaling Calculator', 'slug' => 'recipe-scaling-calculator', 'category' => 'cooking', 'description' => 'Scale recipes'],
    ['name' => 'Cooking Time Calculator', 'slug' => 'cooking-time-calculator', 'category' => 'cooking', 'description' => 'Calculate cooking time'],
    ['name' => 'Ingredient Substitution Calculator', 'slug' => 'ingredient-substitution-calculator', 'category' => 'cooking', 'description' => 'Find ingredient substitutions'],
    ['name' => 'Baking Conversion Calculator', 'slug' => 'baking-conversion-calculator', 'category' => 'cooking', 'description' => 'Convert baking measurements'],
    ['name' => 'Nutrition Calculator', 'slug' => 'nutrition-calculator', 'category' => 'cooking', 'description' => 'Calculate nutrition facts'],
    ['name' => 'Meal Prep Calculator', 'slug' => 'meal-prep-calculator', 'category' => 'cooking', 'description' => 'Calculate meal prep quantities'],
    ['name' => 'Pizza Dough Calculator', 'slug' => 'pizza-dough-calculator', 'category' => 'cooking', 'description' => 'Calculate pizza dough ingredients'],
    ['name' => 'Bread Baker Calculator', 'slug' => 'bread-baker-calculator', 'category' => 'cooking', 'description' => 'Calculate bread ingredients'],

    // Gaming (8 calculators)
    ['name' => 'Minecraft Calculator', 'slug' => 'minecraft-calculator', 'category' => 'gaming', 'description' => 'Minecraft game calculations'],
    ['name' => 'Fortnite Stats Calculator', 'slug' => 'fortnite-stats-calculator', 'category' => 'gaming', 'description' => 'Calculate Fortnite stats'],
    ['name' => 'Pokemon IV Calculator', 'slug' => 'pokemon-iv-calculator', 'category' => 'gaming', 'description' => 'Calculate Pokemon IVs'],
    ['name' => 'DND Dice Roller', 'slug' => 'dnd-dice-roller', 'category' => 'gaming', 'description' => 'Roll D&D dice'],
    ['name' => 'Game Odds Calculator', 'slug' => 'game-odds-calculator', 'category' => 'gaming', 'description' => 'Calculate game odds'],
    ['name' => 'Battle Calculator', 'slug' => 'battle-calculator', 'category' => 'gaming', 'description' => 'Calculate battle stats'],
    ['name' => 'XP Calculator', 'slug' => 'xp-calculator', 'category' => 'gaming', 'description' => 'Calculate experience points'],
    ['name' => 'Level Up Calculator', 'slug' => 'level-up-calculator', 'category' => 'gaming', 'description' => 'Calculate level up requirements'],

    // Sports (8 calculators)
    ['name' => 'Swim Pace Calculator', 'slug' => 'swim-pace-calculator', 'category' => 'sports', 'description' => 'Calculate swimming pace'],
    ['name' => 'Marathon Time Calculator', 'slug' => 'marathon-time-calculator', 'category' => 'sports', 'description' => 'Calculate marathon time'],
    ['name' => 'Bike Cadence Calculator', 'slug' => 'bike-cadence-calculator', 'category' => 'sports', 'description' => 'Calculate bike cadence'],
    ['name' => 'Golf Handicap Calculator', 'slug' => 'golf-handicap-calculator', 'category' => 'sports', 'description' => 'Calculate golf handicap'],
    ['name' => 'Batting Average Calculator', 'slug' => 'batting-average-calculator', 'category' => 'sports', 'description' => 'Calculate batting average'],
    ['name' => 'Vertical Jump Calculator', 'slug' => 'vertical-jump-calculator', 'category' => 'sports', 'description' => 'Calculate vertical jump'],
    ['name' => 'Race Time Predictor', 'slug' => 'race-time-predictor', 'category' => 'sports', 'description' => 'Predict race time'],
    ['name' => 'Training Zone Calculator', 'slug' => 'training-zone-calculator', 'category' => 'sports', 'description' => 'Calculate training zones'],
];

try {
    $db->beginTransaction();
    
    $inserted = 0;
    $skipped = 0;
    
    foreach ($calculators as $calc) {
        // Check if calculator already exists
        $exists = $db->fetchOne("SELECT id FROM calculators WHERE slug = ?", [$calc['slug']]);
        
        if (!$exists) {
            $stmt = $db->prepare("
                INSERT INTO calculators (name, slug, category, description, is_active, created_at, updated_at)
                VALUES (?, ?, ?, ?, 1, NOW(), NOW())
            ");
            $stmt->execute([$calc['name'], $calc['slug'], $calc['category'], $calc['description']]);
            $inserted++;
        } else {
            $skipped++;
        }
    }
    
    $db->commit();
    
    echo "<!DOCTYPE html>";
    echo "<html><head><title>Database Populated</title>";
    echo "<style>body{font-family:Arial;max-width:800px;margin:50px auto;padding:20px;}";
    echo ".success{background:#d4edda;color:#155724;padding:20px;border-radius:8px;border:1px solid #c3e6cb;margin-bottom:20px;}";
    echo ".info{background:#d1ecf1;color:#0c5460;padding:15px;border-radius:8px;margin-bottom:10px;}";
    echo "h1{color:#333;}</style></head><body>";
    echo "<h1>✅ Database Population Complete!</h1>";
    echo "<div class='success'>";
    echo "<h2>Success!</h2>";
    echo "<p><strong>{$inserted}</strong> calculators were added to the database.</p>";
    echo "<p><strong>{$skipped}</strong> calculators were already in the database (skipped).</p>";
    echo "</div>";
    echo "<div class='info'><strong>Total calculators in database:</strong> " . ($inserted + $skipped) . "</div>";
    echo "<div class='info'><strong>Next step:</strong> Go to <a href='" . SITE_URL . "/calculators/'>All Categories</a> to see your calculators!</div>";
    echo "</body></html>";
    
} catch (Exception $e) {
    $db->rollBack();
    echo "<!DOCTYPE html>";
    echo "<html><head><title>Error</title>";
    echo "<style>body{font-family:Arial;max-width:800px;margin:50px auto;padding:20px;}";
    echo ".error{background:#f8d7da;color:#721c24;padding:20px;border-radius:8px;border:1px solid #f5c6cb;}</style></head><body>";
    echo "<h1>❌ Error</h1>";
    echo "<div class='error'>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "</div>";
    echo "</body></html>";
}
?>