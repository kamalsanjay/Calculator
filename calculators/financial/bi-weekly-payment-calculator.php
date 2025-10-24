<?php
/**
 * Bi-weekly Payment Calculator
 * File: bi-weekly-payment-calculator.php
 * Description: Calculate savings from bi-weekly loan payments (USD/INR/EUR/GBP)
 */

$page_title = "Bi-weekly Payment Calculator - Save with Biweekly Payments (USD/INR/EUR/GBP)";
$page_description = "Free bi-weekly payment calculator. Calculate interest saved with biweekly payments vs monthly. Make 13 payments per year automatically. Supports USD, INR, EUR, GBP.";

include 'includes/header.php';
?>

<header>
    <h1>📅 Bi-weekly Payment Calculator</h1>
    <p>Calculate savings from making bi-weekly loan payments</p>
</header>
<style>
	* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
    background: #f5f5f5;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 40px 20px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

header h1 {
    font-size: 2.5em;
    margin-bottom: 10px;
}

header p {
    font-size: 1.2em;
    opacity: 0.9;
}

.breadcrumb {
    margin: 20px 0;
}

.breadcrumb a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s;
}

.breadcrumb a:hover {
    color: #5568d3;
}

.calculator-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-top: 30px;
}

.calculator-section,
.results-section {
    background: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.calculator-section h2,
.results-section h2 {
    color: #667eea;
    margin-bottom: 25px;
    font-size: 1.8em;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #555;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #667eea;
}

.form-group small {
    display: block;
    margin-top: 5px;
    color: #888;
    font-size: 0.9em;
}

.btn {
    background: #667eea;
    color: white;
    padding: 15px 30px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    transition: background 0.3s;
}

.btn:hover {
    background: #5568d3;
}

.result-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px;
    border-radius: 10px;
    margin-bottom: 20px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.result-card.success {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
}

.result-card h3 {
    font-size: 1.2em;
    opacity: 0.9;
    margin-bottom: 10px;
    font-weight: 400;
}

.result-card .amount {
    font-size: 3em;
    font-weight: bold;
}

.metric-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-bottom: 20px;
}

.metric-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    border: 2px solid #e0e0e0;
}

.metric-card h4 {
    color: #666;
    font-size: 0.9em;
    margin-bottom: 10px;
    font-weight: 400;
}

.metric-card .value {
    color: #667eea;
    font-size: 2em;
    font-weight: bold;
}

.breakdown {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-top: 20px;
}

.breakdown h3 {
    color: #667eea;
    margin-bottom: 15px;
    font-size: 1.3em;
}

.breakdown-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #e0e0e0;
}

.breakdown-item:last-child {
    border-bottom: none;
}

.breakdown-item span {
    color: #666;
}

.breakdown-item strong {
    color: #333;
    font-weight: 600;
}

.info-box {
    background: #e3f2fd;
    border-left: 4px solid #2196F3;
    padding: 15px;
    margin: 20px 0;
    border-radius: 5px;
}

.info-box strong {
    color: #1976D2;
}

@media (max-width: 768px) {
    .calculator-wrapper {
        grid-template-columns: 1fr;
    }
    
    header h1 {
        font-size: 2em;
    }
    
    .result-card .amount {
        font-size: 2.5em;
    }
    
    .metric-grid {
        grid-template-columns: 1fr;
    }
}
 </style>
<div class="container">
    <div class="breadcrumb">
        <a href="index.php">← Back to Financial Calculators</a>
    </div>

    <div class="calculator-wrapper">
        <div class="calculator-section">
            <h2>Loan Details</h2>
            <form id="biweeklyForm">
                <div class="form-group">
                    <label for="currency">Currency</label>
                    <select id="currency">
                        <option value="USD">USD ($)</option>
                        <option value="INR">INR (₹)</option>
                        <option value="EUR">EUR (€)</option>
                        <option value="GBP">GBP (£)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="loanAmount">Loan Amount (<span id="currencyLabel1">$</span>)</label>
                    <input type="number" id="loanAmount" value="200000" min="10000" step="1000" required>
                </div>
                
                <div class="form-group">
                    <label for="interestRate">Interest Rate (% per annum)</label>
                    <input type="number" id="interestRate" value="7" min="1" max="20" step="0.1" required>
                </div>
                
                <div class="form-group">
                    <label for="loanTerm">Loan Term (Years)</label>
                    <input type="number" id="loanTerm" value="30" min="5" max="30" step="1" required>
                </div>
                
                <button type="submit" class="btn">Calculate Bi-weekly Savings</button>
            </form>
        </div>

        <div class="results-section">
            <h2>Bi-weekly Payment Impact</h2>
            
            <div class="result-card success">
                <h3>Total Interest Saved</h3>
                <div class="amount" id="interestSaved">$0</div>
            </div>

            <div class="metric-grid">
                <div class="metric-card">
                    <h4>Time Saved</h4>
                    <div class="value" id="timeSaved">0 yrs</div>
                </div>
                <div class="metric-card">
                    <h4>Bi-weekly Payment</h4>
                    <div class="value" id="biweeklyPayment">$0</div>
                </div>
                <div class="metric-card">
                    <h4>Annual Payments</h4>
                    <div class="value" id="annualPayments">26</div>
                </div>
                <div class="metric-card">
                    <h4>Payoff Time</h4>
                    <div class="value" id="payoffTime">0 yrs</div>
                </div>
            </div>

            <div class="breakdown">
                <h3>Monthly Payment Plan</h3>
                <div class="breakdown-item">
                    <span>Monthly Payment</span>
                    <strong id="monthlyPayment">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Payments Per Year</span>
                    <strong>12 payments</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Payments</span>
                    <strong id="monthlyTotalPayments">360</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Paid</span>
                    <strong id="monthlyTotalPaid">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Interest</span>
                    <strong id="monthlyInterest">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Payoff Time</span>
                    <strong id="monthlyPayoff">30 years</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Bi-weekly Payment Plan</h3>
                <div class="breakdown-item">
                    <span>Bi-weekly Payment</span>
                    <strong id="biweeklyAmount" style="color: #4CAF50;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Payments Per Year</span>
                    <strong>26 payments (13 months)</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Payments</span>
                    <strong id="biweeklyTotalPayments">0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Paid</span>
                    <strong id="biweeklyTotalPaid">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Total Interest</span>
                    <strong id="biweeklyInterest">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Payoff Time</span>
                    <strong id="biweeklyPayoff" style="color: #4CAF50;">0 years</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Comparison Summary</h3>
                <div class="breakdown-item">
                    <span>Interest Saved</span>
                    <strong id="savedInterest" style="color: #4CAF50; font-size: 1.1em;">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Time Saved</span>
                    <strong id="savedTime" style="color: #4CAF50;">0 years</strong>
                </div>
                <div class="breakdown-item">
                    <span>Months Saved</span>
                    <strong id="monthsSaved">0 months</strong>
                </div>
                <div class="breakdown-item">
                    <span>Extra Annual Payment</span>
                    <strong id="extraPayment">1 extra payment/year</strong>
                </div>
            </div>

            <div class="breakdown" style="margin-top: 20px;">
                <h3>Annual Cost Comparison</h3>
                <div class="breakdown-item">
                    <span>Monthly Plan (Annual)</span>
                    <strong id="monthlyAnnual">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Bi-weekly Plan (Annual)</span>
                    <strong id="biweeklyAnnual">$0</strong>
                </div>
                <div class="breakdown-item">
                    <span>Annual Difference</span>
                    <strong id="annualDiff" style="color: #FF9800;">$0</strong>
                </div>
            </div>
            
            <div class="info-box">
                <strong>Bi-weekly Payment Benefits:</strong> Makes 26 half-payments = 13 full payments per year (1 extra). Reduces principal faster, saves interest. Aligns with bi-weekly paychecks. No extra effort after setup. Simple way to pay off loan 4-6 years early on 30-year mortgage.
            </div>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('biweeklyForm');
    const currencySelect = document.getElementById('currency');

    currencySelect.addEventListener('change', function() {
        updateCurrencyLabels();
        calculateBiweekly();
    });

    function updateCurrencyLabels() {
        const currency = currencySelect.value;
        const symbols = {
            'USD': '$',
            'INR': '₹',
            'EUR': '€',
            'GBP': '£'
        };
        const symbol = symbols[currency];
        document.getElementById('currencyLabel1').textContent = symbol;
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        calculateBiweekly();
    });

    function calculateBiweekly() {
        const loanAmount = parseFloat(document.getElementById('loanAmount').value) || 0;
        const annualRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0;
        const loanTerm = parseInt(document.getElementById('loanTerm').value) || 30;
        const currency = currencySelect.value;

        const monthlyRate = annualRate / 12;
        const numberOfMonths = loanTerm * 12;

        // Monthly payment calculation
        let monthlyPayment = 0;
        if (monthlyRate > 0) {
            monthlyPayment = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, numberOfMonths)) /
                           (Math.pow(1 + monthlyRate, numberOfMonths) - 1);
        } else {
            monthlyPayment = loanAmount / numberOfMonths;
        }

        const monthlyTotalPaid = monthlyPayment * numberOfMonths;
        const monthlyInterest = monthlyTotalPaid - loanAmount;

        // Bi-weekly payment (half of monthly)
        const biweeklyPayment = monthlyPayment / 2;
        const biweeklyRate = annualRate / 26; // 26 bi-weekly periods per year

        // Calculate payoff time with bi-weekly payments
        let balance = loanAmount;
        let biweeklyPaymentsCount = 0;
        let totalInterestPaid = 0;

        while (balance > 0 && biweeklyPaymentsCount < numberOfMonths * 2) {
            const interestPayment = balance * biweeklyRate;
            const principalPayment = biweeklyPayment - interestPayment;
            
            totalInterestPaid += interestPayment;
            balance -= principalPayment;
            biweeklyPaymentsCount++;

            if (balance < 0) balance = 0;
        }

        const biweeklyTotalPaid = biweeklyPayment * biweeklyPaymentsCount;
        const interestSaved = monthlyInterest - totalInterestPaid;
        const paymentsSaved = numberOfMonths - (biweeklyPaymentsCount / 2);
        const yearsSaved = paymentsSaved / 12;
        const biweeklyYears = (biweeklyPaymentsCount / 26);

        const monthlyAnnualCost = monthlyPayment * 12;
        const biweeklyAnnualCost = biweeklyPayment * 26;
        const annualDifference = biweeklyAnnualCost - monthlyAnnualCost;

        // Update UI
        document.getElementById('interestSaved').textContent = formatCurrency(interestSaved, currency);
        document.getElementById('timeSaved').textContent = yearsSaved.toFixed(1) + ' yrs';
        document.getElementById('biweeklyPayment').textContent = formatCurrency(biweeklyPayment, currency);
        document.getElementById('annualPayments').textContent = '26';
        document.getElementById('payoffTime').textContent = biweeklyYears.toFixed(1) + ' yrs';

        document.getElementById('monthlyPayment').textContent = formatCurrency(monthlyPayment, currency);
        document.getElementById('monthlyTotalPayments').textContent = numberOfMonths + ' payments';
        document.getElementById('monthlyTotalPaid').textContent = formatCurrency(monthlyTotalPaid, currency);
        document.getElementById('monthlyInterest').textContent = formatCurrency(monthlyInterest, currency);
        document.getElementById('monthlyPayoff').textContent = loanTerm + ' years';

        document.getElementById('biweeklyAmount').textContent = formatCurrency(biweeklyPayment, currency);
        document.getElementById('biweeklyTotalPayments').textContent = biweeklyPaymentsCount + ' payments';
        document.getElementById('biweeklyTotalPaid').textContent = formatCurrency(biweeklyTotalPaid, currency);
        document.getElementById('biweeklyInterest').textContent = formatCurrency(totalInterestPaid, currency);
        document.getElementById('biweeklyPayoff').textContent = biweeklyYears.toFixed(1) + ' years';

        document.getElementById('savedInterest').textContent = formatCurrency(interestSaved, currency);
        document.getElementById('savedTime').textContent = yearsSaved.toFixed(1) + ' years';
        document.getElementById('monthsSaved').textContent = Math.round(paymentsSaved) + ' months';
        document.getElementById('extraPayment').textContent = '1 extra payment/year';

        document.getElementById('monthlyAnnual').textContent = formatCurrency(monthlyAnnualCost, currency);
        document.getElementById('biweeklyAnnual').textContent = formatCurrency(biweeklyAnnualCost, currency);
        document.getElementById('annualDiff').textContent = formatCurrency(annualDifference, currency);
    }

    function formatCurrency(amount, currency) {
        const locale = currency === 'INR' ? 'en-IN' : currency === 'EUR' ? 'de-DE' : currency === 'GBP' ? 'en-GB' : 'en-US';
        return new Intl.NumberFormat(locale, {
            style: 'currency',
            currency: currency,
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount);
    }

    window.addEventListener('load', function() {
        updateCurrencyLabels();
        calculateBiweekly();
    });
</script>

<?php include 'includes/footer.php'; ?>