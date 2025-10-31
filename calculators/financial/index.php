<?php
/**
 * Financial Calculators Collection
 * File: financial/index.php
 * Description: Landing page for 58+ financial and investment calculators
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Financial Calculators - 58+ Money & Investment Tools</title>
    <meta name="description" content="Complete collection of financial calculators: mortgages, loans, investments, taxes, retirement planning, and budgeting tools.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); min-height: 100vh; padding: 16px; overflow-x: hidden; }
        
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
        .search-input:focus { border-color: #2ecc71; box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1); }
        
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; margin-bottom: 24px; }
        .stat-card { background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); padding: 20px; border-radius: 12px; text-align: center; color: white; border: 2px solid rgba(255,255,255,0.3); }
        .stat-number { font-size: 2.5rem; font-weight: bold; margin-bottom: 4px; text-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stat-label { font-size: 0.9rem; opacity: 0.95; font-weight: 500; }
        
        .category { background: white; padding: 24px; border-radius: 16px; margin-bottom: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .category-header { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 3px solid #f0f0f0; flex-wrap: wrap; }
        .category-icon { font-size: 2rem; }
        .category-title { font-size: 1.4rem; font-weight: 700; color: #27ae60; flex: 1; }
        .category-count { background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }
        
        .calc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; }
        
        .calc-card { background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); padding: 18px; border-radius: 12px; border: 2px solid #e8e8e8; cursor: pointer; transition: all 0.3s; text-decoration: none; display: block; position: relative; overflow: hidden; }
        .calc-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); transition: width 0.3s; }
        .calc-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(46, 204, 113, 0.15); border-color: #2ecc71; }
        .calc-card:hover::before { width: 100%; opacity: 0.05; }
        
        .calc-icon { font-size: 2rem; margin-bottom: 10px; }
        .calc-title { font-size: 1rem; font-weight: 600; color: #333; margin-bottom: 6px; line-height: 1.3; }
        .calc-desc { font-size: 0.825rem; color: #666; line-height: 1.4; }
        .calc-badge { display: inline-block; background: rgba(46, 204, 113, 0.1); color: #27ae60; padding: 3px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; margin-top: 8px; text-transform: uppercase; }
        
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
        <h1>💰 Financial Calculators</h1>
        <p>Comprehensive collection of 58+ financial planning, investment, loan, tax, and budgeting calculators</p>
    </header>

    <div class="container">
        <div class="breadcrumb fade-in">
            <a href="../index.php">🏠 Home</a>
            <span>›</span>
            <span>Financial Calculators</span>
        </div>

        <div class="stats fade-in">
            <div class="stat-card scale-in">
                <div class="stat-number">58+</div>
                <div class="stat-label">Calculators</div>
            </div>
            <div class="stat-card scale-in">
                <div class="stat-number">8</div>
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
            <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search financial calculators..." onkeyup="filterCalculators()">
        </div>

        <!-- Mortgage & Real Estate -->
        <div class="category fade-in" data-category="mortgage">
            <div class="category-header">
                <span class="category-icon">🏠</span>
                <h2 class="category-title">Mortgage & Real Estate</h2>
                <span class="category-count">12 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="mortgage-calculator.php" class="calc-card slide-in-left" data-name="Mortgage Calculator">
                    <div class="calc-icon">🏡</div>
                    <div class="calc-title">Mortgage Calculator</div>
                    <div class="calc-desc">Calculate monthly mortgage payments with taxes and insurance.</div>
                    <span class="calc-badge">Most Popular</span>
                </a>
                <a href="home-affordability-calculator.php" class="calc-card slide-in-left" data-name="Home Affordability">
                    <div class="calc-icon">💵</div>
                    <div class="calc-title">Home Affordability</div>
                    <div class="calc-desc">Determine how much house you can afford based on income.</div>
                </a>
                <a href="rent-vs-buy-calculator.php" class="calc-card slide-in-left" data-name="Rent vs Buy">
                    <div class="calc-icon">🔑</div>
                    <div class="calc-title">Rent vs Buy Calculator</div>
                    <div class="calc-desc">Compare renting vs buying to make the best financial decision.</div>
                </a>
                <a href="mortgage-payoff-calculator.php" class="calc-card slide-in-left" data-name="Mortgage Payoff">
                    <div class="calc-icon">💳</div>
                    <div class="calc-title">Mortgage Payoff</div>
                    <div class="calc-desc">Calculate when your mortgage will be paid off and interest saved.</div>
                </a>
                <a href="refinance-calculator.php" class="calc-card slide-in-left" data-name="Refinance Calculator">
                    <div class="calc-icon">🔄</div>
                    <div class="calc-title">Refinance Calculator</div>
                    <div class="calc-desc">Analyze if refinancing your mortgage makes financial sense.</div>
                </a>
                <a href="fha-loan-calculator.php" class="calc-card slide-in-left" data-name="FHA Loan">
                    <div class="calc-icon">🏦</div>
                    <div class="calc-title">FHA Loan Calculator</div>
                    <div class="calc-desc">Calculate FHA loan payments with MIP and down payment.</div>
                </a>
                <a href="va-mortgage-calculator.php" class="calc-card slide-in-left" data-name="VA Mortgage">
                    <div class="calc-icon">🎖️</div>
                    <div class="calc-title">VA Mortgage Calculator</div>
                    <div class="calc-desc">Calculate VA loan benefits and monthly payments for veterans.</div>
                </a>
                <a href="down-payment-calculator.php" class="calc-card slide-in-left" data-name="Down Payment">
                    <div class="calc-icon">💰</div>
                    <div class="calc-title">Down Payment Calculator</div>
                    <div class="calc-desc">Calculate required down payment and closing costs.</div>
                </a>
                <a href="rental-property-calculator.php" class="calc-card slide-in-left" data-name="Rental Property">
                    <div class="calc-icon">🏢</div>
                    <div class="calc-title">Rental Property ROI</div>
                    <div class="calc-desc">Calculate rental property cash flow and investment returns.</div>
                </a>
                <a href="property-tax-calculator.php" class="calc-card slide-in-left" data-name="Property Tax">
                    <div class="calc-icon">📋</div>
                    <div class="calc-title">Property Tax Calculator</div>
                    <div class="calc-desc">Estimate annual property taxes based on location and value.</div>
                </a>
                <a href="home-equity-calculator.php" class="calc-card slide-in-left" data-name="Home Equity">
                    <div class="calc-icon">📈</div>
                    <div class="calc-title">Home Equity Calculator</div>
                    <div class="calc-desc">Calculate current home equity and borrowing power.</div>
                </a>
                <a href="real-estate-investment-calculator.php" class="calc-card slide-in-left" data-name="Real Estate Investment">
                    <div class="calc-icon">🏘️</div>
                    <div class="calc-title">Real Estate Investment</div>
                    <div class="calc-desc">Analyze investment property returns and profitability.</div>
                </a>
            </div>
        </div>

        <!-- Loans & Credit -->
        <div class="category fade-in" data-category="loans">
            <div class="category-header">
                <span class="category-icon">💳</span>
                <h2 class="category-title">Loans & Credit</h2>
                <span class="category-count">10 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="loan-calculator.php" class="calc-card slide-in-right" data-name="Loan Calculator">
                    <div class="calc-icon">💸</div>
                    <div class="calc-title">Loan Calculator</div>
                    <div class="calc-desc">Calculate loan payments with interest and amortization.</div>
                    <span class="calc-badge">Essential</span>
                </a>
                <a href="auto-loan-calculator.php" class="calc-card slide-in-right" data-name="Auto Loan">
                    <div class="calc-icon">🚗</div>
                    <div class="calc-title">Auto Loan Calculator</div>
                    <div class="calc-desc">Calculate car loan payments and total interest costs.</div>
                </a>
                <a href="personal-loan-calculator.php" class="calc-card slide-in-right" data-name="Personal Loan">
                    <div class="calc-icon">👤</div>
                    <div class="calc-title">Personal Loan</div>
                    <div class="calc-desc">Calculate personal loan payments and payoff timeline.</div>
                </a>
                <a href="student-loan-calculator.php" class="calc-card slide-in-right" data-name="Student Loan">
                    <div class="calc-icon">🎓</div>
                    <div class="calc-title">Student Loan Calculator</div>
                    <div class="calc-desc">Calculate student loan repayment and interest costs.</div>
                </a>
                <a href="business-loan-calculator.php" class="calc-card slide-in-right" data-name="Business Loan">
                    <div class="calc-icon">💼</div>
                    <div class="calc-title">Business Loan</div>
                    <div class="calc-desc">Calculate business loan payments and financing costs.</div>
                </a>
                <a href="debt-consolidation-calculator.php" class="calc-card slide-in-right" data-name="Debt Consolidation">
                    <div class="calc-icon">🔗</div>
                    <div class="calc-title">Debt Consolidation</div>
                    <div class="calc-desc">Analyze if consolidating debts will save you money.</div>
                </a>
                <a href="loan-comparison-calculator.php" class="calc-card slide-in-right" data-name="Loan Comparison">
                    <div class="calc-icon">⚖️</div>
                    <div class="calc-title">Loan Comparison</div>
                    <div class="calc-desc">Compare multiple loan offers side-by-side.</div>
                </a>
                <a href="amortization-calculator.php" class="calc-card slide-in-right" data-name="Amortization">
                    <div class="calc-icon">📊</div>
                    <div class="calc-title">Amortization Schedule</div>
                    <div class="calc-desc">Generate detailed loan payment schedule over time.</div>
                </a>
                <a href="apr-calculator.php" class="calc-card slide-in-right" data-name="APR Calculator">
                    <div class="calc-icon">%</div>
                    <div class="calc-title">APR Calculator</div>
                    <div class="calc-desc">Calculate Annual Percentage Rate including all fees.</div>
                </a>
                <a href="bi-weekly-payment-calculator.php" class="calc-card slide-in-right" data-name="Bi-weekly Payment">
                    <div class="calc-icon">📅</div>
                    <div class="calc-title">Bi-weekly Payment</div>
                    <div class="calc-desc">Calculate savings from bi-weekly loan payments.</div>
                </a>
            </div>
        </div>

        <!-- Investment & Retirement -->
        <div class="category fade-in" data-category="investment">
            <div class="category-header">
                <span class="category-icon">📈</span>
                <h2 class="category-title">Investment & Retirement</h2>
                <span class="category-count">12 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="investment-calculator.php" class="calc-card slide-in-left" data-name="Investment Calculator">
                    <div class="calc-icon">💹</div>
                    <div class="calc-title">Investment Calculator</div>
                    <div class="calc-desc">Calculate investment growth with compound returns.</div>
                </a>
                <a href="compound-interest-calculator.php" class="calc-card slide-in-left" data-name="Compound Interest">
                    <div class="calc-icon">📊</div>
                    <div class="calc-title">Compound Interest</div>
                    <div class="calc-desc">Calculate compound interest with multiple compounding periods.</div>
                </a>
                <a href="roi-calculator.php" class="calc-card slide-in-left" data-name="ROI Calculator">
                    <div class="calc-icon">💎</div>
                    <div class="calc-title">ROI Calculator</div>
                    <div class="calc-desc">Calculate return on investment percentage and gains.</div>
                </a>
                <a href="stock-return-calculator.php" class="calc-card slide-in-left" data-name="Stock Return">
                    <div class="calc-icon">📉</div>
                    <div class="calc-title">Stock Return Calculator</div>
                    <div class="calc-desc">Calculate stock investment returns and capital gains.</div>
                </a>
                <a href="dividend-calculator.php" class="calc-card slide-in-left" data-name="Dividend Calculator">
                    <div class="calc-icon">💵</div>
                    <div class="calc-title">Dividend Calculator</div>
                    <div class="calc-desc">Calculate dividend income and reinvestment growth.</div>
                </a>
                <a href="retirement-calculator.php" class="calc-card slide-in-left" data-name="Retirement Calculator">
                    <div class="calc-icon">🏖️</div>
                    <div class="calc-title">Retirement Calculator</div>
                    <div class="calc-desc">Plan retirement savings and calculate nest egg needed.</div>
                    <span class="calc-badge">Popular</span>
                </a>
                <a href="401k-calculator.php" class="calc-card slide-in-left" data-name="401k Calculator">
                    <div class="calc-icon">🏢</div>
                    <div class="calc-title">401(k) Calculator</div>
                    <div class="calc-desc">Calculate 401k contributions and employer match.</div>
                </a>
                <a href="ira-calculator.php" class="calc-card slide-in-left" data-name="IRA Calculator">
                    <div class="calc-icon">🏦</div>
                    <div class="calc-title">IRA Calculator</div>
                    <div class="calc-desc">Calculate traditional IRA growth and tax benefits.</div>
                </a>
                <a href="roth-ira-calculator.php" class="calc-card slide-in-left" data-name="Roth IRA">
                    <div class="calc-icon">💰</div>
                    <div class="calc-title">Roth IRA Calculator</div>
                    <div class="calc-desc">Calculate Roth IRA contributions and tax-free growth.</div>
                </a>
                <a href="annuity-calculator.php" class="calc-card slide-in-left" data-name="Annuity Calculator">
                    <div class="calc-icon">📆</div>
                    <div class="calc-title">Annuity Calculator</div>
                    <div class="calc-desc">Calculate annuity payments and present value.</div>
                </a>
                <a href="bond-calculator.php" class="calc-card slide-in-left" data-name="Bond Calculator">
                    <div class="calc-icon">📜</div>
                    <div class="calc-title">Bond Calculator</div>
                    <div class="calc-desc">Calculate bond yields, prices, and interest payments.</div>
                </a>
                <a href="mutual-fund-calculator.php" class="calc-card slide-in-left" data-name="Mutual Fund">
                    <div class="calc-icon">📊</div>
                    <div class="calc-title">Mutual Fund Calculator</div>
                    <div class="calc-desc">Calculate mutual fund returns with SIP and lump sum.</div>
                </a>
            </div>
        </div>

        <!-- Tax Calculators -->
        <div class="category fade-in" data-category="tax">
            <div class="category-header">
                <span class="category-icon">🧾</span>
                <h2 class="category-title">Tax Calculators</h2>
                <span class="category-count">11 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="income-tax-calculator.php" class="calc-card slide-in-right" data-name="Income Tax">
                    <div class="calc-icon">💼</div>
                    <div class="calc-title">Income Tax Calculator</div>
                    <div class="calc-desc">Calculate federal and state income tax liability.</div>
                    <span class="calc-badge">Essential</span>
                </a>
                <a href="sales-tax-calculator.php" class="calc-card slide-in-right" data-name="Sales Tax">
                    <div class="calc-icon">🛒</div>
                    <div class="calc-title">Sales Tax Calculator</div>
                    <div class="calc-desc">Calculate sales tax on purchases by state and rate.</div>
                </a>
                <a href="salary-calculator.php" class="calc-card slide-in-right" data-name="Salary Calculator">
                    <div class="calc-icon">💵</div>
                    <div class="calc-title">Salary Calculator</div>
                    <div class="calc-desc">Convert hourly, weekly, monthly, and annual salary.</div>
                </a>
                <a href="paycheck-calculator.php" class="calc-card slide-in-right" data-name="Paycheck Calculator">
                    <div class="calc-icon">💰</div>
                    <div class="calc-title">Paycheck Calculator</div>
                    <div class="calc-desc">Calculate take-home pay after taxes and deductions.</div>
                </a>
                <a href="tax-return-calculator.php" class="calc-card slide-in-right" data-name="Tax Return">
                    <div class="calc-icon">📑</div>
                    <div class="calc-title">Tax Return Calculator</div>
                    <div class="calc-desc">Estimate tax refund or amount owed for the year.</div>
                </a>
                <a href="capital-gains-tax-calculator.php" class="calc-card slide-in-right" data-name="Capital Gains Tax">
                    <div class="calc-icon">📈</div>
                    <div class="calc-title">Capital Gains Tax</div>
                    <div class="calc-desc">Calculate taxes on investment and asset sales.</div>
                </a>
                <a href="gst-calculator.php" class="calc-card slide-in-right" data-name="GST Calculator">
                    <div class="calc-icon">🇮🇳</div>
                    <div class="calc-title">GST Calculator</div>
                    <div class="calc-desc">Calculate Goods and Services Tax in India.</div>
                </a>
                <a href="vat-calculator.php" class="calc-card slide-in-right" data-name="VAT Calculator">
                    <div class="calc-icon">🇪🇺</div>
                    <div class="calc-title">VAT Calculator</div>
                    <div class="calc-desc">Calculate Value Added Tax for European countries.</div>
                </a>
                <a href="self-employment-tax-calculator.php" class="calc-card slide-in-right" data-name="Self-Employment Tax">
                    <div class="calc-icon">👨‍💼</div>
                    <div class="calc-title">Self-Employment Tax</div>
                    <div class="calc-desc">Calculate SE tax for freelancers and contractors.</div>
                </a>
                <a href="bonus-tax-calculator.php" class="calc-card slide-in-right" data-name="Bonus Tax">
                    <div class="calc-icon">🎁</div>
                    <div class="calc-title">Bonus Tax Calculator</div>
                    <div class="calc-desc">Calculate tax withholding on bonus payments.</div>
                </a>
            </div>
        </div>

        <!-- Interest & Rates -->
        <div class="category fade-in" data-category="interest">
            <div class="category-header">
                <span class="category-icon">📊</span>
                <h2 class="category-title">Interest & Payment</h2>
                <span class="category-count">3 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="interest-calculator.php" class="calc-card slide-in-left" data-name="Interest Calculator">
                    <div class="calc-icon">💳</div>
                    <div class="calc-title">Interest Calculator</div>
                    <div class="calc-desc">Calculate simple and compound interest earnings.</div>
                </a>
                <a href="interest-rate-calculator.php" class="calc-card slide-in-left" data-name="Interest Rate">
                    <div class="calc-icon">%</div>
                    <div class="calc-title">Interest Rate Calculator</div>
                    <div class="calc-desc">Calculate effective interest rate from APR and fees.</div>
                </a>
                <a href="payment-calculator.php" class="calc-card slide-in-left" data-name="Payment Calculator">
                    <div class="calc-icon">💵</div>
                    <div class="calc-title">Payment Calculator</div>
                    <div class="calc-desc">Calculate monthly payments for any loan amount.</div>
                </a>
            </div>
        </div>

        <!-- Economics -->
        <div class="category fade-in" data-category="economics">
            <div class="category-header">
                <span class="category-icon">💹</span>
                <h2 class="category-title">Economics & Currency</h2>
                <span class="category-count">3 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="inflation-calculator.php" class="calc-card slide-in-right" data-name="Inflation Calculator">
                    <div class="calc-icon">📈</div>
                    <div class="calc-title">Inflation Calculator</div>
                    <div class="calc-desc">Calculate purchasing power and inflation adjusted values.</div>
                </a>
                <a href="currency-converter.php" class="calc-card slide-in-right" data-name="Currency Converter">
                    <div class="calc-icon">💱</div>
                    <div class="calc-title">Currency Converter</div>
                    <div class="calc-desc">Convert between currencies with live exchange rates.</div>
                </a>
                <a href="finance-calculator.php" class="calc-card slide-in-right" data-name="Finance Calculator">
                    <div class="calc-icon">💼</div>
                    <div class="calc-title">Finance Calculator</div>
                    <div class="calc-desc">All-in-one financial calculator for various needs.</div>
                </a>
            </div>
        </div>

        <!-- Budget & Savings -->
        <div class="category fade-in" data-category="budget">
            <div class="category-header">
                <span class="category-icon">💸</span>
                <h2 class="category-title">Budget & Savings</h2>
                <span class="category-count">3 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="budget-calculator.php" class="calc-card slide-in-left" data-name="Budget Calculator">
                    <div class="calc-icon">📋</div>
                    <div class="calc-title">Budget Calculator</div>
                    <div class="calc-desc">Create and track monthly budget and expenses.</div>
                </a>
                <a href="savings-calculator.php" class="calc-card slide-in-left" data-name="Savings Calculator">
                    <div class="calc-icon">🏦</div>
                    <div class="calc-title">Savings Calculator</div>
                    <div class="calc-desc">Calculate savings growth with regular deposits.</div>
                </a>
                <a href="emergency-fund-calculator.php" class="calc-card slide-in-left" data-name="Emergency Fund">
                    <div class="calc-icon">🆘</div>
                    <div class="calc-title">Emergency Fund</div>
                    <div class="calc-desc">Calculate recommended emergency fund size.</div>
                </a>
            </div>
        </div>

        <!-- Business & Other -->
        <div class="category fade-in" data-category="business">
            <div class="category-header">
                <span class="category-icon">💼</span>
                <h2 class="category-title">Business & Other</h2>
                <span class="category-count">4 Tools</span>
            </div>
            <div class="calc-grid">
                <a href="tip-calculator.php" class="calc-card slide-in-right" data-name="Tip Calculator">
                    <div class="calc-icon">🍽️</div>
                    <div class="calc-title">Tip Calculator</div>
                    <div class="calc-desc">Calculate tip and split bill among people.</div>
                </a>
                <a href="discount-calculator.php" class="calc-card slide-in-right" data-name="Discount Calculator">
                    <div class="calc-icon">🏷️</div>
                    <div class="calc-title">Discount Calculator</div>
                    <div class="calc-desc">Calculate discounted price and savings amount.</div>
                </a>
                <a href="profit-margin-calculator.php" class="calc-card slide-in-right" data-name="Profit Margin">
                    <div class="calc-icon">💹</div>
                    <div class="calc-title">Profit Margin</div>
                    <div class="calc-desc">Calculate gross and net profit margins for business.</div>
                </a>
                <a href="break-even-calculator.php" class="calc-card slide-in-right" data-name="Break Even">
                    <div class="calc-icon">⚖️</div>
                    <div class="calc-title">Break-Even Calculator</div>
                    <div class="calc-desc">Calculate break-even point for business profitability.</div>
                </a>
                <a href="net-worth-calculator.php" class="calc-card slide-in-right" data-name="Net Worth">
                    <div class="calc-icon">💎</div>
                    <div class="calc-title">Net Worth Calculator</div>
                    <div class="calc-desc">Calculate total net worth from assets and liabilities.</div>
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
        <p>💰 Financial Calculators | 58+ Free Tools</p>
        <p style="margin-top: 8px; font-size: 0.875rem;">Financial calculators are for informational purposes. Consult financial advisors for personalized advice.</p>
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