<?php
/**
 * Amortization Calculator
 * File: amortization-calculator.php
 * Description: Calculate loan amortization schedule with detailed payment breakdown (USD/INR/EUR/GBP)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amortization Calculator - Loan Payment Schedule (USD/INR/EUR/GBP)</title>
    <meta name="description" content="Free amortization calculator. Generate detailed loan payment schedule showing principal and interest breakdown. Supports USD, INR, EUR, and GBP currencies.">
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
        
        .schedule-table {
            width: 100%;
            margin-top: 20px;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        
        table thead {
            background: #667eea;
            color: white;
        }
        
        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        table tbody tr:hover {
            background: #f8f9fa;
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
            
            table {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>📅 Amortization Calculator</h1>
        <p>Generate detailed loan payment schedule</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Loan Details</h2>
                <form id="amortizationForm">
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
                        <input type="number" id="loanAmount" value="200000" min="1000" step="1000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="interestRate">Annual Interest Rate (%)</label>
                        <input type="number" id="interestRate" value="7" min="0.1" max="30" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="loanTerm">Loan Term (Years)</label>
                        <input type="number" id="loanTerm" value="30" min="1" max="30" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="month" id="startDate" value="2025-01">
                    </div>
                    
                    <button type="submit" class="btn">Generate Schedule</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Amortization Summary</h2>
                
                <div class="result-card">
                    <h3>Monthly Payment</h3>
                    <div class="amount" id="monthlyPayment">$0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Principal</h4>
                        <div class="value" id="principalAmount">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Interest</h4>
                        <div class="value" id="totalInterest">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Total Payments</h4>
                        <div class="value" id="totalPayments">$0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Number of Payments</h4>
                        <div class="value" id="numPayments">360</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Loan Summary</h3>
                    <div class="breakdown-item">
                        <span>Loan Amount</span>
                        <strong id="loanAmountDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Interest Rate</span>
                        <strong id="rateDisplay">0%</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Loan Term</span>
                        <strong id="termDisplay">30 years</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Payment</span>
                        <strong id="paymentDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Interest Paid</span>
                        <strong id="interestDisplay">$0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Amount Paid</strong></span>
                        <strong id="totalDisplay" style="color: #667eea; font-size: 1.1em;">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>First vs Last Payment</h3>
                    <div class="breakdown-item">
                        <span>First Payment Principal</span>
                        <strong id="firstPrincipal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>First Payment Interest</span>
                        <strong id="firstInterest">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Last Payment Principal</span>
                        <strong id="lastPrincipal">$0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Last Payment Interest</span>
                        <strong id="lastInterest">$0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Payment Schedule (First 12 Months)</h3>
                    <div class="schedule-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Payment</th>
                                    <th>Principal</th>
                                    <th>Interest</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody id="scheduleBody">
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 20px;">Calculate to see schedule</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>Amortization Info:</strong> Early payments are mostly interest, later payments mostly principal. Extra payments reduce principal and save interest. Making 1 extra payment/year can save years off your loan. Biweekly payments = 13 monthly payments/year.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('amortizationForm');
        const currencySelect = document.getElementById('currency');

        currencySelect.addEventListener('change', function() {
            updateCurrencyLabels();
            calculateAmortization();
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
            calculateAmortization();
        });

        function calculateAmortization() {
            const loanAmount = parseFloat(document.getElementById('loanAmount').value) || 0;
            const annualRate = parseFloat(document.getElementById('interestRate').value) / 100 || 0;
            const years = parseInt(document.getElementById('loanTerm').value) || 30;
            const startDateInput = document.getElementById('startDate').value;
            const currency = currencySelect.value;

            const monthlyRate = annualRate / 12;
            const numPayments = years * 12;

            // Calculate monthly payment
            let monthlyPayment = 0;
            if (monthlyRate > 0) {
                monthlyPayment = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, numPayments)) /
                               (Math.pow(1 + monthlyRate, numPayments) - 1);
            } else {
                monthlyPayment = loanAmount / numPayments;
            }

            const totalPayments = monthlyPayment * numPayments;
            const totalInterest = totalPayments - loanAmount;

            // Generate amortization schedule
            let balance = loanAmount;
            const schedule = [];
            
            for (let i = 1; i <= numPayments; i++) {
                const interestPayment = balance * monthlyRate;
                const principalPayment = monthlyPayment - interestPayment;
                balance -= principalPayment;

                if (balance < 0) balance = 0;

                schedule.push({
                    month: i,
                    payment: monthlyPayment,
                    principal: principalPayment,
                    interest: interestPayment,
                    balance: balance
                });
            }

            // Update UI
            document.getElementById('monthlyPayment').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('principalAmount').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('totalInterest').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('totalPayments').textContent = formatCurrency(totalPayments, currency);
            document.getElementById('numPayments').textContent = numPayments;

            document.getElementById('loanAmountDisplay').textContent = formatCurrency(loanAmount, currency);
            document.getElementById('rateDisplay').textContent = annualRate.toFixed(2) + '% per annum';
            document.getElementById('termDisplay').textContent = years + ' years (' + numPayments + ' months)';
            document.getElementById('paymentDisplay').textContent = formatCurrency(monthlyPayment, currency);
            document.getElementById('interestDisplay').textContent = formatCurrency(totalInterest, currency);
            document.getElementById('totalDisplay').textContent = formatCurrency(totalPayments, currency);

            // First vs Last payment
            if (schedule.length > 0) {
                document.getElementById('firstPrincipal').textContent = formatCurrency(schedule[0].principal, currency);
                document.getElementById('firstInterest').textContent = formatCurrency(schedule[0].interest, currency);
                document.getElementById('lastPrincipal').textContent = formatCurrency(schedule[schedule.length - 1].principal, currency);
                document.getElementById('lastInterest').textContent = formatCurrency(schedule[schedule.length - 1].interest, currency);
            }

            // Build table for first 12 months
            const tbody = document.getElementById('scheduleBody');
            tbody.innerHTML = '';

            const displayMonths = Math.min(12, schedule.length);
            for (let i = 0; i < displayMonths; i++) {
                const payment = schedule[i];
                const row = tbody.insertRow();
                
                // Calculate date
                let paymentDate = '';
                if (startDateInput) {
                    const [year, month] = startDateInput.split('-');
                    const date = new Date(parseInt(year), parseInt(month) - 1 + i, 1);
                    paymentDate = date.toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
                }
                
                row.innerHTML = `
                    <td>${payment.month}</td>
                    <td>${paymentDate}</td>
                    <td>${formatCurrency(payment.payment, currency)}</td>
                    <td>${formatCurrency(payment.principal, currency)}</td>
                    <td>${formatCurrency(payment.interest, currency)}</td>
                    <td>${formatCurrency(payment.balance, currency)}</td>
                `;
            }
        }

        function formatCurrency(amount, currency) {
            const locale = currency === 'INR' ? 'en-IN' : currency === 'EUR' ? 'de-DE' : currency === 'GBP' ? 'en-GB' : 'en-US';
            return new Intl.NumberFormat(locale, {
                style: 'currency',
                currency: currency,
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(amount);
        }

        window.addEventListener('load', function() {
            updateCurrencyLabels();
            calculateAmortization();
        });
    </script>
</body>
</html>