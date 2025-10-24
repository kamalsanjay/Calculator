<?php
/**
 * Income Tax Calculator
 * File: income-tax-calculator.php
 * Description: Calculate income tax for India FY 2025-26 (New Tax Regime)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Tax Calculator India FY 2025-26 - Calculate Tax & Take-Home Salary</title>
    <meta name="description" content="Free income tax calculator for India FY 2025-26. Calculate your tax liability under new tax regime, find take-home salary, and compare tax slabs.">
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
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
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
</head>
<body>
    <header>
        <h1>💰 Income Tax Calculator</h1>
        <p>Calculate your tax for FY 2025-26 (New Tax Regime)</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>Income Details</h2>
                <form id="taxForm">
                    <div class="form-group">
                        <label for="annualIncome">Annual Income (₹)</label>
                        <input type="number" id="annualIncome" value="1000000" min="0" step="10000" required>
                        <small>Gross annual income before deductions</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="standardDeduction">Standard Deduction (₹)</label>
                        <input type="number" id="standardDeduction" value="75000" min="0" step="1000">
                        <small>₹75,000 for salaried (FY 2025-26)</small>
                    </div>
                    
                    <button type="submit" class="btn">Calculate Tax</button>
                </form>
            </div>

            <div class="results-section">
                <h2>Tax Calculation</h2>
                
                <div class="result-card">
                    <h3>Total Tax Payable</h3>
                    <div class="amount" id="totalTax">₹0</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Taxable Income</h4>
                        <div class="value" id="taxableIncome">₹0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Take-Home Salary</h4>
                        <div class="value" id="takeHome">₹0</div>
                    </div>
                    <div class="metric-card">
                        <h4>Effective Tax Rate</h4>
                        <div class="value" id="effectiveRate">0%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Monthly Tax</h4>
                        <div class="value" id="monthlyTax">₹0</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Income Breakdown</h3>
                    <div class="breakdown-item">
                        <span>Gross Annual Income</span>
                        <strong id="grossIncome">₹10,00,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Standard Deduction</span>
                        <strong id="deductionAmount">-₹75,000</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Taxable Income</strong></span>
                        <strong id="taxableAmount" style="color: #667eea; font-size: 1.2em;">₹9,25,000</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Tax Slab Calculation</h3>
                    <div class="breakdown-item">
                        <span>Up to ₹4,00,000</span>
                        <strong>₹0 (0%)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>₹4,00,001 to ₹8,00,000</span>
                        <strong id="slab1">₹0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>₹8,00,001 to ₹12,00,000</span>
                        <strong id="slab2">₹0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>₹12,00,001 to ₹16,00,000</span>
                        <strong id="slab3">₹0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>₹16,00,001 to ₹20,00,000</span>
                        <strong id="slab4">₹0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>₹20,00,001 to ₹24,00,000</span>
                        <strong id="slab5">₹0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Above ₹24,00,000</span>
                        <strong id="slab6">₹0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Final Tax Summary</h3>
                    <div class="breakdown-item">
                        <span>Income Tax</span>
                        <strong id="incomeTax">₹0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Cess (4%)</span>
                        <strong id="cess">₹0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total Tax</strong></span>
                        <strong id="totalTaxAmount" style="color: #f44336; font-size: 1.2em;">₹0</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>Take-Home Analysis</h3>
                    <div class="breakdown-item">
                        <span>Gross Annual Income</span>
                        <strong id="grossAnnual">₹10,00,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Total Tax</span>
                        <strong id="taxDeducted">-₹0</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Annual Take-Home</strong></span>
                        <strong id="annualTakeHome" style="color: #4CAF50; font-size: 1.2em;">₹0</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>Monthly Take-Home</span>
                        <strong id="monthlyTakeHome">₹0</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>New Tax Regime FY 2025-26:</strong> No tax up to ₹4L. Slabs: 5% (₹4-8L), 10% (₹8-12L), 15% (₹12-16L), 20% (₹16-20L), 25% (₹20-24L), 30% (>₹24L). 4% cess applies. Standard deduction: ₹75,000 for salaried.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('taxForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateTax();
        });

        function calculateTax() {
            const annualIncome = parseFloat(document.getElementById('annualIncome').value) || 0;
            const standardDeduction = parseFloat(document.getElementById('standardDeduction').value) || 75000;

            const taxableIncome = Math.max(0, annualIncome - standardDeduction);

            // New Tax Regime FY 2025-26 Slabs
            const slabs = [
                { min: 0, max: 400000, rate: 0 },
                { min: 400000, max: 800000, rate: 5 },
                { min: 800000, max: 1200000, rate: 10 },
                { min: 1200000, max: 1600000, rate: 15 },
                { min: 1600000, max: 2000000, rate: 20 },
                { min: 2000000, max: 2400000, rate: 25 },
                { min: 2400000, max: Infinity, rate: 30 }
            ];

            let totalIncomeTax = 0;
            const slabTaxes = [];

            for (let i = 0; i < slabs.length; i++) {
                const slab = slabs[i];
                if (taxableIncome > slab.min) {
                    const taxableInSlab = Math.min(taxableIncome, slab.max) - slab.min;
                    const taxInSlab = (taxableInSlab * slab.rate) / 100;
                    slabTaxes.push(taxInSlab);
                    totalIncomeTax += taxInSlab;
                } else {
                    slabTaxes.push(0);
                }
            }

            // 4% cess
            const cess = totalIncomeTax * 0.04;
            const totalTax = totalIncomeTax + cess;

            const takeHome = annualIncome - totalTax;
            const monthlyTax = totalTax / 12;
            const monthlyTakeHome = takeHome / 12;
            const effectiveRate = annualIncome > 0 ? (totalTax / annualIncome) * 100 : 0;

            // Update UI
            document.getElementById('totalTax').textContent = formatINR(totalTax);
            document.getElementById('taxableIncome').textContent = formatINR(taxableIncome);
            document.getElementById('takeHome').textContent = formatINR(takeHome);
            document.getElementById('effectiveRate').textContent = effectiveRate.toFixed(2) + '%';
            document.getElementById('monthlyTax').textContent = formatINR(monthlyTax);

            document.getElementById('grossIncome').textContent = formatINR(annualIncome);
            document.getElementById('deductionAmount').textContent = '-' + formatINR(standardDeduction);
            document.getElementById('taxableAmount').textContent = formatINR(taxableIncome);

            // Slab breakdown
            document.getElementById('slab1').textContent = formatINR(slabTaxes[1]);
            document.getElementById('slab2').textContent = formatINR(slabTaxes[2]);
            document.getElementById('slab3').textContent = formatINR(slabTaxes[3]);
            document.getElementById('slab4').textContent = formatINR(slabTaxes[4]);
            document.getElementById('slab5').textContent = formatINR(slabTaxes[5]);
            document.getElementById('slab6').textContent = formatINR(slabTaxes[6]);

            document.getElementById('incomeTax').textContent = formatINR(totalIncomeTax);
            document.getElementById('cess').textContent = formatINR(cess);
            document.getElementById('totalTaxAmount').textContent = formatINR(totalTax);

            document.getElementById('grossAnnual').textContent = formatINR(annualIncome);
            document.getElementById('taxDeducted').textContent = '-' + formatINR(totalTax);
            document.getElementById('annualTakeHome').textContent = formatINR(takeHome);
            document.getElementById('monthlyTakeHome').textContent = formatINR(monthlyTakeHome);
        }

        function formatINR(amount) {
            return new Intl.NumberFormat('en-IN', {
                style: 'currency',
                currency: 'INR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        }

        window.addEventListener('load', function() {
            calculateTax();
        });
    </script>
</body>
</html>