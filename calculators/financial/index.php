<?php
/**
 * Financial Calculators Index
 * File: index.php
 * Description: Main landing page for all financial calculators
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Calculators - Free Online Tools (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free online financial calculators. Calculate mortgages, loans, investments, retirement, taxes, inflation, and more. Supports USD, INR, EUR, and GBP.">
    <link rel="stylesheet" href="assets/css/calculator.css">
    <style>
        .calculator-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin: 40px 0;
        }

        .calculator-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .calculator-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            border-color: #667eea;
        }

        .calculator-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .calculator-card h3 {
            color: #333;
            margin: 10px 0;
            font-size: 1.3em;
        }

        .calculator-card p {
            color: #666;
            font-size: 0.95em;
            line-height: 1.6;
            margin: 10px 0 0 0;
        }

        .category-section {
            margin: 60px 0;
        }

        .category-title {
            color: #667eea;
            font-size: 2em;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 60px;
        }

        .hero-section h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 1.2em;
            opacity: 0.95;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin: 50px 0;
        }

        .feature-box {
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .feature-box h3 {
            color: #667eea;
            margin: 15px 0;
        }

        @media (max-width: 768px) {
            .calculator-grid {
                grid-template-columns: 1fr;
            }
            
            .hero-section h1 {
                font-size: 1.8em;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1>&#128202; Financial Calculators</h1>
            <p>Comprehensive financial tools to help you make informed decisions</p>
            <p style="font-size: 0.9em; margin-top: 10px;">Supporting USD, INR, EUR, and GBP currencies</p>
        </div>

        <!-- Features -->
        <div class="features">
            <div class="feature-box">
                <div style="font-size: 48px;">&#127760;</div>
                <h3>Multi-Currency</h3>
                <p>Calculate in USD, INR, EUR, or GBP</p>
            </div>
            <div class="feature-box">
                <div style="font-size: 48px;">&#128176;</div>
                <h3>Free Forever</h3>
                <p>100% free, no registration required</p>
            </div>
            <div class="feature-box">
                <div style="font-size: 48px;">&#128241;</div>
                <h3>Mobile Friendly</h3>
                <p>Works on all devices</p>
            </div>
            <div class="feature-box">
                <div style="font-size: 48px;">&#128274;</div>
                <h3>Privacy First</h3>
                <p>Your data stays on your device</p>
            </div>
        </div>

        <!-- Mortgage & Real Estate Calculators -->
        <div class="category-section">
            <h2 class="category-title">&#127968; Mortgage & Real Estate</h2>
            <div class="calculator-grid">
                <a href="mortgage-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#127968;</div>
                    <h3>Mortgage Calculator</h3>
                    <p>Calculate monthly mortgage payments, total interest, and amortization schedule.</p>
                </a>

                <a href="mortgage-payoff-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128181;</div>
                    <h3>Mortgage Payoff Calculator</h3>
                    <p>See how extra payments can help you pay off your mortgage faster.</p>
                </a>

                <a href="va-mortgage-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#127397;</div>
                    <h3>VA Mortgage Calculator</h3>
                    <p>Calculate VA loan payments with funding fee for veterans.</p>
                </a>

                <a href="fha-loan-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#127970;</div>
                    <h3>FHA Loan Calculator</h3>
                    <p>Calculate FHA loan payments with mortgage insurance.</p>
                </a>

                <a href="rent-vs-buy-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#129309;</div>
                    <h3>Rent vs Buy Calculator</h3>
                    <p>Compare the costs of renting versus buying a home.</p>
                </a>

                <a href="real-estate-investment-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128200;</div>
                    <h3>Real Estate Investment Calculator</h3>
                    <p>Calculate ROI for rental properties and investment returns.</p>
                </a>

                <a href="rental-property-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128176;</div>
                    <h3>Rental Property Calculator</h3>
                    <p>Calculate rental income, expenses, and cash flow.</p>
                </a>

                <a href="home-affordability-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#127974;</div>
                    <h3>Home Affordability Calculator</h3>
                    <p>Find out how much house you can afford based on your income.</p>
                </a>
            </div>
        </div>

        <!-- Loan Calculators -->
        <div class="category-section">
            <h2 class="category-title">&#128179; Loan Calculators</h2>
            <div class="calculator-grid">
                <a href="loan-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128179;</div>
                    <h3>Loan Calculator</h3>
                    <p>Calculate monthly loan payments and total interest for any loan.</p>
                </a>

                <a href="auto-loan-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128663;</div>
                    <h3>Auto Loan Calculator</h3>
                    <p>Calculate car loan payments, interest, and total cost.</p>
                </a>

                <a href="personal-loan-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128181;</div>
                    <h3>Personal Loan Calculator</h3>
                    <p>Calculate personal loan payments and payoff schedule.</p>
                </a>

                <a href="student-loan-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#127891;</div>
                    <h3>Student Loan Calculator</h3>
                    <p>Calculate student loan payments and payoff strategies.</p>
                </a>

                <a href="debt-payoff-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128184;</div>
                    <h3>Debt Payoff Calculator</h3>
                    <p>Create a debt payoff plan using avalanche or snowball method.</p>
                </a>

                <a href="loan-comparison-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#9878;</div>
                    <h3>Loan Comparison Calculator</h3>
                    <p>Compare multiple loan offers side by side.</p>
                </a>
            </div>
        </div>

        <!-- Investment & Retirement Calculators -->
        <div class="category-section">
            <h2 class="category-title">&#128200; Investment & Retirement</h2>
            <div class="calculator-grid">
                <a href="investment-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128200;</div>
                    <h3>Investment Calculator</h3>
                    <p>Calculate investment returns with compound interest.</p>
                </a>

                <a href="compound-interest-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128202;</div>
                    <h3>Compound Interest Calculator</h3>
                    <p>See how compound interest grows your money over time.</p>
                </a>

                <a href="retirement-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128181;</div>
                    <h3>Retirement Calculator</h3>
                    <p>Plan for retirement and calculate how much you need to save.</p>
                </a>

                <a href="401k-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128188;</div>
                    <h3>401(k) Calculator</h3>
                    <p>Calculate 401(k) growth with employer matching.</p>
                </a>

                <a href="roth-ira-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128181;</div>
                    <h3>Roth IRA Calculator</h3>
                    <p>Calculate tax-free retirement savings with Roth IRA.</p>
                </a>

                <a href="stock-return-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128200;</div>
                    <h3>Stock Return Calculator</h3>
                    <p>Calculate stock investment returns and gains.</p>
                </a>

                <a href="dividend-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128176;</div>
                    <h3>Dividend Calculator</h3>
                    <p>Calculate dividend income and reinvestment growth.</p>
                </a>
            </div>
        </div>

        <!-- Tax Calculators -->
        <div class="category-section">
            <h2 class="category-title">&#128221; Tax Calculators</h2>
            <div class="calculator-grid">
                <a href="income-tax-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128221;</div>
                    <h3>Income Tax Calculator</h3>
                    <p>Calculate federal income tax based on your income.</p>
                </a>

                <a href="tax-return-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128220;</div>
                    <h3>Tax Return Calculator</h3>
                    <p>Calculate your tax refund or amount owed.</p>
                </a>

                <a href="self-employment-tax-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128188;</div>
                    <h3>Self-Employment Tax Calculator</h3>
                    <p>Calculate self-employment taxes for freelancers.</p>
                </a>

                <a href="sales-tax-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128184;</div>
                    <h3>Sales Tax Calculator</h3>
                    <p>Calculate sales tax amount and total price.</p>
                </a>

                <a href="vat-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128179;</div>
                    <h3>VAT Calculator</h3>
                    <p>Calculate VAT (Value Added Tax) for different countries.</p>
                </a>

                <a href="capital-gains-tax-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128200;</div>
                    <h3>Capital Gains Tax Calculator</h3>
                    <p>Calculate taxes on investment profits.</p>
                </a>
            </div>
        </div>

        <!-- Savings & Budget Calculators -->
        <div class="category-section">
            <h2 class="category-title">&#128176; Savings & Budget</h2>
            <div class="calculator-grid">
                <a href="savings-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128176;</div>
                    <h3>Savings Calculator</h3>
                    <p>Calculate how your savings grow with regular deposits.</p>
                </a>

                <a href="budget-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128179;</div>
                    <h3>Budget Calculator</h3>
                    <p>Create a monthly budget and track income vs expenses.</p>
                </a>

                <a href="emergency-fund-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128168;</div>
                    <h3>Emergency Fund Calculator</h3>
                    <p>Calculate how much emergency savings you need.</p>
                </a>

                <a href="cd-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128179;</div>
                    <h3>CD (Certificate of Deposit) Calculator</h3>
                    <p>Calculate returns on certificate of deposit investments.</p>
                </a>
            </div>
        </div>

        <!-- Salary & Income Calculators -->
        <div class="category-section">
            <h2 class="category-title">&#128176; Salary & Income</h2>
            <div class="calculator-grid">
                <a href="salary-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128176;</div>
                    <h3>Salary Calculator</h3>
                    <p>Convert between annual, monthly, and hourly salary rates.</p>
                </a>

                <a href="hourly-to-salary-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#9200;</div>
                    <h3>Hourly to Salary Calculator</h3>
                    <p>Convert hourly wage to annual salary.</p>
                </a>

                <a href="net-worth-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128181;</div>
                    <h3>Net Worth Calculator</h3>
                    <p>Calculate your total net worth (assets minus liabilities).</p>
                </a>
            </div>
        </div>

        <!-- Other Financial Calculators -->
        <div class="category-section">
            <h2 class="category-title">&#128202; Other Tools</h2>
            <div class="calculator-grid">
                <a href="inflation-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128176;</div>
                    <h3>Inflation Calculator</h3>
                    <p>Calculate how inflation affects purchasing power over time.</p>
                </a>

                <a href="credit-card-payoff-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128179;</div>
                    <h3>Credit Card Payoff Calculator</h3>
                    <p>Calculate how long it will take to pay off credit card debt.</p>
                </a>

                <a href="apr-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128202;</div>
                    <h3>APR Calculator</h3>
                    <p>Calculate Annual Percentage Rate for loans.</p>
                </a>

                <a href="discount-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#127991;</div>
                    <h3>Discount Calculator</h3>
                    <p>Calculate discounts and final sale prices.</p>
                </a>

                <a href="interest-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128200;</div>
                    <h3>Interest Calculator</h3>
                    <p>Calculate simple and compound interest.</p>
                </a>

                <a href="lease-calculator.php" class="calculator-card">
                    <div class="calculator-icon">&#128663;</div>
                    <h3>Lease Calculator</h3>
                    <p>Calculate monthly lease payments for cars.</p>
                </a>
            </div>
        </div>

        <!-- Footer Info -->
        <div style="margin: 80px 0 40px; padding: 40px; background: #f8f9fa; border-radius: 12px; text-align: center;">
            <h2 style="color: #667eea; margin-bottom: 20px;">Why Use Our Financial Calculators?</h2>
            <div style="max-width: 800px; margin: 0 auto; text-align: left; line-height: 1.8;">
                <p><strong>✓ Accurate Calculations:</strong> All calculators use industry-standard formulas and methods.</p>
                <p><strong>✓ Multi-Currency Support:</strong> Calculate in USD, INR, EUR, or GBP with proper formatting.</p>
                <p><strong>✓ Detailed Breakdowns:</strong> Get comprehensive analysis with year-by-year, month-by-month details.</p>
                <p><strong>✓ No Registration Required:</strong> Use all calculators completely free, no signup needed.</p>
                <p><strong>✓ Privacy Focused:</strong> All calculations happen in your browser - we don't store your data.</p>
                <p><strong>✓ Mobile Responsive:</strong> Works perfectly on desktop, tablet, and mobile devices.</p>
                <p><strong>✓ Educational Content:</strong> Each calculator includes tips and explanations to help you understand.</p>
            </div>
        </div>

        <div style="text-align: center; padding: 40px 0; color: #666; border-top: 1px solid #ddd;">
            <p>&copy; 2025 Financial Calculators. All rights reserved.</p>
            <p style="margin-top: 10px; font-size: 0.9em;">Free financial calculators for mortgage, loans, investments, retirement, and taxes.</p>
        </div>
    </div>
</body>
</html>