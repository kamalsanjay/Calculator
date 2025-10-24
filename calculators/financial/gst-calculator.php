<?php
/**
 * GST Calculator
 * File: gst-calculator.php
 * Description: Calculate GST (Goods and Services Tax) for India with inclusive/exclusive options
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GST Calculator India - Calculate GST Inclusive & Exclusive (5%, 12%, 18%, 28%)</title>
    <meta name="description" content="Free GST calculator for India. Calculate GST amount with inclusive/exclusive options. Supports 5%, 12%, 18%, 28% rates. Get CGST, SGST, IGST breakdown instantly.">
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
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
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
</head>
<body>
    <header>
        <h1>🧾 GST Calculator</h1>
        <p>Calculate Goods and Services Tax for India</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">← Back to Financial Calculators</a>
        </div>

        <div class="calculator-wrapper">
            <div class="calculator-section">
                <h2>GST Calculation</h2>
                <form id="gstForm">
                    <div class="form-group">
                        <label for="calculationType">Calculation Type</label>
                        <select id="calculationType">
                            <option value="exclusive">GST Exclusive (Add GST)</option>
                            <option value="inclusive">GST Inclusive (Remove GST)</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="amount">Amount (₹)</label>
                        <input type="number" id="amount" value="10000" min="0" step="0.01" required>
                        <small id="amountLabel">Original price without GST</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="gstRate">GST Rate (%)</label>
                        <select id="gstRate">
                            <option value="5">5% GST</option>
                            <option value="12">12% GST</option>
                            <option value="18" selected>18% GST</option>
                            <option value="28">28% GST</option>
                        </select>
                        <small>Select applicable GST slab</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="transactionType">Transaction Type</label>
                        <select id="transactionType">
                            <option value="intra">Intra-State (CGST + SGST)</option>
                            <option value="inter">Inter-State (IGST)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">Calculate GST</button>
                </form>
            </div>

            <div class="results-section">
                <h2>GST Breakdown</h2>
                
                <div class="result-card">
                    <h3>Total GST Amount</h3>
                    <div class="amount" id="totalGST">₹1,800</div>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <h4>Original Amount</h4>
                        <div class="value" id="originalAmount">₹10,000</div>
                    </div>
                    <div class="metric-card">
                        <h4>Final Amount</h4>
                        <div class="value" id="finalAmount">₹11,800</div>
                    </div>
                    <div class="metric-card">
                        <h4>GST Rate</h4>
                        <div class="value" id="gstRateDisplay">18%</div>
                    </div>
                    <div class="metric-card">
                        <h4>Transaction</h4>
                        <div class="value" id="transactionDisplay">Intra</div>
                    </div>
                </div>

                <div class="breakdown">
                    <h3>Amount Breakdown</h3>
                    <div class="breakdown-item">
                        <span id="baseLabel">Base Amount (Without GST)</span>
                        <strong id="baseAmount">₹10,000</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>GST Amount</span>
                        <strong id="gstAmount" style="color: #4CAF50;">₹1,800</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong id="totalLabel">Total Amount (With GST)</strong></span>
                        <strong id="totalAmount" style="color: #667eea; font-size: 1.2em;">₹11,800</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;" id="intraStateBreakdown">
                    <h3>Intra-State GST Split</h3>
                    <div class="breakdown-item">
                        <span>CGST (Central GST)</span>
                        <strong id="cgst">₹900 (9%)</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>SGST (State GST)</span>
                        <strong id="sgst">₹900 (9%)</strong>
                    </div>
                    <div class="breakdown-item" style="border-top: 2px solid #667eea; padding-top: 15px; margin-top: 10px;">
                        <span><strong>Total GST (CGST + SGST)</strong></span>
                        <strong id="totalIntraGST" style="color: #667eea;">₹1,800</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px; display:none;" id="interStateBreakdown">
                    <h3>Inter-State GST</h3>
                    <div class="breakdown-item">
                        <span>IGST (Integrated GST)</span>
                        <strong id="igst">₹1,800 (18%)</strong>
                    </div>
                </div>

                <div class="breakdown" style="margin-top: 20px;">
                    <h3>GST at Different Rates</h3>
                    <div class="breakdown-item">
                        <span>At 5% GST</span>
                        <strong id="gst5">₹10,500</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At 12% GST</span>
                        <strong id="gst12">₹11,200</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At 18% GST</span>
                        <strong id="gst18">₹11,800</strong>
                    </div>
                    <div class="breakdown-item">
                        <span>At 28% GST</span>
                        <strong id="gst28">₹12,800</strong>
                    </div>
                </div>
                
                <div class="info-box">
                    <strong>GST Formula:</strong> Add GST: Total = Amount + (Amount × GST%). Remove GST: Base = Amount – (Amount × GST% / (100 + GST%)). Intra-state: CGST+SGST. Inter-state: IGST. Common rates: 5%, 12%, 18%, 28%.
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('gstForm');
        const calculationType = document.getElementById('calculationType');
        const transactionType = document.getElementById('transactionType');
        const amountLabel = document.getElementById('amountLabel');
        const intraStateBreakdown = document.getElementById('intraStateBreakdown');
        const interStateBreakdown = document.getElementById('interStateBreakdown');

        calculationType.addEventListener('change', function() {
            if (this.value === 'exclusive') {
                amountLabel.textContent = 'Original price without GST';
            } else {
                amountLabel.textContent = 'Final price with GST included';
            }
            calculateGST();
        });

        transactionType.addEventListener('change', function() {
            if (this.value === 'intra') {
                intraStateBreakdown.style.display = 'block';
                interStateBreakdown.style.display = 'none';
            } else {
                intraStateBreakdown.style.display = 'none';
                interStateBreakdown.style.display = 'block';
            }
            calculateGST();
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateGST();
        });

        function calculateGST() {
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const gstRate = parseFloat(document.getElementById('gstRate').value) || 18;
            const calcType = calculationType.value;
            const transType = transactionType.value;

            let baseAmount, gstAmountValue, totalAmountValue;

            if (calcType === 'exclusive') {
                // Add GST
                baseAmount = amount;
                gstAmountValue = (amount * gstRate) / 100;
                totalAmountValue = amount + gstAmountValue;
            } else {
                // Remove GST
                totalAmountValue = amount;
                gstAmountValue = (amount * gstRate) / (100 + gstRate);
                baseAmount = amount - gstAmountValue;
            }

            // CGST and SGST (half each for intra-state)
            const cgstAmount = gstAmountValue / 2;
            const sgstAmount = gstAmountValue / 2;
            const cgstRate = gstRate / 2;

            // Different GST rates on base amount
            const gst5Amount = baseAmount * 1.05;
            const gst12Amount = baseAmount * 1.12;
            const gst18Amount = baseAmount * 1.18;
            const gst28Amount = baseAmount * 1.28;

            // Update UI
            document.getElementById('totalGST').textContent = formatINR(gstAmountValue);
            document.getElementById('originalAmount').textContent = formatINR(baseAmount);
            document.getElementById('finalAmount').textContent = formatINR(totalAmountValue);
            document.getElementById('gstRateDisplay').textContent = gstRate + '%';
            document.getElementById('transactionDisplay').textContent = transType === 'intra' ? 'Intra' : 'Inter';

            if (calcType === 'exclusive') {
                document.getElementById('baseLabel').textContent = 'Base Amount (Without GST)';
                document.getElementById('totalLabel').textContent = 'Total Amount (With GST)';
            } else {
                document.getElementById('baseLabel').textContent = 'Original Amount (Without GST)';
                document.getElementById('totalLabel').textContent = 'Amount Entered (With GST)';
            }

            document.getElementById('baseAmount').textContent = formatINR(baseAmount);
            document.getElementById('gstAmount').textContent = formatINR(gstAmountValue);
            document.getElementById('totalAmount').textContent = formatINR(totalAmountValue);

            document.getElementById('cgst').textContent = formatINR(cgstAmount) + ' (' + cgstRate.toFixed(1) + '%)';
            document.getElementById('sgst').textContent = formatINR(sgstAmount) + ' (' + cgstRate.toFixed(1) + '%)';
            document.getElementById('totalIntraGST').textContent = formatINR(gstAmountValue);

            document.getElementById('igst').textContent = formatINR(gstAmountValue) + ' (' + gstRate + '%)';

            document.getElementById('gst5').textContent = formatINR(gst5Amount);
            document.getElementById('gst12').textContent = formatINR(gst12Amount);
            document.getElementById('gst18').textContent = formatINR(gst18Amount);
            document.getElementById('gst28').textContent = formatINR(gst28Amount);
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
            calculateGST();
        });
    </script>
</body>
</html>