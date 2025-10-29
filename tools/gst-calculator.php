// <?php
// require('../header.php');
// ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online GST Calculator India | Accurate GST Calculation Tool</title>
    <meta name="description" content="Use our free GST calculator to easily calculate GST on products and services. Get accurate results for GST inclusive or exclusive calculations.">
    <meta name="keywords" content="GST calculator, calculate GST, GST tax calculator, GST calculation tool, GST inclusive, GST exclusive, GST on products, India GST calculator, GST rate calculator">
    <link rel="canonical" href="https://infinitytoolspace.com/tools/gst-calculator" />
    
    <meta property="og:title" content="GST Calculator - Calculate Goods and Services Tax (GST)" />
<meta property="og:description" content="Easily calculate GST on any product or service with our free GST calculator tool. Get accurate results for both inclusive and exclusive GST." />
<meta property="og:url" content="https://infinitytoolspace.com/tools/gst-calculator" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEh6XilB0y92f0_6fIvIaaV8YkMDkzjPdZtzq0gcAg60Hto6ws1Lx-kJVAEWfwXV4iIEHayYDs3FVl-jn6IGeh8weo6__QndOrxDk1Cz7qcW5TFWIg4XnwkgMIJyCCiKZlsJqlw923XrKCOEiovWxnfC1vgTstw2orPbTllvP8kOTHKdnN_uhyphenhyphennV3xjA218/s16000/GST%20Calculator%20Online.jpg" />

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H09G89QP02"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H09G89QP02');
</script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #f72585;
            --light-color: #f8f9fa;
            --border-radius: 12px;
            --box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7ff;
            color: #333;
        }
        
        .calculator-card {
            background: #ffffff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            overflow: hidden;
            border: none;
        }
        
        .calculator-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }
        
        .gradient-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .gradient-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(30deg);
        }
        
        .calculator-input {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: var(--transition);
            box-shadow: none;
        }
        
        .calculator-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .input-with-icon {
            padding-left: 40px;
        }
        
        .calculate-btn {
            background: var(--primary-color);
            border: none;
            padding: 14px 30px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 10px;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }
        
        .calculate-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
        }
        
        .result-card {
            background: var(--light-color);
            border-radius: var(--border-radius);
            border-left: 4px solid var(--primary-color);
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .result-value {
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .preset-btn {
            border: 2px solid #e9ecef;
            background: white;
            border-radius: 8px;
            transition: var(--transition);
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .preset-btn:hover, .preset-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .toggle-container {
            display: flex;
            background: #f1f3f9;
            border-radius: 10px;
            padding: 4px;
            margin-bottom: 1rem;
        }
        
        .toggle-option {
            flex: 1;
            text-align: center;
            padding: 10px;
            cursor: pointer;
            border-radius: 8px;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .toggle-option.active {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .info-tooltip {
            cursor: pointer;
            color: #6c757d;
            transition: var(--transition);
        }
        
        .info-tooltip:hover {
            color: var(--primary-color);
        }
        
        .comparison-table {
            border-radius: var(--border-radius);
            overflow: hidden;
        }
        
        .comparison-table th {
            background: var(--primary-color);
            color: white;
        }
        
        .custom-tooltip {
            position: relative;
            display: inline-block;
        }
        
        .tooltip-text {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.8rem;
        }
        
        .custom-tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
        
        .result-animation {
            transform: scale(0.95);
            opacity: 0;
            transition: all 0.5s ease;
        }
        
        .result-animation.show {
            transform: scale(1);
            opacity: 1;
        }
        
        .feature-icon {
            width: 50px;
            height: 50px;
            background: rgba(67, 97, 238, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .history-item {
            border-radius: 10px;
            border-left: 3px solid var(--primary-color);
            transition: var(--transition);
            cursor: pointer;
        }
        
        .history-item:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transform: translateY(-2px);
        }
        
        .seo-content {
            border-top: 1px solid #e9ecef;
            padding-top: 2rem;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="calculator-card mb-4">
                    <div class="gradient-header text-white">
                        <h1 class="h3 mb-0 fw-bold">GST Calculator</h1>
                        <p class="mb-0 opacity-75">Calculate Goods and Services Tax instantly</p>
                    </div>
                    <div class="p-4">
                        <!-- GST Type Toggle -->
                        <div class="toggle-container mb-4">
                            <div class="toggle-option active" data-type="exclusive">GST Exclusive</div>
                            <div class="toggle-option" data-type="inclusive">GST Inclusive</div>
                        </div>
                        
                        <form id="gstForm">
                            <div class="mb-4">
                                <label class="form-label fw-bold d-flex align-items-center">
                                    Amount
                                    <span class="custom-tooltip ms-2">
                                        <i class="fas fa-info-circle info-tooltip"></i>
                                        <span class="tooltip-text">Enter the price amount for GST calculation</span>
                                    </span>
                                </label>
                                <div class="position-relative">
                                    <i class="fas fa-rupee-sign input-icon"></i>
                                    <input type="number" class="form-control calculator-input input-with-icon" 
                                        id="amount" name="amount" step="0.01" min="0" required 
                                        placeholder="Enter amount">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold d-flex align-items-center">
                                    GST Rate
                                    <span class="custom-tooltip ms-2">
                                        <i class="fas fa-info-circle info-tooltip"></i>
                                        <span class="tooltip-text">Select or enter the applicable GST rate</span>
                                    </span>
                                </label>
                                
                                <!-- GST Rate Presets -->
                                <div class="d-flex gap-2 mb-3">
                                    <button type="button" class="btn preset-btn flex-grow-1 gst-preset" data-rate="5">5%</button>
                                    <button type="button" class="btn preset-btn flex-grow-1 gst-preset" data-rate="12">12%</button>
                                    <button type="button" class="btn preset-btn flex-grow-1 gst-preset" data-rate="18">18%</button>
                                    <button type="button" class="btn preset-btn flex-grow-1 gst-preset" data-rate="28">28%</button>
                                </div>
                                
                                <div class="input-group">
                                    <input type="number" class="form-control calculator-input" 
                                        id="gstRate" name="gst_rate" min="0" max="100" step="0.1" 
                                        required value="18">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            
                            <!-- Hidden field to store the GST type -->
                            <input type="hidden" id="type" name="type" value="exclusive">
                            
                            <button type="submit" class="btn calculate-btn w-100 text-white">
                                <i class="fas fa-calculator me-2"></i> Calculate GST
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="result-card p-4 mb-4 result-animation" id="resultSection" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h5 mb-0">Calculation Result</h3>
                        <div>
                            <button class="btn btn-sm btn-outline-primary me-2" id="saveBtn">
                                <i class="fas fa-save me-1"></i> Save
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" id="shareBtn">
                                <i class="fas fa-share-alt me-1"></i> Share
                            </button>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="bg-white p-3 rounded shadow-sm">
                                <small class="text-muted d-block">Net Amount</small>
                                <span class="d-block result-value" id="netAmount">₹0.00</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="bg-white p-3 rounded shadow-sm">
                                <small class="text-muted d-block">GST Amount</small>
                                <span class="d-block result-value" id="gstAmount">₹0.00</span>
                                <small class="text-muted" id="gstRateDisplay">at 18%</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="bg-white p-3 rounded shadow-sm">
                                <small class="text-muted d-block">Total Amount</small>
                                <span class="d-block result-value" id="totalAmount">₹0.00</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Breakdown -->
                    <div class="mt-3">
                        <div class="bg-white p-3 rounded shadow-sm">
                            <h4 class="h6 mb-3">GST Breakdown</h4>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted d-block">CGST (50%)</small>
                                    <span class="d-block" id="cgstAmount">₹0.00</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">SGST (50%)</small>
                                    <span class="d-block" id="sgstAmount">₹0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- New Feature: Calculation History -->
                <div class="calculator-card mb-4">
                    <div class="p-3 bg-light border-bottom">
                        <h3 class="h5 mb-0">Recent Calculations</h3>
                    </div>
                    <div class="p-3" id="historyContainer">
                        <p class="text-center text-muted my-3">No recent calculations</p>
                    </div>
                </div>
                
                <!-- New Feature: GST Comparison Table -->
                <div class="calculator-card mb-4">
                    <div class="p-3 bg-light border-bottom">
                        <h3 class="h5 mb-0">GST Rate Comparison</h3>
                    </div>
                    <div class="p-3">
                        <div class="table-responsive">
                            <table class="table table-bordered comparison-table">
                                <thead>
                                    <tr>
                                        <th>GST Rate</th>
                                        <th>Net Amount</th>
                                        <th>GST Amount</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="comparisonTableBody">
                                    <tr>
                                        <td colspan="4" class="text-center">Enter an amount to see comparison</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="row mb-5">
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-white rounded shadow-sm h-100">
                            <div class="feature-icon">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <h4 class="h6">Instant Calculation</h4>
                            <p class="text-muted small mb-0">Get results immediately with our powerful calculation engine</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-white rounded shadow-sm h-100">
                            <div class="feature-icon">
                                <i class="fas fa-history"></i>
                            </div>
                            <h4 class="h6">Save History</h4>
                            <p class="text-muted small mb-0">Access your previous calculations anytime</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-white rounded shadow-sm h-100">
                            <div class="feature-icon">
                                <i class="fas fa-share-alt"></i>
                            </div>
                            <h4 class="h6">Share Results</h4>
                            <p class="text-muted small mb-0">Share calculation results with colleagues or clients easily</p>
                        </div>
                    </div>
                </div>

                <!-- SEO Content Section -->
                <div class="seo-content mt-5">
                    <h2 class="h4">Online GST Calculator - Free Calculation Tool</h2>
                    <p>Our advanced GST Calculator helps you quickly determine the Goods and Services Tax amount for any product or service in India. Whether you need to calculate GST inclusive or exclusive prices, this tool provides instant results with complete breakdown including CGST and SGST components. The calculator supports all GST slabs (5%, 12%, 18%, and 28%) and is optimized for all devices including mobile phones and tablets.</p>
                    
                    <h3 class="h5 mt-4">How to Use the GST Calculator?</h3>
                    <ol>
                        <li>Select GST type: exclusive (add GST to base) or inclusive (extract GST from total)</li>
                        <li>Enter the amount in the first field</li>
                        <li>Choose a preset GST rate or input a custom rate</li>
                        <li>Click 'Calculate GST' to view detailed results with CGST/SGST breakdown</li>
                        <li>Optionally save or share your calculation results</li>
                    </ol>

                    <div itemscope itemtype="https://schema.org/FAQPage">
                        <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <h4 itemprop="name" class="h6 mt-4">What is GST Inclusive?</h4>
                            <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <p itemprop="text">GST Inclusive means the price already includes the tax amount. Use the inclusive option when you need to separate the GST amount from the total price. For example, if a product costs ₹118 (inclusive of 18% GST), the base price is ₹100 and the GST component is ₹18.</p>
                            </div>
                        </div>
                        <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <h4 itemprop="name" class="h6 mt-4">What is GST Exclusive?</h4>
                            <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <p itemprop="text">GST Exclusive means the price doesn't include tax. Use this option to calculate the total price after adding GST to the base amount. For example, if a product's base price is ₹100 with 18% GST, the total payable amount would be ₹118 (₹100 + ₹18 GST).</p>
                            </div>
                        </div>
                        <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <h4 itemprop="name" class="h6 mt-4">What are CGST and SGST?</h4>
                            <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <p itemprop="text">In India, GST is divided into two equal parts: CGST (Central Goods and Services Tax) and SGST (State Goods and Services Tax). Each component represents 50% of the total GST amount. For interstate transactions, IGST (Integrated Goods and Services Tax) is applicable instead.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Replace jQuery document ready with vanilla JS
document.addEventListener('DOMContentLoaded', function() {
    // History storage
    let calculationHistory = JSON.parse(localStorage.getItem('gstCalculationHistory')) || [];
    
    // Toggle between exclusive and inclusive
    const toggleOptions = document.querySelectorAll('.toggle-option');
    toggleOptions.forEach(option => {
        option.addEventListener('click', function() {
            toggleOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('type').value = this.dataset.type;
        });
    });
    
    // GST Rate Presets
    const gstPresets = document.querySelectorAll('.gst-preset');
    gstPresets.forEach(preset => {
        preset.addEventListener('click', function() {
            gstPresets.forEach(pre => pre.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('gstRate').value = this.dataset.rate;
        });
    });
    
    // Handle form submission
    document.getElementById('gstForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const amount = document.getElementById('amount').value;
        const gstRate = document.getElementById('gstRate').value;
        const type = document.getElementById('type').value;
        
        // Validation
        if (!amount || isNaN(amount) || amount <= 0) {
            alert('Please enter a valid amount');
            return;
        }
        
        // Calculate instead of AJAX request
        let netAmount, gstAmount, totalAmount;
        
        if (type === 'exclusive') {
            netAmount = parseFloat(amount);
            gstAmount = (netAmount * gstRate) / 100;
            totalAmount = netAmount + gstAmount;
        } else {
            totalAmount = parseFloat(amount);
            netAmount = (totalAmount * 100) / (100 + parseFloat(gstRate));
            gstAmount = totalAmount - netAmount;
        }
        
        // Format numbers
        const formatNumber = (num) => {
            return new Intl.NumberFormat('en-IN', { 
                minimumFractionDigits: 2, 
                maximumFractionDigits: 2 
            }).format(num);
        };
        
        const result = {
            net_amount: formatNumber(netAmount),
            gst_amount: formatNumber(gstAmount),
            total_amount: formatNumber(totalAmount),
            gst_rate: gstRate
        };
        
        // Update result display
        document.getElementById('netAmount').textContent = '₹' + result.net_amount;
        document.getElementById('gstAmount').textContent = '₹' + result.gst_amount;
        document.getElementById('totalAmount').textContent = '₹' + result.total_amount;
        document.getElementById('gstRateDisplay').textContent = 'at ' + gstRate + '%';
        
        // Calculate and display CGST and SGST (50% each)
        const halfGst = formatNumber(gstAmount / 2);
        document.getElementById('cgstAmount').textContent = '₹' + halfGst;
        document.getElementById('sgstAmount').textContent = '₹' + halfGst;
        
        // Show result with animation
        const resultSection = document.getElementById('resultSection');
        resultSection.style.display = 'block';
        setTimeout(() => {
            resultSection.classList.add('show');
        }, 10);
        
        // Save to history
        saveToHistory({
            amount: amount,
            gstRate: gstRate,
            type: type,
            netAmount: result.net_amount,
            gstAmount: result.gst_amount,
            totalAmount: result.total_amount,
            timestamp: new Date().toISOString()
        });
        
        // Generate comparison table
        generateComparisonTable(amount, type);
    });
    
    // Save calculation to history
    function saveToHistory(calculation) {
        // Add to beginning of array
        calculationHistory.unshift(calculation);
        
        // Keep only last 5 calculations
        if (calculationHistory.length > 5) {
            calculationHistory = calculationHistory.slice(0, 5);
        }
        
        // Save to local storage
        localStorage.setItem('gstCalculationHistory', JSON.stringify(calculationHistory));
        
        // Update history display
        updateHistoryDisplay();
    }
    
    // Update history display
    function updateHistoryDisplay() {
        const historyContainer = document.getElementById('historyContainer');
        
        if (calculationHistory.length === 0) {
            historyContainer.innerHTML = '<p class="text-center text-muted my-3">No recent calculations</p>';
            return;
        }
        
        let historyHtml = '';
        
        calculationHistory.forEach((item, index) => {
            const date = new Date(item.timestamp);
            const formattedDate = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
            
            historyHtml += `
                <div class="history-item p-3 mb-2 bg-white" data-index="${index}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">${formattedDate}</small>
                            <div class="mt-1">
                                <span class="fw-medium">₹${item.amount}</span>
                                <span class="text-muted small">(${item.type}, ${item.gstRate}%)</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">₹${item.totalAmount}</div>
                            <small class="text-muted">GST: ₹${item.gstAmount}</small>
                        </div>
                    </div>
                </div>
            `;
        });
        
        historyContainer.innerHTML = historyHtml;
        
        // Add click event to history items
        document.querySelectorAll('.history-item').forEach(item => {
            item.addEventListener('click', function() {
                const index = this.dataset.index;
                const calculation = calculationHistory[index];
                
                // Set form values
                document.getElementById('amount').value = calculation.amount;
                document.getElementById('gstRate').value = calculation.gstRate;
                
                // Set GST type
                toggleOptions.forEach(option => option.classList.remove('active'));
                document.querySelector(`.toggle-option[data-type="${calculation.type}"]`).classList.add('active');
                document.getElementById('type').value = calculation.type;
                
                // Submit form to recalculate
                const submitEvent = new Event('submit', {cancelable: true});
                document.getElementById('gstForm').dispatchEvent(submitEvent);
            });
        });
    }
    
    // Generate comparison table for different GST rates
    function generateComparisonTable(amount, type) {
        const gstRates = [5, 12, 18, 28];
        let tableHtml = '';
        
        gstRates.forEach(rate => {
            let netAmount, gstAmount, totalAmount;
            
            if (type === 'exclusive') {
                netAmount = parseFloat(amount);
                gstAmount = (netAmount * rate) / 100;
                totalAmount = netAmount + gstAmount;
            } else {
                totalAmount = parseFloat(amount);
                netAmount = (totalAmount * 100) / (100 + rate);
                gstAmount = totalAmount - netAmount;
            }
            
            tableHtml += `
                <tr>
                    <td>${rate}%</td>
                    <td>₹${netAmount.toFixed(2)}</td>
                    <td>₹${gstAmount.toFixed(2)}</td>
                    <td>₹${totalAmount.toFixed(2)}</td>
                </tr>
            `;
        });
        
        document.getElementById('comparisonTableBody').innerHTML = tableHtml;
    }
    
    // Share button functionality
    document.getElementById('shareBtn').addEventListener('click', function() {
        const netAmount = document.getElementById('netAmount').textContent;
        const gstAmount = document.getElementById('gstAmount').textContent;
        const totalAmount = document.getElementById('totalAmount').textContent;
        const gstRate = document.getElementById('gstRateDisplay').textContent.replace('at ', '');
        const type = document.querySelector('.toggle-option.active').dataset.type;
        
        const shareText = `GST Calculation (${type}):\nNet Amount: ${netAmount}\nGST ${gstRate}: ${gstAmount}\nTotal Amount: ${totalAmount}`;
        
        // Try to use Web Share API if available
        if (navigator.share) {
            navigator.share({
                title: 'GST Calculation',
                text: shareText
            }).catch(error => {
                console.log('Error sharing:', error);
                // Fallback: copy to clipboard
                copyToClipboard(shareText);
            });
        } else {
            // Fallback: copy to clipboard
            copyToClipboard(shareText);
        }
    });
    
    // Copy to clipboard helper function
    function copyToClipboard(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        
        alert('Result copied to clipboard!');
    }
    
    // Save button functionality
    document.getElementById('saveBtn').addEventListener('click', function() {
        const result = {
            netAmount: document.getElementById('netAmount').textContent,
            gstAmount: document.getElementById('gstAmount').textContent,
            totalAmount: document.getElementById('totalAmount').textContent,
            gstRate: document.getElementById('gstRateDisplay').textContent.replace('at ', ''),
            type: document.querySelector('.toggle-option.active').dataset.type,
            date: new Date().toLocaleDateString(),
            time: new Date().toLocaleTimeString()
        };
        
        // Create downloadable text file
        const content = `GST Calculation\n\nDate: ${result.date}\nTime: ${result.time}\n\nType: ${result.type === 'exclusive' ? 'GST Exclusive' : 'GST Inclusive'}\nGST Rate: ${result.gstRate}\n\nNet Amount: ${result.netAmount}\nGST Amount: ${result.gstAmount}\nTotal Amount: ${result.totalAmount}\n\nCGST (50%): ${document.getElementById('cgstAmount').textContent}\nSGST (50%): ${document.getElementById('sgstAmount').textContent}`;
        
        const blob = new Blob([content], {type: 'text/plain'});
        const url = URL.createObjectURL(blob);
        
        const a = document.createElement('a');
        a.href = url;
        a.download = `GST_Calculation_${new Date().toISOString().slice(0,10)}.txt`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });
    
    // Initialize history display
    updateHistoryDisplay();
    
    // Initialize GST Rate Preset
    document.querySelector('.gst-preset[data-rate="18"]').classList.add('active');
});
    </script>

    
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "GST Calculator",
  "url": "https://infinitytoolspace.com/tools/gst-calculator",
  "description": "Easily calculate GST for any product or service with our online GST calculator. Supports both inclusive and exclusive GST calculations.",
  "applicationCategory": "Utility",
  "operatingSystem": "All",
  "browserRequirements": "Modern browsers supported",
  "image": "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEh6XilB0y92f0_6fIvIaaV8YkMDkzjPdZtzq0gcAg60Hto6ws1Lx-kJVAEWfwXV4iIEHayYDs3FVl-jn6IGeh8weo6__QndOrxDk1Cz7qcW5TFWIg4XnwkgMIJyCCiKZlsJqlw923XrKCOEiovWxnfC1vgTstw2orPbTllvP8kOTHKdnN_uhyphenhyphennV3xjA218/s16000/GST%20Calculator%20Online.jpg"
}
</script>

</body>
</html>
<?php
include("../footer.php");
?>